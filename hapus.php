<?php
include "koneksi.php";
$id = $_GET["id"];
$query = "DELETE FROM keranjang WHERE id ='$id'";
$sql = mysqli_query($koneksi,$query);
if($sql){
    header("location:cart.php");
}