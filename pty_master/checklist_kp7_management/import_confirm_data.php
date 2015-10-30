<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_j18.php");
include("../../common/transfer_data/function_transfer.php");
include("../../common/class.getdata_master.php");
include("../../common/class.downloadkp7.php");
include("class/class.compare_data.php");
$obj_imp = new Compare_DataImport();
$obj = new GetDataMaster();
$obj_kp7 = new downloadkp7();
$arr_sex = array("1"=>"ชาย","2"=>"หญิง");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	if($action == "process"){
		$sql_count = "SELECT t1.idcard,count(idcard) as numlist  FROM edubkk_checklist.log_import_cmss_confirm AS t1 Inner Join edubkk_checklist.field_import_data_confirm AS t2 ON t1.field_id = t2.field_id Inner Join edubkk_master.view_general AS t3 ON t1.idcard = t3.CZ_ID WHERE t1.import_id = '$import_id' AND t1.siteid = '$xsiteid' AND t1.status_confirm='0'
		group by t1.idcard ORDER BY t3.name_th,surname_th ASC";
		$result_count = mysql_db_query($dbname_temp,$sql_count) or die(mysql_error()."$sql_count<br>LINE__".__LINE__);
		while($rsc = mysql_fetch_assoc($result_count)){
			$xarr[$rsc[idcard]] = $rsc[numlist]	;
		}
		
		
		
		$sql = "SELECT
t1.import_id,
t1.idcard,
t1.field_id,
t2.field_comment,
t2.field_compare,
t2.field_label,
t1.value_import,
t1.value_check,
t1.status_confirm,
t3.prename_th,
t3.name_th,
t3.surname_th,
t3.position_now
FROM
edubkk_checklist.log_import_cmss_confirm AS t1
Inner Join edubkk_checklist.field_import_data_confirm AS t2 ON t1.field_id = t2.field_id
Inner Join edubkk_master.view_general AS t3 ON t1.idcard = t3.CZ_ID
WHERE
t1.import_id =  '$import_id' AND
t1.siteid =  '$xsiteid' AND t1.status_confirm='0'
ORDER BY t3.name_th,surname_th ASC";
#echo $sql."<hr>";
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$conField = "";
	$k=0;
	while($rs = mysql_fetch_assoc($result)){
					$k++;
			if($arr_confirm[$rs[idcard]][$rs[field_id]] == "YES"){
					if($conField > "") $conField .= ",";
					$conField .= "$rs[field_compare]="."'$rs[value_check]'";
					#echo $rs[field_label]."<hr>";
					if($rs[field_label] != ""){
						$conField .= ",$rs[field_label]="."'".$arr_sex[$rs[value_check]]."'";
					}
					### UPDATE การยืนยันข้อมูล
			}// if($arr_confirm[$rs[idcard]][$rs[field_id]] == "1"){
				
				if($arr_confirm[$rs[idcard]][$rs[field_id]] != ""){
					$obj_imp->SaveConfirmData($import_id,$rs[idcard],$rs[field_id],$_SESSION['session_staffid'],$arr_confirm[$rs[idcard]][$rs[field_id]]);
				}
				#echo $xarr[$rs[idcard]]." == $k<br>";
				### update  ข้อมูลใน general
				if($xarr[$rs[idcard]] == $k){
					$obj_imp->UpdateGeneral($rs[siteid],$rs[idcard],$conField);
					$k=0;
					$conField = "";
				}// end if($xarr[$rs[idcard]] == $k){


	}//end 	while($rs = mysql_fetch_assoc($result)){
		
	
/*		echo "<script>alert('ยืนยันการนำเข้าข้อมูลสู่ระบบ cmss เรียบร้อยแล้ว');location.href='?xsiteid=$xsiteid&import_id=$last_id';</script>";
		exit;
*/	}// end if($action == "process"){
		
}//end if($_SERVER['REQUEST_METHOD'] == "POST"){




