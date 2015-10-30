<?
set_time_limit(0);
session_start();
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		ระบบส่งงาน
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
include "epm.inc.php";
require_once("../../common/function_upload_kp7file_qc.php"); 
require_once("../checklist_kp7_management/function_check_xref.php");
$path_file = "../../../kp7file_qc/";


function GetSecname($secid){
	global $dbnamemaster;
	$sql = "SELECT * FROM eduarea WHERE secid='$secid'";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname]);
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
	if($Aaction == "Save"){
		$path_file = $path_file.$ticketid."/"; // path ปลายทาง
		$result_upload = UploadKp7fileQC($kp7file,$kp7file_name,$idcard,$path_file,$siteid,$staffid,$ticketid,$comment_upload);	
		if($result_upload){
				echo "<script>alert('อัปโหลดไฟล์แนบเรียบร้อยแล้ว');location.href='?idcard=$idcard&ticketid=$ticketid&staffid=$staffid&action=';</script>";
					exit();
		}
	}//end if($Aaction == "Save"){
}// end if($_SERVER['REQUEST_METHOD'] == "POST"){

function devidepage($total, $kwd , $sqlencode ){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page,$ticketid,$staffname,$staffsurname,$idcard,$name_th,$surname_th,$action;

	if($total >= 1){
		$table	= "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
		$table	= $table."<tr align=\"right\">";
		$table	= $table."<td width=\"80%\" align=\"left\" height=\"30\">&nbsp;";
				
		if($page_all <= $per_page){
			$min		= 1;
			$max		= $page_all;
		} elseif($page_all > $per_page && ($page - 5) >= 2 ) {			
			$min		= $page - 5;
			$max		= (($page + 5) > $page_all) ? $page_all : $page + 5;
		} else {
			$min	= 1;
			$max	= $per_page; 			
		}
	
		if($min >= 4){ 
			$table .= "<a href=\"?page=1&ticketid=$ticketid&staffname=$staffname&staffsurname=$staffsurname&idcard=$idcard&name_th=$name_th&surname_th=$surname_th&action=$action&displaytype=people".$kwd."\"><u><font color=\"black\">หน้าแรก</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?page=".$i."&ticketid=$ticketid&staffname=$staffname&staffsurname=$staffsurname&idcard=$idcard&name_th=$name_th&surname_th=$surname_th&action=$action&displaytype=people". $kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?page=".$page_all."&ticketid=$ticketid&staffname=$staffname&staffsurname=$staffsurname&idcard=$idcard&name_th=$name_th&surname_th=$surname_th&action=$action&displaytype=people". $kwd."\"><u><font color=\"black\">หน้าสุดท้าย</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?page=".($page_all+1)."&ticketid=$ticketid&staffname=$staffname&staffsurname=$staffsurname&idcard=$idcard&name_th=$name_th&surname_th=$surname_th&action=$action&displaytype=people". $kwd."\"><u><font color=\"black\">แสดงทั้งหมด</font></u></a>";
		}
#		$table .= "&nbsp;<a href=\"search_excel.php?page=$sqlencode\"><u><font color=\"black\">ส่งออกรูปแบบ MS Excel </font></u></a>";

		unset($max,$i,$min);
	
		$table	= $table."</td>";	
		$table	= $table."<td width=\"20%\">จำนวนทั้งหมด <b>".number_format($page_all, 0, "", ",")."</b>&nbsp;หน้า&nbsp;</td>";
		$table	= $table."</tr>";
		$table	= $table."</table>";
	}
 	return $table;
}


?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">

