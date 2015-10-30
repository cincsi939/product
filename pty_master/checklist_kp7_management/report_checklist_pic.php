<?
set_time_limit(0);
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "checklistkp7_report_pobec"; 
$process_id			= "checklistkp7_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20100809.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2010-08-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20100809.00
	## Modified Detail :		ระบบตรวจสอบข้อมูลทะเบียนประวัติต้นฉบับ
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################


include("../../common/common_competency.inc.php");
include("checklist2.inc.php");
$time_start = getmicrotime();

$dbname2=$dbname_temp=DB_CHECKLIST;

if($profile_id == ""){
	$profile_id = LastProfile();	
}//end if($profile_id == ""){


function XNumPersonKey($profile_id){
	global $dbname_temp;
	$sql = "SELECT
edubkk_checklist.tbl_checklist_kp7.siteid,
count(edubkk_checklist.tbl_checklist_kp7.idcard) as numkey
FROM
edubkk_checklist.tbl_checklist_kp7
Inner Join callcenter_entry.tbl_assign_key ON edubkk_checklist.tbl_checklist_kp7.idcard = callcenter_entry.tbl_assign_key.idcard
AND edubkk_checklist.tbl_checklist_kp7.siteid = callcenter_entry.tbl_assign_key.siteid
WHERE
edubkk_checklist.tbl_checklist_kp7.profile_id =  '$profile_id' AND
callcenter_entry.tbl_assign_key.nonactive =  '0' AND
callcenter_entry.tbl_assign_key.approve =  '2'
GROUP BY
edubkk_checklist.tbl_checklist_kp7.siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr1[$rs[siteid]]['numkey'] = $rs['numkey'];
	}
	return $arr1;
}//



function CountPicsysTemp($profile_id){
	global $dbnamemaster;
	
	$sql = "SELECT
	 eduarea.secid,
	if(substring(eduarea.secid,1,1)=0,'spm','spp') as subsite
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' AND
eduarea_config.profile_id =  '$profile_id' ";
//echo $dbnamemaster ." :: ".$sql;
$result = mysql_db_query($dbnamemaster,$sql);
$personcmss = XNumPersonKey($profile_id);
while($rs = mysql_fetch_assoc($result)){
	$arr[$rs[secid]][$rs[subsite]]['numall'] = $personcmss[$rs[secid]]['numkey'];
	$arr[$rs[secid]][$rs[subsite]]['numpic'] = CountPicSys($rs[secid],"","","$profile_id");
	
}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function CountPicsysTemp($profile_id){



function xCheckUnlockIcon($profile_id){
	global $dbname_temp;
	$sql = "SELECT count(siteid) as num1,siteid  FROM `tbl_status_unlock_site` WHERE profile_id='$profile_id' and status_unlock='1' group by siteid";	
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arrx[$rs[siteid]] = $rs[num1];
	}//end while($rs = mysql_fetch_assoc($result)){
return $arrx;	
}//end function CheckUnlockIcon(){





function read_file_folder(){
		$Dir_Part="../../../checklist_kp7file/fileall/";
		$Dir=opendir($Dir_Part);
		while($File_Name=readdir($Dir)){
			if(($File_Name!= ".") && ($File_Name!= "..")){
				$Name .= "$File_Name";
			}
					
		}
		closedir($Dir);
		///ปิด Directory------------------------------	
		$File_Array=explode(".pdf",$Name);
		return $File_Array;
	}// end function read_file_folder($secid){
	// edit_pic----------------------------------------------------------------------------------------
	
	## function count จำนวนคน กับไฟล์ pdf
	function CountPersonPdf($get_siteid){
		global $dbname_temp;	
		$sql = "SELECT 
		count(idcard) as NumPerson,
		sum(if(page_upload > 0,1,0)) as NumPdf,
		sum(if(page_upload > 0 and page_upload <> page_num,1,0)) as NumPageFail
		FROM tbl_checklist_kp7 WHERE siteid='$get_siteid'";
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		$arr['NumPdf'] = $rs[NumPdf];
		$arr['NumPerson'] = $rs[NumPerson];
		$arr['NumPageFail'] = $rs[NumPageFail];
		return $arr;
	}
	
	###
	function AddLogPdf($get_idcard,$get_siteid,$get_action){
		global $dbname_temp;
		$sql = "INSERT INTO tbl_log_upload_pdf SET idcard='$get_idcard',siteid='$get_siteid',action='$get_action'";
		mysql_db_query($dbname_temp,$sql);
	}
	###  สร้าง โฟล์เดอร์
	function xRmkdir($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
	mkdir($way);
	}
}
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<title>เครื่องมือจัดการ checklist รูป</title>
</head>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>
<body>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="1" cellpadding="3" style="display:<?=$sent_secid?"none":"block"?>" >
        <tr>
          <td width="28%" align="right"><strong>เลือกโปรไฟล์ :</strong></td>
          <td width="39%">
          <select name="profile_id" id="profile_id" onchange="gotourl(this)">
          <option value="">เลือกโฟล์ไฟล์</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<option value="?profile_id=<?=$rsp[profile_id]?>&action=<?=$action?>&lv=<?=$lv?>&xsiteid=<?=$xsiteid?>&schoolid=<?=$schoolid?>&xtype=<?=$xtype?>" <?=$sel?>><?=$rsp[profilename]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
        </select> 
          
          </td>
          <td width="33%">&nbsp;</td>
        </tr>
      </table>
    </form><br />

    
