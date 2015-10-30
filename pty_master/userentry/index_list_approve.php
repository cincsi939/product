<?
$ApplicationName	= "diagnosticv1_test";
$module_code 		= "diagnosticv1_test"; 
$process_id			= "diagnostic";
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
	## Modified Detail :		ระบบตรวจสอบรับรองความถูกต้องของข้อมูล
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################

set_time_limit(0);
/*include ("../../../../config/conndb_nonsession.inc.php")  ;
include("../../../../common/common_competency.inc.php");
include("../../../../common/class.loadpage.php");
include('function_checkdata.inc.php') ;
include('function_getdate_face.php') ;
include('function_getdate_keyin.php') ;*/




$time_start = getmicrotime();

function Xdevidepage($total, $kwd , $sqlencode ){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page,$site_id,$action,$xtype,$key_staffname,$key_staffsurname;

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
			$table .= "<a href=\"?page=1&site_id=$site_id&xtype=$xtype&key_staffname=$key_staffname&key_staffsurname=$key_staffsurname&action=$action&displaytype=people".$kwd."\"><u><font color=\"black\">หน้าแรก</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?page=".$i."&site_id=$site_id&xtype=$xtype&key_staffname=$key_staffname&key_staffsurname=$key_staffsurname&action=$action&displaytype=people". $kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?page=".$page_all."&site_id=$site_id&xtype=$xtype&key_staffname=$key_staffname&key_staffsurname=$key_staffsurname&action=$action&displaytype=people". $kwd."\"><u><font color=\"black\">หน้าสุดท้าย</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?page=".($page_all+1)."&site_id=$site_id&xtype=$xtype&key_staffname=$key_staffname&key_staffsurname=$key_staffsurname&action=$action&displaytype=people". $kwd."\"><u><font color=\"black\">แสดงทั้งหมด</font></u></a>";
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



###### ข้อมูลห้องคีย์ข้อมูลจากระบบ face
$arrsite = GetSiteKeyData();
ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานสำหรับรับรองการคีย์ข้อมูล ก.พ.7 สำหรับพนักงานที่เป็น supervisor</title>
<LINK href="../../../../common/style.css" rel=stylesheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>


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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td colspan="3" align="left" bgcolor="#A5B2CE"><strong>SiteName : <? if($site_id == "999"){ echo "SubContact";}else{ echo $arrsite[$site_id];}?></strong></td>
            </tr>
            <?
			$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
			$e			= (!isset($e) || $e == 0) ? 10 : $e ;
			$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 


			if($key_staffname != ""){
					$constaff1 .= " AND staffname LIKE '%$key_staffname%' ";
			}
			if($key_staffsurname != ""){
					$constaff1 .= " AND staffsurname LIKE '%$key_staffsurname%' ";
			}
			
            if($site_id != ""){
			if($site_id  == "999"){// กรณีเป็น SUb
				$conv1 = " AND sapphireoffice='2'";
			}else{
					if($site_id == "8"){ // pattime
						$conv1 = " AND  sapphireoffice='0' AND keyin_group > '0' AND period_time='pm' ";		
					}else{
						$conv1 = " AND  sapphireoffice='0' AND keyin_group > '0' AND period_time='am'";	
					}// end if($site_id == "8"){ // pattime
				    $in_pin = GetPinStaff($site_id);
					if($in_pin != ""){ $conv2 = " AND card_id IN($in_pin)";}else{ $conv2 = "";}
					ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			}
	}
	
	##########################
	$in_staffid = GetStaffidFormData("$key_idcard","$key_name_th","$key_surname_th");
	if($in_staffid != ""){
			$constaff = " AND staffid IN($in_staffid) ";
	}else{
			$constaff = "";
	}//end if($in_staffid != ""){
	
	
	$sql_search = "SELECT
staffid,
prename,
staffname,
staffsurname,
keyin_group
FROM  keystaff
WHERE  status_permit='YES' AND status_extra='NOR' 
$conv1 $conv2 $constaff1 $constaff
GROUP BY staffid
ORDER BY staffname,staffsurname ASC ";
//echo "<hr>".$sql_search."</hr>";
		$xresult = mysql_db_query($dbnameuse,$sql_search) or die(mysql_error()."$sql_search<br>LINE::".__LINE__);
		$all= mysql_num_rows($xresult);
		
		
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

			$result = mysql_db_query($dbnameuse,$sql_search) or die(mysql_error()."$sql<br>LINE::".__LINE__);
			$num_staff = mysql_num_rows($result);
			while($rs = mysql_fetch_assoc($result)){
				$arrstaff_key[$rs[staffid]] = "$rs[prename]$rs[staffname]  $rs[staffsurname]";
				//$arr_list = GetDataKp7Key($rs[staffid]);
				$arr_list = GetDataKp7Key($rs[staffid],"$key_idcard","$key_name_th","$key_surname_th");
				if(count($arr_list) > 0){
					
					foreach($arr_list as $k => $v){
						
						$arrdata[$rs[staffid]][$k]['numall']  = $v['numall'];
						$arrdata[$rs[staffid]][$k]['noapprove']  = $v['noapprove'];
						$arrdata[$rs[staffid]][$k]['key_approve']  = $v['key_approve'];
						$arrdata[$rs[staffid]][$k]['sys_approve']  = $v['sys_approve'];
						$arrdata[$rs[staffid]][$k]['wait_approve']  = $v['wait_approve'];
						$arrdata[$rs[staffid]][$k]['sup_approve']  = $v['sup_approve'];
						$arrdata[$rs[staffid]][$k]['date_ticketid']  = $v['date_ticketid'];
					}//end foreach($arr_list as $k => $v){
				}//end if(count($arr_list) > 0){
			}// end while($rs = mysql_fetch_assoc($result)){
				
	unset($arr_list);
	if(count($arrdata) > 0){
		foreach($arrdata as $key => $val){
			foreach($val as $key1 => $val1){
				$sum_numticket += 1;
				$sum_numall += $val1['numall'];
				$sum_noapprove += $val1['noapprove'];
				$sum_key_approve += $val1['key_approve'];
				$sum_sys_approve += $val1['sys_approve'];
				$sum_wait_approve += $val1['wait_approve'];
				$sum_sup_approve += $val1['sup_approve'];	
			}// end foreach($val as $key1 => $val1){
		}//end foreach($arrdata as $key => $val){
	}// end if(count($arrdata) > 0){	
			?>
          <tr>
            <td width="40%" align="left" bgcolor="#FFFFFF"><strong>จำนวนพนักงานทั้งหมด</strong></td>
            <td width="27%" align="center" bgcolor="#FFFFFF"><?=number_format($num_staff)?></td>
            <td width="33%" align="left" bgcolor="#FFFFFF"><strong>คน</strong></td>
            </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF"><strong>จำนวนใบงานทั้งหมด</strong></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($sum_numticket)?></td>
            <td align="left" bgcolor="#FFFFFF"><strong>ใบงาน</strong></td>
            </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF"><strong>ชุดเอกสารทั้งหมด</strong></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($sum_numall)?></td>
            <td align="left" bgcolor="#FFFFFF"><strong>ชุด</strong></td>
            </tr>
          <tr>
            <td align="left" bgcolor="#E1E1E1"><strong>บันทึกข้อมูลแล้วเสร็จ</strong></td>
            <td align="center" bgcolor="#E1E1E1"><?=number_format($sum_key_approve)?></td>
            <td align="left" bgcolor="#E1E1E1"><strong>ชุด คิดเป็นร้อยละ  <? if($sum_numall > 0){ echo number_format(($sum_key_approve*100)/$sum_numall,2);}?></strong></td>
            </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;&nbsp;- รับรองโดยระบบอัตโนมัติ</strong></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($sum_sys_approve)?></td>
            <td align="left" bgcolor="#FFFFFF"><strong>ชุด คิดเป็นร้อยละ <? if($sum_key_approve > 0){ echo number_format(($sum_sys_approve*100)/$sum_key_approve,2);}?></strong></td>
            </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;&nbsp;- รอตรวจสอบ</strong></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($sum_wait_approve)?></td>
            <td align="left" bgcolor="#FFFFFF"><strong>ชุด คิดเป็นร้อยละ <? if($sum_key_approve > 0){ echo number_format(($sum_wait_approve*100)/$sum_key_approve,2);}?></strong></td>
            </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;&nbsp;- ตรวจสอบแล้ว</strong></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($sum_sup_approve)?></td>
            <td align="left" bgcolor="#FFFFFF"><strong>ชุด คิดเป็นร้อยละ <? if($sum_key_approve > 0){ echo number_format(($sum_sup_approve*100)/$sum_key_approve,2);}?></strong></td>
            </tr>
          <tr>
            <td align="left" bgcolor="#E1E1E1"><strong>ผลการตรวจสอบ</strong></td>
            <td align="center" bgcolor="#E1E1E1"><?=number_format($sum_sup_approve+$sum_sys_approve)?></td>
            <td align="left" bgcolor="#E1E1E1"><strong>ชุด คิดเป็นร้อยละ <? if($sum_key_approve > 0){ echo number_format((($sum_sup_approve+$sum_sys_approve)*100)/$sum_key_approve,2);}?></strong></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
    <tr>
      <td align="right" valign="middle" bgcolor="#FFFFFF"><A href="#" onClick="window.open('popup_search.php?action=<?=$action?>&site_id=<?=$site_id?>&key_staffname=<?=$key_staffname?>&key_staffsurname=<?=$key_staffsurname?>','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=500,height=350');">คลิ๊กเพื่อค้นหา<img src="../../../../application/validate_management/images/cog_edit.png" width="16" height="16" border="0" title="คลิ๊กเพื่อกำหนดโฟร์ไฟล์ข้อมูล"></A>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="9" align="center" bgcolor="#A5B2CE"><strong>รายงานสำหรับการรับรองความถูกต้องของข้อมูลสำหรับ Supervisor</strong></td>
        </tr>
      <tr>
        <td width="3%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="13%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>พนักงานคีย์ข้อมูล</strong></td>
        <td width="23%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>ใบงาน/ชุด</strong></td>
        <td width="13%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>วันที่ใบงาน</strong></td>
        <td width="8%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>บันทึกข้อมูล<br />
          แล้วเสร็จ(ชุด)</strong></td>
        <td width="10%" rowspan="2" align="center" bgcolor="#A5B2CE"><p><strong>รับรองโดย<br />ระบบอัตโนมัติ(ชุด)</strong></p></td>
        <td colspan="2" align="center" bgcolor="#A5B2CE"><strong>การตรวจสอบโดย Supervisor (ชุด)</strong></td>
        <td width="10%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>ผลการตรวจสอบ(ชุด)</strong></td>
      </tr>
      <tr>
        <td width="10%" align="center" bgcolor="#A5B2CE"><strong>รอตรวจสอบ(ชุด)</strong></td>
        <td width="10%" align="center" bgcolor="#A5B2CE"><strong>ตรวจสอบแล้ว(ชุด)</strong></td>
        </tr>
        <?

			if(count($arrstaff_key) > 0){
				
			$j=0;
			foreach($arrstaff_key as $key => $staffname){
			$i++;
			echo "<tr bgcolor='#999999'><td align='center'>$i</td><td align='left' colspan='8' >".$staffname."[$key]</td></tr>";
			if(count($arrdata[$key]) > 0){
				//$i=0;
				foreach($arrdata[$key] as $k1 => $v1){
					if($i% 2){$bg = "#F0F0F0";}else{$bg = "#FFFFFF";} 	$j++;
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center" colspan="2"><? echo $i.".".$j;?></td>
        <td align="center"><? echo "<a href='../../../../application/userentry/assign_print_detail.php?ticketid=$k' target='_blank'>$k1</a> / "; if($v1['numall'] > 0){ echo "<a href='list_ticket_approve.php?ticketid=$k1&staffid=$key&xtype=all' target='_blank'>".number_format($v1['numall'])."</a>";}else{ echo "0";}?></td>
        <td align="center"><? echo $v1['date_ticketid']?></td>
        <td align="center"><? if($v1['key_approve'] > 0){echo "<a href='list_ticket_approve.php?ticketid=$k1&staffid=$key&xtype=key_approve' target='_blank' >".number_format($v1['key_approve'])."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($v1['sys_approve'] > 0){echo "<a href='list_ticket_approve.php?ticketid=$k1&staffid=$key&xtype=sys_approve' target='_blank' >".number_format($v1['sys_approve'])."</a>";}else{ echo "0";}?></td>
        <td align="center"><?  if($v1['wait_approve'] > 0){ echo "<a href='list_ticket_approve.php?ticketid=$k1&staffid=$key&xtype=wait' target='_blank' >".number_format($v1['wait_approve'])."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($v1['sup_approve'] > 0){ echo "<a href='list_ticket_approve.php?ticketid=$k1&staffid=$key&xtype=sup_approve' target='_blank' >".number_format($v1['sup_approve'])."</a>";}?></td>
        <td align="center"><? $all_approve =$v1['sup_approve']+$v1['sys_approve']; if($all_approve > 0){ echo "<a href='list_ticket_approve.php?ticketid=$k1&staffid=$key&xtype=all_approve' target='_blank' >".number_format($all_approve)."</a>";}else{ echo "0";}?></td>
      </tr>
      <?
				$sum1 += $v1['key_approve'];
				$sum2 += $v1['sys_approve'];
				$sum3 += $v1['wait_approve'];
				$sum4 += $v1['sup_approve'];
				$sum5 += $v1['sup_approve']+$v1['sys_approve'];
				}//end 	foreach($arr_list as $k1 => $v1){
		
			?>
        <tr bgcolor="#CCCCCC">
        <td align="right" colspan="4"><strong>รวม :</strong></td>
        <td align="center"><strong><? echo number_format($sum1);?></strong></td>
        <td align="center"><strong><? echo number_format($sum2);?></strong></td>
        <td align="center"><strong><? echo number_format($sum3);?></strong></td>
        <td align="center"><strong><? echo number_format($sum4);?></strong></td>
        <td align="center"><strong><? echo number_format($sum5);?></strong></td>
      </tr>
            <?
						}//end 		foreach($arrdata[$key] as $k1 => $v1){
				$sum1 = 0;$sum2 = 0;$sum3 = 0;$sum4 = 0;$sum5 = 0;
				unset($arr_list);
			}//end foreach($arrstaff as $key => $val){
			}//end if(count($arrstaff) > 0){
				 unset($in_pin);
				 unset($arrdata);
	  ?>
        <tr bgcolor="#FFFFFF">
        <td align="center" colspan="9"><? $sqlencode = urlencode($search_sql)  ; ?>	
	<?=Xdevidepage($allpage, $keyword ,$sqlencode )?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
