<?
set_time_limit(0);
session_start();
include("../../../config/conndb_nonsession.inc.php");
include("../function.php");

require_once "class.writeexcel_workbook.inc.php";
require_once "class.writeexcel_worksheet.inc.php";


$filename = "salary_profile.xls" ;
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


###############   ข้อมูล profile
$sql_profile = "SELECT * FROM tbl_salary_profile WHERE profile_id='$profile_id'";
$result_profile = mysql_db_query($dbnamemaster,$sql_profile);
$rs_profile = mysql_fetch_assoc($result_profile);

//---------------- Set Column --------------------

# Create Header
$worksheet->write(1, 1, "$rs_profile[profile]", $S_normal_b1);


$worksheet->set_column('A:A', 8 );
$worksheet->set_column('B:Q', 12 );
$c_yy = date("Y")+543;
//$m_row= 48;
$m_row = search_max_row_radub($profile_id);
$sql = "SELECT tbl_salary_level.level, tbl_salary_level.money, tbl_salary_level.salary_radub_id FROM tbl_salary_radub Inner Join tbl_salary_level ON tbl_salary_radub.salary_radub_id = tbl_salary_level.salary_radub_id WHERE tbl_salary_radub.profile_id =  '$profile_id'";
$result = mysql_db_query($dbnamemaster,$sql);
while($rs = mysql_fetch_assoc($result)){
		$arr_salary[$rs[salary_radub_id]]["$rs[level]"] = $rs[money];
}// end while($rs = mysql_fetch_assoc($result)){

$sql_title = "SELECT * FROM tbl_salary_profile WHERE profile_id='$profile_id'";
$result_title = mysql_db_query($dbnamemaster,$sql_title);
$rs_t = mysql_fetch_assoc($result_title);

		//$m_level = 24;
		$m_level = ceil($m_row/2);
		$dis = 0.5;
		$x1=0;
		$n=1;
		for($i=$m_row; $i > 0 ; $i--){
		$x1++;
		$n++;
			
				if($x1 == 1){ // รอบแรกไม่คำนวณ
					$level = $m_level;
					}else{
						$level = $m_level-$dis;
						$dis = $dis+0.5;
					}
		#############  กรณี  ขั้นน้อยกว่า 1
					if($level < 1){
						//$level = "";
						break;
					}

$worksheet->write($n,0, "$level", $border2);
####  แนวตั้ง
			$sql_radub = "SELECT * FROM tbl_salary_radub WHERE profile_id='$profile_id'";
			$result_radub = mysql_db_query($dbnamemaster,$sql_radub);
			$k=0;
			while($rs1= mysql_fetch_assoc($result_radub)){
			$arr_radub[$k] = $rs1[radub_label];
			$k++;
			if($arr_salary[$rs1[salary_radub_id]]["$level"] > 0){ $txt_money =  number_format($arr_salary[$rs1[salary_radub_id]]["$level"]);}else{$txt_money = " ";	}
			$worksheet->write($n,$k, "$txt_money", $border2);
			}//end 	while($rs1= mysql_fetch_assoc($result_radub)){

}//end for($i=$m_row; $i > 0 ; $i--){
####  ขั้น
$worksheet->write($n,0, "ขั้น", $border2);
$j=0;
	for($m=0;$m < count($arr_radub); $m++){
	$j++;
		$worksheet->write($n,$j, "$arr_radub[$m]", $border2);
	}//end 	for($m=0;$m < count($arr_radub); $m++){
$workbook->close();
$fh=fopen($fname, "rb");
$contents = fread($fh,filesize($fname));
$dlfile=fopen("tmp_export_excel/$filename", "w");
$w = fwrite($dlfile,$contents);
fclose($dlfile);

header("location: tmp_export_excel/$filename");
die;
?>