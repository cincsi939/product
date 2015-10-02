<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "application_management";
$module_code = "treeadmin";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= false; // 
#########################################################
#Developer::Suwat
#DateCreate::24/01/2009
#LastUpdate::24/01/2009
#DatabaseTable::
#END
#########################################################		
include "epm.inc.php";
$name_main = "Application view"; 
	if($action_view != ""){
		$action_view = $action_view;
	}else{
		$action_view = "application_view";
	}
?>
<html>
<head>
<title>application management</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script type="text/javascript" src="dtree/dtree.js"></script>
<script src="common/functions.js" type="text/javascript" language="javascript"></script>
<LINK href="common/style_menu.css" rel=StyleSheet type="text/css">
<LINK href="common/dtree.css" rel="StyleSheet" type="text/css"  />
<LINK href="common/style.css" rel=StyleSheet type="text/css">
</head>
<body >
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td height="18"><!--<a href="sys_left.php">application view</a> |--> <a href="org_left.php?action_view=user_view">user view</a></td>
  </tr>
    <tr>
    <td height="18">&nbsp;</td>
  </tr>
  <tr>
    <td height="18">
      <p>
<SCRIPT LANGUAGE="JavaScript">
<!--
d = new dTree('d');
<? if($action_view == "application_view"){?>
d.add(0,-1,'<B style="color: black;"><?=$name_main?></B>','application_list.php?action=view&parent=0','ADD Application','mainFrame');
<? 
} // end   if($action_view == "application_view"){
if($action_view == "user_view"){
?>
d.add(0,-1,'<B style="color: black;">user  view</B>','','ADD Application','mainFrame');
<?
} 

function ShowSubMenu($PID,$n,$target){
global $menuitem,$defaulturl ,$epm_staffgroup,$provision_yy,$session_group,$action_view;
	if($action_view == "application_view"){
	$maintbl="app_list";
	$parent = $n;
	$sql = "SELECT  * from $maintbl where app_status = 'on' and  PARENT_ID='$PID' AND (del <>'del' or del IS NULL) and (app_dir <> 'system') order by app_name  ASC";
	//echo $sql;
	$xresult2 = mysql_query($sql);
	while ($xrs2=mysql_fetch_array($xresult2,MYSQL_ASSOC)){	
		$menuitem++;
			echo "d.add($menuitem,$parent,'$xrs2[app_name]','','$xrs2[app_name]','mainFrame',d.icon.folder);\n";
			$xparent = $menuitem;
			
			$sql_admin = "SELECT *  FROM permission_status WHERE app_id='$xrs2[app_id]' AND pid='10'"; // admin ของ app
			$result_admin = mysql_query($sql_admin);
			$rs_admin = mysql_fetch_assoc($result_admin);
			if($rs_admin[permit_id] != ""){ 
			$menuitem++;
			echo "d.add($menuitem,$xparent,'$rs_admin[status]','application_list.php?action=view_detail&id=$rs_admin[permit_id]','$rs_admin[status]','mainFrame',d.icon.usergroup);\n";
			}// end if($rs_admin[permit_id] != ""){ 
			
		
			$sql_user = "SELECT * FROM  permission_status WHERE app_id='$xrs2[app_id]' AND pid='20'"; // 20 คือ ของ user
			$result_user = mysql_query($sql_user);
			$rs_user = mysql_fetch_assoc($result_user);
			if($rs_user[permit_id] != ""){
			$menuitem++;
			echo "d.add($menuitem,$xparent,'$rs_user[status]','application_list_user.php?action=view_detail&id=$rs_user[permit_id]&appid=$xrs2[app_id]','$rs_user[status]','mainFrame',d.icon.usergroup);\n";
			} // end if($rs_user[permit_id] != ""){
			
			ShowSubMenu($xrs2[app_id],$menuitem,"mainFrame");
		
		} // while
	}// end  if($action_view == "application_view"){
}
 
 ### แสดงกลุ่ม
function ShowGroup($PID,$n,$target,$gparent=0){
global $uid,$menuitem,$defaulturl,$epm_db,$session_staffid;
	$parent = $n;
	$sql = "SELECT  * from org_staffgroup where org_staffgroup.org_id='$PID' and org_staffgroup.parent='$gparent'  order by trim(org_staffgroup.groupname) ASC; ";
	$xresult2 = mysql_query($sql);
	while ($xrs2=mysql_fetch_array($xresult2,MYSQL_ASSOC)){	
		$menuitem++;
		echo "d.add($menuitem,$parent,'$xrs2[groupname]','org_group.php?org_id=$PID&id=$xrs2[gid]&action=show&type=$type', '$xrs2[groupname]','mainFrame',d.icon.usergroup,d.icon.usergroup);\n";
	
		
		ShowGroup($PID,$menuitem,$target,$xrs2[gid]);
			// ส่วนของการแสดง user ในกลุ่มงาน
		$sql_user = "select t2.* from org_groupmember  t1 inner join epm_staff  t2 on t1.staffid=t2.staffid where t1.gid='$xrs2[gid]'";
		$result_user = mysql_query($sql_user);
		$xparent = $menuitem; 
		while($rs3 = mysql_fetch_array($result_user,MYSQL_ASSOC)){
		$menuitem++;
			if($rs3[title] != ""){
				$txt_name =  "$rs3[title] : $rs3[prename] $rs3[staffname] $rs3[staffsurname]";
			}else{
				$txt_name = "$rs3[prename] $rs3[staffname] $rs3[staffsurname]";
			}
		if($rs3[sex] == "M"){ $sex = "man"; } elseif($rs3[sex] == "F") { $sex="girl"; } else { $sex="house"; }
			echo "d.add($menuitem,$xparent,'$txt_name','org_user.php?org_id=$PID&id=$rs3[staffid]&action=show&type=$type', '$txt_name','mainFrame',d.icon.$sex,d.icon.$sex);\n";
		}
		
	//ShowGroup($PID,$menuitem,$target,$xrs2[gid]);		
	}//while
} // end function function ShowGroup($PID,$n,$target,$gparent=0){


