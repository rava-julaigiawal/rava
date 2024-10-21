<?php
$conn = new mysqli("localhost", "root", "", "seminar_registration");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Soft delete (mengubah is_deleted menjadi 1)
    $stmt = $conn->prepare("UPDATE peserta SET is_deleted = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: admin.php");
    exit();
}
?>
