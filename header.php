		<!-- top nav -->
		<?php error_reporting(0);
	include("temp/database.php");
	$dataget = mysql_query("SELECT * FROM `profile` where `id`='$userid'");
	$thisprofile = mysql_fetch_assoc($dataget);
	date_default_timezone_set('Africa/Lagos');
	
	
?>
							<div class="navbar navbar-blue navbar-static-top ">  
							<div class="navbar-header">
							  <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							  </button>
							  <a href="home.php" class="navbar-brand logo">uc</a>
							</div>
							<nav class="collapse navbar-collapse" role="navigation">
							<form action="home.php" method="post" class="navbar-form navbar-left">
								<div class="input-group input-group-sm" style="max-width:400px;">
								<input class="form-control" placeholder="Search for friends" name="search-term" id="search-term" type="text" list="srch" onkeydown="setTimeout(searchfriend,192,'srch','srch')" />
								<datalist id="srch"></datalist>
								  <div class="input-group-btn">
									<button class="btn btn-default" name="search" type="submit"><i class="glyphicon glyphicon-search"></i></button>
								  </div>
								</div>
							</form>
							<ul class="nav navbar-nav">
							  <li>
								<a href="home.php"><i class="glyphicon glyphicon-home"></i> Home</a>
							  </li>
							  <li>
								<a href="#postModal" role="button" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Status</a>
							  </li>
							     <li class="dropdown messages-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								  <i class="fa fa-envelope-o"></i>
								  <span class="label label-success" id="navmsg"></span>
								</a>
								<ul class="dropdown-menu">
								  <li class="header">You have <span id="msgp"></span> messages</li>
								  <li>
									<!-- inner menu: contains the actual data -->
									<ul class="menu" style="color: #000;">
	<?php $query1 = "SELECT * FROM mail WHERE `reciever` = '$_SESSION[username]' AND `status` = 'unread' ORDER BY time DESC LIMIT 5";
	$result1 = mysql_query($query1);
	while($mailbox = mysql_fetch_array($result1))
	{ ?>
	  <li><!-- start message -->
		<a href="read.php?mid=<?php echo $mailbox["id"]; ?>">
		  <div class="pull-left">
		  <?php 
		  if(file_exists("profilepictures/$mailbox[sender]/$mailbox[sender].jpg")){
		  echo "<img src='profilepictures/$mailbox[sender]/$mailbox[sender].jpg' class='img-user img-responsive' alt='User Image' />";
		   }
		  elseif(file_exists("profilepictures/$mailbox[sender]/$mailbox[sender].png")){
		  echo "<img src='profilepictures/$mailbox[sender]/$mailbox[sender].png' class='img-user' alt='User Image' />";
		  }
		  else echo "<img src='images/find_user.png' class='img-user' alt='User Image' />";
		  ?>
		
		  </div>
		
		  <h4>
			<?php echo substr($mailbox[subject], 0,30);echo"..."; ?></br>		   
		  </h4>
		   <small style="color: rgba(0,0,0,0.6);"><i class="fa fa-clock-o"></i> <?php  echo date('d-D M Y, h:i:a', $mailbox["time"]); ?></small>
		  </a>
	  </li><!-- end message -->
<?php 
	} 
