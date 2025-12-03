<?php
// inc/header.php
// Shared header + main navigation.
// I use this on pretty much every page so if this file breaks, everything dies lol.

if (!isset($base)) {
    // fallback base path – try to keep this the same everywhere or stuff will 404
    $base = '/~Temiloluwa200632787/CSS-PHP-Project';
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/auth.php';

// figure out which page we are on so I can highlight the active nav link
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- basic meta -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="TeddyBear – a small cozy teddy store I made for my project." />
    <title>TeddyBear | Luxury Bears</title>

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- site css -->
    <link rel="stylesheet" href="<?= $base ?>/css/styles.css" />
</head>
<body class="<?= isset($bodyClass) ? htmlspecialchars($bodyClass) : '' ?>">

<header class="site-header">
    <div class="container header-inner">
        <!-- main site header with logo + nav -->
        <a class="site-brand" href="<?= $base ?>/index.php">
            Teddy<span>Bear</span>
        </a>

        <!-- primary navigation -->
        <nav class="main-nav" aria-label="Primary navigation">
            <ul class="nav-list">

                <li>
                    <a class="<?= $current === 'index.php' ? 'is-active' : '' ?>" href="<?= $base ?>/index.php">
                        Home
                    </a>
                </li>

                <li>
                    <a class="<?= $current === 'about.php' ? 'is-active' : '' ?>" href="<?= $base ?>/templates/about.php">
                        About
                    </a>
                </li>

                <li>
                    <a class="<?= $current === 'shop.php' ? 'is-active' : '' ?>" href="<?= $base ?>/templates/shop.php">
                        Shop
                    </a>
                </li>

                <li>
                    <a class="<?= $current === 'contact.php' ? 'is-active' : '' ?>" href="<?= $base ?>/templates/contact.php">
                        Contact
                    </a>
                </li>

                <!-- auth / admin section in nav -->
                <?php if (is_admin_logged_in()): ?>
                    <li class="nav-auth">
                        <a class="<?= $current === 'products.php' ? 'is-active' : '' ?>" href="<?= $base ?>/admin/products.php">
                            Admin
                        </a>
                        <a class="button button-small" href="<?= $base ?>/logout.php">
                            Logout
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-auth">
                        <a class="<?= $current === 'login.php' ? 'is-active' : '' ?>" href="<?= $base ?>/templates/login.php">
                            Login
                        </a>
                        <a class="button button-small" href="<?= $base ?>/templates/register.php">
                            Sign Up
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>
    </div>
</header>
