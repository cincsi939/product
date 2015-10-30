<?
class FPDF_Protection extends FPDF 
{
    var $encrypted;          //whether document is protected
    var $Uvalue;             //U entry in pdf document
    var $Ovalue;             //O entry in pdf document
    var $Pvalue;             //P entry in pdf document
    var $enc_obj_id;         //encryption object id
    var $last_rc4_key;       //last RC4 key encrypted (cached for optimisation)
    var $last_rc4_key_c;     //last RC4 computed key
	var $font_format = "Th Sarabun"; // set default font format
	
	private $date_datakp7=""; 
	private $dbname_temp=DB_CHECKLIST;
	private $xsiteid="";
	private $dbsite;
	private $status_keydata=1; // คือสถานะการคีย์ข้อมูลเรียบร้อยแล้ว
	var $month_th = array('','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฏาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
	var $chdate="";

	
	function date_data($idcard,$xsiteid){
		
		$d_checklist = $this->datechecklist($idcard,$xsiteid);
		$d_salary = $this->datesalary($idcard,$xsiteid);
		
		
		if($d_checklist > $d_salary and $d_checklist != ""){
				return 	$this->date_checklist($idcard,$xsiteid);
		}else{
				return 	$this->date_salary($idcard,$xsiteid);	
		}

			
	}//end function date_data($idcard,$xsiteid){
	
	function date_salary($idcard,$xsiteid){
		$dbsite = STR_PREFIX_DB.$xsiteid;	
		$sql = "SELECT MAX(date) as maxdate  FROM  salary  WHERE  id='$idcard' GROUP BY  id ";
		$result = mysql_db_query($dbsite,$sql) or die(mysql_error()."$sql <br>LINE :: ".__LINE__);
		$rs = mysql_fetch_assoc($result);
		//$datekey = $this->CheckDate($rs[maxdate]);
		$this->date_datakp7=$this->ShowDateThai($rs[maxdate]);
		return $this->date_datakp7;
	}// end function date_salary($xsiteid){
		
	function datesalary($idcard,$xsiteid){
		$dbsite = STR_PREFIX_DB.$xsiteid;	
		//echo $dbsite."<br>";
		$sql = "SELECT MAX(date) as maxdate  FROM  salary  WHERE  id='$idcard' GROUP BY  id ";
		$result = mysql_db_query($dbsite,$sql) or die(mysql_error()."$sql <br>LINE :: ".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[maxdate];
	}// end function date_salary($xsiteid){
		
	function datechecklist($idcard,$xsiteid){
		global $dbname_temp;
		$sql = "SELECT t2.profile_date FROM ".DB_CHECKLIST.".tbl_checklist_kp7 as t1
Inner Join ".DB_CHECKLIST.".tbl_checklist_profile as t2  ON t1.profile_id = t2.profile_id
Inner Join ".DB_USERENTRY.".tbl_assign_key as t3 ON t1.idcard = t3.idcard
WHERE t3.status_keydata =  '1' and t1.idcard='$idcard' and t1.siteid='$xsiteid'
ORDER BY t3.profile_id DESC LIMIT 1";
		$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql <br>LINE :: ".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[profile_date];
	}//end function date_checklist($idcard,$xsiteid){
	
	function date_checklist($idcard,$xsiteid){
		global $dbname_temp;
		$sql = "SELECT t2.profile_date FROM ".DB_CHECKLIST.".tbl_checklist_kp7 as t1
Inner Join ".DB_CHECKLIST.".tbl_checklist_profile as t2  ON t1.profile_id = t2.profile_id
Inner Join ".DB_USERENTRY.".tbl_assign_key as t3 ON t1.idcard = t3.idcard
WHERE t3.status_keydata =  '1' and t1.idcard='$idcard' and t1.siteid='$xsiteid'
ORDER BY t3.profile_id DESC LIMIT 1";
		$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql <br>LINE :: ".__LINE__);
		$rs = mysql_fetch_assoc($result);
		$this->date_datakp7=$this->ShowDateThai($rs[profile_date]);
		return $this->date_datakp7;
	}//end function date_checklist($idcard,$xsiteid){
   
		
	function ShowDateThai($xdate){
		if($xdate != "" and $xdate != "0000-00-00"){
			$arrd = explode("-",$xdate);
			if($arrd[0] > 2500){
					return intval($arrd[2])." ".$this->month_th[intval($arrd[1])]." ".$arrd[0];
			}else{
					if($arrd[0] > 2000){
						$xyy1 = $arrd[0]+543;	
					}else{
						$xyy1 = "";	
					}
						
					return intval($arrd[2])." ".$this->month_th[intval($arrd[1])]." ".$xyy1;	
			}//end if($arrd[0] > 2500){
		}else{
			return "";		
		}//end if($xdate != "" and $xdate != "0000-00-00"){
			
	}//end function ShowDateThai($xdate){
	
	function CheckDate($xdate){
		if($xdate != "" and $xdate != "0000-00-00"){
			$arrd1 = explode("-",$xdate);
			$xmm = intval($arrd1[1]); //ข้อมูลเดือน
			if($xmm == "10" or $xmm == "4" ){
					$this->chdate=$xdate;
			}else if($arrd1[0] > 2000){
					if($xmm >= 4 and $xmm < 10){
						$this->chdate=$arrd1[0]."-04-01";
					}else if($xmm >= 10 or $xmm < 4){
							if($xmm < 4){
									$xyy = $arrd1[0]-1;
							}else{
									$xyy = $arrd1[0];	
							}
						$this->chdate=$xyy."-10-01";
					}else{
						$this->chdate=$xdate;	
					}
			}else{
				$this->chdate="";		
			}//end if($xmm == "10" or $xmm == "4" ){
		
		}else{
			$this->chdate="";	
		}//end if($xdate != "" and $xdate != "0000-00-00"){
		return $this->chdate;
	}//end 	function CheckDate($xdate){





    function FPDF_Protection($orientation='P',$unit='mm',$format='A4')
    {
        parent::FPDF($orientation,$unit,$format);

        $this->encrypted=false;
        $this->last_rc4_key='';
        $this->padding="\x28\xBF\x4E\x5E\x4E\x75\x8A\x41\x64\x00\x4E\x56\xFF\xFA\x01\x08".
                        "\x2E\x2E\x00\xB6\xD0\x68\x3E\x80\x2F\x0C\xA9\xFE\x64\x53\x69\x7A";
    }

    /**
    * Function to set permissions as well as user and owner passwords
    *
    * - permissions is an array with values taken from the following list:
    *   copy, print, modify, annot-forms
    *   If a value is present it means that the permission is granted
    * - If a user password is set, user will be prompted before document is opened
    * - If an owner password is set, document can be opened in privilege mode with no
    *   restriction if that password is entered
    */
    function SetProtection($permissions=array(),$user_pass='',$owner_pass=null)
    {
        $options = array('print' => 4, 'modify' => 8, 'copy' => 16, 'annot-forms' => 32 );
        $protection = 192;
        foreach($permissions as $permission){
            if (!isset($options[$permission]))
                $this->Error('Incorrect permission: '.$permission);
            $protection += $options[$permission];
        }
        if ($owner_pass === null)
            $owner_pass = uniqid(rand());
        $this->encrypted = true;
        $this->_generateencryptionkey($user_pass, $owner_pass, $protection);
    }

/****************************************************************************
*                                                                           *
*                              Private methods                              *
*                                                                           *
****************************************************************************/

    function _putstream($s)
    {
        if ($this->encrypted) {
            $s = $this->_RC4($this->_objectkey($this->n), $s);
        }
        parent::_putstream($s);
    }

    function _textstring($s)
    {
        if ($this->encrypted) {
            $s = $this->_RC4($this->_objectkey($this->n), $s);
        }
        return parent::_textstring($s);
    }

    /**
    * Compute key depending on object number where the encrypted data is stored
    */
    function _objectkey($n)
    {
        return substr($this->_md5_16($this->encryption_key.pack('VXxx',$n)),0,10);
    }

    /**
    * Escape special characters
    */
    function _escape($s)
    {
        $s=str_replace('\\','\\\\',$s);
        $s=str_replace(')','\\)',$s);
        $s=str_replace('(','\\(',$s);
        $s=str_replace("\r",'\\r',$s);
        return $s;
    }

    function _putresources()
    {
        parent::_putresources();
        if ($this->encrypted) {
            $this->_newobj();
            $this->enc_obj_id = $this->n;
            $this->_out('<<');
            $this->_putencryption();
            $this->_out('>>');
            $this->_out('endobj');
        }
    }

    function _putencryption()
    {
        $this->_out('/Filter /Standard');
        $this->_out('/V 1');
        $this->_out('/R 2');
        $this->_out('/O ('.$this->_escape($this->Ovalue).')');
        $this->_out('/U ('.$this->_escape($this->Uvalue).')');
        $this->_out('/P '.$this->Pvalue);
    }

    function _puttrailer()
    {
        parent::_puttrailer();
        if ($this->encrypted) {
            $this->_out('/Encrypt '.$this->enc_obj_id.' 0 R');
            $this->_out('/ID [()()]');
        }
    }

    /**
    * RC4 is the standard encryption algorithm used in PDF format
    */
    function _RC4($key, $text)
    {
        if ($this->last_rc4_key != $key) {
            $k = str_repeat($key, 256/strlen($key)+1);
            $rc4 = range(0,255);
            $j = 0;
            for ($i=0; $i<256; $i++){
                $t = $rc4[$i];
                $j = ($j + $t + ord($k{$i})) % 256;
                $rc4[$i] = $rc4[$j];
                $rc4[$j] = $t;
            }
            $this->last_rc4_key = $key;
            $this->last_rc4_key_c = $rc4;
        } else {
            $rc4 = $this->last_rc4_key_c;
        }

        $len = strlen($text);
        $a = 0;
        $b = 0;
        $out = '';
        for ($i=0; $i<$len; $i++){
            $a = ($a+1)%256;
            $t= $rc4[$a];
            $b = ($b+$t)%256;
            $rc4[$a] = $rc4[$b];
            $rc4[$b] = $t;
            $k = $rc4[($rc4[$a]+$rc4[$b])%256];
            $out.=chr(ord($text{$i}) ^ $k);
        }

        return $out;
    }

    /**
    * Get MD5 as binary string
    */
    function _md5_16($string)
    {
        return pack('H*',md5($string));
    }

    /**
    * Compute O value
    */
    function _Ovalue($user_pass, $owner_pass)
    {
        $tmp = $this->_md5_16($owner_pass);
        $owner_RC4_key = substr($tmp,0,5);
        return $this->_RC4($owner_RC4_key, $user_pass);
    }

    /**
    * Compute U value
    */
    function _Uvalue()
    {
        return $this->_RC4($this->encryption_key, $this->padding);
    }

    /**
    * Compute encryption key
    */
    function _generateencryptionkey($user_pass, $owner_pass, $protection)
    {
        // Pad passwords
        $user_pass = substr($user_pass.$this->padding,0,32);
        $owner_pass = substr($owner_pass.$this->padding,0,32);
        // Compute O value
        $this->Ovalue = $this->_Ovalue($user_pass,$owner_pass);
        // Compute encyption key
        $tmp = $this->_md5_16($user_pass.$this->Ovalue.chr($protection)."\xFF\xFF\xFF");
        $this->encryption_key = substr($tmp,0,5);
        // Compute U value
        $this->Uvalue = $this->_Uvalue();
        // Compute P value
        $this->Pvalue = -(($protection^255)+1);
    }
}

class PDF_Code39 extends FPDF_Protection {

function Code39($x, $y, $code, $ext = true, $cks = false, $w = 0.2, $h = 8, $wide = true) {

    //Display code
    $this->SetFont('Arial', '', 10);
    $this->Text($x, $y+$h+4, $code);

    if($ext)
    {
        //Extended encoding
        $code = $this->encode_code39_ext($code);
    }
    else
    {
        //Convert to upper case
        $code = strtoupper($code);
        //Check validity
        if(!preg_match('|^[0-9A-Z. $/+%-]*$|', $code))
            $this->Error('Invalid barcode value: '.$code);
    }

    //Compute checksum
    if ($cks)
        $code .= $this->checksum_code39($code);

    //Add start and stop characters
    $code = '*'.$code.'*';

    //Conversion tables
    $narrow_encoding = array (
        '0' => '101001101101', '1' => '110100101011', '2' => '101100101011', 
        '3' => '110110010101', '4' => '101001101011', '5' => '110100110101', 
        '6' => '101100110101', '7' => '101001011011', '8' => '110100101101', 
        '9' => '101100101101', 'A' => '110101001011', 'B' => '101101001011', 
        'C' => '110110100101', 'D' => '101011001011', 'E' => '110101100101', 
        'F' => '101101100101', 'G' => '101010011011', 'H' => '110101001101', 
        'I' => '101101001101', 'J' => '101011001101', 'K' => '110101010011', 
        'L' => '101101010011', 'M' => '110110101001', 'N' => '101011010011', 
        'O' => '110101101001', 'P' => '101101101001', 'Q' => '101010110011', 
        'R' => '110101011001', 'S' => '101101011001', 'T' => '101011011001', 
        'U' => '110010101011', 'V' => '100110101011', 'W' => '110011010101', 
        'X' => '100101101011', 'Y' => '110010110101', 'Z' => '100110110101', 
        '-' => '100101011011', '.' => '110010101101', ' ' => '100110101101', 
        '*' => '100101101101', '$' => '100100100101', '/' => '100100101001', 
        '+' => '100101001001', '%' => '101001001001' );

    $wide_encoding = array (
        '0' => '101000111011101', '1' => '111010001010111', '2' => '101110001010111', 
        '3' => '111011100010101', '4' => '101000111010111', '5' => '111010001110101', 
        '6' => '101110001110101', '7' => '101000101110111', '8' => '111010001011101', 
        '9' => '101110001011101', 'A' => '111010100010111', 'B' => '101110100010111', 
        'C' => '111011101000101', 'D' => '101011100010111', 'E' => '111010111000101', 
        'F' => '101110111000101', 'G' => '101010001110111', 'H' => '111010100011101', 
        'I' => '101110100011101', 'J' => '101011100011101', 'K' => '111010101000111', 
        'L' => '101110101000111', 'M' => '111011101010001', 'N' => '101011101000111', 
        'O' => '111010111010001', 'P' => '101110111010001', 'Q' => '101010111000111', 
        'R' => '111010101110001', 'S' => '101110101110001', 'T' => '101011101110001', 
        'U' => '111000101010111', 'V' => '100011101010111', 'W' => '111000111010101', 
        'X' => '100010111010111', 'Y' => '111000101110101', 'Z' => '100011101110101', 
        '-' => '100010101110111', '.' => '111000101011101', ' ' => '100011101011101', 
        '*' => '100010111011101', '$' => '100010001000101', '/' => '100010001010001', 
        '+' => '100010100010001', '%' => '101000100010001');

    $encoding = $wide ? $wide_encoding : $narrow_encoding;

    //Inter-character spacing
    $gap = ($w > 0.29) ? '00' : '0';

    //Convert to bars
    $encode = '';
    for ($i = 0; $i< strlen($code); $i++)
        $encode .= $encoding[$code{$i}].$gap;

    //Draw bars
    $this->draw_code39($encode, $x, $y, $w, $h);
}

function checksum_code39($code) {

    //Compute the modulo 43 checksum

    $chars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 
                            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 
                            'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 
                            'W', 'X', 'Y', 'Z', '-', '.', ' ', '$', '/', '+', '%');
    $sum = 0;
    for ($i=0 ; $i<strlen($code); $i++) {
        $a = array_keys($chars, $code{$i});
        $sum += $a[0];
    }
    $r = $sum % 43;
    return $chars[$r];
}

function encode_code39_ext($code) {

    //Encode characters in extended mode

    $encode = array(
        chr(0) => '%U', chr(1) => '$A', chr(2) => '$B', chr(3) => '$C', 
        chr(4) => '$D', chr(5) => '$E', chr(6) => '$F', chr(7) => '$G', 
        chr(8) => '$H', chr(9) => '$I', chr(10) => '$J', chr(11) => '?K', 
        chr(12) => '$L', chr(13) => '$M', chr(14) => '$N', chr(15) => '$O', 
        chr(16) => '$P', chr(17) => '$Q', chr(18) => '$R', chr(19) => '$S', 
        chr(20) => '$T', chr(21) => '$U', chr(22) => '$V', chr(23) => '$W', 
        chr(24) => '$X', chr(25) => '$Y', chr(26) => '$Z', chr(27) => '%A', 
        chr(28) => '%B', chr(29) => '%C', chr(30) => '%D', chr(31) => '%E', 
        chr(32) => ' ', chr(33) => '/A', chr(34) => '/B', chr(35) => '/C', 
        chr(36) => '/D', chr(37) => '/E', chr(38) => '/F', chr(39) => '/G', 
        chr(40) => '/H', chr(41) => '/I', chr(42) => '/J', chr(43) => '/K', 
        chr(44) => '/L', chr(45) => '-', chr(46) => '.', chr(47) => '/O', 
        chr(48) => '0', chr(49) => '1', chr(50) => '2', chr(51) => '3', 
        chr(52) => '4', chr(53) => '5', chr(54) => '6', chr(55) => '7', 
        chr(56) => '8', chr(57) => '9', chr(58) => '/Z', chr(59) => '%F', 
        chr(60) => '%G', chr(61) => '%H', chr(62) => '%I', chr(63) => '%J', 
        chr(64) => '%V', chr(65) => 'A', chr(66) => 'B', chr(67) => 'C', 
        chr(68) => 'D', chr(69) => 'E', chr(70) => 'F', chr(71) => 'G', 
        chr(72) => 'H', chr(73) => 'I', chr(74) => 'J', chr(75) => 'K', 
        chr(76) => 'L', chr(77) => 'M', chr(78) => 'N', chr(79) => 'O', 
        chr(80) => 'P', chr(81) => 'Q', chr(82) => 'R', chr(83) => 'S', 
        chr(84) => 'T', chr(85) => 'U', chr(86) => 'V', chr(87) => 'W', 
        chr(88) => 'X', chr(89) => 'Y', chr(90) => 'Z', chr(91) => '%K', 
        chr(92) => '%L', chr(93) => '%M', chr(94) => '%N', chr(95) => '%O', 
        chr(96) => '%W', chr(97) => '+A', chr(98) => '+B', chr(99) => '+C', 
        chr(100) => '+D', chr(101) => '+E', chr(102) => '+F', chr(103) => '+G', 
        chr(104) => '+H', chr(105) => '+I', chr(106) => '+J', chr(107) => '+K', 
        chr(108) => '+L', chr(109) => '+M', chr(110) => '+N', chr(111) => '+O', 
        chr(112) => '+P', chr(113) => '+Q', chr(114) => '+R', chr(115) => '+S', 
        chr(116) => '+T', chr(117) => '+U', chr(118) => '+V', chr(119) => '+W', 
        chr(120) => '+X', chr(121) => '+Y', chr(122) => '+Z', chr(123) => '%P', 
        chr(124) => '%Q', chr(125) => '%R', chr(126) => '%S', chr(127) => '%T');

    $code_ext = '';
    for ($i = 0 ; $i<strlen($code); $i++) {
        if (ord($code{$i}) > 127)
            $this->Error('Invalid character: '.$code{$i});
        $code_ext .= $encode[$code{$i}];
    }
    return $code_ext;
}

function draw_code39($code, $x, $y, $w, $h){

    //Draw bars

    for($i=0; $i<strlen($code); $i++)
    {
        if($code{$i} == '1')
            $this->Rect($x+$i*$w, $y, $w, $h, 'F');
    }
}
}

class KP7 extends PDF_Code39
{
	var $cutstr = "เแโใไ( ";

