<?php
  require_once '..\Controller\Persional_controller.php';
?>

<!DOCTYPE>
<html lang="html">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto Condensed', sans-serif;
            font-size: 14px;
            line-height: 1.42857143;
            color: #47525d;
            background-color: #fff;

            margin: 0;
            padding: 20px;
        }
    </style>

    <script type="text/javascript">
    //ham cho phep gui du lieu len server de cap nhat va xoa anh dai dien
    //value la gia tri la thoi gian de xac dinh anh nao can dang va xoa, id la thuoc tinh cho biet la xoa hay cap nhat
    //mac dinh voi id = 0 la xoa anh, id = 1 la cap nhat lai anh dai dien
      function Request(value, id, id1)//bien id1 dung de an gia tri voi nguoi dung
      {
        $.ajax({
            type: "POST",
            url: "../Controller/Persional_controller.php",
            data:{primary_id: value, del_or_upd: id},
            success: function(data)
            {
              if(parseInt(data) == 0){
                $('#myModal').modal('show');//hien thi modal thong bao
                setTimeout(function() { //tu dong xuat hien thong bao xoa thanh cong
                  $('#myModal').modal('hide');//sau do an
                }, 1000);
                  var VAlue = document.getElementById(id1).getElementsByClassName("caption")[0];
                  VAlue.style.display = "none";
                  var cc = document.getElementById(id1).getElementsByClassName("text-center")[0];
                  cc.style.display = "block";
                 //window.location.reload();
              }
            }
          });
      }

     //ham cho phep xoa va cap nhat anh dai dien
      function Update_Del(id, val)
      {
          var inputvalue;
          
          inputputvalue = document.getElementById(id).getElementsByTagName("input")[0];//lay gia tri ngay thang
          if(val != 0)//xoa anh dai dien
          {
            var yn = confirm("Bạn chắc chắn muốn xóa?");
            if(yn == true)
            {
              var n, n1, str = document.getElementById("num").innerHTML;

              document.getElementById("kt").innerHTML = inputputvalue.value;
              Request(inputputvalue.value, val, id);//xoa trong csdl
              document.getElementById(id).style.display = "none";
              n = str.split("gồm có ");
              n1 = n[1].split("ảnh");
              document.getElementById("num").innerHTML = "Danh Sách gồm có  "+ (parseInt(n1[0]) - 1) + " ảnh.";
            }
          }else{//cap nhat anh dai dien
            Request(inputputvalue.value, val, id);
          }
      }

    </script>
</head>

<body>
   
   <div id="myModal" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Thông báo</h4>
      </div>
      <div class="modal-body">
        <p>Cập nhật ảnh đại diện thành công.</p>
      </div>
    </div>

  </div>
</div>

  <div class="container">
    <h2 class="text-center">DaNh SácH ẢNH cỦa BẠn</h2>
    <p id="kt"></p>
    <div class="row" style="margin-top: 4%;">
      <?php

         $avatar_you = Return_val1("users", "avatar", "user_id", $GLOBALS['id_user']);//ham trong controler
         $list_avatars = array();
         $list_avatars = Show_image();
         $length_list = count($list_avatars);
         for($i = 0; $i < $length_list; $i++){
            echo "<div class='col-sm-4' id = '$i'><div class='thumbnail'>";
            foreach ($list_avatars[$i] as $key => $value) {
              if($key == "avatar")    $avatar = $value;
              else if($key == "date") $date_cr = $value;
              else                    $uid = $value;
            }
            echo "<input type = 'hidden' value='".$date_cr."'>";
            echo"<img src='".$avatar."' alt='".$uid."' style='width:100%' data-toggle='tooltip' title='Ngày đăng: ".date('d/m/Y', strtotime($date_cr))."'>";
             if($avatar_you != $avatar){
              echo"<div class='caption'>
                <button type='button' onclick = 'Update_Del(".$i.", 0)' class='btn btn-link'><span class='glyphicon glyphicon-upload'></span> Reupdate</button>
                <button type='button' onclick = 'Update_Del(".$i.", 1)' class='btn btn-link'><span class='glyphicon glyphicon-floppy-remove'></span> Xóa</button>
              </div><h4 data-toggle='tooltip' title='Không thể xóa' class='text-center' style='display:none;'> Ảnh vừa cập nhật</h4>";
            }else{
               echo"<div class='caption'><h4 data-toggle='tooltip' title='Không thể xóa' class='text-center'>Ảnh hiện tại</h4></div>";
            }
          echo"</div></div>";
         }

      ?>
   </div>
    <?php echo"<h3 class='text-left' id='num'>Danh Sách gồm có  ".$length_list." ảnh.</h3>"; ?>
  </div>
  </body>
</html>
