<?php
    include_once("db.php");

    $email = $_POST["email"];
    $password = $_POST["password"];
    $password = md5($password);

    $sql = "SELECT * FROM `user` WHERE `email` = '$email' AND  `password` =  '$password'";
    $result = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($result);

    if($count == 1){

        $_SESSION["email"] = $email;
        $_SESSION["user"] = "active";
        header("Location: ../../index.php");
    }
    else{
        echo "<script>
        alert('User not found');
        window.location.href = 'login.php';
    </script>";

    }

?>