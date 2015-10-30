<?
session_start();
$ApplicationName	= "userentry";
$module_code 		= "report_monitor_keyupdate"; 
$process_id			= "report_monitor_keyupdate";
$VERSION 				= "9.91";
$BypassAPP 			= true;
ob_start(); 

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110709.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-07-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110709.00
	## Modified Detail :		รายงานสำหรับแสดงผลการบันทึกข้อมูล update
	## Modified Date :		2011-07-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
			require_once("../../../config/conndb_nonsession.inc.php");
			include ("../../../common/common_competency.inc.php")  ;
			include("../function_face2cmss.php");
			include("../function_date.php");
			include("../function_get_data.php");
			include("function_report_keyupdate.php");
		
			$datenotcal = "2011-07-04";
			
			if($start_date == "" and $end_date == ""){
				$date1 = "2011-06-27";
				$date2 = "2011-07-25";
			}else{
				$date1 = GetDateDB($start_date);
				$date2 = GetDateDB($end_date);
			}

			if($prov_site == ""){
					$prov_site = 1;
			}
			if($status_permit == ""){
					$status_permit = "YES";
			}
			$in_site_id = GetInSite_id($prov_site);
			if($in_site_id != ""){
					$conv = " AND t1.site_id IN($in_site_id)";
			}
		
			$count_yy = date("Y")+543;
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

			
			$time_start = getmicrotime();

			
	function ShowStartdate($staffid){
	global $dbnameuse;
	$sql = "SELECT start_date FROM `keystaff` where staffid='$staffid' group by staffid";	
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[start_date] != "" and $rs[start_date] != "0000-00-00"){
		return ShowDateThai($rs[start_date]);
	}else{
		return "";	
	}
}
			
			
	function ShowDateThai($get_date){
		global $mname;
		$arr = explode(" ",$get_date);
		if($arr > 1){
			$get_date = $arr[0];
		}
		if($get_date != "0000-00-00"){
			$arr1 = explode("-",$get_date);	
			return intval($arr1[2])." ".$mname[intval($arr1[1])]." ".substr(($arr1[0]+543),-2);
		}else{
			return "";	
		}
	}//end function ShowDateThai($get_date){
		


		
		


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
</head>


<link href="../../../common/style.css" type="text/css" rel="stylesheet">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script src="../../../common/gs_sortable.js"></script>
<script type=text/javascript src="../../../common/jscriptfixcolumn/jquery.min.js"></script>
<script type=text/javascript src="../../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></script>
<script type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
        });
</script>
<link href="../../../common/gs_sortable.css" />
<style>
.txtcolor{
	color: #FF0000;
}

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

<BODY >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#CCCCCC"><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="13%" align="right"><strong>จังหวัด : </strong></td>
          <td width="54%" align="left">
		    <select name="prov_site" id="prov_site">
            <option value=""> - เลือกจังหวัดคีย์ - </option>
		    <?
          $sql_prov = "SELECT t1.profile_id, t1.profile_name FROM keyin_area_profile as t1 WHERE t1.status_active='1' ORDER BY t1.profile_name ASC";
		  $result_prov = mysql_db_query($dbnameuse,$sql_prov) or die(mysql_error()."$sql_prov".__LINE__);
		  while($rsp = mysql_fetch_assoc($result_prov)){
			  if($rsp[profile_id] == $prov_site){ $sel = " selected='selected'";}else{ $sel = "";}
				 	 echo "<option value='$rsp[profile_id]' $sel>$rsp[profile_name]</option>";
			}//end while($rsp = mysql_fetch_assoc($result_prov)){
		  ?>
              </select>
          </td>
          <td width="33%" align="left">&nbsp;</td>
          </tr>
        <tr>
          <td align="right"><strong>สถานะการทำงาน : </strong></td>
          <td align="left"><input type="radio" name="status_permit" id="radio1" value="YES" <? if($status_permit == "YES"){ echo " checked='checked'";}?>>
            ยังทำงานอยู่
              
              <input type="radio" name="status_permit" id="radio2" value="NO" <? if($status_permit == "NO"){ echo " checked='checked'";}?>>
              ออกงานไปแล้ว
             </td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td align="left"><input type="submit" name="btn_view" id="btn_view" value="แสดงรายงาน"></td>
          <td align="left">&nbsp;</td>
          </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3" id="my_table" >
      <thead>  
      <tr>
        <td colspan="4" align="center" bgcolor="#CCCCCC"><strong> รายงานการที่ค้างบันทึกข้อมูลแก้ไขจุดผิด <?=GetProvinceKeyData($prov_site);?> สถานะการทำงาน : <? if($status_permit == "YES"){ echo " ยังทำงานอยู่";}else{ echo "ลาออกไปแล้ว";}?></strong></td>
      </tr>
      <tr>
        <th width="7%" align="center" bgcolor="#CCCCCC">ลำดับ</th>
        <th width="14%" align="center" bgcolor="#CCCCCC">รหัสพนักงาน</th>
        <th width="52%" align="center" bgcolor="#CCCCCC">ชื่อ นามสกุล</th>
        <th width="27%" align="center" bgcolor="#CCCCCC">ค้างแก้ไข(คน)</th>
      </tr>
      	</thead>    
	<tbody>   
      <?
	  
	$sql = "SELECT
t1.staffid,
t1.prename,
t1.staffname,
t1.staffsurname,
t1.status_permit,
t1.status_extra,
count( distinct t2.idcard) as num1
FROM
keystaff as t1
Left Join validate_checkdata_upload as t2 ON t1.staffid = t2.staffid
WHERE t1.status_permit='$status_permit' AND t1.status_extra='NOR'  and t2.status_edit='NO' $conv
GROUP BY t1.staffid
ORDER BY t1.staffname,t1.staffsurname ASC";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
	if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}

		 

	
	  ?>

      <tr bgcolor="<?=$bg?>">
        <td align="center" width="7%"><?=$i?></td>
        <td align="center" nowrap="nowrap" width="14%"><?=$rs[staffid]?></td>
        <td align="left" nowrap="nowrap" width="52%"><? echo "$rs[staffname]  $rs[staffsurname]";?></td>
        <td align="center" nowrap="nowrap" width="27%"><? if($rs[num1] > 0){ echo "<a href='report_monitor_editkey_detail.php?staffid=$rs[staffid]&fullname=$rs[prename]$rs[staffname]  $rs[staffsurname]' target=\"_blank\">".number_format($rs[num1])."</a>";}else{ echo 0;}?></td>
        </tr>
 
      <?
 
	}//end  while($rs = mysql_fetch_assoc($result)){
	  ?>
           </tbody>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table> 
<script type="text/javascript">
<!--
var TSort_Data = new Array ('my_table','','h','h','h');
var TSort_Classes = new Array ('row1', 'row2');
tsRegister();
// -->
</script> 

<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
 ob_end_flush();    ?>

</body>
</html>


