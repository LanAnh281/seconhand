<?php 
    include_once 'database.php';
    if(isset($_POST['masp'])){
        
        $loaisp='';
        $stmt_tontaisp=$conn->prepare('select  * from SOLUONG  
                            where IDSanPham=? and IDSize=?');
        $stmt_tontaisp->execute([$_POST['masp'],$_POST['ms']]);
        if($row_sp=$stmt_tontaisp->fetch()){
            echo '<script>
                alert("Đã tồn tại sản phẩm và size");
            </script>';
        }
        
        else {
        $stmt_loai=$conn->prepare('select * from LOAISANPHAM where IDLoai=?;');
        $stmt_loai->execute([$_POST['lsp']]);
        $row=$stmt_loai->fetch();
        $loaisp=$row['TenLoai'];
        

        $hinh1=$_FILES['hinh1']['name'];
        $nameh1="";
        if($hinh1 !=""){
            $tmp_name=$_FILES["hinh1"]["name"];
            $nameh1 = $_FILES["hinh1"]["name"];
            move_uploaded_file($tmp_name, "img/" . $loaisp. "/" . $nameh1);

        }
        $hinh2=$_FILES['hinh2']['name'];
        $nameh2="";
        if($hinh2 !=""){
            $tmp_name=$_FILES["hinh2"]["name"];
            $nameh2 = $_FILES["hinh2"]["name"];
            move_uploaded_file($tmp_name, "img/" .$loaisp . "/" . $nameh2);

        }
        $stmt_tontai=$conn->prepare('select  * from SANPHAM  
                            where IDSanPham=? ');
        $stmt_tontai->execute([$_POST['masp']]);
        if($rowsp=$stmt_tontai->fetch()){
            echo 'Đã tồn tại sản phẩm ';
        }
        else{
        $stmt=$conn->prepare('insert into SANPHAM                                              
        (IDLoai,IDSanPham, TenSanPham,DoMoi,Gia,
        Hinh1,Hinh2,ChatLieu,XuatSu,TonTai)
        values (?,?,?,?,?,?,?,?,?,?)'); 
        $stmt->execute([
            $_POST['lsp'],
            $_POST['masp'],
            $_POST['tensp'],
            $_POST['domoi'],
            $_POST['dongia'],
            "img\\" .$loaisp ."\\".$nameh1,
            "img\\" .$loaisp ."\\".$nameh2,
            $_POST['chatlieu'],
            $_POST['xuatsu'],
            '1'
           
        ]);
};
        $stmt_themsl=$conn->prepare('insert into  SOLUONG 
        (IDSanPham,IDSize,SoLuong)
        values (?,?,?);'); 
        $stmt_themsl->execute([
            
            $_POST['masp'],
            $_POST['ms'],
            $_POST['soluong']
           
        ]);

    };
    echo '<script>
        alert("Thêm sản phẩm thành công");
        window.location="quantri_sanpham.php";
    </script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="img/logoGA.PNG"/>
    <title>Quản trị Thêm Sản Phẩm</title>
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
            width: 150px;

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
                
                <li class=" card-body"style="background:#D3EEFF"><a href="quantri_sanpham.php"class="font-weight-bold">
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

            <!--NỘI DUNG  -->
            <div class="col-9 mt-3">
              
              <div class="text-center " >
                <h3 class="mb-3">Thêm sản phẩm </h3>
            <form method="post" action="them.php" enctype="multipart/form-data"  >
            
            
                <div class="form-group ">
                    <label  class="text-left" style="width:150px">Loại Sản Phẩm</label>
                    <select name="lsp" style="width:250px">
                        <option value="">--Chọn--</option>
                        <option value="L01" selected="selected">Áo</option>
                        <option value="L02">Quần</option>
                        <option value="L03">Đầm</option>
                    </select>
                </div>            
     
                <div class="form-group ">
                  <label for="masp" class="text-left">Mã Sản Phẩm:</label>
                  <input type="text"  id="masp" name="masp"  placeholder="Tên sản phẩm">
                </div>
                <div class="form-group ">
                  <label for="tensp" class="text-left">Tên Sản Phẩm:</label>
                  <input type="text"  id="tensp" name="tensp"  placeholder="Tên sản phẩm">
                </div>
            
                <div class="form-group">
                  <label for="hinh1" class="text-left">Hình 1:</label>
                  <input type="file" id="hinh1" name="hinh1" >
                </div>
            
                <div class="form-group">
                    <label for="hinh2" class="text-left">Hình 2:</label>
                    <input type="file"  id="hinh2" name="hinh2" >
                </div>
            
                <div class="form-group ">
                    <label for="loaisp" class="text-left" style="width:150px">Size :</label>
                    
                    <select name="ms" id="loaisp"style="width:250px" class="py-1">
                        <option value="">--Chọn size sản phẩm--</option>
                        <option value="S01" >S</option>
                        <option value="S02">M</option>
                        <option value="S03">L</option>
                        <option value="S04">XL</option>
                    </select>
                </div>
            <div class="form-group">
                    <label for="soluong"class="text-left">Số Lượng:</label>
                    <input type="number"  id="soluong" name="soluong" >
                </div>
                <div class="form-group">
                    <label for="domoi"class="text-left">Độ mới:</label>
                    <input type="number"  id="domoi" name="domoi" >
                </div>

                <div class="form-group">
                    <label for="chatlieu"class="text-left">Chất liệu:</label>
                    <input type="text"  id="chatlieu" name="chatlieu" >
                </div>

                <div class="form-group">
                    <label for="xuatsu"class="text-left">Xuất sứ:</label>
                    <input type="text"  id="xuatsu" name="xuatsu" >
                </div>

                <div class="form-group">
                    <label for="dongia"class="text-left">Đơn giá:</label>
                    <input type="text"  id="dongia"  name="dongia">
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