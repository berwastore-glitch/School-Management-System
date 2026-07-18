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

        $school = School::firstOrCreate(
            ['slug' => Str::slug('Kigali International School')],
            [
                'name' => 'Kigali International School',
                'email' => 'info@kigali-school.com',
                'phone' => '+250 788 123 456',
                'address' => 'Kigali, Rwanda',
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@schoolms.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'phone' => '+1 (555) 000-0000',
                'school_name' => 'SchoolMS Headquarters',
                'email_verified_at' => $now,
                'school_id' => $school->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'school@schoolms.com'],
            [
                'name' => 'School Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+1 (555) 000-0001',
                'school_name' => 'Demo International School',
                'email_verified_at' => $now,
                'school_id' => $school->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'student@test.com'],
            [
                'name' => 'Test Student',
                'password' => Hash::make('password'),
                'role' => 'student',
                'email_verified_at' => $now,
                'school_id' => $school->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'teacher@test.com'],
            [
                'name' => 'Test Teacher',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'email_verified_at' => $now,
                'school_id' => $school->id,
            ]
        );
    }
}
