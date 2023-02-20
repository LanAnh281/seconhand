<?php 
  include_once "database.php";
  session_start();
  if(isset($_SESSION['hoten'])){
  } 
  else {
    header("Location: dangnhap.php");
  }


// Thời gian 
date_default_timezone_set('Asia/Ho_Chi_Minh');   
$now = getdate();

$currentTime = $now["hours"] . ":". $now["minutes"] . ":". $now["seconds"];

$currentDate = $now["year"] . ".". $now["mon"] . ".". $now["mday"];

$currentWeek = $now["wday"] . ".";
// Insert đơn hàng chưa có tổng tiền
if(isset($_POST['dathang'])){
    $SP = array();
    $query = "INSERT INTO `secondhand`.`donhang` (`IDTaiKhoan`, `NgayDat`, `GioDat`, `TrangThai`) 
    VALUES (?,?,?,?);";
    
    $sth = $conn->prepare($query);
    $sth->execute([
        $_SESSION['IDTK'],    
           
        $currentDate,
        $currentTime,
        'chưa xử lí'
    ]);
    // Tìm đơn cuối cùng
    $query = "select max(IDDonHang) as max from `secondhand`.`donhang` ";
    $sth = $conn->prepare($query);
    $sth->execute();
    $row_max=$sth->fetch();
    $max=$row_max['max'];
    // echo "IDDH:".$row['max'];
    #tìm giỏ
    $query = "select * from `secondhand`.`soluonggh` where IDTaiKhoan=?;";
    $sth_gh = $conn->prepare($query);
    $idsp='';
    $soluong=1; 
    $tong=0;
    $sth_gh->execute([$_SESSION['IDTK']]);

   
    while ($row= $sth_gh->fetch()){
       
        #Lấy idsp và slsp ở giỏ hàng
        $idsp=$row['IDSanPham'];
        $sl=$row['SoLuong'];
        $tensize='';
        $tensize=$row['TenSize'];
        // echo "TENSIZE:" .$tensize;
        // Xác định idsize
        $query_size = "select * from `secondhand`.`size` where Ten=?";
        $sth_size = $conn->prepare($query_size);
        $sth_size->execute([$tensize]);
        $idsize='';
        if ($row_size=$sth_size->fetch()){
            $idsize=$row_size['IDSize'];
        }
        // echo "IDSIZE:".$idsize;

        #tìm số lượng của sp
        $query_soluong = "select * from `secondhand`.`soluong` where IDSanPham=? and IDSize=?;";
        $sth_soluong = $conn->prepare($query_soluong);
        $sth_soluong->execute([$idsp,$idsize]);
        
        if($row_soluong=$sth_soluong->fetch()){
            // echo $row_soluong['SoLuong'];
            
            if($sl<=$row_soluong['SoLuong']){
                // echo "SLDD".$sl;
                $query_dh = "INSERT INTO `secondhand`.`soluongdh` (`IDDonHang`, `IDSanPham`, `SoLuong`, `TENSize`) 
                VALUES (?,?,?,?);";
                $sth_dh = $conn->prepare($query_dh);
                $sth_dh->execute([$max,$idsp,$sl,$tensize]);
                #tinh tong dựa vào bảng sp
                $query_sp = "select * from `secondhand`.`sanpham` where IDSanPham=?";
                $sth_sp = $conn->prepare($query_sp);
                $sth_sp->execute([$idsp]);
                $dongia=0;
                $row_sp=$sth_sp->fetch();
                $dongia=$row_sp['Gia'];
                $tong=$tong+$sl*$dongia;
                
                #update số lượng mới
                $slmoi=0;
                $slmoi=$row_soluong['SoLuong']-$sl;
                // echo "slmoi:".$slmoi;
                if($slmoi>0){
                    $query_slm = "UPDATE `secondhand`.`soluong` SET `SoLuong` = ? WHERE IDSanPham = ? and IDSize=?;";
        
                    $sth_slm = $conn->prepare($query_slm);
                    $sth_slm->execute([
                        $slmoi,
                        $idsp,
                        $idsize
                    ]);
                }
                else if($slmoi==0) {
                    $query_xoa = "delete from `secondhand`.`soluong`   WHERE IDSanPham = ? and IDSize=?;";
        
                    $sth_xoa = $conn->prepare($query_xoa);
                    $sth_xoa->execute([
                        $idsp,
                        $idsize
                    ]);

                    $query_conlai = "select count(*) as conlai from `secondhand`.`soluong` where IDSanPham=? ; ";
                    $sth_conlai = $conn->prepare($query_conlai);
                    $sth_conlai->execute([$idsp]);
                    $row_count=$sth_conlai->fetch();
                    // echo "Tồn tại".$row_count['conlai'];
                    if($row_count['conlai']==0){
                    $query = "UPDATE `secondhand`.`sanpham` SET `TonTai` = ? WHERE (`IDSanPham` = ?);";
        
                    $sth = $conn->prepare($query);
                    $sth->execute([
                        '0',
                        $idsp
                    ]);}
                    
                }
                
                // xóa dòng giỏ hàng 
                $query= "DELETE FROM `secondhand`.`soluonggh` WHERE (`IDTaiKhoan` = ? and IDSanPham=?)";
        
                $sth = $conn->prepare($query);
                $sth->execute([
                    $_SESSION['IDTK'],
                    $idsp
            ]);
                
            }

            else {
                array_push($SP,$idsp); 
                
                // echo 'sl>sl còn lại';
            }
        }

    }
        if($tong>0){
        $query = "UPDATE `secondhand`.`donhang` SET `TongTien` = ? WHERE (`IDDonHang` = ?);";
        $sth = $conn->prepare($query);
        $sth->execute([
            $tong, $max
        ]);
    }
    else{
        $query = "DELETE from`secondhand`.`donhang` where (`IDDonHang`=? );"; 
        
        $sth = $conn->prepare($query);
        $sth->execute([$max]) ;
        
    }
   
     if(count($SP)>0){
        echo '<script> 
      choice=confirm("số lượng sản phẩm còn lại nhỏ số lượng sản phẩm đã đặt");

      if (choice==true){
        history.back()
      }
      else {
        window.location="donhang.php";
      }
      </script>';
     }
     
    }





