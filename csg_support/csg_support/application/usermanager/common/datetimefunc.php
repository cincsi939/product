<?
//Translating Serial Date Number to Y-M-D
function ExcelSerialDateToDMY($nSerialDate)
{
    // Excel/Lotus 123 have a bug with 29-02-1900. 1900 is not a
    // leap year, but Excel/Lotus 123 think it is...
    if ($nSerialDate == 60)
    {
        $nDay    = 29;
        $nMonth    = 2;
        $nYear    = 1900;

        return;
    }
    else if ($nSerialDate < 60)
    {
        // Because of the 29-02-1900 bug, any serial date 
        // under 60 is one off... Compensate.
        $nSerialDate++;
    }

    // Modified Julian to DMY calculation with an addition of 2415019
		(int)$l = $nSerialDate + 68569 + 2415019;
		(int)$n = (int)(( 4 * $l ) / 146097);
        $l = $l - (int)(( 146097 * $n + 3 ) / 4);
		(int)$i = (int)(( 4000 * ( $l + 1 ) ) / 1461001);
        $l = $l - (int)(( 1461 * $i ) / 4) + 31;
		(int)$j = (int)(( 80 * $l ) / 2447);
		$nDay = $l - (int)(( 2447 * $j ) / 80);
        $l = (int)($j / 11);
        $nMonth = $j + 2 - ( 12 * $l );
		$nYear = 100 * ( $n - 49 ) + $i + $l;

	return $nYear."-".$nMonth."-".$nDay;
}

//Translating Serial Date Number to Y-M-D V2
function fmtexcel($days) {
  // Excel/Lotus 123 have a bug with 29-02-1900. 1900 is not a
  // leap year, but Excel/Lotus 123 think it is...
  if ($days <1) return "";
  if ($days == 60)  {
    return "2/29/1900";
  } else { 
    if ($days < 60)  {
      // Because of the 29-02-1900 bug, any serial date 
      // under 60 is one off... Compensate.
      $days++;
    }
    // Modified Julian to DMY calculation with an addition of 2415019
    $l = $days + 68569 + 2415019;
    $n = floor(( 4 * $l ) / 146097);
            $l = $l - floor(( 146097 * $n + 3 ) / 4);
    $i = floor(( 4000 * ( $l + 1 ) ) / 1461001);
    $l = $l - floor(( 1461 * $i ) / 4) + 31;
    $j = floor(( 80 * $l ) / 2447);
    $nDay = $l - floor(( 2447 * $j ) / 80);
    $l = floor($j / 11);
    $nMonth = $j + 2 - ( 12 * $l );
    $nYear = 100 * ( $n - 49 ) + $i + $l;
    return "$nYear-$nMonth-$nDay";
  }
}

//DMY to Excel Serial Date
/*------ not work
#function DMYToExcelSerialDate($nDay, $nMonth, $nYear)
#{
#   // Excel/Lotus 123 have a bug with 29-02-1900. 1900 is not a
#    // leap year, but Excel/Lotus 123 think it is...
#  if ($nDay == 29 && $nMonth == 02 && $nYear==1900)
#       return 60;
#
#    // DMY to Modified Julian calculatie with an extra substraction of 2415019.
#    $nSerialDate = (int)(( 1461 * ( $nYear + 4800 + (int)(( $nMonth - 14 ) / 12) ) ) / 4) + (int)(( 367 * ( $nMonth - 2 - 12 * ( ( $nMonth - 14 ) / 12 ) ) ) / 12) -  (int)(( 3 * ( (int)(( $nYear + 4900 + (int)(( $nMonth - 14 ) / 12) ) / 100) ) ) / 4) + $nDay - 2415019 - 32075;
#
#    if ($nSerialDate < 60)
#    {
#        // Because of the 29-02-1900 bug, any serial date 
#       // under 60 is one off... Compensate.
#        $nSerialDate--;
#    }
#
#   return (int)$nSerialDate;
#}
*/

//DMY to Excel Serial Date new version
function DMYToExcelSerialDate($Day,$Month,$Year){
	if( $Year >= 1900 && $Year <= 2099 )
	{
		if( $Month > 2 )
			$SerNum=floor(365.25*$Year)+floor(30.6001*($Month+1))+$Day-694037;
		else
			$SerNum=floor(365.25*($Year-1))+floor(30.6001*($Month+13))+$Day-694037;
	}
	return $SerNum;
}

/*
echo "39182=";
echo ExcelSerialDateToDMY(39182);
echo "<br>";
echo "10/04/2007=";
echo DMYToExcelSerialDate(10,04,2007);
*/

function DBThaiDate($d){
global $monthname;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	
	$d1=explode("-",$d);
	return $d1[2] . "/" . $d1[1] . "/" . (intval($d1[0]) + 543);
}

function ThaiDateTime($d){
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	if ($d == "0000-00-00 00:00:00") return "";
	
	$xd=explode(" ",$d);

	$d1=explode("-",$xd[0]);
	return $d1[2] . "/" . $d1[1] . "/" . (intval($d1[0]) + 543)  . " " . $xd[1];
}


function DBThaiLongDate($d){
global $monthname;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	
	$d1=explode("-",$d);
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " " . (intval($d1[0]) + 543);
}


function ThaiDate2DBDate($d){
	if (!$d) return "";
	if ($d == "00-00-0000") return "";
	
	$d1=explode("/",$d);
	return (intval($d1[2]) - 543) . "-" . $d1[1] . "-" . $d1[0];
}

?>