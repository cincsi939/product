<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_salary";
$module_code 		= "salary"; 
$process_id			= "salary";
$VERSION 				= "9.1";
$BypassAPP 			= true;
$menumode=5;
#########################################################
#Developer::
#DateCreate::17/07/2007
#LastUpdate::13/02/2009
#DatabaseTabel::
#END
#########################################################
session_start();


include("../libary/function.php");
include("inc/libary.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include("../../../config/phpconfig.php");
include("../../../common/class-date-format.php");
include("../../../common/function_kp7_logerror.php");
include("../../../common/function_position.php");

if($_GET[debug]=='on'){
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
}

#$_SESSION[session_staffid]=57; # สำหรับทดสอบการบันทึกข้อมูลอิเล็กทรอนิกส์
$idcard=$_SESSION[idoffice];
$staffid=$_SESSION[session_staffid];
 $_GET['id']= $_SESSION[id];
 $_POST['id']= $_SESSION[id];
 
 
 
 ### ตรวจสอบการแก้ไขข้อมูลโดยเจ้าหน้าที่เขต
$useredit =  CheckUserAreaEdit($_SESSION[secid]);
?>

<script>
//  ตัวแปรที่กำหนดว่าเป็นรหัสของ 38 ค (2)
var  strType38="5";
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>application list</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<?

// =====Constant ===============

/*
echo "<pre>";
print_r($namevit);
echo "</pre>";
*/
//===========================
$ip_check=substr($_SERVER["REMOTE_ADDR"],0,8);
if(($ip_check == "192.168.") or ($ip_check == "127.0.0.") or ($_SESSION[userkeyin])){
$intraip_st = true;
}else{
$intraip_st = false;
}
/*$arr_type_day=array('d ดดดดดดด YY','d ดดด YY','ว ดดด ปป','d ดดดด YYYY','d ดดดด YY','d ดดดด พ.ศ. YY','d ดดดด พ.ศ.YYYY','ว ดดดด พ.ศ.ปป','ว ดดดด  พ.ศ.ปปปป','ว ดดดด ปปปป','d ดดด YYYY','ว ดดด ปปปป','ว ดดด พ.ศ. ปปปป','ว ดดด พ.ศ. ปป','d ดดด พ.ศ. YYYY','d ดดด พ.ศ.YY','d ดดดดด YY','ว ดดดดด ปป','d ดดดดด YYYY','ว ดดดดด ปปปป','ว ดดดดด พ.ศ. ปปปป','ว ดดดดด พ.ศ. ปป','d ดดดดด พ.ศ. YYYY','d ดดดดด พ.ศ. YY','d ดดดดดด YY','ว ดดดดดด ปป','d ดดดดดด YYYY','ว ดดดดดด ปปปป','ว ดดดดดด พ.ศ. ปปปป','ว ดดดดดด พ.ศ. ปป','d ดดดดดด พ.ศ. YYYY','d ดดดดดด พ.ศ. YY');*/
$arr_type_day=array('d ดดดดดดด YY','d ดดด YY','ว ดดด ปป','d ดดดด YYYY','d ดดดด YY','ว ดดดด ปปปป','d ดดด YYYY','ว ดดด ปปปป','d ดดดดด YY','ว ดดดดด ปป','d ดดดดด YYYY','ว ดดดดด ปปปป','d ดดดดด พ.ศ. YY','d ดดดดดด YY','ว ดดดดดด ปป','d ดดดดดด YYYY','ว ดดดดดด ปปปป','ว ดดดดดด พ.ศ. ปปปป','ว ดดดดดด พ.ศ. ปป','d ดดดดดด พ.ศ. YYYY','d ดดดดดด พ.ศ. YY','ว ดดดดดดด ปปปป','d ดดดดดดด YYYY');

$salary=str_replace(',',"",$salary);



function option_day($sent_day,$select_day){
global $arr_type_day; 
$b_day1 = new date_format;
echo "<select name='sent_day'>";
		echo "<option value=''>ไม่ระบุ</option>";
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
echo "<option value=''>ไม่ระบุ</option>";
		foreach($arr_type_day as $val){
		$xday=$b_day1->show_date($val,$sent_day1);
			echo "<option value='$xday'> $xday</option>";
		}	
	echo "</select>";
}

function setorder_type($order_type,$lv,$schoolid,$school_label,$school_name){
    if($order_type==1||$order_type==2||$order_type==7||$order_type==8||$order_type==9||$order_type==18){
        $lv="";
       if($schoolid!=""){
         //$school_label="";   
       }else{
        $school_label=$school_name;   
       }  
    }elseif($order_type==4){        
        $schoolid="";
        $school_label="";
    }else{
        $lv="";
        $schoolid="";
        $school_label="";
    }
    return "$order_type|$lv|$schoolid|$school_label";
}

function savevitaya($salary_id,$idcard,$vataya_id,$date_start,$noorder,$dateorder){
  global $dbname,$dbnamemaster,	$vitaya_major_id,	$vitaya_work,$vitaya_work_type; 
  

    $sql_major = "SELECT majorcode as id, majorname as value  FROM major_reqvitaya where majorcode='$vitaya_major_id'";
    $result_major = mysql_db_query($dbnamemaster,$sql_major);
    $row_major = mysql_fetch_assoc($result_major);
    $vitaya_major=$row_major[value];
  
    $sql_vitaya = "SELECT runid,vitayaname,orderby FROM vitaya where runid='$vataya_id'";
    $result_vitaya = mysql_db_query($dbnamemaster,$sql_vitaya);
    $rs_vitaya = mysql_fetch_assoc($result_vitaya);
    $vitaya = $rs_vitaya[vitayaname];   
  if($vataya_id==""){   //เลือกไม่ระบุ  จะลบข้อมูล
    $sql_sel = "select COUNT(id) AS COUNTN   FROM vitaya_stat WHERE id='$idcard' and salary_id='$salary_id' ";
    $result_sel = mysql_db_query($dbname,$sql_sel);
    $rs_COUNT = mysql_fetch_assoc($result_sel);
    if($rs_COUNT[COUNTN]>0){
       $sql_del = "DELETE FROM vitaya_stat WHERE id='$idcard' and salary_id='$salary_id' ";
        mysql_db_query($dbname,$sql_del);
    }        
  }else{
     $resultx1 = mysql_db_query($dbname," SELECT  *  FROM  vitaya_stat  WHERE   id ='$idcard'  AND  (vitaya_id = '$vataya_id' or name='$vitaya') ");   
     $numrow =mysql_num_rows($resultx1);
     if($numrow>0){
         $sql="update vitaya_stat set 
          vitaya_id = '$vataya_id' ,
          name='$vitaya' ,
          date_start = '$date_start', 
          date_command = '$dateorder', 
          salary_id='$salary_id',
		  vitaya_major_id='$vitaya_major_id',
		  vitaya_major='$vitaya_major',	
		  vitaya_work='$vitaya_work',
		  vitaya_work_type='$vitaya_work_type',
		  remark='$noorder' where id='$idcard' AND  (vitaya_id = '$vataya_id' or name='$vitaya')";
     }else{
         $sql="insert into vitaya_stat set 
          vitaya_id = '$vataya_id' ,
          name='$vitaya' ,
          date_start = '$date_start', 
          date_command = '$dateorder', 
          salary_id='$salary_id',
          remark='$noorder' ,
          id='$idcard',
		  vitaya_major_id='$vitaya_major_id',
		  vitaya_major='$vitaya_major',	
		  vitaya_work='$vitaya_work',
		  vitaya_work_type='$vitaya_work_type' ";
     }
	 echo $sql;die;
       mysql_db_query($dbname,$sql);
       echo" <script language=\"javascript\">
                alert(\"ปรับปรุงข้อมูลวิทยฐานะเรียบร้อย\\n \");
                </script>";
    }
   
  } 

$statusConfigElec="";
function checkStatusConfigElec($staffid){
		global $dbnamemaster;
		$statusConfigElec="";
		if($staffid!=""){
				$sql_select_elec="
				SELECT
				Count(config_keyelec.staffid) AS NUM
				FROM `config_keyelec`
				WHERE config_keyelec.staffid =  '{$staffid}'
				";

				$rs_select_elec=mysql_db_query($dbnamemaster,$sql_select_elec);
				$res_select_elec=mysql_fetch_assoc($rs_select_elec);
				//echo $sql_select_elec; print_r($res_select_elec);
				if(intval($res_select_elec['NUM'])>0){
						$statusConfigElec=$staffid;
				}
		}	// end if($staffid!="")
		return $statusConfigElec;
}	// end function checkStatusConfigElec

$time_start = getmicrotime();
if ($_SERVER[REQUEST_METHOD] == "POST"){
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		exit();*/
$salary_st=str_replace(',',"",$salary);
	$pls = trim($pls);
 if(!get_magic_quotes_gpc()){
	$pls			= addslashes($pls);
 }
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
		
		//$returnid = add_monitor_logbefore("salary","  id='$id' and runid='$runid[$i]' ");
		$result 	= mysql_db_query($dbname,$sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
		//add_monitor_logafter("salary","  id='$id' and runid='$runid[$i]' ",$returnid);
		
	}
	//header("Location: ?id=$id");
	
	echo"<meta http-equiv='refresh' content='0;URL=salary.php?action=edit&viewall=1'>";
	exit;
}


  	$result 		= mysql_db_query($dbname," select max(runno) as runno from salary where id='$id'; ")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
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
	
 //-1  
  
 $sql_vitaya = "SELECT runid,vitayaname,orderby FROM vitaya where runid='$vitaya'";
	$result_vitaya = mysql_db_query($dbnamemaster,$sql_vitaya);
	$rs_vitaya = mysql_fetch_assoc($result_vitaya);
	$hr_vitaya_text = $rs_vitaya[vitayaname];	
   
    

   // savevitaya($runid,$id,$vitaya,$date,$noorder,$dateorder);
    
    
// comment by sanit เนื่องจากได้สร้าง function savevitaya       ไว้สำหรับ บันทึกวิทยะฐานะ 
 //================================================Vitaya=============================    
// กรณีต้องการล้างค่า วิทยฐานะ เพิ่มเติม  suwat  17/02/2552
if($clear_vitaya == "1"){

	$sql_del = "DELETE FROM vitaya_stat WHERE id='$id'";
	@mysql_db_query($dbname,$sql_del);
	
}else{


	


$resultx1 = mysql_db_query($dbname," SELECT  remark  FROM  vitaya_stat  WHERE    id ='$id'  AND  remark = '$noorder_old' ");
	$rr1=mysql_fetch_assoc($resultx1);
	$numrr1=mysql_num_rows($resultx1);
	
	if (($numrr1 !=0) 	and ($noorder_old == $rr1[remark]) and ($rr1[vitaya] != "")){
			$sql_update1 =  "UPDATE vitaya_stat  SET salary_id='$runid',remark='$noorder', date_start = '$date', date_command = '$dateorder'  WHERE   id ='$id'  AND  remark='$noorder_old'" ;	
			//echo "$sql_update";
		$returnid = add_monitor_logbefore("vitaya_stat"," id ='$id'  AND  remark='$noorder_old' ");
		mysql_db_query($dbname,$sql_update1) or die("Query line ". __LINE__ ." error<hr>".mysql_error());
		add_monitor_logafter("vitaya_stat","  id ='$id'  AND  remark='$noorder_old' ",$returnid);
	} 
	
	$resultx = mysql_db_query($dbname," SELECT  remark  FROM  vitaya_stat  WHERE    id ='$id'  AND  remark = '$noorder' ");
	$rr=mysql_fetch_assoc($resultx);
	$numrr=mysql_num_rows($resultx);
	//อ่านเพื่อนำมาเช็คค่าว่ามีวิทยฐานะซ้ำกันหรือไม่
	$sql_name=mysql_db_query($dbname,"select * from vitaya_stat WHERE id='$id' and name='$hr_vitaya_text' ");
	$arn=mysql_fetch_assoc($sql_name);
	$numname=mysql_num_rows($sql_name);
	if($numname==0 and $numrr !=0) //ไม่ซ้ำกัน___________________________________________//......
		{
		if($vitaya !="")
		{
		//echo "แก้ไขได้เลยเพิ่มข้อมูลได้อ่ะครับ";
		$sql_update =  "UPDATE vitaya_stat  SET  date_start = '$date', date_command = '$dateorder' , vitaya_id='$vitaya', name = '$hr_vitaya_text',remark='$noorder' WHERE   id ='$id'  AND  remark='$rr[remark]'" ;
		$returnid = add_monitor_logbefore("vitaya_stat"," id ='$id'  AND  remark='$rr[remark]' ");
		mysql_db_query($dbname,$sql_update);// or die("Query line ". __LINE__ ." error<hr>".mysql_error());
		add_monitor_logafter("vitaya_stat"," id ='$id'  AND  remark='$rr[remark]' ",$returnid);
			}
		else
		{
			$delete="DELETE  FROM  vitaya_stat where id='$id' and remark='$rr[remark]' ";
			mysql_db_query($dbname,$delete)or die(mysql_error());
		}
					
					echo"
				<script language=\"javascript\">
				alert(\"ปรับปรุงข้อมูลวิทยฐานะเรียบร้อย\\n \");
				</script>";
		}
		else if($numname==0 and $numrr==0 and $vitaya !="")//มีคำสังนี้อยู่หรือไม่ ----------------------------------------//////
		{
			$sql_insert =  " REPLACE  INTO  vitaya_stat  (id,salary_id,vitaya_id,name,date_command,date_start,remark)";
			 $sql_insert.="VALUES('$id','$runid','$vitaya','$hr_vitaya_text','$dateorder','$date','$noorder')  " ;
		//	echo "============".$sql_insert."<hr>";
		//die;
		
		echo"
				<script language=\"javascript\">
				alert(\"ปรับปรุงข้อมูลวิทยฐานะเรียบร้อย\\n \");
				</script>";
		$returnid = add_monitor_logbefore("vitaya_stat"," id ='$id'  AND  name='$hr_vitaya_text' ");
		$rrr=mysql_db_query($dbname,$sql_insert);
		add_monitor_logafter("vitaya_stat"," id ='$id'  AND  name='$hr_vitaya_text' ",$returnid);
		
		}
	if($numname==1)
		{
			if($arn[remark]==$noorder)//เช็คว่า ค่าหมายเลขคำสั่ง ในตัวที่มีในฐานข้อมูลตรงกับ ตัวที่แก้ไขหรือไม่
			{
			
			}
			else
			{
			
$sql_vitaya = "SELECT runid,vitayaname,orderby FROM vitaya where runid='$vitaya'";
		$result_vitaya = mysql_db_query($dbnamemaster,$sql_vitaya);
		$rs_vitaya = mysql_fetch_assoc($result_vitaya);
		$hr_vitaya_text = $rs_vitaya[vitayaname];
			
			
				$sql_vitaya_update = "UPDATE vitaya_stat SET id='$id',salary_id='$runid',vitaya_id='$vitaya',name='$hr_vitaya_text', date_command='$dateorder',date_start='$date', remark='$noorder' WHERE id='$id' AND name='$hr_vitaya_text' ";
				$returnid = add_monitor_logbefore("vitaya_stat"," id='$id' AND name='$hr_vitaya_text' ");
				$result_vitaya_update = mysql_db_query($dbname,$sql_vitaya_update);
				add_monitor_logafter("vitaya_stat"," id='$id' AND name='$hr_vitaya_text' ",$returnid);
				
				
					echo"
				<script language=\"javascript\">
				alert(\"ระบบได้ปรับปรุงข้อมูลวิทยฐานะ  $hr_vitaya_text ในคำสั่ง $noorder\\n \");
				</script>";

				
/*//			$rtr="วิทยฐานะ $vitaya ไม่ถูกบันทึก เนื่องจากวิทยฐานะดังกล่าว มีอยู่แล้วในคำสั่งที่ $arn[remark]";
//					echo"
//				<script language=\"javascript\">
//				alert(\"$rtr\\n \");
//				</script>";
//		*/
	}
			
		}
}//end if($clear_vitaya == "1"){#############################




//=================================END Viataya==============================
	if(!get_magic_quotes_gpc()){
			$label_dateorder	= addslashes($label_dateorder);
 	}


	if($label_dateorder != ""){ $label_dateorder_x = $label_dateorder;}else{ $label_dateorder_x = $sent_day1;}
	if($label_date != ""){ $label_date_x = $label_date; }else{ $label_date_x = $sent_day;}
	//ปรับให้เก็บรหัสระดับกับรหัสตำแหน่ง
	//ขวัญ
		$sql_pid = "SELECT  position  FROM hr_addposition_now where pid='$hr_addposition'";
		$result_pid = mysql_db_query($dbnamemaster,$sql_pid);
		$rs_pid = mysql_fetch_assoc($result_pid);
		$pid_text = $rs_pid[position];
	
			$sql_pid = "SELECT  radub  FROM hr_addradub where level_id='$hr_addradub'";
		$result_pid = mysql_db_query($dbnamemaster,$sql_pid);
		$rs_pid = mysql_fetch_assoc($result_pid);
		$hr_addradub_text = $rs_pid[radub];
	
	 /*$str=setorder_type($select_type,$txt_money,$select_school,$select_school_label,$select_school_name);     
	 $arr=explode('|',$str);
	 $select_type=$arr[0];
     $txt_money=$arr[1]; 
     $select_school=$arr[2]; 
     $select_school_label=$arr[3];
	 if($pos_onduty!=""){$post_dutylabel="";}
	 */
	 
	 if($elec_paper != "" or $str_system_type == 'SYSTEM_ELEC' or $str_system_type == 'SYSTEM_SALARYUP_COMMAND'){
			 $conup_salary = ", system_type='$elec_paper' ";
	}else{
			$conup_salary = "";
	}
	 
     
	$sql 	= " update  salary set  `date`='$date', `position`='$pid_text' , noposition = '$noposition', label_noposition='$label_noposition',level_id='$hr_addradub', radub = '$hr_addradub_text', salary ='$salary_st', ";
	$sql	.= " `upgrade` = '$upgrade'  , note ='$note' ,noorder = '$noorder', noorder_number = '$noorder_num', noorder_year = '$noorder_year', schoolid='$select_school', siteid='$_SESSION[secid]', pls = '$pls' , ch_position = '$ch_position' ,ch_salary = '$ch_salary', ";
	$sql	.= " ch_radub='$ch_radub', dateorder = '$dateorder', pos_name='$pos_name',instruct='$instruct',label_date='$label_date_x',label_salary='$label_salary',label_dateorder='$label_dateorder_x',label_radub='$label_radub', position_id='$hr_addposition',note='$txt_note' $conup_salary   where id ='$id' and runid ='$runid' ";	
	//echo $sql." :: update";
	//die();
	add_log("ข้อมูลเงินเดือน",$id,"edit",$menumode,$err_massage);
	$returnid = add_monitor_logbefore("salary","  id ='$id' and runid ='$runid'  ");
	mysql_db_query($dbname,$sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	add_monitor_logafter("salary"," id ='$id' and runid ='$runid' ",$returnid);
	
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
	
echo"
				<script language=\"javascript\">
				alert(\"ข้อมูลตำแหน่ง ระดับ และอัตราเงินเดือน บันทึกเรียบร้อย\\n \");
				</script>
			<meta http-equiv='refresh' content='0;URL=salary.php?action=edit&YY=$YY&viewall=$v'>";
	exit;

} else {
	add_log("ข้อมูลเงินเดือน",$id,"insert",$menumode,$err_massage);
	if($instruct=="other")
	{
	$instruct=$instruct1;
	}
	else
	{
		$instruct=$instruct; 
	}
	/*
		$sql_pid = "SELECT  *  FROM hr_addposition_now where position='$hr_addposition'";
		$result_pid = mysql_db_query($dbnamemaster,$sql_pid);
		$rs_pid = mysql_fetch_assoc($result_pid);
		$pid = $rs_pid[pid];
		*/
    //ปรับให้เก็บรหัสระดับกับรหัสตำแหน่ง 17-11-2009
	//ขวัญ
		$sql_pid = "SELECT  position  FROM hr_addposition_now where pid='$hr_addposition'";
		$result_pid = mysql_db_query($dbnamemaster,$sql_pid);
		$rs_pid = mysql_fetch_assoc($result_pid);
		$pid_text = $rs_pid[position];
	
		$sql_pid = "SELECT  radub  FROM hr_addradub where level_id='$hr_addradub'";
		$result_pid = mysql_db_query($dbnamemaster,$sql_pid);
		$rs_pid = mysql_fetch_assoc($result_pid);
		$hr_addradub_text = $rs_pid[radub];
        
  /*      $str=setorder_type($select_type,$txt_money,$select_school,$select_school_label,$select_school_name);     
        $arr=explode('|',$str);
        $select_type=$arr[0];
        $txt_money=$arr[1]; 
        $select_school=$arr[2]; 
        $select_school_label=$arr[3]; 
	 if($pos_onduty!=""){$post_dutylabel="";}*/
	 
	 	 
	$sql 	= "INSERT INTO salary (id, `date`, `position`, noposition, radub, salary, `upgrade`, noorder ,noorder_number ,noorder_year , ch_position, ch_radub, ch_salary, pls, dateorder, ";
	$sql	.= " pos_name, runno,instruct,label_date,label_salary,label_dateorder,label_radub,label_noposition,note,level_id,position_id,system_type ,schoolid,siteid) VALUES ('$id', '$date', '$pid_text', '$noposition', '$hr_addradub_text', '$salary_st', '$upgrade',  '$noorder', '$noorder_num', '$noorder_year', ";
	$sql	.= " '$ch_position', '$ch_radub','$ch_salary','$pls','$dateorder','$pos_name','$runno','$instruct','$label_date','$label_salary','$label_dateorder','$label_radub','$label_noposition','$txt_note','$hr_addradub','$hr_addposition','$elec_paper','$select_school','$_SESSION[secid]') ";			
//echo $sql."<hr>";
	//echo $sql."<br>";
	$returnid = add_monitor_logbefore("salary","");
	mysql_db_query($dbname,$sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	$max_idx = mysql_insert_id();
	add_monitor_logafter("salary"," id ='$id' and runid ='$max_idx' ",$returnid);
	
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
	// ======= INPUT  VITAYATHANA===========
	
//savevitaya($max_idx,$id,$vitaya,$date,$noorder,$dateorder);  	
	
	
	/// กรณีล้างค่าวิทยะฐานะ suwat
if($clear_vitaya == "1"){


	$sql_del = "DELETE FROM vitaya_stat WHERE id='$id'";
	@mysql_db_query($dbname,$sql_del);
}else{

$sql_vitaya = "SELECT runid,vitayaname,orderby FROM vitaya where runid='$vitaya'";
	$result_vitaya = mysql_db_query($dbnamemaster,$sql_vitaya);
	$rs_vitaya = mysql_fetch_assoc($result_vitaya);
	$hr_vitaya_text = $rs_vitaya[vitayaname];


	// end กรณีล้างค่าวิทยะฐานะ
	$sqlvitaya="select * from vitaya_stat where id='$id' and name='$hr_vitaya_text' ";
	//echo $sqlvitaya;
	$qvitaya=mysql_db_query($dbname,$sqlvitaya)or die (mysql_error());
	$rsv=mysql_fetch_assoc($qvitaya);
	$numvitaya=mysql_num_rows($qvitaya);
	if($numvitaya > 0 and $rsv[vitaya] != "")
	{
			//	$sql_insert =  " insert  INTO  vitaya_stat  (id,name,date_command,date_start,remark)";
			// $sql_insert.="VALUES('$id','$vitaya','$dateorder','$date','$noorder')  " ;
				$sql_update = "UPDATE vitaya_stat SET id='$id',salary_id='$max_idx', vitaya_id='$vitaya',  name='$hr_vitaya_text', date_command='$dateorder', date_start='$date', remar='$noorder' WHERE id='$id' AND name='$hr_vitaya_text'";
			$returnid = add_monitor_logbefore("vitaya_stat","   id='$id' AND name='$hr_vitaya_text'  ");
			$msger=mysql_db_query($dbname,$sql_update);
			add_monitor_logafter("vitaya_stat","  id='$id' AND name='$hr_vitaya_text' ",$returnid);
			
			if($msger){
				echo"
				<script language=\"javascript\">
				alert(\"ข้อมูลวิทยฐานะบันทึกเรียบร้อย\\n \");
				</script>";
			}

/*//		$mssg="วิทยฐานะ $vitaya ไม่ถูกบันทึก เนื่องจากวิทยฐานะดังกล่าว มีอยู่แล้วในคำสั่งที่ $rsv[remark]";
//					echo"
//				<script language=\"javascript\">
//				alert(\"$mssg\\n \");
//				</script>
/			<meta http-equiv='refresh' content='0;URL=salary.php?action=edit&YY=$YY&viewall=$v'>";
//		*/
	}
	else if($numvitaya==0 and $vitaya !="")
	{
	
$sql_vitaya = "SELECT runid,vitayaname,orderby FROM vitaya where runid='$vitaya'";
	$result_vitaya = mysql_db_query($dbnamemaster,$sql_vitaya);
	$rs_vitaya = mysql_fetch_assoc($result_vitaya);
	$hr_vitaya_text = $rs_vitaya[vitayaname];
	
		
				$sql_insert =  " REPLACE  INTO  vitaya_stat  (id,name,salary_id,vitaya_id,date_command,date_start,remark)";
			 $sql_insert.="VALUES('$id','$max_idx','$hr_vitaya_text','$vitaya','$dateorder','$date','$noorder')  " ;
	//$sql_insert =  "INSERT  INTO  vitaya_stat  VALUES('$id','$vitaya','$date','$dateorder','$noorder' )" ;
	//echo $sql_insert."lkg;dsajf;lkdsjfdsl" ;
	$returnid = add_monitor_logbefore("vitaya_stat","   id='$id' AND name='$hr_vitaya_text'  ");
	$msger=mysql_db_query($dbname,$sql_insert);
	add_monitor_logafter("vitaya_stat","  id='$id' AND name='$hr_vitaya_text' ",$returnid);
		echo"
				<script language=\"javascript\">
				alert(\"ข้อมูลวิทยฐานะบันทึกเรียบร้อย\\n \");
				</script>";
	}
				echo"
				<script language=\"javascript\">
				alert(\"ข้อมูลส่วนตำแหน่ง ระดับ และอัตราเงินเดือนบันทึกเรียบร้อย\\n \");
				</script>
			<meta http-equiv='refresh' content='0;URL=salary.php?action=edit&YY=$YY&viewall=$v'>";
	/*//+++++++++++++++++++++++++++++++
	//
	//	echo " 
	//			<script language=\"javascript\">
	//			alert(\"ทำการบันทึกข้อมูลเสร็จสิ้น\\n \");
	//			location.href='?id=$id&action=edit#keys';
	//			</script>
	//			";
	//header("Location: ?id=$id&action=edit#keys");*/
	exit;
				
}
  echo"
                <script language=\"javascript\">
                alert(\"ข้อมูลส่วนตำแหน่ง ระดับ และอัตราเงินเดือนบันทึกเรียบร้อย\\n \");
                </script>
            <meta http-equiv='refresh' content='0;URL=salary.php?action=edit&YY=$YY&viewall=$v'>";

}//end if(){	if($clear_vitaya == "1"){		

} elseif($_GET[action] == 'delete') {
	$rem = urldecode($rem);
	add_log("ข้อมูลเงินเดือน",$id,"delete",$menumode,$err_massage);
	mysql_db_query($dbname,"delete from salary where id ='$id' and runid='$runid';")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	mysql_db_query($dbname,"delete from vitaya_stat where id = $id and remark='$rem'")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	//header("Location: ?id=$id&action=edit");
	echo"<meta http-equiv='refresh' content='0;URL=salary.php?action=edit&viewall=$v&YY=$YY'>";
	exit;
	
} else {		
	
	$sql 		= "select * from  general where id='$id'  ;";
	$result 	= mysql_db_query($dbname,$sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	$rs		= mysql_fetch_array($result,MYSQL_ASSOC);

	$sqlx 		= "select * from  vitaya_stat  where id='$id' AND date_start = '$date'  ;";
	$resultx 	= mysql_db_query($dbname,$sqlx)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	$rsx		= mysql_fetch_array($resultx,MYSQL_ASSOC);

}

function getSchoolName($xschool){
$dbnamemaster="edubkk_master";
$sql="SELECT 
allschool.office,
eduarea.secname,
allschool.id,
eduarea.secid,eduarea.provid,
moiareaid 
FROM 
allschool
Inner Join eduarea ON allschool.siteid = eduarea.secid 
where allschool.id= '$xschool' "  ;
$select1  = mysql_db_query($dbnamemaster,$sql); 
$name = str_replace("'", "", $sql);   

$row=mysql_fetch_array($select1,MYSQL_ASSOC);
$aumpurId=substr($row["moiareaid"],0,4);
$sql_aumpur="SELECT ccaa.ccName FROM ccaa WHERE areaid='{$aumpurId}' ";
$select_aumpur  = mysql_db_query($dbnamemaster,$sql_aumpur); 	
$row_aumpur=mysql_fetch_array($select_aumpur,MYSQL_ASSOC);

$tamboonId=substr($row["moiareaid"],0,6);
$sql_tamboon="SELECT ccaa.ccName FROM ccaa WHERE areaid LIKE '{$tamboonId}%' ";
$select_tamboon  = mysql_db_query($dbnamemaster,$sql_tamboon); 	
$row_tamboon=mysql_fetch_array($select_tamboon,MYSQL_ASSOC);
$name = trim($row["office"]." [".$row_aumpur['ccName']." ".$row_tamboon['ccName']."] : ". str_replace("สำนักงานเขตพื้นที่การศึกษา", "สพท.", $row["secname"]));
return $name;
}
?>


<link href="libary/tab_style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery.js"></script> 




<?php 
if($_GET['action']=="edit1"||$_GET['action']=="edit2"){
	$xid=$_GET[id];
$sql="SELECT
edubkk_$secid.general.schoolid,
edubkk_$secid.general.idcard,
edubkk_master.allschool.office,
edubkk_master.eduarea.secid,
edubkk_master.eduarea.secname
FROM
edubkk_master.allschool
Inner Join edubkk_$secid.general ON edubkk_master.allschool.id = edubkk_$secid.general.schoolid
Inner Join edubkk_master.eduarea ON edubkk_$secid.general.siteid = edubkk_master.eduarea.secid 
where edubkk_$secid.general.idcard='$xid'";
$result= mysql_db_query($dbname,$sql);
$row=mysql_fetch_array($result);
$def_schoolid=$row[schoolid];

if($row[schoolid]==$row[secid]){
	$def_schoolname=$row[office];
}else{
    $def_schoolname=$row[office].":". str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$row[secname]) ;	
	}

}

?>
<script >
var maxyear=<?=date('Y')+543?>;
var minyear=2550;
var  msghide=true;
var def_schoolname="<?=$row[office]?>";
var def_school="<?=$def_schoolid?>";
var def_position="<?=$rs[pid]?>";
var def_salary="<?=$rs[salary]?>";
var def_noposition="<?=$rs[noposition]?>";
var def_radub="<?=$rs[level_id]?>";
var salary_pre=0;
var def_ordertype='';
</script>
<?php /*?><script type="text/javascript" src="../../../common/calendar_list.js"></script> <?php */?>
<script>
var imgDir_path="../../../common/popup_calenda/images/calendar/";
</script>
<script src="../../../common/check_label_values/script.js" type="text/javascript"></script>
<script type="text/javascript" src="../../../common/check_label_values/calendar_list.js"></script>
<script>
$(document).ready(function() {
	path="../../../common/check_label_values/";
	check_true='<img src="'+path+'images/checked.gif" width="18" height="18" />';
	check_false='<img src="'+path+'images/unchecked.gif" width="18" height="18" />';
	
	$('#label_date').after("<span id='msg_label_date' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'value_date','label','date',"chk_date");});
	
	/*$('#noposition').after("<span id='msg_noposition' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'label_noposition','values','number',"chk_noposition");});
	$('#label_noposition').after("<span id='msg_label_noposition' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'noposition','label','number',"chk_noposition");});*/
	
	$('#salary').after("<span id='msg_salary' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'label_salary','values','number',"chk_salary");});
	$('#label_salary').after("<span id='msg_label_salary' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'salary','label','number',"chk_salary");});
	
	$('#label_dateorder').after("<span id='msg_label_dateorder' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'value_dateorder','label','date',"chk_dateorder");});
	
});
</script>
<?

	if($_GET['action']=="edit" && $_GET['viewall']==1){ 
?>

<script src="jquery.tablednd.js" type="text/javascript"></script> 
<script  type="text/javascript">

		function genXHR(){
		var xmlHttp=null;
				try{
					// Firefox, Opera 8.0+, Safari
					xmlHttp=new XMLHttpRequest();
				}catch (e){
					// Internet Explorer
					try{
						xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
					}catch (e){
						xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
				}
		return xmlHttp;
	}

		function Mlink(name){
			j=genXHR();
			params=name;
			sTbl=document.getElementById("showMsg");
			j.onreadystatechange=function() { 
			if (j.readyState==4 || j.readyState=="complete"){ 
				sTbl.innerHTML=j.responseText;
			}else{
				sTbl.innerHTML="<img src=\"bimg/order_indicator.gif\" />&nbsp;กำลังประมวลผล";
			}
		}
		
		j.open("POST","order_jax.php?ts="+new Date().getTime(), true);
		j.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		j.send(params);
		}

		$(document).ready(function() {
    	$("#order_table").tableDnD({
		onDragClass: "hileght",
        onDrop: function(table, row) {
            //alert($.tableDnD.serialize());
			Mlink($.tableDnD.serialize());
        }
    });
});
		
	
		
		
 </script>
 <?php 
 }else{
 ?>
<script type="text/javascript" src="libary/tabber.js"></script>
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

function ch(){
		var f1=document.post;
		var chkStatus=0;
		if (f1.chk_date.value == 'false'){
			if(confirm("ช่อง มีผล ณ (วัน เดือน ปี ) ไม่ตรงกับช่องแสดงผล กพ.7 ต้องการดำเนินการต่อหรือไม่")){
					chkStatus=0;
					f1.subject_error.value=f1.subject_error.value+"::"+"ช่อง มีผล ณ (วัน เดือน ปี ) ไม่ตรงกับช่องแสดงผล กพ.7";
					f1.value_key_error.value=f1.value_key_error.value+"::"+f1.salary_day.value+"/"+f1.salary_month.value+"/"+f1.salary_year.value;
					f1.label_key_error.value=f1.label_key_error.value+"::"+f1.label_date.value;
					f1.submenu_id.value=f1.submenu_id.value+"::"+"8";
			}else{
					chkStatus=1;
					f1.subject_error.value="";
					f1.value_key_error.value="";
					f1.label_key_error.value="";
					f1.submenu_id.value="";
					return false;
			}
		}
		
		if (f1.chk_noposition.value == 'false'){
			if(confirm("ช่องเลขที่ตำแหน่ง ไม่ตรงกับช่องแสดงผล กพ.7 ต้องการดำเนินการต่อหรือไม่")){
					chkStatus=0;
					f1.subject_error.value=f1.subject_error.value+"::"+"ช่องเลขที่ตำแหน่ง ไม่ตรงกับช่องแสดงผล กพ.7";
					f1.value_key_error.value=f1.value_key_error.value+"::"+f1.noposition.value;
					f1.label_key_error.value=f1.label_key_error.value+"::"+f1.label_noposition.value;
					f1.submenu_id.value=f1.submenu_id.value+"::"+"9";
			}else{
					chkStatus=1;
					f1.subject_error.value="";
					f1.value_key_error.value="";
					f1.label_key_error.value="";
					f1.submenu_id.value="";
					return false;
			}
		}
		
		if (f1.chk_salary.value == 'false'){
			if(confirm("ช่องอัตราเงินเดือน ไม่ตรงกับช่องแสดงผล กพ.7 ต้องการดำเนินการต่อหรือไม่")){
					chkStatus=0;
					f1.subject_error.value=f1.subject_error.value+"::"+"ช่องอัตราเงินเดือน ไม่ตรงกับช่องแสดงผล กพ.7";
					f1.value_key_error.value=f1.value_key_error.value+"::"+f1.salary.value;
					f1.label_key_error.value=f1.label_key_error.value+"::"+f1.label_salary.value;
					f1.submenu_id.value=f1.submenu_id.value+"::"+"10";
			}else{
					chkStatus=1;
					f1.subject_error.value="";
					f1.value_key_error.value="";
					f1.label_key_error.value="";
					f1.submenu_id.value="";
					return false;
			}
		}
		
		if (f1.chk_dateorder.value == 'false'){
			if(confirm("ช่องวันที่ (เอกสารอ้างอิง) ไม่ตรงกับช่องแสดงผล กพ.7 ต้องการดำเนินการต่อหรือไม่")){
					chkStatus=0;
					f1.subject_error.value=f1.subject_error.value+"::"+"ช่องวันที่ (เอกสารอ้างอิง) ไม่ตรงกับช่องแสดงผล กพ.7";
					f1.value_key_error.value=f1.value_key_error.value+"::"+f1.dateorder_day.value+"/"+f1.dateorder_month.value+"/"+f1.dateorder_year.value;
					f1.label_key_error.value=f1.label_key_error.value+"::"+f1.label_dateorder.value;
					f1.submenu_id.value=f1.submenu_id.value+"::"+"11";
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

function check(){
wanning_text='';	
errsub=false;
var ddd = document.getElementById("checkdate1");
var ddd2 = document.getElementById("checkdate2");
var month=document.post.salary_month.value;
var year=document.post.salary_year.value;
//alert(chkNumPos);
 if (document.post.checkdate2.checked==true  && document.post.salary_day.value =="" &&  document.post.salary_month.value =="" && document.post.salary_year.value =="")
{
    alert("กรุณาระบุวันที่(วัน เดือน ปี)");
	//AddMessage('0','ไม่ได้ระบุวันที่(วัน เดือน ปี)','00017','submit','e');		
 	return false;
 }
else if(document.post.checkdate2.checked==true && year==""&&month==""){
	 alert("ต้องระบุ เดือนกับปี เป็นอย่างน้อย");
	//AddMessage('0','ต้องระบุ เดือนกับปี เป็นอย่างน้อย','00017','submit','e');	
	return false;
} 
else if(document.post.noorder.value.length == 0)
	{
		alert("ระบุหมายเลขคำสั่ง");
	//	AddMessage('0','ไม่ได้ระบุหมายเลขคำสั่ง','00018','submit','e');	
		document.post.noorder.focus();
		return false;
	} 
else if(document.post.label_salary.value !="" && document.post.salary.value ==0 )
	{
		alert("ระบุอัตราเงินเดือนในช่อง เงินเดือนเพื่อเก็บเป็นข้อมูลสถิติ");
	//	AddMessage('0','ไม่ได้กรอกเงินเดือน','000001','submit','e');	
		return false;
	}else if(document.post.salary.value == 0){
		alert("เงินเดือนในช่องเงินเดือนไม่ควรเป็น 0");
		//AddMessage('0','เงินเดือนในช่องเงินเดือนไม่ควรเป็น 0','000001','submit','e');	
		return false;
	}else if(err_money==1){
		alert("เงินเดือนไม่ถูกต้องตามผังเงินเดือน");
		//AddMessage('0','เงินเดือนในช่องเงินเดือนไม่ควรเป็น 0','000001','submit','e');	
		return false;
	}
	
else if(document.post.hr_addposition.value == "")
{
	alert("กรุณาระบุตำแหน่งเพื่อเก็บเป็นข้อมูลสถิติ");
	//AddMessage('0','ไม่ได้เลือกตำแหน่ง','000011','submit','e');	
	return false;
}else if(ch() ==false)
{
	return false;
}
	
 if (document.post.checkdateorder2.checked==true  && document.post.dateorder_day.value =="" &&  document.post.dateorder_month.value =="" && document.post.dateorder_year.value =="")
{
 alert("กรุณาระบุวันที่(เอกสารอ้างอิง)");
 //AddMessage('0','กรุณาระบุวันที่(เอกสารอ้างอิง)','000019','submit','e');
 return false;
 }

if(year>=2552&&document.post.hr_addradub.value==""){
 alert("กรุณาระบุระดับ");
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
		alert(' กรุณาตรวจสอบข้อมูลเงินเดือนที่ท่านกรอก \n เนื่องตัวเลขอาจมากกว่าความเป็นจริง ');
	}
}


function check_dis_vitaya(val){

var url="getdisvitaya.php?RND="+Math.random()*1000+"&id_pos="+val;
$.get(url,function(data){

		if(data=="1"){
			  $('#vitaya').attr('disabled','');
				//document.post.vitaya.disabled=false;
		}else{
			  $('#vitaya').attr('disabled','');
			//	document.post.vitaya.disabled=true;
		} 
	});
}

// ตรวจสอบเมื่อมีการคลิ๊กเลือก ล้างวิทยฐานะ
   function dis_box_vitaya(){
   var v1 =$('#hr_addradub :selected').text();
 	if((v1 == "คศ.2") || (v1 == "คศ.3") || (v1 == "คศ.4") || (v1 == "คศ.5") ){
   		if(document.post.clear_vitaya.checked == true ){
			document.post.vitaya.disabled=true;
		}else{
			document.post.vitaya.disabled=false;
		}
	}else{
		check_dis_vitaya();
	}
   }

</script>
<?php } 
?>
<script type="text/javascript" src="../../../common/autocomplete/autocomplete.js"></script>
<link href="../../../common/autocomplete/autocomplete.css"  rel="stylesheet" type="text/css">
<script src="../../../common/script_event.js"></script>
<script src="script_salary.js"></script>
<script >
addnone=1;
var def_vistaya='';
var def_radub='';
var xvitaya='';
var sdate='';
var cdate='';

function chekvit(){
	if(	document.post.salary_year.value>0 && document.post.salary_month.value>0&&document.post.salary_day.value>0){
		getvitaya(document.post.hr_addposition.value);	
	}
}


function getposition(val){
		dayT=$('#salary_day').val();
		monthT=$('#salary_month').val();
		yearT=$('#salary_year').val();
		dateTemp=dayT+"/"+monthT+"/"+yearT;
		var def=$('select[name="hr_addposition"]').val();
		if(val==strType38){
				temp38=Check_numberPosition('onchange');
		}
var url="getpostion.php?RND="+Math.random()*1000+"&id_pos="+val+"&DateT="+dateTemp;
$.get(url,function(data){
  $('#hr_addposition').empty().append(data);	
    $('select[name="hr_addposition"]').val(def) ;
  getradub(document.post.hr_addposition.value);
  getvitaya(document.post.hr_addposition.value);
});
}
function getposition2(val){
var url="getpostion2.php?RND="+Math.random()*1000+"&id_pos="+val;
$.get(url,function(data){
  $('#divposduty').empty().append(data);	
 
});
}
<?
if( $_GET['action']=="edit1"||$_GET['action']=="edit2"){ 
?>
var htr=13;	
var showper=7;	
$(document).ready(function(){
	$('select[name="hr_addposition"]').change();
	/*
			   
$('#tr_selschool').hide();
$('#tr_money').hide();	
$('#tr_posduty1').hide();
$('#tr_posduty2').hide();
if(document.post.select_type.value=='1'||document.post.select_type.value=='2'||document.post.select_type.value=='7'||document.post.select_type.value=='8'||document.post.select_type.value=='9'||document.post.select_type.value=='18'){
	$('#tr_selschool').show();
}else if(document.post.select_type.value=='4'){
    $('#tr_money').show();	
	
}else if(document.post.select_type.value=='11'||document.post.select_type.value=='17'){
	$('#tr_posduty1').show();
     $('#tr_posduty2').show();
}

						   
check_dis_vitaya(document.post.hr_addposition.value);									   
getvitaya(document.post.hr_addradub.value);						   
 $("#info").hide();


        $(".close").click(function(){	
		
        $("#info").animate({left:"+=10px"}).animate({left:"-5000px"},function(){
		$("#info").hide();												  });
		msghide=true;       
		});
		$('.up').click(function(){
			
			var boxerr= $("#boxerror").height();
			var texterr=$("#err_text").height();
			//$("#err_text").offset().top+=100;
			 var pos = $("#err_text").position();			 
			 if( texterr-pos.top>boxerr){
			 var xpost=pos.top+(htr*3);			 
			   if(xpost>3){
				$("#err_text").animate({top:0});   
			   }else{   
                $("#err_text").animate({top:xpost});
			   }
			}			 
		 					
		});
		$('.down').click(function(){
			var boxerr= $("#boxerror").height();
			var texterr=$("#err_text").height();			
			 var pos = $("#err_text").position();			
			if( texterr+pos.top>boxerr){ 
			   var xpost=pos.top-(htr*3);
			  if(texterr+xpost<boxerr){
			   $("#err_text").animate({top:boxerr-texterr-3});	
			   }else{
			   $("#err_text").animate({top:xpost});
			   } 
						
			
			}
		});
		
*/});

<?
}
?>



function getvitaya(val){
def_vistaya=document.post.vitaya.value;
var sdate=document.post.salary_year.value+'-'+document.post.salary_month.value+'-'+document.post.salary_day.value
var url="getvitaya.php?RND="+Math.random()*1000+"&radub_id="+val+"&idsel="+def_vistaya+"&xsiteid=<?=($secid!="")?$secid:''?>&xidcard=<?=($id!="")?$id:''?>&xvitaya="+xvitaya+"&sdate="+sdate;
	$.get(url,function(data){
	 $('#hr_vitaya').empty().append(data);					  
	});
checkup_ladub(val);	
}

function checkup_ladub(new_radub){
var url="ajax_check_upradub.php?RND="+Math.random()*1000+"&level_new="+new_radub+"&xsiteid=<?=($secid!="")?$secid:''?>&xidcard=<?=($id!="")?$id:''?>";
	$.get(url,function(data){
					   var  arr=Array();
 					    arr=data.split(':');
	if(arr[0]=="no"){
		AddMessage('0',arr[1],'000000','checkup_ladub','w');	
		}				  
	});
}




function getradub(val){
dayT=$('#salary_day').val();
monthT=$('#salary_month').val();
yearT=$('#salary_year').val();
//var def=$('select#hr_addradub').val();
var def=$('select[name="hr_addradub"]').val();
var url="getradub.php?RND="+Math.random()*1000+"&postname="+val+"&idsel="+document.post.hr_addradub.value+"&xday="+dayT+"&xmonth="+monthT+"&xyear="+yearT;
$.get(url,function(data){
 $('#hr_addradub').empty().append(data);		
 $('select[name="hr_addradub"]').val(def);			  
});
}
var err_money=0;
function checklevel_salary(){
var year=document.post.salary_year.value;	
var month=document.post.salary_month.value;	
var money=document.post.salary.value;
var day=document.post.salary_day.value;

money=money.replace(',','');


if(year>=minyear&&year<=maxyear){
	
/*if(year==2547&&month<12){
	$('#check_salary').html("");
    return false;
}*/	
if(money!=''&&money>0){	
if(salary_pre!=money){
var radub =$('#hr_addradub :selected').text();
var url="check_lvsalary.php?month="+month+"&xyear="+year+"&day="+day+"&Rnd="+Math.random()*100+"&radub="+radub+"&salary="+money+"&xsiteid=<?=($secid!="")?$secid:''?>&xidcard=<?=($id!="")?$id:''?>";
$('#check_salary').html('กำลังตรวจสอบผังเงินเดือน');
	$.get(url,'',function(data){ 
	
						 // $('#check_salary').html("เงินเดือนถูกต้องตามผังเงินเดือน");	
	 var val = new Array();
	 val=data.split('|:|');		
			  
		if($.trim(val[0])=="ok"){
			err_money=0;
		$('#check_salary').html("เงินเดือนถูกต้องตามผังเงินเดือน");	
		getlevel_salary();
		}else if($.trim(val[0])=="no"){
			var x= new Array();
			x=val[1].split(',');
			var xstr="";
			var i=0;
		for(i=0;i<x.length;i++){
			 xstr+="<a href="+ x[i] +" target=_blank>ดูผังบัญชีเงินเดือน</a><br>";
			}	 
		err_money=1;	 
		var err_st='e';
		if(val[4]==1){
			err_st='w';
		}
		$('#check_salary').html("เงินเดือนไม่ถูกต้องตามผังเงินเดือน <br>"+xstr);
		AddMessage('0',money+" เงินเดือนไม่ถูกต้องตามผังเงินเดือน <br>"+xstr,'500001','check_salary',err_st);
		}else{
		$('#check_salary').html("error "+data);
		}				  
	});
	}else{
		if(parseInt(money)==0){
			err_money=1;
		AddMessage('0','ไม่ได้กรอกเงินเดือน','500001','check_salary','e');		

		}	
	  }
	}else{
		err_money=1;
	  AddMessage('0','ไม่ได้กรอกเงินเดือน','500001','check_salary','e');    
	}
	}else{
		err_money=0;
	$('#check_salary').html("");
	}

}
function getlevel_salary(){
 var radub="";
 var money="";
 var day="";
 var month="";
 var year="";
year=document.post.salary_year.value;
month=document.post.salary_month.value;
day=document.post.salary_day.value;
money=document.post.salary.value;
 var radub =$('#hr_addradub :selected').text();
var url="get_lvsalary.php?Rnd="+Math.random()*100+"&radub="+radub+"&salary="+money+"&day="+day+"&month="+month+"&year="+year+"&xsiteid=<?=($secid!="")?$secid:''?>&xidcard=<?=($id!="")?$id:''?>";
 if(day==1&&(month==4||month==10)&&year>=minyear&&year<=maxyear){// 1/4/2547 or 1/10/2547	
$.post(url,'',function(data){  
//alert(data);					 
					  
 var val = new Array();
	 val=data.split(':');
	 if(val[0]=="up"){		 
	  $('#txt_money').val(val[1]);	
		$('#showdata').html("");	
	 }else if(val[0]=="max"){
		 $('#txt_money').val('-1');	
		$('#showdata').html("");
	 }else if(val[0]=="nomal"){
		$('#txt_money').val('0');	
		$('#showdata').html(""); 
	 }else{
		 $('#txt_money').val('-99');
		$('#showdata').html('');
		
	 }	
	//
	//$('#showdata').html("'"+data+"'");
	});
 } 
  
}



function make_autocom(autoObj,showObj){   
    var mkAutoObj=autoObj;    
    var mkSerValObj=showObj;    
    new Autocomplete(mkAutoObj, function() {   
        this.setValue = function(id) {         
            document.getElementById(mkSerValObj).value = id;   
       }   
        if ( this.isModified )   
            this.setValue("");   
        if ( this.value.length < 21 && this.isNotClick )    
            return ;       
        return "gdata.php?q=" + this.value+"&rnd="+Math.random()*1000;   
    });    
}   

function get_vitaya_major(div_id,major_gid){
 var url="ajax_vitaya_major.php?Rnd="+(Math.random()*1000)+"&major_gid="+major_gid;
  del_option(div_id);
  $.get(url,'',function(data){
						
	var rows = data.split("\n");	
		for (var i=0; i < rows.length; i++) {
			var row = $.trim(rows[i]);
			if (row) {
				row = row.split("|");
				$("#"+div_id).append("<option title='"+row[0]+"' value='"+row[1]+"'>"+row[0]+"</option>");

			}
		}
  });
}

function del_option(div_id){
	$i=0;
	$("#"+div_id).find("OPTION").each(function(){
	if($i>0){
		$(this).remove();  
	 }
	 $i++;
	});
}
</script>
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

.style2 {color: #FF0000}
.style3 {color: #000000}
.style5 {color: #000000; font-weight: bold; }
.style8 {color: #880000}
.style10 {color: #8C0000}
.hileght{
	background-color:#999999;
}
#info{
	border: 1px solid;
	margin: 0px;
	background-repeat: no-repeat;
	background-position: 10px center;
	position:relative;
	color: #D8000C;
	background-color: #FFBABA;
	
	padding-right: 5px;
	padding-left: 5px;
	padding-top: 2px;
	padding-bottom: 2px;
} 
#boxerror{
	overflow:hidden;
	height:55px;
}
#err_text{
	position:relative;	
}
.text_error{
	font-size:12px;
	color:#000;
	vertical-align: middle;
	height: 18px;
/*<!--	background-image:url(../../../images_sys/close.gif);
	background-repeat: no-repeat;
	background-position: 1px -2px;-->*/
	padding-left: 2px;
	margin-top: 2px;
}
.text_wanning{
	font-size:12px;
	color:#000;
	vertical-align: middle;
	height: 18px;
/*	background-image:url(../../../images_sys/attention_s.png);
	background-repeat: no-repeat;
	background-position: 1px center;*/
	padding-left: 2px;
	margin: 2px;
}
</style>
</head>
<body bgcolor="#A3B2CC" <?=$onload?>>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"> 
	<td><table width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
	  
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30">
		<?
		 if($action=="edit" and $viewall==5){
		?><table width="98%"  align="left">
		<?
	 if($dis_menu){
		?>
	   <tr>
          <td height="21" colspan="3"><a href="kp7_salary.php?id=<?=$id?>" class="style3"><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" alt="ตรวจสอบข้อมูล กพ.7"><span class="style3">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์</span></a></td>
              </tr>
		<?
		}else{
		?>
            <tr>
              <td width="21%" height="21"><a href="salary.php?id=<?=$rs[id]?>&action=edit&viewall=0" title="แก้ไขข้อมูลเงินเดือน" class="style3"><img src="images/edit.png" width="16" height="16" align="absmiddle" border=""><span class="style3">เพิ่ม/ลบ/แก้ไข ข้อมูล</span></a> </td>
              <td width="41%"><a href="kp7_salary.php?id=<?=$id?>" class="style3"><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" alt="ตรวจสอบข้อมูล กพ.7"><span class="style3">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์</span></a></td>
              <td width="38%">&nbsp;</td>
            </tr>
		<?
		}
		?>
        </table>
        <? }else{?>
		<table width="98%"  align="left">
		 <tr>
              <td width="41%" height="21"><a href="kp7_salary.php?id=<?=$id?>"><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" alt="ตรวจสอบข้อมูล กพ.7"><span class="style3">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></a></td>
              <td width="21%">&nbsp;</td>
            </tr>
        </table><? }?>		</td>
        </tr>
    </table>      
      <span class="style5"><a href="salary.php?id=<?=$rs[id]?>&action=edit&viewall=0" title="แก้ไขข้อมูลเงินเดือน" class="style3">&nbsp;</a>ชื่อ / สกุล &nbsp;<u>
      <?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]?>
      </u>


    
      &nbsp;</span><br>
      <br>
      <span class="style3"><strong><a href="salary.php?id=<?=$rs[id]?>&action=edit&viewall=0" title="แก้ไขข้อมูลเงินเดือน" class="style3">&nbsp;</a>๑๓ . ตำแหน่งและอัตราเงินเดือน	  </strong></span></td>
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
<table width="100%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="black">
  
  <tr bgcolor="#A3B2CC" align="center" style="font-weight:bold;">
    <td width="7%"><strong>วัน เดือน ปี</strong></td>
	  <td width="38%"><strong>ตำแหน่ง</strong></td>
	  <td width="7%"><strong>เลขที่<br>
	    ตำแหน่ง</strong></td>
	  <td width="5%"><strong>ระดับ</strong></td>
	  <td width="8%"><strong>อัตรา<br>
	    เงินเดือน</strong></td>
	  <td width="20%">เอกสารอ้างอิง</td>
	  <td width="15%">ประเภทคำสั่ง</td>
      <?php if(SALARY_COMMENT==1){ ?><th>หมายเหตุ</th> <?php } ?>
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

//__________________________________________
if($rs[label_radub] !=""){$radub=$rs[label_radub]; }
else{$radub=$rs[radub];}
$sys_type=$rs[system_type];
$title="";
if($sys_type!=""){
	$bg="#66FF00";
	if($sys_type=="SYSTEM_TRANSFER"){
		$title="บันทึกผ่านระบบแต่งตั้งโยกย้าย";		
		}else{
	     $title="บันทึกผ่านระบบเลื่อนขั้นเงินเดือน";		
}	
}

##########  label เลขที่ตำแหน่ง
	if($rs[label_noposition] != "" and $rs[label_noposition] != NULL){
			$show_noposition = $rs[label_noposition];
	}else{
			$show_noposition = $rs[noposition];
	}


?>
  <tr bgcolor="<?=$bg?>" title="<?=$title?>">
    <td>&nbsp;<?=$dateshow?></td>
	  <td><?=$rs[pls]?></td>
	  <td align="center"><?=$show_noposition?></td>
	  <td align="center"><?=$radub?></td>
	  <td><?=$salary?>&nbsp;</td>
	  <td align="left"><?=$noo." ".$rinstruct?>
        <input type="hidden" name="runid[]2" value="<?=$rs[runid]?>">
        <?=$dateorder?></td>
	  <td align="left">
      <?
      $sql="SELECT
id,
order_type,
orderby
FROM hr_order_type where id='$rs[order_type]'";
$resultx = mysql_db_query('edubkk_master',$sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
$rsx=mysql_fetch_array($resultx);
echo  substr( $rsx[order_type],0,50);
	  ?>
      </td>
      
      <?php if(SALARY_COMMENT=='1'){ ?><td align="center"><?php if($rs[note]!=''){ ?><a id="toolt" href="#" title="<?=$rs[note]?>">?</a><?php }else{ echo "-"; } ?></td> <?php } ?>
	  </tr>
  <?
	} //while
// List Template
?>
  </table>
<?

}
else if($viewall==0)
{
$sql1 = "select * from salary where id='$id'  order by date DESC limit 1";
$result = mysql_db_query($dbname,$sql1)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
$rs1=mysql_fetch_array($result,MYSQL_ASSOC);
 	$d=explode("-","$rs1[date]");
 	$dleast=$d[0]-4;
	$dmore=$d[0]+1;
	$sql11="SELECT
		*
		FROM
		`salary`
		where id='$id' AND date Between '$dleast% ' AND '$dmore%'
		order by date ASC";
		//echo $sql11;
		$query11=mysql_db_query($dbname,$sql11)or die("Query line".__LINE__."error<hr>".mysql_error());
		$row	= mysql_num_rows($query11);
?>
<input type="hidden" NAME="id"  VALUE="<?=$id?>">
<table width="100%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="black">
  <tr bgcolor="#A3B2CC" align="center">
  <td height="25" colspan="9" bgcolor="#2C2C9E"><span class="style1">การเลื่อนขั้นตำแหน่ง(ข้อมูล 5 ปีย้่อนหลัง)</span></td>
  </tr>
  <tr bgcolor="#A3B2CC" align="center" style="font-weight:bold;">
    <td width="8%"><strong>วัน เดือน ปี</strong></td>
	  <td width="31%"><strong>ตำแหน่ง</strong></td>
	  <td width="6%"><strong>เลขที่<br>
	    ตำแหน่ง</strong></td>
	  <td width="4%"><strong>ระดับ</strong></td>
	  <td width="7%"><strong>อัตรา<br>
	    เงินเดือน</strong></td>
	  <td width="22%"><strong>เอกสารอ้างอิง</strong></td>
	  <td width="13%">ประเภทคำสั่ง</td>
        <?php if(SALARY_COMMENT=='1'){ ?> <th>หมายเหตุ</th><?php } ?>
	  <td width="9%"><input type="button" name="add" value="เพิ่มข้อมูล" onClick="location.href='salary.php?id=<?=$id?>&v=0&action=edit1' "></td>    
  </tr>
  
  <?
while ($rs=mysql_fetch_array($query11,MYSQL_ASSOC)){
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

//__________________________________________
if($rs[label_radub] !=""){$radub=$rs[label_radub]; }
else{$radub=$rs[radub];}
$sys_type=$rs[system_type];
$title="";
if($sys_type!="" and  $sys_type!="SYSTEM_ELEC" and $useredit < 1){
	$bg="#66FF00";
	if($sys_type=="SYSTEM_TRANSFER"){
		$title="บันทึกผ่านระบบแต่งตั้งโยกย้าย";		
		}else{
	     $title="บันทึกผ่านระบบเลื่อนขั้นเงินเดือน";		
	}	
	$del_icon = "<img src=\"../../../images_sys/b_drop_disable.png\" width=\"13\" height=\"13\" border=\"0\" title=\"ไม่สามารถลบได้เนื่องจาก $title \">";
	
}elseif(trim($_SESSION[session_staffid])=="" && substr($rs['date'],0,4)<=2547){
	$title="ข้อมูลถูกบันทึกก่อนปี 2547";		
	$del_icon = "<img src=\"../../../images_sys/b_drop_disable.png\" width=\"13\" height=\"13\" border=\"0\" title=\"ไม่สามารถลบได้เนื่องจาก $title \">";
}else{
	$del_icon = "<a href=\"#\" 
	onClick=\"if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=$rs[id]&runid=$rs[runid]&v=0&rem=".urlencode($rs[noorder])." '\" >
	      <img src=\"bimg/b_drop.png\" width=\"16\" height=\"16\" border=\"0\" title=\"Delete\"></a>";	
}

##########  label เลขที่ตำแหน่ง
	if($rs[label_noposition] != "" and $rs[label_noposition] != NULL){
			$show_noposition = $rs[label_noposition];
	}else{
			$show_noposition = $rs[noposition];
	}

?>
  <tr bgcolor="<?=$bg?>" title="<?=$title?>">
    <td align="left">&nbsp;      <?=$dateshow?></td>
	  <td align="left">&nbsp;<?=$rs[pls]?></td>
	  <td align="center"><?=$show_noposition?></td>
	  <td align="center"><?=$radub?></td>
	  <td align="center"><?=$salary?>&nbsp;</td>
	  <td align="left"><?=$noo." ".$rinstruct?>
	    <input type="hidden" name="runid[]3" value="<?=$rs[runid]?>">
	    <?=$dateorder?></td>
	  <td align="left"><?
      $sql="SELECT
id,
order_type,
orderby
FROM hr_order_type where id='$rs[order_type]'";
$resultx = mysql_db_query('edubkk_master',$sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
$rsx=mysql_fetch_array($resultx);
echo  substr( $rsx[order_type],0,50);
	  ?></td>
      
      <?php if(SALARY_COMMENT=='1'){ ?><td align="center"><?php if($rs[note]!=''){ ?><a id="toolt" href="#" title="<?=$rs[note]?>">?</a><?php }else{ echo "-"; } ?></td> <?php } ?> 
      
	  <td align="center"><a href="salary.php?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&v=0&action=edit2#keys">
	    <img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> 
	    &nbsp; <?=$del_icon?>	</td>   
         
  </tr>
  <?
	} //while
// List Template
?>
  <tr bgcolor="#dddddd" align="center">
    <td colspan="9"><input type="button" name="viewall" value="เรียงลำดับข้อมูลและแสดงผลข้อมูลทั้งหมด"  onClick="location.href='salary.php?action=edit&viewall=1' ">
    <input type="button" name="viewperiod" value="ข้อมูลรายปี" onClick="location.href='salary.php?action=edit&viewall=2&YY=<?=$d[0]?>' ">
    <input type="button" name="viewdata" value="กลับหน้าแรก" onClick="location.href='salary.php?action=edit&viewall=5' ">    </td>
  </tr>
  </table>
<?
}
else if($viewall==1)
{
$i 			= 0;
$result 	= mysql_db_query($dbname,"select * from salary where id='$id' order by runno asc;")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
$row		= mysql_num_rows($result);
?>
<?
$res 	= mysql_db_query($dbname,"select * from salary where id='$id'  order by date DESC limit 1;")or die("Query line ". __LINE__ ." error<hr>".mysql_error());

$rr=mysql_fetch_array($res,MYSQL_ASSOC);
 	$d=explode("-","$rr[date]");
 
	$dmore=$d[0];
?>
	<center>
	<div id="showMsg" style="width:100%;height:150px;padding-top:5px;padding-left:5px;text-align:left;font-weight:bold;margin-bottom:0">
    <div style="width:48%;height:120px;padding-top:5px;padding-left:5px;text-align:left;border:#000000 solid 1px;">
   <h1> <font color="#FF0000">วิธีการจัดลำดับ</font></h1>
    <ol>
    	<li>เลือกบรรทัดที่ต้องการจัดลำดับ</li>
        <li>กดเมาส์ค้างในรายการที่ต้องการจัดลำดับ</li>
        <li>แล้วลากไปยังลำดับรายการที่ต้องการ แล้วปล่อยเมาส์</li>
    </ol>
    </div>
    </div>
    </center>
  <form name="form1" method="post" action="<?=$PHP_SELF?>">			
  <input type="hidden" name="action" value="changeRow">
    
  <input type="hidden" NAME="id" VALUE="<?=$id?>">

  <table width="100%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="black" id="order_table" style="margin-top:0;">
  <thead>
  <tr bgcolor="#A3B2CC" align="center">
  <th height="27" colspan="10" bgcolor="#2C2C9E"><span class="style1">การเลื่อนขั้นตำแหน่ง(แสดงข้อมูลทั้งหมด)</span></th>
  </tr>
  <tr bgcolor="#A3B2CC" align="center" style="font-weight:bold;">
    <th width="6%">ลำดับใหม่</th>
	  <th width="9%"><strong>วัน เดือน ปี</strong></th>
	  <th width="27%"><strong>ตำแหน่ง</strong></th>
	  <th width="10%"><strong>เลขที่<br>
	    ตำแหน่ง</strong></th>
	  <th width="4%"><strong>ระดับ</strong></th>
	  <th width="6%"><strong>อัตรา<br>
	    เงินเดือน</strong></th>
	  <th width="16%"><strong>เอกสารอ้างอิง</strong></th>
	  <th width="14%">ประเภทคำสั่ง</th>
       <th width="8%"><input type="button" name="add2" value="เพิ่มข้อมูล" onClick="location.href='salary.php?id=<?=$id?>&v=1&action=edit1' "></th>    
  </tr>
  </thead>
  <tbody>
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
$sys_type=$rs[system_type];
$title="";
if($sys_type!="" and  $sys_type!="SYSTEM_ELEC" and $useredit < 1){
	$bg="#66FF00";
	if($sys_type=="SYSTEM_TRANSFER"){
		$title="บันทึกผ่านระบบแต่งตั้งโยกย้าย";		
		}else{
	     $title="บันทึกผ่านระบบเลื่อนขั้นเงินเดือน";		
	}	

	$del_icon = "<img src=\"../../../images_sys/b_drop_disable.png\" width=\"13\" height=\"13\" border=\"0\" title=\"ไม่สามารถลบได้เนื่องจาก $title \">";
}elseif(trim($_SESSION[session_staffid])=="" && substr($rs['date'],0,4)<=2547){
	$title="ข้อมูลถูกบันทึกก่อนปี 2547";		
	$del_icon = "<img src=\"../../../images_sys/b_drop_disable.png\" width=\"13\" height=\"13\" border=\"0\" title=\"ไม่สามารถลบได้เนื่องจาก $title \">";
}else{
	$del_icon = "<a href=\"#\" 
	onClick=\"if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=$rs[id]&runid=$rs[runid]&v=1&rem=".urlencode($rs[noorder])." '\" >
	      <img src=\"bimg/b_drop.png\" width=\"16\" height=\"16\" border=\"0\" title=\"Delete\"></a>";	
}
##########  label เลขที่ตำแหน่ง
	if($rs[label_noposition] != "" and $rs[label_noposition] != NULL){
			$show_noposition = $rs[label_noposition];
	}else{
			$show_noposition = $rs[noposition];
	}

?>
  <tr bgcolor="<?=$bg?>" title="<?=$title?>" id="<?php echo $rs[runid]; ?>">
    <td align="center"><?php echo $i; ?></td>
	  <td align="center"><?=$dateshow?></td>
	  <td align="left">&nbsp;
	    <?=$rs[pls]?></td>
	  <td align="center"><?=$show_noposition?></td>
	  <td align="center"><?=$radub?></td>
	  <td align="center"><?=$salary?>&nbsp;</td>
	  <td align="left"><?=$noo." ".$rinstruct?>
        <input type="hidden" name="runid[]22" value="<?=$rs[runid]?>">
        <?=$dateorder?></td>
	  <td align="left"><?
      $sql="SELECT
id,
order_type,
orderby
FROM hr_order_type where id='$rs[order_type]'";
$resultx = mysql_db_query('edubkk_master',$sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
$rsx=mysql_fetch_array($resultx);
echo  substr($rsx[order_type],0,50);
	  ?></td>
         <td align="center"><a href="salary.php?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&v=1&Y=all&action=edit2#keys">
	    <img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> 
	    &nbsp; <?=$del_icon?>	</td>    
	 
  </tr>
  <?
	} //while
// List Template
?>
</tbody>
  </table>
  
  <center>
  <table width="100%" style="border:#000000 solid 2px;margin-top:5px;">
  <tr bgcolor="#dddddd" align="center">
    <td colspan="8"><input type="button" name="viewall" value="เรียงลำดับข้อมูลและแสดงผลข้อมูลทั้งหมด"  onClick="location.href='salary.php?action=edit&viewall=1' ">
      <input type="hidden" NAME="viewall" VALUE="1"><input type="button" name="viewall" value="ข้อมูล5ปีย้อนหลังนับจากปัจจุบัน"  onClick="location.href='salary.php?action=edit&viewall=0' ">
      <input type="button" name="viewperiod2" value="ข้อมูลรายปี" onClick="location.href='salary.php?action=edit&viewall=2&YY=<?=$dmore?>' ">
      <input type="button" name="viewdata2" value="กลับหน้าแรก" onClick="location.href='salary.php?action=edit&viewall=5' "></td>
  </tr>
  </table>
  </center>
  
  </form>
  
  <?
  }//END view==1
else if($viewall=2)

{
?>

<input type="hidden" NAME="id" VALUE="<?=$id?>">
<table width="100%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
  <tr bgcolor="#A3B2CC" align="center"><? $sql_yy="SELECT DISTINCT substring(`salary`.`date`,1,4) as Y FROM `salary` WHERE  id='$id'  order by date DESC ";
		$query_yy=mysql_db_query($dbname,$sql_yy)or die (mysql_error());
		while($rsy=mysql_fetch_assoc($query_yy))	
		{
		echo "<a href=\"salary.php?action=edit&viewall=2&YY=$rsy[Y]\">$rsy[Y]</a> | ";
		
		}
		 $sql_data="select * from salary where id='$id' and date like '$YY%'  order by runno ASC";
		
		$q_data=mysql_db_query($dbname,$sql_data) or die (mysql_error());
		
		?>
		
    <td colspan="9" align="left" bgcolor="#2C2C9E"></td>
  </tr>
  <tr bgcolor="#A3B2CC" align="center">
  <td height="27" colspan="9" bgcolor="#2C2C9E"><span class="style1">การเลื่อนขั้นตำแหน่ง(แสดงข้อมูลช่วงปี)</span></td>
  </tr>
  <tr bgcolor="#A3B2CC" align="center" style="font-weight:bold;">
    <td width="10%"><strong>วัน เดือน ปี</strong></td>
	  <td width="32%"><strong>ตำแหน่ง</strong></td>
	  <td width="9%"><strong>เลขที่<br>
	    ตำแหน่ง</strong></td>
	  <td width="5%"><strong>ระดับ</strong></td>
	  <td width="6%"><strong>อัตรา<br>
	    เงินเดือน</strong></td>
	  <td width="20%"><strong>เอกสารอ้างอิง</strong></td>
	  <td width="9%">ประเภทคำสั่ง</td>
	  <td width="9%"><input type="button" name="add3" value="เพิ่มข้อมูล" onClick="location.href='salary.php?id=<?=$id?>&v=2&YY=<?=$YY?>&action=edit1' "></td>    
  </tr>
  
  <?
while ($rs=mysql_fetch_array($q_data,MYSQL_ASSOC)){
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
$sys_type=$rs[system_type];
$title="";
if($sys_type!="" and  $sys_type!="SYSTEM_ELEC" and $useredit < 1){
	$bg="#66FF00";
	if($sys_type=="SYSTEM_TRANSFER"){
		$title="บันทึกผ่านระบบแต่งตั้งโยกย้าย";		
		}else{
	     $title="บันทึกผ่านระบบเลื่อนขั้นเงินเดือน";		
	}	
	$del_icon = "<img src=\"../../../images_sys/b_drop_disable.png\" width=\"13\" height=\"13\" border=\"0\" title=\"ไม่สามารถลบได้เนื่องจาก $title \">";
}elseif(trim($_SESSION[session_staffid])=="" && substr($rs['date'],0,4)<=2547){
	$title="ข้อมูลถูกบันทึกก่อนปี 2547";		
	$del_icon = "<img src=\"../../../images_sys/b_drop_disable.png\" width=\"13\" height=\"13\" border=\"0\" title=\"ไม่สามารถลบได้เนื่องจาก $title \">";
}else{
	$del_icon = "<a href=\"#\" 
	onClick=\"if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=$rs[id]&runid=$rs[runid]&v=2&YY=$YY&rem=".urlencode($rs[noorder])." '\" >
	      <img src=\"bimg/b_drop.png\" width=\"16\" height=\"16\" border=\"0\" title=\"Delete\"></a>";	
}

##########  label เลขที่ตำแหน่ง
	if($rs[label_noposition] != "" and $rs[label_noposition] != NULL){
			$show_noposition = $rs[label_noposition];
	}else{
			$show_noposition = $rs[noposition];
	}



?>
  <tr bgcolor="<?=$bg?>" title="<?=$title?>">
    <td align="left">&nbsp;      <?=$dateshow?></td>
	  <td align="left">&nbsp;
        <?=$rs[pls]?></td>
	  <td align="center"><?=$show_noposition?></td>
	  <td align="center"><?=$radub?></td>
	  <td align="right"><?=$salary?>&nbsp;</td>
	  <td align="left"><?=$noo." ".$rinstruct?>
        <input type="hidden" name="runid[]222" value="<?=$rs[runid]?>">
        <?=$dateorder?></td>
	  <td align="left"><?
      $sql="SELECT
id,
order_type,
orderby
FROM hr_order_type where id='$rs[order_type]'";
$resultx = mysql_db_query('edubkk_master',$sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
$rsx=mysql_fetch_array($resultx);
echo  substr( $rsx[order_type],0,50);
	  ?></td>
	  <td align="center"><a href="salary.php?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&v=2&YY=<?=$YY?>&action=edit2#keys">
	    <img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> 
	    &nbsp; <?=$del_icon?></td>    
  </tr>
  <?
	} //while
// List Template
?>
  <tr bgcolor="#dddddd" align="center">
    <td colspan="8"><input type="button" name="viewall" value="เรียงลำดับข้อมูลและแสดงผลข้อมูลทั้งหมด"  onClick="location.href='salary.php?action=edit&viewall=1' ">
      <input type="button" name="viewall2" value="ข้อมูล 5 ปีย้อนหลังนับจากปัจจุบัน"  onClick="location.href='salary.php?action=edit&viewall=0' ">
      <input type="button" name="viewdata3" value="กลับหน้าแรก" onClick="location.href='salary.php?action=edit&viewall=5' "></td>
  </tr>
  </table>
<?
	}//END viewall==2	
}//END IF(action==edit)

  else
  {
if ($_GET[action]=="edit2"){

		$sql 		= "select * from salary where id='$id' and runid = '$runid'   ;";
		$result 	= mysql_db_query($dbname,$sql);
		if ($result){
			$rs = mysql_fetch_array($result,MYSQL_ASSOC);
		}
		
}else{
	//	$sql = "select max(radub) as radub,max(salary) as salary, max(position) as position , max(noposition) as noposition from salary where id='$id'   ;";
	$sql 		= "select position_id,radub,salary,position,pos_group,noposition,dateorder,instruct,level_id from salary  where id='$id' order by runno desc limit 1";
	$result 	= mysql_db_query($dbname,$sql);
	$rs		= mysql_fetch_assoc($result);
}
?>
  <a name="keys"></a>
  <form method="post" name="post" action="<?=$PHP_SELF?>" onSubmit="return check();">
  <input type="hidden" NAME="id" VALUE="<?=$id?>">
  <input type="hidden" NAME="err_massage" VALUE="">
  
  <input type="hidden" NAME="v" VALUE="<?=$v?>">
    <input type="hidden" NAME="YY" VALUE="<?=$YY?>">
  <input type="hidden" NAME="runid" VALUE="<?=$runid?>">
  <input type="hidden" NAME="action" VALUE="<?=$_GET[action]?>">	
	<? $SQL_gen="select * from general  where idcard='$id' ";
		$query_gen=mysql_db_query($dbname,$SQL_gen)or die (mysql_error());
		$r_gen=mysql_fetch_assoc($query_gen);
	 ?>
	 <input type="hidden" name="sc_gen" value="<?=$r_gen[schoolid]?>">
	 <input type="hidden" name="site_gen" value="<?=$r_gen[siteid]?>">
<?
$xschool=$r_gen[schoolid];
?>
  <table width="100%" border="0" cellspacing="3" cellpadding="2" align="center">
            <!--############## อิเล็กทรอนิกส์นำหน้ากระดาษ ##############-->
            <?
			if($action=="edit1" || $action=="edit2"){
            $statusConfigElec=checkStatusConfigElec($staffid);
            if($statusConfigElec!=""){
				
				if($rs[system_type] != "" and $rs[system_type] != "SYSTEM_ELEC"){
					$disb1 = " disabled='disabled'";	
					$txt_data = "ประมวลผลโดยระบบ";
				}else{
					$disb1 = "";	
					$txt_data = "อิเล็กทรอนิกส์นำหน้ากระดาษ";
				}
				$tabin="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            ?>
            <tr>
            <td></td>
            <td>
            
                    <table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">        
                            <tr>
                                    <td>
                                    <input type="checkbox" name="elec_paper" id="check_enable" value="" <? if($rs[system_type]=="SYSTEM_ELEC" || $rs[system_type]=="SYSTEM_SALARYUP_COMMAND"){echo 'checked="checked"'; }?> /> บันทึกโดยระบบ<br />
                                    <input type="radio" name="elec_paper" value="SYSTEM_ELEC" id="elec_paper" <?=($rs[system_type]=="SYSTEM_ELEC")?'checked="checked"':''?> <? //$disb1?>> อิเล็กทรอนิกส์นำหน้ากระดาษ<? //$txt_data?><br />
                                    <?=$tabin?><input type="radio" name="elec_paper" value="SYSTEM_SALARYUP_COMMAND" id="upsalary" <?=($rs[system_type]=="SYSTEM_SALARYUP_COMMAND")?'checked="checked"':''?> <? //$disb1?>> บันทึกคำสั้งเลื่อนเงินเดือน
                                    </td>
                            </tr>
                    </table>
            
            </td>
            <td></td>
            </tr>
            <? }}?>
            <!--############## END อิเล็กทรอนิกส์นำหน้ากระดาษ ##############-->
  <tr >
    <td width="174" align="right" >มีผล ณ : <br>
      (วัน เดือน ปี ) </td>
    <td align="left" valign="top"><? if($action=="edit1"){?>
    	
      <table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">
        
        <tr>
          <td><input type="radio" name="checkdate" value="0" id="checkdate1" onClick="clearselect();"   >ไม่ระบุวันที่            </td>
        </tr>
        <tr>
          <td><input type="radio" name="checkdate" value="1"  id="checkdate2" checked="checked" onClick="bbb();">
ระบุวันที่ </td>
        </tr>
        
		
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="2">
            <tr>
              <td><table width="100%" border="0" cellpadding="1" cellspacing="0">
    <tr>
      <td width="43%"><? //dateInput1($rs[date],"salary");?>
        <input  type="hidden" name="datebr"  id="datebr" value="<?=$rs[date]?>">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<select name="salary_day" id="salary_day" onBlur="onobjChange(); Check_numberPosition('onblur'); check_GetVitayaCase();">
				<?

					/*	echo "<option value=''> ไม่ระบุ </option>";
						for ($i=1;$i<=31;$i++){
						$di=sprintf("%02d",$i);
						echo "<option value= $di>" .  $di . "</option>";
						}*/
				?>
				</select>
				<select name="salary_month" id="salary_month"  onblur="onobjChange();  Check_numberPosition('onblur'); check_GetVitayaCase();">
				<?
				/*echo "<option value=''>ไม่ระบุ</option>";
				for ($i=1;$i<=12;$i++){
				$xi = sprintf("%02d",$i);
				echo "<option value='$xi'>$month[$i]</option>";
				}*/
				?>
				</select>
				<select name="salary_year" id="salary_year" onBlur="onobjChange();  Check_numberPosition('onblur'); check_GetVitayaCase();">
				<?
				/*echo "<option value=''>ไม่ระบุ</option>";
				$thisyear = date("Y") + 543;
				$y1 = $thisyear - 80;
				$y2 = $thisyear ;
									
				for ($i=$y1;$i<=$y2;$i++){
						echo "<option value=$i>$i</option>";
				}*/
				
				?>
				</select>
 
</td>
      <td width="57%"><span class="style10">*รูปแบบการแสดงผลของวันที่คือ 12 ม.ค. 2551 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7</span></td>
    </tr>
  </table></td>
            </tr>
            
            <tr>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input  type="hidden" name="value_date"  id="value_date" value=""  />
                &nbsp;
			  <input name="label_date" id="label_date" type="text" value="<?=$rs[label_date]?>" size="20" maxlength="100">
			  <input  type="hidden" name="chk_date"  id="chk_date" value="true"  />
       <script>
	   		generate_calendarlist('value_date','label_date','salary_day','salary_month','salary_year','','','');
			<?php /*?>create_calendar('salary_day','salary_month','salary_year','','','');<?php */?>
		</script>  
			  <span class="style10">หากท่านบันทึกในชองแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
            </tr>
            
          </table></td>
        </tr>
    </table>
    <? }if($action=="edit2"){?>
                
	<table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">
        
        <tr>
          <td><input type="radio" name="checkdate" value="0" <? if($rs[date] ==""){echo "checked";}?>  id="checkdate1" onClick="clearselect();">
ไม่ระบุวันที่
  <input type="hidden" name="olddate" value="<?=$rs[date]?>"></td>
        </tr>
        <tr>
          <td><input type="radio" name="checkdate" value="1" <? if($rs[date] !=""){echo "checked";}?>  id="checkdate2" onClick="bbb();">
เปลี่ยนแปลงวันที่ใหม่</td>
        </tr>
        
        
		
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="2">
            <tr>
              <td><table width="100%" border="0" cellpadding="1" cellspacing="0">
    <tr>
      <td width="43%"><? //dateInput1($rs[date],"salary");?>
        <input  type="hidden" name="datebr2"  id="datebr2" value="<?=$rs[date]?>">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		<?  
		$d1=explode("-",$rs[date]);
		
		
		if ($d1[2] ==''){$dist="disabled";} 
		if ($d1[1]==''){$dist1="disabled";}
		if ($d1[0]==''){$dist2="disabled";}
	//	if($check_date==1 and $label_date=="")
	//	{
	//	$dist_label="disabled";
	//	}
	//	else if($check_date==0){ $dist_label="disabled";}
		
		
		?>
        <select name="salary_day" <?=$dist ?>  id="salary_day" onBlur="onobjChange();  Check_numberPosition('onblur'); check_GetVitayaCase();">
				<?
/*						$d1=explode("-",$rs[date]);
						echo "<option value=''> ไม่ระบุ </option>";
						for ($i=1;$i<=31;$i++){
						  $di=sprintf("%02d",$i);
						if (intval($d1[2])== $i){
						echo "<option value='$di' SELECTED>" . $di. "</option>";
						}else{
								echo "<option>" .  sprintf("%02d",$i) . "</option>";
								}
						}*/
				?>
				</select>
				<select name="salary_month"<?=$dist1?> id="salary_month"  onblur="onobjChange();  Check_numberPosition('onblur'); check_GetVitayaCase();">
				<?
				/*echo "<option value=''>ไม่ระบุ</option>";
				for ($i=1;$i<=12;$i++){
					$xi = sprintf("%02d",$i);
					if (intval($d1[1])== $xi){
				//		echo "<option value='$xi' SELECTED>$xi</option>";
						echo "<option value='$xi' SELECTED>$month[$i]</option>";
					}else{
				//		echo "<option value='$xi'>$xi</option>";
						echo "<option value='$xi'>$month[$i]</option>";
					}
				}*/
				?>
				</select>
				<select name="salary_year" id="salary_year" <?=$dist2 ?>  onblur="onobjChange();  Check_numberPosition('onblur'); check_GetVitayaCase();" >
				<?
				/*echo "<option value=''>ไม่ระบุ</option>";
				$thisyear = date("Y") + 543;
				$y1 = $thisyear - 80;
				$y2 = $thisyear ;
									
				for ($i=$y1;$i<=$y2;$i++){
					if ($d1[0]== $i){
						echo "<option  value='$i' SELECTED>$i</option>";
					}else{
						echo "<option value='$i'>$i</option>";
					}
				}*/
				?>
				</select>              
                </td>
      <td width="57%"><span class="style10">*รูปแบบการแสดงผลของวันที่คือ 12 ม.ค. 2551 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7</span></td>
    </tr>
  </table></td>
            </tr>
            
            <tr>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;<span class="style2">&nbsp;</span>&nbsp;
                <input  type="hidden" name="value_date"  id="value_date" value=""  />
                &nbsp;
                <input name="label_date" id="label_date" type="text" value="<?=$rs[label_date]?>" size="20" maxlength="100" >
                 <input  type="hidden" name="chk_date"  id="chk_date" value="true"  />
<script>
	generate_calendarlist('value_date','label_date','salary_day','salary_month','salary_year','<?=$d1[2]?>','<?=$d1[1]?>','<?=$d1[0]?>');
	<?php /*?>create_calendar('salary_day','salary_month','salary_year','<?=$d1[2]?>','<?=$d1[1]?>','<?=$d1[0]?>');<?php */?>
</script>     
                <?
			if($intraip_st){
			//echo "yy".$salary_year;
			 $temp_day= explode("-",$rs[date]);
			 $yy = $temp_day[0]-543;
			 $mm = $temp_day[1];
			 $dd = $temp_day[2];
			 $sent_day = $yy."-".$mm."-".$dd;
				echo option_day($sent_day);
			  }
			  ?>
               
                <span class="style10">หากท่านบันทึกในชองแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
            </tr>
            
          </table></td>
        </tr>
    </table>
	<? }?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">
      ตำแหน่ง :<br>
      (ใน ก.พ.7) </td>
    <td width="787" align="left" valign="top"><table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">
        <tr>
          <td><span class="style8">ให้นำข้อมูลที่อยู่ในช่องตำแหน่งใน ก.พ. 7 มากรอก เช่น อาจารย์1 โรงเรียน xxxxx สพท.xxxx เป็นต้น </span></td>
        </tr>
        <tr>
          <td><textarea name="pls" cols="100" rows="5" id="pls"><? echo "$rs[pls]";?></textarea></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td align="left" valign="top"><span class="style8">**ส่วนปรับเปลี่ยนตำแหน่งและระดับ/อัตราเงินเดือน และ วิทยฐานะ กรุณากรอกข้อมูลให้ครบทั้งสามแท็บก่อนบันทึก </span></td>
  </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td align="left" valign="top"><table width="580" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td> <div class="tabber">
            <div class="tabbertab">
              <h2>ปรับเปลียนตำแหน่งและระดับ</h2>
              <table width="100%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
                <tr bgcolor="#dddddd">
                  <td height="20" colspan="2">&nbsp;<b><u>ส่วนปรับเปลี่ยนตำแหน่งและระดับ</u></b></td>
                </tr>
                
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">สายงาน :</td>
                  <td>
                  <select name="hr_addposition_group" id="hr_addposition_group" style="width:250px;" onChange="getposition(this.value);">
                  <option value="" class="warn">ไม่ระบุ</option>
                  <?
				  $sql="SELECT hr_positiongroup.positiongroupid as id , hr_positiongroup.positiongroup as value FROM hr_positiongroup  where  status_active='1' and  hr_positiongroup.positiongroupid =(SELECT left(hr_addposition_now.pid ,1)  FROM hr_addposition_now where hr_addposition_now.`position`='$rs[position]' limit 1)";				  
				  $re_postgroup=mysql_db_query("edubkk_master",$sql);
				  $row_postgroup=mysql_fetch_array($re_postgroup);
				  $id_postgroup=$row_postgroup[id];
                  $sql="SELECT  positiongroupid as id ,positiongroup as value FROM hr_positiongroup  where  status_active='1' order by  positiongroupid";
				  echo trim(getOption2($sql,$id_postgroup));
				  ?>
                  
                  </select></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">ตำแหน่ง&nbsp;<b>:</b>&nbsp;</td>
                  <td>
                  <?
                  $tempDate=$d1[2]."/".$d1[1]."/".$d1[0];
				  $sql_tempPosition=genSQLposition($tempDate,'THA',$id_postgroup);
				  ?>
                  <div id="hr_addposition">
                    <select name="hr_addposition"  id="hr_addposition"  style="width:250px;" onChange="check_dis_vitaya(this.value); getradub(this.value) ;" onBlur="onobjChange();">
                      <option value="" class="warn">ไม่ระบุ</option>
                      <?
					  
					//echo  trim(getOption2(" select pid as id, position as value from $dbnamemaster.hr_addposition_now where pid like '$id_postgroup%' order by position; ", $rs[position_id]));
					  echo  trim(getOption2( $sql_tempPosition, $rs[position_id]));
				  
					  ?>
                    </select>
                  </div></td>
                </tr>
                
                <tr bgcolor="#f8f8f8">
                  <td width="30%" height="25" align="right">เลขที่ตำแหน่ง&nbsp;<b>:</b>&nbsp;</td>
                  <td width="70%"><input type="text" name="noposition" id="noposition" size="25" value="<?=$rs[noposition]?>" onBlur="onobjChange(); Check_numberPosition('on_blur');"></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">แสดงผลเลขที่ตำแหน่งในก.พ.7 : </td>
                  <td><label>
                    <input type="text" name="label_noposition_2" id="label_noposition_2" size="25" value="<?=$rs[label_noposition]?>" onBlur="showValuePostion(); chkNumPostion_label();"><span id="msg_label_noposition"></span>
                    <input type="hidden" name="label_noposition" id="label_noposition" size="25" value="<?=$rs[label_noposition]?>"  />
                    <input  type="hidden" name="chk_noposition"  id="chk_noposition" value="true"  />
                  </label></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">&nbsp;</td>
                  <td><span class="style8"><span class="style10">หากท่านบันทึกในชองแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></span></td>
                </tr>
                
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right"><?=TEXT_RADUB?>&nbsp;<b>:</b>&nbsp;</td>
                  <td><div id="hr_addradub">
                      <select name="hr_addradub"  id="hr_addradub" style="width:154px;" onChange="return  getvitaya(this.value) ; " onBlur="onobjChange();">
                        <option value="" class="warn">ไม่ระบุ</option>
                        <? //  
						$sql="SELECT
						hr_addposition_now.`position`,
						hr_addradub.radub as value,
						hr_addradub.level_id as id
						FROM
						position_math_radub
						Inner Join hr_addposition_now ON hr_addposition_now.runid = position_math_radub.position_id
						Inner Join hr_addradub ON position_math_radub.radub_id = hr_addradub.runid where hr_addposition_now.`position`='$rs[position]' order by hr_addradub.radub";
					
					echo getOption2($sql, $rs[level_id])?>
                      </select>
                      <?
					 	
					  //echo $sql;
					  
					  /*<img	src="images/web/index_add.gif" alt="เพิ่มข้อมูล" width="20" height="20" align="absmiddle"
	onclick="popWindow('addElement.php?table=hr_addradub','400','300')" style="cursor:hand;" />*/ ?>
                  </div>
                  
                  <?
                   echo"<script>def_radub='$rs[level_id]'</script>";
				  ?></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">แสดงผลระดับในก.พ.7 &nbsp;<b>:</b>&nbsp;</td>
                  <td><input type="text" name="label_radub" value="<?=$rs[label_radub]?>">
                    <span class="style10"><br>
                    หากท่านบันทึกในชองแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
                </tr>
              </table>
            </div>
          <div class="tabbertab">
              <h2>ปรับเปลียนอัตราเงินเดือน</h2>
            <table width="100%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
                <tr bgcolor="#dddddd">
                  <td height="20" colspan="2">&nbsp;<b><u>ส่วนปรับเปลี่ยนอัตราเงินเดือน</u></b></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td width="21%" height="25" align="right">อัตราเงินเดือน&nbsp;<b>:</b>&nbsp;</td>
                  <td width="79%"><input name="salary" type="text" id="salary" value="<?=number_format($rs[salary])?>" style="width:100px;" onKeyPress=" return noSring(event);" onKeyUp="javascript:this.value=Comma(this.value);" onBlur=" checkmod_salary(this.value) ;checklevel_salary();" onFocus="javascript:salary_pre=this.value;this.select()"   />                    <span id="check_salary"></span>
                   <span class="style8">&nbsp;&nbsp;&nbsp;**กรุณากรอกเฉพาะตัวเลขเท่านั้น</span></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">&nbsp;ส่วนแสดงผลใน ก.พ.7&nbsp;<b>:</b>&nbsp;</td>
                  <td><input name="label_salary" type="text" id="label_salary" style="width:100px;" value="<?=$rs[label_salary]?>" onBlur="check_sum1();">
                   <input  type="hidden" name="chk_salary"  id="chk_salary" value="true"  />
                    <span class="style8">&nbsp;&nbsp;<br>
                    <span class="style10">หากท่านบันทึกในชองแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></span></td>
                </tr>
              </table>
          </div>
          <? 
		  if($_SESSION['tmpuser'] != ""){
		  ?>
          <div class="tabbertab">
              <h2>ปรับเปลี่ยนวิทยฐานะ</h2>
            <table width="100%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
                <tr bgcolor="#dddddd">
                  <td height="20" colspan="2">&nbsp;<b><u>ส่วนปรับเปลี่ยนวิทยฐานะ</u></b></td>
                </tr>
               <!-- <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">ยกเลิกวิทยฐานะเดิม</td>
                  <td><label>
                    <input type="checkbox" name="clear_vitaya" value="1" id="clear_vitaya" onClick="return dis_box_vitaya(this);">
                    <span class="style8">**เลือก กรณีต้องการยกเลิกวิทยฐานะเดิม**</span></label></td>
                </tr>-->
                <tr bgcolor="#f8f8f8">
                  <td width="30%" height="25" align="right">ปรับเปลียนวิทยฐานะเป็น <b>:</b></td>
                  <td width="70%" id="hr_vitaya">&nbsp;
                      <? 
		//$sql_stat="SELECT * FROM vitaya_stat where id='$id'";
$xsql_s="SELECT * FROM vitaya_stat WHERE id='$id' and remark='$rs[noorder]' ";
	$xquery=mysql_db_query($dbname,$xsql_s);
	$xrs_s=mysql_fetch_array($xquery,MYSQL_ASSOC);
	$remark=$xrs_s[remark];
	$vitaya_major_id=$xrs_s[vitaya_major_id];
	$vitaya_major=$xrs_s[vitaya_major];
	$vitaya_ref=$xrs_s[vitaya_ref];
	$vitaya_work=$xrs_s[vitaya_work];
	$vitaya_work_type=$xrs_s[vitaya_work_type];
	$xrs_s[name];
	//echo $dbname ;
echo "<script>  def_vistaya='$xrs_s[name]';\n
                xvitaya='$xrs_s[vitaya_id]';\n
				sdate='$xrs_s[date_start]'\n;
                cdate='$xrs_s[date_command]'\n;</script>";

/*	$sql="SELECT
position_math_vitaya.position_id,
hr_addposition_now.`position`,
vitaya.runid,
vitaya.vitayaname
FROM
position_math_vitaya
Inner Join hr_addposition_now ON hr_addposition_now.runid = position_math_vitaya.position_id
Inner Join vitaya ON position_math_vitaya.vitaya_id = vitaya.runid
where hr_addposition_now.`position`= '$rs[position]' order by vitaya.orderby";
*/
 $sql="SELECT DISTINCT
vitaya.vitayaname AS value,
vitaya.runid AS id,
hr_addradub.radub ,
hr_addradub.level_id 
FROM
vitaya
Inner Join radub_math_vitaya ON radub_math_vitaya.vitaya_id = vitaya.runid
Inner Join hr_addradub ON hr_addradub.level_id = radub_math_vitaya.level_id where 
radub_math_vitaya.level_id='$rs[level_id]'  order by vitaya.orderby";
	

	
	//$xsql_v=mysql_query("SELECT * FROM $dbnamemaster.vitaya");
	$xsql_v=mysql_db_query('edubkk_master',$sql);
				
	  ?>
                      <select name="vitaya" id="vitaya"  onchange="onobjChange();">
                        <?	
			
			echo "<option value=''>ไม่ระบุวิทยฐานะ</option>";
		
				
			
	while ($xrs_v=mysql_fetch_array($xsql_v,MYSQL_ASSOC))
			{	
		 		if ($xrs_s[vitaya_id] == $xrs_v[id])
					{ 			
					echo "<option value='$xrs_v[id]' SELECTED>$xrs_v[value]</option>";
					}
				else
					{
					echo "<option value='$xrs_v[id]'>$xrs_v[value]</option>";
					}
			}//end while
			
	/*		
			 echo " <option value=''if($xrs_v[name]==''){ selected }>ไม่มี</option>";
			while($xrs_v=mysql_fetch_array($xsql_v))
			{
             echo " <option value='$xrs_v[name]'  if($xrs_v[name]==$val){ selected}> $rsx[name]</option>";
			}*/ ?>
                      </select></td>
                </tr>
             <!--   <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">กล่มสาระที่ทำวิทยฐานะ:</td>
                  <td id="hr_vitaya2">
                  <select name="vitaya_major_group_id" id="vitaya_major_group_id" style="width:200px" onChange="get_vitaya_major('vitaya_major_id',this.value);">
                  <option value="" >ระบุกลุ่มสาระ</option>
                  <?
			/*	  $sql="SELECT
					major_reqvitaya.major_group
					FROM `major_reqvitaya` where major_reqvitaya.majorcode='$vitaya_major_id'";
				  $result_major=mysql_db_query($dbnamemaster,$sql);
				  $row_major=mysql_fetch_array($result_major);				  
				  $sub_id = $row_major[major_group];				  
					$sql="SELECT
					hr_addmajorgroup.major_group_id as id,
					hr_addmajorgroup.major_group as value
					FROM `hr_addmajorgroup`";
				  $result_major=mysql_db_query($dbnamemaster,$sql);
				  while($row=mysql_fetch_array($result_major)){
					  $sel=($sub_id==substr($row[id],0,1)||strlen($vitaya_major_id)==strlen($row[id]))?" selected ":"";
				 echo"<option value=\"$row[id]\" title=\"$row[value]\"  $sel >$row[value]</option>\n";	  
					  }*/
				  
				  ?>
                  
                  </select></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">วิชาเอกที่ทำวิทยฐานะ:</td>
                  <td id="hr_vitaya3"><select name="vitaya_major_id" id="vitaya_major_id" style="width:200px">
                  <option value="" >สาขาวิชาเอก</option>
                  <?
                  
/*					 $sql="SELECT					
					major_reqvitaya.majorname as value,
					major_reqvitaya.majorcode as id,
					major_reqvitaya.major_group
					FROM `major_reqvitaya` where major_reqvitaya.major_group='$sub_id'";
$result=mysql_db_query($dbnamemaster,$sql);
while($row=mysql_fetch_array($result)){
 $sel=($vitaya_major_id==$row[id])?" selected ":"";
  echo"<option value=\"$row[id]\" title=\"$row[value]\"  $sel >$row[value]</option>\n";
}
		*/		  ?>
                  </select></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">ประเภทผลงานวิชาการ:</td>
                  <td id="hr_vitaya4"><select name="vitaya_work_type" id="vitaya_work_type" style="width:200px">
                    <option value="" >ประเภทผลงานทางวิชาการ</option>
                    <?
   /*               $sql="SELECT id,caption,orderby FROM `vitaya_work_type` order by  orderby ";
				  $result_major=mysql_db_query($dbnamemaster,$sql);
				  while($row=mysql_fetch_array($result_major)){
					  $sel=($vitaya_work_type==$row[id])?" selected ":"";
				 echo"<option value=\"$row[id]\" title=\"$row[caption]\"  $sel >$row[caption]</option>\n";	  
					  }*/
				  
				  ?> 
                  </select></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">ชื่อผลงานทางวิชาการ:</td>
                  <td id="hr_vitaya5"><input name="vitaya_work" type="text" id="vitaya_work" size="70" maxlength="255"  value="<?=$vitaya_work?>"/></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">&nbsp;</td>
                  <td bgcolor="#f8f8f8"><span class="style8">**ในกรณีที่รายการวิทยฐานะถูกปิดไว้เนื่องระดับตำแหน่งที่ท่านเลือก<br>
                   ไม่สามารถมีวิทยฐานะได้**</span></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">&nbsp;</td>
                  <td bgcolor="#f8f8f8"><span class="style8">**เลือกวิทยฐานะในกรณี เป็นคำสั่งแต่งตั้งวิทยฐานะเท่านั้น**<br />
                    **ระบุสาขาวิชาที่ทำวิทยฐานะ ถ้ามี**                  </span></td>
                </tr>-->
              </table>
            <? 
	  /*<input name="vitaya_sts" type="radio" value="0" <? if($xrs_s[dateorder] != $xrs_v[date_command]){ echo "checked";}/?>>
      //เป็นคำสั่งที่ไม่เกี่ยวข้องกับการได้รับ/ปรับเลื่อนวิทยฐานะ<br>
	  <input name="vitaya_sts" type="radio" value="1" <? if($xrs_s[dateorder]==$xrs_v[date_command]){ echo "checked";}?>>
      เป็นคำสั่งที่เกี่ยวกับการได้รับ/ปรับเลื่อนวิทยฐานะ&nbsp;เป็น
	  //<? 
		//$sql_stat="SELECT * FROM vitaya_stat where id='$id'";
	  ?>
      <select name="vitaya" onFocus="check_radio();">
        <option value="" <? if($xrs_v[name]==""){ echo "selected";}?>>ไม่มี</option>
        <?  
		foreach($namevit AS $key => $values){ 
			foreach ($values  AS  $val){
	?>
        
        <option value="<?=$val?>" <? if($xrs_v[name]=="$val"){ echo "selected";}?>><? echo "$key $val".$rsx[name]?></option>
        <? } } ?> 
        </select> 
      โดยคำสั่งนี้<br>*/?>
              <br>
          </div>
          <? }?>
		  </td>
      </tr>
    </table></td>
  </tr>
  <tr  >
    <td align="right"  >&nbsp;</td>
    <td align="left" valign="top" >
   <h2 style="display:none">       ประเภทคำสั่ง</h2>
        
    <table width="580" border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td bgcolor="#DEDFDE">
  
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="25%" height="25" align="right" bgcolor="#F8F8F8" style="display:none">ประเภทคำสั่ง :</td>
            <td width="75%" bgcolor="#F8F8F8" style="display:none"><label>
              <select name="select_type" id="select_type" style="width:150px" onChange="select_ordertype(this.value,'select_order_type')">
                <option value="">ไม่ระบุ</option>
                <?
				$style_school="none";
				$style_salary="none";
				$style_posduty="none";
				if($action=="edit2"){
			      $xschool=($rs[schoolid]!=0)?$rs[schoolid]:"";
				  $schoollb=$rs[school_label];
				  $ordertype=$rs[order_type];
				  $schoolname=$rs[school_label];
				  $lv=$rs[lv];
				  
				  if($ordertype==1||$ordertype==2||$ordertype==7||$ordertype==8||$ordertype==9||$ordertype==18){		
				 // echo "sssssss";
					 $style_school="block"; 
					 if( $xschool!=""){
						 $schoolname="";
					 }else{
						 $schoollb="";	 
					 }
				  }elseif($ordertype==4){
					$style_salary="block"; 
					
				  }elseif($ordertype==11||$ordertype==17){
					$style_posduty="block";
					
				  }else{
					 $schoollb=""; 
					 $lv="";
					 $schoollb="";
					 $xschool="";
					 $schoolname="";
				  }
			}
				
				
				
				
               $sql="SELECT hr_order_type.id,hr_order_type.order_type FROM hr_order_type order by hr_order_type.orderby";
$result=mysql_db_query($dbnamemaster,$sql);
					while($row=mysql_fetch_array($result)){
						
						 if($ordertype==$row[id]){
						$select="selected";
						}
					echo"<option  $select value='$row[id]'>$row[order_type]</option>";	
					$select="";
					}
			   ?>
              </select>
            </label>
            <script>
            def_ordertype='<?=$ordertype?>';
            </script>
            
            </td>
          </tr>
          <tr id="tr_selschool" >
            <td width="25%" align="right" valign="top" bgcolor="#F8F8F8" style="display:none">หน่วยงานที่สังกัด :</td>
            <td width="75%" bgcolor="#F8F8F8" style="display:none"><?
              // print_r($_SESSION);
				//echo $xschool;
				?>
              <label>
                <!-- select_school-->
              </label>
              <input name="select_school_label"  type="text" id="select_school_label"  size="50" maxlength="255" value="<?=$schoollb?>" />
              <input type="hidden" name="select_school" id="select_school"  value="<?=$xschool?>" />
              <br />
              <span class="style8">ในการค้นรายชื่อหน่วยงานจะต้องพิมพ์ตักอักษร 3 ตัวขึ้นไปและจะแสดงรายการที่ค้นหาได้ 100 รายการแรกเท่านั้น</span><br />
              <input name="select_school_name"  type="text" id="select_school_name" value="<?=$schoolname?>" size="50" maxlength="255" />
              <script >
              make_autocom("select_school_label","select_school");  
              </script>
              <br />
              <span class="style8">กรณีรายชื่อหน่วยงานที่สังกัดไม่มีให้เลือกในรายการ</span></td>
          </tr>
          <tr id="tr_money" >
            <td width="25%" align="right" valign="top" bgcolor="#F8F8F8" style="display:none">ขั้นที่ได้เลื่อน :</td>
            <td width="75%" bgcolor="#F8F8F8" style="display:none"><!--              <input type="text" name="txt_money" id="txt_money" value="<?=$lv?>" />-->
              <?
$arr_level[]="0.5";
$arr_level[]="1";
$arr_level[]="1.5";
$arr_level[]="2";
?>
              <label>
                <select name="txt_money" id="txt_money">
                <? 
				$sel=($lv=="-99")?"selected":"";
				?>
                 <option value="-99" <?=$sel?>>ไม่ระบุขั้น</option>
                 <? 
				$sel=($lv=="0")?"selected":"";
				?>
                  <option value="0" <?=$sel?>>ไม่ได้เลื่อน</option>
                  <?
                foreach($arr_level as $index=>$value){
				$sel=($value==$lv)?"selected":"";	
				echo"<option value=\"$value\" $sel>$value</option>";	
				}
				$sel=($lv=="-1")?"selected":"";
				?>
                
                <option value="-1" <?=$sel?>>เต็มขั้น(ค่าตอบแทนพิเศษ)</option>
                </select>
              </label>
              <div  id="showdata"  class="style1" >&nbsp; </div></td>
          </tr>
          <tr  id='tr_posduty1'>
            <td width="25%" height="25" align="right" valign="top" bgcolor="#F8F8F8" style="display:none">สายงาน :</td>
            <td width="75%" bgcolor="#F8F8F8" style="display:none"><select name="hr_addposition2" id="hr_addposition2" style="width:250px;" onChange="getposition2(this.value);">
              <option value="" class="warn">ไม่ระบุ</option>
                <?
				  $sql="SELECT hr_positiongroup.positiongroupid as id , hr_positiongroup.positiongroup as value FROM hr_positiongroup  where  status_active='1' and  hr_positiongroup.positiongroupid =(SELECT left(hr_addposition_now.pid ,1)  FROM hr_addposition_now where hr_addposition_now.`pid`='$rs[pos_onduty]' limit 1)";				 // echo $sql;
				  $re_postgroup=mysql_db_query("edubkk_master",$sql);
				  $row_postgroup=mysql_fetch_array($re_postgroup);
				  $id_postgroup=$row_postgroup[id];
                  $sql="SELECT  positiongroupid as id ,positiongroup as value FROM hr_positiongroup  where  status_active='1' order by  positiongroupid";
				  echo trim(getOption2($sql,$id_postgroup));
				  ?>
              </select></td>
          </tr>
          <tr  id='tr_posduty2'>
            <td width="25%" height="40" align="right" valign="top" bgcolor="#F8F8F8" style="display:none">ตำแหน่ง :</td>
            <td width="75%" bgcolor="#F8F8F8" style="display:none">
             <div id='divposduty' style="margin-top:5px;margin-bottom:5px">
              <select name="pos_onduty" id="pos_onduty" style="width:250px;">
                <option value="" class="warn">ไม่ระบุ</option>
                
                <?
				if($rs[pos_onduty]!=""){
				echo trim(getOption2(" select pid as id, position as value from $dbnamemaster.hr_addposition_now where pid like '$id_postgroup%' order by position; ", $rs[pos_onduty]));}
			 ?>
             
              </select></div>
              
             
              <input name="post_dutylabel"  type="text" id="post_dutylabel" value="<?=$rs[pos_onduty_label]?>" size="50" maxlength="255" />
              <br />
              <span class="style8">กรณีชื่อตำแน่งไม่มีให้เลือกในรายการ</span></td>
          </tr>
          <tr >
            <td colspan="2" align="left" valign="top" bgcolor="#F8F8F8" id="err_msg_tr"><div id="info">
              <table width="100%" border="0" cellspacing="0" cellpadding="1">
                <tr>
                  <td width="96%" rowspan="4" align="left" valign="top" height="13"><div id="boxerror">
                    <div id="err_text"></div>
                  </div></td>
                  <td height="13"><img class="close" src="../../../images_sys/16-square-red-remove.png" width="16" height="16" /></td>
                </tr>
                <tr>
                  <td width="4%" height="13"><img  class="up" src="../../../images_sys/16-em-open.png" width="16" height="16"  /></td>
                </tr>
                <tr>
                  <td></td>
                </tr>
                <tr>
                  <td height="13"><img class="down" src="../../../images_sys/16-em-down.png" width="16" height="16"  /></td>
                </tr>
              </table>
            </div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  
	<tr id="upsalarySchool1"  style=" <?=($rs[system_type]=="SYSTEM_SALARYUP_COMMAND")?'':'display:none'?>">
    <td align="right" valign="top" ><font color="red">*</font> สถานศึกษา:</td>
    <td align="left" valign="top"><table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">
      <tr valign="middle">
        <td width="54%"><input name="select_school_label"  type="text" id="select_school_label2"  size="100" maxlength="255" value="<? if($rs[schoolid]){echo $select_school_label2=getSchoolName($rs[schoolid]);}else{echo $select_school_label2=getSchoolName($xschool);}?>" /><script>
              make_autocom("select_school_label2","select_school2"); 
              </script>
              <input type="hidden" name="select_school" id="select_school2"  value="<? if($rs[schoolid]){echo $rs[schoolid];}else{echo $xschool;}?>" />
              </td>
        <td width="46%"></td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td align="right" valign="top" ><font color="red">*</font> เลขที่คำสั่ง:<br>
แสดงในส่วนเอกสารอ้างอิง</td>
    <td align="left" valign="top"><table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">
      <tr valign="middle">
	  <?
	  $txtdis="";
if($action=="edit2")
{
$txtdis = "readonly=readonly" ;
}
	  ?>
        <td width="54%"><textarea name="noorder" id="command_id" style="width:300px; height:30px;" onBlur="splitNoorder(this.value)"><?=$rs[noorder]?></textarea></td>
        <td width="46%"><span class="style8">กรณีไม่ระบุเลขที่คำสั่ง ให้ใส่เครื่องหมาย #<input name="noorder_old" type="hidden" id="noorder_old" value="<?=$rs[noorder]?>"></span></td>
      </tr>

    </table></td>
  </tr>  
  
  <tr id="upsalarySchool2" style=" <?=($rs[system_type]=="SYSTEM_SALARYUP_COMMAND")?'':'display:none'?>">
    <td align="right" valign="top" >เลขที่คำสั่ง:</td>
    <td align="left" valign="top"><table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">
      <tr valign="middle">
        <td width="54%"><input name="noorder_num"  type="text" id="noorder_num" style="width:100px;" value="<?=$rs[noorder_number]?>" /> 
        	ปีคำสั่ง <input name="noorder_year"  type="text" id="noorder_year" style="width:100px;" value="<?=$rs[noorder_year]?>"  />
              </td>
        <td width="46%"></td>
      </tr>

    </table></td>
  </tr>
  
  <tr>
    <td align="right" >วันที่ :<br>
      (เอกสารอ้างอิง)</td>
    <td align="left" valign="top"><table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">
        <tr>
          <td bgcolor="#DEDFDE" ><input type="radio" name="instruct" value="ลว."  checked="checked" onClick="doClear(this);" <? if($rs[instruct]=="ลว."){ echo "checked" ;}?>>
          ลว.
          <input type="radio" name="instruct" value="สั่ง" onClick="doClear(this);" <? if($rs[instruct]=="สั่ง"){ echo "checked" ;}?> >
          สั่ง
          <input type="radio" name="instruct" value="other" onClick="aaa();"  <? if($rs[instruct]!="ลว."  and  $rs[instruct] !="สั่ง"){ echo "checked" ;}?> >
          อื่นๆ
		  <?  if($rs[instruct]!="ลว."  and  $rs[instruct] !="สั่ง"){ $disx = "";}else{ $disx = " disabled='disabled'";}?>
          <input name="instruct1" type="text"  value="<?=$rs[instruct]?>" size="10" maxlength="100" <?=$disx?>> 
          <span class="style2">&nbsp;<span class="style8">&nbsp;กรณีเลือกอื่นๆ และเป็นค่าว่างให้ใส่เครื่องหมาย # </span></span></td>
          </tr></table>
		  <? if($action=="edit1"){?>
		 <table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">
        <tr>
          <td><input type="radio" name="checkdateorder" value="0" id="checkdateorder1" onClick="disbb();">ไม่ระบุวันที่            </td>
        </tr>
        
        <tr>
          <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
            <tr>
              <td><input type="radio" name="checkdateorder" value="1"  id="checkdateorder2" checked="checked"  onClick="opendisable();">
ระบุวันที่</td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellpadding="1" cellspacing="0">
                  <tr>
                    <td width="43%" valign="middle"><? //dateInput1($rs[dateorder],"dateorder")?>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <select name="dateorder_day" id="dateorder_day" <?php /*?>onChange="check_date('dateorder_day','dateorder_month','dateorder_year');"<?php */?> >
                        <?
					/*	
						echo "<option value=''> ไม่ระบุ </option>";
						for ($i=1;$i<=31;$i++){
						$doi=sprintf("%02d",$i);
						echo "<option value='$doi'>" .  $doi . "</option>";
						}*/
				?>
                      </select>
                      <select name="dateorder_month" id="dateorder_month" <?php /*?>onChange="check_date('dateorder_day','dateorder_month','dateorder_year');"<?php */?>>
                        <?
				/*echo "<option value=''>ไม่ระบุ</option>";
				for ($i=1;$i<=12;$i++){
						$xi = sprintf("%02d",$i);
						echo "<option value='$xi'>$month[$i]</option>";
					}*/

				?>
                      </select>
                      <select name="dateorder_year" id="dateorder_year" <?php /*?>onChange="check_date('dateorder_day','dateorder_month','dateorder_year');"<?php */?>>
                        <?
				/*echo "<option value=''>ไม่ระบุ</option>";
				$thisyear = date("Y") + 543;
				$y1 = $thisyear - 80;
				$y2 = $thisyear ;					
				for ($i=$y1;$i<=$y2;$i++){
				echo "<option value='$i'>$i</option>";
				}*/
				?>
                      </select>
                      </td>
                    <td width="57%"><span class="style10">*รูปแบบการแสดงผลของวันที่คือ 12 ม.ค. 2551 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7 </span></td>
                  </tr>
                </table></td>
            </tr>
            <tr>
              <td><span class="style2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input  type="hidden" name="value_dateorder"  id="value_dateorder" value=""  />
                &nbsp;
                <input name="label_dateorder" id="label_dateorder" type="text" value="<?=$rs[label_dateorder]?>" size="20">
                <span class="style10">
                <input  type="hidden" name="chk_dateorder"  id="chk_dateorder" value="true"  />
                หากท่านบันทึกในชองแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></span></td>
                
         <script>
	   		generate_calendarlist('value_dateorder','label_dateorder','dateorder_day','dateorder_month','dateorder_year','','','');
			<?php /*?>create_calendar('dateorder_day','dateorder_month','dateorder_year','','','');<?php */?>
		</script> 
            </tr>
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <td width="24%" valign="top">หมายเหตุ :<br>
                    <span class="style10">(หากข้อมูลใน ก.พ.7 <br>
ต้นฉบับไม่ตรงตาม<br>
ข้อเท็จจริงให้หมายเหตุไว้)</span></td>
                  <td width="76%"><label>
                    <textarea name="txt_note" cols="70" rows="5" id="txt_note"><?=$rs[note]?></textarea>
                  </label></td>
                </tr>
              </table></td>
            </tr>
            
          </table></td>
        </tr>
      </table>
		 <? }else if($action=="edit2"){?><table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">
        <tr>
          <td>
            <input type="hidden" name="olddateorder" value="<?=$rs[dateorder]?>">
          
          <input type="radio" name="checkdateorder" value="0"<? if($rs[dateorder]==""){echo "checked";}?> id="checkdateorder1" onClick="disbb();" >
ไม่ระบุวันที่</td>
        </tr>
        <tr>
          <td><input type="radio" name="checkdateorder" value="1"<? if($rs[dateorder] !=""){echo "checked";}?> id="checkdateorder2" onClick="opendisable();">
เปลี่ยนแปลงวันที่ใหม่ </td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#DEDFDE">
            <tr bgcolor="#CCCCCC">
              <td width="41%" bgcolor="#DEDFDE"><table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#DEDFDE">
                  <tr>
                    <td width="43%" valign="middle"><? //=dateInput1($rs[dateorder],"dateorder")?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <?
 
 
  		$d1=explode("-",$rs[dateorder]);
		
		if ($d1[2] ==''){$distdorder="disabled";} 
		if ($d1[1]==''){$distdorder1="disabled";}
		if ($d1[0]==''){$distdorder2="disabled";}
	//	if($checkdateorder==1 and $label_dateorder=='')
	//	{
	//	$distdorder_label="disabled";
	//	}
	//	else if($checkdateorder==0){$distdorder_label="disabled";}?>
  <select name="dateorder_day" <?=$distdorder?> id="dateorder_day" <?php /*?>onChange="check_date('dateorder_day','dateorder_month','dateorder_year');"<?php */?>> 
  <?
/*						echo "<option value=''> ไม่ระบุ </option>";
						for ($i=1;$i<=31;$i++){
						  $doi=sprintf("%02d",$i);
						if (intval($d1[2])== $i){
						echo "<option  value='$doi' SELECTED>" . $doi. "</option>";
						}else{
								echo "<option value='$doi'>" . $doi . "</option>";
								}
						}*/
				?>
</select>
<select name="dateorder_month" <?=$distdorder1?> id="dateorder_month" <?php /*?>onChange="check_date('dateorder_day','dateorder_month','dateorder_year');"<?php */?>>
  <?
/*				echo "<option value=''>ไม่ระบุ</option>";
				for ($i=1;$i<=12;$i++){
					$xi = sprintf("%02d",$i);
					if (intval($d1[1])== $xi){
				//		echo "<option value='$xi' SELECTED>$xi</option>";
						echo "<option value='$xi' SELECTED>$month[$i]</option>";
					}else{
				//		echo "<option value='$xi'>$xi</option>";
						echo "<option value='$xi'>$month[$i]</option>";
					}
				}*/
				?>
</select>
<select name="dateorder_year" id="dateorder_year" <?=$distdorder2?> <?php /*?>onChange="check_date('dateorder_day','dateorder_month','dateorder_year');"<?php */?>>
  <?
/*				echo "<option value=''>ไม่ระบุ</option>";
				$thisyear = date("Y") + 543;
				$y1 = $thisyear - 80;
				$y2 = $thisyear ;
									
				for ($i=$y1;$i<=$y2;$i++){
					if ($d1[0]== $i){
						echo "<option  value='$i' SELECTED>$i</option>";
					}else{
						echo "<option value='$i'>$i</option>";
					}
				}*/
				?>
</select>
  
</td>
                    <td width="57%"><span class="style10">*รูปแบบการแสดงผลของวันที่คือ 12 ม.ค. 2551 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7 </span></td>
                  </tr>
                </table>                </td>
              </tr>
            
            <tr bgcolor="#CCCCCC">
              <td bgcolor="#DEDFDE"><span class="style2">&nbsp;&nbsp;&nbsp;
                &nbsp;
                <input  type="hidden" name="value_dateorder"  id="value_dateorder" value=""  />
                &nbsp;
                <input name="label_dateorder" id="label_dateorder" type="text" value="<?=$rs[label_dateorder]?>" size="20" >
                <span class="style10">
                <input  type="hidden" name="chk_dateorder"  id="chk_dateorder" value="true"  />
                </span>
                <script>
					generate_calendarlist('value_dateorder','label_dateorder','dateorder_day','dateorder_month','dateorder_year','<?=$d1[2]?>','<?=$d1[1]?>','<?=$d1[0]?>');
					<?php /*?>create_calendar('dateorder_day','dateorder_month','dateorder_year','<?=$d1[2]?>','<?=$d1[1]?>','<?=$d1[0]?>');<?php */?>
				</script>  
                <?
			  if($intraip_st){
				 if($rs[dateorder] == ""){
					  echo "";
					  }else{
					$arr_day=explode("-",$rs[dateorder]);
					$yy1 = $arr_day[0]-543;
					$mm1 = $arr_day[1];
					$dd1 = $arr_day[2];
					 $sent_day1 = $yy1."-".$mm1."-".$dd1;
					echo option_day1($sent_day1);
			  }
		  }
			  ?>
                <span class="style10">หากท่านบันทึกในชองแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></span></td>
              </tr>
            <tr bgcolor="#CCCCCC">
              <td bgcolor="#DEDFDE"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <td width="25%" valign="top">หมายเหตุ :<br>
                    <span class="style10">  (หากข้อมูลใน ก.พ.7 <br>
                      ต้นฉบับไม่ตรงตาม<br>
                      ข้อเท็จจริงให้หมายเหตุไว้) </span></td>
                  <td width="75%"><label>
                    <textarea name="txt_note" cols="70" rows="5" id="txt_note"><?=$rs[note]?></textarea>
                    </label></td>
                </tr>
                </table></td>
            </tr>
            
            
          </table></td>
        </tr>
      </table>
		 <? }?>
         
         <input name="submenu_id" id="submenu_id" type="hidden" size="50" value="" >
    <input name="subject_error" id="subject_error" type="hidden" size="50" value="" >
    <input name="value_key_error" id="value_key_error" type="hidden" size="50" value="" >
    <input name="label_key_error" id="label_key_error" type="hidden" size="50" value="" >
         </td>
  </tr>
  
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>

  <? /*
<tr valign="top"> 
	<td width="150" align="right">การเลื่อนขั้น</td>
	<td width="713"><input type="text" name="upgrade" size="40" value="<?=$rs[upgrade]?>"></td>
</tr>
	$xsql_s="SELECT * FROM salary WHERE id='$id'";
	$xquery=mysql_query($xsql_s);
	$xrs_s=mysql_fetch_array($xquery);
				$xsql_v=mysql_query("SELECT * FROM vitaya_stat WHERE id='$id' AND date_command='".$xrs_s[dateorder]."'");
				$xrs_v=mysql_fetch_array($xsql_v);
*/ 
			

?>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
  <tr valign="middle"> 
    <td align="center" colspan="2"><input type="submit" name="send" value="  บันทึก  "> <input type="hidden" NAME="remark" VALUE="<?=$remark?>"><input type="button" name="cancle" value="ยกเลิก" onClick="location.href='salary.php?action=edit&YY=<?=$YY?>&viewall=<?=$v?>' ">
    <input type="hidden" name="str_system_type" value="<?=$rs[system_type]?>">
    
    </td>
  </tr>
  </table>
  </form>
  <?
   }
  
  ?>

  <p>&nbsp;</p>
  <p>&nbsp;</p>
    </td></tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
<script>
var dpvar = Array();
function chkNumPostion_label(){
		label=$('#label_noposition').val();
		value=$('#noposition').val();
		if(label==''){
				$('#msg_'+'label_noposition').html('');	
				$('#chk_noposition').val('true');
		}else{
				if(label==value){
						$('#msg_'+'label_noposition').html(check_true);	
						$('#chk_noposition').val('true');
				}else{
						label=$('#label_noposition_2').val();
						tempL=label;
						tempLabel=label.split('');
						for(aL=0;aL<tempLabel.length;aL++){
								//alert(tempLabel[aL]);
								tempStr=replaceCharThai(tempLabel[aL]);
								//alert(tempStr);
								tempL=tempL.replace(tempLabel[aL],tempStr);		
								//alert(tempL);
						}
						$('#label_noposition').val(tempL);
						if($('#label_noposition').val()==value){
								$('#msg_'+'label_noposition').html(check_true);	
								$('#chk_noposition').val('true');
						}else{
								$('#msg_'+'label_noposition').html(check_false);	
								$('#chk_noposition').val('false');
						}
						$('#label_noposition').val(label);
				}
		}
}

function replaceCharThai(str){
		temp='';
		switch(str){
				case '๐':
						temp='0';
						break;
				case '๑':
						temp='1';
						break;
				case '๒':
						temp='2';
						break;
				case '๓':
						temp='3';
						break;
				case '๔':
						temp='4';
						break;
				case '๕':
						temp='5';
						break;
				case '๖':
						temp='6';
						break;
				case '๗':
						temp='7';
						break;
				case '๘':
						temp='8';
						break;
				case '๙':
						temp='9';
						break;
				case '.':
						temp='';
						break;
				case ' ':
						temp='';
						break;
				default:
						temp=str;
		}
		return temp;
}

function  check_GetVitayaCase(){// 
	//var	year=$('#salary_year').val();
	//	if((year*1)!>=2548){
			
		//var hr_addradub=$('#hr_addradub').val();
				getposition($('#hr_addposition_group').val());
	//	}
}

function showValuePostion(){
		$('#label_noposition').val($('#label_noposition_2').val());
}

//========================================================================================================================
$(document).ready(function(){
	if($("#check_enable").is(':checked')==false) {
		$('#elec_paper').attr("disabled", "disabled");
		$('#upsalary').attr("disabled", "disabled");
	}
});

$("#check_enable").click(function() {
	if($("#check_enable").is(':checked')==false) {
		$("#elec_paper").attr("disabled", "disabled");
		$("#upsalary").attr("disabled", "disabled");
		
		$("#elec_paper").removeAttr("checked");
		$("#upsalary").removeAttr("checked");
		
	    $("#upsalarySchool1").css("display","none");
		$("#upsalarySchool2").css("display","none");
		
		$("#noorder_num").val("");
		$("#noorder_year").val("");
		//$("#select_school_label2").val("");
		//$("#command_id").val("");
	}else{
		$("#elec_paper").removeAttr("disabled");
		$("#upsalary").removeAttr("disabled");
	}
});

$("#elec_paper").click(function() {
  $("#upsalarySchool1").css("display","none");
  $("#upsalarySchool2").css("display","none");
});

$("#upsalary").click(function() {
  $("#upsalarySchool1").css("display","");
  $("#upsalarySchool2").css("display","");
});

function splitNoorder(splitText){
	var Text=splitText.split("/");
	Text[0]=$.trim(Text[0]);
	Text[1]=$.trim(Text[1]);
	
	for(i=Text[0].length;i>0;i--){
		var n=Text[0].substr(i-1,1);
		if(isNaN(n)){var number=i; i=0;}
	}
	
	$("#noorder_num").val($.trim(Text[0].substr(number)));
	$("#noorder_year").val($.trim(Text[1]));
}
</script>