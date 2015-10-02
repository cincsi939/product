<?php
/**
 * @comment ตั้งค่า report exec
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    23/06/2014
 * @access     public
 */
/*****************************************************************************
Function		: แก้ไขส่วนของ Executive Summary ของ Report
Version			: 1.0
Last Modified	: 28/7/2548
Changes		:
	28/7/2548	- ปรับส่วนของการแสดงผล Flash ที่ Stretch

*****************************************************************************/
include "db.inc.php";

// field's name & value for Executive Summary section
$sec = "E";
$tab ="table1";
$tsize = "tsize1";

$id = "";
$controltype = "";
$action = "";
if(isset($_GET['id'])){
	$id = intval($_GET['id']);
}
if(isset($_GET['controltype'])){
	$controltype = $_GET['controltype'];	
}
if(isset($_GET['action'])){
	$action = $_GET['action'];	
}

$do = "";
$row = "";
$column = "";
$controltype = "";
if(isset($_REQUEST['do'])){
	$do = $_REQUEST['do'];
}
if(isset($_REQUEST['row'])){
	$row = $_REQUEST['row'];	
}
if(isset($_REQUEST['column'])){
	$column = $_REQUEST['column'];	
}
if(isset($_REQUEST['controltype'])){
	$controltype = $_REQUEST['controltype'];	
}

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == "POST"){ 
		// remove slashes from variable
	foreach ($_POST as $key => $value){
		if (!is_array($value) && !is_numeric($value)){
			$_POST[$key] = stripslashes($value);
		}
	}
	
	if ($action == "updatetable"){
		$id = intval($_POST['id']);
		$bsize1 = intval($_POST['bsize1']);
		$bcolor1 = addslashes($_POST['bcolor1']);
		// update stretch mode & border style
		$bstretch = intval($_POST['bstretch']);
		$bstyle = intval($_POST['bstyle']);
		// @modify Phada Woodtikarn 05/08/2014
		if($bstretch == 2){
			if(intval($_POST['imgwidth']) == ""){
				$_POST['imgwidth'] = $wx;
			}
			if(intval($_POST['imgheight']) == ""){
				$_POST['imgheight'] = $hx;
			}
			$bsize = intval($_POST['imgwidth']).'x'.intval($_POST['imgheight']);
		}else{
			$bsize = "";
		}
		// @end
		mysql_query("UPDATE reportinfo SET bstyle=$bstyle,bstretch=$bstretch,bsize1=$bsize1,bcolor1='$bcolor1',bsize='$bsize' WHERE rid='$id' AND uname='$uname';");
		
		if (isset($_POST['edittable']) && $_POST['edittable'] == "1"){
			$r = intval($_POST['r']);
			$c = intval($_POST['c']);
			$newtsize = $r . "x" . $c;
			$table = "";
			for ($i=0;$i<$r;$i++){ 
				if ($i>0) $table .= "|";   // คั่น row
				for ($j=0;$j<$c;$j++){ 
					if ($j > 0) $table .= "*";  // คั่น column
					$table .= "1x1";
				}
			}
			mysql_query("UPDATE reportinfo SET $tsize='$newtsize',$tab='$table' WHERE rid='$id' AND uname='$uname';");
			if (mysql_errno()){
				$msg = "Cannot update table size.";
			}
		}

		// มีการ upload รูป Banner
		if ($_FILES['bpic']['name'] && $msg == ""){
			$ext1 = strtolower(substr($_FILES['bpic']['name'],strlen($_FILES['bpic']['name'])-3));
			$fname = addslashes(substr(trim($_FILES['bpic']['name']),0,200)); // limit to 200 chars
			$fsize = $_FILES['bpic']['size'];
			if ($ext1 == "peg") { $ext1 = "jpg"; }

			// change filename to id.ext
			$fname = $id . "." . $ext1;

			if (!($ext1=="jpg" || $ext1=="gif" || $ext1=='png' || $ext1=='swf')){
				$msg = "Only .jpg .jpeg .gif .png or .swf file allowed.";
			}else if ($fsize <=0 ){
				$msg = "File size is 0, please verify your picture file again.";
			} else {
				// No Error , SAVE
				$bstretch = intval($_POST['bstretch']);
				
				mysql_query("update reportinfo set bannerurl='$fname', bstretch=$bstretch where rid='$id' and uname='$uname';");
				if (mysql_errno() == 0){
					if (file_exists($bimgpath.$fname)){
						unlink($bimgpath.$fname);  // Delete it
					}
					move_uploaded_file($_FILES['bpic']['tmp_name'], $bimgpath.$fname);
					$msg = "";
				} else{
					$msg = "Cannot upload banner file.";
				}
			}
		}

//----------------------------------------------------- new feature ------------------------------------------------
		if($do == "cellnew"){
			for($row=1;$row<=$i;$row++){
				$newCell=$row.'.'.$j;
				$sql = "insert into cellinfo(uname,rid,sec,cellno) values('$uname','$id','$sec','$newCell');";
				mysql_query($sql);
			}
		}else if($do == "rownew"){
			for($col=1;$col<=$j;$col++){
				$newrow=$i.'.'.$col;
				$sql = "insert into cellinfo(uname,rid,sec,cellno) values('$uname','$id','$sec','$newrow');";
				mysql_query($sql);
			}
		}
//-------------------------------------------------------------------------------------------------------------------
		if ($msg == ""){
			header("Location: ?id=$id&controltype=$controltype");
			exit;
		}
		

	}else if ($action == "updatecell"){
		$id = intval($_POST['id']);
		$cell = $_POST['cell'];
		$caption = addslashes(str_replace("\"","'",$_POST['caption']));
		$font = addslashes(str_replace("\"","'",$_POST['font']));
		$alignment = addslashes(str_replace("\"","'",$_POST['alignment']));
		$valign = addslashes(str_replace("\"","'",$_POST['valign']));
		$bgcolor = addslashes(str_replace("\"","'",$_POST['bgcolor']));
		$url = addslashes(str_replace("\"","'",$_POST['url']));
		$cond = addslashes(str_replace("\"","'",$_POST['cond']));
		$furl = addslashes(str_replace("\"","'",$_POST['furl']));
		$nformat = intval($_POST['nformat']);
		$decpoint = intval($_POST['decpoint']);
		$celltype = intval($_POST['celltype']);
		$nblank = intval($_POST['nblank']);
		if ($celltype == 0) $cond = "";   // no condition for TextCell
		if ($celltype == 3) $cond = $furl;   // Keep function URL  in cond
		if ($celltype == 4) $cond = $cal;   // Keep calculation  in cond
		//if ($celltype == 5) $cond = $cal;   // Keep calculation  in cond
		// @modify Phada Woodtikarn 30/06/2014 เพิ่ม url type
		$urltype = intval($_POST['urltype']);
		// @end
		
		// set column width
		SetColumnWidth($id,$sec,$cell,$_POST['cwidth']);

		// Delete old value
		mysql_query("delete from cellinfo where rid='$id' and uname='$uname' and sec='$sec' and cellno='$cell';");

		// Insert new value
		// @modify Phada Woodtikarn 30/06/2014 เพิ่ม url type
		$sql = "insert into cellinfo(uname,rid,sec,cellno,caption,font,alignment,valign,bgcolor,url,cond,celltype,nformat,decpoint,urltype,nblank) values('$uname','$id','$sec','$cell','$caption','$font','$alignment','$valign','$bgcolor','$url','$cond',$celltype,$nformat,$decpoint,$urltype,$nblank);";
		// @end
		mysql_query($sql);

		if (mysql_errno()){
			$msg = "Cannot save cell's properties..";
		}else{
			header("Location: ?id=$id");
			exit;
		}

	}else if ($action == "mergecell"){
		$id = intval($_POST['id']);
		// Create SET of selected cell
		$cellset = "";
		foreach ($_POST as $key=>$value){
			if (substr($key,0,1) == "C" && $value == "1"){  // selected cell
				$cellno = $key;
				$cellno = str_replace("C","",$cellno);
				$cellno = str_replace("_",".",$cellno);
				if ($cellset > "") $cellset .= ",";
				$cellset .= "'$cellno'";

				$xresult = mysql_query("select * from cellinfo where rid='$id' and uname='$uname' and sec='$sec' and cellno='$cellno';");
				if (mysql_num_rows($xresult) <= 0){ // not found
					mysql_query("insert into cellinfo(uname,rid,sec,cellno) values('$uname','$id','$sec','$cellno');"); // INSERT IT TO cellinfo
				}
			}
		}

		if (isset($_POST['delete']) && $_POST['delete'] > ""){
			// CLEAR Cell's Properties
			$sql = "delete from cellinfo where rid='$id' and uname='$uname'and sec='$sec' and cellno in ($cellset);";
			mysql_query($sql);
			header("Location: ?id=$id");
			exit;
		}else if (isset($_POST['property']) && $_POST['property'] > ""){
			$nformat = intval($_POST['nformat']);
			$decpoint = intval($_POST['decpoint']);
			$alignment = $_POST['alignment'];
			$valign = $_POST['valign'];
			$font = addslashes($_POST['font']);
			$bgcolor = $_POST['bgcolor'];
			$nblank = intval($_POST['nblank']);

			$xval = "";
			
			if (isset($_POST['xnformat']) && $_POST['xnformat'] == "1"){
				$xval = "nformat = $nformat";
			}

			if (isset($_POST['xdecpoint']) && $_POST['xdecpoint'] == "1"){
				if ($xval > "") $xval .=",";
				$xval .= "decpoint = $decpoint";
			}

			if (isset($_POST['xalignment']) && $_POST['xalignment'] == "1"){
				if ($xval > "") $xval .=",";
				$xval .= "alignment = '$alignment'";
			}

			if (isset($_POST['xvalign']) && $_POST['xvalign'] == "1"){
				if ($xval > "") $xval .=",";
				$xval .= "valign = '$valign'";
			}

			if (isset($_POST['xfont']) && $_POST['xfont'] == "1"){
				if ($xval > "") $xval .=",";
				$xval .= "font = '$font'";
			}

			if (isset($_POST['xbgcolor']) && $_POST['xbgcolor'] == "1"){
				if ($xval > "") $xval .=",";
				$xval .= "bgcolor = '$bgcolor'";
			}
			
			if (isset($_POST['xnblank']) && $_POST['xnblank'] == "1"){
				if ($xval > "") $xval .=",";
				$xval .= "nblank = '$nblank'";
			}

			if ($xval > ""){
				
				$sql = "update cellinfo set $xval where rid='$id' and uname='$uname'and sec='$sec' and cellno in ($cellset);";
				mysql_query($sql);
			}

			header("Location: ?id=$id");
			exit;
		}
		
		$sql = "SELECT table1,tsize1 FROM `reportinfo` WHERE rid='$id' AND uname='$uname';";
		$result = mysql_query($sql);
		if ($result){
			$rs=mysql_fetch_array($result,MYSQL_ASSOC);
			$x = explode("x",$rs[$tsize]);
			$r = intval($x[0]);
			$c = intval($x[1]);

			$tspan=array();
			$tbrow = explode("|",$rs[$tab]);
			for ($i=0;$i<count($tbrow);$i++){
				$tbcol = explode("*",$tbrow[$i]);
				for ($j=0;$j<count($tbcol);$j++){
					$tspan[$i][$j] = $tbcol[$j];
				}
			}
			//หาเซลเริ่มต้นการ merge
			$found = 0;
			for ($i=1;$i<=$r;$i++){
				for ($j=1;$j<=$c;$j++){
					if (isset($_POST["C". $i . "_" . $j]) && $_POST["C". $i . "_" . $j] == "1"){
						if (!$found){
							$found = 1;
							$rstart = $i;
							$cstart = $j;
						}
					}
				}
			}

			if ($found){  // มีการ merge
				//หาเซลสิ้นสุดการ merge
				for ($i=$rstart;$i<=$r;$i++){
					for ($j=$cstart;$j<=$c;$j++){
						if (isset($_POST["C". $i . "_" . $j]) && $_POST["C". $i . "_" . $j] == "1"){
							$rfinish = $i;
							$cfinish = $j;
						}
					}
				}
			
				if ($rstart == $rfinish && $cstart == $cfinish){ // เลือกเซลเดียว
					header("Location: ?id=$id");   // Do nothing
					exit;
				}

				//ลด index ให้ match กับ array
				$rstart --; $rfinish--;
				$cstart --; $cfinish--;

				if ($rstart == $rfinish){ // Merge หลายเซลในแถวเดียวกัน
					$x = explode("x",$tspan[$rstart][$cstart]);
					// @modify Phada Woodtiakrn 16/09/2014 ตรวจดูว่า Merge Column เท่ากันมั้ย จะได้ไม่ Merge Cell ผิด
					$xfinish = explode("x",$tspan[$rfinish][$cfinish]);
					if($x[0] == $xfinish[0]){
					// @end
						$r1 = intval($x[0]);
						$c1 = ($cfinish - $cstart) + 1;
						$tspan[$rstart][$cstart] = $r1 . "x" . $c1;
	
						//update  other cell that merged
						for ($i=$cstart+1;$i<=$cfinish;$i++){ 
							$tspan[$rstart][$i] = $r1 . "x0";
						}
					}else{
						// @modify Phada Woodtiakrn 16/09/2014
						header("Location: ?id=$id&msg2=Cannot merge selected cells.");   // Do nothing row ไม่เท่ากัน 
						exit;
						// @end
					}

				}else if ($cstart == $cfinish){  // Merge Row ใน column เดียวกัน
					
					$x = explode("x",$tspan[$rstart][$cstart]);
					// @modify Phada Woodtiakrn 16/09/2014 ตรวจดูว่า Merge Row เท่ากันมั้ย จะได้ไม่ Merge Cell ผิด
					$xfinish = explode("x",$tspan[$rfinish][$cfinish]);
					if($x[1] == $xfinish[1]){
					// @end
						$c1 = intval($x[1]);
						$r1 = ($rfinish - $rstart) + 1;
						$tspan[$rstart][$cstart] = $r1 . "x" . $c1;
	
						//update  other cell that merged
						for ($i=$rstart+1;$i<=$rfinish;$i++){ 
							$tspan[$i][$cstart] = "0x" . $c1;
						}
					}else{
						// @modify Phada Woodtiakrn 16/09/2014
						header("Location: ?id=$id&msg2=Cannot merge selected cells.");   // Do nothing Column ไม่เท่ากัน 
						exit;
						// @end
					}

				}else{  // Merge ผิดแบบ
					header("Location: ?id=$id&msg2=Cannot merge selected cells.");   // Do nothing
					exit;
				}

				// Update field "table1"
				$table = "";
				for ($i=0;$i<$r;$i++){ 
					if ($i>0) $table .= "|";   // คั่น row
					for ($j=0;$j<$c;$j++){ 
						if ($j > 0) $table .= "*";  // คั่น column
						$table .= $tspan[$i][$j];
					}
				}

				mysql_query("update reportinfo set $tab='$table' where rid='$id' and uname='$uname';");
				if (mysql_errno()){
					$msg = "Cannot update table size.";
				}else{
					header("Location: ?id=$id");
					exit;
				}
			} // if มีการ merge

			
		}else{
			header("Location: ?id=$id&msg2=Cannot merge selected cells.");
			exit;
		}		
		
	}

}else if ($id > 0){
	$sql = "SELECT table1,tsize1,bcolor1,bsize1,bannerurl,bstyle,bstretch,bsize FROM `reportinfo` WHERE rid='$id' AND uname='$uname';";
	$result = mysql_query($sql);
	if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		if($rs){
			$x = explode("x",$rs[$tsize]);
			$r = intval($x[0]);
			$c = intval($x[1]);
	
			$tspan=array();
			$tbrow = explode("|",$rs[$tab]);
			for ($i=0;$i<count($tbrow);$i++){
				$tbcol = explode("*",$tbrow[$i]);
				for ($j=0;$j<count($tbcol);$j++){
					$tspan[$i][$j] = $tbcol[$j];
				}
			}
		}else{
			$msg = "Cannot find Report.";
		}
	} else {
		$msg = "Cannot find Report.";
	}

} else if ($msg == ""){
	$msg = "Cannot find Report.";
}
	
	// ------------------------------------------------------------ chart -----------------------------------------------------------
	
	if($do == "updatechart"){
		
		$valuex = $_POST['valuex'];
		$valuey = $_POST['valuey'];
		$cheader = $_POST['chartheader'];
		
		if($action == "updatechartheader"){
			
			mysql_query("update reportinfo set chart1='$cheader' where rid='$id' and uname='$uname';");
			if ($error = mysql_error()) die('Error, insert query failed with:' . $error);
			if (mysql_errno()){
					$msg = $error;
				}else{
					header("Location: ?id=$id");
					exit;
				}
		}else if($action == "addchart"){
			
			$sql = "insert into chartinfo(uname, rid, sec, valuex, valuey) values('$uname', '$id', '$sec', '$valuex', '$valuey');";
			mysql_query($sql);
				
			header("Location: ?id=$id");
			exit;
	
		}else if($action == "deletechart"){
			
			$sql = "delete from chartinfo  where rid='$id' and uname='$uname' and sec='$sec' and valuex='$valuex' and valuey='$valuey';";
			mysql_query($sql);
			
			header("Location: ?id=$id");
			exit;
		}
	}
	
	
	// -------------------------------------------------------- sql array set --------------------------------------------------------
