<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::where('name', 'super-admin')->first();
        $adminRole = Role::where('name', 'admin')->first();

        if (!$superAdminRole || !$adminRole) {
            $this->command->error('Les rôles "super-admin" ou "admin" n’existent pas. Exécutez le RoleSeeder d’abord.');
            return;
        }

        // Liste des utilisateurs à créer
        $users = [
            [
                'name' => 'DJIOGAP',
                'surname' => 'Hermann',
                'username' => 'Jango',
                'email' => 'djiogaphermann@yahoo.fr',
                'password' => 'password123',
                'phone' => '+237651251425',
                'gender' => 'M',
                'role' => $superAdminRole
            ],
            [
                'name' => 'JIODA',
                'surname' => 'Adolphe',
                'username' => 'Dj Naf',
                'email' => 'jiodaadolphe@gmail.com',
                'password' => 'password123',
                'phone' => '+237653476952',
                'gender' => 'M',
                'role' => $superAdminRole
            ],
            [
                'name' => 'SEGAIN',
                'surname' => 'Alex',
                'username' => 'Skaf',
                'email' => 'kanyoualex@gmail.com',
                'password' => 'password123',
                'phone' => '+237681181820',
                'gender' => 'M',
                'role' => $adminRole
            ],
            [
                'name' => 'LEKEUFACK',
                'surname' => 'Ricardo',
                'username' => 'Brigueur',
                'email' => 'sonfackricardo03@gmail.com',
                'password' => 'password123',
                'phone' => '+79808468897',
                'gender' => 'M',
                'role' => $adminRole
            ],
        ];

        foreach ($users as $u) {
            // Créer ou récupérer l'utilisateur
            $user = User::firstOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'surname' => $u['surname'],
                    'username' => $u['username'],
                    'phone' => $u['phone'],
                    'gender' => $u['gender'],
                    'password' => Hash::make($u['password']),
                ]
            );

            // Attacher le rôle si pas déjà attaché
            if (!$user->roles->contains($u['role']->id)) {
                $user->roles()->attach($u['role']->id);
                $this->command->info("Rôle '{$u['role']->name}' assigné à {$user->email}.");
            } else {
                $this->command->info("L’utilisateur {$user->email} a déjà ce rôle.");
            }
        }

    }
}
