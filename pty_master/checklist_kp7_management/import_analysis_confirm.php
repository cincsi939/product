<?
/**
* @comment �к�����Ң���������
* @projectCode 56EDUBKK01
* @tor 1.2.3 (Opt.)
* @package core(or plugin)
* @author Suwat.K (or ref. by "EDUBKK" path "/com.../....php")
* @access public/private
* @created 05/06/2014
*/
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_j18.php");
include("../../config/cmss_define.php");
include("../../common/transfer_data/function_transfer.php");
include("class/class.compare_data.php");
include("../../common/class.import_checklist2cmss.php");
include("../../common/class.getdata_master.php");
include("class.check_error.php");
include("../../common/class.downloadkp7.php");

$flag_pass = 1; # �Դ�������仡�͹
$obj_kp7 = new downloadkp7();
$pathfile = "../../../".PATH_KP7_FILE."/";

$arr_sex = array("1"=>"���","2"=>"˭ԧ");
$obj_imp = new ImportData2Cmss();
$obj_master = new GetDataMaster();

### ��Ǩ�ͺ�Ţ�ѵ�
$obj_checkdata = new CheckDataError();

if($action == "process"){
	$dateposition_now = "2554-10-01";
	
	
	if(count($arr_id) > 0){
		$int1=0;
		$int2=0;
		$intall=0;
		foreach($arr_id as $key => $val){
		$intall++;
		$sql = "SELECT
		t1.idcard,
		t1.siteid,
		t1.profile_id,
		t2.prename_th,
		t2.name_th,
		t2.surname_th,
		t2.birthday,
		t2.begindate,
		t2.position_now,
		t2.schoolid,
		t2.sex,
		t1.status_transferkey,
		t1.status_keypass,
		t1.flag_insert
		FROM
		queue_transfer AS t1
		Inner Join tbl_checklist_kp7 AS t2 ON t1.idcard = t2.idcard AND t1.siteid = t2.siteid AND t1.profile_id = t2.profile_id
		where t1.siteid='$xsiteid' and t1.profile_id='$profile_id' and t1.flag_process='0' and t1.idcard='$val' ";
		//echo "$sql";die();
		$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."".__LINE__);
		$rs = mysql_fetch_assoc($result);
		$dbsite = STR_PREFIX_DB.$xsiteid;
		
		$age = $obj_checkdata->GetAge($rs[birthday]);
		#$age_gov = $obj_checkdata->GetAge($rs[begindate]);

			if(Check_IDCard($rs[idcard]) or $flag_pass == 1){ // �Ţ�ѵö١��ͧ��������û���ͧ
					if($rs[status_transferkey] == "1"){
						#echo "$rs[idcard] => 0000 => $rs[siteid] => 0000 => $rs[schoolid] => 11 =>Tranfer From 0000 To Cmss<hr>";
							$result_tranfer = transfer_data($rs[idcard],"0000",$rs[siteid],"0000",$rs[schoolid],"11","Tranfer From 0000 To Cmss");// ���¢����Ũҡ cmss 0000
							$obj_imp->UpdateQuery($rs[idcard],$rs[siteid],$profile_id,'1');
							$int1++;
					}else if($rs[flag_insert] == "1"){
						$if=ListCondition_tranfer();
						eval("\$if = \"$if\";");
						//echo $if; die;
						if($if){
						//if($age >= 18 and $age <= 60 and $rs[sex] != "" and $rs[position_now] != "" and ($rs[begindate]!='0000-00-00' and trim($rs[begindate])!='')){
							$pivate_key = gen_pivatekey();
							$arrp1 = GetPrenameId($rs[prename_th]);
							$arrp2 = GetPositionId($rs[position_now]);
							$sql_imp2cmss = "INSERT INTO general SET id='$rs[idcard]',idcard='$rs[idcard]',pivate_key='$pivate_key',position='',blood='',siteid='$rs[siteid]', vitaya_id='0',dateposition_now='$dateposition_now', prename_th='$rs[prename_th]', prename_id='".$arrp1[PN_CODE]."',sex='".$arrp1[sex]."', gender_id='".$arrp1[gender]."', name_th='$rs[name_th]', surname_th='$rs[surname_th]', birthday='$rs[birthday]', begindate='$rs[begindate]', position_now='$rs[position_now]', pid='".$arrp2[pid]."', positiongroup='".$arrp2[Gpid]."', schoolid='$rs[schoolid]' ";	
							#echo "$sql_imp2cmss<hr>";	
							mysql_db_query($dbsite,$sql_imp2cmss) or die(mysql_error()."$sql_imp2cmss<br>LINE__".__LINE__);
							$obj_imp->UpdateQuery($rs[idcard],$rs[siteid],$profile_id,'2');
							$int1++;
						}else{
							$sql_rep = "SELECT
							queue_tranfer_data_similar.idcard_replace as idc,
							queue_tranfer_data_similar.prename_th,
							queue_tranfer_data_similar.name_th,
							queue_tranfer_data_similar.surname_th,
							queue_tranfer_data_similar.position_now,
							queue_tranfer_data_similar.precen_compare
							FROM `queue_tranfer_data_similar`
							WHERE idcard='$rs[idcard]' AND siteid='$rs[siteid]' AND profile_id='$profile_id' order by precen_compare desc limit 1";
							$result_rep = mysql_db_query($dbname_temp,$sql_rep) or die(mysql_error()."".__LINE__);
							$rsr = mysql_fetch_assoc($result_rep);
							$obj_imp->SaveQueueLog($rs[idcard],$rs[siteid],$profile_id,'0000','�����ŵ�駵�� checklist �������ó�','0','0','0',$rsr[idc],$rsr[prename_th],$rsr[name_th],$rsr[surname_th],$rsr[position_now]);
							mysql_db_query($dbname_temp,"DELETE FROM queue_transfer WHERE idcard='$rs[idcard]' AND siteid='$rs[siteid]' AND profile_id='$rs[profile_id]'");	
							$int2++;
						}//end if($age >= 18 and $age <= 60){
					}
					
					
			}else{
											$sql_rep = "SELECT
queue_tranfer_data_similar.idcard_replace as idc,
queue_tranfer_data_similar.prename_th,
queue_tranfer_data_similar.name_th,
queue_tranfer_data_similar.surname_th,
queue_tranfer_data_similar.position_now,
queue_tranfer_data_similar.precen_compare
FROM `queue_tranfer_data_similar`
WHERE idcard='$rs[idcard]' AND siteid='$rs[siteid]' AND profile_id='$profile_id' order by precen_compare desc limit 1";
	$result_rep = mysql_db_query($dbname_temp,$sql_rep) or die(mysql_error()."".__LINE__);
	$rsr = mysql_fetch_assoc($result_rep);
							$obj_imp->SaveQueueLog($rs[idcard],$rs[siteid],$profile_id,'0000','�������Ţ��Шӵ�ǻ�ЪҪ����١��ͧ','0','0','9',$rsr[idc],$rsr[prename_th],$rsr[name_th],$rsr[surname_th],$rsr[position_now]);
				
				mysql_db_query($dbname_temp,"DELETE FROM queue_transfer WHERE idcard='$rs[idcard]' AND siteid='$rs[siteid]' AND profile_id='$rs[profile_id]'");
				$int2++;
			}//end if(Check_IDCard($rs[idcard])){
			
	}//end foreach(){
			echo "<script>alert(\"�����ŷ����� $intall ��¡�� ����ö�����ż��� $int1 ��¡�� �������ö�����ż��� $int2 ��¡��\");location.href='report_analysis.php?xsiteid=$xsiteid&profile_id=$profile_id';</script>";	exit;
	}//end  if(count($arr_id) > 0)
		
}//end if($action == "process"){
	#die();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>�к���Ǩ�ͺ�͡��� �.�.7 �鹩�Ѻ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">
