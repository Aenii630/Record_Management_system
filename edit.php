<?php
// Start session
session_start();

// Initialize students array in session if not exists
if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

// Get student ID from URL
$studentId = isset($_GET['id']) ? $_GET['id'] : '';

// Find the student record
$student = null;
foreach ($_SESSION['students'] as $s) {
    if ($s['id'] === $studentId) {
        $student = $s;
        break;
    }
}

// If student not found, redirect to index
if (!$student) {
    header('Location: index.php');
    exit;
}

// Get any error messages
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - University Record Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <div class="logo-icon">🎓</div>
                <span>University Records</span>
            </div>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="add.php" class="btn-add">+ Add Student</a>
            </div>
        </nav>
    </header>

    <main>
        <h1 class="page-title">Edit Student Record</h1>

        <!-- Error Messages -->
        <?php if ($error === 'empty'): ?>
            <div class="alert alert-danger">
                <span class="alert-icon">⚠️</span>
                Please fill in all required fields!
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                ✏️ Update Student Information
            </div>
            <div class="card-body">
                <form action="process.php" method="POST" id="studentForm">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="original_id" value="<?php echo htmlspecialchars($student['id']); ?>">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="id">Student ID *</label>
                            <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($student['id']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="course">Course *</label>
                            <select id="course" name="course" required>
                                <option value="">Select a course</option>
                                <option value="Computer Science" <?php echo $student['course'] === 'Computer Science' ? 'selected' : ''; ?>>Computer Science</option>
                                <option value="Mathematics" <?php echo $student['course'] === 'Mathematics' ? 'selected' : ''; ?>>Mathematics</option>
                                <option value="Physics" <?php echo $student['course'] === 'Physics' ? 'selected' : ''; ?>>Physics</option>
                                <option value="Chemistry" <?php echo $student['course'] === 'Chemistry' ? 'selected' : ''; ?>>Chemistry</option>
                                <option value="Biology" <?php echo $student['course'] === 'Biology' ? 'selected' : ''; ?>>Biology</option>
                                <option value="Engineering" <?php echo $student['course'] === 'Engineering' ? 'selected' : ''; ?>>Engineering</option>
                                <option value="Business Administration" <?php echo $student['course'] === 'Business Administration' ? 'selected' : ''; ?>>Business Administration</option>
                                <option value="Economics" <?php echo $student['course'] === 'Economics' ? 'selected' : ''; ?>>Economics</option>
                                <option value="Psychology" <?php echo $student['course'] === 'Psychology' ? 'selected' : ''; ?>>Psychology</option>
                                <option value="English Literature" <?php echo $student['course'] === 'English Literature' ? 'selected' : ''; ?>>English Literature</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="year">Academic Year *</label>
                            <select id="year" name="year" required>
                                <option value="">Select year</option>
                                <option value="1st Year" <?php echo $student['year'] === '1st Year' ? 'selected' : ''; ?>>1st Year</option>
                                <option value="2nd Year" <?php echo $student['year'] === '2nd Year' ? 'selected' : ''; ?>>2nd Year</option>
                                <option value="3rd Year" <?php echo $student['year'] === '3rd Year' ? 'selected' : ''; ?>>3rd Year</option>
                                <option value="4th Year" <?php echo $student['year'] === '4th Year' ? 'selected' : ''; ?>>4th Year</option>
                                <option value="5th Year" <?php echo $student['year'] === '5th Year' ? 'selected' : ''; ?>>5th Year</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">✓ Update Record</button>
                        <a href="index.php" class="btn btn-secondary">← Back to List</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 University Record Manager. All rights reserved.</p>
    </footer>

    <script>
        document.getElementById('studentForm').addEventListener('submit', function(e) {
            const id = document.getElementById('id').value.trim();
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const course = document.getElementById('course').value;
            const year = document.getElementById('year').value;

            if (!id || !name || !email || !phone || !course || !year) {
                e.preventDefault();
                alert('Please fill in all required fields!');
            }
        });
    </script>
</body>
</html>
