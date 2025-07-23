<?php
    $server_name = "localhost";
    $username = "root";
    $password = "";
    $db_name = "nexchat";

    $conn = mysqli_connect($server_name,$username,$password,$db_name);
    
    if(!$conn){
        echo "Error in connectiong to database";
    }

    session_start();
?>