<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Tanachai Khampukhew (tanachai@sapphire.co.th)
 * @created  10/09/2014
 * @access  public
 */
 ?>
<?php
	$ws_client = $con->configIPSoap();
	$calendar = array('file' => 'calendar');
	echo $ws_client->call('includefile', $calendar);
	$para = array(
		'dateFormat' => 'dd/mm/yy',
		'inputname' => 'v392',
		'showicon' => false,
		'showOtherMonths' => true,
		'showButton' => false,
		'showchangeMonth' => true,
		'numberOfMonths' => 1,
		'format' => 'tis-620',
		'value'=>'',
		'showWeek' => false);	
	$result = $ws_client->call('calendar', $para); 
	
	$con->connectDB();
	$sql = "SELECT educ_id,education,level FROM eq_member_education";
	$education = $con->select($sql);
	
	$sql = "SELECT id,r_name FROM tbl_relation";
	$relation = $con->select($sql);
?>
<form id="form1" name="form1" method="post" action="../main_exc/form2_add_exc.php" onSubmit="JavaScript:return fncSubmit();">
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <thead>
        <tr>
          <th colspan="4" align="center">&nbsp;</th>
        </tr>
        <tr>
          <th height="24" colspan="4" align="center" bgcolor="#f2f2f2">��������ǹ��� (��������Ǫ� ���� 19-25 ��)</th>
        </tr>
        <tr>
          <th colspan="4" align="center" ><table width="100%" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="11%">�Ţ�ѵû�ЪҪ�</td>
              <td width="29%"><input type="text" value="" name="v196" id="tIDCard"  style="width:120px"  />
                <span  id="idClassCheck" class="bIdCard">��Ǩ�ͺ</span> <span  id="random2" class="bIdCard">�����Ţ�ѵ�
                  <input  name="pin" type="hidden" id="pin" value="<?php echo $_GET['id']; ?>"  />
                <input  name="eq_type" type="hidden" id="eq_type" value="2"  />
                </span></td>
              <td width="6%">����-ʡ��</td>
              <td width="54%"><select id="v400" name="v400"  style="width:120px"  >
                <option value="">�ô�к�</option>
                <?php
				$sql_Prename = 'SELECT id,prename_th,gender FROM `tbl_prename` ORDER BY priority asc;';
				$results_Prename = $con->select($sql_Prename);
				foreach($results_Prename as $rd){
						echo '<option  value="'.$rd['id'].'">'.$rd['prename_th'].'</option>';
				}
			 ?>
              </select>
                <input type="text" value="" name="v194" id="tName"  style="width:120px"  />
                ���ʡ��
                <input type="text" value="" name="v388" id="v388"  style="width:120px"  /></td>
            </tr>
            <tr>
              <td>��</td>
              <td><!--<input type="text" value=""  style=" width:10%"  />--><LABEL id="lblPreName">
                <input name="v396" type="radio"  class="rSex" id="female"  value="1"  />
                1. ˭ԧ&nbsp;
                <input type="radio"  value="2" class="rSex" name="v396"  id="male" />
                2. ���
                <INPUT name="chkSex" type="hidden" id="tSex" value="1" size="30" /></LABEL></td>
              <td>�ѹ�Դ</td>
              <td><?php echo $result; ?> ����
                <input name="v195" type="text"  value="" size="3" id="v195"  /></td>
            </tr>
            <tr>
              <td>��������ѹ���ͺ����</td>
              <td><select name="v197" style="width:120px">
                <option value="">�ô�к�</option>
                <?php
foreach($relation as $rd){
	echo '<option value="'.$rd['id'].'">'.$rd['r_name'].'</option>';
}
?>
              </select></td>
              <td>����֡��</td>
              <td><select name="v198" style="width:120px">
                <option value="">�ô�к�</option>
                <?php
