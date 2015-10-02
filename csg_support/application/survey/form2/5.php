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
		'inputname' => 'v395',
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
          <th height="24" colspan="4" align="center" bgcolor="#f2f2f2">��������ǹ��� (��������ԡ��)</th>
        </tr>
        <tr>
          <th colspan="4" align="left" ><table width="100%" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="11%">�Ţ�ѵû�ЪҪ�</td>
              <td width="29%"><input type="text" value="" name="v299" id="tIDCard"  style="width:120px"  />
                <span  id="idClassCheck" class="bIdCard">��Ǩ�ͺ</span> <span  id="random2" class="bIdCard">�����Ţ�ѵ�
                  <input  name="pin" type="hidden" id="pin" value="<?php echo $_GET['id']; ?>"  />
                <input  name="eq_type" type="hidden" id="eq_type" value="5"  />
                </span></td>
              <td width="6%">����-ʡ��</td>
              <td width="54%"><select id="v403" name="v403"  style="width:120px"  >
                <option value="">�ô�к�</option>
                <?php
				$sql_Prename = 'SELECT id,prename_th,gender FROM `tbl_prename` ORDER BY priority asc;';
				$results_Prename = $con->select($sql_Prename);
				foreach($results_Prename as $rd){
						echo '<option  value="'.$rd['id'].'">'.$rd['prename_th'].'</option>';
				}
			 ?>
              </select>
                <input type="text" value="" name="v297" id="tName"  style="width:120px"  />
                ���ʡ��
                <input type="text" value="" name="v391" id="v391"  style="width:120px"  /></td>
            </tr>
            <tr>
              <td>��Ҿ�����ԡ��</td>
              <td><input type="text" value="" name="v386"  style="width:120px" /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>��</td>
              <td><!--<input type="text" value=""  style=" width:10%"  />--><LABEL id="lblPreName">
                <input name="v399" type="radio"  class="rSex" id="female"  value="1"  />
                1. ˭ԧ&nbsp;
                <input type="radio"  value="2" class="rSex" name="v399"  id="male" />
                2. ���
                <INPUT name="chkSex" type="hidden" id="tSex" value="1" size="30" /></LABEL></td>
              <td>�ѹ�Դ</td>
              <td><?php echo $result; ?> ����
                <input name="v298" type="text"  value="" size="3" id="v298"  /></td>
            </tr>
            <tr>
              <td>��������ѹ���ͺ����</td>
              <td><select name="v300" style="width:120px">
                <option value="">�ô�к�</option>
                <?php
foreach($relation as $rd){
	echo '<option value="'.$rd['id'].'">'.$rd['r_name'].'</option>';
}
?>
              </select></td>
              <td>����֡��</td>
              <td><select name="v301" style="width:120px">
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
        <td width="25%" valign="middle"><input type="checkbox" name="v302" id="checkbox" value="1">
1. �١����Դ�ҧ��<br></td>
        <td width="25%" valign="middle"><input type="checkbox" name="v307" id="checkbox10" value="6">
6. �Դ��þ�ѹ</td>
        <td width="25%" valign="middle"><input type="checkbox" name="v312" id="checkbox34" value="11">
11. �Ҵ����ػ�ó� </td>
        <td width="25%" valign="middle"><input type="checkbox" name="v317" id="checkbox2" value="16">
16. ������Ѻ�š�к��ҡ�ʹ�� </td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v303" id="checkbox5" value="2">
2. �١��������ҧ�����ШԵ�</td>
        <td valign="middle"><input type="checkbox" name="v308" id="checkbox30" value="7">
7. �ѧ����騴����¹</td>
        <td valign="middle"><input type="checkbox" name="v313" id="checkbox35" value="12">
12.  ����ѭ�ҵ�</td>
        <td valign="middle"><input type="checkbox" name="v318" id="checkbox6" value="17">
17. ������</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v304" id="checkbox9" value="3">
3. �Դ����</td>
        <td valign="middle"><input type="checkbox" name="v309" id="checkbox31" value="8">
