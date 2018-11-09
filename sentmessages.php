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
						
          <div class="row">
            <div class="col-md-3">
              <a href="composemessage.php" class="btn btn-default btn-block margin-bottom">Compose</a>
              <div class="panel" style="padding: 10px; margin-top: 10px;">
              
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <li><a class="btn btn-default" href="home.php?messages"><i class="fa fa-inbox"></i> Inbox <span class="label label-primary pull-right" id="msgp"></span></a></li>
                    <br />
					<li><a class="btn btn-primary" href="sentmessages.php"><i class="fa fa-envelope-o"></i> Sent</a></li>
                    
                  </ul>
                </div><!-- /.box-body -->
              </div><!-- /. box -->

            </div><!-- /.col -->
            <div class="col-md-9">
              <div class="panel" style="padding: 10px;">
                <div class="panel-header">
                  <h3 class="panel-title " style="padding: 10px;">Inbox</h3>
                  <!--<div class="box-tools pull-right">
                    <div class="has-feedback">
                      <input type="text" class="form-control input-sm" placeholder="Search Mail"/>
                      <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button class="btn btn-default btn-sm checkbox-toggle" data-toggle="tooltip" title="select all"><i class="fa fa-square-o"></i></button>
                    <div class="btn-group">
                      <button class="btn btn-default btn-sm" data-toggle="tooltip" title="delete" onClick="test('trash')"><i class="fa fa-trash-o"></i></button>
                      <!--<button class="btn btn-default btn-sm" data-toggle="tooltip" title="reply"><i class="fa fa-reply"></i></button>
                    --></div><!-- /.btn-group -->
                    <button class="btn btn-default btn-sm" data-toggle="tooltip" title="refresh" onClick="window.location.reload()"><i class="fa fa-refresh"></i></button>
                    <div class="pull-right">
<?php include("temp/database.php");
if(isset($_REQUEST["page"])) $page = $_REQUEST["page"] + 1;
else $page = 1;

$next = $page + 10;
$total = 0;
$query = "SELECT * FROM mail WHERE sender = '$_SESSION[userid]'";
$result = mysql_query($query);

if($result) $total = mysql_num_rows($result);
$next = ($next > $total)?$total:$next;
if($total > 0) echo "$page-$next/$total";
$page--;
?>
                   
                      <div class="btn-group">
                        <button class="btn btn-default btn-sm" data-toggle="tooltip" title="prev" name="page" value="<?php echo ($page > 0)?"$page\"":"\" disabled"; ?>><i class="fa fa-chevron-left"></i></button>
                        <button class="btn btn-default btn-sm" name="page" value="<?php echo ($next != $total)?"$next\"":"\" disabled"; ?> data-toggle="tooltip" title="next"><i class="fa fa-chevron-right"></i></button>
                      </div><!-- /.btn-group -->
                    </div><!-- /.pull-right -->
                  </div>
                  <div class="table-responsive mailbox-messages" style="margin-top: 10px;">
				  <form name="form" method="post">
                    <table class="table table-hover table-striped">
                      <tbody>
                        
				<?php
				$page++;
				
				
					while($row = mysql_fetch_assoc($result))
					{ 
				if($row)
				{
					?>
						<tr>
                          <td><input type="checkbox" name="msgid[]" value="<?php echo $row["id"]; ?>" /></td>
                          <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                          <td class="mailbox-name"><a href="read.php?mid=<?php echo "$row[id]&$row[sendername]&sent"; ?>"></a></td>
                          <td class="mailbox-subject"><a href="read.php?mid=<?php echo "$row[id]&$row[sendername]&sent"; ?>">
						  <?php $subject = ucwords(strtolower($row['subject'])); ?>
				<?php echo ($row["status"] == "unread")?"<b style=\"color: red; !important; font-size: 10px;\">$subject</b>": "$subject"; ?></a>
						  </td>
                          <td class="mailbox-attachment"></td>
                          <td class="mailbox-date" style="font-size: 9px;"><?php echo date("F jS, Y h:i a", $row["time"]); ?></td>
                        </tr>
				<?php   } else { ?>
						<tr>
                          <td></td>
                          <td class="mailbox-star"></td>
                          <td class="mailbox-name"></td>
                          <td class="mailbox-subject">No message...</td>
                          <td class="mailbox-attachment"></td>
                          <td class="mailbox-date"></td>
                        </tr>
					<?php } }?>
				
			
                        
	
                      </tbody>
                    </table><!-- /.table -->
					</form>
                  </div><!-- /.mail-box-messages -->
                </div><!-- /.box-body -->
                <div class="box-footer no-padding">
                  <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button class="btn btn-default btn-sm checkbox-toggle" data-toggle="tooltip" title="select all"><i class="fa fa-square-o"></i></button>
                    <div class="btn-group">
                      <button class="btn btn-default btn-sm" data-toggle="tooltip" title="delete" onClick="test()"><i class="fa fa-trash-o"></i></button>
                      <!--<button class="btn btn-default btn-sm" data-toggle="tooltip" title="reply"><i class="fa fa-reply"></i></button>
                   --></div><!-- /.btn-group -->
                    <button class="btn btn-default btn-sm" data-toggle="tooltip" title="refresh" onClick="window.location.reload()" ><i class="fa fa-refresh"></i></button>
                    <div class="pull-right">
<?php
if($total > 0) echo "$page-$next/$total";
					$page--;
?>
                   
                      <div class="btn-group">
                        <button class="btn btn-default btn-sm" data-toggle="tooltip" title="prev" name="page" value="<?php echo ($page > 0)?"$page\"":"\" disabled"; ?>><i class="fa fa-chevron-left"></i></button>
                        <button class="btn btn-default btn-sm" name="page" value="<?php echo ($next != $total)?"$next\"":"\" disabled"; ?> data-toggle="tooltip" title="next"><i class="fa fa-chevron-right"></i></button>
                      </div><!-- /.btn-group -->
                    </div><!-- /.pull-right -->
                  </div>
                </div>
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