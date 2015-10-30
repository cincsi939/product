<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Untitled Document</title>
</head>
<script type="text/javascript" src="../../../common/autocomplete/autocomplete.js"></script>
<link href="../../../common/autocomplete/autocomplete.css"  rel="stylesheet" type="text/css">
<script>


function make_autocom(autoObj,showObj){   
    var mkAutoObj=autoObj;    
    var mkSerValObj=showObj;    
    new Autocomplete(mkAutoObj, function() {   
        this.setValue = function(id) {         
            document.getElementById(mkSerValObj).value = id;   
       }   
        if ( this.isModified )   
            this.setValue("");   
        if ( this.value.length < 21 && this.isNotClick )    
            return ;       
        return "gdata.php?q=" + this.value+"&rnd="+Math.random()*1000;   
    });    
}   


</script>
<body>
<table width="588" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="101">&nbsp;</td>
    <td width="420">&nbsp;</td>
    <td width="67">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap">ค้นหาโรงเรียน : </td>
    <td>
                  <input name="select_school_label"  type="text" id="select_school_label"  size="50" maxlength="255" />
              <input type="hidden" name="select_school" id="select_school"  value="<?=$xschool?>" />
      <script >
              make_autocom("select_school_label","select_school");  
			  
              </script>
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
