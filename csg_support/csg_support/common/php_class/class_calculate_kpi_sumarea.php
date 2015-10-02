<?
###################################################################
	## SAIYAIRAK : SURVEY SR1 MAIN INDEX
	###################################################################
	## Version :			200907xx.001 (Created/Modified; Date.RunNumber)
	## Created Date :	2009-07-xx xx:xx
	## Created By :		Mr.SANIT KEAWTAWAN(KHUAN)
	## E-mail :			sanit@sapphire.co.th
	## Tel. :				
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
class calculate_kpi_sumarea{
	public $yy,$mm,$tree_id,$pin;
	public $allvalue = array();
	private $arrpop = array();
function calculate_kpi_sumarea($yy='',$mm='',$tree_id='',$pin=''){
		$this->yy = $yy;
		$this->mm = $mm;
		$this->tree_id = $tree_id;
		$this->pin = $pin;
	}	
	function calculate(){  
		$sql="SELECT eq_kpi_score.tree_id,
eq_kpi_score.yy,
eq_kpi_score.mm,
eq_kpi_score.pin,
eq_kpi_score.tree_node_id
FROM eq_kpi_score";
		    $result1=mysql_query($sql);
			while($row=mysql_fetch_array($result1)){
					//calculate_sumary_amphur
//					calculate_sumary_province
//					calculate_sumary_tambon
//					calculate_summary_area
				$str ="call calculate_sumary_tambon($row[tree_id],$row[yy],$row[mm],$row[pin],$row[tree_node_id])";
				$result=mysql_query($str);
				echo $str."<br>";
				if(!$result){echo mysql_error."<br>";}
				$str ="call calculate_sumary_amphur($row[tree_id],$row[yy],$row[mm],$row[pin],$row[tree_node_id])";
				$result=mysql_query($str);
				echo $str."<br>";
				if(!$result){echo mysql_error."<br>";}
				$str ="call calculate_sumary_province($row[tree_id],$row[yy],$row[mm],$row[pin],$row[tree_node_id])";
				$result=mysql_query($str);
				echo $str."<br>";
				if(!$result){echo mysql_error."<br>";}
				$str ="call calculate_summary_area($row[tree_id],$row[yy],$row[mm],$row[pin],$row[tree_node_id])";
				$result=mysql_query($str);
				echo $str."<br>";
				if(!$result){echo mysql_error."<br>";}
			 }
	}
}
?>