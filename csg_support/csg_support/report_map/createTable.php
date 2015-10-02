<?php
/**
 * @comment 	Create Table question_tbl2_P_H
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    13/09/2014
 * @access     public
 */
	
$connect = mysql_connect('localhost','family_admin','F@m!ly[0vE');
//$connect = mysql_connect('localhost','root','root');
if(!$connect){ 
	echo 'Not Connect';
	die();
}
mysql_select_db('question_project',$connect);
mysql_query('SET NAMES TIS620');
?>
<!doctype html>
<html>
<head>
<meta charset="TIS-620">
<title>Untitled Document</title>
</head>
<body>
<?php
//start question_problem
$sqlProblem = "SELECT problem_detail, problem_type, problem_level FROM question_problem";
$resultProblem = mysql_query($sqlProblem);
if($resultProblem){
	while($row = mysql_fetch_assoc($resultProblem)){
		$createSQL[] = '`problem'.$row['problem_type'].'_'.$row['problem_level'].'` int(2) NOT NULL DEFAULT "0" COMMENT "'.$row['problem_detail'].'",';
		$checkFiled['problem'][$row['problem_type']][$row['problem_level']] = 'problem'.$row['problem_type'].'_'.$row['problem_level'];
	};
}
unset($sqlProblem);
unset($resultProblem);
unset($row);
//end question_problem
//start question_help
$sqlHelp = "SELECT help_detail, help_type, help_level FROM question_help";
$resultHelp = mysql_query($sqlHelp);
if($resultHelp){
	while($row = mysql_fetch_assoc($resultHelp)){
		$createSQL[] = '`help'.$row['help_type'].'_'.$row['help_level'].'` int(2) NOT NULL DEFAULT "0" COMMENT "'.$row['help_detail'].'",';
		$checkFiled['help'][$row['help_type']][$row['help_level']] = 'help'.$row['help_type'].'_'.$row['help_level'];
	};
};
unset($sqlHelp);
unset($resultHelp);
unset($row);
//end question_help

//start Create question_tbl2_P_H
$sql = 'CREATE TABLE `question_tbl2_P_H`(';
$sql .= ' `tbl2_id` varchar(20) NOT NULL COMMENT "รหัสบัตรประชาชน",';
foreach($createSQL as $value){
	$sql .= ' '.$value;
};
$sql .= ' PRIMARY KEY (`tbl2_id`)';
$sql .= ' ) ENGINE=InnoDB DEFAULT CHARSET=tis620 ROW_FORMAT=COMPACT;';
mysql_query('DROP TABLE IF EXISTS `question_tbl2_P_H`;');
$statusCreateTable = mysql_query($sql);
//end Create question_tbl2_P_H

//start query
$sqlTbl2 = "SELECT tbl2_id, tbl2_type, tbl2_problem, tbl2_help FROM question_tbl2";
$resultTbl2 = mysql_query($sqlTbl2);
if($resultTbl2){
	$statusI = true;
	$i=0;
	while($row = mysql_fetch_assoc($resultTbl2)){
		$sql = 'INSERT INTO `question_tbl2_P_H`';
		$filed = '';
		$result = '';
		$problem = explode(',',$row['tbl2_problem']);
		if(is_array($problem)){
			foreach($problem as $value){
				if(isset($checkFiled['problem'][$row['tbl2_type']][$value]) && $checkFiled['problem'][$row['tbl2_type']][$value] != ''){
					$filed .= ' '.$checkFiled['problem'][$row['tbl2_type']][$value].',';
					$result .= ' 1,';
				}
			}
		}
		$help = explode(',',$row['tbl2_help']);
		if(is_array($help)){
			foreach($help as $value){
				if(isset($checkFiled['help'][$row['tbl2_type']][$value]) && $checkFiled['help'][$row['tbl2_type']][$value] != ''){
					$filed .= ' '.$checkFiled['help'][$row['tbl2_type']][$value].',';
					$result .= ' 1,';
				}
			}
		}
		$sql .= ' (';
		$filed = 'tbl2_id,'.$filed;
		$sql .= substr_replace($filed,'',-1);
		$sql .= ') VALUES (';
		$result = $row['tbl2_id'].','.$result;
		$sql .= substr_replace($result,'',-1);
		$sql .= ');';
		$statusInsert = mysql_query($sql);
		if(!$statusInsert){
			echo 'Error: '.$sql.'<br>';
			$statusI = false;	
		}
	};
}
if($statusI === true){
	echo 'Success';	
}else{
	echo 'Unsuccess';	
}
unset($sqlTbl2);
unset($resultTbl2);
unset($row);
//end question_problem

//start Check
if(isset($_GET['report'])){
	$sql = "SELECT
				T1.tbl2_id, T1.tbl2_type, T1.tbl2_problem, T1.tbl2_help, T2.*
			FROM
				question_tbl2 T1
			LEFT JOIN
				question_tbl2_P_H T2 ON T2.tbl2_id = T1.tbl2_id
			LIMIT 100;";
	$result = mysql_query($sql);
	if($result){
		while($row = mysql_fetch_assoc($result)){
			$problem = explode(',',$row['tbl2_problem']);
			echo '<br>'.'ID: '.$row['tbl2_id'].'<br>';
			echo 'Type: '.$row['tbl2_type'].'<br>';
			echo 'Problem: '.$row['tbl2_problem'].'<br>';
			echo 'Help: '.$row['tbl2_help'].'<br>';
			echo 'CHECK value = 1: <br>';
			foreach($row as $key=>$value){
				if($value == 1){
					echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$key.' = '.$value.'<br>';
				}
			}
		}
	}
}
//end Check
?>
</body>
</html>