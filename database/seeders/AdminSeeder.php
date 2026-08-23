<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserStatus;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->where('guard_name', 'api')->firstOrFail();

        $admins = [
            [
                'name' => 'Admin One',
                'email' => 'admin1@example.com',
                'phone' => '01000000001',
            ],
            [
                'name' => 'Admin Two',
                'email' => 'admin2@example.com',
                'phone' => '01000000002',
            ],
            [
                'name' => 'Admin Three',
                'email' => 'admin3@example.com',
                'phone' => '01000000003',
            ],
        ];

        foreach ($admins as $adminData) {
            $admin = User::updateOrCreate(
                ['email' => $adminData['email']],
                [
                    'name' => $adminData['name'],
                    'phone' => $adminData['phone'],
                    'password' => 'Admin@123456',
                    'status' => UserStatus::ACTIVE,
                    'has_password' => true,
                    'email_verified_at' => now(),
                ]
            );

            $admin->assignRole($adminRole);
        }
    }
}
