<?php
/**
 * @comment ตั้งค่า report หลัก
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    02/08/2014
 * @access     public
 */
/*****************************************************************************
Function		: จัดการข้อมูล Report ทั้งหมด (Add New / Edit / Preview)
Version			: 1.0
Last Modified	: 
Changes		:

*****************************************************************************/
include "db.inc.php";

$uname=""; // default user name
$id = "";
$action = "";
if(isset($_GET['id'])){
	$id = intval($_GET['id']);
}
if(isset($_GET['action'])){
	$action = $_GET['action'];
}
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == "POST"){ 
	if ($action == "new"){
		$tid = intval($_POST['tid']);
		$rtype = intval($_POST['rtype']);
		$groupid = trim($_POST['groupid']);
		$subid = trim($_POST['subid']);
		$caption = addslashes($_POST['caption']);
		$comment = addslashes($_POST['comment']);
		$t = "1x1*1x1|1x1*1x1";
		$defaultbg = "#A3B2CC";

		if ($subid == ""){
			$msg = "You must specify ID for this report";
		}else if (mysql_num_rows(mysql_query("SELECT * FROM reportinfo WHERE groupid='$groupid' AND subid='$subid';"))){
			$msg = "ID has already exist for this group.";
		}else if ($caption != ""){
			//find max ID แทนที่ autonumber
			$result = mysql_query("SELECT max(rid) as maxid FROM reportinfo WHERE uname='$uname';");
			$rs = mysql_fetch_assoc($result);
			$newid = intval($rs['maxid']) + 1;

			if ($tid == 0) { // no template
				mysql_query("INSERT INTO reportinfo(uname,rid,caption,rtype,comment,table1,table2,table3,table4,bgcolor,groupid,subid,bannerurl,bstyle,bstretch) VALUES('$uname','$newid','$caption','$rtype','$comment','$t','$t','$t','$t','$defaultbg','$groupid','$subid','',3,0);");
			}else{  // select data from template
				$result = mysql_query("select * from templateinfo where tid=$tid");
				if ($result){
					$rs = mysql_fetch_assoc($result);
					$tdata = stripslashes($rs['tdata']);
					eval($tdata);
			
					//ปรับค่าที่เก็บไว้เป็น ค่าใหม่ที่ป้อนเข้าไป
					$reportinfo[0]['rid'] = $newid; 
					$reportinfo[0]['caption'] = $caption; 
					$reportinfo[0]['groupid'] = $groupid; 
					$reportinfo[0]['subid'] = $subid; 
					$reportinfo[0]['rtype'] = $rtype; 
					$reportinfo[0]['comment'] = $comment; 

					$s1 = $s2 = "";
					foreach ($reportinfo[0] as $key => $value){
						if ($s1 > "") $s1 .= ",";
						if ($s2 > "") $s2 .= ",";
						$s1 .= $key;
						$s2 .= "'" . addslashes($value) ."'";
					}

					mysql_query("INSERT INTO reportinfo ($s1) VALUES($s2);");
					if (mysql_errno() == 0){ // no error
						//$rid = mysql_insert_id();  // new rid inserted

						// CellInfo
						for ($i=0;$i<count($cellinfo);$i++){
							$s1 = $s2 = "";
							$cellinfo[$i]['rid'] = $newid;  // change report id
							foreach ($cellinfo[$i] as $key => $value){
								if ($s1 > "") $s1 .= ",";
								if ($s2 > "") $s2 .= ",";
								$s1 .= $key;
								$s2 .= "'" . addslashes($value) ."'";
							}

							mysql_query("INSERT INTO cellinfo ($s1) VALUES($s2);");

						}

						// ParamInfo
						for ($i=0;$i<count($paraminfo);$i++){
							$s1 = $s2 = "";
							$paraminfo[$i]['rid'] = $newid;  // change report id
							foreach ($paraminfo[$i] as $key => $value){
								if ($s1 > "") $s1 .= ",";
								if ($s2 > "") $s2 .= ",";
								$s1 .= $key;
								$s2 .= "'" . addslashes($value) ."'";
							}

							mysql_query("INSERT INTO paraminfo ($s1) VALUES($s2);");

						}

					} else{ // error
						$msg = "Cannot add new Report.";
					}

					// DONE
				}else{
					$msg = "Cannot find Template data.";
				}
			}

			if (mysql_errno() || $msg > ""){
				$msg = "Cannot add new Report.";
			}else{
				header("Location: ?");
				exit;
			}
		}else{
			$msg = "Caption cannot be blank. ";
		}
	}

}else if($action == "delete"){
		// delete from reportinfo
		mysql_query("delete from cellinfo where rid = '$id' and uname='$uname';");
		if (mysql_errno()){
			$msg = "Cannot delete Report.";
		}else{
			// also delete from cellinfo
			mysql_query("delete from paraminfo where rid = '$id' and uname='$uname';");

			// also delete from cellinfo
			mysql_query("delete from reportinfo where rid = '$id' and uname='$uname';");
			if (mysql_errno()){
				$msg = "Cannot delete Report.";
			}else{
				header("Location: ?id=$id");
				exit;
			}
		}

}
?>

