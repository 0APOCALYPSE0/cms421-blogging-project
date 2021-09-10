<?php
    require 'Includes/db.php';
    require 'Includes/functions.php';
    require 'Includes/sessions.php';
    
    if(isset($_GET['id'])){
        $searchQryParam = $_GET['id'];
        $admin = $_SESSION['adminName'];
        $sql = "DELETE FROM comments WHERE id='$searchQryParam'";
        $execute = mysqli_query($conn, $sql);
        echo $execute;
        if($execute){
            $_SESSION['SuccessMessage'] = "Comment Deleted Successfully";
            Redirect_To("comments.php");
        }else{
            $_SESSION['ErrorMessage'] = "Something went wrong. Try again...";
            Redirect_To("comments.php");
        }
    }

?>