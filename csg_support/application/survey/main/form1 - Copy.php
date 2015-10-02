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
	require_once('lib/nusoap.php'); 
	require_once("lib/class.function.php");
	$con = new Cfunction();
	$con->connectDB();
?>
<link rel="stylesheet" href="../css/style.css">
<script language="JavaScript">
	function showimagepreview(input) {
	if (input.files && input.files[0]) {
	var filerdr = new FileReader();
	filerdr.onload = function(e) {
	$('#imgprvw').attr('src', e.target.result);
	}
	filerdr.readAsDataURL(input.files[0]);
	}
}


</script>


<script src="../js/jquery-1.10.1.min.js"></script>
<script language="JavaScript">
function CreateXmlHttp(){
		//Creating object of XMLHTTP in IE
		try {
			XmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e){
			try{
				XmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			} 
			catch(oc) {
				XmlHttp = null;
			}
		}
		//Creating object of XMLHTTP in Mozilla and Safari 
		if(!XmlHttp && typeof XMLHttpRequest != "undefined") {
			XmlHttp = new XMLHttpRequest();
		}
	} // end function CreateXmlHttp
	
function chgAmphur(e, defa_v, tambon) {
		if ( e ) {
			//document.getElementById('v9').disabled = true;
			CreateXmlHttp();
			XmlHttp.open("get", "main/ajax.chgamphur.php?PvID="+e+"&DfVal="+defa_v, true);
			XmlHttp.onreadystatechange=function() {//alert("Aussy!!");
				if (XmlHttp.readyState==4) {
					
					if (XmlHttp.status==200) {
						var res = XmlHttp.responseText; //alert(res);
						document.getElementById("lblAmphur").innerHTML = res;
						chgTambon(defa_v, tambon);
					} else if (XmlHttp.status==404) {
						alert("�������ö�ӡ�ô֧��������");
					} else {
						alert("Error : "+XmlHttp.status);
					}
				}
			};
			XmlHttp.send(null);
			//chgTambon(e,'');
		}
	}
	
function chgTambon(e, defa_v) {
		if ( e ) {
			CreateXmlHttp();
			XmlHttp.open("get", "main/ajax.chgtambon.php?TbID="+e+"&DfVal="+defa_v, true);
			XmlHttp.onreadystatechange=function() {
				if (XmlHttp.readyState==4) {
					if (XmlHttp.status==200) {
						var res = XmlHttp.responseText; //alert(res);
						document.getElementById("lblTambon").innerHTML = res;
					} else if (XmlHttp.status==404) {
						alert("�������ö�ӡ�ô֧��������");
					} else {
						alert("Error : "+XmlHttp.status);
					}
				}
			};
			XmlHttp.send(null);
		}
}

function chgPreName(e) {
	if ( e ) {
			CreateXmlHttp();
			XmlHttp.open("get", "main/ajax.chkprename.php?pre="+e, true);
			XmlHttp.onreadystatechange=function() {
				if (XmlHttp.readyState==4) {
					if (XmlHttp.status==200) {
						var res = XmlHttp.responseText; //alert(res);
						document.getElementById("lblPreName").innerHTML = res;
					} else if (XmlHttp.status==404) {
						alert("�������ö�ӡ�ô֧��������");
					} else {
						alert("Error : "+XmlHttp.status);
					}
				}
			};
			XmlHttp.send(null);
		}
}

</script>

<?php
	$ws_client = $con->configIPSoap();
	$calendar = array('file' => 'calendar');
	echo $ws_client->call('includefile', $calendar);
	$para = array(
		'dateFormat' => 'dd/mm/yy',
		'inputname' => 'tbirthday',
		'showicon' => false,
		'showOtherMonths' => true,
		'showButton' => false,
		'showchangeMonth' => true,
		'numberOfMonths' => 1,
		'format' => 'tis-620',
		'showWeek' => false);	
	 $result = $ws_client->call('calendar', $para);
?>
<style>
.style1{
	color:#F00;
}
</style>
<form action="main_exc/form1_exc.php" method="post" enctype="multipart/form-data" id="form1" name="form1" onSubmit="JavaScript:return fncSubmit();">
<table width="850" border="0">
<tbody>
	<tr>    
    	<td colspan="4" align="right" >���������Ǩ 
        <INPUT name="round" type="hidden" id="round" value="<?php if($_GET['rond']){echo $_GET['rond'];}else{echo 1;} ?>" size="1"  />
        � �ѹ��� <?php echo $con->_calendarTH('sDay','sMonth','sYear'); ?>
  	  </td>
      </tr>
    <tr>
   	  <td colspan="3" align="left"><b><u>��ǹ��� 1</u></b> <b>��������´�����Ţͧ�������͹</b></td>
   	  <td width="246">
      </td>
    </tr>
    <tr>
      <td width="24" align="right">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td rowspan="5" align="center"><img src="../img/nopicture.gif" width="150" height="180" id="imgprvw" alt="uploaded image preview" name="pPicture">
        <input type="File" name="filUpload" id="filUpload" onChange="showimagepreview(this)" ></td>
    </tr>
    <tr>
      <td height="25" align="right">1.</td>
      <td height="25" colspan="2" valign="middle"><input type="hidden" name="cIDCard" value="1">
        �Ţ�ѵû�Шӵ�ǻ�ЪҪ�<span class="style1"> *</span>
        <INPUT name="v3" type="text" id="v3" value="" size="30"  />        
        <span  id="idClassCheck" class="bIdCard">��Ǩ�ͺ</span>   <span  id="random2" class="bIdCard">�����Ţ�ѵ�</span></td>
      </tr>
    <tr>
      <td height="25" align="right">2.</td>
      <td height="25" colspan="2"><table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td width="24%">�������˹�Ҥ�ͺ����&nbsp;<span class="style1">*</span></td>
          <td width="24%">
          
          <select id="tPrename" name="tPrename" style="width:90%" onChange="chgPreName(this.value)" >
            <?php
				$sql_Prename = 'SELECT id,prename_th,gender FROM `tbl_prename` ORDER BY priority asc;';
				$results_Prename = $con->select($sql_Prename);
				foreach($results_Prename as $rd){
						echo '<option  value="'.$rd['id'].'">'.$rd['prename_th'].'</option>';
				}
			 ?>
		</select>
          
          </td>
          <td width="21%"><input name="v1" type="text" value="" id="v1" size="20"  /></td>
          <td width="10%" align="center">���ʡ��</td>
          <td width="21%"><input type="text" value=""  name="v2" id="v2" size="20"/></td>
        </tr>
      </table></td>
      </tr>
    <tr>
      <td height="25" align="right">3. </td>
      <td height="25" colspan="2">������������</td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td height="25" colspan="2" valign="middle"><table width="471" border="0" cellpadding="1" cellspacing="1">
        <tr>
          <td width="61" align="left">��ҹ�Ţ���</td>
          <td width="152"><INPUT type="text" value="" name="v5" style="width:90%" id="v5" /></td>
          <td width="76" align="left">&nbsp;</td>
          <td width="151">&nbsp;</td>
          </tr>
        <tr>
          <td align="left">������ </td>
          <td><input type="text" value=""  name="v6" style="width:90%" id="v6" /></td>
          <td align="left">��� </td>
          <td><input type="text" value="" name="v7" style="width:90%" id="v7" /></td>
        </tr>
        <tr>
          <td align="left">�ѧ��Ѵ <span class="style1">*</span></td>
          <td><!--<input type="text" value="" name="tProvince" />-->
          
          <select id="v10" name="v10" onChange = "chgAmphur(this.value);"  style="width:90%" >
            <?php
				$sql_Changwat = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Changwat' ";
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					if($rd['ccDigi']==23000000)
					{
						echo '<option selected  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
					else
					{
						echo '<option  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
				}
			 ?>
		</select></td>
          <td align="left">����� <span class="style1">*</span></td>
          <td>
           <LABEL id="lblAmphur">
          	<select id="v9" name="v9" onChange = "chgTambon(this.value, '');" style="width:90%">
            <option value="">�ô�к�</option>
            <?php
				$sql_Changwat = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Aumpur' AND areaid like '23%' AND ccName NOT LIKE '%*%'";
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					echo '<option  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
				}
			 ?>
            </select>
            </LABEL>
          
           <!--<input type="text" value="" name="tDistrict"/>--></td>
          </tr>
        <tr>
          <td align="left">�Ӻ� <span class="style1">*</span></td>
          <td><!--<input type="text" value=""  name="tParish"/>-->
          <LABEL id="lblTambon">
          <select id="v8" name="v8" style="width:90%">
          <option value="">�ô�к�</option>
          <?php
				$sql_Changwat = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Tamboon' AND areaid like '23%' AND ccName NOT LIKE '%*%'";
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					echo '<option  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
				}
			 ?>
          </select>
          </LABEL></td>
          <td align="left">���Ѿ��</td>
          <td><input type="text" value=""  name="v11" style="width:90%" id="v11"/></td>
          </tr>
      </table>
      
      </td>
      </tr>
    <tr>
      <td height="25" align="right">4. </td>
      <td height="25" colspan="2">�� <span class="style1">*</span>
      <LABEL id="lblPreName"><input name="v12" type="radio"  class="v12" id="female"  value="1" checked  />1. ˭ԧ&nbsp;<input type="radio"  value="2" class="v12" name="v12"  id="male" />2. ���
		<INPUT name="chkSex" type="hidden" id="chkSex" value="1" size="30" />
	</LABEL>
