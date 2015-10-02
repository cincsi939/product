<?
class date_format{
	var $str_search = 'dmyÇ´»Y';
	var $th_s_m = array('','Á.¤.','¡.¾.','ÁÕ.¤.','àÁ.Â.','¾.¤.','ÁÔ.Â.','¡.¤.','Ê.¤.','¡.Â.','µ.¤.','¾.Â.','¸.¤.');
	var $th_s_mm = array('','Á¤.','¡¾.','ÁÕ¤.','àÁÂ.','¾¤.','ÁÔÂ.','¡¤.','Ê¤.','¡Â.','µ¤.','¾Â.','¸¤.');
	var $th_s_mmm = array('','Á¤','¡¾','ÁÕ¤','àÁÂ','¾¤','ÁÔÂ','¡¤','Ê¤','¡Â','µ¤','¾Â','¸¤');
	var $th_s_mmmm = array('','Á.¤','¡.¾','ÁÕ.¤','àÁ.Â','¾.¤','ÁÔ.Â','¡.¤','Ê.¤','¡.Â','µ.¤','¾.Â','¸.¤');
	var $th_l_m = array('','Á¡ÃÒ¤Á','¡ØÁÀÒ¾Ñ¹¸ì','ÁÕ¹Ò¤Á','àÁÉÒÂ¹','¾ÄÉÀÒ¤Á','ÁÔ¶Ø¹ÒÂ¹','¡Ã¡¯Ò¤Á','ÊÔ§ËÒ¤Á','¡Ñ¹ÂÒÂ¹','µØÅÒ¤Á','¾ÄÈ¨Ô¡ÒÂ¹','¸Ñ¹ÇÒ¤Á');
	var $th_s_d = array('ÍÒ.','¨.','Í.','¾.','¾Ä.','È.','Ê.');
	var $th_l_d = array('ÍÒ·ÔµÂì','¨Ñ¹·Ãì','ÍÑ§¤ÒÃ','¾Ø·¸','¾ÄËÑÊº´Õ','ÈØ¡Ãì','àÊÒÃì');
	var $th_num = array('ð','ñ','ò','ó','ô','õ','ö','÷','ø','ù');
	var $my_date = '';
	var $format_array = array();

	function sstr($f){
		$l = strlen($f);
		$setc = array();
		$oc = '';
		$ci = 0;
		for($i=0;$i<$l;$i++){
			$c = substr($f,$i,1);
			if(stristr($this->str_search,$c)){		
				if(($oc == $c) OR ($i==0)){
					$oc = $c;
					$setc[$ci] .= $c;
				}else{
					$ci++;
					$setc[$ci] .= $c;
					$oc = $c;
				}
			}else{
				if($i==0){
					$ci = -1;
				}
				$ci++;
				$setc[$ci] .= $c;
				$oc = '';
			}
		}
		return $setc;
	}

	function make_date($d){
		$sep = explode(" ",$d); 
		$day = $sep[0];
		$time = $sep[1];
		$date_ar = explode("-",$day); 
		$year = $date_ar[0];
		$month = $date_ar[1];
		$date = $date_ar[2];
		/*
		$timesep = explode(":",$time); 
		$hour = $timesep[0];
		$min = $timesep[1];
		$sec = $timesep[2];
		*/
		return mktime(0,0,0,intval($month),intval($date),intval($year));
	}

	function thai_num($nm){
		$l = strlen($nm);
		for($i=0;$i<$l;$i++){
			$r = intval(substr($nm,$i,1));
			$th .= $this->th_num[$r];
		}
		return $th;
	}

	function ret_date($f,$d){
		switch ($f){
			case 'd':
				return intval(date('d',$d));
			break;
			case 'dd':
				return date('d',$d);
			break;
			case 'ddd':
				return date('D',$d);
			break;
			case 'dddd':
				return date('l',$d);
			break;
			case 'm':
				return intval(date('m',$d));
			break;
			case 'mm':
				return date('m',$d);
			break;
			case 'mmm':
				return date('M',$d);
			break;
			case 'mmmm':
				return date('F',$d);
			break;
			case 'yy':
				return date('y',$d);
			break;
			case 'yyyy':
				return date('Y',$d);
			break;
			case 'Ç':
				$nm = intval(date('d',$d));
				return $this->thai_num($nm);
			break;
			case 'ÇÇ':
				$nm = date('d',$d);
				return $this->thai_num($nm);
			break;
			case 'ÇÇÇ':
				return $this->th_s_d[date('w',$d)];
			break;
			case 'ÇÇÇÇ':
				return $this->th_l_d[date('w',$d)];
			break;
			case '´':
				$nm = intval(date('m',$d));
				return $this->thai_num($nm);
			break;
			case '´´':
				$nm = date('m',$d);
				return $this->thai_num($nm);
			break;
			case '´´´':
				return $this->th_s_m[intval(date('m',$d))];
			break;
			case '´´´´´':
				return $this->th_s_mm[intval(date('m',$d))];
			break;
			case '´´´´´´':
				return $this->th_s_mmm[intval(date('m',$d))];
			break;
			case '´´´´´´´':
				return $this->th_s_mmmm[intval(date('m',$d))];
			break;
			case '´´´´':
				return $this->th_l_m[intval(date('m',$d))];
			break;
			case '»»':
				$nm = substr(date('Y',$d)+543,2,2);
				return $this->thai_num($nm);
			break;
			case '»»»»':
				$nm = date('Y',$d)+543;
				return $this->thai_num($nm);
			break;
			case 'YY':
				$nm = substr(date('Y',$d)+543,2,2);
				return $nm;
			break;
			case 'YYYY':
				$nm = date('Y',$d)+543;
				return $nm;
			break;
			default:
				return $f;
			break;
		}
	}

