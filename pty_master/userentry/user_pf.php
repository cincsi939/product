<?
session_start();
header("Last-Modified: ".gmdate( "D, d M Y H:i:s")."GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("content-type: application/x-javascript; charset=TIS-620");
include("epm.inc.php");
include("function.php");

$sex 		= array("M"=>"ชาย","F"=>"หญิง");	
$sql 		= " select * from $epm_staff where staffid='".$_SESSION[session_staffid]."'; ";

$result 	= mysql_query($sql)or die("Query Error line : " . __LINE__ . "<hr>".mysql_error());
$rs 		= mysql_fetch_assoc($result);	

/*echo "$sql <hr> $rs[engname] $rs[engsurname] <br>";
*/
?>
<style type="text/css">
<!--
.p_border{
border-bottom:2 solid #DADCED;
}
-->
</style>
<form name="profile" style="width:100%">
<table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#F2F4F7">
<tr>
	<td align="left" bgcolor="#DADCED"><span style="font-size:11pt; font-weight:bold">ข้อมูลส่วนตัว
    <?=$report_title?>
    <input type="hidden" name="img" value="<?="images/personnel/".$rs[image]?>" />
    </span>
	</td>
</tr>
<tr>
	<td align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr align="center">
	<td colspan="2"><div id="Status"></div></td>
</tr>
<tr>
	<td height="20" align="left" ><strong>คำนำหน้า (ไทย)&nbsp;</strong></td>
	<td width="766"><input type="text" name="prename" maxlength="50" style="width:200px;" value="<?=$rs[prename]?>" /></td>
</tr>
<tr>
	<td height="20" align="left" ><strong> ชื่อ (ไทย)<font color="#FF0000">*</font></strong></td>
	<td ><input type="text" name="staffname" maxlength="200" style="width:200px;" value="<?=$rs[staffname]?>" /></td>
</tr>
<tr>
	<td width="171" height="20" align="left" class="p_border"><strong>นามสกุล (ไทย)<font color="#FF0000">*</font></strong> </td>
	<td class="p_border"><input type="text" name="staffsurname" maxlength="200" style="width:200px;" value="<?=$rs[staffsurname]?>" /></td>
</tr>
<tr>
	<td height="20" align="left"><strong>คำนำหน้า (อังกฤษ)</strong></td>
	<td><input type="text" name="engprename" maxlength="200" style="width:200px;" value="<?=$rs[engprename]?>" /></td>
</tr>
<tr>
	<td height="20" align="left"><strong>ชื่อ (อังกฤษ)<font color="#FF0000">*</font></strong></td>
	<td><input name="engname" type="text" style="width:200px;" value="<?=$rs[engname]?>
" /></td>
</tr>
<tr>
	<td height="20" align="left" class="p_border"><strong>นามสกุล (อังกฤษ)<font color="#FF0000">*</font></strong></td>
	<td class="p_border"><input type="text" name="engsurname" maxlength="200" style="width:200px;" value="<?=$rs[engsurname]?>" /></td>
</tr>
<tr>
	<td height="20" align="left" class="p_border"><strong>Email Address</strong></td>
	<td class="p_border"><input type="text" name="email" maxlength="200" style="width:200px;" value="<?=$rs[email]?>" /></td>
</tr>
<tr>
	<td height="20" align="left" class="p_border"><strong>เพศ</strong></td>
	<td class="p_border"><select name="sex" style="width:100px;">
<?
foreach ($sex as $sex=>$caption){

	$sel	= ($rs[sex] == $sex) ? " selected " : "" ; 
	echo "<option value='$sex' $sel>$caption";

}
?>
	</select>
	</td>
</tr>
<tr>
	<td height="20" align="left" class="p_border"><strong>ตำแหน่ง</strong></td>
	<td class="p_border"><input type="text" name="title" maxlength="200" style="width:200px;" value="<?=$rs[title]?>" /></td>
</tr>
<tr>
	<td height="20" align="left" class="p_border"><strong>โทรศัพท์</strong></td>
	<td class="p_border"><input type="text" name="telno" maxlength="100" style="width:200px;" value="<?=$rs[telno]?>" /></td>
</tr>
<tr>
	<td height="20" align="left" valign="top" class="p_border"><strong>ที่อยู่</strong></td>
	<td class="p_border"><textarea name="address"  style="width:100%; height:50px;"><?=$rs[address]?></textarea></td>
</tr>
<tr>
	<td height="20" align="left" valign="top" class="p_border"><strong>หมายเหตุ</strong></td>
	<td class="p_border"><textarea name="comment"  style="width:100%; height:50px;"><?=$rs[comment]?></textarea></td>
</tr>
<tr>
	<td height="20" colspan="2" align="left"><strong>&nbsp;หมายเหตุ รูปภาพจะดึงมาจากระบบแสกนใบหน้า</strong></td>
	</tr>
</table>
	</td>
</tr>
<tr>
    <td align="left" bgcolor="#DADCED">
	<button style="width:60px;font-weight:bold" onclick="UpdateProfile();">OK</button>&nbsp;
    <button style="width:60px;" onclick="document.profile.reset();">Cancel</button>
	</td>
</tr>
</table>
</form>