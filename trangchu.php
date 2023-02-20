<?php  
    include_once "database.php";
    session_start();
    
    if(isset($_POST['SDT'])){
        $stmt=$conn->prepare('select *from TAIKHOAN where SDT=? and MatKhau=? and HanDung="1"');
        $stmt->execute([$_POST['SDT'],md5($_POST['MK'])]);
        if($row=$stmt->fetch()){
            
            $_SESSION['hoten']=$row['HoTen'];
            $_SESSION['IDTK']=$row['IDTaiKhoan'];
            $_SESSION['VAITRO']=$row['VaiTro'];
            if($_SESSION['VAITRO']=='admin'){
                header('Location: quantri.php');
            }
            
        }
        else {
            header('Location: dangky.php');
        }
    }
?>
<?php include_once "./inc/header.php"; ?> 
<!--  -->
        <h3 class="text-center font-italic mt-3">BẠN ĐÃ BÁN QUẦN ÁO CŨ CỦA MÌNH BAO GIỜ CHƯA ?</h3>
        <h3 class="text-center font-italic mt-4">GIVE AWAY CẦN THƠ</h3>
        <h4  class="text-center font-italic mt-3">4/9 An Khánh, Ninh Kiều, Cần Thơ</h4>
        <h4 class="text-center font-italic mt-3">Open: 9h-22h </h4>
        

        <!-- Thông tin về GA -->
        <div class=" text-center">
            <img src="img/cuahang.PNG" alt="" class="rounded img-fluid">
        </div>
        <h3 class="mt-4 text-center text-dark">Thông tin về Give Away Cần Thơ</h3>
        <div class="card mb-5" >
            <div class="card-body"style="background-image:url('img/nen.jpg') ;">
                Việc sản xuất ra bất kỳ một sản phẩm nào đều cần sử dụng tài nguyên và nguyên liệu,
                mà cụ thể là từ bông để dệt vải, khai thác gỗ, chặt phá rừng để trồng bông,...Vì thế, nếu bạn chọn dùng
                đồ second hand nghĩa là bạn đang làm giảm bớt việc sử dụng các nguồn tài nguyên môi trường đấy.
                Hình thức tái sử dụng chỉ hiệu quả khi có cộng đồng. Give Away đã xây dựng được cộng đồng với 1 triệu
                người dùng trên tổng các mạng xã hội, giúp mình có thể thêm kết nối. Đồng thời, mình được trải nghiệm những câu chuyện thời trang 
                thú vị từ khách hàng, xoay quanh những món thời trang hiếm có khó tìm. Đó là 2 điều mình cảm thấy may mắn nhất khi phát triển
                Give Away.
            </div>
          </div>
           
        
          <div class="card">
                    <p class="card-header" data-toggle="collapse" data-target="#kygui">1.Ký gửi</p>
                    <div id="kygui" class="collapse card-body">
                        <ul>
                            <li>Tiêu chí ký gửi:<br>
                                Giá ký gửi là giá thanh lý. Lấy sức hút, tình trạng của sản phẩm tại thời điểm bán 
                                để làm tiêu chuẩn định giá thanh lý. Dựa trên 3 yếu tố chính: chất liệu, kiểu dáng, thương hiệu.
                            </li>
                            <li>Thời gian ký gửi <br>
                                Từ 50 đến 70 ngày phụ thuộc vào thời điểm gửi hàng.
                            </li>
                        </ul>

                    </div>
                
                <div class="card">
                    <p class="card-header" data-toggle="collapse" data-target="#lamsaokygui">2.Làm sao ký gửi</p>
                    <div id="lamsaokygui" class="collapse card-body">
                        <ul>
                            <li>Ký gửi offline:<br>
                                Trước khi đến ký gửi, các chị vui lòng truy cập vào website:
                                <a href="#">giveaway</a> để đặt lịch, hy vọng các chị sẽ đến đúng giờ 
                                để có thể phục vụ tốt nhất ạ.
                            </li>
                            
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <p class="card-header" data-toggle="collapse" data-target="#muasam">3. Mua sắm</p>
                    <div id="muasam" class="collapse card-body">
                        <ul>
                            <li>Mua sắm offline:<br>
                               Nếu ở nội thành Cần Thơ khuyến khích chị em đến trực tiếp tại cửa hàng.
                               Vì dễ dàng check và xem được hơn 2000 sản phẩm khác.
                            </li>
                            <li>Mua sắm online: <br>
                                Hàng còn lại sau khi mở bán trực tiếp, sẽ bắt đầu được chốt online sau 2-3 tiếng cùng ngày. Admin page check tin nhắn theo thứ tự từ dưới lên trên.
                            </li>
                        </ul>
                    </div>
                </div>    
            </div>
            <!-- <img src="img/cogai.PNG" class="col-4 img-fluid mt-2" alt=""> -->
        
            
                
           
    <?php include_once "./inc/footer.php" ;?> 
        
   
</body>
</html>