<?

# FUNCTION ##############################################
/* ฟังก์ชั่นการตรวจสอบสิทธิ์การ เพิ่ม ลบ แก้ไข Modified By : Aussy [2552-10-10 15:12] */
$monthname = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

function cmdObj($app_id, $cmd_type, $url = "#", $target = "_self", $obj_text = "", $attrib = "", $alt = "") {
        if ($_SESSION['SS_PERMISSION'] && $app_id && $cmd_type  || true) {
                if ($cmd_type == "VIEW")
                        $ico = ""; elseif ($cmd_type == "ADD")
                        $ico = "b_add"; elseif ($cmd_type == "EDIT")
                        $ico = "b_edit"; elseif ($cmd_type == "DELETE")
                        $ico = "b_drop";

//			if ( $_SESSION['SS_PERMISSION'][$app_id][$cmd_type] == "Y" ) {
                echo "<a href=\"" . $url . "\" target=\"" . $target . "\">";
                #if ( $obj_text ) echo "<label alt=\"".$alt."\" ".$attrib." onMouseOver=\"this.style.cursor='hand';\">".$obj_text."</label>";
                if ($obj_text)
                        echo $obj_text;
                else
                        echo "<img src=\"../../../images/obj_icon/" . $ico . ".png\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\" alt=\"" . $alt . "\" " . $attrib . ">";
                echo "</a>";
//			} elseif ( $_SESSION['SS_PERMISSION'][$app_id][$cmd_type] == "N" ) {
//				#if ( $obj_text ) echo "<label alt=\"".$alt."\" ".$attrib." onMouseOver=\"this.style.cursor='hand';\">".$obj_text."</label>";
//				if ( $obj_text ) echo $obj_text;
//				else echo "<img src=\"../../images/obj_icon/".$ico."_disabled.png\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\" alt=\"".$alt."\">";
//			}
        }
}

################################################
# ฟังก์ชั่นกำหนดสิทธิ แบบ Tag คำสั่ง By:Jeng [2009-10-13 10:41]
# $app_id : รหัส application
# $cmd_type : ประเภทการเข้าถึง VIEW, ADD, EDIT, DELETE
# $tagYes : แท็กที่ต้องการแสดง เมื่อถูกเงื่อนไข
# $tagNo : แท็กที่ต้องการแสดง เมื่อไม่ถูกเงื่อนไข
################################################

function cmdObj_tag($app_id = "", $cmd_type = "", $tagYes = "", $tagNo = "") {
        if (!empty($app_id) && !empty($_SESSION['SS_PERMISSION'][$app_id][$cmd_type]) || true) {
                if ($_SESSION['SS_PERMISSION'][$app_id][$cmd_type] == "Y" || true) {
                        echo $tagYes;
                } else
                if ($_SESSION['SS_PERMISSION'][$app_id][$cmd_type] == "N") {
                        echo $tagNo;
                }
        } else {
                echo $tagNo;
        }
		
}

##############################################
# ฟัังก์ชั่งแสดงข้อมูล ๊ Usernamemanager VIEW
# $app_id : รหัส application
# $itstaffid : รหัสผู้ใช้งาน
#  ประเภทการเข้าถึง ALL, SELF, GROUP
##############################################

function getUserViewID($app_id = "") {
        $itstaffid = array();
        if (!empty($app_id) && !empty($_SESSION['SS_PERMISSION'][$app_id]['VIEW']) && $_SESSION['SS_PERMISSION'][$app_id]['VIEW'] == "Y") {
                if (!empty($app_id) && !empty($_SESSION['SS_PERMISSION'][$app_id]['SUB_VIEW'])) {
                        if ($_SESSION['SS_PERMISSION'][$app_id]['SUB_VIEW'] == "SELF") {
                                $itstaffid[] = $_SESSION["session_staffid"];
                        } else
                        if ($_SESSION['SS_PERMISSION'][$app_id]['SUB_VIEW'] == "GROUP") {
                                $sql = "SELECT epm_staffgroup.org_id FROM epm_staffgroup Inner Join epm_groupmember ON epm_staffgroup.gid = epm_groupmember.gid 
								WHERE epm_groupmember.staffid ='" . $_SESSION["session_staffid"] . "' ";
                                $RESULT = mysql_query($sql);
                                $rowG = mysql_fetch_assoc($RESULT);
                                $arrGID = implode("','", $rowG);
                                $sql_staffid = "SELECT epm_groupmember.staffid FROM epm_staffgroup Inner Join epm_groupmember ON epm_staffgroup.gid = epm_groupmember.gid 
								WHERE epm_staffgroup.org_id IN('" . $arrGID . "') ";
                                $RESULT_staffid = mysql_query($sql_staffid);
                                while ($rowS = mysql_fetch_assoc($RESULT_staffid)) {
                                        $itstaffid[] = $rowS["staffid"];
                                }
                        } else
                        if ($_SESSION['SS_PERMISSION'][$app_id]['SUB_VIEW'] == "ALL") {
                                $itstaffid[] = "";
                        } else {
                                $itstaffid[] = "NO_STAFFID";
                        }
                }
        } else {
                $itstaffid[] = "NO_APPID";
        }
        return $itstaffid;
}

function redirect_url($url) {
        echo "<script language=\"JavaScript\">\n";
        echo "window.location='" . $url . "';\n";
        echo "</script>\n";
}

function swap_date($date) {
        if ($date && $date != "0000-00-00") {
                list($d, $m, $y) = split("-", $date);
                return sprintf("%s-%s-%s", $y, $m, $d);
        }
}

/* ฟังก์ชั่นการคำนวณอายุ Modified By : Aussy [2552-10-10 15:12] */

function birthday($birthday) {
        if ($birthday) {
                list($year, $month, $day) = explode("-", $birthday);
                $year_diff = date("Y") - $year;
                $month_diff = date("m") - $month;
                $day_diff = date("d") - $day;
                if ($month_diff < 0)
                        $year_diff--;
                elseif (($month_diff == 0) && ($day_diff < 0))
                        $year_diff--;

                return $year_diff;
        }
}

function getPageNum($row, $row_per_page) {
        $page = ceil($row / $row_per_page);
        //$page += (is_int($page))?1:0;
        return ($page <= 0) ? 1 : $page;
}

function date_eng2thai2($date, $add = 0, $dismonth = "L"/* รูปแบบเดือน */, $disyear = "L") {
        global $monthname, $shortmonth;
        if ($date != "") {
                $date = substr($date, 0, 10);
                list($year, $month, $day) = split('[/.-]', $date);
                if ($dismonth == "S") {
                        $month = $shortmonth[$month * 1];
                } else {
                        $month = $monthname[$month * 1];
                }
                $xyear = 0;
                if ($disyear == "S") {
                        $xyear = substr(($year + $add), 2, 2);
                } else {
                        $xyear = ( $year + $add);
                }
                return ($day * 1) . " " . $month . " " . ($xyear);
        } else {
                return "";
        }
}

