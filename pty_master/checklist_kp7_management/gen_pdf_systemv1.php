<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AdminReport";
$module_code = "audit";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Pairoj
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::schooll_name, login
#END
#########################################################
session_start();
set_time_limit(0);
define('FPDF_FONTPATH','../hr_report/fpdf/font/');

			include ("online_config.inc.php")  ;
			include ("../../../common/common_competency.inc.php")  ;
			include ("../../../config/conndb_nonsession.inc.php");
			include("../../../common/std_function.inc.php");
			$hr_username = "sapphire";
			$hr_password = "sprd!@#$%";
			$dbnamemaster = DB_MASTER;
			
			$permition_a = "";
			
function RecursiveFolderDelete ( $folderPath ){
	if ( is_dir ( $folderPath ) ){
			foreach ( scandir ( $folderPath )  as $value ){
					if ( $value != "." && $value != ".." ){
							$value = $folderPath . "/" . $value;
							if ( is_dir ( $value ) ){
								FolderDelete ( $value );
							}elseif ( is_file ( $value ) ){
								@unlink ( $value );
							}
					}
			}
				return rmdir ( $folderPath );
			}else{
		return FALSE;
	}
}// end function RecursiveFolderDelete ( $folderPath ){

			
			
			//$delpath  = "../../../../temp_gen_pdf_sys/สำนักงานเขตพื้นที่การศึกษาพิษณุโลก เขต 2/";
			//rmdir($delpath);
			
		//	RecursiveFolderDelete($delpath);
			//echo "ลบ<br>";
			
			
	function GetArea($get_siteid){
		global $dbnamemaster;
			$sql_area = "SELECT secname FROM eduarea WHERE secid='$get_siteid'";
			$result_area = mysql_db_query($dbnamemaster,$sql_area);
			$rs_a = mysql_fetch_assoc($result_area);
			return $rs_a[secname];
	}//end function GetArea
			
	function GetSchool($get_schoolid){
		global $dbnamemaster;
		$sql_school = "SELECT office FROM allschool  WHERE id='$get_schoolid'";
		$result_school = mysql_db_query($dbnamemaster,$sql_school);
		$rs_s = mysql_fetch_assoc($result_school);
		return $rs_s[office];
	}//end 
?>

