<?php
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
mysql_select_db($dbsystem);
$time_start = getmicrotime();
$competency_system_db = "competency_system";
$edubkk_master_db = DB_MASTER;
?>
<html>
<head>
<title>ข้อมูลข้าราชการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="libary/style.css" type="text/css" rel="stylesheet">
<link href="../../../common/style.css" type="text/css" rel="stylesheet">
<script language="javascript" src="chk_number.js"></script>
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style4 {
	font-size: 16px;
	color: #FFFFFF;
}
-->
</style>

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
	BACKGROUND: url(../hr3/hr_report/images/hdr_bg.png) #6eab26 repeat-x 0px -90px; 
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
	BACKGROUND: url(../hr3/hr_report/images/hdr_bg.png) #63a218 repeat-x 0px -170px; 
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
.style7 {font-family: "Times New Roman", Times, serif}
.style8 {
	font-family: "Times New Roman", Times, serif;
	margin-right: 1px;
	font-weight: bold;
	font-size: 12px;
}
</style>

</head>
<body  background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom ">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<?
	function todate($din){
		$darr1 = explode(" ",$din);
		$darr = explode("-",$darr1[0]);
	 return intval($darr[2])."-".intval($darr[1])."-".(intval($darr[0])+543)." [".$darr1[1]."]";
	}
	?>
    <td valign="top">
		<table  width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="40" align="left"  background="../images/hr-banner.gif" bgcolor="#4752A3" class="shadetabs style4" style="background-repeat: no-repeat; background-position:right bottom ">รายงานการออกเอกสารสำเนา ก.พ.7</td>
			</tr>
  	  </table>
	 <form name="form1" method="post" action="activity_log_list.php"> 
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%"><span class="style7 fieldset"><strong>เงื่อนไขการสืบค้น (<span class="normal"><a href="activity_verify.php" target="_self">ระบบตรวจสอบความถูกต้องเอกสาร</a> || รายงานการออกเอกสารสำเนา ก.พ.7</span>) </strong></span></td>
  </tr>
  
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="16%" align="right"><strong>เขตพื้นที่การศึกษา</strong></td>
        <td width="84%">
		 <select name="txt_siteid">
		 <option value="">เลือกเขตพื้นทีการศึกษา</option>
		  <?
		  if ($_SESSION[secid] == DB_MASTER){ 
		  	$where_area  = " 	"; 
		  }else{
		  	$xsecid = $_SESSION[secid] ; 
		  	$where_area  = " AND secid = '$xsecid'   ";
			$txt_siteid = $xsecid ; 
		   }  ######  if ($_SESSION[secid] == "edubkk_master"){  
		   
		  $sql1 = " SELECT  *  FROM  eduarea   WHERE 1 $where_area   ORDER BY  secname ";
		  $result1 = mysql_db_query($edubkk_master_db,$sql1);
		  while($rs1=mysql_fetch_assoc($result1)){
		  if($rs1[secid] == $txt_siteid){ $selected = "selected";}else{ $selected=""; }
		   ?>
            <option value="<?=$rs1[secid]?>"<?=$selected?>><?=$rs1[secname]?></option>
		  <? } ?>	
          </select>		  </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="6%" align="right" class="fieldset style7">ชื่อ </td>
        <td width="17%" align="left" class="fieldset"><span class="style7">
          <label>
          <input type="text" name="search_name" size="25" value="<?=$search_name?>">
          </label>
        </span></td>
        <td width="8%" align="right" class="fieldset style7">นามสกุล</td>
        <td width="20%" align="left" class="fieldset"><span class="style7">
          <label>
          <input type="text" name="search_sername" size="25" value="<?=$search_sername?>">
          </label>
        </span></td>
        <td width="12%" align="right" class="fieldset style7">รหัสประจำตัว</td>
        <td width="19%" align="left" class="fieldset"><span class="style7">
          <label>
          <input type="text" name="search_id" size="25" value="<?=$search_id?>">
          </label>
        </span></td>
        <td width="18%" align="left" class="fieldset"><span class="style7">
          <label>
		   <input type="hidden" name="action" value="Sreport">
           <input type="submit" name="Submit" value="ค้นหา">
		   <input type="button" name="button" value="ล้างค่า" onClick="location.href='?action='">
          </label>
        </span></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<?