/*	if($do == "updatesql"){
		
		 if ($_GET[action] == "updatesql"){ // update sql query json ----------------------------------------------------
			
			$sqlname = addslashes($_POST[txtsql]);
			$query = $_POST[txtquery];
			$desc = $_POST[txtdesc];
			//echo  $id." ".$sec." ".$uname." ".$sqlname.", ".$query.", ".$desc;
			
			if($sqlname != ""){
				$sql="select * from report_sqldata where rid='$id' and uname='$uname' and sec='$sec' and sqlname='$sqlname';";
				$result = mysql_query($sql);
				$rs = mysql_fetch_array($result);
				if($rs['sqlname']==""){  
					//create new 
					$sql = "insert into report_sqldata(uname, rid, sec, sqlname, query, description) values('$uname', '$id', '$sec', '$sqlname', '$query', '$desc');";
					mysql_query($sql);
				}else{
					// update sql 
					$sql = "update report_sqldata set query='$query', description='$desc' where rid='$id' and uname='$uname' and sec='$sec' and sqlname='$sqlname';";
					mysql_query($sql);
				}
				
			}
			
			header("Location: ?id=$id");
			exit;
	
		}else  if ($_GET[action] == "deletesql"){
			$sqlname = addslashes($_POST[txtsql]);
			$sql = "delete from report_sqldata  where rid='$id' and uname='$uname' and sec='$sec' and sqlname='$sqlname';";
			mysql_query($sql);
			
			header("Location: ?id=$id");
			exit;
		}
	}*/
	
	// ---------------------------------------------------- table control -------------------------------------------------------
	if($do=="deleterow"){
		$sql = "select table1 from reportinfo where rid='$id' and uname='$uname';";
		$result = mysql_query($sql);
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		$newtsize=($r-1)."x".$c;
		
		$deleterow=$row-1;
		$newtable="";
		$tbrow = explode("|",$rs["table1"]);
		for ($i=0;$i<count($tbrow);$i++){
				//if ($i>0 && $i!==$deleterow) $newtable .= "|"; 
				if($i!==$deleterow)$newtable.=$tbrow[$i];
				if($i!==$deleterow && $i<($r-1))$newtable .= "|"; 
		}
		
		mysql_query("update reportinfo set tsize1='$newtsize', table1='$newtable' where rid='$id' and uname='$uname';");
		$sql = "delete from cellinfo where  rid='$id' and uname='$uname' and sec='$sec' and cellno LIKE '$row.%' ;";
		mysql_query($sql);
		
		for($rw=($row+1); $rw<=$r;$rw++){
			for($col=1; $col<=$c;$col++){
				$index = $rw.'.'.$col;
				$indexnew = ($rw-1).'.'.$col;
				$sql = "update cellinfo set cellno = '$indexnew' where  rid='$id' and uname='$uname' and sec='$sec' and cellno = '$index' ;";
				mysql_query($sql);
			}
		}
		
		header("Location: ?id=$id&controltype=$controltype");
		exit;
	}else if($do=="deletecolumn"){
		$sql = "select table1 from reportinfo where rid='$id' and uname='$uname';";
		$result = mysql_query($sql);
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		$newtsize=$r."x".($c-1);
		
		$deletecolumn=$column-1;
		$newtable="";
		$tbrow = explode("|",$rs["table1"]);
		for ($i=0;$i<count($tbrow);$i++){
				if ($i>0) $newtable .= "|"; 
				$tbcol = explode("*",$tbrow[$i]);
			for ($j=0;$j<count($tbcol);$j++){
				if($j!==$deletecolumn)$newtable.=$tbcol[$j];
				if($j!==$deletecolumn && $j<($c-1))$newtable .= "*"; 
			}
		}
		//echo $newtable;
		//exit;
		
		mysql_query("update reportinfo set tsize1='$newtsize', table1='$newtable' where rid='$id' and uname='$uname';");
		$sql = "delete from cellinfo where  rid='$id' and uname='$uname' and sec='$sec' and cellno LIKE '%.$column' ;";
		mysql_query($sql);
		
		for($row=1; $row<=$r;$row++){
			for($col=($column+1); $col<=$c;$col++){
				$index = $row.'.'.$col;
				$indexnew = $row.'.'.($col-1);
				$sql = "update cellinfo set cellno = '$indexnew' where  rid='$id' and uname='$uname' and sec='$sec' and cellno ='$index';"; 
				mysql_query($sql);
			}
		}
		
		header("Location: ?id=$id&controltype=$controltype");
		exit;
		
	}else if($do=="changecell"){
		$cv = array();
		$sql="SELECT * FROM cellinfo where rid='$id' AND uname='$uname' AND sec='$sec' ;";
		$result = mysql_query($sql);
		while ($rs = mysql_fetch_assoc($result)){
				$i=$rs['cellno'];
				$cv[$i][0] = $rs['caption'];
				$cv[$i][1]  = $rs['font'];
				$cv[$i][2] = $rs['alignment'];
				$cv[$i][3] = $rs['valign'];
				$cv[$i][4] = $rs['bgcolor'];
				$cv[$i][5]  =  $rs['url'];
				$cv[$i][6] =  $rs['cond'];
				$cv[$i][7]  =  $rs['celltype'];
				$cv[$i][8] = $rs['nformat'];
				$cv[$i][9] =$rs['decpoint'];
				// @modify Phada Woodtikarn 16/08/2014 เพิ่ม field ใหม่
				$cv[$i][10] =$rs['urltype'];
				$cv[$i][11] =$rs['nblank'];
				// @end
				//echo $i.": ".$cv[$i][0].", ".$cv[$i][6].", ".$cv[$i][7]."<br/>";
		}	
		
		$json = json_decode (stripslashes ($_REQUEST['cell']), true); 
		for ($i=0; $i < count($json[0]); $i++) {
			$bf = $json[1][$i];
			$af= $json[0][$i];
	    	//if (mysql_num_rows($result) == 0)
			
			$caption= addslashes($cv[$bf][0]);
			$font = addslashes($cv[$bf][1]);
			$alignment = addslashes($cv[$bf][2]);
			$valign = addslashes($cv[$bf][3]);
			$bgcolor = addslashes($cv[$bf][4]);
			$url =addslashes($cv[$bf][5]);
			$cond = addslashes($cv[$bf][6]);
			$celltype = intval($cv[$bf][7]);
			$nformat = intval($cv[$bf][8]);
			$decpoint = intval($cv[$bf][9]);
			// @modify Phada Woodtikarn 16/08/2014 เพิ่ม field ใหม่
			$urltype = intval($cv[$bf][10]);
			$nblank = intval($cv[$bf][11]);
			// @end
			
			//echo $af."<==".$bf.": ".$cv[$bf][0].", ".$cv[$bf][6].", ".$celltype."<br/>";
			// @modify Phada Woodtikarn 16/08/2014 เปลี่ยน จาก update เป็น replace into
			$sql = 'REPLACE INTO cellinfo SET 
					uname="'.$uname.'",
					rid="'.$id.'",
					sec="'.$sec.'",
					cellno="'.$af.'",
					caption="'.$caption.'", 
					font="'.$font.'", 
					alignment="'.$alignment.'", 
					valign="'.$valign.'", 
					bgcolor="'.$bgcolor.'", 
					url="'.$url.'", 
					cond="'.$cond.'", 
					celltype="'.$celltype.'", 
					nformat="'.$nformat.'", 
					decpoint="'.$decpoint.'",
					urltype="'.$urltype.'",
					nblank="'.$nblank.'";';
			mysql_query($sql);
		}
		header("Location: ?id=$id");
		exit;
		//print "<meta http-equiv=refresh content=0;URL=report_exec.php?id=$id>";
	}
	// @modify Phada Woodtikarn 30/07/2014 $rs ถูกไฟล์ที่ include มาทับ
	$image['bannerurl'] = $rs['bannerurl'];
	$image['bstyle'] = $rs['bstyle'];
	$image['bstretch'] = $rs['bstretch'];
	// @end
