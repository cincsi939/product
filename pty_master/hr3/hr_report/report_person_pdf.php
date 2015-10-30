<?php
ob_start();
session_start();
define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/fpdf.php');
require('kp7_class.php');
include ("libary/config.inc.php");
require("barcode/core.php");
require("class.activitylog.php");
include("../../../common/class-date-format.php");
include("../../../common/std_function.inc.php");
include ("../../../config/phpconfig.php");
include ("timefunc.inc.php");
$preview_status=1;
$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");

$activity_id = "A0001"; // รหัส log พิมพ์ PDF
$server_id = "S0001"; // รหัส server
$kp7="1"; // รหัส เปิดการแสดงผลข้อมูล กพ 7

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
	//$imgpath = "images/personal/";
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
if($len > 2){
	$a1 = $len - 1 ;
	$f_digit = substr($number[0],$a1,1);
}
//คิดจำนวนเต็ม
for($n=0;$n< $len;$n++){
	$c_num[0]--;
	$c_digit=substr($number[0],$n,1);
	if($c_num[0]==0&& $c_digit==0)$digit[$c_digit]='';

	if($len>1 && $len <= 2){
		if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='เอ็ด';
	}else if ($len>3){
		if($f_digit == 0){
			if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='หนึ่ง';
		}else{
			if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='เอ็ด';
		}
	}else{
		if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='หนึ่ง';
	}

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

		$hrpicture = array();
		$np = 0;
		$xresult = mysql_query("select * from general_pic where id='$id' and kp7_active='$kp7' order by no asc");
		while ($xrs = mysql_fetch_assoc($xresult)){
			//$img_file = "images/personal/$xrs[imgname]";
			$img_file = "../../../../edubkk_image_file/$rs[siteid]/$xrs[imgname]";
			$hrpicture[$np] = $img_file;
			$hrpicture_yy[$np] = $xrs[yy];
			$x = explode(".",$img_file);
			$ext[$np] = strtoupper($x[count($x) - 1]);
			if ($ext[$np] == "GIF"){
				$hrpicture[$np] = "bimg/temppicture.png" ;	
				convert_gif2png($img_file,$hrpicture[$np]);
				$ext[$np] = "PNG";

			}

			$np++;

		}

/*

//		If ($rs[pic] =='' or strlen($rs[pic]) < 100){

		$img_file = get_picture($id);
		 If ($img_file == ""){
			$hrpicture = "bimg/nopicture.jpg" ;
		}else{
			$hrpicture = $img_file;
			$x = explode(".",$img_file);
			$ext = strtolower($x[count($x) - 1]);
			if ($ext == "gif"){
				$hrpicture = "bimg/temppicture.png" ;
				convert_gif2png($img_file,$hrpicture);
				$ext = "PNG";

			}
*/
/*
			//header("Content-Type: " . $rs[pictype]);
			if (stristr($rs[pictype] ,"jpg") || stristr($rs[pictype] ,"jpeg")){
				$hrpicture = "bimg/temppicture.jpg" ;
				$ext = "JPG";
				writeimgfile($rs[pic],$hrpicture);
			}else if (stristr($rs[pictype] ,"gif")){
				$hrpicture1 = "bimg/temppicture.gif" ;
				$hrpicture = "bimg/temppicture.png" ;
				writeimgfile($rs[pic],$hrpicture1);
				convert_gif2png($hrpicture1,$hrpicture);
				$ext = "PNG";
			}else if (stristr($rs[pictype] ,"png")){
				$hrpicture = "bimg/temppicture.png" ;
				$ext = "PNG";
				writeimgfile($rs[pic],$hrpicture);
			}else{
				$hrpicture = "bimg/nopicture.jpg" ;
				$ext = "JPG";
			}
	*/
/*	
		}
*/

$pdf->Image("$picture_logo",100,5,14,17,"JPG",'');
$pdf->SetFont('Angsana New','',14);
$pdf->SetXY(71,10);
$pdf->Cell(71,30,'ประวัติการรับราชการ',0,0,'C');
			
/*$pdf->SetXY(10,30); // ส่วนแสดงกรอบรูป

			$col_width = array(27,27,27,27,27,27,27); // กำหนดความกว้าง column
			$col_height = 31;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height," ",1,0,'C');


			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height," ",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height," ",1,0,'C');

			$x += $col_width[2];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],$col_height," ",1,0,'C');

			$x += $col_width[3];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],$col_height," ",1,0,'C');

			$x += $col_width[4];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],$col_height," ",1,0,'C');

			$x += $col_width[5];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[6],$col_height," ",1,0,'C');

$pdf->SetXY(8,30); // ส่วนแสดงรูป

			$col_width = array(27,27,27,27,27,27,27); // กำหนดความกว้าง column
			$col_height = 24;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			if ($hrpicture[0]) $pdf->Image($hrpicture[0],$x+4,$y+1,23,30,$ext[0],'C');


			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			if ($hrpicture[1]) $pdf->Image($hrpicture[1],$x+4,$y+1,23,30,$ext[1],'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			if ($hrpicture[2]) $pdf->Image($hrpicture[2],$x+4,$y+1,23,30,$ext[2],'C');

			$x += $col_width[2];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			if ($hrpicture[3]) $pdf->Image($hrpicture[3],$x+4,$y+1,23,30,$ext[3],'C');

			$x += $col_width[3];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			if ($hrpicture[4]) $pdf->Image($hrpicture[4],$x+4,$y+1,23,30,$ext[4],'C');

			$x += $col_width[4];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			if ($hrpicture[5]) $pdf->Image($hrpicture[5],$x+4,$y+1,23,30,$ext[5],'C');

			$x += $col_width[5];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			if ($hrpicture[6]) $pdf->Image($hrpicture[6],$x+4,$y+1,23,30,$ext[6],'C');

$pdf->SetXY(10,61); // ส่วนแสดงช่อง ปี พ.ศ.
			
			$col_width = array(27,27,27,27,27,27,27); // กำหนดความกว้าง column
			$col_height = 10;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height/2),"รูปที่ ๑",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
			//กรณีไม่ระบุ พ.ศ. รูปที่ 1
			if($hrpicture_yy[0] >0){
			$pdf->Cell($col_width[0],($col_height/2),"พ.ศ. $hrpicture_yy[0]",0,0,'C');
			}else if($hrpicture[0] !=""){
			$pdf->Cell($col_width[0],($col_height/2),"พ.ศ. ไม่ระบุ",0,0,'C');
			}else{
			$pdf->Cell($col_width[0],($col_height/2),"พ.ศ.",0,0,'C');
			}
			// จบ if 1
			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height/2),"รูปที่ ๒",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
			// กรณีไม่ระบบ พ.ศ. รูปที่ 2
			if($hrpicture_yy[1] >0){
			$pdf->Cell($col_width[1],($col_height/2),"พ.ศ. $hrpicture_yy[1]",0,0,'C');
			}else if($hrpicture[1] !=""){
			$pdf->Cell($col_width[1],($col_height/2),"พ.ศ. ไม่ระบุ",0,0,'C');
			}else{
			$pdf->Cell($col_width[1],($col_height/2),"พ.ศ.",0,0,'C');
			}
			// จบ if 2
			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height/2),"รูปที่ ๓",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
			// กรณีไม่ระบบ พ.ศ. รูปที่ 3
			if($hrpicture_yy[2] >0){
			$pdf->Cell($col_width[2],($col_height/2),"พ.ศ. $hrpicture_yy[2]",0,0,'C');
			}else if($hrpicture[2] !=""){
			$pdf->Cell($col_width[2],($col_height/2),"พ.ศ. ไม่ระบุ",0,0,'C');
			}else{
			$pdf->Cell($col_width[2],($col_height/2),"พ.ศ.",0,0,'C');
			}
			// จบ if 3
			$x += $col_width[2];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height/2),"รูปที่ ๔",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
				// กรณีไม่ระบบ พ.ศ. รูปที่ 4
				if($hrpicture_yy[3] >0){
				$pdf->Cell($col_width[3],($col_height/2),"พ.ศ. $hrpicture_yy[3]",0,0,'C');
				}else if($hrpicture[3] !=""){
				$pdf->Cell($col_width[3],($col_height/2),"พ.ศ. ไม่ระบุ",0,0,'C');
				}else{
				$pdf->Cell($col_width[3],($col_height/2),"พ.ศ.",0,0,'C');
				}
				// จบ if 4
			$x += $col_width[3];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height/2),"รูปที่ ๕",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
			// กรณีไม่ระบุปีพ.ศ.
			if($hrpicture_yy[4] >0){
			$pdf->Cell($col_width[4],($col_height/2),"พ.ศ. $hrpicture_yy[4]",0,0,'C');
			}else if($hrpicture[4] !=""){
			$pdf->Cell($col_width[4],($col_height/2),"พ.ศ. ไม่ระบุ",0,0,'C');
			}else{
			$pdf->Cell($col_width[4],($col_height/2),"พ.ศ.",0,0,'C');
			}
			// จบ
			
			$x += $col_width[4];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height/2),"รูปที่ ๖",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);

			// กรณีไม่มี พ.ศ.
			if($hrpicture_yy[5] >0){
			$pdf->Cell($col_width[5],($col_height/2),"พ.ศ. $hrpicture_yy[5]",0,0,'C');
			}else if($hrpicture[5] !=""){
			$pdf->Cell($col_width[5],($col_height/2),"พ.ศ. ไม่ระบุ",0,0,'C');
			}else{
			$pdf->Cell($col_width[5],($col_height/2),"พ.ศ. ",0,0,'C');
			}
			
			//จบ
			
			$x += $col_width[5];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[6],($col_height/2),"รูปที่ ๗",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[6],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
			// กรณีไม่ระบุปีพ.ศ.
			if($hrpicture_yy[6] >0){
			$pdf->Cell($col_width[6],($col_height/2),"พ.ศ. $hrpicture_yy[6]",0,0,'C');
			}else if($hrpicture[6] !=""){
			$pdf->Cell($col_width[6],($col_height/2),"พ.ศ. ไม่ระบุ",0,0,'C');
			}else{
			$pdf->Cell($col_width[6],($col_height/2),"พ.ศ. ",0,0,'C');
			}
			
			//จบ if*/
			
		## ข้อมูลประวัติส่วนบุคคล
$sql_general = "SELECT id,idcard,siteid,prename_th,name_th,surname_th,position_now,prename_en,name_en,surname_en,birthday,contact_add,radub,level_id,begindate,schoolid,noposition,education FROM general WHERE id='$id'";
$result_general = mysql_db_query($dbname,$sql_general);
$rsv = mysql_fetch_assoc($result_general);

$sql_salary = "SELECT max(date) as maxdate FROM salary WHERE id='".$id."'";
$result_salary = mysql_db_query($dbname,$sql_salary);
$rs_salary = mysql_fetch_assoc($result_salary);

	$sql_pic = "SELECT * FROM general_pic WHERE id='$id' ORDER BY no DESC  LIMIT 1";
	$resust_pic = mysql_db_query($db_name,$sql_pic);
	$pathfile = "../../../../edubkk_image_file/$rsv[siteid]/";
	$rs_pic = mysql_fetch_assoc($resust_pic);
	$imgshow = $pathfile.$rs_pic[imgname];
	$imgyy = "ภาพ ปีพ.ศ.".$rs_pic[yy];

			$y=31;
			$pdf->SetXY(10,$y); 	###  ชื่อ – สกุล (ไทย)
			$col_width = array(189); // กำหนดความกว้าง column
			$col_height = 8;
			$img_height = 40;

			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();
			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetFont('Angsana New','',16);
			$pdf->SetXY(10,$y);

			$pdf->SetXY($x ,$y);
			$pdf->Cell(($col_width[0]),$col_height,"ประวัติส่วนบุคคล",1,0,'L');
			
			$col_width = array("30","65","30","64");
			$pdf->SetFont('Angsana New','',12);
			
			$y=31;
			###  ชื่อ – สกุล (ไทย)
			$y = $y+$col_height;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"ชื่อ – สกุล (ไทย)",1,0,'L');
			
			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1]+$col_width[2],$col_height,"$rsv[prename_th]$rsv[name_th]  $rsv[surname_th]",1,0,'L');
			
			$x += ($col_width[1]+$col_width[2]);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],$img_height," ",1,0,'L');
			//$pdf->Image("$picture_logo",100,5,14,17,"JPG",'');
