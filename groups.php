
<?php error_reporting(0);
if(isset($_REQUEST["groupinvites"])){ include("groupinvites.php"); }
elseif(isset($_REQUEST["invites"])){ include("invites.php"); }
else{ 
ob_start();
session_start();
if(!isset($_SESSION["email"]) and !isset($_SESSION["userid"]))
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
	//unset($_SESSION["path"]);
	$queryp = mysql_query("select * from personals where id='$userid'");
	$pinfo = mysql_fetch_assoc($queryp);
	
	//find out online-but offline users
	/*$d = mysql_query("SELECT * FROM `profile`");
	while($t = mysql_fetch_assoc($d))
	{
		$tid = $t["id"];
		if(!isset($_SESSION[$tid]))
		{
			$query = "UPDATE profile SET loginstatus='offline' WHERE id = '$_SESSION[$tid]'";
			$do = mysql_query($query);
		}
	}*/
	if(isset($_REQUEST["grpname"])){ $_SESSION["grpname"] = $_REQUEST["grpname"]; }
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
		<link rel="stylesheet" type="text/css" href="css/tooltip-comic.css" />
		<!--[if IE]>
  		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
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
					
					<div class="column col-xs-10" id="main">
					 		
					<?php include("header.php"); ?>
					
						<div class="padding">
						
							<div class="full col-sm-12">
							  
								<!-- content -->                      
								<div class="row">
						<!-- right sidebar -->
						<?php include("adverts.php"); ?>
					<!-- /right sidebar -->	
								
								  	 <?php 
								if(isset($_REQUEST["coment"])){ include("comment.html"); }
								if(isset($_REQUEST["addfriend"])){ include("addfriend.php"); }
																
					?>
								 <!-- main col left --> 
								 <div class="col-sm-9">
								<!-------------------------------------------------------------------->
									<div class="col-sm-8 pull-left">
								<?php if(isset($_REQUEST["allgroups"])) {?>
								
								<?php $squery = mysql_query("SELECT * FROM groups");
									  $nrows = mysql_num_rows($squery);
								?>
							
								
								<!--- search result ------>
								 <div class="panel panel-default" >
										 <div class="panel-heading"><h6> <?php if($nrows > 0){ ?><i class="fa fa-search"></i> &nbsp; All Groups (<?php echo"$nrows"; ?>) <?php } if($nrows==0){echo"No Groups has been created!";} ?></h6></div>
										  <div class="panel-body">
										
											<table style="font-size: 10px !important;" border="0" cellpadding="10">
											<tr><td colspan="3"><a href="home.php?creategroup" class="btn btn-primary btn-xs">Create New Group</a></td></tr>
											<?php while($searchresult = mysql_fetch_assoc($squery)){ ?>
											<tr>
											<td style="padding: 7px; padding-top: 0px; margin-top: -5px;">
											
											<?php
											$imagesDir = 'avatars/';

											$images = glob($imagesDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

											$randomImage = $images[array_rand($images)];

											echo "<img src='$randomImage'  class='img-responsive img-user' style='border: 1px solid rgba(0,0,0,0.2); border-radius: 5px; padding: 4px; display: inline-block;  max-width: 50px; max-height: 50px; margin-top: -10px;' />";
											
											?>
											
											</td>
											<?php
											$inthisgroup = mysql_query("select * from `$searchresult[groupname]`");
											$num_rows = mysql_num_rows($inthisgroup);
											
											//$numm = mysql_fetch_assoc($inthisgroup);
											//echo $numm["memberid"];
											?>
											<td><a href="<?php echo"groups.php?&profile=$_SESSION[userid]&grpname=$searchresult[groupname]"; ?>"><strong><?php echo ucfirst(strtolower($searchresult['groupname'])); ?></strong></a><br />
											<?php echo ($num_rows == 0) ? "This Group Has No Members Currently" : "<b>$num_rows</b> Members"; ?><br />
											Created & Administrated by - <a href="<?php echo"mp.php?&profile=$searchresult[creator]&$searchresult[creatorname]"; ?>"><?php echo strtoupper($searchresult['creatorname']); ?></a><br />
											<p>Created on <?php echo date('d M Y, h:i A', $searchresult['time']); ?></p>
											<?php $j = mysql_query("SELECT * from `$searchresult[groupname]` where memberid='$_SESSION[userid]' and memberstatus='member'" );
												  $jrs = mysql_fetch_assoc($j);
											if(empty($jrs)){
											?>
									<p><span class="label label-danger">Not a Member</span> &nbsp;&nbsp; <a href="process.php?grpn=<?php $rand = rand(); echo"$searchresult[groupname]&joingroup=$rand"; ?>" style="color: #fff;" class="btn btn-default btn-primary btn-xs">Join Group</a></p>		
											<?php }else{ ?>
											<p><span class="label label-success">You are a Member</span> &nbsp;&nbsp; </p>
											<?php } ?>
											</td>
											</tr>
											  <?php } ?>
										</table>
											
										  </div>
									  </div>
								<!------ Search Ended ------->
								<?php } else { ?>
																
								<?php if(isset($_REQUEST["invitesent"])){ ?>
							   
								  <div class="alert alert-info alert-dismissable" style="background-color: rgba(102,0,51,0.5);"><!--alert -->
									<button  type="button" class="close" data-dismiss ="alert">
									<strong style="color:#fff">X</strong>
									</button>
						
									<span style="color: #fff;">
									<center><a href="#" style="color: #fff;">Your Group's Invitation has been sent to all your friends!</a>
									</center>
									</span>
									</div><!--alert -->
								<?php } ?>
								<?php if(isset($_REQUEST["justjoined"])){ ?>
							   
								  <div class="alert alert-info alert-dismissable" style="background-color: rgba(102,0,51,0.5);"><!--alert -->
									<button  type="button" class="close" data-dismiss ="alert">
									<strong style="color:#fff">X</strong>
									</button>
						
									<span style="color: #fff;">
									<center><a href="#" style="color: #fff;">You have Successfully Joined <?php echo"$_REQUEST[grpname]"; ?></a>
									</center>
									</span>
									</div><!--alert -->
								<?php } ?>
									  <div class="well ">
									  <script>
											  function FilegroupOption()
											{
											  document.getElementById("thegroupfile").click();
											 									
											}
											
											function sumittt()
												{
												document.getElementById("formgroup").submit();
												
												}
										
											</script>
									<?php $grouprestrict = mysql_query("SELECT * from `$_REQUEST[grpname]` where memberid='$_SESSION[userid]' and memberstatus='member'");
										  $restrict = mysql_fetch_assoc($grouprestrict);
									?>
									<?php if($restrict){ ?>
										   <form id="formgroup" class="form-horizontal" role="form" action="process.php" method="post" class="form-horizontal" enctype='multipart/form-data'>
											<h4>Post in <?php echo ucwords(strtolower($_REQUEST["grpname"])); ?></h4>
											 <div class="form-group" style="padding:14px;">
											 <div class="input-group">
										 <div class="input-group-addon" style="width: 80px; max-width: 90px; max-height: 90px; !important;">
										  <?php if(!$_REQUEST['post'] or $_REQUEST["post"]){echo(file_exists("profilepictures/".$userid."/".$userid.".jpg") or file_exists("profilepictures/".$userid."/".$userid.".png")) ? "<img src='profilepictures/$userid/$userid.jpg' style='border-radius: 7px; width: 50px; height: 41px; border: 1px solid #fff;' class='img-responsive' />" : "";} ?>
										</div>
					
										<textarea style='' rows="4" cols="50" onkeypress="alertme();" maxlength='500' class="form-control" placeholder="<?php echo"$thisprofile[firstname]"; ?>, What's on your mind?" name="status"><?php echo"$_REQUEST[post]"; ?></textarea>
									</div>
								</div>
											<input type="file" id="thegroupfile" name="image" style="display:none;" onchange="sumittt();" /> 
											<?php echo "<img src='$_REQUEST[img]' style='max-width: 300px; height: auto; margin-bottom: 10px;' class='img-responsive;' />"; ?>
										<input type="hidden" name="thisidgroup" value="<?php echo"$_SESSION[userid]"; ?>" />
										<input type="hidden" name="gname" value="<?php echo"$_REQUEST[grpname]"; ?>" />
											<button type="submit" name="groupost" class="btn btn-primary pull-right" type="button">Post</button>
			<ul class="list-inline"><li class="tooltip tooltip-effect-5"><a class="tooltip-item" href="#" onclick="FilegroupOption();return;" ><i class="fa fa-camera"></i></a><span class="tooltip-content tooltip-text" style="width: 100px; margin-left: -50px;">Upload Picture</span></li></ul>		 								
										  </form>
								    <?php } else { ?>
									
				<a href="process.php?grpn=<?php $rand = rand(); echo"$_REQUEST[grpname]&joingroup=$rand"; ?>" style="color: #fff;" class="btn btn-danger form-control"> You are not a Member of <b><?php echo $_REQUEST["grpname"]; ?></b> Click to Join </a>					
									
									<?php } ?>
									  </div>
									  <?php 	
									  //$postquery = mysql_query("SELECT * from `statusposts` WHERE `posterid`='$userid' or `posterid`='$friendid' order by time desc");
									  $postquery = mysql_query("SELECT * from `grouposts` order by time desc");
									  
									  while($post = mysql_fetch_assoc($postquery)) { 
									  $fq = mysql_query("SELECT * from `$_REQUEST[grpname]` where memberid='$_SESSION[userid]' and memberstatus='member'");
									  $friendid = mysql_fetch_assoc($fq);
									  
									  if(isset($friendid["id"]) and $friendid["memberstatus"] == "member" and $post["groupname"] == $_REQUEST["grpname"]) {
									  ?>
									  
									  <div class="row">
									  <div class="panel">
									 
									  <div class="panel-heading" style="height: 30px;">
										<table>
										<tr><td>
									  <div class="col-sm-3 ttooltip ttooltip-effect-2" style="margin-left: -20px;">
									  <?php
									  $tooltip = mysql_query("SELECT * FROM statustable where id='$post[posterid]' order by time desc");
									  $ttstatus = mysql_fetch_assoc($tooltip);
											
													if(is_dir("profilepictures/".$post["posterid"].""))
													{
														$dh = scandir("profilepictures/".$post["posterid"]."");
																																					
														echo "<img src='profilepictures/$post[posterid]/$dh[2]' style='max-width: 50px; max-height: 50px;' class='img-responsive img-user' />";
														
													}
													else{
														echo "<img src='images/find_user.png'  class='img-responsive img-user' style='max-width: 50px; max-height: 50px;' />";
													}
													
									if(!empty($ttstatus["status"])){				
										?>
									<span class="ttooltip-content"><?php echo $ttstatus["status"]; ?></span>
						<div class="ttooltip-shape">
							<svg viewBox="0 0 200 150" preserveAspectRatio="none" style="height: 150px;">
								<polygon points="198.75,37.671 184.334,107.653 104.355,136.679 100,146.676 96.292,136.355 16.312,107.653 3.25,37.671"/>
							</svg>
						</div>
									<?php } ?>	  
									  </div>
									  </td>
									  <td>
									  <?php $rowquery = mysql_query("select * from comments where postid='$post[postid]'"); 
											$commentrow = mysql_num_rows($rowquery);
									  ?>
									  <div class="displayname"><a href="<?php echo"mp.php?profile=$post[posterid]&$post[postername]"; ?>"><?php echo"$post[postername]"; ?></a><span  style="font-size: 9px; color: #666666; text-align: right; width: 240px;  display: inline-block;"><i class="fa fa-comments"></i> <?php echo (!empty($commentrow)) ? "$commentrow Comments" : "0 Comments" ; ?> </span><br />
									  <span style="font-size: 9px; color: #666666; text-align: left; padding-right: 30px;"><i class="fa fa-globe"></i> <?php echo date('F d Y, \a\t\ h:i a', $post["time"]); ?></span></div>
									   </td>
									   </tr>
									   </table>
									  </div>
									 
									  <br clear="all" />
								   <hr />
										<div class="panel-body" style="margin-top: -20px; margin-bottom: -30px;">
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
								 <table cellpadding="5" width="450" >
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
								<?php }  } }?>
								 
									</div>
									
								   <div class="col-sm-4 pull-right" >
								   <div class="row">
									 <?php 
									  $query = mysql_query("select * from profile where loginstatus='online' and id!='$userid'");
									  $query1 = mysql_query("select * from profile where loginstatus='online' and id!='$userid'");
									   $online1 = mysql_fetch_assoc($query1);
									   $fonlinecheck = substr($_SESSION["userid"], 0,33);
									  $que1 = mysql_query("select * from $fonlinecheck where id='$online1[id]'");
									  $rw = mysql_num_rows($que1);
											
									  ?>
									 
									  <div class="panel panel-default" >
									   
										 <div class="panel-heading"><h6> <i class="fa fa-users" style="color: green;"></i> Friends Online (<?php echo (!empty($rw)) ? "$rw" : "0" ; ?>)</h6></div>
										  <div class="panel-body">
										
											<table style="font-size: 9px !important;" border="0">
											<?php while($online = mysql_fetch_assoc($query)){ 
											
											$que = mysql_query("select * from $fonlinecheck where id='$online[id]'");
											$onlinechecked = mysql_fetch_assoc($que);
											
											if($onlinechecked) {
											?>
											<tr>
											<td style="padding: 7px; padding-top: 0px; margin-top: -5px;">
											<?php
											
													if(is_dir("profilepictures/".$online["id"].""))
													{
														$dh = scandir("profilepictures/".$online["id"]."");
																																					
														echo "<a href='mp.php?&profile=$online[id]&$online[firstname]$online[lastname]'><img src='profilepictures/$online[id]/$dh[2]' style='display: inline-block;  max-width: 30px; max-height: 30px; margin-top: -10px;' class='img-responsive img-user' /></a>";
														
													}
													else{
														echo "<img src='images/find_user.png'  class='img-responsive img-user' style='border-radius: 50%; max-width: 40px; max-height: 40px;' />";
													}
													
											
								?>
											</td><td><a href="<?php echo"mp.php?&profile=$online[id]&$online[firstname]$online[lastname]"; ?>"><strong><?php echo"$online[firstname] $online[lastname]"; ?></strong><br />
											<p><?php echo ($online["lastvisit"] == "0000-00-00 00:00:00") ? "New User" : "Last Available on $online[lastvisit]"; ?></p>
											</td>
											</tr>
											<?php } }?>
										</table>
											
										  </div>
									  </div>
									
									  <div class="panel panel-default" >
									   <?php 
									   $rand = rand();
									  $query = mysql_query("select * from profile where id!='$_SESSION[userid]'");
									  
									  $onlinerw = mysql_num_rows($query);
									  ?>
										 <div class="panel-heading"><h6><i class="fa fa-male" style="color: purple;"></i> Connect with friends</h6></div>
										  <div class="panel-body">
											<table style="font-size: 9px !important;" border="0">
											<?php while($friendsuggest = mysql_fetch_assoc($query)){ ?>
											<?php 
											$friendcheck = substr($_SESSION["userid"], 0,33);
											
											$query1 = mysql_query("select * from $friendcheck where id='$friendsuggest[id]'");
											$checked = mysql_fetch_assoc($query1);
											
											
											if(!$checked) { 
									  ?>
											<tr>
											<td style="padding: 7px; padding-top: 0px; margin-top: -5px;">
											<?php
											
													if(is_dir("profilepictures/".$friendsuggest["id"].""))
													{
														$dh = scandir("profilepictures/".$friendsuggest["id"]."");
																																					
														echo "<a href='mp.php?&profile=$friendsuggest[id]&$friendsuggest[firstname]$friendsuggest[lastname]'><img src='profilepictures/$friendsuggest[id]/$dh[2]' style='display: inline-block;  max-width: 30px; max-height: 30px; margin-top: -10px;' class='img-responsive img-user' /></a>";
														
													}
													else{
														echo "<img src='images/find_user.png'  class='img-responsive img-user' style='border-radius: 50%; max-width: 40px; max-height: 40px;' />";
													}
													
											
								?>
											</td><td><a href="<?php echo"mp.php?&profile=$friendsuggest[id]&$friendsuggest[firstname]$friendsuggest[lastname]"; ?>"><strong><?php echo"$friendsuggest[firstname] $friendsuggest[lastname]"; ?></strong><br />
											<p><?php echo ($friendsuggest["lastvisit"] == "0000-00-00 00:00:00") ? "New User" : "Last Available on $friendsuggest[lastvisit]"; ?></p>
									<p><a href="?&addfriend=<?php echo"$friendsuggest[id]"; ?>" class="btn btn-default btn-xs">Connect</a>
											</p>
											</td>
											</tr>
											<?php } ?>
										<?php
										
										} ?>
										</table>
											
										  </div>
									  </div>
									  
									  
									  
									  
									  </div>
								
									</div>
								
					
						
								   
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
<?php } ?>