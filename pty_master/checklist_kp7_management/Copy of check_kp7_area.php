<?
session_start();

include("checklist.inc.php");
##########  �ѹ�֡��õ�Ǩ�ͺ�͡���
if($action == "process"){
##  ��Ǩ�ͺ ��Ң�������¡������ ����ó� ��˹�ʶҹ������ 1
	if($page_num > 0 and $general_status == "1" and $graduate_status == "1" and $salary_status == "1" and $seminar_status == "1" and $sheet_status == "1" and $getroyal_status == "1" and $special_status == "1" and $goodman_status == "1" and $absent_status == "1" and $nosalary_status == "1" and $prohibit_status == "1" and $specialduty_status == "1" and $other_status == "1"){
		$txt_status = "1";	
	}else{
		$txt_status = "0";
	}
###  end ##  ��Ǩ�ͺ ��Ң�������¡������ ����ó� ��˹�ʶҹ������ 1
	$sql_update = "UPDATE tbl_checklist_kp7 SET status_file='$txt_status',page_num='$page_num',comment_page='$comment_page',pic_num='$pic_num',comment_pic='$comment_pic',general_status='$general_status',comment_general='$comment_general',graduate_status='$graduate_status',comment_graduate='$comment_graduate',salary_status='$salary_status',comment_salary='$comment_salary',seminar_status='$seminar_status',comment_seminar='$comment_seminar',sheet_status='$sheet_status',comment_sheet='$comment_sheet',getroyal_status='$getroyal_status',comment_getroyal='$comment_getroyal',special_status='$special_status',comment_special='$comment_special',goodman_status='$goodman_status',comment_goodman='$comment_goodman',absent_status='$absent_status',comment_absent='$comment_absent',nosalary_status='$nosalary_status',comment_nosalary='$comment_nosalary',prohibit_status='$prohibit_status',comment_prohibit='$comment_prohibit',specialduty_status='$specialduty_status',comment_specialduty='$comment_specialduty',other_status='$other_status',comment_other='$comment_other',status_check_file='YES'   WHERE idcard='$idcard' AND siteid='$sentsecid'";
//	echo $sql_update;die;
	$result_update = mysql_db_query($dbname_temp,$sql_update);
	insert_log_import($sentsecid,$idcard,"�ѹ�֡��Ǩ�ͺ�͡��� �.�. 7 �鹩�Ѻ","1");
	if($result_update){
			echo "<script>alert('�ѹ�֡���������º��������');location.href='check_kp7_area.php?sentsecid=$sentsecid';</script>";
		exit;
	}else{
		echo "<script>alert(' !�������ö�ѹ�֡��������');location.href='check_kp7_area.php?sentsecid=$sentsecid';</script>";
		exit;
	}
	
}//end if($action == "process"){

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>�к���Ǩ�ͺ�͡��� �.�.7 �鹩�Ѻ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
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
<script language="javascript">
//	function dis_status_file(){
//		if(document.getElementById("status_file").value == "1"){
//			document.form2.
//		}
//		alert(status_file1);
//	}

function check_F(){
	if(document.form2.page_num.value == "0"){
		alert("��س��кبӹǹ���͡���");
		document.form2.page_num.focus();
		return false;
	}else{
		return true;
	}

}

