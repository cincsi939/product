<?php
/**
 * Title: index page etc_tool system
 * Author: Kaisorrawat Panyo
 * Date: 14/10/2558
 * Time: 
 */
#############################################################
$ApplicationName   = 'etc_tool';
$VERSION             = "1.0";
#############################################################
session_start();
include ("config/config.inc.php");	
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
	<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../../common/donate/package/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../common/donate/css/main.css">
    <link rel="stylesheet" href="../../common/donate/css/menu.css">
	<title>ระบบบริหารจัดการข้อมูล</title>
</head>
<body style="margin-top: 0px; margin-bottom: 0px; margin-right: 0px; margin-left: 0px;">
	<?php
	include("header.php");
	?>
	<br>
	<div class="row">
		<?php
		include("menu.php");
		?>
	    <div class="col-md-9 col-lg-9">
	        <div class="panel panel-default">
	            <div class="panel-body" style="                                         background-color: #E4E4E4">
	                <div class="panel panel-default">
	                    <div class="panel-body">
	                        <?php
	                        if($_GET['p']=='form_data'){
	                            include("form_data.php");
	                        }if($_GET['p']=='dashboard'){
	                        	include("dashboard.php");
	                        }
							
	                        ?>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	
</body>
</html>