<?php
	include_once '../Controller/admin_controller.php';
?>

<!DOCTYPE html>
<html lang="en">
	  <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!--	<link rel="stylesheet" href="bootstrap-3.3.7/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="bootstrap-3.3.7/dist/css/bootstrap-theme.css">
		<script src="bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>-->

		<style type="text/css">
			p{
				font-size: 130%;
				font-family: "Times New Roman", Times, serif;
				cursor: pointer;
			}
		</style>
	  </head>
	<body>

		<div class="container">
			<h2 class="text-center">THỐNG KÊ CƠ BẢN TRANG WEB</h2>
			<div style="margin-top: 5%;">
				<h3 style="margin-left: 5%;">(**)Người Dùng</h4>
				<?php
				  echo"<p>(*)Số lượng người dùng: ".Length_table_any("users", "")."</p>";

				  echo"<p>(*)Người đánh giá nhiều bài đăng nhất: ".Length_tb_any("", "SELECT u.fullname, COUNT(*) as k FROM judge j INNER join users u on u.user_id = j.user_id GROUP by j.post_id ORDER by k DESC")."</p>";

				  echo"<p>(*)Người đăng nhiều bài đăng nhất: ".Length_tb_any("", "SELECT u.fullname, COUNT(*) as k FROM posts p INNER join users u on u.user_id = p.user_id GROUP by p.post_id ORDER by k DESC")."</p>";

				  echo"<p>(*)Người like nhiều bài đăng nhất: ".Length_tb_any("", "SELECT u.fullname, COUNT(*) as k FROM likepost l INNER join users u on u.user_id = l.user_id GROUP by l.post_id ORDER by k DESC")."</p>";

				  echo"<p>(*)Người bình luận nhiều nhất: ".Length_tb_any("", "SELECT u.fullname, COUNT(*) as k FROM comments c INNER join users u on u.user_id = c.user_id GROUP by c.post_id ORDER by k DESC")."</p>";
				?>

				  <h3 style="margin-left: 5%;">(**)Bài đăng</h4>
				<?php
				  echo"<p>(*)Tổng số bài đăng: ".Length_table_any("posts", "")." </p>";

				  echo"<p>(*)Số comment trong 1 bài đăng nhiều nhất: ".Length_tb_any("comments", "SELECT count(*) as p from comments group by post_id order by p desc")." </p>";

				  echo"<p>(*)Điểm Đánh giá cao nhất trong bài đăng: ".Length_tb_any("judge", "SELECT avg(num_of_star) as k FROM judge group by post_id ORDER BY k DESC")."</p>";

				  echo"<p>(*)Bài đăng nhiều like nhất: ".Length_tb_any("likepost", "SELECT count(*) as k FROM likepost GROUP BY post_id ORDER BY k DESC")." </p>";

				  echo"<p>(*)Chủ đề có nhiều bài đăng nhất: ".Length_tb_any("", "SELECT t.name_topic, COUNT(*) as k FROM posts p INNER join topic t on p.topic_id = t.topic_id GROUP by p.topic_id ORDER by k DESC")."</p>";
				?>
			</div>
		</div>

	</body>
</html>

