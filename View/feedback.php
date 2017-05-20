<?php
	include_once '..\Controller\admin_controller.php';
?>

<!DOCTYPE html>
<html lang="en"> 
    <head>
        <title></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<!--<script src="../bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="../bootstrap-3.3.7/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="../bootstrap-3.3.7/dist/css/bootstrap-theme.css">-->
		<!--<script src = "../jquery-3.1.1.min.js"></script>-->	
		<style>
		/* The Modal (background) */
		.modal1 {
   			/*display: none; /* Hidden by default */
         /*  position: fixed; /* Stay in place */
    		z-index: 1; /* Sit on top */
    		padding-top: 100px; /* Location of the box */
    		left: 0;
    		top: 0;
   			/* width: 80%; /* Full width */
   			/* height: 100%; /* Full height */
    		overflow: auto; /* Enable scroll if needed */
    		margin-top: -50px;
    		min-height: auto;
		}

		.modal1-header {
    		padding:0;
    		color: white;
    		border: 1px solid #888;
    		background-color: #fefefe;
		}

		.modal1-footer {
    		padding: 2px 16px;
    		color: white;
    		border: 1px solid #888;
    		background-color: #fefefe;
		}

		/* Modal Content */
		.modal1-content {
    		margin: auto;
    		padding: 20px;
    		border-style: solid;
    		border-width: 0px 1px 0px 1px;
    		border-color: black;
    		min-height:100px;
    		width: 100%;
    		background-color: #fefefe;

		}

		/* The Close Button */
		.close {
    		color: #aaaaaa;
    		float: right;
    		font-size: 28px;
    		font-weight: bold;
		}

		.close:hover,
		.close:focus {
   		   color: #000;
           text-decoration: none;
           cursor: pointer;
        }

        a{
        	cursor: pointer;
        }
	</style>

	 <script type="text/javascript">
	  function Del(id, code_rp)
	  {
	  	 document.getElementById(id).style.display = "none";
	  	 $.ajax({
	  	 	type: "POST",
	  	 	url: "../Controller/admin_controller.php",
	  	 	data: {maxoaphanhoi: code_rp},
	  	 	success: function(data){
	  	 		document.getElementById("kt").innerHTML = data;
	  	 	}
	  	 });
	  }
	 </script>

   </head>
    
    <style>
	</style>
    <body>
    <h2 class="text-center">Số lượng phản hồi: <?php echo Length_tb_any("report", "select count(id_report) from report");?></h2>
    <p id="kt"></p>
    <div class="container">
      <?php
        $reports = array();
      	$reports = Content_report(0, 1000);
      	$lg = count($reports);
      	for($index = $lg - 1; $index >= 0; $index--){
      		foreach ($reports[$index] as $key => $value) {
            	if($key == "content")          $ct = $value;//noi dung phan hoi
            	else if($key == "id_post")     $post_id = $value;//ma bai dang
            	else if($key == "date")        $date_cr = Change_date($value);//thoi gian nguoi dung phan hoi
            	else if($key == "user_send")   $user_send = $value;//ma nguoi gui
            	else                           $code_rp = $value;
            }
       	echo"
       	<div id=$index>
    	  <div id='myModal' class='modal1'>
             <div class='modal1-header'>
                <span class='close' onclick='Del($index, $code_rp)' data-toggle='tooltip' title='Xóa Phản hồi' >&times;</span>
                <h4 style='color: blue;margin-left: 9%;'>Phản hồi</h4>
            </div>
            <div class='modal1-content'>";
           				
            	echo"<div style=' word-wrap: break-word;'><p><strong>Nội dung:</strong> ".$ct."</p></div>";
            	echo"<p><strong>Mã bài đăng:</strong> <a href = 'http://localhost/BaiTapLonPtUdW/view/manage_post.php?mabai=".$post_id."'>".$post_id."</a></p>";
            	echo"<p><strong>Thời gian phản hồi:</strong> ".$date_cr."</p>";
           echo" </div>
         	<div class='modal1-footer'>";
         	 echo"<span style='color:blue;margin-left: 60%;''><strong>Người báo cáo:</strong> <a onclick='See_user_report(".$user_send.")'>".$user_send."</a></span>";
        	echo"</div>

          </div>
        </div>";
        }
       ?>
        <script type="text/javascript">

          function See_user_report(id)
          {
              $.ajax({
                  type: "POST",
                  url: "../Controller/admin_controller.php",
                  data: {aibaocaobaidang: id},
                  success: function(data){
                    window.location.href = "manage_database_user.php";
                  }
              });
          }

        </script>
    </div>
    </body>
</html>