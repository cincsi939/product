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
			
			$curent_date = date("Y-m-d");
			$dbnameuse = DB_USERENTRY;
			$time_start = getmicrotime();
			$mname	= array("","�.�.", "�.�.", "��.�.", "��.�.", "�.�.", "��.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.");
			
			if($sdate == ""){
					$sdate = date("d/m/").(date("Y")+543);
			}
			
			
			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = (intval($x[0])+543);
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				return $xrs;
			}


function DateSaveDB($temp){
		if($temp != ""){
				$arr1 = explode("/",$temp);
				return ($arr1[2]-543)."-".$arr1[1]."-".$arr1[0];
		}//end 	if($temp != ""){
}// end function DateSaveDB($temp){
function DateView($temp){
	if($temp != ""){
			$arr1 = explode("-",$temp);
			return $arr1[2]."/".$arr1[1]."/".($arr1[0]+543);
	}
		
}// end function DateView($temp){


function ShowSubtract($get_date,$get_staffid){
		global $dbnameuse;
		$sqlS = "SELECT spoint  FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey='$get_date'";
		$resultS = mysql_db_query($dbnameuse,$sqlS);
		$rsS = mysql_fetch_assoc($resultS);
		return $rsS[spoint];
}//end function ShowSubtract(){
	
function ShowSubtractBdate($get_staffid,$get_date){
	global $dbnameuse;
	$sql1 = "SELECT max(spoint) AS subtarct FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND sdate <= '$get_date' AND edate >= '$get_date'";
	$result1 = mysql_db_query($dbnameuse,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	return $rs1[subtarct];
		
}//end function ShowSubtractBdate($get_staffid,$get_date){
	
function ShowSdateEdate($get_date){ 
 $arr_d1 = explode("-",$get_date);
 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d1[1]), intval($arr_d1[2]), intval($arr_d1[0]))));
 $curent_week = $xFTime["wday"];
 
 ## 1 ��� �Ţ�ѻ���� �ͧ�ѹ�ѹ���
 ## 6 ��� �Ţ�ѻ���� �ͧ�ѹ�����
	 $curent_week = $xFTime["wday"];
	 $xsdate = $curent_week -1;
	 $xedate = 6-$curent_week;
	// echo " $datereq1  :: $xsdate  :: $xedate<br>";
	 if($xsdate > 0){ $xsdate = "-$xsdate";}
	 
				
				 $xbasedate = strtotime("$get_date");
				 $xdate = strtotime("$xsdate day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// �ѹ�Ѵ�

				 $xbasedate1 = strtotime("$get_date");
				 $xdate1 = strtotime("$xedate day",$xbasedate1);
				 $xsdate1 = date("Y-m-d",$xdate1);// �ѹ�Ѵ�	
				 
				 $arr_date['start_date'] = $xsdate;
				 $arr_date['end_date'] = $xsdate1;
	return $arr_date;
}//end function ShowSdateEdate(){

##  �ѧ���蹵�Ǩ�ͺ��Ҥ�ṹź���㹪�ǧ�ѻ����
function CheckSubtractUpdate($get_staffid,$get_date){
	global $dbnameuse;
	$arrdate = ShowSdateEdate($get_date); // ���ѹ��������������ش�ͧ�����ѻ����
	$sql2 = "SELECT
max(stat_incentive.subtract) as subtract_max
FROM `stat_incentive`
WHERE
stat_incentive.staffid =  '$get_staffid' AND
stat_incentive.datekeyin BETWEEN  '".$arrdate['start_date']."' AND '".$arrdate['end_date']."'";
	$result2 = mysql_db_query($dbnameuse,$sql2);
	$rs2 = mysql_fetch_assoc($result2);
	return $rs2[subtract_max];
}	
### function update ������㹪�ǧ�ѻ����óդ��ź�����դ���ҡ���Ҥ��ź��������Ҥ��ź���� update ��¡�â�����
function ShowNumkeyPoint($get_staff,$get_date){
	global $dbnameuse;
	$arrdate = ShowSdateEdate($get_date); // ���ѹ��������������ش�ͧ�����ѻ����
	$sql_k = "SELECT
FLOOR(stat_user_keyin.numkpoint) AS kpoint,
datekeyin
FROM `stat_user_keyin`
WHERE
stat_user_keyin.datekeyin BETWEEN  '".$arrdate['start_date']."' AND '".$arrdate['end_date']."' AND
stat_user_keyin.staffid =  '$get_staff'";
	$result_k = mysql_db_query($dbnameuse,$sql_k);
	while($rs_k = mysql_fetch_assoc($result_k)){
		$arrk[$rs_k[datekeyin]] = $rs_k[kpoint];
	}//end while($rs_k = mysql_fetch_assoc($result_k)){
	return $arrk;
}//end function ShowNumkeyPoint($get_staff,$get_date){

