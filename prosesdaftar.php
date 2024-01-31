<?php
include "koneksi.php";
$nama = $_POST['user'];
$pw = $_POST['pw'];
$reg = $_POST['pass'];
$telp = $_POST['telp'];
$hashedPassword = md5($reg);
$cek = "SELECT * FROM user where username='$nama'";
$sql = mysqli_query($koneksi,$cek);
$jumlah = mysqli_num_rows($sql);
if( $jumlah > 0){
    echo "<script>alert('username sudah terpakai')
    document.location.href='daftar.php'</script>";
}
else{
    if($pw == $reg){
        $pw = $_POST['pw'];
        $reg = $_POST['pass'];
        $panjang = strlen($pw);
        if($pw = $panjang < 8){
            echo "<script>alert('Password minimal 8 karakter')
            document.location.href='daftar.php'</script>";
        }
        else{
            $query = mysqli_query($koneksi, "INSERT INTO user (username, password,telepon) VALUES ('$nama', '$hashedPassword')");
            if($query){
                echo "<script>alert('Pendaftaran Berhasil')
                document.location.href='login.php'</script>";
            }
        }
    }
    else{
        echo "<script>alert('Password yang anda masukan tidak sama')
        document.location.href='R.html'</script>";
    }
}