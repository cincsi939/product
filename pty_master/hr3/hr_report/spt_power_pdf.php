<?php
ob_start();

define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/fpdf.php');
require('spt_class.php');

include ("libary/config.inc.php");

$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$monthsname = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");

$pdf=new SPT();
$pdf->AliasNbPages();
$pdf->AddThaiFonts();
$pdf->AddPage('L');

$pdf->sptheader();

$col_width_data = array(8,38,9,9,9,9,9,9,9,9,11,11,9,9,8,8,8,8,8,8,8,8,8,8,10,10,10,10);
$y = 45;
		
		$sql = "select * from login order by ampid asc ;";
		$result = mysql_query($sql);
		$no = 0;
		$col_height = 5;
		$col_width_head = array(278);
		$ampid="";
		$pdf->SetFont('Angsana New','',12);
		while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){


// ��ͪ��� 	
			if ($rs[office] == "�ӹѡ�ҹ������ �ӹѡ�ҹࢵ��鹷�����֡����§����ࢵ 2"){
				$rs[office] = "ʾ�.��§���� ࢵ 2";
			}
			
// ��¹��÷Ѵ���  

			if ($ampid != $rs[ampid]){

if ($ampid != ""){

			$x = $pdf->lMargin;
			$y +=  $col_height;

			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[0],$col_height,"",1,0,'C'); // ���  

			$x += $col_width_data[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[1],$col_height,"���",1,0,'C'); // ����ʶҹ�֡�� 

			$x += $col_width_data[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[2],($col_height),number_format($sum_preroom,0),1,0,'C'); // ��͹��ж� ��ͧ 
			$sum_preroom = 0;

			$x += $col_width_data[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[3],($col_height),number_format($sum_prestudent,0),1,0,'C'); // ��͹��ж� ��.  
			$sum_prestudent = 0;

			$x += $col_width_data[3];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[4],($col_height),number_format($sum_grade6room,0),1,0,'C'); // ��ж� ��ͧ 
			$sum_grade6room = 0;

			$x += $col_width_data[4];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[5],($col_height),number_format($sum_grade6student,0),1,0,'C'); // ��ж� ��.  
			$sum_grade6student =0;

			$x += $col_width_data[5];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[6],($col_height),number_format($sum_grade9room,0),1,0,'C'); // �Ѹ���� ��ͧ 
			$sum_grade9room = 0;

			$x += $col_width_data[6];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[7],($col_height),number_format($sum_grade9student,0),1,0,'C'); // �Ѹ���� ��. 
			$sum_grade9student = 0;

			$x += $col_width_data[7];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[8],($col_height),number_format($sum_grade12room,0),1,0,'C'); // �Ѹ������ ��ͧ 
			$sum_grade12room = 0;

			$x += $col_width_data[8];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[9],($col_height),number_format($sum_grade12student,0),1,0,'C'); // �Ѹ������ ��. 
			$sum_grade12student = 0 ;

			$x += $col_width_data[9];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[10],($col_height),number_format($sum_totalroom1,0),1,0,'C'); // �����ж�����Ѹ�� ��ͧ 
			$sum_totalroom1 = 0;

			$x += $col_width_data[10];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[11],($col_height),number_format($sum_totalstudent1,0),1,0,'C'); // �����ж�����Ѹ�� ��. 
			$sum_totalstudent1 = 0;

			$x += $col_width_data[11];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[12],($col_height),number_format($sum_totalroom2,0),1,0,'C'); // ��������� ��ͧ 
			$sum_totalroom2 = 0; 

			$x += $col_width_data[12];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[13],($col_height),number_format($sum_totalstudent2,0),1,0,'C'); // ��������� ��. 
			$sum_totalstudent2 = 0;

			$x += $col_width_data[13];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[14],($col_height),number_format($sum_md,0),1,0,'C'); // ��� �18 ��. 
			$sum_md = 0;

			$x += $col_width_data[14];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[15],($col_height),number_format($sum_teacher,0),1,0,'C'); // ��� �18 ���  
			$sum_teacher = 0;

			$x += $col_width_data[15];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[16],($col_height),number_format($sumtotalmdteacher,0),1,0,'C'); // ��� �18 ��� 
			$sumtotalmdteacher =0;

			$x += $col_width_data[16];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[17],($col_height),"",1,0,'C'); // ��� �� ��. 

			$x += $col_width_data[17];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[18],($col_height),"",1,0,'C'); // ��� �� ��� 

			$x += $col_width_data[18];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[19],($col_height),"",1,0,'C'); // ��� �� ��� 

			$x += $col_width_data[19];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[20],($col_height),"",1,0,'C'); // ��� �Ҵ �Թ ��.  

			$x += $col_width_data[20];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[21],($col_height),"",1,0,'C'); // ��� �Ҵ �Թ ��� 

			$x += $col_width_data[21];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[22],($col_height),"",1,0,'C'); // ��� �Ҵ �Թ ���  

			$x += $col_width_data[22];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[23],($col_height),"",1,0,'C'); // ��� �Ҵ �Թ ������ 

			$x += $col_width_data[23];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[24],($col_height),"",1,0,'C'); // ��ѡ�ҹ�Ҫ��� 

			$x += $col_width_data[24];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[25],($col_height),"",1,0,'C'); // �ѵ�Ҩ�ҧ 

			$x += $col_width_data[25];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[26],($col_height),number_format($sum_outside,0),1,0,'C'); // 仪����Ҫ���  
			$sum_outside = 0;

			$x += $col_width_data[26];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[27],($col_height),number_format($sum_inside,0),1,0,'C'); // �Ҫ����Ҫ���  
			$sum_inside = 0;

} // ����÷Ѵ���   

