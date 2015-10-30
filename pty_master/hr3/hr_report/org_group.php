<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AuthorityManagement";
$module_code = "add";
$process_id = "add";
$VERSION = "9.1";
$BypassAPP= false;
#########################################################
#Developer::Pairoj
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::schooll_name, login
#END
#########################################################
session_start();
set_time_limit(1000);
			include("../../config/config_hr.inc.php");
			include ("../../common/std_function.inc.php")  ;

			include ("../../common/common.inc.php")  ;
			include ("../../inc/authority.inc.php")  ;



if ($_SERVER[REQUEST_METHOD] == "POST" && $appid != "" ){ 

			$sql2 = " SELECT *  FROM  app_authority WHERE  appid='$appid' AND  gid='$gid' ";
			//echo "$sql2<hr>";
			$result = mysql_query($sql2);
			$numrows = mysql_num_rows($result);
			if($numrows>0){
				$sql = " UPDATE  app_authority  SET  appid='$appid',gid='$gid',staffid='' , authority = '$authority' WHERE ( appid='$appid' AND  gid='$gid' ) " ;
				//echo "$sql<hr>";
				mysql_query($sql);
			}else{
				$sql1 = " INSERT INTO  app_authority  SET  appid='$appid',gid='$gid',staffid='' , authority = '$authority'   ";
				mysql_query($sql1);
				//echo "$sql1<hr>";
			}
			if (mysql_errno() == 0){
			echo "
			<HTML>
			<HEAD>
			<TITLE>app</TITLE>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-874\">
			<head>
					<SCRIPT language=JavaScript>
						alert('ปรับปรุงข้อมูลเรียบร้อย');
						window.location = 'org_left.php?appid=$appid&appname=$appname';
					</script>
			</head>
			</html>
			";		
			}else{
			echo "
			<HTML>
			<HEAD>
			<TITLE>app</TITLE>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-874\">
			<head>
					<SCRIPT language=JavaScript>
						alert('ปรับปรุงข้อมูลไม่สำเร็จ');
						window.location = 'org_left.php?appid=$appid&appname=$appname';
					</script>
			</head>
			</html>
			";		
			}
}
		$sql = "select * from $epm_staffgroup where gid='$id';";
		$result = mysql_query($sql);
		$rs = mysql_fetch_assoc($result);
		
		$sql2 = " select * from app_list where id='$appid';";
		$result2 = mysql_query($sql2);
		$rs2 = mysql_fetch_assoc($result2);
		

?>


<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<SCRIPT language=JavaScript>
function checkFields() {
	missinginfo1 = "";
	missinginfo = "";
	if (document.form1.appid.value == "")  {	missinginfo1 += "\n- กรุณาเลือกโปรแกรมก่อนที่จะกำหนดสิทธิ"; }		
	if (missinginfo1 != "") { 
		missinginfo += "ไม่สามารถเพิ่มข้อมูลได้  เนื่องจาก \n";
		missinginfo +="_____________________________\n";
		missinginfo = missinginfo + missinginfo1  ;
		missinginfo += "\n___________________________";
		alert(missinginfo);
		return false;
		}
}
</script>	
</head>
<body bgcolor="#EFEFFF">
<form name="form1" method="post" action="?"  ONSUBMIT="checkFields();">
  <table border=0 align=center cellspacing=1 cellpadding=3 bgcolor="#808080" width="98%">
    <tr bgcolor="#A3B2CC">
      <td colspan="2" ><FONT style="font-size:14pt;">Authority For 
        <?=$rs2[appname]?>
      </font><FONT class="headerTB" style="font-size:14pt;">&nbsp;</font></td>
    </tr>
    <tr bgcolor=white valign=top>
      <td width="26%" class="link_back">ชื่อกลุ่มงาน</td>
      <td width="74%"><?=$rs[groupname]?>
      <input name="appid" type="hidden" id="appid" value="<?=$appid?>">
      <input name="gid" type="hidden" id="gid" value="<?=$id?>">
      <input name="appname" type="hidden" id="appname" value="<?=$appname?>"></td>
    </tr>
    <tr bgcolor=white valign=top>
      <td class="link_back">สิทธิของกลุ่มงาน</td>
      <td valign="middle"><input name="authority" type="radio" value="1" checked>
        อนุญาตให้ใช้ระบบนี้&nbsp;
        <input name="authority" type="radio" value="0">
        ไม่อนุญาตให้ใช้ระบบนี้ </td>
    </tr>
    <tr bgcolor="#DDDDEE">
      <td class="link_back" colspan=2><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="28%" valign="middle"><img src="images/school.gif" align=middle>สมาชิกของกลุ่ม</td>
          <td width="72%"><input name="Submit" type="submit" class="link_back" value="ตกลง">
&nbsp;
<input name="Submit2" type="button" class="link_back" value="ยกเลิก" onClick="history.back(-1)"></td>
        </tr>
      </table></td>
    </tr>
    <tr bgcolor="white" valign=top>
      <td colspan=2><?
		$n=0;
		$sql = "select t2.* from epm_groupmember t1 inner join $epm_staff t2 on t1.staffid=t2.id where t1.gid='$id';"; 
		//echo "$sql<hr>";
		$xresult = mysql_query($sql);
		while ($xrs=mysql_fetch_assoc($xresult)){
			$n++;
			$sex = "school";
			echo " &nbsp; &nbsp; &nbsp; <img src='images/$sex.gif' align=middle> $xrs[office]<BR>";
		}
		if ($n == 0) echo "- ไม่มีรายการข้อมูล -<BR><BR>";
		?></td>
    </tr>
    <tr bgcolor="white" valign=top>
      <td colspan=2 bgcolor="#A3B2CC">Application ที่กลุ่มงาน 
      <?=$rs[groupname]?> อยู่ </td>
    </tr>
    <tr bgcolor="white" valign=top>
      <td colspan=2 class="link_back">
<?
$n=1;
$sql1 = " SELECT *  FROM  app_authority  INNER JOIN  app_list   ON  app_authority.appid = app_list.id  WHERE    gid = '$id' ";
$rerult1 = mysql_query($sql1);
while($rs1=mysql_fetch_assoc($rerult1)){
echo "&nbsp; $n)  $rs1[caption]<br>";
$n++;
}
?>	  </td>
    </tr>
  </table>

</form>
<BR>
<BR>
<BR>
</BODY>
</HTML>
