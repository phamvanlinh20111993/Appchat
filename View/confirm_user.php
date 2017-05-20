<?php

   session_start();
   
   if(!isset($_SESSION['id']) && !isset($_SESSION['pass'])){//khong cho phep vao trang nay khi chua vao trang 
	      header('Location:../view/login_register.php');      // dang nhap
   }

   echo $_SESSION['passuser'];
   
?>

<!DOCTYPE html>
<html>
  <header>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     <title>Xác nhận người dùng</title>
     <style>
       input[type=text], select {
          width: 100%;
          padding: 12px 20px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          border-radius: 4px;
          box-sizing: border-box;
       }

       input[type=submit] {
          width: 100%;
          background-color: #4CAF50;
          color: white;
          padding: 14px 20px;
          margin: 8px 0;
          border: none;
          border-radius: 4px;
          cursor: pointer;
       }

       input[type=submit]:hover {
          background-color: #45a049;
       }

       div {
          border-radius: 5px;
          background-color: #f2f2f2;
          padding: 20px;
       }
    </style>
<body>
    <div class="jumbotron">
      <h1>Blog Share File</h1>
      <p>Luôn luôn lắng nghe, sẵn sàng chia sẻ dù là pdf, hay doc,....</p>
    </div>
	<div class="container">
	    <h3>Chúng tôi cần xác nhận và quản lí tài khoản của bạn !!!</h3>
		<form action="../Controller/test_login_register.php" method = "post" id="form_submit">
			<label for="fname">Nhập mã xác nhận vào đây</label>
			<input type="text" id="code" name="code123" autocomplete="off" onclick = "Entervalue();">
			<div class="alert alert-info" style="display:none;" id="hid">
				<strong>Lỗi rồi!</strong ><p id="error">Vui lòng không để trống trường này.</p>
			</div>
		</form>
		<input type="submit" name = "confirm" value="Submit" onclick = "Submit_Form()">
	</div>
	
	<script type="text/javascript">
	
	   var count = 0;
	   function Submit_Form()
	   {
		   var val = document.getElementById("code").value;
		   if(val == ""){
			   document.getElementById("hid").style.display = "block";
			   count++;
		   }else{
			   document.getElementById("form_submit").submit();
		   }
	   }
	   
	   function Entervalue()
	   {
		if(count >= 0)
		{
			 document.getElementById("hid").style.display = "none";
		}			
	   }
	   
	</script>

</body>

</html>