	//////////// ตัดข้อความ //////////////////////////////////////
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

function retireDate($date){

	$d			= explode("-",$date);
	$year	= $d[0];
	$month	= $d[1];
	$date	= $d[2];

	if($month == 1 || $month == 2 || $month == 3){		
		$retire_year	= ($year < 2484) ? $year + 61 : $year + 60 ;		

} else if($month == 10 || $month == 11 || $month == 12){		
		$retire_year 	= ($date <= 1 && $month == 10) ? $year + 60 :  $year + 61;		
	} else {
		$retire_year 	= $year + 60;
	}		

	return "30 กันยายน พ.ศ. ".$retire_year;
}

function aheader()
 { global $x,$y,$row1_x,$row1_y,$col_width,$col_height;
// รายการที่ 10

$x = $this->lMargin;
$y = 24;
$this->SetXY($x,$y); 
$this->SetFont($this->font_format,'',10);

$this->Cell(189,$col_height,'๑๐. ประวัติการศึกษา ฝึกอบรมและดูงาน ',1,1,'C');

			$col_width = array(69,30,90);
			$col_height = 8;

			$this->SetFont($this->font_format,'',10);
			$row1_x = $this->GetX();
			$row1_y = $this->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[0],($col_height/2)," สถานศึกษา ฝึกอบรม ",0,0,'C');

