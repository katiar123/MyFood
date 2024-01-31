<?php
include "koneksi.php";
$productId = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM keranjang WHERE produk_id = '$productId'");
mysqli_query($koneksi, "DELETE FROM produk WHERE id = '$productId'");
header("location: index.php");
exit();
?>
