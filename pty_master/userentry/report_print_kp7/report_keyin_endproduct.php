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
			include("function_face2cmss.php");
			
			
			$point_per_doc = 69; // ค่าคะแนต่อชุด
			$arrsite = GetSiteKeyData();
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			if($compare_id == ""){
					$compare_id = 2;
			}
			
			if($mm1 == ""){
					$mm1 = intval(date("m"))-1;
			}
			if($mm2 == ""){
					$mm2 = intval(date("m"));	
			}
			if($yy1 == ""){
					$yy1 = date("Y")+543;
			}
			
			if($yy2 == ""){
					$yy2 = date("Y")+543;
			}
			
			if($site_id == ""){
				$site_id = "999";
			}

			
			  $date_dis = (date("Y")+543)-2; // ปีย้อนหลัง
			 $idcard_ex = GetCard_idExcerent();// เลขบัตรประจำตัวประชาชนของกลุ่ม excerent
			 
	############################# function แสดงผลผลิตต่อกลุ่ม #####################	 
	function GetDataGroupE($site_id,$compare_id,$date1,$date2=""){
		global $dbnameuse,$idcard_ex,$point_per_doc;
		if($compare_id == "2"){
			$conid = " AND t2.datekeyin LIKE '$date1%'";
			if($idcard_ex != ""){
				$conid .= "  AND t1.card_id IN($idcard_ex)";
			}//end if($idcard_ex != ""){
		}else{
			$conid = " AND t2.datekeyin between '$date1' AND '$date2'";	
			if($idcard_ex != ""){
				$conid .= "  AND t1.card_id IN($idcard_ex)";
			}//end if($idcard_ex != ""){
		}//end if($compare_id == "2"){
				if($site_id != "999"){
					$in_pin = GetPinStaff($site_id);
					ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 	
					if($in_pin != ""){
						$con1 = " AND t1.card_id IN($in_pin)";	
					}else{
						$con1 = " AND t1.staffid=''";	
					}
				}//end if($site_id != "999"){
			
		$sql = "SELECT
		count(distinct t1.staffid) as numstaff
FROM
 keystaff as t1
 INNER JOIN stat_user_keyin AS t2 ON t1.staffid=t2.staffid
where  t1.keyin_group='2' and t1.period_time='am' and t1.status_permit='YES'  $conid $con1
group by  t1.keyin_group";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<BR>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);


$sql2 = "SELECT
sum(t2.numkpoint) as numpoint,
sum(t3.spoint*( if(t3.spoint > 0 and (t3.point_ratio < 1 or t3.point_ratio IS NULL),1,t3.point_ratio))) as sub_numpoint
FROM
keystaff as t1 Inner Join 
stat_user_keyin as t2  ON t1.staffid=t2.staffid
left Join stat_subtract_keyin as t3 ON t2.datekeyin = t3.datekey AND t2.staffid = t3.staffid
where t1.keyin_group='2' and t1.period_time='am'  $conid $con1 ";
$result2 = mysql_db_query($dbnameuse,$sql2) or die(mysql_error()."$sql2<br>LINE__".__LINE__);
$rs2 = mysql_fetch_assoc($result2);
	$arr['numstaff'] = $rs[numstaff];	
	$arr['numpoint'] = $rs2[numpoint];
	$arr['sub_numpoint'] = $rs2[sub_numpoint];
	
	return $arr;		
	}// end 	function GetDataGroupE($site_id,$compare_id,$date1,$date2=""){
		
