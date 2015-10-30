<?php
ob_start();
session_start();
define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/fpdf.php');
require('kp7_class.php');
//require('kp7pdf_class.php');
include ("libary/config.inc.php");
require("barcode/core.php");
require("class.activitylog.php");
include("../../../common/class-date-format.php");
include("../../../common/std_function.inc.php");
include ("../../../config/phpconfig.php");
include ("timefunc.inc.php");
$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");

$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$monthsname = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");
$picture_logo = "krut.jpg" ;
$hrpicture = "bimg/nopicture.jpg" ;
//$barcode = $_GET[barcode];


if($_GET['id'] != ""){
		$id = $_GET['id'];
}else{
		$id = $id;
}

if(!empty($_GET['xsiteid'])){
	if($_GET['xsiteid'] != "pty_master"){
		$db_name = STR_PREFIX_DB.$_GET['xsiteid'];	
	}
}


function writeimgfile($data,$hrpicture){
	$f = fopen($hrpicture,"w");
	fputs($f,$data);
	fclose($f);
}
$npage = 260;
$pdf = new KP7();
$pdf->AliasNbPages();
$pdf->AddThaiFonts();
$pdf->AddPage();
$pdf->SetFont('Angsana New','B',16);
$y = 18;		
$x = 20;

$pdf->Image("$picture_logo",100,5,14,17,"JPG",'');
$pdf->SetXY($x,$y);
$pdf->Cell(175,15,"����ѵԡ���Ѻ�Ҫ���",0,0,'C');


## Begin  ����ѵ���ǹ�ؤ��
$sql_general = "SELECT id,idcard,siteid,prename_th,name_th,surname_th,position_now,prename_en,name_en,surname_en,birthday,contact_add,radub,level_id,begindate,schoolid,noposition,education FROM general WHERE id='$id'";
$result_general = mysql_db_query($db_name,$sql_general);
$rsv = mysql_fetch_assoc($result_general);

$sql_salary = "SELECT position, noposition FROM `salary` WHERE `id` = '".$rsv['id']."' ORDER BY  updatetime DESC LIMIT 1 ";
$result_salary = mysql_db_query($db_name,$sql_salary);
$rsv_salary = mysql_fetch_assoc($result_salary);

$y+=15;
$setY_call_person = 20;
$pdf->SetFont('Angsana New','B',12);
$pdf->SetXY($x,$y);
$pdf->Cell(180,6,"����ѵ���ǹ�ؤ��",1,0,'L');

$setX_call_person = 40;//����� �����Ż���ѵ���ǹ�ؤ��
$y+=6;

$pdf->SetFont('Angsana New','',12);
$pdf->SetXY($x+$setX_call_person,$y);
$pdf->Cell(140,6*5,"",1,0,'L');
	#Begin �ٻ
	$sql_pic = "SELECT * FROM general_pic WHERE id='$id' ORDER BY yy DESC LIMIT 0,1 ";
	$resust_pic = mysql_db_query($db_name,$sql_pic);
	$num_pic = mysql_num_rows($resust_pic);
	$pathfile = "../../../../edubkk_image_file/$rsv[siteid]/";
	$i=0;
	while($rs_pic = mysql_fetch_assoc($resust_pic)){
		$arrImge = $pathfile.$rs_pic['imgname'];	
		$arrYY = "�Ҿ �վ.�.".$rs_pic['yy'];
		$i++;
	}
	if(is_file($arrImge)){
		$pdf->Image($arrImge,170,40,18,25,"JPG",'');
		$pdf->SetXY($x+$setX_call_person+50,$y+25);
		$pdf->Cell(140,6,$arrYY,0,0,'C');
	}
	#Begin �ٻ

$pdf->SetFont('Angsana New','B',12);
$pdf->SetXY($x,$y);
$pdf->Cell(180-$setX_call_person,6,"���� � ʡ�� (��)",1,0,'L');

$pdf->SetFont('Angsana New','',12);
$pdf->SetXY($x+$setX_call_person,$y);
$pdf->Cell(100,6,$rsv['prename_th'].$rsv['name_th']."  ".$rsv['surname_th'],1,0,'L');

$y+=6;
$pdf->SetFont('Angsana New','B',12);
$pdf->SetXY($x,$y);
$pdf->Cell(180-$setX_call_person,6,"���� � ʡ�� (�ѧ���)",1,0,'L');

$pdf->SetFont('Angsana New','',12);
$pdf->SetXY($x+$setX_call_person,$y);
$pdf->Cell(100,6,$rsv['prename_en'].$rsv['name_en']."  ".$rsv['surname_en'],1,0,'L');

