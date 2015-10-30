<?php
set_time_limit(0);
include("../checklist2.inc.php");
include("function_imp.php");
include("../../pic2cmss/function/function.php");
/// ข้อมูลการ upload ซ้ำ

if($_SERVER['REQUEST_METHOD'] == "POST"){	
 if($Aaction == "process"){
/*	 echo "<pre>";
	 print_r($_POST);
	die;
*/		 
	 if(count($arridcard) > 0){
		 $xi = 0;
		 foreach($arridcard as $key => $val){
			 $numpage = $arr_page[$val]; // จำนวนแผ่น
			 $numpic = $arr_pic[$val]; // จำนวนรูป
			 if($numpage > 0  or $numpic > 0){
				 	if($numpage > 0){ $conpage = " ,page_num='$numpage' ";}else{ $conpage = "";}
					if($numpic > 0){ $conpic = " ,pic_num='$numpic' ";}else{ $conpic = "";}
					 $xi++;
			 	$sql_update = "UPDATE tbl_checklist_kp7 SET time_update=NOW() $conpage $conpic   WHERE idcard='$key' AND profile_id='$profile_id'";
				//echo $sql_update."<br>";
				$result1 = mysql_db_query($dbname_temp,$sql_update);
				//GetNewCutPic($key,$profile_id); // update จำนวนรูปที่ต้องตัดเพิ่ม
				
				if($result1){
					chkUpdateNewCut_ALL($xsiteid);
					$sql_uptemp = "UPDATE temp_upload_excel2checklist  SET flag_process='1',status_conf='1' WHERE idcard='$key' AND profile_id='$profile_id' AND siteid='$xsiteid'";
					//echo "$sql_uptemp<br>";
					mysql_db_query($dbname_temp,$sql_uptemp);
				}//end if($result1){
				}//end 		 if($numpage > 0  or $numpic > 0){
			}//end foreach($arridcard as $key => $val){
				
			//die;	
		if($xi > 0){
		echo "<script>alert('บันทึกการยืนยันจำนวนหน้าและจำนวนรูปเอกสาร ก.พ. 7 เรียบร้อยแล้ว');
		window.close();
		</script>";
		exit;
		}else{
			echo "<script>
		location.href='?profile_id=$profile_id&xsiteid=$xsiteid';
		</script>";
		exit;	
		}//end 	if($xi > 0){
	}//end  if(count($arridcard) > 0){
	 
	 
	 
	 
	 
	}//end if($Aaction == "process"){ 
		
}//end if($_SERVER['REQUEST_METHOD'] == "POST"){


