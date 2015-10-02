<?php
/**
 * @comment 	map trat
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Panupong Kiangmana (panupong@sapphire.co.th)
 * @created    08/09/2014
 * @access     public
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<title>map</title>
</head>
<body>
<script >
	//�ѧ��ѹ resize iframe �� report builder
	
	//�ѧ����������֧��� Element
	function $(elmId){
		return document.getElementById(elmId);
	}
	
	//�ѧ���� ���ҧ���ͧ Tool tip
	var mouseX = 0 ,mouseY = 0;
	function tooltipBox(x,y,text){
		if(x-150<0){
			var x_tooltip = 150-(150-x+20);
		}
		if(x+150>380){
			var x_tooltip = 150-(150-x+20);
		}
		if(y+100>450){
			var y_tooltip = y - 90;
		}else{
			var y_tooltip = y +30;
		}
		$("tooltip").style.left = x-x_tooltip+'px'; //���˹� x ��ҧ�ԧ�ҡ style.left
		$("tooltip").style.top = y_tooltip+'px';//���˹� y ��ҧ�ԧ�ҡ style.top
		$("tooltip").style.display = 'block'; //����ʴ����ͧ tool tip
		$("tooltip").innerHTML = text; //��ͤ����������ҡ�� tool tip
	}
	
	//�ѧ��㹡�á�˹���÷ӧҹ�ͧ tool tip
	function tooltip(e){
		//�֧��ҵ��˹觺�˹�Ҩ�㹨ش��� cursor ���ѧ�������
		var e = e || window.event;
		if(e.clientX || e.clientY){
			mouseX = e.clientX + document.body.scrollLeft;
			mouseY = e.clientY + document.body.scrollTop;
		}else if(e.pageX || e.pageY){
			mouseX = e.pageX;
			mouseY = e.pageY;
		}
		//��Ǩ�ͺ����ա�á�˹� class ����������
		var target = e.target.className || e.srcElement.className;
		if(target){
			var sptarget = target.split("|");
			if(sptarget[0] == "tooltip"){ //��Ǩ�ͺ��� class ��͹����ͧ "|" ��ͤ���� tooltip �������
				tooltipBox (mouseX,mouseY,sptarget[1]);
				  //�ʴ����ͧ tool tip �����¡ function tooltipBox ��ҹ���� ��˹�᡹ x,y ��Т�ͤ�����������ʴ�
			}
		}
	}
	//�ѧ��ѹ�������÷ӧҹ
	function init(){
		var body = document.getElementsByTagName("body")[0];
		var divtt = document.createElement("div");
		divtt.id = "tooltip";
		body.appendChild(divtt);
		//���ҧ ���ͧ tooltip ����� id ��ҡѺ tooltip �����
		document.onmousemove = tooltip; //��� cursor ����͹��ѧelement ����ա�û�С�� class tooltip ����������¡�ѧ��ѹ tooltip �ҷӧҹ
		document.onmouseout = function(){
		$("tooltip").style.display = 'none';
		//㹷ҧ��Ѻ�ѹ��� cursor ����͹�͡�ҡ element ��Ы�͹���ͧ tool tip �ѹ��
		};
	}
	
	init(); //���¡�� �ѧ��ѹ init
	<?php // @modify Phada Woodtikarn 12/09/2014 ���� function Link ?>
	function Link(district_id,mapsize){
		var reportId = '';
		if(mapsize == 's'){
			reportId = 400;
		}
		if(mapsize == 'm'){
			reportId = 398;
		}
		
		window.parent.location.href = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/reportbuilder/report_preview.php?id='+reportId+'&codedistrict_id='+district_id;
	}
	<?php // @end ?>
	function getHost(mapsize){
	if(mapsize == 's'){
			reportId = 390;
		}
		if(mapsize == 'm'){
			reportId = 396;
		}
	var host = window.location.hostname;
	var newlink = 'http://'+host+"/reportbuilder/report_preview.php?id="+reportId;
	window.parent.location = newlink;
	}
</script>
<style>

@font-face {
    font-family: 'Thai Sans Neue Regular';
    src: url('../application/survey/font/ThaiSansNeue-Regular.otf');
    src: url('../application/survey/font/ThaiSansNeue-Regular.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}
#tooltip{
	font-family:'Thai Sans Neue Regular';
	font-size:16px
	border:1px solid #CCC;
	padding:5px;
	height:auto;
	width:250px;/*��˹��������ҧ�٧�ش*/
	text-align:center;
	background-color:#FFF;
	color:#000;
	display:none; /*��˹���� div #tooltip ��͹�������͹*/
	position:absolute; /*position ��ͧ�� absolute*/
	border-radius:5px;
	opacity:0.9;
	overflow:hidden;
	z-index:99;
}
.markerText{
	font-family:'Thai Sans Neue Regular';
	font-size:22px;
}
</style>
<?php 
$con = mysql_connect("localhost","family_admin",'F@m!ly[0vE'); if(!$con) { echo "Not connect"; } mysql_select_db("question_project",$con);
mysql_query('SET NAMES TIS620');
$level_area = $_GET['level_area'];
$margin_val = '10';
?>

