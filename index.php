<?php
include_once("assets/html/db.php");

$email = $_SESSION["email"];
if (!isset($_SESSION["user"])) {
    header("Location: assets/html/login.php");
    exit();
}

$sql = "SELECT * FROM `user` WHERE `email` = '$email'";
$result = mysqli_query($conn, $sql);
if ($row = mysqli_fetch_assoc($result)) {
    $username = $row['username'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>NEXCHAT</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div id="popup" class="popup-overlay">
  <div class="popup-box">
    <span class="close-btn" id="closePopup">&times;</span>
    <h3>Add your Friend</h3>
    <form id="emailForm" action="" method="GET">
      <input type="email" id="email" name="friend_email" placeholder="you@example.com" required>
      <div class="popup-actions">
        <button type="submit">Add</button>
        <button type="button" id="cancelBtn">Cancel</button>
      </div>
    </form>
  </div>
</div>


<div class="chat-container">
  <div class="chat-header">
    <button class="menu-btn" id="menuToggle">☰</button>
    <span><?php echo $username; ?></span>
    <button class="menu-btn popup-trigger" style=" width: 30px ;font-size:25px; border : 1px solid; border-radius:50px">+</button>
  </div>

  <div class="chat-main">
    <div class="sidebar" id="sidebar">
      <ul>

      <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['friend_email'])) {
          $friends_email =$_GET['friend_email'];
          if($friends_email != $email){
            $fetch_sql = "SELECT * FROM `user`  where `email` = '$friends_email'";
            $fetched_result = mysqli_query($conn,$fetch_sql);

            if($row = mysqli_fetch_assoc($fetched_result)){
            $check_existence = "SELECT * FROM `friends_table` WHERE `user_email`= '$email' &&  `friend_email`= '$friends_email'";
            $check_existence_result = mysqli_query($conn,$check_existence);
            $count = mysqli_num_rows($check_existence_result);

            if($count == 0){
              $insert_friend_email = " INSERT INTO `friends_table`(`Sno`, `user_email`, `friend_email`) VALUES (NULL,'$email','$friends_email')";
              mysqli_query($conn,$insert_friend_email);
            }
          }
          }
         
          
        }

        $friend_data1 = "SELECT * FROM `friends_table` WHERE `user_email`= '$email'";
        $friend_data_result1 = mysqli_query($conn,$friend_data1);

        while($row1 = mysqli_fetch_assoc($friend_data_result1)){
            $friend_email1 = $row1['friend_email'];
            echo " <li><a href='index.php?receiver=".$friend_email1."'>".
            // .$friend_name.
            ' ('.$friend_email1.')'."</a></li>";

          $msg ="";
          
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['receiver'])){
              
              $receiver_mail = $_GET['receiver'];
              $fetch_msg = "SELECT * FROM `message` WHERE (`sender_email`='$email' AND `receiver_email`='$receiver_mail') OR (`sender_email`='$receiver_mail' AND `receiver_email`='$email')";
              
                $fetched_result = mysqli_query($conn, $fetch_msg);

                while ($row = mysqli_fetch_assoc($fetched_result)) {
                    if ($row["sender_email"] == $_SESSION["email"]) {
                        $msg.= '<div class="message sent"><div class="bubble">'
                            .$row["message"] .
                            '</div></div>';
                    } else {
                        $msg.= '<div class="message received"><div class="bubble">'
                            . $row["message"] .
                            '</div></div>';
                    }
                }

            }
                


          };
      ?>
      </ul>
      <form action="assets/html/logout.php" method="POST">
        <button style="padding:10px; width:100%; margin-top:10px; background:red; color:#fff; border:none;">Logout</button>
      </form>
    </div>
<?php

  $rec =  $_GET['receiver'];
?>
    <div class="chat-box">
      <div class="messages" id="messages">
        <?php echo $msg; ?>
      </div>
      <form class="chat-input" action="assets/html/post_chat.php" method="POST">
  <input type="text" name="message" id="chatInput" placeholder="Type a message..." required>
  <input type="hidden" value ="<?php echo $rec;?>" name="receiver">
  <button type="submit">Send</button>
</form>

    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById('popup');
    const closeBtn = document.getElementById('closePopup');
    const cancelBtn = document.getElementById('cancelBtn');
    const openBtns = document.querySelectorAll('.popup-trigger');
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('menuToggle');

    openBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        popup.style.display = 'flex';
        document.getElementById('email').focus();
      });
    });

    closeBtn.onclick = cancelBtn.onclick = () => {
      popup.style.display = 'none';
    };

    toggleBtn.addEventListener('click', () => {
      if (window.innerWidth <= 768) {
        sidebar.style.display = sidebar.style.display === 'flex' ? 'none' : 'flex';
      }
    });

    function loadMessages() {
      const box = document.getElementById('messages');
      // fetch('')
      //   .then(response => response.text())
      //   .then(data => {
      //     box.innerHTML = data;
      //     box.scrollTop = box.scrollHeight;
      //   });
    }

    loadMessages();
    setInterval(loadMessages, 1000);
  });
</script>

</body>
</html>
