<?
set_time_limit(100);
session_start();
include("../../../config/config_epm.inc.php");

require_once "class.writeexcel_workbook.inc.php";
require_once "class.writeexcel_worksheet.inc.php";
$id_province = "13"; // รหัสจังหวัด
$idcode_sml = "14"; //  รหัสโครงการ sml

$filename = "sml.xls" ;
$fname = tempnam("tmp_export_excel/", $filename);
$workbook =& new writeexcel_workbook($fname);
$worksheet =& $workbook->addworksheet('SML20');
$worksheet2 =& $workbook->addworksheet('SML21');
$worksheet3 =& $workbook->addworksheet('SML22');

$arr_hd1 = array("( 1 ).","( 2 ).","( 3 ).","( 4 ).","( 5 ).","( 6 ).","( 7 ).","( 8 ).","( 9 ).","( 10 ).","( 11 ).","( 12 ) .","( 13 ).","( 14 ).","( 15 ).");

#######################################################################
//---------------Set Style--------------------
$h1center  =& $workbook->addformat(array('font'=>'CordiaUPC','color'=>'white','size'=>22,'fg_color'=>blue,'bold'=>1));
$h1center->set_align('center');
$h1center->set_align('vcenter');
$h1center->set_merge(); # This is the key feature

$h2center  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>20));
$h3center  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>16));

$S_normal_b1  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x09,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1));
$S_normal_b1_cen  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x09,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1));

$S_normal_b0  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'bold'=>1));
$S_normal_comment  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'bold'=>0));
$S_normal_b0_cen  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'bold'=>1));

$S_number  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>9,'fg_color'=>0x38,'bold'=>1,'num_format'=>'#,##0.00'));

$border1 =& $workbook->addformat(array('font'=>'CordiaUPC','color'=>'black','size'=>14,'text_wrap'=>1));
$border1 =& $workbook->addformat();
$border1->set_align('center');
$border1->set_align('vcenter');
$border1->set_merge(); # This is the key feature


$borderk1 =& $workbook->addformat(array('font'=>'CordiaUPC','color'=>'black','size'=>14,'text_wrap'=>1));
$borderk1 =& $workbook->addformat();
$borderk1->set_bottom(1);
$borderk1->set_align('center');
$borderk1->set_align('vcenter');
$borderk1->set_merge(); # This is the key feature


$borderk2 =& $workbook->addformat(array('font'=>'CordiaUPC','color'=>'black','size'=>14,'text_wrap'=>1));
$borderk2 =& $workbook->addformat();
$borderk2->set_top(1);
$borderk2->set_align('center');
$borderk2->set_align('vcenter');
$borderk2->set_merge(); # This is the key feature

$borderk3 =& $workbook->addformat(array('font'=>'CordiaUPC','color'=>'black','size'=>14,'text_wrap'=>1));
$borderk3 =& $workbook->addformat();
$borderk3->set_top(1);
$borderk3->set_right(1);
$borderk3->set_align('center');
$borderk3->set_align('vcenter');
$borderk3->set_merge(); # This is the key feature

$borderk4 =& $workbook->addformat(array('font'=>'CordiaUPC','color'=>'black','size'=>14,'text_wrap'=>1));
$borderk4 =& $workbook->addformat();
$borderk4->set_left(1);
$borderk4->set_bottom(1);
$borderk4->set_align('center');
$borderk4->set_align('vcenter');
$borderk4->set_merge(); # This is the key feature

$borderleft =& $workbook->addformat(array('font'=>'CordiaUPC','color'=>'black','size'=>14,'text_wrap'=>1));
$borderleft =& $workbook->addformat();
$borderleft->set_left(1);
$borderleft->set_align('center');
$borderleft->set_align('vcenter');
$borderleft->set_merge(); # This is the key feature

$borderright =& $workbook->addformat(array('font'=>'CordiaUPC','color'=>'black','size'=>14,'text_wrap'=>1));
$borderright =& $workbook->addformat();
$borderright->set_right(1);
$borderright->set_align('center');
$borderright->set_align('vcenter');
$borderright->set_merge(); # This is the key feature


$border1_1 =& $workbook->addformat(array('font'=>'CordiaUPC','color'=>'black','size'=>14,'text_wrap'=>1));
$border1_1 =& $workbook->addformat();
$border1_1->set_top(1);
$border1_1->set_right(1);
$border1_1->set_left(1);
$border1_1->set_align('center');
$border1_1->set_align('vcenter');
$border1_1->set_merge(); # This is the key feature

$border1_2 =& $workbook->addformat(array('font'=>'CordiaUPC','color'=>'black','size'=>14,'text_wrap'=>1));
$border1_2 =& $workbook->addformat();
$border1_2->set_bottom(1);
$border1_2->set_right(1);
$border1_2->set_left(1);
$border1_2->set_align('center');
$border1_2->set_align('vcenter');
$border1_2->set_merge(); # This is the key feature

$border2 =& $workbook->addformat(array('font'=>'CordiaUPC','color'=>'black','size'=>14,'bold'=>1,'text_wrap'=>1));
$border2 =& $workbook->addformat();
$border2->set_top(1);
$border2->set_bottom(1);
$border2->set_right(1);
$border2->set_left(1);
$border2->set_align('center');
$border2->set_align('vcenter');
$border2->set_merge(); # This is the key feature

$border2_1 =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'bold'=>1,'text_wrap'=>1));
$border2_1 =& $workbook->addformat();
$border2_1->set_top(1);
$border2_1->set_bottom(1);
$border2_1->set_right(1);
$border2_1->set_left(1);

