<?php
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_absent";
$module_code 		= "absent"; 
$process_id			= "absent";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer::
#DateCreate::17/07/2007
#LastUpdate::17/07/2007
#DatabaseTabel::
#END
#########################################################
define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/fpdf.php');
require('spt_class.php');

//include("session.inc.php");
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();


$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$monthsname = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");
$datenow = date("d") . " " . $monthname[intval(date("m"))] . " �.�. " . (date("Y")+543);


include("timefunc.inc.php");
//include("phpconfig.php");
//include("db.inc.php");

//conn2DB();


$sql = "select *,t2.th_name,t3.ampname from general t1 left join smis_matchschool t2 ON t1.unit = t2.id left join area_ampur t3 on t2.ampid = t3.ampid where t1.id = '$getid';";
$result = mysql_query($sql);
$rs=mysql_fetch_array($result,MYSQL_ASSOC);
$diff1 = dateLength($rs[birthday]);
$diff2 = dateLength($rs[begindate]);
if($rs[vitaya] == "�ӹҭ���"){
		$vitaya_t = "�ӹҭ��þ����";
}else if($rs[vitaya] == "����Ǫҭ"){
		$vitaya_t = "����Ǫҭ�����";
}else{
		$vitaya_t = "�ӹҭ���";
}

$sql2 = "select * from salary where id = '$getid' order by runno desc limit 1 ;";
$result2 = mysql_query($sql2);
$rs2=mysql_fetch_array($result2,MYSQL_ASSOC);
$date_o = explode("-",$rs2[dateorder]); // �ѹ��� �ѹ ��͹ ��  
if ($rs2[dateorder] != "" && $rs2[dateorder] != "0000-00-00" ) {
	$xdate_o = " ".intval($date_o[2])." ".$monthname[intval($date_o[1])]." �.�.".$date_o[0].'';
}else{
	$xdate_o = "";
}

$sql3 = "select * from salary where id = '$getid' order by runno asc limit 1 ;";
$result3 = mysql_query($sql3);
$rs3=mysql_fetch_array($result3,MYSQL_ASSOC);
$date_x = explode("-",$rs3[date]); // �ѹ��� �ѹ ��͹ ��  
$xdate_x = " ".intval($date_x[2])." ".$monthname[intval($date_x[1])]." �.�.".$date_x[0].'';

$sql4 = "select * from graduate where id = '$getid' order by runno desc limit 1 ;";
$result4 = mysql_query($sql4);
$rs4=mysql_fetch_array($result4,MYSQL_ASSOC);


$pdf=new SPT();
$pdf->AddThaiFonts();
$pdf->AliasNbPages();
$pdf->AddPage('P');

$pdf->SetFont('Angsana New','',20);
$pdf->SetXY(70,10);
$pdf->Cell(70,10,'��§ҹ����Ҫ��ä����кؤ�ҡ÷ҧ����֡�ҷ���դس���ѵ�����͹�Է°ҹ�',0,0,'C');
$pdf->SetXY(70,15);
$pdf->Cell(70,15,"���˹� $rs[position_now] �Է°ҹ� $vitaya_t",0,0,'C');
$pdf->SetFont('Angsana New','',18);
$pdf->SetXY(20,25);
$pdf->Cell(20,25,"1. �����ż����Ѻ��û����Թ",0,0,'L');
$pdf->SetFont('Angsana New','',16);
$pdf->SetXY(20,30);
$pdf->Cell(20,30,"����-ʡ�� $rs[prename_th] $rs[name_th] $rs[surname_th] ���� $diff1[year] �� �����Ҫ��� $diff2[year] �� ",0,0,'L');
$pdf->SetXY(20,35);
$pdf->Cell(20,35,"�س�ز��٧�ش $rs[education] �Ԫ��͡ $rs4[grade] �ҡʶҺѹ����֡�� $rs4[place]",0,0,'L');
$pdf->SetXY(20,40);
$pdf->Cell(20,40,"���˹�  $rs[position_now]  ���˹��Ţ��� $rs[noposition]",0,0,'L');
$pdf->SetXY(20,45);
$pdf->Cell(20,45,"ʶҹ�֡�� $rs[th_name] �����/ࢵ $rs[ampname]",0,0,'L');
$pdf->SetXY(20,50);
$pdf->Cell(20,50,"ࢵ��鹷�����֡�� $global_areaname ࢵ $global_areaname_no ���/��ǹ�Ҫ��� $rs[subminis_now]",0,0,'L');
$pdf->SetXY(20,55);
$pdf->Cell(20,55,"�Ѻ�Թ��͹��ѹ�Ѻ $rs2[radub] ��� ".number_format($rs2[salary])." �ҷ",0,0,'L');

