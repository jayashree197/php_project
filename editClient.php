<?php
// Include database connection
include('db.php');

// Start session to handle success messages
session_start();

// Get the ID from the URL or post data
$id = $_POST['id'] ?? null;

if ($id) {
    // Fetch participant details from the database
    $query = "SELECT * FROM participants WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $participant = $result->fetch_assoc();

    // If no participant is found
    if (!$participant) {
        echo "<div style='color: red; text-align:center; margin-top: 20px;'>Invalid participant ID.</div>";
        exit;
    }
} else {
    echo "<div style='color: red; text-align:center; margin-top: 20px;'>No participant ID provided.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Participant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f8;
            font-family: Arial, sans-serif;
            padding-top: 50px;
        }
        .edit-form {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            max-width: 600px;
            margin: 40px auto;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 25px;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .btn-primary {
            background-color: #00b894;
            border: none;
        }
        .btn-primary:hover {
            background-color: #019875;
        }
        label {
            font-weight: 600;
            color: #2d3436;
        }
    </style>
</head>
<body>

<div class="edit-form">
    <h2>Edit Participant</h2>
    <form action="updateClient.php" method="POST" autocomplete="off" onsubmit="return validateForm();">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($participant['id']); ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($participant['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="ndis" class="form-label">NDIS Number</label>
            <input type="text" name="ndis" class="form-control" value="<?php echo htmlspecialchars($participant['ndis']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="diagnosis" class="form-label">Diagnosis</label>
            <input type="text" name="diagnosis" class="form-control" value="<?php echo htmlspecialchars($participant['diagnosis']); ?>">
        </div>

        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" name="contact" class="form-control" value="<?php echo ($participant['contact'] > 0) ? htmlspecialchars($participant['contact']) : ''; ?>">
        </div>

        <div class="mb-4 d-flex justify-content-center gap-3 flex-wrap">
            <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>

<script>
    // Client-side validation for form
    function validateForm() {
        const nameField = document.querySelector('[name="name"]');
        const ndisField = document.querySelector('[name="ndis"]');
        const contactField = document.querySelector('[name="contact"]');

        const name = nameField.value.trim();
        const ndis = ndisField.value.trim();
        const contact = contactField.value.trim();

        // Check for valid name
        if (name === "") {
            alert("Please enter the full name.");
            nameField.focus();
            return false;
        }

        // Validate NDIS number
        if (ndis === "" || isNaN(ndis) || ndis.length < 6) {
            alert("Please enter a valid NDIS Number (min 6 digits).");
            ndisField.focus();
            return false;
        }

        // Validate contact number (if entered)
        if (contact !== "" && !/^\d{10}$/.test(contact)) {
            alert("Contact must be a 10-digit number.");
            contactField.focus();
            return false;
        }

        return true; // Proceed to submit form
    }
</script>

</body>
</html>