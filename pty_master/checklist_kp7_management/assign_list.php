<?
session_start();
$ApplicationName	= "checklist_kp7_management_assign";
$module_code 		= "checklistkp7_assign"; 
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
include("checklist2.inc.php");
$time_start = getmicrotime();
$db_temp = $dbname_temp;
$db_name = $dbcallcenter_entry;

$report_title = "�ͺ���§ҹ scan �͡��÷���¹����ѵԵ鹩�Ѻ";

$year1 = (date("Y")+543)."-09-30";
//echo "<pre>";
//print_r($_POST);
if($_SERVER['REQUEST_METHOD'] == "POST"){



		if($Aaction == "SAVE"){
		
//echo "<pre>";
//print_r($_POST);
			/// �Ѵ��â����š�è��§ҹ��͹
				if($TicketId == ""){
					$TicketId = "TK-".$ticketYY."".ran_digi(7);
					$sql_tk = "INSERT INTO tbl_checklist_assign SET ticketid='$TicketId' , siteid='$ssiteid', staffid='$staffid',activity_id='$activity_id', profile_id='$profile_id',date_assign='".sw_date_indb($c_date)."', staff_assign='".$_SESSION['session_staffid']."',localtion_scan='$localtion_scan'  ,timeupdate_scan=NOW()";
				}else{
					$sql_tk = "UPDATE  tbl_checklist_assign SET staffid='$staffid' , date_assign='".sw_date_indb($c_date)."', staff_assign='".$_SESSION['session_staffid']."', localtion_scan='$localtion_scan',profile_id='$profile_id' WHERE  ticketid='$TicketId' ";
				}// end if($TicketId == ""){
					
				//echo "<pre>";
				//print_r($idcard);
				//echo "sql :: ".$sql_tk." <br>db :: $db_temp";die;
				$result_tk = mysql_db_query($db_temp,$sql_tk);
				if($result_tk){
				
//					$sql_t1 = "SELECT COUNT(*) AS numt1 FROM tbl_assign_key WHERE ticketid='$TicketId' ";
//					$result_t1 = mysql_db_query($db_name,$sql_t1);
//					$rs_t1 = mysql_fetch_assoc($result_t1);
//					
//					if($rs_t1[numt1] > 0){ // �ó��բ��������
//					$idcard = array_merge($xidcard,$xidcard1);
//					$name = array_merge($fullname,$fullname1);
//					$siteid = array_merge($xsiteid,$xsiteid1);
//					}else{
					$idcard = $xidcard;
					$name = $fullname;
					$siteid = $xsiteid;
				//	} // end if($rs_t1[numt1] > 0){
					
					//echo "<pre>";
					//print_r($xsiteid);die;
					
					//$sql_del = "DELETE FROM tbl_assign_key WHERE ticketid='$TicketId'";
					//@mysql_db_query($db_name,$sql_del);
					//echo "<pre>";
					//print_r($_POST);

					if(count($idcard) > 0){
						foreach($idcard as $k => $v){
							if(check_assign_replace($v,$TicketId,$activity_id) > 0){ // ��Ǩ�ͺ�ó��ա�úѹ�֡�����ū�� ��������ѹ
							$temp_alert = " �������ö�ѹ�֡ $name[$k] ���ʺѵ� $v �����ͧ�ҡ��¡�ù����١�ͺ���§ҹ������к�";
							echo "<script>alert('$temp_alert');</script>";
							}else{
								### ��Ǩ�ͺ�����š�͹�ӡ������
							$sql_check = "SELECT * FROM  tbl_checklist_assign_detail WHERE ticketid='$TicketId' AND idcard='$v' and profile_id='$profile_id' and activity_id='$activity_id'" ;
							$result_chekc = @mysql_db_query($dbname_temp,$sql_check);
							$rs_ch = @mysql_fetch_assoc($result_chekc);
								if($rs_ch[idcard] != ""){
										$sql_insert = "UPDATE tbl_checklist_assign_detail SET siteid='$xsiteid[$k]', prename_th='$prename_th[$k]',name_th='$name_th[$k]',surname_th='$surname_th[$k]',profile_id='$profile_id' WHERE ticketid='$rs_ch[ticketid]' AND idcard='$rs_ch[idcard]' and activity_id='$activity_id'";
									//AddLogActivity($rs_ch[ticketid],$rs_ch[idcard],$xsiteid[$k],$staffid,"update",$activity_id,"1","��䢡���ͺ���§ҹ");
									SaveLogAssign($v,$xsiteid[$k],$TicketId,"update");
								}else{
									$sql_insert = "INSERT INTO tbl_checklist_assign_detail(ticketid,idcard,siteid,prename_th,name_th,surname_th,profile_id,activity_id)VALUES('$TicketId','$v','$xsiteid[$k]','$prename_th[$k]','$name_th[$k]','$surname_th[$k]','$profile_id','$activity_id')";
									//AddLogActivity($TicketId,$v,$xsiteid[$k],$staffid,"insert",$activity_id,"1","���������š���ͺ���§ҹ");
									SaveLogAssign($v,$xsiteid[$k],$TicketId,"insert");
								}
								## end ��Ǩ�ͺ�����š�͹����
						//echo $sql_insert."<br>";die;
							mysql_db_query($dbname_temp,$sql_insert);
							
							} // end if(check_assign_replace($v) > 0){ 
						}// end 	foreach($xidcard as $k => $v){
					}// end if(count($xidcard) > 0){

				
				}// end if($result_tk){
				//die;
				
			echo "<script>alert('�ѹ�֡������㺧ҹ���º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=assign_detail&TicketId=$TicketId&staffid=$staffid&profile_id=$profile_id&activity_id=$activity_id';</script>";
		}// end 	if($Aaction == "SAVE"){

}// end if($_SERVER['REQUEST_METHOD'] == "POST"){

