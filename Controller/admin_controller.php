<?php
    session_start();
    require_once'..\Model\model.php';
	require_once'function_service_controller.php';
	$conn = "";
	Connect($conn);

	//ham nay se tra ve thoi gian da thong bao va thoi gian hien tai
	function Change_date($Date)
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$second = abs(time() - strtotime($Date));//doi thoi gian hien tai va thoi gian da dang ve giay
		if($second < 60)                                   return "Vừa xong";
        else if( $second > 60 && $second < 3600)           return (int)($second/60)." Phút trước";
		else if($second >= 3600 && $second < 86400)        return "Khoảng ".(int)($second/3600)." Tiếng trước"; 
		else if($second >= 86400 && $second < 2592000)     return (int)($second/86400)." Ngày trước"; 
		else if($second >= 2592000 && $second < 946080000) return (int)($second/2592000)." Tháng trước";
		else                                               return "Rất rất lâu rồi.";                                    
	}

	//ham thuc hiên xoa cac ban ghi
	function Deleterecord($conn, $Array, $tbname, $where, $val)
	{
	   $del = $Array;
	   $Deletelist = json_decode($del, true);
	   $i = 0;
	   $test = 0;
	   $true = 0;
	   $add = "";
	   
	   while($i < count($Deletelist)){
	   	   if($val == 1){
	   	   		if($Deletelist[$i] == $_SESSION["id"]){
	   	   			$add = "Chúng tôi không thể xóa quản trị viên, ";
	   	   			$true = 1;
	   	   		}
	   	   }
	   	   if($true == 0){
		   		if(Delete_record($conn, $Deletelist[$i], $tbname, $where)){
			   
		   		}else{
			  		 $test = 1;
			   		 break;
		   		}
		   	}
		   $i++;
		   $true = 0;
	   }
	   if($val == 0){
	   		if($test == 0){
		   		$_SESSION['notification_topic'] = "Đã xóa thành công các bản ghi.";
	   		}else{
		 		$_SESSION['notification_topic'] = "Xay ra loi. Thu check lai code.";
	   		}
	  		 echo"<meta http-equiv='refresh' content='0';url='../view/manage_users.php'>";
	  	}else{
	  		if($test == 0){
		   		 echo $add."Đã xóa thành công các bản ghi.";
	        }else{
		   		 echo"Xảy ra lỗi, vui lòng thử lại.";
	   		}
	  	}
	}

	 //ham nay tra ve noi dung se thong bao cho admin trong quan li bai dang
    function Content_post($pos_start, $num, $giatritimkiem)
    {
       return Request_post($GLOBALS['conn'], $pos_start, $num, $giatritimkiem);
    }

    //ham nay tra ve noi dung cua thong bao, tom tat bai dang
    function Take_cotent_notice($val, $num_of_note, $start)
    {
    	$noidungtb = array();
    	$noidungtb = Content_notice($GLOBALS['conn'], (int)$val, $num_of_note, $start);
    	$length_of_tb = count($noidungtb);
    	for($i = 0; $i < $length_of_tb; $i++){
    		foreach ($noidungtb[$i] as $key => $value) {
    			if($key == "time") $noidungtb[$i]["time"] = (string)Change_date($value);
    		}
    	}
    	return $noidungtb;
    }

    //ham tra ve do dai cua bang bat ki voi dieu kien bat ki thong qua cau lenh sql
    function Length_table_any($tbname, $sql)
    {
    	return  Length_table($GLOBALS['conn'], $tbname, $sql);
    }

    //ham tra ve mot gia tri duy nhat thong qua cau lenh sql
    function Length_tb_any($tbname, $sql)
    {
    	return Length_table1($GLOBALS['conn'], $tbname, $sql);
    }

    //ham tra ve du lieu la cac ban ghi chua thong tin ve phan hoi cho admin
    function Content_report($num, $post_start)
    {
    	return Select_report($GLOBALS['conn'], $num, $post_start);
    }
	
	//Cac ham lien quan den quan li csdl cua nguoi dung
	//so luong ban ghi trong csdl kha lon vi vay moi lan chi hien ra them 10 ban ghi
	if(isset($_POST['record'])){
		$_SESSION['num_of_record'] = $_POST['record']*2;
		echo"<meta http-equiv='refresh' content='0';url='../view/manage_users.php'>";
	}
	
	//them sinh vien vao csdl
	if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['dofb']) && isset($_POST['Class']))
	{
		$id =      $_POST['id'];
		$name =     $_POST['name'];
		$dateofbirth =  $_POST['dofb'];
		$class =  $_POST['Class'];
		if(Insert_to_db_user($conn, $id, $name, $dateofbirth, $class)){
			$_SESSION['notification'] = "Đã thêm sinh viên mã số $id thành công.";
		}else{
		    $_SESSION['notification'] = "Xay ra loi. Thu check lai code.";
		}
		echo"<meta http-equiv='refresh' content='0';url='../view/manage_users.php'>";
	}
	
	//cap nhat sinh vien trong csdl
	if(isset($_POST['masv']) && isset($_POST['hoten']) && isset($_POST['ngaysinh']) && 
		isset($_POST['lop']) && isset($_POST['masvcu']))
	{
		$id = $_POST['masvcu'];
		$id_new =    $_POST['masv'];
		$name =     $_POST['hoten'];
		$dateofbirth =  $_POST['ngaysinh'];
		$dateofbirth = date_format(date_create_from_format('d-m-Y', $dateofbirth), 'Y-m-d');
		$class =  $_POST['lop'];
		
		if(Update_csdl_user($conn, $id, $id_new, $name, $dateofbirth, $class)){
			$_SESSION['notification'] = "Đã sửa đổi sinh viên mã số $id thành công.";
		}else{
			$_SESSION['notification'] = "Xay ra loi. Thu check lai code.";
		}
		echo"<meta http-equiv='refresh' content='0';url='../view/manage_users.php'>";
	}
	
	//xoa sinh vien trong csdl
	if(isset($_POST['masosv']))
	{
		$id = $_POST['masosv'];
		if(Delete_record($conn, $id, "infor_users", "id")){
			$_SESSION['notification'] = "Đã xóa sinh viên mã số $id thành công.";
		}else{
            $_SESSION['notification'] = "Xay ra loi. Thu check lai code.";
		}
		echo"<meta http-equiv='refresh' content='0';url='../view/manage_users.php'>";
	}
	
	//clear lai page trong csdl
	if(isset($_POST['clear'])){
		unset($_SESSION['num_of_record']);
		echo"<meta http-equiv='refresh' content='0';url='../view/manage_users.php'>";
	}
	
	//Cac ham lien quan den quan li chu de nguoi dung: them, sua, xoa, tim kiem chu de
	//them chu de
	if(isset($_POST['tp_id']) && isset($_POST['tp_name']))	
	{    
		$topic_id = $_POST['tp_id'];
		$topic_name = $_POST['tp_name'];
		if(add_topic($conn, $topic_id, $topic_name)){
			$_SESSION['notification_topic'] = "Đã thêm chủ đề $topic_name thành công.";
			$_SESSION['pos_fix_topic'] = $topic_id;
		}else{
			$_SESSION['notification_topic'] = "Xay ra loi. Thu check lai code.";
		}
		echo"<meta http-equiv='refresh' content='0';url='../view/manage_users.php'>";
	}
	
	//sua chu de
	if(isset($_POST['tp_id_old']) && isset($_POST['tp_id_new']) && isset($_POST['topic_name']))
	{
		$topic_id = $_POST['tp_id_old'];
		$topic_id_new = $_POST['tp_id_new'];
		$topic_name = $_POST['topic_name'];
		if(Update_topic($conn, $topic_id, $topic_id_new, $topic_name)){
			$_SESSION['notification_topic'] = "Đã sửa chủ đề $topic_name thành công.";
			$_SESSION['pos_fix_topic'] = $topic_id_new;
		}else{
			$_SESSION['notification_topic'] = "Xay ra loi. Thu check lai code.";
		}
		echo"<meta http-equiv='refresh' content='0';url='../view/manage_users.php'>";
	}
	
	//xoa chu de
	if(isset($_POST['deletelist']))
    {
	   $del = $_POST['deletelist'];
	   Deleterecord($conn, $del, "topic", "topic_id", 0);
   }
   
   //quan li tai khoan cua nguoi dung khi dang ki trong blog
   //sua tai khoan cua nguoi dung-khi nguoi dung dat ten khong dung
   if(isset($_POST["vnumail_fixed"]) && isset($_POST["name_fixed"]) && isset($_POST["id_fixed"]))
   {
   		$name = $_POST["name_fixed"];
   		$vnumail = $_POST["vnumail_fixed"];
   		$mssv = $_POST["id_fixed"];
   		$role = $_POST["role_fixed"];
   		if($mssv == $_SESSION['id'] && $role == 0){
   			echo"Không thể sửa vai trò quản trị viên chính mình, ";
   			$role = 1;
   		}
   		if(Update_user($conn, $mssv, $name, $vnumail, $role)){
   			echo"Sửa thành công.";
   		}else{
   			echo"Xảy ra sự cố. Vui lòng thử lại.";
   		}
   }

   //xoa nguoi dung trong bang nguoi dung
  	if(isset($_POST['deleteUser']))
    {
	   $del = $_POST['deleteUser'];
	   Deleterecord($conn, $del, "users", "user_id", 1);
   }
   
   //gui mail toi nguoi dung
	if(isset($_POST['to']) && isset($_POST['subject']) && isset($_POST['content']) 
		&& isset($_POST['mailtoiduser']))
	{
		$to = $_POST['to'];
		$subject = $_POST['subject'];
		$content = $_POST['content'];
		$id = (int)$_POST['mailtoiduser'];
		$name = convert_id_to_info($conn, $id); //dua vao ma sinh vien de tim ten cua nguoi se gui mail
		if(test_user_by_vnumail($to, $name, "", $subject, 1, $content)){//kiểm tra xem gửi mail cho người dùng được không
			echo"Mail đã được gửi đi thành công.";
			//header('Location: ../View/manage_users.php');
		}else{
			echo"Xảy ra sự cố. Vui lòng thử lại.";
		}
	}

    //hien thi so luong thong bao
	if(isset($_POST['request_notification_report']))//lay thong bao
    {
        $num_of_note = (int)Count_record($GLOBALS['conn'], "posts", "notification", 1);
        $num_of_rp = (int)Length_table($GLOBALS['conn'], "report", "");
        echo $num_of_note.",".$num_of_rp;
    }

	//Doc thong bao
	 if(isset($_POST["receive_notification"]) && isset($_POST["receive_report"]))
     {
     	if($_POST["receive_notification"] == 1) $_SESSION["noidungthongbao"] = "xuat no dung ra";//thong bao bai dang
     	else{
     		$_SESSION["noidungbaocaobaidang"] = "xuat no dung ra";//thong bai phan hoi
     	}
     }

     //lay thong bao cu
     if(isset($_POST['Xemthongbaocu']) && isset($_POST['solanclick'])){
     	$noidungtb = array();
     	$length_of_tb = Length_table($GLOBALS['conn'], "posts", "");//tra ve doi dai cua bang posts
     	$solanclick = 25*$_POST['solanclick'];
     	if($length_of_tb > $solanclick){
     		$noidungtb = Take_cotent_notice(0, $solanclick, ($solanclick + 25));
     		echo json_encode($noidungtb);
     	}else {
     		$noidungtb = Take_cotent_notice(0, 0, $length_of_tb);
     		echo json_encode($noidungtb);
     	}
     }

     //quan li bai dang
     if(isset($_POST["laybaidang"]) && isset($_POST["timkiem"])){
     	$giatritimkiem = $_POST["timkiem"];
     	$baidang = array();
     	/*
     	   $oDate = new DateTime("2017-02-07 18:18:26");
		   $sDate = $oDate->format("H:i, l, dd-md-yyyy");
           echo $sDate;
     	*/
     	if($giatritimkiem == "default11111"){
     		$baidang = Content_post(0, 20, "");
     		echo json_encode($baidang);
     	}else{
     		$baidang = Content_post(0, 15, $giatritimkiem);
     		echo json_encode($baidang);
     	}
     }

     //xoa bai dang cua nguoi dung chuc năng của admin
     if(isset($_POST['nguoidang']) && isset($_POST['mabaidang']) && isset($_POST['duongdan']) && isset($_POST['chude']) && isset($_POST['thoigian']) && isset($_POST['maloi']))
     {
     	$uid = $_POST['nguoidang'];//ma nguoi dung
     	$pid = $_POST['mabaidang'];//ma bai dang
     	$duongdan = $_POST['duongdan'];//dung de xoa folder tren server

     	$thoigian = $_POST['thoigian'];//thoi gian da dang
     	$chude = $_POST['chude'];//chu de da dang
     	$maloi = $_POST['maloi'];
     	Insert_error_post($GLOBALS['conn'], $uid, $pid, $thoigian, $chude, $maloi);
		$pos = 0;

		$dodai =  strlen($duongdan);
		for($i = 0; $i < $dodai; $i++){
			if($duongdan[$i] == "/"){
				$pos++;
			}
			if($pos == 3){
				$link = substr($duongdan, 0, $i + 1);
			}
		}
	    //xoa folder chua file da dang cua nguoi dung
     	unlink($duongdan);//xoa file trong folder
     	if(!rmdir($link)){//xoa folder trong(khong co file nao nua)
     		echo "Khong the xoa bai dang.";
     	}
     	//xoa du lieu trong database
     	Delete_record($GLOBALS['conn'], $pid, "posts", "post_id");

     	echo"<meta http-equiv='refresh' content='0';url='../view/manage_post.php'>";
     	$_SESSION['xoathanhcongbaidang']= "Đã xóa thành công bài đăng mã: 140203040".$pid;
     	
     }

     //lay ma so bao cao su co cua nguoi dung gui admin
     if(isset($_POST['maxoaphanhoi'])){
     	$code_report = $_POST['maxoaphanhoi'];
        Delete_record($GLOBALS['conn'], $code_report, "report", "id_report");
        echo "Thanh cong ";
     }

     //xem thong tin nguoi da bao cao bai dang
     if(isset($_POST['aibaocaobaidang'])){
     	$_SESSION['aibaocaobaidang'] = $_POST['aibaocaobaidang'];
     //	echo"<meta http-equiv='refresh' content='0';url='../view/manage_database_user.php'>";
     	//header("Location: ../view/manage_database_user.php");
     }
?>