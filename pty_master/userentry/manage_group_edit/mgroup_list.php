<?
session_start();
$ApplicationName	= "manage_group_edit";
$module_code 		= "main_group_edit"; 
$process_id			= "manage_group_edit";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110503.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-05-03 15:00
	## Created By :		Mr.Suwat Khamtum
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110503.001 
	## Modified Detail :		�к������èѴ��á���������䢢�����
	## Modified Date :		2011-05-03 15:00
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################



include "config_mgroup.php";
include("../../../common/common_competency.inc.php");

if($action == ""){
	$action = "all";	
}// end 
/*echo "<script>alert('�ѹ�֡������㺧ҹ���º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=assign_detail&TicketId=$TicketId&staffid=$staffid&profile_id=$profile_id';</script>";*/

$report_title = "�����á���������䢢�����";

if($_SERVER['REQUEST_METHOD'] == "GET"){
	####  ź��¡��
	if($action == "all" and $mode == "Del"){
		$check_detail = CountGroupEdit($period_master_id);
		if($check_detail > 0){
				echo "<script>alert('�������öź��¡�������ͧ�ҡ�բ�����㹡�á�˹������ҹ�ͧ���������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='mgroup_list.php?action=all&mode=';</script>";
		}else{
			$sql_del = "DELETE FROM  tbl_assign_edit_period WHERE period_master_id='$period_master_id' ";	
			$result_del = mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."$sql_del<br>LINE::".__LINE__);
			if($result_del){
				echo "<script>alert('ź��¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='mgroup_list.php?action=all&mode=';</script>";	
			}else{
				echo "<script>alert('�������öź��¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='mgroup_list.php?action=all&mode=';</script>";	
			}
		}
			
	}// end 	if($action == "all" and $mode == "Del"){
	## end ź��¡��
	
	
	########  ź��Ǵ��¡������
	if($action == "mgroup" and $mode == "Del"){
		if(CountEditProfile($period_id) > 0){
					echo "<script>alert('�������öź��¡�������ͧ�ҡ�բ�����㹡�á�˹������ҹ����Ѻ���������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='mgroup_list.php?action=mgroup&mode=&period_master_id=$period_master_id';</script>";
		}else{
				$sql_del = "DELETE FROM  tbl_assign_edit_period_detail WHERE period_id='$period_id' ";	
				//echo $sql_del;die;
				$result_del = mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."$sql_del<br>LINE::".__LINE__);		
				if($result_del){
					echo "<script>alert('ź��¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='mgroup_list.php?action=mgroup&mode=&period_master_id=$period_master_id';</script>";	
				}else{
					echo "<script>alert('�������öź��¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='mgroup_list.php?action=mgroup&mode=&period_master_id=$period_master_id';</script>";	
				}

		}// end if(CountEditProfile($period_id) > 0){
			
	}
}// end if($_SERVER['REQUEST_METHOD'] == "GET"){
	
	
if($_SERVER['REQUEST_METHOD'] == "POST"){
	#### �����¡��
	
	if($action == "all" and $xmode == "Edit"){	
		$sql_edit = "UPDATE tbl_assign_edit_period SET periodname='$periodname',status_active='$status_active' WHERE period_master_id='$period_master_id' ";
		$result_edit = mysql_db_query($dbnameuse,$sql_edit) or die(mysql_error()."$sql<br>LINE::".__LINE__);
		if($result_edit){
			echo "<script>alert('�����¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='mgroup_list.php?action=all&mode=';</script>";		
		}else{
			echo "<script>alert('�������ö�����¡����'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='mgroup_list.php?action=all&mode=';</script>";		
		}// end if($result_edit){
	
	}//end if($action == "all" and $mode == "Edit"){	
	#### end �����¡��
	
	####  
	if($action == "all" and $xmode == "Add"){	
		$sql_insert = "INSERT INTO tbl_assign_edit_period SET periodname='$periodname',status_active='$status_active',timeupdate=NOW()";
		$result_insert = mysql_db_query($dbnameuse,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE::".__LINE__);
		if($result_insert){
			echo "<script>alert('�ѹ�֡��¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='mgroup_list.php?action=all&mode=';</script>";		
		}else{
			echo "<script>alert('�������ö�ѹ�֡��¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='mgroup_list.php?action=all&mode=';</script>";		
		}
	
	}//end if($action == "all" and $xmode == "Add"){	
	
	
	########  �������¡������
	if($action == "mgroup" and $xmode == "Add"){	
		if($edit_day == ""){
			$coneday = ",edit_day=NULL";	
		}else{
			$coneday = ",edit_day='$edit_day'";		
		}

		$sql_insert = "INSERT INTO tbl_assign_edit_period_detail SET periodname='$periodname',period_master_id='$period_master_id',start_date='".GetDateDB($start_date)."',end_date='".GetDateDB($end_date)."',start_time='".$st1.":".$st2.":".$st3."',end_time='".$et1.":".$et2.":".$et3."',edit_allnow='$edit_allnow',status_active='$status_active' $coneday";
		mysql_db_query($dbnameuse,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE::".__LINE__);
		echo "<script>alert('�ѹ�֡��¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='mgroup_list.php?action=mgroup&mode=&period_master_id=$period_master_id';</script>";	
		exit();
	}// end 	if($action == "mgroup" and $xmode == "Add"){	
	
	if($action == "mgroup" and $xmode == "Edit"){	
		if($edit_day == ""){
			$coneday = ",edit_day=NULL";	
		}else{
			$coneday = ",edit_day='$edit_day'";		
		}

		$sql_insert = "UPDATE  tbl_assign_edit_period_detail SET periodname='$periodname',period_master_id='$period_master_id',start_date='".GetDateDB($start_date)."',end_date='".GetDateDB($end_date)."',start_time='".$st1.":".$st2.":".$st3."',end_time='".$et1.":".$et2.":".$et3."',edit_allnow='$edit_allnow',status_active='$status_active' $coneday WHERE period_id='$period_id'";
		mysql_db_query($dbnameuse,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE::".__LINE__);
		echo "<script>alert('�����¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='mgroup_list.php?action=mgroup&mode=&period_master_id=$period_master_id';</script>";	
		exit();
	}
	
}//end if($_SERVER['REQUEST_METHOD'] == "POST"){

?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../../common/style.css" rel=StyleSheet type="text/css">
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

function ConfirmListDel(delUrl) {
  if (confirm("�س��㨷���ź���������������?")) {
    document.location = delUrl;
  }
}

</script>

<SCRIPT language=JavaScript>
	
	
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
	

// check from1
function ChF1(){
	if(document.form1.periodname.value == ""){
			alert("��س��кت�����Ǵ��¡��");
			document.form1.periodname.focus();
			return false;
	}	
}
	
// check from 2

function CheckD1(){
		if(document.form2.edit_day.value != ""){
				document.getElementById("radio4").checked=true;
		}
	
}
function ChF2(){
		if(document.form2.periodname.value == ""){
			alert("��س��кت�����Ǵ��¡������");
			document.form2.periodname.focus();
			return false;
		}
		
		
		var d1 = document.form2.start_date.value;
		var d2 = document.form2.end_date.value;
			if(d1 != "" && d2 != ""){
			 p1=d1.split("/");
			 p2=d2.split("/");
			 date1 = p1[2]+""+p1[1]+""+p1[0];
			 date2 = p2[2]+""+p2[1]+""+p2[0];
			 if(date1 > date2){
						alert("�ѹ�������ش��ͧ�����¡����ѹ����������");
						return false;
			}
		}else if(d1 != "" && d2 == ""){
				alert("��س����͡�ѹ�������ش");
						return false;
		}else if(d2 != "" && d1 == ""){
			alert("��س����͡�ѹ����������");
						return false;
		}
		
		
		var td1 = document.form2.st1.value+""+document.form2.st2.value+""+document.form2.st3.value;
		var td2 = document.form2.et1.value+""+document.form2.et2.value+""+document.form2.et3.value;
		//alert(td1+" :: "+td2);return false;
		if(td1 != "000000" && td1 != "" && td2 != "000000" && td2 != ""){
				if(td1 > td2){
						alert("��������ش��ͧ�����¡��������������");
						return false;	
				}
		}else if(td1 != "000000" && td1 != "" && (td2 == "000000" || td2 == "")){
				alert("��س����͡��������ش");
						return false;
		}else if((td1 == "000000" || td1 == "") && td2 != "000000" && td2 != ""){
			alert("��س����͡�����������");
						return false;
		}
		
		if((document.getElementById("radio3").checked == true) && (document.form2.edit_day.value != "" || d1 != "" || d2 != "" || (td1 != "000000" && td1 != "" ) || (td2 != "000000" && td2 != "" )) ){
				alert("ʶҹС����䢢����ŵ�ͧ���͡����䢢����ŵ����ǧ���ҷ���˹���ҹ��\n���ͧ�ҡ�ա�����͡�ѹ�ӡ���ѹ�����������������");
				return false;
		}


		if((document.getElementById("radio4").checked == true) && (document.form2.edit_day.value == "" || d1 == "" || d2 == "" || (td1 == "000000" || td1 == "" ) || (td2 == "000000" || td2 == "" )) ){
				alert("ʶҹС����䢢����ŵ�ͧ���͡����䢢����ŵ�ʹ������ҹ��\n���ͧ�ҡ����ա�����͡�ѹ�ӡ�� �ѹ��������������");
				return false;
		}

		
}

function ClearCal1(){
		document.form2.start_date.value=""
}
function ClearCal2(){
		document.form2.end_date.value=""
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
if($action == "all"){
?>

<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
<?
	if($mode == ""){
?>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="left" valign="middle" bgcolor="#A5B2CE"><strong><img src="dtree/img/group_key.png" width="16" height="16" border="0">&nbsp;�������¡�ê�ǧ������䢢����� �.�.7 </strong></td>
        </tr>
      <tr>
        <td width="9%" align="center" valign="middle" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
        <td width="54%" align="center" valign="middle" bgcolor="#A5B2CE"><strong>���͡������¡��</strong></td>
        <td width="26%" align="center" valign="middle" bgcolor="#A5B2CE"><strong>ʶҹС����ҹ</strong></td>
        <td width="11%" align="center" valign="middle" bgcolor="#A5B2CE"><input type="button" name="AddG" value="������¡��" onClick="location.href='?action=all&mode=Add'" ></td>
      </tr>
      <?
      	$sql = "SELECT * FROM tbl_assign_edit_period  ORDER BY periodname asc";
		$result = mysql_db_query($dbnameuse,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
			$temp_numlist = CountGroupEdit($rs[period_master_id]);
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? if($temp_numlist > 0){?><a href="?action=mgroup&mode=&period_master_id=<?=$rs[period_master_id]?>"><?=$rs[periodname]?></a><? }else{ echo "$rs[periodname]";}?></td>
        <td align="center"><?=$arrimg[$rs[status_active]]?></td>
        <td align="center"><a href="?action=all&mode=Edit&period_master_id=<?=$rs[period_master_id]?>"><img src="../../../images_sys/b_edit.png" width="16" height="16" title="�����¡��" border="0"></a>&nbsp;<a href="#" onClick="return ConfirmListDel('?action=all&mode=Del&period_master_id=<?=$rs[period_master_id]?>');"><img src="../../../images_sys/b_drop.png" width="16" height="16" title="ź��¡��" border="0"></a></td>
      </tr>
      <?
		}// end 
	  ?>
    </table></td>
  </tr>
  <?
	}//end if($mode == ""){
if($mode == "Edit" or  $mode == "Add"){
	if($mode == "Add"){
			$title_from = "������ѹ�֡��Ǵ��¡�ê�ǧ������䢢����� �.�.7";
			$ch1 = "checked='checked'";
			$ch2 = "";
	}else{
			$title_from = "����������Ǵ��¡�ê�ǧ������䢢����� �.�.7";
			$sql_edit = "SELECT * FROM tbl_assign_edit_period WHERE period_master_id='$period_master_id'";
			$result_edit = mysql_db_query($dbnameuse,$sql_edit) or die("$sql_edit<br>LINE::".__LINE__);
			$rse = mysql_fetch_assoc($result_edit);
			if($rse[status_active] == "1"){ $ch1 =  "checked='checked'"; }else{ $ch1 = "";}
			if($rse[status_active] == "0"){ $ch2 =  "checked='checked'"; }else{ $ch2 = "";}
	}
  ?>
  <form name="form1" method="post" action="" onSubmit="return ChF1();">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="2" align="left" bgcolor="#A5B2CE"><a href="?action=all&mode="><img src="../../../images_sys/home.gif" width="20" height="20" border="0" title="��͹��Ѻ" ></a> <strong><?=$title_from?>
          </strong></td>
        </tr>
      <tr>
        <td width="18%" align="right" bgcolor="#EFEFFF">���͡������¡�� : </td>
        <td width="82%" align="left" bgcolor="#EFEFFF">
          <input name="periodname" type="text" id="periodname" size="50" value="<?=$rse[periodname]?>"></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF">ʶҹС����ҹ : </td>
        <td align="left" bgcolor="#EFEFFF"><input type="radio" name="status_active" id="radio" value="1" <?=$ch1?>>
          �Դ�����ҹ
         
            <input type="radio" name="status_active" id="radio2" value="0" <?=$ch2?>>
            �Դ�����ҹ
          </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF">&nbsp;</td>
        <td align="left" bgcolor="#EFEFFF"><input type="submit" name="button" id="button" value="�ѹ�֡">
        <input type="hidden" name="period_master_id" value="<?=$period_master_id?>">
        <input type="hidden" name="xmode" value="<?=$mode?>">
          <input type="reset" name="button2" id="button2" value="��ҧ���"></td>
      </tr>
    </table></td>
  </tr>
  </form>
  <?
}//end if($mode == "Edit" or  $mode == "Add"){
  ?>
</table>
<?
}//end if($action == "all"){

if($action == "mgroup"){
?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
<?
	if($mode == ""){
?>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="10" align="left" bgcolor="#A5B2CE"><a href="?action=all&mode="><img src="../../../images_sys/home.gif" width="20" height="20" border="0" title="��͹��Ѻ"></a>&nbsp;<strong>�������¡�� : <?=GetGroupPeriodName($period_master_id);?></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
        <td width="16%" align="center" bgcolor="#A5B2CE"><strong>������¡������</strong></td>
        <td width="11%" align="center" bgcolor="#A5B2CE"><strong>�ѹ㹡�����<br>
        (�.- �.)</strong></td>
        <td width="11%" align="center" bgcolor="#A5B2CE"><strong>�ѹ����������</strong></td>
        <td width="11%" align="center" bgcolor="#A5B2CE"><strong>�ѹ�������ش</strong></td>
        <td width="12%" align="center" bgcolor="#A5B2CE"><strong>�����������</strong></td>
        <td width="12%" align="center" bgcolor="#A5B2CE"><strong>��������ش</strong></td>
        <td width="6%" align="center" bgcolor="#A5B2CE"><strong>ʶҹС��<br>
��䢢�����</strong></td>
        <td width="9%" align="center" bgcolor="#A5B2CE"><strong>ʶҹС��<br>
          ��ҹ</strong></td>
        <td width="8%" align="center" bgcolor="#A5B2CE"><input type="button" name="AddG" value="������¡��" onClick="location.href='?action=mgroup&mode=Add&period_master_id=<?=$period_master_id?>'" ></td>
      </tr>
      <?
      	$sql  = "SELECT * FROM tbl_assign_edit_period_detail WHERE period_master_id='$period_master_id' ORDER BY periodname ASC";
		$result = mysql_db_query($dbnameuse,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[periodname]?></td>
        <td align="center"><? if($arrday[$rs[edit_day]] != ""){ echo $arrday[$rs[edit_day]];}else{ echo "-";}?></td>
        <td align="center"><?=GetThaiDateS($rs[start_date]);?></td>
        <td align="center"><?=GetThaiDateS($rs[end_date]);?></td>
        <td align="center"><? echo GetTimeS($rs[start_time]);?></td>
        <td align="center"><? echo GetTimeS($rs[end_time]);?></td>
        <td align="center"><?=$arrimg[$rs[edit_allnow]]?></td>
        <td align="center"><?=$arrimg[$rs[status_active]]?></td>
        <td align="center"><a href="?action=mgroup&mode=Edit&period_id=<?=$rs[period_id]?>&period_master_id=<?=$period_master_id?>"><img src="../../../images_sys/b_edit.png" width="16" height="16" title="�����¡��" border="0"></a>&nbsp;<a href="#" onClick="return ConfirmListDel('?action=mgroup&mode=Del&period_id=<?=$rs[period_id]?>&period_master_id=<?=$period_master_id?>');"><img src="../../../images_sys/b_drop.png" width="16" height="16" title="ź��¡��" border="0"></a></td>
      </tr>
      <?
		}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  <?
	}//end if($mode == ""){
	if($mode == "Add" or $mode == "Edit"){
		
		if($mode == "Add"){
				$title_from = "��������������Ţͧ�������¡�� ".GetGroupPeriodName($period_master_id);
				$ch1 = "checked='checked'";
				$ch2 = "";
				$ch3 = "checked='checked'";
				$ch4 = "";
		}else{
				$title_from = "�������䢢����Ţͧ�������¡�� ".GetGroupPeriodName($period_master_id);		
				$sql_edit = "SELECT * FROM tbl_assign_edit_period_detail WHERE period_id='$period_id'";
				$result_edit = mysql_db_query($dbnameuse,$sql_edit) or die(mysql_error()."$sql_edit<br>LINE::".__LINE__);
				$rse = mysql_fetch_assoc($result_edit);
				
			if($rse[status_active] == "1"){ $ch1 =  "checked='checked'"; }else{ $ch1 = "";}
			if($rse[status_active] == "0"){ $ch2 =  "checked='checked'"; }else{ $ch2 = "";}
			
			if($rse[edit_allnow] == "1"){ $ch3 =  "checked='checked'"; }else{ $ch3 = "";}
			if($rse[edit_allnow] == "0"){ $ch4 =  "checked='checked'"; }else{ $ch4 = "";}
			$start_date = $rse[start_date];
			$end_date = $rse[end_date];
				$arrt1 = explode(":",$rse[start_time]);
				$arrt2 = explode(":",$rse[end_time]);
				
			

		}	
  ?>
  <form name="form2" method="post" action="" onSubmit="return ChF2();">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="2" align="left" bgcolor="#A5B2CE"><a href="?action=mgroup&mode=&period_master_id=<?=$period_master_id?>"><img src="../../../images_sys/home.gif" width="20" height="20" border="0" title="��͹��Ѻ" ></a>&nbsp;<strong>�������¡�� : <?=$title_from?></strong></td>
        </tr>
      <tr>
        <td width="18%" align="right" bgcolor="#EFEFFF">������¡������ : </td>
        <td width="82%" align="left" bgcolor="#EFEFFF">
          <input name="periodname" type="text" id="textfield" value="<?=$rse[periodname]?>" size="50"></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF">�ѹ㹡�����(�. - �.) : </td>
        <td align="left" bgcolor="#EFEFFF">
          <select name="edit_day" id="edit_day" onChange="return CheckD1()">
          <option value="">�к��ѹ���</option>
          <?
          	if(count($arrday) > 0){
					foreach($arrday as $key => $val){
					
						if($key == $rse[edit_day] and $rse[edit_day] != ""){ $sel = "selected='selected'";}else{  $sel = "";}
							echo "<option value='$key' $sel>$val</option>";
					}//end foreach($arrday as $key => $val){
			}
		  ?>
          </select></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF">�ѹ���������� : </td>
        <td align="left" bgcolor="#EFEFFF"><INPUT name="start_date" onFocus="blur();" value="<?=GetDateFrom($start_date)?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form2.start_date, 'dd/mm/yyyy')"value="�ѹ��͹��">
            <input type="button" name="button5" id="button5" value="��ҧ��һ�ԷԹ" onClick="return ClearCal1();"></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF">�ѹ�������ش : </td>
        <td align="left" bgcolor="#EFEFFF"><INPUT name="end_date" onFocus="blur();" value="<?=GetDateFrom($end_date)?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form2.end_date, 'dd/mm/yyyy')"value="�ѹ��͹��">
            <input type="button" name="button6" id="button6" value="��ҧ��һ�ԷԹ" onClick="return ClearCal2();"></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF">����������� : </td>
        <td align="left" bgcolor="#EFEFFF">
          <select name="st1" id="st1">
          <option value="">�������</option>
          <?
          	for($i1=0;$i1 < 24;$i1++){
					$t1 = sprintf("%02d",$i1);
					if($t1 == $arrt1[0]){ $sel = "selected='selected'";}else{ $sel = "";}
					echo "<option value='$t1'$sel>$t1</option>";
			}
		  ?>
          </select>
      
          <select name="st2" id="st2">
             <option value="">�ҷ�</option>
          <?
          	for($i2=0;$i2 < 60;$i2++){
					$t2 = sprintf("%02d",$i2);
					if($t2 == $arrt1[1]){ $sel = "selected='selected'";}else{ $sel = "";}
					echo "<option value='$t2' $sel>$t2</option>";
			}
		  ?>

          </select>
       
          <select name="st3" id="st3">
               <option value="">�Թҷ�</option>
          <?
          	for($i3=0;$i3 < 60;$i3++){
					$t3 = sprintf("%02d",$i3);
					if($t3 == $arrt1[2]){ $sel = "selected='selected'";}else{ $sel = "";}
					echo "<option value='$t3' $sel>$t3</option>";
			}
		  ?>

          </select>
          </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF">��������ش : </td>
        <td align="left" bgcolor="#EFEFFF">
          <select name="et1" id="et1">
          <option value="">�������</option>
          <?
          	for($i1=0;$i1 < 24;$i1++){
					$t1 = sprintf("%02d",$i1);
					if($t1 == $arrt2[0]){ $sel = "selected='selected'";}else{ $sel = "";}
					echo "<option value='$t1' $sel>$t1</option>";
			}
		  ?>
          </select>
      
          <select name="et2" id="et2">
             <option value="">�ҷ�</option>
          <?
          	for($i2=0;$i2 < 60;$i2++){
					$t2 = sprintf("%02d",$i2);
					if($t2 == $arrt2[1]){ $sel = "selected='selected'";}else{ $sel = "";}
					echo "<option value='$t2' $sel>$t2</option>";
			}
		  ?>

          </select>
       
          <select name="et3" id="et3">
               <option value="">�Թҷ�</option>
          <?
          	for($i3=0;$i3 < 60;$i3++){
					$t3 = sprintf("%02d",$i3);
					if($t3 == $arrt2[2]){ $sel = "selected='selected'";}else{ $sel = "";}
					echo "<option value='$t3' $sel>$t3</option>";
			}
		  ?>

          </select>          
          </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF">ʶҹС����䢢����� : </td>
        <td align="left" bgcolor="#EFEFFF"><input type="radio" name="edit_allnow" id="radio3" value="1" <?=$ch3?>>
        ��䢢����ŵ�ʹ����
          <input type="radio" name="edit_allnow" id="radio4" value="0" <?=$ch4?>>
          ��䢢����ŵ����ǧ���ҷ���˹�
          </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF">ʶҹС����ҹ : </td>
        <td align="left" bgcolor="#EFEFFF"><input type="radio" name="status_active" id="radio5" value="1" <?=$ch1?>>
         �Դ�����ҹ
          <input type="radio" name="status_active" id="radio6" value="0" <?=$ch2?>>
          �Դ�����ҹ</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF">&nbsp;</td>
        <td align="left" bgcolor="#EFEFFF"><input type="submit" name="button3" id="button3" value="�ѹ�֡">
          <input type="reset" name="button4" id="button4" value="��ҧ������">
          <input type="hidden" name="period_master_id" value="<?=$period_master_id?>">
          <input type="hidden" name="xmode" value="<?=$mode?>">
          <input type="hidden" name="action" value="mgroup">
          </td>
      </tr>
    </table></td>
  </tr>
  </form>
  <?
	}//end if($mode == "Add" or $mode == "Edit"){
  ?>
</table>
<?
}//end if($action == "mgroup"){
if($action == "mgroup_view"){
	$sql = "SELECT * FROM tbl_assign_edit_period_detail WHERE period_id='$period_id'";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="2" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="95%" align="left"><a href="?action=mgroup&mode=&period_master_id=<?=$period_master_id?>"><img src="../../../images_sys/home.gif" width="20" height="20" border="0" title="��͹��Ѻ"></a>&nbsp;<strong>�������¡�� :<?=GetGroupPeriodName($period_master_id)?></strong></td>
            <td width="2%" align="center"><? if($xtype != "view"){?><a href="?action=mgroup&mode=Edit&period_id=<?=$period_id?>&period_master_id=<?=$period_master_id?>"><img src="../../../images_sys/b_edit.png" width="16" height="16" title="�����¡��" border="0"></a><? }//endif($xtype != "view"){ ?></td>
            <td width="3%" align="center"><? if($xtype != "view"){ ?><a href="#" onClick="return ConfirmListDel('?action=mgroup&mode=Del&period_id=<?=$period_id?>&period_master_id=<?=$period_master_id?>');"><img src="../../../images_sys/b_drop.png" width="16" height="16" title="ź��¡��" border="0"></a><? }//end if($xtype != "view"){?></td>
            </tr>
        </table></td>
        </tr>
      <tr>
        <td width="19%" align="right" bgcolor="#EFEFFF"><strong>������¡������ :</strong></td>
        <td width="81%" align="left" bgcolor="#EFEFFF"><?=$rs[periodname]?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF"><strong>�ѹ㹡�����(�. - �.) : </strong></td>
        <td align="left" bgcolor="#EFEFFF"><? if($arrday[$rs[edit_day]] != ""){ echo $arrday[$rs[edit_day]];}else{ echo "-";}?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF"><strong>�ѹ���������� : </strong></td>
        <td align="left" bgcolor="#EFEFFF"><?=GetThaiDateS($rs[start_date]);?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF"><strong>�ѹ�������ش : </strong></td>
        <td align="left" bgcolor="#EFEFFF"><?=GetThaiDateS($rs[end_date]);?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF"><strong>����������� : </strong></td>
        <td align="left" bgcolor="#EFEFFF"><? echo GetTimeS($rs[start_time]);?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF"><strong>��������ش : </strong></td>
        <td align="left" bgcolor="#EFEFFF"><? echo GetTimeS($rs[end_time]);?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF"><strong>ʶҹС����䢢����� : </strong></td>
        <td align="left" bgcolor="#EFEFFF"><?=$arrimg[$rs[edit_allnow]]?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF"><strong>ʶҹС����ҹ : </strong></td>
        <td align="left" bgcolor="#EFEFFF"><?=$arrimg[$rs[status_active]]?></td>
      </tr>
    </table></td>
  </tr>
</table>
<?
}
?>
</BODY>
</HTML>
