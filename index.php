<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Unilorin Connect</title>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--webfont-->

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/login.js"></script>
<script src="js/jquery.easydropdown.js"></script>
<!--Animation-->
<script src="js/wow.min.js"></script>
<link href="css/animate.css" rel='stylesheet' type='text/css' />
<script>
	new WOW().init();
</script>
</head>
<body>
<div class="header">
		   <div class="col-sm-8 header-left">
					 <div class="logo">
						<a href="index.php"><img src="images/logo.png" style="height: 50px; width:200px;" alt=""/></a>
					 </div>
						
	    	    </div>
	            <div class="col-sm-4 header_right" style="margin-left: 0; width: 300px;">
	    		      <div id="loginContainer"><a href="#" id="loginButton"><img src="images/login.png"><span>Login</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?signup"><img src="images/login.png"><span>signup</span></a>
						    <div id="loginBox">                
						        <form id="loginForm" method="post" action="process.php">
						                <fieldset id="body">
						                	<fieldset>
						                          <label for="email">Email Address</label>
						                          <input type="text" name="email" placeholder="Email">
						                    </fieldset>
						                    <fieldset>
						                            <label for="password">Password</label>
						                            <input type="password" name="password" placeholder="password">
						                     </fieldset>
						                    <input type="submit" name="login" id="login" value="Sign in">
						                	<label for="checkbox"><input type="checkbox" id="checkbox"> <i>Remember me</i></label>
						            	</fieldset>
						                 <span><a href="#">Forgot your password?</a></span>
							      </form>
				              </div>
			             </div>
		                 <div class="clearfix"></div>
	                 </div>
	                <div class="clearfix"></div>
   </div>
   <?php 
		if(isset($_REQUEST["signup"]))
		{
			include("signup.html");
		}
	
   
   ?>
   <div  id="main-slider" data-ride="carousel" class="banner no-margin item active carousel-inner carousel slide" >
    <!-- carousel -->
	<div >
   <table width="100%">
   <tr>
   <td style="width: 35%;">
   <table>
   <tr>
   <td>
     <div style="float: left; margin-bottom: 20px;" class="row">
   <div style="margin-left: 30px;">
  <span class="float-left col-md-2" style="color: #fff;"><i class="fa fa-comment-o fa-3x"></i></span><div class="thetext col-xs-7" style="margin-top: 15px;">Connect</div>
  <p class='col-xs-7' style="color: #fff; opacity: 0.8; text-align: left; font-size: 12px;">Connect and Chat with Unilorin Students</p>
   </div>
   </td>
   </tr>
   <tr>
   <td>
     <div style="float: left; margin-bottom: 20px;" class="row">
   <div style="margin-left: 30px;">
  <span class="float-left col-md-2" style="color: #fff;"><i class="fa fa-pencil-square-o fa-3x"></i></span><div class="thetext col-xs-7" style="margin-top: 15px;">Share</div>
  <p class='col-xs-7 back' style="color: #fff; opacity: 0.8; text-align: left; font-size: 12px;">Blog, Share contents, files & photos with course-mates</p>
   </div>
   </td>
   </tr>
      <tr>
   <td>
     <div style="float: left; margin-bottom: 20px;" class="row">
   <div style="margin-left: 30px;">
  <span class="float-left col-md-2" style="color: #fff;"><i class="fa fa-users fa-3x"></i></span><div class="thetext col-xs-7" style="margin-top: 15px;">Experience</div>
  <p class='col-xs-7' style="color: #fff; opacity: 0.8; text-align: left; font-size: 12px;">Meet People with Similar Interests</p>
   </div>
   </td>
   </tr>
   </table>
   </td>
   <td style="width: 100%">
   	  <div class="container_wrap" style="width: 900px">
	
   		<h1>Find a Unilorin Student</h1>
   	       <div class="dropdown-buttons">   
            		  <div class="dropdown-button">           			
            			<select class="dropdown" tabindex="9" data-settings='{"wrapperClass":"flat"}'>
            			<option value="faculty">Faculty</option>	
						<option value="1">Physical Sciences</option>
						<option value="2">Arts</option>
						</select>
					</div>
				     <div class="dropdown-button">
					  <select class="dropdown" tabindex="9" data-settings='{"wrapperClass":"flat"}'>
            			<option value="0">Department</option>	
						<option value="1">Mathematics</option>
						<option value="2">Physics</option>
						<option value="3">Chemistry</option>
					  </select>
					 </div>
				   </div>  
		    <form>
				<input type="text" value="Name, matric-no, Nick ..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Name, matric-no, Nick, ...';}">
			    <div class="contact_btn">
	               <label class="btn1 btn-2 btn-2g"><input name="submit" type="submit" id="submit" value="Find"></label>
	            </div>
			</form>        		
   		    <div class="clearfix"></div>
         </div>
		 </td>
		 </tr>
		 </table>
		 </div>
   </div>
   </div>
   </div>
   </div>
   <div class="footer">
   	<div class="container">
   	
	  <div class="footer_grids">
	     <div class="footer-grid">
			<h4>Privacy</h4>
			<ul class="list1">
				<li><a href="">Privacy Policy</a></li>
			</ul>
		  </div>
		  <div class="footer-grid">
			<h4>Terms</h4>
			<ul class="list1">
				<li><a href="#">Terms of Use</a></li>
			
			</ul>
		  </div>
		  <div class="footer-grid last_grid">
			<h4>Follow Us</h4>
			<ul class="footer_social wow fadeInLeft" data-wow-delay="0.4s">
			  <li><a href=""> <i class="fb"> </i> </a></li>
			  <li><a href=""><i class="tw"> </i> </a></li>
			  <li><a href=""><i class="google"> </i> </a></li>
			  <li><a href=""><i class="u_tube"> </i> </a></li>
		 	</ul>
		 	<div class="copy wow fadeInRight" data-wow-delay="0.4s">
              <p>&copy; Copyright. 2015 | Unilorin SUG </p>
	        </div>
		  </div>
		 
	   </div>
      </div>
   </div>
</body>
</html>		