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
	var $cutstr = " เแโใไ(";

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
	
	
function AddThaiFonts()
{
	//font : Angsana New
	$this->AddFont('Angsana New'	,''		,'angsa.php');
	$this->AddFont('Angsana New'	,'B'	,'angsab.php');	//Bold
	$this->AddFont('Angsana New'	,'I'	,'angsai.php');	//Italic
	$this->AddFont('Angsana New'	,'Z'	,'angsaz.php');	//Bold and Italic

	//font : Angsana UPC
	$this->AddFont('Angsana UPC'	,''		,'angsau.php');
	$this->AddFont('Angsana UPC'	,'B'	,'angsaub.php'); //Bold
	$this->AddFont('Angsana UPC'	,'I'	,'angsaui.php'); //Italic	
	$this->AddFont('Angsana UPC'	,'Z'	,'angsauz.php'); //Bold and Italic	
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

#########################################  header ตารางการจ่ายงาน ###################################3


function header_assign_list(){
global $x,$y,$row1_x,$row1_y,$col_width,$col_height;
			$col_width = array(10,30,40,57,18,20,15);
			$col_height = 7;

			$this->SetFont('Angsana New','',12);
			
			$x = 10;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[0],$col_height,"ลำดับ",1,0,'C');

			$x += $col_width[0];
			$this->SetXY($x ,$y);
			$this->Cell($col_width[1],$col_height,"เลขบัตรประชาชน",1,0,'C');

			$x += $col_width[1];
			$this->SetXY($x ,$y);
			$this->Cell($col_width[2],($col_height),"ชื่อ-นามสกุล",1,0,'C');

			$x += $col_width[2];
			$this->SetXY($x ,$y);
			$this->Cell($col_width[3],($col_height),"โรงเรียน/หน่วยงาน",1,0,'C');
			
		
			$x += $col_width[3];
			$this->SetXY($x ,$y);
			$this->Cell($col_width[4],($col_height),"อายุราชการ",1,0,'C');


			$x += $col_width[4];
			$this->SetXY($x ,$y);
			$this->Cell(($col_width[5]),($col_height),"จำนวน(แผ่น)",1,0,'C');

			$x += $col_width[5];
			$this->SetXY($x ,$y);
			$this->Cell($col_width[6],($col_height),"ค่าใช้จ่าย",1,0,'C');
//
//			
//			$x = 10;
//			$this->SetXY($x ,$y);
//			$this->Cell($col_width[0],$col_height+7,"",0,0,'C');
//
//			$x += $col_width[0];
//			$this->SetXY($x ,$y);
//			$this->Cell($col_width[1],$col_height+7,"",0,0,'C');
//
//			$x += $col_width[1];
//			$this->SetXY($x ,$y);
//			$this->Cell($col_width[2],($col_height+7),"",0,0,'C');
//
//			$x += $col_width[2];
//			$this->SetXY($x ,$y);
//			$this->Cell($col_width[3],($col_height+7),"",0,0,'C');
//			
//		
//			$x += $col_width[3];
//			$this->SetXY($x ,$y);
//			$this->Cell($col_width[4],($col_height+7),"",0,0,'C');
//
//
//			$x += $col_width[4];
//			$this->SetXY($x ,$y);
//			$this->Cell(($col_width[5]),($col_height+7),"",0,0,'C');
//
//			$x += $col_width[5];
//			$this->SetXY($x ,$y);
//			$this->Cell($col_width[6],($col_height+7),"ต่อหน่วย",0,0,'C');

//			$temp_heigth = $col_height +7;
//			$x = 10;
//			$this->SetXY($x ,$y);
//			$this->Cell($col_width[0],($temp_heigth),"",1,0,'C');
//
//			$x += $col_width[0];
//			$this->SetXY($x ,$y);
//			$this->Cell($col_width[1],$temp_heigth,"",1,0,'C');
//
//			$x += $col_width[1];
//			$this->SetXY($x ,$y);
//			$this->Cell($col_width[2],($temp_heigth),"",1,0,'C');
//
//			$x += $col_width[2];
//			$this->SetXY($x ,$y);
//			$this->Cell($col_width[3],($temp_heigth),"",1,0,'C');
//			
//		
//			$x += $col_width[3];
//			$this->SetXY($x ,$y);
//			$this->Cell($col_width[4],($temp_heigth),"",1,0,'C');
//
//
//			$x += $col_width[4];
//			$this->SetXY($x ,$y);
//			$this->Cell(($col_width[5]),($temp_heigth),"",1,0,'C');
//
//			$x += $col_width[5];
//			$this->SetXY($x ,$y);
//			$this->Cell($col_width[6],($temp_heigth),"",1,0,'C');


	}



## ฟังก์ชั้นแสดงท้ายเอกสาร
function footer_assign(){
global $x,$y,$row1_x,$row1_y,$col_width,$col_height,$npage;
$col_height = 7;

$this->SetFont('Angsana New','',14);
if (($y) > $npage) {$this->AddPage();$y=20;}
$this->SetXY(10,$y);
$this->Cell(0,5," จังหวัดปทุมธานี : เลขที่ 131 ห้องเลขที่ ไอซี 1-207 ชั้น 2 อาคารอุทยานวิทยาศาสตร์ประเทศไทย ถ.พหลโยธิน",0,0,'L');
$y += $col_height;

if (($y) > $npage) {$this->AddPage();$y=20;}
$this->SetXY(10,$y);
$this->Cell(0,5,"ต. คลองหนึ่ง อ.คลองหลวง จ.ปทุมธานี 12120 โทรซ 0-2564-7880-1 แฟกซ์ 0-2564-7882",0,0,'L');
$y += $col_height;

if (($y) > $npage) {$this->AddPage();$y=20;}
$this->SetXY(10,$y);
$this->Cell(0,5,"จังหวัดเชียงใหม่ : 199/445 หมู่ / 2 ต. หนองจ๊อม อ.สันทราย  จ.เชียงใหม่ 50210",0,0,'L');
$y += $col_height;

if (($y) > $npage) {$this->AddPage();$y=20;}
$this->SetXY(10,$y);
$this->Cell(0,5,"โทร: 0-5324-8985  แฟกซ์   0-5385-4907",0,0,'L');
$y += $col_height;
}
#// end ฟังก์ชั่นแสดงท้ายเอกสาร

} // end class



?>