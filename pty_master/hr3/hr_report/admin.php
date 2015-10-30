<?php

include ("../../../config/phpconfig.php");

If ($_GET[action] == 'delete')
	{
		echo "delete";
		mysql_query("delete from general  where id = $id  ;");
		if (mysql_errno())
			{
			$msg = "Cannot delete parameter.";
			}else
			{
			header("Location: ");
			exit;
			}
	
	}


?>
<html>
<head>
<title>ข้อมูลข้าราชการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
-->
</style>
</head>

<body >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom "><script language=javascript>
	window.top.leftFrame.document.menu.SetVariable("logmenu.id","");
	window.top.leftFrame.document.menu.SetVariable("logmenu.action","edit");
    </script>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#5E5E5E">
        <tr>
          <td width="677" height="30"><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">&nbsp;&nbsp;<b>รายงานแสดงจำนวนบุคลลากรแยกตามหน่วยงาน
            <?
		if	($_SESSION[isprivilage] == "super")
		{
		?>
		<meta http-equiv="refresh" content="0;URL=superadmin.php">
		<?
		}else
		{
		  $resultname = mysql_query("select  th_name  from  office_detail t1  where  substring(t1.id,1,2) = substring('$idoffice',1,2) order by id asc ;");
		   $rsgroup=mysql_fetch_array($resultname,MYSQL_ASSOC);
		   echo "$rsgroup[th_name]";
		   }
		  ?>
          </b></font></td>
          <td width="93" height="30" align="right"><a href="admin.php">
            <input name="Button" type="button"  style="width: 50;" class="xbutton" value="Exit" onClick="location.href='admin.php';">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </a></td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="left" valign="top" >
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                  <td align="right" valign="middle" bgcolor="#CACACA"><?
		 // echo "$idoffice";
	//	 echo "$isprivilage";
		  if     ($isprivilage == "hradmin")
		  {  
		  ?>
                      <a href="general.php"><img src="bimg/clients1.gif" width="30" height="25" border="0" alt="เพิ่มข้อมูลบุคลากร"></a>
                      <?
		  } //end if
		  ?>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                </tr>
              </table>
            <br>
            <?
	  $resultgroup = mysql_query("select  * from $dbnamemaster.hr_beunder  ;");
	 $rsgroup=mysql_fetch_array($resultgroup,MYSQL_ASSOC);
		?>
              <table border=0 width="99%" cellspacing=1 cellpadding=2 bgcolor=black align=center dwcopytype="CopyTableRow">
                <tr bgcolor="#A3B2CC">
                  <th width="40%" height="21">หน่วยงาน</th>
                  <th width="10%" height="21">ชาย</th>
                  <th width="10%" height="21">หญิง</th>
                  <th width="15%" height="21">รวม</th>
                  <th width="25%" height="21">สังกัด</th>
                </tr>
                <?

		$result = mysql_query("select  distinct  t2.th_name as th_name,t2.id as id,t3.name as sunggut  from general t1  left join office_detail  t2  on  t1.unit = t2.id   left join $dbnamemaster.hr_beunder t3 on t2.beunder = t3.id where  substring(t1.unit,1,2) = substring('$idoffice',1,2) order by t2.id asc ;");
	
		while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)) 
		{
			if ($i%2 == 0)
			{	 $color = "#EFEFEF";
			}else
			{
				$color ="#DDDDDD";
			}
		?>
                <tr bgcolor="<?=$color?>">
                  <td width="40%" align=left><a href="list.php?unit=<?=$rs[id]?>&groupping=<?=$rs[id]?>">
                    <?=$rs[th_name]?>
                  </a></td>
                  <?
				$result1 = mysql_query("select count(t1.id) as i from general t1 left join office_detail t2 on t1.unit = t2.id  where  t1.sex ='ชาย'  and  t2.id ='$rs[id]' ;");
				$m1=mysql_fetch_array($result1,MYSQL_ASSOC);
				$result1 = mysql_query("select count(t1.id) as i from general t1 left join office_detail t2 on t1.unit = t2.id  where  t1.sex ='หญิง'  and  t2.id ='$rs[id]';");
				$f1=mysql_fetch_array($result1,MYSQL_ASSOC);
				?>
                  <td width="10%" align="center" ><?=$m1[i] ?>                  </td>
                  <td width="10%" align=center><?=$f1[i] ?>                  </td>
                  <td width="15%" align=center><?=$m1[i]+$f1[i] ?>                  </td>
                  <td width="25%" align=center><?=$rs[sunggut] ?>                  </td>
                </tr>
                <?
			 }// end while
			 ?>
              </table>
            <p>&nbsp;</p>
			</td>
        </tr>
      </table>
	  
	<?
		if ($isprivilage =="hrmanagement"){
	?>
<table border=0 align=center width="90%">
<img src="bimg/b_edit.png"> <A HREF="addunit.php" target=_blank>แก้ไขข้อมูลหน่วยงาน</A><BR>
<img src="bimg/b_edit.png"> <A HREF="addgroupping.php" target=_blank>แก้ไขข้อมูลสังกัด</A><BR>
<img src="bimg/b_edit.png"> <A HREF="addministry.php" target=_blank>แก้ไขข้อมูลกระทรวง</A><BR><BR>
</td></tr></table>
	<?
		}	  
	?>
	  
	</td></tr>
</table>
</body>
</html>
