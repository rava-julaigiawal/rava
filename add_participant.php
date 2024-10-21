<?php
$conn = new mysqli("localhost", "root", "", "seminar_registration");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $nama = $_POST['nama'];
    $institusi = $_POST['institusi'];
    $country = $_POST['country'];
    $address = $_POST['address'];

    // Periksa apakah email sudah ada
    $checkEmail = $conn->prepare("SELECT * FROM peserta WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "Email sudah terdaftar!";
    } else {
        // Simpan ke database
        $stmt = $conn->prepare("INSERT INTO peserta (email, nama, institusi, country, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $email, $nama, $institusi, $country, $address);
        $stmt->execute();
        echo "Peserta berhasil ditambahkan!";
    }
}
?>

<form method="POST">
    Email: <input type="email" name="email" required><br>
    Nama: <input type="text" name="nama" required><br>
    Institusi: <input type="text" name="institusi"><br>
    Negara: <input type="text" name="country"><br>
    Alamat: <textarea name="address"></textarea><br>
    <input type="submit" value="Tambah">
</form>
