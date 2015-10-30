<?php
	###################################################################
	## REPORT: CHECK DATA PROFILE
	###################################################################
	## Version :			20110111.001 (Created/Modified; Date.RunNumber)
	## Created Date :	2011-01-11 11:30
	## Created By :		Mr.KIDSANA PANYA(JENG)
	## E-mail :				kidsana@sapphire.co.th
	## Tel. :				-
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
session_start();

include("../../config/conndb_nonsession.inc.php");



#Begin Set var
$get_view = ($_GET['get_view']!="")?$_GET['get_view']:"edu";
$area_keyin_status = ($_GET['keyin_status']!="")?$_GET['keyin_status']:"update";
$siteid = ($_GET['siteid']!="")?$_GET['siteid']:$_SESSION[session_site];//$_GET['siteid']
$_GET['date_profile'] = ($_GET['date_profile']!="")?$_GET['date_profile']:'2553-10-01';
$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
#End Set var

if($_SESSION[session_staffid] != "" and $_SESSION[session_site] == ""){
	$user_site = DB_MASTER;	
}else if($_SESSION[session_site] != ""){
	$user_site = $_SESSION[session_site];	
}else{
	$user_site = $siteid;	
}// end if($_SESSION[session_staffid] != ""){
	
	
### update เขตนำร่องก่อนเรียกใช้หน้ารายงาน
$sql_sel = "SELECT
 ".DB_MASTER.".eduarea.secid
FROM
 ".DB_MASTER.".eduarea
Inner Join ".DB_USERENTRY.".keystaff ON  ".DB_MASTER.".eduarea.secid = ".DB_USERENTRY.".keystaff.site_area
where 
 ".DB_MASTER.".eduarea.area_keyin_status='new'
group by  ".DB_MASTER.".eduarea.secid";
#echo $sql_sel."<br>";
$result_sel = mysql_db_query($dbnamemaster,$sql_sel);
while($rssel = mysql_fetch_assoc($result_sel)){
	$sql_update = "UPDATE eduarea SET area_keyin_status='update' WHERE secid='$rssel[secid]'";	
	#echo $sql_update."<br>";
	mysql_db_query($dbnamemaster,$sql_update);
}


#Begin Funtions ---------------------------------------------------
function dateToString($date=""){
	$str_date = "";
	$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
	if($date != "" || $date!="0000-00-00"){
		 $arr_date = explode("-",$date);
		 $str_date = intval($arr_date[2])." ".$mname[intval($arr_date[1])]." ".($arr_date[0]+543);
	}else{
		$str_date = "-";
	}
	return $str_date;
}