	function show_date(){
		if(func_num_args ()==1){
			$d = date('Y-m-d');
		}else{
			$d = func_get_arg(1);
		}
		$f = func_get_arg(0);
		$f = str_replace('ÇÑ¹','[!!!]',$f);
		$f = str_replace('à´×Í¹','[###]',$f);
		$this->my_date = $this->make_date($d);

		$format_array = $this->sstr($f);
		$n = count($format_array);
		$date_tmp = '';
		for($i=0;$i<$n;$i++){
			 $rep = $this->ret_date($format_array[$i],$this->my_date);
			$date_tmp .= $rep;
		}
		$date_tmp = str_replace('[!!!]','ÇÑ¹',$date_tmp); 
		$date_tmp = str_replace('[###]','à´×Í¹',$date_tmp); 
		return $date_tmp;
	}

	function sample(){
		echo "<pre><font color=#009900><b>*********************************************************<br>";
		echo "** class-date-format Version 1.0 ******************************<br>";
		echo "*********************************************************
***** English********
*	d	ÇÑ¹·Õè 1
*	dd	ÇÑ¹·Õè 01
*	ddd	ÇÑ¹ Mon
*	dddd	ÇÑ¹ Monday
*	m	à´×Í¹ 1
*	mm	à´×Í¹ 01
*	mmm	à´×Í¹ Jan
*	mmmm	à´×Í¹ january
*	yy	»Õ 07
*	yyyy	»Õ 2007
****** ÀÒÉÒä·Â ******
*	Ç	ÇÑ¹·Õè ñ
*	ÇÇ	ÇÑ¹·Õè ðñ
*	ÇÇÇ	ÇÑ¹ ¨.
*	ÇÇÇÇ	ÇÑ¹ ¨Ñ¹·Ãì
*	´	à´×Í¹ ñ
*	´´	à´×Í¹ ðñ
*	´´´	à´×Í¹ Á.¤.
*	´´´´	à´×Í¹ Á¡ÃÒ¤Á
*	»»	»Õ õñ
*	»»»»	»Õ òõõñ
**********************************************************
";
		echo "*************Simple****************************************</b></font><br>";
		echo '<font color=#FF0000>dd-mm-yyyy</font>'." = <font color=#0000FF>".$this->show_date('dd-mm-yyyy',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>d/m/yy</font>'." = <font color=#0000FF>".$this->show_date('d/m/yy',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>ddd d mmm yy</font>'." = <font color=#0000FF>".$this->show_date('ddd d mmm yy',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>dddd d mmmm yyyy</font>'." = <font color=#0000FF>".$this->show_date('dddd d mmmm yyyy',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>dddd, mmmm d, yyyy</font>'." = <font color=#0000FF>".$this->show_date('dddd, mmmm d, yyyy',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>Ç-´´-»»»»</font>'." = <font color=#0000FF>".$this->show_date('Ç-´´-»»»»',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>Ç/´/»»</font>'." = <font color=#0000FF>".$this->show_date('Ç/´/»»',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>ÇÇÇ Ç ´´´ »»</font>'." = <font color=#0000FF>".$this->show_date('ÇÇÇ Ç ´´´ »»',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>ÇÇÇÇ Ç ´´´´ »»»»</font>'." = <font color=#0000FF>".$this->show_date('ÇÇÇÇ Ç ´´´´ »»»»',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>ÇÑ¹ ÇÇÇÇ ·Õè Ç ´´´´ ¾.È. »»»»</font>'." = <font color=#0000FF>".$this->show_date('ÇÑ¹ ÇÇÇÇ ·Õè Ç ´´´´ ¾.È. »»»»',date("Y-m-d"))."</font><br>";
		echo "<b><font color=#009900>***********************************************************</font></b><br>";
	}
}

/*
$d = new date_format;
echo  $d->show_date("ÇÑ¹·Õè Ç-ÇÇ-ÇÇÇ-ÇÇÇÇ-´/´´/´´´/´´´´/»»:»»»»:d:dd:ddd-dddd-m-mm-mmm-mmmm-yy-yyyy",'2008-01-18 15:39:22');
*/
?>