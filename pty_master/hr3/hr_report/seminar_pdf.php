<?php
//include ("session.inc.php");
//ob_start();
//session_start();
define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/fpdf.php');
require('../../../common/master_class.php');
include ("libary/config.inc.php");

$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");

$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$monthsname = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");

$pdf=new master();
$pdf->AliasNbPages();
$pdf->AddThaiFonts();
$pdf->AddPage(); // �����˹�Ң������Ӥѭ�����

  $runid=$_REQUEST['runnid'];
 $sql = "select t1.*,t2.*,t3.th_name from seminar_form t1 left join general t2 on t1.id = t2.id left join office_detail t3 on t2.unit = t3.id  where t1.id='$id' and t1.runid = '$runid'  ;";
		
		$result = mysql_query($sql);
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);

		$date_on = explode("-",$rs[ondate]); // ŧ�ѹ���
		$date_s = explode("-",$rs[startdate]); // �����ҧ�ѹ���
		$date_e = explode("-",$rs[enddate]); // �֧�ѹ���

$pdf->SetFont('Angsana New','U',16);
$pdf->SetXY(71,10);
$pdf->Cell(71,10,'��§ҹ������������Ъ��������/�Ѵ�Ԩ����',0,0,'C');
$pdf->SetXY(71,15);
$pdf->Cell(71,15,"�ç���¹ $rs[th_name]",0,0,'C');

$pdf->SetFont('Angsana New','',14);
$pdf->SetXY(15,25);
$pdf->Cell(15,25,"���¹  ����ӹ�¡���ç���¹ $rs[th_name]",0,0,'L');
$pdf->SetXY(15,30);
$pdf->Cell(15,30,"����ͧ  �����§ҹ�š��任�Ъ��������/�Ѵ�Ԩ����",0,0,'L');
$pdf->SetXY(15,35);
$pdf->Cell(15,35,"��觷�����Ҵ���     1. $rs[title1]",0,0,'L');
$pdf->SetXY(15,40);
$pdf->Cell(15,40,"                            2. $rs[title2]",0,0,'L');
$pdf->SetXY(15,45);
$pdf->Cell(15,45,"          �������觷��   $rs[orderno]   ŧ�ѹ��� ".intval($date_on[2])."  ��͹ ".$monthname[intval($date_on[1])]."  �.�. ".$date_on[0].''."    ���ͺ��������Ҿ��� $rs[prename_th] $rs[name_th]  $rs[surname_th]",0,0,'L');
$pdf->SetXY(15,50);
$pdf->Cell(15,50,"任�Ъ��������/�Ԩ��������ͧ  $rs[subject]",0,0,'L');
$pdf->SetXY(15,55);
$pdf->Cell(15,55,"�����ҧ�ѹ��� ".intval($date_s[2])."  ��͹ ".$monthname[intval($date_s[1])]."  �.�. ".$date_s[0].''." �֧ ".intval($date_e[2])."  ��͹ ".$monthname[intval($date_e[1])]."  �.�. ".$date_e[0].'',0,0,'L');
$pdf->SetXY(15,60);
$pdf->Cell(15,60,"� $rs[place]",0,0,'L');

$pdf->SetFont('Angsana New','U',16);
$pdf->SetXY(71,65);
$pdf->Cell(71,65,'��Ҿ��Ң���§ҹ�š��任�Ժѵ��Ҫ��ôѧ���',0,0,'C');

$pdf->SetFont('Angsana New','B',14);
$pdf->SetXY(15,70);
$pdf->Cell(15,70,'1  ������� ���� ���ʺ��ó� �����ҡ���ͺ��������',0,0,'L');
			
$pdf->SetFont('Angsana New','',12);

			$col_width = array(180); // ��˹��������ҧ column
			$col_height = 7;
			$x = 20;
			$y = 110;
			$pdf->SetXY($x,$y); // ��÷Ѵ ������� ���� ���ʺ��ó� �����ҡ���ͺ��������

			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($rs[note1],140);
			$num_arr1 = count($arr_str1);
			
			if($num_arr1 == 1){ // �պ�÷Ѵ����
			
			$pdf->SetXY($x,$y);
			$pdf->Cell($col_width[0],$col_height,"$rs[note1]",0,0,'L');

			$y +=  $col_height;

			}else{ // �����º�÷Ѵ
				for ($n=0;$n<$num_arr1;$n++) {
					if($n==0){ // ��¹��÷Ѵ�á

						$pdf->SetFont('Angsana New','',12);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],($col_height*$num_arr1),"",0,0,'L');

					} // end if ��¹��÷Ѵ����ͧ
					if($n<$num_arr1 && $n != 0 ){$y += $col_height;}
			
					$x = $pdf->lMargin;

					$pdf->SetFont('Angsana New','',12);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],$col_height,"$arr_str1[$n]",0,0,'L');
					
					if($n==($num_arr1-1)){$y += $col_height;}
				} // end for
			} // end if else

