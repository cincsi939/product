<?
session_start();
$ApplicationName	= "profile_group_edit";
$module_code 		= "profile_group_edit"; 
$process_id			= "profile_group_edit";
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

	########  ź��Ǵ��¡������
	if($action == "mgroup" and $mode == "Del"){
				$sql_del = "DELETE FROM  keystaff_qc_math_key WHERE staffqc='$staffqc' AND staffkey='$staffid' ";	
				$result_del = mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."$sql_del<br>LINE::".__LINE__);		
				if($result_del){
					echo "<script>alert('ź��¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='profile_list.php?action=mgroup&mode=&staffqc=$staffqc&fullname=$fullname';</script>";	
				}else{
					echo "<script>alert('�������öź��¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='profile_list.php?action=mgroup&mode=&staffqc=$staffqc&fullname=$fullname';</script>";	
				}

			
	}// end 	if($action == "mgroup" and $mode == "Del"){
}// end if($_SERVER['REQUEST_METHOD'] == "GET"){
	
	
if($_SERVER['REQUEST_METHOD'] == "POST"){
	#### �����¡��
	
	if($action == "all" and $xmode == "Edit"){	
	

				$sql_delstaff = "DELETE FROM keystaff_qc_math_key WHERE staffqc='$staffqc'";
				mysql_db_query($dbnameuse,$sql_delstaff) or die(mysql_error()."$sql<br>LINE::".__LINE__);
			if(count($arrstaff) > 0){
				
				foreach($arrstaff as $key => $val){
						$sql_update_staff =  "REPLACE INTO keystaff_qc_math_key SET staffkey='$key',staffqc='$staffqc'";
						mysql_db_query($dbnameuse,$sql_update_staff) or die(mysql_error()."$sql_update_staff<br>LINE::".__LINE__);
				}//end foreach($arrstaff as $key => $val){	
			}// end if(count($arrstaff) > 0){
		
		if($result_edit){
			echo "<script>alert('�����¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='profile_list.php?action=all&mode=';</script>";		
		}else{
			echo "<script>alert('�������ö�����¡����'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='profile_list.php?action=all&mode=';</script>";		
		}// end if($result_edit){
	
	}//end if($action == "all" and $mode == "Edit"){	
	#### end �����¡��
	
	####  
	if($action == "all" and $xmode == "Add"){	
				$sql_delstaff = "DELETE FROM keystaff_qc_math_key WHERE staffqc='$staffqc'";
				mysql_db_query($dbnameuse,$sql_delstaff) or die(mysql_error()."$sql<br>LINE::".__LINE__);
			if(count($arrstaff) > 0){
				
				foreach($arrstaff as $key => $val){
						$sql_update_staff =  "REPLACE INTO keystaff_qc_math_key SET staffkey='$key',staffqc='$staffqc' ";
						mysql_db_query($dbnameuse,$sql_update_staff) or die(mysql_error()."$sql_update_staff<br>LINE::".__LINE__);
				}//end foreach($arrstaff as $key => $val){	
			}// end if(count($arrstaff) > 0){

		
		if($result_insert){
			echo "<script>alert('�ѹ�֡��¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='profile_list.php?action=all&mode=';</script>";		
		}else{
			echo "<script>alert('�������ö�ѹ�֡��¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='profile_list.php?action=all&mode=';</script>";		
		}
	
	}//end if($action == "all" and $xmode == "Add"){	
	
	
	########  �������¡������
	if($action == "mgroup" and $xmode == "Add"){	
	
				$sql_delstaff = "DELETE FROM keystaff_qc_math_key WHERE staffqc='$staffqc'";
				mysql_db_query($dbnameuse,$sql_delstaff) or die(mysql_error()."$sql<br>LINE::".__LINE__);
			if(count($arrstaff) > 0){
				
				foreach($arrstaff as $key => $val){
						$sql_update_staff =  "REPLACE INTO keystaff_qc_math_key SET staffkey='$key',staffqc='$staffqc'";
						mysql_db_query($dbnameuse,$sql_update_staff) or die(mysql_error()."$sql_update_staff<br>LINE::".__LINE__);
				}//end foreach($staffid as $key => $val){	
			}// end		if(count($arrstaff) > 0){

		
		
		echo "<script>alert('�ѹ�֡��¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='profile_list.php?action=mgroup&mode=&staffqc=$staffqc&fullname=$fullname';</script>";	
		exit();
	}// end 	if($action == "mgroup" and $xmode == "Add"){	
	
	if($action == "mgroup" and $xmode == "Edit"){	
				$sql_delstaff = "DELETE FROM keystaff_qc_math_key WHERE staffqc='$staffqc'";
				mysql_db_query($dbnameuse,$sql_delstaff) or die(mysql_error()."$sql<br>LINE::".__LINE__);
			if(count($arrstaff) > 0){
				
				foreach($arrstaff as $key => $val){
						$sql_update_staff =  "REPLACE INTO keystaff_qc_math_key SET staffkey='$key',staffqc='$staffqc'";
						mysql_db_query($dbnameuse,$sql_update_staff) or die(mysql_error()."$sql_update_staff<br>LINE::".__LINE__);
				}//end foreach($staffid as $key => $val){	
			}// end		if(count($arrstaff) > 0){
		echo "<script>alert('�����¡�����º��������'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='profile_list.php?action=mgroup&mode=&staffqc=$staffqc&fullname=$fullname';</script>";	
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
<script language="javascript" src="../../../common/jquery_1_3_2.js"></script>
<script language="javascript">

function checkAll(){
	checkall('tbldata',1);
}//end function checkAll(){

function UncheckAll(){
	checkall('tbldata',0);	
}

function checkall(context, status){	
	$("#"+context).find("input[type$='checkbox']").each(function(){
				$(this).attr('checked', status);	
	});
	
}//end function checkall(context, status){	



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
   var mid = document.getElementById("txt_period_master_id").value;
    if(mid == "" ) {
        clearproductList();
        return;
    }
    var url = "ajax_period.php?mid=" + mid;
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
    var pid = document.getElementById("txt_period_id");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
		
		option = document.createElement("option");
		   option.setAttribute("value",0);
           option.appendChild(document.createTextNode("����к�"));
           pid.appendChild(option);


    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
		  	option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           pid.appendChild(option);
	}
    }
}