if($action == "Sreport"){
//echo $txt_siteid;
//echo $search_name."<br>".$search_sername."<br>".$search_id;
	//---------------------------------start function ---------------------------------------------
function devidepage($total, $kwd , $sqlencode ){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page,$search_name,$search_sername,$search_id;

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
			$table .= "<a href=\"?action=Sreport&owner_name=$search_name&owner_sername=$search_sername&id_card=$search_id&page=1&displaytype=people".$kwd."\"><u><font color=\"black\">หน้าแรก</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?action=Sreport&owner_name=$search_name&owner_sername=$search_sername&id_card=$search_id&page=".$i."&displaytype=people". $kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?action=Sreport&owner_name=$search_name&owner_sername=$search_sername&id_card=$search_id&page=".$page_all."&displaytype=people". $kwd."\"><u><font color=\"black\">หน้าสุดท้าย</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?action=Sreport&owner_name=$search_name&owner_sername=$search_sername&id_card=$search_id&page=".($page_all+1)."&displaytype=people". $kwd."\"><u><font color=\"black\">แสดงทั้งหมด</font></u></a>";
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


//--------------------------------------end function -----------------------------------------

	
		$txt_condition = "  WHERE owner_name LIKE '%$search_name%' ";
		if($search_sername){$txt_condition .= " AND owner_sername LIKE '%$search_sername%' ";}
		if($search_id){$txt_condition .= " AND id_card LIKE '%$search_id%' ";}
		if($txt_siteid){ $txt_condition .= " AND $edubkk_master_db.view_general.siteid LIKE '%$txt_siteid%'";}
		
// ----------- แบ่งหน้า ---------------------------------------------
$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
$e = (!isset($e) || $e == 0) ? 30 : $e ;
$i	= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 

	$sql = "SELECT
						view_general.siteid,
						`activity_log`.`owner_name`,
						`activity_log`.`owner_sername`,
						`activity_log`.`admin_name`,
						`activity_log`.`admin_sername`,
						`server_list`.`servername`,
						`server_list`.`serveraddress`,
						`activity_list`.`activity_name`,
						`activity_log`.`date`,
						`activity_log`.`temp_file`
						FROM
						$competency_system_db.`activity_log`
						inner join $edubkk_master_db.view_general ON  $competency_system_db.`activity_log`.id_card=$edubkk_master_db.view_general.CZ_ID
						Inner Join $competency_system_db.`activity_list` ON `activity_log`.`activity` = `activity_list`.`activity_id`
						Inner Join $competency_system_db.`server_list` ON `server_list`.`serverid` = `activity_log`.`server_id` $txt_condition GROUP BY activity_log.id_card ORDER BY activity_log.`date` DESC,activity_log.owner_name ASC";
	  
	$xresult = mysql_db_query($competency_system_db,$sql);
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;

//---------------------------end--------------
if($page <= $allpage){
$strSearch = "SELECT
						view_general.siteid,
						`activity_log`.`owner_name`,
						`activity_log`.`owner_sername`,
						`activity_log`.`admin_name`,
						`activity_log`.`admin_sername`,
						`server_list`.`servername`,
						`server_list`.`serveraddress`,
						`activity_list`.`activity_name`,
						`activity_log`.`date`,
						`activity_log`.`temp_file`
						FROM
						$competency_system_db.`activity_log`
						inner join $edubkk_master_db.view_general ON  $competency_system_db.`activity_log`.id_card=$edubkk_master_db.view_general.CZ_ID
						Inner Join $competency_system_db.`activity_list` ON `activity_log`.`activity` = `activity_list`.`activity_id`
						Inner Join $competency_system_db.`server_list` ON `server_list`.`serverid` = `activity_log`.`server_id` $txt_condition GROUP BY activity_log.id_card ORDER BY activity_log.`date` DESC,activity_log.owner_name ASC LIMIT $i, $e";
}else if($page == $xpage){
$strSearch = "SELECT
						view_general.siteid,
						`activity_log`.`owner_name`,
						`activity_log`.`owner_sername`,
						`activity_log`.`admin_name`,
						`activity_log`.`admin_sername`,
						`server_list`.`servername`,
						`server_list`.`serveraddress`,
						`activity_list`.`activity_name`,
						`activity_log`.`date`,
						`activity_log`.`temp_file`
						FROM
						$competency_system_db.`activity_log`
						inner join $edubkk_master_db.view_general ON  $competency_system_db.`activity_log`.id_card=$edubkk_master_db.view_general.CZ_ID
						Inner Join $competency_system_db.`activity_list` ON `activity_log`.`activity` = `activity_list`.`activity_id`
						Inner Join $competency_system_db.`server_list` ON `server_list`.`serverid` = `activity_log`.`server_id` $txt_condition GROUP BY activity_log.id_card ORDER BY activity_log.`date` DESC,activity_log.owner_name ASC";
$i=0;
}else{
$strSearch = "SELECT
						view_general.siteid,
						`activity_log`.`owner_name`,
						`activity_log`.`owner_sername`,
						`activity_log`.`admin_name`,
						`activity_log`.`admin_sername`,
						`server_list`.`servername`,
						`server_list`.`serveraddress`,
						`activity_list`.`activity_name`,
						`activity_log`.`date`,
						`activity_log`.`temp_file` , expire_date 
						FROM
						$competency_system_db.`activity_log`
						inner join $edubkk_master_db.view_general ON  $competency_system_db.`activity_log`.id_card=$edubkk_master_db.view_general.CZ_ID
						Inner Join $competency_system_db.`activity_list` ON `activity_log`.`activity` = `activity_list`.`activity_id`
						Inner Join $competency_system_db.`server_list` ON `server_list`.`serverid` = `activity_log`.`server_id` $txt_condition GROUP BY activity_log.id_card ORDER BY activity_log.`date` DESC,activity_log.owner_name ASC LIMIT $i, $e";
}
 echo $strSearch;
die; 

$Result_Search = mysql_db_query($competency_system_db,$strSearch);

$search_sql = $strSearch ; 
$num_r = mysql_num_rows($Result_Search);
// ------------------- end แบ่งหน้า ----------------------------------

			$i = 0;
			while($arr = mysql_fetch_assoc($Result_Search)){
				$arr_id[$i] = $arr[id_card];
				$arr_name[$i] = $arr[owner_name]." ".$arr[owner_sername];
				$arr_activity[$i] = $arr[activity_name];
				$arr_name1[$i] = $arr[admin_name]." ".$arr[admin_sername];
				$arr_servername[$i] = $arr[servername]." <span class='brown style5'>IP ".$arr[serveraddress];
				$arr_date[$i] = todate($arr[date]);
				$arr_temp_file[$i] = $arr[temp_file];
				$arr_endtime[$i] =$arr[date];
				$i++;
			}

	
if($num_r < 1){
//echo $Result_Search;
?>
<table width="99%" border="0" cellpadding="0" cellspacing="2" bgcolor="#FFFFFF" align="center" style="border:1px solid #5595CC;">
<tr>
	<td height="20">
	<ul>
	  <span class="fieldset style7"><br />
	  </span><span class="style8"><img src="../../../images_sys/alert.gif" width="20" height="20" border="0" align="absmiddle" />&nbsp;ผลการค้นหา - ไม่ตรงกับบุคลากรใด ๆ<br />
	  ข้อแนะนำ :<br />
	- ขอให้แน่ใจว่าสะกดทุกคำอย่างถูกต้อง<br />
	- ลดเงื่อนไขการค้นหาลง<br />
	  </span><br />
	</ul>
	</td>
</tr>
</table>
 
<?
}else{
?>

	  		<table  width="100%" border="0" cellspacing="1" cellpadding="0"  bgcolor="#000000">
			<tr>
				<td width="3%" align="center" bgcolor="#9999CC"  class="fieldset" ><strong>ลำดับ</strong></td>
				<td width="16%" align="center"  bgcolor="#9999CC"  class="fieldset"><strong>เจ้าของข้อมูล</strong></td>
				<td width="16%" align="center" bgcolor="#9999CC"   class="fieldset"><strong>เอกสารสั่งพิมพ์</strong></td>
				<td width="14%" align="center" bgcolor="#9999CC"   class="fieldset"><strong>ผู้สั่งพิมพ์</strong></td>
				<td width="20%" align="center" bgcolor="#9999CC"   class="fieldset"><strong>เครื่องคอมพิวเตอร์แม่ข่าย</strong></td>
				<td width="11%" align="center" bgcolor="#9999CC"   class="fieldset"><strong>เวลาสั่งพิมพ์</strong></td>
				<td width="11%" align="center" bgcolor="#9999CC"   class="fieldset">วันที่เอกสารหมดอายุ</td>
				<td width="7%" align="center" bgcolor="#9999CC"   class="fieldset"><strong>ไฟล์ต้นฉบับ</strong></td>
			</tr>
			<?
			$n=0;
			for($k=0;$k<count($arr_id);$k++){
			$n++;
			?>
			<tr>
				<td align="center" bgcolor="#F4F4F4"  class="normal_black" ><? if($page == $allpage+1){ echo $n; }else{ echo ((($page-1) * $e) + $n);}?></td>
				<td align="left"  bgcolor="#F4F4F4"  class="normal_black"><?=$arr_name[$k];?></td>
				<td align="left" bgcolor="#F4F4F4"   class="normal_black"><?=$arr_activity[$k];?></td>
				<td align="left" bgcolor="#F4F4F4"   class="normal_black"><?=$arr_name1[$k];?></td>
				<td align="left" bgcolor="#F4F4F4"   class="normal_black"><?=$arr_servername[$k];?></span></td>
				<td align="center" bgcolor="#F4F4F4"   class="normal_black"><?=$arr_date[$k];?></td>
				<td align="center" bgcolor="#F4F4F4"   class="normal_black">
				<?
				$arr_time_x =explode(" ",$arr_endtime[$k]);
				$strSQL_end = "SELECT ADDDATE('$arr_time_x[0]', INTERVAL 180 DAY) as time_end";
				$Result_end = mysql_db_query($competency_system_db,$strSQL_end);
				$Rs_end = mysql_fetch_assoc($Result_end);
				$arr_1 = explode("-",$Rs_end[time_end]);
				$d1 = $arr_1[2];
				$m1 = $arr_1[1];
				$y1 = $arr_1[0]+543;
				$date_1 = $d1."-".$m1."-".$y1;
				# echo $date_1." [".$arr_time_x[1]."]";
				echo  $arr[expire_date] ;
				?>
				</td>
				<? 
				if(is_file("tmp_pdf/$arr_temp_file[$k]")){
				?>
				<td align="center" bgcolor="#F4F4F4"   class="normal_black"><a href="tmp_pdf/<?=$arr_temp_file[$k];?>" target="_blank"><img src="../images/dtree/page.gif" border="0"></a></td>
				<?
				}else{
				?>
				<td width="2%" align="center" bgcolor="#F4F4F4"   class="normal_black"><img src="../images/dtree/empty.gif" width="19" border="0"></td>
				<?
				}
				?>
			</tr>
			<?

			}
		    ?>
		<tr><td colspan="8" align="center" bgcolor="#FFFFFF">
	<? $sqlencode = urlencode($search_sql)  ; ?>	
	<?=devidepage($allpage, $keyword ,$sqlencode )?>		

		</td>
		</tr>
	  </table>
    </td>
  </tr>
</table>
<?
	}
}
?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>