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
include ("../../common/paginator/function_get_pages.php");
include("config.php");
?>
<style>
.bg_header{
    /*background-image:url('../../images/img_oscc/bg_header.jpg');*/
    background-repeat:repeat-x; 
    background:#cae8ea;
}
</style>							
											
											<?php
											// echo "<pre>";
// 											print_r( array_keys($arr_table));
											
											if(in_array($_GET['table'],array_keys($arr_table))){
												
												
												// แสดงข้อมูลการรับแจ้ง
												$sqlTable = " show full columns from ".$_GET['table']." ";
												$QueryTable = mysql_db_query(DB_OSCC,$sqlTable); // or die("Error Query " .mysql_error());
												while($rsTable = mysql_fetch_assoc($QueryTable)){
													$arr_head[] = $rsTable;
													$num = count($arr_head); 
												}
											
												$i = 0;
												$sql = "SELECT ";
												foreach($arr_head as $key => $value ){
													$i++;
													$sql .=  "`".$value[Field]."`";
														if($num == $i){
															$sql .= " ";
														}else{
															$sql .= ", ";
														}
												}
												$sql .= "FROM ". $_GET['table'];
												if($_GET['debug'] == 'on'){
													echo $sql;
												}
											
											
												$sqlQuery = mysql_db_query(DB_OSCC,$sql) or die("<br> Error Query " .mysql_error());
												// $Num_Rows = mysql_num_rows($sqlQuery);
												$page_all = mysql_num_rows($sqlQuery);
											
												$page = $_GET['page'];
												$per_page = 10;
												$view = $_GET['View'];
												$page_link = "p=dashboard&table=".$_GET['table']."";
												$sqlPaging = getPaging($sql, $page_all, $page, $per_page, $view, $page_link );
												$intRow = ($page>0)?($page-1)*$per_page:0;
											
												$sqlQuery = mysql_db_query(DB_OSCC,$sqlPaging) or die("Error Query " .mysql_error());
												
												?>
<div align="right">
	<a href="index.php?p=form_data&table=<?=$_GET['table']?>">เพิ่มข้อมูล</a>
</div>
<table width="99%" border="1" cellpadding="3" cellspacing="1" align="center" class="tbl_dashboard" style="font-size: 16px;">
	<tr align="center" class="bg_header" height="30" >
		<td><b><?php echo "ลำดับ" ?></b></td>
<?php
			foreach($arr_head as $keyArr => $valArr){
				// echo"<pre>";
// 				print_r($arr_head);
														
?>
		<td><b><?php if($valArr[Comment] == ''){ echo $valArr[Field]; }else{ echo $valArr[Comment]; } ?></b></td>
<?php
			}
?>
		<td><b>เครื่องมือ</b></td>
	</tr>
<?php
		while($rs = mysql_fetch_assoc($sqlQuery)){
			$intRow++;
													
				// $arrRs[] = $rs;
				// $rs = $valArr[Field];						
?>
	<tr style="background-color:#FFF;">
		<td align="center" width="10%"><?=$intRow?></td>
												
<?php
			foreach($arr_head as $ketArrRs => $valArrRs){
					
$subString = explode('(',$valArrRs[Type]);
// echo "<pre>";
// print_r($subString);
				if($valArrRs[Key] == 'PRI' ){
					// $keyTable = $rs[$valArrRs[Field]];
					if($valArrRs[Extra] == 'auto_increment'){
						$keyTable = $rs[$valArrRs[Field]];
					}else if($valArrRs[Key] == 'PRI'){
						$keyTable = $rs[$valArrRs[Field]];
					}
				}
				
				// echo $keyTable."<br>";
					  if($subString[0] != 'int'){
						    $align ="left";  
					  }else{ 
							$align = "center";   
					  } 										
?>
		<td 
			align="<?=$align?>" 
			style="word-wrap: break-word;"><?php echo substr($rs[$valArrRs[Field]],0,50); if(strlen($rs[$valArrRs[Field]]) > 50){ echo " ..."; } ?>
		</td>
<?
			}
															
?>
		<td colspan="2" width="5%" align="center">
			<a href="index.php?p=form_data&table=<?=$_GET['table']?>&keyTable=<?=$keyTable?>&edit=edit">แก้ไข</a>
			<a href="JavaScript:if(confirm('คุณต้องการลบรายการใช่หรือไหม')==true){window.location='index.php?p=form_data&keyTable=<?=$keyTable?>&table=<?=$_GET['table']?>&delete=delete';} ">ลบ</a>

		</td>
<?php
	}
												
?>			
	</tr>
</table>
<?
											}else{
												echo "ไม่มีสิทธิในการเข้าถึงข้อมูล"."<br>";
											}		
											
											
										    
											
											