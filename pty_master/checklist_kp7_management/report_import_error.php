<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_tranfer.php");
include("function_j18.php");



###  end ประมวลผลรายการ
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">
//	function copyit(theField) {
//		var selectedText = document.selection;
//		if (selectedText.type == 'Text') {
//			var newRange = selectedText.createRange();
//			theField.focus();
//			theField.value = newRange.text;
//		} else {
//			alert('select a text in the page and then press this button');
//		}
//	}
</script>
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
<?
	if($action == ""){
		if($mode == "retire"){
			$conv1 = " AND t1.status_tranfer_data='2'";	 	 
			$xtitle1 = "รายการข้อมูลที่ไม่สามารถนำเข้าระบบ cmss ได้เนื่องจากได้เกษียณอายุราชการไปแล้ว";
		}else{
			$conv1 = " AND t1.status_tranfer_data='0'";	
			$xtitle1 = "รายการข้อมูลที่ไม่สามารถนำเข้าระบบ cmss ได้เนื่องจากข้อมูลบังคับไม่สมบูรณ์  ";
		}

?>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="7" align="left" bgcolor="#CCCCCC"><strong><?=$xtitle1?>&nbsp;<?=show_area($xsiteid);?></strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="15%" align="center" bgcolor="#CCCCCC"><strong>เลขบัตรประชาชน</strong></td>
        <td width="18%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="18%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td width="26%" align="center" bgcolor="#CCCCCC"><strong>หน่วยงานสังกัด</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>จำนวนรายการที่มีปัญหา</strong></td>
        <td width="8%" align="center" bgcolor="#CCCCCC"><strong>แก้ไขรายการ</strong></td>
      </tr>
      <?
	  	$arrnum = CountImpError($xsiteid,$profile_id);
      	$sql = "SELECT t1.idcard,t1.prename_th,t1.name_th,t1.surname_th,t1.position_now,t2.office,t1.secid,t2.id,t1.schoolid,t2.prefix_name FROM tbl_check_data as t1 Left Join $dbnamemaster.allschool as t2 ON t1.schoolid=t2.id WHERE   t1.secid='$xsiteid' AND t1.profile_id='$profile_id' $conv1";
		//echo $dbname_temp."<br>".$sql;
		$result = mysql_db_query($dbname_temp,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="center"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
        <td align="center"><? echo "$rs[position_now]";?></td>
        <td align="center"><? echo $rs[prefix_name].$rs[office];?></td>
        <td align="center"><? if($mode != "retire"){ if($arrnum[$rs[idcard]] > 0){ echo "<a href='?action=view_detail&idcard=$rs[idcard]&profile_id=$profile_id&xsiteid=$rs[secid]&fullname=$rs[prename_th]$rs[name_th] $rs[surname_th]&position_now=$rs[position_now]&mode=$mode&schoolid=$rs[schoolid]'>".number_format($arrnum[$rs[idcard]])."</a>";}else{ echo "0";} }?></td>
        <td align="center"><? if($mode != "retire"){?><a href="form_manage_checklist.php?action=EDIT&sentsecid=<?=$rs[secid]?>&idcard=<?=$rs[idcard]?>&profile_id=<?=$profile_id?>&schoolid=<?=$rs[schoolid]?>&xidcard=<?=$rs[idcard]?>&xsiteid=<?=$xsiteid?>" target="_blank"><img src="../../images_sys/b_edit.png" width="16" height="16" title="แก้ไขรายการ" border="0"></a><? } ?></td>
      </tr>
      <?
		}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  
  <?
		}else if($action == "view_detail"){
  ?>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr align="left">
        <td colspan="2" valign="middle" bgcolor="#CCCCCC"><a href="?action=&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>&mode=<?=$mode?>">ย้อนกลับ</a> || <strong>ข้อมูลของ  <? echo "$fullname  เลขบัตร $idcard  ตำแหน่ง $position_now ";?>   || <a href="form_manage_checklist.php?action=EDIT&sentsecid=<?=$xsiteid?>&idcard=<?=$idcard?>&profile_id=<?=$profile_id?>&schoolid=<?=$rs[schoolid]?>&xidcard=<?=$rs[idcard]?>&xsiteid=<?=$xsiteid?>" target="_blank">แก้ไข</a></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" valign="middle" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="96%" align="left" valign="middle" bgcolor="#CCCCCC"><strong>รายการปัญหาข้อมูลไม่สมบูรณ์</strong></td>
        </tr>
        <?
        	$sql = "SELECT t2.comment_name FROM tbl_checklist_logimport_error as t1 Inner Join tbl_checklist_protection as t2 ON t1.pro_id=t2.pro_id WHERE t1.idcard='$idcard' AND t1.siteid='$xsiteid' AND t1.profile_id='$profile_id'";
			$result = mysql_db_query($dbname_temp,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
				 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center" valign="middle"><?=$i?></td>
        <td align="left" valign="middle"><?=$rs[comment_name]?></td>
        </tr>
        <?
			}// end while($rs = mysql_fetch_assoc($result)){
		?>
    </table></td>
  </tr>
  <?
		}// end }else if($action == "view_detail"){
  ?>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>
