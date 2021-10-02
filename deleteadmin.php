<?php
    require 'Includes/db.php';
    require 'Includes/functions.php';
    require 'Includes/sessions.php';

    if(isset($_GET['id'])){
        $searchQryParam = $_GET['id'];
        $admin = $_SESSION['adminName'];
        $sql = "DELETE FROM admins WHERE id='$searchQryParam'";
        $execute = mysqli_query($conn, $sql);
        echo $execute;
        if($execute){
            $_SESSION['SuccessMessage'] = "Admin Deleted Successfully";
            Redirect_To($serverName."/admin?page=1");
        }else{
            $_SESSION['ErrorMessage'] = "Something went wrong. Try again...";
            Redirect_To($serverName."/admin?page=1");
        }
    }

?>