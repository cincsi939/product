<?php
/**
 * @comment footernote count viewer
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    24/06/2014
 * @access     public
 */
//====GEN Counter==============================
$file_active = $id;
if(isset($_SESSION['file_active2'])){
	$file_active2 = $_SESSION['file_active2'];
}else{
	$file_active2 = "";
}
$str_sql = "SELECT rid,count_page FROM $db_name.log_counter_rid WHERE rid = '$file_active' ";
$query1 = mysql_query($str_sql);
$rs_1 = mysql_fetch_array($query1);
if($rs_1){		
	if($file_active2 != $file_active ){
		$count_nm = $rs_1['count_page'] +1 ;
		$_SESSION['file_active2'] = $file_active;
		//session_register("file_active2");
		//$file_active2 = $file_active;
		$str_sql2 = " UPDATE $db_name.log_counter_rid SET count_page = '$count_nm' WHERE  rid = '$file_active' ";
		mysql_query($str_sql2);
	}		
}else{
	$_SESSION['file_active2'] = $file_active;
	//session_register("file_active2");
	//$file_active2 = $file_active;
	$n = 1;
	$str_rp = " REPLACE INTO $db_name.log_counter_rid(rid,count_page) VALUES ('$file_active','$n') "	;
	mysql_query($str_rp);
}
$str_sql3 = "SELECT rid,count_page FROM $db_name.log_counter_rid WHERE rid = '$file_active' ";
$query3 = mysql_query($str_sql3);
$rs_3 = mysql_fetch_array($query3);	
//====END GEN COUNTER====================================
?>
<table border=0 width="100%" align=center cellpadding=0 style="background-color:#FFF;border-collapse:collapse; border:<?=$bsize4?>px solid <?=$bcolor4?>;border-top:0px">
    <tr>
    	<td>
        	<span class="spanF" style=" <?php echo $irs['font']; ?> ">จำนวนการแสดงผลหน้านี้ <?php echo $rs_3['count_page'] ?> ครั้ง</span>
        </td>
    </tr>
</table>