<html>
<head>
<title>Report Management : Main</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="report.css" type="text/css" rel="stylesheet">
<?php // @mofidy Phada Woodtikarn 21/07/2014 ?>
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/jquery-numeric.js"></script>
<script>
	$(document).ready(function(){
		$('#subid').numeric();
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

<?
// ERROR MESSAGE
if ($msg){
	echo "<h1 align=center>$msg</h1></body></html>";
	exit;
}

if ($action == "new"){
?>
<BR>
&nbsp; <B style="font-size: 14pt;">Create new report</B>
<table border=0 width="100%" cellspacing=0 CELLPADDING=0>
<tr HEIGHT=1 BGCOLOR="#000000"><td></td></tr>
</table>
<FORM ACTION="?action=new" METHOD=POST>
<table border=0 width="80%" align=center cellspacing=0 CELLPADDING=0>
<tr><td><B>Report Group</B></td>
<td>
<SELECT NAME="groupid">
<option value=""> - Select report group - </option>
<?
	$result = mysql_query("select * from groupinfo order by groupid;");
	while ($rs=mysql_fetch_assoc($result)){
		echo "<option value='$rs[groupid]'>$rs[groupid] : $rs[groupname]</option>";
	}

?>
</SELECT>
</td>
</tr>

<tr><td><B>ID</B></td><td><INPUT TYPE="text" id="subid" NAME="subid" VALUE="<?=$rs['subid']?>" size="10" maxlength="10"></td></tr>

<tr><td><B>Caption</B></td><td><INPUT TYPE="text" NAME="caption" VALUE="<?=$rs['caption']?>" size="60" maxlength="100"></td></tr>

<tr height=20><td colspan=2></td></tr>

<tr><td><B>Report Style</B></td>
<td>
<select name="rtype">
<?php // @modify Phada Woodtikarn 21/07/2014 เพิ่ม rtype ?>
    <option value="0" <?php echo $rs['rtype']==0?'selected':'';?>>Normal
    <option value="1" <?php echo $rs['rtype']==1?'selected':'';?>>Comparision
    <option value="2" <?php echo $rs['rtype']==2?'selected':'';?>>Comparision without DIFF
    <option value="3" <?php echo $rs['rtype']==3?'selected':'';?>>No Header Parameter
<?php // @end ?>
</select>
</td>
</tr>

<tr><td><B>Template</B></td><td>
<select name="tid">
<option value="0">No Template
<?
$tresult = mysql_query("select * from templateinfo order by tid;");	
while ($trs = mysql_fetch_assoc($tresult)){
	echo "<option value='$trs[tid]'>$trs[caption]\n";
}
?>
</select>
</td></tr>

<tr valign=top><td><B>Description</B></td><td><TEXTAREA NAME="comment" ROWS="6" COLS="60"><?=$rs['comment']?></TEXTAREA></td></tr>

<tr><td>&nbsp;</td><td ALIGN=LEFT><INPUT TYPE="SUBMIT" VALUE="   Update   ">
<INPUT TYPE="reset" VALUE="   Undo   " CLASS="xbutton">
<INPUT TYPE="reset" VALUE="   Reset   "></td></tr>

<?
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
<?php // @modify Phada Woodtikarn 21/07/2014 เพิ่มการเลือกเฉพาะกลุ่ม 
$postgroupid = "";
if(isset($_POST['groupid'])){
	$postgroupid = 	$_POST['groupid'];
}
?>
<table width="98%" border="0" align="center">
	<tr>
    	<td>
        	<form method="POST">
                <select name="groupid">
                	<option value=""> - Select report group - </option>
					<?php
                        $result = mysql_query("SELECT groupid,groupname FROM groupinfo ORDER BY groupid;");
                        while ($rs=mysql_fetch_assoc($result)){
					?>
                            <option value="<?php echo $rs['groupid']?>" <?php echo $postgroupid==$rs['groupid']?'selected':'' ?>>
								<?php echo $rs['groupid'].' : '.$rs['groupname'] ?>
                            </option>";
                    <?php
                        }
                    ?>
                </select>
                <input class="xbutton" style="" type="submit" value="Select Group"> 
            </form>
		</td>
	</tr>
</table>
<?php // @edn ?>
<table border=0 width="98%" cellspacing=1 cellpadding=2 bgcolor="black" align="center">
<tr BGCOLOR="#E0E0E0">
	<th>No.</th>
    <th>rid</th>
    <th>ID</th>
    <th width="381"> Report's Caption </th>
    <?php // @modify Phada Woodtikarn 25/09/2014 เพิ่ม Column Description ?>
    <th> Description </th>
    <?php // @end ?>
    <th>&nbsp;</th>
</tr>
<?php
	$i=0; $gid=-1;
	// @modify Phada Woodtikarn 21/07/2014 แบj' groupid
	if(isset($_POST['groupid']) and $_POST['groupid'] != ''){
		$sql = "SELECT 
					r.groupid,r.rid,r.subid,r.caption,r.comment,g.groupname 
				FROM reportinfo r 
					LEFT JOIN groupinfo g ON 
					r.groupid=g.groupid 
				WHERE 
					r.uname='$uname' AND
					r.groupid='$_POST[groupid]'
				ORDER BY r.groupid,r.subid;";
	}else{
		$sql = "SELECT 
					r.groupid,r.rid,r.subid,r.caption,r.comment,g.groupname 
				FROM reportinfo r 
					LEFT JOIN groupinfo g ON 
					r.groupid=g.groupid 
				WHERE 
					r.uname='$uname' 
				ORDER BY r.groupid,r.subid;";
	}
	$result = mysql_query($sql);
	// @end
	while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		$i++;
		if ($rs['groupid'] != $gid){
			if ($rs['groupid'] == "0" || $rs['groupid'] == ""){
				$gname = 'No Group';
			}else{
				$gname = $rs['groupid'].' : '.$rs['groupname'];
			}

?>
<tr BGCOLOR="#C0C0C0">
	<td colspan="6">&nbsp;<?php echo $gname?></td>
</tr>
<?php
			$gid = $rs['groupid'];
		}
?>
<tr BGCOLOR="WHITE">
    <td align=center width="29"><?php echo $i; ?></td>
    <td align=center width="42"><?php echo $rs['rid']; ?></td>
    <td align=center width="126"><?php echo $rs['groupid']."-".$rs['subid'];?></td>
    <td><?php echo strip_tags($rs['caption'])?></td>
    <?php // @modify Phada Woodtikarn 25/09/2014 เพิ่ม Column Description ?>
    <td><?php echo $rs['comment']; ?></td>
    <?php // @end ?>
    <td align=center width="380px"> 
        <INPUT CLASS="xbutton" TYPE="button" VALUE=" Load " ONCLICK="window.open('report_edit.php?id=<?=$rs['rid']?>','_blank');"> 
        <INPUT CLASS="xbutton" TYPE="button" VALUE=" Preview " ONCLICK="window.open('report_preview.php?id=<?=$rs['rid']?>','_blank');"> 
        <INPUT CLASS="xbutton" TYPE="button" VALUE=" Delete " ONCLICK="if (confirm('Are you sure to delete this report?\nAll data related with this report will be lost!!')) location.href='?action=delete&id=<?=$rs['rid']?>';"> 
        <INPUT CLASS="xbutton" TYPE="button" VALUE=" Save as Template " ONCLICK="location.href='report_template.php?action=save&id=<?=$rs['rid']?>';">
    </td>
</tr>

<?php
	} //while
// List Template
?>
</table>
<BR><BR>
<table border=0 width="98%" cellspacing=1 CELLPADDING=2 bgcolor=black align=center>
<tr BGCOLOR="#E0E0E0"><th> No. </th><th> Template's Caption </th><th>&nbsp;  </th></tr>
<?php
	$i=0;
	$result = mysql_query("select * from templateinfo order by tid;");
	while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		$i++;
?>

<tr BGCOLOR="WHITE">
<td align=center width="30"> <?=$i?> </td>
<td > <?=$rs['caption']?> </td>
<td align=center width="250"> 
	<INPUT CLASS="xbutton" style="width: 70;" TYPE="button" VALUE=" Edit " ONCLICK="location.href='report_template.php?action=edit&id=<?=$rs['tid']?>';"> 
	<INPUT CLASS="xbutton" style="width: 70;" TYPE="button" VALUE=" Preview " ONCLICK="window.open('report_template.php?action=preview&id=<?=$rs['tid']?>','_blank');"> 
	<INPUT CLASS="xbutton"  style="width: 70;" TYPE="button" VALUE=" Delete " ONCLICK="if (confirm('Are you sure to delete this Template?\nAll data related with this Template will be lost!!')) location.href='report_template.php?action=delete&id=<?=$rs['tid']?>';"> 
</td>
</tr>

<?
	}


}	
?>

</table>
<BR><BR>

</td></tr>
<tr HEIGHT=1 BGCOLOR="#000000"><td></td></tr>
</table>


</body>
</html>
