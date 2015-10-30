<?
	include ("../../common/common_competency.inc.php")  ;
	include ("../../common/std_function.inc.php")  ;
	include ("epm.inc.php")  ;
			
	function GetDayOfWeek($get_date){
	  $arr = explode("-",$get_date);
	  $xFTime = getdate(date(mktime(0, 0, 0, intval($arr[1]), intval($arr[2]), intval($arr[0]))));
	  $curent_week = $xFTime["wday"];	
	  return $curent_week;
}// end function GetDayOfWeek($get_date){
	
###### function หาสัปดาของปี
function GetWeekOfYear($get_date){
	  $wOfY = date("W",strtotime($get_date));	
	  return $wOfY;
}// end function GetWeekOfYear($get_date){
		
		
//$get_date1 = "2010-11-29";

//echo $get_date1." :: ".GetWeekOfYear($get_date1);die;
	function GetStaffNtoL(){
			global $dbnameuse;
			$sql = "SELECT t1.staffid, t1.prename, t1.staffname, t1.staffsurname, t1.keyin_group, t1.status_permit, t1.sapphireoffice,
t1.status_extra,
t2.numkpoint,
t2.datekeyin
FROM
keystaff AS t1
Inner Join stat_user_keyin AS t2 ON t1.staffid = t2.staffid
WHERE  t1.keyin_group='2' and t1.status_extra='NOR' and t1.status_permit='YES' AND t2.keyin_group ='3' 
and (t2.datekeyin LIKE '2011%' or t2.datekeyin LIKE '2010%')
order by t1.staffname asc,t2.datekeyin asc";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			//$dOfw = GetDayOfWeek($rs[datekeyin]); // หาวันของสัปดาห์
			$wOfY = GetWeekOfYear($rs[datekeyin]); // หาสัปดาห์ของปี
			//echo $rs[staffid] ." => ".$dOfw."<br>";
			if($wOfY != $temp_wOfY){
				$i++;	
				$temp_wOfY = $wOfY;
				$arr[$rs[staffid]][$i]['sdate'] = $rs[datekeyin];
			}// end if($wOfY != $temp_wOfY){

			//$arr[$rs[staffid]][$i][$rs[datekeyin]] = $arr[$rs[staffid]][$i][$rs[datekeyin]]+$rs[numkpoint];
			$arr[$rs[staffid]][$i]['point'] = $arr[$rs[staffid]][$i]['point']+$rs[numkpoint];
			$arr[$rs[staffid]][$i]['edate'] = $rs[datekeyin];
			$arr[$rs[staffid]][$i]['numday'] = $arr[$rs[staffid]][$i]['numday']+1;
			

				//$xarr['key'] = $arr;
				//$xarr['val'] = $arr1;
		}//end while($rs = mysql_fetch_assoc($result)){
			
		return $arr;
	}//end function GetStaffNtoL(){
			
			




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานการคีย์ข้อมูลของพนักงานกลุ่ม N ของเดือนมีนาคม</title>
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
<script type=text/javascript src="../../common/jscriptfixcolumn/jquery.min.js"></script>
<script type=text/javascript src="../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></script>
<script type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 3 });
        });
</script>