function gen_sql($get_view="edu",$area_keyin_status="",$siteid="",$id=""){
	global $user_site;
	if($get_view=="edu" || $get_view==""){ 
		
		if($area_keyin_status!=""){
				if($area_keyin_status!="all"){
						$where_area_keyin_status = "AND  ".DB_MASTER.".eduarea.`area_keyin_status` = '$area_keyin_status' ";
				}else{
						$where_area_keyin_status = "";
				}
		}else{
			$where_area_keyin_status = "";
		}
		//$sql = "SELECT  ".DB_MASTER.".eduarea.secid AS siteid, ".DB_MASTER.".eduarea.secname AS sitename,  ".DB_MASTER.".eduarea.secname_short  AS caption 
//FROM  ".DB_MASTER.".eduarea ";
//		$sql .= " WHERE 
//						 ".DB_MASTER.".eduarea.secid IS NOT NULL AND  ".DB_MASTER.".eduarea.secname IS NOT NULL AND  ".DB_MASTER.".eduarea.secid NOT LIKE('99%') 
//					".$where_area_keyin_status;
			if($area_keyin_status=="all"){
				$sql = "SELECT  ".DB_MASTER.".eduarea.secid AS siteid, ".DB_MASTER.".eduarea.secname AS sitename,  ".DB_MASTER.".eduarea.secname_short  AS caption 
FROM  ".DB_MASTER.".eduarea ";
		$sql .= " WHERE 
						 ".DB_MASTER.".eduarea.secid IS NOT NULL AND  ".DB_MASTER.".eduarea.secname IS NOT NULL AND  ".DB_MASTER.".eduarea.secid NOT LIKE('99%') 
					".$where_area_keyin_status;
					$sql .= ($siteid!="" and $user_site != DB_MASTER)?" AND  ".DB_MASTER.".eduarea.secid ='".$siteid."' ":"";
					$sql .= " ORDER BY   ".DB_MASTER.".eduarea.secname_short,  ".DB_MASTER.".eduarea.secid ASC";
			}else if($area_keyin_status=="new"){
				$sql="SELECT  ".DB_MASTER.".eduarea.secid AS siteid, ".DB_MASTER.".eduarea.secname AS sitename,  ".DB_MASTER.".eduarea.secname_short  AS caption 
FROM  ".DB_MASTER.".eduarea WHERE  ".DB_MASTER.".eduarea.secid NOT IN(SELECT
  ".DB_MASTER.".eduarea.secid AS siteid 
FROM
 ".DB_MASTER.".eduarea
Inner Join ".DB_USERENTRY.".keystaff ON  ".DB_MASTER.".eduarea.secid = ".DB_USERENTRY.".keystaff.site_area
where ".DB_USERENTRY.".keystaff.status_permit='YES' GROUP BY  ".DB_MASTER.".eduarea.secid) AND  ".DB_MASTER.".eduarea.secid IS NOT NULL AND  ".DB_MASTER.".eduarea.secname IS NOT NULL AND  ".DB_MASTER.".eduarea.secid NOT LIKE('99%') ";
			}else{
			$sql="SELECT
  ".DB_MASTER.".eduarea.secid AS siteid,
  ".DB_MASTER.".eduarea.secname AS sitename,
  ".DB_MASTER.".eduarea.secname_short  AS caption 
FROM
 ".DB_MASTER.".eduarea
Inner Join ".DB_USERENTRY.".keystaff ON  ".DB_MASTER.".eduarea.secid = ".DB_USERENTRY.".keystaff.site_area
where ".DB_USERENTRY.".keystaff.status_permit='YES' GROUP BY  ".DB_MASTER.".eduarea.secid ";
			}
		/*$sql = "SELECT  ".DB_MASTER.".eduarea.secid AS siteid, ".DB_MASTER.".eduarea.secname AS sitename,  ".DB_MASTER.".eduarea.secname_short  AS caption 
FROM  ".DB_MASTER.".eduarea  ";
		$sql .= " WHERE 
						 ".DB_MASTER.".eduarea.secid IS NOT NULL AND  ".DB_MASTER.".eduarea.secname IS NOT NULL AND  ".DB_MASTER.".eduarea.secid NOT LIKE('99%') 
					";*/
		
	}else if($get_view=="school"){
		$sql = "SELECT  id AS schoolid ,IF(id='".$siteid."',office, CONCAT('โรงเรียน',office)) AS caption, siteid ,(if(id='".$siteid."' ,null,office)) AS orderfilde FROM `allschool`  ";
		$sql .= "WHERE siteid IS NOT NULL AND siteid NOT LIKE('99%') ";
		$sql .= ($siteid!="")?" AND siteid ='".$siteid."' ":"";
		$sql .= ($id!="")?" AND id ='".$id."' ":"";
		$sql .= "ORDER BY orderfilde ASC";
	}
	
	return $sql;
}

