<?
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		�к��觧ҹ
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM

include "epm.inc.php";
include("function_assign.php");
//$type_cmss = "province"; // ��˹��ó����к��ͧ �ѧ��Ѵ
$s_db = STR_PREFIX_DB;
//if($dbnamemaster == "cmss_pro_master"){ $temp_site = "1300";};

$year1 = (date("Y")+543)."-09-30";
$report_title = "�ͺ���¡�úѹ�֡������ �.�.7 ���Ѻ�����";


function devidepage($total, $kwd , $sqlencode ){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page,$xmode,$xtype,$utype,$xstatus_pay,$xsapphireoffice,$xsapp;

	if($total >= 1){
		$table	= "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
		$table	= $table."<tr align=\"right\">";
		$table	= $table."<td width=\"80%\" align=\"left\" height=\"30\">&nbsp;";
				
		if($page_all <= $per_page){
			$min		= 1;
			$max		= $page_all;
		} elseif($page_all > $per_page && ($page - 5) >= 2 ) {			
			$min		= $page - 5;
			$max		= (($page + 5) > $page_all) ? $page_all : $page + 5;
		} else {
			$min	= 1;
			$max	= $per_page; 			
		}
	
		if($min >= 4){ 
			$table .= "<a href=\"?page=1&xmode=$xmode&xtype=$xtype&utype=$utype&xstatus_pay=$xstatus_pay&xsapphireoffice=$xsapphireoffice&xsapp=$xsapp&displaytype=people".$kwd."\"><u><font color=\"black\">˹���á</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?page=".$i."&xmode=$xmode&xtype=$xtype&utype=$utype&xstatus_pay=$xstatus_pay&xsapphireoffice=$xsapphireoffice&xsapp=$xsapp&displaytype=people". $kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?page=".$page_all."&xmode=$xmode&xtype=$xtype&utype=$utype&xstatus_pay=$xstatus_pay&xsapphireoffice=$xsapphireoffice&xsapp=$xsapp&displaytype=people". $kwd."\"><u><font color=\"black\">˹���ش����</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?page=".($page_all+1)."&xmode=$xmode&xtype=$xtype&utype=$utype&xstatus_pay=$xstatus_pay&xsapphireoffice=$xsapphireoffice&xsapp=$xsapp&displaytype=people". $kwd."\"><u><font color=\"black\">�ʴ�������</font></u></a>";
		}
#		$table .= "&nbsp;<a href=\"search_excel.php?page=$sqlencode\"><u><font color=\"black\">���͡�ٻẺ MS Excel </font></u></a>";

		unset($max,$i,$min);
	
		$table	= $table."</td>";	
		$table	= $table."<td width=\"20%\">�ӹǹ������ <b>".number_format($page_all, 0, "", ",")."</b>&nbsp;˹��&nbsp;</td>";
		$table	= $table."</tr>";
		$table	= $table."</table>";
	}
 	return $table;
}


### function  �ʴ���ª��ͤ��Ѻ�ͧ
	function show_staff_approve($ticketid){
	global $db_name;
			$sql_staff_appove = "SELECT keystaff.staffname, keystaff.staffsurname FROM tbl_assign_sub Inner Join keystaff ON tbl_assign_sub.staff_approve = keystaff.staffid
WHERE tbl_assign_sub.ticketid =  '$ticketid'";
			$result_staff = @mysql_db_query($db_name,$sql_staff_appove);
			$rs_staff = @mysql_fetch_assoc($result_staff);
			return "$rs_staff[staffname] $rs_staff[staffsurname]";
	}
### end function �ʴ���ª��ͤ��Ѻ�ͧ

if($_SERVER['REQUEST_METHOD'] == "POST"){
	if($Aaction == "SAVE"){
	## �ӡ��ź��͹�ӡ�úѹ�֡
	$sql_del = "DELETE FROM tbl_asign_key WHERE staffid='$staffid'";
	@mysql_db_query($db_name,$sql_del);
		if(count($xidcard) > 0){
			foreach($xidcard as $k => $v){
				$sql_insert = "INSERT INTO tbl_asign_key(staffid,idcard,sign_date,siteid)VALUES('$staffid','$v','".date("Y-m-d")."','$xsiteid')";
				@mysql_db_query($db_name,$sql_insert);
			}// end 	foreach($xidcard as $k => $v){
		}// end if(count($xidcard) > 0){
		echo "<script>alert('�ѹ�֡���������º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='asign_user_key.php?xmode=1';</script>";
		exit;
	} //end if($Aaction == "SAVE"){
}// end if($_SERVER['REQUEST_METHOD'] == "POST"){

?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT language=JavaScript>
function checkFields() {
	missinginfo1 = "";
	missinginfo = "";
	if (document.form1.staffname.value == "")  {	missinginfo1 += "\n- ��ͧ���� �������ö�繤����ҧ"; }		
	if (document.form1.staffsurname.value == "")  {	missinginfo1 += "\n- ��ͧ���ʡ�� �������ö�繤����ҧ"; }		
	if (document.form1.engname.value == "")  {	missinginfo1 += "\n- ��ͧ����(�ѧ���) �������ö�繤����ҧ"; }		
	if (document.form1.engsurname.value == "")  {	missinginfo1 += "\n- ��ͧ���ʡ��(�ѧ���) �������ö�繤����ҧ"; }		
	if (missinginfo1 != "") { 
		missinginfo += "�������ö������������  ���ͧ�ҡ \n";
		missinginfo +="_____________________________\n";
		missinginfo = missinginfo + missinginfo1  ;
		missinginfo += "\n___________________________";
		missinginfo += "\n��سҵ�Ǩ�ͺ �ա����";
		alert(missinginfo);
		return false;
		}
	}
</script>
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

