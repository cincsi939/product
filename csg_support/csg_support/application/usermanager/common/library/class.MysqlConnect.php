<?
class MysqlConnect{
	var $host,$username,$password,$dbname;
	function connect($h="",$u="",$p=""){
		if($h==""){
			$h=$this->host;
		}else{
			$this->host = $h;
		}
		if($u==""){
			$u=$this->username;
		}else{
			$this->username = $u;
		}
		if($p==""){
			$p=$this->password;
		}else{
			$this->password = $p;
		}
		mysql_connect($h, $u,$p) OR DIE("Unable to connect to Mysql");
		mysql_query("SET character_set_results=tis-620");
		mysql_query("SET NAMES TIS620");
	}
	function select_db($d=""){
		if($d==""){
			$d=$this->dbname;
		}else{
			$this->dbname = $d;
		}
		@mysql_select_db($d) or die( "Unable to select database");
	}
	function list_table(){
		$result = mysql_list_tables($this->dbname);
		$tblist = array();
		while ($row = mysql_fetch_row($result)) {
			$tblist[] = $row[0];
		}
		return $tblist;
	}
	function list_field($tbname){
		$result = mysql_query("select * from $tbname limit 1");
		$fieldlist = array();
		for($a=0;$a<mysql_field_len($result,0);$a++ ){
			$fieldlist[] = mysql_field_name ($result, $a);
		}
		return $fieldlist;
	}
	function help(){
		echo "<pre>";
		echo "class MysqlConnect<br>";
		echo "	property<br>";
		echo "		host<br>";
		echo "		username<br>";
		echo "		password<br>";
		echo "		dbname<br>";
		echo "	method<br>";
		echo "		connect([host[,username[,password]]])<br>";
		echo "			connect(\"root\",\"username\",\"password\") หรือ connect() แต่ต้อง เซตค่า class->host = xxxx; <br>";
		echo "		select_db([dbname])<br>";
		echo "			select_db(\"data base\") หรือ select_db() แต่ต้อง เซตค่า class->dbname= xxxx; <br>";
		echo "		list_table()<br>";
		echo "			จะแสดงรายชื่อตารางทั้งหมดที่อยู่ใน dbname<br>";
		echo "		list_field(tbname)<br>";
		echo "			list_field(\"table name\") แสดงชื่อ field ทั้งหมดที่อยู่ในตาราง<br>";
	}
}
?>