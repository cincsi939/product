<?php
/**
* @comment function ในส่วนขอการรับเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด
* @projectCode P2
* @tor
* @package core
* @autho Wised Wisesvatcharajaren
* @access private
* @created 01/10/2015
*/

function monthInYear($month=''){
	$arrData = array('01' => 'มกราคม','02' => 'กุมภาพันธ์','03' => 'มีนาคม','04' => 'เมษายน','05' => 'พฤษภาคม','06' => 'มิถุนายน','07' => 'กรกฎาคม','08' => 'สิงหาคม','09' => 'กันยายน','10' => 'ตุลาคม','11' => 'พฤศจิกายน','12' => 'ธันวาคม');
	return $month == ''?$arrData:$arrData[$month];
}

function getGroupStaff($gid=''){
	$where = "";
	$where .= $gid != ''?" AND org_staffgroup.gid = '".$gid."' ":"";
	
	$arrData = array();
	
	$sql = " SELECT
					org_staffgroup.gid AS gid,
					org_staffgroup.org_id AS org_id,
					org_staffgroup.groupname AS groupname
				FROM org_staffgroup
				WHERE 1 = 1 ".$where;
	$result = mysql_db_query("csg_usermanager",$sql);
	while( $row = mysql_fetch_array($result) ){
		$arrData[$row['gid']]['org_id'] = $row['org_id'];
		$arrData[$row['gid']]['groupname'] = $row['groupname'];
	}
	return $arrData;
}

?>