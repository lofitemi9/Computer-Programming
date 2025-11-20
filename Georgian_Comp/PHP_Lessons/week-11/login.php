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

$error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $db_connection = Database::getInstance()->getConnection();
    $user = new User($db_connection);
    $logged_in_user = $user->login($username, $password);

    if($logged_in_user){
        // Login successful, set the session variables
        Session::set('user_id', $logged_in_user['id']);
        Session::set('username', $logged_in_user['username']);
        // redirect the user to the dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}

?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Login</h3>
            </div>
            <div class="card-body">
                
                <?php  ?>
                    <div class="alert alert-danger">
                        <?php  ?>
                    </div>
                <?php  ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="register.php">Don't have an account? Register</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?> 