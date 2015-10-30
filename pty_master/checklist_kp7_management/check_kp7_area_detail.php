<?
session_start();
set_time_limit(0);
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "checklistkp7"; 
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


include("../../common/common_competency.inc.php");
include("checklist2.inc.php");
include("../pic2cmss/function/function.php");
	$file_name = basename($_SERVER['PHP_SELF']);
function GetFieldComment(){
	global $dbname_temp;
	$sql = "SELECT * FROM tbl_check_menu ORDER BY menu_id ASC ";	
	//echo $dbname_temp." :: $sql";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arrmenu[$rs[field_comment]] = $rs[field_comment];
	}// end while($rs = mysql_fetch_assoc($result)){
		return $arrmenu;
}//end function GetFieldComment(){


$time_start = getmicrotime();


if($_SESSION['session_username'] == ""){
	echo " <script language=\"JavaScript\">  alert(\" ขาดการติดต่อกับ server นานเกินไปกรุณา loginเข้าสู่ระบบอีกครั้ง \"); location.href='login.php';</script>  " ;   
	die;
	//echo "<h3>ขาดการติดต่อกับ server นานเกินไปกรุณา login เข้าสู่ระบบใหม่</h3>";
	//header("Location: login.php");
	//die;
}


function xRmkdir($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
	mkdir($way);
	}
}
if($xaction=="setuser"){
	unset($_SESSION['def_staff']);
	$arr=explode(",",$setuser);
	if(is_array($arr) ){
	foreach($arr as $index=>$values){
	 $_SESSION['def_staff'][$values]='ok';
		}
	}
 
}

if(is_array($_SESSION['def_staff']) ){
	foreach($_SESSION['def_staff'] as $index=>$values){	
	 if($xstr_arr!=""){$xstr_arr.=",";}
	  $xstr_arr.="'".$index."'";
	 
	}
}
//echo $xstr_arr;

##########  บันทึกการตรวจสอบเอกสาร

$arr_problem = show_problem(); // รายการปัญหาเอกสารไม่สมบูรณ์
$arr_doc_comment = show_problem("1"); // รายการเอกสารสมบูรณ์แต่ใส่ comment


#######  ลบข้อมูล