function math_position_date($get_view="edu",$siteid="",$schoolid=""){
	$dbsite = STR_PREFIX_DB.$siteid;
	$date_profile = $_GET['date_profile'];
	
	if($siteid!=""){
		if($get_view=="edu"){
			$arr_p = explode("-",$date_profile);
			$profile_eng = ($arr_p[0]-543)."-".$arr_p[1]."-".$arr_p[2];
			$sql_rcdp = "SELECT * FROM `".DB_MASTER."`.`report_check_data_profile` 
						WHERE `".DB_MASTER."`.`report_check_data_profile`.siteid ='".$siteid."'
						AND `".DB_MASTER."`.`report_check_data_profile`.profile_date ='".$profile_eng."'
						";
			$query_rcdp = mysql_db_query($dbsite, $sql_rcdp);
			$row_rcdp = mysql_fetch_assoc($query_rcdp);
			$count_general_all = $row_rcdp['count_all'];
			$int_count = $row_rcdp['count'];
			$int_count_no_math = $row_rcdp['count_no_math'];
			
		}else if($get_view=="school"){
			$count_general = "SELECT COUNT(idcard) AS count_general FROM `general` WHERE schoolid ='".$schoolid."' ";
			$query_count_general = mysql_db_query($dbsite, $count_general);
			$row_count_general = mysql_fetch_assoc($query_count_general);
			$count_general_all = $row_count_general['count_general'];
			$general = "SELECT
			general.id, MAX( salary.`date` ) AS max_date, general.dateposition_now
			FROM
			general
			LEFT JOIN salary ON general.id = salary.id 
			WHERE general.siteid='".$siteid."'
			AND general.schoolid ='".$schoolid."'
			GROUP BY general.id
			HAVING MAX( DATE(salary.`date`) ) < DATE( '".$date_profile."') OR  (max_date = '' OR max_date IS NULL) ";
			//echo $general."(".$dbsite.")<br/>";
			$query_general = mysql_db_query($dbsite, $general);
			$str_idcard = "";
			$int_count = 0;
			$int_count_no_math = 0;
			while($row_general = mysql_fetch_assoc($query_general)){
				if($date_profile > $row_general['max_date']){
					$int_count++;
					if($row_general['dateposition_now'] != $row_general['max_date']){
						$int_count_no_math++;
					}
				}
			}
		}
		
	}
	$data = array("count_all"=>$count_general_all,"count"=>$int_count,"count_no_math"=>$int_count_no_math);
	//echo $int_count." (".$int_count_no_math.")[PIN:".$str_idcard."]";
	return $data;
}
function gen_part($siteid=""){
	global $dbname,$user_site; 
	$str_link = "";
	if($siteid!=""){
		#edu 
		/*$sql_edu = "SELECT site AS siteid,sitename,siteshortname AS caption ,patameter FROM `eduarea_config` Inner Join  sapphire_app.employee_work_site ON sapphire_app.employee_work_site.siteid =  ".DB_MASTER.".eduarea_config.site  ";
		$sql_edu .= "WHERE site IS NOT NULL AND sitename IS NOT NULL ";
		*/
		//$sql_edu="SELECT
// ".DB_MASTER.".eduarea.secid AS siteid, ".DB_MASTER.".eduarea.secname AS sitename,  ".DB_MASTER.".eduarea.secname_short  AS caption 
//FROM
// ".DB_MASTER.".eduarea
//Inner Join ".DB_USERENTRY.".keystaff ON  ".DB_MASTER.".eduarea.secid = ".DB_USERENTRY.".keystaff.site_area
//WHERE ".DB_USERENTRY.".keystaff.status_permit='YES' AND  ".DB_MASTER.".eduarea.secid IS NOT NULL 
//							AND  ".DB_MASTER.".eduarea.secid ='".$siteid."' 
//group by  ".DB_MASTER.".eduarea.secid";
		
		$sql_edu = "SELECT  ".DB_MASTER.".eduarea.secid AS siteid, ".DB_MASTER.".eduarea.secname AS sitename,  ".DB_MASTER.".eduarea.secname_short  AS caption 
FROM   ".DB_MASTER.".eduarea   ";
		$sql_edu .= "WHERE  ".DB_MASTER.".eduarea.secid IS NOT NULL 
							AND  ".DB_MASTER.".eduarea.secid ='".$siteid."' ";
		$query_edu = mysql_db_query($dbname, $sql_edu);
		$row_edu = mysql_fetch_assoc($query_edu);
		$str_link = '<a href="?get_view=edu&date_profile='.$_GET['date_profile'].'">ภาพรวม</a>'; 
		$str_link .= '=&gt;'.$row_edu['caption'];
	}else{
		$str_link = 'ภาพรวม'; 
	}
	return $str_link;
	
}
function percen_event($num_all=0, $num_event=0){
	return @number_format( (($num_event*100)/$num_all) ,2);
}
#End Funtions ---------------------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet">
<title>รายงาน ตรวจสอบข้อมูลตามที่ไม่ตรงตามโปรไฟล์</title>
</head>
<body>
<DIV style="text-align:right">
<table border="0" align="" style="background-color:#CCCCCC; border:#FFFFCC 1px solid; color:#006699;">
  <tr>
    <td align="left"><strong>รายงานนี้จะมีการประมวลผลทุก 1 วัน</strong></td>
  </tr>
  <tr>
    <td align="center"><!--<DIV style="cursor:pointer; text-align:center; width:160px; color:#00CC33; font-weight:bold; margin:5px; padding:5px; border: #009933 1px solid; background-color:#EEEEEE;" onclick="window.open('script_check_data_profile.php','popup','toolbar=0,location=0,resizeable=0,directories=0,menubar=0,scrollbars=0,status=0,width=350,height=250');"><img src="../../images_sys/refresh.png" align="absmiddle" border="0" width="20" /> ประมวลผลทันที</DIV>--><DIV style="text-align:left; width:360px; color:#FF0000; font-weight:bold; margin:5px; padding:5px; border: #009933 1px solid; background-color:#EEEEEE;"> การคลิ๊กประมวลผลจากหน้ารายงานนี้
