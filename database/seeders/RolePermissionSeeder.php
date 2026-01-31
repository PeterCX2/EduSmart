<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'view schools'],
            ['name' => 'create schools'],
            ['name' => 'edit schools'],
            ['name' => 'delete schools'],

            ['name' => 'view users'],
            ['name' => 'create users'],
            ['name' => 'edit users'],
            ['name' => 'delete users'],
            
            ['name' => 'view subjects'],
            ['name' => 'create subjects'],
            ['name' => 'edit subjects'],
            ['name' => 'delete subjects'],
            
            ['name' => 'view assignments'],
            ['name' => 'create assignments'],
            ['name' => 'edit assignments'],
            ['name' => 'delete assignments'],

            ['name' => 'view submissions'],
            ['name' => 'create submissions'],
            ['name' => 'grade submissions'],
            ['name' => 'delete submissions'],

            ['name' => 'view submission_feedback'],
            ['name' => 'create submission_feedback'],
            ['name' => 'delete submission_feedback'],

            ['name' => 'view roles'],
            ['name' => 'create roles'],
            ['name' => 'edit roles'],
            ['name' => 'delete roles'],
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission['name'],
                'guard_name' => 'web'
            ]);
        }

        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher', 'guard_name' => 'web']);
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        
        $superAdminRole->syncPermissions(Permission::all());

        $teacherPermissions = Permission::whereIn('name', [
            'view schools',
            'view subjects', 'create subjects', 'edit subjects', 'delete subjects',
            'view assignments', 'create assignments', 'edit assignments', 'delete assignments',
            'view submissions', 'grade submissions', 'delete submissions',
            'view submission_feedback', 'create submission_feedback', 'delete submission_feedback',
        ])->get();

        $teacherRole->syncPermissions($teacherPermissions);

        $studentPermissions = Permission::whereIn('name', [
            'view subjects',
            'view assignments',
            'view submissions', 'create submissions', 'delete submissions',
            'view submission_feedback'
        ])->get();

        $studentRole->syncPermissions($studentPermissions);

        \App\Models\User::firstOrCreate([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('superadmin123'),
        ])->assignRole('super-admin');
    }
}