?>

<html>
<head>
<title>Report Management : Executive Summary</title>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<!--<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">-->
<link href="report.css" type="text/css" rel="stylesheet">
<script language="javascript" src="dbselect.js"></script>
<?php // @modify Phada Woodtikarn 04/07/2014 comment เพราะ 102 เน่า ?>
<!--<script>
	$.post("http://202.129.35.102/punchai/callcenter_otcsc/application/callcenter_otcsc/callcenterlog/ticker.php", function( data ) {
		alert('dddd');			
	});
</script>-->
<?php // @end ?>
</head>

<body bgcolor="#FFFFFF" onLoad="loadsqlset()">

<table border=0 width="100%" cellspacing=1 bgcolor=black>
<tr><td>
<?php
// @modify Phada Woodtikarn 21/07/2014 เนื่องจาก menu ใช้หลายหน้าเลยสร้างไว้อันเดียว
include "report_top_menu.php";
// @end
?>
</td></tr>
</table>
<BR>

<!-- Tab Header -->
<table border=0 width="100%" cellspacing=0 CELLPADDING=0>
<tr valign=baseline>
<td><a href="report_edit.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab0.gif" border=0></a></td>
<td><img src="<?php echo $imgpath ?>tabx1.gif" border=0></td>
<td><a href="report_header.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab2.gif" border=0></a></td>
<td><a href="report_info.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab3.gif" border=0></a></td>
<td><a href="report_footer.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab4.gif" border=0></a></td>
<td><a href="report_param.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab5.gif" border=0></a></td>
<td width="50%"><img src="<?php echo $imgpath ?>/black.gif" width="100%" height="1"></td>
</tr>
</table> 

