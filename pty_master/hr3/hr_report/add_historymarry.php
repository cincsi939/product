<?php
session_start();
/*            
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include ("checklogin.php");
include ("phpconfig.php");
include("alert.php");
*/        

require_once ("../../../config/phpconfig.php");
require_once("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
/*Conn2DB();*/
include ("../libary/function.php");
include ("timefunc.inc.php");

if ($_SERVER[REQUEST_METHOD] == "POST"){

}
?>
<?
$smonth = array("","�.�.", "�.�.", "��.�.", "��.�", "�.�", "��.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.");
function  convert_date1($date001){  // convert  form format   2004-11-25  (YYYY-MM-DD)
				global $smonth ; 
				$syear = substr ("$date001", 0,4); // ��
				if ($syear < 2300 ){  $syear = $syear + 543 ;  }
				$smm =  number_format(substr ("$date001", 5,2))  ; // ��͹
				$sday = (int)substr ("$date001", 8,2); // �ѹ
				$convert_date1 = "  $sday   ". $smonth[$smm] ." $syear  ";		
				return $convert_date1 ;
}
?>		
<html>
<head>
<title>�����Ţ���Ҫ���</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<script type="text/javascript" src="../../../common/jquery/1.4/jquery.min.js"></script>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
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
				var url = "ajax_setkp7_historymarry.php?runid=" + item1;
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
		alert("��س��к��ѹ�������¹����");
		document.form2.xdate.focus();
		return false;
	}else if(document.form2.prename_th.value.length == 0){
	alert("��س��кؤӹ�˹�Ҫ���");
		document.form2.prename_th.focus();
		return false;
	}else if(document.form2.name_th.value.length == 0){
	alert("��س��кت���");
		document.form2.name_th.focus();
		return false;
	}else if(document.form2.surname_th.value.length == 0){
	alert("��س��кع��ʡ��");
		document.form2.surname_th.focus();
		return false;
	}else {
		return true;
	}
}	
</script>
</head>
<body >
<?
$tbname = "hr_addhistorymarry" ; 
# print_r($_SESSION) ; 
$general_id = $_SESSION[id] ; 
# $runid = $general_id ; 
//echo "<pre>";print_r($_POST);die;
$prename_th=($prename_th!=0)?$prename_th:"";
if($prename_th&&$prename_th!=0){
	$strSQL="select * from $dbnamemaster.prename_th where PN_CODE='$prename_th' ";
	$result=@mysql_query($strSQL);
	$pre_result=@mysql_fetch_assoc($result);
	if($marry_prename_label==""){
			$prename_th=$pre_result['prename_th'];
	}else{
			$prename_th=$marry_prename_label;
	}
	//$prename_th=$pre_result['prename_th'];
	$marry_prename_id=$pre_result['PN_CODE'];	
	$prename_en=$pre_result['prename_en'];	
	//echo "<pre>"; print_r($_POST); print_r($pre_result); die;
}else{
	$prename_th="";
	$prename_id="";
	$prename_en="";
}
?>
<?
if($action != ""){
		add_log("�����Ż���ѵԡ������¹���������",$general_id,$action);
}

if($action == "changeRow"){
	for($i=0;$i<count($runno);$i++){
		$sql		= " update hr_addhistorymarry set runno='".$runno[$i]."' where gen_id='".$general_id."' and runid='".$runid[$i]."' ";		
		$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	}
	$xsql_h=mysql_query("SELECT * FROM $tbname WHERE gen_id='$general_id' ORDER BY runno DESC");
	$xrs_h=mysql_fetch_assoc($xsql_h);
		$sql_update="UPDATE general SET marry_prename='$xrs_h[prename_th]',marry_prename_id='$xrs_h[marry_prename_id]', marry_name='$xrs_h[name_th]', marry_surname='$xrs_h[surname_th]', marry_occ='$xrs_h[marry_occ]' WHERE id='$general_id'";
		$returnid = add_monitor_logbefore("general","id='$general_id'");
		$sql_query=mysql_query($sql_update);
		add_monitor_logafter("general","id='$general_id'",$returnid);
	
		
		echo "  <script language=\"JavaScript\">
		opener.top.mainFrame.document.form1.marry_prename.value=\"$xrs_h[prename_th]\"; 
	 	opener.top.mainFrame.document.form1.marry_name.value=\"$xrs_h[name_th]\"; 
	 	opener.top.mainFrame.document.form1.marry_surname.value=\"$xrs_h[surname_th]\"; 
	  	opener.top.mainFrame.document.form1.marry_occ.value=\"$xrs_h[marry_occ]\";
	 	</script>";	
}

