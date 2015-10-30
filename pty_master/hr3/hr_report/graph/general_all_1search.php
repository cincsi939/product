<?php
ob_start();

$save_to_file = 1; //@20/7/2550 เก็บรูปลงไฟล์
session_start();
//echo $_SESSION[id];
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
$ApplicationName	= "hr";
$module_code 		= "5002.xx";
$process_id 			= "xxxxxxx";
$VERSION 				= "9.x";
#########################################################
#Developer		::	Alongkot
#DateCreate		::	17/03/2007
#LastUpdate		::	17/03/2007
#DatabaseTabel	::	general
#END
############################################################
include ("../libary/function.php");
include("../../../common/common_competency.inc.php");
# include ("../../../config/phpconfig.php");
include("../../../config/conndb_nonsession.inc.php");
include ("timefunc.inc.php");
include("../../../common/std_var.inc.php");

$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$month 			= array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
function MakeDate($d){
global $monthname;
	if (!$d) return "";
	
	$d1=explode("-",$d);
	if (($d1[0] < 1)  and ($d1[1] < 1)){ return "" ; } 
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " พ.ศ. " . $d1[0];
}
function retireDate($date){

	$d			= explode("-",$date);
	$year	= $d[0];
	$month	= $d[1];
	$date	= $d[2];
	
	
		
	if($month == 1 || $month == 2 || $month == 3){		
		$retire_year	= ($year < 2484) ? $year + 61 : $year + 60 ;		
	} else if($month == 10 || $month == 11 || $month == 12){		
		$retire_year 	= ($date <= 1 && $month == 10) ? $year + 60 :  $year + 61;		
	} else {
		$retire_year 	= $year + 60;
	}		

	return "30 กันยายน พ.ศ. ".$retire_year;
}

 $sql_view="SELECT * FROM view_general where CZ_ID='$xid' ";
$qry=mysql_db_query($db_name,$sql_view)or die (__LINE__ ." :: error");
$rsv=mysql_fetch_assoc($qry);

$xsiteid = $rsv[siteid] ; 
$nowdb = STR_PREFIX_DB. $xsiteid ; 
$masterdb = $dbnamemaster   ; 

 
$sql_general="SELECT * FROM general where id='$xid' ";
$query_general=mysql_db_query($nowdb,$sql_general)or die("CANNOT QOERY Line ". __LINE__ .mysql_error());
$arr_general=mysql_fetch_assoc($query_general);


$sql_salary="SELECT * from salary where id='$xid' ORDER BY  date DESC,salary DESC,dateorder DESC LIMIT 1";
$query_salary=mysql_db_query($nowdb,$sql_salary)or die("CANNOT QOERY Line ". __LINE__ .mysql_error());
$arr_salary=mysql_fetch_assoc($query_salary);


$sql_graduate="SELECT place,grade,finishyear,place from graduate where id='$xid' order by finishyear DESC ";
//echo $sql_graduate;
$query_graduate=mysql_db_query($nowdb,$sql_graduate)or die("CANNOT QOERY".mysql_error());
$arr_graduate=mysql_fetch_assoc($query_graduate);


$sql_sa1="select * from salary where id='$xid' ORDER BY  date DESC,salary DESC,dateorder DESC LIMIT 1";
$query_sa=mysql_db_query($nowdb,$sql_sa1)or die("CANNOT QOERY".mysql_error());
$rs8=mysql_fetch_assoc($query_sa);
 
?>

<html>
<head>
<title>ข้อมูลข้าราชการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="hr.css" type="text/css" rel="stylesheet">

<style type="text/css">
<!--
body {
	margin: 0px  0px;
	padding: 0px  0px;
	margin-top: 5px;
	margin-bottom: 5px;
}
a.pp:link, a.pp:visited, a.pp:active { color: #444444;	
	font-weight:normal;
	text-decoration: none}
