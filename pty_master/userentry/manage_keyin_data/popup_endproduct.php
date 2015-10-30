<?
$ApplicationName	= "diagnosticv1_test";
$module_code 		= "diagnosticv1_test"; 
$process_id			= "diagnostic";
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
	## Modified Detail :		ระบบตรวจสอบรับรองความถูกต้องของข้อมูล
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################

set_time_limit(0);
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			include("function_face2cmss.php");
$time_start = getmicrotime();
			
			if($compare_id == ""){
					$compare_id = 2;
			}
			
			if($mm1 == ""){
					$mm1 = intval(date("m"))-1;
			}
			if($mm2 == ""){
					$mm2 = intval(date("m"));	
			}
			if($yy1 == ""){
					$yy1 = date("Y")+543;
			}
			
			if($yy2 == ""){
					$yy2 = date("Y")+543;
			}
			
			if($site_id == ""){
				$site_id = "999";
			}

			
			  $date_dis = (date("Y")+543)-2; // ปีย้อนหลัง
$file_reload = "report_keyin_endproduct_New.php";


if($_SERVER['REQUEST_METHOD'] == "POST"){
		echo "<script language=\"javascript\">
window.opener.location='$file_reload?site_id=$site_id&compare_id=$compare_id&s_data1=$s_data1&s_data2=$s_data2&e_data1=$e_data1&e_data2=$e_data2&mm1=$mm1&yy1=$yy1&mm2=$mm2&yy2=$yy2&profile_id=$profile_id';window.close();
</script>
";
		
}// end if($_SERVER['REQUEST_METHOD'] == "POST"){


###### ข้อมูลห้องคีย์ข้อมูลจากระบบ face
$arrsite = GetSiteKeyData();
ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานสำหรับรับรองการคีย์ข้อมูล ก.พ.7 สำหรับพนักงานที่เป็น supervisor</title>
<LINK href="../../common/style.css" rel=stylesheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>


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
</style>
<style type="text/css">
.page {
	font						: 9px tahoma;
	font-weight			: bold; 	
	color					: #0280D5;	
	padding				: 1px 3px 1px 3px;
}	

.pagelink {
	font						: 9px tahoma;
	font-weight			: bold; 
	color					: #000000;
	text-decoration	: underline;
	padding				: 1px 3px 1px 3px;
}
.go {
	BORDER: #59990e 1px solid; 
	PADDING-RIGHT: 0.38em; 
	PADDING-LEFT: 0.38em; 
	FONT-WEIGHT: bold; 
	FONT-SIZE: 105%; 
	BACKGROUND: url(../hr3/hr_report/images/hdr_bg.png) #6eab26 repeat-x 0px -90px; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	COLOR: #fff; 
	MARGIN-RIGHT: 0.38em; 
	PADDING-TOP: 0px; 
	HEIGHT: 1.77em
}
#bf .go {
	FLOAT: none
}
.go:hover {
	BORDER: #3f8e00 1px solid; 
	BACKGROUND: url(../hr3/hr_report/images/hdr_bg.png) #63a218 repeat-x 0px -170px; 
}
.q {
	BORDER-RIGHT: #5595CC 1px solid; 
	PADDING-RIGHT: 0.7em; 
	BORDER-TOP: #5595CC 1px solid; 
	PADDING-LEFT: 0.7em; 
	FONT-WEIGHT: normal; FONT-SIZE: 105%; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	MARGIN: 0px 0.38em 0px 0px; 
	BORDER-LEFT: #5595CC 1px solid; 
	WIDTH: 300px; 
	PADDING-TOP: 0.29em; 
	BORDER-BOTTOM: #5595CC 1px solid; 
	HEIGHT: 1.39em

}
.tabberlive .tabbertab {
	background-color:#FFFFFF;
  height:200px;
}
</style>
<script language="javascript">
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
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#A5B2CE"><table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="2%" align="center" bgcolor="#A5B2CE"><img src="../../images_sys/searchb.gif" width="26" height="22" /></td>
        <td width="98%" align="left" bgcolor="#A5B2CE"><strong>ฟอร์มสำหรับค้นหาสถิติการจัดทำข้อมูล</strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>        <form name="form1" method="post" action="" onSubmit="return CheckForm()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td align="right" bgcolor="#A5B2CE">&nbsp;</td>
                <td align="left" bgcolor="#A5B2CE"><a href="CC_keyin_user_out_script.php" target="_blank">ประมวลผล update การปรับพนักงานเข้าออก</a></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#A5B2CE"><strong>โปรไฟล์ข้อมูล : </strong></td>
                <td align="left" bgcolor="#A5B2CE">          <select name="profile_id" id="profile_id" >
          <option value="">เลือกโฟล์ไฟล์</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile where profile_id > 4 ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<option value="<?=$rsp[profile_id]?>" <?=$sel?>><?=$rsp[profilename]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
        </select> 
