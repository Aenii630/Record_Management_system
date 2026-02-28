<?php
// Start session
session_start();

// Initialize students array in session if not exists
if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

// Get any error messages
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - University Record Manager</title>
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
        <h1 class="page-title">Add New Student</h1>

        <!-- Error Messages -->
        <?php if ($error === 'duplicate'): ?>
            <div class="alert alert-danger">
                <span class="alert-icon">⚠️</span>
                A student with this ID already exists!
            </div>
        <?php elseif ($error === 'empty'): ?>
            <div class="alert alert-danger">
                <span class="alert-icon">⚠️</span>
                Please fill in all required fields!
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                ➕ Register New Student
            </div>
            <div class="card-body">
                <form action="process.php" method="POST" id="studentForm">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="id">Student ID *</label>
                            <input type="text" id="id" name="id" placeholder="e.g., STU004" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" id="name" name="name" placeholder="Enter full name" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" placeholder="student@university.edu" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" placeholder="e.g., 555-0100" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="course">Course *</label>
                            <select id="course" name="course" required>
                                <option value="">Select a course</option>
                                <option value="Computer Science">Computer Science</option>
                                <option value="Mathematics">Mathematics</option>
                                <option value="Physics">Physics</option>
                                <option value="Chemistry">Chemistry</option>
                                <option value="Biology">Biology</option>
                                <option value="Engineering">Engineering</option>
                                <option value="Business Administration">Business Administration</option>
                                <option value="Economics">Economics</option>
                                <option value="Psychology">Psychology</option>
                                <option value="English Literature">English Literature</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="year">Academic Year *</label>
                            <select id="year" name="year" required>
                                <option value="">Select year</option>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                                <option value="5th Year">5th Year</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">✓ Register Student</button>
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
