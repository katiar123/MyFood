<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login'])) {
    header("location:login.php");
    exit();
}

$userId = $_SESSION['user'];
$resultCart = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE user_id = '$userId'");

$jumlahBarang = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

$produkId = isset($_SESSION["id"]) ? $_SESSION["id"] : null;
$cek = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = '$produkId'");

if(isset($_POST['pilih'])){
    $nama = $_POST['nama'];
    $gambar = $_POST['gambar'];
    $harga = $_POST['harga'];
    mysqli_query($koneksi, "INSERT INTO beli(user_id,produk_id, nama, gambar, harga, kuantitas) VALUES ('$userId','$produkId','$nama','$gambar','$harga','$kuantitas')");
}

$_SESSION['banyak'] = isset($_POST['pilih?']) ? $_POST['pilih'] : null;

$userId = isset($_SESSION['user']) ? $_SESSION['user'] : null; // Tambahkan pemeriksaan isset
$jumlah = mysqli_query($koneksi,"SELECT * FROM keranjang WHERE user_id='$userId'");
$jum = mysqli_num_rows($jumlah);


$totalHarga = 0;
if(isset($_POST['update'])){
    $nama = $_POST['nama'];
        $userId = $_SESSION['user'];
        $produkId = $_SESSION['id'];
        $kuantitas = $_POST['titas'];
        $cartCheck = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE user_id='$userId' AND nama='$nama'");
        if (mysqli_num_rows($cartCheck) > 0) {
            // Jika produk sudah ada, update kuantitas
                mysqli_query($koneksi, "UPDATE keranjang SET kuantitas='$kuantitas' WHERE user_id='$userId' AND nama='$nama'");
            
        } else {
            // Jika produk belum ada, tambahkan ke dalam tabel keranjang
            mysqli_query($koneksi, "INSERT INTO keranjang(user_id,produk_id, nama, gambar, harga, kuantitas) VALUES ('$userId','$produkId','$nama','$gambar','$harga','$kuantitas')");
        }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Keranjang Belanja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: left;
        }
        .header h2{
            margin-left:30px;
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
        }

        .cart-item img {
            width: 100px;
            margin-right: 10px;
            position: relative;
            left:60px;
        }

        .cart-item h3 {
            margin-right: 20px;
            flex: 1; 
            position: relative;
            left:130px;
        }

        .harga, .quan, .total {
            width: 110px; /* Menentukan lebar agar sejajar */
            margin-right: 30px;
            position: relative;
            right: 60px;
        }
        .harga{
            margin-right:140px;
        }
        .quan{
            margin-right:110px;
            position: relative;
            left:60px;
        }
        .quantity{
            width:20px;
            border:none;
            position: relative;
            left:-40px;
            background:none;
        }
        .tambah{
            position: relative;
            top:0px;
            left:-40px;
            padding:5px 8px;
            color:white;
            background-color:#333;
            border:none;
        }
        .update{
            position: relative;
            left: -40px;
            padding:5px 8px;
            color:white;
            background-color:#333;
            border:none;
        }
        .kurang{
            position: relative;
            top: 0px;
            left:-50px;
            padding:6px 11px;
            color:white;
            background-color:#333;
            border:none;
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
            right:30px;
        }
        .jumlah{
            position: relative;
            right:40px;
        }
        .all{
            background-color:#fff;
            position: fixed;
            width:80%;
            top:550px;
            margin-left:130px;
            padding:30px;
            width:76%;
        }
        .all input[type="checkbox"] {
            transform: scale(2.5); /* Sesuaikan skala sesuai kebutuhan */
            margin-right: 15px; /* Tambahkan margin agar checkbox tidak terlalu dekat dengan teks */
        }
        .co{
            position: relative;
            top:-65px;
            left:900px;
            padding:10px 30px;
            font-size:16px;
            color:white;
            background-color:#333;
            border:none;
        }
        .all h2{
            position: relative;
            top:-20px;
            left:650px;
        }
        .all h3{
            position: relative;
            top:-15px;
            left:670px;
        }
        .pilih{
            transform: scale(2.0); 
            margin-right: 40px;
            margin-left:10px;
            position: relative;
            left:-650px;
        }
        .kembali{
            display:none;
        }
        .kecil{
            display:none;
        }
        .co span{
            display:none;
        }
        .ct{
                position: relative;
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
                left:-50px;
            }
            .kecil{
                display:block;
                position: relative;
                top:-58px;
                right:-30px;
                font-size:22px;
            }
            .judul{
                display:none;
            }
            .cart-item{
                margin-left:5px;
                margin-right:5px;
                width:98%;
                height: 110px;
                position: relative;
            }
            .pilih{
                transform: scale(1.8); 
                margin-right: 40px;
                margin-left:10px;
                position: relative;
                left: 10px;
            }
            .cart-item h3{
                position: relative;
                top: -25px;
                left:15px;
            }
            .harga{
                position: relative;
                top:-60px;
                left:190px;
            }
            .quan{
                position: relative;
                top: -85px;
                left: 190px;
            }
            .total{
                position: relative;
                left: 80px;
                top: -80px;
                border:none;
            }
            .all {
                margin-left:0;
                position: fixed;
                z-index: 3;
                width:100%;
            }
            .all h2{
                position: relative;
                top:-35px;
                left:180px;
                font-size:20px;
            }
            .all h3{
                display:none;
            }
            .co{
                position: relative;
                top:-90px;
                left:290px;
                padding:20px 10px;
                font-size:14px;
                color:white;
                background-color:#333;
                border:none;
            }
            .all input[type="checkbox"] {
                transform: scale(2.0); /* Sesuaikan skala sesuai kebutuhan */
                margin-right: 15px; /* Tambahkan margin agar checkbox tidak terlalu dekat dengan teks */
            }
            .co span{
                display:inline-block;
            }   
            .ct{
                margin-top:75px;
                margin-bottom:85px;
                overflow-x:hidden;
            }
            .cart-item img{
                height:80px;
            }
        }
        @media (max-width:420px) {
            .cart-item{
                margin-left:0px;
                margin-right:5px;
                width:98%;
                height: 100px;
                position: relative;
            }
            .total{
                position: relative;
                left: 60px;
                top: -70px;
                border:none;
                background:none;
            }
            .all {
                margin-left:0;
                z-index: 3;
                width:100%;
                margin-top:135px;
            }
            .all h2{
                position: relative;
                top:-35px;
                left:150px;
                font-size:17px;
            }
            .all h3{
                display:none;
            }
            .co{
                position: relative;
                top:-80px;
                left:250px;
                padding:15px 5px;
                font-size:14px;
                color:white;
                background-color:#333;
                border:none;
            }
            .all input[type="checkbox"] {
                transform: scale(2.0); /* Sesuaikan skala sesuai kebutuhan */
                margin-right: 15px; /* Tambahkan margin agar checkbox tidak terlalu dekat dengan teks */
            }
        }
    </style>
