<?
/*****************************************************************************
Function		: �ͺ���¡�ä�������� �.�.7 ���Ѻ�����
Version			: 1.0
Last Modified	: 22/05/2552
Changes		:
*****************************************************************************/
include("checklist2.inc.php");

?>

<html>
<head>
<title>��������´�ѭ��</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>

</head>
<BODY>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="center" bgcolor="#CCCCCC"><strong>��¡�ûѭ�Ңͧ 
          <?=$fullname?> �Ţ�ѵ� <?=$idcard?>
        �ѧ�Ѵ <?=ShowAreaSortName($xsiteid);?>/<?=$xschoolid;?></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>�ӴѺ</strong></td>
        <td width="23%" align="center" bgcolor="#CCCCCC"><strong>��Ǵ����</strong></td>
        <td width="33%" align="center" bgcolor="#CCCCCC"><strong>��Ǵ�ѭ��</strong></td>
        <td width="40%" align="center" bgcolor="#CCCCCC"><strong>��¡�ûѭ��</strong></td>
      </tr>
      <?
      	$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_problem_detail.problem_id,
tbl_checklist_problem_detail.menu_id,
tbl_checklist_problem_detail.problem_detail
FROM
tbl_checklist_kp7
Left Join tbl_checklist_problem_detail ON tbl_checklist_kp7.idcard = tbl_checklist_problem_detail.idcard
WHERE
tbl_checklist_kp7.profile_id =  '$profile_id' AND
tbl_checklist_kp7.siteid =  '$xsiteid' AND
tbl_checklist_kp7.idcard =  '$idcard' AND
tbl_checklist_problem_detail.menu_id =  '$menu_id'
";
$result = mysql_db_query($dbname_temp,$sql);
$i=0;
while($rs = mysql_fetch_assoc($result)){
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=GetTypeMenu($rs[menu_id])?></td>
        <td align="left"><?=GetTypeProblem($rs[problem_id])?></td>
        <td align="left"><?=$rs[problem_detail]?></td>
      </tr>
      <?
      	}//end 
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</BODY>
</HTML>
