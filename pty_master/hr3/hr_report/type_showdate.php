<?php
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include("../../../common/class-date-format.php");

$sql_tempGeneral="
SELECT
general.idcard,
general.prename_th,
general.name_th,
general.surname_th
FROM `general`
WHERE		general.idcard =  '".$_GET['tempIdcard']."'
";
$rs_tempGeneral=mysql_db_query($dbname,$sql_tempGeneral)or die (mysql_error());
$res_tempGeneral=mysql_fetch_assoc($rs_tempGeneral);
$strName="";
if($res_tempGeneral['idcard']!=""){
		$strName=$res_tempGeneral['prename_th'].$res_tempGeneral['name_th']."     ".$res_tempGeneral['surname_th'];
}
	 
/*$b_day1 = new date_format;
$b_birth= $b_day1->show_date("d ��͹ ���� �.�. YYYY","2010"."-"."07"."-"."25");
echo $b_birth;*/
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
	//alert('test');
document.form.type_showdate2.disabled=false;
document.getElementById('temp_date').value='';
}

function copyText(){
		document.getElementById('temp_date').value=document.getElementById('type_showdate2').value;
		document.getElementById('temp_date2').innerHTML=document.getElementById('type_showdate2').value;
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
                    //document.getElementById('AmphurCHK').innerHTML=req.responseText; //�Ѻ��ҡ�Ѻ��
					document.getElementById('temp_date').value=req.responseText;
					document.getElementById('temp_date2').innerHTML=req.responseText;
               } 
          }
     };
     req.open("GET", "type_showdate_ajax.php?id="+sec+"&tempdate="+tempdate+"&tempStr="+tempStr+"&rnd="+(Math.random()*1000)); //���ҧ connection
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620"); // set Header
     req.send(null); //�觤��
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
</script>
<?
	 $sql77="SELECT type_dateshow  from general where idcard='$_SESSION[idoffice]' ";
	 $q77=mysql_db_query($dbname,$sql77)or die (mysql_error());
	 $rs77=mysql_fetch_assoc($q77);
	 if($rs77[type_dateshow] !=341 and  $rs77[type_dateshow] !=351 and $rs77[type_dateshow] !=361 and $rs77[type_dateshow] !=371 )
	 {
	 $typeshow=341;
	 }
	 else
	 {
	 	$typeshow=$rs77[type_dateshow] ;
	 }
	 
	 $sql78="SELECT * FROM  type_showdate where id_type='$rs77[type_dateshow]' and type_nec='n' ";
	 $q78=mysql_db_query($dbname,$sql78)or die (mysql_error());
	 $rs78=mysql_fetch_assoc($q78);
	 
if ($_SERVER[REQUEST_METHOD] == "POST"){

}
mysql_db_query($dbnamemaster , "select 1 " ) ; 
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
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script>
function getData(e){		
		opener.document.getElementById('label_type_showdate').value = e;
		opener.document.getElementById('label_type_showdate').focus();
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
<body  onLoad="tempOnLoad();">





<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="60" bgcolor="#2C2C9E"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="15%">&nbsp;</td>
              <td width="85%"><B class="pheader">���͡�ٻẺ����ʴ��� �ѹ��� � �.�.7 ��ǹ��� 1</B></td>
            </tr>
        </table></td>
      </tr>
      <tr>

        <td>&nbsp;</td>
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
					$query_showdate=mysql_db_query($dbname,$sql_showdate)or die(mysql_error()."fhfhfhfhfh");
					}

	$sql_date="select id_type from  type_showdate where type_date='$type_showdate1' ";
	//echo $sql_date;
	$q_date=mysql_db_query($dbname,$sql_date)or die (mysql_error());
	$rsd=mysql_fetch_assoc($q_date);
	$type_showdate3=$rsd[id_type];
}
else
{
	$type_showdate3=$type_showdate;

	}
