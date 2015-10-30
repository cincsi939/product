<?
session_start();
set_time_limit(0);
$ApplicationName	= "userentry";
$module_code 		= "search"; 
$process_id			= "search";
$VERSION 				= "9.91";
$BypassAPP 			= true;

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
	## Modified Detail :		ระบบ login userentry
	## Modified Date :		2011-07-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################





include "../../config/conndb_nonsession.inc.php";
include ("../../common/common_competency.inc.php")  ;
$time_start = getmicrotime();
	
	
if($action == "login"){
		
				$_SESSION[islogin] = 1 ;
				$_SESSION[id] = $idcard ;
				$_SESSION[name] = $name_th ;
				$_SESSION[surname] = $surname_th ;
				$_SESSION[session_username] = $idcard;
				$_SESSION[idoffice] = $idcard ;
				$_SESSION[secid] = $xsiteid ;
				$_SESSION[temp_dbsite] = STR_PREFIX_DB.$xsiteid;
				//echo "<pre>";
				//print_r($_SESSION);die;
				
				####  update สถานะการคีย์ข้อมูลว่าได้บันทึกข้อมูลไปแล้ว
				$sql_key = "UPDATE tbl_assign_key SET status_keydata='1' WHERE idcard='$idcard'";
				mysql_db_query($dbcall,$sql_key);
				
				$sqla = " SELECT  *  FROM  keystaff  WHERE  staffid = '$_SESSION[session_staffid]'  ";
				 //echo "$sqla";
				$resulta = mysql_db_query($dbcall,$sqla);
				$rsa = mysql_fetch_assoc($resulta);
				
				$namestaff = " $rsa[prename]$rsa[staffname]  $rsa[staffsurname]  ";

				$temp_name_th = "$name_th $surname_th";


	$redirec_ip = APPHOST_TEST;
	## ตรวจสอบสิทธิการเข้าถึงข้อมูลป้องกัน sub คีย์ข้อมูลข้างในบริษัท

		echo "<script>top.location.href='http://$redirec_ip/edubkk_master/application/hr3/hr_frame/frame.php';</script>";
		exit;



}//end if($action == "login"){

if($xsiteid == ""){
	$xsiteid = "5001";	
}

?>
<html>
<TITLE>ตรวจสอบข้อมูล Competency</TITLE>
<META content="text/html; charset=windows-874" http-equiv=Content-Type>
<LINK href="../../common/style.css" rel=stylesheet type="text/css">
<script  language="javascript">

  var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
  	  }
	}
	

function con_accp() {
	if (confirm("การบันทึกข้อมูลตามช่วงเวลานี้มีคนบันทึกเข้าไปในระบบแล้ว! คุณต้องการบันทึกข้อมูลซ้ำใช้หรือไม่?")) { 
		window.location="qsearch2.php?action=accept";
		return true; 
	}else{
		return false;
	}

}


</script>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>

<style type="text/css">
.page {
	font						: 9px tahoma;
	font-weight			: bold; 	
	color					: #0280D5;	
	padding				: 1px 3px 1px 3px;
}	

.pagelink {
	font						: 9px tahoma;
	font-weight			: bold; 
	color					: #000000;
	text-decoration	: underline;
	padding				: 1px 3px 1px 3px;
}
.go {
	BORDER: #59990e 1px solid; 
	PADDING-RIGHT: 0.38em; 
	PADDING-LEFT: 0.38em; 
	FONT-WEIGHT: bold; 
	FONT-SIZE: 105%; 
	BACKGROUND: url(../../application/hr3/hr_report/images/hdr_bg.png) #6eab26 repeat-x 0px -90px; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	COLOR: #fff; 
	MARGIN-RIGHT: 0.38em; 
	PADDING-TOP: 0px; 
	HEIGHT: 1.77em
}
#bf .go {
	FLOAT: none
}
.go:hover {
	BORDER: #3f8e00 1px solid; 
	BACKGROUND: url(../../application/hr3/hr_report/images/hdr_bg.png) #63a218 repeat-x 0px -170px; 
}
.q {
	BORDER-RIGHT: #5595CC 1px solid; 
	PADDING-RIGHT: 0.7em; 
	BORDER-TOP: #5595CC 1px solid; 
	PADDING-LEFT: 0.7em; 
	FONT-WEIGHT: normal; FONT-SIZE: 105%; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	MARGIN: 0px 0.38em 0px 0px; 
	BORDER-LEFT: #5595CC 1px solid; 
	WIDTH: 300px; 
	PADDING-TOP: 0.29em; 
	BORDER-BOTTOM: #5595CC 1px solid; 
	HEIGHT: 1.39em

}
.tabberlive .tabbertab {
	background-color:#FFFFFF;
  height:200px;
}
</style>

