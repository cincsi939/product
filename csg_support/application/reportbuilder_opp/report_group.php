<?php
/**
 * @comment ตั้งค่า report group
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    04/08/2014
 * @access     public
 */
/*****************************************************************************
Function		: จัดการข้อมูล Report Group
Version			: 1.0
Last Modified	: 
Changes		:


*****************************************************************************/
include "db.inc.php";

$groupid = "";
if(isset($_GET['groupid'])){
	$groupid = intval($_GET['groupid']);
}
if(!isset($_GET['action'])){
	$_GET['action'] = "";
}
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == "POST"){ 
	$groupid = trim($_POST['groupid']);
	$groupname = trim($_POST['groupname']);
	if ($groupid){
		if ($_GET['action'] == "new"){
			if ($groupname > ""){
				$sql = "insert into groupinfo (groupid,groupname) values('$groupid','$groupname');"; 
				mysql_query($sql);
				if (mysql_errno()){
					$msg = "Cannot insert new group name.";
				}else{
					header("Location: ?");
					exit;
				}

			}else{
				$msg = "Group name cannot be blank. ";
			}
		}else if ($_GET['action'] == "edit"){
			if ($groupname > ""){
				mysql_query("update groupinfo set groupname='$groupname' where groupid= '$groupid';");
				if (mysql_errno()){
					$msg = "Cannot edit group name.";
				}else{
					header("Location: ?");
					exit;
				}

			}else{
				$msg = "Group name cannot be blank. ";
			}
			
		}

	}else{ //if ($groupid)
		$msg = "Group ID cannot be blank.";
	}

}else if ($_GET['action'] == "delete"){
		// check reportinfo
		$result = mysql_query("select * from reportinfo where groupid = '$groupid';");
		if (mysql_num_rows($result) > 0){
			$msg = "Cannot delete this group, there is report belong to this group.";
		}else{
			// Can delete 
			mysql_query("delete from groupinfo where groupid = '$groupid';");
			if (mysql_errno()){
				$msg = "Cannot delete group.";
			}else{
				header("Location: ?");
				exit;
			}

		}

}
?>

<html>
<head>
<title>Report Management : Report Group</title>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<link href="report.css" type="text/css" rel="stylesheet">
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/jquery-numeric.js"></script>
<?php // @mofidy Phada Woodtikarn 04/08/2014 ?>
<script>
	$(document).ready(function(){
		$('#groupid').numeric();
	});
</script>
<?php // @end ?>
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
?>

<?php
if ($_GET['action'] == "new" || $_GET['action'] == "edit"){
	if ($_GET['action'] == "edit"){
		$title = "Edit Group Name";
		$result = mysql_query("select * from groupinfo where groupid='$groupid';");
		$rs = mysql_fetch_assoc($result);
	}else{
		$title = "Add New Group Name";
	}
?>
<BR>
<FORM METHOD=POST ACTION="?action=<?=$_GET['action']?>">
<table border=0 width="90%" cellspacing=1 CELLPADDING=2 bgcolor=black align=center>
<tr BGCOLOR="#6699CC">
<td align=LEFT colspan=2> &nbsp; <B><?=$title?></B></td></tr>


<tr BGCOLOR="#E0E0E0">
<td align=right> Group ID &nbsp; </td>
<td > 
<?php
if ($_GET['action'] == "edit"){	
?>
<B><?=$groupid?></B>
<INPUT TYPE="hidden" NAME="groupid" VALUE="<?=$groupid?>">
<?php
}else{	
?>
<INPUT id="groupid" TYPE="text" NAME="groupid" VALUE="<?php echo isset($rs['groupid'])?$rs['groupid']:''; ?>" maxlength=10 size=10>
<?php
}	
?>
</td>
<tr>


<tr BGCOLOR="#E0E0E0">
<td align=right> Group Name &nbsp; </td>
<td > <INPUT TYPE="text" NAME="groupname" VALUE="<?php echo isset($rs['groupname'])?$rs['groupname']:''; ?>" maxlength=100 size=60> </td>
<tr>

<tr BGCOLOR="#808080">
<td align=center colspan=2> 
<INPUT TYPE="submit" VALUE="  Update  ">
<INPUT TYPE="reset" VALUE="  Reset  ">
<INPUT TYPE="button" VALUE="  Cancel  " ONCLICK="location.href='?';">
</td></tr>

</table>
</FORM>

<BR><BR>

</td></tr>
<tr HEIGHT=1 BGCOLOR="#000000"><td></td></tr>
</table>


</body>
</html>

<?php
	exit;
}
?>


<BR>
<table border=0 width="90%" cellspacing=1 CELLPADDING=2 bgcolor=black align=center>
<tr BGCOLOR="#E0E0E0"><th width=50> No. </th><th width=80>Group ID</th><th> Report Group</th><th>&nbsp;  </th></tr>

<?php
	$i=0;
	$result = mysql_query("select * from groupinfo order by groupid;");
	while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		$i++;
?>

<tr BGCOLOR="WHITE">
<td align=center width="30"> <?=$i?> </td>
<td > <?=$rs['groupid']?> </td>
<td > <?=$rs['groupname']?> </td>
<td align=center width="150"> 
	<INPUT CLASS="xbutton" style="width: 70;" TYPE="button" VALUE=" Edit " ONCLICK="location.href='?action=edit&groupid=<?=$rs['groupid']?>';"> 
	<INPUT CLASS="xbutton"  style="width: 70;" TYPE="button" VALUE=" Delete " ONCLICK="if (confirm('Are you sure to delete this group?\nAll data related with this report will be lost!!')) location.href='?action=delete&groupid=<?=$rs['groupid']?>';"> 
</td>
</tr>

<?php
	} //while

?>
</table>
<BR>

&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [ <A HREF="?action=new">Add Group</A> ]<br>
<BR><BR>

</td></tr>
<tr HEIGHT=1 BGCOLOR="#000000"><td></td></tr>
</table>


</body>
</html>
