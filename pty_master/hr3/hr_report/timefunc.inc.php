<?

/*
//example
$d1 = "2520-12-25";   //วันที่ต้องการหา
$diff  = dateLength($d1);
echo "ตั้งแต่ $d1 ถึงปัจจุบัน เป็นระยะเวลา $diff[year] ปี $diff[month] เดือน $diff[day] วัน<BR>";
*/

//หาระยะเวลาจากวันที่ให้มา (พ.ศ.)
function dateLength($thaidate){
	// แปลงเป็นปี คศ.
	$dx1 = explode("-",$thaidate);
	$dx1[0] = intval($dx1[0]) - 543;
	$d1 = $dx1[0] . "-" . $dx1[1] . "-" . $dx1[2];

	//วันที่ปัจจุบัน
	$d2 = date("Y-m-d");

	$diff =  dateDiff($d1,$d2);
	return $diff;
}

function dateLength1($thaidate,$thaidate2){
	// แปลงเป็นปี คศ.
	$dx1 = explode("-",$thaidate);
	$dx1[0] = intval($dx1[0]) - 543;
	$d1 = $dx1[0] . "-" . $dx1[1] . "-" . $dx1[2];

	//วันที่ปัจจุบัน
	$dx2 = explode("-",$thaidate2);
	$dx2[0] = intval($dx2[0]) - 543;
	$d2 = $dx2[0] . "-" . $dx2[1] . "-" . $dx2[2];
	//$d2 = date("Y-m-d");

	$diff1 =  dateDiff($d1,$d2);
	return $diff1;
}

//ส่งเป็นปี คศ. มา โดยอันแรกต้องน้อยกว่าอันที่สอง
function dateDiff($d1,$d2) {
$mday = array(0,31,28,31,30,31,30,31,31,30,31,30,31);

	$x1 = explode("-",$d1);
	$x2 = explode("-",$d2);

	// จำนวนปี
	$ny = intval($x2[0]) - intval($x1[0]);

	if (intval($x1[1]) <= intval($x2[1])){  //เดือน ตัวตั้งมากกว่า
		$nm = intval($x2[1]) - intval($x1[1]);
	}else{
		$nm = intval($x2[1]) + 12 - intval($x1[1]);
		$ny --; // ลดปีลง
	}

	if (intval($x1[2]) <= intval($x2[2])){  //วัน ตัวตั้งมากกว่า
		$nd = intval($x2[2]) - intval($x1[2]);
	}else{
		$mday[2] = date("d",mktime (0,0,0,3,0,intval($x2[0]) ));  // หาจำนวนวันของเดือนกุมภาพันธ์
		$xmonth = intval($x2[1]) - 1;  //เดือนก่อนนี้
		if ($xmonth <= 0){
			$xday = 31; 
		}else{
			$xday = $mday[$xmonth];
		}

		$nd = intval($x2[2]) + $xday - intval($x1[2]);
		$nm --; // ลดเดือน

		if ($nm < 0){ // เดือนแรก (ลดแล้วเหลือ 0)
			$nm = 11;
			$ny--;
		}
	}

	$ret = array("day" => $nd,"month" => $nm, "year" => $ny);
	return $ret;
} 
//แปลงวัน เป็นจำนวนปี เดือน วัน
function sumday($dxx1,$dxx2)
{
//echo $dx1;
	$dx1=explode("-",$dxx1);
	$dx2=explode("-",$dxx2);
	$m1=$dx1[1];
	$m2=$dx2[1];
	$y1=intval($dx1[0]);
	$y2=intval($dx2[0]);
	
//คำนวนวัน 
		if($dx1[2]>=$dx2[2])
			{
			$ddxd=$dx1[2]-$dx2[2];
			}
		else//วันที่ มากกว่า
			{
			$ddxd=($dx1[2]+30)-$dx2[2];
			$m1--;		
			}
//คำนวนจำนวนเดือน
			if($m2<=$m1)
			{
			$mmm=$m1-$m2;
			}
			else
			{
			$mmm=($m1+12)-$m2;
			$y1--;
			}
	//	จำนวนปี
		$YYY=$y1-$y2;
		 
$resutld ="$YYY-$mmm-$ddxd";
return  $resutld;

}

?>