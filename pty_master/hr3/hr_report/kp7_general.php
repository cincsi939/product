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
include("function_showdate_label.php");
$preview_status=1;
$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");

$activity_id = "A0001"; // ���� log ����� PDF
$server_id = "S0001"; // ���� server
$kp7="1"; // ���� �Դ����ʴ��Ţ����� �� 7

if($dbname != "edubkk_master"){
		$xsiteid = substr($dbname,-4);
}


$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$monthsname = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");
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
	$set_wk =1 ;$word_wk="����";
	$genbarcode = true;
}else{
	$set_wk =1 ;$word_wk="���������ҧ��Ǩ�ͺ";
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
	$imgpath = "../../../../".PATH_IMAGES."/$xsiteid/";
	$ext_array = array("jpg","jpeg","png","gif");
	if ($id <= "") return "";

	for ($i=0;$i<count($ext_array);$i++){
		$img_file = $imgpath . $id . "." . $ext_array[$i];
		if (file_exists($img_file)) return $img_file;
	}

	return "";
}

// �ѧ��蹡� �ʴ��� �ѹ ��͹ �� ��
function  showthaidate($number){

$digit=array('�ٹ��','˹��','�ͧ','���','���','���','ˡ','��','Ỵ','���','�Ժ');
$num=array('','�Ժ','����','�ѹ','����','�ʹ','��ҹ');
$number = explode(".",$number);
$c_num[0]=$len=strlen($number[0]);
$c_num[1]=$len2=strlen($number[1]);
$convert='';
if($len > 2){
	$a1 = $len - 1 ;
	$f_digit = substr($number[0],$a1,1);
}
//�Դ�ӹǹ���
for($n=0;$n< $len;$n++){
	$c_num[0]--;
	$c_digit=substr($number[0],$n,1);
	if($c_num[0]==0&& $c_digit==0)$digit[$c_digit]='';

	if($len>1 && $len <= 2){
		if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='���';
	}else if ($len>3){
		if($f_digit == 0){
			if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='˹��';
		}else{
			if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='���';
		}
	}else{
		if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='˹��';
	}

	if($c_num[0]==0&& $c_digit==2)$digit[$c_digit]='�ͧ';
	if($c_num[0]==1&& $c_digit==0)$digit[$c_digit]='';
	if($c_num[0]==1&& $c_digit==1)$digit[$c_digit]='';
	if($c_num[0]==1&& $c_digit==2)$digit[$c_digit]='���'; 

	$convert.=$digit[$c_digit];
		if($c_num[0] > 0 && $c_digit != 0 && $c_digit != ""){
			$convert.=$num[$c_num[0]]; 
		}
}
$convert .= "";
if($number[1]==''){$convert .= "";}

//�Դ�ش�ȹ���
for($n=0;$n< $len2;$n++){ 
$c_num[1]--;
$c_digit=substr($number[1],$n,1);
if($c_num[1]==0&& $c_digit==1)$digit[$c_digit]='˹��';
if($c_num[1]==0&& $c_digit==2)$digit[$c_digit]='�ͧ';
if($c_num[1]==1&& $c_digit==2)$digit[$c_digit]='�ͧ'; 
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
		$date_bd = explode("-",$rs[birthday]); // �ѹ�Դ
		$getidcard = 	$rs[idcard] ;
			if ($rs[contact_tel] == ""){
				$xcontact_tel = " - ";
			}else{
				$xcontact_tel = $rs[contact_tel];
			}
		$rs[contact_add] = str_replace("�.","�Ӻ�",$rs[contact_add]);
		$rs[contact_add] = str_replace("�.","�����",$rs[contact_add]);
		$rs[contact_add] = str_replace("�.","�ѧ��Ѵ",$rs[contact_add]);

		$hrpicture = array();
		$np = 0;
		$xresult = mysql_query("select * from general_pic where id='$id' and kp7_active='$kp7' order by no asc");
		while ($xrs = mysql_fetch_assoc($xresult)){
			//$img_file = "images/personal/$xrs[imgname]";
			$img_file = "../../../../".PATH_IMAGES."/$rs[siteid]/$xrs[imgname]";
			$hrpicture[$np] = $img_file;
			
			if($xrs[label_yy] != ""){
				$xyy = str_replace("�.�.","",$xrs[label_yy]);
			}else if($xrs[yy] > 0){
				$xyy = $xrs[yy];
			}else{
				$xyy = "";	
			}//end if($xrs[label_yy] != ""){
				
			$hrpicture_yy[$np] = $xyy;
			
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
$pdf->SetFont($font_format,'',14);
$pdf->SetXY(71,10);
$pdf->Cell(71,30,'�������Ӥѭ�����',0,0,'C');
			
$pdf->SetXY(10,30); // ��ǹ�ʴ���ͺ�ٻ

			$col_width = array(27,27,27,27,27,27,27); // ��˹��������ҧ column
			$col_height = 31;

			$pdf->SetFont($font_format,'',10);
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

$pdf->SetXY(8,30); // ��ǹ�ʴ��ٻ

			$col_width = array(27,27,27,27,27,27,27); // ��˹��������ҧ column
			$col_height = 24;

			$pdf->SetFont($font_format,'',10);
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

$pdf->SetXY(10,61); // ��ǹ�ʴ���ͧ �� �.�.
			
			$col_width = array(27,27,27,27,27,27,27); // ��˹��������ҧ column
			$col_height = 10;

			$pdf->SetFont($font_format,'',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height/2),"�ٻ��� �",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
			//�ó�����к� �.�. �ٻ��� 1
			if($hrpicture_yy[0]  != ""){
			$pdf->Cell($col_width[0],($col_height/2),"�.�. $hrpicture_yy[0]",0,0,'C');
			}else if($hrpicture[0] !=""){
			$pdf->Cell($col_width[0],($col_height/2),"�.�. ����к�",0,0,'C');
			}else{
			$pdf->Cell($col_width[0],($col_height/2),"�.�.",0,0,'C');
			}
			// �� if 1
			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height/2),"�ٻ��� �",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
			// �ó�����к� �.�. �ٻ��� 2
			if($hrpicture_yy[1] != ""){
			$pdf->Cell($col_width[1],($col_height/2),"�.�. $hrpicture_yy[1]",0,0,'C');
			}else if($hrpicture[1] !=""){
			$pdf->Cell($col_width[1],($col_height/2),"�.�. ����к�",0,0,'C');
			}else{
			$pdf->Cell($col_width[1],($col_height/2),"�.�.",0,0,'C');
			}
			// �� if 2
			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height/2),"�ٻ��� �",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
			// �ó�����к� �.�. �ٻ��� 3
			if($hrpicture_yy[2] != ""){
			$pdf->Cell($col_width[2],($col_height/2),"�.�. $hrpicture_yy[2]",0,0,'C');
			}else if($hrpicture[2] !=""){
			$pdf->Cell($col_width[2],($col_height/2),"�.�. ����к�",0,0,'C');
			}else{
			$pdf->Cell($col_width[2],($col_height/2),"�.�.",0,0,'C');
			}
			// �� if 3
			$x += $col_width[2];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height/2),"�ٻ��� �",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
				// �ó�����к� �.�. �ٻ��� 4
				if($hrpicture_yy[3]  != ""){
				$pdf->Cell($col_width[3],($col_height/2),"�.�. $hrpicture_yy[3]",0,0,'C');
				}else if($hrpicture[3] !=""){
				$pdf->Cell($col_width[3],($col_height/2),"�.�. ����к�",0,0,'C');
				}else{
				$pdf->Cell($col_width[3],($col_height/2),"�.�.",0,0,'C');
				}
				// �� if 4
			$x += $col_width[3];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height/2),"�ٻ��� �",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
			// �ó�����кػվ.�.
			if($hrpicture_yy[4] != ""){
			$pdf->Cell($col_width[4],($col_height/2),"�.�. $hrpicture_yy[4]",0,0,'C');
			}else if($hrpicture[4] !=""){
			$pdf->Cell($col_width[4],($col_height/2),"�.�. ����к�",0,0,'C');
			}else{
			$pdf->Cell($col_width[4],($col_height/2),"�.�.",0,0,'C');
			}
			// ��
			
			$x += $col_width[4];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height/2),"�ٻ��� �",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);

			// �ó������ �.�.
			if($hrpicture_yy[5] != ""){
			$pdf->Cell($col_width[5],($col_height/2),"�.�. $hrpicture_yy[5]",0,0,'C');
			}else if($hrpicture[5] !=""){
			$pdf->Cell($col_width[5],($col_height/2),"�.�. ����к�",0,0,'C');
			}else{
			$pdf->Cell($col_width[5],($col_height/2),"�.�. ",0,0,'C');
			}
			
			//��
			
			$x += $col_width[5];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[6],($col_height/2),"�ٻ��� �",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[6],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
			// �ó�����кػվ.�.
			if($hrpicture_yy[6] != ""){
			$pdf->Cell($col_width[6],($col_height/2),"�.�. $hrpicture_yy[6]",0,0,'C');
			}else if($hrpicture[6] !=""){
			$pdf->Cell($col_width[6],($col_height/2),"�.�. ����к�",0,0,'C');
			}else{
			$pdf->Cell($col_width[6],($col_height/2),"�.�. ",0,0,'C');
			}
			
			//�� if
			$y=71;
			
			$pdf->SetXY(10,$y); // ��÷Ѵ ���� �ѹ ��͹ ���Դ

			$activitylog_name = "$rs[prename_th] $rs[name_th]";
			$activitylog_sername = "$rs[surname_th]";
			$activitylog_idcard = "$rs[idcard]";
			
			$col_width = array(189); // ��˹��������ҧ column
			$col_height = 8;

			$pdf->SetFont($font_format,'',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			

		$sql = "select t1.*,t2.religion as religionname,t3.blood as bloodgroup from  (general t1 left join $dbnamemaster.hr_religion t2 on t1.region=t2.id) left join $dbnamemaster.hr_blood t3 on t1.blood=t3.id where t1.id='$id'  ;";
		$result = mysql_query($sql);
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);

