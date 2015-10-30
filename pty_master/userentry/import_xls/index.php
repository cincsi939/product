<?php
set_time_limit(0) ;
include('root_path.php');
//include ("../../../common/std_function.inc.php") ;
include ("../../../common/common.inc.php") ; 
include "../epm.inc.php";

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Import DATA</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>

<link href="style/upload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js"></script>  
<script type="text/javascript" >
    $(document).ready( function(){                                
         $('#buttonUpload').click(function()
               {
                    if  ($('#secid').val()=="0" || $('#fileToUpload').val()=="")    {
                            alert("กรุณาเลือกสำนักงานเขต");            
                        }else{
                             $('form').submit();
                        }
                        
              }
            )
     })
</script>
</head>
<BODY>
<div id="wrapper">
    <div id="content">
    <h1> <img src="images/paper_content_chart_48.png" width="48" height="48" align="absmiddle">ระบบนำเข้าข้อมูลข้าราชการ</h1>
        <p>นำข้อมูลจากฐานข้อมูล P-OBEC -> CMSS โดยใช้ไฟล์ excel ที่ส่งออก
>CMSS โดยใช้ไฟล์ excel ที่ส่งออก จากโปรแกรม P-OBEC ต้องทำการบันทึกประเภทไฟล์เป็น Microsoft Office Excel Workbook(*.xls)</p>
                <ul>
                    <li>เลือกสำนักงานเขตจากรายการ</li>
                    <li>เลือกไฟล์ excel ที่ต้องการนำข้อมูลเข้า</li>
                    <li>กดปุ่ม Upload</li>
      </ul>        
        
      <form name="form" action="process.php?process=execute" method="POST"  target="maindisplay" enctype="multipart/form-data">
        <table cellpadding="0" cellspacing="0" class="tableForm">
        <tbody>
                    <tr>
                <td  align="left">
                  <select name="secid" id="secid"  class="input">
                   <option value="0" ><<=กรุณาเลือกสำนักงานเขต==>></option>
                    
                    <?
                                  $sql="SELECT     secid, secname FROM  ".DB_MASTER.".eduarea WHERE secid not like '99%' ORDER BY secname  ASC";                                 
                                 $Result = mysql_db_query($dbnamemaster,$sql);
                                 while($rs_ch = mysql_fetch_array($Result)){
                                   echo  '<option value="'. $rs_ch[secid].'">'.$rs_ch[secname].'</option> ';                                      
                                    }
                                 
                                ?>
                </select>
                </td>
            </tr>
            <tr><td height="5"></td></tr>    
            <tr>
                <td align="left"><input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input"></td>            </tr>

        </tbody>
         <tr><td height="5"></td></tr>    
            <tfoot>
                <tr>
                    <td align="left"><button class="button"   type="button"   id="buttonUpload" >Upload</button>                   
                             
                  </td>
                </tr>
            </tfoot>    
    </table>
        </form>        
    </div>
    
</div>

</body>
</html>
