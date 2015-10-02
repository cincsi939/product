<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Tanachai Khampukhew (tanachai@sapphire.co.th)
 * @created  10/09/2014
 * @access  public
 */
 ?>
<?php
class Cfunction
{
	public function  __construct()
	{
		
	}
	
	public function configIPSoap()
	{
		$ws_client = new nusoap_client('http://soapservices.sapphire.co.th/index.php?wsdl',true); 
		//$ws_client = new nusoap_client('http://192.168.2.12/webservices/index.php?wsdl',true); 
		return $ws_client;
	}
	
	//ฟังก์ชั่น connect
	public function connectDB()
	{
		$con	=	mysql_connect("localhost","root",'SPRD525@sapphire');
		//$con	=	mysql_connect("61.19.255.77","family_admin",'F@m!ly[0vE');
		if(!$con) {	echo "Not connect"; }
		mysql_select_db("csg_data",$con);
		//mysql_query("SET NAMES utf-8");
		//mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci';");
		mysql_query("SET NAMES tis-620");
		mysql_query("SET NAMES 'tis620' COLLATE 'tis620_thai_ci';");
		return $con;
	}

	// ฟังก์ select
	public function select($sql) {
		$result=array();
		$req = mysql_query($sql) or die("SQL Error: ".$sql."".mysql_error());	
		while($data= mysql_fetch_assoc($req)) 
		{
			$result[]=$data;
		}
		return $result;
	}
	
	//ฟังก์ชั่น insert
	public function insert($table,$data) {
		$fields=""; 
		$values="";
		$i=1;	
		foreach($data as $key=>$val)		
		{
			  if($i!=1) { $fields.=", "; $values.=", "; }		
			  $fields.=$key;
			  $values.="'".$val."'";
			  $i++;
		}
		
		$sql = "INSERT INTO $table ($fields) VALUES ($values)";
		if(mysql_query($sql)) { return true; }
		else { die("SQL Error: ".$sql."".mysql_error()); return false;}
	}
	
	//ฟังก์ชั่น update
	public function update($table,$data,$where) {
		$modifs="";
		$i=1;
		foreach($data as $key=>$val)
		{
			if($i!=1) { $modifs.=", "; }
			if(is_numeric($val)) { $modifs.=$key.'='.$val; }
			//else { $modifs.=$key.' = '.$val.'; }
			else { $modifs.=$key." = '".$val."'"; }
			$i++;
		}
		$sql = ("UPDATE $table SET $modifs WHERE $where");
		if(mysql_query($sql)) { return true; }
		else { die("SQL Error: ".$sql."".mysql_error()); return false; }
	}
	
	//ฟังก์ชั่น delete

	public function delete($table, $where) {
		$sql = "DELETE FROM $table WHERE $where";
		if(mysql_query($sql)) { return true; }
		else { die("SQL Error: ".$sql."".mysql_error()); return false; }
	}
	
	
	function _calendarTH($day,$month,$year,$values='')
	{
		$yy=date('Y');
		$mm =date('n');$dd=date('d');
		$_month_name = array("1"=>"มกราคม",  "2"=>"กุมภาพันธ์",  "3"=>"มีนาคม",   "4"=>"เมษายน",  "5"=>"พฤษภาคม",  "6"=>"มิถุนายน",   "7"=>"กรกฎาคม",  "8"=>"สิงหาคม",  "9"=>"กันยายน",   "10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");
		
		if($values!='')
		{
			$data = explode('-',$values);
			$ui = '<select name="'.$day.'" id="'.$day.'">';
			for($i=1;$i<=31;$i++){
				if($i==$data[0])
				{
					$ui .= '<option selected value="'.$i.'">'.$i.'</option>';
				}
				else
				{
					$ui .= '<option value="'.$i.'">'.$i.'</option>';
				}
			}
				
			$ui .= '</select>';
			$ui .='<select name="'.$month.'" id="'.$month.'">';
			for($j=1;$j<=12;$j++){
					if($j==$data[1])
					{		
						$ui .= '<option selected value="'.$j.'">'.$_month_name[$j].'</option>';
					}
					else
					{
						$ui .= '<option value="'.$j.'">'.$_month_name[$j].'</option>';
					}
				}
			$ui .= '</select>';
			
			$ui .='<select name="'.$year.'" id="'.$year.'">';
			$yy+= 543;
				for($i=2558;$i<=$yy;$i++){
					if($i==$data[2])
					{		
						$ui .= '<option selected value="'.$i.'">'.$i.'</option>';
					}
					else
					{
						$ui .= '<option value="'.$i.'">'.$i.'</option>';
					}	
				}
			$ui .= '</select>';
		}
		else
		{
			$ui = '<select name="'.$day.'" id="'.$day.'">';
			for($i=1;$i<=31;$i++){
				if($dd==$i)
				{
					$ui .= '<option selected value="'.$i.'">'.$i.'</option>';
				}
				else
				{
					$ui .= '<option value="'.$i.'">'.$i.'</option>';
				}
			}
				
			$ui .= '</select>';
			$ui .='<select name="'.$month.'" id="'.$month.'">';
			for($j=1;$j<=12;$j++){
					if($j==$mm)
					{		
						$ui .= '<option selected value="'.$j.'">'.$_month_name[$j].'</option>';
					}
					else
					{
						$ui .= '<option value="'.$j.'">'.$_month_name[$j].'</option>';
					}
				}
			$ui .= '</select>';
			
			$ui .='<select name="'.$year.'" id="'.$year.'">';
			$yy+= 543;
				for($i=2558;$i<=$yy;$i++){
					if($i==$yy)
					{		
						$ui .= '<option selected value="'.$i.'">'.$i.'</option>';
					}
					else
					{
						$ui .= '<option value="'.$i.'">'.$i.'</option>';
					}	
				}
			$ui .= '</select>';
		}
		
		return $ui;
	}
	
