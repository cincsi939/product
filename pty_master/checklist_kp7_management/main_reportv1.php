<?
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "checklistkp7_report"; 
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
$time_start = getmicrotime();




?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<link href="../../common/gs_sortable.css" />
<script src="../../common/gs_sortable.js"></script>
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
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="12%" align="right"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td width="55%">
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
<?
	
	
	$arr1 = show_val_exsum($lv,$xsiteid,$schoolid,$profile_id);
	
?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
   <td align="center"><table width="500" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
         <tr>
           <td colspan="2" align="center" bgcolor="#CAD5FF"><strong>รายงานการตรวจสอบเอกสารต้นฉบับ <?=ShowProfile_name($profile_id);?></strong></td>
           </tr>
         <tr>
           <td width="55%" align="center" bgcolor="#CAD5FF"><strong>รายการ</strong></td>
           <td width="14%" align="center" bgcolor="#CAD5FF"><strong>จำนวน(คน)</strong></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;<SPAN lang="TH">ค้างรับจากเขต</SPAN></strong></td>
           <td align="center" bgcolor="#FFFFFF"><?=number_format($arr1['numN']);?></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;ตรวจสอบแล้วสมบูรณ์</strong></td>
           <td align="center" bgcolor="#FFFFFF"><?=number_format($arr1['numY1']);?></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong> &nbsp;ตรวจสอบแล้วไม่มีปก</strong></td>
           <td align="center" bgcolor="#FFFFFF"><?=number_format($arr1['NumNoMain'])?></td>
         </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;ตรวจสอบแล้วไม่สมบูรณ์</strong></td>
           <td align="center" bgcolor="#FFFFFF"><?=number_format($arr1['numY0']);?></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#EEEEEE"><strong>&nbsp;จำนวนทั้งหมด</strong></td>
           <td align="center" bgcolor="#EEEEEE"><strong>
             <?=number_format($arr1['numall']);?>
           </strong></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#EEEEEE"><strong>&nbsp;จำนวนหน้าเอกสาร</strong></td>
           <td align="center" bgcolor="#EEEEEE"><?=number_format($arr1['numpage']);?></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#EEEEEE"><strong>&nbsp;จำนวนรูป</strong></td>
           <td align="center" bgcolor="#EEEEEE"><?=number_format($arr1['numpic']);?></td>
           </tr>
       </table></td>
     </tr>
   </table></td>
 </tr>
 <tr>
    <td align="left">&nbsp;<strong><? if($lv == 1){ echo "<a href='?lv=&profile_id=$profile_id'>แสดงข้อมูลภาพรวม</a> => ".show_area($xsiteid);}?></strong></td>
  </tr>
  <?
  	if($lv == ""){ $xcolh = "10"; $xcolf = "2";}else{  $xcolh = "11";$xcolf = "3";}
  ?>
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3" id="my_table">
	<thead>  
      <tr class="strong_black" align="center">
       <td colspan="<?=$xcolh?>" align="center" bgcolor="#A8B9FF"><strong>รายงานการตรวจสอบเอกสาร ก.พ. 7 ต้นฉบับ&nbsp;<?=ShowProfile_name($profile_id);?> </strong></td>
        </tr>
      <tr>
        <th width="4%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>ลำดับ</strong></th>
        <? if($lv == "1"){?>
        <th width="8%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>รหัสหน่วยงาน</strong></th>
        <? } //end if($lv == "1"){?>
        <th width="30%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>เขตพื้นที่การศึกษา</strong></th>
        <th width="10%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>จำนวน<br>
          ทั้งหมด(คน)</strong></th>
        <th width="10%" rowspan="3" align="center" bgcolor="#A8B9FF">ผ่าน Quick  look(คน)</th>
        <th width="10%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>จำนวนหน้า<br>
          เอกสาร(แผ่น)</strong></th>
        <td colspan="4" align="center" bgcolor="#A8B9FF"><strong>สถานะการตรวจสอบ</strong></td>
        <th width="10%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>จำนวนรูป(รูป)</strong></th>
        </tr>
      <tr>
        <th width="9%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ค้างตรวจ(คน)</strong></th>
        <th colspan="3" align="center" bgcolor="#A8B9FF"><strong>ตรวจสอบแล้ว(คน)</strong></th>
        </tr>
      <tr>
        <th width="9%" align="center" bgcolor="#A8B9FF"><strong>สมบูรณ์</strong></th>
        <th width="10%" align="center" bgcolor="#A8B9FF">ไม่มีปก</th>
        <th width="10%" align="center" bgcolor="#A8B9FF"><strong>ไม่สมบูรณ์</strong></th>
        </tr>
	</thead>    
	<tbody>    
		<?
	
		if($lv == ""){// ข้อมูลรายเขต
			$sql = "SELECT
eduarea.secid,
eduarea.secname
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' AND profile_id='$profile_id'
ORDER BY
eduarea.secname ASC";
			$result = mysql_db_query($dbnamemaster,$sql);
			$arrN = CountCheckListKp7V1($profile_id);
			//$rs = mysql_fetch_assoc($result);
		}else if($lv == "1"){ // ข้อมูลรายโรง
				//$sql = "SELECT CAST(id as SIGNED) as id, siteid,office FROM allschool WHERE siteid='$xsiteid' order by id ASC, office ASC";
				//$result = mysql_db_query($dbnamemaster,$sql);
			$sql = "SELECT
CAST(id as SIGNED) as id, allschool.siteid,office,
sum(if(status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') ,1,0 )) as NumPass, 
sum(if(status_file='0' and status_check_file='YES' ,1,0 )) as NumNoPass, 
sum(if(status_check_file='YES' and mainpage ='0' and status_file='1',1,0 )) as NumNoMain, 
Sum(if(status_file='0' AND status_check_file='NO' ,1,0)) AS NumDisC,
sum(if(status_numfile='1',1,0)) as NumQL, 
Sum(page_num) AS NumPage,
Sum(pic_num) AS NumPic,
Count(idcard) AS NumAll,
sum(if(sex='1',1,0 ) ) AS  NumM,
sum(if(sex='2',1,0 ) ) AS  NumF
FROM
edubkk_checklist.tbl_checklist_kp7
Inner Join edubkk_master.allschool ON edubkk_checklist.tbl_checklist_kp7.schoolid = edubkk_master.allschool.id
WHERE
edubkk_checklist.tbl_checklist_kp7.siteid =  '$xsiteid' AND profile_id='$profile_id'
GROUP BY
edubkk_checklist.tbl_checklist_kp7.schoolid
order by id ASC
";
//echo $sql;
$result = mysql_db_query($dbname_temp,$sql);
				
		}//end if($lv == ""){
		$count_y = 0;$count_yn=0;$count_n=0;$count_impP=0;
		
		while($rs = mysql_fetch_assoc($result)){
			
			
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			  if($lv == ""){
//				$id_org = "$rs[secid]";
//			  $arr_1 = count_page_pic($rs[secid],"area","");
//			  $numpage = $arr_1['page']; //  จำนวนแผ่น
//			  $numpic = $arr_1['pic']; // จำนวนรูป
//			  $count_y = count_checklist_kp7($rs[secid],"Y","");// ตรวจสอบผ่าน
//			  $count_yn = count_checklist_kp7($rs[secid],"YN","");// ตรวจสอบแล้วไม่ผ่าน
//			  $count_n = count_checklist_kp7($rs[secid],"N","");// ค้างตรวจสอบ
//			  $count_impP = $count_y+$count_yn+$count_n ;// จำนวนทั้งหม
			  $temp_dis = CheckLockArea($rs[secid],$profile_id);
			  	
				  $id_org = "$rs[secid]";
				  $numpage = $arrN[$id_org]['NumPage']; //  จำนวนแผ่น
				  $numpic = $arrN[$id_org]['NumPic']; // จำนวนรูป
				  $count_y = $arrN[$id_org]['NumPass'];// ตรวจสอบผ่าน
				  $count_yn = $arrN[$id_org]['NumNoPass'];// ตรวจสอบแล้วไม่ผ่าน
				  $count_n = $arrN[$id_org]['NumDisC'];// ค้างตรวจสอบ
				  $count_impP = $arrN[$id_org]['NumAll'];// จำนวนทั้งหมด
                $count_sexM=$arrN[$id_org]['NumM'];
			   $count_sexF=$arrN[$id_org]['NumF'];
			   $count_QL = $arrN[$id_org]['NumQL'];
			   $count_NumNoMain = $arrN[$id_org]['NumNoMain'];
			  
				  $getlink = "?action=&lv=1&xsiteid=$rs[secid]&schoolid=&profile_id=$profile_id";
				  if($temp_dis > 0){
					  $xalink_sys = "<font color='#FF0000'><b>*</b></font>";
				  }else{
						$xalink_sys = "";
				  }//end if($temp_dis > 0){
						  if($count_impP > 0){
								$xalink = "<a href='$getlink'>".str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname])."</a> $xalink_sys";
						  }else{
								$xalink = str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname]);
						  }
				//  }// end  if($temp_dis > 0){
			  }else if($lv == "1"){
//				  $id_org = "$rs[id]";
//			  $arr_1 = count_page_pic($rs[siteid],"school","$rs[id]");
//			  $numpage = $arr_1['page']; //  จำนวนแผ่น
//			  $numpic = $arr_1['pic']; // จำนวนรูป
//			  $count_y = count_checklist_kp7($rs[siteid],"Y","$rs[id]");// ตรวจสอบผ่าน
//			  $count_yn = count_checklist_kp7($rs[siteid],"YN","$rs[id]");// ตรวจสอบแล้วไม่ผ่าน
//			  $count_n = count_checklist_kp7($rs[siteid],"N","$rs[id]");// ค้างตรวจสอบ
//			  $count_impP = $count_y+$count_yn+$count_n ;// จำนวนทั้งหมด
			  
			  		$id_org = "$rs[id]";
				  //$arrN = CountCheckListKp7($rs[siteid],"$rs[id]");
				  $numpage = $rs['NumPage']; //  จำนวนแผ่น
				  $numpic = $rs['NumPic']; // จำนวนรูป
				  $count_y = $rs['NumPass'];// ตรวจสอบผ่าน
				  $count_yn = $rs['NumNoPass'];// ตรวจสอบแล้วไม่ผ่าน
				  $count_n = $rs['NumDisC'];// ค้างตรวจสอบ
				  $count_impP = $rs['NumAll'];// จำนวนทั้งหมด
				   $count_sexM=$rs['NumM'];
			     	$count_sexF=$rs['NumF'];
					$count_QL = $rs['NumQL'];
					 $count_NumNoMain = $rs['NumNoMain'];
				 
			  
			  $getlink = "main_report_detail.php?action=&lv=2&xsiteid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id";
				  if($count_impP > 0){
					  	$xalink = "<a href='$getlink'>$rs[office]</a>";
				  }else{
				  		$xalink = "$rs[office]";
				  }

			  }
			 
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <? if($lv == "1"){?>
          <td align="center"><?=$id_org?></td>
          <? } //end ?>
        <td align="left"><?=$xalink?></td>
        <td align="center"><?=number_format($count_impP)?></td>
        <td align="center"><?=number_format($count_QL);?></td>
        <td align="center"><?=number_format($numpage)?></td>
        <td align="center"><?=number_format($count_n)?></td>
        <td align="center"><?=number_format($count_y);?></td>
        <td align="center"><?=number_format($count_NumNoMain);?></td>
        <td align="center"><?=number_format($count_yn)?></td>
        <td align="center"><?=number_format($numpic)?></td>
        </tr>
		<?
			$sum_page_all += $numpage;
			$sum_pic_all += $numpic;
			$sum_imp_all += $count_impP;
			$sum_y_all += $count_y;
			$sum_n_all += $count_n;
			$sum_yn_all += $count_yn;
			$sum_yn_all_M += $count_sexM;
			$sum_yn_all_F += $count_sexF;
			$sum_QL_all += $count_QL;
			$sum_NumNoMain_all += $count_NumNoMain;
			
			}//end while($rs_m = mysql_fetch_assoc($result_main)){
		?>
</tbody>
      <tfoot>
      <tr class="txthead">
        <td colspan="<?=$xcolf?>" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_imp_all);?>
        </strong></td>
          <td align="center" bgcolor="#CCCCCC"><?=number_format($sum_QL_all);?></td>
        <td align="center" bgcolor="#CCCCCC"><?=number_format($sum_page_all);?></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_n_all);?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_y_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_NumNoMain_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_yn_all);?>
        </strong></td>
         <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_pic_all);?>
        </strong></td
        ></tr>
		 </tfoot>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"><em>หมายเหตุ <font color="#FF0000">*</font> หมายถึงเขตที่ตรวจสอบจำนวนถูกต้องแล้ว</em></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var TSort_Data = new Array ('my_table', '', 'h','g', 'g','g','g','g','g','g','g','g','g');
var TSort_Classes = new Array ('row1', 'row2');
tsRegister();
// -->
</script> 

</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>