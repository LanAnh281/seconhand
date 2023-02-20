
<?php 
    include_once 'database.php';

    if(isset($_GET['trangthai'])){
        $stmt_trangthai=$conn->prepare("UPDATE DONHANG 
        SET TrangThai=? WHERE IDDonHang=? ;");
        $stmt_trangthai->execute([
            $_GET['trangthai'],
            $_GET['iddh']
        ]);
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
        <div class="col-9 mt-3">
            <div>
                <div>
                    <?php 
                    if(isset($_GET['iddh'])){
                        $stmt_thongtin=$conn->prepare('select * from 
                        DONHANG dh join SOLUONGDH sl on dh.IDDonHang=sl.IDDonHang
                        join TAIKHOAN tk on dh.IDTaiKhoan=tk.IDTaiKhoan
                        join SANPHAM sp on sp.IDSanPham = sl.IDSanPham
                        where dh.IDDonHang=?;
                            ');
                        $stmt_thongtin->execute([
                            $_GET['iddh']]
                        );
                
                        $ThongTin=$stmt_thongtin->fetch();
                        echo 
                        '
                          <p >ID DonHang:&nbsp;'.$ThongTin['IDDonHang'].'  </p>
                            <p>Họ và tên:&nbsp;'.$ThongTin['HoTen'].' </p>
                            <p>Địa chỉ:'.$ThongTin['DiaChi'].'</p>
                            <p>SĐT:'.$ThongTin['SDT'].'</p>
                            <p>Ngày đặt:'.$ThongTin['NgayDat'].'</p>
                            <p>Thời gian:'.$ThongTin['GioDat'].'</p>
                            Trạng thái:
                            
                            <div class="form-group row ml-2" style="display:inline-block">
                                    <div ><button type="submit" class=" btn btn-secondary ml-1 name="trangthai1" style="cursor:none" >
                                    '.$ThongTin['TrangThai'].'
                                        </button>
                                    </div>  
            
                            </div>';
                            if ($ThongTin['TrangThai'] =="chưa xử lý"){
                            echo' <div class="form-group row ml-3" style="display:inline-block">
                            <div >
                            
                            <button type="submit" class=" btn btn-primary ml-2" >
                            <a style="text-decoration:none;color:white" href="quantri_chitietdonhang.php?iddh='.$ThongTin['IDDonHang'].'&trangthai=đã xử lý">
                                đã xử lý</a>
                            </button>
                            </div>  
                            
                            </div>';}
                           else if ($ThongTin['TrangThai'] =="đã xử lý"){
                                echo' <div class="form-group row ml-2" style="display:inline-block">
                                <div >
                                
                                <button type="submit" class=" btn btn-primary ml-2" >
                                <a style="text-decoration:none;color:white" href="quantri_chitietdonhang.php?iddh='.$ThongTin['IDDonHang'].'&trangthai=chưa xử lý">
                                    chưa xử lý</a>
                                </button>
                                </div>  
                
                                </div>';};
                        
                    };
                ?>



                </div>

            </div>
            <table class="table my-3 table-hover">
                <h3 class="text-center mt-3">Đơn Hàng</h3>
                <thead>
                    <tr>

                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                if(isset($_GET['iddh'])){
                    $stmt=$conn->prepare('select * from 
                    DONHANG dh join SOLUONGDH sl on dh.IDDonHang=sl.IDDonHang
                    join TAIKHOAN tk on dh.IDTaiKhoan=tk.IDTaiKhoan
                    join SANPHAM sp on sp.IDSanPham = sl.IDSanPham
                    where dh.IDDonHang=?;
                        ');
                    $stmt->execute([
                        $_GET['iddh']]
                    );
            
                    
                while($row=$stmt->fetch()){
                    echo
                    '
                    <tr>
                        <td>'.$row['TenSanPham'].'</td>
                        <td>'.$row['SoLuong'].'</td>
                        <td>'.$row['Gia'].'</td> 
                    </tr>
                    ';
                };
        
            };
            ?>

                    <tr>
                        <td colspan="2"></td>
                        <?php 

                echo'
                <td>Thành tiền: '.$ThongTin['TongTien'].'</td>';
                ?>
                        <td></td>
                    </tr>

                </tbody>
            </table>
            <!--  -->

        </div>
    </div>
    <!--  -->
    <?php include_once "./inc/footer.php"; ?>
</body>

</html>