// not set_merge
$border3 =& $workbook->addformat(array('font'=>'CordiaUPC','color'=>'black','size'=>14,'bold'=>1,'text_wrap'=>1));
$border3 =& $workbook->addformat();
$border3->set_top(1);
$border3->set_bottom(1);
$border3->set_right(1);
$border3->set_left(1);
$border3->set_align('center');
$border3->set_align('vcenter');

//---------------- Set Column --------------------
$worksheet->set_column('A:A', 8 );
$worksheet->set_column('B:Q', 12 );

# Create Header
$worksheet->write(1, 1, "ที่................................ลงวันที่..............................", $S_normal_b0);
$worksheet->write_blank(1, 2,$S_normal_b0);
$worksheet->write_blank(1, 3,$S_normal_b0);

$worksheet->write(2, 1, "เรียน ผู้ว่าราชการจังหวัด...........................................", $S_normal_b0);
$worksheet->write_blank(2, 2,$S_normal_b0);
$worksheet->write_blank(2, 3,$S_normal_b0);

$worksheet->write(3, 1, "- เพื่อโปรดทราบผลการดำเนินโครงการ SML ของอำเภอ/เทศบาล............................ดังนี้", $S_normal_b0);
$worksheet->write_blank(3, 2,$S_normal_b0);
$worksheet->write_blank(3, 3,$S_normal_b0);


$worksheet->write(0, 14,"แบบ SML 20",$h1center);
$worksheet->write_blank(0, 15,		$h1center);
$worksheet->write_blank(0, 16,		$h1center);

$worksheet->write_blank(6, 0,		$h1center);
$worksheet->write_blank(6, 1,		$h1center);
$worksheet->write_blank(6, 2,		$h1center);
$worksheet->write_blank(6, 3,		$h1center);
$worksheet->write_blank(6, 4,		$h1center);
$worksheet->write(6, 5,	"งบหน้าการเสนอโครงการพัฒนาศักยภาพของหมู่บ้านและชุมชน (SML) ตามแนวปรัชญาเศรษฐกิจพอเพียง ปี 2551" ,$h1center);
$worksheet->write_blank(6, 6,		$h1center);
$worksheet->write_blank(6, 7,		$h1center);
$worksheet->write_blank(6, 8,      $h1center);
$worksheet->write_blank(6, 9,		$h1center);
$worksheet->write_blank(6, 10,		$h1center);
$worksheet->write_blank(6, 11,		$h1center);
$worksheet->write_blank(6, 12,		$h1center);
$worksheet->write_blank(6, 13,		$h1center);
$worksheet->write_blank(6, 14,		$h1center);
$worksheet->write_blank(6, 15,		$h1center);
$worksheet->write_blank(6, 16,		$h1center);


$worksheet->write_blank(7, 0,		$h2center);
$worksheet->write_blank(7, 1,		$h2center);
$worksheet->write_blank(7, 2,		$h2center);
$worksheet->write_blank(7, 3,		$h2center);
$worksheet->write_blank(7, 4,		$h2center);
$worksheet->write(7, 5, "อำเภอ/เทศบาล.................................................",$h2center);
$worksheet->write_blank(7, 6,		$h2center);
$worksheet->write_blank(7, 7,		$h2center);

$worksheet->write(7, 8, "จังหวัด.......................................",$h2center);
$worksheet->write_blank(7, 9,		$h2center);
$worksheet->write_blank(7, 10,		$h2center);

$worksheet->write(8, 0,"( 1 ).",$border1);
$worksheet->write(8, 1,"( 2 ).",$border1);
$worksheet->write(8, 2,"( 3 ).",$border1);
$worksheet->write(8, 3,"( 4 ).",$border1);
$worksheet->write(8, 4,"( 5 ).",$border1);
$worksheet->write(8, 5,"( 6 ).",$border1);
$worksheet->write(8, 6,"( 7 ).",$border1);
$worksheet->write(8, 7,"( 8 ).",$border1);
$worksheet->write(8, 8,"( 9 ).",$border1);
$worksheet->write(8, 9,"( 10 ).",$border1);
$worksheet->write(8, 10,"( 11 ).",$border1);
$worksheet->write_blank(8, 11,		$border1);
$worksheet->write(8, 12,"( 12 ).",$border1);
$worksheet->write_blank(8, 13,		$border1);
$worksheet->write(8, 14,"( 13).",$border1);
$worksheet->write(8, 15,"( 14 ).",$border1);
$worksheet->write(8, 16,"( 15 ).",$border1);

$worksheet->set_row(9, 50);
$worksheet->write(9, 0,"ลำดับที่",$border1_1);
$worksheet->write(9, 1,"รหัสหมู่บ้าน/ชุมชน",$border1_1);
$worksheet->write(9, 2,"ชื่อหมู่บ้าน/ชุมชน",$border1_1);
$worksheet->write(9, 3,"หมู่ที่",$border1_1);
$worksheet->write(9, 4,"ตำบล",$border1_1);
$worksheet->write(9, 5,"อำเภอ/เทศบาล",$border1_1);
$worksheet->write(9, 6,"จำนวนประชากร 31/12/2550",$border1_1);
$worksheet->write(9, 7,"ขนาด SML",$border1_1);
$worksheet->write(9, 8,"ชื่อโครงการ",$border1_1);
$worksheet->write(9, 9,"งบประมาณ เสนอขอ",$border1_1);
$worksheet->write(9, 10,"ประชาคม",$border2);
$worksheet->write_blank(9, 11,		$border2);
$worksheet->write(9, 12,"นายอำเภอ/นายกเทศมนตรี",$border2);
$worksheet->write_blank(9, 13,		$border2);
$worksheet->write(9, 14,"ชื่อประธานคณะทำงานหมู่บ้าน/ชุมชน",$border1_1);
$worksheet->write(9, 15,"เบอร์โทรศัพท์ประธานคณะทำงาน",$border1_1);
$worksheet->write(9, 16,"หมายเหตุ",$border1_1);