function CheckF2(){
	if(document.form2.kp7file.value != "" ){
		alert("กรุณาระบุไฟล์แนบผลการ QC เอกสาร ก.พ.7");	
			document.form2.kp7file.focus();
	}
	if(document.form2.comment_upload.value == "" ){
		alert("กรุณาระบุหมายเหตุการ upload ไฟล์แนบ");
		document.form2.comment_upload.focus();
		return false;
			
	}	
	return true;
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

</head>

<body>
<?
	if($action == ""){
?>
<form name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="12" align="left" bgcolor="#A5B2CE"><strong>ค้นหาผลการ QC เอกสาร ก.พ.7 เพื่อแนบไฟล์ผลการ QC</strong></td>
          </tr>
        <tr>
          <td colspan="12" align="center" bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td width="50%" align="center"><strong>ฟอร์มข้อมูลพนักงานคีย์</strong></td>
              <td width="50%" align="center"><strong>ฟอร์มข้อมูลข้าราชการครูและบุคลากรทางการศึกษา</strong></td>
            </tr>
            <tr>
              <td align="center" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="62%" align="right"><strong>รหัสใบงาน : </strong></td>
                  <td width="38%">
                    <input name="ticketid" type="text" id="ticketid" size="30" value="<?=$ticketid?>"></td>
                </tr>
                <tr>
                  <td align="right"><strong>ชื่อพนักงาน : </strong></td>
                  <td>
                    <input name="staffname" type="text" id="staffname" size="30" value="<?=$staffname?>"></td>
                </tr>
                <tr>
                  <td align="right"><strong>นามสกุลพนักงาน : </strong></td>
                  <td>
                    <input name="staffsurname" type="text" id="staffsurname" size="30" value="<?=$staffsurname?>"></td>
                </tr>
              </table></td>
              <td align="center" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="26%" align="right"><strong>เลขบัตรประชาชน : </strong></td>
                  <td width="74%">
                    <input name="idcard" type="text" id="idcard" size="30"  value="<?=$idcard?>"></td>
                </tr>
                <tr>
                  <td align="right"><strong>ชื่อ : </strong></td>
                  <td>
                    <input name="name_th" type="text" id="name_th" size="30" value="<?=$name_th?>"></td>
                </tr>
                <tr>
                  <td align="right"><strong>นามสกุล : </strong></td>
                  <td>
                    <input name="surname_th" type="text" id="surname_th" size="30"  value="<?=$surname_th?>"></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="button" id="button" value="ค้นหา"></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td width="3%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
          <td width="9%" align="center" bgcolor="#A5B2CE"><strong>รหัสใบงาน</strong></td>
          <td width="8%" align="center" bgcolor="#A5B2CE"><strong>เลขบัตรประชาชน</strong></td>
          <td width="9%" align="center" bgcolor="#A5B2CE"><strong>ชื่อ - นามสกุล</strong></td>
          <td width="12%" align="center" bgcolor="#A5B2CE"><strong>พนักงานคีย์ข้อมูล</strong></td>
          <td width="8%" align="center" bgcolor="#A5B2CE"><strong>พนักงานตรวจคำผิด</strong></td>
          <td width="8%" align="center" bgcolor="#A5B2CE"><strong>วันที่ตรวจคำผิด</strong></td>
          <td width="9%" align="center" bgcolor="#A5B2CE"><strong>พนักงานลงลิส</strong></td>
          <td width="8%" align="center" bgcolor="#A5B2CE"><strong>วันที่ลงลิส</strong></td>
          <td width="6%" align="center" bgcolor="#A5B2CE"><strong>จุดผิด(จุด)</strong></td>
          <td width="13%" align="center" bgcolor="#A5B2CE"><strong>ไฟล์แนบ</strong></td>
          <td width="7%" align="center" bgcolor="#A5B2CE"><strong>แนบไฟล์</strong></td>
        </tr>
        <?
		
		  	$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
			$e			= (!isset($e) || $e == 0) ? 20 : $e ;
			$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 


		
			if($ticketid != ""){
					$conv .= " AND t1.ticketid LIKE '%$ticketid%' ";
			}
			if($staffname != ""){
					$conv .= " AND t2.staffname LIKE '%$staffname%' ";
			}
			if($staffsurname != ""){
					$conv .= " AND t2.staffsurname LIKE '%$staffsurname%' ";
			}
			if($idcard != ""){
					$conv .= " AND t1.idcard LIKE '%$idcard%' ";
			}
			if($name_th != ""){
					$conv .= " AND t3.name_th LIKE '%$name_th%' ";
			}
			if($surname_th != ""){
					$conv .= " AND t3.surname_th LIKE '%$surname_th%' ";
			}

        	$sql = "SELECT t1.ticketid, t2.staffid, t1.idcard, t3.prename_th, t3.name_th, t3.surname_th, t3.siteid, t2.staffname, t2.staffsurname, t1.qc_staffid, t1.qc_date, t1.staffid_check, t1.date_check,
sum(t1.num_point) as sumpoint
FROM ".DB_USERENTRY.".validate_checkdata as t1
Inner Join ".DB_USERENTRY.".keystaff  as t2 ON t1.staffid = t2.staffid
Inner Join  ".DB_MASTER.".view_general as t3 ON t1.idcard = t3.CZ_ID
WHERE  1 $conv
GROUP BY t1.idcard";
			
		$xresult = mysql_db_query($dbnameuse,$sql);
		$all= mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
		
	if($page <= $allpage){
			$sql .= " LIMIT $i, $e";
	}else if($page == $xpage){
		$i=0;
			$sql .= " ";
	}else{
			$sql .= " LIMIT $i, $e";
	}

	if($all  < 1){
	echo " <tr bgcolor=\"#FFFFFF\"><td colspan='11' align='center' valign='top'> -ไม่พบข้อมูลที่ค้นหา -</td></tr>";
	}else{ 
		$search_sql = $sql ; 

			$result = mysql_db_query($dbnameuse,$sql );
			while($rs = mysql_fetch_assoc($result)){
			if($i% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $i++;
			
			$kp7file = "../../../edubkk_kp7file/$rs[siteid]/$rs[idcard]".".pdf";
			if(is_file($kp7file)){
				$img_kp7 = "<a href='$kp7file' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" title=\"แสดงเอกสาร ก.พ.7 ต้นฉบับ\" width=\"16\" height=\"16\" border=\"0\"></a>";
			}else{
				$img_kp7 = "";	
			}
		$pdf.= "<a href=\"../hr3/hr_report/kp7.php?id=".$rs[idcard]."&sentsecid=".$rs[siteid]."\" target=\"_blank\">";
		$pdf.= "<img src=\"../hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\" title='ก.พ.7 สร้างโดยระบบ '  ></a>";
		
		
		            $sql1 = "SELECT runid,idcard,siteid,staffid,ticketid,file_upload,comment_upload,time_upload,time_update FROM `validate_checkdata_upload` where idcard='$rs[idcard]' and siteid='$rs[siteid]' and staffid='$rs[staffid]' and ticketid='$rs[ticketid]'";
					$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql1<br>LINE::".__LINE__);
					$numr = mysql_num_rows($result1);
		?>
        <tr bgcolor="<?=$bg?>">
          <td align="center" valign="top"><?=$i?></td>
          <td align="center" valign="top"><?=$rs[ticketid]?></td>
          <td align="center" valign="top"><?=$rs[idcard]?></td>
          <td align="left" valign="top"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
          <td align="left" valign="top"><?=ShowStaffOffice($rs[staffid]);?></td>
          <td align="left" valign="top"><?=ShowStaffOffice($rs[qc_staffid]);?></td>
          <td align="center" valign="top"><?=DBThaiLongDate($rs[qc_date]);?></td>
          <td align="left" valign="top"><?=ShowStaffOffice($rs[staffid_check]);?></td>
          <td align="center" valign="top"><?=DBThaiLongDate($rs[date_check]);?></td>
          <td align="center" valign="top"><?=number_format($rs[sumpoint])?></td>
          <td align="center" valign="top">
          <?
          	if($numr < 1){ echo " - ไม่พบไฟล์แนบ -";}else{
		  ?>
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td width="73%" align="center" bgcolor="#CCCCCC"><strong>หมายเหตุไฟล์แนบ</strong></td>
              <td width="27%" align="center" bgcolor="#CCCCCC"><strong>ไฟล์แนบ</strong></td>
            </tr>
            <?
			$j=0;
			while($rsf = mysql_fetch_assoc($result1)){
				if($j% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $j++;
				$file_upload = "../../../kp7file_qc/$rs[ticketid]/$rsf[file_upload]";
				if(is_file($file_upload)){
				
			?>
            <tr bgcolor="<?=$bg?>">
              <td align="left"><?=$rsf[comment_upload]?></td>
              <td align="center"><a href="<?=$file_upload?>" target="_blank"><img src="../validate_management/images/page_white_acrobat.png" width="16" height="16" border="0" title="คลิ๊กเพื่อเปิดไฟล์แนบ"></a></td>
            </tr>
            <?
				}//end 	if(is_file($file_upload)){
			}//end while($rsf = mysql_fetch_assoc($result1)){ 
			?>
          </table><? } // end  	if($numr < 1){ echo " - ไม่พบไฟล์แนบ -";}else{ ?></td>
          <td align="center" valign="top"><? echo "$img_kp7 $pdf";?>&nbsp;<a href="?action=upload_file&ticketid=<?=$rs[ticketid]?>&idcard=<?=$rs[idcard]?>&staffid=<?=$rs[staffid]?>"><img src="../validate_management/images/application_link.png" width="16" height="16" border="0" title="คลิ๊กเพื่อแนบไฟล์ผลการตรวจสอบเอกสาร ก.พ.7"></a></td>
        </tr>
          <?
		$pdf = "";
			}//end 	while($rs = mysql_fetch_assoc($result)){
		?>

        <tr bgcolor="<?=$bg?>">
          <td colspan="12" align="center" valign="top">	<? $sqlencode = urlencode($search_sql)  ; ?>	
	<?=devidepage($allpage, $keyword ,$sqlencode )?></td>
          </tr>
          <?
			}//end if($all < 1){echo " <tr><td colspan='11' align='center' valign='top'> -ไม่พบข้อมูลที่ค้นหา -</td></tr>";
		  ?>
      </table></td>
    </tr>

    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?
	}else if($action == "upload_file"){//end 	if($action == ""){
		$sql = "SELECT t1.ticketid, t2.staffid, t1.idcard, t3.prename_th, t3.name_th, t3.surname_th, t3.siteid, t2.staffname, t2.staffsurname, t1.qc_staffid, t1.qc_date, t1.staffid_check, t1.date_check,
sum(t1.num_point) as sumpoint,t3.position_now,t3.schoolname
FROM ".DB_USERENTRY.".validate_checkdata as t1
Inner Join ".DB_USERENTRY.".keystaff  as t2 ON t1.staffid = t2.staffid
Inner Join  ".DB_MASTER.".view_general as t3 ON t1.idcard = t3.CZ_ID
WHERE   t1.ticketid = '$ticketid' AND  t2.staffid='$staffid' AND t1.idcard='$idcard'  
GROUP BY t1.idcard";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_db_query()."$sql<br>LINE::".__LINE__);
		$rs = mysql_fetch_assoc($result);
?>
<form action="" method="post" enctype="multipart/form-data" name="form2" onSubmit=" return CheckF2();">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#333333"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="2" bgcolor="#A5B2CE"><strong><a href="?action=&ticketid=<?=$ticketid?>&idcad=<?=$idcard?>&staffid=<?=$staffid?>"><img src="../../images_sys/home.gif" width="20" height="20" border="0" title="กลับหน้าหลัก"></a>ฟอร์มการแนบไฟล์ผลการตรวจสอบคำผิด ก.พ.7</strong></td>
          </tr>
        <tr>
          <td width="18%" align="right" bgcolor="#FFFFFF"><strong>รหัสใบงาน : </strong></td>
          <td width="82%" align="left" bgcolor="#FFFFFF"><?=$rs[ticketid]?></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>เลขบัตรประชาชน : </strong></td>
          <td align="left" bgcolor="#FFFFFF"><?=$rs[idcard]?></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>ชื่อ- นามสกุล บุคลากร : </strong></td>
          <td align="left" bgcolor="#FFFFFF"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>ตำแหน่ง : </strong></td>
          <td align="left" bgcolor="#FFFFFF"><?=$rs[position_now]?></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>สังกัด : </strong></td>
          <td align="left" bgcolor="#FFFFFF"><? echo GetSecname($rs[siteid])." / $rs[schoolname]";?></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>พนักงานคีย์ข้อมูล : </strong></td>
          <td align="left" bgcolor="#FFFFFF"><?=ShowStaffOffice($rs[staffid]);?></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>ชื่อ - นามสกุลพนักงานตรวจคำผิด : </strong></td>
          <td align="left" bgcolor="#FFFFFF"><?=ShowStaffOffice($rs[qc_staffid]);?></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>วันที่ตรวจคำผิด : </strong></td>
          <td align="left" bgcolor="#FFFFFF"><?=DBThaiLongDate($rs[qc_date]);?></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>พนักงานลงลิส : </strong></td>
          <td align="left" bgcolor="#FFFFFF"><?=ShowStaffOffice($rs[staffid_check]);?></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>วันที่ลงลิส : </strong></td>
          <td align="left" bgcolor="#FFFFFF"><?=DBThaiLongDate($rs[date_check]);?></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>จุดผิด(จุด) : </strong></td>
          <td align="left" bgcolor="#FFFFFF"><?=number_format($rs[sumpoint])?></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>ไฟล์แนบ : </strong></td>
          <td align="left" bgcolor="#FFFFFF"><label for="kp7file"></label>
            <input type="file" name="kp7file" id="kp7file"></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>หมายเหตุ : </strong></td>
          <td align="left" bgcolor="#FFFFFF"><label for="comment_upload"></label>
            <textarea name="comment_upload" id="comment_upload" cols="45" rows="5"></textarea></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
          <td align="left" bgcolor="#FFFFFF">
          <input type="hidden" name="ticketid" value="<?=$rs[ticketid]?>">
          <input type="hidden" name="idcard" value="<?=$rs[idcard]?>">
           <input type="hidden" name="staffid" value="<?=$rs[staffid]?>">
            <input type="hidden" name="siteid" value="<?=$rs[siteid]?>">
            <input type="hidden" name="Aaction" value="Save">
          <input type="submit" name="button2" id="button2" value="บันทึก">
          <input type="button" name="btnB" id="btnB1" value="ย้อนกลับ" onClick="location.href='?action=&ticketid=<?=$ticketid?>&idcad=<?=$idcard?>&staffid=<?=$staffid?>'">
          </td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<?
	}//end }else if($action == "upload_file"){//end 	if($action == ""){
?>
</BODY>
</HTML>
