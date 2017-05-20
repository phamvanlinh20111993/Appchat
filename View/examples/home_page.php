<?php
    require_once '..\..\Controller\users_controller.php';
    $name = information_user();

    Online_minute(2400);//45 phut, sau 45 phut he thong se tu dong dong lai, yeu cau nguoi dung phai dang nhap lai tu dau
    //dieu nay la bat buoc vi day chi la webside tai hoac chia se phan mem
	  if(!isset($_SESSION['id']) && !isset($_SESSION['pass'])){
		    header('Location: ../../view/login_register.php', true, 301);
	  }
?>

<!DOCTYPE html>
<!-- release v4.3.6, copyright 2014 - 2016 Kartik Visweswaran -->
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home Page</title>
        <!--Danh gia bai viet -->
       <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
       <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
       <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
       <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" type="text/javascript">
       </script>
       <link rel="stylesheet" href="rating/css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
       <script src="rating/js/star-rating.js" type="text/javascript"></script>
       
       <!-- Upload file -->
       <link href="../css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
       <link rel="stylesheet"  href="home_page_css.css" rel="stylesheet">
       <!--khong ket noi mang -->
     <!--  <link rel="stylesheet" href="../bootstrap-3.3.7/dist/css/bootstrap.min.css">
       <link rel="stylesheet" href="../bootstrap-3.3.7/dist/css/bootstrap-theme.css">
       <script src="../bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>-->
          <!--  <script src = "../jquery-3.1.1.min.js"></script> -->
          <style type="text/css">
          .modal.modal-wide .modal-dialog {
              width: 90%;
          }

          .modal-wide .modal-body {
              overflow-y: auto;
          }

          .modal-content textarea.form-control {
               min-width: 100%;
          }

          .popup-box-chat{
            display:none;
            position: fixed;
            bottom: 2px;
            right: 220px;
            height:392px;
            margin-right: 10%;
            background-color: white;
            box-shadow: 1px 2px 5px #ccccff;
            width: 300px;
            border: 1px solid rgba(29, 49, 91, .3);
          }

          .tooltip111 {
            position: relative;
            display: inline-block;
          }

          .tooltip111 .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color:#ccffcc;
            color: black;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            top: 50%;
            left: 10%;
          }

          .tooltip111 .tooltiptext::after {
              content: "";
              position: absolute;
              bottom: 100%;
              left: 35%;
              margin-left: -5px;
              border-width: 5px;
              border-style: solid;
              border-color: transparent transparent #ccffcc  transparent;
          }

          .tooltip111:hover .tooltiptext {
              visibility: visible;
          }

          .close1{
           height:30px;
           width:45px;
           text-align: center;
           background-color: white;
           border: none;
           margin-top:5px;
           text-decoration: none;
           display: inline-block;
           font-size: 16px;
           cursor: pointer;
           line-height:30px;
           float:right;
           border-radius: 5px;
          }

          .close2 {
            background-color: white; 
            color: black; 
            border: 2px solid #4CAF50;
          }

          .close2:hover {
            background-color: #4CAF50 ; 
            color: black; 
            border: 2px solid #4CAF50;
          }
           
           .boxchat_body{
              min-height:30px;
              padding:10px;
              word-wrap:break-word;
              max-width:200px;
              border:1px solid #bcd1c6;
              background-color: #e9eaed;
              border-radius: 50px;
              margin-left:5px;
              /*position:inherit;*/
          }

          .boxchat_body.boxchatbody{
              border:1px solid green;
              background-color: lightblue;
              border-radius: 50px;
              margin-left:64px;
             /*position:inherit;*/
          }

          .boxchat_body.centerbox{
            margin-left:35px;
            font-size:120%;
            background-color:yellow;
          }
        </style>

        <script src="../js/fileinput.js" type="text/javascript"></script>

        <script src="http://127.0.0.1:5555/socket.io/socket.io.js"></script><!--them dia chi ip cua ban-->
        <script src="nguoidung.js"></script><!--file chat box nhieu nguoi dung trong node js-->

        <script type="text/javascript">
            // cac bien toan cuc
            var user_id, information_user, max_cmt_id, num_click_hidden_cmt;//vi tri danh dau la 10
			      num_click_hidden_cmt = 10;//chon la 10 vi gia tri tu 0 den 9 dung de dat class hay id cho js(mac dinh)
			      max_cmt_id = -1;
            //doi thong tin nguoi dung dang dang nhap sang js
            information_user = <?php echo json_encode($name);?>;//chuyen ve object
            user_id = <?php echo $id_user; ?>;//ma nguoi dung dang online(chinh la ban)
            max_cmt_id = <?php echo (int)Max_collumn("comments", "id_cmt"); ?>;
            // user_infor = jQuery.parseJSON(information_user);
            //  user_infor = JSON.parse( information_user);
            //  console.log(information_user);
            
           //thong tin nguoi dung online
           function Request_online()
           {
               var Obj, index, length, element;

               $.ajax({
                  type: "POST",
                  url: "../../Controller/users_controller.php",
                  data: {request:1},
                  success: function (data)
                  {
                    Obj = JSON.parse(data);
                    length = Object.keys(Obj).length;//lay do dai cua mang object
                    element = "";
                        
                    document.getElementById("songuoionline").innerHTML = "Online(" + length + ")";
                    document.getElementById("danhsachan").style.display = "none";
                         
                    for(index = 0; index < length; index++)
                    {
                        element += "<table style='margin-left:40px;'><tr style='height:45px;'><td><img src='../"+ Obj[index].avatar +"' style='height:48px;width:48px;'></td>";
                        element += "<td style='margin-left:10px;'><a onclick = 'chatbox_popup(101000,"+user_id+","+Obj[index].userid+")' class='a8'><i>"+ Obj[index].fullname+ "</i></a></td></tr></table><input type='hidden' value='"+Obj[index].fullname+"' id = '101000'><br>";
                    }
                         
                     document.getElementById("danhsachhien").style.display = "block";
                     document.getElementById("danhsachhien").innerHTML = element;
                  }
                });
           }
           window.setInterval("Request_online()", 60000); //60s cap nhat nhung ai online tren trang web

          //khi nguoi dung dang bai dang
          function Submit_form()
          {
             var comment, file, topic, t, yesorno;
             comment = document.getElementById("comment").value;
             file = document.getElementById("file-0a").value;
             if(file != ""){
                name_of_file = document.getElementById("file-0a").files[0].name;
             }
             t = document.getElementById("topic");
             topic = t.options[t.selectedIndex].value;//lay gia tri trong the select

             if(topic == "00000"){//ma chu de mac dinh co gia tri ooooo
                document.getElementById("chua-chon-chu-de").style.display = "block";
             }else if(comment == "" || file == ""){
                yesorno = confirm("Hãy viết gì đó, hoặc chọn file upload");
                if(yesorno == true){
                   if(comment == "") document.getElementById("comment").focus(); 
                }
              }else if(Control_post_comment(comment) || Control_post_comment(name_of_file)){
                alert("Warning!!! Không đăng bài nói tục chửi bậy trên web");
                document.getElementById("comment").focus(); 
              }else{
                  document.getElementById("chudenan").value = topic;//gan vao trong form de submit
                  document.getElementById("form_main").submit();
              }
          }

          //ham request loi cua nguoi dung neu bi admin xoa bai dang
          function Request_er()
          {
            var lists, Length, index, ele = "";
            $.ajax({
                type: "POST",
                url: "../../Controller/users_controller.php",
                data: {request_er:1, uid: user_id},
                success: function (data)
                {
                  lists = JSON.parse(data);
                  Length = Object.keys(lists).length;
                  document.getElementById("noticefromadmin").innerHTML = "";
                  document.getElementById("noticefromadmin1").innerHTML = 'Thông báo từ quản trị viên('+Length+'): ';
                  ele = '<div id="thongbaoloituquantri"><ol type="1">';
                  for(index = 0; index < Length; index++)
                  {
                    ele += '<input type = "hidden" name="angiatriloi'+index+'" value = "'+lists[index].id_er+'">';
                    ele += '<input type = "hidden" name="angiatriloi'+index+'" value = "'+lists[index].name+'">';
                    ele += '<input type = "hidden" name="angiatriloi'+index+'" value = "'+lists[index].post_id+'">';
                    ele += '<input type = "hidden" name="angiatriloi'+index+'" value = "'+lists[index].time_post+'">';
                    ele += '<input type = "hidden" name="angiatriloi'+index+'" value = "'+lists[index].name_topic+'">';
                    ele += '<input type = "hidden" name="angiatriloi'+index+'" value = "'+lists[index].er_cd+'">';
                    ele += '<li style="margin-top:3%;">Admin đã gửi thông báo về lỗi bài đăng của bạn. <a onclick = "Show_er('+index+')" style="cursor:pointer;" data-toggle="tooltip" title="Click vào xem chi tiết">Mã lỗi: '+lists[index].er_cd+'</a>';

                  }
                  ele += '</li></ol></div>';
                  document.getElementById("noticefromadmin").innerHTML = ele;
                }
            });
          }

          setTimeout(Request_er, 900);//lay ma loi cua admin gui cho nguoi dung ngay khi load page
          setInterval(Request_er, 10000);//lay ma loi cua admin gui cho nguoi dung cu 10s load 1 lan

        </script>

        <script src="function_content_sharing.js"></script>
        <script type="text/javascript">

          //refresh lai trang web
          function Back_to_page()
          {
            window.location.reload();
          }

          //hien thi bai dang theo chu de tim kiem
          function Hienthitheochude()
          {
            //$('#phanhienthibaidang').load(document.URL + ' #phanhienthibaidang');
            var giatri = document.getElementById("timkiemgiatri").value;
            if(giatri!=""){
              document.getElementById("phanhienthibaidang").innerHTML = "<div id = 'tk'></div>";
              document.getElementById("phanhienthibaidang").innerHTML += See_more_posts("", giatri);
            }else{
              document.getElementById("phanhienthibaidang").innerHTML = "<div id = 'tk'><div class='alert alert-info'><strong>Info!</strong> Không thể tìm kiếm</div> <button type='button' class='btn btn-link' onclick='Back_to_page()'> <span class='glyphicon glyphicon-backward'></span> Quay lại trang web</button></div>"; 
            }
          }

        </script>
    </head>
	
    <body data-spy="scroll" data-target=".navbar" data-offset="0">
	    <!-- Nav bar in boostrap -->
      <!-- Moi bai bang se co so nguoi thich va danh gia bai dang, tao 1 pop up de hien thi chi tiet 
      thong tin nhung ai da thich bai viet, danh gia tai lieu-->
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

      <!--Pop up de gui phan hoi cua nguoi dung-->
      <div id="myModal1" class="modal fade" style="margin-top: 4%;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="Close_modal()">&times;</button>
              <h4 class="modal-title" id="tieudemodal">Phản hồi bài đăng của </h4>
            </div>
            <div class="modal-body">
               <div class="form-group" id="phanhoivebaidang">
                 <p class="text-left">Chủ đề: </p>
                 <p class="text-left">Tên file: </p>
                 <p class="text-left">Nội dung phản hồi: </label>
                 <input type="hidden" value="">
               </div>
               <input type="text" id="comments111" class="form-control" placeholder="Report problem here...">
               <div class="alert alert-info" id="canhbaoloi" style="display: none;">
                  <strong>Info!</strong> Bạn phản hồi về vấn đề gì của bài đăng???
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="Report_problem_server()">Gửi phản hồi</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <!--Pop up de gui phan hoi cua nguoi dung-->
      <div class="modal fade" id="myModal2" role="dialog" style="margin-top: 5%;">
        <div class="modal-dialog">
    
         <!-- Modal content-->
         <div class="modal-content">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Trang web của chúng tôi cho biết:</h4>
           </div>
            <div class="modal-body">
               <div id="thongbaoxoabaidangtuquantrivien">
               </div>
            </div>
            <div class="modal-footer">
             <button type="button" class="btn btn-danger" data-dismiss="modal">Đồng ý</button>
            </div>
          </div>
      
        </div>
      </div>

	    <nav class="navbar navbar-inverse" data-spy="affix" data-offset-top="0">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">BloG SharE FiLe</a>
				</div>
				<ul class="nav navbar-nav">
					<li class="active"><a href="<?php if($_SESSION['Admin'] == 0){
                       echo"home_page.php";
                    }else echo"../examples/admin_page.php";?>">Home</a></li>
					<li><a href="../examples/Profile.php">Profile</a></li>
				</ul>
				<div class="navbar-form navbar-left">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search" data-toggle="tooltip" data-placement="bottom" title="Tìm kiếm theo chủ đề, mã số sinh viên" id="timkiemgiatri">
					</div>
					<button type="button" class="btn btn-default" onclick="Hienthitheochude()">Submit</button>
				</div>
          <img src="..\<?php echo $name['avatar']; ?>" alt="Ảnh đại diện" style="height:33px;width: 33px;margin-left: 29%;margin-top: 0.4%;">
			    <ul class="nav navbar-nav navbar-right">
					<li><a href="Profile.php?value=1"><span></span> <i>Xin chào</i> <span class="chusang" data-toggle="tooltip" data-placement="bottom" title="<?php echo"Mssv: ".$id_user; ?>"><?php echo$name['fullname']; ?></span></a></li>
					<li><a href = "#" onclick="user_Log_out(1)"><span class="glyphicon glyphicon-log-in"></span> Log out</a></li>
				</ul>
			</div>
		</nav>

        <div class="container-fluid text-center">  
	       <div class="row content">
              <div class="col-sm-3 sidenav navbar-fixed-top" style="min-height: 790px;"><!-- Noi dung ben trai -->
		            <div class="row">
		                <div class="col-md-4">
                      <div class="container kv-main" style="width:100%;margin-left:6px;">
			                   <div class="form-group" style="width:450%;margin-top:-20px;">
			                     <div class="page-header" style = "margin-top:-5px;">
				                    <h3><b>Chọn chủ đề</b><small></h3>
                             <div id='nhushitvay'></div>
				                   </div>
                                <!-- hien thi chu de-->
                            <?php
                              $topic = array();
                              $topic = Topic();
                              echo"<select class='form-control' id='topic'>";
                              echo"<option style='font-size:130%;' selected value='00000'></option>";
                              $length_topic = Length_table($conn, "topic", "");
                              for($i = 0; $i < $length_topic; $i++){
                                foreach($topic[$i] as $key=>$value){
                                  if($key != "topic_name"){
                                    echo"<option style='font-size:130%;' value='".$value."'>";
                                  }else{
                                    echo"<b>".$value."</b></option>";
                                  }
                                }
                              }
				                      echo"</select>";
                            ?>

                            <div class ="alert alert-danger" style="margin-top:10px;display:none;" id="chua-chon-chu-de">
                             <strong> <span class="glyphicon glyphicon-warning-sign"></span> Warning!!!
                            </strong>Bạn không thể để trống trường này</div>
			                 </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group" style="margin-top:33px;min-height: 20%;">
                        <label for="comment" style="font-size: 140%;" id="noticefromadmin1"></label>
                        <div style="padding: 15px 10px 10px 0px; min-height:100px;background: white;" align="left" id="noticefromadmin">
                        </div>
                    </div>
              </div>

                 <div class="col-sm-6 text-left" style="min-height: 790px;margin-left: 25%;overflow:auto;"> 
                    <form enctype="multipart/form-data" id="form_main" method = "post" 
                     action = "..\..\Controller\users_controller.php">
			                 <div class="form-group" style="margin-top: 4%;">
					               <textarea class="form-control" rows="5" id="comment" name = 'binhluan' placeholder="Write something in here...."></textarea>
				              </div>
				              <!--   <label for="comment" style="margin-left: 7%; font-size: 130%;">Choose file:</label> -->
                         <a href="#" data-toggle="tooltip" title="Lựa chọn chủ đề và chọn file upload ở đây...">
                         <input id="file-0a" class="file" name = "tep" type="file" multiple data-min-file-count="1"> </a>
                         <input type="hidden" value="" id="chudenan" name="chude">
                        <br>
                        <button type="button" class="btn btn-primary" name ="submitform" onclick="Submit_form()">Upload File</button>
                        <button type="reset" class="btn btn-default" style="margin-left: 15px;">Reset File</button>
                     </form>
                      <p id="kt"></p>
                    <div id="phanhienthibaidang">
                <!-- dang bai su dung php-->
                   <?php
                    
                     if(isset($_SESSION["uploaded_file"]) != ""){
                         echo"<script>alert(".$_SESSION["uploaded_file"].");</script>";
                     }
                     /*
                        moi echo nay tuong ung voi mot bai dang co id xac đinh rieng(trung voi ma id trong csdl)
                        Ý tuong: các sự kiện binh luận, thích, đánh giá bài viết se dung ajax de liên kết với server, dùng js để đáp ứng sự kiện của người dùng, khi user loafa lại trang sự kiện js biến mất thay vào đó csdl thay thế.
                     */

                     $posts = array();
                     $one_post = array();
                     $comments = array();
                     $one_cmt = array();
                     //Cach 1 de hien them bai dang
                   //  if(isset($_SESSION["Show_more_posts"])) 
                   //     $posts = Show_post_to_user(0, $_SESSION["Show_more_posts"]);//hien thi thong tin 10 bai dang 
                   //  else 
                     $posts = Show_post_to_user(0, 15, "", "");
                     $num_of_post = count($posts);
                     $index = 0;
                     $id_rating = 0;
                    for($index = 0; $index < $num_of_post; $index++){
                      foreach ($posts[$index] as $key => $value) {
                        if($key == "post_id")      $one_post[0] = $value;//ma bai dang
                        else if($key=="post_time") $one_post[1] = Change_date($value);//thoi gian da dang bai
                        else if($key=="notice")    $one_post[2] = $value;//noi dung bai dang
                        else if($key=="link")      $one_post[3] = $value;//vi tri luu tep tai len
                        else if($key=="name")      $one_post[4] = $value;//ten nguoi dang
                        else if($key=="name_tp")   $one_post[5] = $value;//ten chu de
                        else if($key=="name_file") $one_post[6] = $value;//ten cua tep
                        else if($key =="uid")      $one_post[8] = $value;//ma nguoi dung de xoa bai dang
                        else                       $one_post[7] = $value;//anh dai dien cua nguoi dang bai dang
                      }

                     $tenuser = htmlspecialchars(json_encode($one_post[4]));//4 gia tri nay fix loi missing ) in argument list--loi xay ra tren js
                     $tencd = htmlspecialchars(json_encode($one_post[5]));
                     $tentep = htmlspecialchars(json_encode($one_post[6]));
                     $mabd = htmlspecialchars(json_encode($one_post[0]));
                     $mauser = htmlspecialchars(json_encode($one_post[8]));

                      echo"<div class='popup-box4' id=".$one_post[0].">
                      <div class='dropdown'>
                        <a class='dropbtn'><h5 class='glyphicon glyphicon-chevron-down'></h5></a>
                        <div class='dropdown-content'>";
                        if($one_post[8] != $id_user || You_are_ad() == true){
                         echo"<a style='cursor:pointer;' onclick='Report_problem($tenuser, $tencd, $tentep, $mabd, $mauser)'>Phản hồi bài đăng</a>";
                        }
                        if($one_post[8] == $id_user || You_are_ad() == true){ //nguoi dung chi duoc xoa bai dang cua chinh minh, tuy nhien quan tri vien co quyen xoa het bai dang da tao
                           echo"<a style='cursor:pointer;' onclick = 'del_post_by_yourself(".$one_post[0].")'>Xóa bài đăng</a>";
                        }
                     echo"</div>
                     </div>
                           <table style='margin-left: 5px;height:80px;'>
                              <tr style='margin-top:5px;'>
                                 <td>
                                    <img src='../".$one_post[7]."' style='height:47px;width:47px;'>
                                 </td>
                                 <td>
                                    <div style='margin-left:8px;padding:0px;'>
                                      <p style='color:blue;margin-top:4px;'><a href = 'Profile.php?value=0' style='font-size:110%;cursor:pointer;' class='text-justify' data-toggle='tooltip' title='".$one_post[8]."' ><b>".$one_post[4]."</b></a> đã cập nhật chủ đề <b style='color:black;font-size:160%;cursor:pointer;'>".$one_post[5]."</b></p>
                                      <div style='margin-top:-9px;'>
                                        <label style='font-size:90%;'>".$one_post[1]."</label>
                                     </div>
                                    </div>
                                 </td>
                              </tr>
                           </table>";
                          
                          $average_rate = avg_rating($one_post[0]);//diem tb danh gia tu nguoi dung
                          echo"<div style='min-height: 140px;margin-top:10px;' class='form-group'>
                             <textarea readonly class='form-control' style='min-height:20px;resize:none;outline:none;font-size:15px;color:orange;background-color:white;border:none;' >".$one_post[2]."</textarea>
                              <div style='float:right;margin-right:10px;'>
                                <h4><label style='font-size:80%;'>Điểm đánh giá</label> : <span>".$average_rate."</span>/5</h4>
                             </div>
                             <div style='margin-left: 15px;'>
                             <h5> <i>Đường dẫn file:</i></h5>
                             <a href = '../".$one_post[3]."' target='_blank' style='cursor: pointer;'><p style='font-size: 170%;margin-left: 15px;'>".$one_post[6]."</p></a>
                             </div>
                          </div>

                         <div class='divcmt'>";

                          $num_of_judge = Count_like_or_rating(1, $one_post[0]);//so luong nguoi danh gia
                          $num_of_like = Count_like_or_rating(0, $one_post[0]);//so luong nguoi thich
                          if(Show_status_like($one_post[0], $id_user)){
                            echo"<img src='../../Datasystem/dalike.jpg' onclick = 'changeImage(this, ".$one_post[0].", ".$id_user.", ".$num_of_like.")' style='margin-left:5px;width:36;height:29px;'>
                           <p style='margin-top:-20px;margin-left: 50px;color:blue;'>Đã thích</p>";
                          }else{
                           echo"<img src='../../Datasystem/Like-512.png' onclick = 'changeImage(this, ".$one_post[0].", ".$id_user.", ".$num_of_like.")' style='margin-left:5px;width:36;height:29px;'>
                           <p style= 'margin-top:-20px;margin-left:50px;'>Thích</p>";
                          }
                     
                          echo"<div style='margin-top:-20px;margin-left:26%;'>
                              <a style='cursor:pointer;' data-toggle='modal' data-target='#myModal' onclick='Infor_like_rating(".$one_post[0].",".$num_of_like.",".$num_of_judge.")'><span>".$num_of_like."</span> người thích, <span>".$num_of_judge."</span> người đánh giá</a>
                           </div>";

                           $value_of_judge = Value_of_rating_by_user($one_post[0]);//gia tri danh gia bai dang
                           echo"<div style='margin-left:60%;margin-top:-29px;cursor:pointer;'>
                               <input value='".$value_of_judge."' type='number' class='rating' min=0 max=5 step=1 data-size='xs' data-stars='5' onchange = 'Rating(this, ".$one_post[0].", ".$id_user.", ". $num_of_judge.", ".$average_rate.", ".$value_of_judge.")'>
                           </div></div>";

                          echo"<div class='divcmt1'>
                            <div style='border:1px solid #d5e8e8;height:auto;'>
                                <div style='margin-top:12px;'>";
                                  $all_cmt = Count_comment($one_post[0]);//tat ca binh luan 
                                  $tam = 0;
                                 if( $all_cmt > 8){
                                   $tam = $all_cmt - 8;
                                   echo"<a class='a4' onclick = 'See_more_Comment(".$one_post[0].", 0);'>Xem thêm bình luận(<span id='changecmt'>".$tam."</span>)</a>";
                                 }else{
                                   echo"<a class='a4' onclick = 'See_more_Comment(".$one_post[0].", 0);'>Xem thêm bình luận(<span id='changecmt'>0</span>)</a>";
                                 }
                                 echo"<input type='hidden' id='changecmt' value = ".$tam.">";//tong so binh luan
                                 echo"<input type='hidden' id='changecmt' value = 0>";//so lan click

                            echo"</div>
                                <div style='height:auto;' id=0></div>
                            </div>
                            <form style='margin-top:18px;margin-left:10px;'>
                              <table><tr><td><img src='../".$name['avatar']."' style='height:40px;width:42px;margin-top:5px;margin-left:-1px;'></td><td><div>
                              <textarea style='resize:none;' rows='1' id='' placeholder='Viết bình luận' class='divcmt2' onkeypress = 'return UserComment(event, this,".$one_post[0].",0)'></textarea></div></td></tr></table></form><div style='height:30px; margin-top:0px;'></div>
                            </div>
                      </div>";

                      $comments = Show_comment_to_user($one_post[0], 8, 0);//cac comment cua nguoi dung khac nhau ung voi ma bai dang($one_post[0]), so luong binh luan hien thi ban dau(0, 8)
                      $num_of_cmt = count($comments);//dem so luong binh luan trong 1 bai dang
                      if($num_of_cmt > 0)
                      {
                        $i = 0;
                        for($i = 0; $i < $num_of_cmt; $i++){
                          foreach ($comments[$i] as $key => $value) {
                             if($key == "avt")          $one_cmt[0] = $value;//anh dai dien nguoi dang binh luan
                             else if($key == "name")    $one_cmt[1] = $value;//ten cua nguoi dang binh luan
                             else if($key == "time")    $one_cmt[2] = $value;//thoi gian da dang binh luan
                             else if($key == "content") $one_cmt[3] = $value; //noi dung da binh luan
                             else                       $one_cmt[4] = $value; //ma binh luan
                          }
                          echo"<script>
                            Show_comment_from_db(".$one_post[0].", '".json_encode($one_cmt[0])."', '".$one_cmt[1]."', '".$one_cmt[2]."', '".json_encode($one_cmt[3])."',".$one_cmt[4].", 0, 1);
                          </script>";//gia tri 2,1  Show_comment_from_db() trong ham 2 la ten id= 2 cua the div se hien comments gia tri 1 de hien thi binh luan khi load file(dung php), con 0 la dung ajax xu li ben client
                        }
                      }
                   }
                 ?>
                </div>

                <div id="tk">cc</div><!--Hien thi them bai dang -->

                <div style="margin-top: 10px;">
                 <?php 
                 // if(isset($_SESSION['num_of_posts'])) $val123 = $_SESSION['num_of_posts']);cach so 1
                  echo"<button type='button' class='btn btn-link' ";
                  echo"onclick='See_more_posts(".$id_user.", 0)'> Xem thêm bài đăng(0)</button>";
                  ?>
                </div>
             </div>

            <div class="col-sm-3 sidenav navbar-fixed-top" style="margin-left: 75%;">
              <div>
                <?php

                //ham se truy van co so du lieu tra ve nhung nguoi dung dang online
                //Chi chay 1 lan duy nhat khi nguoi dung load page hay chay lai trang web, sau do dung ham
                //   window.setInterval("Request_online()", 60000);  trong javascript tu dong 60s truy van co so du lien de tra ve nhung nguoi dang online, 
                //note: Phan ben duoi nay co the bo di thay bang ham  window.setTimeOut("Request_online()", 1000); chay 1 lan duy nhat de truy van csdl hien thi so nguoi online

                  $users = Array();
                  $users = List_on_of_line();
                  $num_of_user = count($users);
                  $random = -100000;
                  $tendaydu="";
                   echo"<div class='well well-sm'>";
                     echo"<h3 id= 'songuoionline'>Online($num_of_user)</h3>";
                   echo"</div>";
                   echo"<div style='height: 450px;'>";
                     echo"<div id='danhsachhien' style='display:none;'></div>";
                     echo"<div id = 'danhsachan'>"; 
                        for($index = 0; $index < $num_of_user; $index++){
                           echo"<table style='margin-left:40px;'><tr style='height:45px;'>";
                           foreach ($users[$index] as $key => $value) {
                              if($key=="avatar")        $anhdaidien = $value;
                              else if($key=="fullname") $tendaydu = $value;
                              else $masosv =            $value;
                           }
                           $random = strtotime(date('Y-m-d', time())).rand(0, 200000);
                           echo"<td><img src='../".$anhdaidien."' style='height:48px;width:48px;'></td>";
                           echo"<td style='margin-left:15px;'><a href= '#' class='a8' onclick = 'chatbox_popup($random, $id_user, $masosv),Countingclick()'><i>$tendaydu</i></a></td>";
                          
                           echo"</tr></table><br>";
                           echo "<input type='hidden' value='$tendaydu' id = '$random'>";//lay ten ng dung
                        }
                    echo"</div></div>";
                 ?>

              </div>
              <div class="well well-sm" style="margin-top: -4%;">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search something...">
                    <div class="input-group-btn">
                      <button class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-search"></i>
                      </button>
                    </div>
                  </div>
              </div>
            </div>
           
          </div>
        </div>
      <!--  <footer class="container-fluid text-center">
            <p>Footer Text</p>
        </footer> -->
    </body>
	
	<script>

   //ham nay cho phep tu dong tang chieu dai cua textarea khi nguoi dung comment vuot qua chieu dai co dinh
   function Height(e) {
      $(e).css({'height':'auto','overflow-y':'hidden'}).height(e.scrollHeight);
   }
      
   $('textarea').each(function () {
      Height(this);
   }).on('input', function () {
      Height(this);
   });
   
   //dung tooltip
   $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();   
   });
   
	</script>
</html>