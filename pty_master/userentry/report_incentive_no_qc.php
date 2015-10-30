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
			include("../../config/conndb_nonsession.inc.php");
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
			$curent_date = date("Y-m-d");
			$dbnameuse = "edubkk_userentry";
			$time_start = getmicrotime();
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
	function CheckQCWeek($get_staffid,$get_sdate,$get_edate){
			global $dbnameuse;
			//$sql_1 = "SELECT SUM(num_p) as nump FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey BETWEEN '$get_sdate' AND '$get_edate' ";
			$sql_1 = "SELECT count(spoint) as nump  FROM stat_subtract_keyin_avg WHERE staffid='$get_staffid' AND datekey BETWEEN '$get_sdate' AND '$get_edate' ";
			$result_1 = mysql_db_query($dbnameuse,$sql_1);
			$rs_1 = mysql_fetch_assoc($result_1);
			return $rs_1[nump];
	}//end function CheckQCWeek(){

?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT SRC="sorttable.js"></SCRIPT>
<script language="javascript">

</script>
</HEAD>
<BODY >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px" >รายงานคนที่ไม่ได้ รับรองข้อมูลในช่วงสัปดาห์</td>
        </tr>
		   <tr>
          <td class="headerTB"><a href="?g_type=1">กลุ่ม A </a>|| <a href="?g_type=2">กลุ่ม B</a></td>
        </tr>
		   <tr>
		     <td class="headerTB"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		       <tr>
		         <td><form name="form2" method="post" action="">
		           <table width="100%" border="0" cellspacing="0" cellpadding="0">
		             <tr>
		               <td bgcolor="#000000"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		                 <tr>
                            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                              <tr>
                                <td width="5%" rowspan="2" align="center" bgcolor="#727B85"><strong>ลำดับ</strong></td>
                                <td width="23%" rowspan="2" align="center" bgcolor="#727B85"><strong>ชื่อนามสกุล</strong></td>
                                <td colspan="5" align="center" bgcolor="#727B85"><strong>รายงานคนที่ไม่ได้รับรองข้อมูลในช่วงสัปดาห์</strong></td>
                                </tr>
                              <tr>
                                <td width="14%" align="center" bgcolor="#727B85"><strong>สัปดาห์ที่ 1</strong></td>
                                <td width="16%" align="center" bgcolor="#727B85"><strong>สัปดาห์ที่ 2</strong></td>
                                <td width="14%" align="center" bgcolor="#727B85"><strong>สัปดาห์ที่ 3</strong></td>
                                <td width="17%" align="center" bgcolor="#727B85"><strong>สัปดาห์ที่ 4</strong></td>
                                <td width="11%" align="center" bgcolor="#727B85"><strong>สัปดาห์ที่ 5</strong></td>
                              </tr>
                              <?
							  		if($g_type == ""){
										$cont = " WHERE keystaff.keyin_group='1' OR keystaff.keyin_group='2' ";	
									}else if($g_type == "1"){
										$cont = " WHERE keystaff.keyin_group='1'";	
									}else if($g_type == "2"){
										$cont = " WHERE keystaff.keyin_group='2'";	
									}
                              	$sql = "SELECT * FROM keystaff  $cont  ORDER BY keystaff.staffname ASC";
								$result = mysql_db_query($dbnameuse,$sql);
								$i++;
								while($rs = mysql_fetch_assoc($result)){
										if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
									$week1 = CheckQCWeek($rs[staffid],"2010-03-01","2010-03-06");
									$week2 = CheckQCWeek($rs[staffid],"2010-03-08","2010-03-13");
									$week3 = CheckQCWeek($rs[staffid],"2010-03-15","2010-03-20");
									$week4 = CheckQCWeek($rs[staffid],"2010-03-22","2010-03-27");
									$week5 = CheckQCWeek($rs[staffid],"2010-03-29","2010-03-31");
									if($rs[keyin_group] == 1){
										if($week1 < 1){  $bg1 = "#FF0000";}else{ $bg1 = $bg;}	
										if($week2 < 1){  $bg2 = "#FF0000";}else{ $bg2 = $bg;}	
										if($week3 < 1){  $bg3 = "#FF0000";}else{ $bg3 = $bg;}	
										if($week4 < 1){  $bg4 = "#FF0000";}else{ $bg4 = $bg;}	
										if($week5 < 1){  $bg5 = "#FF0000";}else{ $bg5 = $bg;}	
									}else if($rs[keyin_group] == 2){
										if($week1 < 1){  $bg1 = "#FF0000";}else{ $bg1 = $bg;}	
										if($week2 < 1){  $bg2 = "#FF0000";}else{ $bg2 = $bg;}	
										if($week3 < 1){  $bg3 = "#FF0000";}else{ $bg3 = $bg;}	
										if($week4 < 1){  $bg4 = "#FF0000";}else{ $bg4 = $bg;}	
										if($week5 < 1){  $bg5 = "#FF0000";}else{ $bg5 = $bg;}	
									}
									
							  ?>
                              <tr bgcolor="<?=$bg?>">
                                <td align="center"><?=$i?></td>
                                <td align="left"><? echo "$rs[prename]$rs[staffname]   $rs[staffsurname] [$rs[staffid]]";?></td>
                                <td align="center" bgcolor="<?=$bg1?>"><?=$week1?></td>
                                <td align="center" bgcolor="<?=$bg2?>"><?=$week2?></td>
                                <td align="center" bgcolor="<?=$bg3?>"><?=$week3?></td>
                                <td align="center" bgcolor="<?=$bg4?>"><?=$week4?></td>
                                <td align="center" bgcolor="<?=$bg5?>"><?=$week5?></td>
                              </tr>
                              <?
								}//end 
							  ?>
                            </table></td>
                          </tr>
                          <tr>
                            <td bgcolor="#FFFFFF">&nbsp;</td>
                          </tr>
                          <tr>
                            <td bgcolor="#FFFFFF">&nbsp;</td>
                          </tr>
                        </table></td>
	                  </tr>
	                </table>
	             </form></td>
	           </tr>
	         </table></td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>