</head>

<body>
    <div class="header">
    <a class="kembali" href="index.php"><i class="fa-solid fa-arrow-left"></i></a>
        <h2 class="besar">MyFood | Keranjang Belanja</h2>
        <h2 class="kecil">Keranjang Saya</h2>
    </div>
    <div class="judul">
        <h4 class="produk">Produk</h4>
        <h4 class="nama">Nama</h4>
        <h4 class="harg">Harga</h4>
        <h4 class="jumlah">Kuantitas</h4>
        <h4 class="total">Aksi</h4>
    </div>
    <div class="ct">
    <?php
    if(mysqli_num_rows($cek) > 0){
        if (mysqli_num_rows($resultCart) == 0) {
            echo "<p><center>Keranjang belanja kosong.</center></p>";
        } else {
            while ($productDetails = mysqli_fetch_array($resultCart)) {
                $isChecked = ($produkId == $productDetails[2]) ? 'checked' : '';
                $totalHarga += $productDetails['harga'] * $productDetails['kuantitas'];
        ?>
                <div class="cart-item" data-product-id="<?php echo $productDetails[0]; ?>" id="form1">
                    <img src="<?php echo $productDetails[4]; ?>" name="gambar" alt="<?php echo $productDetails[3]; ?>" width="100">
                        <h3><?php echo $productDetails[3]; ?></h3>
                        <p class="harga">Rp<?php echo number_format($productDetails[5], 2, ',', '.'); ?></p>
                        <div class="jumlah">
                        <form action="beli.php" method="post">
                        <input type="checkbox" name="pilih[]" class="pilih" id="pilih" value="<?php echo $productDetails[2];?>">
                            <input type="hidden" name="nama" value="<?php echo $productDetails[3]; ?>">
                            <input type="hidden" name="id" value="<?php echo $productDetails[0]; ?>">
                            <button type="button" class="kurang" name="kurang" onclick="decrementQuantity(this)"><b>-</b></button>
                            <input type="text" class="quantity" name="titas" value="<?php echo $productDetails[6]; ?>" readonly>
                            <button type="button" name="tambah" class="tambah" onclick="incrementQuantity(this)"><b>+</b></button>
                            <button type="submit" name="kirim" class="update">UPDATE</button>
                        
                        </div>
                        <a class="total" href="hapus.php?id=<?php echo $productDetails[0]?>">hapus</a>
                </div>
    <?php
            }
        }
    }
    ?>
    </div>


    <div class="all">
        <h3 id="totalProduk">Total(0 produk)</h3>
            <input type="hidden" name="nama" value="<?php echo $row[1]; ?>">
            <input type="hidden" name="gambar" value="<?php echo $row[3]; ?>">
            <input type="hidden" name="harga" value="<?php echo $row[2]; ?>">
            <input type="hidden" name="kuan" value="<?php echo $row[6]; ?>">
            <button type="submit" name="co" class="co" onclick="submitForms()"><b>Check Out <span id="total">(0)<span></b></button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var checkboxSemua = document.querySelector('.semua');
            var checkboxProduk = document.querySelectorAll('.pilih');

            checkboxSemua.addEventListener('change', function () {
                for (var i = 0; i < checkboxProduk.length; i++) {
                    checkboxProduk[i].checked = this.checked;
                }
            });

            for (var i = 0; i < checkboxProduk.length; i++) {
                checkboxProduk[i].addEventListener('change', function () {
                    checkboxSemua.checked = document.querySelectorAll('.pilih:checked').length === checkboxProduk.length;
                });
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            var checkboxSemua = document.querySelector('.semua');
            var checkboxProduk = document.querySelectorAll('.pilih');
            var totalHargaElem = document.getElementById('totalHarga');
            var totalProdukElem = document.getElementById('totalProduk');

            function updateTotal() {
                var totalHarga = 0;
                var totalProduk = 0;
                var adaProdukDipilih = false;

                for (var i = 0; i < checkboxProduk.length; i++) {
                    if (checkboxProduk[i].checked) {
                        var cartItem = checkboxProduk[i].closest('.cart-item');
                        var harga = parseFloat(cartItem.querySelector('.harga').innerText.replace('Rp', '').replace(',', ''));
                        var kuantitas = parseInt(cartItem.querySelector('.quan').innerText);

                        totalHarga += harga * kuantitas;
                        totalProduk++;
                        adaProdukDipilih = true;
                    }
                }

                totalHargaElem.innerText = adaProdukDipilih ? 'Rp' + totalHarga.toFixed(3) : 'Rp0';
                totalProdukElem.innerText = 'Total(' + totalProduk + ' produk)';
                updateTotalPosition();
            }

            function updateTotalPosition() {
                var screenWidth = window.innerWidth;
                if (screenWidth <= 460) {
                    // Update position for small screens
                    totalHargaElem.style.position = 'relative';
                    totalHargaElem.style.left = '0';
                    totalProdukElem.style.position = 'relative';
                    totalProdukElem.style.left = '0';
                } else {
                    // Reset position for larger screens
                    totalHargaElem.style.position = '';
                    totalHargaElem.style.left = '';
                    totalProdukElem.style.position = '';
                    totalProdukElem.style.left = '';
                }
            }

            window.addEventListener('resize', updateTotalPosition);

            checkboxSemua.addEventListener('change', function () {
                for (var i = 0; i < checkboxProduk.length; i++) {
                    checkboxProduk[i].checked = this.checked;
                }
                updateTotal();
            });

            for (var i = 0; i < checkboxProduk.length; i++) {
                checkboxProduk[i].addEventListener('change', function () {
                    checkboxSemua.checked = document.querySelectorAll('.pilih:checked').length === checkboxProduk.length;
                    updateTotal();
                });
            }
        });

    document.addEventListener("DOMContentLoaded", function () {
        var checkboxSemua = document.querySelector('.semua');
        var checkboxProduk = document.querySelectorAll('.pilih');
        var totalHargaElem = document.getElementById('totalHarga');
        var totalProdukElem = document.getElementById('total');

        function updateTotal() {
            var totalHarga = 0;
            var totalProduk = 0;
            var adaProdukDipilih = false;

            for (var i = 0; i < checkboxProduk.length; i++) {
                if (checkboxProduk[i].checked) {
                    var cartItem = checkboxProduk[i].closest('.cart-item');
                    var harga = parseFloat(cartItem.querySelector('.harga').innerText.replace('Rp', '').replace(',', ''));
                    var kuantitas = parseInt(cartItem.querySelector('.quan').innerText);

                    totalHarga += harga * kuantitas;
                    totalProduk++;
                    adaProdukDipilih = true;
                }
            }

            totalHargaElem.innerText = adaProdukDipilih ? 'Rp' + totalHarga.toFixed(3) : 'Rp0';
            totalProdukElem.innerText = '(' + totalProduk + ')';
        }


        checkboxSemua.addEventListener('change', function () {
            for (var i = 0; i < checkboxProduk.length; i++) {
                checkboxProduk[i].checked = this.checked;
            }
            updateTotal();
        });

        for (var i = 0; i < checkboxProduk.length; i++) {
            checkboxProduk[i].addEventListener('change', function () {
                checkboxSemua.checked = document.querySelectorAll('.pilih:checked').length === checkboxProduk.length;
                updateTotal();
            });
        }
    });

    function updateCartBadge() {
        const cartBadge = document.querySelector('.cart-badge');
        const jumlahBarangPHP = <?php echo $jumlahBarang; ?>; // Ambil jumlah barang dari PHP

        // Update nilai di bagian HTML menggunakan JavaScript
        cartBadge.innerHTML = jumlahBarangPHP;
    }

    // Panggil fungsi untuk memperbarui jumlah item di keranjang saat halaman dimuat
    updateCartBadge();

    function validateForm() {
        var checkboxes = document.querySelectorAll('.pilih:checked');
        
        // Check if at least one checkbox is checked
        if (checkboxes.length === 0) {
            alert('Pilih setidaknya satu untuk melanjutkan');
            return false; // Prevent form submission
        }
        
        // If checkboxes are checked, allow form submission
        return true;
    }
    document.addEventListener("DOMContentLoaded", function () {
    // ...

    for (var i = 0; i < checkboxProduk.length; i++) {
        checkboxProduk[i].addEventListener('change', function () {
            checkboxSemua.checked = document.querySelectorAll('.pilih:checked').length === checkboxProduk.length;
            updateTotal();
            updateSelectedProductsInput();
        });
    }
});

