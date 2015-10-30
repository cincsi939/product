<?
session_start();
$ApplicationName	= "manage_group_edit";
$module_code 		= "main_group_edit"; 
$process_id			= "manage_group_edit";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110503.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-05-03 15:00
	## Created By :		Mr.Suwat Khamtum
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110503.001 
	## Modified Detail :		ระบบบริหารจัดการกลุ่มการแก้ไขข้อมูล
	## Modified Date :		2011-05-03 15:00
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################



include "config_mgroup.php";
include("../../../common/common_competency.inc.php");
?>
<html>
<head>
<title>บริหารกลุ่มการแก้ไขข้อมูล</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script type="text/javascript" src="dtree/dtree.js"></script>
<script src="../../../common/functions.js" type="text/javascript" language="javascript"></script>
<LINK href="../../../common/style_menu.css" rel=StyleSheet type="text/css">
<LINK href="../../../common/dtree.css" rel="StyleSheet" type="text/css"  />
<LINK href="../../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>
</head>
<body >
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td height="18">&nbsp;</td>
  </tr>
  <tr>
    <td height="18">
      <p>
<SCRIPT LANGUAGE="JavaScript">
<!--
	d = new dTree('d');
	d.add(0,-1,'<B style="color: black;"><? echo "หมวดรายการช่วงเวลาแก้ไขข้อมูล ก.พ.7";?></B>','mgroup_list.php?action=all&parent=0','manage group edit','mainFrame');
	
<?

function ShowSubMenu($PID,$n,$target){
global $menuitem,$defaulturl ,$staffid,$dbnameuse;
//$img = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลบ";

	$parent = $n;
	$sql = "SELECT  * FROM tbl_assign_edit_period  WHERE   PARENT_ID='$PID'  ORDER BY periodname  ASC";
	$xresult2 = mysql_db_query($dbnameuse,$sql);
	while ($xrs2=mysql_fetch_assoc($xresult2)){	
		$menuitem++;
		$temp_numlist = CountGroupEdit($xrs2[period_master_id]);
		if($temp_numlist > 0){
				$count_list = " ( $temp_numlist รายการ)";
		}else{
				$count_list = "";	
		}
			echo "d.add($menuitem,$parent,'$xrs2[periodname] $count_list','mgroup_list.php?action=mgroup&period_master_id=$xrs2[period_master_id]&period_name=$xrs2[periodname]','$xrs2[periodname]','mainFrame');\n";
			$xparent = $menuitem;
			$sql_key= "SELECT *  FROM tbl_assign_edit_period_detail  WHERE period_master_id='$xrs2[period_master_id]'"; // admin ของ app
			$result_key = mysql_db_query($dbnameuse,$sql_key);
				while($rs_key = mysql_fetch_assoc($result_key)){
					$menuitem++;
					echo "d.add($menuitem,$xparent,'$rs_key[periodname]','mgroup_list.php?action=mgroup_view&period_id=$rs_key[period_id]&period_master_id=$xrs2[period_master_id]&periodname=$rs_key[periodname]','$rs_key[periodname]','mainFrame');\n";
				}// end if($rs_admin[permit_id] != ""){ 
			
		} // end while ($xrs2=mysql_fetch_array($xresult2,MYSQL_ASSOC)){	
	} // end function ShowSubMenu($PID,$n,$target){

 


$defaulturl = "";
$menuitem = 0; 
ShowSubMenu("0",0,"mainFrame");
$menuitem++;

?>
	
document.write(d);
//-->
</SCRIPT>
    </p>	</td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
  </tr>
</table>

</body>
</html>