$worksheet->write_blank(10, 0,$border1_2);
$worksheet->write_blank(10, 1,$border1_2);
$worksheet->write_blank(10, 2,$border1_2);
$worksheet->write_blank(10, 3,$border1_2);
$worksheet->write_blank(10, 4,$border1_2);
$worksheet->write_blank(10, 5,$border1_2);
$worksheet->write_blank(10, 6,$border1_2);
$worksheet->write_blank(10, 7,$border1_2);
$worksheet->write_blank(10, 8,$border1_2);
$worksheet->write_blank(10, 9,$border1_2);
$worksheet->write(10, 10,"ผ่าน",$border3);
$worksheet->write(10, 11,"ไม่ผ่าน",$border3);
$worksheet->write(10, 12,"รับรองผลประชาคม",$border3);
$worksheet->write(10, 13,"รับรองคณะทำงาน",$border3);
$worksheet->write_blank(10, 14,$border1_2);
$worksheet->write_blank(10, 15,$border1_2);
$worksheet->write_blank(10, 16,$border1_2);


//==== DATA =============
$i = 1;
$n=11;
$sql = " SELECT *  FROM epm_detail LEFT JOIN sml_procedure ON epm_detail.epm_id = sml_procedure.epm_id where epm_detail.policy_id = '$idcode_sml' ";
$query = mysql_query($sql);
while($rs = mysql_fetch_assoc($query)){
		$strSQL = "SELECT * FROM  village_latlong WHERE  VILL_CODE = '$rs[project_area_id]'";
		$Result = mysql_query($strSQL);
		$Rsv = mysql_fetch_assoc($Result);
		$source_name = "$Rsv[VILL_NAME]";
		$find_name = "หมู่ที่";
		$ch_post = strrpos($source_name,$find_name);
		if($ch_post === false){  $moo = " "; }else{  $moo = str_replace("หมู่ที่","","$Rsv[VILL_NAME]");}
		
		// เงื่อนไขการแสดงผล ขนาด SML 
		$peple_num = "$rs[peple_num]";
		if($peple_num <= 50){ 
			$sml = "S1";
		}else if(($peple_num >= 52) and ($peple_num <= 150)){
			 $sml = "S2";
		 }else if(($peple_num >= 151) and ($peple_num <= 250)){
		 	$sml = "S3";
		 }else if(($peple_num >= 251) and ($peple_num <= 500)){
		 	$sml = "S";
		 }else if(($peple_num >= 501) and ($peple_num <= 1000)){
		 	$sml = "M";
		 }else if(($peple_num >= 1001) and ($peple_num <= 1500)){
		 	$sml = "L";
		 }else {
		 	$sml = "XL";
		 }	
		// งบประมาณในการลงทุน
		$budget = "$rs[budget_nm]";
		// การรับรองผลประชาคม
		if($rs[community_status] == 1){ $commu_status = " / ";}else{ $commu_status = " ";}
		if($rs[community_status] == 0){ $commu_false = " / ";}else{ $commu_false = " ";}
		if($rs[approve_comm] == 1){ $approve_c = " / ";}else{ $approve_c = " "; }
		if($rs[approve_work] == 1){ $approve_w = " / ";}else{ $approve_w = " ";}
		$chairman= "$rs[chairman]";
		$tel = "$rs[tel]";
		$comment = "$rs[comment]";
		$total_budget += $budget;

	$worksheet->write($n, 0," $i ",$border2);
	$worksheet->write($n, 1," $Rsv[VILLAGE_ID] ",$border2);
	$worksheet->write($n, 2," $source_name ",$border2);
	$worksheet->write($n, 3," $moo ",$border2);
	$worksheet->write($n, 4," $Rsv[TAM_NAME] ",$border2);
	$worksheet->write($n, 5," $Rsv[AMP_NAME] ",$border2);
	$worksheet->write($n, 6," $rs[peple_num] ",$border2);
	$worksheet->write($n, 7," $sml ",$border2);
	$worksheet->write($n, 8," $rs[projectname] ",$border2);
	$worksheet->write($n, 9," $budget ",$border2);
	$worksheet->write($n, 10," $commu_status ",$border2);
	$worksheet->write($n, 11," $commu_false ",$border2);
	$worksheet->write($n, 12," $approve_c ",$border2);
	$worksheet->write($n, 13," $approve_w ",$border2);
	$worksheet->write($n, 14," $chairman ",$border2);
	$worksheet->write($n, 15," $tel ",$border2);
	$worksheet->write($n, 16," $comment ",$border2);

$i++;
$n++;
}
// ผลรวมงบประมาณในโครงการ
$rowx = $n;
	$worksheet->write($rowx, 8," รวม ",$border2);
	$worksheet->write($rowx, 9," $total_budget  ",$border2);
// end ผลรวมงบประมาณในโครงการ
// ลงชื่อ.................................................
$rowx += 1; 
$rowx = $rowx+1;
$worksheet->write($rowx, 8, "ลงชื่อ...............................................................",$S_normal_b0);
$rowx = $rowx+1;
$worksheet->write($rowx, 8, "นายอำเภอ/นายกเทศมนตรี..................................",$S_normal_b0);

// หมายเหตุ

$rowx = $rowx+2;
$worksheet->write($rowx, 0, "หมายเหตุ  หากไม่มีการลงลายมือชื่อของนายอำเภอ/นายกเทศมนตรีอาจเป็นเหตุทำให้หมู่บ้าน/ชุมชนไม่ได้รับการพิจารณาอนุมัติโครงการและไม่ได้รับการจัดสรรงบประมาณ",$S_normal_comment);

