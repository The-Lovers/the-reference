<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\PhoneCodeRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\AdminActivityNotifier;

class UserController extends Controller
{
    protected $roleRepository;
    protected $phoneCodeRepository;
    protected $userRepository;

    public function __construct(
        RoleRepository $roleRepository,
        PhoneCodeRepository $phoneCodeRepository,
        UserRepository $userRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->phoneCodeRepository = $phoneCodeRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Colonnes pour la table générique
     */

    /**
     * Affichage de la liste avec filtres et pagination
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $fields = ['name', 'surname', 'email', 'phone', 'code'];
        $users = $this->userRepository->getAllWithSearch(
            $request->search,
            $fields,
            10
        );
        // $users = $this->userRepository->getAll();
        $users->getCollection()->load('roles');

        if ($request->ajax()) {
            $users->getCollection()->transform(function (User $listedUser) {
                $listedUser->can_edit = Auth::user()->can('update', $listedUser);
                $listedUser->can_delete = Auth::user()->can('delete', $listedUser);
                $listedUser->show_url = route('users.show', $listedUser);
                $listedUser->edit_url = route('users.edit', $listedUser);
                $listedUser->full_phone = $listedUser->full_phone;

                return $listedUser;
            });

            return response()->json($users);
        }
        return view('admin.users.index', compact('users'));
    }

    /**
     * Affichage du formulaire de création
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $roles = $this->availableRolesFor(Auth::user());
        $phoneCodes = $this->loadPhoneCodes();

        return view('admin.users.create', compact('roles', 'phoneCodes'));
    }

    /**
     * Stockage d'un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'gender' => ['required', 'in:M,F'],
            'role' => ['required', 'exists:roles,id'],
            'code' => ['required', 'string'],
            'phone' => ['required', 'string'],
        ]);

        try {
            $this->ensureRoleAssignable((int) $validated['role']);

            $password = Str::random(8);

            DB::transaction(function () use ($validated, $password, &$user) {
                $user = User::create([
                    'name' => $validated['name'],
                    'surname' => $validated['surname'],
                    'username' => $validated['username'],
                    'email' => $validated['email'],
                    'gender' => $validated['gender'],
                    'code' => $validated['code'],
                    'phone' => $validated['phone'],
                    'password' => Hash::make($password),
                ]);

                $user->roles()->attach($validated['role']);
                Mail::to($user->email)->send(new UserCreate($user, $password));
            });

            app(AdminActivityNotifier::class)->notify(Auth::user(), 'created', 'utilisateur', $user);

            return redirect()->route('users.index')
                ->with('success', __('infos.user.creation-success'));
        } catch (\Throwable $e) {
            Log::error(__('infos.user.creation-error-log') . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', __('infos.user.creation-error'));
        }
    }

    /**
     * Affichage d'un utilisateur
     */
    public function show($locale, User $user)
    {
        $this->authorize('view', $user);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Formulaire d'édition
     */
    public function edit($locale, User $user)
    {
        $this->authorize('update', $user);

        $roles = $this->availableRolesFor(Auth::user());
        $phoneCodes = $this->loadPhoneCodes();
        ['selectedCode' => $selectedCode, 'phoneNumber' => $phoneNumber] = $this->extractPhoneData($user);

        return view('admin.users.edit', compact('user', 'roles', 'phoneCodes', 'selectedCode', 'phoneNumber'));
    }

    /**
     * Mise à jour de l'utilisateur
     */
    public function update($locale, Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'gender' => ['required', 'in:M,F'],
            'role' => ['required', 'exists:roles,id'],
            'phone' => ['required', 'string'],
            'code' => ['required', 'string'],
        ]);

        try {
            $this->ensureRoleAssignable((int) $validated['role']);

            $user->update([
                'name' => $validated['name'],
                'surname' => $validated['surname'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'gender' => $validated['gender'],
                'code' => $validated['code'],
                'phone' => $validated['phone'],
            ]);

            $user->roles()->sync([$validated['role']]);

            app(AdminActivityNotifier::class)->notify(Auth::user(), 'updated', 'utilisateur', $user);

            return redirect()->route('users.index')
                ->with('success', __('infos.user.edition-success'));
        } catch (\Throwable $e) {
            Log::error(__('infos.user.edition-error-log') . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', __('infos.user.edition-error'));
        }
    }

    /**
     * Suppression de l'utilisateur
     */
    public function destroy($locale, User $user)
    {
        $this->authorize('delete', $user);

        try {
            app(AdminActivityNotifier::class)->notify(Auth::user(), 'deleted', 'utilisateur', $user);

            $user->roles()->detach();
            $user->delete();
            return redirect()->route('users.index')
                ->with('success', __('infos.user.deletion-success'));
        } catch (\Throwable $e) {
            Log::error(__('infos.user.deletion-error-log') . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', __('infos.user.deletion-error'));
        }
    }

    /**
     * Charger les codes téléphoniques depuis la DB ou JSON
     */
    private function loadPhoneCodes(): array {
        $phoneCodes = [];

        try {
            // On suppose que PhoneCodeRepository récupère la table countries
            $countries = $this->phoneCodeRepository->getAll();

            foreach ($countries as $country) {
                $phone_code = $country->phone_code ?? null;
                $code = $country->code ?? null;
                $flag = $country->flag ?? null; // champ flag dans la table countries
                $label_fr = $country->label_fr ?? '';
                $label_en = $country->label_en ?? '';

                if ($phone_code) {
                    // Chaque entrée contient 'label', 'code' et 'flag'
                    $phoneCodes[] = [
                        'phone_code' => $phone_code,
                        'code' => $code,
                        'label_fr' => $label_fr,
                        'label_en' => $label_en,
                        'flag' => $flag,
                    ];
                }
            }

        } catch (\Throwable $e) {
            // fallback JSON si table absente
            $path = base_path('database/data/countries_195_un.json');
            if (file_exists($path)) {
                $json = json_decode(file_get_contents($path), true);
                if (is_array($json)) {
                    foreach ($json as $country) {
                        if (!empty($country['phone_code'])) {
                            $phoneCodes[] = [
                                'phone_code' => $country['phone_code'],
                                'code' => $country['phone'],
                                'label_fr' => $country['label_fr'],
                                'label_en' => $country['label_en'],
                                'flag' => $country['flag'] ?? null,
                            ];
                        }
                    }
                }
            }
        }

        return $phoneCodes;
    }

    private function availableRolesFor(User $actor)
    {
        $roles = $this->roleRepository->getAll();

        if ($actor->hasRole('super-admin')) {
            return $roles;
        }

        return $roles->reject(fn ($role) => $role->name === 'super-admin')->values();
    }

    private function ensureRoleAssignable(int $roleId): void
    {
        $actor = Auth::user();
        $role = $this->roleRepository->getById($roleId);

        abort_unless($role, 404);

        if (!$actor->hasRole('super-admin') && $role->name === 'super-admin') {
            abort(403);
        }
    }

    public function show_profile($locale, User $user)
    {
        $this->ensureProfileOwner($user);

        return view('admin.users.profile.show', compact('user'));
    }

    public function edit_profile($locale, User $user)
    {
        $this->ensureProfileOwner($user);

        $phoneCodes = $this->loadPhoneCodes();
        ['selectedCode' => $selectedCode, 'phoneNumber' => $phoneNumber] = $this->extractPhoneData($user);

        return view('admin.users.profile.edit', compact('user', 'phoneCodes', 'selectedCode', 'phoneNumber'));
    }

    public function update_profile($locale, Request $request, User $user)
    {
        $this->ensureProfileOwner($user);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'gender' => ['required', 'in:M,F'],
            'phone' => ['required', 'string'],
            'code' => ['required', 'string'],
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ]);

        try {
            $data = [
                'name' => $validated['name'],
                'surname' => $validated['surname'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'gender' => $validated['gender'],
                'code' => $validated['code'],
                'phone' => $validated['phone'],
            ];

            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }

                $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            $user->update($data);

            app(AdminActivityNotifier::class)->notify($user, 'profile_updated', 'profil', $user, [
                'self_only' => true,
            ]);

            return redirect()->route('profile.show', $user)
                ->with('success', __('infos.user.edition-success'));
        } catch (\Throwable $e) {
            Log::error(__('infos.user.edition-error-log') . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', __('infos.user.edition-error'));
        }
    }

    private function ensureProfileOwner(User $user): void
    {
        abort_unless(Auth::id() === $user->id, 403);
    }

    private function extractPhoneData(User $user): array
    {
        if (!empty($user->code)) {
            return [
                'selectedCode' => $user->code,
                'phoneNumber' => $user->phone ?? '',
            ];
        }

        $phone = $user->phone ?? '';
        $firstSpace = strpos($phone, ' ');

        if ($firstSpace === false) {
            return [
                'selectedCode' => '',
                'phoneNumber' => $phone,
            ];
        }

        return [
            'selectedCode' => substr($phone, 0, $firstSpace),
            'phoneNumber' => substr($phone, $firstSpace + 1),
        ];
    }
}
