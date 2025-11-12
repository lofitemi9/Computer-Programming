<?php
if (!isset($base)) {
    $base = '/Georgian_Comp/PHP_Lessons/CSS-PHP-Project';
}
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header basics -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="teddybear ecomm store" />
    <title>TeddyBear | Luxury Bears</title>

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- site css -->
    <link rel="stylesheet" href="<?= $base ?>/css/styles.css" />
</head>

<body class="<?= isset($bodyClass) ? htmlspecialchars($bodyClass) : '' ?>">
    <!-- top navigation -->
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="<?= $base ?>/index.
      <!-- span for two diff colors -->
      php">Teddy<span>Bear</span></a>

            <nav class="nav" aria-label="Primary">
                <ul class="nav-list">
                    <li><a class="<?= $current === 'index.php' ? 'active' : '' ?>" href="<?= $base ?>/index.php">Home</a></li>
                    <li><a class="<?= $current === 'about.php' ? 'active' : '' ?>" href="<?= $base ?>/templates/about.php">About</a></li>
                    <li><a class="<?= $current === 'shop.php' ? 'active' : '' ?>" href="<?= $base ?>/templates/shop.php">Shop</a></li>
                    <li><a class="<?= $current === 'contact.php' ? 'active' : '' ?>" href="<?= $base ?>/templates/contact.php">Contact</a></li>
                    <li class="auth">
                        <a class="<?= $current === 'login.php' ? 'active' : '' ?>" href="<?= $base ?>/templates/login.php">Login</a>
                        <a class="btn" href="<?= $base ?>/templates/register.php">Sign Up</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- main wrapper starts here -->
    <main class="site-main container">