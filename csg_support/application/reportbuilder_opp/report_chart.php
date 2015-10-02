<?php

/**
* @comment ไฟล์สำหรับสร้าง cockpit
* @projectCode 56CMSS09
* @package plugin
* @author ref. by "Report Builder"
* @access public
* @created 01/04/2014
*/

//$sql_chart = "select * from reportinfo  where rid='$id' and uname='$uname';";
//$result_chart = mysql_query($sql_chart);
//$rs_chart=mysql_fetch_array($result_chart,MYSQL_ASSOC);
//$chartheader =$rs_chart['chart1'];
$chartheader = $rs['chart1'];
// @modify Phada Woodtikarn 25/07/2014 เจาะ iframe
$countchart = count($chartinfo);
$iframe = false;
if(strpos($chartheader,'http://')!==false){
	$iframe = true;
	$chartheader = ReplaceParam($chartheader);
}else if(strpos($chartheader,'url::')!==false){
	$iframe = true;
	$chartheader = str_replace('url::','',$chartheader);
	$chartheader = ReplaceParam($chartheader);
}else{
	if($countchart == 1){
		echo $chartheader;
	}
}
if(isset($_GET['iGraph']) && $_GET['iGraph'] == 'off'){
	$iGraph = false;
}else{
	$iGraph = true;
}
if($iframe == true && $iGraph == true){
	if(isset($rs['bsize'])){
		$iframeSize = explode('x',$rs['bsize']);
	}else{
		$iframeSize[0] = 600;
		$iframeSize[1] = 250;
	}
	echo '<iframe id="rpb_iframe" width="'.$iframeSize[0].'" height="'.$iframeSize[1].'" src="'.$chartheader.'" align="middle" frameborder="0"></iframe>';
	
}else if($iGraph == true){
// @end
?>
	<script src="js/jquery-1.10.1.min.js"></script>
    <script src="js/HighCharts/highcharts.min.js"></script>
    <script src="js/HighCharts/highcharts-more.js"></script>
    <!--<div class="container" style="border:1px solid #d8d8d8;"></div>-->
    <div class="container" ></div>
    <?php 
	if($countchart > 1){
	?>
    <script> 
        $(function () {
            $arrCell=[]; 
            $i = 0;
            <?php
            global $chartinfo;
            for($r = 0; $r < count($chartinfo); $r++){
                $xx = explode(".", $chartinfo[$r]['valuex']);
                $x1 = $xx[0] - 1;
                $x2 = $xx[1] - 1;
                $yy = explode(".", $chartinfo[$r]['valuey']);
                $y1 = $yy[0] - 1;
                $y2 = $yy[1] - 1;
         	?>
                    //console.log(<?= $x1 ?>+":"+<?= $x2 ?>+" | "+<?= $y1 ?>+":"+<?= $y2 ?>);
                    //console.log(document.getElementById('corner-exsummary').rows[<?= $x1 ?>].cells[<?= $x2 ?>].innerText);
                    $arrCell[$i] = new Array();
                    $arrCell[$i][0] = document.getElementById('corner-exsummary').rows[<?= $x1 ?>].cells[<?= $x2 ?>].innerText;
                    $arrCell[$i][1] = parseInt(document.getElementById('corner-exsummary').rows[<?= $y1 ?>].cells[<?= $y2 ?>].innerText);
                    $i++;
            <?php 
			} 
			?>
                if($i>1){
                    
                    $('.container').highcharts({
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            width: 600,
                            height: 250
                        },
                        title: {
                            text: '<?= $chartheader ?>',
                            style: {
                                        fontWeight: 'bold',
                                        fontSize: '14px'
                                    }
                        },
                        tooltip: {
                            pointFormat: '<b>{point.y}</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    color: '#000000',
                                    connectorColor: '#000000',
                                    formatter: function() {
                                        return  '<b>' + this.point.y.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</b>';
                                    },
                                    style: {
                                        fontWeight: 'bold',
                                        fontSize: '12px'
                                    }
                                },
                                showInLegend: true
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle',
                           // x: -10,
                           // y: 100,
                            borderWidth: 0
                        },
                        series: [{
                                type: 'pie',
                                name: '',
                                data: $arrCell
                            }]
                    });
                    
                    }
                });
    </script>
    <? }else{?>
    <?php
    // ////////////////////////////////////////////
    // call database for readflie ================
    // ////////////////////////////////////////////
        // @modify bannasorn 02/04/2014  edit database connection to use file center config
        $sql = "SELECT * FROM competency_system.success_salary_cockpit";
        //@end
        $all_files = mysql_query($sql);
        
        if (!$all_files) {
            echo "Could not successfully run query ($sql) from DB: " . mysql_error();
            exit;
        }
        
        if (mysql_num_rows($all_files) == 0) {
            echo "No rows found, nothing to print so am exiting";
            exit;
        }
        
        $data_cockpit = mysql_fetch_assoc($all_files);		
        $url_warning = '';
    
        if (isset($data_cockpit['warning'])) {
            if ($data_cockpit['warning']) {
                $url_warning = isset($data_cockpit['warning_url'])? $data_cockpit['warning_url']: '#';
            }
        }
    ?>
    <script>
        $(function() {
            <?php
                $xx = explode(".", $chartinfo[0]['valuex']);
                $x1 = $xx[0] - 1;
                $x2 = $xx[1] - 1;
                $yy = explode(".", $chartinfo[0]['valuey']);
                $y1 = $yy[0] - 1;
                $y2 = $yy[1] - 1;
            ?>
            //console.log(<?= $x1 ?>+":"+<?= $x2 ?>+" | "+<?= $y1 ?>+":"+<?= $y2 ?>);
            //console.log(document.getElementById('corner-exsummary').rows[<?= $x1 ?>].cells[<?= $x2 ?>].innerText);
            $arrCell = new Array();
            $arrCell[0] = document.getElementById('corner-exsummary').rows[<?= $x1 ?>].cells[<?= $x2 ?>].innerText;
            $arrCell[1] = parseInt(document.getElementById('corner-exsummary').rows[<?= $y1 ?>].cells[<?= $y2 ?>].innerText);
            
            //var data = 0.00;
            var data = parseFloat($arrCell[0]);
            var data_goal = <?php echo isset($data_cockpit['target']) ? $data_cockpit['target'] : 0; ?>;
            //var data_goal = parseFloat($arrCell[1]);
            var icon_alert = data_goal;
            var icon_alert_img = "js/HighCharts/img/alert_icon.gif";
            var link_alert = "<?php echo $url_warning; ?>";
            var background = "js/HighCharts/img/cockpit_bg.png"
    
            $('.container').highcharts({
                chart: {
                    type: 'gauge',
                    backgroundColor: 'transparent',
                    plotBackgroundImage: background,
                    height: 180,
                    width: 180
                },
                title: {
                    text: ''
                },
                pane: {
                    startAngle: -134,
                    endAngle: 134,
                    borderWidth: null,
                    background: [{
                            borderWidth: null,
                            outerRadius: '0%'
                        }]
                },
                yAxis: {
                    min: 0,
                    max: 100,
                    minorTickWidth: 0,
                    minorTickLength: 10,
                    tickPixelInterval: 0,
                    tickWidth: 5,
                    tickLength: 25,
                    style: {
                        fontSize: '18px',
                        color: '#000000'
                    },
                    labels: {
                        rotation: 'auto',
                        distance: -40,
                        style: {
                            fontSize: '16px',
                        }
                    },
                    title: {
                        text: ''
                    },
                    plotBands: [{
                            from: data_goal - 1.4,
                            to: data_goal + 1.4,
                            zIndex: 5,
                            color: '#FC3003',
                            innerRadius: '108%',
                            outerRadius: '106%'
                        }, {
                            from: data_goal - 1.2,
                            to: data_goal + 1.2,
                            zIndex: 5,
                            color: '#FC3003',
                            innerRadius: '107%',
                            outerRadius: '105%'
                        }, {
                            from: data_goal - 1,
                            to: data_goal + 1,
                            zIndex: 5,
                            color: '#FC3003',
                            innerRadius: '106%',
                            outerRadius: '104%'
                        }, {
                            from: data_goal - 0.8,
                            to: data_goal + 0.8,
                            zIndex: 5,
                            color: '#FC3003',
                            innerRadius: '105%',
                            outerRadius: '103%'
                        }, {
                            from: data_goal - 0.6,
                            to: data_goal + 0.6,
                            zIndex: 5,
                            color: '#FC3003',
                            innerRadius: '104%',
                            outerRadius: '102%'
                        }, {
                            from: data_goal - 0.4,
                            to: data_goal + 0.4,
                            zIndex: 5,
                            color: '#FC3003',
                            innerRadius: '103%',
                            outerRadius: '101%'
                        }, {
                            from: data_goal - 0.2,
                            to: data_goal + 0.2,
                            zIndex: 5,
                            color: '#FC3003',
                            innerRadius: '102%',
                            outerRadius: '100%'
                        }]
                },
                series: [{
                        enabled: true,
                        rotation: 0,
                        name: 'Success',
                        data: [data],
                        dial: {
                            radius: '75%',
                            backgroundColor: 'silver',
                            borderColor: '#555',
                            borderWidth: 1,
                            baseWidth: 14,
                            topWidth: 1,
                            baseLength: '15%', // of radius
                            rearLength: '15%'
                        },
                        pivot: {
                            radius: 18,
                            borderWidth: 1,
                            borderColor: 'gray',
                            backgroundColor: {
                                linearGradient: {x1: 0, y1: 0, x2: 1, y2: 1},
                                stops: [
                                    [0, 'white'],
                                    [3, 'gray']
                                ]
                            }
                        },
                        dataLabels: {
                            x: 0,
                            y: 35,
                            borderColor: null,
                            useHTML: true,
                            formatter: function() {
                                //rounds to 2 decimals
                                format_y = ((this.y < 10) ? '00' : ((this.y < 100) ? '0' : '')) + parseFloat(this.y).toFixed(2);
                                formatter_str = '<span style=\"margin-left:40px;\">';
                                style_str = 'border:#555 1px solid;margin:1px;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;padding:1px;';
                                style_str += 'background: -webkit-linear-gradient(top, #BBB, #FFF); background: -moz-linear-gradient(top, #BBB, #FFF);font-size:12px;';
                                for (i = 0; i < format_y.length; i++) {
                                    if (format_y[i] != '.') {
                                        formatter_str += '<span style=\"' + style_str + '\">' + format_y[i] + '</span>';
                                    } else {
                                        formatter_str += format_y[i];
                                    }
                                }
    
                                formatter_str += '</span>';
                                alert_img = '';
                                if (link_alert != '') {
                                    //icon_alert_img = (icon_alert != 0)?'<a href=\"../'+icon_alert_img+'\"><img src=' + icon_alert_img +' width=\"24\" /></a>':'<img src=' + icon_alert_img +' width=\"24\"/>';                                           
                                    //alert_img = (data < icon_alert)?'<a href=\"../'+link_alert+'\"><img src=' + icon_alert_img +' width=24 /></a>':'<span width=24></span>';  
                                    if (data < icon_alert) {
                                        alert_img = '<a href=\"../' + link_alert + '\"><img src=' + icon_alert_img + ' width=24 /></a>';
                                    }
                                } else {
                                    //icon_alert_img = (icon_alert != 0)?'<img src=' + icon_alert_img +'  width=\"24\" style=\"display:hidden\"/>':'<img src=' + icon_alert_img +' width=\"24\" style=\"display:hidden\"/>';
                                }
    
    
                                formatter_str += '<span >';
                                if (data < icon_alert) {
                                    formatter_str += '<span  style="margin-left:15px;">' + alert_img + '</span>';
                                } else {
                                    formatter_str += '<span  style="margin-left:39px;"></span>';
                                }
                                formatter_str += '</span>';
    
                                formatter_str += '</span>';
                                return formatter_str;
                            },
                            style: {
                                fontSize: '18px',
                                color: '#000000'
                            }
                        },
                        tooltip: {
                            valueSuffix: ' %'
                        }
                    }]
            });
        });
    </script>
    <?php
    }
	?>
<?php
}
?>