//================================================ worksheet2===========================================
$arr_txtsml = array(
"S1" => array(" ไม่เกิน 50 คน"=>"50,000"),
"S2" => array(" 51-150 คน"=>"100,000"),
"S3" => array("151-250 คน"=>"150,000"),
"S" => array(" 251-500 คน"=>"200,000"),
"M" => array("501-1,000 คน"=>"250,000"),
"L" => array("1,001-1,500 คน"=>"300,000"),
"XL" => array("1,501 คนขึ้นไป"=>"350,000")
);

//---------------- Set Column --------------------
$worksheet2->set_column('A:A', 8 );
$worksheet2->set_column('B:Q', 12 );

# Create Header
$worksheet2->write(1, 1, "ที่................................ลงวันที่..............................", $S_normal_b0);
$worksheet2->write_blank(1, 2,$S_normal_b0);
$worksheet2->write_blank(1, 3,$S_normal_b0);

$worksheet2->write(2, 1, "เรียน ผู้ว่าราชการจังหวัด...........................................", $S_normal_b0);
$worksheet2->write_blank(2, 2,$S_normal_b0);
$worksheet2->write_blank(2, 3,$S_normal_b0);

$worksheet2->write(3, 1, "- เพื่อโปรดทราบผลการดำเนินโครงการ SML ของอำเภอ/เทศบาล............................ดังนี้", $S_normal_b0);
$worksheet2->write_blank(3, 2,$S_normal_b0);
$worksheet2->write_blank(3, 3,$S_normal_b0);


$worksheet2->write(0, 18,"แบบ SML 21",$h1center);
$worksheet2->write_blank(0, 19,		$h1center);
$worksheet2->write_blank(0, 20,		$h1center);

$worksheet2->write_blank(6, 0,		$h1center);
$worksheet2->write(6, 1,"สรุปภาพรวมการเสนอโครงการ SML",$h1center);
$worksheet2->write_blank(6, 2,		$h1center);
$worksheet2->write_blank(6, 3, 		$h1center);
$worksheet2->write_blank(6, 4,		$h1center);
$worksheet2->write_blank(6, 5,		$h1center);
$worksheet2->write_blank(6, 6,		$h1center);
$worksheet2->write_blank(6, 7,		$h1center);
$worksheet2->write_blank(6, 8, 		$h1center);
$worksheet2->write_blank(6, 9,		$h1center);
$worksheet2->write_blank(6, 10,		$h1center);
$worksheet2->write_blank(6, 11,		$h1center);
$worksheet2->write_blank(6, 12,		$h1center);
$worksheet2->write_blank(6, 13,		$h1center);
$worksheet2->write_blank(6, 14,		$h1center);
$worksheet2->write_blank(6, 15,		$h1center);
$worksheet2->write_blank(6, 16,		$h1center);
$worksheet2->write_blank(6, 17,		$h1center);
$worksheet2->write_blank(6, 18,		$h1center);
$worksheet2->write_blank(6, 19,		$h1center);
$worksheet2->write_blank(6, 20,		$h1center);

$worksheet2->write_blank(7, 0,		$h2center);
$worksheet2->write_blank(7, 1,		$h2center);
$worksheet2->write_blank(7, 2,		$h2center);
$worksheet2->write_blank(7, 3,		$h2center);
$worksheet2->write_blank(7, 4,		$h2center);
$worksheet2->write(7, 7, "อำเภอ/เทศบาล.........................................",$h2center);
$worksheet2->write_blank(7, 8,		$h2center);
$worksheet2->write_blank(7, 9,		$h2center);

$worksheet2->write(7, 10, "วันที่........................................................",$h2center);
$worksheet2->write_blank(7, 11,		$h2center);
$worksheet2->write_blank(7, 12,		$h2center);

$worksheet2->write(8, 0,"  ",$border1_1);
$worksheet2->write(8, 1,"  ",$border1_1);
$worksheet2->write(8, 2," เงิน",$border1_1);
$worksheet2->write(8, 3," ฐานข้อมูลของอำเภอ/เทศบาล ",$borderk2);
$worksheet2->write_blank(8, 4,		$borderk2);
$worksheet2->write_blank(8, 5,		$borderk2);
$worksheet2->write_blank(8, 6,        $borderk3);
$worksheet2->write(8, 7," ข้อมูลที่เสนอโครงการครั้งนี้ (ครั้งที่..................) ",$borderk2);
$worksheet2->write_blank(8, 8,		$borderk2);
$worksheet2->write_blank(8, 9,		$borderk2);
$worksheet2->write_blank(8, 10,		$borderk2);
$worksheet2->write_blank(8, 11,		$borderk3);
$worksheet2->write(8, 12," ยอดรวมครั้งที่ผ่านมารวมกับครั้งนี้ ",$borderk2);
$worksheet2->write_blank(8, 13,		$borderk2);
$worksheet2->write_blank(8, 14,		$borderk2);
$worksheet2->write_blank(8, 15,		$borderk2);
$worksheet2->write_blank(8, 16,		$borderk3);
$worksheet2->write(8, 17," คงเหลือหมู่บ้าน/ชุมชนที่ยังไม่ได้เสนอโครงการ ",$borderk2);
$worksheet2->write_blank(8, 18,		$borderk2);
$worksheet2->write_blank(8, 19,		$borderk2);
$worksheet2->write_blank(8, 20,		$borderk3);

