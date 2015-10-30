<?php
session_start();
require_once ("../../../config/phpconfig.php");
require_once("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include ("../libary/function.php");
include ("timefunc.inc.php");
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
?>		
<html>
<head>
<title>ข้อมูลข้าราชการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<script language="javascript" src="../../../common/js/jquery-1.8.2.js"></script>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript" src="../../../common/script_event.js"></script>
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style1 {color: #FF0000}
-->
</style>
<script language="javascript">
/*var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}


function setdbkp7() {
				var item1 = getCheckedValue(set_kp7);
				var url = "ajax_setkp7_historyname.php?runid=" + item1;
				createXMLHttpRequest();
				xmlHttp.open("GET", url, true);
				xmlHttp.send(null);
}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}*/

function check(){
	if(document.form2.xdate.value.length == 0){
		alert("กรุณาระบุวันที่เปลี่ยนชื่อ");
		document.form2.xdate.focus();
		return false;
	}else if(document.form2.prename_th.value.length == 0){
	alert("กรุณาระบุคำนำหน้าชื่อ");
		document.form2.prename_th.focus();
		return false;
	}else if(document.form2.name_th.value.length == 0){
	alert("กรุณาระบุชื่อ");
		document.form2.name_th.focus();
		return false;
	}else if(document.form2.surname_th.value.length == 0){
	alert("กรุณาระบุนามสกุล");
		document.form2.surname_th.focus();
		return false;
	}else {
		return true;
	}
}	

function regExp_th(){
	var thai = new RegExp("^[ก-๙]+$");
	var eng = new RegExp("^[a-zA-Z]+$");
	var eng_ex = new RegExp("[#@$!%^&*]");
	if(!($('#name_th').val()=='')){
		var name = $('#name_th').val();
		if(!(name.match(thai))||($('#name_th').val().match(eng_ex))){
			alert("กรุณากรอกเฉพาะภาษาไทยเท่านั้น!!");
		   $('#name_th').focus();
		   return false;
		}
	}
	if(!($('#surname_th').val()=='')){
		var lname = $('#surname_th').val();
		if(!(lname.match(thai))||($('#surname_th').val().match(eng_ex))){
			alert("กรุณากรอกเฉพาะภาษาไทยเท่านั้น!!");
		   $('#surname_th').focus();
		   return false;
		}
    }
	
	if(!($('#name_en').val()=='')){
		if(!($('#name_en').val().match(eng))||($('#name_en').val().match(eng_ex))){
			alert("กรุณากรอกเฉพาะภาษาอังกฤษเท่านั้น!!");
		   $('#name_en').focus();
		   return false;
		}
	}
	if(!($('#surname_en').val()=='')){
		if(!($('#surname_en').val().match(eng))||($('#surname_en').val().match(eng_ex))){
			alert("กรุณากรอกเฉพาะภาษาอังกฤษเท่านั้น!!");
		   $('#surname_en').focus();
		   return false;
		}
    }
}
function key_thai()
{
	var code;
	if (!e) var e = window.event;
	if (e.keyCode)
    {
	 code = e.keyCode;
	 if ((code >= 3585)&&(code < 3664) || (code == 32) || (code == 95))
	 { return true;}
	 else
	 { return false;}
    }
}
function key_eng()
{
    var code;
    if (!e) var e = window.event;
    if (e.keyCode)
    {
        code = e.keyCode;
        if ((code >= 65&&code<=90)||(code >= 97&&code<=122)||(code==127))
        { return true;}
        else
        {  return false;}
    }
}
</script>
</head>
<body >
<?
$tbname = "hr_addhistoryname" ; 
# print_r($_SESSION) ; 
$general_id = $_SESSION[id] ; 
//echo "<pre>";print_r($_POST);die;
$prename_th=($prename_th!=0)?$prename_th:"";
if($prename_th){
	$strSQL="select * from $dbnamemaster.prename_th where PN_CODE='$prename_th' ";
	$result=@mysql_query($strSQL);
	$pre_result=@mysql_fetch_assoc($result);
	$prename_th_label=trim($prename_th_label);
	if($prename_th_label==""){
			$prename_th=$pre_result['prename_th'];
	}else{
			$prename_th=$prename_th_label;
	}
	$prename_id=$pre_result['PN_CODE'];	
	$prename_en=$pre_result['prename_en'];	
	//echo "<pre>"; print_r($pre_result); die;
}else{
	$prename_th="";
	$prename_id="";
	$prename_en="";
}
/*echo $prename_th."<br>";
echo $prename_id."<br>";
echo $prename_en."<br>";*/
?>
<?
	if($action == "changeRow"){
		for($i=0;$i<count($runno);$i++){
		$sql		= " update hr_addhistoryname set runno='".$runno[$i]."' where gen_id='".$general_id."' and runid='".$runid[$i]."' ";		
		$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());		
		}
	$xsql_h=mysql_query("SELECT * FROM $tbname WHERE gen_id='$general_id' ORDER BY runno DESC");
	$xrs_h=mysql_fetch_assoc($xsql_h);
		$sql_update="UPDATE general SET prename_th='".$xrs_h[prename_th]."', name_th='".$xrs_h[name_th]."', surname_th='".$xrs_h[surname_th]."', prename_en='".$xrs_h[prename_en]."', name_en='".$xrs_h[name_en]."', surname_en='".$xrs_h[surname_en]."' WHERE id='$general_id'";
		$sql_query=mysql_query($sql_update);
///------------------------------------------------------------------------------------------------------------
echo "  <script language=\"JavaScript\"> opener.document.location.reload();  </script> ";	
}

if ($act=="del"){
	// ตรวจสอบการลบข้อมูล
	$strSQL_DEL="SELECT * FROM $tbname WHERE gen_id='$general_id'";
	$Rs_Del=mysql_query($strSQL_DEL);
		$RS_DEL=mysql_num_rows($Rs_Del);
			if($RS_DEL == 1){
				echo "<script language=\"JavaScript\"> alert(\"ไม่สามารถลบข้อมูลได้เนื่องจะสร้างความเสียหายให้กับข้อมูล\");</script>";
				
			}else{
										
			$sql = " DELETE FROM $tbname WHERE  runid = $runid "; 
			$result = mysql_query($sql) ; 
			
			$str_delx="select max(kp7_active) as kp7_active from $tbname where gen_id='$general_id'";
			$result_delx=mysql_query($str_delx);
			$kp7_a="1";
			$rs_delx=mysql_fetch_array($result_delx);
				if($rs_delx[kp7_active] == 0 or $rs_delx[kp7_active] == NULL){
				$str_select_d="select * from $tbname where gen_id='$general_id' order by runno desc limit 0,1";
				$result_select_d=mysql_query($str_select_d);
				$rs_x1=mysql_fetch_array($result_select_d);
				$str_upDel="update $tbname set kp7_active='$kp7_a' where gen_id='".$rs_x1[gen_id]."' and runid='".$rs_x1[runid]."'";
				@mysql_query($str_upDel);
				}
			}
				
			

			
##############################################################
$sql1 = "  SELECT * FROM `$tbname` WHERE `gen_id` = '$general_id' ORDER BY runno DESC";    
$result1 = mysql_query($sql1) ; 
$rs1 = mysql_fetch_assoc($result1) ; 
 $sql2 = " UPDATE `general`   SET  
 `prename_th`='$rs1[prename_th]',`prename_id`='$rs1[prename_id]',`prename_en`='$rs1[prename_en]',
 `name_th`='$rs1[name_th]',  `name_en`='$rs1[name_en]',
 `surname_th`='$rs1[surname_th]',   `surname_en`='$rs1[surname_en]', 
`secondname_th`='$rs1[secondname_th]',`secondname_en`='$rs1[secondname_en]' 
WHERE (`id`='$general_id')   
" ; 
$result2 = mysql_query($sql2) ; 

echo "  <script language=\"JavaScript\"> opener.document.location.reload();  </script> ";	
$act="";
} ############  if ($act=="del"){ 
?>
<?



if ($edit !="" and $runid != "" ){
		$tmpdate = explode("/" , $xdate) ;
		$dd1 = $tmpdate[0] ; $mm1 = $tmpdate[1] ; $yy1 = $tmpdate[2] ; 
		if ($yy1 > 2350){ $yy1 -=  543 ;  } 
		
		$daterec = $yy1 ."-". $mm1  ."-". $dd1  ;  
		// update การเปิดเปิด kp7
		// echo "<pre>. $tbname .";print_r($_POST);die;
		//จบการปิดเปิด kp7
		
		if($kp7 == 1){
				$str_x1="select * from $tbname where gen_id='$gen_id' and runid <>'$runid'";
				$result_x1=mysql_query($str_x1);
				while($rs_x1=mysql_fetch_assoc($result_x1)){
						$upkp7="0";
						$str_upx="update $tbname set kp7_active='$upkp7' where runid='".$rs_x1[runid]."' and gen_id='".$rs_x1[gen_id]."'";
						//echo $str_upx."<br>";
						@mysql_query($str_upx);
				}
				
				$sql = " UPDATE `$tbname` 
				SET `prename_th`='$prename_th', `prename_id`='$prename_id',`name_th`='$name_th',`surname_th`='$surname_th',`secondname_th`='$secondname_th',`prename_en`='$prename_en',`name_en`='$name_en',`surname_en`='$surname_en',`secondname_en`='$secondname_en',`kp7_active`='$kp7',
				`daterec`='$daterec',`updatetime`= NOW()
				WHERE (`runid`='$runid')   
				" ; 
				$result = @mysql_query($sql) ; 
		}else{
				$sql = " UPDATE `$tbname` 
				SET `prename_th`='$prename_th', `prename_id`='$prename_id',`name_th`='$name_th',`surname_th`='$surname_th',`secondname_th`='$secondname_th',`prename_en`='$prename_en',`name_en`='$name_en',`surname_en`='$surname_en',`secondname_en`='$secondname_en',`kp7_active`='$kp7',
				`daterec`='$daterec',`updatetime`= NOW()
				WHERE (`runid`='$runid')   
				" ; 
				$result = @mysql_query($sql) ;
		}
		
		$sql1 = "  SELECT * FROM `$tbname` WHERE `gen_id` = '$general_id' ORDER BY runno DESC";    
		$result1 = @mysql_query($sql1) ; 
		$rs1 = mysql_fetch_assoc($result1) ; 
		$sql2 = " UPDATE `general`   SET  
		`prename_th`='$prename_th', `prename_id`='$rs1[prename_id]',`prename_en`='$rs1[prename_en]',
		`name_th`='$rs1[name_th]',  `name_en`='$rs1[name_en]',
		`surname_th`='$rs1[surname_th]',   `surname_en`='$rs1[surname_en]', 
		`secondname_th`='$rs1[secondname_th]',`secondname_en`='$rs1[secondname_en]' 
		WHERE (`id`='$general_id')   
		" ; 
		$result2 = mysql_query($sql2) ;
		//if(substr($_SERVER["REMOTE_ADDR"],0,8) == "192.168.")//{//echo "$sql2<br>";die;}
		
		
		
		
		//echo $sql2.'<br>'.$sql; 
		//echo mysql_error() ; 
		//die;
		echo "  <script language=\"JavaScript\"> opener.document.location.reload();  </script> ";	
} ############  if ($act=="edit"){ 
?>
<?
if ($addnew  != ""){ 
$tmpdate = explode("/" , $xdate) ;
$dd1 = $tmpdate[0] ; $mm1 = $tmpdate[1] ; $yy1 = $tmpdate[2] ; 
if ($yy1 > 2350){ $yy1 -=  543 ;  } 
$daterec = $yy1 ."-". $mm1  ."-". $dd1  ;  
$select_no="select max(runno) as runno from $tbname where gen_id='$general_id'";
$query_no=mysql_query($select_no);
$rs_no=mysql_fetch_array($query_no);
	$r_no=$rs_no['runno'];
	$runno_new=$r_no+1;
	
if($kp7 == 1){
$str_x2="select * from $tbname where gen_id='$general_id'";
$result_x2=mysql_query($str_x2);
while($rs_x2=mysql_fetch_assoc($result_x2)){
$upkp="0";
$str_upx2="update $tbname set kp7_active='$upkp' where runid='".$rs_x2[runid]."' and gen_id='".$rs_x2[gen_id]."'";
//echo $str_upx."<br>";
@mysql_query($str_upx2);
	}
	$sql = " 
INSERT INTO `$tbname` ( `gen_id`,`prename_th`,`prename_id`,`name_th`,`surname_th`,
`secondname_th`,`prename_en`,`name_en`,`kp7_active`,`surname_en`,`secondname_en`,`daterec`,`updatetime`,`runno`) 
VALUES ('$general_id','$prename_th','$prename_id','$name_th','$surname_th','$secondname_th',
'$prename_en','$name_en','$kp7','$surname_en','$secondname_en','$daterec',NOW(),'$runno_new')
";  
$result = mysql_query($sql) ; 
	
}else{
$sql = " 
INSERT INTO `$tbname` ( `gen_id`,`prename_th`,`prename_id`,`name_th`,`surname_th`,
`secondname_th`,`prename_en`,`name_en`,`kp7_active`,`surname_en`,`secondname_en`,`daterec`,`updatetime`,`runno`) 
VALUES (   '$general_id','$prename_th','$prename_id','$name_th','$surname_th','$secondname_th',
'$prename_en','$name_en','$kp7','$surname_en','$secondname_en','$daterec',NOW(),'$runno_new')
";  
$result = mysql_query($sql) ; 

}

//echo $sql."<hr>";

$sql1 = "  SELECT * FROM `$tbname` WHERE `gen_id` = '$general_id' ORDER BY runno DESC";    
$result1 = mysql_query($sql1) ; 
$rs1 = mysql_fetch_assoc($result1) ; 
$sql2 = " UPDATE `general`   SET  
 `prename_th`='$prename_th',`prename_en`='$rs1[prename_en]',
 `name_th`='$rs1[name_th]',  `name_en`='$rs1[name_en]',
 `surname_th`='$rs1[surname_th]',   `surname_en`='$rs1[surname_en]', 
`secondname_th`='$rs1[secondname_th]',`secondname_en`='$rs1[secondname_en]' 
,`prename_id`='$rs1[prename_id]'
WHERE (`id`='$general_id')   
" ; 
$result2 = mysql_query($sql2) ; 
//echo $sql."<hr>";
//echo $sql1."<hr>";
//echo $sql2."<hr>";
//die;
echo "  <script language=\"JavaScript\"> opener.document.location.reload();  </script> ";	
} ########## if ($addnew  != ""){  
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="60" bgcolor="#2C2C9E"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="15%"><div align="center"><img src="bimg/hr.gif" width="64" height="64" /></div></td>
              <td width="85%"><b class="pheader">
                <?=($rs[runid]!=0?"แก้ไข":"เพิ่ม")?>ประวัติการเปลี่ยนแปลงคำนำหน้าชื่อ นามสกุล และ ชื่อรอง </b></td>
            </tr>
        </table></td>
      </tr>
      <tr>

        <td>&nbsp;		
		</td>
      </tr>
    </table>
<?
if ($act==""){ 
?>
	<form name="form1" method="post" action="<?=$PHP_SELF?>">			
  <input type="hidden" name="action" value="changeRow">
   <input type="hidden" name="kp7" value="<?=$rs[runid];?>">
      <table width="98%" border="0" align="center" cellpadding="2" cellspacing="1">
        <tr class="gcaption"   align="center"  bgcolor="#A3B2CC"    >
          <td width="8%"  ><label>ลำดับ</label></td>
          <td width="14%"  >วันที่เปลี่ยนชื่อ</td>
          <td width="13%">คำนำหน้าชื่อ</td>
          <td width="14%">ชื่อ</td>
          <td width="14%">นามสกุล</td>
          <td width="11%">ชื่อรอง</td>
          <td width="15%">สถานะการแสดงผลใน ก.พ.7</td>
          <td width="11%">เครื่องมือ</td>
        </tr>
<?
$c_date=date("Y-m-d");
	$strSQL_hr="SELECT * FROM hr_addhistoryname WHERE gen_id='$general_id'";
	$xResult=mysql_query($strSQL_hr);
	$xnum_row=mysql_num_rows($xResult);
		if($xnum_row <1){
				$strSQL1="SELECT * FROM general WHERE id='$general_id'";
					$Result1=mysql_query($strSQL1);
						$Rs1=mysql_fetch_assoc($Result1);
						if($Rs1[name_th] != ""){
							$strINSERT="INSERT INTO hr_addhistoryname(gen_id, prename_th, prename_id, name_th, surname_th, prename_en, name_en, surname_en, kp7_active,daterec)VALUES('".$Rs1[id]."', '".$Rs1[prename_th]."', '".$Rs1[prename_id]."', '".$Rs1[name_th]."', '".$Rs1[surname_th]."', '".$Rs1[prename_en]."', '".$Rs1[name_en]."', '".$Rs1[surname_en]."', '1','$c_date')";
							$Result_gen=mysql_query($strINSERT);
						
						}
		
		}
					
	$i=0;
	$sql = " SELECT * FROM hr_addhistoryname WHERE gen_id='$general_id' ORDER BY runno ASC" ; 
	$result = mysql_query($sql) ; 
	$row=mysql_num_rows($result);
	while($rs = mysql_fetch_assoc($result)){
	$i++;
if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
/*
 runid  
 gen_id  prename_th  name_th  surname_th  secondname_th  
 
 prename_en  name_en  surname_en  secondname_en  
 
 daterec  updatetime  
*/
$tmpdate = $rs[daterec] ; 
$daterec = convert_date1($rs[daterec])  ; 
 ?>

        <tr  bgcolor="#<?=$bgcolor1?>">
          <td rowspan="2" align="center" >
		   <select name="runno[]">
  			<?
			for($e=1;$e<=$row;$e++){
				$selected = ($e == $i) ? " selected " : "" ;
				echo "<option value=\"".$e."\" ".$selected.">".$e."</option>";
					}
			?>	
      </select>
		  </td>
		  <input type="hidden" name="runid[]" value="<?=$rs[runid]?>">
          <td rowspan="2" align="center" > <?=$daterec?></td>
          <td>&nbsp; <?=$rs[prename_th]?></td>
          <td>&nbsp; <?=$rs[name_th]?></td>
          <td>&nbsp; <?=$rs[surname_th]?></td>
          <td>&nbsp; <?=$rs[secondname_th]?>		  </td>
          <td rowspan="2" align="center"><? if($rs[kp7_active]=="1"){  $dis_delete="disabled"; $kp7_st_show++; echo "<img src=\"../../../images_sys/approve20.png\" alt='แสดงข้อมูลใน กพ7'>";}else{ echo "<img src=\"../../../images_sys/b_drop.png\" alt='ไม่แสดงข้อมูลใน กพ7'>";  $dis_delete="";}?>
         </td>
          <td rowspan="2" align="center"> 

		  
            <input class="xbutton" style="width: 70;" type="button" value="Edit" onClick="location.href='?runid=<?=$rs[runid]?>&act=edit';" name="button2">
        
          <input class="xbutton"  style="width: 50;" type="button" value="Delete" onClick="if (confirm('คุณกำลังลบข้อมูล ในวันที่ <?=$daterec?>!!')) location.href='?act=del&runid=<?=$rs[runid]?>';" name="button3"  <?=$dis_delete?>>

		  </td>
        </tr >
        <tr bgcolor="#<?=$bgcolor1?>">
          <td>&nbsp; <?=$rs[prename_en]?></td>
          <td>&nbsp; <?=$rs[name_en]?></td>
          <td>&nbsp; <?=$rs[surname_en]?></td>
          <td>&nbsp; <?=$rs[secondname_en]?></td>
        </tr>
<?
} ########## END while($rs = mysql_fetch_assoc($result)){ 
?>		
    </table>
	 <table width="98%" border="0" align="center" cellpadding="2" cellspacing="1">
	 <tr><td align="center"><input type="submit" name="Submit" value="บันทึกการเรียงลำดับการแสดงผลใน ก.พ.7"></td></tr>
	</table>
	</form>
<?
}else{  ##########  if ($act==""){ 
?>
<form name="form1" method="post" action="?">
<?
$sql = " SELECT *  FROM $tbname WHERE  runid = $runid "; 
$result = mysql_query($sql) ; 
$rs = mysql_fetch_assoc($result) ; 
?>
  <table width="98%" border="0" align="center">
    <tr>
      <td colspan="5" bgcolor="#A3B2CC">&nbsp; <strong>แก้ไข</strong></td>
    </tr>
    <tr>
      <td width="7%" align="right">วันที่เปลี่ยนชื่อ</td>
      <td colspan="4">
<?
#    $xdate = "2513-01-03";    == >ปฐิทิน ==> 10/12/2550   
$daterec = "$rs[daterec]";

$tmpdate = explode("-" , $daterec) ;
$dd1 = $tmpdate[2] ; $mm1 = $tmpdate[1] ; $yy1 = $tmpdate[0]+543 ;  
$xdate = $dd1  ."/". $mm1  ."/". $yy1 ;  
?>	  

		   
           <input name="xdate" onFocus="blur();" value="<?=$xdate?>" readOnly   > 
           <input  style="FONT-SIZE: 11px; WIDTH: 80px" onClick="popUpCalendar(this, form.xdate, 'dd/mm/yyyy')" type="button"value="วัน เดือน ปี">
           <input name="runid" type="hidden" id="runid" value="<?=$runid?>"></td>
      </tr>
    <tr class="gcaption">
      <td align="right">&nbsp;</td>
      <td width="19%" align="center">คำนำหน้าชื่อ</td>
      <td width="20%" align="center">ชื่อ</td>
      <td width="21%" align="center">นามสกุล</td>
      <td width="33%" align="center">ชื่อรอง</td>
      </tr>
    <tr>
      <td align="right"><span class="style1">*</span><span class="textp">(ไทย) </span></td>
      <td>
	  	<script language="javascript">
			function matchingID(str){
				if(str.name == "prename_en"){ var targ='prename_th'; }else{ var targ='prename_en'; }
				var x = str.value;
				var y = document.getElementById(targ);
				$(y).val(x); 
				if(y.value!=x){
				 $(y).val("0"); 
				}
			}		
		</script>	  
	  	<select name="prename_th" style="width:140px;" onChange="matchingID(this);" >
        <option value="0">ไม่ระบุ</option>
        <?
		$strSQL="select prename_th as prename , PN_CODE,short_prename_th as sprename from $dbnamemaster.prename_th WHERE prename_th !='' AND PN_CODE !='' AND active = 'on' 
group by PN_CODE order by orderby , prename_th  ";		
		$select1  = mysql_query($strSQL);
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)){
			if($rselect1[sprename] != ""){
				$xprename = "$rselect1[prename]($rselect1[sprename])";	
			}else{
				$xprename = "$rselect1[prename]";	
			}
			if( ($rs[prename_th] == $rselect1[prename]) || ($rs[prename_id] == $rselect1[PN_CODE] && ($rs[prename_id]) && ($rselect1[PN_CODE])) )
			{ 			
				$PN_CODE_CONVETOR="$rselect1[PN_CODE]";
				echo "<option value='$rselect1[PN_CODE]' SELECTED>$xprename</option>/n";
			}else{
				echo "<option value='$rselect1[PN_CODE]' >$xprename</option>";
			}
		}//end while
