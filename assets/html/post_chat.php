<?php
    include_once("db.php");

    $message = $_POST["message"];
    $email = $_SESSION["email"];
    $receiver = $_POST['receiver'];

    $sql = "INSERT INTO `message`(`s. no.`, `sender_email`, `receiver_email`, `message`) VALUES ( NULL,'$email','$receiver','$message')";
    $result = mysqli_query($conn,$sql);

    if ($result == 1){
        header("Location: ../../index.php?receiver=".$receiver."");
    }

?>