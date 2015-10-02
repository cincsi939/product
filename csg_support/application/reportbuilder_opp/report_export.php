<?php
/**
 * @comment Export Reportbuilder
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    14/08/2014
 * @access     public
 */
?>
<html>
<head>
<title>Report Management : Export Report</title>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<script language="javascript" src="dbselect.js"></script>
</head>

<body bgcolor="#FFFFFF">
<PRE>
<?php
/*****************************************************************************
Function		: แสดงข้อมูลใน Database ออกมาเป็น php Array 
Version			: 1.0
Last Modified	: 
Changes		:
	- 7/8/2548	 เพิ่มการ Export ให้มีส่วนของ Header ลงไปด้วย (เพิ่ม Field ใน reportinfo : keyincode,createby,refno)

*****************************************************************************/
include "db.inc.php";

function GenerateHeader($id){
	if(!isset($uname)){
		$uname = "";	
	}
	eval (DB2Array("reportinfo","select * from reportinfo where rid='$id' and uname='$uname';"));
	eval (DB2Array("paraminfo","select * from paraminfo where rid='$id' and uname='$uname' order by porder;"));

	$xfld = explode(".",$reportinfo[0]['fldname']);
	$vfld = explode(".",$paraminfo[0]['dfield']);

	echo "#START\n#This Program is copyrigth by Sapphire R&D co.,ltd\n";
	echo "#TableMaster=" . $xfld[0] . "\n";
	echo "#TableValue=" . $vfld[0] . "\n";
	echo "#KeyinCode=" . $reportinfo[0]['keyincode'] . "\n";
	echo "#DateModified=" . date("d-m-Y") . "\n";      
	echo "#CreateBy=" . $reportinfo[0]['createby'] . "\n";
	echo "#END\n\n";
	echo '$id = '.$id.";\n";
	echo "\$imcode = \"" . $reportinfo[0]['keyincode'] . "\";\n\n";
}

$id = intval($_GET['id']);

echo "&lt;?\n";

GenerateHeader($id);

echo 'require_once "db.inc.php";';
echo "\n";
echo DB2ArrayExport("reportinfo","select * from reportinfo where rid='$id' and uname='$uname';");
echo "\n";
echo DB2ArrayExport("cellinfo","select * from cellinfo where rid='$id' and uname='$uname';");
echo "\n";
// @modify Phada Woodtikarn 04/08/2014 จัด $cellinfo ใหม่
echo '$cellinfo = ChangeArrayCellinfo($cellinfo);';
echo "\n";
// @end
echo DB2ArrayExport("paraminfo","select * from paraminfo where rid='$id' and uname='$uname' order by porder;");
echo "\n";
echo "include \"".$report_inc_path. "report.inc.php\";\n";
echo "?&gt;\n";

?>
</PRE>
</body>
</html>