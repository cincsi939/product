<?php
define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/fpdf.php');
require('spt_class.php');

$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$monthsname = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");
$pdf=new SPT();
$pdf->AddThaiFonts();
$pdf->AliasNbPages();
$pdf->AddPage('L');
$pdf->SetAutoPageBreak('auto',15);

$pdf->SetFont('Angsana New','',14);
$pdf->SetXY(10,10);
$pdf->Cell(270,10,'Ẻ��ػ����ҳ�ҹ�ͧʶҹ�֡�һ�Сͺ����ҧἹ�ѵ�ҡ��ѧ��٢ͧʶҹ�֡�� �ѧ�Ѵ�ӹѡ�ҹ��С�����á���֡�Ң�鹾�鹰ҹ �է�����ҳ ',0,0,'C');
$pdf->SetXY(10,15);
$pdf->Cell(270,15,'ʾ�. $global_areaname ࢵ $global_areaname_no ',0,0,'C');
$pdf->SetXY(10,20);
$pdf->Cell(270,20,'�觾����˹ѧ��� ʾ�.  ࢵ  ��� ȸ  ŧ�ѹ��� ',0,0,'C');

$pdf->SetXY(10,35);

			$col_width = array(20,60,6,6,6,6,6,6,6,6,6,6,70,14,14,14,14,14,7,7,7,7,7,7,7,7,7,7,42,21,21,7,7,7,7,7,7,21,7,7,7,10,10,10,34,17,17); // ��˹��������ҧ column
			$col_height = 20;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"������",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height/2),"�ӹǹ�ç���¹������ʷ����",1,0,'C');
			
			$pdf->SetFont('Angsana New','B',10);
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height/2),"�",1,0,'C');

			$x += $col_width[2];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height/2),"�",1,0,'C');

			$x += $col_width[3];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height/2),"�",1,0,'C');

			$x += $col_width[4];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height/2),"�",1,0,'C');

			$x += $col_width[5];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[6],($col_height/2),"�",1,0,'C');

			$x += $col_width[6];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[7],($col_height/2),"�",1,0,'C');

			$x += $col_width[7];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[8],($col_height/2),"�",1,0,'C');

			$x += $col_width[8];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[9],($col_height/2),"�",1,0,'C');

			$x += $col_width[9];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[10],($col_height/2),"�",1,0,'C');

			$x += $col_width[10];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[11],($col_height/2),"���",1,0,'C');


			$x += $col_width[11];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[12],($col_height/4),"����ҳ�ҹ",1,0,'C');

			$pdf->SetFont('Angsana New','B',10);
			$y  = $row1_y+($col_height/4);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[13],($col_height/4),"͹غ��",1,0,'C');

			$x += $col_width[13];
			$y  = $row1_y+($col_height/4);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[14],($col_height/4),"�.�-�.�",1,0,'C');

			$x += $col_width[14];
			$y  = $row1_y+($col_height/4);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[15],($col_height/4),"�.�-�.�",1,0,'C');

			$x += $col_width[15];
			$y  = $row1_y+($col_height/4);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[16],($col_height/4),"�.�-�.�",1,0,'C');

			$x += $col_width[16];
			$y  = $row1_y+($col_height/4);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[17],($col_height/4),"���",1,0,'C');

			
			$pdf->SetFont('Angsana New','B',10);
			$x -= ($col_width[13]+$col_width[14]+$col_width[15]+$col_width[16]);
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[18],($col_height/2),"��.",1,0,'C');

			$x += $col_width[18];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[19],($col_height/2),"��ͧ",1,0,'C');

			$x += $col_width[19];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[20],($col_height/2),"��.",1,0,'C');

			$x += $col_width[20];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[21],($col_height/2),"��ͧ",1,0,'C');

			$x += $col_width[21];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[22],($col_height/2),"��.",1,0,'C');

			$x += $col_width[22];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[23],($col_height/2),"��ͧ",1,0,'C');

			$x += $col_width[23];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[24],($col_height/2),"��.",1,0,'C');

			$x += $col_width[24];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[25],($col_height/2),"��ͧ",1,0,'C');

			$x += $col_width[25];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[26],($col_height/2),"��.",1,0,'C');

			$x += $col_width[26];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[27],($col_height/2),"��ͧ",1,0,'C');


			$x += $col_width[27];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[28],($col_height/4),"�ӹǹ���",1,0,'C');

			$pdf->SetFont('Angsana New','B',10);
			$y  = $row1_y+($col_height/4);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[29],($col_height/4),"��� �.18",1,0,'C');

			$x += $col_width[29];
			$y  = $row1_y+($col_height/4);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[30],($col_height/4),"���ࡳ�� �.�",1,0,'C');

			$pdf->SetFont('Angsana New','B',10);
			$x -= ($col_width[30]);
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[31],($col_height/2),"��.",1,0,'C');

			$x += $col_width[31];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[32],($col_height/2),"���",1,0,'C');

			$x += $col_width[32];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[33],($col_height/2),"���",1,0,'C');

			$x += $col_width[33];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[34],($col_height/2),"��.",1,0,'C');

			$x += $col_width[34];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[35],($col_height/2),"���",1,0,'C');

			$x += $col_width[35];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[36],($col_height/2),"���",1,0,'C');

			$x += $col_width[36];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[37],($col_height/2),"�ӹǹ���-�Ҵ �Թ",1,0,'C');

			$pdf->SetFont('Angsana New','B',10);
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[38],($col_height/2),"��.",1,0,'C');

			$x += $col_width[38];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[39],($col_height/2),"���",1,0,'C');

			$x += $col_width[39];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[40],($col_height/2),"���",1,0,'C');

			$x += $col_width[40];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[41],($col_height/2),"�Ҵ�Թ",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[41],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[41],($col_height/2),"������",0,0,'C');

			$x += $col_width[41];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[42],($col_height/2),"������³",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[42],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[42],($col_height/2),"��",0,0,'C');

			$x += $col_width[42];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[43],($col_height/4),"��ѡ�ҹ",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[43],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/4);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[43],($col_height/4),"�Ҫ���",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[43],($col_height),"",0,0,'');

			$y  = $row1_y+($col_height/2.6);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[43],($col_height/2.6),"���˹�",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[43],($col_height),"",0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[43],($col_height/2),"��ټ���͹",0,0,'C');

			$x += $col_width[43];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[44],($col_height/2),"������੾�� �.�.���Ҵ���",1,0,'C');

			$pdf->SetFont('Angsana New','B',10);
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[45],($col_height/2),"�ӹǹ�ç���Ҵ",1,0,'C');

			$x += $col_width[45];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[46],($col_height/2),"�ӹǹ��ٷ��Ҵ",1,0,'C');


		$pdf->SetMargins($pdf->save_lMargin,$pdf->save_tMargin);
		$pdf->SetLineWidth(0.1);
		$pdf->Rect($pdf->left,$pdf->top,$pdf->width,$pdf->height);

		$pdf->SetFont('Angsana New','',12);

		$pdf->SetY(-40);
		$pdf->Cell(500,0,"���Ѻ�ͧ��Ң����Ŷ١��ͧ",0,0,'C');

		$pdf->SetY(-30);
		$pdf->Cell(500,0,"______________________________",0,0,'C');

		$pdf->SetY(-25);
		$pdf->Cell(500,0,"(______________________________)",0,0,'C');

		$pdf->SetY(-20);
		$pdf->Cell(500,0,"���˹� ���˹�ҡ���������çҹ�ؤ��",0,0,'C');

		$pdf->SetY(-15);
		$pdf->Cell(500,0,"ʾ�._________________ࢵ______",0,0,'C');

$pdf->Output(spt_pdf.".pdf",'D');
?>