			$this->SetXY($x ,$y);
			$this->Cell($col_width[0],($col_height),"",1,1,0,'');

			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[0],($col_height/2),"และดูงาน",0,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[1],($col_height/2)," ตั้งแต่ - ถึง ",0,0,'C');

			$this->SetXY($x ,$y);
			$this->Cell($col_width[1],($col_height),"",1,1,0,'');

			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[1],($col_height/2),"(เดือน ปี)",0,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[2],($col_height/2)," วุฒิที่ได้รับ ",0,0,'C');

			$this->SetXY($x ,$y);
			$this->Cell($col_width[2],($col_height),"",1,1,0,'');

			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[2],($col_height/2),"ระบุสาขาวิชาเอก (ถ้ามี)",0,0,'C');

			$col_height = 5;

 }

function bheader()
	 {
			 global $x,$y,$row1_x,$row1_y,$col_width,$col_height;
// รายการที่ 12
$x = $this->lMargin;
$y = $y;
$this->SetXY($x,$y); 
$this->SetFont($this->font_format,'',10);

$this->Cell(189,$col_height,"๑๒. วันที่ไม่ได้รับเงินเดือนหรือได้รับเงินเดือนไม่เต็ม หรือวันที่มิได้ประจำปฏิบัติหน้าที่อยู่ในเขตที่ได้มีประกาศใช้กฏอัยการศึก",1,1,'C');

			$row1_x = $this->GetX();
			$row1_y = $this->GetY();

			$x = $row1_x;
			$y = $row1_y;

$this->SetXY($x,$y);

			$col_width = array(44,100,45);
			$col_height = 6;

			$this->SetFont($this->font_format,'',10);
			$row1_x = $this->GetX();
			$row1_y = $this->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[0],$col_height,"ตั้งแต่ - ถึง (วันเดือนปี)",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[1],$col_height,"รายการ",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[2],($col_height),"เอกสารอ้างอิง",1,0,'C');
	 }