function clearproductList() {
    var pid = document.getElementById("txt_period_id");
    while(pid.childNodes.length > 0) {
              pid.removeChild(pid.childNodes[0]);
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
	if(document.form1.profile_edit_name.value == ""){
			alert("��س��кت������������䢢����� �.�.7");
			document.form1.profile_edit_name.focus();
			return false;
	}	
	if(document.form1.txt_period_master_id.value == ""){
		alert("��س��кت��͡������¡����䢢����� �.�.7");
			document.form1.txt_period_master_id.focus();
			return false;	
	}
	
		if(document.form1.txt_period_id.value == ""){
		alert("��س��кت��͡������¡��������䢢����� �.�.7");
			document.form1.txt_period_id.focus();
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
	
	
function ShowTableStaff(){

            document.getElementById("tblstaff").style.display = 'block';
      
}
	
function HiddenTableStaff(){

            document.getElementById("tblstaff").style.display = 'none';
      
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
        <td colspan="4" align="left" valign="middle" bgcolor="#A5B2CE"><strong><img src="dtree/img/group_key.png" width="16" height="16" border="0">&nbsp;�����ž�ѡ�ҹ��Ǩ�ͺ�͡���(QC)</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" valign="middle" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
        <td width="49%" align="center" valign="middle" bgcolor="#A5B2CE"><strong>��ѡ�ҹ��Ǩ�ͺ�͡��� �.�.7 (QC)</strong></td>
        <td width="37%" align="center" valign="middle" bgcolor="#A5B2CE"><strong>�ӹǹ��ѡ�ҹ<br>
          㹷���ͧ QC(��)</strong></td>
        <td width="10%" align="center" valign="middle" bgcolor="#A5B2CE">&nbsp;</td>
      </tr>
      <?
      	$sql = "SELECT  * FROM  keystaff   WHERE status_permit='YES' AND status_extra LIKE '%QC%'  AND sapphireoffice='0'   ORDER BY staffname  ASC,staffsurname ASC";
		$result = mysql_db_query($dbnameuse,$sql);
		$i=0;
		$arrnumstaff = CountStaffProfile();
		while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
			$fullname = "$rs[prename]$rs[staffname] $rs[staffsurname]";
			$temp_numlist = $arrnumstaff[$rs[staffid]];
			
			
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? if($temp_numlist > 0){?><a href="?action=mgroup&mode=&staffqc=<?=$rs[staffid]?>&fullname=<?=$fullname?>"><?=$fullname?></a><? }else{ echo "$fullname";}?></td>
        <td align="center"><? if($temp_numlist > 0){ echo "<a href=\"?action=mgroup&mode=&staffqc=$rs[staffid]&fullname=$fullname\">".$temp_numlist."</a>";}else{ echo "0";}?></td>
        <td align="center"><a href="?action=mgroup&mode=Add&staffqc=<?=$rs[staffid]?>&fullname=<?=$fullname?>"><img src="../../validate_management/images/status_online.png" width="16" height="16" border="0" title="������§�����ž�ѡ�ҹ�ѹ�֡�����šѺ��ѡ�ҹ��Ǩ�ͺ�͡��� �.�.7"></a></td>
      </tr>
      <?
		}// end 
	  ?>
    </table></td>
  </tr>
  <?
	}//end if($mode == ""){
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
        <td colspan="4" align="left" bgcolor="#A5B2CE"><a href="?action=all&mode="><img src="../../../images_sys/home.gif" width="20" height="20" border="0" title="��͹��Ѻ"></a>&nbsp;<strong>���;�ѡ�ҹ��Ǩ�ͺ�͡��� (QC) : 
          <?=$fullname;?></strong></td>
        </tr>
      <tr>
        <td width="6%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
        <td width="34%" align="center" bgcolor="#A5B2CE"><strong>���;�ѡ�ҹ</strong></td>
        <td width="49%" align="center" bgcolor="#A5B2CE"><strong>�������ѡ�ҹ</strong></td>
        <td width="11%" align="center" bgcolor="#A5B2CE"><input type="button" name="AddG" value="������¡��" onClick="location.href='?action=mgroup&mode=Add&staffqc=<?=$staffqc?>&fullname=<?=$fullname?>'" ></td>
      </tr>
      <?
      	$sql  = "SELECT
t1.staffid,
t1.prename,
t1.staffname,
t1.staffsurname,
t2.staffqc,
t3.groupkey_id,
t3.groupname,
t1.ratio_id
FROM
keystaff as t1
Inner Join keystaff_qc_math_key as t2 ON t1.staffid = t2.staffkey
Left Join keystaff_group as t3 ON t1.keyin_group=t3.groupkey_id
WHERE t2.staffqc='$staffqc'
ORDER BY 
t1.staffname ASC,
t1.staffsurname ASC";
//echo $sql;
		$result = mysql_db_query($dbnameuse,$sql);
		$i=0;
		$arrratio = GetRatio();// �ʴ��ѵ����ǹ��� QC
		while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
			$xfullname = "$rs[prename]$rs[staffname]  $rs[staffsurname]";
			
			
			

	
	if($rs[groupkey_id] == "2" or $rs[groupkey_id] == "5"){
			$txt_ratio = " �ѵ����ǹ 1:20";
	}else{
			$txt_ratio = $arrratio[$rs[ratio_id]];
	}
	
	if($txt_ratio == ""){
			$txt_ratio = " �ѵ����ǹ 1:20";
	}// end 	if($rs[groupkey_id] == "2" or $rs[groupkey_id] == "5"){

			
			
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$xfullname?></td>
        <td align="center"><? if($rs[groupname] != ""){ echo "$rs[groupname] ($txt_ratio)";}else{ echo "";}?></td>
        <td align="center"><a href="#" onClick="return ConfirmListDel('?action=mgroup&mode=Del&staffqc=<?=$rs[staffqc]?>&staffid=<?=$rs[staffid]?>&fullname=<?=$fullname?>');"><img src="../../../images_sys/b_drop.png" width="16" height="16" title="ź��¡��" border="0"></a></td>
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
				$title_from = "�����������ѡ�ҹ�ѹ�֡����������Ѻ��� QC �ͧ ".$fullname;
		}else{
				$title_from = "�������䢾�ѡ�ҹ�ѹ�֡����������Ѻ��� QC �ͧ ".$fullname;
		}	
		
		$arrstaff =  GetStaffProfile($staffqc);
  ?>
  <form name="form2" method="post" action="" >
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="2" align="left" bgcolor="#A5B2CE"><a href="?action=mgroup&mode=&staffqc=<?=$staffqc?>&fullname=<?=$fullname?>"><img src="../../../images_sys/home.gif" width="20" height="20" border="0" title="��͹��Ѻ"></a>&nbsp;<strong> <?=$title_from?></strong></td>
        </tr>
      <tr>
        <td width="18%" align="right" valign="top" bgcolor="#EFEFFF"><strong>��ѡ�ҹ���������</strong> : </td>
        <td width="82%" align="left" bgcolor="#EFEFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3" id="tbldata">
          <tr>
            <td width="7%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
            <td width="35%" align="center" bgcolor="#A5B2CE"><strong>����- ���ʡ�ž�ѡ�ҹ</strong></td>
            <td width="34%" align="center" bgcolor="#A5B2CE"><strong>�������÷ӧҹ</strong></td>
            <td width="24%" align="center" bgcolor="#A5B2CE"><a href="#" onClick="checkAll()" style="font-weight:bold">���͡������</a>/<a href="#" onClick="UncheckAll()"  style="font-weight:bold">������͡������</a></td>
          </tr>
          <?
                  	$sql_staff = "SELECT
t1.staffid,
t1.prename,
t1.staffname,
t1.staffsurname,
t2.status_editkey,
t2.groupkey_id,
t2.groupname,
t1.status_extra,
t1.ratio_id
FROM
keystaff as t1
Inner Join keystaff_group as t2 ON t1.keyin_group = t2.groupkey_id
WHERE t1.status_permit='YES' 
AND t1.status_extra='NOR'  and sapphireoffice<>'1'
GROUP BY t1.staffid
ORDER BY t2.groupname ASC, t1.staffname ASC,t1.staffsurname ASC";
	$result_staff = mysql_db_query($dbnameuse,$sql_staff) or die(mysql_error()."$sql_staff<br>LINE::".__LINE__);
	$i=0;
	$arrratio = GetRatio();// �ʴ��ѵ����ǹ��� QC
	while($rs = mysql_fetch_assoc($result_staff)){
	if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
	
	if($arrstaff[$rs[staffid]] != ""){ $check2 = " checked='checked'";}else{ $check2 = "";}
	
	if($rs[groupkey_id] == "2" or $rs[groupkey_id] == "5"){
			$txt_ratio = " �ѵ����ǹ 1:20";
	}else{
			$txt_ratio = $arrratio[$rs[ratio_id]];
	}
	
	if($txt_ratio == ""){
			$txt_ratio = " �ѵ����ǹ 1:20";
	}// end 	if($rs[groupkey_id] == "2" or $rs[groupkey_id] == "5"){
				  ?>
          <tr bgcolor="<?=$bg?>">
            <td align="center"><?=$i?></td>
            <td align="left"><? echo "$rs[prename]$rs[staffname] $rs[staffsurname]";?></td>
            <td align="left"><? if($rs[groupname] != ""){ echo "$rs[groupname] ($txt_ratio)";}else{ echo "$rs[status_extra]";}?></td>
            <td align="center"><input type="checkbox" name="arrstaff[<?=$rs[staffid]?>]" id="<?=$rs[staffid]?>" value="<?=$rs[staffid]?>" <?=$check2?>></td>
          </tr>
          <?
					}//end 
				  ?>
        </table></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF">&nbsp;</td>
        <td align="left" bgcolor="#EFEFFF"><input type="submit" name="button3" id="button3" value="�ѹ�֡">
          <input type="reset" name="button4" id="button4" value="��ҧ������">
          <input type="hidden" name="staffqc" value="<?=$staffqc?>">
          <input type="hidden" name="xmode" value="<?=$mode?>">
          <input type="hidden" name="fullname" value="<?=$fullname?>">
          <input type="hidden" name="action" value="mgroup">
          </td>
      </tr>
    </table></td>
  </tr>
  </form>
  <?
  unset($arrstaff);
	}//end if($mode == "Add" or $mode == "Edit"){
  ?>
