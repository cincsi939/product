<?php
###################################################################
## CMSS SCANPDF REPORT EXPORT
###################################################################
## Version :			20100615.001 (Created/Modified; Date.RunNumber)
## Created Date :	2010-06-15 09:00
## Created By :		Mr.PUDIS PROMSRI (PAAK)
## E-mail :				pudis@sapphire.co.th
## Tel. :				086-1860538
## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
###################################################################
$start_page = intval($start_page)>0 ? intval($start_page) : 1; 
//$limit = " limit 10" ;
	
define('FPDF_FONTPATH','fpdf/font/');
require_once("../config/conndb_nonsession.inc.php");
require_once("positionsql.inc_v2.php");
require_once('fpdf/fpdf.php');
require_once('fpdf/kp7_class.php');
require_once('../common/justify.inc.php');
require_once('count.function.php');

$dbnamemaster =  "edubkk_master" ; 

set_time_limit(3000);

session_start();

$timeA = microtime();

$profile_id = $profile_id ? $profile_id : "4";
$db_master = "edubkk_master";
$db_temp = "edubkk_checklist";
$last_page = intval($start_page) > 0  ? intval($start_page)-1 : 0 ;
$date_export = $DateNData ? $DateNData : " 1 เมษายน 2553 ";		// วันที่ ส่งออกข้อมูล
//$date_export = " 1 เมษายน 2553 ";		// วันที่ ส่งออกข้อมูล

if($profile_id){
$sql_profile  = "SELECT profilename FROM  ".DB_CHECKLIST.".tbl_checklist_profile WHERE profile_id = '$profile_id' ORDER BY profile_date DESC ";
                $result_profile = mysql_query($sql_profile);
                $rsp = mysql_fetch_assoc($result_profile);				
				$date_export = $rsp[profilename];
}



function UpdatePositionChecklist($siteid){
	global $dbnamemaster,$dbname_temp;
	$db_site = STR_PREFIX_DB.$siteid;
	$sql = "SELECT
t1.idcard,
t1.siteid,
t1.profile_id,
t2.position_now
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7 as t1
Inner Join $db_site.view_general as t2  ON t1.idcard = t2.CZ_ID AND t1.position_now <> t2.position_now
where t1.siteid='$siteid'";
$result = mysql_db_query($db_site,$sql);
while($rs = mysql_fetch_assoc($result)){
	$sql_up = "UPDATE tbl_checklist_kp7 SET position_now='$rs[position_now]' WHERE idcard='$rs[idcard]' and profile_id='$rs[profile_id]'";
	$sql_up1 = "UPDATE tbl_check_data SET position_now='$rs[position_now]' WHERE idcard='$rs[idcard]' and profile_id='$rs[profile_id]'";
	mysql_db_query($dbname_temp,$sql_up) or die(mysql_error());
	mysql_db_query($dbname_temp,$sql_up1) or die(mysql_error());

}// end while($rs = mysql_fetch_assoc($result)){
		
}//end UpdatePositionChecklist(){
	
UpdatePositionChecklist($siteid); // UPDATE ตำแหน่ง ใน checklist ให้ตรงกับ checklist

function CountLinePositionModify($get_siteid){
global $arrSkip,$profile_id;
	$db_temp = "edubkk_checklist";
	$g1 = find_groupstaff(1);
	$g2 = find_groupstaff(2);
	$g3 = find_groupstaff(3);
	$g4 = find_groupstaff(4);
	$g5 = find_groupstaff(5);
	$g6 = find_groupstaff(6);
	$g7 = find_groupstaff(7);
	$g8 = find_groupstaff(8); 
	$xarr[sum]="";
	
	 if (@in_array($get_siteid, $arrSkip) ) {
			$sql = " SELECT  
			sum(if($g1,1,0 )) as  H1,
			sum(if($g2 ,1,0 )) as H2,
			sum(if($g3 ,1,0 )) as H3,
			sum(if($g7,1,0 )) as  H4,
			sum(if($g4 ,1,0 )) as H5,
			sum(if($g5 ,1,0 )) as H6,
			sum(if(($g6 or $g8),1,0 )) as H7,
			schoolid,
			count(idcard) as numall
			FROM tbl_checklist_kp7  where siteid='$get_siteid' and page_upload>0 and profile_id = '$profile_id' GROUP BY schoolid";			
				
		} else {	
			$sql = " SELECT  
			sum(if($g1,1,0 )) as  H1,
			sum(if($g2 ,1,0 )) as H2,
			sum(if($g3 ,1,0 )) as H3,
			sum(if($g7,1,0 )) as  H4,
			sum(if($g4 ,1,0 )) as H5,
			sum(if($g5 ,1,0 )) as H6,
			sum(if(($g6 or $g8),1,0 )) as H7,
			schoolid,
			count(idcard) as numall
			FROM tbl_checklist_kp7  where siteid='$get_siteid' and profile_id = '$profile_id' GROUP BY schoolid";
		}
	//echo "<pre>$sql";die;
	$result = mysql_db_query($db_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		if($rs[schoolid]>0){
		$xarr[$rs[schoolid]]['H1'] = $rs['H1'];
		$xarr[$rs[schoolid]]['H2'] = $rs['H2'];
		$xarr[$rs[schoolid]]['H3'] = $rs['H3'];
		$xarr[$rs[schoolid]]['H4'] = $rs['H4'];
		$xarr[$rs[schoolid]]['H5'] = $rs['H5'];
		$xarr[$rs[schoolid]]['H6'] = $rs['H6'];
		$xarr[$rs[schoolid]]['H7'] = $rs['H7'];
		$xarr[$rs[schoolid]]['numall'] = $rs['numall'];
		$xarr[sum] += $rs['numall'];
		}
	}
	
	 if (@in_array($get_siteid, $arrSkip) ) {
			$sql = " SELECT  
			sum(if($g1,1,0 )) as  H1,
			sum(if($g2 ,1,0 )) as H2,
			sum(if($g3 ,1,0 )) as H3,
			sum(if($g7,1,0 )) as  H4,
			sum(if($g4 ,1,0 )) as H5,
			sum(if($g5 ,1,0 )) as H6,
			sum(if(($g6 or $g8),1,0 )) as H7,
			schoolid,
			count(idcard) as numall
			FROM tbl_checklist_kp7_false  where siteid='$get_siteid' and page_upload>0 
			 AND (tbl_checklist_kp7_false.status_IDCARD LIKE '%IDCARD_FAIL%' AND tbl_checklist_kp7_false.status_chang_idcard ='NO')
			 AND	tbl_checklist_kp7_false.profile_id = '$profile_id'
			GROUP BY schoolid";			
				
		} else {	
			$sql = " SELECT  
			sum(if($g1,1,0 )) as  H1,
			sum(if($g2 ,1,0 )) as H2,
			sum(if($g3 ,1,0 )) as H3,
			sum(if($g7,1,0 )) as  H4,
			sum(if($g4 ,1,0 )) as H5,
			sum(if($g5 ,1,0 )) as H6,
			sum(if(($g6 or $g8),1,0 )) as H7,
			schoolid,
			count(idcard) as numall
			FROM tbl_checklist_kp7_false  where siteid='$get_siteid'    
			 AND 	(tbl_checklist_kp7_false.status_IDCARD LIKE '%IDCARD_FAIL%' AND tbl_checklist_kp7_false.status_chang_idcard ='NO')
			 AND	tbl_checklist_kp7_false.profile_id = '$profile_id'
			GROUP BY schoolid";
		}
	//echo "<pre>$sql";die;
	$result = mysql_db_query($db_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		if($rs[schoolid]>0){
		$xarr[$rs[schoolid]]['H1']+= $rs['H1'];
		$xarr[$rs[schoolid]]['H2']+= $rs['H2'];
		$xarr[$rs[schoolid]]['H3']+= $rs['H3'];
		$xarr[$rs[schoolid]]['H4']+= $rs['H4'];
		$xarr[$rs[schoolid]]['H5']+= $rs['H5'];
		$xarr[$rs[schoolid]]['H6']+= $rs['H6'];
		$xarr[$rs[schoolid]]['H7']+= $rs['H7'];
		$xarr[$rs[schoolid]]['numall']+= $rs['numall'];
		$xarr[sum] += $rs['numall'];
		}
	}
	//echo "<pre>"; print_r($xarr); die;
	return $xarr;		
}

