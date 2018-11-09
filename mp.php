<?php error_reporting(0);
ob_start();
session_start();
if(!isset($_SESSION["userid"]))
{
	header("location: index.php");
}
	if(isset($_SESSION["userid"]) or !isset($_REQUEST["userid"]) or $_REQUEST["profile"] == $_SESSION["userid"])
	{
		$userid = $_SESSION["userid"];
	}
	if(isset($_REQUEST["profile"]) and $_REQUEST["profile"] != $_SESSION["userid"])
	{
		$userid = $_REQUEST["profile"];
	}
	include("temp/database.php");
	$dataget = mysql_query("SELECT * FROM `profile` where `id`='$userid'");
	$thisprofile = mysql_fetch_assoc($dataget);
	
	$queryp = mysql_query("select * from personals where id='$userid'");
	$pinfo = mysql_fetch_assoc($queryp);
	
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
		

        <title><?php echo"$thisprofile[firstname] $thisprofile[lastname]"; ?></title>
		<meta name="HandheldFriendly" content="true" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        
        <link href="assets/css/bootstrap.css" rel="stylesheet">
		<link href="font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link href="assets/css/facebook.css" rel="stylesheet">
		<link href="assets/css/prettyPhoto.css" rel="stylesheet">
		<script src="js/jquery.js"></script>
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/tooltip-classic.css" />

		
    </head>
    
    <body>
	
        <table>
		<tr><td>
        <div>
			<div class="box">
				<div class="row row-offcanvas row-offcanvas-left">
					<!--left-sidebar-->
					<?php include("left-sidebar.php"); ?>
					<!--/left-sidebar-->
					<!-- main right col -->
					
					<div class="column  col-xs-10" id="main">
					 		
					<?php include("header.php"); ?>
					
						<div class="padding">
						
							<div class="full col-sm-12">
							  
								<!-- content -->                      
								<div class="row">
						<!-- right sidebar -->
						<?php include("adverts.php"); ?>
						<!-- /right sidebar -->	
								<div class="col-sm-9">
								
								<?php 
								if(isset($_REQUEST["connectdecline"])) { 
									$myft = substr($_SESSION["userid"],0,33);
									$ft = substr($_REQUEST["connectdecline"],0,33);
									
									$delete1 = mysql_query("delete from $myft where id='$_REQUEST[connectdecline]'");
									$delete2 = mysql_query("delete from $ft where id='$_SESSION[userid]'");
									if($delete1 and $delete2){ header("location: home.php?friendrequests");}
								}
								
								if(isset($_REQUEST["connectconnect"])) { 
									$myft = substr($_SESSION["userid"],0,33);
									$ft = substr($_REQUEST["connectconnect"],0,33);
									
									$update1 = mysql_query("update $myft set status='friends' where id='$_REQUEST[connectconnect]'");
									$update2 = mysql_query("update $ft set status='friends' where id='$_SESSION[userid]'");
								
									if($update1 and $update2){
								?>
								<div class="alert alert-info alert-dismissable" style="background-color: rgba(102,0,51,0.5);"><!--alert -->
									<button  type="button" class="close" data-dismiss ="alert">
									<strong style="color:#fff">X</strong>
									</button>
						
									<span style="color: #fff; font-weight: bold;">
									<center><a href="#" style="color: #fff;"><?php echo"$thisprofile[firstname] $pinfo[middlename] $thisprofile[lastname] and YOU are now Connected!"; ?></a>
									</center>
									</span>
								</div><!--alert -->
								<?php } }?>
								<div  class="panel panel-default panel-adjust" 
								<?php if(is_dir("coverphoto/".$userid."")) { 
								if(file_exists("coverphoto/".$userid."/".$userid.".jpg")){
								echo "style='background: url(coverphoto/$userid/$userid.jpg) center no-repeat; background-size: 100%; position: relative;'";
								}
								elseif(file_exists("coverphoto/".$userid."/".$userid.".png")){
								echo "style='background: url(coverphoto/$userid/$userid.png) center no-repeat; background-size: 100%;'";
								}
								elseif(file_exists("coverphoto/".$userid."/".$userid.".gif")){
								echo "style='background: url(coverphoto/$userid/$userid.gif) center no-repeat; background-size: 100%;'";
								}
								else{
								echo "style='background: url(images/background1.jpg) center no-repeat; background-size: 100%;'";
								}
								}
								else{
								echo "style='background: url(images/background1.jpg) center no-repeat; background-size: 100%;'";
								}								?>
								>
											<script>
											  function openFileOption()
											{
											  document.getElementById("file1").click();
											 									
											}
											
											function sumit()
												{
												document.getElementById("uploadForm").submit();
												
												}
											
											</script>
											
									<?php if(!isset($_REQUEST["profile"]) or $_REQUEST["profile"] == $_SESSION["userid"]) { ?> 
										<form id="uploadForm" action="upload.php" method="post" enctype='multipart/form-data'>							
										<input type="file" id="file1" name="image" style="display:none;" onchange="sumit();" value="<?php echo"$userid"; ?>"/> 
										<input type="hidden" name="id" value="<?php echo"$userid"; ?>" />
										<a href="#" onclick="openFileOption();return;" data-toggle= 'tooltip' title= 'Change Cover Photo' class="pull-right" style="position: relative; padding: 10px; color: #fff;"><i class="fa fa-camera fa-2x"></i></a>
										</form>
									<?php } ?>
										<div class="panel-body">
										<div class="col-sm-10 col-sm-offset-1 profilename">
										<?php echo"$thisprofile[firstname] $pinfo[middlename] $thisprofile[lastname]"; ?>
										</div>
									
										<div class="col-sm-3" id="showimgbutton">
											<?php
											
									if(is_dir("profilepictures/".$userid.""))
									{
										$dh = scandir("profilepictures/".$userid."");
																																	
										echo "
										<div class='portfolio-item'>
                                            <div class='item-inner'>
										<img src='profilepictures/$userid/$dh[2]' class='img-responsive' max-height: 150px; max-width: 150px;/>
												<div class='overlay'>
                                                    <a class='preview btn btn-danger' href='profilepictures/$userid/$dh[2]' rel='prettyPhoto' ><i class='fa fa-eye'></i></a>
                                                </div>
										</div>
										</div>
										";
									}
									else{
										echo "<div class='portfolio-item'>
                                            <div class='item-inner'>
										<img src='images/find_user.png' style='width: 140px; height: 100px;' class='img-responsive profilepic' />
										<div class='overlay'>
                                                    <a class='preview btn btn-danger' href='images/find_user.png' rel='prettyPhoto' ><i class='fa fa-eye'></i></a>
                                                </div>
										</div>
										</div>
										";
									}
													$ssid = session_id();
													$time = time();
													
