<?php 
ob_start();
session_start();
if(!isset($_SESSION["email"]) and !isset($_SESSION["userid"]) and $_REQUEST["reg"] != $_SESSION["userid"])
{
	header("location: index.php");
}
	include("temp/database.php");
	$dataget = mysql_query("SELECT * FROM `profile` where `id`='$_SESSION[userid]' and `email`='$_SESSION[email]'");
	$thisprofile = mysql_fetch_assoc($dataget);

?>

<!DOCTYPE html>
<html lang="en">
	<head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title><?php echo"$thisprofile[firstname] $thisprofile[lastname]"; ?></title>
		
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="assets/css/bootstrap.css" rel="stylesheet">
		<link href="font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link href="assets/css/facebook.css" rel="stylesheet">
		<link href="assets/css/ajaxstyles.css" rel="stylesheet">
		<script src="js/jquery.js"></script>
		<script src="pjs.js"></script>
    </head>
    
    <body>
        

			<div class="box">
				<div class="row row-offcanvas row-offcanvas-left">
					
					<!-- sidebar -->
				
					<!-- /sidebar -->
				  
					<!-- main right col -->
					<div class="column col-sm-12 col-xs-12" id="main">
						
							<div class="padding">
							<div class="full col-sm-9">
							  
								<!-- content -->                      
								<div class="row">
								<div class="col-sm-8 col-sm-offset-2">
								
								</div>
								<?php if(is_dir("profilepictures/".$_SESSION["userid"]."")) { ?>
								 <!-- start --> 
								 <div class="col-sm-10 col-sm-offset-1">
								   <div class="col-sm-12">
								   <div class="row">
									  <div class="panel panel-default">
										 <div class="panel-heading"><a href="mp.php" class="pull-right badge" >Skip <i class="fa fa-angle-double-right"></i></a><h4>Upload a Profile Picture</h4> </div>
										  <div class="panel-body" >
				<!--Form to get educational data -->
												<div>
												<form id="uploadForm" action="upload.php" method="post" enctype='multipart/form-data'>
												<div id="targetLayer">
												<?php
													if(is_dir("profilepictures/".$_SESSION["userid"].""))
													{
														$dh = scandir("profilepictures/".$_SESSION["userid"]."");
																																					
														echo "<img src='profilepictures/$_SESSION[userid]/$dh[2]' class='img-responsive' style='width: 100px; height: 100px;' />";
														
													}
													else{
														echo "<img src='images/find_user.png' style='width: 100px; height: 100px;' class='img-responsive' />";
													}
												?>
												</div>
												<div id="uploadFormLayer">
												<span class="badge"><?php echo (isset($_SESSION["error"])) ? "Image Type not Allowed" : "" ; ?> </span>
												<label>Upload Image File from your computer:</label><br/>
											
												<div >
												<input name="image" type="file" class="inputFile" class="form-control"/>
												<input type="hidden" name="id" id="id" value="<?php echo $_SESSION["userid"]; ?>" />
												</div>
												<br />
												<div>
												<input type="submit" value="Upload Image" class="btnSubmit" />
												</div>
												
												</form>
												</div>
												</div>					
										
										</div> <!-- panel body-->
									</div>
									
									<div class="pull-right">
									<a href="mp.php" class="btn btn-success">Finish <i class='fa fa-angle-double-right'></i></a>
									</div>
									
							  </div>
						   </div>
									 
						</div>
								<?php } else { ?>
								 <div class="col-sm-10 col-sm-offset-1">
								   <div class="col-sm-12">
								   <div class="row">
									  <div class="panel panel-default">
										 <div class="panel-heading"><a href="<?php $code = rand().microtime(); echo"comp_profile_step_2.php?reg=$_SESSION[userid]&step_2=$code";?>" class="pull-right badge" >Skip <i class="fa fa-angle-double-right"></i></a><h4>Upload a Profile Picture</h4> </div>
										  <div class="panel-body" >
				<!--Form to get educational data -->
												<div>
												<form id="uploadForm" action="upload.php" method="post" enctype='multipart/form-data'>
												<div id="targetLayer"><img src='images/find_user.png' style='width: 100px; height: 100px;' class='img-responsive' /></div>
												<div id="uploadFormLayer">
												<label>Upload Image File from your computer:</label><br/>
											
												<div >
												<input name="image" type="file" class="inputFile" class="form-control"/>
												<input type="hidden" name="id" id="id" value="<?php echo $_SESSION["userid"]; ?>" />
												</div>
												<br />
												<div>
												<input type="submit" value="Upload Image" class="btnSubmit" />
												</div>
												
												</form>
												</div>
												</div>					
										
										</div> <!-- panel body-->
									</div>
									
									<div class="pull-right">
									<a href="mp.php" class="btn btn-success">Finish <i class='fa fa-angle-double-right'></i></a>
									</div>
									
							  </div>
						   </div>
									 
						</div>
								<?php } ?>
					<!-- -------- finish ------------------>
					
					
				 </div>
				 </div>
			</div>
			</div>
		</div>	
				<!-- /main -->
	  
	</div>
</div>							
				  
					
		
<script type="text/javascript">
		$(document).ready(function (e) {
	$("#uploadForm").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "upload.php?saledata=" + document.getElementById("id").value,
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
			$("#targetLayer").html(data);
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
});
</script>
        <script type="text/javascript" src="assets/js/jquery.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {
			$('[data-toggle=offcanvas]').click(function() {
				$(this).toggleClass('visible-xs text-center');
				$(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
				$('.row-offcanvas').toggleClass('active');
				$('#lg-menu').toggleClass('hidden-xs').toggleClass('visible-xs');
				$('#xs-menu').toggleClass('visible-xs').toggleClass('hidden-xs');
				$('#btnShow').toggle();
			});
        });
        </script>
</body></html>