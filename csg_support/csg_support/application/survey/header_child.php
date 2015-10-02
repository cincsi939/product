<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<?php
/**
 * @comment  header
 * @projectCode
 * @tor     
 * @package  core
 * @author Jakrit Monkong (jakrit@sapphire.co.th)
 * @created  14/09/2014
 * @access  public
 */
	@session_start();
	include('../../config/config_host.php');
	include('../survey/lib/class.function.php');
	$con = new Cfunction();
	$con->connectDB();

	$user = $_SESSION['username'];
	$pass = $_SESSION['pass'];
	
	$sql ="SELECT user_id,pass,user_status FROM user WHERE user_id='".$user."' AND pass='".$pass."'";
	$results  = mysql_query($sql);
	$rs = mysql_fetch_array($results);
	if($rs <=0) { 
	header( "location:../usermanager/login.php");

	}
	
	function replacepin($pin){
		if($_SESSION['user_status']=='1' or $_SESSION['user_status']==''){
			return substr($pin,0,3).'XXXXXXXXXX';
		}else{
			return $pin;
		}
	}
?>
<style>
#tbhead_1 { height:80px;width:100px;}
#tbhead_2 { height:80px;}
#tbhead_3 { height:80px;width:462px;}
#phoneimg { display:none;}
.iconbox { height:26px; width:39px;}
@media screen and  (min-width: 1px) and (max-width: 360px) {
#tbhead_1 { display:none;width:0px;}
#tbhead_2 { display:none;width:0px;}
#tbhead_3 { display:none;width:0px;}
#phoneimg { display: block;}
.iconbox { height: auto; width:12%;}
}
@media (min-width: 361px)  and (max-width: 767px) { 

}
@media screen and  (min-device-width: 1px) and (max-device-width: 360px) {
#tbhead_1 { display:none;width:0px;}
#tbhead_2 { display:none;width:0px;}
#tbhead_3 { display:none;width:0px;}
#phoneimg { display: block;}

.iconbox { height: auto; width:8%;}
}
@media (min-device-width: 361px)  and (max-device-width: 767px) { 

}
</style>
<?php //print_r($_SESSION); ?>

<img src="../img/logo2_03.png" width="100%" id="phoneimg">
<table width="100%"  border="0" cellpadding="0" cellspacing="0"   style="background-image:url(../img/back01_07.png); background-size:auto 100% ;">
  <tr>
    <td id="tbhead_1"><img src="../img/logo_1_02.png" height="98%"></td>
    <td id="tbhead_2"><img src="../img/logo2_03.png" height="98%"></td>
    <td align="right" id="tbhead_3"><img src="../img/logo5_08.png" height="98%"></td>
  </tr>
</table>


<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"  style="padding:3px; background-image:url(../img/background_06.png); background-size:100% auto;">

	</td>
  </tr>
</table>