<table style="margin-left:<?php echo $margin_val."px";  ?>">
    <tr>
    
<?php
if($level_area == 'province'){
	if($_GET['mapsize']=='s'){
	?>
 	<td width="367" height="426" style="position:inherit;  background-image:url('images/trat34.png'); background-repeat:no-repeat;">
    <?php
    }else if($_GET['mapsize']=='m'){ 
		// @modify Phada Woodtikarn 11/09/2014 �ٻ map ����
		if(isset($_GET['maptype']) && $_GET['maptype'] == '1'){
	?>
    <td width="500" height="620" style="position:inherit; background-image:url('images/type_full_scale3_04.png'); background-repeat:no-repeat;">
	<?php
		}else{
	?>
	<td width="500" height="620" style="position:inherit; background-image:url('images/type_full_scale_m.png'); background-repeat:no-repeat;">
    <?php		
		// @end
		}
	}
	if($_GET['area_id']){
		$area_id =  substr($_GET['area_id'],0,2)."%";
	}else{
		$area_id ='23%';
	}
	
	if($_GET['year']){
		$report_year = "and report_year='".$_GET['year']."'";
	}
	
	$sql_GYR = "select report_id, report_chkevaltype, report_parish from reportbuilder_all where report_id like '".$area_id ."' ".$report_year;
	$query_GYR = mysql_query($sql_GYR);
	// @modify Phada Woodtikarn 12/09/2014 ������èҧ��
	if(isset($_GET['codedistrict_id'])){
		$district_id = $_GET['codedistrict_id'];
		$opqcity = 'opacity: 0.5;';
	}else{
		$district_id = '';
		$opqcity = '';
	}
	// @end
	if($_GET['mapsize']=='s'){
		// static position size S
		$arr[23040000]['position'] = "top: 50px; left: ".($margin_val+140)."px;";
		$arr[23030000]['position'] = "top: 100px; left: ".($margin_val+80)."px;";
		$arr[23010000]['position'] = "top: 150px; left:  ".($margin_val+180)."px;";
		$arr[23050000]['position'] = "top: 160px; left: ".($margin_val+80)."px;";
		$arr[23070000]['position'] = "top: 230px; left: ".($margin_val+30)."px;";
		$arr[23020000]['position'] = "top: 270px; left: ".($margin_val+270)."px;";
		$arr[23060000]['position'] = "top: 370px; left: ".($margin_val+160)."px;";
		$arr[23040000]['position'] .= $district_id==23040000?'':$opqcity;
		$arr[23030000]['position'] .= $district_id==23030000?'':$opqcity;
		$arr[23010000]['position'] .= $district_id==23010000?'':$opqcity;
		$arr[23050000]['position'] .= $district_id==23050000?'':$opqcity;
		$arr[23070000]['position'] .= $district_id==23070000?'':$opqcity;
		$arr[23020000]['position'] .= $district_id==23020000?'':$opqcity;
		$arr[23060000]['position'] .= $district_id==23060000?'':$opqcity;
		
		$arr[23040000]['textposition'] = "top: 65px; left: ".($margin_val+225)."px; color:#000; text-shadow: 1px 1px 3px #ccc;";
		$arr[23030000]['textposition'] = "top: 100px; left: ".($margin_val+55)."px; color:#fff; text-shadow: 1px 1px 3px #000;";
		$arr[23010000]['textposition'] = "top: 170px; left: ".($margin_val+256)."px; color:#000; text-shadow: 1px 1px 3px #ccc;";
		$arr[23050000]['textposition'] = "top: 200px; left: ".($margin_val+50)."px; color:#fff; text-shadow: 1px 1px 3px #000;";
		$arr[23070000]['textposition'] = "top: 290px; left: ".($margin_val+40)."px; color:#000; text-shadow: 1px 1px 3px #ccc;";
		$arr[23020000]['textposition'] = "top: 305px; left: ".($margin_val+253)."px; color:#000; text-shadow: 1px 1px 3px #ccc;";
		$arr[23060000]['textposition'] = "top: 400px; left: ".($margin_val+205)."px; color:#000; text-shadow: 1px 1px 3px #ccc;";
		
		$arr[23040000]['textposition'] .= $district_id==23040000?'':$opqcity;
		$arr[23030000]['textposition'] .= $district_id==23030000?'':$opqcity;
		$arr[23010000]['textposition'] .= $district_id==23010000?'':$opqcity;
		$arr[23050000]['textposition'] .= $district_id==23050000?'':$opqcity;
		$arr[23070000]['textposition'] .= $district_id==23070000?'':$opqcity;
		$arr[23020000]['textposition'] .= $district_id==23020000?'':$opqcity;
		$arr[23060000]['textposition'] .= $district_id==23060000?'':$opqcity;
		// static position
	}else if($_GET['mapsize']=='m'){
		// static position size M
		$arr[23040000]['position'] = "top: 45px; left: ".($margin_val+140)."px;";
		$arr[23030000]['position'] = "top: 120px; left: ".($margin_val+70)."px;";
		$arr[23010000]['position'] = "top: 170px; left: ".($margin_val+180)."px;";
		$arr[23050000]['position'] = "top: 222px; left: ".($margin_val+60)."px;";
		$arr[23070000]['position'] = "top: 310px; left: ".($margin_val+10)."px;";
		$arr[23020000]['position'] = "top: 385px; left: ".($margin_val+253)."px;";
		$arr[23060000]['position'] = "top: 530px; left: ".($margin_val+135)."px;";
		
		$arr[23040000]['position'] .= $district_id==23040000?'':$opqcity;
		$arr[23030000]['position'] .= $district_id==23030000?'':$opqcity;
		$arr[23010000]['position'] .= $district_id==23010000?'':$opqcity;
		$arr[23050000]['position'] .= $district_id==23050000?'':$opqcity;
		$arr[23070000]['position'] .= $district_id==23070000?'':$opqcity;
		$arr[23020000]['position'] .= $district_id==23020000?'':$opqcity;
		$arr[23060000]['position'] .= $district_id==23060000?'':$opqcity;
		
		$arr[23040000]['textposition'] = "top: 65px; left: ".($margin_val+230)."px; color:#000; text-shadow: 1px 1px 3px #ccc;";
		$arr[23030000]['textposition'] = "top: 110px; left: ".($margin_val+55)."px; color:#fff; text-shadow: 1px 1px 3px #000;";
		$arr[23010000]['textposition'] = "top: 200px; left: ".($margin_val+270)."px; color:#000; text-shadow: 1px 1px 3px #ccc;";
		$arr[23050000]['textposition'] = "top: 292px; left: ".($margin_val+100)."px; color:#fff; text-shadow: 1px 1px 3px #000;";
		$arr[23070000]['textposition'] = "top: 430px; left: ".($margin_val+40)."px; color:#000; text-shadow: 1px 1px 3px #ccc;";
		$arr[23020000]['textposition'] = "top: 385px; left: ".($margin_val+253)."px; color:#000; text-shadow: 1px 1px 3px #ccc;";
		$arr[23060000]['textposition'] = "top: 530px; left: ".($margin_val+205)."px; color:#000; text-shadow: 1px 1px 3px #ccc;";
		
		$arr[23040000]['textposition'] .= $district_id==23040000?'':$opqcity;
		$arr[23030000]['textposition'] .= $district_id==23030000?'':$opqcity;
		$arr[23010000]['textposition'] .= $district_id==23010000?'':$opqcity;
		$arr[23050000]['textposition'] .= $district_id==23050000?'':$opqcity;
		$arr[23070000]['textposition'] .= $district_id==23070000?'':$opqcity;
		$arr[23020000]['textposition'] .= $district_id==23020000?'':$opqcity;
		$arr[23060000]['textposition'] .= $district_id==23060000?'':$opqcity;
		// static position
	}
	?>
    	<div style="width:130px; height:30px; top: 15px; left: <?php echo $margin_val+230; ?>px; position:absolute; cursor:pointer;" onclick="getHost('<?php echo $_GET['mapsize']; ?>')"></div>
    <?php
	while($row_GYR = mysql_fetch_assoc($query_GYR)){
		if($_GET['mapsize']=='s'){
			if($row_GYR['report_chkevaltype'] == 'green'){
				$point_img = 'width:40px; height:40px; background-image:url(images/green.png);';
				$point_img_selected = 'width:40px; height:40px; background-image:url(images/green_select_s.png);';
			}else if($row_GYR['report_chkevaltype'] == 'yellow'){
				$point_img = 'width:50px; height:50px; background-image:url(images/yellow.png);';
				$point_img_selected = 'width:50px; height:50px; background-image:url(images/yellow_select_s.png);';
			}else{
				$point_img = 'width:60px; height:60px; background-image:url(images/red.png);';
				$point_img_selected = 'width:60px; height:60px; background-image:url(images/red_select_s.png);';
			}
		}else if($_GET['mapsize']=='m'){
			if($row_GYR['report_chkevaltype'] == 'green'){
				$point_img = 'width:57px; height:57px; background-image:url(images/point_green_m.png);';
				$point_img_selected = 'width:57px; height:57px; background-image:url(images/green_select_m.png);';
			}else if($row_GYR['report_chkevaltype'] == 'yellow'){
				$point_img = 'width:85px; height:85px; background-image:url(images/point_yellow_m.png);';
				$point_img_selected = 'width:85px; height:85px; background-image:url(images/yellow_select_m.png);';
			}else{
				$point_img = 'width:103px; height:103px; background-image:url(images/point_red_m.png);';
				$point_img_selected = 'width:103px; height:103px; background-image:url(images/red_select_m.png);';
			}
		}
		$sql_count_family = "select report_tatalfamily from reportbuilder_all where  report_id = '".$row_GYR['report_id']."' ";
		$query_count_family = mysql_query($sql_count_family);
		$row_count_family = mysql_fetch_assoc($query_count_family);
		
		$sql_count_help = "select report_total_t from reportbuilder_f2_1 where  report_id = '".$row_GYR['report_id']."' ";
		$query_count_help = mysql_query($sql_count_help);
		$row_count_help = mysql_fetch_assoc($query_count_help);
		
		if($_GET['codedistrict_id']==$row_GYR['report_id']){$showimg = $point_img_selected;}else{$showimg = $point_img;}
		$arr[$row_GYR['report_id']]['style'] = $arr[$row_GYR['report_id']]['position'].$showimg."position:absolute; cursor:pointer";
		$arr[$row_GYR['report_id']]['styletext'] = $arr[$row_GYR['report_id']]['textposition']."position:absolute; cursor:pointer;   ";
		
		if($row_GYR['report_parish'] == '��������ͧ��Ҵ'){
			$arr[$row_GYR['report_id']]['data'] = $row_GYR['report_parish']."<br>�ӹǹ���á�Դ����鹷���¹ : 303 ��";
		}elseif($row_GYR['report_parish'] == '����ͤ�ͧ�˭�'){
			$arr[$row_GYR['report_id']]['data'] = $row_GYR['report_parish']."<br>�ӹǹ���á�Դ����鹷���¹ : 32 ��";
		}elseif($row_GYR['report_parish'] == '���������ԧ'){
			$arr[$row_GYR['report_id']]['data'] = $row_GYR['report_parish']."<br>�ӹǹ���á�Դ����鹷���¹ : 159 ��";
		}elseif($row_GYR['report_parish'] == '����ͺ�����'){
			$arr[$row_GYR['report_id']]['data'] = $row_GYR['report_parish']."<br>�ӹǹ���á�Դ����鹷���¹ : 122 ��";
		}elseif($row_GYR['report_parish'] == '����������ͺ'){
			$arr[$row_GYR['report_id']]['data'] = $row_GYR['report_parish']."<br>�ӹǹ���á�Դ����鹷���¹ : 87 ��";
		}elseif($row_GYR['report_parish'] == '�������Сٴ'){
			$arr[$row_GYR['report_id']]['data'] = $row_GYR['report_parish']."<br>�ӹǹ���á�Դ����鹷���¹ : 11 ��";
		}elseif($row_GYR['report_parish'] == '�������Ъ�ҧ'){
			$arr[$row_GYR['report_id']]['data'] = $row_GYR['report_parish']."<br>�ӹǹ���á�Դ����鹷���¹ : 2 ��";
		}
		
	
	?>
     <div style=" <?php echo $arr[$row_GYR['report_id']]['style'] ?>" class="tooltip|<?php echo $arr[$row_GYR['report_id']]['data']; ?>" ></div>
     <div class="markerText" style=" <?php echo $arr[$row_GYR['report_id']]['styletext'] ?> " ><?php echo $row_GYR['report_parish']?></div> 
    <?php 
	}
// ��ǹ�������еӺ�
}else if($level_area == 'district'){
	$area_id =  substr($_GET['area_id'],0,4)."%";
	?>
 	<td width="367" height="426" style="position:inherit; background-image:url('images/trat3.png'); background-repeat:no-repeat;">
    <?php
    ?>
     <div style=" <?php echo $arr[$row_GYR['report_id']]['style'] ?>" class="tooltip|<?php echo $arr[$row_GYR['report_id']]['data']; ?>"></div>
    <?php 
	// �ʴ� �����
	if($level_area == 'parish' ){
		$area_id =  substr($_GET['area_id'],0,6)."%";
		?>
 	<td width="377" height="426" style="position:inherit; background-image:url('trat3.png'); background-repeat:no-repeat;">
    <?php 
	?>
     <div style=" <?php echo $arr[$row_GYR['report_id']]['style'] ?>" class="images/tooltip|<?php echo $arr[$row_GYR['report_id']]['data']; ?>"></div>
    <?php 
		// �ʴ��ӺŹ��
	} 
}

if($_GET['debug']=='on'){
	echo "<pre>";
	print_r($arr);
	echo "<pre>";
}

?>     
        </td>
    </tr>
</table>
<script type="text/javascript">
	window.parent.document.getElementById('rpb_iframe').style.height="<?php echo $_GET['mapsize']=='s'?'450px':'645px'; ?>";
	window.parent.document.getElementById('rpb_iframe').style.width="<?php echo $_GET['mapsize']=='s'?($margin_val + 390).'px':($margin_val + 500).'px'; ?>";
</script>
</body>
</html>