function ShowUser($PID,$n,$target){
global $uid,$menuitem,$defaulturl,$type;
	$parent = $n;
	$sql = "SELECT  * from epm_staff where  epm_staff.org_id='$PID' order by epm_staff.staffid";
	$xresult2 = mysql_query($sql);
	while ($xrs2=mysql_fetch_array($xresult2,MYSQL_ASSOC)){	
		$menuitem++;
		if($xrs2[sex] == "M"){ $sex = "man"; } elseif($xrs2[sex] == "F") { $sex="girl"; } else { $sex="house"; }
		if($xrs2[title] != ""){
			$show_name = "$xrs2[title] : $xrs2[prename] $xrs2[staffname] $xrs2[staffsurname]";
		}else{
			$show_name = "$xrs2[prename] $xrs2[staffname] $xrs2[staffsurname]";
		}
		
		echo "d.add($menuitem,$parent,'$show_name', 'org_user.php?org_id=$PID&id=$xrs2[staffid]&action=show&type=$type', '$xrs2[prename] $xrs2[staffname] $xrs2[staffsurname]', 'mainFrame',d.icon.$sex,d.icon.$sex);\n";
	}//while
}


function ShowSubMenu1($PID,$n,$target){
global $uid,$menuitem,$defaulturl,$epm_db,$session_staffid;
	$parent = $n;
	if ($_SESSION[session_dev_id] > 1 && $n == 0){ //admin ของหน่วยงาน
		$sql = "SELECT  * from main_menu where  PARENT_ID='$PID' and NID='$_SESSION[session_dev_id]' order by `POSITION`; ";
	}else{
		$sql = "SELECT  * from main_menu where  PARENT_ID='$PID' order by `POSITION`; ";
	}

	$xresult2 = mysql_query($sql);
	while ($xrs2=mysql_fetch_array($xresult2,MYSQL_ASSOC)){	
		$menuitem++;
		if ($xrs2[MTYPE] == 1) { // group
			echo "d.add($menuitem,$parent,'$xrs2[NLABEL]','org_info.php?id=$xrs2[NID]&type=$type','$xrs2[NLABEL]','$target',d.icon.folder);\n";
			$xparent = $menuitem;

			$nperson = Query1("select count(*) from epm_staff where epm_staff.org_id='$xrs2[NID]';");
			$ndep = Query1("select count(*) from main_menu where PARENT_ID='$xrs2[NID]';");

			$ngroup = Query1("select count(*) from org_staffgroup where org_id='$xrs2[NID]';");



			$menuitem++;
			echo "d.add($menuitem,$xparent,'หน่วยงาน ($ngroup)','org_group.php?org_id=$xrs2[NID]&type=$type','หน่วยงาน','$target',d.icon.usergroup,d.icon.usergroup);\n";
			ShowGroup($xrs2[NID],$menuitem,"_blank");

			$menuitem++;
			echo "d.add($menuitem,$xparent,'บุคลากร ($nperson)','org_user.php?org_id=$xrs2[NID]&type=$type','บุคลากร','$target',d.icon.user,d.icon.user);\n";
			ShowUser($xrs2[NID],$menuitem,"_blank");

			//@23/7/2550 เอาโรงเรียนมาเข้าใน สพท. /@22/5/2550 ไม่เอาหน่วยงานย่อย จะเปลี่ยนเป็นกลุ่มย่อยแทน
			$menuitem++;
			echo "d.add($menuitem,$xparent,'หน่วยงาน ($ndep)','','หน่วยงานย่อยในหน่วยงานนี้','',d.icon.folder);\n";
			ShowSubMenu1($xrs2[NID],$menuitem,"_blank");


		}else{
			echo "d.add($menuitem,$parent,'$xrs2[NLABEL]','$xrs2[NVALUE]','$xrs2[NLABEL]','$target',d.icon.node);\n";
			if ($defaulturl == "") $defaulturl=$xrs2[NVALUE];
		}
	} // while

}




if($action_view == "application_view"){ // แสดง application list
$menuitem = 0; 
ShowSubMenu("0",0,"mainFrame");
$menuitem++;
}// end if($action_view == "application_view"){

if($action_view == "user_view"){
$defaulturl = "";
$menuitem = 0; 
ShowSubMenu1("0",0,"mainFrame");

$nperson = Query1("select count(*) from epm_staff where epm_staff.org_id='0' or org_id is null ;");
$menuitem++;
echo "d.add($menuitem,0,'บุคลากรที่ไม่สังกัดหน่วยงาน ($nperson)','org_user.php?org_id=','บุคลากรที่ไม่สังกัดหน่วยงาน','mainFrame',d.icon.user,d.icon.user);\n";

ShowUser("",$menuitem,"_blank");

}
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