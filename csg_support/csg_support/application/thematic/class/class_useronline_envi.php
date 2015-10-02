<?php

	###################################################################
	## CLASS User Online And Environment System
	###################################################################
	## Version :		20110929.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2013-08-21 17:00
	## Created By :		Mr.ATIPHAT PHAKHAM (NUENG)
	## E-mail :			atiphat@sapphire.co.th
	## Tel. :			-
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	
require_once("../../config/conndb_nonsession.inc.php");
//include("config.inc.php");
//include("function.inc.php");
require_once('../../common/system.inc.php');

class SyatemEnvironment extends CPULoad{
	
	function SyatemEnvironment(){
		$this->get_load();
	}
	
	function getUserOnline(){
		$str = "SELECT COUNT(useronline.sessionid) AS useronline
				FROM edubkk_system.useronline
				WHERE ipaddress != '127.0.0.1'
				ORDER BY appname ASC, ipaddress ASC, timeupdate DESC";
		$result = mysql_query($str);
		$row = mysql_fetch_assoc($result);
		
		return $row['useronline'];
	}
	
	#Begin Function getCPU usage
	function getCPU(){
		$resultcpu =  number_format($this->load["cpu"],2);
		return $resultcpu;
	}
	#End Function getCPU usage
	
	#Begin Function getLoadAverage
	function getLoadAverage(){
		$before = $this->CPULoadAverage();
	   	sleep(5);
	   	$after = $this->CPULoadAverage();

	   	$total=array_sum($after)-array_sum($before);
	  
	   	$loadavg = round(100* (($after[0]+$after[1]+$after[2]) - ($before[0]+$before[1]+$before[2])) / $total, 2); // user+nice+system
	   	//$iowait= round(100* ($b[4] - $a[4])/$total,2); 
		
		return $loadavg;
	}
	#End Function getLoadAverage
		
	#Begin Function getMemory usage
	function getMemory() {
		foreach(file('/proc/meminfo') as $ri) $m[strtok($ri, ':')] = strtok('');
		//$resultmem = 100 - round(($m['MemFree'] + $m['Buffers'] + $m['Cached']) / $m['MemTotal'] * 100);
		$MemTotal = ($m['MemTotal']/1024)/1024;
		$MemUsed = (($m['Active']+$m['Buffers'] + $m['Cached'])/1024)/1024;
		$MemFree = $MemTotal-$MemUsed;
		$arrData = array('total'=>$MemTotal, 'used'=>$MemUsed, 'free'=>$MemFree);
		return $arrData;
	}
	#End Function getMemory usage
		
	#Begin Function getHDD Usage
	function getHDD(){
		$partition = "/";
		$totalSpace = disk_total_space($partition) / 1048576;
		$usedSpace = $totalSpace - disk_free_space($partition) / 1048576;
		$totalSpace = ($totalSpace/1024);
		$usedSpace = ($usedSpace/1024);
		$freeSpace = ($totalSpace-$usedSpace);
		$arrData = array('total'=>$totalSpace, 'used'=>$usedSpace, 'free'=>$freeSpace);
		return $arrData;
	}
	#End Function getHDD Usage
		
	#Begin Function checkEnvironment Usage
	function checkEnvironment($cpu_max=0, $memory_max=0, $harddisk_max=0){
			
		$resultcpu = $this->getCPU();
		$resultmemory = $this->getMemory();
		$resulthdd = $this->getHDD();
		if($resultcpu>$cpu_max || $resultmemory>$memory_max || $resulthdd>$harddisk_max){
			return true;
		}else{
			return true;
		}
	}
	#End Function checkEnvironment Usage
}

?>