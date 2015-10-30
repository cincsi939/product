<?php
session_start();
include ("../../../config/phpconfig.php");
if($_GET[dir] != ''){
deletedir(base64_decode($_GET[dir]).'_temp/');
}
function deletedir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") 
           deletedir($dir."/".$object); 
        else unlink   ($dir."/".$object);
      }
    }
    reset($objects);
    rmdir($dir);
  }
 }
 echo '1';
 ?>