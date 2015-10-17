<?php
/**
 * Title: dashboard page etc_tool system 
 * Author: Kaisorrawat Panyo
 * Date: 14/10/2558
 * Time: 
 */
#############################################################
$ApplicationName   = 'etc_tool';
$VERSION             = "1.0";
#############################################################
$nameTable = $_GET['table'];
$keyTable = $_GET['keyTable'];
// if($_POST){
// 	echo "<pre>";
// 	print_r($_POST);
// 	die();
// }

if($_POST[action] == 'add'){
	// echo "<pre>";
// 	print_r($_POST);
	$i = 0;
	$sql = "INSERT INTO ".$nameTable." ( ";
	foreach($_POST[field] as $key => $arrKey){
		$i++;
		$num = count($_POST[field]);
		$sql .=  "`".$key."`";
		if($num == $i){
			$sql .= " ";
		}else{
			$sql .= ", ";
		}
		echo $num."<br>";
	}
	$sql .= ") VALUES ( ";
	$j = 0;
	foreach($_POST[field] as $key => $arrPost){
		$j++;
		$numPost = count($_POST[field]);
		$sql .= "'$arrPost'" ;
		if($numPost == $j){
			$sql .= " ";
		}else{
			$sql .= ", ";
		}
	}
	$sql .= ") ";
	// echo $sql."<br>";
	$QuerySQL = mysql_db_query(DB_OSCC,$sql) or die("Query Error " .mysql_error());
	if($QuerySQL){
		?> <script>window.location.href = 'index.php?p=dashboard&table=<?=$nameTable?>';</script><?php
	}
}
if($_POST[action] == 'edit'){
	// echo "<pre>";
// 	print_r($_POST);
	$i = 0;
	$sql = "UPDATE " .$nameTable. " SET ";
	foreach($_POST[field] as $key => $arrKey){
		$i++;
		$num = count($_POST[field]);
		$sql .=  "`".$key."`" ." = ";
		$sql .= "'$arrKey'";
		if($num == $i){
			$sql .= " ";
		}else{
			$sql .= ", ";
		}
	}
	$sql .= "WHERE ". $_POST[condition] ." = " .$keyTable;
	// echo $sql."<br>";
	$QuerySQL = mysql_db_query(DB_OSCC,$sql) or die("Query Error " .mysql_error());
	if($QuerySQL){
		?> <script>window.location.href = 'index.php?p=dashboard&table=<?=$nameTable?>';</script> <?php
	}
}

if($_GET['delete'] == 'delete'){
	// echo "<pre>";
// 	print_r($_GET);
	$sqlTable = " show full columns from ".$_GET['table']." ";
	$QueryTable = mysql_db_query(DB_OSCC,$sqlTable) or die("Error Query " .mysql_error());
	while($rsTable = mysql_fetch_assoc($QueryTable)){
		$arr_head[] = $rsTable;
		$num = count($arr_head); 
	}
	
	$k = 0;
	foreach($arr_head as $keySelect => $valueSelect){
		$k++;
		$sqlSelect .= $valueSelect[Field];
		if($numEdit == $k){
			$sqlSelect .= " ";
		}else{
			$sqlSelect .= ", ";
		}
		if($valueSelect[Key] == 'PRI'){
			if($valueSelect[Extra] == 'auto_increment'){
				$condition = $valueSelect[Field];
			}
		}
	}
	$Delete = "DELETE FROM ".$_GET['table']." WHERE ".$condition." = ".$_GET['keyTable']." ";
	// echo $Delete."<br>";
	$QuerySQL = mysql_db_query(DB_OSCC,$Delete) or die("Query Error " .mysql_error());
	if($QuerySQL){
		?> <!-- --> <script>window.location.href = 'index.php?p=dashboard&table=<?=$nameTable?>';</script> <?php
	}
}

?>
<link rel="stylesheet" href="../../common/donate/package/formvalidation/dist/css/formValidation.min.css">
<script src="../../common/donate/package/formvalidation/vendor/jquery/jquery.min.js"></script>
<script src="../../common/donate/package/formvalidation/dist/js/formValidation.min.js"></script>
<script src="../../common/oscc_js/bootstrap.min.js"></script>
<!-- <script src="//code.jquery.com/jquery-1.11.3.min.js"></script> -->