###  end ประมวลผลรายการ
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="5" align="center" bgcolor="#CCCCCC"><strong>รายการยืนยันการนำเข้าข้อมูลสู่ฐาน cmss กรณีที่ ข้อมูลไม่ตรงกัน<br><? echo $obj->GetAreaName($xsiteid,"secname");?>
              </strong></td>
              </tr>
            <tr>
              <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
              <td width="31%" align="center" bgcolor="#CCCCCC"><strong>รายการข้อมูล</strong></td>
              <td width="22%" align="center" bgcolor="#CCCCCC"><strong>ข้อมูลใน checklist</strong></td>
              <td width="26%" align="center" bgcolor="#CCCCCC"><strong>ข้อมูลในระบบ cmss</strong></td>
              <td width="16%" align="center" bgcolor="#CCCCCC">
                <input type="submit" name="btn_submit" id="btn_submit" value="บันทึก">
                <input type="hidden" name="action" value="process">
                <input type="hidden" name="import_id" value="<?=$import_id?>">
                <input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
              </td>
            </tr>
            <?
            	$sql = "SELECT
t1.import_id,
t1.idcard,
t1.field_id,
t2.field_comment,
t2.field_label,
t1.value_import,
t1.value_check,
t1.status_confirm,
t3.prename_th,
t3.name_th,
t3.surname_th,
t3.position_now
FROM
edubkk_checklist.log_import_cmss_confirm AS t1
Inner Join edubkk_checklist.field_import_data_confirm AS t2 ON t1.field_id = t2.field_id
Inner Join edubkk_master.view_general AS t3 ON t1.idcard = t3.CZ_ID
WHERE
t1.import_id =  '$import_id' AND
t1.siteid =  '$xsiteid' and t1.status_confirm='0'
ORDER BY t3.name_th,surname_th ASC,t2.field_comment asc";
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<hr>LINE__".__LINE__);
	$i=0;
	$j=0;
	while($rs = mysql_fetch_assoc($result)){
	
		if($rs[idcard] != $temp_idcard){
			$j++;
			echo "<tr bgcolor=\"#CCCCCC\">
			<td align=\"center\">$j</td>
			<td align=\"left\" colspan=\"4\"> $rs[idcard]   $rs[prename_th]$rs[name_th] $rs[surname_th]  (ตำแหน่ง : $rs[position_now]) ก.พ.7 ".$obj_kp7->get_pdforg("../../../kp7file",$xsiteid,$rs[idcard])." ".$obj_kp7->get_elecimg($xsiteid,$rs[idcard])." </td>
			</tr>";
				
			$temp_idcard = $rs[idcard];
			$i=0;
		}

			if ($i++ % 2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			
			if($rs[field_label] == "sex"){
				$label_checklist = $arr_sex[	$rs[value_check]];
				$label_cmss = $arr_sex[	$rs[value_import]];
			}else{
				$label_checklist = $rs[value_check];
				$label_cmss = $rs[value_import];
					
			}
		
			?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><? echo $j.".".$i;?></td>
              <td align="left"><? echo "$rs[field_comment]";?></td>
              <td align="center"><? echo "$label_checklist";?></td>
              <td align="center"><? echo "$label_cmss";?></td>
              <td align="center">
                <input type="radio" name="arr_confirm[<?=$rs[idcard]?>][<?=$rs[field_id]?>]" id="radio_id<?=$rs[idcard]."_".$rs[field_id]?>" value="YES">ยืนยัน
                <input type="radio" name="arr_confirm[<?=$rs[idcard]?>][<?=$rs[field_id]?>]" id="radio_id<?=$rs[idcard]."_".$rs[field_id]?>" value="NO">ไม่ยืนยัน
              </td>
            </tr>
            <?
	}//end 	while($rs = mysql_fetch_assoc($result)){
			?>
          </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>หมายเหตุ: ยืนยัน คือ การนำข้อมูลใน checklist ไป update ใน cmss<br></td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ไม่ยืนยัน คือ ใช้ข้อมูลเดิมที่มีอยู่ในระบบ cmss</td>
  </tr>
</table>
</body>
</html>
