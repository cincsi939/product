<?
class date_format{
	var $str_search = 'dmyǴ�Y';
	var $th_s_m = array('','�.�.','�.�.','��.�.','��.�.','�.�.','��.�.','�.�.','�.�.','�.�.','�.�.','�.�.','�.�.');
	var $th_s_mm = array('','��.','��.','�դ.','���.','��.','���.','��.','ʤ.','��.','��.','��.','��.');
	var $th_s_mmm = array('','��','��','�դ','���','��','���','��','ʤ','��','��','��','��');
	var $th_s_mmmm = array('','�.�','�.�','��.�','��.�','�.�','��.�','�.�','�.�','�.�','�.�','�.�','�.�');
	var $th_l_m = array('','���Ҥ�','����Ҿѹ��','�չҤ�','����¹','����Ҥ�','�Զع�¹','�á�Ҥ�','�ԧ�Ҥ�','�ѹ��¹','���Ҥ�','��Ȩԡ�¹','�ѹ�Ҥ�');
	var $th_s_d = array('��.','�.','�.','�.','��.','�.','�.');
	var $th_l_d = array('�ҷԵ��','�ѹ���','�ѧ���','�ط�','����ʺ��','�ء��','�����');
	var $th_num = array('�','�','�','�','�','�','�','�','�','�');
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
			case '�':
				$nm = intval(date('d',$d));
				return $this->thai_num($nm);
			break;
			case '��':
				$nm = date('d',$d);
				return $this->thai_num($nm);
			break;
			case '���':
				return $this->th_s_d[date('w',$d)];
			break;
			case '����':
				return $this->th_l_d[date('w',$d)];
			break;
			case '�':
				$nm = intval(date('m',$d));
				return $this->thai_num($nm);
			break;
			case '��':
				$nm = date('m',$d);
				return $this->thai_num($nm);
			break;
			case '���':
				return $this->th_s_m[intval(date('m',$d))];
			break;
			case '�����':
				return $this->th_s_mm[intval(date('m',$d))];
			break;
			case '������':
				return $this->th_s_mmm[intval(date('m',$d))];
			break;
			case '�������':
				return $this->th_s_mmmm[intval(date('m',$d))];
			break;
			case '����':
				return $this->th_l_m[intval(date('m',$d))];
			break;
			case '��':
				$nm = substr(date('Y',$d)+543,2,2);
				return $this->thai_num($nm);
			break;
			case '����':
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
		$f = str_replace('�ѹ','[!!!]',$f);
		$f = str_replace('��͹','[###]',$f);
		$this->my_date = $this->make_date($d);

		$format_array = $this->sstr($f);
		$n = count($format_array);
		$date_tmp = '';
		for($i=0;$i<$n;$i++){
			 $rep = $this->ret_date($format_array[$i],$this->my_date);
			$date_tmp .= $rep;
		}
		$date_tmp = str_replace('[!!!]','�ѹ',$date_tmp); 
		$date_tmp = str_replace('[###]','��͹',$date_tmp); 
		return $date_tmp;
	}

	function sample(){
		echo "<pre><font color=#009900><b>*********************************************************<br>";
		echo "** class-date-format Version 1.0 ******************************<br>";
		echo "*********************************************************
***** English********
*	d	�ѹ��� 1
*	dd	�ѹ��� 01
*	ddd	�ѹ Mon
*	dddd	�ѹ Monday
*	m	��͹ 1
*	mm	��͹ 01
*	mmm	��͹ Jan
*	mmmm	��͹ january
*	yy	�� 07
*	yyyy	�� 2007
****** ������ ******
*	�	�ѹ��� �
*	��	�ѹ��� ��
*	���	�ѹ �.
*	����	�ѹ �ѹ���
*	�	��͹ �
*	��	��͹ ��
*	���	��͹ �.�.
*	����	��͹ ���Ҥ�
*	��	�� ��
*	����	�� ����
**********************************************************
";
		echo "*************Simple****************************************</b></font><br>";
		echo '<font color=#FF0000>dd-mm-yyyy</font>'." = <font color=#0000FF>".$this->show_date('dd-mm-yyyy',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>d/m/yy</font>'." = <font color=#0000FF>".$this->show_date('d/m/yy',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>ddd d mmm yy</font>'." = <font color=#0000FF>".$this->show_date('ddd d mmm yy',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>dddd d mmmm yyyy</font>'." = <font color=#0000FF>".$this->show_date('dddd d mmmm yyyy',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>dddd, mmmm d, yyyy</font>'." = <font color=#0000FF>".$this->show_date('dddd, mmmm d, yyyy',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>�-��-����</font>'." = <font color=#0000FF>".$this->show_date('�-��-����',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>�/�/��</font>'." = <font color=#0000FF>".$this->show_date('�/�/��',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>��� � ��� ��</font>'." = <font color=#0000FF>".$this->show_date('��� � ��� ��',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>���� � ���� ����</font>'." = <font color=#0000FF>".$this->show_date('���� � ���� ����',date("Y-m-d"))."</font><br>";
		echo '<font color=#FF0000>�ѹ ���� ��� � ���� �.�. ����</font>'." = <font color=#0000FF>".$this->show_date('�ѹ ���� ��� � ���� �.�. ����',date("Y-m-d"))."</font><br>";
		echo "<b><font color=#009900>***********************************************************</font></b><br>";
	}
}

/*
$d = new date_format;
echo  $d->show_date("�ѹ��� �-��-���-����-�/��/���/����/��:����:d:dd:ddd-dddd-m-mm-mmm-mmmm-yy-yyyy",'2008-01-18 15:39:22');
*/
?>