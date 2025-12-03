<?php
// inc/auth.php
// Little auth helpers so I don't keep copy/pasting the same checks everywhere.

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

/**
 * Simple guard: only let logged-in admins see admin pages.
 * If nobody is logged in, just kick them back to the login page.
 */
function require_admin(): void
{
    if (empty($_SESSION['admin_id'])) {
        // base path for redirects – if this is wrong stuff will def break :)
        $base = '/~Temiloluwa200632787/CSS-PHP-Project';
        header('Location: ' . $base . '/templates/login.php');
        exit;
    }
}

/**
 * Tiny helper so I can quickly ask "is someone logged in or not?"
 */
function is_admin_logged_in(): bool
{
    return !empty($_SESSION['admin_id']);
}