<style type="text/css">
.form-style-2{
    max-width: 700px;
    padding: 20px 12px 10px 20px;
    font: 13px Arial, Helvetica, sans-serif;
}
.form-style-2-heading{
    font-weight: bold;
    font-style: italic;
    border-bottom: 2px solid #ddd;
    margin-bottom: 20px;
    font-size: 20px;
    padding-bottom: 3px;
}
.form-style-2 label{
    display: block;
    margin: 0px 0px 15px 0px;
}
.form-style-2 label > span{
    width: 200px;
    font-weight: bold;
    float: left;
    padding-top: 8px;
    padding-right: 5px;
}
.form-style-2 span.required{
    color:red;
}
.form-style-2 .tel-number-field{
    width: 40px;
    text-align: center;
}
.form-style-2 input.input-field{
    width: 48%;
    
}

.form-style-2 input.input-field,
.form-style-2 textarea.input-field,  
.form-style-2 .tel-number-field, 
.form-style-2 .textarea-field, 
 .form-style-2 .select-field{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    border: 1px solid #C2C2C2;
    box-shadow: 1px 1px 4px #EBEBEB;
    -moz-box-shadow: 1px 1px 4px #EBEBEB;
    -webkit-box-shadow: 1px 1px 4px #EBEBEB;
    border-radius: 3px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    padding: 7px;
    outline: none;
}
.form-style-2 .input-field:focus, 
.form-style-2 .tel-number-field:focus, 
.form-style-2 .textarea-field:focus,  
.form-style-2 .select-field:focus{
    border: 1px solid #0C0;
}
.form-style-2 .textarea-field{
    height:100px;
    width: 55%;
}
.form-style-2 input[type=submit],
.form-style-2 input[type=button],
.form-style-2 button[type=submit],
.form-style-2 button[type=button]{
    border: none;
    padding: 8px 15px 8px 15px;
    background: #FF8500;
    color: #fff;
    box-shadow: 1px 1px 4px #DADADA;
    -moz-box-shadow: 1px 1px 4px #DADADA;
    -webkit-box-shadow: 1px 1px 4px #DADADA;
    border-radius: 3px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
}
.form-style-2 input[type=submit]:hover,
.form-style-2 input[type=button]:hover{
    background: #EA7B00;
    color: #fff;
}

</style>
		<script language="javascript">