?>
<HTML><HEAD><TITLE>Import DATA</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<LINK href="../../../common/style.css" rel=stylesheet>
</HEAD>
<BODY>
<?
	if($action == ""){
		$arrrep = CheckUploadReplace($profile_id,$xsiteid);
?>
<form name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="5" align="center" bgcolor="#CCCCCC"><strong>รายการ upload ข้อมูลซ้ำเลือกยืนยันหากต้องการบวกจำนวนรูปและจำนวนหน้าเอกสาร <?=show_area($xsiteid)?> หมายเหตุ เลือก checkbox กรณีต้องการใช้ค่าตัวเลขนั้นถ้าไม่ต้องการให้ทำการ uncheck ออก&nbsp;&nbsp;<input type="submit" name="button" id="button" value="บันทึก">
            <input type="hidden" name="profile_id" value="<?=$profile_id?>">
            <input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
            <input  type="hidden" name="Aaction" value="process">
          </strong></td>
          </tr>
        <tr>
          <td width="3%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
          <td width="28%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>[เลขบัตร]ชื่อนามสกุล</strong></td>
          <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>รายการ upload รูปซ้ำ</strong></td>
          </tr>
        <tr>
          <td width="22%" align="center" bgcolor="#CCCCCC"><strong>ชื่อพนักงานที่ upload</strong></td>
          <td width="16%" align="center" bgcolor="#CCCCCC"><strong>จำนวนหน้าเอกสาร</strong></td>
          <td width="17%" align="center" bgcolor="#CCCCCC"><strong>จำนวนรูปภาพ</strong></td>
          </tr>
          <?
          	if(count($arrrep) > 0){
				$n=0;
				foreach($arrrep as $key => $val){
					 	if ($n++ %  2){ 	$bg = "#F0F0F0"; 	}else{ $bg = "#FFFFFF";	}
						$arr1 = GetIdReplace($key,$profile_id);
		  ?>
        <tr bgcolor="<?=$bg?>">
          <td align="center" valign="top"><?=$n?></td>
          <td align="left" valign="top"><? echo "[$key] $val";?></td>
          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          	<? 
			$n1 = 0;
				foreach($arr1 as $key1 => $val1){
						foreach($val1['staffid'] as $keystaff => $valstaff){
						$n1++;
			?>
            <tr>
              <td align="left">&nbsp;<?=$valstaff?></td>
            </tr>
            <? 
						}//end 	foreach($val1['staffid'] as $keystaff => $valstaff){
			}//end  
			
				if($n1 > 1){ // กรณีมีจำนวนรายการข้อมูลซ้ำมากกว่า 1 รายการ
			?>
             <tr>
              <td align="left" bgcolor="#CCCCCC"><strong>&nbsp;รวม</strong></td>
            </tr>
			<?
				}//end 	if($n1 > 1){
            ?>
          </table></td>
          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
             <? 
			 $i1 = 0;
				foreach($arr1 as $key2 => $val2){
					foreach($val2['num_page'] as $keypage => $valpage){
				$i1++;
			?>

            <tr>
              <td width="39%" align="right"><?=$valpage?></td>
                 <td width="61%" align="left"> <input type="radio" name="arr_page[<?=$key?>]" id="<?=$key.$i1;?>" value="<?=$valpage?>"></td>
            </tr>
            <?
			$sumpage += $valpage;
					}//end 
				}// end foreach($arr1 as $key2 => $val2){
					
				if($i1 > 1){ // ในกรณี มีมากว่า 1 รายการ	
			?>
               <tr>
              <td align="right" bgcolor="#CCCCCC">
              <strong><?=$sumpage?></strong></td>
         
               <td align="left" bgcolor="#CCCCCC"><input type="radio" name="arr_page[<?=$key?>]" id="<?=$key.$i1+1;?>" value="<?=$sumpage?>"></td>
            </tr>
			<?
				}//end if($i1 > 1){
			?>
          </table></td>
          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
            <? 
			$i2=0;
				foreach($arr1 as $key3 => $val3){
					foreach($val3['num_pic'] as $keypic => $valpic){
					$i2++;
			?>
            
            <tr>
              <td width="44%" align="right"><?=$valpic?></td>
              <td width="56%" align="left"><input type="radio" name="arr_pic[<?=$key?>]" id="<?=$key.$i2;?>" value="<?=$valpic?>"></td>
              </tr>
            <?
				$sumpic += $valpic;
					}//end foreach($val3['num_pic'] as $keypic => $valpic){
				}//end foreach($arr1 as $key2 => $val2){
				if($i2 > 1){ // ในการณีมีมากว่า 1 รายการ
			?>
            <tr>
              <td align="right" bgcolor="#CCCCCC"><strong><?=$sumpic?></strong></td>
              <td align="left" bgcolor="#CCCCCC"><input type="radio" name="arr_pic[<?=$key?>]" id="<?=$key.$i2+1;?>" value="<?=$sumpic?>"></strong></td>
              </tr>
            <?
				}//end if($i2 > 1){ 
			?>
          </table></td>
          </tr>
        <?
			$sumpage = "";
			$sumpic = "";
			echo "<input type=\"hidden\" name=\"arridcard[$key]\" value=\"$key\">";
				}//END foreach($arrrep as $key => $val){
			}else{
				 echo "<tr>
          <td colspan=\"6\" align=\"center\" bgcolor=\"#CCCCCC\"><strong>ได้ดำเนินการยืนยันจำนวนรูปและจำนวนไฟล์ไปทั้งหมดแล้ว</strong></td>
          </tr>";
				
			}//endif(count($arrrep) > 0){
		?>
      </table></td>
    </tr>
  </table>
</form>
<?
	}//end 	if($action == ""){
?>
</BODY>