if ($act=="del"){
add_log("�����Ż���ѵԡ������¹���������",$general_id,$act);
 $sql_del="SELECT * FROM $tbname WHERE gen_id='$general_id'";
 $rs_del=mysql_query($sql_del);
 $num_row_del=mysql_num_rows($rs_del);
 	if($num_row_del == 1){
		echo "<script language=\"JavaScript\"> alert(\"�������öź�����������ͧ�����ҧ��������������Ѻ������\");</script>";

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
				
				$returnid = add_monitor_logbefore("$tbname","gen_id='".$rs_x1[gen_id]."' and runid='".$rs_x1[runid]."'");
				@mysql_query($str_upDel);
				add_monitor_logafter("$tbname","gen_id='".$rs_x1[gen_id]."' and runid='".$rs_x1[runid]."'",$returnid);
				}

	}
	
$sql1 = "  SELECT * FROM `$tbname` WHERE `gen_id` = '$general_id' ORDER BY runno DESC ";    
$result1 = mysql_query($sql1) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sq1 <br> ".mysql_error() ."<br>"  ;   die;  } 
$rs1 = mysql_fetch_assoc($result1) ; 

$sql2 = " UPDATE `general`   SET  
 `marry_prename`='$rs1[prename_th]',   `marry_prename_id`='$rs1[marry_prename_id]',   
 `marry_name`='$rs1[name_th]',  
 `marry_surname`='$rs1[surname_th]',      `marry_occ`='$rs1[marry_occ]' 
WHERE (`id`='$general_id')   
" ; 
$returnid = add_monitor_logbefore("general","id='$general_id'");
$result2 = mysql_query($sql2) ; 
add_monitor_logafter("general","id='$general_id'",$returnid);
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sq2 <br> ".mysql_error() ."<br>"  ;   die;  } 
##############################################################
		echo "  <script language=\"JavaScript\">
		opener.top.mainFrame.document.form1.marry_prename.value=\"$rs1[prename_th]\"; 
	 	opener.top.mainFrame.document.form1.marry_name.value=\"$rs1[name_th]\"; 
	 	opener.top.mainFrame.document.form1.marry_surname.value=\"$rs1[surname_th]\"; 
	  	opener.top.mainFrame.document.form1.marry_occ.value=\"$rs1[marry_occ]\";
	 	</script>";	
