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

<?



function GetDateA(){
		global $dbnameuse;
		$sql = "SELECT
t1.staffid,
t1.id_code,
concat(t1.prename,
t1.staffname,' ',
t1.staffsurname) as fullname ,
t1.start_date,

Sum(t2.numkpoint) AS numpoint,
sum(t3.spoint* if(t2.rpoint > 0,t2.rpoint,t3.point_ratio)) as sub_numpoint,
Count(distinct t2.datekeyin) AS numday
FROM
keystaff as t1  Inner Join
stat_user_keyin as t2 ON  t1.staffid=t2.staffid
left Join stat_subtract_keyin as t3 ON t2.datekeyin = t3.datekey AND t2.staffid = t3.staffid
where  t1.period_time='am' and t1.status_permit='YES' and t1.sapphireoffice='0'  AND t2.datekeyin between '2011-06-27' AND '2011-06-30' 
group by 
t1.staffid
order by t1.id_code  asc
";	
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
			
			$arr[$rs[staffid]]['1'] = $rs[id_code];
			$arr[$rs[staffid]]['2'] = $rs[fullname];
			$arr[$rs[staffid]]['3'] = $rs[start_date];
			$arr[$rs[staffid]]['4'] = $rs[numpoint];
			$arr[$rs[staffid]]['5'] = $rs[sub_numpoint];
			$arr[$rs[staffid]]['6'] = $rs[numday];
			$arr[$rs[staffid]]['7'] = $rs[numpoint]-$rs[sub_numpoint];
			$arr[$rs[staffid]]['8'] =($rs[numpoint]-$rs[sub_numpoint])/$rs[numday];
	}
	return $arr;
	}
	
	
function GetDateB(){
		global $dbnameuse;
		$sql = "SELECT
t1.staffid,
t1.id_code,
concat(t1.prename,
t1.staffname,' ',
t1.staffsurname) as fullname ,
t1.start_date,

Sum(t2.numkpoint) AS numpoint,
sum(t3.spoint* if(t2.rpoint > 0,t2.rpoint,t3.point_ratio)) as sub_numpoint,
Count(distinct t2.datekeyin) AS numday
FROM
keystaff as t1  Inner Join
stat_user_keyin as t2 ON  t1.staffid=t2.staffid
left Join stat_subtract_keyin as t3 ON t2.datekeyin = t3.datekey AND t2.staffid = t3.staffid
where  t1.period_time='am' and t1.status_permit='YES' and t1.sapphireoffice='0'  AND t2.datekeyin between '2011-07-01' AND '2011-07-25' and t2.datekeyin NOT IN('2011-07-11','2011-07-13')
group by 
t1.staffid
order by t1.id_code  asc
";	
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
			
			$arr[$rs[staffid]]['1'] = $rs[id_code];
			$arr[$rs[staffid]]['2'] = $rs[fullname];
			$arr[$rs[staffid]]['3'] = $rs[start_date];
			$arr[$rs[staffid]]['4'] = $rs[numpoint];
			$arr[$rs[staffid]]['5'] = $rs[sub_numpoint];
			$arr[$rs[staffid]]['6'] = $rs[numday];
			$arr[$rs[staffid]]['7'] = $rs[numpoint]-$rs[sub_numpoint];
			$arr[$rs[staffid]]['8'] =($rs[numpoint]-$rs[sub_numpoint])/$rs[numday];
	}
	return $arr;
	}
	
function GetDateC(){
		global $dbnameuse;
		$sql = "SELECT
t1.staffid,
t1.id_code,
concat(t1.prename,
t1.staffname,' ',
t1.staffsurname) as fullname ,
t1.start_date,

Sum(t2.numkpoint) AS numpoint,
sum(t3.spoint* if(t2.rpoint > 0,t2.rpoint,t3.point_ratio)) as sub_numpoint,
Count(distinct t2.datekeyin) AS numday
FROM
keystaff as t1  Inner Join
stat_user_keyin as t2 ON  t1.staffid=t2.staffid
left Join stat_subtract_keyin as t3 ON t2.datekeyin = t3.datekey AND t2.staffid = t3.staffid
where  t1.period_time='am' and t1.status_permit='YES' and t1.sapphireoffice='0'  AND t2.datekeyin between '2011-06-02' AND '2011-06-30' and t2.datekeyin NOT IN('2011-06-09','2011-06-21')
group by 
t1.staffid
order by t1.id_code  asc
";	
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
			
			$arr[$rs[staffid]]['1'] = $rs[id_code];
			$arr[$rs[staffid]]['2'] = $rs[fullname];
			$arr[$rs[staffid]]['3'] = $rs[start_date];
			$arr[$rs[staffid]]['4'] = $rs[numpoint];
			$arr[$rs[staffid]]['5'] = $rs[sub_numpoint];
			$arr[$rs[staffid]]['6'] = $rs[numday];
			$arr[$rs[staffid]]['7'] = $rs[numpoint]-$rs[sub_numpoint];
			$arr[$rs[staffid]]['8'] =($rs[numpoint]-$rs[sub_numpoint])/$rs[numday];
	}
	return $arr;
	}//end function GetDateC(){

