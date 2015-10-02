<?
header("Content-type: text/html; charset=utf-8"); 
$con	=	mysql_connect("localhost","family_admin",'F@m!ly[0vE');
if(!$con) {	echo "Not connect"; }
mysql_select_db("question_project",$con);
mysql_query("SET NAMES utf-8");
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci';");

require_once("../php-sdk/facebook.php");
	
$appId =  '625002070937410';
$secret =  'c99285e28088714bfae1f2ded8a84ca9';
$config = array(
  'appId'  =>  $appId,
  'secret' =>  $secret ,
  'cookie' => true,
);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<?
$facebook = new Facebook($config);
$user_id = $facebook->getUser();

if($user_id) {
						try {
									$user_profile = $facebook->api('/me');
									$USER_EMAIL = $user_profile['email'];
									$USER_first_name = $user_profile['first_name'];
									$USER_last_name = $user_profile['last_name'];

$str = " SELECT `user_id` ,`email` ,`pass`,`active` ,user_status FROM  `user`  where email = '".$USER_EMAIL."' ";
$obj = mysql_query($str);
$check = mysql_fetch_array($obj);

if ( empty($check['email']) ){
	
	echo '<script>alert("ไม่พบข้อมูลชื่อผู้ใช้ในระบบ");</script>';

	echo "<meta http-equiv='refresh' content='0;url=../usermanager/login.php'>";
} else {
	
	$_SESSION['username'] = $check['user_id'];
	$_SESSION['email'] = $check['email'];
	$_SESSION['pass'] = $check['pass'];
	$_SESSION['user_status'] = $check['user_status'];
	header( "location:".$_GET['goto']);
}


	
	
						} catch(FacebookApiException $e) { 
													$login_url = $facebook->getLoginUrl( array(
													'scope' => 'publish_stream,read_stream,email,read_friendlists'
													));
													
													header( "location:".$login_url);
													echo '<h3><a href="' . $login_url . '&login=true">connect</a></h3>';
						}
} else {


													$login_url = $facebook->getLoginUrl( array(
													'scope' => 'publish_stream,read_stream,email,read_friendlists'
													));
													
													header( "location:".$login_url);
													echo '<h3><a href="' . $login_url . '&login=true">connect</a></h3>';
}

?>