$x = 15;
$y = $y;
$pdf->SetXY($x,$y);

			$col_width = array(180);
			$col_height = 7;

			$pdf->SetFont('Angsana New','B',14);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"2  ��ùӤ����������û�Ժѵ� ��ѧ���",0,0,'L');

$pdf->SetFont('Angsana New','',12);

			$x = $pdf->lMargin;
			$y = $y+($col_height);

			$pdf->SetXY($x,$y); // ��ùӤ����������û�Ժѵ� ��ѧ���

			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($rs[note2],140);
			$num_arr1 = count($arr_str1);
			
			if($num_arr1 == 1){ // �պ�÷Ѵ����
			
			$pdf->SetXY($x,$y);
			$pdf->Cell($col_width[0],$col_height,"$rs[note2]",0,0,'L');

			$y +=  $col_height;

			}else{ // �����º�÷Ѵ
				for ($n=0;$n<$num_arr1;$n++) {
					if($n==0){ // ��¹��÷Ѵ�á

						$pdf->SetFont('Angsana New','',12);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],($col_height*$num_arr1),"",0,0,'L');

					} // end if ��¹��÷Ѵ����ͧ
					if($n<$num_arr1 && $n != 0 ){$y += $col_height;}
			
					$x = $pdf->lMargin;

					$pdf->SetFont('Angsana New','',12);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],$col_height,"$arr_str1[$n]",0,0,'L');
					
					if($n==($num_arr1-1)){$y += $col_height;}
				} // end for
			} // end if else

$x = 15;
$y = $y;
$pdf->SetXY($x,$y);
		
		$arr_strx1 = array(); 
		$resultx1 = mysql_query("select t1.*,t2.*,t3.th_name from seminar_form t1 left join general t2 on t1.id = t2.id left join office_detail t3 on t2.unit = t3.id  where t1.id='$id' and t1.runid = '$runid'  ;");				
		while($rsx1=mysql_fetch_array($resultx1)){
			$arr_strx1 = $pdf->alignstr($rsx1[note3],140);
			$num_arrx1 += count($arr_strx1);
		}
		if ((14+($num_arrx1*7)+$y+50) > 265) {$pdf->AddPage();$y=30;}

			$col_width = array(180);
			$col_height = 7;

			$pdf->SetFont('Angsana New','B',14);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"3  ��觷���ͧ�������ç���¹�����ʹѺʹع",0,0,'L');

$pdf->SetFont('Angsana New','',12);

			$x = $pdf->lMargin;
			$y = $y+($col_height);

			$pdf->SetXY($x,$y); // ��ùӤ����������û�Ժѵ� ��ѧ���

			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($rs[note3],140);
			$num_arr1 = count($arr_str1);
			
			if($num_arr1 == 1){ // �պ�÷Ѵ����
			
			$pdf->SetXY($x,$y);
			$pdf->Cell($col_width[0],$col_height,"$rs[note3]",0,0,'L');

			$y +=  $col_height;

			}else{ // �����º�÷Ѵ
				for ($n=0;$n<$num_arr1;$n++) {
					if($n==0){ // ��¹��÷Ѵ�á

						$pdf->SetFont('Angsana New','',12);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],($col_height*$num_arr1),"",0,0,'L');

					} // end if ��¹��÷Ѵ����ͧ
					if($n<$num_arr1 && $n != 0 ){$y += $col_height;}
			
					$x = $pdf->lMargin;

					$pdf->SetFont('Angsana New','',12);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],$col_height,"$arr_str1[$n]",0,0,'L');
					
					if($n==($num_arr1-1)){$y += $col_height;}
				} // end for
			} // end if else


//$pdf->SetXY(10,200); // �������ǹ����

			$row1_x = $pdf->lMargin; // �����������
			$row1_y = $pdf->GetY(); // �Ѻ��Һ�÷Ѵ
			$x = $row1_x+10;
			$y = $row1_y+15;

$pdf->SetXY($x,$y); // ��÷Ѵ�����

			$col_width = array(150); // �������ҧ column ����,���
			$col_height = 10;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height/2),"(ŧ����)________________________________________________                              	(ŧ����)________________________________________________",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"",0,0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height/2),"      (_______________________________________________)                                   (_______________________________________________)",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"",0,0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height+5),"�������Ѻ��û�Ъ��������/�Ѵ�Ԩ����                                                                                       ���˹�ҡ��������",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"",0,0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height+20),"(ŧ����)________________________________________________                              	(ŧ����)________________________________________________",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"",0,0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height+30),"      (_______________________________________________)                                   (_______________________________________________)",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"",0,0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height+40),"                 ���§ҹ�Ԫҡ��                                                                                                            ����ӹ�¡���ç���¹",0,0,'C');

$pdf->Output(seminar.".pdf",'D');
?>