### ��¡��ź������

if($action == "del"){
		$sql_check = "SELECT COUNT(idcard) AS num1 FROM tbl_checklist_assign_detail WHERE ticketid='$TicketId' and profile_id='$profile_id' and activity_id='$activity_id' GROUP BY ticketid";
		$result_check = mysql_db_query($dbname_temp,$sql_check);
		$rs_c = mysql_fetch_assoc($result_check);
		if($rs_c[num1] > 0){
	echo "<script>alert('�������öź��¡�������ͧ�ҡ����¡�����������㺧ҹ���'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=view_main&staffid=$staffid&profile_id=$profile_id&activity_id=$activity_id';</script>";
		}else{
	$sql_del = "DELETE  FROM tbl_checklist_assign  WHERE ticketid='$TicketId' and profile_id='$profile_id&activity_id=$activity_id'";
	@mysql_db_query($dbname_temp,$sql_del);
	### �� log 
	$sqlx1 = "SELECT * FROM tbl_checklist_assign_detail WHERE WHERE ticketid='$TicketId' and profile_id='$profile_id' AND activity_id=$activity_id'";
	$resultx1 = mysql_db_query($dbname_temp,$sqlx1);
	while($rsx1 = mysql_fetch_assoc($resultx1)){
			//AddLogActivity($TicketId,$rsx1[idcard],$rsx1[siteid],$staffid,"delete",$activity_id,"0","�͹㺧ҹ�͡");
			SaveLogAssign($rsx1[idcard],"$rsx1[siteid]",$TicketId,"delete","ź���㺧ҹ");	
			
	}//end while($rsx1 = mysql_fetch_assoc($resultx1)){
	
	$sql_del1 = "DELETE FROM tbl_checklist_assign_detail WHERE ticketid='$TicketId' and profile_id='$profile_id' and activity_id='$activity_id'";
	
	@mysql_db_query($dbname_temp,$sql_del1);
	
	if(!(mysql_error())){
		echo "<script>alert('ź��¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=view_main&staffid=$staffid&profile_id=$profile_id&activity_id=$activity_id';</script>";
	}
	
	}//end 	if($rs_c[num1] > 0){
}// end if($action == "del"){
### end ��¡��ź������

