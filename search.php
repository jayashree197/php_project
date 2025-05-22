<?php
include('db.php');
$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';
$result = null;

if (!empty($searchTerm)) {
    $stmt = $conn->prepare("SELECT * FROM participants WHERE name LIKE ? OR diagnosis LIKE ?");
    $likeTerm = "%$searchTerm%";
    $stmt->bind_param("ss", $likeTerm, $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .table thead {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center mb-4">🔍 Search Participants</h2>

    <form method="POST" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Enter name or diagnosis" value="<?= htmlspecialchars($searchTerm) ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <a href="index.php" class="btn btn-outline-dark mb-4">⬅ Back to Dashboard</a>

    <?php if ($result !== null){ ?>
        <?php if ($result->num_rows > 0){ ?>
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
                    <?php while ($row = $result->fetch_assoc()){ ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= ($row['ndis'] > 0) ? htmlspecialchars($row['ndis']) : '' ?></td>
                            <td><?= htmlspecialchars($row['diagnosis']) ?></td>
                            <td><?= ($row['contact'] > 0) ? htmlspecialchars($row['contact']) : '' ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else{?>
            <div class="alert alert-warning">No matching records found.</div>
        <?php } ?>
    <?php } ?>
</div>
</body>
</html>

<?php $conn->close(); ?>
