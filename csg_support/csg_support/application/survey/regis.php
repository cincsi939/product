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

$str = " SELECT `user_id` ,`email` ,`pass`,`active`  FROM  `user`  where email = '".$USER_EMAIL."' ";
$obj = mysql_query($str);
$check = mysql_fetch_array($obj);

if ( empty($check['email']) ){
	
	mysql_query("INSERT INTO  `user` (`user_id` ,`email` ,`pass`,`user_status`,`name` ,`surname`,`active`  )VALUES ( '".$USER_EMAIL."',  '".$USER_EMAIL."'  ,  'logon' ,'1' ,'".$USER_first_name."','".$USER_last_name."' ,'0') ");
	$check['email'] = $USER_EMAIL;
	$check['active'] = 0;
	
	$_SESSION['username'] = $USER_EMAIL;
	$_SESSION['email'] = $USER_EMAIL;
	$_SESSION['pass'] = 'logon';
	
} else {
	
	$_SESSION['username'] = $check['user_id'];
	$_SESSION['email'] = $check['email'];
	$_SESSION['pass'] = $check['pass'];
	
}

		if ($check['active'] == 0){
			header( "location:".$_GET['goto']);

		
		} else {
		

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