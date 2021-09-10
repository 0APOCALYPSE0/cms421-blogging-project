<?php
    require 'db.php';

    function Redirect_To($newLocation){
        header('Location:'.$newLocation);
        exit;
    }

    function checkUsernameExist($username){
        global $conn;
        $sql = "SELECT * FROM admins WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0){
            return true;
        }else{
            return false;
        }
    }

    function loginAttempt($username, $password){
        global $conn;
        $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password' LIMIT 1";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0){
                return mysqli_fetch_assoc($result);
            }else{
                return null;
            }
    }

    function confirmLogin(){
        if(isset($_SESSION['userID'])){
            return true;
        }else{
            $_SESSION['ErrorMessage'] = "Login Required!";
            Redirect_To("login.php");
        }
    }

    function totalPosts(){
        global $conn;
        $sql = "SELECT * FROM post";
        $result = mysqli_query($conn, $sql);
        return mysqli_num_rows($result);
    }

    function totalCategories(){
        global $conn;
        $sql = "SELECT * FROM category";
        $result = mysqli_query($conn, $sql);
        return mysqli_num_rows($result);
    }

    function totalAdmins(){
        global $conn;
        $sql = "SELECT * FROM admins";
        $result = mysqli_query($conn, $sql);
        return mysqli_num_rows($result);
    }

    function totalComments(){
        global $conn;
        $sql = "SELECT * FROM comments";
        $result = mysqli_query($conn, $sql);
        return mysqli_num_rows($result);
    }

    function approvedCommentsAccordingToPost($PostId){
        global $conn;
        $sql = "SELECT * FROM comments WHERE post_id='$PostId' AND status='ON'";
        $result = mysqli_query($conn, $sql);
        return mysqli_num_rows($result);
    }

    function disapprovedCommentsAccordingToPost($PostId){
        global $conn;
        $sql = "SELECT * FROM comments WHERE post_id='$PostId' AND status='OFF'";
        $result = mysqli_query($conn, $sql);
        return mysqli_num_rows($result);
    }

?>