$date_d = explode("-",$rs[startdate]); // �ѹ��觺�è�
$date_bd = explode("-",$rs[birthday]); // �ѹ�Դ
		$sqld="select * from general where id='$id' ";
					$qd2=mysql_query($sqld);
					$rsd2=mysql_fetch_array($qd2);
					$adsd2=$rsd2[type_dateshow];
					$sqlshow="select type_date,type_nec from type_showdate where id_type='$adsd2' ";
					$qshow=mysql_query($sqlshow);
					$rsshow1=mysql_fetch_array($qshow);	
			if($rsshow1[type_nec]=="n" )
		 {
		 	$b_birth=$rsshow1[type_date];
		 }

		else
		 {		
		//if($adsd2 ==300 or $adsd2==299or $adsd2==293or $adsd2==292)
			//  if($adsd2 !=293 or $adsd2 !=299 or $adsd2 != 292 or $adsd2 !=300)
			 if($adsd2 ==341 or $adsd2==351or $adsd2==361 or $adsd2==371)
				 {
				$b_day1 = new date_format;
				$year_d=($date_bd[0]-543);
				$b_birth= $b_day1->show_date($rsshow1[type_date],$year_d."-".$date_bd[1]."-".$date_bd[2]);
			 	
				 }
			else
				{
				$b_birth=intval($date_bd[2])." ��͹ ".$monthname[intval($date_bd[1])]." �.�.".$date_bd[0];
				}
		}
		
		# check ��õ�Ǩ�ͺ label �ͧ�ѹ��͹���Դ
		$b_birth=showdate_label($rs[birthday],$b_birth,$rs['birthday_label'],"birthday","1");
			
			// ������� �Դ�Դ��ǹ����ʴ��Ū�����Ңͧ��7
			$strSQL=mysql_query("SELECT * FROM hr_addhistoryname WHERE gen_id='$id' AND kp7_active='$kp7' ORDER BY runno DESC");
			$num_row_name=mysql_num_rows($strSQL);
			###  ����ѵԡ������¹����
			$sql_history_name = "SELECT * FROM hr_addhistoryname WHERE gen_id='$id' AND kp7_active <> '$kp7' ORDER BY runno DESC";
			$result_h_name = mysql_query($sql_history_name);
			while($rsh1 = mysql_fetch_assoc($result_h_name)){
				$his_name .= " ($rsh1[prename_th]$rsh1[name_th]  $rsh1[surname_th]) ";
			}
			//echo $his_name;
			### edn ����ѵԡ������¹����
			if($num_row_name > 0){
				$strRs=mysql_fetch_assoc($strSQL);
				
				$txt_his_name = "�.  ����  $strRs[prename_th]$strRs[name_th]  $strRs[surname_th]".$his_name." �Դ�ѹ��� $b_birth";
				$arr_name1 = array(); 
				$arr_name1 = $pdf->alignstr($txt_his_name,160);
				$num_name1 = count($arr_name1); // check �ӹǹ��÷Ѵ column 1
				if($num_name1 == 1){
					$pdf->Cell($col_width[0],$col_height,"$txt_his_name ",1,0,'L');
					$y=$y+$col_height;
				}else{
					$pdf->Cell($col_width[0],($col_height*$num_name1)," ",1,'L');
					for($n=0;$n<$num_name1;$n++){
						//if(($num_name1-$n) == 1){ $border_line = 1;}else{ $border_line = 0;}
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],$col_height,"$arr_name1[$n]",0,0,'L');
						$y=$y+$col_height;
					}
				}//end 	if($num_name1 == 1){

				
					}else{
					
					
			$sql_history_name = "SELECT * FROM hr_addhistoryname WHERE gen_id='$id' AND kp7_active <> '$kp7' ORDER BY runno DESC";
			$result_h_name = @mysql_query($sql_history_name);
			$k=0;
			while($rsh1 = @mysql_fetch_assoc($result_h_name)){
			$k++;
				if($k > 1){ // �����Һ�÷Ѵ�á㹡ó�����ա�á�˹� ʶҹ������ʴ���� �.�.7
				$xhis_name .= " ($rsh1[prename_th]$rsh1[name_th]  $rsh1[surname_th]) ";
				}// end if($k > 1){
			}// end while($rsh1 = @mysql_fetch_assoc($result_h_name)){

					
					
				$sql_noAt = "SELECT * FROM hr_addhistoryname WHERE gen_id='$id' ORDER BY runno DESC LIMIT 0,1 ";
				$result_noAt = mysql_query($sql_noAt);
				$rs_noAt = mysql_fetch_assoc($result_noAt);
				
				$txt_his_name = "�. ���� $rs_noAt[prename_th]$rs_noAt[name_th]  $rs_noAt[surname_th]".$xhis_name." �Դ�ѹ��� $b_birth";
				$arr_name1 = array(); 
				$arr_name1 = $pdf->alignstr($txt_his_name,160);
				$num_name1 = count($arr_name1); // check �ӹǹ��÷Ѵ column 1
				if($num_name1 == 1){
					$pdf->Cell($col_width[0],$col_height,"$txt_his_name",1,0,'L');
					$y=$y+$col_height;
				}else{
					$pdf->Cell($col_width[0],($col_height*$num_name1)," ",1,'L');
					for($n=0;$n<$num_name1;$n++){
						
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],$col_height,"$arr_name1[$n]",0,0,'L');
						$y=$y+$col_height;
					}
				}//end 	if($num_name1 == 1){

				
				
				//$pdf->Cell($col_width[0],$col_height,"�.  ���� $rs_noAt[prename_th]$rs_noAt[name_th]  $rs_noAt[surname_th]   �Դ�ѹ��� ".$b_birth.'',1,0,'L');
					}// end if($num_row_name > 0){
				//�����ǹ�ͧ��ûԴ�Դ����ʴ�����¡�â����Ţͧ�ؤ��
				
							
