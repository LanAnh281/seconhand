<?php 
    include_once "database.php";
    $idsp='';
    $tensp='';
    $hinh1='';
    $size='';
    $soluong;
    $domoi;
    $dongia;
    
    if(isset($_GET['xoa'])){
      
      $stmt_idsize=$conn->prepare('select IDSize from SIZE where Ten=?');
      $stmt_idsize->execute([$_GET['ten']]);
      $row=$stmt_idsize->fetch();

      $idsize=$row['IDSize'];
      $stmt_soluong=$conn->prepare('delete  from soluong where IDSanPham=? and IDSize=?');
      $stmt_soluong->execute([$_GET['idsp'],$idsize]);
     
      
      $stmt_tontai= $conn->prepare('select count(*)as slsp from 
      SANPHAM sp join soluong sl on sp.IDSanPham=sl.IDSanPham
      where sl.IDSanPham=?;');
      $stmt_tontai->execute([$_GET['idsp']]);
      $ssp=$stmt_tontai->fetch();
      
      if ($ssp['slsp']==0){
        $stmt_capnhat=$conn->prepare("UPDATE SANPHAM SET TonTai=? WHERE IDSanPham=?;");
        $stmt_capnhat->execute(['0',$_GET['idsp']]);
      }
      echo '<script>
            alert("Đã xóa thành công");
            window.location=("quantri_sanpham.php");

      
        </script>';
      
    }
      if(isset($_GET['idsp'])){
        $stmt = $conn->prepare('select *from SANPHAM sp join SOLUONG sl
        on sp.IDSanPham= sl.IDSanPham
        join SIZE s on s.IDSize=sl.IDSize
        where sp.IDSanPham=:masp');
        // viết sql chuẩn bị
        $stmt->execute([
        'masp'=>$_GET['idsp']]);                   
        if ($row=$stmt->fetch()){
          $idsp=$_GET['idsp'];
          $tensp=$row['TenSanPham'];
          $hinh1=$row['Hinh1'];
          $size=$row['Ten'];
          $soluong=$row['SoLuong'];
          $domoi=$row['DoMoi'];
          $dongia=$row['Gia'];
        }
      }
                 
    

  
?>

<?php include_once "./inc/header_admin.php"; ?>
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
            <h3 class="text-center">THÔNG TIN CHI TIẾT SẢN PHẨM</h3>
            <div>
                <button type="submit" class="btn btn-warning" name="add" value="add">

                    <a href="themspcuthe.php?idsp=<?php echo ''.$_GET['idsp'].'' ?>" style="text-decoration:none;"
                        class="font-weight-bold">+</a>

                </button>

                <?php 
                       if(isset($_GET['idsp'])){
                        $stmt = $conn->prepare('select *from SANPHAM sp join SOLUONG sl
                        on sp.IDSanPham= sl.IDSanPham
                            join SIZE s on s.IDSize=sl.IDSize
                        where sp.IDSanPham=:masp');
                        // viết sql chuẩn bị
                            $stmt->execute([
                                'masp'=>$_GET['idsp']
                            ]); 
                            // thuc thi sql
                            
                         
                                echo '
                            <div>   
                                <p>Mã sản phẩm:  &ensp;'.$_GET['idsp'].'</p>
                                <p>Tên sản phẩm: &ensp; '.$_GET['tensp'].'</p>
                                <p>Đơn giá:  &ensp;'.$_GET['dgia'].' VND</p>
                            </div>'
                        ?>
            </div>
            <table class="table my-3 table-hover">
                    

                <thead>
                    <tr>
                       
                        <th style="width: 120px; ">Hình ảnh</th>
                        <th>Size</th>
                        <th>Số lượng</th>
                        <th>Độ mới(%)</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                   
                   while ($row = $stmt->fetch()) {
                    echo '
                        <td  style="width: 130px; height: 150px;" >
                            <img src="'.$row["Hinh1"].'" style=" width: 100%; height: 100%;">
                        </td>
                        <td>'.$row['Ten'].'</td>
                        <td>'.$row['SoLuong'].'</td>
                        <td>'.$row['DoMoi'].'</td>
                        
                        
                        <td>
                        <a href="chitiet_sanpham.php?idsp='.$row["IDSanPham"].'&xoa=1&ten='.$row['Ten'].'" style="text-decoration: none;">
                          <i class="fa-solid fa-trash pr-3 text-dark"></i>
                        </a>
                        <a href="chinhsua.php?idsp='.$row["IDSanPham"].'" style="text-decoration: none;">
                        <i class="fa-solid fa-pen-to-square text-dark"></i>
                        </a>
                      
                      </td>
                      </tr>
                      ' ;}    
                          
                     
                    }
                     ?>

                </tbody>
            </table>

        </div>
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