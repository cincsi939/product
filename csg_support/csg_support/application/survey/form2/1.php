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
		'inputname' => 'v382',
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
	$sql = "SELECT educ_id,education,level FROM eq_member_education order by level asc";
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
          <th height="24" colspan="4" align="center" bgcolor="#f2f2f2" >��������ǹ��� (���������� ���� 0-18 ��)</th>
        </tr>
        <tr>
          <th colspan="4" align="left" ><table width="100%" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="11%">�Ţ�ѵû�ЪҪ�</td>
              <td width="29%"><input type="text" name="v156" id="tIDCard"  style="width:120px"  />
              <span  id="idClassCheck" class="bIdCard">��Ǩ�ͺ</span> <span  id="random2" class="bIdCard">�����Ţ�ѵ�
              <input type="hidden" value="<?php echo $_GET['id']; ?>"  name="pin"  />
              <input  name="eq_type" type="hidden" id="eq_type" value="1"  />
              </span></td>
              <td width="6%">����</td>
              <td width="54%"><select id="v384" name="v384"  style="width:120px"  >
                <option value="">�ô�к�</option>
                <?php
				$sql_Prename = 'SELECT id,prename_th,gender FROM `tbl_prename` ORDER BY priority asc;';
				$results_Prename = $con->select($sql_Prename);
				foreach($results_Prename as $rd){
						echo '<option  value="'.$rd['id'].'">'.$rd['prename_th'].'</option>';
				}
			 ?>
              </select>
              <input type="text" value="" name="v154" id="tName"  style="width:120px"  />
              ���ʡ��
              <input type="text" value="" name="v381" id="v381"  style="width:120px"  /></td>
            </tr>
            <tr>
              <td>��</td>
              <td><!--<input type="text" value=""  style=" width:10%"  />-->
              <LABEL id="lblPreName">
                <input name="v383" type="radio"  class="rSex" id="female"  value="1"  />
1. ˭ԧ&nbsp;
<input type="radio"  value="2" class="rSex" name="v383"  id="male" />
2. ���
<INPUT name="chkSex" type="hidden" id="tSex" value="1" size="30" />
			</LABEL></td>
              <td>�ѹ�Դ</td>
              <td><?php echo $result; ?> ����
              <input name="v155" type="text"  value="" size="3" id="v155"  /></td>
            </tr>
            <tr>
              <td>��������ѹ���ͺ����</td>
              <td><select name="v157" style="width:120px">
              			<option value="">�ô�к�</option>
                <?php
foreach($relation as $rd){
	echo '<option value="'.$rd['id'].'">'.$rd['r_name'].'</option>';
}
?>
              </select></td>
              <td>����֡��</td>
              <td><select name="v158" style="width:120px">
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
          <th colspan="4" align="left" ><!--<input type="text" value=""  style=" width:10%"  />--></th>
        </tr>
        <tr>
          <td  height="24" colspan="4" align="center" bgcolor="#f2f2f2" ><strong>ʶҹ�ѭ��</strong></td>
        </tr>
      </thead>
       <tr>
        <td width="25%" valign="middle"><input type="checkbox" name="v159" id="checkbox" value="1">
1. ����շع����֡��<br></td>
        <td width="25%" valign="middle"><input type="checkbox" name="v165" id="checkbox2" value="7">
7. �Դ����</td>
        <td width="25%" valign="middle"><input type="checkbox" name="v171" id="checkbox3" value="13">
13. ������������</td>
        <td width="25%" valign="middle"><input type="checkbox" name="v177" id="checkbox119" value="19">
19. �Դ�/��ôҵ�ͧ�ɨӤء</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v160" id="checkbox5" value="2"> 
        2. �١����Դ�ҧ��</td>
        <td valign="middle"><input type="checkbox" name="v166" id="checkbox6" value="8">
8. �Դ����</td>
        <td valign="middle"><input type="checkbox" name="v172" id="checkbox7" value="14">
