<?php
	###################################################################
	## CLASS Data Gateway
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
	
	//Sample include
	include('../../../common/system.inc.php');
	
	class SyatemEnvironment extends CPULoad{
		function SyatemEnvironment(){
			$this->get_load();
		}
		
		#Begin Function getCPU usage
		function getCPU(){
			$resultcpu =  number_format($this->load["cpu"],2);
			return $resultcpu;
		}
		#End Function getCPU usage
		
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
	 
	 
	 
	 #Sample
	 
	 $sys = new SyatemEnvironment();
	 $arrCPU = $sys->getCPU();
	 $arrMemory = $sys->getMemory();
	$arrHDD = $sys->getHDD();
	
	echo "<br/>";
	echo "OS: ".PHP_OS;
	echo "<br/>";
	echo "Version: ".phpversion();
	 echo "<br/>";
	 echo "CPU usage: ".$arrCPU;
	 echo "<br/>";
	 echo "Memory total: ".$arrMemory['total'];
	 echo "<br/>";
	 echo "Memory used: ".$arrMemory['used'];
	 echo "<br/>";
	 echo "Memory free: ".$arrMemory['free'];
	 echo "<br/>";
	 echo "HDD total: ".$arrHDD['total'];
	 echo "<br/>";
	 echo "HDD used: ".$arrHDD['used'];
	 echo "<br/>";
	 echo "HDD free: ".$arrHDD['free'];
	 echo "<br/>";

	 
?>