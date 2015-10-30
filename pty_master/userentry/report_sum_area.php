<?
session_start();
/*****************************************************************************
Function		: รายงานสรุปภาพรวมการคีย์ข้อมูลในเขตพื้นที่
Version			: 1.0
Last Modified	: 25/12/2551
Changes		:

*****************************************************************************/
include "epm.inc.php";
set_time_limit(0);
$dbcall =DB_USERENTRY;
$in_area1 ="'3303','6502','6601','6702','7002','7102','7103','7203','7302','6302','6301','3405','4001','4005','4101','4802','5101','5701','6002','8602','5001','5002','5003','5004','5005','5006'";

$arr_site_admin = array('7103'=>'7103','6502'=>'6502','8602'=>'8602','6301'=>'6301','5101'=>'5101','7002'=>'7002','5701'=>'5701','6702'=>'6702','7203'=>'7203','4802'=>'4802','7302'=>'7302','3303'=>'3303');// เขตที่เอาเฉพาผู้บริหารและเจ้าหน้าที่เขต

$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = intval($x[0]+543);
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				return $xrs;
			}

			function thaidate1($temp){
				global $mname;
				$x = explode("/",$temp);
				$xrs = intval($x[0])." ".$mname[intval($x[1])]." ".$x[2];
				return $xrs;
			}
			
			function thaidate2($temp){
				global $mname;
				$x = explode("-",$temp);
				$xrs = intval($x[2])." ".$mname[intval($x[1])]." ".($x[0]+543);
				return $xrs;
			}




$c_date = date("Y-m-d");

$temp_start_date = "01/06/2552"; // วันเที่เริ่มต้นคีย์ข้อมูล ก.พ. 7 รอบที่ 2

		$ddmm = date("d/m/");
		$yyyy = date("Y")+543;
		$cc_dd = $ddmm.$yyyy;

?>


<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
</head>

<body bgcolor="#EFEFFF">
<BR>
<table border=0 align=center cellspacing=1 cellpadding=2 width="98%">
<tr><td width=35><img src="images/user_icon.gif"></td>
<td align="left" class="Label_big_black">สรุปภาพรวมรายการการคีย์ข้อมูล</td>
</tr>

<tr valign=top height=1 bgcolor="#808080"><td colspan=2></td></tr>

