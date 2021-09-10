<?php
    require 'Includes/db.php';
    require 'Includes/functions.php';
    require 'Includes/sessions.php';
    
    if(isset($_GET['id'])){
        $searchQryParam = $_GET['id'];
        $admin = $_SESSION['adminName'];
        $sql = "DELETE FROM category WHERE id='$searchQryParam'";
        $execute = mysqli_query($conn, $sql);
        echo $execute;
        if($execute){
            $_SESSION['SuccessMessage'] = "Category Deleted Successfully";
            Redirect_To("categories.php");
        }else{
            $_SESSION['ErrorMessage'] = "Something went wrong. Try again...";
            Redirect_To("categories.php");
        }
    }

?>