//			$x += ($col_width[1]+$col_width[2]+20);
//			$pdf->SetXY($x ,$y);
//			$pdf->Cell("30",$img_height," ",1,0,'L');
			$pdf->Image($imgshow,$x+20,$y+1,23,30,$ext[0],'C');

			## ชื่อ – สกุล (อังกฤษ)
			$y = $y+$col_height;
			$x = $row1_x;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"ชื่อ – สกุล (อังกฤษ)",1,0,'L');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1]+$col_width[2],$col_height,"$rsv[prename_en]$rsv[name_en]  $rsv[surname_en]",1,0,'L');
			
			## วัน-เดือน-ปี เกิด
			$y = $y+$col_height;
			$x = $row1_x;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"วัน-เดือน-ปี เกิด",1,0,'L');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1]+$col_width[2],$col_height,"".MakeDate($rsv[birthday]),1,0,'L');
			
			##ที่อยู่ปัจจุบัน
			$y = $y+$col_height;
			$x = $row1_x;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height*2),"ที่อยู่ปัจจุบัน",1,0,'L');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1]+$col_width[2],($col_height*2),"$rsv[contact_add]",1,0,'L');
			
			##แถว blank
			$y = $y+$col_height;
//			$x = $row1_x;
//			$pdf->SetXY($x ,$y);
//			$pdf->Cell(($col_width[0]+$col_width[1]+$col_width[2]),$col_height," ",1,0,'L');
//			
			$x += $col_width[1]+$col_width[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],$col_height,"$imgyy",0,0,'C');
			
			##ตำแหน่ง
			$y = $y+$col_height;
			$x = $row1_x;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"ตำแหน่ง",1,0,'L');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$rsv[position_now]",1,0,'L');
			
			## เลขที่ตำแหน่ง
			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"เลขที่ตำแหน่ง",1,0,'L');
			
			$x += $col_width[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],$col_height,"$rsv[noposition]",1,0,'L');

			##ระดับ
			if($rsv[level_id] != ""){
				$xradub = ShowRadub($rsv[level_id]);
			}else{
				$xradub = "$rsv[radub]";	
			}
			$y = $y+$col_height;
			$x = $row1_x;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"ระดับ",1,0,'L');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$xradub",1,0,'L');
			
			## การศึกษาสูงสุด
			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"การศึกษาสูงสุด",1,0,'L');
			
			$x += $col_width[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],$col_height,"$rsv[education]",1,0,'L');
			
			##อายุราชการ ณ ปัจจุบัน
			$diff  = dateLength($rsv[begindate]);
					if ($rsv[begindate] != ""){
						$xbegindate = $diff[year]." ปี ".$diff[month]." เดือน ".$diff[day]." วัน";
					}else{
						$xbegindate = "-";
					}
			$y = $y+$col_height;
			$x = $row1_x;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"อายุราชการ ณ ปัจจุบัน",1,0,'L');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$xbegindate",1,0,'L');
			
			## วันครบเกษียณอายุ
			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"วันครบเกษียณอายุ",1,0,'L');
			
			$x += $col_width[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],$col_height,"".retireDate($rsv[birthday]),1,0,'L');

			##หน่วยงาน
			if($rsv[schoolid] != $rsv[siteid]){ $prearea = "โรงเรียน";}else{ $prearea = "";}
				$xarea =  $prearea."".ShowSchool($rsv[schoolid])." / ".ShowArea($rsv[siteid]);
			$y = $y+$col_height;
			$x = $row1_x;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"หน่วยงาน",1,0,'L');
			
			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell(($col_width[1]+$col_width[2]+$col_width[3]),$col_height,"$xarea",1,0,'L');