</HEAD>
<BODY>
<form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="12%" align="right"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td width="55%">
          <select name="xsiteid" id="xsiteid" onchange="gotourl(this)">
          <option value="">เลือกโฟล์ไฟล์</option>
      	<?
		$sql_profile  = "SELECT * FROM eduarea WHERE secid NOT LIKE '99%' ";
		$result_profile = mysql_db_query($dbnamemaster,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[secid] == $xsiteid){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<option value="?xsiteid=<?=$rsp[secid]?>" <?=$sel?>><?=$rsp[secname]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
        </select> 
          
          </td>
          <td width="33%">&nbsp;</td>
        </tr>
      </table>
    </form>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="center" bgcolor="#999999">&nbsp;</td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#999999"><strong>ลำดับ</strong></td>
        <td width="14%" align="center" bgcolor="#999999"><strong>เลขบัตรประชาชน</strong></td>
        <td width="17%" align="center" bgcolor="#999999"><strong>ชื่อ นามสกุล</strong></td>
        <td width="27%" align="center" bgcolor="#999999"><strong>ตำแหน่ง</strong></td>
        <td width="33%" align="center" bgcolor="#999999"><strong>สังกัด</strong></td>
        <td width="4%" align="center" bgcolor="#999999">&nbsp;</td>
      </tr>
      <?
	  $sql = "SELECT t1.CZ_ID,t1.prename_th,t1.name_th,t1.surname_th,t1.siteid,t2.secname,t1.schoolname,t1.position_now FROM view_general as t1 inner join eduarea as t2 ON t1.siteid=t2.secid WHERE t1.pid IN('125471008','125471009','325471008','325001010','325001005','325471009') AND t1.siteid='$xsiteid' ORDER BY siteid ASC,pid ASC,name_th,surname_th ASC";
	  //echo $sql;die;
	  $result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
	  while($rs = mysql_fetch_assoc($result)){
      	if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
		$xpdf = "../../../edubkk_kp7file/".$rs[siteid]."/".$rs[CZ_ID].".pdf";
		if(is_file($xpdf)){
			$img_pdf = "<a href='$xpdf' target=\"_blank\"><img src=\"../../images_sys/gnome-mime-application-pdf.png\" title=\"แสดงเอกสาร ก.พ.7 ต้นฉบับ\" width=\"16\" height=\"16\" border=\"0\"></a>";	
		}else{
			$img_pdf = "";	
		}
		
		
		$pdf = "<a href=\"../hr3/hr_report/kp7_search.php?id=".$rs[CZ_ID]."&sentsecid=".$rs[siteid]."&tmpuser=$tmpuser&tmppass=$tmppass\" target=\"_blank\"><img src=\"../../application/hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\" title='ก.พ.7 สร้างโดยระบบ '  ></a>";
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><a href="?name_th=<?=$rs[name_th]?>&surname_th=<?=$rs[surname_th]?>&idcard=<?=$rs[CZ_ID]?>&action=login&xsiteid=<?=$rs[siteid]?>"><?=$rs[CZ_ID]?></a></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
        <td align="left"><?=$rs[position_now]?></td>
        <td align="left"><? echo "$rs[secname]/$rs[schoolname]";?></td>
        <td><?=$img_pdf?>&nbsp;<?=$pdf?></td>
      </tr>
      <?
	  }//end 	  while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
<?
	$time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
?>
