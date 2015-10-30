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
where  t1.period_time='am' and t1.status_permit='YES' and t1.sapphireoffice='0'  AND t2.datekeyin between '2011-06-02' AND '2011-06-25' and t2.datekeyin NOT IN('2011-06-09','2011-06-21')
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
where  t1.period_time='am' and t1.status_permit='YES' and t1.sapphireoffice='0'  AND t2.datekeyin between '2011-05-26' AND '2011-05-29' 
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
$arrc = GetDateC();
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
              <td colspan="10" align="center" bgcolor="#6C757E">ช่วงคะแนน 26 พ.ค.-31 พ.ค. 54 ไม่นับวันที่ 30,31 พ.ค.</td>
              <td colspan="5" align="center" bgcolor="#6C757E">ช่วงคะแนน 1 มิ.ย-25 มิ.ย. 54 , ไม่นับวันที่ 1,9,21 มิ.ย</td>
              <td colspan="5" align="center" bgcolor="#6C757E">ช่วงคะแนน&nbsp; 1 มิ.ย-30  มิ.ย. 54 , ไม่นับวันที่ 1,9,21 มิ.ย</td>
              </tr>
            <tr>
              <td width="0%" align="center" bgcolor="#6C757E">ลำดับ</td>
              <td width="6%" align="center" bgcolor="#6C757E">รหัสพนักงาน</td>
              <td width="6%" align="center" bgcolor="#6C757E">รายชื่อพนักงาน</td>
              <td width="6%" align="center" bgcolor="#6C757E">กลุ่มการทำงาน</td>
              <td width="5%" align="center" bgcolor="#6C757E">วันเริ่มทำงาน</td>
              <td width="6%" align="center" bgcolor="#6C757E">คะแนนทั้งหมด</td>
              <td width="3%" align="center" bgcolor="#6C757E">จุดผิด</td>
              <td width="6%" align="center" bgcolor="#6C757E">จำนวนวันทำงาน</td>
              <td width="5%" align="center" bgcolor="#6C757E">คะแนนสุทธิ</td>
              <td width="7%" align="center" bgcolor="#6C757E">คะแนนเฉลี่ยต่อวัน<br>
                สุทธิ(คะแนน)</td>
              <td width="5%" align="center" bgcolor="#6C757E">คะแนน<br>
                ทั้งหมด</td>
              <td width="5%" align="center" bgcolor="#6C757E">จุดผิด</td>
              <td width="6%" align="center" bgcolor="#6C757E">จำนวน<br>
                วันทำงาน</td>
              <td width="5%" align="center" bgcolor="#6C757E">คะแนนสุทธิ</td>
              <td width="7%" align="center" bgcolor="#6C757E">คะแนนเฉลี่ยต่อวัน<br>
                สุทธิ(คะแนน)</td>
              <td width="3%" align="center" bgcolor="#6C757E">คะแนน<br>
                ทั้งหมด</td>
              <td width="3%" align="center" bgcolor="#6C757E">จุดผิด</td>
              <td width="4%" align="center" bgcolor="#6C757E">จำนวน<br>
                วันทำงาน</td>
              <td width="5%" align="center" bgcolor="#6C757E">คะแนนสุทธิ</td>
              <td width="7%" align="center" bgcolor="#6C757E">คะแนนเฉลี่ยต่อวัน<br>
                สุทธิ(คะแนน)</td>
              </tr>
              <?
              	$sql = "SELECT * FROM keystaff  WHERE period_time='am' and status_permit='YES' AND keyin_group IN('2','3') ORDER BY keyin_group DESC,staffname ASC";
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
              <td align="center"><?=number_format($arrc[$rs[staffid]]['4'],2)?></td>
              <td align="center"><?=number_format($arrc[$rs[staffid]]['5'],2)?></td>
              <td align="center"><?=$arrc[$rs[staffid]]['6']?></td>
              <td align="center"><?=number_format($arrc[$rs[staffid]]['7'],2)?></td>
              <td align="center"><?=number_format($arrc[$rs[staffid]]['8'],2)?></td>
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
