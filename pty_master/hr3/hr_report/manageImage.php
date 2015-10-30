<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8' />
        <title>manage Image</title>
    </head>
    <body>
        <?php
        include '../../../common/SMLcore/Plugin/WideImage/WideImage.php';
        $Iurl = '';
        $Cx = '';
        $Cy = '';
        $Cwidth = '';
        $Cheight = '';
        $Iwidth = '';
        $Iheight = '';

        isset($_POST['Iurl']) ? $Iurl = $_POST['Iurl'] : exit();
        isset($_POST['Cx']) ? $Cx = $_POST['Cx'] : exit();
        isset($_POST['Cy']) ? $Cy = $_POST['Cy'] : exit();
        isset($_POST['Cwidth']) ? $Cwidth = $_POST['Cwidth'] : exit();
        isset($_POST['Cheight']) ? $Cheight = $_POST['Cheight'] : exit();
        isset($_POST['Iwidth']) ? $Iwidth = $_POST['Iwidth'] : exit();
        isset($_POST['Iheight']) ? $Iheight = $_POST['Iheight'] : exit();
        
		$imageurl = '';
        $imagethumbnailUrl = '';
		$newname = '';
        isset($_POST['imageurl']) ? $imageurl = $_POST['imageurl'] : exit();
		isset($_POST['imagethumbnailUrl']) ? $imagethumbnailUrl = $_POST['imagethumbnailUrl'] : exit();
	 	isset($_POST['newname']) ? $newname = $_POST['newname'] : exit();		
        $fileoldname =  basename($imageurl, ".".pathinfo($imageurl, PATHINFO_EXTENSION)."");
				
        echo $Cx . '<br>';
        echo $Cy . '<br>';
        echo $Cwidth . '<br>';
        echo $Cheight . '<br>';
        echo $Iwidth . '<br>';
        echo $Iheight . '<br>';

        // resize
        $thumb = WideImage::load($Iurl)->resize($Iwidth, $Iheight);

        // crop
        $thumb = $thumb->crop($Cx, $Cy, $Cwidth, $Cheight);

        // save
        $thumb->saveToFile('../../../common/'.str_replace($fileoldname,$newname,$imageurl));        
        $thumb = $thumb->resize(80);
        $thumb->saveToFile('../../../common/'.str_replace($fileoldname,$newname,$imagethumbnailUrl));
        ?>
    </body>
</html>