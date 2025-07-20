<?php
    include_once("db.php");

    $message = $_POST["message"];
    $email = $_SESSION["email"];

    $sql = "INSERT INTO `message`(`s. no.`, `email`, `message`) VALUES ( NULL,'$email','$message')";
    $result = mysqli_query($conn,$sql);

    if ($result == 1){
        header("Location: ../../index.php");
    }

?>