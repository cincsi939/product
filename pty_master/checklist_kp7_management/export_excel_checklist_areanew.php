<?
set_time_limit(0);
include("../checklist2.inc.php");
require_once "class.writeexcel_workbook.inc.php";
require_once "class.writeexcel_worksheet.inc.php";
$sheetname = "รายชื่อบุคลากร";
$filename = GenidcardSys($xsiteid,"7").".xls"; // ชือไฟล์ที่ทำการตรวจสอบข้อมูล
SaveLogExcelGen($profile_id,$xsiteid,$filename); // เก็บ log การ gen ไฟล์ excel

//$filename = date("His").".xls";
LogImpExpExcel($xsiteid,$profile_id,"ดาวน์โหลดข้อมูลexcel กรณีเข้าเขตใหม่");
$fname = tempnam("tmp_export_excel", "$filename");
$workbook = &new writeexcel_workbook($fname);
$worksheet1 =& $workbook->addworksheet($sheetname);

$worksheet1->set_column("A:A", 8); // ลำดับ
$worksheet1->set_column("B:B", 20);// เลขบัตรประชาชน
$worksheet1->set_column("C:C", 10);// คำนำหน้าชื่อ
$worksheet1->set_column("D:D", 20);// ชื่อ 
$worksheet1->set_column("E:E", 20); // นามสกุล
$worksheet1->set_column("F:F", 20);// โรงเรียน
$worksheet1->set_column("G:G", 20);// อำเภอ
$worksheet1->set_column("H:H", 15);// จำนวนแผ่นเอกสาร(แผ่น)
$worksheet1->set_column("I:I", 15);// จำนวนรูป(รูป)
$worksheet1->set_column("J:J", 15);// ปกเอกสาร(1 =มีปก,0=ไม่มีปก)
$worksheet1->set_column("K:K", 15);// พนักงานที่ตรวจสอบ
$worksheet1->set_column("L:L", 20);//สถานะ(1=เพิ่มรายชื่อใหม่ 0 = รายชื่อเดิม 2= ลบรายชื่อออก
$worksheet1->set_column("M:M", 15);//เลขบัตรที่ถูกต้อง
$worksheet1->set_column("N:N", 15);//วันเดือนปีเกิด
$worksheet1->set_column("O:O", 15);//วันเริ่มปฏิบัติราชการ


# Some common formats
# 0x2f = สีเทา
# 0x34 = สีส้ม
# 0x2C = สีฟ้า
# 0x6 = สีชมพู
# header
$h_ALL  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1));
$h_T  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'top'=>1,'right'=>1,'left'=>1));
$h_LT  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'top'=>1,'left'=>1));
$h_LR  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1,'left'=>1));
$h_L  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'left'=>1));
$h_R =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1));
$h_BTM  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'bottom'=>1,'right'=>1,'left'=>1));
$h_BNK  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'bold'=>1));

$h_BNK_Pink  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x6,'bold'=>1)); // พีื้นสีชมพู
$h_BNK_Blue  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2C,'bold'=>1)); // พีื้นสีฟ้า
$h_BNK_orange  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x34,'bold'=>1)); // พีื้นสีส้ม
$h_BNK_grey  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1)); // พีื้นเทา
#มีเส้นขอบ left
$h_BNK_Pink_border  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x6,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // พีื้นสีชมพู
$h_BNK_Blue_border  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2C,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // พีื้นสีฟ้า
$h_BNK_orange_border =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x34,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // พีื้นสีส้ม
$h_BNK_grey_border  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // พีื้นเทา
# มีเส้นขอบตรง center
$h_BNK_Pink_border_center  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x6,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // พีื้นสีชมพู
$h_BNK_Blue_border_center  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2C,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // พีื้นสีฟ้า
$h_BNK_orange_border_center =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x34,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // พีื้นสีส้ม
$h_BNK_grey_border_center  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // พีื้นเทา

# มีเส้นขอบตรง left
$h_BNK_border  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // พีื้นสีชมพู
$h_BNK_g_border  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // พีื้นเทา
# มีเส้นขอบตรง center
$h_BNK_border_center  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // พีื้นสีชมพู
$h_BNK_g_border_center  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // พีื้นเทา