function UpdateSubtractVal($get_staffid,$get_date,$get_val){
	global $dbnameuse,$base_point,$point_w;
	$arr_kpoint = ShowNumkeyPoint($get_staffid,$get_date);
	if(count($arr_kpoint) > 0){
		foreach($arr_kpoint as $key => $val){
			$npoint = ($val-$get_val)-$base_point;
			$kincentive = $npoint*$point_w;
			
			$sql_up = "UPDATE stat_incentive SET subtract='$get_val', net_point='$npoint', incentive='$kincentive' WHERE staffid='$get_staffid' and datekeyin='$key'";
			mysql_db_query($dbnameuse,$sql_up);	
		}//end foreach($arr_kpoint as $key => $val){	
	}//end if(count($arr_kpoint) > 0){	
}//end function UpdateSubtractVal(){ 
	  						//echo "<input type='hidden' name='arr_datekeyin[$rsv[staffid]]' value='$rsv[datekeyin]'>";
							//echo "<input type='hidden' name='arr_subtract[$rsv[staffid]]' value='$subtract_val'>";
							//echo "<input type='hidden' name='arr_net_point[$rsv[staffid]]' value='$net_kpoint'>";
							//echo "<input type='hidden' name='arr_incentive[$rsv[staffid]]' value='$Incentive_val'>";
	
if($_SERVER['REQUEST_METHOD'] == "POST" and $Aaction == "Save"){
	//echo "<pre>";
	//print_r($arr_incentive);
	if(count($arr_datekeyin) > 0){
			foreach($arr_datekeyin as $key => $val){
				$sql_replace = "REPLACE INTO stat_incentive(staffid,datekeyin,staff_approve,status_approve,subtract,net_point,incentive)VALUES('$key','$val','$staff_approve','1','$arr_subtract[$key]','$arr_net_point[$key]','$arr_incentive[$key]')";
				//echo $sql_replace."<br><br>";
				mysql_db_query($dbnameuse,$sql_replace);		
			}//end foreach($arr_datekeyin as $key => $val){				
			echo "<script>alert('�ѹ�֡��¡�����º��������'); location.href='?sdate=$sdate';</script>";
		exit;
	}//end if(count($arr_datekeyin) > 0){	
}//end if($_SERVER['REQUEST_METHOD'] == "POST" and $Aaction == "Save"){

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
          <td height="48" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px" ><a href="index_incentive.php">��Ѻ˹����ѡ</a> || ��§ҹ��äӹǳ��� Incentive ����ѹ</td>
        </tr>
		   <tr>
          <td class="headerTB"><form name="form1" method="post" action="">
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="14%" align="right"><strong>�ѹ���&nbsp;:</strong></td>
                <td width="86%" align="left"><INPUT name="sdate" onFocus="blur();" value="<?=$sdate?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.sdate, 'dd/mm/yyyy')"value="�ѹ��͹��"></td>
              </tr>
              <tr>
                <td align="right">&nbsp;</td>
                <td align="left"><label>
                  <input type="submit" name="button2" id="button" value="�ʴ���§ҹ">
                  <input type="hidden" name="Aaction" value="Search">
                </label></td>
              </tr>
            </table>
          </form></td>
        </tr>
		   <tr>
		     <td class="headerTB"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		       <tr>
		         <td><form name="form2" method="post" action="">
		           <table width="100%" border="0" cellspacing="0" cellpadding="0">
		             <tr>
		               <td bgcolor="#000000">
                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                         <tr>
                           <td align="left" bgcolor="#A5B2CE"><strong>��§ҹ��� Incentive ��Ш��ѹ���  <? $date_show = DateSaveDB($sdate); echo thaidate($date_show);?>  ��Ҥ�ṹ�ҵðҹ = 240 ��ṹ&nbsp;&nbsp;ʶҹС���Ѻ�ͧ�ʹ : </strong><? if(CheckAppriveIncentive($date_show) > 0){ echo "<img src=\"../../images_sys/approve20.png\" width=\"16\" height=\"16\" border=\"0\" title=\"ʶҹ��Ѻ�ͧ�����١��ͧ�ͧ����������\">";}else{ echo "<img src=\"../../images_sys/unapprove.png\" width=\"16\" height=\"16\" border=\"0\" title=\"�ѧ���١�Ѻ�ͧ�����١��ͧ�ͧ������\">";} ?>
                            </td>
                         </tr>
                         <? 
						  if($group_type == "A"){ 
						 	 $xsub_title = "��§ҹ��úѹ�֡�����š���� A";
						  }else if($group_type == "B"){ 
						  	$xsub_title = "��§ҹ��úѹ�֡�����š����  B";
						}else if($group_type == "C"){ 
							$xsub_title = "��§ҹ��úѹ�֡�����š���� C";
						}else{ $xsub_title = "��§ҹ��úѹ�֡�����ŷ�����";}
						 
						 ?>
                         <tr>
                           <td align="left" bgcolor="#A5B2CE"><a href="?sdate=<?=$sdate?>&group_type=A">����� A</a> ||<a href="?sdate=<?=$sdate?>&group_type=B">����� B</a> || <a href="?sdate=<?=$sdate?>&group_type=C">����� C</a> || <a href="?sdate=<?=$sdate?>&group_type=">������</a></td>
                         </tr>
                         <tr>
                           <td align="left" bgcolor="#A5B2CE"><strong><? echo $xsub_title ;?></strong></td>
                         </tr>
                       </table>
						<table width="100%" border="0" cellspacing="1" cellpadding="3" id="table0" class="sortable">
		                 <tr onMouseOver="this.style.cursor='hand'; this.style.background='#EFEFEF';" onMouseOut="this.style.cursor='point'; this.style.background='#FFFFFF';">
		                   <td width="5%" align="center" bgcolor="#A5B2CE"  class="fillcolor_menu"><strong>�ӴѺ</strong></td>
		                   <td width="28%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>���� - ���ʡ��</strong></td>
		                   <td width="14%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>��Ҥ�ṹ</strong></td>
		                   <td width="16%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>��Ҥ�ṹź</strong></td>
		                   <td width="20%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>��ṹ�ط��</strong></td>
		                   <td width="17%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>��� Incentive(�ҷ)</strong></td>
		                   </tr>
                           <?
	if($group_type == "A"){
		$cong = " AND keyin_group='1'";	
	}else if($group_type == "B"){
		$cong = " AND keyin_group='2'";	
	}else if($group_type == "C"){
		$cong = " AND keyin_group='3'";
	}else{
		$cong = "";	
	}
                           	$sql_view = "SELECT
