<?php
// index.php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome to modular notes</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    /* Increase main text size and center it */
    .main-text {
      text-align: center;
      font-size: 3em;
      margin-bottom: 30px;
    }
    /* Center the buttons below the main text */
    .button-container {
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="main-text">
      <h1>Welcome to modular notes</h1>
      <p>Your ultimate note-taking platform</p>
    </div>
    <div class="button-container">
      <a href="pages/login.php"><button>Log In</button></a>
      <a href="pages/register.php"><button>Register</button></a>
    </div>
  </div>
  <script src="assets/js/script.js"></script>
</body>
</html>