<table border=0 width="100%" cellspacing=0 CELLPADDING=0>
<tr BGCOLOR="#6F96C6"><td><FONT SIZE="-2" COLOR="WHITE">&nbsp;Executive Summary section.</FONT></td></tr>
<tr HEIGHT=1 BGCOLOR="#406080"><td></td></tr>
</table>
<!-- End Tab Header -->

<table border=0 width="100%" cellspacing=0 CELLPADDING=0>
<tr BGCOLOR="#AACCEE" valign=middle><td>

<?php
// ERROR MESSAGE
if ($msg != ''){
	echo "<h1 align=center>$msg</h1></body></html>";
	exit;
}
?>
<A HREF="report_preview.php?id=<?=$id?>&sec=<?=$sec?>" title="Preview" target="_blank"><img src="<?php echo $imgpath; ?>preview.gif" border="0" style="margin-right:5px">Preview this section</A>
&nbsp; <A HREF="report_export.php?id=<?=$id?>&sec=<?=$sec?>" title="Export" target="_blank"><img src="<?php echo $imgpath; ?>export.gif" border="0" style="margin-right:5px">Export this section</A>
<br>
<br>
<table width="100%">
	<tr valign="top">
    	<td width="600px">
       	<FORM name="updatetable" ACTION="?action=updatetable" METHOD=POST ENCTYPE="multipart/form-data">
		<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
            <table width="90%" border=0 align=center>
                <tr><td><B>Table Size</B> &nbsp; </td>
                <td>
                <INPUT TYPE="text" id="r" NAME="r" VALUE="<?=$r?>" size="2" maxlength="2" disabled> Rows <FONT COLOR="RED"><B>X</B></FONT> 
                <INPUT TYPE="text" id="c" NAME="c" VALUE="<?=$c?>" size="2" maxlength="2" disabled> Columns
                &nbsp; <INPUT TYPE="checkbox" NAME="edittable" value="1" ONCLICK="document.forms[0].r.disabled = document.forms[0].c.disabled = !this.checked;"> Edit Table Size
                </td></tr>
                
                <tr valign=top><td><B>Border Size</B></td><td>
                    <input type="text" id="bsize1" name="bsize1" size="2" maxlength=2 value="<?=$rs['bsize1']?>"> 
                </td></tr>
                
                <tr valign=top><td><B>Border Color</B></td><td>
                    <input type="text" name="bcolor1" size="10" class="kolorPicker"   value="<?=$rs['bcolor1']?>"> 
                    <!--<INPUT TYPE="BUTTON" VALUE=" Select Color" CLASS="xbutton" ONCLICK="PickColor(document.forms[0].bcolor1);">-->
                </td></tr>
                
                <tr><td><B>Banner</B> &nbsp; </td>
                <td>
                <INPUT TYPE="FILE" NAME="bpic" SIZE="40">
                </td></tr>
                
                <tr><td><B>Stretch Mode</B></td>
                <td>
                <input type="radio" name="bstretch" value="0" <?php if ($rs['bstretch'] == 0) echo "CHECKED"?>> Default size - Best fit (<?=$wx?> x <?=$hx?>) <br>
                <input type="radio" name="bstretch" value="1" <?php if ($rs['bstretch'] == 1) echo "CHECKED"?>> Stretch <br>
                <?php
                // @modify Phada Woodtikarn 05/08/2014 เพิ่มการกำหนด size เอง
				if($rs['bstretch'] == 2 && isset($rs['bsize'])){
					$bsize = explode('x',$rs['bsize']);
				}else{
					$bsize[0] = "";
					$bsize[1] = "";	
				}
				?>
                <input type="radio" name="bstretch" value="2" <?php if ($rs['bstretch'] == 2) echo "CHECKED"?>> Config
                <input class="configimg" type="text" name="imgwidth" value="<?php echo $bsize[0] ?>" size="2" maxlength="3" style="margin-left:10px;" <?php echo $rs['bstretch']!= 2?'disabled':'';?>> x
                <input class="configimg" type="text" name="imgheight" value="<?php echo $bsize[1] ?>" size="2" maxlength="3" <?php echo $rs['bstretch']!= 2?'disabled':'';?>>
                <?php // @end ?>
                </td></tr>
                
                <tr><td><B>Banner Style</B> &nbsp; </td>
                <td>
                <select name="bstyle">
                    <option value="0" <?php if ($rs['bstyle'] == 0) echo "SELECTED"?>> Image
                    <option value="1" <?php if ($rs['bstyle'] == 1) echo "SELECTED"?>> Flash
                    <?php // @modify Phada Woodtikarn 05/08/2014 ?>
                    <option value="3" <?php if ($rs['bstyle'] == 3) echo "SELECTED"?>> None
                    <?php // @end ?>
                </select>
                </td></tr>
                
                <tr><td>&nbsp;</td>
                <td>
                <INPUT TYPE="SUBMIT" VALUE="   Update  "> 
                <INPUT TYPE="reset" VALUE="   Undo   ">
                <INPUT TYPE="reset" VALUE="   Reset   ">
                </td></tr>
                
                <?php
					if(isset($_GET['msg2'])){
						echo "<tr><td colspan=2><B>$_GET[msg2]</B></td></tr>";
					}
                ?>
                </table>
                
                </FORM>
        </td>
        <td align="left">
        	 <div style="min-width: 100px; float: left;">
				<?php include "report_chartcontrol.php";?>
       		</div>
        	<div style="float: left;margin-left: 20px;">
        	<INPUT TYPE="BUTTON" VALUE=" SQL-Set " ONCLICK="SqlSetDialog();" >
            </div>
            <?php include "dbset.php";?>   
            
        </td>
	</tr>