</td>
      <td align="center">&nbsp;</td>
      </tr>
    <tr>
      <td height="25" align="right">5. </td>
      <td height="25" colspan="2">�ѹ�Դ <span class="style1">*</span> <?php echo $result; ?>  ����
        <INPUT name="v14" type="text" id="v14" value="" size="4" maxlength="4" class="numberOnly" />
��</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">6. </td>
      <td height="25" colspan="2">�������ͧ������������㹻Ѩ�غѹ
        
        &nbsp;</td>
      <td height="25">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td height="25"><input name="v15" type="radio" class="v15"  id="m2"  value="1" checked />1. ��ҹ����ͧ</td>
      <td height="25" colspan="2">	<input name="v15" type="radio"  value="4" id="v15_2"   class="v15"/>
        2. ��ҹ��� ���¤�����
<INPUT name="v16" type="text" id="v16" value="" size="10" class="numberOnly" />
        �ҷ/��͹/��</td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td height="25"><input name="v15" type="radio"  value="3" id="f3" class="v15"  />
3. ��ҹ�ҵ� </td>
      <td height="25" colspan="2"><input name="v15" type="radio"  value="4" id="v15_4"   class="v15"/>
        4. ��� � �к�        
        <INPUT name="v17" type="text" id="v17" value="" style="width:80%" /></td>
      </tr>
    <tr>
      <td height="25" align="right">7.</td>
      <td height="25" colspan="2">�ѡɳз������</td>
      <td height="25">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td height="25" colspan="2">7.1 �ѡɳТͧ��ҹ</td>
      <td height="25">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3" align="right"><textarea name="v18" id="v18" style="width:100%" rows="8"></textarea></td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="2">7.2 ��Ҿ��ҹ</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><textarea name="v19" id="v19" style="width:100%" rows="8"></textarea></td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="2">7.3 ��ͧ�آ�</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><textarea name="v20" id="v20" style="width:100%" rows="8"></textarea></td>
      </tr>
    <tr>
      <td height="25" align="right">8.</td>
      <td  colspan="2">��Ҿ�Ǵ����</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><textarea name="v20" id="v20" style="width:100%" rows="8"></textarea></td>
      </tr>
    <tr>
      <td height="25" align="right">9.</td>
      <td  colspan="2">����֡��</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input    name="v22" type="radio"  id="v22_1"  value="1" checked/>
        ������֡��</td>
      <td width="282" ><input type="radio"  value="2"  id="v22_2"    name="v22"/>
        ��ӡ��һ�ж��֡��</td>
      <td ><input type="radio"  value="3"  id="v22"    name="v22"/>
        ��ж��֡��</td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="4"  id=""    name="v22"/>
      �Ѹ���֡�ҵ͹��</td>
      <td ><input type="radio"  value="5"  id=""    name="v22"/>
        �Ѹ���֡�ҵ͹����</td>
      <td ><input type="radio"  value="6"  id="v22"    name="v22"/>
        �Ѹ���֡�ҵ͹����/�Ǫ</td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="7"  id=""    name="v22"/>
      ͹ػ�ԭ��/���</td>
      <td ><input type="radio"  value="8"  id=""    name="v22"/>
        ��ԭ�ҵ��</td>
      <td ><input type="radio"  value="9"  id="v22"    name="v22"/>
        �٧���һ�ԭ�ҵ��</td>
      </tr>
    <tr>
      <td height="25" align="right">10. </td>
      <td  colspan="2">�Ҫվ��ѡ�ͧ���˹�Ҥ�ͺ���� <strong>(�ͺ���ҡ��� 1 ���) <span class="style1">*</span></strong></td>
      <td >&nbsp;</td>
    </tr>

    <!--<div class="careertable">-->
    <tr class="careertable">
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="checkbox"  value="1"  id="cCareer1"    name="v23" class="cCareer"/>
        1. �Ѻ��ҧ�����</td>
      <td >        <input type="checkbox"  value="2"  id="cCareer2"    name="v24" class="cCareer"/>
      2. �ɵá� </td>
      <td >&nbsp;</td>
    </tr>
    <tr class="careertable">
      <td height="25" align="right">&nbsp;</td>
      <td >        <input type="checkbox"  value="3"  id="cCareer3"    name="v25" class="cCareer"/>
      3. �����</td>
      <td >        <input type="checkbox"  value="4"  id="cCareer4"    name="v26" class="cCareer"/>
      4. ����Ҫ���/�١��ҧ���;�ѡ�ҹ�ͧ�Ѱ</td>
      <td >&nbsp;</td>
    </tr>
    <tr class="careertable">
      <td height="25" align="right">&nbsp;</td>
      <td >        <input type="checkbox"  value="5"  id="cCareer5"    name="v27" class="cCareer"/>
      5. ��ѡ�ҹ�Ѱ����ˡԨ</td>
      <td >        <input type="checkbox"  value="6"  id="cCareer6"    name="v28" class="cCareer"/>
      6. ���˹�ҷ��ͧ��û���ͧ��ͧ��� </td>
      <td >&nbsp;</td>
    </tr>
    <tr class="careertable">
      <td height="25" align="right">&nbsp;</td>
      <td >        <input type="checkbox"  value="7"  id="cCareer7"    name="v29" class="cCareer"/>
      7. ��Ң��/��áԨ��ǹ���</td>
      <td >        <input type="checkbox"  value="8"  id="cCareer8"    name="v30" class="cCareer"/>
      8. ��ѡ�ҹ/�١��ҧ�͡��</td>
      <td >&nbsp;</td>
    </tr>
    <tr class="careertable">
      <td height="25" align="right">&nbsp;</td>
      <td width="280" >        <input type="checkbox"  value="9"  id="cCareer9"    name="v31" class="cCareer"/>
      9. ��ҧ�ҹ/����էҹ��</td>
      <td  colspan="2">
        
        <input type="checkbox"  value="10"  id="cCareer10"    name="v32" class="cCareer"/>
        10. ��� � �к�
  <input  name="v33" type="text" value="" style="width:80%" id="tCareer"  /></td>
      </tr>
      <!--</div>-->
    <tr>
      <td height="25" align="right">11.</td>
      <td  colspan="2">��ͺ�����շ��Թ�ӡԹ      </td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="1"  id="rLand"    name="v34"/>
        �� �ӹǹ 
        <input name="v35" type="text" id="tLand" size="10" class="numberOnly" />
        ���</td>
      <td ><input    name="v34" type="radio" class="rLand_1"  id="m34"  value="2" checked/>
        �����</td>
      <td >&nbsp;</td>
    </tr>
    <tr class="careertable">
      <td height="25" align="right">12. </td>
      <td  colspan="3">���������¢ͧ��ͺ���� �ӹǹ
        <input name="v36" type="text" value="" size="10" id="tIncome" class="numberOnly" />
        �ҷ (��ͻ�)<strong> (�����Դ�ҡ��Ҫԡ���������������ѹ) <span class="style1">*</span></strong></td>
      </tr>
    <tr>
      <td height="25" align="right">13. </td>
      <td  colspan="2">��ʹ���ѡ�ͧ��ͺ����</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><input name="v37" type="radio" class="rReligion"  id=""  value="1" checked/>
        1. �ط�
        &nbsp;
        <input type="radio"  value="2" id="" name="v37"  class="rReligion"/>
        2. ���ʵ�
        <input type="radio"  value="3"  id="" name="v37"   class="rReligion"/>
        3. ������
        &nbsp;
        <input type="radio"  value="4"  name="v37"  class="rReligion_1" id="rReligion_2"/>
        4. ��� � �к�
        <input name="v38" type="text" value="" style="width:60%" id="tReligion_1" /></td>
      </tr>
    <tr>
      <td height="25" align="right">14.</td>
      <td  colspan="2">��ҹ�Ҿ���ʢͧ��ҹ㹻Ѩ�غѹ�����ҧ��</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input name="v39" type="radio"  class="rStatus"  value="1" checked />
        1. �ʴ</td>
      <td  colspan="2"><input type="radio"  value="2" class="rStatus" name="v39" />
        2. ���� </td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="3"  class="rStatus"  name="v39"/>
        3. ������ҧ</td>
      <td  colspan="2"><input type="radio"  value="4" class="rStatus" name="v39"/>
        4. ��������ͧ�ҡ����������ª��Ե</td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="5"  id="rStatus_5" name="v39" />
        5. �¡�ѹ���� �ô�к�</td>
      <td  colspan="2">&nbsp;</td>
      </tr>
      
    <tr class="rStatus_detail">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><dd><input type="radio"  value="1" class="rStatus_5_detail" name="v40" />
