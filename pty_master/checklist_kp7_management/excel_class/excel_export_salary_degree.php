<?
set_time_limit(0);
session_start();
include("../../../config/conndb_nonsession.inc.php");
include("../function.php");

require_once "class.writeexcel_workbook.inc.php";
require_once "class.writeexcel_worksheet.inc.php";

$filename = "salary_profile_".date('Ymd').".xls" ;

$fname = tempnam("tmp_export_excel/", $filename);
$workbook =& new writeexcel_workbook($fname);
$worksheet =& $workbook->addworksheet('salary_profile');

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

$header_middle =& $workbook->addformat(array('font'=>'CordiaUPC','color'=>'black','size'=>14,'text_wrap'=>1));
$header_middle =& $workbook->addformat();
$header_middle->set_size(9);
$header_middle->set_top(1);
$header_middle->set_left(1);
$header_middle->set_right(1);
//$header_middle->set_bottom(0);
$header_middle->set_align('center');
$header_middle->set_align('vcenter');
$header_middle->set_merge(); # This is the key feature
	
$header_bottom =& $workbook->addformat(array('font'=>'CordiaUPC','color'=>'black','size'=>14,'text_wrap'=>1));
$header_bottom =& $workbook->addformat();
$header_bottom->set_size(9);
//$header_bottom->set_top(0);
$header_bottom->set_left(1);
$header_bottom->set_right(1);
$header_bottom->set_bottom(1);
$header_bottom->set_align('center');
$header_bottom->set_align('vcenter');
//$header_middle->set_merge(); # This is the key feature

$body_bottom =& $workbook->addformat(array('font'=>'CordiaUPC','color'=>'black','size'=>14,'text_wrap'=>1));
$body_bottom =& $workbook->addformat();
$body_bottom->set_size(9);
$body_bottom->set_top(1);
$body_bottom->set_left(1);
$body_bottom->set_right(1);
$body_bottom->set_bottom(1);
$body_bottom->set_align('center');
$body_bottom->set_align('vcenter');

###############   ข้อมูล profile
$sql_profile = "SELECT * FROM tbl_salary_profile WHERE profile_id='$profile_id'";
$result_profile = mysql_db_query($dbnamemaster,$sql_profile);
$rs_profile = mysql_fetch_assoc($result_profile);

//---------------- Set Column --------------------
$worksheet->set_column('A:A', 15 );
$worksheet->set_column('B:B', 20 );
$worksheet->set_column('C:C', 20 );
$worksheet->set_column('D:D', 15 );
$worksheet->set_column('E:E', 15 );
#BEGIN Header
$worksheet->write(1, 0, $rs_profile['profile'], $S_normal_b0);
#END Header

#BEGIN Body Information
	$xlsRow = 5;
	$worksheet->write('A'.$xlsRow, 'ประเภทตำแหน่ง', $header_middle);
	$worksheet->write('B'.$xlsRow, 'ระดับ', $header_middle);
	$worksheet->write('C'.$xlsRow, 'ช่วงเงินเดือน', $header_middle);
	$worksheet->write('D'.$xlsRow, 'ฐานในการคำนวณ', $header_middle);
	$worksheet->write('E'.$xlsRow, '', $header_middle);
	
	$xlsRow = 6;
	$worksheet->write('A'.$xlsRow, '', $header_bottom);
	$worksheet->write('B'.$xlsRow, '', $header_bottom);
	$worksheet->write('C'.$xlsRow, '', $header_bottom);
	$worksheet->write('D'.$xlsRow, "ระดับ", $header_bottom);
	$worksheet->write('E'.$xlsRow, "อัตรา", $header_bottom);
	
	
	$sql = "
			SELECT
			tbl_salary_profile.profile_id,
			tbl_salary_profile.profile,
			tbl_salary_radub.radub_label,
			tbl_salary_level_degree.level_cal,
			tbl_salary_level_degree.min_salary,
			tbl_salary_level_degree.medium_salary,
			tbl_salary_level_degree.max_salary,
			hr_typeposition.type_position,
			tbl_salary_math_radub.salary_radub_id,
			hr_typeposition.type_id
			FROM
			tbl_salary_profile
			Inner Join tbl_salary_radub ON tbl_salary_profile.profile_id = tbl_salary_radub.profile_id
			Inner Join tbl_salary_math_radub ON tbl_salary_radub.salary_radub_id = tbl_salary_math_radub.salary_radub_id
			Inner Join hr_addradub ON hr_addradub.runid = tbl_salary_math_radub.radub_id
			Inner Join tbl_salary_level_degree ON tbl_salary_radub.salary_radub_id = tbl_salary_level_degree.salary_radub_id
			Inner Join hr_typeposition ON hr_addradub.type_id = hr_typeposition.type_id
			WHERE tbl_salary_profile.profile_id='".$profile_id."'  ORDER BY hr_typeposition.type_id,tbl_salary_math_radub.salary_radub_id,tbl_salary_radub.radub_label ASC 
		";
		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error);
		while($row = mysql_fetch_assoc($result)){
			$xlsRow++;
			$worksheet->write('A'.$xlsRow, $row['type_position'], $body_bottom);
			$worksheet->write('B'.$xlsRow, $row['radub_label'], $body_bottom);
			$worksheet->write('C'.$xlsRow, number_format($row['min_salary'])."-".number_format($row['max_salary']), $body_bottom);
			$worksheet->write('D'.$xlsRow, $row['level_cal'], $body_bottom);
			$worksheet->write('E'.$xlsRow, number_format($row['medium_salary']), $body_bottom);
		}//exit();
#END Body Information

$workbook->close();
header("Content-Type: application/x-msexcel; name=\"".$filename.".xsl\"");
header("Content-Disposition: inline; filename=\"".$filename.".xsl\"");
$fh=fopen($fname, "rb");
fpassthru($fh);

/*
$fh=fopen($fname, "rb");
$contents = fread($fh,filesize($fname));
$dlfile=fopen("tmp_export_excel/$filename", "w");
$w = fwrite($dlfile,$contents);
fclose($dlfile);
header("location: tmp_export_excel/$filename");
die;
*/
?>