$act="";
} ############  if ($act=="del"){ 
?>
<?
if ($edit !="" and $runid != "" ){
$tmpdate = explode("/" , $xdate) ;
$dd1 = $tmpdate[0] ; $mm1 = $tmpdate[1] ; $yy1 = $tmpdate[2] ; 
if ($yy1 > 2350){ $yy1 -=  543 ;  } 

$daterec = $yy1 ."-". $mm1  ."-". $dd1  ;  

if($kp7 == 1){
	$str_x1="select * from $tbname where gen_id='$general_id' and runid <>'$runid'";
	$result_x1=mysql_query($str_x1);
		while($rs_x1=mysql_fetch_assoc($result_x1)){
		$upkp7="0";
		$str_upx="update $tbname set kp7_active='$upkp7' where runid='".$rs_x1[runid]."' and gen_id='".$rs_x1[gen_id]."'";
			//echo $str_upx."<br>";
			@mysql_query($str_upx);
	}
	$sql = " UPDATE `$tbname` 
SET `prename_th`='$prename_th',`marry_prename_id`='$marry_prename_id',
`name_th`='$name_th',`surname_th`='$surname_th',`secondname_th`='$secondname_th',
`marry_occ`='$marry_occ', 
`daterec`='$xdate',`kp7_active`='$kp7',`updatetime`= NOW()
WHERE (`runid`='$runid')   
" ; 

$returnid = add_monitor_logbefore("$tbname","runid='$runid'");
$result = mysql_query($sql) ; 
add_monitor_logafter("$tbname","runid='$runid'",$returnid);

}else{

$sql = " UPDATE `$tbname` 
SET `prename_th`='$prename_th',`marry_prename_id`='$marry_prename_id',
`name_th`='$name_th',`surname_th`='$surname_th',`secondname_th`='$secondname_th',
`marry_occ`='$marry_occ', 
`daterec`='$xdate',`kp7_active`='$kp7',`updatetime`= NOW()
WHERE (`runid`='$runid')   
" ; 

$returnid = add_monitor_logbefore("$tbname","runid='$runid'");
$result = mysql_query($sql) ; 
add_monitor_logafter("$tbname","runid='$runid'",$returnid);

}

$sql1 = "  SELECT * FROM `$tbname` WHERE `gen_id` = '$general_id' ORDER BY runno DESC";    
$result1 = mysql_query($sql1) ; 
$rs1 = mysql_fetch_assoc($result1) ; 
$sql2 = " UPDATE `general`   SET  
 `marry_prename`='$rs1[prename_th]',   `marry_prename_id`='$rs1[marry_prename_id]',   
 `marry_name`='$rs1[name_th]',  
 `marry_surname`='$rs1[surname_th]',      `marry_occ`='$rs1[marry_occ]' 
WHERE (`id`='$general_id')   
" ; 
######################  marry_prename  
add_monitor_logafter("general","id='$general_id'",$returnid);
 $result2 = mysql_query($sql2) ; 
 add_monitor_logafter("general","id='$general_id'",$returnid);
// if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql2 <br> ".mysql_error() ."<br>"  ;  die;   } 
		echo "  <script language=\"JavaScript\">
		opener.top.mainFrame.document.form1.marry_prename.value=\"$rs1[prename_th]\"; 
	 	opener.top.mainFrame.document.form1.marry_name.value=\"$rs1[name_th]\"; 
	 	opener.top.mainFrame.document.form1.marry_surname.value=\"$rs1[surname_th]\"; 
	  	opener.top.mainFrame.document.form1.marry_occ.value=\"$rs1[marry_occ]\";
	 	</script>";				
} ############  if ($act=="del"){ 
?>
<?
if ($addnew  != ""){ 
/*
marry_prename
marry_name
marry_surname
*/

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
$returnid = add_monitor_logbefore("$tbname","runid='".$rs_x2[runid]."' and gen_id='".$rs_x2[gen_id]."'");
@mysql_query($str_upx2);
add_monitor_logafter("$tbname","runid='".$rs_x2[runid]."' and gen_id='".$rs_x2[gen_id]."'",$returnid);
	}
$sql = " 
INSERT INTO `$tbname` 
( `gen_id`,`prename_th`,`marry_prename_id`,`name_th`,`surname_th` ,`marry_occ`  , `daterec`,`updatetime`,`kp7_active`,`runno`) 
VALUES (   '$general_id','$prename_th','$marry_prename_id','$name_th','$surname_th' , '$marry_occ' , '$xdate',NOW(), '$kp7', '$runno_new')
";  

	$returnid = add_monitor_logbefore("$tbname","");
	$result = mysql_query($sql) ; 
	$max_idx = mysql_insert_id();
	add_monitor_logafter("$tbname","runid='$max_idx' and gen_id='$general_id'",$returnid);


}else{
$sql = " 
INSERT INTO `$tbname` 
( `gen_id`,`prename_th`,`marry_prename_id`,`name_th`,`surname_th` ,`marry_occ`  , `daterec`,`updatetime`,`kp7_active`,`runno`) 
VALUES (   '$general_id','$prename_th','$marry_prename_id','$name_th','$surname_th' , '$marry_occ' , '$xdate',NOW(), '$kp7', '$runno_new')
";  
	$returnid = add_monitor_logbefore("$tbname","");
	$result = mysql_query($sql) ; 
	$max_idx = mysql_insert_id();
	add_monitor_logafter("$tbname","runid='$max_idx' and gen_id='$general_id'",$returnid);

}
//if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   die; } 

$sql1 ="SELECT * FROM `$tbname` WHERE `gen_id` = '$general_id' ORDER BY runno DESC";    
$result1 = mysql_query($sql1) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sq1 <br> ".mysql_error() ."<br>"  ;   die;  } 
$rs1 = mysql_fetch_assoc($result1) ; 

