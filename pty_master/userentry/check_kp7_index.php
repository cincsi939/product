<?
session_start();
include("../../config/conndb_nonsession.inc.php");
include("checklist.inc.php");
if($_SESSION['session_username'] == ""){
	echo "<h3>ขาดการติดต่อกับ server นานเกินไปกรุณา login เข้าสู่ระบบใหม่</h3>";
	header("Location: login.php");
	die;
}

set_time_limit(0);

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

</head>
<body>
<?
	
	
	$arr1 = show_val_exsum($lv,$xsiteid,$schoolid);
	
?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
   <td align="center">
<?  if  ($lv < 1 ){   ?> 
   
   <table width="500" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
         <tr>
           <td colspan="2" align="center" bgcolor="#CAD5FF"><strong>รายงานการตรวจสอบเอกสารต้นฉบับ</strong></td>
           </tr>
         <tr>
           <td width="55%" align="center" bgcolor="#CAD5FF"><strong>รายการ</strong></td>
           <td width="45%" align="center" bgcolor="#CAD5FF"><strong>จำนวน(คน)</strong></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;ค้างตรวจสอบ</strong></td>
           <td align="center" bgcolor="#FFFFFF"><?=number_format($arr1['numN']);?></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;ตรวจสอบแล้วสมบูรณ์</strong></td>
           <td align="center" bgcolor="#FFFFFF"><?=number_format($arr1['numY1']);?></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;ตรวจสอบแล้วไม่สมบูรณ์</strong></td>
           <td align="center" bgcolor="#FFFFFF"><?  if($lv == "1"){ if($arr1['numY0'] > 0){ echo "<a href='report_problem.php?sentsecid=$xsiteid&lv=1' target='_blank'>".number_format($arr1['numY0'])."</a>";}else{ echo "0";}}else{ if($arr1['numY0'] > 0){ echo "<a href='report_problem.php?sentsecid=$sentsecid&lv=' target='_blank'>".number_format($arr1['numY0'])."</a>";}else{ echo "0";} }?></td>
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
   </table>
<? }elseif  ($lv == 1 ){   ?>    
  <? 
  $sql2 = " SELECT time_update FROM tbl_checklist_kp7 where  time_update is not null  ORDER BY  time_update ASC  LIMIT 1 ";
  $result2 = mysql_db_query($dbname_temp , $sql2 ) ;
  $xrs = mysql_fetch_assoc($result2) ; 
  $thtimemin =get_dateThai($xrs[time_update], 1 ) ; 
  
  $sql2 = " SELECT time_update FROM tbl_checklist_kp7 where  time_update is not null  ORDER BY  time_update DESC  LIMIT 1 ";
  $result2 = mysql_db_query($dbname_temp , $sql2 ) ;
  $xrs = mysql_fetch_assoc($result2) ; 
  echo mysql_error() ; 
  echo " <br><br>   $timemax    ";
  $thtimemax =get_dateThai($xrs[time_update], 1 ) ; 
  ?>
     <table width="700" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
       <tr>
         <td bgcolor="#000000"><table width="100%" border="0" cellpadding="3" cellspacing="1" bordercolor="#000000">
           <tr>
             <td colspan="7" align="left" bgcolor="#CAD5FF"><strong>ผลการตรวจสอบเอกสารทะเบียนประวัติ กพ.7 อิเล็กทรอนิกส์  <? show_area($xsiteid) ?></strong></td>
           </tr>
           <tr>
             <td colspan="5" align="left" bgcolor="#CAD5FF"><strong>เข้าพื้นที่ดำเนินการตั้งแต่วันที่  
               <?=$thtimemin?> 
               ถึงวันที่  
               <?=$thtimemax?>
             </strong></td>
             <td colspan="2" align="center" bgcolor="#CAD5FF"><strong>จำนวนเอกสาร<br>
               แสกนไม่ตรง</strong></td>
             </tr>
           <? if($arr1['PageNoMath'] > 0){ $xbg = "#FF0000";}else{ $xbg = "#FFFFFF";}?>
           <tr>
             <td width="37%" align="left" bgcolor="#FFFFFF">จำนวนข้าราชการครูและบุคลากรทางการศึกษา </td>
             <td width="11%" bgcolor="#EEEEEE"><strong>
               <? if($arr1['numall'] > 0){ echo "<a href='report_problem.php?xtype=all&sentsecid=$xsiteid&lv=1' target='_blank'>".number_format($arr1['numall'])."</a>";}else{ echo "0";}?>
             </strong></td>
             <td width="12%" bgcolor="#FFFFFF">คน</td>
             <td width="11%" bgcolor="#EEEEEE"><?=number_format($arr1['numpage']);?></td>
             <td width="11%" bgcolor="#FFFFFF">แผ่น</td>
             <td width="9%" bgcolor="<?=$xbg?>" align="center"><strong><? if($arr1['PageNoMath'] > 0){ echo "<a href='report_page_no_math.php?sentsecid=$xsiteid' target='_blank'>".number_format($arr1['PageNoMath'])."</a>";}else{ echo "0";}?></strong></td>
             <td width="9%" bgcolor="<?=$xbg?>"><strong>คน</strong></td>
             </tr>
           <tr>
             <td height="22" align="left" bgcolor="#FFFFFF">ตรวจสอบเอกสารแล้ว</td>
             <td bgcolor="#EEEEEE"><? $allstaff = ($arr1['numY1']) + ($arr1['numY0'])     ;
			 if($allstaff > 0){ echo "<a href='report_problem.php?xtype=checkall&sentsecid=$xsiteid&lv=1' target='_blank'>".number_format($allstaff)."</a>";}else{ echo "0";}
			 ?> </td>
             <td bgcolor="#FFFFFF">คน</td>
             <td bgcolor="#EEEEEE"><strong>
			 <?  $allnumYpage =  $arr1['numY0page'] + $arr1['numY1page'] ; ?>
             <?=number_format($allnumYpage);?>
             </strong></td>
             <td bgcolor="#FFFFFF">แผ่น</td>
             <td bgcolor="#FFFFFF">&nbsp;</td>
             <td bgcolor="#FFFFFF">&nbsp;</td>
             </tr>
           <tr>
             <td align="left" bgcolor="#FFFFFF"> - สมบูรณ์</td>
             <td bgcolor="#EEEEEE"><? if($arr1['numY1'] > 0){ echo "<a href='report_problem.php?xtype=complate&sentsecid=$xsiteid&lv=1' target='_blank'>".number_format($arr1['numY1'])."</a>";}else{ echo "0";}?></td>
             <td bgcolor="#FFFFFF">คน</td>
             <td bgcolor="#EEEEEE"><strong>
                <?=number_format($arr1['numY1page']);?>
             </strong></td>
             <td bgcolor="#FFFFFF">แผ่น</td>
             <td bgcolor="#FFFFFF">&nbsp;</td>
             <td bgcolor="#FFFFFF">&nbsp;</td>
             </tr>
           <tr>
             <td align="left" bgcolor="#FFFFFF"> - ไม่สมบูรณ์</td>
             <td bgcolor="#EEEEEE"><?  if($lv == "1"){ if($arr1['numY0'] > 0){ echo "<a href='report_problem.php?sentsecid=$xsiteid&lv=1' target='_blank'>".number_format($arr1['numY0'])."</a>";}else{ echo "0";}}else{ if($arr1['numY0'] > 0){ echo "<a href='report_problem.php?sentsecid=$sentsecid&lv=' target='_blank'>".number_format($arr1['numY0'])."</a>";}else{ echo "0";} }?></td>
             <td bgcolor="#FFFFFF">คน</td>
             <td bgcolor="#EEEEEE"><strong>
               <?=number_format($arr1['numY0page']);?>
                
             </strong></td>
             <td bgcolor="#FFFFFF">แผ่น</td>
             <td bgcolor="#FFFFFF">&nbsp;</td>
             <td bgcolor="#FFFFFF">&nbsp;</td>
             </tr>
           <tr>
             <td align="left" bgcolor="#FFFFFF">อยู่ระหว่างการตรวจสอบ</td>
             <td bgcolor="#EEEEEE"><? if($arr1['numN'] > 0){ echo "<a href='report_problem.php?xtype=wait&sentsecid=$xsiteid&lv=1' target='_blank'>".number_format($arr1['numN'])."</a>";}else{ echo "0";}?></a></td>
             <td bgcolor="#FFFFFF">คน</td>
             <td bgcolor="#FFFFFF">&nbsp;</td>
             <td bgcolor="#FFFFFF">&nbsp;</td>
             <td bgcolor="#FFFFFF">&nbsp;</td>
             <td bgcolor="#FFFFFF">&nbsp;</td>
             </tr>
             <?
             	$sql_school_num = "SELECT count(schoolid) as num_school FROM tbl_checklist_kp7 WHERE  (siteid = '$xsiteid') and (schoolid='0' or schoolid IS NULL or schoolid ='') ";
				$result_school_num = mysql_db_query($dbname_temp,$sql_school_num);
				$rs_school_num = mysql_fetch_assoc($result_school_num);
				$NoSchool = $rs_school_num[num_school];
				if($NoSchool > 0){
						$bg1 = "#FF0000";
				}else{
						$bg1 = "#FFFFFF";	
				}
			 ?>
           <tr>
             <td align="left" bgcolor="#FFFFFF">จำนวนรูปภาพ</td>
             <td bgcolor="#EEEEEE"><?=number_format($arr1['numpic']);?></td>
             <td bgcolor="#FFFFFF">รูป</td>
             <td colspan="2" align="right" bgcolor="<?=$bg1?>"><strong>ไม่มีสังกัด :</strong></td>
             <td align="center" bgcolor="<?=$bg1?>">
             <? if($NoSchool > 0){ echo "<a href='report_page_no_math.php?action=NOSCHOOL&xsiteid=$xsiteid&sentsecid=$xsiteid' target='_blank'>".number_format($NoSchool)."</a>";}else{ echo "0";}?>
             </td>
             <td bgcolor="<?=$bg1?>"><strong>คน</strong></td>
             </tr>
         </table></td>
       </tr>
     </table><br>

<? } ######### END   }else{ if  ($lv == 1 ){   ?>    	 
	 </td>
 </tr>
 <tr>
    <td align="left">&nbsp;<strong><? if($lv == 1){ echo "<a href='?lv='>แสดงข้อมูลภาพรวม</a> => ".show_area($xsiteid);}?></strong></td>
  </tr>
  <? if($lv == ""){ $xtitle = "สำนักงานเขตพื้นที่การศึกษา"; $xcolh = "8"; $xcolf = "2";}else{ $xtitle = "หน่วยงาน"; $xcolh = "9"; $xcolf = "3";}
  
  ?>
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3" id="my_table">
	<thead> 
      <tr align="center">
       <td colspan="<?=$xcolh?>" align="center" bgcolor="#A8B9FF"><strong>รายงานการตรวจสอบเอกสาร ก.พ. 7 ต้นฉบับ </strong></td>
        </tr>
      <tr>
        <th width="4%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>ลำดับ</strong><br>
