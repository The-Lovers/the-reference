<?php

namespace App\Actions\Fortify;

use App\Mail\UserCreate;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'gender' => ['required|string'],
            'code' => ['required|string'],
            'phone' => ['required|string'],
            'role' => ['required|string'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'username' => [
                'required',
                'string',
                'string',
                'max:255',
                Rule::unique(User::class),
            ],
        ])->validate();
        // $password = Str::random(10);
        $password = Password::generate(8, true, true, true);
        return User::create([
            'name' => $input['name'],
            'surname' => $input['surname'],
            'username' => $input['username'],
            'email' => $input['email'],
            'gender' => $input['gender'],
            'phone' => $input['code'].$input['phone'],
            'password' => Hash::make($password),
        ]);

        Mail::to($user->email)->send(
            new UserCreate($user, $password)
        );
    }
}
