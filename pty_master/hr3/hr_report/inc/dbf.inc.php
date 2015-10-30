<?
$prog = array("obec", "p-obec", "m-obec", "student", "smis");
$field	 = array("C"	=> "CHAR", 	"Y" 	=> "DOUBLE", 		"N" 	=> "INT",			"F" 	=> "FLOAT",
					"D" 	=> "DATE",	"T" 	=> "DATETIME",	"B" 	=> "DOUBLE",	"I" 	=> "INT",
					"L" 	=> "INT",		"M"	=> "TEXT",			"G"	=> "VARCHAR",	"C"	=> "VARCHAR",
					"M"	=> "TEXT",	"P"	=> "BLOB",			"Q"	=> "BLOB",		"V"	=> "VARCHAR");	


function get_dbf_header($dbfname) {

  $fdbf 			= fopen($dbfname,'r');
  $dbfhdrarr 	= array();
  $buff32 		= array();
  $i 				= 1;
  $goon 			= true;
  while ($goon) {
     if (!feof($fdbf)) {
        $buff32	= fread($fdbf,32);
        if ($i > 1) {
           if (substr($buff32,0,1) == chr(13)) {
              $goon 			= false;
           } else {
              $pos 			= strpos(substr($buff32,0,10),chr(0));
              $pos 			= ($pos == 0?10:$pos);
              $fieldname 	= substr($buff32,0,$pos);
              $fieldtype 	= substr($buff32,11,1);
              $fieldlen 		= ord(substr($buff32,16,1));
              $fielddec 		= ord(substr($buff32,17,1));
			  array_push($dbfhdrarr, array($fieldname,$fieldtype,$fieldlen,$fielddec));
           }
        }
        $i++;
     } else {
        $goon = false;
     }
  }
  fclose($fdbf);
  return($dbfhdrarr);
}

function get_file_name($temp){

	$f 				= explode(".", $temp);
	$f_name 	= $f[0];	
	$f_ext 		= $f[1];	
	return $f_name;
	
}

function table_exists($table_name){

 	$table = mysql_query(" show tables like '" . $table_name . "'; ");
    if(mysql_fetch_row($table) === false){
		return(false);
	} else {
		return(true);
	}    
         
}	
									
function fieldCheck($temp){

	$temp	= strtoupper($temp);
	$field 	= array("DATE","DATETIME","TEXT","BLOB");

	for($i=0;$i<count($field);$i++){
		if($field[$i] == $temp){
			$chk	= "y";
			break;
		}
	}
	$data	= ($chk == "y") ? true : false ; 
	return $data;

}		
?>