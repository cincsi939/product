<?php
	header ('Content-type: text/html; charset=utf-8'); 
	include('../lib/class.function.php');
	$con = new Cfunction();
	if ( $_GET['pre'] ) {
		$sql_preName = "SELECT gender FROM tbl_prename where id =".$_GET['pre'];
		$con->connectDB();
		$results_preName = $con->select($sql_preName);
		foreach($results_preName as $rt){}
		if($rt['gender']==2)
		{
			echo '<input name="v12" type="radio"  class="v12" id="female"  value="1" checked  />1. หญิง&nbsp;<input type="radio"  value="2" class="v12" name="v12"  id="male" />2. ชาย
		 <INPUT name="chkSex" type="hidden" id="chkSex" value="1" size="30" />';
		}
		elseif($rt['gender']==1)
		{
			echo '<input name="v12" type="radio"  class="v12" id="female"  value="1" />1. หญิง&nbsp;<input type="radio"  value="2" class="v12" name="v12"  id="male" checked />2. ชาย
		 <INPUT name="chkSex" type="hidden" id="chkSex" value="1" size="30" />';
		}
		else
		{
			echo '<input name="v12" type="radio"  class="v12" id="female"  value="1" />1. หญิง&nbsp;<input type="radio"  value="2" class="v12" name="v12"  id="male" />2. ชาย
		 <INPUT name="chkSex" type="hidden" id="chkSex" value="1" size="30" />';
		}
	}
?>