</table>


<!-- Thin Line -->
<table border=0 width="100%" cellspacing=0 cellpadding=0>
<tr HEIGHT=1 BGCOLOR="#000000"><td></td></tr>
</table>
<!-- End Thin Line -->

<!-- Display Table & Merge Cell -->

<script type="text/javascript">
	function chkAll(n){
		if(n==1){	
			$('input.checkfield').attr('checked', true);
		}else {
			$('input.checkfield').removeAttr('checked');			
		}	
	}
</script>
<form action="?action=mergecell" method="POST" NAME="mergeform">
<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">

<table border=0 width="100%" cellspacing=2 cellpadding=5 bgcolor="#404040">
<tr valign=middle BGCOLOR="#F4F8FF"><td width="90%">

<!--  ########################################## new script  #########################################   -->  
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/jquery-numeric.js"></script>
<link rel="stylesheet" href="js/jquery-ui-themes-1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="js/jstable/dragtable.css" />
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="js/jstable/jquery.dragtable.js"></script>
<script src="js/kolorpicker/jquery.kolorpicker.js" type="text/javascript"></script>
<link rel="stylesheet" href="js/kolorpicker/style/kolorpicker.css" type="text/css" />
<script>
	$(document).ready(function() {
		$('#defaultTable thead').hide();
		$('#defaultTable').show();
		<?php // @modify Phada Woodtikarn 21/07/2014 ?>
		$('#r').numeric();
		$('#c').numeric();
		$('#txtrow').numeric();
		$('#txtcol').numeric();
		$('#bsize1').numeric();
		<?php // @end ?>
		<?php // @modify Phada Woodtikarn 05/08/2014 ?>
		$('.configimg').numeric();
		$('input[name=bstretch]').click(function(){
			if($(this).val() == 2){
				$('.configimg').removeAttr('disabled');
			}else{
				$('.configimg').attr('disabled','disabled');
			}
		});
		<?php // @end ?>
		//$('#defaultTable tbody th').hide();
		//$('#defaultTable thead').css('display', 'none');
    	//$('#defaultTable').dragtable();
    	//$('#defaultTable tbody tr').sortable({
        //     connectWith: ".connectedSortable"
        //});
		$('#boxdefault').css('display', 'none');
  	});