�¡�ѹ������Ǥ��ǵ����͵�ŧ�����͵�ŧ�����ҧ�������</dd></td>
      </tr>
    <tr class="rStatus_detail">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><dd><input type="radio"  value="2" class="rStatus_5_detail" name="v40"/>�¡�ѹ������Ǥ��ǵ����������</dd>
        </td>
      </tr>
      
    <tr>
      <td height="25" align="right">15.</td>
      <td  colspan="2">�ѡɳ��ç���ҧ��ͺ����</td>
      <td >&nbsp;</td>
    </tr>
    <tr id="t15_detail_1">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><input  name="v41" type="radio" class="rStructureFamily" id="rStructureFamily"  value="1" checked/>
        1. ��ͺ�������� �ӹǹ��Ҫԡ
<input type="text" value="" size="4" maxlength="4" name="v42" id="tMemberFamily_1" style="background:#EBEBE4" readonly/>
        �� ���
  <input type="text" value="" size="4" maxlength="4" name="v43" id="tMemberMale_1" class="numberOnly"/>
        �� ˭ԧ
  <input type="text" value="" size="4" maxlength="4" name="v44" id="tMemberFemale_1" class="numberOnly"/>
  &nbsp;�� <strong>*��ͺ���Ƿ���Сͺ���¾�� ��� ����١����ѧ������觧ҹ</strong></td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="2"><input type="radio"  value="2" id="rLargeFamily" name="v41" class="rLargeFamily"/>
        2. ��ͺ���Ǣ��� �ô�к�</td>
      <td >&nbsp;</td>
    </tr>
    
    <tr class="r15_2">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><dd>
        <input type="radio"  value="1" id="rLargeFamily_21" name="v45" class="rLargeFamily_23"  />
        2.1 ��ͺ���Ǣ��·���Сͺ�������� � �������͹���������ѹ ���Ф������͹ <u>�դ�������ѹ���͡ѹ</u></dd></td>
    </tr>
    <tr class="r15_2" id="t15_detail_2_1">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><dd> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�ӹǹ��Ҫԡ
        <input type="text" value="" size="4" maxlength="4" name="v46" id="tMemberFamily_2_1" style="background:#EBEBE4" readonly/>
        �� ���
        <input type="text" value="" size="4" maxlength="4" name="v47" id="tMemberMale_2_1" class="numberOnly" />
        �� ˭ԧ
        <input type="text" value="" size="4" maxlength="4" name="v48" id="tMemberFemale_2_1" class="numberOnly" />
        &nbsp;�� </dd></td>
    </tr>
    <tr class="r15_2">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><dd>
        <input type="radio"  value="2" id="rLargeFamily_22" name="v45" class="rLargeFamily_24"  />
        2.2 ��ͺ���Ǣ��·���Сͺ�������� � �������͹���������ѹ ���Ф������͹ <u>�դ�������е�͡ѹ</u>㹡�ô��Թ���Ե��ͺ���Ǣͧ���ͧ </dd></td>
    </tr>
    <tr class="r15_2" id="t15_detail_2_2">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3" valign="top"><dd> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�ӹǹ�������͹
        <input type="text" value="" size="4" maxlength="4" name="v49" id="v49" class="numberOnly" />
