<?php
session_start();
define('FPDF_FONTPATH','fpdf/font/');
include "epm.inc.php";
include("function_assign.php");
require('fpdf/fpdf.php');
require('pdf_class.php');

$npage = 260;
$picture_logo = "logo.jpg" ;
include("gif.php");
$pdf=new KP7();
$pdf->AliasNbPages();
$pdf->AddThaiFonts();
$pdf->AddPage();
$col_height = 7;

		$sql = "SELECT * FROM tbl_assign_sub WHERE ticketid='$ticketid'";
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		
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
$pdf->Cell(0,5,show_date($rs[recive_date]),0,0,'L');

$y += $col_height;
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"ชื่อ- นามสกุล : ",0,0,'L');
$pdf->SetXY(45,$y);
$pdf->Cell(0,5,show_user($rs[staffid]),0,0,'L');

$pdf->SetXY(100,$y);
$pdf->Cell(0,5,"วันที่คาดว่าจะดำเนินการแล้วเสร็จ :  ",0,0,'L');
$pdf->SetXY(160,$y);
$pdf->Cell(0,5,show_date($rs[sent_date]),0,0,'L');


$y += $col_height;
  $sql_user = "SELECT *  FROM  keystaff  WHERE staffid='$rs[staffid]'";
  $result_user = mysql_db_query($db_name,$sql_user);
  $rs_u = mysql_fetch_assoc($result_user);
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"หมายเลขโทรศัพท์ :  ",0,0,'L');
$pdf->SetXY(45,$y);
$pdf->Cell(0,5,$rs_u[telno],0,0,'L');

$pdf->SetXY(100,$y);
$pdf->Cell(0,5,"ประมาณการค่าบันทึกข้อมูล :   ",0,0,'L');
$pdf->SetXY(160,$y);
$pdf->Cell(0,5,number_format($rs[amount_pay],2)." บาท",0,0,'L');


$y += $col_height;
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"จำนวน (ชุด/แผ่น) : ",0,0,'L');
$pdf->SetXY(45,$y);
$pdf->Cell(0,5,count_assign_key($rs[ticketid])." ชุด / ".sum_count_page($rs[ticketid])." แผ่น",0,0,'L');

$y += $col_height;
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"เจ้าหน้าที่บริษัทฯ : ",0,0,'L');
$pdf->SetXY(45,$y);
$pdf->Cell(0,5,show_user($rs[admin_id]),0,0,'L');



		   $sql_admin = "SELECT *  FROM  keystaff  WHERE staffid='$rs[admin_id]'";
		  $result_admin = mysql_db_query($db_name,$sql_admin);
		  $rs_admin = mysql_fetch_assoc($result_admin);

$pdf->SetXY(100,$y);
$pdf->Cell(0,5,"เบอร์โทรเจ้าหน้าที่บริษัทฯ : : ",0,0,'L');
$pdf->SetXY(160,$y);
$pdf->Cell(0,5,$rs_admin[telno],0,0,'L');