<?  if($lv == "1"){if(CheckLockArea($xsiteid) > 0){ echo "<em>Lock</em>"; }else{?><input type="button" name="btnA" value="เพิ่มข้อมูล" onClick="location.href='form_manage_checklist.php?action=ADD&sentsecid=<?=$xsiteid?>&extra=1'" style="cursor:hand"><? }  } //end //end <? if(CheckLockArea($sentsecid) > 0){ ?></th>
		<? if($lv == "1"){?>
		<th width="8%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>รหัสหน่วยงาน</strong></th>
		<? } //end ?>
        <th width="30%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong><?=$xtitle?></strong></th>
        <th width="10%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>จำนวน<br>
          ทั้งหมด(คน)</strong></th>
        <th width="10%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>จำนวนหน้า<br>
          เอกสาร(แผ่น)</strong></th>
        <td colspan="3" align="center" bgcolor="#A8B9FF"><strong>สถานะการตรวจสอบ</strong></td>
        <th width="10%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>จำนวนรูป(รูป)</strong></th>
        </tr>
      <tr>
        <th width="9%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ค้างตรวจ(คน)</strong></th>
        <th colspan="2" align="center" bgcolor="#A8B9FF"><strong>ตรวจสอบแล้ว(คน)</strong></th>
        </tr>
      <tr>
        <th width="9%" align="center" bgcolor="#A8B9FF"><strong>สมบูรณ์</strong></th>
        <th width="10%" align="center" bgcolor="#A8B9FF"><strong>ไม่สมบูรณ์</strong></th>
        </tr> 
	</thead>    
	<tbody>   
		<?
		if($lv == ""){// ข้อมูลรายเขต
			$sql = "SELECT * FROM eduarea WHERE status_area53 ='1' order by secname ASC";
			$result = mysql_db_query($dbnamemaster,$sql);
			//$rs = mysql_fetch_assoc($result);
		}else if($lv == "1"){ // ข้อมูลรายโรง
				//$sql = "SELECT CAST(id as SIGNED) as id, siteid,office FROM allschool WHERE siteid='$xsiteid' order by id ASC, office ASC";
				//$result = mysql_db_query($dbnamemaster,$sql);
				##CAST(id as SIGNED) as id, 
$sql = "SELECT
CAST(CASE id 
WHEN 660184 THEN 9999991
WHEN 660194 THEN 9999992
WHEN 660408 THEN 9999993
WHEN 660419 THEN 9999994
ELSE id
END   as SIGNED) as id1,
id,
allschool.siteid,office,
Sum(if(status_file='1' AND status_check_file='YES',1,0 )) AS NumPass,
Sum(if(status_file='0' AND status_check_file='YES',1,0 )) AS NumNoPass,
Sum(if(status_file='0' AND status_check_file='NO' ,1,0)) AS NumDisC,
Sum(page_num) AS NumPage,
Sum(pic_num) AS NumPic,
Count(idcard) AS NumAll
FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7
Inner Join  ".DB_MASTER.".allschool ON  ".DB_CHECKLIST.".tbl_checklist_kp7.schoolid =  ".DB_MASTER.".allschool.id
WHERE
 ".DB_CHECKLIST.".tbl_checklist_kp7.siteid =  '$xsiteid'
GROUP BY
 ".DB_CHECKLIST.".tbl_checklist_kp7.schoolid
order by id1 ASC
";
//echo $sql;
$result = mysql_db_query($dbname_temp,$sql);
				
		}//end if($lv == ""){
		$count_y = 0;$count_yn=0;$count_n=0;$count_impP=0;
		
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			  if($lv == ""){
				  $temp_dis = CheckLockArea($rs[secid]);
				  $arrN = CountCheckListKp7($rs[secid],"");
				  $id_org = "$rs[secid]";
				  $numpage = $arrN['NumPage']; //  จำนวนแผ่น
				  $numpic = $arrN['NumPic']; // จำนวนรูป
				  $count_y = $arrN['NumPass'];// ตรวจสอบผ่าน
				  $count_yn = $arrN['NumNoPass'];// ตรวจสอบแล้วไม่ผ่าน
				  $count_n = $arrN['NumDisC'];// ค้างตรวจสอบ
				  $count_impP = $arrN['NumAll'];// จำนวนทั้งหมด
				  $getlink = "?action=&lv=1&xsiteid=$rs[secid]&schoolid=";
				  $lint_yn = "report_problem.php?lv=1&sentsecid=$rs[secid]&schoolid=";
				  if($temp_dis > 0){
					  	$xalink_sys  = "<font color='#FF0000'><b>*</b></font>";
				  }else{
					  	$xalink_sys = "";
				 }//end  if($temp_dis > 0){
					  if($count_impP > 0){
							$xalink = "<a href='$getlink'>$rs[secname]</a> $xalink_sys";
							
					  }else{
							$xalink = "$rs[secname]";	
					  }
				  
			  
			  }else if($lv == "1"){
				  $id_org = "$rs[id]";
				  //$arrN = CountCheckListKp7($rs[siteid],"$rs[id]");
				  $numpage = $rs['NumPage']; //  จำนวนแผ่น
				  $numpic = $rs['NumPic']; // จำนวนรูป
				  $count_y = $rs['NumPass'];// ตรวจสอบผ่าน
				  $count_yn = $rs['NumNoPass'];// ตรวจสอบแล้วไม่ผ่าน
				  $count_n = $rs['NumDisC'];// ค้างตรวจสอบ
				  $count_impP = $rs['NumAll'];// จำนวนทั้งหมด
				  $getlink = "check_kp7_area.php?action=&lv=2&xsiteid=$rs[siteid]&sentsecid=$rs[siteid]&schoolid=$rs[id]";
				  $lint_yn = "report_problem.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]";
				  if(CheckLockArea($rs[siteid]) > 0){
						$xalink_sys  = "<font color='#FF0000'><b>*</b></font>";
					}else{
						$xalink_sys = "";
					}
					  if($count_impP > 0){
							$xalink = "<a href='$getlink'>$rs[office]</a>$xalink_sys";
					  }else{
							$xalink = "$rs[office]";
					  }

			  }
			 ### เช็คเงื่อนไขการ loc เขต
			 
			 
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
		<? if($lv == "1"){?>
		<td align="center"><?=$id_org?></td>
		<? } //end ?>
        <td align="left"><?=$xalink?></td>
        <td align="center"><?=number_format($count_impP)?></td>
        <td align="center"><?=number_format($numpage)?></td>
        <td align="center"><?=number_format($count_n)?></td>
        <td align="center"><?=number_format($count_y);?></td>
        <td align="center"><? if($count_yn > 0){ echo "<a href='$lint_yn' target='_blank'>".number_format($count_yn)."</a>";}else{ echo "0";}?></td>
        <td align="center"><?=number_format($numpic)?></td>
        </tr>
		<?
			$sum_page_all += $numpage;
			$sum_pic_all += $numpic;
			$sum_imp_all += $count_impP;
			$sum_y_all += $count_y;
			$sum_n_all += $count_n;
			$sum_yn_all += $count_yn;
			
			}//end while($rs_m = mysql_fetch_assoc($result_main)){
		?>
</tbody>
 <tfoot>
      <tr class="txthead">
        <td colspan="<?=$xcolf?>" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_imp_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_page_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_n_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_y_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_yn_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_pic_all);?>
        </strong></td>
        </tr>
 </tfoot>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
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
