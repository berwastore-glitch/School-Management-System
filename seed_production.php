<?php

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$db   = getenv('DB_DATABASE');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');

try {
    $pdo = new PDO("pgsql:host={$host};port={$port};dbname={$db}", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $count = $pdo->query("SELECT count(*) FROM users")->fetchColumn();
    echo "Current users: {$count}\n";

    if ($count > 0) {
        echo "Users already exist. Skipping.\n";
        exit(0);
    }

    // Hash for 'password'
    $hash = password_hash('password', PASSWORD_BCRYPT);
    $now = date('Y-m-d H:i:s');

    // Create school
    $stmt = $pdo->prepare("INSERT INTO schools (name, slug, email, phone, address, is_active, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ON CONFLICT (slug) DO NOTHING RETURNING id");
    $stmt->execute(['Kigali International School', 'kigali-international-school', 'info@kigali-school.com', '+250 788 123 456', 'Kigali, Rwanda', true, $now, $now]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $schoolId = $row['id'];
    } else {
        $schoolId = $pdo->query("SELECT id FROM schools WHERE slug='kigali-international-school'")->fetchColumn();
    }
    echo "School ID: {$schoolId}\n";

    // Create users
    $users = [
        ['Super Admin', 'admin@schoolms.com', $hash, 'super_admin', '+1 (555) 000-0000', 'SchoolMS Headquarters'],
        ['School Admin', 'school@schoolms.com', $hash, 'admin', '+1 (555) 000-0001', 'Demo International School'],
        ['Test Student', 'student@test.com', $hash, 'student', null, null],
        ['Test Teacher', 'teacher@test.com', $hash, 'teacher', null, null],
    ];

    foreach ($users as $u) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, phone, school_name, email_verified_at, school_id, created_at, updated_at) SELECT ?, ?, ?, ?, ?, ?, ?, ?, ?, ? WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = ?)");
        $stmt->execute([$u[0], $u[1], $u[2], $u[3], $u[4], $u[5], $now, $schoolId, $now, $now, $u[1]]);
        echo "Created: {$u[0]} ({$u[1]})\n";
    }

    echo "Seeding complete!\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
