<?php
/**
 * @comment หน้ารายงาน reportbuilder
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    04/08/2014
 * @access     public
 */
/*****************************************************************************
Function		: แสดงหน้ารายงานตาม id ที่ส่งมา
Version			: 1.0
Last Modified	: 
Changes		:


*****************************************************************************/
# @modify Suwat.k 15/09/2015 แสดงหัวรายงานกรณีเป็นรายงานแยกตามช่วงอายุ
$arr_report_id = array('416','420','429','431','435','436');
if(in_array($_GET['id'], $arr_report_id)) {	
	include("header.php");
}#@end
require_once "db.inc.php";
$id = "";
if(isset($_GET['id'])){
	$id = intval($_GET['id']);
}
eval(DB2Array("reportinfo","select * from reportinfo where rid='$id' and uname='$uname';"));
eval(DB2Array("cellinfo","select * from cellinfo where rid='$id' and uname='$uname';"));
// @modify Phada Woodtikarn 04/08/2014 จัด $cellinfo ใหม่
$cellinfo = ChangeArrayCellinfo($cellinfo);
// @end
if (mysql_query("select porder from paraminfo limit 1;")){
	// มี porder ในตาราง paraminfo
	eval(DB2Array("paraminfo","select * from paraminfo where rid='$id' and uname='$uname' order by porder;"));
}else{
	eval(DB2Array("paraminfo","select * from paraminfo where rid='$id' and uname='$uname';"));
}

eval(DB2Array("chartinfo",  "select * from chartinfo where rid='$id';"));

include "report.inc.php";
?>








