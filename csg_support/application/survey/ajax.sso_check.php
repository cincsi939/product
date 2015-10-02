<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Tanachai Khampukhew (tanachai@sapphire.co.th)
 * @created  30/08/2014
 * @access  public
 */
 include("../../config/config_host.php"); #อ้างหาค่า Define
?>
<html>
<head>
<title>application management</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script src="../js/jquery.js" type="text/javascript"></script>
</head>
<body >
<input type="button" id="connect" value="ตรวจสอบ">
<iframe id="checkFrame" src="" style="width:300px; height:300px;"></iframe>
<div id="testData" style="width:100%; height:500px; float:left;">

</div>
</body>
<script>
$(document).ready(function(){
	$('#connect').click(function(){
		var url = "http://www.sso.go.th/wpr/service04.jsp?cat=828&webId=0&pid=1509900563241";
		$('#checkFrame').attr('src',url).load(function(){
			alert('check');
		});;
		/*var text = $('#checkFrame').contents().find('body').html();
		alert(text);*/
	});
});
</script>
</html>