<HTML><HEAD><TITLE>เครื่องมือ generate PDFและ และ Copy PDF ต้นฉบับ </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<LINK href="../../../common/style.css" rel=stylesheet>
<script language="javascript">
function openwin( urlpage, width, height,newwin) {
        center = 1;                                
        xpos=0; ypos=0;
        if ((parseInt(navigator.appVersion) >= 4 ) && (center)){
                xpos = (screen.width - width) / 2;
                ypos = (screen.height - height) / 2;
        }
        arg = "width=" + width + "," 
        + "height=" + height + "," 
        + "location=0"	// address bar
        + "menubar=0,"
        + "resizable=no,"
        + "scrollbars=no,"
        + "status=0," 
        + "toolbar=0,"
        + "screenx=" + xpos + ","  // Netscape
        + "screeny=" + ypos + ","  // Netscape
        + "left=" + xpos + ","     // IE
        + "top=" + ypos;           // IE

        window.open( urlpage,'newwin',arg );
}
</script>
<style type="text/css">
<!--
.style2 {color: #FFFFFF}
.style4 {
	font-size:12px;
	padding-left:5px;
	padding-right:5px;
	color: #ffffff;
	font-style: italic;
}
-->
</style>
</HEAD>
<BODY bgcolor="#A5B2CE">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-bottom:1px solid #FFFFFF">
  <tr>
    <td height="50" align="right" background="../hr_report/images/report_banner_01.gif"  style=" border-bottom:1px solid #FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px">เครื่องมือ generate PDFและ และ Copy PDF ต้นฉบับ </td>
        <td align="right"><img src="../hr_report/images/report_banner_03.gif" width="365" height="50" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right"  style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#868E94', EndColorStr='#ffffff')"></td>
  </tr>
</table>
<table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td height="25" colspan="5" align="left" bgcolor="#A5B2CE" class="plink" >
	  <?
		conn("localhost");
	  	$sql = " SELECT  intra_ip,area_name,area_id FROM  area_info  GROUP BY intra_ip ORDER BY  intra_ip ";
		$result = mysql_db_query($dbnamemaster,$sql) ;
		while($rs = mysql_fetch_assoc($result)){	
	?>
	<!--  <a href="?action=show&ipaddress=<?=$rs[intra_ip]?>&area_id=<?=$rs[area_id]?>"><?=$rs[area_name]?></a>-->	<?	}  ?>	  </td>
  </tr>
	<tr align="center"     bgcolor="#10265F">
	  <td height="25" colspan="5" align="left" bgcolor="#A5B2CE" class="plink" >
	  <?
	  if($action == ""){
	  ?>
	  <table width="100%" cellpadding="3">
	  
        <tr>
          <td width="7%" align="center" bgcolor="#10265F"><span class="style2">ลำดับ</span></td>
          <td width="75%" align="center" bgcolor="#10265F"><span class="style2">ชื่อเขตพื้นที่การศึกษา</span></td>
          <td width="18%" align="center" bgcolor="#10265F"><span class="style2">รหัสพื้นที่ </span></td>
          <td width="18%" align="center" bgcolor="#10265F"><span class="style2">ลบโฟรเดอร์ </span></td>
          <td width="18%" align="center" bgcolor="#10265F"><span class="style2">ตรวจสอบการ gen ไฟล์</span></td>
        </tr>
		<?
	conn("$ipaddress");
	$j = 1;
	$sql1 = " SELECT  eduarea.secid, eduarea.area_id ,secname FROM  eduarea  WHERE status_area53='1' order  by secname asc   ";
	$result1 = mysql_db_query(DB_MASTER,$sql1) ;
	while($rs1 = mysql_fetch_assoc($result1)){	
	if($i%2){ $bg1 = "#F0F0F0";}else{ $bg1 = "#FFFFFF";}
	$dbsite="cmss_".$rs1[secid];

				
		?>
        <tr  bgcolor="<?=$bg1?>">
          <td align="center"><?=$j?></td>
          <td align="left"><?=$rs1[secname]?><? echo "<a href='?action=run_show&siteid_sent=$rs1[secid]'>Gen File PDF Original</a>";?></td>
          <td align="center">Gen File PDF<? echo "<a href='../hr_report/genpdf53.php?action=gen&ipaddress=$ipaddress&siteid_sent=$rs1[secid]&area_id=$rs1[area_id]' target='_blank'>$rs1[secid]</a>"; ?></td>
          <td align="center"><? if($permition_a != ""){?><a href="?action=del&siteid_sent=<?=$rs1[secid]?>">ลบ</a><? }//end?></td>
          <td align="center"><a href="gen_pdf_view.php?action=view&xsiteid=<?=$rs1[secid]?>" target="_blank"><img src="../../../images_sys/button_select.png" width="14" height="13" border="0" title="คลิ๊กเพื่อแสดงผลการ genfile pdf ต้นฉบับและ pdf จาำกระบบ"></a></td>
        </tr>
		<?
			  $j++;
		}
		?>
      </table>
	  <?

	 }
	  ?>	  </td>
  </tr>
	<tr align="center"     bgcolor="#10265F">
	  <td height="25" colspan="5" align="left" bgcolor="#A5B2CE" class="plink" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"><?
	
if($action == "run_show"){
 conn("$ipaddress");
 	$dbsite = "cmss_".$siteid_sent;
	$db_temp = DB_CHECKLIST;
	
	function Rmkdir($path,$mode = 0777){
		$exp=explode("/",$path);
		$way='';
		foreach($exp as $n){
			$way.=$n.'/';
			if(!file_exists($way))
			mkdir($way);
		}
	}//end function Rmkdir($path,$mode = 0777){ 
	
	$xarea = GetArea($siteid_sent);
	
	$path_main = $_SERVER['DOCUMENT_ROOT']."/temp_gen_pdf_original/".$xarea;
	$path_upload = $_SERVER['DOCUMENT_ROOT']."/checklist_kp7file";

	
	$sql = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='$siteid_sent' ORDER BY schoolid ASC ";
	$result = mysql_db_query($db_temp,$sql);
	$i=0;
	$j=0;
	while($rs = mysql_fetch_assoc($result)){
		$xschool = str_replace("."," ",GetSchool($rs[schoolid])); // แสดงชื่อโรงเรียน
		$dest_path = $path_main."/".$xschool."/";
		$sorce_path = $path_upload."/".$siteid_sent."/";
		
		###  ตรวจสอบ โฟลเดอร์ที่จะคัดลอกไฟล์ไปไว้แยกตามโรงเรียน
		if(!(is_dir($dest_path))){
			Rmkdir($dest_path);	
		}//end if(!(is_dir($dest_path))){
		$file_sorece = $sorce_path."".$rs[idcard].".pdf";
		$file_dest = $dest_path."".$rs[idcard].".pdf";
		if(copy($file_sorece,$file_dest)){
			$i++;
			chmod("$file_dest",0777);	
			$sql_log = "REPLACE INTO log_gen_filepdf SET idcard='$rs[idcard]', siteid='$rs[siteid]', type_file='original',schoolid='$rs[schoolid]',status_file='1' ";
			mysql_db_query($db_temp,$sql_log);
		}else{
			$j++;
			$sql_log = "REPLACE INTO log_gen_filepdf SET idcard='$rs[idcard]', siteid='$rs[siteid]', type_file='original',schoolid='$rs[schoolid]',status_file='0' ";
			mysql_db_query($db_temp,$sql_log);
		}//end if(copy($file_sorece,$file_dest)){
				
	}//end while($rs = mysql_fetch_assoc($result)){
echo "<script>alert('คัดลอกไฟล์เรียบร้อยแล้ว จำนวนไฟล์ที่คัดลอกได้ $i รายการ จำนวนที่ไม่สามารถคัดลอกได้ $j รายการ'); location.href='gen_pdf_systemv1.php?action=';</script>";
}//end if($action == "run_show"){
	
	
	if($action == "del"){
		$db_temp = DB_CHECKLIST;
	//$delpath  = "../../../../temp_gen_pdf_sys/สำนักงานเขตพื้นที่การศึกษาพิษณุโลก เขต 2/";
	$xarea = GetArea($siteid_sent);
	
	$path_main ="../../../../temp_gen_pdf_sys/".$xarea;
	
	$sql = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='$siteid_sent' group by schoolid ORDER BY schoolid ASC ";
	$result = mysql_db_query($db_temp,$sql);
	$i=0;
	$j=0;
	while($rs = mysql_fetch_assoc($result)){
		//$xschool = str_replace("."," ",GetSchool($rs[schoolid])); // แสดงชื่อโรงเรียน
		$xschool = GetSchool($rs[schoolid]);
		$dest_path = $path_main."/".$xschool."/";
		echo $dest_path."<br>";
		RecursiveFolderDelete($dest_path);
				
	}//end while($rs = mysql_fetch_assoc($result)){
		/*echo "<script>alert('ลบรายการเรียบร้อยแล้ว'); location.href='gen_pdf_systemv1.php?action=';</script>";*/
			
	}//end if($action == "del"){

  ?></td>
  </tr>
</table></td>
  </tr>
</table>


</BODY></HTML>