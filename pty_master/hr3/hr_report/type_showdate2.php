<?php
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$onload=" onLoad=\"tempOnLoad();\"";

function changDateToSlash($datename){
		$str="";
		if($datename!=""){
				unset($temp);				
				$temp=explode("-",$datename);
				$str=$temp[2]."/".$temp[1]."/".$temp[0];
		}
		return $str;
}

$sql_tempGeneral="
SELECT
general.idcard,
general.prename_th,
general.name_th,
general.surname_th,
general.marital_status_id,
general.marry_prename,
general.marry_name,
general.marry_surname,
general.startdate,
general.father_prename,
general.father_name,
general.father_surname,
general.begindate
FROM `general`
WHERE		general.idcard =  '".$_GET['tempIdcard']."'
";
$rs_tempGeneral=mysql_db_query($dbname,$sql_tempGeneral)or die (mysql_error());
$res_tempGeneral=mysql_fetch_assoc($rs_tempGeneral);
$strName="";
if($res_tempGeneral['idcard']!=""){
		$strName=$res_tempGeneral['prename_th'].$res_tempGeneral['name_th']."     ".$res_tempGeneral['surname_th'];
}

$strFatherName="";
if($res_tempGeneral['idcard']!=""){
		$strFatherName=$res_tempGeneral['father_prename'].$res_tempGeneral['father_name']."  ".$res_tempGeneral['father_surname'];
}

$strMarryName="";
if($res_tempGeneral['marital_status_id']=="1"){
		$strMarryName=$res_tempGeneral['marry_prename'].$res_tempGeneral['marry_name']."  ".$res_tempGeneral['marry_surname'];
}
?>

<script type="text/javascript">
 
  var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
  	  }
	}
		/*function check_benzine_value(value)
	{
	var id_instruct = document.getElementById("id_instruction").value;
	var spt_source = document.getElementById("list").value;
   //var people_id= document.getElementById("benzine_value_id").innerHTML = value;
   	document.form2.list3.value = spt_source ;
	document.form2.list4.value =  value ;
	document.form2.instruct_id.value = id_instruct ;
	}*/
function aaa()
{
document.form.type_showdate2.disabled=false;
}
 function doClear(type_showdate2) 
{
	document.form.type_showdate2.disabled=true;
     if (document.form.type_showdate2.value!="")
 	{
       document.form.type_showdate2.value="";
	   document.form.type_showdate2.disabled=true;
    }
}

function Inint_AJAX() {
   try { return new ActiveXObject("Msxml2.XMLHTTP");  } catch(e) {} //IE
   try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   try { return new XMLHttpRequest();          } catch(e) {} //Native Javascript
   alert("XMLHttpRequest not supported");
   return null;
}

function getBirthShow(e) {
	//alert(e.value);
     var req = Inint_AJAX();
	 var sec =e;
	 tempdate='<?=$_GET['tempBirth']?>';
	 tempID='temp_name_showdate_'+sec;
	tempStr=document.getElementById(tempID).value;
     req.onreadystatechange = function () { 
          if (req.readyState==4) {
               if (req.status==200) {
			   		//alert(req.responseText);
                    //document.getElementById('AmphurCHK').innerHTML=req.responseText; //รับค่ากลับมา
					document.getElementById('temp_date').value=req.responseText;
					document.getElementById('temp_date2').innerHTML=req.responseText;
               } 
          }
     };
     req.open("GET", "type_showdate_ajax.php?id="+sec+"&tempdate="+tempdate+"&tempStr="+tempStr+"&rnd="+(Math.random()*1000)); //สร้าง connection
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620"); // set Header
     req.send(null); //ส่งค่า
}

function tempOnLoad(){		
		rs77_12=document.getElementById('temp77').value;
		rs78_12=document.getElementById('temp78').value;
		if(rs77_12==rs78_12){
				copyText();
		}else{
				getBirthShow(rs77_12);
		}
}