$sql2 = " UPDATE `general`   SET  
 `marry_prename`='$rs1[prename_th]',   `marry_prename_id`='$rs1[marry_prename_id]',   
 `marry_name`='$rs1[name_th]',  
 `marry_surname`='$rs1[surname_th]',      `marry_occ`='$rs1[marry_occ]' 
WHERE (`id`='$general_id')   
" ; 

$returnid = add_monitor_logbefore("general","id='$general_id'");
$result2 = mysql_query($sql2) ; 
add_monitor_logafter("general","id='$general_id'",$returnid);
//if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sq2 <br> ".mysql_error() ."<br>"  ;   die;  } 

		echo "  <script language=\"JavaScript\">
		opener.top.mainFrame.document.form1.marry_prename.value=\"$rs1[prename_th]\"; 
	 	opener.top.mainFrame.document.form1.marry_name.value=\"$rs1[name_th]\"; 
	 	opener.top.mainFrame.document.form1.marry_surname.value=\"$rs1[surname_th]\"; 
	  	opener.top.mainFrame.document.form1.marry_occ.value=\"$rs1[marry_occ]\";
	 	</script>";	
} ################################################ if ($addnew  != ""){ 
 
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="60" bgcolor="#2C2C9E"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="15%"><div align="center"><img src="bimg/hr.gif" width="64" height="64" /></div></td>
              <td width="85%"><B class="pheader">
                <?=($rs[runid]!=0?"���":"����")?>
                ����ѵԡ������¹�ŧ�ӹ�˹�Ҫ��� ���� ���ʡ��   ����Ҫվ �ͧ������� </B></td>
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
<form name="formrh23" method="post" action="<?=$PHP_SELF?>">			
  <input type="hidden" name="action" value="changeRow">
   <input type="hidden" name="kp7" value="<?=$rs[runid];?>">

      <table width="98%" border="0" align="center" cellpadding="2" cellspacing="1">
        <tr class="gcaption"   align="center"  bgcolor="#A3B2CC"    >
          <td colspan="8" align="right"  ><!--<a href="?act=addnew"><img src="js/document_add.gif" width="24" height="24" border="0"></a>--></td>
        </tr>
        <tr class="gcaption"   align="center"  bgcolor="#A3B2CC"    >
          <td width="6%"  ><label>�ӴѺ</label></td>
          <td width="11%"  >�շ������¹����</td>
          <td width="11%">�ӹ�˹�Ҫ���</td>
          <td width="14%">����</td>
          <td width="14%">���ʡ��</td>
          <td width="17%">�Ҫվ</td>
          <td width="15%">ʶҹС���ʴ���� �.�.7 </td>
          <td width="12%">����ͧ���</td>
        </tr>
<?
$c_month=date("Y");
$new_month=$c_month+543;
$xsql="SELECT * FROM hr_addhistorymarry WHERE gen_id='$general_id'";
$xresult=mysql_query($xsql);
$xnum_row=mysql_num_rows($xresult);
	if($xnum_row<1){
		$xsql1="SELECT * FROM general WHERE id='$general_id'";
		$xresult1=mysql_query($xsql1);
			$xrs=mysql_fetch_assoc($xresult1);
			if($xrs[marry_name] != ""){
			$xsql2="INSERT INTO hr_addhistorymarry(gen_id, prename_th, name_th, surname_th, daterec, kp7_active, marry_occ)VALUES('".$xrs[id]."','".$xrs[marry_prename]."','".$xrs[marry_name]."','".$xrs[marry_surname]."','$new_month','1','".$xrs[marry_occ]."')";
			$xrs2=mysql_query($xsql2);
			}
	}
	$i=0;
	$sql = " SELECT * FROM hr_addhistorymarry WHERE gen_id='$general_id' ORDER BY runno ASC" ; 
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
$daterec = $rs[daterec] ; 
# $daterec = convert_date1($rs[daterec])  ; 

