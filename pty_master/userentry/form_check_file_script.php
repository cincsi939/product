<?
/*****************************************************************************
Function		: �ͺ���¡�ä�������� �.�.7 ���Ѻ�����
Version			: 1.0
Last Modified	: 22/05/2552
Changes		:
*****************************************************************************/
include "epm.inc.php";
include("function_assign.php");

$pos_code_k = "'19','20','21','24','25','23','22','26','27','28'"; // ���ʢͧ���
$arr_site_admin = array('7103'=>'7103','6502'=>'6502','8602'=>'8602','6301'=>'6301','5101'=>'5101','7002'=>'7002','5701'=>'5701','6702'=>'6702','7203'=>'7203','4802'=>'4802','7302'=>'7302','3303'=>'3303');

function count_check_pdf($type,$secid){
	global $dbnamemaster;
	$sql_c = "SELECT COUNT(status_file) AS  NUM1 FROM log_pdf_check WHERE status_file='$type' and secid='$secid' ";
	//echo $sql_c;
	$result_c = mysql_db_query($dbnamemaster,$sql_c);
	$rs_c =mysql_fetch_assoc($result_c);
	return $rs_c[NUM1];
}
function show_schoolname($siteid,$schoolid){
$tbl_name = "school_".$siteid;
	$sql_s = "SELECT S_NAME  FROM $tbl_name WHERE I_CODE='$schoolid'";
	$result_s = mysql_db_query("temp_pobec_import",$sql_s);
	$rs_s = mysql_fetch_assoc($result_s);
	return $rs_s[S_NAME];
}