$(document).ready(function() {
    $(".txtboxToFilter").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
			
			function cancal(){
				$('#form_cancal').submit();
			}
			function submit(){
				$('#loginForm').submit();
				
			}
			
		</script>
			
			<?php
if(in_array($_GET['table'],array_keys($arr_table))){				
			?>
			
	<form action="" method="post" name="form_cancal" id="form_cancal">
		<input type="hidden" value="cancal" name="cancal">
	</form>
<div class="row" >
	<?php
		$sqlTable = " show full columns from ".$_GET['table']." ";
		$QueryTable = mysql_db_query(DB_OSCC,$sqlTable) or die("Error Query " .mysql_error());
		while($rsTable = mysql_fetch_assoc($QueryTable)){
			$arr_head[] = $rsTable;
			$num = count($arr_head); 
		}
		// echo "<pre>";
// 		print_r($arr_head);
		
	?>
	<div class="form-style-2 center-block">
		<div class="form-style-2-heading">แบบฟอร์มการบันทึกข้อมูล</div>
		<form action="" method="post" id="loginForm" name=""  >
			<?php
			if($_GET['edit'] == 'edit'){
				$sqlTableEdit = " show full columns from ".$_GET['table']." ";
				$QueryTableEdit = mysql_db_query(DB_OSCC,$sqlTableEdit) or die("Error Query " .mysql_error());
				while($rsTableEdit = mysql_fetch_assoc($QueryTableEdit)){
					$arr_head_edit[] = $rsTableEdit;
					$numEdit = count($arr_head_edit); 
				}
				
				$k = 0;
				$sqlSelect = "SELECT ";
				foreach($arr_head_edit as $keySelect => $valueSelect){
					$k++;
					$sqlSelect .= $valueSelect[Field];
					if($numEdit == $k){
						$sqlSelect .= " ";
					}else{
						$sqlSelect .= ", ";
					}
					if($valueSelect[Key] == 'PRI'){
						if($valueSelect[Extra] == 'auto_increment'){
							$condition = $valueSelect[Field];
						}else if($valueSelect[Key] == 'PRI'){
							$condition = $valueSelect[Field];
						}
						
					}
					
				}
				$sqlSelect .= "FROM " .$_GET['table'] . " WHERE " . $condition ." = " .$_GET['keyTable'] ;
				if($_GET['debug'] == 'on'){
					echo $sqlSelect;
				}
				$selectQuery = mysql_db_query(DB_OSCC,$sqlSelect) or die("<br> Error Query " .mysql_error());
				
				$rsSelect = mysql_fetch_assoc($selectQuery);
				
				
			?>
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="condition" value="<?=$condition?>">
			<?php
			}else{
			?>	
			<input type="hidden" name="action" value="add">
			<?php	
			}
			?>
			
			
  			<?php
  			foreach($arr_head as $keyArr => $valArr){
				
				$subString = explode('(',$valArr[Type]);
				
				// if($_GET['edit'] == 'edit'){
// 					if($valArr[Extra] == 'PRI'){
//
// 					}
//
// 				}
				
				if($valArr[Extra] != 'auto_increment'){
					?>
					<label for="field1">
						<span><?=$valArr[Comment]?></span>
						<div class="form-group">
							<?php
							if(strlen($rsSelect[$valArr[Field]]) > 50){ 
								?>
								<textarea 
									class="input-field"
									rows="25" 
									cols="40" 
									id="<?=$valArr[Field]?>" 
									name="field[<?=$valArr[Field]?>]"
									group = "field"
									field = "<?=$valArr[Field]?>"
									<?php
									if(in_array($valArr[Field],$arr_table[$_GET['table']]['notAllnull'])){
										echo 'Validate = "YES" ';
									}else{
										echo 'Validate = "NO" '; 
									}
									?>
									
									><?=$rsSelect[$valArr[Field]]?></textarea>
									<span id="error_<?=$valArr[Field]?>" class="alert alert-danger" style="display: none; color: red; ">กรุณากรอกข้อความ</span>
								<?php
							}else{
								?>
								<input 
									type="text"
									group = "field"
									field = "<?=$valArr[Field]?>"
									<?php
									if(in_array($valArr[Field],$arr_table[$_GET['table']]['notAllnull'])){
										echo 'Validate = "YES" ';
									}else{
										echo 'Validate = "NO" '; 
									}
									?>
									class="input-field <?php if($subString[0] == 'int'){ ?>txtboxToFilter<?php } else if($subString[0] == 'tinyint'){ ?>txtboxToFilter<?php }else{ ?> <?php } ?>" 
									id="<?=$valArr[Field]?>"
									name="field[<?=$valArr[Field]?>]" 
									value="<?=$rsSelect[$valArr[Field]]?>"
									/>
									<span id="error_<?=$valArr[Field]?>" class="alert alert-danger" style="display: none; color: red; ">กรุณากรอกข้อความ</span>
								<?php
							}
							?>
						
						
						</div>
						
					</label>
					<?php
				}
  				?>
			
				<?php
			}
			?>
			<label><span>&nbsp;</span>
                <button type="button" name="" class="btn btn-default" aria-label="Left Align" onClick="fncValidate();" >
                    บันทึก
                </button>
							<?php
							if($_REQUEST["cancal"] == "cancal"){
								
								// echo "<script>window.location='form_users.php?id_received='".$_GET['id_received']."' ';</script>";
				?> <script>window.location.href = 'index.php?p=dashboard&table=<?=$_GET['table']?>';</script> <?php

							}
							?>
                <button type="reset" name="" class="btn btn-default" aria-label="Left Align" onClick="javascript:return cancal();">
                    ยกเลิก
                </button>
				
			</label>
		</form>
	</div>
	
</div>
<?php
		}else{
			echo "ไม่มีสิทธิในการเข้าถึงข้อมูล"."<br>";
		}
											?>
<script>


function fncValidate(){
    
	var pass = true;
	$("input[group=field]").each(function(){
		var fieldname = $(this).attr("field");
		// alert($('#'+fieldname).attr("Validate"));
		
		if($('#'+fieldname).attr("Validate")=='YES' && $('#'+fieldname).val() == ''){
			// alert('Error');
			$('#error_'+fieldname).show();
			$(this).css("border-color","red");
			pass = false;
			
		}else{
			$('#error_'+fieldname).hide();
			$(this).css("border-color","");
			
		}
// alert($('input[name=field['+fieldname+']]').val());
		
	});
	
	if(pass === true){
		submit();
	}
}
</script>
