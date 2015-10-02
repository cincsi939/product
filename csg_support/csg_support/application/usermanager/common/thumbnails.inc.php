<? 
function createThumb($sfile,$dfile,$show_w,$show_h) 
{ 
// the passed variables are string filenames, the source and the destination 

global $maxwidth,$maxheight; 

//=================================================================================
$arr_size =  getimagesize($sfile);

$img_width =  $arr_size[0] ;  $img_height =  $arr_size[1] ;  

if ($img_width > $img_height) {
		if ($img_width > $show_w ){ 
			$ratio1 = $img_width / $show_w ;
			$show_h = $img_height /  $ratio1;		
			$show_h = (int)$show_h  ; 
		}else{
			$ratio1 = $img_height / $show_h ;
			$show_w = $img_width /  $ratio1;		
			$show_w = (int)$show_w  ; 
		}
}
$maxwidth		= $show_w;		$maxheight	= $show_h;		// Find thumbnails size 
//=================================================================================
$simg = imagecreatefromjpeg($sfile); 
$currwidth=imagesx($simg); 
$currheight=imagesy($simg); 

//set the dimensions of the thumbnail 
if ($currheight>$currwidth*1.7) 
{ 
   $zoom=$maxheight/$currheight; 
   $newheight=$maxheight; 
   $newwidth=$currwidth*$zoom; 
} 
else 
{ 
   $zoom=$maxwidth/$currwidth; 
   $newwidth=$maxwidth; 
   $newheight=$currheight*$zoom; 
} 

//create the resource img for the thumbnail 
$dimg = imagecreate($newwidth, $newheight); 

//convert truecolor immage resource to palette image resource (so we can count the colors...) 
imagetruecolortopalette($simg, false, 256); 
$palsize = ImageColorsTotal($simg); 
for ($i = 0; $i<$palsize; $i++) 
{ 
   $colors = ImageColorsForIndex($simg, $i); 
   ImageColorAllocate($dimg, $colors['red'], $colors['green'], $colors['blue']); 
} 

imagecopyresized($dimg, $simg, 0, 0, 0, 0, $newwidth, $newheight, $currwidth, $currheight); 
imagejpeg($dimg,$dfile); 

  ImageDestroy($simg); 
  ImageDestroy($dimg); 
} 
?> 
<? 
//   use the function like this: 
/*
$maxwidth=100; 
$maxheight=80; 
createThumb("bigImage.jpg","bigImage_htumb.jpg"); 

*/
?>