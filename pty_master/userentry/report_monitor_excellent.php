<?
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			include("function_face2cmss.php");
			
			
	if($group_id == ""){
		$group_id = 2;	
	}
	
	
	if($yy == ""){
			$yy = date("Y")+543;
	}
	if($mm == ""){
			$mm = sprintf("%02d",date("m"));
	}
	
	$yy1 = $yy;
	$yy = $yy-543;
	$yymm = $yy."-".sprintf("%02d",$mm);
	if($yymm == ""){
			$yymm = date("Y-m");
	}

	//echo $yymm;
	$arrsite = GetSiteKeyData();
	$arrnum_absent = GetNumAbsentStaff($yymm);
	ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
	


	function GetGroupName(){
		global $dbnameuse;
		$sql = "SELECT * FROM `keystaff_group` where status_active='1'";	
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[groupkey_id]] = $rs[groupname];	
		}//end while($rs = mysql_fetch_assoc($result)){
			return $arr;
	}// end function GetGroupName(){
	
	
$arrgroupname = GetGroupName(); // กลุ่มการคีย์ข้อมูล



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
	$date_dis = (date("Y")+543)-2;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#CCCCCC"> <form id="form1" name="form1" method="post" action="">
              เดือน <select name="mm" id="mm">
                        <option value="">เลือกเดือน</option>
                        <?
                      	if(count($monthname) > 0){
								foreach($monthname as $km => $vm){
									if($km != ""){
										if($mm == $km){ $sel = "selected='selected'";}else{ $sel = "";}
										echo "<option value='$km' $sel>$vm</option>";
									}//end if($km != ""){
								}
						}
					  ?>
                      </select>
                      &nbsp;ปี <select name="yy1" id="yy1">
                        <option value="">เลือกปี</option>
                        <?
					
                      	for($y1=(date("Y")+543);$y1 > $date_dis;$y1--){
							if($y1 == $yy1){ $sel = "selected='selected'";}else{ $sel = "";}
							echo "<option value='$y1' $sel>$y1</option>";
								
						}
					  ?>
                      </select>
         &nbsp;&nbsp;