	function chkImg($type,$url)
	{
		if($type==1)
		{
			$ui = '<img src="'.$url.'img/Icon/child.png" width="40" height="40" title="เด็กเล็ก (อายุ 0-18 ปี)">';
		}
		elseif($type==2)
		{
			$ui = '<img src="'.$url.'img/Icon/teens.png" width="40" height="40" title="กลุ่มเยาวชน (อายุ 19-25 ปี)">';
		}
		elseif($type==3)
		{
			$ui = '<img src="'.$url.'img/Icon/man.png" width="40" height="40" title="กลุ่มวัยแรงงาน (อายุ 25-60 ปี)">';
		}
		elseif($type==4)
		{
			$ui = '<img src="'.$url.'img/Icon/elderly.png" width="40" height="40" title="กลุ่มผู้สูงอายุ">';
		}
		else
		{
			$ui = '<img src="'.$url.'img/Icon/disabled.png" width="40" height="40" title="กลุ่มผู้พิการ">';
		}
		return $ui;
	}
	
	function sortData($chkData,$column,$order)
	{
		if($chkData==$column)
		{
			if($order=='asc')
			{
				$ui = 'desc';
			}
			else
			{
				$ui = 'asc';
			}
		}
		else
		{
			$ui = 'asc';
		}
		return $ui;
	}
	function careerSelect($careertext)
	{
		$data = array();
		$x=json_decode($careertext);
				for($n=0;$n<count($x);$n++){
						if($x[$n]==1){
							$data[]='รับจ้างทั่วไป';
							}
							if($x[$n]==2){
							$data[]='เกษตรกร';
							}
							if($x[$n]==3){
							$data[]='ประมง';
							}
							if($x[$n]==4){
							$data[]='ข้าราชการ/ลูกจ้างหรือพนักงานของรัฐ';
							}
							if($x[$n]==5){
							$data[]='พนักงานรัฐวิสาหกิจ';
							}		
							if($x[$n]==6){
							$data[]='เจ้าหน้าที่องค์กรปกครองท้องถิ่น';
							}
							if($x[$n]==7){
							$data[]='ค้าขาย/ธุรกิจส่วนตัว';
							}
							if($x[$n]==8){
							$data[]='พนักงาน/ลูกจ้างเอกชน';
							}
							if($x[$n]==9){
							$data[]='ว่างงาน/ไม่มีงานทำ';
							}	
							if($x[$n]==10){
							$data[]='อื่นๆ';
							}						
					}
					$career_detail = implode(",",$data);
					return $career_detail;
	}
	
	function date_eng2thai2($date, $add = 0, $dismonth = "L", $disyear = "L") {
		$monthname = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        global $monthname, $shortmonth;
        if ($date != "") {
                $date = substr($date, 0, 10);
                list($year, $month, $day) = split('[/.-]', $date);
                if ($dismonth == "S") {
                        $month = $shortmonth[$month * 1];
                } else {
                        $month = $monthname[$month * 1];
                }
                $xyear = 0;
                if ($disyear == "S") {
                        $xyear = substr(($year + $add), 2, 2);
                } else {
                        $xyear = ( $year + $add);
                }
                return ($day * 1) . " " . $month . " " . ($xyear);
        } else {
                return "";
        }
	}
	
