<?php
session_start();
include "koneksi.php";

// Ambil data produk dari database
$id = $_GET["id"];
$sql = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = $id");
$row = mysqli_fetch_array($sql);
$_SESSION['id'] = $row[0];


// Fungsi untuk menambahkan item ke keranjang
function addToCart($productId, $quantity)
{
    $cartItem = [
        'id' => $productId,
        'quantity' => $quantity,
    ];

    // Inisialisasi keranjang jika belum ada
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Cek apakah produk sudah ada di keranjang
    $index = -1;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $productId) {
            $index = $key;
            break;
        }
    }

    // Jika produk sudah ada, update jumlahnya
    if ($index !== -1) {
        $_SESSION['cart'][$index]['quantity'] += $quantity;
    } else {
        // Jika produk belum ada, tambahkan ke keranjang
        $_SESSION['cart'][] = $cartItem;
    }
}

// Tangkap data dari form jika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    addToCart($productId, $quantity);
}


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
        } else {
            // Jika produk belum ada, tambahkan ke dalam tabel keranjang
            mysqli_query($koneksi, "INSERT INTO keranjang(user_id,produk_id, nama, gambar, harga, kuantitas) VALUES ('$userId','$produkId','$nama','$gambar','$harga','$kuantitas')");
        }
    }
}

$jumlahBarang = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
$userId = isset($_SESSION['user']) ? $_SESSION['user'] : null; // Tambahkan pemeriksaan isset
$jumlah = mysqli_query($koneksi,"SELECT * FROM keranjang WHERE user_id='$userId'");
$cek = mysqli_num_rows($jumlah);
$jum = mysqli_fetch_array($jumlah);
if (isset($jum) && is_array($jum)) {
    // Set session variables
    $_SESSION['namaproduk'] = isset($jum[3]) ? $jum[3] : '';
    $_SESSION['gambar'] = isset($jum[4]) ? $jum[4] : '';
    $_SESSION['harga'] = isset($jum[5]) ? $jum[5] : 0;
    $_SESSION['kuan'] = isset($jum[6]) ? $jum[6] : 0;
} else {
    // Handle the case where $jum is not set or not an array (optional)
    // You can set default values or take other appropriate actions
    $_SESSION['namaproduk'] = '';
    $_SESSION['gambar'] = '';
    $_SESSION['harga'] = 0;
    $_SESSION['kuan'] = 0;
}