echo (!isset($_REQUEST["profile"]) or $_REQUEST["profile"] == $_SESSION["userid"]) ? "<a href='comp_profile_step_4.php?reg=$userid&edit=$ssid$time' data-toggle='tooltip' title='Change Profile Picture' id='buttonid' class='btn btn-default btn-xs'>change picture</a>" : "" ;				
													
												?>
												<br/>
												<br />
								
																				
										</div>
										<!--
											 <div class='portfolio-item'>
                                            <div class='item-inner'>
                                                <img class="img-responsive" src="images/slide6.jpg" width='100' alt="">
                                               <div class='overlay'>
                                                    <a class='preview btn btn-danger' href='images/slide6.jpg' rel='prettyPhoto' ><i class='fa fa-eye'></i></a>
                                                </div>
                                            </div>
                                        </div>
										-->
										<script>
										var buttonDiv = document.getElementById("showimgbutton");  
									
										onload = function() {
											document.getElementById("buttonid").style.display = 'none';
										
										}
										buttonDiv.onmouseover = function() {
											document.getElementById("buttonid").style.display = 'block';
											
										}
									
									
										buttonDiv.onmouseout = function() {
											document.getElementById("buttonid").style.display = 'none';
										
										}
										
										
										</script>
									<div class="col-sm-2">
													<a href="?&timeline&profile=<?php echo"$userid"; ?>" class="btn btn-default  coverbuttons"><i class="fa fa-clock-o"></i> Timeline</a>
									</div>
									
										<div class="col-sm-2">
													<a href="?&showfriends&profile=<?php echo"$userid"; ?>" class="btn btn-default  coverbuttons"><i class="fa fa-group"></i> Friends</a>
												</div>
										<?php if($_REQUEST["profile"] == $_SESSION["userid"] or !isset($_REQUEST["profile"])) { ?>
										<div class="col-sm-2">
													<a href="home.php?&messages" class="btn btn-default coverbuttons"><i class="fa fa-envelope-o"></i> Message</a>
										</div>
										<?php } else { ?>
										<div class="col-sm-2">
													<a href="home.php?&composemessage&reply=<?php echo"$userid"; ?>" class="btn btn-default coverbuttons"><i class="fa fa-envelope-o"></i> Message</a>
										</div>
										<?php } ?>
										<div class="col-sm-2">
													<a href="?&about&profile=<?php echo"$userid"; ?>" class="btn btn-default  coverbuttons"><i class="fa fa-stack-exchange"></i> About</a>
												</div>
										
										</div>
								</div>
								
								<div class="panel">
								
								</div>
								</div>
								  	 <?php 
								if(isset($_REQUEST["coment"])){ include("comment.html"); }
																
					?>
								 <!-- main col left --> 
								 <div class="col-sm-9">
								 
								 
								 	<!-------------------------------------------------------------------->
							<?php if(isset($_REQUEST["showfriends"])) { ?>
									<div class="col-sm-12">
								   <div class="row">
									<div class="panel panel-default">
									   <?php 
									  
									  $myfriends = substr($userid, 0,33);
									  $ffquery = mysql_query("select * from `$myfriends` where status='friends'");
									  $frow = mysql_num_rows($ffquery);			  
									  ?> 
								<div class="panel-heading"><h4><?php if(empty($frow)){ $frow = "0";}echo ($_REQUEST["profile"] == $_SESSION["userid"]) ? "Your Friends ($frow)" : "Friends of $thisprofile[firstname]" ; ?></h4></div>
								<div class="panel-body">
										
									
								
								<!-- Friends -->		
								
								<div class="row" style="margin-left: 20px;">
								<?php while($friendinfo = mysql_fetch_assoc($ffquery)) { ?>
								<?php if (!empty($friendinfo)) { ?>
								<div class="col-sm-3" style="border: 1px solid rgba(0,0,0,0.2); border-radius: 4px; max-height: 130px; height: 130px; margin: 5px; padding: 5px; max-width: 120px; text-align: center;">
								<?php
													
													if(is_dir("profilepictures/".$friendinfo["id"].""))
													{
														$dh = scandir("profilepictures/".$friendinfo["id"]."");
																																					
														echo "<a href='mp.php?&profile=$friendinfo[id]&$friendinfo[firstname]$friendinfo[lastname]'><img src='profilepictures/$friendinfo[id]/$dh[2]' style='border-radius: 30%; display: inline-block;  max-width:100px; max-height: 100px;' class='img-responsive img-user' /></a>";
														
													}
													else{
														echo "<a href='mp.php?&profile=$friendinfo[id]&$friendinfo[firstname]$friendinfo[lastname]'><img src='images/find_user.png'  class='img-responsive img-user' style='border-radius: 50%; width: 80px; height: 80px; display: inline-block;' /></a>";
													}
								$namequery = mysql_query("select * from `profile` where id='$friendinfo[id]'");				
								$nameinfo = mysql_fetch_assoc($namequery);
								?>
								<br />
								
								<span style="font-size: 9px;"><?php echo"<a href='mp.php?&profile=$nameinfo[id]&$nameinfo[firstname]$friendinfo[lastname]'>$nameinfo[firstname] $nameinfo[lastname]</a>"; ?></span>
								</div>
								<?php }
								else { echo "No Friends";}
								} ?>
								</div>
							
							
								 </div>
								 </div>
							</div>
							</div>							
									
									  										 
							<?php } ?>
						<!-------------------------------------------------------------------->
								 
								<!-------------------------------------------------------------------->
								<?php if(!isset($_REQUEST["about"]) and !isset($_REQUEST["showfriends"])) { ?>
								   <div class="col-sm-6 pull-right">
								   <?php if(isset($_REQUEST["profile"])){
											$frsub = substr($_SESSION["userid"], 0,33);
																					
											$query = mysql_query("select * from $frsub where id='$_REQUEST[profile]' and status='friends'");
											$checked = mysql_fetch_assoc($query);
											
											if(!$checked and $_REQUEST['profile'] != $_SESSION["userid"]) { 
									  ?>
											<div class="panel" style="padding: 10px; text-align: center;">
											
											<b style='color: purple;'>You</b> and <b style='color: purple;'><?php echo "$thisprofile[firstname] $thisprofile[lastname]"; ?></b> are not connected!
											<p style="margin-top: 5px;"><a href="home.php?&addfriend=<?php echo"$_REQUEST[profile]"; ?>" class="btn btn-success btn-xs">Connect</a></p>
											</div>
									  
								   <?php } }?>
									  <div class="well">
									  <script>
											  function FileOption()
											{
											  document.getElementById("thefile").click();
											 									
											}
											
											function sumitt()
												{
												document.getElementById("form").submit();
												
												}
											function alertme() {
												if (this.value.length > 300) {
													alert("You have exceeded the maximum character length allowed for this post");
												}
											}
											</script>
										   <form id="form" class="form-horizontal" role="form" action="process.php" method="post" class="form-horizontal" enctype='multipart/form-data'>
											<h4><?php echo ($_SESSION["userid"]==$userid) ? "Post on your Timeline" : "Share as $thisprofile[firstname] on Your Timeline"; ?>  </h4>
											 <div class="form-group" style="padding:14px;">
											 <div class="input-group">
										 <div class="input-group-addon" style="width: 80px; max-width: 90px; max-height: 90px; !important;">
										  <?php if(!$_REQUEST['post'] or $_REQUEST["post"]){echo(file_exists("profilepictures/".$userid."/".$userid.".jpg") or file_exists("profilepictures/".$userid."/".$userid.".png")) ? "<img src='profilepictures/$userid/$userid.jpg' style='border-radius: 7px; width: 50px; height: 41px; border: 1px solid #fff;' class='img-responsive' />" : "";} ?>
										</div>
										<textarea style='' rows="4" onkeypress="alertme();" maxlength='500' class="form-control" placeholder="<?php echo"$thisprofile[firstname]"; ?>, What do you have to Share?" name="status"><?php echo"$_REQUEST[post]"; ?></textarea>
									</div>
								</div>
											<input type="file" id="thefile" name="image" style="display:none;" onchange="sumitt();" /> 
											<?php echo "<img src='$_REQUEST[img]' style='max-width: 300px; height: auto; margin-bottom: 10px;' class='img-responsive;' />"; ?>
										<input type="hidden" name="thisid" value="<?php echo"$userid"; ?>" />
											<button type="submit" name="poststatus" class="btn btn-primary pull-right" type="button">Post</button>
			<ul class="list-inline"><li class="tooltip tooltip-effect-5"><a class="tooltip-item" href="#" onclick="FileOption();return;" ><i class="fa fa-camera"></i></a><span class="tooltip-content tooltip-text" style="width: 100px; margin-left: -50px;">Upload Picture</span></li></ul>		 				
										  </form>
										
									
									  </div>
									  <?php 	
									  //$postquery = mysql_query("SELECT * from `statusposts` WHERE `posterid`='$userid' or `posterid`='$friendid' order by time desc");
									  $postquery = mysql_query("SELECT * from `statusposts` order by time desc");
									  
									  while($post = mysql_fetch_assoc($postquery)) { 
									  $myfriendtable = substr($userid, 0,33);
									  $fq = mysql_query("SELECT * from `$myfriendtable` where id='$post[posterid]'" );
									  $friendid = mysql_fetch_assoc($fq);
									  
									  if(isset($friendid["id"]) and $friendid["status"] == "friends" or $post['posterid'] == $_SESSION["userid"]) {
									  ?>
									  
									  <div class="row">
									  <div class="panel">
									 
									<div class="panel-heading" >
									
									 <div class="col-sm-3" style="margin-left: -20px;">
									  <?php
											
									if(is_dir("profilepictures/".$post["posterid"].""))
									{
										$dh = scandir("profilepictures/".$post["posterid"]."");
																																	
										echo "<img src='profilepictures/$post[posterid]/$dh[2]' style='max-width: 50px; max-height: 50px;' class='img-responsive img-user' />";
										
									}
									else{
										echo "<img src='images/find_user.png'  class='img-responsive img-user' style='max-width: 50px; max-height: 50px;' />";
									}
													
													
										?>
									
									  
									  </div>
									  <?php $rowquery = mysql_query("select * from comments where postid='$post[postid]'"); 
											$commentrow = mysql_num_rows($rowquery);
									  ?>
									  <div class="pull-left displayname"><a href="<?php echo"mp.php?profile=$post[posterid]&$post[postername]"; ?>"><?php echo"$post[postername]"; ?></a><span  style="font-size: 9px; color: #666666; text-align: right; width: 120px;  display: inline-block;"><i class="fa fa-comments"></i> <?php echo (!empty($commentrow)) ? "$commentrow Comments" : "0 Comments" ; ?> </span><br />
									  <span style="font-size: 9px; color: #666666; text-align: left; padding-right: 30px;"><i class="fa fa-globe"></i> <?php echo date('F d Y, \a\t\ h:i a', $post["time"]); ?></span></div>
									   
									  </div>
									 
									  <br clear="all" />
								   <hr />
										<div class="panel-body" style="margin-top: -20px;">
											<?php echo"$post[post]"; ?>
											
									<div class="col-sm-12" style="margin-top: 20px;">
									
								<?php 
								
												
								
								if($post) { echo "<img src='$post[imgpath]' class='img-responsive' style='margin-left: auto; margin-right: auto;'/>"; } ?>
									  
									  </div>
										</div>
								<hr />
								</div>
								</div>
								 <div class="panel commentspanel">
								 <div>
								 <table cellpadding="5" width="326" >
								  <?php $commentquery = mysql_query("select * from comments where postid='$post[postid]'"); 
								  while($comment = mysql_fetch_assoc($commentquery)) { ?>
								<tr>
								<td colspan="2" style="font-size: 9px; background-color: rgba(102,0,51,0.5); font-weight: bold; text-align: center; color: #fff;"><i class="fa fa-globe"></i> On <?php echo date('F d, Y \a\t\ h:i a', $comment["time"]); ?></td>
								</tr>
								<tr>
								 <td style="width: 42px;">
								<?php
											
													if(is_dir("profilepictures/".$comment["commenterid"].""))
													{
														$dh = scandir("profilepictures/".$comment["commenterid"]."");
																																					
														echo "<img src='profilepictures/$comment[commenterid]/$dh[2]' style='display: inline-block; border-radius: 50%; max-width: 40px; height: auto; max-height: 50px; border: solid 1.5px rgba(102,0,51,0.7);' class='img-responsive' />";
														
													}
													else{
														echo "<img src='images/find_user.png'  class='img-responsive img-user' style='border-radius: 50%; max-width: 40px; max-height: 40px;' />";
													}
													
											
								?>
								</td>
								<td class="displayname"><a href="<?php echo"mp.php?profile=$comment[commenterid]&$comment[commentername]"; ?>"><?php echo"$comment[commentername]"; ?></a>&nbsp; <i class="fa fa-play"></i> &nbsp; <span style="line-height: 20px; font-size: 11px;"><?php echo"$comment[comment]"; ?></span> </td>
								<tr >
								<td colspan="2" ><span style="color: #fff; ";><hr /></span></td>
								</tr>
								</tr>
								
								
								<?php } ?>
								</table>
								 </div>
								 
								<div class="form-group">
								
							<a href="?&coment=<?php echo"$post[id]"; ?>" class="btn btn-primary btn-xs pull-right">Comment</a>
								</div>
							
								 
								 </div>
								<?php }  }?>
								 
							</div>
								   <div class="col-sm-6 pull-left">
								   
								<?php $statquery = mysql_query("select * from `statustable` where id='$userid' order by time desc");
								$statusupdateresult = mysql_fetch_assoc($statquery);
								if(!empty($statusupdateresult)){
								?>
								   
								   <div class="alert alert-info alert-dismissable" style="background-color: rgba(102,0,51,0.5);"><!--alert -->
									<button  type="button" class="close" data-dismiss ="alert">
									<strong style="color:#fff">x</strong>
									</button>
						
									<span style="color: #fff;">
									<center><a href="#" style="color: #fff;"><?php echo $statusupdateresult["status"]; ?></a>
									</center>
									</span>
									</div><!--alert -->
								<?php } ?>
								   <div class="row">
									  <?php 
									  $query = mysql_query("select * from eduinfo where id='$userid'");
									  $eduinfo = mysql_fetch_assoc($query);
									  
									  
									  ?>
									  <div class="panel panel-default">
										 <div class="panel-heading"><a href="<?php echo"?&about"; ?>" class="pull-right badge">View all</a> <h4><?php echo ($_SESSION["userid"]==$userid) ? "Your" : "$thisprofile[firstname] $thisprofile[lastname]'s"; ?> Information</h4></div>
										  <div class="panel-body">
											<table class="table table-hover">
											<tr>
											<td>Username:</td><td><?php echo"$thisprofile[username]"; ?></td>
											</tr>
											<tr>
											<td>Name:</td><td><?php echo"$thisprofile[firstname] $thisprofile[lastname]"; ?></td>
											</tr>
											
											<?php if(!empty($eduinfo["department"])) { ?>
											<tr>
											<td>Department</td><td><?php echo"$eduinfo[department]"; ?></td>
											</tr>
											<?php } ?>
											<?php if(!empty($eduinfo["faculty"])) { ?>
											<tr>
											<td>Faculty:</td><td><?php echo"$eduinfo[faculty]"; ?></td>
											</tr>
											<?php } ?>
											<?php if(!empty($eduinfo["level"])) { ?>
											<tr>
											<td>Current Level:</td><td><?php echo"$eduinfo[level] Level"; ?></td>
											</tr>
											<?php } ?>
											<?php if(!empty($eduinfo["email"])) { ?>
											<tr>
											<td>Email:</td><td><?php echo"$eduinfo[email]"; ?></td>
											</tr>
											<?php } ?>
											
											<tr>
											<td>Phonenumber:</td><td><?php echo"$thisprofile[phonenumber]"; ?></td>
											</tr>
											
											</table>
											
										  </div>
									  </div>
									  
									  	  <div class="panel panel-default">
										  <?php 
									  $grpquery = mysql_query("select * from groups");
										  ?> 
										 <div class="panel-heading"><a href="<?php echo"groups.php?allgroups"; ?>" class="pull-right badge">See all</a> <h4> Groups <?php echo ($_SESSION["userid"]==$userid) ? "You" : "$thisprofile[firstname]"; ?> belong to</h4></div>
										  <div class="panel-body">
										  <table class="table table-hover">
										  <?php 
										   while($groupinfo = mysql_fetch_assoc($grpquery)) {
										  $groupcheck = mysql_query("select * from `$groupinfo[groupname]` where memberid='$userid' and memberstatus='member'");
										  $gcheck = mysql_fetch_assoc($groupcheck);
										  if($gcheck){ ?>
											<tr>
											<td><a href="<?php echo"groups.php?&profile=$_SESSION[userid]&grpname=$groupinfo[groupname]"; ?>"><strong><?php echo ucfirst(strtolower($groupinfo['groupname'])); ?></strong></a></td>
											</tr>
										 <?php } }?>
										   	</table>
										  </div>
									  </div>
									  
									  	  <div class="panel panel-default">
										 <div class="panel-heading"><a href="<?php echo"?&showfriends&profile=$userid"; ?>" class="pull-right badge">View all</a> <h4><?php echo ($_SESSION["userid"]==$userid) ? "Your Friends" : "Friends of $thisprofile[firstname]"; ?></h4></div>
										  <div class="panel-body">
									   <?php 
									  
									  $myfriends = substr($userid, 0,33);
									  $ffquery = mysql_query("select * from `$myfriends` where status='friends'");
									  $frow = mysql_num_rows($ffquery);			  
									  ?> 	  
								<div class="row">
								<?php while($friendinfo = mysql_fetch_assoc($ffquery)) { ?>
								<?php if (!empty($friendinfo)) { ?>
								<div class="col-sm-2 tooltip tooltip-effect-5" style="border: 1px solid rgba(0,0,0,0.2); border-radius: 4px; margin: 5px; padding: 5px; text-align: center;">
								<?php
									
										$q = mysql_query("select * from profile where id='$friendinfo[id]'");
										$qname = mysql_fetch_assoc($q); 
													if(is_dir("profilepictures/".$friendinfo["id"].""))
													{
														$dh = scandir("profilepictures/".$friendinfo["id"]."");
																																					
														echo "<a href='mp.php?&profile=$friendinfo[id]&$qname[firstname]$qname[lastname]'><img src='profilepictures/$friendinfo[id]/$dh[2]' width='50' height='50' style='display: inline-block;' class='img-responsive img-user tooltip-item' /></a>";
														
													}
													else{
														echo "<a href='mp.php?&profile=$friendinfo[id]&$qname[firstname]$qname[lastname]'><img src='images/find_user.png'  width='50' height='50' style='display: inline-block;' class='img-responsive img-user' /></a>";
													}
								echo"<span class='tooltip-content tooltip-text' style='width: 100px; margin-left: -50px;'>$qname[firstname] $qname[lastname]</span>";
								//$namequery = mysql_query("select * from `profile` where id='$friendinfo[id]'");				
								//$nameinfo = mysql_fetch_assoc($namequery);
								?>
								</div>
								<?php } } ?>
								</div>
									
										  </div>
									  </div>
									  
									  
									  </div>
								
									</div>
								<?php } ?>
						<!-------------------------------------------------------------------->
						<?php if(isset($_REQUEST["about"])) { ?>
									<div class="col-sm-12">
								   <div class="row">
									<div class="panel panel-default">
									   <?php 
									  $cquery = mysql_query("select * from `contactinfo` where id='$userid'");
									  $contactinfo = mysql_fetch_assoc($cquery);
									  				  
									  ?> 
										 <div class="panel-heading"><?php echo (empty($contactinfo)) ? "<a href='comp_profile_step_3.php?&editfield' class='pull-right badge' >Edit Now <i class='fa fa-angle-double-right'></i></a>" : "" ; ?><h4><?php echo"$thisprofile[firstname]'s"; ?> <b>Contact Information</b></h4></div>
										  <div class="panel-body">
										
									
								<table class="table table-hover">
								<!-- Mobile No -->		
								<?php if (!empty($contactinfo)) { ?>
								<tr>
								<td>Skype ID:</td>
								<?php if(!isset($_REQUEST["edit"]) and isset($_REQUEST["about"])) { echo "<td>"; 
							echo "$contactinfo[skype]";
							if($_SESSION["userid"] == $userid){ echo "<a href='mp.php?&about&edit=skype' id='abtbutton' class='btn btn-primary btn-xs'>edit</a>";}
								echo "</td>"; }?>
								<?php if(isset($_REQUEST["edit"]) and isset($_REQUEST["about"]) and $_REQUEST["edit"] == "skype") { echo "<td>"; 
								echo"
								<form action='process.php' method='post'>
								<div class='col-sm-7'>
								<input type='text' name='newfield' value='$contactinfo[skype]' class='form-control'/>
								</div>
								<input type='hidden' name='myid' value='$userid' />
								<input type='hidden' name='column' value='skype' />
								<div class='col-sm-2'>
<button type='submit' name='contactupdate' data-toggle='tooltip' title='Edit this Information' style='margin-top: 5px;' class='btn btn-primary btn-xs'>done</button>
								</div>
								</form>
								";
								
								echo "</td>"; } ?>
								</tr>
								<!-- Email Address -->		
								<tr>
								<td>Email Address:</td>
								<?php if(!isset($_REQUEST["edit"]) and isset($_REQUEST["about"])) { echo "<td>"; 
							echo "$contactinfo[email]";
							if($_SESSION["userid"] == $userid){ echo "<a href='mp.php?&about&edit=email' id='abtbutton' class='btn btn-primary btn-xs'>edit</a>";}
								echo "</td>"; }?>
								<?php if(isset($_REQUEST["edit"]) and isset($_REQUEST["about"]) and $_REQUEST["edit"] == "email") { echo "<td>"; 
								echo"
								<form action='process.php' method='post'>
								<div class='col-sm-7'>
								<input type='text' name='newfield' value='$contactinfo[email]' class='form-control'/>
								</div>
								<input type='hidden' name='myid' value='$userid' />
								<input type='hidden' name='column' value='email' />
								<div class='col-sm-2'>
<button type='submit' name='contactupdate' data-toggle='tooltip' title='Edit this Information' style='margin-top: 5px;' class='btn btn-primary btn-xs'>done</button>
								</div>
								</form>
								";
								
								echo "</td>"; } ?>
								</tr>	
								<!-- Facebook -->		
								<tr>
								<td>Facebook ID:</td>
								<?php if(!isset($_REQUEST["edit"]) and isset($_REQUEST["about"])) { echo "<td>"; 
							echo "$contactinfo[facebookid]";
							if($_SESSION["userid"] == $userid){ echo "<a href='mp.php?&about&edit=fb' id='abtbutton' class='btn btn-primary btn-xs'>edit</a>";}
								echo "</td>"; }?>
								<?php if(isset($_REQUEST["edit"]) and isset($_REQUEST["about"]) and $_REQUEST["edit"] == "fb") { echo "<td>"; 
								echo"
								<form action='process.php' method='post'>
								<div class='col-sm-7'>
								<input type='text' name='newfield' value='$contactinfo[facebookid]' class='form-control'/>
								</div>
								<input type='hidden' name='myid' value='$userid' />
								<input type='hidden' name='column' value='facebookid' />
								<div class='col-sm-2'>
<button type='submit' name='contactupdate' data-toggle='tooltip' title='Edit this Information' style='margin-top: 5px;' class='btn btn-primary btn-xs'>done</button>
								</div>
								</form>
								";
								
								echo "</td>"; } ?>
								</tr>		  
								<!-- BBM -->		
								<tr>
								<td>BBM Pin:</td>
								<?php if(!isset($_REQUEST["edit"]) and isset($_REQUEST["about"])) { echo "<td>"; 
							echo "$contactinfo[bbmpin]";
							if($_SESSION["userid"] == $userid){ echo "<a href='mp.php?&about&edit=bbm' id='abtbutton' class='btn btn-primary btn-xs'>edit</a>";}
								echo "</td>"; }?>
								<?php if(isset($_REQUEST["edit"]) and isset($_REQUEST["about"]) and $_REQUEST["edit"] == "bbm") { echo "<td>"; 
								echo"
								<form action='process.php' method='post'>
								<div class='col-sm-7'>
								<input type='text' name='newfield' value='$contactinfo[bbmpin]' class='form-control'/>
								</div>
								<input type='hidden' name='myid' value='$userid' />
								<input type='hidden' name='column' value='bbmpin' />
								<div class='col-sm-2'>
<button type='submit' name='contactupdate' data-toggle='tooltip' title='Edit this Information' style='margin-top: 5px;' class='btn btn-primary btn-xs'>done</button>
								</div>
								</form>
								";
								
								echo "</td>"; } ?>
								</tr>		
											
								<!-- Twitter -->		
								<tr>
								<td>Twitter ID:</td>
								<?php if(!isset($_REQUEST["edit"]) and isset($_REQUEST["about"])) { echo "<td>"; 
							echo "$contactinfo[twitterid]";
							if($_SESSION["userid"] == $userid){ echo "<a href='mp.php?&about&edit=twitter' id='abtbutton' class='btn btn-primary btn-xs'>edit</a>";}
								echo "</td>"; }?>
								<?php if(isset($_REQUEST["edit"]) and isset($_REQUEST["about"]) and $_REQUEST["edit"] == "twitter") { echo "<td>"; 
								echo"
								<form action='process.php' method='post'>
								<div class='col-sm-7'>
								<input type='text' name='newfield' value='$contactinfo[twitterid]' class='form-control'/>
								</div>
								<input type='hidden' name='myid' value='$userid' />
								<input type='hidden' name='column' value='twitterid' />
								<div class='col-sm-2'>
<button type='submit' name='contactupdate' data-toggle='tooltip' title='Edit this Information' style='margin-top: 5px;' class='btn btn-primary btn-xs'>done</button>
								</div>
								</form>
								";
								
								echo "</td>"; } ?>
								</tr>
								<!-- Address -->		
								<tr>
								<td>Contact Address:</td>
								<?php if(!isset($_REQUEST["edit"]) and isset($_REQUEST["about"])) { echo "<td>"; 
							echo "$contactinfo[address]";
							if($_SESSION["userid"] == $userid){ echo "<a href='mp.php?&about&edit=add' id='abtbutton' class='btn btn-primary btn-xs'>edit</a>";}
								echo "</td>"; }?>
								<?php if(isset($_REQUEST["edit"]) and isset($_REQUEST["about"]) and $_REQUEST["edit"] == "add") { echo "<td>"; 
								echo"
								<form action='process.php' method='post'>
								<div class='col-sm-7'>
								<input type='text' name='newfield' value='$contactinfo[address]' class='form-control'/>
								</div>
								<input type='hidden' name='myid' value='$userid' />
								<input type='hidden' name='column' value='address' />
								<div class='col-sm-2'>
<button type='submit' name='contactupdate' data-toggle='tooltip' title='Edit this Information' style='margin-top: 5px;' class='btn btn-primary btn-xs'>done</button>
								</div>
								</form>
								";
								
								echo "</td>"; } ?>
								</tr>			
								<!-- Website -->		
								<tr>
								<td>Website:</td>
								<?php if(!isset($_REQUEST["edit"]) and isset($_REQUEST["about"])) { echo "<td>"; 
							echo "$contactinfo[website]";
							if($_SESSION["userid"] == $userid){ echo "<a href='mp.php?&about&edit=website' id='abtbutton' class='btn btn-primary btn-xs'>edit</a>";}
								echo "</td>"; }?>
								<?php if(isset($_REQUEST["edit"]) and isset($_REQUEST["about"]) and $_REQUEST["edit"] == "website") { echo "<td>"; 
								echo"
								<form action='process.php' method='post'>
								<div class='col-sm-7'>
								<input type='text' name='newfield' value='$contactinfo[website]' class='form-control'/>
								</div>
								<input type='hidden' name='myid' value='$userid' />
								<input type='hidden' name='column' value='website' />
								<div class='col-sm-2'>
<button type='submit' name='contactupdate' data-toggle='tooltip' title='Edit this Information' style='margin-top: 5px;' class='btn btn-primary btn-xs'>done</button>
								</div>
								</form>
								";
								
								echo "</td>"; } ?>
								</tr>
								<tr>
								<td>Last Updated:</td><td><?php echo date('d \of\ F Y, h:i:a', $contactinfo['time']); ?></td>
								</tr>
								<?php } else { ?>
								<tr>
								<td>Not yet Updated...</td>
								</tr>
								<?php } ?>
								</table>
									
										  </div>
									  </div>
									  
									  	<div class="panel panel-default">
										<?php 
									  $pquery = mysql_query("select * from `personals` where id='$userid'");
									  $pinfo = mysql_fetch_assoc($pquery);
									   ?> 
										 <div class="panel-heading"><?php echo (empty($pinfo)) ? "<a href='comp_profile_step_2.php?&editfield' class='pull-right badge' >Edit Now <i class='fa fa-angle-double-right'></i></a>" : "" ; ?><h4><?php echo"$thisprofile[firstname]'s"; ?> <b>Personal Information</b></h4></div>
										  <div class="panel-body">
										   
											<table class="table table-hover">
								<?php if (!empty($pinfo)) { ?>
								<tr>
								<td>Full Name:</td>
								<?php if(!isset($_REQUEST["edit"]) and isset($_REQUEST["about"])) { echo "<td>"; 
							echo "$pinfo[lastname] $pinfo[middlename] $pinfo[firstname]";
							if($_SESSION["userid"] == $userid){ echo "<a href='mp.php?&about&edit=name' id='abtbutton' class='btn btn-primary btn-xs'>edit</a>";}
								echo "</td>"; }?>
								<?php if(isset($_REQUEST["edit"]) and isset($_REQUEST["about"]) and $_REQUEST["edit"] == "name") { echo "<td>"; 
								echo"
								<form action='process.php' method='post'>
								<div class='col-sm-7'>
								<input type='text' name='newfield' value='$pinfo[middlename]' class='form-control'/>
								</div>
								<input type='hidden' name='myid' value='$userid' />
								<input type='hidden' name='column' value='middlename' />
								<div class='col-sm-2'>
<button type='submit' name='pupdate' data-toggle='tooltip' title='Edit this Information' style='margin-top: 5px;' class='btn btn-primary btn-xs'>done</button>
								</div>
								</form>
								";
								
								echo "</td>"; } ?>
								</tr>
								
								<tr>
								<td>Gender:</td>
								<?php if(!isset($_REQUEST["edit"]) and isset($_REQUEST["about"])) { echo "<td>"; 
							echo "$pinfo[gender]";
							if($_SESSION["userid"] == $userid){ echo "<a href='mp.php?&about&edit=gender' id='abtbutton' class='btn btn-primary btn-xs'>edit</a>";}
								echo "</td>"; }?>
								<?php if(isset($_REQUEST["edit"]) and isset($_REQUEST["about"]) and $_REQUEST["edit"] == "gender") { echo "<td>"; 
								echo"
								<form action='process.php' method='post'>
								<div class='col-sm-7'>
								<select name='newfield' class='form-control'>
								<option value=''>Choose</option>
								<option value='Male'>Male</option>
								<option value='Female'>Female</option>
								</select>
								</div>
								<input type='hidden' name='myid' value='$userid' />
								<input type='hidden' name='column' value='gender' />
								<div class='col-sm-2'>
<button type='submit' name='pupdate' data-toggle='tooltip' title='Edit this Information' style='margin-top: 5px;' class='btn btn-primary btn-xs'>done</button>
								</div>
								</form>
								";
								
								echo "</td>"; } ?>
								</tr>
								
								<tr>
								<td>Nick Name:</td>
								<?php if(!isset($_REQUEST["edit"]) and isset($_REQUEST["about"])) { echo "<td>"; 
							echo "$pinfo[nickname]";
							if($_SESSION["userid"] == $userid){ echo "<a href='mp.php?&about&edit=nickname' id='abtbutton' class='btn btn-primary btn-xs'>edit</a>";}
								echo "</td>"; }?>
								<?php if(isset($_REQUEST["edit"]) and isset($_REQUEST["about"]) and $_REQUEST["edit"] == "nickname") { echo "<td>"; 
								echo"
								<form action='process.php' method='post'>
								<div class='col-sm-7'>
								<input type='text' name='newfield' value='$pinfo[nickname]' class='form-control'/>
								</div>
								<input type='hidden' name='myid' value='$userid' />
								<input type='hidden' name='column' value='nickname' />
								<div class='col-sm-2'>
<button type='submit' name='pupdate' data-toggle='tooltip' title='Edit this Information' style='margin-top: 5px;' class='btn btn-primary btn-xs'>done</button>
								</div>
								</form>
								";
								
								echo "</td>"; } ?>
								</tr>
										
									<tr>
								<td>My Passion:</td>
								<?php if(!isset($_REQUEST["edit"]) and isset($_REQUEST["about"])) { echo "<td>"; 
							echo "$pinfo[passion]";
							if($_SESSION["userid"] == $userid){ echo "<a href='mp.php?&about&edit=passion' id='abtbutton' class='btn btn-primary btn-xs'>edit</a>";}
								echo "</td>"; }?>
								<?php if(isset($_REQUEST["edit"]) and isset($_REQUEST["about"]) and $_REQUEST["edit"] == "passion") { echo "<td>"; 
								echo"
								<form action='process.php' method='post'>
								<div class='col-sm-7'>
								<textarea name='newfield' class='form-control' >$pinfo[passion] </textarea>
								</div>
								<input type='hidden' name='myid' value='$userid' />
								<input type='hidden' name='column' value='passion' />
								<div class='col-sm-2'>
<button type='submit' name='pupdate' data-toggle='tooltip' title='Edit this Information' style='margin-top: 5px;' class='btn btn-primary btn-xs'>done</button>
								</div>
								</form>
								";
								
								echo "</td>"; } ?>
								</tr>
								
								<tr>
								<td>Hobby:</td>
								<?php if(!isset($_REQUEST["edit"]) and isset($_REQUEST["about"])) { echo "<td>"; 
							echo "$pinfo[hobby]";
							if($_SESSION["userid"] == $userid){ echo "<a href='mp.php?&about&edit=hobby' id='abtbutton' class='btn btn-primary btn-xs'>edit</a>";}
								echo "</td>"; }?>
								<?php if(isset($_REQUEST["edit"]) and isset($_REQUEST["about"]) and $_REQUEST["edit"] == "hobby") { echo "<td>"; 
								echo"
								<form action='process.php' method='post'>
								<div class='col-sm-7'>
								<input type='text' name='newfield' value='$pinfo[hobby]' class='form-control'/>
								</div>
								<input type='hidden' name='myid' value='$userid' />
								<input type='hidden' name='column' value='hobby' />
								<div class='col-sm-2'>
<button type='submit' name='pupdate' data-toggle='tooltip' title='Edit this Information' style='margin-top: 5px;' class='btn btn-primary btn-xs'>done</button>
								</div>
								</form>
								";
								
								echo "</td>"; } ?>
								</tr>
								
								<tr>
								<td>About Me:</td>
								<?php if(!isset($_REQUEST["edit"]) and isset($_REQUEST["about"])) { echo "<td>"; 
							echo "$pinfo[about]";
							if($_SESSION["userid"] == $userid){ echo "<a href='mp.php?&about&edit=about' id='abtbutton' class='btn btn-primary btn-xs'>edit</a>";}
								echo "</td>"; }?>
								<?php if(isset($_REQUEST["edit"]) and isset($_REQUEST["about"]) and $_REQUEST["edit"] == "about") { echo "<td>"; 
								echo"
								<form action='process.php' method='post'>
								<div class='col-sm-7'>
								<textarea name='newfield' class='form-control' > $pinfo[about] </textarea>
								</div>
								<input type='hidden' name='myid' value='$userid' />
								<input type='hidden' name='column' value='about' />
								<div class='col-sm-2'>
<button type='submit' name='pupdate' data-toggle='tooltip' title='Edit this Information' style='margin-top: 5px;' class='btn btn-primary btn-xs'>done</button>
								</div>
								</form>
								";
								
								echo "</td>"; } ?>
								</tr>
								<tr>
								<td>Last Updated:</td><td><?php echo date('d \of\ F Y, h:i:a', $pinfo['time']); ?></td>
								</tr>
								<?php } else { ?>
								<tr>
								<td>Not yet updated...</td>
								</tr>
								<?php } ?>
								</table>
									
										  </div>
									  </div>
								
									  
									  </div>
									  <div class="row">
									  
									  	  
									   	<div class="panel panel-default">
										 <?php 
									  $equery = mysql_query("select * from `eduinfo` where id='$userid'");
									  $einfo = mysql_fetch_assoc($equery);
										?> 
										 <div class="panel-heading"><?php echo (empty($einfo)) ? "<a href='comp_profile.php?&editfield' class='pull-right badge' >Edit Now <i class='fa fa-angle-double-right'></i></a>" : "" ; ?><h4><?php echo"$thisprofile[firstname]'s"; ?> <b>Educational Information</b></h4></div>
										  <div class="panel-body">
										  
									<table class="table table-hover">
								<?php if (!empty($einfo)) { ?>
								<tr>
								<td>Faculty:</td>
								<?php if(!isset($_REQUEST["edit"]) and isset($_REQUEST["about"])) { echo "<td>"; 
							echo "$einfo[faculty]";
							if($_SESSION["userid"] == $userid){ echo "<a href='mp.php?&about&edit=faculty' id='abtbutton' class='btn btn-primary btn-xs'>edit</a>";}
								echo "</td>"; }?>
								<?php if(isset($_REQUEST["edit"]) and isset($_REQUEST["about"]) and $_REQUEST["edit"] == "faculty") { echo "<td>"; 
								echo"
								<form action='process.php' method='post'>
								<div class='col-sm-7'>
								<input name='newfield' type='text' class='form-control' value='$einfo[faculty]' /> 
								</div>
								<input type='hidden' name='myid' value='$userid' />
								<input type='hidden' name='column' value='faculty' />
								<div class='col-sm-2'>
<button type='submit' name='eduupdate' data-toggle='tooltip' title='Edit this Information' style='margin-top: 5px;' class='btn btn-primary btn-xs'>done</button>
								</div>
								</form>
								";
								
								echo "</td>"; } ?>
								</tr>
								
								<tr>
								<td>Department:</td>
								<?php if(!isset($_REQUEST["edit"]) and isset($_REQUEST["about"])) { echo "<td>"; 
							echo "$einfo[department]";
							if($_SESSION["userid"] == $userid){ echo "<a href='mp.php?&about&edit=department' id='abtbutton' class='btn btn-primary btn-xs'>edit</a>";}
								echo "</td>"; }?>
								<?php if(isset($_REQUEST["edit"]) and isset($_REQUEST["about"]) and $_REQUEST["edit"] == "department") { echo "<td>"; 
								echo"
								<form action='process.php' method='post'>
								<div class='col-sm-7'>
								<input name='newfield' type='text' class='form-control' value='$einfo[department]' /> 
								</div>
								<input type='hidden' name='myid' value='$userid' />
								<input type='hidden' name='column' value='department' />
								<div class='col-sm-2'>
<button type='submit' name='eduupdate' data-toggle='tooltip' title='Edit this Information' style='margin-top: 5px;' class='btn btn-primary btn-xs'>done</button>
								</div>
								</form>
								";
								
								echo "</td>"; } ?>
								</tr>
								<tr>
								<td>Level:</td>
								<?php if(!isset($_REQUEST["edit"]) and isset($_REQUEST["about"])) { echo "<td>"; 
							echo "$einfo[level] Level";
							if($_SESSION["userid"] == $userid){ echo "<a href='mp.php?&about&edit=level' id='abtbutton' class='btn btn-primary btn-xs'>edit</a>";}
								echo "</td>"; }?>
								<?php if(isset($_REQUEST["edit"]) and isset($_REQUEST["about"]) and $_REQUEST["edit"] == "level") { echo "<td>"; 
								echo"
								<form action='process.php' method='post'>
								<div class='col-sm-7'>
								<input name='newfield' type='text' class='form-control' value='$einfo[level]' /> 
								</div>
								<input type='hidden' name='myid' value='$userid' />
								<input type='hidden' name='column' value='level' />
								<div class='col-sm-2'>
<button type='submit' name='eduupdate' data-toggle='tooltip' title='Edit this Information' style='margin-top: 5px;' class='btn btn-primary btn-xs'>done</button>
								</div>
								</form>
								";
								
								echo "</td>"; } ?>
								</tr>
											
								<tr>
								<td>University:</td><td>University of Ilorin</td>
								</tr>
								<td>Last Updated:</td><td><?php echo date('d \of\ F Y, h:i:a', $einfo['time']); ?></td>
								</tr>
								<?php } else { ?>
								<tr>
								<td>Not yet uploaded...</td>
								</tr>
								<?php } ?>
								</table>
									
										  </div>
									  </div>
									  
									  </div>
								
									</div>
						<?php } ?>
						
								   
								  </div>
								  
								  <!-- main col right -->
								
							   </div><!--/row-->
							
							 					
							  
							</div><!-- /col-9 -->
						</div><!-- /padding -->
					</div>
					<!-- /main -->
				
				  
				</div>
			</div>
		</div>


			<!--post modal-->
		<script>
		function sub()
		{
		document.getElementById("formid").submit();
		
		}
		</script>
		<div id="postModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog">
		  <div class="modal-content">
			  <div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					Update Status
			  </div>
			  <div class="modal-body">
				  <form id="formid" class="form center-block" method="post" action="process.php">
					<div class="form-group">
					  <textarea name="statusupdate" class="form-control input-lg" autofocus="" placeholder="What do you want to share?"></textarea>
					</div>
					<input type="hidden" name="uid" value="<?php echo"$userid"; ?>" />
				  </form>
			  </div>
			  <div class="modal-footer">
				  <div>
				  <button class="btn btn-primary btn-sm" onclick='sub();' type="submit" data-dismiss="modal" aria-hidden="true">Post</button>
					
				  </div>	
			  </div>
		  </div>
		  </div>
		</div>
		
<?php include("footer.php"); ?>