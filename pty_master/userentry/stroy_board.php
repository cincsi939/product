
<html>
<head>
<title>�ͺ���¡�úѹ�֡������ �.�.7 ���Ѻ�����</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">
function confirmDelete(delUrl) {
//  if (confirm("�س��㨷���ź������ cmss ��ԧ�������")) {
//  window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
    //document.location = delUrl;
	//document.location =  
	window.open(delUrl,null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
 // }
}

function confirmDelete1(delUrl) {
  if (confirm("�س��㨷���ź���������������?")) {
  //window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
    document.location = delUrl;
  }
}

</script>

<SCRIPT language=JavaScript>
function checkFields() {
	missinginfo1 = "";
	missinginfo = "";
	if (document.form1.staffname.value == "")  {	missinginfo1 += "\n- ��ͧ���� �������ö�繤����ҧ"; }		
	if (document.form1.staffsurname.value == "")  {	missinginfo1 += "\n- ��ͧ���ʡ�� �������ö�繤����ҧ"; }		
	if (document.form1.engname.value == "")  {	missinginfo1 += "\n- ��ͧ����(�ѧ���) �������ö�繤����ҧ"; }		
	if (document.form1.engsurname.value == "")  {	missinginfo1 += "\n- ��ͧ���ʡ��(�ѧ���) �������ö�繤����ҧ"; }		
	if (missinginfo1 != "") { 
		missinginfo += "�������ö������������  ���ͧ�ҡ \n";
		missinginfo +="_____________________________\n";
		missinginfo = missinginfo + missinginfo1  ;
		missinginfo += "\n___________________________";
		missinginfo += "\n��سҵ�Ǩ�ͺ �ա����";
		alert(missinginfo);
		return false;
		}
	}
	
	
	
	
	
	/////////////////////  ajax
	
	
var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}
    
	
function refreshproductList() {
   var sent_siteid = document.getElementById("sent_siteid").value;
    if(sent_siteid == "" ) {
        clearproductList();
        return;
    }
    var url = "ajax_school.php?sent_siteid=" + sent_siteid;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStateChange;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}
    
function handleStateChange() {
    if(xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            updateproductList();
        }
    }
}

function updateproductList() {
    clearproductList();
    var schoolid = document.getElementById("schoolid");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
		
			option = document.createElement("option");
		   option.setAttribute("value",0);
           option.appendChild(document.createTextNode("����к�"));
           schoolid.appendChild(option);


    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
		  	option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           schoolid.appendChild(option);
	}
    }
}

function clearproductList() {
    var schoolid = document.getElementById("schoolid");
    while(schoolid.childNodes.length > 0) {
              schoolid.removeChild(schoolid.childNodes[0]);
    }
}

</script>
<script language="javascript">

	function checkFm(){
		var age1 = document.form_m1.age_g1.value;
		var age2 = document.form_m1.age_g2.value;
		
		
	if(age1 > 0 && age2 > 0){ // 㹡óդ��Ҫ�ǧ�����Ҫ��� 
		if(age1 > age2){
			alert("�����Ҫ�������ش��ͧ�����¡��������Ҫ����������");
			document.form_m1.age_g2.focus();
			return false;
		}
	}
return true;		
	}

	function check_number(){
		var num1 = document.form_m1.person_no.value;
	 if (isNaN(num1)) {
      alert("��س��к�੾�е���Ţ��ҹ��");
      document.form_m1.person_no.focus();
      return false;
      }

		
	}
