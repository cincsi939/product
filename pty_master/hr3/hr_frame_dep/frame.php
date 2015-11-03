<?
session_start();

if ($_SESSION[islogin]!=1){
	echo "<script>alert('กรุณา login เพื่อเข้าสู่ระบบ และเปิดรับ Cookie เพื่อเก็บสถานะการ login'); top.location.href='../index.php';</script>";
	exit;
}
?>
<html>
<head>
<?
		
		$loadGraph = "";
		$groupMenu = "";
        $headName = "ระบบฐานข้อมูลบุคลากร";
		if($_SESSION[islogin]==1){
			$left = "left_edit.php?id=$id&action=edit";
			//$reporturl ="kp7menu.php";
			$reporturl = "../hr_report/general_all_1compare.php?id=$id&action=edit";
		}else{
			$left = "left_edit.php?id=$id&action=edit";
			$reporturl = "../index.php";
		}
?>
<title><?=$headName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<frameset rows="52,*" cols="*" frameborder="NO" border="0" framespacing="0">
  <frame src="top_edit.php?headName=<?=$headName?>" name="topFrame" scrolling="NO" noresize>
    <frameset cols="215,*" frameborder="NO" border="0" framespacing="0">
    <frame src="<?=$left;?>" name="leftFrame" scrolling="NO" noresize>
    <frame src="<?=$reporturl;?>" name="mainFrame">
  </frameset>
</frameset>
<noframes><body>
</body></noframes>
</html>
