<?php
    session_start();
?>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<style>
			table {
				border-collapse: collapse;
				width: 96%;
				margin-left:2%;
			}

			tr:hover{background-color:#f5f5f5}

			th, td {
				padding: 8px;
				border: 1px solid #ddd;
				text-align: center;
			}

			th {
				background-color:#B376C6;
				color: white;
			}
			
			.cotxoa{
				height:20px;
				width:25px;
				background:red;
			}
			
			.cotsua{
				height:21px;
				width:26px;
				background:blue;
			}
		</style>
	</head>
	
	<body>
		<div class="jumbotron" style='text-align:center;'>
			<h2>QUẢN LÍ TÀI KHOẢN NGƯỜI DÙNG</h2>      
			<p>Sửa, xóa tìm kiếm và gửi mail tới người dùng</p>
		</div>  
		<p id="kt"></p>
		<div  style="margin-left:4%;">		
			<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Đưa ra lựa chọn ở đây
					<span class="caret"></span></button>
				<ul class="dropdown-menu">
					<li class="dropdown-header">Chung</li>
					<li><a href="#" onclick = "Sua()">Sửa tài khoản người dùng</a></li>
					<li><a href="#" onclick = "Xoa()">Xóa người dùng</a></li>
					<li class="divider"></li>
					<li class="dropdown-header">Nâng cao</li>
					<li><a href="#" onclick = "Timkiem()">Tìm kiếm</a></li>
				</ul>
			</div>
		</div>
		
		<div class="container">	
			<div style="display:none;margin-top:10px; margin-left:15%;" id="search">
				<div class="form-inline">
					<form action = "" method = "post" id="submitform">
						<input type="text" class="form-control" name = "valuesearch" id="find" style="width:60%;" placeholder="Tìm kiếm ...">
						<button type="button" class="btn btn-info" onclick="Timkiem1()">
							<span class="glyphicon glyphicon-search"></span> Search
						</button>
					</form>
				</div>
				<p class="bg-warning" id="error0" style="display: none;">(**)Không để trống trường này.</p>
			</div>
			<div style="display:none;margin-top:10px;" id = "fix">
				 <div class="form-group">
					<label for="name">Tên tài khoản:</label>
					<input type="text" class="form-control" id="account" placeholder = "Tên hợp lệ...">
					<p class="bg-warning" id="error" style="display: none;">Không để trống hoặc viết kí tự lạ ở đây</p>
				</div>
				<div class="form-group">
					<label for="email">Địa chỉ vnu-mail:</label>
					<input type="text" class="form-control" id="vnumail" placeholder = "Eg:14020822@vnu.edu.vn">
					 <p class="bg-warning" id="error1" style="display: none;">Không để trống trường này hoặc sai định dạng.</p>
				</div>
				<label for="role">Vai trò của người dùng:</label>
				<div class="form-inline">
					<input type="number" class="form-control" id="role" placeholder = "1 là admin, 0 là người dùng..."
						 style = "width:70%;" min="0" max="1" readonly>
					<button type="button" class="btn btn-danger" id="fixtrue" disabled >Chắc chắn muốn sửa?</button>
				</div>
				<p class="bg-warning" id="error2" style="display: none;">Sai giá trị</p>
				<div class="form-group" style="margin-top:5%;">
					<button type="button" class="btn btn-success" style="margin-left:40%;width:20%;" onclick="Fixtrue()">Sửa</button>
					<p class="bg-warning" id="error3" style = "margin-top: 5%; font-size: 120%;display: none;" >(**)Vui lòng tích vào ô sửa bên dưới.</p>
				</div>
			</div>
			<div style="margin-top:5px;display:none;margin-left:10%;" id = "del">
				<div class="form-inline">
					<textarea class="form-control" id="iduser" style="min-width:50%;" readonly></textarea>
					<button type="submit" class="btn btn-danger" style="width:15%;" onclick="Deltrue()" id="deltrue">
						<span class="glyphicon glyphicon-floppy-remove"></span> Xóa
					</button>
				</div>
				 <p class="bg-warning" id="error5" style="display: none;">(**)Vui lòng tích vào ô xóa bên dưới.</p>
			</div>
		</div>
		
		<div class="container">
			<!-- Modal -->
			<div class="modal fade" id="myModal" role="dialog">
				<div class="modal-dialog">
				
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header" style="background-color:#697070;">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title" style="color:white;">Gửi tin nhắn</h4>
						</div>
						<div class="modal-header" style="height:10%;" >
							<div class = "form-group" style="margin-top:-1%;">
								<input type="text" class="form-control" style="height:150%;" id="to" placeholder="To">
							</div>
						</div>
						<div class="modal-header" style="height:10%;">
							<div class = "form-group" style="margin-top:-1%;">
								<input type="text" class="form-control" style="height:150%;" id="subviet" placeholder="Subject" autofocus>
							</div>
						</div>
						<div class="modal-body" style="height:50%;">
							<textarea class="form-control" rows="12" id="content" style="resize:none;" placeholder = "Content here...">
							</textarea>
						</div>
						<div class="modal-footer">
							<button type="button" onclick = "gui();" class="btn btn-primary" style="width:20%;">Gửi</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php
		   require_once'..\Model\model.php';
		   $conn = "";
		   Connect($conn);
		   $users = array();

		   if(isset($_POST['valuesearch'])){
				$valu = $_POST['valuesearch'];
				if($valu != "") 	$users = Search($conn, $valu);
		   }else  $users = Show_user($conn, Length_table($conn, "users", ""));
		   $mail = "";
		   $index = 10000;
		   $nguoibaocaobaidang = "";
		   if(isset($_SESSION['aibaocaobaidang'])){
		   	  $nguoibaocaobaidang = $_SESSION['aibaocaobaidang'];
		   	  unset($_SESSION['aibaocaobaidang']);
		   }
		 //  echo realpath(dirname(__FILE__));
		   echo"<div style='margin-top: 28px;'><table><tr><th>STT</th><th>Sửa</th><th>Xóa</th><th>Mã số sv</th>".
		   "<th>Tên tài khoản</th><th>Vnumail</th><th>Ảnh đại diện</th><th>Trạng thái</th><th>Gửi mail</th></tr>";
		   $pos = -1;
		   $pos1 = -1;
		   for($i = 0; $i < count($users); $i++){
		   	  if($pos1 == -1){
		   	   	foreach ($users[$i] as $key=>$value) {
		   	   	   if($key == "user_id") {
                       if($nguoibaocaobaidang == $value){
                       	  $pos = $i;
                       	  $pos1 = 2;
                       	  break;
                       }
		   	   	   	}
		   	   	}
		   	  }
			   if($pos != -1)  echo"<tr style='background-color:yellow;'>";
			   else            echo "<tr>";
			   echo"<td>".($i + 1)."</td>";
			   echo"<td><input class='cotsua' type='radio' name = 'A' id = $i onclick = 'SUA($index)' disabled></td>";
			   echo"<td><input  class='cotxoa' type='checkbox' id = ".($i + 1000)." onclick = 'XOA($index,".($i + 1000).")' disabled></td>";
			   foreach($users[$i] as $key=>$value){
				   if($key == "vnumail") $mail = $value;
				   if($key == "avatar") echo"<td><img src='$value' class='img-circle' alt='Lỗi' width='50' height='50'></td>";
				   else echo"<td>$value</td>";
				   echo "<input type = 'hidden' value = '$value' id = $index>";
				   $index++;
			   }
			   echo"<td><button type='button' class='btn btn-info' data-toggle='modal' data-target='#myModal' ".
			    "onclick = 'Send(".json_encode($mail).")'><span class='glyphicon glyphicon-send'></span> Send</button></td>";
			   echo"</tr>";
			   $pos = -1;
		   }
		   echo"</table></div>";
		?>
		
		<script type="text/javascript">
			var Length = 0, pos = 0;
			var deleteUser = new Array();
			var iduser="";

		    document.getElementById("fixtrue").addEventListener("click", function(){//ham nay bat su kien admin khi ad
				document.getElementById("role").readOnly = false;
				document.getElementById("role").focus();
			});

		    //ham thuc hien tim kiem gia tri do ad nhap vao
			function Timkiem1()
			{
				if(document.getElementById("find").value == ""){
					document.getElementById("error0").style.display="block";
				}else{
					document.getElementById("submitform").submit();
				}
			}
			
			function Send(val){//ham nay tien hanh bat hop box gui email toi nguoi dung
				//document.getElementById("kt").innerHTML = "Pham Van Linh Dep Trai";
				document.getElementById("subviet").focus();
				document.getElementById("to").value = val.toString();	
				document.getElementById("content").value = "";
			}
			
			function enable(val)//ham nay bat cac gia tri trong o chon xoa va chon sua cua bang
			{
				var i = 0;
				var input = document.getElementsByClassName(val);
				if(input[0].disabled == true){
					Length = input.length;
					for(i = 0; i < Length; i++){
						input[i].disabled = false;
					}
				}
			}
			
			function disable(val)//ham nay tat cac gia tri trong o chon xoa va chon sua cua bang
			{
				var i = 0;
				var input = document.getElementsByClassName(val);
				if(input[0].disabled == false){
					for(i = 0; i < Length; i++){
						input[i].disabled = true;
					}
				}
			}


			function Uncheckbox(val)
			{
				var i = 0;
				var input = document.getElementsByClassName(val);
				for(i = 0; i < input.length; i++){
					if(input[i].checked == true) 
						input[i].checked = false;
				}
			}

			
			function Sua()//ham nay thuc hien khi nguoi dung kick vao o sua trong thanh bang chon
			{
				document.getElementById("fix").style.display = "block";
				document.getElementById("search").style.display = "none";
				document.getElementById("del").style.display = "none";
				document.getElementById("account").disabled = true;
				document.getElementById("vnumail").disabled = true;
				document.getElementById("role").readOnly = true;
				document.getElementById("iduser").value = "";
				disable("cotxoa");
				enable("cotsua");
				Uncheckbox("cotsua");
			}
			
			function XOA(index, val)//ham nay thuc hien khi nguoi dung kick vao o checkbox trong bang nguoi dung
			{
				deleteUser[pos] = document.getElementById(index).value.toString();
				document.getElementById("error5").style.display = "none";
				document.getElementById("iduser").value = "";
				if(document.getElementById(val).checked == false){
				  	iduser = iduser.replace(deleteUser[pos], "");
				  	pos--;
				}else{
				 	iduser = iduser.concat(deleteUser[pos], "  ");
				 	pos++;
				 }
				document.getElementById("iduser").value += iduser;
			}

			function Xoa()//ham nay thuc hien khi nguoi dung kick vao o xoa trong thanh bang chon
			{
				document.getElementById("search").style.display = "none";
				document.getElementById("fix").style.display = "none";
				document.getElementById("del").style.display = "block";
				iduser = "";
				enable("cotxoa");
				disable("cotsua");
				Uncheckbox("cotxoa");
			}
			
			function Timkiem()//ham nay tien hanh hien ra box tim kiem khi ad kick vao thanh bang chon
			{
				document.getElementById("search").style.display = "block";
				document.getElementById("fix").style.display = "none";
				document.getElementById("del").style.display = "none";
				document.getElementById("find").focus();
				iduser = "";
				disable("cotsua");
				disable("cotxoa");
			}
			
			function gui()//ham nay thuc hien gui mail cho nguoi dung co dia chi email xac dinh
			{
				var to, subject, content, mailtoiduser="", i = 0;
				to = document.getElementById("to").value.toString();
				subject = document.getElementById("subviet").value;
				content = document.getElementById("content").value;
				for(i = 0; i < 8; i++){
					mailtoiduser += to[i];
				}
				//document.getElementById("kt").innerHTML = mailtoiduser;
				if(to == ""){
					alert("Không thể để trống trường này.");
					document.getElementById("to").focus();
				}else{
					if(subject == ""){
						var True = confirm("Bạn chắc muốn để trống trường subject ???");
						if(True != true){
						    document.getElementById("subviet").focus();
						}
					}
					
					$.ajax({
						type: "POST",
						url: "../Controller/admin_controller.php",
						data: { to: to, subject: subject, content:content, mailtoiduser: parseInt(mailtoiduser)},
							success: function (data){
						 	    alert(data);
						  	    location.reload();
							}
					});
				}
			}
			
			function Deltrue()//ham nay tien hanh truy van database xoa nguoi dung
			{
				if(document.getElementById("iduser").value == "")
					document.getElementById("error5").style.display = "block";
				if(pos == 0){

				}else{
					var r = confirm("Bạn chắc chắn muốn xoá những người dùng này?? Vui lòng cân nhắc kĩ?");
					if(r == true){
						$.ajax({
							type : "POST",
							url : "../Controller/admin_controller.php",
							data: {deleteUser: JSON.stringify(deleteUser)},
							success: function (data){
								alert(data);
						  		location.reload();
							}		 			
						});
				    }
				}

			}
			
			var id = "";//lay id cua nguoi dung muon thay doi 
			function SUA(val)// ham nay tien hanh lay gia tri vao o text khi admin kick vao nut sua ben trong bang
			{
				var user, vnumail, role = 0;
				user = document.getElementById((val + 1)).value;
				vnumail = document.getElementById((val + 2)).value;
				id = document.getElementById(val).value;
				if(document.getElementById((val + 4)).value == "Admin")  role = 1;
				if(document.getElementById("account").disabled == true){
					document.getElementById("account").disabled = false;
					document.getElementById("account").focus();
					document.getElementById("vnumail").disabled = false;
					document.getElementById("error3").style.display = "none";
				}
				document.getElementById("error").style.display = "none";
				document.getElementById("error1").style.display = "none";
				document.getElementById("fixtrue").disabled = false;
				document.getElementById("account").value = user;
				document.getElementById("vnumail").value = vnumail;
				document.getElementById("role").value = role;
				//window.location.href = "http://localhost/BaiTapLonPtUdW/view/admin_page.php#id=account";
			}

			function validateVNU(vnumail)//dinh dang vnumail
			{
				 var re =  /\d{8}@vnu.edu.vn/;
    			return re.test(vnumail);
			}

			function validateName(name)//ten khong chua ki tu la
			{
				var re =  /[a-z0-9A-Z]/;
    			return re.test(name);
			}
			
			function Fixtrue()//khi admin da sua xong cac gia tri, tien hanh truy van database
			{
				//document.getElementById("kt").innerHTML = "Pham Van Linh Dep Trai";
				if(document.getElementById("account").disabled == true){
					document.getElementById("error3").style.display = "block";
				}
				var name, vnumail, role = 0;
				name = document.getElementById("account").value;
				vnumail = document.getElementById("vnumail").value;
       
				if(name == "" || !validateName(name)){
					document.getElementById("error").style.display = "block";
					document.getElementById("account").focus();
				}else if(!validateVNU(vnumail) || vnumail[8] !="@"){
					document.getElementById("error1").style.display = "block";
					document.getElementById("vnumail").focus();
				}else{
					if(document.getElementById("role").readOnly == false){
						var r = confirm("Bạn chắc chắn muốn thay đổi vai trò của " +name+ " ?");
						if(r == true){
							role = document.getElementById("role").value;
						}	
					}
				}
				$.ajax({
					type: "POST",
					url: "../Controller/admin_controller.php",
					data: {name_fixed:name, vnumail_fixed: vnumail, role_fixed:role, id_fixed:id},
					success: function (data){
						alert(data);
						location.reload();
					}
				});
			}
			
		</script>
	</body>
</html>