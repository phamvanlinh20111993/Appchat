<?php
  require_once '..\Controller\Persional_controller.php';
  $name = information_user();
  $your_pesonal = array();
  $your_pesonal = information_real_user($GLOBALS['id_user']);
?>

<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title></title>
  <meta name="author" content="Jake Rocheleau">
  <link rel="shortcut icon" href="http://designshack.net/favicon.ico">
  <link rel="icon" href="http://designshack.net/favicon.ico">
  <link rel="stylesheet" type="text/css" media="all" href="styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script type="text/javascript">

    function Change_Infor(val)
    {
        var tmpStr, inputs = document.getElementsByTagName('input');
        inputs[val].readOnly = false;
        if(val == 1){//khi kick vao nut thay doi password thi input xac nhan lai pass cung hien ra
           document.getElementById("confirm-pass").style.display = "block";
        }
        inputs[val].focus();
        tmpStr = inputs[val].value;
        inputs[val].value = "";
        inputs[val].value = tmpStr;
    }

    //ham kiem tra email co dung dinh dang khong
    function test_String(val)
    {
        var pos, pos1, inputs = document.getElementsByTagName('input');
        pos = inputs[3].value.search('@vnu.edu.vn');
        pos1 = inputs[3].value.search('@gmail.com');
        if(pos == -1 && pos1 == -1){
          return false;
        }

        return true;
    }
     
     //khong duoc chua ki tu la
    function isValid(str){
      return !/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
    }
    
    //ham kiem tra pass word
    function testPass()
    {
      var inputs = document.getElementsByTagName('input');
      var val, val1;
      val =  inputs[1].value;//pass
      val1 = inputs[2].value;//xac nhan lai pass moi
      if(val == val1)  return true;
      return false;
    }

    //ham enter sua ten va email
    function Done(e, val)
    {
      var True = false;
      if(e.keyCode == 13){
          var labels, mail_name, inputs;
          inputs = document.getElementsByTagName('input');
          labels = document.getElementsByTagName('label');
          mail_name = inputs[val].value;
         // document.getElementById("kt").innerHTML += test_String(mail_name);
         if(val == 3)
         {//ten
            if(test_String(mail_name) == true && mail_name.length <= 50){
               True = true;
            }else labels[val].style.visibility = "visible";
         }else if(val == 0)
         {//mail
            if(isValid(mail_name) == true && mail_name.length <= 100){
               True = true;
            }else labels[val].style.visibility = "visible";
         }else if(val == 2)
         {//password
            if(testPass()){
               True = true;
            }else labels[val].style.visibility = "visible";
         }
         
          if(True){
           $.ajax({
              type: "POST",
              url: "../Controller/Persional_controller.php",
              data: {Change_Infor: mail_name, know_val: val},
              success: function(data)
              {
                alert("Thay đổi thành công");
                location.reload();
              }
            });
         }
      }
    }

  </script>
  <style type="text/css">
    input{
      border: none;
      width: 300px;
      height:30px;
    }
    label{
      color: orange;
      font-weight: bold;
      font-style: Arial;
      font-size: 85%;
      visibility: hidden;
    }
  </style>
</head>
<body style="background-image: url('../Datasystem/b.jpg');">
  <div id="w" style="margin-top: 6%;">
    <div id="content" class="clearfix">
      <div id="userphoto"><img src="<?php echo $name['avatar']; ?>" alt="default avatar" style="height: 140px;width: 140px;"></div>
      <h1>Hiển thị thông tin</h1>

      <nav id="profiletabs">
        <ul class="clearfix">
          <li><a href="#bio" class="sel">Thông tin tài khoản</a></li>
          <li><a href="#settings">Thông tin cá nhân</a></li>
        </ul>
      </nav>
    <?php
      echo"<section  id='settings' class='hidden'>
        <div style='margin-top: 5%;'>
        <p class='setting'><span>Mã số sinh viên: </span> ".$your_pesonal[0]['id']."</p>
        
        <p class='setting'><span>Tên: </span> ".$your_pesonal[0]['name']."</p>
        
        <p class='setting'><span>Sinh nhật: </span> ".date('d/m/Y', strtotime($your_pesonal[0]['dateofbirth']))."</p>
        
        <p class='setting'><span>Lớp khóa học: </span> ".$your_pesonal[0]['class']."</p>
        </div>
		
      </section>";
    ?>
      <section id="bio">
        <p>Edit your user settings:</p>
        
        <p class="setting"><span>Tên <img src="../Datasystem/edit.png" alt="*Edit*" data-toggle="tooltip" title="Chỉnh sửa thông tin" onclick="Change_Infor(0)"></span> <input type = "text" value = "<?php echo $name['fullname']; ?>" readonly="true" title="Tên chứa kí tự thường độ dài 100" data-toggle="tooltip" title="Ấn enter để kết thúc" onkeypress="Done(event, 0)"><label>Kí tự thường, số</label></p>

        <p class="setting"><span>Password <img src="../Datasystem/edit.png" alt="*Edit*" data-toggle="tooltip" title="Chỉnh sửa thông tin độ dài 100" onclick="Change_Infor(1)"></span> <input type = "password" value = "<?php echo $GLOBALS['pass_user']; ?>" readonly="true" title="mật khẩu dài không quá 100 kí tự"><label></label></p>
        <p class="setting" style="display: none;" id="confirm-pass"><span>Confirm pass</span> <input type = "password" class="form-control" value = "" data-toggle="tooltip" title="Ấn enter để kết thúc" onkeypress="Done(event, 2)" placeholder="xác nhận lại pass"><label>Xác nhận sai</label></p>
        
        <p class="setting"><span>Địa chỉ mail <img src="../Datasystem/edit.png" alt="*Edit*" data-toggle="tooltip" title="@gmail hoac @vnu độ dài 100" onclick="Change_Infor(3)"></span> <input type = "text" value = "<?php echo $name['vnumail']; ?>" readonly="true" data-toggle="tooltip" title="Ấn enter để kết thúc" onkeypress="Done(event, 3)"><label>Không đúng định dạng</label></p>
		
		    <p class="setting"><span>Trạng thái </span> <?php if(Admin()==true){echo "Quản trị viên";}else{echo"Người dùng";} ?></p>
		
		    <p class="setting"><span data-toggle="tooltip" title="Tạo tài khoản trên website">Ngày khời tạo </span> <?php echo Change_date($name['date']);?></p>
      </section>
    </div><!-- @end #content -->
  </div><!-- @end #w -->

<script type="text/javascript">
  $(function(){
    $('#profiletabs ul li a').on('click', function(e){
       e.preventDefault();
       var newcontent = $(this).attr('href');
    
       $('#profiletabs ul li a').removeClass('sel');
       $(this).addClass('sel');
    
       $('#content section').each(function(){
         if(!$(this).hasClass('hidden')) { $(this).addClass('hidden'); }
       });
    
       $(newcontent).removeClass('hidden');
    });
  });
</script>
</body>
</html>