$pdf->SetFont('Angsana New','',18);
$pdf->SetXY(20,60);
$pdf->Cell(20,60,"2. ����Ѻ�Ҫ���",0,0,'L');
$pdf->SetFont('Angsana New','',16);
$pdf->SetXY(20,65);
$pdf->Cell(20,65,"2.1 ������Ѻ�Ҫ���㹵��˹� $rs3[position] ������ѹ��� $xdate_x",0,0,'L');
$pdf->SetXY(20,70);
$pdf->Cell(20,70,"2.2 �´�ç����/�Է°ҹ� ����Ӥѭ �ѧ���",0,0,'L');

$pdf->SetXY(20,110);

			$col_width = array(25,90,60,30,30); // ��˹��������ҧ column
			$col_height = 14;

			$pdf->SetFont('Angsana New','',14);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"�ѹ ��͹ ��",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"���˹�/�Է°ҹ�",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height/2),"�Ѻ�Թ��͹",1,0,'C');
			
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height/2),"�дѺ/�ѹ�Ѻ",1,0,'C');

			$x += $col_width[3];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height/2),"���/�ҷ",1,0,'C');


$col_width = array(25,90,30,30);
/*
$subsql = "select radub,date,position,salary from salary where id = '$getid' group by radub order by runno ";
$query = mysql_query($subsql);
*/

	$result1= mysql_query("select position as position  from salary where id='$getid'  GROUP BY position order by date asc  ;");
				while ($rs1=mysql_fetch_array($result1,MYSQL_ASSOC)){

					$result2 = mysql_query("select min(date) as mindate, max(date) as maxdate  from salary  where id='$getid' and position = '$rs1[position]' order by maxdate desc ");
					$rs2=mysql_fetch_array($result2,MYSQL_ASSOC);

					$result3 = mysql_query("select  radub,salary  from salary  where id='$getid' and position = '$rs1[position]' and date = '$rs2[maxdate]' ");
					$rs3=mysql_fetch_array($result3,MYSQL_ASSOC);

					If ($rs2[maxdate] == "00000000")
						{
							$xdate_s = " ";
			
						}else{
							$d1=explode("-",$rs2[maxdate]);
							$xdate_s = intval($d1[2]) . " " . $monthsname[intval($d1[1])] . "  " . $d1[0];

						}

		$y =  $pdf->GetY();
			
			$x = 20;
			$col_height = 7;
			$y +=  $col_height;

			$pdf->SetFont('Angsana New','',14);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,$xdate_s,1,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,$rs1[position],1,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,$rs3[radub],1,0,'C');

			$x += $col_width[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],$col_height,number_format($rs3[salary]),1,0,'C');

}

			$row1_y = $pdf->GetY();

			$x = 20;
			$y = $row1_y+$col_height+2;
			$col_height = 8;