// ฟังชั่น addheader การฝึกอบรมและดูงานรายการย่อย
function subAheader(){
 global $x,$y,$row1_x,$row1_y,$col_width,$col_height;
$this->SetFont($this->font_format,'',12);
$x = 10;
$y = 7;
$this->SetXY($x,$y);
$this->Cell(190,6,'๑๐. ประวัติการศึกษา ฝึกอบรมและดูงาน ',1,1,'C');
$this->SetXY(10,13);

			$col_width = array(20,40,40,70,20);
			$col_height = 5;

			$this->SetFont($this->font_format,'',10);
			$row1_x = $this->GetX();
			$row1_y = $this->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[0],$col_height,"ประเภท",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[1],$col_height,"วันเริ่มต้น",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[2],($col_height),"ถึงวันที่",1,0,'C');

			$x += $col_width[2];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[3],($col_height),"ชื่อหลักสูตร",1,0,'C');
			
			$x += $col_width[3];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[4],($col_height),"รุ่น",1,0,'C');
}
// end add header การฝึกอลรมและดูงานรายการย่อย



function cheader()
	 {
		 global $x,$y,$row1_x,$row1_y,$col_width,$col_height;
// รายการที่ 13
$this->SetFont($this->font_format,'',10);
$x = $this->lMargin;
$y = 24;
$this->SetXY($x,$y);
$this->Cell(194,6,'๑๓. ตำแหน่งและอัตราเงินเดือน',1,1,'C');

			$col_width = array(20,75,15,10,15,39,20);
			$col_height = 6;

			$this->SetFont($this->font_format,'',10);

			$x = 10;
			$y = 30;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[0],$col_height,"วัน เดือน ปี",1,0,'C');

			$x += $col_width[0];
			$this->SetXY($x ,$y);
			$this->Cell($col_width[1],$col_height,"ตำแหน่ง",1,0,'C');

			$x += $col_width[1];
			$this->SetXY($x ,$y);
			$this->Cell($col_width[2],($col_height),"เลขที่ตำแหน่ง",1,0,'C');

			$x += $col_width[2];
			$this->SetXY($x ,$y);
			$this->Cell($col_width[3],($col_height),"ระดับ",1,0,'C');
			
			$this->SetFont($this->font_format,'',9);
			$x += $col_width[3];
			$this->SetXY($x ,$y);
			$this->Cell($col_width[4],($col_height),"อัตราเงินเดือน",1,0,'C');

 			$this->SetFont($this->font_format,'',10);
			$x += $col_width[4];
			$this->SetXY($x ,$y);
			$this->Cell(($col_width[5]+$col_width[6]),($col_height),"เอกสารอ้างอิง",1,0,'C');

			//$x += $col_width[5];
			//$this->SetXY($x ,$y);
			//$this->Cell($col_width[6],($col_height),"ลงวันที่",1,0,'C');
	}
	
