<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<LINK href="../../css/style.css" rel=stylesheet>
<link rel="stylesheet" href="../../css/styles.menu.2.css">
<script src="../../js/jquery-latest.min.js" type="text/javascript"></script>
<script src="../../js/script.js"></script>

<script src="../../js/jquery-1.10.1.min.js"></script>
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

function chgPreName(e) {
	if ( e ) {
			CreateXmlHttp();
			XmlHttp.open("get", "../main/ajax.chkprename.php?pre="+e, true);
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
<style>
#mark{background:#D80041;
 color:#000;
}

.style1{
	color:#F00;
}
</style>
<?php
if(isset($_GET['frame']))
{
	$frame = $_GET['frame'];
}
else
{
	$frame = 1;
}
?>
<div id="cssmenu">
    <ul>
   <li class='active' <?php if($frame == 1){?> id="mark" <?php }?>><a href='?frame=1&id=<?php echo $_GET['id']; ?>'><span>���������� (���� 0-18 ��)</span></a></li>
   <li class='has-sub' <?php if($frame == 2){?> id="mark" <?php }?>><a href='?frame=2&id=<?php echo $_GET['id']; ?>'><span>��������Ǫ� (���� 19-25 ��)</span></a></li>
   <li class='has-sub' <?php if($frame == 3){?> id="mark" <?php }?>><a href='?frame=3&id=<?php echo $_GET['id']; ?>'><span>���������ç�ҹ (���� 25 �բ��� - 60 ��)</span></a></li>
   <li class='has-sub' <?php if($frame == 4){?> id="mark" <?php }?>><a href='?frame=4&id=<?php echo $_GET['id']; ?>'><span>���������٧����</span></a></li>
   <li class='last' <?php if($frame == 5){?> id="mark" <?php }?>><a href='?frame=5&id=<?php echo $_GET['id']; ?>'><span>��������ԡ��</span></a></li>
</ul>
<div id="content">
<?php
		include('../lib/nusoap.php');
		include('../lib/class.function.php');
		$con = new Cfunction();
		if(isset($_GET['frame']))
		{
			include('../form2/'.$_GET['frame'].'.php');
		}
		else
		{
			include('../form2/1.php');
		}
?>
</div> <!--end content-->

</div><!--div tabs-->
<script src="../../js/CheckIdCardThai.min.js"></script>
<script src="../../js/AgeCalculate.min.js"></script>
<script  type="text/javascript">

function fncSubmit()
{
	
	if(document.form1.tIDCard.value == "")
	{
		alert('��سҡ�͡�ѵû�ЪҪ� ���� ��ԡ��������ѵû�ЪҪ�');
		document.form1.tIDCard.focus();
		return false;
	}
	
	
	if(document.form1.tName.value == "")
	{
		alert('��سҡ�͡����-���ʡ��');
		document.form1.tName.focus();
		return false;
	}
	
	if(document.form1.tPrename.value == '')
	{
		alert('��س��кؤӹ�˹�Ҫ���');
		document.form1.tName.focus();
		return false;
	}
	
	if(document.form1.chkSex.value == 0)
	{
		alert('��سҡ�͡���͡��');
		document.form1.tIDCard.focus();
		return false;
	}
	
	if(document.form1.tAge.value == "")
	{
		alert('��سҡ�͡�ӹǹ���� ���� �ѹ�Դ');
		document.form1.tAge.focus();
		return false;
	}
	
	if(document.form1.tRelation.value == "")
	{
		alert('��س��к� ��������ѹ���ͺ����');
		return false;
	}
	
	if(document.form1.tEducation.value == "")
	{
		alert('��س��к� ����֡��');
		return false;
	}
	
	
	var result = $('#tIDCard').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
	} else {
		alert('�Ţ�ѵû�ЪҪ�������١��ͧ');
		document.form1.tIDCard.focus();
		return false;
	}
}

$(document).ready(function () {
$("#v382").change(function () {
	var result = calAge(document.getElementById('v382').value);
	document.getElementById('v155').value = result[0];
});

$("#v155").keyup(function() {
 var tAge = document.getElementById('v155').value ;
 var ttAge = <?php echo $dt = date('Y') + 543;?> - tAge ;
 var showDate = "01/01/" + ttAge ;
 document.getElementById('v382').value = showDate;
 
});

$("#v392").change(function () {
	var result = calAge(document.getElementById('v392').value);
	document.getElementById('v195').value = result[0];
});

$("#v195").keyup(function() {
 var tAge = document.getElementById('v195').value ;
 var ttAge = <?php echo $dt = date('Y') + 543;?> - tAge ;
 var showDate = "01/01/" + ttAge ;
 document.getElementById('v392').value = showDate;
 
});

$("#v393").change(function () {
	var result = calAge(document.getElementById('v393').value);
	document.getElementById('v229').value = result[0];
});

$("#v229").keyup(function() {
 var tAge = document.getElementById('v229').value ;
 var ttAge = <?php echo $dt = date('Y') + 543;?> - tAge ;
 var showDate = "01/01/" + ttAge ;
 document.getElementById('v393').value = showDate;
 
});

$("#v394").change(function () {
	var result = calAge(document.getElementById('v394').value);
	document.getElementById('v260').value = result[0];
});

$("#v260").keyup(function() {
 var tAge = document.getElementById('v260').value ;
 var ttAge = <?php echo $dt = date('Y') + 543;?> - tAge ;
 var showDate = "01/01/" + ttAge ;
 document.getElementById('v394').value = showDate;
 
});

$("#v395").change(function () {
	var result = calAge(document.getElementById('v395').value);
	document.getElementById('v298').value = result[0];
});

$("#v298").keyup(function() {
 var tAge = document.getElementById('v298').value ;
 var ttAge = <?php echo $dt = date('Y') + 543;?> - tAge ;
 var showDate = "01/01/" + ttAge ;
 document.getElementById('v395').value = showDate;
 
});
	
/*----------------------------------------------------------- ત�ѵû�ЪҪ�*/
 $('#idClassCheck').click(function() {
	var result = $('#tIDCard').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
		alert('�Ţ�ѵû�ЪҪ����١��ͧ');
	} else {
		alert('�Ţ�ѵû�ЪҪ�������١��ͧ');
	}
});

$('#random2').click(function() {
	$('#tIDCard').RandomIdCardThai({firstNum: '0'});
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

});
</script>