$y+=6;
$pdf->SetFont('Angsana New','B',12);
$pdf->SetXY($x,$y);
$pdf->Cell(180-$setX_call_person,6,"�ѹ-��͹-�� �Դ",1,0,'L');

$pdf->SetFont('Angsana New','',12);
$pdf->SetXY($x+$setX_call_person,$y);
$pdf->Cell(100,6, MakeDate($rsv['birthday']),1,0,'L');

$y+=6;
$pdf->SetFont('Angsana New','B',12);
$pdf->SetXY($x,$y);
$pdf->Cell(180-$setX_call_person,12,"",1,0,'L');
$pdf->SetXY($x,$y);
$pdf->Cell(180-$setX_call_person,6,"�������Ѩ�غѹ",0,0,'L');

$pdf->SetFont('Angsana New','',12);
$arr_str_contact_add = $pdf->alignstr($rsv['contact_add'],75);
$Int_addr = 0;
$pdf->SetXY($x+$setX_call_person,$y);
$pdf->Cell(100,12, "",1,0,'L');
foreach($arr_str_contact_add as $contact_add_var){
	$Int_addr++;
	if($Int_addr==1){
		$pdf->SetXY($x+$setX_call_person,$y);
		$pdf->Cell(100,6, $contact_add_var,0,0,'L');
	}else{
		$pdf->SetXY($x+$setX_call_person,$y+6);
		$pdf->Cell(100,6, $contact_add_var,0,0,'L');
	}
}

$y+=12;
$pdf->SetFont('Angsana New','B',12);
$pdf->SetXY($x,$y);
$pdf->Cell(180-$setX_call_person,6,"���˹�",1,0,'L');

$pdf->SetFont('Angsana New','',12);
$pdf->SetXY($x+$setX_call_person,$y);
$pdf->Cell(60,6,$rsv_salary['position'],1,0,'L');

$pdf->SetFont('Angsana New','B',12);
$pdf->SetXY($x+60+$setX_call_person,$y);
$pdf->Cell(40,6,"�Ţ�����˹�",1,0,'L');

$pdf->SetFont('Angsana New','',12);
$pdf->SetXY($x+100+$setX_call_person,$y);
$pdf->Cell(40,6,$rsv_salary['noposition'],1,0,'L');

$y+=6;
$pdf->SetFont('Angsana New','B',12);
$pdf->SetXY($x,$y);
$pdf->Cell(180-$setX_call_person,6,"�дѺ",1,0,'L');

$pdf->SetFont('Angsana New','',12);
$pdf->SetXY($x+$setX_call_person,$y);
$pdf->Cell(60,6,(($rsv['level_id'] != "")?ShowRadub($rsv['level_id']):$rsv['radub']),1,0,'L');

$pdf->SetFont('Angsana New','B',12);
$pdf->SetXY($x+60+$setX_call_person,$y);
$pdf->Cell(40,6,"����֡���٧�ش",1,0,'L');

$sql_graduate = "SELECT 
$dbname.graduate.place,
$dbname.graduate.grade,
$dbnamemaster.hr_addhighgrade.highgrade,
$dbname.graduate.degree_level,
$dbname.graduate.university_level,
$dbname.graduate.major_level 
FROM $dbname.graduate inner join $dbnamemaster.hr_addhighgrade on $dbname.graduate.graduate_level=$dbnamemaster.hr_addhighgrade.runid 
WHERE $dbname.graduate.id='".$rsv['id']."' and kp7_active='1' ORDER BY  $dbname.graduate.graduate_level DESC,$dbname.graduate.finishyear DESC  LIMIT 1";
$result_graduate = mysql_db_query($dbname,$sql_graduate);
$rs_gradate = mysql_fetch_assoc($result_graduate);
$pdf->SetFont('Angsana New','',12);
$pdf->SetXY($x+100+$setX_call_person,$y);
$pdf->Cell(40,6,$rs_gradate['highgrade'],1,0,'L');

$y+=6;
$pdf->SetFont('Angsana New','B',12);
$pdf->SetXY($x,$y);
$pdf->Cell(180-$setX_call_person,6,"�����Ҫ��� � �Ѩ�غѹ",1,0,'L');

$diff  = dateLength($rsv[begindate]);
$pdf->SetFont('Angsana New','',12);
$pdf->SetXY($x+$setX_call_person,$y);
$pdf->Cell(60,6,(($rsv['begindate'] != "")?$diff['year']." ��  ".$diff['month']." ��͹  ".$diff['day']." �ѹ":"-"),1,0,'L');

