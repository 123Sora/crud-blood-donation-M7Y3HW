<?php
include 'blood_db.php';

if (isset($_POST['id'])) {
    $idToDelete = $conn->real_escape_string($_POST['id']);
    $sqlDelete = "UPDATE donors SET deleted_at = NOW() WHERE id = $idToDelete";

    if ($conn->query($sqlDelete) === TRUE) {
        $message = "Donor deleted successfully.";
        $message_type = "success";
    } else {
        $message = "Error deleting donor: " . $conn->error;
        $message_type = "danger";
    }
    header("Location: index.php?message=" . urlencode($message) ."&message_type=".$message_type);
    exit();
} else {
    header("Location: index.php"); 
}
?>