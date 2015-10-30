<?
require_once("../../../../config/conndb_nonsession.inc.php");
include('function.inc_v1.php') ;
$db_call= DB_USERENTRY;
$date_con = "2009-12-01";
$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$point_num = 60;	
	if($yy1 == ""){
		$yy1 = date("Y")+543;
	}
	if($mm == ""){					
		$mm = sprintf("%2d",date("m"));
	}
	function ShowGroup($get_group){
			if($get_group == "1"){ return "A";}
			else if($get_group == "2"){ return "B";}
			else if($get_group == "3"){ return "C";}
	}

$array_day = array("1"=>"จ.","2"=>"อ.","3"=>"พ.","4"=>"พฤ.","5"=>"ศ.","6"=>"ส.");

#####  function นับจำนวนที่ค้าง QC
function CountDiscountQC(){
	global $db_call;
	$sql = "SELECT  sum(if(status_qc=1,1,0)) as num_qc ,sum(if(status_qc=0,1,0)) as num_dis_qc,siteid FROM temp_qc  GROUP BY siteid";
	$result = mysql_db_query($db_call,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs['siteid']]['1'] = $rs[num_qc];
		$arr[$rs['siteid']]['0'] = $rs[num_dis_qc];
			
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function CountDiscountQC(){

###  funnction countall
function CountPersonAll($get_profile=""){
		$db_temp = DB_CHECKLIST;
		$sql = "SELECT COUNT(idcard) as num1 , siteid FROM tbl_checklist_kp7 GROUP BY siteid";
		$result = mysql_db_query($db_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arr2[$rs[siteid]] = $rs[num1];
		}//end while($rs = mysql_fetch_assoc($result)){
			return $arr2;
}//end function CountPersonAll(){


###################   ประมวลผลดึงข้อมูลไว้ใน temp
/*if($action == "process_all"){
	$sql = "SELECT
monitor_keyin.idcard,
monitor_keyin.staffid,
monitor_keyin.keyin_name,
monitor_keyin.siteid,
monitor_keyin.status_key,
monitor_keyin.status_approve,
monitor_keyin.audit_comment,
monitor_keyin.timeupdate,
monitor_keyin.timestamp_key,
monitor_keyin.status_user,
monitor_keyin.timeupdate_user
FROM
monitor_keyin
Left Join temp_qcvalidate_checkdata ON monitor_keyin.idcard = temp_qcvalidate_checkdata.idcard
WHERE
temp_qcvalidate_checkdata.idcard IS NULL  AND
date(monitor_keyin.timeupdate)  >  '$date_con' GROUP BY monitor_keyin.idcard";
$result = mysql_db_query($db_call,$sql);
while($rs = mysql_fetch_assoc($result)){
	$sql1 = "SELECT COUNT(idcard) as num1 FROM temp_qc WHERE idcard='$rs[idcard]' AND staffid='$rs[staffid]'";
	$result1 = mysql_db_query($db_call,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	if($rs1[num1] < 1){ // ทำการเพิ่ม
		$sql2 = "INSERT INTO temp_qc SET staffid='$rs[staffid]',idcard='$rs[idcard]',keyin_name='$rs[keyin_name]',siteid='$rs[siteid]',status_key='$rs[status_key]',status_approve='$rs[status_approve]',audit_comment='$rs[audit_comment]',timeupdate='$rs[timeupdate]',timestamp_key='$rs[timestamp_key]',status_user='$rs[status_user]',timeupdate_user='$rs[timeupdate_user]'";	
		mysql_db_query($db_call,$sql2);
	}//end 	if($rs1[num1] < 1){ // ทำการเพิ่ม
		
}//end while($rs = mysql_fetch_assoc($result)){
		echo "<script language=\"javascript\">
	location.href = \"?action=\";
	</script>" ;
	exit;
}else*/ 

if($action == "process_site"){
	$sql = "SELECT
distinct monitor_keyin.idcard
FROM
monitor_keyin
WHERE monitor_keyin.siteid='$xsiteid' AND
date(monitor_keyin.timeupdate)  >  '$date_con'";
$result = mysql_db_query($db_call,$sql);
while($rs = mysql_fetch_assoc($result)){
	if($con_id > "") $con_id .= ",";
	$con_id .= "'$rs[idcard]'";
}//end while($rs = mysql_fetch_assoc($result)){
	
if($con_id != ""){
		$sql2 = "SELECT distinct idcard   FROM `validate_checkdata` where idcard IN($con_id)";
		$result2 = mysql_db_query($db_call,$sql2);
		while($rs2 = mysql_fetch_assoc($result2)){
				if($xconid > "") $xconid .= ","; 
				$xconid .= "'$rs2[idcard]'";
		}
		
	if($xconid != ""){
			$sql3 = "SELECT distinct monitor_keyin.idcard,
monitor_keyin.staffid,
monitor_keyin.keyin_name,
monitor_keyin.siteid,
monitor_keyin.status_key,
monitor_keyin.status_approve,
monitor_keyin.audit_comment,
monitor_keyin.timeupdate,
monitor_keyin.timestamp_key,
monitor_keyin.status_user,
monitor_keyin.timeupdate_user FROM  monitor_keyin WHERE siteid='$xsiteid' AND idcard NOT IN($xconid) AND date(monitor_keyin.timeupdate)  >  '$date_con'";
			$result3 = mysql_db_query($db_call,$sql3);
			while($rs = mysql_fetch_assoc($result3)){
				$sql1 = "SELECT COUNT(idcard) as num1 FROM temp_qc WHERE idcard='$rs[idcard]' AND staffid='$rs[staffid]'";
				$result1 = mysql_db_query($db_call,$sql1);
				$rs1 = mysql_fetch_assoc($result1);
				if($rs1[num1] < 1){ // ทำการเพิ่ม
					$sql2 = "INSERT INTO temp_qc SET staffid='$rs[staffid]',idcard='$rs[idcard]',keyin_name='$rs[keyin_name]',siteid='$rs[siteid]',status_key='$rs[status_key]',status_approve='$rs[status_approve]',audit_comment='$rs[audit_comment]',timeupdate='$rs[timeupdate]',timestamp_key='$rs[timestamp_key]',status_user='$rs[status_user]',timeupdate_user='$rs[timeupdate_user]'";	
				mysql_db_query($db_call,$sql2);
				}//end 	if($rs1[num1] < 1){ // ทำการเพิ่ม

			}//end 	while($rs = mysql_fetch_assoc($result3)){
	}//end 	if($xconid != ""){
}//end if($con_id != ""){
		
	echo "<script language=\"javascript\">
	location.href = \"?action=\";
	</script>" ;
	exit;
}//end if($action == "process_all"){

###################  end ประมวลผลดึงข้อมูลไว้ใน temp



### แบ่งหน้า

function xdevidepage($total, $kwd , $sqlencode ){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page,$key_siteid,$key_idcard,$key_name,$key_surname,$date_key,$key_staffid,$key_action,$action,$xtype,$xsiteid;

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
			$table .= "<a href=\"?page=1&key_siteid=$key_siteid&key_idcard=$key_idcard&key_name=$key_name&key_surname=$key_surname&date_key=$date_key&key_staffid=$key_staffid&key_action=$key_action&action=$action&xtype=$xtype&xsiteid=$xsiteid&displaytype=people".$kwd."\"><u><font color=\"black\">หน้าแรก</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?page=".$i."&key_siteid=$key_siteid&key_idcard=$key_idcard&key_name=$key_name&key_surname=$key_surname&date_key=$date_key&key_staffid=$key_staffid&key_action=$key_action&action=$action&xtype=$xtype&xsiteid=$xsiteid&displaytype=people". $kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?page=".$page_all."&key_siteid=$key_siteid&key_idcard=$key_idcard&key_name=$key_name&key_surname=$key_surname&date_key=$date_key&key_staffid=$key_staffid&key_action=$key_action&action=$action&xtype=$xtype&xsiteid=$xsiteid&displaytype=people". $kwd."\"><u><font color=\"black\">หน้าสุดท้าย</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?page=".($page_all+1)."&key_siteid=$key_siteid&key_idcard=$key_idcard&key_name=$key_name&key_surname=$key_surname&date_key=$date_key&key_staffid=$key_staffid&key_action=$key_action&action=$action&xtype=$xtype&xsiteid=$xsiteid&displaytype=people". $kwd."\"><u><font color=\"black\">แสดงทั้งหมด</font></u></a>";
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานตรวจสอบการ QC</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
    <style type="text/css">

    .mouseOut {
    background: #708090;
    color: #FFFAFA;
    }

    .mouseOver {
    background: #FFFAFA;
    color: #000000;
    }
    
	body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #000;
}
a:visited {
	color: #000;
}
a:hover {
	color: #F60;
}
a:active {
	color: #000;
}
</style>
</head>
<body>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        
        
   <?
   	if($action == ""){
		
   
   ?>
        
        <tr>
          <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="7" align="center" bgcolor="#D4D4D4"><strong>รายงานจำนวนข้าราชการครูและบุคลากรทางการศึกษาที่ยังไม่ได้ QC</strong></td>
              </tr>
            <tr>
              <td width="4%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>ลำดับ</strong></td>
              <td width="34%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
              <td width="10%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>จำนวนบุคลากร<br />
                ทั้งหมดในเขต</strong></td>
              <td colspan="3" align="center" bgcolor="#D4D4D4"><strong>จำนวนที่ค้าง QC จากอัตราส่วนของการคีย์ข้อมูลแต่ละกลุ่ม</strong></td>
              <td width="10%" rowspan="2" align="center" bgcolor="#D4D4D4"><!--<strong><a href="?action=process_all">ประมวลผลดึงข้อมูลทั้งหมด</a>--></strong></td>
            </tr>
            <tr>
              <td width="12%" align="center" bgcolor="#D4D4D4"><strong>ดำเนินการ QC เรียบร้อยแล้ว</strong></td>
              <td width="14%" align="center" bgcolor="#D4D4D4"><strong>ยังไม่ได้ดำเนินการ QC</strong></td>
              <td width="16%" align="center" bgcolor="#D4D4D4"><strong>รวมค้าง QC ทั้งหมด</strong></td>
              </tr>
            <? 
			$arr1 = CountDiscountQC();
			$arrp = CountPersonAll(); // จำนวนบุคลากรทั้งหมดในเขต
				$sql = "SELECT
eduarea.secid,
eduarea.secname,
if(substring(eduarea.secid,1,1) ='0',cast(secid as SIGNED),9999) as idsite
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' group by eduarea.secid ORDER BY idsite, eduarea.secname";
		$result = mysql_db_query($dbnamemaster,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			if($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFF";}
			$num_qc_all = $arr1[$rs[secid]][1]+$arr1[$rs[secid]][0];
			$num_qcpass = $arr1[$rs[secid]][1];
			$num_qcdis = $arr1[$rs[secid]][0];
			?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$i?></td>
              <td align="left"><?=$rs[secname]?><? echo " [$rs[secid]] ";?></td>
              <td align="center"><?=number_format($arrp[$rs[secid]])?></td>
              <td align="center"><? if($num_qcpass > 0){ echo "<a href='?action=view&xtype=1&xsiteid=$rs[secid]'>".number_format($num_qcpass)."</a>"; }else{ echo "0";}?></td>
              <td align="center"><? if($num_qcdis > 0){ echo "<a href='?action=view&xtype=0&xsiteid=$rs[secid]'>".number_format($num_qcdis)."</a>"; }else{ echo "0";}?></td>
              <td align="center"><? if($num_qc_all > 0){ echo "<a href='?action=view&xtype=11&xsiteid=$rs[secid]'>".number_format($num_qc_all)."</a>"; }else{ echo "0";}?></td>
              <td align="center"><strong><a href="?action=process_site&xsiteid=<?=$rs[secid]?>">ประมวลผลรายเขต</a></strong></td>
              </tr>
            <? 
						$sum_all += $num_qc_all;
						$sum_pass += $num_qcpass;
						$sum_dis += $num_qcdis;
				}//end 	while($rs = mysql_fetch_assoc($result)){
			?>
            <tr bgcolor="<?=$bg?>">
              <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
              <td align="center" bgcolor="#CCCCCC"><strong>
                <?=number_format($sum_pass)?>
              </strong></td>
              <td align="center" bgcolor="#CCCCCC"><strong>
                <?=number_format($sum_dis)?>
              </strong></td>
              <td align="center" bgcolor="#CCCCCC"><strong>
                <?=number_format($sum_all)?>
              </strong></td>
              <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        
        <? 
		}//end if($action == ""){
			
	?>
      <tr>
       <td>&nbsp;</td>
      </tr>
    <?	
	if($action == "view"){
		if($xtype == "1"){
				$conv = " AND status_qc='1' ";
				$xtitle = "จำนวนที่ได้ QC เรียบร้อยแล้ว";
		}else if($xtype == "0"){
				$conv = " AND status_qc='0' ";
				$xtitle = "จำนวนที่ได้ค้าง QC";
		}else if($xtype == "11"){
				$conv = "";
				$xtitle = "จำนวนรวมทั้งหมด";
		}
	?>
        
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="6" align="left" bgcolor="#D4D4D4"><strong><a href="?action=">ย้อนกลับ</a> || <?=$xtitle?><?=ShowArea($xsiteid);?>|| <a href="?action=view&xtype=1&xsiteid=<?=$xsiteid?>">QC แล้ว</a> || <a href="?action=view&xtype=0&xsiteid=<?=$xsiteid?>">ยังไม่ QC</a> || <a href="?action=view&xtype=11&xsiteid=<?=$xsiteid?>">รวมทั้งหมดที่ค้าง</a></strong></td>
              </tr>
            <tr>
              <td width="4%" align="center" bgcolor="#D4D4D4"><strong>ลำดับ</strong></td>
              <td width="26%" align="center" bgcolor="#D4D4D4"><strong>เลขบัตรประจำตัวประชาชน</strong></td>
              <td width="21%" align="center" bgcolor="#D4D4D4"><strong>ชื่อ - นามสกุล</strong></td>
              <td width="18%" align="center" bgcolor="#D4D4D4"><strong>ตำแหน่ง</strong></td>
              <td width="18%" align="center" bgcolor="#D4D4D4"><strong>พนักงานคีย์ข้อมูล</strong></td>
              <td width="13%" align="center" bgcolor="#D4D4D4">&nbsp;</td>
            </tr>
            <?
			
	$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
	$e			= (!isset($e) || $e == 0) ? 50 : $e ;
	$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 

            	$sql_search = "SELECT ".DB_USERENTRY.".temp_qc.idcard, ".DB_USERENTRY.".temp_qc.staffid,
 ".DB_CHECKLIST.".tbl_checklist_kp7.prename_th,
 ".DB_CHECKLIST.".tbl_checklist_kp7.name_th,
 ".DB_CHECKLIST.".tbl_checklist_kp7.surname_th,
 ".DB_CHECKLIST.".tbl_checklist_kp7.position_now, ".DB_USERENTRY.".temp_qc.siteid, ".DB_USERENTRY.".temp_qc.status_qc
FROM ".DB_USERENTRY.".temp_qc
Inner Join  ".DB_CHECKLIST.".tbl_checklist_kp7 ON ".DB_USERENTRY.".temp_qc.idcard =  ".DB_CHECKLIST.".tbl_checklist_kp7.idcard
WHERE ".DB_USERENTRY.".temp_qc.siteid =  '$xsiteid' $conv ";


		$xresult = mysql_db_query($db_call,$sql_search);
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
		
	if($page <= $allpage){
			$sql_search .= " LIMIT $i, $e";
	}else if($page == $xpage){
		$i=0;
			$sql_search .= " ";
	}else{
			$sql_search .= " LIMIT $i, $e";
	}

				$result_search = mysql_db_query($db_name,$sql_search);
				$num_search = @mysql_num_rows($result_search);
				$search_sql = $sql_search ; 
while($rs = mysql_fetch_assoc($result_search)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	$fullname = "$rs[prename_th]$rs[name_th] $rs[surname_th]";
				
							$pathfile = "../../../../../edubkk_kp7file/$rs[siteid]/$rs[idcard]".".pdf";
							if(is_file($pathfile)){
								$pdf_file = "<a href='$pathfile' target='_blank'><img src=\"../../../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"21\" alt=\"ตรวจสอบไฟล์ pdf ต้นฉบับ\" border='0'></a>";
							}else{
								$pdf_file = "";
							}//end if(is_file($pathfile)){
						$staffname = ShowStaffKey($rs[staffid]);
						if($rs[status_qc] == 1){
								$bg = "#009900";
						}else{
								$bg = $bg;	
						}
						
						 $pdf	= "<a href=\"../../hr_report/kp7.php?id=".$rs[idcard]."&sentsecid=".$rs[siteid]."\" target=\"_blank\">";
				 			$pdf		.= "<img src=\"../../hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\"  alt='ก.พ.7 สร้างโดยระบบ '  ></a>";
			?>
            
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$i?></td>
              <td align="center"><?=$rs[idcard]?></td>
              <td align="left"><?=$fullname?></td>
              <td align="center"><?=$rs[position_now]?></td>
              <td align="left"><?=$staffname?></td>
              <td align="center"><?=$pdf_file?>&nbsp;<?=$pdf?>&nbsp;<a href="validate_keydata_temp.php?idcard=<?=$rs[idcard]?>&fullname=<?=$fullname?>&staffname=<?=$staffname?>&staffid=<?=$rs[staffid]?>&xsiteid=<?=$rs[siteid]?>" target="_blank"><img src="../../../validate_management/images/cog_edit.png" width="16" height="16" border="0" alt="คลิ๊กเพื่อบันทึกความผิดพลาดการบันทึกข้อมูล"></a></td>
            </tr>
                        <?
							}//e nd while(){
			?>

            <tr bgcolor="<?=$bg?>">
              <td colspan="6" align="center" bgcolor="#CCCCCC"><? $sqlencode = urlencode($search_sql)  ; ?>	
	<?=xdevidepage($allpage, $keyword ,$sqlencode )?></td>
              </tr>
          </table></td>
        </tr>
 <?
 
	}//end 	if($action == "view"){
?>
   
  </table></td>
          </tr>
      </table>
  </td>
    </tr>
  </table>
</body>
</html>
