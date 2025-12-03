<?php
// logout.php
// Just clears the admin session and sends them back to the login page.
// (Pretty basic but it works, so I'm not overthinking it lol)

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start(); // making sure session exists before blowing it up
}

// wipe everything
session_unset();
session_destroy();

// redirect them out
$base = '/~Temiloluwa200632787/CSS-PHP-Project';
header('Location: ' . $base . '/templates/login.php');
exit;