###########  นับจำนวนเลขบัตรไม่ตรองตามกรมการปกครอง
function NumIDFalse2($siteid,$profile_id){
	global $profile_id;
/*		if($profile_id >= 40){
			$profile_id = substr($profile_id,0,1);
		}
		
		if($xprofile_id >= 40){
			$conp = CmssProfile($xprofile_id);	
			if($conp != ""){
				$conprofile = " AND siteid IN($conp)";	
			}else{
				$conprofile = "";
			}
		}else{
			$conprofile = 	"  ";
		}*/
	$ins = "";
	
	$arrch = ChecklistSchoolSite($siteid); // function ตรวจสอบหน่วยงานโรงเรียนในเขต
	if(count($arrch) > 0){
			foreach($arrch as $k => $v){
					if($ins > "") $ins .= ",";
					$ins .= "'$v'";
			}
	}
	if($ins != ""){
		
		$xconif .= " or schoolid NOT IN($ins)";	
	}else{
		$xconif = "";	
	}
		
		$dbname_temp = "edubkk_checklist";
		$sql = "SELECT
		count(tbl_checklist_kp7_false.idcard) as num1,
			if(schoolid='' or schoolid IS NULL or schoolid='0' $xconif,'',schoolid) as schid
FROM
tbl_checklist_kp7_false
WHERE
siteid='$siteid' and 
tbl_checklist_kp7_false.profile_id =  '$profile_id' AND
tbl_checklist_kp7_false.status_IDCARD LIKE  '%IDCARD_FAIL%' AND
tbl_checklist_kp7_false.status_chang_idcard LIKE  '%NO%'
 group by schid";
//echo $sql;die;
$result = mysql_db_query($dbname_temp,$sql);
while($rs = mysql_fetch_assoc($result)){
	if($rs[schid] == "" or $rs[schid] == "0"){
			$idsch = "";	
		}else{
			$idsch = $rs[schid];
		}


			$arr[$idsch] = $rs[num1];

}//end while($rs = mysql_fetch_assoc($result))
//echo "<pre>";
//print_r($arr);die;
	return $arr;
}//end function NumIDFalse2()


#####  function แสดงจำนวนบุคลากรแยกตามตำแหน่ง
function CountLinePosition($get_siteid,$schoolid=""){
		global $arrSkip , $profile_id , $db_temp , $db_master ,$limit,$dbnamemaster;
		$db_temp = "edubkk_checklist";

		$arrsite = CountCheckList($get_siteid);
			
			$sql = "SELECT
			if( ".DB_MASTER.".allschool.id = '$xsiteid',999999, ".DB_MASTER.".allschool.id) AS num1,
			 ".DB_MASTER.".allschool.id,
			 ".DB_MASTER.".allschool.office,
			 ".DB_MASTER.".allschool.siteid
			FROM 
			".STR_PREFIX_DB."$get_siteid.general as t1
			Inner Join  ".DB_MASTER.".allschool ON  ".DB_MASTER.".allschool.id = t1.schoolid
			WHERE  ".DB_MASTER.".allschool.siteid='$get_siteid'
			GROUP BY  ".DB_MASTER.".allschool.id
			order by num1 desc";
			//echo "<pre>$sql";
			$nonm=0 ; 
			$result = mysql_db_query($dbnamemaster , $sql) ; 
			$i=0;
			$arrIdF = NumIDFalse2($get_siteid,$profile_id);
			while ($rs = mysql_fetch_assoc($result)){  
				 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				$runscid = $rs[id] ; 		
			####ข้อมูลของคนที่จะคีย์  <font color='green'><b>*</b></font>			
			//$rs['NumPass'] + $rs['NumNoPass'] +  $rs['NumNoMain'] + $rs['NumDisC'] + $rs['numidfalse'];
			$area_name = str_replace("สำนักงานเขตพื้นที่การศึกษา","",$rs[secname]);
			$numpass1 =  $arrsite[$rs[id]]['NumPass']; 
			$numDocP1 = $arrsite[$rs[id]]['NumPass']+$arrsite[$rs[id]]['NumNoPass']+$arrsite[$rs[id]]['NumNoMain']+$arrsite[$rs[id]]['NumDisC']+$arrsite[$rs[id]]['numidfalse']; // NEW CONDITION
			$NumDisCheck = $arrsite[$rs[id]]['numnorecive'];
			
			###  จำนวนข้อมูลเลขบัตรไม่ถูกต้องตามกรมการปกครอง
			
			$numIdFalse2 = $arrIdF[$rs[id]];
			
			$numIdFalse = $arrsite[$rs[id]]['numidfalse']+$numIdFalse2;
			### บุคลากรตามอัตราจริงทั้งหมด (คน)
			$sumPerson =  $arrsite[$rs[id]]['NumAll'];// NEW CONDITION
 		 	$NumFalse = $arrsite[$rs[id]]['NumNoPass']+$arrsite[$rs[id]]['NumNoMain']+$arrsite[$rs[id]]['NumDisC']; // NEW CONDITION
   			$NumUploadFile = $arrsite[$rs[id]]['NumUpload']; // NEW CONDITION
	 		$numpersonkey = $arrkey[$rs[id]]['numkey'];

		
		$xarr[$rs[schoolid]]['numall'] = $sumPerson;	   // ทั้งหมด // NEW CONDITION
		$xarr[$rs[schoolid]]['H1'] = $numDocP1 ? intval($numDocP1) : "0"; // เอกสารทั้งหมด// NEW CONDITION
		$xarr[$rs[schoolid]]['H2'] = $NumPass ? intval($NumPass) : "0"; // ผ่าน  // NEW CONDITION
		$xarr[$rs[schoolid]]['H3'] = $NumFalse ? intval($NumFalse) : "0"; // เอกสารไม่ผ่าน// NEW CONDITION
		$xarr[$rs[schoolid]]['H4'] = $NumDisCheck ? intval($NumDisCheck) : "0"; // ค้างรับ
		$xarr[$rs[schoolid]]['H5'] = $numIdFalse ? intval($numIdFalse) : "0"; // ไม่ตรงตามกรมการปกครอง
		$xarr[$rs[schoolid]]['H6'] = $NumUploadFile ? intval($NumUploadFile) : "0"; // ไฟล์กพ7 // NEW CONDITION
		}

	
	//echo "<pre>"; print_r($xarr); echo "</pre>";die;
	return $xarr;		
}

//$arr1 = CountLinePosition($siteid);echo "<pre>"; print_r($arr1); die;

// ฟังชั่น หัวเรื่องโรงเรียน
function add_site_head($siteid,$school_id=""){
	global $pdf , $x , $y , $row_h , $date_export ,$last_page ,$array_page;
	$now_page = $pdf->AddPage();
	$last_page++;
	$x = 10;
	$y = 5;
	$row_h = 7; # ความสูงของบรรทัด
	$strSQL=" Select * from  ".DB_MASTER.".eduarea where secid = '$siteid' limit 1 ";
	$Row_site = mysql_query($strSQL);
	if(@mysql_num_rows($Row_site)>0){ $Result_site = mysql_fetch_assoc($Row_site); }
	
	if($school_id){
		$strSQL=" SELECT * FROM  ".DB_MASTER.".`allschool` where id = '$school_id' limit 1";
		$Row_school = mysql_query($strSQL);
		if(@mysql_num_rows($Row_school)>0){ 
			$Result_school = mysql_fetch_assoc($Row_school); 	
			if($school_id==$siteid){
				$school_text = " / ".$Result_school[office]; 
			}else{
				$school_text = " / โรงเรียน".$Result_school[office]; 
			}
		}
	}

	$array_page[$now_page] = $school_text ? $Result_school[office] : $Result_site[secname] ;

	$logos_path = "img/logo_kks.jpg";			// รูปโลโก้ที่ใช้งาน secname
	$pdf->Image($logos_path,$x+150,$y,28);
	$pdf->SetFont('Angsana New','B',14);
	$pdf->SetXY($x,$y+=5);	$pdf->Cell(160,$row_h,"รายงานจำนวนสำเนาทะเบียนประวัติอิเล็กทรอนิกส์ (ก.พ.7) ต้นฉบับ จำแนกรายหน่วยงาน",0,0,'C');	
	$pdf->SetXY($x,$y+=5);	$pdf->Cell(160,$row_h,"$Result_site[secname]".$school_text,0,0,'C');	
	if(!$school_id){	$pdf->SetXY($x,$y+=5);	$pdf->Cell(160,$row_h,"สังกัดสำนักงานคณะกรรมการการศึกษาขั้นพื้นฐาน (สพฐ.) ",0,0,'C');}
	$pdf->SetXY($x,$y+=5);	$pdf->Cell(160,$row_h,"$date_export ",0,0,'C');	
	$pdf->SetFont('Angsana New','',14);	
	$y+=10;
	$path_directory = "$Result_site[secname_short]".$school_text."/";
	return $path_directory;
}