<style type=text/css>HTML * {
	FONT-FAMILY: Tahoma, "Trebuchet MS" , Verdana; FONT-SIZE: 11px
}
BODY {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
.baslik {
	TEXT-ALIGN: center; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #6b8e23; PADDING-LEFT: 5px; PADDING-RIGHT: 5px; COLOR: white; FONT-WEIGHT: bold; PADDING-TOP: 5px
}
.tdmetin {
	PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #dcdcdc; PADDING-LEFT: 5px; PADDING-RIGHT: 5px; COLOR: #00008b; FONT-WEIGHT: bold; PADDING-TOP: 5px
}
.code {
	BORDER-BOTTOM: #cccccc 1px solid; BORDER-LEFT: #cccccc 1px solid; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #eeeeee; PADDING-LEFT: 5px; WIDTH: 400px; PADDING-RIGHT: 5px; BORDER-TOP: #cccccc 1px solid; BORDER-RIGHT: #cccccc 1px solid; PADDING-TOP: 5px
}
.highlight {
	BACKGROUND-COLOR: highlight !important
}
.highlight2 {
	BACKGROUND-COLOR: #CCCCCC !important; COLOR: black
}
.tbl1 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
.tbl2 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
.tbl3 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
</style>
</head>
<body>
<?
	$arrg = GetStaffNtoL(); //ข้อมูลระยะเวลากลุ่ม N ที่ย้ายเข้ามาเป็นกลุ่ม L
	

	
	foreach($arrg as $key => $val){
			$arr_max[] = count($val);
	}
	$maxarr = max($arr_max);
//	echo "จำนวนสูงสุด : ".$maxarr."<pre>";
	//print_r($arrg);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="<?=5+$maxarr?>" align="center" bgcolor="#CCCCCC"><strong>รายงานระยะเวลาการทำงานของพนักงานบันทึกข้อมูลก่อนขึ้นมาเป็น กลุ่ม L</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="23%" align="center" bgcolor="#CCCCCC"><strong>ชื่อนามสกุลพนักงาน</strong></td>
        <td width="21%" align="center" bgcolor="#CCCCCC"><strong>ระยะเวลาการทำงานก่อนขึ้นมาเป็นกลุ่ม L<br />
          (สัปดาห์)        </strong></td>
          <?
		  $percenw = floor(22/$maxarr);
		  $xmod = $maxarr-($percenw*$maxarr);
		  $add_p = $percenw+$xmod;
          	if($maxarr > 0){
				for($k=1;$k<=$maxarr;$k++){
					if($k==$maxarr){
						$strp = $add_p;
					}else{
						$strp = $percenw;
					}
		  ?>
        <td width="<?=$strp?>%" align="center" bgcolor="#CCCCCC"><? echo "สัปดาห์ที่ ".$k;?></td>
        <?
				}//end foreach(){
			}//end  	if($maxarr > 0){
		?>
        <td width="8%" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
      </tr>
      <?
		
	
		
        	$sql = "SELECT
t1.staffid,
t1.prename,
t1.staffname,
t1.staffsurname,
t1.keyin_group,
t1.status_permit,
t1.sapphireoffice,
t1.status_extra,
t2.numkpoint,
t2.datekeyin
FROM
keystaff AS t1
Inner Join stat_user_keyin AS t2 ON t1.staffid = t2.staffid
WHERE  t1.keyin_group='2' and t1.status_extra='NOR' and t1.status_permit='YES'  AND  t1.period_time='am' AND t1.sapphireoffice='0' AND  t2.keyin_group ='3' 
and (t2.datekeyin LIKE '2011%' or t2.datekeyin LIKE '2010%')
group by t1.staffid
order by 
t1.staffname asc,t2.datekeyin asc";
$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
$i=0;
while($rs = mysql_fetch_assoc($result)){
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	 
	// echo "<pre>";
	// print_r($arrg[$rs[staffid]]);
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?></td>
        <td align="center"><?=number_format(count($arrg[$rs[staffid]]))?></td>
        <?
        	if(count($arrg[$rs[staffid]] > 0)){
				$intA = 0;
				foreach($arrg[$rs[staffid]] as $key1 => $va1){
					$intA++;
				
		?>
        <td align="center"><?=number_format($va1['point'],2)?></td>
        <?
				$sump += $va1['point'];
				
				}//end foreach($arrg[$rs[staffid]] as $key1 => $va1){
			}//end if(count($arrg[$rs[staffid]] > 0)){
		
		$diff_loop = $maxarr-$intA;	
		if($diff_loop > 0){
			for($j=0;$j < $diff_loop;$j++){
					echo "<td align=\"center\">-</td>";
			}
				
		}
		?>
        <td align="center"><?=number_format($sump,2)?></td>
      </tr>
      <?
	  $intA = 0;
	  $sump = 0;
}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
      
    </table></td>
  </tr>
</table>
</body>
</html>
