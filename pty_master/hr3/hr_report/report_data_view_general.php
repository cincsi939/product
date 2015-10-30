<?php
ob_start();
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
if($_GET[xid] != ""){
	$id = $_GET[xid];
}else{
	$id = $id;
}

$getidcard = $_SESSION[idoffice] ;
$save_to_file = 1; //@20/7/2550 เก็บรูปลงไฟล์

//				echo "ขณะนี้โปรแกรมเมอร์ กำลังตรวจสอบโปรแกรม ไม่ได้เกิดปัญหาใด ท่านสามารถทำการบันทึกได้ปกติ";
//				echo "<pre>";
//				print_r($_SESSION);
//				echo "<hr>";
function CheckIDCard($StrID){
    if(strlen($StrID)==13){
    $id=str_split($StrID); 
    $sum=0;    
    for($i=0; $i < 12; $i++){
         $sum += floatval($id[$i])*(13-$i); 
    }   
    if((11-$sum%11)%10!=floatval($id[12])){
         return false;
    }else{
         return true; 
    }
}else{
    return false;
}   
}


function checkID($id) {
				if(strlen($id) != 13) return false;
				for($i=0, $sum=0; $i<12;$i++)
				$sum += (int)($id{$i})*(13-$i);
				if((11-($sum%11))%10 == (int)($id{12}))
				return true;
				return false;
}

