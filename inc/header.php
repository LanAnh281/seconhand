<?php include_once "database.php";
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="img/logoGA.PNG"/>
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/7ccdb29924.js" crossorigin="anonymous"></script>

</head>
<body class="container">
    <header>
        <img src="img/back1.PNG" style="width: 100%;object-fit: contain;height: 150px;"alt="background" class=" rounded-right img-fluid">
        
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
              <ul class="navbar-nav mr-auto">
                 <li class="nav-item">
                  <a class="nav-link active" href="trangchu.php">Trang chủ</a>
                </li>
                
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sản phẩm
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <?php
                    $query = 'select * from LOAISANPHAM';
                    $stt = 1;
                    try {
                        $sth = $conn->query($query);
                        while ($row = $sth->fetch()){
                            echo '
                                <a class="dropdown-item" href="sanpham.php?idloai='.$row['IDLoai'].'">'.$row['TenLoai'].'</a>
                            ';
                        }   
                    } catch (PDOException $e){
                        
                    }
                    ?>   
                  </div>
                </li>
                <?php 

                    if (isset($_SESSION['IDTK'])&& $_SESSION['VAITRO']=='admin') {
                        echo '
                            <li class="nav-item ">
                                    <a class="nav-link" href="quantri.php">Về Quản Trị<span class="sr-only">(current)</span></a>
                            </li>
                            
                            ';
                    }

                    elseif(!isset($_SESSION['IDTK'])){
                        echo '
                            <li class="nav-item ">
                                <a class="nav-link" href="dangky.php">Đăng ký <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="dangnhap.php">Đăng nhập <span class="sr-only">(current)</span></a>
                            </li>
                            ';
                    }
                    elseif (isset($_SESSION['IDTK'])) {
                        echo '
                            <li class="nav-item ">
                                    <a class="nav-link" href="dangxuat.php">Đăng xuất<span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link " href="donhang.php">Đơn hàng<span class="sr-only">(current)</span></a>
                            </li>
                            ';
                    }
                ?>
              </ul>
              <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Sản phẩm ...." aria-label="Search">
                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
              </form>
              <?php
                if(isset($_SESSION['IDTK'])&&$_SESSION['VAITRO']=='user'){
                    echo '
                        <button class="btn btn-warning  my-2 my-sm-0 ml-2" type="submit">
                                <a class="nav-link p-0" href="giohang.php">
                                    <i class="fa-solid fa-cart-shopping" style="color: black;"></i>  
                                </a>
                        </button>
                    ';
                }
              ?>
              
            </div>
        </nav>  
    </header>    