function add_site_head_null($siteid,$school_id=""){
	global $pdf , $x , $y , $row_h , $date_export ,$last_page ,$array_page;
	$now_page = $pdf->AddPage();
	$last_page++;
	$x = 10;
	$y = 5;
	$row_h = 7; # ความสูงของบรรทัด
	$strSQL=" Select * from  ".DB_MASTER.".eduarea where secid = '$siteid' limit 1 ";
	$Row_site = mysql_query($strSQL);
	if(@mysql_num_rows($Row_site)>0){ $Result_site = mysql_fetch_assoc($Row_site); }
	

	$array_page[$now_page] = $school_text = "  ไม่ระบุหน่วยงานสังกัด";

	$logos_path = "img/logo_kks.jpg";			// รูปโลโก้ที่ใช้งาน secname
	$pdf->Image($logos_path,$x+150,$y,28);
	$pdf->SetFont('Angsana New','B',14);
	$pdf->SetXY($x,$y+=5);	$pdf->Cell(160,$row_h,"รายงานจำนวนสำเนาทะเบียนประวัติอิเล็กทรอนิกส์ (ก.พ.7) ต้นฉบับ จำแนกรายหน่วยงาน",0,0,'C');	
	$pdf->SetXY($x,$y+=5);	$pdf->Cell(160,$row_h,"$Result_site[secname]".$school_text,0,0,'C');	
	if(!$school_id){	$pdf->SetXY($x,$y+=5);	$pdf->Cell(160,$row_h,"สังกัดสำนักงานคณะกรรมการการศึกษาขั้นพื้นฐาน (สพฐ.) ",0,0,'C');}
	$pdf->SetXY($x,$y+=5);	$pdf->Cell(160,$row_h,"$date_export ",0,0,'C');	
	$pdf->SetFont('Angsana New','',14);	
	$y+=10;
	$path_directory = "$Result_site[secname_short]".$school_text."/";
	return $path_directory;
}// end function add_site_head_null($siteid,$school_id=""){

