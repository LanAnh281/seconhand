<?php 
  include_once "database.php";
  session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="img/logoGA.PNG" />
    <title>Chi tiết đơn hàng</title>
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
    </style>
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
                    if(!isset($_SESSION['IDTK'])){
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
                            <li class="nav-item active ">
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
                if(isset($_SESSION['IDTK'])){
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
    <!--  -->
    <div class="row mt-3">

        <div class="col-12 mt-3">
            <h3 class="text-center mt-3">Đơn Hàng</h3>
            <?php 
            $stmt = $conn->prepare('select * from DONHANG  where IDTaiKhoan=? and IDDonHang=?;');
            $stmt->execute([$_GET['iddh']]);
            $row=$stmt->fetch();
            echo '
            <div>
                <p>Ngày đặt:&nbsp;  '.$row['NgayDat'].'</p>
                <p>Thời gian:&nbsp; '.$row['GioDat'].'</p>
            </div>
            
            <table class="table my-3 table-hover">
                
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Size</th>
                        <th>Đơn giá</th>
                    </tr>
                </thead>
                <tbody>';
                $stmt_chitiet = $conn->prepare('select * from DONHANG natural join SOLUONGDH  
                    natural join sanpham where IDTaiKhoan=? and IDDonHang=?;');
                $stmt_chitiet->execute([$_SESSION['IDTK'],$_GET['iddh']]);
                    while ($row_chitiet=$stmt_chitiet->fetch()){
                        echo '
                    <tr>
                        <td>'.$row_chitiet['IDDonHang'].'</td>
                        <td>'.$row_chitiet['TenSanPham'].'</td>
                        <td>'.$row_chitiet['SoLuong'].'</td>
                        <td>'.$row_chitiet['TENSize'].'</td>
                        <td>'.$row_chitiet['Gia'].'</td>
                    </tr>
                    ';}
                    echo '
                    <tr>
                        <td colspan="3"></td>
                        <td>Thành tiền:</td>
                        <td>'.$row['TongTien'].'</td>
                    </tr>';
                    
            echo '        
                </tbody>
            </table>';
            ?>
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