<? if($action == ""){
	
		$arr_1 = show_val_exsumall($profile_id);
		$arrpic = CountPicsysTemp($profile_id);
		$arrunlocksite = xCheckUnlockIcon($profile_id);
		//echo "<pre>";
		//print_r($arr_1);
		
		//echo "<hr><pre>";
		//print_r($arrpic);
		
		//$sumall1=  array_sum($arr_1);
		//$sumallpic = array_sum($arrpic);
		if(count($arr_1) > 0){
				foreach($arr_1 as $key1 => $val1){
					
					$sumall_ch_spm += $val1['numall']['spm']; // จำนวนคนทั้งหมด
					$sumall_chpic_spm += $val1['numpic']['spm']; // จำนวนรูปทั้งหมด
				
					
					
					$sumall_ch_spp += $val1['numall']['spp']; // จำนวนคนทั้งหมด
					$sumall_chpic_spp += $val1['numpic']['spp']; // จำนวนรูปทั้งหมด
					
					####  
					//echo "".$val1['numpic']['spm']." :: ".$arrpic[$key1]['spm']['numpic']."<br>";
					if($val1['numpic']['spm'] > 0){
						$sumall_picsys_spm += $arrpic[$key1]['spm']['numpic'];
					}////end if($val1['numpic']['spm'] > 0){
					if($val1['numpic']['spp'] > 0){
						$sumall_picsys_spp += $arrpic[$key1]['spp']['numpic'];
					}//end if($val1['numpic']['spp'] > 0){

					
				}//end foreach($arr_1 as $key1 => $val1){
		}//end 	if(count($arr_1) > 0){
			
//			if(count($arrpic) > 0){
//				foreach($arrpic as $k1 => $v1){
//					$sumall_picsys_spp += $val1['spp']['numpic'];
//					$sumall_picsys_spm += $val1['spm']['numpic'];
//				}// end 	foreach($arrpic as $k1 => $v1){
//				
//			}//end if(count($arrpic) > 0){

				$sumall_dif_spm = $sumall_chpic_spm-$sumall_picsys_spm;
				$sumall_dif_spp = $sumall_chpic_spp-$sumall_picsys_spp;

	?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td colspan="7" align="center" bgcolor="#CCCCCC"><strong>รายงานสถานะการจัดทำข้อมูลปฐมภูมิส่วนรูปภาพเจ้าของทะเบียนประวัติ</strong></td>
            </tr>
          <tr>
            <td width="31%" rowspan="2" align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>บุคลากรทั้งหมด</strong></td>
            <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>จำนวนรูปในระบบ CMSS</strong></td>
            <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>ค้างดำเนินการ</strong></td>
            </tr>
          <tr>
            <td width="12%" align="center" bgcolor="#CCCCCC"><strong>(คน)</strong></td>
            <td width="11%" align="center" bgcolor="#CCCCCC"><strong>(รูป)</strong></td>
            <td width="12%" align="center" bgcolor="#CCCCCC"><strong>(รูป)</strong></td>
            <td width="12%" align="center" bgcolor="#CCCCCC"><strong>(ร้อยละ)</strong></td>
            <td width="11%" align="center" bgcolor="#CCCCCC"><strong>(รูป)</strong></td>
            <td width="11%" align="center" bgcolor="#CCCCCC"><strong>(ร้อยละ)</strong></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#FFFFFF"><strong><a href="?action=&xtype=spp&profile_id=<?=$profile_id?>">สพป.</a></strong></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($sumall_ch_spp);?></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($sumall_chpic_spp);?></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($sumall_picsys_spp);?></td>
            <td align="center" bgcolor="#FFFFFF"><? if($sumall_chpic_spp > 0){ echo number_format(($sumall_picsys_spp*100)/$sumall_chpic_spp,2);}else{ echo "0.00";}?></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($sumall_dif_spp);?></td>
            <td align="center" bgcolor="#FFFFFF"><? if($sumall_chpic_spp > 0){ echo number_format(($sumall_dif_spp*100)/$sumall_chpic_spp,2);}else{  echo "0.00";}?></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#FFFFFF"><strong><a href="?action=&xtype=spm&profile_id=<?=$profile_id?>">สพม.</a></strong></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($sumall_ch_spm);?></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($sumall_chpic_spm);?></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($sumall_picsys_spm);?></td>
            <td align="center" bgcolor="#FFFFFF"><? if($sumall_chpic_spm > 0){ echo number_format(($sumall_picsys_spm*100)/$sumall_chpic_spm,2);}else{ echo "0.00";}?></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($sumall_dif_spm);?></td>
            <td align="center" bgcolor="#FFFFFF"><? if($sumall_chpic_spm > 0){ echo number_format(($sumall_dif_spm*100)/$sumall_chpic_spm,2);}else{ echo "0.00";}?></td>
          </tr>
          <?
          	$allnum1 = $sumall_ch_spm+$sumall_ch_spp; // จำนวนบุคลากรทั้งหมด
			$allchpic1 = $sumall_chpic_spm+$sumall_chpic_spp;// จำนวนรูปที่นับจาก checklist
			$allsyspic1 = $$sumall_picsys_spm+$sumall_picsys_spp;// จำนวนรูปทั้งหมดในระบบ
			$alldiffpic1 = $sumall_dif_spm+$sumall_dif_spp;// จำนวนรูปที่ค้างทั้งหมด
		  ?>
          <tr>
            <td align="center" bgcolor="#FFFFFF"><strong><a href="?action=&xtype=all&profile_id=<?=$profile_id?>">รวม</a></strong></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($allnum1);?></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($allchpic1);?></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($allsyspic1);?></td>
            <td align="center" bgcolor="#FFFFFF"><? if($allchpic1 > 0){ echo number_format(($allsyspic1*100)/$allchpic1,2);}else{ echo "0.00";}?></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($alldiffpic1);?></td>
            <td align="center" bgcolor="#FFFFFF"><? if($allchpic1 > 0){ echo number_format(($alldiffpic1*100)/$allchpic1,2);}else{ echo "0.00";}?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right"><strong>รายงาน ณ วันที่ <?=GetDateThaiFull(date("Y-m-d"));?></strong>&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
  <tr>
  <td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bordercolor="#000000">

  <tr>
    <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
    <td rowspan="2" align="center" bgcolor="#CCCCCC">&nbsp;</td>
    <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
    <td height="24" colspan="2" align="center" bgcolor="#CCCCCC"><strong>จำนวนบุคลากรทั้งหมด (Checklist)</strong></td>
    <td height="24" colspan="2" align="center" bgcolor="#CCCCCC"><strong>จำนวนรูปในระบบ CMSS (ข้อมูลปฐมภูมิ)</strong></td>
    <td height="24" colspan="3" align="center" bgcolor="#CCCCCC"><strong>จำนวนที่ค้างดำเนินการ</strong></td>
    </tr>
  <tr>
    <td align="center" bgcolor="#CCCCCC"><strong> (คน)</strong></td>
    <td height="24" align="center" bgcolor="#CCCCCC"><strong>(รูป)</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>(คน)</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>(รูป)</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>(คน)</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>(รูป)</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>(ร้อยละ)</strong></td>
    </tr>
  <?
	$j = 1;
	 if($xtype == "spp"){
			$conw1 = " AND eduarea.secid NOT LIKE '0%'";
	}else if($xtype == "spm"){
			$conw1 = " AND eduarea.secid  LIKE '0%'";
	}else if($xtype == "all"){
			$conw1 = "";
	}else{  // defult เป็น สพป.
			$conw1 = " AND eduarea.secid NOT LIKE '0%'";
	}//end  if($xtype == "spp"){
	
	$sql = "SELECT eduarea.secid, eduarea.name_proth, eduarea.office_ref, eduarea.secname, eduarea.provid, eduarea.partid, eduarea.siteid,eduarea.secname_short,
eduarea.status,
eduarea.msg,
eduarea.area_id,
eduarea.beunderid,
eduarea.area_under,
eduarea.staff_gain,
eduarea.staff_empty,
eduarea.import_pobec,
eduarea.config_area,
eduarea.full_area,
eduarea.no_import_pobec,
eduarea.status_area53,
if(substring(eduarea.secid,1,1) ='0',cast(secid as SIGNED),9999) as idsite,
if(substring(eduarea.secid,1,1)=0,'spm','spp') as subsite
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' AND
eduarea_config.profile_id =  '$profile_id' $conw1
order by idsite, eduarea.secname  ASC";

	$result = mysql_db_query(DB_MASTER,$sql) ;
	$i=0;
	while($rs = mysql_fetch_assoc($result)){	
	
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
		
		$xnumpic =$arr_1[$rs[secid]]['numpic'][$rs[subsite]];
		$xnumall = $arr_1[$rs[secid]]['numall'][$rs[subsite]];
		
		$count2 = $arr_1[$rs[secid]]['NumPass'][$rs[subsite]]+$arr_1[$rs[secid]]['NumNoPass'][$rs[subsite]]+$arr_1[$rs[secid]]['NumNoMain'][$rs[subsite]];
		$count3_1 = $arr_1[$rs[secid]]['NumDisC'][$rs[subsite]];
				
		
		$numpicsys = $arrpic[$rs[secid]][$rs[subsite]]['numpic'];
		$numpersonsys = $arrpic[$rs[secid]][$rs[subsite]]['numall'];
		
		
		$orgname1 = str_replace("สพท.","",$rs[secname_short]);
		$diffperson = $xnumall-$numpersonsys; // จำนวนคนที่ค้าง
		$diffpic = $xnumpic-$numpicsys;// จำนวนรูปที่ค้าง
	
		
	//	echo "$count2  ::  $count3_1 ::  ".$arrunlocksite[$rs[secid]]."<br>";
		if($count2 > 0 and $count3_1 == "0" and $arrunlocksite[$rs[secid]] < 1){
		
			if($xnumpic > 0 and ($xnumpic != $numpicsys)){
					//$bgcolor1 = "#FF9491";
					$iconx = "<img src='../../images_sys/circle2.gif' border='0' width='19' height='19' title='สถานะข้อมูลจำนวนรูปไม่ตรงกัน'>";
					$iconF1 = "<font color=\"green\">*</font>";
					$xt1 = 1;
			}else{
					//$bgcolor1 = $bgcolor1;
					$iconx = "";
					$iconF1 = "";
					$xt1 = 0;
			}
			
				$label_pic = number_format($xnumpic);
				$numpicsys = $numpicsys;
				$label_numpicsys = number_format($numpicsys);
				$diffpic = $diffpic;
				$label_diffpic = number_format($diffpic);
			
		}else{
					$iconx = "";
					$iconF1 = "";
					$xt1 = 0;
			
			if($xnumpic < 1){
				$label_pic = "N/A";	
				$numpicsys = 0;
				$label_numpicsys = "N/A";
				$diffpic = 0;
				$label_diffpic = "N/A";
			}else{
				$label_pic = number_format($xnumpic);
				$numpicsys = $numpicsys;
				$label_numpicsys = number_format($numpicsys);
				$diffpic = $diffpic;
				$label_diffpic = number_format($diffpic);
			}
				
		}//end if($count2 > 0 and $count3_1 == "0" and $arrunlocksite[$rs[secid]] < 1){
		
	
	?>
  <tr bgcolor="<?=$bg?>">
    <td width="3%" height="24" align="center"><?=$i?></td>
    <td width="3%" align="center"><?=$iconx?></td>
    <td width="25%"><a href="?action=getdata&sent_secid=<?=$rs[secid]?>&profile_id=<?=$profile_id?>&xt1=<?=$xt1?>&xnumall=<?=$xnumall?>&xnumpic=<?=$xnumpic?>&numpicsys=<?=$numpicsys?>&diffpic=<?=$diffpic?>" target="_blank"><?=$orgname1?></a>&nbsp;<?=$iconF1?></td>
    <td width="11%" align="center"><? echo number_format($xnumall);?></td>
    <td width="10%" align="center"><? echo $label_pic;?></td>
    <td width="10%" align="center"><?=number_format($numpersonsys);?></td>
    <td width="11%" align="center"><?=$label_numpicsys;?></td>
    <td width="9%" align="center"><?=number_format($diffperson);?></td>
    <td width="9%" align="center"><?=$label_diffpic;?></td>
    <td width="9%" align="center"><? if($xnumpic > 0){ echo number_format(($diffpic*100)/$xnumpic,2);}else{ echo "N/A";}?></td>
    </tr>
 <? 
 $j++ ;
 
 $NumAll += $xnumall;
 $NumPic += $xnumpic;
 $NumPicsysAll += $numpicsys;
 $NumPersonsysAll += $numpersonsys ;
 $NumDiffPersonAll += $diffperson;
 $NumDiffPicAll += $diffpic;
 
 }  // end while
  ?> 
  <tr bgcolor="<?=$bgcolor1?>">
    <td height="24" colspan="3" align="right" bgcolor="#FFFFFF"><strong>รวม :</strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong><?=number_format($NumAll);?></strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($NumPic);?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong><?=number_format($NumPersonsysAll);?></strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($NumPicsysAll);?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong><?=number_format($NumDiffPersonAll)?></strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong><?=number_format($NumDiffPicAll)?></strong></td>
    <td align="center" bgcolor="#FFFFFF"><? if($NumPic > 0){ echo number_format(($NumDiffPicAll*100)/$NumPic,2);}else{ echo "0.00";}?></td>
    </tr>
</table>
</td></tr></table>
<? } // end if($action == ""){