8. �١�ʹ���</td>
        <td valign="middle"><input type="checkbox" name="v314" id="checkbox36" value="13">
13. ������Ѻ����͡�͡����Ѻ�ͧ�����ԡ��</td>
        <td valign="middle"><input type="checkbox" name="v319" id="checkbox7" value="18">
18. ���ä��Шӵ��&nbsp;�к�&nbsp;
<input type="text" value=""  style=" width:30%" name="v320"  /></td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v305" id="checkbox12" value="4">
4. �Դ�Һ��</td>
        <td valign="middle"><input type="checkbox" name="v310" id="checkbox32" value="9">
9. ����������������������</td>
        <td valign="middle"><input type="checkbox" name="v315" id="checkbox135" value="14">
14. �ԡ�ë�ӫ�͹</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v306" id="checkbox13" value="5">
5. �Դ����</td>
        <td valign="middle"><input type="checkbox" name="v311" id="checkbox33" value="10">
10. ������Ҫվ</td>
        <td valign="middle"><input type="checkbox" name="v316" id="checkbox3" value="15">
15. ���Դ����HIV/�������ʹ�� </td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td height="24" colspan="4" align="center" valign="top" bgcolor="#f2f2f2"><strong>������������ͷ���ͧ���</strong></td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v321" id="checkbox38" value="1">
1. ��������й�</td>
        <td valign="top"><input type="checkbox" name="v327" id="checkbox45" value="7">
7. ���ʶҹʧ������</td>
        <td valign="top"><input type="checkbox" name="v333" id="checkbox15" value="13">
13. ö�繹��(������)</td>
        <td valign="top"><input type="checkbox" name="v339" id="checkbox4" value="19">
19. ��ͧ��ë����ػ�ó��</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v322" id="checkbox39" value="2">
2. �Թʧ������</td>
        <td valign="top"><input type="checkbox" name="v328" id="checkbox46" value="8">
8. ��ͧ�����������Ԩ������ҧ�㹪����</td>
        <td valign="top"><input type="checkbox" name="v334" id="checkbox16" value="14">
14. ö�������¡</td>
        <td valign="top"><input type="checkbox" name="v340" id="checkbox21" value="20">
20. ����ͧ������</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v323" id="checkbox40" value="3">
3. �Թ�ع��Сͺ�Ҫվ</td>
        <td valign="top"><input type="checkbox" name="v329" id="checkbox136" value="9">
9. �Թ��������㹡���ѡ�Ҿ�Һ��</td>
        <td valign="top"><input type="checkbox" name="v335" id="checkbox17" value="15">
15. �����Ҥ���ѹ</td>
        <td valign="top"><input type="checkbox" name="v341" id="checkbox22" value="21">
21. �������������ٻ</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v324" id="checkbox42" value="4">
4. ��ͧ��ý֡�Ҫվ</td>
        <td valign="top"><input type="checkbox" name="v330" id="checkbox8" value="10">
10. �Թ��������㹡���Թ�ҧ��ѡ�Ҿ�Һ��</td>
        <td valign="top"><input type="checkbox" name="v336" id="checkbox18" value="16">
16. ����ͧ���¿ѧ</td>
        <td valign="top"><input type="checkbox" name="v342" id="checkbox23" value="22">
22. �������������� </td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v325" id="checkbox43" value="5">
5. ������������������ </td>
  <td valign="top"><input type="checkbox" name="v331" id="checkbox11" value="11">
11. �Ѵ��ʶҹ�֡��</td>
        <td valign="top"><input type="checkbox" name="v337" id="checkbox25" value="17">
17. ������</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v326" id="checkbox44" value="6">
6. ����ӹ�¤����дǡ</td>
        <td><input type="checkbox" name="checkbox34" id="v332" value="12">
12. �����ػ�ó����ɷҧ�������      
        <td valign="top"><input type="checkbox" name="v338" id="checkbox20" value="18">
18. ᢹ����</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="right" valign="top"><button> �ѹ�֡������ </button>        </td>
        <td valign="top">&nbsp;</td>
      </tr>
</table>
    </form>