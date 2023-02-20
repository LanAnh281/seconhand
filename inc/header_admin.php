<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="img/logoGA.PNG"/>
    <title>Quản trị Tài Khoản</title>
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
        .active_quantri{
            color: #2c136b;
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
                  <a class="nav-link active" href="trangchu.php">Về Trang Chủ</a>
            </li>
                
            <li class="nav-item ">
            <?php
            session_start();
        
            if (isset($_SESSION['IDTK'])){
                echo'<a class="nav-link" href="dangxuat.php">
                        Đăng xuất
                </a>';
               
            };
           
            ?>
            </li>     
        </ul>
            </div>
        </nav> 
</header>