// �ѹ�֡ log gen barcode
if($genbarcode == true){
	$temp_pdf_path = "";
	$expire_date = "";
	$activitylog_admin_id = $_SESSION[idoffice];
	$activitylog_admin_office = $_SESSION[office_name];
	$activitylog_admin_office_sname = $_SESSION[office_sername];
	$makelog = new activity_log;
	$makelog->save_log("$activitylog_idcard","$activitylog_name","$activitylog_sername","$server_id","$activity_id","$temp_pdf_path","$expire_date","$activitylog_admin_id","$activitylog_admin_office","$activitylog_admin_office_sname");
	$activitylog_barcode =  $makelog->getbarcode();
	$makelog->update_temp();
}

/// $y=79;


$pdf->SetXY(10,$y); // ��÷Ѵ �������

			$col_width = array(189); // ��˹��������ҧ column
			$col_height = 8;

			$pdf->SetFont($font_format,'',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
		// ������鹡�ûԴ�Դ����ʴ��Ţ����� �������㹡�7
			$strSQL1=mysql_query("SELECT * FROM hr_addhistoryaddress WHERE gen_id='$id' AND kp7_active='$kp7' ORDER BY runno DESC");
				$num_row_address=mysql_num_rows($strSQL1);
					if($num_row_address != ""){
						$Rs1=mysql_fetch_assoc($strSQL1);
						
						$xpos = strpos($Rs1['address'], PREFIX_ADD); #��Ǩ�ͺ prefix ���� replace ��� ��ҹ�Ţ����͡
						$txt_address = ($xpos === false)? PREFIX_ADD." $Rs1[address]":"$Rs1[address]";
						
					$pdf->Cell($col_width[0],$col_height,"�.  �������Ѩ�غѹ $txt_address ���Ѿ�� $xcontact_tel",1,0,'L');
						
					
					}else{
					$pdf->Cell($col_width[0],$col_height,"�.  �������Ѩ�غѹ   ���Ѿ�� $xcontact_tel",1,0,'L');
					}
			// ����ûԴ�ԡ����ʴ��Ţ����ŷ������� ��7
			
			
// �����˹�һ���ѵ���Ңͧ������

/*$sql = "select t1.*,t2.religion as religionname,t3.blood as bloodgroup from  (general t1 left join $dbnamemaster.hr_religion t2 on t1.region=t2.id) left join $dbnamemaster.hr_blood t3 on t1.blood=t3.id where t1.id='$id'  ;";
		$result = mysql_query($sql);
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);

$date_d = explode("-",$rs[startdate]); // �ѹ��觺�è�
$date_bd = explode("-",$rs[birthday]); // �ѹ�Դ*/
$date_bg = explode("-",$rs[begindate]); // �ѹ�������Ժѵԧҹ
$sql1="select type_date,type_nec from type_showdate where id_type='$rs[type_dateshow2]' ";
$query1=mysql_query($sql1)or die(mysql_error());
$rs1=mysql_fetch_array($query1);
		if($rs1[type_nec]=="n" ){
				$b_birthday=$rs1[type_date];
		}
		else{
				$b_day = new date_format;
				$b_birthday= $b_day->show_date($rs1[type_date],($date_bd[0]-543)."-".$date_bd[1]."-".$date_bd[2]);
		}
		
		# check ��õ�Ǩ�ͺ label �ͧ�ѹ��͹���Դ
		$b_birthday=showdate_label($rs[birthday],$b_birthday,$rs['birthday_label'],"birthday","2");
		
			$sql_showbdate="select * from type_showdate where id_type='$rs[type_showbegindate]' ";
			$q_showbdate=mysql_query($sql_showbdate)or die (mysql_error());
			$rssdate=mysql_fetch_assoc($q_showbdate);
			if($rssdate[type_nec]=="n"){
					$showbedate=$rssdate[type_date];
			}
			else{
					$b_showday = new date_format;
					$showbedate= $b_showday->show_date($rssdate[type_date],($date_bg[0]-543)."-".$date_bg[1]."-".$date_bg[2]);
			}
			
			# check ��õ�Ǩ�ͺ label �ͧ�ѹ�������Ժѵԧҹ
			$showbedate=showdate_label($rs[begindate],$showbedate,$rs['begindate_label'],"begindate");

$retire =  $pdf->retireDate($rs[birthday]);
if($rs[label_persontype2now] !="")
{
	$str_position=$rs[label_persontype2now];
}
else
{
	$str_position=$rs[persontype2_now];
}
/*if($rs[persontype2_now]=="����Ҫ��ä��" or $rs[position_now]=="���" or $rs[position_now]=="�ͧ����ӹ�¡��ʶҹ�֡��" or $rs[position_now]=="����ӹ�¡��ʶҹ�֡��" or $rs[position_now]=="����ӹ�¡���ç���¹"){
	$str_position = "���";
}else{
	$str_position = "�ؤ�ҡ÷ҧ����֡����蹵���ҵ�� 38 �. (2)";
}*/
/*
$d1=explode("-",$rs[birthday]);
if($d1[1] <= 10){
	if($d1[1] >= 10 && $d1[2] >= 01){
		$retire = "�ѹ��� 30 ��͹ �ѹ��¹ �.�.".intval($d1[0] + 61)."";
	} else {
		$retire = "�ѹ��� 30 ��͹ �ѹ��¹ �.�.".intval($d1[0] + 60)."";
	}	
} elseif($d1[1] >= 11){
	$retire = "�ѹ��� 30  ��͹ �ѹ��¹ �.�.".intval($d1[0] + 61)."";
}
*/
$y=$y+$col_height;

			$pdf->SetXY(10,$y); // ��˹���÷Ѵ���������¡�÷�� 1-9 // y =87

			$col_width = array(63,63,63); // ��˹��������ҧ column
			$col_height = 8;

			$pdf->SetFont($font_format,'',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			
			//������鹡�ûԴ�Դ����ʴ��� ����㹡�7
				$strSQL2=mysql_query("SELECT * FROM hr_addhistoryname WHERE gen_id='$id' AND kp7_active='$kp7' ORDER BY runno DESC");
				$num_row_name1=mysql_num_rows($strSQL2);
				
			$sql_history_name = "SELECT * FROM hr_addhistoryname WHERE gen_id='$id' AND kp7_active <> '$kp7' ORDER BY runno DESC";
			$result_h_name = mysql_query($sql_history_name);
			while($rsh1 = mysql_fetch_assoc($result_h_name)){
				$his_name1 .= " ($rsh1[prename_th]$rsh1[name_th]  $rsh1[surname_th]) ";
			}// end 	while($rsh1 = @mysql_fetch_assoc($result_h_name)){

				
				
				if($num_row_name1 > 0){
					$Rs2=mysql_fetch_assoc($strSQL2);
					
				$txt_his_name = "�. ���� $Rs2[prename_th]$Rs2[name_th]  $Rs2[surname_th] ".$his_name1;
				//echo $txt_his_name;
				$arr_name1 = array(); 
				$arr_name1 = $pdf->alignstr($txt_his_name,55);
				$num_name1 = count($arr_name1); // check �ӹǹ��÷Ѵ column 1
				if($num_name1 == 1){
					$pdf->Cell($col_width[0],$col_height,"$txt_his_name ",1,0,'L');
					$y=$y+$col_height;
				}else{
					
					$pdf->Cell($col_width[0],($col_height*$num_name1)," ",1,0,'L');
					for($n=0;$n<$num_name1;$n++){
						//if(($num_name1-$n) == 1){ $bo_line= 1;}else{ $bo_line=0;}
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],$col_height,"$arr_name1[$n]",0,0,'L');
						$y=$y+$col_height;
					}
				}//end 	if($num_name1 == 1){

					
					//$pdf->Cell($col_width[0],$col_height,"�. ���� $Rs2[prename_th] $Rs2[name_th] $Rs2[surname_th]",1,0,'L');
					
					
				}else{
			
			$sql_history_name = "SELECT * FROM hr_addhistoryname WHERE gen_id='$id' AND kp7_active <> '$kp7' ORDER BY runno DESC";
			$result_h_name = @mysql_query($sql_history_name);
			$k=0;
			while($rsh1 = @mysql_fetch_assoc($result_h_name)){
			$k++;
				if($k > 1){
				$xhis_name1 .= " ($rsh1[prename_th]$rsh1[name_th]  $rsh1[surname_th]) ";
				}//end if($k > 1){
			}// end 	while($rsh1 = @mysql_fetch_assoc($result_h_name)){

				
				$sql_noAt1 = "SELECT * FROM hr_addhistoryname WHERE gen_id='$id' ORDER BY runno DESC LIMIT 0,1 ";
				$result_noAt1 = mysql_query($sql_noAt1);
				$rs_noAt1 = mysql_fetch_assoc($result_noAt1);
				
				$txt_his_name = "�. ���� $rs_noAt1[prename_th]$rs_noAt1[name_th]  $rs_noAt1[surname_th]".$xhis_name1;
				$arr_name1 = array(); 
				$arr_name1 = $pdf->alignstr($txt_his_name,55);
				$num_name1 = count($arr_name1); // check �ӹǹ��÷Ѵ column 1
				if($num_name1 == 1){
					$pdf->Cell($col_width[0],$col_height,"$txt_his_name",1,0,'L');
					$y=$y+$col_height;
				}else{
				$pdf->Cell($col_width[0],($col_height*$num_name1)," ",1,0,'L');
					for($n=0;$n<$num_name1;$n++){
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],$col_height,"$arr_name1[$n]",0,0,'L');
						$y=$y+$col_height;
					}
				}//end 	if($num_name1 == 1){
				
				
				//$pdf->Cell($col_width[0],$col_height,"�.  ���� $rs_noAt1[prename_th]$rs_noAt1[name_th]  $rs_noAt1[surname_th] ",1,0,'L');

				}//end 	if($num_row_name1 > 0){
			// ����ûԴ�Դ����ʴ���� �� 7
			
			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			
			// �������ûԴ�Դ����ʴ��� �������
			$strSQL3=mysql_query("SELECT * FROM hr_addhistorymarry WHERE gen_id='$id' AND kp7_active='$kp7' ORDER BY runno DESC");
				$num_row_marry=mysql_num_rows($strSQL3);
					if($num_row_marry > 0){
					$Rs3=mysql_fetch_assoc($strSQL3);
							if($num_name1 == 1){
						
								$pdf->Cell($col_width[1],$col_height,"�. ���ͤ������ $Rs3[prename_th] $Rs3[name_th] $Rs3[surname_th]",1,0,'L');
								
							}else{
								$pdf->Cell($col_width[1],$col_height,"�. ���ͤ������ $Rs3[prename_th]$Rs3[name_th] $Rs3[surname_th]",0,0,'L');
								$pdf->Cell($col_width[1],($col_height*$num_name1)," ",1,0,'L');
								
								
							}//end if($num_name1 == 1){
					}else{
							if($num_name1 == 1){
								$pdf->Cell($col_width[1],$col_height,"�. ���ͤ������",1,0,'L');
							}else{
								
								$pdf->Cell($col_width[1],$col_height,"�. ���ͤ������",0,0,'L');
								$pdf->Cell($col_width[1],($col_height*$num_name1)," ",1,0,'L');
							}
					} //end 	if($num_row_marry > 0){
			// ���Դ�Դ����ʴ��� �������
			
			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
		######## ��ǹ����ʴ��� �ѹ��觺�è�
		/*if($rs[startdate_label] != ""){
			$show_startdate_label = $rs[startdate_label];
		}else{
			$show_startdate_label = intval($date_d[2])." ".$monthname[intval($date_d[1])]." ".$date_d[0];
		}*/
		
		# check ��õ�Ǩ�ͺ label �ͧ�ѹ��觺�è�
		$show_startdate_label = intval($date_d[2])." ".$monthname[intval($date_d[1])]." ".$date_d[0];
		$show_startdate_label=showdate_label($rs[startdate],$show_startdate_label,$rs['startdate_label'],"startdate");
		
			if($num_name1 == 1){
				$pdf->Cell($col_width[2],($col_height),"�. �ѹ��觺�è�  ".$show_startdate_label.'',1,0,'L');
				$y=$y+$col_height;
			}else{
				//$pdf->Cell($col_width[2],($col_height*$num_name1)," ",1,0,'L');
				$pdf->Cell($col_width[2],($col_height),"�. �ѹ��觺�è�  ".$show_startdate_label.'',0,0,'L');
				
				for($i=0;$i<$num_name1;$i++){
					if(($num_name1 - $i) == "1"){ $border_line = 1;}else{ $border_line = 0;}
					$y=$y+$col_height;
					$pdf->Cell($col_width[2],($col_height)," ",$border_line,0,'L');
				}
				
			}

