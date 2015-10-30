<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AdminReport";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Pairoj
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::schooll_name, login
#END
#########################################################
//session_start();

			set_time_limit(8000);
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
$date_last = 31;
$date_last1 = 1;
$point_per_ch = 70; // จำนวนคะแนนต่อชุด
$percen_add = 0.05; // เปอร์เซ็นส่วนเพิ่ม
$day_per_week = 6;// จำนวนวันใน 1 สัปดาห์
$avg_age = 26;// อายุราชการเฉลี่ย
$age_begin = 22; // อายุกลางในการรับราชการ
$constan_update_age = 200;// กรณีค่าที่จะ update มากกว่า  200 ใน update
$point_avg_person = 18.42; // จำนวนค่าเฉลี่ยคะแนนต่อ 1 อายุราชการ
$con_point = 16;// คะแนนบวกสูตรการหาคะแนจากอายุราชการ
$con_point_multiply = 2.42; // คะแนนคูณการหาคะแนนจากอายุราชการ 
$site_defult = "51"; // OZONE 1


$host_face = "202.129.35.101";
$user_face = "sapphire";
$pass_face = "sprd!@#$%";
$dbface = "faceaccess";

	ConHost($host_face,$user_face,$pass_face); // connect faceaccess
	$sql = "SELECT t1.officer_id, t1.pin FROM faceacc_officer as t1 Inner Join faceacc_site as t2  ON t1.site_id = t2.site_id where  t2.site_id IN('2','3','4','5','8','21','22','42','43','44','51','53','70') group by  t1.pin";	
	$result=  mysql_db_query($dbface,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$in_id = "";
	while($rs = mysql_fetch_assoc($result)){
			if($in_id > "") $in_id .= ",";
			$in_id .= "'$rs[pin]'";
	}// end 	while($rs = mysql_fetch_assoc($result)){
ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 

$sql1 = "SELECT
Sum(t2.numkpoint) AS num1,
t2.datekeyin
FROM
keystaff as t1
Inner Join stat_user_keyin as t2 ON t1.staffid = t2.staffid
where t2.datekeyin between '2011-06-01' and '2011-06-28' and t1.sapphireoffice='0' and t1.period_time='am'
and t1.card_id IN($in_id);
group by year(t2.datekeyin)";
echo $sql1."<br>";
?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript" src="../../common/jquery_1_3_2.js"></script>
<script language="javascript">

function checkAll(){
	checkall('tbldata',1);
}//end function checkAll(){

function UncheckAll(){
	checkall('tbldata',0);	
}

function checkall(context, status){	
	$("#"+context).find("input[type$='checkbox']").each(function(){
				$(this).attr('checked', status);	
	});
	
}//end function checkall(context, status){	


function CheckForm(){
	
if(document.form1.compare_id1.checked == true){
	var d1 = document.form1.s_data1.value;
	var d2 =  document.form1.s_data2.value;
	var d3 =  document.form1.e_data1.value
	var d4 = document.form1.e_data2.value
	// วันที่ที่ 1
	arr1 = d1.split("/");
	v1 = arr1[2]+""+arr1[1]+""+arr1[0];
	// วันที่ที่ 2
	arr2 =  d2.split("/");
	v2 = arr2[2]+""+arr2[1]+""+arr2[0];
	
	arr3 =  d3.split("/");
	v3 = arr3[2]+""+arr3[1]+""+arr3[0];
	
	arr4 =  d4.split("/");
	v4 = arr4[2]+""+arr4[1]+""+arr4[0];
		if(v2 < v1){
				alert("วันที่สิ้นสุดส่วนหน้าต้องไม่น้อยกว่าวันที่เริ่มต้น");
				document.form1.s_data2.focus();
				return false;
		}
		if(v4 < v3){
				alert("วันที่สิ้นสุดส่วนหลังต้องไม่น้อยกว่าวันที่เริ่มต้น");
				document.form1.s_data2.focus();
				return false;
		}
		
	return true;	
	}else if(document.form1.compare_id2.checked == true){
	var m1 = document.form1.mm1.value;
	var y1 =  document.form1.yy1.value;
	var m2 =  document.form1.mm2.value
	var y2 = document.form1.yy2.value	
		val1 = y1+""+m1;
		val2 = y2+""+m2;
		if(val2 < val1){
				alert("เดือนปีสิ้นสุดต้องไม่น้อยกว่าเดือนปีเริ่มต้น");
				document.form1.yy2.focus();
				return false
		}
			
		return true;
	}//end if(document.form1.compare_id1.checked == true){
		
}//end function CheckForm(){
	

function CheckR1(){
		document.form1.compare_id1.checked = true;
}

function CheckR2(){
		document.form1.compare_id2.checked = true;
}

</script>

</HEAD>
<BODY >
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "เวลาในการประมวลผล :: $timeprocess";
?>
