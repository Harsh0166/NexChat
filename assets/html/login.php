<?php

  include_once("db.php");
  if(isset($_SESSION["email"])){
    header("Location: ../../index.php");
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - ChatApp</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #6a11cb, #2575fc);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .form-container {
      background-color: #fff;
      padding: 2rem;
      border-radius: 10px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h4 class="mb-3 text-center">Login to ChatApp</h4>
    <form action="login_checker.php" method="POST">
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <p class="mt-3 text-center">
      Don't have an account?
      <a href="register.php">Register</a>
    </p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
