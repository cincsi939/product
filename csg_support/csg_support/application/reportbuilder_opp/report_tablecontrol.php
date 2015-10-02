<script>

	$(document).ready(function() {
		//$('#defaultTable thead').hide();
  	});

	function getIndex(e) {
		row_index = $(e.target).parent().index();
  		col_index = $(e.target).index();
  		document.getElementById("txtrow").value  = row_index+1;
  		document.getElementById("txtcol").value = col_index+1;
	}
	function getHeaderIndex(e){
		getIndex(e);
		$index = $(e).index();
	}
	function headerhover(e){
		$index = $(e).index();
		$('#defaultTable tbody td').removeClass('cellhover');
	    $( '#defaultTable tbody #trIndex').each(function(index, element){
			$(this.cells[$index]).addClass('cellhover');
	    });
	}
	function headerUnhover(){
		$('#defaultTable tbody td').removeClass('cellhover');
	}
	function getCellIndex(row, col){
		document.getElementById("txtcol").value = col;
  		document.getElementById("txtrow").value  = row;
	}

	function addColumn(){
		$tr=<?=$i?>;
		$tc=<?=$j?>;
		
		var tspan = <?=json_encode($tspan); ?>;
		var $tableColIndex= $('#defaultTable  #trIndex');
		var newCol;
		newCol="";
		
		var colIndex=document.getElementById("txtcol").value;
		$cIndex=colIndex-1;
		
		document.forms["updatetable"]["c"].value = $tc+1;  
		document.forms["updatetable"]["c"].disabled = false;
		document.forms["updatetable"]["r"].disabled = false;
		document.forms['updatetable'].elements['edittable'].checked = "1";
		document.forms['updatetable'].action="?action=updatetable&do=cellnew&controltype=<?=$controltype?>"; 
		document.forms["updatetable"].submit();
	}
	
	function addRow(){
		$tr=<?=$i?>;
		$tc=<?=$j?>;
		
		document.forms["updatetable"]["r"].value = $tr+1;  
		document.forms["updatetable"]["c"].disabled = false;
		document.forms["updatetable"]["r"].disabled = false;
		document.forms['updatetable'].elements['edittable'].checked = "1";
		document.forms['updatetable'].action="?action=updatetable&do=rownew&controltype=<?=$controltype?>"; 
		document.forms["updatetable"].submit();
	}
	
	function deleteColumn(){
  		$column = document.getElementById("txtcol").value ;
		
		if(confirm("Are you sure to delete column: "+$column+" ?")){
			window.location = "?id="+<?=$id?>+"&do=deletecolumn&controltype=<?=$controltype?>&column="+$column;
		}
	}
	
	function deleteRow(){
		$row = document.getElementById("txtrow").value;
		
		if(confirm("Are you sure to delete row: "+$row+" ?")){
			window.location = "?id="+<?=$id?>+"&do=deleterow&controltype=<?=$controltype?>&row="+$row;
		}
	}
	
	function unmergeall(){
		document.forms["updatetable"]["c"].disabled = false;
		document.forms["updatetable"]["r"].disabled = false;
		document.forms['updatetable'].elements['edittable'].checked = "1";
		document.forms['updatetable'].action="?action=updatetable"; 
		document.forms["updatetable"].submit();
	}

	function updateTable(){
			var $tableColIndex= $('#execTable u');
			var txt;
			txt="";

	    	$('#defaultTable  #trIndex').each(function(id){
	    		$row = id+1;
	    		$(this).find('u').each(function(id){
	    			$col = id+1;
	    			this.innerText=$row+":"+$col;
	    			//txt +=$row+":"+$col+", ";
	    		});
	    	});
		}
		
	function updateCell(){
			$arrCell= [];
			$arrCell[0] = new Array();
			$arrCell[1] = new Array();
			
			$i=0;
			$('#defaultTable #trIndex').each(function(id){
	    		$row = id+1;
	    		$(this).find('u').each(function(id){
	    			$col = id+1;
	    			$bf=$row+"."+$col;
	    			$af=this.innerText;
	    			if($bf!==$af){
	    				$arrCell[0][$i]=$row+"."+$col;
						if(typeof this.innerText === 'undefined'){
							$arrCell[1][$i]=this.textContent;
						}else{
	    					$arrCell[1][$i]=this.innerText;
						}
	    				$i++;
	    			}
	    		});
	    	});
	    	
	    	$cellBefore="";
	    	for (var i=0; i < $arrCell[0].length; i++) {
			  		$bf= $arrCell[0][i];
					$af=$arrCell[1][i];
					$cellBefore += $bf+"==>"+$af+"\n";
			};
			//alert($cellBefore);
			window.location = "?id="+<?=$id?>+"&do=changecell&cell="+JSON.stringify($arrCell);
		}
		
		function refreshCell(){
			window.location = "?id="+<?=$id?>;
		}
		
		function ChkMoveCol(emtChk)
		{				
			if(document.getElementById(emtChk).checked)
			{
				$('#defaultTable').dragtable();
				$('#defaultTable tbody tr').sortable({
		              connectWith: ".connectedSortable"
		        });
        		
        		$tr=<?=$i?>;
				$tc=<?=$j?>;
        		$eTable = $('#defaultTable td:first');
        		$tw =$eTable.css("width");
        		$th = $('#defaultTable').height() / $tr;
        		//$('#defaultTable tbody td').css('width', $tw);
        		//$('#defaultTable tbody td').css('height', $th+"px");
			}else{
				//document.getElementById(emtChk).style.display="none";
				$('#defaultTable tbody td').css('width', <?php //echo $px?>+"%");
			}
		}
		
		function checkMergeTable(){
			$chkResult="0";
			var tspan = <?=json_encode($tspan); ?>;
				for($i=0; $i<<?=$i?>; $i++){
					for($j=0; $j<<?=$j?>; $j++){
						$x = tspan[$i][$j].split('x');
						$rspan = $x[0];
						$cspan = $x[1];
						if($rspan>1 || $cspan>1){
							$chkResult="1";
							break;
						}
					}
				}
			return $chkResult;
		}
		
		function controlselect(control){
			
			$chkMerage=checkMergeTable();
			
			if($chkMerage=="1"){
				
				$result = confirm("รูปแบบของตารางไม่ถูกต้อง เนื่องจากบางเซลถูก Merge เข้าด้วยกัน คุณต้องการ unmerge cell หรือไม่ !");	
				if($result){
					document.forms["updatetable"]["c"].disabled = false;
					document.forms["updatetable"]["r"].disabled = false;
					document.forms['updatetable'].elements['edittable'].checked = "1";
					document.forms['updatetable'].action="?action=updatetable&controltype="+control.value;
					document.forms["updatetable"].submit();
				}
				
				document.getElementById("controltype").value=0;
				exit;
			}
			
			window.location = "?id="+<?=$id?>+"&controltype="+control.value;
		}
		
		$(window).load(function () {
		  	controltypes(<?=$controltype?>);
		});
		
		function controltypes(control){
		
			$('#defaultTable thead').hide();
			$('#defaultTable tbody th').hide();
			$('#defaultTable th').css('cursor', 'default');
			
			$('#defaultTable thead th').removeClass('tablehover');
			$('#defaultTable tbody tr').removeClass('tablehover');
			$('#defaultTable tbody tr').removeClass('rowhover');
			$('#defaultTable tbody td').removeClass('tablehover');
			
			$('#defaultTable').removeClass("dragtable");
			
			$('#addrow').removeClass('showcontrol');
			$('#deleterow').removeClass('showcontrol');
			$('#addcolumn').removeClass('showcontrol');
			$('#deletecolumn').removeClass('showcontrol');

			if(control =="0"){
	
	
			}else if(control=="1"){
				
				$('#defaultTable thead').show();
				$('#defaultTable thead th').addClass('tablehover');
				
				$('#addcolumn').addClass('showcontrol');
				$('#deletecolumn').addClass('showcontrol');
		
				$('#defaultTable').dragtable();
				$('#defaultTable th').css('cursor', 'move');
				
			}else if(control=="2"){
			
				$('#defaultTable tbody th').show();
				$('#defaultTable tbody tr').addClass('rowhover');
				
				$('#addrow').addClass('showcontrol');
				$('#deleterow').addClass('showcontrol');
				
				$('#defaultTable tbody tr').click(function(){
					if($(this).hasClass('rowselect')){
						$(this).removeClass('rowselect');
					}else{
						$('#defaultTable tbody tr').removeClass('rowselect');
						$(this).addClass('rowselect');
					}
				});
				
				$('#defaultTable tbody').sortable({
		              connectWith: ".connectedSortable"
		        });
	
			}else if(control=="3"){
				
				$('#defaultTable tbody #tdCell').addClass('tablehover');
				
				$('#defaultTable tbody #tdCell').click(function(){
					if($(this).hasClass('cellselect')){
						$(this).removeClass('cellselect');
					}else{
						$('#defaultTable tbody #tdCell').removeClass('cellselect');
						$(this).addClass('cellselect');
					}
				});
				
				$('#defaultTable tbody tr').sortable({
		              connectWith: ".connectedSortable"
		        });
			}
		}
		
		function pasteproperties(e){
    		var fromcell = prompt("Input import cell style.", '');
        	if (fromcell != null){
            	//e.target.innerText=fromcell;
        	}
		}
</script>

<style>
	#divtable-control{text-align:center; margin: 5px; background-color:#6f96c6; padding:5px; margin: -5px -5px 25px -5px; border-top:1px  double #000; border-bottom: 1px double #000;}
	.button-Control{padding: 2px 2px  2px 2px; display:none;}
	.showcontrol{ display:inline;}
	.button-Save{width:50px;}
	/* #defaultTable{position: static;}*/
	 #defaultTable th { cursor: move; background-color:#6f96c6;}
	 #defaultTable thead tr td { border: 1px dotted #fff; border-top:none; border-bottom:none; height:15px; background-color: #fff;}
	 #defaultTable thead tr th:hover{background:#FECA40; }
	/*#defaultTable tbody tr:hover td{background:#FECA40; }
	  #defaultTable tbody td:hover{background: #FECA40;}*/
	 .tablehover:hover{ background:#6f96c6;}
	 .headerselect{ background: #6f96c6; }
	 .rowhover:hover td{ background:#6f96c6; }
	 .cellhover { background: #FECA40; }
	 .cellselect{ background: #FECA40; }
	 .rowselect td{ background: #FECA40; }
	 .hidecontrol{ display:none;}
	 #txtpaste{font-size:xx-small;}
</style> 

<div id="divtable-control" >
	<b>Row:</b> <input type="text" id="txtrow" value="0" style="width: 25px; text-align: center;" disabled>
	<b>Column:</b> <input type="text" id="txtcol" value="0" style="width: 25px; text-align: center;" disabled>
    <b>Control Type:</b>
    <select id="controltype" onChange="controlselect(this)">
		<option value="0" <?= ( $controltype == 0 ? 'selected="selected"' : '' ) ?>> -- select control --</option>
		<option value="1" <?= ( $controltype == 1 ? 'selected="selected"' : '' ) ?>> Column Control</option>
        <option value="2" <?= ( $controltype == 2 ? 'selected="selected"' : '' ) ?>> Row Control</option>
        <option value="3" <?= ( $controltype == 3 ? 'selected="selected"' : '' ) ?>> Cell Control</option>
	</select>
    <input type="button" id="addrow" class="button-Control" value="(+) Row" onClick="addRow()">
    <input type="button" id="deleterow" class="button-Control" value="(-) Row" onClick="deleteRow()">
  	<input type="button" id="addcolumn" class="button-Control" value="(+) Column" onClick="addColumn()">
	<input type="button" id="deletecolumn" class="button-Control" value="(-) Column" onClick="deleteColumn()">
    <input type="button"  value="Unmerge All" onClick="unmergeall()">
	<!--<input type="checkbox" id="chkMoveCol"  onclick="ChkMoveCol(this.id);"/>:move column-->
	<input type="button" class="button-Save" value="Save" onClick="updateCell();">
    <input type="button" class="button-Save" value="Reset" onClick="refreshCell()">
</div>

