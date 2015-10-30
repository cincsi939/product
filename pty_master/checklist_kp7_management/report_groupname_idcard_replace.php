<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");

function GetSecnameAll(){
	global $dbnamemaster;
	$sql = "SELECT secid,secname_short FROM eduarea WHERE secid NOT LIKE '99%' ";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[secid]] = $rs[secname_short];	
	}//end 	while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function GetSecnameAll(){

############  ประมวลผลตรวจสอบข้อมูลชื่อซ้ำกัน
if($_GET['action'] == "process"){
	
	$sql_delete = "DELETE  FROM tbl_checklist_kp7_name_replace  ";
	mysql_db_query($dbname_temp,$sql_delete) or die(mysql_error()."$sql_delete<br>LINE__".__LINE__);
	
	$sql = "INSERT INTO tbl_checklist_kp7_name_replace (idcard,num_row,name_group,prename_th,name_th,surname_th,birthday,begindate,position_now,siteid,schoolid,timeupdate)
	SELECT
idcard,
Count(idcard) AS num1,
concat(trim(name_th),trim(surname_th),birthday,begindate) AS name_group,
prename_th,
name_th,
surname_th,
birthday,begindate,position_now,siteid,schoolid,
NOW()
FROM tbl_checklist_kp7
where status_id_false='0'
group by idcard,name_group";
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	if($result){
				echo "<script> alert('ประมวลผลตรวจสอบข้อมูล');location.href='?action=';</script>";
	}
		
}//end if($_GET['action'] == "process"){


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>รายงานข้อมูลบุคลากรที่ใช้เลขบัตรซ้ำกัน</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<script type=text/javascript src="../../common/jscriptfixcolumn/jquery.min.js"></script>
<script type=text/javascript src="../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></script>
<LINK href="css/style.css" rel=stylesheet>
<script language="javascript">
function mOvr(src,clrOver){ 
	if (!src.contains(event.fromElement)) src.bgColor = clrOver; 
} 

function mOut(src,clrIn){ 
	if (!src.contains(event.toElement)) src.bgColor = clrIn; 
} 
</script>