// ��¹��������  
				$ampid=$rs[ampid];
				$sql = "select ampname from area_ampur where ampid = '$rs[ampid]' ;";
				$result2 = mysql_query($sql);
				$rs2=mysql_fetch_array($result2);
				$ampname=$rs2[0];
				if ($ampid == 1){
				$ampname 	= "�ӹѡ�ҹ������ �ӹѡ�ҹࢵ��鹷�����֡����§����";
				}
			$x = $pdf->lMargin;
			$y +=  $col_height;
			$pdf->SetFont('Angsana New','',12);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_head[0],$col_height," $ampname",1,0,'L');

			}

// �Ҥ��  

			$sql = "select sum(pre3year_room+preschool1room+preschool2room+preschool3room) from report_quantitywork where schoolid = '$rs[id]' ;";
			$result2 = mysql_query($sql);
			$rs2=mysql_fetch_array($result2);
			$num_preroom = $rs2[0]; // �ӹǹ��ͧ���¹��͹��ж�  
			$sum_preroom = $sum_preroom+$num_preroom;

			$sql = "select sum(pre3year_m+pre3year_f+preschool1m+preschool1f+preschool2m+preschool2f+preschool3m+preschool3f) from report_quantitywork where schoolid = '$rs[id]' ;";
			$result2 = mysql_query($sql);
			$rs2=mysql_fetch_array($result2);
			$num_prestudent = $rs2[0]; // �ӹǹ�ѡ���¹��͹��ж�  
			$sum_prestudent = $sum_prestudent+$num_prestudent;

			$sql = "select sum(grade1room+grade2room+grade3room+grade4room+grade5room+grade6room) from report_quantitywork where schoolid = '$rs[id]' ;";
			$result2 = mysql_query($sql);
			$rs2=mysql_fetch_array($result2);
			$num_grade6room = $rs2[0]; // �ӹǹ��ͧ���¹��ж�  
			$sum_grade6room = $sum_grade6room+$num_grade6room;

			$sql = "select sum(grade1m+grade1f+grade2m+grade2f+grade3m+grade3f+grade4m+grade4f+grade5m+grade5f+grade6m+grade6f) from report_quantitywork where schoolid = '$rs[id]' ;";
			$result2 = mysql_query($sql);
			$rs2=mysql_fetch_array($result2);
			$num_grade6student = $rs2[0]; // �ӹǹ�ѡ���¹��ж�  
			$sum_grade6student = $sum_grade6student+$num_grade6student;

			$sql = "select sum(grade7room+grade8room+grade9room) from report_quantitywork where schoolid = '$rs[id]' ;";
			$result2 = mysql_query($sql);
			$rs2=mysql_fetch_array($result2);
			$num_grade9room = $rs2[0]; // �ӹǹ��ͧ���¹�Ѹ����   
			$sum_grade9room = $sum_grade9room+$num_grade9room;

			$sql = "select sum(grade7m+grade7f+grade8m+grade8f+grade9m+grade9f) from report_quantitywork where schoolid = '$rs[id]' ;";
			$result2 = mysql_query($sql);
			$rs2=mysql_fetch_array($result2);
			$num_grade9student = $rs2[0]; // �ӹǹ�ѡ���¹�Ѹ����    
			$sum_grade9student = $sum_grade9student+$num_grade9student;

			$sql = "select sum(grade10room+grade11room+grade12room) from report_quantitywork where schoolid = '$rs[id]' ;";
			$result2 = mysql_query($sql);
			$rs2=mysql_fetch_array($result2);
			$num_grade12room = $rs2[0]; // �ӹǹ��ͧ���¹�Ѹ������   
			$sum_grade12room = $sum_grade12room+$num_grade12room;

			$sql = "select sum(grade10m+grade10f+grade11m+grade11f+grade12m+grade12f) from report_quantitywork where schoolid = '$rs[id]' ;";
			$result2 = mysql_query($sql);
			$rs2=mysql_fetch_array($result2);
			$num_grade12student = $rs2[0]; // �ӹǹ�ѡ���¹�Ѹ����    
			$sum_grade12student = $sum_grade12student+$num_grade12student;

			$totalroom1 = $num_grade6room+$num_grade9room+$num_grade12room; // �����ͧ��ж�����Ѹ�� 
			$sum_totalroom1 = $sum_totalroom1+$totalroom1;
			$totalstudent1 = $num_grade6student+$num_grade9student+$num_grade12student; // ����ѡ���¹��ж�����Ѹ��  
			$sum_totalstudent1 = $sum_totalstudent1+$totalstudent1;
			$totalroom2 = $num_preroom+$num_grade6room+$num_grade9room+$num_grade12room; // �����ͧ������  
			$sum_totalroom2 = $sum_totalroom2+$totalroom2;
			$totalstudent2 = $num_prestudent+$num_grade6student+$num_grade9student+$num_grade12student; // ����ѡ���¹��ж�����Ѹ��  
			$sum_totalstudent2 = $sum_totalstudent2+$totalstudent2;

			$sql = "select count(positiongroup) from general where positiongroup = '3' and unit = '$rs[id]' ;";
			$result2 = mysql_query($sql);
			$rs2=mysql_fetch_array($result2);
			$num_md = $rs2[0]; // �������� �.18 
			$sum_md = $sum_md+$num_md;

			$sql = "select count(positiongroup) from general where positiongroup = '4' and unit = '$rs[id]' ;";
			$result3 = mysql_query($sql);
			$rs3=mysql_fetch_array($result3);
			$num_teacher = $rs3[0]; // ��� �.18  
			$sum_teacher = $sum_teacher+$num_teacher;

			$totalmdteacher = $num_md + $num_teacher; // ��� �������� �.18 + ��� �.18 
			$sumtotalmdteacher = $sumtotalmdteacher+$totalmdteacher;

			$sql = "select count(id) from general where outside = '1' and unit = '$rs[id]' ;";
			$result4 = mysql_query($sql);
			$rs4=mysql_fetch_array($result4);
			$num_outside = $rs4[0]; // 仪����Ҫ���  
			$sum_outside = $sum_outside+$num_outside;

			$sql = "select count(id) from general where inside = '1' and unit = '$rs[id]' ;";
			$result5 = mysql_query($sql);
			$rs5=mysql_fetch_array($result5);
			$num_inside = $rs5[0]; // �Ҫ����Ҫ���  
			$sum_inside = $sum_inside+$num_inside;