function GetDataGroupL($site_id,$compare_id,$date1,$date2=""){
		global $dbnameuse,$idcard_ex,$point_per_doc;
		if($compare_id == "2"){
			$conid = "AND t2.datekeyin LIKE '$date1%'";
			if($idcard_ex != ""){
				$conid .= "  AND t1.card_id NOT IN($idcard_ex)";
			}//end if($idcard_ex != ""){
		}else{
			$conid = "AND t2.datekeyin between '$date1' AND '$date2'";	
			if($idcard_ex != ""){
				$conid .= "  AND t1.card_id NOT IN($idcard_ex)";
			}//end if($idcard_ex != ""){
		}//end if($compare_id == "2"){
			
			if($site_id != "999"){
					$in_pin = GetPinStaff($site_id);
					ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 	
					if($in_pin != ""){
						$con1 = " AND t1.card_id IN($in_pin)";	
					}else{
						$con1 = " AND t1.staffid=''";	
					}
				}//end if($site_id != "999"){
/*		$sql = "SELECT
Sum(t2.numkpoint)/$point_per_doc AS numpoint,
COUNT(distinct t2.staffid) AS numstaff
FROM
 keystaff as t1
Inner Join
stat_user_keyin AS t2
 ON t1.staffid = t2.staffid
where  t1.keyin_group='2' and t1.period_time='am' and t1.status_permit='YES'  $conid $con1
group by  t1.keyin_group";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<BR>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);*/
	
	
	
	$sql = "SELECT
		count(distinct t1.staffid) as numstaff
FROM
 keystaff as t1
 INNER JOIN stat_user_keyin AS t2 ON t1.staffid=t2.staffid
where  t1.keyin_group='2' and t1.period_time='am' and t1.status_permit='YES'   $conid $con1
group by  t1.keyin_group";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<BR>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);


$sql2 = "SELECT
sum(t2.numkpoint) as numpoint,
sum(t3.spoint*( if(t3.spoint > 0 and (t3.point_ratio < 1 or t3.point_ratio IS NULL),1,t3.point_ratio))) as sub_numpoint
FROM
keystaff as t1  Inner Join
stat_user_keyin as t2 ON  t1.staffid=t2.staffid
left Join stat_subtract_keyin as t3 ON t2.datekeyin = t3.datekey AND t2.staffid = t3.staffid
where t1.keyin_group='2' and t1.period_time='am'  $conid $con1 ";
$result2 = mysql_db_query($dbnameuse,$sql2) or die(mysql_error()."$sql2<br>LINE__".__LINE__);
$rs2 = mysql_fetch_assoc($result2);
	
	
	$arr['numstaff'] = $rs[numstaff];	
	$arr['numpoint'] = $rs2[numpoint];
	$arr['sub_numpoint'] = $rs2[sub_numpoint];
	
	return $arr;		
	}// end 	function GetDataGroupE($site_id,$compare_id,$date1,$date2=""){

function GetDataGroupN($site_id,$compare_id,$date1,$date2=""){
	global $dbnameuse,$point_per_doc;
	if($compare_id == "2"){
		$conid = " AND t2.datekeyin LIKE '$date1%'";
	}else{
		$conid = " AND t2.datekeyin between '$date1' AND '$date2'";	
	}//end if($compare_id == "2"){
					if($site_id != "999"){
					$in_pin = GetPinStaff($site_id);
					ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 	
					if($in_pin != ""){
						$con1 = " AND t1.card_id IN($in_pin)";	
					}else{
						$con1 = " AND t1.staffid=''";	
					}
				}//end if($site_id != "999"){
	
	


$sql = "SELECT
t1.ratio_id as rpoint,
sum(t2.numkpoint) as numpoint,
sum(t3.spoint*( if(t3.spoint > 0 and (t3.point_ratio < 1 or t3.point_ratio IS NULL),1,t3.point_ratio))) as sub_numpoint
FROM
keystaff as t1  Inner Join
stat_user_keyin as t2 ON  t1.staffid=t2.staffid
left Join stat_subtract_keyin as t3 ON t2.datekeyin = t3.datekey AND t2.staffid = t3.staffid
where t1.keyin_group='3' and t1.period_time='am'  $conid $con1	
group by 
t1.ratio_id";
//echo $sql."<hr>";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<BR>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
	$arr[$rs[rpoint]]['numpoint'] = $rs[numpoint];
	$arr[$rs[rpoint]]['sub_numpoint'] = $rs[sub_numpoint];
	
}//end while($rss = mysql_fetch_assoc($result_staff)){
	
	
		$sql2 = "SELECT
		t1.ratio_id as rpoint,
		count(distinct t1.staffid) as numstaff
FROM
 keystaff as t1
 INNER JOIN stat_user_keyin AS t2 ON t1.staffid=t2.staffid
