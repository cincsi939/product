<?
$ApplicationName	= "userentry";
$module_code 		= "assign"; 
$process_id			= "assign";
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
	## Modified Detail :		�к� �ͺ���§ҹ �.�.7
	## Modified Date :		2011-07-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
include "epm.inc.php";
include("function_assign.php");
//include("function_assign_group.php");
include("../../common/common_competency.inc.php");
$time_start = getmicrotime();
//$type_cmss = "province"; // ��˹��ó����к��ͧ �ѧ��Ѵ
$s_db = STR_PREFIX_DB;
//$dis = " disabled='disabled'"; // �óջԴ���� �������ͧ��á�˹���������ҡѺ��ͧ��ҧ
//if($dbnamemaster == "cmss_pro_master"){ $temp_site = "1300";};
$report_title = "�ͺ���¡�úѹ�֡������ �.�.7 ���Ѻ�����";

$num_docfix = 36; 
$year1 = (date("Y")+543)."-09-30";
$gmonth = date("Y-m");
$xnumwait = CheckNumKeyStaff($staffid,$profile_id);


	$sql_staff = "SELECT * FROM keystaff WHERE staffid='$staffid'";
	$result_staff = mysql_db_query($db_name,$sql_staff);
	$rs_staff = mysql_fetch_assoc($result_staff);
	$idcard_staff = $rs_staff[card_id]; // �Ţ�ѵû�ЪҪ��ͧ��ѡ�ҹ���������
	
	### ��ͧ����ҹ�ͧ��ѡ�ҹ���������
	$sitekey = GetSiteName($idcard_staff);
	// connet �������ͧ db server
	ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
	

	#echo "<pre>";
	#print_r($_POST);
	


if($_SERVER['REQUEST_METHOD'] == "POST"){
	
if($_POST['Aaction'] == "" and count($xidcard) > 0){
	$Aaction = 	"SAVE_W";
}
	
#echo "<pre>";
#print_r($_POST);
if($Aaction == "SAVE_W"){
	
	
	
	//echo "<pre>";
	//print_r($_POST);die;
	
			if($TicketId == ""){
					$TicketId = "TK-".$ticketYY."".ran_digi(7);
					$sql_tk = "INSERT INTO tbl_assign_sub SET ticketid='$TicketId' , staffid='$staffid' , profile_id='$profile_id',assign_date='".sw_date_indb($c_date)."', admin_id='$session_staffid', localtion_key='$localtion_key' ,mode_assign='$mode_assign'";
				}else{
					$sql_tk = "UPDATE  tbl_assign_sub SET staffid='$staffid' , assign_date='".sw_date_indb($c_date)."', admin_id='$session_staffid', localtion_key='$localtion_key',profile_id='$profile_id',mode_assign='$mode_assign' WHERE  ticketid='$TicketId' ";
				}// end if($TicketId == ""){
				
				
				#echo "sql :: $sql_tk<br>";
				$result_tk = mysql_db_query($db_name,$sql_tk) or die(mysql_error()."$sql_tk<br>LINE__".__LINE__);
				
				#echo "<Pre>";
				#print_r($xidcard);
				
				if($result_tk){
					$idcard = $xidcard;
					$name = $fullname;
					$siteid = $xsiteid;
					
					
					if(count($idcard) > 0){
						foreach($idcard as $k => $v){
							if($xsiteid[$k] != $temp_xsiteid){
								$dateassign = sw_date_indb($c_date);
								SaveAssignActivityTicketId($TicketId,$xsiteid[$k],$staffid,$profile_id,$dateassign,$session_staffid);// ����㺧ҹ�ͧchecklist	
								$temp_xsiteid = $xsiteid;
							}
							
							if(check_assign_replace($v,$TicketId) > 0){ // ��Ǩ�ͺ�ó��ա�úѹ�֡�����ū�� ��������ѹ
							$temp_alert = " �������ö�ѹ�֡ $name[$k] ���ʺѵ� $v �����ͧ�ҡ��¡�ù����١�ͺ���§ҹ������к�";
							echo "<script>alert('$temp_alert');</script>";
							}else{
								### ��Ǩ�ͺ�����š�͹�ӡ������
							$sql_check = "SELECT * FROM  tbl_assign_key WHERE ticketid='$TicketId' AND idcard='$v' and profile_id='$profile_id'" ;
							$result_chekc = mysql_db_query($db_name,$sql_check) or die(mysql_error()."$sql_check<br>LINE__".__LINE__);
							$rs_ch = mysql_fetch_assoc($result_chekc);
								if($rs_ch[idcard] != ""){
										$sql_insert = "UPDATE tbl_assign_key SET siteid='$xsiteid[$k]', fullname='$name[$k]',profile_id='$profile_id' WHERE ticketid='$rs_ch[ticketid]' AND idcard='$rs_ch[idcard]'";
									UpdateMarkAssign($rs_ch[idcard],$profile_id,"0"); // ��ҧ��ҡ�èͧ
									UpdateStatusAssign($rs_ch[idcard],$profile_id);// update ʶҹС���ͺ���§ҹ�����
									#SaveLogAssign("update",$TicketId,$v,$xstatus_file[$v]);
									SaveLogAssignKey($TicketId,$rs_ch[idcard],$profile_id,$xsiteid[$k],$name[$k],"0","update","���㺧ҹ");
								}else{
									$sql_insert = "INSERT INTO tbl_assign_key(ticketid,idcard,siteid,fullname,profile_id)VALUES('$TicketId','$v','$xsiteid[$k]','$name[$k]','$profile_id')";
									UpdateMarkAssign($v,$profile_id,"0"); // ��ҧ��ҡ�èͧ
									UpdateStatusAssign($v,$profile_id);// update ʶҹС���ͺ���§ҹ�����
									#SaveLogAssign("insert",$TicketId,$v,$xstatus_file[$v]);
									SaveLogAssignKey($TicketId,$v,$profile_id,$xsiteid[$k],$name[$k],"0","insert","����㺧ҹ");
								}
								## end ��Ǩ�ͺ�����š�͹����
								
								
								mysql_db_query($db_name,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE__".__LINE__);
							
							#### �纡���ͺ���§ҹ� checklist
							SaveAssignActivity($TicketId,$v,$xsiteid[$k],$xprename_th[$k],$xname_th[$k],$xsurname_th[$k],$profile_id);// ��㺧ҹ� checklist
							
							} // end if(check_assign_replace($v) > 0){ 
						}// end 	foreach($xidcard as $k => $v){
					}// end if(count($xidcard) > 0){

				
				}// end if($result_tk){
				
			echo "<script>alert('�ѹ�֡������㺧ҹ���º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=assign_detail&TicketId=$TicketId&staffid=$staffid&profile_id=$profile_id';</script>";

		
}//end if($Aaction == "SAVE_W"){




		else if($Aaction == "SAVE"){
	
			/// �Ѵ��â����š�è��§ҹ��͹
				if($TicketId == ""){
					$TicketId = "TK-".$ticketYY."".ran_digi(7);
					$sql_tk = "INSERT INTO tbl_assign_sub SET ticketid='$TicketId' , staffid='$staffid' , profile_id='$profile_id',assign_date='".sw_date_indb($c_date)."', admin_id='$session_staffid', localtion_key='$localtion_key' ";
				}else{
					$sql_tk = "UPDATE  tbl_assign_sub SET staffid='$staffid' , assign_date='".sw_date_indb($c_date)."', admin_id='$session_staffid', localtion_key='$localtion_key',profile_id='$profile_id' WHERE  ticketid='$TicketId' ";
				}// end if($TicketId == ""){

				$result_tk = mysql_db_query($db_name,$sql_tk);
				if($result_tk){
					$idcard = $xidcard;
					$name = $fullname;
					$siteid = $xsiteid;
					if(count($idcard) > 0){
						foreach($idcard as $k => $v){
							if(check_assign_replace($v,$TicketId) > 0){ // ��Ǩ�ͺ�ó��ա�úѹ�֡�����ū�� ��������ѹ
							$temp_alert = " �������ö�ѹ�֡ $name[$k] ���ʺѵ� $v �����ͧ�ҡ��¡�ù����١�ͺ���§ҹ������к�";
							echo "<script>alert('$temp_alert');</script>";
							}else{
								### ��Ǩ�ͺ�����š�͹�ӡ������
							$sql_check = "SELECT * FROM  tbl_assign_key WHERE ticketid='$TicketId' AND idcard='$v' and profile_id='$profile_id'" ;
							$result_chekc = @mysql_db_query($db_name,$sql_check);
							$rs_ch = @mysql_fetch_assoc($result_chekc);
								if($rs_ch[idcard] != ""){
										$sql_insert = "UPDATE tbl_assign_key SET siteid='$xsiteid[$k]', fullname='$name[$k]',profile_id='$profile_id' WHERE ticketid='$rs_ch[ticketid]' AND idcard='$rs_ch[idcard]'";
									#SaveLogAssign("update",$TicketId,$v,$xstatus_file[$v]);
									SaveLogAssignKey($TicketId,$rs_ch[idcard],$profile_id,$xsiteid[$k],$name[$k],"0","update","���㺧ҹ");
								}else{
									$sql_insert = "INSERT INTO tbl_assign_key(ticketid,idcard,siteid,fullname,profile_id)VALUES('$TicketId','$v','$xsiteid[$k]','$name[$k]','$profile_id')";
									#SaveLogAssign("insert",$TicketId,$v,$xstatus_file[$v]);
									SaveLogAssignKey($TicketId,$v,$profile_id,$xsiteid[$k],$name[$k],"0","insert","����㺧ҹ");
								}
								## end ��Ǩ�ͺ�����š�͹����
							mysql_db_query($db_name,$sql_insert);
							
							} // end if(check_assign_replace($v) > 0){ 
						}// end 	foreach($xidcard as $k => $v){
					}// end if(count($xidcard) > 0){

				
				}// end if($result_tk){
				
			echo "<script>alert('�ѹ�֡������㺧ҹ���º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=assign_detail&TicketId=$TicketId&staffid=$staffid&profile_id=$profile_id';</script>";
		}// end 	if($Aaction == "SAVE"){

}// end if($_SERVER['REQUEST_METHOD'] == "POST"){

### ��¡��ź������

if($action == "del"){
		$sql_check = "SELECT COUNT(idcard) AS num1 FROM tbl_assign_key WHERE ticketid='$TicketId' and profile_id='$profile_id' GROUP BY ticketid";
		$result_check = mysql_db_query($db_name,$sql_check);
		$rs_c = mysql_fetch_assoc($result_check);
		if($rs_c[num1] > 0){
	echo "<script>alert('�������öź��¡�������ͧ�ҡ����¡�����������㺧ҹ���'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=view_main&staffid=$staffid&profile_id=$profile_id';</script>";
		}else{
	$sql_del = "DELETE  FROM tbl_assign_sub WHERE ticketid='$TicketId' and profile_id='$profile_id'";
	mysql_db_query($db_name,$sql_del) or die(mysql_error()."$sql_del<br>LINE__".__LINE__);
	$sql_assign = "SELECT *  FROM tbl_assign_key WHERE ticketid='$TicketId' and profile_id='$profile_id'";
	$result_assign = mysql_db_query($dbnameuse,$sql_assign) or die(mysql_error()."".__LINE__);
	while($rsa = mysql_fetch_assoc($result_assign)){
		SaveLogAssignKey($TicketId,$rsa[idcard],$profile_id,$rsa[siteid],$ras[fullname],"$rsa[approve]","delete","ź㺧ҹ");	
	}//end while($rsa = mysql_fetch_assoc($result_assign)){
	
	$sql_del1 = "DELETE FROM tbl_assign_key WHERE ticketid='$TicketId' and profile_id='$profile_id'";
	mysql_db_query($db_name,$sql_del1) or die(mysql_error()."$sql_del1<br>LINE__".__LINE__);
	
	
	if(!(mysql_error())){
		echo "<script>alert('ź��¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=view_main&staffid=$staffid&profile_id=$profile_id';</script>";
	}
	
	}//end 	if($rs_c[num1] > 0){
}// end if($action == "del"){
### end ��¡��ź������

if($action == "del_person"){ // ź��������ǹ�ؤ��
$sql_del = "DELETE FROM tbl_assign_key WHERE ticketid='$ticketid' AND idcard='$idcard' AND profile_id='$profile_id' ";
mysql_db_query($db_name,$sql_del) or die(mysql_error()."$sql_del<br>LINE__".__LINE__);
SaveLogAssignKey($ticketid,$idcard,$profile_id,$xsiteid[$k],$name[$k],"0","delete","ź㺧ҹ");

	if(!(mysql_error())){
		echo "<script>alert('ź��¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=assign_detail&staffid=$staffid&TicketId=$ticketid&profile_id=$profile_id';</script>";
	}


}
// end ź��������ǹ�ؤ��



?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">
function confirmDelete(delUrl) {
//  if (confirm("�س��㨷���ź������ cmss ��ԧ�������")) {
//  window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
    //document.location = delUrl;
	//document.location =  
	window.open(delUrl,null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
 // }
}

function confirmDelete1(delUrl) {
  if (confirm("�س��㨷���ź���������������?")) {
  //window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
    document.location = delUrl;
  }
}

</script>

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
	
	
	
	
	
	/////////////////////  ajax
	
	
var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}
    
	
function refreshproductList() {
   var sent_siteid = document.getElementById("sent_siteid").value;
    if(sent_siteid == "" ) {
        clearproductList();
        return;
    }
    var url = "ajax_school.php?sent_siteid=" + sent_siteid;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStateChange;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}
    
function handleStateChange() {
    if(xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            updateproductList();
        }
    }
}

