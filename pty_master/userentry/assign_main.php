<?

if($staffid == ""){
	echo "�Դ��ͼԴ��Ҵ ��س� login �������к������ա����";
	die;
}
?>
<html>
<head>
<title>�к������èѴ����ͺ���§ҹ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<frameset rows="50,*" cols="*" frameborder="no" border="0" framespacing="0">
  <frame src="assign_top.php" name="topFrame" scrolling=no>
  <frameset rows="*" cols="35%,65%" frameborder="no" border="0" framespacing="0" >
	  <frame src="assign_left.php?staffid=<?=$staffid?>" name="leftFrame" style="border:#666666 1px solid; border-left:#666666 2px groove">
	  <frame src="blankpage.php" name="mainFrame">
  </frameset>
</frameset>

<noframes><body>
</body></noframes>
</html>
