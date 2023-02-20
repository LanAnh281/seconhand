<?php 
    include_once "database.php";
    if(isset($_GET['idtk'])){
        
        if($_GET['handung']=='1'){
        $stmt_xoa=$conn->prepare('UPDATE TAIKHOAN SET HanDung=? where IDTaiKhoan=?;');
        $stmt_xoa->execute(['0',$_GET['idtk']]);
        }
        else if ($_GET['handung']=='0'){

            $stmt=$conn->prepare('UPDATE TAIKHOAN SET HanDung=? where IDTaiKhoan=?;');
            $stmt->execute(['1',$_GET['idtk']]);
        
        };
    }
?>

<?php include_once "./inc/header_admin.php"; ?>  

<!--  -->
       
        
        <div class="row mt-3">
            <div class="col-3 mt-3 ">
               <ul class="card">
                <li class=" card-header" ><a href="#"class="font-weight-bold">
                    <i class="fa-solid fa-list"></i>
                    Trang Quản Trị
                </a>
                </li>
                <li class=" card-body" style="background:#D3EEFF" >
                    <a href="quantri.php"class="font-weight-bold active_quantri" >
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
            <div class="col-9 mt-3">
                <table class="table my-3 table-hover">
                    <h3 class="text-center mt-3">Tài khoản</h3>
                    <thead>
                      <tr>
                        <th>IDTK</th>
                        <th >Họ và Tên</th>
                        <th>Địa chỉ</th>
                        <th>SĐT</th>
                        <th>Email</th>
                        <!-- <th>Mật khẩu</th> -->
                        <th style="padding-left:0;padding-right:0">Vai trò</th>
                        <th style="padding-left:0;padding-right:0">Hạn dùng</th>
                        <th style="padding-left:0;padding-right:0">Thao tác</th>
                    
                      </tr>
                    </thead>
                    <tbody>
                        <?php  
                        $stmt =$conn->prepare("select * from TAIKHOAN ");
                        $stmt->execute();
                        while ($row=$stmt->fetch()){
                            if($row['VaiTro']=='user'){
                          echo'  <tr>
                        <td >'.$row['IDTaiKhoan'].'</td>
                        <td>'.$row['HoTen'].'</td>
                        <td>'.$row['DiaChi'].'</td>
                        <td >'.$row['SDT'].'</td>
                        <td>'.$row['email'].'</td>
                        <!--<td >'.$row['MatKhau'].'</td>-->
                        
                        
                       
                        <td style="padding-left:0;padding-right:0">'.$row['VaiTro'].'</td>
                        <td style="padding-left:0;padding-right:0">'.$row['HanDung'].'</td>
                        <td style="padding-left:0;padding-right:0">
                        <a href="quantri.php?idtk='.$row['IDTaiKhoan'].'&handung='.$row['HanDung'].'" style="text-decoration: none;">
                        <i class="fa-solid fa-power-off"></i>
                      </td>
                      </tr>';}
                        };
                      
                      ?>
                      
                      
                    </tbody>
                  </table>
                
            </div>
        </div>
<!--  -->
    <?php include_once "./inc/footer.php"; ?>
</body>
</html>