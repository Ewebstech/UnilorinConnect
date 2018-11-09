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
										 <div class="panel-heading"><a href="<?php $code = rand().microtime(); echo"comp_profile_step_3.php?reg=$_SESSION[userid]&step_3=$code";?>" class="pull-right badge" >Skip <i class="fa fa-angle-double-right"></i></a><h4>Update your Personal Information and get your friends know you better!</h4> </div>
										  <div class="panel-body" >
				<!--Form to get educational data -->
										<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
									
										<div class="col-sm-12">
										
										<div class="form-group col-sm-4">
											  <label>Are you Male or Female?</label>
										   	   <select name="gender" class="form-control">
											   <option value="">Choose</option>
											   <option value="Male">Male</option>
											   <option value="Female">Female</option>
											   </select>
										</div>
																				 
										<div class="form-group col-sm-4">
											  <label>What's your nickname?</label>
										   	   <input type="text" name="nick" placeholder="bonnyface?" class="form-control"/>
										</div>
										
										<div class="form-group col-sm-4">
											  <label>What's your Middle Name?</label>
										   	   <input type="text" name="middlename" placeholder="Middlename" class="form-control"/>
										</div>
										<div class="row">									
										<div class="form-group col-sm-4">
											  <label>About ME</label>
										   	   <textarea name="aboutme" rows="6" placeholder="Tell your friends something interesting about your personality!" class="form-control"></textarea>
										</div>
										<div class="form-group col-sm-4">
											  <label>Do you have a Hobby?</label>
										   	   <input type="text" name="hobby" placeholder="What's your Hobby?" class="form-control"/>
										</div>
										<div class="form-group col-sm-4">
											  <label>Passion</label>
										   	   <textarea rows="6" name="passion" placeholder="Find friends with similar passions" class="form-control"></textarea>
										</div>
										</div>
										  </div> <!-- col -->
			<?php if(isset($_REQUEST["duplicate"])){ echo "<div class='btn btn-danger col-sm-12'>Error! Do you want to update your profile? Please go to your profile page and click 'Edit Profile' to do so</div>"; } ?>									
										
										</div> <!-- panel body-->
									</div>
									
									<div class="pull-right">
									
									
								
									<button name="personal" type="submit" class="btn btn-primary">Next <i class='fa fa-angle-double-right'></i></button> 
						
									
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
	
if(isset($_POST["personal"]))
{
		$gender = mysql_real_escape_string($_POST["gender"]);
		$nick = mysql_real_escape_string($_POST["nick"]);
		$passion = mysql_real_escape_string($_POST["passion"]);
		$hobby = mysql_real_escape_string($_POST["hobby"]);
		$aboutme = mysql_real_escape_string($_POST["aboutme"]);
		$middlename = mysql_real_escape_string($_POST["middlename"]);
		$id = $_SESSION["userid"];
		$time = time();
		
		$queryprofile = mysql_query("SELECT * FROM `profile` where `id`='$id'");
		$get = mysql_fetch_assoc($queryprofile);
		
		$query = "CREATE TABLE IF NOT EXISTS `personals` (id VARCHAR(200), nickname VARCHAR(50), hobby VARCHAR(50), about TEXT, passion TEXT, middlename VARCHAR(50), 
		firstname VARCHAR(50), lastname VARCHAR(50), email VARCHAR(50), gender VARCHAR(6), time VARCHAR(20), PRIMARY KEY(email))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			die(mysql_error());
		}
		
		$query = "INSERT INTO `personals` (id, nickname, hobby, about, passion, middlename, firstname, lastname, email, gender, time) VALUES 
		('$id', '$nick', '$hobby', '$aboutme', '$passion', '$middlename', '$get[firstname]', '$get[lastname]', '$get[email]', '$gender', '$time')";
		$insert = mysql_query($query);
		if(!$insert)
		{
			header("location: comp_profile_step_2.php?duplicate");
		}
		else{
		$code = rand().microtime();
		if(isset($_SESSION["goto"])) {
			unset($_SESSION["goto"]);
		header("location: mp.php?&about&profile=$_SESSION[userid]");
		}
		else{ header("location: comp_profile_step_3.php?reg=".$id."&step_3=".$code.""); }
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