<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Tanachai Khampukhew (tanachai@sapphire.co.th)
 * @created  22/09/2014
 * @access  public
 */
?>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<?php
	include('../lib/class.function.php');
	include('../lib/function.php');
	$con = new Cfunction();
	if ( $_GET['TbID'] ) {
		$sql_Aumpur = 'Select ccDigi,ccName,secid,group_id,areaid,ccType FROM ccaa WHERE ccType = \'Tamboon\' AND areaid like \''.substr($_GET['TbID'],0,4).'%\'';
		$con->connectDB();
		$results_Aumpur = $con->select($sql_Aumpur);
		if(  $_GET['no'] == '2' ){
			echo "<select name=\"v808\" id=\"v808\" style=\"width:100px;\">";
		}else{
			echo "<select name=\"v8\" id=\"v8\" style=\"width:100px;\">";
		}
		echo '<option value="">โปรดระบุ</option>';
		foreach($results_Aumpur as $rd)
		{
			echo '<option value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
		}
		echo "</select>";
	}
?>