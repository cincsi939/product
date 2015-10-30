<?
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "report_idfalse"; 
$process_id			= "checklistkp7_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20100809.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2010-08-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20100809.00
	## Modified Detail :		ระบบตรวจสอบข้อมูลทะเบียนประวัติต้นฉบับ
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
include ("../../common/common_competency.inc.php")  ;
include("checklist2.inc.php");
$time_start = getmicrotime();

function ShowSecname($xsiteid){
		global $dbnamemaster;
		$sql = "SELECT secname FROM eduarea WHERE secid='$xsiteid'";
		$result = mysql_db_query($dbnamemaster,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[secname];
}

function ShowOffice($sid){
	global $dbnamemaster;	
	$sql = "SELECT office FROM allschool WHERE id='$sid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[office];
}

function ShowProfileName($profile_id){
		global $dbname_temp;
		$sql = "SELECT * FROM tbl_checklist_profile WHERE profile_id='$profile_id'";
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[profilename];
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
<SCRIPT SRC="sorttable.js"></SCRIPT>
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
<script language="javascript">

function confirmDelete(delUrl) {
  if (confirm("คุณแน่ใจที่จะลบข้อมูลใช่หรือไม่?")) {
  //window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
    document.location = delUrl;
  }
}


function sw_table(ch_id,menu_id){
	if(ch_id == "0"){
		document.getElementById("tblName"+menu_id).style.display = "";
		document.getElementById("radio_all1").checked=false;
	}else{
		document.getElementById("tblName"+menu_id).style.display = "none";
		document.getElementById("radio_all2").checked=false;
	}

}//end function sw_table(menu_id){
	
//  ฟังก์ชั่นเลือกการตรวจสอบสถานะทั้งหมด
function check_radio_all(txtpotion){
	var arrmenu = new Array('','general_status','graduate_status','salary_status','seminar_status','sheet_status','getroyal_status','special_status','goodman_status','absent_status','nosalary_status','prohibit_status','specialduty_status','other_status');
		if(txtpotion == "1"){ /// กรณีสมบูรณ์ทั้งหมด
				for(i=1;i<14;i++){
					//alert(arrmenu[i]);
					document.getElementById(arrmenu[i]+"1").checked=true;
					sw_table(1,i)
				}//end for(i=0;i<count(arrment);i++){
		}else if(txtpotion == "2"){// กรณีไม่สมบูรณ์
				for(i=1;i<14;i++){
					document.getElementById(arrmenu[i]+"2").checked=true;
					 sw_table(0,i)
				}//end for(i=0;i<count(arrment);i++){
		}
	
}//end function check_radio_all(txtpotion){

function control_checkbox(){
//alert("sad");
	for(i=1;i<=13;i++){ // หมวดเมนู
		for(j=1;j<=4;j++){
			var str_checkbox = "check_problem"+i+""+j;
			var str_textbox = "problem_detail"+i+""+j;
			//alert(document.getElementById("check_problem"+i+j).value);
			if(eval("document.form2."+str_checkbox+".checked") == true) { 
				document.getElementById("problem_detail"+i+j).disabled=false;
			}else{
				document.getElementById("problem_detail"+i+j).disabled=true;
				document.getElementById("problem_detail"+i+j).value="";
			}//end if(eval("document.form2.check_problem13"+i+".checked")==false) { 
			
		}//end for(j=1;j<=4;j++){
	}//end for(i=1;i<=13;i++){

	
}

function setuser(){
 var left=(document.width/2)-(450/2);
 var top=(document.height/2)-(500/2);
// if(xnorsel==undefined){xnorsel="";}
 var url="popup_setuser.php?Rnd="+(Math.random()*1000);
 var prop="dialogHeight: 500px; dialogWidth: 450px; scroll: yes; help: No; status: No;center:yes ;dialogTop:"+top+";dialogLeft:"+left;
 var o=showModalDialog(url,"pop",prop); 

 if(o){
	 var xstr=o.strname;
	
    document.formsetuser.setuser.value=xstr;
	 document.formsetuser.submit();
 }
}

</script>
<script src="../../common/jquery.js"></script>
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
    <td background="../competency_executive/images/braner/banner-cmss_01_02.png"><img src="../competency_executive/images/braner/banner-cmss_01.jpg" width="442" height="93"></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="12%" align="right"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td width="55%" align="left">
          <select name="profile_id" id="profile_id" onchange="gotourl(this)">
          <option value="">เลือกโฟล์ไฟล์</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
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
</td>
  </tr>
  <tr>
    <td align="center">ข้าราชการครูและบุคลากรทางการศึกษาตามรายชื่อด้านล่างให้ติดต่อมายัง <a href="http://www.sapphire.co.th/sapphire_/service_program.php?menu=5" target="_blank" style="color:#F00000">call_center</a> เพื่อแก้ไข</td>
  </tr>
  <tr>
    <td align="center">ข้อมูลหมายเลขบัตรประชาชนให้ถูกต้องในระบบทะเบียนประวัติ ก.พ.7 อิเล็กทรอนิกส์</td>
  </tr>
  <tr>
    <td align="center"><strong><?=ShowProfileName($profile_id);?></strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="2" id="table0" class="sortable">
         
          <tr style="cursor:hand">
            <td width="8%" align="center" bgcolor="#DADADA"><strong>ลำดับ</strong></td>
            <td width="26%" align="center" bgcolor="#DADADA"><strong>ชื่อ - นามสกุล</strong></td>
            <td width="35%" align="center" bgcolor="#DADADA"><strong>หน่วยงานสังกัด</strong></td>
            <td width="31%" align="center" bgcolor="#DADADA"><strong>เขตพื้นที่การศึกษา</strong></td>
          </tr> 
          <?
      	$sql = "SELECT  
		concat(name_th,surname_th) as fullname,prename_th,name_th,surname_th,schoolid,siteid  FROM tbl_checklist_kp7_false WHERE  
tbl_checklist_kp7_false.status_IDCARD LIKE  '%IDCARD_FAIL%'   AND  idcard <> 'X080119001363' AND 
tbl_checklist_kp7_false.status_chang_idcard LIKE  '%NO%'  AND profile_id='$profile_id' GROUP BY fullname ORDER BY siteid ASC";
	//echo $dbname_temp."  :: ".$sql;
		$result = mysql_db_query($dbname_temp,$sql);
		$n=0;
		$j=0;
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}

	  ?>
      
          <tr bgcolor="<?=$bg?>">
            <td align="center"><?=$i?></td>
            <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
            <td align="left"><?=ShowOffice($rs[schoolid]);?></td>
            <td align="left"><?=ShowSecname($rs[siteid])?></td>
          </tr>
      <?

		}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>