?>
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="../../report/executive_dashboard/css/map_keydata.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
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
<?
	if($action == ""){
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#abc8e2" align="center"><strong><?=show_area($sentsecid);?></strong></td>
  </tr>
  <tr>
    <td bgcolor="#abc8e2">&nbsp;</td>
  </tr>
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="4" bgcolor="#abc8e2"><strong>ค้นหาบุคลากรเพื่อตรวจสอบข้อมูล ก.พ. 7 ต้นฉบับ </strong></td>
              </tr>
            <tr>
              <td width="8%" bgcolor="#FFFFFF"><strong>ชื่อ:</strong></td>
              <td width="25%" bgcolor="#FFFFFF"><label>
                <input name="key_name" type="text" id="key_name" size="25" value="<?=$key_name?>">
              </label></td>
              <td width="18%" bgcolor="#FFFFFF"><strong><?=TEXT_IDCARD?>:</strong></td>
              <td width="49%" bgcolor="#FFFFFF"><label>
                <input name="key_idcard" type="text" id="key_idcard" size="25" value="<?=$key_idcard?>">
              </label></td>
            </tr>
            <tr>
              <td bgcolor="#FFFFFF"><strong>นามสกุล:</strong></td>
              <td bgcolor="#FFFFFF"><label>
                <input name="key_surname" type="text" id="key_surname" size="25" value="<?=$key_surname?>">
              </label></td>
              <td colspan="2" bgcolor="#FFFFFF"><label>
			  <input type="hidden" name="sentsecid" value="<?=$sentsecid?>">
              <input type="hidden" name="profile_id" value="<?=$profile_id?>">
			  <input type="hidden" name="action" value="">
			  <input type="hidden" name="search" value="search">
                <input type="submit" name="Submit" value="ค้นหา">
              </label></td>
              </tr>
          </table></td>
        </tr>
      </table>
        </form>    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<? if($sentsecid != ""){ $xsiteid = $sentsecid;}?>
	<strong>
	<a href='report_checklist.php?lv=1&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>'><?=show_area($xsiteid)?></a> =></strong> <?=show_school($schoolid);?></td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="14" bgcolor="#abc8e2"><strong>รายชื่อบุคลากรที่ทำการตรวจสอบข้อมูล ก.พ. 7 ต้นฉบับ </strong></td>
        </tr>
      <tr>
        <td width="4%" rowspan="2" align="center" bgcolor="#abc8e2"><strong>ลำดับ</strong></td>
        <td width="10%" rowspan="2" align="center" bgcolor="#abc8e2"><strong><?=TEXT_IDCARD?></strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#abc8e2"><strong>คำนำ<br>
          หน้าชื่อ</strong></td>
        <td width="7%" rowspan="2" align="center" bgcolor="#abc8e2"><strong>ชื่อ</strong></td>
        <td width="9%" rowspan="2" align="center" bgcolor="#abc8e2"><strong>นามสกุล</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#abc8e2"><strong>ตำแหน่ง</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#abc8e2"><strong>สถานะ<br>
          เอกสาร</strong></td>
        <td colspan="2" align="center" bgcolor="#abc8e2"><strong>จำนวนแผ่น</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#abc8e2"><strong>ไฟล์<br>
          upload</strong></td>
        <td colspan="3" align="center" bgcolor="#abc8e2"><strong>จำนวนรูป</strong><strong><br>
        </strong></td>
        <td width="23%" rowspan="2" align="center" bgcolor="#abc8e2"><strong>รายละเอียดการตรวจสอบเอกสาร</strong></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#abc8e2"><strong>พนักงาน<br>
          ตรวจ</strong></td>
        <td width="6%" align="center" bgcolor="#abc8e2"><strong>script<br>
          ตรวจ</strong></td>
        <td width="5%" align="center" bgcolor="#abc8e2"><strong>พนักงาน<br>
          นับ</strong></td>
        <td width="5%" align="center" bgcolor="#abc8e2"><strong>upload</strong></td>
        <td width="6%" align="center" bgcolor="#abc8e2"><strong>จำนวนนับ<br>
          ใหม่</strong></td>
        </tr>
	  <?
	  	$arrfield_comment = FieldComment();
	 $page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
	$e			= (!isset($e) || $e == 0) ? 100 : $e ;
	$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 

	  
		if($search == "search"){
			if($key_name != ""){ $conv .= " AND name_th LIKE '%$key_name%'";}
			if($key_surname != ""){ $conv .= " AND surname_th LIKE '%$key_surname%'";}
			if($key_idcard != ""){ $conv .= " AND idcard LIKE '%$key_idcard%'";}
		}
			if($schoolid != ""){ $conschool = " AND schoolid='$schoolid'";}else{ $conschool = "";}
		$sql_main = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' AND profile_id='$profile_id' $conschool $conv ORDER  BY name_th,surname_th ASC";
		//echo $sql_main."<br>$dbname_temp<br>name :: $key_name<br>$key_surname";
		
		
		$xresult = mysql_db_query($dbname_temp,$sql_main);
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
		
	if($page <= $allpage){
			$sql_main .= " LIMIT $i, $e";
	}else if($page == $xpage){
		$i=0;
			$sql_main .= " ";
	}else{
			$sql_main .= " LIMIT $i, $e";
	}

		$result_main = mysql_db_query($dbname_temp,$sql_main);
		$num_row = mysql_num_rows($result_main);
		$search_sql = $sql_main ; 

		$n=0;
		if($all < 1){// ไม่รบรายการที่ค้นหา
			echo "<tr bgcolor='#FFFFFF'><td colspan='14' align='center'> - ไม่พบรายการที่ค้นหา - </td></tr>";
		}else{
		while($rs1 = mysql_fetch_assoc($result_main)){
		$i++;
		 	if ($n++ %  2){ 	$bg = "#F0F0F0"; 	}else{ $bg = "#FFFFFF";	}
			
			if($rs1[page_num] > 0 and $rs1[page_upload] > 0){
				if($rs1[page_num] != $rs1[page_upload]){
					$bg = "#FF0000";		$tr_title = " title='ข้อมูลจำนวนหน้าที่นับโดยระบบกับที่พนักงานนับไม่ตรงกันกรุณาตรวจสอบอีกครั้ง'  style='cursor:hand'";
					$link_up_count_pdf = "1";
				}else{
					$link_up_count_pdf = "0";
					$bg = $bg;		$tr_title = "";	
				}
			}else{
					$link_up_count_pdf = "0";
					$bg = $bg;		$tr_title = "";	
			}
			###  แสดงไฟล์ upload 
			$path_file = "../../../".PATH_KP7_FILE."/$rs1[siteid]/$rs1[idcard]".".pdf";
			if(is_file($path_file)){
				$img_pdf = "<a href='$path_file' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a>";
			}else{
				
				$sql_file = "SELECT * FROM tbl_checklist_log_uploadfile WHERE profile_id='$profile_id' AND idcard='$rs1[idcard]' ORDER BY date_upload DESC";
				$result_file = mysql_db_query($dbname_temp,$sql_file);
				$numrowfile = @mysql_num_rows($result_file);
				if($numrowfile > 0){
						$img_pdf = "<A href=\"#\" OnClick=\"window.open('report_scan_false_detail_person.php?profile_id=$profile_id&idcard=$rs1[idcard]&fullname=$rs1[prename_th]$rs1[name_th]  $rs1[surname_th]','_blank','address=no,toolbar=no,status=yes,scrollbars=yes,width=500,height=400')\"><img src=\"../../images_sys/doc_problem.png\" width=\"23\" height=\"22\" title='คลิ๊กเพื่อดูประวัติิการ upload ไฟล์ ก.พ.7' border='0'></a>";	
				}else{
						$arrkp7 = GetPdfOrginal($rs1[idcard],$path_pdf,$imgpdf,"","pdf");
						$img_pdf = $arrkp7['linkfile'];	
						//$img_pdf = "";
				}
				
				
			}
			
			########  ตรวจสอบความสมบูรณ์ของรายการที่ตรวจสอบ
			if($rs1[general_status] == "1" and $rs1[graduate_status] == "1" and $rs1[salary_status] == "1"  and $rs1[seminar_status] == "1" and $rs1[sheet_status] == "1" and $rs1[getroyal_status] == "1" and $rs1[special_status] == "1" and  $rs1[goodman_status] == "1" and $rs1[absent_status] == "1" and $rs1[nosalary_status] == "1" and $rs1[prohibit_status] == "1" and $rs1[specialduty_status] == "1" and $rs1[other_status] == "1"){
					$file_complate = "1";
			}else if($rs1[general_status] == "0" or $rs1[graduate_status] == "0" or $rs1[salary_status] == "0"  or $rs1[seminar_status] == "0" or $rs1[sheet_status] == "0" or $rs1[getroyal_status] == "0" or $rs1[special_status] == "0" or $rs1[goodman_status] == "0" or $rs1[absent_status] == "0" or $rs1[nosalary_status] == "0" or $rs1[prohibit_status] == "0" or $rs1[specialduty_status] == "0" or $rs1[other_status] == "0"){
					$file_complate = "0";
			}else{
					$file_complate = "";
			}
			
			
			if(trim($rs1[comment_pic]) != ""){
				$alert_pic = "<img src=\"../../images_sys/alert.png\" width=\"15\" height=\"14\" border=\"0\" title='เอกสารที่หมายเหตุหลังจำนวนรูปภาพอาจหมายถึงเอกสารไม่มีปกหน้าเป็นต้น'>";
			}else{
				$alert_pic = "";
			}
			## end แสดงไฟล์  upload
			
			if(($rs1[pic_num] > 0 and $rs1[pic_upload] > 0 and  $rs1[pic_num]  != $rs1[pic_upload]) or ($rs1[pic_upload] > 0 and $rs1[pic_num] < 1)){
					$bg = "#FF9900";		$tr_title = " title='ข้อมูลจำนวนรูปคนนับกับที่ upload ขึ้นไปในระบบไม่ตรงกัน'  style='cursor:hand'";
			}//end if($rs1[pic_num] > 0 and $rs1[pic_upload] > 0 and  $rs1[pic_num]  != $rs1[pic_upload]){
	  ?>
	  
      <tr bgcolor="<?=$bg?>" <?=$tr_title?>>
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs1[idcard]?><?=$alert_pic?>
          </td>
        <td align="left"><? echo "$rs1[prename_th]";?></td>
        <td align="left"><? echo "$rs1[name_th]";?></td>
        <td align="left"><? echo "$rs1[surname_th]";?></td>
        <td align="center"><? echo "$rs1[position_now]";?></td>
        <td align="center"><?=show_icon_check($rs1[status_file],$rs1[status_check_file],$rs1[status_numfile],$file_complate);?><? if($rs1[problem_status_id] > 0){ echo "<font color='red'>*</font>";}else{ echo "";}?></td>
        <td align="center"><? if($rs1[page_num] > 0){ echo number_format($rs1[page_num]); }else{ echo "-";}?></td>
        <td align="center"><?  if($rs1[page_upload] > 0){ echo number_format($rs1[page_upload]); }else{ echo "-";}  if($link_up_count_pdf == 1){ echo " <a href=\"count_filepdf.php?temp_siteid=$rs1[siteid]&xidcard=$rs1[idcard]&profile_id=$profile_id\" target=\"_blank\"> ประมวลผล </a>";}?></td>
        <td align="center"><?=$img_pdf?></td>
        <td align="center"><? if($rs1[pic_num] > 0){ echo number_format($rs1[pic_num]);}else{ echo "-";}?></td>
        <td align="center">
        <?
        	echo "$rs1[pic_upload]";
		?> 
        </td>
        <td align="center"><?
        $sql_numpic = "SELECT * FROM upload_compare_kp7 WHERE id='$rs1[idcard]'";
		$result_numpic = @mysql_db_query($dbname_temp,$sql_numpic);
		$rs_numpic = @mysql_fetch_assoc($result_numpic);
		echo $rs_numpic[number];
		?></td>
		<td align="center">
		
<?
//$sql_detail = "SELECT * FROM tbl_checklist_problem_detail WHERE idcard='$rs1[idcard]' AND status_problem = '0' AND profile_id='$profile_id'   ORDER BY menu_id,problem_id  ASC";
$sql_detail = "SELECT * FROM
tbl_checklist_problem_detail as t1
Inner Join tbl_problem as t2 ON t1.problem_id = t2.problem_id
WHERE
t1.idcard =  '$rs1[idcard]' AND
t1.status_problem =  '0' AND
t1.profile_id =  '$profile_id' AND
t2.type_problem =  '0'
ORDER BY t1.menu_id,t2.problem_id  ASC";
$result_detail = mysql_db_query($dbtemp_check,$sql_detail);
if (@mysql_num_rows($result_detail) > 0 ){ 
?>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="38%" align="center" bgcolor="#abc8e2"><strong>หมวดปัญหา</strong></td>
                <td width="62%" align="center" bgcolor="#abc8e2"><strong>รายละเอียดปัญหา</strong></td>
                </tr>
                <?

					$j=0;
					while($rs_d = mysql_fetch_assoc($result_detail)){
					
					
						if ($j++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}	
				?>
              <tr bgcolor="<?=$bg1?>">
                <td align="left"><? echo GetTypeMenu($rs_d[menu_id])." => ".GetTypeProblem($rs_d[problem_id]);?></td>
                <td align="left"><?=$rs_d[problem_detail]?></td>
                </tr>
               <?
					}//end while(){
			   ?>
            </table>
<? } ########## END if (@mysql_num_rows(result_detail) > 0 ){ 

####  หาค่า comment ที่อยู่ใน field ในการจัดเก็บรูปแบบเก่า(เอกสารสมบูรณ์)
if(count($arrfield_comment) > 0){
		foreach($arrfield_comment as $kx1 => $vx1){
			if($rs1[$kx1] != ""){
				$nexttext1 = wordwrap($rs1[$kx1], 10, "\n",true);
					$arrcomp[$vx1] = $nexttext1;
			}
		}//end foreach($arrfield_comment as $kx1 => $vx1){
}// end if(count($arrfield_comment) > 0){


############  หาค่า comment ในการจัดเก็บรูปแบบใหม่(เอกสารสมบูรณ์)
$sql_docm = "SELECT
t1.idcard,
t1.menu_id,
t2.problem
FROM
tbl_checklist_problem_detail as t1
Inner Join tbl_problem as t2 ON t1.problem_id = t2.problem_id
WHERE
t1.status_problem =  '0' AND
t2.type_problem =  '1' AND t1.idcard='$rs1[idcard]' AND t1.profile_id='$profile_id' ORDER BY  t1.menu_id ASC";
$result_doc = mysql_db_query($dbname_temp,$sql_docm);
$numr_doc = @mysql_num_rows($result_doc);
while($rsd = mysql_fetch_assoc($result_doc)){
	if($xmenu_id != $rsd[menu_id]){
		$comment_doc = "";
		$xmenu_id = $rsd[menu_id];
	}
	
	if($comment_doc > "") $comment_doc .= ",";
	$comment_doc .= $rsd[problem];
	$nexttext2 = wordwrap($comment_doc, 10, "\n",true);
	$arrdocp1[GetTypeMenu($rsd[menu_id])] = $nexttext2;

}// end while($rsd = mysql_fetch_assoc($result_doc)){
	
	
#####  ทำการเชื่อมโยงกันระหว่างข้อมูลรูปแบบเก่ากับแบบใหม่
if(count($arrdocp1) > 0){
	foreach($arrdocp1 as $xk2 => $xv2){
			if(array_key_exists("$xk2", $arrcomp)) {
				
				$temp_text =  $xv2.",".$arrcomp[$xk2];
				$nexttext = wordwrap($temp_text, 10, "\n",true);
				$arrc[$xk2] = $nexttext;
				unset($arrcomp[$xk2]); // เคลียค่า array ทีซ้ำ
			}else{
				$arrc[$xk2] = $xv2;
			} //end 	if(array_key_exists("$xk2", $arrcomp)) {
	}//end foreach($arrdocp1 as $xk2 => $xv2){
}//end  if(count($arrdocp1) > 0){

if(count($arrdocp1) > 0 and count($arrcomp) > 0){
	$arrmerge = array_merge($arrc,$arrcomp);
}else if(count($arrdocp1) > 0 and count($arrcomp) < 1){
	$arrmerge = $arrdocp1;
}else if(count($arrdocp1) < 1 and count($arrcomp) > 0){
	$arrmerge = $arrcomp;
}//end if(count($arrdocp1) > 0 and count($arrcomp) > 0){
	//echo "<pre>";
	//print_r($arrcomp);
	//print_r($arrmerge);


if(count($arrmerge) > 0){
?>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
 <tr>
    <td colspan="2" bgcolor="#009900" align="center"><strong>หมายเหตุรายการเอกสารสมบูรณ์</strong></td>
    </tr>
  <tr>
    <td bgcolor="#009900" align="center"><strong>หมวดข้อมูล</strong></td>
    <td bgcolor="#009900" align="center"><strong>หมายเหตุ</strong></td>
  </tr>
    <? ;
		$xj=0;
		foreach($arrmerge as $keyc => $valc){
			if ($xj++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}	
	?>
      <tr bgcolor="<?=$bg1?>">
        <td width="44%"><?=$keyc?></td>
        <td width="56%" ><?=$valc?></td>
      </tr>
  <?
		}//end  foreach($arrcomp as $keyc => $valc){
?>
</table>

<? }// end if(count($arrmerge) > 0){?>
</td>
      </tr>
	  <?
	 // $arrcomp = array();
	 	unset($arrmerge);
		unset($arrc);
	  	unset($arrcomp);
	  	unset($arrdocp1);
	 
	  	}//end while(){
		} //end if($all < 1){
		if($all > 0){ //
	  ?>
      <tr>
        <td colspan="14" align="center" bgcolor="#FFFFFF"><? $sqlencode = urlencode($search_sql)  ; ?>	
	<?=devidepage($allpage, $keyword ,$sqlencode )?></td>
        </tr>
	<? } //end 	if($all > 0){?>
    </table></td>
  </tr>
</table>

  <?
	}
?>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