$pdf->SetFont('Angsana New','B',12);
$pdf->SetXY($x+60+$setX_call_person,$y);
$pdf->Cell(40,6,"�ѹ�ú���³����",1,0,'L');

$pdf->SetFont('Angsana New','',12);
$pdf->SetXY($x+100+$setX_call_person,$y);
$pdf->Cell(40,6,retireDate($rsv['birthday']),1,0,'L');

$y+=6;
$pdf->SetFont('Angsana New','B',12);
$pdf->SetXY($x,$y);
$pdf->Cell(180,6,"˹��§ҹ",1,0,'L');

$pdf->SetFont('Angsana New','',12);
$pdf->SetXY($x+$setX_call_person,$y);
$prearea = ($rsv[schoolid] != $rsv[siteid])?"�ç���¹":"";
$school = $prearea."".ShowSchool($rsv[schoolid])." / ".ShowArea($rsv[siteid]);
$pdf->Cell(180-$setX_call_person,6,$school,1,0,'L');

## End  ����ѵ���ǹ�ؤ��

## Begin  ����ѵԡ���֡��
$y+=10;
$pdf->SetFont('Angsana New','B',12);
$pdf->SetXY($x,$y);
$pdf->Cell(180,7,"����ѵԡ���֡��",1,0,'L');

$y+=7;
$size_cellEdu1=45;
$pdf->SetXY($x,$y);
$pdf->Cell($size_cellEdu1,12,"�дѺ����֡��",1,0,'C');

$x = $x+$size_cellEdu1;
$pdf->SetXY($x,$y);
$size_cellEdu2 = 15;
$pdf->Cell($size_cellEdu2,12,"",1,0,'C');
$pdf->SetXY($x,$y);
$pdf->Cell($size_cellEdu2,7,"�շ�������",0,0,'C');
$pdf->SetXY($x,$y+5);
$pdf->Cell($size_cellEdu2,7,"����֡��",0,0,'C');

$x = $x+$size_cellEdu2;
$pdf->SetXY($x,$y);
$size_cellEdu3 = 45;
$pdf->Cell($size_cellEdu3,12,"�زԡ���֡��",1,0,'C');

$x = $x+$size_cellEdu3;
$pdf->SetXY($x,$y);
$size_cellEdu4 = 30; 
$pdf->Cell($size_cellEdu4,12,"�Ң��Ԫ�",1,0,'C');

$x = $x+$size_cellEdu4;
$pdf->SetXY($x,$y);
$size_cellEdu5 = 45; 
$pdf->Cell($size_cellEdu5,12,"ʶҺѹ����֡��",1,0,'C');