//	function copyit(theField) {
//		var selectedText = document.selection;
//		if (selectedText.type == 'Text') {
//			var newRange = selectedText.createRange();
//			theField.focus();
//			theField.value = newRange.text;
//		} else {
//			alert('select a text in the page and then press this button');
//		}
//	}
</script>
<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<style>
.txthead{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtexsum{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtdate{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000; 
}
.txtdata{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #000; 
}
.txt_link a:link {
	FONT-SIZE: 12px;
	color: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:visited {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:active {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline;FONT-WEIGHT: bold;
}
.fillcolor_headgraph{	
	padding: 2pt;
	background-color:#0063C9;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#0063C9', EndColorStr='#000467');
}
.fillcolor_headgraph2{	
	padding: 2pt;
	background-color:#E6E6E6;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#E6E6E6', EndColorStr='#8E8E8E');
	font-weight:bold;
}
</style>
<script language="javascript">
		function CheckAll(chk){
			for (i = 0; i < chk.length; i++)
			chk[i].checked = true ;
		}
		
		function UnCheckAll(chk){
			for (i = 0; i < chk.length; i++)
			chk[i].checked = false ;
		}
</script>
</head>
<body>
<form name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="11" align="left" bgcolor="#CCCCCC"><strong><a href="import_analysis.php?xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>">��Ѻ˹����ѡ</a> ||��§ҹ�����Ţ���Ҫ��ä����кؤ�ҡ÷ҧ����֡�ҷ����������Ң����� Cmss ���ͺѹ�֡������</strong></td>
          </tr>
        <tr>
          <td width="3%" align="center" bgcolor="#CCCCCC"><strong>�ӴѺ</strong></td>
          <td width="9%" align="center" bgcolor="#CCCCCC"><strong>�Ţ��Шӵ�ǻ�ЪҪ�</strong></td>
          <td width="8%" align="center" bgcolor="#CCCCCC"><strong>���� ���ʡ��</strong></td>
          <td width="8%" align="center" bgcolor="#CCCCCC"><strong>�ѹ��͹���Դ</strong></td>
          <td width="8%" align="center" bgcolor="#CCCCCC"><strong>�ѹ�������Ժѵ�<br>
            �Ҫ���</strong></td>
          <td width="12%" align="center" bgcolor="#CCCCCC"><strong>���˹�</strong></td>
          <td width="4%" align="center" bgcolor="#CCCCCC"><strong>��</strong></td>
          <td width="8%" align="center" bgcolor="#CCCCCC"><strong>˹��§ҹ�ѧ�Ѵ</strong></td>
          <td width="7%" align="center" bgcolor="#CCCCCC"><strong>�����˵�</strong></td>
          <td width="23%" align="center" bgcolor="#CCCCCC"><strong>��¡�â����ŷ�����¡ѹ</strong></td>
          <td width="10%" align="center" bgcolor="#CCCCCC"><input  type="button" value="Check" onclick="CheckAll(document.form1.n)" /> <input  type="button" value="UnCheck" onclick="UnCheckAll(document.form1.n)" /></td>
        </tr>
        <?
        	$sql = "SELECT
t1.idcard,
t1.siteid,
t1.profile_id,
t2.prename_th,
t2.name_th,
t2.surname_th,
t2.birthday,
t2.begindate,
t2.position_now,
t2.schoolid,
t2.sex,
t1.status_transferkey,
t1.status_keypass,
t1.flag_insert,
if(count(t3.idcard) > 0,1,0) as name_replace
FROM
queue_transfer AS t1
Inner Join tbl_checklist_kp7 AS t2 ON t1.idcard = t2.idcard AND t1.siteid = t2.siteid AND t1.profile_id = t2.profile_id
Left Join queue_tranfer_data_similar as t3 On t1.idcard=t3.idcard AND t1.siteid=t3.siteid AND t1.profile_id=t3.profile_id
where t1.siteid='$xsiteid' and t1.profile_id='$profile_id' and t1.flag_process='0'
group by t1.idcard
";

	if($_GET['debug']=='on'){ echo $sql; die;}
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."".__LINE__);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
		 if ($i++ % 2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}	
		 if($rs[status_transferkey] == "1"){
			$msg_comment = "<font color=\"#990000\">���¢����Ũҡ�ҹ��ҧ������ cmss<font>";	 
			$file_site = "0000";
		}else if($rs[flag_insert] == "1"){
			$msg_comment = "<font color=\"#006600\">��������������к� cmss</font>";
			$file_site = $xsiteid;
		}else{
			$msg_comment = "";
			$file_site = $xsiteid;
		}
	
		 
		?>
        <tr bgcolor="<?=$bg1?>">
          <td align="center"><?=$i?></td>
          <td align="center"><?=$rs[idcard]?></td>
          <td align="left"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
          <td align="center"><? echo thai_dateS($rs[birthday]);?></td>
          <td align="center"><? echo thai_dateS($rs[begindate]);?></td>
          <td align="left"><? echo $rs[position_now]?></td>
          <td align="center"><? echo $arr_sex[$rs[sex]]?></td>
          <td align="left"><? echo $obj_master->GetSchool($rs[schoolid]);?></td>
          <td align="left"><? echo $msg_comment;?></td>
          <td align="center">
          <? if($rs[name_replace] > 0){?>
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td align="center" bgcolor="#CCCCCC"><strong>�Ţ�ѵ��</strong></td>
              <td align="center" bgcolor="#CCCCCC"><strong>���� ���ʡ��</strong></td>
              <td align="center" bgcolor="#CCCCCC"><strong>Ǵ� �Դ</strong></td>
              <td align="center" bgcolor="#CCCCCC"><strong>Ǵ� ��Ժѵ�</strong></td>
              <td align="center" bgcolor="#CCCCCC"><strong>���˹�</strong></td>
              <td align="center" bgcolor="#CCCCCC"><strong>%</strong></td>
            </tr>
            <?
            	$sql_similar = "SELECT
t1.runid,
t1.idcard,
t1.siteid,
t1.profile_id,
t1.idcard_replace,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t1.schoolid,
t1.begindate,
t1.birthday,
t1.precen_compare,
t1.timeupdate
FROM
queue_tranfer_data_similar AS t1 WHERE t1.idcard='$rs[idcard]' AND t1.siteid='$xsiteid' AND t1.profile_id='$profile_id'";
				$result_r = mysql_db_query($dbname_temp,$sql_similar) or die(mysql_error()."".__LINE__);
				while($rsr = mysql_fetch_assoc($result_r)){
			?>
            <tr>
              <td align="left" bgcolor="#FFCC00"><? echo "$rsr[idcard_replace]";?></td>
              <td align="left" bgcolor="#FFCC00"><? echo "$rsr[prename_th]$rsr[name_th] $rsr[surname_th]";?></td>
              <td align="left" bgcolor="#FFCC00"><? echo thai_dateS($rsr[birthday]);?></td>
              <td align="left" bgcolor="#FFCC00"><? echo thai_dateS($rsr[begindate]);?></td>
              <td align="left" bgcolor="#FFCC00"><? echo $rsr[position_now];?></td>
              <td align="left" bgcolor="#FFCC00"><? echo "$rsr[precen_compare]";?><?=$obj_kp7->get_pdforg($pathfile,$rsr[siteid],$rsr[idcard_replace]);?></td>
            </tr>
            <?
				}//end 
			?>
          </table>
          <?
		  }else{
				echo " - ��辺��¡�ë�� - "; 	 
		  }//edn if($rs[name_replace] > 0)
		  ?>
          </td>
          <td align="center"><?=$obj_kp7->get_pdforg($pathfile,$file_site,$rs[idcard]);?>&nbsp;<input type="checkbox" name="arr_id[<?=$rs[idcard]?>]" id="n" value="<?=$rs[idcard]?>">
          </td>
        </tr>
        <?
	}//end while($rs = mysql_fetch_assoc($result)){ 
		?>
           <tr>
          <td colspan="10" align="center" bgcolor="#CCCCCC">&nbsp;</td>
          <td align="center" bgcolor="#CCCCCC">
          <input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
          <input type="hidden" name="profile_id" value="<?=$profile_id?>">
          <input type="hidden" name="action" value="process">
          <input type="submit" name="button" id="button" value="�����żŢ�������� cmss" height="50">
          </td>
        </tr>
           <tr>
             <td colspan="10" align="center" bgcolor="#CCCCCC">&nbsp;</td>
             <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
           </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
