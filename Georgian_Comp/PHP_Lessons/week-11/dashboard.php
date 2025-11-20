<?php

require_once 'classes/Session.php';
require_once 'templates/header.php';

// this is our first line of defence for a user login function
if(!Session::isLoggedIn()){
    header("Location: login.php");
    exit();
}

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3>Dashboard</h3>
            </div>
            <div class="card-body">
                <h5 class="card-title">Welcome, <?php echo htmlspecialchars(Session::get('username')); ?>!</h5>
                <p class="card-text">You have successfully logged in to the protected area.</p>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>