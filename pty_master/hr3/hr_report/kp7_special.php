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
// ความสามารถพิเศษ
$pdf->AddPage();

$pdf->SetFont($font_format,'',16);
$pdf->SetXY(71,10);

$pdf->SetXY(10,5);

			$col_width = array(189); // กำหนดความกว้าง column
			$col_height = 8;

			$pdf->SetFont($font_format,'',16);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"๕.  ความสามารถพิเศษ",1,0,'C');

		$sql = "select t1.*,t2.major as majorname,t3.groupname from special t1 left join $dbnamemaster.hr_addmajor t2 on t1.major=t2.runid left join $dbnamemaster.specialgroup t3 on t1.specialgroup=t3.runid where t1.id='$id' and t1.kp7_active='1' order by t1.runno asc";
		$result = mysql_query($sql);

$pdf->SetXY(10,13);

			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;

			$pdf->SetXY($x,$y);

			$col_width = array(189);
			$col_height = 6;

			$pdf->SetFont($font_format,'',14);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

/*			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"สาขา",1,0,'C');*/

/*			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"กลุ่มความสามารถ",1,0,'C');

			$x = $row1_x;
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"รายละเอียด",1,0,'C');

		$y =  $pdf->GetY();
		$y = $y+($col_height);
		$col_height = 5;*/

		while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){

			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($rs[detail],130);
			$num_arr1 = count($arr_str1);

			$x = $pdf->lMargin;

			if($num_arr1 == 1){ // มีบรรทัดเดียว

			$pdf->SetFont($font_format,'',12);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"$rs[detail]",1,0,'L');

/*			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$rs[groupname]",1,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"$rs[detail]",1,0,'L');
*/			
			$y +=  $col_height;

			}else{ // มีหลายบรรทัด

			for ($n=0;$n<$num_arr1;$n++) {
			$y1 = $y ;
			$y1  += $col_height;
			if($y1 >= 265){$pdf->AddPage();}
			
			if($n==0){ // เขียนบรรทัดแรก

			$pdf->SetFont($font_format,'',14);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height*$num_arr1),"",1,0,'L');

/*			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height*$num_arr1),"$rs[groupname]",1,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height*$num_arr1),"",1,0,'L');
*/
			} // end if เขียนบรรทัดที่สอง

			if($n<$num_arr1 && $n != 0 ){$y += $col_height;}
			
			$x = $pdf->lMargin;

			$pdf->SetFont($font_format,'',14);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"$arr_str1[$n]",0,0,'L');

/*			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"",0,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"$arr_str1[$n]",0,0,'L');
*/
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