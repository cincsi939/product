<?php
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

	
if ($_SERVER[REQUEST_METHOD] == "POST"){
			 if ($_POST[action]=="edit2")
			 {
				$sql = "update app_list  set   appname='$appname', caption='$caption', icon='$icon' , app_url='$app_url'  , targetpage = '$target'  , gid = '$group_id'  WHERE  id = '$id' ;";
				mysql_query($sql);
				if (mysql_errno())
				{
					$msg = "ไม่สามารถบันทึกข้อมูลได้ ";
				}
				else
				{
					header("Location: ?id=$id&action=edit&refreshpage=1");
					exit;
				}
			}else
				{
				$sql = "INSERT INTO  app_list  SET  appname='$appname', caption='$caption', icon='$icon' , app_url='$app_url'  , targetpage = '$target' , gid = '$group_id' ";
					$result  = mysql_query($sql);
					if($result)
					{
						header("Location: ?id=$id&action=edit&refreshpage=1");
						exit;
					}else
					{	echo "ไม่สามารถบันทึกข้อมูลได้ ";}
				}
}else if ($_GET[action] == 'delete')
	{
		mysql_query("delete from app_list where id = '$id' ");
		mysql_query("delete from app_authority  where appid = '$id' ");
		if (mysql_errno())
			{
			$msg = "ไม่สามารถลบข้อมูลได้ ";
			}else
			{
			header("Location: ?id=$id&action=edit&refreshpage=1");
			exit;
			}
	
}else
		{		
	 	$sql = "select * from  app_list  where id='$id'  ;";
			$result = mysql_query($sql);
		if ($result){
			$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		} else {
			$msg = "ไม่พบข้อมูล";
			echo $msg;
		}
}

?>
<html>
<head>
<title>เพิ่มรายการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="../../common/style.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style2 {color: #0000FF}
-->
</style>
<SCRIPT LANGUAGE="JavaScript">
function pic_change(obj){
document.getElementById("p1").src = obj.value;
};
</SCRIPT>
<?
//refresh openner
if ($refreshpage){
?>	
<SCRIPT LANGUAGE="JavaScript">
// opener.document.location.form1.reload();
opener.document.location.reload();

</SCRIPT>

<?
}
?>
</head>