</table>
<?
}//end if($action == "mgroup"){
if($action == "mgroup_view"){
	$sql = "SELECT
t1.staffid,
t1.prename,
t1.staffname,
t1.staffsurname,
t2.groupname,
t1.email,
t1.sex,
t1.telno
FROM keystaff as t1 
Left Join keystaff_group as t2 ON t1.keyin_group = t2.groupkey_id
WHERE t1.staffid='$staffid' ";
//echo $sql;
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="2" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="95%" align="left"><a href="?action=mgroup&mode=&staffqc=<?=$staffqc?>&fullname=<?=$fullname?>"><img src="../../../images_sys/home.gif" width="20" height="20" border="0" title="��͹��Ѻ"></a>&nbsp;<strong>���;�ѡ�ҹ��Ǩ�ͺ�͡��� (QC) : 
          <?=$fullname;?>
            </strong></td>
            </tr>
        </table></td>
        </tr>
      <tr>
        <td width="19%" align="right" bgcolor="#EFEFFF"><strong>�ӹ�˹�Ҫ��� :</strong></td>
        <td width="81%" align="left" bgcolor="#EFEFFF"><?=$rs[prename]?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF"><strong> ����: </strong></td>
        <td align="left" bgcolor="#EFEFFF"><? echo "$rs[staffname]";?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF"><strong>���ʡ�� : </strong></td>
        <td align="left" bgcolor="#EFEFFF"><? echo "$rs[staffsurname]";?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF"><strong>�� : </strong></td>
        <td align="left" bgcolor="#EFEFFF"><?=$arrsex[$rs[sex]]?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF"><strong>������� : </strong></td>
        <td align="left" bgcolor="#EFEFFF"><? echo $rs[email]?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF"><strong>�������Ѿ�� : </strong></td>
        <td align="left" bgcolor="#EFEFFF"><? echo $rs[telno]?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EFEFFF"><strong>�������÷ӧҹ : </strong></td>
        <td align="left" bgcolor="#EFEFFF"><?=$rs[groupname]?></td>
      </tr>
    </table></td>
  </tr>
</table>
<?
}
?>
</BODY>
</HTML>
