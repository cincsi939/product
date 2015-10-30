<?
//ไม่เอาอายุ มาคิดเป็นเงื่อนไข

$minsalary = array(
	"คศ.2"=>"14810",
	"คศ.3"=>"18180",
	"คศ.4"=>"22330",
	"คศ.5"=>"27450"
);

$error_message =array(); //ข้อความแสดงเหตุผลที่ไม่ผ่านเกณฑ์


function GetVitaya($position,$vitaya,$force=false){
global $minsalary;
	$nvitaya = 0 ;

	if (!$force){
		//check วันที่ update ให้ทำวันละครั้ง
		$result = mysql_query("select min(lastupdate) as lastupdate from temp_vitaya where position='$position' and vitaya='$vitaya';");
		$rs = mysql_fetch_assoc($result);
		if ($rs[lastupdate] < date("Y-m-01 00:00:00")){ //ทำเดือนละครั้ง ( ถ้าเลยวัน ก็ให้ทำใหม่ )
			$force = true;
		}
	}

	if (!$force){
		$result = mysql_query("select count(position) as ncount from temp_vitaya where position='$position' and vitaya='$vitaya';");
		$rs = mysql_fetch_assoc($result);
		return $rs[ncount];
	}

	$sql = "delete from temp_vitaya where position = '$position' and vitaya='$vitaya';";
	mysql_query($sql);
	// re-calculate

	//echo "$position/$vitaya<BR>";

	if ($position == "ครู"){
		if ($vitaya == "ชำนาญการ"){
			$sql 		= " select * from general where position_now='ครู' and (vitaya='' or vitaya is null) and salary >= " . $minsalary['คศ.2'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitaya1($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "ชำนาญการพิเศษ"){

			//echo "<BR><BR>ครูชำนาญการ => ครูชำนาญการพิเศษ<BR>";
			$sql 		= " select * from general where position_now='ครู' and (vitaya='ชำนาญการ') and  salary >=" . $minsalary['คศ.3'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitaya2($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "เชี่ยวชาญ"){

			//echo "<BR><BR>ครูชำนาญการพิเศษ => ครูเชี่ยวชาญ<BR>";
			$sql 		= " select * from general where position_now='ครู' and (vitaya='ชำนาญการพิเศษ') and  salary >=" . $minsalary['คศ.4'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitaya3($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "เชี่ยวชาญพิเศษ"){

			//echo "<BR><BR>ครูเชี่ยวชาญ => ครูเชี่ยวชาญพิเศษ<BR>";
			$sql 		= " select * from general where position_now='ครู' and (vitaya='เชี่ยวชาญ') and  salary >=" . $minsalary['คศ.5'] . "and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitaya4($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);

			} //while

		} // if vitaya
//======================================================================================

	} else if ($position == "ศึกษานิเทศก์"){

		if ($vitaya == "ชำนาญการ"){
			$sql 		= " select * from general where position_now='ศึกษานิเทศก์' and (vitaya='') and  salary >=" . $minsalary['คศ.2'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaNites1($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "ชำนาญการพิเศษ"){

			$sql 		= " select * from general where position_now='ศึกษานิเทศก์' and (vitaya='ชำนาญการ') and  salary >=" . $minsalary['คศ.3'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaNites2($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "เชี่ยวชาญ"){

			$sql 		= " select * from general where position_now='ศึกษานิเทศก์' and (vitaya='ชำนาญการ' || vitaya='ชำนาญการพิเศษ') and  salary >=" . $minsalary['คศ.4'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaNites3($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "เชี่ยวชาญพิเศษ"){

			$sql 		= " select * from general where position_now='ศึกษานิเทศก์' and (vitaya='เชี่ยวชาญ') and  salary >=" . $minsalary['คศ.5'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaNites4($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while


		} // if vitaya

//======================================================================================

	} else if ($position == "ผู้อำนวยการโรงเรียน"){

		if ($vitaya == "ชำนาญการ"){
			$sql 		= " select * from general where position_now='ผู้อำนวยการโรงเรียน' and (vitaya='') and  salary >=" . $minsalary['คศ.2'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSchoolMgr1($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "ชำนาญการพิเศษ"){

			$sql 		= " select * from general where position_now='ผู้อำนวยการโรงเรียน' and (vitaya='ชำนาญการ') and  salary >=" . $minsalary['คศ.3'] . "  and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSchoolMgr2($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "เชี่ยวชาญ"){

			$sql 		= " select * from general where position_now='ผู้อำนวยการโรงเรียน' and (vitaya='ชำนาญการ' || vitaya='ชำนาญการพิเศษ') and  salary >=" . $minsalary['คศ.4'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSchoolMgr3($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "เชี่ยวชาญพิเศษ"){

			$sql 		= " select * from general where position_now='ผู้อำนวยการโรงเรียน' and (vitaya='เชี่ยวชาญ') and  salary >=" . $minsalary['คศ.5'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSchoolMgr4($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		} // if vitaya


//======================================================================================

	} else if ($position == "รองผู้อำนวยการโรงเรียน"){

		if ($vitaya == "ชำนาญการ"){
			$sql 		= " select * from general where position_now='รองผู้อำนวยการโรงเรียน' and (vitaya='') and  salary >=" . $minsalary['คศ.2'] . "  and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSchoolViceMgr1($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "ชำนาญการพิเศษ"){

			$sql 		= " select * from general where position_now='รองผู้อำนวยการโรงเรียน' and (vitaya='ชำนาญการ') and  salary >=" . $minsalary['คศ.3'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSchoolViceMgr2($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "เชี่ยวชาญ"){

			$sql 		= " select * from general where position_now='รองผู้อำนวยการโรงเรียน' and (vitaya='ชำนาญการ' || vitaya='ชำนาญการพิเศษ') and  salary >=" . $minsalary['คศ.4'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSchoolViceMgr3($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "เชี่ยวชาญพิเศษ"){

			$sql 		= " select * from general where position_now='รองผู้อำนวยการโรงเรียน' and (vitaya='เชี่ยวชาญ') and  salary >=" . $minsalary['คศ.5'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSchoolViceMgr4($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		} // if vitaya


//======================================================================================

	} else if ($position == "ผู้อำนวยการ สพท."){


		if ($vitaya == "เชี่ยวชาญ"){

			$sql 		= " select * from general where position_now='ผู้อำนวยการ สพท.' and (vitaya='') and  salary >=" . $minsalary['คศ.4'] . "  and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSecMgr1($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "เชี่ยวชาญพิเศษ"){

			$sql 		= " select * from general where position_now='ผู้อำนวยการ สพท.' and (vitaya='เชี่ยวชาญ') and  salary >=" . $minsalary['คศ.5'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSecMgr2($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		} // if vitaya

//======================================================================================

	} else if ($position == "รองผู้อำนวยการ สพท."){


		if ($vitaya == "ชำนาญการพิเศษ"){

			$sql 		= " select * from general where position_now='รองผู้อำนวยการ สพท.' and (vitaya='') and  salary >=" . $minsalary['คศ.3'] . "  and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaViceSecMgr1($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "เชี่ยวชาญ"){

			$sql 		= " select * from general where position_now='รองผู้อำนวยการ สพท.' and (vitaya='ชำนาญการพิเศษ') and  salary >=" . $minsalary['คศ.4'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaViceSecMgr2($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		} // if vitaya



	} // if $position


	return $nvitaya;

}


//================================================================================
// ครู
//================================================================================

function chkVitaya1($userid){
global $minsalary;
global $error_message;  $error_message=array();
	$p1 = $p2 = $p3 = $key1 = false;
	//Condition 1 : ตรวจสอบการศึกษาในระดับปริญญาขึ้นไป	
	
	$sql		= "
		select distinct grade from graduate 
		where (grade like '%ปริญญา%เอก%')  
		and grade not like '%อนุปริญญา%' 
		and grade not like '%ประกาศนีย์บัตร%'
		and grade not like '%ประกาศนียบัตร%'
		and grade not like '%ป.กศ%'
		and grade not like '%ป.กศ.%'
		and grade not like '%ป.ก.ศ.%'
		and grade not like '%ปกศ%'
		and grade not like '%ปก.ศ%'
		and grade not like '%ป.กส%'
		and grade not like '%ปกส%'
		and grade not like '%ปวส%'
		and grade not like '%ปวช%'
		and grade not like '%ปว.ส%'
		and grade not like '%ปว.ช%'
		and grade not like '%ป.วส%'
		and grade not like '%ป.วช%'
		and id='$userid' order by finishyear desc limit 0,1;		
	";	
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$p3	= (mysql_num_rows($result) >= 1) ? true : false ;


	$sql		= "
		select distinct grade from graduate 
		where (grade like '%ปริญญา%โท%' or grade like '%ป%โท%' or grade like '%ปริญญ%มหาบัณ%' or grade like '%ศาสตร์%มหาบัณฑิต%' 	or grade like '%ศ.ษ.ม.%' )  
		and grade not like '%อนุปริญญา%' 
		and grade not like '%ประกาศนีย์บัตร%'
		and grade not like '%ประกาศนียบัตร%'
		and grade not like '%ป.กศ%'
		and grade not like '%ป.กศ.%'
		and grade not like '%ป.ก.ศ.%'
		and grade not like '%ปกศ%'
		and grade not like '%ปก.ศ%'
		and grade not like '%ป.กส%'
		and grade not like '%ปกส%'
		and grade not like '%ปวส%'
		and grade not like '%ปวช%'
		and grade not like '%ปว.ส%'
		and grade not like '%ปว.ช%'
		and grade not like '%ป.วส%'
		and grade not like '%ป.วช%'
		and id='$userid' order by finishyear desc limit 0,1;		
	";	
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$p2	= (mysql_num_rows($result) >= 1) ? true : false ;

	$sql		= "
		select distinct grade from graduate 
		where (grade like '%ปริญญา%ตรี%' or grade like '%ป%ตรี%' or grade like '%ค.บ.%' 
		or grade like '%ศษ.%บ.%' or grade like '%ศาสตร์%บัณฑิต%' or grade like '%บริหารธุรกิจบัณฑิต%'
		or grade like '%ครุศาสตรบัณฑิต%')  
		and grade not like '%อนุปริญญา%' 
		and grade not like '%ประกาศนีย์บัตร%'
		and grade not like '%ประกาศนียบัตร%'
		and grade not like '%ป.กศ%'
		and grade not like '%ป.กศ.%'
		and grade not like '%ป.ก.ศ.%'
		and grade not like '%ปกศ%'
		and grade not like '%ปก.ศ%'
		and grade not like '%ป.กส%'
		and grade not like '%ปกส%'
		and grade not like '%ปวส%'
		and grade not like '%ปวช%'
		and grade not like '%ปว.ส%'
		and grade not like '%ปว.ช%'
		and grade not like '%ป.วส%'
		and grade not like '%ป.วช%'
		and id='$userid' order by finishyear desc limit 0,1;		
	";	
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$p1	= (mysql_num_rows($result) >= 1) ? true : false ;



	if ($p1 || $p2 || $p3) $key1 = true; 

	//Condition 1 : End
	
	//Condition 2 : ตรวจสอบเงื่อนไขที่สองเป็นครูมา 6 ปี
	if($key1 == true){
		
		$sql		= "		
			SELECT DISTINCT `position`
			from salary
			where 
			(`position` like '%ครู%'  or  `position` like '%อาจารย์%') 
			and `position` not like '%ชำนาญ%' 
			and `position` not like '%เชี่ยวชาญ%' 
			and `position` not like '%ทดลอง%' 
			and `position` not like '%ผู้ช่วย%' 
			and `position` not like '%รักษาการ%' 
			and `position` not like '%พ้นจาก%' 		
		";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		while($rs 	= mysql_fetch_assoc($result)){
			$pos[$rs[position]]	= 1;
		}
		mysql_free_result($result);
		unset($rs,$sql);
	
		//echo "<pre>"; print_r($pos); echo "</pre>"; 
		
		$edu = 0;
		$sql		= " select * from `salary` where id='$userid' order by date desc;  ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		while($rs = mysql_fetch_assoc($result)){
			//echo "<li>$rs[position]";
			if($pos[$rs[position]] == 1){
				$x = explode("-",$rs[date]);
				$y1 = intval($x[0]);
				if ($y1 > 2400){
					$dy = intval(date("Y")+543) - $y1;
				}

				if ($dy > $edu){ //เอาปีที่มากสุด
					$edu = $dy;
				}

			}
		}
		mysql_free_result($result);
		unset($rs,$sql,$pos);

		if (($p3 && $edu >= 2) || ($p2 && $edu >= 4) || ($p1 && $edu >= 6)){
			$key2 = true;
		}else{
			$key2 = false;
			$error_message["ประสพการณ์"] = "ยังดำรงตำแหน่งครูไม่ครบตามเกณฑ์ที่ระบุ";
		}
		//$key2	= ($edu >= 6) ? true : false ;	
	}else{
		$error_message["การศึกษา"] = "วุฒิการศึกษาไม่ถึงระดับปริญญาตรี";
	}
	//Condition 2 : End
	
	//if ($userid == "13002307") echo "p1=$p1/p2=$p2/p3=$p3 /key1 = $key1/ key2=$key2/ edu=$edu<BR>";

	//Condition 3 : เงินเดือน
	if($key2 == true){
	/*
		$sql		= " select cs1 from `salary_rate` order by cs1 asc where cs1 > 0; "; // get เงินเดือนคศ1 
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		while($rs = mysql_fetch_assoc($result)){
			$sal[]= $rs[cs1];
		}
		mysql_free_result($result);
		unset($rs,$sql);
		
		$sql		= " select min(cs2) as cs2 from `salary_rate`; "; // get เงินเดือนต่ำสุด คศ 2
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs 		= mysql_fetch_assoc($result);
		$sal[]	= $rs[cs2];
		mysql_free_result($result);
		unset($rs,$sql);
		
		$sql		= " select salary from `salary` where id='$id' order by date desc limit 0,1; "; // get เงินเดือนปัจจุบัน
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs 		= mysql_fetch_assoc($result);
		$money	= $rs[salary];
		mysql_free_result($result);
		unset($rs,$sql);
		*/

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		if (($rs[salary] >= $minsalary['คศ.2']) && $rs[vitaya] == "" ){
			$getCon1 = true;
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.2";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	
	//Condition 3 : End
	return $getCon1;
}



function chkVitaya2($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//ครูชำนาญการพิเศษ
//=============================
// มีวิทยฐานะ "ชำนาญการ" 1 ปี
// เงินเดือ คศ.2 และถึงขั้นต่ำ คศ. 3

//
	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and position like '%ชำนาญการ%' order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 1){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.3'])){
			if ($rs[vitaya] == "ชำนาญการ" ){
				$getCon1 = true;
			}else{
				$error_message["วิทยฐานะ"] = "ไม่มีวิทยฐานะ ชำนาญการ";
			}
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.3";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["ประสพการณ์"] = "มีวิทยฐานะ ชำนาญการ ไม่ถึง 3 ปี";
	}
	//Condition 3 : End
	return $getCon1;
}



function chkVitaya3($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//ครูชำนาญการพิเศษ => ครูเชี่ยวชาญ
//=============================
// มีวิทยฐานะ "ูชำนาญการพิเศษ" 3 ปี
// เงินเดือ คศ.3 และถึงขั้นต่ำ คศ. 4
// มีผลงานย้อนหลัง 2 ปี

//
	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and position like '%ูชำนาญการพิเศษ%' order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 3){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.4'])){
			if ($rs[vitaya] == "ชำนาญการพิเศษ" ){
				$getCon1 = true;
			}else{
				$error_message["วิทยฐานะ"] = "ไม่มีวิทยฐานะ ชำนาญการพิเศษ";
			}
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.3";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["ประสพการณ์"] = "่มีวิทยฐานะ ชำนาญการพิเศษ ไม่ถึง 3 ปี";
	}
	//Condition 3 : End
	return $getCon1;
}

function chkVitaya4($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//ครูเชี่ยวชาญ => ครูเชี่ยวชาญพิเศษ
//=============================
// มีวิทยฐานะ "เชี่ยวชาญ" 2 ปี
// เงินเดือ คศ.4 และถึงขั้นต่ำ คศ. 5
// มีผลงานย้อนหลัง 2 ปี

//
	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and position like '%เชี่ยวชาญ%' order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 2){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.5'])){
			if ($rs[vitaya] == "เชี่ยวชาญ" ){
				$getCon1 = true;
			}else{
				$error_message["วิทยฐานะ"] = "ไม่มีวิทยฐานะ เชี่ยวชาญ";
			}
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.5";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["ประสพการณ์"] = "่มีวิทยฐานะ เชี่ยวชาญ ไม่ถึง 2 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}

//================================================================================
// ศึกษานิเทศก์
//================================================================================
function chkVitayaNites1($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//ศึกษานิเทศก์ => ศึกษานิเทศก์ชำนาญการ
//=============================
// เป็นศึกษานิเทศก์/เทียบเท่า 2 ปี
// เงินเดือ คศ.1 และถึงขั้นต่ำ คศ. 2
// มีผลงานย้อนหลัง 2 ปี


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and position like '%ศึกษานิเทศก์%' order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 2){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.2']) && $rs[vitaya] == "" ){
			$getCon1 = true;
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.2";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["ประสพการณ์"] = "เป็นศึกษานิเทศก์ ไม่ถึง 2 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}

function chkVitayaNites2($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//ศึกษานิเทศก์ชำนาญการ => ศึกษานิเทศก์ชำนาญการพิเศษ
//=============================
// เป็นศึกษานิเทศก์ชำนาญการ 1 ปี
// เงินเดือ คศ.2 และถึงขั้นต่ำ คศ. 3
// มีผลงานย้อนหลัง 2 ปี


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and position like '%ศึกษานิเทศก์%ชำนาญการ%' order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 1){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.3'])){
			if ($rs[vitaya] == "ชำนาญการ" ){
				$getCon1 = true;
			}else{
				$error_message["วิทยฐานะ"] = "ไม่มีวิทยฐานะ ชำนาญการ";
			}
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.3";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["ประสพการณ์"] = "เป็นศึกษานิเทศก์ชำนาญการ ไม่ถึง 1 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}


function chkVitayaNites3($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//ศึกษานิเทศก์ชำนาญการพิเศษ => ศึกษานิเทศกเชี่ยวชาญ
//=============================
// ศึกษานิเทศก์ชำนาญการพิเศษ 3 ปี หรือ ศึกษานิเทศก์ชำนาญการ 5 ปี
// เงินเดือ คศ.3 และถึงขั้นต่ำ คศ. 4
// มีผลงานย้อนหลัง 2 ปี


	$getCon1 = false;

	$edu1 = 0;
	$sql		= " select * from `salary` where id='$userid' and position like '%ศึกษานิเทศก์%ชำนาญการ%' order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu1 = intval(date("Y")+543) - $y1;
	}

	
	$edu2 = 0;
	$sql		= " select * from `salary` where id='$userid' and position like '%ศึกษานิเทศก์%ชำนาญการ%พิเศษ' order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu2 = intval(date("Y")+543) - $y1;
	}


//echo "edu1=$edu1/edu2=$edu2 ";
	if($edu1 >= 5 || $edu2 >= 3){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >=  $minsalary['คศ.4'] ) ){
			if ( (($rs[vitaya] == "ชำนาญการ" && $edu1 >= 5) || ($rs[vitaya] == "ชำนาญการพิเศษ" && $edu2 >= 3)) ){
				$getCon1 = true;
			}else{
				$error_message["วิทยฐานะ"] = "ไม่มีวิทยฐานะ ชำนาญการพิเศษ";
			}
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.4";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["ประสพการณ์"] = "เป็นศึกษานิเทศก์ชำนาญการพิเศษไม่ถึง 3 ปี หรือ เป็นศึกษานิเทศก์ชำนาญการไม่ถึง 5 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}


function chkVitayaNites4($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//ศึกษานิเทศกเชี่ยวชาญ => ศึกษานิเทศกเชี่ยวชาญพิเศษ
//==================================
// ศึกษานิเทศกเชี่ยวชาญ 2 ปี
// เงินเดือ คศ.4 และถึงขั้นต่ำ คศ. 5
// มีผลงานย้อนหลัง 2 ปี


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and position like '%ศึกษานิเทศก์%เชี่ยวชาญ%' order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}



	if($edu >= 2){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.5'])){
			if ($rs[vitaya] == "เชี่ยวชาญ" ){
				$getCon1 = true;
			}else{
				$error_message["วิทยฐานะ"] = "ไม่มีวิทยฐานะ เชี่ยวชาญ";
			}
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.5";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["ประสพการณ์"] = "เป็นศึกษานิเทศกเชี่ยวชาญไม่ถึง 2 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}




//================================================================================
// ผู้อำนวยการโรงเรียน
//================================================================================
function chkVitayaSchoolMgr1($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//ผู้อำนวยการโรงเรียน => ผู้อำนวยการโรงเรียนชำนาญการ
//=============================
// เป็นผู้อำนวยการโรงเรียน 1 ปี
// เงินเดือ คศ.1 และถึงขั้นต่ำ คศ. 2
// มีผลงานปฏิบัติหน้าที่ย้อนหลัง 2 ปี


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%ผู้อำนวยการ%' ) order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	if($edu >= 1){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.2']) && $rs[vitaya] == "" ){
			$getCon1 = true;
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.2";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["ประสพการณ์"] = "เป็นผู้อำนวยการโรงเรียน ไม่ถึง 1 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}

function chkVitayaSchoolMgr2($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//ผู้อำนวยการโรงเรียนชำนาญการ => ผู้อำนวยการโรงเรียนชำนาญการพิเศษ
//=============================
// เป็นศึกษานิเทศก์ชำนาญการ 1 ปี
// เงินเดือ คศ.2 และถึงขั้นต่ำ คศ. 3
// มีผลงานย้อนหลัง 2 ปี


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%ผู้อำนวยการ%ชำนาญการ')  order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 1){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.3'])){
			if ($rs[vitaya] == "ชำนาญการ" ){
				$getCon1 = true;
			}else{
				$error_message["วิทยฐานะ"] = "ไม่มีวิทยฐานะ ชำนาญการ";
			}
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.3";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["ประสพการณ์"] = "เป็นผู้อำนวยการโรงเรียนชำนาญการ  ไม่ถึง 1 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}


function chkVitayaSchoolMgr3($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//ผู้อำนวยการโรงเรียนชำนาญการพิเศษ => ผู้อำนวยการโรงเรียนเชี่ยวชาญ
//=============================
// ผู้อำนวยการโรงเรียนชำนาญการพิเศษ 3 ปี หรือผู้อำนวยการโรงเรียนชำนาญการ 5 ปี
// เงินเดือ คศ.3 และถึงขั้นต่ำ คศ. 4
// มีผลงานย้อนหลัง 2 ปี


	$getCon1 = false;

	$edu1 = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%ผู้อำนวยการ%ชำนาญการ%' )  order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu1 = intval(date("Y")+543) - $y1;
	}

	
	$edu2 = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%ผู้อำนวยการ%ชำนาญการ%พิเศษ%' ) order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu2 = intval(date("Y")+543) - $y1;
	}


//echo "edu1=$edu1/edu2=$edu2 ";
	if($edu1 >= 5 || $edu2 >= 3){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.4']) ){
			if ( (($rs[vitaya] == "ชำนาญการ" && $edu1 >= 5) || ($rs[vitaya] == "ชำนาญการพิเศษ" && $edu2 >= 3)) ){
				$getCon1 = true;
			}else{
				$error_message["วิทยฐานะ"] = "ไม่มีวิทยฐานะ ชำนาญการ หรือ ชำนาญการพิเศษ";
			}
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.4";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["ประสพการณ์"] = "เป็นผู้อำนวยการโรงเรียนชำนาญการพิเศษไม่ถึง 3 ปี หรือผู้อำนวยการโรงเรียนชำนาญการ 5 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}


function chkVitayaSchoolMgr4($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//ผู้อำนวยการโรงเรียนเชี่ยวชาญ => ผู้อำนวยการโรงเรียนเชี่ยวชาญพิเศษ
//==================================
// ผู้อำนวยการโรงเรียนเชี่ยวชาญ  2 ปี
// เงินเดือ คศ.4 และถึงขั้นต่ำ คศ. 5
// มีผลงานย้อนหลัง 2 ปี


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%ผู้อำนวยการ%เชี่ยวชาญ' ) order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}



	if($edu >= 2){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.5']) ){
			if ($rs[vitaya] == "เชี่ยวชาญ" ){
				$getCon1 = true;
			}else{
				$error_message["วิทยฐานะ"] = "ไม่มีวิทยฐานะ เชี่ยวชาญ";
			}
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.5";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["ประสพการณ์"] = "เป็นผู้อำนวยการโรงเรียนเชี่ยวชาญไม่ถึง 2 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}



//================================================================================
// รองผู้อำนวยการโรงเรียน
//================================================================================
function chkVitayaSchoolViceMgr1($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//รองผู้อำนวยการโรงเรียน => รองผู้อำนวยการโรงเรียนชำนาญการ
//=============================
// เป็นรองผู้อำนวยการโรงเรียน 1 ปี
// เงินเดือ คศ.1 และถึงขั้นต่ำ คศ. 2
// มีผลงานปฏิบัติหน้าที่ย้อนหลัง 2 ปี


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%รองผู้อำนวยการ%' or position like '%รอง%ผ.อ%' ) order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	if($edu >= 1){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.2']) && $rs[vitaya] == "" ){
			$getCon1 = true;
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.2";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["ประสพการณ์"] = "เป็นรองผู้อำนวยการโรงเรียน ไม่ถึง 1 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}

function chkVitayaSchoolViceMgr2($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//รองผู้อำนวยการโรงเรียนชำนาญการ => รองผู้อำนวยการโรงเรียนชำนาญการพิเศษ
//=============================
// เป็นศึกษานิเทศก์ชำนาญการ 1 ปี
// เงินเดือ คศ.2 และถึงขั้นต่ำ คศ. 3
// มีผลงานย้อนหลัง 2 ปี


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%รองผู้อำนวยการ%ชำนาญการ%'  or position like '%รอง%ผ.อ%ชำนาญการ%' )  order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 1){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.3']) ){
			if ($rs[vitaya] == "ชำนาญการ" ){
				$getCon1 = true;
			}else{
				$error_message["วิทยฐานะ"] = "ไม่มีวิทยฐานะ ชำนาญการ";
			}
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.3";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["ประสพการณ์"] = "เป็นรองผู้อำนวยการโรงเรียนชำนาญการ ไม่ถึง 1 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}


function chkVitayaSchoolViceMgr3($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//รองผู้อำนวยการโรงเรียนชำนาญการพิเศษ => รองผู้อำนวยการโรงเรียนเชี่ยวชาญ
//=============================
// รองผู้อำนวยการโรงเรียนชำนาญการพิเศษ 3 ปี หรือรองผู้อำนวยการโรงเรียนชำนาญการ 5 ปี
// เงินเดือ คศ.3 และถึงขั้นต่ำ คศ. 4
// มีผลงานย้อนหลัง 2 ปี


	$getCon1 = false;

	$edu1 = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%รองผู้อำนวยการ%ชำนาญการ%' or position like '%รอง%ผ.อ%ชำนาญการ%' )  order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu1 = intval(date("Y")+543) - $y1;
	}

	
	$edu2 = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%รองผู้อำนวยการ%ชำนาญการ%พิเศษ%' ) order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu2 = intval(date("Y")+543) - $y1;
	}


//echo "edu1=$edu1/edu2=$edu2 ";
	if($edu1 >= 5 || $edu2 >= 3){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.4']) ){
			if ( (($rs[vitaya] == "ชำนาญการ" && $edu1 >= 5) || ($rs[vitaya] == "ชำนาญการพิเศษ" && $edu2 >= 3)) ){
				$getCon1 = true;
			}else{
				$error_message["วิทยฐานะ"] = "ไม่มีวิทยฐานะ ชำนาญการ หรือ ชำนาญการพิเศษ ";
			}
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.4";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["ประสพการณ์"] = "เป็นรองผู้อำนวยการโรงเรียนชำนาญการพิเศษ ไม่ถึง 3 ปี หรือรองผู้อำนวยการโรงเรียนชำนาญการ ไม่ถึง 5 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}


function chkVitayaSchoolViceMgr4($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//รองผู้อำนวยการโรงเรียนเชี่ยวชาญ => รองผู้อำนวยการโรงเรียนเชี่ยวชาญพิเศษ
//==================================
// รองผู้อำนวยการโรงเรียนเชี่ยวชาญ  2 ปี
// เงินเดือ คศ.4 และถึงขั้นต่ำ คศ. 5
// มีผลงานย้อนหลัง 2 ปี


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%รองผู้อำนวยการ%เชี่ยวชาญ' or position like '%รอง%ผ.อ%เชี่ยวชาญ' ) order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}



	if($edu >= 2){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.5']) ){
			if ($rs[vitaya] == "เชี่ยวชาญ" ){
				$getCon1 = true;
			}else{
				$error_message["วิทยฐานะ"] = "ไม่มีวิทยฐานะ เชี่ยวชาญ";
			}
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.5";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["ประสพการณ์"] = "เป็นรองผู้อำนวยการโรงเรียนเชี่ยวชาญ ไม่ถึง 2 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}


//================================================================================
// ผู้อำนวยการสพท.
//================================================================================
function chkVitayaSecMgr1($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//ผู้อำนวยการ สพท. => ผู้อำนวยการ สพท. เชี่ยวชาญ
//=============================
// เป็นผู้อำนวยการ สพท. / เทียบเท่า 1 ปี
// เงินเดือ คศ.4
// มีผลงานปฏิบัติหน้าที่ย้อนหลัง 2 ปี


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%ผู้อำนวยการ%สพท%' ) order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	if($edu >= 1){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.4']) && $rs[vitaya] == "" ){
			$getCon1 = true;
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.4";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else {
		$error_message["ประสพการณ์"] = "เป็นผู้อำนวยการ สพท. หรือ เทียบเท่า ไม่ถึง 1 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}

function chkVitayaSecMgr2($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//ผู้อำนวยการ สพท. เชี่ยวชาญ => ผู้อำนวยการ สพท. เชี่ยวชาญพิเศษ
//=============================
// เป็นผู้อำนวยการ สพท. เชี่ยวชาญ 2 ปี
// เงินเดือ คศ.4 และถึงขั้นต่ำ คศ. 5
// มีผลงานย้อนหลัง 2 ปี


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%ผู้อำนวยการ%สพท%เชี่ยวชาญ')  order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 2){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.5']) ){
			if ($rs[vitaya] == "เชี่ยวชาญ" ){
				$getCon1 = true;
			}else{
				$error_message["วิทยฐานะ"] = "ไม่มีวิทยฐานะ เชี่ยวชาญ";
			}
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.5";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else {
		$error_message["ประสพการณ์"] = "เป็นผู้อำนวยการ สพท.เชี่ยวชาญ ไม่ถึง 2 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}





//================================================================================
// รองผู้อำนวยการสพท.
//================================================================================
function chkVitayaViceSecMgr1($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
// รองผู้อำนวยการ สพท. => รองผู้อำนวยการ สพท. ชำนาญการพิเศษ
// ============================================
// เป็นรองผู้อำนวยการ สพท. / เทียบเท่า 1 ปี
// เงินเดือ คศ.3
// มีผลงานปฏิบัติหน้าที่ย้อนหลัง 2 ปี


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%รอง%ผู้อำนวยการ%สพท%' ) order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	if($edu >= 1){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.3']) && $rs[vitaya] == "" ){
			$getCon1 = true;
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.3";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else {
		$error_message["ประสพการณ์"] = "เป็นรองผู้อำนวยการ สพท. หรือ เทียบเท่า ไม่ถึง 1 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}

function chkVitayaViceSecMgr2($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
// รองผู้อำนวยการ สพท. ชำนาญการพิเศษ => รองผู้อำนวยการ สพท. เชี่ยวชาญ
// =============================
// เป็นรองผู้อำนวยการ สพท. ชำนาญการพิเศษ 3 ปี
// เงินเดือ คศ.3 และถึงขั้นต่ำ คศ. 4
// มีผลงานย้อนหลัง 2 ปี


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%รอง%ผู้อำนวยการ%สพท%ชำนาญการ%พิเศษ')  order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 2){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['คศ.4']) ){
			if ($rs[vitaya] == "ชำนาญการพิเศษ" ){
				$getCon1 = true;
			}else{
				$error_message["วิทยฐานะ"] = "ไม่มีวิทยฐานะ ชำนาญการพิเศษ";
			}
		}else{
			$getCon1 = false;
			$error_message["เงินเดือน"] = "ขั้นเงินเดือนไม่ถึงขั้นต่ำ คศ.4";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else {
		$error_message["ประสพการณ์"] = "เป็นรองผู้อำนวยการ สพท. ชำนาญการพิเศษ ไม่ถึง 2 ปี";
	}	
	//Condition 3 : End
	return $getCon1;
}


?>