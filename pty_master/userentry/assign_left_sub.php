<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "userentry";
$module_code = "treeadmin";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= false; // 
#########################################################
#Developer::Suwat
#DateCreate::05/06/2009
#LastUpdate::05/06/2009
#DatabaseTable::
#END
#########################################################		
include "epm.inc.php";

$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

				function thai_date($temp){
				global $mname;
				$x = explode("-",$temp);
				$m1 = $mname[intval($x[1])];
				$y1 = intval($x[0]+543);
				$xrs = intval($x[2])." $m1 "." $y1 ";
				return $xrs;
			}

$sql = "SELECT * FROM keystaff WHERE staffid='$staffid'";
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);

if($profile_id == ""){
	
		$sqldf = "SELECT * FROM tbl_checklist_profile WHERE status_active='1' ORDER BY profile_date DESC LIMIT 1";
		$result_profile = mysql_db_query($db_temp,$sqldf);
		$rsdf = mysql_fetch_assoc($result_profile);
		$profile_id = $rsdf[profile_id];
}//end if($profile_id == ""){



?>
<html>
<head>
<title>มอบหมายงาน sub</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script type="text/javascript" src="dtree/dtree.js"></script>
<script src="../../common/functions.js" type="text/javascript" language="javascript"></script>
<LINK href="../../common/style_menu.css" rel=StyleSheet type="text/css">
<LINK href="../../common/dtree.css" rel="StyleSheet" type="text/css"  />
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>
</head>
<body >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="29%" align="right"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td width="71%">
            <select name="profile_id" id="profile_id" onChange="gotourl(this)">
              <option value="">เลือกโฟล์ไฟล์</option>
              <?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($db_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
              <option value="?profile_id=<?=$rsp[profile_id]?>&staffid=<?=$staffid?>&action=<?=$action?>&TicketId=<?=$TicketId?>&parent=<?=$parent?>" <?=$sel?>><?=$rsp[profilename]?></option>
              <?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
              </select> 
            
          </td>
          </tr>
      </table>
    </form></td>
  </tr>
</table>
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
	d.add(0,-1,'<B style="color: black;"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?></B>','assign_list_sub.php?action=view_main&staffid=<?=$staffid?>&parent=0&profile_id=<?=$profile_id?>','assign person','mainFrame');
	

<?

function ShowSubMenu($PID,$n,$target){
global $menuitem,$defaulturl ,$staffid,$db_name,$profile_id;
//$img = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลบ";
if($profile_id == ""){
		$profile_id=1;
}
	$parent = $n;
	$sql = "SELECT  * from tbl_assign_sub  where staffid = '$staffid' and nonactive = '0' and PARENT_ID='$PID' AND profile_id='$profile_id' ORDER BY assign_date ASC";
	$xresult2 = mysql_db_query($db_name,$sql);
	while ($xrs2=mysql_fetch_array($xresult2,MYSQL_ASSOC)){	
		$menuitem++;
		$temp_date = thai_date($xrs2[assign_date]);
			echo "d.add($menuitem,$parent,'วันที่ $temp_date ($xrs2[ticketid])','assign_list_sub.php?action=assign_detail&staffid=$xrs2[staffid]&TicketId=$xrs2[ticketid]&profile_id=$profile_id','$temp_date','mainFrame');\n";
			$xparent = $menuitem;
			$sql_key= "SELECT *  FROM tbl_assign_key WHERE ticketid='$xrs2[ticketid]' and profile_id='$profile_id'"; // admin ของ app
			$result_key = mysql_db_query($db_name,$sql_key);
				while($rs_key = mysql_fetch_assoc($result_key)){
					$menuitem++;
					echo "d.add($menuitem,$xparent,'$rs_key[idcard] $rs_key[fullname] $img','','mainFrame');\n";
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