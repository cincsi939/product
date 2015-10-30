<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("../../common/common_competency.inc.php");

function XCountPagePdf($file){
        if(file_exists($file)) { 
		
                        //open the file for reading 
            if($handle = @fopen($file, "rb")) { 
                $count = 0; 
                $i=0; 
                while (!feof($handle)) { 
                    if($i > 0) { 
                        $contents .= fread($handle,8152); 
						
                    }else { 
                          $contents = fread($handle, 1000); 
                        if(preg_match("/\/N\s+([0-9]+)/", $contents, $found)) { 
						//echo "<pre>";
						//print_r($found);
						//$count_file = $found['1'];
                        // return $found[1]; 
                        } 
                    } 
                    $i++; 
                } //end   while (!feof($handle)) { 
				}
			}
		return $found[1];
		//fclose($handle); 
	}//end function XCountPagePdf($file){

function GetSecnameAll(){
	global $dbnamemaster;
	$sql = "SELECT secid,secname_short FROM eduarea WHERE secid NOT LIKE '99%' ";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[secid]] = $rs[secname_short];	
	}//end 	while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function GetSecnameAll(){

$arrsite = GetSecnameAll();// 

function GetProfileName(){
	global $dbname_temp;
	$sql = "SELECT
tbl_checklist_profile.profile_id,
tbl_checklist_profile.profilename_short
FROM `tbl_checklist_profile`";	
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[profile_id]] = $rs[profilename_short];
	}// end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end function GetProfileName(){

############  ประมวลผลตรวจสอบข้อมูลชื่อซ้ำกัน
if($_GET['action'] == "process"){
	if($xsiteid != ""){
		$consite = " AND t1.siteid='$xsiteid' ";
		$redirect = "?action=view&xsiteid=$xsiteid";
	}else{
		$redirect = "?action=";	
	}
	$sql = "SELECT t1.siteid, t1.last_profile as profile_id FROM `view_checklist_lastprofile` as t1 inner join callcenter_entry.keystaff as t2 on t1.siteid=t2.site_area $consite  GROUP BY t1.siteid";
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		
		mysql_db_query($dbname_temp,"DELETE FROM view_page_uploadkp7_last_flase WHERE siteid='$rs[siteid]'") or die(mysql_error()."ลบข้อมูล ผิดพลาด".__LINE__);
		
		$sql1 = "SELECT
t1.idcard,
t1.profile_id,
t1.siteid,
t1.page_upload
FROM
tbl_checklist_kp7 AS t1
WHERE
t1.siteid =  '$rs[siteid]' AND
t1.profile_id =  '$rs[profile_id]' ";	
		$result1 = mysql_db_query($dbname_temp,$sql1) or die(mysql_error()."".__LINE__);
		while($rs1 = mysql_fetch_assoc($result1)){
				$sql2 = "SELECT  t1.profile_id, t1.page_upload FROM tbl_checklist_kp7 AS t1 WHERE
t1.siteid =  '$rs[siteid]' AND t1.profile_id <>  '$rs1[profile_id]'  and t1.idcard='$rs1[idcard]' ORDER BY t1.profile_id DESC LIMIT 1";
				$result2 = mysql_db_query($dbname_temp,$sql2) or die(mysql_error()."$sql2<br>LINE__".__LINE__);
				$rs2 = mysql_fetch_assoc($result2);
				
				$kp7file_dest = "../../../".PATH_KP7_FILE."/$rs1[siteid]/".$rs1[idcard].".pdf"  ;
				$temp_page = XCountPagePdf($kp7file_dest);
				################  เก็บข้อมูลที่จำนวนไม่เท่ากัน
				if(($rs2[page_upload] > $rs1[page_upload]) and $rs1[page_upload] > 0  and $rs2[page_upload] > $temp_page ){
						$sql_save= "INSERT INTO view_page_uploadkp7_last_flase SET idcard='$rs1[idcard]',siteid='$rs1[siteid]',profile_id_before='$rs2[profile_id]',page_before='$rs2[page_upload]',profile_id_after='$rs1[profile_id]',page_after='$rs1[page_upload]'";
						mysql_db_query($dbname_temp,$sql_save) or die(mysql_error()."$sql_save<br>LINE__".__LINE__);
				}//end if(($rs2[page_upload] > $rs1[page_upload]) and $rs1[page_upload] > 0 ){
					
					if($temp_page > $rs1[page_upload] and  $rs1[page_upload] > 0){
						$sql_update1 = "UPDATE tbl_checklist_kp7 SET page_upload='$temp_page' WHERE idcard='$rs1[idcard]' AND siteid='$rs[siteid]' AND profile_id='$rs1[page_upload]'  ";	
						#echo "$rs[idcard]  ::   จำนวนแผ่นก่อนหน้า => $rs2[page_upload] ::  จำนวนล่าสุด => $rs1[page_upload]  :: จำนวนแผ่นที่นับจากระบบ =>  $temp_page <hr>";
						mysql_db_query($dbname_temp,$sql_update1);
					}
					
					
		}
	}//end while($rs = mysql_fetch_assoc($result)){
		
	if($result){
				echo "<script> alert('ประมวลผลตรวจสอบข้อมูล');location.href='$redirect';</script>";
	}
		
}//end if($_GET['action'] == "process"){
	