	function reportDay($reday)
	{
		list($day, $mon, $year) = explode("/", $reday);

		$month_name_1 = array("1"=>"มกราคม",  "2"=>"กุมภาพันธ์",  "3"=>"มีนาคม",   "4"=>"เมษายน",  "5"=>"พฤษภาคม",  "6"=>"มิถุนายน",   "7"=>"กรกฎาคม",  "8"=>"สิงหาคม",  "9"=>"กันยายน",   "10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

		return $reportD = array($day,$month_name_1[$mon],$year);
	}
	
	function percentage($arrVal, $intDec = 2, $intPercent = 100) {
        if ($arrVal && is_array($arrVal)) {
                #shwArray($arrVal);

                $SumOfVal = array_sum($arrVal); #echo "Total of Value is : ".$SumOfVal."<br>";

                foreach ($arrVal as $Key => $Val) {
                        $arrVal[$Key] = number_format((($Val * $intPercent) / $SumOfVal), $intDec + 1); // จำนวนร้อยละ ทศนิยม +1
                        // ชุดตัวแปร Array ร้อยละ จำนวนหลักทศนิยม
                        if (substr($arrVal[$Key], -1, 1) < 5) { # A2
                                $arrA2Ori[$Key] = $arrVal[$Key];
                                $arrA2[$Key] = number_format($arrVal[$Key], $intDec);
                                $Ref = explode(".", $arrA2[$Key]);
                                $arrA2LastChar[$Key] = substr($arrA2Ori[$Key], -1, 1);
                        } else { # A1
                                $arrA1Ori[$Key] = $arrVal[$Key];
                                $arrA1[$Key] = number_format($arrVal[$Key], $intDec);
                                $Ref = explode(".", $arrA1[$Key]);
                                $arrA1LastChar[$Key] = substr($arrA1Ori[$Key], -1, 1);
                        }

                        $arrVInt[$Key] = $Ref[0]; // ชุดตัวแปรจำนวนเต็ม (ตัดทศนิยมทิ้ง)
                        $arrVDec[$Key] = $Ref[1]; // ชุดตัวแปรจำนวนทศนิยม
                }

                #shwArray($arrVal);

                $x0 = array_sum($arrVInt);   #echo "x0 = ".$x0."<br>";
                $x1 = $intPercent - $x0;    #echo "x1 = ".$x1."<br>";
                $x2 = ($x1 * pow(10, $intDec)); #echo "x2 = ".$x2."<br>";
                $x3 = array_sum($arrVDec);   #echo "x3 = ".$x3."<br>";
                $x4 = $x3 - $x2;       #echo "x4 = ".$x4."<br>";
                #shwArray($arrA1Ori);
                #shwArray($arrA2Ori);

                arsort($arrA1LastChar);
                arsort($arrA2LastChar);
                #shwArray($arrA1LastChar);
                #shwArray($arrA2LastChar);
                #shwArray($arrA1);
                #shwArray($arrA2);

                if ($x4 == 0) {
                        foreach ($arrA1 as $Key => $Val)
                                $arrResult[$Key] = $arrA1[$Key];
                        foreach ($arrA2 as $Key => $Val)
                                $arrResult[$Key] = $arrA2[$Key];
                } elseif ($x4 > 0) {
                        $intA = 1;
                        foreach ($arrA1LastChar as $Key => $Val) {
                                if ($intA <= (count($arrA1Ori) - $x4))
                                        $arrResult[$Key] = $arrA1[$Key];
                                else
                                        $arrResult[$Key] = substr($arrA1Ori[$Key], 0, strlen($arrA1Ori[$Key]) - 1);
                                $intA++;
                        }

                        foreach ($arrA2 as $Key => $Val)
                                $arrResult[$Key] = $arrA2[$Key];
                } elseif ($x4 < 0) {
                        $intA = 1;
                        foreach ($arrA2LastChar as $Key => $Val) {
                                if ($intA <= abs($x4))
                                        $arrResult[$Key] = $arrA2[$Key] + 1 / (pow(10, $intDec));
                                else
                                        $arrResult[$Key] = $arrA2[$Key];
                                $intA++;
                        }

                        foreach ($arrA1 as $Key => $Val)
                                $arrResult[$Key] = $arrA1[$Key];
                }

                #shwArray($arrResult);
                #echo "Total of Percent is : ".number_format(array_sum($arrResult), 2)."<br>";

                return $arrResult;
        }
}

}
?>