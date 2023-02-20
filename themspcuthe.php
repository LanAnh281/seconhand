<?php
    include_once "database.php";
    $idsp='';
    $tensp='';
    $hinh1='';
    $hinh2='';
    $size=0;
    $soluong=0;
    $domoi=0;
    $gia=0;
    $tenloai="";
    $idsize='';
    if(isset($_GET['idsp'])){

        $stmt =$conn->prepare('select * from SANPHAM where idsanpham=? 
           ');

        $stmt->execute([
            $_GET['idsp']
        ]);
        if($row=$stmt->fetch()){
            $idsp=$row['IDSanPham'];
            $tensp=$row['TenSanPham'];
            $hinh1=$row['Hinh1'];
            $hinh2=$row['Hinh2'];
            $domoi=$row['DoMoi'];
            $gia=$row['Gia'];
           
        };
        
       
    }

    else if(isset($_POST['idsp'])){
        $idsize=$_POST['size'];

        $stmt_tontaisp=$conn->prepare('select  * from SOLUONG  
                            where IDSanPham=? and IDSize=?');
        $stmt_tontaisp->execute([$_POST['idsp'],$idsize]);
        if($row_sp=$stmt_tontaisp->fetch()){
            echo '<script>
                alert("Đã tồn tại sản phẩm và size");
            </script>';
        }
        else{
        $stmt = $conn->prepare(
        "INSERT into SOLUONG (IDSanPham, IDSize,SoLuong)value (?,?,?) ");
        $stmt->execute([
        $_POST['idsp'],
        $idsize,
        $_POST['soluong']]);
        echo'<script>
        alert("đã thêm sản phẩm");</script>';
        
        $stmt_sp = $conn->prepare(
            "select * from SanPham where IDSanPham=? ");
        $stmt_sp->execute([ $_POST['idsp']]);
        $rowsp=$stmt_sp->fetch();

        $idsp= $_POST['idsp'];
        $tensp=$rowsp['TenSanPham'];
        $gia=$rowsp['Gia'];
        }
        
    }
?>
   


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="img/logoGA.PNG"/>
    <title>Thêm sản phẩm cụ thể</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/7ccdb29924.js" crossorigin="anonymous"></script>
    <style>
       ul li>a:hover{
            text-decoration: none;
            color: black;
            
        }
        ul{
            list-style: none;
            padding-left: 0;
            
        }
        li a{
            color: black;
        }
        .card-body:hover{
           color: black;
            opacity: 0.8 .2s;
            border: 1px solid bisque;
            box-shadow:  1px 1px 2px #427388;
            font-size: large;
            
        }
        label{
            width: 130px;

        }
        input{
            width: 250px;
        }
    </style>
</head>

<body class="container">
  <header>
    <img src="img/back1.PNG" style="width: 100%;object-fit: contain;height: 150px;"alt="background" class=" rounded-right img-fluid">
    
      
</header>   
<!--  -->
        <div class="row mt-3">
            <div class="col-3 mt-3 ">
               <ul class="card">
                <li class=" card-header" ><a href="#"class="font-weight-bold">
                    <i class="fa-solid fa-list"></i>
                    
                </a>
                </li>
                <li class=" card-body" ><a href="quantri.php"class="font-weight-bold" >
                    <i class="fa-solid fa-users"></i>
                    Tài khoản
                </a>
                </li>

                <li class=" card-body"><a href="quantri_loai.php"class="font-weight-bold">
                    <i class="fa-solid fa-spa"></i>
                    Loại sản phẩm
                    
                </a>
                </li>
                
                <li class=" card-body"><a href="quantri_sanpham.php"class="font-weight-bold">
                    <i class="fa-solid fa-leaf"></i>
                    Sản phẩm
                </a>
                
                </li>

                <li class=" card-body"><a href="quantri_donhang.php"class="font-weight-bold">
                  <i class="fa-solid fa-leaf"></i>
                  Danh sách đơn hàng
              </a>
              
              </li>

               </ul>
            </div>

            <!-- Nội dung -->
            <div class="col-9 mt-3">
              
              <div class="text-center " >
                
            <form method="post" action="themspcuthe.php" enctype="multipart/form-data"  >

            <div class='text-center'>
              <h3 class="mb-3 text-center">Thêm sản phẩm </h3>
                <?php
                echo'
                    <input name ="idsp"  style="display:none"value="'.$idsp.'"></input>
                    <p name="idsp">ID Sản Phẩm &nbsp;'.$idsp.'</p>
                    <p name="tensp">Tên Sản Phẩm&nbsp;'.$tensp.'  </p>
                    <p name="gia">Đơn Giá:&nbsp;'.$gia.' </p>
                    ';
                ?>
              </div>
                        
                
                <div class="form-group ">
                    <label for="loaisp" class="text-left" >Size:</label>
                    
                    <select name="size" id="loaisp"style="width:250px" class="py-1">
                        <option value="">--Chọn size sản phẩm--</option>
                        <option value="S01" >S</option>
                        <option value="S02">M</option>
                        <option value="S03">L</option>
                        <option value="S04">XL</option>
                    </select>
                </div>
                
                            
                <div class="form-group">
                    <label for="soluong"class="text-left">Số lượng</label>
                    <input type="text"  id="soluong" name="soluong"  >
                </div>
                <button type="submit" class="btn btn-primary" name="them" value="them">Thêm</button>
                </form>
            </div>
                <!--  -->
            
            </div>
        </div>
<!--  -->
    <footer class="bg-dark my-2 py-2"style="color: white;">
        <p class="text-center mt-3" >
            Copyrights © 2018 Give Away Cần Thơ
        </p>

    </footer>
</body>
</html>