<?php
// Konfigurasi koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti dengan username MySQL Anda
$password = ""; // Ganti dengan password MySQL Anda
$database = "radiostream";

// Membuka koneksi ke database
$conn = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newChannelName = $_POST["namaStasiun"];
    $newStreamingLink = $_POST["urlStreaming"];

    if ($newChannelName && $newStreamingLink) {
        // Membuat pernyataan SQL untuk menyimpan data baru
        $sql = "INSERT INTO radio (nama_stasiun, url_streaming) VALUES ('$newChannelName', '$newStreamingLink')";

        if ($conn->query($sql) === TRUE) {
            echo "Data stasiun radio '$newChannelName' telah berhasil dimasukkan ke database.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Nama channel dan link streaming harus diisi.";
    }
}

// Tutup koneksi database
$conn->close();
?>
