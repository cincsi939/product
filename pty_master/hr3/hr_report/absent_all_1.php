<?php
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_absent";
$module_code 		= "absent"; 
$process_id			= "absent";
$VERSION 				= "9.91";
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
//include("../../../config/phpconfig.php");
include("alert.php");
 $_GET['id']= $_SESSION[id];
 $_POST['id']= $_SESSION[id];
$time_start = getmicrotime();
$mmeng = array("","january","february","march","april","may","june","july","august","september","october","november","december");
 $ch_yea=$_POST[ch_year];
if($ch_yea==1) {

    $sqlgen="select  *  from  general   where id='$id'";
	   $relult=mysql_query($sqlgen);
	   while($ros=mysql_fetch_array($relult)){
		   $begindate=$ros['begindate'];
	   }

 	 $s=explode("/", $_POST['txtstartdate']);
  $startdate=$s[2]."-".$s[1]."-".$s[0];    
	$e=explode("/", $_POST['txtenddate']);
   $enddate=$e[2]."-".$e[1]."-".$e[0];
   $startedu=($s[2]-543)."-".$s[1]."-".$s[0]; 
   $endedu=($e[2]-543)."-".$e[1]."-".$e[0];

    $start=$s[2];
	$end=$e[2];
	$yeardif=$end-$start;
//----------------------------------------------------------------------------------------------------------------
//case ��� 1

if($yeardif==0){

$start_diff_day =strtotime(intval($s[0])." ".$mmeng[intval($s[1])]." ".($s[2]-543));
$end_diff_day =strtotime(intval($e[0])." ".$mmeng[intval($e[1])]." ".($e[2]-543));
$timediff =$end_diff_day-$start_diff_day;
$education=intval($timediff/86400);

if ($_SERVER[REQUEST_METHOD] == "POST"){
if($_POST[action]=="edit2"){
			 
    $sql = "update  hr_absent  set  education='$education',startdate = '$startdate',enddate='$enddate' 
	where id ='$id' and yy='$start' ";
		mysql_query($sql)or die("�������ö��䢢�������");
		//echo "<meta http-equiv='refresh' content='1;URL=absent.php>";
		echo "<script language=\"javascript\">
				alert(\"".msgedit."\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
		         exit;
	               } else { 
		     if($startdate>$enddate){
				  	echo "
					<script language=\"javascript\">
					alert(\"".msg1."\\n \");
					location.href='?id=$id&action=edit';
					</script>
				    ";
			       }else{
			      if(($startdate<=$begindate)&&($enddate<=$begindate)&&($startdate=="")&&($enddate==""))
				   { 
					 echo "
					<script language=\"javascript\">
					alert(\"�ѹ����ҵ�ͧ�����¡����ѹ����Ѻ�Ҫ���\\n \");
					location.href='?id=$id&action=edit';
					</script>
				     ";
				   }else {
				 $sql = "INSERT INTO  hr_absent (id,yy,education,startdate,enddate) VALUES ('$id','$start','$education','$startdate
				 ','$enddate')";
				 $result  = mysql_query($sql);		
					if($result)
					{
					echo "
				<script language=\"javascript\">
				alert(\"".msginsert."\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
				//	header("Location: ?id=$id&action=edit");
					exit;
					}else{	$msg = "�������ö�ѹ�֡�������� ";}
			}//�����ѹ��
	      }//�����ѹ���������ش
	   }
    }
//-----------------------------------------------------------------------------------------------------------------------
//case ��� 2
     } 
	 
	else 
	{
		
		$sql_12="SELECT DATEDIFF('$endedu 23:59:59','$startedu') as sw";
		//$sql_12="SELECT DATEDIFF ('$endedu','$startedu') AS e";
		$query_edu=mysql_query($sql_12)or die ("ERRRRRR".__LINE__.mysql_error());
		$ab_edu=mysql_fetch_assoc($query_edu);
		$education=$ab_edu[sw];
	
if ($_SERVER[REQUEST_METHOD] == "POST"){
if($_POST[action]=="edit2"){			 
    $sql = "update  hr_absent  set  education='$education',startdate = '$startdate',enddate='$enddate',label_education='$label_education'
	where id ='$id' and yy='$start' ";
		mysql_query($sql)or die("�������ö��䢢�������");
		//echo "<meta http-equiv='refresh' content='1;URL=absent.php>";
		echo "<script language=\"javascript\">
				alert(\"".msgedit."\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
		         exit;
	               } else { 
		     if($startdate>$enddate){
				  	echo "
					<script language=\"javascript\">
					alert(\"".msg1."\\n \");
					location.href='?id=$id&action=edit';
					</script>
				    ";
			       }else{
			      if(($startdate<=$begindate)&&($enddate<=$begindate)&&($startdate=="")&&($enddate==""))
				   { 
					 echo "
					<script language=\"javascript\">
					alert(\"�ѹ����ҵ�ͧ�����¡����ѹ����Ѻ�Ҫ���\\n \");
					location.href='?id=$id&action=edit';
					</script>
				     ";
				   }else {
				 $sql = "INSERT INTO  hr_absent (id,yy,education,startdate,enddate,label_education) VALUES ('$id','$start','$education','$startdate
				 ','$enddate','$label_education')";
				 $result  = mysql_query($sql);		
					if($result)
					{
					echo "
				<script language=\"javascript\">
				alert(\"".msginsert."\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
				//	header("Location: ?id=$id&action=edit");
					exit;
					}else{	$msg = "�������ö�ѹ�֡�������� ";}
			}//�����ѹ��
	      }//�����ѹ���������ش
	   }
    }
		
	}///////////////////////////////////////////
	/*elseif($yeardif==1){

    $startsql="SELECT DAYOFYEAR('".$startdate."') AS start_year";
	$result_start=mysql_query ($startsql);
	$row_start = mysql_fetch_array ($result_start); 
    $startyear=$row_start['start_year'];

	$sec="SELECT DAYOFYEAR('".$enddate."') AS end_year";
	$result_end=mysql_query ($sec);
	$row_end = mysql_fetch_array ($result_end); 
    $day_end=$row_end['end_year'];
   
	$intFirstDay1=$s[0]."-02-01";
	$select_audit="SELECT LAST_DAY('".$intFirstDay1."') AS start_year";
	$result=mysql_query ($select_audit);
	$audit_date1 = mysql_fetch_array ($result); 
	$start_date=explode ("-",$audit_date1['start_year']);
	$startdate=$start_date[2];
    $numbers=(31+31+30+31+30+31+31+30+31+30+31+1)+"$startdate<br>"; 
     $day_start=($numbers-$startyear);
	
     $startdate=$s[2]."-".$s[1]."-".$s[0]; 


if ($_SERVER[REQUEST_METHOD] == "POST"){
if($_POST[action]=="edit2"){
		  if($startdate>$enddate){
				  	echo "
					<script language=\"javascript\">
					alert(\"".msg1."\\n \");
					location.href='?id=$id&action=edit';
					</script>
				    ";
			            }else{
				   if(($startdate<=$begindate)&&($enddate<=$begindate)&&($startdate=="")&&($enddate==""))
				   { 
					 echo "
					<script language=\"javascript\">
					alert(\"�ѹ����ҵ�ͧ�����¡����ѹ����Ѻ�Ҫ���\\n \");
					location.href='?id=$id&action=edit';
					</script>
				     ";
				   }else {
	    $sql = "update  hr_absent  set  education='$day_start',startdate = '$startdate',enddate='$enddate' 
	    where id ='$id' and yy='$start'";
	    mysql_query($sql)or die("�������ö��䢢�������");

		$sql = "update  hr_absent  set  education='$day_end',startdate = '$startdate',enddate='$enddate' 
		where id ='$id' and yy='$end' ";
		mysql_query($sql)or die("�������ö��䢢�������");

		echo "<script language=\"javascript\">
				alert(\"".msgedit."\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
		exit;
			}//�����ѹ��
	    }//�����ѹ���������ش
	} else {
	
		     if($startdate>$enddate){
				  	echo "
					<script language=\"javascript\">
					alert(\"".msg1."\\n \");
					location.href='?id=$id&action=edit';
					</script>
				    ";
			         }else{
				     if(($startdate<=$begindate)&&($enddate<=$begindate)&&($startdate=="")&&($enddate==""))
				    { 
					 echo "
					<script language=\"javascript\">
					alert(\"�ѹ����ҵ�ͧ�����¡����ѹ����Ѻ�Ҫ���\\n \");
					location.href='?id=$id&action=edit';
					</script>
				     ";
				   }else {
					   
    $sqls = "INSERT INTO  hr_absent (id,yy,education,startdate,enddate) VALUES ('$id','$start','$day_start','$startdate','$enddate')";
	$results  = mysql_query($sqls);

	$sqle = "INSERT INTO  hr_absent (id,yy,education,startdate,enddate) VALUES ('$id','$end','$day_end','$startdate','$enddate')";
	$resulte = mysql_query($sqle);	
	
					if($resulte)
					{
					echo "
				<script language=\"javascript\">
				alert(\"".msginsert."\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
				//	header("Location: ?id=$id&action=edit");
					exit;
					}else{	$msg = "�������ö�ѹ�֡�������� ";}
			}
		}//�����ѹ��
	   } //�����ѹ���������ش
}
}*//*else {
// case ��� 3
//--------------------------------------------------------------------------------------------------------

    $startsql="SELECT DAYOFYEAR('".$startdate."') AS start_year";
	$result_start=mysql_query ($startsql);
	$row_start = mysql_fetch_array ($result_start); 
    $startyear=$row_start['start_year'];

    $sec="SELECT DAYOFYEAR('".$enddate."') AS end_year";
	$result_end=mysql_query ($sec);
	$row_end = mysql_fetch_array ($result_end); 
    $day_end=$row_end['end_year'];

	$intFirstDay1=$s[0]."-02-01";
	$select_audit="SELECT LAST_DAY('".$intFirstDay1."') AS start_year";
	$result=mysql_query ($select_audit);
	$audit_date1 = mysql_fetch_array ($result); 
	$start_date=explode ("-",$audit_date1['start_year']);
	$startdate=$start_date[2];
    $numbers=(31+31+30+31+30+31+31+30+31+30+31+1)+"$startdate<br>"; 
    $day_start=($numbers-$startyear);
	$startdate=$s[2]."-".$s[1]."-".$s[0]; 

for($i=($start+1);$i<$end;$i++){
$starttime=strtotime("1  january ".($i-543))."";
$endtime= strtotime("31 december ".($i-543))."";
$count_year=$endtime-$starttime;
$yearc=intval($count_year/86400);

$array_day[$i] = $i; 
if($_POST[action]=="edit2"){
$sql = "update  hr_absent  set  yy='$i',education='$yearc',startdate = '$startdate',enddate='$enddate' 
where id ='$id' and yy='$start' and yy='$end'";
 mysql_query($sql)or die("�������ö��䢢�������");
 }else{
 $sqls = "INSERT INTO  hr_absent (id,yy,education,startdate,enddate) VALUES ('$id','$i','$yearc','$startdate','$enddate')";
 $results  = mysql_query($sqls);	
 if($results)
					{
					echo "
				<script language=\"javascript\">
				alert(\"".msginsert."\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
				//	header("Location: ?id=$id&action=edit");
					exit;
					}else{	$msg = "�������ö�ѹ�֡�������� ";}
 }
 }
 if ($_SERVER[REQUEST_METHOD] == "POST"){
 if($_POST[action]=="edit2"){
     if($startdate>$enddate){
				  	echo "
					<script language=\"javascript\">
					alert(\"".msg1."\\n \");
					location.href='?id=$id&action=edit';
					</script>
				    ";
			            }else{
				    if(($startdate<=$begindate)&&($enddate<=$begindate)&&($startdate=="")&&($enddate==""))
				   { 
					 echo "
					<script language=\"javascript\">
					alert(\"�ѹ����ҵ�ͧ�����¡����ѹ����Ѻ�Ҫ���\\n \");
					location.href='?id=$id&action=edit';
					</script>
				     ";
				   }else {
    $sql = "update  hr_absent  set  education='$day_start',startdate = '$startdate',enddate='$enddate' 
	where id ='$id' and yy='$start'";
	mysql_query($sql)or die("�������ö��䢢�������");

    $sql = "update  hr_absent  set  education='$day_end',startdate = '$startdate',enddate='$enddate' 
	where id ='$id' and yy='$end'";
	mysql_query($sql)or die("�������ö��䢢�������");

		//echo "<meta http-equiv='refresh' content='1;URL=absent.php>";
	echo "<script language=\"javascript\">
				alert(\"".msgedit."\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
	      exit;
				}//�����ѹ��
	   } //�����ѹ���������ش
	} else {
		    if($startdate>$enddate){
				  	echo "
					<script language=\"javascript\">
					alert(\"".msg1."\\n \");
					location.href='?id=$id&action=edit';
					</script>
				    ";
			            }else{
				   if(($startdate<=$begindate)&&($enddate<=$begindate)&&($startdate=="")&&($enddate==""))
				   { 
					 echo "
					<script language=\"javascript\">
					alert(\"�ѹ����ҵ�ͧ�����¡����ѹ����Ѻ�Ҫ���\\n \");
					location.href='?id=$id&action=edit';
					</script>
				     ";
				   }else {
   $sqls = "INSERT INTO  hr_absent (id,yy,education,startdate,enddate) VALUES ('$id','$start','$day_start','$startdate','$enddate')";
   $results  = mysql_query($sqls);	
   $sqle = "INSERT INTO  hr_absent (id,yy,education,startdate,enddate) VALUES ('$id','$end','$day_end','$startdate','$enddate')";
   $resulte = mysql_query($sqle);	
		if($resulte)
					{
					echo "
				<script language=\"javascript\">
				alert(\"".msginsert."\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
				//	header("Location: ?id=$id&action=edit");
					exit;
					}else{	$msg = "�������ö�ѹ�֡�������� ";}
			   }//�����ѹ��
	         } //�����ѹ���������ش
	      }// �ѹ�֡ ���
		} // endpost
		} //������� case �ѹ����������-����ش*/
		} // ������� radio
       else 
       {

       $sqlgen="select  *  from  general   where id='$id'";
	   $relult=mysql_query($sqlgen);
	   while($ros=mysql_fetch_array($relult)){

		   $begindate=$ros['begindate'];
	       }
	   	  
			$day=date("d/m/Y");
			$date=explode("/",$day);
			$date[2]=$date[2]+543;
			$days=$date[2]."-".$date[1]."-".$date[0];

		     $s=explode("/", $_POST['txtstartdate']);
			 $startdate=$s[2]."-".$s[1]."-".$s[0];
		        
			 $e=explode("/", $_POST['txtenddate']);
		     $enddate=$e[2]."-".$e[1]."-".$e[0];
	
				add_log("�����Ũӹǹ�ѹ����ش",$id,$action);
				if ($_SERVER[REQUEST_METHOD] == "POST"){
				if($_POST[action]=="edit2"){
			 
			       if($startdate>$enddate){
				  	echo "
					<script language=\"javascript\">
					alert(\"".msg1."\\n \");
					location.href='?id=$id&action=edit';
					</script>
				    ";
			            }else{
			           if(($startdate>$days)or($enddate>$days)){
				      echo "
				      <script language=\"javascript\">
				       alert(\"".msg2."\\n \");
					   location.href='?id=$id&action=edit';
					   </script>
				       ";
			           }else{
				   	      if(($startdate<=$begindate)&&($enddate<=$begindate)&&($startdate=="")&&($enddate==""))
				   { 
					 echo "
					<script language=\"javascript\">
					alert(\"�ѹ����� ��ͧ�����¡����ѹ����Ѻ�Ҫ���\\n \");
					location.href='?id=$id&action=edit';
					</script>
				     ";
				     }else {
				   if( $sick==""){$sick=0;}
				if($birth==""){$birth=0;}
				if($duty==""){$duty=0;}
				if($vacation==""){$vacation=0;}
				if($late==""){$late=0;}
				if($absent==""){$absent=0;}
				if($etc==""){$etc=0;}
				$label_yy=trim($label_yy);
		$sql = " update  hr_absent set  yy='$yy', sick='$sick' , duty = '$duty' , vacation = '$vacation', late ='$late', absent = '$absent'  , ";
		$sql .= "etc = '$etc',date = '$date' ,date_vacation = '$date_vacation',date_vacation_all ='$date_vacation_all', ";
		$sql .= "birth='$birth', startdate='$startdate', enddate='$enddate' ,other_absent='$other_absent',label_sick='$label_sick',label_birth='$label_birth',label_dv='$label_dv',label_late='$label_late',label_absent='$label_absent',label_etc='$label_etc',label_yy='$label_yy' where id ='$id' and yy ='$yy' ;";
		mysql_query($sql)or die("�������ö��䢢�������");
		//echo "<meta http-equiv='refresh' content='1;URL=absent.php>";
		echo "<script language=\"javascript\">
				alert(\"".msgedit."\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
			   	}//�����ѹ��
	           } //�����ѹ���������ش
			 }

		    exit;
            	} else {
               if($startdate>$enddate){
				  	echo "
					<script language=\"javascript\">
					alert(\"".msg1."\\n \");
					location.href='?id=$id&action=edit';
					</script>
				";
			     }else{
			           if(($startdate>$days)or($enddate>$days)){
				 echo "
				 <script language=\"javascript\">
					alert(\"".msg2."\\n \");
					location.href='?id=$id&action=edit';
					</script>
				   ";
			     }else{

				    if(($startdate<=$begindate)&&($enddate<=$begindate)&&($startdate=="")&&($enddate==""))
				   { 
					 echo "
					<script language=\"javascript\">
					alert(\"�ѹ����ҵ�ͧ�����¡����ѹ����Ѻ�Ҫ���\\n \");
					location.href='?id=$id&action=edit';
					</script>
				     ";
				   }else {
                    if( $sick==""){$sick=0;}
				if($birth==""){$birth=0;}
				if($duty==""){$duty=0;}
				if($vacation==""){$vacation=0;}
				if($late==""){$late=0;}
				if($absent==""){$absent=0;}
				if($etc==""){$etc=0;}
				$label_yy=trim($label_yy);
					 $sql = "INSERT INTO  hr_absent (id,yy,sick,duty,vacation,late,absent,etc,date_vacation,date_vacation_all,birth,startdate, enddate,other_absent,label_sick,label_birth,label_dv,label_late,label_absent,label_etc,label_yy) VALUES ('$id','$yy','$sick','$duty','$vacation','$late','$absent','$etc','$date_vacation','$date_vacation_all','$birth','$startdate','$enddate','$other_absent','$label_sick','$label_birth','$label_dv','$label_late','$label_absent','$label_etc','$label_yy')";
                      $result  = mysql_query($sql);	
				  
				    	}//�����ѹ��
	                  } //�����ѹ���������ش
                     }
					if($result)
					{
					echo "
				<script language=\"javascript\">
				alert(\"".msginsert."\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";	
				//		header("Location: ?id=$id&action=edit");
						exit;
					}else
					{	$msg = "�������ö�ѹ�֡�������� ";}
	                 }
                     }else if ($_GET[action] == 'delete')
	                {
		          add_log("�����Ũӹǹ�ѹ����ش",$id,$action);
	            	mysql_query("delete from hr_absent where id = $id and yy='$yy';");
		           if (mysql_errno())
			{
			$msg = "�������öź��������";
			}else
			{
		    echo"<meta http-equiv='refresh' content='0;URL=absent.php'>";
			header("Location: ?id=$id&action=edit");
						/*echo "<script language=\"javascript\">
							location.href='?id=$id&action=edit';
							</script>";*/
			exit;
			}
			}//
			} // ������� radio

	 	$sql = "select * from  general where id='$id'  ;";
		$result = mysql_query($sql);
		if ($result){
			$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		} else {
			$msg = "��辺�����ŷ���ҹ�к�";
		}
?>
<html>
<head>
<title>�ӹǹ�ѹ����ش�Ҫ��� �Ҵ�Ҫ��� �����</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style5 {color: #000000}
-->
</style>
<!-- send id to menu flash -->
<script language="javascript">
function onSelect(val, divid){
	if(val == 0){
 		document.getElementById('Posdate').style.display	= 'none';  
		document.getElementById('Posyear').style.display	= 'block'; 
	} else {
 		document.getElementById("Posdate").style.display	= 'block';  
		document.getElementById("Posyear").style.display	= 'none'; 
	}
    } 

	function check ()    {
		var errMsg='';
		if (document.post.txtstartdate.value==""){  errMsg+="��س����͡�ѹ�������\n";  
		    document.post.txtstartdate.focus();
		}
		else if(document.post.txtenddate.value=="") { errMsg+="��س����͡�ѹ����ش\n";
		  document.post.txtenddate.focus() ;
		    }
		if (errMsg!='') {
			alert(errMsg);
			return false;
		} else {
		   return true;
		} 
	}
</script>
</head>
<body bgcolor="#A3B2CC">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr align="left" valign="top"><td><br>
&nbsp;
<?
if($dis_menu){
?>
<a href="kp7_absent.php?id=<?=$id?>" title="��Ǩ�ͺ������ ��.7">&nbsp;<img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" ><span class="style5"> ��Ǩ�ͺ�͡��â����� �.�.7 ����硷�͹ԡ�� </span></a>
<?
}else{
?>
	<a href="absent.php?id=<?=$id?>&action=view" class="pp" title="��䢢�������ǹ�ؤ��"><img src="images/edit.png" width="16" height="16" align="absmiddle" border=""><span class="style5">����/ź/��� ������</span></a>&nbsp;&nbsp;<a href="kp7_absent.php?id=<?=$id?>" title="��Ǩ�ͺ������ ��.7">&nbsp;<img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" ><span class="style5"> ��Ǩ�ͺ�͡��â����� �.�.7 ����硷�͹ԡ�� </span></a>
<?
}
?>
	<br>
    <br>
    <table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
<tr align="left" valign="top" > 
	<td><b>���� / ʡ��&nbsp;<u>
	  <?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]?>
	</u></b> </td>
</tr>
<tr align="left" valign="top" >
  <td align="left">&nbsp;</td>
</tr>
<tr align="left" valign="top" >
  <td align="left"><b>�. �ӹǹ�ѹ����ش�Ҫ��� �Ҵ�Ҫ��� ����� </b></td>
</tr>
</table>
<br>
<table width="98%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
<tr bgcolor="#999999" align="center" style="font-weight:bold;"> 
	<td width="12%" bgcolor="#A3B2CC">�.�.</td>
	<td width="17%" bgcolor="#A3B2CC">�һ���</td>
	<td width="20%" bgcolor="#A3B2CC">�ҡԨ����Ҿѡ��͹</td>
	<td width="17%" bgcolor="#A3B2CC">�����</td>
	<td width="17%" bgcolor="#A3B2CC">�Ҵ�Ҫ���</td>
	<td width="17%" bgcolor="#A3B2CC">���֡�ҵ��</td>

   </tr>
    <?
     //$sqls="select   substring(startdate,1,4) as startdate ,substring(enddate,1,4) as enddate  from  hr_absent  where id='$id'";
    $sqls="select   *    from  hr_absent  where id='$id'";
    $rey=mysql_query($sqls);
    $i	= 0;
    while($rs=mysql_fetch_array($rey)){
	$i++;
	$bg = ($i % 2) ? "#FFFFFF" : "#F0F0F0" ;
	if($rs[other_absent] !="")
	{
	$other=$rs[other_absent];	
	}
	else 
	{
		$other=$rs[education];	
	}
    ?>
	<?
			if($rs[label_yy] !=""){//��Ǩ�ͺ����ʴ���㹪�ͧ ��
			$str_yy=$rs[label_yy];
			}else{
			$str_yy=$rs[yy];
			}
			//---------------------
			if($rs[label_sick] !=""){// ��Ǩ�ͺ����ʴ���㹪�ͧ ����
			$str_sick=$rs[label_sick];
			}else{
			$str_sick=$rs[sick];
			}
			//---------------
			if($rs[label_dv] !=""){//��Ǩ�ͺ����ʴ��� �Ҿ����
			$str_duty=$rs[label_dv];
			}else{
			$str_duty=$rs[duty]+$rs[vacation];
			}
			//----------------
			if($rs[label_late] !=""){// ��Ǩ�ͺ����ʴ��� ��������
			$str_late=$rs[label_late];
			}else{
			$str_late=$rs[late];
			}
			//-----------------
			if($rs[label_absent] !=""){
			$str_absent=$rs[label_absent];
			}else{
			$str_absent=$rs[absent];
			}
			
			//--------------------
			if($rs[label_education] != ""){
			$arr_str1=$rs[label_education];
			}else if($rs[other_absent] !=""){
			$arr_str1=$rs[other_absent];
			}else if($rs[label_birth] !=""){
			$arr_str1 = $rs[label_birth];
			}else if($rs[etc] !=0){
			$tem_etc="�Ҿ���� ".$rs[etc]." �ѹ";
			$arr_str1=$tem_etc;
			}else if($rs[birth] !=0){
			$tem_birth="�Ҥ�ʹ ".$rs[birth]." �ѹ";
			$arr_str1=$tem_birth;
			}else if($rs[education] >= 365){
			$arr_str1="���֡�ҵ��";
			}else if($rs[education] < 365){
			$arr_str1=$rs[education];
			}
			else{
			$arr_str1="0";
			}
	if ($rs[merge_col]==1){?><tr align="left" bgcolor="<?=$bg?>"> 
	<td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	  <?=$rs[special_exp]?></td>
	</tr><? }else{?>
   <tr align="center" bgcolor="<?=$bg?>"> 
	<td><? echo $str_yy; ?></td>
	<td><? echo $str_sick; ?></td>
	<td><? echo $str_duty; ?></td>
	<td><? echo $str_late; ?></td>
	<td><? echo $str_absent;?></td>
	<td><? echo $arr_str1;?></td>
</tr>
<? }
}
//} 
mysql_free_result($result);
?>
</table>

	</td>
</tr>
</table>      
    </td>
</tr>
</table><br>
<br>

<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>