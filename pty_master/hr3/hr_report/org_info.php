<?
include "epm.inc.php";


$Max_File_Size = 100000; //��˹���Ҵ������˭����ش���͹حҵ��� upload �ҷ�� Server ��˹����� byte 
$File_Type_Allow = array("application/x-zip-compressed" /*.zip*/, 
                    "text/plain" /*.txt*/, 
                    "image/bmp" /* .bmp, .ico*/, 
                    "image/gif" /* .gif*/, 
                    "image/pjpeg" /*.jpg, .jpeg*/, 
                    "image/jpeg" /* .jpg, .jpeg*/
); //��˹��������ͧ��������������㴺�ҧ���͹حҵ��� upload �ҷ�� Server 

function check_type($type_check) { //�繿ѧ��ѹ ����Ǩ�ͺ��� ����� upload ����㹻��������͹حҵ�������� 
   global $File_Type_Allow; 
   for ($i=0;$i<count($File_Type_Allow);$i++) { 
      if ($File_Type_Allow[$i] == $type_check) { 
         return true; 
      } 
   } 
   return false; 
} 

function validate_form($file_input,$file_size,$file_type) { //�� function ����������Ǩ�ͺ������������ upload �ç������͹��������� 
   global $Max_File_Size,$File_Type_Allow; 
   if ($file_input == "none") { 
      $error = "����� file ��� Upload"; 
   } elseif ($file_size > $Max_File_Size) { 
      $error = "��Ҵ����˭���� $Max_File_Size 亵�"; 
   } elseif (!check_type($file_type,$File_Type_Allow)) { 
      $error = "����������� ���͹حҵ��� Upload"; 
   } else { 
      $error = false; 
   } 
   return $error; 
} 

if ($_SERVER[REQUEST_METHOD] == "POST"){ 

	$result = mysql_query("select max(NID) as lastid from $maintbl ");
	$rs = mysql_fetch_assoc($result);
	$nextid = intval($rs[lastid]) + 1;
	
	if($banner != ""){
		$msg_err = validate_form($banner,$banner_size,$banner_type);	
	}
	if($map != ""){
		$msg_err = validate_form($map,$map_size,$map_type);	
	}

	if($msg_err){ 	
		echo "<SCRIPT language=JavaScript>";
		echo "alert('$msg_err');";
		echo "window.location = 'add_form_admin.php?id=$id';";
		echo "</script>"; 
	}

	$result = mysql_query("select max(POSITION) as lastposition from $maintbl where PARENT_ID='$parent' ;");
	$rs = mysql_fetch_assoc($result);
	$nextposition = intval($rs[lastposition]) + 1;
	if ($action == "newgroup"){
		$sql = "insert into $maintbl (NID,PARENT_ID,POSITION,NLABEL,NVALUE,MTYPE,NLABEL_ENG ,address,address_eng,url,tel1,tel2,fax,email, website,banner,map) values('$nextid','$parent','$nextposition','$NLABEL','','1','$NLABEL_ENG','$address','$address_eng','$url','$tel1','$tel2','$fax','$email','$website','$banner','$map');";
	}else if ($action == "editgroup"){
		$sql = " UPDATE $maintbl SET  NLABEL =  '$NLABEL',NLABEL_ENG = '$NLABEL_ENG',address = '$address',address_eng = '$address_eng',url = '$url',tel1 = '$tel1',tel2 = '$tel2',fax = '$fax',email = '$email', website = '$website',banner = '$banner',map = '$map'  WHERE  NID = '$id' ; ";
/*	}else if ($action == "new"){
		$sql = "insert into $maintbl (NID,PARENT_ID,POSITION,NLABEL,NVALUE,MTYPE) values('$nextid','$parent','$nextposition','$NLABEL','$NVALUE',0);";
	}else if ($action == "edit"){
		$sql = "update $maintbl set NLABEL='$NLABEL',NVALUE='$NVALUE' where NID='$id' ;";
*/	}
	
	mysql_query($sql);
	if ($action == "newgroup"){//����˹��§ҹ����
		$id=mysql_insert_id();
		//automatic add group 'guest' ����Ѻ˹��§ҹ��� ��� add admin ����Ѻ˹��§ҹ�ѵ��ѵ�
		mysql_query("insert into $epm_staffgroup (org_id,groupname,comment) values('$id','Guest','Guest ����Ѻ˹��§ҹ $NLABEL');");
		$gid = mysql_insert_id(); //id �ͧ group ����� insert �
		mysql_query("insert into $epm_staff (org_id,staffname,username) values('$id','Administrator ����Ѻ˹��§ҹ $NLABEL','admin_$id');");
		$staffid = mysql_insert_id(); //id �ͧ staff ����� insert �
		mysql_query("insert into epm_groupmember(gid,staffid) values('$gid','$staffid');");

		$id = $parent;
	}	
	//header("Location: ?id=$id");
	echo "<script>alert('�ѹ�֡���������º��������'); parent.leftFrame.location=parent.leftFrame.location; location.href='?id=$id';</script>";
	exit;
}else{ // if ($_SERVER[REQUEST_METHOD] == "POST"){ 

	if ($action == "deletegroup"){
		if (Query1("select count(*) from $maintbl where PARENT_ID='$id';") > 0){
			$msg = "�������öź�� �����ѧ��˹��§ҹ�����˹��§ҹ���";
		}

		if (Query1("select count(*) from $epm_staff where org_id='$id';") > 0){
			$msg = "�������öź�� �����ѧ�պؤ�ҡ��ѧ�Ѵ�˹��§ҹ���";
		}

		if (Query1("select count(*) from $epm_staffgroup where org_id='$id';") > 0){
			$msg = "�������öź�� �����ѧ�ա�����ؤ�ҡ������˹��§ҹ���";
		}

		if ($msg == ""){
			mysql_query("delete from $maintbl where NID='$id';");
			$msg = "ź���������º��������";
			echo "<script>alert('$msg'); parent.leftFrame.location=parent.leftFrame.location; location.href='blankpage.php';</script>";
			exit;
		}else{
			echo "<script>alert('$msg'); location.href='?id=$id';</script>";
			exit;
		}
	}


}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<title></title>