$sql = "UPDATE general SET type_dateshow='$type_showdate3' where idcard='$_SESSION[idoffice]' ";
//echo  $sql."<hr>";
$result = mysql_db_query($dbname,$sql) or die (mysql_error()) ;
if($result)
{
$msg="�ٻẺ����ʴ����ѹ�����١�ѹ�֡�������";
				echo"<script language=\"javascript\">
				alert(\"$msg\\n \");
				</script>";
				//echo"<meta http-equiv='refresh' content='0;URL=type_showdate2.php'>";
				echo"<script language=\"javascript\">getData('$type_showdate2');</script>";
				echo"<script language=\"javascript\">window.close();</script>";
				exit;
}
else
{
				$msg="�������ö�ѹ�֡��������";
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
      <td colspan="5" bgcolor="#A3B2CC">&nbsp;<strong> �к��ٻẺ����ʴ��� �ͧ�ѹ���ͧ�ѹ�Դ � �.�.7 </strong></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" align="center">
      <div style="background:url(../../../images_sys/sec1.PNG) no-repeat; width:1000px; height:145px; margin:0; padding:0; float:left; font-size:16px; font-weight:bold;">
        <div style="background:#FF9; width:240px; height:18px; margin:10px 0 0 110px; float:left;"><strong><div id="showname"><?=$strName?></div></strong></div>
        <div style="background:#FF9; width:350px; height:28px; margin:8px 0 0 170px; float:left;"><div id="temp_date2"></div></div>
	</div>
      </td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      		<strong>�ѹ��͹���Դ		<?=$_GET['tempBirth']?></strong>
      </td>
    </tr>
    <tr>
      <td colspan="5" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      		�. ���� 
      		  <input name="temp_name" id="temp_name" value="<?=$strName?>" size="50" disabled>
�Դ�ѹ���<input name="temp_date" id="temp_date" value="" size="50" disabled >
      </td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    
     <?

	 
	 
	 $sql6="SELECT * FROM  type_showdate where type_nec='y' order by id_type  DESC LIMIT 4 ";
	  		$query6=mysql_db_query($dbname,$sql6)or die (mysql_error());
			while($rs6=mysql_fetch_assoc($query6))
			{
			
	  ?>
     
     <tr>
      <td width="9%">&nbsp;</td>
      <td width="21%"><p>
        <input type="radio" name="type_showdate" value="<?=$rs6[id_type]?>" <?  if($rs6[id_type]==$typeshow ){ echo "checked";}?> onClick="doClear(this); getBirthShow(this.value);" onFocus="getBirthShow(this.value);">
        <input type="hidden" name="temp_name_showdate_<?=$rs6[id_type]?>" id="temp_name_showdate_<?=$rs6[id_type]?>" size="30" value="<?=$rs6[type_date]?>">
        <?="$rs6[type_date]";?>
      </td>
	  <td width="70%"><font color="#FF0000">
	    <?= "**". $rs6[type_detail]?>
	  </font></td>
    </tr> <? }?>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2"><input type="radio" name="type_showdate" value="other" onClick="aaa();" <? if($rs77[type_dateshow]==$rs78[id_type]){echo "checked";}?> >
      ����(�к�)
        <input name="type_showdate2" id="type_showdate2" type="text" <?=($rs77[type_dateshow]==$rs78[id_type])?"":'disabled="disabled"'?> value="<?=$rs78[type_date]?>" size="50" onKeyUp="copyText();">
        <input type="hidden" id="temp77" name="temp77" value="<?=$rs77[type_dateshow]?>"><input type="hidden" id="temp78" name="temp78" value="<?=$rs78[id_type]?>">
        </td>
      </tr>
	 
    
    <tr>
      <td colspan="5" align="center"><br>
        <input name="addnew" type="submit" id="addnew" value="�ѹ�֡">
        &nbsp;
        <input type="button" name="Submit22" value="�Դ˹�ҹ��" onClick="window.close(); "></td>
      </tr>
  </table>
</form>
<? } #######   if ($act == ""){   ?> 
<table width="98%" border="0" align="center">
  <tr>
    <td colspan="2"><strong>�����˵�</strong></td>
  </tr>
  <tr>
    <td width="8%">&nbsp;</td>
    <td width="92%">����ͺѹ�֡�������к������¡�֧������ ˹�Һѹ�֡�����ŷ����(˹�ҡ�͹���)���� �ҡ�ա�úѹ�֡�������˹�Ң����ŷ���� ��سҺѹ�֡˹�Һѹ�֡�����ŷ����(˹�ҡ�͹���) ��͹�ѹ�֡ �ٻẺ����ʴ����ѹ�Դ � �.�.7 </td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