function copyText(){
		document.getElementById('temp_date').value=document.getElementById('type_showdate2').value;
		document.getElementById('temp_date2').innerHTML=document.getElementById('type_showdate2').value;
}
</script>
<?
 	 $sql77="SELECT type_dateshow2  from general where idcard='$_SESSION[idoffice]' ";
	 $q77=mysql_db_query($dbname,$sql77)or die (mysql_error());
	 $rs77=mysql_fetch_assoc($q77);
	 
	 $sql78="SELECT * FROM  type_showdate where id_type='$rs77[type_dateshow2]' and type_nec='n' ";
	 $q78=mysql_db_query($dbname,$sql78)or die (mysql_error());
	 $rs78=mysql_fetch_assoc($q78);
	 
	mysql_db_query($dbname , "select 1 " ) ; 
if ($_SERVER[REQUEST_METHOD] == "POST"){

}
?>
<?
$smonth = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย", "พ.ค", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
function  convert_date1($date001){  // convert  form format   2004-11-25  (YYYY-MM-DD)
				global $smonth ; 
				$syear = substr ("$date001", 0,4); // ปี
				if ($syear < 2300 ){  $syear = $syear + 543 ;  }
				$smm =  number_format(substr ("$date001", 5,2))  ; // เดือน
				$sday = (int)substr ("$date001", 8,2); // วัน
				$convert_date1 = "  $sday   ". $smonth[$smm] ." $syear  ";		
				return $convert_date1 ;
}
$month_name = array("01"=>"มกราคม","02"=> "กุมภาพันธ์","03"=> "มีนาคม", "04"=>"เมษายน","05"=> "พฤษภาคม", "06"=>"มิถุนายน", "07"=>"กรกฏาคม", "08"=>"สิงหาคม","09"=> "กันยายน", "10"=>"ตุลาคม","11"=> "พฤษจิกายน", "12"=>"ธันวาคม");
?>		
<html>
<head>
<title>ข้อมูลข้าราชการ</title>

<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script>
function getData(e){		
		opener.document.getElementById('label_type_showdate2').value = e;
		opener.document.getElementById('label_type_showdate2').focus();
}
</script>
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
-->
</style>
</head>
<body <?=$onload?>>


<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="60" bgcolor="#2C2C9E"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="15%">&nbsp;</td>
              <td width="85%"><B class="pheader">เลือกรูปแบบการแสดงผล วันที่ ใน ก.พ.7 ส่วนที่ 2</B></td>
            </tr>
        </table></td>
      </tr>
      <tr>

        <td></td>
      </tr>
    </table>