if($action == "getdata"){
	
	      	$sql_chk = "SELECT *,CAST(schoolid AS SIGNED) as sid,if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0',1,0) as sfile FROM tbl_checklist_kp7 WHERE siteid='$sent_secid' AND  `profile_id` LIKE '$profile_id' ORDER  BY sid ASC";
		$result_chk = mysql_db_query($dbname_temp,$sql_chk);
		$i=0;
		$a = 10000;
		$b = 20000;
		$arr11 = CountPicSysV1($sent_secid,"","",$profile_id);
		while($rs_c = mysql_fetch_assoc($result_chk)){
				if ($bgcolor1 == "#DDDDDD"){  $bgcolor1 = "#EFEFEF"  ; } else {$bgcolor1 = "#DDDDDD" ;}
		$i++;
		$num_pics = $arr11[$rs_c[idcard]];
		if($rs_c[sfile] == "0"){
				$alert_file = "<img src=\"../../images_sys/alert.gif\" width=\"16\" height=\"16\" border=\"0\" title=\"สถานะเอกสารไม่สมบูรณ์\">";
		}else{
				$alert_file = "";	
		}
		
		
			if($rs_c[pic_num] > 0 and ($rs_c[pic_num] != $num_pics)){
				$arrid[$a] = $rs_c[idcard];
				$arrname[$a] = "$rs_c[prename_th]$rs_c[name_th]  $rs_c[surname_th]";
				$arrposition[$a] =  "$rs_c[position_now]";
				$arrschool[$a] = show_school($rs_c[schoolid]);
				$arrpic[$a] = $rs_c[pic_num];
				$arrpics[$a] = $num_pics;
				$bg[$a] = $bgcolor1;
				$alertF[$a] = $alert_file;
				if($xt1 == 1){
				$xicona[$a] =  "<img src='../../images_sys/circle2.gif' border='0' width='19' height='19' title='สถานะข้อมูลจำนวนรูปไม่ตรงกัน'>";
				}//end 
				$a++;
			}else{
				$arrid[$b] = $rs_c[idcard];
				$arrname[$b] = "$rs_c[prename_th]$rs_c[name_th]  $rs_c[surname_th]";
				$arrposition[$b] =  "$rs_c[position_now]";
				$arrschool[$b] = show_school($rs_c[schoolid]);
				$arrpic[$b] = $rs_c[pic_num];
				$arrpics[$b] = $num_pics;
				$bg[$b] = $bgcolor1;
				$xicona[$b] =  "";
				$alertF[$b] = $alert_file;
				$b++;

			}
		}//end //end while
		
		

					$sumall_chpic  = array_sum($arrpic);
					$sumall_picsys = array_sum($arrpics);
					$sumall_ch = $i;
					$sumall_dif = $sumall_chpic-$sumall_picsys;

?>

<table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="7" align="center" bgcolor="#CCCCCC"><strong>รายงานสถานะการจัดทำข้อมูลปฐมภูมิส่วนรูปภาพเจ้าของทะเบียนประวัติ&nbsp;<?=ShowAreaSortName($sent_secid);?>
&nbsp;
<?=ShowDateProfile($profile_id)?></strong></td>
      </tr>
      <tr>
        <td width="31%" rowspan="2" align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>บุคลากรทั้งหมด</strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>จำนวนรูปในระบบ CMSS</strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>ค้างดำเนินการ</strong></td>
      </tr>
      <tr>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>(คน)</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>(รูป)</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>(รูป)</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>(ร้อยละ)</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>(รูป)</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>(ร้อยละ)</strong></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#FFFFFF"><strong>ข้อมูลรูปภาพเจ้าของทะเบียนประวัติ</strong></td>
        <td align="center" bgcolor="#FFFFFF"><?=number_format($xnumall);?></td>
        <td align="center" bgcolor="#FFFFFF"><?=number_format($xnumpic);?></td>
        <td align="center" bgcolor="#FFFFFF"><?=number_format($numpicsys);?></td>
        <td align="center" bgcolor="#FFFFFF"><? if($xnumpic > 0){ echo number_format(($numpicsys*100)/$xnumpic,2);}else{ echo "0.00";}?></td>
        <td align="center" bgcolor="#FFFFFF"><?=number_format($diffpic);?></td>
        <td align="center" bgcolor="#FFFFFF"><? if($xnumpic > 0){ echo number_format(($diffpic*100)/$xnumpic,2);}else{  echo "0.00";}?></td>
      </tr>
      <?
          	$allnum1 = $sumall_ch_spm+$sumall_ch_spp; // จำนวนบุคลากรทั้งหมด
			$allchpic1 = $sumall_chpic_spm+$sumall_chpic_spp;// จำนวนรูปที่นับจาก checklist
			$allsyspic1 = $$sumall_picsys_spm+$sumall_picsys_spp;// จำนวนรูปทั้งหมดในระบบ
			$alldiffpic1 = $sumall_dif_spm+$sumall_dif_spp;// จำนวนรูปที่ค้างทั้งหมด
		  ?>
    </table></td>
  </tr>
</table>
<br />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" align="center" bgcolor="#CCCCCC"><strong>รายงานข้อมูลรูปภาพเจ้าของทะเบียนประวัติรายบุคล</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="4%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="15%" align="center" bgcolor="#CCCCCC"><strong>รหัสบัตร</strong></td>
        <td width="15%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="14%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td width="14%" align="center" bgcolor="#CCCCCC"><strong>หน่วยงาน</strong></td>
        <td width="16%" align="center" bgcolor="#CCCCCC"><strong>จำนวนรูปในระบบ (Checklist)</strong></td>
        <td width="18%" align="center" bgcolor="#CCCCCC"><strong>จำนวนรูปในระบบ CMSS (ข้อมูลปฐมภูมิ)</strong></td>
      </tr>
      <?
		

	//echo "<pre>";
	//print_r($arrid);
	ksort($arrid);
	$k=0;
	foreach($arrid as $key1 => $val1){
		$k++;
	  ?>
      <tr bgcolor="<?=$bg[$key1]?>">
        <td align="center"><?=$k?></td>
        <td align="center"><?=$xicona[$key1]?><?=$alertF[$key1]?></td>
        <td align="center"><?=$val1?></td>
        <td align="left"><? echo $arrname[$key1];?></td>
        <td align="left"><? echo $arrposition[$key1];?></td>
        <td align="left"><? echo $arrschool[$key1];?></td>
        <td align="center"><? echo number_format($arrpic[$key1]);?></td>
        <td align="center"><?=number_format($arrpics[$key1]);?></td>
      </tr>
        <?
		$sum_allpic += $arrpic[$key1];
		$sumPicsys += $arrpics[$key1];
		}//end foreach(){
	  ?>
      <tr>
        <td colspan="6" align="right" bgcolor="#FFFFFF"><strong>&nbsp;จำนวนรวม : </strong></td>
        <td align="center" bgcolor="#FFFFFF"><b><?=number_format($sum_allpic);?></b></td>
        <td align="center" bgcolor="#FFFFFF"><b><?=number_format($sumPicsys);?></b></td>
      </tr>

    </table></td>
  </tr>
</table>
<?
}//end if($action == "view_all" or $action == "view_in" or $action == "view_discount"){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>หมายเหตุ : เครื่องหมาย <img src='../../images_sys/circle2.gif' border='0' width='19' height='19' title='สถานะข้อมูลจำนวนรูปไม่ตรงกัน'> หมายถึงจำนวนรูปจากระบบเช็คลิสไม่ตรงกับจำนวนรูปจากระบบ</td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../../images_sys/alert.gif" width="16" height="16" border="0" title="สถานะเอกสารไม่สมบูรณ์"> หมายถึงสถานะเอกสารไม่สมบูรณ์</td>
  </tr>
</table>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>