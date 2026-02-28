<?php
// Start session for temporary data storage
session_start();

// Initialize students array in session if not exists
if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

// Get action from URL
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Add sample data if session is empty (for demonstration)
if (empty($_SESSION['students'])) {
    $_SESSION['students'] = [
        [
            'id' => 'STU001',
            'name' => 'John Smith',
            'email' => 'john.smith@university.edu',
            'phone' => '555-0101',
            'course' => 'Computer Science',
            'year' => '3rd Year'
        ],
        [
            'id' => 'STU002',
            'name' => 'Emily Johnson',
            'email' => 'emily.johnson@university.edu',
            'phone' => '555-0102',
            'course' => 'Mathematics',
            'year' => '2nd Year'
        ],
        [
            'id' => 'STU003',
            'name' => 'Michael Brown',
            'email' => 'michael.brown@university.edu',
            'phone' => '555-0103',
            'course' => 'Physics',
            'year' => '4th Year'
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Record Manager</title>
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
        <h1 class="page-title">Student Records</h1>

        <!-- Action Messages -->
        <?php if ($action === 'success'): ?>
            <div class="alert alert-success">
                <span class="alert-icon">✓</span>
                Student record has been successfully added!
            </div>
        <?php elseif ($action === 'update'): ?>
            <div class="alert alert-success">
                <span class="alert-icon">✓</span>
                Student record has been successfully updated!
            </div>
        <?php elseif ($action === 'delete'): ?>
            <div class="alert alert-warning">
                <span class="alert-icon">🗑️</span>
                Student record has been successfully deleted!
            </div>
        <?php endif; ?>

        <!-- Stats -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo count($_SESSION['students']); ?></div>
                <div class="stat-label">Total Students</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo count(array_unique(array_column($_SESSION['students'], 'course'))); ?></div>
                <div class="stat-label">Courses</div>
            </div>
        </div>

        <!-- Student Table -->
        <div class="card">
            <div class="card-header">
                📋 Registered Students
            </div>
            <div class="card-body">
                <?php if (empty($_SESSION['students'])): ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">📭</div>
                        <h3>No Records Found</h3>
                        <p>There are no student records in the system.</p>
                        <a href="add.php" class="btn btn-primary">Add First Student</a>
                    </div>
                <?php else: ?>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Course</th>
                                    <th>Year</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION['students'] as $student): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($student['id']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($student['name']); ?></td>
                                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                                        <td><?php echo htmlspecialchars($student['phone']); ?></td>
                                        <td><?php echo htmlspecialchars($student['course']); ?></td>
                                        <td><?php echo htmlspecialchars($student['year']); ?></td>
                                        <td>
                                            <div class="action-btns">
                                                <a href="edit.php?id=<?php echo urlencode($student['id']); ?>" class="btn-edit">✏️ Edit</a>
                                                <button type="button" class="btn-delete" onclick="confirmDelete('<?php echo htmlspecialchars($student['id']); ?>', '<?php echo htmlspecialchars($student['name']); ?>')">🗑️ Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <h3>⚠️ Confirm Delete</h3>
            <p>Are you sure you want to delete the record for <strong id="deleteStudentName"></strong>?</p>
            <div class="modal-actions">
                <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <a href="" id="confirmDeleteBtn" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 University Record Manager. All rights reserved.</p>
    </footer>

    <script>
        function confirmDelete(studentId, studentName) {
            document.getElementById('deleteStudentName').textContent = studentName;
            document.getElementById('confirmDeleteBtn').href = 'delete.php?id=' + encodeURIComponent(studentId);
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        // Close modal on outside click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
