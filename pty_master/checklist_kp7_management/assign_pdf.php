<?php
session_start();
define('FPDF_FONTPATH','fpdf/font/');
include("checklist2.inc.php");
require('fpdf/fpdf.php');
require('pdf_class.php');
$db_name = $dbname_temp;

$npage = 260;
$picture_logo = "logo.jpg" ;
$pdf=new KP7();
$pdf->AliasNbPages();
$pdf->AddThaiFonts();
$pdf->AddPage();
$col_height = 7;

		$sql = "SELECT * FROM tbl_checklist_assign WHERE ticketid='$ticketid'";
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		
		$arrpage = CountPagePerPerson($ticketid,$profile_id);
		$page_all = array_sum($arrpage);
		
$pdf->Image("$picture_logo",10,10,60,15,"JPG",'');
$y = 30;
$pdf->SetFont('Angsana New','',16);
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"หนังสือรับมอบเอกสาร กพ.7",0,0,'C');

$y += $col_height;
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"หมายเลขงาน :",0,0,'L');
$pdf->SetXY(45,$y);
$pdf->Cell(0,5,$ticketid,0,0,'L');

$pdf->SetXY(100,$y);
$pdf->Cell(0,5,"วันที่รับเอกสาร : ",0,0,'L');
$pdf->SetXY(160,$y);
$pdf->Cell(0,5,thai_date($rs[date_recive]),0,0,'L');

$y += $col_height;
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"ชื่อ- นามสกุล : ",0,0,'L');
$pdf->SetXY(45,$y);
$pdf->Cell(0,5,show_user($rs[staffid]),0,0,'L');

$pdf->SetXY(100,$y);
$pdf->Cell(0,5,"วันที่คาดว่าจะดำเนินการแล้วเสร็จ :  ",0,0,'L');
$pdf->SetXY(160,$y);
$pdf->Cell(0,5,thai_date($rs[date_sent]),0,0,'L');


$y += $col_height;
  $sql_user = "SELECT *  FROM  keystaff  WHERE staffid='$rs[staffid]'";
  $result_user = mysql_db_query($dbcallcenter_entry,$sql_user);
  $rs_u = mysql_fetch_assoc($result_user);
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"หมายเลขโทรศัพท์ :  ",0,0,'L');
$pdf->SetXY(45,$y);
$pdf->Cell(0,5,$rs_u[telno],0,0,'L');

/*$pdf->SetXY(100,$y);
$pdf->Cell(0,5,"ประมาณการค่าบันทึกข้อมูล :   ",0,0,'L');
$pdf->SetXY(160,$y);
$pdf->Cell(0,5,number_format($rs[amount_pay],2)." บาท",0,0,'L');
*/

$y += $col_height;
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"จำนวน (ชุด/แผ่น) : ",0,0,'L');
$pdf->SetXY(45,$y);
$pdf->Cell(0,5,CountTicketDetail($rs[ticketid])." ชุด / ".$page_all." แผ่น",0,0,'L');

$y += $col_height;
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"เจ้าหน้าที่บริษัทฯ : ",0,0,'L');
$pdf->SetXY(45,$y);
$pdf->Cell(0,5,show_user($rs[staff_assign]),0,0,'L');



		   $sql_admin = "SELECT *  FROM  keystaff  WHERE staffid='$rs[staff_assign]'";
		  $result_admin = mysql_db_query($dbcallcenter_entry,$sql_admin);
		  $rs_admin = mysql_fetch_assoc($result_admin);

$pdf->SetXY(100,$y);
$pdf->Cell(0,5,"เบอร์โทรเจ้าหน้าที่บริษัทฯ : : ",0,0,'L');
$pdf->SetXY(160,$y);
$pdf->Cell(0,5,$rs_admin[telno],0,0,'L');



