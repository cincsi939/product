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
$time_start = getmicrotime();
$mmeng = array("","january","february","march","april","may","june","july","august","september","october","november","december");
 $ch_yea=$_POST[ch_year];

if($ch_yea==1) {
	
		$sqlgen="select  *  from  general   where id='$id'";
		   $relult=mysql_query($sqlgen);
		   while($ros=mysql_fetch_array($relult)){
			   $begindate=$ros['begindate'];
		   } // จบwhile

//	$s=explode("/", $_POST['txtstartdate']);
  $startdate=$y_start_edu."-".$m_start_edu."-".$d_start_edu;    
	//$e=explode("/", $_POST['txtenddate']);
   $enddate=$y_end_edu."-".$m_end_edu."-".$d_end_edu;
   $startedu=($y_start_edu-543)."-".$m_start_edu."-".$d_start_edu; 
   $endedu=($y_end_edu-543)."-".$m_end_edu."-".$d_end_edu;

    $start=$y_start_edu;
	$end=$y_end_edu;
	$yeardif=$end-$start;
//----------------------------------------------------------------------------------------------------------------
//case ที่ 1
	if($yeardif==0){
			//	$start_diff_day =strtotime(intval($s[0])." ".$mmeng[intval($s[1])]." ".($s[2]-543));
				$start_diff_day =strtotime(intval($d_start_edu)." ".$mmeng[intval($m_start_edu)]." ".($y_start_edu-543));
				//$end_diff_day =strtotime(intval($e[0])." ".$mmeng[intval($e[1])]." ".($e[2]-543));
				$end_diff_day =strtotime(intval($d_end_edu)." ".$mmeng[intval($m_end_edu)]." ".($y_end_edu-543));
				$timediff =$end_diff_day-$start_diff_day;
				$education=intval($timediff/86400);
				
				
	if ($_SERVER[REQUEST_METHOD] == "POST"){
	
				if($action=="edit2"){
				
			$sql = "update  hr_absent  set  education='$education',startdate ='$startdate',enddate='$enddate' 
			where id ='$id' and yy='$start' ";
			
		$returnid = add_monitor_logbefore("hr_absent","");
		mysql_query($sql)or die("ไม่สามารถแก้ไขข้อมูลได้");
		add_monitor_logafter("hr_absent"," id ='$id' and yy='$start' ",$returnid);
			
			//	mysql_query($sql)or die("ไม่สามารถแก้ไขข้อมูลได้");
				//echo "<meta http-equiv='refresh' content='1;URL=absent.php>";
				echo "<script language=\"javascript\">
						alert(\"".msgedit."\\n \");
						</script>
						";
				 echo"<meta http-equiv='refresh' content='0;URL=absent.php?action=view'>";			
		         exit;
	               }
	 if($action=="add"){ 
		     if($startdate>$enddate){
				  	echo "
					<script language=\"javascript\">
					alert(\"".msg1."\\n \");
					location.href='?id=$id&action=edit';
					</script>
				    ";
			       }else{
			      if(($startdate<=$begindate)&&($enddate<=$begindate)&&($startdate=="")&&($enddate=="")){ 
				 echo "<script language=\"javascript\">alert(\"วันที่ลาต้องไม่น้อยกว่าวันที่รับราชการ\\n \");location.href='?id=$id&action=edit';</script>";
				   }else {
				 $sql = "INSERT INTO  hr_absent (id,yy,education,startdate,enddate) VALUES ('$id','$start','$education','$startdate','$enddate')";
				 
				 $returnid = add_monitor_logbefore("hr_absent","");
				 $result  = mysql_query($sql);	
				add_monitor_logafter("hr_absent"," id ='$id' and yy ='$start' ",$returnid);	
				
							if($result){
								echo "<script language=\"javascript\">alert(\"".msginsert."\\n \");	</script>	";
								  echo"<meta http-equiv='refresh' content='0;URL=absent.php?action=view'>";			
								exit;
							}else{	$msg = "ไม่สามารถบันทึกข้อมูลได้ ";}
			}//จบเช็ควันลา
	      }//จบเช็ควันเริ่มสิ้นสุด
	   }
    }
//-----------------------------------------------------------------------------------------------------------------------
//case ที่ 2
     } else {
		$sql_12="SELECT DATEDIFF('$endedu 23:59:59','$startedu') as sw";
		//$sql_12="SELECT DATEDIFF ('$endedu','$startedu') AS e";
		$query_edu=mysql_query($sql_12)or die ("ERRRRRR".__LINE__.mysql_error());
		$ab_edu=mysql_fetch_assoc($query_edu);
		$education=$ab_edu[sw];
	
	if ($_SERVER[REQUEST_METHOD] == "POST"){
		if($action=="edit2"){			 
			$sql = "update  hr_absent  set  education='$education',startdate = '$startdate',enddate='$enddate',label_education='$label_education'
			where id ='$id' and yy='$start' ";
				
				$returnid = add_monitor_logbefore("hr_absent"," id ='$id' and yy='$start' ");
				mysql_query($sql)or die("ไม่สามารถแก้ไขข้อมูลได้");
				add_monitor_logafter("hr_absent"," id ='$id' and yy ='$start' ",$returnid);	
				
				echo "<script language=\"javascript\">alert(\"".msgedit."\\n \");</script>";
				 echo"<meta http-equiv='refresh' content='0;URL=absent.php?action=view'>";	
		  	   exit;
	        } 
		if($action=="add") { 
		     if($startdate>$enddate){
				  	echo "
					<script language=\"javascript\">
					alert(\"".msg1."\\n \");
					location.href='?id=$id&action=edit';
					</script>
				    ";
			       }else{
			  		    if(($startdate<=$begindate)&&($enddate<=$begindate)&&($startdate=="")&&($enddate=="")){ 
						 echo "<script language=\"javascript\">alert(\"วันที่ลาต้องไม่น้อยกว่าวันที่รับราชการ\\n \");</script>";
					 	 echo"<meta http-equiv='refresh' content='0;URL=absent.php?action=view'>";	
				 		  }else {
						 $sql = "INSERT INTO  hr_absent (id,yy,education,startdate,enddate,label_education) VALUES ('$id','$start','$education','$startdate
						 ','$enddate','$label_education')";
						 
							$returnid = add_monitor_logbefore("hr_absent","");
							 $result  = mysql_query($sql);		
							add_monitor_logafter("hr_absent"," id ='$id' and yy ='$start' ",$returnid);	

						 
						
							if($result){
									echo "<script language=\"javascript\">alert(\"".msginsert."\\n \");</script>";
								  	echo"<meta http-equiv='refresh' content='0;URL=absent.php?action=view'>";			
									exit;
							}else{	$msg = "ไม่สามารถบันทึกข้อมูลได้ ";}
			}//จบเช็ควันลา
	      }//จบเช็ควันเริ่มสิ้นสุด
	   }
    }
		
}///////////////////////////////////////////

		} // จบการเช็ค radio
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
		  //   $s=explode("/", $_POST['txtstartdate']);
	/*	  if($y_start_edu==""){
		  $y_start_edu="00";
		  }else{
		  $
		  }
		  */
			 $startdate=$y_start_edu."-".$m_start_edu."-".$d_start_edu;
//			 $e=explode("/", $_POST['txtenddate']);
			  $enddate=$y_end_edu."-".$m_end_edu."-".$d_end_edu;
			 
		
				//$startedu=($s[2]-543)."-".$s[1]."-".$s[0]; 
					$startedu=($y_start_edu-543)."-".$m_start_edu."-".$d_start_edu; 
   					//$endedu=($e[2]-543)."-".$e[1]."-".$e[0];
					$endedu=($y_end_edu-543)."-".$m_end_edu."-".$d_end_edu;
						 $start=$y_start_edu;
						$end=$y_end_edu;
						$yeardif=$end-$start;

			//	$start_diff_day =strtotime(intval($s[0])." ".$mmeng[intval($s[1])]." ".($s[2]-543));
				$start_diff_day =strtotime(intval($d_start_edu)." ".$mmeng[intval($m_start_edu)]." ".($y_start_edu-543));
				//$end_diff_day =strtotime(intval($e[0])." ".$mmeng[intval($e[1])]." ".($e[2]-543));
				$end_diff_day =strtotime(intval($d_end_edu)." ".$mmeng[intval($m_end_edu)]." ".($y_end_edu-543));
				$timediff =$end_diff_day-$start_diff_day;
				$education=intval($timediff/86400);
				
	add_log("ข้อมูลจำนวนวันลาหยุด",$id,$action);
	if ($_SERVER[REQUEST_METHOD] == "POST"){
		if($_POST[action]=="edit2"){

			       if($startdate>$enddate){echo "<script language=\"javascript\">alert(\"".msg1."\\n \");location.href='?id=$id&action=edit';</script> ";
			            }else{
			         	  if(($startdate>$days)or($enddate>$days)){
				      echo " <script language=\"javascript\">alert(\"".msg2."\\n \"); location.href='?id=$id&action=edit';</script> ";
			           }else{
				   	      if(($startdate<=$begindate)&&($enddate<=$begindate)&&($startdate=="")&&($enddate==""))
				 	  {  
					 echo "<script language=\"javascript\">alert(\"วันที่ลา ต้องไม่น้อยกว่าวันที่รับราชการ\\n \");location.href='?id=$id&action=edit';</script>";
				     }else {
				   if( $sick==""){$sick=0;}
					if($birth==""){$birth=0;}
					if($duty==""){$duty=0;}
					if($vacation==""){$vacation=0;}
					if($late==""){$late=0;}
					if($absent==""){$absent=0;}
					if($etc==""){$etc=0;}
					$label_yy=trim($label_yy);
					if($special_exp !=""){$merge_col=1;}else{$merge_col="";}
		$sql = " update  hr_absent set  yy='$yy', sick='$sick' , duty = '$duty' , vacation = '$vacation', late ='$late', absent = '$absent'  , ";
		$sql .= "etc = '$etc',date = '$date' ,date_vacation = '$date_vacation',date_vacation_all ='$date_vacation_all', ";
		$sql .= "birth='$birth', startdate='$startdate', enddate='$enddate' ,other_absent='',label_sick='$label_sick',label_birth='$label_birth',label_dv='$label_dv',label_late='$label_late',label_absent='$label_absent',label_etc='$label_etc',label_yy='$label_yy',education='$education',label_education='$label_education2',special_exp='$special_exp',merge_col='$merge_col' where id ='$id' and yy ='$yy' ;";
		
		$returnid = add_monitor_logbefore("hr_absent"," id ='$id' and yy ='$yy' ");
		mysql_query($sql)or die("ไม่สามารถแก้ไขข้อมูลได้");
		add_monitor_logafter("hr_absent"," id ='$id' and yy ='$yy' ",$returnid);
		
		
		echo "<script language=\"javascript\">
				alert(\"".msgedit."\\n \");
				</script>
				";
				echo"<meta http-equiv='refresh' content='0;URL=absent.php?action=view'>";			
			   	}//จบเช็ควันลา
	           } //จบเช็ควันเริ่มสิ้นสุด
			 }

		    exit;
            	} else {
               		if($startdate>$enddate){
				  	echo "<script language=\"javascript\">alert(\"".msg1."\\n \");location.href='?id=$id&action=edit';</script>";
			  	   }else{
			       		 if(($startdate>$days)or($enddate>$days)){
				 echo "<script language=\"javascript\">alert(\"".msg2."\\n \");location.href='?id=$id&action=edit';</script>";
			   			  }else{

				  				  if(($startdate<=$begindate)&&($enddate<=$begindate)&&($startdate=="")&&($enddate==""))
						 			  { 
									 echo "<script language=\"javascript\">alert(\"วันที่ลาต้องไม่น้อยกว่าวันที่รับราชการ\\n \");location.href='?id=$id&action=edit';</script>";
									   }else {
									if( $sick==""){$sick=0;}
									if($birth==""){$birth=0;}
									if($duty==""){$duty=0;}
									if($vacation==""){$vacation=0;}
									if($late==""){$late=0;}
									if($absent==""){$absent=0;}
									if($etc==""){$etc=0;}
									$label_yy=trim($label_yy);
										if($special_exp !=""){$merge_col=1;}else{$merge_col="";}
					 $sql = "INSERT INTO  hr_absent (id,yy,sick,duty,vacation,late,absent,etc,date_vacation,date_vacation_all,birth,startdate, enddate,other_absent,label_sick,label_birth,label_dv,label_late,label_absent,label_etc,label_yy,education,label_education,special_exp,merge_col) VALUES ('$id','$yy','$sick','$duty','$vacation','$late','$absent','$etc','$date_vacation','$date_vacation_all','$birth','$startdate','$enddate','$other_absent','$label_sick','$label_birth','$label_dv','$label_late','$label_absent','$label_etc','$label_yy','$education','$label_education','$special_exp','$merge_col')";
                    
					 
					  
					$returnid = add_monitor_logbefore("hr_absent","");
					 $result  = mysql_query($sql);	
					add_monitor_logafter("hr_absent"," id ='$id' and yy ='$yy' ",$returnid);

					  
				    	}//จบเช็ควันลา
	                  } //จบเช็ควันเริ่มสิ้นสุด
                     }
					if($result)
					{
					echo "
				<script language=\"javascript\">
				alert(\"".msginsert."\\n \");
				</script>
				";	
			echo"<meta http-equiv='refresh' content='0;URL=absent.php?action=view'>";			
						exit;
					}else{	$msg = "ไม่สามารถบันทึกข้อมูลได้ ";}
	                 }
                     }else if ($_GET[action] == 'delete')
	                {
		          add_log("ข้อมูลจำนวนวันลาหยุด",$id,$action);
	            	mysql_query("delete from hr_absent where id = $id and yy='$yy';");
		           if (mysql_errno())
			{
			$msg = "ไม่สามารถลบข้อมูลได้";
			}else
			{
		    echo"<meta http-equiv='refresh' content='0;URL=absent.php?action=view'>";			
			exit;
			}
			}//
			} // จบการเช็ค radio

	 	$sql = "select * from  general where id='$id'  ;";
		$result = mysql_query($sql);
		if ($result){
			$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		} else {
			$msg = "ไม่พบข้อมูลที่ท่านระบุ";
		}
?>
<html>
<head>
<title>จำนวนวันลาหยุดราชการ ขาดราชการ มาสาย</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script type="text/javascript" src="../../../common/calendar_list.js"></script>
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style1 {color: #FF0000}
.style5 {color: #000000}
.style6 {color: #8C0000}
-->
</style>
<!-- send id to menu flash -->
<script language="javascript">
addnone=1;
displaymonth='i';
function onSelect(val, divid){
	if(val == 0){
 		document.getElementById('Posdate').style.display	= 'none';  
		document.getElementById('Posyear').style.display	= 'block'; 
	} else {
 		document.getElementById("Posdate").style.display	= 'block';  
		document.getElementById("Posyear").style.display	= 'none'; 
	}
    } 

/*	function check ()    {
		var errMsg='';
		if (document.post.txtstartdate.value==""){  errMsg+="กรุณาเลือกวันเริ่มต้น\n";  
		    document.post.txtstartdate.focus();
		}
		else if(document.post.txtenddate.value=="") { errMsg+="กรุณาเลือกวันสิ้นสุด\n";
		  document.post.txtenddate.focus() ;
		    }
		if (errMsg!='') {
			alert(errMsg);
			return false;
		} else {
		   return true;
		} 
	}
*/</script>
</head>
<body bgcolor="#A3B2CC">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr> 
 <td height="30"><a href="kp7_absent.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7">&nbsp;<img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" ><span class="style5"> ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></a></td>
 <td width="50" height="30"></td>
 </tr>
</table>
<?
if ($msg){
?>
<CENTER>
<h2><FONT COLOR="red"><?=$msg?></FONT></h2>
<input type=button value=" ย้อนกลับ " onClick="history.back();">
</CENTER>
<?
	exit;
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr align="left" valign="top"> 
	<td>    
<table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
<tr align="left" valign="top" > 
	<td><b>ชื่อ / สกุล&nbsp;<u>
	  <?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]?>
	</u></b> </td>
</tr>
<tr align="left" valign="top" >
  <td align="left">&nbsp;</td>
</tr>
<tr align="left" valign="top" >
  <td align="left"><b> ๔. จำนวนวันลาหยุดราชการ ขาดราชการ มาสาย</b> </td>
</tr>
</table>
<br>
<?
if($action=="view"){
?>
<table width="98%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
<tr bgcolor="#999999" align="center" style="font-weight:bold;"> 
	<td width="6%" bgcolor="#A3B2CC">พ.ศ.</td>
	<td width="7%" bgcolor="#A3B2CC">ลาป่วย</td>
	<td width="9%" bgcolor="#A3B2CC">ลาคลอด</td>
	<td width="9%" bgcolor="#A3B2CC">ลากิจ</td>
	<td width="10%" bgcolor="#A3B2CC">ลาพักผ่อน</td>
	<td width="11%" bgcolor="#A3B2CC">มาสาย</td>
	<td width="10%" bgcolor="#A3B2CC">ขาดราชการ</td>
	<td width="10%" bgcolor="#A3B2CC">ลาพิเศษ</td>
	<td width="10%" bgcolor="#A3B2CC">ลาศึกษาต่อวัน</td>
	<td width="10%" bgcolor="#A3B2CC">รวมวันลา</td>
	<td width="8%" bgcolor="#A3B2CC"><input type="button" name="add" value="เพิ่มข้อมูล" onClick="location.href='absent.php?id=<?=$id?>&action=add' "></td>
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
   	if($rs[merge_col]==1)
	{
    ?>   <tr align="left" bgcolor="<?=$bg?>"> 
	<td colspan="10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	  <?=$rs[special_exp]?></td>
	<td align="center"><a href="?id=<?=$rs[id]?>&yy=<?=$rs[yy]?>&ch_year=<?=$ch_yea?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> 
<a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>&yy=<?=$rs[yy]?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>	</td>
</tr><? }else {?>
   <tr align="center" bgcolor="<?=$bg?>"> 
	<td><?=$rs[yy];?></td>
	<td><?=$rs[sick];?></td>
	<td><?=$rs[birth]?></td>
	<td><?=$rs[duty];?>  </td>
	<td><?=$rs[vacation];?></td>
	<td><?=$rs[late];?></td>
	<td><?=$rs[absent];?></td>
	<td><?=$rs[etc];?></td>
	<td><?=$rs[education];?></td>
	<td><? echo  $total=$rs[late]+$rs[sick]+$rs[duty]+$rs[vacation]+$rs[absent]+$rs[etc]+$rs[birth]+$rs[education];?></td>
	<td><a href="?id=<?=$rs[id]?>&yy=<?=$rs[yy]?>&ch_year=<?=$ch_yea?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> 
<a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>&yy=<?=$rs[yy]?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>	</td>
</tr>

<?
}
}
//} 
mysql_free_result($result);
?>
<tr  bgcolor="<?=$bg?>"><td colspan="11" align="center"><input type="button" name="Button" value="กลับหน้าแรก" onClick="location.href='absent_all_1.php?'"></td>
</tr>
</table>
<br>
<br>

<?
}
if($action=="edit2")
{
	$sql 		= "select * from hr_absent where id='$id' and yy = '$yy'   ;";
	$result 	= mysql_query($sql);
	$rs		= mysql_fetch_assoc($result);

?>
<form method="post" name="post"  action="<?=$PHP_SELF?>" >
<input type="hidden" name="day" value="<?=$days?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="yy" value="<?=$array_day?>">
<input type="hidden" name="action" value="edit2">&nbsp;&nbsp;
<!--เลือกปี&nbsp;<input name="ch_year" type="radio" value="0" checked  onClick="onSelect('0','Posdate');">ลาอื่น ๆ<input name="ch_year" type="radio" value="1"   onClick="onSelect('1','Posyear');">
ลาศึกษาต่อ
--><input type="hidden" name="ch_year" value="0">

<!--<div id='Posyear' style="display:block;">	
--><table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
<tr>
  <td align="right" valign="top">&nbsp;</td>
  <td align="left" valign="top">&nbsp;ส่วนแสดงรายการข้อมูล&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td align="center" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ส่วนแสดงใน ก.พ7. </td>
  <td width="333" align="left" valign="top">&nbsp;</td>
</tr>
<tr>
  <td align="right" valign="top">&nbsp;</td>
  <td align="left" valign="top">&nbsp;</td>
  <td colspan="2" align="left" valign="top"><span class="style6">หากท่านบันทึกในชองแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
  </tr>

<tr>
  <td align="right" valign="top">&nbsp;</td>
  <td align="left" valign="top">&nbsp;</td>
  <td align="right" valign="top" bgcolor="#A3B2CC">&nbsp;</td>
  <td align="left" valign="top">&nbsp;</td>
</tr>
<tr> 
<td align="right" valign="top" width="213">
   <B>พ.ศ.</B>&nbsp;&nbsp;</td> 
<td width="142" align="left" valign="top"> 

<select name="yy" >
<?
$thisyear = date("Y") + 543;
$sq="select   yy    from  hr_absent  where id='$id' ";
$re=mysql_query($sq);
while($r=mysql_fetch_array($re)){
 $arr_insertedyy[$r[yy]] = $r[yy] ; 
}
for ($i=$thisyear;$i>=2470;$i--){
	if (( $arr_insertedyy[$i]  != "" )and  ($action !="edit2")){ continue ; } 
	if ($rs[yy] == $i){ 
		echo "<option selected>$i</option>";   
	} else{ 
		echo "<option>$i</option>";
	} # END if ($rs[yy] == $i){ 
} # end for 	($i=$thisyear;$i>=2470;$i--){

?>
</select></td>
<td width="254" align="right" valign="top" bgcolor="#A3B2CC">พ.ศ.&nbsp;
  <input name="label_yy" type="text" value="<?=$rs[label_yy]?>" size="20" maxlength="50">
  <br></td>
<td align="left" valign="top"><span class="style6">ในกรณีช่อง พ.ศ.มีมากกว่า 1 บรรทัด<br>
  ให้ใส่
  เครื่องหมาย<strong> , </strong>คั่น เช่น 23 ก.พ. 50<strong>,</strong>1 ต.ค. 51</span></td>
</tr>
<tr align="left" style="font-weight:bold;"> 
	<td align="right" >ลาป่วย&nbsp;&nbsp;</td>
	<td><input type="text" name="sick" size="10" value="<? if($rs[sick]==0){}else{echo $rs[sick];}?>" maxlength="4">&nbsp;&nbsp;วัน
	&nbsp;</td>
    <td align="right">ลาป่วย&nbsp;
      <input name="label_sick" type="text" value="<?=$rs[label_sick]?>" size="20" maxlength="50"></td>
    <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;"> 
	<td align="right" bgcolor="#A3B2CC">ลากิจ&nbsp;&nbsp;</td>
	<td><input type="text" name="duty" size="10" value="<? if($rs[duty]==0){}else{echo $rs[duty];}?>" maxlength="4">&nbsp;&nbsp;วัน</td>
    <td rowspan="2" align="right">ลากิจและพักผ่อน&nbsp;
      <input name="label_dv" type="text" value="<?=$rs[label_dv]?>" size="20" maxlength="50"></td>
    <td rowspan="2" bgcolor="#A3B2CC">&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;"> 
	<td align="right" bgcolor="#A3B2CC">พักผ่อน&nbsp;&nbsp;</td>
	<td><input type="text" name="vacation" size="10" value="<? if($rs[vacation]==0){}else{ echo $rs[vacation];}?>" maxlength="4">&nbsp;&nbsp;วัน</td>
    </tr>				
<tr align="left" style="font-weight:bold;"> 
	<td align="right">มาสาย&nbsp;&nbsp;</td>
	<td><input name="late" type="text" id="late" value="<? if($rs[late]==0){}else{echo $rs[late]; }?>" size="10" maxlength="4">&nbsp;&nbsp;วัน</td>
    <td align="right">มาสาย&nbsp;
      <input name="label_late" type="text" value="<?=$rs[label_late]?>" size="20" maxlength="50"></td>
    <td valign="top">&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;"> 
	<td align="right">ขาดราชการ&nbsp;&nbsp;</td>
	<td><input type="text" name="absent" size="10" value="<? if($rs[absent]==0){}else{echo $rs[absent]; }?>" maxlength="4">&nbsp;&nbsp;วัน</td>
    <td align="right">ขาดราชการ&nbsp;
      <input name="label_absent" type="text" value="<?=$rs[label_absent]?>" size="20"></td>
    <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
  <td align="right">ลาคลอด&nbsp;&nbsp;</td>
  <td><input name="birth" type="text" value="<? if($rs[birth]==0){echo $rs[birth];}else {echo $rs[birth]; }?>" size="10" maxlength="4">
    &nbsp;&nbsp;วัน</td>
  <td align="right">
    <input name="label_birth" type="hidden" value="<?//=$rs[label_birth]?>" size="20" maxlength="50"></td>
  <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
	<td align="right">ลาพิเศษ ( ลาประกอบพิธีกรรมทางศาสนา )&nbsp;&nbsp;</td>
	<td><input name="etc" type="text" id="etc" value="<? if($rs[etc]==0){}else{echo $rs[etc];}?>" size="10" maxlength="4">&nbsp;&nbsp;วัน
	 <input name="label_etc" type="hidden" value="<?=$rs[label_etc]?>" size="20" maxlength="50">	</td>
    <td align="right">ลาศึกษาต่อ
      <input name="label_education2" type="text" value="<?=$rs[label_education]."". $rs[other_absent];?>" size="20"  width="20">
      <input name="other_absent" type="hidden"  value="<?//=$rs[other_absent]?>" size="20">   </td>
    <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
  <td align="right">&nbsp;</td>
  <td colspan="2" align="center">กรณีออกราชการแล้วกลับเข้ารับราชการใหม่</td>
  <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
  <td align="right">&nbsp;</td>
  <td colspan="2" align="center"><input name="special_exp" type="text" value="<?=$rs[special_exp];?>" size="50"></td>
  <td>&nbsp;</td>
</tr>

<tr align="left" style="font-weight:bold;">
  <td align="right"> </td>
  <td colspan="3">      </td>
  </tr>
</table>
<!--</div>
<div id='Posdate' style="display:none;">	
--><table align="center">
<?

$s=explode("-",$rs['startdate']);
$y_start= trim($s[0]);
$m_start=trim($s[1]);
$d_start=trim($s[2]);
//$startdate= trim($s[2]) ."/". trim($s[1]) ."/".$s[0];

$e=explode("-",$rs['enddate']);
$y_end= trim($e[0]);
$m_end=trim($e[1]);
$d_end=trim($e[2]);
//$enddate=$e[2]."/".$e[1]."/".$e[0];

?>
  <tr align="left" style="font-weight:bold;">
    <td colspan="3">&nbsp;</td>
    </tr>
  <tr align="left" style="font-weight:bold;">
    <td colspan="2" align="left">ลาศึกษาต่อ </td>
    <td width="438">&nbsp;</td>
  </tr>
  <tr align="left" style="font-weight:bold;">
    <td colspan="3" align="right"><span class="style6">**หากต้องการให้ช่องลาศึกษาต่อแสดงวันลาศึกษาเป็น &quot;ลาศึกษาต่อ&quot; ในเอกสาร ก.พ.7 ให้เลือก 1- 01- xxxx - 31-12- xxxx </span></td>
    </tr>
  <tr align="left" style="font-weight:bold;">
    <td width="14" align="right">&nbsp;</td>
    <td width="156" align="right">วัน เดือน ปี เริ่มต้น&nbsp;&nbsp; </td>
    <td> วันที่
      <select name="d_start_edu" id="d_start_edu" onChange="check_date('d_start_edu','m_start_edu','y_start_edu');"> </select>
	 
          <? /*<option value="">ไม่ระบุ</option>
for ($i=1;$i<=31;$i++){
	if($d_start==sprintf("%02d",$i)){
	echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option value=\"".sprintf("%02d",$i)."\" >" .  sprintf("%02d",$i) . "</option>";
	}
}*/
?>
       
      เดือน
  <select name="m_start_edu" id="m_start_edu" onChange="check_date('d_start_edu','m_start_edu','y_start_edu');"></select>
  
    <? /*<option value="">ไม่ระบุ</option>
for ($i=1;$i<=12;$i++){
		if($m_start==sprintf("%02d",$i)){
		echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
		}else{
		echo "<option value=\"".sprintf("%02d",$i)."\">" .  sprintf("%02d",$i) . "</option>";
		}
	}*/
?>
  
      ปี
  <select name="y_start_edu"  id="y_start_edu" onChange="check_date('d_start_edu','m_start_edu','y_start_edu');" ></select>
  
    <? /*<option value="">ไม่ระบุ</option>
$thisyear = date("Y") + 543;
$y1 = $thisyear - 80;
$y2 = $thisyear ;
					
for ($i=$y2;$i>=$y1;$i--){
	if($y_start==$i){
		echo "<option  value=\"".$i."\" SELECTED>$i</option>";

	}else{
		echo "<option  value=\"".$i."\">$i</option>";
	}
}
*/
	// $diff  = dateLength($rs[begindate]);

?>
 <script>
	create_calendar('d_start_edu','m_start_edu','y_start_edu','<?=$d_start?>','<?=$m_start?>','<?=$y_start?>');
</script> 
  <span class="style6">ข้อมูลเชิงสถิติ </span></td>
  </tr>
  <tr align="left" style="font-weight:bold;">
    <td align="right">&nbsp;</td>
    <td align="right">วัน เดือน ปี สิ้นสุด&nbsp;&nbsp;</td>
    <td>วันที่
      <select name="d_end_edu"  id="d_end_edu" onChange="check_date('d_end_edu','m_end_edu','y_end_edu');"> </select>
	  
          <?/* <option value="">ไม่ระบุ</option>
for ($i=1;$i<=31;$i++){
	if($d_end==sprintf("%02d",$i)){
		echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option value=\"".sprintf("%02d",$i)."\" >" .  sprintf("%02d",$i) . "</option>";
	}
}*/
?>
       
      เดือน
  <select name="m_end_edu" id="m_end_edu" onChange="check_date('d_end_edu','m_end_edu','y_end_edu');"></select>
  
    <?
/*    <option value="">ไม่ระบุ</option>
for ($i=1;$i<=12;$i++){
		if($m_end==sprintf("%02d",$i)){
		echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
		}else{
		echo "<option value=\"".sprintf("%02d",$i)."\">" .  sprintf("%02d",$i) . "</option>";
		}
	}*/
?>
  
      ปี
  <select name="y_end_edu" id="y_end_edu" onChange="check_date('d_end_edu','m_end_edu','y_end_edu');"></select>
 
    <? 
/*	<option value="">ไม่ระบุ</option>
$thisyear = date("Y") + 543;
$y1 = $thisyear - 80;
$y2 = $thisyear ;
					
for ($i=$y2;$i>=$y1;$i--){
	if($y_end==$i){
		echo "<option  value=\"".$i."\" SELECTED>$i</option>";
	}else{
		echo "<option  value=\"".$i."\">$i</option>";
	}
}*/

	// $diff  = dateLength($rs[begindate]);

?>
 <script>
	create_calendar('d_end_edu','m_end_edu','y_end_edu','<?=$d_end?>','<?=$m_end?>','<?=$y_end?>');
</script> 
  <span class="style6">ข้อมูลเชิงสถิติ </span></td>
  </tr>


    
<tr><td align="right" >&nbsp;</td><td align="right">&nbsp;</td><td align="left">&nbsp;</td> 
</tr>
</table>
<!--</div>

-->
<br><br>
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr valign="middle" align="center"> 
	<td> 
	
	<input type="submit" name="send" value="บันทึก" style="width:90px;">
	<input type="button" name="Button" value="ยกเลิก" onClick="location.href='?action=view'">
	<input type="button" name="Button" value="กลับหน้าแรก" onClick="location.href='absent_all_1.php?'">
	</td>
</tr>
</table>
</form>
<?
	}
	if($action=="add"){
?>



<form method="post" name="post"  action="<?=$PHP_SELF?>">
<input type="hidden" name="day" value="<?=$days?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="yy" value="<?=$array_day?>">
<input type="hidden" name="action" value="add">
<!--เลือกปี&nbsp;<input name="ch_year" type="radio" value="0" checked  onClick="onSelect('0','Posdate');">ลาอื่น ๆ<input name="ch_year" type="radio" value="1"   onClick="onSelect('1','Posyear');">
ลาศึกษาต่อ
--><input type="hidden" name="ch_year" value="0">

<!--<div id='Posyear' style="display:block;">	
--><table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
<tr>
  <td align="right" valign="top">&nbsp;</td>
  <td align="left" valign="top">&nbsp;ส่วนแสดงรายการข้อมูล&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td align="center" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ส่วนแสดงใน ก.พ7. </td>
  <td width="329" align="left" valign="top">&nbsp;</td>
</tr>
<tr>
  <td align="right" valign="top">&nbsp;</td>
  <td align="left" valign="top">&nbsp;</td>
  <td colspan="2" align="left" valign="top"><span class="style6">หากท่านบันทึกในชองแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
  </tr>

<tr>
  <td align="right" valign="top">&nbsp;</td>
  <td align="left" valign="top">&nbsp;</td>
  <td align="right" valign="top" bgcolor="#A3B2CC">&nbsp;</td>
  <td align="left" valign="top">&nbsp;</td>
</tr>
<tr> 
<td align="right" valign="top" width="242">
   <B>พ.ศ.</B>&nbsp;&nbsp;</td> 
<td width="136" align="left" valign="top"> 

<select name="yy" >
<?
$thisyear = date("Y") + 543;
$sq="select   yy    from  hr_absent  where id='$id' ";
$re=mysql_query($sq);
while($r=mysql_fetch_array($re)){
 $arr_insertedyy[$r[yy]] = $r[yy] ; 
}
for ($i=$thisyear;$i>=2470;$i--){
	if (( $arr_insertedyy[$i]  != "" )and  ($action !="edit2")){ continue ; } 
	if ($rs[yy] == $i){ 
		echo "<option selected>$i</option>";   
	} else{ 
		echo "<option>$i</option>";
	} # END if ($rs[yy] == $i){ 
} # end for 	($i=$thisyear;$i>=2470;$i--){

?>
</select></td>
<td width="251" align="right" valign="top" bgcolor="#A3B2CC">พ.ศ.&nbsp;
  <input name="label_yy" type="text" value="<?=$rs[label_yy]?>" size="20" maxlength="50">
  <br></td>
<td align="left" valign="top"><span class="style6">ในกรณีช่อง พ.ศ.มีมากกว่า 1 บรรทัด<br>
  ให้ใส่
  เครื่องหมาย<strong> , </strong>คั่น เช่น 23 ก.พ. 50<strong>,</strong>1 ต.ค. 51</span></td>
</tr>
<tr align="left" style="font-weight:bold;"> 
	<td align="right" >ลาป่วย&nbsp;&nbsp;</td>
	<td><input type="text" name="sick" size="10" value="<? if($rs[sick]==0){}else{echo $rs[sick];}?>" maxlength="4">&nbsp;&nbsp;วัน
	&nbsp;</td>
    <td align="right">ลาป่วย&nbsp;
      <input name="label_sick" type="text" value="<?=$rs[label_sick]?>" size="20" maxlength="50"></td>
    <td>&nbsp;</td>
</tr>

<tr align="left" style="font-weight:bold;"> 
	<td align="right" bgcolor="#A3B2CC">ลากิจ&nbsp;&nbsp;</td>
	<td><input type="text" name="duty" size="10" value="<? if($rs[duty]==0){}else{echo $rs[duty];}?>" maxlength="4">&nbsp;&nbsp;วัน</td>
    <td rowspan="2" align="right">ลากิจและพักผ่อน&nbsp;
      <input name="label_dv" type="text" value="<?=$rs[label_dv]?>" size="20" maxlength="50"></td>
    <td rowspan="2" bgcolor="#A3B2CC">&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;"> 
	<td align="right" bgcolor="#A3B2CC">พักผ่อน&nbsp;&nbsp;</td>
	<td><input type="text" name="vacation" size="10" value="<? if($rs[vacation]==0){}else{ echo $rs[vacation];}?>" maxlength="4">&nbsp;&nbsp;วัน</td>
    </tr>				
<tr align="left" style="font-weight:bold;"> 
	<td align="right">มาสาย&nbsp;&nbsp;</td>
	<td><input name="late" type="text" id="late" value="<? if($rs[late]==0){}else{echo $rs[late]; }?>" size="10" maxlength="4">&nbsp;&nbsp;วัน</td>
    <td align="right">มาสาย&nbsp;
      <input name="label_late" type="text" value="<?=$rs[label_late]?>" size="20" maxlength="50"></td>
    <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;"> 
	<td align="right">ขาดราชการ&nbsp;&nbsp;</td>
	<td><input type="text" name="absent" size="10" value="<? if($rs[absent]==0){}else{echo $rs[absent]; }?>" maxlength="4">&nbsp;&nbsp;วัน</td>
    <td align="right">ขาดราชการ&nbsp;
      <input name="label_absent" type="text" value="<?=$rs[label_absent]?>" size="20" maxlength="50"></td>
    <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
  <td align="right">ลาคลอด&nbsp;&nbsp;</td>
  <td><input name="birth2" type="text" value="<? if($rs[birth]==0){echo $rs[birth];}else {echo $rs[birth]; }?>" size="10" maxlength="4">
    &nbsp;&nbsp;วัน</td>
  <td align="right">
    <input name="label_birth2" type="hidden" value="<?//=$rs[label_birth]?>" size="20" maxlength="50"></td>
  <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
	<td align="right">ลาพิเศษ ( ลาประกอบพิธีกรรมทางศาสนา )&nbsp;&nbsp;</td>
	<td><input name="etc" type="text" id="etc" value="<? if($rs[etc]==0){}else{echo $rs[etc];}?>" size="10" maxlength="4">&nbsp;&nbsp;วัน
	 <input name="label_etc" type="hidden" value="<?=$rs[label_etc]?>" size="20" maxlength="50">	</td>
    <td align="right">ลาศึกษาต่อ
      <input name="label_education" type="text" size="20" maxlength="100"  width="20">
      <input name="other_absent" type="hidden"  value="<?//=$rs[other_absent]?>">   </td>
    <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
  <td align="right">&nbsp;</td>
  <td colspan="2" align="center">กรณีลาออกแล้วกลับเข้ารับราชการใหม่ </td>
  <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
  <td align="right">&nbsp;</td>
  <td colspan="2" align="center"><input name="special_exp" type="text" value="<?=$rs[special_exp];?>" size="50">
    &nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td>&nbsp;</td>
</tr>

<tr align="left" style="font-weight:bold;">
  <td align="right"> </td>
  <td colspan="3">      </td>
  </tr>
</table>
<!--</div>
<div id='Posdate' style="display:none;">	
--><table align="center">
<?

/*$s=explode("-",$rs['startdate']);
$startdate=$s[2]."/".$s[1]."/".$s[0];

$e=explode("-",$rs['enddate']);
$enddate=$e[2]."/".$e[1]."/".$e[0];
*/
?>
  <tr align="left" style="font-weight:bold;">
    <td colspan="3">&nbsp;</td>
    </tr>
  <tr align="left" style="font-weight:bold;">
    <td colspan="2" align="left">ลาศึกษาต่อ</td>
    <td width="440">&nbsp;</td>
  </tr>
  <tr align="left" style="font-weight:bold;">
    <td colspan="3"><span class="style6">**หากต้องการให้ช่องลาศึกษาต่อแสดงวันลาศึกษาเป็น &quot;ลาศึกษาต่อ&quot; ในเอกสาร ก.พ.7  ให้เลือก 1- 01- xxxx - 31-12- xxxx </span></td>
    </tr>
  <tr align="left" style="font-weight:bold;">
    <td width="27" align="right">&nbsp;</td>
    <td width="135" align="right">วัน เดือน ปี เริ่มต้น&nbsp;&nbsp; </td>
    <td>
	
	 วันที่
      <select name="d_start_edu" id="d_start_edu" onChange="check_date('d_start_edu','m_start_edu','y_start_edu');">
      </select>
      <? /*<option value="">ไม่ระบุ</option>
for ($i=1;$i<=31;$i++){
	if($d_start==sprintf("%02d",$i)){
	echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option value=\"".sprintf("%02d",$i)."\" >" .  sprintf("%02d",$i) . "</option>";
	}
}*/
?>
เดือน
<select name="m_start_edu" id="m_start_edu" onChange="check_date('d_start_edu','m_start_edu','y_start_edu');">
</select>
<? /*<option value="">ไม่ระบุ</option>
for ($i=1;$i<=12;$i++){
		if($m_start==sprintf("%02d",$i)){
		echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
		}else{
		echo "<option value=\"".sprintf("%02d",$i)."\">" .  sprintf("%02d",$i) . "</option>";
		}
	}*/
?>
ปี
<select name="y_start_edu"  id="y_start_edu" onChange="check_date('d_start_edu','m_start_edu','y_start_edu');" >
</select>
<? /*<option value="">ไม่ระบุ</option>
$thisyear = date("Y") + 543;
$y1 = $thisyear - 80;
$y2 = $thisyear ;
					
for ($i=$y2;$i>=$y1;$i--){
	if($y_start==$i){
		echo "<option  value=\"".$i."\" SELECTED>$i</option>";

	}else{
		echo "<option  value=\"".$i."\">$i</option>";
	}
}
*/
	// $diff  = dateLength($rs[begindate]);

?>
<script>
	create_calendar('d_start_edu','m_start_edu','y_start_edu','<?=$d_start?>','<?=$m_start?>','<?=$y_start?>');
</script>
<span class="style6">ข้อมูลเชิงสถิติ </span></td>
  </tr>
  <tr align="left" style="font-weight:bold;">
    <td align="right">&nbsp;</td>
    <td align="right">วัน เดือน ปี สิ้นสุด&nbsp;&nbsp;</td>
    <td> วันที่
      <select name="d_end_edu"  id="d_end_edu" onChange="check_date('d_end_edu','m_end_edu','y_end_edu');">
      </select>
      <?/* <option value="">ไม่ระบุ</option>
for ($i=1;$i<=31;$i++){
	if($d_end==sprintf("%02d",$i)){
		echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option value=\"".sprintf("%02d",$i)."\" >" .  sprintf("%02d",$i) . "</option>";
	}
}*/
?>
เดือน
<select name="m_end_edu" id="m_end_edu" onChange="check_date('d_end_edu','m_end_edu','y_end_edu');">
</select>
<?
/*    <option value="">ไม่ระบุ</option>
for ($i=1;$i<=12;$i++){
		if($m_end==sprintf("%02d",$i)){
		echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
		}else{
		echo "<option value=\"".sprintf("%02d",$i)."\">" .  sprintf("%02d",$i) . "</option>";
		}
	}*/
?>
ปี
<select name="y_end_edu" id="y_end_edu" onChange="check_date('d_end_edu','m_end_edu','y_end_edu');">
</select>
<? 
/*	<option value="">ไม่ระบุ</option>
$thisyear = date("Y") + 543;
$y1 = $thisyear - 80;
$y2 = $thisyear ;
					
for ($i=$y2;$i>=$y1;$i--){
	if($y_end==$i){
		echo "<option  value=\"".$i."\" SELECTED>$i</option>";
	}else{
		echo "<option  value=\"".$i."\">$i</option>";
	}
}*/

	// $diff  = dateLength($rs[begindate]);

?>
<script>
	create_calendar('d_end_edu','m_end_edu','y_end_edu','','','');
</script>
<span class="style6">ข้อมูลเชิงสถิติ </span></td>
  </tr>

    
<tr><td align="right" >&nbsp;</td><td align="right">&nbsp;</td><td align="left">&nbsp;</td> 
</tr>
</table>
<!--</div>

-->
<br><br>
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr valign="middle" align="center"> 
	<td> 
	
	<input type="submit" name="send" value="บันทึก" style="width:90px;">
		<input type="button" name="Button" value="ยกเลิก" onClick="location.href='?action=view'">
		<input type="button" name="Button" value="กลับหน้าแรก" onClick="location.href='absent_all_1.php?'">
	</td>
</tr>
</table>
</form>
<?
}
?>

	</td>
</tr>
</table>      
    </td>
</tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>