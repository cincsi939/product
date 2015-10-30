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
include("../../common/common_competency.inc.php");
include("checklist2.inc.php");
$db_temp = $dbname_temp;
$db_name = $dbcallcenter_entry;

	if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์
		$profile_id = LastProfile();
	}//end if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์


$sql = "SELECT * FROM keystaff WHERE staffid='$staffid'";
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);


?>
<html>
<head>
<title>การมอบหมายงานเอกสาร</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script type="text/javascript" src="dtree/dtree.js"></script>
<script src="../../common/functions.js" type="text/javascript" language="javascript"></script>
<LINK href="../../common/style_menu.css" rel=StyleSheet type="text/css">
<LINK href="../../common/dtree.css" rel="StyleSheet" type="text/css"  />
<LINK href="../../common/style.css" rel="StyleSheet" type="text/css">
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
              <option value="?profile_id=<?=$rsp[profile_id]?>&staffid=<?=$staffid?>&action=<?=$action?>&TicketId=<?=$TicketId?>&parent=<?=$parent?>&activity_id=<?=$activity_id?>" <?=$sel?>><?=$rsp[profilename]?></option>
              <?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
              </select> 
            
          </td>
          </tr>
                  <tr>
          <td width="29%" align="right"><strong>เลือก สพท. :</strong></td>
          <td width="71%">
            <select name="s_siteid" id="s_siteid" onChange="gotourl(this)">
              <option value="">เลือก สพท.</option>
              <?
		$sql_s  = "SELECT eduarea.secid, eduarea.secname,eduarea_config.pdf_org,
eduarea_config.pdf_sys FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE eduarea_config.group_type =  'keydata' AND eduarea_config.profile_id='$profile_id'  order by eduarea.secname ASC ";
		$result_s = mysql_db_query($dbnamemaster,$sql_s);
		while($rss = mysql_fetch_assoc($result_s)){
			if($rss[secid] == $s_siteid){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
              <option value="?profile_id=<?=$profile_id?>&staffid=<?=$staffid?>&action=<?=$action?>&TicketId=<?=$TicketId?>&s_siteid=<?=$rss[secid]?>&parent=<?=$parent?>&activity_id=<?=$activity_id?>" <?=$sel?>><?=str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rss[secname]);?></option>
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
	d.add(0,-1,'<B style="color: black;"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname](".ShowActivity($activity_id).")";?></B>','assign_list.php?action=view_main&staffid=<?=$staffid?>&parent=0&profile_id=<?=$profile_id?>&activity_id=<?=$activity_id?>&s_siteid=<?=$s_siteid?>','assign person','mainFrame');
	

<?

function ShowSubMenu($PID,$n,$target){
global $menuitem,$defaulturl ,$staffid,$db_name,$profile_id,$db_temp,$s_siteid,$activity_id;
//$img = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลบ";
if($s_siteid != ""){
		$conss = " AND siteid='$s_siteid'";
}

	$parent = $n;
	$sql = "SELECT  * from tbl_checklist_assign  where staffid = '$staffid' and PARENT_ID='$PID' AND profile_id='$profile_id' AND activity_id='$activity_id'  $conss ORDER BY timeupdate_scan ASC";
	//echo $sql;
	$xresult2 = mysql_db_query($db_temp,$sql);
	while ($xrs2=mysql_fetch_array($xresult2,MYSQL_ASSOC)){	
		$menuitem++;
		$xsecname = str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",show_area($xrs2[siteid]));
		$temp_date = thai_dateS($xrs2[date_assign]);
			echo "d.add($menuitem,$parent,'$temp_date ($xrs2[ticketid]) $xsecname','assign_list.php?action=assign_detail&staffid=$xrs2[staffid]&TicketId=$xrs2[ticketid]&profile_id=$profile_id&activity_id=$activity_id','$temp_date','mainFrame');\n";
			$xparent = $menuitem;
			$sql_key= "SELECT *  FROM tbl_checklist_assign_detail WHERE ticketid='$xrs2[ticketid]' and profile_id='$profile_id' ORDER BY name_th ASC"; // admin ของ app
			$result_key = mysql_db_query($db_temp,$sql_key);
				while($rs_key = mysql_fetch_assoc($result_key)){
					$menuitem++;
					echo "d.add($menuitem,$xparent,'$rs_key[idcard] $rs_key[prename_th]$rs_key[name_th] $rs_key[surname_th] $img','','mainFrame');\n";
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
    </p>
  
    	</td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
  </tr>
</table>

</body>
</html>