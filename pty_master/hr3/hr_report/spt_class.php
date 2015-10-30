<?
class SPT extends FPDF
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

	function sptheader()
	 {
			 global $x,$y,$row1_x,$row1_y,$col_width,$col_height;

$this->SetFont('Angsana New','',14);
$this->SetXY(10,10);
$this->Cell(270,10,'ข้อมูลอัตรากำลังข้าราชการครูตามเกณฑ์ ก.ค. (ก.ค.ศ) ในสถานศึกษา ประจำปีการศึกษา 2550',0,0,'C');
$this->SetXY(10,15);
$this->Cell(270,15,'สำนักงานเขตพื้นที่การศึกษาเชียงใหม่ เขต 2',0,0,'C');

$this->SetXY(10,30);

			$col_width = array(8,38,112,18,18,18,18,22,18,9,9,9,9,9,9,9,9,11,11,9,9,48,24,24,8,8,8,8,8,8,32,8,8,8,8,10,10,10,10);
			$col_height = 20;

			$this->SetFont('Angsana New','',10);
			$row1_x = $this->GetX();
			$row1_y = $this->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[0],$col_height,"ที่",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[1],$col_height,"ชื่อสถานศึกษา",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[2],($col_height/4),"จำนวนนักเรียน/ห้องเรียน",1,0,'C');

			$this->SetFont('Angsana New','B',10);
			$y  = $row1_y+($col_height/4);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[3],($col_height/4),"ก่อนประถม",1,0,'C');

			$x += $col_width[3];
			$y  = $row1_y+($col_height/4);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[4],($col_height/4),"ประถม",1,0,'C');

			$x += $col_width[4];
			$y  = $row1_y+($col_height/4);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[5],($col_height/4),"มัธยมต้น",1,0,'C');

			$x += $col_width[5];
			$y  = $row1_y+($col_height/4);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[6],($col_height/4),"มัธยมปลาย",1,0,'C');

			$x += $col_width[6];
			$y  = $row1_y+($col_height/4);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[7],($col_height/4),"รวมประถมและมัธยม",1,0,'C');

			$x += $col_width[7];
			$y  = $row1_y+($col_height/4);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[8],($col_height/4),"รวมทั้งสิ้น",1,0,'C');

			
			$this->SetFont('Angsana New','B',10);
			$x -= ($col_width[3]+$col_width[4]+$col_width[5]+$col_width[6]+$col_width[7]);
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[9],($col_height/2),"ห้อง",1,0,'C');

			$x += $col_width[9];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[10],($col_height/2),"นร.",1,0,'C');

			$x += $col_width[10];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[11],($col_height/2),"ห้อง",1,0,'C');

			$x += $col_width[11];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[12],($col_height/2),"นร.",1,0,'C');

			$x += $col_width[12];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[13],($col_height/2),"ห้อง",1,0,'C');

			$x += $col_width[13];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[14],($col_height/2),"นร.",1,0,'C');

			$x += $col_width[14];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[15],($col_height/2),"ห้อง",1,0,'C');

			$x += $col_width[15];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[16],($col_height/2),"นร.",1,0,'C');

			$x += $col_width[16];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[17],($col_height/2),"ห้อง",1,0,'C');

			$x += $col_width[17];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[18],($col_height/2),"นร.",1,0,'C');

			$x += $col_width[18];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[19],($col_height/2),"ห้อง",1,0,'C');

			$x += $col_width[19];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[20],($col_height/2),"นร.",1,0,'C');


			$x += $col_width[20];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[21],($col_height/4),"จำนวนครู",1,0,'C');

			$this->SetFont('Angsana New','B',10);
			$y  = $row1_y+($col_height/4);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[22],($col_height/4),"ครูตาม จ.18",1,0,'C');

			$x += $col_width[22];
			$y  = $row1_y+($col_height/4);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[23],($col_height/4),"ครูตามเกณฑ์ ก.ค.",1,0,'C');

			$this->SetFont('Angsana New','B',10);
			$x -= ($col_width[22]);
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[24],($col_height/2),"บร.",1,0,'C');

			$x += $col_width[24];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[25],($col_height/2),"ครู",1,0,'C');

			$x += $col_width[25];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[26],($col_height/2),"รวม",1,0,'C');

			$x += $col_width[26];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[27],($col_height/2),"บร.",1,0,'C');

			$x += $col_width[27];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[28],($col_height/2),"ครู",1,0,'C');

			$x += $col_width[28];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[29],($col_height/2),"รวม",1,0,'C');

			$x += $col_width[29];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[30],($col_height/2),"จำนวนครู-ขาด เกิน",1,0,'C');

			$this->SetFont('Angsana New','B',10);
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[31],($col_height/2),"บร.",1,0,'C');

			$x += $col_width[31];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[32],($col_height/2),"ครู",1,0,'C');

			$x += $col_width[32];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[33],($col_height/2),"รวม",1,0,'C');

			$x += $col_width[33];
			$y  = $row1_y+($col_height/2);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[34],($col_height/2),"ร้อยละ",1,0,'C');

			$x += $col_width[34];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[35],($col_height/4),"พนักงาน",0,0,'C');

			$this->SetXY($x ,$y);
			$this->Cell($col_width[35],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/4);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[35],($col_height/4),"ราชการ",0,0,'C');

			$x += $col_width[35];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[36],($col_height/4),"อัตรา",0,0,'C');

			$this->SetXY($x ,$y);
			$this->Cell($col_width[36],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/4);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[36],($col_height/4),"จ้าง",0,0,'C');

			$x += $col_width[36];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[37],($col_height/4),"ไปช่วย",0,0,'C');

			$this->SetXY($x ,$y);
			$this->Cell($col_width[37],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/4);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[37],($col_height/4),"ราชการ",0,0,'C');

			$x += $col_width[37];
			$y  = $row1_y;
			$this->SetXY($x ,$y);
			$this->Cell($col_width[38],($col_height/4),"มาช่วย",0,0,'C');

			$this->SetXY($x ,$y);
			$this->Cell($col_width[38],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/4);
			$this->SetXY($x ,$y);
			$this->Cell($col_width[38],($col_height/4),"ราชการ",0,0,'C');

	 }

	 function Footer()
	{
		global $yy,$date_now,$monthname,$mm_now,$activitylog_barcode;
		//Position at 1.5 cm from bottom
		$this->SetY(-15);
		$this->SetFont('Angsana New','I',9);
		//Page number
		$this->Cell(0,20,'หน้า  '.$this->PageNo().' / {nb}',0,0,'R');	
			}

} // end class