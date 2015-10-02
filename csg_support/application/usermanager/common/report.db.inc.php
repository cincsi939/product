<?
/*****************************************************************************
Function		: ตั้งค่าการเชื่อมต่อ Database และ รวม function ต่างๆ ที่ใช้ในทุกไฟล์
Version			: 1.0
Last Modified	: 27/7/2548
Changes		:
	27/7/2548 - รองรับการเชื่อมต่อ Database อื่นๆได้ (เพิ่มส่วนของ $_SESSION)
	6/8/2548	- รูปที่ Stretch เปลี่ยนเป็นขนาด 189 * 120

*****************************************************************************/
session_start();
include("../../inc/conndb_nonsession.inc.php");
// Default Database Setting
$hostname = "localhost";
$db_username = "$username";
$db_password = "$password";
$db_name= "$dbname";

$notconnect = true;


/*
// sapphire
$db_name= "simplybright";
$db_username = "simplybright";
$db_password = "subsimplybright";
*/

/*if ($_SESSION[newdb] == "yes"){
	$hostname = $_SESSION[xhostname];
	$db_name= $_SESSION[xdbname];
	$db_username = $_SESSION[xuser];
	$db_password = $_SESSION[xpwd];
}*/

// Banner Size
$wx = 189;
$hx = 120;

// Banner Base Directory
$basedir = "../../images_sys/";
$imgpath = "../../images_sys/";  //ที่เก็บรูป รcon ต่างๆ ที่ใช้ในรายงาน 
$report_inc_path = "../../common/";   //ที่เก็บ report.inc.php
$css_path = "../../common/";   //ที่เก็บreport.css


if (!$notconnect){
	@mysql_connect($hostname,$db_username,$db_password) or die("Cannot connect to Database Server.");
	@mysql_select_db($db_name) or die("Cannot connect to Database.");
}

function GetCellProperty($id,$sec1,$cellno){
		$result = mysql_query("select * from cellinfo where rid=$id and sec='$sec1' and cellno='$cellno';");
		if ($result){
			$rs=mysql_fetch_array($result,MYSQL_ASSOC);
			$prop = "";
			if ($rs[alignment]){
				$prop .= " align='$rs[alignment]' ";
			}

			if ($rs[valign]){
				$prop .= " valign='$rs[valign]' ";
			}

			if ($rs[bgcolor]){
				$prop .= " bgcolor='$rs[bgcolor]' ";
			}

			if ($rs[width]){
				$prop .= " width='$rs[width]' ";
			}

			return $prop;

		}else{
			return "";
		}
}

function GetCellValue($id,$sec1,$cellno){
		$result = mysql_query("select * from cellinfo where rid=$id and sec='$sec1' and cellno='$cellno';");
		if ($result){
			$rs=mysql_fetch_array($result,MYSQL_ASSOC);
			$val1 = $rs[caption];

			if ($rs[celltype] == 1){
				$val1 .= " [db] ";
			}else if ($rs[celltype] == 2){
				$val1 .= " [fld] ";
			}else if ($rs[celltype] == 3){
				$val1 .= " [fn] ";
			}

			if ($rs[font]){
				$val1 = "<span style='$rs[font]'>$val1</span>";
			}

			if ($rs[url]){
				$val1 = "<a href='$rs[url]' target='_blank'>$val1</a>";
			}
			
			return $val1;

		}else{
			return "&nbsp;";
		}
}

function DB2Array($arrayname,$sql){
	$s = "\$$arrayname  = array(";
	$result = mysql_query($sql);
	$i = 0;
	$firstrow = true;
	while ($rs = mysql_fetch_assoc($result)){
		if ($firstrow){
			$firstrow = false;
		}else{
			$s .= ",";
		}

		$firstcol = true;
		$s .= "$i => array(";
		foreach($rs as $key => $value){
			if ($firstcol){
				$firstcol = false;
			}else{
				$s .= ", ";
			}
			$s .= "\"$key\"=>\"" . ($value) . "\"";
		}
		$s .= ")";

		$i++;
	}

	$s .= ");";

	return $s;
}

function canSetWidth(){ // ตรวจสอบว่า ฐานข้อมูลรองรับการแก้ไข Column Width หรือไม่
	$result = @mysql_query("select cwidth1,cwidth2,cwidth3,cwidth4 from reportinfo limit 1");
	if ($result && mysql_errno() == 0){
		return true; // can set width
	}else{
		return false; //cannot set width
	}
}

function GetColumnWidth($rid,$sec,$cellno){
	$x = explode(".",$cellno);
	$col = $x[1];

	// H,E,I,F
	if ($sec == "H"){
		$sql = "select cwidth1 from reportinfo where rid='$rid';";
	}else if ($sec == "E"){
		$sql = "select cwidth2 from reportinfo where rid='$rid';";
	}else if ($sec == "I"){
		$sql = "select cwidth3 from reportinfo where rid='$rid';";
	}else {
		$sql = "select cwidth4 from reportinfo where rid='$rid';";
	}

	$cwidth = "";

	$result = @mysql_query($sql);
	if ($result){
		$rs = mysql_fetch_array($result);
		$x=explode("|",$rs[0]); //แต่ละ column คั่นด้วย |
		$cwidth = $x[$col - 1]; // เอาเฉพาะตัวที่กำหนดจากค่าตัวหลังของ cellno
	}

	return htmlspecialchars($cwidth);
}

function SetColumnWidth($rid,$sec,$cellno,$cwidth){
	$x = explode(".",$cellno);
	$col = $x[1];

	$cwidth = str_replace("|","",$cwidth);  //กำจัดเครื่องหมาย | (ถ้ามี)

	// H,E,I,F
	if ($sec == "H"){
		$sql = "select cwidth1 from reportinfo where rid='$rid';";
	}else if ($sec == "E"){
		$sql = "select cwidth2 from reportinfo where rid='$rid';";
	}else if ($sec == "I"){
		$sql = "select cwidth3 from reportinfo where rid='$rid';";
	}else {
		$sql = "select cwidth4 from reportinfo where rid='$rid';";
	}

	$result = @mysql_query($sql);
	if ($result){
		$rs = mysql_fetch_array($result);
		$x=explode("|",$rs[0]); //แต่ละ column คั่นด้วย |

		//สำหรับอันที่ไม่เคยได้ทำถึงอันนี้
		for ($i=0;$i<$col-1;$i++){
			if (!isset($x[$i])){
				$x[$i] = "";
			}
		}

		$x[$col - 1] = $cwidth;  
		$columnwidth = implode("|",$x); //จับมารวมกัน
	}else{ // ยังไม่มีการกำหนดค่า
		$columnwidth = "";
		for ($i=0;$i<$col-1;$i++){
			$columnwidth .= "|";
		}
		$columnwidth .= "$cwidth|";
	}


	// H,E,I,F
	if ($sec == "H"){
		$sql = "update reportinfo set cwidth1='$columnwidth' where rid='$rid';";
	}else if ($sec == "E"){
		$sql = "update reportinfo set cwidth2='$columnwidth' where rid='$rid';";
	}else if ($sec == "I"){
		$sql = "update reportinfo set cwidth3='$columnwidth' where rid='$rid';";
	}else {
		$sql = "update reportinfo set cwidth4='$columnwidth' where rid='$rid';";
	}

	@mysql_query($sql);

}

?>