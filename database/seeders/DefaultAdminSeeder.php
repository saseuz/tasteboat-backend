<?php

namespace Database\Seeders;

use App\Models\Backend\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'super-admin',
        ],[
            'name' => 'super-admin',
            'guard_name' => 'admin',
        ]);

        $admin = Admin::firstOrCreate([
            'email' => 'superadmin@example.com',
        ], [
            'name'  => 'Super Admin',
            'password' => '123123',
        ]);

        $admin->assignRole('super-admin');

        echo "Admin: " . $admin->name . " Created!\n";
    }
}