$pdf->SetFont('Angsana New','',12);
$sql_edu = "SELECT * FROM graduate WHERE id='$id' AND kp7_active='1' ORDER BY graduate_level ASC";
$result_edu = mysql_db_query($db_name,$sql_edu);
$i=0;
$y+=6;
$y_start = $y;
while($rs_edu = mysql_fetch_assoc($result_edu)){
	## �ز����֡��
		if($rs_edu['degree_level'] != ""){
				$DegreeLevel = ShowGraduateLevel($rs_edu['degree_level']);
		}else{
				$DegreeLevel = $rs_edu['grade'];
		}
	## �Ң��Ԫ��͡
		if($rs_edu['major_level'] != ""){
				$MajorLevel = ShowMajor($rs_edu['major_level']);
		}else{
				$MajorLevel = "����к�";	
		}
	## ʶҹ�֡��
		if($rs_edu['university_level'] != ""){
				$GraduatePlace = ShowGraduatePlace($rs_edu['university_level']);
				
		}else{
				$GraduatePlace = $rs_edu['place'];	
		}
		
		$arr_str_edu_leve = array(); 
		$arr_str_edu_leve = $pdf->alignstr(ShowGraduate($rs_edu['graduate_level']),35);
		$num_arr_edu_leve = count($arr_str_edu_leve); // check �ӹǹ��÷Ѵ column 1 �дѺ����֡��
		
		$arr_str_edu_DegreeLevel = array(); 
		$arr_str_edu_DegreeLevel = $pdf->alignstr($DegreeLevel,35);
		$num_arr_edu_DegreeLevel = count($arr_str_edu_DegreeLevel); // check �ӹǹ��÷Ѵ column 1 �زԡ���֡��
		
		$arr_str_edu_GraduatePlace = array(); 
		$arr_str_edu_GraduatePlace = $pdf->alignstr($GraduatePlace,28);
		$num_arr_edu_GraduatePlace = count($arr_str_edu_GraduatePlace); // check �ӹǹ��÷Ѵ column 1 ʶҺѹ����֡��
		$maxNum_edu = max($num_arr_edu_leve, $num_arr_edu_DegreeLevel, $num_arr_edu_GraduatePlace);

		#Begin �дѺ����֡��
		$y=$y_start;
		$x = 20;
		$size_cellEdu1=45;
		$pdf->SetXY($x,$y+6);
		$pdf->Cell($size_cellEdu1,6*$maxNum_edu," ",1,0,'L');	
		if($rs_edu['graduate_level'] != $xgraduate_level){
			$I = 0;
			foreach($arr_str_edu_leve as $str_edu_var){
				$y+=6;
				if($I==0 ){
					$pdf->SetXY($x,$y);
					$pdf->Cell($size_cellEdu1,6," - ".$str_edu_var,0,0,'L');	
				}else{
					$pdf->SetXY($x,$y);
					$pdf->Cell($size_cellEdu1,6," ".$str_edu_var,0,0,'L');	
				}
				$I++;
			}
		}else{
			$y+=6;
			$pdf->SetXY($x,$y);
			$pdf->Cell($size_cellEdu1,6," ",1,0,'L');
		}
		
		#End �дѺ����֡��

		#Begin �շ������稡���֡��
		$y=$y_start;
		$size_cellEdu2 = 15;
		$x = $x+$size_cellEdu1;
		$y+=6;
		$pdf->SetXY($x,$y);
		$pdf->Cell($size_cellEdu2,6*$maxNum_edu," ",1,0,'C');
		$pdf->SetXY($x,$y);
		$pdf->Cell($size_cellEdu2,6,$rs_edu['finishyear'],0,0,'C');
		#End �շ������稡���֡��
		
		#Begin �زԡ���֡��
		$y=$y_start;
		$x = $x+$size_cellEdu2;
		$size_cellEdu3 = 45;
		$pdf->SetXY($x,$y+6);
		$pdf->Cell($size_cellEdu3,6*$maxNum_edu," ",1,0,'L');	
		$I = 0;
		foreach($arr_str_edu_DegreeLevel as $key=>$str_edu_DegreeLevel_var){
			$y+=6;
			if($I==0){
				$pdf->SetXY($x,$y);
				$pdf->Cell($size_cellEdu3,6,$str_edu_DegreeLevel_var,0,0,'L');	
			}else{
				$pdf->SetXY($x,$y);
				$pdf->Cell($size_cellEdu3,6," ".$str_edu_DegreeLevel_var,0,0,'L');	
			}
			$I++;
		}
		#End �زԡ���֡��
		
		#Begin �Ң��Ԫ�
		$y=$y_start;
		$size_cellEdu4 = 30; 
		$x = $x+$size_cellEdu3;
		$y+=6;
		$pdf->SetXY($x,$y);
		$pdf->Cell($size_cellEdu4,6*$maxNum_edu," ",1,0,'C');
		$pdf->SetXY($x,$y);
		$pdf->Cell($size_cellEdu4,6,$MajorLevel,0,0,'L');
		#End �Ң��Ԫ�
		
		#Begin ʶҺѹ����֡��
		$y=$y_start;
		$x = $x+$size_cellEdu4;
		$size_cellEdu5 = 45; 
		$pdf->SetXY($x,$y+6);
		$pdf->Cell($size_cellEdu5,6*$maxNum_edu," ",1,0,'L');	
		$I = 0;
		foreach($arr_str_edu_GraduatePlace as $str_edu_GraduatePlace_var){
			$y+=6;
			if($I==0){
				$pdf->SetXY($x,$y);
				$pdf->Cell($size_cellEdu5,6,$str_edu_GraduatePlace_var,0,0,'L');	
			}else{
				$pdf->SetXY($x,$y);
				$pdf->Cell($size_cellEdu5,6,"  ".$str_edu_GraduatePlace_var,0,0,'L');	
			}
			$I++;
		}
		#End ʶҺѹ����֡��
		/**/
		$y_start+=(6*$maxNum_edu);
}//while

## End  ����ѵԡ���֡��

