<?php
    require_once 'db.php';

    // $serverName = $_SERVER['SERVER_NAME'];
    define("BASE_PATH", url());
    $serverName = BASE_PATH;
    $cssBaseURL = $serverName.'/css';
    $imagesBaseURL = $serverName.'/Images';
    $uploadBaseURL = $serverName.'/Upload';

    function url(){
        return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['SERVER_NAME'] != 'localhost' ? '' : '/CMS4.2.1'
        );
    }

    function post_slug($vp_string){

        $vp_string = trim($vp_string);

        $vp_string = html_entity_decode($vp_string);

        $vp_string = strip_tags($vp_string);

        $vp_string = strtolower($vp_string);

        $vp_string = preg_replace('~[^ a-z0-9_.]~', ' ', $vp_string);

        $vp_string = preg_replace('~ ~', '-', $vp_string);

        $vp_string = preg_replace('~-+~', '-', $vp_string);

        return $vp_string;
    }

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
            Redirect_To("login");
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