<?php
// Include database connection
include('db.php');

session_start();

// Check if the ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete query to remove the participant
    $query = "DELETE FROM participants WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id); // Bind the participant ID
    $stmt->execute();

    // Set a success message in the session
    $_SESSION['success_message'] = "Participant deleted successfully!";

    // Redirect back to the participants page (index.php)
    header("Location: index.php");
    exit;
} else {
    echo "No participant ID provided.";
}
?>
