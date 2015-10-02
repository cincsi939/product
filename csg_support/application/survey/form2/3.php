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
		'inputname' => 'v393',
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
    <table width="100%" border="0" cellspacing="3" cellpadding="0">
      <thead>
        <tr>
          <th colspan="4" align="center">&nbsp;</th>
        </tr>
        <tr>
          <th height="24" colspan="4" align="center" bgcolor="#f2f2f2">��������ǹ��� (���������ç�ҹ ���� 25 �բ��� - 60 ��)</th>
        </tr>
        <tr>
          <th colspan="4" align="center" ><table width="100%" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="11%">�Ţ�ѵû�ЪҪ�</td>
              <td width="29%"><input type="text" value="" name="v230" id="tIDCard"  style="width:120px"  />
                <span  id="idClassCheck" class="bIdCard">��Ǩ�ͺ</span> <span  id="random2" class="bIdCard">�����Ţ�ѵ�
                  <input  name="pin" type="hidden" id="pin" value="<?php echo $_GET['id']; ?>"  />
                <input  name="eq_type" type="hidden" id="eq_type" value="3"  />
                </span></td>
              <td width="6%">����-ʡ��</td>
              <td width="54%"><select id="v401" name="v401"  style="width:120px"  >
                <option value="">�ô�к�</option>
                <?php
				$sql_Prename = 'SELECT id,prename_th,gender FROM `tbl_prename` ORDER BY priority asc;';
				$results_Prename = $con->select($sql_Prename);
				foreach($results_Prename as $rd){
						echo '<option  value="'.$rd['id'].'">'.$rd['prename_th'].'</option>';
				}
			 ?>
              </select>
                <input type="text" value="" name="v228" id="tName"  style="width:120px"  />
                ���ʡ��
                <input type="text" value="" name="v389" id="v389"  style="width:120px"  /></td>
            </tr>
            <tr>
              <td>��</td>
              <td><!--<input type="text" value=""  style=" width:10%"  />--><LABEL id="lblPreName">
                <input name="v397" type="radio"  class="rSex" id="female"  value="1"  />
                1. ˭ԧ&nbsp;
                <input type="radio"  value="2" class="rSex" name="v397"  id="male" />
                2. ���
                <INPUT name="chkSex" type="hidden" id="tSex" value="1" size="30" /></LABEL></td>
              <td>�ѹ�Դ</td>
              <td><?php echo $result; ?> ����
                <input name="v229" type="text"  value="" size="3" id="v229"  /></td>
            </tr>
            <tr>
              <td>��������ѹ���ͺ����</td>
              <td><select name="v231" style="width:120px">
                <option value="">�ô�к�</option>
                <?php
foreach($relation as $rd){
	echo '<option value="'.$rd['id'].'">'.$rd['r_name'].'</option>';
}
?>
              </select></td>
              <td>����֡��</td>
              <td><select name="v232" style="width:120px">
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
        <td width="25%" valign="middle"><input type="checkbox" name="v233" id="checkbox" value="1">
1. �١����Դ�ҧ��<br></td>
        <td width="25%" valign="middle"><input type="checkbox" name="v237" id="checkbox10" value="5">
5. �Դ����</td>
        <td width="25%" valign="middle"><input type="checkbox" name="v241" id="checkbox2" value="9">
9. ����էҹ��</td>
        <td width="25%" valign="middle"><input type="checkbox" name="v245" id="checkbox11" value="13">
13. ������</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v234" id="checkbox5" value="2">
2. �١��������ҧ�����ШԵ�</td>
        <td valign="middle"><input type="checkbox" name="v238" id="checkbox15" value="6">
6. �Դ��þ�ѹ</td>
        <td valign="middle"><input type="checkbox" name="v242" id="checkbox3" value="10">
10. �Ҵ�Թ�ع��Сͺ�Ҫվ</td>
        <td valign="middle"><input type="checkbox" name="v246" id="checkbox25" value="14">
14. ���ä��Шӵ��          
        �к�
  <input type="text" value=""  style=" width:30%" name="v247"  /></td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v235" id="checkbox9" value="3">
3. �Դ����</td>
        <td valign="middle"><input type="checkbox" name="v239" id="checkbox13" value="7">
7. ������·���ͧ����§�ٺص���§�Ӿѧ</td>
        <td valign="middle"><input type="checkbox" name="v243" id="checkbox6" value="11">
11. �Դ���� HIV/�����ʹ��</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v236" id="checkbox12" value="4">
4. �Դ�Һ��</td>
        <td valign="middle"><input type="checkbox" name="v240" id="checkbox14" value="8">
8. ����ѭ�ҵ�</td>
        <td valign="middle"><input type="checkbox" name="v244" id="checkbox7" value="12">
12. ���Ѻ�š�з��ҡ HIV</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr align="center">
        <td height="24" colspan="4" valign="middle" bgcolor="#f2f2f2"><strong>������������ͷ���ͧ���</strong></td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v248" id="checkbox4" value="1">
1. ��������й�</td>
        <td valign="top"><input type="checkbox" name="v251" id="checkbox42" value="4">
4. ���������������</td>
        <td valign="top"><input type="checkbox" name="v254" id="checkbox45" value="7">
7. ��ͧ�����������Ԩ������ҧ�㹪����</td>
        <td valign="top"><input type="checkbox" name="v257" id="checkbox8" value="10">
10. ���Ѻ��ä�����ͧ</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v249" id="checkbox39" value="2">
2. �Թʧ������</td>
        <td valign="top"><input type="checkbox" name="v252" id="checkbox43" value="5">
5.  ��ͧ��ý֡�Ҫվ</td>
        <td valign="top"><input type="checkbox" name="v255" id="checkbox17" value="8">
        8. �Թ��������㹡���ѡ�Ҿ�Һ��</td>
        <td valign="top"><input type="checkbox" name="v258" id="checkbox16" value="11">
11. ��������������ͷҧ������</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v250" id="checkbox40" value="3">
3. �Թ�ع��Сͺ�Ҫվ</td>
        <td valign="top"><input type="checkbox" name="v253" id="checkbox44" value="6">
6. ������������</td>
        <td align="left" valign="top"><input type="checkbox" name="v256" id="checkbox136" value="9">
9. �Թ��������㹡���Թ�ҧ��ѡ�Ҿ�Һ��</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="right" valign="top"><button> �ѹ�֡������ </button>          </td></td>
        <td valign="top">&nbsp;</td>
      </tr>
  </table>
    </form>