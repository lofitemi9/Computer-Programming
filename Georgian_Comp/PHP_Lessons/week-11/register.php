<?php

require_once 'config.php';
require_once 'classes/Session.php';
require_once 'classes/Database.php';
require_once 'classes/User.php';
require_once 'templates/header.php';


// redirect a user if already logged in
if(Session::isLoggedIn()){
    header("Location: dashboard.php");
    exit();
}
$message = "";
$message_type = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // get our db connection
    $db_connection = Database::getInstance()->getConnection();
    // instantiate User class
    $user = new User($db_connection);

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $message = $user->register($username, $password, $confirm_password);
    // now check to see if out user was created

    if($message === "User Created"){
        $message_type = "success";
    } else {
        $message_type = "danger";
    }



}

?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Register</h3>
            </div>
            <div class="card-body">
                
                <?php if($message): ?>
                    <div class="alert alert-<?php echo $message_type; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <form action="register.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="login.php">Already have an account? Login</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>