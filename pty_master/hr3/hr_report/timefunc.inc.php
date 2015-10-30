<?

/*
//example
$d1 = "2520-12-25";   //�ѹ����ͧ�����
$diff  = dateLength($d1);
echo "����� $d1 �֧�Ѩ�غѹ ���������� $diff[year] �� $diff[month] ��͹ $diff[day] �ѹ<BR>";
*/

//���������Ҩҡ�ѹ�������� (�.�.)
function dateLength($thaidate){
	// �ŧ�繻� ��.
	$dx1 = explode("-",$thaidate);
	$dx1[0] = intval($dx1[0]) - 543;
	$d1 = $dx1[0] . "-" . $dx1[1] . "-" . $dx1[2];

	//�ѹ���Ѩ�غѹ
	$d2 = date("Y-m-d");

	$diff =  dateDiff($d1,$d2);
	return $diff;
}

function dateLength1($thaidate,$thaidate2){
	// �ŧ�繻� ��.
	$dx1 = explode("-",$thaidate);
	$dx1[0] = intval($dx1[0]) - 543;
	$d1 = $dx1[0] . "-" . $dx1[1] . "-" . $dx1[2];

	//�ѹ���Ѩ�غѹ
	$dx2 = explode("-",$thaidate2);
	$dx2[0] = intval($dx2[0]) - 543;
	$d2 = $dx2[0] . "-" . $dx2[1] . "-" . $dx2[2];
	//$d2 = date("Y-m-d");

	$diff1 =  dateDiff($d1,$d2);
	return $diff1;
}

//���繻� ��. �� ���ѹ�á��ͧ���¡����ѹ����ͧ
function dateDiff($d1,$d2) {
$mday = array(0,31,28,31,30,31,30,31,31,30,31,30,31);

	$x1 = explode("-",$d1);
	$x2 = explode("-",$d2);

	// �ӹǹ��
	$ny = intval($x2[0]) - intval($x1[0]);

	if (intval($x1[1]) <= intval($x2[1])){  //��͹ ��ǵ���ҡ����
		$nm = intval($x2[1]) - intval($x1[1]);
	}else{
		$nm = intval($x2[1]) + 12 - intval($x1[1]);
		$ny --; // Ŵ��ŧ
	}

	if (intval($x1[2]) <= intval($x2[2])){  //�ѹ ��ǵ���ҡ����
		$nd = intval($x2[2]) - intval($x1[2]);
	}else{
		$mday[2] = date("d",mktime (0,0,0,3,0,intval($x2[0]) ));  // �Ҩӹǹ�ѹ�ͧ��͹����Ҿѹ��
		$xmonth = intval($x2[1]) - 1;  //��͹��͹���
		if ($xmonth <= 0){
			$xday = 31; 
		}else{
			$xday = $mday[$xmonth];
		}

		$nd = intval($x2[2]) + $xday - intval($x1[2]);
		$nm --; // Ŵ��͹

		if ($nm < 0){ // ��͹�á (Ŵ��������� 0)
			$nm = 11;
			$ny--;
		}
	}

	$ret = array("day" => $nd,"month" => $nm, "year" => $ny);
	return $ret;
} 
//�ŧ�ѹ �繨ӹǹ�� ��͹ �ѹ
function sumday($dxx1,$dxx2)
{
//echo $dx1;
	$dx1=explode("-",$dxx1);
	$dx2=explode("-",$dxx2);
	$m1=$dx1[1];
	$m2=$dx2[1];
	$y1=intval($dx1[0]);
	$y2=intval($dx2[0]);
	
//�ӹǹ�ѹ 
		if($dx1[2]>=$dx2[2])
			{
			$ddxd=$dx1[2]-$dx2[2];
			}
		else//�ѹ��� �ҡ����
			{
			$ddxd=($dx1[2]+30)-$dx2[2];
			$m1--;		
			}
//�ӹǹ�ӹǹ��͹
			if($m2<=$m1)
			{
			$mmm=$m1-$m2;
			}
			else
			{
			$mmm=($m1+12)-$m2;
			$y1--;
			}
	//	�ӹǹ��
		$YYY=$y1-$y2;
		 
$resutld ="$YYY-$mmm-$ddxd";
return  $resutld;

}

?>