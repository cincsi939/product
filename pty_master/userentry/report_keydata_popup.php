<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
$ApplicationName	= "competency_percenentry_byarea";
$module_code 		= "percenentry_byarea"; 
$process_id			= "percenentry_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		Rungsit
	## E-mail :			
	## Tel. :			
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		ระบบฐานข้อมูลบุคลากร
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################

session_start() ; 
set_time_limit(0) ; 
if ( $_SESSION[siteid]   != ""){ 
	# $_SESSION[reportsecid]
} 
if ($xsiteid == ""){ $xsiteid = $_SESSION[siteid]  ;    $xxsiteid = $xsiteid  ; } 

if ($loginid != ""){   $xxsiteid = $loginid  ; } 
if ($_SESSION[reportsecid] == "cmss-otcsc" ){
	########### ok 
} ### END if ($_SESSION[reportsecid] == "cmss-otcsc" ){
//
/*echo "<pre>";
print_r($_SESSION);
*/
$link_file = "percen_entry_v5sc_appv_detail.php";
$link_file1 = "percen_entry_v5sc_appv.php";
if($xsiteid != ""){ $xsiteid = $xsiteid;}else{ $xsiteid = "5006";}; // กรณีทดสอบในเครื่อง

$edubkk_master = DB_MASTER; 
$lead_general = "general";
$view_general = "view_general";
$now_dbname = STR_PREFIX_DB. $xxsiteid ; 

include("../config/conndb_nonsession.inc.php");
include("../common/common_competency.inc.php");
//include("../common/class.loadpage.php");
include("positionsql.inc_v2.php");
include("percen_entry_v4.inc.php");

$date_conf = "2009-11-01";// fix ปี
$dbname_temp = DB_CHECKLIST;

function maxPorfile(){
		global $dbname_temp;
		$sql = "SELECT MAX(profile_id) as maxprofile  FROM tbl_checklist_profile";
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[maxprofile];
}//end function maxPorfile(){

$time_start = getmicrotime();



	
	$month = array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$dd = date("j")   ; 
	$mm1 = date("n")  ; 
	$mm =  $month[$mm1] ; 
	$yy = date("Y") + 543 ; 
	$nowdd = " $dd $mm  $yy "  ; 
	$view_general = "view_general" ; 
	$date_curent = intval(date("d"))." ".$month[intval(date("m"))]." ".(date("Y")+543);

$getdepid = $depid ;

if($_SERVER['REQUEST_METHOD'] == "POST"){
	if($Aaction == "Process"){
	$arr_pro = explode("||",$profile_id);
	if(count($arr_pro) > 1){
		$profile_id = $arr_pro[0]; //กรณีเป็น profile_ส่งงาน
		$sql_file = "SELECT
distinct tbl_cmss_profile_new.profile_id,
tbl_checklist_report.file_process
FROM
tbl_checklist_report
Inner Join tbl_cmss_profile_new ON tbl_checklist_report.report_id = tbl_cmss_profile_new.report_id
WHERE tbl_checklist_report.report_id='$profile_id'";
		$result_file = mysql_db_query($dbname_temp,$sql_file) or die(mysql_error()."<br>".$sql_file);
		$rsf = mysql_fetch_assoc($result_file);
		$file_reload = "$rsf[file_process]?xprofile_id=$profile_id&profile_id=$rsf[profile_id]";
	}else{
		$profile_id = $profile_id;
		$file_reload = "report_keydata_main.php?profile_id=$profile_id";
	}
	
	if($profile_id == "225"){
		$maxprofile = maxPorfile();
			$file_reload = "report_keydata_main_all_new.php?profile_id=$maxprofile";
			echo "<script language=\"javascript\">
window.opener.location='$file_reload&xlv=$xlv&col1=$col1&col2=$col2&col3=$col3&col4=$col4&col5=$col5&col6=$col6&col7=$col7&col8=$col8&col9=$col9&col10=$col10&col11=$col11&col12=$col12&col12_1=$col12_1&col13=$col13&col14=$col14&col14_1=$col14_1&col15=$col15&conF=1';window.close();
</script>
";
	}else{
echo "<script language=\"javascript\">
window.opener.location='$file_reload&xlv=$xlv&col1=$col1&col2=$col2&col3=$col3&col4=$col4&col5=$col5&col6=$col6&col7=$col7&col8=$col8&col9=$col9&col10=$col10&col11=$col11&col12=$col12&col12_1=$col12_1&col13=$col13&col14=$col14&col14_1=$col14_1&col15=$col15&conF=1';
</script>
";
	}
	}//end if($Aaction == "Process"){
}else{
	
		$sql1 = "SELECT * FROM tbl_temp_profile WHERE page_load='3' and status_load='1'";
		$result1 = mysql_db_query($dbname_temp,$sql1);
			while($rs1 = mysql_fetch_assoc($result1)){
			$sql_del = "DELETE FROM tbl_temp_profile_detail  WHERE  load_id='$rs1[load_id]'";
			mysql_db_query($dbname_temp,$sql_del);
			mysql_db_query($dbname_temp,"DELETE FROM tbl_temp_profile  WHERE  load_id='$rs1[load_id]'");
	}//end while($rs1 = mysql_fetch_assoc($result1)){
	
}//end if($_SERVER['REQUEST_METHOD'] == "POST"){


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<LINK href="../common/style.css" rel=StyleSheet type="text/css">
<title>เลือกโฟรไฟล์การจัดทำข้อมูลปฐมภูมิ</title>
<script language="javascript">
function checkF(){
	if(document.form1.profile_id.value == ""){
			alert("กรุณาเลือกโฟรไฟล์");
			document.form1.profile_id.focus();
			return false;
	}else{
		return true;	
	}
}
</script>


  
  <style>
