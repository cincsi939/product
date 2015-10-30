<?
session_start();
include("checklist2.inc.php");
if($_GET['profile_id'] == ""){
		$profile_id = 6;
}//end if($_GET['profile_id'] == ""){

function ShowProfileNameUp($profile_id){
		global $dbname_temp;
		$sql = "SELECT profilename, profile_id
FROM  tbl_checklist_profile  WHERE profile_id='$profile_id'";
		$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."".__LINE__);
		$rs= mysql_fetch_assoc($result);
		return $rs[profilename];
}// end function ShowProfileNameUp(){


function Getnumpicsys($siteid,$profile_id){
		global $dbname_temp;
		$sql = "SELECT
t1.id,
Count(t2.id) AS numpic,
t3.profile_id,
t3.pic_num,
t3.pic_upload
FROM
cmss_$siteid.general AS t1
Inner Join cmss_$siteid.general_pic AS t2 ON t1.id = t2.id
Inner Join edubkk_checklist.tbl_checklist_kp7 as t3 ON t2.id = t3.idcard
where t3.profile_id='$profile_id' and t3.siteid='$siteid'
GROUP BY t2.id
having numpic > 0 and  t3.pic_num <> numpic";
		$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$numr = mysql_num_rows($result);
		return $numr;
}
	
