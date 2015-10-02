<FORM name="updatesql" ACTION="?id=<?=$id?>&action=updatesql" METHOD=POST ENCTYPE="multipart/form-data">
    <!--<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">-->
    <script>
        
        function savejsondata(){
            //alert($jsondata);   
            //document.forms["updatesql"].action="?do=updatesql&action=updatesql&id=<?=$id?>"; 
            //document.forms["updatesql"].submit();
            $sqlname = document.getElementById("txtsql").value;
            $query = document.getElementById("txtquery").value;
            $desc = document.getElementById("txtdesc").value;
            $.getJSON('report_jsonbuilder.php?action=updatesql&id=<?=$id?>&sec=<?=$sec?>&sqlname='+$sqlname+'&query='+encodeURIComponent($query)+'&desc='+$desc, function(data) {
				clearjsondata();
                document.getElementById("sqlselect").selectedIndex=0;
                getjsonsqlset();
            });
        }
        
        function deletejsondata(){
            //alert($jsondata);   
            //document.forms["updatesql"].action="?do=updatesql&action=deletesql&id=<?=$id?>"; 
            //document.forms["updatesql"].submit();
            $sqlname = document.getElementById("txtsql").value;
            $.getJSON('report_jsonbuilder.php?action=deletesql&id=<?=$id?>&sec=<?=$sec?>&sqlname='+$sqlname, function(data) {			
                //alert(JSON.stringify(data));
                clearjsondata();
                document.getElementById("sqlselect").selectedIndex=0;
                getjsonsqlset();
            });
        }
        
        function getjsontable(){
            var $tablerow = $('#jtable tbody tr');
            $tablerow.remove();
            var strQuery = document.getElementById("txtquery").value;
            $.getJSON('report_jsonbuilder.php?strQuery='+ strQuery, function(data) {			
                $jsondata = JSON.stringify(data);
                //json_decode
                //alert(JSON.stringify(data));
                //var arr = jQuery.parseJSON(data);
                $result = [];
                $jsontalbe = $('#jtable tbody:last');
                $.each(data, function(index, value) {
                    $newrow = "<tr>";
                    $result[index]= new Array();
                    $.each(value, function(col, val){
                        $j= Object.keys(value).indexOf(col);
                        $field = "["+index+"]["+$j+"]";
                        $result[index][$j] = val;
                        //$encode= iconv("utf-8", "tis-620", val);
                        $newrow +="<td onclick='jsonindex(this)'><u style='font-size:xx-small;'><b>"+$field+"</b></u>   "+val+"</td>";
                    });
                    $newrow+="</tr>";
                    $jsontalbe.append($newrow);
                });
                
            });
        }
        
        function getjsonsqlset(){
            $.getJSON('report_jsonbuilder.php?action=getsqlset&id=<?=$id?>&sec=<?=$sec?>', function(data) {			
                $jsontable = $('#sqlselect');
                document.getElementById("sqlselect").innerHTML = "";
                $newrow = "<option value='0' > -- select sql --</option>";
                $.each(data, function(key, val) {
                    $newrow += "<option value=" +val.sqlname + "> "  + val.sqlname + "</option>";
                });
                $jsontable.append($newrow);
            });				
        }
        
        
        function getjsonsql(sqlname){
            
            var strQuery = "select * from report_sqldata  where rid='<?=$id?>' and uname='<?=$uname?>' and sec='<?=$sec?>' and sqlname='"+sqlname.value+"' ";
            $.getJSON('report_jsonsql.php?strQuery='+ strQuery, function(data) {		
                $jsondata = JSON.stringify(data);
                $.each(data, function(key, val) {
                    document.getElementById("txtsql").value=val.sqlname;
                    document.getElementById("txtquery").value=val.query;
                    document.getElementById("txtdesc").value=val.description;
                });
            });
            
            clearjsondata();
            getjsonarray(<?=$id?>);
        }
        
        var $sql;
        var $sqlset=[];
        function loadsqlset() {
            $.getJSON('report_jsonbuilder.php?id=<?=$id?>' , function(data) {	
                $sql= JSON.parse(JSON.stringify(data));
            });
        }
        
        function getjsonarray(id){
            
            $slqid= document.getElementById("sqlselect").value
    
            $.getJSON('report_jsonbuilder.php?id='+ id, function(data) {				
                $sql= JSON.parse(JSON.stringify(data));
                //alert(JSON.stringify($sql[$slqid][0][0]));
				//console.log(JSON.stringify($sql[$slqid]['check']));
                $jsontable = $('#jtable tbody:last');
                $.each($sql[$slqid], function(index, value) {
                    $newrow = "<tr>";
                    $.each(value, function(col, val){
                        $field = $slqid+"["+index+"]["+col+"]";
                        $newrow +="<td onclick='jsonindex(this)'><u><b>"+$field+"</b></u>   "+val+"</td>";
                    });
                    $newrow+="</tr>";
                    $jsontable.append($newrow);
                });
            });					
        }
        
        function getsqlcellvalue(cellindex){
        
            cellindex = cellindex.replace(/]/g, '');
            $s = cellindex.split('[');
            $source = $s[0];
            $row=$s[1];
            $col=$s[2];
            //alert($source+", "+$row+", " +$col);
            //alert(JSON.stringify($sql[$source][$row][$col]));
            $cellvalue= JSON.stringify($sql[$source][$row][$col]);
            return $cellvalue;
            //document.write($cellvalue);
        }
        
        function createnew(){
            clearjsondata();
            document.getElementById("sqlselect").value=0;
        }
        
        function clearjsondata(){
            document.getElementById("txtsql").value='';
            document.getElementById("txtquery").value='';
            document.getElementById("txtdesc").value='';
            
            document.getElementById("jtable").innerHTML = "";
            $('#jtable:last').append("<tbody></tbody>");
        }
        
        function jsonindex(e){
            //row_index = $(e.target).parent().index();
            //col_index = $(e.target).index();
            //alert(row_index+"."+col_index);
            $sqlset=e.firstChild.innerText;
            document.getElementById("cond").value=$sqlset;
        }
        
        function selectsql(){
            document.write(getsqlcellvalue('sql1[0][0]')); 
        }
    </script>
    
    <div id="boxdefault" style="display:none" >
        <div  id="boxsqlset" style="background-color:#6f96c6; padding:10px; margin-bottom:10px; border: 1px solid #000;  font-size:small;" >
			<style>
                #sqlsetTalble{ border:1px solid #666; background-color:#efefef; margin-bottom:10px; border-spacing: 0px; border-collapse: collapse; width:70%; font-size:small;}
                #sqlsetTalble tr td { border: 1px solid #666; font-size:x-small;}
            </style>
            <table id="sqlsetTalble"  >
                <tr style="background-color:#999; padding:2px;" class="ui-widget-header">
                	<td colspan="2"><b>SQL Query Template</b></td>
                </tr>
                <tr class="ui-state-default">
                    <td><b>SQL Name</b></td>
                    <td><input type="text" id="txtsql" name="txtsql" value="" size="70%"></td>
                </tr>
                <tr class="ui-state-default">
                    <td><b>SQL Query</b> </td>
                    <td>
                    <textarea id="txtquery" name="txtquery" value="" rows="3" cols="70" >  </textarea> 
                    <input type="button" value=" SQL Query" onClick="SelectCondition(document.getElementById('txtquery'));" > 
                    <input type="button" value="View" onClick="getjsontable();">
                    </td>
                </tr>
                <tr class="ui-state-default">
                    <td><b>Description</b></td>
                    <td><input type="text" id="txtdesc" name="txtdesc" size="70%" value=""></td>
                </tr>
                <tr class="ui-state-default">
                    <td></td>
                    <td>
                    <input type="button" value="Save" onClick="savejsondata()">
                    <input type="button" value="Delete" onClick="deletejsondata()">
                    <input type="button" value="Create New SQL" onClick="createnew()">
                    </td>
                </tr>
            </table>
        
            <div id="boxsql">
                <div style="background-color:#999; border:1px solid #666; padding:2px;" class="ui-widget-header">
                    <b>SQL-Set: </b>
                    <select id="sqlselect" onChange="getjsonsql(this)"  style="width:250px;" >
                        <option value="0" > -- select sql --</option>
                        <?php
                        $sql="select * from report_sqldata where rid='$id' and uname='$uname' and sec='$sec';";
                        $result = mysql_query($sql);
                        while ($rs = mysql_fetch_assoc($result)){
                        ?>
                        <option value=<?=$rs['sqlname']?>> <?=$rs['sqlname']?></option>
                        <?php }?>
                    </select>
				</div>   
                <style>
                    #jtable{ background-color:#fff; border-spacing: 0px; border-collapse: collapse; width:90%; border: 1px  solid #333;}
                    #jtable td {border-spacing: 1px; border: 1px  solid #333; text-align:center; cursor:pointer;}
                    #jtable u { background-color:#F60; font-size:x-small; float:left;}
                    #jtable td:hover{background: #fff9df;}
                </style>                
                <table id="jtable"  style="background-color:#efefef; width:100%;">
                	<tbody></tbody>
                </table>
            </div>
        </div>
	</div>
</FORM>

<div id="PageSqlSet" title="SQL-Set:" style="background-color:#6f96c6; padding:5px; border: 1px solid #000; font-size:smaller; display:none; ">
</div>              
<script>
	function SqlSetDialog(){
		clearjsondata();
		document.getElementById("sqlselect").selectedIndex=0;
		//$tw =$('#sqlsetTalble').css("width");
		$tw = 475;
		$('#PageSqlSet').append($('#boxsqlset'));
		$('#PageSqlSet').css('float', 'inherit');
		$( '#PageSqlSet' ).dialog({
			width: $tw,
			close: function() {
				$('#boxdefault:last').append($('#boxsqlset'));
			}
		});
	}
	/*
	$(document).ready(function () {
		$("#btnDone").click(function () {
	  $("#form-dialog").dialog('close');
		});
	});*/
</script>
