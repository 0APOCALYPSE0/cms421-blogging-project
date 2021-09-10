<?php
    require 'Includes/db.php';
    require 'Includes/functions.php';
    require 'Includes/sessions.php';
    
    if(isset($_GET['id'])){
        $searchQryParam = $_GET['id'];
        $admin = $_SESSION['adminName'];
        $sql = "UPDATE comments SET status='OFF', approvedby='$admin' WHERE id='$searchQryParam'";
        $execute = mysqli_query($conn, $sql);
        echo $execute;
        if($execute){
            $_SESSION['SuccessMessage'] = "Comment Dis-Approved Successfully";
            Redirect_To("comments.php");
        }else{
            $_SESSION['ErrorMessage'] = "Something went wrong. Try again...";
            Redirect_To("comments.php");
        }
    }

?>