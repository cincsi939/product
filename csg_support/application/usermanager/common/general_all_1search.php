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
//mysql_connect("localhost","root","sapphire");
//$db_name="democmss_db";
  //$iresult = mysql_query("SET character_set_results=tis-620");
//$iresult = mysql_query("SET NAMES TIS620");
/*Conn2DB();*/

$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$month 			= array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
function MakeDate($d){
global $monthname;
	if (!$d) return "";
	
	$d1=explode("-",$d);
	if (($d1[0] < 1)  and ($d1[1] < 1)){ return "" ; } 
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " " . $d1[0];
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
$nowdb = "cmss_" . $xsiteid ; 
$masterdb = $dbnamemaster   ; 

 
$sql_general="SELECT * FROM general where id='$xid' ";
$query_general=mysql_db_query($nowdb,$sql_general)or die("CANNOT QOERY Line ". __LINE__ .mysql_error());
$arr_general=mysql_fetch_assoc($query_general);


$sql_salary="SELECT * from salary where id='$xid' order by runno DESC";
$query_salary=mysql_db_query($nowdb,$sql_salary)or die("CANNOT QOERY Line ". __LINE__ .mysql_error());
$arr_salary=mysql_fetch_assoc($query_salary);


$sql_graduate="SELECT place,grade,finishyear,place from graduate where id='$xid' order by finishyear DESC ";
//echo $sql_graduate;
$query_graduate=mysql_db_query($nowdb,$sql_graduate)or die("CANNOT QOERY".mysql_error());
$arr_graduate=mysql_fetch_assoc($query_graduate);


$sql_sa1="select * from salary where id='$xid' order by date DESC ";
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
filter:propro_id:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#F4F4F4', EndColorStr='#F4F4F4'); 

}
.style1 {border-bottom: #5595CC 1px solid; border-top: #5595CC 1px solid; height: 25px; padding-left: 10px; font-weight: bold; }

-->
</style></head>
<body>

<table width="98%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4" align="center" style="border:1px solid #DADAE1;">
  <tr>
    <td height="35" align="left"  style="filter:propro_id:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#ffffff', EndColorStr='#F4F4F4'); padding: 2px">&nbsp;</td>
  </tr>
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
						$img="<img src=\"../images/personnel/noimage.jpg\">";
						
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
						$img="<img src=\"images/personal/$rp[imgname]\" width=120 height=160 >";
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
                <td width="444" rowspan="2"><font color="#000000">ข้อมูลสำคัญโดยย่อ </font></td>
                <td align="right">อ้างอิง :
                  <?=$rsv[CZ_ID];?></td>
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
                <td width="23%" align="right" valign="top"><strong>ชื่อ - นามสกุล :&nbsp;</strong></td>
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
                <td colspan="2" valign="top"><?="$rsv[position_now] <strong>ระดับ :&nbsp;</strong>$rsv[radub] (<strong>เลขที่ตำแหน่ง :</strong>$rsv[noposition])";?></td>
                </tr>
				<?
					$sql_query="SELECT * FROM vitaya_stat WHERE id='$xid'";
					$xresult_v=mysql_db_query($nowdb , $sql_query);
					$xrs_v=mysql_fetch_assoc($xresult_v);
				?>
              <tr>
                <td align="right" valign="top"><strong>วิทยฐานะ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? 
						if($rsv[vitaya] ==""){
						echo "ยังไม่ได้รับวิทยฐานะ";
						}else {
								$sql_vitaya="select * from vitaya_stat where id='$xid' ORDER BY date_command DESC";
								 $query_vitaya=mysql_db_query($nowdb,$sql_vitaya)or die("cannot query");
								$arr_vitaya=mysql_fetch_assoc($query_vitaya);
								echo $rsv[vitaya];					
								$date_start=$arr_vitaya[date_start];
							echo"(<strong>ได้รับเมื่อวันที่ : </strong>".MakeDate($date_start)   .")"  ; 

						}
								?> </td>	
                </tr>
              <tr>
			  <? 
					$royal=$rsv[getroyal];
			  ?>
                <td align="right" valign="top"><strong>เครื่องราชย์อิสริยาภรณ์ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? if($royal=="")
				{
				echo "-";
				}
				else
				{
					echo "$royal";
				}
				;?></td>
              </tr>
              <tr>
			  <? 					
										$sql_school="SELECT office from $dbnamemaster.allschool where id='$rsv[schoolid]' ";
										$query_school=mysql_db_query($dbnamemaster,$sql_school)or die (mysql_error());
										$rs_school=mysql_fetch_assoc($query_school);			
										$sql_secname="SELECT secname from $dbnamemaster.eduarea where secid='$rsv[siteid]' ";
										$query_secname=mysql_db_query($dbnamemaster,$sql_secname)or die (mysql_error());
										$rs_secname=mysql_fetch_assoc($query_secname);	
										$sql_work="select * from $dbnamemaster.hr_work where workid='$rsv[work]' ";
										$query_work=mysql_db_query($db_name,$sql_work) or die (mysql_error());
										$rsw=mysql_fetch_assoc($query_work);
								  	if($rsv[schoolid] !=""){
										$rs_school="โรงเรียน".$rs_school[office];
										$rssecname=$rs_secname[secname];
								  }	else{
									//echo "<strong>สังกัด :&nbsp;</strong>";
									$rs_school=$rsw[work];
									$rssecname=$rs_secname[secname];
									}
						
					?>
                <td align="right" valign="top"><strong>หน่วยงาน :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?=$rs_school;?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>สังกัด :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?=$rssecname;?>
                  <br><?="$rsv[subminis_now] &nbsp;$rsv[minis_now] ";?></td>
              </tr>
<?  
if ($allow_showsalary != "no"){  
	$xsalary = $rsv[salary] ; 
}else{
	$xsalary ="*****" ; 	
} ### END   if ($allow_showsalary != "no"){  
 ?>			  
              <tr>
                <td align="right" valign="top"><strong>เงินเดือนปัจจุบัน :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?=number_format($xsalary)." บาท";?></td>
              </tr>
		  
<?  if ($allow_showbirthday != "no"){   ?>
              <tr>
                <td align="right" valign="top"><strong>วันเดือนปีเกิด :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? $birth=$rsv[birthday];
									 		echo MakeDate($birth);?><? $diff  = dateLength($rsv[birthday]);
if ($rsv[birthday] != ""){
	echo "&nbsp; อายุ &nbsp;".$diff[year]."&nbsp;ปี&nbsp;&nbsp;".$diff[month]."&nbsp;เดือน&nbsp;&nbsp;".$diff[day]."&nbsp;วัน";
}else{
  	echo "-";
}
?></td>
              </tr>
<? } ### END   if ($allow_showbirthday != "no"){   ?>
              <tr>
                <td align="right" valign="top"><strong>ที่อยู่ปัจจุบัน :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? if($rsv[contract_add]!=""){echo "$rsv[contract_add]";} else{echo "-";}?></td>
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
                <td colspan="2" valign="top"><?="ระดับ : $rsv[education] &nbsp;&nbsp;(สาขาวิชา :$rsv[grade] &nbsp;&nbsp;สถาบัน : $rsv[place] )";?></td>
              </tr>
              <tr>
			  			  <?
			  	$sql_prohibit="select * from hr_prohibit where id='$rsv[CZ_ID]' ";
				$query_pro=mysql_db_query($nowdb,$sql_prohibit)or die(mysql_error());
				$num_pro=mysql_num_rows($query_pro);
			   ?>
                <td align="right" valign="top"><?   if($num_pro!=0)
			   {
			  	echo"<strong>ประวัติการได้รับโทษทางวินัย :</strong>";
			
			    ?></td>
                <td valign="top"><? 
				for($i=0;$i<$num_pro;$i++)
				{
				$rsp=mysql_fetch_assoc($query_pro);
				echo"$rsp[yy] &nbsp; $rsp[comment]<br>";
				}
				}//END if
				else
				{
					
				}
				?></td>
                <td width="19%" valign="top">&nbsp;</td>
              </tr>
              <tr>

                <td align="right" valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>
		</form>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="35" style="filter:propro_id:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#ffffff', EndColorStr='#F4F4F4'); padding:2px">&nbsp;</td>
  </tr>
</table>
</body>
</html>

