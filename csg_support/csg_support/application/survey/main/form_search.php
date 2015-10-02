<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Tanachai Khampukhew (tanachai@sapphire.co.th)
 * @created  10/09/2014
 * @access  public
 */
 ?>
 <body onload="window.location='../search_question_form.php'">
<!--<center>
<p>
<div style="border:1px #CCCCCC solid; padding:7px; width:90%; text-align:left">
<h1>ค้นหาขั้นสูง</h1>
<?php
require_once('lib/nusoap.php'); 
require_once("lib/class.function.php");
$con = new Cfunction();

$ws_client = $con->configIPSoap();
	$para =  array(
	"form_type"=>  "input" ,
	"server_ip"  =>  "61.19.255.77",
	"database_name"  =>  "question_project", 
	"username"  =>  "family_admin",
	"password"  =>  "F@m!ly[0vE",
	"tbl_table"  =>  "view_avs",
	"tbl_map"  =>   "tbl_map",//tbl_map
	"normal"  =>  "question_id,master_id,question_firstname,question_lastname,master_idcard,master_round,master_idques,question_sex,question_age,question_Income,question_career,question_career_detail,question_parish,question_district,prename_th",
	'advance'  =>  "true",
	"output" =>  "question_id,master_id,question_firstname,question_lastname,master_idcard,master_round,master_idques,question_sex,question_age,question_Income,question_career,question_career_detail,question_parish,question_district,prename_th",
	"input_showquery" =>  "false",
	"viewoutput" =>  "xml",
	"url_result" =>   "question_form.php?frame=form_output",
	"order_by" =>  "",
	"para_query"  => "",
);
$result_input = $ws_client->call('advance_search_utf8', $para);
echo $result_input;
?>
</div>
</p>
</center>-->
</body>