<?php include_once "database.php" 
  
?>
<?php include_once "./inc/header_admin.php"; ?> 
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
                    Tài Khoản
              </a>
          </li>

          <li class=" card-body"><a href="quantri_loai.php"class="font-weight-bold">
              <i class="fa-solid fa-spa"></i>
                Loại sản phẩm</a>
          </li>
                
          <li class=" card-body"style="background:#D3EEFF"><a href="quantri_sanpham.php"class="font-weight-bold">
              <i class="fa-solid fa-leaf"></i>
                    Sản phẩm  </a>
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
              <div>
                <button type="submit" class="btn btn-warning" name="add" value="add">
                  <a href="them.php" class="font-weight-bold" >+</a>
                </button>
                <!--  -->
              </div>
                <table class="table my-3 table-hover">
                    <h3 class="text-center mt-3">Sản Phẩm</h3>
                    <thead>
                      <tr>
                        <th>Mã sản phẩm</th>
                        <th >Tên sản phẩm</th>
                        <th style="width: 120px; ">Hình ảnh</th>
                        <th>Đơn giá</th>
                        <th>Tồn tại</th>
                        <th>Thao tác</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 

                      $stmt = $conn->prepare('select * from SANPHAM');
                        // viết sql chuẩn bị
                          $stmt->execute(); 
                          // thuc thi sql
                          while ($row = $stmt->fetch()) {
                            if($row['TonTai']=='1'){
                            echo '<tr>
                            <td>'.$row['IDSanPham'].'</td>
                            <td>'.$row['TenSanPham'].'</td>
                            <td  style="width: 130px; height: 150px;" >
                                <img src="'.$row['Hinh1'].'" style=" width: 100%; height: 100%;">
                            </td>
                            
                            <td>'.$row['Gia'].'</td>
                            
                            
                            <td>'.$row['TonTai'].'</td>
                            <td>
                            <a href="chitiet_sanpham.php?idsp='.$row['IDSanPham'].'&dgia='.$row['Gia'].'&tensp='.$row['TenSanPham'].'" class="ml-2" style="text-decoration: none;"> 
                              <i class="fa-solid fa-circle-info text-dark"></i>
                          </a>
                          </td>
                          </tr>
                         ';
                            }
                          }
                          
                    ?>
                      
                      
                    </tbody>
                  </table>
                 
            </div>
        </div>
<!--  -->
    <?php include_once "./inc/footer.php"; ?>
</body>
</html>