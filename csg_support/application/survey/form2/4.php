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
		'inputname' => 'v394',
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
          <th height="24" colspan="4" align="center" bgcolor="#f2f2f2">��������ǹ��� (���������٧��� ���� 60 �� ����)</th>
        </tr>
        <tr>
          <th colspan="4" align="left" ><table width="100%" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="11%">�Ţ�ѵû�ЪҪ�</td>
              <td width="29%"><input type="text" value="" name="v261" id="tIDCard"  style="width:120px"  />
                <span  id="idClassCheck" class="bIdCard">��Ǩ�ͺ</span> <span  id="random2" class="bIdCard">�����Ţ�ѵ�
                  <input  name="pin" type="hidden" id="pin" value="<?php echo $_GET['id']; ?>"  />
                <input  name="eq_type" type="hidden" id="eq_type" value="4"  />
                </span></td>
              <td width="6%">����-ʡ��</td>
              <td width="54%"><select id="v402" name="v402"  style="width:120px"  >
                <option value="">�ô�к�</option>
                <?php
				$sql_Prename = 'SELECT id,prename_th,gender FROM `tbl_prename` ORDER BY priority asc;';
				$results_Prename = $con->select($sql_Prename);
				foreach($results_Prename as $rd){
						echo '<option  value="'.$rd['id'].'">'.$rd['prename_th'].'</option>';
				}
			 ?>
              </select>
                <input type="text" value="" name="v259" id="tName"  style="width:120px"  />
                ���ʡ��
                <input type="text" value="" name="v390" id="v390"  style="width:120px"  /></td>
            </tr>
            <tr>
              <td>��</td>
              <td><!--<input type="text" value=""  style=" width:10%"  />--><LABEL id="lblPreName">
                <input name="v398" type="radio"  class="rSex" id="female"  value="1"  />
                1. ˭ԧ&nbsp;
                <input type="radio"  value="2" class="rSex" name="v398"  id="male" />
                2. ���
                <INPUT name="chkSex" type="hidden" id="tSex" value="1" size="30" /></LABEL></td>
              <td>�ѹ�Դ</td>
              <td><?php echo $result; ?> ����
                <input name="v260" type="text"  value="" size="3" id="v260"  /></td>
            </tr>
            <tr>
              <td>��������ѹ���ͺ����</td>
              <td><select name="v262" style="width:120px">
                <option value="">�ô�к�</option>
                <?php
foreach($relation as $rd){
	echo '<option value="'.$rd['id'].'">'.$rd['r_name'].'</option>';
}
?>
              </select></td>
              <td>����֡��</td>
              <td><select name="v263" style="width:120px">
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
          <td height="24" colspan="4" align="center" valign="middle" bgcolor="#f2f2f2"><strong>ʶҹ�ѭ��</strong></td>
        </tr>
      </thead>
      <tr>
        <td width="25%" valign="middle"><input type="checkbox" name="v264" id="checkbox" value="1">
1. �١����Դ�ҧ��<br></td>
        <td width="25%" valign="middle"><input type="checkbox" name="v269" id="checkbox10" value="6">
6. �Դ��þ�ѹ</td>
        <td width="25%" valign="middle"><input type="checkbox" name="v274" id="checkbox3" value="11">
11. ������Ѻ�š�к��ҡ�ʹ�� </td>
        <td width="25%" valign="middle"><input type="checkbox" name="v279" id="checkbox11" value="16">
16. ������������Ӿѧ</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v265" id="checkbox5" value="2">
2. �١��������ҧ�����ШԵ�</td>
        <td valign="middle"><input type="checkbox" name="v270" id="checkbox15" value="7">
7. ����٧���صԴ��ҹ</td>
        <td valign="middle"><input type="checkbox" name="v275" id="checkbox6" value="12">
12.  ����ѭ�ҵ�</td>
        <td valign="middle"><input type="checkbox" name="v280" id="checkbox17" value="17">
17. �Ҵ������ʹ���㹡�ô�ç���Ե</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v266" id="checkbox9" value="3">
3. �Դ����</td>
        <td valign="middle"><input type="checkbox" name="v271" id="checkbox31" value="8">
8. ����٧���ػ���������ѧ/���µԴ��§</td>
        <td valign="middle"><input type="checkbox" name="v276" id="checkbox7" value="13">
13. ����٧���ط���ͧ����§�ٺص���ҹ</td>
        <td valign="middle"><input type="checkbox" name="v281" id="checkbox18" value="18">
18. ������</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v267" id="checkbox12" value="4">
4. �Դ�Һ��</td>
        <td valign="middle"><input type="checkbox" name="v272" id="checkbox32" value="9">
9. ����٧���ط����������ŧ���</td>
        <td valign="middle"><input type="checkbox" name="v277" id="checkbox135" value="14">
14. ����٧��������շ�����������/�Ҵ����ػ��������§��</td>
        <td valign="middle"><input type="checkbox" name="v282" id="checkbox19" value="19">
19. ���ä��Шӵ��&nbsp;�к�&nbsp;
<input type="text" value=""  style=" width:30%" name="v283"  /></td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v268" id="checkbox13" value="5">
5. �Դ����</td>
        <td valign="middle"><input type="checkbox" name="v273" id="checkbox2" value="10">
10. ���Դ����HIV/�������ʹ��</td>
        <td valign="middle"><input type="checkbox" name="v278" id="checkbox14" value="15">
15. �Ҵ�Թ��Сͺ�Ҫվ</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td height="24" colspan="4" align="center" valign="middle" bgcolor="#f2f2f2"><strong>������������ͷ���ͧ���</strong></td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v284" id="checkbox38" value="1">
1. ��������й�</td>
        <td valign="top"><input type="checkbox" name="v288" id="checkbox21" value="5">
5.  ��ͧ��ý֡�Ҫվ</td>
        <td valign="top"><input type="checkbox" name="v292" id="checkbox24" value="9">
9. �Թ��������㹡���Թ�ҧ��ѡ�Ҿ�Һ��</td>
        <td valign="top"><input type="checkbox" name="v296" id="checkbox4" value="13">
13. �������������ٻ����Ѻ����˭�</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v285" id="checkbox39" value="2">
2. �Թʧ������</td>
        <td valign="top"><input type="checkbox" name="v289" id="checkbox22" value="6">
6. ������������</td>
        <td valign="top"><input type="checkbox" name="v293" id="checkbox25" value="10">
10. �Թ��������㹡���ѡ�Ҿ�Һ��</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v286" id="checkbox40" value="3">
3. �Թ�ع��Сͺ�Ҫվ</td>
        <td valign="top"><input type="checkbox" name="v290" id="checkbox8" value="7">
7. ���Ѻ��ä�����ͧ</td>
        <td valign="top"><input type="checkbox" name="v294" id="checkbox27" value="11">
11. ������ҧ�к�������ͧ</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v287" id="checkbox20" value="4">
4. ���������������</td>
        <td valign="top"><input type="checkbox" name="v291" id="checkbox23" value="8">
        8. ��ͧ�����������Ԩ������ҧ�㹪����</td>
        <td valign="top"><input type="checkbox" name="v295" id="checkbox26" value="12">
12. �Ѵ������Ѥ����仴���</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="right" valign="top"><button> �ѹ�֡������ </button>        </td>
        <td valign="top">&nbsp;</td>
      </tr>
  </table>
    </form>