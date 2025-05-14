<?php
// pages/login.php
session_start();
require_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = $conn->real_escape_string($_POST['identifier']); // username or email
    $password   = $_POST['password'];  // Plain text comparison

    // Try to find user in admins table first.
    $sqlAdmin = "SELECT * FROM admins WHERE username = '$identifier' OR email = '$identifier' LIMIT 1";
    $resultAdmin = $conn->query($sqlAdmin);
    
    if ($resultAdmin->num_rows == 1) {
        $user = $resultAdmin->fetch_assoc();
        if ($password == $user['password']) {
            $_SESSION['user'] = $user;
            $_SESSION['role'] = 'admin';
            header("Location: admin_dashboard.php");
            exit;
        }
    }

    // Else check in students table.
    $sqlStudent = "SELECT * FROM students WHERE username = '$identifier' OR email = '$identifier' LIMIT 1";
    $resultStudent = $conn->query($sqlStudent);
    
    if ($resultStudent->num_rows == 1) {
        $user = $resultStudent->fetch_assoc();
        if ($password == $user['password']) {
            $_SESSION['user'] = $user;
            $_SESSION['role'] = 'student';
            header("Location: student_dashboard.php");
            exit;
        }
    }
    
    $error = "Invalid login credentials.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Log In - Modular Notes</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="container">
    <h2>Log In</h2>
    <?php 
      if(isset($_SESSION['success'])) { 
         echo "<p style='color:green;'>".$_SESSION['success']."</p>"; 
         unset($_SESSION['success']);
      }
      if(isset($error)) {
         echo "<p style='color:red;'>$error</p>"; 
      }
    ?>
    <form action="login.php" method="POST">
      <label for="identifier">Username or Email:</label>
      <input type="text" name="identifier" id="identifier" required>
      
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>
      
      <input type="submit" value="Log In">
    </form>
    <br>
    <a href="register.php">Don't have an account? Register Here</a>
  </div>
  <script src="../assets/js/script.js"></script>
</body>
</html>