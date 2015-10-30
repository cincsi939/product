<?
session_start();
include("checklist2.inc.php");
$arrEduSchool = GetEduareaAllschool($profile_id);
$eduarea = $arrEduSchool['eduarea'];
$allschool = $arrEduSchool['allschool'];
$tbl_allschool = "edubkk_master.".$allschool;

if($_GET['profile_id'] == ""){
		$profile_id = 5;
}


function GetArraySchool($xsiteid){
	global $dbnamemaster;
	$sql  =  "SELECT id,office,prefix_name FROM allschool WHERE siteid='$xsiteid'";
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[id]] = $rs[prefix_name].$rs[office];
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end function GetArraySchool(){

function Getyy_profile($profile_id){
	global $dbname_temp;
	$sql = "SELECT
(year(profile_date)+543) as yy
FROM tbl_checklist_profile where profile_id='$profile_id'";	
 	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$rs = mysql_fetch_assoc($result);
	if($rs[yy] == "543"){
			$yy = date("Y")+543;
	}else{
			$yy = $rs[yy];	
	}//end if($rs[yy] == "543"){
		return $yy;
}//end function Getyy_profile($profile_id){

function Thai_dateS1($temp){
				$shortmonth = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
				if($temp != "0000-00-00" and $temp != ""){
					$x = explode("-",$temp);
					return intval($x[2])." ".$shortmonth[intval($x[1])]." ".($x[0]+543);
				}else{
					return "";	
				}
				
}// function Thai_dateS1($temp){

function CountStatusDocDiffAssgin($profile_id){
	global $dbname_temp;
	$sql = "SELECT
t1.siteid,
Count(t1.idcard) as numall,
Sum(if(t1.page_upload IS NULL or t1.page_upload='' or t1.page_upload < 1,1,0)) as file_kp7,
sum(if(t1.pic_num > 0 and t1.pic_num IS NOT NULL and t1.pic_num <>t1.pic_upload,1,0 )) as pic_kp7,
sum(if((!(((status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0') OR 
(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0')))),1,0)) as status_kp7

FROM  tbl_checklist_kp7  as t1
where t1.profile_id='$profile_id'
group by t1.siteid";	
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]]['numall'] = $rs[numall];
		$arr[$rs[siteid]]['file_kp7'] = $rs[file_kp7];
		$arr[$rs[siteid]]['pic_kp7'] = $rs[pic_kp7];
		$arr[$rs[siteid]]['status_kp7'] = $rs[status_kp7];	
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}

######  function ตรวจสอบการมอบหมายงาน
function GetNumAssign($profile_id){
	global $dbname_temp;
	$sql = "SELECT
t1.siteid,
Count(distinct t1.idcard) AS numall
FROM
edubkk_checklist.tbl_checklist_kp7 AS t1
Inner Join callcenter_entry.tbl_assign_key as t2 ON t1.idcard = t2.idcard AND t1.profile_id = t2.profile_id
WHERE
t1.profile_id =  '$profile_id'
GROUP BY
t1.siteid";	
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[$rs[siteid]]] = $rs[numall];
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end function GetNumAssign($profile_id){
?>
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
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

</head>
<script src="../../common/jquery.js"></script>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>
<body>
<?
	if($action == ""){
?>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="2" align="left" bgcolor="#D2D2D2"><strong>เลือกกลุ่มรายการข้อมูล</strong></td>
          </tr>
        <tr>
          <td width="12%" align="right" bgcolor="#FFFFFF"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td bgcolor="#FFFFFF">
            <select name="profile_id" id="profile_id" onChange="gotourl(this)">
              <option value="">เลือกโฟล์ไฟล์</option>
              <?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
              <option value="?profile_id=<?=$rsp[profile_id]?>&action=<?=$action?>" <?=$sel?>><?=$rsp[profilename]?></option>
              <?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
              </select> 
            
          </td>
          </tr>
      
      </table>
   </td>
  </tr>
</table>
 </form>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
       <tr>
         <td colspan="8" align="center" bgcolor="#D2D2D2"><strong>รายงานเอกสารค้างมอบหมายงาน <?=ShowProfile_name($profile_id);?></strong></td>
        </tr>
       <tr>
         <td width="4%" rowspan="2" align="center" bgcolor="#D2D2D2"><strong>ลำดับ</strong></td>
         <td width="31%" rowspan="2" align="center" bgcolor="#D2D2D2"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
         <td width="12%" rowspan="2" align="center" bgcolor="#D2D2D2"><strong>จำนวนบุคลากรทั้งหมด(คน)</strong></td>
         <td width="12%" rowspan="2" align="center" bgcolor="#D2D2D2"><strong>จำนวนมอบหมายงาน(คน)</strong></td>
         <td colspan="3" align="center" bgcolor="#D2D2D2"><strong>สาเหตุที่ไม่สามารถมอบหมายงานได้</strong></td>
         <td width="9%" rowspan="2" align="center" bgcolor="#D2D2D2"><strong>จำนวนค้าง<br>
          มอบหมายงาน(คน)</strong></td>
       </tr>
       <tr>
         <td width="10%" align="center" bgcolor="#D2D2D2"><strong>ไม่มีไฟล์ ก.พ.7 <br>
          ต้นฉบับ(คน)</strong></td>
         <td width="10%" align="center" bgcolor="#D2D2D2"><strong>ไม่มีรูปภาพ <br>
          ก.พ.7(คน)</strong></td>
         <td width="12%" align="center" bgcolor="#D2D2D2"><strong>สถานะเอกสารที่ไม่สามารถ<br>
          มอบหมายงานได้(คน)</strong></td>
        </tr>
        <?
        	$sql = "SELECT t1.secid as siteid, t1.secname,
if(substring(t1.secid,1,1) ='0',cast(secid as SIGNED),9999) as idsite
FROM
$eduarea as t1
Inner Join eduarea_config as t2 ON t1.secid = t2.site
WHERE
t2.group_type =  'keydata' AND
t2.profile_id =  '$profile_id' 
order by idsite, t1.secname  ASC";
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$i=0;
	$arr1 = CountStatusDocDiffAssgin($profile_id);
	$arr2 = GetNumAssign($profile_id);

	while($rs = mysql_fetch_assoc($result)){
		 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		 $numall = $arr1[$rs[siteid]]['numall']; // จำนวนบุคลากรทั้งหมด
		  $numkp7 = $arr1[$rs[siteid]]['file_kp7']; // จำนวนบุคลากรที่ยังไม่ได้นำเข้าไฟล์ kp7
		  $numpic =  $arr1[$rs[siteid]]['pic_kp7']; // จำนวนบุคลากรที่ยังไม่ได้นำเข้ารูปภาพ
		  $numstatus = $arr1[$rs[siteid]]['status_kp7']; // จำนวนบุคลากรที่สถานะเอกสรไม่พร้อมมอบหมายงาน
		  $nun_assign = $arr2[$rs[siteid]]; // จำนวนบุคลากรที่มอบหมายงานไปแล้ว
		  $numdiff_assign = $numall-$nun_assign;// จำนวนบุคลการที่ค้างมอบหมายงาน
		?>
       <tr bgcolor="<?=$bg?>">
         <td align="center"><?=$i?></td>
         <td align="left"><?=str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname])?></td>
         <td align="center"><?=number_format($numall)?></td>
         <td align="center"><?=number_format($nun_assign)?></td>
         <td align="center"><? if($numkp7 > 0){ echo "<a href='?action=view&xsiteid=$rs[siteid]&profile_id=$profile_id&xtype=kp7'>".number_format($numkp7)."</a>";}else{ echo "0";}?></td>
         <td align="center"><? if($numpic > 0){ echo "<a href='?action=view&xsiteid=$rs[siteid]&profile_id=$profile_id&xtype=pic'>".number_format($numpic)."</a>";}else{ echo "0";}?></td>
         <td align="center"><? if($numstatus > 0){ echo "<a href='?action=view&xsiteid=$rs[siteid]&profile_id=$profile_id&xtype=doc'>".number_format($numstatus)."</a>";}else{ echo "0";}?></td>
         <td align="center"><? if($numdiff_assign > 0){ echo "<a href='?action=view&xsiteid=$rs[siteid]&profile_id=$profile_id&xtype=diffassign'>".number_format($numdiff_assign)."</a>";}else{ echo "0";}?></td>
       </tr>
       <?
	   		$sum1 += $numall;
			$sum2 += $nun_assign;
			$sum3 += $numkp7;
			$sum4 += $numpic;
			$sum5 += $numstatus;
			$sum6 += $numdiff_assign;
	   
	   		$numall = 0;
		  	$numkp7 =  0;
		  	$numpic =  0;
		  	$numstatus =  0;
		  	$nun_assign = 0;
		  	$numdiff_assign = 0;

	}//end 	while($rs = mysql_fetch_assoc()){
	   ?>
        <tr bgcolor="#D2D2D2">
         <td colspan="2" align="center"><strong>รวม : </strong></td>
         <td align="center"><strong>
           <?=number_format($sum1)?>
         </strong></td>
         <td align="center"><strong>
           <?=number_format($sum2)?>
         </strong></td>
         <td align="center" ><strong>
           <?=number_format($sum3)?>
         </strong></td>
         <td align="center" ><strong>
           <?=number_format($sum4)?>
         </strong></td>
         <td align="center" ><strong>
           <?=number_format($sum5)?>
         </strong></td>
         <td align="center" ><strong>
           <?=number_format($sum6)?>
         </strong></td>
       </tr>

     </table></td>
  </tr>
</table>
<?
	}else if($action == "view"){
		if($xtype == "kp7"){
			$xtitle = "รายการข้อมูลที่ไม่มีไฟล์ ก.พ.7 ต้นฉบับ ".show_area($xsiteid);
			$con1 = " AND (t1.page_upload IS NULL or t1.page_upload='' or t1.page_upload < 1)";
			$problem1 = "ไม่มีไฟล์ ก.พ.7 ต้นฉบับ";
				
		}else if($xtype == "pic"){
			$xtitle = "รายการข้อมูลที่ยังไม่ได้ upload รูปภาพ ".show_area($xsiteid);
			$con1 = " AND (t1.pic_num > 0 and t1.pic_num IS NOT NULL and t1.pic_num <>t1.pic_upload)";
			$problem1 = "ไม่มีรูปภาพ ก.พ.7";
		}else if($xtype == "doc"){
			$xtitle = "รายการข้อมูลที่สถานะเอกสารไม่สมบูรณ์ ".show_area($xsiteid);
			$con1 = " AND (!(((status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0') OR 
(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0'))))";
			$problem1 = "เอกสารไม่สมบูรณ์";
		}else if($xtype == "diffassign"){
			$xtitle = "รายการข้อมูลที่ค้างมอบหมายงานคีย์ข้อมูล ก.พ.7 ".show_area($xsiteid);
				
		}
		
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" align="left" bgcolor="#D2D2D2"><a href="?action=&profile_id=<?=$profile_id?>">ย้อนกลับ</a> || <strong><?=$xtitle?></strong></td>
        </tr>

      <tr>
        <td width="3%" align="center" bgcolor="#D2D2D2"><strong>ลำดับ</strong></td>
        <td width="14%" align="center" bgcolor="#D2D2D2"><strong>เลขบัตรประชาชน</strong></td>
        <td width="16%" align="center" bgcolor="#D2D2D2"><strong>ชื่อ นามสกุล</strong></td>
        <td width="19%" align="center" bgcolor="#D2D2D2"><strong>ตำแหน่ง</strong></td>
        <td width="16%" align="center" bgcolor="#D2D2D2"><strong>หน่วยงานสังกัด</strong></td>
        <td width="7%" align="center" bgcolor="#D2D2D2"><strong>อายุราชการ</strong></td>
        <td width="22%" align="center" bgcolor="#D2D2D2"><strong>ปัญหาการ assign</strong></td>
        <td width="3%" align="center" bgcolor="#D2D2D2">&nbsp;</td>
        </tr>
                <?
		$year1 = Getyy_profile($profile_id)."-09-30"; 
		$arrschool = GetArraySchool($xsiteid);
	 if($xtype != "diffassign"){
		$sql = "SELECT
t1.idcard,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t1.begindate,
t1.position_now,
t1.schoolid,
FLOOR((TIMESTAMPDIFF(MONTH,t1.begindate,'$year1')/12)) as age_gov,
$problem1 as problem
FROM  tbl_checklist_kp7 as t1 WHERE t1.profile_id='$profile_id' and t1.siteid='$xsiteid' $con1";
	}else{

$sql = "SELECT
t1.idcard,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t1.begindate,
t1.position_now,
t1.schoolid,
FLOOR((TIMESTAMPDIFF(MONTH,t1.begindate,'$year1')/12)) as age_gov,
if(t1.page_upload IS NULL or t1.page_upload='' or t1.page_upload < 1,1,0) as prob1,
if(t1.pic_num > 0 and t1.pic_num IS NOT NULL and t1.pic_num <>t1.pic_upload,1,0) as prob2,
if(!(((status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0') OR 
(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0'))),1,0) as prob3

FROM  tbl_checklist_kp7 as t1 LEFT Join callcenter_entry.tbl_assign_key as t2 ON t1.idcard=t2.idcard and t1.siteid=t2.siteid and t1.profile_id=t2.profile_id WHERE t1.profile_id='$profile_id' and t1.siteid='$xsiteid' and t2.idcard IS NULL";
	}//end  if($xtype != "diffassign"){
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
		 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}

			$org = $arrschool[$rs[schoolid]];	 	

			
		 $filekp7 = "../../../".PATH_KP7_FILE."/$rs[siteid]/$rs[idcard].pdf";
		 if(is_file($filekp7)){
				 $link_kp7 = "<a href=\"../../../".PATH_KP7_FILE."/$rs[siteid]/$rs[idcard].pdf\" target=\"_blank\"><img src=\"../../images_sys/gnome-mime-application-pdf.png\" alt=\"เอกสาร ก.พ.7 ต้นฉบับ\" width=\"16\" height=\"16\" border=\"0\"></a>";
		}else{
				$link_kp7 ="";	
		}

		 
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
        <td align="left"><?=$rs[position_now]?></td>
        <td align="left"><?=$org?></td>
        <td align="center"><?=$rs[age_gov]?></td>
        <td align="left"><?
        	if($rs[problem] != ""){
				echo $rs[problem];	
			}else{
					if($rs[prob1] == "1"){
							echo "- ไม่มีไฟล์ ก.พ.7 ต้นฉบับ<br>";
					}	
					if($rs[prob2] == "2"){
							echo "- ไม่มีรูปภาพ ก.พ.7<br>";
					}
					if($rs[prob3] == "3"){
							echo "- เอกสารไม่สมบูรณ์<br>";
					}
			}
		?></td>
        <td align="center"><?=$link_kp7?></td>
      </tr>
      <?
	}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
</table>
<?
	}//end }else if($action == "view"){
?>
</body>
</html>