<script type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
        });
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
<style type="text/css">
<!--
A:link {
	FONT-SIZE: 12px;color: #000000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";TEXT-DECORATION: underline
}
A:visited {
	FONT-SIZE: 12px; COLOR: #000000; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:active {
	FONT-SIZE: 12px; COLOR: #014d5f; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
-->
</style>

<style type=text/css>HTML * {
	FONT-FAMILY: Tahoma, "Trebuchet MS" , Verdana; FONT-SIZE: 11px
}
BODY {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
.baslik {
	TEXT-ALIGN: center; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #6b8e23; PADDING-LEFT: 5px; PADDING-RIGHT: 5px; COLOR: white; FONT-WEIGHT: bold; PADDING-TOP: 5px
}
.tdmetin {
	PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #dcdcdc; PADDING-LEFT: 5px; PADDING-RIGHT: 5px; COLOR: #00008b; FONT-WEIGHT: bold; PADDING-TOP: 5px
}
.code {
	BORDER-BOTTOM: #cccccc 1px solid; BORDER-LEFT: #cccccc 1px solid; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #eeeeee; PADDING-LEFT: 5px; WIDTH: 400px; PADDING-RIGHT: 5px; BORDER-TOP: #cccccc 1px solid; BORDER-RIGHT: #cccccc 1px solid; PADDING-TOP: 5px
}
.highlight {
	BACKGROUND-COLOR: highlight !important
}
.highlight2 {
	BACKGROUND-COLOR: #CCCCCC !important; COLOR: black
}
.tbl1 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
.tbl2 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
.tbl3 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="1" cellspacing="1" cellpadding="3" class="tbl3">
      <tr>
        <td colspan="9" align="left" bgcolor="#CCCCCC"><strong><a href="?action=process">ประมวลผลตรวจสอบข้อมูล</a> || รายชื่อบุคลากรที่ใช้เลขบัตรประจำตัวประชาชนซ้ำกัน <a href="#" onClick="window.open('../../report/report_keydata_popup.php','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=800,height=550');"><img src="../validate_management/images/cog_edit.png" width="16" height="16" border="0" title="คลิ๊กเพื่อกำหนดโฟร์ไฟล์ข้อมูล"></a></strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>เลขบัตรประชาชน</strong></td>
        <td width="8%" align="center" bgcolor="#CCCCCC"><strong>คำนำหน้าชื่อ</strong></td>
        <td width="8%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ</strong></td>
        <td width="10%" align="center" bgcolor="#CCCCCC"><strong>นามสกุล</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>วันเดือนปีเกิด</strong></td>
        <td width="10%" align="center" bgcolor="#CCCCCC"><strong>วันเริ่มปฏิบัติราชการ</strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td width="18%" align="center" bgcolor="#CCCCCC"><strong>หน่วยงานสังกัด</strong></td>
      </tr>
      <?
	  	 	$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
			$e			= (!isset($e) || $e == 0) ? 100 : $e ;
			$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 

	  
	  
      	$sql_main = "SELECT
Count(idcard) AS num1,
t1.idcard,
t1.num_row,
t1.name_group,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t1.begindate,
t1.position_now,
t1.siteid,
t1.schoolid
FROM `tbl_checklist_kp7_name_replace` as t1
where trim(t1.name_group) <> ''
group by t1.idcard
having num1 > 1
order by t1.idcard  asc
";

	$xresult = mysql_db_query($dbname_temp,$sql_main);
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
		
	if($page <= $allpage){
			$sql_main .= " LIMIT $i, $e";
	}else if($page == $xpage){
		$i=0;
			$sql_main .= " ";
	}else{
			$sql_main .= " LIMIT $i, $e";
	}

		$result_main = mysql_db_query($dbname_temp,$sql_main);
		$num_row = mysql_num_rows($result_main);
		$search_sql = $sql_main ; 

		$arr_secname = GetSecnameAll();
		while($rs = mysql_fetch_assoc($result_main)){
		$i++;
			 
			echo "<tr bgcolor='#CCCCCC'>
			<td align=\"center\"><b>$i</b></td>
			<td colspan='8'><b>$rs[idcard]</b></td>
			</tr>"; 
			$sql1 = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$rs[idcard]' order by name_th,surname_th ASC";
			$result1 = mysql_db_query($dbname_temp,$sql1) or die(mysql_error()."$sql1<br>".__LINE__);
			while($rs1 = mysql_fetch_assoc($result1)){

	  ?>
      <tr bgcolor="#FFFFFF">
        <td align="right" colspan="3"><?=$rs1[prename_th]?>
          &nbsp;&nbsp;</td>
        <td align="left"><?=$rs1[name_th]?></td>
        <td align="left"><?=$rs1[surname_th]?></td>
        <td align="center"><?=GetDateThaiFull($rs1[birthday])?></td>
        <td align="center"><?=GetDateThaiFull($rs1[begindate])?></td>
        <td align="left"><?=$rs1[position_now]?></td>
        <td align="left"><?
        	$sql_org = "SELECT office,prefix_name FROM allschool WHERE id='$rs1[schoolid]'";
			$result_org = mysql_db_query($dbnamemaster,$sql_org) or die(mysql_error()."".__LINE__);
			$rsorg = mysql_fetch_assoc($result_org);

			
			echo $arr_secname[$rs1[siteid]]."/".$rsorg[prefix_name].$rsorg[office];
		?></td>
      </tr>
        <?
			}//end while($rs1 = mysql_fetch_assoc($result1)){

      	}//end while($rs = mysql_fetch_assoc($result)){
	  ?>

      <tr bgcolor="#FFFFFF">
        <td align="center" colspan="9"><? $sqlencode = urlencode($search_sql)  ; ?>	
	<?=devidepage($allpage, $keyword ,$sqlencode )?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
