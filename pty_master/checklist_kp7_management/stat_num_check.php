<?
session_start();
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
	## Modified Detail :		�к���Ǩ�ͺ�����ŷ���¹����ѵԵ鹩�Ѻ
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################


include("../../common/common_competency.inc.php");
include("checklist.inc.php");
$time_start = getmicrotime();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>�к���Ǩ�ͺ�͡��� �.�.7 �鹩�Ѻ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>

<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>
<body>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
   <td align="center"><form name="form1" method="post" action="">
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
           <tr>
             <td colspan="4" align="left" bgcolor="#CAD5FF"><strong>���Ҿ�ѡ�ҹ��Ǩ�ͺ������</strong></td>
             </tr>
           
           <tr>
             <td width="17%" align="left" bgcolor="#FFFFFF"><strong>�ѹ����Ǩ�ͺ�͡���</strong></td>
             <td width="83%" colspan="3" align="left" bgcolor="#FFFFFF"> 
			 <? ######### 30/11/2552
			 if	($c_date == ""){ 
				$thyy = date("Y")+543 ; 
			 	$c_date = date(d ."/".m."/".$thyy ) ; 
			 }  ####### END  if	($c_date == ""){ 
			 ?>			 
			 <label><INPUT name="c_date" onFocus="blur();" value="<?=$c_date?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.c_date, 'dd/mm/yyyy')"value="�ѹ��͹��"></label>               
			<label> �֧�ѹ��� 
            <INPUT name="c_date2" onFocus="blur();" value="<?=$c_date2?>" size="15" readOnly>
            <INPUT name="button2" type="button"  onClick="popUpCalendar(this, form1.c_date2, 'dd/mm/yyyy')"value="�ѹ��͹��">
            </label>
            <label> </label></td>
             </tr>
           <tr>
             <td colspan="4" align="center" bgcolor="#FFFFFF"><label>
			 <input type="hidden" name="search" value="search">
               <input type="submit" name="Submit" value="����">
               <input type="reset" name="Submit2" value="��ҧ������">
             </label></td>
             </tr>
         </table></td>
       </tr>
     </table>
      </form>
   </td>
 </tr>
 <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <? 
if ($search == ""){ $search =    "search" ; } ############  �ѧ�Ѻ��� ��Ҥ����á�ʴ������Ţͧ�ѹ���
  if($search == "search"){
  	if($c_date != ""){
 		$key_date = " AND  date(edubkk_checklist.tbl_checklist_log.time_update) LIKE '%".sw_dateE($c_date)."%'";
	}else{
		$key_date = "";
	}
	if($key_staffname != ""){ $conv .= " and callcenter_entry.keystaff.staffname like '%$key_staffname%'";}
	if($key_staffsurname != ""){ $conv .= " and callcenter_entry.keystaff.staffsurname like '%$key_staffsurname%'";}
	
$sql_search = "SELECT
callcenter_entry.keystaff.staffid,
callcenter_entry.keystaff.prename,
callcenter_entry.keystaff.staffname,
callcenter_entry.keystaff.staffsurname,
edubkk_checklist.tbl_checklist_log.user_update,
callcenter_entry.keystaff.sapphireoffice,
edubkk_checklist.tbl_checklist_log.time_update,
date(edubkk_checklist.tbl_checklist_log.time_update) as date_c
FROM
edubkk_checklist.tbl_checklist_log
Inner Join callcenter_entry.keystaff ON edubkk_checklist.tbl_checklist_log.user_update = callcenter_entry.keystaff.staffid
WHERE
edubkk_checklist.tbl_checklist_log.type_action =  '1' $conv
$key_date
group by edubkk_checklist.tbl_checklist_log.user_update";
echo $sql_search;
	$result_search = mysql_db_query($dbtemp_check,$sql_search);
	$numr = @mysql_num_rows($result_search);
  
  ?>
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      
      <tr>
        <td width="6%" align="center" bgcolor="#CAD5FF"><strong>�ӴѺ</strong></td>
        <td width="20%" align="center" bgcolor="#CAD5FF"><strong>����-���ʡ�ž�ѡ�ҹ</strong></td>
        <td width="22%" align="center" bgcolor="#CAD5FF"><strong>�ѹ����Ǩ�ͺ�͡���</strong></td>
        <td width="29%" align="center" bgcolor="#CAD5FF"><strong>��������ѡ�ҹ</strong></td>
        <td width="23%" align="center" bgcolor="#CAD5FF"><strong>�ӹǹ����Ǩ�͡���</strong></td>
      </tr>
	  <?
	  	if($numr < 1){
			echo "<tr bgcolor='#F0F0F0'><td colspan='6'> - ��辺��¡�÷����� -</td></tr>";
		}else{
		$i=0;
		while($rs = mysql_fetch_assoc($result_search)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		$log_user = search_person_check_kp7($rs[idcard]);
		$num_check = count_check_kp7($rs[user_update],$rs[date_c]);
		$txt_date = get_dateThai($rs[time_update],"T");
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname] $rs[staffsurname]";?></td>
        <td align="center"><?=$txt_date;?></td>
        <td align="left"><?=show_type_staff($rs[sapphireoffice]);?></td>
        <td align="center"><? if($num_check > 0){ echo "<a href='search_person_num_check_detail.php?action=view&staffid=$rs[user_update]&key_date=$rs[date_c]&staffname=$rs[prename]$rs[staffname] $rs[staffsurname]&show_date=$txt_date' target='_blank'>".number_format($num_check)."</a>";}else{ echo "0";}?></td>
      </tr>
	  <?
	  	}//end while(){
	  	}//end if($numr < 1){
	  ?>
	  
    </table></td>
  </tr>
  <?
  	}//end   if($search == "search"){
  ?>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>