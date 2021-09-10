<?php
    require 'Includes/db.php';
    require 'Includes/functions.php';
    require 'Includes/sessions.php';

    $_SESSION['userID'] = null;
    $_SESSION['username'] = null;
    $_SESSION['adminName'] = null;
    // unset($_SESSION['userID']);
    // unset($_SESSION['username']);
    // unset($_SESSION['adminName']);
    // session_destroy();
    // $_SESSION["SuccessMessage"] = "You are logged out successfully.";
    Redirect_To("index.php");

?>