function updateproductList() {
    clearproductList();
    var schoolid = document.getElementById("schoolid");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
		
			option = document.createElement("option");
		   option.setAttribute("value",0);
           option.appendChild(document.createTextNode("����к�"));
           schoolid.appendChild(option);


    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
		  	option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           schoolid.appendChild(option);
	}
    }
}

function clearproductList() {
    var schoolid = document.getElementById("schoolid");
    while(schoolid.childNodes.length > 0) {
              schoolid.removeChild(schoolid.childNodes[0]);
    }
}

</script>
<script language="javascript">

	function checkFm(){
		var age1 = document.form_m1.age_g1.value;
		var age2 = document.form_m1.age_g2.value;
		
		
	if(age1 > 0 && age2 > 0){ // 㹡óդ��Ҫ�ǧ�����Ҫ��� 
		if(age1 > age2){
			alert("�����Ҫ�������ش��ͧ�����¡��������Ҫ����������");
			document.form_m1.age_g2.focus();
			return false;
		}
	}
return true;		
	}

	function check_number(){
		var num1 = document.form_m1.person_no.value;
	 if (isNaN(num1)) {
      alert("��س��к�੾�е���Ţ��ҹ��");
      document.form_m1.person_no.focus();
      return false;
      }

		
	}
</script>
<style type="text/css">
<!--
.style1 {
	color: #990000;
	font-style: italic;
}
-->
</style>
</head>
<body bgcolor="#EFEFFF">
<?
	if($action == "view_main"){
	$sql = "SELECT * FROM keystaff WHERE staffid='$staffid'";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	
?>
<table width="98%" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" cellpadding="2" cellspacing="1">
      <tr>
        <td colspan="6" align="left" bgcolor="#A5B2CE"><strong>��¡���ͺ�ҹ�ͧ <? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?>&nbsp;<?=ShowDateProfile($profile_id);?></strong></td>
        </tr>
      <tr>
        <td width="17%" align="center" bgcolor="#A5B2CE"><strong>�����ͺ�ҹ</strong></td>
        <td width="21%" align="center" bgcolor="#A5B2CE"><strong>�ѹ����ͺ�ҹ</strong></td>
        <td width="19%" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ�ؤ�ҡ÷�����(��)</strong></td>
        <td width="20%" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ����ѧ�ѹ�֡�������������(��)</strong></td>
        <td width="14%" align="center" bgcolor="#A5B2CE"><strong>ʶҹС���ͺ�ҹ</strong></td>
        <td width="9%" align="center" bgcolor="#A5B2CE"><label>
          <input type="button" name="btnA" value="������¡��" onClick="location.href='assign_list.php?action=assign_key&staffid=<?=$staffid?>&smode=1&profile_id=<?=$profile_id?>'">
        </label></td>
      </tr>
	  <? 
	  $arrkeydata = GetStaffApprove($staffid,$profile_id);
	  	$sql_main = "SELECT * FROM tbl_assign_sub WHERE staffid='$staffid' AND nonactive='0' and profile_id='$profile_id' ORDER BY assign_date DESC";
		$result_main = mysql_db_query($db_name,$sql_main);
		$i=0;
		while($rs_m = mysql_fetch_assoc($result_main)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}

		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$rs_m[ticketid]?></td>
        <td align="center"><?=thai_date($rs_m[assign_date])?></td>
        <td align="center">
		<?			
			echo "<a href='assign_list.php?action=view_person&staffid=$staffid&ticketid=$rs_m[ticketid]&profile_id=$profile_id&mode=all'>".$arrkeydata[$rs_m[ticketid]]['numall']."</a>";
			//echo $rs_c1[num1];
		?>
		</td>
        <td align="center"><? if($arrkeydata[$rs_m[ticketid]]['notapprove'] > 0){ echo "<a href='assign_list.php?action=view_person&staffid=$staffid&ticketid=$rs_m[ticketid]&profile_id=$profile_id&mode=diffkey'>".$arrkeydata[$rs_m[ticketid]]['notapprove']."</a>";}else{ echo "0";} ?></td>
        <td align="center"><? if($rs_m[assign_status] == "Y"){ echo "�ͺ�ҹ����";}else{ echo "���ͺ�ҹ";} ?></td>
        <td align="center"><a href="assign_list.php?action=assign_key&staffid=<?=$rs_m[staffid]?>&TicketId=<?=$rs_m[ticketid]?>&profile_id=<?=$profile_id?>"><img src="images/b_edit.png" width="16" height="16" border="0" alt="��䢢�����"></a> &nbsp;<img src="images/b_drop.png" width="16" height="16" border="0" alt="ź��¡�â�����" onClick="return confirmDelete1('assign_list.php?action=del&staffid=<?=$rs_m[staffid]?>&TicketId=<?=$rs_m[ticketid]?>&profile_id=<?=$profile_id?>')" style="cursor:hand"></td>
      </tr>
   	    <?
		$sum_all += $arrkeydata[$rs_m[ticketid]]['numall'];
		$sum_notapporve += $arrkeydata[$rs_m[ticketid]]['notapprove'];
	  	}// end while
	  ?>
      <tr>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>���</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_all)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_notapporve)?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
      </tr>

    </table></td>
  </tr>
</table>

<?
	}// end 
?>

