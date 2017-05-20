<?php
      $conn = new mysqli("localhost", "root", "");
	  if(!$conn){
		  echo"khong the ket noi CSDL: ".$conn->connect_error."</br>";
	  }else{
		  if($conn->select_db("project1")){
			  
		  }else{
			  $sql = "create database project1";
			  if(!$conn->query($sql)){
                   echo"Loi tao CSDL: ".$conn->mysqli_error."</br>"; 
              }
		  }
	  }
	  
	  $conn = new mysqli("localhost", "root", "", "project1");
	  //tao table infor_users
	  if(!$conn->query("describe infor_users")){
        $sql = "create table infor_users(id int(8) unsigned not null primary key, name varchar(100) not null,"
		."dateofbirth date not null, class varchar(50) )engine = innoDB default charset = utf8";
            
        if($conn->query($sql)){
            echo "Tao bang infor_ users thanh cong.</br>";
            $sql = null;
        }else{
            echo"Loi tao bang infor_users ".$conn->error."</br>";
        }
      }

      //tao table er chua loi ma nguoi dung gap phai trong qua trinh dang bai
       if(!$conn->query("describe er")){
        $sql = "create table er(id_er int(8) unsigned primary key not null, uid int(8) unsigned not null, pid bigint(20) not null,"
        ."time varchar(200), topic varchar(200), code_er varchar(10), constraint er_users foreign key(uid) references users(user_id) on update cascade on delete cascade)engine = innoDB default charset = utf8";
            
        if($conn->query($sql)){
            echo "Tao bang er thanh cong.</br>";
            $sql = null;
        }else{
            echo"Loi tao bang er ".$conn->error."</br>";
        }
      }
	  
	   //tao table topic cho phep nguoi dung chon chu de de dang bai
	  if(!$conn->query("describe topic")){
        $sql = "create table topic(topic_id char(5) primary key not null, name_topic varchar(50) not null)engine = innoDB default charset = utf8";
            
        if($conn->query($sql)){
            echo "Tao bang topic thanh cong.</br>";
            $sql = null;
        }else{
            echo"Loi tao bang topic: ".$conn->error."</br>";
        }
      }
	  
	  //tao table users luu tru thong tin nguoi dung
	  if(!$conn->query("describe users")){
        $sql = "create table users(user_id int(8) unsigned primary key not null, timeout timestamp, pass varchar(100) not null, online int(2), "
		 ."fullname varchar(100) not null, vnumail char(50) not null, date_create datetime not null, avatar varchar(200), constraint user_user foreign key(user_id) references infor_users(id) on update cascade on delete cascade)".
		 ."engine = innoDB default charset = utf8";
            
        if($conn->query($sql)){
            echo "Tao bang users thanh cong.</br>";
            $sql = null;
            $pass = "55555";//mat khau admin mac dinh la 55555
            $pass = md5((int)$pass);
            $sql10 = "INSERT into users(user_id, pass, fullname, vnumail, avatar, Admin)values('14020822', '$pass', 'Pham Van Linh Dep Trai', '14020822@vnu.edu.vn', '../Datasystem/logo.png', '1')";//tao admin
            if(!$conn->query($sql10)){
                echo"Khong the tao tai khoan admin do: ".$conn->error."</br>";
            }
        }else{
            echo"Loi tao bang users: ".$conn->error."</br>";
        }
      }
	  
	  //tao table cac bai dang cua nguoi dung
	  if(!$conn->query("describe posts")){
        $sql = "create table posts(post_id bigint unsigned auto_increment primary key not null, name_of_file varchar(300) not null, post_time datetime not null, link varchar(200) not null, notice varchar(1000), ".
		 "user_id int(8) unsigned not null, topic_id char(5) not null, notification int(1) not null, ".
		 "constraint post_user foreign key (user_id) references users(user_id) on update cascade on delete cascade, constraint post_topic foreign key (topic_id) ".
		 " references topic(topic_id) on update cascade on delete cascade) engine = innoDB default charset = utf8";
            
        if($conn->query($sql)){
            echo "Tao bang posts thanh cong.</br>";
            $sql = null;
        }else{
            echo"Loi tao bang posts: ".$conn->error."</br>";
        }
      }

      //tao table nhan phan hoi bai dang cua nguoi dung
      if(!$conn->query("describe report")){
        $sql = "create table report(id_report int(8) unsigned auto_increment primary key not null, id_u_send int(8) unsigned not null, id_post bigint(20) unsigned not null, content varchar(1000) not null, Date datetime not null, constraint report_user foreign key(id_u_send) references users(user_id) on update cascade on delete cascade, constraint report_post foreign key (id_post) references posts(post_id) on update cascade on delete cascade) engine = innoDB default charset = utf8";
        if($conn->query($sql)){
            echo "Tao bang report thanh cong.</br>";
            $sql = null;
        }else{
            echo"Loi tao bang report: ".$conn->error."</br>";
        }
      }
	  
	  //tao bang chua danh sach anh dai dien da dang
	  if(!$conn->query("describe user_avatar")){
        $sql = "create table report(user_id int(8) unsigned not null, avatar varchar(400) not null, date_create datetime not null, constraint user_id_avatar foreign key(user_id) references users(user_id) on update cascade on delete cascade) engine = innoDB default charset = utf8";
        if($conn->query($sql)){
            echo "Tao bang user_avatar thanh cong.</br>";
            $sql = null;
        }else{
            echo"Loi tao bang user_id: ".$conn->error."</br>";
        }
      }
	  
	  //tao table thich bai dang
	  if(!$conn->query("describe likepost")){
        $sql = "create table likepost(user_id int(8) unsigned not null, post_id bigint unsigned not null, constraint likepost_user foreign key (user_id)".
		 " references users(user_id) on update cascade on delete cascade, constraint likepost_post foreign key (post_id) ".
		 " references posts(post_id) on update cascade on delete cascade) engine = innoDB default charset = utf8";
            
        if($conn->query($sql)){
            echo "Tao bang likepost thanh cong.</br>";
            $sql = null;
        }else{
            echo"Loi tao bang likepost: ".$conn->error."</br>";
        }
      }
	  //tao table comments chua cac binh luan bai dang cua nguoi dung
	  if(!$conn->query("describe comments")){
        $sql = "create table comments(id_cmt bigint(20) unsigned auto_increment primary not null, user_id int(8) unsigned not null, post_id bigint(20) unsigned not null, comment_time datetime not null, ".
		 "content varchar(1000) not null, constraint comment_user foreign key(user_id) references users(user_id) on update cascade".
		 " on delete cascade, constraint comment_post foreign key (post_id) references posts(post_id) ".
		 "on update cascade on delete cascade)engine = innoDB default charset = utf8";
            
        if($conn->query($sql)){
            echo "Tao bang comments thanh cong.</br>";
            $sql = null;
        }else{
            echo"Loi tao bang comments: ".$conn->error."</br>";
        }
      }
	  //tao table judge de danh gia bai dang cua nguoi dung, co 5 sao tuong ung 5 muc danh gia
	  if(!$conn->query("describe judge")){
        $sql = "create table judge(user_id int(8) unsigned not null, post_id bigint unsigned not null, num_of_star int(1) unsigned, ".
		 "constraint judge_user foreign key (user_id) references users(user_id) on update cascade on delete cascade, ".
		 "constraint judge_post foreign key (post_id) references posts(post_id) on update cascade on delete cascade)engine = innoDB default charset = utf8";
        
        if($conn->query($sql)){
            echo "Tao bang judge thanh cong.</br>";
            $sql = null;
        }else{
            echo"Loi tao bang judge: ".$conn->error."</br>";
        }
      }
	  
	  mysqli_close($conn);
?>