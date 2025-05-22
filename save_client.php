<?php
include('db.php');

session_start();

$name = isset($_POST['name']) ? trim($_POST['name']) : "";
$ndis = isset($_POST['ndis']) ? intval($_POST['ndis']) : "";
$diagnosis = isset($_POST['diagnosis']) ? trim($_POST['diagnosis']) : "";
$contact = isset($_POST['contact']) ? intval($_POST['contact']) : "";

$sql = "INSERT INTO participants (name, ndis, diagnosis, contact) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param('sisi', $name, $ndis, $diagnosis, $contact);

// Set a success message in the session
$_SESSION['success_message'] = "Participant added successfully!";

// Redirect to the participants page after updating
header("Location: index.php");
exit;

$stmt->close();
$conn->close();
?>