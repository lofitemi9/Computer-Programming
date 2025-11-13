<?php
$base = '/Georgian_Comp/PHP_Lessons/CSS-PHP-Project';
$bodyClass = 'auth-page';
include __DIR__ . '/../inc/header.php';
?>

<!-- this is the login form -->
<section>
    <h1>Login</h1>
    <form class="form auth-form" method="post" action="#" novalidate>
        <label>Email
            <input type="email" name="email" required>
        </label>

        <label>Password
            <input type="password" name="password" required>
        </label>

        <button class="btn" type="submit">Sign In</button>
        <p class="muted" style="margin-top:8px;">No account? <a href="<?= $base ?>/templates/register.php">Register</a></p>
    </form>
</section>

<?php include __DIR__ . '/../inc/footer.php'; ?>