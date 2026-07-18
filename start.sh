#!/bin/sh

cd /var/www/html

cp -n .env.example .env 2>/dev/null || true

php artisan key:generate --force 2>&1 || true
php artisan config:clear 2>&1
php artisan config:cache 2>&1
php artisan route:cache 2>&1
php artisan view:cache 2>&1
php artisan migrate --force 2>&1
php artisan storage:link 2>&1 || true

# Seed via artisan tinker - guaranteed to work
php artisan tinker --execute="
\App\Models\User::firstOrCreate(
    ['email' => 'admin@schoolms.com'],
    ['name' => 'Super Admin', 'password' => bcrypt('password'), 'role' => 'super_admin', 'email_verified_at' => now()]
);
\$adminSchool = \App\Models\School::firstOrCreate(
    ['slug' => 'kigali-international-school'],
    ['name' => 'Kigali International School', 'email' => 'info@kigali-school.com', 'phone' => '+250788123456', 'address' => 'Kigali, Rwanda', 'is_active' => true]
);
if (\$admin = \App\Models\User::where('email','admin@schoolms.com')->first()) {
    \$admin->update(['school_id' => \$adminSchool->id]);
}
echo 'SEED_OK: ' . \App\Models\User::count() . ' users exist';
" 2>&1

exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