<? 
	if($action == "assign_key"){
		
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="fillcolor">
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td width="17%"  bgcolor="<? if($smode == ""){ $bgcolor = "BLACK";echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066"; }?>" align=center style="border-right: solid 1 white;"><A HREF="assign_list.php?action=assign_key&smode=&staffid=<?=$staffid?>&TicketId=<?=$TicketId?>&profile_id=<?=$profile_id?>"><strong><U style="color:<?=$bgcolor?>;">���ҧ��¡�����к�</U></strong></A></td>
              <td width="24%"  bgcolor="<? if($smode == "1"){ $bgcolor = "BLACK"; echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066";}?>" align=center style="border-right: solid 1 white;"><A HREF="assign_list.php?action=assign_key&smode=1&staffid=<?=$staffid?>&TicketId=<?=$TicketId?>&profile_id=<?=$profile_id?>"><strong><U style="color:<?=$bgcolor?>;"> ���ҧ㺨��§ҹ��͹��ѧ</U></strong></A></td>
              <td width="28%" bgcolor="<? if($smode == "extraW"){ $bgcolor = "BLACK"; echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066";}?>" align="center" style="border-right:solid 1 white;"><a href="assign_list.php?action=assign_key&smode=extraW&staffid=<?=$staffid?>&TicketId=<?=$TicketId?>&profile_id=<?=$profile_id?>"><strong><U style="color:<?=$bgcolor?>;"> ���ҧ㺧ҹ����ѻ����</U></strong></a></td>
			<!-- <td width="34%"  bgcolor="<? if($smode == "2"){ $bgcolor = "BLACK"; echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066";}?>" align=center style="border-right: solid 1 white;"><A HREF="assign_list.php?action=assign_key&smode=2&staffid=<?=$staffid?>&TicketId=<?=$TicketId?>"><strong><U style="color:<?=$bgcolor?>;"> �к���͹䢢���٧</U></strong></A></td>-->
			 <td width="31%">&nbsp;</td>
            </tr>
      </table>	</td>
  </tr>
  
   <?
 	if($smode == "extraW"){
	$arrestkey = GetNumKeyPerWeek($staffid,$gmonth);
	$point_est_day = GetPointAvgPerDay($staffid);
	$point_week = $point_est_day*$day_per_week;// ��Ҥ�ṹ�»���ҳ��������� 1 �ѻ����
	
	$arr_pa = GetBasePointAndPercenAdd($staffid); // ��������ǹ����
	$percen_assign_add = $arr_pa['percen_add'];
	
	$arr_over = GetDocNokeyAsPoint($staffid,$profile_id); // ��ṹ��ǹ�Թ����ѡ

		
 ?>
   <form name="form_m1" method="post" action="" onSubmit="return checkFm();">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td colspan="2" align="left" bgcolor="#FFFFFF"><strong>������ѹ�֡����ͺ���§ҹ�ͧ
            <?=show_user($staffid)?> 
            <br>
            �ӹǹ��ṹ����·�������������ѹ��ҡѺ <?=$point_est_day?>  ��ṹ �Դ�� 1 �ѻ���� (<?=$DayOfWeek?> �ѹ) ��ҡѺ <?=number_format($point_week)?> ��ṹ
            <?
            	if($arr_over[num] > 0){
						$temp_point1 = $point_week-$arr_over[point];
						$percen_push = abs(($temp_point1*$percen_assign_add)/100); // ��������ǹ����
						$point_net1 = $temp_point1+$percen_push;
						echo "<br><font color=\"#FF0000\">�ըӹǹ�ش����ҧ��������  $arr_over[num] �ش �Դ�繤�ṹ ".number_format($arr_over[point])." <br>
��ṹ������Ѻ�ͺ���§ҹ����ѻ����������Ҥ�ṹ��������ѻ����ź�ӹǹ��ṹ����ҧ���� ��ҡѺ".number_format($temp_point1)." ��ṹ</font>";
echo "<br>�ǡ��������ǹ�����ա ".$percen_assign_add." ������ ��ṹ�ط�Է������Ѻ����ͺ���§ҹ��ҡѺ".
number_format($point_net1)." �»���ҳ";
				}else{
						$percen_push = abs(($point_week*$percen_assign_add)/100); // ��������ǹ����
						$point_net1 = $point_week+$percen_push; // ��ṹ�ط��
						echo "<br>�ǡ��������ǹ�����ա ".$percen_assign_add." ������ ��ṹ�ط�Է������Ѻ����ͺ���§ҹ��ҡѺ".number_format($point_net1)." �»���ҳ";
				}
				
					if($point_net1 < 18){  // �óդ�ṹ�������͹��¡��� 18 ��ṹ
							$dis = " disabled='disabled'";
							$msg3 = "�ըӹǹ��ṹ����ѧ���������ҡ�Թ仨֧�������ö�ͺ���§ҹ��";
					}else{
							$dis = "";	
							$msg3 = "";
					}
			?>
             
			<br>
			
      
        </strong>

</td>
        </tr>
      <tr>
        <td width="25%" align="left" bgcolor="#FFFFFF"><strong>ࢵ��鹷�����֡��</strong></td>
        <td width="75%" align="left" bgcolor="#FFFFFF"><select name="sent_siteid" id="sent_siteid">
          
          <option value=""> - ���͡ࢵ��鹷�����֡�� - </option>
          <? 
			$sql_site = "SELECT
eduarea.secid, eduarea.secname,eduarea_config.pdf_org,
eduarea_config.pdf_sys,
if(substring(eduarea.secid,1,1) ='0',cast(secid as SIGNED),9999) as idsite
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' AND
eduarea_config.profile_id =  '$profile_id' ORDER BY  idsite, eduarea.secname  ASC
";
			$result_site = mysql_db_query($dbnamemaster,$sql_site);
			while($rs_s = mysql_fetch_assoc($result_site)){
				if($rs_s[secid] == $sent_siteid){ $sel = "selected='selected'";}else{ $sel = "";}
				$secname = str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",$rs_s[secname]);
				echo "<option value='$rs_s[secid]' $sel>$secname</option>";
			}// end while($rs_s = mysql_fetch_assoc($result_site)){
			?>
        </select></td>
        </tr>
      <tr>
        <td colspan="2" align="center" bgcolor="#FFFFFF"><span class="style1">�����˵�* �ӹǹ���зӡ���ͺ���§ҹ������繨ӹǹ����ѻ����</span></td>
      </tr>
      <tr>
        <td colspan="2" align="center" bgcolor="#FFFFFF">
        <input type="hidden" name="numkeyperweek" value="<?=$doc_perweek?>">
        <input type="hidden" name="profile_id" value="<?=$profile_id?>">
		<input type="hidden" name="xsearch" value="search_week">
        <? echo $msg3;?>
          <input type="submit" name="Submit3" value="����" <?=$dis?> >
       </td>
        </tr>
    </table></td>
  </tr>
  </form>
 
 <?
	}//end 
 ?>

  
    <? 
  if($smode == "2"){
  
  ?>
  <form name="form_m2" method="post" action="">
  <tr>
    <td align="center" bgcolor="#000000"><!--<table width="100%" border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td colspan="4" align="left" bgcolor="#FFFFFF"><strong>������ѹ�֡����ͺ���§ҹ�ͧ
            <?=show_user($staffid)?>
        </strong></td>
        </tr>
      <tr>
        <td width="20%" align="left" bgcolor="#FFFFFF"><strong>����</strong></td>
        <td width="27%" align="left" bgcolor="#FFFFFF"><strong>
          <label></label>
          <label>
          <input name="sname" type="text" id="sname" size="25" value="<?=$sname?>" <?=$dis?>>
          </label>
        </strong></td>
        <td width="16%" align="left" bgcolor="#FFFFFF"><strong>���ʡ��</strong></td>
        <td width="37%" align="left" bgcolor="#FFFFFF"><strong>
          <label></label>
          <label>
          <input name="ssurname" type="text" id="ssurname" value="<?=$ssurname?>" <?=$dis?>>
          </label>
        </strong></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#FFFFFF"><strong>���ʺѵ�</strong></td>
        <td align="left" bgcolor="#FFFFFF"><strong>
          <label></label>
          <label>
          <input name="sidcard" type="text" id="sidcard" size="25" value="<?=$sidcard?>" <?=$dis?>>
          </label>
        </strong></td>
        <td colspan="2" align="left" bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" align="center" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center" bgcolor="#FFFFFF"><label>
		<input type="hidden" name="xsearch" value="search2">
          <input type="submit" name="Submit3" value="����" <?=$dis?>>
        </label></td>
        </tr>
    </table>--></td>
  </tr>
  </form>
 <? 
	 } // end   if($smode == "2"){  
  if($smode == ""){
  ?>
  <form name="form_m1" method="post" action="" onSubmit="return checkFm();">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td colspan="4" align="left" bgcolor="#FFFFFF"><strong>������ѹ�֡����ͺ���§ҹ�ͧ
            <?=show_user($staffid)?>
        </strong></td>
        </tr>
      <tr>
        <td width="20%" align="left" bgcolor="#FFFFFF"><strong>�����Ҫ���</strong></td>
        <td width="27%" align="left" bgcolor="#FFFFFF"><strong>
          <label>
          <select name="age_g1" id="age_g1" <?=$dis?>>
		  <option value=""> - ����к� - </option>
		  <? 
		  	for($i = 15 ; $i <= 45 ; $i++){
				if($age_g1 == $i){ $sel = "selected='selected'";}else{ $sel = "";}
				echo "<option value='$i' $sel>$i</option>";
			}
		  ?>
          </select>
            </label>
        </strong></td>
        <td width="16%" align="left" bgcolor="#FFFFFF"><strong>�֧</strong></td>
        <td width="37%" align="left" bgcolor="#FFFFFF"><strong>
          <label>
          <select name="age_g2" id="age_g2" <?=$dis?>>
		  <option value=""> - ����к� -</option>
		  <?
		  	for($j = 15 ; $j <= 45 ; $j++){
				if($age_g2 == $j){ $sel = "selected='selected'";}else{ $sel = "";}
				echo "<option value='$j' $sel>$j</option>";
			}
		  
		  ?>
          </select>
            </label>
        </strong></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#FFFFFF"><strong>�ӹǹ��</strong></td>
        <td align="left" bgcolor="#FFFFFF"><strong>
          <label>
          <input name="person_no" type="text" id="person_no" size="15" value="<?=$person_no?>"  onBlur="return check_number(this);" <?=$dis?>>
          </label>
        </strong></td>
        <td align="left" bgcolor="#FFFFFF"><strong>ࢵ��鹷�����֡��</strong></td>
        <td align="left" bgcolor="#FFFFFF">
		
		<select name="sent_siteid" id="sent_siteid" onChange="refreshproductList();">
            <?
		if($dbnamemaster == "cmss_pro_master"){ 
			echo "<option value='1300' selected='selected'>�ѧ��Ѵ�����ҹ�</option>";
		}else{
	?>
            <option value=""> - ���͡ࢵ��鹷�����֡�� - </option>
            <? 
			//if(in_area() != ""){ $in_site = in_area(); }else{ $in_site = "''";} // ����ࢵ 20 ࢵ
			$sql_site = "SELECT
eduarea.secid, eduarea.secname,eduarea_config.pdf_org,
eduarea_config.pdf_sys
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' AND
eduarea_config.profile_id =  '$profile_id' ORDER BY if(substring(eduarea.secid,1,1) ='0',cast(secid as SIGNED),9999) asc,eduarea.secname ASC";
			$result_site = mysql_db_query($dbnamemaster,$sql_site);
			while($rs_s = mysql_fetch_assoc($result_site)){
				if($rs_s[secid] == $sent_siteid){ $sel = "selected='selected'";}else{ $sel = "";}
				$secname = str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",$rs_s[secname]);
				echo "<option value='$rs_s[secid]' $sel>$secname</option>";
			}// end while($rs_s = mysql_fetch_assoc($result_site)){
	}// end if($dbname == "cmss_pro_1300"){ 
			?>
          </select>		</td>
      </tr>
      <tr>
        <td colspan="4" align="center" bgcolor="#FFFFFF"><span class="style1">�����˵�* ��ҷ�ҹ������͡��ǧ�����Ҫ����к��зӡ�ä��Һؤ�ҡ�÷���������Ҫ��õ���� 15 �բ��� </span></td>
      </tr>
      <tr>
        <td colspan="4" align="center" bgcolor="#FFFFFF"><label>
        <input type="hidden" name="profile_id" value="<?=$profile_id?>">
		<input type="hidden" name="xsearch" value="search1">
          <input type="submit" name="Submit3" value="����" <?=$dis?>>
        </label></td>
        </tr>
    </table></td>
  </tr>
  </form>
 <? 
 } // end   if($smode == ""){ 
 if($smode == "1"){
 ?>
  <form name="form1" method="post" action="">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td colspan="4" align="left" bgcolor="#FFFFFF"><strong>������ѹ�֡����ͺ���§ҹ�ͧ
          <?=show_user($staffid)?>
        </strong></td>
      </tr>
      <tr>
        <td colspan="4" align="left" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td width="95%"><strong>����</strong></td>
              <td width="5%" align="center"><!--<img src="images/gear.png" width="24" height="24" border="0" alt="��駤�ҡ�˹�ࢵ������鹡�ä���" onClick="" style="cursor:hand">--></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td width="15%" align="left" bgcolor="#FFFFFF"><strong>ࢵ��鹷�����֡��</strong></td>
        <td width="30%" align="left" bgcolor="#FFFFFF"><label>
          <select name="sent_siteid" id="sent_siteid" onChange="refreshproductList();">
            <?
		if($dbnamemaster == "cmss_pro_master"){ 
			echo "<option value='1300' selected='selected'>�ѧ��Ѵ�����ҹ�</option>";
		}else{
	?>
            <option value=""> - ���͡ࢵ��鹷�����֡�� - </option>
            <? 
			if(in_area() != ""){ $in_site = in_area(); }else{ $in_site = "''";} // ����ࢵ 20 ࢵ
			$sql_site = "SELECT
eduarea.secid, eduarea.secname,eduarea_config.pdf_org,
eduarea_config.pdf_sys
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' AND
eduarea_config.profile_id =  '$profile_id' ORDER BY if(substring(eduarea.secid,1,1) ='0',cast(secid as SIGNED),9999) asc,eduarea.secname ASC";
		/*	$sql_site = "SELECT eduarea.secid, eduarea.secname,eduarea_config.pdf_org,
eduarea_config.pdf_sys FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE eduarea_config.group_type =  'keydata'  order by eduarea.secname ASC";*/
			$result_site = mysql_db_query($dbnamemaster,$sql_site);
			while($rs_s = mysql_fetch_assoc($result_site)){
				if($rs_s[secid] == $sent_siteid){ $sel = "selected='selected'";}else{ $sel = "";}
				$secname = str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",$rs_s[secname]);
				echo "<option value='$rs_s[secid]' $sel>$secname</option>";
			}// end while($rs_s = mysql_fetch_assoc($result_site)){
	}// end if($dbname == "cmss_pro_1300"){ 
			?>
          </select>
        </label></td>
        <td width="13%" align="left" bgcolor="#FFFFFF"><label><strong>����</strong></label></td>
        <td width="42%" align="left" bgcolor="#FFFFFF"><label>
          <input name="key_name" type="text" id="key_name" size="30" value="<?=$key_name?>">
        </label></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#FFFFFF"><strong>˹��§ҹ/�ç���¹</strong></td>
        <td align="left" bgcolor="#FFFFFF"><label>
          <select name="schoolid" id="schoolid">
            <?
			if($dbnamemaster == "cmss_pro_master"){ 
			
				$sql_school = "SELECT * FROM  allschool";
				$result_school = mysql_db_query($dbnamemaster,$sql_school);
				while($rs_s = mysql_fetch_assoc($result_school)){
					if($rs_s[id] == $schoolid){ $sel = "selected";}else{ $sel = "";}
					echo "<option value='$rs_s[id]' $sel>$rs_s[office]</option>";
				}
			}else{
				if($sent_siteid != ""){
					echo "<option value=''>����к�</option>";
					$sql_school = "SELECT id, office FROM allschool WHERE siteid='$sent_siteid' order by  office ASC";
					$result_school = mysql_db_query($dbnamemaster,$sql_school);
					while($rs_sch = mysql_fetch_assoc($result_school)){
							if($rs_sch[id] == $schoolid){ $sel = "selected='selected'";}else{ $sel = "";}
							echo "<option value='$rs_sch[id]' $sel>$rs_sch[office]</option>";
					}
				}//end 	if($sent_siteid != ""){
			}// end 			if($dbnamemaster == "cmss_pro_master"){ 
			?>
          </select>
        </label></td>
        <td align="left" bgcolor="#FFFFFF"><strong>���ʡ��</strong></td>
        <td align="left" bgcolor="#FFFFFF"><input name="key_surname" type="text" id="key_surname" size="30" value="<?=$key_surname?>"></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
        <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
        <td align="left" bgcolor="#FFFFFF"><strong>���ʺѵ�</strong></td>
        <td align="left" bgcolor="#FFFFFF"><input name="key_idcard" type="text" id="key_idcard" size="30" value="<?=$key_idcard?>"></td>
      </tr>
      <tr>
        <td colspan="4" align="left" bgcolor="#FFFFFF"><span class="style1">㹡óշ���ͧ��ä��Ҫ����ҡ����˹�觪������������ &quot;,&quot; �� �����,���Է��,�͡��� �繵� </span></td>
      </tr>
      <tr>
        <td colspan="4" align="center" bgcolor="#FFFFFF">
        <input type="hidden" name="profile_id" value="<?=$profile_id?>">
        <input type="hidden" name="action" value="assign_key">
            <input type="hidden" name="xsearch" value="search">
            <input type="hidden" name="staffid2" value="<?=$staffid?>">
            <input type="hidden" name="TicketId2" value="<?=$TicketId?>">
            <input type="submit" name="Submit" value="����"></td>
      </tr>
    </table></td>
  </tr>
  </form>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td>


<script type="text/javascript" src="../../common/autocomplete/autocomplete.js"></script>
<link href="../../common/autocomplete/autocomplete.css"  rel="stylesheet" type="text/css">
<script src="../../common/script_event.js"></script>
<script type="text/javascript" src="auto/jquery.js"></script>
<script src="auto/script_salary.js"></script> 
<script>

function getposition(val){
var url="getpostion.php?RND="+Math.random()*1000+"&id_pos="+val;
$.get(url,function(data){
  $('#hr_addposition').empty().append(data);	
  getradub(document.post.hr_addposition.value);
  getvitaya(document.post.hr_addposition.value);
});
}
function getposition2(val){
var url="getpostion2.php?RND="+Math.random()*1000+"&id_pos="+val;
$.get(url,function(data){
  $('#divposduty').empty().append(data);	
 
});
}


function make_autocom(autoObj,showObj){
 
    var mkAutoObj=autoObj;    
    var mkSerValObj=showObj;    
    new Autocomplete(mkAutoObj, function() {   
        this.setValue = function(id) {         
            document.getElementById(mkSerValObj).value = id;   
       }   
        if ( this.isModified )   
            this.setValue("");   
        if ( this.value.length < 21 && this.isNotClick )    
            return ;       
        return "gdata.php?q=" + this.value+"&rnd="+Math.random()*1000;   
    });    
} 



document.write('<style type="text/css">.tabber{display:none;}<\/style>');
</script>
<script type="text/javascript" charset="utf-8" src="js/jquery-1.2.3.pack.js"></script>  
<script type="text/javascript">
// initialize the jquery code
 $(document).ready(function(){
//close all the content divs on page load
$('.mover').hide();

// toggle slide
$('#slideToggle').click(function(){
// by calling sibling, we can use same div for all demos
$(this).siblings('.mover').slideToggle();
});

});
</script>
<style type="text/css">

.container .pusher{
	cursor:pointer;
	padding:3px 10px 3px 7px;
	font-weight:900;
	font-size:14px;
	margin:0;
}

.container .mover{
	padding:3px 10px 3px 7px;
	margin: 0;
	border:1px solid #3399CC;
	background-color:#FFFFFF;
}

.container {
  
  padding:3px;
  margin-top:5px;
  width:100%;
  /*font-size:11px;*/
}
</style> 	

	<table width="100%" border="0" cellspacing="0" cellpadding="3">
     
      <tr>
        <td>
<div class="container">
  <div class="pusher" id="slideToggle"><img src="images/document_ac_view.gif" align="absmiddle">&nbsp;<u>���Ҩҡ�ӹѡࢵ��鹷�����֡���Ѹ���֡��</u></div>
  <div style="display: none;" class="mover">
    <form action="?action=<?=$_GET['action']?>&smode=<?=$_GET['smode']?>&staffid=<?=$_GET['staffid']?>&TicketId=<?=$_GET['TicketId']?>&profile_id=<?=$_GET['profile_id']?>" method="post" name="frm_type2">		
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="20%"><div align="right">�����ç���¹</div></td>
    <td width="80%">
	<input name="select_school_label"  type="text" id="select_school_label"  size="50" maxlength="255" value="<?=$select_school_label?>" />
	<script >
        //make_autocom("select_school_label","select_school");  
    </script>
	<input type="hidden" name="select_school" id="select_school"  value="<?=$select_school?>" />
	</td>
  </tr>
  <tr>
    <td><div align="right">����</div></td>
    <td><input name="name_type2" type="text" value="<?=$name_type2?>"></td>
  </tr>
  <tr>
    <td><div align="right">���ʡ��</div></td>
    <td><input name="surname_type2" type="text" value="<?=$surname_type2?>"></td>
  </tr>
 
  <tr>
    <td><div align="right">�Ţ�ѵû�ЪҪ�</div></td>
    <td><input name="idcard_type2" type="text" value="<?=$idcard_type2?>"></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>
	<input type="hidden" name="profile_id" value="<?=$profile_id?>">
    <input type="hidden" name="action" value="assign_key">
    <input type="hidden" name="xsearch" value="search3">
    <input type="hidden" name="staffid2" value="<?=$staffid?>">
    <input type="hidden" name="TicketId2" value="<?=$TicketId?>">
	<input name="bt_search" type="submit" value=" ���� "></td>
  </tr>
</table>
</form>	
 </div>
</div>	
		
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
<? } //end if($smode == "1"){?>	  
    </table>
	
	</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <?
 #########   ###########################  ����Ẻ�����´ ################
  	if($xsearch == "search"){
	if($sent_siteid == ""){ // �ó������ sent_siteid
		echo " �Ҵ��õԴ��͡Ѻ server ";die;
	}
	//if($sent_siteid != ""){ $sent_siteid = $sent_siteid;}else{ echo "";}
	//echo $sent_siteid."<br>";
	//con_db($sent_siteid);
	$db_site = "$s_db".$sent_siteid;
	//echo $db_site."<br>";
	## �óդ��Ҫ���
	if($key_name != ""){ 
		$xpos = strpos($key_name,",");
		if(!($xpos === false)){ // �óշ���ա�ä��Ҫ������¤�
			$arr_t = explode(",",$key_name);
			foreach($arr_t as $k => $v){
				if($name_search > "") $name_search .= ",";
					$name_search .= "'".trim($v)."'";
			}// end  foreach($arr_t as $k => $v){
			$conW = " AND t1.name_th IN($name_search) ";
		}else{
			$conW = " AND t1.name_th LIKE '%$key_name%' ";
		} // end if(!($xpos === false)){
	}// end if($name != ""){ 
## end �óդ��Ҫ���
## �óդ��ҹ��ʡ��
if($key_surname != ""){
	$xpos1 = strpos($key_surname,",");
		if(!($xpos1 === false)){
			$arr_t1 = explode(",",$key_surname);
				foreach($arr_t1 as $k1 => $v1){
					if($surname_search > "") $surname_search .= ",";
						$surname_search .= "'".trim($v1)."'";
				}// end foreach
			$conW1 = " AND t1.surname_th IN($surname_search) ";
		}else{
			$conW1 = " AND t1.surname_th LIKE '%$key_surname%' ";
		}
}// end if($surname != ""){
## end �óդ��ҹ��ʡ��
##  �óդ������ʺѵ�
if($key_idcard != ""){
	$xpos2 = strpos($key_idcard,",");
	if(!($xpos2 === false)){
		$arr_t2 = explode(",",$key_idcard);
			foreach($arr_t2 as $k2 => $v3){
				if($idcard_search > "") $idcard_search .= ",";
					$idcard_search .= "'".trim($v3)."'";
			}
			$conW2 = " AND t2.idcard IN($idcard_search)";
	}else{
			$conW2 = " AND t2.idcard LIKE '%$key_idcard%'";
	}
}
##  end �óդ������ʺѵ�
if($schoolid > 0){
	$w_school = " AND t1.schoolid='$schoolid' ";
}
$year1 = (date("Y")+543)."-09-30";

	$sql = "SELECT t2.siteid,t1.CZ_ID as idcard,t1.prename_th,t1.name_th,t1.surname_th,t1.schoolid,t1.schoolname,t1.birthday,t1.begindate,t1.position_now , (TIMESTAMPDIFF(MONTH,t1.begindate,'$year1')/12) as age_gov FROM  $dbnamemaster.view_general as t1 Inner join $dbname_temp.tbl_checklist_kp7 as t2 On t1.CZ_ID=t2.idcard WHERE  t2.siteid='$sent_siteid' AND t2.profile_id='$profile_id' $conW  $conW1 $conW2 $w_school";
//	echo "$db_site :: $sql ";
	//echo $db_site;
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$ch_num = mysql_num_rows($result);
}// end if($xsearch == "search"){