## Begin  ����ѵԡ���Ѻ�Ҫ���
//function add_page_history(){
//	global $y ,$x ,$db_name ,$id ,$y_start ;
	$pdf->AddPage();
	$pdf->SetFont('Angsana New','B',16);
	$y = 18;		
	$x = 20;
	
	$y+=10;
	$x = 20;
	$pdf->SetFont('Angsana New','B',12);
	$pdf->SetXY($x,$y);
	$pdf->Cell(180,7,"����ѵԡ���Ѻ�Ҫ���",1,0,'L');
	
	$y+=7;
	$size_cellEdu1=25;
	$pdf->SetXY($x,$y);
	$pdf->Cell($size_cellEdu1,12,"�ѹ / ��͹ / ��",1,0,'C');
	
	$x = $x+$size_cellEdu1;
	$pdf->SetXY($x,$y);
	$size_cellEdu2 = 30;
	$pdf->Cell($size_cellEdu2,12,"���˹�",1,0,'C');
	
	$x = $x+$size_cellEdu2;
	$pdf->SetXY($x,$y);
	$size_cellEdu3 = 15;
	$pdf->Cell($size_cellEdu3,12,"",1,0,'C');
	$pdf->SetXY($x,$y);
	$pdf->Cell($size_cellEdu3,7,"�Ţ���",0,0,'C');
	$pdf->SetXY($x,$y+5);
	$pdf->Cell($size_cellEdu3,7,"���˹�",0,0,'C');
	
	$x = $x+$size_cellEdu3;
	$pdf->SetXY($x,$y);
	$size_cellEdu4 = 10; 
	$pdf->Cell($size_cellEdu4,12,"�дѺ",1,0,'C');
	
	$x = $x+$size_cellEdu4;
	$pdf->SetXY($x,$y);
	$size_cellEdu5 = 50; 
	$pdf->Cell($size_cellEdu5,12,"�͡�����ҧ�ԧ",1,0,'C');
	
	$x = $x+$size_cellEdu5;
	$pdf->SetXY($x,$y);
	$size_cellEdu6 = 50; 
	$pdf->Cell($size_cellEdu6,12,"˹��§ҹ",1,0,'C');

	$pdf->SetFont('Angsana New','',12);
	$sql_salary = "SELECT * FROM $db_name.salary WHERE id='$id' ORDER BY runno ASC";
	$result_salary = mysql_db_query($db_name,$sql_salary);
	$int_t=0;
	//$y+=60;//TEST MAX
	$y+=6;
	$y_start = $y;
