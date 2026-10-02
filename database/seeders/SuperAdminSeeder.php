<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@globalpark.ai'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin@123'),
                'email_verified_at' => now(),
                'is_super_admin' => true,
            ]
        );

        if (! $user->is_super_admin) {
            $user->is_super_admin = true;
            $user->save();
        }
    }
}
