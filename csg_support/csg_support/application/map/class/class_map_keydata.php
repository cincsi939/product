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
		
		function setDBMaster($db_master){
			$this->db_master = $db_master;
		}
		
		
		#Begin Function getArea
		function getArea(){
			$arrData = array();
			$sql = "	SELECT ccDigi FROM `ccaa` 
							WHERE `ccDigi` LIKE '23%' AND `ccType` = 'Aumpur' AND `g_point` <> '' ";
			$query = mysql_db_query($this->db_master, $sql);
			while($row = mysql_fetch_assoc($query)){
					$arrData[$row['ccDigi']] = $row['ccDigi'];
			}
			return $arrData;
		}
		#End Function getArea
		
		
		
	}
	 
	 
	 
?>