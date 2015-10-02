<?php
/**
* @comment script �ӹǳ��ҴѪ�յ鹷ع���Ե�ٹ�� � ����ҹ������ѡ��觤�ͺ�ú����
* @projectCode PS56DSDPW04
* @tor  -
* @package core
* @author Kidsana Panya
* @access private
* @created 15/05/2014
*/

class calculate_kpi {

    public $number_action, $yy, $mm, $tree_id, $pin, $eq_type;
    public $allvalue = array();
    public $allvalue_full = array();
    public $dbname = "question_project";
    public $arrData;
    public $arrVar;
    public $arrV;
    private $arrpop = array();

    /* Constructor Get Variable Arguments */

    function calculate_kpi($number_action, $yy, $mm, $tree_id, $pin, $eq_type) {
        $this->number_action = $number_action;
        $this->tree_id = $tree_id;
        $this->pin = $pin;
        $this->yy = $yy;
        $this->mm = $mm;
        $this->eq_type = $eq_type;
    }

    /* �ѧ���蹤ӹǳ��ṹ ���������������� Table : "eq_kpi_score" */

    function calculate_tree() {
        $args = func_get_args();
        list( $number_action, $tree_id, $pin, $yy, $mm, $eq_type ) = $args;
        if ($number_action)
            $this->number_action = $number_action;
        if ($tree_id)
            $this->tree_id = $tree_id;
        if ($pin)
            $this->pin = $pin;
        if ($yy)
            $this->yy = $yy;
        if ($mm)
            $this->mm = $mm;
        if ($eq_type)
            $this->eq_type = $eq_type;

        $time_startAll = $this->getmicrotime();
        $time_start_arrData = $this->getmicrotime();
        $this->arrData = $this->getvar($this->pin); // �֧��ͤӶ�����ͺ
        $time_end_arrData = $this->getmicrotime();
        $this->arrVar = $this->kpivar(); // �֧��� ID ����� �ҡ KPI
		
		
		
        $this->writetime2db($time_start_arrData, $time_end_arrData, "getvar");
        $this->gettree(0); // ���¡�� Method "gettree();" �֧�����ŵ���ç���ҧ
        ksort($this->allvalue);
        $sql_del_queue = "DELETE FROM `eq_kpi_score_queue` WHERE pin ='' OR pin IS NULL ";
        $query_del_queue = mysql_query($sql_del_queue);

        foreach ($this->allvalue as $key => $val) {
            $fvalue = $this->allvalue_full[$key];
            $sql_mb = "SELECT `addr_mooid`,`addr_tambon`,`addr_amphur`,`addr_province`  FROM `eq_member` WHERE pin ='" . $this->pin . "' ";
            $query_mb = mysql_query($sql_mb);
            $row_mb = mysql_fetch_assoc($query_mb);
            $sql_partid = "SELECT partid FROM `ccaa` WHERE ccDigi='" . $row_mb['addr_province'] . "'  ";
            $query_partid = mysql_query($sql_partid);
            $row_partid = mysql_fetch_assoc($query_partid);
            $sql = "SELECT count(pin) AS countKpi FROM eq_kpi_score WHERE `number_action`='" . $this->number_action . "' AND `tree_id`='" . $this->tree_id . "' AND `yy`='" . $this->yy . "' AND `mm`='" . $this->mm . "' AND `pin`='" . $this->pin . "' AND `tree_node_id`='" . $key . "' AND `eq_type`='" . $this->eq_type . "'  ";
            $query = mysql_query($sql);
            $countKpi = mysql_fetch_assoc($query);
            $strSQL = " REPLACE INTO `eq_kpi_score` (`number_action`, `tree_id`, `yy`, `mm`, `pin`, `tree_node_id`, `score`, `full_score`, `eq_type`)
									VALUES ('" . $this->number_action . "', '" . $this->tree_id . "', '" . $this->yy . "', '" . $this->mm . "', '" . $this->pin . "', '" . $key . "', '" . $val . "', '" . $fvalue . "', '" . $this->eq_type . "')";
            mysql_query($strSQL);
            $this->writetime2db($time_start, $time_end, "INSERT kpi_score");
        }
        //Begin Update eq_kpi_score_queue
        $time_start = $this->getmicrotime();
        $sqlMaxMM = " SELECT MAX(eq_kpi_score.mm) AS mm FROM  eq_kpi_score 
												WHERE eq_kpi_score.tree_id='" . $this->tree_id . "'
												AND eq_kpi_score.number_action='" . $this->number_action . "'
            									AND eq_kpi_score.yy='" . $this->yy . "'
            									AND eq_kpi_score.pin='" . $this->pin . "'
            									AND eq_kpi_score.eq_type='" . $this->eq_type . "'
												 ";
        $queryMaxMM = mysql_query($sqlMaxMM);
        $RowMaxMM = mysql_fetch_assoc($queryMaxMM);
        $sql_M = "SELECT count(pin) AS countKpi FROM eq_kpi_score_queue 
										WHERE `tree_id`='" . $this->tree_id . "' 
										AND `number_action`='" . $this->number_action . "'
										AND `yy`='" . $this->yy . "' 
										AND `mm`='" . $RowMaxMM['mm'] . "' 
										AND `pin`='" . $this->pin . "'  
										AND `eq_type`='" . $this->eq_type . "' 
										";
        $query_M = mysql_query($sql_M);
        $countKpi_M = mysql_fetch_assoc($query_M);
        $strSQL_queue = " REPLACE INTO `eq_kpi_score_queue` (`number_action`,`tree_id`,`yy`,`mm`,`pin`,`addr_mooid`,`addr_tambon`,`addr_amphur`,`addr_province`,`partid`,`eq_type`,`time_stamp`)
									VALUES ('" . $this->number_action . "', '" . $this->tree_id . "', '" . $this->yy . "', '" . $RowMaxMM['mm'] . "', '" . $this->pin . "', '" . $row_mb['addr_mooid'] . "', '" . $row_mb['addr_tambon'] . "', '" . $row_mb['addr_amphur'] . "', '" . $row_mb['addr_province'] . "', '" . $row_partid['partid'] . "', '" . $this->eq_type . "',NOW())";
        /* if($this->yy == "2554"&& $this->pin=="3500100216838"){
          echo $strSQL_queue ;
          exit();
          } */
        mysql_query($strSQL_queue);
        $time_end = $this->getmicrotime();
        $this->writetime2db($time_start, $time_end, "INSERT eq_kpi_score_queue");
        //End Update eq_kpi_score_queue
        //Begin Delete Data In Table eq_var_data_temp
        //$sql_var_data_del = " DELETE  FROM `eq_var_data_temp` WHERE `form_id`='".$this->tree_id."' AND `yy`='".$this->yy."' AND `mm`='".$this->mm."' AND `pin`='".$this->pin."'  AND `siteid`='".$this->eq_type."' ";
        //mysql_query($sql_var_data_del);
        //End Delete Data In Table eq_var_data_temp
        $time_endAll = $this->getmicrotime();
        $this->writetime2db($time_startAll, $time_endAll, "function_calculate_tree");
		
		
		#Begin �红����� view_eq_data_survey
		$sql_veq_var = '';
		$countNum = count($this->arrVar);
		$intVar = 0;
		foreach($this->arrVar as $k=>$v){
			$intVar++;
			$sql_veq = "SELECT COUNT(pin) AS num  FROM view_eq_data_survey 
									WHERE  pin='".$this->pin."' AND number_action='".$this->number_action."' AND yy='".$this->yy."' ";
			$query_veq = mysql_query($sql_veq);
			$row_veq = mysql_fetch_assoc($query_veq);						
			if($row_veq['num'] == 0){
				$sql_veq = " INSERT INTO view_eq_data_survey SET pin='".$this->pin."', number_action='".$this->number_action."', yy='".$this->yy."' ";
				$query_veq = mysql_query($sql_veq);
			}
			$var_data = str_replace('[', '',$k);
			$var_data = str_replace(']', '',$var_data);
			$sql_veq_var .= " `".$var_data."`='".$v."'";
			$sql_veq_var .= ($intVar!=$countNum)?',':'';
		}
		$sql_veq = " UPDATE  view_eq_data_survey  
									SET {$sql_veq_var}
									WHERE  pin='".$this->pin."' AND number_action='".$this->number_action."' AND yy='".$this->yy."' ";
		//echo $sql_veq."<br/>";							
		$query_veq = mysql_query($sql_veq);
		
		$sql_veq_s98 = "SELECT score  FROM eq_kpi_score_current 
									WHERE  pin='".$this->pin."' AND number_action='".$this->number_action."' AND yy='".$this->yy."' AND tree_node_id='98' ";
		$query_veq_s98 = mysql_query($sql_veq_s98);
		$row_veq_s98 = mysql_fetch_assoc($query_veq_s98);
		$sql_veq_s99 = "SELECT score  FROM eq_kpi_score_current 
									WHERE  pin='".$this->pin."' AND number_action='".$this->number_action."' AND yy='".$this->yy."' AND tree_node_id='99' ";
		$query_veq_s99 = mysql_query($sql_veq_s99);
		$row_veq_s99 = mysql_fetch_assoc($query_veq_s99);		
		$sql_veq_s102 = "SELECT score  FROM eq_kpi_score_current 
									WHERE  pin='".$this->pin."' AND number_action='".$this->number_action."' AND yy='".$this->yy."' AND tree_node_id='102' ";
		$query_veq_s102 = mysql_query($sql_veq_s102);
		$row_veq_s102 = mysql_fetch_assoc($query_veq_s102);			
		$sql_veq = " UPDATE  view_eq_data_survey  SET tree_node_98='".$row_veq_s98['score']."', 
								tree_node_99='".$row_veq_s99['score']."', tree_node_102='".$row_veq_s102['score']."', 
								tree_node_all='".($row_veq_s98['score']+$row_veq_s99['score']+$row_veq_s102['score'])."',
								siteid='".$this->eq_type."'
								WHERE  pin='".$this->pin."' AND number_action='".$this->number_action."' AND yy='".$this->yy."' ";
		//echo $sql_veq."<br/>";							
		$query_veq = mysql_query($sql_veq);
		
		#End �红����� view_eq_data_survey
    }

