<?php
include_once("assets/html/db.php");
// session_start();

$email = $_SESSION["email"];
if (!isset($_SESSION["user"])) {
    header("Location: assets/html/login.php");

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
  <title>Responsive Chat App</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css"> 
<!-- <script src="assets/js/script.js"></script> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function loadMessages() {
  $('#messages').load('assets/html/load_message.php', function () {
      const box = document.getElementById('messages');
      box.scrollTop = box.scrollHeight;
  });
}

loadMessages();              
setInterval(loadMessages, 1000); 
</script>

</head>
<body>

  <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Chats</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column justify-content-between">
      <ul class="list-group mb-3">
        <li class="list-group-item">Alice</li>
        <li class="list-group-item">Bob</li>
        <li class="list-group-item">Charlie</li>
        <li class="list-group-item">Support</li>
      </ul>
          <form action="assets/html/logout.php" method="POST"><button class="btn btn-danger w-100 mb-2">Logout</button></form>
    </div>
  </div>

  <div class="container-fluid p-0">
    <div class="chat-container">
      <div class="sidebar-desktop p-3">
        <div>
          <h5>Chats</h5>
          <ul class="list-group mb-3">
            <li class="list-group-item">Alice</li>
            <li class="list-group-item">Bob</li>
            <li class="list-group-item">Charlie</li>
            <li class="list-group-item">Support</li>
          </ul>
        </div>
        <div>
          <form action="assets/html/logout.php" method="POST"><button class="btn btn-danger w-100 mb-2">Logout</button></form>
        </div>
      </div>

      <div class="chat-box">
        <div class="chat-header bg-white border-bottom p-3 d-flex align-items-center">

          <button class="btn btn-outline-primary me-3 menu-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
            ☰
          </button>
          <span class="fw-bold"><?php echo htmlspecialchars($username); ?></span>
        </div>

        <div class="messages" id="messages">

                 
        </div>

        <form action="assets/html/post_chat.php" method="POST">
          <div class="chat-input d-flex p-3 bg-white border-top">
          <input type="text" id="chatInput" class="form-control me-2" placeholder="Type a message..." name="message">
          <button class="btn btn-primary">Send</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
