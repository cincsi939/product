<?
/*****************************************************************************
Function		: �ͺ���¡�ä�������� �.�.7 ���Ѻ�����
Version			: 1.0
Last Modified	: 22/05/2552
Changes		:
*****************************************************************************/
include "epm.inc.php";
//$type_cmss = "province"; // ��˹��ó����к��ͧ �ѧ��Ѵ
$s_db = STR_PREFIX_DB;
//if($dbnamemaster == "cmss_pro_master"){ $temp_site = "1300";};
$report_title = "�ͺ���¡�úѹ�֡������ �.�.7 ���Ѻ�����";
# �ѧ����㹡�ùѺ�ӹǹ�ؤ�ҡ÷�������������
function count_key_sucssec($staffid){
global $db_name;
	$sql1 = "SELECT  siteid  FROM tbl_assign_key  WHERE staffid='$staffid'  GROUP BY siteid";
	$result1 = mysql_db_query($db_name,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
	$sql2 = "SELECT COUNT(monitor_keyin.idcard) AS num1 FROM tbl_asign_key INNER JOIN  monitor_keyin ON tbl_asign_key.idcard = monitor_keyin.idcard  WHERE monitor_keyin.siteid='$rs1[siteid]' AND monitor_keyin.staffid='$staffid'  GROUP BY monitor_keyin.idcard ";
	//echo $sql2;
	$result2 = mysql_db_query($db_name,$sql2);
	$rs2 = mysql_fetch_assoc($result2);
		$temp_num  = $temp_num + $rs2[num1];
	}
	return $temp_num;
}// end function count_key_sucssec(){

# �ѧ����㹡�ùѺ�ӹǹ�ؤ�ҡ÷����ͺ�����������������
function count_assign($staffid){
global $db_name;
	$sql_count = "SELECT COUNT(staffid) AS  num1  FROM  tbl_asign_key  WHERE staffid='$staffid' GROUP BY staffid";
	$result_count = @mysql_db_query($db_name,$sql_count);
	$rs = @mysql_fetch_assoc($result_count);
	if($rs[num1] > 0){ $temp_result = $rs[num1];}else{ $temp_result = 0;}
	return $temp_result;
}
# end  �ѧ����㹡�ùѺ�ӹǹ�ؤ�ҡ÷����ͺ�����������������

## �ѧ�����ʴ��ѹ����ͺ��������ش
function show_max_date($staffid){
global $db_name,$monthname;
	$sql_max = "SELECT MAX(sign_date) AS max_date FROM tbl_asign_key WHERE staffid='$staffid' AND sign_date <> '0000-00-00'";
	$result_max = @mysql_db_query($db_name,$sql_max);
	$rs = @mysql_fetch_assoc($result_max);
	if($rs[max_date] != "0000-00-00" and $rs[max_date] != ""){
			$arr_t = explode("-",$rs[max_date]);
			$temp_result = intval($arr_t[2])." ".$monthname[intval($arr_t[1])]." ".($arr_t[0]+543);
	}else{
			$temp_result = "";
	}
	return $temp_result;
}
## end function show_max_date(){

function show_user($staffid){
	global $db_name;
	$sql = "SELECT *  FROM  keystaff  WHERE staffid='$staffid'";
	$result = @mysql_db_query($db_name,$sql);
	$rs = @mysql_fetch_assoc($result);
	return $rs[prename]." ".$rs[staffname]." ".$rs[staffsurname];

}// end function show_user(){



function person_not_assign($xidcard,$xsiteid){ // �ѧ���蹵�Ǩ�ͺ�óպؤ�ҡö١ assing ¡��鹵���ͧ
global $staffid,$db_name;
	con_db($xsiteid);
	$sql_p = "SELECT COUNT(idcard) AS num1 FROM tbl_asign_key WHERE staffid <> '$staffid' AND idcard = '$xidcard' GROUP BY staffid";
	//echo $sql_p;
	$result_p = @mysql_db_query($db_name,$sql_p);
	$rs_p = @mysql_fetch_assoc($result_p);
	return $rs_p[num1];
}// end function person_not_assign(){

