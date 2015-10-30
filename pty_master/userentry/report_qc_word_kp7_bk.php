<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AdminReport";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Pairoj
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::schooll_name, login
#END
#########################################################
//session_start();
			set_time_limit(8000);
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			include("function_incentive.php");
			$flag_process = 0;
			
			$curent_date = date("Y-m-d");
			$dbnameuse = "edubkk_userentry";
			$time_start = getmicrotime();
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			
			if($sdate == ""){
					$sdate = date("d")."/".(date("m/")).(date("Y")+543);
			}
			
			
			function ConvertDate($d){
				if (!$d) return "0000-00-00";
					$arr = explode("/",$d);
					return ($arr[2]-543)."-".$arr[1]."-".$arr[0];
			}
			
			$xdate = ConvertDate($sdate);
			
			
			$txt_date = DBThaiLongDate($xdate);
			
			
	function GetDataQC($xdate){
			$year1 = (date("Y")+543)."-09-30";
			global $dbnameuse;
			
			$sql = "SELECT DISTINCT
t2.CZ_ID as idcard,
t2.prename_th,
t2.name_th,
t2.surname_th,
Sum(t1.num_point) AS numpoint,
t2.begindate,
FLOOR((TIMESTAMPDIFF(MONTH,t2.begindate,'$year1')/12)) AS age_gov,
t1.qc_staffid,
t1.qc_date ,
t2.siteid
FROM ".DB_USERENTRY.".validate_checkdata AS t1
Inner Join  ".DB_MASTER.".view_general AS t2 ON t1.idcard = t2.CZ_ID 
AND t1.qc_date = '$xdate'
Inner Join ".DB_USERENTRY.".keystaff as t3 ON t1.qc_staffid = t3.staffid and t3.status_extra='QC_WORD'
GROUP BY
t2.CZ_ID";	
//echo $sql;
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			$urlpath = "../../../edubkk_kp7file/$rs[siteid]/".$rs[idcard].".pdf";
			if(is_file($urlpath)){
				$xpdf = "<a href='$urlpath' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a>";
			}else{
				$xpdf = "";	
			}
			$arr[$rs[qc_staffid]][$rs[idcard]]['fullname'] = "$rs[prename_th]$rs[name_th]  $rs[surname_th]";
			$arr[$rs[qc_staffid]][$rs[idcard]]['numqc'] = $rs[numpoint];
			$arr[$rs[qc_staffid]][$rs[idcard]]['age'] = $rs[age_gov];
			$arr[$rs[qc_staffid]][$rs[idcard]]['pdf_org'] = $xpdf;
			$arr[$rs[qc_staffid]][$rs[idcard]]['pdf_sys'] = "<a href=\"../../application/hr3/hr_report/kp7_search.php?id=".$rs[idcard]."&sentsecid=".$rs[siteid]."\" target=\"_blank\"><img src=\"../../application/hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\" alt='ก.พ.7 สร้างโดยระบบ ' ></a>";
				
		}
		return $arr;
	}// end 	function GetDataQC($qc_date){

         

$arr_qc = GetDataQC($xdate);
//echo "<pre>";
//print_r($arr_qc);



?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript" src="../../common/jquery_1_3_2.js"></script>
<script language="javascript">

function checkAll(){
	checkall('tbldata',1);
}//end function checkAll(){

function UncheckAll(){
	checkall('tbldata',0);	
}

function checkall(context, status){	
	$("#"+context).find("input[type$='checkbox']").each(function(){
				$(this).attr('checked', status);	
	});
	
}//end function checkall(context, status){	



</script>