<tr valign=top bgcolor="#808080"><td colspan=2 bgcolor="#EFEFFF">
<? if($action == "view"){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td colspan="2" bgcolor="#EFEFFF"><strong>ค้นหาตามช่วงเวลา</strong></td>
        </tr>	
		<?		
		if($s_date != ""){$s_date = $s_date;}else{ $s_date = $temp_start_date;}
		if($e_date != ""){ $e_date = $e_date;}else{ $e_date = $cc_dd;}
		
		?>
        <tr>
          <td width="11%" align="right" bgcolor="#EFEFFF"><strong>เริ่มเวลา</strong></td>
          <td width="89%" align="left" bgcolor="#EFEFFF"><INPUT name="s_date" onFocus="blur();" value="<?=$s_date?>" size="15" readOnly>
              <INPUT name="button" type="button" class="index2"style="FONT-SIZE: 11px; WIDTH: 80px" onClick="popUpCalendar(this, form1.s_date, 'dd/mm/yyyy')"value="วัน เดือน ปี"></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#EFEFFF"><strong>สิ้นสุดเวลา</strong></td>
          <td align="left" bgcolor="#EFEFFF"><INPUT name="e_date" onFocus="blur();" value="<?=$e_date?>" size="15" readOnly>
              <INPUT name="button" type="button" class="index2"style="FONT-SIZE: 11px; WIDTH: 80px" onClick="popUpCalendar(this, form1.e_date, 'dd/mm/yyyy')"value="วัน เดือน ปี"></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#EFEFFF">&nbsp;</td>
          <td align="left" bgcolor="#EFEFFF"><label>
		  <input type="hidden" name="action" value="view">
            <input type="submit" name="Submit" value="ค้นหา">
          </label></td>
        </tr>
      </table>
        </form>
    </td>
  </tr>
</table>

<? } //END IF(action == "view")?>
</td>
</tr>
</table>
<?
if($action == "view"){
//echo "aaaaaaa";
?>
<table border=0 align=center cellspacing=1 cellpadding=2 bgcolor=black width="98%" class="sortable" id="unique_id">
<tr bgcolor="#a3b2cc">
  <th colspan="5" align="left"><? 
  if($s_date != "" and $e_date != ""){ echo "แสดงข้อมูลวันที่ ".thaidate1($s_date)." ถึง ".thaidate1($e_date);
  }else{ echo "ข้อมูล ณ. วันที่ ".thaidate2($c_date);}
  ?></th>
  </tr>
<tr bgcolor="#a3b2cc">
<th width=62>ลำดับ</th>
<th width="282">สำนักงานเขตพื้นที่การศึกษา</th>
<th width="222">จำนวนบุคลากรทั้งหมด(คน)</th>
<th width="186">จำนวนบุคลากรที่คีย์เสร็จ(คน)</th>
<th width=197>จำนวนบุคลากรที่ยังไม่ได้คีย์(คน)</th>
</tr>
<?

if($s_date != ""){$s_date = $s_date;}else{ $s_date = $temp_start_date;}
if($e_date != ""){ $e_date = $e_date;}else{ $e_date = $cc_dd;}

//echo $s_date."<hr>".$e_date;

$arr_s = explode("/",$s_date);
$arr_e = explode("/",$e_date);
$where_s_date =($arr_s[2]-543)."-".$arr_s[1]."-".$arr_s[0];
$where_e_date = ($arr_e[2]-543)."-".$arr_e[1]."-".$arr_e[0];

//543-- === 3094-12-15
if($where_s_date != "-543--" and $where_e_date != "-543--"){
	$where_con = "  AND monitor_keyin.timeupdate BETWEEN  '$where_s_date' AND '$where_e_date'";
}

//$sql= "SELECT $dbnamemaster.eduarea.secid, $dbnamemaster.eduarea.secname FROM $dbnamemaster.eduarea Inner Join $dbcall.monitor_keyin ON $dbnamemaster.eduarea.secid = $dbcall.monitor_keyin.siteid WHERE $dbcall.monitor_keyin.siteid <>  ''  AND $dbcall.monitor_keyin.siteid IN($in_area1)GROUP BY $dbcall.monitor_keyin.siteid ORDER BY $dbnamemaster.eduarea.secid  ASC";

$sql= "SELECT  $dbnamemaster.eduarea.secid, $dbnamemaster.eduarea.secname FROM   $dbnamemaster.eduarea   WHERE  $dbnamemaster.eduarea.secid IN($in_area1)  ORDER BY  $dbnamemaster.eduarea.secid  ASC ";
//echo $sql;die;
$result = mysql_db_query($dbnamemaster,$sql);
$n=0;
while($rs = mysql_fetch_assoc($result)){
if($n% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $n++;
$db_site = STR_PREFIX_DB.$rs[secid];
$siteid = $rs[secid];
// หาจำนวนบุคลากรทั้งหมด
if($arr_site_admin[$siteid] != ""){
$sql_1 = "SELECT COUNT(id) AS  num_all FROM general WHERE position_now NOT LIKE '%ครู%' or position_now NOT LIKE 'อาจารย์%'";
}else{
$sql_1 = "SELECT COUNT(id) AS  num_all FROM general";
}
$result1 = @mysql_db_query($db_site,$sql_1);
$rs1 = @mysql_fetch_assoc($result1);
$num_all = $rs1[num_all];
// หาจำนวนบุคลากรที่คีย์แล้ว

//$sql_2 = "SELECT *  FROM  monitor_keyin  WHERE  siteid='$siteid'  $where_con GROUP BY idcard";
//$sql_2 = "SELECT $db_site.general.idcard, $db_site.general.prename_th,$db_site.general.name_th, $db_site.general.surname_th,$db_site.general.position_now FROM $db_site.general INNER JOIN $dbcall.monitor_keyin ON $db_site.general.idcard= $dbcall.monitor_keyin.idcard  WHERE $dbcall.monitor_keyin.siteid='$siteid'  $where_con  GROUP BY ".DB_USERENTRY.".monitor_keyin.idcard ";

$sql_2 = "SELECT count($db_site.general.idcard) as num_key  FROM $db_site.general INNER JOIN $dbcall.monitor_keyin ON $db_site.general.idcard= $dbcall.monitor_keyin.idcard  WHERE $dbcall.monitor_keyin.siteid='$siteid'  $where_con ";
//echo "$sql_2";
$result2 = @mysql_db_query($dbcall,$sql_2);
$rs2 = @mysql_fetch_assoc($result2);
$num_key = $rs2[num_key];
$dif_null_key = $num_all - $num_key;

?>
<tr valign=top bgcolor="<?=$bg?>">
<td align="center"><?=$n?></td>
<td align="left" ><!--<a href="?action=view_school&siteid=<?//=$siteid?>&s_date=<?//=$s_date?>&e_date=<?//=$e_date?>">--><?=$rs[secname]?><!--</a>--></td>
<td align="right"><a href="?action=view_person_all&report=n_all&siteid=<?=$siteid?>&s_date=<?=$s_date?>&e_date=<?=$e_date?>" target="_blank"><?=number_format($num_all);?></a></td>
<td align="right"><a href="?action=view_person_all&report=n_key&siteid=<?=$siteid?>&s_date=<?=$s_date?>&e_date=<?=$e_date?>" target="_blank"><?=number_format($num_key);?></a></td>
<td align="right"><? if($dif_null_key > 0){?><a href="?action=view_person_all&report=n_null_key&siteid=<?=$siteid?>&s_date=<?=$s_date?>&e_date=<?=$e_date?>" target="_blank"><?=number_format($dif_null_key);?></a><? } else{ echo number_format($dif_null_key);}?></td>
</tr>
<?
}
?>
</table>

<?
} //end action == view
if($action == "view_school"){

$arr_s = explode("/",$s_date);
$arr_e = explode("/",$e_date);
$where_s_date =($arr_s[2]-543)."-".$arr_s[1]."-".$arr_s[0];
$where_e_date = ($arr_e[2]-543)."-".$arr_e[1]."-".$arr_e[0];

//543-- === 3094-12-15
if($where_s_date != "-543--" and $where_e_date != "-543--"){
	$where_con = "  AND monitor_keyin.timeupdate BETWEEN  '$where_s_date' AND '$where_e_date'";
}

$dbsite = STR_PREFIX_DB.$siteid;
$sql_allschool = "SELECT id, office FROM allschool WHERE siteid='$siteid' ORDER BY id DESC";
$result_allschool = mysql_db_query($dbnamemaster,$sql_allschool);

?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr><td align="left">&nbsp;</td></tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td colspan="5" align="left" bgcolor="#A3B2CC"><? if($s_date != "" and $e_date != ""){ echo "แสดงข้อมูลวันที่ ".thaidate1($s_date)." ถึง ".thaidate1($e_date);}else{ echo "ข้อมูล ณ. วันที่ ".thaidate2($c_date);}?></td>
        </tr>
      <tr>
        <td width="7%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="29%" align="center" bgcolor="#A3B2CC"><strong>สังกัดหน่วยงานการศึกษา</strong></td>
        <td width="24%" align="center" bgcolor="#A3B2CC"><strong>จำนวนบุคลากรทั้งหมด(คน)</strong></td>
        <td width="20%" align="center" bgcolor="#A3B2CC"><strong>จำนวนบุคลากรที่คีย์เสร็จ(คน)</strong></td>
        <td width="20%" align="center" bgcolor="#A3B2CC"><strong>จำนวนบุคลากรที่ยังไม่ได้คีย์(คน)</strong></td>
      </tr>
	  <?
	  $n=0;
	  while($rs = mysql_fetch_assoc($result_allschool)){
	  if($n% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $n++;
	  $sql_num1 = "SELECT COUNT(id) AS num1 FROM general WHERE schoolid='$rs[id]'";
	  $result_num1 = mysql_db_query($dbsite,$sql_num1);
	  $rs1 = mysql_fetch_assoc($result_num1);
	  $num1 = $rs1[num1];
	  $xnum1 += $rs1[num1]; // ผลรวมบุคลากรที่ทั้งหมดในเขต
	  
	  $sql_num2 = "SELECT $dbsite.general.schoolid,$dbsite.general.idcard FROM $dbsite.general INNER JOIN $dbcall.monitor_keyin ON $dbsite.general.idcard=$dbcall.monitor_keyin.idcard  WHERE $dbsite.general.schoolid='$rs[id]' $where_con  GROUP BY $dbcall.monitor_keyin.idcard ";
	  $result_num2 = mysql_db_query($dbsite,$sql_num2);
	  $num2 = mysql_num_rows($result_num2);
	  
	  $temp_num = $num2;
	  $xnum2 += $temp_num;	   /// ผลรวมของบุคลากรที่คีย์แล้ว
	  $dif_num = $num1-$num2;
	  
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$n?></td>
        <td align="left"><?=$rs[office]?></td>
        <td align="right"><? if($num1 > 0){ echo "<a href='?action=view_person&report=n_all&schoolid=$rs[id]&schoolname=$rs[office]&siteid=$siteid&s_date=$s_date&e_date=$e_date'>".number_format($num1)."</a>";}else{ echo number_format($num1); }?></td>
        <td align="right"><? if($num2 > 0){ echo "<a href='?action=view_person&report=n_key&schoolid=$rs[id]&schoolname=$rs[office]&siteid=$siteid&s_date=$s_date&e_date=$e_date'>".number_format($num2)."</a>";}else{ echo number_format($num2);}?></td>
        <td align="right"><? if($dif_num > 0){ echo"<a href='?action=view_person&report=n_null_key&schoolid=$rs[id]&schoolname=$rs[office]&siteid=$siteid&s_date=$s_date&e_date=$e_date'>".number_format($dif_num)."</a>";}else{ echo number_format($dif_num);}?></td>
      </tr>
	  <?
	  }
	  ?>
      <tr>
        <td colspan="2" align="center" bgcolor="#FFFFFF"><strong>รวม</strong></td>
        <td align="right" bgcolor="#FFFFFF"><? echo number_format($xnum1);?></td>
        <td align="right" bgcolor="#FFFFFF"><? echo number_format($xnum2);?></td>
        <td align="right" bgcolor="#FFFFFF"><? $xdif_num = $xnum1 - $xnum2; echo number_format($xdif_num);?></td>
      </tr>
    </table></td>
  </tr>
</table>
<?
}
if($action == "view_person"){
$db_site = STR_PREFIX_DB.$siteid;

$arr_s = explode("/",$s_date);
$arr_e = explode("/",$e_date);
$where_s_date =($arr_s[2]-543)."-".$arr_s[1]."-".$arr_s[0];
$where_e_date = ($arr_e[2]-543)."-".$arr_e[1]."-".$arr_e[0];

//543-- === 3094-12-15
if($where_s_date != "-543--" and $where_e_date != "-543--"){
	$where_con = "  AND monitor_keyin.timeupdate BETWEEN  '$where_s_date' AND '$where_e_date'";
}


	if($report == "n_all"){
	$sql = "SELECT idcard, prename_th, name_th, surname_th, position_now FROM general WHERE schoolid='$schoolid' ORDER BY name_th  ASC";
	$result = mysql_db_query($db_site,$sql);
	$i=0;
		while($rs = mysql_fetch_assoc($result)){
			$idcard[$i] = "$rs[idcard]";
			$name[$i] = "$rs[prename_th]$rs[name_th]  $rs[surname_th]";
			$posi[$i] = "$rs[position_now]";
		$i++;
		}
		$txt_title = "รายงานจำนวนบุคลากรทั้งหมด";
	}else if($report == "n_key"){
	$sql = "SELECT $db_site.general.idcard, $db_site.general.prename_th,$db_site.general.name_th, $db_site.general.surname_th,$db_site.general.position_now FROM $db_site.general INNER JOIN $dbcall.monitor_keyin ON $db_site.general.idcard= $dbcall.monitor_keyin.idcard WHERE $db_site.general.schoolid = '$schoolid' $where_con  GROUP BY ".DB_USERENTRY.".monitor_keyin.idcard  ORDER BY $db_site.general.name_th ASC";
	//echo "$sql<br>";
	$result = mysql_db_query($db_site,$sql);
	$i=0;
		while($rs = mysql_fetch_assoc($result)){
			$idcard[$i] = "$rs[idcard]";
			$name[$i] = "$rs[prename_th]$rs[name_th]  $rs[surname_th]";
			$posi[$i] = "$rs[position_now]";
		$i++;
		}
	$txt_title = "รายงานจำนวนบุคลากรที่คีย์แล้ว";
}else if($report == "n_null_key"){

$sql_key = "SELECT $db_site.general.idcard FROM $db_site.general INNER JOIN $dbcall.monitor_keyin ON $db_site.general.idcard= $dbcall.monitor_keyin.idcard WHERE $db_site.general.schoolid = '$schoolid' $where_con  GROUP BY ".DB_USERENTRY.".monitor_keyin.idcard  ORDER BY $db_site.general.name_th ASC";
//echo $sql_key ;
$result_key = mysql_db_query($db_site,$sql_key);
$k=0;
while($rs_key = mysql_fetch_assoc($result_key)){
	$in_idcard .= $rs_key[idcard].",";
	$k++;
}

$in_id = substr($in_idcard,0,-1);
if($k > 0){
$sql = "SELECT idcard, prename_th, name_th, surname_th, position_now FROM general WHERE idcard NOT IN($in_id) AND schoolid='$schoolid'";
}else{
$sql = "SELECT idcard, prename_th, name_th, surname_th, position_now FROM general WHERE  schoolid='$schoolid'";
}
$result = mysql_db_query($db_site,$sql);
	$i=0;
while($rs = mysql_fetch_assoc($result)){
	if($rs[key_id] == "" or $rs[key_id] == NULL){
		$idcard[$i] = "$rs[idcard]";
		$name[$i] = "$rs[prename_th]$rs[name_th]  $rs[surname_th]";
		$posi[$i] = "$rs[position_now]";		
	$i++;
	}
		$txt_title = "รายงายจำนวนบุคลากรที่ยังไม่ได้คีย์";
}
	}
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td colspan="4" align="left" bgcolor="#A3B2CC"><strong><? $spost = strpos($schoolname,"สพท."); if($spost === false){ echo "โรงเรียน$schoolname";}else{ echo "$schoolname";}?><?=$txt_title?></strong></td>
        </tr>
      <tr>
        <td width="7%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="29%" align="center" bgcolor="#A3B2CC"><strong>รหัสบัตรประจำตัวประชาชน</strong></td>
        <td width="29%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - นามสกุล </strong></td>
        <td width="35%" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
        </tr>
		<?
		$m=0;
		 for($j=0;$j<count($idcard);$j++){	
		  if($n% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $m++;
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$m?></td>
        <td align="left"><?=$idcard[$j]?></td>
        <td align="left"><?=$name[$j]?></td>
        <td align="left"><?=$posi[$j]?></td>
        </tr>
<?
	}
?>
    </table></td>
  </tr>
</table>
<?
}
if($action == "view_person_all"){
$db_site = STR_PREFIX_DB.$siteid;

$arr_s = explode("/",$s_date);
$arr_e = explode("/",$e_date);
$where_s_date =($arr_s[2]-543)."-".$arr_s[1]."-".$arr_s[0];
$where_e_date = ($arr_e[2]-543)."-".$arr_e[1]."-".$arr_e[0];

//543-- === 3094-12-15
if($where_s_date != "-543--" and $where_e_date != "-543--"){
	$where_con = "  AND monitor_keyin.timeupdate BETWEEN  '$where_s_date' AND '$where_e_date'";
}
	if($report == "n_all"){
		$txt_title = "รายงายจำนวนบุคลากรทั้งหมด";
	}else if($report == "n_key"){
		$txt_title = "รายงายจำนวนบุคลากรที่คีย์เสร็จแล้ว";
	}else if($report == "n_null_key"){
		$txt_title = "รายงายจำนวนบุคลากรที่ยังไม่ได้คีย์";
	}
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td colspan="4" align="left" bgcolor="#A3B2CC"><strong><? $spost = strpos($schoolname,"สพท."); if($spost === false){ echo "โรงเรียน$schoolname";}else{ echo "$schoolname";}?><?=$txt_title?></strong></td>
        </tr>
      <tr>
        <td width="7%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="29%" align="center" bgcolor="#A3B2CC"><strong>รหัสบัตรประจำตัวประชาชน</strong></td>
        <td width="29%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - นามสกุล </strong></td>
        <td width="35%" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
        </tr>
<?
$m=0;


$sql_key1 = "
SELECT 
$db_site.general.idcard
FROM
$db_site.general
INNER Join ".DB_USERENTRY.".monitor_keyin ON $db_site.general.idcard = ".DB_USERENTRY.".monitor_keyin.idcard 
WHERE ".DB_USERENTRY.".monitor_keyin.siteid='$siteid' $where_con GROUP BY $db_site.general.idcard
";
//echo $sql_key1;
$result_key1 = mysql_db_query($db_site,$sql_key1);
while($rs_k1 = mysql_fetch_assoc($result_key1)){
	if($idcard_key1 > "") $idcard_key1 .= ",";
	//$xpos = strpos($rs_k1[idcard],"X");
	//if($xpos === false){
		//$idcard_key1 .= $rs_k1[idcard];
	//}else{
		$idcard_key1 .= "'".$rs_k1[idcard]."'";
	//}
}


if($report == "n_all"){
$sql_key = "
SELECT 
$db_site.general.idcard,
 ".DB_MASTER.".allschool.office,
$db_site.general.prename_th,$db_site.general.name_th, $db_site.general.surname_th,$db_site.general.position_now
FROM
$db_site.general
Inner Join  ".DB_MASTER.".allschool ON $db_site.general.schoolid =  ".DB_MASTER.".allschool.id
GROUP BY $db_site.general.idcard
ORDER BY  ".DB_MASTER.".allschool.id,$db_site.general.name_th ASC
";

}else if($report == "n_key"){
	$sql_key = "
SELECT 
$db_site.general.idcard,
 ".DB_MASTER.".allschool.office,
$db_site.general.prename_th,$db_site.general.name_th, $db_site.general.surname_th,$db_site.general.position_now
FROM
$db_site.general
Inner Join  ".DB_MASTER.".allschool ON $db_site.general.schoolid =  ".DB_MASTER.".allschool.id
WHERE  $db_site.general.idcard IN($idcard_key1)
GROUP BY $db_site.general.idcard
ORDER BY  ".DB_MASTER.".allschool.id,$db_site.general.name_th ASC
";

}else if($report == "n_null_key"){

$sql_key = "
SELECT 
$db_site.general.idcard,
 ".DB_MASTER.".allschool.office,
$db_site.general.prename_th,$db_site.general.name_th, $db_site.general.surname_th,$db_site.general.position_now
FROM
$db_site.general
Inner Join  ".DB_MASTER.".allschool ON $db_site.general.schoolid =  ".DB_MASTER.".allschool.id
WHERE   $db_site.general.idcard NOT IN($idcard_key1)
GROUP BY $db_site.general.idcard
ORDER BY  ".DB_MASTER.".allschool.id,$db_site.general.name_th ASC
";
//echo $sql_key;
}
//echo $report." <br>".$sql_key."<hr>";
$result_key = @mysql_db_query($db_site,$sql_key);
while($rs  = @mysql_fetch_assoc($result_key)){
$name = "$rs[prename_th]$rs[name_th]  $rs[surname_th]";
if($n% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} $m++;
	if($office != $rs[office]){
	$office = $rs[office]; 
	echo "
		  <tr bgcolor=\"#EFEFEF\">
			<td colspan=\"4\" align=\"LEFT\">&nbsp;$rs[office]</td>
		   </tr>
	";
	}
?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$m?></td>
        <td align="left"><?=$rs[idcard]?></td>
        <td align="left"><?=$name?></td>
        <td align="left"><?=$rs[position_now]?></td>
        </tr>
<?
	}
?>
    </table></td>
  </tr>
</table>
<?
}
?>
</BODY>
</HTML>
