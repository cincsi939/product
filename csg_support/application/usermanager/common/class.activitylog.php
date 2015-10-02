<?
class activity_log{
	//;
	var $system_db,$barcode = "",$scode="",$idcardnm="";
	function activity_log(){
		global $competency_system_db;
		$this->system_db = $competency_system_db;
	}
	function GetRandomString($length) {
			settype($template, "string");
		   $template = "1234567890";
		   settype($length, "integer");
		   settype($rndstring, "string");
		   settype($a, "integer");
		   settype($b, "integer");
		   for ($a = 0; $a < $length; $a++) {
				   $b = rand(0, strlen($template) - 1);
				   $rndstring .= $template[$b];
		   }
		   return $rndstring;
	}
	function d2b($dcom){
		$o = "";
		$bii = base_convert($dcom,16,2);
		for($j=strlen($bii);$j<4;$j++){
			$o .= "0";
		}
		return $o.$bii;
	}
	function fxor($nm1,$nm2){
		$retmp = "";
		$nm1arr = str_split($nm1);
		$nm2arr = str_split($nm2);
		for($k=0;$k<count($nm1arr);$k++){
			$retmp .= (intval($nm1arr[$k]) ^ intval($nm2arr[$k]));
		}
		return $retmp;
	}
	function bcd2hex($bcdin){
		$encodenm = array();
		$binm = strlen($bcdin)/4;
		for($l=0;$l<$binm;$l++){
			$encodenm[$l] =  base_convert(substr("$bcdin",$l*4,4),2,16);
		}
		return $encodenm;
	}
	function getbarcode(){
		return $this->barcode;
	}
	function decode($barcode,$idcard){
		
		$sr1 = base_convert("1".$barcode, 16, 2);
		$sr2 = base_convert("1".$idcard, 16, 2);

		$x1 =  substr($sr1,1);
		$x2 =  substr($sr2,1);

		$ret = $this->fxor($x1,$x2);
		$ret2 = $this->bcd2hex($ret);
		return implode('',$ret2);
	}
	function update_temp(){
		$sql = "UPDATE $this->system_db.`activity_log` SET `temp_file`='$this->barcode.pdf' WHERE (`sampling_code`='$this->scode') AND (`id_card`='$this->idcardnm')  ";
		$result = $result = mysql_query($sql);
	}
    function save_log($idcard="0000000000000",$name="",$sername="",$server="",$activity="",$temp="",$expire="",$admin_id='',$admin_name='',$admin_sername=''){
		$samp_code = $this->GetRandomString(13);
		$this->scode = $samp_code;
		$this->idcardnm = $idcard;

		$sql = "INSERT INTO $this->system_db.`activity_log` (`sampling_code`,`id_card`,`owner_name`,`owner_sername`,`server_id`,`activity`,`date`,`temp_file`,`expire_date`,`admin_id`,`admin_name`,`admin_sername`) VALUES ('$samp_code','$idcard','$name','$sername','$server','$activity',NOW(),'$temp','$expire','$admin_id','$admin_name','$admin_sername')";

		$result = mysql_query($sql);
		if($result){
			$btmp = array();
			$samarr  = str_split($samp_code);
			$idarr  = str_split($idcard);
			$sdg = count($samarr);
			$iddg = count($idarr);
			$itmp = array();
			for($i=0;$i<$sdg;$i++){
				if($sdg-$i>$iddg){
					$itmp[$i] = "0000";
				}else{
					$itmp[$i] = $this->d2b($idarr[$i-($sdg-$iddg)]);
				}
				$btmp[$i] = $this->d2b($samarr[$i]);
			}
			$idcard_en = implode('',$itmp);
			$samp_en = implode('',$btmp);

			//echo "<pre>";

			//echo $idcard."<br>";
			//echo $samp_code."<br>";

			//echo $idcard_en."<br>";
			//echo $samp_en."<br>";
			$bixor =  $this->fxor($idcard_en,$samp_en);
			//echo $bixor."<br>";
			
			$this->barcode =  implode('',$this->bcd2hex($bixor));
			//echo $this->barcode."<br>";
		}
	}
}
?>