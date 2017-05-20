<?php
 	include_once '../Controller/admin_controller.php';
   if(isset($_SESSION['xoathanhcongbaidang'])){
      echo"<script>alert('".$_SESSION['xoathanhcongbaidang']."');</script>";
      unset($_SESSION['xoathanhcongbaidang']);
   }
?>	

<!DOCTYPE html>
<html lang="en">
	  <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript">
		    //ham nay tim kiem thong tin bai dang dang quan li
            var error = "";//ham nay tra ve vi tri da click trong danh sach quan li bai dang
            //error la ma loi 
		    function Timkiem(id)
		    {
		    	var valu = document.getElementById(id).value;
		    	
		    	if(valu == ""){
		    		document.getElementById("canhbao").style.display = "block";
		    	}else{
		    		Quanlibaidang(valu);
		    	}
		    }

		    //ham phu tro cho ham tim kiem
		    function An()
		    {
		    	document.getElementById("canhbao").style.display = "none";
		    }

            //ham dua ra thoi gian hien tai
		    function Time_now()
		    {
		    	var dt, time;
		    	document.getElementById("thoigianhientai").innerHTML = "";
		    	dt = new Date();
		    	time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds() + ", " + dt.getDate()+ "/" + (dt.getMonth() + 1) + "/" + dt.getFullYear();//thoi gian dang bai, xu li ben client, hien ra dang gio:phut: giay ngay/thang/nam
		    	document.getElementById("thoigianhientai").innerHTML = "Thời gian hiện tại: " + time;
		    }

          //ham ho tro chuyen doi cac thu trong tuan trong js
          function Weekdays(num)
          {
             switch(num){
               case 1:
                 return "Monday";
                 break;
               case 2:
                  return "Tuesday";
                  break;
               case 3:
                  return "Wednesday";
                  break;
               case 4:
                  return "Thursday";
                  break;
               case 5:
                  return "Friday";
                  break;
               case 6:
                  return "Saturday";
                  break;
               default:
                  return "Sunday";
                  break;
             }
          }
           //Ham thay doi post_time(kieu datetime trong sql) su dung javascript
           function Change_date_in_server(date_in_server)
           {
               var dc, d = new Date(date_in_server.replace(/-/g, "/"));//bien date_in_server la dang date kieu datetime trong sql, vi vay can bien doi thoi gian ve dang de doc hown cho nguoi dung
               dc = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds() + ", " + Weekdays(d.getDay()) +" "+ d.getDate()+ "/" + (d.getMonth() + 1) + "/" + d.getFullYear();
               return dc;
           }

		    //ham hien bai dang
			function Quanlibaidang(val)
			{
				var i, object, res, Length, Id_POST, element = "";
              
				$.ajax({
					type: "POST",
					url: "../Controller/admin_controller.php",
					data:{laybaidang: 1, timkiem: String(val)},
					success:function(data)
					{
						Id_POST = String(window.location.href);//http://localhost/BaiTapLonPtUdW/View/manage_post.php
						res = Id_POST.substring(59, Id_POST.length);//http://localhost/BaiTapLonPtUdW/View/manage_post.php?,mabd=17-> de lay duoc vi tri thi can cat xau o vi tri 59, se cat duoc so 17
						object = JSON.parse(data);
						Length = Object.keys(object).length;
						element = '<table class="table table-bordered"><thead><tr><th>STT</th><th>Người đăng</th>';
       					element += '<th>Thời gian</th><th>Tên file</th><th>Chủ đề</th><th>Xóa</th></tr></thead><tbody>';
      					for(i = 0; i < Length; i++)
      					{
      					 element += '<input type = "hidden" name="angiatri" value = "'+object[i].postid+'">';
      					 element += '<input type = "hidden" name="angiatri" value = "'+object[i].link+'">';
                      element += '<input type = "hidden" name="angiatri" value = "'+object[i].uid+'">';
                      element += '<input type = "hidden" name="angiatri" value = "'+object[i].post_time+'">';
      					 if(parseInt(Id_POST.length) > parseInt(52) && parseInt(res) == parseInt(object[i].postid))
      					 {
      					 	element += '<tr style="background-color: #F2F5A9;">'; 
      					 }else{
      					 	element += '<tr>'; 
      					 }

      					 element += '<td>'+(i + 1)+'</td>' + '<td style="cursor:pointer;"><p data-toggle="tooltip" title="'+object[i].uid+'">'+object[i].name+'</p></td>' + '<td>'+Change_date_in_server(object[i].post_time)+'</td>';
                         //data-toggle="modal" data-target="#myModal" dat vao input type radio
      					 element += '<td>'+object[i].namefile+'</td>' + '<td>'+object[i].topic_name+'</td><td><div class="radio"><label><input type="radio" name="optradio"  onclick="Xoa()"></label></div></td></tr>';
      					}

						element += '</tbody></table>';
						if(String(val) == "default11111"){//hien thi bai dang
							document.getElementsByClassName("Timkiembaidangoday")[0].innerHTML = "";
							document.getElementsByClassName("Hienthibaidangoday")[0].innerHTML = element;
					    }else{
					    	document.getElementsByClassName("Hienthibaidangoday")[0].innerHTML = "";
					    	if(Length == 0) document.getElementById("canhbao1").style.display = "block";
					    	else            document.getElementsByClassName("Timkiembaidangoday")[0].innerHTML = element;
					    }
					}
				});

			}

			setTimeout(Quanlibaidang('default11111'), 100);
			window.setInterval("Time_now()", 1000);
            
			//ham ho tro xoa bai dang
            function Note(val, uid, time, topic, pid)
            {
             	var text = "";
            	switch(val) {
    				case "check0":
        				text = "Chúng tôi xóa bài đăng của "+uid+" vì Nội dung không phù hợp. Đăng ngày "+time+"; chủ đề "+topic + "; mã bài đăng " + pid;
                        error = "110AB1";
        				break;
    				case "check1":
        				text = "Chú thích hoặc bình luận của "+uid+" vì dâm ô, phản động. Đăng ngày "+time+"; chủ đề "+topic+ "; mã bài đăng " + pid;
                        error = "110AB";
        				break;
    				case "check2":
        				text = "Bài đăng của "+uid+" vì cố tình Phá hoại trang web. Đăng ngày "+time+"; chủ đề "+topic+ "; mã bài đăng " + pid;
                         error = "110AB2";
        				break;
        			case "check3":
        				text = "Chủ đề bài đăng của "+uid+" không hợp với nội dung bài đăng. Đăng ngày "+time+"; chủ đề "+topic+ "; mã bài đăng " + pid;
                        error = "110AB3";
        				break;
    				default:
        				text = "Mã người đăng: "+uid+"; thời gian đăng: "+time+"; Chủ đề: "+topic+ "; Mã bài đăng: " + pid;
                        error = "110AB4";
				}

				return text;
            }

            //ham kiem tra admin kick vao nut xoa chua
            function Test_check_del()
            {
               var table1, index, pos = -1;
               table1 = document.querySelectorAll('input[type="radio"][name="optradio"]');//vi tri click nut xoa
               for(index = 0; index < table1.length; index++){
                    if(table1[index].checked == true){
                        pos = index;
                        break;
                    }
                }

               return pos;
            }

            //ham kiem tra admin kick vao nut xoa chua
            function Test_check_del1()
            {
               var index, pos = 0;
               for(index = 0; index <= 4; index++){
                    if(document.getElementById("check" + index).checked == true){
                        pos = 1;
                        break;
                    }
               }
               if(pos == 1){
                  return true;
               }
               return false;
            }

            //ham lua chon gia tri khi muon xoa bai dang
            function Selectonly(id)
            {
               // document.getElementById("kt").innerHTML = table[3].cells[2].innerHTML;
                var i, table1, index, pos, table, table2, pos1, pos2, pos3, possition; 
                table = document.querySelector("table").rows;
                table2 = document.querySelectorAll('input[type="hidden"][name="angiatri"]');//lay gia tri cua cac input type hidden co ten la angiatri

                pos = Test_check_del();//lay vi tri click hien tai
                var time, uid, topic, pid;//thoi gian, ma nguoi dung, chu de, ma bai dang

                pos1 = pos*4 + 2;//input type hidden
                pos2 = pos*4;

                uid = table2[pos1].value;
                pid = table2[pos2].value;
                time = table[(pos + 1)].cells[2].innerHTML;//lay gia tri o cot thu 2 trong bang
                topic = table[(pos + 1)].cells[4].innerHTML;//lay gia tri o cot thu 4 trong bang
                
            	for (i = 0; i <= 4; i++){
        			  document.getElementById("check" + i).checked = false;
    			   }
   				   document.getElementById(id).checked = true;
   				   document.getElementById("lydoxoa").focus();
   				   document.getElementById("lydoxoa").value = Note(id, uid, time, topic, pid);
   				   document.getElementById("luuy").innerHTML = "";
            }

            //ham hien thi modal xoa bai dang khi click
            function Xoa()
            {
               document.getElementById("luuy").innerHTML = "";
                $('#myModal').modal();//goi modal
            }

            //ham nay xay ra khi click vào nút xóa bài đăng trong modal
            function Xoabaidang()
            {
                var time, uid, topic, pid, link, table, table2, pos1, pos2, pos3, possition;
                table = document.querySelector("table").rows;
                table2 = document.querySelectorAll('input[type="hidden"][name="angiatri"]');
                possition = Test_check_del();
         
                if(Test_check_del1()){
                  pos1 = possition*4 + 2;
                  pos2 = possition*4 + 1;
                  pos3 = possition*4;

                  uid = table2[pos1].value;//ma so sinh vien cua nguoi dang bai
                  pid = table2[pos3].value;//ma bai dang
                  time = table2[(pos3 + 3)].value;//thoi gian dang
                  topic = table[(possition+1)].cells[4].innerHTML;//chu de nguoi dung
                  link = table2[pos2].value;
                  Xoabaidang1(uid, pid, link, time, topic);
               }else{
                  document.getElementById("luuy").innerHTML = "(???)Vui lòng chọn 1 lí do muốn xóa bài đăng.";
               }
            }
           
         
            //xoa bai dang, bao cao su co tu admin(voi li do khong chinh dang cua nguoi dung)
            function Xoabaidang1(uid, pid, link, time, topic)
            {
            	$.ajax({
            		type: "POST",
						url: "../Controller/admin_controller.php",
						data:{nguoidang: uid, mabaidang: pid, duongdan: link, thoigian: time, chude: topic, maloi: error},
						success:function(data)
						{
							$("#kt").html(data);
						}
            	});
            }

            //ham xem tiep cac bai dang
            function Xemtiep()
            {

            }

            //ham hien thi lai cac bai da dang
            function Xemtruocdo()
            {
                
            }
            
            //ham nay khoi phuc lai trang thai cua modal
            function CLose_modal()
            {
                var i;
                for(i = 0; i <= 4; i++){
                   document.getElementById("check" + i).checked = false;
                }
                document.getElementById("lydoxoa").value = "";
            }

		</script>
		<style>
		</style>
	  </head>
	<body>
		 <div class="modal fade" id="myModal" role="dialog">
    		<div class="modal-dialog modal-lg">
      			<div class="modal-content">
        			<div class="modal-header">
         			 	<button type="button" class="close" data-dismiss="modal" onclick="CLose_modal()">&times;</button>
          				<h4 class="modal-title">Lí do muốn xóa bài đăng</h4>
        			</div>
        		<div class="modal-body"  style="height:300px;">
        		 <div>
         			<div class="checkbox">
      					<label><input type="checkbox" value="11A" id = "check0" onclick="Selectonly(this.id)">Nội dung bài đăng(file) không phù hợp với văn hóa, phong tục(mã xóa 1L0A)</label>
    				</div>
    				<div class="checkbox">
      					<label><input type="checkbox" value="22B" id = "check1" onclick="Selectonly(this.id)">Bài đăng chứa phần chú thích hoặc các bình luận dâm ô, phản động, đả kích xã hội</label>
    				</div>
    				<div class="checkbox">
      					<label><input type="checkbox" value="33C" id = "check2" onclick="Selectonly(this.id)">Phá hoại trang web</label>
    				</div>
    				<div class="checkbox">
      					<label><input type="checkbox" value="44D" id = "check3" onclick="Selectonly(this.id)">Chủ đề không phù hợp với bài đăng</label>
    				</div>
    				<div class="checkbox">
      					<label><input type="checkbox" value="44D" id = "check4" onclick="Selectonly(this.id)">Lí do khác</label>
    				</div>
    				<div class="form-group">
      					<label for="comment">Chi tiết:</label>
      					<textarea class="form-control" rows="4" id="lydoxoa" style="resize: none;font-weight:bold;"></textarea>
      					<p id="luuy" style="color:red;font-size: 105%;"></p>
    				</div>
         		 </div>
        		</div>
        		<div class="modal-footer">
        		   <button type="button" class="btn btn-primary" style="float: left;" onclick="Xoabaidang()">Xóa???</button>
          		   <button type="button" class="btn btn-default" data-dismiss="modal" onclick="CLose_modal()">Close</button>
        		</div>
      			</div>
    		</div>
         </div>
		<div class="container">
			<h3 class="text-center">QUẢN LÝ BÀI ĐĂNG</h3>
			<h4 id="thoigianhientai" style="margin-left: 50%;margin-top: 2%;"></h4>
			<div class="form-inline">
			  <input type="text" id = "giatri" class="form-control" placeholder="Tìm kiếm ở đây..." onclick="An()">
			  <button type="button" class="btn btn-warning" onclick = "Timkiem('giatri')" data-toggle="tooltip" title="Tìm kiếm theo tên, mã số, chủ đề">
    			<span class="glyphicon glyphicon-search"></span> Search
  			  </button>
  			</div>
  			<div class="alert alert-warning" style="display: none;" id="canhbao">
  				<strong>Warning!</strong> Bạn không thể để trống trường này.
			</div>
			<div class="alert alert-info" style="display: none;" id="canhbao1">
  				<strong>Info!</strong> Không tìm thấy giá trị nào.
			</div>
			<p id="kt"></p>
			<div class = "Hienthibaidangoday" style="margin-top: 5%;"></div>
			<div class = "Timkiembaidangoday" style="margin-top: 5%;"></div>

			<?php
				$num_of_post = Length_table_any("posts", "");
				echo"<p class='text-center'> <b>Tổng số bài đăng:</b> ".$num_of_post."</p>";
			?>

			<ul class="pager">
   				 <li class="previous" onclick="Xemtruocdo()"><a href="#">Previous</a></li>
   				 <li class="next" onclick="Xemtiep()"><a href="#">Next</a></li>
  			</ul>
		</div>
        <script>
          $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip(); 
          });
        </script>
	</body>
</html>

