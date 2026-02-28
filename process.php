<?php
// Start session
session_start();

// Initialize students array in session if not exists
if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

// Get form data
$action = isset($_POST['action']) ? $_POST['action'] : '';

// Process based on action
if ($action === 'add') {
    // Add new student
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $course = isset($_POST['course']) ? trim($_POST['course']) : '';
    $year = isset($_POST['year']) ? trim($_POST['year']) : '';

    // Validate required fields
    if (empty($id) || empty($name) || empty($email) || empty($phone) || empty($course) || empty($year)) {
        header('Location: add.php?error=empty');
        exit;
    }

    // Check for duplicate ID
    foreach ($_SESSION['students'] as $student) {
        if ($student['id'] === $id) {
            header('Location: add.php?error=duplicate');
            exit;
        }
    }

    // Add new student to session
    $_SESSION['students'][] = [
        'id' => $id,
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'course' => $course,
        'year' => $year
    ];

    // Redirect with success action
    header('Location: index.php?action=success');
    exit;

} elseif ($action === 'edit') {
    // Edit existing student
    $original_id = isset($_POST['original_id']) ? trim($_POST['original_id']) : '';
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $course = isset($_POST['course']) ? trim($_POST['course']) : '';
    $year = isset($_POST['year']) ? trim($_POST['year']) : '';

    // Validate required fields
    if (empty($id) || empty($name) || empty($email) || empty($phone) || empty($course) || empty($year)) {
        header('Location: edit.php?id=' . urlencode($original_id) . '&error=empty');
        exit;
    }

    // Check for duplicate ID (if ID changed)
    if ($id !== $original_id) {
        foreach ($_SESSION['students'] as $student) {
            if ($student['id'] === $id) {
                header('Location: edit.php?id=' . urlencode($original_id) . '&error=duplicate');
                exit;
            }
        }
    }

    // Find and update the student record
    foreach ($_SESSION['students'] as &$student) {
        if ($student['id'] === $original_id) {
            $student['id'] = $id;
            $student['name'] = $name;
            $student['email'] = $email;
            $student['phone'] = $phone;
            $student['course'] = $course;
            $student['year'] = $year;
            break;
        }
    }

    // Redirect with update action
    header('Location: index.php?action=update');
    exit;
}

// If no valid action, redirect to index
header('Location: index.php');
exit;
?>