//}
//add_page_history();
while($rs = mysql_fetch_assoc($result_salary)){
	if(($rs[position_id] != $xposition_id) or ($rs[level_id] != $xlevel_id) or ($rs[order_type] != $xorder_type)){
		$int_t++;
		if(CheckOrderType($rs[order_type]) > 0 ){
			##########  label �Ţ�����˹�
			if($rs['label_noposition'] != "" && $rs['label_noposition'] != NULL){
					$show_noposition = $rs['label_noposition'];
			}else{
					$show_noposition = $rs['noposition'];
			}
			##########  �дѺ
			$show_radub = ($rs['level_id'] != "" and $rs['level_id'] > 0)?ShowRadub($rs['level_id']):$rs['radub'];
			
			if($rs[noorder]=="#"){
					$noo="";
			}else{	
					$noo=$rs[noorder];
			}
			
			##########  �͡�����ҧ�ԧ
			if($rs[label_dateorder] !=""){
					$dateorder=$rs[label_dateorder];
			}else{
					$dateorderX=MakeDate2($rs[dateorder]);
					$DO=explode(" ",$dateorderX);
			if($DO[0]==0){$dot="";}else{$dot=$DO[0];}
					$dateorder=$dot.$DO[1].$DO[2];
			}
			if($rs[instruct]=="#"){
					$rinstruct="";
			}else	{
					$rinstruct=$rs[instruct];
			}
			##########  ˹��§ҹ
			$xpos1 = strpos($rs[pls],"�.�");
			$xpos2 = strpos($rs[pls],"�.�.");
			$xpos3 = strpos($rs[pls],"�ç���¹");
			$xpos_temp = strpos($rs[pls],"�ѡ�ҡ��");
			$xpos4 = strpos($rs[pls],"��.");
			$xpos5 = strpos($rs[pls],"��");
						
			if(($xpos_temp === false)){
				if(!($xpos2 === false)){
						$school_subject =  "�ç���¹".CutWord($rs[pls],"�.�.");
				}else if(!($xpos1 === false)){
						$school_subject = "�ç���¹".CutWord($rs[pls],"�.�");
				}else if(!($xpos3 === false)){
						$school_subject =  "�ç���¹".CutWord($rs[pls],"�ç���¹");
				}else if(!($xpos4 === false)){
						$school_subject = "�ç���¹".CutWord($rs[pls],"��.");
				}else if(!($xpos5 === false)){
						$school_subject = "�ç���¹".CutWord($rs[pls],"��");
				}else{
						$part = $rs['pls'];	
				}
			}else{
				$part = $rs['pls'];	
			}
			
			$arr_str_rinstruct = array(); 
			$arr_str_rinstruct = $pdf->alignstr($noo." ".$rinstruct." ".$dateorder,38);
			$num_arr_str_rinstruct = count($arr_str_rinstruct); // check �ӹǹ��÷Ѵ column 1 �͡�����ҧ�ԧ
			
			$arr_str_school_subject = array(); 
			$arr_str_school_subject = $pdf->alignstr($school_subject,35);
			$num_arr_str_school_subject = count($arr_str_school_subject); // check �ӹǹ��÷Ѵ column 1 ˹��§ҹ
			$maxNum_sub = max($num_arr_str_rinstruct, $num_arr_str_school_subject);
			$x = 20;
			
			#Begin �ѹ / ��͹ / ��
			$y=$y_start;
			$size_cellEdu1 = 25; 
			$y+=6;
			$pdf->SetXY($x,$y);
			$pdf->Cell($size_cellEdu1,6*$maxNum_sub," ",1,0,'C');
			$pdf->SetXY($x,$y);
			$pdf->Cell($size_cellEdu1,6,MakeDate($rs['date']),0,0,'C');
			#End �ѹ / ��͹ / ��
			
			#Begin ���˹�
			$y=$y_start;
			$size_cellEdu2 = 30; 
			$x = $x+$size_cellEdu1;
			$y+=6;
			$pdf->SetXY($x,$y);
			$pdf->Cell($size_cellEdu2,6*$maxNum_sub," ",1,0,'C');
			$pdf->SetXY($x,$y);
			$position = ($rs['position_id'] != "" && $rs['position_id'] > 0)?ShowPosition($rs['position_id']):$rs['position']; 
			$pdf->Cell($size_cellEdu2,6,$position,0,0,'L');
			#End ���˹�

			#Begin �Ţ��� ���˹�
			$y=$y_start;
			$size_cellEdu3 = 15;
			$x = $x+$size_cellEdu2;
			$y+=6;
			$pdf->SetXY($x,$y);
			$pdf->Cell($size_cellEdu3,6*$maxNum_sub," ",1,0,'C');
			$pdf->SetXY($x,$y);
			$pdf->Cell($size_cellEdu3,6,$show_noposition,0,0,'C');
			#End �Ţ��� ���˹�

			#Begin �дѺ
			$y=$y_start;
			$size_cellEdu4 = 10;
			$x = $x+$size_cellEdu3;
			$y+=6;
			$pdf->SetXY($x,$y);
			$pdf->Cell($size_cellEdu4,6*$maxNum_sub," ",1,0,'C');
			$pdf->SetXY($x,$y);
			$pdf->Cell($size_cellEdu4,6,$show_radub,0,0,'C');
			#End �дѺ

			#Begin �͡�����ҧ�ԧ
			$y=$y_start;
			$x = $x+$size_cellEdu4;
			$size_cellEdu5 = 50; 
			$pdf->SetXY($x,$y+6);
			$pdf->Cell($size_cellEdu5,6*$maxNum_sub," ",1,0,'L');	
			$I = 0;
			foreach($arr_str_rinstruct as $str_rinstruct_var){
				$y+=6;
				if($I==0){
					$pdf->SetXY($x,$y);
					$pdf->Cell($size_cellEdu5,6,$str_rinstruct_var,0,0,'L');	
				}else{
					$pdf->SetXY($x,$y);
					$pdf->Cell($size_cellEdu5,6,"  ".$str_rinstruct_var,0,0,'L');	
				}
				$I++;
			}
			#End �͡�����ҧ�ԧ

			#Begin �͡�����ҧ�ԧ
			$y=$y_start;
			$x = $x+$size_cellEdu5;
			$size_cellEdu6 = 50; 
			$pdf->SetXY($x,$y+6);
			$pdf->Cell($size_cellEdu6,6*$maxNum_sub," ",1,0,'L');	
			$I = 0;
			foreach($arr_str_school_subject as $str_school_subject_var){
				$y+=6;
				if($I==0){
					$pdf->SetXY($x,$y);
					$pdf->Cell($size_cellEdu6,6,$str_school_subject_var,0,0,'L');	
				}else{
					$pdf->SetXY($x,$y);
					$pdf->Cell($size_cellEdu6,6,"  ".$str_school_subject_var,0,0,'L');	
				}
				$I++;
			}
			#End �͡�����ҧ�ԧ
			$y_start+=(6*$maxNum_sub);
			
			#ŧ˹������
			if($y_start >= 269){ 	
					$pdf->AddPage();
					$pdf->SetFont('Angsana New','B',16);
					$y = 18;		
					$x = 20;					
					$y+=10;
					$x = 20;
					$pdf->SetFont('Angsana New','B',12);
					$pdf->SetXY($x,$y);
					$pdf->Cell(180,7,"����ѵԡ���Ѻ�Ҫ���",1,0,'L');					
					$y+=7;
					$size_cellEdu1=25;
					$pdf->SetXY($x,$y);
					$pdf->Cell($size_cellEdu1,12,"�ѹ / ��͹ / ��",1,0,'C');					
					$x = $x+$size_cellEdu1;
					$pdf->SetXY($x,$y);
					$size_cellEdu2 = 30;
					$pdf->Cell($size_cellEdu2,12,"���˹�",1,0,'C');					
					$x = $x+$size_cellEdu2;
					$pdf->SetXY($x,$y);
					$size_cellEdu3 = 15;
					$pdf->Cell($size_cellEdu3,12,"",1,0,'C');
					$pdf->SetXY($x,$y);
					$pdf->Cell($size_cellEdu3,7,"�Ţ���",0,0,'C');
					$pdf->SetXY($x,$y+5);
					$pdf->Cell($size_cellEdu3,7,"���˹�",0,0,'C');					
					$x = $x+$size_cellEdu3;
					$pdf->SetXY($x,$y);
					$size_cellEdu4 = 10; 
					$pdf->Cell($size_cellEdu4,12,"�дѺ",1,0,'C');					
					$x = $x+$size_cellEdu4;
					$pdf->SetXY($x,$y);
					$size_cellEdu5 = 50; 
					$pdf->Cell($size_cellEdu5,12,"�͡�����ҧ�ԧ",1,0,'C');					
					$x = $x+$size_cellEdu5;
					$pdf->SetXY($x,$y);
					$size_cellEdu6 = 50; 
					$pdf->Cell($size_cellEdu6,12,"˹��§ҹ",1,0,'C');				
					$pdf->SetFont('Angsana New','',12);
					$y_start=$y+6;
			}			
		} 
	}
}

