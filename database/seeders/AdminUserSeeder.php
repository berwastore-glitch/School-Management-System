<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $school = School::create([
            'name' => 'Kigali International School',
            'slug' => Str::slug('Kigali International School'),
            'email' => 'info@kigali-school.com',
            'phone' => '+250 788 123 456',
            'address' => 'Kigali, Rwanda',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@schoolms.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'phone' => '+1 (555) 000-0000',
            'school_name' => 'SchoolMS Headquarters',
            'email_verified_at' => $now,
            'school_id' => $school->id,
        ]);

        User::create([
            'name' => 'School Admin',
            'email' => 'school@schoolms.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+1 (555) 000-0001',
            'school_name' => 'Demo International School',
            'email_verified_at' => $now,
            'school_id' => $school->id,
        ]);

        User::create([
            'name' => 'Test Student',
            'email' => 'student@test.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'email_verified_at' => $now,
            'school_id' => $school->id,
        ]);

        User::create([
            'name' => 'Test Teacher',
            'email' => 'teacher@test.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'email_verified_at' => $now,
            'school_id' => $school->id,
        ]);
    }
}
