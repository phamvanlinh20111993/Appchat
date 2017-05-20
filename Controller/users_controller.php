<?php
  	session_start();
  //  include_once dirname(__FILE__).'..\Model\model.php';
    include_once 'C:\xampp\htdocs\BaiTapLonPtUdW\Model\model.php';
  	$conn = "";
	Connect($conn);

    $id_user = $_SESSION['id'];
    $pass_user =  $_SESSION['pass'];
  //  mysqli_query($conn, 'SET character_set_results=utf8');
  //  mysqli_query($conn, 'SET NAMES utf8');

    //ham nay se tra ve thoi gian da thong bao va thoi gian hien tai
    function Change_date($Date)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $second = abs(time() - strtotime($Date));//thoi gian hien tai va thoi gian da dang
        if($second < 60)                                   return "Vừa xong";
        else if($second > 60 && $second < 3600)           return (int)($second/60)." Phút trước";
        else if($second >= 3600 && $second < 86400)        return "Khoảng ".(int)($second/3600)." Tiếng trước"; 
        else if($second >= 86400 && $second < 2592000)     return (int)($second/86400)." Ngày trước"; 
        else if($second >= 2592000 && $second < 946080000) return (int)($second/2592000)." Tháng trước";
        else                                               return "Rất rất lâu.";                                    
    }

  // ham cho phep nguoi dung online voi mot thoi gian xac dinh
    function Online_minute($time_set)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $on_time = strtotime(date('Y-m-d H:i:s', time()));//xem thoi gian hien tai de doi chieu
        $time_arr = array();
        $time_arr = Do_you_online($GLOBALS['conn']);//tra ma so nguoi dung voi timestamp-nguoi dung dang nhap
        $lenght_time = count($time_arr);
        $pos = 0;

        for($pos = 0; $pos < $lenght_time; $pos++){
           $time_go = 0;
           foreach ($time_arr[$pos] as $key => $value) 
           {
              if($key == "time"){
                $time_go = strtotime((string)$value);
              }
              if($key == "user_id"){
                if((int)$on_time - $time_go > $time_set){
                 if($value != $GLOBALS['id_user']) User_offline($GLOBALS['conn'], $value);
                 if($value == $GLOBALS['id_user']&&!is_admin($GLOBALS['conn'],$GLOBALS['id_user'],$GLOBALS['pass_user']))
                 {
                    echo"<script>alert('Bạn đã hết thời gian online, vui lòng đăng nhập lại !!!".date('Y-m-d H:i:s', time())."');</script>";
                    session_destroy();
                    header("Refresh:0;");
                }
              }
            }
          }
        }
    }

    //ham kiem tra nguoi dung co phai quan tri vien hay khong
    function You_are_ad()
    {
        if(is_admin($GLOBALS['conn'], $GLOBALS['id_user'], $GLOBALS['pass_user'])) return true;
        return false;
    }

    //ham lay du lieu ma thong bao loi khi nguoi dung dang bai loi
    function Take_er($uid)
    {
        return Select_error_post($GLOBALS['conn'], $uid);
    }

    //chuyen doi ma sinh vien thanh thong tin như tên, lớp...
    function information_user()
    {
       return convert_id_to_info1($GLOBALS['conn'], $GLOBALS['id_user']);
    }

    //danh sach chu de trong csdl
    function Topic()
    {
        return Show_topic($GLOBALS['conn'], "select * from topic", 0);
    }

    //hien thi sanh sach nguoi Online
    function List_on_of_line()
    {
        return Show_user_on_ofline($GLOBALS['conn'], 10, 1, $GLOBALS['id_user']);
    }

    //ham tra ve mot so ngau nhien de dat ten floder trong folder nguoi dung
    function Creat_random($id_user)
    {
        $datetime = new DateTime();
        return $datetime->getTimestamp().rand(1, 1000);
    }

    //hien thi bai dang
    function Show_post_to_user($pos_start, $pos_end, $collumn, $condition)
    {
        return Show_post($GLOBALS['conn'], $pos_start, $pos_end, $collumn, $condition);//hien thi 10 bai dang
    }

    //ham hien thi binh luan
    function Show_comment_to_user($post_id, $num, $post_start)
    {
        return Show_comment($GLOBALS['conn'], $post_id, $num, $post_start);
    }

    //hàm trả về trạng thái like bài viết của người dùng
    function Show_status_like($post_id, $id_user)//id_user la ma sinh vien cua chinh nguoi dung do
    {
        if(Show_likepost($GLOBALS['conn'], $post_id, $id_user) == 0) return false;// chua like bai dang nay
        else return true;// da like bai dang nay
    }

    //ham tra ve so luong nguoi da like, danh gia bai dang
    function Count_like_or_rating($value, $post_id)
    {
        if($value == 0){//bang thich bai dang(likepost)
            return Count_record($GLOBALS['conn'], "likepost", "post_id", $post_id);
        }else{//bang danh gia cua nguoi dung(judge)
            return Count_record($GLOBALS['conn'], "judge", "post_id", $post_id);
        }
    } 
    
    //ham tra ve gia tri danh gia bai viet voi ma bai dang cho truoc
    function Value_of_rating_by_user($post_id)
    {

        $val = value_of_user_rating($GLOBALS['conn'], $post_id, $GLOBALS['id_user']);
        if($val == - 1);//chua danh gia
        else if($val == "") return 0;
        else return $val;//da danh gia
    }

    //ham tra ve diem trung binh danh gia cua nguoi dung voi ma bai dang xac dinh
    function avg_rating($post_id)
    {
        $tam = Average_of_rating($GLOBALS['conn'], $post_id);
        if(!$tam) return 0;
        else  return number_format((float)$tam, 2, '.', '');//ma tron 2 so dau dau phay thap phan
    }

    //ham ra ve so nguoi da binh luan bai dang
    function Count_comment($post_id)
    {
        return Count_record($GLOBALS['conn'], "comments", "post_id", $post_id);
    }

    //Ham tra ve so thu tu lon nhat trong bang comments de xoa binh luan cua nguoi dung
    function Max_collumn($tbname, $collumn)
    {
        return Position_max_cmt($GLOBALS['conn'], $tbname, $collumn);
    }

    //ham xoa thong bao trong er, khi nguoi dung da nhan duoc thong bao
    function Del_record($id, $table_name, $table_collumn)
    {
        Delete_record($GLOBALS['conn'], $id, $table_name, $table_collumn);
    }

    //ham giup insert du lieu vao trong bang report de luu tru thong bao loi
    function Insert_report_controller ($id_u_send, $id_post, $content)
    {
        Insert_report($GLOBALS['conn'], $id_u_send, $id_post, $content);
    }

    //Ham tra ve danh sach nhung nguoi da like va rate
    function infor_user_like_rate($post_id)
    {
        $information_user_arr = array();
        $arr_like = array();
        $arr_rate = array();

        $arr_like =  Infor_users_like($GLOBALS['conn'], $post_id);
        $arr_rate = Infor_users_rating($GLOBALS['conn'], $post_id);

        $num_of_array_like = count($arr_like);
        $num_of_array_rate = count($arr_rate);
        $in = 0;
        for($in = 0; $in < $num_of_array_like; $in++){
            foreach ($arr_like[$in] as $key => $value){
                if($key == "user_id")   $information_user_arr[$in]["user_id"] = $value;//ma nguoi dung
                else if($key == "name") $information_user_arr[$in]["name"] = $value;//ten day du
                else if($key == "avt")  $information_user_arr[$in]["avatar"] = $value;//anh dai dien
                else                    $information_user_arr[$in]["mail"] = $value;//vnu mail
            }
            $information_user_arr[$in]["star"] = 0;
        }
        $in = $num_of_array_like;
        for($in1 = 0; $in1 <  $num_of_array_rate; $in1++){

            foreach ($arr_rate[$in1] as $key => $value){
                if($key == "user_id")    $information_user_arr[$in]["user_id"] = $value;
                else if($key == "name")  $information_user_arr[$in]["name"] = $value;
                else if($key == "avt")   $information_user_arr[$in]["avatar"] = $value;
                else if($key == "star")  $information_user_arr[$in]["star"] = $value;//diem danh gia
                else                     $information_user_arr[$in]["mail"] = $value;
            }
            $in++;
        }

        return $information_user_arr;
    }

    //ham tra ve du lieu trong php voi 1 dieu kien
    function Return_val1($table, $choose, $collumn,$value)// 1 dieu kien
    {
         return Choose_any_value($GLOBALS['conn'], $table, $choose, $collumn, "", $value, "");
    }

  	//thuc hien chuc nang dang xuat cua nguoi dung
  	if(isset($_POST['logout'])){
        session_destroy();
        User_offline($conn, $id_user);

        echo"ok";
  	}

    //truy van csdl de biet thong tin nguoi dung co ai online
    if(isset($_POST['request']))
    {
        $list = Array();
        $list = List_on_of_line();
        echo json_encode($list);
    }

    //ham submit form tu hompage, dang bai viet-upload tai lieu
    if(isset($_POST['binhluan']))
    {
         $chude = $_POST['chude'];
         $binhluan = $_POST['binhluan'];
         $file_folder = Creat_random($GLOBALS['id_user']);//tao ten folder chua file nguoi dung uplen
         $folder = "../Datauser/".$id_user;
         //tao 1 folder co ten la masv tren server chua cac file do chinh nguoi dung do dang len
         if(!is_dir($folder)){
            mkdir($folder,0777, true);
         }
         //tao folder chua file nguoi dung
         mkdir($folder."/".$file_folder, 0777, true);
         $file_name = $_FILES["tep"]["name"];
         $file_path = $_FILES["tep"]["tmp_name"];
         $file_size = (int)$_FILES["tep"]["size"];
         $file_type = $_FILES["tep"]["type"];

         $path = $folder."/".$file_folder."/".$file_name;
         echo $path;
         if(move_uploaded_file($file_path, $path) || $file_size > 51200000){
           post_post($conn, $path, $binhluan, $id_user, $chude, $file_name);
         }else{
            $_SESSION["uploaded_file"] = "Xay ra loi trong qua trinh upload file, hoac kich thuoc file vuot qua 50M. Vui long thu lai";
         }

        //page home se submit form toi controller, ham header dieu huong ve trang cu
         header("Location: ../view/examples/home_page.php"); 
    }

    //nhan gia tri binh luan cua nguoi dung gui len databse
    if(isset($_POST["mabaidang"]) && isset($_POST["idnguoidung"]) && 
        isset($_POST["thoigianbl"]) && isset($_POST["noidung"]))
    {
        $mabaidang = $_POST["mabaidang"];
        $idnguoidung = $_POST["idnguoidung"];
        $thoigianbl = $_POST["thoigianbl"];
        $noidung = $_POST["noidung"];

        if(post_comment($GLOBALS['conn'], $idnguoidung, $mabaidang, $thoigianbl, $noidung)){
            echo"Thanh cong";
        }else{
            echo"Xay ra loi roi";
        }
    }

    //nhan gia tri like bai viet cua nguoi dung gui len database
    if(isset($_POST["mabaidang_thich"]) && isset($_POST["manguoidung_thich"]) && isset($_POST["giatri01"]))
    {
        $mabd = $_POST["mabaidang_thich"];
        $mangd = $_POST["manguoidung_thich"];
        $giatri01 = $_POST["giatri01"];
        if($giatri01 == 0)//nguoi dung thich bai dang
        {
            To_Add_like($GLOBALS['conn'], $mabd, $mangd);
        }else{//nguoi dung bo thich bai dang
            To_leave_like($GLOBALS['conn'], $mabd, $mangd);
        }
    }

    //nhan gia tri danh gia bai dang cua nguoi dung gui len server
    if(isset($_POST["mabaidang_danhgia"]) && isset($_POST["manguoidung_danhgia"]) && isset($_POST["giatri12345"]))
    {
        $mabd1 = $_POST["mabaidang_danhgia"];
        $mangd1 = $_POST["manguoidung_danhgia"];
        $giatri12345 = $_POST["giatri12345"];
        if($giatri12345 != 0)//nguoi dung bo danh gia bai dang thi so sao la 0
        {
            if(!Show_rate($GLOBALS['conn'], $mabd1, $mangd1)){//neu nguoi dung da danh gia diem roi
                To_Add_rating($GLOBALS['conn'], $mabd1, $mangd1, $giatri12345);
            }else{
                Update_rate($GLOBALS['conn'], $mabd1, $mangd1, $giatri12345);
            }
        }else{
            //nguoi dung bo danh gia bai dang
            To_leave_rating($GLOBALS['conn'], $mabd1, $mangd1);
        }
    }

    //khi nguoi dung muon xem them bai dang, hien thi bai dang trong trang ca nhan, hien thi co dieu kien
    if(isset($_POST['see_more_post']) && isset($_POST['user_id_to_show']) && isset($_POST['recognize_val']))
    {
          $recognize_val = $_POST['recognize_val'];//lay gia tri de hien thi theo chu de hay gi do
      //  $_SESSION["Show_more_posts123"] += 10; //cach so 1 hien thi them binh luan
          $mores_posts = array();
          if($_POST['user_id_to_show'] != ""){ // tim kiem theo ma so sinh vien, hien thi trong trang ca nhan cua chinh nguoi do
             $condition = $_POST['user_id_to_show'];
             $more_posts = Show_post_to_user(0, 15, "p.user_id", (int)$condition);//hien thi thong tin 5 bai dang
          }else if($_POST['recognize_val'] != 0 || $_POST['recognize_val'] != ""){//tim kiem theo gia tri khi nguoi dung tim kiem
             $condition = $_POST['recognize_val'];
             if(is_numeric($condition)){
                $more_posts = Show_post_to_user(0, 10, " p.user_id", (int)$condition);
             }else{

                $more_posts = Show_post_to_user(0, 10, "t.name_topic", $condition);
             }
          }
          $num_num_num_post = count($more_posts);
        //Show_more_post(id_post, id_user, avatar, name, time, average_rate, topic, content_post, link, file_name, status_like, num_of_like, num_of_judge, value_of_judge, avatar_you)
          //cac bien con thieu la 
          $in = 0;
          for($in = 0; $in < $num_num_num_post; $in++){

            foreach ($more_posts[$in] as $key => $value){
                if($key == "post_id")
                {
                    if(Show_status_like($value, $id_user)) $more_posts[$in]["status_like"] = 1;
                    else $more_posts[$in]["status_like"] = 0;

                    $value_of_judge = Value_of_rating_by_user($value);
                    $more_posts[$in]["value_of_judge"] = $value_of_judge;

                    $num_of_judge = Count_like_or_rating(1, $value);//so luong nguoi danh gia
                    $num_of_like = Count_like_or_rating(0, $value);//so luong nguoi thich
                    $more_posts[$in]["num_of_judge"] = $num_of_judge;
                    $more_posts[$in]["num_of_like"] = $num_of_like;

                    $average_rate = avg_rating($value);
                    $more_posts[$in]["average_rate"] = $average_rate;
                }

            }
          }

          echo json_encode($more_posts);
    }

   //nguoi dung muon xem them binh luan 
    if(isset($_POST['Show_more_comments']) && isset($_POST['soluongbinhluan']) && isset($_POST['mabaidang1']))
    {
        $php_or_js = $_POST['giatriphpjs'];//gia tri nhan la 0 hoac 1, gia tri 1 tuc la hien thi mac dinh, con gia tri 0 la nguoi dung muon xem them binh luan
        $soluongbl = $_POST['soluongbinhluan'];
        $mabaidang1 = $_POST['mabaidang1'];
        $tongsobl = Count_comment($mabaidang1);
        $more_cmt = array();
        if((int)$php_or_js == 1) $more_cmt = Show_comment_to_user($mabaidang1, $soluongbl, 0);//mac dinh hien thi
        else  $more_cmt = Show_comment_to_user($mabaidang1, $soluongbl, 8);//lay 8 bl bat dau tu vi tri so 8
        echo json_encode($more_cmt);
    }

    //nguoi dung muon xoa binh luan cua minh.vd: cmt noi dung phan cam hay gi do :v
    if(isset($_POST['del_cmt_id_post']) && isset($_POST['del_cmt_id_cmt']))
    {
        $del_cmt_id_post = $_POST['del_cmt_id_post'];
        $del_cmt_id_cmt = $_POST['del_cmt_id_cmt'];
        if(Delete_comment($GLOBALS['conn'], $del_cmt_id_cmt, $del_cmt_id_post)){
            echo"Thanh cong";
        }else{
            echo"Loi roi";
        }
    }

    //Nguoi dung yeu cau xem chi tiet ai da like bai dang va ai da thich bai dang
    if(isset($_POST["postcode_infor_user_like_rating"]))
    {
        $post_id_user = $_POST["postcode_infor_user_like_rating"];
        $information_user_like_rate = array();
        $information_user_like_rate = infor_user_like_rate($post_id_user);
        echo json_encode($information_user_like_rate);
    }

    //lay thong bao loi cua admin cho nguoi dung
    if(isset($_POST["request_er"]) && isset($_POST["uid"])){
        $uid = $_POST["uid"];
        $list_er = Take_er($uid);//day la mot mang danh sach loi
        echo json_encode($list_er);
    }

    //Xoa thong bao loi khi nguoi dung da xem
    if(isset($_POST["request_user_seen_err"]) && isset($_POST['ma_loi_server']))
    {
        $id_in_er = $_POST['ma_loi_server'];
        Del_record($id_in_er, "er", "id_er");
        echo $id_in_er;
    }

    //nguoi dung muon xoa bai dang cua chinh minh
    if(isset($_POST["banxoabaidang_mabd"])){
        $id_post_uers = $_POST["banxoabaidang_mabd"];
        $dg = Return_val1("posts", "link", "post_id", $_POST["banxoabaidang_mabd"]);//lay link file xoa trong bo nho server
        //tien hanh lay ten cua file da dang va xoa
        $dodai =  strlen($dg);
        $pos = 0;
        for($i = 0; $i < $dodai; $i++){
            if($dg[$i] == "/"){
                $pos++;
            }
            if($pos == 3){
                $link = substr($dg, 0, $i + 1);
            }
        }
        //xoa folder chua file da dang cua nguoi dung
        unlink($dg);//xoa file trong folder
        if(!rmdir($link)){//xoa folder trong(khong co file nao nua)
            echo "Khong the xoa bai dang.";
        }
        Del_record($id_post_uers, "posts", "post_id");//xoa trong csdl
    }

    //ham nhan cac phan hoi cua nguoi dung khi bao cao bai dang
    if(isset($_POST["Report_postid"]) && isset($_POST["Report_userid"]) && isset($_POST["Report_content"])){
        $mabaidang = $_POST["Report_postid"];
        $mangd = $_POST["Report_userid"];
        $noidung = $_POST["Report_content"];
        Insert_report_controller($mangd, $mabaidang, $noidung);
       // echo $mabaidang.$mangd.$noidung;
    }

?>