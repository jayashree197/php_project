<?php
session_start(); // Start the session to retrieve messages
include('db.php');
$sql = "SELECT * FROM participants ORDER BY id DESC LIMIT 5";
$result = $conn->query($sql);
?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Participant Dashboard</title>
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome for the check icon -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(to right, #ffecd2, #fcb69f);
                min-height: 100vh;
                padding: 40px 20px;
                font-family: 'Segoe UI', sans-serif;
            }
            .card {
                border: none;
                border-radius: 16px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            }
            .btn-custom {
                background-color: #6f42c1;
                color: white;
            }
            .btn-custom:hover {
                background-color: #5936a1;
            }
            .table thead {
                background-color: #6f42c1;
                color: white;
            }
            .header-badge {
                background: #28a745;
                color: white;
                font-size: 20px;
                padding: 10px 20px;
                border-radius: 30px;
            }
        </style>
    </head>
    <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container">
        <div class="text-center mb-4">
            <span class="header-badge">Participant Dashboard</span>
            <p class="lead mt-2">Manage all your participant data in one place</p>
        </div>

        <div class="mb-4 d-flex justify-content-center gap-3 flex-wrap">
            <a href="register.php" class="btn btn-success">➕ Add New Participant</a>
            <a href="search.php" class="btn btn-primary">🔍 Search Participants</a>
        </div>

        <div class="card p-4">
            <h4 class="mb-3"> Recent Participants</h4>
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="width: 400px; font-size: 14px; margin: 10px auto;">
                    <strong><i class="fas fa-check-circle me-2"></i></strong>
                    <?= $_SESSION['success_message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>
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
                        <?php while ($row = $result->fetch_assoc()){ ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= ($row['ndis'] > 0) ? htmlspecialchars($row['ndis']) : '' ?></td>
                                <td><?= htmlspecialchars($row['diagnosis']) ?></td>
                                <td><?= ($row['contact'] > 0) ? htmlspecialchars($row['contact']) : '' ?></td>
                                <td>
                                    <!-- Edit Button (POST method) -->
                                    <form action="editClient.php" method="POST" style="display:inline-block;">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                                    </form>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteId(<?= $row['id'] ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="alert alert-warning">No participants found.</div>
            <?php } ?>
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this participant? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS (Required for Modal) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- JavaScript to Set the Delete ID -->
    <script>
        function setDeleteId(id) {
            const deleteUrl = `deleteClient.php?id=${id}`; // Construct the delete URL
            document.getElementById('confirmDeleteBtn').setAttribute('href', deleteUrl); // Set the href of the confirm button
        }
    </script>
    </body>
    </html>
    </body>
    </html>

<?php $conn->close(); ?>