&nbsp;�ӹǹ��Ҫԡ
          <input type="text" value="" size="4" maxlength="4"  name="v50" id="tMemberFamily_2_2" style="background:#EBEBE4" readonly/>
        �� ���
        <input type="text" value="" size="4" maxlength="4" name="v51" id="tMemberMale_2_2" class="numberOnly" />
        �� ˭ԧ
        <input type="text" value="" size="4" maxlength="4"  name="v52" id="tMemberFemale_2_2" class="numberOnly"/>
        &nbsp;�� </dd></td>
    </tr>
    
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="2"><input type="radio"  value="3" id="rSpecialFamily"  name="v41" class="rSpecialFamily"/>
        3. ��ͺ�����ѡɳо���� �ô�к�</td>
      <td >&nbsp;</td>
    </tr>
    
    <tr class="r15_3">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="2"><dd>
        <input type="radio"  value="1" id="rSpecialFamily_1" name="v53" class="rSpecialFamily_1" />
        3.1 ��ͺ���Ƿ������պص�</dd></td>
      <td >&nbsp;</td>
    </tr>
    <tr class="r15_3">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="2"><dd>
        <input type="radio"  value="2" id="rSpecialFamily_2" name="v53" class="rSpecialFamily_2"/>
        3.2 ��ͺ���Ǿ�������������§�����</dd></td>
      <td >&nbsp;</td>
    </tr>
    <tr class="r15_3">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="2"><dd>
        <input type="radio"  value="3" id="rSpecialFamily_3"  name="v53" class="rSpecialFamily_3"/>
        3.3 ��ͺ���Ǻصúح����</dd></td>
      <td >&nbsp;</td>
    </tr>
    <tr class="r15_3">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="2"><dd><input type="radio"  value="4" id="rSpecialFamily_4"  name="v53" class="rSpecialFamily_4" />
      
        3.4 ��ͺ�����ȷҧ���͡</dd></td>
      <td >&nbsp;</td>
    </tr>
    <tr class="r15_3">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="2"><dd><input type="radio"  value="5" id="rSpecialFamily_5"  name="v53" class="rSpecialFamily_5"/>
      
        3.5 ��ͺ�����ػ�����</dd></td>
      <td >&nbsp;</td>
    </tr>
    <tr class="r15_3">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><dd>
        <input type="radio"  value="6" id="rSpecialFamily_6"  name="v53" class="rSpecialFamily_6"/>
        3.6 ��� � �к�
        <input name="v54" type="text" value="" style="width:85%" id="tSpecialFamily_3" />
      </dd></td>
      </tr>
    <tr>
      <td height="25" align="right">16. </td>
      <td  colspan="2">�ӹǹ��Ҫԡ㹤�ͺ���Ƿ�������о�觾ԧ�٧ (�������ö��������͵��ͧ��)</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td width="280" ><input name="v55" type="radio"  id="rDefective_1"  value="1" checked  />1. �����</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="2"  id="rDefective_2"  name="v55"/>2. �ӹǹ<input type="text" value="" size="4" maxlength="4" name="v56" id="tDefective" style="background:#EBEBE4" readonly>�� �ô�к� </td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      </tr>
      
    <tr id="t16_detail">
      <td height="25" align="right">&nbsp;</td>
      <td colspan="3"><dd>
        <table>
          <tr>
            <td>�ӹǹ����� (0-4��)</td>
            <td><input type="text" value="" size="4" maxlength="4" name="v57" id="tChild" class="numberOnly" />
              ��</td>
            </tr>
          <tr>
            <td>�ӹǹ���ԡ��</td>
            <td><input type="text" value="" size="4" maxlength="4"  name="v58" id="tDisabled" class="numberOnly" />
              ��</td>
            </tr>
          <tr>
            <td>�ӹǹ�����·ҧ�Ե</td>
            <td><input type="text" value="" size="4" maxlength="4" name="v59" id="tMindSick" class="numberOnly" />
              ��</td>
            </tr>
          <tr>
            <td>�ӹǹ������������ѧ</td>
            <td><input type="text" value="" size="4" maxlength="4"  name="v60" id="tSick" class="numberOnly"/>
              ��</td>
            </tr>
          <tr>
            <td>�ӹǹ����٧����</td>
            <td><input type="text" value="" size="4" maxlength="4" name="v61" id="tElderly" class="numberOnly" />
              ��</td>
            </tr>
          </table>
        
        </dd></td>
    </tr>
    <tr>
      <td height="25" align="right">17. </td>
      <td  colspan="3">�ӹǹ���������¡��������</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="3"><table width="50%" border="0" cellpadding="1" cellspacing="0" id="t17">
        <thead>
          <tr>
            <th width="30%" height="25"  bgcolor="#f2f2f2">������</th>
            <th width="10%"  bgcolor="#f2f2f2">���</th>
            <th width="10%"  bgcolor="#f2f2f2">˭ԧ</th>
            <th width="10%"  bgcolor="#f2f2f2">���</th>
            </tr>
          </thead>
        <tr>
          <td width="184" height="25"  align="left">&nbsp;1. �� (���� 0-18 ��)</td>
          <td width="202"  align="center"><input  name="v62" type="text" id="tChildMale"  style=" width:80%" maxlength="4"/></td>
          <td width="202"  align="center"><input name="v63" type="text" id="tChildFemale"  style=" width:80%" maxlength="4" /></td>
          <td  align="center"><input name="v64" type="text" id="tChildTotal"  style=" width:80%; background:#CCC;" value="0" maxlength="4" readonly /></td>
          </tr>
        <tr>
          <td width="184" height="25"  align="left">&nbsp;2. ���Ǫ� (���� 19-25 ��)</td>
          <td width="202"  align="center"><input name="v65" type="text" id="tTeensMale"  style=" width:80%" maxlength="4"  /></td>
          <td width="202"  align="center"><input name="v66" type="text" id="tTeensFemale"  style=" width:80%" maxlength="4" /></td>
          <td  align="center"><input name="v67" type="text" id="tTeensTotal"  style=" width:80%; background:#CCC;" value="0" maxlength="4" readonly /></td>
          </tr>
        <tr>
          <td width="184" height="25"  align="left">&nbsp;3. �������·���� (���� 26-59 ��)</td>
          <td width="202"  align="center"><input name="v68" type="text" id="tMan"  style=" width:80%" maxlength="4" /></td>
          <td width="202"  align="center"><input name="v69" type="text" id="tWoman"  style=" width:80%" maxlength="4" /></td>
          <td  align="center"><input name="v70" type="text" id="tTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly /></td>
          </tr>
        <tr>
          <td width="184" height="25"  align="left">&nbsp;4. ����٧���� (���� 60 ��)</td>
          <td width="202"  align="center"><input name="v71" type="text" id="tElderMale"  style=" width:80%" maxlength="4" /></td>
          <td width="202"  align="center"><input name="v72" type="text" id="tElderFemale"  style=" width:80%" maxlength="4" /></td>
          <td  align="center"><input name="v73" type="text" id="tElderTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly /></td>
          </tr>
        <tr>
          <td width="184" height="25"  align="left">&nbsp;5. ���ԡ��</td>
          <td width="202"  align="center"><input name="v74" type="text" id="tDisabledMale"  style=" width:80%" maxlength="4" /></td>
          <td width="202"  align="center"><input name="v75" type="text" id="tDisabledFemale"  style=" width:80%" maxlength="4"  /></td>
          <td  align="center"><input name="v76" type="text" id="tDisabledTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly  /></td>
          </tr>
        <tr>
          <td width="184" height="25"  align="center">���������</td>
          <td width="202"  align="center"><input name="v77" type="text" id="tMaleTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly  /></td>
          <td width="202"  align="center"><input name="v78" type="text" id="tFemaleTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly /></td>
          <td  align="center"><input name="v79" type="text" id="tSumTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly /></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="25" align="right">18.</td>
      <td  colspan="2">��ͺ������˹���Թ </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  valign="top"><input   name="v80" type="radio"  id="rDebt_1"  value="1" checked/> 1. �����</td>
      <td  valign="top"><br></td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="2"  id="rDebt_2" name="v80" /> 2. �� �ô�к�</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
    <tr class="t18">
      <td height="25" align="right">&nbsp;</td>
      <td >&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox"  value="1"  id="rDebt_a" name="rDebt_a" /> 
        2.1 ˹����к�</td>
      <td  colspan="2">&nbsp;</td>
    </tr>
    <tr id="t18_a" class="t18">
      <td height="25" align="right">&nbsp;</td>
      <td colspan="3">
      <dd>
      <table width="809" border="0" cellpadding="1" cellspacing="1" class="t21">
        <tr>
          <td width="20"><input name="v81" type="checkbox" id="2_2_1" value="1"></td>
          <td>�Թ��鸹Ҥ��</td>
          </tr>
        <tr id="t18_2_1_1">
          <td>&nbsp;</td>
          <td>�ӹǹ 
            <input type="text" value="" size="10" name="v82" id="t21_money_1" />
            �ҷ �͡����������            
            <input type="text" value="" size="10" name="v83" id="t21_interest_1"/>
            ���/�� �����������Թ�ӹǹ 
            <input type="text" value="" size="10" name="v84" id="t21_pay_1"/>
            �ҷ �ʹ�������
            <input type="text" value="" size="10" name="v85" id="t21_balance_1" />
            �ҷ</td>
          </tr>
        <tr>
          <td><input name="v86" type="checkbox" value="2" id="2_2_2"></td>
          <td>�Թ���ͧ�ع�Ѩ��������Ѿ��</td>
          </tr>
        <tr id="t18_2_1_2">
          <td>&nbsp;</td>
          <td>�ӹǹ
            <input type="text" value="" size="10" name="v87" id="t21_money_2" />
