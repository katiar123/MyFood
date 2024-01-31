<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "koneksi.php";

    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $jenis = $_POST["jenis"];
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
    // Perbaikan klausa UPDATE
    $insert = mysqli_query($koneksi, "UPDATE produk SET nama='$nama', harga='$jenis', gambar='$upload_dir$nama_file', stok='$stok' WHERE id = '$id'");

    if ($insert) {
        echo "<script>alert('Data berhasil diupdate'); document.location.href='index.php'</script>";
    } else {
        echo "<script>alert('Data gagal diupdate')</script>";
    }
}
?>
