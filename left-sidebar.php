<!-- sidebar -->
					<div class="column col-sm-2 sidebar-offcanvas left-border" id="sidebar">
					  
						<ul class="nav navbar navbar-blue">
							<li><a href="#" data-toggle="offcanvas" class="visible-xs text-center"><i class="glyphicon glyphicon-chevron-right"></i></a></li>
						</ul>
					   <div class="">
					   
						<ul class="nav hidden-xs" id="lg-menu" style="margin-top: 50px; float: right; padding-right: 50px;">
							<h6 style="color: #666666; padding-left: 15px; font-weight: bold;"> <i class="fa fa-user"></i> PROFILE</h6>
							<li class="active">
							
							<a href="mp.php" style='display: inline-block;'> 
							<?php if(is_dir("profilepictures/".$userid.""))
									{
										$dh = scandir("profilepictures/".$userid."");
										echo "<img src='profilepictures/$userid/$dh[2]' class='img-responsive' style='display: inline-block; margin-left:-2px; text-decoration: none; border: solid 1px rgba(255,255,255,0.7); border-radius:2px; width: 15px; max-width: 15px; height: 15px; max-height: 15px;'/>";
									}
								  else{
									   echo"<img src='images/find_user.png' class='img-responsive' style='display: inline-block; margin-left:-2px; text-decoration: none; border: solid 1px rgba(255,255,255,0.7); border-radius:2px; width: 15px; max-width: 15px; height: 15px; max-height: 15px;' />";
								  }
							?>
							<?php echo"$thisprofile[firstname]"; ?></a>
							</li>
							<li><a href="mp.php?&about"><i class="fa fa-pencil-square-o" style='color: #000; margin-right: 3px; display: inline-block;'></i> Edit Profile</a></li>
							<li><a href="#" onclick="window.location.reload();"><i class="glyphicon glyphicon-refresh"></i> Refresh</a></li>
						</ul>
						</div>
						<!------- 2 ----------------->
						 <div class="">
					   
						<ul class="nav hidden-xs" id="lg-menu" style="margin-top: 5px; float: right; padding-right: 40px;">
							<h6 style="color: #666666; padding-left: 15px; font-weight: bold;"> <i class="fa fa-reply-all"></i> UPDATES</h6>
							<li><a href="home.php?messages"><i class="fa fa-comments" style='color: #000; margin-right: 3px; display: inline-block;'></i> Messages <span id="side" class="label label-success"></span></a></li>
							<li><a href="home.php?friendrequests"><i class="fa fa-flag" style='color: #000; margin-right: 3px; display: inline-block;'></i> Requests <span id="reqii" class="label label-primary"></span></a></li>
							<?php $totalgroups = mysql_query("select * from groups"); 
									$tgnum = mysql_num_rows($totalgroups);
							?>
							<li><a href="groups.php?allgroups"><i class="fa fa-group" style='color: #000; margin-right: 3px; display: inline-block;'></i> Groups <span class="label label-warning"><?php echo $tgnum; ?></span></a></li>
							
						</ul>
						<ul class="nav hidden-xs" id="lg-menu" style="margin-top: 5px; float: right; padding-right: 40px;">
							<h6 style="color: #666666; padding-left: 15px; font-weight: bold;"> <i class="fa fa-comment"></i> CHATROOMS</h6>
							<li><a href="mathschat/"><i class="fa fa-sign-in" style='color: #000; margin-right: 3px; display: inline-block;'></i> Mathematics</a></li>
							<li><a href="microchat/"><i class="fa fa-sign-in" style='color: #000; margin-right: 3px; display: inline-block;'></i> Microbiology</a></li>
							
							
						</ul>
						</div>
						
					  
					</div>
					<!-- /sidebar -->