?>
      </select></td>
      <td><input name="name_th" id="name_th" type="text" class="input_text" value="<?=$rs[name_th]?>" size="20" onKeyPress="return key_thai();" onBlur="return regExp_th();" ></td>
      <td><input name="surname_th" id="surname_th" type="text" class="input_text" value="<?=$rs[surname_th]?>" size="20" ></td><!--onKeyPress="return key_thai();" onBlur="return regExp_th();"-->
      <td><input name="secondname_th" type="text" class="input_text" value="<?=$rs[secondname_th]?>" size="20" onKeyPress="return noSpChar2(event)" ></td>
      </tr>
      <tr>
      <td align="right"></td>
      <td colspan="4">
      		<input name="prename_th_label" type="text" class="input_text" value="<?=$rs[prename_th]?>" size="23" > 
            <span class="style1">หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span>
      </td>
      </tr>
    <tr>
      <td align="right"><span class="textp">(อังกฤษ) </span></td>
      <td>
	  <select name="prename_en" style="width:140px;" onChange="matchingID(this,'en');" >
        <option value="0">ไม่ระบุ</option>
        <?
		$strSQL="select prename_en as prename , PN_CODE from $dbnamemaster.prename_th WHERE prename_en !='' AND PN_CODE !='' AND active = 'on' group by PN_CODE order by orderby , prename_th ";		
		$select1  = mysql_query($strSQL);		
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)){
			$pre_id=($PN_CODE_CONVETOR)?$PN_CODE_CONVETOR:$rs[prename_id];
			if ( ($rs[prename_en] == $rselect1[prename]) || (($pre_id == $rselect1[PN_CODE]) && (pre_id) && ($rselect1[PN_CODE]) ) )	{
				echo "<option value='$rselect1[PN_CODE]' SELECTED>$rselect1[prename]</option>";
			}else{
				echo "<option value='$rselect1[PN_CODE]' >$rselect1[prename]</option>";
			}
		}//end while
		?>
      </select></td>
      <td><input name="name_en" id="name_en" type="text" class="input_text" value="<?=$rs[name_en]?>" size="20" onKeyPress="return key_eng();" onBlur="return regExp_th();"></td>
      <td><input name="surname_en" id="surname_en" type="text" class="input_text" value="<?=$rs[surname_en]?>" size="20" onKeyPress="return key_eng();" onBlur="return regExp_th();"></td>
      <td><input name="secondname_en" type="text" class="input_text" value="<?=$rs[secondname_en]?>" size="20" onKeyPress="return key_eng();" onBlur="return regExp_th();"></td>
      </tr>
       <?php /*?><tr>
      <td align="right">&nbsp;</td>
      <td colspan="4">
      <input name="prename_en_label" type="text" class="input_text" value="<?=$rs[prename_en]?>" size="25" >
      <span class="style1">หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span>
      </td>
      </tr><?php */?>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">
	  <?
	  $strSQL_kp7 = "SELECT * FROM hr_addhistoryname WHERE gen_id='$general_id'";
	  $Result_kp7 = mysql_query($strSQL_kp7);
	  $num_r_kp7 = mysql_num_rows($Result_kp7);
	  $Rs_kp7 = mysql_fetch_assoc($Result_kp7);
	  if(($num_r_kp7 <= 1) and ($Rs_kp7[kp7_active] != '0')){
	  echo "หมวดการแก้ไข การแสดงผลข้อมูลใน ก.พ.7 ถูกปิดไว้ ทั้งนี้เพื่อความปลอดภัยของข้อมูล";
	  echo "<input name=\"kp7\" type=\"hidden\" value=\"1\">";
	  }else{
	  
  	$sql = " SELECT * FROM $tbname WHERE gen_id='$general_id' AND kp7_active=1 ORDER BY runno ASC" ; 
	$result = mysql_query($sql) ; 
	$row=mysql_num_rows($result);
	if($rs[kp7_active]=="1" && $row==1 ){ $kp7_st_active="disabled"; }else{ $kp7_st_active=""; } 
	  ?> 
			    <input name="kp7" type="radio" value="1" <? if($rs[kp7_active]=="1"){ echo "checked";}?>>
		แสดงผลใน ก.พ.7 &nbsp;
				<input name="kp7" type="radio" value="0" <? if($rs[kp7_active]=="0"){ echo "checked";} echo $kp7_st_active;?>>
		ไม่แสดงผลใน ก.พ.7
		<?
		}
		?>
