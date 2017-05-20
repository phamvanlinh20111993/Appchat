<?php
    session_start();
	
    $conn = "";
    require_once'..\Model\model.php';
	include_once'function_service_controller.php';
	
	//ham random-bao gom so va ki tu tham khao tren stackoverflow.com
	function Code_confirm_user($length = 16) //ma xac nhan dai 16 ki tu
	{
         $rangelength = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $charactersLength = strlen($rangelength);
         $randomString = '';
         for ($i = 0; $i < $length; $i++) {
            $randomString .= $rangelength[rand(0, $charactersLength - 1)];
         }
	  
         return $randomString;
    }
	
	Connect($conn);//kết nối cơ sở dữ liệu trong model
	
	//khi nguoi dung dăng nhap
	if(isset($_POST['form-username']))
	{
		$id = (int)$_POST['form-username'];
		$pass = $_POST['form-password'];
		$pass1 = $pass;
		$pass = md5($pass1);
		
		if(user_login($conn, $id, $pass))
		{
			if(!isset($_COOKIE['identify_student']) && !isset($_COOKIE['password_user'])){
			    setcookie("identify_student", $id, time() + (86400), "/");//tao bien cookie ton tai 86400s = 1 day
		        setcookie("password_user", $pass1, time() + (86400), "/");
			}
			 unset($_SESSION['error_identify']);
			 unset($_SESSION['name']);
			 unset($_SESSION['mail']);
			 $_SESSION['id'] = $id;
			 $_SESSION['pass'] = $pass;
			 $_SESSION["Show_more_posts123"] = 0;//hien thi bai dang trong trang chu
			 User_offline($conn, $id);//nguoi dung duoc phep luot web trong vong 45p thi phai thoat ra dang nhap lai, do do gia su nguoi dung se offline truoc khi het thoi gian, thoi gian online van duoc luu giu o csdl, lan sau dang nhap se xay ra loi.Do do ham nay se luon xac dinh nguoi dung da offline thi moi dang nhap
			 
			 if(is_admin($conn, $id, $pass)){
			 	$_SESSION['Admin'] = 1;//nguoi dung la admin
			 	header('Location: ../view/examples/admin_page.php');
			 } else{
			 	$_SESSION['Admin'] = 0;//nguoi dung la 1 nguoi dung binh thuong
		        header('Location: ../View/examples/home_page.php');
		    }
			User_online($conn, $id);//nguoi dung online thi csdl duoc thay doi
			
		}else
		{
			 $_SESSION['error_notification'] = 'Tài khoản không đúng. Thử lại !!!';
			 echo $id."</br>";//kiem tra loi =)))
			 echo $pass;//kiem tra loi
			 $_SESSION['error_identify'] = $id;
			 header('Location: ../view/login_register.php');
		}
		unset($_POST['user_login']);
	}	
	
	//khi nguoi dung dang ki tai khoan 
	if(isset($_POST['form-fullname1']))
	{
		$name = $_POST['form-fullname1'];
        $pass = $_POST['form-pass1'];
	    $vnumail = $_POST['formvnmail'];
	    $id = (string)$_POST['form-id1'];
		
		$_SESSION['name'] = $name;
        $_SESSION['id'] = $id;
        $_SESSION['id1'] = $id;//id nay dung de hien len thanh dang ki de nguoi dung khong phai go lai
        $_SESSION['mail'] = $vnumail;
		$_SESSION['pass'] = $pass;
		 
	    if(test_id($id, $conn) == true && exit_account($conn, $id) == false)//kiem tra ngươi dung co phai sinh vien UET khong, 
		{                                                  // kiem tra tai khoan da ton tai chua
		    $passuser = Code_confirm_user();//gửi mã xác nhận mail cho người dùng
		    $_SESSION['passuser'] = $passuser;
		    if(test_user_by_vnumail($vnumail, $name, $passuser, "Xác nhận người dùng", 0, "")){//kiểm tra xem gửi mã mail cho người dùng được không
			    echo"Vui long doi nhe.</br>";
		    }else{
			    echo"Xay ra loi he thong, vui long thu lai.</br>";
		    }
		    header('Location:../View/confirm_user.php');
	    }else
		{
		   if(!test_id($id, $conn))    $_SESSION['error_notification'] = 'Hệ thống không ghi nhận được mã số của bạn. Vui lòng đổi mã khác';
		   else if(exit_account($conn, $id))    $_SESSION['error_notification'] = 'Tài khoản này đã tồn tại. Thử lại tài khoản khác.';
		   unset($_SESSION['id']);//dung cho trang chu
		   unset($_SESSION['pass']);//dung cho trang chu
		   unset($_SESSION['form-fullname1']);
		   header('Location:../view/login_register.php');
	    }
		
	}
	
	if(isset($_POST['code123'])){//kiem tra khi nguoi dung nhap ma xac nhan mail va kich vao xac nhan 
		$confirm_user_page = $_POST['code123'];//lay ma xac nhan khi nguoi dung nhap vao
		if($confirm_user_page == $_SESSION['passuser'])
	    {
			$pass1 = $_SESSION['pass'];
			$pass = md5($pass1);
			$id =  $_SESSION['id'];
			$vnumail =  $_SESSION['mail'];
			$name = $_SESSION['name'];
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			$account_creat = (new \DateTime())->format('Y-m-d H:i:s');
				
			if(Insert_user($conn, "users", $id, $name, $pass, $vnumail, $account_creat))
			{
				if(!isset($_COOKIE['identify_student']) && !isset($_COOKIE['password_user'])){
					setcookie("identify_student", $id, time() + (5000), "/");//tao bien cookie ton tai 500s
				    setcookie("password_user", $pass1, time() + (5000), "/");
				}
				header('Location:../View/examples/home_page.php');
			}else{
				$_SESSION['error_notification'] = 'Đăng kí không thành công, vui lòng thử lại.';
				header('Location:../View/login_register.php');
			}
		}else{
		    unset($_SESSION['id']);
		    unset($_SESSION['pass']);
		    $_SESSION['error_notification'] = 'Mã xác nhận không đúng, vui lòng thử lại.';
			header('Location:../View/login_register.php');
		}
		unset($_POST['code123']);
	    unset($_SESSION['confirm_vnumail']);
	    unset($_SESSION['passuser']);
	}
	
?>