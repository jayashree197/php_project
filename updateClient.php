<?php
include('db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form inputs with basic validation
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $ndis = isset($_POST['ndis']) ? trim($_POST['ndis']) : '';
    $diagnosis = isset($_POST['diagnosis']) ? trim($_POST['diagnosis']) : '';
    $contact = isset($_POST['contact']) ? trim($_POST['contact']) : '';

    // Update participant info
    $sql = "UPDATE participants SET name = ?, ndis = ?, diagnosis = ?, contact = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $name, $ndis, $diagnosis, $contact, $id);
    $stmt->execute();

    $_SESSION['success_message'] = "Participant updated successfully.";
    header("Location: index.php");
    exit;
}
?>