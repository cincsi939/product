<? 
session_start();
session_destroy();

include ("../../../config/conndb_nonsession.inc.php")  ;

?>
<html>
<head>
<title>�������к��ҹ������</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="../../../common/style.css" rel="stylesheet" type="text/css">
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
    var url = "ajax_dataentry.php?Tid=" + provid;
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
<table width="100%" height="420" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
  <tr>
    <td align="center" class="headerTB"  >	</td>
  </tr>
  <tr>
    <td width="738" align="center" valign="top">
<!------	
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td align="center" bgcolor="#EFEFEF"><strong>�Դ�к��������ͧ������ </strong><br>
�����ҧ�ѹ�ѧ��� ��� 11 ��.� 2551 ���� 18.00 - �ѹ �ѧ��� ��� 11  ��.� 2551 ���� 20.00 �. <br>
�֧������㹤�������дǡ�� �. ����� </td>
    </tr>
  </table>
------->   
  <?

/*
$user_ip = $_SERVER["REMOTE_ADDR"] ;
if (substr($user_ip,0,8) == "192.168."){
	echo " <font color=red> ����ö�����੾��� Intra net ��ҹ�� </font> ";
	$IPpermission = "allow" ; 
}else{
#	$IPpermission = "0"  ;
#	echo " <br><br> <center>������ ˹����§ҹ�������ö��������͢��� Intranet ��ҹ�� </center>$user_ip";
	die; 
}
*/


?>	  
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><img src="../../../images_sys/cmss64.png" width="64" height="64"  ></td>
        </tr>
        <tr>
          <td align="center">
<!--------------- 
		  <table width="400" border="0" cellpadding="2" cellspacing="0" bgcolor="#FF3366" style="border: 2 solid  #FF3366">
            <tr>
              <td bgcolor="#EAF6F7" class="login_text"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td width="13%" align="center" valign="middle" bgcolor="#FAC9CA"><img src="../images/tip_icon2.gif" width="40" height="38"></td>
                    <td align="center" bgcolor="#FAC9CA" ><p><strong> ��С�ȻԴ�к��������ͧ������ ��� ��Ǩ�ͺ�����١��ͧ �ͧ������  
                          <br>
                          ��ѹ                    <u>������� 31 �.�. 2551 ���� 21.00 �.</u>  �֧ <u><br>
                    �ѹ�ѹ����� 2 ��.�. 2551 ���� 09.00 �.</u>
                    </strong><br>
                    </p></td>
                  </tr>
              </table></td>
            </tr>
          </table>
------------->
		  
		  </td>
        </tr>
        <tr>
          <td align="center"><strong>�к� CMSS ��Ѻ�ç���ҧ�� 185 ࢵ��鹷�����֡������</strong> </td>
        </tr>
        <tr>
          <td align="center"><br>
��س����͡ࢵ��鹷�����֡�������������к�</td>
        </tr>
      </table>
	  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="34%" valign="top" class="13_W"><form name="form1" method="post" action="redirect_dataentry.php">
          <table width="100%" border="0" cellspacing="2" cellpadding="3">

            <tr>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select name="provid" id="provid" onChange="refreshproductList();">
                <option value="0">��س����͡�ѧ��Ѵ</option>
                <?
#  				 where  area_id != 2   �Ҥ��				
			$sql = " SELECT  distinct  provid , name_proth   FROM  eduarea     order by name_proth  " ; 
		 	$query_area = mysql_query( $sql  ) ;
			while($rs_area = mysql_fetch_assoc($query_area)){
		 	?>
                <option value="<?=$rs_area[provid]?>">
                <?=$rs_area[name_proth]?>
                </option>
                <? } ?>
              </select>
                &nbsp;
                <select id="secname" name="secname">
                  </select></td>
              </tr>
            <tr>
              <td align="center"><input type="submit" name="Submit" value="      ��ŧ     "></td>
              </tr>
          </table>
        </form></td>
      </tr>
    </table>
      <table width="98%" border="0" align="center">
        <tr>
          <td class="headerTB">ʶҹС�ù���Ң����� �к�ʹѺʹع��èѴ������ö�кؤ�ҡ÷ҧ����֡��</td>
        </tr>
        <tr>
          <td>���ءʾ�. login ��Ҵ��� username cmss.xxxx (���� ʾ�.�ͧ��ҹ �� ���.ࢵ 1 �� cmss.1001) ������͡������ ��§ҹ �ѧ�ٻ </td>
        </tr>
        <tr>
          <td align="center"><img src="../../../images/cmss_tabreport.gif" width="397" height="140"></td>
        </tr>
      </table>
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
<? } # END  if  (3!= 5){   ### ����Ѻ���������� ?></td>
        </tr>
    </table> </td>
  </tr>
</table>
</body>
</html>
