<?php 
  include_once "database.php";
  session_start();

?>
<?php include_once "./inc/header.php"; ?>
    <!-- Đơn hàng-->

    <table class="table my-3 table-hover">
        <h3 class="text-center mt-3">Mua Ngay</h3>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Size</th>
                <th>Số lượng</th>
                <th class="text-center">Đơn giá</th>


            </tr>
        </thead>
        <tbody>
            <form method="POST" action="donhang.php" id="form_register">
                <?php 
            if(isset($_GET['masp'])){
              $stmt=$conn->prepare('select * from sanpham where IDSanPham=?;');
              $stmt->execute([$_GET['masp']]);
              $row=$stmt->fetch();
              echo '<input name="idsp" style="display:none" value="'.$row['IDSanPham'].'"></input>';
              echo '
              <tr>
                <td>'.$row['IDSanPham'].'</td>
                <td >'.$row['TenSanPham'].'</td>
                <td>

                <select name="ms" id="size" class="py-1" required>
                  <option value="">Chọn size sản phẩm</option>
                  <div class="form-group "> ';
                
                $stmt_size=$conn->prepare('select * from sanpham natural join SOLUONG natural join Size
                                          where IDSanPham=?;');
                $stmt_size->execute([$_GET['masp']]);
                
                while ($row_size=$stmt_size->fetch()){
                         echo'                        
                        <option value="'.$row_size['IDSize'].'" >'.$row_size['Ten'].'</option>
                       ';

                       }
              echo'
                    </select>
                  </div>
                </td>
                <td>
                  <input name= "soluong" id ="sl" type="number" value="1" min="1" max="" style="width:55px;" id="soluong"
                  onchange="checkTextbox(this)">
                </td>
                <td class="text-center" name="gia">'.$row['Gia'].'</td>
              
              </tr>';
            };
          ?>

                <tr>
                    <td colspan="3"></td>

                    <td id='tong' class="text-center">
                        Thành tiền
                    </td>
                    <td id='result' class='text-center' name="thanhtien" value="">
                        <?php echo ''.$row['Gia'].''; ?>
                    </td>
                </tr>

                <!-- Bắt sự kiện thay đổi số lượng và thành tiền -->
                <?php 
                $soluong=1;
                echo ' <script>
                  function checkTextbox(element){
                      var sl = document.getElementById("sl").value;
                      var tong=sl*'.$row['Gia'].';
                      var div=document.getElementById("result");
                      document.getElementById("result").value=tong
                      // alert(document.getElementById("result").value);
                      div.innerHTML=tong;

                  }
               
                </script>';
            
              ?>
                <script>
                $(document).ready(function() {
                    $('#form_register').submit(function() {

                        // BƯỚC 1: Lấy dữ liệu từ form
                        var username = $.trim($('#size').val());
                        var password = $.trim($('#sl').val());


                        // BƯỚC 2: Validate dữ liệu
                        // Biến cờ hiệu
                        var flag = true;

                        // Username
                        if (username == 0) {
                            $('#username_error').text('Tên đăng nhập phải lớn hơn 4 ký tự');
                            flag = false;
                        } else {
                            $('#username_error').text('');
                        }

                        // Password
                        if (password.length <= 0) {
                            $('#password_error').text('Bạn phải nhập mật khẩu');
                            flag = false;
                        } else {
                            $('#password_error').text('');
                        }



                        return flag;
                    });
                });
                </script>
        </tbody>
    </table>


    <div class="text-center">
        <button type="submit" class="btn btn-warning" name="muangay" value="dathang">
            Đặt hàng
        </button>
    </div>
    </form>


    <?php include_once "./inc/footer.php"; ?>

</body>

</html>