<?php

#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_salary";
$module_code 		= "salary"; 
$process_id			= "salary";
$VERSION 				= "9.1";
$BypassAPP 			= true;
#########################################################
#Developer::
#DateCreate::17/07/2007
#LastUpdate::17/07/2007
#DatabaseTabel::
#END
#########################################################
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include("../../../config/phpconfig.php");
include("inc/libary.php");
include("../../../common/class-date-format.php");


// =====Constant ===============

/*
echo "<pre>";
print_r($namevit);
echo "</pre>";
*/
//===========================
$ip_check=substr($_SERVER["REMOTE_ADDR"],0,8);
if(($ip_check == "192.168.") or ($ip_check == "127.0.0.")){
$intraip_st = true;
}else{
$intraip_st = false;
}
$arr_type_day=array('d ��� YY','� ��� ��','d ���� YYYY','d ���� YY','d ���� �.�. YY','d ���� �.�.YYYY','� ���� �.�.��','� ����  �.�.����','� ���� ����','d ��� YYYY','� ��� ����','� ��� �.�. ����','� ��� �.�. ��','d ��� �.�. YYYY','d ��� �.�.YY','d ����� YY','� ����� ��','d ����� YYYY','� ����� ����','� ����� �.�. ����','� ����� �.�. ��','d ����� �.�. YYYY','d ����� �.�. YY','d ������ YY','� ������ ��','d ������ YYYY','� ������ ����','� ������ �.�. ����','� ������ �.�. ��','d ������ �.�. YYYY','d ������ �.�. YY');

function option_day($sent_day,$select_day){
global $arr_type_day; 
$b_day1 = new date_format;
echo "<select name='sent_day'>";
		echo "<option value=''>����к�</option>";
		foreach($arr_type_day as $val){
		$xday=$b_day1->show_date($val,$sent_day);
			echo "<option value='$xday'> $xday</option>";
		}	
	echo "</select>";
}

function option_day1($sent_day1){
global $arr_type_day; 
$b_day1 = new date_format;
echo "<select name='sent_day1'>";
echo "<option value=''>����к�</option>";
		foreach($arr_type_day as $val){
		$xday=$b_day1->show_date($val,$sent_day1);
			echo "<option value='$xday'> $xday</option>";
		}	
	echo "</select>";
}


