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
            <div class="col-md-10 col-md-offset-1">
              <div class="panel" style="padding: 10px;">
                <div class="panel-header">
                  <h3 class="panel-title" style="padding-top: 10px; padding-bottom: 10px; color: purple">Friend Requests</h3>
                  
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <div class="mailbox-controls">
                    <!-- Check all button -->
                    <!--<button class="btn btn-default btn-sm checkbox-toggle" data-toggle="tooltip" title="select all"><i class="fa fa-square-o"></i></button>
                    <div class="btn-group">
                      <button class="btn btn-default btn-sm" data-toggle="tooltip" title="delete" onClick="test('trash')"><i class="fa fa-trash-o"></i></button>
                      <button class="btn btn-default btn-sm" data-toggle="tooltip" title="reply"><i class="fa fa-reply"></i></button>
                    </div><!-- /.btn-group -->
                    <button class="btn btn-default btn-sm" data-toggle="tooltip" title="refresh" onClick="window.location.reload()"><i class="fa fa-refresh"></i></button>
                    <div class="pull-right">
<?php
if(isset($_REQUEST["page"])) $page = $_REQUEST["page"] + 1;
else $page = 1;

$time = time();
$next = $page + 10;
$total = 0;
$iid = substr($_SESSION['userid'], 0,33);
$query = "SELECT * FROM $iid WHERE status = 'pending' and email != '$_SESSION[email]' ORDER BY time DESC LIMIT 5";
$result = mysql_query($query);
if($result) $total = mysql_num_rows($result);
$next = ($next > $total)?$total:$next;
if($total > 0) echo "$page-$next/$total";
$page--;
?>
                   
                      <div class="btn-group" >
                        <button class="btn btn-default btn-sm" data-toggle="tooltip" title="prev" name="page" value="<?php echo ($page > 0)?"$page\"":"\" disabled"; ?>><i class="fa fa-chevron-left"></i></button>
                        <button class="btn btn-default btn-sm" name="page" value="<?php echo ($next != $total)?"$next\"":"\" disabled"; ?> data-toggle="tooltip" title="next"><i class="fa fa-chevron-right"></i></button>
                      </div><!-- /.btn-group -->
                    </div><!-- /.pull-right -->
                  </div>
                  <div class="table-responsive mailbox-messages" style="padding-top: 15px;">
				  <form name="form" method="post">
                    <table class="table table-hover table-striped" >
                      <tbody>
                        
				<?php
				$page++;
				$iid = substr($_SESSION['userid'], 0,33);
				$result = mysql_query("SELECT * FROM $iid WHERE status = 'pending' and email!='$_SESSION[email]' ORDER BY time DESC LIMIT 5");
				
					while($row = mysql_fetch_assoc($result))
					{
						$tfid = mysql_query("select * from profile where id='$row[id]'");
						$tfidresult = mysql_fetch_assoc($tfid);
						if($row['id']){
					?>
						<tr style="text-align: left">
						  <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                          <td class="mailbox-name"><a href="requests.php?fid=<?php echo "$row[id]&$row[sender]"; ?>"></a></td>
                          <td class="mailbox-subject" style="font-size: 11px; font: arial; "><a href="requests.php?fid=<?php echo $row["id"]; ?>">
						  <?php $mesg = substr($row["message"], 0,40); ?>
				<?php if($row["status"] == "pending") { echo "<b style=\"color: red !important;\"> $tfidresult[firstname] wants to connect with you</b>"; } ?> </a>
						  </td>
                          
                          <td class="mailbox-date" style="color: rgba(0,0,0,0.5); font-size: 10px;"><?php echo date("jS \of F Y h:i:s A", $row["time"]); ?></td>
                        </tr>
		<?php		} 
					else
					{?>
                        <tr>

                          <td class="mailbox-name"></td>
                          <td class="mailbox-subject" style="text-align: center;">You have No Friend Requests...</td>

                          <td class="mailbox-date"></td>
                        </tr>
				<?php	}
					} ?>
                      </tbody>
                    </table><!-- /.table -->
					</form>
                  </div><!-- /.mail-box-messages -->
                </div><!-- /.box-body -->
                <div class="box-footer no-padding">
                  <div class="mailbox-controls">
                    <!-- Check all button -->
                    <!--<button class="btn btn-default btn-sm checkbox-toggle" data-toggle="tooltip" title="select all"><i class="fa fa-square-o"></i></button>
                    <div class="btn-group">
                      <button class="btn btn-default btn-sm" data-toggle="tooltip" title="delete" onClick="test()"><i class="fa fa-trash-o"></i></button>
                      <button class="btn btn-default btn-sm" data-toggle="tooltip" title="reply"><i class="fa fa-reply"></i></button>
                   </div><!-- /.btn-group -->
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