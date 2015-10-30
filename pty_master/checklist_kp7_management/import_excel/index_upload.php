<?
include("../checklist2.inc.php");
include("../../../config/conndb_nonsession.inc.php");
?>
<HTML><HEAD><TITLE>Import DATA</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<LINK href="../../../common/style.css" rel=stylesheet>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script language="javascript">

function chFrom(){
	 if(document.form1.name.value == ""){
			alert("กรุณาไฟล์ข้อมูล");
			document.form1.name.focus();
			return false;
	
	}
	return true;
}


function msgconf(){
		alert("การยืนยันการดำเนินการตรวจสอบข้อมูลเสร็จสิ้นจะมีผลทำให้ไม่สามารถปรับปรุงข้อมูลผ่านฟอร์ม excel ได้อีก คุณแน่ใจที่จะยืนยันการดำเนินการเสร็จสิ้น");	
	return true;
}
</script>

</HEAD>
<BODY bgcolor="#A5B2CE">
<? if($action == ""){
	$sql_ch = "SELECT COUNT(siteid) AS num1 FROM tbl_checklist_kp7_confirm_site WHERE siteid='$xsiteid' AND profile_id='$profile_id' AND flag_xls_endprocess='1'";
	$result_ch = mysql_db_query($dbname_temp,$sql_ch);
	$rsch = mysql_fetch_assoc($result_ch);
	mysql_free_result($result_ch);
	if($rsch[num1] > 0){
	?>
    <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td align="center"> <strong>
           <img src="../../../images_sys/alert.png" width="23" height="23" border="0"> 
        <?=show_area($xsiteid);?>
        &nbsp;<?=ShowDateProfile($profile_id)?> 
ได้ทำการยืนยันการดำเนินการเสร็จสิ้นไปแล้วหากท่านต้องการเข้าไปทำการปรับปรุงข้อมูลในระบบกรุณาติดต่อผู้ดูแลระบบในการปลดล็อกการทำงานของโปรแกรม</strong></td>
      </tr>
    </table>
<?
	}else{
	?>
    
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr align="center"><td align="center">
<form action="processxls.php?process=execute&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>" method="post" enctype="multipart/form-data" name="form1" onSubmit="return chFrom();">
  <fieldset >
    <legend><strong> ระบบนำเข้าข้อมูล excel เพื่อปรับปรุงสถานเอกสารก.พ.7 <?=show_area($xsiteid);?></strong>  </legend>
      <table width="100%" border="0">
      <tr>
        <td align="right">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
          <td width="17%" align="right" >โฟร์ไฟล์ข้อมูล : </td>
      <td width="79%"><?=ShowProfile_name($profile_id);?> </td>
      <td width="4%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" >ส่งไฟล์ข้อมูล :</td>
      <td><input name="name" type="file" id="name"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">ยืนยันการดำเนินการเสร็จ :</td>
      <td><input type="radio" name="conF_site" id="radio" value="1" onClick="return msgconf();">
        ดำเนินการตรวจสอบข้อมูลเสร็จสิ้น 
            <input type="radio" name="conF_site" id="radio2" value="0" checked> 
            อยู่ระหว่างดำเนินการ
</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td class="redlink">หมายเหต : การยืนยันการดำเนินการตรวจสอบข้อมูลเสร็จสิ้นจะมีผลทำให้กระบวนการ upload ข้อมูลผ่านฟอร์ม excel ถูกปิดไปเพื่อป้องกันช่องทางข้อมูลที่จะนำเข้าระบบ</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><input type="submit" name="Submit" value=" upload "></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="16" align="right">&nbsp;</td>
      <td><font color="#FF0000">หมายเหตุ : การนำเข้าข้อมูลการตรวจสอบเอกสาร ก.พ.7 ต้นฉบับจะยึดจำนวนและตัวเลขในไฟล์ excel ที่นำเข้า<br>
ดังนั้นตัวเลขแลจำนวนบุคลากรที่นำเข้าเป็นข้อมูลตั้งต้นจาก pobec ครั้งแรกถ้าไม่มีในไฟล์ excel จะถูกลบออกจากระบบจัดทำข้อมูลตั้งต้นเพื่อที่จะยึดจำนวนบุคลากรจากไฟล์ excel ที่ท่านนำเข้า </font> <a href="?action=view&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>">คลิ๊กเพื่อดู log การลบ</a></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  </fieldset>
</form>
</td>
</tr>
</table>
<? 
	}//end if($rsch[num1] < 1){
}//end 

if($action == "view"){
		$sql = "SELECT * FROM tbl_checklist_kp7_logdelete WHERE siteid='$xsiteid' and profile_id='$profile_id' and flag_redata='0' ORDER BY schoolid ASC";
		$result = mysql_db_query($dbname_temp,$sql);
		$numR = @mysql_num_rows($result);
	?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="5" align="left" bgcolor="#A5B2CE"><a href="?action=&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>">ย้อนกลับ</a> || <? echo ShowAreaSortName($xsiteid); echo "&nbsp;".ShowProfile_name($profile_id);?></td>
        </tr>
      <tr>
        <td width="6%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="18%" align="center" bgcolor="#A5B2CE"><strong>เลขบัตรประชาชน</strong></td>
        <td width="29%" align="center" bgcolor="#A5B2CE"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="25%" align="center" bgcolor="#A5B2CE"><strong>ตำแหน่ง</strong></td>
        <td width="22%" align="center" bgcolor="#A5B2CE"><strong>โรงเรียน</strong></td>
      </tr>
      <?
      if($numR > 0){
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="center"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="center"><?=$rs[position_now]?></td>
        <td align="center" ><?=show_school($rs[schoolid]);?></td>
      </tr>
      <?
		}//end while($rs = mysql_fetch_assoc($result)){
		}else{
			echo "<tr bgcolor='#FFFFFF'><td colspan='5'><center><font color='#FF0000'>-ไม่พบการลบข้อจากระบบตรวจสอบข้อมูล ก.พ.7 ผ่านฟอร์มการนำเข้าข้อมูล excel -</font></center> </td></tr>";
				
		}//end    if($numR > 0){
	  ?>
    </table></td>
  </tr>
</table>
<?
}//end  if($action == "view"){
?>
</BODY>
</HTML>