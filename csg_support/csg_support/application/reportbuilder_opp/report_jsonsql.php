<?
	include "db.inc.php";
	//<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
	//header("content-type: text/html; charset=tis-620");
	
	$sql = stripslashes($_REQUEST['strQuery']);
	mysql_query("SET character_set_results=UTF8");
	$result = mysql_query($sql) or die(mysql_error());
	$i=0;
	//$row_field = mysql_num_fields($result); 
	
	while ($rs = mysql_fetch_array($result))
	{
			$json[] = array(
			   'sqlname'=>  $rs['sqlname'],
			   'query'=>  $rs['query'],
			   'description'=> $rs['description']
			);
	}

	echo json_encode($json);

	
?>
