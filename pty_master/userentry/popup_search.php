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
include ("../../../../config/conndb_nonsession.inc.php")  ;
include("../../../../common/common_competency.inc.php");
include("../../../../common/class.loadpage.php");
include('function_checkdata.inc.php') ;
include('function_getdate_face.php') ;
include('function_getdate_keyin.php') ;
$time_start = getmicrotime();
$file_reload = "index.php";


if($_SERVER['REQUEST_METHOD'] == "POST"){
		echo "<script language=\"javascript\">
window.opener.location='$file_reload?site_id=$site_id&key_staffname=$key_staffname&key_staffsurname=$key_staffsurname&key_idcard=$key_idcard&key_name_th=$key_name_th&key_surname_th=$key_surname_th&action=list_approve';window.close();
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
<LINK href="../../../../common/style.css" rel=stylesheet type="text/css">
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
	BACKGROUND: url(../../application/hr3/hr_report/images/hdr_bg.png) #6eab26 repeat-x 0px -90px; 
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
	BACKGROUND: url(../../application/hr3/hr_report/images/hdr_bg.png) #63a218 repeat-x 0px -170px; 
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
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="2" align="left" valign="top" bgcolor="#A5B2CE"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="2%" align="center"><img src="../../../../images_sys/searchb.gif" alt="" width="26" height="22" /></td>
                  <td width="98%" align="left" valign="middle" bgcolor="#A5B2CE"><strong>ค้นหาใบงานเพื่อรับรองข้อมูล</strong></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td width="35%" align="right" bgcolor="#FFFFFF"><strong>เลือกห้องการคีย์ข้อมูล : </strong></td>
              <td width="65%" bgcolor="#FFFFFF">
                <strong>
                <select name="site_id" id="site_id">
                  <option value="">- เลือก Site -</option>
                  <?
                	if(count($arrsite) > 0){
						foreach($arrsite as $key => $val){
							if($site_id == $key){ $sel = " selected='selected'";}else{$sel="";}
									echo "<option value='$key' $sel>$val</option>";
						}//end foreach($arrsite as $key => $val){
							
					}// end 	if(count($arrsite) > 0){
						if($site_id == "999"){ $sel = " selected='selected'";}else{$sel="";}
					echo "<option value='999' $sel>SubContact</option>";
				?>
                </select>
                
                </strong></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>ชื่อพนักงานคีย์ข้อมูล : </strong></td>
              <td bgcolor="#FFFFFF">
                <input name="key_staffname" type="text" id="key_staffname" size="30"></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>นามสกุลพนักงานคีย์ข้อมูล : </strong></td>
              <td bgcolor="#FFFFFF">
                <input name="key_staffsurname" type="text" id="key_staffsurname" size="30"></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>เลขบัตรประชาชน : </strong></td>
              <td align="left" bgcolor="#FFFFFF">
                <input name="key_idcard" type="text" id="key_idcard" size="30"></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>ชื่อบุคลากร : </strong></td>
              <td align="left" bgcolor="#FFFFFF">
                <input name="key_name_th" type="text" id="key_name_th" size="30"></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>นามสกุลบุคลากร : </strong></td>
              <td align="left" bgcolor="#FFFFFF">
                <input name="key_surname_th" type="text" id="key_surname_th" size="30"></td>
            </tr>
            <tr>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">
              <input type="hidden" name="action" value="<?=$action?>">
              <input type="submit" name="button" id="button" value="ค้นหา" /></td>
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