## ��Ǩ�ͺ�ͧ����ͧ
function person_select_assign($xidcard,$xsiteid){
global $staffid,$db_name;
	con_db($xsiteid);
	$sql_p = "SELECT COUNT(idcard) AS num1 FROM tbl_asign_key WHERE staffid = '$staffid' AND idcard = '$xidcard' GROUP BY staffid";
	$result_p = @mysql_db_query($db_name,$sql_p);
	$rs_p = @mysql_fetch_assoc($result_p);
	return $rs_p[num1];

}// function person_select_assign($xidcard,$xsiteid){

## �ѧ�����ʴ�����˹��§ҹ/�ç���¹
function show_org($schoolid){
global $s_db;
$sql_org = "SELECT * FROM allschool WHERE id='$schoolid'";
$result_org = mysql_db_query($s_db."master",$sql_org);
$rs_org = mysql_fetch_assoc($result_org);
if($rs_org[office] != ""){ $temp_org = $rs_org[office];}else{ $temp_org = "����к�";}
return $temp_org;
}// end function show_org(){



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
</head>

<body bgcolor="#EFEFFF">
<table border=0 align=center cellspacing=1 cellpadding=2 width="98%">
<tr><td colspan="2" class="fillcolor"><table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td width="13%"  bgcolor="<? if($xmode == ""){ $bgcolor = "BLACK";echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066"; }?>" align=center style="border-right: solid 1 white;"><A HREF="org_user.php?xmode="><strong><U style="color:<?=$bgcolor?>;">�Ѵ��â����ż����</U></strong></A></td>
              <td width="26%"  bgcolor="<? if($xmode == "1"){ $bgcolor = "BLACK"; echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066";}?>" align=center style="border-right: solid 1 white;"><A HREF="asign_user_key.php?xmode=1"><B><U style="color:<?=$bgcolor?>;">�ͺ���¡�ä�����������Ѻ�����</U></B></A></td>
              <td width="61%">&nbsp;</td>
            </tr>
          </table></td></tr>
<tr><td width=39><img src="images/user_icon.gif"></td>
<td width="908" align="left"><B style="font-size: 12pt;">��ǹ�ͧ����ͺ���¡�ä�����������Ѻ�����</B></td>
</tr>

<tr valign=top height=1 bgcolor="#808080"><td colspan=2></td></tr>

<tr valign=top><td colspan=2>
<BR></td>
</tr>
</table>