$worksheet2->write(9, 0," ขนาด ",$borderleft);
$worksheet2->write(9, 1," จำนวนประชากร ",$borderleft);
$worksheet2->write(9, 2," งบประมาณ ",$borderleft);
$worksheet2->write(9, 3," หมู่บ้าน ",$border1_1);
$worksheet2->write(9, 4," ชุมชน ", $border1_1);
$worksheet2->write(9, 5," รวม ", $border1_1);
$worksheet2->write(9, 6," งบประมาณ ", $border1_1);
$worksheet2->write(9, 7," หมู่บ้าน ",$border1_1);
$worksheet2->write(9, 8," ชุมชน ",$border1_1);
$worksheet2->write(9, 9," รวม ", $border1_1);
$worksheet2->write(9, 10," จำนวน", $border1_1);
$worksheet2->write(9, 11,	"งบประมาณ ",$border1_1);
$worksheet2->write(9, 12," หมู่บ้าน ",$border1_1);
$worksheet2->write(9, 13,	" ชุมชน ",	$border1_1);
$worksheet2->write(9, 14,	" รวม ",	$border1_1);
$worksheet2->write(9, 15,	" จำนวน ",$border1_1);
$worksheet2->write(9, 16,	" งบประมาณ ",	$border1_1);
$worksheet2->write(9, 17," หมู่บ้าน ",$border1_1);
$worksheet2->write(9, 18,	" ชุมชน ",	$border1_1);
$worksheet2->write(9, 19,	" รวม ", $border1_1);
$worksheet2->write(9, 20,	" งบประมาณ ", $border1_1);


$worksheet2->write(10, 0,"  ",$border1_2);
$worksheet2->write(10, 1,"  ",$border1_2);
$worksheet2->write(10, 2," (บาท) ",$border1_2);
$worksheet2->write(10, 3,"  ",$border1_2);
$worksheet2->write(10, 4,"  ", $border1_2);
$worksheet2->write(10, 5,"  ", $border1_2);
$worksheet2->write(10, 6,"  ", $border1_2);
$worksheet2->write(10, 7,"  ",$border1_2);
$worksheet2->write(10, 8,"  ",$border1_2);
$worksheet2->write(10, 9,"  ", $border1_2);
$worksheet2->write(10, 10," โครงการ", $border1_2);
$worksheet2->write(10, 11,	" ",$border1_2);
$worksheet2->write(10, 12,"  ",$border1_2);
$worksheet2->write(10, 13,	"  ",	$border1_2);
$worksheet2->write(10, 14,	"  ",	$border1_2);
$worksheet2->write(10, 15,	" โครงการ ",$border1_2);
$worksheet2->write(10, 16,	"  ",	$border1_2);
$worksheet2->write(10, 17,"  ",$border1_2);
$worksheet2->write(10, 18,	"  ",	$border1_2);
$worksheet2->write(10, 19,	"  ", $border1_2);
$worksheet2->write(10, 20,	"  ", $border1_2);

$n=11;
//==== DATA =============
foreach($arr_txtsml as $key => $val){
	foreach($val as $key1 => $val1){		
	if($key == "S1"){	
	$strSQL_b2 = "SELECT COUNT(*) AS sml_num, sum(budget_nm) as sum_budget FROM epm_detail LEFT JOIN sml_procedure ON epm_detail.epm_id = sml_procedure.epm_id  WHERE epm_detail.policy_id =  '$idcode_sml' AND sml_procedure.peple_num BETWEEN  '0' AND '50' group by epm_detail.project_area_id";
	}else if($key == "S2"){
	$strSQL_b2 = "SELECT COUNT(*) AS sml_num, sum(budget_nm) as sum_budget FROM epm_detail LEFT JOIN sml_procedure ON epm_detail.epm_id = sml_procedure.epm_id  WHERE epm_detail.policy_id =  '$idcode_sml' AND sml_procedure.peple_num BETWEEN  '51' AND '150'  group by epm_detail.project_area_id";
	}else if($key == "S3"){
	$strSQL_b2 = "SELECT COUNT(*) AS sml_num, sum(budget_nm) as sum_budget FROM epm_detail LEFT JOIN sml_procedure ON epm_detail.epm_id = sml_procedure.epm_id  WHERE epm_detail.policy_id = '$idcode_sml' AND sml_procedure.peple_num BETWEEN  '151' AND '250'  group by epm_detail.project_area_id";
	}else if($key == "S"){
	$strSQL_b2 = "SELECT COUNT(*) AS sml_num, sum(budget_nm) as sum_budget FROM epm_detail LEFT JOIN sml_procedure ON epm_detail.epm_id = sml_procedure.epm_id  WHERE epm_detail.policy_id = '$idcode_sml' AND sml_procedure.peple_num BETWEEN  '251' AND '500' group by epm_detail.project_area_id";
	}else if($key == "M"){
	$strSQL_b2 = "SELECT COUNT(*) AS sml_num, sum(budget_nm) as sum_budget FROM epm_detail LEFT JOIN sml_procedure ON epm_detail.epm_id = sml_procedure.epm_id  WHERE epm_detail.policy_id = '$idcode_sml' AND sml_procedure.peple_num BETWEEN  '501' AND '1000' group by epm_detail.project_area_id";
	}else if($key == "L"){
	$strSQL_b2 = "SELECT COUNT(*) AS sml_num, sum(budget_nm) as sum_budget FROM epm_detail LEFT JOIN sml_procedure ON epm_detail.epm_id = sml_procedure.epm_id  WHERE epm_detail.policy_id =  '$idcode_sml' ANDsml_procedure.peple_num BETWEEN  '1001' AND '1500' group by epm_detail.project_area_id";
	}else{
$strSQL_b2 = "SELECT COUNT(*) AS sml_num, sum(budget_nm) as sum_budget FROM epm_detail LEFT JOIN sml_procedure ON epm_detail.epm_id = sml_procedure.epm_id  WHERE epm_detail.policy_id =  '$idcode_sml' AND sml_procedure.peple_num >  1500 group by epm_detail.project_area_id";
	}
	$Result_b2 = mysql_query($strSQL_b2);
	$Rs_b2 = @mysql_fetch_assoc($Result_b2);
	$shumchoon = "0";
	$sml_num = number_format($Rs_b2[sml_num]);// จำนวนหหมู่บ้าน
	$sml_num1 = number_format($shumchoon);
	$total_num = $sml_num + $sml_num1;
	$sum_budget = number_format($Rs_b2[sum_budget]);

	$worksheet2->write($n, 0," $key ",$border2);
	$worksheet2->write($n, 1,"  $key1 ",$border2);
	$worksheet2->write($n, 2,"  $val1 ",$border2);
	$worksheet2->write($n, 3,"  $sml_num ",$border2);
	$worksheet2->write($n, 4," $sml_num1 ",$border2);
	$worksheet2->write($n, 5," $total_num ",$border2);
	$worksheet2->write($n, 6," $sum_budget ",$border2);
	$worksheet2->write($n, 7,"  ",$border2);
	$worksheet2->write($n, 8,"  ",$border2);
	$worksheet2->write($n, 9,"  ",$border2);
	$worksheet2->write($n, 10,"  ",$border2);
	$worksheet2->write($n, 11,"  ",$border2);
	$worksheet2->write($n, 12," ",$border2);
	$worksheet2->write($n, 13,"  ",$border2);
	$worksheet2->write($n, 14,"  ",$border2);
	$worksheet2->write($n, 15,"  ",$border2);
	$worksheet2->write($n, 16,"  ",$border2);
	$worksheet2->write($n, 17,"  ",$border2);
	$worksheet2->write($n, 18,"  ",$border2);
	$worksheet2->write($n, 19,"  ",$border2);
	$worksheet2->write($n, 20,"  ",$border2);

$n++;
	}
}


