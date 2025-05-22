<?php
// Include database connection
include('db.php');
session_start();
// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //validation
    $id = isset($_POST['id']) ? intval($_POST['id']) : "";
    $name = isset($_POST['name']) ? trim($_POST['name']) : "";
    $ndis = isset($_POST['ndis']) ? intval($_POST['ndis']) : "";
    $diagnosis = isset($_POST['diagnosis']) ? trim($_POST['diagnosis']) : "";
    $contact = isset($_POST['contact']) ? intval($_POST['contact']) : "";

    // Update query to modify participant details
    $query = "UPDATE participants SET name = ?, ndis = ?, diagnosis = ?, contact = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssi', $name, $ndis, $diagnosis, $contact, $id);
    $stmt->execute();

    // Set a success message in the session
    $_SESSION['success_message'] = "Participant updated successfully!";

    // Redirect to the participants page after updating
    header("Location: index.php");
    exit;
}
?>