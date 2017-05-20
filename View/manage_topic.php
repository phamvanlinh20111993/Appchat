<?php
   session_start();
   
   if(isset($_SESSION['notification_topic']))
	{
		echo"<script type='text/javascript'>";
		echo"alert('".$_SESSION['notification_topic']."');";
		echo"</script>";
		unset($_SESSION['notification_topic']);
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
		<style>
			table {
				border-collapse: collapse;
				width: 80%;
				margin-left:10%;
			}

			tr:hover{background-color:#f5f5f5}

			th, td {
				padding: 8px;
				border: 1px solid #ddd;
				text-align: center;
			}

			th {
				background-color: #4CAF50;
				color: white;
			}
		</style>
	  </head>
	<body>
        <p id="kt"></p>
		<div class="container">
		    <h2 style='text-align:center;'>	QUẢN LÍ CHỦ ĐỀ</h2>
			<form action = "../view/manage_topic.php" method = "post" id="submit_form">
				<div class="form-group">
					<label>(**)Mã chủ đề</label>
					<input type="text" class="form-control" id = 0 placeholder="Nhập mã chủ đề có 5 kí tự ở đây...">
					<div class ="alert alert-warning" id = "warning0" style="display:none;margin-top:1px;">
					    <p id="cc"></p>
					</div>
				</div>
				<div class="form-group">
					<label>(**)Tên chủ đề</label>
					<input type="text" class="form-control" id = 1 placeholder="Nhập tên chủ đề ở đây...">
					<div class ="alert alert-warning"  id = "warning1" style="display:none;margin-top:1px;">
					    <strong>Cảnh báo!</strong> Không để trống trường này.
					</div>
				</div>
			</form>
			<button type="button" class="btn btn-info btn-md" style="width:100px;margin-left:5%;" id="add" onclick = "them()">Thêm</button>
			<button type="button" class="btn btn-info btn-md" style="width:100px;margin-left:10%;" id="fix" onclick = "sua_csdl()">Sửa</button>
			<button type="button" class="btn btn-info btn-md" style="width:100px;margin-left:10%;" id="del" onclick = "xoa_csdl()">Xóa</button></br></br>
			<div class ="alert alert-info"  id = "info0" style="margin-top:1px;display:none;">
				<strong>Chú ý!</strong> Hãy tích vào hàng muốn xóa.
			</div>
			<div class ="alert alert-info"  id = "warning2" style="display:none;margin-top:1px;">
				<strong>Chú ý!</strong> Tích Chọn một ô bất kì trong ô Chọn sửa.
			</div>
			<div class = "form-inline">
				<form action = "../view/manage_topic.php" method = "post">
					<input type="text" class="form-control" id = 2 placeholder="Search here..." style="width:30%;" name="vl">
					<button type="submit" class="btn btn-info btn-md" style="width:100px;margin-left:1%;" name = "search">Tìm kiếm</button>
					<div style="margin-top:1px;display:none;" id = "info1">
						<div class ="alert alert-info">
							<strong>Xin lỗi!</strong> Không để trống trường này.
						</div>
					</div>
				</form>
			</div>
		</div>
		
		<?php
			require_once'..\Model\model.php';
		    $conn = "";
		    Connect($conn);
			
			$topic = array();
			$length = Length_table($conn, "topic", "");
			if(isset($_POST['search'])){
				   $valu = $_POST['vl'];
				   if($valu != ""){
					   $topic = Search_topic($conn, $valu);
				   }
			}else  $topic = Show_topic($conn, "", $length);
			
		    echo"<div style='margin-top:3%;'><form><table>";
			echo"<tr><th>STT</th><th>Chọn sửa</th><th>Chọn xóa</th><th>Mã chủ đề</th><th>Tên chủ để</th></tr>";
			$index = 2000;
			for($i = 0; $i < sizeof($topic); $i++){
				if(isset($_SESSION['pos_fix_topic'])){
					foreach($topic[$i] as $key => $value){
						if($_SESSION['pos_fix_topic'] == $value){
							unset($_SESSION['pos_fix_topic']);
							echo"<tr style='background-color:#E0ECF8;'>";
							break;
						}
					}
				}else echo"<tr>";
				echo"<td style='width:25px;'><b>".($i + 1)."<b></td>";
				echo"<td style = 'width:14%;'><input style = 'height:20px;width:25px;background:red;'"
                . " type='radio' name = 'A' id = $i onclick = 'sua($index)'></td>";
                
                echo"<td style = 'width:14%;'><input style = 'height:20px;width:25px;background:red;'"
                . " type='checkbox' id = ".($i + 1000)."></td>";
				foreach($topic[$i] as $key => $value){
					echo "<td style='font-size:120%;'><b>$value</b></td>";
					echo "<input type = 'hidden' value = '$value' id = $index>";
					$index++;
				}
				echo"</tr>";
				$Check = 1;
			}
			echo"</table></form></div>";
			echo"<h4 style='margin-left:10%;'><i>Danh sách gồm có $length chủ đề.</i><h4>";
		?>
		
		<script type="text/javascript">
		
		    var input, searchvl, topic_id_old, count = 0, count1 = 0, count2 = 0;
			var length = parseInt(<?php echo Length_table($conn, "topic", "");?>);
			input = document.getElementsByClassName("form-control");
			
		   // document.getElementById("kt").innerHTML = length;
			input[0].addEventListener('click', function(){
				if(count > 0){
					document.getElementById("warning0").style.display = "none";
			    }
				count++;
			});
			
			input[0].addEventListener('blur', function(){
				document.getElementById("cc").innerHTML = "";
				if(count > 0){
					if(document.getElementById(0).value == ""){
						document.getElementById("cc").innerHTML += "<strong>Cảnh báo!</strong> Không để trống trường này.";
						document.getElementById("warning0").style.display = "block";
					}else if(document.getElementById(0).value.length != 5){
						document.getElementById("cc").innerHTML += "<strong>Cảnh báo!</strong> Trường này chỉ có 5 kí tự.";
						document.getElementById("warning0").style.display = "block";
					}else{
						document.getElementById("warning0").style.display = "none";
					}
			    }
				count++;
			});
			
			input[1].addEventListener('click', function(){
				if(count1 > 0){
					document.getElementById("warning1").style.display = "none";
			    }
				count1++;
				document.getElementById("kt").innerHTML += count1 + " ";
			});
			
			input[1].addEventListener('blur', function(){
				if( document.getElementById(1).value == ""){
				    document.getElementById("warning1").style.display = "block";
				}else {
					document.getElementById("warning1").style.display = "none";
				}
				count1++;
			});
			
			input[2].addEventListener('click', function(){
				if(count2 > 0){
					document.getElementById("info1").style.display = "none";
			    }
				count2++;
			});	
			
			input[2].addEventListener('blur', function(){
				if(document.getElementById(2).value == ""){
				    document.getElementById("info1").style.display = "block";
				}else {
					document.getElementById("info1").style.display = "none";
				}
				count2++;
			});
			
			//ham thuc hien chuc nang them du lieu
			function them()
			{
				var topicid, topicname;
				topicid = document.getElementById(0).value;
				topicname = document.getElementById(1).value;
				if(topicname !="" && topicid !=""){
					$.ajax({
					type: "POST",
					url: "../Controller/admin_controller.php",
					data: { tp_id: topicid, tp_name: topicname },
						success: function (data){
						   $('#kt').html(data);
						}
					});
				}else{
					if(topicid =="" || (topicid =="" && topicname == "")){
						document.getElementById(0).focus();
						document.getElementById("cc").innerHTML  = "";
						document.getElementById("cc").innerHTML = "<strong>Cảnh báo!</strong> Không để trống trường này.";
						document.getElementById("warning0").style.display = "block";
					}
					if(topicid !="" && topicname == ""){
						document.getElementById(1).focus();
						if(count1 == 0)  document.getElementById("warning1").style.display = "block";
					}
				}
			}
		     
			//hai ham thuc hien chuc nang sua du lieu
			function sua(val)
			{
				topic_id_old = document.getElementById(val).value;
				document.getElementById("fix").disabled = false;
				document.getElementById("add").disabled = true;
				document.getElementById("del").disabled = true;
				document.getElementById("warning0").style.display = "none";
				document.getElementById("warning1").style.display = "none";
				document.getElementById("warning2").style.display = "none";
				document.getElementById(0).value = topic_id_old;
				document.getElementById(1).value = document.getElementById((val + 1)).value;
				document.getElementById(0).focus();
			}
			
			function sua_csdl()
			{
				var topicid_new, topicname;
				//document.getElementById("kt").innerHTML = topic_id_old;
				document.getElementById("warning0").style.display = "none";
				document.getElementById("warning1").style.display = "none";
				document.getElementById("warning2").style.display = "none";
				topicid_new = document.getElementById(0).value;
				topicname = document.getElementById(1).value;
				if(topicid_new =="" ||  topicname ==""){
					document.getElementById("warning2").style.display = "block";
				}else{
					$.ajax({
					type: "POST",
					url: "../Controller/admin_controller.php",
					data: { tp_id_old: topic_id_old, tp_id_new: topicid_new, topic_name: topicname },
						success: function (data){
						   $('#kt').html(data);
						}
					});
				}
			}
			
			//ham thuc hien chuc nang xoa du lieu trong bang
			function xoa_csdl()
			{
				//document.getElementById("kt").innerHTML = "cc";
				var topicid, topicname, index, pos = 1000, dem = 0, temp = 1000, length1 = 0;
				var deletelist = new Array();
				document.getElementById("add").disabled = true;
				document.getElementById("fix").disabled = true;
				length1 = length + 1000;
				for(index = pos; index < length1; index++){
					if(document.getElementById(index).checked == true){
						deletelist[dem] = document.getElementById((temp + 1000)).value;
						dem++;
					}
					temp += 2;
				}
				if(dem == 0){
					document.getElementById("info0").style.display = "block";
				}else{
					var r = confirm("Bạn chắc chắn muốn xóa "+dem.toString()+" chủ đề này?");
					if(r == true){
					 	$.ajax({
							type : "POST",
							url : "../Controller/admin_controller.php",
							data: {deletelist: JSON.stringify(deletelist)},
							success: function (data){
								$('#kt').html(data);
							}		 			
					   });
					}
				}
			}
		
		</script>

	</body>
</html>