### หัวเอกสาร ######
$y += $col_height;
$pdf->header_assign_list(); //เรียกใช้ฟังก์แสดงส่วนหัวเอกสาร 

	$cyy = (date("Y")+543);
	$sql1 = "SELECT
	$db_name.tbl_assign_key.ticketid,
	$db_name.tbl_assign_key.estimate_pay,
	$dbnamemaster.view_general.CZ_ID,
	$dbnamemaster.view_general.siteid,
	$dbnamemaster.view_general.prename_th,
	$dbnamemaster.view_general.name_th,
	$dbnamemaster.view_general.surname_th,
	$dbnamemaster.view_general.position_now,
	$dbnamemaster.view_general.schoolid,
	TIMESTAMPDIFF(MONTH,begindate,'$cyy-09-30')/12 AS age_gov  
	FROM
	$db_name.tbl_assign_key
	Inner Join $dbnamemaster.view_general ON $db_name.tbl_assign_key.idcard = $dbnamemaster.view_general.CZ_ID WHERE $db_name.tbl_assign_key.ticketid='$ticketid'";
	$result1 = mysql_db_query($db_name,$sql1);
	$k=0;
	while($rs1 = mysql_fetch_assoc($result1)){
	
	$org = show_org($rs1[schoolid])."/".show_area($rs1[siteid]);
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
						$pdf->Cell($col_width[1],$col_height,"$rs1[CZ_ID]",1,0,'L');
			
						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],$col_height,"$rs1[prename_th]$rs1[name_th]  $rs1[surname_th]",1,0,'L');
			
			
						$x += $col_width[2];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[3],($col_height),$org,1,0,'L');
			
						$x += $col_width[3];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[4],($col_height),floor($rs1[age_gov]),1,0,'C');
			
					 	$page_result = count_page($rs1[CZ_ID],$rs1[siteid]);  if($page_result <= 1){ $page_result = 3;}else{ $page_result = $page_result;}  
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[5],($col_height),$page_result,1,0,'C');
						
						$x += $col_width[5];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[6],($col_height),number_format($rs1[estimate_pay],2),1,0,'R');
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
						$pdf->Cell($col_width[1],($col_height*$num_arr1),"$rs1[CZ_ID]",1,0,'L');
			
						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],($col_height*$num_arr1),"$rs1[prename_th]$rs1[name_th]  $rs1[surname_th]",1,0,'L');
			
			
						$x += $col_width[2];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[3],($col_height*$num_arr1)," ",1,0,'L');
			
						$x += $col_width[3];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[4],($col_height*$num_arr1),floor($rs1[age_gov]),1,0,'C');
			
					 	$page_result = count_page($rs1[CZ_ID],$rs1[siteid]);  if($page_result <= 1){ $page_result = 3;}else{ $page_result = $page_result;}  
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[5],($col_height*$num_arr1),$page_result,1,0,'C');
						
						$x += $col_width[5];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[6],($col_height*$num_arr1),number_format($rs1[estimate_pay],2),1,0,'R');

			} // end if เขียนบรรทัดที่สอง
			if($n<$num_arr1 && $n != 0 ){$y += $col_height;}
						$x = $pdf->lMargin;

						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],$col_height,"",0,0,'C');
			
						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],$col_height,"",0,0,'L');
			
						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],$col_height,"",0,0,'L');
			
			
						$x += $col_width[2];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[3],($col_height),"$arr_str1[$n] ",0,0,'L');
			
						$x += $col_width[3];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[4],($col_height),"",0,0,'C');
			
					 	$page_result = count_page($rs1[CZ_ID],$rs1[siteid]);  if($page_result <= 1){ $page_result = 3;}else{ $page_result = $page_result;}  
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[5],($col_height),"",0,0,'C');
						
						$x += $col_width[5];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[6],($col_height),"",0,0,'R');

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
																																$pdf->Cell(32,5,"(  ".show_user($rs[admin_id])."  )",0,0,'C');



$y += $col_height;

if (($y) > $npage) {$pdf->AddPage();$y=20;}
$pdf->SetXY(40,$y);
$pdf->Cell(30,5," ผู้รับจ้าง ",0,0,'C');																					$pdf->SetXY(130,$y);
																																	$pdf->Cell(30,5," เจ้าหน้าที่บริษัทฯ ",0,0,'C');

//$temp_user = show_user($rs[staffid]);

$y += ($col_height+5);
if (($y) > $npage) {$pdf->AddPage();$y=20;}
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"จังหวัดปทุมธานี : เลขที่ 131 ห้องเลขที่ ไอซี 1-207 ชั้น 2 อาคารอุทยานวิทยาศาสตร์ประเทศไทย ถ.พหลโยธิน ",0,0,'C');		

$y += $col_height;
if (($y) > $npage) {$pdf->AddPage();$y=20;}
$pdf->SetXY(10,$y);
$pdf->Cell(0,5,"ต. คลองหนึ่ง อ.คลองหลวง จ.ปทุมธานี 12120 โทรซ 0-2564-7880-1 แฟกซ์ 0-2564-7882 ",0,0,'C');		
	
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
