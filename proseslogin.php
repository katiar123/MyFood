<?php
include "koneksi.php";
session_start();

if(isset($_SESSION['login'])){
    header("location:index.php");
}

if(isset($_POST["submit"])){
    $user = $_POST['user'];
    $pw = $_POST['pw'];

    if(empty($user)){
        echo "<script>alert('Username tidak boleh kosong');
        document.location.href='login.php';</script>";
    }
    else if(strlen($pw) < 8){
        echo "<script>alert('Password minimal 8 karakter');
        document.location.href='login.php';</script>";
    }
    else {
        $sql = "SELECT * FROM user WHERE username='$user' and password='$pw'";
        $query = mysqli_query($koneksi, $sql);

        if ($query && mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_array($query);
        
        $_SESSION["login"]=true;
        $_SESSION["user"] = $user[0];
        $_SESSION['nama'] = $user[1];
        $_SESSION["level"] = $user[4];


        header('Location: index.php');
        
        exit();
        } else {
            echo "<script>alert('Username atau password salah');
        document.location.href='login.php';</script>";
        }
    }
}
?>
