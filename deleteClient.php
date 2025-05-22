<?php
// Start session and include DB connection
session_start();
require 'db.php';

// Check if a valid participant ID is passed
if (!empty($_GET['id'])) {
    $participantId = (int) $_GET['id'];

    // Prepare and execute delete statement
    $stmt = $conn->prepare("DELETE FROM participants WHERE id = ?");
    $stmt->bind_param('i', $participantId);
    $stmt->execute();

    // Store success message in session
    $_SESSION['success_message'] = "Participant deleted successfully.";

    // Redirect to the main listing page
    header("Location: index.php");
    exit;
} else {
    echo "Invalid request: No participant ID specified.";
}
?>