//  ***Thêm vào đơn hàng của mua ngay
  else if(isset($_POST['soluong'])){
    
    
    $stmt_size=$conn->prepare('select * from sanpham sp  join SOLUONG sl on sp.IDSanPham = sl.IDSanPham 
    join size s on s.IDSize=sl.IDSize
    where sl.IDSanPham=? and sl.IDSize=?;');
    
    $stmt_size->execute([$_POST['idsp'],$_POST['ms']]);
    if ($row_size=$stmt_size->fetch()){
        $ten_size='';
        
        $ten_size= $row_size['Ten'];
    };
    
    
    if($row_size['SoLuong']< $_POST['soluong']){
    //   echo "slsp nhỏ sldat";
      echo '<script> 
      
   
      choice=confirm("số lượng sản phẩm còn lại nhỏ số lượng sản phẩm đã đặt");

      if (choice==true){
        history.back()
      }
      else {
        window.location="trangchu.php";
      }
      </script>';
    
    }
    
    else {
    
    $tongtien=0;
    $stmt_tien=$conn->prepare('select * from SANPHAM where idsanpham=?');
    $stmt_tien->execute([$_POST['idsp']]);
    if($row=$stmt_tien->fetch()){
     
      $tongtien=$row['Gia']*$_POST['soluong'];
    }
    // echo $tongtien;
    date_default_timezone_set('Asia/Ho_Chi_Minh');   
    $now = getdate();
    
    $currentTime = $now["hours"] . ":". $now["minutes"] . ":". $now["seconds"];

    $currentDate = $now["year"] . ".". $now["mon"] . ".". $now["mday"];

    $currentWeek = $now["wday"] . ".";

    $stmt=$conn->prepare('insert into DONHANG (IDTaiKhoan, TongTien,NgayDat,GioDat,TrangThai)
                          values (?,?,?,?,?)');
    
    // echo $_POST['thanhtien'];
    $stmt->execute([
      $_SESSION['IDTK'],
      $tongtien,
      $currentDate,
      $currentTime,
      'chưa xử lý'
    ]);
    $max_id=0;
    $stmt_max=$conn->prepare('select max(IDDonHang) as max from DONHANG ');
    $stmt_max->execute();
    $row_max= $stmt_max->fetch();
    $max_id=$row_max['max'];
    // echo $max_id;


    $stmt=$conn->prepare('insert into SOLUONGDH (IDDonHang,IDSanPham,SoLuong,TENSize)
                          values (?,?,?,?);');
    $stmt->execute([
      $max_id,
      $_POST['idsp'],
      $_POST['soluong'],
      $ten_size                     
    ]); 
    
    $soluong_moi=$row_size['SoLuong']-$_POST['soluong'];
    if($soluong_moi==0){
      $stmt_xoa=$conn->prepare('delete  from SOLUONG where IDSanPham=? and IDSize=?;');
      $stmt_xoa->execute([$_POST['idsp'],$_POST['ms']]);
    
      $stmt_dem=$conn->prepare('select count(*) as dem  from SOLUONG where IDSanPham=? ');
      $stmt_dem->execute([$_POST['idsp']]);
        
    $row_dem=$stmt_dem->fetch();
    if($row_dem['dem']==0){
      $stmt_sl=$conn->prepare('update  SanPham set  TonTai=? where IDSanPham=? ;');
      $stmt_sl->execute(['0',$_POST['idsp']]);
    }
}
    else {

    $stmt_sl=$conn->prepare('update  SOLUONG set  SoLuong=? where IDSanPham=? and IDSize=?;');
   
      
    $stmt_sl->execute([$soluong_moi,$_POST['idsp'],$_POST['ms']]);
    }
    
  }

  }
?>
<?php include_once "./inc/header.php"; ?>
    <!-- Đơn hàng-->
    <table class="table my-3 table-hover">
        <h3 class="text-center mt-3">Danh Sách Đơn Hàng</h3>
        <thead>
            <tr>
                <th>Ngày đặt</th>
                <th>Thời Gian</th>
                <th>Thành Tiền</th>
                <th>Trạng thái</th>
                <th class="text-center">Thao tác</th>

            </tr>
        </thead>
        <tbody>

            <tr>
                <?php 
        $stmt_dh=$conn->prepare('select * from DONHANG dh natural join taikhoan where IDTaiKhoan=?');
        $stmt_dh->execute([$_SESSION['IDTK']]);
        while ($row_dh=$stmt_dh->fetch())
        echo '<tr>
          <td>'.$row_dh['NgayDat'].' </td>
          <td>'.$row_dh['GioDat'].'</td>
          <td>'.$row_dh['TongTien'].'</td>
          <td>'.$row_dh['TrangThai'].'</td>
          <td class="text-center">
              <a href="chitietdonhang.php?iddh='.$row_dh['IDDonHang'].'" style="text-decoration: none;color: black;">
                  <i class="fa-solid fa-circle-info"></i>
              </a>
          </td>
        </tr>';

        ?>
            </tr>


        </tbody>
    </table>

  <?php include_once "./inc/footer.php"; ?>
</body>

</html>