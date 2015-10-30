<?php
//include ("session.inc.php");
//ob_start();
//session_start();
define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/fpdf.php');
require('../../../common/master_class.php');
include ("libary/config.inc.php");

$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");

$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$monthsname = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");

$pdf=new master();
$pdf->AliasNbPages();
$pdf->AddThaiFonts();
$pdf->AddPage(); // เริ่มหน้าข้อมูลสำคัญโดยย่อ

  $runid=$_REQUEST['runnid'];
 $sql = "select t1.*,t2.*,t3.th_name from seminar_form t1 left join general t2 on t1.id = t2.id left join office_detail t3 on t2.unit = t3.id  where t1.id='$id' and t1.runid = '$runid'  ;";
		
		$result = mysql_query($sql);
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);

		$date_on = explode("-",$rs[ondate]); // ลงวันที่
		$date_s = explode("-",$rs[startdate]); // ระหว่างวันที่
		$date_e = explode("-",$rs[enddate]); // ถึงวันที่

$pdf->SetFont('Angsana New','U',16);
$pdf->SetXY(71,10);
$pdf->Cell(71,10,'รายงานการเข้าร่วมประชุมสัมมนา/จัดกิจกรรม',0,0,'C');
$pdf->SetXY(71,15);
$pdf->Cell(71,15,"โรงเรียน $rs[th_name]",0,0,'C');

$pdf->SetFont('Angsana New','',14);
$pdf->SetXY(15,25);
$pdf->Cell(15,25,"เรียน  ผู้อำนวยการโรงเรียน $rs[th_name]",0,0,'L');
$pdf->SetXY(15,30);
$pdf->Cell(15,30,"เรื่อง  การรายงานผลการไปประชุมสัมมนา/จัดกิจกรรม",0,0,'L');
$pdf->SetXY(15,35);
$pdf->Cell(15,35,"สิ่งที่ส่งมาด้วย     1. $rs[title1]",0,0,'L');
$pdf->SetXY(15,40);
$pdf->Cell(15,40,"                            2. $rs[title2]",0,0,'L');
$pdf->SetXY(15,45);
$pdf->Cell(15,45,"          ตามคำสั่งที่   $rs[orderno]   ลงวันที่ ".intval($date_on[2])."  เดือน ".$monthname[intval($date_on[1])]."  พ.ศ. ".$date_on[0].''."    โดยมอบหมายให้ข้าพเจ้า $rs[prename_th] $rs[name_th]  $rs[surname_th]",0,0,'L');
$pdf->SetXY(15,50);
$pdf->Cell(15,50,"ไปประชุมสัมมนา/กิจกรรมเรื่อง  $rs[subject]",0,0,'L');
$pdf->SetXY(15,55);
$pdf->Cell(15,55,"ระหว่างวันที่ ".intval($date_s[2])."  เดือน ".$monthname[intval($date_s[1])]."  พ.ศ. ".$date_s[0].''." ถึง ".intval($date_e[2])."  เดือน ".$monthname[intval($date_e[1])]."  พ.ศ. ".$date_e[0].'',0,0,'L');
$pdf->SetXY(15,60);
$pdf->Cell(15,60,"ณ $rs[place]",0,0,'L');

$pdf->SetFont('Angsana New','U',16);
$pdf->SetXY(71,65);
$pdf->Cell(71,65,'ข้าพเจ้าขอรายงานผลการไปปฏิบัติราชการดังนี้',0,0,'C');

$pdf->SetFont('Angsana New','B',14);
$pdf->SetXY(15,70);
$pdf->Cell(15,70,'1  ความรู้ หรือ ประสบการณ์ ที่ได้จากการอบรมสัมมนา',0,0,'L');
			
$pdf->SetFont('Angsana New','',12);

			$col_width = array(180); // กำหนดความกว้าง column
			$col_height = 7;
			$x = 20;
			$y = 110;
			$pdf->SetXY($x,$y); // บรรทัด ความรู้ หรือ ประสบการณ์ ที่ได้จากการอบรมสัมมนา

			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($rs[note1],140);
			$num_arr1 = count($arr_str1);
			
			if($num_arr1 == 1){ // มีบรรทัดเดียว
			
			$pdf->SetXY($x,$y);
			$pdf->Cell($col_width[0],$col_height,"$rs[note1]",0,0,'L');

			$y +=  $col_height;

			}else{ // มีหลายบรรทัด
				for ($n=0;$n<$num_arr1;$n++) {
					if($n==0){ // เขียนบรรทัดแรก

						$pdf->SetFont('Angsana New','',12);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],($col_height*$num_arr1),"",0,0,'L');

					} // end if เขียนบรรทัดที่สอง
					if($n<$num_arr1 && $n != 0 ){$y += $col_height;}
			
					$x = $pdf->lMargin;

					$pdf->SetFont('Angsana New','',12);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],$col_height,"$arr_str1[$n]",0,0,'L');
					
					if($n==($num_arr1-1)){$y += $col_height;}
				} // end for
			} // end if else