</script>
<style type="text/css">
<!--
.style1 {
	color: #990000;
	font-style: italic;
}
-->
</style>
</head>
<body bgcolor="#EFEFFF">

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="fillcolor">
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td width="17%"  bgcolor="#FFFFFF" align=center style="border-right: solid 1 white;"><A HREF="assign_list.php?action=assign_key&smode=&staffid=11560&TicketId=&profile_id=8"><strong><U style="color:BLACK;">���ҧ��¡�����к�</U></strong></A></td>
              <td width="24%"  bgcolor="#000066" align=center style="border-right: solid 1 white;"><A HREF="assign_list.php?action=assign_key&smode=1&staffid=11560&TicketId=&profile_id=8"><strong><U style="color:white;"> ���ҧ㺨��§ҹ��͹��ѧ</U></strong></A></td>
              <td width="28%" bgcolor="#000066" align="center" style="border-right:solid 1 white;"><a href="assign_list.php?action=assign_key&smode=extraW&staffid=11560&TicketId=&profile_id=8"><strong><U style="color:white;"> ���ҧ㺧ҹ����ѻ����</U></strong></a></td>
			<!-- <td width="34%"  bgcolor="#000066" align=center style="border-right: solid 1 white;"><A HREF="assign_list.php?action=assign_key&smode=2&staffid=11560&TicketId="><strong><U style="color:white;"> �к���͹䢢���٧</U></strong></A></td>-->
			 <td width="31%">&nbsp;</td>
            </tr>
      </table>	</td>
  </tr>
  
   
  
      <form name="form_m1" method="post" action="" onSubmit="return checkFm();">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td colspan="4" align="left" bgcolor="#FFFFFF"><strong>������ѹ�֡����ͺ���§ҹ�ͧ
            �ҧ��Ǿ���� �ѹ���        </strong></td>
        </tr>
      <tr>
        <td width="20%" align="left" bgcolor="#FFFFFF"><strong>�����Ҫ���</strong></td>
        <td width="27%" align="left" bgcolor="#FFFFFF"><strong>
          <label>
          <select name="age_g1" id="age_g1" >
		  <option value=""> - ����к� - </option>
		  <option value='15' >15</option><option value='16' >16</option><option value='17' >17</option><option value='18' >18</option><option value='19' >19</option><option value='20' >20</option><option value='21' >21</option><option value='22' >22</option><option value='23' >23</option><option value='24' >24</option><option value='25' >25</option><option value='26' >26</option><option value='27' >27</option><option value='28' >28</option><option value='29' >29</option><option value='30' >30</option><option value='31' >31</option><option value='32' >32</option><option value='33' >33</option><option value='34' >34</option><option value='35' >35</option><option value='36' >36</option><option value='37' >37</option><option value='38' >38</option><option value='39' >39</option><option value='40' >40</option><option value='41' >41</option><option value='42' >42</option><option value='43' >43</option><option value='44' >44</option><option value='45' >45</option>          </select>
            </label>
        </strong></td>
        <td width="16%" align="left" bgcolor="#FFFFFF"><strong>�֧</strong></td>
        <td width="37%" align="left" bgcolor="#FFFFFF"><strong>
          <label>
          <select name="age_g2" id="age_g2" >
		  <option value=""> - ����к� -</option>
		  <option value='15' >15</option><option value='16' >16</option><option value='17' >17</option><option value='18' >18</option><option value='19' >19</option><option value='20' >20</option><option value='21' >21</option><option value='22' >22</option><option value='23' >23</option><option value='24' >24</option><option value='25' >25</option><option value='26' >26</option><option value='27' >27</option><option value='28' >28</option><option value='29' >29</option><option value='30' >30</option><option value='31' >31</option><option value='32' >32</option><option value='33' >33</option><option value='34' >34</option><option value='35' >35</option><option value='36' >36</option><option value='37' >37</option><option value='38' >38</option><option value='39' >39</option><option value='40' >40</option><option value='41' >41</option><option value='42' >42</option><option value='43' >43</option><option value='44' >44</option><option value='45' >45</option>          </select>
            </label>
        </strong></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#FFFFFF"><strong>�ӹǹ��</strong></td>
        <td align="left" bgcolor="#FFFFFF"><strong>
          <label>
          <input name="person_no" type="text" id="person_no" size="15" value=""  onBlur="return check_number(this);" >
          </label>
        </strong></td>
        <td align="left" bgcolor="#FFFFFF"><strong>ࢵ��鹷�����֡��</strong></td>
        <td align="left" bgcolor="#FFFFFF">
		
		<select name="sent_siteid" id="sent_siteid" onChange="refreshproductList();">
                        <option value=""> - ���͡ࢵ��鹷�����֡�� - </option>
            <option value='7101' >ʾ�.��ж��֡�ҡҭ������ ࢵ 1</option><option value='7102' >ʾ�.��ж��֡�ҡҭ������ ࢵ 2</option><option value='7103' >ʾ�.��ж��֡�ҡҭ������ ࢵ 3</option><option value='4001' >ʾ�.��ж��֡�Ң͹�� ࢵ 1</option><option value='4005' >ʾ�.��ж��֡�Ң͹�� ࢵ 5</option><option value='1801' >ʾ�.��ж��֡�Ҫ�¹ҷ</option><option value='8602' >ʾ�.��ж��֡�Ҫ���� ࢵ 2</option><option value='5701' >ʾ�.��ж��֡����§��� ࢵ 1</option><option value='5704' >ʾ�.��ж��֡����§��� ࢵ 4</option><option value='5001' >ʾ�.��ж��֡����§���� ࢵ 1</option><option value='5002' >ʾ�.��ж��֡����§���� ࢵ 2</option><option value='5003' >ʾ�.��ж��֡����§���� ࢵ 3</option><option value='5004' >ʾ�.��ж��֡����§���� ࢵ 4</option><option value='5005' >ʾ�.��ж��֡����§���� ࢵ 5</option><option value='5006' >ʾ�.��ж��֡����§���� ࢵ 6</option><option value='6301' >ʾ�.��ж��֡�ҵҡ ࢵ 1</option><option value='6302' >ʾ�.��ж��֡�ҵҡ ࢵ 2</option><option value='7301' >ʾ�.��ж��֡�ҹ�û�� ࢵ 1</option><option value='7302' >ʾ�.��ж��֡�ҹ�û�� ࢵ 2</option><option value='4802' >ʾ�.��ж��֡�ҹ�þ�� ࢵ 2</option><option value='6002' >ʾ�.��ж��֡�ҹ�����ä� ࢵ 2</option><option value='5501' >ʾ�.��ж��֡�ҹ�ҹ ࢵ 1</option><option value='3801' >ʾ�.��ж��֡�Һ֧���</option><option value='7702' >ʾ�.��ж��֡�һ�ШǺ���բѹ�� ࢵ 2</option><option value='5601' >ʾ�.��ж��֡�Ҿ���� ࢵ 1</option><option value='6601' >ʾ�.��ж��֡�ҾԨԵ� ࢵ 1</option><option value='6502' >ʾ�.��ж��֡�Ҿ�ɳ��š ࢵ 2</option><option value='6701' >ʾ�.��ж��֡��ྪú�ó� ࢵ 1</option><option value='6702' >ʾ�.��ж��֡��ྪú�ó� ࢵ 2</option><option value='4403' >ʾ�.��ж��֡�������ä�� ࢵ 3</option><option value='2101' >ʾ�.��ж��֡�����ͧ ࢵ 1</option><option value='5201' >ʾ�.��ж��֡���ӻҧ ࢵ 1</option><option value='5202' >ʾ�.��ж��֡���ӻҧ ࢵ 2</option><option value='5101' >ʾ�.��ж��֡���Ӿٹ ࢵ 1</option><option value='5102' >ʾ�.��ж��֡���Ӿٹ ࢵ 2</option><option value='3301' >ʾ�.��ж��֡��������� ࢵ 1</option><option value='3302' >ʾ�.��ж��֡��������� ࢵ 2</option><option value='3303' >ʾ�.��ж��֡��������� ࢵ 3</option><option value='3304' >ʾ�.��ж��֡��������� ࢵ 4</option><option value='6402' >ʾ�.��ж��֡����⢷�� ࢵ 2</option><option value='7203' >ʾ�.��ж��֡���ؾ�ó���� ࢵ 3</option><option value='8401' >ʾ�.��ж��֡������ɮ��ҹ� ࢵ 1</option><option value='4101' >ʾ�.��ж��֡���شøҹ� ࢵ 1</option><option value='4102' >ʾ�.��ж��֡���شøҹ� ࢵ 2</option><option value='5301' >ʾ�.��ж��֡���صôԵ�� ࢵ 1</option><option value='6102' >ʾ�.��ж��֡���ط�¸ҹ� ࢵ 2</option><option value='3404' >ʾ�.��ж��֡���غ��Ҫ�ҹ� ࢵ 4</option><option value='3405' >ʾ�.��ж��֡���غ��Ҫ�ҹ� ࢵ 5</option>          </select>		</td>
      </tr>
      <tr>
        <td colspan="4" align="center" bgcolor="#FFFFFF"><span class="style1">�����˵�* ��ҷ�ҹ������͡��ǧ�����Ҫ����к��зӡ�ä��Һؤ�ҡ�÷���������Ҫ��õ���� 15 �բ��� </span></td>
      </tr>
      <tr>
        <td colspan="4" align="center" bgcolor="#FFFFFF"><label>
        <input type="hidden" name="profile_id" value="8">
		<input type="hidden" name="xsearch" value="search1">
          <input type="submit" name="Submit3" value="����" >
        </label></td>
        </tr>
    </table></td>
  </tr>
  </form>
 	  
    </table>
	
	</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
      <form name="form5" method="post" action="">
  <tr><td align="center" bgcolor="#000000">
  <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr>
          <td colspan="8" align="center" bgcolor="#A3B2CC"><table width="100%" border="0" cellspacing="0" cellpadding="3">
		              <tr>
              <td width="18%" align="left"><strong>ʶҹ�����������</strong></td>
              <td width="82%" align="left"><label><input name="localtion_key" type="radio" value="IN" checked='checked' >
              �ѹ�֡�����Ţ�ҧ㹺���ѷ
                <input name="localtion_key" type="radio" value="OUT" >
                ��������Ţ�ҧ�͡����ѷ
                </label></td>
            </tr>
				            <tr>
              <td align="left"><strong>&nbsp;��ͧ����ҹ��ͫ�����</strong></td>
              <td align="left"><INPUT name="c_date" onFocus="blur();" value="23/04/2555" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form5.c_date, 'dd/mm/yyyy')"value="�ѹ��͹��">			</td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td width="6%" align="center" bgcolor="#A3B2CC"><strong>���͡��¡��</strong></td>
          <td width="12%" align="center" bgcolor="#A3B2CC"><strong>���ʻ�Шӵ�ǻ�ЪҪ�</strong></td>
          <td width="12%" align="center" bgcolor="#A3B2CC"><strong>���� - ���ʡ�� </strong></td>
          <td width="35%" align="center" bgcolor="#A3B2CC"><strong>˹��§ҹ�ѧ�Ѵ</strong></td>
          <td width="15%" align="center" bgcolor="#A3B2CC"><strong>���˹�</strong></td>
          <td width="6%" align="center" bgcolor="#A3B2CC"><strong>�����Ҫ���</strong></td>
          <td width="9%" align="center" bgcolor="#A3B2CC"><strong>�ӹǹ�ٻ/�ӹǹ��</strong></td>
          <td width="5%" align="center" bgcolor="#A3B2CC"><strong>PDF</strong></td>
          </tr>
		         <tr bgcolor="#FFFFFF">
          <td align="center" bgcolor="#FF9900">1<input type="checkbox" name="xidcard[3100100714742]" value="3100100714742" checked="checked" > 
            <input type="hidden" name="xsiteid[3100100714742]" value="1801">
             <input type="hidden" name="xstatus_file[3100100714742]" value="1">            </td>
          <td align="center" bgcolor="#FF9900">3100100714742</td>
          <td align="left" bgcolor="#FF9900">�ҧ���Ե��  �ѡ�ت <input type="hidden" name="fullname[3100100714742]" value="�ҧ���Ե��  �ѡ�ت "></td>
          <td align="left" bgcolor="#FF9900">ʾ�.��§����ࢵ 1/�ç���¹�������</td>
          <td align="left" bgcolor="#FF9900">����ӹ�¡��ʶҹ�֡��</td>
          <td align="center" bgcolor="#FF9900">24</td>
          <td align="center" bgcolor="#FF9900">3/8</td>
          <td align="center" bgcolor="#FF9900"><a href="../../../edubkk_kp7file/1801/3100100714742.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center" bgcolor="#FF9900">2<input type="checkbox" name="xidcard[3100100714769]" value="3100100714769" checked="checked" > 
            <input type="hidden" name="xsiteid[3100100714769]" value="1801">
             <input type="hidden" name="xstatus_file[3100100714769]" value="1">            </td>
          <td align="center" bgcolor="#FF9900">3100100714769</td>
          <td align="left" bgcolor="#FF9900">�����ҹ  �ѡ�ت <input type="hidden" name="fullname[3100100714769]" value="�����ҹ  �ѡ�ت "></td>
          <td align="left" bgcolor="#FF9900">ʾ�.��§����ࢵ 1/ʾ�.��§����ࢵ 1</td>
          <td align="left" bgcolor="#FF9900">���˹�ҷ�����������º�����Ἱ</td>
          <td align="center" bgcolor="#FF9900">24</td>
          <td align="center" bgcolor="#FF9900">2/7</td>
          <td align="center" bgcolor="#FF9900"><a href="../../../edubkk_kp7file/1801/3100100714769.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center" bgcolor="#FF9900">3<input type="checkbox" name="xidcard[3100200898641]" value="3100200898641" checked="checked" > 
            <input type="hidden" name="xsiteid[3100200898641]" value="1801">
             <input type="hidden" name="xstatus_file[3100200898641]" value="1">            </td>
          <td align="center" bgcolor="#FF9900">3100200898641</td>
          <td align="left" bgcolor="#FF9900">��¸�ѷ���  ����ô <input type="hidden" name="fullname[3100200898641]" value="��¸�ѷ���  ����ô "></td>
          <td align="left" bgcolor="#FF9900">ʾ�.��§����ࢵ 1/�ç���¹�Ѵ˹ͧ��Ҥ���</td>
          <td align="left" bgcolor="#FF9900">����ӹ�¡��ʶҹ�֡��</td>
          <td align="center" bgcolor="#FF9900">29</td>
          <td align="center" bgcolor="#FF9900">2/6</td>
          <td align="center" bgcolor="#FF9900"><a href="../../../edubkk_kp7file/1801/3100200898641.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center">4<input type="checkbox" name="xidcard[3100202201027]" value="3100202201027" checked="checked" > 
            <input type="hidden" name="xsiteid[3100202201027]" value="1801">
             <input type="hidden" name="xstatus_file[3100202201027]" value="1">            </td>
          <td align="center">3100202201027</td>
          <td align="left">�ҧ�ͺ�Ծ��  �ԧ���ç�� <input type="hidden" name="fullname[3100202201027]" value="�ҧ�ͺ�Ծ��  �ԧ���ç�� "></td>
          <td align="left">ʾ�.��§����ࢵ 1/�ç���¹�Ѵ�͹���</td>
          <td align="left">���</td>
          <td align="center">24</td>
          <td align="center">2/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100202201027.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center">5<input type="checkbox" name="xidcard[3100202694759]" value="3100202694759" checked="checked" > 
            <input type="hidden" name="xsiteid[3100202694759]" value="1801">
             <input type="hidden" name="xstatus_file[3100202694759]" value="1">            </td>
          <td align="center">3100202694759</td>
          <td align="left">��¨��֡  �������� <input type="hidden" name="fullname[3100202694759]" value="��¨��֡  �������� "></td>
          <td align="left">ʾ�.��§����ࢵ 1/�ç���¹�Ѵ˹ͧ��Ҥ���</td>
          <td align="left">���</td>
          <td align="center">31</td>
          <td align="center">2/7</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100202694759.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center" bgcolor="#FFFFFF">6<input type="checkbox" name="xidcard[3100400867056]" value="3100400867056" checked="checked" > 
            <input type="hidden" name="xsiteid[3100400867056]" value="1801">
             <input type="hidden" name="xstatus_file[3100400867056]" value="1">            </td>
          <td align="center" bgcolor="#FFFFFF">3100400867056</td>
          <td align="left" bgcolor="#FFFFFF">�ҧ����  ��Сͺ�Ԩ������ <input type="hidden" name="fullname[3100400867056]" value="�ҧ����  ��Сͺ�Ԩ������ "></td>
          <td align="left" bgcolor="#FFFFFF">ʾ�.��§����ࢵ 1/�ç���¹�Ѵ˹ͧ��Ҥ���</td>
          <td align="left" bgcolor="#FFFFFF">���</td>
          <td align="center" bgcolor="#FFFFFF">36</td>
          <td align="center" bgcolor="#FFFFFF">0/8</td>
          <td align="center" bgcolor="#FFFFFF"><a href="../../../edubkk_kp7file/1801/3100400867056.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center">7<input type="checkbox" name="xidcard[3100500696342]" value="3100500696342" checked="checked" > 
            <input type="hidden" name="xsiteid[3100500696342]" value="1801">
             <input type="hidden" name="xstatus_file[3100500696342]" value="1">            </td>
          <td align="center">3100500696342</td>
          <td align="left">�ҧ���Ե��  ��µ�С�� <input type="hidden" name="fullname[3100500696342]" value="�ҧ���Ե��  ��µ�С�� "></td>
          <td align="left">ʾ�.��§����ࢵ 1/�ç���¹�Ѵ˹ͧ��Ҥ���</td>
          <td align="left">���</td>
          <td align="center">28</td>
          <td align="center">2/7</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100500696342.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center">8<input type="checkbox" name="xidcard[3100502913693]" value="3100502913693" checked="checked" > 
            <input type="hidden" name="xsiteid[3100502913693]" value="1801">
             <input type="hidden" name="xstatus_file[3100502913693]" value="1">            </td>
          <td align="center">3100502913693</td>
          <td align="left">��ºح��  �Ծ���ԧ�� <input type="hidden" name="fullname[3100502913693]" value="��ºح��  �Ծ���ԧ�� "></td>
          <td align="left" bgcolor="#FFFFFF">ʾ�.��§����ࢵ 1/�ç���¹�������ҹ�ǡ�á����</td>
          <td align="left">���</td>
          <td align="center">34</td>
          <td align="center">1/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100502913693.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center">9<input type="checkbox" name="xidcard[3100600746473]" value="3100600746473" checked="checked" > 
            <input type="hidden" name="xsiteid[3100600746473]" value="1801">
             <input type="hidden" name="xstatus_file[3100600746473]" value="1">            </td>
          <td align="center">3100600746473</td>
          <td align="left">������Թ���  ����Ժ�ó쾧�� <input type="hidden" name="fullname[3100600746473]" value="������Թ���  ����Ժ�ó쾧�� "></td>
          <td align="left">ʾ�.��§����ࢵ 1/�ç���¹�������ҹ�ǡ�á����</td>
          <td align="left">���</td>
          <td align="center">28</td>
          <td align="center">2/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100600746473.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center">10<input type="checkbox" name="xidcard[3100600821971]" value="3100600821971" checked="checked" > 
            <input type="hidden" name="xsiteid[3100600821971]" value="1801">
             <input type="hidden" name="xstatus_file[3100600821971]" value="1">            </td>
          <td align="center">3100600821971</td>
          <td align="left">�ҧ�ѭ��ѵ��  �ز���� <input type="hidden" name="fullname[3100600821971]" value="�ҧ�ѭ��ѵ��  �ز���� "></td>
          <td align="left">ʾ�.��§����ࢵ 1/�ç���¹�������ҹ�ǡ�á����</td>
          <td align="left">���</td>
          <td align="center">19</td>
          <td align="center">2/7</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100600821971.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center">11<input type="checkbox" name="xidcard[3100601689252]" value="3100601689252" checked="checked" > 
            <input type="hidden" name="xsiteid[3100601689252]" value="1801">
             <input type="hidden" name="xstatus_file[3100601689252]" value="1">            </td>
          <td align="center">3100601689252</td>
          <td align="left">�ҧ����Ѫ����ó  ������ <input type="hidden" name="fullname[3100601689252]" value="�ҧ����Ѫ����ó  ������ "></td>
          <td align="left">ʾ�.��§����ࢵ 1/�ç���¹�������ҹ�ǡ�á����</td>
          <td align="left">���</td>
          <td align="center">27</td>
          <td align="center">3/7</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100601689252.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center">12<input type="checkbox" name="xidcard[3100601697999]" value="3100601697999" checked="checked" > 
            <input type="hidden" name="xsiteid[3100601697999]" value="1801">
             <input type="hidden" name="xstatus_file[3100601697999]" value="1">            </td>
          <td align="center">3100601697999</td>
          <td align="left">�ҧ�ѵ��  �������� <input type="hidden" name="fullname[3100601697999]" value="�ҧ�ѵ��  �������� "></td>
          <td align="left" bgcolor="#FFFFFF">ʾ�.��§����ࢵ 1/�ç���¹�������ҹ�ǡ�á����</td>
          <td align="left">���</td>
          <td align="center">25</td>
          <td align="center">2/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100601697999.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center">13<input type="checkbox" name="xidcard[3100602259472]" value="3100602259472" checked="checked" > 
            <input type="hidden" name="xsiteid[3100602259472]" value="1801">
             <input type="hidden" name="xstatus_file[3100602259472]" value="1">            </td>
          <td align="center">3100602259472</td>
          <td align="left">�ҧ��Ե�  �Թ������ͧ <input type="hidden" name="fullname[3100602259472]" value="�ҧ��Ե�  �Թ������ͧ "></td>
          <td align="left">ʾ�.��§����ࢵ 1/�ç���¹�Ѵ����Թ</td>
          <td align="left">���</td>
          <td align="center">29</td>
          <td align="center">6/7</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100602259472.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center">14<input type="checkbox" name="xidcard[3100603210612]" value="3100603210612" checked="checked" > 
            <input type="hidden" name="xsiteid[3100603210612]" value="1801">
             <input type="hidden" name="xstatus_file[3100603210612]" value="1">            </td>
          <td align="center">3100603210612</td>
          <td align="left">�ҧ����  ⾸���� <input type="hidden" name="fullname[3100603210612]" value="�ҧ����  ⾸���� "></td>
          <td align="left">ʾ�.��§����ࢵ 1/�ç���¹�Ѵ����Թ</td>
          <td align="left">���</td>
          <td align="center">33</td>
          <td align="center">2/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100603210612.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center">15<input type="checkbox" name="xidcard[3100903523772]" value="3100903523772" checked="checked" > 
            <input type="hidden" name="xsiteid[3100903523772]" value="1801">
             <input type="hidden" name="xstatus_file[3100903523772]" value="1">            </td>
          <td align="center">3100903523772</td>
          <td align="left">��»ҹ෾  �ҹ��� <input type="hidden" name="fullname[3100903523772]" value="��»ҹ෾  �ҹ��� "></td>
          <td align="left">ʾ�.��§����ࢵ 1/�ç���¹�Ѵ����Թ</td>
          <td align="left">���</td>
          <td align="center">19</td>
          <td align="center">1/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100903523772.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center">16<input type="checkbox" name="xidcard[3101400457576]" value="3101400457576" checked="checked" > 
            <input type="hidden" name="xsiteid[3101400457576]" value="1801">
             <input type="hidden" name="xstatus_file[3101400457576]" value="1">            </td>
          <td align="center">3101400457576</td>
          <td align="left">�ҧ��ǻ�о����  ���¹� <input type="hidden" name="fullname[3101400457576]" value="�ҧ��ǻ�о����  ���¹� "></td>
          <td align="left">ʾ�.��§����ࢵ 1/�ç���¹�Ѵ����Թ</td>
          <td align="left">���</td>
          <td align="center">26</td>
          <td align="center">3/6</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3101400457576.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center">17<input type="checkbox" name="xidcard[3101400508588]" value="3101400508588" checked="checked" > 
            <input type="hidden" name="xsiteid[3101400508588]" value="1801">
             <input type="hidden" name="xstatus_file[3101400508588]" value="1">            </td>
          <td align="center">3101400508588</td>
          <td align="left">�����ѵ��  ����ǧ�� <input type="hidden" name="fullname[3101400508588]" value="�����ѵ��  ����ǧ�� "></td>
          <td align="left">ʾ�.��§����ࢵ 1/�ç���¹�Ѵ���ͧ�ҵ�</td>
          <td align="left">���</td>
          <td align="center">27</td>
          <td align="center">2/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3101400508588.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center">18<input type="checkbox" name="xidcard[3101400944051]" value="3101400944051" checked="checked" > 
            <input type="hidden" name="xsiteid[3101400944051]" value="1801">
             <input type="hidden" name="xstatus_file[3101400944051]" value="1">            </td>
          <td align="center">3101400944051</td>
          <td align="left">�ҧ��ǹ���  ����§��С�� <input type="hidden" name="fullname[3101400944051]" value="�ҧ��ǹ���  ����§��С�� "></td>
          <td align="left">ʾ�.��§����ࢵ 1/�ç���¹�Ѵ���ͧ�ҵ�</td>
          <td align="left">���</td>
          <td align="center">29</td>
          <td align="center">2/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3101400944051.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center">19<input type="checkbox" name="xidcard[3101501762757]" value="3101501762757" checked="checked" > 
            <input type="hidden" name="xsiteid[3101501762757]" value="1801">
             <input type="hidden" name="xstatus_file[3101501762757]" value="1">            </td>
          <td align="center">3101501762757</td>
          <td align="left">�ҧ������  �Ҵ�� <input type="hidden" name="fullname[3101501762757]" value="�ҧ������  �Ҵ�� "></td>
          <td align="left">ʾ�.��§����ࢵ 1/�ç���¹�Ѵ���ͧ�ҵ�</td>
          <td align="left">���</td>
          <td align="center">30</td>
          <td align="center">3/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3101501762757.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center">20<input type="checkbox" name="xidcard[3101601029377]" value="3101601029377" checked="checked" > 
            <input type="hidden" name="xsiteid[3101601029377]" value="1801">
             <input type="hidden" name="xstatus_file[3101601029377]" value="1">            </td>
          <td align="center">3101601029377</td>
          <td align="left">����ʹ���  �ѧ���� <input type="hidden" name="fullname[3101601029377]" value="����ʹ���  �ѧ���� "></td>
          <td align="left">ʾ�.��§����ࢵ 1/�ç���¹�Ѵ���ͧ�ҵ�</td>
          <td align="left">���</td>
          <td align="center">33</td>
          <td align="center">1/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3101601029377.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr>
          <td colspan="8" align="center" bgcolor="#FFFFFF"><label>
          <input type="hidden" name="profile_id" value="8">
		  <input type="hidden" name="Aaction" value="SAVE">
		   <input type="hidden" name="staffid" value="11560">
		   <input type="hidden" name="TicketId" value="">
		                <input type="submit" name="Submit2" value="�ѹ�֡" >
			<input type="button" name="btnB" value="��͹��Ѻ" onClick="location.href='assign_list.php?action=assign_key&xsearch=&staffid=11560'">
          </label></td>
          </tr>
		          <tr>
		            <td colspan="8" align="left" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
		              <tr>
		                <td colspan="3" align="left"><em><strong>�����˵� </strong></em></td>
	                  </tr>
		              <tr>
		                <td width="3%">&nbsp;</td>
		                <td width="3%" bgcolor="#FF9900">&nbsp;</td>
		                <td width="97%"><em>�ѭ�ѡɳ����Ҫ��ä����кؤ�ҡ÷ҧ����֡�ҷ���繡�����������㹡�õ�Ǩ�ͺ�����١��ͧ�ͧ������(QC)</em></td>
	                  </tr>
		              <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
	                  </tr>
		              <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
	                  </tr>
		              <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
	                  </tr>
		              <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
	                  </tr>
		              <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
	                  </tr>
		              <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
	                  </tr>
		              <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
	                  </tr>
	                </table></td>
        </tr>
      </table>
  
  </td></tr>
  </form>
  </table>

</BODY>
</HTML>

