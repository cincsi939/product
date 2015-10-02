<?
class master extends FPDF
{
var $cutstr = "àáâãä( ";

	//////////// µÑ´¢éÍ¤ÇÒÁ //////////////////////////////////////
	function retstr($strinput, $stbegin, $stlength) {
		$retarr = Array();
		if (strlen($strinput)>$stlength) {   
			if ($stlength>(strlen($strinput)-$stbegin)) {
				$retarr[0] = substr($strinput,$stbegin, (strlen($strinput)-$stbegin));
				$retarr[1] = strlen($strinput);
				$retarr[2] = "end";
			}else{
				for ($s=($stbegin+$stlength); $s>$stbegin; $s--) {
					for ($i=0; $i<strlen($this->cutstr); $i++) {
						if (ord(substr($this->cutstr,$i,1)) == ord(substr($strinput,$s,1))) {

							if(ord(substr($this->cutstr,$i,1))!=32) {
								$retarr[0] = substr($strinput,$stbegin, ($s-$stbegin));
								$retarr[1] = $s;
								$retarr[2] = "process";
								$re = "success";
								break;
							}else{
								$retarr[0] = substr($strinput,$stbegin, ($s-$stbegin));
								$retarr[1] = $s+1;
								$retarr[2] = "process";
								$re = "success";
								break;
							}
						}
					}
					if ($re == "success") {
						break;
					}
				}
				if ($re!="success") {
					$retarr[0] = substr($strinput,$stbegin, $stlength);
					$retarr[1] = $stbegin+$stlength;
					$retarr[2] = "process";
					$re = "success";
				}
			}
		} else {
			$retarr[0] = $strinput;
			$retarr[1] = strlen($strinput);
			$retarr[2] = "end";
		}
		$re = "nonsuccess";
		return $retarr;
	}

function alignstr($strin, $cutlength) {
		$strarray = Array();
		$bg = 0;
		for ($k=0; $k<100; $k++) {
			$xstr = Array();
			$xstr = $this->retstr($strin, $bg, $cutlength);
			$strarray[$k] = $xstr[0];
			$bg = $xstr[1];
			if ($xstr[2] == "end") {
				break;
			}
		}
		//print_r($strarray);
		return $strarray;
	}

function Footer()
	{
		global $yy,$date_now,$monthname,$mm_now,$activitylog_barcode;
		//Position at 1.5 cm from bottom
		$this->SetY(-15);
		$this->SetFont('Angsana New','I',9);
		//Page number
		$this->Cell(0,20,'Ë¹éÒ  '.$this->PageNo().' / {nb}',0,0,'R');	
			}

} // end class
?>