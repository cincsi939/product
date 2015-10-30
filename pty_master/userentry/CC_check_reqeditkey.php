<?
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
			
			$sql = "SELECT DISTINCT
t2.CZ_ID as idcard,
t2.siteid,
t2.prename_th,
t2.name_th,
t2.surname_th,
t1.req_date
FROM
 ".DB_MASTER.".req_problem_person AS t1
Inner Join  ".DB_MASTER.".view_general as t2 ON t1.idcard =t2.CZ_ID
WHERE
t1.req_status =  '3'
group by t2.CZ_ID";
	    $result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
				$dbsite = STR_PREFIX_DB.$rs[siteid];
				######
				$sql1 = "SELECT count(t1.username) as numedit FROM log_update as t1 where  t1.username='$rs[idcard]' and t1.action NOT LIKE '%login%' and t1.updatetime > '$rs[req_date]' GROUP BY t1.username ";
				$result1 = mysql_db_query($dbsite,$sql1) or die(mysql_error()."".__LINE__);
				$rs1 = mysql_fetch_assoc($result1);
				if($rs1[numedit] > 0){
						$status_edit = "YES";
				}else{
						$status_edit = "NO";
				}
				$sql_replace = "REPLACE INTO req_problem_editkey SET idcard='$rs[idcard]',siteid='$rs[siteid]',status_edit='$status_edit',timeupdate=NOW()";
				mysql_db_query($dbnamemaster,$sql_replace) or die(mysql_error()."".__LINE__);
		}//end 	while($rs = mysql_fetch_assoc($result)){

echo "Done....";


?>