ใช้ทรัพยากรของเครื่อง Server ค่อนข้างมาก
ดังนั้นการประมวลผลในหน้ารายงานนี้
จะทำงานอัตโนมัติวันละ 1 ครั้ง หลังเที่ยงคืน</DIV></td>
  </tr>
</table>
</DIV>
<br/>&nbsp;
	<center><strong style="font-size:16px;">รายงาน ตรวจสอบข้อมูลตามที่ไม่ตรงตามโปรไฟล์</strong></center>
	<table width="98%" border="0" align="center">
	  <tr>
		<td><!--ภาพรวมทั้งประเทศ--></td>
		<td align="right">ข้อมูลโปรไฟล์&nbsp;
		<select name="date_profile" onchange="window.location='?siteid=<?=$_GET['siteid'];?>&get_view=<?=$_GET['get_view'];?>&schoolid=<?=$_GET['schoolid'];?>&m_type=<?=$m_type;?>&date_profile='+this.value;">
		<?php
		#ช่วงเวลา 
		$arr_period = array("04-01"=>"1 เม.ย. ", "10-01"=>"1 ต.ค. ");
		$year_s = 2009+543;
		$year_e = intval(date("Y"))+543;
		for($y=$year_s;$y<=$year_e;$y++){	
			foreach($arr_period as $period_k => $period_v){
				if($y<=$year_e){
					echo '<option value="'.$y.'-'.$period_k.'" '.(($y.'-'.$period_k==$_GET['date_profile'])?"SELECTED":"").'>'.$period_v.$y.'</option>';
				}else if($year_e == $y ){
					if(intval(date('m')) < 4){
						if("04-01" == $period_k){
							echo '<option value="'.$y.'-'.$period_k.'" '.(($y.'-'.$period_k==$_GET['date_profile'])?"SELECTED":"").'>'.$period_v.$y.'</option>';
						}
					}else if(intval(date('m')) >= 4){
						if("10-01" == $period_k){
							echo '<option value="'.$y.'-'.$period_k.'" '.(($y.'-'.$period_k==$_GET['date_profile'])?"SELECTED":"").'>'.$period_v.$y.'</option>';
						}
					}
				}
			}
		}
		/*if(intval(date('m')) >= 10){
			echo '<option value="'.($year_e+1).'-04-01" '.((($year_e+1).'-04-01'==$_GET['date_profile'])?"SELECTED":"").'>'.$arr_period['04-01'].$y.'</option>';
		}*/
		?>
		</select>
		</td>
	  </tr>
	</table>
	<table border="0" width="98%"  align="center">
	  <tr>
		<td><?php echo gen_part($_GET['siteid']);?></td>
		<td align="right">
        <a href="?siteid=<?=$_GET['siteid'];?>&get_view=<?=$_GET['get_view'];?>&schoolid=<?=$_GET['schoolid'];?>&m_type=<?=$m_type;?>&date_profile=<?=$_GET['date_profile']?>&keyin_status=update">สพท. นำร่อง</a>
        &nbsp;|&nbsp;
        <a href="?siteid=<?=$_GET['siteid'];?>&get_view=<?=$_GET['get_view'];?>&schoolid=<?=$_GET['schoolid'];?>&m_type=<?=$m_type;?>&date_profile=<?=$_GET['date_profile']?>&keyin_status=new">นอกเหนือจาก สพท. นำร่อง</a>
        &nbsp;|&nbsp;
        <a href="?siteid=<?=$_GET['siteid'];?>&get_view=<?=$_GET['get_view'];?>&schoolid=<?=$_GET['schoolid'];?>&m_type=<?=$m_type;?>&date_profile=<?=$_GET['date_profile']?>&keyin_status=all">ทั้งหมด</a>
        </td>
	  </tr>
	</table>
	<table width="98%" border="0" align="center" bgcolor="#666666" cellpadding="2" cellspacing="1">
	  <tr align="center"  bgcolor="#a3b2cc" >
		<td width="50"><strong>ลำดับ</strong></td>
		<td><strong>หน่วยงาน</strong></td>
        <td><strong>วันที่เริ่มปฏิบัติงาน</strong></td>
		<td><strong>จำนวนข้าราชการทั้งหมด</strong></td>
		<td width="100"><strong>จำนวนข้อมูลที่อัพเดตไม่ถึง <br/><?php echo dateToString((substr($_GET['date_profile'],0,4)-543).substr($_GET['date_profile'],4,6));?></strong></td>
		<td width="200"><strong>จำนวนข้อมูลไม่ตรงกันระหว่างตำแหน่งและอัตราเงินเดือนกับข้อมูลทั่วไป</strong></td>
		<td width="120"><strong>เปอร์เซนต์ความสำเร็จ</strong></td>
		<td width="120"><strong>เปอร์เซนต์ที่ต้องทำ</strong></td>
	  </tr>
	  <?php
	  $sql =  gen_sql($get_view,$area_keyin_status,$siteid); 
	// echo $sql."".$dbname."<br>";
	  $query = mysql_db_query($dbname, $sql);
	  $int_row = 0;
	  $sum_c = 0;
	  $sum_no_c = 0;
	  $bg_color = array("#DDDDDD", "#EFEFEF");
	  while($row = mysql_fetch_assoc($query)){
	  	$int_row++;
	  	$data_count = math_position_date($get_view,$row['siteid'],$row['schoolid']);
		$sum_c_all += $data_count['count_all'];
		$sum_c += $data_count['count'];
		$sum_no_c += $data_count['count_no_math'];
		
		$sql_start_date = "	SELECT ".DB_USERENTRY.".keystaff.site_area, 
												MIN(".DB_USERENTRY.".keystaff.date_area) AS start_date_area
											FROM ".DB_USERENTRY.".keystaff
											WHERE ".DB_USERENTRY.".keystaff.site_area='".$row['siteid']."'; "; 
		$query_start_date  = mysql_query($sql_start_date);
		$start_date = mysql_fetch_assoc($query_start_date);
	  ?>
	  <tr bgcolor="<?php echo $bg_color[$int_row%2];?>" align="center">
		<td><?php echo $int_row;?></td>
		<td align="left">
			<?php 
			$get_view_link = ($get_view!="edu")?$get_view:"school";
			if($get_view!="school"){ 
			?>
			<a href="?get_view=<?=$get_view_link?>&date_profile=<?=$_GET['date_profile']?>&siteid=<?=$row['siteid']?>&schoolid=<?=$row['schoolid']?>"><?php echo $row['caption'];?></a>
			<?php 
			}else{
				echo $row['caption'];
			}
			?>
		</td>
		<td>
		<?php 
		if(substr($start_date['start_date_area'],0,10) != "0000-00-00" && substr($start_date['start_date_area'],0,10) !="" ){
			echo dateToString($start_date['start_date_area']);	
		}else{
			echo "ยังไม่มีเจ้าหน้าประจำ สพท.";
		}
		?>
        </td>
        <td><?php echo number_format($data_count['count_all']);?></td>
		<td>
		<?php
		if($data_count['count']>0){
			echo '<a href="report_check_data_profile_person.php?date_profile='.$_GET['date_profile'].'&siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=m1" target="_blank">'.number_format($data_count['count']).'</a>';
		}else{
			echo '0';
		}
		?>
		</td>
		<td>
		<?php
		if($data_count['count_no_math']>0){
			echo '<a href="report_check_data_profile_person.php?date_profile='.$_GET['date_profile'].'&siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=m2" target="_blank">'.number_format($data_count['count_no_math']).'</a>';
		}else{
			echo '0';
		}
		?>
		</td>
		<td style="color:#006600;"><?php echo percen_event($data_count['count_all'], ($data_count['count_all']-$data_count['count']))?></td>
		<td style="color:#FF0000;">
		<?php 
		echo '<a href="report_check_data_profile_person.php?date_profile='.$_GET['date_profile'].'&siteid='.$row['siteid'].'&schoolid='.$row['schoolid'].'&m_type=m1" target="_blank" style="color:#FF0000;">';
		echo percen_event($data_count['count_all'], $data_count['count']);
		echo '</a>';
		?>
		</td>
	  </tr>
	  <?php }  ?>
	   <tr bgcolor="#FFFFFF" align="center">
		<td>&nbsp;</td>
		<td align="left" colspan="2"><strong>รวม</strong></td>
		<td><strong><?php echo number_format($sum_c_all);?></strong></td>
		<td>
		<strong><?php echo number_format($sum_c);?></strong>
		</td>
		<td>
		<strong><?php echo number_format($sum_no_c);?></strong>
		</td>
		<td style="color:#006600;">
		<strong><?php echo percen_event($sum_c_all, ($sum_c_all-$sum_c) )?></strong>
		</td>
		<td style="color:#FF0000;">
		<strong><?php echo percen_event($sum_c_all, $sum_c)?></strong>
		</td>
	  </tr>
	</table>

</body>
</html>