## End  ����ѵԡ���Ѻ�Ҫ���
## Begin  ����ѵԡ�����Ѻ�Է°ҹ�
$pdf->AddPage();
$pdf->SetFont('Angsana New','B',16);
$y = 18;		

$y+=10;
$x = 20;
$pdf->SetFont('Angsana New','B',12);
$pdf->SetXY($x,$y);
$pdf->Cell(180,7,"����ѵԡ�����Ѻ�Է°ҹ�",1,0,'L');

$y+=7;
$size_cellEdu1=25;
$pdf->SetXY($x,$y);
$pdf->Cell($size_cellEdu1,12,"�ѹ / ��͹ / ��",1,0,'C');

$x = $x+$size_cellEdu1;
$pdf->SetXY($x,$y);
$size_cellEdu2 = 30;
$pdf->Cell($size_cellEdu2,12,"���˹�",1,0,'C');

$x = $x+$size_cellEdu2;
$pdf->SetXY($x,$y);
$size_cellEdu3 = 15;
$pdf->Cell($size_cellEdu3,12,"",1,0,'C');
$pdf->SetXY($x,$y);
$pdf->Cell($size_cellEdu3,7,"�Ţ���",0,0,'C');
$pdf->SetXY($x,$y+5);
$pdf->Cell($size_cellEdu3,7,"���˹�",0,0,'C');

$x = $x+$size_cellEdu3;
$pdf->SetXY($x,$y);
$size_cellEdu4 = 10; 
$pdf->Cell($size_cellEdu4,12,"�дѺ",1,0,'C');

$x = $x+$size_cellEdu4;
$pdf->SetXY($x,$y);
$size_cellEdu5 = 50; 
$pdf->Cell($size_cellEdu5,12,"�͡�����ҧ�ԧ",1,0,'C');

$x = $x+$size_cellEdu5;
$pdf->SetXY($x,$y);
$size_cellEdu6 = 50; 
$pdf->Cell($size_cellEdu6,12,"���Ѻ�Է°ҹ�",1,0,'C');

