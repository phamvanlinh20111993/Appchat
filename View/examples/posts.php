<?php
   require_once '../../Controller/Persional_controller.php';
   $name = information_user();
?>

<!DOCTYPE>
<html lang="en">
<head>

  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet"  href="home_page_css.css" rel="stylesheet">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

  <script type="text/javascript">
      var user_id, information_user, max_cmt_id, num_click_hidden_cmt;
      num_click_hidden_cmt = 10;//chon la 10 vi gia tri tu 0 den 9 dung de dat class hay id cho js(mac dinh)
      max_cmt_id = -1;
      //doi thong tin nguoi dung dang dang nhap sang js
      information_user = <?php echo json_encode($name);?>;//chuyen ve object
      user_id = <?php echo $id_user; ?>;//ma nguoi dung dang online(chinh la ban)
      max_cmt_id = <?php echo (int)Max_collumn("comments", "id_cmt"); ?>;
  </script>

  <script src = "function_content_sharing.js"></script>

  <script type = "text/javascript">
    setTimeout(See_more_posts(user_id, 0), 900);//lay ma loi cua admin gui cho nguoi dung ngay khi load page
  </script>

</head>
<body style="background-image: url('../../Datasystem/18.jpg');">
     <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg" style="top:6%;">
           <div class="modal-content">
            <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h3 class="modal-title text-center">Thông tin Liên quan Bài đăng</h3>
            </div>
           <div class="modal-body" style="height:450px;">
              <div style="width: 50%;height: 96%; float:left;overflow-y: none;overflow-x: auto;">
                 <div>
                  <h4 class = "text-center" id="soluongthich"></h4>
                  <table class="table" id="nguoilikebaidang">
                  </table>
                 </div>
              </div>

              <div style="width: 50%;height: 96%; float:right;overflow-y: none;overflow-x: auto;">
                 <div>
                   <h4 class = "text-center" id="soluongdanhgia"></h4>
                   <table class="table">
                   <tr>
                    <th><center>Thông tin</center></th>
                     <th></th>
                    <th>Số sao</th>
                  </tr>
                   <tbody id="nguoidanhgiabaidang">
                   </tbody>
                  </table>
                </div>
              </div>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
         </div>
        </div>
      </div>

 <div class="container">

   <h3 class="text-center" style="color: red;">Dòng thời gian(<span style="font-size: 110%;color: blue;"><?php echo Count_length_post();?></span>)</h3>
   <div id="kt"></div><!-- dung de debug-->
   <div>
      <div id="tk"></div>
   </div>
 </div>
</body>
</html>


