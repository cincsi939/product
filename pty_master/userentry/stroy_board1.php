
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
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" align="left" bgcolor="#A5B2CE"><b>�ҧ��Ǿ���� �ѹ��� �ѹ��� 9 ����¹  2555  ���ʧҹ TK-255504091027310245679&nbsp;�������͡�����ǹ���� 
          <strong>��ͧ����ҹ���
          ���˹�ҷ���Ǩ�ͺ�س�Ҿ������          </strong></b><a href="assign_print.php?ticketid=TK-255504091027310245679" target="_blank"><img src="../../images_sys/print.gif" width="21" height="20" title="�������ͻ��Թ㺧ҹ�ͺ���§ҹ �.�.7" border="0"></a></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
        <td width="12%" align="center" bgcolor="#A5B2CE"><strong>���ʻ�Шӵ�ǻ�ЪҪ�</strong></td>
        <td width="13%" align="center" bgcolor="#A5B2CE"><strong>���� -���ʡ�� </strong></td>
        <td width="20%" align="center" bgcolor="#A5B2CE"><strong>�ç���¹/˹��§ҹ</strong></td>
        <td width="27%" align="center" bgcolor="#A5B2CE"><strong>���˹�</strong></td>
        <td width="7%" align="center" bgcolor="#A5B2CE"><strong>�����Ҫ���</strong></td>
        <td width="11%" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ�ٻ/�ӹǹ��</strong></td>
        <td width="7%" align="center" bgcolor="#A5B2CE"><input type="button" name="btnA" value="������¡��" onClick="location.href='assign_list.php?action=assign_key&staffid=11560&TicketId=TK-255504091027310245679&profile_id=9'"></td>
      </tr>
	        <tr bgcolor="#FFFFFF">
        <td align="center">1</td>
        <td align="left">3810100665613</td>
        <td align="left">����ҷ� �ʹ��ѭ</td>
        <td align="left">�Է����¡���Ҫվ�����ʹ/�ӹѡ�ҹ��С�����á���Ҫ���֡��</td>
        <td align="left">���</td>
        <td align="center">3</td>
        <td align="center">1/3</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3810100665613.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ź��¡��" onClick="return confirmDelete('pupup_delete.php?idcard=3810100665613&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3810100665613')" style="cursor:hand"></td>
      </tr>
	        <tr bgcolor="#F0F0F0">
        <td align="center">2</td>
        <td align="left">3840800007830</td>
        <td align="left">�ҧ��ͧ�ҭ��� ���ҧ��</td>
        <td align="left">�Է����¡���Ҫվ�����ʹ/�ӹѡ�ҹ��С�����á���Ҫ���֡��</td>
        <td align="left">���</td>
        <td align="center">4</td>
        <td align="center">1/3</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3840800007830.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ź��¡��" onClick="return confirmDelete('pupup_delete.php?idcard=3840800007830&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3840800007830')" style="cursor:hand"></td>
      </tr>
	        <tr bgcolor="#FFFFFF">
        <td align="center">3</td>
        <td align="left">3920300121055</td>
        <td align="left">������Ъ�� ��¾����Ѳ��</td>
        <td align="left">�Է����¡���Ҫվ�����ʹ/�ӹѡ�ҹ��С�����á���Ҫ���֡��</td>
        <td align="left">���</td>
        <td align="center">9</td>
        <td align="center">1/3</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3920300121055.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ź��¡��" onClick="return confirmDelete('pupup_delete.php?idcard=3920300121055&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3920300121055')" style="cursor:hand"></td>
      </tr>
	        <tr bgcolor="#F0F0F0">
        <td align="center">4</td>
        <td align="left">3920600091810</td>
        <td align="left">�ҧ�����ԭ�� �ѹ���ᴧ</td>
        <td align="left">�Է����¡���Ҫվ�����ʹ/�ӹѡ�ҹ��С�����á���Ҫ���֡��</td>
        <td align="left">���</td>
        <td align="center">16</td>
        <td align="center">3/3</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3920600091810.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ź��¡��" onClick="return confirmDelete('pupup_delete.php?idcard=3920600091810&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3920600091810')" style="cursor:hand"></td>
      </tr>
	        <tr bgcolor="#FFFFFF">
        <td align="center">5</td>
        <td align="left">3920600441012</td>
        <td align="left">�����෾ ��ǻ�ʹ</td>
        <td align="left">�Է����¡���Ҫվ�����ʹ/�ӹѡ�ҹ��С�����á���Ҫ���֡��</td>
        <td align="left">�ͧ����ӹ�¡���Է�����</td>
        <td align="center">36</td>
        <td align="center">1/5</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3920600441012.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ź��¡��" onClick="return confirmDelete('pupup_delete.php?idcard=3920600441012&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3920600441012')" style="cursor:hand"></td>
      </tr>
	        <tr bgcolor="#F0F0F0">
        <td align="center">6</td>
        <td align="left">3920600824124</td>
        <td align="left">����Ԫ�� ��蹪ҭ</td>
        <td align="left">�Է����¡���Ҫվ�����ʹ/�ӹѡ�ҹ��С�����á���Ҫ���֡��</td>
        <td align="left">���</td>
        <td align="center">18</td>
        <td align="center">1/4</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3920600824124.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ź��¡��" onClick="return confirmDelete('pupup_delete.php?idcard=3920600824124&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3920600824124')" style="cursor:hand"></td>
      </tr>
	        <tr bgcolor="#FFFFFF">
        <td align="center">7</td>
        <td align="left">3939900190153</td>
        <td align="left">��¹ѹ���� �����ǾѲ�����</td>
        <td align="left">�Է����¡���Ҫվ�����ʹ/�ӹѡ�ҹ��С�����á���Ҫ���֡��</td>
        <td align="left">�ͧ����ӹ�¡���Է�����</td>
        <td align="center">33</td>
        <td align="center">1/5</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3939900190153.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ź��¡��" onClick="return confirmDelete('pupup_delete.php?idcard=3939900190153&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3939900190153')" style="cursor:hand"></td>
      </tr>
	        <tr bgcolor="#F0F0F0">
        <td align="center">8</td>
        <td align="left">3941000313332</td>
        <td align="left">�ҧ������� ����</td>
        <td align="left">�Է����¡���Ҫվ�����ʹ/�ӹѡ�ҹ��С�����á���Ҫ���֡��</td>
        <td align="left">���</td>
        <td align="center">3</td>
        <td align="center">1/3</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3941000313332.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ź��¡��" onClick="return confirmDelete('pupup_delete.php?idcard=3941000313332&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3941000313332')" style="cursor:hand"></td>
      </tr>
	        <tr bgcolor="#FFFFFF">
        <td align="center">9</td>
        <td align="left">3969900126706</td>
        <td align="left">�ҧ���Ҿ� �ŧ����ԧ</td>
        <td align="left">�Է����¡���Ҫվ�����ʹ/�ӹѡ�ҹ��С�����á���Ҫ���֡��</td>
        <td align="left">���</td>
        <td align="center">4</td>
        <td align="center">1/3</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3969900126706.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="�͡��� �.�.7 �鹩�Ѻ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ź��¡��" onClick="return confirmDelete('pupup_delete.php?idcard=3969900126706&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3969900126706')" style="cursor:hand"></td>
      </tr>
	      </table></td>
  </tr>
</table>
<script>
	  function alertTxt(id){
	    alert('�١���͡�����');
		document.getElementById(id).checked = false;
      }
</script>

</BODY>
</HTML>

