<?php
session_start(); // Start the session to show feedback messages
include('db.php');

// Get the latest 5 participants from the database
$sql = "SELECT * FROM participants ORDER BY id DESC";
$result = $conn->query($sql);
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Participant Dashboard</title>
        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome for icons -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(to right, #ffecd2, #fcb69f);
                min-height: 100vh;
                padding: 40px 20px;
            }
            .card {
                border-radius: 16px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            }
            .header-badge {
                background: #28a745;
                color: white;
                font-size: 20px;
                padding: 10px 20px;
                border-radius: 30px;
            }
            .table thead {
                background-color: #6f42c1;
                color: white;
            }
        </style>
    </head>
    <body>

    <div class="container">
        <div class="text-center mb-4">
            <span class="header-badge">Participant Dashboard</span>
            <p class="lead mt-2">Manage your participant records here</p>
        </div>

        <!-- Action buttons -->
        <div class="mb-4 d-flex justify-content-center gap-3 flex-wrap">
            <a href="register.php" class="btn btn-success">➕ Add New</a>
            <a href="search.php" class="btn btn-primary">🔍 Search</a>
        </div>

        <!-- Main card -->
        <div class="card p-4">
            <h4 class="mb-3">Recent Participants</h4>

            <!-- Show session message -->
            <?php if (isset($_SESSION['success_message'])){ ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= $_SESSION['success_message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php } ?>

            <!-- Display table if results exist -->
            <?php if ($result && $result->num_rows > 0){ ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>NDIS</th>
                            <th>Diagnosis</th>
                            <th>Contact</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo !empty($row['ndis']) ? htmlspecialchars($row['ndis']) : ''; ?></td>
                                <td><?php echo htmlspecialchars($row['diagnosis']); ?></td>
                                <td><?php echo !empty($row['contact']) ? htmlspecialchars($row['contact']) : ''; ?></td>
                                <td>
                                    <form action="editClient.php" method="POST" style="display:inline-block;">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                                    </form>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteId(<?php echo (int) $row['id']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="alert alert-warning text-center">No participants found.</div>
            <?php } ?>
        </div>
    </div>

    <!-- Delete confirmation modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this participant? This cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and delete logic -->
    <script>
        function setDeleteId(id) {
            document.getElementById('confirmDeleteBtn').href = `deleteClient.php?id=${id}`;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>
    </html>

<?php $conn->close(); ?>