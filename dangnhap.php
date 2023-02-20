<?php
  include_once "./database.php";
  session_start(); 
  
  if (isset($_POST['name'])){
    $query = ' select * from TAIKHOAN where SDT=?';
    $sth = $conn->prepare($query);
    $sth->execute([
      $_POST['sdt']
    ]);

      if(!$row=$sth->fetch()) {
      $query = ' INSERT INTO TAIKHOAN (HoTen, DiaChi, email, SDT, MatKhau, vaiTro,HanDung)
      VALUES (?,?,?,?,?,?,?)';
      try{
        
        $sth = $conn->prepare($query);
        $sth->execute([
          $_POST['name'],
          $_POST['diachi'],
          $_POST['email'],
          $_POST['sdt'],
          md5(  $_POST['password']),
          'user',
          '1'
        ]);
      }catch (PDOException $e){
        
      }
     

    }
    else {
      header('Location: dangky.php');
    }
  }
?>
<?php include_once "./inc/header.php"; ?>
   
    <div class="mx-5">
      <form class="mt-5 mb-5" method="POST"action="trangchu.php" style="border: solid 1px blue;">
        <h2 class=" bg-light text-dark p-3 text-center">Đăng nhập</h2>

        <div class="form-group row text-center">
            <label for="sdt" class="col-3  font-weight-bold col-form-label ">SĐT</label>
            <div class="col-9 ">           
                <input type="text" class="form-control w-75" 
                id="sdt" placeholder="Nhập SĐT" name="SDT">
            </div>
        </div>

        <div class="form-group row text-center">
          <label for="pass" class="col-3  font-weight-bold col-form-label ">Mật khẩu</label>
          <div class="col-9 ">           
              <input type="password" class="form-control w-75" 
              id="pass" placeholder="Nhập mật khẩu" name="MK">
          </div>
        </div>
      
        <div class="form-group row">
            <label for="" class="col-3"></label>
            <div class="col-9">
              
            <button type="submit" class=" btn btn-primary ml-3 mb-3">
            Đăng nhập
            </button></div>
              
        </div>
    
      </form>
    </div>
    
    <?php include_once "./inc/footer.php"; ?>
</body>
</html>