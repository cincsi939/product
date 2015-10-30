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
include ("../../../config/phpconfig.php");
include ("timefunc.inc.php");
$getidcard = $_SESSION[idoffice] ;
function checkID($id) {
				if(strlen($id) != 13) return false;
				for($i=0, $sum=0; $i<12;$i++)
				$sum += (int)($id{$i})*(13-$i);
				if((11-($sum%11))%10 == (int)($id{12}))
				return true;
				return false;
}


/*if(isset($getidcard)) { 
	if( (!checkID($getidcard)) AND (substr($_SERVER["REMOTE_ADDR"],0,8) != "192.168.") ){
			echo "
					<script language=\"javascript\">
							alert(\" รหัสบัตรประชาชนของท่านไม่ตรงตามโครงสร้างของกรมการปกครอง \\n อาจเกิดจากการลงทะเบียนหรือการนำข้อมูลเข้า\\n กรุณาติดต่อ Callcenter  เพื่อให้แก้ไขก่อนจึงจะสามารถใช้งานระบบได้\");
							top.location.href=\"$mainwebsite\";
					</script>";
			exit;
	}
}  
*/

$sql_view="SELECT * FROM view_general where CZ_ID='$id' ";
$qry=mysql_db_query($db_name,$sql_view)or die ("error");
$rsv=mysql_fetch_assoc($qry);
$sql_general="SELECT * FROM general where id='$id' ";
$query_general=mysql_db_query($db_name,$sql_general)or die("CANNOT QOERY".mysql_error());
$arr_general=mysql_fetch_assoc($query_general);
$sql_salary="SELECT * from salary where id='$arr_general[id]' order by runno DESC";
$query_salary=mysql_db_query($db_name,$sql_salary)or die("CANNOT QOERY".mysql_error());
$arr_salary=mysql_fetch_assoc($query_salary);
$sql_graduate="SELECT place,grade,finishyear,place from graduate where id='$id' order by finishyear DESC ";
//echo $sql_graduate;
$query_graduate=mysql_db_query($db_name,$sql_graduate)or die("CANNOT QOERY".mysql_error());
$arr_graduate=mysql_fetch_assoc($query_graduate);
$sql_sa1="select * from salary where id='$arr_general[id]' order by date DESC ";
$query_sa=mysql_db_query($db_name,$sql_sa1)or die("CANNOT QOERY".mysql_error());
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

<table width="98%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4" align="center" style="border:1px solid #DADAE1;">
  <tr>
    <td height="35" align="left"  style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#ffffff', EndColorStr='#F4F4F4'); padding: 2px"><table width="627" border="0" cellspacing="0" cellpadding="2">
	<?
	if($dis_menu){
	?>
      <tr>
        <td height="26" colspan="2">		<a href="kp7_general.php?id=<?=$id?>"class="pp" title="ตรวจสอบข้อมูล กพ.7"><img src="../../../images_sys/pdf.gif" width="16" height="16"align="absmiddle" border=""> ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิก</a>ส์</td>
        </tr>
	  <?
	  }else{
	  ?>
	        <tr>
        <td width="107" height="26">
		<a href="general.php?id=<?=$arr_general[id]?>&action=edit" class="pp" title="แก้ไขข้อมูลส่วนบุคคล"><img src="images/edit.png" width="16" height="16" align="absmiddle" border="">แก้ไขข้อมูล</a>		</td>
        <td width="512" height="26"><a href="kp7_general.php?id=<?=$id?>"class="pp" title="ตรวจสอบข้อมูล กพ.7"><img src="../../../images_sys/pdf.gif" width="16" height="16"align="absmiddle" border=""> ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิก</a>ส์</td>
      </tr>

	  <?
	  }
	  ?>
    </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="2" align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
      <tr>
        <td width="14%" height="515" valign="top"><?
						$sql_showpic="select yy,imgname from general_pic where id='$id' and kp7_active='1' order by no  DESC ";
						
						$query=mysql_db_query($db_name,$sql_showpic)or die("cannot query".mysql_error());
						$num=mysql_num_rows($query);
						
						if($num==0)
						{
						//$img="<img src=\"../images/personnel/noimage.jpg\">";
						$img="<img src=\"../../../../images_sys/noimage.jpg\">";
						
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
						$img = "<img src=\"../../../../../image_file/$rsv[siteid]/$rp[imgname]\" width=120 height=160 >";
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
                  <?=MakeDate($rs8[date]);?></td>
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
																	`salary`.`id` = '$arr_general[id]'
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
															`salary`.`id` = '$arr_general[id]' AND
															`salary`.`position`  =  '$arr_general[position_now]'
															ORDER BY
															`salary`.`date` ASC
															LIMIT 1
															";
									$query_po=mysql_db_query($db_name,$sql_po)or die("cannot query".mysql_error());
									$arr_po=mysql_fetch_assoc($query_po);
?></td>
                <td colspan="2" valign="top"><?="$rsv[position_now] <strong>ระดับ :&nbsp;</strong>$rsv[radub] (<strong>เลขที่ตำแหน่ง :</strong>$rsv[noposition])";?></td>
                </tr>
				<?
					$sql_query="SELECT * FROM vitaya_stat WHERE id='$arr_general[id]'";
					$xresult_v=mysql_query($sql_query);
					$xrs_v=mysql_fetch_assoc($xresult_v);
				?>
<!--              <tr>
                <td align="right" valign="top"><strong>วิทยฐานะ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? 
//						if($rsv[vitaya] ==""){
//						echo "ยังไม่ได้รับวิทยฐานะ";
//						}else {
//								$sql_vitaya="select * from vitaya_stat where id='$arr_general[id]' ORDER BY date_command DESC";
//								 $query_vitaya=mysql_db_query($db_name,$sql_vitaya)or die("cannot query");
//								$arr_vitaya=mysql_fetch_assoc($query_vitaya);
//								echo $rsv[vitaya];					
//								$date_start=$arr_vitaya[date_start];
//							echo"(<strong>ได้รับเมื่อวันที่ : </strong>".MakeDate($date_start)."<strong> ตามหนังสือ :</strong>".$rsv[remark].")";
//
//						}
								?> </td>	
                </tr>-->
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
											$rs_school=$rsw[work];
											$rssecname=$rs_secname[secname];
										 }	else{
											if($check_id_school == "99"){// ตรวจสอบรหัสโรงเรียนที่ขึ้นต้นด้วย 99
												if($c_pos === false){
													$rs_school=$rs_school[office];
												}else{
													$rs_school=str_replace("ไม่ระบุ","",$rs_school[office]);
												}											
											}else{
											//echo "<strong>สังกัด :&nbsp;</strong>";
											$rs_school="".$rs_school[office];
											$rssecname=$rs_secname[secname];
											}
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
              <tr>
                <td align="right" valign="top"><strong>เงินเดือนปัจจุบัน :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?=number_format($rsv[salary])." บาท"." ( ข้อมูล ณ วันที่ ".MakeDate($rs8[date])." ) ";?></td>
              </tr>
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
				$query_pro=mysql_db_query($db_name,$sql_prohibit)or die(mysql_error());
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
    <td height="39" style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#ffffff', EndColorStr='#F4F4F4'); padding:2px"><? include("../../../config/licence_inc.php");?></td>
  </tr>
</table>
</body>
</html>

