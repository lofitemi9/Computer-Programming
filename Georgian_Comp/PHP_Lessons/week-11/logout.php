<?php

require_once 'classes/Session.php';
Session::start();
Session::destroy();

header("Location: login.php");
exit();

?>