$y+=6;
$pdf->SetFont('Angsana New','',12);
$sqlSV = "SELECT * FROM salary WHERE id='$id' AND order_type='3' order by runno ASC";
$resultSV = mysql_db_query($db_name,$sqlSV);
while($rs = mysql_fetch_assoc($resultSV)){
	 ##########  label �Ţ�����˹�
	if($rs[label_noposition] != "" and $rs[label_noposition] != NULL){
			$show_noposition = $rs[label_noposition];
	}else{
			$show_noposition = $rs[noposition];
	}
					
	if($rs[noorder]=="#"){
			$noo="";
	}else{	
			$noo=$rs[noorder];
	}
							
	if($rs[label_dateorder] !=""){
			$dateorder=$rs[label_dateorder];
	}else{
			$dateorderX=MakeDate2($rs[dateorder]);
		   	$DO=explode(" ",$dateorderX);
			if($DO[0]==0){$dot="";}else{$dot=$DO[0];}
			$dateorder=$dot.$DO[1].$DO[2];
	}
	if($rs[instruct]=="#"){
			$rinstruct="";
	}else	{
			$rinstruct=$rs[instruct];
	}
	
	$sql_vitaya = "SELECT * FROM vitaya_stat WHERE id='$rs[id]' AND salary_id='$rs[runid]'";
	$result_vitaya = mysql_db_query($db_name,$sql_vitaya);
	$rs_v = mysql_fetch_assoc($result_vitaya);
	
		$y+=6;
		$x = 20;
		$size_cellEdu1=25;
		$pdf->SetXY($x,$y);
		$pdf->Cell($size_cellEdu1,6,MakeDate($rs['date']),1,0,'L');
		
		$x = $x+$size_cellEdu1;
		$pdf->SetXY($x,$y);
		$size_cellEdu2 = 30;
		$position = ($rs['position_id'] != "" && $rs['position_id'] > 0)?ShowPosition($rs['position_id']):$rs['position']; 
		$pdf->Cell($size_cellEdu2,6,$position,1,0,'L');
		
		$x = $x+$size_cellEdu2;
		$pdf->SetXY($x,$y);
		$size_cellEdu3 = 15;
		$pdf->Cell($size_cellEdu3,6,$show_noposition,1,0,'C');
		
		$x = $x+$size_cellEdu3;
		$pdf->SetXY($x,$y);
		$size_cellEdu4 = 10; 
		$pdf->Cell($size_cellEdu4,6,$show_radub,1,0,'C');
		
		$x = $x+$size_cellEdu4;
		$pdf->SetXY($x,$y);
		$size_cellEdu5 = 50; 
		$pdf->Cell($size_cellEdu5,6,$noo." ".$rinstruct." ".$dateorder,1,0,'L');
		
		$x = $x+$size_cellEdu5;
		$pdf->SetXY($x,$y);
		$size_cellEdu6 = 50; 
		$pdf->Cell($size_cellEdu6,6,$position.$rs_v['name'],1,0,'L');
	
}

## End  ����ѵԡ�����Ѻ�Է°ҹ�
## Begin  ����ѵԡ�ý֡ͺ�� / �֡�Ҵ٧ҹ
$y+=10;
$x = 20;
$pdf->SetFont('Angsana New','B',12);
$pdf->SetXY($x,$y);
$pdf->Cell(180,7,"����ѵԡ�ý֡ͺ�� / �֡�Ҵ٧ҹ",1,0,'L');

$y+=7;
$size_cellEdu1=40;
$pdf->SetXY($x,$y);
$pdf->Cell($size_cellEdu1,7,"�ѹ / ��͹ / ��  (�ҡ-�֧)",1,0,'C');

$x = $x+$size_cellEdu1;
$pdf->SetXY($x,$y);
$size_cellEdu2 = 140;
$pdf->Cell($size_cellEdu2,7,"������ѡ�ٵ�",1,0,'C');

$y+=7;
$x = 20;
$pdf->SetFont('Angsana New','',12);
$sql_seminar = "SELECT * FROM seminar WHERE id='$id' and kp7_active='1' order by runno ASC";
$result_seminar = mysql_db_query($db_name,$sql_seminar);
$num_seminar = @mysql_num_rows($result_seminar);
	if($num_seminar < 1){
		$pdf->SetXY($x,$y);
		$pdf->Cell(180,6,"- ����ջ���ѵԡ�ý֡ͺ�� - ",1,0,'C');
	}else{
		$i=0;
		while($rs_sem = mysql_fetch_assoc($result_seminar)){
			$x = 20;
			$size_cellEdu1=40;
			$pdf->SetXY($x,$y);
			$pdf->Cell($size_cellEdu1,7,ShowDateThai($rs_sem['startdate'], $rs_sem['enddate']),1,0,'C');

			$x = $x +$size_cellEdu1;
			$pdf->SetXY($x,$y);
			$size_cellEdu2 = 140;
			$pdf->Cell($size_cellEdu2,7,$rs_sem['subject'],1,0,'L');
			$y+=7;
		}
	}
## End  ����ѵԡ�ý֡ͺ�� / �֡�Ҵ٧ҹ
$y = 270;
$pdf->c2footer();
$pdf->Output($id.".pdf",'D');
?>