<? if($action == ""){ /// ��ǹ�ͧ����ʴ�����¡��?>

<table border=0 align=center cellspacing=1 cellpadding=2 bgcolor=black width="98%" class="sortable" id="unique_id">
<tr bgcolor="#a3b2cc">
<th width=60>�ӴѺ</th>
<th width="298">���� - ���ʡ��</th>
<th width="182">�ӹǹ����ͺ����</th>
<th width="182">�ӹǹ����������</th>
<th width="283">�ѹ����ͺ��������ش</th>
<th width="126">�ͺ���§ҹ</th>
</tr>
<?
$n = 0;
$sql = "select * from  $epm_staff  WHERE sapphireoffice='0' ORDER BY staffname  ASC";
$result = mysql_query($sql);
while ($rs=mysql_fetch_assoc($result)){
	if ($n++ %  2){
		$bgcolor = "#F0F0F0";
	}else{
		$bgcolor = "#FFFFFF";
	}
	
?>
<tr valign=top bgcolor="<?=$bgcolor?>">
<td align=center ><?=$n?></td>
<td align="left" ><?=$rs[staffname]?> <?=$rs[staffsurname]?></td>
<td align="center" valign="middle" ><? if(count_assign($rs[staffid]) > 0){ echo "<a href='?action=view_key&staffid=$rs[staffid]&type_key=all&xmode=1'>".number_format(count_assign($rs[staffid]))."</a>";}else{ echo "0";}?></td>
<td align="center" valign="middle" ><? if(count_key_sucssec($rs[staffid]) > 0){ echo "<a href='?action=view_key&staffid=$rs[staffid]&type_key=comp&xmode=1'>".number_format(count_key_sucssec($rs[staffid]))."</a>";}else{ echo "0";}?></td>
<td align="center" valign="middle" ><?=show_max_date($rs[staffid])?></td>
<td align="center" ><img src="../../images_sys/refresh.png" alt="��������ͺ���ºؤ�ҡ����Ѻ�������зӡ�úѹ�֡������ �.�.7" width="20" height="20" border="0" onClick="location.href='asign_user_key.php?action=assign_key&staffid=<?=$rs[staffid]?>&xmode=1'" style="cursor:hand"></td>
</tr>
<?
}
?>
</table>
<? } //end if($action == ""){
	if($action == "assign_key"){
		
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" method="post" action="">
  <tr>
    <td align="center" bgcolor="#000000">
      <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr>
          <td colspan="5" align="left" bgcolor="#FFFFFF"><strong>������ѹ�֡����ͺ���§ҹ�ͧ 
              <?=show_user($staffid)?>
          </strong></td>
          </tr>
        <tr>
          <td width="6%" rowspan="2" align="center" bgcolor="#FFFFFF"><strong>����</strong></td>
          <td align="center" bgcolor="#FFFFFF"><strong>ࢵ��鹷�����֡��</strong></td>
          <td align="center" bgcolor="#FFFFFF"><strong>����</strong></td>
          <td align="center" bgcolor="#FFFFFF"><strong>���ʡ��</strong></td>
          <td align="center" bgcolor="#FFFFFF"><strong>���ʺѵ�</strong></td>
        </tr>
        <tr>
          <td width="23%" align="left" bgcolor="#FFFFFF"><label>
            <select name="sent_siteid" id="sent_siteid">
	<?
		if($dbnamemaster == "cmss_pro_master"){ 
			echo "<option value='1300' selected='selected'>�ѧ��Ѵ�����ҹ�</option>";
		}else{
	?>
			<option value=""> - ���͡ࢵ��鹷�����֡�� - </option>
			<? 
			$sql_site = "SELECT * FROM eduarea WHERE secid NOT LIKE '99%' ORDER BY secname ASC";
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
          <td width="31%" align="left" bgcolor="#FFFFFF"><label>
            <input name="name" type="text" id="name" size="40" value="<?=$name?>">
            </label></td>
          <td width="21%" align="left" bgcolor="#FFFFFF"><label>
            <input name="surname" type="text" id="surname" size="25" value="<?=$surname?>">
          </label></td>
          <td width="19%" align="left" bgcolor="#FFFFFF"><label>
            <input name="idcard" type="text" id="idcard" size="20" value="<?=$idcard?>">
          </label></td>
          </tr>
        <tr>
          <td colspan="3" align="left" bgcolor="#FFFFFF"><em>㹡óշ���ͧ��ä��Ҫ����ҡ����˹�觪������������ &quot;,&quot; �� �����,���Է��,�͡��� �繵� </em></td>
          <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
          <td align="center" bgcolor="#FFFFFF">
		  <input type="hidden" name="action" value="assign_key">
		  <input type="hidden" name="xsearch" value="search">
		  <input type="hidden" name="staffid" value="<?=$staffid?>">
		  <input type="submit" name="Submit" value="����">
		  </td>
        </tr>
      </table>
    </td>
  </tr>
  </form>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <?
  	if($xsearch == "search"){
	if($sent_siteid != ""){ $sent_siteid = $sent_siteid;}else{ $sent_siteid = "5001";}
	con_db($sent_siteid);
	$db_site = "$s_db".$sent_siteid;
	//echo $db_site."<br>";
	## �óդ��Ҫ���
	if($name != ""){ 
		$xpos = strpos($name,",");
		if(!($xpos === false)){ // �óշ���ա�ä��Ҫ������¤�
			$arr_t = explode(",",$name);
			foreach($arr_t as $k => $v){
				if($name_search > "") $name_search .= ",";
					$name_search .= "'".trim($v)."'";
			}// end  foreach($arr_t as $k => $v){
			$conW = " AND name_th IN($name_search) ";
		}else{
			$conW = " AND name_th LIKE '%$name%' ";
		} // end if(!($xpos === false)){
	}// end if($name != ""){ 
## end �óդ��Ҫ���
## �óդ��ҹ��ʡ��
if($surname != ""){
	$xpos1 = strpos($surname,",");
		if(!($xpos1 === false)){
			$arr_t1 = explode(",",$surname);
				foreach($arr_t1 as $k1 => $v1){
					if($surname_search > "") $surname_search .= ",";
						$surname_search .= "'".trim($v1)."'";
				}// end foreach
			$conW1 = " AND surname_th IN($surname_search) ";
		}else{
			$conW1 = " AND surname_th LIKE '%$surname%' ";
		}
}// end if($surname != ""){
## end �óդ��ҹ��ʡ��
##  �óդ������ʺѵ�
if($idcard != ""){
	$xpos2 = strpos($idcard,",");
	if(!($xpos2 === false)){
		$arr_t2 = explode(",",$idcard);
			foreach($arr_t2 as $k2 => $v3){
				if($idcard_search > "") $idcard_search .= ",";
					$idcard_search .= "'".trim($v3)."'";
			}
			$conW2 = " AND idcard IN($idcard_search)";
	}else{
			$conW2 = " AND idcard LIKE '%$idcard%'";
	}
}
##  end �óդ������ʺѵ�


	$sql = "SELECT * FROM  general WHERE  siteid='$sent_siteid' $conW  $conW1 $conW2 ";
	//echo "$sql ";
	//echo $db_site;
	$result = mysql_db_query($db_site,$sql);
	$ch_num = mysql_num_rows($result);
  ?>
  <form name="form2" method="post" action="">
  <tr>
    <td align="center" bgcolor="#000000">
      <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr>
          <td width="5%" align="center" bgcolor="#A3B2CC"><strong>�ӴѺ</strong></td>
          <td width="18%" align="center" bgcolor="#A3B2CC"><strong>���ʻ�Шӵ�ǻ�ЪҪ�</strong></td>
          <td width="23%" align="center" bgcolor="#A3B2CC"><strong>���� - ���ʡ�� </strong></td>
          <td width="21%" align="center" bgcolor="#A3B2CC"><strong>���˹�</strong></td>
          <td width="21%" align="center" bgcolor="#A3B2CC"><strong>˹��§ҹ/�ç���¹</strong></td>
          <td width="12%" align="center" bgcolor="#A3B2CC"><strong>���͡��¡��</strong></td>
          </tr>
		 <?
		 if($ch_num < 1){
		 	echo "<tr bgcolor='#FFFFFF'><td colspan='6' align='center'>  -��辺��¡�÷����� ��سҵ�Ǩ�ͺ���͹䢡�ä��ա���� - </td></tr>";
		 }else{
		 $j=0;
		 while($rs = mysql_fetch_assoc($result)){
		 if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}

		 ?>
        <tr bgcolor="<?=$bg?>">
          <td align="center"><?=$j?></td>
          <td align="center"><?=$rs[idcard]?></td>
          <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
          <td align="left"><? echo "$rs[position_now]";?></td>
          <td align="center"><?=show_org($rs[schoolid]);?></td>
          <td align="center"><label>
		  <?
		  	if(person_not_assign($rs[idcard],$sent_siteid) > 0){
				echo " <input type=\"checkbox\" name=\"select_idcard\"  disabled=\"disabled\"><font color='red'>! Assign</font>";
			}else{
		  ?>
            <input type="checkbox" name="xidcard[<?=$rs[idcard]?>]" value="<?=$rs[idcard]?>" <? if(person_select_assign($rs[idcard],$sent_siteid) > 0){ echo "checked='checked'";}?>>
			<input type="hidden" name="xsiteid" value="<?=$rs[siteid]?>">
			<?
			}// end 	if(person_not_assign($rs[idcard],$sent_siteid) > 0){
			?>
          </label></td>
          </tr>
		  <? 
		  }//end while(){
		}// end  if($ch_num < 1){ ?>
        <tr>
          <td colspan="6" align="center" bgcolor="#FFFFFF"><label>
		  <input type="hidden" name="Aaction" value="SAVE">
		   <input type="hidden" name="staffid" value="<?=$staffid?>">
            <input type="submit" name="Submit2" value="�ѹ�֡">
			<input type="button" name="btnB" value="��͹��Ѻ" onClick="location.href='asign_user_key.php?action=assign_key&xsearch=&staffid=<?=$staffid?>'">
          </label></td>
          </tr>
      </table>
    </td>
  </tr>
  </form>
  <? } // end if($xsearch == "search"){?>
</table>
<? } // end if($action == "assign_key"){ ?>
<? if($action == "view_key"){
	
	//con_db($siteid)
	if($type_key == "all"){ // �ӹǹ����Ѻ�Ѻ�ͺ���·�����
		if($type_cmss == "province"){
		$xdb = $s_db.$temp_site;
			$sql = "SELECT $xdb.general.idcard, $xdb.general.schoolid, $xdb.general.prename_th, $xdb.general.name_th,$xdb.general.surname_th, $xdb.general.position_now, $db_name.tbl_asign_key.sign_date FROM $db_name.tbl_asign_key Inner Join $xdb.general ON $db_name.tbl_asign_key.idcard = $xdb.general.idcard WHERE $db_name.tbl_asign_key.staffid =  '$staffid' GROUP BY $xdb.general.idcard ";
		}else{
			$sql = "SELECT $db_name.tbl_asign_key.idcard, $dbnamemaster.view_general.prename_th, $dbnamemaster.view_general.name_th, $dbnamemaster.view_general.surname_th, $dbnamemaster.view_general.position_now, $dbnamemaster.view_general.schoolid, $db_name.tbl_asign_key.sign_date
FROM $db_name.tbl_asign_key Inner Join $dbnamemaster.view_general ON $db_name.tbl_asign_key.idcard = $dbnamemaster.view_general.CZ_ID
WHERE $db_name.tbl_asign_key.staffid =  '$staffid'";
		}
		$xtitle = "�ؤ�ҡ÷���������ͺ���¢ͧ ";
	}else if($type_key == "comp"){ // �ӹǹ��������������
		$sql = "SELECT $db_name.tbl_asign_key.idcard, $dbnamemaster.view_general.prename_th, $dbnamemaster.view_general.name_th, $dbnamemaster.view_general.surname_th, $dbnamemaster.view_general.position_now, $dbnamemaster.view_general.schoolid, $db_name.tbl_asign_key.sign_date
FROM $db_name.tbl_asign_key Inner Join $dbnamemaster.view_general ON $db_name.tbl_asign_key.idcard = $dbnamemaster.view_general.CZ_ID INNER JOIN  monitor_keyin ON tbl_asign_key.idcard = monitor_keyin.idcard
WHERE $db_name.tbl_asign_key.staffid =  '$staffid'";
//echo $sql;
		$xtitle = "�ؤ�ҡ÷��ѹ�֡�������º�������Ǣͧ ";
	}

?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td colspan="6" bgcolor="#A3B2CC"><input type="button" name="btnBB" value="��͹��Ѻ" onClick="location.href='asign_user_key.php?xmode=1'"><strong>
          <?=$xtitle?> 
          <?=show_user($staffid)?>
        </strong></td>
        </tr>
		
      <tr>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>�ӴѺ</strong></td>
        <td width="16%" align="center" bgcolor="#A3B2CC"><strong>���ʻ�Шӵ�ǻ�ЪҪ�</strong></td>
        <td width="17%" align="center" bgcolor="#A3B2CC"><strong>���� - ���ʡ�� </strong></td>
        <td width="23%" align="center" bgcolor="#A3B2CC"><strong>���˹�</strong></td>
        <td width="23%" align="center" bgcolor="#A3B2CC"><strong>˹��§ҹ/�ç���¹ </strong></td>
        <td width="16%" align="center" bgcolor="#A3B2CC"><strong>�ѹ����ͺ����§ҹ</strong></td>
      </tr>
	  <? 
	  $result = mysql_db_query($db_name,$sql);
	  $k=0;
	  while($rs = mysql_fetch_assoc($result)){
	   if ($k++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$k?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="left"><? echo show_org($rs[schoolid]);?></td>
        <td align="center"><?
		 $arr_d = explode("-",$rs[sign_date]);  
		 	echo intval($arr_d[2])." ".$monthname[intval($arr_d[1])]." ".($arr_d[0]+543);
		
		?></td>
      </tr>
	  <? } // end while (){?>
    </table></td>
  </tr>
</table>
<? } // end if($action == "view_key"){?>

</BODY>
</HTML>
