<?php
include_once("db.php");

$fetch_sql = "SELECT * FROM `message`";
$fetched_result = mysqli_query($conn, $fetch_sql);

while ($row = mysqli_fetch_assoc($fetched_result)) {
    if ($row["email"] == $_SESSION["email"]) {
        echo '<div class="message sent"><div class="bubble">'
             .$row["message"] .
             '</div></div>';
    } else {
        echo '<div class="message received"><div class="bubble">'
             . $row["message"] .
             '</div></div>';
    }
}
?>
