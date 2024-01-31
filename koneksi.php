<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "dbshop";
$koneksi = mysqli_connect($host,$username,$password,$database);
if($koneksi){
    echo "";
}
else{ 
    echo "gagal";
}