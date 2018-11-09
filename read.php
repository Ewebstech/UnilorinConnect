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
            <div class="col-md-3">
              <a href="home.php?composemessage" class="btn btn-default btn-block margin-bottom">Compose</a>
              <div class="panel" style="padding: 10px; margin-top: 10px;">
              
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <li><a class="btn btn-primary" href="home.php?messages"><i class="fa fa-inbox"></i> Inbox <span class="label label-primary pull-right" id="msgp"></span></a></li>
                    <br />
					<li><a class="btn btn-default" href="sentmessages.php"><i class="fa fa-envelope-o"></i> Sent</a></li>
                    
                  </ul>
                </div><!-- /.box-body -->
              </div><!-- /. box -->

            </div><!-- /.col -->
           <div class="col-md-9">
              <div class="panel" style="padding: 10px;">
                <div class="panel-header">
                
                  <!--<div class="box-tools pull-right">
                    <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                    <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
                  </div>-->
                </div><!-- /.box-header -->
                
<?php

$mid;

if(isset($_REQUEST["mid"])) $mid = $_REQUEST["mid"];

		$query = "SELECT * FROM mail WHERE id = '".$mid."'";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		$update = mysql_query("update mail set status='read' where id='$mid'");
		
		
?>

				<div class="box-body no-padding">
                  <div class="mailbox-read-info">
                    <h4><?php echo ucwords(strtolower($row["subject"])); ?></h4> <!-- Message Subject Is Placed Here -->
                    <h6 style="margin-bottom: 20px;"><?php echo (!isset($_REQUEST["sent"])) ? "From: $row[sendername]" : "To: $row[reciever]" ; ?> <span class="mailbox-read-time pull-right"><?php echo date("jS \of F Y h:i:s A", $row["time"]); ?></span></h6>
                  </div><!-- /.mailbox-read-info -->
                  <form class="mailbox-controls with-border text-center">
                    <!--<div class="btn-group">-->
					
                      <button formaction="processmail.php" formmethod="post" name="trash" value="<?php echo $row["id"]; ?>" class="btn btn-default btn-sm" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></button>
                      <button formaction="composemessage.php" formmethod="post" name="reply" value="<?php echo $row["sender"]; ?>" class="btn btn-default btn-sm" data-toggle="tooltip" title="Reply"><i class="fa fa-reply"></i></button>
                     <!--<button class="btn btn-default btn-sm" data-toggle="tooltip" title="Forward"><i class="fa fa-share"></i></button>-->
                    <!--</div><!-- /.btn-group -->
                   
                  </form><!-- /.mailbox-controls -->
                  <div class="mailbox-read-message" style="margin: 20px;">
					<?php echo ucfirst(strtolower($row["msg"])); ?>
                  </div><!-- /.mailbox-read-message -->
                </div><!-- /.box-body -->
              <!-- <div class="box-footer">
                  <ul class="mailbox-attachments clearfix">
                    <li>
                      <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
                      <div class="mailbox-attachment-info">
                        <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Sep2014-report.pdf</a>
                        <span class="mailbox-attachment-size">
                          1,245 KB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                      </div>
                    </li>
                    <li>
                      <span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span>
                      <div class="mailbox-attachment-info">
                        <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> App Description.docx</a>
                        <span class="mailbox-attachment-size">
                          1,245 KB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                      </div>
                    </li>
                    <li>
                      <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo1.png" alt="Attachment"/></span>
                      <div class="mailbox-attachment-info">
                        <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo1.png</a>
                        <span class="mailbox-attachment-size">
                          2.67 MB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                      </div>
                    </li>
                    <li>
                      <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo2.png" alt="Attachment"/></span>
                      <div class="mailbox-attachment-info">
                        <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo2.png</a>
                        <span class="mailbox-attachment-size">
                          1.9 MB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                      </div>
                    </li>
                  </ul>
                </div><!-- /.box-footer -->
                <form class="box-footer">
                  <div class="pull-right">
                    <button formaction="composemessage.php" formmethod="post" name="reply" value="<?php echo $row["sender"]; ?>" class="btn btn-default"><i class="fa fa-reply"></i> Reply</button>
                    <button formaction="composemessage.php" formmethod="post" name="forward" value="<?php echo $row["id"]; ?>" class="btn btn-default"><i class="fa fa-share"></i> Forward</button>
                  </div>
				
				<button formaction="processmail.php" formmethod="post" name="trash" value="<?php echo $row["id"]; ?>" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</button>
				
                  
				</form><!-- /.box-footer -->
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