if($_SERVER['REQUEST_METHOD'] == "POST"){
		if($Aaction == "SAVE"){
						$sql_check = "SELECT COUNT(secid) AS NUMC1 FROM log_pdf_check WHERE secid = '$temp_siteid'";
						$result_check = mysql_db_query($dbnamemaster,$sql_check);
						$rs_c = mysql_fetch_assoc($result_check);
			if($rs_c[NUMC1] < 1){ //  ��㹡�ù���� �ҡ pobec ��� ��ӡѹ
//		echo "<pre>";
//		print_r($xsiteid);die;
				if(count($xsiteid) > 0){
					foreach($xsiteid as $k => $v){
						$arr_d1 = explode(" ",$birthday[$k]);
						$arr_d11  = explode("-",$arr_d1[0]);
						if($arr_d11[0] > 0){ // �ѹ�Դ
						$xbirthday = $arr_d11[2]."-".$arr_d11[1]."-".($arr_d11[0]+543);
						}
						$arr_d2 = explode(" ",$begindate[$k]);
						$arr_d22 = explode("-",$arr_d2[0]);
						if($arr_d22[0] > 0){ // �ѹ��Ժѵ��Ҫ���
							$xbegindate = $arr_d22[2]."-".$arr_d22[1]."-".($arr_d22[0]+543);
						}// end �ѹ�������Ժѵ�Ҫ���
						$sql_replace = "replace into log_pdf_check(idcard,secid,status_file,comment_file,check_file,page_pdf,sent_scan,name_th,surname_th,birthday,begindate,schoolname,position_now)values('$k','$xsiteid[$k]','$status_file[$k]','$comment_file[$k]','1','$page_pdf[$k]','$sent_scan[$k]','$name_th[$k]','$surname_th[$k]','$xbirthday','$xbegindate','$schoolname[$k]','$position_now[$k]')";
						//echo $sql_replace;die;
						$result_replace = mysql_db_query($dbnamemaster,$sql_replace);
					}
				}
						echo "<script>alert('�ѹ�֡���������º��������'); location.href='form_check_file.php?action=view';</script>";
						exit;
			}else{
						echo "<script>alert('�����Ţͧࢵ�ըй������������к�����'); location.href='form_check_file.php?action=view';</script>";
						exit;
			}// end if($rs_c[NUMC1] < 1){
		} //end 	if($Aaction == "SAVE"){
		
}// end if($_SERVER['REQUEST_METHOD'] == "POST"){

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
  if (confirm("�س��㨷���ź������ cmss ��ԧ�������")) {
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
	
	
	function check_F2(){
		if(document.form_m2.sent_siteid.value == ""){
			alert("��س����͡ࢵ��鹷�����֡��");
			document.form_m2.sent_siteid.focus();
			return false;
		}
		return true;
	}
	
</script>
<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style3 {color: #FF0000}
.style4 {color: #000000}
-->
</style>
</head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="9%" align="center"><img src="../../images_sys/secu.png" width="64" height="64"></td>
        <td width="91%"><span class="style1">�к��ѹ�֡������������ó�ͧ�͡��� �.�. 7 </span></td>
      </tr>
    </table></td>
  </tr>
</table>
<? 
	if($action == "" or $action == "view"){
	
?>

  <form name="form_m2" method="post" action="" onSubmit="return check_F2();">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td colspan="4" align="left" bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="25%"><strong>������¡�÷��зӡ�úѹ�֡</strong></td>
            <td width="25%">&nbsp;</td>
            <td width="39%">&nbsp;</td>
            <td width="11%" align="center"><a href="form_check_file.php?action=view">�ʴ�˹����§ҹ</a></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td width="20%" align="left" bgcolor="#EFEFFF"><strong>ࢵ��鹷�����֡��</strong></td>
        <td width="27%" align="left" bgcolor="#EFEFFF"> <select name="sent_siteid" id="sent_siteid">
            <?
		if($dbnamemaster == "cmss_pro_master"){ 
			echo "<option value='1300' selected='selected'>�ѧ��Ѵ�����ҹ�</option>";
		}else{
	?>
            <option value=""> - ���͡ࢵ��鹷�����֡�� - </option>
            <? 
			if(in_area() != ""){ $in_site = in_area(); }else{ $in_site = "''";} // ����ࢵ 20 ࢵ
			$sql_site = "SELECT * FROM eduarea WHERE secid NOT LIKE '99%' AND secid IN($in_site) ORDER BY secname ASC";
			$result_site = mysql_db_query($dbnamemaster,$sql_site);
			while($rs_s = mysql_fetch_assoc($result_site)){
				if($rs_s[secid] == $sent_siteid){ $sel = "selected='selected'";}else{ $sel = "";}
				$secname = str_replace("�ӹѡ�ҹࢵ��鹷�����֡��","ʾ�.",$rs_s[secname]);
				echo "<option value='$rs_s[secid]' $sel>$secname</option>";
			}// end while($rs_s = mysql_fetch_assoc($result_site)){
	}// end if($dbname == "cmss_pro_1300"){ 
			?>
          </select></td>
        <td width="13%" align="left" bgcolor="#EFEFFF"><strong>����</strong></td>
        <td width="40%" align="left" bgcolor="#EFEFFF"><strong>
          <label></label>
          <label></label>
          <input name="sname" type="text" id="sname" size="25" value="<?=$sname?>" <?=$dis?>>
        </strong></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#EFEFFF"><strong>���ʺѵ�</strong></td>
        <td align="left" bgcolor="#EFEFFF"><strong>
          <label></label>
          <label>
          <input name="sidcard" type="text" id="sidcard" size="25" value="<?=$sidcard?>" <?=$dis?>>
          </label>
        </strong></td>
        <td align="left" bgcolor="#EFEFFF"><strong>���ʡ��</strong></td>
        <td align="left" bgcolor="#EFEFFF"><strong>
          <input name="ssurname" type="text" id="ssurname" value="<?=$ssurname?>" size="25" <?=$dis?>>
        </strong></td>
      </tr>
      <tr>
        <td colspan="4" align="center" bgcolor="#EFEFFF">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center" bgcolor="#EFEFFF"><label>
		<input type="hidden" name="xsearch" value="search2">
          <input type="submit" name="Submit3" value="����" <?=$dis?>>
        </label></td>
        </tr>
    </table></td>
  </tr>
  </form>
<tr>
    <td align="center">&nbsp;</td>
</tr>
  <?

if($xsearch == "search2"){
	//if(in_area() != ""){ $in_site = in_area(); }else{ $in_site = "''";} // ����ࢵ 20 ࢵ
	if($sent_siteid != ""){ 
		$db_pobec = "pobec_".$sent_siteid;
		$db_school = "school_".$sent_siteid;
	}
	if($arr_site_admin[$sent_siteid] != ""){
		$conx1  =  "  AND $db_pobec.POST_CODE NOT IN($pos_code_k)";
	}
	
	if($sname != ""){ $conx .= " AND $db_pobec.NAME1 LIKE '%$sname%' ";}
	if($ssurname != ""){ $conx .= " AND $db_pobec.NAME2 LIKE '%$ssurname%' ";}
	if($sidcard != ""){ $conx .= " AND $db_pobec.IDCODE LIKE '%$sidcard%'";}
	if(in_area() != ""){ $in_site = in_area(); }else{ $in_site = "''";} // ����ࢵ 20 ࢵ
	$db_temp = "temp_pobec_import";
//	$sql = "SELECT $db_pobec.IDCODE as idcard, $db_pobec.NAME1 as name_th, $db_pobec.NAME2 as surname_th, postcode.POST_NAME as position_now, $db_school.S_NAME as school  FROM $db_pobec Inner Join postcode ON $db_pobec.POST_CODE = postcode.POST_CODE 
//	Inner Join $db_school ON $db_pobec.I_CODE = $db_school.I_CODE
//	 WHERE $db_pobec.IDCODE <> ''  $conx1  $conx   order by postcode.POST_CODE  ASC ";
	 
	 $sql = "SELECT  $db_pobec.IDCODE AS idcard, $db_pobec.NAME1 AS name_th, $db_pobec.NAME2 AS surname_th, postcode.POST_NAME AS position_now, $db_pobec.I_CODE AS schoolid , $db_pobec.DATE_B as birthday, $db_pobec.DATE_F as begindate FROM $db_pobec Inner Join postcode ON $db_pobec.POST_CODE = postcode.POST_CODE 
WHERE $db_pobec.IDCODE <> '' $conx1  $conx  GROUP BY $db_pobec.IDCODE order by postcode.POST_CODE  ASC";
	 
	//echo $sql;die;
	//$sql = "	SELECT *, CZ_ID as idcard, (TIMESTAMPDIFF(MONTH,begindate,'$year1')/12) as age_gov FROM view_general  WHERE siteid  IN($in_site)  $conx ";
	$result = mysql_db_query($db_temp,$sql);
	$ch_num = mysql_num_rows($result); 
}// end if($xsearch == "search2"){

################################  ����Ẻ�ҵðҹ
###  ��ǹ�ͧ����ʴ��šóդ���Ẻ����
if($xsearch == "search2"){
  ?>
  <form name="form2" method="post" action="">
  <tr>
    <td align="center">
      <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr>
          <td colspan="11" align="center" bgcolor="#A3B2CC"><strong>��¡�÷��зӡ�úѹ�֡</strong></td>
        </tr>
        <tr>
          <td width="4%" align="center" bgcolor="#A3B2CC"><strong>�ӴѺ</strong></td>
          <td width="9%" align="center" bgcolor="#A3B2CC"><strong>�ѵû�ЪҪ�</strong></td>
          <td width="10%" align="center" bgcolor="#A3B2CC"><strong>���� - ���ʡ�� </strong></td>
          <td width="9%" align="center" bgcolor="#A3B2CC"><strong>˹��§ҹ</strong></td>
          <td width="10%" align="center" bgcolor="#A3B2CC"><strong>���˹�</strong></td>
          <td width="6%" align="center" bgcolor="#A3B2CC"><strong>PFD</strong></td>
          <td width="6%" align="center" bgcolor="#A3B2CC"><strong>�ӹǹ˹��</strong></td>
          <td width="10%" align="center" bgcolor="#A3B2CC"><strong>��������ó�</strong></td>
          <td width="18%" align="center" bgcolor="#A3B2CC"><strong>�����˵�</strong></td>
          <td width="11%" align="center" bgcolor="#A3B2CC"><strong>ʶҹ�<br>
          ���ʡ�</strong></td>
          <td width="7%" align="center" bgcolor="#A3B2CC"><strong>���͡<br>
          ���ͺѹ�֡</strong></td>
        </tr>
		 <?
		 if($ch_num < 1){
		 	echo "<tr bgcolor='#FFFFFF'><td colspan='7' align='center'>  -��辺��¡�÷����� ��سҵ�Ǩ�ͺ���͹䢡�ä��ա���� - </td></tr>";
		 }else{
		 $j=0;
		 while($rs = mysql_fetch_assoc($result)){		 
			 if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
		  	$sql_chf = "SELECT * FROM log_pdf_check  WHERE  idcard = '$rs[idcard]'";
			$result_chf = @mysql_db_query($dbnamemaster,$sql_chf);
			$rs_chf = @mysql_fetch_assoc($result_chf);
			$numF = @mysql_num_rows($result_chf);
			if($rs_chf[check_file] == "1"){ // ʶҹС�úѹ�֡�õ����������
				$bg = "#99CC33";
				$title_a = " title='��¡�ù�����ҹ��úѹ�֡��õ�Ǩ�ͺ��������ó������'";
			}
		  ?>

        <tr bgcolor="<?=$bg?>" <?=$title_a?>>
          <td align="center" valign="top"><?=$j?></td>
          <td align="center" valign="top"><?=$rs[idcard]?></td>
          <td align="left" valign="top"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
          <td align="left" valign="top"><? echo show_schoolname($sent_siteid,$rs[schoolid]);?></td>
          <td align="center" valign="top"><? echo "$rs[position_now]";?></td>
          <td align="center" valign="top"><? if(check_kp7file($rs[idcard],$sent_siteid) == 1){?><a href="../../../edubkk_kp7file/<? echo "$sent_siteid/$rs[idcard]".".pdf";?>" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�ʴ��͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a><? } ?></td>
          <td align="center" valign="top"><label>
		  <? 
		  $page_result = count_page($rs[idcard],$sent_siteid); 
		   if(check_kp7file($rs[idcard],$sent_siteid) == 1){
		   if($page_result <= 1){ $page_result = 3;}else{ $page_result = $page_result;}  
		   }// end  if(check_kp7file($rs[idcard],$sent_siteid) == 1){
		  if($rs_chf[page_pdf] > 0){ $p = $rs_chf[page_pdf];}else{ $p = $page_result;}
		  ?>
            <input name="page_pdf[<?=$rs[idcard]?>]" type="text" size="5" value="<?=$p?>" style="text-align:right">
          </label></td>
          <td align="center" valign="top"><label>
            <select name="status_file[<?=$rs[idcard]?>]">
			<option value="YES" <? if($rs_chf[status_file] == "YES"){ echo "selected='selected'";}?>>����ó�</option>
			<option value="NO" <? if($rs_chf[status_file] == "NO"){ echo "selected='selected'"; }?>>�������ó�</option>
            </select>
          </label></td>
          <td align="left" valign="middle"><label>
            <textarea name="comment_file[<?=$rs[idcard]?>]" cols="25" rows="2"><?=$rs_chf[comment_file]?></textarea>
			<input type="hidden" name="xsiteid[<?=$rs[idcard]?>]" value="<?=$sent_siteid?>">
          </label></td>
          <td align="left" valign="middle"><label>
            <select name="sent_scan[<?=$rs[idcard]?>]">
			<option value="">���͡�����</option>
			<option value="0" <? if($rs_chf[sent_scan] == "0"){ echo "selected='selected'";}?>>�����ʡ�</option>
			<option value="1" <? if($rs_chf[sent_scan] == "1"){ echo "selected='selected'";}?>>���ʡ�</option>
            </select>
          </label></td>
          <td align="center" valign="middle"><label>
          <input type="hidden" name="name_th[<?=$rs[idcard]?>]" value="<?=$rs[name_th]?>">
			<input type="hidden" name="surname_th[<?=$rs[idcard]?>]" value="<?=$rs[surname_th]?>">
			<input type="hidden" name="schoolname[<?=$rs[idcard]?>]" value="<?=show_schoolname($sent_siteid,$rs[schoolid])?>">
			<input type="hidden" name="position_now[<?=$rs[idcard]?>]" value="<?=$rs[position_now]?>">
			<input type="hidden" name="birthday[<?=$rs[idcard]?>]" value="<?=$rs[birthday]?>">
			<input type="hidden" name="begindate[<?=$rs[idcard]?>]" value="<?=$rs[begindate]?>">
			<input type="hidden" name="temp_siteid" value="<?=$sent_siteid?>">
          </label></td>
        </tr>
		  <? 
		  }//end while(){
		}// end  if($ch_num < 1){ 
		
		?>
        <tr>
          <td colspan="11" align="center" bgcolor="#CCCCCC"><label>
		  <input type="hidden" name="Aaction" value="SAVE">
		    <? if($j < 1){ $dis_s = " disabled=disabled' ";}?>
            <input type="submit" name="Submit2" value="�ѹ�֡" <?=$dis_s?>>
			<input type="button" name="btnB" value="��͹��Ѻ" onClick="location.href='form_check_file.php?action=&xsearch='">
          </label></td>
        </tr>
      </table>    </td>
  </tr>
  <tr>
  <td align="center"> <div align="center" class="style3">*�����˵� <span class="style4">�ó�᷺��¡���� �������ʴ������¡�ù�����ҹ��õ�Ǩ�ͺ��������ó�ͧ�͡��������</span></div></td>
  </tr>
  </form>
  <? } // end if($xsearch == "search"){ end ��ǹ�ͧ����ʴ���Ẻ��ä���Ẻ�����´
 	
  ?>

  </table>
<? } // end if($action == ""){
	if($action == "view"){
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" bgcolor="#A3B2CC"><strong><!--<img src="../../images_sys/nav_left_blue.png" width="24" height="24" border="0" onClick="location.href='?action='" style="cursor:hand" alt="��͹��Ѻ���ͤ��Һѹ�֡��¡��">-->&nbsp;��§ҹ��õ�Ǩ�ͺʶҹТͧ�͡��� �.�. �鹩�Ѻ </strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A3B2CC"><strong>�ӴѺ</strong></td>
        <td width="40%" align="center" bgcolor="#A3B2CC"><strong>ࢵ��鹷��</strong></td>
        <td width="18%" align="center" bgcolor="#A3B2CC"><strong>�ӹǹ�͡��÷������ó�(�ش)</strong></td>
        <td width="17%" align="center" bgcolor="#A3B2CC"><strong>�ӹǹ�͡����������ó�(�ش)</strong></td>
        <td width="12%" align="center" bgcolor="#A3B2CC"><strong>���</strong></td>
        <td width="9%" align="center" bgcolor="#A3B2CC"><strong>ʶҹе�Ǩ<br>
          �͡���</strong></td>
      </tr>
	  <? 
	  $sql_view = "SELECT * FROM config_area WHERE defult_config='1' ORDER BY secname ASC";
	 $result_view = mysql_db_query($db_name,$sql_view);
	 $j=0;
	 while($rs_v = mysql_fetch_assoc($result_view)){
	  if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  $temp_c = count_check_pdf("YES",$rs_v[secid]);
	  $temp_u = count_check_pdf("NO",$rs_v[secid]);
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$j?></td>
        <td align="left"><?=$rs_v[secname]?></td>
        <td align="center"><? if($temp_c > 0){ echo "<a href='?action=view_detail&xtype=c&secid=$rs_v[secid]&sname=$rs_v[secname]'>".number_format($temp_c)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($temp_u > 0){ echo "<a href='?action=view_detail&xtype=u&secid=$rs_v[secid]&sname=$rs_v[secname]'>".number_format($temp_u)."</a>";}else{ echo "0";} ?></td>
        <td align="center"><? echo number_format($temp_c+$temp_u);?></td>
        <td align="center">&nbsp;</td>
      </tr>
	  <?
	  	}// end 	 while($rs_v = mysql_fetch_assoc($result_view)){
	  ?>
    </table></td>
  </tr>
</table>
<? } // end  if($action == "view"){
	if($action == "view_detail"){
	if($xtype == "c"){  $conw = "  AND log_pdf_check.status_file='YES'";$txt_h = " ��¡���͡��á.�.7 �鹩�Ѻ�������ó�";           $consp = "5";}
	if($xtype == "u"){  $conw = "  AND log_pdf_check.status_file='NO'"; $txt_h = " ��¡���͡��� �.�.7 �鹩�Ѻ����������ó�";        $consp = "6";}

?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="<?=$consp?>" bgcolor="#A3B2CC"><strong><img src="../../images_sys/nav_left_blue.png" width="24" height="24" border="0" onClick="location.href='?action=view'" style="cursor:hand" alt="��͹��Ѻ���ͤ��Һѹ�֡��¡��"><? echo "$sname &nbsp;&nbsp;$txt_h";  ?></strong></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>�ӴѺ</strong></td>
        <td width="16%" align="center" bgcolor="#A3B2CC"><strong>�ѵû�ЪҪ�</strong></td>
        <td width="19%" align="center" bgcolor="#A3B2CC"><strong>����-���ʡ��</strong></td>
        <td width="25%" align="center" bgcolor="#A3B2CC"><strong>�ç���¹/˹��§ҹ</strong></td>
        <td width="16%" align="center" bgcolor="#A3B2CC"><strong>���˹�</strong></td>
		<? if($xtype == "u"){?>
		  <td width="19%" align="center" bgcolor="#A3B2CC"><strong>�����˵� �.�.7 �������ó� </strong></td>
		  <? } ?>
        </tr>
      <? 
	  $sql_view1 = "SELECT log_pdf_check.idcard, view_general.CZ_ID, view_general.siteid, view_general.prename_th, view_general.name_th, view_general.surname_th,
view_general.position_now, view_general.schoolid,log_pdf_check.comment_file  FROM log_pdf_check Left Join view_general ON log_pdf_check.idcard = view_general.CZ_ID WHERE
log_pdf_check.secid =  '$secid'  $conw  order by view_general.name_th ASC
";

	 $result_view1 = mysql_db_query($dbnamemaster,$sql_view1);
	 $j=0;
	 while($rsv1 = mysql_fetch_assoc($result_view1)){
	  if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  if($rsv1[CZ_ID] == "" or ($rsv1[siteid] != "$secid")){ 
	 			 $bg = "#FF6600";
				$txt_s = " title='�����ŵ�駵��ѧ�������ó�'";
	  }
	  ?>
      <tr bgcolor="<?=$bg?>" <?=$txt_s?>>
        <td align="center"><?=$j?></td>
        <td align="left"><?=$rsv1[idcard]?></td>
        <td align="left"><? echo "$rsv1[prename_th]$rsv1[name_th]  $rsv1[surname_th]";?></td>
        <td align="left"><?=show_org($rsv1[schoolid])."/".show_area($rsv1[siteid]);?></td>
        <td align="left"><?=$rsv1[position_now]?></td>
		<? if($xtype == "u"){?>
		<td align="left"><?=$rsv1[comment_file]?></td>
		<? } ?>
        </tr>
      <?
	  $txt_s = "";
	  	}// end 	 while($rs_v = mysql_fetch_assoc($result_view)){
		$txt_com = "<span class=\"style2\">*�����˵ <span class=\"style4\">����¡�÷����������ʴ���Ң����ŵ�駵��ѧ�������ó������������к�</span></span>";
	  ?>
	  <tr>
	    <td colspan="<?=$consp?>" align="center" bgcolor="#FFFFFF"><?=$txt_com?></td>
	  </tr>
    </table></td>
  </tr>
</table>
<?
	}// end if($action == "view_detail"){
?>
</BODY>
</HTML>