if(isset($_POST['beli'])){
    if(!isset($_SESSION['login'])){
        header("location:login.php");
        exit; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR9338cZcWjwN2xVkO7MMfMV-O3G6XAbnRF9w&usqp=CAU" type="image/png">
    <title>MyFood</title>
    <style>
        *{
                margin:0;
                padding:0;
                font-family: arial;
            }
            body{
                margin:0;
                padding: 0;
                background-color: #f2f2f2;
                overflow: hidden;
            }
            .header h2{
                position: relative;
                left:80px;
                top:-5px;
                color: #fff;
                text-align: left;
            }
            .cart{
                color: white;
                margin-left:1185px;
                font-size: 30px;
                position: relative;
                bottom: 15px;
            }
            .apus {
                color: white;
                position:absolute;
                font-size: 30px;
                top: -60px;
                left: 1100px;
            }

            .edit {
                color: white;
                position:absolute;
                font-size: 30px;
                top: -60px;
                left: 1125px;
            }

            .header{
                background-color: #333;
                position: fixed;
                width: 120%;
                padding: 20px;
                overflow: hidden;
            }
            .main img{
                width:30%;
                height:300px;
            }
            .main{
                background-color:#fff;
                margin:20px;
                margin-left:25px;
                margin-top:30px;
                position: relative;
            }
            .text-center{
                margin-left:10px;
                position: relative;
                font-size: 30px;
                color:black;
                bottom:250px;
                left:450px;
            }
            .text-center h3{
                margin-left:10px;
                position: relative;
                font-size: 30px;
                color:black;
                right:10px;
                bottom:20px;
            }
            .nasi h4{
                margin-left:10px;
                position: relative;
                font-size: 15px;
                color:black;
                bottom:390px;
                left:450px;
            }
            .jumlah {
                margin-left:10px;
                position: relative;
                font-size: 15px;
                color:black;
                bottom:180px;
                left:450px;
                padding:10px;
                font-size: 18px;
            }
            input[type="number"]{
                padding:10px;
            }
            .text-center span{
                color:black;
            }
            button{
                padding:15px;
                position: relative;
                bottom:130px;
                left:450px;
                font-size: 17px;
                color:#fff;
                background-color:#333;
                border:none;
            }
            .beli i{
                margin-right:10px;
            }
            .bs{
                padding:15px;
                position: relative;
                bottom:130px;
                left:450px;
                font-size: 17px;
                color:#fff;
                background-color:#333;
                border:none;
                cursor: pointer;
            }
            .nasi a{
                display:none;
            }
            .beli{
                cursor: pointer;
            }
            .cart-icon-container {
                position: relative;
                display: inline-block;
                padding:10px;
                top:20px;
            }
            .jumlah span{
                position: relative;
                top:8px;
                font-size:16px;
                color:#999;
            }

    .cart-badge {
        position: absolute;
        top: -15px;
        right: 0;
        background-color: red; /* Warna latar belakang bulatan */
        color: white;
        border-radius: 50%;
        padding: 4px 8px; /* Sesuaikan dengan kebutuhan */
        font-size: 12px; /* Sesuaikan dengan kebutuhan */
    }
            .jumlah input{
                padding:16px 65px;
                width: 10px;
            }
            .jumlah{
                position: relative;
                left:500px;
            }
            .kurang{
                position: relative;
                top:0px;
                left: 42px;
            }
            .tambah{
                position: relative;
                top: 0px;
                left:-46px;
            }
            .pay label{
                position: relative;
                top:-140px;
                left: 470px;
            }
            .pay h4{
                position: relative;
                top: -210px;
                left: 700px;
                color:#999;
            }
            @media(max-width:460px){
                body{
                    margin:0;
                    padding: 0;
                    background-color: #fff;
                    overflow-x: hidden;
                }
                .header {
                    display: none;
                }

                .cart-icon-container {
                    position: fixed;
                    top: 5px; /* Adjust the top distance as needed */
                    right: 20px; /* Adjust the right distance as needed */
                    font-size: 25px;
                    border-radius: 30px;
                    display: flex;
                    align-items: center;
                    padding: 0 5px;
                    z-index: 1000;
                }
                .cart,.apus,.edit{
                    color:white;
                    position: relative;
                    top:4px;
                    background-color:#333;
                    padding:3px;
                    border-radius:30px;
                    font-size:23px;
                }
                .apus{
                    position: relative;
                    left: -40px;
                }
                .edit{
                    position: relative;
                    left: -80px;
                }
                .cart-badge{
                    position: absolute;
                    top:-2px;
                    font-size:12px;
                }
                .main img{
                    width:100%;
                    height:300px;
                }
                .main{
                    margin:0px;
                    width:100%;
                }
                .text-center h3{
                    margin-left:10px;
                    position: relative;
                    font-size: 25px;
                    color:black;
                    bottom:0px;
                }
                .text-center{
                    margin-left:10px;
                    position: relative;
                    font-size: 30px;
                    color:black;
                    bottom:10px;
                    left:5px;
                }
                .jumlah {
                    margin-left:10px;
                    position: relative;
                    font-size: 15px;
                    color:black;
                    left:-60px;
                    padding:5px;
                    font-size: 15px;
                    margin-bottom:30px;
                }
                .beli i{
                    margin-right:10px;
                }
                .kembali{
                    color:#fff;
                    position: relative;
                    bottom:290px;
                    left:20px;
                    font-size:30px;
                    background-color:#333;
                    border-radius:15px;
                }
                .nasi h4{
                    margin-left:10px;
                    position: relative;
                    font-size: 15px;
                    color:black;
                    bottom:-5px;
                    left:5px;
                }
                .pay {
                    position: fixed;
                    bottom: 0;
                    left: 0;
                    width: 100%;
                    background-color: #fff;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
                .pay button{
                    padding:20px;
                    position: relative;
                    left:0px;
                    font-size: 17px;
                    color:#fff;
                    border:none;
                }
                .beli button{
                    width:60%;
                    background-color:darkblue;
                    position: absolute;
                    bottom:-5px;
                }
                .bs{
                    padding-top:20px;
                    position: fixed;
                    bottom:0px;
                    font-size: 17px;
                    color:#fff;
                    background-color:#333;
                    border:none;
                    width:42%;
                    margin-left:236px;
                    left:31px;
                }
                .nasi a{
                    display:block;
                    width:5%;
                }
                .jumlah{
                    position: relative;
                    top:-90px;
                }
            }
            @media (max-width:430px) {
                .beli button{
                    width:60%;
                    background-color:darkblue;
                    position: absolute;
                    bottom:-5px;
                }
                .bs{
                    padding-top:20px;
                    position: fixed;
                    bottom:0px;
                    font-size: 17px;
                    color:#fff;
                    background-color:#333;
                    border:none;
                    width:42%;
                    margin-left:236px;
                    left:13px;
                }
            }
            @media (max-width:440px) {
                .beli button{
                    width:65%;
                    background-color:darkblue;
                    position: absolute;
                    bottom:-5px;
                }
                .bs{
                    padding-top:20px;
                    position: fixed;
                    bottom:0px;
                    font-size: 17px;
                    color:#fff;
                    background-color:#333;
                    border:none;
                    width:42%;
                    margin-left:236px;
                    left:19px;
                }
            }
            @media (max-width:405px) {
                .beli button{
                    width:65%;
                    background-color:darkblue;
                    position: absolute;
                    bottom:-5px;
                    padding-top:30px;
                }
                .bs{
                    padding-top:30px;
                    position: fixed;
                    bottom:0px;
                    font-size: 17px;
                    color:#fff;
                    background-color:#333;
                    border:none;
                    width:42%;
                    margin-left:236px;
                    left:5px;
                }
            }
    </style>
</head>
<body>
    <div class="header">
        <h2>MyFood</h2>
    </div>
    <div class="bg">
        <div class="cart-icon-container">
            <a class="cart" href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <div class="cart-badge"><?php echo $cek; ?></div> 
        </div>
    </div>
    <?php
    if(isset($_SESSION['login']) && isset($_SESSION['level']) && $_SESSION['level'] == 'admin'){
?>
    <div class="cart-icon-container">
        <a class="apus" href="hapusdata.php?id=<?php echo $row[0];?>"><i class="fa-solid fa-trash"></i></a>
    </div>
    <div class="cart-icon-container">
        <a class="edit" href="editdata.php?id=<?php echo $row[0];?>"><i class="fa-solid fa-pen-to-square"></i></a>
    </div>
<?php
    }
?>

    <div class="main">
        <div class="menu-item nasi">
            <form method="post" action="beli.php?id=<?php echo $row[0] ?>" id="productForm">
                <input type="hidden" name="nama" value="<?php echo $row[1]; ?>">
                <input type="hidden" name="gambar" value="<?php echo $row[3]; ?>">
                <input type="hidden" name="harga" value="<?php echo $row[2]; ?>">
                <img src="<?php echo $row[3]; ?>" alt="<?php echo $row[1]; ?>" width="300">
                <a class="kembali" href="index.php"><i class="fa-solid fa-arrow-left"></i></a>
                <div class="cart-body">
                    <div class="text-center">
                        <h3 class="fw-bolder" name="nama"><?php echo $row[1] ?></h3>
                        <p name="harga">Rp<?php echo number_format($row[2], 2, ',', '.') ?></p>
                    </div>
                    <div class="pay">
                        <input type="hidden" name="product_id" value="<?php echo $row[0] ?>">
                        <label for="quantity">Kuantitas:</label>
                        <div class="jumlah">
                            <button type="button" class="kurang" onclick="decrement()">-</button>
                            <input type="text" id="quantity" name="quantity" class="kuan" value="1" readonly>
                            <button type="button" class="tambah" onclick="increment()">+</button>
                        </div>
                        <h4>Tersisa <?php echo $row[5];?> Buah</h4>
                    </div>
                    <div class="co">
                        <div class="beli">
                            <input type="hidden" id="checkProductInCart" name="check_product_in_cart" value="0">
                            <button type="submit" name="ms"><i class="fa-solid fa-cart-shopping"></i>Masukkan Keranjang</button>
                            <button class="bs" type="submit" name="beli" id="beli">Beli Sekarang</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
            <h4><?php echo $row[4]?></h4>
        </div>
    </div>
    <script>
        function buyNow() {
            // Set the hidden input value to indicate that the product should be checked in the cart
            document.getElementById('checkProductInCart').value = '1';

            // Submit the form
            document.getElementById('productForm').submit();
        }
    function increment() {
        var quantityInput = document.getElementById('quantity');
        quantityInput.value = parseInt(quantityInput.value) + 1;
    }

    function decrement() {
        var quantityInput = document.getElementById('quantity');
        var currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    }
        
    </script>
</body>
</html>
