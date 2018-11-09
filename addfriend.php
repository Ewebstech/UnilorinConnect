<style>
.moda { background:rgba(0,0,0,0.5); display:none; width:100%; height:100%; z-index:1111; position:fixed; top:0; left:0;
 cursor:default; }

#modapage { background:#fff; padding:3px 5px 5px 10px; display:none; border-radius:5px;
			 box-shadow:0px 0px 10px 3px rgba(0,0,0,0.5); -moz-box-shadow:0px 0px 10px 3px rgba(0,0,0,0.5);
			 width:380px;position: fixed; z-index:1111; margin-top: -20px; max-height: 500px;
}

.c {
	display:block;
	text-align:right;
	line-height:0.8;
	margin:0;
	float:right;
}
.ani { -webkit-animation:bring 1s; -o-animation:bring 1s; animation:bring 1s;
				position:absolute; top:20%; left:25%; }
.outta { -webkit-animation:outta 5s; -o-animation:outta 5s; position:absolute; top:-1000px; }
.cl { font-size:30px; color:#f20; }
.cl:hover { cursor:pointer; }

@-webkit-keyframes bring { from	{ top:-100%; }
}
@-o-keyframes bring { from { top:-100%; }
}
@keyframes bring { from { top:-100%; }
}

@-webkit-keyframes outta { from { top:10%; left:25%; opacity:1; } to { top:-100%; left:25%; opacity:0.9; }	
}
@-o-keyframes outta { from { top:10%; left:25%; opacity:1; } to { top:-100%; left:25%; opacity:0.9; }
}
@keyframes outta { from { top:10%; left:25%; opacity:1; } to { top:-100%; left:25%; opacity:0.9; }
}
</style>
<div id='moda' class='moda'></div>
<?php session_start(); ?>
<div id="modapage">
	<div class="c"><a href='javascript:closemoda()' class='cl'>&#215;</a></div>
 <div class="login-box-body">
				
			
				
				
				  <?php 				include("temp/database.php");
										
										if(isset($_REQUEST["addfriend"])){
										$addfriend = $_REQUEST['addfriend'];
										
										}
									  //$postquery = mysql_query("SELECT * from `statusposts` WHERE `posterid`='$userid' or `posterid`='$friendid' order by time desc");
									  $query = mysql_query("SELECT * from `profile` where id='$addfriend'");
									  
									  
									  while($add = mysql_fetch_assoc($query)) { 
									  ?>
									  <div class="row">
									  <div class="panel">
									 
									  <div class="panel-heading" >
									
																
									  <div><a class="btn btn-primary btn-flat form-control" style="text-align: center;" href="<?php echo"mp.php?profile=$add[id]&$add[fisrtname]$add[lastname]"; ?>">Connect with <?php echo"$add[firstname] $add[lastname]"; ?></a></div>
									   
									  </div>
									
										<div class="panel-body">
											
											
									<div class="col-sm-12">
									
								<?php 
													if(is_dir("profilepictures/".$add["id"].""))
													{
														$dh = scandir("profilepictures/".$add["id"]."");
																																					
														echo "<img src='profilepictures/$add[id]/$dh[2]' style='max-height: 100px; margin-right: auto; margin-left: auto;' class='img-responsive' />";
														
													}
													else{
														echo "<img src='images/find_user.png' class='img-responsive' style='max-height: 100px; margin-right: auto; margin-left: auto;' />";
													}
												
								?>
								
									  
									  </div>
									<div>
									<p>
										<script type="text/javascript">
										$(document).ready(function (e) {
									$("#fform").on('submit',(function(e) {
										e.preventDefault();
										$.ajax({
											url: "process.php?myid=" + document.getElementById("mid").value + "&fid=" + document.getElementById("frid").value + "&msg=" + document.getElementById("message").value,
											type: "POST",
											data:  new FormData(this),
											contentType: false,
											cache: false,
											processData:false,
											success: function(data)
											{
											$("#rpl").html(data);
											closemoda();
											},
											error: function() 
											{
											} 	        
									   });
									}));
									
								});
								</script>
											<div id="rpl">
											
											<form id="fform" method="post">
											<input type="hidden" id="mid" value="<?php echo"$_SESSION[userid]";?>" />
											<input type="hidden" id="frid" value="<?php echo"$addfriend";?>" />
											<textarea id="message" name="message" Placeholder="Send <?php echo"$add[firstname]"; ?> a Personal Message along with your request" class="form-control"></textarea>
											<br />
											<input type="submit" class="btn btn-primary btn-xs" class="form-control" value="Send Request" />
											
											</form>
										
											</div>
											</p>
											</div>
										</div>
								 	</div>
								
									  <?php } ?>
			  </div><!-- /.login-box-body -->
			 </div>
			 </div>
<script>
window.onload = function(){ b(); }
function b()
{
	document.getElementById('modapage').className = 'ani';
	document.getElementById('modapage').style.display = 'block'; document.getElementById('moda').style.display = 'block';
}
function closemoda()
{	
	document.getElementById('modapage').className = 'outta';
	setTimeout('removecon()',2000);
	setTimeout("location = '?&done'",2000);
	
}
function removecon()
{
	document.getElementById('modapage').style.display = 'none'; document.getElementById('moda').style.display = 'none';
	//location = '" + document.referrer + "';
}
</script>