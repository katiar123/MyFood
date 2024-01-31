<?php
include "koneksi.php";
$id = $_GET['id'];
$edit = mysqli_query($koneksi,"SELECT * FROM produk WHERE id='$id'");
$tampil = mysqli_fetch_array($edit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Edit data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        form {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 90%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
        }

        button {
            background-color: #333;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .header h2,h3,a{
            display:none;
        }

        button:hover {
            background-color: #333;
        }
        a{
            margin-left:10px;
            text-decoration:none;
            color:white;
            background-color: #333;
            padding:9px 20px;
            padding-bottom:10px;
            border-radius:5px;
            font-size:14px;
        }
        input[type="file"] {
            width: 90%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
            display: inline-block;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
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
                display: block;
            }
            .header a{
                display: block;
                position: absolute;
                font-size: 25px;
                top: 7%;
                left: 5px;
                transform: translate(0, -50%);
                color: #fff;
            }
            .header{
                background-color: #333;
                width: 100%;
                padding:10px;
            }
            form h2,form a{
                display: none;
            }
            form {
                max-width: 400px;
                margin: 50px auto;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>MyFood</h2>
        <a href="index.php"><i class="fa-solid fa-arrow-left"></i></a>
        <h3>Edit Produk</h3>
    </div>
    <form action="proseseditdata.php" method="post" enctype="multipart/form-data">
        <h2>Edit Produk</h2>
        <input type="hidden" id="id" name="id" required value="<?php echo $tampil[0];?>">

        <label for="id">Nama Produk:</label>
        <input type="text" id="nama" name="nama" required value="<?php echo $tampil[1];?>">

        <label for="jenis">Harga Produk:</label>
        <input type="number" id="jenis" name="jenis" required value="<?php echo $tampil[2];?>">

        <label for="jenis">Jumlah Stok:</label>
        <input type="number" id="stok" name="stok" required value="<?php echo $tampil[5];?>">

        <label for="gambar">Gambar:</label>
        <input type="file" id="gambar" name="gambar" accept="image/*" required>

        <button type="submit">Simpan</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
