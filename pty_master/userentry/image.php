<?
//============================================================================
// Example of use for PostGraph class
// Version: 1.0
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
// 
// For support contact info@webradev.com
//============================================================================
// include files
error_reporting(E_ALL ^ E_NOTICE);//
include('common/postgraph.class.php'); 
include('common/user_keyin_stat.php'); 
include("../../config/conndb_nonsession.inc.php");

//### SET VAR-----------------
$date_stat = $_GET['date_stat'];

$data_point_rate = array(1=>100);
for($i=0;$i<40;$i++){
		$data_point_rate[$i+2]=array(101+($i*10),110+($i*10));
}

//$data = array();
foreach($data_point_rate as $key=>$value){
	$count_user = 0;
	if(is_array($value)){
		$point = $value;
		$count_user = getNumkeyPoint($date_stat,$point[0],$point[1]);
		$point_rate = $point[0];//($point[0]+$point[1])/2
	}else{
		$count_user = getNumkeyPoint($date_stat,$value);
		$point_rate = $value;
	}
	if($count_user>0){
		$data[$count_user][] = $point_rate;
	}
}
ksort($data);
/*echo "<pre>";
print_r($data);
echo "</pre>";*/

$graph = new PostGraph(750,450);
$graph->setGraphTitles('User Keyin Stat', 'x axis', 'y axis');
$graph->setYNumberFormat('integer');
$graph->setYTicks(10);
$graph->setData($data);
$graph->centralPoint=240;
$graph->setBackgroundColor(array(65,170,33));
$graph->setCentralPointColor(array(250, 231, 18));
$graph->setBarsColor(array(255,0,0));
$graph->setXTextOrientation('horizontal');
    
$graph->drawImage();

$graph->printImage();

?>