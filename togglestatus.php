<?php
    require 'Includes/db.php';
    require 'Includes/functions.php';
    require 'Includes/sessions.php';

    if(isset($_GET['id']) && isset($_GET['status'])){
        $id = $_GET['id'];
        $status = $_GET['status'];
        if($status == 'publish'){
          $status = 'draft';
        }else{
          $status = 'publish';
        }
        $admin = $_SESSION['adminName'];
        $sql = "UPDATE post SET status='$status' WHERE id='$id'";
        $execute = mysqli_query($conn, $sql);
        echo $execute;
        if($execute){
            $_SESSION['SuccessMessage'] = "Status updated Successfully";
            Redirect_To($serverName."/posts?page=1");
        }else{
            $_SESSION['ErrorMessage'] = "Something went wrong. Try again...";
            Redirect_To($serverName."/posts?page=1");
        }
    }

?>