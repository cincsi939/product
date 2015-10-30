
<?

session_start();
ob_start();
echo $_SESSION[siteid] ;
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################

$ApplicationName	= "competency_search_people";
$module_code 		= "search_people"; 
$process_id			= "search_people";
$VERSION 				= "9.91";
$BypassAPP 			= true;

#########################################################
#Developer 	:: 
#DateCreate	::17/07/2007
#LastUpdate	::17/07/2007
#DatabaseTabel::
#END<a href="../../../AppServ/www/democmss/application/hr3/tool_competency/tranferuser/function_tranfer.inc.php">function_tranfer.inc.php</a>
#########################################################

//include("session.inc.php");
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();
include("../../../config/phpconfig.php");
//include("db.inc.php");
//include("../tool_competency/tranferuser/function_tranfer.inc.php");

include("function_tranfer.inc.php");
//conn2DB();
//mysql_free_result($result2);
//unset($rs2,$sql2,$selected);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../libary/style.css" type="text/css" rel="stylesheet">
<title>ค้นหาบุคลากร</title>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-bottom:1px solid #FFFFFF">
  <tr style=" border-bottom:1px solid #FFFFFF" align="right">
    <td height="50" background="images/report_banner_01.gif"><img src="images/report_banner_03.gif" width="365" height="50" /></td>
  </tr>
  <tr align="right" >
    <td style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#868E94', EndColorStr='#ffffff')">&nbsp;</td>
  </tr>
</table>

<form name="post" method="post" action="list_people.php" onsubmit="return check();">
<table border="0" width="99%" cellspacing="1" cellpadding="2" bgcolor="black" align="center" style="margin-top:5px;">
<tr bgcolor="#A3B2CC">
	<td width="12%" height="25" align="right"><p>ค้นหารายชื่อบุคลากร&nbsp;&nbsp;</p>	  </td>
    <td width="88%" align="left">&nbsp;ชื่อ 
	  <input name="name_th" type="text" style="width:100px;" value="<?=$name_th?>" />
	  นามสกุล 
	  <input name="surname_th" type="text" style="width:100px;" value="<?=$surname_th?>" />
	  เลขบัตรประชาชน
    <input name="idcard" type="text" id="idcard" value="<?=$idcard?>" />
	<label></label>
	
	&nbsp;
	<input name="sub" type="submit" value="Search" />
    <input name="button" type="button" onclick="window.location.href('<?=$PHP_SELF?>')" value="reset" />
    <input type="hidden" name="action" value="view" />
    <label></label></td>
</tr>
</table>
</form>
<? 

$action=$_REQUEST['sub'];

$name_th=$_REQUEST['name_th'];
$units=$_REQUEST['unit'];
$position_now=$_REQUEST['position_now'];
$surname_th=$_REQUEST['surname_th'];
$idcard=$_REQUEST['idcard'];
?>
<div align="right" style="display:none;">เพื่อความรวดเร็วในการแสดงผล ระบบจะแสดง 50 อันดับแรก&nbsp;&nbsp;</div>
<table border="0" width="99%" cellspacing="1" cellpadding="2" bgcolor="black" align="center" style="margin-top:5px;">
<tr bgcolor="#A3B2CC">
	<th width="5%"> ลำดับที่ </th>
	<th width="10%">เลขบัตรประชาชน</th>
	<th width="15%"> ชื่อ-นามสกุล</th>
	<th width="20%">ตำแหน่งปัจจุบัน</th>
	<th width="7%">สถานะ<br />การรับรองข้อมูล</th>
    <th width="7%">ทะเบียนประวัติ<br />
    (ก.พ.7)</th>
</tr>
<?           
$i 	= $x	= 0;

 if($name_th=="")  {
    $name_th	= (!empty($name_th)) ? " general.name_th like '%".trim($name_th)."%' " : "" ;
 }else {
  $name_th	= (!empty($name_th)) ? " general.name_th like '%".trim($name_th)."%' and  " : "" ;
 }

 if($surname_th=="") {
    $surname_th = (!empty($surname_th)) ? "general.surname_th like '%".trim($surname_th)."%' " : "" ;
 }else {
   $surname_th = (!empty($surname_th)) ? "general.surname_th like '%".trim($surname_th)."%'and " : "" ;
 }

 if ($idcard=="") {
    $idcard = (!empty($idcard)) ? " general.idcard like '%".trim($idcard)."%' " : "" ;
 }else {
   $idcard = (!empty($idcard)) ? " general.idcard like '%".trim($idcard)."%' and"  : "" ;
 }

 if($allschool=="") {
    $allschool = (!empty($units)) ? "  allschool.id='$units' and  general.schoolid='$units' and  " : "" ;
 }else {
    $allschool = (!empty($units)) ? "  allschool.id='$units' and  general.schoolid='$units' " : "" ;
 }

 if($position=="") {
 $position = (!empty($position_now)) ? " general.position_now like '".trim($position_now)."' and  " : "" ;
 }else {
$position = (!empty($position_now)) ? " general.position_now like '".trim($position_now)."' " : "" ;
 }