?>
		
        <tr  bgcolor="#<?=$bgcolor1?>"  >
          <td align="center" >
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
          <td align="center" > <?=$daterec?> </td>
          <td>&nbsp; <?=$rs[prename_th]?></td>
          <td>&nbsp; <?=$rs[name_th]?></td>
          <td>&nbsp; <?=$rs[surname_th]?></td>
          <td>&nbsp; <?=$rs[marry_occ]?></td>
          <td align="center"><? if($rs[kp7_active]=="1"){  $dis_delete="disabled"; echo "<img src=\"../../../images_sys/approve20.png\" alt='�ʴ�������� ��7'>";}else{ echo "<img src=\"../../../images_sys/b_drop.png\" alt='����ʴ�������� ��7'>"; $dis_delete="";}?></td>
          <td align="center"> 

		  
            <input class="xbutton" style="width: 70;" type="button" value="Edit" onClick="location.href='?runid=<?=$rs[runid]?>&act=edit';" name="button2">
          
          <input class="xbutton"  style="width: 50;" type="button" value="Delete" onClick="if (confirm('�س���ѧź������ ��ѹ��� <?=$daterec?>!!')) location.href='?act=del&runid=<?=$rs[runid]?>';" name="button3" <?=$dis_delete?>></td>
        </tr >
        
<?
} ########## END while($rs = mysql_fetch_assoc($result)){ 
?>		
    </table>
	 <table width="98%" border="0" align="center" cellpadding="2" cellspacing="1">
	 <tr><td align="center"><input type="submit" name="Submit" value="�ѹ�֡������§�ӴѺ����ʴ���� �.�.7"></td></tr>
	</table>
</form>	
<?
} # END  ##########  if ($act==""){  
if ($act=="edit"){ 
?>
<form name="formrh" method="post" action="?">
<?
$sql = " SELECT *  FROM $tbname WHERE  runid = $runid "; 
$result = mysql_query($sql) ; 
$rs = mysql_fetch_assoc($result) ; 
?>
  <table width="98%" border="0" align="center">
    <tr>
      <td colspan="5" bgcolor="#A3B2CC">&nbsp; <strong>���</strong></td>
    </tr>
    <tr>
      <td width="11%" align="right">�շ������¹����</td>
      <td colspan="4">
	    <?

#    $xdate = "2513-01-03";    == >��ԷԹ ==> 10/12/2550   
$daterec = "$rs[daterec]";

$th_yy = date("Y")+543 ; 
$th_yy_60 = $th_yy - 60 ; 
?>
        <select name="xdate"  >
          <?   for ($ii = $th_yy ;  $ii > $th_yy_60 ; $ii-- ){   


if ($daterec == $ii ){
	$str_selected = " selected " ; 
}else{
	$str_selected = "  " ; 
} ## if ($xdate == $ii ){
?>
          <option value="<?=$ii?>" <?=$str_selected?> >
            <?=$ii?>
            </option>
          <?  } #### for ($ii = $th_yy ;  $ii <= $th_yy_60 ; $ii-- ){   ?>
        </select>
          

           <input name="runid" type="hidden" id="runid" value="<?=$runid?>"></td>
      </tr>
    <tr class="gcaption">
      <td align="right">&nbsp;</td>
      <td width="15%" align="center">�ӹ�˹�Ҫ���</td>
      <td width="20%" align="center">����</td>
      <td width="21%" align="center">���ʡ��</td>
      <td width="33%" align="center">�Ҫվ</td>
    </tr>
    <tr>
      <td align="right"><span class="textp">(��) </span></td>
      <td><select name="prename_th"  style="width:140px;" >
        <option value="">����к�</option>
		 <?
		$strSQL="select prename_th as prename , PN_CODE,short_prename_th as sprename  from $dbnamemaster.prename_th WHERE prename_th !='' AND PN_CODE !='' AND active = 'on' group by PN_CODE order by orderby , prename_th ";		
		$select1  = mysql_query($strSQL);
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)){
			if($rselect1[sprename] != ""){
				$xprename = "$rselect1[prename]($rselect1[sprename])";	
			}else{
				$xprename = "$rselect1[prename]";	
			}

			
		if( ($rs[prename_th] == $rselect1[prename]) || ($rs[marry_prename_id] == $rselect1[PN_CODE] && ($rs[marry_prename_id]) && ($rselect1[PN_CODE])) )		
		{ 			
			$PN_CODE_CONVETOR="$rselect1[PN_CODE]";
			echo "<option value='$rselect1[PN_CODE]' SELECTED>$xprename</option>";
		}else
			{
			echo "<option value='$rselect1[PN_CODE]' >$xprename</option>";
			}
		}//end while
		?>
      </select></td>
      <td><input name="name_th" id="name_th" type="text" class="input_text" value="<?=$rs[name_th]?>" size="20" onKeyPress="isThaichar(this.value,'name_th','')" onKeyUp="isThaichar(this.value,'name_th','')" onBlur="isThaichar(this.value,'name_th','full')"></td>
      <td><input name="surname_th" id="surname_th" type="text" class="input_text" value="<?=$rs[surname_th]?>" size="20" ></td><!--onKeyPress="isThaichar(this.value,'surname_th','')" onKeyUp="isThaichar(this.value,'surname_th','')" onBlur="isThaichar(this.value,'surname_th','full')"-->
      <td><input name="marry_occ" type="text" class="input_text" value="<?=$rs[marry_occ]?>" size="20"></td>
    </tr>
    <tr>
      <td align="right"></td>
      <td colspan="4">
      		<input name="marry_prename_label" type="text" class="input_text" value="<?=$rs[prename_th]?>" size="23" > 
            <span class="style1">�ҡ��ҹ�ѹ�֡㹪�ͧ�ʴ��� ��.7 �к��йӢ����Ź���ʴ���� ��.7 ᷹</span>
      </td>
      </tr>
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
      <td colspan="3"><label>
	  <?
		$sql = " SELECT * FROM $tbname WHERE gen_id='$general_id' AND kp7_active=1 ORDER BY runno ASC" ; 
		$result = mysql_query($sql) ; 
		$row=mysql_num_rows($result);
		if($rs[kp7_active]=="1" && $row==1 ){ $kp7_st_active="disabled"; }else{ $kp7_st_active=""; } 	  
		
	  ?>
        <input name="kp7" type="radio" value="1" <? if($rs[kp7_active]=="1"){ echo "checked";}?>>
        �ʴ���� �.�.7 &nbsp;
        <input name="kp7" type="radio" value="0" <? if($rs[kp7_active]=="0"){ echo "checked";} echo $disabled_show;?>>
      ����ʴ���� �.�.7</label></td>
      </tr>
    
    <tr>
      <td colspan="5" align="center"><br>
        <input name="edit" type="submit" id="edit" value="�ѹ�֡">
        &nbsp;
        <input type="button" name="Submit222" value="��͹��Ѻ" onClick="history.go(-1) "></td>
      </tr>
  </table>
