<?php
// Start session
session_start();

// Initialize students array in session if not exists
if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

// Get student ID from URL
$studentId = isset($_GET['id']) ? $_GET['id'] : '';

// Find and remove the student record
$found = false;
foreach ($_SESSION['students'] as $key => $student) {
    if ($student['id'] === $studentId) {
        unset($_SESSION['students'][$key]);
        $_SESSION['students'] = array_values($_SESSION['students']); // Re-index array
        $found = true;
        break;
    }
}

// Redirect based on result
if ($found) {
    header('Location: index.php?action=delete');
} else {
    header('Location: index.php');
}
exit;
?>