function updateSelectedProductsInput() {
    var selectedProductIds = [];
    for (var i = 0; i < checkboxProduk.length; i++) {
        if (checkboxProduk[i].checked) {
            var cartItem = checkboxProduk[i].closest('.cart-item');
            var productId = cartItem.getAttribute('data-product-id');
            selectedProductIds.push(productId);
        }
    }
    document.getElementById('selectedProductsInput').value = selectedProductIds.join(',');
}
function increment() {
    var quantityElement = document.querySelector('.quantity');
    var currentValue = parseInt(quantityElement.innerText);
    quantityElement.innerText = currentValue + 1;
}

function decrement() {
    var quantityElement = document.querySelector('.quantity');
    var currentValue = parseInt(quantityElement.innerText);
    if (currentValue > 1) {
        quantityElement.innerText = currentValue - 1;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    // ...

    for (var i = 0; i < checkboxProduk.length; i++) {
        checkboxProduk[i].addEventListener('change', function () {
            checkboxSemua.checked = document.querySelectorAll('.pilih:checked').length === checkboxProduk.length;
            updateTotal();
            updateSelectedProductsInput();
        });
    }
});

function updateSelectedProductsInput() {
    var selectedProductIds = [];
    var selectedQuantities = [];
    for (var i = 0; i < checkboxProduk.length; i++) {
        if (checkboxProduk[i].checked) {
            var cartItem = checkboxProduk[i].closest('.cart-item');
            var productId = cartItem.getAttribute('data-product-id');
            var quantity = cartItem.querySelector('.quantity').value;

            selectedProductIds.push(productId);
            selectedQuantities.push(quantity);
        }
    }
    document.getElementById('selectedProductsInput').value = selectedProductIds.join(',');
    document.getElementById('selectedQuantitiesInput').value = selectedQuantities.join(',');
}
function submitForms() {
            var formData1 = new FormData(document.getElementById("form1"));
            var formData2 = new FormData(document.getElementById("form2"));

            // Gabungkan data dari kedua formulir
            for (var pair of formData2.entries()) {
                formData1.append(pair[0], pair[1]);
            }

            // Kirim data ke server atau lakukan tindakan lainnya
            // Misalnya, menggunakan Fetch API untuk mengirim data ke server
            fetch('beli.php', {
                method: 'POST',
                body: formData1
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response from server:', data);
                // Handle response dari server
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    function incrementQuantity(button) {
        var quantityInput = button.parentNode.querySelector('.quantity');
        quantityInput.value = parseInt(quantityInput.value) + 1;
        updateTotal(); // Update total saat mengubah kuantitas
        updateSelectedProductsInput(); // Update input terpilih saat mengubah kuantitas
    }

    function decrementQuantity(button) {
        var quantityInput = button.parentNode.querySelector('.quantity');
        var currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            updateTotal(); // Update total saat mengubah kuantitas
            updateSelectedProductsInput(); // Update input terpilih saat mengubah kuantitas
        }
    }

    </script>
</body>
</html>
