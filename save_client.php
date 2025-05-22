<?php
include('db.php');
session_start();

// Sanitize and validate inputs
$name = isset($_POST['name']) ? trim($_POST['name']) : "";
$ndis = isset($_POST['ndis']) ? intval($_POST['ndis']) : 0;
$diagnosis = isset($_POST['diagnosis']) ? trim($_POST['diagnosis']) : "";
$contact = isset($_POST['contact']) ? intval($_POST['contact']) : 0;

// Prepare the SQL insert statement
$sql = "INSERT INTO participants (name, ndis, diagnosis, contact) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters and execute
$stmt->bind_param('sisi', $name, $ndis, $diagnosis, $contact);

if ($stmt->execute()) {
    $_SESSION['success_message'] = "Participant added successfully!";
} else {
    $_SESSION['error_message'] = "Failed to add participant: " . $stmt->error;
}

// Close resources
$stmt->close();
$conn->close();

// Redirect to dashboard
header("Location: index.php");
exit;
?>