$time_start = getmicrotime();
if ($_SERVER[REQUEST_METHOD] == "POST"){
$salary_st=str_replace(',',"",$salary);
add_log("�������Թ��͹",$id,$action);
$pls			= trim($pls);
$pls			= wordwrap($pls, 65, "\n", true);

if($action=="edit1")
{
	$dateorder	= ($checkdateorder == 0) ? "" : $dateorder_year.'-'.$dateorder_month.'-'.$dateorder_day ;
	$date 		= ($checkdate == 0) ? "" :$salary_year.'-'.$salary_month.'-'.$salary_day;
}
else if($action=="edit2")
{
	if($checkdate == 0){$date 		= "";}
	else if($checkdate == 1 ){$date  =$salary_year.'-'.$salary_month.'-'.$salary_day;}
	else if($checkdate == 2){$date=$olddate;}
	
	if($checkdateorder==0){$dateorder="";}
	else if($checkdateorder==1){$dateorder=$dateorder_year.'-'.$dateorder_month.'-'.$dateorder_day ;}
	else if($checkdateorder==2){$dateorder=$olddateorder;}
}

$comedate=$comeyear."-".$comemonth."-".$comeday;
if($action == "changeRow"){
	for($i=0;$i<count($runno);$i++){
		$sql		= " update salary set runno='".$runno[$i]."' where id='".$id."' and runid='".$runid[$i]."' ";		
		$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	}
	//header("Location: ?id=$id");
	
	echo"<meta http-equiv='refresh' content='0;URL=start_work.php?action=edit&viewall=1'>";
	exit;
}


  	$result 		= mysql_query(" select max(runno) as runno from salary where id='$id'; ")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
  	$rs			= mysql_fetch_assoc($result);
  	$runno		= ($rs[runno] <= 0) ? 1 : ($rs[runno] + 1);
	mysql_free_result($result);
	unset($rs);

if($_POST[action]=="edit2"){
	if($instruct=="other")
	{
	$instruct=$instruct1;
	}
	else
	{
		$instruct=$instruct;
	}
$resultx1 = mysql_query(" SELECT  remark  FROM  vitaya_stat  WHERE    id ='$id'  AND  remark = '$noorder_old' ");
	$rr1=mysql_fetch_assoc($resultx1);
	$numrr1=mysql_num_rows($resultx1);
	if (($numrr1 !=0) 	and ($noorder_old == $rr1[remark])){
			$sql_update1 =  "UPDATE vitaya_stat  SET remark='$noorder' WHERE   id ='$id'  AND  remark='$noorder_old'" ;	
			//echo "$sql_update";
		mysql_query($sql_update1) or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	} 
	$resultx = mysql_query(" SELECT  remark  FROM  vitaya_stat  WHERE    id ='$id'  AND  remark = '$noorder' ");
	$rr=mysql_fetch_assoc($resultx);
	$numrr=mysql_num_rows($resultx);
	//��ҹ���͹����礤��������Է°ҹЫ�ӡѹ�������
	$sql_name=mysql_query("select * from vitaya_stat WHERE id='$id' and name='$vitaya' ");
	$arn=mysql_fetch_assoc($sql_name);
	$numname=mysql_num_rows($sql_name);
	if($numname==0 and $numrr !=0) //����ӡѹ___________________________________________//......
		{
		if($vitaya !="")
		{
		//echo "����������������������Ф�Ѻ";
		$sql_update =  "UPDATE vitaya_stat  SET  date_start = '$date', date_command = '$dateorder' , name = '$vitaya',remark='$noorder' WHERE   id ='$id'  AND  remark='$rr[remark]'" ;
		mysql_query($sql_update) or die("Query line ". __LINE__ ." error<hr>".mysql_error());
			}
		else
		{
			$delete="DELETE  FROM  vitaya_stat where id='$id' and remark='$rr[remark]' ";
			mysql_query($delete)or die(mysql_error());
		}
					echo"
				<script language=\"javascript\">
				alert(\"��Ѻ��ا�������Է°ҹ����º����\\n \");
				</script>";
		}
		else if($numname==0 and $numrr==0 and $vitaya !="")//�դ��ѧ�������������� ----------------------------------------//////
		{
			$sql_insert =  " insert  INTO  vitaya_stat  (id,name,date_command,date_start,remark)";
			 $sql_insert.="VALUES('$id','$vitaya','$dateorder','$date','$noorder')  " ;
			//echo "============".$sql_insert."<hr>";
			
		echo"
				<script language=\"javascript\">
				alert(\"��Ѻ��ا�������Է°ҹ����º����\\n \");
				</script>";
		$rrr=mysql_query($sql_insert);
		}
	if($numname==1)
		{
			if($arn[remark]==$noorder)//����� ��������Ţ����� 㹵�Ƿ����㹰ҹ�����ŵç�Ѻ ��Ƿ������������
			{}
			else
			{
			//echo "fdsfklds;fjdslf";
				$rtr="�Է°ҹ� $vitaya ���١�ѹ�֡ ���ͧ�ҡ�Է°ҹдѧ����� ����������㹤���觷�� $arn[remark]";
					echo"
				<script language=\"javascript\">
				alert(\"$rtr\\n \");
				</script>";
			}
			
		}
	if($label_dateorder != ""){ $label_dateorder_x = $label_dateorder;}else{ $label_dateorder_x = $sent_day1;}
	if($label_date != ""){ $label_date_x = $label_date; }else{ $label_date_x = $sent_day;}
		$sql 	= " update  salary set  `date`='$date', `position`='$hr_addposition' , noposition = '$noposition', radub = '$hr_addradub', salary ='$salary_st', ";
	$sql	.= " `upgrade` = '$upgrade'  , note ='$note' ,noorder = '$noorder',pls = '$pls' , ch_position = '$ch_position' ,ch_salary = '$ch_salary', ";
	$sql	.= " ch_radub='$ch_radub', dateorder = '$dateorder', pos_name='$pos_name',instruct='$instruct',label_date='$label_date_x',label_salary='$label_salary',label_dateorder='$label_dateorder_x',label_radub='$label_radub' where id ='$id' and runid ='$runid' ;";	
	//echo $sql."update";
	mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
echo"
				<script language=\"javascript\">
				alert(\"�����ŵ��˹� �дѺ ����ѵ���Թ��͹ �ѹ�֡���º����\\n \");
				</script>
			<meta http-equiv='refresh' content='0;URL=start_work.php?action=edit&YY=$YY&viewall=$v'>";
	exit;

} else {
	add_log("�������Թ��͹",$id,$new);
	if($instruct=="other")
	{
	$instruct=$instruct1;
	}
	else
	{
		$instruct=$instruct;
	}
	$sql 	= "INSERT INTO salary (id, `date`, `position`, noposition, radub, salary, `upgrade`, note, noorder, ch_position, ch_radub, ch_salary, pls, dateorder, ";
	$sql	.= " pos_name, runno,instruct,label_date,label_salary,label_dateorder,label_radub) VALUES ('$id', '$date', '$hr_addposition', '$noposition', '$hr_addradub', '$salary_st', '$upgrade', '$note', '$noorder', ";
	$sql	.= " '$ch_position', '$ch_radub','$ch_salary','$pls','$dateorder','$pos_name','$runno','$instruct','$label_date','$label_salary','$label_dateorder','$label_radub') ";			
//echo $sql."<hr>";
	mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	// ======= INPUT  VITAYATHANA===========
	
	$sqlvitaya="select * from vitaya_stat where id='$id' and name='$vitaya' ";
	//echo $sqlvitaya;
	$qvitaya=mysql_query($sqlvitaya)or die (mysql_error());
	$rsv=mysql_fetch_assoc($qvitaya);
	$numvitaya=mysql_num_rows($qvitaya);
	if($numvitaya >0)
	{
				$sql_insert =  " insert  INTO  vitaya_stat  (id,name,date_command,date_start,remark)";
			 $sql_insert.="VALUES('$id','$vitaya','$dateorder','$date','$noorder')  " ;
		//$sql_insert =  " insert  INTO  vitaya_stat  VALUES('$id','$vitaya','$date','$dateorder','$noorder')  " ;
//echo "hjlkjh;l".$sql_insert."=========";
		$msger=mysql_query($sql_insert);
	$mssg="�Է°ҹ� $vitaya ���١�ѹ�֡ ���ͧ�ҡ�Է°ҹдѧ����� ����������㹤���觷�� $rsv[remark]";
					echo"
				<script language=\"javascript\">
				alert(\"$mssg\\n \");
				</script>
			<meta http-equiv='refresh' content='0;URL=start_work.php?action=edit&YY=$YY&viewall=$v'>";
		
	}
	else if($numvitaya==0 and $vitaya !="")
	{
				$sql_insert =  " insert  INTO  vitaya_stat  (id,name,date_command,date_start,remark)";
			 $sql_insert.="VALUES('$id','$vitaya','$dateorder','$date','$noorder')  " ;
	//$sql_insert =  "INSERT  INTO  vitaya_stat  VALUES('$id','$vitaya','$date','$dateorder','$noorder' )" ;
	//echo $sql_insert."lkg;dsajf;lkdsjfdsl" ;
	$msger=mysql_query($sql_insert);
		echo"
				<script language=\"javascript\">
				alert(\"�������Է°ҹкѹ�֡���º����\\n \");
				</script>";
	}
				echo"
				<script language=\"javascript\">
				alert(\"��������ǹ���˹� �дѺ ����ѵ���Թ��͹�ѹ�֡���º����\\n \");
				</script>
			<meta http-equiv='refresh' content='0;URL=start_work.php?action=edit&YY=$YY&viewall=$v'>";
	//+++++++++++++++++++++++++++++++
	/*
		echo " 
				<script language=\"javascript\">
				alert(\"�ӡ�úѹ�֡�������������\\n \");
				location.href='?id=$id&action=edit#keys';
				</script>
				";
	//header("Location: ?id=$id&action=edit#keys");*/
	exit;
				
}
				

} elseif($_GET[action] == 'delete') {

	add_log("�������Թ��͹",$id,$action);
	mysql_query("delete from salary where id ='$id' and runid='$runid';")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	mysql_query("delete from vitaya_stat where id = $id and remark='$rem'")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	//header("Location: ?id=$id&action=edit");
	echo"<meta http-equiv='refresh' content='0;URL=start_work.php?action=edit&viewall=$v&YY=$YY'>";
	exit;
	
} else {		
	
	$sql 		= "select * from  general where id='$id'  ;";
	$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	$rs		= mysql_fetch_array($result,MYSQL_ASSOC);

	$sqlx 		= "select * from  vitaya_stat  where id='$id' AND date_start = '$date'  ;";
	$resultx 	= mysql_query($sqlx)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	$rsx		= mysql_fetch_array($resultx,MYSQL_ASSOC);

}
?>

<html>
<head>
<TITLE>application list</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">

<link href="libary/tab_style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="libary/tabber.js"></script>
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
body {  
	margin				: 0px  0px; 
	padding				: 0px  0px;
}

a:link { 
	color					: #005CA2; 
	text-decoration	: none;
}

a:visited { 
	color					: #005CA2; 
	text-decoration	: none;
}

a:active { 
	color					: #0099FF; 
	text-decoration	: underline
}

a:hover { 
	color					: #0099FF; 
	text-decoration	: underline;
}

.style1 {
	color					: #FFFFFF;
	font-weight		: bold;
}
.style3 {color: #000000}
.style5 {color: #000000; font-weight: bold; }
.style11 {color: #800000}
</style>
<!-- send id to menu flash -->
<script type="text/javascript">
document.write('<style type="text/css">.tabber{display:none;}<\/style>');
</script>
<script language="javascript">

function ylib_Browser()
{
	d				= document;
	this.agt		= navigator.userAgent.toLowerCase();
	this.major	= parseInt(navigator.appVersion);
	this.dom	= (d.getElementById)?1:0;
	this.ns		= (d.layers);
	this.ns4up	= (this.ns && this.major >=4);
	this.ns6	= (this.dom&&navigator.appName=="Netscape");
	this.op 		= (window.opera? 1:0);
	this.ie		= (d.all);
	this.ie4		= (d.all&&!this.dom)?1:0;
	this.ie4up	= (this.ie && this.major >= 4);
	this.ie5		= (d.all&&this.dom);
	this.win	= ((this.agt.indexOf("win")!=-1) || (this.agt.indexOf("16bit")!=-1));
	this.mac	= (this.agt.indexOf("mac")!=-1);
};

var oBw = new ylib_Browser();

function DisplayElement ( elt, displayValue ) {
	if ( typeof elt == "string" )
		elt = document.getElementById( elt );
	if ( elt == null ) return;
	if ( oBw && oBw.ns6 ) {
		// OTW table formatting will be lost:
		if ( displayValue == "block" && elt.tagName == "TR" )
			displayValue = "table-row";
		else if ( displayValue == "inline" && elt.tagName == "TR" )
			displayValue = "table-cell";
	}

	elt.style.display = displayValue;
}

function insert_bline(id, siteid)
{
	var url			= "bline_popup.php?kid=" + id + "&siteid=" + siteid;
	var newwin 	= window.open(url,'popup','location=0,status=no,scrollbars=no,resizable=no,width=500,height=370,top=200');
	newwin.focus();
} 

/*function disableInput(sta){
if(sta == 1){
	document.getElementById("t1").disabled=false;	
	document.getElementById("t2").disabled=false;
	document.getElementById("t3").disabled=false;
	document.getElementById("t4").disabled=false;
	document.getElementById("t5").disabled=false;
} else {
	document.getElementById("t1").disabled=true;	
	document.getElementById("t2").disabled=true;
	document.getElementById("t3").disabled=true;
	document.getElementById("t4").disabled=true;
	document.getElementById("t5").disabled=true;
}}*/

function popWindow(url, w, h){

	var popup		= "Popup"; 
	if(w == "") 	w = 420;
	if(h == "") 	h = 300;
	var newwin 	= window.open(url, popup,'location=0,status=no,scrollbars=yes,resizable=no,width=' + w + ',height=' + h + ',top=20');
	newwin.focus();

}

function onSelect(val, divid){
	if(val == 0){
 		document.getElementById(divid).style.display	= 'none';  
	} else {
		document.getElementById(divid).style.display	= 'block';  
	}
} 
function onSelect1(val, divid){
	if(val == 0){
 		document.getElementById(divid).style.display	= 'none';  
	} else {
		document.getElementById(divid).style.display	= 'block';  
	}
} 

function check(){
//alert(document.post.salary_year.value);
//alert (document.post.sc_gen.value)
var ddd = document.getElementById("checkdate1");
var ddd2 = document.getElementById("checkdate2");
//alert(ddd.value);
 if (document.post.checkdate2.checked==true  && document.post.salary_day.value =="" &&  document.post.salary_month.value =="" && document.post.salary_year.value =="")
{
 alert("��س��к��ѹ���(�ѹ ��͹ ��)");
 return false;
 }
 
else if(document.post.noorder.value.length == 0)
	{
		alert("�к������Ţ�����");
		document.post.noorder.focus();
		return false;
	} 
else if(document.post.label_salary.value !="" && document.post.salary.value ==0 )
	{
		alert("�к��ѵ���Թ��͹㹪�ͧ �Թ��͹�������繢�����ʶԵ�");
		return false;
	}
 if (document.post.checkdateorder2.checked==true  && document.post.dateorder_day.value =="" &&  document.post.dateorder_month.value =="" && document.post.dateorder_year.value =="")
{
 alert("��س��к��ѹ���(�͡�����ҧ�ԧ)");
 return false;
 }
// var position=
var sc_general= document.post.sc_gen.value;
var site_general= document.post.site_gen.value;
var ddddd= document.post.salary_year.value+document.post.salary_month.value+document.post.salary_day.value;
//(ddddd>25471224) &&(document.post.sc_gen.value !="") &&
//alert(ddddd);
//alert(site_general);
//alert(sc_general);
// &&( document.post.hr_addposition.value !="��ټ�����" || document.post.hr_addposition.value !="���" || document.post.hr_addposition.value !="����ӹ�¡��ʶҹ�֡��" || document.post.hr_addposition.value !="�ͧ����ӹ�¡��ʶҹ�֡��")
if((ddddd>25471224) &&(sc_general != site_general) && ( (document.post.hr_addposition.value !="��ټ�����") && (document.post.hr_addposition.value != "���") && (document.post.hr_addposition.value !="����ӹ�¡��ʶҹ�֡��" )) && (document.post.hr_addposition.value !="�ͧ����ӹ�¡��ʶҹ�֡��" )&& (document.post.hr_addposition.value !="����ӹ�¡���ç���¹" )&& (document.post.hr_addposition.value !="����ӹ�¡���ٹ��")&& (document.post.hr_addposition.value !="����ӹ�¡���Է�����" ) )
{
	//alert(document.post.sc_gen.value);
	//alert(document.post.hr_addposition.value);
	alert("�ҡ ����Ҫ�ѭ�ѵ�����º����Ҫ��ä����кؤ�ҡ÷ҧ����֡�� �.�. 2547  �.�ѹ��� 21 �ѹ�Ҥ� �.�. 2547��Ǵ 3 ��á�˹����˹� �Է°ҹ���С��������Ѻ�Թ��͹ �Թ�Է°ҹ� ����Թ��Шӵ��˹� �ҵ�� 38 �ؤ�ҡ���ѧ�Ѵʶҹ�֡�� ����§���˹� ����ӹ�¡��ʶҹ�֡�� , �ͧ����ӹ�¡��ʶҹ�֡��, ���,����ӹ�¡���ç���¹,����ӹ�¡���ٹ��,����ӹ�¡���Է����� ��� ��ټ����� ��ҹ�鹡�س����͡���˹������ա���� ");
	return false;
}

}



function bbb()
{
	document.post.salary_day.disabled=false;
	document.post.salary_month.disabled=false;
	document.post.salary_year.disabled=false;
	document.post.label_date.disabled=false;
}
function clearselect()
{
	document.post.salary_day.disabled=true;
	document.post.salary_month.disabled=true;
	document.post.salary_year.disabled=true;
	document.post.label_date.disabled=true;
	
	 if (document.post.salary_day.value!="")
 	{
       document.post.salary_day.value="";
	   document.post.salary_day.disabled=true;
    }
	 if (document.post.salary_month.value!="")
 	{
       document.post.salary_month.value="";
	   document.post.salary_month.disabled=true;
    }
	
	 if (document.post.salary_year.value!="")
 	{
       document.post.salary_year.value="";
	   document.post.salary_year.disabled=true;
    }
	 if (document.post.label_date.value!="")
 	{
       document.post.label_date.value="";
	   document.post.label_date.disabled=true;
    }
}
function opendisable()
{
	document.post.dateorder_day.disabled=false;
	document.post.dateorder_month.disabled=false;
	document.post.dateorder_year.disabled=false;
	document.post.label_dateorder.disabled=false;
}
function disbb()
{
	document.post.dateorder_day.disabled=true;
	document.post.dateorder_month.disabled=true;
	document.post.dateorder_year.disabled=true;
	document.post.label_dateorder.disabled=true;
	
	 if (document.post.dateorder_day.value!="")
 	{
       document.post.dateorder_day.value="";
	   document.post.dateorder_day.disabled=true;
    }
	 if (document.post.dateorder_month.value!="")
 	{
       document.post.dateorder_month.value="";
	   document.post.dateorder_month.disabled=true;
    }
	
	 if (document.post.dateorder_year.value!="")
 	{
       document.post.dateorder_year.value="";
	   document.post.dateorder_year.disabled=true;
    }
	 if (document.post.label_dateorder.value!="")
 	{
       document.post.label_dateorder.value="";
	   document.post.label_dateorder.disabled=true;
    }
}

function check_radio(){
		document.post.vitaya_sts[1].checked = true;
}
function aaa()
{
document.post.instruct1.disabled=false;
}
 function doClear(instruct1) 
{
	document.post.instruct1.disabled=true;
     if (document.post.instruct1.value!="")
 	{
       document.post.instruct1.value="";
	   document.post.instruct1.disabled=true;
    }
}

function check_sum1(){
	var f1 = document.post;	
	a =  Number(f1.salary.value) ;
	if( a > 80000  ){
		alert(' ��سҵ�Ǩ�ͺ�������Թ��͹����ҹ��͡ \n ���ͧ����Ţ�Ҩ�ҡ���Ҥ����繨�ԧ ');
	}
}
var isMain = true;

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>
<body bgcolor="#A3B2CC" <?=$onload?>>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"> 
	<td><table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
	  
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30"><?
		 if($action=="edit" and $viewall==5){
		?>
            <? }else{?>
            <? }?></td>
      </tr>
    </table>      
      <span class="style5"><a href="start_work.php?id=<?=$rs[id]?>&action=edit&viewall=0" title="��䢢������Թ��͹" class="style3">&nbsp;</a>���� / ʡ�� &nbsp;<u>
      <?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]?>
      </u>


    
      &nbsp;</span><br>
      <br>
      <span class="style3"><strong><a href="start_work.php?id=<?=$rs[id]?>&action=edit&viewall=0" title="��䢢������Թ��͹" class="style3">&nbsp;</a>�� . �Ѵ��â����šó��͡�ҡ�Ҫ�����С�Ѻ�����Ѻ�Ҫ������� </strong></span></td>
  </tr>

  </table>
      
      <br>
      <?
if($action=="edit")
{
 if($viewall==5)
{
$i = 0;
$sql = "select * from salary where id='$id' order by runno asc";
$result = mysql_db_query($dbname,$sql) or die("Query line ". __LINE__ ." error<hr>".mysql_error());
$row	= mysql_num_rows($result);
?>
      <?

}

else if($viewall==0)
{
$i 			= 0;
$result 	= mysql_query("select * from salary where id='$id' order by runno asc;")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
$row		= mysql_num_rows($result);
?>
<?
$res 	= mysql_query("select * from salary where id='$id'  order by date DESC limit 1;")or die("Query line ". __LINE__ ." error<hr>".mysql_error());

$rr=mysql_fetch_array($res,MYSQL_ASSOC);
 	$d=explode("-","$rr[date]");
 
	$dmore=$d[0];
?>
  <form name="form1" method="post" action="<?=$PHP_SELF?>">			
    <p>
      <input type="hidden" name="action" value="changeRow">
      
      <input type="hidden" NAME="id" VALUE="<?=$id?>">
&nbsp;&nbsp;      <span class="style11"> <img src="../../../images_sys/new11.gif" ><br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;***���������ǹ��� ����͡੾�� ��ҹ��� ���͡�ҡ�Ҫ�����С�Ѻ����Ѻ�Ҫ������� ��觨��ռŵ�������Ҫ��âͧ��ҹ �Ըա�����͡ ���<br>
  <br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1).  ����ԡ��� �ٻ�Թ��� ���ش���¡�͹�͡�ҡ�Ҫ��� �ҡ������͡&nbsp;&quot;�͡�ҡ�Ҫ���&quot; ���ջ�����ᴧ�ʴ�ʶҹС���͡�ҡ�Ҫ��û�ҡ������<br>
  <br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2).</span><span class="style11"> ����ԡ��� �ٻ�Թ�� 㹻��á��ѧ�ҡ����Ѻ�Ҫ������� ������͡ &quot;��Ѻ����Ѻ�Ҫ�������&quot; ���ջ����������ʴ�ʶҹС�á�Ѻ����Ѻ�Ҫ��������ҡ������</span></p>
    <table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
  <tr bgcolor="#A3B2CC" align="center">
  <td colspan="9" bgcolor="#2C2C9E"><span class="style1">�������͹��鹵��˹�(�ʴ������ŷ�����)</span></td>
  </tr>
  <tr bgcolor="#A3B2CC" align="center" style="font-weight:bold;">
    <td width="9%"><strong>�ѹ ��͹ ��</strong></td>
	  <td width="31%"><strong>���˹�</strong></td>
	  <td width="8%"><strong>�Ţ���<br>
	    ���˹�</strong></td>
	  <td width="4%"><strong>�дѺ</strong></td>
	  <td width="7%"><strong>�ѵ��<br>
	    �Թ��͹</strong></td>
	  <td width="32%"><strong>�͡�����ҧ�ԧ</strong></td>
	  <td width="5%">ʶҹ�<br>
	    �ҧ�Ҫ���</td>
	  <td width="4%">��䢢�����</td>
  </tr>
  
  <?
while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
	$i++;
if ($i % 2) {
	$bg = "#EFEFEF";
}else{
	$bg = "#DDDDDD";
}
if($rs[instruct]=="#")
{
	$rinstruct="";
}
else
{
$rinstruct=$rs[instruct];
}
if($rs[label_salary] !="")
{
	$salary=$rs[label_salary];
}
else
{
	if($rs[salary]==0)
	{
	$salary="";
	}
	else
	{
	$salary=number_format($rs[salary]);
	}
}
if($rs[noorder]=="#")
{
	$noo="";
}
else
{
	$noo=$rs[noorder];
}
if($rs[label_date] !="")
{
	$dateshow= $rs[label_date];
}
else
{
		$dateshowX=MakeDate2($rs[date]);
	$DX=explode(" ",$dateshowX);
	//echo "$DX[0]";
	if($DX[0]==0){$dxt="";}else{$dxt=$DX[0];}
	$dateshow=$dxt.$DX[1].$DX[2];
}
if($rs[label_dateorder] !="")
{
	$dateorder=$rs[label_dateorder];
}
else
{
	$dateorderX=MakeDate2($rs[dateorder]);
	$DO=explode(" ",$dateorderX);
	//echo "$DX[0]";
	if($DO[0]==0){$dot="";}else{$dot=$DO[0];}
	$dateorder=$dot.$DO[1].$DO[2];
	//$dateorder=MakeDate2($rs[dateorder]);
}
if($rs[label_radub] !=""){$radub=$rs[label_radub]; }
else{$radub=$rs[radub];}
//__________________________________________
if($rs[status_startwork]=="out"){$showimg="<img src=\"../../../images_sys/circle1.gif\" alt=\"ʶҹС���͡�ҡ�Ҫ���\">";}
else if($rs[status_startwork]=="in"){$showimg="<img src=\"../../../images_sys/circle5.gif\" alt=\"ʶҹС������Ѻ�Ҫ�������\">";}
else{$showimg="";}

?>
  <tr align="center" bgcolor="<?=$bg?>">
    <td align="center"><?=$dateshow?></td>
	  <td align="left">&nbsp;
	    <?=wordwrap($rs[pls], 30, "\n", true)?></td>
	  <td align="center"><?=$rs[noposition] . $rs[status_startwork];?></td>
	  <td align="center"><?=$radub?></td>
	  <td align="center"><?=$salary?>&nbsp;</td>
	  <td align="left"><?=$noo." ".$rinstruct?>
        <input type="hidden" name="runid[]22" value="<?=$rs[runid]?>">
        <?=$dateorder?></td>
		
	  <td align="center"><?=$showimg;?></td>
	  <td align="center">
	  <? if($showimg ==""){?><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"  style="cursor:hand" onClick="MM_openBrWindow('fix_startwork.php?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&action=edit','<?=$rs[id]?>historyfather','scrollbars=yes,width=600,height=500')"><? }else{ ?> <img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Edit" style="cursor:hand" onClick="MM_openBrWindow('fix_startwork.php?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&action=DEL_OUT','<?=$rs[id]?>historyfather','scrollbars=yes,width=600,height=500')"><? }?>
	    &nbsp; </td>    
  </tr>
  <?
	} //while
// List Template
?>
  </table>
  </form>
  
  <?
  }//END view==1

}//END IF(action==edit)

?>
<a name="keys"></a>
<p>&nbsp;</p>
  <p>&nbsp;</p>
    </td></tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>