<? 
session_start();
session_destroy();

include ("../../../config/conndb_nonsession.inc.php")  ;

?>
<html>
<head>
<title>�������к��ҹ������</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="common/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style5 {
	color: #FF0000;
	font-weight: bold;
}
.style7 {	color: #FF0000;
	font-weight: bold;
	font-size: 16px;
}
.style12 {font-size: 16}
-->
</style>
<script type="text/javascript">
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
   var provid = document.getElementById("provid").value;
    if(provid == "" ) {
        clearproductList();
        return;
    }
    var url = "ajax_register.php?Tid=" + provid;
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
    var secname = document.getElementById("secname");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
           option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           secname.appendChild(option);
	}
    }
}

function clearproductList() {
    var secname = document.getElementById("secname");
    while(secname.childNodes.length > 0) {
              secname.removeChild(secname.childNodes[0]);
    }
}

</script>
</head>
<body bgcolor="#FFFFFF">
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
  <tr>
    <td colspan="2" align="center" class="headerTB"  >
	</td>
  </tr>
  <tr>
    <td width="222" align="center"><img src="../../../images_sys/cmss64.png" width="64" height="64"><br>
    ��س����͡ࢵ��鹷�����֡�������������к�</td>
    <td width="738" align="right">
	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="34%" valign="top" class="13_W"><form name="form1" method="post" action="redirect_register.php">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">

            <tr>
              <td align="center">
			  
			  
			                  <select id="secname" name="secname">
                <?
#  				 where  area_id != 2   �Ҥ��				
			$sql = "  select  secid,secname from eduarea where provid = '99' order by secid   " ; 
		 	$query_area = mysql_query( $sql  ) ;
			while($rs_area = mysql_fetch_assoc($query_area)){
		 	?>
                <option value="<?=$rs_area[secid]?>">
                <?=$rs_area[secname]?>
                </option>
                <? } ?>									  
                  </select>                </td>
              </tr>
            <tr>
              <td align="center"><input type="submit" name="Submit" value="      ��ŧ     "></td>
              </tr>
          </table>
        </form></td>
      </tr>
    </table>
	<br>
	<br>
	<table width="100%" border="0">
      <tr>
        <td align="center" valign="baseline"><strong>
          <? if  (3 == 5){   ### ����Ѻ���������� ?>
          ��С��</strong><br>
          �Դ���ͧ������ ʾ�.�ࢵ�Ҥ�� <br>
          ��ѹ������� 1 �ѹ�Ҥ� 2550 ���� 09.00 - 18.00 �. 

		  <br>
		  
          <br>
		  �ҡ��ͧ��ûԴ / �к�  ��ͧ�� 3 ��� 
		  index_dataentry.php<br>
index_kp7.php<br>
index_register.php
<? } # END  if  (3!= 5){   ### ����Ѻ���������� ?>		  </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