/// วันลา

function absentheader()
	 {
		 global $x,$y,$row1_x,$row1_y,$col_width,$col_height;
// รายการที่ 13
$this->SetFont($this->font_format,'',12);
$x = $this->lMargin;
$y = 24;
$this->SetXY($x,$y);
$this->Cell(189,6,'๔. จำนวนวันลาหยุดราชการ ขาดราชการ มาสาย',1,1,'L');

			$col_width = array(21,21,36,37,37,37);
			$col_height = 12;

			$this->SetFont($this->font_format,'',12);

			$x = 10;
			$y = 30;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[0],$col_height,"พ.ศ.",1,0,'C');

			$x += $col_width[0];
			$this->SetXY($x ,$y);
			$this->Cell($col_width[1],$col_height,"ลาป่วย",1,0,'C');

			$x += $col_width[1];
			$this->SetXY($x ,$y);
			$this->Cell($col_width[2],($col_height),"ลากิจและพักผ่อน",1,0,'C');

			$x += $col_width[2];
			$this->SetXY($x ,$y);
			$this->Cell($col_width[3],($col_height),"มาสาย",1,0,'C');
			
			$this->SetFont($this->font_format,'',9);
			$x += $col_width[3];
			$this->SetXY($x ,$y);
			$this->Cell($col_width[4],($col_height),"ขาดราชการ",1,0,'C');

 			$this->SetFont($this->font_format,'',10);
			$x += $col_width[4];
			$this->SetXY($x ,$y);
			$this->Cell(($col_width[5]+$col_width[6]),($col_height),"ลาศึกษาต่อ",1,0,'C');

			//$x += $col_width[5];
			//$this->SetXY($x ,$y);
			//$this->Cell($col_width[6],($col_height),"ลงวันที่",1,0,'C');
	}