//// ลงชื่อ.................................................
$txt1 = " ( 1 ) ";
$txt2 = " ( 2 ) ";
$txt3 = " ( 3 ) ";
$txt4 = " ( 4 ) ";
$rowx += 2 ; 
$worksheet2->write($rowx, 4, " $txt1 ",$h2center);
$worksheet2->write($rowx, 9, " $txt2 ",$h2center);
$worksheet2->write($rowx, 14, " $txt3 ",$h2center);
$worksheet2->write($rowx, 19, " $txt4 ",$h2center);

$rowx = $rowx+2;
$worksheet2->write($rowx, 8, "ลงชื่อ...............................................................",$S_normal_b0);
$rowx = $rowx+1;
$worksheet2->write($rowx, 8, "นายอำเภอ/นายกเทศมนตรี..................................",$S_normal_b0);

//// หมายเหตุ h3center
$rowx = $rowx+2;
$worksheet2->write($rowx, 0, "คำอธิบาย",$S_normal_b0);
$rowx = $rowx+1;
$worksheet2->write($rowx, 1, " $txt1 หมายถึง ข้อมูลที่อำเภอ/เทศบาลตรวจสอบยืนยันและรายงานให้จังหวัดทราบเป็นครั้งสุดท้าย ณ วันที่ 21 เมษายน 2551 ฐานข้อมูลอำเภอ/เทศบาลต้องคงที่ไม่",$S_normal_comment);
$rowx = $rowx+1;
$worksheet2->write($rowx, 1, " $txt2 หมายถึง จำนวนหมู่บ้าน/ชุมชน โครงการ และงบประมาณที่อำเภอ/เทศบาลรายงานต่อจังหวัดในครั้งนี้",$S_normal_comment);
$rowx = $rowx+1;
$worksheet2->write($rowx, 1, " $txt3 หมายถึง จำนวนหมู่บ้าน/ชุมชน โครงการ งบประมาณ ที่ได้รายงานจังหวัดไปแล้วทั้งหมดรวมกับจำนวนหมู่บ้าน/ชุมชน โครงการ งบประมาณ ตาม $txt2 ",$S_normal_comment);
$rowx = $rowx+1;
$worksheet2->write($rowx, 1, " $txt4 หมายถึง จำนวนหมู่บ้าน/ชุมชน ที่ยังไม่ได้เสนอโครงการ $txt4 = $txt1 - $txt3 ",$S_normal_comment);

//================================================ worksheet3 ===========================================
//---------------- Set Column --------------------
$worksheet3->set_column('A:A', 8 );
$worksheet3->set_column('B:Q', 12 );

# Create Header
$worksheet3->write(1, 1, "ที่................................ลงวันที่..............................", $S_normal_b0);
$worksheet3->write_blank(1, 2,$S_normal_b0);
$worksheet3->write_blank(1, 3,$S_normal_b0);

$worksheet3->write(2, 1, " เรียน อธิบดีกรมการปกครอง", $S_normal_b0);
$worksheet3->write_blank(2, 2,$S_normal_b0);
$worksheet3->write_blank(2, 3,$S_normal_b0);

$worksheet3->write(2, 10, " ส่งครั้งที่ .............", $S_normal_b0);

$worksheet3->write(3, 1, "-  เพื่อโปรดทราบผลการดำเนินโครงการ SML ของจังหวัด..........................ดังนี้", $S_normal_b0);
$worksheet3->write_blank(3, 2,$S_normal_b0);
$worksheet3->write_blank(3, 3,$S_normal_b0);


$worksheet3->write(0, 10,"แบบ SML 22",$h1center);
$worksheet3->write_blank(0, 11,		$h1center);
$worksheet3->write_blank(0, 12,		$h1center);