### หัวเอกสาร ######
$y += $col_height;
$pdf->header_assign_list(); //เรียกใช้ฟังก์แสดงส่วนหัวเอกสาร 
$arrpage = CountPagePerPerson($ticketid,$profile_id);

	$cyy = (date("Y")+543);
	$sql1 = "SELECT * FROM tbl_checklist_assign_detail WHERE ticketid='$ticketid' AND profile_id='$profile_id' ORDER BY name_th ASC";
	$result1 = mysql_db_query($db_name,$sql1);
	$k=0;
	while($rs1 = mysql_fetch_assoc($result1)){
		$arrp = ShowPersonDetail($rs1[idcard]);
	
	$org = $arrp['schoolid']."/".str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",show_area($rs1[siteid]));
	
	### ส่วนของการปัดบรรทัด
			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($org,43);
			$num_arr1 = count($arr_str1);
		$k++;
		$y += $col_height;
				
		if (($y) > $npage) {$pdf->AddPage();$pdf-> header_assign_list();$y=20;}
			$pdf->SetFont('Angsana New','',12);
	## end ส่วนของการปัดบรรทัด
		
		if($num_arr1 == 0){
			
			$x = 10;	

						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],$col_height,$k,1,0,'C');
			
						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],$col_height,"$rs1[idcard]",1,0,'C');
			
						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],$col_height,"$rs1[prename_th]$rs1[name_th]  $rs1[surname_th]",1,0,'L');
			
			
						$x += $col_width[2];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[3],($col_height),"",1,0,'L');
			
						///$arrp['position_now']
						$x += $col_width[3];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[4],($col_height),"",1,0,'C');
			
					  
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[5],($col_height),floor($arrp['age_gov']),1,0,'C');
						
						$x += $col_width[5];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[6],($col_height),$arrpage[$rs1[idcard]],1,0,'C');
				}else{
					
							for ($n=0;$n<$num_arr1;$n++) {
					//			$y1 = $y ;
//								$y1  += $col_height;
								//if($y1 >= 265){$pdf->AddPage();}
								$x = 10;	

								
							if($n==0){ // เขียนบรรทัดแรก

						$pdf->SetFont('Angsana New','',12);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],($col_height*$num_arr1),$k,1,0,'C');
			
						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],($col_height*$num_arr1),"$rs1[idcard]",1,0,'C');
			
						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],($col_height*$num_arr1),"$rs1[prename_th]$rs1[name_th]  $rs1[surname_th]",1,0,'L');
			
			
						$x += $col_width[2];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[3],($col_height*$num_arr1),$arrp['position_now'],1,0,'L');
			
						$x += $col_width[3];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[4],($col_height*$num_arr1),$org,1,0,'C');
			
					 	  
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[5],($col_height*$num_arr1),floor($arrp['age_gov']),1,0,'C');
						
						
						$x += $col_width[5];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[6],($col_height*$num_arr1),$arrpage[$rs1[idcard]],1,0,'C');

			} // end if เขียนบรรทัดที่สอง
			if($n<$num_arr1 && $n != 0 ){$y += $col_height;}
						$x = $pdf->lMargin;

						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],$col_height,"",0,0,'C');
			
						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],$col_height,"",0,0,'C');
			
						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],$col_height,"",0,0,'L');
			
			
						$x += $col_width[2];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[3],($col_height)," ",0,0,'L');
			
						$x += $col_width[3];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[4],($col_height),$arr_str1[$n],0,0,'C');
			
					 	  
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[5],($col_height),"",0,0,'C');
						
						$x += $col_width[5];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[6],($col_height),"",0,0,'C');

			//if($n==($num_arr1-1)){$y += $col_height;}

							}// end for ($n=0;$n<$num_arr1;$n++) {				
				
				}// end if($num_arr1 == "0"){
	if (($y) > $npage) {$pdf->AddPage();$pdf-> header_assign_list();$y=20;}
	}// end while


$y = $y+15;
$pdf->SetFont('Angsana New','',14);
if (($y) > $npage) {$pdf->AddPage();$y=20;}
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"ข้าพเจ้าได้รับสำเนาทะเบียนประวัติ ก.พ.7 จากบริษัท แซฟไฟร์ รีเสิร์ช แอนด์ ดีเวลล็อปเม็นท์ จำกัด ตามรายการ ",0,0,'L');
$y += $col_height;