a.pp:hover {
	text-decoration: underline;
	color: #444444;
}
.sub_head_td{
border-bottom:#5595CC 1px solid; 
border-top:#5595CC 1px solid;
height:25px;
padding-left:10px;
filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#F4F4F4', EndColorStr='#F4F4F4'); 

}
.style1 {border-bottom: #5595CC 1px solid; border-top: #5595CC 1px solid; height: 25px; padding-left: 10px; font-weight: bold; }

-->
</style></head>
<body>
<?
if($showbanner!="off"){
include("../../main_app/header.php");
	}
?> 
<table width="98%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4" align="center" style="border:1px solid #DADAE1;">
  <tr>
    <td ><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="2" align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
      <tr>
        <td width="14%" height="515" valign="top"><?
						$sql_showpic="select yy,imgname from general_pic where id='$xid' order by yy  DESC ";
						
						$query=mysql_db_query($nowdb,$sql_showpic)or die("cannot query".mysql_error());
						$num=mysql_num_rows($query);
						
						if($num==0)
						{
						//$img="<img src=\"../images/personnel/noimage.jpg\">";
						$img="<img src=\"../../../images_sys/noimage.jpg\">";
						
						?>
          <table width="123" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#000000">
            <tr>
              <td  align="center" bgcolor="#F4F4F4" style="border:1px #5595CC solid;padding:2px;"><?=$img?></td>
            </tr>
          </table>
          <? }
						else
						{
					$j=0;	
					while($rp=mysql_fetch_assoc($query))
					{
						//$img="<img src=\"images/personal/$rp[imgname]\" width=120 height=160 >";
						$img = "<img src=\"../../../../edubkk_image_file/$rsv[siteid]/$rp[imgname]\" width=120 height=160 >";
						?>
          <table width="123" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#000000">
            <tr>
              <td align="center" bgcolor="#F4F4F4" style="border:1px #5595CC solid; padding:2px;"><?=$img?></td>
            </tr>
            <tr>
              <td height="25" align="center" bgcolor="#F4F4F4">ภาพ ปี พ.ศ.
                  <? if($rp[yy] >0){ echo "$rp[yy]";}else{ echo "ไม่ระบุ";}?>              </td>
            </tr>
          </table>
          <? $j++; if($j>0){break;}
						}
						
						}
						 ?></td>
        <td width="86%" valign="top">
		<form  name ="form1" method = POST  action = "<?  echo $PHP_SELF ; ?>" onSubmit="return ch();" >
		<table width="100%" border="0" cellspacing="1" cellpadding="2">
          <tr>
            <td class="style1" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="363" rowspan="2"><font color="#000000">ข้อมูลสำคัญโดยย่อ </font></td>
                <td width="438" align="right">รหัสประจำตัวประชาชน :<?=$rsv[CZ_ID];?></td>
              </tr>
              <tr>
                <td align="right">ข้อมูล ณ วันที่
                  <?=MakeDate($arr_salary[date]);?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" align="right" cellpadding="3" cellspacing="1">
              <tr>
                <td width="26%" align="right" valign="top"><strong>ชื่อ - นามสกุล :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?=" $rsv[prename_th] $rsv[name_th]   &nbsp;$rsv[surname_th]"?>                </td>
              </tr>
              
              <tr>
                <td align="right" valign="top">&nbsp;</td>
                <td colspan="2" valign="top"><? if($rsv[prename_en]!="" and $rsv[name_en]!=""){echo " $rsv[prename_en] $rsv[name_en]   &nbsp;$rsv[surname_en]";}else{}?></td>
                </tr>
              <tr>
                <td align="right" valign="top"><strong>ตำแหน่งปัจจุบัน :&nbsp;</strong>
                    <? /*SELECT DISTINCT
								`salary`.`position`,
								`salary`.`radub`,
								`salary`.`date`,
								`salary`.`runno`
								FROM
																	`salary`
								WHERE
																	`salary`.`id` = '$xid'
								ORDER BY
								`salary`.`runno` DESC,
																							`salary`.`dateorder` DESC */ $sql_po="SELECT
															`salary`.`radub`,
															`salary`.`date`,
															`salary`.`runno`,
															`salary`.`dateorder`,
															`salary`.`runid`,
															`salary`.`position`,
															`salary`.`pls`
															FROM
																																`salary`
															WHERE
															`salary`.`id` = '$xid' AND
															`salary`.`position`  =  '$arr_general[position_now]'
															ORDER BY
															`salary`.`date` ASC
															LIMIT 1
															";
									$query_po=mysql_db_query($nowdb,$sql_po)or die("cannot query".mysql_error());
									$arr_po=mysql_fetch_assoc($query_po);
?></td>
                <td colspan="2" valign="top"><? //="$rsv[position_now] <strong>ระดับ :&nbsp;</strong>$rsv[radub] (<strong>เลขที่ตำแหน่ง :</strong>$rsv[noposition])";
					#####  ตำแหน่งและวันที่ล่าสุดในการดำรงตำแหน่ง
					$sql_salary = "SELECT * FROM salary WHERE id='$arr_general[id]' order by date DESC,salary DESC,dateorder DESC LIMIT 1";
					$result_salary = mysql_db_query($nowdb,$sql_salary);
					$rs_salary = mysql_fetch_assoc($result_salary);
					echo "$rs_salary[position] (<strong>เลขที่ตำแหน่ง :</strong>$rs_salary[noposition])<br> ";
						$sql_salary = "SELECT * FROM salary WHERE id='$arr_general[id]'  and (position_id='$rs_salary[position_id]'  or position='$rs_salary[position]') order by date asc,salary asc,dateorder asc LIMIT 1 ";
					$result_salary2 = mysql_db_query($nowdb,$sql_salary);
					$rs_salary2 = mysql_fetch_assoc($result_salary2);
					
					
					echo MakeDate($rs_salary2['date'])."($rs_salary[noorder])" ;
				?></td>
                </tr>
              <tr>
                <td align="right" valign="top"><strong>ระดับ :&nbsp; </strong></td>
                <td colspan="2" valign="top"><?=$rs_salary[radub]?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>วิทยฐานะ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? 
								//$sql_vitaya="select * from vitaya_stat where id='$arr_general[id]' ORDER BY date_command DESC,updatetime ASC LIMIT 1";
								$sql_vitaya = "SELECT
t1.id,
t1.salary_id,
t1.vitaya_id,
t1.name,
t1.vitaya_major_id,
t1.vitaya_major,
t1.vitaya_ref,
t1.vitaya_work,
t1.vitaya_work_type,
t1.date_command,
t1.date_start,
t1.remark,
t1.updatetime,
t2.orderby
FROM
$nowdb.vitaya_stat as t1
Inner Join $dbnamemaster.vitaya  as t2 ON t1.vitaya_id = t2.runid
WHERE
t1.id =  '$arr_general[id]'
ORDER BY
t2.orderby desc
LIMIT 1";
								
								 $query_vitaya=@mysql_db_query($nowdb,$sql_vitaya);
								$arr_vitaya=@mysql_fetch_assoc($query_vitaya);			
								$date_start=$arr_vitaya[date_start];
		
							/*if($rsv[vitaya] != ""){
									$show_vitaya1 = "$rsv[vitaya] "."(<strong>ได้รับเมื่อวันที่ : </strong>".MakeDate($date_start)."<strong> ตามหนังสือ :</strong>".$rsv[remark].")";
							}else*/ 
							if($arr_vitaya[name] != ""){
								$show_vitaya1 = "$rs_salary[position]$arr_vitaya[name] "."(<strong>ได้รับเมื่อวันที่ : </strong>".MakeDate($date_start)."<strong> ตามหนังสือ :</strong>".$arr_vitaya[remark].")";
							}else{
									$show_vitaya1 ="ยังไม่มีวิทยฐานะ";
							}
								echo $show_vitaya1;
								?> </td>	
                </tr>
              <tr>
			  <? 					
										$sql_school="SELECT *  from $dbnamemaster.allschool where id='$rsv[schoolid]' ";
										$query_school=mysql_db_query($dbnamemaster,$sql_school)or die (mysql_error());
										$rs_school=mysql_fetch_assoc($query_school);			
										
										
										$check_id_school = substr($rs_school[id],0,2); // เช็คหารหัสโรงเรียนที่ขึ้นต้นด้วย 99 
										$c_pos = strpos($rs_school[office],"ไม่ระบุ"); // เช็คว่าชื่อโรงเรียนมีคำว่า ไม่ระบุอยู่หรือไม่
										
										$sql_secname="SELECT secname from $dbnamemaster.eduarea where secid='$rsv[siteid]' ";
										$query_secname=mysql_db_query($dbnamemaster,$sql_secname)or die (mysql_error());
										$rs_secname=mysql_fetch_assoc($query_secname);	
										$sql_work="select * from $dbnamemaster.hr_work where workid='$rsv[work]' ";
										$query_work=mysql_db_query($db_name,$sql_work) or die (mysql_error());
										$rsw=mysql_fetch_assoc($query_work);
										if($rsv[schoolid] ==$_SESSION[secid]){
											$group_work =$rsw[work];
											$rs_school=$rs_secname[secname];
											$rssecname="";
										 }	else{
											if($check_id_school == "99"){// ตรวจสอบรหัสโรงเรียนที่ขึ้นต้นด้วย 99
												if($c_pos === false){
													$rs_school=$rs_school[office];
												}else{
													$rs_school=str_replace("ไม่ระบุ","",$rs_school[office]);
												}											
											}else{
											//echo "<strong>สังกัด :&nbsp;</strong>";
											if($rs_school[id]==$rsv[siteid]){
												$rs_school="".$rs_school[office];
											}else{
											$rs_school="โรงเรียน".$rs_school[office];
											}
											
											$rssecname=$rs_secname[secname];
											}
										}
						
					?>
                <td align="right" valign="top"><strong>หน่วยงาน :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?=$group_work?>&nbsp;<?=$rs_school;?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>สังกัด :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? if($rssecname != ""){ echo "$rssecname<br>";}?><?="$rsv[subminis_now] &nbsp;$rsv[minis_now] ";?></td>
              </tr>
<?  
if ($allow_showsalary != "no"){  
//	if($rsv[salary] > 0){
//		$xsalary = number_format($rsv[salary]) ; 
//	}else{
		$xsalary = number_format($rs8[salary]) ; 
	//}
	
}else{
	$xsalary ="*****" ; 	
} ### END   if ($allow_showsalary != "no"){  
 ?>			  
              <tr>
                <td align="right" valign="top"><strong>เงินเดือนปัจจุบัน :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?=($xsalary)." บาท";?></td>
              </tr>
		  
 
              <tr>
                <td align="right" valign="top"><strong>วันเดือนปีเกิด :&nbsp;</strong></td>
                <td colspan="2" valign="top">
<? 
if ($allow_showbirthday != "no"){  
	$birth=$rsv[birthday];
	echo MakeDate($birth);
	$diff  = dateLength($rsv[birthday]);
	if ($birth != ""){
		echo "&nbsp; อายุ &nbsp;".$diff[year]."&nbsp;ปี&nbsp;&nbsp;".$diff[month]."&nbsp;เดือน&nbsp;&nbsp;".$diff[day]."&nbsp;วัน";
	}else{
		echo "-";
	} ####### END if ($birth != ""){	
}else{ 
	echo "***** อายุ  ** ปี ** เดือน ** วัน ";

} ### END   if ($allow_showbirthday != "no"){ 
?></td>
              </tr>
 
              <tr>
                <td align="right" valign="top"><strong>ที่อยู่ปัจจุบัน :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? // if($rsv[contract_add]!=""){echo "$rsv[contract_add]";} else{echo "-";}
				
			if($rsv[contract_add]!=""){
					echo "$rsv[contract_add]";
				} else{
					$sql_address = "SELECT * FROM hr_addhistoryaddress WHERE gen_id='$arr_general[id]' and kp7_active='1' ORDER BY daterec DESC , updatetime DESC LIMIT 1";
					//echo $sql_address;
					$result_address = mysql_db_query($nowdb,$sql_address);
					$rs_address = mysql_fetch_assoc($result_address);
						if($rs_address[address] != ""){
								echo "$rs_address[address]";
						}else{
								echo "-";
						}// end 		if($rs_address[address] != ""){
				} //end 	if($rsv[contract_add]!=""){

				
				?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>วันครบเกษียณอายุ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?=retireDate($rsv[birthday])?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>วันสั่งบรรจุ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? $startdate =$rsv[startdate];
								  echo  MakeDate($startdate); ?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>วันเริ่มปฏิบัติราชการ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? $begindate =$rsv[begindate];
								  echo  MakeDate($begindate); ?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong> อายุราชการ ณ ปัจจุบัน :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? $diff  = dateLength($rsv[begindate]);
								  ?>
                    <? if ($rsv[begindate] != ""){
	echo "".$diff[year]."&nbsp;ปี&nbsp;&nbsp;".$diff[month]."&nbsp;เดือน&nbsp;&nbsp;".$diff[day]."&nbsp;วัน";
}else{
  	echo "-";
}?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>การศึกษาสูงสุด :&nbsp; </strong></td>
                <td colspan="2" valign="top"><?
				
					########### ระดับการศึกษา
				$sql_graduate = "SELECT 
$nowdb.graduate.place,
$nowdb.graduate.grade,
$dbnamemaster.hr_addhighgrade.highgrade,
$nowdb.graduate.degree_level,
$nowdb.graduate.university_level,
$nowdb.graduate.major_level 
FROM $nowdb.graduate inner join $dbnamemaster.hr_addhighgrade on $nowdb.graduate.graduate_level=$dbnamemaster.hr_addhighgrade.runid 
WHERE $nowdb.graduate.id='$arr_general[id]' and kp7_active='1' AND  $nowdb.graduate.graduate_level NOT IN('50','70','90')  ORDER BY  $nowdb.graduate.graduate_level DESC,$nowdb.graduate.finishyear DESC LIMIT 1";
				$result_graduate = mysql_db_query($nowdb,$sql_graduate);
				$rs_gradate = mysql_fetch_assoc($result_graduate);
				if($rs_gradate[place] != ""){  // สถานที่การศึกษา
					$show_place = "$rs_gradate[place]";
				}else {
					$xsql_place = "SELECT * FROM hr_adduniversity WHERE u_id='$rs_gradate[university_level]' ";
					$xresult_place = mysql_db_query($dbnamemaster,$xsql_place);
					$xrs_p = mysql_fetch_assoc($xresult_place);
					$show_place = "$xrs_p[u_name]";
				}
				########   สาขาวิชา
				if($rs_gradate[grade] != ""){
						$show_grade = "$rs_gradate[grade]";
				}else{
						$xsql_degree = "SELECT * FROM hr_adddegree WHERE degree_id='$rs_gradate[degree_level]'";
						$xresult_degree = mysql_db_query($dbnamemaster,$xsql_degree);
						$xrs_d = mysql_fetch_assoc($xresult_degree);
						
						$xsql_major = "SELECT * FROM hr_addmajor WHERE major_id='$rs_gradate[major_level]'";
						$xresult_major = mysql_db_query($dbnamemaster,$xsql_major);
						$xrs_d1 = mysql_fetch_assoc($xresult_major);
						$show_grade = $xrs_d[degree_name]." ".$xrs_d1[major];
				}
				
				echo "ระดับ : $rs_gradate[highgrade] &nbsp;&nbsp;(สาขาวิชา :$show_grade &nbsp;&nbsp;สถาบัน : $show_place )";

				
				?></td>
              </tr>
<!--              <tr>
			  			  <?
			  	//$sql_prohibit="select * from hr_prohibit where id='$rsv[CZ_ID]' ";
				//$query_pro=mysql_db_query($nowdb,$sql_prohibit)or die(mysql_error());
				//$num_pro=mysql_num_rows($query_pro);
			   ?>
                <td align="right" valign="top"><?  //if($num_pro!=0)
			  // {
			  	//echo"<strong>ประวัติการได้รับโทษทางวินัย :</strong>";
			
			    ?></td>/
                <td width="55%" valign="top"><? 
				//for($i=0;$i<$num_pro;$i++)
			//	{
				//$rsp=mysql_fetch_assoc($query_pro);
					//if($rsp[label_yy] != ""){ $xshowdate = $rsp[label_yy];}else{ $xshowdate = MakeDate($rsp[yy]); }
				//echo $xshowdate."&nbsp; $rsp[comment]<br>";
				//}
				//}//END if
				//else
				//{
					
				//}
				?></td>
                <td width="19%" valign="top">&nbsp;</td>
              </tr>
-->              <tr>

                <td align="right" valign="top"><strong>เครื่องราชย์อิสริยาภรณ์ :&nbsp;</strong></td>
                <td valign="top"><?
//					if($rsv[getroyal] != ""){
						echo "$rsv[getroyal]";
//					}else{
					/*		$sql_royal = "SELECT getroyal FROM getroyal WHERE id='$arr_general[id]' and kp7_active='1' ORDER BY  date DESC,orderid DESC limit 1";
							$result_royal = mysql_db_query($nowdb,$sql_royal);
							$rs_royal = mysql_fetch_assoc($result_royal);
							echo "$rs_royal[getroyal]";
							*/
//					}
//					$sql_royal = "SELECT $nowdb.getroyal.getroyal FROM $nowdb.getroyal Inner Join $dbnamemaster.cordon_list ON $nowdb.getroyal.getroyal = $dbnamemaster.cordon_list.name Inner Join $dbnamemaster.cordon_group ON $dbnamemaster.cordon_list.groupid = $dbnamemaster.cordon_group.runid
//WHERE $nowdb.getroyal.id =  '$arr_general[id]' AND $nowdb.getroyal.kp7_active='1' ORDER BY $dbnamemaster.cordon_group.`order` ASC, $dbnamemaster.cordon_list.runid ASC";
//			$result_royal = mysql_db_query($nowdb,$sql_royal);
//			$rs_royal = mysql_fetch_assoc($result_royal);
//			echo $rs_royal[getroyal];

				
				?></td>
                <td valign="top">&nbsp;</td>
              </tr>
           <?
              	   $sql_gpf = "SELECT * FROM tbl_status_gpf WHERE runid='$rsv[status_gpf]'";
					$result_gpf = mysql_db_query($dbnamemaster,$sql_gpf);
					$rs_gpf = mysql_fetch_assoc($result_gpf);
				  if($rs_gpf[gpf_detail] != ""){
			  ?>
			  <tr>
                <td align="right" valign="top"><strong>สถานะการเป็นสมาชิก กบข. : </strong></td>
                <td colspan="2" valign="top"><? echo "$rs_gpf[gpf_detail]";?></td>
                </tr>
				 <?
				  }
				// if($rsv[comment] != ""){
			   ?>
              <tr>
					<td align="right" valign="top"><strong>ความดีความชอบย้อนหลัง 5 ครั้ง : </strong></td>
					<td colspan="2" valign="top">
							<?
							$db38=STR_PREFIX_DB.$rsv[siteid];
							function chk38($cid){
									global $db38;
									$sql38 = " select count(id) as numChk
													from salary
													where id='".$cid."' and 
										(
									(position not LIKE  '%ผู้อำนวยการ%' and position not LIKE  '%ผอ%' )
									 AND ( position not  LIKE  '%ครู%'    )
									 AND ( position not  LIKE  '%อาจารย์%' )
									 AND ( position not  LIKE  '%ศึกษานิ%' ) 
									 AND ( position not  LIKE  '%ศน%' ) 
									 AND ( position not  LIKE  ''    ) 
									 AND ( position NOT LIKE '%เจ้าหน้าที่บริหารการศึกษา%' )
									 AND (position NOT LIKE '%จนท%บริหารการศึกษา%' )									
										) ";
									//echo $sql38;
									$rs38=mysql_db_query($db38,$sql38);
									$result38=mysql_fetch_assoc($rs38);
									if($result38['numChk']>0){
										return 1;
									}else{
										return 0;
									}
							}
							//echo chk38($xid);
							//echo date('Y-m-d');
							function find_good($date){
									$dateT=explode("-",$date);
									$day=(int)$dateT[2];
									$month=(int)$dateT[1];
									$year=(int)$dateT[0];
									if($day >= 1 && ($month >= 10 || $month < 4)){
											$yearTemp=$year+543;
											$arr[]=array(id=>'0',caption=>"1 ต.ค. $yearTemp",variable=>"$yearTemp-10-01");
											$yearTemp=$year+543;
											$arr[]=array(id=>'1',caption=>"1 เม.ย. $yearTemp",variable=>"$yearTemp-04-01");
											$yearTemp=$year+543-1;
											$arr[]=array(id=>'2',caption=>"1 ต.ค. $yearTemp",variable=>"$yearTemp-10-01");
											$yearTemp=$year+543-1;
											$arr[]=array(id=>'3',caption=>"1 เม.ย. $yearTemp",variable=>"$yearTemp-04-01");
											$yearTemp=$year+543-2;
											$arr[]=array(id=>'4',caption=>"1 ต.ค. $yearTemp",variable=>"$yearTemp-10-01");
											$yearTemp=$year+543-2;
											$arr[]=array(id=>'5',caption=>"1 เม.ย. $yearTemp",variable=>"$yearTemp-04-01");
											$yearTemp=$year+543-3;
											$arr[]=array(id=>'6',caption=>"1 ต.ค. $yearTemp",variable=>"$yearTemp-10-01");
									}else if($day >= 1 && ($month >= 4 || $month < 10)){
											$yearTemp=$year+543;
											$arr[]=array(id=>'0',caption=>"1 เม.ย. $yearTemp",variable=>"$yearTemp-04-01");
											$yearTemp=$year+543-1;
											$arr[]=array(id=>'1',caption=>"1 ต.ค. $yearTemp",variable=>"$yearTemp-10-01");
											$yearTemp=$year+543-1;
											$arr[]=array(id=>'2',caption=>"1 เม.ย. $yearTemp",variable=>"$yearTemp-04-01");
											$yearTemp=$year+543-2;
											$arr[]=array(id=>'3',caption=>"1 ต.ค. $yearTemp",variable=>"$yearTemp-10-01");
											$yearTemp=$year+543-2;
											$arr[]=array(id=>'4',caption=>"1 เม.ย. $yearTemp",variable=>"$yearTemp-04-01");
											$yearTemp=$year+543-3;
											$arr[]=array(id=>'5',caption=>"1 ต.ค. $yearTemp",variable=>"$yearTemp-10-01");
											$yearTemp=$year+543-3;
											$arr[]=array(id=>'6',caption=>"1 เม.ย. $yearTemp",variable=>"$yearTemp-04-01");
									}
									//echo $dateT[2].':'.$dateT[1].':'.$dateT[0];
									return $arr;
							}
							$arrvalue=find_good(date('Y-m-d'));
							/*echo '<pre>';
							print_r($arrvalue);*/
							$chkNum=4;
							foreach($arrvalue as $key=>$value){
									//echo $value[variable].';'.$value[id].'<br>';
									if($value[id]<=$chkNum){
											$sqlGood="	SELECT
																		salary.id,
																		salary.`date`,
																		salary.lv,
																		salary.order_type
																FROM salary
																WHERE salary.id =  '".$xid."' AND salary.`date` =  '".$value[variable]."'
																ORDER By salary.lv DESC
																	";
													//echo $sqlGood.'<br>';
											$dbGood=STR_PREFIX_DB.$rsv[siteid];
											$rsGood=mysql_db_query($dbGood,$sqlGood);
											$numGood=mysql_num_rows($rsGood);
											if($numGood==0){
													$chkNum++;
											}else if($numGood==1){
													$resGood=mysql_fetch_assoc($rsGood);
													if(chk38($xid)==1 && $value[variable]>='2553-04-01'){
															$arrResult[]=array(dateS=>MakeDate($resGood['date']),good=>$resGood['lv'],ck38=>"%");
													}else{
															$arrResult[]=array(dateS=>MakeDate($resGood['date']),good=>$resGood['lv'],ck38=>"");
													}
											}else{
													/*print"<script language='JavaScript'> alert('test') </script> ";*/
													$resGood=mysql_fetch_assoc($rsGood);
													if(chk38($xid)==1 && $value[variable]>='2553-04-01'){
															$arrResult[]=array(dateS=>MakeDate($resGood['date']),good=>$resGood['lv'],ck38=>"%");
													}else{
															$arrResult[]=array(dateS=>MakeDate($resGood['date']),good=>$resGood['lv'],ck38=>"");
													}
											}
									}
							}
							/*echo '<pre>';
							print_r($arrResult);*/
							//echo $rsv[siteid];
							?>
							<?
							
							function showStar($numStar,$value38){
									if($value38=='%'){
											$padTop=10;
											$padLeft=7;
											$padRight=6;
											if($numStar==0.0){
												$pic='win1';
											}else if($numStar==(-99.0)){
												$pic='win6';
												$numStar='   ';
												$padTop=20;
												$padLeft=20;
												$padRight=20;
											}else if($numStar==(-1.0)){
												$numStar='เต็มขั้น';
												$padTop=5;
												$padLeft=11;
												$padRight=7;
											}else if($numStar>=0.1 && $numStar <= 2.4){
												$pic='win2';
											}else if($numStar>=2.5 && $numStar <= 3.4){
												$pic='win3';
											}else if($numStar>=3.5 && $numStar <= 4.4){
												$pic='win3_1';
											}else if($numStar>=4.5 && $numStar <= 6.0){
												$pic='win4';
											}else{
												$pic='win6';
												$numStar='   ';
												$padTop=20;
												$padLeft=20;
												$padRight=20;
											}
									}else{
											$padTop=11;
											$padLeft=11;
											$padRight=11;
											if($numStar==0.0){
												$pic='win1';
											}else if($numStar==0.5){
												$pic='win2';
											}else if($numStar==1.0){
												$pic='win3';
											}else if($numStar==(-99.0)){
												$pic='win6';
												$numStar='   ';
												$padTop=20;
												$padLeft=20;
												$padRight=20;
											}else if($numStar==(-1.0)){
												$pic='win5';
												$numStar='เต็มขั้น';
												$padTop=5;
												$padLeft=11;
												$padRight=7;
											}else if($numStar==1.5){
												$pic='win3_1';
											}else if($numStar==2.0){
												$pic='win4';
											}else{
												$pic='win6';
												$numStar='   ';
												$padTop=20;
												$padLeft=20;
												$padRight=20;
											}
									}
													echo '<table border="0" cellpadding="0" cellspacing="0" width="38" height="50" >';
															echo '<tr><td width="20" height="19">';
																	echo '<table border="0" cellpadding="0" cellspacing="0" width="100%" height="50"  style="background-image:url(../../../images_sys/';
																	echo $pic;
																	echo '.png);">';
																	echo '<tr><td align="center" valign="top">';
																			echo '<table border="0"  width="100%" cellpadding="0" cellspacing="0">';
																					echo '<tr><td style="padding-top:';
																					echo $padTop;
																					echo 'px; padding-left:';
																					echo $padLeft;
																					echo 'px; padding-right:';
																					echo $padRight;
																					echo 'px;">';
																						echo '<font color="#FFFFFF">';
																							
																							echo $numStar.$value38;
																						echo '</font>';
																					echo '</td></tr>';
																			echo '</table>';
																	echo '</td></tr>';
																	echo '</table>';
															echo '</td></tr>';
													echo '</table>';
								}
							?>		
							<table width="70%" border="0" cellpadding="3" cellspacing="1" bgcolor="#0033FF">
									<tr bgcolor="#F4F4F4" align="center">
											<?
											for($a=4;$a>=0;$a--){
											?>
											<td><?=$arrResult[$a][dateS]?></td>
											<? }?>
									</tr>
									<tr bgcolor="#F4F4F4" align="center">
											<?
											for($a=4;$a>=0;$a--){
											?>
											<td><?=showStar(number_format($arrResult[$a][good],1),$arrResult[$a][ck38])?></td>
											<? }?>
									</tr>
							</table>
					</td>
              </tr>
			  <tr>
			  		<td></td>
					<td><?="หมายเหตุ:"?>
							<table width="33%" border="0" cellpadding="3" cellspacing="1" bgcolor="#0033FF">
									<tr bgcolor="#F4F4F4" align="center">
											<td width="32%"></td>
											<td width="34%" align="center"><strong>คิดแบบขั้น</strong></td>
											<td width="34%" align="center"><strong>คิดแบบร้อยละ</strong></td>
									</tr>
									<tr bgcolor="#F4F4F4" align="center">
											<td align="center"><img  src="../../../images_sys/win6.png" width="20" align="absmiddle"/></td>
											<td align="center">ไม่ระบุ</td>
											<td align="center">ไม่ระบุ</td>
									</tr>
									<tr bgcolor="#F4F4F4" align="center">
											<td align="center"><img  src="../../../images_sys/win1.png" width="20" align="absmiddle"/></td>
											<td align="center">0.0</td>
											<td align="center">0.0%</td>
									</tr>
									<tr bgcolor="#F4F4F4" align="center">
											<td align="center"><img  src="../../../images_sys/win2.png" width="20" align="absmiddle"/></td>
											<td align="center">0.5</td>
											<td align="center">0.1% - 2.4%</td>
									</tr>
									<tr bgcolor="#F4F4F4" align="center">
											<td align="center"><img  src="../../../images_sys/win3.png" width="20" align="absmiddle"/></td>
											<td align="center">1.0</td>
											<td align="center">2.5% - 3.4%</td>
									</tr>
									<tr bgcolor="#F4F4F4" align="center">
											<td align="center"><img  src="../../../images_sys/win3_1.png" width="20" align="absmiddle"/></td>
											<td align="center">1.5</td>
											<td align="center">3.5% - 4.4%</td>
									</tr>
									<tr bgcolor="#F4F4F4" align="center">
											<td align="center"><img  src="../../../images_sys/win4.png" width="20" align="absmiddle"/></td>
											<td align="center">2.0</td>
											<td align="center">4.5% - 6.0%</td>
									</tr>
									<tr bgcolor="#F4F4F4" align="center">
											<td align="center"><img  src="../../../images_sys/win5.png" width="20" align="absmiddle"/></td>
											<td align="center">เต็มขั้น</td>
											<td align="center">-</td>
									</tr>
						  </table>
					</td>
			  </tr>
              
<!--                   <tr>
                <td align="right" valign="top"><strong>สถานะการเป็นสมาชิก กบข. : </strong></td>
                <td colspan="2" valign="top"><? //echo "$rs_gpf[gpf_detail]";?></td>
                </tr>
-->
               <?
				// }//end  if($rsv[comment] != ""){
			   ?>

            </table></td>
          </tr>
        </table>
		</form>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="35">&nbsp;</td>
  </tr>
</table>
</body>
</html>

