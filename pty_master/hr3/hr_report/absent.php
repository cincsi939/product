<?php ######################  start Header ########################
/**
* @comment ���١���ҧ���������Ѻ���ͺ
* @projectCode 56EDUBKK01
* @tor 7.2.4.4.7
* @package core
* @author Suwat.K
* @access public/private
* @created 10/04/2014
*/
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
include("../../../config/phpconfig.php");
include("alert.php");
include("../../../common/function_kp7_logerror.php");
$idcard=$_SESSION[idoffice];
$staffid=$_SESSION[session_staffid];
$time_start = getmicrotime();
$mmeng = array("","january","february","march","april","may","june","july","august","september","october","november","december");
 $ch_yea=$_POST[ch_year];

if($ch_yea==1) {
	
		$sqlgen="select  *  from  general   where id='$id'";
		   $relult=mysql_query($sqlgen);
		   while($ros=mysql_fetch_array($relult)){
			   $begindate=$ros['begindate'];
		   } // ��while

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
//case ��� 1
	if($yeardif==0){
			//	$start_diff_day =strtotime(intval($s[0])." ".$mmeng[intval($s[1])]." ".($s[2]-543));
				$start_diff_day =strtotime(intval($d_start_edu)." ".$mmeng[intval($m_start_edu)]." ".($y_start_edu-543));
				//$end_diff_day =strtotime(intval($e[0])." ".$mmeng[intval($e[1])]." ".($e[2]-543));
				$end_diff_day =strtotime(intval($d_end_edu)." ".$mmeng[intval($m_end_edu)]." ".($y_end_edu-543));
				$timediff =$end_diff_day-$start_diff_day;
				$education=intval($timediff/86400);
				
				
	if ($_SERVER[REQUEST_METHOD] == "POST"){
	
				if($action=="edit2"){
				
			$sql = "update  hr_absent  set  education='$education',startdate ='$startdate',enddate='$enddate',yy='$yy'
			where id ='$id' and yy='$start' ";
			//echo $sql;die;
		$returnid = add_monitor_logbefore("hr_absent","");
		mysql_query($sql)or die("�������ö��䢢�������");
		add_monitor_logafter("hr_absent"," id ='$id' and yy='$start' ",$returnid);
			
			//	mysql_query($sql)or die("�������ö��䢢�������");
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
				 echo "<script language=\"javascript\">alert(\"�ѹ����ҵ�ͧ�����¡����ѹ����Ѻ�Ҫ���\\n \");location.href='?id=$id&action=edit';</script>";
				   }else {
				 $sql = "INSERT INTO  hr_absent (id,yy,education,startdate,enddate) VALUES ('$id','$start','$education','$startdate','$enddate')";
				 
				 $returnid = add_monitor_logbefore("hr_absent","");
				 $result  = mysql_query($sql);	
				add_monitor_logafter("hr_absent"," id ='$id' and yy ='$start' ",$returnid);	
				
							if($result){
								echo "<script language=\"javascript\">alert(\"".msginsert."\\n \");	</script>	";
								  echo"<meta http-equiv='refresh' content='0;URL=absent.php?action=view'>";			
								exit;
							}else{	$msg = "�������ö�ѹ�֡�������� ";}
			}//�����ѹ��
	      }//�����ѹ���������ش
	   }
    }