<SCRIPT language=JavaScript>
function checkFields() {
	missinginfo1 = "";
	missinginfo = "";
	if (document.form1.name.value == "")  {	missinginfo1 += "\n- ��ͧ����ͧ����������ö�繤����ҧ"; }		
	if (document.form1.name.value == "")  {	missinginfo1 += "\n- ��ͧ����˹��§ҹ�ç����������ö�繤����ҧ"; }		
	if (document.form1.name.value == "")  {	missinginfo1 += "\n- ��ͧ����˹��§ҹ�ç����������ö�繤����ҧ"; }		
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
<?
if ($action == "newgroup" || $action == "editgroup"){
	if ($action == "editgroup"){
		$result = mysql_query("select * from $maintbl where NID='$id';");
		$rs = mysql_fetch_assoc($result);
		$title = "���";
	}else{
		$title = "����";
	}
?>

<FORM METHOD=post name="form1" ACTION="?" enctype="multipart/form-data"  onSubmit="return checkFields()">
<INPUT TYPE="hidden" NAME="action" VALUE="<?=$action?>">
<INPUT TYPE="hidden" NAME="parent" VALUE="<?=$parent?>">
<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">

<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=2 ALIGN=CENTER WIDTH="98%">

<TR VALIGN=TOP BGCOLOR="#336699"><TD colspan=2> &nbsp; <B STYLE="color: WHITE;"><?=$title?>ͧ���<?=$parentname?></B> </TD></TR>

<tr>
  <td align="right" bgcolor="#a3b2cc">&nbsp;����ͧ��� : * </td>
  <td><input name="NLABEL" type="text" id="name" value="<?=$rs[NLABEL]?>" size="80"></td>
</tr>
<tr>
  <td align="right" bgcolor="#a3b2cc">&nbsp;����ͧ��� (English) :</td>
  <td><input name="NLABEL_ENG" type="text" id="name_eng" value="<?=$rs[NLABEL_ENG]?>" size="80"></td>
</tr>
<tr>
  <td align="right" bgcolor="#a3b2cc">&nbsp;����� :  </td>
  <td><input name="address" type="text" id="address" value="<?=$rs[address]?>" size="80"></td>
</tr>
<tr>
  <td align="right" bgcolor="#a3b2cc">&nbsp;����� (English) :</td>
  <td><input name="address_eng" type="text" id="address_eng" value="<?=$rs[address_eng]?>" size="80"></td>
</tr>
<tr>
  <td align="right" bgcolor="#a3b2cc">&nbsp;URL : </td>
  <td><input name="url" type="text" id="url" value="<?=$rs[url]?>" size="80"></td>
</tr>
<tr>
  <td align="right" bgcolor="#a3b2cc">&nbsp;��. (1) :</td>
  <td><input name="tel1" type="text" id="tel1" value="<?=$rs[tel1]?>" size="80"></td>
</tr>
<tr>
  <td align="right" bgcolor="#a3b2cc">&nbsp;��. (2) :</td>
  <td><input name="tel2" type="text" id="tel2" value="<?=$rs[tel2]?>" size="80"></td>
</tr>
<tr>
  <td align="right" bgcolor="#a3b2cc">&nbsp;�����  :</td>
  <td><input name="fax" type="text" id="fax" value="<?=$rs[fax]?>" size="80"></td>
</tr>
<tr>
  <td align="right" bgcolor="#a3b2cc">&nbsp;email : </td>
  <td><input name="email" type="text" id="email" value="<?=$rs[email]?>" size="80"></td>
</tr>
<tr>
  <td align="right" bgcolor="#a3b2cc">&nbsp;website :</td>
  <td><input name="website" type="text" id="website" value="<?=$rs[website]?>" size="80"></td>
</tr>
<tr>
  <td align="right" bgcolor="#a3b2cc">&nbsp;��һ�Ш�˹��§ҹ : </td>
  <td><input name="banner" type="file" id="banner" size="50"></td>
</tr>
<tr>
  <td align="right" bgcolor="#a3b2cc">&nbsp;Ἱ��� : </td>
  <td><input name="map" type="file" id="map" size="50">
  </td>
</tr>


<tr height=1 bgcolor="#808080"><td colspan=2></td></tr>


<TR VALIGN=TOP><TD colspan=2 align="center">
<INPUT TYPE="submit" VALUE=" �ѹ�֡ " STYLE="width: 100px;">
<INPUT TYPE="reset" VALUE=" ¡��ԡ " STYLE="width: 100px;" ONCLICK="location.href='?id=<?=$id?>';">
&nbsp; &nbsp; &nbsp; <B><?=$msg?></B>
</TD>
</TR>
</TABLE>
</FORM>



</body>
</html>

<?
	exit; 
}	
?>


<?
//================================================================
// �ʴ���������´˹��§ҹ
//================================================================
 $sql ="SELECT *  FROM $maintbl  WHERE  NID = '$id' ";
 $query_result=mysql_db_query($dbname,$sql);
 $rs = mysql_fetch_assoc($query_result);

?>

<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#808080">
  <tr valign="top" bgcolor="#336699">
    <td colspan="2" bgcolor="#DDE0EF" class="headerTB"><img src="dtree/img/base.gif">&nbsp;<?=$rs[NLABEL]?></td>
</tr>

  <tr valign="top" bgcolor="#336699">
    <td colspan="2" bgcolor="#E0E0FF" >

<table border=0 cellspacing=0 cellpadding=0>
<tr>
<td align=center width="100">
<A HREF="?action=newgroup&parent=<?=$id?>"><img src="images/department_add.gif" border=0><BR>
����˹��§ҹ����</A>
</td>

<td align=center width="100">
<A HREF="org_user.php?action=new&org_id=<?=$id?>"><img src="images/user_add.gif" border=0><BR>
�����ؤ�ҡ�</A>
</td>

<td align=center width="100">
<A HREF="org_group.php?org_id=<?=$rs[NID]?>"><img src="images/group_add.gif" border=0><BR>
����������ؤ�ҡ�</A>
</td>

<td align=center width="150">
<A HREF="?action=editgroup&id=<?=$rs[NID]?>"><img src="images/info_edit.gif" border=0><BR>
�����������´˹��§ҹ
</A>
</td>

<td align=center width="100">
<A HREF="#" ONCLICK="if(confirm('��ҹ��ͧ���ź˹��§ҹ������������?')) location.href='?action=deletegroup&id=<?=$rs[NID]?>';"><img src="images/department_delete.gif" border=0><BR>
ź˹��§ҹ���</A>
</td>

</tr>
</table>


	</td>
  </tr>
  <tr>
    <td width="24%" align="right" bgcolor="#a3b2cc">&nbsp;����˹��§ҹ : </td>
    <td width="76%" bgcolor="#EFEFEF">&nbsp;<?=$rs[NLABEL]?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#a3b2cc">&nbsp;����˹��§ҹ (English) :</td>
    <td bgcolor="#EFEFEF">&nbsp;<?=$rs[NLABEL_ENG]?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#a3b2cc">&nbsp;����� : </td>
    <td bgcolor="#EFEFEF">&nbsp;<?=$rs[address]?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#a3b2cc">&nbsp;����� (English) :</td>
    <td bgcolor="#EFEFEF">&nbsp;<?=$rs[address_eng]?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#a3b2cc">&nbsp;URL : </td>
    <td bgcolor="#EFEFEF">&nbsp;<?=$rs[url]?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#a3b2cc">&nbsp;��. (1) : </td>
    <td bgcolor="#EFEFEF">&nbsp;<?=$rs[tel1]?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#a3b2cc">&nbsp;��. (2) :&nbsp;</td>
    <td bgcolor="#EFEFEF">&nbsp;<?=$rs[tel2]?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#a3b2cc">&nbsp;�����  :&nbsp;</td>
    <td bgcolor="#EFEFEF">&nbsp;<?=$rs[fax]?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#a3b2cc">&nbsp;email : </td>
    <td bgcolor="#EFEFEF">&nbsp;<?=$rs[email]?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#a3b2cc">&nbsp;website :</td>
    <td bgcolor="#EFEFEF">&nbsp;<?=$rs[website]?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#a3b2cc">&nbsp;��һ�Ш�˹��§ҹ : </td>
    <td bgcolor="#EFEFEF">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#a3b2cc">&nbsp;Ἱ��� : </td>
    <td bgcolor="#EFEFEF">&nbsp;</td>
  </tr>
  <tr height="1" bgcolor="#808080">
    <td colspan="2"></td>
  </tr>
  <tr valign="top">
    <td colspan="2" align="center">&nbsp; &nbsp; &nbsp;
	</td>
  </tr>
</table>



</body>
</html>