if (($y) > $npage) {$pdf->AddPage();$y=20;}
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"ข้างต้น ข้าพเจ้าจะดูแลเอกสารที่ได้รับมาทั้งหมดเป็นอย่างดีและไม่นำไปทำสำเนาซ้ำไม่ว่าด้วยกรณีใด ๆ",0,0,'L');
$y += $col_height;

if (($y) > $npage) {$pdf->AddPage();$y=20;}
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"พร้อมกับจะนำมาส่งคืนให้กับบริษัทฯ ทันทีเมื่อดำเนินการบันทึกข้อมูลแล้วเสร็จหรือทางบริษัทฯทวงถาม",0,0,'L');
$y += $col_height;

if (($y) > $npage) {$pdf->AddPage();$y=20;}
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"หากเกิดความเสียหายกับเอกสาร เอกสารสูญหาย ข้าพเจ้ายินดีรับผิดชอบต่อความเสียหายทั้งปวงที่เกิดขึ้นตามที่",0,0,'L');
$y += $col_height;

if (($y) > $npage) {$pdf->AddPage();$y=20;}
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"บริษัทฯ เรียกร้อง",0,0,'L');


$y += $col_height;

if (($y) > $npage) {$pdf->AddPage();$y=20;}

$pdf->SetXY(40,$y);
$pdf->Cell(0,5,"........................................",0,0,'L');                                                   $pdf->SetXY(130,$y);
																																$pdf->Cell(0,5,"........................................",0,0,'L');


$y += $col_height;

if (($y) > $npage) {$pdf->AddPage();$y=20;}

$pdf->SetXY(40,$y);
$pdf->Cell(32,5,"(  ".show_user($rs[staffid])."  )",0,0,'C');											$pdf->SetXY(130,$y);
																																$pdf->Cell(32,5,"(  ".show_user($rs[staff_assign])."  )",0,0,'C');



$y += $col_height;

if (($y) > $npage) {$pdf->AddPage();$y=20;}
$pdf->SetXY(40,$y);
$pdf->Cell(30,5," ผู้รับจ้าง ",0,0,'C');																					$pdf->SetXY(130,$y);
																																	$pdf->Cell(30,5," เจ้าหน้าที่บริษัทฯ ",0,0,'C');
$y += ($col_height+5);
//$temp_user = show_user($rs[staffid]);

//$y += ($col_height+5);
//if (($y) > $npage) {$pdf->AddPage();$y=20;}
//$pdf->SetXY(10,$y);
//$pdf->Cell(0,5,"จังหวัดปทุมธานี : เลขที่ 131 ห้องเลขที่ ไอซี 1-207 ชั้น 2 อาคารอุทยานวิทยาศาสตร์ประเทศไทย ถ.พหลโยธิน ",0,0,'C');		
//
//$y += $col_height;
//if (($y) > $npage) {$pdf->AddPage();$y=20;}
//$pdf->SetXY(10,$y);
//$pdf->Cell(0,5,"ต. คลองหนึ่ง อ.คลองหลวง จ.ปทุมธานี 12120 โทรซ 0-2564-7880-1 แฟกซ์ 0-2564-7882 ",0,0,'C');		
	
$y += $col_height;
if (($y) > $npage) {$pdf->AddPage();$y=20;}
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"จังหวัดเชียงใหม่ : 199/445 หมู่ / 2 ต. หนองจ๊อม อ.สันทราย  จ.เชียงใหม่ 50210 ",0,0,'C');			
		
$y += $col_height;
if (($y) > $npage) {$pdf->AddPage();$y=20;}
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"โทร: 0-5324-8985  แฟกซ์   0-5385-4907",0,0,'C');																										
														

$pdf->Output("$ticketid.pdf",'D');
		
?>