</td>
      </tr>

    <tr>
      <td colspan="5" align="center"><br>
	  <input type="hidden" name="gen_id" value="<?=$rs[gen_id]?>">
        <input name="edit" type="submit" id="edit" value="บันทึก">
        &nbsp;
        <input type="submit" name="Submit2" value="ย้อนกลับ"></td>
      </tr>
  </table>
</form>

<?
}  ########## END   if ($act==""){ 
?>	
<?  if ($act == ""){   ?> 
<form name="form2" method="post" action="?" onSubmit=" return check();">

  <table width="98%" border="0" align="center">
    <tr>
      <td colspan="5" bgcolor="#A3B2CC">&nbsp;<strong>เพิ่มใหม่</strong></td>
    </tr>
    <tr>
      <td width="7%" align="right">วันที่เปลี่ยนชื่อ</td>
      <td colspan="4">
<?
$xdate = "12/12/2521";
?>	  

		   
           <input name="xdate" onFocus="blur();" value="" readOnly   > 
           <input  style="FONT-SIZE: 11px; WIDTH: 80px" onClick="popUpCalendar(this, form.xdate, 'dd/mm/yyyy')" type="button"value="วัน เดือน ปี">
           <input name="runid" type="hidden" id="runid" value="<?=$runid?>"></td>
      </tr>
    <tr class="gcaption">
      <td align="right">&nbsp;</td>
      <td width="19%" align="center">คำนำหน้าชื่อ</td>
      <td width="20%" align="center">ชื่อ</td>
      <td width="21%" align="center">นามสกุล</td>
      <td width="33%" align="center">ชื่อรอง</td>
      </tr>
    <tr>
      <td align="right"><span class="textp">(ไทย) </span></td>
      <td>
	  	 <script language="javascript">
			function matchingID(str){
				if(str.name == "prename_en"){ var targ='prename_th'; }else{ var targ='prename_en'; }
				var x = str.value;
				var y = document.getElementById(targ);
				$(y).val(x); 
				if(y.value!=x){
				 $(y).val("0"); 
				}
			}		
		</script>
	  <select name="prename_th"  style="width:140px;"  onchange="matchingID(this);" >
        <option value="0">ไม่ระบุ</option>
        <?
		$strSQL="select prename_th as prename , PN_CODE,short_prename_th as sprename  from $dbnamemaster.prename_th WHERE prename_th !='' AND PN_CODE !='' AND active = 'on' 
group by PN_CODE order by orderby , prename_th  ";		
		$select1  = mysql_query($strSQL);
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)){
			if($rselect1[sprename] != ""){
				$xprename = "$rselect1[prename]($rselect1[sprename])";	
			}else{
				$xprename = "$rselect1[prename]";	
			}

			if( ($rs[prename_th] == $rselect1[prename]) || ($rs[prename_id] == $rselect1[PN_CODE] && ($rs[prename_id]) && ($rselect1[PN_CODE])) )
			{ 			
				$PN_CODE_CONVETOR="$rselect1[PN_CODE]";
				echo "<option value='$rselect1[PN_CODE]' SELECTED>$xprename</option>/n";
			}else{
				echo "<option value='$rselect1[PN_CODE]' >$xprename</option>";
			}
		}//end while
