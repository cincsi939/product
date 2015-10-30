<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="../../../common/SMLcore/TheirParty/js/jquery-1.10.2.min.js"></script>
<?php include '../../../common/SMLcore/Plugin/UploadFile/UploadFile.php'; ?>
</head>
<body>
<?php

		//default
		/*$Options = array(
				'path' => './',
				'foldername' => 'plugin',
				'rename' => null,
				'themecss' => 'default',
				'maxfilesize' => 5000000,
				'acceptfiletypes' => '/(\.|\/)(gif|jpe?g|png)$/i',
				'maxnumberoffiles' => 3
				);*/
		$options = array(
		 				'path' => '../../../common/',
						'rename' => 'test',
						'foldername' => '.'
						);
						
						
		$testupload = new uploadfile($options);
?>
</body>
</html>