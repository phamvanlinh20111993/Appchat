
		    Array.remove = function(array, from, to){                     //cho mảng arr=["dao", "man", "le", "tao", "cam", "quyt", "hong"]
				var add = array.slice(( to || from ) + 1 || array.length);// dùng hàm Array.remove(arr, 3)
			    array.length = from < 0 ? array.length + from : from;    //ta được mảng mới arr=["dao", "man", "le", "cam", "quyt", "hong"]
				return array.push.apply(array, add);                    // => tác dụng của hàm Array.remove();*tham khảo trên mạng*
			};
			
		    var Arr = [];
			var socket = io.connect('http://127.0.0.1:5555');
			var count = 0;//dùng trong trường hợp như sau: ví dụ C muốn nhắn tin cho 2 ngừoi nhắn tin là A và B, khi click() hộp thoại được tạo, 
			//sau đó click vào nút tắt hội thoại đi - hàm close_chatbox() dùng hàm A.style.display = "none" - ẩn hộp thoại.Do đó khi người dùng 
			//muốn nhắn tin lại cho A  hàm chatbox_popup đã vô tình tạo hộp thoại mới là bản sao của hộp thoại cũ, vậy khi nhắn tin, ngôn ngữ trong
			//hội thoại bị lặp do đó dùng biến toàn cục count và Countingclick() để tránh tạo thêm hộp thoại, khắc phục vấn đề này :)
			function Countingclick()
			{
				count++;
				if(count > 1) count = 1;
			}
			
            function chatbox_popup(id, yourself, you)//tao hop thoai de nhan tin
            { 		
			    var i = 0;
				var index = parseInt(id);
				var name = document.getElementById(id).value;
				
                if(count <= -1){//đã có người dùng, không cần tạo thêm, tránh lặp từ ngữ trong hội thoại
					//document.getElementById("result").innerHTML = "block";
					var valu = document.getElementById(id).value;
					document.getElementById(valu).style.display = "block";
					Arr.unshift(name);//them gia tri vao dau mang
					chatbox_cal();
					return;
				}			
			    
				for(i = 0; i < Arr.length; i++)
				{
					if(Arr[i] == name)
					{
						Array.remove(Arr, i);
						Arr.unshift(name);
						chatbox_cal();
						return;
					}
				}
			 
				var textareaid = index + 1000;//giá trị textareaid và textboxid phải khác nhau
				var textboxid = index + 2000;
                var element = '<div class="popup-box-chat" id="'+ name +'">';//
				element += '<input type="hidden" id="'+ index +'" value="'+ name +'">';
				element += '<div style="background-color:  #5b5bef;height: 38px;">';
                element +=  '<div class="tooltip111"><a class=a8><p style="margin-top:-20px;font-size:80%;color:yellow;margin-left:5px;"><b><i>'+ name +'</i></b></p></a>';
                element += '<span class="tooltiptext">Mã số sinh viên: '+you+' </span>';
                element += '</div>';
                element += '<button class="close1 close2" onclick="close_chatbox('+index+')">X</button>'; 
                element += '</div>';
                element += '<div style="height:300px;max-width:297;background-color: #bcd1c6;overflow:auto;">';
                element += '<div id="'+textareaid+'"></div>';
                element += '</div>';
                element += '<div style="margin-top:5px; box-shadow: 1px 2px 5px #ccccff;">';
                element +=  '<input type = "text" placeholder="Viết tin nhắn..." id = "'+textboxid+'" style="margin-left:3px;width:290px;height:40px;"';
				element += 'onkeypress = "return CLICK(event,'+textareaid+','+textboxid+','+you+','+yourself+');" autofocus>';//"
                element += '<div style="clear: both"></div></div>';
                element = element + '</div>';
				
                document.getElementsByTagName("body")[0].innerHTML += element;  
              //  document.getElementById("nhushitvay").innerHTML += element; 
                Arr.unshift(name);//them gia tri vao dau mang
                chatbox_cal();
				document.getElementById(textareaid).innerHTML = "";//danh tu
                //phan dung nodejs
                socket.on('information', function(data){
	                document.getElementById(textareaid).innerHTML += '<br>' + '<div class="boxchat_body centerbox">' + data;
                });
                 
				var pos; 
				var receiver = "";//lay ma so sinh vien nguoi nhan
				var text = "";//lay doan du lieu
				var sender = "";//lay ma so sinh vien nguoi gui
				
                socket.on('message', function(data)
				{
				    for(pos = 0; pos < data.length; pos++)
					{
					   if(pos >=0 && pos < 16){
						  if(pos >=0 && pos < 8)  receiver += data.charAt(pos); //vi tri 0 va 8 la ma cua nguoi nhan de gui di, vd:14020813
						  else  sender += data.charAt(pos);//vi tri tu 8 den 16 la ma cua nguoi gui
					   }else{
						   text += data.charAt(pos); 
					   }
				    }
				
					//yourself la ma so sinh vien cua nguoi gui tin nhan
					//you la ma so sinh vien cua nguoi ban muon nhan tin cung
				    if((yourself == sender && receiver == you) || (yourself == receiver && you == sender)){
					   if(yourself == sender && receiver == you){//tin hieu gui
					       document.getElementById(textareaid).innerHTML += '<br>' + '<div class="boxchat_body">' + text;
					   }else{//tin hieu nhan 
						   document.getElementById(textareaid).innerHTML += '<br>' + '<div class="boxchat_body boxchatbody">' + text;
					   }
				    }
					//document.getElementById(textareaid).innerHTML = "";
					text = "";
					receiver = "";
					sender = "";
                });
            }
            
			function CLICK(e, aa, aaa, id, yourself)
			{
	          if(e.keyCode == 13){
				 var val = document.getElementById(aaa).value;
				// document.getElementById("ketqua").innerHTML += id + " ,";
				 var change  = id.toString() + yourself.toString() + val;//id la nhan dien nguoi dung
				 //document.getElementById("result").innerHTML += change + " ,";
				 if(val == ""); 
		         else{
					  socket.emit('message', change);//phat tin hieu
				      document.getElementById(aaa).value="";
	                  return false;
				 }
	          }
            }
			
			//hien thi them chatbox nhan tin
            function chatbox_cal()
            {
				var right = 260;
                var i = 0;
				
                for(i; i < 3; i++)
                {
                    if(Arr[i] != undefined)
                    {
                        var element = document.getElementById(Arr[i]);
                        element.style.right = right + "px";
                        right = right + 320;
                        element.style.display = "block";
                    }
                }
                
                for(var j = i; j < Arr.length; j++)
                {
                    var element = document.getElementById(Arr[j]);
                    element.style.display = "none";
                }				
            }  
			
			function close_chatbox(id)
			{
				var valu = document.getElementById(id).value;
				var i = 0;
				for(i; i < Arr.length; i++)
				{
				    if(Arr[i] == valu)
					{
						Array.remove(Arr, i);
						document.getElementById(valu).style.display = "none";
						count = count - 2;
						chatbox_cal();
						return;
					}
				}
			}
			
			window.addEventListener("resize", chatbox_cal);
            window.addEventListener("load", chatbox_cal);