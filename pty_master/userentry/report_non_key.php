<?
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
	## Modified Detail :		รายงานการบันทึกข้อมูล
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
include "epm.inc.php";
include("function_assign.php");

function Datediff($datefrom,$dateto){
         $startDate = strtotime($datefrom);
         $lastDate = strtotime($dateto);
        $differnce = $startDate - $lastDate;
        $differnce = ($differnce / (60*60*24)); //กรณืที่ต้องการให้ return ค่าเป็นวันนะครับ
        return $differnce;
      } // end function Datediff($datefrom,$dateto){

//$alert_file = 50;
$temp_d = "2009-06-01";
$temp_d1 = "2009-08-31";
$date_total = Datediff($temp_d1,$temp_d);
$temp_dc = date("Y-m-d");
$date_total_c = Datediff($temp_dc,$temp_d);

function show_eduarea($secid){
	global $dbnamemaster;
	$sql_edu = "SELECT secname FROM eduarea WHERE secid='$secid'";
	$result_edu = mysql_db_query($dbnamemaster,$sql_edu);
	$rs_e = mysql_fetch_assoc($result_edu);
	$xarea = str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs_e[secname]);
	return $xarea;
}

##################  ข้อมูลของคนที่ค้างบันทึกข้อมูล
$year1 = (date("Y")+543)."-09-30";
$sql_main = "SELECT  ".DB_CHECKLIST.".tbl_check_data.idcard,  ".DB_CHECKLIST.".tbl_check_data.prename_th,  ".DB_CHECKLIST.".tbl_check_data.name_th,
 ".DB_CHECKLIST.".tbl_check_data.surname_th
, ".DB_MASTER.".view_general.schoolname, 
 ".DB_CHECKLIST.".tbl_check_data.secid, 
 ".DB_MASTER.".view_general.begindate,
(TIMESTAMPDIFF(MONTH, ".DB_MASTER.".view_general.begindate,'$year1')/12) as age_gov
 FROM  ".DB_CHECKLIST.".tbl_check_data
Inner Join ".DB_USERENTRY.".tbl_assign_key ON  ".DB_CHECKLIST.".tbl_check_data.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard
Inner Join  ".DB_MASTER.".view_general ON  ".DB_CHECKLIST.".tbl_check_data.idcard =  ".DB_MASTER.".view_general.CZ_ID
WHERE ".DB_USERENTRY.".tbl_assign_key.approve <>  '2'";
/*$sql_main = "SELECT tbl_check_data.idcard, tbl_check_data.prename_th, tbl_check_data.name_th, tbl_check_data.surname_th, tbl_check_data.begindate,
tbl_check_data.position_now, tbl_check_data.schoolname, tbl_check_data.secid, tbl_assign_key.idcard, tbl_assign_key.approve, (TIMESTAMPDIFF(MONTH,begindate,'$year1')/12) as age_gov FROM
tbl_check_data Inner Join tbl_assign_key ON tbl_check_data.idcard = tbl_assign_key.idcard WHERE tbl_assign_key.approve <> '2'";
*/
$result_main = mysql_db_query(DB_USERENTRY,$sql_main);
while($rs_m = mysql_fetch_assoc($result_main)){
	$fullname[$rs_m[idcard]] = "$rs_m[prename_th]$rs_m[name_th] $rs_m[surname_th]";
	$schoolname[$rs_m[idcard]] = show_eduarea($rs_m[secid])."/".$rs_m[schoolname];
	$age_gov[$rs_m[idcard]] = floor($rs_m[age_gov]);
	$arr_begindate[$rs_m[idcard]] = $rs_m[begindate];
}

//$fullname[1234567890] = "fdsfdsfdsfdsf";
//$schoolname[1234567890] = "sdfdsfdsfdsfds";
//$age_gov[1234567890] = 60;
################  end 

/*$sql1 = "SELECT   ".DB_CHECKLIST.".tbl_check_data.idcard  FROM   ".DB_CHECKLIST.".tbl_check_data";
$result1 = mysql_db_query("edubkk_checklist",$sql1);
while($rs1 = mysql_fetch_assoc($result1)){
		$arr_idcard1[$rs1[idcard]] = $rs1[idcard];
}

$sql2 = "SELECT  ".DB_CHECKLIST.".tbl_check_data.idcard FROM   ".DB_CHECKLIST.".tbl_check_data INNER JOIN ".DB_USERENTRY.".tbl_assign_key ON
 ".DB_CHECKLIST.".tbl_check_data.idcard=edubkk_userentry.tbl_assign_key.idcard";
$result2 = mysql_db_query("edubkk_checklist",$sql2);
while($rs2 = mysql_fetch_assoc($result2)){
	$arr_idcard2[$rs2[idcard]] = $rs2[idcard];
}



$result_idcard = array_diff_assoc($arr_idcard1, $arr_idcard2);
echo  count($result_idcard);
echo "<pre>";
print_r($result_idcard);*/