$pdf->SetXY($x,$y); 
$pdf->SetFont('Angsana New','',16);
$pdf->Cell(10,$col_height,"2.3 ���Ѻ�觵������ç���˹觻Ѩ�غѹ ������ѹ��� $xdate_o",0,0,'L');
$y +=  $col_height;
$pdf->SetXY($x,$y);
$pdf->Cell(10,$col_height,"���Ѻ�觵�����Է°ҹлѨ�غѹ ������ѹ��� ",0,0,'L');
$y +=  $col_height;
$pdf->SetXY($x,$y);
$pdf->Cell(10,$col_height,"2.4 �¢�����������͹���Է°ҹ����ǡѹ��� �����ش���� ������ѹ��� ",0,0,'L');
$y +=  $col_height;
$pdf->SetFont('Angsana New','',18);
$pdf->SetXY($x,$y);
$pdf->Cell(10,$col_height,"3. ��§ҹ�ŧҹ����Դ�ҡ��û�Ժѵ�˹�ҷ��",0,0,'L');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->SetFont('Angsana New','',16);
$pdf->Cell(10,$col_height,"���ʹ���§ҹ�ŧҹ����Դ�ҡ��û�Ժѵ�˹�ҷ����͹��ѧ 2 �յԴ��͡ѹ ���Ẻ ǰ.2 �ӹǹ 4 �ش �Ҿ�������",0,0,'L');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"���Ѻ�ͧ��Ң����ŷ������١��ͧ ����繤�����ԧ",0,0,'C');
$y +=  ($col_height*2);
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"(ŧ����)___________________________________________",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"$rs[prename_th] $rs[name_th] $rs[surname_th]",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"���˹�$rs[position]$rs[vitaya]",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"�ѹ���  $datenow",0,0,'C');


$pdf->AddPage('P');

$pdf->SetFont('Angsana New','',20);
$pdf->SetXY(70,10);
$pdf->Cell(70,10,'��õ�Ǩ�ͺ����Ѻ�ͧ',0,0,'C');

			$y = 15;
			$x = $pdf->lMargin;
			$col_height = 10;

$pdf->SetFont('Angsana New','',16);
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"��õ�Ǩ�ͺ����Ѻ�ͧ�ͧ���ѧ�Ѻ�ѭ�Ҫ�鹵�",0,0,'L');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->SetFont('Angsana New','',16);
$pdf->Cell(200,$col_height,"               ���Ǩ�ͺ�����Ѻ�ͧ��Ң����Ŷ١��ͧ ����繤�����ԧ",0,0,'L');
$y +=  ($col_height*2);
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"(ŧ����)_______________________________________",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"         _______________________________________",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"���˹�_______________________________________",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"�ѹ���________��͹____________________�.�.___________",0,0,'C');
$y +=  ($col_height*2);
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"��õ�Ǩ�ͺ�س���ѵԢͧ�ӹѡ�ҹࢵ��鹷�����֡�� ������ǹ�Ҫ���",0,0,'L');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"               ���Ǩ�ͺ����",0,0,'L');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"               (     )  �դس���ѵԵ����� �.�.�. ��˹�",0,0,'L');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"               (     )  �Ҵ�س���ѵ� (�к�)______________________________________________________________________",0,0,'L');
$y +=  ($col_height*2);
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"                                      (ŧ����)_______________________________________����Ǩ�ͺ�س���ѵ�",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"            (_______________________________________)",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"���˹�_______________________________________",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"�ѹ���______��͹_________________�.�.________",0,0,'C');
$y +=  ($col_height*2);
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"(ŧ����)_______________________________________",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"         _______________________________________",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"����ӹ�¡���ӹѡ�ҹࢵ��鹷�����֡��/���˹����ǹ�Ҫ���",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"(���ͼ�����Ѻ�ͺ����)",0,0,'C');
$y +=  $col_height;
$pdf->SetXY($x,$y); 
$pdf->Cell(200,$col_height,"�ѹ���______��͹_________________�.�.________",0,0,'C');


$pdf->Output(wt1_pdf.".pdf",'D');
 $time_end = getmicrotime(); writetime2db($time_start,$time_end); 
?>