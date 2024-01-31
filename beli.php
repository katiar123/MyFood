<?php
include "koneksi.php";
session_start();
if (!isset($_SESSION['login'])) {
    header("location:login.php");
    exit;
}
$id = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$sql = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$id'");
$row = mysqli_fetch_array($sql);

$produkId = $_SESSION['id'];
$totalHarga = 0;

if(isset($_POST["ms"])){
    if(!isset($_SESSION['login'])){
        header("location:login.php");
    }
    else{
        $nama = $_POST['nama'];
        $userId = $_SESSION['user'];
        $produkId = $_SESSION['id'];
        $gambar = $_POST['gambar'];
        $harga = $_POST['harga'];
        $kuantitas = $_POST['quantity'];
        $cartCheck = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE user_id='$userId' AND nama='$nama'");
        if (mysqli_num_rows($cartCheck) > 0) {
            // Jika produk sudah ada, update kuantitas
            $cartItem = mysqli_fetch_array($cartCheck);
            $newQuantity = $cartItem['kuantitas'] + $kuantitas;
            mysqli_query($koneksi, "UPDATE keranjang SET kuantitas='$newQuantity' WHERE user_id='$userId' AND nama='$nama'");
            header("location:kedua.php?id=$produkId");
        } else {
            // Jika produk belum ada, tambahkan ke dalam tabel keranjang
            mysqli_query($koneksi, "INSERT INTO keranjang(user_id,produk_id, nama, gambar, harga, kuantitas) VALUES ('$userId','$produkId','$nama','$gambar','$harga','$kuantitas')");
            header("location:kedua.php?id=$produkId");
        }
    }
}