$sql_m1 = "SELECT  idcard FROM tbl_assign_key GROUP BY idcard";
//echo $sql_m1;
$result_m1 = mysql_db_query(DB_USERENTRY,$sql_m1);
while($rs_m1 = mysql_fetch_assoc($result_m1)){
		if($in_id > "") $in_id .= ",";
		$in_id .= "'$rs_m1[idcard]'";
}

$year2 = (date("Y")+543)."-09-30";
$sql_m2 = "SELECT
 ".DB_CHECKLIST.".tbl_check_data.idcard,
 ".DB_CHECKLIST.".tbl_check_data.prename_th,
 ".DB_CHECKLIST.".tbl_check_data.name_th,
 ".DB_CHECKLIST.".tbl_check_data.surname_th,
 ".DB_CHECKLIST.".tbl_check_data.secid,
 ".DB_MASTER.".view_general.schoolname,
 ".DB_MASTER.".view_general.begindate,
(TIMESTAMPDIFF(MONTH, ".DB_MASTER.".view_general.begindate,'$year2')/12) as age_gov2
FROM
 ".DB_CHECKLIST.".tbl_check_data
Inner Join  ".DB_MASTER.".view_general ON  ".DB_CHECKLIST.".tbl_check_data.idcard =  ".DB_MASTER.".view_general.CZ_ID
WHERE  ".DB_CHECKLIST.".tbl_check_data.idcard NOT IN($in_id) AND  secid NOT LIKE '50%'
";
//$sql_m2 = "SELECT
// ".DB_CHECKLIST.".tbl_check_data.idcard,
// ".DB_CHECKLIST.".tbl_check_data.prename_th,
// ".DB_CHECKLIST.".tbl_check_data.name_th,
// ".DB_CHECKLIST.".tbl_check_data.surname_th,
// ".DB_CHECKLIST.".tbl_check_data.secid,
// ".DB_CHECKLIST.".tbl_check_data.schoolname,
//(TIMESTAMPDIFF(MONTH,begindate,'$year1')/12) as age_gov
//FROM
// ".DB_CHECKLIST.".tbl_check_data
//WHERE  ".DB_CHECKLIST.".tbl_check_data.idcard NOT IN($in_id)
//";

$result_m2 = mysql_db_query(DB_CHECKLIST,$sql_m2);
while($rs_m2 = mysql_fetch_assoc($result_m2)){
	$fullname[$rs_m2[idcard]] = "$rs_m2[prename_th]$rs_m2[name_th] $rs_m2[surname_th]";
	$schoolname[$rs_m2[idcard]] = show_eduarea($rs_m2[secid])."/".$rs_m2[schoolname];
	$age_gov[$rs_m2[idcard]] = floor($rs_m2[age_gov2]);
	$arr_begindate[$rs_m2[idcard]] = $rs_m2[begindate];
}



$sql_numall = "SELECT COUNT(secid) as num_all FROM tbl_check_data WHERE secid NOT LIKE '50%'";
$result_numall = mysql_db_query(DB_CHECKLIST,$sql_numall);
$rs_num = mysql_fetch_assoc($result_numall);

$num_all = $rs_num[num_all];
//if($num_all != ""){
//	$num_all = $num_all;
//}else{
//	$num_all = 23540;
//}
#########  จำนวนคนที่ค้างบันทึก
$count_dis = count($fullname);
#### อายุราชการเฉลี่ย
$temp_age = array_sum($age_gov);
$age_agv = number_format(($temp_age/$count_dis),2);



