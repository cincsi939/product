<?
session_start();
//====GEN Counter==============================
	$host = "localhost";
	$username = "sapphire";
	$password = "sprd!@#$%";
	$cms_db = "competency_cms";


	$myconnect = @mysql_connect($host,$username,$password) ; //OR DIE("Unable to connect to database :: $host ");
	$iresult = mysql_query("SET character_set_results=tis-620");
	$iresult = mysql_query("SET NAMES TIS620");


	$ses_id = session_id() ;
	$str_gen_table = " CREATE TABLE  IF NOT EXISTS `log_counter` (  `file_name` varchar(255) NOT NULL default '',  `count_page` int(11) default NULL,  PRIMARY KEY  (`file_name`)) TYPE=MyISAM; ";
	@mysql_db_query($cms_db,$str_gen_table);

	$file_active = basename($PHP_SELF);
	$str_sql = "SELECT *  from log_counter WHERE file_name = '$file_active' ";
	$query1=@mysql_db_query($cms_db,$str_sql);
	$rs_1 = @mysql_fetch_array($query1);	
		if($rs_1){		
			if($file_active2 != $file_active ){
			$count_nm = $rs_1[count_page] + 1 ;
			session_register("file_active2");
			$file_active2 = $file_active;
			$str_sql2 = " update log_counter SET count_page = '$count_nm' WHERE  file_name = '$file_active' ";
			@mysql_db_query($cms_db,$str_sql2);
			
			}		
		}else{
			session_register("file_active2");
			$n = 606328; // สุ่มค่า หากยังไม่เคย view มาก่อน
			$file_active2 = $file_active;
			$str_rp = " Replace Into log_counter(file_name,count_page) VALUES ('$file_active','$n') "	;
			@mysql_db_query($cms_db,$str_rp);
		}

	$str_sql3 = "SELECT *  from log_counter WHERE file_name = '$file_active' ";
	$query3 = @mysql_db_query($cms_db,$str_sql3);
	$rs_3 = @mysql_fetch_array($query3);
	
	function get_real_ip()
{
	$ip = false;
	if(!empty($_SERVER['HTTP_CLIENT_IP']))	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}

	if ($ip){
		return ($_SERVER['REMOTE_ADDR'] . "/$ip");
	}else{
		return ($_SERVER['REMOTE_ADDR'] );
	}
}

$result_c = @mysql_db_query($cms_db,"  SELECT count(session_id)  AS  cnum FROM  log_counterpage  ; ") ;
$rs_c = @mysql_fetch_assoc($result_c);
//====END GEN COUNTER====================================
?>

<table cellpadding="0" cellspacing="0" class="moduletable">
<tr><th valign="top">ผู้เข้าชมในขณะนี้</th></tr>
<tr><td>ขณะนี้มี <?=$rs_c[cnum]?> บุคคลทั่วไป ออนไลน์</td></tr>
</table>

<table cellpadding="0" cellspacing="0" class="moduletable">
<tr><th valign="top">Site Counter</th></tr>
<tr><td align="center">         
          <table  style="border-style: solid; border-width: 0; border-color: #000000">
           <tr>
            <td align="center">
			<?
			$x = $rs_3[count_page];
			for ($i=0;$i<strlen($x);$i++){
				$digit = substr($x,$i,1);
				echo "<img src='digits/$digit.set001_blue.gif' border=0 width='16' height='14'>";
			}
			?>
			
	    </td>
           </tr>
          </table>

</td></tr>
</table>
<?
mysql_close();
?>