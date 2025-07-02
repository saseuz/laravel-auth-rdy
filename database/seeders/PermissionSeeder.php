<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Saseuz\LaravelAuthRdy\Models\PermissionGroup;

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