</script>
<?php include "report_tablecontrol.php";?>
<!--
defaultTable tbody tr td
row_index = $(event.target).parent().index();
col_index = $(event.target).index();
-->
<!--  ########################################## Report Exec #########################################   
<table border=0 bgcolor=black width="100%" align=center cellspacing=1 cellpadding=0 id="defaultTable"  onclick="defaultTableClick()">--> 
<table style="border:0; background-color:#333;display:none;"  width="100%" align="center" cellspacing="1" cellpadding="0" id="defaultTable" data-mode="columntoggle">
	<thead>
		<tr onMouseDown="getHeaderIndex(event);">
		<?php
			$colno=1;
			for ($j=1;$j<=$c;$j++){
				$x = explode("x",$tspan[0][$j-1]);
				$rspan = intval($x[0]);
				$cspan = intval($x[1]);
				echo "<th class='ui-widget-header' onMouseOver='headerhover(this)'  onMouseOut='headerUnhover()' >h".$j."</th>";
				/*echo "<th id='$j' colspan='$cspan' rowspan='$rspan' class='ui-widget-header' ><a href='#'  onclick='movecol($colno)'><</a> h".$colno."</th>";
				if($cspan==1)$colno++;
				if($cspan >1) {
					$j++;		
					$colno++;
				}*/
			}
		?>
		</tr>
	</thead>
    <tbody>
<?php
$px = intval(100 / $c); // ความกว้างแต่ละเซล
for ($i=1;$i<=$r;$i++){
	echo "<tr bgcolor='#F0F0F0' valign='top' id='trIndex' onclick='getIndex(event);' >";
	//echo "<th>r".$i."</th>";
	for ($j=1;$j<=$c;$j++){
		$x = explode("x",$tspan[$i-1][$j-1]);
		$rspan = intval($x[0]);
		$cspan = intval($x[1]);
		if ($rspan > 0 && $cspan > 0){
			//echo $i.".".$j.":".GetCellProperty($id,$sec,$i . "." . $j).", colspan=".$cspan.", rowspan=".$rspan.", width=".$px."%"."<br/>";
			?>
			<!--<td <?echo GetCellProperty($id,$sec,$i . "." . $j)?> width='<?=$px?>%' colspan='<?=$cspan?>' rowspan='<?=$rspan?>' id="tdCell">-->
			<td <? echo GetCellProperty($id,$sec,$i . "." . $j)?>  width='100px'  colspan='<?=$cspan?>' rowspan='<?=$rspan?>' id="tdCell"  >
				
				<!--<a href="#" id='txtpaste' title="import cell style" onclick='pasteproperties(event)'>&laquo;</a>-->
				
                <!--  ######################################## Field Report Exec #######################################   --> 
				<table border=0 cellspacing=0 cellpadding=0 width='20' height="20" align="left" id="execTable">
					<tr valign="top">
						<td align=center width='25' bgcolor='#FF6633'>
							<A HREF="?action=cell&id=<?=$id?>&cell=<?=$i?>.<?=$j?>" title="Edit Cell Properties"><FONT COLOR="BLACK"><B><U><?=$i?>.<?=$j?></U></B></FONT></A>
						</td>
						<td width='15' align=left><input type="checkbox" class="checkfield" name="C<?=$i?>_<?=$j?>" value="1"></td>
					</tr>
				</table>
				<!--  ######################################## Field Report Exec #######################################   --> 
				
				<?=GetCellValue($id,$sec,$i . "." . $j)?>

			</td>
			<?
		}
	}
	echo "</tr>";
}
?></tbody>
</table>

<table border=0 width="95%" align=center cellspacing=1 cellpadding=0>
<tr><td align=right>
<input type="button" value=" Check all " style="font-weight: bold;" onClick="chkAll(1)">
<input type="button" value=" Uncheck all " style="font-weight: bold;" onClick="chkAll(0)">
<input type="submit" value=" Merge Selected Cell " style="font-weight: bold;" name="Merge">
<input type="submit" value=" Clear Selected Cell " style="font-weight: bold;" name="delete" onClick="if (!confirm('ต้องการลบข้อมูลนี้จริงหรือไม่?')) return false;">
<input type="button" value=" Selected Cell's Property " style="font-weight: bold;" name="delete" onClick="DisplayElement ( 'cellprop', 'table');">
</td></tr>
</table>

<!-- End Display Table & Merge Cell -->

</td>
<td width="<?=$wx+10?>" align="center" valign="middle">
<!-- BANNER -->
<?php
if(is_file($bimgpath.$image['bannerurl']) && $image['bstyle'] != 3 ){
	if($image['bstyle'] == 0){ //Image
		if ($image['bstretch'] == 1){
			echo '<img src="'.$bimgpath.$image['bannerurl'].'" alt="Banner" border="0" width="'.$wx.'" height="'.$hx.'">';
		}else if ($image['bstretch'] == 2){
			echo ChangeSizeImage($bimgpath.$image['bannerurl'],$bsize[0],$bsize[1]);
		}else{
			echo '<img src="'.$bimgpath.$image['bannerurl'].'" alt="Banner" border="0">';
		}
	}else if($image['bstyle'] == 1){ // Flash
		if ($image['bstretch'] == 1){
			$setwidth = "width='$wx' height='$hx' ";
		}else{
			$setwidth="";
		}
?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" <?php echo $setwidth; ?>>
<param name="movie" value="<?php echo $bimgpath.$image['bannerurl']; ?>">
<param name="quality" value="high">
<embed src="<?php echo $bimgpath.$image['bannerurl']?>" quality="100%" 
pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
</object>
<?php
	}
}else{
	echo '<img src="'.$imgpath.'banner.gif" alt="Banner" border="0" width="'.$wx.'" height="'.$hx.'">';
}
?>

</td>
</tr></table>

<BR>
<?php
include "selectedcellprop.inc.php";
?>

</form>


