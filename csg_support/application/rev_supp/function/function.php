<?php
/**
* @comment function ���ǹ�͡���Ѻ�Թ�ش˹ع���͡������§�����á�Դ
* @projectCode P2
* @tor
* @package core
* @autho Wised Wisesvatcharajaren
* @access private
* @created 01/10/2015
*/

function monthInYear($month=''){
	$arrData = array('01' => '���Ҥ�','02' => '����Ҿѹ��','03' => '�չҤ�','04' => '����¹','05' => '����Ҥ�','06' => '�Զع�¹','07' => '�á�Ҥ�','08' => '�ԧ�Ҥ�','09' => '�ѹ��¹','10' => '���Ҥ�','11' => '��Ȩԡ�¹','12' => '�ѹ�Ҥ�');
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