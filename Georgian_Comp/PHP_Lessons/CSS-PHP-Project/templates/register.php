<?php
$base = '/Georgian_Comp/PHP_Lessons/CSS-PHP-Project';
$bodyClass = 'auth-page';
include __DIR__ . '/../inc/header.php';
?>

<!-- this is the register form  -->
<section>
    <h1>Create Account</h1>
    <form class="form auth-form" method="post" action="#" novalidate>
        <label>Full Name
            <input type="text" name="full_name" required>
        </label>

        <label>Email
            <input type="email" name="email" required>
        </label>

        <label>Password
            <input type="password" name="password" minlength="8" required>
        </label>

        <button class="btn" type="submit">Create Account</button>
    </form>
</section>

<?php include __DIR__ . '/../inc/footer.php'; ?>