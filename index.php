<?php
include_once("assets/html/db.php");

$email = $_SESSION["email"] ?? '';
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
    <form id="emailForm">
      <input type="email" id="email" name="email" placeholder="you@example.com" required>
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
    <span><?php echo htmlspecialchars($username); ?></span>
    <button class="menu-btn popup-trigger">＋</button>
  </div>

  <div class="chat-main">
    <div class="sidebar" id="sidebar">
      <ul>
        <li>Alice</li>
        <li>Bob</li>
        <li>Charlie</li>
        <li>Support</li>
      </ul>
      <form action="assets/html/logout.php" method="POST">
        <button style="padding:10px; width:100%; margin-top:10px; background:red; color:#fff; border:none;">Logout</button>
      </form>
    </div>

    <div class="chat-box">
      <div class="messages" id="messages"></div>
      <form class="chat-input" action="assets/html/post_chat.php" method="POST">
  <input type="text" name="message" id="chatInput" placeholder="Type a message..." required>
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
      fetch('assets/html/load_message.php')
        .then(response => response.text())
        .then(data => {
          box.innerHTML = data;
          box.scrollTop = box.scrollHeight;
        });
    }

    loadMessages();
    setInterval(loadMessages, 1000);
  });
</script>

</body>
</html>