<body >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#2C2C9E"></td>
      </tr>
      <tr>
        <?
 if ($_GET[action]!="edit2")
 {
?>
        <td valign="top" ><p>&nbsp;</p>
            <table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
              <tr bgcolor="#A3B2CC">
                <td width="5%" align="center" bgcolor="#4752A3" class="plink">ลำดับ</td>
                <td width="32%" align="center" bgcolor="#4752A3" class="plink">appname</td>
                <td width="5%" align="center" bgcolor="#4752A3" class="plink">Group</td>
                <td width="5%" align="center" bgcolor="#4752A3" class="plink">ICON</td>
                <td width="35%" align="center" bgcolor="#4752A3" class="plink">URL</td>
                <td width="18%" align="center" bgcolor="#4752A3" class="plink">&nbsp;</td>
              </tr>
 <?php
		$i = 0;
		$no=0;
		$max=0;
		$result = mysql_query(" SELECT *  FROM  app_list  LEFT JOIN  app_group  ON app_list.gid = app_group.gid   order by id  ;");
		while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)) 
		{		
			$i++;
			$no++;
			if ($rs[id] > $max) $max=$rs[id];
			
			if ($i % 2){
				$bg="#FFFFFF";
			}else{
				$bg="#F0F0F0";
			}
		?>
              <tr bgcolor="<?=$bg?>">
                <td width="5%" height="28" align="center"><?=$no?></td>
                <td width="32%"><a href="org_left.php?appid=<?=$rs[id]?>&appname=<?=$rs[appname]?>" target="mainFrame" title="<?=$rs[caption]?>"><? echo $rs[caption];?><br>[<?=$rs[appname]?>]</a></td>
                <td width="5%" align="center">&nbsp;</td>
                <td width="5%" align="center"><img src="<? echo $rs[icon];?>" width="16" height="16"></td>
                <td width="35%"><? echo $rs[app_url];?></td>
                <td width="18%" align="center"><input style="width: 70;" type="button" value="edit" onClick="location.href='?id=<?=$rs[id]?>&action=edit2';" name="button2">
                    <input class="xbutton"  style="width: 70;" type="button" value="Delete" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>';" name="button">                </td>
              </tr>
              <?
		} // while
		$id = $max + 1;
		?>
            </table>
          <?
}
else if ($_GET[action]=="edit2")
{
		$sql = "select * from app_list   WHERE id = '$id' ORDER BY id  ;";
		$result = mysql_query($sql);
		if ($result)
		{
			$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		}
}
?>
            <span class="style2"> </span>
            <form  name="form" method = POST  action = "<?  echo $PHP_SELF ; ?>?id=<?=$id?>" >
              <INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">
              <table width="100%" border="0" cellspacing="1" cellpadding="2" align="center">
                <tr>
                  <td colspan=3 align="left" valign="top" bgcolor="#4752A3"><B class="plink">
                    <?=($rs[id]!=0?"แก้ไข":"เพิ่ม")?>รายการ</B></td>
                </tr>
                <tr>
                  <td align="right" valign="middle" class="link_back">Application Name </td>
                  <td><input name="appname" type="text" id="appname" value="<?=$rs[appname]?>" size="50"></td>
                </tr>
                <tr>
                  <td width="20%" align="right" valign="middle" class="link_back">Caption</td>
                  <td><input name="caption" type="text" id="caption" value="<?=$rs[caption]?>" size="50"></td>
                </tr>
                <tr>
                  <td align="right" valign="middle" class="link_back">Icon</td>
                  <td valign="middle"><select name="icon" id="icon" onChange="pic_change(this)">
                      <? 
						$directory = "../../images_sys";
						$dir = opendir($directory) ;
						while($file= readdir($dir)){
							if (($file != ".") AND ($file != "..")){
								$typepath = $directory . "/" . $file ;
								
					  ?>
									  <option value="<?=$typepath?>" <? if("../../images_sys/circlearrow.gif"==$typepath){ echo "selected=\"selected\"";}?>>
										<?=$typepath?>
					  </option>
									  <?
							}
						}		  
						?>
                  </select>  <img src="<?=$typepath?>" id="p1" width="24" height="24" border="1"/>                </td>
                </tr>
                <tr>
                  <td align="right" valign="middle" class="link_back">Application URL </td>
                  <td><input name="app_url" type="text" id="app_url" value="<?=$rs[app_url]?>" size="50"></td>
                </tr>
                <tr>
                  <td align="right" valign="middle" class="link_back">Application Group</td>
                  <td align="left" valign="top">
				  <select name="group_id" id="group_id">
				  	<?  
						$rsx_Query = mysql_query(" SELECT  *  FROM  app_group  order by gid ; ");
						while($rsx_gid= mysql_fetch_assoc($rsx_Query)){
					?>
                    <option value="<?=$rsx_gid[gid]?>" <? if($rs[gid]=="$rsx_gid[gid]"){echo " SELECTED";}?>><?=$rsx_gid[gname]?></option>
					<? } ?>
                  </select>
				  
				  </td>
                </tr>
                <tr>
                  <td align="right" valign="middle" class="link_back">Target</td>
                  <td align="left" valign="top">
                  <select name="target" id="target">
                    <option value="_blank" <? if($rs[targetpage]=="_blank"){echo " SELECTED";}?>>_blank</option>
                    <option value="_blank"<? if($rs[targetpage]=="_top"){echo " SELECTED";}?>>_top</option>
                    <option value="_blank"<? if($rs[targetpage]=="_parent"){echo " SELECTED";}?>>_parent</option>
                    <option value="_blank"<? if($rs[targetpage]=="_self"){echo " SELECTED";}?>>_self</option>
                  </select></td>
                </tr>
                <tr>
                  <td align="right" valign="top" width="20%">&nbsp;</td>
                  <td align="left" valign="top" width="60%"><input type="submit" name="Submit" value=" บันทึก ">
                      <input type="reset" name="Submit2" value="Reset">
                      <input type="reset" name="Submit3" value="ยกเลิก" ONCLICK="<? if ($_GET[action] == "edit2") echo "location.href='?id=$id';"; else echo "window.close();"; ?>">
                      <input name="id" type="hidden" id="id" value="<?=$id?>"></td>
                </tr>
              </table>
            </form>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
