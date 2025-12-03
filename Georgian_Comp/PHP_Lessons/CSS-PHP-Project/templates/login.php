<?php
// templates/login.php
// Admin login page for the backend. Nothing fancy, just email + password.

$base = '/~Temiloluwa200632787/CSS-PHP-Project';
$bodyClass = 'auth-page';

require_once __DIR__ . '/../conf/database.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// store errors + old email so I can re-fill the form if login fails
$errors = [];
$email  = '';

// If already logged in, send to admin dashboard immediately
if (!empty($_SESSION['admin_id'])) {
    header('Location: ' . $base . '/admin/products.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Email and password are required.';
    } else {
        try {
            $pdo = db();

            // Look up admin by email
            $stmt = $pdo->prepare('SELECT * FROM admins WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password'])) {
                // Login successful
                $_SESSION['admin_id']   = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];

                header('Location: ' . $base . '/admin/products.php');
                exit;
            }

            // no match → incorrect email or password
            $errors[] = 'Invalid email or password.';
        } catch (PDOException $e) {
            // probably DB connection issue or something unexpected
            $errors[] = 'Database error. Please try again later.';
        }
    }
}

include __DIR__ . '/../inc/header.php';
?>

<main class="site-main auth-layout">
    <section class="auth-card">
        <h1 class="page-title">Admin Login</h1>

        <?php if (isset($_GET['registered'])): ?>
            <p class="status-message status-success">
                Registration worked! You can log in now.
            </p>
        <?php endif; ?>

        <?php if ($errors): ?>
            <div class="form-errors">
                <!-- just dumping out any validation/login errors -->
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="form auth-form" method="post" novalidate>
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
                    required
                    autocomplete="current-password"
                >
            </label>

            <button class="button" type="submit">Sign In</button>

            <p class="form-note">
                No account?
                <a href="<?= $base ?>/templates/register.php">Register</a>
            </p>
        </form>
    </section>
</main>

<?php include __DIR__ . '/../inc/footer.php'; ?>