</td>
              </tr>
              <tr>
                <td width="10%" align="right" bgcolor="#A5B2CE"><strong>ศูนย์การคีย์ข้อมูล : </strong></td>
                <td width="90%" align="left" bgcolor="#A5B2CE">
                  <select name="site_id" id="site_id">
                  <option value="999">เลือกทั้งหมด</option>
                  <?
                  	if(count($arrsite) > 0){
						foreach($arrsite as $key => $val){
							if($site_id == $key){ $sel = " selected='selected''";}else{ $sel = "";}
							echo "<option value='$key' $sel>$val</option>";
						}
							
					}//end 	if(count($site_id) > 0){
				  ?>
                  </select>
                  </td>
              </tr>
              <tr>
                <td align="right" bgcolor="#A5B2CE"><input type="radio" name="compare_id" id="compare_id1" value="1" <? if($compare_id == "1"){ echo " checked";}?> > </td>
                <td align="left" bgcolor="#A5B2CE"><strong>การเปรียบเทียบระหว่างวัน</strong></td> 
              </tr>
              <tr>
                <td align="right" bgcolor="#A5B2CE">&nbsp;</td>
                <td align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                  <tr>
                    <td width="27%" align="left"><INPUT name="s_data1" onFocus="blur();" value="<?=$s_data1?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.s_data1, 'dd/mm/yyyy');return CheckR1();"value="วันเดือนปี"></td>
                    <td width="18%" align="center"><strong>ถึง</strong></td>
                    <td width="40%" align="left"><INPUT name="s_data2" onFocus="blur();" value="<?=$s_data2?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.s_data2, 'dd/mm/yyyy');return CheckR1();"value="วันเดือนปี"></td>
                    <td width="15%" align="center">&nbsp;</td>
                    </tr>
                  <tr>
                    <td colspan="3" align="left"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เปรียบเทียบกับ</b></td>
                    <td align="center">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="left"><INPUT name="e_data1" onFocus="blur();" value="<?=$e_data1?>" size="15" readOnly>
                      <INPUT name="button3" type="button"  onClick="popUpCalendar(this, form1.e_data1, 'dd/mm/yyyy');return CheckR1();"value="วันเดือนปี"></td>
                    <td align="center"><strong>ถึง</strong></td>
                    <td align="left"><INPUT name="e_data2" onFocus="blur();" value="<?=$e_data2?>" size="15" readOnly>
                      <INPUT name="button4" type="button"  onClick="popUpCalendar(this, form1.e_data2, 'dd/mm/yyyy');return CheckR1();"value="วันเดือนปี"></td>
                    <td align="center">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#A5B2CE"><input type="radio" name="compare_id" id="compare_id2" value="2" <? if($compare_id == "2"){ echo " checked";}?>>
                  </td>
                <td align="left" bgcolor="#A5B2CE"><strong>การเปรียบเทียบระหว่างเดือน</strong></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#A5B2CE">&nbsp;</td>
                <td align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                  <tr>
                    <td width="27%" align="left"><strong>เดือน</strong>
                      <select name="mm1" id="mm1" onClick="return CheckR2();">
                        <option value="">เลือกเดือน</option>
                        <?
                      	if(count($monthname) > 0){
								foreach($monthname as $km => $vm){
									if($km != ""){
										if($mm1 == $km){ $sel = "selected='selected'";}else{ $sel = "";}
										echo "<option value='$km' $sel>$vm</option>";
									}//end if($km != ""){
								}
						}
					  ?>
                      </select></td>
                    <td width="20%" align="left"><strong>ปี</strong>
                      <select name="yy1" id="yy1" onClick="return CheckR2();">
                        <option value="">เลือกปี</option>
                        <?
					
                      	for($y1=(date("Y")+543);$y1 > $date_dis;$y1--){
							if($y1 == $yy1){ $sel = "selected='selected'";}else{ $sel = "";}
							echo "<option value='$y1' $sel>$y1</option>";
								
						}
					  ?>
                      </select></td>
                    <td width="53%" align="left">&nbsp;</td>
                    </tr>
                  <tr>
                    <td colspan="2" align="left"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เปรียบเทียบกับ</b></td>
                    <td align="left">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="left"><strong>เดือน </strong>
                      <select name="mm2" id="mm2" onClick="return CheckR2();">
                        <option value="">เลือกเดือน</option>
                        <?
                      	if(count($monthname) > 0){
								foreach($monthname as $km1 => $vm1){
									if($km1 != ""){
										if($mm2 == $km1){ $sel = "selected='selected'";}else{ $sel = "";}
										echo "<option value='$km1' $sel>$vm1</option>";
									}//end if($km1 != ""){
								}
						}
					  ?>
                      </select></td>
                    <td align="left"><strong>ปี</strong>
                      <select name="yy2" id="yy2" onClick="return CheckR2();">
                        <option value="">เลือกปี</option>
                        <?
					
                      	for($y1=(date("Y")+543);$y1 > $date_dis;$y1--){
							if($y1 == $yy2){ $sel = "selected='selected'";}else{ $sel = "";}
							echo "<option value='$y1' $sel>$y1</option>";
								
						}
					  ?>
                      </select></td>
                    <td align="left">&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#A5B2CE">&nbsp;</td>
                <td align="left" bgcolor="#A5B2CE"><input type="submit" name="button2" id="button" value="แสดงรายงานเปรียบเทียบ"></td>
              </tr>
              <tr>
                <td colspan="2" align="right" bgcolor="#A5B2CE">&nbsp;</td>
                </tr>
            </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
