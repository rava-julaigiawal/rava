<?php
$conn = new mysqli("localhost", "root", "", "seminar_registration");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $nama = $_POST['nama'];
        $institusi = $_POST['institusi'];
        $country = $_POST['country'];
        $address = $_POST['address'];

        // Update data peserta
        $stmt = $conn->prepare("UPDATE peserta SET email=?, nama=?, institusi=?, country=?, address=? WHERE id=?");
        $stmt->bind_param("sssssi", $email, $nama, $institusi, $country, $address, $id);
        $stmt->execute();

        header("Location: admin.php");
        exit();
    } else {
        $stmt = $conn->prepare("SELECT * FROM peserta WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $peserta = $result->fetch_assoc();
    }
}
?>

<form method="POST">
    Email: <input type="email" name="email" value="<?php echo $peserta['email']; ?>" required><br>
    Nama: <input type="text" name="nama" value="<?php echo $peserta['nama']; ?>" required><br>
    Institusi: <input type="text" name="institusi" value="<?php echo $peserta['institusi']; ?>"><br>
    Negara: <input type="text" name="country" value="<?php echo $peserta['country']; ?>"><br>
    Alamat: <textarea name="address"><?php echo $peserta['address']; ?></textarea><br>
    <input type="submit" value="Update">
</form>