$pdf->SetXY(10,$y); // 95

			$col_width = array(63,63,63);
			$col_height = 8;
			$col_height2 = 14;
			$col_height3 = 6;

			$pdf->SetFont($font_format,'',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height2,'',1,0,'L');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height2,'',1,0,'L');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height2,'',1,0,'L');

//****************  data *********************

$pdf->SetXY(10,$y);

			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			//$pdf->Cell($col_width[0],$col_height,"�. �ѹ ��͹ �� �Դ  ".intval($date_bd[2])." ".$monthname[intval($date_bd[1])]."  �.�. ".$date_bd[0].'',0,0,'L');

			$pdf->Cell($col_width[0],$col_height,"�. �ѹ ��͹ �� �Դ  ".$b_birthday.'',0,0,'L');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			
			// ������鹻Դ�Դ ����ʴ��� ���� �Դ�
			
			$strSQL5=mysql_query("SELECT * FROM hr_addhistoryfathername WHERE gen_id='$id' AND kp7_active='$kp7' ORDER BY runno DESC");
					$num_row_father=mysql_num_rows($strSQL5);
					if($num_row_father != ""){
						$Rs5=mysql_fetch_assoc($strSQL5);
						$pdf->Cell($col_width[1],$col_height,"�. ���ͺԴ�  $Rs5[father_prename] $Rs5[father_name] $Rs5[father_surname]",0,0,'L');
					}else{
					$pdf->Cell($col_width[1],$col_height,"�. ���ͺԴ�  ",0,0,'L');
					}
			//�� �Դ�Դ ����ʴ��� ���� �Դ�
			
			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"�. �ѹ�������Ժѵ��Ҫ��� $showbedate",0,0,'L');