</form>
<?
}  ########## END  if ($act=="edit"){ 
?>	
<?  if ($act == ""){   ?>
<form name="form2" method="post" action="?" onSubmit="return check();">

  <table width="98%" border="0" align="center">
    <tr>
      <td colspan="5" bgcolor="#A3B2CC">&nbsp;<strong>��������</strong></td>
    </tr>
    <tr>
      <td width="11%" align="right">�շ������¹����</td>
      <td colspan="4"><?
$th_yy = date("Y")+543 ; 
$th_yy_60 = $th_yy - 60 ; 
?>
        <select name="xdate"  >
          <?   for ($ii = $th_yy ;  $ii > $th_yy_60 ; $ii-- ){   


if ($xdate == $ii ){
	$str_selected = " selected " ; 
}else{
	$str_selected = "  " ; 
} ## if ($xdate == $ii ){
?>
          <option value="<?=$ii?>" <?=$str_selected?> >
            <?=$ii?>
            </option>
          <?  } #### for ($ii = $th_yy ;  $ii <= $th_yy_60 ; $ii-- ){   ?>
        </select>
        <input name="runid" type="hidden" id="runid" value="<?=$runid?>"></td>
      </tr>
    <tr class="gcaption">
      <td align="right">&nbsp;</td>
      <td width="15%" align="center">�ӹ�˹�Ҫ���</td>
      <td width="20%" align="center">����</td>
      <td width="21%" align="center">���ʡ��</td>
      <td width="33%" align="center">�Ҫվ</td>
    </tr>
    <tr>
      <td align="right"><span class="style1">*</span><span class="textp">(��) </span></td>
      <td><select name="prename_th"  style="width:140px;" >
        <option value="">����к�</option>
		 <?
		$strSQL="select prename_th as prename , PN_CODE,short_prename_th as sprename  from $dbnamemaster.prename_th WHERE prename_th !='' AND PN_CODE !='' AND active = 'on' group by PN_CODE  order by orderby , prename_th ";		
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
			echo "<option value='$rselect1[PN_CODE]' SELECTED>$xprename</option>";
		}else
			{
			echo "<option value='$rselect1[PN_CODE]' >$xprename</option>";
			}
		}//end while
		?>
      </select></td>
      <td><input name="name_th" id="name_th" type="text" class="input_text" value="<?=$rs[name_th]?>" size="20" onKeyPress="isThaichar(this.value,'name_th','')" onKeyUp="isThaichar(this.value,'name_th','')" onBlur="isThaichar(this.value,'name_th','full')"></td>
      <td><input name="surname_th" id="surname_th" type="text" class="input_text" value="<?=$rs[surname_th]?>" size="20" ></td><!--onKeyPress="isThaichar(this.value,'surname_th','')" onKeyUp="isThaichar(this.value,'surname_th','')" onBlur="isThaichar(this.value,'surname_th','full')"-->
      <td><input name="marry_occ" type="text" class="input_text" value="<?=$rs[marry_occ]?>" size="20"></td>
    </tr>
    <tr>
      <td align="right"></td>
      <td colspan="4">
      		<input name="marry_prename_label" type="text" class="input_text" value="<?=$rs[prename_th]?>" size="23" > 
            <span class="style1">�ҡ��ҹ�ѹ�֡㹪�ͧ�ʴ��� ��.7 �к��йӢ����Ź���ʴ���� ��.7 ᷹</span>
      </td>
      </tr>
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
      <td colspan="3"><label>
	  <?
		$sql = " SELECT * FROM $tbname WHERE gen_id='$general_id' AND kp7_active=1 ORDER BY runno ASC" ; 
		$result = mysql_query($sql) ; 
		$row=mysql_num_rows($result);
		if($row==0 ){ $kp7_st_active="disabled"; }else{ $kp7_st_active=""; } 	  
	  ?>  	  
        <input name="kp7" type="radio" value="1" checked="checked">
        �ʴ���� �.�.7 &nbsp;
        <input name="kp7" type="radio" value="0"  <?= $kp7_st_active?>>
        ����ʴ���� �.�.7</label></td>
    </tr>
    
    <tr>
      <td colspan="5" align="center"><br>
        <input name="addnew" type="submit" id="addnew" value="�ѹ�֡">
        &nbsp;
        <input type="button" name="Submit22" value="�Դ˹�ҹ��" onClick="window.close(); "></td>
    </tr>
  </table>
