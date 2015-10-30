<? 
   $a=array("0","8","2","3","5","7","a","b","c"); 

   for ($i=0; $i < count($a); $i++) { // print only digit 
      if ( ereg("[0-9]",$a[$i]) ) { 
         print ("$a[$i] <BR>\n"); 
      } 
   } 
?> 
<HR> 
<? 
   for ($i=0; $i < count($a); $i++) { // print only a, b or c 
      if ( ereg("[a-c]",$a[$i]) ) { 
         print ("$a[$i] <BR>\n"); 
      } 
   } 
?>
<hr />
<?

$a=array("f","mn", "eU","+5","Y","17","a4","%m","cdef"); 
   for($i=0; $i < count($a); $i++) { 
      if ( eregi("[a-z]",$a[$i]) ) { 
         print ("$a[$i] <BR>\n"); 
      } 
   } 

?>
<hr />
<? 
   function getBrowserName() { 
      global $HTTP_USER_AGENT; 
      $browser=strtoupper($HTTP_USER_AGENT); 
	 // echo $browser."<br>MSIE";
      if (strstr($browser,"MSIE")) 
         return "MS Internet Explorer"; 
      else if (strstr($browser,"MOZILLA")) 
         return "Netscape"; 
      else 
         return ""; 
   } 
   $name = getBrowserName(); 
   if ($name != "") { 
      echo "Your browser is ".$name.".<BR>"; 
   } 
?>
