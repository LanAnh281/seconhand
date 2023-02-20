<?php
    include_once "database.php";
    
    $tensp='';
    $hinh1='';
    $hinh2='';
    $size=0;
    $soluong=0;
    $domoi=0;
    $gia=0;
    $tenloai="";
    if(isset($_GET['idsp'])){


        $stmt =$conn->prepare('select * from SANPHAM sp join SOLUONG sl
        on sp.IDSanPham= sl.IDSanPham
            join SIZE s on s.IDSize=sl.IDSize
            join LOAISANPHAM lsp on lsp.IDLoai=sp.IDLoai
        where sp.IDSanPham=:masp');

        $stmt->execute([
            'masp'=>$_GET['idsp']
        ]);
        if($row=$stmt->fetch()){
            $tensp=$row['TenSanPham'];
            $hinh1='';
            $hinh2='';
            $size=$row['Ten'];
            $soluong=$row['SoLuong'];
            $domoi=$row['DoMoi'];
            $gia=$row['Gia'];
            $tenloai=$row['TenLoai'];
        };
            
       
    }

    else if(isset($_POST['idsp'])){
        
        $timid=$conn->prepare('select * from SIZE where Ten=?');
        $timid->execute([$_POST['size']]);
        if($row=$timid->fetch()){
            $idsize_new=$row['IDSize'];
        }
        
        
        $stmt = $conn->prepare(
            "UPDATE SANPHAM sp join SOLUONG sl
            on sp.IDSanPham= sl.IDSanPham
            join SIZE s on s.IDSize=sl.IDSize
            SET TenSanPham=?, DoMoi=?,sl.IDSize=?, SoLuong=?,Gia=? WHERE sp.IDSanPham=? and sl.IDSize=? ;"
        ); 
        $stmt->execute([
        $_POST['tensp'],
        $_POST['domoi'],
        $idsize_new,
        $_POST['soluong'],
        $_POST['gia'],
        $_POST['idsp'],
        $_POST['idsize']]);


        $tensp=$_POST['tensp'];
        $size=$_POST['size'];
        $soluong=$_POST['soluong'];
        $domoi=$_POST['domoi'];
        $gia=$_POST['gia'];
        $tenloai=$_POST['lsp'];

        $hinh1 = $_FILES["hinh1"]["name"];
        if ($hinh1 != "") {
            $tmp_name = $_FILES["hinh1"]["tmp_name"];
            $name = $_FILES["hinh1"]["name"];
            move_uploaded_file($tmp_name, "img\\" . $_POST['lsp'] . "\\" . $name);

            $stmt = $conn->prepare(
                "UPDATE SANPHAM SET Hinh1=? where IDSanPham=?"
            ); 
            $stmt->execute([
            "img\\" . $_POST['lsp'] . "\\" . $name,
            $_POST['idsp']
            ]);
        }

        $hinh2 = $_FILES["hinh2"]["name"];
        if ($hinh2 != "") {
            $tmp_name = $_FILES["hinh2"]["tmp_name"];
            $name = $_FILES["hinh2"]["name"];
            move_uploaded_file($tmp_name, "img\\" . $_POST['lsp'] . "\\" . $name);
            
            $stmt = $conn->prepare(
                "UPDATE SANPHAM SET Hinh2=? where IDSanPham=?"
            ); 
            $stmt->execute([
            "img\\" . $_POST['lsp'] . "\\" . $name,
            $_POST['idsp']
            ]);
        }
        echo '
            <script>
                alert("Chỉnh sửa sản phẩm thành công");
                window.location="quantri_sanpham.php";
            </script>
        ';
    }

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="img/logoGA.PNG" />
    <title>Quản trị Chỉnh sửa sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/7ccdb29924.js" crossorigin="anonymous"></script>
    <style>
    ul li>a:hover {
        text-decoration: none;
        color: black;

    }

    ul {
        list-style: none;
        padding-left: 0;

    }

    li a {
        color: black;
    }

    .card-body:hover {
        color: black;
        opacity: 0.8 .2s;
        border: 1px solid bisque;
        box-shadow: 1px 1px 2px #427388;
        font-size: large;

    }

    label {
        width: 150px;

    }

    input {
        width: 250px;
    }
    </style>
</head>

<body class="container">
    <header>
        <img src="img/back1.PNG" style="width: 100%;object-fit: contain;height: 150px;" alt="background"
            class=" rounded-right img-fluid">


    </header>
    <!--  -->
    <div class="row mt-3">
        <div class="col-3 mt-3 ">
            <ul class="card">
                <li class=" card-header"><a href="#" class="font-weight-bold">
                        <i class="fa-solid fa-list"></i>

                    </a>
                </li>
                <li class=" card-body"><a href="quantri.php" class="font-weight-bold">
                        <i class="fa-solid fa-users"></i>
                        Tài khoản
                    </a>
                </li>

                <li class=" card-body"><a href="quantri_loai.php" class="font-weight-bold">
                        <i class="fa-solid fa-spa"></i>
                        Loại sản phẩm

                    </a>
                </li>

                <li class=" card-body" style="background:#D3EEFF"><a href="quantri_sanpham.php"
                        class="font-weight-bold">
                        <i class="fa-solid fa-leaf"></i>
                        Sản phẩm

                    </a>

                </li>

                <li class=" card-body"><a href="quantri_donhang.php" class="font-weight-bold">
                        <i class="fa-solid fa-leaf"></i>
                        Danh sách đơn hàng
                    </a>

                </li>

            </ul>
        </div>

        <!-- Nội dung -->
        <div class="col-9 mt-3">

            <div class="text-center ">
                <h3 class="mb-3">Chỉnh Sửa Sản Phẩm </h3>
                <form method="post" action="chinhsua.php" enctype="multipart/form-data">

                    <div class="form-group ">
                        <label for="idsp" class="text-left">Loại Sản Phẩm</label>
                        <input type="text" name="lsp" value="<?php echo $tenloai ?>">
                    </div>


                    <div class="form-group " style="display:none">
                        <label for="idsp" class="text-left">ID Sản Phẩm</label>
                        <input type="text" id="idsp" name="idsp" placeholder="ID sản phẩm"
                            value=<?php echo ''.$row['IDSanPham'].'' ?>>
                    </div>
                    <div class="form-group " style="display:none">
                        <label for="idsize" class="text-left">ID Size</label>
                        <input type="text" id="idsize" name="idsize" placeholder="ID size"
                            value=<?php echo ''.$row['IDSize'].'' ?>>
                    </div>
                    <div class="form-group ">
                        <label for="tensp" class="text-left">Tên Sản Phẩm</label>
                        <input type="text" id="tensp" name="tensp" placeholder="Tên sản phẩm"
                            value="<?php echo $tensp ?>">
                    </div>

                    <div class="form-group">
                        <label for="hinh1" class="text-left">Hình 1</label>
                        <input type="file" id="hinh1" name="hinh1">
                    </div>

                    <div class="form-group">
                        <label for="hinh2" class="text-left">Hình 2</label>
                        <input type="file" id="hinh2" name="hinh2">
                    </div>

                    <div class="form-group">
                        <label for="size" class="text-left">Size</label>
                        <input type="text" name="size" id="size" value="<?php echo $size ?>">
                    </div>

                    <div class="form-group">
                        <label for="soluong" class="text-left">Số lượng</label>
                        <input type="text" id="soluong" name="soluong" value="<?php echo $soluong ?>">
                    </div>

                    <div class="form-group">
                        <label for="domoi" class="text-left">Độ mới</label>
                        <input type="number" name="domoi" id="domoi" value="<?php echo $domoi  ?>">
                    </div>

                    <div class="form-group">
                        <label for="dongia" class="text-left">Đơn giá</label>
                        <input type="text" name='gia' id="dongia" value="<?php echo $gia ?>">
                    </div>




                    <button type="submit" class="btn btn-primary" name="sua" value="sua">Sửa</button>

                </form>
            </div>
            <!--  -->

        </div>
    </div>
    <!--  -->
    <footer class="bg-dark my-2 py-2" style="color: white;">
        <p class="text-center mt-3">
            Copyrights © 2018 Give Away Cần Thơ
        </p>

    </footer>
</body>

</html>