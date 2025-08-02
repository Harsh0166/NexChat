<?php
include_once("assets/html/db.php");

$email = $_SESSION["email"];
if (!isset($_SESSION["email"])) {
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <button class="menu-btn popup-trigger" id ="add_btn" style=" width: 30px ;font-size:25px; border : 1px solid; border-radius:50px">+</button>
  </div>

  <div class="chat-main">
    <div class="sidebar" id="sidebar">
    <div class="sidebar-content">

      <div class="profile-box">
        <img src="assets/html/image.png" alt="User" class="profile-img">
        <p class="username"><?php echo $username; ?></p>
      </div>
      <hr >
      <ul>

      <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['friend_email'])) {
          $friends_email =$_GET['friend_email'];
          if($friends_email != $email){
            $fetch_sql = "SELECT * FROM `user`  where `email` = '$friends_email'";
            $fetched_result = mysqli_query($conn,$fetch_sql);

            if($row = mysqli_fetch_assoc($fetched_result)){
              $friend_name = $row['username'];
              $check_existence = "SELECT * FROM `friends_table` WHERE `user_email`= '$email' &&  `friend_email`= '$friends_email'";
              $check_existence_result = mysqli_query($conn,$check_existence);
              $count = mysqli_num_rows($check_existence_result);

              if($count == 0){
                $insert_friend_email = " INSERT INTO `friends_table`(`Sno`, `user_email`, `friend_email`,`friend_name`) VALUES (NULL,'$email','$friends_email','$friend_name')";
                mysqli_query($conn,$insert_friend_email);
              }
            }
            else{
              echo "<script>
                  alert('User is not on NEXCHAT invite them');
                  window.location.href = 'index.php';
                  </script>";
            }
          } 
          else{
            echo "<script>
              alert('you cant add you own id');
              window.location.href = 'index.php';
              </script>";
          }    
        }

        $friend_data1 = "SELECT * FROM `friends_table` WHERE `user_email`= '$email'";
        $friend_data_result1 = mysqli_query($conn,$friend_data1);

        while($row1 = mysqli_fetch_assoc($friend_data_result1)){
            $friend_email1 = $row1['friend_email'];
            $friend_name = $row1['friend_name'];
            echo " <li><a href='index.php?receiver=".$friend_email1."'>".
            $friend_name.
            ' ('.$friend_email1.')'."</a></li>";
                
          };
      ?>
      </ul>
    </div>
      <form action="assets/html/logout.php" method="POST" class="logout-form">
        <button>Logout</button>
      </form>
    </div>
<?php

          if(isset($_GET['receiver'])){
            $rec =  $_GET['receiver'];
          }
          else{
            $rec ='';
          }

?>
    <div class="chat-box">
      <div class="messages" id="messages">
        <div id="messageboard">
        </div>
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
  var popup = document.getElementById('popup');
  var closeBtn = document.getElementById('closePopup');
  var cancelBtn = document.getElementById('cancelBtn');
  var sidebar = document.getElementById('sidebar');
  var toggleBtn = document.getElementById('menuToggle');
  var openBtns = document.getElementById("add_btn");

  openBtns.onclick = function(){
    popup.style.display = 'flex';
    document.getElementById('email').focus();
  }

  closeBtn.onclick=function(){
    popup.style.display = 'none';
  }

  cancelBtn.onclick=function(){
    popup.style.display = 'none';
  }

  toggleBtn.onclick = function () {
    sidebar.classList.toggle('show-sidebar');
  };

  setInterval(() => {
    fetch("assets/html/load_message.php?receiver=<?php echo $_GET['receiver'] ?? ''; ?>")
      .then(res => res.text())
      .then(html => {
        document.getElementById("messageboard").innerHTML = html;
        const messages = document.getElementById("messages");
        messages.scrollTop = messages.scrollHeight;
      });
  }, 100);


</script>

</body>
</html>
