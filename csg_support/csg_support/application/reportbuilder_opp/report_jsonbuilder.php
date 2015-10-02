<?php
include "db.inc.php";

//header("content-type: text/html; charset=tis-620");
$id = $_REQUEST['id'];
$sec = $_REQUEST['sec'];
$sql = $_REQUEST['strQuery'];

$action = $_REQUEST['action'];
$sqlname = addslashes($_REQUEST['sqlname']);
$query = $_REQUEST['query'];
$desc = $_REQUEST['desc'];


if($action == "getsqlset"){
	
	$sql = "select * from report_sqldata where rid='$id' and sec='$sec' ;";
	$result = mysql_query($sql);
	$json = array();
	$i = 0;
	while ($rs = mysql_fetch_array($result, MYSQL_ASSOC))
	{	
		$json[$i] = $rs;
		$i++;
	}
	echo json_encode($json);
	exit;
}

if ($action== "updatesql"){ // update sql query json ----------------------------------------------------
		if($sqlname != ""){
			$sql="select * from report_sqldata where rid='$id'  and sec='$sec' and sqlname='$sqlname';";
			$result = mysql_query($sql);
			$rs = mysql_fetch_array($result);
			if($rs['sqlname']==""){  
				//create new 
				$sql = "insert into report_sqldata(uname, rid, sec, sqlname, query, description) values('$uname', '$id', '$sec', '$sqlname', '$query', '$desc');";
				mysql_query($sql);
			}else{
				// update sql 
				// @modify Phada Woodtikarn 03/07/2014 check ดูว่ามี ' ใน sql มั้ย จะได้ไม่เกินการ update ผิดผลาด ทุกตาราง เพราะไปปิดtag
				$found = strpos($query, "'");
				if($found == false){
					$sql = "update report_sqldata set query='$query', description='$desc' where rid='$id'  and sec='$sec' and sqlname='$sqlname';";
					mysql_query($sql);
				}
				// @end
			}				
		}			
		//header("Location: ?id=$id");
		$json = array();
		$json[0] = "save to finish";
		echo json_encode($json);
		exit;

	}else  if ($action == "deletesql"){
		
		$sql = "delete from report_sqldata  where rid='$id' and sec='$sec' and sqlname='$sqlname';";
		mysql_query($sql);			
		//header("Location: ?id=$id");
		$json = array();
		$json[0] = "delete to finish";
		echo json_encode($json);
		exit;
}

if($id==""){
	if($sql == null) $sql="select * from tblView";
	mysql_query("SET character_set_results=UTF8");
	$result = mysql_query($sql);
	$i=0;
	$json = array();
	while ($rs = mysql_fetch_array($result, MYSQL_ASSOC))
	{	
		$json[$i] = $rs;
		$i++;
	}
	echo json_encode($json);
}else if($id != ""){
	
	$report = "select * from report_sqldata where rid='$id'";
	mysql_query("SET character_set_results=UTF8");
	$rRow = mysql_query($report);
	$json = array();
	while ($row = mysql_fetch_array($rRow, MYSQL_ASSOC))
	{	
			$rSql = $row['sqlname'];
			$rQuery = $row['query'];	
			$result = mysql_query($rQuery);
			$i=0;
			$json[$rSql]['check'] = 0;
			while ($rs = mysql_fetch_array($result,MYSQL_NUM)){	
				if($json[$rSql]['check'] == 0){
					$json[$rSql]['check'] = 1;	
				}
				//$json[$rSql][$i] = $rs;
				//$i++;
				//$json[$rSql][$i] =array();
				
				for($j=0; $j<count($rs); $j++){
					//$json[$rSql][-1][$j] = mysql_field_name($result, $j);
					$json[$rSql][$i][$j] = $rs[$j];
				}
				$i++;
			}	
	}
	echo json_encode($json);
	//echo $json[sql1][0][0];
}
?>
