 
          //ham quan tri bai dang , cam dang bai, noi tuc trong bai dang(kiem soat bai dang, noi dung)

          function Control_post_comment(string)
          {
             var obscene = ["địt", "dit", "đit", "lồn", "lon", "lòn", "lôn", "lon'", "chịch", "chich", "buồi", "buoi", "buôi", "fuck", "bitch", "bop vu", "bop vú", "bóp vu", "bóp vú", "vcl", "đm", "dm", "ngu", "đít","lỗ l", "cl", "liem chim", "liếm chim", "blow job", "mút cu", "cặc", "căc", "vl", "con cac"];
             var index, True = false;
             for(index = 0; index < obscene.length; index++){
                if(string.search(obscene[index]) != -1){
                  True = true;
                  break;
                }
             }

             return True;
          }


          //ham xoa bai dang
          function del_post_by_yourself(id_post)
          {
            var yesno = confirm("Bạn chắc chắn muốn xóa bài đăng này cuả chính bạn ???");
            if(yesno == true){
               document.getElementById(id_post).style.display = "none";

               $.ajax({
                  type: "POST",
                  url: "../../Controller/users_controller.php",
                  data: {banxoabaidang_mabd: id_post},
                  success: function (data){
                   //  $("#kt").html(data);
                  }
               });
            }
          }

          //ham bao cao van de doi voi bai dang
          function Report_problem(name, topic, namefile, post_id, uid)
          {
             $("#myModal1").modal("show");
             var Div, listsp, Input;

             document.getElementById("tieudemodal").innerHTML += '<label style="color:#59CB86;" data-toggle="tooltip" data-placement="bottom" title="'+uid+'"><i>'+name+'</label></a>';
             Div = document.getElementById("phanhoivebaidang");
             listp = Div.getElementsByTagName("p");
             Input = Div.getElementsByTagName("input");

             Input[0].value = post_id;//lay gia tri vao in put type hidden in modal
             listp[0].innerHTML += "<b style='font-size:110%;'>"+topic+"</b>";
             listp[1].innerHTML += "<b style='font-size:110%;'>"+namefile+"</b>";
          }

          //Ham gui gia tri (noi dung bao cao ve bai dang) len server
          function Report_problem_server()
          {
             var inp, post_id, report_ct, Div = document.getElementById("phanhoivebaidang");
             inp = Div.getElementsByTagName("input");
             post_id = inp[0].value;
             report_ct = document.getElementById("comments111").value;
             if( report_ct == "")
             {
                document.getElementById("canhbaoloi").style.display = "block";
             }else
             {
              $.ajax({
                type: "POST",
                url: "../../Controller/users_controller.php",
                data:{Report_postid: post_id, Report_userid: user_id, Report_content: report_ct},
                success: function(data){
                }
              });

              $('#myModal1').modal('toggle'); 
              setTimeout(function(){alert("Phản hồi của bạn đã được gửi đi. Cảm ơn sự đóng góp của bạn."); }, 2000);
             }
          }

          //dong modal lai thi modal tro lai trang thai ban dau
          function Close_modal()
          {
             var Div, listsp, Input;
             document.getElementById("tieudemodal").innerHTML = "Phản hồi bài đăng của ";
             Div = document.getElementById("phanhoivebaidang");
             listp = Div.getElementsByTagName("p");
             Input = Div.getElementsByTagName("input");
             listp[0].innerHTML = "Chủ đề: ";
             listp[1].innerHTML = "Tên file: ";
             document.getElementById("comments111").value = "";
             document.getElementById("canhbaoloi").style.display = "none";
          }

           //ham tra ve mot doan van ban thong bao loi da mac phai cua nguoi dung, hien thi cho nguoi dung
          function Err_wh(err_code, name, time, topic, pid)
          {

            switch(err_code)
            {
               case "110AB1":
                  text = "<p>Người đăng: "+name+" </p><p>Chủ đề: "+topic +"</p> <p>Thời gian: "+time+"</p><p> Mã bài đăng: " + pid+"</p><p>Lỗi gặp: Nội dung không phù hợp</p><p>Trạng thái: Đã xóa</p>";
                  break;
               case "110AB":
                  text = "<p>Người đăng: "+name+" </p><p>Chủ đề: "+topic +"</p> <p>Thời gian: "+time+"</p><p> Mã bài đăng: " + pid+"</p><p>Lỗi gặp: Bài đăng chứa chú thích hoặc bình luận dâm ô, phản động.</p><p>Trạng thái: Đã xóa</p>";
                  break;
               case "110AB2":
                  text = "<p>Người đăng: "+name+" </p><p>Chủ đề: "+topic +"</p> <p>Thời gian: "+time+"</p><p>Mã bài đăng: " + pid+"</p><p>Lỗi gặp: Phá hoại trang web</p><p>Trạng thái: Đã xóa</p>";
                  break;
               case "110AB3":
                  text = "<p>Người đăng: "+name+" </p><p>Chủ đề: "+topic +"</p> <p>Thời gian: "+time+"</p><p> Mã bài đăng: " + pid+"</p><p>Lỗi gặp: Chủ đề không phù hợp với file đã share</p><p>Trạng thái: Đã xóa</p>";
                  break;
               default:
                  text = "<p>Người đăng: "+name+" </p><p>Chủ đề: "+topic +"</p> <p>Thời gian: "+time+"</p><p> Mã bài đăng: " + pid+"</p><p>Lỗi gặp: Xảy ra sự cố hoặc lỗi của admin. Rất tiếc về bài đăng của bạn.</p><p>Trạng thái: Đã xóa</p>";
            }

            return text;
          }

          //ham hien thi loi chi tiet cua nguoi dung khi dang bai va bi server xoa bo
          function Show_er(id)
          {
             var lists_hidden, id_er, err_code, name, time, topic, pid;
             lists_hidden = document.querySelectorAll('input[type="hidden"][name="angiatriloi'+id+'"]');
             id_er = lists_hidden[0].value;//ma vi tri loi trong csdl
             name = lists_hidden[1].value;//ten nguoi dang
             err_code = lists_hidden[5].value;//ma loi nguoi dang gap phai
             topic = lists_hidden[4].value;//ten cua chu de
             pid = lists_hidden[2].value;//ma bai dang
             time = lists_hidden[3].value;//thoi gian da dang
             $("#myModal2").modal("show");
             document.getElementById("thongbaoxoabaidangtuquantrivien").innerHTML= Err_wh(err_code, name, time, topic, pid);
             $.ajax({
                  type: "POST",
                  url: "../../Controller/users_controller.php",
                  data: {request_user_seen_err:1, ma_loi_server: id_er},
                  success: function (data)
                  {
                    // $("#kt").html(data);
                  }
            });
          }

           //ham nay dung ajax để gửi lên server muốn xóa bình luận này....
            function Ajax_remove_cmt(post_id, id_cmt)
            {
                $.ajax({
                    type: "POST",
                    url : "../../Controller/users_controller.php",
                    data: {del_cmt_id_post: post_id, del_cmt_id_cmt: id_cmt},
                    success: function(data){
                     //  document.getElementById("kt").innerHTML = data;
                    }
                });
            }

            //hàm này sẽ xóa các bình luận của chính người dùng
            //ý tưởng:tại client, khi nguoi dùng tiến hành kick vao nut xoa ben duoi cmt cua chinh minh thi
            //tien hanh an binh luan do va gui tin hieu len server(dung ajax) xoa binh luan do cua nguoi dung.
            function Remove_cmt(post_id, pos)//pos la class
            {//de xoa 1 cmt thi can co thong tin ma bai dang, nguoi da cmt, thoi gian cmt, neu can thiet thi noi dung dang bai :v
                var take_id = - 1; 
                take_id = document.getElementsByClassName(pos);
             //gia tri nay dung de so sanh thoi gian cu the trong database
                take_id[0].style.display = "none";//an cmt doi voi nguoi dung
                Ajax_remove_cmt(post_id, take_id[1].value);
               // document.getElementById("kt").innerHTML = post_id+ " " + take_id[1].value;
            }

            //ham tra cau truc cua mot binh luan bao gom anh dai dien nguoi dang, thoi gian dang, noi dung binh luan
            function Create_comment(Avatar, name, dt, Value, post_id, id_cmt)//gia tri post_id la ma bai dang de biet comment thuoc bai dang nao
            {
                var ele, time, time1;
                time = dt.getHours() + ":" + dt.getMinutes() +", "+ dt.getDate()+ "/" + (dt.getMonth() + 1) + "/" + dt.getFullYear();//thoi gian dang bai, xu li ben client, hien ra dang gio:phut ngay/thang/nam

                ele = '<div style="min-height:40px;margin-top:5px;" class = '+num_click_hidden_cmt+'>';
                ele += '<img src="../'+Avatar+'" width="41" height="42" style="float:left;margin-left:10px;margin-top:-2px;">';
                ele += '<p style="width:85%;word-wrap:break-word;margin-left:56px;"><span style="color:blue;font-size:108%;">'+name+'</span>  '+Value;
                ele += '</p><div style="height:10px;margin-left:56px;font-size:82%;color:#474343;margin-top:-7px;">';
                ele += '<a class="a11" onclick="Remove_cmt('+post_id+', '+num_click_hidden_cmt+');">xóa</a><span style="margin-left:10px;">'+time+'</span></div>';
                ele += '<input type= "hidden" class= '+num_click_hidden_cmt+' value = '+id_cmt+'></div>';

                //An thoi gian trong datetime trong csdl, gia tri nay se dung de xoa binh luan, doi chieu voi csdl
                //hien thi cac binh luan trong database nhung ma javascript
                num_click_hidden_cmt++;
                return ele;
            }

            //ham tra ve xu li xu kien nguoi dung dang binh luan voi bai viet
            function UserComment(e, value_of_cmt, id_post, id_comment)
            {
                var temp, Value, dt = new Date();
                var Avatar, name;
                Avatar = information_user.avatar;//anh dai dien nguoi binh luan
                name = information_user.fullname;//ten nguoi binh luan

                if(e.keyCode == 13){
                    Value = value_of_cmt.value;//lay gia tri trong textarea
                    if(Value == ""){
                       return false;
                    }else{
                       time1 = dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate() + " " + dt.getHours() + ":" + dt.getMinutes() +":"+ dt.getSeconds();//thoi gian vao csdl(kieu datetime) 
                       temp = document.getElementById(id_post).querySelectorAll("[id^='"+id_comment+"']");//tra ve tat ca cac tag(p, h, div) co id bat dau la id_comment, trong 1 bai dang co 2 gia tri la id_comment, vay tem[1] se tra ve vi tri hien binh luan
                       if(Control_post_comment(Value)){
                          alert("Warning!!! Không được nói tục chửi bậy trên web");
                          value_of_cmt.value = "";
                       }else{
                        Post_comment_to_db(id_post, user_id, time1, Value);//gui du lieu tren database
                        value_of_cmt.value = "";
                        max_cmt_id++;//khi gui du lieu(comment) len server, gia tri id_cmt se tu dong tang len 1, va khi do, ben client cung co gia tri tang len 1 tuong ung voi server 
                        temp[0].innerHTML += Create_comment(Avatar, name, dt, Value, id_post, max_cmt_id) + '<br>'; 
                        return false;
                      }
                    }
                } 
            }

            //ham se hien cac binh luan cua nguoi dung tu truoc(trong database)
            function Show_comment_from_db(id_post, Avatar, name, time, Value, id_cmt, id_comment_client, val)
            {
                var avatar, cmt, time_show, time_to_client;
                cmt = document.getElementById(id_post).querySelectorAll("[id^='"+id_comment_client+"']");
               // document.getElementById("kt").innerHTML += typeof(id_post) + " ";
                time_show = new Date(time);//lay thoi gian bl trong database

                if(parseInt(val) == 1)
                {//dung php de hien thi binh luan
                    Avatar = String(Avatar);
                    avatar = Avatar.slice(1, Avatar.length - 1);
                    Value = String(Value).slice(1, Value.length - 1);//json_encode ben php, bo di dau "" trong string
                    cmt[0].innerHTML += Create_comment(avatar, name, time_show, Value, id_post, id_cmt) + '<br>';
                }else{//dung ajax de hien thi them binh luan
                    cmt[0].innerHTML += Create_comment(Avatar, name, time_show, Value, id_post, id_cmt) + '<br>';
                }
                  
            }

            //Ham tra ve Xem them binh luan vi co the co qua nhieu binh luan 
            function See_more_Comment(id_post, val_php_js)
            {  
               var count_click_see_more_cmt, val = 0, sp;
               sp = document.getElementById(id_post).querySelectorAll("[id^='changecmt']");
               count_click_see_more_cmt = parseInt(sp[2].value) + 1;//so lan click tang len 1
               sp[2].value = count_click_see_more_cmt;//input type hidden chua so lan click

               if(sp[1].value - 8 > 0) sp[0].innerHTML = (sp[1].value - 8);
               else sp[0].innerHTML = 0;

               val = parseInt(count_click_see_more_cmt)*8;

               if(sp[1].value > 0){
                  $.ajax({
                    type: "POST",
                    url: "../../Controller/users_controller.php",
                    data: {Show_more_comments: 1, soluongbinhluan: val, mabaidang1: id_post, giatriphpjs: val_php_js},
                    success: function(data)
                    {
                       var i, length, Ob, sp;
                       Ob = JSON.parse(data);
                       length = Object.keys(Ob).length;

                       for(i = 0; i < length; i++){
                         Show_comment_from_db(id_post, Ob[i].avt, Ob[i].name, Ob[i].time, Ob[i].content, Ob[i].id_cmt, 0, 0);
                       }
                    }
                  });
               }
               sp[1].value = sp[1].value - 8;//bot di 8 binh luan, chứa số lượng bl chưa hiện ra
                   
            }

            //ham se gui du lieu khi nguoi dung dang binh luan vao database de su dung ve sau
            function Post_comment_to_db(post_id, id_user, time, vl)
            {
               $.ajax({
                 type: "POST",
                 url: "../../Controller/users_controller.php",
                 data: {mabaidang: post_id, idnguoidung: id_user, thoigianbl: time, noidung: vl},
                 success: function(data){
                   // document.getElementById("kt").innerHTML = data;
                 }
               });
            }

           //ham nay se gui du lieu den server thong tin nguoi dung thich bai dang hay bo like bai dang
          //thong tin bao gom ma bai dang, 
            function Post_like_to_db(post_id, id_user, val)
            {
               $.ajax({
                 type: "POST",
                 url: "../../Controller/users_controller.php",
                 data: { mabaidang_thich: post_id, manguoidung_thich: id_user, giatri01: val},
                 success: function(data){
                   //  document.getElementById("kt").innerHTML = "da like";
                 }
               });

            }

           //ham gui du lieu danh gia bai dang toi nguoi dung
            function Post_rating_to_db(post_id, user_id, val)
            {
              $.ajax({
                type: "POST",
                url: "../../Controller/users_controller.php",
                data: { mabaidang_danhgia: post_id, manguoidung_danhgia: user_id, giatri12345: val},
                  success: function(data){
                  // document.getElementById("kt").innerHTML = "da danh gia";
                  }
              });
            }

            // Danh gia cua nguoi dung ve bai dang, value la lay gia tri cua chinh no
            // Bien mark_avg_rate de tinh diem danh gia voi diem trung binh hien tai va' so nguoi danh gia
            // va khi nguoi dung thay doi hay bo danh gia thi client thay doi truoc, server thay doi sau
            // Bien val_now_rate de thay doi trang thai hien tai. Vi du: khi nguoi dung chua danh
            // gia bai dang thi val_now_rate = 0 sau do danh gia, ham Rating duoc goi, khi do so nguoi danh gia tang len 1.con khi nguoi dung da danh gia toi, 
            // val_now_rate != 0, sau do bo danh gia thi ham Rating lai phai giam so nguoi danh gia di 1 
            function Rating(val_input_rating, post_id, id_user, num_of_rate, mark_avg_rate, val_now_rate)
            {
                var  num_of_star, cr_span, avg_rate_now = 0;
                num_of_star = val_input_rating.value;//nguoi dung danh gia tu 1 den 5 sao

                cr_span = document.getElementById(post_id).querySelectorAll("span");//client xu li su kien
                if(val_now_rate == 0)//chua nguoi dung nao danh gia, gia tri co dinh
                {
                  var temp = parseInt(mark_avg_rate*num_of_rate) + parseInt(num_of_star);
                  avg_rate_now = temp / parseInt(num_of_rate + 1);//them 1 nguoi danh gia
                 //  document.getElementById("kt").innerHTML = num_of_star;
                  cr_span[0].innerHTML = avg_rate_now.toFixed(2);//lay 2 chu so sau dau phay
                 // ham toFixed(2) lay 2 so sau dau phay
                 if(num_of_star != 0){
                    num_of_rate++;
                    cr_span[2].innerHTML = num_of_rate;//so nguoi danh gia tang len 1
                    document.getElementById("soluongdanhgia").innerHTML = "Bạn và "+(num_of_rate - 1)+" người khác đã đánh giá bài đăng này";
                 }else{
                   if(num_of_rate > 0)  num_of_rate--;
                   cr_span[2].innerHTML = num_of_rate;//so nguoi danh gia giam di 1
                   document.getElementById("soluongdanhgia").innerHTML = num_of_rate + " người đã đánh giá bài đăng này";
                 }
               }else
               {
                  avg_rate_now = (parseInt(mark_avg_rate)*parseInt(num_of_rate) - parseInt(val_now_rate) + parseInt(num_of_star))/num_of_rate;//them 1 nguoi danh gia
                  cr_span[0].innerHTML = avg_rate_now.toFixed(2);
                  if(num_of_star == 0){
                      num_of_rate--;
                      cr_span[2].innerHTML = num_of_rate;//so nguoi danh gia giam di 1
                      document.getElementById("soluongdanhgia").innerHTML = num_of_rate + " người đã đánh giá bài đăng này";
                  }else{
                      cr_span[2].innerHTML = num_of_rate;//so nguoi danh gia tang len 1
                      document.getElementById("soluongdanhgia").innerHTML = "Bạn và "+(num_of_rate - 1)+" người khác đã đánh giá bài đăng này";
                  }
               } 
               Post_rating_to_db(post_id, id_user, num_of_star);//gui du lieu toi server
            }


           //ham bo tro hien thi thong tin nguoi dung:da thich bai dang ben client
            function Help_like(user_id, avatar, name, vnumail)
            {
              var ele = '<tbody>';
              ele += '<td><img src = "../'+avatar+'" class="thumbnail" alt="Loi" width="50" height="50"></td>';
              ele += '<td><div style="margin-left:-10%; "><p style="font-size: 125%;">'+name+'</p>';
              ele += '<p style="font-size: 80%;">'+vnumail+'</p></div></td>';
              ele += '<td><button type="button" class="btn btn-primary" style="margin-top: 8%;">Nhắn tin</button></td>';
              ele += '</tbody>';
              ele+= '<input type="hidden" id = "anthongtindanhgia" value = '+user_id+'>';

              return ele;
            }

            //ham hien thi thong tin nguoi dung: da danh gia bai dang ben client
            function Help_rating(user_id, avatar, name, vnumail, num_of_star)
            {
              var ele = '<tbody>';
              ele += '<td><img src = "../'+avatar+'" class="thumbnail" alt="Loi" width="50" height="50"></td>';
              ele += '<td><div style="margin-left:-20%;"><p style="font-size: 125%;">'+name+'</p>';
              ele += '<p style="font-size: 80%;">'+vnumail+'</p></div></td>';
              ele += '<td><p style="margin-left:20%;font-size:150%">' +num_of_star+ '</p></td>';
              ele += '</tbody>';
              ele+= '<input type="hidden" id = "anthongtindanhgia" value = '+user_id+'>';
              return ele;
            }

            //ham hien thi thong tin nguoi dung da like hoac danh gia bai dang
            
            function Infor_like_rating(post_id, num_like, num_rate)
            {

              $.ajax({
                type: "POST",
                url: "../../Controller/users_controller.php",
                data: {postcode_infor_user_like_rating: post_id},
                success: function(data)
                {
                  var True, index, length, infor_obj = JSON.parse(data);
                  True = 0;
                  length = Object.keys(infor_obj).length;
                  document.getElementById("nguoilikebaidang").innerHTML = "";
                  for(index = 0; index < num_like; index++){
                    if(user_id == infor_obj[index].user_id){
                      True = 1;
                    }else{
                      document.getElementById("nguoilikebaidang").innerHTML += Help_like(infor_obj[index].user_id, infor_obj[index].avatar, infor_obj[index].name, infor_obj[index].mail);
                    }
                  }

                  if(True == 1) document.getElementById("soluongthich").innerHTML = "Bạn và "+(num_like - 1)+" người khác đã thích bài đăng này";
                  else document.getElementById("soluongthich").innerHTML = num_like + " người đã thích bài đăng này";

                  True = 0;
                  document.getElementById("nguoidanhgiabaidang").innerHTML = "";
                  for(index = num_like; index < length; index++){
                    if(user_id == infor_obj[index].user_id){
                      True = 1;
                    }else{
                     document.getElementById("nguoidanhgiabaidang").innerHTML += Help_rating(infor_obj[index].user_id, infor_obj[index].avatar, infor_obj[index].name, infor_obj[index].mail, infor_obj[index].star);
                    }
                  }

                  if(True == 1) document.getElementById("soluongdanhgia").innerHTML = "Bạn và "+(num_rate - 1)+" người khác đã đánh giá bài đăng này";
                  else document.getElementById("soluongdanhgia").innerHTML = num_rate + " người đã đáng giá bài đăng này";

                }
              });

            }

             //ham nguoi dung se dang xuat ra khoi trang web
            //gia tri val trong ham user_Log_out
            function user_Log_out(val)
            {
               $.ajax({
                 type: "POST",
                 url: "../../Controller/users_controller.php",
                 data: {logout: val},
                 success : function (data){
                  
                   if(data == "ok"){
                       window.location.href = "../login_register.php";
                   }else{
                    //  alert("Xảy ra lỗi, không thể đăng xuất, vui lòng đợi...");
                   //  document.getElementById("kt").innerHTML = data;
                   }
                 }
               });
            }

              //thay doi su kien like bai dang
              function changeImage(image, id_post, id_user, like)//like va khong like
              {
                var show, show1;
                show = document.getElementById(id_post).querySelectorAll("p");//thay doi trang thai like, khong like
                show1 = document.getElementById(id_post).querySelectorAll("span");//chua so nguoi like bai viet
                //document.getElementById("kt").innerHTML = "cc";
                if(image.src.match("Like-512"))//trang thai chua like bai dang
                {
                  image.src = "../../Datasystem/dalike.jpg";
                  show[2].innerHTML = "<p style='color:blue;margin-top:-20px;'>Đã thích</p>";
                  like = like + 1; 
                  document.getElementById("soluongthich").innerHTML = "Bạn và "+(like - 1)+" người khác đã thích bài đăng này";     
                  Post_like_to_db(id_post, id_user, 0);//ma 0 la chua thich bai dang bjo thich bai dang
                }else//trang thai nay khi nguoi dung bo like bai dang
                {
                   image.src = "../../Datasystem/Like-512.png";
                   show[2].innerHTML = "<p style='color:black;margin-top:-20px;'>Thích</p>";
                   if(like > 0) like = like - 1;
                   document.getElementById("soluongthich").innerHTML = like + " người đã thích bài đăng này";
                   Post_like_to_db(id_post, id_user, 1);//ma 1 da thich bai dang bjo bo thich
                }
                show1[1].innerHTML = like;
              }

              //ham xem them bài đăng:
              //ý tưởng chính:khi người dùng muốn xem thêm bài đăng(trong web chỉ hiện tối đa 10 bài đăng gần nhất)
            // sử dụng php hiện 10 binh luan do ra. do đó khi kick vào xem thêm bài đăng, đề không mất công load lại trang, làm nặng thêm trang web, ý
              //tưởng dùng js và ajax, js để hiện bài đăng, còn ajax sẽ lấy dữ liệu từ server ra
              //tạo 1 div có class = '' sau dó dùng document.getElementsByCLassName de hien thong tin bai dang.
              //su dung ajax truy van co so du lieu ra ve mot array object voi moi doi tuong co cac thong tin 
              //function Show_more_post(id_post, id_user, avatar, name, time, average_rate, topic, content_post, link, file_name, status_like, num_of_like, num_of_judge, value_of_judge, avatar_you)
              //nhu vay cu moi lan nguoi dung yeu cau hien them binh luan thi ta chi viec lam nhu tren ma khong phai
              // refresh lai trang web, tuy nhien class rating chua the thuc hien duoc vi vay tam dung voi y tuong nhu vay.... :(

              //ham bo tro hien bai dang
              function Show_more_post(id_post, id_user, avatar, name, time, average_rate, topic, content_post, link, file_name, status_like, num_of_like, num_of_judge, value_of_judge, avatar_you)
              {
                var showpost = "";
                showpost = '<div class="popup-box4" id='+id_post+'><span class="glyphicon glyphicon-floppy-remove" data-toggle="tooltip" title="Xóa bài đăng" style="cursor:pointer;float:right;margin-top:1%;margin-right:2%;" onclick="Report_problem('+name+', '+topic+', '+file_name+', '+id_post+','+id_user+')">';
                showpost += '</span><table style="margin-left: 5px;height:80px;"><tr style="margin-top:5px;"><td><img src="../'+avatar+'" style="height:47px;width:47px;"></td><td><div style="margin-left:8px;padding:0px;">';
                showpost += '<p style="color:blue;margin-top:4px;"><a style="font-size:110%;cursor:pointer;" class="text-justify"><b>'+name+'</b></a> đã cập nhật chủ đề <b style="color:black;font-size:160%;">'+topic+'</b></p>';
                showpost += '<div style="margin-top:-9px;"><label style="font-size:90%;">'+time+'</label></div></div></td></tr></table>';
                showpost += '<div style="min-height: 140px;margin-top:10px;" class="form-group"><textarea readonly class="form-control" style="min-height:20px;resize:none;outline:none;font-size:15px;color:orange;background-color:white;border:none;">';
                showpost += content_post+'</textarea><div style="float:right;margin-right:10px;"><h4><label style="font-size:80%;">Điểm đánh giá</label> : <span>'+average_rate+'</span>/5</h4>';
                showpost += '</div><div style="margin-left: 15px;"><h5> <i>Đường dẫn file:</i></h5><a href = "../'+link+' target="_blank" style="cursor: pointer;"><p style="font-size: 170%;margin-left: 15px;">'+file_name+'</p></a></div></div>';

                showpost += '<div class="divcmt">';
                if(status_like == 1)
                {
                  showpost += '<img src="../../Datasystem/dalike.jpg" onclick = "changeImage(this,'+id_post+', '+id_user+','+num_of_like+')" style="margin-left:5px;width:36;height:29px;">';
                  showpost += '<p style="margin-top:-20px;margin-left: 50px;color:blue;">Đã thích</p>';
                }else
                {
                  showpost += '<img src="../../Datasystem/Like-512.png" onclick = "changeImage(this,'+id_post+', '+id_user+','+num_of_like+')" style="margin-left:5px;width:36;height:29px;">';
                  showpost += '<p style= "margin-top:-20px;margin-left:50px;">Thích</p>';
                }

                showpost += '<div style="margin-top:-20px;margin-left:26%;"><a style="cursor:pointer;" data-toggle="modal" data-target="#myModal" onclick="Infor_like_rating("'+id_post+','+num_of_like+','+num_of_judge+')"><span>'+num_of_like+'</span> người thích, <span>'+num_of_judge+'</span> người đánh giá</a></div>';
                showpost += '<div style="margin-left:60%;margin-top:-29px;cursor:pointer;"><input value="'+value_of_judge+'" type="number" class="rating" min=0 max=5 step=1 data-size="xs" data-stars="5" ';
                showpost += 'onchange = "Rating(this, '+id_post+', '+id_user+', '+num_of_judge+', '+average_rate+', '+value_of_judge+')"></div></div>';

                showpost += '<div class="divcmt1"><div style="border:1px solid #d5e8e8;height:auto;"><div style="margin-top:12px;"><a class="a4" onclick = "See_more_Comment('+id_post+', 0);">Xem bình thêm luận(<span id="changecmt">8</span>)</a>';
                showpost +='<input type="hidden" id="changecmt" value = 9><input type="hidden" id="changecmt" value = 1></div><div style="height:auto;" id=0></div></div>';
                showpost += '<form style="margin-top:18px;margin-left:10px;"><table><tr><td><img src="../'+String(avatar_you)+'" style="height:40px;width:42px;margin-top:5px;margin-left:-1px;"></td><td><div>';
                showpost += '<textarea style="resize:none;" rows="1" placeholder="Viết bình luận" class="divcmt2" onkeypress = "return UserComment(event, this, '+id_post+', 0)"></textarea></div></td></tr></table>';
                showpost += '</form><div style="height:30px; margin-top:0px;"></div></div></div>';

                return showpost;
              }

              //ham chuyen doi thoi gian so voi hien tai
              function Change_date(Date_time)
              {
                  var second, d, d1, date_now, text; 
                  d = new Date();//lay thoi gian hien tai
                  d1 = new Date(String(Date_time));//;lay thoi gian da dang
                  second = parseInt((d - d1)/1000);//thoi gian hien tai va thoi gian da dang
                  if(second < 60) text = "Vừa xong";
                  else if(second > 60 && second < 3600)            text =parseInt(second/60)+" Phút trước";
                  else if(second >= 3600 && second < 86400)        text = "Khoảng "+parseInt(second/3600)+" Tiếng trước"; 
                  else if(second >= 86400 && second < 2592000)     text = parseInt(second/86400)+" Ngày trước"; 
                  else if(second >= 2592000 && second < 946080000) text = parseInt(second/2592000)+" Tháng trước";
                  else                                             text = "Rất rất lâu.";     
                  return text;                               
              }

              //để hiện thị được các commment ta phải dùng ajax yêu cầu server trả về các bình luận với mã bài đăng xác định
              function See_comment_from_sv(id_post)
              {
                $.ajax({
                  type: "POST",
                  url: "../../Controller/users_controller.php",
                  data: {See_comment_from_sv_idpost: id_post},
                  success: function(data){
                   // document.getElementById("kt").innerHTML = avatar_you;
                  }

                });
              }
              
              //ham yeu cau hien thi them bai dang
              function See_more_posts(id_user, val)
              {
                  var avatar_you = information_user.avatar;//anh dai dien nguoi binh luan
                 // document.getElementById("kt").innerHTML = avatar_you;
                  $.ajax({
                     type: "POST",
                     url:  "../../Controller/users_controller.php",
                     data: {see_more_post: 1, user_id_to_show: id_user, recognize_val: val},
                     success: function(data)
                     {
                        // document.getElementById("tk").innerHTML = data;
                         var lgth, In, Obj_post;
                         Obj_post = JSON.parse(data);
                         lgth = Object.keys(Obj_post).length;//lay do dai cua mang object
                         for(In = 0; In < lgth; In++){
                           document.getElementById("tk").innerHTML += Show_more_post(Obj_post[In].post_id, id_user, Obj_post[In].avatar, Obj_post[In].name, Change_date(Obj_post[In].post_time), Obj_post[In].average_rate, Obj_post[In].name_tp, Obj_post[In].notice, Obj_post[In].link, Obj_post[In].name_file, Obj_post[In].status_like, Obj_post[In].num_of_like, Obj_post[In].num_of_judge, Obj_post[In].value_of_judge, avatar_you);
                           See_more_Comment(Obj_post[In].post_id, 1);
                         }
                     } 
                });
              }