<?php
if($action == "cell" && !isset($_GET['cell'])){
	$_GET['cell'] = "";
}
if ($action == "cell" && $_GET['cell'] > 0){
	$cell = $_GET['cell'];
	$sql = "select * from cellinfo where rid='$id' and uname='$uname' and sec='$sec' and cellno='$cell';";
	$result = mysql_query($sql);
	if ($result){
		$crs=mysql_fetch_array($result,MYSQL_ASSOC);
	}else{
		$crs = array();
	}

?>
<table border=0 width="100%" cellspacing=0 cellpadding=0 bgcolor="WHITE">
<tr><td>

<BR>
<FORM name="cellform" method="post" action="?action=updatecell&id=<?=$id?>">
<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
<INPUT TYPE="hidden" NAME="cell" VALUE="<?=$cell?>">
<table border=0 width="80%" align=center cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white><td align=LEFT>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr valign="middle" height="30"> 
          <td align="center" width="35" bgcolor="#FF6633"><b style="font-size: 12pt;"><?=$_GET['cell']?></b></td>
		  <td width="1" BGCOLOR=BLACK></td>
          <td align="left" width="60%" bgcolor="#999999"><b style="font-size: 12pt;">&nbsp;&nbsp;Cell Properties :</b></td>
          <td align="RIGHT" bgcolor="#999999"> 
			<INPUT TYPE="submit" VALUE=" Save " STYLE="font-weight: bold;"> 
			<INPUT TYPE="button" VALUE=" Cancel " STYLE="font-weight: bold;" ONCLICK="location.href='?id=<?=$id?>';"> &nbsp;
		  </td>
        </tr>
      </table>
</td></tr>
<tr bgcolor="#F0F0F0"><td align=LEFT>

      <br>
      		
              <table width="90%" border="0" cellspacing="1" cellpadding="2" align="CENTER" bgcolor="#6699E0">

                <tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130"> 
                    &nbsp;&nbsp;<B>Cell Type</B></td>
                  <td align="left" width="500">  
		              <input type="radio" name="celltype" value="0" <? if (intval($crs['celltype'])==0) echo "CHECKED";?> ONCLICK="DisplayElement ( 'condition', 'none');DisplayElement ( 'function', 'none');DisplayElement ( 'calculate', 'none');DisplayElement ( 'sqlarr', 'none');"> <B>TEXT</B> 
				      <input type="radio" name="celltype" value="1" <? if (intval($crs['celltype'])==1) echo "CHECKED";?> ONCLICK="DisplayElement ( 'condition', 'block');DisplayElement ( 'function', 'none');DisplayElement ( 'calculate', 'none');DisplayElement ( 'sqlarr', 'none');DisplayElement ( 'sqlquery', 'inline');"> <B>DATABASE</B> 
				      <input type="radio" name="celltype" value="3" <? if (intval($crs['celltype'])==3) echo "CHECKED";?> ONCLICK="DisplayElement ( 'condition', 'none');DisplayElement ( 'function', 'block');DisplayElement ( 'calculate', 'none');DisplayElement ( 'sqlarr', 'none');"> <B>FUNCTION</B> 
				      <input type="radio" name="celltype" value="4" <? if (intval($crs['celltype'])==4) echo "CHECKED";?> ONCLICK="DisplayElement ( 'condition', 'none');DisplayElement ( 'function', 'none');DisplayElement ( 'calculate', 'block');DisplayElement ( 'sqlarr', 'none');"> <B>CALCULATION</B> 
                      <input type="radio" name="celltype" value="5" <? if (intval($crs['celltype'])==5) echo "CHECKED";?> ONCLICK="DisplayElement ( 'condition', 'block');DisplayElement ( 'function', 'none');DisplayElement ( 'calculate', 'none');DisplayElement ( 'sqlarr', 'inline');DisplayElement ( 'sqlquery', 'none');"> <B>SQL-SET</B> 
					</td>
                </tr>

				<tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130"> 
                    &nbsp;&nbsp;<B>Caption</B></td>
                  <td align="left" width="500">  
                    <input type="text" name="caption" size="60" value="<?=$crs['caption']?>">
                    </td>
                </tr>
           
				<tr valign="middle" bgcolor="#CCE8FD" id="condition" <? if (intval($crs['celltype'])!=1 && intval($crs['celltype'])!=5) echo "style='display:none;'";?>> 
                  <td align="left" width="130"> 
                    &nbsp;&nbsp;<B>Condition</B></td>
                  <td align="left" width="500">  
                    <!--<input type="text" id="cond" name="cond" size="60" value="<?=$crs['cond']?>">  -->
                    <textarea name="cond" rows="5" cols="80" id="cond"><?=$crs['cond']?></textarea> 
					<INPUT TYPE="BUTTON" VALUE=" SQL Query " CLASS="xbutton" ONCLICK="SelectCondition(document.cellform.cond);" id="sqlquery" <? if (intval($crs['celltype'])!=1) echo "style='display:none;'";?>>
                    <INPUT TYPE="BUTTON" VALUE=" SQL-Set "  ONCLICK="SqlSetDialog();" id="sqlarr" <?php if (intval($crs['celltype'])!=5) echo "style='display:none;'";?>>
                    </td>
                </tr>

				<tr valign="middle" bgcolor="#CCE8FD" id="function" <? if (intval($crs['celltype'])!=3) echo "style='display:none;'";?>> 
                  <td align="left" width="130">
                    &nbsp;&nbsp;<B>Function URL</B></td>
                  <td align="left" width="500">  
                    <input type="text" name="furl" size="70" value="<?=$crs['cond']?>">  
                    </td>
                </tr>

				<tr valign="middle" bgcolor="#CCE8FD" id="calculate" <? if (intval($crs['celltype'])!=4) echo "style='display:none;'";?>> 
                  <td align="left" width="130"> 
                    &nbsp;&nbsp;<B>Calculation</B></td>
                  <td align="left" width="500">  
                    <input type="text" name="cal" size="70" value="<?=$crs['cond']?>">  
                    </td>
                </tr>
           
				<tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Format</B></td>
                  <td align="left" width="500">
					  <?php // @modify Phada Woodtikarn 26/06/2014 เปลี่ยนคำ?>  
					  <select name="nformat">
                          <option value="0" <?php echo $crs['nformat']==0?'selected':'';?>>Number Natural Value</option>
                          <option value="1" <?php echo $crs['nformat']==1?'selected':'';?>>Number Normal Value</option>
                          <option value="2" <?php echo $crs['nformat']==2?'selected':'';?>>Number Invert Value</option>
                          <?php // @modify Phada Woodtikarn 25/06/2014 เพิ่ม format แบบ ไทย ?>
                          <option value="3" <?php echo $crs['nformat']==3?'selected':'';?>>Date eng2thai(Short)</option>
                          <option value="4" <?php echo $crs['nformat']==4?'selected':'';?>>Date eng2thai(Full)</option>
                          <?php // @end ?>
                          <?php // @modify Phada Woodtikarn 28/06/2014 เพิ่ม format อายุปีเดือน ?>
                          <option value="5" <?php echo $crs['nformat']==5?'selected':'';?>>Age Year Month</option>
                          <?php // @end ?>
                          <?php // @modify Phada Woodtikarn 30/09/2014 เพิ่ม format ซ่อนข้อมูล ?>
                          <option value="6" <?php echo $crs['nformat']==6?'selected':'';?>>Hide Value</option>
                          <?php // @end ?>
					  </select>
                      <?php // @end ?>
                    </td>
                </tr>
                <?php // @modify Phada Woodtikarn 13/08/2014 เพิ่ม blank value ?>
                <tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Blank Value</B></td>
                  <td align="left" width="500">
					  <select name="nblank">
                          <option value="0" <?php echo $crs['nblank']==0?'selected':'';?>>(Default)</option>
                          <option value="1" <?php echo $crs['nblank']==1?'selected':'';?>>N/A</option>
                          <option value="2" <?php echo $crs['nblank']==2?'selected':'';?>>-</option>
                          <option value="3" <?php echo $crs['nblank']==3?'selected':'';?>>0</option>
                          <option value="4" <?php echo $crs['nblank']==4?'selected':'';?>>NULL</option>
                          <option value="5" <?php echo $crs['nblank']==5?'selected':'';?>>None</option>
					  </select>
                    </td>
                </tr>
                <?php // @end ?>
				<tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Decimal Point</B></td>
                  <td align="left" width="500">  
					  <SELECT NAME="decpoint">
					  <OPTION VALUE="0" <?php if ($crs['decpoint'] == 0) echo "SELECTED";?>>Natural</OPTION>
					  <OPTION VALUE="1" <?php if ($crs['decpoint'] == 1) echo "SELECTED";?>>2 decimal point (.00)</OPTION>
					  <OPTION VALUE="2" <?php if ($crs['decpoint'] == 2) echo "SELECTED";?>>3 decimal point (.000)</OPTION>
					  <OPTION VALUE="3" <?php if ($crs['decpoint'] == 3) echo "SELECTED";?>>No decimal point</OPTION>
					  </SELECT>
                    </td>
                </tr>

				<tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Fonts</B></td>
                  <td align="left" width="500">  
                    <input type="text" name="font" size="60" value="<?=$crs['font']?>">  
					<INPUT TYPE="BUTTON" VALUE=" Select Font" CLASS="xbutton" onClick="SelectFont(document.cellform.font, document.cellform.caption.value);">
                    </td>
                </tr>

<?
//ตรวจสอบฐานข้อมูลก่อน ว่าได้เปลี่ยนโครงสร้างตาราง reportinfo ให้รองรับความกว้าง (cwidth1,cwidth2,cwidth3,cwidth4) หรือยัง
if (canSetWidth()){
?>
				<tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Column Width</B></td>
                  <td align="left" width="500">  
                  <input type="text" name="cwidth" size="10" maxlength=10 value="<?=GetColumnWidth($id,$sec,$cell)?>">  
				  (pixel or percent with %)
                  </td>
                </tr>
<?
}	
?>

                <tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Alignment</B></td>
                  <td align="left" width="500">  
					  <SELECT NAME="alignment" style="width:100;">
					  <OPTION VALUE="LEFT" <?php if ($crs['alignment'] == "TOP") echo "SELECTED";?>>Left</OPTION>
					  <OPTION VALUE="RIGHT" <?php if ($crs['alignment'] == "RIGHT") echo "SELECTED";?>>Right</OPTION>
					  <OPTION VALUE="CENTER" <?php if ($crs['alignment'] == "CENTER") echo "SELECTED";?>>Center</OPTION>
					  </SELECT>
                    </td>
                </tr>

                <tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Vertical Alignment</B></td>
                  <td align="left" width="500">  
					  <SELECT NAME="valign" style="width:100;">
					  <OPTION VALUE="TOP" <?php if ($crs['valign'] == "TOP") echo "SELECTED";?>>Top</OPTION>
					  <OPTION VALUE="MIDDLE" <?php if ($crs['valign'] == "MIDDLE") echo "SELECTED";?>>Middle</OPTION>
					  <OPTION VALUE="BASELINE" <?php if ($crs['valign'] == "BASELINE") echo "SELECTED";?>>Baseline</OPTION>
					  </SELECT>
                    </td>
                </tr>

				<tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Background</B></td>
                  <td align="left" width="500">   
                    <input type="text"  name="bgcolor" size="10" class="kolorPicker" value="<?=$crs['bgcolor']?>"  >
					<!--<INPUT TYPE="BUTTON" VALUE=" Select Color" CLASS="xbutton" ONCLICK="PickColor(document.cellform.bgcolor);">-->
                    </td>
                </tr>
                <tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Url</B></td>
                  <td align="left" width="500">  
                    <input type="text" name="url" size="70" value="<?=$crs['url']?>">
                    <?php // @modify Phada Woodtikarn 30/06/2014 เพิ่ม Target?>  
					  <select name="urltype">
                          <option value="0" <?php echo $crs['urltype']==0?'selected':'';?>>_self</option>
                          <option value="1" <?php echo $crs['urltype']==1?'selected':'';?>>_blank</option>
                          <option value="2" <?php echo $crs['urltype']==2?'selected':'';?>>_parent</option>
                          <option value="3" <?php echo $crs['urltype']==3?'selected':'';?>>_top</option>
                          <option value="4" <?php echo $crs['urltype']==4?'selected':'';?>>popup</option>
					  </select>
                      <?php // @end ?>
                    </td>
                </tr>
              </table>


<BR>
</td></tr>
</table>

</FORM>
<BR>

</td></tr>
</table> <!-- End WHITE SPACE -->


<?
}
?>


