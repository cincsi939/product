<?php
ob_start();
session_start();
define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/fpdf.php');
require('kp7_class.php');
include ("libary/config.inc.php");
require("barcode/core.php");
require("../../../common/class.activitylog.php");
include("../../../common/std_function.inc.php");
$preview_status=1;
$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");

$activity_id = "A0001"; // รหัส log พิมพ์ PDF
$server_id = "S0001"; // รหัส server

if($dbname != "pty_master"){
		$xsiteid = substr($dbname,-4);
}



$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$monthsname = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
$mm_now = date("n");
$date_now = date("j");
$picture_logo = "krut.jpg" ;
$hrpicture = "bimg/nopicture.jpg" ;
$barcode = $_GET[barcode];


function writeimgfile($data,$hrpicture){
	$f = fopen($hrpicture,"w");
	fputs($f,$data);
	fclose($f);
}


include("gif.php");
function convert_gif2png($p_fl, $p_new_fl){

	if($gif = gif_loadFile($p_fl)) {
		// OK
		if(gif_outputAsPng($gif, $p_new_fl)) {
			// OK
			return true;
		}
		else {
			return false;
		}
	}
	else {
			return false;
	}

} // function


// Set Water Mark
$strx = " select approve_status from general where id='$id' ";
$queryx = mysql_query($strx);
$rsx = mysql_fetch_assoc($queryx); 
if($rsx[approve_status] == "approve"){
	$set_wk =1 ;$word_wk="สำเนา";
	$genbarcode = true;
}else{
	$set_wk =1 ;$word_wk="อยู่ระหว่างตรวจสอบ";
	$genbarcode = false;
}


if($preview_status==1){
	$set_wk =1 ;$word_wk="Preview";
	$genbarcode = false;
}
//@20/7/2550
function get_picture($id){
		global $xsiteid;
	$imgpath = "../../../../edubkk_image_file/$xsiteid/";
	$ext_array = array("jpg","jpeg","png","gif");
	if ($id <= "") return "";

	for ($i=0;$i<count($ext_array);$i++){
		$img_file = $imgpath . $id . "." . $ext_array[$i];
		if (file_exists($img_file)) return $img_file;
	}

	return "";
}

// ฟังชั่นก์ แสดงผล วัน เดือน ปี ไทย
function  showthaidate($number){

$digit=array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ');
$num=array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
$number = explode(".",$number);
$c_num[0]=$len=strlen($number[0]);
$c_num[1]=$len2=strlen($number[1]);
$convert='';

//คิดจำนวนเต็ม
for($n=0;$n< $len;$n++){
	$c_num[0]--;
	$c_digit=substr($number[0],$n,1);
	if($c_num[0]==0&& $c_digit==0)$digit[$c_digit]='';
	if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='เอ็ด';
	if($c_num[0]==0&& $c_digit==2)$digit[$c_digit]='สอง';
	if($c_num[0]==1&& $c_digit==0)$digit[$c_digit]='';
	if($c_num[0]==1&& $c_digit==1)$digit[$c_digit]='';
	if($c_num[0]==1&& $c_digit==2)$digit[$c_digit]='ยี่'; 

	$convert.=$digit[$c_digit];
		if($c_num[0] > 0 && $c_digit != 0 && $c_digit != ""){
			$convert.=$num[$c_num[0]]; 
		}
}
$convert .= "";
if($number[1]==''){$convert .= "";}

//คิดจุดทศนิยม
for($n=0;$n< $len2;$n++){ 
$c_num[1]--;
$c_digit=substr($number[1],$n,1);
if($c_num[1]==0&& $c_digit==1)$digit[$c_digit]='หนึ่ง';
if($c_num[1]==0&& $c_digit==2)$digit[$c_digit]='สอง';
if($c_num[1]==1&& $c_digit==2)$digit[$c_digit]='สอง'; 
if($c_num[1]==1&& $c_digit==1)$digit[$c_digit]='';
$convert.=$digit[$c_digit];
$convert.=$num[$c_num[1]]; 
}
if($number[1]!='')$convert .= "";
return $convert;

}
$pdf=new KP7();
$pdf->AliasNbPages();
$pdf->AddThaiFonts();
$pdf->AddPage();
$sql = "select t1.*,t2.religion as religionname,t3.blood as bloodgroup from  (general t1 left join $dbnamemaster.hr_religion t2 on t1.region=t2.id) left join $dbnamemaster.hr_blood t3 on t1.blood=t3.id where t1.id='$id'  ;";
		$result = mysql_query($sql);
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		$date_bd = explode("-",$rs[birthday]); // วันเกิด
		$getidcard = 	$rs[idcard] ;
			if ($rs[contact_tel] == ""){
				$xcontact_tel = " - ";
			}else{
				$xcontact_tel = $rs[contact_tel];
			}
		$rs[contact_add] = str_replace("ต.","ตำบล",$rs[contact_add]);
		$rs[contact_add] = str_replace("อ.","อำเภอ",$rs[contact_add]);
		$rs[contact_add] = str_replace("จ.","จังหวัด",$rs[contact_add]);

