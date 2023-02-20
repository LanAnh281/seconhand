<?php
    include_once 'database.php';
    if(isset($_GET['maloai'])){
        $stmt_idsp=$conn->prepare("select IDSanPham from sanpham sp join  loaisanpham l on sp.IDLoai= l.IDLoai where sp.IDLoai=?");
        $stmt_idsp->execute([$_GET["maloai"]]);
            while($row=$stmt_idsp->fetch()){
                $idsp=$row["IDSanPham"];
                $stmt_soluong=$conn->prepare("delete  from soluong where IDSanPham=? ");
                $stmt_soluong->execute([$idsp]);
        
                $stmt_sp=$conn->prepare("delete  from sanpham where IDSanPham=?");
                $stmt_sp->execute([$idsp]);
                };
        
                $stmt_loai=$conn->prepare("delete  from LOAISANPHAM where IDloai=?");
                $stmt_loai->execute([$_GET["maloai"]]);
         
    }    
            
          
    
        
        

 ?>
<?php include_once "./inc/header_admin.php"; ?>

    <!-- NỘI DUNG -->
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

                <li class=" card-body" style="background:#D3EEFF">
                    <a href="quantri_loai.php" class="font-weight-bold">
                        <i class="fa-solid fa-spa"></i>
                        Loại sản phẩm

                    </a>
                </li>

                <li class=" card-body"><a href="quantri_sanpham.php" class="font-weight-bold">
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
            <!-- điều hướng thêm loại themloai.php -->
            <h3 class="text-center mt-3">Loại Sản Phẩm</h3>
            <div>
                <button type="submit" class="btn btn-warning" name="add" value="add">
                    <a href="themloai.php" class="font-weight-bold">+</a>
                </button>
            </div>

            <table class="table my-3 table-hover">

                <thead>
                    <tr>
                        <th>ID Loại</th>
                        <th>Tên loại</th>
                        <th>Thao tác</th>

                    </tr>
                </thead>
                <tbody>

                    <?php 
                     $stmt= $conn->prepare('select * from LOAISANPHAM');
                     $stmt->execute();
                     while ($row=$stmt->fetch()){
                       echo '
                       <tr>
                       <td >'.$row['IDLoai'].'</td>
                       <td>'.$row['TenLoai'].'</td>
                       <td>
                       <a href="quantri_loai.php?maloai='.$row['IDLoai'].'"
                        style="text-decoration: none; "
                       >
                         <i class="fa-solid fa-trash pr-3 text-dark"></i>
                       </a>
                       <a href="chinhsua_loai.php?maloai='.$row['IDLoai'].'" style="text-decoration: none;">
                       <i class="fa-solid fa-pen-to-square text-dark"></i>
                       </a>
                       
                     </td>
                       ';
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