######################  ประมวลผลจำนวนแผ่นเอกสาร ก.พ.7 #########################
if($_SERVER['REQUEST_METHOD'] == "GET"){
		if($action == "process"){
			$sql = "SELECT
t1.id,
Count(t2.id) AS numpic,
t3.profile_id,
t3.pic_num,
t3.pic_upload
FROM
cmss_$xsiteid.general AS t1
Inner Join cmss_$xsiteid.general_pic AS t2 ON t1.id = t2.id
Inner Join edubkk_checklist.tbl_checklist_kp7 as t3 ON t2.id = t3.idcard
where t3.profile_id='$profile_id' and t3.siteid='$xsiteid'
GROUP BY t2.id
having numpic > 0 and t3.pic_num <> numpic";
//echo $sql."<hr>";
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$sqlup = "UPDATE tbl_checklist_kp7 SET pic_num='$rs[numpic]',pic_upload='$rs[numpic]' WHERE idcard='$rs[id]' and siteid='$xsiteid' and profile_id='$profile_id' ";
		//echo $sqlup."<br>";
		
		
		mysql_db_query($dbname_temp,$sqlup) or die(mysql_error()."$sqlup<br>LINE__".__LINE__);
	}	
			//die;
			echo "<script>alert('ประมวลผลจำนวนแผ่นเอกสารเรียบร้อยแล้ว');location.href='?action=&profile_id=$profile_id';</script>";
		}//endif($action == "process"){
}//end if($_SERVER['REQUEST_METHOD'] == "GET"){


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
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
.style1 {color: #006600}
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
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="8%" align="right"><strong>เลือกโปรไฟร์์ :</strong></td>
          <td width="59%">
          <select name="profile_id" id="profile_id" onChange="gotourl(this)">
          <option value="">เลือกโปรไฟร์</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile WHERE status_update='1' ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<option value="?profile_id=<?=$rsp[profile_id]?>&action=<?=$action?>&lv=<?=$lv?>&xsiteid=<?=$xsiteid?>&schoolid=<?=$schoolid?>" <?=$sel?>><?=$rsp[profilename]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
        </select> 
          
          </td>
          <td width="33%">&nbsp;</td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
<?
	if($action == ""){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="left" bgcolor="#A8B9FF"><strong>รายงานข้อมูลรูปภาพใน checklist ที่ไม่ตรงกับรูปภาพในระบบ cmss   โปรไฟร์ <?=ShowProfileNameUp($profile_id);?></strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#A8B9FF"><strong>ลำดับ</strong></td>
        <td width="44%" align="center" bgcolor="#A8B9FF"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="27%" align="center" bgcolor="#A8B9FF"><strong>จำนวนคนที่รูปในระบบไม่ตรงกับ checklist (คน)</strong></td>
        <td width="24%" align="center" bgcolor="#A8B9FF"><strong>ประมวลผล</strong></td>
      </tr>
      <?
      	$sql = "SELECT t2.secid AS siteid, t2.secname, t1.profile_id FROM edubkk_checklist.tbl_checklist_profile_detail as t1 Inner Join edubkk_master.eduarea as t2 ON t1.siteid = t2.secid
WHERE t1.profile_id='$profile_id' ORDER BY t2.secname ASC";
		$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 	if ($i++ %  2){ 	$bg = "#F0F0F0"; }else{ $bg = "#FFFFFF";	}
				$numpic_false = Getnumpicsys($rs[siteid],$rs[profile_id]);
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[secname]?></td>
        <td align="center"><? if($numpic_false > 0){ echo "<a href='?action=view&xsiteid=$rs[siteid]&profile_id=$rs[profile_id]&secname=$rs[secname]'>".$numpic_false."</a>";}else{ echo "0";}?></td>
        <td align="center"><a href="?action=process&xsiteid=<?=$rs[siteid]?>&profile_id=<?=$profile_id?>">คลิิกเพื่อประมวลผล</a></td>
      </tr>
      <?
	  $numpic_false = 0;
		}//end while($rs = mysql_fetch_assoc($result)){
	 ?>
    </table></td>
  </tr>
</table>
<?
		}//end if($action == ""){
	if($action == "view"){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" align="left" bgcolor="#A8B9FF"><strong> <a href="?action=&profile_id=<?=$profile_id?>">กลับหน้าหลัก</a> || <a href="?action=process&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>">คลิ๊กประมวลผล update จำนวนนับใน checklist </a>||รายงานจำนวนบุคลากรที่จำนวนรูปใน checklist ไม่ตรงกับ ในระบบ cmss 
          <?=$secname?>
        </strong></td>
        </tr>
      <tr>
        <td width="3%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ลำดับ</strong></td>
        <td width="13%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>เลขบัตรประชาชน</strong></td>
        <td width="19%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ชื่อนามสกุล</strong></td>
        <td width="15%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ตำแหน่ง</strong></td>
        <td width="22%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>หน่วยงานสังกัด</strong></td>
        <td colspan="2" align="center" bgcolor="#A8B9FF"><strong>จำนวนคนที่รูปภาพไม่ตรงกัน(คน)</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#A8B9FF">&nbsp;</td>
      </tr>
      <tr>
        <td width="12%" align="center" bgcolor="#A8B9FF"><strong>ใน checklist</strong></td>
        <td width="11%" align="center" bgcolor="#A8B9FF"><strong>ในระบบ cmss</strong></td>
        </tr>
      <?
	  
	  $sql = "SELECT
Count(t2.id) AS numpic,
t3.profile_id,
t3.pic_num,
t3.pic_upload,
t1.CZ_ID as idcard,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t1.schoolname
FROM
cmss_$xsiteid.general_pic AS t2
Inner Join edubkk_checklist.tbl_checklist_kp7 AS t3 ON t2.id = t3.idcard
Inner Join edubkk_master.view_general as t1 ON t1.CZ_ID = t2.id
where t3.profile_id='$profile_id' and t3.siteid='$xsiteid' and t1.siteid='$xsiteid'
GROUP BY t2.id
having numpic > 0 and t3.pic_num <> numpic
order by t1.schoolname asc,t1.name_th ASC, t1.surname_th ASC";
$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
$i=0;
while($rs = mysql_fetch_assoc($result)){
		if ($i++ %  2){ 	$bg = "#F0F0F0"; }else{ $bg = "#FFFFFF";	}
	  
      	$path_file = "../../../".PATH_KP7_FILE."/$rs[siteid]/$rs[idcard]".".pdf";
			if(is_file($path_file)){
				$img_pdf = "<a href='$path_file' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a>";
			}else{
           		$img_pdf = ""; 
           }
		  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><?=$rs[position_now]?></td>
        <td align="left"><?=$rs[schoolname]?></td>
        <td align="center"><?=$rs[pic_num]?></td>
        <td align="center"><?=$rs[numpic]?></td>
        <td align="center"><?=$img_pdf?></td>
      </tr>
      <?
	}//end 
	  ?>
    </table></td>
  </tr>
</table>
<?
	}//end 	if($action == "view"){
?>
</body>
</html>
