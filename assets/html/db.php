<?php
    $server_name = "localhost";
    $username = "root";
    $password = "root123";
    $db_name = "nexchat";

    $conn = mysqli_connect($server_name,$username,$password,$db_name);
    
    if($conn){
        echo "connected successfully";
    }

?>