function add_site_colhead($siteid,$school_id=""){
		global $pdf , $x , $y , $row_h , $date_export ,$last_page ,$array_page,$x_column;
		$row_hx = $row_h;
		$row_h = 15;
		$x_row = $x;
		$all_bar = $x_column[3] + $x_column[4] + $x_column[5] + $x_column[6] + $x_column[7] + $x_column[8] ;
		$pdf->SetXY($x,$y);										$pdf->Cell($x_column[0],$row_h , "" ,1,0,'C');
		$pdf->SetXY($x+=$x_column[0],$y);				$pdf->Cell($x_column[1],$row_h , "" ,1,0,'C');
		$pdf->SetXY($x+=$x_column[1],$y);				$pdf->Cell($x_column[2],$row_h ,	 "" ,1,0,'C');
		$pdf->SetXY($x+$x_column[2],$y);					$pdf->Cell($all_bar/2,$row_h/2 , "" ,1,0,'C');
		
		$pdf->SetXY($x+=$x_column[2],$y+$row_h/2);	$pdf->Cell($x_column[3],$row_h/2 , "" ,1,0,'C');
		$pdf->SetXY($x+=$x_column[3],$y+$row_h/2);	$pdf->Cell($x_column[4],$row_h/2 , "" ,1,0,'C');
		$pdf->SetXY($x+=$x_column[4],$y+$row_h/2);	$pdf->Cell($x_column[5],$row_h/2 , "" ,1,0,'C');
		$pdf->SetXY($x+=$x_column[5],$y);	$pdf->Cell($x_column[6],$row_h , "" ,1,0,'C');		
		$pdf->SetXY($x+=$x_column[6],$y);	$pdf->Cell($x_column[7],$row_h , "" ,1,0,'C');		
		$pdf->SetXY($x+=$x_column[7],$y);	$pdf->Cell($x_column[8],$row_h , "" ,1,0,'C');		
//		$pdf->SetXY($x+=$x_column[8],$y+$row_h/3);	$pdf->Cell($x_column[9],$row_h*2/3 , "" ,1,0,'C');		
		$x = $x_row;
		
		$pdf->SetFont('Angsana New','B',14);
		$pdf->SetXY($x,$y);											$pdf->Cell($x_column[0],$row_h , "ลำดับ" ,0,0,'C');
		$pdf->SetXY($x+=$x_column[0],$y);					$pdf->Cell($x_column[1],$row_h , "หน่วยงาน" ,0,0,'C');
		$pdf->SetFont('Angsana New','B',12);
		$pdf->SetXY($x+=$x_column[1],$y);					$pdf->Cell($x_column[2],$row_h/3 ,	 "บุคลากรตาม" ,0,0,'C');
		$pdf->SetXY($x,$y+$row_h/3);							$pdf->Cell($x_column[2],$row_h/3 ,	 "อัตราจริง" ,0,0,'C');
		$pdf->SetXY($x,$y+$row_h*2/3);						$pdf->Cell($x_column[2],$row_h/3 ,	 "ทั้งหมด (คน)" ,0,0,'C');

		$pdf->SetXY($x+$x_column[2],$y);						$pdf->Cell($all_bar/2,$row_h/2 , "ได้รับเอกสาร (คน)" ,0,0,'C');

		$pdf->SetXY($x+=$x_column[2],$y+$row_h/2);	$pdf->Cell($x_column[3],$row_h/2 , "รวม" ,0,0,'C');
		$pdf->SetXY($x+=$x_column[3],$y+$row_h/2);	$pdf->Cell($x_column[4],$row_h/2 , "สมบูรณ์" ,0,0,'C');
		$pdf->SetXY($x+=$x_column[4],$y+$row_h/2);	$pdf->Cell($x_column[5],$row_h/2 , "ไม่สมบูรณ์" ,0,0,'C');
		
		$pdf->SetXY($x+=$x_column[5],$y);				$pdf->Cell($x_column[6],$row_h/2 , "เอกสาร" ,0,0,'C');		
		$pdf->SetXY($x,$y+$row_h/2);	$pdf->Cell($x_column[6],$row_h/2 , "ค้างรับ(คน)" ,0,0,'C');		
		
		$pdf->SetXY($x+=$x_column[6],$y);	$pdf->Cell($x_column[7],$row_h/4 , "เลขบัตรฯ" ,0,0,'C');		
		$pdf->SetXY($x,$y+$row_h/4);			$pdf->Cell($x_column[7],$row_h/4 , "ไม่ตรงตาม" ,0,0,'C');
		$pdf->SetXY($x,$y+$row_h*2/4);		$pdf->Cell($x_column[7],$row_h/4 , "กรมการ" ,0,0,'C');
		$pdf->SetXY($x,$y+$row_h*3/4);		$pdf->Cell($x_column[7],$row_h/4 , "ปกครอง(คน)" ,0,0,'C');
		
		$pdf->SetXY($x+=$x_column[7],$y);	$pdf->Cell($x_column[8],$row_h/2 , "ไฟล์สำเนา" ,0,0,'C');		
		$pdf->SetXY($x,$y+$row_h/2);	$pdf->Cell($x_column[8],$row_h/2 , "ก.พ.7 (คน)" ,0,0,'C');		
		$y=$y+$row_h;
		$row_h = $row_hx;
		$x=$x_row;
		//$row_h = $row_hx;
		//$y+=$row_h;
}



	if($siteid && startpage){	
		# TAMPLATE PAGE 1 		
		#####################################################################################
		$pdf=new KP7();
		$pdf->AliasNbPages();
		$pdf->AddThaiFonts();
		$pdf->SetFont('Angsana New','B',14);	
		##########################START STEP 1 ######################################################		

		
		$x_column[0] = 10;
		$x_column[1] = 72;
		$x_column[2] = 18;
		$x_column[3] = 15;
		$x_column[4] = 15;
		$x_column[5] = 15;
		$x_column[6] = 15;
		$x_column[7] = 15;
		$x_column[8] = 15;
//		$x_column[9] = 13;
		
//		$x = 10;			// ขอบซ้าย		//$y=$y;
		$y = 270;
//		$number ++;		// ลำดับ		
//		if($y >= 268){ 
//			if($last_page>1){	$pdf->AddPage();	}	
//			add_site_head($siteid);	
//			add_site_colhead($siteid);
//			$last_page++; 		// ลงหน้าใหม่ limit ที่ 268	
//		}

		$pdf->SetFont('Angsana New','',14);	
		## เรียกจำนวนออกเป็น ARRAY 
/*		$sql_view = "
			SELECT if( ".DB_MASTER.".allschool.id = '$siteid',999,count(t1.idcard) ) AS num1,
			 ".DB_MASTER.".allschool.id,
			 ".DB_MASTER.".allschool.office,
			 ".DB_MASTER.".allschool.siteid
			FROM
			$db_temp.tbl_checklist_kp7 as t1
			Inner Join  ".DB_MASTER.".allschool ON  ".DB_MASTER.".allschool.id = t1.schoolid
			WHERE  ".DB_MASTER.".allschool.siteid='$siteid' AND profile_id = '$profile_id' 
			GROUP BY  ".DB_MASTER.".allschool.id
			order by num1 desc
			$limit
		";
		*/
		
	$ins = "";
	$arrch = ChecklistSchoolSite($siteid); // function ตรวจสอบหน่วยงานโรงเรียนในเขต
	if(count($arrch) > 0){
			foreach($arrch as $k => $v){
					if($ins > "") $ins .= ",";
					$ins .= "'$v'";
			}
	}
	if($ins != ""){
		
		$xconif .= " or schoolid NOT IN($ins)";	
	}else{
		$xconif = "";	
	}
		
		$sql_view = "SELECT 
		if(schoolid='' or schoolid IS NULL or schoolid='0' $xconif,'',schoolid) as schid,
		if( ".DB_MASTER.".allschool.id = '$siteid',999,if(id IS NULL or id='' or id='0',0,count(t1.idcard)) ) AS num1,
			 ".DB_MASTER.".allschool.id,
			 ".DB_MASTER.".allschool.office,
			 ".DB_MASTER.".allschool.siteid
			FROM
			$db_temp.tbl_checklist_kp7 as t1
			left Join  ".DB_MASTER.".allschool ON  ".DB_MASTER.".allschool.id = t1.schoolid
			WHERE t1.siteid='$siteid'  and profile_id = '$profile_id' 	
			GROUP BY schid order by num1 desc, ".DB_MASTER.".allschool.id asc
			$limit";
		
		$number  = 0;	
		$Result_School = mysql_query($sql_view) or die(mysql_error()."<br>$sql_view<br>LINE__".__LINE__);
		$num_of_org = @mysql_num_rows($Result_School);
		if($num_of_org>0){
			$arrsite = CountCheckList($siteid);
			$arrkey = NumPersonKey($siteid);		
		  //	$arrIdF = NumIDFalse($siteid);
			$arrIdF = NumIDFalse2($siteid,$profile_id);
			 $arrM=CountLinePositionModify($siteid);
			//echo "ข้อมูลเลขบัตรไม่สมบูรณ์ :: <pre>";
			//print_r($arrIdF);die;
		//$arr1 = CountNumPersonSchool($siteid);
		//echo "<pre>";	print_r($arrc1);		echo "</pre>";die;
		//echo $arrsite['']['NumAll']."<br>";
		
		//echo "<pre>";
		//print_r($arrsite);die;
		if(count($arrIdF) > 0){
			$sum_idfalse1 = array_sum($arrIdF);
		}//end if(count($arrIdF) > 0){
		
			  if(count($arrsite)>0){
					  foreach($arrsite as $k => $v){
						  $exsum_allH += $arrsite[$k]['NumAll'];
						 // $exnum1 += $arrsite[$k]['NumPass'];
						 // $exnum2 += $arrsite[$k]['NumDocFalse'];
						  //$exnum3 += $arrsite[$k]['NumDis'];
						  $exnum4 += $arrsite[$k]['NumUpload'];  
						 // $exnum_idflase_1 += $arrsite[$k]['numidfalse'];  // ได้รับเอกสารแต่เลขบัตรไม่สมบูรณ์
						  //$exnum4 += $arrsite[$k]['NumPass']+$arrsite[$k]['NumNoPass']+$arrsite[$k]['NumNoMain']+$arrsite[$k]['NumDisC']+$arrsite[$k]['numidfalse'];
						//  $exnum5 += $arrkey[$k]['numkey'];
						  $exsum_numarea = $exsum_numarea+1; // จำนวนเขต
						  
					  }//end foreach($arrsite as $k => $v){<br />
					  $exsum_noarea = $arrsite['']['NumAll']+$arrsite['0']['NumAll'];
				   }
				
				
				if($exsum_noarea > 0){
						$exsum_numarea  = $exsum_numarea-1;
				}

		while($Row_sc = mysql_fetch_assoc($Result_School)){
			
			if($Row_sc[schid] == "" or $Row_sc[schid] == "0"){
				$idschool = "";	
			}else{
				$idschool = $Row_sc[schid];	
			}
			
			$row_h = 7;
			$y=$y+$row_h;
			$number ++;		// ลำดับ	
			$x = 10;			// ขอบซ้าย
			if($y >= 268){
				add_site_head($siteid);
				if(intval($first_page)<1){
					$first_page++;
					$x_row = $x;					
					
					
					
					
					
					//echo "<pre> ";	print_r($arrsite); echo "</pre><hr><hr>"; 
				  // $exsum_idflase = array_sum($arrIdF); // จำนวนข้อมูลเลขบัตรไม่ถูกต้องทั้งหมด	
				   
				   //echo "<pre>";		print_r($arrM);		   echo "</pre>"; die;
				   
				   //$exsum_data = $exnum1+$exnum2+$exnum3;
				   $exsum_all = $exsum_allH;//$exsum_idflase+$exsum_data; /// จำนวนข้าราชการครูและบุคลากรทางการศึกษา (อัตราจริง)
				  // $exsum_doc = $exnum1+$exnum2; // สำเนาเอกสาร ก.พ.7 ต้นฉบับที่ได้รับจากเขตฯ
				   $exsum_scan = $exnum4;//แฟ้มข้อมูลสแกนสำเนาเอกสาร ก.พ.7 ต้นฉบับ
				  // $exsum_key = $exnum5;
				

					//$exsum_array = CountPersonPdf($siteid);
					$all_people     =  $exsum_allH+$sum_idfalse1; //$exsum_all ? $exsum_all : "0";
					$num_of_org  = $exsum_numarea ? $exsum_numarea : "0";
					$all_pdf 		    = $exsum_scan ? $exsum_scan : "0";					
					$percent_entry =  $all_people > 0 ? number_format($all_pdf*100/$all_people,2) : "0" ;					
					//$x=20;
					//$y=$y+$row_h;
					$pdf->SetXY($x+10,$y);								$pdf->Cell(100,$row_h,"จำนวนข้าราชการและบุคลากรทางการศึกษา (อัตราจริง)" ,0,0,'L');
					$pdf->SetXY($x+100,$y);							$pdf->Cell(20,$row_h , number_format($all_people) ,0,0,'C');
					$pdf->SetXY($x+110,$y);							$pdf->Cell(20,$row_h , "คน" ,0,0,'C');
					$pdf->SetXY($x+120,$y);							$pdf->Cell(20,$row_h , number_format($num_of_org) ,0,0,'C');
					$pdf->SetXY($x+130,$y);							$pdf->Cell(20,$row_h , "หน่วยงาน" ,0,0,'C');
					$y=$y+$row_h;
					$pdf->SetXY($x+10,$y);								$pdf->Cell(100,$row_h , "สำเนาเอกสาร ก.พ.7 ต้นฉบับ " ,0,0,'L');
					$pdf->SetXY($x+100,$y);							$pdf->Cell(20,$row_h , number_format($all_pdf) ,0,0,'C');
					$pdf->SetXY($x+110,$y);							$pdf->Cell(20,$row_h , "คน" ,0,0,'C');
					$pdf->SetXY($x+120,$y);							$pdf->Cell(20,$row_h , "$percent_entry" ,0,0,'C');
					$pdf->SetXY($x+130,$y);							$pdf->Cell(20,$row_h , "%" ,0,0,'C');
					$y=$y+$row_h;
					$date_now = date("Y-m-d");
					if(count($x_column) > 0){
					$all_bar =array_sum($x_column);
					}//end if(count($x_column) > 0){
					$now_thaidate = date_print();
					$pdf->SetXY($x,$y);							$pdf->Cell($all_bar,$row_h , "รายงาน ณ วันที่ ".$now_thaidate ,0,0,'R');
					$x=$x_row;
					$y=$y+$row_h;
				}
				add_site_colhead($siteid);
			}

			$x_row = $x;				
			$pdf->SetXY($x,$y);										$pdf->Cell($x_column[0],$row_h , "" ,1,0,'C');
			$pdf->SetXY($x+=$x_column[0],$y);				$pdf->Cell($x_column[1],$row_h , "" ,1,0,'C');
			$pdf->SetXY($x+=$x_column[1],$y);				$pdf->Cell($x_column[2],$row_h ,	 "" ,1,0,'C');
			$pdf->SetXY($x+=$x_column[2],$y);				$pdf->Cell($x_column[3],$row_h , "" ,1,0,'C');
			$pdf->SetXY($x+=$x_column[3],$y);				$pdf->Cell($x_column[4],$row_h , "" ,1,0,'C');
			$pdf->SetXY($x+=$x_column[4],$y);				$pdf->Cell($x_column[5],$row_h , "" ,1,0,'C');
			$pdf->SetXY($x+=$x_column[5],$y);				$pdf->Cell($x_column[6],$row_h , "" ,1,0,'C');		
			$pdf->SetXY($x+=$x_column[6],$y);				$pdf->Cell($x_column[7],$row_h , "" ,1,0,'C');		
			$pdf->SetXY($x+=$x_column[7],$y);				$pdf->Cell($x_column[8],$row_h , "" ,1,0,'C');		

			####ข้อมูลของคนที่จะคีย์  			
//			$area_name = str_replace("สำนักงานเขตพื้นที่การศึกษา","",$Row_sc[secname]);
//			$numpass1 =  $arrsite[$Row_sc[id]]['NumPass'];
//			$numDocP1 = $arrsite[$Row_sc[id]]['NumPass']+$arrsite[$Row_sc[id]]['NumDocFalse'];
//			$NumDisCheck = $arrsite[$Row_sc[id]]['NumDis'];
//			$numIdFalse = $arrIdF[$Row_sc[id]];
//			### บุคลากรตามอัตราจริงทั้งหมด (คน)
//			$sumPerson = $numIdFalse+$numDocP1+$NumDisCheck;
// 		 	$NumFalse = $arrsite[$Row_sc[id]]['NumDocFalse'];
//   			$NumUploadFile = $arrsite[$Row_sc[id]]['NumUpload'];
//	 		$numpersonkey = $arrkey[$Row_sc[id]]['numkey'];  


			####ข้อมูลของคนที่จะคีย์  <font color='green'><b>*</b></font>			
			$area_name = str_replace("สำนักงานเขตพื้นที่การศึกษา","",$rs[secname]);
			if($idschool == ""){
			
			$numpass1 =  $arrsite['']['NumPass']; 
			$NumidFalse_norecive =  $arrsite['']['numnorecive_idfalse'];  // เลขบัตรที่ gen ในระบบ checklist แต่เป็นเอกสารค้างรับ

//			###  จำนวนข้อมูลเลขบัตรไม่ถูกต้องตามกรมการปกครอง
			
			$numIdFalse = $arrsite['']['numidfalse'];
			### จำนวนไฟล์ค้าง
			$NumDisCheck = $arrIdF['']+$arrsite['']['numnorecive']+$NumidFalse_norecive;

			### บุคลากรตามอัตราจริงที่สมบูรณ์ (คน)
 		 	$NumFalse = $arrsite['']['NumNoPass']+$arrsite['']['NumNoMain']+$arrsite['']['NumDisC']; // NEW CONDITION			
			### ไฟล์อัตราจริงที่สมบูรณ์ (คน)
   			$NumUploadFile = $arrsite['']['NumUpload']; // NEW CONDITION 
			### นำเข้าข้อมูลตามอัตราจริงที่สมบูรณ์ (คน)
	 		$numpersonkey = $arrkey['']['numkey'];
			

			}else{
			
			$numpass1 =  $arrsite[$idschool]['NumPass']; 
			$NumidFalse_norecive =  $arrsite[$idschool]['numnorecive_idfalse'];  // เลขบัตรที่ gen ในระบบ checklist แต่เป็นเอกสารค้างรับ

//			###  จำนวนข้อมูลเลขบัตรไม่ถูกต้องตามกรมการปกครอง
			
			$numIdFalse = $arrsite[$idschool]['numidfalse'];
			### จำนวนไฟล์ค้าง
			$NumDisCheck = $arrIdF[$idschool]+$arrsite[$idschool]['numnorecive']+$NumidFalse_norecive;

			### บุคลากรตามอัตราจริงที่สมบูรณ์ (คน)
 		 	$NumFalse = $arrsite[$idschool]['NumNoPass']+$arrsite[$idschool]['NumNoMain']+$arrsite[$idschool]['NumDisC']; // NEW CONDITION			
			### ไฟล์อัตราจริงที่สมบูรณ์ (คน)
   			$NumUploadFile = $arrsite[$idschool]['NumUpload']; // NEW CONDITION 
			### นำเข้าข้อมูลตามอัตราจริงที่สมบูรณ์ (คน)
	 		$numpersonkey = $arrkey[$idschool]['numkey'];
			
			}
			
			### บุคลากรตามอัตราจริงที่สมบูรณ์ (คน)
			$numDocP1 = $numpass1+$NumFalse+$numIdFalse; // NEW CONDITION
			### บุคลากรตามอัตราจริงทั้งหมด (คน)
			$sumPerson = $numDocP1+$NumDisCheck;// NEW CONDITION
			
			
			
			if($Row_sc[schid] == ""){
				$xoffice1 = "ไม่ระบุหน่วยงานสังกัด";
			}else{
				$xoffice1 = $Row_sc[office];	
			}
			

			$x = $x_row;
			$pdf->SetXY($x,$y);										$pdf->Cell($x_column[0],$row_h , $number ,0,0,'C');
			$pdf->SetFont('Angsana New','B',14);	
			$pdf->SetXY($x+=$x_column[0],$y);				$pdf->Cell($x_column[1],$row_h , $xoffice1 ,0,0,'L');
			$pdf->SetFont('Angsana New','',14);	
			$pdf->SetXY($x+=$x_column[1],$y);				$pdf->Cell($x_column[2],$row_h ,	 number_format($sumPerson) ,0,0,'C');
			$pdf->SetXY($x+=$x_column[2],$y);				$pdf->Cell($x_column[3],$row_h , number_format($numDocP1) ,0,0,'C');
			$pdf->SetXY($x+=$x_column[3],$y);				$pdf->Cell($x_column[4],$row_h , number_format($numpass1) ,0,0,'C');
			$pdf->SetXY($x+=$x_column[4],$y);				$pdf->Cell($x_column[5],$row_h , number_format($NumFalse) ,0,0,'C');
			$pdf->SetXY($x+=$x_column[5],$y);				$pdf->Cell($x_column[6],$row_h , number_format($NumDisCheck) ,0,0,'C');		
			$pdf->SetXY($x+=$x_column[6],$y);				$pdf->Cell($x_column[7],$row_h , number_format($numIdFalse) ,0,0,'C');		
			$pdf->SetXY($x+=$x_column[7],$y);				$pdf->Cell($x_column[8],$row_h , number_format($NumUploadFile) ,0,0,'C');	
			
			$sumall 	+= $sumPerson;
			$sum_h1 += $numDocP1;
			$sum_h2 += $numpass1;
			$sum_h3 += $NumFalse;
			$sum_h4 += $NumDisCheck;
			$sum_h5 += $numIdFalse;
			$sum_h6 += $NumUploadFile;		

			$Array_Site[$idschool][Hall] = $sumPerson;
			$Array_Site[$idschool][H1] = $numDocP1;
			$Array_Site[$idschool][H2] = $numpass1;
			$Array_Site[$idschool][H3] = $NumFalse;
			$Array_Site[$idschool][H4] = $NumDisCheck;
			$Array_Site[$idschool][H5] = $numIdFalse;
			$Array_Site[$idschool][H6] = $NumUploadFile;		

		}
		if(@mysql_num_rows($Result_School)>0){
			$x = 10;			// ขอบซ้าย
			$y=$y+$row_h;
			$row_h = 7;
			if($y >= 268){ 				
				add_site_head($siteid);
				add_site_colhead($siteid);	
				$last_page++; 
			}		// ลงหน้าใหม่ limit ที่ 268			
			
/*			if($exsum_noarea > 0){
			$x = $x_row;
			$pdf->SetXY($x,$y);										$pdf->Cell($x_column[0],$row_h , $number+1 ,1,0,'C');
			$pdf->SetFont('Angsana New','B',14);	
			$pdf->SetXY($x+=$x_column[0],$y);				$pdf->Cell($x_column[1],$row_h , "ไม่ระบุหน่วยงานสังกัด" ,1,0,'L');
			$pdf->SetFont('Angsana New','',14);	
			$pdf->SetXY($x+=$x_column[1],$y);				$pdf->Cell($x_column[2],$row_h ,	 number_format(0) ,1,0,'C');
			$pdf->SetXY($x+=$x_column[2],$y);				$pdf->Cell($x_column[3],$row_h , number_format(0) ,1,0,'C');
			$pdf->SetXY($x+=$x_column[3],$y);				$pdf->Cell($x_column[4],$row_h , number_format(0) ,1,0,'C');
			$pdf->SetXY($x+=$x_column[4],$y);				$pdf->Cell($x_column[5],$row_h , number_format(0) ,1,0,'C');
			$pdf->SetXY($x+=$x_column[5],$y);				$pdf->Cell($x_column[6],$row_h , number_format($exsum_noarea) ,1,0,'C');		
			$pdf->SetXY($x+=$x_column[6],$y);				$pdf->Cell($x_column[7],$row_h , number_format(0) ,1,0,'C');		
			$pdf->SetXY($x+=$x_column[7],$y);				$pdf->Cell($x_column[8],$row_h , number_format(0) ,1,0,'C');	
			$y=$y+$row_h;
	
			}
			
*/			$x = $x_row;
			$pdf->SetFont('Angsana New','B',14);	
			$pdf->SetXY($x,$y);												$pdf->Cell($x_column[0]+$x_column[1],$row_h , "รวม "  ,1,0,'R');
			$pdf->SetXY($x+=$x_column[0]+$x_column[1],$y);	$pdf->Cell($x_column[2],$row_h ,	 number_format($sumall) ,1,0,'C');
			$pdf->SetXY($x+=$x_column[2],$y);				$pdf->Cell($x_column[3],$row_h , number_format($sum_h1) ,1,0,'C');
			$pdf->SetXY($x+=$x_column[3],$y);				$pdf->Cell($x_column[4],$row_h , number_format($sum_h2) ,1,0,'C');
			$pdf->SetXY($x+=$x_column[4],$y);				$pdf->Cell($x_column[5],$row_h , number_format($sum_h3) ,1,0,'C');
			$pdf->SetXY($x+=$x_column[5],$y);				$pdf->Cell($x_column[6],$row_h , number_format($sum_h4) ,1,0,'C');		
			$pdf->SetXY($x+=$x_column[6],$y);				$pdf->Cell($x_column[7],$row_h , number_format($sum_h5) ,1,0,'C');		
			$pdf->SetXY($x+=$x_column[7],$y);				$pdf->Cell($x_column[8],$row_h , number_format($sum_h6) ,1,0,'C');			
		}
		
		if($debug=="ON"){echo "<pre>";	print_r($Array_Site);  echo "$sumall  , $sum_h1 , $sum_h2 , $sum_h3 , $sum_h4 , $sum_h5 , $sum_h6 "; echo "</pre>";	die;}
		########################## STEP 2 ######################################################
		$schoolid_cond = $schoolid_fix ? " AND  ".DB_MASTER.".allschool.id= '$schoolid_fix' " : "";
		/*$sql_view = "
			SELECT if( ".DB_MASTER.".allschool.id = '$siteid',999,count(t1.idcard) ) AS num1,
			 ".DB_MASTER.".allschool.id,
			 ".DB_MASTER.".allschool.office,
			 ".DB_MASTER.".allschool.siteid
			FROM
			$db_temp.tbl_checklist_kp7 as t1
			Inner Join  ".DB_MASTER.".allschool ON  ".DB_MASTER.".allschool.id = t1.schoolid
			WHERE  ".DB_MASTER.".allschool.siteid='$siteid' AND profile_id = '$profile_id' 
			$schoolid_cond
			GROUP BY  ".DB_MASTER.".allschool.id
			order by num1 desc
			$limit
		";*/
		$ins = "";
	
	$arrch = ChecklistSchoolSite($xsiteid); // function ตรวจสอบหน่วยงานโรงเรียนในเขต
	if(count($arrch) > 0){
			foreach($arrch as $k => $v){
					if($ins > "") $ins .= ",";
					$ins .= "'$v'";
			}
	}
	if($ins != ""){
		
		$xconif .= " or schoolid NOT IN($ins)";	
	}else{
		$xconif = "";	
	}
		
		$sql_view = "SELECT 
		if(schoolid='' or schoolid IS NULL or schoolid='0' $xconif,'',schoolid) as schid,
		if( ".DB_MASTER.".allschool.id = '$siteid',999,if(id IS NULL or id='' or id='0',0,count(t1.idcard)) ) AS num1,
			 ".DB_MASTER.".allschool.id,
			 ".DB_MASTER.".allschool.office,
			 ".DB_MASTER.".allschool.siteid
			FROM
			$db_temp.tbl_checklist_kp7 as t1
			left Join  ".DB_MASTER.".allschool ON  ".DB_MASTER.".allschool.id = t1.schoolid
			WHERE t1.siteid='$siteid'  and profile_id = '$profile_id' 	
			$schoolid_cond
			GROUP BY schid order by num1 desc, ".DB_MASTER.".allschool.id asc
			$limit
			";
		//echo "$sql_view"; die;
		$Result_School = mysql_query($sql_view) or die(mysql_error()."<br>$sql_view<br>LINE__".__LINE__);
		 $arrsite = CountCheckListSchool($siteid,$schoolid);
		 if(@mysql_num_rows($Result_School)>0){
		while($Row_sc = mysql_fetch_assoc($Result_School)){
						
			#HEADER Column; ความกว้างคอลลัมณ์
			if($Row_sc[schid] == "" or $Row_sc[schid] == "0" ){
				$path_directory = add_site_head_null($siteid,"");
				$schoolid = "";
			}else{
				$path_directory = add_site_head($siteid , $Row_sc[schid] );
				$schoolid = $Row_sc[schid];	
			}//  end if($Row_sc[id] == "" or $Row_sc[id] == "0" ){
			
		
					
			$x_column[0] = 9;
			$x_column[1] = 25;
			$x_column[2] = 55;
			$x_column[3] = 35;
			$x_column[4] = 12;
			$x_column[5] = 55;
			$all_bar2 =array_sum($x_column)-$x_column[5]+$x_row;
			$number  = 0;
			$x_row = $x;
				
			if($last_page_school[$schoolid] < "0"){					
				 $last_page_school[$schoolid]++;
				 $x_row = $x;				 
				 
				//$exsum_array = CountPersonPdf($siteid,$schoolid);
				
				//echo "<pre> <b>$schoolid</b> <br>"; print_r($Array_Site); die;
				
				$all_people     = intval($Array_Site[$schoolid][Hall]);
				$all_pdf 		    = $Array_Site[$schoolid]['H6']			? $Array_Site[$schoolid]['H6'] : "0";
				$percent_entry =  $all_people > 0 							? number_format($all_pdf*100/$all_people,2) : "0" ;					
				//$x=20;
				$pdf->SetXY($x+10,$y);								$pdf->Cell(100,$row_h,"จำนวนข้าราชการและบุคลากรทางการศึกษา (อัตราจริง)" ,0,0,'L');
				$pdf->SetXY($x+100,$y);							$pdf->Cell(20,$row_h , number_format($all_people) ,0,0,'C');
				$pdf->SetXY($x+110,$y);							$pdf->Cell(20,$row_h , "คน" ,0,0,'C');
				$y=$y+$row_h;
				$pdf->SetXY($x+10,$y);								$pdf->Cell(100,$row_h , "สำเนาเอกสาร ก.พ.7 ต้นฉบับ " ,0,0,'L');
				$pdf->SetXY($x+100,$y);							$pdf->Cell(20,$row_h ,  number_format($all_pdf) ,0,0,'C');
				$pdf->SetXY($x+110,$y);							$pdf->Cell(20,$row_h , "คน" ,0,0,'C');
				$pdf->SetXY($x+120,$y);							$pdf->Cell(20,$row_h , "$percent_entry" ,0,0,'C');
				$pdf->SetXY($x+130,$y);							$pdf->Cell(20,$row_h , "%" ,0,0,'C');
				$y=$y+$row_h;
				$date_now = date("Y-m-d");

				$now_thaidate = date_print();
				$pdf->SetXY($x,$y);							$pdf->Cell($all_bar2,$row_h , "รายงาน ณ วันที่ ".$now_thaidate ,0,0,'R');
				$y=$y+$row_h/3;
				$x=$x_row;
			}
			
		
			$row_h = 10;
			$pdf->SetXY($x,$y+=5);						$pdf->Cell($x_column[0],$row_h,"",1,0,'C');
			$pdf->SetXY($x+=$x_column[0],$y);	$pdf->Cell($x_column[1],$row_h,"",1,0,'C');
			$pdf->SetXY($x+=$x_column[1],$y);	$pdf->Cell($x_column[2],$row_h,"",1,0,'C');
			$pdf->SetXY($x+=$x_column[2],$y); 	$pdf->Cell($x_column[3],$row_h,"",1,0,'C');
			$pdf->SetXY($x+=$x_column[3],$y);	$pdf->Cell($x_column[4],$row_h,"",1,0,'C');
			$pdf->SetXY($x+=$x_column[4],$y);	$pdf->Cell($x_column[5],$row_h,"",1,0,'C');
			$x = $x_row;
			$pdf->SetXY($x,$y);							$pdf->Cell($x_column[0],$row_h," ลำดับ",0,0,'C');
			$pdf->SetXY($x+=$x_column[0],$y);	$pdf->Cell($x_column[1],$row_h," เลขบัตรประชาชน",0,0,'C');
			$pdf->SetXY($x+=$x_column[1],$y);	$pdf->Cell($x_column[2],$row_h," ชื่อ - นามสกุล",0,0,'C');
			$pdf->SetXY($x+=$x_column[2],$y); 	$pdf->Cell($x_column[3],$row_h," ตำแหน่ง",0,0,'C');//$pdf->Cell($x_column[4],$row_h," ไฟล์ต้นฉบับ ",1,0,'C');
			$pdf->SetXY($x+=$x_column[3],$y);	$pdf->Cell($x_column[4],$row_h/2,"ไฟล์",0,0,'C');
			$pdf->SetXY($x,$y+($row_h/2));			$pdf->Cell($x_column[4],$row_h/2,"ต้นฉบับ",0,0,'C');
			$pdf->SetXY($x+=$x_column[4],$y);	$pdf->Cell($x_column[5],$row_h," ที่อยู่ไฟล์",0,0,'C');


			# รายชื่อ ข้าราชการครู แต่ละโรงเรียน
			if($schoolid == ""){
					$consch1 = "  AND (t1.schoolid = '$schoolid' or t1.schoolid='0' or t1.schoolid IS NULL) ";
					$consch2 = " AND (t3.schoolid = '$schoolid'  or t3.schoolid='0' or t3.schoolid IS NULL) ";
			}else{
					$consch1 = " AND t1.schoolid = '$schoolid'";	
					$consch2 = " AND t3.schoolid = '$schoolid'  ";
			}

			$xcmssdb = STR_PREFIX_DB.$siteid;
			$strSQL = "SELECT
					t1.idcard,
					t1.siteid,
					t1.prename_th,
					t1.name_th,
					t1.surname_th,
					if(tx.position_now <> '',tx.position_now,t1.position_now) as position_now,				
					t1.schoolid,
					t1.status_check_file,
					t1.status_file,
					'' as status_IDCARD,
					'' as status_chang_idcard,
					t2.orderby
				FROM tbl_checklist_kp7 as t1
				left join $xcmssdb.general as tx ON t1.idcard=tx.idcard
				LEFT Join  ".DB_MASTER.".hr_addposition_now  as t2 ON  if(tx.position_now <> '',tx.position_now,t1.position_now) =t2.`position`
				WHERE 
				
				t1.siteid='$siteid' AND t1.profile_id = '$profile_id' 	 $consch1
				UNION
				SELECT
					t3.idcard,
					t3.siteid,
					t3.prename_th,
					t3.name_th,
					t3.surname_th,
					t3.position_now,				
					t3.schoolid,
					t3.status_check_file,
					t3.status_file,
					t3.status_IDCARD,
					t3.status_chang_idcard,
					t4.orderby
				FROM tbl_checklist_kp7_false as t3
				LEFT Join  ".DB_MASTER.".hr_addposition_now as t4  ON t3.position_now = t4.`position`
				WHERE 
				
				t3.siteid='$siteid' AND 
				t3.profile_id = '$profile_id' 
				AND (t3.status_IDCARD LIKE '%IDCARD_FAIL%' AND t3.status_chang_idcard ='NO') $consch2
			ORDER BY orderby	ASC";
			//echo "<pre>" .$strSQL; die;	
			$Result_User = mysql_query($strSQL) or die(mysql_error()."$strSQL<br>LINE__".__LINE__);
			$xnum = @mysql_num_rows($Result_User);
			if( $xnum > 0 ){	
				$school_page=0;
				while($Row_User = mysql_fetch_assoc($Result_User)){
					if(!$idcard_success[$Row_User[idcard]]){
						$idcard_success[$Row_User[idcard]] = $Row_User[idcard];

						
						$x = 10;			// ขอบซ้าย
						$y=$y+$row_h;
						$row_h = 14;
						$number ++;		// ลำดับ		
						if($y >= 268){ 
							// $pdf->AddPage();	
							$x = 10;	$y = 20;	$last_page++; 
							$path_directory = add_site_head($siteid , $Row_sc[id] );
								$row_h = 10;
								$pdf->SetXY($x,$y+=5);						$pdf->Cell($x_column[0],$row_h,"",1,0,'C');
								$pdf->SetXY($x+=$x_column[0],$y);	$pdf->Cell($x_column[1],$row_h,"",1,0,'C');
								$pdf->SetXY($x+=$x_column[1],$y);	$pdf->Cell($x_column[2],$row_h,"",1,0,'C');
								$pdf->SetXY($x+=$x_column[2],$y); 	$pdf->Cell($x_column[3],$row_h,"",1,0,'C');
								$pdf->SetXY($x+=$x_column[3],$y);	$pdf->Cell($x_column[4],$row_h,"",1,0,'C');
								$pdf->SetXY($x+=$x_column[4],$y);	$pdf->Cell($x_column[5],$row_h,"",1,0,'C');
								$x = $x_row;
								$pdf->SetXY($x,$y);							$pdf->Cell($x_column[0],$row_h," ลำดับ",0,0,'C');
								$pdf->SetXY($x+=$x_column[0],$y);	$pdf->Cell($x_column[1],$row_h," เลขบัตรประชาชน",0,0,'C');
								$pdf->SetXY($x+=$x_column[1],$y);	$pdf->Cell($x_column[2],$row_h," ชื่อ - นามสกุล",0,0,'C');
								$pdf->SetXY($x+=$x_column[2],$y); 	$pdf->Cell($x_column[3],$row_h," ตำแหน่ง",0,0,'C');
								//$pdf->Cell($x_column[4],$row_h," ไฟล์ต้นฉบับ ",1,0,'C');
								$pdf->SetXY($x+=$x_column[3],$y);	$pdf->Cell($x_column[4],$row_h/2,"ไฟล์",0,0,'C');
								$pdf->SetXY($x,$y+($row_h/2));			$pdf->Cell($x_column[4],$row_h/2,"ต้นฉบับ",0,0,'C');
								$pdf->SetXY($x+=$x_column[4],$y);	$pdf->Cell($x_column[5],$row_h," ที่อยู่ไฟล์",0,0,'C');
								$y=$y+$row_h;
								$row_h = 14;
								$x = 10;
						}		// ลงหน้าใหม่ limit ที่ 268
						$x_row = $x;					
	
						$pdf->SetXY($x,$y);							$pdf->Cell($x_column[0],$row_h , "" ,1,0,'C');
						$pdf->SetXY($x+=$x_column[0],$y);	$pdf->Cell($x_column[1],$row_h , "" ,1,0,'C');
						$pdf->SetXY($x+=$x_column[1],$y);	$pdf->Cell($x_column[2],$row_h ,	 "" ,1,0,'C');
						$pdf->SetXY($x+=$x_column[2],$y); 	$pdf->Cell($x_column[3],$row_h , "" ,1,0,'C');
						$pdf->SetXY($x+=$x_column[3],$y);	$pdf->Cell($x_column[4],$row_h , "" ,1,0,'C');
						$pdf->SetXY($x+=$x_column[4],$y);	$pdf->Cell($x_column[5],$row_h , "" ,1,0,'C');
	
						$User_name = trim($Row_User[prename_th].$Row_User[name_th]." ".$Row_User[surname_th]);
						$path_User = $path_directory.$Row_User[idcard].".pdf";
	
						
						
						############################################# Export DATA Record
						$pdf->SetFont('Angsana New','',14);
						$x = $x_row;
						$arry_text=$pdf->alignstr($text,$col_var);
						
						// ลำดับ
						$pdf->SetXY($x,$y);							$pdf->Cell($x_column[0],$row_h , $number ,0,0,'C');	
						
						// IDCARD
						$pdf->SetXY($x+=$x_column[0],$y);	$pdf->Cell($x_column[1],$row_h , $Row_User[idcard] ,0,0,'C'); 
						
						// ชื่อ
						$pdf->SetXY($x+=$x_column[1],$y);	$pdf->Cell($x_column[2],$row_h , $User_name ,0,0,'L'); 

				// ชื่อเขต
						if(strstr($Row_User[position_now],"สำนักงานเขตพื้นที่การศึกษา")) {	// ชื่อ มี เขต เกี่ยวข้อง หรือ // ตำแหน่ง มากกว่า 1 บรรทัด
							$pdf->SetFont('Angsana New','',13);
							$position_text = str_replace("สำนักงานเขตพื้นที่การศึกษา","",$Row_User[position_now]);						
							//$pdf->SetXY($x+=$x_column[2],$y); 	$pdf->Cell($x_column[3],floor($row_h/2.5) , $position_text ,0,0,'L');
							//$pdf->SetXY($x,$y+floor($row_h*0.85/2.5)); 			$pdf->Cell($x_column[3],floor($row_h/2.5) , "สำนักงานเขตพื้นที่การศึกษา" ,0,0,'L');
							//$pdf->SetXY($x,$y+floor($row_h*1.5/2.5)); 		$pdf->Cell($x_column[3],floor($row_h/2.5) , "พื้นที่การศึกษา" ,0,0,'L');
							
							$pdf->SetXY($x+=$x_column[2],$y); 	$pdf->Cell($x_column[3],$row_h*3/5 , $position_text ,0,0,'L');
							$pdf->SetXY($x,$y+($row_h*2/6)); 						$pdf->Cell($x_column[3],$row_h*3/5 , "สำนักงานเขตพื้นที่การศึกษา" ,0,0,'L');

							
							
							
							$pdf->SetFont('Angsana New','',14);
						}else{ // ตำแหน่ง 1 บรรทัด
							if(strlen($Row_User[position_now])<=20){  // ไม่เกิน 20 ตัว
								$position_text = $Row_User[position_now] ? $Row_User[position_now] : "ไม่ระบุ" ;
								$pdf->SetXY($x+=$x_column[2],$y); 	$pdf->Cell($x_column[3],$row_h , $position_text ,0,0,'L');
							}else{													// เกิน 20 ตัว
								if(strstr($Row_User[position_now],"ทั่วไป")||strstr($Row_User[position_now],"สถานศึกษา")||strstr($Row_User[position_now],"นโยบายและแผน") ){
									$spos = strpos($Row_User[position_now],"ทั่วไป");
									$spos = strpos($Row_User[position_now],"สถานศึกษา") ? strpos($Row_User[position_now],"สถานศึกษา") : $spos;
									$spos = strpos($Row_User[position_now],"นโยบายและแผน") ? strpos($Row_User[position_now],"นโยบายและแผน") : $spos;
									$slen = strlen($Row_User[position_now]);
									if($spos > 0){
										$position_array[0] = substr($Row_User[position_now],0,$spos);
										$position_array[1] = substr($Row_User[position_now],$spos);
										$pdf->SetXY($x+=$x_column[2],$y); 	$pdf->Cell($x_column[3],$row_h*3/5 , $position_array[0] ,0,0,'L');
										$pdf->SetXY($x,$y+($row_h*2/6)); 						$pdf->Cell($x_column[3],$row_h*3/5 , $position_array[1] ,0,0,'L');
									}
								}else{
										$position_text = $position_text ? $position_text : "ไม่ระบุ";
										if(strlen($Row_User[position_now]) <= 20){
											$pdf->SetXY($x+=$x_column[2],$y); 					$pdf->Cell($x_column[3],$row_h , $Row_User[position_now] ,0,0,'L');	
										}else{
											$arry_pos=$pdf->alignstr($Row_User[position_now],20);
											if(count($arry_pos) > 2){
											$pdf->SetXY($x+=$x_column[2],$y); 	$pdf->Cell($x_column[3],$row_h*3/5 , $arry_pos[0] ,0,0,'L');
											$pdf->SetXY($x,$y+($row_h*2/6)); 						$pdf->Cell($x_column[3],$row_h*3/5 , $arry_pos[1] ,0,0,'L');
											}else{
												$pdf->SetXY($x+=$x_column[2],$y); 	$pdf->Cell($x_column[3],floor($row_h/2.5) , $arry_pos[0] ,0,0,'L');
												$pdf->SetXY($x,$y+floor($row_h*0.85/2.5)); 			$pdf->Cell($x_column[3],floor($row_h/2.5) , $arry_pos[1] ,0,0,'L');
												$pdf->SetXY($x,$y+floor($row_h*1.5/2.5)); 		$pdf->Cell($x_column[3],floor($row_h/2.5) , $arry_pos[2] ,0,0,'L');

											}//end if(count($arry_pos) > 0){
												
										}//end if(strlen($Row_User[position_now]) <= 20){
										
								}
							}
						}
						
	//					// สัญลักษณ์ ไฟล์ต้นฉบับ
	//					$pdf->SetXY($x+=$x_column[3],$y);	$pdf->Cell($x_column[4],$row_h , "",0,0,'C'); // รูป
	//					$pdf->Image($src,$x+4,$y+4,4);

						$false_status = "";
						$false_status = ( $Row_User[status_check_file] =='YES' and $Row_User[status_file] ==0 ) ? "3" : $false_status;
						$false_status = ( $Row_User[status_check_file] =='NO' ) ? "2" : $false_status;
						
						$strSQL="
						SELECT
							tbl_checklist_kp7_false.status_IDCARD,
							tbl_checklist_kp7_false.status_chang_idcard
						FROM tbl_checklist_kp7_false
						WHERE 
						tbl_checklist_kp7_false.idcard = '$Row_User[idcard]' 
						AND
						tbl_checklist_kp7_false.profile_id = '$profile_id' 
						LIMIT 1
						";
						//echo "$strSQL";
						$Result_User_info = mysql_query($strSQL);
						$xnum = @mysql_num_rows($Result_User_info);
						if($xnum>0){
							$Row_User_info = mysql_fetch_assoc($Result_User_info);
							$false_status = ( $Row_User_info[status_IDCARD] =='IDCARD_FAIL' and $Row_User_info[status_chang_idcard] =="NO" ) ? "1" : $false_status;
						}
						
						if(!$false_status){
								$src='img/gnome_pdf.jpg';
								// สัญลักษณ์ ไฟล์ต้นฉบับ
								$pdf->SetXY($x+=$x_column[3],$y);	$pdf->Cell($x_column[4],$row_h , "",0,0,'C'); // รูป
								$pdf->Image($src,$x+4,$y+4,4);
							
								// ที่อยู่ไฟล์
								$path_User_array = explode("/",$path_User);	// PATH FILE
								$pdf->SetFont('Angsana New','',13);					
								$path_1=trim($path_User_array[0])."/";
								$path_2=trim($path_User_array[1]."/".$Row_User[idcard].".pdf");
								$path_2A=trim($path_User_array[1]."/");
								$path_2B=trim($Row_User[idcard].".pdf");		
								
								if(strlen($path_2) <= 38 ){	// ชื่อ 2 บรรทัด
									$pdf->SetFont('Angsana New','',11);	
									if(strlen($path_1) > 36 ){	 $pdf->SetFont('Angsana New','',10);	}
									$pdf->SetXY($x+=$x_column[4],$y);	$pdf->Cell($x_column[5],$row_h/1.5 , $path_1 ,0,0,'L');
									if(strlen($path_2) > 36 ){	 $pdf->SetFont('Angsana New','',10);	}
									$pdf->SetXY($x,$y+($row_h/3));			$pdf->Cell($x_column[5],$row_h/1.5 , $path_2 ,0,0,'L');
									//if(strlen($path_1) > 39 ){	 $pdf->SetFont('Angsana New','',13);	}
									$pdf->SetFont('Angsana New','',13);	
								}else{  								// ชื่อ 3 บรรทัด
									$pdf->SetFont('Angsana New','',11);	
									if(strlen($path_1) > 39 ){	 $pdf->SetFont('Angsana New','',10);	}
									$pdf->SetXY($x+=$x_column[4],$y);	$pdf->Cell($x_column[5],$row_h/1.8 , $path_1 ,0,0,'L');
									if(strlen($path_2A) > 39 ){	 $pdf->SetFont('Angsana New','',9);	}
									$pdf->SetXY($x,$y+($row_h/4));			$pdf->Cell($x_column[5],$row_h/1.8 , $path_2A ,0,0,'L');			
									$pdf->SetFont('Angsana New','',10);	
									$pdf->SetXY($x,$y+($row_h*2/4));			$pdf->Cell($x_column[5],$row_h/1.8 , $path_2B ,0,0,'L');		
									if(strlen($path_1) > 39 ){	 $pdf->SetFont('Angsana New','',13);	}
								}
								$pdf->SetFont('Angsana New','',14);
						}else{
								// สัญลักษณ์ ไฟล์ต้นฉบับ
								$src ="img/alert.jpg";
								$pdf->SetXY($x+=$x_column[3],$y);	$pdf->Cell($x_column[4],$row_h , "",0,0,'C'); // รูป
								$pdf->Image($src,$x+4,$y+4,4);
	
								$path_error="";
								$path_n = 0;
								$path_n = $false_status == 3 ? $path_n+1 : $path_n;
								$path_n = $false_status == 2 ? $path_n+1 : $path_n;
								$path_n = $false_status == 1 ? $path_n+1 : $path_n;
								
							  if($false_status == 3) {  $path_error = "เอกสารไม่สมบูรณ์"; 
								  $pdf->SetXY($x+=$x_column[4],$y+$row_h*($path_n-1)/$path_n);	$pdf->Cell($x_column[5],$row_h/$path_n , $path_error ,0,0,'L');							
							  }
							  if($false_status == 2) {  $path_error = "เอกสารค้างรับ"; 
								  $pdf->SetXY($x+=$x_column[4],$y+$row_h*($path_n-1)/$path_n);	$pdf->Cell($x_column[5],$row_h/$path_n , $path_error ,0,0,'L');							
							  }
							  if($false_status == 1) {  $path_error = "เลขบัตรฯไม่ตรงตามกรมการปกครอง"; 
								  $pdf->SetXY($x+=$x_column[4],$y+$row_h*($path_n-1)/$path_n);	$pdf->Cell($x_column[5],$row_h/$path_n , $path_error ,0,0,'L');							
							}								
						}
					}
					#############################################END Export DATA Record
				}
			}
		}
		}
		##########################END STEP 2 ###################################################		
		#################################################################################
		$file_name = $siteid."_".date("YmdHis"). '.pdf';

		$timeB = microtime() - $timeA;

		$strSQL="
		INSERT INTO $db_temp.`tbl_scanpdf` (`name_page`,`site`,`timeexport`,`start_page`,`end_page`,`time_query`) 
		VALUES ('$file_name','$siteid',NOW(),'$start_page','$last_page','$timeB')
		";
		@mysql_query($strSQL);
		$pdfid = @mysql_insert_id();

		if(is_array($array_page)){
			foreach($array_page as $page => $title){
			$strSQL="
				INSERT INTO `tbl_pdf_centent` SET 
				`type`='genpdf',
				`pdfid`='$pdfid',
				`title`='$title',
				`page`='$page'
			";
			//echo "<pre>$strSQL";
			@mysql_db_query($db_temp,$strSQL);				
			}
		}			
	}
		}
		//$pdf->Output();
		$pdf->Output(  gen_pdf."/".$file_name , 'F' );
		echo "$file_name:#:$start_page:#:$last_page:#:$pdfid:#:".date("Y-m-d H:i:s");
?>