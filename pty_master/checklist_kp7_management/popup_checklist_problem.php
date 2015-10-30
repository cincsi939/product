<?
session_start();
include("checklist2.inc.php");

function ShowPersonChecklist($idcard,$profile_id){
	global $dbname_temp;
	$sql = "SELECT * FROM tbl_checklist_kp7  WHERE idcard='$idcard' AND profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return "$rs[prename_th]$rs[name_th]  $rs[surname_th]";
}//end function ShowPersonChecklist($idcard,$profile_id){

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<style>
.txthead{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtexsum{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtdate{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000; 
}
.txtdata{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #000; 
}
.txt_link a:link {
	FONT-SIZE: 12px;
	color: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:visited {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:active {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline;FONT-WEIGHT: bold;
}
.style1 {color: #006600}
.fillcolor_headgraph{	
	padding: 2pt;
	background-color:#0063C9;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#0063C9', EndColorStr='#000467');
}
.fillcolor_headgraph2{	
	padding: 2pt;
	background-color:#E6E6E6;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#E6E6E6', EndColorStr='#8E8E8E');
	font-weight:bold;
}
</style>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="3" align="left" bgcolor="#CCCCCC"><strong>รายการปัญหาของ 
          <?=ShowPersonChecklist($idcard,$profile_id)?>&nbsp;<?=ShowProfile_name($profile_id);?>
        </strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="32%" align="center" bgcolor="#CCCCCC"><strong>หมวดปัญหา</strong></td>
        <td width="63%" align="center" bgcolor="#CCCCCC"><strong>รายละเอียดปัญหา</strong></td>
      </tr>
      <?
     $sql_detail = "SELECT * FROM tbl_checklist_problem_detail WHERE idcard='$idcard' AND profile_id='$profile_id'  AND status_problem = 0   ORDER BY menu_id,problem_id  ASC";
	// echo "$dbname_temp :: ".$sql_detail;
	$result_detail = mysql_db_query($dbname_temp,$sql_detail);
	$j=0;
	while($rs_d = mysql_fetch_assoc($result_detail)){
		if ($j++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}	
	  
	  ?>
      <tr bgcolor="<?=$bg1?>">
        <td align="left"><?=$j?></td>
        <td align="left"><? echo GetTypeMenu($rs_d[menu_id])." => ".GetTypeProblem($rs_d[problem_id]);?></td>
        <td align="left"><?=$rs_d[problem_detail]?></td>
      </tr>
      <?
	}//end 	while($rs_d = mysql_fetch_assoc($result_detail)){
	  ?>
    </table></td>
  </tr>
</table>
</body>
</html>