<body bgcolor="#EFEFFF">
<table border=0 align=center cellspacing=1 cellpadding=2 width="98%">
<tr><td colspan="2" class="fillcolor"><table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td width="13%"  bgcolor="<? if($xmode == ""){ $bgcolor = "BLACK";echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066"; }?>" align=center style="border-right: solid 1 white;"><A HREF="index_assign_key.php?xmode="><strong><U style="color:<?=$bgcolor?>;">�Ѵ��â����ż����</U></strong></A></td>
              <td width="26%"  bgcolor="<? if($xmode == "1"){ $bgcolor = "BLACK"; echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066";}?>" align=center style="border-right: solid 1 white;"><A HREF="index_assign_key.php?xmode=1"><strong><U style="color:<?=$bgcolor?>;"> ��ǹ���§ҹ���Ѻ����Ѻ�ҹ</U></strong></A></td>
			   <td width="26%"  bgcolor="<? if($xmode == "2"){ $bgcolor = "BLACK"; echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066";}?>" align=center style="border-right: solid 1 white;"><A HREF="index_assign_key.php?xmode=2"><strong><U style="color:<?=$bgcolor?>;"> ��ǹ�ͧ����͵�Ǩ�ҹ</U></strong></A></td>

              <td width="61%"><a href="search_userkey.php" target="_blank"><img src="images/document_view.gif" alt="���ҡ�úѹ�֡������" width="24" height="24" border="0"></a>&nbsp;&nbsp;<a href="script_up_qc_pass_crontab.php?action=run" target="_blank">�Ѻ�ͧ�ѵ��ѵ����к�</a></td>
            </tr>
          </table></td></tr>
<tr><td width=39><img src="images/user_icon.gif"></td>
<td width="908" align="left"><B style="font-size: 12pt;"><? if($xmode == ""){ $txt_mode = "��ǹ�ͧ����ͺ���§ҹ";}else if($xmode == "1"){ $txt_mode = "��ǹ�ͧ��è��§ҹ���Ѻ����Ѻ�ҹ";}else if($xmode == "2"){ $txt_mode = "��ǹ�ͧ����͵�Ǩ�ҹ";} echo "$txt_mode";?></B></td>
</tr>

<tr valign=top height=1 bgcolor="#808080"><td colspan=2></td></tr>

<tr valign=top><td colspan=2>
<BR></td>
</tr>
</table>

