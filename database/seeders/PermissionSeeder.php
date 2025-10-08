<?php

namespace Database\Seeders;

use App\Models\Backend\PermissionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionGroups = config('permissionGroups');

        foreach ($permissionGroups as $group) {
            $permissionGroup = PermissionGroup::firstOrCreate(
                ['name' => $group['name']],
                ['name' => $group['name']]
            );

            foreach ($group['permissions'] as $permissionName) {
                $permission = $permissionGroup->permissions()->firstOrCreate(
                    ['name' => $permissionName],
                    ['name' => $permissionName, 'guard_name' => 'admin']
                );

                echo "Permission: " . $permission->name . " Created in Group: " . $permissionGroup->name . "\n";
            }
        }
    }
}