14. �硷�躡���ͧ�ҧ������¹���</td>
        <td valign="middle"><input type="checkbox" name="v178" id="checkbox120" value="20">
20. �Դ�/��ôҷʹ���</td>
      </tr>
      <tr>
        <td valign="middle"><input name="v161" type="checkbox" id="checkbox9" value="3">
3. �١��������ҧ�����ШԵ�</td>
        <td valign="middle"><input type="checkbox" name="v167" id="checkbox10" value="9">
9. ��蹡�þ�ѹ</td>
        <td valign="middle"><input type="checkbox" name="v173" id="checkbox11" value="15">
15. ����ѭ�ҵ�</td>
        <td valign="middle"><input type="checkbox" name="v179" id="checkbox121" value="21">
21. �硢ͷҹ</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v162" id="checkbox12" value="4">
4. ��������ͧ�����������š����</td>
        <td valign="middle"><input type="checkbox" name="v168" id="checkbox15" value="10">
10. �վĵԡ������§ູ�ҧ��</td>
        <td valign="middle"><input type="checkbox" name="v174" id="checkbox116" value="16">
16. �硵Դ���� HIV</td>
        <td valign="middle"><input type="checkbox" name="v180" id="checkbox122" value="22">
22. ��������Ѻ����֡���Ҥ�ѧ�Ѻ(�.3)</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v163" id="checkbox14" value="5">
5. �ٺ������</td>
        <td valign="middle"><input type="checkbox" name="v169" id="checkbox16" value="11">
11. ��������ѹ���͹����ѹ���</td>
        <td valign="middle"><input type="checkbox" name="v175" id="checkbox117" value="17">
17. �����Ѻ�š�з��ҡ HIV</td>
        <td valign="middle"><input type="checkbox" name="v181" id="checkbox123" value="23">
23. ������</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v164" id="checkbox13" value="6">
6. �Դ�Һ��</td>
        <td valign="middle"><input type="checkbox" name="v170" id="checkbox17" value="12">
12. ��駤�����������</td>
        <td valign="middle"><input type="checkbox" name="v176" id="checkbox118" value="18">
18. �Դ�/��ô����ª��Ե</td>
        <td height="20" valign="middle"><input type="checkbox" name="v182" id="checkbox124" value="24">
24. ���ä��Шӵ��          
        �к� 
  <input type="text" value=""  style=" width:30%" name="v183"  /></td>
      </tr>
      <tr>
        <td height="24" colspan="4" align="center" valign="middle" bgcolor="#f2f2f2"><strong>������������ͷ���ͧ���</strong></td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v184" id="checkbox4" value="1">
1. ��������й�</td>
        <td valign="top"><input type="checkbox" name="v187" id="checkbox19" value="4">
4. ��������Ѻ����͹</td>
        <td valign="top"><input type="checkbox" name="v190" id="checkbox22" value="7">
7. ���������������</td>
        <td valign="top"><input type="checkbox" name="v193" id="checkbox125" value="10">
10. �������������ٻ����Ѻ��</td>	
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v185" id="checkbox8" value="2">
2. �ع����֡��</td>
        <td valign="top"><input type="checkbox" name="v188" id="checkbox20" value="5">
5. ����ͧ������</td>
        <td valign="top"><input type="checkbox" name="v191" id="checkbox23" value="8">
8. ��������㹡���Թ�ҧ�ѡ�Ҿ�Һ��</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v186" id="checkbox18" value="3">
3. �Թʧ������</td>
        <td valign="top"><input type="checkbox" name="v189" id="checkbox21" value="6">
6. ���Ѻ��úӺѴ ��鹿�</td>
        <td valign="top"><input type="checkbox" name="v192" id="checkbox24" value="9">
9. �Թ��������㹡���ѡ�Ҿ�Һ��</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="right" valign="top"><button> �ѹ�֡������ </button>          </td></td>
        <td valign="top">&nbsp;</td>
      </tr>
</table>
    </form>