<?php

#Include the connect.php file
include('connect.php');
#Connect to the database
//connection String

//$connect = mysql_connect($hostname, $username, $password)
//or die('Could not connect: ' . mysql_error());
//Select The database

//if ($bool === False){
//   print "can't find $database";
//}
// get data and store in a json array
$query = "SELECT * FROM personal_point_2557 LIMIT 10";
if (isset($_GET['update']))
{
	// UPDATE COMMAND 
	$update_query = "UPDATE personal_point_2557 SET 
	
	`Working_log_id`='".$_GET['Working_log_id']."',
	`WorkingDate`='".$_GET['WorkingDate']."',
	`WorkingPeple`='".$_GET['WorkingPeple']."',
	`ProjectCode`='".$_GET['ProjectCode']."',
	`WorkingPercent`='".$_GET['WorkingPercent']."',
	`WorkingTime`='".$_GET['WorkingTime']."', 
	`CostId`='".$_GET['CostId']."',
	`TaskId`='".$_GET['TaskId']."', 
	`phase_code`='".$_GET['phase_code']."', 
	`assign_staffid`='".$_GET['assign_staffid']."', 
	`JobAssignment`='".$_GET['JobAssignment']."', 
	`workname`='".$_GET['workname']."', 
	`WorkingDetail`='".$_GET['WorkingDetail']."', 
	`staffid`='".$_GET['staffid']."', 
	`UpdateTime`='".$_GET['UpdateTime']."', 
	`Department`='".$_GET['Department']."', 
	`tor`='".$_GET['tor']."', 
	`facebook_url`='".$_GET['facebook_url']."', 
	`daily_type`='".$_GET['daily_type']."', 
	`Job_Des`='".$_GET['Job_Des']."', 
	`Diff_Level`='".$_GET['Diff_Level']."', 
	`ABS_result`='".$_GET['ABS_result']."'
	
	WHERE 
	`id`='".$_GET['id']."' and `IdCard`='".$_GET['IdCard']."'";
	 $result = mysql_query($update_query) or die("SQL Error 1: " . mysql_error());
     echo $result;
}
else
{
    // SELECT COMMAND
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	$employees = array();
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$employees[] = array(
				'id'=>$row['id'],
				'Working_log_id'=>$row['Working_log_id'],
				'WorkingDate'=>''.$_GET['WorkingDate'],
				'IdCard'=>$row['IdCard'],
				'WorkingPeple'=>iconv("TIS-620","UTF-8",$row['WorkingPeple']),
				'ProjectCode'=>$row['ProjectCode'],
				'WorkingPercent'=>$row['WorkingPercent'],
				'WorkingTime'=>$row['WorkingTime'], 
				'CostId'=>$row['CostId'],
				'TaskId'=>$row['TaskId'], 
				'phase_code'=>$row['phase_code'], 
				'assign_staffid'=>$row['assign_staffid'], 
				'JobAssignment'=>iconv("TIS-620","UTF-8",$row['JobAssignment']), 
				'workname'=>iconv("TIS-620","UTF-8",$row['workname']), 
				'WorkingDetail'=>iconv("TIS-620","UTF-8",$row['WorkingDetail']), 
				'staffid'=>$row['staffid'], 
				'UpdateTime'=>$row['UpdateTime'], 
				'Department'=>$row['Department'], 
				'tor'=>$row['tor'], 
				'facebook_url'=>$row['facebook_url'], 
				'daily_type'=>$row['daily_type'], 
				'Job_Des'=>$row['Job_Des'], 
				'Diff_Level'=>$row['Diff_Level'], 
				'ABS_result'=>$row['ABS_result']	
		  );
	}
	//echo '<pre>';
	 //print_r($employees);
	 //$data = iconv("tis-620",$employees);
	 
	$data = json_encode($employees);
	//print_r( json_decode($data));
	echo $data;
	
}

?>