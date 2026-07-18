<?php

$url = getenv('DB_URL');

if (!$url) {
    echo "No DB_URL set\n";
    exit(0);
}

$vars = [];

// Handle key=value format (Render internal URL)
if (strpos($url, 'host=') !== false) {
    preg_match_all("/(\w+)=['\"]?([^'\" ]+)['\"]?/", $url, $m);
    for ($i = 0; $i < count($m[1]); $i++) {
        $key = strtoupper($m[1][$i]);
        $val = $m[2][$i];
        $vars["DB_{$key}"] = $val;
    }
}
// Handle postgresql:// URL format
elseif (preg_match('#postgresql://([^:]+):([^@]+)@([^:]+):(\d+)/(.+)#', $url, $m)) {
    $vars['DB_USERNAME'] = $m[1];
    $vars['DB_PASSWORD'] = $m[2];
    $vars['DB_HOST'] = $m[3];
    $vars['DB_PORT'] = $m[4];
    $vars['DB_DATABASE'] = $m[5];
}

// Write to .env file
$envPath = __DIR__ . '/.env';
$env = file_exists($envPath) ? file_get_contents($envPath) : '';

foreach ($vars as $key => $val) {
    $line = "{$key}={$val}";
    if (preg_match("/^" . preg_quote($key) . "=.*$/m", $env)) {
        $env = preg_replace("/^" . preg_quote($key) . "=.*$/m", $line, $env);
    } else {
        $env .= "\n{$line}";
    }
}

file_put_contents($envPath, $env);
echo "Parsed DB_URL: host={$vars['DB_HOST']} port={$vars['DB_PORT']} db={$vars['DB_DATABASE']} user={$vars['DB_USERNAME']}\n";