if (isset($_POST['sekarang'])) {
    $userId = $_SESSION['user'];
    $produkId = $_SESSION['id'];
    $nama = $_POST['nama'];
    $gambar = $_POST['gambar'];
    $harga = $_POST['harga'];
    $kuantitas = $_POST['kuan'];

    // Memasukkan data ke dalam tabel 'beli'
    $queryInsertBeli = "INSERT INTO beli(user_id, produk_id, nama, harga, gambar, kuantitas) VALUES ('$userId','$produkId','$nama','$harga','$gambar','$kuantitas')";
    mysqli_query($koneksi, $queryInsertBeli);

    // Menghapus data dari tabel 'keranjang' karena sudah dibeli

    header("location:index.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai dari checkbox yang dicentang
    if (is_array($nilaiDicentang)) {
        echo "Nilai yang dicentang: " . implode(', ', $nilaiDicentang);
    } else {
        echo "Tidak ada nilai yang dicentang.";
    }
    
}



$_SESSION['kuantitas'] = $_POST['quantity'];
$kuantitas = $_SESSION['kuantitas'];
$_SESSION['titas'] = isset($_POST['titas']);
$kuan = isset($_SESSION['titas'])?$_SESSION['titas']:null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR9338cZcWjwN2xVkO7MMfMV-O3G6XAbnRF9w&usqp=CAU" type="image/png">
    <title>Checkout</title>
    <style>body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .kembali{
            display:none;
        }
        .header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: left;
            position: fixed;
            width:100%;
            top:-10px;
            z-index: 3;
        }
        .header h2{
            margin-left:30px;
        }
        .kecil{
            display:none;
        }
        .alamat{
            background-color:#fff;
            margin:30px 90px;
            padding:20px;
            height:130px;
            margin-top:100px;
        }
        .telp{
            position: relative;
            top: -50px;
        }
        .ubah{
            color:blue;
            text-decoration:none;
            position: relative;
            left: 1000px;
            top: -100px;
            font-size:20px;
            border:none;
            background:none;
        }
        .hr{
            position: relative;
            top:-90px;
        }
        .data{
            position: relative;
            top:-130px;
            left: 250px;
            font-size:23px;
            padding-right:320px;
        }
        .cart-item {
            border: 1px solid #ddd;
            margin: 5px;
            padding: 10px;
            background-color: #fff;
            display: flex;
            align-items: center;
            flex-wrap: wrap; /* Baris baru jika lebar layar terlalu kecil */
            width:78.5%;
            margin-left:130px;
            padding-bottom:130px;
            position: relative;
            top:-90px;
        }
        .pembayaran{
            position: relative;
            top:120px;
        }

        .cart-item img {
            width: 100px;
            height:100px;
            margin-right: 10px;
            position: relative;
            top:100px;
            left:40px;
        }
        .produk{
            position: relative;
            top:-20px;
            font-size:20px;
        }
        .cart-item h3 {
            margin-right: 20px;
            flex: 1; 
            position: relative;
            left:50px;
            top: 80px;
            font-size:28px;
        }

        .harga, .quan, .total {
            width: 110px; /* Menentukan lebar agar sejajar */
            margin-right: 30px;
            position: relative;
            right: 50px;
            top:80px;
            font-size:20px;
        }
        .harga{
            margin-right:140px;
            position: relative;
            left:90px;
        }
        .quan{
            margin-right:100px;
            position: relative;
            left:50px;
        }

        a {
            display: block;
            margin-top: 10px;
            color: #333;
            text-decoration: none;
            background-color: #fff;
            padding: 10px;
            border: 1px solid #ddd;
            width: 150px;
            text-align: center;
        }
        .judul {
            display: flex;
            background-color: #fff;
            margin: 5px;
            padding: px;
            border: 1px solid #ddd;
            align-items: center;
            justify-content: space-between;
            width:80%;
            margin-left:130px;
        }

        .judul h4 {
            flex: 1;
            margin-right: 20px;
            text-align: center;
        }
        .produk{
            position: relative;
            right:-25px;
        }
        .nama,.harg{
            position: relative;
            right:40px;
        }
        .nama{
            position: relative;
            right:0px;
        }
        .jumlah{
            position: relative;
            right:40px;
        }
        .judul i,span{
            position: relative;
            left:-100px;
            top:-30px;
        }
        .judul span{
            position: relative;
            left:-230px;
        }
        .nama{
            position:relative;
            left:-540px;
        }
        .judul{
            border:none;
        }
        .telp{
            position: relative;
            left: -885px;
            top:25px;
        }
        .data{
            position: relative;
            top:-50px;
        }
        .namaatas ul{
            list-style-type: none;
        }
        .namaatas li{
            display: inline-block;
            margin-right:80px;
        }
        .namaatas{
            position: relative;
            top:40px;
            left:660px;
            z-index: 2;
            color:#999;
        }
        .pembayaran select,.pembayaran option{
            padding: 15px 5px;
            width: 500px;
            position: relative;
            left:350px;
            top:-25px;
        }
        .ct h4{
            position: relative;
            top:0px;
            left:150px;
            z-index: 2;
        }
        .pembayaran{
            background-color:white;
            position: relative;
            top: -100px;
            margin:0px 133px;
            left: -3px;
        }
        .pembayaran h2{
            position: relative;
            top: 30px;
            left: 80px;
        }
        .pembayaran h3{
            position: relative;
            top:90px;
            color:#444;
            left: 680px;
        }.pembayaran span{
            position: relative;
            left: 880px;
            font-size:25px;
            top:45px;
        }
        .sekarang{
            padding:15px 80px;
            background-color:#333;
            color:white;
            border:none;
            position: relative;
            left: 900px;
            top: -30px;
        }
        @media (max-width:460px) {
            .header{
                height:60px;
                position: fixed;
                z-index: 2;
                width:100%;
                top: -10px;
            }
            .besar{
                display:none;
            }
            .kembali{
                display:block;
                background:none;
                border:none;
                color:white;
                font-size:25px;
                position: relative;
                left:10px;
                top:20px;
            }
            .kecil{
                display:block;
                position: relative;
                top:-25px;
                right:-25px;
                font-size:22px;
            }
        }
        </style>