$arr1 = GetDateA();
$arr2 = GetDateB();

?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px" >รายงานตรวจสอบผลผลิตการ key ข้อมูลแยกรายกลุ่มพนักงาน</td>
        </tr>
        <form name="form1" method="post" action="" onSubmit="return CheckForm()">
		   <tr>
          <td bgcolor="#000000" ><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td width="3%" rowspan="2" align="center" bgcolor="#6C757E">ลำดับ</td>
              <td width="8%" rowspan="2" align="center" bgcolor="#6C757E">รหัสพนักงาน</td>
              <td width="13%" rowspan="2" align="center" bgcolor="#6C757E">รายชื่อพนักงาน</td>
              <td width="7%" rowspan="2" align="center" bgcolor="#6C757E">กลุ่มการทำงาน</td>
              <td width="8%" rowspan="2" align="center" bgcolor="#6C757E">วันเริ่มทำงาน</td>
              <td colspan="5" align="center" bgcolor="#6C757E">ช่วงคะแนน 27-30 มิ.ย.54</td>
              <td colspan="5" align="center" bgcolor="#6C757E">ช่วงคะแนน  1-25 ก.ค.54  ไม่นับวันที่ 11 และ 13</td>
              </tr>
            <tr>
              <td width="6%" align="center" bgcolor="#6C757E">คะแนน<br>
                ทั้งหมด</td>
              <td width="4%" align="center" bgcolor="#6C757E">จุดผิด</td>
              <td width="7%" align="center" bgcolor="#6C757E">จำนวน<br>
                วันทำงาน</td>
              <td width="7%" align="center" bgcolor="#6C757E">คะแนนสุทธิ</td>
              <td width="7%" align="center" bgcolor="#6C757E">คะแนนเฉลี่ยต่อวัน<br>
                สุทธิ(คะแนน)</td>
              <td width="6%" align="center" bgcolor="#6C757E">คะแนน<br>
                ทั้งหมด</td>
              <td width="6%" align="center" bgcolor="#6C757E">จุดผิด</td>
              <td width="5%" align="center" bgcolor="#6C757E">จำนวน<br>
                วันทำงาน</td>
              <td width="6%" align="center" bgcolor="#6C757E">คะแนนสุทธิ</td>
              <td width="7%" align="center" bgcolor="#6C757E">คะแนนเฉลี่ยต่อวัน<br>
                สุทธิ(คะแนน)</td>
              </tr>
              <?
              	$sql = "SELECT * FROM keystaff  WHERE period_time='am' and status_permit='YES' AND keyin_group IN('2','3')
				and card_id IN('1100500089288','1100500233851','1100500256796','1101400053321','1101401374406','1102000039356','1102000291284','1103700368892','1160700003115','1209700231638','1329900088056','1341200047066','1349900265632','1361000086084','1400900115623','1409600044591','1409900131643','1409900322007','1409900450552','1410100004169','1410100006129','1410100014440','1410100059729','1410100081155','1410100083948','1410100091606','1410100094036','1410100101733','1410100102365','1410100104350','1410100107359','1410100116340','1410100117788','1410100118717','1410100118890','1410100127554','1410100139714','1410100141956','1410100144084','1410100145668','1410100146907','1410100154390','1410100165669','1410100169851','1410100174951','1410100190221','1410100196645','1410100213850','1410190000915','1410190001270','1410190003248','1410190006018','1410190010651','1410200060613','1410200067618','1410200067731','1410200083630','1410200087902','1410200098220','1410300047953','1410300050733','1410300054739','1410300060534','1410300077011','1410300080845','1410400102123','1410490000635','1410490004428','1410500040596','1410500044982','1410500048619','1410500055631','1410600008091','1410600093420','1410600103824','1410600107862','1410600126123','1410600132662','1410600144300','1410600144768','1410600149867','1410700005905','1410700010763','1410800014205','1410800049971','1410900064000','1411100020548','1411100156547','1411200053154','1411200103895','1411300046249','1411400026240','1411400085378','1411400121242','1411490001641','1411500021096','1411600082402','1411700095476','1411700124123','1411700126606','1411800104175','1411800118435','1411900013473','1411900015808','1411900031137','1411900103626','1411900122299','1411900127118','1411900128122','1411900135552','1419900008574','1419900016101','1419900052441','1419900055645','1419900093890','1419900096562','1419900099103','1419900101884','1419900107190','1419900123373','1419900124001','1419900124442','1419900125198','1419900130141','1419900132755','1419900133573','1419900136785','1419900139130','1419900150630','1419900163111','1419900164975','1419900168385','1419900169179','1419900170819','1419900173966','1419900176183','1419900185212','1419900197741','1419900211078','1419990000896','1420900093841','1420900106667','1430100001321','1430100090502','1430100092823','1430100098686','1430200014450','1430200098718','1430200114179','1430200125448','1430300002127','1430300023213','1430300104078','1430500136275','1430500235931','1430600118449','1430800036781','1430800037728','1431000002343','1439900012385','1439900019291','1439900063745','1439900076308','1439900113009','1439900129401','1440300094625','1450700088398','1461100048931','1470100073331','1470400081011','1470500018680','1470500035851','1470600017561','1471000068123','1471200024791','1471200156603','1479900089230','1480400053726','1489900079137','1500700089024','1500700098767','1509900380073','1509900415021','1509900503582','1550700054115','1560600013671','1570300054665','1630700041896','1659900177871','1671100039271','1709900020806','1809800009842','1909900214242','2409900022451','2410100031954','2410400017451','2419900027674','3410100140433','3410100184741','3410100263543','3410100394320','3410100530924','3410100801693','3410101200804','3410101565993','3410101905468','3410101905689','3410102022063','3410102241474','3410400001048','3410900273977','3411400654662','3411700868218','3411900302111','3419900065949','3419900147961','3419900215819','3419900344163','3419900375395','3419900525362','3419900580762','3420400012368','3430200043413','3430200430913','3430300243163','3430600312021','3451100750534','3460700810324','3470100684468','3470100691863','3471000467288','3501600241361','3521300190621','3560100019889','3560600377831','3570600182967','3669700079405','3810500182806','5101400127955','5410100048118','5410100149747','5410490004706','8419988003741')
				
				 ORDER BY keyin_group DESC,staffname ASC";
				$result = mysql_db_query($dbnameuse,$sql);
				$i=0;
				while($rs = mysql_fetch_assoc($result)){
					
					
				if($arr1[$rs[staffid]]['4'] > 0 or $arr2[$rs[staffid]]['4'] > 0){
					if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			  ?>
            <tr bgcolor="<?=$bg?>">
              <td align="center" nowrap><?=$i?></td>
              <td align="center" nowrap><? if($arr1[$rs[staffid]]['1'] != ""){ echo $arr1[$rs[staffid]]['1'];}else{ echo $arr2[$rs[staffid]]['1'];}?></td>
              <td nowrap><? if($arr1[$rs[staffid]]['2'] != ""){ echo $arr1[$rs[staffid]]['2'];}else{ echo $arr2[$rs[staffid]]['2'];}?></td>
              <td nowrap><? if($rs[ratio_id] == "1"){ echo "N 1:1";}else if($rs[ratio_id] == "2"){ echo "N 1:3";}else if($rs[ratio_id] == "3"){ echo "N 1;20";} else if($rs[keyin_group] == "2"){ echo " L";}?></td>
              <td nowrap><? if($arr1[$rs[staffid]]['3'] != ""){ echo $arr1[$rs[staffid]]['3'];}else{ echo $arr2[$rs[staffid]]['3'];} ?></td>
              <td align="center"><?=number_format($arr1[$rs[staffid]]['4'],2)?></td>
              <td align="center"><?=number_format($arr1[$rs[staffid]]['5'],2)?></td>
              <td align="center"><?=$arr1[$rs[staffid]]['6']?></td>
              <td align="center"><?=number_format($arr1[$rs[staffid]]['7'],2)?></td>
              <td align="center"><?=number_format($arr1[$rs[staffid]]['8'],2)?></td>
              <td align="center"><?=number_format($arr2[$rs[staffid]]['4'],2)?></td>
              <td align="center"><?=number_format($arr2[$rs[staffid]]['5'],2)?></td>
              <td align="center"><?=$arr2[$rs[staffid]]['6']?></td>
              <td align="center"><?=number_format($arr2[$rs[staffid]]['7'],2)?></td>
              <td align="center"><?=number_format($arr2[$rs[staffid]]['8'],2)?></td>
              </tr>
              <?
			}
				}//end 
			  ?>
          </table></td>
        </tr>
        </form>

		   </table>
	  </td>
  </tr>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "เวลาในการประมวลผล :: $timeprocess";
?>
