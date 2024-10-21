<?php
session_start();
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "seminar_registration");

// Cek login admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Tampilkan daftar peserta (yang belum dihapus)
$query = "SELECT * FROM peserta WHERE is_deleted = 0";
$result = $conn->query($query);
?>

<h2>Daftar Peserta Seminar</h2>
<table border="1">
    <tr>
        <th>Email</th>
        <th>Nama</th>
        <th>Institusi</th>
        <th>Negara</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['nama']; ?></td>
        <td><?php echo $row['institusi']; ?></td>
        <td><?php echo $row['country']; ?></td>
        <td><?php echo $row['address']; ?></td>
        <td>
            <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> | 
            <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<a href="add_participant.php">Tambah Peserta</a>
