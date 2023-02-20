<?php 
    include "database.php";  
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

                <li class=" card-body"><a href="quantri_sanpham.php" class="font-weight-bold">
                        <i class="fa-solid fa-leaf"></i>
                        Sản phẩm

                    </a>

                </li>

                <li class=" card-body" style="background:#D3EEFF"><a href="quantri_donhang.php"
                        class="font-weight-bold">
                        <i class="fa-solid fa-leaf"></i>
                        Danh sách đơn hàng
                    </a>

                </li>

            </ul>
        </div>
        <!--  -->
        <div class="col-9 mt-3">

            <table class="table my-3 table-hover">
                <h3 class="text-center mt-3">Danh Sách Đơn Hàng</h3>
                <thead>
                    <tr>
                        <th>ID đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Thời Gian</th>
                        <th>Thành Tiền</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Thao tác</th>

                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $stmt=$conn->prepare('select * from DONHANG');
                    $stmt->execute();
                    while ($row=$stmt->fetch()){
                        echo 
                        '
                        <tr>
                            <td >'.$row['IDDonHang'].'</td>
                            <td >'.$row['NgayDat'].'</td>
                            <td>'.$row['GioDat'].'</td>
                            <td>'.$row['TongTien'].'</td>
                            <td>'.$row['TrangThai'].'</td>
                            <td class="text-center">
                                <a href="quantri_chitietdonhang.php?iddh='.$row['IDDonHang'].'" style="text-decoration: none;color: black;">
                                    <i class="fa-solid fa-circle-info"></i>
                                </a>
                            </td>
                        </tr>
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