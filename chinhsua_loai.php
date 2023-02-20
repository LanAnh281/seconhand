<?php
    include_once "database.php";
    $maloai='';
    $tenloai='';
 
    if(isset( $_GET['maloai'])){
    $stmt = $conn->prepare('select * from LOAISANPHAM where IDLoai=:maloai');
        // viết sql chuẩn bị
            $stmt->execute([
                'maloai'=>$_GET['maloai']
            ]); 
            // thuc thi sql
            if ($row = $stmt->fetch()) {
                $maloai=$row['IDLoai'];
                $tenloai=$row['TenLoai'];
               
            }
        }

    else if(isset($_POST['maloaimoi'])) {
        
                $stmt = $conn->prepare(
                    "UPDATE LOAISANPHAM SET IDLoai=?, TenLoai=? WHERE IDLoai=?;"
                ); 
                $stmt->execute([
                $_POST['maloaimoi'],
                $_POST['tenloai'],
                $_POST['maloaicu']]);
                // echo $_POST['maloai'] .$_POST['tenloai'] . $_POST['loaicu'];


                $maloai=$_POST['maloaimoi'];
                $tenloai=$_POST['tenloai'];

                echo '
                <script>
                    alert("Đã chỉnh sửa thành công");
                    window.location="quantri_loai.php";
                </script>
                    ';
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

                <li class=" card-body" style="background:#D3EEFF"><a href="quantri_loai.php" class="font-weight-bold">
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

        <!--  -->
        <div class="col-9 mt-3">

            <div class="text-center ">
                <h3 class="mb-3">Thêm sản phẩm </h3>
                <form method="post" action="chinhsua_loai.php">
                    <div class="form-group " style="display:none">
                        <label for="maloai1" class="text-left">Mã Loại</label>
                        <input type="text" name="maloaicu" id="maloai1" value="<?php 
                            echo $maloai;
                        ?>" placeholder="Mã loại sản phẩm">
                    </div>


                    <div class="form-group ">
                        <label for="maloai" class="text-left">Mã Loại</label>
                        <input type="text" name="maloaimoi" id="maloai" value="<?php 
                            echo $maloai;
                        ?>" placeholder="Mã loại sản phẩm">
                    </div>


                    <div class="form-group">

                        <label for="tenloai" class="text-left">Tên Loại</label>
                        <input type="text" id="tenloai" value="<?php 
                            echo "$tenloai";
                        ?>
                        " placeholder="Tên loại sản phẩm" name="tenloai">
                    </div>
                    <button type="submit" class="btn btn-primary">Sửa</button>
                </form>
            </div>
            <!--  -->

        </div>
    </div>
    <!--  -->
    <?php include_once "./inc/footer.php"; ?>
</body>

</html>