</form>
<? } #######   if ($act == "addnew"){   ?> 
<table width="98%" border="0" align="center">
  <tr>
    <td colspan="2"><strong>�����˵�</strong></td>
  </tr>
  <tr>
    <td width="8%">&nbsp;</td>
    <td width="92%">����ͺѹ�֡�������к������¡�֧������ ˹�Һѹ�֡�����ŷ����(˹�ҡ�͹���)���� �ҡ�ա�úѹ�֡�������˹�Ң����ŷ���� ��سҺѹ�֡˹�Һѹ�֡�����ŷ����(˹�ҡ�͹���) ��͹�ѹ�֡ ����ѵԡ������¹�ŧ�ӹ�˹�Ҫ��� ���ʡ��   ����Ҫվ �ͧ������� </td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
<script>
function isThaichar(str,obj,type){  
    var orgi_text="()����֤������Ӿ���ùºţ�ˡ������ǧ�����׷�������������𮱸��ϭ��Ħ�����ȫ������";  
    var str_length=str.length;  
    var str_length_end=str_length-1;  
    var isThai=true;  
    var Char_At="";  
    for(i=0;i<str_length;i++){  
        Char_At=str.charAt(i);  
        if(orgi_text.indexOf(Char_At)==-1){  
            isThai=false;  
        }     
    }  
    if(str_length>=1){  
        if(isThai==false){  
			$('#'+obj).val(str.substr(0,str_length_end));
        }  
    }

	if(type=='full' && isThai==false){
		alert('�ͧ�Ѻ��á�͡�ѡ����������ҹ��');
		$('#'+obj).val('');
		$('#'+obj).focus();
	}
    return isThai; // ����� true �ʴ�����������·�����  
}
</script>