$x = 15;
$y = $y;
$pdf->SetXY($x,$y);

			$col_width = array(180);
			$col_height = 7;

			$pdf->SetFont('Angsana New','B',14);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"2  การนำความรู้สู่การปฏิบัติ ได้ดังนี้",0,0,'L');

$pdf->SetFont('Angsana New','',12);

			$x = $pdf->lMargin;
			$y = $y+($col_height);

			$pdf->SetXY($x,$y); // การนำความรู้สู่การปฏิบัติ ได้ดังนี้

			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($rs[note2],140);
			$num_arr1 = count($arr_str1);
			
			if($num_arr1 == 1){ // มีบรรทัดเดียว
			
			$pdf->SetXY($x,$y);
			$pdf->Cell($col_width[0],$col_height,"$rs[note2]",0,0,'L');

			$y +=  $col_height;

			}else{ // มีหลายบรรทัด
				for ($n=0;$n<$num_arr1;$n++) {
					if($n==0){ // เขียนบรรทัดแรก

						$pdf->SetFont('Angsana New','',12);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],($col_height*$num_arr1),"",0,0,'L');

					} // end if เขียนบรรทัดที่สอง
					if($n<$num_arr1 && $n != 0 ){$y += $col_height;}
			
					$x = $pdf->lMargin;

					$pdf->SetFont('Angsana New','',12);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],$col_height,"$arr_str1[$n]",0,0,'L');
					
					if($n==($num_arr1-1)){$y += $col_height;}
				} // end for
			} // end if else

$x = 15;
$y = $y;
$pdf->SetXY($x,$y);
		
		$arr_strx1 = array(); 
		$resultx1 = mysql_query("select t1.*,t2.*,t3.th_name from seminar_form t1 left join general t2 on t1.id = t2.id left join office_detail t3 on t2.unit = t3.id  where t1.id='$id' and t1.runid = '$runid'  ;");				
		while($rsx1=mysql_fetch_array($resultx1)){
			$arr_strx1 = $pdf->alignstr($rsx1[note3],140);
			$num_arrx1 += count($arr_strx1);
		}
		if ((14+($num_arrx1*7)+$y+50) > 265) {$pdf->AddPage();$y=30;}

			$col_width = array(180);
			$col_height = 7;

			$pdf->SetFont('Angsana New','B',14);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"3  สิ่งที่ต้องการให้โรงเรียนให้การสนับสนุน",0,0,'L');

$pdf->SetFont('Angsana New','',12);

			$x = $pdf->lMargin;
			$y = $y+($col_height);

			$pdf->SetXY($x,$y); // การนำความรู้สู่การปฏิบัติ ได้ดังนี้

			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($rs[note3],140);
			$num_arr1 = count($arr_str1);
			
			if($num_arr1 == 1){ // มีบรรทัดเดียว
			
			$pdf->SetXY($x,$y);
			$pdf->Cell($col_width[0],$col_height,"$rs[note3]",0,0,'L');

			$y +=  $col_height;

			}else{ // มีหลายบรรทัด
				for ($n=0;$n<$num_arr1;$n++) {
					if($n==0){ // เขียนบรรทัดแรก

						$pdf->SetFont('Angsana New','',12);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],($col_height*$num_arr1),"",0,0,'L');

					} // end if เขียนบรรทัดที่สอง
					if($n<$num_arr1 && $n != 0 ){$y += $col_height;}
			
					$x = $pdf->lMargin;

					$pdf->SetFont('Angsana New','',12);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],$col_height,"$arr_str1[$n]",0,0,'L');
					
					if($n==($num_arr1-1)){$y += $col_height;}
				} // end for
			} // end if else


//$pdf->SetXY(10,200); // เริ่มส่วนท้าย

			$row1_x = $pdf->lMargin; // เริ่มแถวใหม่
			$row1_y = $pdf->GetY(); // รับค่าบรรทัด
			$x = $row1_x+10;
			$y = $row1_y+15;

$pdf->SetXY($x,$y); // บรรทัดเริ่ม

			$col_width = array(150); // ความกว้าง column ซ้าย,ขวา
			$col_height = 10;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height/2),"(ลงชื่อ)________________________________________________                              	(ลงชื่อ)________________________________________________",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"",0,0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height/2),"      (_______________________________________________)                                   (_______________________________________________)",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"",0,0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height+5),"ผู้เข้ารับการประชุมสัมมนา/จัดกิจกรรม                                                                                       หัวหน้ากลุ่มสาระ",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"",0,0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height+20),"(ลงชื่อ)________________________________________________                              	(ลงชื่อ)________________________________________________",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"",0,0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height+30),"      (_______________________________________________)                                   (_______________________________________________)",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"",0,0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height+40),"                 ฝ่ายงานวิชาการ                                                                                                            ผู้อำนวยการโรงเรียน",0,0,'C');

$pdf->Output(seminar.".pdf",'D');
?>