//-----------------------------------------------------------------------------------------------------------------------
//case ��� 2
     } else {
		$sql_12="SELECT DATEDIFF('$endedu 23:59:59','$startedu') as sw";
		//$sql_12="SELECT DATEDIFF ('$endedu','$startedu') AS e";
		$query_edu=mysql_query($sql_12)or die ("ERRRRRR".__LINE__.mysql_error());
		$ab_edu=mysql_fetch_assoc($query_edu);
		$education=$ab_edu[sw];
	
	if ($_SERVER[REQUEST_METHOD] == "POST"){
		if($action=="edit2"){			 
			$sql = "update  hr_absent  set  education='$education',startdate = '$startdate',enddate='$enddate',label_education='$label_education', yy='$yy'
			where id ='$id' and yy='$start' ";
				//echo $sql;die;
				$returnid = add_monitor_logbefore("hr_absent"," id ='$id' and yy='$start' ");
				mysql_query($sql)or die("�������ö��䢢�������");
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
						 echo "<script language=\"javascript\">alert(\"�ѹ����ҵ�ͧ�����¡����ѹ����Ѻ�Ҫ���\\n \");</script>";
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
							}else{	$msg = "�������ö�ѹ�֡�������� ";}
			}//�����ѹ��
	      }//�����ѹ���������ش
	   }
    }
		
}///////////////////////////////////////////

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
				
	
	if ($_SERVER[REQUEST_METHOD] == "POST"){
		if($_POST[action]=="edit2"){

			       if($startdate>$enddate){echo "<script language=\"javascript\">alert(\"".msg1."\\n \");location.href='?id=$id&action=edit';</script> ";
			            }else{
			         	  if(($startdate>$days)or($enddate>$days)){
				      echo " <script language=\"javascript\">alert(\"".msg2."\\n \"); location.href='?id=$id&action=edit';</script> ";
			           }else{
				   	      if(($startdate<=$begindate)&&($enddate<=$begindate)&&($startdate=="")&&($enddate==""))
				 	  {  
					 echo "<script language=\"javascript\">alert(\"�ѹ����� ��ͧ�����¡����ѹ����Ѻ�Ҫ���\\n \");location.href='?id=$id&action=edit';</script>";
				     }else {
				   if( $sick==""){$sick=0;}
					if($birth==""){$birth=0;}
					if($duty==""){$duty=0;}
					if($vacation==""){$vacation=0;}
					if($late==""){$late=0;}
					if($absent==""){$absent=0;}
					if($etc==""){$etc=0;}
					$helpbirth = ($_POST['helpbirth'] =="") ? 0 : $_POST['helpbirth'];
					$soldier = ($_POST['soldier']=="") ? 0 : $_POST['soldier'];
					$eduday = ($_POST['eduday']=="") ? 0 : $_POST['eduday'];
					$gointer = ($_POST['gointer']=="") ? 0 : $_POST['gointer'];
					$gomarry = ($_POST['gomarry']=="") ? 0 : $_POST['gomarry'];
					$upskill = ($_POST['upskill']=="") ? 0 : $_POST['upskill'];
					
					//echo "A : ".strlen($label_yy); die;
					if(strlen($label_yy) > 2 ){
						$label_yy=trim($label_yy);
					}
					if($special_exp !=""){$merge_col=1;}else{$merge_col="";}
		$sql = " update  hr_absent set  yy='$yy', sick='$sick' , duty = '$duty' , vacation = '$vacation', late ='$late', absent = '$absent'  , ";
		$sql .= "etc = '$etc',date = '$date' ,date_vacation = '$date_vacation',date_vacation_all ='$date_vacation_all', ";
		$sql .= "helpbirth = $helpbirth, soldier = '$soldier', eduday ='$eduday', gointer='$gointer', gomarry='$gomarry', upskill='$upskill', ";
		$sql .= "birth='$birth', startdate='$startdate', enddate='$enddate' ,other_absent='',label_sick='$label_sick',label_birth='$label_birth',label_dv='$label_dv',label_late='$label_late',label_absent='$label_absent',label_etc='$label_etc',label_yy='$label_yy',education='$education',label_education='$label_education2',special_exp='$special_exp',merge_col='$merge_col' where id ='$id' and yy ='$old_yy' ;";
		//echo $sql."";die;
		add_log("�����Ũӹǹ�ѹ����ش",$id,"edit");
		$returnid = add_monitor_logbefore("hr_absent"," id ='$id' and yy ='$yy' ");
		mysql_query($sql)or die("�������ö��䢢�������");
		add_monitor_logafter("hr_absent"," id ='$id' and yy ='$yy' ",$returnid);
		
		######################
		$temp_subject_error=explode("::",$_POST['subject_error']);
		$temp_value_key_error=explode("::",$_POST['value_key_error']);
		$temp_label_key_error=explode("::",$_POST['label_key_error']);
		$temp_submenu_id=explode("::",$_POST['submenu_id']);
		$numTemp=count($temp_subject_error);
		
		for($a=1;$a<$numTemp;$a++){
			save_kp7_logerror($idcard,$temp_subject_error[$a],get_real_ip(),'UPDATE',$temp_value_key_error[$a],$temp_label_key_error[$a],$staffid,$temp_submenu_id[$a]);
		}		
		######################
		
		echo "<script language=\"javascript\">
				alert(\"".msgedit."\\n \");
				</script>
				";
				echo"<meta http-equiv='refresh' content='0;URL=absent.php?action=view'>";			
			   	}//�����ѹ��
	           } //�����ѹ���������ش
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
									 echo "<script language=\"javascript\">alert(\"�ѹ����ҵ�ͧ�����¡����ѹ����Ѻ�Ҫ���\\n \");location.href='?id=$id&action=edit';</script>";
									   }else {
									if( $sick==""){$sick=0;}
									if($birth==""){$birth=0;}
									if($duty==""){$duty=0;}
									if($vacation==""){$vacation=0;}
									if($late==""){$late=0;}
									if($absent==""){$absent=0;}
									if($etc==""){$etc=0;}
									$helpbirth = ($_POST['helpbirth'] =="") ? 0 : $_POST['helpbirth'];
									$soldier = ($_POST['soldier']=="") ? 0 : $_POST['soldier'];
									$eduday = ($_POST['eduday']=="") ? 0 : $_POST['eduday'];
									$gointer = ($_POST['gointer']=="") ? 0 : $_POST['gointer'];
									$gomarry = ($_POST['gomarry']=="") ? 0 : $_POST['gomarry'];
									$upskill = ($_POST['upskill']=="") ? 0 : $_POST['upskill'];
									
									if(strlen($label_yy) > 2){
										$label_yy=trim($label_yy);
									}
										if($special_exp !=""){$merge_col=1;}else{$merge_col="";}
					 $sql = "INSERT INTO  hr_absent (id,yy,sick,duty,vacation,late,absent,etc,date_vacation,date_vacation_all,birth,";
					 $sql .= "helpbirth,soldier, eduday, gointer, gomarry, upskill,";
					 $sql .= "startdate, enddate,other_absent,label_sick,label_birth,label_dv,label_late,label_absent,label_etc,";
					 $sql .= "label_yy,education,label_education,special_exp,merge_col) VALUES ";
					 $sql .= "('$id','$yy','$sick','$duty','$vacation','$late','$absent','$etc','$date_vacation','$date_vacation_all','$birth',";
					 $sql .= "'$helpbirth','$soldier', '$eduday', '$gointer', '$gomarry', '$upskill', ";
					 $sql .= "'$startdate','$enddate','$other_absent','$label_sick','$label_birth','$label_dv','$label_late','$label_absent','$label_etc','$label_yy',";
					 $sql .= "'$education','$label_education','$special_exp','$merge_col')";
                    
					 
					  add_log("�����Ũӹǹ�ѹ����ش",$id,"insert");
					$returnid = add_monitor_logbefore("hr_absent","");
					 $result  = mysql_query($sql);	
					add_monitor_logafter("hr_absent"," id ='$id' and yy ='$yy' ",$returnid);

					  
				    	}//�����ѹ��
	                  } //�����ѹ���������ش
                     }
					if($result)
					{
		
		######################
		$temp_subject_error=explode("::",$_POST['subject_error']);
		$temp_value_key_error=explode("::",$_POST['value_key_error']);
		$temp_label_key_error=explode("::",$_POST['label_key_error']);
		$temp_submenu_id=explode("::",$_POST['submenu_id']);
		$numTemp=count($temp_subject_error);
		
		for($a=1;$a<$numTemp;$a++){
			save_kp7_logerror($idcard,$temp_subject_error[$a],get_real_ip(),'INSERT',$temp_value_key_error[$a],$temp_label_key_error[$a],$staffid,$temp_submenu_id[$a]);
		}		
		######################
					echo "
				<script language=\"javascript\">
				alert(\"".msginsert."\\n \");
				</script>
				";	
			echo"<meta http-equiv='refresh' content='0;URL=absent.php?action=view'>";			
						exit;
					}else{	$msg = "�������ö�ѹ�֡�������� ";}
	                 }
                     }else if ($_GET[action] == 'delete')
	                {
		          add_log("�����Ũӹǹ�ѹ����ش",$id,"delete");
	            	mysql_query("delete from hr_absent where id = $id and yy='$yy';");
		           if (mysql_errno())
			{
			$msg = "�������öź��������";
			}else
			{
		    echo"<meta http-equiv='refresh' content='0;URL=absent.php?action=view'>";			
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
<script type="text/javascript" src="../../../common/calendar_list.js"></script>
<script type="text/javascript" src="../../../common/script_event.js"></script>
<script>
var imgDir_path="../popup_calenda/images/calendar/";
</script>
<script src="jquery.js" type="text/javascript"></script>
<script src="script.js" type="text/javascript"></script>
<script src="../../../common/check_label_values/script.js" type="text/javascript"></script>
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
*/
$(document).ready(function() {
	path="../../../common/check_label_values/";
	check_true='<img src="'+path+'images/checked.gif" width="18" height="18" />';
	check_false='<img src="'+path+'images/unchecked.gif" width="18" height="18" />';
	
	$('#value_yy').after("<span id='msg_value_yy' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'label_yy','values','number',"chk_yy");});
	$('#label_yy').after("<span id='msg_label_yy' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'value_yy','label','number',"chk_yy");});
	
	$('#sick').after("<span id='msg_sick' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'label_sick','values','number',"chk_sick");});
	$('#label_sick').after("<span id='msg_label_sick' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'sick','label','number',"chk_sick");});
	
	/*$('#value_dv').after("<span id='msg_value_dv' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'label_dv','values','number',"chk_dv");});
	$('#label_dv').after("<span id='msg_label_dv' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'value_dv','label','number',"chk_dv");});*/
	
	$('#late').after("<span id='msg_late' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'label_late','values','number',"chk_late");});
	$('#label_late').after("<span id='msg_label_late' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'late','label','number',"chk_late");});
	
	$('#absent').after("<span id='msg_absent' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'label_absent','values','number',"chk_absent");});
	$('#label_absent').after("<span id='msg_label_absent' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'absent','label','number',"chk_absent");});
});

function showValue(e){
		document.getElementById('value_yy').value=e.value;
}

function sumDV(){
		/*var a=(document.getElementById('duty').value*1);
		var b=(document.getElementById('vacation').value*1);
		document.getElementById('value_dv').value=a+b;
		document.getElementById('label_dv').focus();*/
}

function ch(){
		var f1=document.post;
		var chkStatus=0;
		if (f1.chk_yy.value == 'false'){
			if(confirm("��ͧ �.�. ���ç�Ѻ��ͧ�ʴ��� ��.7 ��ͧ��ô��Թ��õ���������")){
					chkStatus=0;
					f1.subject_error.value=f1.subject_error.value+"::"+"��ͧ �.�. ���ç�Ѻ��ͧ�ʴ��� ��.7";
					f1.value_key_error.value=f1.value_key_error.value+"::"+f1.value_yy.value;
					f1.label_key_error.value=f1.label_key_error.value+"::"+f1.label_yy.value;
					f1.submenu_id.value=f1.submenu_id.value+"::"+"12";
			}else{
					chkStatus=1;
					f1.subject_error.value="";
					f1.value_key_error.value="";
					f1.label_key_error.value="";
					f1.submenu_id.value="";
					return false;
			}
		}
		
		if (f1.chk_sick.value == 'false'){
			if(confirm("��ͧ�һ��� ���ç�Ѻ��ͧ�ʴ��� ��.7 ��ͧ��ô��Թ��õ���������")){
					chkStatus=0;
					f1.subject_error.value=f1.subject_error.value+"::"+"��ͧ�һ��� ���ç�Ѻ��ͧ�ʴ��� ��.7";
					f1.value_key_error.value=f1.value_key_error.value+"::"+f1.sick.value;
					f1.label_key_error.value=f1.label_key_error.value+"::"+f1.label_sick.value;
					f1.submenu_id.value=f1.submenu_id.value+"::"+"13";
			}else{
					chkStatus=1;
					f1.subject_error.value="";
					f1.value_key_error.value="";
					f1.label_key_error.value="";
					f1.submenu_id.value="";
					return false;
			}
		}
		
		if (f1.chk_dv.value == 'false'){
			if(confirm("��ͧ�ҡԨ��оѡ��͹ ���ç�Ѻ��ͧ�ʴ��� ��.7 ��ͧ��ô��Թ��õ���������")){
					chkStatus=0;
					f1.subject_error.value=f1.subject_error.value+"::"+"��ͧ�ҡԨ��оѡ��͹ ���ç�Ѻ��ͧ�ʴ��� ��.7";
					f1.value_key_error.value=f1.value_key_error.value+"::"+f1.value_dv.value;
					f1.label_key_error.value=f1.label_key_error.value+"::"+f1.label_dv.value;
					f1.submenu_id.value=f1.submenu_id.value+"::"+"14";
			}else{
					chkStatus=1;
					f1.subject_error.value="";
					f1.value_key_error.value="";
					f1.label_key_error.value="";
					f1.submenu_id.value="";
					return false;
			}
		}
		
		if (f1.chk_late.value == 'false'){
			if(confirm("��ͧ����� ���ç�Ѻ��ͧ�ʴ��� ��.7 ��ͧ��ô��Թ��õ���������")){
					chkStatus=0;
					f1.subject_error.value=f1.subject_error.value+"::"+"��ͧ����� ���ç�Ѻ��ͧ�ʴ��� ��.7";
					f1.value_key_error.value=f1.value_key_error.value+"::"+f1.late.value;
					f1.label_key_error.value=f1.label_key_error.value+"::"+f1.label_late.value;
					f1.submenu_id.value=f1.submenu_id.value+"::"+"15";
			}else{
					chkStatus=1;
					f1.subject_error.value="";
					f1.value_key_error.value="";
					f1.label_key_error.value="";
					f1.submenu_id.value="";
					return false;
			}
		}
		
		if (f1.chk_absent.value == 'false'){
			if(confirm("��ͧ�Ҵ�Ҫ��� ���ç�Ѻ��ͧ�ʴ��� ��.7 ��ͧ��ô��Թ��õ���������")){
					chkStatus=0;
					f1.subject_error.value=f1.subject_error.value+"::"+"��ͧ�Ҵ�Ҫ��� ���ç�Ѻ��ͧ�ʴ��� ��.7";
					f1.value_key_error.value=f1.value_key_error.value+"::"+f1.absent.value;
					f1.label_key_error.value=f1.label_key_error.value+"::"+f1.label_absent.value;
					f1.submenu_id.value=f1.submenu_id.value+"::"+"16";
			}else{
					chkStatus=1;
					f1.subject_error.value="";
					f1.value_key_error.value="";
					f1.label_key_error.value="";
					f1.submenu_id.value="";
					return false;
			}
		}
		
		if(chkStatus==0){
				return true;
		}else{
				return false;
		}
}

</script>
</head>
<body bgcolor="#A3B2CC">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr> 
 <td height="30"><a href="kp7_absent.php?id=<?=$id?>" title="��Ǩ�ͺ������ ��.7">&nbsp;<img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" ><span class="style5"> ��Ǩ�ͺ�͡��â����� �.�.7 ����硷�͹ԡ�� </span></a></td>
 <td width="50" height="30"></td>
 </tr>
</table>
<?
if ($msg){
?>
<center>
<h2><font COLOR="red"><?=$msg?></font></h2>
<input type=button value=" ��͹��Ѻ " onClick="history.back();">
</center>
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
	<td><b>���� / ʡ��&nbsp;<u>
	  <?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]?>
	</u></b> </td>
</tr>
<tr align="left" valign="top" >
  <td align="left">&nbsp;</td>
</tr>
<tr align="left" valign="top" >
  <td align="left"><b> �. �ӹǹ�ѹ����ش�Ҫ��� �Ҵ�Ҫ��� �����</b> </td>
</tr>
</table>
<br>
<?
if($action=="view"){
?>
<table width="98%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
<tr bgcolor="#999999" align="center" style="font-weight:bold;"> 
	<td bgcolor="#A3B2CC">�.�.</td>
	<td width="6%" bgcolor="#A3B2CC">�һ���</td>
	<td width="6%" bgcolor="#A3B2CC">�Ҥ�ʹ</td>
    <td width="6%" bgcolor="#A3B2CC">��仪�������Ҥ�ʹ</td>
	<td width="6%" bgcolor="#A3B2CC">�ҡԨ</td>
	<td width="6%" bgcolor="#A3B2CC">�Ҿѡ��͹</td>
    <td width="6%" bgcolor="#A3B2CC">�һ�Сͺ�Ը���ʹ�</td>
    <td width="6%" bgcolor="#A3B2CC">�ҤѴ���͡����</td>
    <td width="6%" bgcolor="#A3B2CC">���֡�ҵ��</td>
	<td width="6%" bgcolor="#A3B2CC">��价ӧҹͧ��õ�ҧ�����</td>
    <td width="6%" bgcolor="#A3B2CC">�ҵԴ����������</td>
    <td width="6%" bgcolor="#A3B2CC">��仿�鹿��Ҫվ</td>
    <td width="6%" bgcolor="#A3B2CC">�����</td>
	<td width="6%" bgcolor="#A3B2CC">�Ҵ�Ҫ���</td>
	<td width="6%" bgcolor="#A3B2CC">����ѹ��</td>
	<td bgcolor="#A3B2CC"><input type="button" name="add" value="����������" onClick="location.href='absent.php?id=<?=$id?>&action=add' "></td>
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
	<td colspan="14">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	  <?=$rs[special_exp]?></td>
	<td align="center"><a href="?id=<?=$rs[id]?>&yy=<?=$rs[yy]?>&ch_year=<?=$ch_yea?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> 
<a href="#" onClick="if (confirm('�س�зӡ��ź��������ǹ�����������!!')) location.href='?action=delete&id=<?=$rs[id]?>&yy=<?=$rs[yy]?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>	</td>
</tr><? }else { $sumday = 0;?>
   <tr align="center" bgcolor="<?=$bg?>"> 
	<td><?=$rs[yy]; #�� �.�?></td>
	<td><?=$rs[sick]; $sumday+=$rs[sick]; #����?></td>
	<td><?=$rs[birth]; $sumday+=$rs[birth]; #��ʹ?></td>
    <td><?=$rs[helpbirth]; $sumday+=$rs[helpbirth]; #���¤�ʹ?></td>
	<td><?=$rs[duty]; $sumday+=$rs[duty]; #�Ԩ?>  </td>
	<td><?=$rs[vacation]; $sumday+=$rs[vacation]; #�ѡ��͹?></td>
    <td><?=$rs[etc]; $sumday+=$rs[etc]; #�Ǫ?></td>
    <td><?=$rs[soldier]; $sumday+=$rs[soldier]; #�Ѵ���͡����?></td>
    <td><?=$rs[eduday]; $sumday+=$rs[eduday]; #�֡�ҵ��?></td>
    <td><?=$rs[gointer]; $sumday+=$rs[gointer]; #�ӧҹͧ��������ҧ�����?></td>
    <td><?=$rs[gomarry]; $sumday+=$rs[gomarry]; #仡Ѻ�������?></td>
    <td><?=$rs[upskill]; $sumday+=$rs[upskill]; #��鹿��Ҫվ?></td>
	<td><?=$rs[late]; $sumday+=$rs[late]; #���?></td>
	<td><?=$rs[absent]; $sumday+=$rs[absent]; #�Ҵ?></td>	
	<td><? echo  $sumday;?></td>
	<td><a href="?id=<?=$rs[id]?>&yy=<?=$rs[yy]?>&ch_year=<?=$ch_yea?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> 
<a href="#" onClick="if (confirm('�س�зӡ��ź��������ǹ�����������!!')) location.href='?action=delete&id=<?=$rs[id]?>&yy=<?=$rs[yy]?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>	</td>
</tr>

<?
}
}
//} 
mysql_free_result($result);
?>
<tr  bgcolor="<?=$bg?>"><td colspan="16" align="center"><input type="button" name="Button" value="��Ѻ˹���á" onClick="location.href='absent_all_1.php?'"></td>
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
<form method="post" name="post"  action="<?=$PHP_SELF?>"  onSubmit="return ch();" >
<input type="hidden" name="day" value="<?=$days?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="yy" value="<?=$array_day?>">
<input type="hidden" name="action" value="edit2">&nbsp;&nbsp;
<!--���͡��&nbsp;<input name="ch_year" type="radio" value="0" checked  onClick="onSelect('0','Posdate');">����� �<input name="ch_year" type="radio" value="1"   onClick="onSelect('1','Posyear');">
���֡�ҵ��
--><input type="hidden" name="ch_year" value="0">

<!--<div id='Posyear' style="display:block;">	
--><table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
<tr>
  <td align="right" valign="top">&nbsp;</td>
  <td align="left" valign="top">&nbsp;��ǹ�ʴ���¡�â�����&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td align="center" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��ǹ�ʴ�� �.�7. </td>
  <td width="333" align="left" valign="top">&nbsp;</td>
</tr>
<tr>
  <td align="right" valign="top">&nbsp;</td>
  <td align="left" valign="top">&nbsp;</td>
  <td colspan="2" align="left" valign="top"><span class="style6">�ҡ��ҹ�ѹ�֡㹪ͧ�ʴ��� ��.7 �к��йӢ����Ź���ʴ���� ��.7 ᷹</span></td>
  </tr>

<tr>
  <td align="right" valign="top">&nbsp;</td>
  <td align="left" valign="top">&nbsp;</td>
  <td align="right" valign="top" bgcolor="#A3B2CC">&nbsp;</td>
  <td align="left" valign="top">&nbsp;</td>
</tr>
<tr> 
<td align="right" valign="top" width="213">
   <b>�.�.</b>&nbsp;&nbsp;</td> 
<td width="142" align="left" valign="top"> 

<select name="yy" onChange="showValue(this);">
<?
$thisyear = date("Y") + 543;
$showYear=0;
$sq="select   yy    from  hr_absent  where id='$id' ";
$re=mysql_query($sq);
while($r=mysql_fetch_array($re)){
 $arr_insertedyy[$r[yy]] = $r[yy] ; 
}
for ($i=$thisyear;$i>=2470;$i--){
	if (( $arr_insertedyy[$i]  != "" )and  ($action !="edit2")){ continue ; } 
	if ($rs[yy] == $i){ 
		$showYear=$i;
		echo "<option selected>$i</option>";   
	} else{ 
		echo "<option   value='$i'>$i</option>";
	} # END if ($rs[yy] == $i){ 
} # end for 	($i=$thisyear;$i>=2470;$i--){

?>
</select>
<input type="hidden" name="value_yy" id="value_yy" value="<?=$showYear?>"  style="width:150px;" /></td>
<td width="254" align="right" valign="top" bgcolor="#A3B2CC">�.�.&nbsp;
  <input name="label_yy" id="label_yy" type="text" value="<?=$rs[label_yy]?>" size="20">
  <input  type="hidden" name="chk_yy"  id="chk_yy" value="true"  />
  <br></td>
<td align="left" valign="top"><span class="style6">㹡óժ�ͧ �.�.���ҡ���� 1 ��÷Ѵ<br>
  ������
  ����ͧ����<strong> , </strong>��� �� 23 �.�. 50<strong>,</strong>1 �.�. 51</span></td>
</tr>
<tr align="left" style="font-weight:bold;"> 
	<td align="right" >�һ���&nbsp;&nbsp;</td>
	<td><input type="text" name="sick" id="sick" size="10" value="<? if($rs[sick]==0){}else{echo $rs[sick];}?>" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ
	&nbsp;</td>
    <td align="right">�һ���&nbsp;
      <input name="label_sick" id="label_sick" type="text" value="<?=$rs[label_sick]?>" size="20" >
      <input  type="hidden" name="chk_sick"  id="chk_sick" value="true"  /></td>
    <td>&nbsp;</td>
</tr>


<tr align="left" style="font-weight:bold;">
  <td align="right">�Ҥ�ʹ�ص�&nbsp;&nbsp;</td>
  <td><input name="birth" type="text" value="<? if($rs[birth]==0){}else {echo $rs[birth]; }?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">
    &nbsp;&nbsp;�ѹ</td>
  <td align="right">
    <input name="label_birth" type="hidden" value="<?//=$rs[label_birth]?>" size="20" maxlength="50" ></td>
  <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
  <td align="right">��仪�������ҷ���ʹ�ص�&nbsp;&nbsp;</td>
  <td><input name="helpbirth" type="text" value="<? if($rs[helpbirth]==0){}else {echo $rs[helpbirth]; }?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">
    &nbsp;&nbsp;�ѹ</td>
  <td align="right">
    <input name="label_helpbirth" type="hidden" value="<?//=$rs[label_birth]?>" size="20" maxlength="50" ></td>
  <td>&nbsp;</td>
</tr>


<tr align="left" style="font-weight:bold;"> 
	<td align="right" bgcolor="#A3B2CC">�ҡԨ��ǹ���&nbsp;&nbsp;</td>
	<td><input type="text" name="duty" id="duty" size="10" value="<? if($rs[duty]==0){}else{echo $rs[duty];}?>" maxlength="4" onKeyPress=" return noSring(event);" onBlur="chkDutyVacation();">&nbsp;&nbsp;�ѹ</td>
    <td align="right">�ҡԨ��оѡ��͹&nbsp;
      <input name="label_dv" id="label_dv" type="text" value="<?=$rs[label_dv]?>" size="20" onBlur="chkDutyVacation();" ><span id='msg_value_dv' class='span_check'></span><span id='msg_label_dv' class='span_check'></span>
      <input  type="hidden" name="chk_dv"  id="chk_dv" value="true"  /></td>
    <td bgcolor="#A3B2CC">&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;"> 
	<td align="right" bgcolor="#A3B2CC">�Ҿѡ��͹&nbsp;&nbsp;</td>
	<td><input type="text" name="vacation" id="vacation" size="10" value="<? if($rs[vacation]==0){}else{ echo $rs[vacation];}?>" maxlength="4" onKeyPress=" return noSring(event);" onBlur="chkDutyVacation();">&nbsp;&nbsp;�ѹ
	  <input type="hidden" name="value_dv" id="value_dv" value=""  style="width:150px;" /></td>
      <td bgcolor="#A3B2CC">&nbsp;</td>
      <td bgcolor="#A3B2CC">&nbsp;</td>
    </tr>	
    
<tr align="left" style="font-weight:bold;">
	<td align="right">�Ҿ���� ( �һ�Сͺ�Ըա����ҧ��ʹ� )&nbsp;&nbsp;</td>
	<td><input name="etc" type="text" id="etc" value="<? if($rs[etc]==0){}else{echo $rs[etc];}?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ
	 <input name="label_etc" type="hidden" value="<?=$rs[label_etc]?>" size="20" maxlength="50">	</td>
     <td></td>
     <td bgcolor="#A3B2CC">&nbsp;</td>
</tr>

<tr align="left" style="font-weight:bold;">
	<td align="right">������Ѻ��õ�Ǩ���͡��������Ѻ����������&nbsp;&nbsp;</td>
	<td><input name="soldier" type="text" id="soldier" value="<? if($rs[soldier]==0){}else{echo $rs[soldier];}?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ</td>
     <td></td>
     <td bgcolor="#A3B2CC">&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
	<td align="right">���֡�ҵ�� �֡ͺ�� ��Ժѵԡ���Ԩ�� ���ʹ٧ҹ&nbsp;&nbsp;</td>
	<td><input name="eduday" type="text" id="eduday" value="<? if($rs[eduday]==0){}else{echo $rs[eduday];}?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ</td>
     <td></td>
     <td bgcolor="#A3B2CC">&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
	<td align="right">��任�Ժѵԧҹ�ͧ��������ҧ�����&nbsp;&nbsp;</td>
	<td><input name="gointer" type="text" id="gointer" value="<? if($rs[gointer]==0){}else{echo $rs[gointer];}?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ</td>
     <td></td>
     <td bgcolor="#A3B2CC">&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
	<td align="right">�ҵԴ����������&nbsp;&nbsp;</td>
	<td><input name="gomarry" type="text" id="gomarry" value="<? if($rs[gomarry]==0){}else{echo $rs[gomarry];}?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ</td>
     <td></td>
     <td bgcolor="#A3B2CC">&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
	<td align="right">��仿�鹿����ö�Ҿ��ҹ�Ҫվ&nbsp;&nbsp;</td>
	<td><input name="upskill" type="text" id="upskill" value="<? if($rs[upskill]==0){}else{echo $rs[upskill];}?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ</td>
     <td></td>
     <td bgcolor="#A3B2CC">&nbsp;</td>
</tr>
    			
<tr align="left" style="font-weight:bold;"> 
	<td align="right">�����&nbsp;&nbsp;</td>
	<td><input name="late" type="text" id="late" value="<? if($rs[late]==0){}else{echo $rs[late]; }?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ</td>
    <td align="right">�����&nbsp;
      <input name="label_late" id="label_late" type="text" value="<?=$rs[label_late]?>" size="20" >
      <input  type="hidden" name="chk_late"  id="chk_late" value="true"  /></td>
    <td valign="top">&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;"> 
	<td align="right">�Ҵ�Ҫ���&nbsp;&nbsp;</td>
	<td><input type="text" name="absent" id="absent" size="10" value="<? if($rs[absent]==0){}else{echo $rs[absent]; }?>" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ</td>
    <td align="right">�Ҵ�Ҫ���&nbsp;
      <input name="label_absent" id="label_absent" type="text" value="<?=$rs[label_absent]?>" size="20" >
      <input  type="hidden" name="chk_absent"  id="chk_absent" value="true"  /></td>
    <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
	<td align="right"></td>
	<td></td>
    <td align="right">���֡�ҵ��
      <input name="label_education2" type="text" value="<?=$rs[label_education]."". $rs[other_absent];?>" size="20"  width="20" >
      <input name="other_absent" type="hidden"  value="<?//=$rs[other_absent]?>" size="20">   </td>
    <td>
    <input name="submenu_id" id="submenu_id" type="hidden" size="50" value="" >
    <input name="subject_error" id="subject_error" type="hidden" size="50" value="" >
    <input name="value_key_error" id="value_key_error" type="hidden" size="50" value="" >
    <input name="label_key_error" id="label_key_error" type="hidden" size="50" value="" >
    &nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
  <td align="right">&nbsp;</td>
  <td colspan="2" align="center">�ó��͡�Ҫ������ǡ�Ѻ����Ѻ�Ҫ�������</td>
  <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
  <td align="right">&nbsp;</td>
  <td colspan="2" align="center"><input name="special_exp" type="text" value="<?=$rs[special_exp];?>" size="50"></td>
  <td>&nbsp;</td>
</tr>
<script>
	sumDV();
</script>
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
    <td colspan="2" align="left">���֡�ҵ�� </td>
    <td width="438">&nbsp;</td>
  </tr>
  <tr align="left" style="font-weight:bold;">
    <td colspan="3" align="right"><span class="style6">**�ҡ��ͧ�������ͧ���֡�ҵ���ʴ��ѹ���֡���� &quot;���֡�ҵ��&quot; ��͡��� �.�.7 ������͡ 1- 01- xxxx - 31-12- xxxx </span></td>
    </tr>
  <tr align="left" style="font-weight:bold;">
    <td width="14" align="right">&nbsp;</td>
    <td width="156" align="right">�ѹ ��͹ �� �������&nbsp;&nbsp; </td>
    <td> �ѹ���
      <select name="d_start_edu" id="d_start_edu" onChange="check_date('d_start_edu','m_start_edu','y_start_edu');"> </select>
	 
          <? /*<option value="">����к�</option>
for ($i=1;$i<=31;$i++){
	if($d_start==sprintf("%02d",$i)){
	echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option value=\"".sprintf("%02d",$i)."\" >" .  sprintf("%02d",$i) . "</option>";
	}
}*/
?>
       
      ��͹
  <select name="m_start_edu" id="m_start_edu" onChange="check_date('d_start_edu','m_start_edu','y_start_edu');"></select>
  
    <? /*<option value="">����к�</option>
for ($i=1;$i<=12;$i++){
		if($m_start==sprintf("%02d",$i)){
		echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
		}else{
		echo "<option value=\"".sprintf("%02d",$i)."\">" .  sprintf("%02d",$i) . "</option>";
		}
	}*/
?>
  
      ��
  <select name="y_start_edu"  id="y_start_edu" onChange="check_date('d_start_edu','m_start_edu','y_start_edu');" ></select>
  
    <? /*<option value="">����к�</option>
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
  <span class="style6">�������ԧʶԵ� </span></td>
  </tr>
  <tr align="left" style="font-weight:bold;">
    <td align="right">&nbsp;</td>
    <td align="right">�ѹ ��͹ �� ����ش&nbsp;&nbsp;</td>
    <td>�ѹ���
      <select name="d_end_edu"  id="d_end_edu" onChange="check_date('d_end_edu','m_end_edu','y_end_edu');"> </select>
	  
          <?/* <option value="">����к�</option>
for ($i=1;$i<=31;$i++){
	if($d_end==sprintf("%02d",$i)){
		echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option value=\"".sprintf("%02d",$i)."\" >" .  sprintf("%02d",$i) . "</option>";
	}
}*/
?>
       
      ��͹
  <select name="m_end_edu" id="m_end_edu" onChange="check_date('d_end_edu','m_end_edu','y_end_edu');"></select>
  
    <?
/*    <option value="">����к�</option>
for ($i=1;$i<=12;$i++){
		if($m_end==sprintf("%02d",$i)){
		echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
		}else{
		echo "<option value=\"".sprintf("%02d",$i)."\">" .  sprintf("%02d",$i) . "</option>";
		}
	}*/
?>
  
      ��
  <select name="y_end_edu" id="y_end_edu" onChange="check_date('d_end_edu','m_end_edu','y_end_edu');"></select>
 
    <? 
/*	<option value="">����к�</option>
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
  <span class="style6">�������ԧʶԵ� </span></td>
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
	<input type="hidden" name="old_yy" value="<?=$rs[yy]?>">
	<input type="submit" name="send" value="�ѹ�֡" style="width:90px;">
	<input type="button" name="Button" value="¡��ԡ" onClick="location.href='?action=view'">
	<input type="button" name="Button" value="��Ѻ˹���á" onClick="location.href='absent_all_1.php?'">
	</td>
</tr>
</table>
</form>
<?
	}
	if($action=="add"){
?>



<form method="post" name="post"  action="<?=$PHP_SELF?>"  onSubmit="return ch();" >
<input type="hidden" name="day" value="<?=$days?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="yy" value="<?=$array_day?>">
<input type="hidden" name="action" value="add">
<!--���͡��&nbsp;<input name="ch_year" type="radio" value="0" checked  onClick="onSelect('0','Posdate');">����� �<input name="ch_year" type="radio" value="1"   onClick="onSelect('1','Posyear');">
���֡�ҵ��
--><input type="hidden" name="ch_year" value="0">

<!--<div id='Posyear' style="display:block;">	
--><table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
<tr>
  <td align="right" valign="top">&nbsp;</td>
  <td align="left" valign="top">&nbsp;��ǹ�ʴ���¡�â�����&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td align="center" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��ǹ�ʴ�� �.�7. </td>
  <td width="329" align="left" valign="top">&nbsp;</td>
</tr>
<tr>
  <td align="right" valign="top">&nbsp;</td>
  <td align="left" valign="top">&nbsp;</td>
  <td colspan="2" align="left" valign="top"><span class="style6">�ҡ��ҹ�ѹ�֡㹪ͧ�ʴ��� ��.7 �к��йӢ����Ź���ʴ���� ��.7 ᷹</span></td>
  </tr>

<tr>
  <td align="right" valign="top">&nbsp;</td>
  <td align="left" valign="top">&nbsp;</td>
  <td align="right" valign="top" bgcolor="#A3B2CC">&nbsp;</td>
  <td align="left" valign="top">&nbsp;</td>
</tr>
<tr> 
<td align="right" valign="top" width="242">
   <b>�.�.</b>&nbsp;&nbsp;</td> 
<td width="136" align="left" valign="top"> 

<select name="yy" onChange="showValue(this);">
<?
$thisyear = date("Y") + 543;
$sq="select   yy    from  hr_absent  where id='$id' ";
$re=mysql_query($sq);
while($r=mysql_fetch_array($re)){
 $arr_insertedyy[$r[yy]] = $r[yy] ; 
}
$ab=0;
for ($i=$thisyear;$i>=2470;$i--){
	if (( $arr_insertedyy[$i]  != "" )and  ($action !="edit2")){ continue ; } 
	if ($rs[yy] == $i){ 
		$showYear=$i;
		echo "<option selected>$i</option>";   
	} else{ 
		if($ab==0){
				$showYear=$i;
				$ab++;
		}
		echo "<option  value='$i'>$i</option>";
	} # END if ($rs[yy] == $i){ 
} # end for 	($i=$thisyear;$i>=2470;$i--){

?>
</select>
<input type="hidden" name="value_yy" id="value_yy" value="<?=$showYear?>"  style="width:150px;" /></td>
<td width="251" align="right" valign="top" bgcolor="#A3B2CC">�.�.&nbsp;
  <input name="label_yy" id="label_yy" type="text" value="<?=$rs[label_yy]?>" size="20">
  <input  type="hidden" name="chk_yy"  id="chk_yy" value="true"  />
  <br></td>
<td align="left" valign="top"><span class="style6">㹡óժ�ͧ �.�.���ҡ���� 1 ��÷Ѵ<br>
  ������
  ����ͧ����<strong> , </strong>��� �� 23 �.�. 50<strong>,</strong>1 �.�. 51</span></td>
</tr>
<tr align="left" style="font-weight:bold;"> 
	<td align="right" >�һ���&nbsp;&nbsp;</td>
	<td><input type="text" name="sick" id="sick" size="10" value="<? if($rs[sick]==0){}else{echo $rs[sick];}?>" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ
	&nbsp;</td>
    <td align="right">�һ���&nbsp;
      <input name="label_sick" id="label_sick" type="text" value="<?=$rs[label_sick]?>" size="20" >
      <input  type="hidden" name="chk_sick"  id="chk_sick" value="true"  /></td>
    <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
  <td align="right">�Ҥ�ʹ&nbsp;&nbsp;</td>
  <td><input name="birth" id="birth" type="text" value="<? if($rs[birth]==0){echo $rs[birth];}else {echo $rs[birth]; }?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">
    &nbsp;&nbsp;�ѹ</td>
  <td align="right">
    <input name="label_birth" type="hidden" value="<?//=$rs[label_birth]?>" size="20" maxlength="50" onKeyPress=" return noSring(event);"></td>
  <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
  <td align="right">��仪�������ҷ���ʹ�ص�&nbsp;&nbsp;</td>
  <td><input name="helpbirth" type="text" value="<? if($rs[helpbirth]==0){echo $rs[helpbirth];}else {echo $rs[helpbirth]; }?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">
    &nbsp;&nbsp;�ѹ</td>
  <td align="right">
    <input name="label_helpbirth" type="hidden" value="<?//=$rs[label_birth]?>" size="20" maxlength="50" ></td>
  <td>&nbsp;</td>
</tr>

<tr align="left" style="font-weight:bold;"> 
	<td align="right" bgcolor="#A3B2CC">�ҡԨ��ǹ���&nbsp;&nbsp;</td>
	<td><input type="text" name="duty" id="duty" size="10" value="<? if($rs[duty]==0){}else{echo $rs[duty];}?>" maxlength="4" onKeyPress=" return noSring(event);" onBlur="chkDutyVacation();">&nbsp;&nbsp;�ѹ</td>
    <td align="right">�ҡԨ��оѡ��͹&nbsp;
      <input name="label_dv" id="label_dv" type="text" value="<?=$rs[label_dv]?>" size="20" onBlur="chkDutyVacation();"><span id='msg_value_dv' class='span_check'></span><span id='msg_label_dv' class='span_check'></span>
      <input  type="hidden" name="chk_dv"  id="chk_dv" value="true"  /></td>
    <td bgcolor="#A3B2CC">&nbsp;</td>
    <td bgcolor="#A3B2CC">&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;"> 
	<td align="right" bgcolor="#A3B2CC">�Ҿѡ��͹&nbsp;&nbsp;</td>
	<td><input type="text" name="vacation" id="vacation" size="10" value="<? if($rs[vacation]==0){}else{ echo $rs[vacation];}?>" maxlength="4" onKeyPress=" return noSring(event);" onBlur="chkDutyVacation();">&nbsp;&nbsp;�ѹ
	  <input type="hidden" name="value_dv" id="value_dv" value=""  style="width:150px;" /></td>
      <td bgcolor="#A3B2CC">&nbsp;</td>
    </tr>
<tr align="left" style="font-weight:bold;">
	<td align="right">�Ҿ���� ( �һ�Сͺ�Ըա����ҧ��ʹ� )&nbsp;&nbsp;</td>
	<td><input name="etc" type="text" id="etc" value="<? if($rs[etc]==0){}else{echo $rs[etc];}?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ
	 <input name="label_etc" type="hidden" value="<?=$rs[label_etc]?>" size="20" maxlength="50">	</td>
     <td bgcolor="#A3B2CC">&nbsp;</td>
     <td bgcolor="#A3B2CC">&nbsp;</td>
     </tr>
     <tr align="left" style="font-weight:bold;">
	<td align="right">������Ѻ��õ�Ǩ���͡��������Ѻ����������&nbsp;&nbsp;</td>
	<td><input name="soldier" type="text" id="soldier" value="<? if($rs[soldier]==0){}else{echo $rs[soldier];}?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ</td>
     <td></td>
     <td bgcolor="#A3B2CC">&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
	<td align="right">���֡�ҵ�� �֡ͺ�� ��Ժѵԡ���Ԩ�� ���ʹ٧ҹ&nbsp;&nbsp;</td>
	<td><input name="eduday" type="text" id="eduday" value="<? if($rs[eduday]==0){}else{echo $rs[eduday];}?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ</td>
     <td></td>
     <td bgcolor="#A3B2CC">&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
	<td align="right">��任�Ժѵԧҹ�ͧ��������ҧ�����&nbsp;&nbsp;</td>
	<td><input name="gointer" type="text" id="gointer" value="<? if($rs[gointer]==0){}else{echo $rs[gointer];}?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ</td>
     <td></td>
     <td bgcolor="#A3B2CC">&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
	<td align="right">�ҵԴ����������&nbsp;&nbsp;</td>
	<td><input name="gomarry" type="text" id="gomarry" value="<? if($rs[gomarry]==0){}else{echo $rs[gomarry];}?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ</td>
     <td></td>
     <td bgcolor="#A3B2CC">&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
	<td align="right">��仿�鹿����ö�Ҿ��ҹ�Ҫվ&nbsp;&nbsp;</td>
	<td><input name="upskill" type="text" id="upskill" value="<? if($rs[upskill]==0){}else{echo $rs[upskill];}?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ</td>
     <td></td>
     <td bgcolor="#A3B2CC">&nbsp;</td>
</tr>
     
     
<tr align="left" style="font-weight:bold;"> 
	<td align="right">�����&nbsp;&nbsp;</td>
	<td><input name="late" type="text" id="late" value="<? if($rs[late]==0){}else{echo $rs[late]; }?>" size="10" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ</td>
    <td align="right">�����&nbsp;
      <input name="label_late" id="label_late" type="text" value="<?=$rs[label_late]?>" size="20" >
      <input  type="hidden" name="chk_late"  id="chk_late" value="true"  /></td>
    <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;"> 
	<td align="right">�Ҵ�Ҫ���&nbsp;&nbsp;</td>
	<td><input type="text" name="absent" id="absent" size="10" value="<? if($rs[absent]==0){}else{echo $rs[absent]; }?>" maxlength="4" onKeyPress=" return noSring(event);">&nbsp;&nbsp;�ѹ</td>
    <td align="right">�Ҵ�Ҫ���&nbsp;
      <input name="label_absent" id="label_absent" type="text" value="<?=$rs[label_absent]?>" size="20" >
      <input  type="hidden" name="chk_absent"  id="chk_absent" value="true"  /></td>
    <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
	<td align="right"></td>
	<td></td>
    <td align="right">���֡�ҵ��
      <input name="label_education" type="text" size="20"  width="20" >
      <input name="other_absent" type="hidden"  value="<?//=$rs[other_absent]?>">   </td>
    <td>
    <input name="submenu_id" id="submenu_id" type="hidden" size="50" value="" >
    <input name="subject_error" id="subject_error" type="hidden" size="50" value="" >
    <input name="value_key_error" id="value_key_error" type="hidden" size="50" value="" >
    <input name="label_key_error" id="label_key_error" type="hidden" size="50" value="" >
    &nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
  <td align="right">&nbsp;</td>
  <td colspan="2" align="center">�ó����͡���ǡ�Ѻ����Ѻ�Ҫ������� </td>
  <td>&nbsp;</td>
</tr>
<tr align="left" style="font-weight:bold;">
  <td align="right">&nbsp;</td>
  <td colspan="2" align="center"><input name="special_exp" type="text" value="<?=$rs[special_exp];?>" size="50" >
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
    <td colspan="2" align="left">���֡�ҵ��</td>
    <td width="440">&nbsp;</td>
  </tr>
  <tr align="left" style="font-weight:bold;">
    <td colspan="3"><span class="style6">**�ҡ��ͧ�������ͧ���֡�ҵ���ʴ��ѹ���֡���� &quot;���֡�ҵ��&quot; ��͡��� �.�.7  ������͡ 1- 01- xxxx - 31-12- xxxx </span></td>
    </tr>
  <tr align="left" style="font-weight:bold;">
    <td width="27" align="right">&nbsp;</td>
    <td width="135" align="right">�ѹ ��͹ �� �������&nbsp;&nbsp; </td>
    <td>
	
	 �ѹ���
      <select name="d_start_edu" id="d_start_edu" onChange="check_date('d_start_edu','m_start_edu','y_start_edu');">
      </select>
      <? /*<option value="">����к�</option>
for ($i=1;$i<=31;$i++){
	if($d_start==sprintf("%02d",$i)){
	echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option value=\"".sprintf("%02d",$i)."\" >" .  sprintf("%02d",$i) . "</option>";
	}
}*/
?>
��͹
<select name="m_start_edu" id="m_start_edu" onChange="check_date('d_start_edu','m_start_edu','y_start_edu');">
</select>
<? /*<option value="">����к�</option>
for ($i=1;$i<=12;$i++){
		if($m_start==sprintf("%02d",$i)){
		echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
		}else{
		echo "<option value=\"".sprintf("%02d",$i)."\">" .  sprintf("%02d",$i) . "</option>";
		}
	}*/
?>
��
<select name="y_start_edu"  id="y_start_edu" onChange="check_date('d_start_edu','m_start_edu','y_start_edu');" >
</select>
<? /*<option value="">����к�</option>
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
<span class="style6">�������ԧʶԵ� </span></td>
  </tr>
  <tr align="left" style="font-weight:bold;">
    <td align="right">&nbsp;</td>
    <td align="right">�ѹ ��͹ �� ����ش&nbsp;&nbsp;</td>
    <td> �ѹ���
      <select name="d_end_edu"  id="d_end_edu" onChange="check_date('d_end_edu','m_end_edu','y_end_edu');">
      </select>
      <?/* <option value="">����к�</option>
for ($i=1;$i<=31;$i++){
	if($d_end==sprintf("%02d",$i)){
		echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option value=\"".sprintf("%02d",$i)."\" >" .  sprintf("%02d",$i) . "</option>";
	}
}*/
?>
��͹
<select name="m_end_edu" id="m_end_edu" onChange="check_date('d_end_edu','m_end_edu','y_end_edu');">
</select>
<?
/*    <option value="">����к�</option>
for ($i=1;$i<=12;$i++){
		if($m_end==sprintf("%02d",$i)){
		echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
		}else{
		echo "<option value=\"".sprintf("%02d",$i)."\">" .  sprintf("%02d",$i) . "</option>";
		}
	}*/
?>
��
<select name="y_end_edu" id="y_end_edu" onChange="check_date('d_end_edu','m_end_edu','y_end_edu');">
</select>
<? 
/*	<option value="">����к�</option>
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
<span class="style6">�������ԧʶԵ� </span></td>
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
		<input type="hidden" name="old_yy" value="<?=$rs[yy]?>">
	<input type="submit" name="send" value="�ѹ�֡" style="width:90px;">
		<input type="button" name="Button" value="¡��ԡ" onClick="location.href='?action=view'">
		<input type="button" name="Button" value="��Ѻ˹���á" onClick="location.href='absent_all_1.php?'">
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

<script>
aaa="abc";
//alert(aaa.search('b'));
function chkDutyVacation(){
		duty=$('#duty').val();
		vacation=$('#vacation').val();
		label_dv=$('#label_dv').val();
		//value_dv=$('#value_dv').val();
		duty=duty.replace(/ /g,"");
		vacation=vacation.replace(/ /g,"");
		label_dv=label_dv.replace(/ /g,"");
		
		dutyStr="�";
		vacationStr="�";
		DT=$('#duty').val()*1;
		VA=$('#vacation').val()*1;
		$('#value_dv').val(DT+VA);
		value_dv=$('#value_dv').val();
		
		valueDuty='';
		valueVacation='';
		var digit=/^[0-9�-�.]+$/ // number
		if(label_dv!=''){		// if label is not empty
				if(value_dv=='' || value_dv=='0'){	// if value is empty
						$('#msg_'+'label_dv').html(check_false);	
						$('#'+'chk_dv').val('false');
				}else{
						if(label_dv.search(digit)!=-1){ //if match true ( �繵���Ţ��� string )
								//alert("number");								
								if((DT+VA)!=0){
										check_values_label('value_dv','label_dv','values','number',"chk_dv");
										check_values_label('label_dv','value_dv','label','number',"chk_dv");
								}
								
						}else{
								//alert("not number");
								
								label_dv=label_dv.replace(/�ѡ/g,"XXX");
								dutyPosition=label_dv.search(dutyStr);
								
								if(label_dv.search("XXX")!=-1){
										vacationPosition=label_dv.search('XXX');
										vacationStr="XXX";
								}else{
										vacationPosition=label_dv.search(vacationStr);
								}
								
								if(dutyPosition < vacationPosition){	// �ҡԨ �����͹ �ѡ��͹
										//alert('T1');
										tempArr=label_dv.split("");
										if(dutyPosition!=-1){		// �� � 
												if(dutyPosition==0){		// �� � �繵���á�ͧ string
														arrV=label_dv.split(vacationStr);
														valueDuty=getNumberFromText(arrV[0]);
														valueVacation=getNumberFromText(arrV[1]);
												}else{
														if(tempArr[(dutyPosition-1)].search(digit)!=-1){ //if match true ( �繵���Ţ��� string )
																arrV=label_dv.split(dutyStr);
																valueDuty=getNumberFromText(arrV[0]);
																valueVacation=getNumberFromText(arrV[1]);
														}else{
																arrV=label_dv.split(vacationStr);
																valueDuty=getNumberFromText(arrV[0]);
																valueVacation=getNumberFromText(arrV[1]);
														}
												}
										}else{		// ����� �
												//arrV=label_dv.split(vacationStr);
												//valueDuty=getNumberFromText(arrV[1]);												
												//valueVacation=getNumberFromText(arrV[0]);
												
												/*valueDuty='';
												valueVacation=getNumberFromText(label_dv);*/
												
												if(vacationPosition==0){ // �� � �繵���á�ͧ string
														valueDuty='';
														valueVacation=getNumberFromText(label_dv);
												}else{
														if(tempArr[(vacationPosition-1)].search(digit)!=-1){ //if match true ( �繵���Ţ��� string )
																arrV=label_dv.split(vacationStr);
																valueVacation=getNumberFromText(arrV[0]);
																valueDuty='';
														}else{
																arrV=label_dv.split(vacationStr);
																valueVacation=getNumberFromText(arrV[1]);
																valueDuty='';
														}
												}
										}										
										//alert(valueDuty+"--"+valueVacation);
										if(valueDuty==duty  &&  valueVacation==vacation){	// check �ҡԨ ��� �ѡ��͹ ��ҡѹ�Ѻ label
												$('#msg_'+'label_dv').html(check_true);	
												$('#'+'chk_dv').val('true');
										}else{
												$('#msg_'+'label_dv').html(check_false);	
												$('#'+'chk_dv').val('false');
										}
								}else if(dutyPosition > vacationPosition){	// �ѡ��͹ �����͹ �ҡԨ
										//alert('T2');
										tempArr=label_dv.split("");
										if(vacationPosition!=-1){  // �� �
												if(vacationPosition==0){  // �� � �繵���á�ͧ string
														arrV=label_dv.split(dutyStr);
														valueVacation=getNumberFromText(arrV[0]);
														valueDuty=getNumberFromText(arrV[1]);
												}else{
														if(tempArr[(vacationPosition-1)].search(digit)!=-1){ //if match true ( �繵���Ţ��� string )
																arrV=label_dv.split(vacationStr);
																valueVacation=getNumberFromText(arrV[0]);
																valueDuty=getNumberFromText(arrV[1]);
														}else{
																arrV=label_dv.split(dutyStr);
																valueVacation=getNumberFromText(arrV[0]);
																valueDuty=getNumberFromText(arrV[1]);
														}
												}
										}else{
												//arrV=label_dv.split(dutyStr);
												//valueVacation=getNumberFromText(arrV[0]);												
												//valueDuty=getNumberFromText(arrV[1]);
												
												/*valueVacation='';
												valueDuty=getNumberFromText(label_dv);*/
												
												if(dutyPosition==0){ // �� � �繵���á�ͧ string
														valueVacation='';
														valueDuty=getNumberFromText(label_dv);
												}else{
														if(tempArr[(dutyPosition-1)].search(digit)!=-1){ //if match true ( �繵���Ţ��� string )
																arrV=label_dv.split(dutyStr);
																valueVacation='';
																valueDuty=getNumberFromText(arrV[0]);
														}else{
																arrV=label_dv.split(dutyStr);
																valueVacation=='';
																valueDuty=getNumberFromText(arrV[1]);
														}
												}
										}										
										//alert(valueDuty+"--"+valueVacation);
										if(valueDuty==duty  &&  valueVacation==vacation){	// check �ҡԨ ��� �ѡ��͹ ��ҡѹ�Ѻ label
												$('#msg_'+'label_dv').html(check_true);	
												$('#'+'chk_dv').val('true');
										}else{
												$('#msg_'+'label_dv').html(check_false);	
												$('#'+'chk_dv').val('false');
										}
								}else{		// ����շ��  �  ���  �
										label_dvValueTemp=0;
										if(label_dv.search(/\+/)!=-1){
												arrTempPlus=label_dv.split("+");
												for(ip=0;ip<arrTempPlus.length;ip++){
														label_dvValueTemp+=(getNumberFromText(arrTempPlus[ip])*1);
												}
										}else{
												label_dvValueTemp=getNumberFromText(label_dv);
										}
										
										if(value_dv==label_dvValueTemp){	// ����� ��ҡѹ
												$('#msg_'+'label_dv').html(check_true);	
												$('#'+'chk_dv').val('true');
										}else{
												$('#msg_'+'label_dv').html(check_false);	
												$('#'+'chk_dv').val('false');
										}
								}								
						}
				}
		}else{
				$('#msg_'+'label_dv').html('');	
				$('#'+'chk_dv').val('true');
		}
}

// function ���੾�е���Ţ㹪ش��ͤ������
function getNumberFromText(num){
		var digit=/^[0-9�-�.]+$/ // number
		numberStr='';
		//alert(num);
		if(num){
				arr=num.split("");
				for(i=0;i<arr.length;i++){
						if(arr[i].search(digit)!=-1){
								numberStr=numberStr+replaceCharThai(arr[i]);
						}
				}
				if(numberStr.substr(0,1)=='.'){
						numberStr=numberStr.substr(1,numberStr.length);
				}
				
				if(numberStr.substr((numberStr.length-1),numberStr.length)=='.'){
						numberStr=numberStr.substr(0,(numberStr.length-1));
				}
				return numberStr;
		}else{
				return '';
		}
}

// function ����¹�ҡ����Ţ�� �繵���Ţ���Һԡ
function replaceCharThai(str){
		temp='';
		switch(str){
				case '�':
						temp='0';
						break;
				case '�':
						temp='1';
						break;
				case '�':
						temp='2';
						break;
				case '�':
						temp='3';
						break;
				case '�':
						temp='4';
						break;
				case '�':
						temp='5';
						break;
				case '�':
						temp='6';
						break;
				case '�':
						temp='7';
						break;
				case '�':
						temp='8';
						break;
				case '�':
						temp='9';
						break;
				default:
						temp=str;
		}
		return temp;
}
</script>