function getDMY($xDate, $xType = "D") {
        $arrThaiMonth = array('', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฏาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');

        if ($xDate && $xDate != "0000-00-00") {
                if ($xType == "D")
                        return substr($xDate, 8, 2);
                if ($xType == "M")
                        return $arrThaiMonth[intval(substr($xDate, 5, 2))];
                if ($xType == "Y")
                        return substr($xDate, 0, 4) + 543;
        }
}

function shwArray($strData) {
//		if ( is_array($strData) ) {
        echo "<pre>";
        print_r($strData);
        echo "</pre>";
//		} else {
//			echo $strData;
//		}
}

function CharLimit($strData, $intLimit = 0) {
        if ($strData) {
                $strResult = substr($strData, 0, $intLimit);
                if (strlen($strData) > $intLimit)
                        $strResult = $strResult . "...";
                return $strResult;
        }
}

function STRING_RANDOM($len) {
        $code = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        srand((double) microtime() * 1000000);
        for ($i = 0; $i < $len; $i++) {
                $strRandom .= $code[rand() % strlen($code)];
        }
        return $strRandom;
}

function EnCrypt($strNormal) {
        empty($strEncrypted);
        for ($intA = 0; $intA < strlen($strNormal); $intA++) {
                if (substr($strNormal, $intA, 1) == "A") {
                        $strEncrypted = $strEncrypted . "9";
                } elseif (substr($strNormal, $intA, 1) == "B") {
                        $strEncrypted = $strEncrypted . "8";
                } elseif (substr($strNormal, $intA, 1) == "C") {
                        $strEncrypted = $strEncrypted . "7";
                } elseif (substr($strNormal, $intA, 1) == "D") {
                        $strEncrypted = $strEncrypted . "6";
                } elseif (substr($strNormal, $intA, 1) == "E") {
                        $strEncrypted = $strEncrypted . "5";
                } elseif (substr($strNormal, $intA, 1) == "F") {
                        $strEncrypted = $strEncrypted . "4";
                } elseif (substr($strNormal, $intA, 1) == "G") {
                        $strEncrypted = $strEncrypted . "3";
                } elseif (substr($strNormal, $intA, 1) == "H") {
                        $strEncrypted = $strEncrypted . "2";
                } elseif (substr($strNormal, $intA, 1) == "I") {
                        $strEncrypted = $strEncrypted . "1";
                } elseif (substr($strNormal, $intA, 1) == "J") {
                        $strEncrypted = $strEncrypted . "0";
                } elseif (substr($strNormal, $intA, 1) == "K") {
                        $strEncrypted = $strEncrypted . "z";
                } elseif (substr($strNormal, $intA, 1) == "L") {
                        $strEncrypted = $strEncrypted . "y";
                } elseif (substr($strNormal, $intA, 1) == "M") {
                        $strEncrypted = $strEncrypted . "x";
                } elseif (substr($strNormal, $intA, 1) == "N") {
                        $strEncrypted = $strEncrypted . "w";
                } elseif (substr($strNormal, $intA, 1) == "O") {
                        $strEncrypted = $strEncrypted . "v";
                } elseif (substr($strNormal, $intA, 1) == "P") {
                        $strEncrypted = $strEncrypted . "u";
                } elseif (substr($strNormal, $intA, 1) == "Q") {
                        $strEncrypted = $strEncrypted . "t";
                } elseif (substr($strNormal, $intA, 1) == "R") {
                        $strEncrypted = $strEncrypted . "s";
                } elseif (substr($strNormal, $intA, 1) == "S") {
                        $strEncrypted = $strEncrypted . "r";
                } elseif (substr($strNormal, $intA, 1) == "T") {
                        $strEncrypted = $strEncrypted . "q";
                } elseif (substr($strNormal, $intA, 1) == "U") {
                        $strEncrypted = $strEncrypted . "p";
                } elseif (substr($strNormal, $intA, 1) == "V") {
                        $strEncrypted = $strEncrypted . "o";
                } elseif (substr($strNormal, $intA, 1) == "W") {
                        $strEncrypted = $strEncrypted . "n";
                } elseif (substr($strNormal, $intA, 1) == "X") {
                        $strEncrypted = $strEncrypted . "m";
                } elseif (substr($strNormal, $intA, 1) == "Y") {
                        $strEncrypted = $strEncrypted . "l";
                } elseif (substr($strNormal, $intA, 1) == "Z") {
                        $strEncrypted = $strEncrypted . "k";
                } elseif (substr($strNormal, $intA, 1) == "a") {
                        $strEncrypted = $strEncrypted . "j";
                } elseif (substr($strNormal, $intA, 1) == "b") {
                        $strEncrypted = $strEncrypted . "i";
                } elseif (substr($strNormal, $intA, 1) == "c") {
                        $strEncrypted = $strEncrypted . "h";
                } elseif (substr($strNormal, $intA, 1) == "d") {
                        $strEncrypted = $strEncrypted . "g";
                } elseif (substr($strNormal, $intA, 1) == "e") {
                        $strEncrypted = $strEncrypted . "f";
                } elseif (substr($strNormal, $intA, 1) == "f") {
                        $strEncrypted = $strEncrypted . "e";
                } elseif (substr($strNormal, $intA, 1) == "g") {
                        $strEncrypted = $strEncrypted . "d";
                } elseif (substr($strNormal, $intA, 1) == "h") {
                        $strEncrypted = $strEncrypted . "c";
                } elseif (substr($strNormal, $intA, 1) == "i") {
                        $strEncrypted = $strEncrypted . "b";
                } elseif (substr($strNormal, $intA, 1) == "j") {
                        $strEncrypted = $strEncrypted . "a";
                } elseif (substr($strNormal, $intA, 1) == "k") {
                        $strEncrypted = $strEncrypted . "Z";
                } elseif (substr($strNormal, $intA, 1) == "l") {
                        $strEncrypted = $strEncrypted . "Y";
                } elseif (substr($strNormal, $intA, 1) == "m") {
                        $strEncrypted = $strEncrypted . "X";
                } elseif (substr($strNormal, $intA, 1) == "n") {
                        $strEncrypted = $strEncrypted . "W";
                } elseif (substr($strNormal, $intA, 1) == "o") {
                        $strEncrypted = $strEncrypted . "V";
                } elseif (substr($strNormal, $intA, 1) == "p") {
                        $strEncrypted = $strEncrypted . "U";
                } elseif (substr($strNormal, $intA, 1) == "q") {
                        $strEncrypted = $strEncrypted . "T";
                } elseif (substr($strNormal, $intA, 1) == "r") {
                        $strEncrypted = $strEncrypted . "S";
                } elseif (substr($strNormal, $intA, 1) == "s") {
                        $strEncrypted = $strEncrypted . "R";
                } elseif (substr($strNormal, $intA, 1) == "t") {
                        $strEncrypted = $strEncrypted . "Q";
                } elseif (substr($strNormal, $intA, 1) == "u") {
                        $strEncrypted = $strEncrypted . "P";
                } elseif (substr($strNormal, $intA, 1) == "v") {
                        $strEncrypted = $strEncrypted . "O";
                } elseif (substr($strNormal, $intA, 1) == "w") {
                        $strEncrypted = $strEncrypted . "N";
                } elseif (substr($strNormal, $intA, 1) == "x") {
                        $strEncrypted = $strEncrypted . "M";
                } elseif (substr($strNormal, $intA, 1) == "y") {
                        $strEncrypted = $strEncrypted . "L";
                } elseif (substr($strNormal, $intA, 1) == "z") {
                        $strEncrypted = $strEncrypted . "K";
                } elseif (substr($strNormal, $intA, 1) == "0") {
                        $strEncrypted = $strEncrypted . "J";
                } elseif (substr($strNormal, $intA, 1) == "1") {
                        $strEncrypted = $strEncrypted . "I";
                } elseif (substr($strNormal, $intA, 1) == "2") {
                        $strEncrypted = $strEncrypted . "H";
                } elseif (substr($strNormal, $intA, 1) == "3") {
                        $strEncrypted = $strEncrypted . "G";
                } elseif (substr($strNormal, $intA, 1) == "4") {
                        $strEncrypted = $strEncrypted . "F";
                } elseif (substr($strNormal, $intA, 1) == "5") {
                        $strEncrypted = $strEncrypted . "E";
                } elseif (substr($strNormal, $intA, 1) == "6") {
                        $strEncrypted = $strEncrypted . "D";
                } elseif (substr($strNormal, $intA, 1) == "7") {
                        $strEncrypted = $strEncrypted . "C";
                } elseif (substr($strNormal, $intA, 1) == "8") {
                        $strEncrypted = $strEncrypted . "B";
                } elseif (substr($strNormal, $intA, 1) == "9") {
                        $strEncrypted = $strEncrypted . "A";
                } elseif (substr($strNormal, $intA, 1) == "~") {
                        $strEncrypted = $strEncrypted . " ";
                } elseif (substr($strNormal, $intA, 1) == "!") {
                        $strEncrypted = $strEncrypted . "/";
                } elseif (substr($strNormal, $intA, 1) == "@") {
                        $strEncrypted = $strEncrypted . "?";
                } elseif (substr($strNormal, $intA, 1) == "#") {
                        $strEncrypted = $strEncrypted . ".";
                } elseif (substr($strNormal, $intA, 1) == "$") {
                        $strEncrypted = $strEncrypted . ">";
                } elseif (substr($strNormal, $intA, 1) == "%") {
                        $strEncrypted = $strEncrypted . ",";
                } elseif (substr($strNormal, $intA, 1) == "^") {
                        $strEncrypted = $strEncrypted . "<";
                } elseif (substr($strNormal, $intA, 1) == "&") {
                        $strEncrypted = $strEncrypted . "'";
                } elseif (substr($strNormal, $intA, 1) == "*") {
                        $strEncrypted = $strEncrypted . "\"";
                } elseif (substr($strNormal, $intA, 1) == "(") {
                        $strEncrypted = $strEncrypted . ";";
                } elseif (substr($strNormal, $intA, 1) == ")") {
                        $strEncrypted = $strEncrypted . ":";
                } elseif (substr($strNormal, $intA, 1) == "_") {
                        $strEncrypted = $strEncrypted . "\\";
                } elseif (substr($strNormal, $intA, 1) == "-") {
                        $strEncrypted = $strEncrypted . "|";
                } elseif (substr($strNormal, $intA, 1) == "+") {
                        $strEncrypted = $strEncrypted . "]";
                } elseif (substr($strNormal, $intA, 1) == "=") {
                        $strEncrypted = $strEncrypted . "}";
                } elseif (substr($strNormal, $intA, 1) == "{") {
                        $strEncrypted = $strEncrypted . "[";
                } elseif (substr($strNormal, $intA, 1) == "[") {
                        $strEncrypted = $strEncrypted . "{";
                } elseif (substr($strNormal, $intA, 1) == "}") {
                        $strEncrypted = $strEncrypted . "=";
                } elseif (substr($strNormal, $intA, 1) == "]") {
                        $strEncrypted = $strEncrypted . "+";
                } elseif (substr($strNormal, $intA, 1) == "|") {
                        $strEncrypted = $strEncrypted . "-";
                } elseif (substr($strNormal, $intA, 1) == "\\") {
                        $strEncrypted = $strEncrypted . "_";
                } elseif (substr($strNormal, $intA, 1) == ":") {
                        $strEncrypted = $strEncrypted . ")";
                } elseif (substr($strNormal, $intA, 1) == ";") {
                        $strEncrypted = $strEncrypted . "(";
                } elseif (substr($strNormal, $intA, 1) == "\"") {
                        $strEncrypted = $strEncrypted . "*";
                } elseif (substr($strNormal, $intA, 1) == "'") {
                        $strEncrypted = $strEncrypted . "&";
                } elseif (substr($strNormal, $intA, 1) == "<") {
                        $strEncrypted = $strEncrypted . "^";
                } elseif (substr($strNormal, $intA, 1) == ",") {
                        $strEncrypted = $strEncrypted . "%";
                } elseif (substr($strNormal, $intA, 1) == ">") {
                        $strEncrypted = $strEncrypted . "$";
                } elseif (substr($strNormal, $intA, 1) == ".") {
                        $strEncrypted = $strEncrypted . "#";
                } elseif (substr($strNormal, $intA, 1) == "?") {
                        $strEncrypted = $strEncrypted . "@";
                } elseif (substr($strNormal, $intA, 1) == "/") {
                        $strEncrypted = $strEncrypted . "!";
                } elseif (substr($strNormal, $intA, 1) == " ") {
                        $strEncrypted = $strEncrypted . "~";
                }
        }
        $ENCODE_BIT = 64;  //64 bit
        $strRandVal = STRING_RANDOM($ENCODE_BIT);
        $strEncrypted = str_replace(substr($strRandVal, 4, strlen($strNormal)), $strEncrypted, $strRandVal);
        $strEncrypted = str_replace(substr($strEncrypted, $ENCODE_BIT - 3, 2), getNO(strlen($strNormal), 2, 0), $strEncrypted);
        return($strEncrypted);
}

function getNO($NO, $GetCharTotal, $Increasement) {
        $NO = ($NO * 1) + $Increasement;
        $NO = "000000000" . $NO;
        $NO = substr($NO, strlen($NO) - $GetCharTotal, $GetCharTotal);
        return($NO);
}

function getPersonalID($strPersonalID) {
        if ($strPersonalID && strlen($strPersonalID) == 13) {
                $PID = substr($strPersonalID, 0, 1);
                $PID .= "-" . substr($strPersonalID, 1, 4);
                $PID .= "-" . substr($strPersonalID, 5, 5);
                $PID .= "-" . substr($strPersonalID, 10, 2);
                $PID .= "-" . substr($strPersonalID, 12, 1);
                return $PID;
        } else {
                return $strPersonalID;
        }
}

function get_date($birthdate) {
        $date_edit = explode('-', $birthdate);
        $date_edit[0]+=543;
        $change_date = implode("-", array_reverse($date_edit));
        return $change_date;
}

function SmallThaiDate($vDate) {
        # Set $vDate Format to "d-m-Y" First...
        $Month = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        if ($vDate) {
                $arrDate = explode("-", $vDate);
                $arrDate[0] = ( $arrDate[0] == "00" ) ? "-" : intval($arrDate[0]);
                $arrDate[1] = ( $arrDate[1] == "00" ) ? "-" : $Month[intval($arrDate[1])];
                $strDate = $arrDate[0] . " " . $arrDate[1] . " " . ($arrDate[2] + 543);
                return $strDate;
        }
}

function date2THA($x) {
        $exdateexplode = explode("-", $x);
        if ($exdateexplode[0] <= 2300) {
                $exdateexplode[0] = $exdateexplode[0] + 543;
        }
        if ($exdateexplode[0] > 2900) {
                $exdateexplode[0] = $exdateexplode[0] - 543;
        }
        $x = $exdateexplode[0] . "-" . $exdateexplode[1] . "-" . $exdateexplode[2];
        return $x;
}

function date2ENG($x) {
        $exdateexplode = explode("-", $x);
        if ($exdateexplode[0] <= 1900) {
                $exdateexplode[0] = $exdateexplode[0] + 543;
        }
        if ($exdateexplode[0] > 2300) {
                $exdateexplode[0] = $exdateexplode[0] - 543;
        }
        $x = $exdateexplode[0] . "-" . $exdateexplode[1] . "-" . $exdateexplode[2];
        return $x;
}

/* จำแนกกลุ่มอายุ */

function ageGrp($intAge) {
		if ( $intAge <=18 ) $Grp = "A";
		elseif ( $intAge <= 59 ) $Grp =  "B";
		elseif ( $intAge > 59 ) $Grp = "C";
		return $Grp;
}

function GetCellProperty($id, $sec1, $cellno) {
        $result = mysql_query("select * from cellinfo where node_id='$id' and sec='$sec1' and cellno='$cellno';");
        if ($result) {
                $rs = mysql_fetch_array($result, MYSQL_ASSOC);
                $prop = "";
                if ($rs[alignment]) {
                        $prop .= " align='$rs[alignment]' ";
                }

                if ($rs[valign]) {
                        $prop .= " valign='$rs[valign]' ";
                }

                if ($rs[bgcolor]) {
                        $prop .= " bgcolor='$rs[bgcolor]' ";
                }

                if ($rs[width]) {
                        $prop .= " width='$rs[width]' ";
                }

                return $prop;
        } else {
                return "";
        }
}

function GetCellValue($id, $sec1, $cellno) {
        $result = mysql_query("select * from cellinfo where node_id='$id' and sec='$sec1' and cellno='$cellno';");
        if ($result) {
                $rs = mysql_fetch_array($result, MYSQL_ASSOC);
                $val1 = $rs[caption];

                if ($rs[celltype] == 1) {
                        $val1 .= " [obj] ";
                } else if ($rs[celltype] == 2) {
                        $val1 .= " [fld] ";
                } else if ($rs[celltype] == 3) {
                        $val1 .= " [fn] ";
                } else if ($rs[celltype] == 4) {
                        $val1 .= " [cal] ";
                }

                if ($rs[font]) {
                        $val1 = "<span style='$rs[font]'>$val1</span>";
                }

                if ($rs[url]) {
                        $val1 = "<a href='$rs[url]' target='_blank'>$val1</a>";
                }

                return $val1;
        } else {
                return "&nbsp;";
        }
}

function DB2Array($arrayname, $sql) {
        $s = "\$$arrayname  = array(";
        $result = mysql_query($sql);
        $i = 0;
        $firstrow = true;
        while ($rs = mysql_fetch_assoc($result)) {
                if ($firstrow) {
                        $firstrow = false;
                } else {
                        $s .= ",";
                }

                $firstcol = true;
                $s .= "$i => array(";
                foreach ($rs as $key => $value) {
                        if ($firstcol) {
                                $firstcol = false;
                        } else {
                                $s .= ", ";
                        }
                        $s .= "\"$key\"=>\"" . $value . "\"";
                }
                $s .= ")";

                $i++;
        }

        $s .= ");";

        return $s;
}

function canSetWidth() { // ตรวจสอบว่า ฐานข้อมูลรองรับการแก้ไข Column Width หรือไม่
        $result = @mysql_query("SELECT cwidth1,cwidth2,cwidth3,cwidth4 FROM eq_kpi_tree_member LIMIT 1");
        if ($result && mysql_errno() == 0) {
                return true; // can set width
        } else {
                return false; //cannot set width
        }
}

function GetColumnWidth($rid, $sec, $cellno) {
        $x = explode(".", $cellno);
        $col = $x[1];

        // H,E,I,F
        if ($sec == "H") {
                $sql = "select cwidth1 from eq_kpi_tree_member where node_id='$rid';";
        } else if ($sec == "E") {
                $sql = "select cwidth2 from eq_kpi_tree_member where node_id='$rid';";
        } else if ($sec == "I") {
                $sql = "select cwidth3 from eq_kpi_tree_member where node_id='$rid';";
        } else {
                $sql = "select cwidth4 from eq_kpi_tree_member where node_id='$rid';";
        }

        $cwidth = "";

        $result = @mysql_query($sql);
        if ($result) {
                $rs = mysql_fetch_array($result);
                $x = explode("|", $rs[0]); //แต่ละ column คั่นด้วย |
                $cwidth = $x[$col - 1]; // เอาเฉพาะตัวที่กำหนดจากค่าตัวหลังของ cellno
        }

        return htmlspecialchars($cwidth);
}

function SetColumnWidth($rid, $sec, $cellno, $cwidth) {
        global $uname;
        $x = explode(".", $cellno);
        $col = $x[1];

        $cwidth = str_replace("|", "", $cwidth);  //กำจัดเครื่องหมาย | (ถ้ามี)
        // H,E,I,F
        if ($sec == "H") {
                $sql = "select cwidth1 from eq_kpi_tree_member where node_id='$rid';";
        } else if ($sec == "E") {
                $sql = "select cwidth2 from eq_kpi_tree_member where node_id='$rid';";
        } else if ($sec == "I") {
                $sql = "select cwidth3 from eq_kpi_tree_member where node_id='$rid';";
        } else {
                $sql = "select cwidth4 from eq_kpi_tree_member where node_id='$rid';";
        }

        $result = @mysql_query($sql);
        if ($result) {
                $rs = mysql_fetch_array($result);
                $x = explode("|", $rs[0]); //แต่ละ column คั่นด้วย |
                //สำหรับอันที่ไม่เคยได้ทำถึงอันนี้
                for ($i = 0; $i < $col - 1; $i++) {
                        if (!isset($x[$i])) {
                                $x[$i] = "";
                        }
                }

                $x[$col - 1] = $cwidth;
                $columnwidth = implode("|", $x); //จับมารวมกัน
        } else { // ยังไม่มีการกำหนดค่า
                $columnwidth = "";
                for ($i = 0; $i < $col - 1; $i++) {
                        $columnwidth .= "|";
                }
                $columnwidth .= "$cwidth|";
        }


        // H,E,I,F
        if ($sec == "H") {
                $sql = "update eq_kpi_tree_member set cwidth1='$columnwidth' where node_id='$rid';";
        } else if ($sec == "E") {
                $sql = "update eq_kpi_tree_member set cwidth2='$columnwidth' where node_id='$rid';";
        } else if ($sec == "I") {
                $sql = "update eq_kpi_tree_member set cwidth3='$columnwidth' where node_id='$rid';";
        } else {
                $sql = "update eq_kpi_tree_member set cwidth4='$columnwidth' where node_id='$rid';";
        }

        @mysql_query($sql);
}

/* ฟังก์ชั่นคำนวณร้อยละ Modified By : Aussy [2552-10-02 19:04] */

function percentage($arrVal, $intDec = 2, $intPercent = 100) {
        if ($arrVal && is_array($arrVal)) {
                #shwArray($arrVal);

                $SumOfVal = array_sum($arrVal); #echo "Total of Value is : ".$SumOfVal."<br>";

                foreach ($arrVal as $Key => $Val) {
                        $arrVal[$Key] = number_format((($Val * $intPercent) / $SumOfVal), $intDec + 1); // จำนวนร้อยละ ทศนิยม +1
                        // ชุดตัวแปร Array ร้อยละ จำนวนหลักทศนิยม
                        if (substr($arrVal[$Key], -1, 1) < 5) { # A2
                                $arrA2Ori[$Key] = $arrVal[$Key];
                                $arrA2[$Key] = number_format($arrVal[$Key], $intDec);
                                $Ref = explode(".", $arrA2[$Key]);
                                $arrA2LastChar[$Key] = substr($arrA2Ori[$Key], -1, 1);
                        } else { # A1
                                $arrA1Ori[$Key] = $arrVal[$Key];
                                $arrA1[$Key] = number_format($arrVal[$Key], $intDec);
                                $Ref = explode(".", $arrA1[$Key]);
                                $arrA1LastChar[$Key] = substr($arrA1Ori[$Key], -1, 1);
                        }

                        $arrVInt[$Key] = $Ref[0]; // ชุดตัวแปรจำนวนเต็ม (ตัดทศนิยมทิ้ง)
                        $arrVDec[$Key] = $Ref[1]; // ชุดตัวแปรจำนวนทศนิยม
                }

                #shwArray($arrVal);

                $x0 = array_sum($arrVInt);   #echo "x0 = ".$x0."<br>";
                $x1 = $intPercent - $x0;    #echo "x1 = ".$x1."<br>";
                $x2 = ($x1 * pow(10, $intDec)); #echo "x2 = ".$x2."<br>";
                $x3 = array_sum($arrVDec);   #echo "x3 = ".$x3."<br>";
                $x4 = $x3 - $x2;       #echo "x4 = ".$x4."<br>";
                #shwArray($arrA1Ori);
                #shwArray($arrA2Ori);

                arsort($arrA1LastChar);
                arsort($arrA2LastChar);
                #shwArray($arrA1LastChar);
                #shwArray($arrA2LastChar);
                #shwArray($arrA1);
                #shwArray($arrA2);

                if ($x4 == 0) {
                        foreach ($arrA1 as $Key => $Val)
                                $arrResult[$Key] = $arrA1[$Key];
                        foreach ($arrA2 as $Key => $Val)
                                $arrResult[$Key] = $arrA2[$Key];
                } elseif ($x4 > 0) {
                        $intA = 1;
                        foreach ($arrA1LastChar as $Key => $Val) {
                                if ($intA <= (count($arrA1Ori) - $x4))
                                        $arrResult[$Key] = $arrA1[$Key];
                                else
                                        $arrResult[$Key] = substr($arrA1Ori[$Key], 0, strlen($arrA1Ori[$Key]) - 1);
                                $intA++;
                        }

                        foreach ($arrA2 as $Key => $Val)
                                $arrResult[$Key] = $arrA2[$Key];
                } elseif ($x4 < 0) {
                        $intA = 1;
                        foreach ($arrA2LastChar as $Key => $Val) {
                                if ($intA <= abs($x4))
                                        $arrResult[$Key] = $arrA2[$Key] + 1 / (pow(10, $intDec));
                                else
                                        $arrResult[$Key] = $arrA2[$Key];
                                $intA++;
                        }

                        foreach ($arrA1 as $Key => $Val)
                                $arrResult[$Key] = $arrA1[$Key];
                }

                #shwArray($arrResult);
                #echo "Total of Percent is : ".number_format(array_sum($arrResult), 2)."<br>";

                return $arrResult;
        }
}

/* ฟังก์ชั่นคำนวณร้อยละ Modified By : Aussy [2552-10-05 10:00] */

function percentage_2d($arrVal, $intDec = 2, $intPercent = 100) {
        if ($arrVal && is_array($arrVal)) {
#			echo "arrVal ______________ "; shwArray($arrVal);
                $SumOfVal = multimension_array_sum($arrVal); #echo "Total of Value is : ".$SumOfVal."<br>";

                $Key = 0;
                foreach ($arrVal as $i => $arrValX) { # แกน X
                        foreach ($arrValX as $j => $arrValY) { # แกน Y
#					$SumOfX[$j] += $arrValY;
#					$SumOfY[$i] += $arrValY;
                                $arrPer[$i][$j] = number_format((($arrValY * $intPercent) / $SumOfVal), $intDec + 1); // จำนวนร้อยละ ทศนิยม+1
#					$SumOfarrX[$j] += number_format((($arrValY * $intPercent) / $SumOfVal), $intDec + 1); // จำนวนร้อยละ ในแกน X ทศนิยม+1
#					$SumOfarrY[$i] += number_format((($arrValY * $intPercent) / $SumOfVal), $intDec + 1); // จำนวนร้อยละ ในแกน Y ทศนิยม+1
                                // ชุดตัวแปร Array ร้อยละ จำนวนหลักทศนิยม

                                if (substr($arrPer[$i][$j], -1, 1) < 5) { # A2
                                        $arrA2Ori[$Key] = $arrPer[$i][$j];
                                        $arrA2[$Key] = number_format($arrPer[$i][$j], $intDec);
                                        $Ref = explode(".", $arrA2[$Key]);
                                        $arrA2LastChar[$Key] = substr($arrA2Ori[$Key], -1, 1);
                                } else { # A1
                                        $arrA1Ori[$Key] = $arrPer[$i][$j];
                                        $arrA1[$Key] = number_format($arrPer[$i][$j], $intDec);
                                        $Ref = explode(".", $arrA1[$Key]);
                                        $arrA1LastChar[$Key] = substr($arrA1Ori[$Key], -1, 1);
                                }

                                $arrVInt[$Key] = $Ref[0]; // ชุดตัวแปรจำนวนเต็ม (ตัดทศนิยมทิ้ง)
                                $arrVDec[$Key] = $Ref[1]; // ชุดตัวแปรจำนวนทศนิยม

                                $arrKey[$Key] = $i . "#" . $j;
                                $Key++;
                        }
                }

#			shwArray($arrKey);
#			echo "SumOfX ______________ "; shwArray($SumOfX);
#			echo "SumOfY ______________ "; shwArray($SumOfY);
#			echo "arrPer ______________ "; shwArray($arrPer);
#			echo multimension_array_sum($arrPer);
                $SumOfArrPer = multimension_array_sum($arrPer); #echo "Total of Value is : ".$SumOfArrPer."<br>";

                $x0 = array_sum($arrVInt);   #echo "x0 = ".$x0."<br>";
                $x1 = $intPercent - $x0;    #echo "x1 = ".$x1."<br>";
                $x2 = ($x1 * pow(10, $intDec)); #echo "x2 = ".$x2."<br>";
                $x3 = array_sum($arrVDec);   #echo "x3 = ".$x3."<br>";
                $x4 = $x3 - $x2;       #echo "x4 = ".$x4."<br>";
#			echo "arrA1Ori ______________ "; shwArray($arrA1Ori);
#			echo "arrA2Ori ______________ "; shwArray($arrA2Ori);

                arsort($arrA1LastChar);
                arsort($arrA2LastChar);
#			shwArray($arrA1LastChar);
#			shwArray($arrA2LastChar);
#			shwArray($arrA1);
#			shwArray($arrA2);
#			echo "SumOfarrX ______________ "; shwArray($SumOfarrX);
#			echo "SumOfarrY ______________ "; shwArray($SumOfarrY);

                if ($x4 == 0) {
                        foreach ($arrA1 as $Key => $Val) {
                                $Index = explode("#", $arrKey[$Key]);
                                $arrResult[$Index[0]][$Index[1]] = $arrA1[$Key];
                        }

                        foreach ($arrA2 as $Key => $Val) {
                                $Index = explode("#", $arrKey[$Key]);
                                $arrResult[$Index[0]][$Index[1]] = $arrA2[$Key];
                        }
                } elseif ($x4 > 0) {
                        $intA = 1;
                        foreach ($arrA1LastChar as $Key => $Val) {
                                $Index = explode("#", $arrKey[$Key]);
                                if ($intA <= (count($arrA1Ori) - $x4))
                                        $arrResult[$Index[0]][$Index[1]] = $arrA1[$Key];
                                else
                                        $arrResult[$Index[0]][$Index[1]] = substr($arrA1Ori[$Key], 0, strlen($arrA1Ori[$Key]) - 1);
                                $intA++;
                        }

                        foreach ($arrA2 as $Key => $Val) {
                                $Index = explode("#", $arrKey[$Key]);
                                $arrResult[$Index[0]][$Index[1]] = $arrA2[$Key];
                        }
                } elseif ($x4 < 0) {
                        $intA = 1;
                        foreach ($arrA2LastChar as $Key => $Val) {
                                $Index = explode("#", $arrKey[$Key]);
                                if ($intA <= abs($x4))
                                        $arrResult[$Index[0]][$Index[1]] = $arrA2[$Key] + 1 / (pow(10, $intDec));
                                else
                                        $arrResult[$Index[0]][$Index[1]] = $arrA2[$Key];
                                $intA++;
                        }

                        foreach ($arrA1 as $Key => $Val) {
                                $Index = explode("#", $arrKey[$Key]);
                                $arrResult[$Index[0]][$Index[1]] = $arrA1[$Key];
                        }
                }

#			shwArray($arrResult);
#			echo "Total of Percent is : ".number_format(multimension_array_sum($arrResult), 2)."<br>";

                return $arrResult;
        }
}

/* ฟังก์ชั่นคำนวณหาผลรวมของ Array หลายมิติ Modified By : Aussy [2552-10-05 10:00] */

function multimension_array_sum($a) {
        if (!is_array($a))
                return $a;
        foreach ($a as $key => $value)
                $totale += multimension_array_sum($value);
        return $totale;
}

/* ฟังก์ชั่นสำหรับตัดช่องว่างทั้งหมดในประโยค Modified By : Aussy [2552-10-15 10:53] */

function trimall($str, $charlist = " \t\n\r\0\x0B") {
        return str_replace(str_split($charlist), '', $str);
}

function mobile_device_detect($iphone = true, $ipad = true, $android = true, $opera = true, $blackberry = true, $palm = true, $windows = true, $mobileredirect = false, $desktopredirect = false) {



        $mobile_browser = false; // set mobile browser as false till we can prove otherwise

        $user_agent = $_SERVER['HTTP_USER_AGENT']; // get the user agent value - this should be cleaned to ensure no nefarious input gets executed

        $accept = $_SERVER['HTTP_ACCEPT']; // get the content accept value - this should be cleaned to ensure no nefarious input gets executed



        switch (true) { // using a switch against the following statements which could return true is more efficient than the previous method of using if statements
                case (preg_match('/ipad/i', $user_agent)); // we find the word ipad in the user agent

                        $mobile_browser = $ipad; // mobile browser is either true or false depending on the setting of ipad when calling the function

                        $status = 'Apple iPad';

                        if (substr($ipad, 0, 4) == 'http') { // does the value of ipad resemble a url
                                $mobileredirect = $ipad; // set the mobile redirect url to the url value stored in the ipad value
                        } // ends the if for ipad being a url

                        break; // break out and skip the rest if we've had a match on the ipad // this goes before the iphone to catch it else it would return on the iphone instead



                case (preg_match('/ipod/i', $user_agent) || preg_match('/iphone/i', $user_agent)); // we find the words iphone or ipod in the user agent

                        $mobile_browser = $iphone; // mobile browser is either true or false depending on the setting of iphone when calling the function

                        $status = 'Apple';

                        if (substr($iphone, 0, 4) == 'http') { // does the value of iphone resemble a url
                                $mobileredirect = $iphone; // set the mobile redirect url to the url value stored in the iphone value
                        } // ends the if for iphone being a url

                        break; // break out and skip the rest if we've had a match on the iphone or ipod



                case (preg_match('/android/i', $user_agent));  // we find android in the user agent

                        $mobile_browser = $android; // mobile browser is either true or false depending on the setting of android when calling the function

                        $status = 'Android';

                        if (substr($android, 0, 4) == 'http') { // does the value of android resemble a url
                                $mobileredirect = $android; // set the mobile redirect url to the url value stored in the android value
                        } // ends the if for android being a url

                        break; // break out and skip the rest if we've had a match on android



                case (preg_match('/opera mini/i', $user_agent)); // we find opera mini in the user agent

                        $mobile_browser = $opera; // mobile browser is either true or false depending on the setting of opera when calling the function

                        $status = 'Opera';

                        if (substr($opera, 0, 4) == 'http') { // does the value of opera resemble a rul
                                $mobileredirect = $opera; // set the mobile redirect url to the url value stored in the opera value
                        } // ends the if for opera being a url 

                        break; // break out and skip the rest if we've had a match on opera



                case (preg_match('/blackberry/i', $user_agent)); // we find blackberry in the user agent

                        $mobile_browser = $blackberry; // mobile browser is either true or false depending on the setting of blackberry when calling the function

                        $status = 'Blackberry';

                        if (substr($blackberry, 0, 4) == 'http') { // does the value of blackberry resemble a rul
                                $mobileredirect = $blackberry; // set the mobile redirect url to the url value stored in the blackberry value
                        } // ends the if for blackberry being a url 

                        break; // break out and skip the rest if we've had a match on blackberry



                case (preg_match('/(pre\/|palm os|palm|hiptop|avantgo|plucker|xiino|blazer|elaine)/i', $user_agent)); // we find palm os in the user agent - the i at the end makes it case insensitive

                        $mobile_browser = $palm; // mobile browser is either true or false depending on the setting of palm when calling the function

                        $status = 'Palm';

                        if (substr($palm, 0, 4) == 'http') { // does the value of palm resemble a rul
                                $mobileredirect = $palm; // set the mobile redirect url to the url value stored in the palm value
                        } // ends the if for palm being a url 

                        break; // break out and skip the rest if we've had a match on palm os



                case (preg_match('/(iris|3g_t|windows ce|opera mobi|windows ce; smartphone;|windows ce; iemobile)/i', $user_agent)); // we find windows mobile in the user agent - the i at the end makes it case insensitive

                        $mobile_browser = $windows; // mobile browser is either true or false depending on the setting of windows when calling the function

                        $status = 'Windows Smartphone';

                        if (substr($windows, 0, 4) == 'http') { // does the value of windows resemble a rul
                                $mobileredirect = $windows; // set the mobile redirect url to the url value stored in the windows value
                        } // ends the if for windows being a url 

                        break; // break out and skip the rest if we've had a match on windows



                case (preg_match('/(mini 9.5|vx1000|lge |m800|e860|u940|ux840|compal|wireless| mobi|ahong|lg380|lgku|lgu900|lg210|lg47|lg920|lg840|lg370|sam-r|mg50|s55|g83|t66|vx400|mk99|d615|d763|el370|sl900|mp500|samu3|samu4|vx10|xda_|samu5|samu6|samu7|samu9|a615|b832|m881|s920|n210|s700|c-810|_h797|mob-x|sk16d|848b|mowser|s580|r800|471x|v120|rim8|c500foma:|160x|x160|480x|x640|t503|w839|i250|sprint|w398samr810|m5252|c7100|mt126|x225|s5330|s820|htil-g1|fly v71|s302|-x113|novarra|k610i|-three|8325rc|8352rc|sanyo|vx54|c888|nx250|n120|mtk |c5588|s710|t880|c5005|i;458x|p404i|s210|c5100|teleca|s940|c500|s590|foma|samsu|vx8|vx9|a1000|_mms|myx|a700|gu1100|bc831|e300|ems100|me701|me702m-three|sd588|s800|8325rc|ac831|mw200|brew |d88|htc\/|htc_touch|355x|m50|km100|d736|p-9521|telco|sl74|ktouch|m4u\/|me702|8325rc|kddi|phone|lg |sonyericsson|samsung|240x|x320|vx10|nokia|sony cmd|motorola|up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|psp|treo)/i', $user_agent)); // check if any of the values listed create a match on the user agent - these are some of the most common terms used in agents to identify them as being mobile devices - the i at the end makes it case insensitive

                        $mobile_browser = true; // set mobile browser to true

                        $status = 'Mobile matched on piped preg_match';

                        break; // break out and skip the rest if we've preg_match on the user agent returned true 



                case ((strpos($accept, 'text/vnd.wap.wml') > 0) || (strpos($accept, 'application/vnd.wap.xhtml+xml') > 0)); // is the device showing signs of support for text/vnd.wap.wml or application/vnd.wap.xhtml+xml

                        $mobile_browser = true; // set mobile browser to true

                        $status = 'Mobile matched on content accept header';

                        break; // break out and skip the rest if we've had a match on the content accept headers



                case (isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE'])); // is the device giving us a HTTP_X_WAP_PROFILE or HTTP_PROFILE header - only mobile devices would do this

                        $mobile_browser = true; // set mobile browser to true

                        $status = 'Mobile matched on profile headers being set';

                        break; // break out and skip the final step if we've had a return true on the mobile specfic headers



                case (in_array(strtolower(substr($user_agent, 0, 4)), array('1207' => '1207', '3gso' => '3gso', '4thp' => '4thp', '501i' => '501i', '502i' => '502i', '503i' => '503i', '504i' => '504i', '505i' => '505i', '506i' => '506i', '6310' => '6310', '6590' => '6590', '770s' => '770s', '802s' => '802s', 'a wa' => 'a wa', 'acer' => 'acer', 'acs-' => 'acs-', 'airn' => 'airn', 'alav' => 'alav', 'asus' => 'asus', 'attw' => 'attw', 'au-m' => 'au-m', 'aur ' => 'aur ', 'aus ' => 'aus ', 'abac' => 'abac', 'acoo' => 'acoo', 'aiko' => 'aiko', 'alco' => 'alco', 'alca' => 'alca', 'amoi' => 'amoi', 'anex' => 'anex', 'anny' => 'anny', 'anyw' => 'anyw', 'aptu' => 'aptu', 'arch' => 'arch', 'argo' => 'argo', 'bell' => 'bell', 'bird' => 'bird', 'bw-n' => 'bw-n', 'bw-u' => 'bw-u', 'beck' => 'beck', 'benq' => 'benq', 'bilb' => 'bilb', 'blac' => 'blac', 'c55/' => 'c55/', 'cdm-' => 'cdm-', 'chtm' => 'chtm', 'capi' => 'capi', 'cond' => 'cond', 'craw' => 'craw', 'dall' => 'dall', 'dbte' => 'dbte', 'dc-s' => 'dc-s', 'dica' => 'dica', 'ds-d' => 'ds-d', 'ds12' => 'ds12', 'dait' => 'dait', 'devi' => 'devi', 'dmob' => 'dmob', 'doco' => 'doco', 'dopo' => 'dopo', 'el49' => 'el49', 'erk0' => 'erk0', 'esl8' => 'esl8', 'ez40' => 'ez40', 'ez60' => 'ez60', 'ez70' => 'ez70', 'ezos' => 'ezos', 'ezze' => 'ezze', 'elai' => 'elai', 'emul' => 'emul', 'eric' => 'eric', 'ezwa' => 'ezwa', 'fake' => 'fake', 'fly-' => 'fly-', 'fly_' => 'fly_', 'g-mo' => 'g-mo', 'g1 u' => 'g1 u', 'g560' => 'g560', 'gf-5' => 'gf-5', 'grun' => 'grun', 'gene' => 'gene', 'go.w' => 'go.w', 'good' => 'good', 'grad' => 'grad', 'hcit' => 'hcit', 'hd-m' => 'hd-m', 'hd-p' => 'hd-p', 'hd-t' => 'hd-t', 'hei-' => 'hei-', 'hp i' => 'hp i', 'hpip' => 'hpip', 'hs-c' => 'hs-c', 'htc ' => 'htc ', 'htc-' => 'htc-', 'htca' => 'htca', 'htcg' => 'htcg', 'htcp' => 'htcp', 'htcs' => 'htcs', 'htct' => 'htct', 'htc_' => 'htc_', 'haie' => 'haie', 'hita' => 'hita', 'huaw' => 'huaw', 'hutc' => 'hutc', 'i-20' => 'i-20', 'i-go' => 'i-go', 'i-ma' => 'i-ma', 'i230' => 'i230', 'iac' => 'iac', 'iac-' => 'iac-', 'iac/' => 'iac/', 'ig01' => 'ig01', 'im1k' => 'im1k', 'inno' => 'inno', 'iris' => 'iris', 'jata' => 'jata', 'java' => 'java', 'kddi' => 'kddi', 'kgt' => 'kgt', 'kgt/' => 'kgt/', 'kpt ' => 'kpt ', 'kwc-' => 'kwc-', 'klon' => 'klon', 'lexi' => 'lexi', 'lg g' => 'lg g', 'lg-a' => 'lg-a', 'lg-b' => 'lg-b', 'lg-c' => 'lg-c', 'lg-d' => 'lg-d', 'lg-f' => 'lg-f', 'lg-g' => 'lg-g', 'lg-k' => 'lg-k', 'lg-l' => 'lg-l', 'lg-m' => 'lg-m', 'lg-o' => 'lg-o', 'lg-p' => 'lg-p', 'lg-s' => 'lg-s', 'lg-t' => 'lg-t', 'lg-u' => 'lg-u', 'lg-w' => 'lg-w', 'lg/k' => 'lg/k', 'lg/l' => 'lg/l', 'lg/u' => 'lg/u', 'lg50' => 'lg50', 'lg54' => 'lg54', 'lge-' => 'lge-', 'lge/' => 'lge/', 'lynx' => 'lynx', 'leno' => 'leno', 'm1-w' => 'm1-w', 'm3ga' => 'm3ga', 'm50/' => 'm50/', 'maui' => 'maui', 'mc01' => 'mc01', 'mc21' => 'mc21', 'mcca' => 'mcca', 'medi' => 'medi', 'meri' => 'meri', 'mio8' => 'mio8', 'mioa' => 'mioa', 'mo01' => 'mo01', 'mo02' => 'mo02', 'mode' => 'mode', 'modo' => 'modo', 'mot ' => 'mot ', 'mot-' => 'mot-', 'mt50' => 'mt50', 'mtp1' => 'mtp1', 'mtv ' => 'mtv ', 'mate' => 'mate', 'maxo' => 'maxo', 'merc' => 'merc', 'mits' => 'mits', 'mobi' => 'mobi', 'motv' => 'motv', 'mozz' => 'mozz', 'n100' => 'n100', 'n101' => 'n101', 'n102' => 'n102', 'n202' => 'n202', 'n203' => 'n203', 'n300' => 'n300', 'n302' => 'n302', 'n500' => 'n500', 'n502' => 'n502', 'n505' => 'n505', 'n700' => 'n700', 'n701' => 'n701', 'n710' => 'n710', 'nec-' => 'nec-', 'nem-' => 'nem-', 'newg' => 'newg', 'neon' => 'neon', 'netf' => 'netf', 'noki' => 'noki', 'nzph' => 'nzph', 'o2 x' => 'o2 x', 'o2-x' => 'o2-x', 'opwv' => 'opwv', 'owg1' => 'owg1', 'opti' => 'opti', 'oran' => 'oran', 'p800' => 'p800', 'pand' => 'pand', 'pg-1' => 'pg-1', 'pg-2' => 'pg-2', 'pg-3' => 'pg-3', 'pg-6' => 'pg-6', 'pg-8' => 'pg-8', 'pg-c' => 'pg-c', 'pg13' => 'pg13', 'phil' => 'phil', 'pn-2' => 'pn-2', 'pt-g' => 'pt-g', 'palm' => 'palm', 'pana' => 'pana', 'pire' => 'pire', 'pock' => 'pock', 'pose' => 'pose', 'psio' => 'psio', 'qa-a' => 'qa-a', 'qc-2' => 'qc-2', 'qc-3' => 'qc-3', 'qc-5' => 'qc-5', 'qc-7' => 'qc-7', 'qc07' => 'qc07', 'qc12' => 'qc12', 'qc21' => 'qc21', 'qc32' => 'qc32', 'qc60' => 'qc60', 'qci-' => 'qci-', 'qwap' => 'qwap', 'qtek' => 'qtek', 'r380' => 'r380', 'r600' => 'r600', 'raks' => 'raks', 'rim9' => 'rim9', 'rove' => 'rove', 's55/' => 's55/', 'sage' => 'sage', 'sams' => 'sams', 'sc01' => 'sc01', 'sch-' => 'sch-', 'scp-' => 'scp-', 'sdk/' => 'sdk/', 'se47' => 'se47', 'sec-' => 'sec-', 'sec0' => 'sec0', 'sec1' => 'sec1', 'semc' => 'semc', 'sgh-' => 'sgh-', 'shar' => 'shar', 'sie-' => 'sie-', 'sk-0' => 'sk-0', 'sl45' => 'sl45', 'slid' => 'slid', 'smb3' => 'smb3', 'smt5' => 'smt5', 'sp01' => 'sp01', 'sph-' => 'sph-', 'spv ' => 'spv ', 'spv-' => 'spv-', 'sy01' => 'sy01', 'samm' => 'samm', 'sany' => 'sany', 'sava' => 'sava', 'scoo' => 'scoo', 'send' => 'send', 'siem' => 'siem', 'smar' => 'smar', 'smit' => 'smit', 'soft' => 'soft', 'sony' => 'sony', 't-mo' => 't-mo', 't218' => 't218', 't250' => 't250', 't600' => 't600', 't610' => 't610', 't618' => 't618', 'tcl-' => 'tcl-', 'tdg-' => 'tdg-', 'telm' => 'telm', 'tim-' => 'tim-', 'ts70' => 'ts70', 'tsm-' => 'tsm-', 'tsm3' => 'tsm3', 'tsm5' => 'tsm5', 'tx-9' => 'tx-9', 'tagt' => 'tagt', 'talk' => 'talk', 'teli' => 'teli', 'topl' => 'topl', 'hiba' => 'hiba', 'up.b' => 'up.b', 'upg1' => 'upg1', 'utst' => 'utst', 'v400' => 'v400', 'v750' => 'v750', 'veri' => 'veri', 'vk-v' => 'vk-v', 'vk40' => 'vk40', 'vk50' => 'vk50', 'vk52' => 'vk52', 'vk53' => 'vk53', 'vm40' => 'vm40', 'vx98' => 'vx98', 'virg' => 'virg', 'vite' => 'vite', 'voda' => 'voda', 'vulc' => 'vulc', 'w3c ' => 'w3c ', 'w3c-' => 'w3c-', 'wapj' => 'wapj', 'wapp' => 'wapp', 'wapu' => 'wapu', 'wapm' => 'wapm', 'wig ' => 'wig ', 'wapi' => 'wapi', 'wapr' => 'wapr', 'wapv' => 'wapv', 'wapy' => 'wapy', 'wapa' => 'wapa', 'waps' => 'waps', 'wapt' => 'wapt', 'winc' => 'winc', 'winw' => 'winw', 'wonu' => 'wonu', 'x700' => 'x700', 'xda2' => 'xda2', 'xdag' => 'xdag', 'yas-' => 'yas-', 'your' => 'your', 'zte-' => 'zte-', 'zeto' => 'zeto', 'acs-' => 'acs-', 'alav' => 'alav', 'alca' => 'alca', 'amoi' => 'amoi', 'aste' => 'aste', 'audi' => 'audi', 'avan' => 'avan', 'benq' => 'benq', 'bird' => 'bird', 'blac' => 'blac', 'blaz' => 'blaz', 'brew' => 'brew', 'brvw' => 'brvw', 'bumb' => 'bumb', 'ccwa' => 'ccwa', 'cell' => 'cell', 'cldc' => 'cldc', 'cmd-' => 'cmd-', 'dang' => 'dang', 'doco' => 'doco', 'eml2' => 'eml2', 'eric' => 'eric', 'fetc' => 'fetc', 'hipt' => 'hipt', 'http' => 'http', 'ibro' => 'ibro', 'idea' => 'idea', 'ikom' => 'ikom', 'inno' => 'inno', 'ipaq' => 'ipaq', 'jbro' => 'jbro', 'jemu' => 'jemu', 'java' => 'java', 'jigs' => 'jigs', 'kddi' => 'kddi', 'keji' => 'keji', 'kyoc' => 'kyoc', 'kyok' => 'kyok', 'leno' => 'leno', 'lg-c' => 'lg-c', 'lg-d' => 'lg-d', 'lg-g' => 'lg-g', 'lge-' => 'lge-', 'libw' => 'libw', 'm-cr' => 'm-cr', 'maui' => 'maui', 'maxo' => 'maxo', 'midp' => 'midp', 'mits' => 'mits', 'mmef' => 'mmef', 'mobi' => 'mobi', 'mot-' => 'mot-', 'moto' => 'moto', 'mwbp' => 'mwbp', 'mywa' => 'mywa', 'nec-' => 'nec-', 'newt' => 'newt', 'nok6' => 'nok6', 'noki' => 'noki', 'o2im' => 'o2im', 'opwv' => 'opwv', 'palm' => 'palm', 'pana' => 'pana', 'pant' => 'pant', 'pdxg' => 'pdxg', 'phil' => 'phil', 'play' => 'play', 'pluc' => 'pluc', 'port' => 'port', 'prox' => 'prox', 'qtek' => 'qtek', 'qwap' => 'qwap', 'rozo' => 'rozo', 'sage' => 'sage', 'sama' => 'sama', 'sams' => 'sams', 'sany' => 'sany', 'sch-' => 'sch-', 'sec-' => 'sec-', 'send' => 'send', 'seri' => 'seri', 'sgh-' => 'sgh-', 'shar' => 'shar', 'sie-' => 'sie-', 'siem' => 'siem', 'smal' => 'smal', 'smar' => 'smar', 'sony' => 'sony', 'sph-' => 'sph-', 'symb' => 'symb', 't-mo' => 't-mo', 'teli' => 'teli', 'tim-' => 'tim-', 'tosh' => 'tosh', 'treo' => 'treo', 'tsm-' => 'tsm-', 'upg1' => 'upg1', 'upsi' => 'upsi', 'vk-v' => 'vk-v', 'voda' => 'voda', 'vx52' => 'vx52', 'vx53' => 'vx53', 'vx60' => 'vx60', 'vx61' => 'vx61', 'vx70' => 'vx70', 'vx80' => 'vx80', 'vx81' => 'vx81', 'vx83' => 'vx83', 'vx85' => 'vx85', 'wap-' => 'wap-', 'wapa' => 'wapa', 'wapi' => 'wapi', 'wapp' => 'wapp', 'wapr' => 'wapr', 'webc' => 'webc', 'whit' => 'whit', 'winw' => 'winw', 'wmlb' => 'wmlb', 'xda-' => 'xda-',))); // check against a list of trimmed user agents to see if we find a match

                        $mobile_browser = true; // set mobile browser to true

                        $status = 'Mobile matched on in_array';

                        break; // break even though it's the last statement in the switch so there's nothing to break away from but it seems better to include it than exclude it



                default;

                        $mobile_browser = false; // set mobile browser to false

                        $status = 'Desktop / full capability browser';

                        break; // break even though it's the last statement in the switch so there's nothing to break away from but it seems better to include it than exclude it
        } // ends the switch 
        // tell adaptation services (transcoders and proxies) to not alter the content based on user agent as it's already being managed by this script, some of them suck though and will disregard this....
        // header('Cache-Control: no-transform'); // http://mobiforge.com/developing/story/setting-http-headers-advise-transcoding-proxies
        // header('Vary: User-Agent, Accept'); // http://mobiforge.com/developing/story/setting-http-headers-advise-transcoding-proxies
        // if redirect (either the value of the mobile or desktop redirect depending on the value of $mobile_browser) is true redirect else we return the status of $mobile_browser

        if ($redirect = ($mobile_browser == true) ? $mobileredirect : $desktopredirect) {

                header('Location: ' . $redirect); // redirect to the right url for this device

                exit;
        } else {

                // a couple of folkas have asked about the status - that's there to help you debug and understand what the script is doing

                if ($mobile_browser == '') {

                        return $mobile_browser; // will return either true or false 
                } else {

                        return array($mobile_browser, $status); // is a mobile so we are returning an array ['0'] is true ['1'] is the $status value
                }
        }
}

function set_style_graph() {
        $mobile = mobile_device_detect();
        if ($mobile == "") {
                $Setstyle = "";
        } else {
                $Setstyle = "JPG";
        }

        return $Setstyle;
}

function getSiteType($org_id) {
        $dbname = 'saiyairak_master';
        $sql = " SELECT * FROM `main_menu` WHERE `NID`='" . $org_id . "' ";
        $query = mysql_db_query($dbname, $sql);
        $row = mysql_fetch_assoc($query);
        $type = substr($row['SITEID'], 0, 1);
        if ($type == 'C') {
                $siteType = "กองประสานสายใยรักแห่งครอบครัว";
        } else if ($type == 'A') {
                $siteType = "ศูนย์ ๓ วัย สานสายใยรักแห่งครอบครัว";
        }
        return $siteType;
}

function GETIPADDRESS($fakeip = false) {
        $ip = (!empty($_SERVER['HTTP_CLIENT_IP'])) ? (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_CLIENT_IP'] : preg_replace('/(?:,.*)/', '', $_SERVER['HTTP_X_FORWARDED_FOR'])  : $_SERVER['REMOTE_ADDR'];
        $ip = (!$fakeip) ? $ip : $fakeip;

// local check class b and c
        $patterns = array("/(192).(168).(\d+).(\d+)/i", "/(10).(\d+).(\d+).(\d+)/i");
        foreach ($patterns as $pattern) {
                if (preg_match($pattern, $ip)) {
                        return $_SERVER["REMOTE_ADDR"];
                }
        }
// local check class a
        $parts = explode(".", $ip);
        if ($parts[0] == 172 && ($parts[1] > 15 || $parts[1] < 32)) {
                return $_SERVER["REMOTE_ADDR"];
        }

        if ($_SERVER['HTTP_X_FORWARDED_FOR'] != "") {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return trim($ip);
}

## เก็บข้อมูลใน log update

function add_logact($subject, $idcard, $action, $menu_id = "", $listerr = "") {
        // $subject="ชื่อ module";
        // $menu_id="ชื่อ application";
        // $listerr="0|form|0|0|บัญทึกข้อมูลนับตัว";
        global $server_id, $dbcmss_site;
        $xaction = trim($action);
        if (!(strrpos($xaction, "edit") === false)) {
                $xaction = 'edit';
        } elseif (!(strrpos($xaction, "delete") === false)) {
                $xaction = 'delete';
        }if (!(strrpos($xaction, "insert") === false)) {
                $xaction = 'insert';
        } else {
                $xaction = $xaction;
        }
        $uname = $_SESSION[session_username];
        $staff_key = $_SESSION[session_staffid];
        $ip = GETIPADDRESS();

        $sql = "insert into log_update(server_id,logtime,username,subject,target_id,user_ip,action,staff_login) values('$server_id',now(),'$uname','$subject','$idcard','$ip','$xaction','$staff_key');";

        mysql_query($sql) or die(mysql_error());
}


## แสดงวุฒิการศึกษา
function GetEduLevel(){
	$arredu = array();
	$sql = "SELECT * FROM eq_member_education ";
	$result = mysql_query($sql) or die(mysql_error());
	while($rs = mysql_fetch_assoc($result)){
		$arredu[$rs[educ_id]] = $rs[education];
	}
	return $arredu;
}

## function update เลขสมาชิก
function UpdateMemberID($pin){
$daten = date("Y-m-d");
 $sql = "update eq_member set member_no= concat(
substring_index(member_no,'-',1),'-',

if(floor((TIMESTAMPDIFF(MONTH,birthdate,'".$daten."')/12)) between '0' and '18','A',
if(
floor((TIMESTAMPDIFF(MONTH,birthdate,'".$daten."' )/12)) between '19' and '59','B','C'
)) 
,substring(substring_index(member_no,'-',-1) FROM 2))  
where pin IN($pin)
";

#echo $sql."<hr>";
mysql_query($sql);
}
## function update เลขสมาชิก
function UpdateMemberIDBefore($pin){
$sql = "SELECT pin,member_no,birthdate FROM eq_member where pin IN($pin)";
	$result = mysql_query($sql) or die(mysql_error());
	while($rs = mysql_fetch_assoc($result)){
		$arrMember_no = explode("-", $rs['member_no']);
		$member = $arrMember_no[0] . "-" . substr_replace($arrMember_no[1],ageGrp(birthday($rs['birthdate'])),0, 1);
		$sql = "update eq_member set member_no='".$member."' where pin IN(".$rs['pin'].")";
		
		#echo $sql."<hr>";
		mysql_query($sql);
	}
 
}

# END FUNCTION ###########################################
?>
