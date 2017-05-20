<?php
    $conn = "";
    require_once'C:\xampp\htdocs\BaiTapLonPtUdW\Model\model.php';
   	Connect($conn);
	
    if(Insert_user($conn, "user", "14020822", "Pham Van Linh", "1234", "14020822@vnu.edu.vn")) {
		//  setcookie("identify_student", $name, time() + (3600), "/");//tao bien cookie ton tai 1/24 ngay
		//  setcookie("password_user", $pass, time() + (3600), "/");
		//  header('Location: http://localhost/BaiTapLonPtUdW/View/examples/homepage/homepage.php');
    }else{
		// header('Location: http://localhost/BaiTapLonPtUdW/view/login_register.php');
		echo"<script type='text/javascript'>";
	    echo"alert('Chung toi khong the tao giup ban. Sorry');";
	    echo"</script>"; 
	}
?>