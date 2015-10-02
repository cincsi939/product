<?php
	$sql = "select chart1 from  `reportinfo`  where rid='$id' and uname='$uname';";
	$result = mysql_query($sql);
	$rs=mysql_fetch_array($result,MYSQL_ASSOC);
	$chartheader =$rs['chart1'];
?>
<script>
	function chartindex(e) {
  		document.getElementById("valuex").value  = e.cells[0].innerText;
  		document.getElementById("valuey").value = e.cells[1].innerText;
		
		if($(e).hasClass('rowselect')){
			$(e).removeClass('rowselect');
		}else{
			$('#ctable tbody tr').removeClass('rowselect');
			$(e).addClass('rowselect');
		}
	}
	
	function getvaluex(){
	
		document.getElementById("valuex").value  = document.getElementById("txtrow").value+"."+document.getElementById("txtcol").value;
	}
	
	function getvaluey(){
		
		document.getElementById("valuey").value  = document.getElementById("txtrow").value+"."+document.getElementById("txtcol").value;
	}
	
	function addchart(){
		document.forms["updatechart"].action="?do=updatechart&action=addchart&id=<?=$id?>" ; 
		document.forms["updatechart"].submit();
		//window.location = "?do=updatechart&action=addchart&id=<?=$id?>";
	}
				
	function deletechart(){
		document.forms["updatechart"].action="?do=updatechart&action=deletechart&id=<?=$id?>"; 
		document.forms["updatechart"].submit();
	}
	
	function refreshchart(){
		document.getElementById("valuex").value  ="";
  		document.getElementById("valuey").value = "";
		$('#ctable tbody tr').removeClass('rowselect');
	}
	
	function updatechartheader(){
		document.forms["updatechart"].action="?do=updatechart&action=updatechartheader&id=<?=$id?>" ; 
		document.forms["updatechart"].submit();
	}

</script>
<style>
	#ctable{ background-color:#fff; border-spacing: 0px; border-collapse: collapse; width:90%; border: 1px  solid #333; font-size:xx-small;}
	#ctable td {border-spacing: 1px; border: 1px  solid #333; text-align:center;}
	#ctable th{border-spacing: 1px; border: 1px  solid #333; text-align:center; background-color:#6f96c6;}
	#ctable #trtool{ background-color:#999; }
	.rowselect td{ background: #FECA40; }
	/*#ctable tbody #trchart:hover{background:#FECA40; }*/
</style>
<FORM name="updatechart" ACTION="?id=<?=$id?>&sec=<?=$sec?>&action=updatechart" METHOD=POST ENCTYPE="multipart/form-data">
    <table id="ctable"   style="background-color:#efefef; width:100%;">
        <tr>
        	<th colspan="2" class="ui-widget-header">Chart Value</th>
        <tr>
        <tr>
            <td colspan="2">
            <textarea name="chartheader" rows="2" cols="12" id="chartheader"><?=$chartheader?></textarea> <br/>
            <input type="button" value="update" onClick="updatechartheader();">
            </td>
        </tr>
        <tr id="trtool" class="ui-widget-header">
            <td>x</td>
            <td>y</td>
        </tr>
        <tbody>
        <?php
        $sql="select valuex,valuey from chartinfo where rid='$id' and sec='$sec' ";
        $result = mysql_query($sql);
        //$i =0;
        //$json = array();
        while ($rs = mysql_fetch_array($result, MYSQL_ASSOC)){
		?>
        <tr id="trchart" onClick="chartindex(this)">
            <td><?=$rs['valuex']?></td>
            <td><?=$rs['valuey']?></td>
        </tr>
        <?php } ?>
        </tbody>
        <tr class="ui-state-default" id="trtool">
            <td><input id="valuex" name="valuex" type="text" style="width:40px;" onClick="getvaluex()"></td>
            <td><input id="valuey" name="valuey" type="text" style="width:40px;" onClick="getvaluey()"></td>
        <tr>
        <tr class="ui-widget-header" id="trtool">
            <td colspan="2">
                <input type="button" value="+" onClick="addchart();">
                <input type="button" value="-" onClick="deletechart();">
                <input type="button" value="(c)" onClick="refreshchart();">
            </td>
        </tr>
    </table>
</FORM>
    