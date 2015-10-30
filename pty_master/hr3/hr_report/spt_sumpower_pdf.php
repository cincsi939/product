<?php
ob_start();
define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/fpdf.php');
require('spt_class.php');

include ("libary/config.inc.php");

$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$monthsname = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");

$pdf=new SPT();
$pdf->AddThaiFonts();
$pdf->AliasNbPages();
$pdf->AddPage('L');

$pdf->SetFont('Angsana New','',16);
$pdf->SetXY(10,10);
$pdf->Cell(270,10,'��ػ�����Ũӹǹ�ѵ�ҡ��ѧ����Ҫ��ä����л���ҳ�ҹʶҹ�֡�� ��Шӻա���֡�� 2550',0,0,'C');
$pdf->SetXY(10,15);
$pdf->Cell(270,15,'�ѧ�Ѵ �ӹѡ�ҹࢵ��鹷�����֡����§���� ࢵ 2',0,0,'C');

$pdf->SetXY(10,30);

			$col_width = array(10,40,90,18,18,18,18,18,30,15,15,63,21,21,21,15,15,15); // ��˹��������ҧ column
			$col_height = 20;

			$pdf->SetFont('Angsana New','',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"���",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"�����",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height/2),"�ӹǹ�ç���¹",1,0,'C');
			
			$pdf->SetFont('Angsana New','B',10);
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height/2),"��ж�",1,0,'C');

			$x += $col_width[3];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height/2),"�����͡���",1,0,'C');

			$x += $col_width[4];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height/2),"�Ѹ��",1,0,'C');

			$x += $col_width[5];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[6],($col_height/2),"�֡��ʧ������",1,0,'C');

			$x += $col_width[6];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[7],($col_height/2),"���",1,0,'C');


			$pdf->SetFont('Angsana New','B',12);
			$x += $col_width[7];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[8],($col_height/2),"�ӹǹ�ѡ���¹",1,0,'C');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[9],($col_height/2),"�ѡ���¹",1,0,'C');

			$x += $col_width[9];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[10],($col_height/2),"��ͧ",1,0,'C');

			$x += $col_width[10];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[11],($col_height/2),"�ӹǹ���",1,0,'C');


			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[12],($col_height/2),"��� �.18",1,0,'C');

			$x += $col_width[12];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[13],($col_height/2),"���ࡳ�� �.�.�.",1,0,'C');

			$x += $col_width[13];
			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[14],($col_height/2),"-�Ҵ,+�Թ",1,0,'C');


			$x += $col_width[14];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[15],($col_height/2),"�١��ҧ",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[15],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[15],($col_height/2),"��Ш�",0,0,'C');

			$x += $col_width[15];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[16],($col_height/2),"��ѡ�ҹ",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[16],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[16],($col_height/2),"�Ҫ���",0,0,'C');

			$x += $col_width[16];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[17],($col_height/2),"����ؤ�ҡ�",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[17],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[17],($col_height/2),"������",0,0,'C');

$col_width_data = array(10,40,18,18,18,18,18,15,15,21,21,21,15,15,15);

$sql = "select ampid,ampname from area_ampur where ampid in ('5006','5007','5008','5011','5014');";
$result = mysql_query($sql);
$no = 0;
$y = 44;
$col_height = 6;

while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){

			$sql = "select count(t1.id) from general t1 left join login t2 on t1.unit = t2.id left join area_ampur t3 on t2.ampid = t3.ampid where t3.ampid = $rs[ampid];";
			$result2 = mysql_query($sql);
			$rs2=mysql_fetch_array($result2);
			$num_teacherj18 = $rs2[0];

			$no++;
			$x = $pdf->lMargin;
			$y +=  $col_height;

			$pdf->SetFont('Angsana New','',12);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[0],$col_height,$no,1,0,'C'); // ���  

			$x += $col_width_data[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[1],$col_height,$rs[ampname],1,0,'L'); // ����� 

			$x += $col_width_data[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[2],($col_height),"",1,0,'C'); // ��ж� 

			$x += $col_width_data[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[3],($col_height),"",1,0,'C'); // �����͡�� 

			$x += $col_width_data[3];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[4],($col_height),"",1,0,'C'); // �Ѹ�� 

			$x += $col_width_data[4];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[5],($col_height),"",1,0,'C'); // �֡��ʧ������  

			$x += $col_width_data[5];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[6],($col_height),"",1,0,'C'); // ��� 

			$x += $col_width_data[6];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[7],($col_height),"",1,0,'C'); // �ѡ���¹ 

			$x += $col_width_data[7];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[8],($col_height),"",1,0,'C'); // ��ͧ 

			$x += $col_width_data[8];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[9],($col_height),number_format($num_teacherj18,0),1,0,'C'); // ��� �.18 

			$x += $col_width_data[9];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[10],($col_height),"",1,0,'C'); // ���ࡳ�� �.�.�.  

			$x += $col_width_data[10];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[11],($col_height),"",1,0,'C'); // �Ҵ�Թ  

			$x += $col_width_data[11];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[12],($col_height),"",1,0,'C'); // �١��ҧ��Ш� 

			$x += $col_width_data[12];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[13],($col_height),"",1,0,'C'); // ��ѡ�ҹ�Ҫ��� 

			$x += $col_width_data[13];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[14],($col_height),"",1,0,'C'); // ��� �ؤ�ҡ� ������ 

			if (($y) > 175) {$pdf->AddPage('L');$y=25;}


		} // end while

			$sql = "select count(t1.id) from general t1 left join login t2 on t1.unit = t2.id left join area_ampur t3 on t2.ampid = t3.ampid where t3.ampid in ('5006','5007','5008','5011','5014');";
			$result2 = mysql_query($sql);
			$rs2=mysql_fetch_array($result2);
			$sum_teacherj18 = $rs2[0];

			$x = $pdf->lMargin;
			$y +=  $col_height;

		$pdf->SetFont('Angsana New','',12);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[0],$col_height,"",1,0,'C'); // ���  

			$x += $col_width_data[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[1],$col_height,"���",1,0,'C'); // ����� 

			$x += $col_width_data[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[2],($col_height),"",1,0,'C'); // ��ж� 

			$x += $col_width_data[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[3],($col_height),"",1,0,'C'); // �����͡�� 

			$x += $col_width_data[3];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[4],($col_height),"",1,0,'C'); // �Ѹ�� 

			$x += $col_width_data[4];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[5],($col_height),"",1,0,'C'); // �֡��ʧ������  

			$x += $col_width_data[5];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[6],($col_height),"",1,0,'C'); // ��� 

			$x += $col_width_data[6];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[7],($col_height),"",1,0,'C'); // �ѡ���¹ 

			$x += $col_width_data[7];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[8],($col_height),"",1,0,'C'); // ��ͧ 

			$x += $col_width_data[8];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[9],($col_height),number_format($sum_teacherj18,0),1,0,'C'); // ��� �.18 

			$x += $col_width_data[9];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[10],($col_height),"",1,0,'C'); // ���ࡳ�� �.�.�.  

			$x += $col_width_data[10];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[11],($col_height),"",1,0,'C'); // �Ҵ�Թ  

			$x += $col_width_data[11];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[12],($col_height),"",1,0,'C'); // �١��ҧ��Ш� 

			$x += $col_width_data[12];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[13],($col_height),"",1,0,'C'); // ��ѡ�ҹ�Ҫ��� 

			$x += $col_width_data[13];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[14],($col_height),"",1,0,'C'); // ��� �ؤ�ҡ� ������ 

$pdf->Output(spt_sumpower_pdf.".pdf",'D');
?>