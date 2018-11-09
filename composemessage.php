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
		
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/tooltip-classic.css" />
		
		<link href="css/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
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
						  
			
						
          <div class="row">
		   <div class="panel col-sm-12">
			  <div class="panel-header">
                  
                  <h3 class="panel-title" style="margin-top: 20px; margin-bottom: 20px"> <i class="fa fa-envelope"></i> Send Message to a friend</h3>
                  <!-- tools box -->
                 
			  <?php 
				if($_REQUEST["cid"]){
			$msg = '';
			if($_REQUEST["cid"])
			{
				switch($_REQUEST["cid"])
				{
					case "success":
					{ $msg = "<div class='form-control btn btn-success' style='margin-top: 15px;'>Message sent successfully and file also attached successfully</div>";
					break; 
					}
					case "noupload":
					{ $msg = "<div class='form-control btn btn-success' style='margin-top: 15px;'>Message was sent successfully</div>";
					break; 
					}
					case "emptyform":
					{ $msg = "<div class='btn btn-danger' style='margin-left: 330px; margin-top: 15px;'>Empty fields</div>";
					break; 
					}
				}
			}
			
			echo $msg;
				}
			if(isset($_REQUEST["forward"]))
	{
		$query = "SELECT * FROM mail WHERE id = '".$_REQUEST["forward"]."'";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		$msg = $row["msg"];
		$time = date('jS F Y, h:i:a', $row["time"]);
	}
	if(isset($_REQUEST["reply"])) 
	{
		$query = "SELECT * FROM profile WHERE id = '".$_REQUEST["reply"]."'";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		$to = $row["username"];
		
	}
	
				
			?>
                
                </div>
                <div class="panel-body">
                  <form action="processmail.php" method="POST" accept-charset='UTF-8'>
                   <div class="form-group">
                    <input class="form-control" placeholder="Recipient (Friend's Username)" name="to" id="to" value="<?php echo $to; ?>" type="text" list="mail" onkeydown="setTimeout(searchfriend,192,'mail','mail')" />
					<datalist id="mail"></datalist>
                  </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="subject" placeholder="Subject"/>
                    </div>
				
                    <div>
                      <textarea class="textarea" name="message" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo (isset($_REQUEST["forward"]))?"------------------Forwarded $time------------------\n$msg":""; ?></textarea>
                    </div>
                 
                </div>
                <div class="box-footer clearfix" style="margin-left: 10px; margin-right: 10px; margin-bottom: 10px;">
                 <button type="submit" name="sendthismessage" class="pull-right btn btn-default" id="sendEmail">Send <i class="fa fa-arrow-circle-right"></i></button>
                </div>
				 </form>
			
              </div>
         
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