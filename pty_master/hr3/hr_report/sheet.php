<?php
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_sheet";
$module_code 		= "sheet"; 
$process_id			= "sheet";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	:: 
#DateCreate	::17/07/2007
#LastUpdate	::17/07/2007
#DatabaseTabel::
#END
#########################################################
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include("../../../config/phpconfig.php");
$time_start = getmicrotime();
if ($_SERVER[REQUEST_METHOD] == "POST"){
	add_log("�����żŧҹ�ҧ�Ԫҡ��",$id,$action);
			// ��Сͺ��Ҩҡ select box
			  $startdate = $start_year.'-'.$start_month.'-'.$start_day;
			  $enddate = $end_year.'-'.$end_month.'-'.$end_day;

			 if ($_POST[action]=="edit2")
			 {  
			 
				$sql = "update sheet set  topic='$topic' ,startdate ='$startdate',enddate='$enddate' ,sheetname='$sheetname' ,refer='$refer'  where id ='$id' and runid='$runid' ;";
				
				mysql_query($sql);
				if (mysql_errno())
				{
					$msg = "Cannot update parameter information.";
				}
				else
				{
					echo "
				<script language=\"javascript\">
				alert(\"�ӡ�û�Ѻ��ا�������������\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
				//	header("Location: ?id=$id&action=edit");
					exit;
				}
									
					
			}else
				{
				$sql = "INSERT INTO  sheet (id,startdate,enddate,sheetname,topic,refer) VALUES ('$id','$startdate','$enddate','$sheetname','$topic','$refer')";
		
					$result  = mysql_query($sql);
					if($result)
					{
					echo "
				<script language=\"javascript\">
				alert(\"�ӡ�úѹ�֡�������������\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
					//	header("Location: ?id=$id&action=edit");
						exit;
					}else
					{	echo "�������ö�ѹ�֡�������� ";}
				}
				

}else if ($_GET[action] == 'delete')
	{
		add_log("�����š���֡��",$id,$action);
		mysql_query("delete from sheet  where id = $id and runid='$runid';");
		if (mysql_errno()){
			$msg = "Cannot delete parameter.";
			}else
			{
			header("Location: ?id=$id&action=edit");
			echo"<meta http-equiv='refresh' content='0;URL=sheet.php'>";
			exit;
			}
	
}else
		{		
	 	$sql = "select * from  general where id='$id'  ;";
		$result = mysql_query($sql);
		if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		} else {
		$msg = "Cannot find parameter information.";
		echo $msg;
		}
}
	
		?>



<html>
<head>
<title>�ŧҹ�ҧ�Ԫҡ��</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<!-- send id to menu flash -->
<script language=javascript>
	
function check(){

	if(document.post.sheetname.value.length==0){
		alert("�кت��ͼŧҹ");
		document.post.sheetname.focus();
		return false;
	} else {
		return true;
	}
	
}	
</script>
</head>

<body bgcolor="#A3B2CC">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="30">&nbsp;</td>
    <td width="50" height="30"> 
      <div align="center"></div>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="left" valign="top"> 
            <form name="post" method="post" action="<?=$PHP_SELF?>" onSubmit="return check();">
              <INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
              <INPUT TYPE="hidden" NAME="runid" VALUE="<?=$runid?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">
              <table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
                <tr> 
                  <td align="left" valign="top" width="450"><b>���� / ʡ�� &nbsp;&nbsp; <u>
                    <?=$rs[prename_th]?>
                    <?=$rs[name_th]?>
                    <?=$rs[surname_th]?></u>
                    &nbsp;&nbsp; </b></td>
                </tr>
              </table>
              <br>
              <table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" BGCOLOR=black>
                <tr bgcolor="#A3B2CC" align="center">
                  <td colspan="5" bgcolor="#2C2C9E"><span class="style1">�ŧҹ�ҧ�Ԫҡ��</span></td>
                </tr>
                <tr bgcolor="#A3B2CC" align="center"> 
                  <td><strong>�ѹ���</strong></td>
                  <td><strong>�֧�ѹ���</strong></td>
                  <td><strong>���ͼŧҹ</strong></td>
                  <td><strong>�����������</strong></td>
                  <td>&nbsp;</td>
                </tr>
                <?
//conn2DB();
	$i=0;
	$result = mysql_query("select * from sheet where id='$id' ;");
	while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		$i++;
		if ($i % 2) {
		$bg = "#EFEFEF";
		}else{
		$bg = "#DDDDDD";
		}
?>
                <tr align="center" valign="top" bgcolor="<?=$bg?>"> 
                  <td align="center"> 
                    <?=MakeDate($rs[startdate])?>                  </td>
                  <td align="center"> 
                    <?=MakeDate($rs[enddate])?>                  </td>
                  <td align="left"> 
                    <?=$rs[sheetname]?>                  </td>
                  <td align="left"> 
                    <?=$rs[topic]?>                  </td>
                  <td width=150> <a href="sheet.php?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> 
                    &nbsp; <a href="#" onClick="if (confirm('�س�зӡ��ź��������ǹ�����������!!')) location.href='?action=delete&id=<?=$rs[id]?>&runid=<?=$rs[runid]?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>                  </td>
                </tr>
                <?
	} //while
// List Template
?>
              </table>
              <?

If ($_GET[action]=="edit2")
{
		$sql = "select * from sheet where id='$id' and runid= '$runid' ;";
		$result = mysql_query($sql);
		if ($result)
		{
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		}

}
?>
              <br>
              <table width="90%" border="0" cellspacing="2" cellpadding="0" align="center">
                <tr> 
                  <td align="right" valign="top" width="266">�����</td>
                  <td align="left" valign="top" width="608"> 
<?DateInput($rs[startdate],"start");?>                  </td>
                </tr>
                <tr> 
                  <td align="right" valign="top" width="266">�֧</td>
                  <td align="left" valign="top" width="608"> 
<?DateInput($rs[enddate],"end");?>                  </td>
                </tr>

                <tr> 
                  <td align="right" valign="top" width="266"><font color="red">*</font> ���ͼŧҹ</td>
                  <td align="left" valign="top" width="608"> 
                    <input type="text" name="sheetname" size="55" value="<?=$rs[sheetname]?>">
                  </td>
                </tr>
                <tr> 
                  <td align="right" valign="top" width="266">�����/��ù��ʹ�</td>
                  <td align="left" valign="top" width="608">
                    <input type="text" name="refer" size="55" value="<?=$rs[refer]?>">
                  </td>
                </tr>
                <tr> 
                  <td align="right" valign="top" width="266">������������</td>
                  <td align="left" valign="top" width="608"><textarea name="topic" cols="50" rows="10"><?=$rs[topic]?></textarea>
                  </td>
                </tr>
              </table>
              <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
                <tr valign="middle"> 
                  <td align="center" > &nbsp;&nbsp; 
                    <input type="submit" name="send" value="  �ѹ�֡  ">
                  </td>
                </tr>
              </table>
            </form>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
          </td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>