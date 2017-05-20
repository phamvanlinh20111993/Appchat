<?php
	include_once '../Controller/admin_controller.php';
?>

<!DOCTYPE html>
<html lang="en">
    
    <head>
        <title>Admin Page</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
 	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<!--<link rel="stylesheet" href="../bootstrap-3.3.7/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="../bootstrap-3.3.7/dist/css/bootstrap-theme.css">
		<script src="bootstrap-3.3.7/distjs/bootstrap.min.js"></script>
		<script src = "../jquery-3.1.1.min.js"></script> -->
		<script>
			function See_detail(post_id)
			{
				//document.getElementById("kt").innerHTML = window.location.href;
				window.location.href = "manage_post.php?mabai=" + post_id;
			}

			function Help_take_ct(pos, ten, mang, tg, mabd)
			{
				var ele = '<label>'+pos+', Người dùng mã <a href="#" data-toggle="tooltip" data-placement="top" title="Ten:'+ten+'">'+mang+'</a> đã đăng bài vào lúc '+tg+'...</label><a style="cursor: pointer;" onclick="See_detail('+mabd+')"><span class="label label-info">Xem chi tiết</span></a></br>';
				return ele;
			}

            var click = 0;
			function Xemthongbaocu()
			{
				document.getElementById("xemthongbao").innerHTML = "";
				$.ajax({
					type: "POST",
					url: "../Controller/admin_controller.php",
					data: {Xemthongbaocu: 1, solanclick: click},
					success: function(data){
						
						var i, Lg, ndtb = JSON.parse(data);
						
						Lg = Object.keys(ndtb).length;
						//document.getElementById("kt").innerHTML = data;
						for(i = 0; i < Lg; i++){
							document.getElementById("xemthongbao").innerHTML += Help_take_ct(parseInt(i + 1), ndtb[i].name, ndtb[i].userid, ndtb[i].time, ndtb[i].postid);
						}
					}
				});
				click ++;
			}
		</script>
		<script src = "examples/function_content_sharing.js"></script>

    </head>

    <style>
	</style>
    <body>
      <div class="container-fluid">
      <p id="kt"></p>
        <div style="margin-left: 5%;">
       <?php
            $_SESSION['noidungthongbao'] = "cdfs";
 	    	if(isset($_SESSION['noidungthongbao']) && $_SESSION['noidungthongbao'] !="")
	    	{
				$_SESSION['noidungthongbao'] = "";
				$content_notification = Array();
				$content_notification = Take_cotent_notice(1, 0, 200);
				$InD = count($content_notification);
				if($InD > 0) 
					echo"<h2 class = 'text-center' id='tieude'>Có Rất nhiều Thông Báo Mới</h2>";
				else echo"<h2 class = 'text-center' id='tieude'>Không có thông báo nào</h2>";

      			 echo"<ul class='list-inline' id='xemthongbao'>";
				 for($in = 0; $in < $InD; $in++){
				  foreach ($content_notification[$in] as $key => $value){
				  	if($key == "userid")       $mangd = $value;
				    else if($key == "name")    $ten   = $value;
				    else if($key == "postid")  $mabd  = $value;
				    else                       $thoigian = $value; 
				  } 

      		      echo "<label>".($in + 1).", Người dùng mã <a data-toggle='tooltip' data-placement='top' title='Tên:".$ten."'>".$mangd."</a> đã đăng bài vào lúc ".$thoigian."</label><a style='cursor: pointer;' onclick='See_detail(".$mabd.")'><span class='label label-info'>Xem chi tiết</span></a></br>";
	    	    } 
	    	    echo"</ul>";
	    	}
      	?>
        
      	<ul class="pager">
    		<li class="previous"><a href="#" onclick="Xemthongbaocu()">Cũ hơn</a></li>
  		</ul>
      </div>	
      </div>

      <script>
		$(document).ready(function(){
    		$('[data-toggle="tooltip"]').tooltip();   
		});
	 </script>
	 
    </body>
</html>