$worksheet3->write_blank(5, 0,		$h1center);
$worksheet3->write(5, 1, "สรุปงบหน้าโครงการพัฒนาศักยภาพของหมู่บ้านและชุมชน (SML) ตามแนวปรัชญาเศรษฐกิจพอเพียง ปี 2551",	$h1center);
$worksheet3->write_blank(5, 2,		$h1center);
$worksheet3->write_blank(5, 3,		$h1center);
$worksheet3->write_blank(5, 4,		$h1center);
$worksheet3->write_blank(5, 5,		$h1center);
$worksheet3->write_blank(5, 6,		$h1center);
$worksheet3->write_blank(5, 7,		$h1center);
$worksheet3->write_blank(5, 8, 		$h1center);
$worksheet3->write_blank(5, 9,		$h1center);
$worksheet3->write_blank(5, 10,		$h1center);
$worksheet3->write_blank(5, 11,		$h1center);
$worksheet3->write_blank(5, 12,		$h1center);


$worksheet3->write_blank(6, 0,		$h2center);
$worksheet3->write_blank(6, 1,		$h2center);
$worksheet3->write_blank(6, 2,		$h2center);
$worksheet3->write_blank(6, 3,		$h2center);
$worksheet3->write_blank(6, 4,		$h2center);
$worksheet3->write(6, 5, "จังหวัด.......................................",$h2center);
$worksheet3->write_blank(6, 6,		$h2center);
$worksheet3->write_blank(6, 7,		$h2center);

$worksheet3->write(7, 4, " วันที่.....................เดือน........................พ.ศ........................... ",$h2center);
$worksheet3->write_blank(7, 5,		$h2center);
$worksheet3->write_blank(7, 6,		$h2center);

$worksheet3->write(8, 0," ลำดับที่ ",$border1_1);
$worksheet3->write(8, 1," อำเภอ/เทศบาล ",$border1_1);
$worksheet3->write(8, 2," จำนวนหมู่บ้าน/ชุมชน เสนอโครงการ ",$borderk2);
$worksheet3->write_blank(8, 3,		$borderk2);
$worksheet3->write_blank(8, 4,		$borderk2);
$worksheet3->write_blank(8, 5, 		$borderk2);
$worksheet3->write_blank(8, 6, 		$borderk2);
$worksheet3->write_blank(8, 7, 		$borderk2);
$worksheet3->write_blank(8, 8, 		$borderk2);
$worksheet3->write_blank(8, 9, 		$borderk3);
$worksheet3->write(8, 10," จำนวนโครงการ ",$border1_1);
$worksheet3->write(8, 11,	" งบประมาณ ", $border1_1);
$worksheet3->write(8, 12," หมายเหตุ ",$border1_1);

$worksheet3->write_blank(9, 0,		$border1_2);
$worksheet3->write_blank(9, 1,		$border1_2);
$worksheet3->write(9, 2," S1 ",$border2);
$worksheet3->write(9, 3," S2 ",$border2);
$worksheet3->write(9, 4," S3 ",$border2);
$worksheet3->write(9, 5," S ",$border2);
$worksheet3->write(9, 6," M ",$border2);
$worksheet3->write(9, 7," L ",$border2);
$worksheet3->write(9, 8," XL ",$border2);
$worksheet3->write(9, 9," รวมทั้งสิ้น",$border2);
$worksheet3->write(9, 10," ทั้งสิ้น",$border2);
$worksheet3->write(9, 11, " ทั้งสิ้น", $border2);
$worksheet3->write(9, 12,	"  ", $border1_2);

$m=10;

