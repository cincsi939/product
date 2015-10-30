<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "authoritymanagement";
$module_code = "treereport";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= false; // 
#########################################################
#Developer::poramin
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::
#END
#########################################################		

session_start();
ob_start();
include "epm.inc.php";
include ("../../common/common_competency.inc.php") ;
include ("../../inc/authority.inc.php") ;
$time_start = getmicrotime();
// include_once  "../../config/config_epm.inc.php";
			if($_SESSION[secid] == "edubkk_master"){
				$name_main = "ระบบสนับสนุนการจัดการกลุ่มงาน"; 
			}else{
				$name_main = "ระบบสนับสนุนการจัดการกลุ่มงาน"; 
			}
$appid = $_GET[appid];
$imgstatus1="<img src=\"images/project_status1.gif\" width=\"8\" height=\"8\">";
$imgstatus2="<img src=\"images/project_status2.gif\" width=\"8\" height=\"8\">";

?>
<html>
<head>
<title><?=$dbname?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script type="text/javascript" src="dtree/dtree.js"></script>
<script src="../../common/functions.js" type="text/javascript" language="javascript"></script>
<LINK href="../../common/style_menu.css" rel=StyleSheet type="text/css">
<LINK href="../../common/dtree.css" rel="StyleSheet" type="text/css"  />
</head>

<body >

<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
  
  <tr>
    <td height="18">
      <p>
<SCRIPT LANGUAGE="JavaScript">
<!--

d = new dTree('d');
d.add(0,-1,'<B style="color: black;"><?=$name_main?></B>','org_info.php?action=newgroup&parent=0','เพิ่มองค์กร','mainFrame');

<?

function ShowGroup($PID,$n,$target){
global $uid,$menuitem,$defaulturl , $epm_staffgroup,$epm_groupmember,$appid,$appname,$imgstatus1,$imgstatus2;
	$parent = $n;
	$sql = "SELECT  * from $epm_staffgroup where  org_id='$PID' order by binary groupname ASC ; ";
	//echo "$sql";
	$xresult2 = mysql_query($sql);
	while ($xrs2=mysql_fetch_array($xresult2,MYSQL_ASSOC)){	
		$menuitem++;

		$nmember = Query1("select count(*) from $epm_groupmember where gid='$xrs2[gid]';");
		$author_nm = Query1("select count(*) from app_authority where gid='$xrs2[gid]' AND appid = '$appid'  AND authority = 1 ;");
		if($author_nm>0){$imgstatus=$imgstatus2;}else{$imgstatus=$imgstatus1;}
		
		echo "d.add($menuitem,$parent,'$xrs2[groupname] ($nmember) $imgstatus','org_group.php?org_id=$PID&id=$xrs2[gid]&action=show&appid=$appid&appname=$appname', '$xrs2[groupname]','mainFrame',d.icon.usergroup,d.icon.usergroup);\n";
		
	}//while
}

function ShowUser($PID,$n,$target){
global $uid,$menuitem,$defaulturl ,$epm_staff,$appid,$appname,$imgstatus1,$imgstatus2 ;
	$parent = $n;
	$sql = "SELECT  * from $epm_staff  ";
	//echo "$sql";
	$xresult2 = mysql_query($sql);
	while ($xrs2=mysql_fetch_array($xresult2,MYSQL_ASSOC)){	
		$author_nm = Query1("SELECT count(*) from app_authority  where staffid='$xrs2[id]' AND appid = '$appid' AND authority = 1 ;");
		if($author_nm>0){$imgstatus=$imgstatus2;}else{$imgstatus=$imgstatus1;}
		$menuitem++;
		echo "d.add($menuitem,$parent,'$xrs2[office]  $imgstatus', 'org_user.php?org_id=$PID&id=$xrs2[id]&action=show&appid=$appid&appname=$appname', '$xrs2[office]', 'mainFrame','images/school.gif','images/school.gif');\n";
	}//while
}
//------------------------------------

function ShowSubMenu($PID,$n,$target){
global $uid,$menuitem,$defaulturl , $epm_staff ,$epm_staffgroup,$appid,$appname ,$imgstatus1,$imgstatus2   ; 
	$maintbl="epm_main_menu";
	$parent = $n;
	$sql = "SELECT  * from $maintbl where  PARENT_ID='$PID' order by `POSITION`; ";
	$xresult2 = mysql_query($sql);
	while ($xrs2=mysql_fetch_array($xresult2,MYSQL_ASSOC)){	
		$countuser = Query1("select count(*) FROM epm_groupmember where gid='$xrs2[NID]';");
		$author_nm = Query1("select count(*) from app_authority where gid='$xrs2[NID]' AND appid = '$appid' AND authority = 1 ;");

		if($author_nm>0){$imgstatus=$imgstatus2;}else{$imgstatus=$imgstatus1;}

		if($countuser < 1){ $num_count=""; }else{ $num_count="($countuser)";}
		
		$menuitem++;
		if ($xrs2[MTYPE] == 1) { // group

	echo "d.add($menuitem,$parent,'$xrs2[NLABEL] $imgstatus','org_user.php?org_id=$xrs2[NID]&appid=$appid&appname=$appname','$xrs2[NLABEL]','mainFrame',d.icon.folder);\n";

			$xparent = $menuitem;


			//$nperson = Query1("SELECT count(*) from epm_staff where NID='$xrs2[NID]';");
			$ngroup = Query1("select count(*) FROM $epm_staffgroup where org_id='$xrs2[NID]';");
			$ndep = Query1("select count(*) from epm_main_menu where PARENT_ID='$xrs2[NID]';");

			ShowSubMenu($xrs2[NID],$menuitem,"mainFrame");
		}else{
			echo "d.add($menuitem,$parent,'$xrs2[NLABEL]','$xrs2[NVALUE]','$xrs2[NLABEL]','$target',d.icon.node);\n";
			if ($defaulturl == "") $defaulturl=$xrs2[NVALUE];
		}
	} // while

}


$defaulturl = "";
$menuitem = 0; 
ShowSubMenu("0",0,"mainFrame");

$nperson = Query1("select count(*) from $epm_staff where org_id='0' or org_id is null ;");
$menuitem++;
/*echo "d.add($menuitem,0,'หน่วยงานนอก ($nperson)','org_user.php?org_id=','หน่วยงานนอก','mainFrame','dtree/img/house.gif','dtree/img/house.gif');\n";
*/
?>
	
document.write(d);
//-->
</SCRIPT>
    </p>	</td>
  </tr>
</table>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);ob_end_flush();?>