</HEAD>
<BODY >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px" >รายงานการตรวจคำผิดของพนักงาน</td>
        </tr>
		   <tr>
          <td class="headerTB"><form name="form1" method="post" action="">
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="14%" align="right"><strong>วันที่&nbsp;:</strong></td>
                <td width="86%" align="left"><INPUT name="sdate" onFocus="blur();" value="<?=$sdate?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.sdate, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
              </tr>
              <tr>
                <td align="right">&nbsp;</td>
                <td align="left">
                  <input type="submit" name="button2" id="button" value="แสดงรายงาน">
               </td>
              </tr>
            </table>
          </form></td>
        </tr>
		   <tr>
		     <td class="headerTB"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		       <tr>
		         <td>
		           <table width="100%" border="0" cellspacing="0" cellpadding="0">
		             <tr>
		               <td bgcolor="#000000"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		                 <tr>
                            <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                              <tr>
                                <td colspan="6" align="left" bgcolor="#94A4C5"><strong>รายงานการ QC คำผิด <? echo " วันที่ $txt_date";?></strong></td>
                                </tr>
                              <tr>
                                <td width="4%" align="center" bgcolor="#94A4C5"><strong>ลำดับ</strong></td>
                                <td width="18%" align="center" bgcolor="#94A4C5"><strong>ชื่อพนักงานตรวจคำผิด</strong></td>
                                <td width="28%" align="center" bgcolor="#94A4C5"><strong>รายชื่อชุดเอกสารที่ตรวจ</strong></td>
                                <td width="22%" align="center" bgcolor="#94A4C5"><strong>จำนวนจุดผิด</strong></td>
                                <td width="18%" align="center" bgcolor="#94A4C5"><strong>อายุราชการ</strong></td>
                                <td width="10%" align="center" bgcolor="#94A4C5">&nbsp;</td>
                              </tr>
                              <?
                              	$sql = "SELECT * FROM `keystaff` WHERE `status_extra` LIKE '%QC_WORD%' ORDER BY staffname ASC";
								$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
								$j=0;
								while($rs = mysql_fetch_assoc($result)){
									if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
							  ?>
                              <tr bgcolor="<?=$bg?>">
                                <td align="center" valign="top"><?=$j?></td>
                                <td align="left" valign="top"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname] [$rs[staffid]]";?></td>
                                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                <?
                                if(count($arr_qc) > 0){
									$arr2 = $arr_qc[$rs[staffid]];
									$k=0;
									foreach($arr2 as $key => $val){
										if ($k++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
								?>
                                  <tr bgcolor="<?=$bg?>">
                                    <td align="left">&nbsp;<?=$val['fullname']?></td>
                                  </tr>
                                  <? 
									}// foreach($arr_qc as $key => $val){
								  }// end   if(count($arr_qc) > 0){
								  ?>
                                </table></td>
                                <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                <?
                                	  if(count($arr_qc) > 0){
										$arr2_1 = $arr_qc[$rs[staffid]];
										$k1=0;
										foreach($arr2_1 as $key => $val){
												if ($k1++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
								?>
                                  <tr bgcolor="<?=$bg?>">
                                    <td align="center">&nbsp;<?=$val['numqc']?></td>
                                  </tr>
                                  <?
										}//end 
									  }
								  ?>
                                </table></td>
                                <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                <?
                                	  if(count($arr_qc) > 0){
										$arr2_2 = $arr_qc[$rs[staffid]];
										$k2=0;
										foreach($arr2_2 as $key => $val){
											if ($k2++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
								?>
                                  <tr bgcolor="<?=$bg?>">
                                    <td align="center">&nbsp;<?=$val['age']?></td>
                                  </tr>
                                  <?
										}//end 
									  }
								  ?>
                                </table></td>
                                <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                  <?
                                	  if(count($arr_qc) > 0){
										$arr2_3 = $arr_qc[$rs[staffid]];
										$k3=0;
										foreach($arr2_3 as $key => $val){
											if ($k3++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
								?>
                                  <tr bgcolor="<?=$bg?>">
                                    <td align="center"><?=$val['pdf_org']?>&nbsp;<?=$val['pdf_sys']?></td>
                                  </tr>
                                  <?
										}//end 
									  }
								  ?>
                                </table></td>
                              </tr>
                              <?
								}//end while($rs = mysql_fetch_assoc($result)){
							  ?>
                            </table></td>
                          </tr>
                          
                          <tr>
                            <td bgcolor="#FFFFFF">&nbsp;</td>
                          </tr>
                      </table></td>
	                  </tr>
	                </table>
	            </td>
	           </tr>
	         </table></td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "เวลาในการประมวลผล :: $timeprocess";
?>
