<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "seminar_registration");

$alertMessage = ""; // Variabel untuk menyimpan pesan alert

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
        // Jika email sudah ada
        $alertMessage = "Email sudah terdaftar!";
    } else {
        // Simpan ke database
        $stmt = $conn->prepare("INSERT INTO peserta (email, nama, institusi, country, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $email, $nama, $institusi, $country, $address);
        $stmt->execute();
        $alertMessage = "Pendaftaran berhasil!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Seminar</title>
    <script>
        // Fungsi untuk menampilkan alert jika ada pesan dari PHP
        function showAlert(message) {
            if (message !== "") {
                alert(message);
            }
        }
    </script>
</head>
<body onload="showAlert('<?php echo $alertMessage; ?>')">

<form method="POST" action="">
    Email: <input type="email" name="email" required><br>
    Nama: <input type="text" name="nama" required><br>
    Institusi: <input type="text" name="institusi"><br>
    Negara: <input type="text" name="country"><br>
    Alamat: <textarea name="address"></textarea><br>
    <input type="submit" value="Daftar">
</form>

</body>
</html>