// ��¹������

			$no++;
			$x = $pdf->lMargin;
			$col_height = 5;
			$y +=  $col_height;
	
			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[0],$col_height,$no,1,0,'C'); // ���  

			$x += $col_width_data[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[1],$col_height,$rs[office],1,0,'L'); // ����ʶҹ�֡�� 

			$x += $col_width_data[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[2],($col_height),"$num_preroom",1,0,'C'); // ��͹��ж� ��ͧ 

			$x += $col_width_data[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[3],($col_height),"$num_prestudent",1,0,'C'); // ��͹��ж� ��.  

			$x += $col_width_data[3];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[4],($col_height),"$num_grade6room",1,0,'C'); // ��ж� ��ͧ 

			$x += $col_width_data[4];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[5],($col_height),"$num_grade6student",1,0,'C'); // ��ж� ��.  

			$x += $col_width_data[5];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[6],($col_height),"$num_grade9room",1,0,'C'); // �Ѹ���� ��ͧ 

			$x += $col_width_data[6];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[7],($col_height),"$num_grade9student",1,0,'C'); // �Ѹ���� ��. 

			$x += $col_width_data[7];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[8],($col_height),"$num_grade12room",1,0,'C'); // �Ѹ������ ��ͧ 

			$x += $col_width_data[8];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[9],($col_height),"$num_grade12student",1,0,'C'); // �Ѹ������ ��. 

			$x += $col_width_data[9];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[10],($col_height),"$totalroom1",1,0,'C'); // �����ж�����Ѹ�� ��ͧ 

			$x += $col_width_data[10];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[11],($col_height),"$totalstudent1",1,0,'C'); // �����ж�����Ѹ�� ��. 

			$x += $col_width_data[11];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[12],($col_height),"$totalroom2",1,0,'C'); // ��������� ��ͧ 

			$x += $col_width_data[12];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[13],($col_height),"$totalstudent2",1,0,'C'); // ��������� ��. 

			$x += $col_width_data[13];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[14],($col_height),"$num_md",1,0,'C'); // ��� �18 ��. 

			$x += $col_width_data[14];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[15],($col_height),"$num_teacher",1,0,'C'); // ��� �18 ���

			$x += $col_width_data[15];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[16],($col_height),"$totalmdteacher",1,0,'C'); // ��� �18 ��� 

			$x += $col_width_data[16];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[17],($col_height),"",1,0,'C'); // ��� �� ��. 

			$x += $col_width_data[17];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[18],($col_height),"",1,0,'C'); // ��� �� ��� 

			$x += $col_width_data[18];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[19],($col_height),"",1,0,'C'); // ��� �� ��� 

			$x += $col_width_data[19];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[20],($col_height),"",1,0,'C'); // ��� �Ҵ �Թ ��.  

			$x += $col_width_data[20];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[21],($col_height),"",1,0,'C'); // ��� �Ҵ �Թ ��� 

			$x += $col_width_data[21];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[22],($col_height),"",1,0,'C'); // ��� �Ҵ �Թ ���  

			$x += $col_width_data[22];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[23],($col_height),"",1,0,'C'); // ��� �Ҵ �Թ ������ 

			$x += $col_width_data[23];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[24],($col_height),"",1,0,'C'); // ��ѡ�ҹ�Ҫ��� 

			$x += $col_width_data[24];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[25],($col_height),"",1,0,'C'); // �ѵ�Ҩ�ҧ 

			$x += $col_width_data[25];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[26],($col_height),"$num_outside",1,0,'C'); // 仪����Ҫ��� 

			$x += $col_width_data[26];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width_data[27],($col_height),"$num_inside",1,0,'C'); // �Ҫ����Ҫ��� 

			if (($y) > 175) {$pdf->AddPage('L');$pdf->sptheader();$y=45;} // add new page      

		} // end while

$pdf->Output(spt_power_pdf.".pdf",'D');
?>