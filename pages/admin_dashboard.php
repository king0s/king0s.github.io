<?php
// pages/admin_dashboard.php
session_start();
require_once "../config/db.php";
require_once "../functions/auth.php";

// Enforce admin login
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$admin_id = $_SESSION['user']['id'];

// Handle Add Student form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_student'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $email    = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']); // Plain text password

    $sql_new = "INSERT INTO students (admin_id, username, email, password)
                VALUES ('$admin_id', '$username', '$email', '$password')";
    $conn->query($sql_new);
}

// Fetch students for this admin
$result = $conn->query("SELECT * FROM students WHERE admin_id = $admin_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Modular Notes</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="container">
    <h2>Admin Dashboard</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</p>
    
    <!-- Add New Student Form -->
    <div class="add-student" style="margin-bottom: 20px; padding: 20px; border: 1px solid #ccc; border-radius: 12px;">
      <h3>Add New Student</h3>
      <form action="admin_dashboard.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        
        <label for="password">Password:</label>
        <input type="text" name="password" id="password" required>
        
        <input type="submit" name="add_student" value="Add Student">
      </form>
    </div>
    
    <!-- Registered Students Listing -->
    <h3>Registered Students</h3>
    <table border="1" width="100%" style="border-collapse: collapse; background: rgba(255,255,255,0.8);">
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Actions</th>
      </tr>
      <?php while ($student = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $student['id']; ?></td>
          <td><?php echo htmlspecialchars($student['username']); ?></td>
          <td><?php echo htmlspecialchars($student['email']); ?></td>
          <td>
            <!-- Placeholder links for edit and delete actions -->
            <a href="edit_user.php?id=<?php echo $student['id']; ?>"><button>Edit</button></a>
            <a href="delete_user.php?id=<?php echo $student['id']; ?>"><button>Delete</button></a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
    
    <br>
    <a href="../logout.php"><button>Logout</button></a>
  </div>
  <script src="../assets/js/script.js"></script>
</body>
</html>