�ҷ �͡���������� 
<input type="text" value="" size="10" name="v88" id="t21_interest_2" />
���/�� �����������Թ�ӹǹ 
            <input type="text" value="" size="10" name="v89" id="t21_pay_2" />
            �ҷ �ʹ�������
            <input type="text" value="" size="10" name="v90" id="t21_balance_2" />
            �ҷ</td>
          </tr>
        <tr>
          <td><input name="v91" type="checkbox" id="2_2_3" value="3"></td>
          <td>�Թ���ͧ�ع�����ҹ</td>
          </tr>
        <tr id="t18_2_1_3">
          <td>&nbsp;</td>
          <td>�ӹǹ 
            <input type="text" value="" size="10" name="v92" id="t21_money_3"/>
�ҷ �͡���������� <input type="text" value="" size="10" name="v93" id="t21_interest_3" />
���/�� �����������Թ�ӹǹ
<input type="text" value="" size="10" name="v94" id="t21_pay_3" />
            �ҷ �ʹ�������
            <input type="text" value="" size="10" name="v95" id="t21_balance_3" />
            �ҷ</td>
          </tr>
        <tr >
          <td><input name="v96" type="checkbox" id="2_2_4" value="4"></td>
          <td>�ͧ�ع�Ѳ�Һ��ҷʵ��</td>
          </tr>
        <tr id="t18_2_1_4">
          <td>&nbsp;</td>
          <td>�ӹǹ 
            <input type="text" value="" size="10" name="v97" id="t21_money_4" />
            �ҷ �͡���������� 
            <input type="text" value="" size="10" name="v98" id="t21_interest_4" />
            ���/�� �����������Թ�ӹǹ 
            <input type="text" value="" size="10" name="v99" id="t21_pay_4" />
            �ҷ �ʹ�������
            <input type="text" value="" size="10" name="v100" id="t21_balance_4" />
            �ҷ</td>
          </tr>
        <tr>
          <td><input name="v101" type="checkbox" id="2_2_5" value="5"></td>
          <td>�ͧ�ع����٧����</td>
          </tr>
        <tr id="t18_2_1_5">
          <td>&nbsp;</td>
          <td>�ӹǹ 
            <input type="text" value="" size="10" name="v102" id="t21_money_5" />
            �ҷ �͡���������� 
            <input type="text" value="" size="10" name="v103" id="t21_interest_5" />
            ���/�� �����������Թ�ӹǹ 
            <input type="text" value="" size="10" name="v104" id="t21_pay_5" />
            �ҷ �ʹ�������
            <input type="text" value="" size="10" name="v105" id="t21_balance_5" />
            �ҷ</td>
          </tr>
        <tr>
          <td><input name="v106" type="checkbox" id="2_2_6" value="6"></td>
          <td>�ͧ�ع��������Ѳ�Ҥس�Ҿ���Ե���ԡ��</td>
          </tr>
        <tr id="t18_2_1_6">
          <td>&nbsp;</td>
          <td>�ӹǹ 
            <input type="text" value="" size="10" name="v107" id="t21_money_6"/>
            �ҷ �͡���������� 
            <input type="text" value="" size="10" name="v108" id="t21_interest_6"/>
            ���/�� �����������Թ�ӹǹ 
            <input type="text" value="" size="10" name="v109" id="t21_pay_6"/>
            �ҷ �ʹ�������
            <input type="text" value="" size="10" name="v110" id="t21_balance_6"/>
            �ҷ</td>
          </tr>
        <tr>
          <td><input name="v111" type="checkbox" id="2_2_7" value="7"></td>
          <td>�ͧ�ع����</td>
          </tr>
        <tr id="t18_2_1_7">
          <td>&nbsp;</td>
          <td>�ӹǹ
            <input type="text" value="" size="10" name="v112" id="t21_money_7"/>
            �ҷ �͡���������� 
            <input type="text" value="" size="10" name="v113" id="t21_interest_7" />
            ���/�� �����������Թ�ӹǹ 
            <input type="text" value="" size="10" name="v114" id="t21_pay_7" />
            �ҷ �ʹ�������
            <input type="text" value="" size="10" name="v115" id="t21_balance_7" />
            �ҷ</td>
          </tr>
        <tr>
          <td><input name="v116" type="checkbox" id="2_2_8" value="8"></td>
          <td>�ͧ�ع�ɵ�</td>
          </tr>
        <tr id="t18_2_1_8">
          <td>&nbsp;</td>
          <td>�ӹǹ
            <input type="text" value="" size="10" name="v117" id="t21_money_8" />
            �ҷ �͡���������� 
            <input type="text" value="" size="10" name="v118" id="t21_interest_8"/>
            ���/�� �����������Թ�ӹǹ 
            <input type="text" value="" size="10" name="v119" id="t21_pay_8"/>
            �ҷ �ʹ�������
            <input type="text" value="" size="10" name="v120" id="t21_balance_8"/>
            �ҷ</td>
          </tr>
        <tr>
          <td><input name="v121" type="checkbox" id="2_2_9" value="9"></td>
          <td>��� � �к�
            <input type="text" value=""  style="width:84%" name="v122" id="t21_other" /></td>
          </tr>
        <tr id="t18_2_1_9">
          <td>&nbsp;</td>
          <td>�ӹǹ 
            <input type="text" value="" size="10" name="v123" id="t21_money_9"/>
            �ҷ �͡���������� 
            <input type="text" value="" size="10" name="v124" id="t21_interest_9"/>
            ���/�� �����������Թ�ӹǹ 
            <input type="text" value="" size="10" name="v125" id="t21_pay_9"/>
            �ҷ �ʹ�������
            <input type="text" value="" size="10" name="v126" id="t21_balance_9"/>
            �ҷ</td>
          </tr>
      </table>
      
      </dd>
      </td>
    </tr>
    <tr class="t18">
      <td height="25" align="right" >&nbsp;</td>
      <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox"  value="2"  name="rDebt_a" />
        2.2 ˹��͡�к� �س��˹��͡�к��ú�ҧ �кت��� - ʡ�Ŵ���</td>
    </tr>
    <tr class="t18">
      <td height="25" align="right">&nbsp;</td>
      <td colspan="3">
      
      <dd>
      <table width="809" border="0" cellspacing="2" cellpadding="2" class="order-list">
      <tbody>
        </tbody>
        <tfoot>
        <tr>
          <td >����-ʡ�� 
            <input type="text" name="v127" value="" /></td>
          <td width="104" >�ӹǹ�Թ</td>
          <td width="114"><input type="text" name="v128" size="10" />
�ҷ</td>
          <td width="104">�͡����������</td>
          <td width="264"><input name="v129" type="text" value="" size="10" />
����ѹ/��͹/�� </td>
          </tr>
        <tr>
          <td width="191" >&nbsp;</td>
          <td >�����������Թ            </td>
          <td ><input name="v130" type="text" value="" size="10" />
�ҷ</td>
          <td >�ʹ�������</td>
          <td ><input name="v131" type="text" value="" size="10" />
�ҷ</td>
          </tr>
        <tr>
          <td >����-ʡ��
            <input type="text" name="v132" value="" /></td>
          <td >�ӹǹ�Թ</td>
          <td ><input type="text" name="v133" size="10" />
�ҷ</td>
          <td >�͡����������</td>
          <td ><input name="v134" type="text" value="" size="10" />
����ѹ/��͹/�� </td>
          </tr>
        <tr>
          <td >&nbsp;</td>
          <td >�����������Թ</td>
          <td ><input name="v135" type="text" value="" size="10" />
�ҷ</td>
          <td >�ʹ�������</td>
          <td ><input name="v136" type="text" value="" size="10" />
