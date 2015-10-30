<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_tranfer.php");
include("function_j18.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
	if($action == "process"){
			if(count($arr_id) > 0){
					foreach($arr_id as $key => $val){
							$sql_del = "DELETE  FROM tbl_checklist_kp7 WHERE idcard='$val' AND siteid='$xsiteid' AND profile_id='$profile_id'";
							mysql_db_query($dbname_temp,$sql_del) or die(mysql_error()."$sql_del<br>LINE__".__LINE__);
							#echo $sql_del."<br>";
							$sql_up = "UPDATE log_import_cmss_detail SET status_del='1'  WHERE import_id='$import_id' AND idcard='$val' AND siteid='$xsiteid' AND profile_id='$profile_id'";
							#echo $sql_up."<br>";
							mysql_db_query($dbname_temp,$sql_up) or die(mysql_error()."$sql_up<br>LINE__".__LINE__);
					}//end 	foreach($arr_id as $key => $val){
					echo "<script>alert('ลบรายการใน checklist เรียบร้อยแล้ว');location.href='?action=&xsiteid=$xsiteid&profile_id=$profile_id&import_id=$import_id';</script>";	
					exit();
			}//endif(count($arr_id) > 0){ 
	}// end if($action == "process"){
		
}// end if($_SERVER['REQUEST_METHOD'] == "POST"){



###  end ประมวลผลรายการ
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript" src="../../common/jquery_1_3_2.js"></script>
<script language="javascript">

function checkAll(){
	checkall('tbldata',1);
}//end function checkAll(){

function UncheckAll(){
	checkall('tbldata',0);	
}

function checkall(context, status){	
	$("#"+context).find("input[type$='checkbox']").each(function(){
				$(this).attr('checked', status);	
	});
	
}//end function checkall(context, status){	



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

</head>
<body>
<form name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3"  id="tbldata">
        <tr>
          <td colspan="7" align="left" bgcolor="#CCCCCC"><strong>รายการข้อมูลที่ซ้ำกับเขตนำร่อง ตรวจสอบข้อมูลเพื่อทำการลบรายการออกจาก checklist <?=show_area($xsiteid);?></strong></td>
          </tr>
        <tr>
          <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
          <td width="14%" align="center" bgcolor="#CCCCCC"><strong>เลขบัตร</strong></td>
          <td width="17%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล</strong></td>
          <td width="20%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
          <td width="23%" align="center" bgcolor="#CCCCCC"><strong>ซ้ำกับสำนักงานเขตพื้นที่การศึกษา</strong></td>
          <td width="7%" align="center" bgcolor="#CCCCCC"><strong>ก.พ.7 ต้นฉบับ</strong></td>
          <td width="14%" align="center" bgcolor="#CCCCCC"><strong>
            <input  type="button" value="เลือกทั้งหมด" onclick="checkAll()" /> 
            <input  type="button" value="ยกเลิกทั้งหมด" onclick="UncheckAll()" />
          </strong></td>
        </tr>
        <?
        	$sql = "SELECT
t1.idcard,
t1.siteid,
t1.profile_id,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t1.siteid_replace,
t2.secname,
t1.status_replace_sitecon
FROM
edubkk_checklist.log_import_cmss_detail AS t1
Inner Join edubkk_master.eduarea AS t2 ON t1.siteid_replace = t2.secid
WHERE
t1.siteid =  '$xsiteid' AND
t1.profile_id =  '$profile_id' AND
t1.status_replace_sitecon =  '1' AND
t1.import_id = '$import_id'
and t1.status_del='0'";
		$result = mysql_db_query($dbname_temp,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 	$file_pdf = "../../../".PATH_KP7_FILE."/$xsiteid/$rs[idcard]".".pdf";
			 	if(is_file($file_pdf)){
					$img_pdf = "<a href='$file_pdf' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a>";
					$disable_ch = "";
				}else{
					$img_pdf = "";
					//$disable_ch = "disabled='disable_ch'";
				}//end if(is_file($file_pdf)){
		?>
        <tr bgcolor="<?=$bg?>">
          <td align="center"><?=$i?></td>
          <td align="center"><?=$rs[idcard]?></td>
          <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
          <td align="left"><? echo $rs[position_now];?></td>
          <td align="left"><? echo "$rs[secname]";?></td>
          <td align="center"><?=$img_pdf?></td>
          <td align="center">  <input type="checkbox" name="arr_id[<?=$i?>]" id="listname" value="<?=$rs[idcard]?>" ></td>
        </tr>
        <?
		}//end while($rs = mysql_fetch_assoc($result)){
		?>
        <tr>
          <td colspan="7" align="center" bgcolor="#CCCCCC">
          <input type="hidden" name="action" value="process">
          <input type="hidden" name="profile_id" value="<?=$profile_id?>">
          <input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
          <input type="hidden" name="import_id" value="<?=$import_id?>">
           <input type="submit" name="button" id="button" value="ลบข้อมูล"></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
