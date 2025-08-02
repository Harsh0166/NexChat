<?php
include_once("db.php");

if (!isset($_SESSION['email']) || !isset($_GET['receiver'])) {
    exit();
}

$email = $_SESSION['email'];
$receiver_mail = $_GET['receiver'];

$msg = "";
$fetch_msg = "SELECT * FROM `message` WHERE 
    (`sender_email`='$email' AND `receiver_email`='$receiver_mail') OR 
    (`sender_email`='$receiver_mail' AND `receiver_email`='$email')";

$fetched_result = mysqli_query($conn, $fetch_msg);

while ($row = mysqli_fetch_assoc($fetched_result)) {
    if ($row["sender_email"] == $email) {
        $msg .= '<div class="message sent"><div class="bubble">'
              . $row["message"] . '</div></div>';
    } else {
        $msg .= '<div class="message received"><div class="bubble">'
              . $row["message"] . '</div></div>';
    }
}

echo $msg;
?>