    /* �ѧ���蹴֧��Ң�ͤӶ�� */

    function gettree($nid) {
        $tid = $this->tree_id;
        #�Դ��Ҥ�ṹ��������ͧ�Ѻ���� (node_id=110)
        $sql_city_area = "SELECT city_area FROM `main_menu` WHERE SITEID ='" . $this->eq_type . "' ";
        $query_city_area = mysql_query($sql_city_area);
        $row_city_area = mysql_fetch_assoc($query_city_area);

        $strSQL = "SELECT t1.node_id, t1.parent_id, t1.node_name, t2.kpi_id
							FROM eq_kpi_tree t1 LEFT JOIN eq_kpi_tree_member t2 ON t1.node_id=t2.node_id
							WHERE t1.tree_id='" . $tid . "' AND parent_id='" . $nid . "' ORDER BY t1.node_id ";
        $rs = mysql_query($strSQL);

        while ($ar = mysql_fetch_assoc($rs)) {
            if ($ar['parent_id'] > 0)
                array_push($this->arrpop, $ar['parent_id']); // �֧��Ң�ͤӶ��������� Array � $this->arrpop
            if ($ar['kpi_id']) {
                list( $score, $full_score ) = $this->xformula($ar['kpi_id'], $tid, ""); // ���¡�� Method "xformula();" ������ ��Ҥ�ṹ����� ��� ��ṹ��� ����Т�� 
                #�Դ��Ҥ�ṹ��������ͧ�Ѻ���� (node_id=110)
                if ($row_city_area['city_area'] == 1 && $ar['node_id'] == 110) {
                    $score = $full_score;
                    $this->allvalue[$ar['node_id']] = $score;
                } else {
                    $this->allvalue[$ar['node_id']] = $score;
                }
                $this->allvalue_full[$ar['node_id']] = $full_score;
                //echo $ar['node_id']."[".$row_city_area['city_area']."]=>".$this->allvalue[$ar['node_id']].", ".$full_score."<br/>";
                if ($nid > 0) {
                    foreach ($this->arrpop as $key => $val) {
                        $this->allvalue[$val] += $score;
                        $this->allvalue_full[$val] += $full_score;
                    }
                }
            } else {
                $score = 0;
            }

            $this->gettree($ar[node_id]);
        }
        array_pop($this->arrpop);
    }

