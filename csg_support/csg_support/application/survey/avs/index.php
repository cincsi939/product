<?php
	session_start();
	include("config_advance_search.php");
	include("nusoap.php");
$form_type = "input";
$ws_client = new nusoap_client("http://soapservices.sapphire.co.th/index.php?wsdl",true); 
$para =  array(
"form_type"=> $form_type ,
"server_ip"  => $server_ip,
"database_name"  => $database_name, 
"username"  => $username,
"password"  => $password,
"tbl_table"  => $tbl_table,
"tbl_map"  =>  $tbl_map,
"normal"  =>  $normal,
'advance'  =>  $advance,
"output" =>  $output,
"input_showquery" => $input_showquery,
"viewoutput" =>  $viewoutput,
"url_result" =>   $url_result,
"order_by" =>  $order_by,
"para_query"  => $para_query
);
$result_input = $ws_client->call('advance_search', $para);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>ค้นหาขั้นสูง</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=windows-874">

</HEAD>
<BODY>
<div id="box_body">
<table width="100%" border="0" cellpadding="10" cellspacing="0"  id="box_content" >
  <tr>
    <td align="left" valign="top" id="box_content_center">
<!-- START CONTENT -->
<div style="border:1px #CCCCCC solid; padding:7px;">
<h1>ค้นหาขั้นสูง</h1>
<? echo $result_input; ?>
</div>
<!-- END CONTENT -->	
</td>
</tr>
</table>
</div><!-- End .box_body -->
</BODY>
</HTML>