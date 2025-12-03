<?php
// templates/register.php
// Admin registration page. Only used to create backend users (not store customers).

$base = '/~Temiloluwa200632787/CSS-PHP-Project';
$bodyClass = 'auth-page';

require_once __DIR__ . '/../conf/database.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// basic state for the form – keeps old values if something goes wrong
$errors = [];
$name   = '';
$email  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['full_name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic validation – nothing too fancy but enough for this project
    if ($name === '') {
        $errors[] = 'Full name is required.';
    }

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email is required.';
    }

    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }

    if (!$errors) {
        try {
            $pdo = db();

            // Check for duplicate email (can't have two admins with the same email)
            $stmt = $pdo->prepare('SELECT id FROM admins WHERE email = :email');
            $stmt->execute(['email' => $email]);

            if ($stmt->fetch()) {
                $errors[] = 'That email is already registered.';
            } else {

                // hash the password so we're not saving plain text (that would be bad lol)
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $insert = $pdo->prepare(
                    'INSERT INTO admins (name, email, password)
                     VALUES (:name, :email, :password)'
                );
                $insert->execute([
                    'name'     => $name,
                    'email'    => $email,
                    'password' => $hash,
                ]);

                // Redirect to login with success flag
                header('Location: ' . $base . '/templates/login.php?registered=1');
                exit;
            }
        } catch (PDOException $e) {
            // probably a DB connection issue or something unexpected
            $errors[] = 'Database error. Please try again later.';
        }
    }
}

include __DIR__ . '/../inc/header.php';
?>

<main class="site-main auth-layout">
    <section class="auth-card">
        <h1 class="page-title">Create Admin Account</h1>

        <?php if ($errors): ?>
            <div class="form-errors">
                <!-- show any validation errors from the form -->
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="form auth-form" method="post" novalidate>
            <label>
                Full Name
                <input
                    type="text"
                    name="full_name"
                    required
                    value="<?= htmlspecialchars($name) ?>"
                    autocomplete="name"
                >
            </label>

            <label>
                Email
                <input
                    type="email"
                    name="email"
                    required
                    value="<?= htmlspecialchars($email) ?>"
                    autocomplete="email"
                >
            </label>

            <label>
                Password
                <input
                    type="password"
                    name="password"
                    minlength="8"
                    required
                    autocomplete="new-password"
                >
            </label>

            <button class="button" type="submit">Create Account</button>
        </form>
    </section>
</main>

<?php include __DIR__ . '/../inc/footer.php'; ?>
