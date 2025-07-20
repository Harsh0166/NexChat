<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    include_once("db.php");

    $email = $_POST["email"];
    $password = $_POST["password"];
    $password = md5($password);

    $sql = "SELECT * FROM `user` WHERE `email` = '$email' AND  `password` =  '$password'";
    $result = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($result);

    if($count == 1)
    {
        $_SESSION["email"] = $email;
        $_SESSION["user"] = "active";
        header("Location: ../../index.php");
    }

?>