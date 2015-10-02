<?php

header("Content-Type: text/xml;");
include("config_advance_search.php");
include("nusoap.php");

$form_type = "output";
$code =  urlencode(str_replace("\\","",$_GET['sqlid']));
$keyword =  urlencode(str_replace("\\","",$_GET['keyword']));

if ($_GET['type'] == "desc"){  $type = "desc"; } else { $type = "asc"; } 
if ($_GET['order_by'] != ""){ $order_by = $_GET['order_by']." ".$type; }
$perpage = "100";
$page = $_GET['page'];
$ws_client = new nusoap_client("http://soapservices.sapphire.co.th/index.php?wsdl",true); 

//�ҡ submit ��������к����͹� �к����ѹ���Ѿ��������͡�� ����˹����������૷� $perpage ���к�������ʴ����͹䢡�ä��� <text></text> �͡��
// ��� advance search ��� basic search ��˹�� out put �����ѹ��

$para =  array(
"form_type"=> $form_type,
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
"code"  => $code,
"keyword"  => $keyword,
"order_by"  => $order_by,
"perpage"  => $perpage,
"page"  => $page,
"para_query"  => $para_query

);
$result = $ws_client->call('advance_search', $para);
$result = iconv("TIS-620","UTF-8//IGNORE",$result);
echo $result ;
?>