//
#write
$line0 = 0;
$line1 = 1;
$line2 = 2;
$line3 = 3;
$line4 = 4;
$line5 = 5;
$line6 = 6;
$worksheet1->write($line0, 0," ", $h_LT);
$worksheet1->write($line0, 1," ", $h_T);
$worksheet1->write($line0, 2," ", $h_T);
$worksheet1->write($line0, 3," ", $h_T);
$worksheet1->write($line0, 4," ", $h_T);
$worksheet1->write($line0, 5," ", $h_T);
$worksheet1->write($line0, 6," ", $h_T);
$worksheet1->write($line0, 7,"จำนวนแผ่น", $h_T);
$worksheet1->write($line0, 8,"จำนวน", $h_T);
$worksheet1->write($line0, 9,"ปกเอกสาร", $h_T);
$worksheet1->write($line0, 10,"พนักงาน", $h_T);
$worksheet1->write($line0, 11,"สถานะ(1=เพิ่มรายชื่อใหม่", $h_T);
$worksheet1->write($line0, 12,"เลขบัตรประชาชน", $h_T);
$worksheet1->write($line0, 13,"วันเดือนปี", $h_T);
$worksheet1->write($line0, 14,"วันเริ่ม", $h_T);



$worksheet1->write($line1, 0,"ลำดับ", $h_L);
$worksheet1->write($line1, 1,"เลขบัตรประชาชน", $h_LR);
$worksheet1->write($line1, 2,"คำนำหน้าชื่อ", $h_LR);
$worksheet1->write($line1, 3,"ชื่อ", $h_LR);
$worksheet1->write($line1, 4,"นามสกุล", $h_LR);
$worksheet1->write($line1, 5,"โรงเรียน", $h_LR);
$worksheet1->write($line1, 6,"อำเภอ", $h_LR);
$worksheet1->write($line1, 7,"เอกสาร", $h_LR);
$worksheet1->write($line1, 8,"รูป", $h_LR);
$worksheet1->write($line1, 9,"(1 =มีปก", $h_LR);
$worksheet1->write($line1, 10,"ที่ตรวจสอบ", $h_LR);
$worksheet1->write($line1, 11,"0 = รายชื่อเดิม", $h_LR);
$worksheet1->write($line1, 12,"ที่ถูกต้อง", $h_LR);
$worksheet1->write($line1, 13,"เกิด", $h_LR);
$worksheet1->write($line1, 14,"ปฏิบัติราชการ", $h_LR);

$worksheet1->write($line2, 0," ", $h_BTM);
$worksheet1->write($line2, 1," ", $h_BTM);
$worksheet1->write($line2, 2," ", $h_BTM);
$worksheet1->write($line2, 3," ", $h_BTM);
$worksheet1->write($line2, 4," ", $h_BTM);
$worksheet1->write($line2, 5," ", $h_BTM);
$worksheet1->write($line2, 6," ", $h_BTM);
$worksheet1->write($line2, 7,"(แผ่น)", $h_BTM);
$worksheet1->write($line2, 8,"(รูป)", $h_BTM);
$worksheet1->write($line2, 9,"0=ไม่มีปก)", $h_BTM);
$worksheet1->write($line2, 10," ", $h_BTM);
$worksheet1->write($line2, 11,"2= ลบรายชื่อออก", $h_BTM);
$worksheet1->write($line2, 12," ", $h_BTM);
$worksheet1->write($line2, 13," ", $h_BTM);
$worksheet1->write($line2, 14," ", $h_BTM);


$worksheet1->write($line3, 15,"หมายเหตุ", $h_BNK);
$worksheet1->write($line3, 16,"สีชมพู คือเอกสารไม่สมบูรณ์", $h_BNK_Pink);
$worksheet1->write($line4,16,"สีฟ้า คือ เอกสารขาดปกประกอบ", $h_BNK_Blue);
$worksheet1->write($line5,16,"สีเหลือง คือ เอกสารเลขบัตรไม่สมบูรณ์", $h_BNK_orange);
$worksheet1->write($line6,16,"สีเทา คือ เลขบัตรไม่สมบูรณ์จาก pobec และจำนวนที่ค้างรับเอกสาร", $h_BNK_grey);

######  start data
#### หาโรงเรียน มัธยมออกเพื่อตัดออก
 ConHost(HOST,USERNAME_HOST,PASSWORD_HOST);