where  t1.keyin_group='3' and t1.period_time='am' and t1.status_permit='YES'   $conid $con1
group by t1.ratio_id";
//echo $sql2."<br>";
	$result2 = mysql_db_query($dbnameuse,$sql2) or die(mysql_error()."$sql<BR>LINE::".__LINE__);
	while($rs2 = mysql_fetch_assoc($result2)){
		$arr[$rs2[rpoint]]['numstaff'] = $rs2[numstaff]	;
	}


	//echo "<pre>";
	//print_r($arr);
	
	return $arr;		
}// end 	function GetDataGroupE($site_id,$compare_id,$date1,$date2=""){


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


function CheckForm(){
	
if(document.form1.compare_id1.checked == true){
	var d1 = document.form1.s_data1.value;
	var d2 =  document.form1.s_data2.value;
	var d3 =  document.form1.e_data1.value
	var d4 = document.form1.e_data2.value
	// วันที่ที่ 1
	arr1 = d1.split("/");
	v1 = arr1[2]+""+arr1[1]+""+arr1[0];
	// วันที่ที่ 2
	arr2 =  d2.split("/");
	v2 = arr2[2]+""+arr2[1]+""+arr2[0];
	
	arr3 =  d3.split("/");
	v3 = arr3[2]+""+arr3[1]+""+arr3[0];
	
	arr4 =  d4.split("/");
	v4 = arr4[2]+""+arr4[1]+""+arr4[0];
		if(v2 < v1){
				alert("วันที่สิ้นสุดส่วนหน้าต้องไม่น้อยกว่าวันที่เริ่มต้น");
				document.form1.s_data2.focus();
				return false;
		}
		if(v4 < v3){
				alert("วันที่สิ้นสุดส่วนหลังต้องไม่น้อยกว่าวันที่เริ่มต้น");
				document.form1.s_data2.focus();
				return false;
		}
		
	return true;	
	}else if(document.form1.compare_id2.checked == true){
	var m1 = document.form1.mm1.value;
	var y1 =  document.form1.yy1.value;
	var m2 =  document.form1.mm2.value
	var y2 = document.form1.yy2.value	
		val1 = y1+""+m1;
		val2 = y2+""+m2;
		if(val2 < val1){
				alert("เดือนปีสิ้นสุดต้องไม่น้อยกว่าเดือนปีเริ่มต้น");
				document.form1.yy2.focus();
				return false
		}
			
		return true;
	}//end if(document.form1.compare_id1.checked == true){
		
}//end function CheckForm(){
	

function CheckR1(){
		document.form1.compare_id1.checked = true;
}

function CheckR2(){
		document.form1.compare_id2.checked = true;
}

</script>

