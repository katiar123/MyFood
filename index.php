<?php
    include "koneksi.php";
    $sql = mysqli_query($koneksi,"SELECT * FROM produk");

    session_start();

    if (isset($_SESSION['login'])) {
        $status = "LOG OUT";
    }   
    else {
        $status = "LOG IN";
    }

    $jumlahBarang = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

    $userId = isset($_SESSION['user']) ? $_SESSION['user'] : null;
    $jumlah = mysqli_query($koneksi,"SELECT * FROM keranjang WHERE user_id='$userId'");
    $cek = mysqli_num_rows($jumlah);
    
    if(isset($_POST['cari'])){ // Mengubah 'car' menjadi 'cari'
        $input = $_POST['cari'];
        $cari = mysqli_query($koneksi,"SELECT * FROM produk WHERE nama LIKE '%$input%'");
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f0f0f0;
        }

        /* Navigation styles */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 15px;
            position: fixed;
            width:100%;
            z-index: 3;
        }

        .navbar h1 {
            color: #fff;
            margin-left:50px;
        }

        .nav-links {
            list-style: none;
            display: flex;
        }

        .nav-links li {
            margin-right: 20px;
        }

        .nav-links a {
            text-decoration: none;
            margin-right:10px;
            color: #fff;
        }
        .menu-toggle {
            display: none;
            font-size: 24px;
            color: #fff;
            cursor: pointer;
            margin:0 550px;
        }
        .konten img{
            width: 100%;
            height:500px;
        }
            .iklan a{
                font-size: 80px;
                color: white;
                border: 1px solid;
                padding:5px;
            }
            .next{
                position: relative;
                bottom:358px;
                left:1180px;
                z-index:2;
            }
            .prev{
                position: relative;
                bottom:250px;
                left:1115px;
                z-index:2;
            }
            .cart{
                color: white;
                margin-top:10px;
                margin-left:400px;
                font-size: 35px;
            }
            .navbar h1 {
                color: #fff;
                position: relative;
                bottom: 5px;
            }
            .main {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start; /* Change to flex-start to keep items in one row */
        margin: 20px;
    }

    .menu-item {
        width: calc(25% - 30px); /* Set the width to 25% for four items in a row */
        margin-bottom: 20px;
        margin-left: 15px; /* Adjust as needed */
        box-sizing: border-box;
    }


            .menu-item img {
                width: 100%;
                border-radius: 10px;
                height: 140px;
            }

            .menu-item .cart-body {
                margin-top: 10px;
            }
            .text-center{
                color:#fff;
                margin-left:10px;
                position: relative;
                right:10px;
                bottom: 0px;
                font-size: 18px;
            }
            
            .nasi, .soto, .sate {
                width: 23%; 
                height: 280px; 
                margin-right: 10px;
                background-color: #333; 
                padding:20px;
                text-align: center;
                border-radius: 10px;
                text-decoration:none;
            }

            .nasi img, .soto img, .sate img {
                width: 115.5%;
                border-radius: 10px;
                height: 180px; 
                margin-right: 0;
                border-radius: 10px;
                position: relative;
                bottom:20px;
                right:20px;
            }
            .iklan::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 83.5%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1;
            }
            .iklan{
                position: relative;
                top:80px;
                margin-bottom:20px;
            }        
            footer {
                background-color: #333;
                color: #fff;
                text-align: center;
                padding: 30px;
                position: relative;
                bottom: 0;
                width: 100%;
        }

        /* Additional styling for links in the footer */
        footer a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            text-decoration: underline;
        }
        .login{
            text-decoration: none;
            color: #fff;
            font-size:14px;
            position: absolute;
            top: 10px;
            right:20px;
        }
        .cart-icon-container {
        position: relative;
        display: inline-block;
        padding:10px;
    }

    .cart-badge {
        position: absolute;
        top: 0px;
        right: 0;
        background-color: red; /* Warna latar belakang bulatan */
        color: white;
        border-radius: 50%;
        padding: 4px 8px; /* Sesuaikan dengan kebutuhan */
        font-size: 12px; /* Sesuaikan dengan kebutuhan */
    }
    .plus{
        position: absolute;
        right:180px;
        top: 25px;
        font-size:35px;
    }
    .cari{
        width: 700px;
        position: absolute;
        left:300px;
        height:38px;
        padding:0 40px;
        font-size:17px;
    }
    .cari::placeholder{
        padding: 2px;
        font-size:17px;
    }
    .car{
        position: relative;
        left: 543px;
        top:2px;
    }
    .btn{
        padding: 7px 25px;
        font-size:16px;
        background-color:#333;
        color:white;
        border:none;
    }
    .dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #333;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    min-width: 160px;
    z-index: 3;
    border-radius: 5px;
}