?>
      </select>
	  </td>
      <td><input name="name_th" id="name_th" type="text" class="input_text" value="<?=$rs[name_th]?>" size="20" onKeyPress="return key_thai();" onBlur="return regExp_th();" ></td>
      <td><input name="surname_th" id="surname_th" type="text" class="input_text" value="<?=$rs[surname_th]?>" size="20"></td><!-- onKeyPress="return key_thai();" onBlur="return regExp_th();"-->
      <td><input name="secondname_th" type="text" class="input_text" value="<?=$rs[secondname_th]?>" size="20" onKeyPress="return noSpChar2(event)" ></td>
      </tr>
      <tr>
      <td align="right"></td>
      <td colspan="4">
      		<input name="prename_th_label" type="text" class="input_text" value="<?=$rs[prename_th]?>" size="23" > 
            <span class="style1">หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span>
      </td>
      </tr>
    <tr>
      <td align="right"><span class="textp">(อังกฤษ) </span></td>
      <td><select name="prename_en" style="width:140px;"  onchange="matchingID(this);">
        <option value="0">ไม่ระบุ</option>
		<?
		$strSQL="select prename_en as prename , PN_CODE from $dbnamemaster.prename_th WHERE  prename_en !='' AND PN_CODE !='' AND active = 'on' group by PN_CODE order by orderby , prename_th ";		
		$select1  = mysql_query($strSQL);		
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)){
			$pre_id=($PN_CODE_CONVETOR)?$PN_CODE_CONVETOR:$rs[prename_id];
			if ( ($rs[prename_en] == $rselect1[prename]) || (($pre_id == $rselect1[PN_CODE]) && (pre_id) && ($rselect1[PN_CODE]) ) )	{
				echo "<option value='$rselect1[PN_CODE]' SELECTED>$rselect1[prename]</option>";
			}else{
				echo "<option value='$rselect1[PN_CODE]' >$rselect1[prename]</option>";
			}
		}//end while
		?>
      </select></td>
      <td><input name="name_en" id="name_en" type="text" class="input_text" value="<?=$rs[name_en]?>" size="20" onKeyPress="return key_eng();" onBlur="return regExp_th();" ></td>
      <td><input name="surname_en" type="text" id="surname_en" class="input_text" value="<?=$rs[surname_en]?>" size="20" onKeyPress="return key_eng();" onBlur="return regExp_th();" ></td>
      <td><input name="secondname_en" type="text" class="input_text" value="<?=$rs[secondname_en]?>" size="20"></td>
      </tr>
      <?php /*?><tr>
      <td align="right">&nbsp;</td>
      <td colspan="4">
      <input name="prename_en_label" type="text" class="input_text" value="<?=$rs[prename_en]?>" size="25" >
      <span class="style1">หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span>
      </td>
      </tr><?php */?>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">
	  <?
		$sql = " SELECT * FROM $tbname WHERE gen_id='$general_id' AND kp7_active=1 ORDER BY runno ASC" ; 
		$result = mysql_query($sql) ; 
		$row=mysql_num_rows($result);
		if($row==0 ){ $kp7_st_active="disabled"; }else{ $kp7_st_active=""; } 	  
	  ?>  	  
	  <input name="kp7" type="radio" value="1" checked="checked">
แสดงผลใน ก.พ.7 &nbsp;
<input name="kp7" type="radio" value="0" <?= $kp7_st_active?>>
ไม่แสดงผลใน ก.พ.7</td>
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
    <td width="92%">เมื่อบันทึกข้อมูลระบบจะเรียกดึงข้อมูล หน้าบันทึกข้อมูลทั่วไป(หน้าก่อนนี้)ใหม่ หากมีการบันทึกข้อมูลในหน้าข้อมูลทั่วไป กรุณาบันทึกหน้าบันทึกข้อมูลทั่วไป(หน้าก่อนนี้) ก่อนบันทึก ประวัติการเปลี่ยนแปลงคำนำหน้าชื่อ นามสกุล และ ชื่อรอง  </td>
  </tr>
  <tr>
    <td colspan="2" align="center"></td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
