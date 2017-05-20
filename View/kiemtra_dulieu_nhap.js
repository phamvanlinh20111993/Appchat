
 var count_name = 0, count_repass = 0, count_pass = 0, count_mail = 0 , count_id = 0, count_all = 0;
 var count_user = 0, count_pass = 0;
 
 document.getElementById("form-fullname").addEventListener("click", function(){count_click("1");});
 document.getElementById("form-fullname").addEventListener("blur", function(){test_data("1");});
 
 document.getElementById("form-pass").addEventListener("click", function(){count_click("2");});
 document.getElementById("form-pass").addEventListener("blur", function(){test_data("2");});

 document.getElementById("form-repass").addEventListener("click", function(){count_click("3");});
 document.getElementById("form-repass").addEventListener("blur", function(){test_data("3");});
 
 document.getElementById("form-mail").addEventListener("click", function(){count_click("4");});
 document.getElementById("form-mail").addEventListener("blur", function(){test_data("4");});
 
 document.getElementById("form-id").addEventListener("click", function(){count_click("5");});
 document.getElementById("form-id").addEventListener("blur", function(){test_data("5");});

 
 function count_click(val)
 {
	if(val == "1"){
	    count_name++;
	    if(count_name >= 1 ||  count_all > 0){
		  document.getElementById("error-name").style.display = "none";
	    }
	}else if(val == "2"){
	    count_pass++;
	    if(count_pass >= 1 || count_all > 0){
		  document.getElementById("error-pass").style.display = "none";
	    }
	}else if(val == "3"){
	    count_repass++;
	    if(count_repass >= 1 || count_all > 0){
		  document.getElementById("error-repass").style.display = "none";
	    }
	}else if(val == "4"){
	    count_mail++;
	    if(count_mail >= 1  || count_all > 0 ){
		  document.getElementById("error-mail").style.display = "none";
	    }
	}else if(val == "5"){
	    count_id++;
	    if(count_id >= 1 || count_all > 0){
		  document.getElementById("error-id").style.display = "none";
	    }
	}
	
 }
 
 function error(id_error, notification)
 {
	 document.getElementById(id_error).innerHTML = "";
	 document.getElementById(id_error).style.display = "block";
	 document.getElementById(id_error).innerHTML = notification;
 }
 
 function test_data(Value)
 {
	var name, pass, repass, mail, id, length_name;
	
	if(Value == "1"){
		name = document.getElementById("form-fullname").value;
		length_name = name.length;
	    if(length_name == 0){
		   error("error-name", "Không để trống trường này.");
		   return false;
	    }else{
	        if(length_name < 6){
		        error("error-name", "Độ dài tên của bạn quá ngắn. Tối thiểu 6 kí tự");
				return false;
	        }else if(length_name > 30){
		        error("error-name", "Độ dài tên của bạn quá dài. Nhiều nhất 30 kí tự");
				return false;
	        }
		}
    }else if(Value == "2"){
	     pass = document.getElementById("form-pass").value;
	     repass = document.getElementById("form-repass").value;
	     if(pass.length == 0){
		     error("error-pass", "Không để trống trường này.");
			 return false;
	     }
	}else if(Value == "3"){
		 pass = document.getElementById("form-pass").value;
	     repass = document.getElementById("form-repass").value;
		 if(repass == 0){
	         error("error-repass", "Không để trống trường này.");
			 return false;
	     }else{
			 if(pass != repass){
		        error("error-repass", "Xác nhận mật khẩu không đúng.");
			    return false;
			 }
		 }
	}else if(Value == "4"){
		 mail = document.getElementById("form-mail").value;
		 if(mail.length == 0){
			error("error-mail", "Không để trống trường này.");
			return false;
		 }else{
		    var pos = mail.search("@vnu.edu.vn");
		    if(pos == -1){
			  error("error-mail", "Tài khoản vnu-mail không đúng.");
			  return false;
		    }
		 }
	}else if(Value == "5"){
		id = document.getElementById("form-id").value;
		id = parseInt(id);
		if(id < 10000000 || id > 99999999 || isNaN(id) == true){
		     error("error-id", "Mã số sinh viên có tám kí tự.");
			 return false;
		}
	}
	
	return true;
 }
 
 function Submit_form_register()
 {
	var a, b, c, d, e;
	a = test_data("1"); 
	b = test_data("2");
	c = test_data("3");
	d = test_data("4");
	e = test_data("5"); 
	if(a && b && c && d && e){
		value = 1;
		document.getElementById("form_register").submit();
	}else count_all++;
 }
 
 function Kick()
 {
	 count_user++;
	 document.getElementById("error-login-username").innerHTML = "";
	 if( count_user > 1) document.getElementById("error-login-username").style.display = "none";
 }
 
 function Kick1()
 {
	 count_pass++;
	 document.getElementById("error-login-pass").innerHTML = "";
	 if( count_pass > 1) document.getElementById("error-login-pass").style.display = "none";
 }
 
 function Submit_form_login()
 {
	 var identify = document.getElementById("form-username1").value;
	 var pass = document.getElementById("form-password1").value;
	 document.getElementById("error-login-username").style.display = "block";
	 document.getElementById("error-login-pass").style.display = "block";
	 var length12 = identify.length, True = 0;	
	 
	 if(identify == ""){
		 document.getElementById("error-login-username").innerHTML = "(*)Không để trống trường này.";
		 True = 1;
	 }
	 if(pass == ""){
		 document.getElementById("error-login-pass").innerHTML = "(*)Không để trống trường này.";
		 True = 1;
	 }
	 if(isNaN(identify) == true && length12 != 8){
		document.getElementById("error-login-username").innerHTML = "(*)Mã số sinh viên phải là số và có tám kí tự.";
		True = 1;
	 }else if(isNaN(identify)){
		document.getElementById("error-login-username").innerHTML = "(*)Mã số sinh viên phải là số.";
		True = 1;
	 }else if(length12 != 8 && length12 > 0){
		 document.getElementById("error-login-username").innerHTML = "(*)Mã số sinh viên phải có tám kí tự.";
		 True = 1;
	 }
	 
	 if(True == 0)  document.getElementById("form_login").submit();
 }
 
 