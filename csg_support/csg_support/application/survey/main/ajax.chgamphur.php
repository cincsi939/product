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
	if ( $_GET['PvID'] ) {
		$sql_Aumpur = 'Select ccDigi,ccName,secid,group_id,areaid,ccType FROM ccaa WHERE ccType = \'Aumpur\' AND areaid like \''.substr($_GET['PvID'],0,2).'%\'';
		$con->connectDB();
		$results_Aumpur = $con->select($sql_Aumpur);
		if(  $_GET['no'] == '2' ){
			echo "<select name=\"v809\" id=\"v809\" onchange=\"chgTambon2(this.value, ".$_GET['DfVal'].");\" style=\"width:100px;\">";	
		}else{
			echo "<select name=\"v9\" id=\"v9\" onchange=\"chgTambon(this.value, ".$_GET['DfVal'].");\" style=\"width:100px;\">";
		}
		echo '<option value="">�ô�к�</option>';
		foreach($results_Aumpur as $rd)
		{
			echo '<option value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
		}
		echo "</select>";
	}
?>