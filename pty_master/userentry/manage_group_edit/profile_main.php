<?
	
	$bpage = "profile_list.php";
?>

<html>
<head>
<title>ระบบจัดกลุ่มช่วงเวลาการแก้ไขข้อมูล</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<frameset rows="50,*" cols="*" frameborder="no" border="0" framespacing="0">
  <frame src="profile_top.php" name="topFrame" scrolling=no>
  <frameset rows="*" cols="35%,65%" frameborder="no" border="0" framespacing="0" >
	  <frame src="profile_left.php" name="leftFrame" style="border:#666666 1px solid; border-left:#666666 2px groove">
	  <frame src="<?=$bpage?>" name="mainFrame">
  </frameset>
</frameset>

<noframes><body>
</body></noframes>
</html>
