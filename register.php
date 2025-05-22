<?php include('db.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add NDIS Participant</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #a1c4fd, #c2e9fb);
            font-family: 'Segoe UI', sans-serif;
            padding-top: 50px;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 25px;
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

<div class="form-container">
    <h2>Register NDIS Participant</h2>
    <form action="save_client.php" method="POST" autocomplete="off" onsubmit="return validateForm();">
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="mb-3">
            <label for="ndis" class="form-label">NDIS Number</label>
            <input type="text" name="ndis" class="form-control">
        </div>
        <div class="mb-3">
            <label for="diagnosis" class="form-label">Diagnosis</label>
            <input type="text" name="diagnosis" class="form-control">
        </div>
        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" name="contact" class="form-control">
        </div>
        <div class="mb-4 d-flex justify-content-center gap-3 flex-wrap">
            <a href="index.php" class="btn btn-success">Back to Dashboard</a>
            <button type="submit" class="btn btn-primary">Save Participant</button>
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