<?php
session_start();
header( 'Content-type: text/html; charset=tis-620' );
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_graduate";
$module_code 		= "graduate";
$process_id			= "graduate";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	::
#DateCreate	::17/07/2007
#LastUpdate	::17/07/2007
#DatabaseTabel::
#END
#########################################################

include("../../../../config/conndb_nonsession.inc.php");
include("../../../../common/common_competency.inc.php");

require_once('lib/Form.php');

$obj = new Form();

//$obj->init('localhost','root','root','edubkk_master');
$obj->init(HOST,USERNAME_HOST,PASSWORD_HOST,DB_MASTER);

$method = $obj->valPostGet('mod',false);
$val = $obj->valPostGet('val',false);
$first = iconv('utf-8','tis-620',$obj->valPostGet('first','===== กรุณาเลือก ====='));

iconv('utf-8','tis-620',$first);
if(!$obj->getOptionResultByMethod($val, $method, $first)) {
    echo 'please check your method have in the system or not!!';
}
?>