$sql_area ="SELECT schoolid FROM allschool_math_sd WHERE siteid='$xsiteid'";
//echo $dbnamemaster." :: ".$sql_area."<br>";
$result_area = mysql_db_query($dbnamemaster,$sql_area) or die(mysql_error());
while($rsa = mysql_fetch_assoc($result_area)){
		if($inschoolid > "") $inschoolid .= ",";
		$inschoolid .= "'$rsa[schoolid]'";
}//end while($rsa = mysql_fetch_assoc($result_area)){

if($inschoolid != ""){
		$conW = " AND t1.schoolid NOT IN($inschoolid)";	
		$conW1 = " AND t3.schoolid NOT IN($inschoolid)";	
			
}else{
	 	$conW = "";
		$conw1 = "";	
}
//$subid = substr($xsiteid,0,2);
//if(($xsiteid == "1001" or $xsiteid == "1002" or $xsiteid == "1003" or $xsiteid == "0101" or $xsiteid == "0102" or $xsiteid == "0134" or $subid == "50" or $subid == "58") and $profile_id == "4"){// กรณีเป็นเขต ที่แยกมัธยมและประถมแล้ว
		//$conw1 = "";
//}



$sql = "SELECT
t1.idcard,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t2.office,
t2.moiareaid,
if(status_id_false='1',2,1)  as ty,
t1.page_num as page_num,
t1.pic_num as pic_num
FROM
edubkk_checklist.tbl_checklist_kp7 as t1
Left Join edubkk_master.allschool as t2 ON t1.schoolid = t2.id
WHERE
t1.siteid =  '$xsiteid' AND t1.profile_id='$profile_id' $conW

UNION
SELECT
t3.idcard,
t3.prename_th,
t3.name_th,
t3.surname_th,
t3.position_now,
t4.office,
t4.moiareaid,
 '2' as ty,
  '' as page_num,
 '' as pic_num
FROM
tbl_checklist_kp7_false as t3
Left Join edubkk_master.allschool as t4 ON  t3.schoolid=t4.id
WHERE t3.profile_id =  '$profile_id' AND
t3.status_IDCARD LIKE  '%IDCARD_FAIL%' AND
t3.status_chang_idcard LIKE  '%NO%' AND t3.siteid='$xsiteid' $conW1
order by ty asc";
//echo $dbname_temp." :: ".$sql;die;
$result = mysql_db_query($dbname_temp,$sql);
$int_line = $line2;
$i=0;
while($rs = mysql_fetch_assoc($result)){
$int_line++;
$i++;
	if($rs[ty] == 1){
			$sy_b = $h_BNK_border;
			$sb_bc = $h_BNK_border_center;
	}else{
			$sy_b = $h_BNK_g_border;
			$sb_bc = $h_BNK_g_border_center;
	}
	
	$ampur = GetArea($xsiteid,$rs[moiareaid],"Aumpur");
	
	if($rs[page_num] > 0 or $rs[pic_num] > 0){
		$status_ch = "0";
	}else{
		$status_ch = "";	
	}

	
	$worksheet1->write($int_line, 0,"$i", $sb_bc);
	$worksheet1->write($int_line, 1," $rs[idcard] ", $sb_bc);
	$worksheet1->write($int_line, 2,"$rs[prename_th]", $sy_b);
	$worksheet1->write($int_line, 3,"$rs[name_th]", $sy_b);
	$worksheet1->write($int_line, 4,"$rs[surname_th]", $sy_b);
	$worksheet1->write($int_line, 5," $rs[office]", $sy_b);
	$worksheet1->write($int_line, 6," $ampur ", $sy_b);
	$worksheet1->write($int_line, 7,"$rs[page_num]", $sy_b);
	$worksheet1->write($int_line, 8,"$rs[pic_num]", $sy_b);
	$worksheet1->write($int_line, 9,"  ", $sy_b);
	$worksheet1->write($int_line, 10," ", $sy_b);
	$worksheet1->write($int_line, 11,"$status_ch", $sy_b);
	$worksheet1->write($int_line, 12," ", $sy_b);
	$worksheet1->write($int_line, 13," ", $sy_b);
	$worksheet1->write($int_line, 14," ", $sy_b);

}//end while($rs = mysql_fetch_assoc($result)){
####  end data
$workbook->close();

#--------------------------------------------------------------------------------------
$fh=fopen($fname, "rb");
$contents = fread($fh,filesize($fname));
$dlfile=fopen("tmp_export_excel/$filename", "w");


$w = fwrite($dlfile,$contents);

fclose($dlfile);
header("location: tmp_export_excel/$filename");
die;



?>