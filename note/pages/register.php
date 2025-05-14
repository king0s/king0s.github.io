<?php
// pages/register.php
session_start();
require_once "../config/db.php";

// Process registration when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username  = $conn->real_escape_string($_POST['username']);
    $email     = $conn->real_escape_string($_POST['email']);
    $password  = $conn->real_escape_string($_POST['password']);  // Plain text password

    // Insert the student into the database.
    // For demonstration, we assign a default admin (e.g., admin_id = 1)
    $default_admin_id = 1;
    $sql = "INSERT INTO students (admin_id, username, email, password)
            VALUES ('$default_admin_id', '$username', '$email', '$password')";
    if ($conn->query($sql)) {
        $_SESSION['success'] = "Registration successful. Please log in.";
        header("Location: login.php");
        exit;
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Modular Notes</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="container">
    <h2>Student Registration</h2>
    <?php if(isset($error)): ?>
      <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="register.php" method="POST">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" required>
      
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" required>
      
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>

      <input type="submit" value="Register">
    </form>
    <br>
    <a href="login.php">Already have an account? Log In Here</a>
  </div>
  <script src="../assets/js/script.js"></script>
</body>
</html>