�ҷ</td>
        </tr>
        <tr>
          <td >����-ʡ��
            <input type="text" name="v137" value="" /></td>
          <td>�ӹǹ�Թ</td>
          <td ><input type="text" name="v138" size="10" />
            �ҷ</td>
          <td>�͡����������</td>
          <td ><input name="v139" type="text" value="" size="10" />
            ����ѹ/��͹/�� </td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td>�����������Թ</td>
          <td ><input name="v140" type="text" value="" size="10" />
            �ҷ</td>
          <td>�ʹ�������</td>
          <td ><input name="v141" type="text" value="" size="10" />
            �ҷ</td>
        </tr>
        <tr>
          <td >����-ʡ��            <input type="text" name="v142" value="" /></td>
          <td>�ӹǹ�Թ</td>
          <td ><input type="text" name="v143" size="10" />
            �ҷ</td>
          <td>�͡����������</td>
          <td ><input name="v144" type="text" value="" size="10" />
            ����ѹ/��͹/�� </td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td>�����������Թ</td>
          <td ><input name="v145" type="text" value="" size="10" />
            �ҷ</td>
          <td>�ʹ�������</td>
          <td ><input name="v146" type="text" value="" size="10" />
            �ҷ</td>
        </tr>
        <tr>
          <td >����-ʡ��            <input type="text" name="v147" value="" /></td>
          <td>�ӹǹ�Թ</td>
          <td ><input type="text" name="v148" size="10" />
            �ҷ</td>
          <td>�͡����������</td>
          <td ><input name="v149" type="text" value="" size="10" />
            ����ѹ/��͹/�� </td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td>�����������Թ</td>
          <td ><input name="v150" type="text" value="" size="10" />
            �ҷ</td>
          <td>�ʹ�������</td>
          <td ><input name="v151" type="text" value="" size="10" />
            �ҷ</td>
        </tr>
        </tfoot>
      </table>
      </dd>
      
      </td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="3" align="right"><button> ���Թ��õ�� </button></td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="2" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="2" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="2" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
</tbody>
</table>
</form>

<script src="../js/CheckIdCardThai.min.js"></script>
<script src="../js/AgeCalculate.min.js"></script>
<script  type="text/javascript">


function fncSubmit()
{
	
	if(document.getElementById('cCareer1').checked==false && document.getElementById('cCareer2').checked==false && document.getElementById('cCareer3').checked==false && document.getElementById('cCareer4').checked==false && document.getElementById('cCareer5').checked==false && document.getElementById('cCareer6').checked==false && document.getElementById('cCareer7').checked==false && document.getElementById('cCareer8').checked==false && document.getElementById('cCareer9').checked==false && document.getElementById('cCareer10').checked==false)
	{
		alert('��س����͡�Ҫվ ���� �к��Ҫվ���١��ͧ');
		document.form1.tCareer.focus();
		return false;
	}
	if(document.form1.chkSex.value == 0)
	{
		alert('��سҡ�͡���͡��');
		document.form1.tIDCard.focus();
		return false;
	}
	
	if(document.form1.v3.value == "")
	{
		alert('��سҡ�͡�ѵû�ЪҪ� ���� ��ԡ��������ѵû�ЪҪ�');
		document.form1.v3.focus();
		return false;
	}
	
	if(document.form1.tFirstname.value == "")
	{
		alert('��سҡ�͡�������˹�Ҥ�ͺ����');
		document.form1.tFirstname.focus();
		return false;
	}
	
	if(document.form1.tLastname.value == "")
	{
		alert('��سҡ�͡���ʡ��');
		document.form1.tLastname.focus();
		return false;
	}

	if(document.form1.v14.value == "")
	{
		alert('��سҡ�͡�ӹǹ���� ���� �ѹ�Դ');
		document.form1.v14.focus();
		return false;
	}
	
	

	var result = $('#v3').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
	} else {
		alert('�Ţ�ѵû�ЪҪ�������١��ͧ');
		document.form1.v3.focus();
		return false;
	}
}


