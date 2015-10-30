<?
session_start();
include "epm.inc.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="../../common/style.css" type="text/css" rel="stylesheet">
</head>
<body bgcolor="#F2F4F7">
<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width="100%" ALIGN=CENTER>
<TR VALIGN=TOP><TD width="155%" ALIGN=LEFT>
<table width="100%" border=0 align=center cellspacing=1 cellpadding=2 bgcolor="#dddddd">
<tr bgcolor="#A0A0A0">
<th width="150" bgcolor="#88AACC">วันที่/เวลา</th>
<th width="100" bgcolor="#88AACC">IP Address</th>
<th bgcolor="#88AACC">รายละเอียด</th>
</tr>

<?
// paging
if (!isset($LinePerPage)) $LinePerPage = 20; //default line per page
$lpp = $LinePerPage;
$p = intval($p);
if ($p <= 0) $p = 1;
$result = mysql_query("select count(staffid) as total from epm_log where staffid='$_SESSION[session_staffid]';");	
$rs = mysql_fetch_assoc($result);
$totalpage = intval((intval($rs[total]) + $lpp - 1) / $lpp);
$n= ($p - 1) * $lpp;



$sql = "select * from epm_log where staffid='$_SESSION[session_staffid]' order by logtime desc  limit $n,$lpp;";
$result = mysql_query($sql);
$n=0;
while ($rs =  mysql_fetch_assoc($result)){
	if ($n++ % 2) $bg="#FFFFFF"; else $bg="#FFFFCC";
?>

<tr bgcolor="<?=$bg?>">
<td align=center><?=($rs[logtime])?></td>
<td align=center><?=$rs[ip]?></td>
<td align=left><?=$rs[detail]?></td>
</tr>
<?
}	
?>

<TR BGCOLOR="#DDDDDD">
	<TD height="30" COLSPAN='3' align=left bgcolor="#DDDDDD"> &nbsp; <B>หน้าที่ 
<?
for ($i=1;$i<=$totalpage;$i++){
	if ($i == $p){
		echo "[<font color=\"red\"><B>$i</B></font>]&nbsp;";
	}else{
		echo "<A HREF=?p=$i>$i</A> ";
	}
}

?>	</B></TD>
</TR>
</table>
</TD></TR>
</TABLE>
</BODY>
</HTML>