    /* �ѧ���蹡������ٵ� ���� Return ��Ҥ�ṹ����� ��� ��Ҥ�ṹ��� ; ��ҷ���ͧ��ä�� "���ʢ�ͤӶ��", "����Ẻ�ͺ���" ��� "������Ҫԡ" */

    function xformula($kpiid, $tree_id, $mid) {
        if (!$mid)
            $mid = $this->pin;
        $strSQL = "SELECT formula, full_score FROM eq_formula WHERE kpi_id='" . $kpiid . "' AND tree_id='" . $tree_id . "'  ";
        //$time_start = $this->getmicrotime();
        $rs = mysql_query($strSQL);
        //$time_end = $this->getmicrotime();
        //$this->writetime2db($time_start, $time_end, "function_xformula");
        $ar = mysql_fetch_assoc($rs);
        if ($ar['formula'])
            $formula = $ar['formula'];
        else
            $formula = 0; // �֧��Ҥ�ṹ�����
        if ($ar['full_score'])
            $full_score = $ar['full_score'];
        else
            $full_score = 0; // �֧��Ҥ�ṹ���
        $allvar = $this->arrVar; // ���¡�� Method "kpivar();" ���� List ����Ҩҡ����õ�ҧ �
        foreach ($allvar as $key => $val) {
            if (($val * 1) == 0)
                $val = 0;
            $formula = str_replace($key, $val, $formula);
        }
        @eval("\$value = $formula;");
        
        // check N/A
        if (strtoupper($value) == 'N/A') {
            $value = $full_score = 0;
        }
        
        // check no formula
        if (empty($formula)) {
            $value = $full_score = 0;
        }
        if ($value > $full_score)
            $value = $full_score; // �óշ��ӹǳ��ṹ�ҡ�ٵ��������Ҥ�ṹ����Թ�Ѻ��Ҥ�ṹ�������˹���� ������Ҥ�ṹ���
        $retarr = array($value, $full_score);
//        if($kpiid == 8){
//            echo '<pre>';
//            echo $formula. '<br>';
//            echo $kpiid.'<br>';
//            echo $tree_id;
//            echo '</pre>';
//            echo $value.' '.$full_score;
//            exit;
//        }
        return $retarr;
    }

