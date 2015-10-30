<?php ######################  start Header ########################
/**
* @comment ไฟล์ถูกสร้างขึ้นมาสำหรับระบบบันทึกข้อมูลข้าราชการครูและบุคลากรทางการศึกษา สำนักการศึกษา กรุงเทพมหานคร
* @projectCode 56EDUBKK01
* @tor 7.2.4
* @package core(or plugin)
* @author Pannawit
* @access public/private
* @created 01/10/2014
*/

function utf2Tis620($val){
	
	return iconv('UTF-8','TIS-620',$val);
}

$monthList = array('1'=>'มกราคม','2'=>'กุมภาพันธ์','3'=>'มีนาคม','4'=>'เมษายน','5'=>'พฤษภาคม','6'=>'มิถุนายน','7'=>'กรกฎาคม','8'=>'สิงหาคม',
'9'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤศจิกายน','12'=>'ธันวาคม');

$monthList = array_map('utf2Tis620',$monthList);

$month = (int) $_POST['month'];

$year = (int) $_POST['year'];

$year = $year - 543;

$date = date("t", mktime(0, 0, 0, $month, 1, $year));

$date = range(1,$date);


foreach( $date as $each ){
    
    
    
    $text = sprintf('%s %d %s %d',utf2Tis620('วันที่'),$each,$monthList[$month],$year+543);
    
    $time = strtotime("$year-$month-$each");
    
    echo '<a href="CC_keyin_user.inc_script.php?time='.$time.'" target="_blank">'.$text.'</a><br>';
}
?>