// รายการที่ 10

$pdf->SetXY(10,5);
$pdf->SetFont($font_format,'',12);
$pdf->Cell(190,6,'๑๐. ประวัติการศึกษา ฝึกอบรมและดูงาน ',1,1,'C');

$pdf->SetXY(10,11);

			$col_width = array(20,40,40,70,20);
			$col_height = 5;

			$pdf->SetFont($font_format,'',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"ประเภท",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"วันเริ่มต้น",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"ถึงวันที่",1,0,'C');

			$x += $col_width[2];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height),"ชื่อหลักสูตร",1,0,'C');
			
			$x += $col_width[3];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height),"รุ่น",1,0,'C');


// วุฒิการศึกษา
		$sql = "select * from seminar where id='$id' and kp7_active='1'order by runno asc;";
		$result = mysql_query($sql);
		
		$y =  $pdf->GetY();
		$y = $y+($col_height/1);
		$col_height = 5;
		
		while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){

			$obrom=0;
			$dongan=1;
			$seminar=2;

			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($rs[subject],60);
			$num_arr1 = count($arr_str1);
			
									if($rs[stype]==0){
									$stype="อบรม";}
									else if($rs[stype]==1){
											$stype="ดูงาน";
											}
									else if($rs[stype]==2){
											$stype="สัมมนา";
											
											}

			if(($num_arr1 == 1)){ // มีบรรทัดเดียว
			$x = $pdf->lMargin;				
			$pdf->SetFont($font_format,'',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height," $stype",1,1,'C');
											
			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$rs[startdate]",1,0,'C');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"$rs[enddate]",1,1,'C');
			
			$x += $col_width[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],$col_height,"$rs[subject]",1,1,'L');
			
			$x += $col_width[3];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],$col_height,"$rs[versions]",1,1,'C');
			
			$y +=  $col_height;

			}else{ // มีหลายบรรทัด

			for ($n=0;$n<$num_arr1;$n++) {
			if($y1 >= 260){$pdf->AddPage();$pdf->subAheader();$y=18;}
			$y1 = $y ;
			$y1  += $col_height;
			if($n==0){ // บรรทัดแรกให้แสดงข้อมูล
			$x = $pdf->lMargin;
			$pdf->SetFont($font_format,'',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height*$num_arr1)," $stype ",1,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height*$num_arr1),"$rs[startdate]",1,0,'C');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height*$num_arr1),"$rs[enddate]",1,0,'C');
			
			$x += $col_width[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height*$num_arr1),"",1,0,'L');
			
			$x += $col_width[3];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height*$num_arr1),"$rs[versions]",1,0,'C');
			
			} // end if

			if($n<$num_arr1 && $n != 0 ){$y += $col_height;}
			
			$x = $pdf->lMargin;

			$pdf->SetFont($font_format,'',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"",0,0,'L');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"",0,0,'C');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"",0,0,'L');
			
			$x += $col_width[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],$col_height,"$arr_str1[$n]",0,0,'L');
			if($n==($num_arr1-1)){$y += $col_height;}
			
			} // end else
			} // end 
			} // end while

$y = 270;
$setpass = "$date_bd[2]"."$date_bd[1]"."$date_bd[0]"."$getidcard" ;
//$pdf->SetProtection(array('print'),'competency',"$setpass");

$pdf->cfooter();
if($activitylog_barcode!=""){
$pdf->Output("tmp_pdf/".$activitylog_barcode.".pdf",'F');
}
$pdf->Output($id.".pdf",'D');
?>