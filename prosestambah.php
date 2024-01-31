<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "koneksi.php";

    $id = $_POST["id"];
    $nama = $_POST["jenis"];
    $stok = $_POST["stok"];

    // Proses unggahan gambar
    $gambar = $_FILES["gambar"];
    $nama_file = $gambar["name"];
    $ukuran_file = $gambar["size"];
    $tmp_file = $gambar["tmp_name"];

    // Direktori tempat menyimpan gambar
    $upload_dir = "uploads/";

    // Pastikan direktori ada
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Pindahkan file ke direktori tujuan
    move_uploaded_file($tmp_file, $upload_dir . $nama_file);

    // Insert data ke database
    // Perbaikan klausa INSERT INTO
    $insert = mysqli_query($koneksi, "INSERT INTO produk (nama, harga, gambar,stok) VALUES ('$id', '$nama', '$upload_dir$nama_file','$stok')");

    if ($insert) {
        echo "<script>alert('Data berhasil ditambahkan')
        document.location.href='index.php'</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan')</script>";
    }
}
?>