if($action == "del_person"){ // ź��������ǹ�ؤ��
$sql_del = "DELETE FROM tbl_checklist_assign_detail WHERE ticketid='$ticketid' AND idcard='$idcard' AND profile_id='$profile_id' and activity_id='$activity_id' ";
@mysql_db_query($dbname_temp,$sql_del);
//AddLogActivity($ticketid,$idcard,$xsiteid,$staffid,"delete",$activity_id,"0","�͹㺧ҹ�͡");
SaveLogAssign($idcard,"$xsiteid",$ticketid,"delete");	
	if(!(mysql_error())){
		echo "<script>alert('ź��¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=assign_detail&staffid=$staffid&TicketId=$ticketid&profile_id=$profile_id&activity_id=$activity_id';</script>";
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

	
?><br>
<table width="98%" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" cellpadding="2" cellspacing="1">
      <tr>
        <td colspan="5" align="center" bgcolor="#E1E1E1"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="97%" align="center"><strong><? echo "(".ShowActivity($activity_id).")";?></strong><br>
              <strong>��¡���ͺ�ҹ�ͧ <? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?>&nbsp;
              <?=ShowDateProfile($profile_id);?>
              &nbsp;</strong></td>
            <td width="3%" align="center">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td width="21%" align="center" bgcolor="#E1E1E1"><strong>�����ͺ�ҹ</strong></td>
        <td width="26%" align="center" bgcolor="#E1E1E1"><strong>�ѹ����ͺ�ҹ</strong></td>
        <td width="22%" align="center" bgcolor="#E1E1E1"><strong>�ӹǹ�ؤ�ҡ÷���᡹(��)</strong></td>
        <td width="22%" align="center" bgcolor="#E1E1E1"><strong>ʶҹС���ͺ�ҹ</strong></td>
        <td width="9%" align="center" bgcolor="#E1E1E1"><label>
          <input type="button" name="btnA" value="����" onClick="location.href='assign_list.php?action=assign_key&staffid=<?=$staffid?>&smode=1&profile_id=<?=$profile_id?>&activity_id=<?=$activity_id?>'">
        </label></td>
      </tr>
	  <? 
	  if($s_siteid != ""){
			$conv1 = " AND siteid='$s_siteid'";	 	 
	  }
	  	$sql_main = "SELECT * FROM tbl_checklist_assign WHERE staffid='$staffid' AND profile_id='$profile_id' AND activity_id='$activity_id' $conv1";
		$result_main = mysql_db_query($db_temp,$sql_main);
		$i=0;
		while($rs_m = mysql_fetch_assoc($result_main)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}

		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$rs_m[ticketid]?></td>
        <td align="center"><?=thai_date($rs_m[date_assign])?></td>
        <td align="center">
		<?
			$sql_count = "SELECT COUNT(idcard) AS num1  FROM tbl_checklist_assign_detail  WHERE ticketid = '$rs_m[ticketid]'  GROUP BY ticketid ";
			$result_count = mysql_db_query($db_temp,$sql_count);
			$rs_c1 = mysql_fetch_assoc($result_count);
			echo "<a href='assign_list.php?action=view_person&staffid=$staffid&ticketid=$rs_m[ticketid]&profile_id=$profile_id&activity_id=$activity_id'>$rs_c1[num1]</a>";
			//echo $rs_c1[num1];
		?>
		</td>
        <td align="center"><? if($rs_m[assign_status] == "Y"){ echo "�ͺ�ҹ����";}else{ echo "���ͺ�ҹ";} ?></td>
        <td align="center"><a href="assign_list.php?action=assign_key&staffid=<?=$rs_m[staffid]?>&TicketId=<?=$rs_m[ticketid]?>&profile_id=<?=$profile_id?>&activity_id=<?=$activity_id?>"><img src="../userentry/images/b_edit.png" width="16" height="16" border="0" alt="��䢢�����"></a> &nbsp;<img src="../userentry/images/b_drop.png" width="16" height="16" border="0" alt="ź��¡�â�����" onClick="return confirmDelete1('assign_list.php?action=del&staffid=<?=$rs_m[staffid]?>&TicketId=<?=$rs_m[ticketid]?>&profile_id=<?=$profile_id?>&activity_id=<?=$activity_id?>')" style="cursor:hand"></td>
      </tr>
	  <?
	  	}// end while
	  ?>
    </table></td>
  </tr>
</table>

<?
	}// end 
?>

