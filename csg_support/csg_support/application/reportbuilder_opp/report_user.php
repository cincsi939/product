<?php
/**
 * @comment ตั้งค่า report user
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    04/08/2014
 * @access     public
 */
/*****************************************************************************
Function		: จัดการข้อมูล user
Version			: 1.0
Last Modified	: 
Changes		:


*****************************************************************************/
include "db.inc.php";
if(isset($_SESSION['priv']) && $_SESSION['priv'] == 'U'){
	echo "<script>window.location='report_manage.php'</script>";
}

$id = "";
if(isset($_GET['id'])){
	$id = intval($_GET['id']);
}
if(!isset($_GET['action'])){
	$_GET['action'] = "";
}
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == "POST"){ 
	$xuname=trim($_POST['xuname']);
	$email=trim($_POST['email']);
	$fullname=trim($_POST['fullname']);
	$comment=trim($_POST['comment']);
	$priv=trim($_POST['priv']);
	$pwd = $_POST['pwd'];

	if ($_GET['action'] == "new"){
		$sql = "insert into userinfo (uname,pwd,fullname,email,comment,priv) values('$xuname','$pwd','$fullname','$email','$comment','$priv');";
		mysql_query($sql);
		if (mysql_errno()){
			$msg = "Cannot add new user information.";
		}else{
			header("Location: ?");
			exit;
		}
	}else if ($_GET['action'] == "edit"){
		$sql = "update userinfo set fullname='$fullname',pwd='$pwd',email='$email',comment='$comment',priv='$priv' where uname='$xuname';";
		mysql_query($sql);
		if (mysql_errno()){
			$msg = "Cannot update user information.";
		}else{
			header("Location: ?");
			exit;
		}
	}

}else if ($_GET['action'] == "delete"){
		// delete from reportinfo
		if(isset($_GET['xuname'])){
			$uname = $_GET['xuname'];
			mysql_query("delete from userinfo where uname='$uname';");
			if (mysql_errno()){
				$msg = "Cannot delete user.";
			}else{
				header("Location: ?");
				exit;
			}
		}
}
?>

<html>
<head>
<title>Report Management : User</title>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<link href="report.css" type="text/css" rel="stylesheet">
</head>

<body bgcolor="#FFFFFF">

<table border=0 width="100%" cellspacing=1 bgcolor=black>
<tr><td>
<?php
// @modify Phada Woodtikarn 21/07/2014 เนื่องจาก menu ใช้หลายหน้าเลยสร้างไว้อันเดียว
include "report_top_menu.php";
// @end
?>
</td></tr>
</table>


<table border=0 width="100%" cellspacing=0 CELLPADDING=0>
<tr BGCOLOR="#AACCEE"><td>

<?php
// ERROR MESSAGE
if ($msg){
	echo "<h1 align=center>$msg</h1></body></html>";
	exit;
}

if ($_GET['action'] == "new" || $_GET['action'] == "edit"){
	if ($_GET['action'] == "edit"){
		$result = mysql_query('select * from userinfo where uname="'.$_GET['xuname'].'";');
		$rs = mysql_fetch_assoc($result);
	}
?>


<BR>
&nbsp; <B style="font-size: 14pt;">Create new user</B>


<table border=0 width="100%" cellspacing=0 CELLPADDING=0>
<tr HEIGHT=1 BGCOLOR="#000000"><td></td></tr>
</table>


<FORM ACTION="?action=<?=$_GET['action']?>" METHOD=POST>
<table border=0 width="80%" align=center cellspacing=0 CELLPADDING=0>


<tr><td><B>Privilege</B></td>
<td>
<SELECT NAME="priv">
<?php
	if ($rs['priv'] == "A"){
?>
<option value="U"> Report User
<option value="A" SELECTED> Report Administrator
<?php
	}else{
?>
<option value="U" SELECTED> Report User
<option value="A"> Report Administrator
<?php
	}
?>
</SELECT>
</td>
</tr>
<?php
	if ($_GET['action'] == "edit"){
?>
<tr><td><B>User Name</B></td><td> <B><?=$rs['uname']?></B>
<INPUT TYPE="hidden" NAME="xuname" VALUE="<?=$rs['uname']?>">
</td></tr>
<?php
}else{	
?>
<tr><td><B>User Name</B></td><td><INPUT TYPE="text" NAME="xuname" VALUE="<?php echo isset($rs['uname'])?$rs['uname']:''; ?>" size="20" maxlength="20"></td></tr>
<?php
}
?>


<tr><td><B>Password</B></td><td><INPUT TYPE="password" NAME="pwd" VALUE="<?php echo isset($rs['pwd'])?$rs['pwd']:'';?>" size="20" maxlength="20"></td></tr>

<tr><td><B>Full Name</B></td><td><INPUT TYPE="text" NAME="fullname" VALUE="<?php echo isset($rs['fullname'])?$rs['fullname']:'';?>" size="60" maxlength="100"></td></tr>

<tr><td><B>Email Address</B></td><td><INPUT TYPE="text" NAME="email" VALUE="<?php echo isset($rs['email'])?$rs['email']:'';?>" size="60" maxlength="100"></td></tr>

<tr valign=top><td><B>Comment</B></td><td><TEXTAREA NAME="comment" ROWS="6" COLS="60"><?php echo isset($rs['comment'])?$rs['comment']:'';?></TEXTAREA></td></tr>

<tr><td>&nbsp;</td><td ALIGN=LEFT>
<INPUT TYPE="SUBMIT" VALUE="   Update   ">
<INPUT TYPE="reset" VALUE="   Reset   ">
<INPUT TYPE="reset" VALUE="   Cancel   " onClick="location.href='?';">
</td></tr>

<?php
if (isset($_GET['msg2'])){
	echo "<tr><td>&nbsp;</td><td><B>$_GET[msg2]</B></td></tr>";
}
?>

</table>
</FORM>

<?php
}else{   // LIST ALL REPORT
?>

<BR>
<table border=0 width="98%" cellspacing=1 CELLPADDING=2 bgcolor=black align=center>
<tr BGCOLOR="#E0E0E0"><th>No.</th><th>User Name</th><th>Fullname</th><th> Email Address </th><th>&nbsp;  </th></tr>

<?php
	$i=0; 

	$result = mysql_query("select * from userinfo order by uname;");
	while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		$i++;

?>

<tr BGCOLOR="WHITE">
<td align=center width="30"> <?=$i?> </td>
<td > <?=$rs['uname']?> </td>
<td > <?=$rs['fullname']?> </td>
<td > <?=$rs['email']?> </td>
<td align=center width="350"> 
	<INPUT CLASS="xbutton" style="width: 70;" TYPE="button" VALUE=" Edit " ONCLICK="location.href='?action=edit&xuname=<?=$rs['uname']?>';"> 
	<INPUT CLASS="xbutton"  style="width: 70;" TYPE="button" VALUE=" Delete " ONCLICK="if (confirm('Are you sure to delete this user?\nAll data related with this user will be lost!!')) location.href='?action=delete&xuname=<?=$rs['uname']?>';"> 

</td>
</tr>

<?php
	} //while

?>
</table>
<BR><BR>
&nbsp; [ <A HREF="?action=new">Add New User</A> ]<BR><BR>
<?php
}	
?>

</td></tr>
<tr HEIGHT=1 BGCOLOR="#000000"><td></td></tr>
</table>


</body>
</html>
