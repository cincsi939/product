<?
session_start();
$ApplicationName	= "userentry";
$module_code 		= "manage_keyin_data"; 
$process_id			= "report_staffkey_addpercen";
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
	## Modified Detail :		รายงานคะแนนเพิ่มการบันทึกข้อมูลของพนักงานคีย์ข้อมูล
	## Modified Date :		2011-07-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
			require_once("../../../config/conndb_nonsession.inc.php");
			include ("../../../common/common_competency.inc.php")  ;
			include("../function_face2cmss.php");
			include("../function_date.php");
			include("../function_get_data.php");
			include("function_add_percen.php");
			if($prov_id == ""){
				$prov_id = 1; // รหัสจังหวัดเชียงใหม่
			}
			
			$k12 = 0.1051;
			$percenadd = 5;
			$datenotcal = "2011-07-04";
			
			if($start_date == "" and $end_date == ""){
				$date1 = "2011-06-27";
				$date2 = "2011-07-25";
			}else{
				$date1 = GetDateDB($start_date);
				$date2 = GetDateDB($end_date);
			}


	
			$count_yy = date("Y")+543;
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

			
			$time_start = getmicrotime();
			$arrsite = GetSiteKeyData();
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			
			$in_site_id = GetInSite_id($prov_id);
			
			
	######################  ประมวลผล script #############################
	

	
	
	####################### end ประมวลผล Script ########################
			
			
			
			
			
			
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

		
		
function GetMenuQC(){
	global $dbnameuse;
		$sql = "SELECT t1.checkdata_id, t1.dataname FROM validate_datagroup as t1 where t1.parent_id='0'";	
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[checkdata_id]] = $rs[dataname];	
		}// end while($rs = mysql_fetch_assoc($result)){
			return $arr;
}//end function GetMenuQC(){
$arr_menu = array();
$arr_menu = GetMenuQC();
$num_menu = count($arr_menu);
if($num_menu > 0){
	$Cw = floor(55/$num_menu);
	$mod1 = 55%$num_menu;
}else{
	$Cw = 55;	
}


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
          <td width="10%" align="right"><strong>วันที่เริ่มต้น : </strong></td>
          <td width="57%" align="left"><INPUT name="start_date" onFocus="blur();" value="<?=GetDateFrom($date1)?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.start_date, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
          <td width="33%" align="left">&nbsp;</td>
          </tr>
        <tr>
          <td align="right"><strong>วันที่สิ้นสุด : </strong></td>
          <td align="left"><INPUT name="end_date" onFocus="blur();" value="<?=GetDateFrom($date2)?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.end_date, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
          <td align="left">&nbsp;</td>
          </tr>
        <tr>
          <td align="right"><strong>จังหวัดบันทึกข้อมูล :</strong></td>
          <td align="left">
            <select name="prov_id" id="prov_id">
            <option value=""> เลือกจังหวัดคีย์ข้อมูล </option>
            <?
            	$sql_prov = "SELECT profile_id, profile_name FROM keyin_area_profile ORDER BY profile_name ";
				$result_prov = mysql_db_query($dbnameuse,$sql_prov);
				while($rsp = mysql_fetch_assoc($result_prov)){
					if($prov_id == $rsp[profile_id]){ $sel = " selected='selected'";}else{ $sel = "";}
					echo "<option value='$rsp[profile_id]' $sel>$rsp[profile_name]</option>";	
				}//end while($rsp = mysql_fetch_assoc($result_prov)){
			?>
            </select></td>
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
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3" id="my_table">
      <thead>  
      <tr>
        <td colspan="6" align="center" bgcolor="#CCCCCC"><strong> รายงานข้อมูลจุดผิดแยกรายหมวดข้อมูลระหว่างวันที่
<?=DBThaiLongDateFull($date1)?> ถึงวันที่ <?=DBThaiLongDateFull($date2)?> ของจังหวัด <?=GetProvinceKeyData($prov_id)?></strong></td>
        </tr>
      <tr>
        <th width="4%" align="center" bgcolor="#CCCCCC"><span class="txthead">ลำดับ</span></th>
        <th width="11%" align="center" bgcolor="#CCCCCC"><span class="txthead">ชื่อ นามสกุล</span></th>
        <th width="7%" align="center" bgcolor="#CCCCCC"><span class="txthead">กลุ่ม</span></th>
        <th width="9%" align="center" bgcolor="#CCCCCC"><span class="txthead">วันที่เริ่มทำงาน</span></th>
        <th width="15%" align="center" bgcolor="#CCCCCC"><span class="txthead">ศูนย์คีย์ฯ</span></th>
        <th width="54%" align="center" bgcolor="#CCCCCC">&nbsp;</th>
        </tr>
      	</thead>    
	<tbody>   
      <?
	  
	  			if($in_site_id != ""){
					$conin = " AND  t1.site_id IN($in_site_id)";
			}else{
					$conin = "";
			}

	  
      	$sql = "SELECT
t1.staffid,
t1.id_code,
t2.groupname,
t1.prename,
t1.staffname,
t1.staffsurname,
t1.start_date,
t1.site_id
FROM
keystaff AS t1
Left Join keystaff_group as t2 ON t1.keyin_group = t2.groupkey_id
where  t1.status_permit='YES' and t1.status_extra='NOR' AND t1.period_time='am' $conin
ORDER BY t1.keyin_group ASC,t1.staffname asc,t1.staffsurname asc
";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
	if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}


	
	  ?>

      <tr bgcolor="<?=$bg?>">
        <td align="center" width="4%"><?=$i?></td>
        <td align="left" nowrap="nowrap" width="11%"><? echo "$rs[prename]$rs[staffname] $rs[staffsurname]";?></td>
        <td align="center" nowrap="nowrap" width="7%"><?=$rs[groupname]?></td>
        <td align="center" nowrap="nowrap" width="8%"><?
        	if($rs[start_date] != "" and $rs[start_date] != "0000-00-00"){
		echo  ShowDateThai($rs[start_date]);
	}else{
		echo  "";	
	}

		?></td>
        <td align="left" nowrap="nowrap" width="15%"><?=$arrsite[$rs[site_id]]?></td>
        <td align="center" width="55%">&nbsp;</td>
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
var TSort_Data = new Array ('my_table','','h','h', 'g','h','g','g','g','g','g','g','g','g','g','g');
var TSort_Classes = new Array ('row1', 'row2');
tsRegister();
// -->
</script> 

<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
 ob_end_flush();    ?>

</body>
</html>


