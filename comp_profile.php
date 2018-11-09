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
								  
								 <!-- start --> 
								 <div class="col-sm-10 col-sm-offset-1">
								   <div class="col-sm-12">
								   <div class="row">
									  <div class="panel panel-default">
										 <div class="panel-heading"><a href="<?php $code = rand().microtime(); echo"comp_profile_step_2.php?reg=$_SESSION[userid]&step_2=$code";?>" class="pull-right badge" >Skip <i class="fa fa-angle-double-right"></i></a><h4>Update your Educational Information to enable your friends reach you easily!</h4> </div>
										  <div class="panel-body" >
				<!--Form to get educational data -->
										<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
									
										<div class="col-sm-12">
										
										<div class="form-group col-sm-4">
											  <label>Faculty</label>
										   	   <select name="faculty" class="form-control">
											   <option value="">Choose</option>
											   <option value="Physical Sciences">Physical Sciences</option>
											   <option value="Engineering">Engineering</option>
											   <option value="Social Sciences">Social Sciences</option>
											   <option value="Arts">Arts</option>
											   </select>
										</div>
										 
										<div class="form-group col-sm-4">
											  <label>Department</label>
										   	   <select name="department" class="form-control">
											   <option value="">Choose</option>
											   <option value="Physics">Physics</option>
											   <option value="Plant Biology">Plant Biology</option>
											   <option value="Microbiology">Microbiology</option>
											   </select>
										</div>	
										 
										<div class="form-group col-sm-4">
											  <label>Level</label>
										   	   <select name="level" class="form-control">
											   <option value="">Choose</option>
											   <option value="100">100</option>
											   <option value="200">200</option>
											   <option value="300">300</option>
											   <option value="400">400</option>
											   <option value="500">500</option>
											   <option value="600">600</option>
											   <option value="700">700</option>
											   </select>
										</div>
									
								
										  </div> <!-- col -->
									   <div>
	<?php if(isset($_REQUEST["emp"])){ echo "<div class='btn btn-danger col-sm-12'>Sorry, you cant leave any fields blank. If you dont have enough information now, you can skip this page and complete it later!</div>"; } ?>								
	<?php if(isset($_REQUEST["duplicate"])){ echo "<div class='btn btn-danger col-sm-12'>Error! Do you want to update your profile? Please go to your profile page and click 'Edit Profile' to do so</div>"; } ?>									  
									  </div>
										
										</div> <!-- panel body-->
									</div>
									
									<div class="pull-right">
									<!--<input type="submit" name="educational" class="btn btn-primary" value="Next >>" /> -->
				
									<button name="educational" type="submit" class="btn btn-primary">Next <i class='fa fa-angle-double-right'></i></button> 
									</div>
									</form>
							  </div>
						   </div>
									 
						</div>
	<?php 
	
	if(isset($_REQUEST["editfield"]))
	{
		$_SESSION["goto"] = "set123";
	}
if(isset($_POST["educational"]))
{
	if(empty($_POST["faculty"]) or empty($_POST["department"]) or empty($_POST["level"]))
	{
		header("location: comp_profile.php?reg=".$_SESSION["userid"]."&emp");
    }
	else
	{
		$faculty = mysql_real_escape_string($_POST["faculty"]);
		$department = mysql_real_escape_string($_POST["department"]);
		$level = mysql_real_escape_string($_POST["level"]);
		$id = $_SESSION["userid"];
		$time = time();
		
		$queryprofile = mysql_query("SELECT * FROM `profile` where `id`='$id'");
		$get = mysql_fetch_assoc($queryprofile);
		
		$query = "CREATE TABLE IF NOT EXISTS `eduinfo` (id VARCHAR(200), faculty VARCHAR(50), level VARCHAR(50), department VARCHAR(50), firstname VARCHAR(50), lastname VARCHAR(50), email VARCHAR(50), time VARCHAR(20), PRIMARY KEY(email))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			die(mysql_error());
		}
		
		$query = "INSERT INTO `eduinfo` (id, faculty, level, department, firstname, lastname, email, time) VALUES 
		('$id', '$faculty', '$level', '$department', '$get[firstname]', '$get[lastname]', '$get[email]', '$time')";
		$insert = mysql_query($query);
		if(!$insert)
		{
			header("location: comp_profile.php?duplicate");
		}
		else{
		$code = rand().microtime();
		if(isset($_SESSION["goto"])) {
			unset($_SESSION["goto"]);
		header("location: mp.php?&about&profile=$_SESSION[userid]");
		}
		else{ header("location: comp_profile_step_2.php?reg=".$id."&step_2=".$code.""); }
		}
	}
}
	
	
	
?>
					<!-- -------- finish ------------------>
					
					
				 </div>
				 </div>
			</div>
			</div>
		</div>	
				<!-- /main -->
	  
	</div>
</div>							
				  
					
		



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