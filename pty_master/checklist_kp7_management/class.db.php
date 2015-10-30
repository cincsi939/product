<?
## mysql
## by suwat

class mysql_db{
		var $__result = "";
		var $__rs = "";
		var $__host = HOST;
		var $__username = USERNAME_HOST;
		var $__password = PASSWORD_HOST;
		var $db_master = DB_MASTER;
		var $db_entry = DB_USERENTRY;
		var $db_temp = DB_CHECKLIST;

		

	  function GetError($sql){
			return   die(mysql_error()."$sql<br>LINE__".__LINE__);
	}
	 function Query($db,$sql){
			$this->__result =  mysql_db_query($db,$sql) or $this->GetError($sql);
	}
	 function GetResult($db,$sql){
			return  mysql_fetch_assoc(mysql_db_query($db,$sql) or $this->GetError($sql));
	}
	
	 function FetchRow($result=""){
			if($result == ""){
				return  mysql_fetch_assoc($this->__result);	
			}else{
				return 	mysql_fetch_assoc($result);
			}
	}

	 function SetResult(){
		$this->__result = "";
	}

	 function SetRs(){
		$this->__rs = "";
	}
	
		
}//end class mysql_db{ 







	



?>