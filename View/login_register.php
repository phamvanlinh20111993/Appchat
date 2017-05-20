<?php
   session_start();

    if(isset($_SESSION['id'])){
   		if($_SESSION['Admin'] == 1) {
   			     header('Location: ../view/examples/admin_page.php');
   		}else    header('Location: ../view/examples/home_page.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome to Blog share Documents</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
        <style>
		   ::-webkit-input-placeholder {
		       font-size:17px;
               color: pink;
            }
			
			input[type="email"]
            {
              font-size:20px;
			  color:brown;
            }
			
			input[type="text"]
            {
              font-size:20px;
			  color:black;
            }
			
			input[type="number"]
            {
              font-size:20px;
			  color:grey;
            }
			
		</style>
    </head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
	<!--<script src="jquery-3.1.1.min.js"></script> -->
  
    <body>
        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                	
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>Blog share DoCuMeNts</strong> Login &amp; Register</h1>
                            <div class="description">
                            	<p>
	                            	Cho phép chia sẻ <strong>"Tài liệu(word, excel, pdf,...)"</strong>  Theo chủ đề. 
	                            	Bình luận, nhận xét, đánh giá,.... <a><strong>Cực cool</strong></a>, 
	                            	hãy đến với chúng tôi!
                            	</p>
                            </div>
                        </div>
                    </div>
					<?php 
					   if(isset($_SESSION['error_notification']))
					   {
						   echo"<script type='text/javascript'>";
						   echo"alert('".$_SESSION['error_notification']."');";
						   echo"</script>";
						   unset($_SESSION['error_notification']);
					   }
					
					?>
                    
                    <div class="row">
                        <div class="col-sm-5">
                        	
                        	<div class="form-box">
	                        	<div class="form-top">
	                        		<div class="form-top-left">
	                        			<h3>Đăng nhập bằng tài khoản</h3>
	                            		<p>Nhập mã số sinh viên và mật khẩu:</p>
	                        		</div>
	                        		<div class="form-top-right">
	                        			<i class="fa fa-lock"></i>
	                        		</div>
	                            </div>
	                            <div class="form-bottom">
				                    <form role="form" action="../Controller/test_login_register.php" method="post" class="login-form" id = "form_login">
				                    	<div class="form-group">
				                    		<label class="sr-only" for="form-username">Username</label>
				                        	<input type="text" name="form-username" value = "<?php 
											      if(isset($_COOKIE['identify_student'])){
													  echo $_COOKIE['identify_student'];
												  }else if(isset($_SESSION['error_identify'])){
													  echo $_SESSION['error_identify'];
												  } ?>" placeholder="Identify..." class="form-username form-control" id="form-username1" onclick="Kick()" autocomplete="off">
				                        </div>
										<p id="error-login-username" style="color:red;display:none;"></p>
				                        <div class="form-group">
				                        	<label class="sr-only" for="form-password">Password</label>
				                        	<input type="password" name="form-password" value = "<?php if(isset($_COOKIE['identify_student'])) echo $_COOKIE['password_user']; ?>" 
											 placeholder="Password..." class="form-password form-control" id="form-password1"  onclick="Kick1()">
				                        </div>
										<p id="error-login-pass" style="color:red;display:none;" > </p>
				                        <button type="button" name = "user_login" class="btn" onclick="Submit_form_login()">Sign in!</button>
				                    </form>	
			                    </div>
		                    </div>
		                
		                	<div class="social-login">
	                        	<h3>...or login with:</h3>
	                        	<div class="social-login-buttons">
		                        	<a class="btn btn-link-2" href="#">
		                        		<i class="fa fa-facebook"></i> Facebook
		                        	</a>
		                        	<a class="btn btn-link-2" href="#">
		                        		<i class="fa fa-twitter"></i> Twitter
		                        	</a>
		                        	<a class="btn btn-link-2" href="#">
		                        		<i class="fa fa-google-plus"></i> Google Plus
		                        	</a>
	                        	</div>
	                        </div>
	                        
                        </div>
                        
                        <div class="col-sm-1 middle-border"></div>
                        <div class="col-sm-1"></div>
                        	
                        <div class="col-sm-5">
                        	
                        	<div class="form-box">
                        		<div class="form-top">
	                        		<div class="form-top-left">
	                        			<h3>Đăng kí ngay</h3>
	                            		<p>Điền đầy đủ thông tin bên dưới</p>
	                        		</div>
	                        		<div class="form-top-right">
	                        			<i class="fa fa-pencil"></i>
	                        		</div>
	                            </div>
	                            <div class="form-bottom">
				                    <form role="form" action="http://localhost/BaiTapLonPtUdW/Controller/test_login_register.php" method="post" id="form_register">
				                    	<div class="form-group">
				                    		<label class="sr-only" for="form-first-name">Full name</label>
				                        	<input type="text" name="form-fullname1" value = "<?php if(isset($_SESSION['name'])) echo $_SESSION['name']; ?>" 
											 pattern="[A-Za-z0-9]{50}" title="Tên chỉ chứa kí tự và số" placeholder="Full name..." class="form-control" id="form-fullname">
				                        </div>
										<p id="error-name" style="color:red;display:none;" > </p>
				                        <div class="form-group">
				                        	<label class="sr-only" for="form-last-name">Password</label>
				                        	<input type="password" name="form-pass1" placeholder="Password..." class="form-control" id="form-pass">
				                        </div>
											<p id="error-pass" style="color:red;display:none;" > </p>
                                        <div class="form-group">
				                        	<label class="sr-only" for="form-last-name">Confirm password</label>
				                        	<input type="password" name="form-repass1" placeholder="Confirm pass..." class="form-control" id="form-repass">
				                        </div>
										<p id="error-repass" style="color:red;display:none;" > </p>
				                        <div class="form-group">
				                        	<label class="sr-only" for="form-email">VNU-email</label>
				                        	<input style="height:50px;" type="email" value = "<?php if(isset($_SESSION['mail'])) echo $_SESSION['mail'];?> " name="formvnmail" placeholder="VNU-email..." class="form-control" id="form-mail">
				                        </div>
										<p id="error-mail" style="color:red;display:none;" > </p>
				                        <div class="form-group">
				                        	<label class="sr-only" for="form-about-yourself">Your id</label>
				                        	<input style="height:50px;" type="number" value = "<?php
				                        	if(isset($_SESSION['id1'])) echo (int)$_SESSION['id1'];?>" name="form-id1" placeholder="Your identify..." class="form-control" id="form-id" max="99999999" min="10000000">
				                        </div>
										<p id="error-id" style="color:red;display:none;" > </p>
				                        <button type="button" class="btn"  name="signup" onclick = "Submit_form_register()">Sign me up!</button>
				                    </form>
			                    </div>
                        	</div>
                        	
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>

        <!-- Footer -->
        <footer>
        	<div class="container">
        		<div class="row">
        			
        			<div class="col-sm-8 col-sm-offset-2">
        				<div class="footer-border"></div>
        				<p>Sáng chế bởi <a href=""><strong>NHÓM 3</strong></a> 
        					phát triển ứng dụng Web<i class="fa fa-smile-o"></i></p>
        			</div>
        			
        		</div>
        	</div>
        </footer>

        <!-- Javascript -->
		<script src="kiemtra_dulieu_nhap.js"></script>
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
    </body>

</html>
