<?php
	require_once '..\..\Controller\users_controller.php';
	$name = information_user();
  Online_minute(2400);//duoc online 45 phut
  if(!isset($_SESSION['id']) && !isset($_SESSION['pass'])){
    header('Location: ../../view/login_register.php', true, 301);
  }

  if(isset($_SESSION["loi cap nhat csdl"])){
    echo"<script>alert('".$_SESSION["loi cap nhat csdl"]."');</script>";
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>ProFile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <!-- <link rel="stylesheet" href="../bootstrap-3.3.7/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap-3.3.7/dist/css/bootstrap-theme.css">
  <script src="../bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
  <script src = "../jquery-3.1.1.min.js"></script> -->
 
  <script src = "function_content_sharing.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 650px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }

    .fieldwrapper{
      white-space: nowrap;
      margin-top: 2%;
    }

  </style>
  <script type="text/javascript">
  /*  $(document).ready(function() {
    $('#avatar img').each(function() {
        var maxWidth = 100; // Max width for the image
        var maxHeight = 100;    // Max height for the image
        var ratio = 0;  // Used for aspect ratio
        var width = $(this).width();    // Current image width
        var height = $(this).height();  // Current image height

        // Check if the current width is larger than the max
        if(width > maxWidth){
            ratio = maxWidth / width;   // get ratio for scaling image
            $(this).css("width", maxWidth); // Set new width
            $(this).css("height", height * ratio);  // Scale height based on ratio
            height = height * ratio;    // Reset height to match scaled image
            width = width * ratio;    // Reset width to match scaled image
        }

        // Check if current height is larger than max
        if(height > maxHeight){
            ratio = maxHeight / height; // get ratio for scaling image
            $(this).css("height", maxHeight);   // Set new height
            $(this).css("width", width * ratio);    // Scale width based on ratio
            width = width * ratio;    // Reset width to match scaled image
            height = height * ratio;    // Reset height to match scaled image
        }
    });
}); */
  </script>
</head>

<body onload="Autopos()">
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cập nhật ảnh đại diện</h4>
        </div>
        <div class="modal-body">
          <p id="cc" class="text-center">Ảnh hiện tại</p>
          <div align="middle">
          <img src="../<?php echo $name['avatar'];?>" class="img-rounded" alt="<?php echo $name['fullname'];?>" id="avatar" style="object-fit: contain;">
          </div>
          <form action="../../Controller/Persional_controller.php" method="post" enctype="multipart/form-data" id="Form_image">
            <div class="fieldwrapper">
             <input type="file" name="files" id = "filer_input" data-toggle="tooltip" title="Click chọn file ảnh ở đây, lấy file đầu tiên up" onchange="Choose_image(this)">
             <input type="button" name = "submitfile" class="btn btn-info" value="Submit file" onclick="Upload_file()" style="margin-top: 1%;">
           </div>
        
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
	<div class="container-fluid">
     <div class="row content">
  	 
     <div class="col-sm-3 sidenav">
      <div style="margin-left: 85px;">
        <div class="thumbnail" style="margin-top: 6%;" >
          <img src="..\<?php echo $name['avatar']; ?>" alt="Ảnh đại diện" class="img-thumbnail" style="height: 205px;width:215px;" onclick = "Update_image();Changeimagesize()" data-toggle="tooltip" title="Kick vao day de cap nhat anh dai dien">
        <!--<div class="caption">
        </div> -->
        </div>

       <?php echo"<h4 class='text-center'>Profile's <label style='font-size:120%;'>".$name["fullname"]."</label></h4>"; ?>
       <ul class="nav nav-pills nav-stacked" style="margin-top: 5%;">
         <li class="active">
         <a href="<?php if($_SESSION['Admin']== 1){echo"admin_page.php";
              }else echo"home_page.php";?>">Home</a></li>
         <li><a href="#1" onclick="Changeimage('examples/posts.php')">Your posts</a></li>
          <li><a href="#3" onclick="Changeimage('upload.php')">Your avatars</a></li>
         <li><a href="#2" onclick="Changeimage('information.php')">Informations</a></li>
         <li><a href = "#" onclick="user_Log_out(0)"> Log out</a></li>
       </ul><br>
       <div class="input-group">
         <input type="text" class="form-control" placeholder="Search something..">
           <span class="input-group-btn">
             <button class="btn btn-default" type="button">
               <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
      </div>
      </div>
    </div>
    <p id="kt"></p>

    <div class="col-sm-9" style="height: 99%;">
      <iframe id = "Iframe" style = "height:100%;width:100%;"></iframe>

    </div>
  </div>
