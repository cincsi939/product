<?php
define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/fpdf.php');
require('spt_class.php');
include("../../../config/config_hr.inc.php");

$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$monthsname = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");
//$datenow = date("d/m/") . (date("Y")+543);
$datenow = date("d") . " " . $monthname[intval(date("m"))] . " �.�. " . (date("Y")+543);
$timenow = date("H:i:s");
$pdf=new SPT();
$pdf->AddThaiFonts();
$pdf->AliasNbPages();
$pdf->AddPage('L');
$pdf->SetAutoPageBreak('auto',15);

$pdf->SetFont('Angsana New','',16);
$pdf->SetXY(10,10);
$pdf->Cell(270,10,"Ẻ��§ҹ����ҳ�ҹ�ͧʶҹ�֡��",0,0,'C');
$pdf->SetFont('Angsana New','',14);
$pdf->SetXY(10,15);
$pdf->Cell(10,15,'1. �ç���¹___________________',0,0,'L');
$pdf->SetXY(10,20);
$pdf->Cell(10,20,"    �����___________________ �ӹѡ�ҹࢵ��鹷�����֡�� $global_areaname ࢵ $global_areaname_no",0,0,'L');
$pdf->SetXY(10,25);
$pdf->Cell(10,25,'2. ��èѴ����֡�Ҵ��Թ��� �ѧ���',0,0,'L');
$pdf->SetXY(10,30);
$pdf->Cell(10,30,'	     ( ) 2.1 ��͹��ж��֡��   ( ) �����   ( ) ͹غ�� 3 �Ǻ   ( ) ͹غ�� 1-2',0,0,'L');
$pdf->SetXY(10,35);
$pdf->Cell(10,35,'     ( ) 2.2 ��ж��֡��           ( ) �.1-4     ( ) �.1-6   ( ) ࡳ���硻���鹻�',0,0,'L');
$pdf->SetXY(10,40);
$pdf->Cell(10,40,'     ( ) 2.3 �Ѹ���֡��             ( ) �.1-3     ( ) �.1-6',0,0,'L');
$pdf->SetXY(10,45);
$pdf->Cell(10,45,'3. ��������´����ǡѺ��ͧ���¹��йѡ���¹',0,0,'L');

$pdf->SetXY(10,70);

			$col_width = array(35,20,20,15); // ��˹��������ҧ column
			$col_height = 10;

			$pdf->SetFont('Angsana New','',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"������¹",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"�ӹǹ��ͧ���¹",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"�ӹǹ�ѡ���¹",1,0,'C');

			$x += $col_width[2];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],$col_height,"�����˵�",1,0,'C');

$pdf->SetXY(105,70);

			$col_width = array(35,20,20,15); // ��˹��������ҧ column
			$col_height = 10;

			$pdf->SetFont('Angsana New','',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"������¹",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"�ӹǹ��ͧ���¹",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"�ӹǹ�ѡ���¹",1,0,'C');

			$x += $col_width[2];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],$col_height,"�����˵�",1,0,'C');

			$pdf->SetFont('Angsana New','',14);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x-($col_width[0]+$col_width[1]+$col_width[2]+$col_width[3]);
			$y = $row1_y+$col_height;

			$pdf->SetXY($x ,$y);
			$pdf->Cell(40,10,'4. �ѵ�ҡ��ѧ�������١��ҧ',0,0,'L');

$pdf->SetFont('Angsana New','',10);
$row1_x = $pdf->GetX();
$row1_y = $pdf->GetY();
$x = $row1_x-40;
$y = $row1_y+$col_height;
$pdf->SetXY($x ,$y);

			$col_width = array(30,10,10,10,30,10,10,10,15,20,10,10,12,12); // ��˹��������ҧ column
			$col_height = 10;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height/2),"��ٵ��ࡳ��",1,0,'C');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height/2),"�.",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height/2),"�.",1,0,'C');

			$x += $col_width[2];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height/2),"���",1,0,'C');

			$x += $col_width[3];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height/2),"��ٵ�� �.18",1,0,'C');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height/2),"�.",1,0,'C');

			$x += $col_width[5];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[6],($col_height/2),"�.",1,0,'C');

			$x += $col_width[6];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[7],($col_height/2),"���",1,0,'C');

			$x += $col_width[7];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[8],$col_height,"�Ҵ/�Թ",1,0,'C');

			$x += $col_width[8];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[9],($col_height/2),"��٪����Ҫ���",1,0,'C');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[10],($col_height/2),"���",1,0,'C');

			$x += $col_width[10];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[11],($col_height/2),"�͡",1,0,'C');

			$x += $col_width[11];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[12],$col_height,"����ը�ԧ",1,0,'C');

			$x += $col_width[12];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[13],$col_height,"�Ҵ/�Թ",1,0,'C');

$pdf->SetFont('Angsana New','',14);
$pdf->SetXY(195,40);
$pdf->Cell(195,40,'5. �ӹǹ��������Ǵ�ԪҢͧ����Ҫ��ä�ٷ�������',0,0,'L');


		$pdf->SetMargins($pdf->save_lMargin,$pdf->save_tMargin);
		$pdf->SetLineWidth(0.1);
		$pdf->Rect($pdf->left,$pdf->top,$pdf->width,$pdf->height);

		$pdf->SetFont('Angsana New','',12);

		$pdf->SetY(-90);
		$pdf->Cell(500,0,"���Ѻ�ͧ��Ң����Ŷ١��ͧ",0,0,'C');

		$pdf->SetY(-80);
		$pdf->Cell(500,0,"______________________________",0,0,'C');

		$pdf->SetY(-75);
		$pdf->Cell(500,0,"(______________________________)",0,0,'C');

		$pdf->SetY(-70);
		$pdf->Cell(500,0,"��������ʶҹ�֡��",0,0,'C');

		$pdf->SetY(-65);
		$pdf->Cell(500,0,"ʾ�._________________ࢵ______",0,0,'C');

		$pdf->SetY(-60);
		$pdf->Cell(500,0,"�ѹ��� $datenow",0,0,'C');

		$pdf->SetY(-45);
		$pdf->Cell(500,0,"���Ѻ�ͧ��Ң����Ŷ١��ͧ",0,0,'C');

		$pdf->SetY(-35);
		$pdf->Cell(500,0,"______________________________",0,0,'C');

		$pdf->SetY(-30);
		$pdf->Cell(500,0,"(______________________________)",0,0,'C');

		$pdf->SetY(-25);
		$pdf->Cell(500,0,"���˹�ҡ���������çҹ�ؤ��",0,0,'C');

		$pdf->SetY(-20);
		$pdf->Cell(500,0,"ʾ�._________________ࢵ______",0,0,'C');

		$pdf->SetY(-15);
		$pdf->Cell(500,0,"�ѹ��� $datenow",0,0,'C');
			

$pdf->Output(spt_schwork_pdf.".pdf",'D');
?>