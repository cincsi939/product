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
	class MonitorKeyData {
		
		var $db_master = '';
		var $db_userentry = '';
		var $db_checklist = '';
		
		function setDBMaster($db_master){
			$this->db_master = $db_master;
		}

		function getMonitorKeyData($profile_id,$profile_retire_id='0'){
			$sqlCall = "CALL rpt_monitor_keyin({$profile_id},{$profile_retire_id});";
			mysql_db_query($this->db_master, $sqlCall) or die(mysql_error());
			
			$sql = "SELECT * FROM rpt_monitor_keyin WHERE profile_id = '{$profile_id}'";
			$query = mysql_db_query($this->db_master, $sql) or die(mysql_error());
			$row = mysql_fetch_assoc($query);
			$arrData = $row;    
			return $arrData;			
		}

	}
 
?>