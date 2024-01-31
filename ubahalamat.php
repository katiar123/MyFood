<?php
include "koneksi.php";
$id = $_GET['id'];
$sql = mysqli_query($koneksi,"SELECT * From user WHERE id = '$id'");
$data = mysqli_fetch_array($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            font-family:arial;
        }
        body{
            background-color:#f2f2f2;
        }
        .nama,.telp{
            padding: 15px 20px;
        }
        .kecamatan,.jalan{
            padding:15px 20px;
            width: 386px;
            margin-top:10px;
        }
        .jalan{
            position: relative;
            top: 0px;
        }
        .kecamatan::placeholder{
            text-align:left;
        }
        iframe{
            width:426px;
            position: relative;
            height:200px;
            margin-top:10px;
        }
        .ubah{
            background-color:#fff;
            height:500px;
            width:500px;
            margin-left:400px;
            padding-top:80px;
        }
        .data{
            margin-left:30px;
            position: relative;
            top: -60px;
        }
        .ubah h2{
            position: relative;
            top: -70px;
            right: -30px;
        }
        .konfir{
            padding: 10px 25px;
            color:white;
            background-color:#333;
            border:none;
            position: relative;
            left: 270px;
            top:-10px;
        }
        .batal{
            text-decoration:none;
            position: relative;
            left:250px;
            top: -10px;
        }
    </style>
</head>
<body>
    <div class="ubah">
        <h2>Ubah Alamat</h2>
        <div class="data">
        <form action="" method="post">
            <input type="text" class="nama" placeholder="Nama Lengkap" value="<?php echo $data[1]?>">
            <input type="number" class="telp" placeholder="Nomer Telepon" value="<?php echo $data[3]?>"><br>
            <input type="text" class="kecamatan" placeholder="Provinsi,Kota,Kecamatan" value="<?php echo $data[5]?>"><br>
            <input type="text" class="jalan" placeholder="Nama Jalan,Gedung,No.Rumah" value="<?php echo $data[6]?>">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.382890463253!2d106.8916138697983!3d-6.344435148001532!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ecdbbdc1caa7%3A0x855dac0ed0167667!2sGg.%20Buni%2C%20RW.2%2C%20Munjul%2C%20Kec.%20Cipayung%2C%20Kota%20Jakarta%20Timur%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2013850!5e0!3m2!1sid!2sid!4v1705374391671!5m2!1sid!2sid" width="600"
                height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <a href="beli.php" class="batal">BATAL</a>
            <button type="submit" name="ubah" class="konfir">KONFIRMASI</button>
        </form>
    </div>

    
</body>
</html>