</HEAD>
<BODY >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px" >รายงานตรวจสอบผลผลิตการ key ข้อมูลแยกรายกลุ่มพนักงาน</td>
        </tr>
        <form name="form1" method="post" action="" onSubmit="return CheckForm()">
		   <tr>
          <td bgcolor="#000000" >
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="10%" align="right" bgcolor="#A5B2CE"><strong>ศูนย์การคีย์ข้อมูล : </strong></td>
                <td width="90%" align="left" bgcolor="#A5B2CE">
                  <select name="site_id" id="site_id">
                  <option value="999">เลือกทั้งหมด</option>
                  <?
                  	if(count($arrsite) > 0){
						foreach($arrsite as $key => $val){
							if($site_id == $key){ $sel = " selected='selected''";}else{ $sel = "";}
							echo "<option value='$key' $sel>$val</option>";
						}
							
					}//end 	if(count($site_id) > 0){
				  ?>
                  </select>
                  </td>
              </tr>
              <tr>
                <td align="right" bgcolor="#A5B2CE"><input type="radio" name="compare_id" id="compare_id1" value="1" <? if($compare_id == "1"){ echo " checked";}?> > </td>
                <td align="left" bgcolor="#A5B2CE"><strong>การเปรียบเทียบระหว่างวัน</strong></td> 
              </tr>
              <tr>
                <td align="right" bgcolor="#A5B2CE">&nbsp;</td>
                <td align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                  <tr>
                    <td width="19%" align="left"><INPUT name="s_data1" onFocus="blur();" value="<?=$s_data1?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.s_data1, 'dd/mm/yyyy');return CheckR1();"value="วันเดือนปี"></td>
                    <td width="2%" align="center"><strong>ถึง</strong></td>
                    <td width="20%" align="left"><INPUT name="s_data2" onFocus="blur();" value="<?=$s_data2?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.s_data2, 'dd/mm/yyyy');return CheckR1();"value="วันเดือนปี"></td>
                    <td width="11%" align="center">&nbsp;</td>
                    <td width="8%"></td>
                    <td width="2%" align="center">&nbsp;</td>
                    <td width="38%"></td>
                    </tr>
                  <tr>
                    <td colspan="3" align="center"><b>เปรียบเทียบกับ</b></td>
                    <td align="center">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left"><INPUT name="e_data1" onFocus="blur();" value="<?=$e_data1?>" size="15" readOnly>
                      <INPUT name="button3" type="button"  onClick="popUpCalendar(this, form1.e_data1, 'dd/mm/yyyy');return CheckR1();"value="วันเดือนปี"></td>
                    <td align="center"><strong>ถึง</strong></td>
                    <td align="left"><INPUT name="e_data2" onFocus="blur();" value="<?=$e_data2?>" size="15" readOnly>
                      <INPUT name="button4" type="button"  onClick="popUpCalendar(this, form1.e_data2, 'dd/mm/yyyy');return CheckR1();"value="วันเดือนปี"></td>
                    <td align="center">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#A5B2CE"><input type="radio" name="compare_id" id="compare_id2" value="2" <? if($compare_id == "2"){ echo " checked";}?>>
                  </td>
                <td align="left" bgcolor="#A5B2CE"><strong>การเปรียบเทียบระหว่างเดือน</strong></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#A5B2CE">&nbsp;</td>
                <td align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                  <tr>
                    <td width="19%" align="left"><strong>เดือน</strong>
                      <select name="mm1" id="mm1" onClick="return CheckR2();">
                        <option value="">เลือกเดือน</option>
                        <?
                      	if(count($monthname) > 0){
								foreach($monthname as $km => $vm){
									if($km != ""){
										if($mm1 == $km){ $sel = "selected='selected'";}else{ $sel = "";}
										echo "<option value='$km' $sel>$vm</option>";
									}//end if($km != ""){
								}
						}
					  ?>
                      </select></td>
                    <td width="12%" align="left"><strong>ปี</strong>
                      <select name="yy1" id="yy1" onClick="return CheckR2();">
                        <option value="">เลือกปี</option>
                        <?
					
                      	for($y1=(date("Y")+543);$y1 > $date_dis;$y1--){
							if($y1 == $yy1){ $sel = "selected='selected'";}else{ $sel = "";}
							echo "<option value='$y1' $sel>$y1</option>";
								
						}
					  ?>
                      </select></td>
                    <td width="26%" align="left">&nbsp;</td>
                    <td width="43%" align="left"></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center"><b>เปรียบเทียบกับ</b></td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left"><strong>เดือน </strong>
                      <select name="mm2" id="mm2" onClick="return CheckR2();">
                        <option value="">เลือกเดือน</option>
                        <?
                      	if(count($monthname) > 0){
								foreach($monthname as $km1 => $vm1){
									if($km1 != ""){
										if($mm2 == $km1){ $sel = "selected='selected'";}else{ $sel = "";}
										echo "<option value='$km1' $sel>$vm1</option>";
									}//end if($km1 != ""){
								}
						}
					  ?>
                      </select></td>
                    <td align="left"><strong>ปี</strong>
                      <select name="yy2" id="yy2" onClick="return CheckR2();">
                        <option value="">เลือกปี</option>
                        <?
					
                      	for($y1=(date("Y")+543);$y1 > $date_dis;$y1--){
							if($y1 == $yy2){ $sel = "selected='selected'";}else{ $sel = "";}
							echo "<option value='$y1' $sel>$y1</option>";
								
						}
					  ?>
                      </select></td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                  </tr>
                  </table></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#A5B2CE">&nbsp;</td>
                <td align="left" bgcolor="#A5B2CE"><input type="submit" name="button2" id="button" value="แสดงรายงานเปรียบเทียบ"></td>
              </tr>
            </table>
          </td>
        </tr>
        </form>
        <?

        	if($compare_id == "1"){
				$date1 = ThaiDate2DBDate($s_data1);
				$date2 = ThaiDate2DBDate($s_data2);
				$date3 = ThaiDate2DBDate($e_data1);
				$date4 = ThaiDate2DBDate($e_data2);
				
				$arr_e = GetDataGroupE($site_id,$compare_id,$date1,$date2); // กลุ่ม E
				$arr_e1 = GetDataGroupE($site_id,$compare_id,$date3,$date4); // กลุ่ม E
				$arr_l = GetDataGroupL($site_id,$compare_id,$date1,$date2); // กลุ่ม L
				$arr_l1 = GetDataGroupL($site_id,$compare_id,$date3,$date4); // กลุ่ม L
				$arr_n = GetDataGroupN($site_id,$compare_id,$date1,$date2); // กลุ่ม N
				$arr_n1 = GetDataGroupN($site_id,$compare_id,$date3,$date4); // กลุ่ม N
				
				$condate1 = $date1."||".$date2;
				$condate2 = $date3."||".$date4;
				
					$xhead = " รายงานเปรียบเทียบผลผลิตระหว่างวันที่ ".DBThaiLongDateFull($date1)." ถึง ".DBThaiLongDateFull($date2)." เปรียบเทียบกับ ".DBThaiLongDateFull($date3)." ถึง ".DBThaiLongDateFull($date4)." ".$arrsite[$site_id];
					$sub_h1 = "วันที่ ".DBThaiLongDateFull($date1)." ถึง ".DBThaiLongDateFull($date2);
					$sub_h2 =  "วันที่ ".DBThaiLongDateFull($date3)." ถึง ".DBThaiLongDateFull($date4);
			}else{
					$cmm = intval(date("m"));
					$cyy = intval(date("Y")+543);
					$cdd = intval(date("d"));
					if($cmm == $mm1 and $cyy == $yy1){
						$hsub1 = "ข้อมูลวันที่ 1 ถึงวันที่ $cdd";	
					}else{
						$hsub1 = "";
					}// end if($cmm == $mm1 and $cyy == $yy1){
					if($cmm == $mm2 and $cyy == $yy2){
						$hsub2 = "ข้อมูลวันที่ 1 ถึงวันที่ $cdd";	
					}else{
						$hsub2 = "";
					}//end if($cmm == $mm2 and $cyy == $yy2){
					$xhead = " รายงานเปรียบเทียบผลผลิตระหว่างเดือน  ".$monthname[$mm1]." พ.ศ. ".$yy1." เปรียบเทียบกับ ".$monthname[$mm2]." พ.ศ. ".$yy2." ".$arrsite[$site_id];	
					$sub_h1 = $hsub1." เดือน  ".$monthname[$mm1]." พ.ศ. ".$yy1;
					$sub_h2 = $hsub2." เดือน  ".$monthname[$mm2]." พ.ศ. ".$yy2;
				
					
					
					$month_val1 = sprintf("%02d",$mm1);
					$month_val2 = sprintf("%02d",$mm2);
					$year_val1 = $yy1-543;
					$year_val2 = $yy2-543;
					$date1 = $year_val1."-".$month_val1;
					$date2 = $year_val2."-".$month_val2;
					
					$condate1 = $date1;
					$condate2 = $date2;
					//echo $date1." :: ".$date2;
					
				$arr_e = GetDataGroupE($site_id,$compare_id,$date1,""); // กลุ่ม E
				$arr_e1 = GetDataGroupE($site_id,$compare_id,$date2,""); // กลุ่ม E
				$arr_l = GetDataGroupL($site_id,$compare_id,$date1,""); // กลุ่ม L
				$arr_l1 = GetDataGroupL($site_id,$compare_id,$date2,""); // กลุ่ม L
				$arr_n = GetDataGroupN($site_id,$compare_id,$date1,""); // กลุ่ม N
				$arr_n1 = GetDataGroupN($site_id,$compare_id,$date2,""); // กลุ่ม N

					
			}
		?>
		   <tr>
		     <td class="headerTB"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		       <tr>
		         <td>
		           <table width="100%" border="0" cellspacing="0" cellpadding="0">
		             <tr>
		               <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
		                 <tr>
		                   <td colspan="11" align="center" bgcolor="#A5B2CE"><strong>
		                     <?=$xhead?>
		                   </strong></td>
		                   </tr>
		                 <tr>
		                   <td width="4%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
		                   <td width="21%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>กลุ่มพนักงาน</strong></td>
		                   <td colspan="3" align="center" bgcolor="#A5B2CE"><strong>
		                     <?=$sub_h1?>
		                   </strong></td>
		                   <td colspan="6" align="center" bgcolor="#A5B2CE"><strong>
		                     <?=$sub_h2?>
		                   </strong></td>
		                   </tr>
		                 <tr>
		                   <td width="10%" align="center" bgcolor="#A5B2CE"><strong>จำนวน (คน)</strong></td>
		                   <td width="10%" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตรวม(ชุด)</strong></td>
		                   <td width="10%" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตต่อคน(ชุด)</strong></td>
		                   <td width="8%" align="center" bgcolor="#A5B2CE"><strong>จำนวน (คน)</strong></td>
		                   <td width="7%" align="center" bgcolor="#A5B2CE"><strong>(+/-)</strong></td>
		                   <td width="8%" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตรวม(ชุด)</strong></td>
		                   <td width="7%" align="center" bgcolor="#A5B2CE"><strong>(+/-)</strong></td>
		                   <td width="8%" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตต่อคน(ชุด)</strong></td>
		                   <td width="7%" align="center" bgcolor="#A5B2CE"><strong>(+/-)</strong></td>
		                   </tr>
                           <?
                           	$sql = "SELECT * FROM keystaff_group_report ORDER BY orderby ASC";
							$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
							$i=0;
							while($rs = mysql_fetch_assoc($result)){
								if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
								if($rs[groupreport_id] == "1"){
										$staff_val1 = $arr_e['numstaff']; // จำนวนพนักงานทั้งหมด
										$staff_val2 = $arr_e1['numstaff'];
										$numpoint_val1 = ($arr_e['numpoint']-$arr_e['sub_numpoint'])/$point_per_doc;// จำนวนพนักงานทั้งหมด1
										$numpoint_val2 = ($arr_e1['numpoint']-$arr_e1['sub_numpoint'])/$point_per_doc;
										if($staff_val1 > 0){
											$numpoint_avg1 = $numpoint_val1/$staff_val1;
										}
										if($staff_val2 > 0){
											$numpoint_avg2 = $numpoint_val2/$staff_val2;
										}
										#########  ผลผลิต +-
										$staff_pd = $staff_val2-$staff_val1;
										$numpoint_pd = $numpoint_val2-$numpoint_val1;
										$numavg_pd = $numpoint_avg2-$numpoint_avg1;
								}//if($rs[groupreport_id] == "1"){
									
								else if($rs[groupreport_id] == "2"){
										
										$staff_val1 = $arr_l['numstaff']; // จำนวนพนักงานทั้งหมด
										$staff_val2 = $arr_l1['numstaff'];
										$numpoint_val1 = ($arr_l['numpoint']-$arr_l['sub_numpoint'])/$point_per_doc;// จำนวนพนักงานทั้งหมด1
										$numpoint_val2 = ($arr_l1['numpoint']-$arr_l1['sub_numpoint'])/$point_per_doc;
										if($staff_val1 > 0){
											$numpoint_avg1 = $numpoint_val1/$staff_val1;
										}
										if($staff_val2 > 0){
											$numpoint_avg2 = $numpoint_val2/$staff_val2;
										}

										#########  ผลผลิต +-
										$staff_pd = $staff_val2-$staff_val1;
										$numpoint_pd = $numpoint_val2-$numpoint_val1;
										$numavg_pd = $numpoint_avg2-$numpoint_avg1;
								}//end else if($rs[groupreport_id] == "1"){
									
								else{
										
										$staff_val1 = $arr_n[$rs[r_point]]['numstaff']; // จำนวนพนักงานทั้งหมด
										$staff_val2 = $arr_n1[$rs[r_point]]['numstaff'];
										if($staff_val1 > 0){
											$numpoint_val1 = ($arr_n[$rs[r_point]]['numpoint']-$arr_n[$rs[r_point]]['sub_numpoint'])/$point_per_doc;// จำนวนพนักงานทั้งหมด1
										}//end if($staff_val1 > 0){
										if($staff_val2 > 0){
											$numpoint_val2 = ($arr_n1[$rs[r_point]]['numpoint']-$arr_n1[$rs[r_point]]['sub_numpoint'])/$point_per_doc;
										}//end if($staff_val2 > 0){
										if($staff_val1 > 0){
											$numpoint_avg1 = $numpoint_val1/$staff_val1;
										}// end if($staff_val1 > 0){
										if($staff_val2 > 0){
											$numpoint_avg2 = $numpoint_val2/$staff_val2;
										}//end if($staff_val2 > 0){
										#########  ผลผลิต +-
										$staff_pd = $staff_val2-$staff_val1;
										$numpoint_pd = $numpoint_val2-$numpoint_val1;
										$numavg_pd = $numpoint_avg2-$numpoint_avg1;
	
									}//end else($rs[groupreport_id] == "3"){
								
						   ?>
		                 <tr bgcolor="<?=$bg?>">
		                   <td align="center"><?=$i?></td>
		                   <td align="left"><?=$rs[groupreport_name]?></td>
		                   <td align="center"><? if($staff_val1 > 0){ echo "<a href='report_key_endproduct_detail.php?groupreport_id=$rs[groupreport_id]&xtype=1&site_id=$site_id&rpoint=$rs[r_point]&condate=$condate1' target='_blank'>".number_format($staff_val1)."</a>";}else{ echo "0";}?></td>
		                   <td align="center"><?=number_format($numpoint_val1,2)?></td>
		                   <td align="center"><?=number_format($numpoint_avg1,2)?></td>
		                   <td align="center"><? if($staff_val2 > 0){ echo "<a href='report_key_endproduct_detail.php?groupreport_id=$rs[groupreport_id]&xtype=2&site_id=$site_id&rpoint=$rs[r_point]&condate=$condate2' target='_blank'>".number_format($staff_val2)."</a>";}else{ echo "0";}?></td>
		                   <td align="center"><? if($staff_pd < 0){ echo "<font color=\"#CC0000\"><a href='report_key_endproduct_detail_diff.php?groupreport_id=$rs[groupreport_id]&xtype=3&site_id=$site_id&rpoint=$rs[r_point]&condate1=$condate1&condate2=$condate2&r=N&numstaff=$staff_pd' target='_blank' style=\"color:#F00000\">".number_format($staff_pd)."</a></font>";}else if($staff_pd > 0){ echo "<a href='report_key_endproduct_detail_diff.php?groupreport_id=$rs[groupreport_id]&xtype=3&site_id=$site_id&rpoint=$rs[r_point]&condate1=$condate1&condate2=$condate2&r=Y&numstaff=$staff_pd' target='_blank'>".number_format($staff_pd)."</a>"; }else{ echo "0";}?></td>
		                   <td align="center"><?=number_format($numpoint_val2,2)?></td>
		                   <td align="center"><? if($numpoint_pd < 0){ echo "<font color=\"#CC0000\">".number_format($numpoint_pd,2)."</font>";}else{ echo number_format($numpoint_pd,2);}?></td>
		                   <td align="center"><?=number_format($numpoint_avg2,2)?></td>
		                   <td align="center"><? if($numavg_pd < 0){ echo "<font color=\"#CC0000\">".number_format($numavg_pd,2)."</font>";}else{ echo number_format($numavg_pd,2); }?></td>
		                   </tr>
                           <?
						   	$num1 += $staff_val1;
							$num2 += $numpoint_val1;
							$num3 += $numpoint_avg1;
							$num4 += $staff_val2;
							$num5 += $staff_pd;
							$num6 += $numpoint_val2;
							$num7 += $numpoint_pd;
							$num8 += $numpoint_avg2;
							$num9 += $numavg_pd;
							
							
							$staff_val1 = 0;
							$numpoint_val1 = 0;
							$numpoint_avg1 = 0;
							$staff_val2 = 0;
							$staff_pd = 0;
							$numpoint_val2 = 0;
							$numpoint_pd = 0;
							$numpoint_avg2 = 0;
							$numavg_pd = 0;
							
							
							}// end while($rs = mysql_fetch_assoc($result)){
						   ?>
		                 <tr>
		                   <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>รวม :</strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <?=number_format($num1)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <?=number_format($num2,2)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <?=number_format($num3,2)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <?=number_format($num4)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <?=number_format($num5)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <?=number_format($num6,2)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <?=number_format($num7,2)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <?=number_format($num8,2)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#CCCCCC"><strong>
		                     <?=number_format($num9,2)?>
		                   </strong></td>
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
