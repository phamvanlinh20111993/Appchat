<?php
   //ket noi vao csdl
   function Connect(&$conn){
       $conn = new mysqli("localhost", "root", "", "project1");
       if(!$conn){
	      echo"loi Ket Noi CSDL".$conn->connect_error."</br>";
       }else{
	    // echo"Ket Noi Thanh cong";
      }
   }
   
   //cac ham thao tac voi table user_avatar
   function Insert_user_avatar($conn, $user_id, $avatar, $date_create)
   {
   		$sql = "Insert into user_avatar(user_id, avatar, date_create)values('$user_id', '$avatar', '$date_create')";
   		if($conn->query($sql)){
	   	   return true;
	    }else{
	   	  trigger_error("Xay ra loi chen vao bang user_avatar: ".$conn->error."</br>");
	    }
   }

   //ham tra ve gia tri dau tien tim thay cua 1 bang bat ki voi dieu kien bat ky(toi da 2 dieu kien)
   function Choose_any_value($conn, $table, $choose, $collumn, $collumn1, $value, $value1)
   {
   	    if($collumn != "" && $collumn1 != ""){
   	    	$sql = "select $choose from $table where $collumn = '$value' and $collumn1 = '$value1'";
   	    }else {
   	    	$sql = "select $choose from $table where $collumn = '$value'";
   	    }
   	    $re = $conn->query($sql);
   	    $row = $re->fetch_row();

   	    return $row[0];
   }

   //ham tra ve danh sach anh cua nguoi dung
   function Show_user_avatar($conn, $collumn, $codition)
   {
   	    $sql = "select * from user_avatar where $collumn = '$codition'";
   	    $result = $conn->query($sql);

   		if(!$result){
   			trigger_error("Khong the lay du lieu tu bang user_avatar do: ".$conn->error."</br>");
   			return 0;
   		}else
   		{
   			$index = 0;
   			$avatars = array();
   			while($row = $result->fetch_assoc())
   			{
   			  $avatars[$index] = array("user_id"=>$row['user_id'], "avatar" => $row['avatar'], "date" => $row['date_create']);
   				$index++;
   			}
   		}

   		return $avatars;
   }

   //thay doi gia tri bat ki trong 1 bang bat ki voi gia tri tu ng dung
   function Update_table_any($conn, $table, $collumn, $collumn1, $value, $value_new)
   {
   	 $sql = "UPDATE $table set $collumn = '$value_new' where $collumn1 = '$value'";
   	 if($conn->query($sql)){
	   	return true;
	 }else{
	   	trigger_error("Xay ra loi cap nhat voi bang $table: ".$conn->error."</br>");
	 }
   }

   //ham nay se truyen du lieu vao bang thong bao cho nguoi dung biet bai dang cua minh da bi xóa
   //insert mã người đăng, mã bài đăng, thời gian, chủ đề, mã lỗi để khi người dùng đăng nhập, admin sẽ thông báo cụ thể cho người dùng lí do bài đăng bị xóa 
   function Insert_error_post($conn, $uid, $pid, $time, $topic, $code_er)
   {
   		$sql = "insert into er(uid, pid, time, topic, code_er)values('$uid', '$pid', '$time', '$topic', '$code_er')";

   		if($conn->query($sql)){
	   	   return true;
	    }else{
	   	  trigger_error("Xay ra loi them thong bao loi cho nguoi dung: ".$conn->error."</br>");
	    }
   }

   //hàm này sẽ lấy dữ liệu từ trong server hiển thị cho người dùng biết bài đăng của mình đã bị xóa 
   //và gửi cho người dùng chi tiết bài đăng đã bị xóa là bài đăng nào, khi nào, tại sao bị xóa...
   function Select_error_post($conn, $uid)
   {
   		$sql = "select e.id_er, u.fullname, e.pid, e.time, e.topic, e.code_er from er e inner join users u on e.uid = u.user_id where e.uid = $uid";
   		$result = $conn->query($sql);

   		if(!$result){
   			trigger_error("Khong the lay du lieu tu bang er do: ".$conn->error."</br>");
   			return 0;
   		}else
   		{
   			$index = 0;
   			$error_post = array();
   			while($row = $result->fetch_assoc())
   			{
   				$error_post[$index] = array("id_er"=>$row['id_er'], "name" => $row['fullname'], "post_id" => $row['pid'], "time_post" => $row['time'], "name_topic" => $row['topic'], "er_cd" => $row['code_er']);
   				$index++;
   			}
   		}

   		return $error_post;
   }

   //ham se nhan cac phan hoi cua nguoi dung ve bai dang luu tru tren server
   function Insert_report($conn, $id_u_send, $id_post, $content)
   {
   	 date_default_timezone_set('Asia/Ho_Chi_Minh');
       $Time = date('Y-m-d H:i:s', Time());//time 24h
   	 $sql = "insert into report(id_u_send, id_post, content, Date)values('$id_u_send', '$id_post', '$content', '$Time')";
   	 if($conn->query($sql)){
	   	   return true;
	 }else{
	   	  trigger_error("Xay ra loi khi chen du lieu vao table report: ".$conn->error."</br>");
	 }
   }

   //ham se tra ve thong bao cho admin biet phan hoi cua nguoi dung
   function Select_report($conn, $num, $post_start)
   {
   	  $sql = "SELECT * from report limit $num, $post_start";
   	  $result = $conn->query($sql);
   	  if($result){
   	  	$index = 0;
   	  	$report_lists = array();
   	  	while($row = $result->fetch_assoc()){
   	  		$report_lists[$index] = array("id_rp"=>$row['id_report'], 'user_send'=> $row['id_u_send'], "id_post" => $row['id_post'], "content"=>$row['content'], 'date'=>$row['Date']);
   	  		$index++;
   	  	}
   	  	return $report_lists;
   	  }else{
   	  	trigger_error($conn->error);
   	  	return 0;
   	  }

   }

   //hàm kiểm tra sinh viên có là sinh viên uet, du lieu co san(tham khao)
   function test_id($id, $conn)
   {
      $sql = "select id from infor_users where id = '$id'";
      $result = $conn->query($sql);
      if($result){
	     $num = mysqli_num_rows($result);
		 echo "So dong: ".$num;
		 if($num >= 1) return true;
      }else{
	    trigger_error("Loi truy van: ".$conn->error."</br");
      }	
	  return false;
   }
   
   //kiểm tra xem đã tồn tại tài khoản chưa để không cho phép tạo nhiều tài khoản trùng nhau thông qua mssv
   function exit_account($conn, $id)
   {
	   $sql = "select user_id from users where user_id = $id";
	   $result = $conn->query($sql);
	   if($result)
	   {
		   $num =  mysqli_num_rows($result);//dem so ban ghi tra ve
		   if($num == 0) return false;
	   }else{
		   trigger_error("Loi truy van: ".$conn->error."</br");
	   }
	   
	   return true;
   }
   
   //kiem tra nguoi dung co phai quan tri vien khong, admin mac dinh co gia tri 1, con nguoi dung binh thuong thi co gia tri 0, admin co trang su dung rieng(trang admin)
   function is_admin($conn, $id, $pass)
   {
	   $sql = "select Admin from users where user_id = '$id' and pass = '$pass'";
	   $result = $conn->query($sql);
	   $row = mysqli_fetch_assoc($result);
	  // echo $row['Admin'];
	   if(intval($row['Admin']) == 1) return true;
	   return false;
   }
   
   //Người dùng đăng nhập vào hệ thống, neu nguoi dung da dang ki va dang nhap đúng tài khoản đã đăng kí thì người dùng có thể đăng nhập
   function user_login($conn, $id, $pass)
   {
	   $sql = "select * from users where user_id = '$id' and pass = '$pass'";
	   $result = $conn->query($sql);
	   if($result){
		   $num =  mysqli_num_rows($result);
		   if($num == 1) return true;
		   echo $num."   ";
	   }else{
		   trigger_error("Loi truy van: ".$conn->error."</br");
		   return false;
	   }
	   
	   return false;
   }

   //nguoi dung online thi csdl thay doi, mặc đinh khi người dùng offline thì trường online đặt giá trị 0, còn khi người dùng online thì trường này có giá trị 1
   function User_online($conn, $id)
   {
   		$sql = "update users set Online = '1' where user_id = '$id'";
   		if(!$conn->query($sql)){
   			trigger_error("Loi truy van ".$conn->error."</br>");
   		}
   }

    //nguoi dung offline thi csdl thay doi 
   function User_offline($conn, $id)
   {
   		$sql = "update users set Online = '0' where user_id = '$id'";
   		if(!$conn->query($sql)){
   			trigger_error("Loi truy van ".$conn->error."</br>");
   		}
   }

   //ham nay dung de set time out de huy session cua nguoi dung, neu sau mot vai phut xac dinh(5-30 phut) ma nguoi dung khong lam gi thi coi nhu da offline, nguoi dung phai dang nhap lai
   function Do_you_online($conn)
   {
   	   $sql = "SELECT user_id,  timeout from users";
   	   $re = $conn->query($sql) or die($conn->error);
   	   $time_array = array();
   	   $i = 0;

   	   while($row = $re->fetch_assoc())
   	   {
   	   	    $time_array[$i] = array("time"=>$row["timeout"], "user_id" => $row["user_id"]);
   	   	    $i++;
   	   }
   	   return $time_array;
   }
   
   //ham nay dua tren thong tin cua masosv de chuyen thanh thong tin nguoi dung(ten nguoi dung) trong csdl ng dung. Admin sẽ sử dụng tên thật người dùng trong các trường hợp cụ thể. Hàm trả về tên thật của người dùng
   function convert_id_to_info($conn, $id)
   {
	   $sql = "select name from infor_users where id = '$id'";
	   $result = $conn->query($sql);
	   $row = $result->fetch_row();
	   if($result){
		    return $row[0];
	   }
	   return trigger_error("Loi truy van: ".$conn->error."</br");
   }

    //ham nay dua tren thong tin cua masosv de chuyen thanh thong tin nguoi dung(ten nguoi dung) trong table ng dung. Hàm sẽ trả về tên người dùng(tên lúc đăng kí), địa chỉ vnu mail và ảnh đại diện của người dùng có mã số đó
   function convert_id_to_info1($conn, $id)
   {
   		$sql = "select fullname, vnumail, avatar, date_create from users where user_id = '$id'";
   		$result = $conn->query($sql);
   		$row = mysqli_fetch_row($result);
        $user = array("fullname"=> $row[0], "vnumail"=>$row[1], "avatar"=>$row[2], "date"=>$row[3]);
        if($result){
        	return $user;
        }
          return trigger_error("Loi truy van: ".$conn->error."</br");
   }
   
   //thêm người dùng vào bảng-khi nguoi dung dang ki tai khoan
   function Insert_user($conn, $tbname, $mssv, $name, $pass, $vnumail, $account_date)
   {	
	   $avatar = "..\Datasystem\logo.png";//logo mac dinh cua he thong
	   $avatar  = addslashes($avatar);//them dau cheo vao database
	   //mysqli_real_escape_string($conn, $avatar);
	   $sql = "INSERT INTO $tbname(user_id, fullname, pass, vnumail, avatar, date_create)VALUES('$mssv', '$name', '$pass', '$vnumail','$avatar', '$account_date')";
	   if($conn->query($sql)){
		   return true;
	   }else  echo"Xay ra loi: ".$conn->error;
	   return false;
   }
   
   //chuc nang cua Admin trong quan li nguoi dung, them nguoi dung, sua nguoi dung, xoa nguoi dung
   //thay đổi thông tin của người dùng-vai trò của admin
   function Update_user($conn, $masv, $name, $vnumail, $role)
   {
	   $sql = "UPDATE users SET  fullname = '$name', vnumail = '$vnumail', Admin = $role where user_id = '$masv'";
	   if($conn->query($sql)){
		   return true;
	   }else  echo"Xay ra loi: ".$conn->error;
	   return false;
   }
   
   //thay đổi thông tin của người dùng trong csdl nguoi dung-vai trò của admin
   function Update_csdl_user($conn, $id, $id_new, $name, $dateofbirth, $class)
   {
	   $sql = "UPDATE infor_users SET id = '$id_new', name = '$name', dateofbirth = '$dateofbirth', class = '$class' where id = '$id'";
	   if($conn->query($sql)){
		   return true;
	   }else  echo"Xay ra loi: ".$conn->error;
	   return false;
   }
   
   //them nguoi dung moi vao co su du lieu cua nguoi dung, khi dang ki
   function Insert_to_db_user($conn, $id, $name, $dateofbirth, $class)
   {
	   $sql = "INSERT INTO infor_users(id, name, dateofbirth, class) VALUES ('$id', '$name', '$dateofbirth', '$class')";
	   if($conn->query($sql)){
		   return true;
	   }else  echo"Xay ra loi: ".$conn->error;
	   return false;
   }
   
   //hien thi thong tin co so du lieu nguoi dung, sử dụng trong page của admin
   function Show_csdl_user($conn, $pos, $sql)
   {
		if($sql == "") $sql = "select * from infor_users limit $pos";
		
		$result = $conn->query($sql);
		if(!$result)
		{
			return trigger_error("Loi truy van: ".$conn->error."</br>");
		}else
		{
			$arraylist = array();
			$index = 0;
			while($row = $result->fetch_assoc())
			{
				$arraylist[$index] = array("id"=>$row['id'], "name"=>$row['name'],
				  "dateofbirth"=>$row['dateofbirth'], "class"=>$row['class']);
				$index++;
			}
			return $arraylist;
		}
	}
	
	//hien thi thong tin nguoi dung, trả về mã số sinh viên, tên, địa chỉ mail, ảnh đại diện và vai trò( người dùng bt hay admin quản trị web)của bất kì người dùng
	function Show_user($conn, $pos)
    {
		$sql = "select * from users limit $pos";
		$result = $conn->query($sql);
		if(!$result){
			return trigger_error("Loi truy van: ".$conn->error."</br>");
		}else
		{
			$arraylist = array();
			$index = 0;
			while($row = $result->fetch_assoc())
			{
				if($row['Admin'] == 0)  $role = "User";
				else                    $role = "Admin";
				$arraylist[$index] = array("user_id"=>$row['user_id'], "fullname"=>$row['fullname'],
				  "vnumail"=>$row['vnumail'], "avatar"=>$row['avatar'], "status"=>$role);
				$index++;
			}
			return $arraylist;
		}
	}

    //hàm nay hiển thị những người dùng online hoặc offline với điều kiện $cond (0 là off, 1 là on) và số lượng hiển thị ($pos)-vì có thể có rất nhiều người dùng on hoặc off. Và khi hiển thị cho người dùng đó, hàm sẽ trả về những người dùng khác mà không phải người đó thông qua biến $id
	function Show_user_on_ofline($conn, $pos, $cond, $id)
	{
		$sql = "select user_id, fullname, avatar from users where Online = '$cond' and user_id != '$id'";
		$result = $conn->query($sql);

		if(!$result){
			return trigger_error("Loi truy van: ".$conn->error."");
		}else
		{
			$arraylist = array();
			$index = 0;
			while($row = $result->fetch_assoc())
			{
				$arraylist[$index] = array("userid"=>$row['user_id'], "avatar"=>$row['avatar'], "fullname"=>$row['fullname']);
				$index++;
			}
			return $arraylist;
		}

	}
	
	//tra ve do dai cua bang bat ki thong qua cau lenh sql co the la 1 dieu kien hay 2 dieu kien
	function Length_table($conn, $tbname, $sql)
	{
		if($sql == "") $sql = "select * from $tbname";//nếu mã sql là "" thì chạy câu lệnh này
		$result = $conn->query($sql);
		if(!$result)
		{
			trigger_error("Loi truy van: ".$conn->error."</br>");
		}else
		{
		    return $result->num_rows;
		}
	}

	//tra ve 1 gia tri duy nhat cua bang bat ki thong qua cau lenh sql co the la 1 dieu kien hay 2 dieu kien
	//vi du khi chon ma so sinh vien co nhieu binh luan nhat
	function Length_table1($conn, $tbname, $sql)
	{
		$result = $conn->query($sql);
		if(!$result)
		{
			trigger_error("Loi truy van csdl: ".$conn->error."</br>");
		}else
		{
			$row = $result->fetch_row();
		    return $row[0];
		}
	}

	//ham tra ve do dai cua bang voi dieu kien bat ki
	function Count_record($conn, $tbname, $collumn, $condition)
	{
		$sql = "select * from $tbname where $collumn = '$condition'";
		$result = $conn->query($sql);
		if(!$result)
		{
			trigger_error("Loi truy van xay ra: ".$conn->error."</br>");
		}else
		{
		    return $result->num_rows;
		}
	}
   
   //hàm tìm kiếm người dùng- sử dụng trong page của admin
   function Search($conn, $value)
   {
	   $sql = "select * from users where user_id like '%$value%' or fullname like '%$value%'";
	   return Show_user($conn, Length_table($conn, "users", $sql));
   }
   
   //hàm tìm kiếm trong cơ sở dl người dùng-chỉ admin ms sử dung hàm này
   function Search_db($conn, $value)
   {
	   $sql = "select * from infor_users where id like '%$value%' or name like '%$value%' ".
	    "or class like '%$value%' or dateofbirth like '%$value%'";
	   return Show_csdl_user($conn, Length_table($conn, "infor_users", $sql) , $sql);
   }
   
    //Quan li chu de cua nguoi dung
	//them chu de
   function add_topic($conn, $topic_id, $topic_name)
   {
	   $sql = "INSERT INTO topic(topic_id, name_topic)values('$topic_id', '$topic_name')";
	   if($conn->query($sql)){
		   return true;
	   }echo "Xay ra loi: ".$conn->error;
	   return false;
   }
   
   //cap nhat chu de- sửa lại chủ đề
   function Update_topic($conn, $topic_id, $topic_id_new, $topic_name)
   {
	   $sql = "UPDATE topic SET topic_id = '$topic_id_new', name_topic = '$topic_name' where topic_id = '$topic_id'";
	   if($conn->query($sql)){
		   return true;
	   }else  echo "Xay ra loi: ".$conn->error;
	   return false;
   }
   
   //tim kiem chu de
   function Search_topic($conn, $value)
   {
	   $sql = "select * from topic where topic_id like '%$value%' or name_topic like '%$value%'";
	   return Show_topic($conn, $sql, Length_table($conn, "topic", $sql));
   }
   
   //hien thi chu de
   function Show_topic($conn, $sql, $pos)
   {
	   if($sql == "") $sql = "select * from topic limit $pos";
	   $result = $conn->query($sql);
	   if(!$result){
		   trigger_error("Loi truy van: ".$conn->error."</br>");
		   return false;
	   }else{
		    $arraylist = array();
			$index = 0;
			while($row = $result->fetch_assoc())
			{
				$arraylist[$index] = array("topic_id"=>$row['topic_id'], "topic_name"=>$row['name_topic']);
				$index++;
			}
			return $arraylist;	
	   }
   }
    
	//xóa ban ghi trong cac bang dung chung cho quan li nguoi dung, csdl nguoi dung, chu de, bai dang, er
   function Delete_record($conn, $id, $table_name, $table_collumn)
   {
	   $sql = "DELETE from $table_name where $table_collumn = '$id'";
	   if($conn->query($sql)){
		   return true;
	   }else  echo"Xay ra loi: ".$conn->error;
	   return false;
   }
   
   //Cac ham truy van csdl khi nguoi dung tien hanh dang bai, binh luan va like bai dang
   //khi nguoi dung tien hanh dang bai
   function post_post($conn, $link, $notice, $user_id, $topic_id, $file_name)
   {
   	date_default_timezone_set('Asia/Ho_Chi_Minh');
   	$post_time = date("Y-m-d H:i:s", time());
   	$notification = 1;
	   $sql = "insert into posts(post_time, link, notice, user_id, topic_id, notification, name_of_file) values ('$post_time', '$link', '$notice', '$user_id', '$topic_id', $notification, '$file_name')";

	   if($conn->query($sql)){
	   	   return true;
	   }else{
	   	  trigger_error("Xay ra loi: ".$conn->error."</br>");
	   }
   }
   
   //khi nguoi dung tien hanh dang binh luan, dung ajax
   function post_comment($conn, $user_id, $post_id, $comment_time, $content)
   {
	   $sql = "insert into comments(user_id, post_id, comment_time, content)values('$user_id', '$post_id', '$comment_time', '$content')";

	   if($conn->query($sql)){
	   	   return true;
	   }else{
	   	  trigger_error("Xay ra loi: ".$conn->error."</br>");
	   	  return false;
	   }
   }

   // khi nguoi dung tien hanh like bai dang, dung ajax
   function post_like($conn, $user_id, $post_id, $status) 
   {
	   $sql = "insert into likepost(user_id, post_id, status)values('$user_id', '$post_id', '$status')";

	   if($conn->query($sql)){
	   	   return true;
	   }else{
	   	  trigger_error("Xay ra loi: ".$conn->error."</br>");
	   }
   }

   //ham tra ve thong tin nguoi dung thich bai dang
   function Infor_users_like($conn, $post_id)
   {
   		$sql = "select l.user_id, u.fullname, u.avatar, u.vnumail from likepost l inner join users u on l.user_id = u.user_id where l.post_id = $post_id";
   		$result = $conn->query($sql);
   		$Infomation_user_like = array();
   	    $count = 0;
   	    while($row = $result->fetch_assoc())
   	    {
   	    	 $Infomation_user_like[$count] = array("user_id"=>$row['user_id'], "name"=>$row['fullname'], "avt"=>$row['avatar'], "mail"=>$row['vnumail']);
   	   		$count++;
   	    }

   	    if($conn->query($sql)){
	   	   return $Infomation_user_like;
	    }else{
	   	  trigger_error("Xay ra loi roi: ".$conn->error."</br>");
	   	  return 0;
	    }

   }

   //danh gia bai dang cua nguoi dung
   function post_judge($conn, $user_id, $post_id, $num_of_star)
   {
   		$sql = "insert into judge(user_id, post_id, num_of_star)values('$user_id', '$post_id', '$num_of_star')";

	   if($conn->query($sql)){
	   	   return true;
	   }else{
	   	  trigger_error("Xay ra loi: ".$conn->error."</br>");
	   }
   }

   //ham tra ve thong tin nguoi dung da danh gia bai dang
   function Infor_users_rating($conn, $post_id)
   {
   	   $sql = "select j.user_id, j.num_of_star, u.fullname, u.avatar, u.vnumail from judge j inner join users u on j.user_id = u.user_id where j.post_id = $post_id";
   	   $result = $conn->query($sql);
   	   $Infomation_user_rate = array();
   	   $count = 0;

   	   while($row = $result->fetch_assoc())
   	   {
   	   	    $Infomation_user_rate[$count] = array("user_id"=>$row['user_id'], "name"=>$row['fullname'], "avt"=>$row['avatar'], "mail"=>$row['vnumail'], "star"=>$row['num_of_star']);
   	   		$count++;
   	   }

   	   if($conn->query($sql)){
	   	   return $Infomation_user_rate;
	   }else{
	   	  trigger_error("Xay ra loi roi: ".$conn->error."</br>");
	   	  return 0;
	   }
   }
   
   //chinh sua bai dang, hàm nâng cao
   //cho phep chinh sua noi dung dang di cung voi thoi gian cung thay doi
   function Update_post($conn, $post_id, $notice, $post_time)
   {
   	   $sql = "update posts set notice = '$notice', post_time = '$post_time' where post_id = $post_id";

   		if($conn->query($sql)){
   			return true;
   		}else{
   			trigger_error("Khong the chinh sua bai dang do: ".$conn->error."</br>");
   			return false;
   		}
   }

   //chinh sua binh luan, hàm nâng cao
   //cho phep chinh sua noi dung da binh luan thoi gian cung thay doi
   function Update_comment($conn, $comment_time, $content)
   {
   		$sql = "update comments set ";

   }

   //Ham cho phep xoa bai dang cua nguoi dung
   //ham nay se so sanh thoi gian dang binh luan trong bai dang va sau do xoa di
   function Delete_comment($conn, $cmt_id, $post_id)
   {
   		$sql = "delete from comments where post_id = '$post_id' and id_cmt = '$cmt_id'";
   		if($conn->query($sql)){
   			return true;
   		}else{
   			trigger_error("Khong the xoa binh luan do: ".$conn->error."</br>");
   			return false;
   		}
   }

   //ham nay se tra ve id_cmt lon nhat trong csdl, vi ham nay lien quan den xoa binh luan
   function Position_max_cmt($conn, $tbname, $collumn)
   {
   		$sql = "select MAX($collumn) from $tbname";
   		$result = $conn->query($sql);
   		if($result){
            $row = $result->fetch_row();
   			return $row[0];
   		}else{
   			trigger_error("Cannot take max value of $collumn in $tbname do: ".$conn->error."</br>");
            return -1;
   		}
   }

   //tra ve so luong bai dang cua nguoi dung trong phan quan li bai dang
   function Request_post($conn, $num, $pos_start, $search_val)
   {
   	    $index = 0;
   	   if($search_val == ""){//hien thi bang bai dang admin quan li
   		   $sql = "select p.user_id, p.post_id, p.link, p.post_time, u.fullname, p.name_of_file, t.name_topic from posts p inner join topic t on p.topic_id = t.topic_id inner join users u on u.user_id = p.user_id limit $num, $pos_start";
   		   $result = $conn->query($sql);

   			if(!$result){
				return trigger_error("Loi truy van: ".$conn->error."</br>");
			}else{
		  		$arraylist = array();
				while($row = $result->fetch_assoc())
				{
					$arraylist[$index] = array("uid"=>$row['user_id'],"postid"=>$row['post_id'], "name"=>$row['fullname'], "post_time"=>$row['post_time'], "topic_name"=> $row["name_topic"], "namefile"=>$row['name_of_file'], "link"=>$row['link']);
					$index++;
				}
			}
   	   }else
   	   {
   	   	   $replace = "p.user_id LIKE '%".$search_val."%'";//tim kiem theo ma sinh vien
   	   	   $replace1 = "t.name_topic LIKE '%".$search_val."%'";//tim kiem theo ten chu de
   	   	   $replace2 = "u.fullname LIKE '%".$search_val."%'";//tim kiem theo ten nguoi dung

   	   	   $sql = "select p.user_id, p.post_id, p.link, p.post_time, u.fullname, p.name_of_file, t.name_topic from posts p inner join topic t on p.topic_id = t.topic_id inner join users u on u.user_id = p.user_id where ";
   	   	   $sql1 = "";
   	   	   $sql1 = $sql.$replace;
   	   	   $result1 = $conn->query($sql1);
   	 
   	   	   $arraylist = array();
   	   	   if(!$result1){
   	   	   		return trigger_error("Khong the tim kiem theo ma sinh vien: ".$conn->error."</br>");
   	   	   }else{
   	   	   		if(mysqli_num_rows($result1) > 0){
   	   	   			while($row = $result1->fetch_assoc())
					{
						$arraylist[$index] = array("uid"=>$row['user_id'],"postid"=>$row['post_id'], "name"=>$row['fullname'], "post_time"=>$row['post_time'], "topic_name"=> $row["name_topic"], "namefile"=>$row['name_of_file'], "link"=>$row['link']);
						$index++;
					}
   	   	   		}
   	   	   }

   	   	   $sql1 = "";
   	   	   $sql1 = $sql.$replace1;
   	   	   $result1 = $conn->query($sql1);
   	   	   if(!$result1){
   	   	   		return trigger_error("Khong the tim kiem theo ten chu de: ".$conn->error."</br>");
   	   	   }else{
   	   	   		if(mysqli_num_rows($result1) > 0){
   	   	   			while($row = $result1->fetch_assoc())
					{
						$arraylist[$index] = array("uid"=>$row['user_id'],"postid"=>$row['post_id'], "name"=>$row['fullname'], "post_time"=>$row['post_time'], "topic_name"=> $row["name_topic"], "namefile"=>$row['name_of_file'], "link"=>$row['link']);
						$index++;
					}
   	   	   		}
   	   	   }
           
           $sql1 = "";
   	   	   $sql1 = $sql.$replace2;
   	   	   $result1 = $conn->query($sql1);
   	   	   if(!$result1){
   	   	   		return trigger_error("Khong the tim kiem theo ten nguoi dung: ".$conn->error."</br>");
   	   	   }else{
   	   	   		if(mysqli_num_rows($result1) > 0){
   	   	   			while($row = $result1->fetch_assoc())
					{
						$arraylist[$index] = array("uid"=>$row['user_id'],"postid"=>$row['post_id'], "name"=>$row['fullname'], "post_time"=>$row['post_time'], "topic_name"=> $row["name_topic"], "namefile"=>$row['name_of_file'], "link"=>$row['link']);
						$index++;
					}
   	   	   		}
   	   	   }
   	    }

   	    return $arraylist;	
   }

   //ham nay se thay doi gia tri thong bao la 1 thanh 0 de biet la admin da nhan duoc thong bao
   function Receive_notice($conn)
   {
   	  $sql = "UPDATE posts set notification = 0";

   	  $re = $conn->query($sql);
   	  if(!$re){
   	     trigger_error("Co loi xay ra: ".$conn->error."</br>");
   	     return false;
   	  }
   	  return true; 
   }

   //ham nay se lay thong tin ve nguoi dung da dang bai de thong bao voi admin
   //gia tri $new_old de lay noi dung da thong bao hay thong bao cun
   function Content_notice($conn, $new_old, $pos, $num)
   {
   	  $sql = "select p.post_id , p.user_id, u.fullname, p.post_time from posts p inner join users u on u.user_id = p.user_id where notification = $new_old order by post_id desc limit $pos, $num";
   	  $Content_notice = array();
   	  $result = $conn->query($sql);

   	  if(!$result)
   	  {
   	  	trigger_error("Khong the lay thong bao: ".$conn->error."</br>");
   	  }else
   	  {
        $index = 0;
        while ($row = $result->fetch_assoc())
        {
           $Content_notice[$index] = array("postid" => $row['post_id'], "userid"=>$row['user_id'], "name"=>$row['fullname'], "time"=>$row['post_time']);
           $index++;
        }
        if(Receive_notice($conn));//da lay duoc thong bao
        else echo"Khong the thay doi gia tri thong bao bai dang. Debugg ngay</br>";

        return $Content_notice;
   	  }
   }

   //hien thi bai dang tu trong co so du lieu, $condition la phan nang cao de tim kiem bai dang voi mot hoac 2 dk xac dinh, vi du tim kiem bai dang theo tg, theo ten, theo ma chu de
   function Show_post($conn, $pos_start, $pos_end, $collumn, $condition)
   {
   	    if($collumn == ""){
   			$sql = "select p.user_id, p.post_id, p.post_time, p.link, p.notice, p.name_of_file, u.fullname, u.avatar, t.name_topic from posts p inner join topic t on p.topic_id = t.topic_id inner join users u on u.user_id = p.user_id order by p.post_id desc limit $pos_start, $pos_end";
   		}else{
   			$sql = "select p.user_id, p.post_id, p.post_time, p.link, p.notice, p.name_of_file, u.fullname, u.avatar, t.name_topic from posts p inner join topic t on p.topic_id = t.topic_id inner join users u on u.user_id = p.user_id where ".$collumn." = '$condition' order by p.post_id desc limit $pos_start, $pos_end";
   		}
   		$result = $conn->query($sql);

   		if(!$result){
   			return trigger_error("Loi truy van: ".$conn->error."</br>");
   		}else{
   			$arraylist = array();
   			$avatar = array();
			$index = 0;
			while($row = $result->fetch_assoc())
			{
				$arraylist[$index] = array("post_id"=>$row['post_id'], "post_time"=>$row['post_time'],"notice"=>$row['notice'], "link"=>$row["link"], "name"=>$row['fullname'], "name_tp"=>$row['name_topic'], "avatar"=>$row['avatar'], "name_file"=>$row['name_of_file'], "uid"=>$row['user_id']);
				$index++;
			}
			return $arraylist;	
   		}
   }

   //hien thi binh luan
   function Show_comment($conn, $post_id, $num, $pos_start)
   {
   		$sql = "select c.id_cmt, c.comment_time, c.content, u.fullname, u.avatar from comments c inner join users u on c.user_id = u.user_id where c.post_id = '$post_id' order by c.id_cmt asc limit $pos_start, $num";

   		$result = $conn->query($sql);

   		if(!$result){
   			return trigger_error("Khong the load binh luan do: ".$conn->error."</br>");
   		}else{
   			$comment = array();
   			$i = 0;
   			while ($row = $result->fetch_assoc()) {
   				$comment[$i] = array("id_cmt"=>$row["id_cmt"],"avt"=>$row['avatar'], "name"=>$row['fullname'], 
   					"time"=>$row['comment_time'], "content"=>$row['content']);
   				$i++;
   			}

   			return $comment;
   		}
   }

   //Hien thi thong tin danh gia bai dang
   function Show_rate($conn, $post_id, $user_id)
   {
   	    $sql = "select num_of_star from judge where user_id = '$user_id' and post_id = '$post_id'";
   	    $re = $conn->query($sql);
   	    if(!$re) return trigger_error("Co loi xay ra: ".$conn->error."</br>");
   	    else{
   	    	$row = $re->fetch_row();
   	    	return $row[0];
   	    } 
   }

   //hien thi thong tin like bai dang cua nguoi dùng.
   //Ví dụ: Bạn A đăng nhập vào home_page, cần hiển thị trạng thái các bài đăng A đã like và chưa like, trạng thái status luôn là 0, 
   function Show_likepost($conn, $post_id, $user_id)
   {
   		$sql = "select status from likepost where user_id = '$user_id' and post_id = '$post_id'";
   		
   		$re = $conn->query($sql);
   	    if(!$re) return trigger_error("Co loi: ".$conn->error."</br>");
   	    else{
   	    	return mysqli_num_rows($re);// tra ve 1 neu da like bai dang hoac 0 neu chua like bai dang
   	    } 
   }

   //ham thao tac voi bang likepost
   //ham dau tien la ham thao tac  them nguoi dung da like bai dang bao gom ma bai dang va ma nguoi dung(ma sinh vien)
   function To_Add_like($conn, $post_id, $user_id)
   {
   	  $sql = "insert into likepost(user_id, post_id) values('$user_id', '$post_id')";
   	  if(!$conn->query($sql))
   	  {
   	  	trigger_error("Co loi xay ra khi them thong tin: ".$conn->error."</br>");
   	  	return false;
   	  }else return true;
   }

   //ham xoa bo trang thai bo like bai viet cua nguoi dung
   function To_leave_like($conn, $post_id, $user_id)
   {
   	  $sql = "delete from likepost where post_id = '$post_id' and user_id = '$user_id'";
   	  if(!$conn->query($sql))
   	  {
   	  	trigger_error("Co loi xay ra khi xoa like: ".$conn->error."</br>");
   	  	return false;
   	  }else return true;
   }

   //ham thao tac voi bang judge
   //ham dau tien la ham thao tac them nguoi dung da danh bai dang bao gom ma bai dang va ma nguoi dung(ma sinh vien), gia tri num_of_jstar luon la 1 den 5
   function To_Add_rating($conn, $post_id, $user_id, $num_of_star)
   {
   	  $sql = "insert into judge(user_id, post_id, num_of_star) values('$user_id', '$post_id', '$num_of_star')";
   	  if(!$conn->query($sql))
   	  {
   	  	trigger_error("Co loi xay ra khi them thong tin danh gia bai viet: ".$conn->error."</br>");
   	  	return false;
   	  }else return true;
   }

   //ham xoa bo trang thai bo danh bai viet cua nguoi dung
   function To_leave_rating($conn, $post_id, $user_id)
   {
   	  $sql = "delete from judge where post_id = '$post_id' and user_id = '$user_id'";
   	  if(!$conn->query($sql))
   	  {
   	  	trigger_error("Co loi xay ra khi xoa danh gia bai viet: ".$conn->error."</br>");
   	  	return false;
   	  }else return true;
   }

   //ham tra ve gia tri sao ma nguoi dung da danh gia
   function value_of_user_rating($conn, $post_id, $user_id)
   {
   	  $sql = "select num_of_star from judge where post_id = $post_id and user_id = $user_id";
   	  $result = $conn->query($sql);
   	  if(!$result)
   	  {
   	  	trigger_error("Co loi xay ra khi lay gia tri danh gia: ".$conn->error."</br>");
   	  	return -1;
   	  }else{
   	  	$row = $result->fetch_row();
   	  	return $row[0];

   	  } 
   }

   //ham tra ve diem trung binh danh gia cua bai dang
   //vd:co 3 ban A, B, C danh gia ma bai dang 6 la 4, 3, 5 sao.Khi do bai dang 6 co diem trung binh danh gia la 4 diem/5 diem
   function Average_of_rating($conn, $post_id)
   {
   	  $sql = "select avg(num_of_star) from judge where post_id = $post_id";
   	  $result = $conn->query($sql);
   	  if(!$result)
   	  {
   	  	trigger_error("Co loi xay ra khi tinh diem tb danh gia: ".$conn->error."</br>");
   	  	return -1;
   	  }else{
   	  	$row = $result->fetch_row();
   	  	return $row[0];
   	  } 
   }

   //Ham thay doi gia tri sao(danh gia) bai dang, vi du: Khi A danh gia bai dang do la 5 sao bay gio muon thay doi
   //thanh 4 sao thi ham nay se thay doi gia tri
   function Update_rate($conn, $post_id, $user_id, $val)
   {
   		$sql = "update judge set num_of_star = $val where user_id = $user_id and post_id = $post_id";
   		$result = $conn->query($sql);
   	   if(!$result)
   	   {
   	  	  trigger_error("Co loi khi tinh thay doi diem danh gia: ".$conn->error."</br>");
   	  	  return false;
   	   }else{
   	   	  return true;
   	   } 
   }
   
?>