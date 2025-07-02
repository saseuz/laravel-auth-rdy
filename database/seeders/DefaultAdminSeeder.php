<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Saseuz\LaravelAuthRdy\Models\Admin;
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
            'email' => 'saseuz@gmail.com',
        ], [
            'name'  => 'Saseuz',
            'password' => '123123',
        ]);

        $admin->assignRole('super-admin');

        echo "Admin: " . $admin->name . " Created!\n";
    }
}
