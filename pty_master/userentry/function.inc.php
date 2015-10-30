<?

function checkID($id) {
	if(strlen($id) != 13) return false;
	for($i=0, $sum=0; $i<12;$i++)
	$sum += (int)($id{$i})*(13-$i);
	if((11-($sum%11))%10 == (int)($id{12}))
	return true;
	return false;
}


function  chdata($idcard,$dbsite,$showmsg=false){
	GLOBAL $dbsite,$action;
// -----------------  ข้อมูลทั่วไป ----------------------------
// ====  ชื่อ นามสกุล ==========================
	$sql = " SELECT  *  FROM  general WHERE  idcard = '$idcard' ";
	$result = mysql_db_query($dbsite,$sql);
	$rs = mysql_fetch_assoc($result);


	if($rs[name_th] != "" AND $rs[surname_th] != ""){
		$sql1 = " SELECT  *  FROM  hr_addhistoryname WHERE  gen_id = '$idcard' ";
		$result1 = mysql_db_query($dbsite,$sql1);
		while($rs1 = mysql_fetch_assoc($result1)){
			if($rs[name_th] != "" AND $rs[surname_th] != "" AND $rs1[kp7_active] == 1 ){
				$G[0] = true;
				$msg[0] = "";
				break;
			}else{
				$G[0] = false;
				$msg[0] = "[Error Code : G001] ข้อมูลชื่อ นามสกุล ไม่ถูกต้อง ไม่พบข้อมูลใน ตารางประวัติการเปลี่ยนชื่อ ผลกระทบคือ จะทำให้ชื่อไม่แสดงผลใน กพ.7";
			}
		}
	}else{
				$G[0] = false;
				$msg[0] = "[Error Code : G001] ข้อมูลชื่อ นามสกุล  ไม่พบข้อมูลใน ตารางข้อมูลทั่วไป ผลกระทบคือ จะทำให้ชื่อหรือนามสกุลไม่แสดงผลใน กพ.7";
	}


//==============================

$dy=explode("-",$rs[begindate]);

// ====  รหัสบัตรบัตรประชาชน  ==========================
	if(!checkID($idcard)){
		$G[1] = false;
		$msg[1] = "[Error Code : G002] ข้อมูลรหัสบัตรประชาชนไม่ถูกต้อง ไม่ตรงรูปแบบของกรมการปกครอง  ";
	}
	
// =========== วัน เดือน ปีเกิด ====================
	if($rs[birthday] == ""){
		$G[2] = false;
		$msg[2] = "[Error Code : G003] ข้อมูลวัน เดือน ปีเกิด เป็นช่องว่าง   ";
	}else{
		$bday1 = explode("-",$rs[birthday]) ;
		$bday1[0] = $bday1[0] ;
		$sql2 = " SELECT '".$bday1[0]."-".$bday1[1]."-".$bday1[2]."' <  '$rs[begindate]' ";
		//echo "$sql2";
		$result2 = @mysql_db_query($dbsite,$sql2);
		$rs2 = @mysql_fetch_array($result2);
		if($rs2[0]==0){
			$G[2] = false;
			$msg[2] = "[Error Code : G003] ข้อมูลวัน เดือน ปีเกิด ค่าที่ไม่สอดคล้องกับวันเริ่มปฏิบัติราชการ   ";
		}else{
			$G[2] = true;
			$msg[2] = " ";
		}
	}

//============================================
// คำนำหน้า
	$flag1 = true ;

	if($rs[prename_th]=="" OR $rs[prename_th]== null){
		$flag1 = false ;
		$msg[3] = "<br> - ไม่ระบุคำนำหน้า";
	}
	// ชื่อ
	if($rs[name_th]=="" OR $rs[name_th]== null){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุชื่อ";
	}
	// นามสกุล
	if($rs[surname_th]=="" OR $rs[surname_th]== null){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุนามสกุล";
	}
	// เพศ
	if($rs[sex]=="" OR $rs[sex]== null){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุเพศ";
	}
	// ตำแหน่งเริ่ม
	if($rs[position]=="" OR $rs[position]== null){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุตำแหน่งเริ่มรับราชการ";
	}
	// ระดับเริ่มรับราชการ
	if($rs[radub_past]=="" OR $rs[radub_past]== null){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุระดับเริ่มรับราชการ";
	}
	// ตำแหน่งปัจจุับัน
	if($rs[position_now]=="" OR $rs[position_now]== null){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุตำแหน่งปัจจุับัน";
	}
	// ระดับปัจจุับัน
	if($rs[radub]=="" OR $rs[radub]== null){
		$flag1 = false ;
		$msg[3] .= "<br> - ไม่ระบุระดับปัจจุับัน";
	}

	if(!$flag1){
			$G[3] = false;
			$msg[3] = "[Error Code : G004] ".$msg[3];
	}

//=========รูป============================

$sql3 = " SELECT *  FROM general_pic WHERE id = '$idcard'  ORDER BY   kp7_active  ASC  " ;
if($result3 = mysql_db_query($dbsite,$sql3)){
	while($rs3 = mysql_fetch_assoc($result3)){
		if($rs[kp7_active] == "0"){
			$G[4] = false;
			$msg[4] = "[Error Code : G005]  ไม่ได้ตั้งค่าแสดงผลในกพ.7 ";
		}else{
			$G[4] = true;
			$msg[4] = "";
		}
	}
}else{
	$G[4] = false;
	$msg[4] = "[Error Code : G005]  ไม่มีข้อมูลรูปในระบบ ";
}

// ==============ประวัติการศึกษา========================
$sql4 = " SELECT id   FROM graduate  WHERE id = '$idcard' " ;
$result4 = mysql_db_query($dbsite,$sql4);

if(!$result4){
	$G[5] = false;
	$msg[5] = "[Error Code : G006]  ไม่มีข้อมูลประวัติการศึกษา ";
}

//===========การลาหยุด=====================
$msgshow11 = "";
$sqlabsent="SELECT Count(hr_absent.yy)as ABDAY FROM hr_absent WHERE hr_absent.id =  '$idcard' AND `yy` BETWEEN '$dy[0]' AND '2549' ";
$resultabsent =  mysql_db_query($dbsite,$sqlabsent) ;
$rsab=mysql_fetch_assoc($resultabsent);
$sumab=$rsab[ABDAY];
if($sumwork !=$sumab)
{
	for($i=$dy[0];$i<=2549;$i++)//หาปีที่กรอกข้อมูลไม่ครบ
	{
	$arr1[]=$i;
	}
	
	$sqlfindyy="SELECT yy from  hr_absent where id='$idcard' AND `yy` BETWEEN '$dy[0]' AND '2549' order by yy ASC";
	$queryfindyy = mysql_db_query($dbsite,$sqlfindyy) ;
	while($XX=mysql_fetch_assoc($queryfindyy))
	{
		$arr2[]=$XX[yy];
	}
for($i = 0; $i < sizeof($arr1); $i++){

for($j = 0; $j < sizeof($arr2); $j++)
	{ 
			if($arr1[$i] != $arr2[$j]){ 
			$isSame = false;
			}else{
			$isSame = true;
			break;
			} 
	}//for($j = 0; $j < sizeof($arr2); $j++)
	
	if($isSame == false){
		$msgshow11 .= "<br> -  ปี พ.ศ. $arr1[$i]  ";
		}
	}//for($i = 0; $i < sizeof($arr1); $i++){
}
if($msgshow11){
	$G[6] = false;
	$msg[6] = "[Error Code : G007]  ข้อมูลวันลาหยุดไม่สมบูรณ์ ขาด ".$msgshow11;
}
//======================================
$msgshow12 = "";

$sqlsa="SELECT count(runid) AS suma FROM `salary` WHERE `id` LIKE '%$idcard%' AND `date` BETWEEN '2544' AND '2550' ";
$resultsa = mysql_db_query($dbsite,$sqlsa) ;
$rssa=mysql_fetch_assoc($resultsa);
if($rssa[suma]<14 and $dy[0] < 2544){
	$msgshow12 .= "<br> - ในช่วงปี พ.ศ. 2544 - พ.ศ. 2549  กรอกข้อมูลเงินเดือนไม่ครบ";	
}

if($msgshow12){
	$G[7] = false;
	$msg[7] = "[Error Code : G008]  ข้อมูลเงินเดือนไม่สมบูรณ์ ขาด ".$msgshow12;
}

///----------------  ไฟล์ต้นฉบับ -----------------------------------
$ch_file = $_SERVER['DOCUMENT_ROOT']."/edubkk_kp7file/$idcard.pdf" ;
if(!is_file($ch_file)){
	$G[8] = false;
	$msg[8] = "[Error Code : G009]  ไม่มีเอกสาร กพ.7 ต้นฉบับ ";
}

if($action == "getdata" && $idcard != ""){

$sqlx = " INSERT INTO  tempcheckdata(idcard) VALUES ('$idcard') " ;
mysql_db_query($dbsite,$sqlx);

}


$flagerror = false;
	foreach($G AS $key => $val){
		if(!$val){
			if($showmsg){
				echo "$msg[$key] <br>";
			}
			if($action == "getdata" && $idcard != ""){
				$sqlxa = " UPDATE   tempcheckdata  SET  G00".$key." = '1'  WHERE  idcard = '$idcard' " ;
				//echo "$sqlxa <br>";
				mysql_db_query($dbsite,$sqlxa);
			}
			$flagerror = true ;
		}
	}
	if(!$flagerror){
		if($showmsg){
		echo "<h1>ตรวจสอบข้อมูลแล้ว ไม่พบส่วนที่มีความผิดพลาด</h1>";
		}
	}


return $flagerror;

}// function

?>