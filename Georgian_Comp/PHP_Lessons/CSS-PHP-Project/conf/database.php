<?php
// conf/database.php
// Tiny PDO helper so I don't repeat the same connect code everywhere.

function db(): PDO
{
    static $pdo = null;

    // reuse the same connection so we don't reconnect every single time
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    // pulling DB stuff from env.php so I can move this project around
    // without editing 10 different files (learned that the hard way)
    $env = require __DIR__ . '/env.php';

    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=%s',
        $env['DB_HOST'],
        $env['DB_PORT'],
        $env['DB_NAME'],
        $env['DB_CHARSET']
    );

    // basic PDO options – not super fancy but good enough for this assingment :)
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    // create the PDO instance
    $pdo = new PDO($dsn, $env['DB_USER'], $env['DB_PASS'], $options);
    return $pdo;
}