### �óդ���Ẻ����٧
if($xsearch == "search2"){
	//con_db("5001");
	if($sname != ""){ $conx .= " AND t1.name_th LIKE '%$sname%' ";}
	if($ssurname != ""){ $conx .= " AND t1.surname_th LIKE '%$ssurname%' ";}
	if($sidcard != ""){ $conx .= " AND t1.CZ_ID LIKE '%$sidcard%'";}
	if(in_area() != ""){ $in_site = in_area(); }else{ $in_site = "''";} // ����ࢵ 20 ࢵ
	$sql = "	SELECT t2.siteid,t1.CZ_ID as idcard,t1.prename_th,t1.name_th,t1.surname_th,t1.schoolid,t1.schoolname,t1.birthday,t1.begindate,t1.position_now, (TIMESTAMPDIFF(MONTH,t1.begindate,'$year1')/12) as age_gov FROM $dbnamemaster.view_general as t1 Inner join $dbname_temp.tbl_checklist_kp7 as t2 On t1.CZ_ID=t2.idcard   WHERE t2.siteid  IN($in_site)  $conx ";
	//echo $sql."<br> $dbnamemaster";
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$ch_num = mysql_num_rows($result);
	//echo $ch_num;
}// end if($xsearch == "search2"){

################################  ����Ẻ�ҵðҹ
if($xsearch == "search1"){
	if($sent_siteid != ""){ 
		$in_site = "'$sent_siteid'";
	}else{
		if(in_area() != ""){ $in_site = in_area(); }else{ $in_site = "''";} // ����ࢵ 20 ࢵ
	}//end 	if($sent_siteid != ""){ 
	if($age_g1 != "" and $age_g2 == ""){ $conW = " AND (TIMESTAMPDIFF(MONTH,t1.begindate,'$year1')/12) = '$age_g1'";} // �ó����͡��������
	if($age_g1 != "" and $age_g2 != ""){ $conW = "AND ((TIMESTAMPDIFF(MONTH,t1.begindate,'$year1')/12) >= '$age_g1' AND (TIMESTAMPDIFF(MONTH,t1.begindate,'$year1')/12) <= '$age_g2' )";} 
	if($age_g1 == "" and $age_g2 == ""){ $conW = " AND (TIMESTAMPDIFF(MONTH,t1.begindate,'$year1')/12) >= '15'";}
	$sql = "SELECT  t2.siteid,t1.CZ_ID as idcard,t1.prename_th,t1.name_th,t1.surname_th,t1.schoolid,t1.schoolname,t1.birthday,t1.begindate,t1.position_now, (TIMESTAMPDIFF(MONTH,t1.begindate,'$year1')/12) as age_gov FROM $dbnamemaster.view_general  as t1 Inner Join $dbname_temp.tbl_checklist_kp7 as t2 On t1.CZ_ID=t2.idcard WHERE t2.siteid IN($in_site)  $conW  ORDER BY t2.siteid ASC";
	//echo $sql;
	$result = mysql_db_query($dbnamemaster,$sql);
	$xi = 0;
	while($rs = mysql_fetch_assoc($result)){
	
		if(CheckFileKp7($rs[CZ_ID],$rs[siteid]) == 1){ // ��������㹵���� array ੾�к�ؤ�ҡ÷���� �.�. 7 �鹩�Ѻ��ҹ��
			if(person_not_assign($rs[CZ_ID],$rs[siteid],"$TicketId") == 0){
			
			####  �礡ó��բ����� � view_general � master �������� site
			$check_db_site = STR_PREFIX_DB.$rs[siteid]; // dbsite
/*			$sql_count_site = "SELECT COUNT(id) AS numc FROM general WHERE id='$rs[CZ_ID]' GROUP BY id";
			$result_count_site = mysql_db_query($check_db_site,$sql_count_site);
			$rs_count = mysql_fetch_assoc($result_count_site);
					if($rs_count[numc] > 0){ // �ó��բ������ site ��ҹ��*/
						$xi++;
						$arr_idcard[$rs[CZ_ID]] = $rs[CZ_ID];
						$arr_name[$rs[CZ_ID]] = "$rs[prename_th]$rs[name_th]  $rs[surname_th]";
						$arr_school[$rs[CZ_ID]] = show_org($rs[schoolid])."/".show_area($rs[siteid]);
						$arr_siteid[$rs[CZ_ID]] = $rs[siteid];
						$arr_position[$rs[CZ_ID]] = $rs[position_now];
						$arr_age[$rs[CZ_ID]] = $rs[age_gov];
				#	}// end 	if($rs_count[numc] > 0){
			}// end if(person_not_assign($rs[idcard],$sent_siteid,"$TicketId") == 0){			
		}// end if(check_kp7file($rs[idcard],$rs[siteid]) == 1){
		
		if($xi >= $num_docfix){ break;}
		//if($xi >= $person_no){ break;} //㹡óշ����Ҥú����ӹǹ����˹�����͡�ҡ loop
		
	}// end while($rs = mysql_fetch_assoc($result)){
	
	//$person_no;
	
	
}// end  if($xsearch == "search1"){