เลือกกลุ่ม 
<select name="group_id" id="group_id"> 

            <option value="" >เลือกกลุ่มการคีย์ข้อมูล</option>
            <?
            	$sql_g = "SELECT * FROM `keystaff_group` where status_active='1'";
				$result_g = mysql_db_query($dbnameuse,$sql_g);
				while($rsg = mysql_fetch_assoc($result_g)){
					if($rsg[groupkey_id] == $group_id){ $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='$rsg[groupkey_id]' $sel>$rsg[groupname]</option>";
				}
			?>
            </select>
            &nbsp;&nbsp; ที่ตั้งศูนย์คีย์: 
            <select name="site_id" id="site_id"> 
            <option value="" > - เลือกที่ตั้ง - </option>
                 <option value="999" <? if($site_id == "999"){ echo " selected='selected' ";}?>>เลือกทั้งหมด</option>
                 <?
                 	if(count($arrsite) > 0){
							foreach($arrsite as $kk => $vv){
								if($kk == $site_id){ $sel = " selected='selected' ";}else{ $sel = "";}
									echo "<option value='$kk' $sel>$vv</option>";
							}
					}//end 	if(count($arrsite) > 0){
				 ?>
            </select>
            &nbsp;&nbsp;<br />
ชื่อพนักงาน : 
            
           
            <input type="text" name="staffname" id="staffname" value="<?=$staffname?>">&nbsp;นามสกุลพนักงาน : <input type="text" name="staffsurname" id="staffsurname" value="<?=$staffsurname?>">
        <input type="submit" name="button" id="button" value="ค้นหา" /></form></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td bgcolor="#000000"><table width="100%" border="1" cellspacing="1" cellpadding="3" class="tbl3">
      <tr>
        <td colspan="15" align="left" bgcolor="#CCCCCC">
<strong>รายงานค่าคะแนนประจำเดือน&nbsp;<?=$monthname[intval($mm)]?> &nbsp;<?=$yy1?> <? echo "(".$arrgroupname[$group_id].")"; if($site_id != "" and $site_id != "999"){ echo " (".$arrsite[$site_id].") ";}?></strong></td>
        </tr>
      <tr>
        <td width="3%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>โค้ดพนักงาน</strong></td>
        <td width="10%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ชื่อ นามสกุล</strong></td>
        <td width="7%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>วันเริ่มทำงาน</strong></td>
        <td width="8%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>กลุ่มการทำงาน</strong></td>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>คะแนนการบันทึกข้อมูล</strong></td>
        <td colspan="4" align="center" bgcolor="#CCCCCC"><strong>ค่าถ่วงน้ำหนักการบันทึก</strong></td>
        <td width="6%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>คะแนนเฉลี่ย<br />
          ต่อวัน</strong></td>
        <td width="6%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>เกณฑ์<br />
          ประเมิน</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ผลประเมิน</strong></td>
      </tr>
      <tr>
        <td  width="6%" align="center" bgcolor="#CCCCCC"><strong>คะแนนบันทึกได้</strong></td>
        <td  width="7%" align="center" bgcolor="#CCCCCC"><strong>คะแนนถ่วงน้ำหนัก</strong></td>
        <td  width="10%" align="center" bgcolor="#CCCCCC"><strong>คะแนนสุทธิ</strong></td>
        <td  width="7%" align="center" bgcolor="#CCCCCC"><strong>ลา</strong></td>
        <td  width="7%" align="center" bgcolor="#CCCCCC"><strong>แก้งาน/ระบบร่ม</strong></td>
        <td  width="6%" align="center" bgcolor="#CCCCCC"><strong>ขาด</strong></td>        
        <td width="7%" align="center" bgcolor="#CCCCCC"><strong>นับจริง</strong></td>
        </tr>
      <?
 if($site_id != "999"){
		$in_pin = GetPinStaff($site_id);
		if($in_pin != ""){ $conv2 = " AND t1.card_id IN($in_pin)";}else{ $conv2 = "";}
 }//end  if($site_id != "999"){
			
ConHost(HOST,USERNAME_HOST,PASSWORD_HOST);   

if($staffname != ""){
		$conw1 .= " AND t1.staffname LIKE '%$staffname%' ";
}
if($staffsurname != ""){
		$conw1 .= " AND t1.staffsurname LIKE '%$staffsurname%' ";
}

if($group_id != ""){
		$congroup = " AND t1.keyin_group='$group_id'";
}else{
		$congroup = "";	
}

$sql = "SELECT
t1.staffid,
t1.id_code,
t1.prename,
t1.staffname,
t1.staffsurname,
t1.card_id,
t1.sapphireoffice,
t1.status_extra,
t1.keyin_group,
t1.start_date,
t2.datekeyin,
Sum(t2.numkpoint) AS sumpoint,
sum(t3.spoint * if(t2.rpoint>0,t2.rpoint,1)) as sub_point,
count(distinct t2.datekeyin) as numday
FROM
keystaff AS t1
Inner Join stat_user_keyin AS t2 ON t1.staffid = t2.staffid
Left Join stat_subtract_keyin as t3 ON t2.staffid = t3.staffid and t2.datekeyin=t3.datekey
where t2.datekeyin LIKE '$yymm%' and t1.status_permit='YES' and t1.status_extra='NOR' $conv2 $conw1 $congroup
GROUP BY t1.staffid";
//echo $sql;
		$result = mysql_db_query($dbnameuse,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 $point_net = $rs[sumpoint]-$rs[sub_point];
			 $num_absent = $arrnum_absent[$rs[card_id]]['absent_a']; // จำนวนวันที่ขาด
			 $num_absent1=  $arrnum_absent[$rs[card_id]]['absent_l']; // จำนวนวันที่ลา
			 $num_daykey = $rs[numday]-($num_absent+$num_absent1); // จำนวนวันที่ทำงานทั้งหมด
			
			 if($num_daykey > 0){ $point_per_day = $point_net/$num_daykey;}else{ $point_per_day = 0;}
			 if($point_per_day > $point_excellent){ $pw = 1;$img_con = " <img src=\"../../images_sys/approve20.png\" width=\"16\" height=\"16\" border=\"0\" title=\"คะแนนสูงกว่าเกณฑ์\">"; }else{ $img_con = "<img src=\"../../images_sys/unapprove.png\" width=\"16\" height=\"16\" border=\"0\" title=\"คะแนนไม่ผ่านเกณฑ์\">";  $pw = 0;}
	
	  ?>

        <tr bgcolor="<?=$bg?>">
          <td align="center"><?=$i?></td>
          <td align="center" nowrap="nowrap"><?=$rs[id_code]?></td>
          <td align="left" nowrap="nowrap"><? echo "$rs[staffname] $rs[staffsurname]"?></td>
          <td align="left" nowrap="nowrap"><?=DBThaiLongDate($rs[start_date]);?></td>
          <td  align="center"><?=$arrgroupname[$rs[keyin_group]];?></td>
          <td  align="center"><?=number_format($rs[sumpoint],2)?></td>
          <td align="center"><?=number_format($rs[sub_point],2)?></td>
          <td align="center"><?=number_format($point_net,2)?></td>
          <td align="center"><?=number_format($num_absent1);?></td>
          <td align="center">0</td>
          <td  align="center"><?=number_format($num_absent);?></td>
          <td align="center"><?=number_format($num_daykey)?></td>
          <td align="center"><?=number_format($point_per_day,2)?></td>
          <td align="center"><?=$point_excellent?></td>
          <td align="center"><?=$img_con?></td>
        </tr>
        <?
	 	$point_net = 0;
		$num_absent = 0;
		$num_absent1 = 0;
		
		}//end while($rs = mysql_fetch_assoc($result)){
	 ?>
    </table></td>
  </tr>
</table>
</body>
</html>
