<!DOCTYPE html>
<?php
    session_start();
    ob_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bài thực hành tuần 5</title>
        <style>
            
            .div1 {
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                margin-left: 200px;
                margin-top: 100px;
            }
            
            input[type=text], select {
                width: 25%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                font-size:120%;
                height:50px;
            }

            input[type=submit] {
               width: 15%;
               padding: 14px 20px;
               margin: 8px 0;
               border: none;
               border-radius: 4px;
               cursor: pointer;
               margin-left: 30px;
               background-color: #3CBC8D;
               color: white;
               height:50px;
            }
            
        </style>
        
        <script>
            function Change(value)
            {
                if(value=="songuyento"){
                    document.getElementById("hien").innerHTML = "1.1.4. Nhập số n, cho biết n là số nguyên tố hay không? </br>";
                    document.getElementById("hien").innerHTML +="Ví dụ: 2 là số nguyên tố.";
                }
                else if(value=="fibonaci"){
                    document.getElementById("hien").innerHTML = "1.2.4.Nhập số n, in danh sách các số fibonaci trong phạm vi n.</br>";
                    document.getElementById("hien").innerHTML +="Ví dụ: Dãy số Fibonacci trong phạm vi 10 là 1, 2, 3, 5, 8";
                }else if(value=="tongbinhphuong"){
                    document.getElementById("hien").innerHTML = "1.2.5. Nhập số n, tính tổng bình phương của n số nguyên đầu tiên.</br>";
                    document.getElementById("hien").innerHTML +="Ví dụ: Tổng bình phương 3 số đầu tiên: 1^2 + 2^2 + 3^2 = 14";
                }else if(value=="sohoanhao"){
                    document.getElementById("hien").innerHTML ="1.2.2. Nhập số n, kiểm tra n là số hoàn hảo hay không?</br> ";
                    document.getElementById("hien").innerHTML +="Ví dụ: 6 = 1 + 2 + 3 nên là số hoàn hảo";
                }else if(value =="giaithua"){
                    document.getElementById("hien").innerHTML ="1.2.1. Nhập số n, tính n giai thừa. </br>";
                    document.getElementById("hien").innerHTML +="Ví dụ: 5! = 120";
                }else if(value=="toiuu"){
                    document.getElementById("hien").innerHTML = "1.1.8. Tìm phương án tối ưu (số tờ tiền là ít nhất) kết hợp 3 loại giấy bạc </br>100đ, 200đ, 500đ với nhau để cho ra số tiền 10000đ.";
                }
            }
            
        </script>
    </head>
    <body style=" background-color: #f2f2f2;">
        <div style="margin-left:180px;">
           <h1>BÀI TẬP THỰC HÀNH TUẦN 5</h1>
           <h3>Nội dung: Chọn 4 trong số các bài tập tuần 3 và 4 để viết chương trình bằng php, sử dụng giao diện web thay vì dòng lệnh.</h3>
        </div>
        <div class="div1">
           <h3>Chọn 1 bài toán để giải</h3>
          <form action="#" method="POST" enctype="multipart/form-data">
              <select name="chonlua" onchange="Change(value)">
                 <option value=""></option>
                 <option value="songuyento">1. Số nguyên tố</option>
                 <option value="fibonaci">2. Số Fibonacci</option>
                 <option value="tongbinhphuong">3. Tổng bình phương</option>
                 <option value="sohoanhao">4. Số hoàn hảo</option>
                 <option value="giaithua">5. Tính giai thừa</option>
                 <option value="toiuu">6. Tính số tiền tối ưu</option>
             </select>
             <input type = "submit" name = "submit1" value = "CONTINUE">
          </form>
          <p id="hien" style="font-size:120%;"></p>
       </div>
        <?php
            if(isset($_POST['submit1'])){
               if($_POST['chonlua'] == "songuyento"){
                  $_SESSION['value'] = 1;
               }
               
               if($_POST['chonlua'] == "fibonaci"){
                  $_SESSION['value'] = 2;
               }
               
               if($_POST['chonlua'] == "tongbinhphuong"){
                  $_SESSION['value'] = 3;
               }
               
               if($_POST['chonlua'] == "sohoanhao"){
                  $_SESSION['value'] = 4;
               }
               
               if($_POST['chonlua'] == "giaithua"){
                  $_SESSION['value'] = 5;
               }
               
               if($_POST['chonlua'] == "toiuu"){
                  $_SESSION['value'] = 6;
               }
               if($_POST['chonlua'] != "") header("location:tinhtoan.php");
            //  if($_POST['chonlua'] != "") echo"<meta http-equiv='refresh' content='0;url=songuyento.php'>";
              
            }
            ob_end_flush();
        ?>
    </body>
</html>
