<?php
    session_start();
	include_once 'C:\xampp\htdocs\BaiTapLonPtUdW\Model\model.php';
	$conn = "";
	Connect($conn);

    $id_user = $_SESSION['id'];
    $pass_user =  $_SESSION['pass'];

    function information_user(){
    	return convert_id_to_info1($GLOBALS['conn'], $GLOBALS['id_user']);
    } 	
    
    //ham kiem tra co phai quan tri vien hay khong
    function Admin()
    {
        return is_admin($GLOBALS['conn'], $GLOBALS['id_user'], $GLOBALS['pass_user']);
    }

    //ham nay se tra ve thoi gian da thong bao va thoi gian hien tai
    function Change_date($Date)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $second = abs(time() - strtotime($Date));//thoi gian hien tai va thoi gian da dang
        if($second < 60)                                   return "Vừa xong";
        else if( $second > 60 && $second < 3600)           return (int)($second/60)." Phút trước";
        else if($second >= 3600 && $second < 86400)        return "Khoảng ".(int)($second/3600)." Tiếng trước"; 
        else if($second >= 86400 && $second < 2592000)     return (int)($second/86400)." Ngày trước"; 
        else if($second >= 2592000 && $second < 946080000) return (int)($second/2592000)." Tháng trước";
        else                                               return "Rất rất lâu.";                                    
    }

    //Ham tra ve so thu tu lon nhat trong bang comments de xoa binh luan cua nguoi dung
    function Max_collumn($tbname, $collumn)
    {
        return Position_max_cmt($GLOBALS['conn'], $tbname, $collumn);
    }

    //ham tra ve thong tin ca nhan cua mot nguoi trong csdl bao gom thong tin chinh thuc(trong truong hoc va thong tin trong website), ham nay tra ve thong tin ca nhan that su cua nguoi dung

    function information_real_user($user_id)
    {
    	return Show_csdl_user($GLOBALS['conn'], 1, "select * from infor_users where id = '$user_id'");
    }

    //Thay doi ten, anh dai dien hay dia chi mail
    function Change_infor($table, $collumn, $collumn1, $value, $value_new)
    {
    	Update_table_any($GLOBALS['conn'], $table, $collumn, $collumn1, $value, $value_new);
    }

    //Ham dem so ban ghi bang so anh dai dien nguoi dung da dang trong csdl
    function Count_length_avatars()
    {
        $id = $GLOBALS['id_user'];
        return Length_table($GLOBALS['conn'], "user_avatar", "select * from user_avatar where user_id = '$id'");
    }

    //ham dem so luong ban ghi la cac bai dang nguoi dung do da dang
    function Count_length_post()
    {
        $id = $GLOBALS['id_user'];
        return Length_table($GLOBALS['conn'], "posts", "select * from posts where user_id = '$id'");
    }

    //ham lay du lieu anh tư csdl de hien thi cac anh da dang cua nguoi dung
    //chi cho phep nguoi dung dang 10 anh
    function Show_image()
    {
        return Show_user_avatar($GLOBALS['conn'],  "user_id", $GLOBALS['id_user']);
    }

    //ham tra ve du lieu trong php voi 2 dieu kien
    function Return_val($table, $choose, $collumn, $collumn1, $value, $value1)
    {
        return Choose_any_value($GLOBALS['conn'], $table, $choose, $collumn, $collumn1, $value, $value1);
    }

    function Return_val1($table, $choose, $collumn,$value)// 1 dieu kien
    {
         return Choose_any_value($GLOBALS['conn'], $table, $choose, $collumn, "", $value, "");
    }

    //ham thay doi ten, tuoi...
    if(isset($_POST['Change_Infor']) && isset($_POST['know_val']))
    {
    	if((int)$_POST['know_val'] == 0){//ten
    		Update_table_any($GLOBALS['conn'], "users", "fullname", "user_id", $id_user, $_POST['Change_Infor']);
    	}else if((int)$_POST['know_val'] == 3){//vnumail
    		Update_table_any($GLOBALS['conn'], "users", "vnumail", "user_id", $id_user, $_POST['Change_Infor']);
    	}else if((int)$_POST['know_val'] == 2){//mat khau
    		Update_table_any($GLOBALS['conn'], "users", "pass", "user_id", $id_user, md5($_POST['Change_Infor']));
            $GLOBALS['pass_user'] = md5($_POST['Change_Infor']);
    	}

    	echo "Thanh cong nhe";
    }

    //ham cap nhat anh dai dien
    if(isset($_FILES["files"]["name"]))
    {
        $name_of_file = $_FILES["files"]["name"];
        $folder = "../Datauser/".$id_user;//tao folder tren server chua du lieu cua nguoi dung
        if(!is_dir($folder)){
            mkdir($folder);
        }
        $folder = $folder."/avatar";//tao folder chua anh dai dien cua nguoi dung
        if(!is_dir($folder)){
            mkdir($folder);
        }
        
        //upload file vao folder va tao duong dan tren server
        $file_path =  $_FILES["files"]["tmp_name"];
        $folder = $folder."/".$name_of_file;
        $file_size = (int)$_FILES["files"]["size"];

        if(move_uploaded_file($file_path, $folder)){
            if($file_size < 30720000 && Count_length_avatars() < 10){//kich thuoc anh khong vuot qua 3M va so luong anh dai dien khong vuot qua 10
                Change_infor("users", "avatar", "user_id" , $id_user, $folder);
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $date_create = date('Y-m-d H:i:s', time());
                Insert_user_avatar($GLOBALS['conn'], $id_user, $folder, $date_create);
            }
         }else{
            $_SESSION["loi cap nhat csdl"] = "Kich thuoc file anh vuot qua 3M hoac ban da dang qua 10 anh dai dien, vui long xoa bot. Vui long thu lai";
         }
         echo"<meta http-equiv='refresh' content='0;url=http://localhost/BaiTapLonPtUdW/view/examples/Profile.php'>";
    }

    if(isset($_POST['primary_id']) && isset($_POST['del_or_upd']))
    {
        $primary_id = $_POST['primary_id'];//thoi gian
        $link_file =  Return_val("user_avatar", "avatar", "user_id", "date_create", $id_user, $primary_id);
        if($_POST['del_or_upd'] == 0){//update image
            Change_infor("users", "avatar", "user_id" , $id_user, $link_file);
            echo 0;
        }else//delete image
        {
            Delete_record($GLOBALS['conn'], $primary_id, "user_avatar" , "date_create");//xoa trong csdl
            unlink($link_file);//xoa file trong folder
        }
    }

?>