<?
session_start();
set_time_limit(0);
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "genidcard"; 
$process_id			= "checklistkp7_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20100809.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2010-08-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20100809.00
	## Modified Detail :		�к���Ǩ�ͺ�����ŷ���¹����ѵԵ鹩�Ѻ
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################


require_once("../../config/conndb_nonsession.inc.php");
require_once("../../common/lib/Genidcard.php");
$obj = new Genidcard();




	
?>
<html>
<head>
<title>�к���Ǩ�ͺ�͡��� �.�.7 �鹩�Ѻ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
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

</head>
<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><form action="" method="post" enctype="multipart/form-data" name="form1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td width="3%" align="left" bgcolor="#CCCCCC"><strong><img src="../../images_sys/attention.png" alt="" width="32" height="32"></strong></td>
              <td colspan="2" align="left" valign="middle" bgcolor="#CCCCCC"><strong>Ẻ�����㹡�� gen �Ţ�ѵû�ЪҪ�������Ѻ�к�����͹����Թ��͹</strong></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>���͡ࢵ��鹷�����֡�� : </strong></td>
              <td width="71%" align="left" bgcolor="#FFFFFF">
                <select name="txt_siteid" id="txt_siteid">
                <option value="">-- ���͡ࢵ��鹷�����֡��--</option>
                <?
                	$sql = "SELECT secid as siteid,secname_short FROM eduarea WHERE status='1' ORDER BY if(left(secid,1)='0',cast(secid as SIGNED),9999) ASC,secname ASC";
					$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
					while($rs = mysql_fetch_assoc($result)){
						if($txt_siteid == $rs[siteid]){ $sel = " selected='selected' ";}else{ $sel = "";}
						echo "<option value='$rs[siteid]' $sel>$rs[secname_short]</option>";
							
					}// end while($rs = mysql_fetch_assoc($result)){
				?>
                </select>
                </td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>�ӹǹ�Ţ�ѵ� : </strong></td>
              <td align="left" bgcolor="#FFFFFF">
                <select name="num_id" id="num_id">
                <?
                	for($i=1;$i <= 20;$i++){
						if($num_id == $i){ $sel = " selected='selected' ";}else{ $sel = "";}
						echo "<option value='$i' $sel>$i</option>";	
					}
				?>
                </select>
                </td>
            </tr>
            <tr>
              <td colspan="2" align="right" valign="top" bgcolor="#FFFFFF"><strong>�Ţ�ѵ�� ���ͧ���١��ͧ��������û���ͧ : </strong></td>
              <td align="left" bgcolor="#FFFFFF"><? 
	
			  
			  if($txt_siteid != ""){
				  if($num_id < 1){
				 	 $num_id = 1;
				 }
				 for($j = 0; $j < $num_id; $j++){
			   		echo "<font color=\"#006600\">".$obj->genID($txt_siteid)."</font><br>";
				 }
			  }else{
					echo "<font color=\"#FF0000\"> ���͡ࢵ��鹷���������ҧ�Ţ�ѵè��ͧ</font>"; 	 
				}// �Ţ�ѵû�ЪҪ�?></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF">&nbsp;</td>
              <td align="left" bgcolor="#FFFFFF">
                <input type="submit" name="button" id="button" value="���ҧ�Ţ�ѵè��ͧ"></td>
            </tr>
          </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>
