<?php
  include_once "database.php";
  session_start();
  
  if(isset($_POST['ttsp'])) {
    $query = "INSERT INTO `secondhand`.`soluonggh` (`IDTaiKhoan`, `IDSanPham`, `SoLuong`, `TenSize`) 
    VALUES (?,?,?,?);";
		try{
      $sth = $conn->prepare($query);
      $sth->execute([
        $_SESSION['IDTK'],
        $_POST['ttsp'],
        $_POST['soluong'],
        $_POST['size']
      ]);
    }catch (PDOException $e){
      $conn_error = $e->getMessage();
    }
  }
 

  
  if(isset($_POST['tang'])) {
    // $soluong = $_GET['f'];
    $query = "UPDATE `secondhand`.`soluonggh` SET `SoLuong` = ? 
    WHERE (`IDTaiKhoan` = ?) and (`IDSanPham` = ?);    ";
		try{
      $sth = $conn->prepare($query);
      $sth->execute([
        $_POST['f']+1,
        $_SESSION['IDTK'],
        $_POST['tang']
      ]);
    }catch (PDOException $e){
      $conn_error = $e->getMessage();
    }
  }
  if(isset($_POST['giam'])) {
    // $soluong = $_GET['f'];
    $query = "UPDATE `secondhand`.`soluonggh` SET `SoLuong` = ?
     WHERE (`IDTaiKhoan` = ?) and (`IDSanPham` = ?);";
		try{
      $sth = $conn->prepare($query);
      $sth->execute([
        $_POST['f']-1,
        $_SESSION['IDTK'],
        $_POST['giam']
      ]);
    }catch (PDOException $e){
      $conn_error = $e->getMessage();
    }
  }

  // if(isset($_POST['ttsp'])){
  //   header ('Location: sanpham.php?idloai=L01');
  // }
 

?>
<?php include_once "./inc/header.php"; ?>
<!-- Đơn hàng-->
  <h3 class="text-center mt-3">Giỏ Hàng</h3>

  
    <div>
      <?php 
          $query = "select * from taikhoan where IDTaiKhoan = '".$_SESSION['IDTK']."'";
          $stt = 1;
          try {
              $sth = $conn->query($query);
              if ($row = $sth->fetch()){
                  echo ' 
                    <div>
                      <h5>Họ tên: '.$row['HoTen'].'</h5>
                      <h5>Địa chỉ: '.$row['DiaChi'].'</h5>
                      <h5>Số điện thoại: '.$row['SDT'].'</h5>
                    </div>
                  ';
              }   
          } catch (PDOException $e){
              
          }
      ?>
    </div>
    <table class="table my-3 table-hover">
      
      <thead>
        <tr>
          <th>STT</th>
          <th >Tên sản phẩm</th>
          <th>Size</th>
          <th >Số lượng</th>
          <th >Đơn giá</th>
          <th>Thành tiền</th>
          <th class="text-center"> Thao tác</th>
          
        </tr>
      </thead>
      <tbody>
      
        <?php
            if(isset($_GET['masp'])){
              $query = "DELETE FROM `secondhand`.`soluonggh` WHERE (`IDTaiKhoan` = ?) and (`IDSanPham` = ?);";
              try{
                  $sth = $conn->prepare($query);
                  $sth->execute([
                    $_SESSION['IDTK'],
                    $_GET['masp']
                  ]);
                }catch (PDOException $e){
                  $conn_error = $e->getMessage();
                }
            }
          $query = "select * ,soluong*gia as gia
                    from soluonggh natural join taikhoan
                                  natural join sanpham
                    where idtaikhoan = '".$_SESSION['IDTK']."'";
          $stt = 1;
          try {
              $sth = $conn->query($query);
              while ($row = $sth->fetch()){
                  echo ' 
                    <tr>
                      <td>'.$stt++.'</td>
                      <td>'.$row['TenSanPham'].'</td>
                      <td>'.$row['TenSize'].'</td>
                      <td>
                      
                        <form action="giohang.php" method="post">
                          <input readonly min="1" type="number" name="f" value="'.$row['SoLuong'].'"></input>
                          <button type="submit" readonly  name="tang" value="'.$row['IDSanPham'].'">Tăng</button>
                          <button type="submit" name="giam" value="'.$row['IDSanPham'].'">Giảm</button>
                          </form>
                        
                      </td>
                      <td>'.$row['Gia'].'</td>
                      <td>'.$row['gia'].'</td>
                      <td class="text-center">
                        <a href="?masp='.$row['IDSanPham'].'" style="text-decoration: none;">
                          <i class="fa-solid fa-trash pr-3 text-dark"></i>
                        </a>
                      </td>
                    </tr>
                  ';
                  // <form action="giohang.php" method="post">
                  //   <button type="button" readonly  name="tang" value="'.$row['IDSanPham'].'">Tăng</button>
                  //   <button type="button" name="giam" value="'.$row['IDSanPham'].'">Giảm</button>
                  // </form>
                  // <button type="submit" readonly  name="tang" value="'.$row['IDSanPham'].'">Tăng</button>
                  // <button type="submit" name="giam" value="'.$row['IDSanPham'].'">Giảm</button>
              }   
          } catch (PDOException $e){
              
          }
        ?>
        
        <!-- <tr>
          <td >1</td>
          <td>Đầm</td>
          <td></td>
          <td></td>
          <td>
            <input type="number" value="1" min="1" style="width:55px;">
          </td>
          <td>280k</td>
          <td class="text-center">
            <a href="#" style="text-decoration: none;">
              <i class="fa-solid fa-trash pr-3 text-dark"></i>
            </a>
            
            
          </td>
        </tr>
        <tr>
          <td colspan="5"></td>
          <td>Tổng:</td>
          <td></td>
        </tr>
        -->
      </tbody>
    </table>
    <div >
      <?php
          $query = "select *,sum(soluong*gia) as tong
                    from soluonggh natural join taikhoan
                                    natural join sanpham
                      where idtaikhoan = '".$_SESSION['IDTK']."'; "; 
          try {
              $sth = $conn->query($query);
              if ($row = $sth->fetch()){
                echo '
                <div style="margin-left: 800px;" class="text-center">
                  Tổng: <input class="bg-light" name="tong" value="'.$row['tong'].'" type="text" readonly >
                </div>
                  <input hidden class="bg-light" name="idsp" value="'.$row['IDSanPham'].'" type="text">
                  <input hidden class="bg-light" name="tensize" value="'.$row['TenSize'].'" type="text">
                  
                  ';
              }
          } catch (PDOException $e){
              
          }
        ?>
        
    </div>
    <form action="donhang.php" method="post">
    <div class="text-center">
      <button type="submit" class="btn btn-warning" name="dathang" value="dathang">Đặt hàng</button>
    </div>
  </form>
  <?php include_once "./inc/footer.php"; ?>
 
  </script>
</body>
</html>