$(document).ready(function () {	

/*$('#tbirthday').keydown(function(e){
	var oEvent = (window.event) ? window.event : e; 
			var Obj = document.getElementById('tbirthday');
			if ( Obj.value.length == 2 || Obj.value.length == 5) {
				Obj.value = Obj.value + "/";
			}
});*/

/*----------------------------------------------------------- ત�ѵû�ЪҪ�*/
 $('#idClassCheck').click(function() {
	var result = $('#v3').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
		alert('�Ţ�ѵû�ЪҪ����١��ͧ');
	} else {
		alert('�Ţ�ѵû�ЪҪ�������١��ͧ');
	}
});

$('#random2').click(function() {
	$('#v3').RandomIdCardThai({firstNum: '0'});
 });
 
/*----------------------------------------------------------- ��Ǩ�ͺ����Ţ*/
$(".numberOnly").keydown(function(e){
	if (e.shiftKey) 
           e.preventDefault();
       else 
       {
           var nKeyCode = e.keyCode;
           //Ignore Backspace and Tab keys
           if (nKeyCode == 8 || nKeyCode == 9)
               return;
           if (nKeyCode < 95) 
           {
               if (nKeyCode < 48 || nKeyCode > 57)
                   e.preventDefault();
           }
           else 
           {
               if (nKeyCode < 96 || nKeyCode > 105) 
               e.preventDefault();
           }
       }
});

/*----------------------------------------------------------- �ӹǹ�Ţ㹢�� 16 */
$("#t16_detail input").keyup(function (){
	var tChild = document.getElementById('tChild').value;
	var tDisabled = document.getElementById('tDisabled').value;
	var tMindSick = document.getElementById('tMindSick').value;
	var tSick = document.getElementById('tSick').value;
	var tElderly = document.getElementById('tElderly').value;
	
	if(tChild==''){tChild = 0;}
	if(tDisabled==''){tDisabled = 0;}
	if(tMindSick==''){tMindSick = 0;}
	if(tSick==''){tSick = 0;}
	if(tElderly==''){tElderly = 0;}

	var tDefective = parseInt(tChild)+parseInt(tDisabled)+parseInt(tMindSick)+parseInt(tSick)+parseInt(tElderly);
	$("#tDefective").val(tDefective);
});

/*----------------------------------------------------------- �ӹǹ�Ţ㹢�� 15 */
$("#t15_detail_1 input").keyup(function (){
	var tMemberMale_1 = document.getElementById('tMemberMale_1').value;
	var tMemberFemale_1 = document.getElementById('tMemberFemale_1').value;
	if(tMemberMale_1==''){tMemberMale_1 = 0;}
	if(tMemberFemale_1==''){tMemberFemale_1 = 0;}
	var tMemberFamily_1 = parseInt(tMemberMale_1)+parseInt(tMemberFemale_1);
	$("#tMemberFamily_1").val(tMemberFamily_1);
});

$("#t15_detail_2_1 input").keyup(function (){
	var tMemberMale_2_1 = document.getElementById('tMemberMale_2_1').value;
	var tMemberFemale_2_1 = document.getElementById('tMemberFemale_2_1').value;
	if(tMemberMale_2_1==''){tMemberMale_2_1 = 0;}
	if(tMemberFemale_2_1==''){tMemberFemale_2_1 = 0;}
	var tMemberFamily_2_1 = parseInt(tMemberMale_2_1)+parseInt(tMemberFemale_2_1);
	$("#tMemberFamily_2_1").val(tMemberFamily_2_1);
});

$("#t15_detail_2_2 input").keyup(function (){
	var tMemberMale_2_2 = document.getElementById('tMemberMale_2_2').value;
	var tMemberFemale_2_2 = document.getElementById('tMemberFemale_2_2').value;
	if(tMemberMale_2_2 ==''){tMemberMale_2_2 = 0;}
	if(tMemberFemale_2_2 ==''){tMemberFemale_2_2 = 0;}
	var tMemberFamily_2_2 = parseInt(tMemberMale_2_2)+parseInt(tMemberFemale_2_2);
	$("#tMemberFamily_2_2").val(tMemberFamily_2_2);
});

$("#tSex").attr('disabled','disabled');	
$("#v16").attr('disabled','disabled');
$("#v17").attr('disabled','disabled');
$("#tCareer").attr('disabled','disabled');
$("#tLand").attr('disabled','disabled');
$("#tReligion_1").attr('disabled','disabled');
/*$("#tMemberFamily_1,#tMemberMale_1,#tMemberFemale_1").attr('disabled','disabled');*/
$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
$("#tSpecialFamily_3").attr('disabled','disabled');
//��͹�������á���Թ��к�
$('#t18_2_1_1').hide();
$('#t18_2_1_2').hide();
$('#t18_2_1_3').hide();
$('#t18_2_1_4').hide();
$('#t18_2_1_5').hide();
$('#t18_2_1_6').hide();
$('#t18_2_1_7').hide();
$('#t18_2_1_8').hide();
$('#t18_2_1_9').hide();

/*--------------------- 14 */
$(".rStatus_detail").hide();

/*--------------------- 15 */
$("#rLargeFamily_21,#rLargeFamily_22").attr('disabled','disabled');
$("#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").attr('disabled','disabled');
$(".r15_2").hide();
$(".r15_3").hide();

/*--------------------- 16 */
$('#t16_detail').hide();

/*--------------------- 18 */
$('.t18').hide();
$('#t18_a,#t18_b').hide();
//$('#t18_2_1_1,#t18_2_1_2,#t18_2_1_3,#t18_2_1_4,#t18_2_1_5,#t18_2_1_6,#t18_2_1_7,#t18_2_1_8,#t18_2_1_9').hide();

/*----------------------------------------------------------- �ӹǹ�ѹ�Դ*/
$("#tbirthday").change(function () {
	var result = calAge(document.getElementById('tbirthday').value);
	document.getElementById('v14').value = result[0];
});


$("#v14").keyup(function() {
 var v14 = document.getElementById('v14').value ;
 var tv14 = <?php echo $dt = date('Y') + 543;?> - v14 ;
 var showDate = "01/01/" + tv14 ;
 document.getElementById('tbirthday').value = showDate;
 
});

//��ǹ�ͧ��õ�Ǩ�ͺ���͹䢡��Disabled 
//��Ǩ�ͺ���͹䢡������
$('.rSex').click(function(){
	$("#tSex").attr('disabled','disabled');
	document.getElementById('chkSex').value = 1;
});

$('#etc_1').click(function(){
	$("#tSex").removeAttr('disabled');
});

//��Ǩ�ͺ���͹䢡����������������
$('.v15').click(function(){
	$("#v17").attr('disabled','disabled');
});
$('.v15').click(function(){
	$("#v16").attr('disabled','disabled');
});

$('#v15_2').click(function(){
	$("#v16").removeAttr('disabled');
});
$('#v15_4').click(function(){
	$("#v17").removeAttr('disabled');
});

//��Ǩ�ͺ���͹䢡�����Ҫվ
$('#cCareer10').click(function(){
	if($('#tCareer').attr('disabled')){
		$('#tCareer').removeAttr('disabled')
	}else{
		$('#tCareer').attr('disabled','disabled')
	}
});
$('#cCareer4').click(function(){
	 if($('#cCareer5').attr('disabled')){
		$('#cCareer5,#cCareer6,#cCareer8').removeAttr('disabled')
	}else{
		$('#cCareer5,#cCareer6,#cCareer8').attr('disabled','disabled')
		$('#cCareer5,#cCareer6,#cCareer8').removeAttr('checked')
	}
});
$('#cCareer5').click(function(){
	 if($('#cCareer4').attr('disabled')){
		$('#cCareer4,#cCareer6,#cCareer8').removeAttr('disabled')
	}else{
		$('#cCareer4,#cCareer6,#cCareer8').attr('disabled','disabled')
		$('#cCareer4,#cCareer6,#cCareer8').removeAttr('checked')
	}
});
$('#cCareer6').click(function(){
	 if($('#cCareer4').attr('disabled')){
		$('#cCareer4,#cCareer5,#cCareer8').removeAttr('disabled')
	}else{
		$('#cCareer4,#cCareer5,#cCareer8').attr('disabled','disabled')
		$('#cCareer4,#cCareer5,#cCareer8').removeAttr('checked')
	}
});
$('#cCareer8').click(function(){
	 if($('#cCareer4').attr('disabled')){
		$('#cCareer4,#cCareer6,#cCareer5').removeAttr('disabled')
	}else{
		$('#cCareer4,#cCareer6,#cCareer5').attr('disabled','disabled')
		$('#cCareer4,#cCareer6,#cCareer5').removeAttr('checked')
	}
});

$('.careertable input:not(#cCareer9)').click(function(){
	if($('.careertable input:not(#cCareer9)').is(':checked') == true){
		$('#cCareer9').attr('disabled','disabled')
		$('#cCareer9').removeAttr('checked')
	}
	if($('.careertable input:not(#cCareer9)').is(':checked') == false){
		$('#cCareer9').removeAttr('disabled')
	}
});

$('#cCareer9').click(function(){
		 if($('.careertable input:not(#cCareer9)').attr('disabled')){ //�����
			$('.careertable input:not(#cCareer9,#tCareer)').removeAttr('disabled')
		 }else{
			$('.careertable input:not(#cCareer9)').attr('disabled','disabled')
			$('.careertable input:not(#cCareer9)').removeAttr('checked')
		}
		

});

//��Ǩ�ͺ���͹䢡�������Թ
$('.rLand_1').click(function(){
	$("#tLand").attr('disabled','disabled');
});

$('#rLand').click(function(){
	$("#tLand").removeAttr('disabled');
});
//��Ǩ�ͺ���͹䢡������ʹ�
$('.rReligion').click(function(){
	$("#tReligion_1").attr('disabled','disabled');
});
$('.rReligion_1').click(function(){
	$("#tReligion_1").removeAttr('disabled');
});

//��Ǩ�ͺ���͹���ҹ�Ҿ����
$('.rStatus').click(function(){
	$(".rStatus_detail").hide();
});

$('#rStatus_5').click(function(){
	$(".rStatus_detail").show();
});

//------------------------------------------------ 16
$('#rDefective_1').click(function(){
	$('#t16_detail').hide();
});

$('#rDefective_2').click(function(){
	$('#t16_detail').show();
});

//------------------------------------------------ 17
$("#t17 input").keyup(function () {
	
	var tChildMale = document.getElementById('tChildMale').value;
	var tChildFemale = document.getElementById('tChildFemale').value;
	if(tChildMale==''){tChildMale = 0;}
	if(tChildFemale==''){tChildFemale = 0;}
	var tChildTotal = parseInt(tChildMale)+parseInt(tChildFemale);
	 document.getElementById('tChildTotal').value = tChildTotal;
	//$("#tChildTotal").val(tChildTotal);
	
	var tTeensMale = document.getElementById('tTeensMale').value;
	var tTeensFemale = document.getElementById('tTeensFemale').value;
	if(tTeensMale==''){tTeensMale = 0;}
	if(tTeensFemale==''){tTeensFemale = 0;}
	var tTeensTotal = parseInt(tTeensMale)+parseInt(tTeensFemale);
	document.getElementById('tTeensTotal').value = tTeensTotal;
	//$("#tTeensTotal").val(tTeensTotal);
	
	var tMan = document.getElementById('tMan').value;
	var tWoman = document.getElementById('tWoman').value;
	if(tMan==''){tMan = 0;}
	if(tWoman==''){tWoman = 0;}
	var tTotal = parseInt(tMan)+parseInt(tWoman);
	document.getElementById('tTotal').value = tTotal;
	//$("#tTotal").val(tTotal);
	
	var tElderMale = document.getElementById('tElderMale').value;
	var tElderFemale = document.getElementById('tElderFemale').value;
	if(tElderMale==''){tElderMale = 0;}
	if(tElderFemale==''){tElderFemale = 0;}
	var tElderTotal = parseInt(tElderMale)+parseInt(tElderFemale);
	document.getElementById('tElderTotal').value = tElderTotal;
	//$("#tElderTotal").val(tElderTotal);
	
	var tDisabledMale = document.getElementById('tDisabledMale').value;
	var tDisabledFemale = document.getElementById('tDisabledFemale').value;
	if(tDisabledMale==''){tDisabledMale = 0;}
	if(tDisabledFemale==''){tDisabledFemale = 0;}
	var tDisabledTotal = parseInt(tDisabledMale)+parseInt(tDisabledFemale);
	document.getElementById('tDisabledTotal').value = tDisabledTotal;
	//$("#tDisabledTotal").val(tDisabledTotal);

	var tMaleTotal = parseInt(tChildMale)+parseInt(tTeensMale)+parseInt(tMan)+parseInt(tElderMale)+parseInt(tDisabledMale);
	var tFemaleTotal = parseInt(tChildFemale)+parseInt(tTeensFemale)+parseInt(tWoman)+parseInt(tElderFemale)+parseInt(tDisabledFemale);
	var tSumTotal = parseInt(tMaleTotal)+parseInt(tFemaleTotal);
	
	document.getElementById('tMaleTotal').value = tMaleTotal;
	document.getElementById('tFemaleTotal').value = tFemaleTotal;
	document.getElementById('tSumTotal').value = tSumTotal;
	//$("#tMaleTotal").val(tMaleTotal);
	//$("#tFemaleTotal").val(tFemaleTotal);
	//$("#tSumTotal").val(tSumTotal);
});

//���͹䢡������ͺ����
//////////////////////////��Ǩ�ͺ���͹䢡������ͺ���������
$('.rStructureFamily').click(function(){
	$(					"#rLargeFamily_21,#rLargeFamily_22,#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").attr('disabled','disabled');
});
$('.rStructureFamily').click(function(){
	$("#tMemberFamily_1,#tMemberMale_1,#tMemberFemale_1").removeAttr('disabled');
});
$('.rStructureFamily').click(function(){
	$("#rLargeFamily_21,#rLargeFamily_22").removeAttr('checked');
});
$('.rStructureFamily').click(function(){
	$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
});

$('.rStructureFamily').click(function(){
	$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
});
$('.rStructureFamily').click(function(){
	$("#tSpecialFamily_3").attr('disabled','disabled');
});
$('.rStructureFamily').click(function(){
	$("#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").removeAttr('checked');
});

/////////////////////////////��Ǩ�ͺ���͹䢡������ͺ���Ǣ���
$('.rLargeFamily').click(function(){
	$("#tMemberFamily_1,#tMemberMale_1,#tMemberFemale_1,#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").attr('disabled','disabled');
});

$('.rLargeFamily').click(function(){
	$("#rLargeFamily_21,#rLargeFamily_22").removeAttr('disabled');
});

$('.rLargeFamily_23').click(function(){
	$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").removeAttr('disabled');
});
$('.rLargeFamily_24').click(function(){
	$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").removeAttr('disabled');
});
$('.rLargeFamily_24').click(function(){
	$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
});
$('.rLargeFamily_23').click(function(){
	$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
});
$('.rLargeFamily').click(function(){
	$("#tSpecialFamily_3").attr('disabled','disabled');
});
$('.rLargeFamily').click(function(){
	$("#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").removeAttr('checked');
});

///////////////////////////////////��Ǩ�ͺ���͹䢻�����ͺ���Ǿ����
$('.rSpecialFamily').click(function(){
	$("#rLargeFamily_21,#rLargeFamily_22,#tMemberFamily_1,#tMemberMale_1,#tMemberFemale_1").attr('disabled','disabled');
});
$('.rSpecialFamily').click(function(){
	$("#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").removeAttr('disabled');	
});
$('.rSpecialFamily').click(function(){
	$("#rLargeFamily_21,#rLargeFamily_22").removeAttr('checked');
});
$('.rSpecialFamily').click(function(){
	$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
});
$('.rSpecialFamily').click(function(){
	$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
});
$('.rSpecialFamily_6').click(function(){
	$("#tSpecialFamily_3").removeAttr('disabled');
});
$('#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5').click(function(){
	$("#tSpecialFamily_3").attr('disabled','disabled');
});

/*------------------------------------ ��Ǩ�ͺ��͹��ͤ��� r15_2 r15_3 rStructureFamily rLargeFamily rSpecialFamily*/ 
$('#rStructureFamily').click(function(){
	$(".r15_2").hide();
	$(".r15_3").hide();
});

$('#rLargeFamily').click(function(){
	$(".r15_2").show();
	$(".r15_3").hide();
});

$('#rSpecialFamily').click(function(){
	$(".r15_2").hide();
	$(".r15_3").show();
});

//------------------------------------------------ 18 rDebt_1
	if($('#rDebt_1').is(':checked') == true){
		$('#t18_a').hide();
		$('#t18_b').hide();
		$('.t18').hide();
	}

$('#rDebt_1').click(function(){
	$('.t18').hide();
})

$('#rDebt_2').click(function(){
	$('.t18').show();
	//$('#rDebt_a').arr('checked',true);
	document.getElementById('rDebt_a').checked = true;
})

$('#rDebt_a').click(function(){
	$('#t18_a').show();
	$('#t18_b').hide();
})
$('#rDebt_b').click(function(){
	$('#t18_a').hide();//prop
	$('#t18_b').show();
})
//����Թ��к���й͡�к�
 if($('.t18 input:not(#rDebt_a)').is(':checked') == true){
	 $('.t21').hide();
 }
 if($('.t18 input:not(#rDebt_b)').is(':checked') == true){
	 $('.t22').hide();
 }
//�Թ��鸹Ҥ��
$('#2_2_1').click(function(){
	if($('#2_2_1').attr('checked')){
		$('#t18_2_1_1').show();
	}
	else{
		$('#t18_2_1_1').hide();
	}
})
//�Թ���ͧ�ع�Ѩ��������Ѿ��
$('#2_2_2').click(function(){
	if($('#2_2_2').attr('checked')){
		$('#t18_2_1_2').show();
	}
	else{
		$('#t18_2_1_2').hide();
	}
})
//�Թ���ͧ�ع�����ҹ
$('#2_2_3').click(function(){
	if($('#2_2_3').attr('checked')){
		$('#t18_2_1_3').show();
	}
	else{
		$('#t18_2_1_3').hide();
	}
})
//�ͧ�ع�Ѳ�Һ��ҷʵ��
$('#2_2_4').click(function(){
	if($('#2_2_4').attr('checked')){
		$('#t18_2_1_4').show();
	}
	else{
		$('#t18_2_1_4').hide();
	}
})
//�ͧ�ع����٧����
$('#2_2_5').click(function(){
	if($('#2_2_5').attr('checked')){
		$('#t18_2_1_5').show();
	}
	else{
		$('#t18_2_1_5').hide();
	}
})
//�ͧ�ع��������Ѳ�Ҥس�Ҿ���Ե���ԡ��
$('#2_2_6').click(function(){
	if($('#2_2_6').attr('checked')){
		$('#t18_2_1_6').show();
	}
	else{
		$('#t18_2_1_6').hide();
	}
})
//�ͧ�ع����
$('#2_2_7').click(function(){
	if($('#2_2_7').attr('checked')){
		$('#t18_2_1_7').show();
	}
	else{
		$('#t18_2_1_7').hide();
	}
})
//�ͧ�ع�ɵ�
$('#2_2_8').click(function(){
	if($('#2_2_8').attr('checked')){
		$('#t18_2_1_8').show();
	}
	else{
		$('#t18_2_1_8').hide();
	}
})
//�����к�
$('#2_2_9').click(function(){
	if($('#2_2_9').attr('checked')){
		$('#t18_2_1_9').show();
	}
	else{
		$('#t18_2_1_9').hide();
	}
})
//�кءͧ�ع����������
$('#2_2_9').click(function(){
	if($('#2_2_9').attr('checked')){
		$('#t21_other').removeAttr('disabled');;
	}
	else{
		$('#t21_other').attr('disabled','disabled');
	}
})

});
    
</script> 