.dropdown-content a {
    color: #fff;
    padding: 20px 30px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #555;
}

.dropdown:hover .dropdown-content {
    display: block;
}



.dropdown a.head:hover {
    background-color: #555;
}

        @media (max-width: 460px) {
            .navbar {
                flex-direction: column;
                align-items: center;
                height: 100px;
            }

            .cart-icon-container {
                order: -1; /* Move the cart icon container to the top */
                position: relative;
                right: 40px;
                top:20px;
            }
            .cart{
                font-size:28px;
            }

            .nav-links.show {
                display: flex;
            }

            .nav-links li {
                margin-right: 0;
                margin-bottom: 10px;
            }

            .konten img{
                width: 100%;
                height:200px;
            }
            .iklan a{
                font-size: 30px;
                color: white;
                border: 1px solid;
                padding:5px;
            }
            .next{
                position: relative;
                bottom:138px;
                left:370px;
            }
            .prev{
                position: relative;
                bottom:90px;
                left:335px;
            }
            .text-center{
                color:#fff;
                margin-left:10px;
                position: relative;
                right:10px;
                bottom: px;
                font-size: 14px;
            }
            .navbar h1 {
                color: #fff;
                margin-left: 50px;
                font-size:28px;
                position: relative;
                bottom: 25px;
                right: 145px;
            }
            .cari{
                display:none;
            }
            .menu-item img{
                width: 130%;
                object-fit:cover;
                height:180px;
                position: relative;
                left:-17px;
                top:-15px;
            }
            .menu-item {
                width: calc(47% - 30px); /* Two items side by side on smaller screens with some margin */
                margin-left: 30px; /* Remove margin for small screens */
            }
            .plus{
                position: absolute;
                right:80px;
                top: 40px;
                font-size:35px;
            }
            footer{
                display:none;
            }
            .our{
                position: relative;
                top:50px;
                margin-bottom:90px;
            }
        }    
        @media (max-width:440px) {
            .next{
                position: relative;
                bottom:138px;
                left:350px;
            }
            .prev{
                position: relative;
                bottom:90px;
                left:315px;
            }
            
        }
        @media (max-width:405px) {
            .next{
                position: relative;
                bottom:138px;
                left:330px;
            }
            .prev{
                position: relative;
                bottom:90px;
                left:295px;
            }
            .menu-item img{
                width: 136%;
                object-fit:cover;
                height:180px;
                position: relative;
                left:-17px;
                top:-15px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar" id="navbar">
        <h1>MyFood</h1>
        <form action="" method="post">
            <input type="text" name="cari" class="cari" placeholder="Martabak Manis">
            <span class="car"><b><button type="submit" name="cari" class="btn"><i class="fa-solid fa-magnifying-glass"></i></button></b></span>
        </form>
        <div class="cart-icon-container">
            <a class="cart" href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <div class="cart-badge"><?php echo $cek; ?></div>   
        </div>
        <div class="menu-toggle" onclick="toggleMenu()">&#9776;</div>
        <ul class="nav-links">
            <?php
            if(isset($_SESSION['login'])){
                if($_SESSION["level"] == "admin"){
                    ?>
                    <li><a class="plus" href="tambahdata.php"><i class="fa-solid fa-circle-plus"></i></a></li>
                    <?php
                    }
                    ?>
                <?php
            }
            ?>
            <li class="login"style="margin-right:100px;"><?php 
            if(isset($_SESSION['login'])){
                echo $_SESSION['nama'];
            }
            else{
                echo "";
            }?></li>
            <li >
                    <b>
                        <a class="login" id="loginButton"  
                            <?php
                                if(!isset($_SESSION['login'])){
                                    echo "href='login.php'";
                                    $jumlahBarang = 0; 
                                }
                                else{
                                    echo "href='javascript:void(0);' onclick='konfirmasiLogout()'";
                                    $jumlahBarang = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                                }
                            ?>>
                            <?php echo $status ?>
                        </a>
                    </b>
                </div>
            </li>
        </ul>
        
    </div>
    <br>
    <br>
    <div class="iklan">
        <div class="konten" id="konten">
            <img src="https://www.teakpalace.com/image/catalog/artikel/gambar-makanan-paling-enak-sate-kambing.jpg">
            <img src="https://www.teakpalace.com/image/catalog/artikel/gambar-makanan-paling-enak-soto-kudus.jpg">
            <img src="https://www.teakpalace.com/image/catalog/artikel/gambar-makanan-paling-enak-Rendang-Padang-Asli-Minang.jpg">
        </div>
        <a href="#navbar" class="next" onclick="clickNext()"><i class="fa-solid fa-chevron-right"></i></a>
        <a href="#navbar" class="prev" onclick="clickPrev()"><i class="fa-solid fa-chevron-left"></i></a>
    </div>
    <h2 class="our"><center>Our Menu</center></h2>
    
    <div class="menu" id="menu">
        <div class="main">
            <?php
                while ($row = mysqli_fetch_array($sql)){
                    if($row[5] > 0){
            ?>
            <a class="menu-item nasi" href="kedua.php?id=<?php echo $row[0]?>">
                <img src="<?php echo $row[3]?>">
                <div class="cart-body">
                    <div class="text-center">
                        <h5 class="fw-bolder"><?php echo $row[1]?></h5>
                        Rp<?php echo number_format($row[2], 2, ',', '.')
                        ?>
                    </div>  
                </div>
            </a>    
            <?php
                }
                else{
                    $productId = $row[0];
                    mysqli_query($koneksi, "DELETE FROM keranjang WHERE produk_id = " . $productId);
                    mysqli_query($koneksi, "DELETE FROM produk WHERE id = " . $productId);
                }
            }
            ?>          
        </div>
    </div>
    <footer>
        <p>&copy; 2024 MyShop. All rights reserved. | Designed by <a href="https://instagram.com/katiarwdhi?igshid=OGQ5ZDc2ODk2ZA==" target="_blank">Katiar Wadhi</a></p>
    </footer>
    <script>
        const images = document.querySelectorAll('.konten img');
        let currentImageIndex = 0;
        let isLoggedIn = false;

        function showImage(index) {
            images.forEach((img, i) => {
                if (i === index) {
                    img.style.display = 'block';
                } else {
                    img.style.display = 'none';
                }
            });
        }

        function clickPrev() {
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            showImage(currentImageIndex);
        }

        function clickNext() {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            showImage(currentImageIndex);
        }
        function autoSlide() {
            clickNext(); 
        }    
        setInterval(autoSlide, 5000);
    
        showImage(currentImageIndex);
        showImage(currentImageIndex);

        function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            navLinks.classList.toggle('show');
        }
        function konfirmasiLogout() {
        var konfirmasi = confirm("Apakah Anda yakin ingin logout?");
        if (konfirmasi) {
            alert("Anda telah logout.");
            isLoggedIn = false;
            window.location.href = 'logout.php';
        } else {
            alert("Logout dibatalkan.");
        }
    }
    function konfirmasiLogout() {
        var konfirmasi = confirm("Apakah Anda yakin ingin logout?");
        if (konfirmasi) {
            alert("Anda telah logout.");
            isLoggedIn = false;
            window.location.href = 'logout.php';
        } else {
            alert("Logout dibatalkan.");
        }
    }
    function updateCartBadge() {
            const cartBadge = document.getElementById('cartBadge');
            const jumlahBarangPHP = <?php echo $jumlahBarang; ?>;

            cartBadge.innerHTML = jumlahBarangPHP;
        }

        // Pemanggilan fungsi saat halaman dimuat
        updateCartBadge();
    </script>
</body>
</html>
