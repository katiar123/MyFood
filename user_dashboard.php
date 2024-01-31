<?php
session_start();

if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'user') {
    include "koneksi.php";
    $sql = mysqli_query($koneksi,"SELECT * FROM produk");

    if (isset($_SESSION['login'])) {
        $status = "LOG OUT";
    }   
    else {
        $status = "LOG IN";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Shop</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
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
            padding: 25px;
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
                margin-top:0px;
                margin-left:650px;
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
                justify-content: space-between;
                margin: 20px;
            }

            .menu-item {
                width: calc(50% - 20px); /* 50% width with a little space between items */
                margin-bottom: 20px;
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
                width: 30%; 
                height: 280px; 
                margin-right: 10px;
                background-color: #333; 
                padding:20px;
                text-align: center;
                border-radius: 10px;
                text-decoration:none;
            }

            .nasi img, .soto img, .sate img {
                width: 135%;
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
            margin-right:10px;
            color: #fff;
            margin-right:10px;
        }
        @media (max-width: 445px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
                padding: 20px;
                position: fixed;
                z-index: 3;
                overflow: hidden;
            }

            .nav-links {
                display: none;
                flex-direction: column;
                width: 100%;
                margin-top: 20px;
            }

            .nav-links.show {
                display: flex;
            }

            .nav-links li {
                margin-right: 0;
                margin-bottom: 10px;
            }

            .menu-toggle {
                display: block;
                margin-top: -34px;
                margin-left: 325px;
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
                left:340px;
            }
            .prev{
                position: relative;
                bottom:90px;
                left:305px;
            }
            .cart{
                color: white;
                margin-top:-35px;
                margin-left:285px;
                font-size: 25px;
            }
            .navbar h1 {
                color: #fff;
                position: relative;
                bottom: 5px;
                right: 50px;
            }
            .main {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                margin: 200px;
            }

            .menu-item {
                width: calc(50% - 20px); /* 50% width with a little space between items */
                margin-bottom: 20px;
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
                font-size: 11px;
            }
            .nasi,.soto,.sate{
                background-color: #333;
                padding:20px;
                text-align: center;
                width: 45%;
                border-radius: 10px;
                height: 220px;
                text-decoration: none;
            }
            .nasi img,.soto img,.sate img{
                width: 135%;
                border-radius: 10px;
                height:140px;
                margin-right:200px;
                position: relative;
                bottom:20px;
                right:20px;
            }
            .iklan{
                position: relative;
                top:50px;
                margin-bottom:20px;
            }
            .login{
                text-decoration: none;
                margin-right:10px;
                color: #fff;
                cursor: pointer;
            }   
        }   
    </style>
</head>
<body>
    <div class="navbar">
        <h1>MyShop</h1>
        <a  class="cart" href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
        <div class="menu-toggle" onclick="toggleMenu()">&#9776;</div>
        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#menu">Shop</a></li>
            <li><b><a class="login" id="loginButton"  href="<?php 
            if(isset($_SESSION["login"])){
                echo "logout.php";
            }
            else{
                echo "login.php";
            }
            ?>"><?php echo $status ?></a></b></li>

        </ul>
        
    </div>
    <br>
    <br>
    <div class="iklan">
        <div class="konten" id="konten">
            <img src="https://www.teakpalace.com/image/catalog/artikel/gambar-makanan-paling-enak-tuna-nasi-goreng.jpg">
            <img src="https://www.teakpalace.com/image/catalog/artikel/gambar-makanan-paling-enak-sate-kambing.jpg">
            <img src="https://www.teakpalace.com/image/catalog/artikel/gambar-makanan-paling-enak-soto-kudus.jpg">
            <img src="https://www.teakpalace.com/image/catalog/artikel/gambar-makanan-paling-enak-Rendang-Padang-Asli-Minang.jpg">
        </div>
        <a href="#konten" class="next" onclick="clickNext()"><i class="fa-solid fa-chevron-right"></i></a>
        <a href="#konten" class="prev" onclick="clickPrev()"><i class="fa-solid fa-chevron-left"></i></a>
    </div>
    <h2><center>Our Menu</center></h2>
    
    <div class="menu" id="menu">
        <div class="main">
            <?php
                while ($row = mysqli_fetch_array($sql)){
            ?>
            <a class="menu-item nasi" href="kedua.php?id=<?php echo $row[0]?>">
                <img src="<?php echo $row[3]?>">
                <div class="cart-body">
                    <div class="text-center">
                        <h5 class="fw-bolder"><?php echo $row[1]?></h5>
                        Rp<?php echo number_format($row[2], 2, ',', '.')?>
                    </div>  
                </div>
            </a>
            <?php
                }
            ?>          
        </div>
    </div>
    <footer>
        <p>&copy; 2023 Your Website Name. All rights reserved. | Designed by <a href="https://instagram.com/katiarwdhi?igshid=OGQ5ZDc2ODk2ZA==" target="_blank">Katiar Wadhi</a></p>
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

    </script>
</body>
</html>
<?php  
} else {
    header('Location: login.php');
    exit();
}
?>