<BR>
</td></tr>
</table> <!-- End BLUE SPACE -->


<!-- Thin Line -->
<table border=0 width="100%" cellspacing=0 cellpadding=0>
<tr HEIGHT=1 BGCOLOR="#000000"><td></td></tr>
</table>
<!-- End Thin Line -->


<script language="JavaScript"> 
<!-- 

function ylib_Browser()
{
	d=document;
	this.agt=navigator.userAgent.toLowerCase();
	this.major = parseInt(navigator.appVersion);
	this.dom=(d.getElementById)?1:0;
	this.ns=(d.layers);
	this.ns4up=(this.ns && this.major >=4);
	this.ns6=(this.dom&&navigator.appName=="Netscape");
	this.op=(window.opera? 1:0);
	this.ie=(d.all);
	this.ie4=(d.all&&!this.dom)?1:0;
	this.ie4up=(this.ie && this.major >= 4);
	this.ie5=(d.all&&this.dom);
	this.win=((this.agt.indexOf("win")!=-1) || (this.agt.indexOf("16bit")!=-1));
	this.mac=(this.agt.indexOf("mac")!=-1);
};

var oBw = new ylib_Browser();

	function DisplayElement ( elt, displayValue ) {
		if ( typeof elt == "string" )
			elt = document.getElementById( elt );
		if ( elt == null ) return;

		if ( oBw && oBw.ns6 ) {
			// OTW table formatting will be lost:
			if ( displayValue == "block" && elt.tagName == "TR" )
				displayValue = "table-row";
			else if ( displayValue == "inline" && elt.tagName == "TR" )
				displayValue = "table-cell";
		}

		elt.style.display = displayValue;
	}

var obj1 = null;
function PickColor(obj){
	obj1 = obj;
	window.open('color/color.htm','color_window','width=450, height=550, noresize,location=no,menubar=no,toolbars=no');
}

function SelectFont(obj,sampletext){
	obj1 = obj;
	window.open('font/font.php?sample='+sampletext+'&style='+obj.value.replace("#","%23"),'font_window','width=550, height=250, location=no,menubar=no,toolbars=no');
}

//--> 
</script>

</body>
</html>
