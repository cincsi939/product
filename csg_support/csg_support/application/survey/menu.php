<?php
/**
* @comment 
* @projectCode 
* @tor  -
* @package core
* @author Wised Wisesvatcharajaren
* @access private
* @created 25/07/2558
*/

?>
<style>

.menu_list{
	font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
	border-radius: 5px 5px 5px 5px;
	border : 1px solid #BBB;
	 background-image:url('index_files/bg_gline.png');
	 font-size:14px;
	 font-weight:bold;
	  box-shadow: 1px 1px 2px  #888888;
	 
}
.menu_list_dis{
	font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
	 font-size:14px;
	 font-weight:bold;
	 color:#CCC;
	 text-shadow:#FFF;
	 TEXT-DECORATION:none;
}

.menu_list a{
	font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
	 font-size:14px;
	 font-weight:bold;
	 color:#666;
	 text-shadow:#FFF;
	 TEXT-DECORATION:none;
}

.menu_list a:hover {
	font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
	 font-size:14px;
	 font-weight:bold;
	 text-shadow:#FFF;
	 TEXT-DECORATION:none;
	 COLOR: #f3960b;
}
button{
	border:0px;
}

a:link {
    text-decoration: none;
}

a:visited {
    text-decoration: none;
}
</style>
<div style="float:left; width:97%; height:auto; text-align:right; font-size:16px; font-weight:bold;">
	<div  style="float:right;padding-right:10px; color:<?php echo  $color = ($_GET['frame']=='dr_doc_attach') ? 'red' : 'gray'; ?>">
    	<?php
        	if($_GET['id'] == ''){
				echo '&bull; แนบเอกสาร';
			}else{
				echo '&bull; <a href="question_form.php?frame=dr_doc_attach&id='.$_GET['id'].'&eq_id='.$_GET['eq_id'].'" style="color:'.$color.' ">แนบเอกสาร</a>';
			}
    	?>
    </div>
    <div  style="float:right;padding-right:10px; color:<?php echo  $color = ($_GET['frame']=='dr_doc2') ? 'red' : 'gray'; ?>">
    	<?php
        	if($_GET['id'] == ''){
				echo '&bull; แบบรับรองสถานะของครัวเรือน (ดร.02)';
			}else{
				echo '&bull; <a href="question_form.php?frame=dr_doc2&id='.$_GET['id'].'&eq_id='.$_GET['eq_id'].'" style="color:'.$color.'">แบบรับรองสถานะของครัวเรือน (ดร.02)</a>';
			}
    	?>
    </div>
    <div  style="float:right;padding-right:10px; color:<?php echo  $color = ($_GET['frame']=='dr_doc1') ? 'red' : 'gray'; ?>">
    	&bull; <a href="question_form.php?frame=dr_doc1&id=<?php echo $id; ?>&eq_id=<?php echo $_GET['eq_id']?>"  style="color:<?php echo $color ?>">แบบลงทะเบียนเพื่อขอรับสิทธิฯ (ดร.01)</a>
    </div>
    <div  style="float:right; padding-right:10px;">แบบลงทะเบียน :</div>
</div>