</head>
<body>
    <div class="header">
        <a class="kembali" href="#" id="kembali"><i class="fa-solid fa-arrow-left"></i></a>
        <h2 class="besar">MyFood | Check Out</h2>
        <h2 class="kecil">Check Out</h2>
    </div>
    <div class="alamat">
        <div class="judul">
            <i class="fa-solid fa-location-dot"></i> <span><b>Alamat Pengiriman</b></span>
            <input type="hidden" name="nama" value="<?php echo $row[1]; ?>">
            <h3 class="nama"><?php echo $row[1]; ?></h3><br>
            <h3 class="telp"><?php echo $row[3]; ?></h3>
        </div>
        <div class="data">
            <?php echo $row[6]; ?> <?php echo $row[5]; ?>
        </div>
        <div class="almt">
            <a class="ubah" href="ubahalamat.php?id=<?php echo $row[0] ?>">Ubah</a>
        </div>
        <hr class="hr">
    </div>
    <div class="namaatas">
        <ul>
            <li>Harga Satuan</li>
            <li>Jumlah</li>
            <li>Subtotal Produk</li>
        </ul>
    </div>
    <div class="ct"> 
    <h4 class="produk">Produk Dipesan</h4>
        <?php
        if(isset($_POST['beli'])){
            $produkId = $_SESSION['id'];
            $query = mysqli_query($koneksi,"SELECT * FROM produk WHERE id = '$produkId'");
            while($productDetails = mysqli_fetch_array($query)){
                $subtotal = $productDetails[2] * $kuantitas;
            ?>
            <div class="cart-item">
                <input type="hidden" name="pilih" class="pilih">
                <img src="<?php echo $productDetails[3]; ?>" name="gambar" alt="<?php echo $productDetails[1]; ?>" width="100">
                <h3><?php echo $productDetails[1]; ?></h3>
                <p class="harga">Rp<?php echo number_format($productDetails[2], 2, ',', '.'); ?></p>
                <p class="quan"><?php echo $kuantitas; ?></p>
                <p class="total">Rp<?php echo number_format($subtotal, 2, ',', '.');?></p>
            </div>
        <?php
            }
        }
            if (isset($_POST['co'])) {
                $userId = $_SESSION['user'];
                
        
                    $query = "SELECT * FROM keranjang WHERE user_id = '$userId'";
                    $result = mysqli_query($koneksi, $query);
                    if ($result) {
                        ?>
                        <?php
                        while ($productDetails = mysqli_fetch_array($result)) {
                            $subtotal = $productDetails[5] * $productDetails[6];
                            $totalHarga += $productDetails['harga'] * $productDetails['kuantitas'];
                            ?>
                            <div class="cart-item">
                                <input type="hidden" name="pilih" class="pilih">
                                <img src="<?php echo $productDetails[4]; ?>" name="gambar" alt="<?php echo $productDetails[3]; ?>" width="100">
                                <h3><?php echo $productDetails[3]; ?></h3>
                                <p class="harga">Rp<?php echo number_format($productDetails[5], 2, ',', '.'); ?></p>
                                <p class="quan"><?php echo $productDetails[6]; ?></p>
                                <p class="total">Rp<?php echo number_format($subtotal, 2, ',', '.');?></p>
                            </div>
                            <form action="" method="post">
                            <?php
                            if(isset($_POST['beli'])){
                                ?>
                                <input type="hidden" name="nama" value="<?php echo $productDetails[3];?>">
                                <input type="hidden" name="gambar" value="<?php echo $productDetails[4];?>">
                                <input type="hidden" name="kuan" value="<?php echo $productDetails[6]?>">
                                <input type="hidden" name="harga" value="<?php echo $productDetails[5];?>">
                                <?php
                            }
                        }
                    }
                }
            
        
        

        ?>
            <div class="pembayaran">
                <?php
                if(isset($_POST['co'])){
                    ?>
                    <input type="hidden" name="nama" value="<?php echo $_SESSION['namaproduk'];?>">
                    <input type="hidden" name="gambar" value="<?php echo $_SESSION['gambar'];?>">
                    <input type="hidden" name="kuan" value="<?php echo $_SESSION['kuan'];?>">
                    <input type="hidden" name="harga" value="<?php echo $_SESSION['harga'];?>">
                <?php
                }
                ?>
                <h2>Metode Pembayaran   :</h2>
                <select name="metode">
                    <option>---PILIH METODE PEMBAYARAN---</option>
                    <option value="cod">CASH ON DELIVERY</option>
                    <option value="tf">TRANSFER BANK</option>
                </select>
                <h3>Total Pembayaran</h3><?php 
                if(isset($_POST['beli'])){
                    ?>
                    <span><b><?php echo number_format($subtotal, 2, ',', '.');;?></b></span>
                <?php
                }
                if(isset($_POST['co'])){
                    ?>
                    <span><b><?php echo number_format($totalHarga, 2, ',', '.');;?></b></span>
                    <?php
                }
                ?>
            </div>
            <button type="submit" name="sekarang" class="sekarang">BUAT PESANAN</button>
        </form>
        </div>
    </div>
    
</body>
</html>
                        