</script>
</head>
<body>
<?
	if($action == ""){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#A8B9FF" align="center"><strong><?=show_area($sentsecid);?></strong></td>
  </tr>
  <tr>
    <td bgcolor="#A8B9FF">&nbsp;</td>
  </tr>
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="4" bgcolor="#A8B9FF"><strong>���Һؤ�ҡ����͵�Ǩ�ͺ������ �.�. 7 �鹩�Ѻ </strong></td>
              </tr>
            <tr>
              <td width="8%" bgcolor="#FFFFFF"><strong>����:</strong></td>
              <td width="25%" bgcolor="#FFFFFF"><label>
                <input name="key_name" type="text" id="key_name" size="25" value="<?=$key_name?>">
              </label></td>
              <td width="18%" bgcolor="#FFFFFF"><strong>�Ţ�ѵû�ЪҪ�:</strong></td>
              <td width="49%" bgcolor="#FFFFFF"><label>
                <input name="key_idcard" type="text" id="key_idcard" size="25" value="<?=$key_idcard?>">
              </label></td>
            </tr>
            <tr>
              <td bgcolor="#FFFFFF"><strong>���ʡ��:</strong></td>
              <td bgcolor="#FFFFFF"><label>
                <input name="key_surname" type="text" id="key_surname" size="25" value="<?=$key_surname?>">
              </label></td>
              <td colspan="2" bgcolor="#FFFFFF"><label>
			  <input type="hidden" name="sentsecid" value="<?=$sentsecid?>">
			  <input type="hidden" name="action" value="">
			  <input type="hidden" name="search" value="search">
                <input type="submit" name="Submit" value="����">
              </label></td>
              </tr>
          </table></td>
        </tr>
      </table>
        </form>    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="19" bgcolor="#A8B9FF"><strong>��ª��ͺؤ�ҡ÷��ӡ�õ�Ǩ�ͺ������ �.�. 7 �鹩�Ѻ </strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A8B9FF">�ӴѺ</td>
        <td width="34%" align="center" bgcolor="#A8B9FF">���� - ���ʡ�� </td>
        <td width="15%" align="center" bgcolor="#A8B9FF">ʶҹ�<br>
          �͡���</td>
        <td width="18%" align="center" bgcolor="#A8B9FF">�ӹǹ<br>
          ��</td>
        <td width="23%" align="center" bgcolor="#A8B9FF">�ӹǹ<br>
          �ٻ</td>
<!--        <td width="4%" align="center" bgcolor="#A8B9FF">������<br>
          �����</td>
        <td width="4%" align="center" bgcolor="#A8B9FF"><br>
          ���<br>
          �֡��</td>
        <td width="4%" align="center" bgcolor="#A8B9FF">�Թ<br>
          ��͹</td>
        <td width="5%" align="center" bgcolor="#A8B9FF">�֡ͺ��<br>
          �٧ҹ</td>
        <td width="5%" align="center" bgcolor="#A8B9FF">�ŧҹ<br>
          �Ԫҡ��</td>
        <td width="4%" align="center" bgcolor="#A8B9FF">����ͧ<br>
          �Ҫ��</td>
        <td width="5%" align="center" bgcolor="#A8B9FF">�������<br>
          ����<br>
          ����ö<br>
          �����</td>
        <td width="5%" align="center" bgcolor="#A8B9FF">������<br>
          ����<br>
          �ͺ</td>
        <td width="4%" align="center" bgcolor="#A8B9FF">�ѹ��</td>
        <td width="5%" align="center" bgcolor="#A8B9FF">�ѹ�����<br>
          �Ѻ<br>
          �Թ��͹</td>
        <td width="5%" align="center" bgcolor="#A8B9FF">�ɷҧ<br>
          �Թ��</td>
        <td width="5%" align="center" bgcolor="#A8B9FF">��Ժѵ�<br>
          �Ҫ���<br>
          �����</td>
        <td width="5%" align="center" bgcolor="#A8B9FF">��¡��<br>
          ����</td>
-->        <td width="6%" align="center" bgcolor="#A8B9FF">&nbsp;</td>
      </tr>
	  <?
	 $page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
	$e			= (!isset($e) || $e == 0) ? 20 : $e ;
	$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 

	  
		if($search == "search"){
			if($key_name != ""){ $conv .= " AND name_th LIKE '%$key_name%'";}
			if($key_surname != ""){ $conv .= " AND surname_th LIKE '%$key_surname%'";}
			if($key_idcard != ""){ $conv .= " AND idcard LIKE '%$key_idcard%'";}
		}
		$sql_main = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' $conv ORDER  BY status_check_file DESC";
		//echo $sql_main."<br>$dbname_temp<br>name :: $key_name<br>$key_surname";
		
		
		$xresult = mysql_db_query($dbname_temp,$sql_main);
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

		$result_main = mysql_db_query($dbname_temp,$sql_main);
		$num_row = mysql_num_rows($result_main);
		$search_sql = $sql_main ; 

		$n=0;
		if($all < 1){// ���ú��¡�÷�����
			echo "<tr bgcolor='#FFFFFF'><td colspan='6' align='center'> - ��辺��¡�÷����� - </td></tr>";
		}else{
		while($rs1 = mysql_fetch_assoc($result_main)){
		$i++;
		 	if ($n++ %  2){ 	$bg = "#F0F0F0"; 	}else{ $bg = "#FFFFFF";	}
	  ?>
	  
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs1[prename_th]$rs1[name_th]  $rs1[surname_th]";?></td>
        <td align="center"><?=show_icon_check($rs1[status_file]);?></td>
        <td align="center"><? if($rs1[page_num] > 0){ echo number_format($rs1[page_num]); }else{ echo "-";}?></td>
        <td align="center"><? if($rs1[pic_num] > 0){ echo number_format($rs1[pic_num]);}else{ echo "-";}?></td>
<!--        <td align="center"><?=show_icon_check($rs1[general_status]);?></td>
        <td align="center"><?=show_icon_check($rs1[graduate_status]);?></td>
        <td align="center"><?=show_icon_check($rs1[salary_status]);?></td>
        <td align="center"><?=show_icon_check($rs1[seminar_status]);?></td>
        <td align="center"><?=show_icon_check($rs1[sheet_status]);?></td>
        <td align="center"><?=show_icon_check($rs1[getroyal_status]);?></td>
        <td align="center"><?=show_icon_check($rs1[special_status]);?></td>
        <td align="center"><?=show_icon_check($rs1[goodman_status]);?></td>
        <td align="center"><?=show_icon_check($rs1[absent_status]);?></td>
        <td align="center"><?=show_icon_check($rs1[nosalary_status]);?></td>
        <td align="center"><?=show_icon_check($rs1[prohibit_status]);?></td>
        <td align="center"><?=show_icon_check($rs1[specialduty_status]);?></td>
        <td align="center"><?=show_icon_check($rs1[other_status]);?></td>
-->        <td align="center"><a href="?action=execute&sentsecid=<?=$rs1[siteid]?>&idcard=<?=$rs1[idcard]?>&fullname=<? echo "$rs1[prename_th]$rs1[name_th]  $rs1[surname_th]";?>&search=<?=$search?>&key_name=<?=$key_name?>&key_surname=<?=$key_surname?>&key_idcard=<?=$key_idcard?>"><img src="../../images_sys/refresh.png" width="18" height="18" border="0" alt="�������ͺѹ�֡�š�õ�Ǩ�ͺ�͡���"></a></td>
      </tr>
	  <?
	  	}//end while(){
		} //end if($all < 1){
		if($all > 0){ //
	  ?>
      <tr>
        <td colspan="6" align="center" bgcolor="#FFFFFF"><? $sqlencode = urlencode($search_sql)  ; ?>	
	<?=devidepage($allpage, $keyword ,$sqlencode )?></td>
        </tr>
	<? } //end 	if($all > 0){?>
    </table></td>
  </tr>
</table>

  <?
	}else if($action == "execute"){
		$sql_edit = "SELECT * FROM  tbl_checklist_kp7  WHERE idcard='$idcard' AND siteid='$sentsecid'";
		$result_edit = mysql_db_query($dbname_temp,$sql_edit);
		$rs_e = mysql_fetch_assoc($result_edit);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><form name="form2" method="post" action="" onSubmit="return check_F();">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="3" bgcolor="#FFFFFF"><strong><a href="check_kp7_area.php?action=&sentsecid=<?=$sentsecid?>&search=<?=$search?>&key_name=<?=$key_name?>&key_surname=<?=$key_surname?>&key_idcard=<?=$key_idcard?>"><img src="../../images_sys/home.gif" alt="��Ѻ˹����ѡ" width="20" height="20" border="0"></a>&nbsp;��Ǩ�ͺ�͡��� �.�. 7 �鹩�Ѻ�ͧ&nbsp;<?=$fullname?> </strong></td>
          </tr>
        <tr>
          <td width="34%" align="center" bgcolor="#FFFFFF"><strong>��Ǵ��¡�� </strong></td>
          <td width="33%" align="center" bgcolor="#FFFFFF"><strong>ʶҹФ�������ó�ͧ�͡���</strong></td>
          <td width="33%" align="center" bgcolor="#FFFFFF"><strong>�����˵</strong>�</td>
          </tr>
<!--        <tr>
          <td align="left" bgcolor="#FFFFFF"> ʶҹ��͡��õ鹩�Ѻ</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="status_file"  id="status_file" type="radio" value="1" <?// if($rs_e[status_file] == "1"){ echo "checked=\"checked\"";}?>>
            ����ó�
            <input name="status_file" id="status_file" type="radio" value="0" <?// if($rs_e[status_file] == "0"){  echo "checked=\"checked\"";}?>>
            �������ó�
          </label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_file" value="<?//=$rs_e[comment_file]?>">
          </label></td>
          </tr>
-->        <tr>
          <td align="left" bgcolor="#FFFFFF">�ӹǹ���͡���</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <select name="page_num">
			<option value="0">�ӹǹ��</option>
			<?
				for($i=0;$i<15;$i++){
					if($rs_e[page_num] == $i){ $sel = "selected='selected'";}else{ $sel = "";}
					echo "<option value='$i' $sel>$i</option>";
				}
			?>
            </select>
            ��
          </label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="comment_page" type="text" value="<?=$rs_e[comment_page]?>" size="50">
          </label></td>
          </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">�ӹǹ�ٻ</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <select name="pic_num">
			<option value="0">�ӹǹ�ٻ</option>
			<?
				for($n=0;$n < 15; $n++){
					if($rs_e[pic_num] == $n){ $sel = "selected='selected'";}else{ $sel = "";}
					echo "<option value='$n' $sel>$n</option>";
				}
			?>
            </select>
          �ٻ</label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_pic" value="<?=$rs_e[comment_pic]?>" size="50">
          </label></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">�����ŷ����</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="general_status" type="radio" value="1" <? if($rs_e[general_status] == "1"){ echo "checked='checked'";}?>>
          ����ó� 
          <input name="general_status" type="radio" value="0" <? if($rs_e[general_status] == "0"){ echo "checked='checked'";}?>>
          �������ó�</label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_general" value="<?=$rs_e[comment_general]?>" size="50">
          </label></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">����ѵԡ���֡��</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="graduate_status" type="radio" value="1" <? if($rs_e[graduate_status] == "1"){ echo "checked='checked'";}?>>
          ����ó� 
          <input name="graduate_status" type="radio" value="0" <? if($rs_e[graduate_status] == "0"){ echo "checked='checked'";}?>>
          �������ó�</label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_graduate" value="<?=$rs_e[comment_graduate]?>" size="50">
          </label></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">���˹�����ѵ���Թ��͹ </td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="salary_status" type="radio" value="1" <? if($rs_e[salary_status] == "1"){ echo "checked='checked'";}?>>
          ����ó� 
          <input name="salary_status" type="radio" value="0" <? if($rs_e[salary_status] == "0"){ echo "checked='checked'";}?>>
          �������ó�</label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_salary" value="<?=$rs_e[comment_salary]?>" size="50">
          </label></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">�֡ͺ����д٧ҹ</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="seminar_status" type="radio" value="1" <? if($rs_e[seminar_status] == "1"){ echo "checked='checked'";}?>>
            ����ó�
            <input name="seminar_status" type="radio" value="0" <? if($rs_e[seminar_status] == "0"){ echo "checked='checked'";}?>>
          �������ó�</label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_seminar" value="<?=$rs_e[comment_seminar]?>" size="50">
          </label></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">�ŧҹ�ҧ�Ԫҡ��</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="sheet_status" type="radio" value="1" <? if($rs_e[sheet_status] == "1"){ echo "checked='checked'";}?>>
            ����ó�
          </label>
            <label>
            <input name="sheet_status" type="radio" value="0" <? if($rs_e[sheet_status] == "0"){ echo "checked='checked'";}?>>
            �������ó�</label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_sheet" value="<?=$rs_e[comment_sheet]?>" size="50">
          </label></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">����ͧ�Ҫ��������ó��</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="getroyal_status" type="radio" value="1" <? if($rs_e[getroyal_status] == "1"){ echo "checked='checked'";}?>>
          </label>
            ����ó�
            <input name="getroyal_status" type="radio" value="0" <? if($rs_e[getroyal_status] == "0"){ echo "checked='checked'";}?>>
            �������ó�</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_getroyal" value="<?=$rs_e[comment_getroyal]?>" size="50">
          </label></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">��������������ö�����</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="special_status" type="radio" value="1" <? if($rs_e[special_status] == "1"){ echo "checked='checked'";}?>>
          </label>
            <label>
            ����ó�
            <input name="special_status" type="radio" value="0" <? if($rs_e[special_status] == "0"){ echo "checked='checked'";}?>>
            �������ó�</label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_special" value="<?=$rs_e[comment_special]?>" size="50">
          </label></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">�����դ����ͺ</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="goodman_status" type="radio" value="1" <? if($rs_e[goodman_status] == "1"){ echo "checked='checked'";}?>>
            ����ó�          </label>
            <label>
            <input name="goodman_status" type="radio" value="0" <? if($rs_e[goodman_status] == "0"){ echo "checked='checked'";}?>>
            �������ó�</label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_goodman" value="<?=$rs_e[comment_goodman]?>" size="50">
          </label></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">�ӹǹ�ѹ����ش�Ҫ����</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="absent_status" type="radio" value="1" <? if($rs_e[absent_status] == "1"){ echo "checked='checked'";}?> >
            ����ó�          </label>
            <label>
            <input name="absent_status" type="radio" value="0" <? if($rs_e[absent_status] == "0"){ echo "checked='checked'";}?>>
            �������ó�</label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_absent" value="<?=$rs_e[comment_absent]?>" size="50">
          </label></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">�ѹ���������Ѻ�Թ��͹�������Ѻ�Թ��͹�������</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="nosalary_status" type="radio" value="1" <? if($rs_e[nosalary_status] == "1"){ echo "checked='checked'";}?>>
          </label>
            <label>
            ����ó�
            <input name="nosalary_status" type="radio" value="0" <? if($rs_e[nosalary_status] == "0"){ echo "checked='checked'";}?>>
            �������ó�</label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_nosalary" value="<?=$rs_e[comment_nosalary]?>" size="50">
          </label></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">������Ѻ�ɷҧ�Թ�� </td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="prohibit_status" type="radio" value="1" <? if($rs_e[prohibit_status] == "1"){ echo "checked='checked'";}?>>
            ����ó�          </label>
            <input name="prohibit_status" type="radio" value="0" <? if($rs_e[prohibit_status] == "0"){ echo "checked='checked'";}?>>
            �������ó�</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_prohibit" value="<?=$rs_e[comment_prohibit]?>" size="50">
          </label></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">��û�Ժѵ��Ҫ��þ����</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="specialduty_status" type="radio" value="1" <? if($rs_e[specialduty_status] == "1"){ echo "checked='checked'";}?>>
            ����ó�
            <input name="specialduty_status" type="radio" value="0" <? if($rs_e[specialduty_status] == "0"){ echo "checked='checked'";}?>>
          �������ó�</label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_specialduty" value="<?=$rs_e[comment_specialduty]?>" size="50">
          </label></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">��¡����� � ������</td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input name="other_status" type="radio" value="1" <? if($rs_e[other_status] == "1"){ echo "checked='checked'";}?>>
            ����ó�
            <input name="other_status" type="radio" value="0" <? if($rs_e[other_status] == "0"){ echo "checked='checked'";}?>>
          �������ó�</label></td>
          <td align="left" bgcolor="#FFFFFF"><label>
            <input type="text" name="comment_other" value="<?=$rs_e[comment_other]?>" size="50">
          </label></td>
        </tr>
        <tr>
          <td colspan="3" align="center" bgcolor="#FFFFFF"><label>
		  <input type="hidden" name="action" value="process">
		  <input type="hidden" name="idcard" value="<?=$idcard?>">
		  <input type="hidden" name="sentsecid" value="<?=$sentsecid?>">
            <input type="submit" name="Submit2" value="�ѹ�֡">
            &nbsp;
            <input type="reset" name="Submit3" value="��ҧ���">
			&nbsp;
            <input type="button" name="btnB" value="��͹��Ѻ" onClick="location.href='check_kp7_area.php?action=&sentsecid=<?=$sentsecid?>&search=<?=$search?>&key_name=<?=$key_name?>&key_surname=<?=$key_surname?>&key_idcard=<?=$key_idcard?>'">
          </label></td>
          </tr>
      </table>
        </form>
    </td>
  </tr>
</table>
<? }//end else if($action == "execute"){ ?>
</body>
</html>
