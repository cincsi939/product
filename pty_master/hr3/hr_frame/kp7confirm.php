<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_approve";
$module_code 		= "approve"; 
$process_id			= "approve";
$VERSION 				= "9.1";
$BypassAPP 			= true;
#########################################################
#Developer 	:: 
#DateCreate	::17/07/2007
#LastUpdate	::17/07/2007
#DatabaseTabel::
#END
#########################################################
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();


if($_SERVER['REQUEST_METHOD'] == "POST"){

//Check bday and IdCard of Personnel
	$sql 		= "select id, idcard, birthday, unit from general where idcard='$idcard' and id='$id';";
	$result 	= mysql_query($sql)or die("Line". __LINE__ .mysql_error());
if(mysql_num_rows($result) >= 1){
	while ($rs=mysql_fetch_assoc($result)){	
	
		$yy 			= substr($rs[birthday],0,4);
		$mm			= substr($rs[birthday],5,2);
		$dd 			= substr($rs[birthday],8,2);
		$birthday 	= "$dd$mm$yy";
		if(($idcard != $rs[idcard]) && ($bday !=$birthday)){	
		
			echo "
				<script language=\"javascript\">
				alert(\"�������ѹ�Դ ���� ���ʻ�ЪҪ��ͧ��ҹ���١��ͧ\");			
				</script>
				<meta http-equiv='refresh' content='0;url=?id=".$id."'>
				";			
			exit;
				
		}		
	}
	mysql_free_result($result);
} else {
	echo "
		<script language=\"javascript\">
		alert(\"�������ѹ�Դ ���� ���ʻ�ЪҪ��ͧ��ҹ���١��ͧ\");			
		</script>
		<meta http-equiv='refresh' content='0;url=?id=".$id."'>
		";			
	exit;
}	

$timestamp 	= date("Y-m-d H:i:s");
$ip				= get_real_ip();

//@10/8/2550
$sql = " select * from `general`  WHERE (`id`='$id')   " ; 
$result = mysql_query($sql) ;
$xrs = mysql_fetch_assoc($result);
$unit = $xrs[unit];
$beginwork=$xrs[begindate];
$endwork=2549;
$dy=explode("-",$beginwork);
$startdaywork=$xrs[startdate];
$sdy=explode("-",$startdaywork);
$sumwork=($endwork+1)-$dy[0];
$sqlabsent="SELECT Count(hr_absent.yy)as ABDAY FROM hr_absent WHERE hr_absent.id =  '$id' AND `yy` BETWEEN '$dy[0]' AND '2549' ";
$resultabsent = mysql_query($sqlabsent) ;
$rsab=mysql_fetch_assoc($resultabsent);
$sumab=$rsab[ABDAY];
if($sumwork !=$sumab)
{
	for($i=$dy[0];$i<=2549;$i++)//�һշ���͡���������ú
	{
	$arr1[]=$i;
	}
		$sqlfindyy="SELECT yy from  hr_absent where id='$id' AND `yy` BETWEEN '$dy[0]' AND '2549' order by yy ASC";
		$queryfindyy = mysql_query($sqlfindyy) ;
	while($XX=mysql_fetch_assoc($queryfindyy))
	{
		$arr2[]=$XX[yy];
	}
for($i = 0; $i < sizeof($arr1); $i++){

for($j = 0; $j < sizeof($arr2); $j++)
	{ 
			if($arr1[$i] != $arr2[$j]){ 
			$isSame = false;
			}else{
			$isSame = true;
			break;
			} 
	}//for($j = 0; $j < sizeof($arr2); $j++)
	
	if($isSame == false){
	$msgshow11 .= "\\n -  �� �.�. $arr1[$i]  ";
		// echo $arr1[$i]." ";
		}
	}//for($i = 0; $i < sizeof($arr1); $i++){
}




$sql2 = " select  id  from  general_pic   WHERE (`id`='$id')   " ; 
$result2 = mysql_query($sql2) ;
$numrows_pic = mysql_num_rows($result2);

$sqlsa="SELECT count(runid) AS suma FROM `salary` WHERE `id` LIKE '%$id%' AND `date` BETWEEN '2544' AND '2551' ";
$resultsa = mysql_query($sqlsa) ;
$rssa=mysql_fetch_assoc($resultsa);

$sql_gra="SELECT Count(graduate.runid)AS GRA FROM graduate WHERE graduate.id =  '$id'";
$resultgra = mysql_query($sql_gra) ;
$rsgra=mysql_fetch_assoc($resultgra);
$sumgra=$rsgra[GRA];



// ��Ǩ�ͺ������㹿�Ŵ�ѧ�Ѻ��͹�Ѻ�ͧ
$msgshow = "";
// �ӹ�˹��
if($xrs[prename_th]=="" OR $xrs[prename_th]== null){
	$msgshow = "\\n - ����кؤӹ�˹��";
}
// ����
if($xrs[name_th]=="" OR $xrs[name_th]== null){
	$msgshow .= "\\n - ����кت���";
}
// ���ʡ��
if($xrs[surname_th]=="" OR $xrs[surname_th]== null){
	$msgshow .= "\\n - ����кع��ʡ��";
}
// ��
if($xrs[sex]=="" OR $xrs[sex]== null){
	$msgshow .= "\\n - ����к���";
}
// ���˹������
if($xrs[position]=="" OR $xrs[position]== null){
	$msgshow .= "\\n - ����кص��˹�������Ѻ�Ҫ���";
}
// �дѺ������Ѻ�Ҫ���
if($xrs[radub_past]=="" OR $xrs[radub_past]== null){
	$msgshow .= "\\n - ����к��дѺ������Ѻ�Ҫ���";
}
// ���˹觻Ѩ��Ѻѹ
if($xrs[position_now]=="" OR $xrs[position_now]== null){
	$msgshow .= "\\n - ����кص��˹觻Ѩ��Ѻѹ";
}
// �дѺ�Ѩ��Ѻѹ
if($xrs[radub]=="" OR $xrs[radub]== null){
	$msgshow .= "\\n - ����к��дѺ�Ѩ��Ѻѹ ��سҺѹ�֡���������Ǵ���˹�����ѵ���Թ��͹";
}
// �дѺ�Ѩ��Ѻѹ
if($numrows_pic < 1){
	$msgshow .= "\\n - ������ٻ����";
}

//�������ѹ�����ú����ӹǹ�յ����������ӧҹ - �� 49
//if($sumwork !=$sumab)
//{
////$msgshow .= $msgshow11."\\n��͡�������ѹ�����ú";
//}
// �������Թ��͹ �� 2544 - 2549 ���¡��� 14 ��
if($rssa[suma] < 14 and $sdy[0]<2544)
{
$msgshow .= "\\n - 㹪�ǧ�� �.�. 2544 - �.�. 2549  ��͡�������Թ��͹���ú";	
}
//����֡���繤����ҧ
if($sumgra==0)
{
$msgshow .= "\\n - ����кآ����š���֡��";	
}

if($msgshow != ""){
		echo "<script language=\"javascript\">";
		echo "alert(\"��ҹ�������ö�Ѻ�ͧ�����������ͧ�ҡ \\n $msgshow \\n ��سҵ�Ǩ�ͺ�����Ţͧ��ҹ\");			
		window.close();";
		echo "</script>";
		exit;
}else{

	//If bday and idCard Correct 	
	$upate1	= " insert into log_approve set approve_status='approve', general_id='$id', userip='$ip', notes='$notes', timestamp='$timestamp' ; ";
	$upate2	= " update general set approve_status='approve',req_notapprove='0' where id='$id'; ";
	$update_log_re_not="update log_req_notapprove set status='0' where general_id='$id' ";
	//$update3  = "update temp_listapprove  set  approve = approve+1 , not_approve = not_approve-1     where id ='$unit' ;";  // ��������� ź �� ��Ѻ�ç������
	$update3  = " replace into temp_listapprove (ampid,id,th_name,approve,not_approve,outside,status_sch) select `t1`.`ampid` AS `ampid`, ";
	$update3  .= " `t1`.`id` AS `id`,`t1`.`office` AS `th_name`,sum(if((`t2`.`approve_status` = _tis620'approve'),1,0)) AS `approve`, ";
	$update3  .= " sum(if((((`t2`.`approve_status` = _tis620'') or isnull(`t2`.`approve_status`)) and (`t2`.`id` is not null)),1,0)) AS `not_approve`, ";
	$update3  .= " sum(if((`t2`.`outside` = _utf8'1'),1,0)) AS `outside`,`t1`.`status_sch` AS `status_sch` from (`login` `t1` left join ";
	$update3  .= "`general` `t2` on((`t1`.`id` = `t2`.`unit`))) where `t2`.`unit`='$unit'  group by `t1`.`ampid`,`t1`.`id`;";  // recalculate
	$result1	= mysql_query($upate1)or die("Line ". __LINE__ ."<br>" .mysql_error());
	$result2	= mysql_query($upate2)or die("Line ". __LINE__ ."<br>" .mysql_error());
	$result3	= mysql_query($update3)or die("Line ". __LINE__ ."<br>" .mysql_error());
	$result_log= mysql_query($update_log_re_not)or die("Line ". __LINE__ ."<br>" .mysql_error());
	add_log("�׹�ѹ������","$id","approve");

	echo "
	<script language=\"javascript\">
	alert(\"�ѹ�֡����׹�ѹ�����Ţͧ��ҹ���º��������\");	
	</script>
	<br><br>
	<div align=\"center\"><button onClick=\"self.close();\">�Դ˹�ҵ�ҧ���</button></div>
	";
	exit;
} // end if ��Ǩ�ͺ�Ѻ�ͧ
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>�к��׹�ѹ������</title>
<script language="javascript">
function check(){
	
if(confirm("��ҹ��ͧ����׹�ѹ�����١��ͧ�ͧ������ ��������� ?")){	
	if(document.post.bday.value.length==0){
		alert("�кآ������ѹ ��͹ ���Դ");
		document.post.bday.focus();
		return false;
	} else if(document.post.idcard.value.length==0) {
		alert("�кآ����źѵû�ЪҪ�");
		document.post.idcard.focus();
		return false;
	} else {		
		return true;
	}
} else {
		return false;
}	
}
</script>
<link href="../hr_report/hr.css" rel="stylesheet" type="text/css" />
</head>
<body topmargin="0" leftmargin="0">
<table width="500" border="0" cellspacing="0" cellpadding="0">
<tr align="center">
    <td height="200"><br />
<b>��سҺѹ�֡ �ѹ ��͹ ���Դ ������ʺѵû�ЪҪ��ͧ��ҹ�ա���� <br /> �����׹�ѹ �����١��ͧ�ͧ�����ż�ҹ�к�</b><br />
<br />
<form name="post" method="post" action="<?=$PHP_SELF?>" onsubmit="return check();">	
<input type="hidden" name="id" value="<?=$id?>" />
<table width="400" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
<tr align="center" bgcolor="#ffffff">
    <td height="25" colspan="2">&nbsp;</td>
</tr>
<tr bgcolor="#ffffff">
    <td width="150" height="25" align="right">�ѹ��͹���Դ&nbsp;<b>:</b>&nbsp;</td>
    <td width="250"><input type="text" name="bday" maxlength="8" style="width:200px;" /></td>
</tr>
<tr bgcolor="#ffffff">
    <td height="25" align="right">���ʺѵû�ЪҪ�&nbsp;<b>:</b>&nbsp;</td>
    <td><input type="text" name="idcard" maxlength="13" style="width:200px;" /></td>
</tr>
<tr align="center" bgcolor="#ffffff">
    <td height="35" colspan="2"><input type="submit" value="��ŧ" style="width:60px;" />
      &nbsp;
      <input name="submit" type="submit" value="¡��ԡ" onclick="self.close();" style="width:60px;" /></td>
</tr>
</table>
</form>
	</td>
</tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>