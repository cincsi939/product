<?
set_time_limit(0);

include ("../../common/common_competency.inc.php")  ;
include("checklist.inc.php");
## �ʴ�������ࢵ��鹷�����֡��
function GetEduArea($get_secid){
	global $dbnamemaster;
	$sql_eduarea = "SELECT secname FROM eduarea WHERE secid='$get_secid'";
	$result_eduarea = mysql_db_query($dbnamemaster,$sql_eduarea);
	$rs_edu = mysql_fetch_assoc($result_eduarea);
	return $rs_edu[secname];
}
###  ��Ǩ�ͺ���ࢵ�١�׹�ѹ�ӹǹ�ؤ�ҡ��ࢵ�ҡ��� checklist �����ѧ
function CheckLockSite(){
	global $dbname_temp;
	$sql = "SELECT count(siteid) as num1,siteid FROM tbl_status_lock_site GROUP BY siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]] = $rs[num1];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}// end function CheckLockSite(){
	
function CheckImportToCmss($get_siteid){
	global $dbname_temp;
	$db_site = STR_PREFIX_DB."$get_siteid";
	$sql = "SELECT
count(edubkk_checklist.tbl_check_data.idcard) as num1,
sum(if(page_upload>0,1,0)) as numpdf,
sum(if(pic_upload>0,pic_upload,0)) as numpic
FROM
edubkk_checklist.tbl_checklist_profile 
Inner Join edubkk_checklist.tbl_checklist_kp7 ON edubkk_checklist.tbl_checklist_profile.profile_id = edubkk_checklist.tbl_checklist_kp7.profile_id
Inner Join edubkk_checklist.tbl_check_data ON edubkk_checklist.tbl_checklist_kp7.idcard = edubkk_checklist.tbl_check_data.idcard 
Inner Join $db_site.general ON  edubkk_checklist.tbl_check_data.idcard = $db_site.general.idcard
WHERE
edubkk_checklist.tbl_checklist_profile.status_active =  '1'
GROUP BY
edubkk_checklist.tbl_checklist_kp7.siteid
";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	$arr['numperson'] = $rs[num1];
	$arr['numpdf'] = $rs[numpdf];
	$arr['numpic'] = $arr[numpic];
	
	return $arr;
}//end function CheckImportToCmss($get_siteid){
	
### function �Ѻ������㹰ҹ������ checklidt
function NumDataChecklist(){
	global $dbname_temp;
	$sql = "SELECT
count(tbl_checklist_kp7.siteid) as num1,
sum(if(page_upload > 0,1,0)) as numpdf,
sum(if(pic_num > 0,pic_num,0)) as numpic,
siteid
FROM
tbl_checklist_kp7
Inner Join tbl_checklist_profile ON tbl_checklist_kp7.profile_id = tbl_checklist_profile.profile_id
WHERE
tbl_checklist_profile.status_active =  '1'
GROUP BY siteid
";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs['siteid']]['numperson'] = $rs[num1]	;
		$arr[$rs['siteid']]['numpdf'] = $rs[numpdf];
		$arr[$rs['siteid']]['numpic'] = $rs[numpic];
	}
	return $arr;
}//end function NumDataChecklist(){
	
	
	###########  function 
	function CountNumUpload($get_siteid){
		global $dbname_temp;
		$sql = "SELECT sum(if(status_file=0,1,0)) as num1,sum(if(status_file=1,1,0)) as num2, sum(if(status_file=2,1,0)) as num3,sum(if(status_file=3,1,0)) as num4,sum(if(status_file=4,1,0)) as num5,sum(if(status_file=99,1,0)) as num6,sum(if(status_file=9,1,0)) as num7,upload_id FROM log_upload_pdf_detail WHERE siteid='$get_siteid' and type_ref='Y' GROUP BY upload_id";
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[upload_id]]['Y'] = $rs[num2];
			$arr[$rs[upload_id]]['N'] = $rs[num1];
			$arr[$rs[upload_id]]['EN'] = $rs[num3];
			$arr[$rs[upload_id]]['RE'] = $rs[num4];
			$arr[$rs[upload_id]]['PERMI'] = $rs[num5];
			$arr[$rs[upload_id]]['Queue_error'] = $rs[num6];
			$arr[$rs[upload_id]]['file_old'] = $rs[num7];
		}//end while($rs = mysql_fetch_assoc($result)){
			return $arr;
	}//end function CountNumUpload(){

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<title>��§ҹ�ʴ��ӹǹ˹��¹Ѻ�����źؤ�ҡõ�����кǹ�����������֧��кǹ��ä��������</title>
</head>
<body>
<? if($action == ""){?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="11" align="left" bgcolor="#A5B2CE"><a href="script_manage_filepdfrefdoc.php?action=&profile_id=<?=$profile_id?>">��Ѻ˹������� upload</a> || <strong>��§ҹ log ��� upload ��� 
            <?=GetEduArea($xsiteid);?>
          </strong></td>
        </tr>
        <tr>
          <td width="3%" rowspan="3" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
          <td width="12%" rowspan="3" align="center" bgcolor="#A5B2CE"><strong>�ѹ���㹡�� upload ���</strong></td>
          <td width="27%" rowspan="3" align="center" bgcolor="#A5B2CE"><strong>��������´�ҹ</strong></td>
          <td colspan="8" align="center" bgcolor="#A5B2CE"><strong>ʶҹС�� upload</strong></td>
        </tr>
        <tr>
          <td width="6%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>��ҹ</strong></td>
          <td colspan="6" align="center" bgcolor="#A5B2CE"><strong>����ҹ</strong></td>
          <td width="10%" rowspan="2" align="center" bgcolor="#A5B2CE"><strong>���������</strong></td>
        </tr>
        <tr>
          <td width="6%" align="center" bgcolor="#A5B2CE"><strong>������µ�ͧ <br />
            Repair</strong></td>
          <td width="6%" align="center" bgcolor="#A5B2CE"><strong>�ѭ���������</strong></td>
          <td width="6%" align="center" bgcolor="#A5B2CE"><strong>�ѭ�� Xref</strong></td>
          <td width="6%" align="center" bgcolor="#A5B2CE"><strong>�ѭ������ͧ<br />
          permision ���</strong></td>
          <td width="6%" align="center" bgcolor="#A5B2CE"><strong>�������ö���� QUEUE ��</strong></td>
          <td width="6%" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ�����<br />����������</strong></td>
        </tr>
        <?
			$arr1 = CountNumUpload($xsiteid);
        	$sql = "SELECT * FROM  log_upload_pdf WHERE siteid='$xsiteid' AND type_ref='Y' ORDER BY date_upload DESC";
			$result = mysql_db_query($dbname_temp,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
				if($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				$upload_y = $arr1[$rs[upload_id]]['Y'];
				$upload_n = $arr1[$rs[upload_id]]['N'];
				$upload_en = $arr1[$rs[upload_id]]['EN'];
				$upload_re = $arr1[$rs[upload_id]]['RE'];
				$upload_per = $arr1[$rs[upload_id]]['PERMI'];
				$queue_error = $arr1[$rs[upload_id]]['Queue_error']; // queue error
				$upload_file_old = $arr1[$rs[upload_id]]['file_old'];
				$sum_upload = $upload_y+$upload_n+$upload_en+$upload_re+$upload_per+$queue_error+$upload_file_old;
				
				$txt = "�š�� upload ��� pdf �鹩�Ѻ�������ӹǹ $sum_upload ���  ";
				$txt .= " �ӹǹ���������ó� �ըӹǹ  $upload_y ���";

				if($upload_n > 0){
					$txt .= " �ӹǹ������������ó� �ըӹǹ  $upload_n ���";
				}else{
					$txt .= " ";	
				}
				if($upload_en > 0){
					$txt .= " �ӹǹ�����١������ʡ�͹���� �ӹǹ $upload_en ���";
				}
				if($upload_re > 0){
						$txt .= "�ӹǹ������µ�ͧ repair �ըӹǹ  $upload_re  ���";
				}
				if($upload_per > 0){
						$txt .= "�ӹǹ����ջѭ������ͧ permision �������������ö update ����� $upload_per ���";
				}
				if($queue_error > 0){
						$txt .= "�ӹǹ������������ö���� queue �� $queue_error ���";
				}if($upload_file_old > 0){
						$txt .= "�ӹǹ��������������� �ըӹǹ $upload_file_old ���";
				}
				####  �ѹ��� upload 
				$dateup = get_dateThai($rs[date_upload],"");
				$uploadall = $upload_y+$upload_n+$upload_en+$upload_re+$upload_per+$queue_error+$upload_file_old;
				//echo "$upload_y :: $upload_n";
		?>
        <tr bgcolor="<?=$bg?>">
          <td align="center"><?=$i?></td>
          <td align="center"><?=$dateup?></td>
          <td align="left"><?=$txt?></td>
          <td align="center"><? if($upload_y > 0){ echo "<a href='?action=view&status_file=1&upload_id=$rs[upload_id]&dateup=$dateup&folder_bk=$rs[folder_bk]&xsiteid=$rs[siteid]&numup=$upload_y'>".number_format($upload_y)."</a>";}else{ echo "0";}?></td>
          <td align="center"><? if($upload_re > 0){ echo "<a href='?action=view&status_file=3&upload_id=$rs[upload_id]&dateup=$dateup&folder_bk=$rs[folder_bk]&xsiteid=$rs[siteid]&numup=$upload_re'>".number_format($upload_re)."</a>";}else{ echo "0";}?></td>
          <td align="center"><? if($upload_en > 0){ echo "<a href='?action=view&status_file=2&upload_id=$rs[upload_id]&dateup=$dateup&folder_bk=$rs[folder_bk]&xsiteid=$rs[siteid]&numup=$upload_en'>".number_format($upload_en)."</a>";}else{ echo "0";}?></td>
          <td align="center"><? if($upload_n > 0){ echo "<a href='?action=view&status_file=0&upload_id=$rs[upload_id]&dateup=$dateup&folder_bk=$rs[folder_bk]&xsiteid=$rs[siteid]&numup=$upload_n'>".number_format($upload_n)."</a>";}else{ echo "0";}?></td>
          <td align="center"><? if($upload_per > 0){ echo "<a href='?action=view&status_file=4&upload_id=$rs[upload_id]&dateup=$dateup&folder_bk=$rs[folder_bk]&xsiteid=$rs[siteid]&numup=$upload_per'>".number_format($upload_per)."</a>";}else{ echo "0";}?></td>
          <td align="center"><?
          	if($queue_error > 0){ echo "<a href='?action=view&status_file=99&upload_id=$rs[upload_id]&dateup=$dateup&folder_bk=$rs[folder_bk]&xsiteid=$rs[siteid]&numup=$queue_error'>".number_format($uploadall)."</a>";}else{ echo "0";}
		  ?></td>
          <td align="center"><? if($upload_file_old > 0){ echo "<a href='?action=view&status_file=9&upload_id=$rs[upload_id]&dateup=$dateup&folder_bk=$rs[folder_bk]&xsiteid=$rs[siteid]&numup=$upload_file_old'>".number_format($upload_file_old)."</a>";}else{ echo "0";}?></td>
          <td align="center"><? if($uploadall > 0){ echo "<a href='?action=view&status_file=11&upload_id=$rs[upload_id]&dateup=$dateup&folder_bk=$rs[folder_bk]&xsiteid=$rs[siteid]&numup=$uploadall'>".number_format($uploadall)."</a>";}else{ echo "0";}?></td>
        </tr>
        <?
			}//end while($rs = mysql_fetch_assoc($result)){
		?>
      </table></td>
    </tr>
  </table>
  <?
			}//end if($action == ""){
	if($action == "view"){
		
		if($status_file == 1){
				$txt1 = "��§ҹ�ӹǹ�����չ��������ó� �ӹǹ  $numup  ���";
				$conv = " AND log_upload_pdf_detail.status_file='1'";
		}else if($status_file == "0"){
				$txt1 = "��§ҹ�ӹǹ����������������ó�  �ӹǹ  $numup  ���";	
				$conv = " AND log_upload_pdf_detail.status_file='0'";
		}else if($status_file == "2"){
				$txt1 = "��§ҹ�ӹǹ���������������ա���������������� �ӹǹ $numup ��� ";
				$conv = " AND log_upload_pdf_detail.status_file='2'";
		}else if($status_file == "3"){
				$txt1 = "��§ҹ�ӹǹ��������µ�ͧ Repair  �ӹǹ $numup  ���";	
				$conv = " AND log_upload_pdf_detail.status_file='3'";
		}else if($status_file == "4"){
				$txt1 = "��§ҹ�ӹǹ����ջѭ������ͧ permision �������������ö update ����� $numup ���";
				$conv = " AND log_upload_pdf_detail.status_file='4'";
		}else if($status_file == "99"){
				$txt1 = "��§ҹ�ӹǹ����ջѭ������ͧ ������� Queue �ӹǹ  $numup ���";
				$conv = " AND log_upload_pdf_detail.status_file='99'";
		}else if($status_file == "9"){
				$txt1 = "��§ҹ�ӹǹ��������������� �ըӹǹ $numup ���";
				$conv = " AND log_upload_pdf_detail.status_file='9'";
		}else{
				$txt1 = "��§ҹ�ӹǹ��������ҷ����� �ӹǹ  $numup  ���";	
				$conv = " ";
		}
  ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="6" align="center" bgcolor="#A5B2CE"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="6%" align="center" valign="top"><strong><a href="?action=&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>">��͹��Ѻ</a></strong></td>
              <td width="94%" align="center"><strong>
                <?=$txt1?><br />
                <?=GetEduArea($xsiteid);?>
                <br />
                <?=$dateup?>
                <br />
<!--���������������ͧ�����������-->
<?//=$folder_bk?>
              </strong></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td width="3%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
          <td width="16%" align="center" bgcolor="#A5B2CE"><strong>�ѵû�Шӵ�ǻ�ЪҪ�</strong></td>
          <td width="19%" align="center" bgcolor="#A5B2CE"><strong>���� - ���ʡ��</strong></td>
          <td width="23%" align="center" bgcolor="#A5B2CE"><strong>���˹�</strong></td>
          <td width="24%" align="center" bgcolor="#A5B2CE"><strong>˹��§ҹ</strong></td>
          <td width="15%" align="center" bgcolor="#A5B2CE"><strong>���</strong></td>
        </tr>
        <?
        $sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
CAST(tbl_checklist_kp7.schoolid AS UNSIGNED) as schoolid 
FROM
log_upload_pdf_detail
Inner Join tbl_checklist_kp7 ON log_upload_pdf_detail.idcard = tbl_checklist_kp7.idcard
WHERE
log_upload_pdf_detail.upload_id =  '$upload_id'  and log_upload_pdf_detail.type_ref='Y' $conv
ORDER  BY schoolid ASC";
//echo $sql;
		$result = mysql_db_query($dbname_temp,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			$path_file = "../../../".PATH_KP7_REFDOC_FILE."/$rs[siteid]/$rs[idcard]"."R.pdf";
			if($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			
			if(is_file($path_file)){
				$img_pdf = "<a href='$path_file' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='�.�.7 ���Ҩҡ�鹩�Ѻ' width='16' height='16' border='0'></a>";
			}else{
				$img_pdf = "";	
				$bg = "#FF9900";
			}//end 

		?>
        <tr bgcolor="<?=$bg?>">
          <td align="center"><?=$i?></td>
          <td align="center"><?=$rs[idcard]?></td>
          <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
          <td align="left"><? echo "$rs[position_now]";?></td>
          <td align="left"><?=show_school($rs[schoolid]);?></td>
          <td align="center"><?=$img_pdf?></td>
        </tr>
        <?
		}//end while($rs = mysql_fetch_assoc($result)){
		?>
      </table></td>
    </tr>
  </table>
<?
	}//end if($action == "view"){
  ?>
</body>
</html>