?>
									</ul>
								  </li>

								  <li class="footer"><a href="home.php?messages">See All Messages</a></li>
								</ul>
							  </li>
			 <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag"></i>
                  <span class="label label-warning" id="not"></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have <span id="value"></span> friend requests</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu" style="color: #000;">
	<?php $iid = substr($_SESSION['userid'], 0,33);
	$query = "SELECT * FROM $iid WHERE status = 'pending' and email != '$_SESSION[email]' ORDER BY time DESC LIMIT 5";
	$req = mysql_query($query);
	while($res = mysql_fetch_assoc($req))
	{ ?>
	  <li><!-- start message -->
		<a href="requests.php?fid=<?php echo"$res[id]"; ?>">
		<table>
		<tr><td>
		  <div class="pull-left" style="padding-right: 10px;">
		  <?php 
		  if(file_exists("profilepictures/$res[id]/$res[id].jpg")){
		  echo "<img src='profilepictures/$res[id]/$res[id].jpg' class='img-responsive img-user' width='60' height='60' style='border: 1px solid rgba(0,0,0,0.4); border-radius: 5px;' alt='User Image' />";
		   }
		  elseif(file_exists("profilepictures/$res[id]/$res[id].png")){
		  echo "<img src='profilepictures/$res[id]/$res[id].png' class='img-user img-responsive' width='50' height='50' style='border: 1px solid rgba(0,0,0,0.4); border-radius: 5px;' alt='User Image' />";
		  }
		  else echo "<img src='images/find_user.png' class='img-user img-responsive' style='border: 1px solid rgba(0,0,0,0.4); border-radius: 5px;' alt='User Image' width='50' height='50'/>";
		  ?>
		
		  </div>
		</td><td>
		  <h4 style="font-size: 11px;">
			<?php $text = substr($res['message'], 0,30);  echo (!empty($res["message"])) ? "$text..." : "Please Connect with Me"; ?></br>		   
		  </h4>
		   <small class="pull-right" style="color: rgba(0,0,0,0.6);"><i class="fa fa-clock-o"></i> <?php  echo date('M jS Y, h:i:a', $res["time"]); ?></small>
			</td></tr></table>
		 </a>
		 
	  </li><!-- end message -->
<?php 
	} 
?>
									</ul>
                  </li>
                  <li class="footer"><a href="friendrequests.php">View all</a></li>
                </ul>
              </li>
			 <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-group"></i>
                  <span class="label label-warning" id="first"></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have <span id="second"></span> group invites</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu" style="color: #000;">
	<?php 
	$query = "SELECT * FROM groupinvite where invitee='$_SESSION[userid]'";
	$req = mysql_query($query);
	while($res = mysql_fetch_assoc($req))
	{ 
		$r = mysql_query("select * from profile where id='$res[inviter]'");
		$kname = mysql_fetch_assoc($r);
	?>
	  <li><!-- start message -->
		<a href="invites.php?fid=<?php echo"$res[inviter]"; ?>">
		<table>
		<tr>
		<td>
		  <h4 style="font-size: 11px;">
			<?php echo"$kname[firstname] invited you to join <b>$res[groupname]</b>";?></br>		   
		  </h4>
		   <small class="pull-right" style="color: rgba(0,0,0,0.6);"><i class="fa fa-clock-o"></i> <?php  echo date('M jS Y, h:i:a', $res["time"]); ?></small>
			</td></tr></table>
		 </a>
		 
	  </li><!-- end message -->
<?php 
	} 
?>
									</ul>
                  </li>
                  <li class="footer"><a href="groupinvites.php">View all</a></li>
                </ul>
              </li>
					
							   <li><?php
							   
							   if(is_dir("profilepictures/".$_SESSION['userid'].""))
								{
									$dh = scandir("profilepictures/".$_SESSION['userid']."");
																																
									echo "<img src='profilepictures/$_SESSION[userid]/$dh[2]' class='img-responsive img-circle' style='max-width: 30px; max-height: 30px; margin-top: 10px;' />";
									
								}
								else{
									echo "<img src='images/find_user.png' style='max-width: 30px; max-height: 30px; margin-top: 10px;' class='img-responsive img-circle' />";
								}
								$get = mysql_query("SELECT * FROM `profile` where `id`='$_SESSION[userid]'");
								$headerprofile = mysql_fetch_assoc($get);
							   ?>
							   
							  </li>
							  <li>
							 
								<a href="mp.php"><span class="badge"><?php echo"$headerprofile[firstname]"; ?></span></a>
							  </li>
							
							</ul>
							<ul class="nav navbar-nav navbar-right">
							  <li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i></a>
								<ul class="dropdown-menu">
								  <li><a href="">Account Settings</a></li>
								  <li><a href="mp.php?&about">Edit my profile</a></li>
								  <li><a href="process.php?cid=logout46">Log Out</a></li>
								</ul>
							  </li>
							</ul>
							</nav>
						</div>
						<!-- /top nav -->