###  ��ǹ�ͧ����ʴ��šóդ���Ẻ����
if($xsearch == "search" or $xsearch == "search2" or $show_by_school != "" or $show_by_person != ""){
	
	//echo "XXXXXXXXXXXXX";
  ?>
 <form name="form2" method="post" action="">
  <tr>
    <td align="center" bgcolor="#000000">
      <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr>
          <td colspan="8" align="center" bgcolor="#A3B2CC">
		   <?php
		   #echo $sql;
		   if($show_by_school != ""){
		     $db_new_site = STR_PREFIX_DB.$_GET['new_site'];
		     $sql = "SELECT * , (TIMESTAMPDIFF(MONTH,begindate,'$year1')/12) as age_gov FROM general WHERE schoolid = '".$show_by_school."' ";
			 $result = mysql_db_query($db_new_site,$sql)or die(mysql_error());
			 $ch_num = mysql_num_rows($result);
		   }
		   if($show_by_person != ""){
		     $idcard_field = "CZ_ID";
			 if(count($_POST['arr_idcard']) > 0){
		      $str_idcard = implode(",",$_POST['arr_idcard']);
		      $sql = "SELECT * , (TIMESTAMPDIFF(MONTH,begindate,'$year1')/12) as age_gov FROM view_general WHERE CZ_ID IN($str_idcard) ";
			 }else{
			  $_POST['arr_idcard'][] = $idcard_show;
			  $sql = "SELECT * , (TIMESTAMPDIFF(MONTH,begindate,'$year1')/12) as age_gov FROM view_general WHERE CZ_ID = '$idcard_show' ";
			 } 
			  $result = mysql_db_query($dbnamemaster,$sql)or die(mysql_error());
			  $ch_num = mysql_num_rows($result);
			 
             #echo $sql;
			 
		   }else{
		    $idcard_field = "idcard";
		   }
		   ?>
		  <table width="100%" border="0" cellspacing="0" cellpadding="3">
		  <?    $sql_ticket = "select * from tbl_assign_sub where ticketid='$TicketId' AND nonactive='0' AND profile_id='$profile_id'";
		  		$result_ticket = @mysql_db_query($db_name,$sql_ticket)or die(mysql_error());
				$num_t = @mysql_num_rows($result_ticket);
				$rs_t = @mysql_fetch_assoc($result_ticket);
				
				if($rs_t[assign_date]  != "0000-00-00" and $TicketId != ""){
					$cdate  = $rs_t[assign_date];
				
				}else{
					$cdate = date("Y-m-d");
				}
				
				#### ������͡ʶҹз����������
				if($num_t > 0){
					if($rs_t[localtion_key] == "IN"){ $select_in = "checked='checked'"; }else{ $select_in = "";}
					if($rs_t[localtion_key] == "OUT"){ $select_out = "checked='checked'"; }else{ $select_out = "";}
						
				}else{
					$select_in = "checked='checked'";	
					$select_out = "";
				}//end if($num_t > 0){

		  ?>
            <tr>
              <td width="18%" align="left"><strong>ʶҹ�����������</strong></td>
              <td width="82%" align="left"><!--<label><input name="localtion_key" type="radio" value="IN" <?//=$select_in?> >
              �ѹ�֡�����Ţ�ҧ㹺���ѷ
                <input name="localtion_key" type="radio" value="OUT" <?//=$select_out?>>
                ��������Ţ�ҧ�͡����ѷ
                </label>--><strong>
                  <?=$sitekey?>
              </strong></td>
            </tr>
            <tr>
              <td align="left"><strong>�ѹ������ҧ</strong></td>
              <td align="left"><INPUT name="c_date" onFocus="blur();" value="<?=sw_date_intxtbox($cdate)?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form2.c_date, 'dd/mm/yyyy')"value="�ѹ��͹��"></td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td width="7%" align="center" bgcolor="#A3B2CC"><strong>���͡��¡��</strong></td>
          <td width="13%" align="center" bgcolor="#A3B2CC"><strong>���ʻ�Шӵ�ǻ�ЪҪ�</strong></td>
          <td width="14%" align="center" bgcolor="#A3B2CC"><strong>���� - ���ʡ�� </strong></td>
          <td width="19%" align="center" bgcolor="#A3B2CC"><strong>�ç���¹/˹��§ҹ</strong></td>
          <td width="22%" align="center" bgcolor="#A3B2CC"><strong>���˹�</strong></td>
          <td width="9%" align="center" bgcolor="#A3B2CC"><strong>�����Ҫ���</strong></td>
          <td width="10%" align="center" bgcolor="#A3B2CC"><strong>�ӹǹ�ٻ/�ӹǹ��</strong></td>
          <td width="6%" align="center" bgcolor="#A3B2CC"><strong>PDF</strong></td>
          </tr>
		 <?
		 if($ch_num < 1){
		 	echo "<tr bgcolor='#FFFFFF'><td colspan='7' align='center'>  -��辺��¡�÷����� ��سҵ�Ǩ�ͺ���͹䢡�ä��ա���� - </td></tr>";
		 }else{
		 $j=0;
		#echo $sql;
		 while($rs = mysql_fetch_assoc($result)){
			// echo "<pre>";
			 //print_r($rs);
		// echo "$rs[CZ_ID]";
		    //echo $rs['name_th'];
			#echo "<br>".$rs[$idcard_field]."/".$rs['siteid']."/".$TicketId;
			
			 if(CheckKp7FileUpdate($rs[$idcard_field],$profile_id) == 1){
				$icon_file = "<font color=\"#006600\"><b>*</b></font>";		 
			}else{
				$icon_file = "";			
			}
			
			
			
			if($sent_siteid = ""){
			  $sent_siteid = $rs['siteid'];
			}
			#echo "==".person_not_assign($rs[$idcard_field],$sent_siteid,"$TicketId"); 
			if(person_not_assign($rs[$idcard_field],$sent_siteid,"$TicketId") == 0){ // �ʴ�੾�кؤ�ҡ÷���ѧ���١���͡��ҹ���
			
			
			// echo "<pre>";
			// print_r($rs);
		
			 if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			// echo "xxx= ".person_select_assign($rs[idcard],$sent_siteid);
			###  ��ǹ�ͧ��õ�Ǩ�ͺ�����š�͹����ͺ���§ҹ�����§ҹ����Ǩ�ͺ
			
			 $arrx = CheckProtectionAssign($rs[$idcard_field],$rs[siteid],$profile_id);

			
			#echo $rs[idcard]."  ".$rs[siteid]."  ".$profile_id;
			//echo "<pre>";
			//print_r($arrx);
			if($arrx[0] > 0){
				$dis = "disabled='disabled'";
				$msg = "<font color='red'>".$arrx[1]."</font>";
				$file_status = $arrx[2];  // ʶҹТͧ��õ�Ǩ�ͺ�͡���
			}else{
				$dis = "";	
				$msg = "";
				$file_status = 1;
				
			}//end if($arrx[0] > 0) 
			####  end ��ǹ�ͧ��õ�Ǩ�ͺ�����š�͹����ͺ���§ҹ�����§ҹ����Ǩ�ͺ
			
			
//			$arrpage = CheckNumKp7File($rs[$idcard_field],$profile_id);
//			if($arrpage['nump'] == "0"){
//				$msg .= $arrpage['msg_err'];
//				$dis = "disabled='disabled'";
//			}

			
			#############   ��ʶҹ������ �������ó�
			### �ó��繢�������Ңͧ�շ���������͹حҵ� assign ��� sub
			if(CheckTypeUser($staffid) > 0 and CheckOldData($rs[$idcard_field]) > 0){
				if($dis == ""){
						$dis = "disabled='disabled'";
						$msg = "<font color='red'>���͹حҵ assign ��������Ҩҡ�ç��ûշ����������Ѻ sub ��</font>";
				}	
			}else{
				$dis = $dis;
				$msg = $msg;
			}
			
		
/*			$check_pic = CheckPicChecklistToCmss($profile_id,$rs[idcard],$rs[siteid]);
				if( $check_pic == 0){ // �ó�������ٻ��к� cmss
					$dis = "disabled='disabled'";
					$msg = "<font color='red'>���͹حҵ assign ���ͧ�ҡ�ѧ������ٻ�Ҿ��к�cmss ��سҵԴ��ͷ�� upload �ٻ</font>";
				}else{
					$dis = $dis;
					$msg = $msg;
				}
*/			
			//$dis = "";
			
			
		####  �Ѻ�ӹǹ�ٻ�ӹǹ��
		$arrpicpage = GetNumPicPage($rs[$idcard_field],$profile_id);
		$picpage = $arrpicpage['pic']."/".$arrpicpage['page'];
		 ?>
        <tr bgcolor="<?=$bg?>">
          <td align="center">
		  <?php
		  if($show_by_person != ""){
		   if(in_array($rs[$idcard_field],$_POST['arr_idcard']) and $msg == ""){
		     $ch = "checked='checked'";
		   }else{
		     $ch = "";
		   }
		  }
		  ?>
		  <? echo "$j"; echo "$msg";?>
            <input type="checkbox" name="xidcard[<?=$rs[$idcard_field]?>]" value="<?=$rs[$idcard_field]?>" <? if(person_select_assign($rs[$idcard_field],$sent_siteid,"$TicketId") > 0){ echo "checked='checked'";}?> <?=$dis?> <?=$ch?>>
            <input type="hidden" name="xsiteid[<?=$rs[$idcard_field]?>]" value="<?=$rs[siteid]?>">
            <input type="hidden" name="xstatus_file[<?=$rs[$idcard_field]?>]" value="<?=$file_status?>">            </td>
          <td align="center"><?=$rs[$idcard_field]?></td>
          <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?> <input type="hidden" name="fullname[<?=$rs[$idcard_field]?>]" value="<? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?> "></td>
          <td align="left">
		  <?php
		  
		   echo show_org($rs[schoolid])."/".show_area($rs[siteid]);

		   ?></td>
          <td align="left"><? echo "$rs[position_now]";?></td>
          <td align="center"><? echo floor($rs[age_gov]);?></td>
          <td align="center"><?=$picpage?></td>
          <td align="center"><? 
		  
		 
		  if(CheckFileKp7($rs[$idcard_field],$rs[siteid]) == 1){?><a href="../../../edubkk_kp7file/<? echo "$rs[siteid]/$rs[$idcard_field]".".pdf";?>" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�ʴ��͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a>
		  <? 
		  }else{
			  	echo $arrx[3];
			}
			echo "&nbsp;$icon_file";
		  ?></td>
          </tr>
		  <? 
		  $dis = "";
		  $msg = "";
		  } // //echo " <input type=\"checkbox\" name=\"select_idcard\"  disabled=\"disabled\"><br><font color='red'>! Assign</font>";
		  }//end while(){
		}// end  if($ch_num < 1){ 
		
//		if($TicketId != ""){
//		
//			$sql_edit = "SELECT * FROM tbl_assign_key WHERE ticketid='$TicketId'";
//			//echo $sql_edit;
//			$result_edit = mysql_db_query($db_name,$sql_edit);
//			while($rs_e = mysql_fetch_assoc($result_edit)){
//				echo "<input type=\"hidden\" name=\"xidcard1[$rs_e[idcard]]\" value=\"$rs_e[idcard]\">";
//				echo "<input type=\"hidden\" name=\"fullname1[$rs_e[idcard]]\" value=\"$rs_e[fullname]\">";
//				echo "<input type=\"hidden\" name=\"xsiteid1[$rs_e[idcard]]\" value=\"$rs_e[siteid]\">";
//			}
//			
//		}
		
		
		?>
        <tr>
          <td colspan="8" align="center" bgcolor="#FFFFFF"><label>
		  <input type="hidden" name="Aaction" value="SAVE">
          <input type="hidden" name="profile_id" value="<?=$profile_id?>">
		   <input type="hidden" name="staffid" value="<?=$staffid?>">
		   <input type="hidden" name="TicketId" value="<?=$TicketId?>">
		    <? if($j < 1){ $dis_s = " disabled=disabled' ";}?>
            <input type="submit" name="Submit2" value="�ѹ�֡" <?=$dis_s?>>
			<input type="button" name="btnB" value="��͹��Ѻ" onClick="location.href='assign_list.php?action=assign_key&xsearch=&staffid=<?=$staffid?>'">
          </label></td>
          </tr>
      </table>    </td>
  </tr>
  </form>
  <? } // end if($xsearch == "search"){ end ��ǹ�ͧ����ʴ���Ẻ��ä���Ẻ�����´
  	if($xsearch == "search1"){
  	
  ?>
    <form name="form5" method="post" action="">
  <tr><td align="center" bgcolor="#000000">
  <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr>
          <td colspan="8" align="center" bgcolor="#A3B2CC"><table width="100%" border="0" cellspacing="0" cellpadding="3">
		  <? $sql_ticket = "select * from tbl_assign_sub where ticketid='$TicketId' AND nonactive='0'";
		  
		  		$result_ticket = @mysql_db_query($db_name,$sql_ticket);
				$num_t = @mysql_num_rows($result_ticket);
				$rs_t = @mysql_fetch_assoc($result_ticket);
				
				if($rs_t[assign_date]  != "0000-00-00" and $TicketId != ""){
					$cdate  = $rs_t[assign_date];
				
				}else{
					$cdate = date("Y-m-d");
				}
				
				if($num_t > 0){
					if($rs_t[localtion_key] == "IN"){ $select_in = "checked='checked'"; }else{ $select_in = "";}
					if($rs_t[localtion_key] == "OUT"){ $select_out = "checked='checked'"; }else{ $select_out = "";}
						
				}else{
					$select_in = "checked='checked'";	
					$select_out = "";
				}//end if($num_t > 0){

		  ?>
            <tr>
              <td width="18%" align="left"><strong>ʶҹ�����������</strong></td>
              <td width="82%" align="left"><label><input name="localtion_key" type="radio" value="IN" <?=$select_in?> >
              �ѹ�֡�����Ţ�ҧ㹺���ѷ
                <input name="localtion_key" type="radio" value="OUT" <?=$select_out?>>
                ��������Ţ�ҧ�͡����ѷ
                </label></td>
            </tr>
				<? if($cdate != ""){ $temp_date = sw_date_intxtbox($cdate); }else{ $temp_date = date("d/m/Y");}?>
            <tr>
              <td align="left"><strong>&nbsp;��ͧ����ҹ���
                  <?=$sitekey?>
              </strong></td>
              <td align="left"><INPUT name="c_date" onFocus="blur();" value="<?=$temp_date?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form5.c_date, 'dd/mm/yyyy')"value="�ѹ��͹��">			</td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td width="7%" align="center" bgcolor="#A3B2CC"><strong>���͡��¡��</strong></td>
          <td width="13%" align="center" bgcolor="#A3B2CC"><strong>���ʻ�Шӵ�ǻ�ЪҪ�</strong></td>
          <td width="14%" align="center" bgcolor="#A3B2CC"><strong>���� - ���ʡ�� </strong></td>
          <td width="19%" align="center" bgcolor="#A3B2CC"><strong>�ç���¹/˹��§ҹ</strong></td>
          <td width="19%" align="center" bgcolor="#A3B2CC"><strong>���˹�</strong></td>
          <td width="10%" align="center" bgcolor="#A3B2CC"><strong>�����Ҫ���</strong></td>
          <td width="11%" align="center" bgcolor="#A3B2CC"><strong>�ӹǹ�ٻ/�ӹǹ��</strong></td>
          <td width="7%" align="center" bgcolor="#A3B2CC"><strong>PDF</strong></td>
          </tr>
		 <?
		 if(count($arr_idcard) < 1){ // �ó�������¡��
		 	echo "<tr bgcolor='#FFFFFF'><td colspan='7' align='center'>  -��辺��¡�÷����� ��سҵ�Ǩ�ͺ���͹䢡�ä��ա���� - </td></tr>";
		 }else{
		 $j=0;		
		// echo "<pre>";
///print_r($arr_siteid);
		 
		foreach($arr_idcard as $k1 => $v1){
		 
			if(person_not_assign($v1,$arr_siteid[$k1],"$TicketId") == 0){ // �ʴ�੾�кؤ�ҡ÷���ѧ���١���͡��ҹ���
			 if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			 $arrx = CheckProtectionAssign($arr_idcard[$k1],$arr_siteid[$k1],$profile_id);
			// echo "<pre>";
			 //print_r($arrx);
			 if($arrx[0] > 0){
			    
				$dis = "disabled='disabled'";
				$msg = "<font color='red'>".$arrx[1]."</font>";
				$file_status = $arrx[2];  // ʶҹТͧ��õ�Ǩ�ͺ�͡���
			}else{
				$dis = "";	
				$msg = "";
				$file_status = 1;
			}//end if($arrx[0] > 0){ 
			####  end ��ǹ�ͧ��õ�Ǩ�ͺ�����š�͹����ͺ���§ҹ�����§ҹ����Ǩ�ͺ

//			$arrpage = CheckNumKp7File($arr_idcard[$k1],$profile_id);
//			if($arrpage['nump'] == "0"){
//				$msg .= $arrpage['msg_err'];
//				$dis = "disabled='disabled'";
//			}

			 

				 
			if(CheckTypeUser($staffid) > 0 and CheckOldData($rs[idcard]) > 0){

						$dis = "disabled='disabled'";
						$msg = "<font color='red'>���͹حҵ assign ��������Ҩҡ�ç��ûշ����������Ѻ sub ��</font>";
	
			}else{
				$dis = $dis;
				$msg = $msg;
			}
			
			
		  $filekp7 = "../../../edubkk_kp7file/$arr_siteid[$k1]/$arr_idcard[$k1].pdf";
		 if(is_file($filekp7)){
				 $link_kp7 = "<a href=\"../../../edubkk_kp7file/$arr_siteid[$k1]/$arr_idcard[$k1].pdf\" target=\"_blank\"><img src=\"../../images_sys/gnome-mime-application-pdf.png\" alt=\"�͡��� �.�.7 �鹩�Ѻ\" width=\"20\" height=\"20\" border=\"0\"></a>";
		}else{
				$link_kp7 = $arrx[3];	
		}
//	$dis = "";
		####  �Ѻ�ӹǹ�ٻ�ӹǹ��
		$arrpicpage = GetNumPicPage($arr_idcard[$k1],$profile_id);
		$picpage = $arrpicpage['pic']."/".$arrpicpage['page'];
		
		
		 if(CheckKp7FileUpdate($v1,$profile_id) == 1){
				$icon_file = "<font color=\"#006600\"><b>*</b></font>";		 
			}else{
				$icon_file = "";			
			}
			

		 ?>
        <tr bgcolor="<?=$bg?>">
          <td align="center"><?=$j?><?=$msg?><input type="checkbox" name="xidcard[<?=$v1?>]" value="<?=$v1?>" checked="checked" <?=$dis?>> 
            <input type="hidden" name="xsiteid[<?=$v1?>]" value="<?=$arr_siteid[$k1]?>">
             <input type="hidden" name="xstatus_file[<?=$v1?>]" value="<?=$file_status?>">            </td>
          <td align="center"><?=$v1?></td>
          <td align="left"><? echo "$arr_name[$k1]";?> <input type="hidden" name="fullname[<?=$v1?>]" value="<? echo "$arr_name[$k1]";?> "></td>
          <td align="left"><? echo "$arr_school[$k1]";?></td>
          <td align="left"><? echo "$arr_position[$k1]";?></td>
          <td align="center"><? echo floor($arr_age[$k1]);?></td>
          <td align="center"><?=$picpage?></td>
          <td align="center"><?=$link_kp7?><? echo "&nbsp;{$icon_file}";?></td>
        </tr>
		  <? 
		  	$dis = "";
		  	$msg = "";

			  } // //echo " <input type=\"checkbox\" name=\"select_idcard\"  disabled=\"disabled\"><br><font color='red'>! Assign</font>";
		  }//end while(){
		}// end  if($ch_num < 1){ 
		
//		if($TicketId != ""){
//		
//			$sql_edit = "SELECT * FROM tbl_assign_key WHERE ticketid='$TicketId'";
//			//echo $sql_edit;
//			$result_edit = mysql_db_query($db_name,$sql_edit);
//			while($rs_e = mysql_fetch_assoc($result_edit)){
//				echo "<input type=\"hidden\" name=\"xidcard1[$rs_e[idcard]]\" value=\"$rs_e[idcard]\">";
//				echo "<input type=\"hidden\" name=\"fullname1[$rs_e[idcard]]\" value=\"$rs_e[fullname]\">";
//				echo "<input type=\"hidden\" name=\"xsiteid1[$rs_e[idcard]]\" value=\"$rs_e[siteid]\">";
//			}
//			
//		}
//		
		
		?>
        <tr>
          <td colspan="8" align="center" bgcolor="#FFFFFF"><label>
          <input type="hidden" name="profile_id" value="<?=$profile_id?>">
		  <input type="hidden" name="Aaction" value="SAVE">
		   <input type="hidden" name="staffid" value="<?=$staffid?>">
		   <input type="hidden" name="TicketId" value="<?=$TicketId?>">
		    <? if($j < 1){ $dis_s = " disabled=disabled' ";}?>
            <input type="submit" name="Submit2" value="�ѹ�֡" <?=$dis_s?>>
			<input type="button" name="btnB" value="��͹��Ѻ" onClick="location.href='assign_list.php?action=assign_key&xsearch=&staffid=<?=$staffid?>'">
          </label></td>
          </tr>
      </table>
  
  </td></tr>
  </form>
  <? } // end if($xsearch == "search1"){
	if($xsearch == "search_week"){  
	
		
		if($sent_siteid == ""){
			$arrsite = GetSite();
			$sent_siteid = $arrsite[0];
		}//end if($sent_siteid == ""){
			
			
			//ProcessGroupAge($sent_siteid,$profile_id);die;
			//SaveTempAssign($profile_id,$sent_siteid);die;
			
		if(CheckFlagProcessGroupAge($sent_siteid,$profile_id)	 == 0){
			//echo "xxxx";die;
			SaveTempAssign($profile_id,$sent_siteid);
			ProcessGroupAge($sent_siteid,$profile_id);
		}//end if(CheckFlagProcessGroupAge($sent_siteid,$profile_id)	 == 0){
		//echo "sadddddd";die;	
		$arr_tempid = RandomDocumentAssign("$staffid","$sent_siteid","$profile_id");
		
		//echo "�ӹǹ�ش :: <pre>";
		//print_r($arr_tempid);die;

		$numarr1 = count($arr_tempid); // �ӹǹ �����ŷ��ӡ�ô֧�͡���ͺ���§ҹ
		$num_docest = $numkeyperweek/2; // �Ҩӹǹ�ش��� 2 ��Ǩ�ͺ����Ҩӹǹ�ش�������¡��Ҥ���˹�觢ͧ�ش�»���ҳ�������
		if($numarr1 < $num_docest){
			$arrsite1 = GetSite();
			if(CheckFlagProcessGroupAge($arrsite1[1],$profile_id)	 == 0){
				SaveTempAssign($profile_id,$arrsite1[1]);
				ProcessGroupAge($arrsite1[1],$profile_id);
			}//end if(CheckFlagProcessGroupAge($sent_siteid,$profile_id)	 == 0){

			$arr_tempid1 = RandomDocumentAssign("$staffid","$arrsite1[1]","$profile_id");	
		}
		if(count($arr_tempid1) > 0){
			$arr_tempid = array_merge($arr_tempid,$arr_tempid1);	
		}//end if(count($arr_tempid1) > 0){
		
		
		
		if(count($arr_tempid) > 0){
			$i=0;
			foreach($arr_tempid as $key => $val){
				$sql2 = "SELECT
t1.CZ_ID AS idcard,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.schoolid,
t1.position_now,
t3.temp_age_gov as age_gov
FROM  ".DB_MASTER.".view_general as t1 INNER JOIN 	 ".DB_CHECKLIST.".tbl_checklist_kp7 as t2 ON t1.CZ_ID=t2.idcard
INNER JOIN ".DB_USERENTRY.".tbl_constan_assign_detail as t3 ON t2.idcard=t3.idcard
WHERE t1.CZ_ID='$val' and t3.flag_assign='0'  ORDER BY t1.schoolid ASC";
$result2 = mysql_db_query($db_name,$sql2);
$rs2 = mysql_fetch_assoc($result2);
				$filekp7 = "../../../edubkk_kp7file/$rs2[siteid]/$rs2[idcard].pdf";
				 if(is_file($filekp7)){
						 $link_kp7 = "<a href=\"../../../edubkk_kp7file/$rs2[siteid]/$rs2[idcard].pdf\" target=\"_blank\"><img src=\"../../images_sys/gnome-mime-application-pdf.png\" alt=\"�͡��� �.�.7 �鹩�Ѻ\" width=\"20\" height=\"20\" border=\"0\"></a>";
				}else{
						$link_kp7 = "";	
				}//end  if(is_file($filekp7)){


				$i++;
				$arrpicpage = GetNumPicPage($rs2[idcard],$profile_id);
				$picpage = $arrpicpage['pic']."/".$arrpicpage['page'];
				$arr_idcard[$rs2[idcard]] = $rs2[idcard];
				$arr_siteid[$rs2[idcard]] = $rs2[siteid];
				$arr_schoolid[$rs2[idcard]] = $rs2[schoolid];
				$arr_fullname[$rs2[idcard]] = "$rs2[prename_th]$rs2[name_th]  $rs2[surname_th]";
				$arr_prename_th[$rs2[idcard]] = "$rs2[prename_th]";
				$arr_name_th[$rs2[idcard]] = "$rs2[name_th]";
				$arr_surname_th[$rs2[idcard]] = "$rs2[surname_th]";
				$arr_position[$rs2[idcard]] = $rs2[position_now];	
				$arr_pagepic[$rs2[idcard]] = $picpage;
				$arr_kp7[$rs2[idcard]] = $link_kp7;
				$arr_age[$rs2[idcard]] = $rs2[age_gov];

				if($numkeyperweek == $i){ break;}
					
			}// end foreach($arr_tempid as $key => $val){
		}// end if(count($arr_tempid) > 0){
		
		
		
		//$point_avg = GetPointAvgPerDay($staffid); // ��ṹ����¡�ä�����ͧ��ѡ�ҹ���������������ѹ��͹��ѧ 30 �ѹ
		//$arrp =  CheckSubGroupAge($sent_siteid,$profile_id); // �����Ҫ�����������С���������駨ӹǹ����ؤ�ҡ÷���ͧ�ͺ���§ҹ���С����
		//$arr_sub_group =  GetShareNumGroup($sent_siteid,$profile_id);
		##### ��ṹ����������ͧ��ѡ�ҹ����鹷��Ф������¤ӹǹ�ҡ��������¤ٳ���¨ӹǹ�ش������������С����
		//$point_staffall = GetPointStaffAll($sent_siteid,$profile_id);
		//$point_sub_doc = ceil($point_staffall/$point_avg);// �ӹǹ�ѹ���Ҵ��Ҩӷӡ�ä������������


	?>
  
      <form name="form5" method="post" action="">
  <tr><td align="center" bgcolor="#000000">
  <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr>
          <td colspan="9" align="center" bgcolor="#A3B2CC"><table width="100%" border="0" cellspacing="0" cellpadding="3">
		  <? 
		  $sql_ticket = "select * from tbl_assign_sub where ticketid='$TicketId' AND nonactive='0' AND profile_id='$profile_id'";
		  
		  		$result_ticket = @mysql_db_query($db_name,$sql_ticket);
				$num_t = @mysql_num_rows($result_ticket);
				$rs_t = @mysql_fetch_assoc($result_ticket);
				
				if($rs_t[assign_date]  != "0000-00-00" and $TicketId != ""){
					$cdate  = $rs_t[assign_date];
				
				}else{
					$cdate = date("Y-m-d");
				}
									
					

		  ?>
            <tr>
              <td colspan="2" align="left">
             <strong> �ӹǹ�ش����ͺ���§ҹ��������� <?=count($arr_idcard) ?> ����ѻ���� </strong></td>
              </tr>
				<? if($cdate != ""){ $temp_date = sw_date_intxtbox($cdate); }else{ $temp_date = date("d/m/Y");}?>
            <tr>
              <td width="18%" align="left"><strong>&nbsp;��ͧ����ҹ���
                <?=$sitekey?>
              </strong></td>
              <td width="82%" align="left"><INPUT name="c_date" onFocus="blur();" value="<?=$temp_date?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form5.c_date, 'dd/mm/yyyy')"value="�ѹ��͹��">&nbsp;</td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td width="7%" align="center" bgcolor="#A3B2CC"><strong>���͡��¡��</strong></td>
          <td width="13%" align="center" bgcolor="#A3B2CC"><strong>���ʻ�Шӵ�ǻ�ЪҪ�</strong></td>
          <td width="14%" align="center" bgcolor="#A3B2CC"><strong>���� - ���ʡ�� </strong></td>
          <td width="19%" align="center" bgcolor="#A3B2CC"><strong>�ç���¹/˹��§ҹ</strong></td>
          <td width="19%" align="center" bgcolor="#A3B2CC"><strong>���˹�</strong></td>
          <td width="10%" align="center" bgcolor="#A3B2CC"><strong>�����Ҫ���</strong></td>
          <td width="10%" align="center" bgcolor="#A3B2CC"><strong>��ṹ�����ͪش</strong></td>
          <td width="11%" align="center" bgcolor="#A3B2CC"><strong>�ӹǹ�ٻ/�ӹǹ��</strong></td>
          <td width="7%" align="center" bgcolor="#A3B2CC"><strong>PDF</strong></td>
          </tr>
		 <?
		 
		 if(count($arr_idcard) < 1){ // �ó�������¡��
		 	echo "<tr bgcolor='#FFFFFF'><td colspan='7' align='center'>  -��辺��¡�÷����� ��سҵ�Ǩ�ͺ���͹䢡�ä��ա���� - </td></tr>";
		 }else{
		 $j=0;		
	foreach($arr_idcard as $k1 => $v1){
		 if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		 $point_key = GetPointFormAgeGov($arr_age[$k1]);
		 
		  if(CheckKp7FileUpdate($v1,$profile_id) == 1){
				$icon_file = "<font color=\"#006600\"><b>*</b></font>";		 
			}else{
				$icon_file = "";			
			}
			
		 
		 ?>
        <tr bgcolor="<?=$bg?>">
          <td align="center"><?=$j?><input type="checkbox" name="xidcard[<?=$v1?>]" value="<?=$v1?>" checked="checked"> 
            <input type="hidden" name="xsiteid[<?=$v1?>]" value="<?=$arr_siteid[$k1]?>">
             <input type="hidden" name="xstatus_file[<?=$v1?>]" value="1">            
             <input type="hidden" name="xprename_th[<?=$v1?>]" value="<?=$arr_prename_th[$k1]?>">
             <input type="hidden" name="xname_th[<?=$v1?>]" value="<?=$arr_name_th[$k1]?>">
             <input type="hidden" name="xsurname_th[<?=$v1?>]" value="<?=$arr_surname_th[$k1]?>">
             </td>
          <td align="center"><?=$v1?></td>
          <td align="left"><? echo "$arr_fullname[$k1]";?> <input type="hidden" name="fullname[<?=$v1?>]" value="<? echo "$arr_fullname[$k1]";?> "></td>
          <td align="left">
		 <?  if($arr_schoolid[$k1] != $arr_siteid[$k1] ){ $pre_school = "�ç���¹";}else{ $pre_school = "";}echo $pre_school.ShowOfficeName($arr_schoolid[$k1])."/".ShowSecname($arr_siteid[$k1]);?></td>
          <td align="left"><? echo "$arr_position[$k1]";?></td>
          <td align="center"><? echo floor($arr_age[$k1]);?></td>
          <td align="center"><?=$point_key;?></td>
          <td align="center"><?=$arr_pagepic[$k1]?></td>
          <td align="center"><?=$arr_kp7[$k1]?><? echo "&nbsp;{$icon_file}";?></td>
        </tr>
		  <? 
		  
		  $point_keyall += $point_key;
		  		}//end 	foreach($arr_idcard as $k1 => $v1){
		}// end   if(count($arr_idcard) < 1){ 
		
		?>
           <tr bgcolor="<?=$bg?>">
          <td colspan="6" align="center" bgcolor="#CCCCCC"><strong>�����ṹ�»���ҳ</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>
            <?=number_format($point_keyall)?>
          </strong></td>
          <td colspan="2" align="left" bgcolor="#CCCCCC"><strong>��ṹ</strong></td>
          </tr>

        <tr>
          <td colspan="9" align="center" bgcolor="#FFFFFF"><label>
          <input type="hidden" name="profile_id" value="<?=$profile_id?>">
		  <input type="hidden" name="Aaction" value="SAVE_W">
		   <input type="hidden" name="staffid" value="<?=$staffid?>">
		   <input type="hidden" name="TicketId" value="<?=$TicketId?>">
           <input type="hidden" name="mode_assign" value="WEEK">
		    <? if($j < 1){ $dis_s = " disabled=disabled' ";}?>
            <input type="submit" name="Submit2" value="�ѹ�֡" <?=$dis_s?>>
			<input type="button" name="btnB" value="��͹��Ѻ" onClick="location.href='assign_list.php?action=assign_key&xsearch=&staffid=<?=$staffid?>&smode=<?=$smode?>'">
          </label></td>
          </tr>
      </table>
  
  </td></tr>
  </form>
  
  <?
	}//end if($xsearch == "search_week";){
  ?>