function GetPersonUploadFalse(){
	global $dbname_temp;
	$sql = "SELECT count(idcard) as num1,siteid FROM `view_page_uploadkp7_last_flase` group by  siteid;";	
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]] = $rs[num1];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function GetPersonUploadFalse(){


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
<?
	if($action == ""){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="3" align="left" bgcolor="#CCCCCC"><a href="?action=process">ประมวลผล</a> || รายงานข้อมูลการ นำเข้าไฟล์ ก.พ.7 ที่ข้อมูลจำนวนแผ่นไม่เท่ากับจำนวนแผ่นก่อนหน้าที่จะทำการ upload</td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="63%" align="center" bgcolor="#CCCCCC"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="33%" align="center" bgcolor="#CCCCCC"><strong>จำนวนบุคลการที่จำนวนแผ่น ก.พ.7 <br>
          ต้นฉบับล่าสุดน้อยกว่าข้อมูลก่อนหน้า</strong></td>
        </tr>
      <?

	  
	  
      	$sql_main = "SELECT t2.secid as siteid, t2.secname FROM callcenter_entry.keystaff AS t1 Inner Join edubkk_master.eduarea as t2 ON t1.site_area = t2.secid
GROUP BY  t2.secid order by t2.secname asc";
		$result_main = mysql_db_query($dbnamemaster,$sql_main) or die(mysql_error()."$sql_main<br>LINE__".__LINE__);
		$arrnum = GetPersonUploadFalse();
		while($rs = mysql_fetch_assoc($result_main)){
		
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			 $numupF = $arrnum[$rs[siteid]];

	  ?>
      <tr bgcolor="#FFFFFF">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs[secname]";?></td>
        <td align="center"><? if($numupF > 0){ echo "<a href='?action=view&xsiteid=$rs[siteid]'>".number_format($numupF)."</a>";}else{ echo "0";}?></td>
        <?
			$sumUpF += $numupF;
      	}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
        </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sumUpF)?></strong></td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?
		}//end if($aciton == ""){
		else if($action == "view"){
			
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="9" bgcolor="#CCCCCC"><strong><a href="?action=process&xsiteid=<?=$xsiteid?>">ประมวลผล</a> || <a href="?action=">ย้อนกลับ</a> || ข้อมูลบุคลากรที่จำนวนแผ่นการนำเข้าล่าสุดน้อยกว่าโฟรไฟล์ก่อนหน้า <?=$arrsite[$xsiteid]?></strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="10%" align="center" bgcolor="#CCCCCC"><strong>เลขบัตรประชาชน</strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="18%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>โฟรไฟล์ก่อน</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>จำนวนแผ่น</strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>โฟรไฟล์ล่าสุด</strong></td>
        <td width="14%" align="center" bgcolor="#CCCCCC"><strong>จำนวนแผ่นล่าสุด</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ก.พ. 7</strong></td>
      </tr>
      <?
      	$sql = "SELECT
t2.idcard,
concat(t2.prename_th,
t2.name_th,' ',
t2.surname_th) as fullname,
t2.position_now,
t1.profile_id_before,
t1.page_before,
t1.profile_id_after,
t1.page_after
FROM
view_page_uploadkp7_last_flase AS t1
Inner Join tbl_checklist_kp7 AS t2 ON t1.idcard = t2.idcard AND t1.siteid = t2.siteid AND t1.profile_id_after = t2.profile_id
WHERE t1.siteid='$xsiteid'
order by t2.name_th,t2.surname_th ASC";
$arrprofile = GetProfileName();
		$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	$fname = "../../../".PATH_KP7_FILE."/$xsiteid/".$rs[idcard].".pdf"  ;
	 if (is_file($fname)){ 
			$pdf_orig = " <a href='$fname' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' title='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a> " ; 
		}else{
			$pdf_orig = ""; 	
		}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[fullname]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="center"><?=$arrprofile[$rs[profile_id_before]];?></td>
        <td align="center"><?=$rs[page_before]?></td>
        <td align="center"><?=$arrprofile[$rs[profile_id_after]];?></td>
        <td align="center"><?=$rs[page_after]?></td>
        <td align="center"><?=$pdf_orig?></td>
      </tr>
      <?
		}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
</table>
<?
		}//end if($action == "view"){
?>
</body>
</html>