</div>

<!--<footer class="container-fluid">
  <p>Footer Text</p>
</footer> -->
<script type="text/javascript">
  //ham hien thi cac

  function Autopos()
  {
   // document.getElementById("kt").innerHTML = window.location.href;
    var y;
   
    var pos = window.location.href;
    if(pos.length >= 64){
      var val = pos.substring(64, pos.length);
      if(parseInt(val) == 0){
        y = "http://localhost/BaiTapLonPtUdW/View/examples/posts.php";
      }else if(parseInt(val) == 1){
         y = "http://localhost/BaiTapLonPtUdW/View/information.php";
      }else{
         y = "http://localhost/BaiTapLonPtUdW/View/upload.php";
      }
    }else{
         y = "http://localhost/BaiTapLonPtUdW/View/upload.php";
    }
    var x = document.getElementById("Iframe");
    x.setAttribute("src", y);
  }

  //ham thay doi active khi click vao nhom the a
  $("ul li").on("click", function() {
    $("li").removeClass("active");
    $(this).addClass("active");
  });

  //ham thay doi kich thuoc anh theo ti le
  function Changeimagesize()
  {
      var id = document.getElementById("avatar");
      var H, W, wh, temp;

      W = id.naturalWidth//-chieu rong
      H = id.naturalHeight//-chieu dai
  
      if(W > H){
          wh = W;
      }else wh = H;

      if(wh > 500){
        temp = wh/500;
        if(wh == W){
            id.width = 500;
            id.height = parseInt(H/temp);
        }else{
            id.height = 500;
            id.width = parseInt(W/temp);
        }
      }else{
        temp = 500/wh;
        if(wh == W){
           id.width = 500;
           id.height = parseInt(H*temp);
        }else{
            id.height = 500;
            id.width = parseInt(W*temp);
        }
      }
  }

  function Choose_image(id)
  {
    document.getElementById("avatar").src = window.URL.createObjectURL(event.target.files[0]);
    document.getElementById("cc").innerHTML="Ảnh đang chọn...";
   // $('#avatar').width('auto').height('auto');
    Changeimagesize();
   // document.getElementById("cc").innerHTML = id.files[0].name;
  }

  function Changeimage(value)
  {
    var y = "http://localhost/BaiTapLonPtUdW/View/" + value;
    var x = document.getElementById("Iframe");
    x.setAttribute("src", y);
  }

  function Upload_file()
  {
    var link = document.getElementById("filer_input").files;
    var format_file = link[0].name.substring(link[0].name.lastIndexOf('.'));//lay dinh dang cua file
    if(format_file.toLowerCase() == ".png" || format_file.toLowerCase() == ".jpg" || format_file.toLowerCase() == ".gif" || format_file.toLowerCase() == ".tiff" || format_file.toLowerCase() == ".bmp" || format_file.toLowerCase() == ".jepg"){
      document.getElementById("Form_image").submit();
    }else{  
      alert("Vui lòng chọn định dạng ảnh png, jpg, gif, tif hoặc bmp.");
      window.location.href = "Profile.php";//load lai trang
      //location.reload();
    }
  }

  function Update_image()
  {
    $('#myModal').modal('show');
  }

</script>
</body>
</html>
