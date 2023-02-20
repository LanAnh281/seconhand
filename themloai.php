

<?php 
    include_once "database.php"
?>
<?php 
// có gửi dữ liệu
// in de up 
   if(isset($_POST['maloai'])) {
    $stmt = $conn->prepare(
		'insert into LOAISANPHAM (IDLoai, TenLoai)
            values (:idloai, :tenloai)'); 
    $stmt->execute([
	'idloai' =>$_POST['maloai'],
	'tenloai' =>$_POST['tenloai']]);
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="img/logoGA.PNG"/>
    <title>Quản Trị Thêm Loại</title>
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

                <li class=" card-body"style="background:#D3EEFF"><a href="quantri_loai.php"class="font-weight-bold">
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

            <!--  -->
            <div class="col-9 mt-3">
              
            <div class="text-center " >
                <h3 class="mb-3">Thêm sản phẩm </h3>
            <form method="post" action="themloai.php"   >
               <div class="form-group">
                  <label for="maloai" class="text-left" >Mã Loại</label>
                  <input type="text" id="hinh1" placeholder="Mã loại sản phẩm" name="maloai">
                </div> 
                
                <div class="form-group ">
                  <label for="tenloai" class="text-left">Tên Loại</label>
                  <input type="text"  id="tenloai"   placeholder="Tên loại sản phẩm" name="tenloai">
                </div>
            
                <button type="submit" class="btn btn-primary" >Thêm</button>
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