</table>
<? } // end if($action == "assign_key"){ ?>
<? if($action == "view_person"){
$year1 = (date("Y")+543)."-09-30";
if($mode == "diffkey"){ $conv = " and $db_name.tbl_assign_key.userkey_wait_approve='0'";}else{ $conv = "";}

	$sql_view = "SELECT
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
Inner Join $dbnamemaster.view_general ON $db_name.tbl_assign_key.idcard = $dbnamemaster.view_general.CZ_ID WHERE $db_name.tbl_assign_key.ticketid='$ticketid' $conv ";

?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" bgcolor="#A5B2CE"><input type="button" name="btnBB" value="��͹��Ѻ" onClick="location.href='assign_list.php?action=view_main&staffid=<?=$staffid?>&profile_id=<?=$profile_id?>'">&nbsp;<strong>���ʨ��§ҹ 
            <?=$ticketid?>
        <?=ShowDateProfile($profile_id);?> </strong><strong>&nbsp;��ͧ����ҹ���
                <?=$sitekey?>
              </strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
        <td width="15%" align="center" bgcolor="#A5B2CE"><strong>���ʻ�Шӵ�ǻ�ЪҪ�</strong></td>
        <td width="18%" align="center" bgcolor="#A5B2CE"><strong>���� - ���ʡ�� </strong></td>
        <td width="18%" align="center" bgcolor="#A5B2CE"><strong>�ç���¹/˹��§ҹ</strong></td>
        <td width="21%" align="center" bgcolor="#A5B2CE"><strong>���˹�</strong></td>
        <td width="8%" align="center" bgcolor="#A5B2CE"><strong>�����Ҫ���</strong></td>
        <td width="10%" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ�ٻ/�ӹǹ��</strong></td>
        <td width="7%" align="center" bgcolor="#A5B2CE"><strong>PDF</strong></td>
      </tr>
	  <? 
		$result = mysql_db_query($db_name,$sql_view);
		while($rs = mysql_fetch_assoc($result)){
		 if ($k++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		 
		  $filekp7 = "../../../edubkk_kp7file/$rs[siteid]/$rs[CZ_ID].pdf";
		 if(is_file($filekp7)){
				 $link_kp7 = "<a href=\"../../../edubkk_kp7file/$rs[siteid]/$rs[CZ_ID].pdf\" target=\"_blank\"><img src=\"../../images_sys/gnome-mime-application-pdf.png\" alt=\"�͡��� �.�.7 �鹩�Ѻ\" width=\"20\" height=\"20\" border=\"0\"></a>";
		}else{
				$arrkp7 = GetPdfOrginal($rs[CZ_ID],$path_pdf,$imgpdf,"","pdf");
				$link_kp7 = $arrkp7['linkfile'];	
		}
		
				####  �Ѻ�ӹǹ�ٻ�ӹǹ��
		$arrpicpage = GetNumPicPage($rs[CZ_ID],$profile_id);
		$picpage = $arrpicpage['pic']."/".$arrpicpage['page'];
		
		 if(CheckKp7FileUpdate($rs[CZ_ID],$profile_id) == 1){
				$icon_file = "<font color=\"#006600\"><b>*</b></font>";		 
			}else{
				$icon_file = "";			
			}
			
		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$k?></td>
        <td align="center"><?=$rs[CZ_ID]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo show_org($rs[schoolid])."/".show_area($rs[siteid]);?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="center"><? echo floor($rs[age_gov]);?></td>
        <td align="center"><?=$picpage?></td>
        <td align="center"><?=$link_kp7?><? echo "&nbsp;{$icon_file}";?></td>
      </tr>
	  <?
	  	}// end while(){
	  ?>
    </table></td>
  </tr>
</table>

<? } // end 

	if($action == "assign_detail"){
	$sql = "SELECT * FROM tbl_assign_sub WHERE ticketid='$TicketId' AND nonactive='0'";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" align="left" bgcolor="#A5B2CE"><b><? echo show_user($rs[staffid])." �ѹ��� ".thai_date($rs[assign_date])." ���ʧҹ ".$TicketId;?>&nbsp;<?=ShowDateProfile($profile_id);?> 
          <strong>��ͧ����ҹ���
          <?=$sitekey?>
          </strong></b><a href="assign_print.php?ticketid=<?=$TicketId?>" target="_blank"><img src="../../images_sys/print.gif" width="21" height="20" title="�������ͻ��Թ㺧ҹ�ͺ���§ҹ �.�.7" border="0"></a></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
        <td width="12%" align="center" bgcolor="#A5B2CE"><strong>���ʻ�Шӵ�ǻ�ЪҪ�</strong></td>
        <td width="13%" align="center" bgcolor="#A5B2CE"><strong>���� -���ʡ�� </strong></td>
        <td width="20%" align="center" bgcolor="#A5B2CE"><strong>�ç���¹/˹��§ҹ</strong></td>
        <td width="27%" align="center" bgcolor="#A5B2CE"><strong>���˹�</strong></td>
        <td width="7%" align="center" bgcolor="#A5B2CE"><strong>�����Ҫ���</strong></td>
        <td width="11%" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ�ٻ/�ӹǹ��</strong></td>
        <td width="7%" align="center" bgcolor="#A5B2CE"><input type="button" name="btnA" value="������¡��" onClick="location.href='assign_list.php?action=assign_key&staffid=<?=$staffid?>&TicketId=<?=$TicketId?>&profile_id=<?=$profile_id?>'"></td>
      </tr>
	  <?
//	  	$sql_detail = "SELECT
//$db_name.tbl_assign_key.ticketid,
//$dbnamemaster.view_general.CZ_ID,
//$dbnamemaster.view_general.siteid,
//$dbnamemaster.view_general.prename_th,
//$dbnamemaster.view_general.name_th,
//$dbnamemaster.view_general.surname_th,
//$dbnamemaster.view_general.position_now,
//$dbnamemaster.view_general.schoolid,
//(TIMESTAMPDIFF(MONTH,begindate,'$year1')/12) as age_gov
//FROM
//$db_name.tbl_assign_key
//Inner Join $dbnamemaster.view_general ON $db_name.tbl_assign_key.idcard = $dbnamemaster.view_general.CZ_ID  WHERE $db_name.tbl_assign_key.ticketid='$TicketId'";
$sql_detail = "SELECT * FROM tbl_assign_key WHERE ticketid='$TicketId'";
//echo $sql_detail;
$result_detail = mysql_db_query($db_name,$sql_detail);
while($rs_d = mysql_fetch_assoc($result_detail)){
$dbsite = STR_PREFIX_DB.$rs_d[siteid];
		$sql_general = "SELECT idcard,siteid,prename_th,name_th,surname_th,position_now,schoolid,(TIMESTAMPDIFF(MONTH,begindate,'$year1')/12) as age_gov FROM general WHERE idcard = '$rs_d[idcard]'";
		$result_general = @mysql_db_query($dbsite,$sql_general);
		$rs_g = @mysql_fetch_assoc($result_general);
		$xarr_idcard[$rs_d[idcard]] = $rs_g[idcard];
		$xarr_name_th[$rs_d[idcard]] = $rs_g[prename_th]."".$rs_g[name_th]." ".$rs_g[surname_th];
		$xarr_org[$rs_d[idcard]] = show_org($rs_g[schoolid])."/".show_area($rs_d[siteid]);
		$xarr_position_now[$rs_d[idcard]] = $rs_g[position_now];
		$xarr_age[$rs_d[idcard]] = floor($rs_g[age_gov]);
		$xarr_siteid[$rs_d[idcard]] = $rs_g[siteid];
		$xarr_idcard_assign[$rs_d[idcard]] = $rs_d[idcard];
}

//echo "<pre>";
//print_r($xarr_idcard);
		$k=0;
		if($xarr_idcard > 0){ // �ó��բ�������ҹ��
		foreach($xarr_idcard as $xkey => $xval){
		 if ($k++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		 $filekp7 = "../../../edubkk_kp7file/$xarr_siteid[$xkey]/$xval.pdf";
		 if(is_file($filekp7)){
				 $link_kp7 = "<a href=\"../../../edubkk_kp7file/$xarr_siteid[$xkey]/$xval.pdf\" target=\"_blank\"><img src=\"../../images_sys/gnome-mime-application-pdf.png\" alt=\"�͡��� �.�.7 �鹩�Ѻ\" width=\"20\" height=\"20\" border=\"0\"></a>";
		}else{
			
			 	$arrkp7 = GetPdfOrginal($xval,$path_pdf,$imgpdf,"","pdf");
				$link_kp7 = $arrkp7['linkfile'];		
				//$link_kp7 = "";	
		}
		
						####  �Ѻ�ӹǹ�ٻ�ӹǹ��
		$arrpicpage = GetNumPicPage($xval,$profile_id);
		$picpage = $arrpicpage['pic']."/".$arrpicpage['page'];
		
		 if(CheckKp7FileUpdate($xval,$profile_id) == 1){
				$icon_file = "<font color=\"#006600\"><b>*</b></font>";		 
		}else{
				$icon_file = "";			
		}
			

		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$k?></td>
        <td align="left"><? echo "$xval";?></td>
        <td align="left"><? echo "$xarr_name_th[$xkey]";?></td>
        <td align="left"><? echo "$xarr_org[$xkey]";?></td>
        <td align="left"><? echo "$xarr_position_now[$xkey]";?></td>
        <td align="center"><? echo "$xarr_age[$xkey]";?></td>
        <td align="center"><?=$picpage?></td>
        <td align="center"><?=$link_kp7?>&nbsp; <? echo "&nbsp;$icon_file";?><img src="images/b_drop.png" border="0" alt="ź��¡��" onClick="return confirmDelete('pupup_delete.php?idcard=<?=$xval?>&ticketid=<?=$TicketId?>&staffid=<?=$staffid?>&idcard_assign=<?=$xarr_idcard_assign[$xkey]?>')" style="cursor:hand"></td>
      </tr>
	  <?
	  	} // end foreach($arr_idcard as $key => $val){
		}//end if($xarr_idcard > 0){ 
	  ?>
    </table></td>
  </tr>
</table>
<script>
	  function alertTxt(id){
	    alert('�١���͡�����');
		document.getElementById(id).checked = false;
      }
</script>
<?
	} //end 
	

function find_site_now($schoolid){
  $sql = "SELECT * FROM allschool WHERE id = '$schoolid' ";
  $query = mysql_db_query(DB_MASTER,$sql);
  $rows = mysql_fetch_array($query);
  
  return $rows['siteid'];
}
function find_old_site($schoolid){
  $sql = "SELECT * FROM allschool_math_sd WHERE schoolid = '$schoolid' ";
  $query = mysql_db_query(DB_MASTER,$sql);
  $rows = mysql_fetch_array($query);
  
  $num = mysql_num_rows($query);
  if($num > 0){
    return $rows['siteid'];
  }else{
    return find_site_now($schoolid);
  }  
}

function replace_txt($txt){
 if(eregi('�Ѹ���֡��',$txt)){
   $str = "�ӹѡ�ҹࢵ��鹷�����֡��";
 }else{
   $str = "�ӹѡ�ҹࢵ��鹷�����֡�һ�ж��֡��";   
 }
 
 $txt = str_replace('ʾ�.',"",$txt); 
 return $str.$txt; 
}	

function searchReplace($key="", $data = ""){
	
		$replace = '<span style="background:#FFCC99;">'.$key.'</span>';
		$data_replace = str_replace($key,$replace,$data);
		return $data_replace;
	}



if($xsearch == "search3" ){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="2" bgcolor="#E6E6E6" align="center" style="border:1px solid #5595CC;">
	<tr>
	<td >
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="5%" valign="top"><strong>�Ӥ�</strong></td>
    <td width="95%" valign="top">
	<?php
	if($select_school_label != ""){
	  echo "<strong>�����ç���¹ :</strong><font style='background-color:#FFCC99'>$select_school_label</font>";
	}
	if($name_type2 != ""){
	  echo "<br><strong>���� :</strong><font style='background-color:#FFCC99'>$name_type2</font>";
	}
	if($surname_type2 != ""){
	  echo "<br><strong>���ʡ�� :</strong> <font style='background-color:#FFCC99'>$surname_type2</font>";
	}
	if($idcard_type2 != ""){
	  echo "<br><strong>�����Ţ�ѵû�ЪҪ� :</strong> <font style='background-color:#FFCC99'>$idcard_type2</font>";
	}
	?>
	</td>
  </tr>
</table>

	
		
	</td>
	</tr>
</table>
<br>
<br>		
<?php
  
  #find schoolid from school name
  if($select_school_label != ""){
    $str_school = str_replace(" ","%",$select_school_label);
    $sql_school = " SELECT id,office,siteid FROM allschool WHERE office LIKE '%".$str_school."%' ";
	$query_school = mysql_db_query(DB_MASTER,$sql_school);
	while($rows_school = mysql_fetch_array($query_school)){
	  $arr_school[$rows_school['id']] = $rows_school['office'];
	}
  }

 if(count($arr_school) > 0){
?>
<form action="?action=<?=$_GET['action']?>&smode=<?=$_GET['smode']?>&staffid=<?=$_GET['staffid']?>&TicketId=<?=$_GET['TicketId']?>&profile_id=<?=$_GET['profile_id']?>" method="post" name="frm_sc1">
<?php 
   foreach($arr_school as $schoolid => $school_name){
    
	$cond = "";  
	$cond .= " AND schoolid = '".$schoolid."' ";
  
    $siteid_now = find_site_now($schoolid);
	if($name_type2 != ""){
	 $cond .= " AND name_th LIKE '%".$name_type2."%' ";
	}
	if($surname_type2 != ""){
	 $cond .= "AND surname_th LIKE '%".$surname_type2."%' ";
	}
	if($idcard_type2 != ""){
	 $cond .= " AND idcard = '".$idcard_type2."' "; 
	}
	
	if($show_person_all == $schoolid ){
	  $limit = "  ";
	}else{
	  $limit = " LIMIT 0,3 ";
	}  
	
	$db_site = STR_PREFIX_DB.$siteid_now;
	$sql = "SELECT * , (TIMESTAMPDIFF(MONTH,begindate,'$year1')/12) as age_gov FROM general WHERE siteid='$siteid_now' $cond $limit ";
	
?>


<a name="<?=$schoolid?>"></a>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr bgcolor="#FFFFCC">
    <td>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="9%"><div align="left"><strong>�ç���¹ </strong></div></td>
    <td width="91%"><strong><?=searchReplace($select_school_label,$school_name)?></strong></td>
  </tr>
  <tr>
    <td><div align="left"><strong>�ѧ�Ѵ�Ѩ�غѹ</strong></div></td>
    <td><strong><?=replace_txt(show_area(find_site_now($schoolid)))?></strong></td>
  </tr>
  <tr>
    <td><div align="left"><strong>�ѧ�Ѵ���</strong></div></td>
    <td><strong><font color="#666666"><em><?=show_area(find_old_site($schoolid))?></em></font></strong></td>
  </tr>
  <tr>
    <td><div align="left"></div></td>
    <td><a href="?action=<?=$_GET['action']?>&smode=<?=$_GET['smode']?>&staffid=<?=$_GET['staffid']?>&TicketId=<?=$_GET['TicketId']?>&profile_id=<?=$_GET['profile_id']?>&show_by_school=<?=$schoolid?>&old_site=<?=find_old_site($schoolid)?>&new_site=<?=$siteid_now?>"><font color="#006600"><b><u>[价��˹���ͺ���§ҹ����ç���¹]</u></b></font></a></td>
  </tr>
</table>
</td>
  </tr>
 
  <tr bgcolor="#FFFFFF">
    <td>
	
	
	
<strong>��ª��ͺؤ�ҡ���ç���¹�</strong>
<table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="#CCCCCC" style="border-collapse:collapse; background-color:#FFFFFF">
  <tr >
  
    <td width="11%"><div align="center"><strong>�ӴѺ</strong></div></td>
    <td width="25%"><div align="center"><strong>�Ţ���ѵû�ЪҪ�</strong></div></td>
    <td width="40%"><div align="center"><strong>���� ���ʡ��</strong></div></td>
    <td width="24%"><div align="center"><strong>���͡�ʴ������������ͺ���§ҹ</strong><br>
    <input name="bt_show" type="submit" value="�ͺ���§ҹ ">
	<input name="show_by_person" type="hidden" value="1">
</div></td>
  </tr>
<?php
$i = 1;
$query = mysql_db_query($db_site,$sql)or die(mysql_error());
while($rows = mysql_fetch_array($query)){
  
?>  
  <tr <?php if($i%2 == '0'){echo 'bgcolor="#eeeeee"';}?> >
  
    <td><div align="center"><?=$i?></div></td>
    <td><div align="center"><?=searchReplace($idcard_type2,$rows['idcard'])?></div></td>
    <td><?=$rows['prename_th']?><?=searchReplace($name_type2,$rows['name_th'])?>&nbsp;&nbsp;<?=searchReplace($surname_type2,$rows['surname_th'])?></td>
    <td>
	<?php
	$arrx = CheckProtectionAssign($rows['idcard'],$rows['siteid'],$profile_id);
	if($arrx[0] > 0){
				$dis = "disabled='disabled'";
				$msg = "<font color='red'>".$arrx[1]."</font>";
				$file_status = $arrx[2];  // ʶҹТͧ��õ�Ǩ�ͺ�͡���
	}else{
				$dis = "";	
				$msg = "";
				$file_status = 1;
				
	}
	
	
//	$arrpage = CheckNumKp7File($rows['idcard'],$profile_id);
//			if($arrpage['nump'] == "0"){
//				$msg .= $arrpage['msg_err'];
//				$dis = "disabled='disabled'";
//			}

	
	if(person_not_assign($rows['idcard'],$rows['siteid'],"$TicketId") == 1){ // �ʴ�੾�кؤ�ҡ÷���ѧ���١���͡��ҹ���
      $dis2 = "disabled='disabled'";
	  $msg2 = "<font color='red'>*�١���͡�����</font>";
    }else{
	  $dis2 = "";	
	  $msg2 = "";
	}
	#echo $rows['idcard']."/".$rows['siteid']."/".$TicketId;
	?>
	
	<div align="center"><input id="<?=$rows['idcard']?>" name="arr_idcard[]" type="checkbox" value="<?=$rows['idcard']?>" <?=$dis?>
	<?php if($msg2 != "" ){?>
	onClick="alert('�١���͡�����'),document.getElementById('<?=$rows[idcard]?>').checked = false ;"
	<?php
	}
	?>
	 > <?=$msg?></div></td>
  </tr>
<?php
  $i++;
}
?> 
</table>

	
	</td>
  </tr>
   <tr>
    <td><strong><a href="?action=<?=$_GET['action']?>&smode=<?=$_GET['smode']?>&staffid=<?=$_GET['staffid']?>&TicketId=<?=$_GET['TicketId']?>&profile_id=<?=$_GET['profile_id']?>&show_person_all=<?=$schoolid?>&select_school_label=<?=$select_school_label?>&name_type2=<?=$name_type2?>&surname_type2=<?=$surname_type2?>&idcard_type2=<?=$idcard_type2?>&xsearch=search3#<?=$schoolid?>"><font color="#CC0000">[�ʴ���ª��ͺؤ�ҡ÷�����]
	</font></a></strong></td>
  </tr>
</table>
<br>
<br>

<?php
  }#end foreach	
?>
</form>	
<?php  
 }else{
    if($name_type2 != ""){
	 $cond .= " AND name_th LIKE '%".$name_type2."%' ";
	}
	if($surname_type2 != ""){
	 $cond .= "AND surname_th LIKE '%".$surname_type2."%' ";
	}
	if($idcard_type2 != ""){
	 $cond .= " AND CZ_ID = '".$idcard_type2."' "; 
	}
	$sql = "SELECT * , (TIMESTAMPDIFF(MONTH,begindate,'$year1')/12) as age_gov FROM view_general WHERE siteid != '' $cond  ORDER BY schoolid ";
	
?>
<form action="?action=<?=$_GET['action']?>&smode=<?=$_GET['smode']?>&staffid=<?=$_GET['staffid']?>&TicketId=<?=$_GET['TicketId']?>&profile_id=<?=$_GET['profile_id']?>" method="post" name="frm_sc2">
<table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="#CCCCCC" style="border-collapse:collapse; background-color:#FFFFFF">
  <tr bgcolor="#A5B2CE">
    <td width="4%" rowspan="2"><div align="center"><strong>�ӴѺ</strong></div></td>
    <td width="11%" rowspan="2"><div align="center"><strong>�Ţ���ѵû�ЪҪ�</strong></div></td>
    <td width="12%" rowspan="2"><div align="center"><strong>���� ���ʡ��</strong></div></td>
    <td width="20%" rowspan="2"><div align="center"><strong>�ç���¹ / �ѧ�Ѵ</strong></div></td>
    <td width="21%" rowspan="2"><div align="center"><strong>˹��§ҹ��� </strong></div></td>
    <td colspan="2"><div align="center"><strong>�ʴ������������ͺ���§ҹ</strong></div></td>
  </tr>
  <tr bgcolor="#A5B2CE">
  
    <td width="16%"><div align="center"><strong>���͡����ç���¹</strong></div></td>
    <td width="16%"><div align="center">
	<strong>���͡��¤�</strong>
	<input name="show_by_person" type="hidden" value="1">
</div></td>
  </tr>
<?php
$i = 1;
$query = mysql_db_query(DB_MASTER,$sql)or die(mysql_error());
while($rows = mysql_fetch_array($query)){
 
?>  
  <tr <?php if($i%2 == '0'){echo 'bgcolor="#eeeeee"';}?> >
  
    <td><div align="center"><?=$i?></div></td>
    <td><div align="center"><?=searchReplace($idcard_type2,$rows['CZ_ID'])?></div></td>
    <td><?=$rows['prename_th']?><?=searchReplace($name_type2,$rows['name_th'])?>&nbsp;&nbsp;<?=searchReplace($surname_type2,$rows['surname_th'])?></td>
    <td><?php echo show_org($rows['schoolid'])." : ".replace_txt(show_area($rows['siteid'])); ?></td>
    <td>
	 <?php 
	 echo '<font color="#666666">('.replace_txt(show_area(find_old_site($rows['schoolid']))).") </font>";
	 ?>	</td>
    <td><div align="center">
	<a href="?action=<?=$_GET['action']?>&smode=<?=$_GET['smode']?>&staffid=<?=$_GET['staffid']?>&TicketId=<?=$_GET['TicketId']?>&profile_id=<?=$_GET['profile_id']?>&show_by_school=<?=$rows['schoolid']?>&old_site=<?=find_old_site($rows['schoolid'])?>&new_site=<?=$rows['siteid']?>">
	<font color="#006600"><u>����ç���¹</u></font>	</a>
	</div></td>
    <td><div align="center">
	
<?php
	$arrx = CheckProtectionAssign($rows['CZ_ID'],$rows['siteid'],$profile_id);
	if($arrx[0] > 0){
				$dis = "disabled='disabled'";
				$msg = "<font color='red'>".$arrx[1]."</font>";
				$file_status = $arrx[2];  // ʶҹТͧ��õ�Ǩ�ͺ�͡���
	}else{
				$dis = "";	
				$msg = "";
				$file_status = 1;
				
	}
	
	
//	$arrpage = CheckNumKp7File($rows['CZ_ID'],$profile_id);
//			if($arrpage['nump'] == "0"){
//				$msg .= $arrpage['msg_err'];
//				$dis = "disabled='disabled'";
//			}

	
	if(person_not_assign($rows['CZ_ID'],$rows['siteid'],"$TicketId") == 1){ // �ʴ�੾�кؤ�ҡ÷���ѧ���١���͡��ҹ���
      $dis2 = "disabled='disabled'";
	  $msg = "<font color='red'>*�١���͡�����</font>";
    }else{
	  $dis2 = "";	
	  $msg2 = "";
	}
	
	
	
	
	if($msg != "" or $msg2 != ""){
	  echo $msg." ".$msg2;
	}
	if($msg == "" and $msg2 == ""){
?>
<a href="?action=<?=$_GET['action']?>&smode=<?=$_GET['smode']?>&staffid=<?=$_GET['staffid']?>&TicketId=<?=$_GET['TicketId']?>&profile_id=<?=$_GET['profile_id']?>&old_site=<?=find_old_site($rows['schoolid'])?>&new_site=<?=$rows['siteid']?>&show_by_person=1&idcard_show=<?=$rows['CZ_ID']?>">���͡</a>
<?php
	}

	#echo $rows['idcard']."/".$rows['siteid']."/".$TicketId;
	?>
	
	</div>	
	</td>
  </tr>
<?php
  $i++;
  }
}
?> 
</table>
</form>	
	
	</td>
  </tr>
</table>

<?php
	
 
}

echo "&nbsp;&nbsp;&nbsp;&nbsp; �����˵� : ����ͧ���� <font color=\"#006600\"><b>*</b></font> ���ʶҹ���� �.�.7 ���ӡ�õ��������º�������� ";
?>
</BODY>
</HTML>

<?
	$time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
?>