    /* �ѧ���蹴֧��� ID ����� �ҡ KPI */

    function kpivar() {
        $strSQL = "SELECT t2.vid, t3.vname, eq_formula.tree_id FROM eq_kpi AS t1 Inner Join eq_kpi_var AS t2 ON (t1.kpi_id = t2.kpi_id)
								Inner Join eq_var_info AS t3 ON (t2.vid = t3.vid)
								Inner Join eq_formula ON eq_formula.kpi_id = t1.kpi_id
								WHERE eq_formula.tree_id='" . $this->tree_id . "' ";
        $vararr = array();
        //$time_start = $this->getmicrotime();
        $rs = mysql_query($strSQL);
        //$time_end = $this->getmicrotime();
        //$this->writetime2db($time_start, $time_end ,"function_kpivar");
        while ($ar = mysql_fetch_assoc($rs)) {
            $vararr['[var' . $ar['vid'] . "]"] = $this->arrData[$ar['vid']]; // ���¡�� Method "getvar();" ���͹Ӥ�� "eq_var_data_temp" ��� ID �����
        }
        return $vararr;
    }

    /* �ѧ���蹴֧��ҵ���� �ҡ "eq_var_data_temp" */

    function getvar($mid) {
        if (!$mid)
            $mid = $this->pin;
        $arrData = array();
        $table_eq_var_data = "eq_var_data"; //eq_var_data_temp
        $strSQL = "SELECT vid,value FROM $table_eq_var_data WHERE number_action='" . $this->number_action . "' AND pin='" . $mid . "' AND yy='" . $this->yy . "' AND mm='" . $this->mm . "' AND form_id='" . $this->tree_id . "' AND siteid='" . $this->eq_type . "' ";

        //$time_start = $this->getmicrotime();
        $rs = mysql_query($strSQL);
        //$time_end = $this->getmicrotime();
        //$this->writetime2db($time_start, $time_end ,"function_getvar");
        while ($row = mysql_fetch_assoc($rs)) {
            $arrData[$row['vid']] = $row['value'];
        }

        if (is_array($arrData)) {
            return $arrData;
        } else {
            return 0;
        }
    }

    function getmicrotime() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }

    function writetime2db($timestart, $timeend, $AppName) {

        $serverip = $_SERVER['SERVER_NAME'];
        $ipaddress = $_SERVER["REMOTE_ADDR"];
        $file_name = basename($_SERVER['PHP_SELF']);
        $filefullpath = __FILE__;
        $timequery = $timeend - $timestart;
        $sessionid = session_id();
        $siteid1 = $_SESSION['SS_SITEID'];

        $sql = " INSERT INTO sys_timequery SET username = '" . $_SESSION['session_staffid'] . "' ,ipaddress = '$ipaddress' ,siteid='$siteid1',appname = '$AppName', filename = '$file_name', timequery = '$timequery', serverip = '$serverip'  ";
        mysql_db_query($this->dbname, $sql);

        $sql1 = " REPLACE INTO sys_useronline  SET sessionid = '$sessionid', username = '" . $_SESSION['session_staffid'] . "', siteid='$siteid1', ipaddress = '$ipaddress', appname = '$AppName', filename = '$file_name', serverip = '$serverip' ";
        mysql_db_query($this->dbname, $sql1);
    }

}

?>