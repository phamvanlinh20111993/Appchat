<?php
   
    include('class.smtp.php');
    include('class.phpmailer.php');
	
    function test_user_by_vnumail($adress_mail, $username, $passuser, $title_sendmail, $pass, $content)//ham tham khao tren freetuts.net
	{
        $nFrom = "Web Dự Án";    //mail duoc gui tu dau, thuong de ten cong ty ban
        $mFrom = 'duanwebptudweb@gmail.com';  //dia chi email cua ban 
        $mPass = 'DuAnWebPTUDWEB123';
	    //mat khau email cua ban
        $nTo = $username; //Ten nguoi nhan
        $mTo = $adress_mail;   //dia chi nhan mail
        $mail  = new PHPMailer();
        if($pass == 0) $body   =  "Mã xác nhận của bạn là: ".$passuser;   // Noi dung email
		else $body = $content;
        $title = $title_sendmail;   //Tieu de gui mail
        $mail->IsSMTP();             
        $mail->CharSet  = "utf-8";
        $mail->SMTPDebug  = 0;   // enables SMTP debug information (for testing)
        $mail->SMTPAuth   = true;    // enable SMTP authentication
        $mail->SMTPSecure = "ssl";   // sets the prefix to the servier
        $mail->Host       = "smtp.gmail.com";    // sever gui mail.
        $mail->Port       = 465;         // cong gui mail de nguyen
        // xong phan cau hinh bat dau phan gui mail
        $mail->Username   = $mFrom;  // khai bao dia chi email
        $mail->Password   = $mPass;              // khai bao mat khau
        $mail->SetFrom($mFrom, $nFrom);
        $mail->AddReplyTo('duanwebptudweb@gmail.com', 'duanwebptudweb@gmail.com'); //khi nguoi dung phan hoi se duoc gui den email nay
        $mail->Subject    = $title;// tieu de email 
        $mail->MsgHTML($body);// noi dung chinh cua mail se nam o day.
        $mail->AddAddress($mTo, $nTo);
       // thuc thi lenh gui mail 
		
        if($mail->Send()) {
           return true;
        }
		return false;
	}

    //khi click vao nut dang xuat
    function Logout()
    {
        session_destroy();
     //   header('Location: ../../view/login_register.php');
    }
	
?>