//==== DATA =============
$strSQL_sheet3 = "SELECT ccaa.ccDigi, SUBSTRING(ccaa.ccDigi, 1, 4) AS area_id, ccaa.ccName FROM ccaa  WHERE ccaa.ccDigi LIKE '$id_province%' AND SUBSTRING(ccaa.ccDigi,1,2) IN($id_province)  AND ccName NOT LIKE '%*%'  AND ccName NOT LIKE '%จังหวัด%'GROUP BY area_id ";
$Result_sheet3 = mysql_query($strSQL_sheet3);
$kk = 1;
while($Rs_st3 = mysql_fetch_assoc($Result_sheet3)){
$strSQL_sml1= "SELECT * FROM epm_detail LEFT JOIN sml_procedure ON epm_detail.epm_id = sml_procedure.epm_id where epm_detail.policy_id = '$idcode_sml'  AND epm_detail.project_area_id LIKE '$Rs_st3[area_id]%' AND (sml_procedure.peple_num  <= 50) ";
$Result_sml1 = mysql_query($strSQL_sml1);
$sml1 = @mysql_num_rows($Result_sml1);

$strSQL_sml2= "SELECT * FROM epm_detail LEFT JOIN sml_procedure ON epm_detail.epm_id = sml_procedure.epm_id where epm_detail.policy_id = '$idcode_sml'  AND epm_detail.project_area_id LIKE '$Rs_st3[area_id]%' AND (sml_procedure.peple_num BETWEEN  '51' AND '150') ";
$Result_sml2 = mysql_query($strSQL_sml2);
$sml2 = @mysql_num_rows($Result_sml2);

$strSQL_sml3= "SELECT * FROM epm_detail LEFT JOIN sml_procedure ON epm_detail.epm_id = sml_procedure.epm_id where epm_detail.policy_id = '$idcode_sml'  AND epm_detail.project_area_id LIKE '$Rs_st3[area_id]%' AND (sml_procedure.peple_num BETWEEN  '151' AND '250') ";
$Result_sml3 = mysql_query($strSQL_sml3);
$sml3 = @mysql_num_rows($Result_sml3);

$strSQL_sml4= "SELECT * FROM epm_detail LEFT JOIN sml_procedure ON epm_detail.epm_id = sml_procedure.epm_id where epm_detail.policy_id = '$idcode_sml'  AND epm_detail.project_area_id LIKE '$Rs_st3[area_id]%' AND (sml_procedure.peple_num BETWEEN  '251' AND '500') ";
$Result_sml4 = mysql_query($strSQL_sml4);
$sml4 = @mysql_num_rows($Result_sml4);

$strSQL_sml5= "SELECT * FROM epm_detail LEFT JOIN sml_procedure ON epm_detail.epm_id = sml_procedure.epm_id where epm_detail.policy_id = '$idcode_sml'  AND epm_detail.project_area_id LIKE '$Rs_st3[area_id]%' AND (sml_procedure.peple_num BETWEEN  '501' AND '1000') ";
$Result_sml5 = mysql_query($strSQL_sml5);
$sml5 = @mysql_num_rows($Result_sml5);

$strSQL_sml6= "SELECT * FROM epm_detail LEFT JOIN sml_procedure ON epm_detail.epm_id = sml_procedure.epm_id where epm_detail.policy_id = '$idcode_sml'  AND epm_detail.project_area_id LIKE '$Rs_st3[area_id]%' AND (sml_procedure.peple_num BETWEEN  '1001' AND '1500') ";
$Result_sml6 = mysql_query($strSQL_sml6);
$sml6 = @mysql_num_rows($Result_sml6);

$strSQL_sml7= "SELECT * FROM epm_detail LEFT JOIN sml_procedure ON epm_detail.epm_id = sml_procedure.epm_id where epm_detail.policy_id = '$idcode_sml'  AND epm_detail.project_area_id LIKE '$Rs_st3[area_id]%' AND (sml_procedure.peple_num > 1500) ";
$Result_sml7 = mysql_query($strSQL_sml7);
$sml7 = @mysql_num_rows($Result_sml7);

$money_project = "SELECT sum(epm_detail.budget_nm) as money_use FROM epm_detail LEFT JOIN sml_budget ON epm_detail.epm_id=sml_budget.epm_id  
WHERE epm_detail.project_area_id LIKE '$Rs_st3[area_id]%' AND  epm_detail.policy_id = '$idcode_sml' ";
$Result_porject = mysql_query($money_project);
$Rs_money = mysql_fetch_assoc($Result_porject);
$budget_use = number_format($Rs_money[money_use]);

$sml_total  = $sml1+$sml2+$sml3+$sml4+$sml5+$sml6+$sml7;
$sml_project = $sml1+$sml2+$sml3+$sml4+$sml5+$sml6+$sml7;
$total_s1 += $sml1;
$total_s2 += $sml2;
$total_s3 += $sml3;
$total_s4 += $sml4;
$total_s5 += $sml5;
$total_s6 += $sml6;
$total_s7 += $sml7;
$total_sml_total += $sml_total;
$total_sml_project += $sml_project;
$total_budget += $budget_use;


	$worksheet3->write($m, 0, " $kk ", $border2);
	$worksheet3->write($m, 1, " $Rs_st3[ccName] ", $border2_1);
	$worksheet3->write($m, 2," $sml1 ",$border2);
	$worksheet3->write($m, 3," $sml2 ",$border2);
	$worksheet3->write($m, 4," $sml3 ",$border2);
	$worksheet3->write($m, 5," $sml4 ",$border2);
	$worksheet3->write($m, 6," $sml5 ",$border2);
	$worksheet3->write($m, 7," $sml6 ",$border2);
	$worksheet3->write($m, 8," $sml7 ",$border2);
	$worksheet3->write($m, 9," $sml_total ",$border2);
	$worksheet3->write($m, 10," $sml_project ",$border2);
	$worksheet3->write($m, 11, " $budget_use ", $border2);
	$worksheet3->write($m, 12,	"  ", $border2);

	$kk++;
	$m++;

}
// ผลรวม
$rowx = $m;
$total_budget = number_format($total_budget);
	$worksheet3->write($rowx, 0, "  ", $border2);
	$worksheet3->write($rowx ,1, " รวม ", $border2);
	$worksheet3->write($rowx, 2," $total_s1 ",$border2);
	$worksheet3->write($rowx, 3," $total_s2 ",$border2);
	$worksheet3->write($rowx, 4," $total_s3 ",$border2);
	$worksheet3->write($rowx, 5," $total_s4 ",$border2); 
	$worksheet3->write($rowx, 6," $total_s5 ",$border2);
	$worksheet3->write($rowx, 7," $total_s6 ",$border2);
	$worksheet3->write($rowx, 8," $total_s7 ",$border2);
	$worksheet3->write($rowx ,9," $total_sml_total ",$border2);
	$worksheet3->write($rowx, 10," $total_sml_project  ",$border2);
	$worksheet3->write($rowx, 11, " $total_budget ", $border2);
	$worksheet3->write($rowx, 12,	"  ", $border2);

// ลงชื่อ.................................................
$rowx += 1; 
$rowx = $rowx+1;
$worksheet3->write($rowx, 8, "ลงชื่อ...............................................................",$S_normal_b0);
$rowx = $rowx+1;
$worksheet3->write($rowx, 8, "นายอำเภอ/นายกเทศมนตรี..................................",$S_normal_b0);

// หมายเหตุ

$rowx = $rowx+2;
$worksheet3->write($rowx, 0, "หมายเหตุ ",$S_normal_b0);
$worksheet3->write($rowx, 1, " การรายงานของจังหวัดในแบบ SML 22  ให้นำข้อมูลจาก  $txt2   ของแบบ SML 21 ของทุกอำเภอ/เทศบาล มารายงานเท่านั้นโดยไม่ต้องสะสมยอด",$h3center);
$workbook->close();

/*
header("Content-Type: application/x-msexcel; name=\"sml.xls\"");
header("Content-Disposition: inline; filename=\"sml.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
//unlink($fname);
*/
$fh=fopen($fname, "rb");
$contents = fread($fh,filesize($fname));
$dlfile=fopen("tmp_export_excel/$filename", "w");
$w = fwrite($dlfile,$contents);
fclose($dlfile);

header("location: tmp_export_excel/$filename");
die;
?>