if($action!="") {
    $Stotal = mysql_query("select general.id, general.idcard, general.prename_th, general.name_th, general.surname_th,general.position_now, general.approve_status,general.siteid, login.office,allschool.siteid,allschool.office
 from allschool Inner Join general ON allschool.siteid = general.siteid Inner Join login ON general.unit = login.id 
    where   $name_th  $surname_th  $idcard  $position $allschool  general.siteid='$_SESSION[siteid]'  group by idcard  DESC"); 
    $total = mysql_num_rows($Stotal);
    $start= 0;
    
	$limit = '50';
	if((!empty($page)) AND ($page != "1")) {
	$start = (($page -1) * $limit);
	}

  $sql2= "select general.id, general.idcard, general.prename_th, general.name_th, general.surname_th,general.position_now, general.approve_status,general.siteid, login.office,allschool.siteid,allschool.office
 from general  left  Join  allschool  ON  general.schoolid  = allschool.id  	 
 Inner Join login ON general.unit = login.id  where  $name_th  $surname_th  $idcard $position $allschool  general.siteid='$_SESSION[siteid]' group by idcard  LIMIT $start,$limit"; 
  $result2 = mysql_query($sql2)or die("Query Line " . __LINE__ . " Error<hr>".mysql_error());

     if(mysql_num_rows($result2) >= 1){
     while($rs = mysql_fetch_assoc($result2)){
    $i += 1;

    $idg=$rs[id];
	$color 		= ($i%2 == 0) ? "#DDDDDD" : "#EFEFEF" ;
	$inside		= ($rs[inside] == "1") ? "( มาช่วยราชการ )" : "" ;
	$outside	= ($rs[outside] == "1") ? "( ไปช่วยราชการ )" : "" ;
	$approve	= ($rs[approve_status] == "approve") ? "../images/approve.gif" : "../images/web/alert.gif" ;
	$aimg		= "<img src=\"".$approve."\" width=\"16\" height=\"16\">";
	
	if($_SESSION[isprivilage] == "super"){
		$pdf		= "<a href=\"kp7.php?id=".$rs[id]."\" target=\"_blank\">";
		$pdf		.= "<img src=\"bimg/pdf.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"></a>";
	}else {
	$pdf	="&nbsp;";
	}
?>
<tr align="center" bgcolor="<?=$color?>" onmouseover="mOvr(this,"dbf2ae");" onmouseout="mOut(this,"<?=$color?>");">
	<td height="20"><?=$start+$i?></td>	
	<td align="left"><?=$rs[idcard]?></td>
	<td align="left">&nbsp;<?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]."&nbsp;".$inside.$outside?></td>
	<td align="left"><?=$rs[position_now]?></td>
	<td><?=$aimg?></td>
    <td><?=$pdf?></td>
</tr>
<? 	
} 
mysql_free_result($result);
} else {
	echo "<tr bgcolor=\"#ffffff\" align=\"center\"><td height=\"25\" colspan=\"6\">ไม่พบข้อมูล</td></tr>";
}
$name_th=$_REQUEST['name_th'];
$units=$_REQUEST['unit'];
$position_now=$_REQUEST['position_now'];
$surname_th=$_REQUEST['surname_th'];
$idcard=$_REQUEST['idcard'];
?>	
</table>
<?
		$page = ceil($total/$limit); 
		for($i=1;$i<=$page;$i++){
		if($_GET['page']==$i){
		echo "|<a href='?start=".$limit*($i-1)."&page=$i&name_th=$name_th&surname_th=$surname_th&idcard=$idcard&
		position_now=$position_now&unit=$units&siteid=$_SESSION[siteid] &sub=$action'><B>$i</B> </A>"; 
		}else{
		echo "|<a href='?start=".$limit*($i-1)."&page=$i&name_th=$name_th&surname_th=$surname_th&siteid=$_SESSION[siteid]&idcard=$idcard
		&unit=$units&position_now=$position_now&sub=$action'>$i </A>"; 
		}
		} 
}

?>
<? include("licence_inc.php");  ?>
</body>
</html>
<?//  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>