foreach($education as $rd){
	echo '<option value="'.$rd['educ_id'].'">'.$rd['education'].'</option>';
}
?>
              </select></td>
            </tr>
          </table></th>
        </tr>
        <tr>
          <td height="24" colspan="4" align="center" bgcolor="#f2f2f2"><strong>ʶҹ�ѭ��</strong></td>
        </tr>
      </thead>
      <tr>
        <td width="25%" valign="middle"><input type="checkbox" name="v199" id="checkbox" value="1">
1. ������֡��<br></td>
        <td width="25%" valign="middle"><input type="checkbox" name="v205" id="checkbox2" value="7">
7. �Դ�Һ��</td>
        <td width="25%" valign="middle"><input type="checkbox" name="v211" id="checkbox3" value="13">
13. �Դ���� HIV</td>
        <td width="25%" valign="middle"><input type="checkbox" name="v217" id="checkbox119" value="19">
19. ���ä��Шӵ��          
        �к� 
  <input type="text" value="" name="v218"  style=" width:30%"  /></td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v200" id="checkbox5" value="2">
2. ����էҹ��</td>
        <td valign="middle"><input type="checkbox" name="v206" id="checkbox6" value="8">
8. �Դ����</td>
        <td valign="middle"><input type="checkbox" name="v212" id="checkbox7" value="14">
14. ���Ѻ�š�з��ҡ HIV</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v201" id="checkbox9" value="3">
3. �١����Դ�ҧ��</td>
        <td valign="middle"><input type="checkbox" name="v207" id="checkbox10" value="9">
9. �Դ����</td>
        <td valign="middle"><input type="checkbox" name="v213" id="checkbox11" value="15">
15. �Դ�/��ô����ª��Ե</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v202" id="checkbox12" value="4">
4. �١��������ҧ�����ШԵ�</td>
        <td valign="middle"><input type="checkbox" name="v208" id="checkbox15" value="10">
10. ��蹡�þ�ѹ</td>
        <td valign="middle"><input type="checkbox" name="v214" id="checkbox116" value="16">
16. �Դ�/��ôҵ�ͧ�ɨӤء</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v203" id="checkbox14" value="5">
5. ��������ͧ�����������š�����</td>
        <td valign="middle"><input type="checkbox" name="v209" id="checkbox16" value="11">
11. �վĵԡ����ҧ���§ູ�ҧ��</td>
        <td valign="middle"><input type="checkbox" name="v215" id="checkbox117" value="17">
17. �Դ�/��ôҷʹ���</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v204" id="checkbox13" value="6">
6. �ٺ������</td>
        <td valign="middle"><input type="checkbox" name="v210" id="checkbox17" value="12">
12. ����ѭ�ҵ�</td>
        <td valign="middle"><input type="checkbox" name="v216" id="checkbox118" value="18">
18. ������</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td height="24" colspan="4" align="center" valign="middle" bgcolor="#f2f2f2"><strong>������������ͷ���ͧ���</strong></td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v219" id="checkbox4" value="1">
1. ��������й�</td>
        <td valign="top"><input type="checkbox" name="v222" id="checkbox19" value="4">
4. ����ͧ�������</td>
        <td valign="top"><input type="checkbox" name="v225" id="checkbox22" value="7">
7. ��������㹡���Թ�ҧ�ѡ�Ҿ�Һ��</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v220" id="checkbox8" value="2">
2. �ع��Сͺ</td>
        <td valign="top"><input type="checkbox" name="v223" id="checkbox20" value="5">
5. ���Ѻ��úӺѴ&nbsp;��鹿�</td>
        <td valign="top"><input type="checkbox" name="v226" id="checkbox23" value="8">
8. �Թ��������㹡���ѡ�Ҿ�Һ��</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v221" id="checkbox18" value="3">
3. �Թʧ������</td>
        <td valign="top"><input type="checkbox" name="v224" id="checkbox21" value="6">
6. ��������������� </td>
        <td valign="top"><input type="checkbox" name="v227" id="checkbox24" value="9">
9. �ҧҹ��</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="right" valign="top"><button> �ѹ�֡������ </button>          </td></td>
        <td valign="top">&nbsp;</td>
      </tr>
  </table>
    </form>