<? 
if($action == ""){ /// ��ǹ�ͧ����ʴ�����¡��
	if($xmode == "2"){
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr><td>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
<?
		if($xtype != ""){$xtype = $xtype;}else{ $xtype = "1";}
		if($xtype == "1"){ $fcolor1 = "<font color='#000000'>"; $fcolor_n1 = "</font>"; $bg1 = "#FFFFFF";}else{  $bg1 = "#A5B2CE";} 
		if($xtype == "2"){ $fcolor2 = "<font color='#000000'>"; $fcolor_n2 = "</font>"; $bg2 = "#FFFFFF";}else{ $bg2 = "#A5B2CE";} 
		if($xtype == "3"){  $fcolor3 = "<font color='#000000'>"; $fcolor_n3 = "</font>"; $bg3 = "#FFFFFF";}else{ $bg3 = "#A5B2CE";} 
?>
          <tr>
            <td width="19%" align="center" bgcolor="<?=$bg1?>"><strong><a href="index_assign_key.php?xmode=2&xtype=1"><?=$fcolor1?>���������ҧ���Թ���<?=$fcolor_n1?></a></strong></td>
		<td width="20%" align="center" bgcolor="<?=$bg3?>"><strong><a href="index_assign_key.php?xmode=2&xtype=3"><?=$fcolor3?>�͵�Ǩ�ͺ�ҹ<?=$fcolor_n3?></a></strong></td>
            <td width="24%" align="center" bgcolor="<?=$bg2?>"><strong><a href="index_assign_key.php?xmode=2&xtype=2"><?=$fcolor2?>��Ǩ�ҹ���º��������<?=$fcolor_n2?></a></strong></td>
            <td width="37%" align="center" bgcolor="#A5B2CE">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center" bgcolor="#EFEFFF">&nbsp;</td>
          </tr>
          <?
          	if($xsapphireoffice == ""){ $xsapphireoffice = "all";}
			if($xsapphireoffice == "all"){ $fcolor1 = "<font color='#000000'>"; $fcolor_n1 = "</font>"; $bg1 = "#FFFFFF";}else{  $bg1 = "#A5B2CE";} 
			if($xsapphireoffice == "0"){ $fcolor2 = "<font color='#000000'>"; $fcolor_n2 = "</font>"; $bg2 = "#FFFFFF";}else{ $bg2 = "#A5B2CE";} 
			if($xsapphireoffice == "2"){  $fcolor3 = "<font color='#000000'>"; $fcolor_n3 = "</font>"; $bg3 = "#FFFFFF";}else{ $bg3 = "#A5B2CE";} 
		  ?>
          <tr>
            <td align="center" bgcolor="<?=$bg1?>"><strong><a href="index_assign_key.php?xmode=2&xtype=<?=$xtype?>&xsapphireoffice=all"><?=$fcolor1?>㺧ҹ������<?=$fcolor_n1?></a></strong></td>
            <td align="center" bgcolor="<?=$bg2?>"><strong><a href="index_assign_key.php?xmode=2&xtype=<?=$xtype?>&xsapphireoffice=0"><?=$fcolor2?>�١��ҧ���Ǥ���<?=$fcolor_n2?></a></strong></td>
            <td align="center" bgcolor="<?=$bg3?>"><strong><a href="index_assign_key_sub.php?xmode=2&xtype=<?=$xtype?>&xsapphireoffice=2" target="_blank"><?=$fcolor3?>Subcontract<?=$fcolor_n3?></a></strong></td>
            <td align="center" bgcolor="#A5B2CE">&nbsp;</td>
          </tr>
      </table>
  </td></tr>	
	<tr><td><br>

	  <form name="form2" method="post" action="">
	    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td colspan="5" align="left" bgcolor="#DFDFFF"><img src="images/document_view.gif" width="20" height="20"><strong>��������Ҽ��ѹ�֡������</strong></td>
                </tr>
              <tr>
                <td align="right" bgcolor="#EFEFFF"><strong>�ѹ���������� : </strong></td>
                <td colspan="2" align="left" bgcolor="#EFEFFF"><INPUT name="s_date" onFocus="blur();" value="<?=$s_date?>" size="15" readOnly>
              <INPUT name="button" type="button"  onClick="popUpCalendar(this, form2.s_date, 'dd/mm/yyyy')"value="�ѹ ��͹ ��"></td>
                <td colspan="2" align="left" bgcolor="#EFEFFF"><strong>�ѹ�������ش :</strong>
                  <INPUT name="e_date" onFocus="blur();" value="<?=$e_date?>" size="15" readOnly>
                  <INPUT name="button" type="button"  onClick="popUpCalendar(this, form2.e_date, 'dd/mm/yyyy')"value="�ѹ ��͹ ��"></td>
              </tr>
              <tr>
                <td width="12%" align="right" bgcolor="#EFEFFF"><strong>���� : </strong></td>
                <td width="19%" align="left" bgcolor="#EFEFFF"><label>
                  <input name="name1" type="text" id="name1" value="<?=$name1?>">
                </label></td>
                <td width="13%" align="right" bgcolor="#EFEFFF"><strong>���ʡ�� : </strong></td>
                <td width="20%" align="left" bgcolor="#EFEFFF"><label>
                  <input name="name2" type="text" id="name2" value="<?=$name2?>">
                </label></td>
                <td width="36%" align="left" bgcolor="#EFEFFF"><label>
				<input type="hidden" name="xmode" value="<?=$xmode?>">
				<input type="hidden" name="xtype" value="<?=$xtype?>">
                <input type="hidden" name="xsapphireoffice" value="<?=$xsapphireoffice?>">
                  <input type="submit" name="Submit2" value="����">
                </label></td>
              </tr>
            </table></td>
          </tr>
        </table>
      </form>
	</td>
	</tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" align="left" bgcolor="#A5B2CE"><strong>��¡���͵�Ǩ�ҹ &nbsp;&nbsp;<a href="index_assign_key.php?xmode=<?=$xmode?>&xtype=<?=$xtype?>&xsapphireoffice=<?=$xsapphireoffice?>&xstatus_pay=WAIT">�ͨ����Թ</a> || <a href="index_assign_key.php?xmode=<?=$xmode?>&xtype=<?=$xtype?>&xsapphireoffice=<?=$xsapphireoffice?>&xstatus_pay=YES">�����Թ���º��������</a></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
        <td width="22%" align="center" bgcolor="#A5B2CE"><strong>���͹��ʡ��</strong></td>
        <td width="14%" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ����ͺ����</strong></td>
        <td width="13%" align="center" bgcolor="#A5B2CE"><strong>���ʨ��§ҹ</strong></td>
        <td width="14%" align="center" bgcolor="#A5B2CE"><strong>�ѹ����˹��觧ҹ</strong></td>
        <td width="12%" align="center" bgcolor="#A5B2CE"><strong>ʶҹ��觧ҹ</strong></td>
        <td width="13%" align="center" bgcolor="#A5B2CE"><strong>���Ѻ�ͧ</strong></td>
        <td width="8%" align="center" bgcolor="#A5B2CE"><strong>�Ѻ�ҹ</strong></td>
      </tr>
	  <?
	$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
	$e			= (!isset($e) || $e == 0) ? 10 : $e ;
	$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 

	  if($xstatus_pay == ""){ $xstatus_pay = "WAIT";}
	  if($xstatus_pay == "WAIT"){
			$con_pay = " AND tbl_assign_sub.status_pay <> 'YES'"; 
	}else if($xstatus_pay == "YES"){
			$con_pay = " AND tbl_assign_sub.status_pay = 'YES'"; 
	}
	  
	  if($xtype != ""){ $xtype = $xtype;}else{ $xtype = "1";}
	  if($name1 != ""){	$xcon1 .= " AND  keystaff.staffname LIKE '%$name1%'";  }
	  if($name2 != ""){ $xcon1 .= " AND  keystaff.staffsurname  LIKE '%$name2%'";}
	 			 $arr1 = explode("/",$s_date);
				$temp_d1 = ($arr1[2]-543)."-".$arr1[1]."-".$arr1[0];
	  	  		$arr2 = explode("/",$e_date);
				$temp_d2 = ($arr2[2]-543)."-".$arr2[1]."-".$arr2[0];
			
	  if($s_date != ""  and $e_date != ""){
		$xcon1 .= " AND 	tbl_assign_sub.sent_date  BETWEEN '$temp_d1' AND '$temp_d2'";
	  }else if($s_date != "" and $e_date == ""){
	  		$arr2 = explode("/",$e_date);
			$temp_d2 = ($arr2[2]-543)."-".$arr2[1]."-".$arr2[0];
			$xcon1 .= " AND tbl_assign_sub.sent_date LIKE '%$temp_d1%'";
	  }
	  
	  ######################  main######################
	  ## �¡��������ѡ�ҹ�ѹ�֡������
	 	if($xsapphireoffice == "all"){
				$constaff = "";	
		}else if($xsapphireoffice == "0"){
				$constaff = " AND keystaff.sapphireoffice='0'";
		}else if($xsapphireoffice == "2"){
				$constaff = " AND keystaff.sapphireoffice='2'";
		}
	  
			if($xtype == "1"){ // �������������������ҧ���Թ���
				$sql_main = "SELECT  keystaff.staffid, keystaff.prename,
keystaff.staffname,
keystaff.staffsurname FROM keystaff Inner Join tbl_assign_sub ON keystaff.staffid = tbl_assign_sub.staffid
Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid WHERE tbl_assign_sub.assign_status = 'YES'  AND (tbl_assign_key.approve =  '0' OR tbl_assign_key.approve =  '1') AND tbl_assign_sub.nonactive='0' $xcon1 $constaff
group by keystaff.staffid ";
			}else if($xtype == "2"){ // ������������Թ�����������
				$sql_main = "SELECT  keystaff.staffid, keystaff.prename,
keystaff.staffname,
keystaff.staffsurname FROM keystaff Inner Join tbl_assign_sub ON keystaff.staffid = tbl_assign_sub.staffid
Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid  WHERE  tbl_assign_sub.assign_status = 'YES'  AND (tbl_assign_key.approve =  '2' and( tbl_assign_key.approve <>  '0' and tbl_assign_key.approve <>  '1' and tbl_assign_key.approve <>  '3'  )) AND tbl_assign_sub.nonactive='0' $xcon1 $constaff  group by keystaff.staffid ";
			}else if($xtype == "3"){ // ������͵�Ǩ�ҹ
				$sql_main = "SELECT  keystaff.staffid, keystaff.prename,
keystaff.staffname,
keystaff.staffsurname FROM keystaff Inner Join tbl_assign_sub ON keystaff.staffid = tbl_assign_sub.staffid
Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid WHERE  tbl_assign_sub.assign_status = 'YES'  AND (tbl_assign_key.approve =  '3' and( tbl_assign_key.approve <>  '0' and tbl_assign_key.approve <>  '1')) AND tbl_assign_sub.nonactive='0' $xcon1 $constaff group by keystaff.staffid ";
			}// endif($xtype == "1"){
			
			
		$xresult = mysql_query($sql_main);
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
		
	if($page <= $allpage){
			$sql_main .= " LIMIT $i, $e";
	}else if($page == $xpage){
		$i=0;
			$sql_main .= " ";
	}else{
			$sql_main .= " LIMIT $i, $e";
	}

		

		$result_main = mysql_query($sql_main);
		$num_row = mysql_num_rows($result_main);
		$search_sql = $sql_main ; 

		$j1 = 0;
		while($rs_m = mysql_fetch_assoc($result_main)){
		$j1++;
		$i++;
	  	echo "
		<tr  bgcolor='#F0F0F0'>
		<td align='center'>$i</td>
		<td  align='left'  colspan='7'>$rs_m[prename]$rs_m[staffname] $rs_m[staffsurname]</td>
		</tr>
		";
		### �ó��� ticketid �ͧ��
		if($xtype == "1"){
				$sql_ticket = "SELECT tbl_assign_sub.ticketid FROM tbl_assign_sub Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
WHERE (tbl_assign_key.approve =  '0' or tbl_assign_key.approve ='1') and tbl_assign_sub.staffid =  '$rs_m[staffid]' AND tbl_assign_sub.nonactive='0' GROUP BY tbl_assign_key.ticketid";
		}else if($xtype == "2"){
			$sql_ticket = "SELECT tbl_assign_sub.ticketid FROM tbl_assign_sub Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
WHERE (tbl_assign_key.approve =  '2' and( tbl_assign_key.approve <>  '0' and tbl_assign_key.approve <>  '1' and tbl_assign_key.approve <>  '3'  )) and tbl_assign_sub.staffid =  '$rs_m[staffid]' AND tbl_assign_sub.nonactive='0' GROUP BY tbl_assign_key.ticketid";
		}else if($xtype == "3"){
			$sql_ticket = "SELECT tbl_assign_sub.ticketid FROM tbl_assign_sub Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
WHERE (tbl_assign_key.approve =  '3' and( tbl_assign_key.approve <>  '0' and tbl_assign_key.approve <>  '1')) and tbl_assign_sub.staffid =  '$rs_m[staffid]' AND tbl_assign_sub.nonactive='0' GROUP BY tbl_assign_key.ticketid";
		}
		$result_ticket = mysql_query($sql_ticket);
		while($rs_ticket = mysql_fetch_assoc($result_ticket)){
			if($xticket_id > "") $xticket_id .= ",";
			$xticket_id .= "'$rs_ticket[ticketid]'";
		}// end ticketid 
		if($xticket_id != ""){ $xticket_id = $xticket_id;}else{ $xticket_id = "''";}
	  ######################## child ###############
		$sql_m2 = "SELECT
		tbl_assign_sub.ticketid,
		tbl_assign_sub.assign_date,
		tbl_assign_sub.sent_date,
		tbl_assign_sub.approve,
		tbl_assign_sub.status_pay,
		keystaff.staffid,
		keystaff.prename,
		keystaff.staffname,
		keystaff.staffsurname
		FROM
		tbl_assign_sub
		Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid
		where tbl_assign_sub.assign_status = 'YES'  $xcon1 AND keystaff.staffid = '$rs_m[staffid]' and tbl_assign_sub.ticketid in($xticket_id) AND tbl_assign_sub.nonactive='0' $con_pay";
	//echo $sql_m2;
		$result_m2 = mysql_db_query($db_name,$sql_m2);
		$n2 = 0;
		while($rsm2 = mysql_fetch_assoc($result_m2)){
	  	if ($n2++ %  2){ 	$bg = "#F0F0F0"; 	}else{ $bg = "#FFFFFF";	}	
		$txt_s_show = show_date($rsm2[assign_date])." ���ʧҹ  ($rsm2[ticketid])";	
			if($xtype == "1"){
				$img_x = "<img src=\"images/reddot.gif\" width=\"20\" height=\"17\" border=\"0\" alt=\"���������ҧ���Թ���\">";
			}else if($xtype == "2"){
				$img_x = "<img src=\"images/greendot.gif\" width=\"20\" height=\"17\" border=\"0\" alt=\"���Թ������º����\">";
			}else if($xtype == "3"){
				$img_x = "<img src=\"images/yellowdot.gif\" width=\"20\" height=\"17\" border=\"0\" alt=\"�� QC\">";
			}
			
			if($rsm2[status_pay] == "WAIT"){
				$pay_img = "<img src=\"images/info1.gif\" width=\"18\" height=\"18\" border=\"0\" alt=\"ʶҹ��ͨ����Թ\">";
			}else if($rsm2[status_pay] == "YES"){
				$pay_img = "<img src=\"images/department_money.gif\" width=\"18\" height=\"18\" border=\"0\" alt=\"ʶҹШ����Թ���º��������\">";
			}else{
				$pay_img = "";
			}
	
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td colspan="2" align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo " ".show_date($rsm2[assign_date]); ?></td>
        <td align="center" bgcolor="#FFFFFF"><? if(count_assign_key($rsm2[ticketid]) > 0){ echo "<a href='?action=view_key&staffid=$rsm2[staffid]&ticketid=$rsm2[ticketid]&xname=$txt_s_show&xmode=2&xtype=$xtype'>".number_format(count_assign_key($rsm2[ticketid]))."</a>";}else{ echo "0";}?></td>
        <td align="center" bgcolor="#FFFFFF"><? 
echo $rsm2[ticketid];


?></td>
        <td align="center" bgcolor="#FFFFFF"><? echo show_date($rsm2[sent_date]); ?></td>
        <td align="center" bgcolor="#FFFFFF"><?  echo $pay_img; echo " $img_x ";?>   </td>
        <td align="center" bgcolor="#FFFFFF"><? echo show_staff_approve($rsm2[ticketid]);?></td>
        <td align="center" bgcolor="#FFFFFF"><a href="recive_job.php?ticketid=<?=$rsm2[ticketid]?>&xmode=2&xtype=<?=$xtype?>" target="_blank"><img src="images/task.gif" alt="���������Ѻ�ҹ" width="19" height="19" border="0"></a></td>
      </tr>
	  	<?
		  }// end while(){
		  	$xticket_id = ""; // ��ҧ�������㺧ҹ��͹ loop����
	} // end w
		  ?>
      <tr>
        <td colspan="8" align="left" bgcolor="#FFFFFF">	
		<? $sqlencode = urlencode($search_sql)  ; ?>	
	<?=devidepage($allpage, $keyword ,$sqlencode )?>	</td>
        </tr>

    </table></td>
  </tr>
</table>
<?
	}// end if($xmode == "2"){
	if($xmode == ""){

?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
	<? 
		if($utype == "all"){ $fcolor1 = "<font color='#000000'>"; $fcolor_n1 = "</font>"; $bg1 = "#FFFFFF";}else{  $bg1 = "#A5B2CE";} 
		if($utype == "em"){ $fcolor2 = "<font color='#000000'>"; $fcolor_n2 = "</font>"; $bg2 = "#FFFFFF";}else{ $bg2 = "#A5B2CE";} 
		if($utype == "sub"){ $fcolor3 = "<font color='#000000'>"; $fcolor_n3 = "</font>"; $bg3 = "#FFFFFF";}else{ $bg3 = "#A5B2CE";} 
	
	?>
      <tr>
        <td width="17%" align="center" bgcolor="<?=$bg1?>"><a href="index_assign_key.php?xmode=&utype=all"><strong>
          <?=$fcolor1?>
          ���ѹ�֡������
          <?=$fcolor_n1?>
        </strong></a></td>
        <td width="15%" align="center" bgcolor="<?=$bg2?>"><strong><a href="index_assign_key.php?xmode=&utype=em">
          <?=$fcolor2?>
          �١��ҧ���Ǥ���
          <?=$fcolor_n2?>
       </a> </strong></td>
        <td width="16%" align="center" bgcolor="<?=$bg3?>"><strong><a href="index_assign_key_sub.php?xmode=&utype=sub" target="_blank">
          <?=$fcolor3?>
          Subcontract
          <?=$fcolor_n3?>
       </a> </strong></td>
        <td width="52%" align="center" bgcolor="#A5B2CE">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<form name="form3" method="post" action="">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#000000">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="5" align="left" bgcolor="#DFDFFF"><strong><img src="images/document_view.gif" width="20" height="20">��������Ҽ��ѹ�֡������</strong></td>
          </tr>
        <tr>
          <td width="12%" align="right" bgcolor="#EFEFFF"><strong>���� : </strong></td>
          <td width="22%" align="left" bgcolor="#EFEFFF"><label>
            <input name="xname1" type="text" id="xname1" value="<?=$xname1?>">
          </label></td>
          <td width="12%" align="right" bgcolor="#EFEFFF"><strong>���ʡ�� : </strong></td>
          <td width="20%" align="left" bgcolor="#EFEFFF"><label>
            <input name="xname2" type="text" id="xname2" value="<?=$xname2?>">
          </label></td>
          <td width="34%" align="left" bgcolor="#EFEFFF"><label>
		  	<input type="hidden" name="xmode" value="<?=$xmode?>">
			<input type="hidden" name="utype" value="<?=$utype?>">
            <input type="submit" name="Submit3" value="����">
          </label></td>
        </tr>
      </table>
    
    </td>
  </tr>
</table>    </form>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="left" bgcolor="#A5B2CE"><strong>��ª��;�ѡ�ҹ�����ͺ���§ҹ</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
        <td width="30%" align="center" bgcolor="#A5B2CE"><strong>���͹��ʡ��</strong></td>
        <td width="19%" align="center" bgcolor="#A5B2CE"><strong>������</strong></td>
        <td width="20%" align="center" bgcolor="#A5B2CE"><strong>�������</strong></td>
        <td width="17%" align="center" bgcolor="#A5B2CE"><strong>��������ѡ�ҹ</strong></td>
        <td width="10%" align="center" bgcolor="#A5B2CE"><strong>�ͺ���§ҹ</strong></td>
      </tr>
	  <? 
	  	$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
		$e			= (!isset($e) || $e == 0) ? 20 : $e ;
		$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 

	  
	  if($utype == "" or $utype == "all"){ $con = " sapphireoffice <> '1' ";}
	  if($utype == "em"){ $con = " sapphireoffice = '0' ";}
	  if($utype == "sub"){ $con = " sapphireoffice = '2'";}
	  if($xname1 != ""){ $xcon .= " AND staffname LIKE '%$xname1%'";}
	  if($xname2 != ""){ $xcon .= " AND staffsurname LIKE '%$xname2%'";}
	 // $sql_staff = "SELECT * FROM keystaff  WHERE status_permit = 'YES'  AND $con $xcon order by sapphireoffice ASC ";
	  $sql_staff = "SELECT 
 tbl_assign_sub.staffid,
keystaff.staffid,
keystaff.gid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
keystaff.engprename,
keystaff.engname,
keystaff.engsurname,
keystaff.priority,
keystaff.email,
keystaff.image,
keystaff.`comment`,
keystaff.sex,
keystaff.org_id,
keystaff.title,
keystaff.telno,
keystaff.address,
keystaff.std_cost,
keystaff.username,
keystaff.`password`,
keystaff.`status`,
keystaff.card_id,
keystaff.weight,
keystaff.sapphireoffice,
keystaff.status_permit,
keystaff.retire_date,
tbl_assign_sub.assign_date  FROM keystaff LEFT JOIN tbl_assign_sub ON keystaff.staffid=tbl_assign_sub.staffid  WHERE keystaff.status_permit='YES'  AND $con $xcon  
GROUP BY  tbl_assign_sub.staffid,
keystaff.staffid
ORDER BY  tbl_assign_sub.assign_date DESC  ";
	 //echo $sql_staff;
	 
	 	$xresult = mysql_query($sql_staff);
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
		
	if($page <= $allpage){
			$sql_staff .= " LIMIT $i, $e";
	}else if($page == $xpage){
	$i=0;
			$sql_staff .= " ";
	}else{
			$sql_staff .= " LIMIT $i, $e";
	}

		

		$result_main = mysql_query($sql_staff);
		$num_row = mysql_num_rows($result_main);
		$search_sql = $sql_staff ; 

	 // $result_staff = mysql_db_query($db_name,$sql_staff);
	  $nn= 0;
	  while($rs1 = mysql_fetch_assoc($result_main)){
	  $i++;
	  	if ($nn++ %  2){ 	$bg = "#F0F0F0"; 	}else{ $bg = "#FFFFFF";	}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs1[prename]$rs1[staffname] $rs1[staffsurname]";?></td>
        <td align="left"><?=$rs1[telno]?></td>
        <td align="left"><?=$rs1[email]?></td>
        <td align="left"><? if($rs1[sapphireoffice]=="0"){echo "�١��ҧ���Ǥ���";}else if($rs1[sapphireoffice]=="2"){echo "Subcontract";}else{echo "����к�";}?></td>
        <td align="center"><a href="assign_main.php?staffid=<?=$rs1[staffid]?>" target="_blank"><img src="images/budget.gif" alt="���������ͺ���§ҹ" width="16" height="16" border="0"></a></td>
      </tr>
	  	  <?
	  	} // end while(){
	  ?>
      <tr>
        <td colspan="6" align="left" bgcolor="#EFEFFF"><? $sqlencode = urlencode($search_sql)  ; ?>
          <?=devidepage($allpage, $keyword ,$sqlencode )?></td>
        </tr>
    </table></td>
  </tr>
</table>

<? } //end if($xmode == ""){
if($xmode == "1"){
?>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
<?
		if($xtype != ""){$xtype = $xtype;}else{ $xtype = "1";}
		if($xtype == "1"){ $fcolor1 = "<font color='#000000'>"; $fcolor_n1 = "</font>"; $bg1 = "#FFFFFF";}else{  $bg1 = "#A5B2CE";} 
		if($xtype == "2"){ $fcolor2 = "<font color='#000000'>"; $fcolor_n2 = "</font>"; $bg2 = "#FFFFFF";}else{ $bg2 = "#A5B2CE";} 
?>
    <tr>
      <td width="16%" align="center" bgcolor="<?=$bg1?>"><strong><a href="index_assign_key.php?xmode=1&xtype=1"><?=$fcolor1?>�ͨ��§ҹ<?=$fcolor_n1?></a></strong></td>
      <td width="17%" align="center" bgcolor="<?=$bg2?>"><strong><a href="index_assign_key.php?xmode=1&xtype=2"><?=$fcolor2?>���§ҹ���º��������<?=$fcolor_n2?></a></strong></td>
      <td colspan="2" align="center" bgcolor="#A5B2CE">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="center" bgcolor="#EFEFFF">&nbsp;</td>
    </tr>
    <?
    	if($xsapp != ""){$xsapp = $xsapp;}else{ $xsapp = "all";}
		if($xsapp == "all"){ $fcolor1 = "<font color='#000000'>"; $fcolor_n1 = "</font>"; $bg1 = "#FFFFFF";}else{  $bg1 = "#A5B2CE";} 
		if($xsapp == "0"){ $fcolor2 = "<font color='#000000'>"; $fcolor_n2 = "</font>"; $bg2 = "#FFFFFF";}else{ $bg2 = "#A5B2CE";} 
		if($xsapp == "2"){ $fcolor3 = "<font color='#000000'>"; $fcolor_n3 = "</font>"; $bg3 = "#FFFFFF";}else{ $bg3 = "#A5B2CE";} 
	?>
    <tr>
      <td align="center" bgcolor="<?=$bg1?>"><strong><a href="index_assign_key.php?xmode=1&xtype=<?=$xtype?>&xsapp=all"><?=$fcolor1?>�����ŷ�����<?=$fcolor_n1?></a></strong></td>
      <td align="center" bgcolor="<?=$bg2?>"><strong><a href="index_assign_key.php?xmode=1&xtype=<?=$xtype?>&xsapp=0"><?=$fcolor2?>�١��ҧ���Ǥ���<?=$fcolor_n2?></a></strong></td>
      <td width="14%" align="center" bgcolor="<?=$bg3?>"><strong><a href="index_assign_key.php?xmode=1&xtype=<?=$xtype?>&xsapp=2" target="_blank"><?=$fcolor3?>Subcontract<?=$fcolor_n3?></a></strong></td>
      <td width="53%" align="center" bgcolor="#A5B2CE">&nbsp;</td>
    </tr>
</table>
<form name="form1" method="post" action="">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="5" align="left" valign="top" bgcolor="#DFDFFF"><strong><img src="images/document_view.gif" width="20" height="20">��������Ҽ��ѹ�֡������</strong></td>
          </tr>
        <tr>
          <td width="6%" align="right" bgcolor="#EFEFFF"><strong>���� : </strong></td>
          <td width="23%" align="left" bgcolor="#EFEFFF"><strong>
            <label>
            <input name="name_th" type="text" id="name_th" value="<?=$name_th?>">
              </label>
          </strong></td>
          <td width="8%" align="right" bgcolor="#EFEFFF"><strong>���ʡ�� : </strong></td>
          <td width="25%" align="left" bgcolor="#EFEFFF"><strong>
            <label>
            <input name="surname_th" type="text" id="surname_th" value="<?=$surname_th?>">
              </label>
          </strong></td>
          <td width="38%" align="left" bgcolor="#EFEFFF"><label>
		  <input  type="hidden" name="xmode" value="<?=$xmode?>">
		  <input type="hidden" name="xtype" value="<?=$xtype?>">
          <input type="hidden" name="xsapp" value="<?=$xsapp?>">
            <input type="submit" name="Submit" value="����">
          </label></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<table border=0 align=center cellspacing=1 cellpadding=2 bgcolor=black width="98%" class="sortable" id="unique_id">
<tr bgcolor="#a3b2cc">
<th width=39>�ӴѺ</th>
<th width="307">���� - ���ʡ��</th>
<th width="184">�ӹǹ����ͺ����</th>
<th width="202">���ʡ�è��§ҹ</th>
<th width="113">��§ҹ���§ҹ</th>
<th width="82">���§ҹ</th>
</tr>
<?
	$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
	$e			= (!isset($e) || $e == 0) ? 20 : $e ;
	$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 



if($xtype != ""){$xtype = $xtype;}else{ $xtype = "1";}
if($xtype == "1"){ $con1 = "  where  tbl_assign_sub.assign_status='NO' ";}
if($xtype == "2"){ $con1 = "  where  tbl_assign_sub.assign_status='YES' ";}

if($name_th != ""){
	$xcon2 .= " AND keystaff.staffname LIKE '%$name_th%'";
}
if($surname_th != ""){
	$xcon2 .= " AND keystaff.staffsurname LIKE '%$surname_th%'";
}

### �¡��������ѡ�ҹ
if($xsapp == "all"){
		$consf = "";
}else if($xsapp == "0"){
		$consf = " AND keystaff.sapphireoffice='0'";
}else if($xsapp == "2"){
		$consf = " AND keystaff.sapphireoffice='2'";
}

$n = 0;
$sql_temp = "SELECT
tbl_assign_sub.ticketid,
tbl_assign_sub.assign_date,
tbl_assign_sub.assign_status,
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname
FROM
tbl_assign_sub
Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid
$con1 $xcon2  AND tbl_assign_sub.nonactive='0'  $consf  GROUP BY keystaff.staffid  ORDER BY keystaff.staffid ASC 
";

	 	$xresult = mysql_query($sql_temp);
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
		
	if($page <= $allpage){
			$sql_temp .= " LIMIT $i, $e";
	}else if($page == $xpage){
	$i=0;
			$sql_temp .= " ";
	}else{
			$sql_temp .= " LIMIT $i, $e";
	}

		

		$result_temp = mysql_query($sql_temp);
		$num_row = mysql_num_rows($result_temp);
		$search_sql = $sql_temp ; 

$k=0;
while($rs_t = mysql_fetch_assoc($result_temp)){
$i++;
$k++;
	echo "<tr bgcolor='#F0F0F0'>
	<td align='center'>$i</td>
	<td align='left'  colspan='5'> $rs_t[prename]$rs_t[staffname]  $rs_t[staffsurname]</td>
	</tr>";

$sql = "SELECT
tbl_assign_sub.ticketid,
tbl_assign_sub.assign_date,
tbl_assign_sub.assign_status,
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname
FROM
tbl_assign_sub
Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid
$con1  AND  keystaff.staffid ='$rs_t[staffid]' AND tbl_assign_sub.nonactive='0' ORDER BY  tbl_assign_sub.assign_date   ASC
";

$result = mysql_query($sql);
while ($rs=mysql_fetch_assoc($result)){
	if ($n++ %  2){
		$bgcolor = "#F0F0F0";
	}else{
		$bgcolor = "#FFFFFF";
	}
	$txt_s_show = show_date($rs[assign_date])." ���ʧҹ  ($rs[ticketid])";
?>
<tr  bgcolor="#FFFFFF">
<!--<td align=center ><?=$n?></td>-->
<td align="left"  colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  -  �ѹ��� <?=thai_date($rs[assign_date]);?></td>
<td align="center" valign="middle" ><? if(count_assign_key($rs[ticketid]) > 0){ echo "<a href='?action=view_key&staffid=$rs[staffid]&ticketid=$rs[ticketid]&xname=$txt_s_show&xmode=1&xtype=$xtype'>".number_format(count_assign_key($rs[ticketid]))."</a>";}else{ echo "0";}?></td>
<td align="center" valign="middle" >
<? 
echo "$rs[ticketid]";


?></td>
<td align="center" ><? 
if($_SESSION[session_sapphire] == "1"){ //���੾�о�ѡ�ҹ sapphire ��ҹ��

 if($rs[assign_status] == "YES"){ echo "<a href='assign_pdf.php?ticketid=$rs[ticketid]'><img src=\"../../images_sys/pdf.gif\" alt=\"���§ҹ���º�������Ǥ������ͻ����͡��� pdf\" width=\"20\" height=\"20\" border=\"0\"></a>";}
 
 } //end if($_SESSION[session_sapphire] == "1"){
 
 ?> </td>
<td align="center" ><a href="sent_job.php?ticketid=<?=$rs[ticketid]?>&xmode=1" target="_blank"><img src="../../images_sys/refresh.png" alt="��������ͺ���ºؤ�ҡ����Ѻ�������зӡ�úѹ�֡������ �.�.7" width="20" height="20" border="0"></a></td>
</tr>
<?
	} // end while ($rs=mysql_fetch_assoc($result)){
}//end while($rs_t = mysql_fetch_assoc($result_temp)){
?>

<tr  bgcolor="#FFFFFF">
  <td align="left"  colspan="6"><? $sqlencode = urlencode($search_sql)  ; ?>
          <?=devidepage($allpage, $keyword ,$sqlencode )?></td>
  </tr>
</table>
<?
	}// end if($action == "1"){
 } //end if($action == ""){
	if($action == "view_key"){
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td colspan="8" bgcolor="#A3B2CC"><input type="button" name="btnBB" value="��͹��Ѻ" onClick="location.href='index_assign_key.php?xmode=<?=$xmode?>&xtype=<?=$xtype?>'">
            <strong><?=show_user($staffid)?>  �ѹ���<?=$xname?>
          </strong></td>
      </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A3B2CC"><strong>�ӴѺ</strong></td>
        <td width="13%" align="center" bgcolor="#A3B2CC"><strong>���ʻ�Шӵ�ǻ�ЪҪ�</strong></td>
        <td width="19%" align="center" bgcolor="#A3B2CC"><strong>���� - ���ʡ�� </strong></td>
        <td width="21%" align="center" bgcolor="#A3B2CC"><strong>�ç���¹/˹��§ҹ</strong></td>
        <td width="18%" align="center" bgcolor="#A3B2CC"><strong>���˹�</strong></td>
        <td width="9%" align="center" bgcolor="#A3B2CC"><strong>�����Ҫ���</strong></td>
        <td width="8%" align="center" bgcolor="#A3B2CC"><strong>PDF�鹩�Ѻ</strong></td>
        <td width="8%" align="center" bgcolor="#A3B2CC"><strong>PDF�ҡ�к�</strong></td>
      </tr>
      <? 
	  
$sql_show = "SELECT
$db_name.tbl_assign_key.ticketid,
$dbnamemaster.view_general.CZ_ID,
$dbnamemaster.view_general.siteid,
$dbnamemaster.view_general.prename_th,
$dbnamemaster.view_general.name_th,
$dbnamemaster.view_general.surname_th,
$dbnamemaster.view_general.position_now,
$dbnamemaster.view_general.schoolid,
(TIMESTAMPDIFF(MONTH,begindate,'$year1')/12) as age_gov
FROM
$db_name.tbl_assign_key
Inner Join $dbnamemaster.view_general ON $db_name.tbl_assign_key.idcard = $dbnamemaster.view_general.CZ_ID WHERE $db_name.tbl_assign_key.ticketid='$ticketid'";
//echo $db_name." <br>".$sql_show;

	  $result_show = mysql_db_query($db_name,$sql_show);
	  while($rs_s = mysql_fetch_assoc($result_show)){
	   if ($k++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$k?></td>
        <td align="center"><?=$rs_s[CZ_ID]?></td>
        <td align="left"><? echo "$rs_s[prename_th]$rs_s[name_th]  $rs_s[surname_th]";?></td>
        <td align="left"><? echo show_org($rs_s[schoolid])."/".show_area($rs_s[siteid]);?></td>
        <td align="left"><? echo "$rs_s[position_now]";?></td>
        <td align="center"><? echo floor($rs_s[age_gov]);?></td>
        <td align="center"><a href="../../../edubkk_kp7file/<?=$rs_s[siteid]?>/<?=$rs_s[CZ_ID].".pdf";?>" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" width="20" height="20" alt="�͡��� �.�.7 �鹩�Ѻ" border="0"></a></td>
        <td align="center">
		<?  
	$pdf		= "<a href=\"../hr3/hr_report/kp7.php?id=".$rs_s[CZ_ID]."&sentsecid=".$rs_s[siteid]."\" target=\"_blank\">";
	$pdf		.= "<img src=\"../../images_sys/pdf.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"  alt='�.�.7 ���ҧ���к� '  ></a>";
				 echo $pdf;
				 ?>
		</td>
      </tr>
      <?
	  }// end while(){
	  ?>
    </table></td>
  </tr>
</table>
<?
	}// end if($action == "view_key"){
?>
</BODY>
</HTML>
