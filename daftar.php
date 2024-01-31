<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyFood | Log in</title>
    <script src="path/ke/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="path/ke/sweetalert2.min.css">
    <link rel="icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR9338cZcWjwN2xVkO7MMfMV-O3G6XAbnRF9w&usqp=CAU" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            .header h3{
                position: relative;
                bottom:14px;
                left:200px;
                color: #fff;
                text-align: left;
            }
            .header h2{
                position: relative;
                bottom:-10px;
                left:80px;
                color: #fff;
                text-align: left;
            }
            .header a{
                display: none;
            }
            .header{
                background-color: #333;
                width: 1200%;
                padding: 10px;
                overflow: hidden;
            }
            .container {
                text-align: center;
            }

            .login-box {
                background-color: #fff;
                border: 1px solid #ccc;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                width: 300px;
                position: relative;
                left: 900px;
                top:-530px;
                height:440px;
            }
            .login-box form input {
                width: 90%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 3px;
            }
            .input{
                margin-top:40px;
            }
            .username span {
                display:none ;              
            }

            .password i {
                display: none;
            }
            .login-box h3{
                margin-top: 20px;
                text-align: left;
            }
            .signup {
                color: #999;
                font-size: 16px;
                margin-top: 20px;
            }

        .signup a {
            color: #333;
            text-decoration: none;
        }
        .fa{
            position: absolute;
            right: 550px;
            transform: translate(0,-50%);
            top: 333px;
            cursor: pointer;
        }
        .login-box form button {
        width: 100%;
        padding: 10px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 3px;
        margin-top: 10px;
        cursor: pointer;
        }
        input[type="checkbox"]{
                position: absolute;
                top: 51%; 
                right: 155px;
                transform: translate(0, -50%);
            }
            .rmb{
                position: relative;
                right: 80px;
            }
            img{
                width:120%;
                height:570px;
                overflow: hidden;
            }
        @media(max-width:480px){
            .header h2{
                display: none;
            }
            body{
                margin:0;
                padding: 0;
                background-color: #fff;
                overflow-x: hidden;
            }
            .header h3{
                position: relative;
                bottom:-2px;
                left:70px;
                color: #fff;
            }
            .header a{
                display: block;
                position: absolute;
                font-size: 25px;
                top: 5%;
                left: 35px;
                transform: translate(0, -50%);
                color: #fff;
            }
            .header{
                background-color: #333;
                width: 100%;
                padding:20px;
            }
            img{
                display:none;
            }
            .login-box {
                border: 1px solid #ccc;
                padding: 20px;
                border-radius: 5px;
                box-shadow: none;
                width: 90%;
                position: relative;
                left: 5px;
                top:-50px;
                height:380px;
                border:none;
                background:none;
                margin-top: 30px;
            }
            .login-box h3{
                display:none;
            }
            .username span{
                display: block;
                margin: 0;
                position: absolute;
                font-size: 25px;
                top: 20%;
                left: 55px;
                transform: translate(0, -50%);
            }
            .password i{
                display: block;
                position: absolute;
                font-size: 25px;
                top: 45%;
                left: 35px;
                transform: translate(0, -50%);
            }
            .login-box form input {
                width: 90%;
                padding: 10px;
                margin: 10px 0;
                border: none;
                border-radius: 3px;
                background: none;
                text-indent: 50px;
                border-bottom: 1px solid #333;
                outline: none;
            }
            input[type="checkbox"]{
                position: absolute;
                top: 40.5%; 
                left: -130px;
                transform: translate(0, -50%);
                background-color:#333;
                display: block;
            }
            .fa{
                position: absolute;
                left: 300px;
                transform: translate(0,-50%);
                top: 333px;
                font-size: 20px;
                cursor: pointer;
            }
            .rmb{
                position: relative;
                right: 90px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>MyFood</h2>
        <a href=""><i class="fa-solid fa-arrow-left"></i></a>
        <h3>LOG IN</h3>
    </div>
    <img src="https://assets.jenius.com/assets/2020/06/12061913/Makanan-Khas-Lebaran.jpg">
    <div class="login-box">
        <h3>SIGN UP</h3>
        <form action="proseslogin.php" method="post">
            <div class="input">
                <div class="username">
                    <input type="text" name="user" autocomplete="off" placeholder="Username">
                    <span><i class="fa-solid fa-user"></i></span>
                </div>
                <div class="password" style="position: relative;">
                    <input type="password" id="pw" name="pw" placeholder="Password">
                    <span><i class="fa-solid fa-lock"></i></span>
                    <span id="showPassword" class="fa fa-eye-slash" style="position: absolute; top: 50%; right: 10px; transform: translate(0, -50%); cursor: pointer;"></span>
                </div>
                <div class="password" style="position: relative;">
                    <span><i class="fa-solid fa-lock"></i></span>
                    <input type="password" id="pw" name="pass" placeholder="Entered Your Password">
                </div>
                <div class="password" style="position: relative;">
                    <span><i class="fa-solid fa-phone"></i></span>
                    <input type="number" id="pw" name="telp" placeholder="Number Phone">
                </div>
            </div>
            <button name="submit" type="submit">Sign Up</button>
        </form>
        <div class="signup">
            Sudah punya akun? <a href="login.php">Login</a>
            
        </div>
    </div>
</div>
<script>
    const passwordInput = document.getElementById("pw");
    const showPasswordIcon = document.getElementById("showPassword");

    passwordInput.addEventListener("input", function () {
        if (passwordInput.value.length > 0) {
            showPasswordIcon.style.display = "block";
        } else {
            showPasswordIcon.style.display = "block"; 
        }
    });

    showPasswordIcon.addEventListener("click", function () {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            showPasswordIcon.classList.remove("fa-eye-slash");
            showPasswordIcon.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            showPasswordIcon.classList.remove("fa-eye");
            showPasswordIcon.classList.add("fa-eye-slash");
        }
    });
</script>

</body>
</html>


