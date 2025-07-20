<?php
include_once("db.php");
$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$password = md5($password);

$sql_user_checker = "SELECT * FROM `user` WHERE 'email' = '$email'";
$result_user = mysqli_query($conn,$sql_user_checker);
$count = mysqli_num_rows($result_user);

if($count == 0){

    $sql = "INSERT INTO `user`(`s. no.`, `username`, `email`, `password`, `status`) VALUES (NULL,'$username','$email','$password','1')";
    $result = mysqli_query($conn,$sql);

    if($result == 1){
        header("Location:login.php");
    }
    else{
        echo "register failed";
    }
}
else{
    echo "user already exist";
}


?>