stat_user_keyin.staffid,
stat_user_keyin.datekeyin,
stat_user_keyin.numkpoint,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname
FROM
stat_user_keyin
Inner Join keystaff ON stat_user_keyin.staffid = keystaff.staffid
WHERE
stat_user_keyin.datekeyin =  '$date_show' $cong ORDER BY stat_user_keyin.numkpoint DESC";
							$result_view = mysql_db_query($dbnameuse,$sql_view);
							$i=0;
							while($rsv = mysql_fetch_assoc($result_view)){
							if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
							
							
							
							$numkpoint = floor($rsv[numkpoint]);
							
							$subtract_val  =  ShowSubtract($rsv[datekeyin],$rsv[staffid]); // ��Ҥ�ṹ ź
							
							if($subtract_val != ""){ // �ʴ�����ա�äӹǳ���ź����
							//echo "�դ�� :: $i<br>";
								$net_kpoint = CaluateNetPoint($numkpoint,$subtract_val);
								
							}else{
								//echo "����դ�� :: $i<br>";
								$subtract_val = CalPointF($rsv[staffid],$rsv[datekeyin]);	
								$net_kpoint = CaluateNetPoint($numkpoint,$subtract_val);
							}
							
							
							
								$Incentive_val = CalulateIncentive($net_kpoint);
								
								$group_type = CheckGroupKey($rsv[staffid]);/// �������ͧ�������ѡ�ҹ�����$group_type = CheckGroupKey($rsv[staffid]);/// �������ͧ�������ѡ�ҹ�����
								if($group_type > 0){ // �ʴ�����繡���� A ��� B ����ҵ����ǧ����
								#��Ǩ�ͺ��Ҥ�ṹź���㹪�ǧ�ѻ�������ҹ����Ѻ�ͧ�ͧ�����
									$subtract_week = CheckSubtractUpdate($rsv[staffid],$rsv[datekeyin]); 
								#�ʴ���Ҥ�ṹź㹪�ǧ�ѻ����
									$subtract_val = ShowSubtractBdate($rsv[staffid],$rsv[datekeyin]); 
										if($subtract_val > 0){ // �ʴ�����դ�Ҩش�ѡ��令ٳ 3 �ش
											$subtract_val = $subtract_val*3;
										}else{
											$subtract_val = $subtract_val;
										}//end if($subtract_val > 0){
											# �óդ��ź�ҡ�š�õ�Ǩ�ͺ�����դ���ҡ�������� update ��äӹǹ�����Ҵ���
											if($subtract_val > $subtract_week){ 
											 #update ��äӹǳ��� incentive �������ͧ�ҡ�š�� QC �ش����ش�դ�ṹź�ҡ����
												UpdateSubtractVal($rsv[staffid],$rsv[datekeyin],$subtract_val);
												}//end if($subtract_val > $subtract_week){
	
								}else{
											$subtract_val = $subtract_val;
								}//end if($group_type > 0){
								
						   ?>
		                 <tr bgcolor="<?=$bg?>">
		                   <td align="center"><?=$i?></td>
		                   <td align="left"><? echo "$rsv[prename]$rsv[staffname]  $rsv[staffsurname]";?>&nbsp;&nbsp;<? echo "[$rsv[staffid]]";?></td>
		                   <td align="center"><?=number_format($numkpoint);?></td>
		                   <td align="center"><? if($subtract_val > 0){?><a href='report_subtract_qc.php?staffid=<?=$rsv[staffid]?>&datecal=<?=$rsv[datekeyin]?>&xstaffname=<? echo "$rsv[prename]$rsv[staffname]  $rsv[staffsurname]";?>' target="_blank"><?=$subtract_val;?></a><? }else{ echo "0";}?></td>
		                   <td align="center"><?=number_format($net_kpoint);?></td>
		                   <td align="right"><?=number_format($Incentive_val,2);?></td>
		                   </tr>
                          <?
						  	echo "<input type='hidden' name='arr_datekeyin[$rsv[staffid]]' value='$rsv[datekeyin]'>";
							echo "<input type='hidden' name='arr_subtract[$rsv[staffid]]' value='$subtract_val'>";
							echo "<input type='hidden' name='arr_net_point[$rsv[staffid]]' value='$net_kpoint'>";
							echo "<input type='hidden' name='arr_incentive[$rsv[staffid]]' value='$Incentive_val'>";
							if($Incentive_val > 0){ $num_incentive_all += 1;}
						
						   		$sum_Incentive_all += $Incentive_val;
							}//end while($rsv = mysql_fetch_assoc($result_view)){
						   ?>
	                    </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                              <tr>
                                <td width="83%" align="right"><strong>��� Incentive ��� : </strong></td>
                                <td width="14%" align="center"><?=number_format($sum_Incentive_all);?></td>
                                <td width="3%" align="left"><strong>�ҷ</strong></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="3">
		                     <tr>
		                       <td width="53%" align="right" bgcolor="#FFFFFF"><strong>��ѡ�ҹ��Ǩ�ͺ�ʹ: </strong></td>
		                       <td width="47%" align="left" bgcolor="#FFFFFF"><label>
		                         <select name="staff_approve" id="staff_approve">
            					<option value="">���͡���;�ѡ�ҹ</option>
                                 <?
                                 	$sql_approve = "SELECT * FROM keystaff WHERE sapphireoffice='1'";
									$result_approve = mysql_db_query($dbnameuse,$sql_approve);
									while($rs_a = mysql_fetch_assoc($result_approve)){
										$sqla1 = "SELECT COUNT(staff_approve) AS numstaff FROM stat_incentive WHERE staff_approve='$rs_a[staffid]' AND datekeyin='$date_show'";
										$result1 = mysql_db_query($dbnameuse,$sqla1);
										$rsa1 = mysql_fetch_assoc($result1);
										if($rsa1[numstaff] > 0){ $sel = "selected='selected'";}else{ $sel = "";}
										echo "  <option value='$rs_a[staffid]' $sel>$rs_a[prename]$rs_a[staffname]  $rs_a[staffsurname]</option>";
									}
								 ?>
		                           </select>
		                         </label></td>
		                       </tr>
		                     <tr>
		                       <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
		                       <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
		                       </tr>
		                     <tr>
		                       <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
		                       <td align="left" bgcolor="#FFFFFF">
                               <input type="submit" name="button3" id="button2" value="�ѹ�֡">
                               <input type="hidden" name="Aaction" value="Save">
                               <input type="hidden" name="sdate" value="<?=$sdate?>">
                               </td>
		                       </tr>
		                     </table></td>
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