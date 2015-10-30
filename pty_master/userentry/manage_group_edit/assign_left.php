<?
session_start();
$ApplicationName	= "assign_group_edit";
$module_code 		= "assign_group_edit"; 
$process_id			= "assign_group_edit";
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
	d.add(0,-1,'<B style="color: black;"><? echo "มอบหมายงานแก้ไขข้อมูล ก.พ.7 ";?></B>','assign_list.php?action=all&parent=0','manage group edit','mainFrame');
	
<?

function ShowSubMenu($PID,$n,$target){
global $menuitem,$defaulturl ,$staffid,$dbnameuse;
//$img = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลบ";

	$parent = $n;
	$sql = "SELECT
t3.staffid,
t3.prename,
t3.staffname,
t3.staffsurname,
t2.status_profile
FROM
tbl_assign_edit_staffkey as  t1
Inner Join tbl_assign_edit_profile as t2 ON t1.profile_edit_id = t2.profile_edit_id
Inner Join keystaff  as t3 ON t1.staffid = t3.staffid
WHERE
t2.status_profile =  '1'
GROUP BY 
t3.staffid
ORDER BY t3.staffname ASC,t3.staffsurname ASC
";
//echo $sql;
	$xresult2 = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	while ($xrs2=mysql_fetch_assoc($xresult2)){	
		$menuitem++;
		$fullname = "$xrs2[prename]$xrs2[staffname] $xrs2[staffsurname]";
			echo "d.add($menuitem,$parent,'$fullname','assign_list.php?action=view_ticketid&staffid=$xrs2[staffid]','$fullname','mainFrame');\n";
			$xparent = $menuitem;
			$sql_key= "SELECT *  FROM  tbl_assign_edit_sub WHERE staffid='$xrs2[staffid]' ORDER BY ticketid DESC"; // admin ของ app
			$result_key = mysql_db_query($dbnameuse,$sql_key);
				while($rs_key = mysql_fetch_assoc($result_key)){
					$menuitem++;
					$txt_ticket = "วันที่ ".ShowThaiDate($rs_key[assign_date])."(".$rs_key[ticketid].")";
					echo "d.add($menuitem,$xparent,'$txt_ticket','assign_list.php?action=view_ticketid&mode=view_detail&staffid=$rs_key[staffid]&ticketid=$rs_key[ticketid]','$txt_ticket','mainFrame');\n";
					
					#### ข้อมูลรายละเอียดในใบงาน
					$sql_detail = "SELECT * FROM tbl_assign_edit_key WHERE ticketid='$rs_key[ticketid]'";
					$result_d = mysql_db_query($dbnameuse,$sql_detail);
					$xparent1 = $menuitem;
					while($rsd = mysql_fetch_assoc($result_d)){
						$menuitem++;
						$txt_ticket_detail = "$rsd[idcard] $rsd[fullname]";
						echo "d.add($menuitem,$xparent1,'$txt_ticket_detail','','$txt_ticket_detail','mainFrame');\n";
					}//end while($rsd = mysql_fetch_assoc($result_d)){
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