$img_asc = "<img src=\"../../images_sys/s_asc.png\" width=\"11\" height=\"9\" border='0'>";
$img_desc = "<img src=\"../../images_sys/s_desc.png\" width=\"11\" height=\"9\" border='0'>";
?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript">
function confirmDelete(delUrl) {
//  if (confirm("คุณแน่ใจที่จะลบข้อมูล cmss จริงหรือไม่")) {
//  window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
    //document.location = delUrl;
	//document.location =  
	window.open(delUrl,null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
 // }
}
</script>
</head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><table width="70%" border="0" cellspacing="1" cellpadding="1">
      <tr>
        <td bgcolor="#000000"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" bgcolor="#EFEFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="32%" align="right" bgcolor="#EFEFFF"><strong>จำนวนบุคลากรทั้งหมด</strong></td>
                  <td width="19%" align="center" bgcolor="#EFEFFF"><?=number_format($num_all)?></td>
                  <td width="10%" bgcolor="#EFEFFF"><strong>คน</strong></td>
                  <td width="39%" bgcolor="#EFEFFF">&nbsp;</td>
                </tr>
                <tr>
                  <td align="right" bgcolor="#EFEFFF"><strong>จำนวนบุคลากรที่ค้างบันทึก</strong></td>
                  <td align="center" bgcolor="#EFEFFF"><?=number_format($count_dis)?></td>
                  <td bgcolor="#EFEFFF"><strong>คน</strong></td>
                  <td bgcolor="#EFEFFF"><strong>คิดเป็นร้อยละ &nbsp;&nbsp;
                        <?=number_format(($count_dis*100)/$num_all,2)?>
                  </strong></td>
                </tr>
                <tr>
                  <td align="right" bgcolor="#EFEFFF"><strong>อายุราชการเฉลี่ย</strong></td>
                  <td align="center" bgcolor="#EFEFFF"><?=$age_agv?></td>
                  <td bgcolor="#EFEFFF"><strong>ปี</strong></td>
                  <td bgcolor="#EFEFFF">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="5" align="center" bgcolor="#A3B2CC"><strong>รายงานบุคลากรที่ค้างบันทึกข้อมูล</strong></td>
        </tr>
		<?
		if($sort_field == "schoolname"){
				if($sort_a1 == "asc"){
					$sort_a1 = "desc";
					$img_sort1 = $img_asc;
				}else{
					$sort_a1 = "asc";
					$img_sort1 = $img_desc;
				}
		}else if($sort_field == "age_gov"){
				if($sort_a == "asc"){
					$sort_a = "desc";
					$img_sort = $img_asc;
				}else{
					$sort_a = "asc";
					$img_sort = $img_desc;
				}
		}// end 		if($sort_field == "schoolname"){
		
		?>
      <tr>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="18%" align="center" bgcolor="#A3B2CC"><strong>รหัสบัตรประชาชน</strong></td>
        <td width="22%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - นามสกุล </strong></td>
        <td width="40%" align="center" bgcolor="#A3B2CC"><strong><a href="?sort_field=schoolname&sort_a1=<?=$sort_a1?>">หน่วยงาน<?=$img_sort1?></a></strong></td>
        <td width="15%" align="center" bgcolor="#A3B2CC"><strong><a href="?sort_field=age_gov&sort_a=<?=$sort_a?>">อายุราชการ<?=$img_sort?></a></strong></td>
      </tr>
	  <?
	  	if($sort_field == "schoolname"){
				if($sort_a1 == "asc"){
					arsort(${'schoolname'}); // จากมากไปหาน้อย
				}else{
					asort(${'schoolname'}); // เรียง array จากน้อยไปหามาก
				}
			 $foreach_arr = ${'schoolname'};
			 
		}else if($sort_field == "age_gov"){
			if($sort_a == "asc"){ 
				arsort(${'age_gov'}); // เรียงจากมากไปหาน้อย
			}else{
				asort(${'age_gov'}); // เรียงจากน้อยไปหามาก
			}
			$foreach_arr = ${'age_gov'};
		}else{ // กรณีไม่เรียงลำดับ
			$foreach_arr = ${'age_gov'};
			asort($foreach_arr);
		}

	  	$i=0;

	  	foreach($foreach_arr as $key => $val){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
			$show_school = $schoolname[$key];
			$show_age = $age_gov[$key];
			if($show_age < 1){
				$show_age = 1;
			}else{
				$show_age = $show_age;
			}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$key?></td>
        <td align="left"><?=$fullname[$key]?></td>
        <td align="left"><?=$show_school?></td>
        <td align="center"><?=$show_age?>   <!--[<?//=$arr_begindate[$key]?>]--></td>
      </tr>
	  
	  <?
	  
	  	}//end 	  	foreach($fullname as $key => $val){
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
</table>
</BODY>
</HTML>