$y=$y+$col_height;
$pdf->SetXY(10,$y);// 101
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y ;
			$pdf->SetXY($x ,$y);
				#### ��ǹ�ѹ��͹���Դ label
				$txt_showBirth_3=showthaidate(intval($date_bd[2]))." ".$monthname[intval($date_bd[1])]." ".showthaidate($date_bd[0]);
				/*if($rs[birthday_label] != ""){
					$txt_birthday = " ( ".$rs[birthday_label]." ) ";
				}else{
					$txt_birthday = "( ".showthaidate(intval($date_bd[2]))." ".$monthname[intval($date_bd[1])]." ".showthaidate($date_bd[0])." )";
				}*/
				
				# check ��õ�Ǩ�ͺ label �ͧ�ѹ�Դ ��ǹ��� 3 �ç�������ǧ���
				$txt_birthday = "( ".showdate_label($rs['birthday'],$txt_showBirth_3,$rs['birthday_label'],"birthday","3")." )";
				
			$pdf->Cell($col_width[0],$col_height3,"$txt_birthday",0,0,'R');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height3,"",0,0,'L');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height3,"",0,0,'L');


$y=$y+$col_height3;
$pdf->SetXY(10,$y);//  109

			$col_width = array(63,63,63);
			$col_height = 8;

			$pdf->SetFont($font_format,'',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			###  ��Ǩ�ͺ����ʴ��Ż��ª����ѹ���³�����Ҫ���
			if($rs[retire_label] != ""){
				$retire = $rs[retire_label];
			}else{
				$retire = $retire;
			}
			### end ��Ǩ�ͺ����ʴ��Ż��ª����ѹ���³�����Ҫ���
			$pdf->Cell($col_width[0],$col_height,"�. �ѹ�ú���³����  $retire",1,0,'L');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			// ������鹻Դ�Դ����ʴ��� ������ô�
				$strSQL4=mysql_query("SELECT * FROM hr_addhistorymothername WHERE gen_id='$id' AND kp7_active='$kp7' ORDER BY runno DESC");
					$num_row_mother=mysql_num_rows($strSQL4);
						if($num_row_mother != ""){
								$Rs4=mysql_fetch_assoc($strSQL4);
						$pdf->Cell($col_width[1],$col_height,"�. ������ô�  $Rs4[mother_prename] $Rs4[mother_name] $Rs4[mother_surname]",1,0,'L');	
						}else{
						$pdf->Cell($col_width[1],$col_height,"�. ������ô�  ",1,0,'L');
						}
			
			// ���Դ�Դ����ʴ��� ������ô�
			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"�. ����������Ҫ���  $str_position",1,0,'L');


$y = 270;
$setpass = "$date_bd[2]"."$date_bd[1]"."$date_bd[0]"."$getidcard" ;
//$pdf->SetProtection(array('print'),'competency',"$setpass");

$pdf->cfooter();
if($activitylog_barcode!=""){
$pdf->Output("tmp_pdf/".$activitylog_barcode.".pdf",'F');
}
$pdf->Output($id.".pdf",'D');
?>