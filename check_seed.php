<?php

$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '5432';
$db   = getenv('DB_DATABASE') ?: 'laravel';
$user = getenv('DB_USERNAME') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';

try {
    $pdo = new PDO("pgsql:host={$host};port={$port};dbname={$db}", $user, $pass);
    $count = (int) $pdo->query("SELECT count(*) FROM users")->fetchColumn();
    if ($count === 0) {
        echo "No users found. Running seeder...\n";
        $pdo->exec("ALTER TABLE users DISABLE TRIGGER ALL");
        // Use artisan to seed
        exec('php artisan db:seed --force 2>&1', $output, $exitCode);
        echo implode("\n", $output) . "\n";
    } else {
        echo "Users exist ({$count}). Skipping seed.\n";
    }
} catch (Exception $e) {
    echo "DB check failed: " . $e->getMessage() . "\n";
}