################  ประวัติการศึกษา
			$col_width = array(189); // กำหนดความกว้าง column
			$y = $y+16;
			$pdf->SetFont('Angsana New','',16);
			$pdf->SetXY(10,$y);
			$pdf->Cell(($col_width[0]),$col_height,"ประวัติการศึกษา",1,0,'L');
			$col_width = array("50","15","42","41","41");
			$y +=$y;
			$x =  $row1_x;
			$pdf->SetXY($x,$y);
			$pdf->Cell(($col_width[0]),$col_height,"ระดับการศึกษา",1,0,'L');
			
			$x +=  $col_width[0];
			$pdf->SetXY($x,$y);
			$pdf->Cell(($col_width[1]),$col_height,"ปีที่สำเร็จการศึกษา",1,0,'L');
			
			$x +=  $col_width[1];
			$pdf->SetXY($x,$y);
			$pdf->Cell(($col_width[2]),$col_height,"วุฒิการศึกษา",1,0,'L');
			
			


$y = 270;
$setpass = "$date_bd[2]"."$date_bd[1]"."$date_bd[0]"."$getidcard" ;
//$pdf->SetProtection(array('print'),'competency',"$setpass");

$pdf->cfooter();
if($activitylog_barcode!=""){
$pdf->Output("tmp_pdf/".$activitylog_barcode.".pdf",'F');
}
$pdf->Output($id.".pdf",'D');
?>