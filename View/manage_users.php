<?php
    session_start();
	
	if(isset($_SESSION['notification']))
	{
		echo"<script type='text/javascript'>";
		echo"alert('".$_SESSION['notification']."');";
		echo"</script>";
		unset($_SESSION['notification']);
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
		   table, td, th {
              border: 1px solid black;
           }

           table {
             border-collapse: collapse;
             width: 98%;
			 margin-left:1%;
           }
		   
		   input[type="text"][disabled] {
              background-color: white;
           }

           th {
              height: 30px;
		      font-size:120%;
			  text-align:center;
			  background-color: #5882FA;
			  color:white;
           }
		
		   td{
			  height: 35px;
		   }
		
		   a{
			  color:blue;
			  text-decoration:underline;
			  font-size: 105%;
		   }
		   
		   a:hover{
			  color:green;
			  cursor:pointer;
		   }
		</style>
	</head>
	
	<body>
		<h3 style="text-align:center;">QUẢN LÍ CƠ SỞ DỮ LIỆU NGƯỜI DÙNG</h3>
		<p id="kt"></p>
		<?php
		   require_once'..\Model\model.php';
		   $conn = "";
		   Connect($conn);
		   
		   echo"<div style='border-top:1px solid grey;'><div style='margin-top:20px;'>";
		   echo"<form action = 'http://localhost/BaiTapLonPtUdW/view/manage_users.php' method = 'post'>";
		   echo "<div class = 'form-inline'><input type='text' name = 'records' placeholder='Search here....' class = 'form-control'".
		      " style='margin-left:7px;'>";
		 //  echo"<button type='submit' class='btn btn-primary active' style='margin-left:2px;width:7%;'>OK</button>";
			echo"<button type='submit' class='btn btn-primary active' style='margin-left:1%;' name = 'search'>";
			echo"<span class='glyphicon glyphicon-search'></span> Search";
			echo"</button></div>";
		   echo"</form>";
		   echo"<table style='margin-top:30px;'><form><tr><th>STT</th><th>Mã SV</th>";
		   echo"<th>Họ tên</th><th>Ngày sinh</th><th>Lớp</th><th>Thêm/Sửa</th><th>Xóa</th></tr>";

		   //dung vong while in du lieu
		   $leng = Length_table($conn, "infor_users", "");
		   if($leng > 0)
		   {
			   $stt = 0;
			   $masv = "";
			   if(isset($_SESSION['num_of_record'])) $pos = $_SESSION['num_of_record'];
			   else  $pos = 10;
			   $id_row = 10000;
			   $sinhvien = array();
			   if(isset($_POST['search'])){
				   $valu = $_POST['records'];
				   if($valu != ""){
					   $sinhvien =  Search_db($conn, $valu);
					   unset($_SESSION['num_of_record']);
				   }
			   }
			   else  $sinhvien =  Show_csdl_user($conn, $pos, "");
			   
			   for($i = 0; $i < sizeof($sinhvien); $i++)
			   {   
				  echo"<tr = ".$id_row."><td align='center'>".($i + 1)."</td>";
				  $id = $stt;
			      foreach($sinhvien[$i] as $key=>$value)//in ra 1 ban ghi
				  {
					  if($key == "dateofbirth")  $value = date_format(date_create_from_format('Y-m-d', $value), 'd-m-Y');
					  if($key == "id")      $masv = $value;
				      if($key != "name"){
						  echo"<td align='center'><input type='text' style='height:31px;text-align:center;"
						   ."font-weight:bold;font-size:15px;border:0px;' value = '".$value."' id=$id disabled></td>";
					  }else{
						  echo"<td><input type='text' style='height:31px;font-weight:bold;font-size:15px;border:0px;width:100%;' "
						   ."value = '".$value."' disabled id = $id></td>";
				      }
					  $id++;
			      } 
				  echo"<td align='center' style='display:none' id = ".($stt + 4)."><input type='button' style='width:100%;"
				   ."margin-top:2px;height:31px;' onclick = 'Sua_csdl(".$stt.")' value='Sửa'></td>";
				  echo "<td align='center' id = ".($stt + 5)."><a onclick = 'Sua(".$masv.", ".$stt.")'>Sửa</a></td>";
				  echo "<td align='center'><div style='width: 80px;'><a onclick = 'Xoa(".$masv.")'>Xóa</a></div></td>";
				  echo"</tr>";
				  $stt += 6;
				  $id_row ++;
			   }
		   }
		   
		   echo"<tr id = 'an/hien'><td align='center'>".($i + 1)."</td><td align='center'><input type='text' name='masv' id='masv'"
		    ." style='height:33px;' autofocus placeholder='Nhập mã số sinh viên...'></td>";
		   echo"<td><input type='text' name='hoten' id='hoten' style='height:33px;width:100%;' placeholder='Nhập họ tên sinh viên...'></td>";
		   echo"<td align='center'><input type='date' name='ngsinh' id='ngsinh' style='height:33px;' placeholder='Nhập ngày sinh...'></td>";
		   echo"<td align = 'center'><input type='text' id='lop' style='height:33px;width:100%;' placeholder='Nhập lớp ở đây...'></td>";
		   echo"<td align='center'><input type='button' class = 'btn btn-primary' style='width: 100%;height:33px;' value='Thêm' onclick = 'Them()'></td>";
		    echo"<td><div style='width:80px;'></div></td></tr>";
		   echo"</form></table>";
		   echo"</div></div>";
		   echo"<h3 style='margin-left:1%;'><i>(**)Có tổng cộng $leng sinh viên trong danh sách.</i></h3>";
		   echo"<ul class='pager'>";
			echo"<li class='previous'><a href='#' onclick = 'NhieuDuLieu($pos)' style='text-decoration:none;margin-left:2%;'>Show more>></a></li>";
			echo"<li class='next'><a href='#' onclick='Refresh();' style='text-decoration:none;margin-right:2%;'>Clear</a></li>";
		   echo"</ul>";
		?>
		
		<script type="text/javascript">
		  //Cac ham xu li trong csdl nguoi dung
		   function Refresh()
		   {
			   $.ajax({
					type: "POST",
					url: "../Controller/admin_controller.php",
					data: { clear: 1},
					success: function (data){
						   $('#kt').html(data);
					}
				});
		   }
		   
		   function NhieuDuLieu(val)
		   {
			    $.ajax({
					type: "POST",
					url: "../Controller/admin_controller.php",
					data: { record: val},
					success: function (data){
						   $('#kt').html(data);
					}
				});
		   }
		   
		   function Them()
		   {
			   var mssv, ht, ngs, lop;
			   mssv = document.getElementById("masv").value;
			   ht = document.getElementById("hoten").value;
			   ngs = document.getElementById("ngsinh").value;
			   lop = document.getElementById("lop").value;
			   
			   if(mssv == "" || ngs == "" || ht == "" || lop == "" || mssv.length != 8)
			   {
				   if(mssv.length != 8){
					    alert("Mã số sinh viên chỉ có 8 kí tự.");
				        document.getElementById("masv").focus();
				   }else{
						alert("Không được để trống bất kì trường nào.");
				        if(mssv == "")         document.getElementById("masv").focus();
				        else if(ht == "")      document.getElementById("hoten").focus();
				        else if(ngs == "")     document.getElementById("ngsinh").focus();
				        else                   document.getElementById("lop").focus();
				   }
			   }else{
				   $.ajax({
					   type: "POST",
					   url: "../Controller/admin_controller.php",
					   data: { id: mssv, name: ht, dofb: ngs, Class: lop},
					   success: function (data){
						   $('#kt').html(data);
					   }
				   });
			   }
			 //  document.getElementById("kt").innerHTML = ngs;
		   }
		   
		   function Xoa(mssv)
		   {
			  if(document.getElementById('an/hien').style.display == "none"){
				  document.getElementById('an/hien').style.display = "block";
			  }
			  var t = confirm("Bạn chắc chắn muốn xóa sinh viên có mã số "+mssv+" này ???");
			  if(t == true){
				    $.ajax({
					   type: "POST",
					   url: "../Controller/admin_controller.php",
					   data: { masosv: mssv},
					   success: function (data){
						   $('#kt').html(data);
					   }
				   });
			   }
			
		   }
		   
		   var masvcu = "", count_gb = 0;
		   function Sua(masvc, vl)
		   {
			   if(count_gb == 0){
					masvcu = masvc;
					document.getElementById('an/hien').style.display = "none";
					document.getElementById(vl).style.border = "1px solid black";
					document.getElementById(vl).disabled = false;
					document.getElementById(vl).focus();
			   
					document.getElementById((vl + 1)).style.border = "1px solid black";
					document.getElementById((vl + 1)).disabled = false;
					document.getElementById((vl + 2)).style.border = "1px solid black";
					document.getElementById((vl + 2)).disabled = false;
					document.getElementById((vl + 3)).style.border = "1px solid black";
					document.getElementById((vl + 3)).disabled = false;
					document.getElementById((vl + 4)).style.display = "block";
					document.getElementById((vl + 5)).style.display = "none";
			   }
			   count_gb++;
			   
		   }
		   
		   function Sua_csdl(vl)
		   {
			   var mssv, ht, ngs, lop;
			   mssv = document.getElementById(vl).value;
			   ht = document.getElementById((vl + 1)).value;
			   ngs = document.getElementById((vl + 2)).value;
			   Cl = document.getElementById((vl + 3)).value;
			  // document.getElementById("kt").innerHTML = masvcu + " " + mssv + "  " + ht + "  " + Cl + "  " + ngs ;
			   
			   $.ajax({
					type: "POST",
					url: "../Controller/admin_controller.php",
					data: { masvcu: masvcu, masv: mssv, hoten: ht, ngaysinh: ngs, lop: Cl},
					success: function (data){
						$('#kt').html(data);
					}
				});
		   }
		   
		</script>
		
		<script type="text-javascript">
		   //cac ham xu li quan li nguoi dung
		   
		</script>
</body>
</html>