### comment ไว้เนื่องจากการบันทึกข้อมูลของเขต มีเลขบัตรที่ไม่สมบูรณ์อยู่ด้วย
if(isset($getidcard)) { 
	//if( (!checkID($getidcard)) AND (substr($_SERVER["REMOTE_ADDR"],0,8) != "192.168.") ){
	if( (!CheckIDCard($getidcard)) AND (substr($_SERVER["REMOTE_ADDR"],0,8) != "192.168.") ){
			echo "
					<script language=\"javascript\">
							alert(\" รหัสบัตรประชาชนของท่านไม่ตรงตามโครงสร้างของกรมการปกครอง \\n อาจเกิดจากการลงทะเบียนหรือการนำข้อมูลเข้า\\n กรุณาติดต่อ Callcenter  เพื่อให้แก้ไขก่อนจึงจะสามารถใช้งานระบบได้\");
							top.location.href=\"$mainwebsite\";
					</script>";
			exit;
	}
}  

############  ตรวจสอบข้อมูลในเขตว่ามีจริงมั้ย
$sql_check_general = "SELECT COUNT(id) AS num_g FROM general WHERE id='$id'";
$result_check_general = mysql_db_query($dbname,$sql_check_general);
$rs_cg = mysql_fetch_assoc($result_check_general);
	if($rs_cg[num_g] < 1){ // แสดง่ว่ามีข้อมูลใน view_general จากการค้นหาแต่ไม่พอข้อมูลใน เขต
			echo "
					<script language=\"javascript\">
							alert(\" ไม่พบข้อมูลนี้ในระบบเนื่องจากการค้นหาก่อนเข้ามาบันทึกข้อมูล ข้อมูลที่ท่านพบเกิดจากข้อมูลเก่าค้างในข้อมูลภาพรวม \\n กรุณาติดต่อทีมโปรแกรมเมอร์เพื่อปรับข้อมูล\");
							top.location.href=\"$mainwebsite\";
					</script>";
			exit;
	}

$sql_view="SELECT *,CZ_ID as id FROM view_general where CZ_ID='$id' ";
$qry=mysql_db_query($db_name,$sql_view)or die ("error");
$rsv=mysql_fetch_assoc($qry);

$sql_general="SELECT * FROM general where id='$id' ";
$query_general=mysql_db_query($db_name,$sql_general)or die("CANNOT QUERY".mysql_error());
$arr_general=mysql_fetch_assoc($query_general);
//echo "$sql_general <hr> $db_name";
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


### script เช็ค ประวัติชื่อที่จะออก ก.พ. 7 ================  by suwat ==============================
		## ชื่อมารดา
				$select2_mo="select * from hr_addhistorymothername where gen_id='$id'";
				$result2_mo=@mysql_db_query($db_name,$select2_mo);
				$num_row2_mo=@mysql_num_rows($result2_mo);
				
					if($num_row2_mo < 1){
					
						$select3_mo="select mother_prename,mother_name,mother_surname,mother_occ from general where id='$id'";
						$result3_mo = @mysql_db_query($db_name,$select3_mo);
						$rs3_mo = @mysql_fetch_array($result3_mo);
						
						$name_date_mo=date("Y-m-d");
							if($rs3_mo[mother_name] !=""){
							
						$strSQL1_mo="insert into hr_addhistorymothername(gen_id,mother_prename,mother_name,mother_surname,mother_occ,mother_daterec, kp7_active, runno)values('".$id."','".$rs3_mo[mother_prename]."','".$rs3_mo[mother_name]."','".$rs3_mo[mother_surname]."','".$rs3_mo[mother_occ]."','$name_date_mo','1','1')";
							@mysql_db_query($db_name,$strSQL1_mo);
							
							} // end if($rs3_mo[mother_name] !=""){
					
					} // end 	if($num_row2_mo < 1){

		## ชื่อ มารดา

		### คู่สมรส
				
				$select2_ma="select * from hr_addhistorymarry where gen_id='$id'";
				$result2_ma = @mysql_db_query($db_name,$select2_ma);
				$num_row2_ma = @mysql_num_rows($result2_ma);
					if($num_row2_ma < 1){
				$select3_ma="select marry_prename,marry_name,marry_surname,marry_occ from general where id='".$id."'";
						$result3_ma = @mysql_db_query($db_name,$select3_ma);
						$rs3_ma = @mysql_fetch_array($result3_ma);
						$name_date_ma=date("Y");
							if($rs3_ma[marry_name] !=""){
						$strSQL1_ma="insert into hr_addhistorymarry(gen_id,prename_th,name_th,surname_th,marry_occ,daterec, kp7_active, runno)values('".$id."','".$rs3_ma[marry_prename]."','".$rs3_ma[marry_name]."','".$rs3_ma[marry_surname]."','".$rs3_ma[marry_occ]."','$name_date_ma','1','1')";
							@mysql_db_query($db_name,$strSQL1_ma);
							} // end 	if($rs3_ma[marry_name] !=""){
					} // end if($num_row2_ma < 1){

		## end คู่สมรส
		
		##  ชื่อ บิดา
		
				$select2_f="select * from hr_addhistoryfathername where gen_id='".$id."'";
				$result2_f = @mysql_db_query($db_name,$select2_f);
				$num_row2_f = @mysql_num_rows($result2_f);
					if($num_row2_f < 1){
						$select3_f = "select father_prename,father_name,father_surname,father_occ from general where id='".$id."'";
						$result3_f = @mysql_db_query($db_name,$select3_f);
						$rs3_f = @mysql_fetch_array($result3_f);
						$name_date_f=date("Y-m-d");
							if($rs3_f[father_name] !=""){
							
			$strSQL1_f="insert into hr_addhistoryfathername(gen_id,father_prename,father_name,father_surname,father_occ,father_daterec, kp7_active, runno)values('".$id."','".$rs3_f[father_prename]."','".$rs3_f[father_name]."','".$rs3_f[father_surname]."','".$rs3_f[father_occ]."','$name_date_f','1','1')";
						
							@mysql_db_query($db_name,$strSQL1_f);
							} // end if($rs3_f[father_name] !=""){
					
					} // end 	if($num_row2_f < 1){

		## end ชื่อบิดา
		
		
		## ชื่อ  ตัว
		
				$select2="select * from hr_addhistoryname where gen_id='".$id."'";
//				echo "ขณะนี้โปรแกรมเมอร์ กำลังตรวจสอบโปรแกรม ไม่ได้เกิดปัญหาใด ท่านสามารถทำการบันทึกได้ปกติ";
//				echo "<hr>";
//				echo $select2."<hr>";
				$result2 = @mysql_db_query($db_name,$select2);
				$num_row2 = @mysql_num_rows($result2);
				//echo $num_row2."<hr>";
					if($num_row2 < 1){
					
						$select3="select prename_th,prename_en,name_th,name_en,surname_th,surname_en from general where id='".$id."'";
						$result3=mysql_db_query($db_name,$select3);
						$rs3=mysql_fetch_array($result3);
						$name_date=date("Y-m-d");
						
							if($rs3[name_th] !=""){
							
						$strSQL1="insert into hr_addhistoryname(gen_id,prename_th,name_th,surname_th,prename_en,name_en,surname_en,daterec, kp7_active, runno)values('".$id."','".$rs3[prename_th]."','".$rs3[name_th]."','".$rs3[surname_th]."','".$rs3[prename_en]."','".$rs3[name_en]."','".$rs3[surname_en]."','$name_date','1','1')";

							@mysql_db_query($db_name,$strSQL1);
							} // end 	if($rs3[name_th] !=""){
					
					} // end 	if($num_row2 < 1){

		## end ชื่อ ตัว
		
		## ส่วนของ ที่อยู่ 
		
				$select2_as="select * from hr_addhistoryaddress where gen_id='".$id."'";
				$result2_as = @mysql_db_query($db_name,$select2_as);
				$num_row2_as = @mysql_num_rows($result2_as);
					if($num_row2_as < 1){
						$select3_as="select contact_add from general where id='".$id."'";
						$result3_as = @mysql_db_query($db_name,$select3_as);
						$rs3_as = @mysql_fetch_array($result3_as);
						$name_date_as=date("Y");
							if($rs3_as[contact_add] !=""){
						$strSQL1_as="insert into hr_addhistoryaddress(gen_id,address,daterec, kp7_active, runno)values('".$id."','".$rs3_as[contact_add]."','$name_date_as','1','1')";
							@mysql_db_query($db_name,$strSQL1_as);
							}
					
					}

		### end ส่วนของที่อยู่
		

### end script เช็คประวัิติชื่อที่จะออก ก.พ. 7=====================================



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
    <td height="35" align="left"  style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#ffffff', EndColorStr='#F4F4F4'); padding: 2px">&nbsp;</td>
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
		<table width="100%" border="0" cellspacing="1" cellpadding="2">
          <tr>
            <td class="style1" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="377" rowspan="2"><font color="#000000">ข้อมูลสำคัญโดยย่อ รายงานจาก view_general </font></td>
                <td width="424" align="right">รหัสประจำตัวประชาชน :
                  <?=$rsv[id];?></td>
              </tr>
              <tr>
                <td align="right">ข้อมูล ณ วันที่
                  <?=MakeDate($arr_salary['date']);?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" align="right" cellpadding="3" cellspacing="1">
              <tr>
                <td width="20%" align="right" valign="top"><strong>ชื่อ - นามสกุล :&nbsp;</strong></td>
                <td colspan="2" valign="top" width="80%"><?=" $rsv[prename_th] $rsv[name_th]   &nbsp;$rsv[surname_th]"?></td>
              </tr>
              <tr>
                <td align="right" valign="top">&nbsp;</td>
                <td colspan="2" valign="top"><? if($rsv[prename_en]!="" and $rsv[name_en]!=""){echo " $rsv[prename_en] $rsv[name_en]   &nbsp;$rsv[surname_en]";}else{}?></td>
              </tr>
			  <?
			   $sql_po="SELECT
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
			  ?>
              <tr>
                <td align="right" valign="top"><strong>ตำแหน่งปัจจุบัน :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?="$rsv[position_now] <strong>ระดับ :&nbsp;</strong>$rsv[radub] (<strong>เลขที่ตำแหน่ง :</strong>$rsv[noposition])";?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>วิทยฐานะ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? 
						if($rsv[vitaya] ==""){
							echo "ยังไม่มีวิทยฐานะ";
						}else {
								$sql_vitaya="select * from vitaya_stat where id='$rsv[id]' ORDER BY date_command DESC";
								 $query_vitaya=mysql_db_query($db_name,$sql_vitaya)or die("cannot query");
								$arr_vitaya=mysql_fetch_assoc($query_vitaya);
								echo "$rsv[position_now]".$rsv[vitaya];					
								$date_start=$arr_vitaya[date_start];
								echo"(<strong>ได้รับเมื่อวันที่ : </strong>".MakeDate($date_start)."<strong> ตามหนังสือ :</strong>".$rsv[remark].")";

						}
								?>
                </td>
              </tr>
              <tr>
                <? 
					$sql_getroyal = "SELECT * FROM getroyal WHERE id='$rsv[id]' ORDER BY orderid DESC LIMIT 0,1";
					$result_getroyal = mysql_db_query($dbname,$sql_getroyal);
					$rs_getroyal = mysql_fetch_assoc($result_getroyal);
			  ?>
                <td align="right" valign="top"><strong>เครื่องราชย์อิสริยาภรณ์ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? if($rs_getroyal[getroyal]=="")
				{
				echo "-";
				}
				else
				{
					echo "$rs_getroyal[getroyal]";
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
													$rs_school="โรงเรียน".$rs_school[office];
													$rssecname=$rs_secname[secname];
											}
										}// end if($rsv[schoolid] ==$_SESSION[secid]){
						
					?>
                <td align="right" valign="top"><strong>หน่วยงาน :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?=$rs_school;?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>สังกัด :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?=$rssecname;?>
                    <br>
                  <?="$rsv[subminis_now] &nbsp;$rsv[minis_now] ";?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>เงินเดือนปัจจุบัน :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?=number_format($rsv[salary])." บาท"." ( ข้อมูล ณ วันที่ ".MakeDate($arr_salary['date'])." ) ";?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>วันเดือนปีเกิด :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? 
									 		echo MakeDate($rsv[birthday]);?>
                    <? $diff  = dateLength($rsv[birthday]);
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
                <td align="right" valign="top"><strong>วันเริ่มปฏิบัติราชการ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? echo MakeDate($rsv[begindate]);?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>วันสั่งบรรจุ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? echo  MakeDate($rsv[startdate]); ?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>วันครบเกษียณอายุ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?=retireDate($rsv[birthday])?></td>
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
                <td align="right" valign="top"><strong>หลักสูตรการฝึกอบรมล่าสุด : </strong></td>
                <td colspan="2" valign="top"><?
					$sql_seminar = "SELECT * FROM seminar WHERE id='$rsv[id]' ORDER BY runno DESC LIMIT 0,1";
					$result_seminar = mysql_db_query($dbname,$sql_seminar);
					$rs_seminar = mysql_fetch_assoc($result_seminar);
					echo "$rs_seminar[subject]";
				?>
                </td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>ความรู้ความสามารถพิเศษ : </strong></td>
                <td colspan="2" valign="top"><?
				$sql_specail = "SELECT * FROM special WHERE id='$rsv[id]' ";
				$result_specail = mysql_db_query($dbname,$sql_specail);
				while($rs_sp = mysql_fetch_assoc($result_specail)){
						echo " - $rs_sp[detail]<br>";
				}
					
				?>
                </td>
              </tr>
              <?
			  	$ab_yy = date("Y")+543;
				$yy_gov = ($ab_yy-1)."-10-01";
			  $sql_absent = "SELECT sum(sick) as sum_sick, sum(duty) as sum_duty, sum(vacation) as sum_vacation, sum(late) as sum_late,sum(absent) as sum_absent,  sum(education) as sum_education  FROM hr_absent where id='$rsv[id]' AND yy='$ab_yy'";
			  $result_absent = mysql_db_query($dbname,$sql_absent);
			  $rs_ab = mysql_fetch_assoc($result_absent);
			  ?>
              <tr>
                <td align="right" valign="top"><strong>จำนวนวันลาหยุดปัจจุบัน : <br>
(ข้อมูล ณ วันที่ <?=MakeDate($yy_gov);?>  ถึงปัจจุบัน) </strong></td>
                <td colspan="2" valign="top">ลาป่วย
                  <?=number_format($rs_ab[sum_sick])?>
                  วัน&nbsp; ลากิจและพักผ่อน
                  <?=number_format($rs_ab[sum_duty]+$rs_ab[sum_vacation])?>
                  วัน &nbsp;มาสาย
                  <?=number_format($rs_ab[sum_late])?>
                  วัน&nbsp; ขาดราชการ
                  <?=number_format($rs_ab[sum_absent]);?>
                  วัน&nbsp; ลาศึกษา
                  <?=number_format($rs_ab[sum_education]);?>
                  วัน </td>
              </tr>
              <?
			  	// ประวัติความดี
				$sql_goodman = "SELECT * FROM goodman WHERE id='$rsv[CZ_ID]'";
				$result_goodman = @mysql_db_query($db_name,$sql_goodman);
				$num_goodman = @mysql_num_rows($result_goodman);
				if($num_goodman > 0){ // กรณีมีรายการความดี
			  ?>
              <tr>
                <td align="right" valign="top"><strong><? echo "ประวัติความดีความชอบ";?></strong></td>
                <td colspan="2" valign="top"><?
				while($rs_good = mysql_fetch_assoc($result_goodman)){
						echo " - $rs_good[gaction]<br>";
				}	
				?></td>
              </tr>
              <?
			  	}//end if($num_goodman > 0){ 
			  ?>
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
                <td width="61%" valign="top"><? 
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
                <td align="right" valign="top"><strong>การปฏิบัติราชการพิเศษ: </strong></td>
                <td colspan="2" valign="top"><?
				$sql_hr_specialduty = "SELECT * FROM hr_specialduty WHERE id='$rsv[id]'";
				$result_hr_specialduty = mysql_db_query($dbname,$sql_hr_specialduty);
				while($rs_hsp = mysql_fetch_assoc($result_hr_specialduty)){
						echo " - $rs_hsp[comment]<br>";
				}
					
				?></td>
              </tr>
            </table></td>
          </tr>
        </table>
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

