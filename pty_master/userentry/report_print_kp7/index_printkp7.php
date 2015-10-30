<?
require_once("../../../config/conndb_nonsession.inc.php");
require_once("function_print_kp7.php");
require_once("../function_face2cmss.php");


$arrsite = GetSiteKeyData();
ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 

$curent_yy = date("Y")+543;

//echo "<font color='red'><center>ขออภัยกำลังปรับปรุงโปรแกรม ประมาณ  30 นาที </center></font>";die;

$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$point_num = 60;	
	if($yy1 == ""){
		$yy1 = date("Y")+543;
	}
	if($mm == ""){					
		$mm = sprintf("%2d",date("m"));
	}
	

	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานตรวจสอบการ QC</title>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script type=text/javascript src="../../../common/jscriptfixcolumn/jquery.min.js"></script>
<script type=text/javascript src="../../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></script>
<script type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 3 });
        });
</script>

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
	color: #FFF;
}
a:active {
	color: #000;
}
</style>


<style type="text/css">
<!--
A:link {
	FONT-SIZE: 12px;color: #000000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";TEXT-DECORATION: underline
}
A:visited {
	FONT-SIZE: 12px; COLOR: #000000; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:active {
	FONT-SIZE: 12px; COLOR: #014d5f; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
-->
</style>

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
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" bgcolor="#000000"><form id="form1" name="form1" method="post" action="">
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td align="right" bgcolor="#FFFFFF"><strong>พนักงาน QC : </strong></td>
                <td align="left" bgcolor="#FFFFFF">
                  <select name="staff_qc" id="staff_qc">
                  <option value="">เลือกทั้งหมด</option>
                  <?
                  	$sqlqc = "SELECT t1.staffid, t1.prename,
t1.staffname,
t1.staffsurname
FROM
keystaff AS t1
Inner Join keystaff_qc_math_key as t2 ON t1.staffid = t2.staffqc
WHERE t1.status_permit='YES'
GROUP BY t1.staffid";
					$resultqc = mysql_db_query($dbnameuse,$sqlqc) or die(mysql_error()."$sqlqc<br>LINE__".__LINE__);
					while($rsqc = mysql_fetch_assoc($resultqc)){
							if($staff_qc == $rsqc[staffid]){ $sel = " selected='selected'";}else{ $sel = "";}
							echo "<option value='$rsqc[staffid]' $sel>$rsqc[prename]$rsqc[staffname] $rsqc[staffsurname]</option>";
					}//end while($rsqc = mysql_fetch_assoc($resultqc)){
				  ?>
                  </select></td>
                <td align="right" bgcolor="#FFFFFF"><strong>กลุ่มคีย์ข้อมูล : </strong></td>
                <td align="left" bgcolor="#FFFFFF">
                <select name="group_id" id="group_id">
                <option value="">เลือกกลุ่มการคีย์ข้อมูล</option>
                <?
                	$sql = "SELECT groupkey_id,groupname,status_qc FROM keystaff_group WHERE status_qc='1' ";
					$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
					while($rs = mysql_fetch_assoc($result)){
						if($rs[groupkey_id] == $group_id){ $sel = " selected='selected'";}else{ $sel = "";}
						echo "<option value='$rs[groupkey_id]' $sel>$rs[groupname]</option>";	
					}// end while($rs = mysql_fetch_assoc($result)){
				?>
                </select>
                
                </td>
              </tr>
              <tr>
                <td width="18%" align="right" bgcolor="#FFFFFF"><strong>เดือนปี : </strong></td>
                <td align="left" bgcolor="#FFFFFF">
                  <select name="mm" id="mm">
                    <option value="">เลือกเดือน</option>
                    <?
                  	for($m = 1 ; $m <= 12 ; $m++ ){
						$xmm = sprintf("%02d",$m);
						if($xmm == $mm){ $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='$xmm' $sel>$monthFull[$m]</option>";
					}//end for($m = 1 ; $m <= 12 ; $m++ ){
				  ?>
                    </select>
                  <strong> ปี </strong>
                  <select name="yy1" id="yy1">
                    <option value="">เลือกปี</option>
                    <?
                 	for($y = 2552 ; $y <= $curent_yy ; $y++){
						if($y == $yy1){ $sel1 = "selected='selected'";}else{ $sel1 = "";}
							echo "<option value='$y' $sel1>$y</option>";
					}
				 ?>
                    </select>
                </td>
                <td align="right" bgcolor="#FFFFFF"><strong>ศูนย์คีย์ข้อมูล : </strong></td>
                <td align="left" bgcolor="#FFFFFF"><select name="site_id" id="site_id">
                  <option value="">เลือก site งาน</option>
                  <option value="999" <? if($site_id == "999"){ echo " selected='selected' ";}?>>เลือกทั้งหมด</option>
                  <?
                 	if(count($arrsite) > 0){
							foreach($arrsite as $kk => $vv){
								if($kk == $site_id){ $sel = " selected='selected' ";}else{ $sel = "";}
									echo "<option value='$kk' $sel>$vv</option>";
							}
					}//end 	if(count($arrsite) > 0){
				 ?>
                </select></td>
              </tr>
              <tr>
                <td width="18%" align="right" bgcolor="#FFFFFF"><strong>ชื่อพนักงานคีย์ข้อมูล : </strong></td>
                <td width="24%" align="left" bgcolor="#FFFFFF">
                  <input type="text" name="staffname" id="staffname" value="<?=$staffname?>"></td>
                <td width="12%" align="right" bgcolor="#FFFFFF"><strong>นามสกุลพนักงานคีย์ข้อมูล : </strong></td>
                <td width="46%" align="left" bgcolor="#FFFFFF"> <input type="text" name="staffsurname" id="staffsurname" value="<?=$staffsurname?>"></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
                <td align="left" bgcolor="#FFFFFF"><input type="submit" name="button2" id="button" value="แสดงรายงาน"></td>
                <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
                <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            </table>
          </form></td>
        </tr>

        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#000000"><table width="100%" border="1" cellspacing="1" cellpadding="3" class="tbl3" bgcolor="#000000">
            <tr>
              <td colspan="7" align="center" bgcolor="#A3B2CC"><strong><? if($group_id == "3" or $group_id == "4"){ $file_script = "CC_addkeygroupn_script.php";}else{ $file_script = "CC_updatekp7_print.php";}?><a href="<?=$file_script?>" target="_blank">คลิ๊กประมวลผลเอกสารที่ลงลิสไปแล้ว</a>&nbsp;&nbsp;รายงานข้อมูลการปริ้นเอกสาร ก.พ.7 สำหรับการ QC ประจำเดือน <?=$monthFull[intval($mm)]?> ปี <?=$yy1?></strong></td>
              </tr>
            <tr>
              <td width="4%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
              <td width="18%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ชื่อนามสกุลพนักงานคีย์ข้อมูล</strong></td>
              <td width="11%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>กลุ่มการคีย์ข้อมูล</strong></td>
              <td width="19%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>พนักงานที่ทำการ QC</strong></td>
              <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>จำนวนเอกสาร ก.พ.7 ที่จะทำการ QC (ชุด)</strong></td>
              </tr>
            <tr>
              <td width="16%" align="center" bgcolor="#A3B2CC"><strong>ทั้งหมด(ชุด)</strong></td>
              <td width="16%" align="center" bgcolor="#A3B2CC"><strong>ปริ้นเรียบร้อยแล้ว(ชุด)</strong></td>
              <td width="16%" align="center" bgcolor="#A3B2CC"><strong>ค้างปริ้น(ชุด)</strong></td>
            </tr>
            <?
			
			
		$xmonth1 = ($yy1-543)."-".sprintf("%02d",$mm);		
		$txt_yy = $yy1;
		$txt_mm = $mm;
			//$constaff = " AND staffid='12016' ";
			
			if($site_id != "999"){
				$in_pin = GetPinStaff($site_id);
				if($in_pin != ""){ $conv2 = " AND t1.card_id IN($in_pin)";}else{ $conv2 = "";}
				ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			}// end if($site_id != "999"){
				
			if($staffname != ""){
					$constaff .= " and t1.staffname LIKE '%$staffname%' ";
			}
			if($staffsurname != ""){
					$constaff .= " and t1.staffsurname LIKE '%$staffsurname%' ";
			}
			
			if($group_id != ""){
					$congroup = " AND t1.keyin_group = '$group_id' ";
			}
			
			################### คนหาพนักงานคีย์ #######################
			
			if($staff_qc != ""){
					$instaff = GetQcMathkey($staff_qc);
					if($instaff != ""){
							$constaff1 = " AND t1.staffid IN($instaff)";
					}
			}
			
			

            	$sql = "SELECT
t1.staffid,
t1.prename,
t1.staffname,
t1.staffsurname,
Count(t2.idcard) AS numall,
Sum(if(t2.status_print='1',1,0)) AS num_print,
Sum(if(t2.status_print='0',1,0)) AS no_print,
t3.groupname,
t4.staffqc,
t1.keyin_group
FROM
keystaff as t1
Left Join tbl_person_print_kp7 as t2  ON t1.staffid = t2.staffid  and t2.datekqc LIKE '$xmonth1%' 
Left Join keystaff_group as t3 ON t1.keyin_group = t3.groupkey_id
Left Join keystaff_qc_math_key as t4 ON t1.staffid=t4.staffkey
where  t1.status_permit = 'YES' and t1.status_extra='NOR' and t1.keyin_group > 0  $conv2 $constaff $constaff1 $congroup
group by t1.staffid
order by t1.staffname ASC,t1.staffsurname ASC";
//echo $sql."<br><br>";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$i=0;
		$arrstaffqc = GetStaffQc();
		//echo "<pre>";
		//print_r($arrstaffqc);
		while($rs = mysql_fetch_assoc($result)){
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 if($rs[keyin_group] == "3" or $rs[keyin_group] == "4"){ $file_script = "CC_addkeygroupn_script.php";}else{ $file_script = "CC_updatekp7_print.php";}
			 
			 ?>
		
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$i?></td>
              <td align="left"><? echo "$rs[prename]$rs[staffname] $rs[staffsurname]";?>&nbsp;<a href="<?=$file_script?>?yymm=<?=$xmonth1?>&staffid=<?=$rs[staffid]?>" target="_blank"><img src="../../validate_management/images/script.png" width="16" height="16" title="คลิ๊กเพื่อประมวลผลการปร้ินเอกสาร ก.พ.7 สำหรับการ QC" border="0"></a></td>
              <td align="center"><? echo $rs[groupname];?></td>
              <td align="left"><? echo $arrstaffqc[$rs[staffqc]];?></td>
              <td align="center"><?  if($rs[numall] > 0){ echo "<a href='index_printkp7_detail.php?staffid=$rs[staffid]&yymm=$xmonth1&xtype=all&fullname=$rs[prename]$rs[staffname] $rs[staffsurname]&groupid=$rs[keyin_group]' target='_blank'>".number_format($rs[numall])."</a>";}else{ echo "0";}?></td>
              <td align="center"><?  if($rs[num_print] > 0){ echo "<a href='index_printkp7_detail.php?staffid=$rs[staffid]&yymm=$xmonth1&xtype=Y&fullname=$rs[prename]$rs[staffname] $rs[staffsurname]&groupid=$rs[keyin_group]' target='_blank'>".number_format($rs[num_print])."</a>";}else{ echo "0";}?></td>
              <td align="center"><? if($rs[no_print] > 0){ echo "<a href='index_printkp7_detail.php?staffid=$rs[staffid]&yymm=$xmonth1&xtype=N&fullname=$rs[prename]$rs[staffname] $rs[staffsurname]&groupid=$rs[keyin_group]' target='_blank'>".number_format($rs[no_print])."</a>";}else{ echo "0";}?></td>
            </tr>
           <?
		   $sum1 += $rs[numall];
		   $sum2 += $rs[num_print];
		   $sum3 += $rs[no_print];
		}//end 
		   ?>
               <tr bgcolor="#CCCCCC">
              <td colspan="4" align="right"><strong>รวม : </strong></td>
              <td align="center"><strong><?=number_format($sum1)?></strong></td>
              <td align="center"><strong><?=number_format($sum2)?></strong></td>
              <td align="center"><strong><?=number_format($sum3)?></strong></td>
            </tr>

          </table></td>
        </tr>
  </table></td>
          </tr>
      </table>
  </td>
    </tr>
  </table>
</body>
</html>
