<?
session_start();
$ApplicationName	= "manage_keyin_data";
$module_code 		= "popup_performance"; 
$process_id			= "popup_performance";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110709.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-07-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110709.00
	## Modified Detail :		รายงานประสิทธิภาพการทำงานของพนักงาน
	## Modified Date :		2011-07-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
			require_once("../../../config/conndb_nonsession.inc.php");
			require_once ("../../../common/common_competency.inc.php")  ;
			require_once("../function_face2cmss.php");
			require_once("../function_date.php");
			require_once("../function_get_data.php");
			require_once("function_add_percen.php");
			if($_SESSION['session_staffid'] == ""){
				echo "<script>alert('กรุณา login เพื่อเข้าใช้งานระบบ'); location.href='../login.php';</script>";
				exit;
			}//end if($_SESSION['session_staffid'] == ""){
			$time_start = getmicrotime();
			if($prov_site == "" ){
				$prov_site = 2; // รหัสจังหวัดของอุดร		
			}
			
			
			if($start_date == "" and $end_date == ""){
				$date1 = "2011-06-27";
				$date2 = "2011-07-25";
			}else{
				$date1 = GetDateDB($start_date);
				$date2 = GetDateDB($end_date);
			}

	  if($incentive == "1"){
	 	$arrincent = GetIncentive($date1,$date2,$consite);
	  }// end 
	  if($qc_pd == ""){
		$qc_pd = 1;	 	 
		}
		
	if($cost_pd == ""){
		$cost_pd = 166.91;
	}
	if($manage_pd == ""){
		$manage_pd = 0.3;
	}
	if($salary == ""){
			$salary = 280;
	}
	 if($hw_pd == ""){
		 $hw_pd = 63;
	}
	if($incentive == ""){
			$incentive = 0;
	}
	  


if($_SERVER['REQUEST_METHOD'] == "POST"){
echo "<script language=\"javascript\">
window.opener.location='performance_per_head.php?start_date=$start_date&end_date=$end_date&prov_site=$prov_site&cost_pd=$cost_pd&salary=$salary&incentive=$incentive&qc_pd=$qc_pd&hw_pd=$hw_pd&manage_pd=$manage_pd&staffname=$staffname&staffsurname=$staffsurname';window.close();
</script>
";
		
}// end if($_SERVER['REQUEST_METHOD'] == "POST"){


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
</head>


<link href="../../../common/style.css" type="text/css" rel="stylesheet">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">

function data_change(field)
     {
          var check = true;
          var value = field.value; //get characters
          //check that all characters are digits, ., -, or ""
          for(var i=0;i < field.value.length; ++i)
          {
               var new_key = value.charAt(i); //cycle through characters
               if(((new_key < "0") || (new_key > "9")) && 
                    !(new_key == ""))
               {
                    check = false;
                    break;
               }
          }
          //apply appropriate colour based on value
          if(!check)
          {
               field.style.backgroundColor = "red";
          }
          else
          {
               field.style.backgroundColor = "white";
          }
     }
	 
	 
	 
	 function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 46 || charCode > 57))
		 
            return false;

         return true;
      }

</script>


<BODY >
<form name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="2%" bgcolor="#A5B2CE"><img src="../../../images_sys/searchb.gif" width="26" height="22"></td>
          <td colspan="4" align="left" valign="middle" bgcolor="#A5B2CE"><strong>แบบฟอร์มสำหรับการวิเคราะห์ต้นทุน</strong></td>
          </tr>
        <tr>
          <td colspan="2" align="right"><strong>วันที่เริ่มต้น</strong>: </td>
          <td width="22%" align="left"><INPUT name="start_date" onFocus="blur();" value="<?=GetDateFrom($date1)?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.start_date, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
          <td width="17%" align="right"><strong>จำนวนผลผลิตเฉลี่ย/วัน(บาท) : </strong></td>
          <td width="43%"><label for="cost_pd"></label>
            <input name="cost_pd" type="text" id="cost_pd" size="20" value="<?=$cost_pd?>" onKeyPress="return isNumberKey(event)"> </td>
        </tr>
        <tr>
          <td colspan="2" align="right"><strong>วันที่สิ้นสุด</strong> : </td>
          <td align="left"><INPUT name="end_date" onFocus="blur();" value="<?=GetDateFrom($date2)?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.end_date, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
          <td align="right"><strong>เงินเดือน : </strong></td>
          <td>
            <input name="salary" type="text" id="salary" size="20" value="<?=$salary?>" onKeyPress="return isNumberKey(event)"></td>
        </tr>
        <tr>
          <td colspan="2" align="right"><strong>ศูนย์จังหวัดคีย์ข้อมูล : </strong></td>
          <td align="left">
            <select name="prov_site" id="prov_site">
            <option value="999">เลือกทั้งหมด</option>
            <?
            	$sql_prov = "SELECT t1.profile_id, t1.profile_name, t1.status_active FROM keyin_area_profile as t1 where t1.status_active='1' ORDER BY t1.profile_name ASC ";
				$result_prov = mysql_db_query($dbnameuse,$sql_prov)  or die(mysql_error()."$sql_prov<br>LINE__".__LINE__);
				while($rsp = mysql_fetch_assoc($result_prov)){
					if($rsp[profile_id] == $prov_site){ $sel = " selected='selected'"; }else{ $sel = "";}
					echo "<option value='$rsp[profile_id]' $sel>$rsp[profile_name]</option>";
				}//end while($rsp = mysql_fetch_assoc($result_prov)){
			?>
            </select></td>
          <td align="right"><strong>incentive : </strong></td>
          <td><input type="radio" name="incentive" id="radio" value="1" <? if($incentive == "1"){ echo " checked='checked'";}?>>
            แสดงค่า incentive
              <input type="radio" name="incentive" id="radio2" value="0"  <? if($incentive == "0"){ echo " checked='checked'";}?>>
              ไม่แสดงค่า incentive</td>
        </tr>
        <tr>
          <td colspan="2" align="right"><strong>ชื่อพนักงาน : </strong></td>
          <td align="left"><label for="staffname"></label>
            <input name="staffname" type="text" id="staffname" size="30"></td>
          <td align="right"><strong>ค่า QC ต่อชุด : </strong></td>
          <td>
            <input name="qc_pd" type="text" id="qc_pd" size="20" value="<?=$qc_pd?>" onKeyPress="return isNumberKey(event)"></td>
        </tr>
        <tr>
          <td colspan="2" align="right"><strong>นามสกุลพนักงาน : </strong></td>
          <td align="left"><label for="staffsurname"></label>
            <input name="staffsurname" type="text" id="staffsurname" size="30"></td>
          <td align="right"><strong>ค่าเช่า HW : </strong></td>
          <td>
            <input name="hw_pd" type="text" id="hw_pd" size="20" value="<?=$hw_pd?>" onKeyPress="return isNumberKey(event)"></td>
        </tr>
        <tr>
          <td colspan="2" align="right">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="right"><strong>ค่าบริหารจัดการ : </strong></td>
          <td>
            <input name="manage_pd" type="text" id="manage_pd" size="20" value="<?=$manage_pd?>" onKeyPress="return isNumberKey(event)"></td>
        </tr>
        <tr>
          <td colspan="2" align="right">&nbsp;</td>
          <td colspan="3" align="left"><input type="submit" name="button2" id="button" value="แสดงรายงานวิเคราะห์ต้นทุน"></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>



