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
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreate;

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
    private function columns(): array
    {
        return [
            ['label' => 'Nom', 'field' => 'name', 'sortable' => true],
            ['label' => 'Prénom', 'field' => 'surname', 'sortable' => true],
            ['label' => 'Email', 'field' => 'email', 'sortable' => true],
            ['label' => 'Téléphone', 'field' => 'phone'],
            ['label' => 'Genre', 'field' => 'gender'],
        ];
    }

    /**
     * Affichage de la liste avec filtres et pagination
     */
    public function index()
    {
        $users = $this->userRepository->getAll();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Affichage du formulaire de création
     */
    public function create()
    {
        $roles = $this->roleRepository->getAll();
        $phoneCodes = $this->loadPhoneCodes();

        return view('admin.users.create', compact('roles', 'phoneCodes'));
    }

    /**
     * Stockage d'un nouvel utilisateur
     */
    public function store(Request $request)
    {
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

        // Combiner code et téléphone
        $validated['phone'] = $validated['code'] . ' ' . $validated['phone'];
        $password = Password::generate(8, true, true, true);

        $user = User::create([
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'password' => Hash::make($password),
        ]);

        $user->roles()->attach($validated['role']);
        Mail::to($user->email)->send(
            new UserCreate($user, $password)
        );
        return redirect()->route('users.index')
            ->with('success', __('dashboard.user.created'));
    }

    /**
     * Affichage d'un utilisateur
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Formulaire d'édition
     */
    public function edit(User $user)
    {
        $roles = $this->roleRepository->getAll();
        $phoneCodes = $this->loadPhoneCodes();

        return view('admin.users.edit', compact('user', 'roles', 'phoneCodes'));
    }

    /**
     * Mise à jour de l'utilisateur
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'gender' => ['required', 'in:M,F'],
            'role' => ['required', 'exists:roles,id'],
            'phone' => ['required', 'string'],
        ]);

        $user->update($validated);

        $user->roles()->sync([$validated['role']]);

        return redirect()->route('users.index')
            ->with('success', __('dashboard.user.updated'));
    }

    /**
     * Suppression de l'utilisateur
     */
    public function destroy(User $user)
    {
        // $user->roles()->detach();
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', __('dashboard.user.deleted'));
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
}
