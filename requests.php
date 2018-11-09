<?php error_reporting(0);
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
		<link rel="stylesheet" type="text/css" href="css/AdinLTE.css" />
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/tooltip-classic.css" />
		<link rel="stylesheet" type="text/css" href="css/tooltip-comic.css" />
		<link rel="stylesheet" type="text/css" href="iCheck/all.css" />
		
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
					
					<div class="column  col-xs-10" id="main">
					 		
					<?php include("header.php"); ?>
					
						<div class="padding">
						
							<div class="full col-sm-12">
							  
								<!-- content -->                      
								<div class="row">
						<!-- right sidebar -->
						<?php include("adverts.php"); ?>
					<!-- /right sidebar -->	
								
						  <!-- main col right -->
						  <div class="col-sm-9">
						
       <!-- MAILBOX BEGIN -->
          <div class="row" >
            <div class="col-md-8 col-md-offset-2">
              <div class="panel" style="padding: 10px;">
                <div class="panel-header">
                 
                  
                </div><!-- /.box-header -->
                            
<?php



if(isset($_REQUEST["fid"])) $fid = $_REQUEST["fid"];

		$query = "SELECT * FROM profile WHERE id = '".$fid."'";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		
		
?>

				<div class="box-body no-padding">
                  <div class="mailbox-read-info">
                    <h3 style="font-size: 13px; color: purple; text-align: center"> <?php echo"<a href='mp.php?&profile=$row[id]&$row[firstname]$row[lastname]'>$row[firstname] $row[lastname]</a> wants to Connect with you";?></h3> <!-- Message Subject Is Placed Here -->
                   
                  </div><!-- /.mailbox-read-info -->
                  <form class="mailbox-controls with-border text-center">
                    <!--<div class="btn-group">-->
					
                  
                  </form><!-- /.mailbox-controls -->
                  <div class="mailbox-read-message">
				  <table style="text-align: center;" width="450" cellpadding="7">
				  <tr><td align="center" >
				  <?php
											
				if(is_dir("profilepictures/".$row["id"].""))
				{
					$dh = scandir("profilepictures/".$row["id"]."");
																												
					echo "<a href='mp.php?&profile=$row[id]&$row[firstname]$row[lastname]'><img src='profilepictures/$row[id]/$dh[2]' style=' border: 2px solid rgba(0,0,0,0.3); border-radius: 5px; text-align: center' width='200' class='img-responsive img-user' /></a>";
					
				}
				else{
					echo "<img src='images/find_user.png'  class='img-responsive img-user' style='border: 2px solid rgba(0,0,0,0.3); border-radius: 5px; text-align: center' width='200' />";
				}
				
											
				?>
				</td></tr>
				<tr><td>
					<?php $cutfid = substr($_SESSION["userid"],0,33);
					$msgquery = mysql_query("select * from $cutfid where id = '$fid'");
					$rowmsg = mysql_fetch_assoc($msgquery);
					echo ucfirst(strtolower($rowmsg[message])); 
					?>
				</td></tr>
				<tr><td >
				<a href="mp.php?profile=<?php $rand = rand(); echo"$row[id]&$row[firstname]$row[lastname]&connectconnect=$row[id]"; ?>" style="color: #fff;" class="btn btn-default btn-success btn-xs">Connect</a>&nbsp;&nbsp;<a style="color: #fff;" href="mp.php?profile=<?php $rand = rand(); echo"$row[id]&$row[firstname]$row[lastname]&connectdecline=$row[id]"; ?>" class="btn btn-default btn-danger btn-xs">Decline</a>
				</td></tr>
				</table>
                  </div><!-- /.mailbox-read-message -->
                </div><!-- /.box-body -->
               
                <form class="box-footer">
                  
				   
				</form><!-- /.box-footer -->
              </div><!-- /. box -->
                
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        
						 						  
						  </div>
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