.graph {
position: relative; /* IE is dumb */
width: 100%;
border: 1px solid #B1D632;
padding: 2px;
}
.graph .bar {
display: block;
position: relative;
background: #B1D632;
text-align: center;
color: #333;
height: 30px;
line-height: 30px;
}
.graph .bar span { position: absolute; left: 1em; width: 100%;text-align: center;font-size:14px;color:#FFFFFF; }

.graph_error {
position: relative; /* IE is dumb */
width: 100%;
border: 1px solid #FF9900;
padding: 2px;
}
.graph_error .bar {
display: block;
position: relative;
background: #FF9900;
text-align: center;
color: #333;
height: 30px;
line-height: 30px;
}
.graph_error .bar span { position: absolute; left: 1em; width: 100%;text-align: center;font-size:14px;color:#FFFFFF; }

.graph_error_all {
position: relative; /* IE is dumb */
width: 100%;
border: 1px solid #FF0000;
padding: 2px;
}
.graph_error_all .bar {
display: block;
position: relative;
background: #FF0000;
text-align: center;
color: #333;
height: 30px;
line-height: 30px;
}
.graph_error_all .bar span { position: absolute; left: 1em; width: 100%;text-align: center;font-size:14px;color:#FFFFFF; }
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style3 {	color: #666666;
	font-size: 11px;
}
.style15 {font-size: 12px; color: #CCCCCC; }
  .style17 {
	color: #FFFFFF;
	font-weight: bold;
}
.style20 {font-size: 12px; color: #FFFF00; }
.style25 {color: #000000; font-weight: bold; }
  </style>
    <script language="javascript">
	
			var xlv="<?=$xlv?>";
			var chF = "<?=$chF?>";
			var profile_id = "<?=$profile_id?>";
			
			 

  	var int = self.setInterval('getLogforce()',2000);
	function getLogforce(){
		if(chF == 1){
	var pts_success = document.getElementById("pts_success");
	forceInformation( <?=$profile_id?> );
	pts_success.scrollTop = pts_success.scrollHeight;
		
		}//end 
	}//end function getLogforce(){

  </script>

</head>
<body onLoad="getLogforce();">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="" onsubmit="return checkF();">
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="2" bgcolor="#CCCCCC"><strong>เลือกโฟรไฟล์การจัดทำข้อมูล</strong></td>
              </tr>
            <tr>
              <td width="19%" align="right" bgcolor="#FFFFFF"><strong>เลือกโฟรไฟล์ :</strong></td>
              <td width="81%" align="left" bgcolor="#FFFFFF">
                <select name="profile_id" id="profile_id">
              <option value="">เลือกโฟรไฟล์</option>
                <option value="225" <? if($profile_id == "225"){ echo "selected='selected'";}?>>แสดงข้อมูลภาพรวมทั้งประเทศ</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<option value="<?=$rsp[profile_id]?>"><?=$rsp[profilename]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		$sql1 = "SELECT * FROM tbl_checklist_report  ORDER BY orderby ASC";
		$result1 = mysql_db_query($dbname_temp,$sql1);
		while($rs1 = mysql_fetch_assoc($result1)){
			if($rs1[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
        	<option value="<?=$rs1[report_id]?>||report" <?=$sel?>><?=$rs1[report_name]?></option>
          <?
		}//end while($rs1 = mysql_fetch_assoc($result1)){
		  ?>
        </select> </td>
            </tr>
            <tr>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td align="left" bgcolor="#FFFFFF"><strong>เลือกเขตที่ต้องการแสดงผล</strong></td>
            </tr>
            <tr>
              <td colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                      <td width="7%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>รายละเอียดการ<br />
                        ดำเนินงาน</strong></td>
                      <td width="6%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>
                        <label for="checkbox">บุคลากรตาม<br />
                          อัตราจริง<br />
                          ทั้งหมด(คน)</label>
                      </strong></td>
                      <td colspan="6" align="center" bgcolor="#CCCCCC"><strong>ได้รับเอกสาร (คน)</strong></td>
                      <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>เอกสารค้างรับ (คน)</strong></td>
                      <td width="8%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>เลขบัตรฯไม่<br />
                        ตรงปกครอง(คน)</strong></td>
                      <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>ไฟล์สำเนา กพ.7 (คน)</strong></td>
                      <td width="6%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ข้อมูล<br />
                        ปฐมภูมิ(คน)</strong></td>
                      <td width="6%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ยังไม่ได้<br />
บันทึก<br />
ข้อมูล</strong></td>
                      <td width="2%" rowspan="2" align="center" bgcolor="#CCCCCC">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="6%" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
                      <td width="5%" align="center" bgcolor="#CCCCCC"><strong>อยู่ระหว่าง<br />
                        ตรวจสอบ</strong></td>
                      <td width="6%" align="center" bgcolor="#CCCCCC"><strong>สมบูรณ์</strong></td>
                      <td width="6%" align="center" bgcolor="#CCCCCC"><strong>ขาดเอกสาร<br />
                        ประกอบ</strong></td>
                      <td width="6%" align="center" bgcolor="#CCCCCC"><strong>ไม่สมบูรณ์</strong></td>
                      <td width="6%" align="center" bgcolor="#CCCCCC"><strong>เลขบัตรไม่<br />
                        สมบูรณ์</strong></td>
                      <td width="6%" align="center" bgcolor="#CCCCCC"><strong>เลขบัตร<br />
                        สมบูรณ์</strong></td>
                      <td width="6%" align="center" bgcolor="#CCCCCC"><strong> เลขบัตรไม่<br />
                        สมบูรณ์</strong></td>
                      <td width="5%" align="center" bgcolor="#CCCCCC"><strong>สมบูรณ์</strong></td>
                      <td width="6%" align="center" bgcolor="#CCCCCC"><strong>ยังไม่ได้<br />
นำเข้าระบบ</strong></td>
                      <td width="7%" align="center" bgcolor="#CCCCCC"><strong>ขาดปก</strong></td>
                    </tr>
                    <? 
					
					if($_SERVER['REQUEST_METHOD'] == "POST"){
						if($col1 == "1" ){ $ch1 = " checked='checked'";}else{ $ch1 = "";}
						if($col2 == "1" ){ $ch2 = " checked='checked'";}else{ $ch2 = "";}
						if($col3 == "1" ){ $ch3 = " checked='checked'";}else{ $ch3 = "";}
						if($col4 == "1" ){ $ch4 = " checked='checked'";}else{ $ch4 = "";}
						if($col5 == "1" ){ $ch5 = " checked='checked'";}else{ $ch5 = "";}
						if($col6 == "1" ){ $ch6 = " checked='checked'";}else{ $ch6 = "";}
						if($col7 == "1" ){ $ch7 = " checked='checked'";}else{ $ch7 = "";}
						if($col8 == "1" ){ $ch8 = " checked='checked'";}else{ $ch8 = "";}
						if($col9 == "1" ){ $ch9 = " checked='checked'";}else{ $ch9 = "";}
						if($col10 == "1" ){ $ch10 = " checked='checked'";}else{ $ch10 = "";}
						if($col11 == "1" ){ $ch11 = " checked='checked'";}else{ $ch11 = "";}
						if($col12 == "1" ){ $ch12 = " checked='checked'";}else{ $ch12 = "";}
						if($col12_1 == "1" ){ $ch12_1 = " checked='checked'";}else{ $ch12_1 = "";}
						if($col13 == "1" ){ $ch13 = " checked='checked'";}else{ $ch13 = "";}
						if($col14 == "1" ){ $ch14 = " checked='checked'";}else{ $ch14 = "";}
						if($col14_1 == "1" ){ $ch14_1 = " checked='checked'";}else{ $ch14_1 = "";}
						if($col15 == "1" ){ $ch15 = " checked='checked'";}else{ $ch15 = "";}	
					}else{
						$ch1 = " checked='checked'";	
						$ch2 = " checked='checked'";	
						$ch3 = " checked='checked'";	
						$ch4 = " checked='checked'";	
						$ch5 = " checked='checked'";	
						$ch6 = " checked='checked'";	
						$ch7 = " checked='checked'";	
						$ch8 = " checked='checked'";	
						$ch9 = " checked='checked'";	
						$ch10 = " checked='checked'";	
						$ch11 = " checked='checked'";	
						$ch12 = " checked='checked'";	
						$ch12_1 = " checked='checked'";
						$ch13 = " checked='checked'";
						$ch14 = " checked='checked'";
						$ch14_1 = " checked='checked'";
						$ch15 = " checked='checked'";
						
					}
					?>
                    <tr>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col1" id="col1" value="1" <?=$ch1?>></td>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col2" id="col2" value="1" <?=$ch2?>></td>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col3" id="col3" value="1" <?=$ch3?>></td>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col4" id="col4" value="1" <?=$ch4?>></td>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col5" id="col5" value="1" <?=$ch5?>></td>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col6" id="col6" value="1" <?=$ch6?>></td>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col7" id="col7" value="1" <?=$ch7?>></td>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col8" id="col8" value="1" <?=$ch8?>></td>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col9" id="col9" value="1" <?=$ch9?>></td>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col10" id="col10" value="1" <?=$ch10?>></td>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col11" id="col11" value="1" <?=$ch11?>></td>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col12" id="col12" value="1" <?=$ch12?>></td>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col12_1" id="col12_1" value="1" <?=$ch12_1?>></td>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col13" id="col13" value="1" <?=$ch13?>></td>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col14" id="col14" value="1" <?=$ch14?>></td>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col14_1" id="col14_1" value="1" <?=$ch14_1?>></td>
                      <td align="center" bgcolor="#FFFFFF"><input type="checkbox" name="col15" id="col15" value="1" <?=$ch15?>></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td align="left" bgcolor="#FFFFFF"><label>
                <input type="submit" name="button" id="button" value="ตกลง" />
                <input type="button" name="btnC" value="ปิดหน้าต่าง" onclick="window.close()">
                <input type="hidden" name="Aaction" value="Process">
                <input type="hidden" name="chF" value="1">
                <input type="hidden" name="xlv" value="<?=$xlv?>">
              </label></td>
            </tr>
          </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <? if($chF == 1){?>
  
       <script language="javascript">

 
 	function CreateXmlHttp(){
		//Creating object of XMLHTTP in IE
		try {
			XmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e){
			try{
				XmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			} 
			catch(oc) {
				XmlHttp = null;
			}
		}
		//Creating object of XMLHTTP in Mozilla and Safari 
		if(!XmlHttp && typeof XMLHttpRequest != "undefined") {
			XmlHttp = new XMLHttpRequest();
		}
		return XmlHttp; 
	} // end function CreateXmlHttp

	function getTimeStamp(){
		var d = new Date();
		var strTime = d.getHours()+'-'+d.getMinutes()+'-'+d.getSeconds();
		return strTime;
	}

	function getInternetSpeed(bandwidth_support){
		time      = new Date();
		starttime = time.getTime();	
		XmlHttpInternetSpeed = CreateXmlHttp();
			XmlHttpInternetSpeed.open("get", "../application/policy_timeline_stat/get_speed.php?ram="+getTimeStamp(), true);
			XmlHttpInternetSpeed.onreadystatechange=function() {
				if (XmlHttpInternetSpeed.readyState==4) {
					if(XmlHttpInternetSpeed.status==200) {
						//var res_internetSpeed = XmlHttpInternetSpeed.responseText;
						time          = new Date();
						endtime       = time.getTime();
						if (endtime == starttime){
							downloadtime = 0;
						}else{
							downloadtime = (endtime - starttime)/1000;
						}
						kbytes_of_data = 128;
						linespeed  = kbytes_of_data/downloadtime;
						kbps   = (Math.round((linespeed*8)*10*1.024))/10;		
						if(kbps >= 1000000){
							valueSpeed = (kbps/1024)/1024;
							unitSpeed = "Gbps";
						}
						if(kbps >= 1000){
							valueSpeed = kbps/1024;
							unitSpeed = "Mbps";
						}else{
							valueSpeed = kbps;
							unitSpeed = "Kbps";
						}
						
						document.getElementById("Internet_Speed_Alert").innerHTML =  (parseInt(kbps) < parseInt(bandwidth_support))?strImgAlert+" Internet Speed  ต้องสูงเกินกว่าที่กำหนด ("+bandwidth_support+" Kbps)":"";			
						document.getElementById("Internet_Speed").innerHTML = valueSpeed.toFixed(3)+" "+unitSpeed;
						Internet_Speed_Alert
					} else if (XmlHttpInternetSpeed.status==404) {
						alert("ไม่สามารถทำการดึงข้อมูลได้x1");
					}
				}
			};
			XmlHttpInternetSpeed.send(null);
	}

/*	function logForceSucess( profile_id ){
		XmlHttpSucess = CreateXmlHttp();
		XmlHttpSucess.open("get", "../application/policy_timeline_stat/ajax.pts_force_success.php?profile_id="+profile_id+"&ram="+getTimeStamp(), true);
		XmlHttpSucess.onreadystatechange=function() {
			if (XmlHttpSucess.readyState==4) {
				if(XmlHttpSucess.status==200) {
					var res_success = XmlHttpSucess.responseText;
					//document.getElementById("pts_force_success").innerHTML = res_success;
					document.getElementById("pts_force_success").innerHTML = "";
				} else if (XmlHttpSucess.status==404) {
					alert("ไม่สามารถทำการดึงข้อมูลได้x2");
				}
			}
		};
		XmlHttpSucess.send(null);
	}*/

	var strImgAlert  =  '<img src="../application/policy_timeline_stat/images/alert.png" border="0" align="absmiddle">';

	function forceInformation( profile_id ){
		XmlHttpInformation = CreateXmlHttp();
		XmlHttpInformation.open("get", "../application/policy_timeline_stat/ajax.load_page_executive.php?profile_id="+profile_id+"&ram="+getTimeStamp(), true);
		XmlHttpInformation.onreadystatechange=function() {
			if (XmlHttpInformation.readyState==4) {
				if(XmlHttpInformation.status==200) {
					var res = XmlHttpInformation.responseText;
					
					var graph = document.getElementById("graph"+profile_id);
				//	alert(graph);
					arrNum = res.split(",");
					//alert(res);

				
					//document.getElementById("numAll").innerHTML = arrNum[0];//All
					//document.getElementById("numError").innerHTML = arrNum[1];//Error
					//document.getElementById("numForce").innerHTML = arrNum[2];//Force
					//document.getElementById("numUnforce").innerHTML = arrNum[3];//Unforce
					//document.getElementById("timeWasted").innerHTML = arrNum[4];//เวลาที่ใช้
					document.getElementById("Cpu_Usage").innerHTML = parseInt(arrNum[6])+"%";
					document.getElementById("Memory_Usage").innerHTML = parseInt(arrNum[7])+"%";
					document.getElementById("Hdd_Usage").innerHTML = parseInt(arrNum[8])+"%";
					document.getElementById("Cpu_Usage_Rate").style.width = parseInt(arrNum[6])+"%";
					//alert(arrNum[7]);
					document.getElementById("Memory_Usage_Rate").style.width = parseInt(arrNum[7])+"%";
					//alert(arrNum[12]);
					document.getElementById("Hdd_Usage_Rate").style.width = parseInt(arrNum[8])+"%";
					getInternetSpeed(arrNum[12]);
					//alert(arrNum[14]);
					
					//เมื่อค่าสูงเกินกว่าที่กำหนด
					document.getElementById("Cpu_Usage_Alert").innerHTML =  (parseInt(arrNum[6]) > parseInt(arrNum[9]))?strImgAlert+"การใช้งาน CUP สูงเกินกว่าที่กำหนด ("+arrNum[9]+"%)":"";
					document.getElementById("Cpu_Usage_Border").style.border = (parseInt(arrNum[6]) > parseInt(arrNum[9]))?"1px #FF0000 solid":"1px #9ED850 solid";
					document.getElementById("Memory_Usage_Alert").innerHTML =  (parseInt(arrNum[7]) > parseInt(arrNum[10]))?strImgAlert+"การใช้งาน Memory สูงเกินกว่าที่กำหนด ("+arrNum[10]+"%)":"";
					document.getElementById("Memory_Usage_Border").style.border = (parseInt(arrNum[7]) > parseInt(arrNum[10]))?"1px #FF0000 solid":"1px #9ED850 solid";
					document.getElementById("Hdd_Usage_Alert").innerHTML =  (parseInt(arrNum[8]) > parseInt(arrNum[11]))?strImgAlert+"การใช้งาน Harddisk สูงเกินกว่าที่กำหนด ("+arrNum[11]+"%)":"";
					document.getElementById("Hdd_Usage_Border").style.border = (parseInt(arrNum[8]) > parseInt(arrNum[11]))?"1px #FF0000 solid":"1px #9ED850 solid";
					

			
					if(arrNum[0] == arrNum[1] && arrNum[0] > 0){
						graph.className = "graph_error_all";
							
					}else if(arrNum[0] > arrNum[1] && arrNum[1] > 0 ){
						graph.className = "graph_error";
					}else{
						graph.className = "graph";
					}
					
//alert(arrNum[2]);
//alert(arrNum[0]);
					var percenProcess = (arrNum[2]*100)/arrNum[0];
					var percenProcessFixed = (percenProcess < 100)?percenProcess.toFixed(2):percenProcess;
					
					setProgess( profile_id, percenProcessFixed);
					
					//logForceSucess( profile_id );
					if(percenProcessFixed == 100){
					setTimeout("window.close()",2000);
					}
					
					//logForceError( profile_id );

				} else if (XmlHttpInformation.status==404) {
					alert("ไม่สามารถทำการดึงข้อมูลได้x3");
				}
			}
		};
		XmlHttpInformation.send(null);
	}

	function setProgess( profile_id, percenProcess){
		var newWidth = percenProcess;
		//var newWidth = 20;
		
		//alert(newWidth);
		if(newWidth <= 100 && newWidth > 0){
			document.getElementById("progress"+profile_id).style.width = newWidth+"%";
			document.getElementById("val"+profile_id).innerHTML = newWidth+"%";
		}else{
			document.getElementById("progress"+profile_id).style.width = "0%";
			document.getElementById("val"+profile_id).innerHTML = "0%";
		}
	}
	
	function profileStatus( buttonID, profile_id ){
		var button_status = document.getElementById( buttonID );
		XmlHttpStatus = CreateXmlHttp();
		XmlHttpStatus.open("get", "../application/policy_timeline_stat/ajax.pts_profile_status.php?profile_id="+profile_id+"&profile_status="+button_status.value+"&ram="+getTimeStamp(), true);
		XmlHttpStatus.onreadystatechange=function() {
			if (XmlHttp.readyState==4) {
				if(XmlHttpStatus.status==200) {q
					var res = XmlHttpStatus.responseText;
				} else if (XmlHttpStatus.status==404) {
					alert("ไม่สามารถทำการดึงข้อมูลได้x4");
				}
			}
		};
		XmlHttpStatus.send(null);
	}

 </script>


  <tr>
    <td><TABLE width="100%">
					<TR>
						<TD>
						<fieldset style="color:#000000;border:1px #000000 solid;font-size:14px;">
						<legend><B style="color:#000000;">ข้อมูลระบบ</B></legend>
						<TABLE width="99%" style="color:#000000;font-size:12px;">
						<TR>
							<TD width="100" bgcolor="#EFEFEF"><B>CPU Usage</B></TD>
						  <TD width="100" align="right" bgcolor="#EFEFEF"><DIV id="Cpu_Usage"></DIV></TD>
							<TD width="230" align="left" bgcolor="#EFEFEF">
							<DIV id="Cpu_Usage_Border" style="border:#9ED850 1px solid;width:200px;height:15px;">
								<DIV id="Cpu_Usage_Rate" style="background-image:url(../application/policy_timeline_stat/images/rate_color.png);width:5%;height:15px;"></DIV>
							</DIV>
						  </TD>
						  <TD  align="left" bgcolor="#EFEFEF"><DIV id="Cpu_Usage_Alert"></DIV></TD>
						</TR>
						<TR>
							<TD bgcolor="#EFEFEF"><B>Memory Usage</B></TD>
						  <TD width="100" align="right" bgcolor="#EFEFEF"><DIV id="Memory_Usage"></DIV></TD>
							<TD align="left" bgcolor="#EFEFEF">
							<DIV id="Memory_Usage_Border" style="border:#9ED850 1px solid;width:200px;height:15px;">
								<DIV id="Memory_Usage_Rate" style="background-image:url(../application/policy_timeline_stat/images/rate_color.png);width:5%;height:15px;"></DIV>
							</DIV>
						  </TD>
						  <TD  align="left" bgcolor="#EFEFEF"><DIV id="Memory_Usage_Alert"></DIV></TD>
						</TR>
						<TR>
							<TD bgcolor="#EFEFEF"><B>HDD Usage</B></TD>
						  <TD width="100" align="right" bgcolor="#EFEFEF"><DIV id="Hdd_Usage"></DIV></TD>
							<TD align="left" bgcolor="#EFEFEF">
							<DIV id="Hdd_Usage_Border" style="border:#9ED850 1px solid;width:200px;height:15px;">
								<DIV id="Hdd_Usage_Rate" style="background-image:url(../application/policy_timeline_stat/images/rate_color.png);width:5%;height:15px;"></DIV>
							</DIV>
						  </TD>
						  <TD  align="left" bgcolor="#EFEFEF"><DIV id="Hdd_Usage_Alert"></DIV></TD>
						</TR>
						<TR>
							<TD bgcolor="#EFEFEF"><B>Internet Speed</B></TD>
						  <TD width="100" align="right" bgcolor="#EFEFEF"><DIV id="Internet_Speed"></DIV></TD>
							<TD align="left" bgcolor="#EFEFEF"></TD>
						  <TD align="left" bgcolor="#EFEFEF"><DIV id="Internet_Speed_Alert"></DIV> </TD>
						</TR>
						<TR>
							<TD></TD>
							<TD></TD>
						</TR>
						</TABLE>
						</fieldset>
						</TD>
					</TR>
					</TABLE></td>
  </tr>
  <tr>
    <td><TABLE width="100%">
			   <TR>
				    <TD align="left">
					   <div class="graph" id="graph<?=$profile_id?>">
					   <strong id="progress<?=$profile_id?>" class="bar" style="width:0%;"><span id="val<?=$profile_id?>">0%</span></strong>	</div></TD>
			   </TR>
			   </TABLE></td>
  </tr>
  <tr>
    <td><DIV id="pts_success" style=" overflow:auto; width:100%; height:1px;border:#BBBBBB 1px solid;">
			    <DIV id="pts_force_success"></DIV>
		      </DIV>	</td>
  </tr>
  <?
  }//end // end if($chF == 1){
  ?>
</table>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
