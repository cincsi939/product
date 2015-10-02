<?php
	###################################################################
	## CLASS Map Keydata
	###################################################################
	## Version :		20110929.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-09-29 10:09
	## Created By :		Mr.KIDSANA PANYA (JENG)
	## E-mail :			kidsana@sapphire.co.th
	## Tel. :			-
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	/*
	Include Files
	common/system.inc.php
	*/
	class MapKeyData {
		
		var $db_master = '';
		var $db_userentry = '';
		var $db_checklist = '';
		
		function setDBMaster($db_master){
			$this->db_master = $db_master;
		}
		
		function setDBUserentry($db_userentry){
			$this->db_userentry = $db_userentry;
		}
		
		function setDBChecklist($db_checklist){
			$this->db_checklist = $db_checklist;
		}
		
		#Begin Function getArea
		function getArea(){
			$arrData = array();
			$sql = "	SELECT ccDigi FROM `ccaa` 
							WHERE `ccDigi` LIKE '10%' AND `ccType` = 'Aumpur' AND `g_point` <> '' ";
			$query = mysql_db_query($this->db_master, $sql);
			while($row = mysql_fetch_assoc($query)){
					$arrData[$row['ccDigi']] = $row['ccDigi'];
			}
			return $arrData;
		}
		#End Function getArea
		
		function getTargetData($profile_id){
			$sql = "SELECT COUNT(idcard) AS num_key, 
							tbl_checklist_kp7.siteid, 
							tbl_checklist_kp7.schoolid, 
							SUBSTRING(allschool.moiareaid,1,4) AS areaid
						FROM ".$this->db_checklist.".tbl_checklist_kp7 AS tbl_checklist_kp7 INNER JOIN allschool ON tbl_checklist_kp7.schoolid = allschool.id
						WHERE profile_id='{$profile_id}'
						GROUP BY SUBSTRING(allschool.moiareaid,1,4) ";
			$query = mysql_db_query($this->db_master, $sql) or die(mysql_error());
			while($row = mysql_fetch_assoc($query)){
					$arrData[$row['areaid']] = $row['num_key'];
			}
			return $arrData;			
		}
		
		function getProductData($profile_id){
			$sql = "SELECT 
							SUBSTRING(allschool.moiareaid,1,4) AS areaid, 
							COUNT(DISTINCT ".$this->db_userentry.".view_kp7approve.idcard) AS num_key
							FROM ".$this->db_userentry.".view_kp7approve AS view_kp7approve
							INNER JOIN allschool ON view_kp7approve.siteid = allschool.siteid
							WHERE view_kp7approve.profile_id='{$profile_id}'
							GROUP BY SUBSTRING(allschool.moiareaid,1,4)  ";
			$query = mysql_db_query($this->db_master, $sql) or die(mysql_error());
			while($row = mysql_fetch_assoc($query)){
					$arrData[$row['areaid']] = $row['num_key'];
			}
			return $arrData;			
		}
		
		
		
		
		
		
	}
	 
	 
	 
?>