function xheader()
	 {
		 global $x,$y,$row1_x,$row1_y,$col_width,$col_height;

$this->SetFont($this->font_format,'',12);
$x = $this->lMargin;
$y = 10;
$this->SetXY($x,$y); 

			$row1_x = $this->GetX();
			$row1_y = $this->GetY();

			$x = $row1_x;
			$y = $row1_y;

$this->SetXY($x,$y); // กำหนดหัวตารางข้อมูล

			$col_width = array(20,169);
			$col_height = 6;

			$this->SetFont($this->font_format,'',12);
			$row1_x = $this->GetX();
			$row1_y = $this->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[0],$col_height,"ลำดับ",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[1],$col_height,"รายการ",1,0,'C');

			$y =  $this->GetY();
			$y = $y+($col_height);
			$col_height = 5;
	}

// จบวันลา
function c2footer($Gety1=-1){
		global $id,$dbname;
	// รายการที่ 14
			global $x,$y;

			if($Gety1==-1){
				$y = $y;
			}else{
				$y = $Gety1;
			}

			$x = $this->lMargin;
			$id = trim($id);
		
				$this->SetXY($x,$y);
				$this->SetFont($this->font_format,'',10);
				$this->Cell(194,6,"",0,0,'L');
	}
function cfooter($Gety1=-1)
	{
	global $id,$dbname;
// รายการที่ 14
			global $x,$y;

			if($Gety1==-1){
				$y = $y;
			}else{
				$y = $Gety1;
			}

			$x = $this->lMargin;
			$id = trim($id);
$dbnamemaster=DB_MASTER;
/*$sql = "select t1.*,t2.religion as religionname,t3.blood as bloodgroup from  (general t1 left join $dbnamemaster.hr_religion t2 on t1.region=t2.id) left join $dbnamemaster.hr_blood t3 on t1.blood=t3.id where t1.id='$id'  ;";*/
$sql = "select t1.*,t2.religion as religionname,t3.blood as bloodgroup from (general t1 left join $dbnamemaster.hr_religion t2 on t1.region=t2.id) left join $dbnamemaster.hr_blood t3 on t1.blood=t3.id where t1.id='$id';";
//echo "dbname  == ".$dbname;
		$result = mysql_db_query($dbname,$sql);
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		if($rs[subminis_now]=="สำนักงานคณะกรรมการการศึกษาขั้นพื้นฐาน")
		{
		$subminis_now="สำนักงานคณะกรรมการการศึกษาขั้นพื้นฐาน";
		}else{$subminis_now=$rs[subminis_now];}
		if($rs[subminis_now_label] != ""){ // หากมีส่วนมี label ให้นำ label ไปแสดง
				$subminis_now = $rs[subminis_now_label];
		}else{
				$subminis_now =  $subminis_now;
		}
$this->SetXY($x,$y);
$this->SetFont($this->font_format,'',10);


/*$C_post = strpos($rs[minis_now],"กระทรวง");
if($C_post === false){
	$txt_minis = "กระทรวง$rs[minis_now]";
}else{
	$txt_minis = "$rs[minis_now]";
}
*/

$this->Cell(194,6,"๑๔. ชื่อ  $rs[prename_th] $rs[name_th] $rs[surname_th]    ระดับ  $rs[radub]    $rs[minis_now]   กรม  $subminis_now ",0,0,'L');

	}

	function Footer()
	{
		
	$this->SetFillColor(0,0,0);
		global $yy,$date_now,$monthname,$mm_now,$activitylog_barcode,$preview_status,$id,$xsiteid;
		
		//Position at 1.5 cm from bottom
		$this->SetY(-15);
		$this->SetFont($this->font_format,'I',9);
		//Page number
		$this->Cell(0,20,'หน้า  '.$this->PageNo().' / {nb}',0,0,'R');	

		$code1="$activitylog_barcode";

		//$code1="928871098722888";
		if($code1==""){$code1="NotApproved";}
		if($preview_status==1)
		{
		$code1="Preview";	
		}

/*			$datexx =date('d/m/Y',strtotime('next Month'));
			$arrdate11 = explode("/",$datexx ) ;    
			$xyy = $arrdate11[2] + 543; 
			$new_date = $xyy   ."-".  $arrdate11[1]  ."-".  $arrdate11[0]   ; 
			$expire_date  =  convert_date1($new_date) ; 
*/			$sql = " SELECT date(DATE_SUB( NOW() , INTERVAL -3 MONTH ) ) AS new_expire    "; 
			$result	= mysql_query($sql) ;  
			$rs = mysql_fetch_assoc($result) ;  
			$arrdate11 = explode("-",$rs[new_expire] ) ;  
			$xyy = $arrdate11[0] + 543;  
			$new_date = $xyy   ."-".  $arrdate11[1]  ."-".  $arrdate11[2]   ;  
			//$expire_date  =  convert_date1($new_date) ; 
			$expire_date = $this->ShowDateThai($new_date);



			$this->SetFont($this->font_format, '', 10); 
			$this->SetXY(9 ,280);  
			$this->Cell(200,19,"วันหมดอายุเอกสาร $expire_date",0,0,'L'); 

		//barCode(BC_TYPE_CODE39, $code1, 1, 3, 1, FALSE, 50, BC_IMG_TYPE_JPG, TRUE, BC_ROTATE_0, TRUE, TRUE, "tmp_barcode/$code1");
		//$img = "tmp_barcode/$code1".".jpg";
		//$this->Image("$img",10,280,50,12,"JPG",'');
			$datetata = $this->date_data($id,$xsiteid); // ข้อมูล ณ วันที่ 
			if($datetata != "" ){
					$datetata = "ข้อมูล ณ วันที่ ".$datetata;
			}
			
			$this->SetXY(10 ,265);
			$this->Cell(50,10,"$datetata",0,0,'L');  // เขียนข้อมูล ณ วันที่ 
			
			$this->Code39(10, 275, $code1);
			
		
		

	}
    function Image($file,$x,$y,$w=0,$h=0,$type='',$link='')
    {        
        if(is_file($file)){            
            parent::Image($file,$x,$y,$w,$h,$type,$link); 
        }else{
          if($file!=""&&!is_dir($file)){
            $result=@mysql_query("SELECT DATABASE()");
            $row=mysql_fetch_array($result);
            $mysql_current_db=$row[0];
            $glob_db=$GLOBALS[dbsystem];
            if($glob_db==""){$glob_db="competency_system";}    
            $call_file=$_SERVER['PHP_SELF'];        
                $sql="insert into log_pdf_imgerror(update_time,filename,call_file) values(NOW(),'$file','$call_file')";
                mysql_db_query($glob_db,$sql);
            if($mysql_current_db!=$glob_db&&$mysql_current_db!=""){
                mysql_select_db($mysql_current_db);               
            }
          }  
        }
       
        
    }
} // end class



?>