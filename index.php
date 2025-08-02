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
    <div>
      <button class="menu-btn" id="menuToggle">☰</button>
    <span style="font-size: 25px;"><B>NEXCHAT</B></span>
    </div>
    <?php
          if (isset($_GET['receiver'])){
            $friend_email = $_GET['receiver'];
            $friend_name_sql = "SELECT * FROM `friends_table` WHERE `user_email` = '$email' AND `friend_email`= '$friend_email'";
            $friend_name_result = mysqli_query($conn,$friend_name_sql);
            $row = $friend_name_result->fetch_assoc();
            $friend_name = $row['friend_name'];
            
            echo '<span>'.$friend_name .'</span>';
          }
        ?>
    
  </div>

  <div class="chat-main">
    <div class="sidebar" id="sidebar">
    <div class="sidebar-content">
<button class="menu-btn popup-trigger" id ="add_btn" style=" width: 30px ;font-size:25px; border : 1px solid; border-radius:50px">+</button>
      <div class="profile-box">
        <img src="assets/html/image.png" alt="User" class="profile-img">
        
        <p class="username"><?php echo $username; ?></p>
      </div>
      <hr >
      <ul>

      <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['friend_email'])) {
          $friends_email = $_GET['friend_email'];
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
                echo "<script>
                  alert('Friend Added successfully');
                  window.location.href = 'index.php';
                  </script>";;
              }
            }
            else{
              echo "<script>
                  alert('User is not on NEXCHAT invite them');
                  window.location.href = 'index.php';
                  </script>";
            }
          } 
          else if($friends_email == $email){
            echo "<script>
              alert('you can't add you own id');
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
          <?php
          $msg = "";
        if (isset($_GET['receiver'])  && !empty($_GET['receiver'])) {
          echo $msg;
        } else {
          echo '<div class="welcome-msg"><h2>Welcome to NEXCHAT</h2><p>Select a friend to start chatting.</p></div>';
        }
      ?>
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

function loadMessages() {
  const receiver = new URLSearchParams(window.location.search).get('receiver');
  if (!receiver) return; // don't fetch if no receiver selected

  fetch('assets/html/load_message.php?receiver=' + receiver)
    .then(res => res.text())
    .then(data => {
      document.getElementById("messageboard").innerHTML = data;
    });
}

setInterval(loadMessages, 100);



</script>

</body>
</html>
