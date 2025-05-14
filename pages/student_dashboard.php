<?php
// pages/student_dashboard.php
session_start();
require_once "../config/db.php";
require_once "../functions/auth.php";

// Enforce student login
if (!isLoggedIn() || !isStudent()) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['user']['id'];
$username   = htmlspecialchars($_SESSION['user']['username']);

// Process form submission to add a new note
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['note_submit'])) {
    $module     = $conn->real_escape_string($_POST['module']);
    $title      = $conn->real_escape_string($_POST['note_title']);
    $content    = $conn->real_escape_string($_POST['note_content']);
    $note_color = $conn->real_escape_string($_POST['note_color']);
    
    $sql = "INSERT INTO notes (student_id, module, note_title, note_content, color)
            VALUES ($student_id, '$module', '$title', '$content', '$note_color')";
    $conn->query($sql);
}

// Fetch notes for the logged-in student
$notes_result = $conn->query("SELECT * FROM notes WHERE student_id = $student_id ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Dashboard - Modular Notes</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="container">
    <!-- Big Welcome Message -->
    <div class="welcome-banner">Welcome, <?php echo $username; ?>!</div>
    
    <!-- Button to toggle the Add Note form -->
    <button onclick="toggleNoteForm()">Add Note</button>
    
    <!-- Hidden Note Form -->
    <div id="noteForm" class="hidden">
      <h3>New Note</h3>
      <form action="student_dashboard.php" method="POST">
        <label for="module">Module (e.g., Web, OOP, Math):</label>
        <input type="text" name="module" id="module" required>
        
        <label for="note_title">Note Title:</label>
        <input type="text" name="note_title" id="note_title" required>
        
        <label for="note_content">Note Content:</label>
        <textarea name="note_content" id="note_content" rows="5" required></textarea>
        
        <label for="note_color">Note Color:</label>
        <input type="color" name="note_color" id="note_color" value="#ffffff" required>
        
        <input type="submit" name="note_submit" value="Save Note">
      </form>
    </div>

    <h3>Your Notes</h3>
    <div class="note-grid">
      <?php while ($note = $notes_result->fetch_assoc()): ?>
        <div class="note-card"
             style="background: <?php echo htmlspecialchars($note['color']); ?>;"
             data-note-title="<?php echo htmlspecialchars($note['note_title']); ?>"
             data-note-module="<?php echo htmlspecialchars($note['module']); ?>"
             data-note-content="<?php echo htmlspecialchars($note['note_content']); ?>">
          <div class="note-title"><?php echo htmlspecialchars($note['note_title']); ?></div>
          <div class="note-module"><?php echo htmlspecialchars($note['module']); ?></div>
        </div>
      <?php endwhile; ?>
    </div>
    
    <br>
    <a href="../logout.php"><button>Logout</button></a>
  </div>

  <!-- Modal for full note display -->
  <div id="noteModal" class="modal">
    <div class="modal-content">
      <span class="close-modal">&times;</span>
      <h3 id="modalNoteTitle"></h3>
      <p id="modalNoteModule"></p>
      <p id="modalNoteContent"></p>
    </div>
  </div>
  
  <script>
    // Toggle note form visibility
    function toggleNoteForm() {
      const form = document.getElementById('noteForm');
      form.classList.toggle('hidden');
    }
  </script>
  <script src="../assets/js/script.js"></script>
</body>
</html>