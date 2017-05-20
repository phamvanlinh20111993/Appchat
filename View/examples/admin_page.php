<?php
    include_once '..\..\Controller\users_controller.php';

	if(!isset($_SESSION['id'])&& !isset($_SESSION['pass'])){
		 header('Location:../login_register.php');
	}
    $name = information_user();

?>

<!DOCTYPE html>
<html lang="en">
    
    <head>
        <title>Admin Page</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<!--<script src="../bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="../bootstrap-3.3.7/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="../bootstrap-3.3.7/dist/css/bootstrap-theme.css">-->
		<!--<script src = "../jquery-3.1.1.min.js"></script>-->
		<script src = "function_content_sharing.js"></script>
		
    </head>
    
    <style>
	</style>

<!-- onbeforeunload="XXX();"-->
    <body>
	<!-- Nav bar in boostrap -->
	    <nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">BloG SharE FiLe</a>
				</div>
				<ul class="nav navbar-nav">
					<li class="active"><a href="home_page.php">Home</a></li>
					<li><a href="profile.php">Profile</a></li>
				</ul>
				<form class="navbar-form navbar-left">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search">
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
				</form>
				<img src="<?php echo '../'.$name['avatar']; ?>" alt="Ảnh đại diện" style="height:33px;width: 33px;margin-left: 29%;margin-top: 0.5%;">
			    <ul class="nav navbar-nav navbar-right">
					<li><a href="Profile.php"><span></span> <i>Xin chào</i> <span style="color: blue;font-size: 110%;"><?php echo$name["fullname"]; ?></span></a></li>
					<li><a href="#" onclick="user_Log_out(1)"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
				</ul>
			</div>
		</nav>
		<!-- list group in boostrap -->
		<p id = "cc"></p>
	   <div class="container-fluid">
	        <!-- Bootstrap Grid -->
 	        <div class="row">
			    <div class="col-md-3" style="background-color:lavender;">
					<h2>Dashboard Admin</h2>
					<div class="list list-group" >
						<a href="#id=1" onclick = "Changesrc('manage_users.php')" class="list-group-item active"  data-toggle="tooltip" title="Dữ liệu sinh viên trong tổ chức">Manage database users</a>
						<a href="#id=2" onclick = "Changesrc('manage_database_user.php')" class="list-group-item"  data-toggle="tooltip" title="Tài khoản sinh viên trong web">Manage users</a>
						<a href="#id=3" onclick = "Changesrc('manage_topic.php')"  data-toggle="tooltip" title="Thêm sửa xóa chủ đề" class="list-group-item">Manage topics</a>
						<a href="#id=4" onclick = "Changesrc('manage_post.php')" class="list-group-item">Manage posts</a>
						<a href="#id=5" onclick = "Changesrc('logistic.php')" class="list-group-item">Logistics</a>
						<a href="#id=6" onclick = "Changesrc('Notification.php'); Get_noti(1, 0);" class="list-group-item">Notifications<span class="badge" id="thongbao"  style="color:#C0002E;font-size: 130%;">0</span></a>
						<a href="#id=7" onclick = "Changesrc('feedback.php'); Get_noti(0, 1);" class="list-group-item" data-toggle="tooltip" title="Cac phan hoi chua xu li">Get feedbacks<span class="badge" id="thongbao1" style="color:#C0002E;font-size: 130%;">0</span></a>
						<a href="#id=8" class="list-group-item">Others</a>
						<p id="kt"><p>
					</div>
				</div>
				<div class="col-sm-8">
				  <iframe id = "Iframe" style = "height:580px;width:990px;" src="http://localhost/BaiTapLonPtUdW/View/manage_users.php"></iframe>
				</div>
			</div>
	    </div>
		
		<script type="text/javascript">

			function XXX()
    	    {
                 alert("ok?");
    	    }
		   //ham thay doi src của frame
		    function Changesrc(value)
			{
				var y = "http://localhost/BaiTapLonPtUdW/View/" + value;
				var x = document.getElementById("Iframe");
				x.setAttribute("src", y);
				//document.body.appendChild(x);
			}
			//ham thay doi active khi click vao nhom the a
			$(".list a").click(function() {
				if ($(".list a").removeClass("active")) {
					$(this).removeClass("active");
				}
				$(this).addClass("active");
			});

			//Request thong bao
			function Request_notification()
			{
				$.ajax({
					type: "post",
					url: "../../Controller/admin_controller.php",
					data: {request_notification_report:1},
					success: function(data){
					//du lieu tra ve se bao gom 3 thong so (num1, num2), num1 la so luong thong bao ve viec nguoi dung dang bai, num2 là so luong thong bao ve viec nguoi dung bao cao bai dang.do co dau "," ngan cach giua hai so num1 va num 2 nen can tim cach tach 2 so nay ra
						var data1, data2, Length, Length1;
						Length = data.length;
						Length1 = data.search(',');
						data1 = data.slice(0, Length1);//lay num1
						data2 = data.slice(Length1 + 1, Length);
						document.getElementById("thongbao").innerHTML = data1;
						document.getElementById("thongbao1").innerHTML = data2;
					}
				});
			}
			window.setTimeout("Request_notification()", 100);//chi request tu dong 1 lan
			window.setInterval("Request_notification()", 30000);//request tu dong 30s 1 lan

			//ham nay gui toi controller noi rang admin se xem thong bao, gui noi dung thong bao cho t
			function Get_noti(value1, value2){
				$.ajax({
					type: "post",
					url: "../../Controller/admin_controller.php",
					data: {receive_notification:value1, receive_report:value2},
					success: function(data){
						document.getElementById("kt").innerHTML = data;
					}
				});
				if(value1 == 1) document.getElementById("thongbao").innerHTML = 0;
				else            document.getElementById("thongbao1").innerHTML = 0;
			}

		</script>
    </body>

</html>
	