<?
# print_r($_SESSION) ; 
$general_id = $_SESSION[id] ; 
if ($addnew  != ""){ 
$tmpdate = explode("/" , $xdate) ;
$dd1 = $tmpdate[0] ; $mm1 = $tmpdate[1] ; $yy1 = $tmpdate[2] ; 
if ($yy1 > 2350){ $yy1 -=  543 ;  } 
$daterec = $yy1 ."-". $mm1  ."-". $dd1  ;  
if($type_showdate=="other")
{
	$type_showdate1=$type_showdate2;
	$type="n";
	
			if($rs78[type_date]==$type_showdate1)
					{
						$update="UPDATE type_showdate set type_date='$type_showdate1' where id_type='$rs78[id_type]' " 	;
						$query_update=mysql_db_query ($dbname,$update) or die (mysql_error());
					}
					else
					{
					$sql_showdate="INSERT INTO type_showdate SET type_date='$type_showdate1', type_nec='$type' ";
					//echo $sql_showdate;
					$query_showdate=mysql_db_query($dbname,$sql_showdate)or die(mysql_error());
					}

	$sql_date="select id_type from  type_showdate where type_date='$type_showdate1' ";

	$q_date=mysql_db_query($dbname,$sql_date)or die (mysql_error());
	$rsd=mysql_fetch_assoc($q_date);
	$type_showdate3=$rsd[id_type];
}
else
{
	$type_showdate3=$type_showdate;

	}
$sql = "UPDATE general SET type_dateshow2='$type_showdate3' where idcard='$_SESSION[idoffice]' ";

$result = mysql_db_query($dbname,$sql) or die (mysql_error()) ;
if($result)
{
	$msg="รูปแบบการแสดงผลวันที่ได้ถูกบันทึกเสร็จสิ้น";
				echo"<script language=\"javascript\">
				alert(\"$msg\\n \");
				</script>";
				//echo"<meta http-equiv='refresh' content='0;URL=type_showdate2.php'>";
				echo"<script language=\"javascript\">getData('$type_showdate2')</script>";
				echo"<script language=\"javascript\">window.close();</script>";
				exit;	
}
else
{
				$msg="ไม่สามารถบันทึกข้อมูลได้";
				echo"<script language=\"javascript\">
				alert(\"$msg\\n \");
				</script>";
				//echo"<meta http-equiv='refresh' content='0;URL=type_showdate2.php'>";
				echo"<script language=\"javascript\">window.close();</script>";
				exit;
	}


} ########## if ($addnew  != ""){  
?>
<?  if ($act == ""){   ?>
<form name="form" method="post" action="?">

  <table width="98%" border="0" align="center">
    <tr>
      <td colspan="5" bgcolor="#A3B2CC">&nbsp;<strong> ระบุรูปแบบการแสดงผล ของวันที่ของวันเกิด ใน ก.พ.7 </strong></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" align="center">
      	<div style="background:url(../../../images_sys/sec2.PNG) no-repeat; width:1000px; height:118px; margin:0; padding:0; float:left;font-size:16px; font-weight:bold;">
          <div style="background:#FF9; width:200px; height:20px; margin:15px 0 0 140px; float:left; text-align:center;"><strong><?=$strName?></strong></div>
          <div style="background:#FF9; width:180px; height:20px; margin:15px 0 0 190px; float:left; text-align:center;"><strong><?=$strMarryName?></strong></div>
          <div style="background:#FF9; width:170px; height:20px; margin:15px 0 0 120px; float:left; text-align:center;"><strong><?=convert_date1($res_tempGeneral['startdate'])?></strong></div>
          <br>
          <div style="background:#FF9; width:280px; height:40px; margin:28px 0 0 152px; float:left; text-align:center;"><strong><div id="temp_date2" style="border-bottom:solid 1px #000;"></div>
          <div style="margin:0; padding:0; font-size:14px;"><?php
			$newtempBirth=explode("/",$_GET["tempBirth"]);
			echo "( ".showthaidate($newtempBirth[0])." ".$month_name["$newtempBirth[1]"]." ".showthaidate($newtempBirth[2])." )";
		  ?></div>
</strong></div>
		<div style="background:#FF9; width:200px; height:20px; margin:28px 0 0 85px; float:left; text-align:center;"><strong><?=$strFatherName?></strong></div>
        <div style="background:#FF9; width:128px; height:20px; margin:28px 0 0 152px; float:left; text-align:center;"><strong><?=convert_date1($res_tempGeneral['begindate'])?></strong></div>
		</div>
		</td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      		<strong>วันเดือนปีเกิด		<?=$_GET['tempBirth']?></strong>
      </td>
    </tr>
    <tr>
      <td colspan="5" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      		๑. ชื่อ <input name="temp_name" id="temp_name" value="<?=$strName?>" size="50" disabled>      
            เกิดวันที่  <input name="temp_date" id="temp_date" value="" size="50" disabled >
      </td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    
     <? $sql6="SELECT * FROM  type_showdate where type_nec='y' order by id_type ASC ";
	  		$query6=mysql_db_query($dbname,$sql6)or die (mysql_error());
			while($rs6=mysql_fetch_assoc($query6))
			{
	  ?>
    <tr>
      <td width="9%">&nbsp;</td>
      <td width="23%"><p>
        <input type="radio" name="type_showdate" value="<?=$rs6[id_type]?>"<? if($rs77[type_dateshow2]==$rs6[id_type]){ echo "checked";}?> onClick="doClear(this); getBirthShow(this.value);"  onFocus="getBirthShow(this.value);">
        <input type="hidden" name="temp_name_showdate_<?=$rs6[id_type]?>" id="temp_name_showdate_<?=$rs6[id_type]?>" size="30" value="<?=$rs6[type_date]?>">
        <?=$rs6[type_date]?>
      </td>
	  <td width="68%"><font color="#FF0000">
	    <?= "**". $rs6[type_detail]?>
	  </font></td>
    </tr> <? }?>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2"><input type="radio" name="type_showdate" value="other" onClick="aaa();" <? if($rs77[type_dateshow2]==$rs78[id_type]){echo "checked";}?> >
      อื่นๆ(ระบุ)
        <input name="type_showdate2" id="type_showdate2" type="text"  <?=($rs77[type_dateshow2]==$rs78[id_type])?"":'disabled="disabled"'?>  value="<?=$rs78[type_date]?>" size="50" onKeyUp="copyText();">
        <input type="hidden" id="temp77" name="temp77" value="<?=$rs77[type_dateshow2]?>"><input type="hidden" id="temp78" name="temp78" value="<?=$rs78[id_type]?>">
        	</td>
      </tr>
	 
    
    <tr>
      <td colspan="5" align="center"><br>
        <input name="addnew" type="submit" id="addnew" value="บันทึก">
        &nbsp;
        <input type="button" name="Submit22" value="ปิดหน้านี้" onClick="window.close(); "></td>
      </tr>
  </table>
</form>
<? } #######   if ($act == ""){   ?> 
<table width="98%" border="0" align="center">
  <tr>
    <td colspan="2"><strong>หมายเหตุ</strong></td>
  </tr>
  <tr>
    <td width="8%">&nbsp;</td>
    <td width="92%">เมื่อบันทึกข้อมูลระบบจะเรียกดึงข้อมูล หน้าบันทึกข้อมูลทั่วไป(หน้าก่อนนี้)ใหม่ หากมีการบันทึกข้อมูลในหน้าข้อมูลทั่วไป กรุณาบันทึกหน้าบันทึกข้อมูลทั่วไป(หน้าก่อนนี้) ก่อนบันทึก รูปแบบการแสดงผลวันเกิด ใน ก.พ.7 </td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>

<?php
function  showthaidate($number){
$digit=array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ');
$num=array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
$number = explode(".",$number);
$c_num[0]=$len=strlen($number[0]);
$c_num[1]=$len2=strlen($number[1]);
$convert='';
if($len > 2){
	$a1 = $len - 1 ;
	$f_digit = substr($number[0],$a1,1);
}
//คิดจำนวนเต็ม
for($n=0;$n< $len;$n++){
	$c_num[0]--;
	$c_digit=substr($number[0],$n,1);
	if($c_num[0]==0&& $c_digit==0)$digit[$c_digit]='';
	if($len>1 && $len <= 2){
		if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='เอ็ด';
	}else if ($len>3){
		if($f_digit == 0){
			if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='หนึ่ง';
		}else{
			if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='เอ็ด';
		}
	}else{
		if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='หนึ่ง';
	}
	if($c_num[0]==0&& $c_digit==2)$digit[$c_digit]='สอง';
	if($c_num[0]==1&& $c_digit==0)$digit[$c_digit]='';
	if($c_num[0]==1&& $c_digit==1)$digit[$c_digit]='';
	if($c_num[0]==1&& $c_digit==2)$digit[$c_digit]='ยี่'; 
	$convert.=$digit[$c_digit];
		if($c_num[0] > 0 && $c_digit != 0 && $c_digit != ""){
			$convert.=$num[$c_num[0]]; 
		}
}
$convert .= "";
if($number[1]==''){$convert .= "";}
//คิดจุดทศนิยม
for($n=0;$n< $len2;$n++){ 
$c_num[1]--;
$c_digit=substr($number[1],$n,1);
if($c_num[1]==0&& $c_digit==1)$digit[$c_digit]='หนึ่ง';
if($c_num[1]==0&& $c_digit==2)$digit[$c_digit]='สอง';
if($c_num[1]==1&& $c_digit==2)$digit[$c_digit]='สอง'; 
if($c_num[1]==1&& $c_digit==1)$digit[$c_digit]='';
$convert.=$digit[$c_digit];
$convert.=$num[$c_num[1]]; 
}
if($number[1]!='')$convert .= "";
return $convert;
}
?>