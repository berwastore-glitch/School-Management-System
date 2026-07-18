<?php

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$db   = getenv('DB_DATABASE');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');

echo "Connecting: host={$host} port={$port} db={$db} user={$user}\n";

try {
    $pdo = new PDO("pgsql:host={$host};port={$port};dbname={$db}", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $count = (int)$pdo->query("SELECT count(*) FROM users")->fetchColumn();
    echo "Users in DB: {$count}\n";

    if ($count > 0) {
        echo "Seed already done.\n";
        exit(0);
    }

    $hash = password_hash('password', PASSWORD_BCRYPT);
    $now = date('Y-m-d H:i:s');

    // Create school
    $schoolId = null;
    try {
        $stmt = $pdo->prepare("INSERT INTO schools (name, slug, email, phone, address, is_active, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?) RETURNING id");
        $stmt->execute(['Kigali International School', 'kigali-international-school', 'info@kigali-school.com', '+250 788 123 456', 'Kigali, Rwanda', true, $now, $now]);
        $schoolId = $stmt->fetchColumn();
        echo "Created school ID: {$schoolId}\n";
    } catch (Exception $e) {
        echo "School insert error: " . $e->getMessage() . "\n";
        $schoolId = $pdo->query("SELECT id FROM schools LIMIT 1")->fetchColumn();
        echo "Using existing school ID: {$schoolId}\n";
    }

    // Create users one by one
    $users = [
        ['Super Admin', 'admin@schoolms.com', 'super_admin'],
        ['School Admin', 'school@schoolms.com', 'admin'],
        ['Test Student', 'student@test.com', 'student'],
        ['Test Teacher', 'teacher@test.com', 'teacher'],
    ];

    foreach ($users as [$name, $email, $role]) {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, email_verified_at, school_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $hash, $role, $now, $schoolId, $now, $now]);
            echo "OK: {$name} ({$email})\n";
        } catch (Exception $e) {
            echo "SKIP: {$email} - " . $e->getMessage() . "\n";
        }
    }

    $final = (int)$pdo->query("SELECT count(*) FROM users")->fetchColumn();
    echo "Total users now: {$final}\n";
    echo "DONE\n";

} catch (Exception $e) {
    echo "FATAL: " . $e->getMessage() . "\n";
    exit(1);
}