<? 
	if($action == "assign_key"){
		
?><br>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <form name="form1" method="post" action="">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td colspan="4" align="center" bgcolor="#E1E1E1"><strong><? echo "(".ShowActivity($activity_id).")";?><br>
������ѹ�֡����ͺ���§ҹ�ͧ
          <?=show_user($staffid)?>&nbsp;
          </strong></td>
      </tr>
      <tr>
        <td width="15%" align="left" bgcolor="#FFFFFF"><strong>ࢵ��鹷�����֡��</strong></td>
        <td width="30%" align="left" bgcolor="#FFFFFF">
          <select name="sent_siteid" id="sent_siteid" onChange="refreshproductList();">
            <option value=""> - ���͡ࢵ��鹷�����֡�� - </option>
            <? 
			$sql_site = "SELECT eduarea.secid, eduarea.secname,eduarea_config.pdf_org,
eduarea_config.pdf_sys FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE eduarea_config.group_type =  'keydata' AND eduarea_config.profile_id='$profile_id'  order by eduarea.secname ASC";
			$result_site = mysql_db_query($dbnamemaster,$sql_site);
			while($rs_s = mysql_fetch_assoc($result_site)){
				if($rs_s[secid] == $sent_siteid){ $sel = "selected='selected'";}else{ $sel = "";}
				$secname = str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",$rs_s[secname]);
				echo "<option value='$rs_s[secid]' $sel>$secname</option>";
			}// end while($rs_s = mysql_fetch_assoc($result_site)){
			?>
            </select>
  </td>
        <td width="13%" align="left" bgcolor="#FFFFFF"><label><strong>����</strong></label></td>
        <td width="42%" align="left" bgcolor="#FFFFFF"><label>
          <input name="key_name" type="text" id="key_name" size="30" value="<?=$key_name?>">
          </label></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#FFFFFF"><strong>˹��§ҹ/�ç���¹</strong></td>
        <td align="left" bgcolor="#FFFFFF">
          <select name="schoolid" id="schoolid">
            <?
				if($sent_siteid != ""){
					$sql_school = "SELECT id, office FROM allschool WHERE siteid='$sent_siteid' order by  office ASC";
					$result_school = mysql_db_query($dbnamemaster,$sql_school);
					while($rs_sch = mysql_fetch_assoc($result_school)){
							if($rs_sch[id] == $schoolid){ $sel = "selected='selected'";}else{ $sel = "";}
							echo "<option value='$rs_sch[id]' $sel>$rs_sch[office]</option>";
					}
				}//end 	if($sent_siteid != ""){

			?>
          </select>
        </td>
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
        <td colspan="4" align="center" bgcolor="#FFFFFF">
          <input type="hidden" name="profile_id" value="<?=$profile_id?>">
          <input type="hidden" name="action" value="assign_key">
          <input type="hidden" name="xsearch" value="search">
          <input type="hidden" name="staffid" value="<?=$staffid?>">
          <input type="hidden" name="TicketId" value="<?=$TicketId?>">
        <input  type="hidden" name="activity_id" value="<?=$activity_id?>">
          <input type="submit" name="Submit" value="����"></td>
      </tr>
    </table></td>
  </tr>
  </form>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <?
 #########   ###########################  ����Ẻ�����´ ################
  	if($xsearch == "search"){

	## �óդ��Ҫ���
	if($key_name != ""){ 
			$conW .= " AND name_th LIKE '%$key_name%' ";
	}// end if($name != ""){ 
## end �óդ��Ҫ���
## �óդ��ҹ��ʡ��
	if($key_surname != ""){
			$conW .= " AND surname_th LIKE '%$key_surname%' ";
	}// end if($surname != ""){
## end �óդ��ҹ��ʡ��
##  �óդ������ʺѵ�
	if($key_idcard != ""){
			$conW2 = " AND idcard LIKE '%$key_idcard%'";
	}
##  end �óդ������ʺѵ�
	if($schoolid > 0){
		$w_school = " AND schoolid='$schoolid' ";
	}

$year1 = (date("Y")+543)."-09-30";

if($sent_siteid != ""){
		$consite = " AND siteid='$sent_siteid' ";
}
###########  ���͹䢡�ä���



	//$sql = "SELECT * , (TIMESTAMPDIFF(MONTH,begindate,'$year1')/12) as age_gov FROM  general WHERE  siteid='$sent_siteid' $conW  $conW1 $conW2 $w_school";
	$sql = "SELECT *,(TIMESTAMPDIFF(MONTH,begindate,'$year1')/12) as age_gov,if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0',1,0) as status_doc FROM `tbl_checklist_kp7` WHERE  profile_id='$profile_id'  $consite $conW  $conW1 $conW2 $w_school";
//	echo "$db_site :: $sql ";
	//echo $db_site;
	$result = mysql_db_query($dbname_temp,$sql);
	$ch_num = mysql_num_rows($result);
}// end if($xsearch == "search"){

### �óդ���Ẻ����٧
	
  ?>
  <form name="form2" method="post" action="">
  <tr>
    <td align="center" bgcolor="#000000">
      <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr>
          <td colspan="7" align="center" bgcolor="#A3B2CC"><table width="100%" border="0" cellspacing="0" cellpadding="3">
		  <? $sql_ticket = "select * from tbl_checklist_assign where ticketid='$TicketId'  AND profile_id='$profile_id' AND activity_id='$activity_id'";
		  		$result_ticket = @mysql_db_query($dbname_temp,$sql_ticket);
				$num_t = @mysql_num_rows($result_ticket);
				$rs_t = @mysql_fetch_assoc($result_ticket);
				
				if($rs_t[date_assign]  != "0000-00-00" and $TicketId != ""){
					$cdate  = $rs_t[date_assign];
				
				}else{
					$cdate = date("Y-m-d");
				}
				
				#### ������͡ʶҹз����������
				if($num_t > 0){
					if($rs_t[localtion_scan] == "IN"){ $select_in = "checked='checked'"; }else{ $select_in = "";}
					if($rs_t[localtion_scan] == "OUT"){ $select_out = "checked='checked'"; }else{ $select_out = "";}
						
				}else{
					$select_in = "checked='checked'";	
					$select_out = "";
				}//end if($num_t > 0){

		  ?>
<!--            <tr>
              <td width="18%" align="left"><strong>ʶҹ���դ��������</strong></td>
              <td width="82%" align="left"><label><input name="localtion_scan" type="radio" value="IN" <?//=$select_in?> >
              
                �᡹����ҧ㹺���ѷ
                <input name="localtion_scan" type="radio" value="OUT" <?//=$select_out?>>
                �᡹����ҧ�͡����ѷ
                </label></td>
            </tr>
-->            <tr>
              <td width="24%" align="left"><strong>�ѹ������ҧ</strong></td>
              <td width="76%" align="left"><INPUT name="c_date" onFocus="blur();" value="<?=sw_date_intxtbox($cdate)?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form2.c_date, 'dd/mm/yyyy')"value="�ѹ��͹��">
           
           </td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td width="9%" align="center" bgcolor="#A3B2CC"><strong>���͡��¡��</strong></td>
          <td width="15%" align="center" bgcolor="#A3B2CC"><strong>���ʻ�Шӵ�ǻ�ЪҪ�</strong></td>
          <td width="17%" align="center" bgcolor="#A3B2CC"><strong>���� - ���ʡ�� </strong></td>
          <td width="22%" align="center" bgcolor="#A3B2CC"><strong>�ç���¹/˹��§ҹ</strong></td>
          <td width="18%" align="center" bgcolor="#A3B2CC"><strong>���˹�</strong></td>
          <td width="11%" align="center" bgcolor="#A3B2CC"><strong>�����Ҫ���</strong></td>
          <td width="8%" align="center" bgcolor="#A3B2CC"><strong>�ӹǹ��</strong></td>
          </tr>
		 <?
		 if($ch_num < 1){
		 	echo "<tr bgcolor='#FFFFFF'><td colspan='7' align='center'>  -��辺��¡�÷����� ��سҵ�Ǩ�ͺ���͹䢡�ä��ա���� - </td></tr>";
		 }else{
		 $j=0;
			$n=0;
		$msg_err = "";
			
		$dis = "";
		$msg = "";
		
		 while($rs = mysql_fetch_assoc($result)){		 
		 	$chassg = CheckAssginSearch($rs[idcard]);// ��Ǩ�ͺ��ҷ���ͺ���§ҹ件١�Ѻ�ͧ���ѧ
		  	if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			if(person_not_assign($rs[idcard],$sent_siteid,"$TicketId",$activity_id) == 0){ // �ʴ�੾�кؤ�ҡ÷���ѧ���١���͡��ҹ���	
			$n++;
			if($rs[status_check_file] == "YES" and $rs[status_file] == "1"){ // 
			
				$dis = "";
				$msg = "";	
			}else{
				$dis = "disabled='disabled'";
				$msg = "<font color='red'>�͡���������ó�</font>";
			}//end if($rs[status_check_file] == "YES" and $rs[status_file] == "1"){ 

			}else{
				
				if($chassg == "0"){
					$bg = "#FFFF00";
				}else if($chassg == "1"){
					$bg = "#009900";
				}else if($chassg == "2"){
					$bg = "#FF0000";	
				}
				$msg = "<img src=\"../../images_sys/alert_icon.png\" width=\"16\" height=\"16\" border=\"0\" title=\"�ͺ���§ҹ����\">";
				$dis = "disabled='disabled'";	
			} // //echo	if(person_not_assign($rs[idcard],$sent_siteid,"$TicketId") == 0){
			
			if($activity_id == "3"){
				####  ��Ǩ�ͺ�ٻ
				if($rs[pic_num] > 0){
				$db_site = "cmss_".$rs[siteid];
				$sql_general_pic = "SELECT COUNT(id) as numpic FROM general_pic WHERE id='$rs[idcard]' group by id";
				//echo $db_site." :: ".$sql_general_pic."<br>";
				$result_general_pic = mysql_db_query($db_site,$sql_general_pic);
				$rspic1 = mysql_fetch_assoc($result_general_pic);
				$numpic_sys = intval($rspic1[numpic]);// �ӹǹ�ٻ��ԧ��к�
				//echo "$rs[pic_num] ::: $numpic_sys<br>";
					if($rs[pic_num] != $numpic_sys){
						$dis = "disabled='disabled'";
						$msg_err .= "<font color='#CC0000'>�ٻ���ú���Ѻ�� $rs[pic_num] �ٻ��������к� $numpic_sys �ٻ</font>";
					}
				}//end 
				
				if($rs[status_doc] == "0"){
							$dis = "disabled='disabled'";
								$msg_err .= "<font color='#CC0000'>ʶҹ��͡����������ó�<font>";
				}
				
				if($rs[page_upload] < 1){ // �������� pdf
						$dis = "disabled='disabled'";	
						$msg_err .= "<font color='#CC0000'>��辺��� �.�. 7 �鹩�Ѻ<font>";
				}

				if($rs[page_upload] > 0 and $rs[page_num] != $rs[page_upload]){
					$dis = "disabled='disabled'";	
					$msg_err .= "<font color='#CC0000'>�ӹǹ���͡��� �.�.���ç�ѹ<br>��ѡ�ҹ�Ѻ�� $rs[page_num] �� �к��Ѻ�� $rs[page_upload] ��</font>";
				}
				

			}//end if($activity_id == "3"){
			
			
					 
			 ### ��Ǩ�ͺʶҹ����  
	
			
		 ?>
        <tr bgcolor="<?=$bg?>">
          <td align="center"><? echo "$j"; echo "$msg";echo "$msg_err";?>
            <input type="checkbox" name="xidcard[<?=$rs[idcard]?>]" value="<?=$rs[idcard]?>" <? if(person_select_assign($rs[idcard],$sent_siteid,"$TicketId") > 0){ echo "checked='checked'";}?> <?=$dis?>>
            <input type="hidden" name="xsiteid[<?=$rs[idcard]?>]" value="<?=$rs[siteid]?>">
            </td>
          <td align="center"><?=$rs[idcard]?></td>
          <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?> 
          <input type="hidden" name="prename_th[<?=$rs[idcard]?>]" value="<? echo "$rs[prename_th]";?>">
          <input type="hidden" name="name_th[<?=$rs[idcard]?>]" value="<? echo "$rs[name_th]";?>">
          <input type="hidden" name="surname_th[<?=$rs[idcard]?>]" value="<? echo "$rs[surname_th]";?>">  
          </td>
          <td align="left"><? echo show_school($rs[schoolid])."/".(str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",show_area($rs[siteid])));?></td>
          <td align="left"><? echo "$rs[position_now]";?></td>
          <td align="center"><? echo floor($rs[age_gov]);?></td>
          <td align="center"><? echo $rs[page_num]?></td>
          </tr>
		  <? 

		  $dis = "";
		  $msg = "";
		  $msg_err = "";
		  
		  }//end while(){
		}// end  if($ch_num < 1){ 
		
		
		?>
        <tr>
          <td colspan="7" align="center" bgcolor="#FFFFFF"><label>
		  <input type="hidden" name="Aaction" value="SAVE">
          <input type="hidden" name="profile_id" value="<?=$profile_id?>">
		   <input type="hidden" name="staffid" value="<?=$staffid?>">
		   <input type="hidden" name="TicketId" value="<?=$TicketId?>">
           <input type="hidden" name="ssiteid" value="<?=$sent_siteid?>">
            <input type="hidden" name="activity_id" value="<?=$activity_id?>">
		    <? if($n < 1){ $dis_s = " disabled=disabled' ";}?>
            <input type="submit" name="Submit2" value="�ѹ�֡" <?=$dis_s?>>
			<input type="button" name="btnB" value="��͹��Ѻ" onClick="location.href='assign_list.php?action=assign_key&xsearch=&staffid=<?=$staffid?>&profile_id=<?=$profile_id?>&activity_id=<?=$activity_id?>'">
          </label></td>
          </tr>
        <tr>
          <td colspan="7" align="center" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="2">
            <tr>
              <td colspan="3" align="left"><em>�����˵� : </em></td>
              </tr>
            <tr>
              <td width="9%" align="right"><img src="../../images_sys/alert_icon.png" alt="" width="16" height="16" border="0" title="�ͺ���§ҹ����"></td>
              <td width="58%"> ��� ʶҹж١�ͺ���§ҹ���º��������</td>
              <td width="33%">&nbsp;</td>
            </tr>
            <tr>
              <td align="right" bgcolor="#009900">������ </td>
              <td>��� �Ѻ�ͺ�ҹ���º��������</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFF00">������ͧ </td>
              <td>��� �ͺ���§ҹ�������ѧ����觧ҹ</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FF0000">��ᴧ</td>
              <td>��� �觧ҹ���</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table>    </td>
  </tr>
  </form>
  <? 
  } // end if($xsearch == "search"){ end ��ǹ�ͧ����ʴ���Ẻ��ä���Ẻ�����´  	
	?>
</table>

<? if($action == "view_person"){
$year1 = (date("Y")+543)."-09-30";

$sql_view = "SELECT
tbl_checklist_assign_detail.ticketid,
tbl_checklist_assign_detail.idcard,
tbl_checklist_kp7.begindate,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.schoolid,
tbl_checklist_kp7.birthday,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.page_num,
tbl_checklist_kp7.profile_id,
(TIMESTAMPDIFF(MONTH,tbl_checklist_kp7.begindate,'$year1')/12) as age_gov
FROM
tbl_checklist_assign_detail
Inner Join tbl_checklist_kp7 ON tbl_checklist_assign_detail.idcard = tbl_checklist_kp7.idcard
WHERE
tbl_checklist_assign_detail.profile_id =  '$profile_id' AND tbl_checklist_assign_detail.ticketid='$ticketid' GROUP  BY tbl_checklist_assign_detail.idcard ORDER BY tbl_checklist_kp7.name_th ASC";
//echo $sql_view;

?><br>

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="7" bgcolor="#A5B2CE"><input type="button" name="btnBB" value="��͹��Ѻ" onClick="location.href='assign_list.php?action=view_main&staffid=<?=$staffid?>&profile_id=<?=$profile_id?>&activity_id=<?=$activity_id?>'">&nbsp;<strong>���ʨ��§ҹ 
          <?=$ticketid?>
          <?=ShowDateProfile($profile_id);?>&nbsp;<? echo "(".ShowActivity($activity_id).")";?></strong></td>
      </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
        <td width="17%" align="center" bgcolor="#A5B2CE"><strong>���ʻ�Шӵ�ǻ�ЪҪ�</strong></td>
        <td width="20%" align="center" bgcolor="#A5B2CE"><strong>���� - ���ʡ�� </strong></td>
        <td width="20%" align="center" bgcolor="#A5B2CE"><strong>�ç���¹/˹��§ҹ</strong></td>
        <td width="24%" align="center" bgcolor="#A5B2CE"><strong>���˹�</strong></td>
        <td width="9%" align="center" bgcolor="#A5B2CE"><strong>�����Ҫ���</strong></td>
        <td width="6%" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ��</strong></td>
      </tr>
	  <? 
		$result = mysql_db_query($db_temp,$sql_view);
		while($rs = mysql_fetch_assoc($result)){
		 if ($k++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$k?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo show_school($rs[schoolid])."/".str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",show_area($rs[siteid]));?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="center"><? echo floor($rs[age_gov]);?></td>
        <td align="center"><? echo "$rs[page_num]";?></td>
      </tr>
	  <?
	  	}// end while(){
	  ?>
    </table></td>
  </tr>
</table>

<? } // end 

	if($action == "assign_detail"){
	$sql = "SELECT * FROM tbl_checklist_assign WHERE ticketid='$TicketId'  AND profile_id='$profile_id' AND activity_id='$activity_id'";
	$result = mysql_db_query($db_temp,$sql);
	$rs = mysql_fetch_assoc($result);
?><br>

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" align="center" bgcolor="#A5B2CE"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="96%" align="center"><strong><? echo "(".ShowActivity($activity_id).")";?></strong><br>
<b><? echo show_user($rs[staffid])." �ѹ��� ".thai_date($rs[date_assign])." ���ʧҹ ".$TicketId;?><br>
<?=ShowDateProfile($profile_id);?>&nbsp;</b></td>
            <td width="4%" align="center" valign="middle"><? if($rs[assign_status] == "N"){?><a href="assign_sentjob.php?ticketid=<?=$TicketId?>&profile_id=<?=$profile_id?>&activity_id=<?=$activity_id?>" target="_blank"><img src="../../images_sys/Refreshb1.png" width="20" height="20" border="0" title="�����������ͺ�ҹ"></a><? }else{ echo "<font color='green'><em>���ͺ�ҹ����</em></font>";}?></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
        <td width="13%" align="center" bgcolor="#A5B2CE"><strong>���ʻ�Шӵ�ǻ�ЪҪ�</strong></td>
        <td width="13%" align="center" bgcolor="#A5B2CE"><strong>���� -���ʡ�� </strong></td>
        <td width="22%" align="center" bgcolor="#A5B2CE"><strong>�ç���¹/˹��§ҹ</strong></td>
        <td width="27%" align="center" bgcolor="#A5B2CE"><strong>���˹�</strong></td>
        <td width="8%" align="center" bgcolor="#A5B2CE"><strong>�����Ҫ���</strong></td>
        <td width="8%" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ��</strong></td>
        <td width="5%" align="center" bgcolor="#A5B2CE"><input type="button" name="btnA" value="����" onClick="location.href='assign_list.php?action=assign_key&staffid=<?=$staffid?>&TicketId=<?=$TicketId?>&profile_id=<?=$profile_id?>&activity_id=<?=$activity_id?>'"></td>
      </tr>
	  <?

$sql_detail = "SELECT * FROM tbl_checklist_assign_detail WHERE ticketid='$TicketId'";
$sql_detail = "SELECT
tbl_checklist_assign_detail.ticketid,
tbl_checklist_assign_detail.idcard,
tbl_checklist_kp7.begindate,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.schoolid,
tbl_checklist_kp7.birthday,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.page_num,
tbl_checklist_kp7.profile_id,
(TIMESTAMPDIFF(MONTH,tbl_checklist_kp7.begindate,'$year1')/12) as age_gov
FROM
tbl_checklist_assign_detail
Inner Join tbl_checklist_kp7 ON tbl_checklist_assign_detail.idcard = tbl_checklist_kp7.idcard
WHERE
 tbl_checklist_assign_detail.ticketid='$TicketId' AND tbl_checklist_kp7.profile_id='$profile_id' GROUP  BY tbl_checklist_assign_detail.idcard ORDER BY tbl_checklist_kp7.name_th ASC ";
//echo $sql_detail;
$result_detail = mysql_db_query($db_temp,$sql_detail);
$k=0;
while($rs = mysql_fetch_assoc($result_detail)){
 if ($k++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}

	  ?>
            <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$k?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo show_school($rs[schoolid])."/".str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",show_area($rs[siteid]));?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="center"><? echo floor($rs[age_gov]);?></td>
        <td align="center"><? echo "$rs[page_num]";?></td>
        <td align="center"><a href="#" onClick="confirmDelete('pupup_delete.php?idcard=<?=$rs[idcard]?>&ticketid=<?=$TicketId?>&staffid=<?=$staffid?>&profile_id=<?=$rs[profile_id]?>&activity_id=<?=$activity_id?>')"><img src="../userentry/images/b_drop.png" width="16" height="16" border="0" title="ź��¡��"></a></td>
      </tr>
	  <?
	}//end while($rs_d = mysql_fetch_assoc($result_detail)){
	  ?>
    </table></td>
  </tr>
</table>
<?
	} //end 
?>
</BODY>
</HTML>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
