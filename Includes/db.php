<?php
    date_default_timezone_set('Asia/Kolkata');
    $DSN = "mysql:host=localhost; dbms=CMS4.2.1";
    // $conn = new PDO($DSN, 'root', '');
    if($_SERVER['SERVER_NAME'] == 'localhost'){
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $db = 'CMS4.2.1';
    }else{
        $myfile = fopen("db.txt", "r") or die("Unable to open file!");
        $str = fread($myfile,filesize("db.txt"));
        fclose($myfile);
        $str_arr = explode(",", $str);
        $host = $str_arr[0];
        $username = $str_arr[1];
        $password = $str_arr[2];
        $db = $str_arr[3];
    }
    $conn = mysqli_connect($host, $username, $password, $db);
?>