<?
class Get_Contents{
  var $Path;
  var $Folder;
  var $Filename;
  var $Temp_File;
  //var $debug="OFF";
  var $run = "OFF";
  var $CurrentFile;
  var $Contents ="";
  function Get_Contents($xPath="",$xFolder="",$xFilename=""){  
  	$this->run = ($_GET['run']=='ON')?'ON':'OFF';
	$this->Contents="";
	$this->Path=($xPath!="")?$xPath:$this->Path; 
	$this->Folder=($xFolder!="")?$xFolder:$this->Folder;  
	$this->Filename=($xFilename!="")?md5($xFilename):md5($this->Filename);  	
	$this->Temp_File=($this->Temp_File=="")?$this->Path.$this->Folder.$this->Filename:$this->Temp_File; 
	
   if($this->run=="OFF"){     
		if (file_exists($this->Temp_File)){        
			$this->Contents = file_get_contents($this->Temp_File); 
	   }  		 
	 }   
  }
 
  
  
  
  function Put_contents(){
  //ob_start(); 
   $output = ob_get_contents();
   //if ($this->debug=="OFF"){
        file_put_contents($this->Temp_File,$output);
		chmod($this->Temp_File, 0755); 
    //}
    ob_end_flush();
  }
  
}
?>