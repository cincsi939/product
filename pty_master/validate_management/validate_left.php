<?
$ApplicationName= "salary_management";
$module_code = "tree salary";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= false; // 
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090819.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-08-19 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090819.002
	## Modified Detail :		ระบบสร้างฝังเงินเดือน
	## Modified Date :		2009-08-19 09:49
	## Modified By :		MR.SUWAT KHAMTUM

session_start();
include("validate.inc.php");

 function ShowGroupData($PID,$n,$target){
global $menuitem,$defaulturl ,$yy ,$db_name;
	$parent = $n;
	//$sql = "SELECT * FROM tbl_salary_profile WHERE yy='$yy'";
	$xt = "หมวด";
	$sql = "SELECT * FROM validate_datagroup  WHERE parent_id='0'  order by level_id,checkdata_id ASC ";
	$result = mysql_db_query($db_name,$sql);
	$menuitem1 = 0;
	while ($rs=mysql_fetch_array($result)){	
	############  แสดงmain
		$menuitem++;
		$menuitem1++;
		echo "t.add($menuitem,$parent,'$rs[dataname]', 'group_data.php?parent_id=$rs[checkdata_id]&action=view_detail&xtitle=$xt$rs[dataname]&level_id=1', '$rs[dataname] ', 'mainFrame','images/application_side_tree.png','images/application_side_tree.png');\n";
	############  แสดง child
		$sql_child = "SELECT * FROM validate_datagroup WHERE parent_id='$rs[checkdata_id]' order by level_id,checkdata_id ASC ";
		$result_child = mysql_db_query($db_name,$sql_child);
		$num1 = mysql_num_rows($result_child);
		if($num1 > 0){ // แสดงในกรณีมี child เท่านั้น
			while($rs1 = mysql_fetch_assoc($result_child)){
			$menuitem++;
			$parent1 = $menuitem1;
			if(CheckListSub($rs1[checkdata_id]) > 0){
				$sent_para = "group_data.php?parent_id=$rs1[checkdata_id]&action=view_detail&xtitle=$xt$rs1[dataname]&level_id=2&Aaction=view_detail";
			}else{
				$sent_para = "group_data.php?checkdata_id=$rs1[checkdata_id]&action=EDIT&xtitle=$xt$rs1[dataname]&parent_id=$rs[checkdata_id]&level_id=2&Aaction=view_detail";		
			}
			echo "t.add($menuitem,$parent1,'$rs1[dataname]', '$sent_para', '$rs1[dataname] ', 'mainFrame','images/sitemap.png','images/sitemap.png');\n";
			$parent2 = $menuitem;
			 ShowSubN($rs1[checkdata_id],$menuitem,"$rs1[checkdata_id]");

				}//end while($rs1 = mysql_fetch_assoc($result_radub)){						
			} //end 	if($num1 > 0){ 
			$menuitem1 = $menuitem;
	}//while
}// end  ShowGroup($PID,$menuitem,$target,$xrs2[gid]);
//------------------------------------

### function show subN
function ShowSubN($PID,$n,$get_para){
	global $menuitem,$defaulturl ,$yy ,$db_name;
	$parent = $n;
	$sqlN = "SELECT * FROM validate_datagroup  WHERE parent_id='$PID'  order by level_id,checkdata_id ASC";
	$resultN = mysql_db_query($db_name,$sqlN);
	while($rsN = mysql_fetch_assoc($resultN)){
		$menuitem++;
		//$parent = $menuitem;
		echo "t.add($menuitem,$parent,'$rsN[dataname]', 'group_data.php?checkdata_id=$rsN[checkdata_id]&action=EDIT&xtitle=$xt$rsN[dataname]&parent_id=$get_para&level_id=2&Aaction=view_detail', '$rs1[dataname] ', 'mainFrame','images/database_table.png','images/database_table.png');\n";	
	}//end while($rsN = mysql_fetch_assoc($resultN)){
		
}//end function ShowSubN(){
	

 function CheckListSub($get_id){
	global $db_name;
	$sql_sub1 = "SELECT COUNT(parent_id) AS  num_sub FROM validate_datagroup WHERE parent_id='$get_id'";
	$result_sub1 = mysql_db_query($db_name,$sql_sub1);
	$rs_s1 = mysql_fetch_assoc($result_sub1);
	return $rs_s1[num_sub];
}
 ?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script type="text/javascript" src="dtree/dtree.js"></script>
<script src="../../common/functions.js" type="text/javascript" language="javascript"></script>
<LINK href="../../common/style_menu.css" rel=StyleSheet type="text/css">
<LINK href="../../common/dtree.css" rel="StyleSheet" type="text/css"  />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<body >
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td height="18">
<SCRIPT LANGUAGE="JavaScript">
<!--
t = new dTree('t');
t.add(0,-1,'<B style="color: black;">บริหารจัดการหมวดรายการตรวจสอบข้อมูล</B>','group_data.php?action=view','เพิ่มหมวดการตรวจสอบข้อมูล','mainFrame');
<?
ShowGroupData("0",0,"mainFrame");
?>
document.write(t);
//-->
</SCRIPT>
	</td>
  </tr>
</table>
</body>
</html>