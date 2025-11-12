<?php
function db(): PDO
{
    static $pdo = null;
    if ($pdo) return $pdo;

    // Load environment configuration
    $env = require __DIR__ . '/env.php';

    // Build DSN string
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=%s',
        $env['DB_HOST'],
        $env['DB_PORT'],
        $env['DB_NAME'],
        $env['DB_CHARSET']
    );

    // Set PDO options
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    // Create and return PDO instance
    return $pdo = new PDO($dsn, $env['DB_USER'], $env['DB_PASS'], $options);
}
