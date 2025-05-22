<?php
include 'db.php';

$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';
$results = null;

if (!empty($searchTerm)) {
    $query = "SELECT * FROM participants WHERE name LIKE ? OR diagnosis LIKE ?";
    $stmt = $conn->prepare($query);
    $param = "%$searchTerm%";
    $stmt->bind_param("ss", $param, $param);
    $stmt->execute();
    $results = $stmt->get_result();
}
?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Search Participants</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(to right, #74ebd5, #9face6);
                padding: 40px 20px;
                font-family: 'Segoe UI', sans-serif;
            }
            .card {
                border-radius: 16px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }
            .btn-primary {
                background-color: #007bff;
                border: none;
            }
            .btn-primary:hover {
                background-color: #0056b3;
            }
            .table thead {
                background-color: #007bff;
                color: #fff;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <h2 class="text-center mb-4">Search Participants</h2>

        <form method="POST" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Enter name or diagnosis" value="<?= htmlspecialchars($searchTerm) ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <a href="index.php" class="btn btn-outline-dark mb-4">Back to Dashboard</a>

        <?php if ($results !== null){ ?>
            <?php if ($results->num_rows > 0){ ?>
                <div class="card p-4">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>NDIS</th>
                            <th>Diagnosis</th>
                            <th>Contact</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($row = $results->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo !empty($row['ndis']) ? htmlspecialchars($row['ndis']) : ''; ?></td>
                                <td><?php echo htmlspecialchars($row['diagnosis']); ?></td>
                                <td><?php echo !empty($row['contact']) ? htmlspecialchars($row['contact']) : ''; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="alert alert-warning">No records found.</div>
            <?php } ?>
        <?php } ?>
    </div>
    </body>
    </html>

<?php $conn->close(); ?>