

function gaugeGender(myid, data, data_goal, icon_alert, link_alert){
		var data = data;
		var data_goal = data_goal;
		
		
		
        $('#'+myid).highcharts({
            chart: {
                type: 'gauge',
                backgroundColor:'transparent',
                //plotBackgroundImage:null,
				//plotBackgroundImage: '../images/cockpit-01.svg',
				plotBackgroundImage: 'img/cockpit_bg.png',
               // plotBorderWidth: false,
                //plotShadow: false,
				height: 240,
				width: 240
            },
            title: {
                text: ''
            },
            pane: {
                startAngle: -130,
                endAngle: 130,
				borderWidth:null,
                background: [{
                        borderWidth: null,
                        outerRadius: '0%'
                    }]
            },
            // the value axis
            yAxis: {
                min: 0,
                max: 100,
               // minorTickInterval: 'auto',
                minorTickWidth: 0,
                minorTickLength: 10,
                //minorTickPosition: 'inside',
                //minorTickColor: '#555',
                tickPixelInterval: 0,
                tickWidth: 5,
                //tickPosition: 'inside',
                tickLength: 25,
                //tickColor: '#666',
				style: {
							fontSize: '18px',
							color:'#000000'
						},
                labels: {
                   // step: 2,
                    rotation: 'auto',
					distance: -40,
					style: {
							fontSize: '16px',
					}
                },
                title: {
                    text: ''
                },
                plotBands: [{ // GOAL  ===============
					 from: data_goal-1.4,
                        to: data_goal+1.4,
						zIndex: 5,
                        color: '#FC3003',
						innerRadius: '108%',
            			outerRadius: '106%'
					 }, {
					  from: data_goal-1.2,
                        to: data_goal+1.2,
						zIndex: 5,
                        color: '#FC3003',
						innerRadius: '107%',
            			outerRadius: '105%'
					 }, {
					  from: data_goal-1,
                        to: data_goal+1,
						zIndex: 5,
                        color: '#FC3003',
						innerRadius: '106%',
            			outerRadius: '104%'
					 }, {
                        from: data_goal-0.8,
                        to: data_goal+0.8,
						zIndex: 5,
                        color: '#FC3003',
						innerRadius: '105%',
            			outerRadius: '103%'
					 }, {
                        from: data_goal-0.6,
                        to: data_goal+0.6,
						zIndex: 5,
                        color: '#FC3003',
						innerRadius: '104%',
            			outerRadius: '102%'	
					}, {
                        from: data_goal-0.4,
                        to: data_goal+0.4,
						zIndex: 5,
                        color: '#FC3003',
						innerRadius: '103%',
            			outerRadius: '101%'		
					}, {
                        from: data_goal-0.2,
                        to: data_goal+0.2,
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
							linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
							stops: [
								[0, 'white'],
								[3, 'gray']
							]
						}	
					},
					dataLabels: {
						x: 0,
                    	y: 35,
						borderColor:null,
						useHTML: true,
						formatter: function() {
								//rounds to 2 decimals
								format_y = ((this.y<10)?'00':((this.y<100)?'0':''))+parseFloat(this.y).toFixed(2);
								formatter_str ='<span style="margin-left:65px;">';
								style_str = 'border:#555 1px solid;margin:1px;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;padding:1px;'; 
 								style_str += 'background: -webkit-linear-gradient(top, #BBB, #FFF); background: -moz-linear-gradient(top, #BBB, #FFF);font-size:20px;';
								for(i=0;i<format_y.length;i++){
									if(format_y[i] != '.'){
										formatter_str += '<span style="'+style_str+'">'+format_y[i]+'</span>';
									}else{
										formatter_str += format_y[i];
									}
								}
								
								formatter_str += '</span>';
								icon_alert_img = '';
								if(link_alert != ''){
									icon_alert_img = (icon_alert != 0)?'<img src="img/alert_icon.gif" onclick="javascript:parent.linkPage('+link_alert+');" />':'<img src="img/non_alert.gif"/>';
									/*icon_alert_img = (icon_alert != 0)?'<a href="#" onclick="javascript:window.top.location=\''+link_alert+'\';" ><img src="../images/alert_icon.gif"/></a>':'<img src="../images/non_alert.gif"/>';*/
									
								}else{
									icon_alert_img = (icon_alert != 0)?'<img src="img/alert_icon.gif"/>':'<img src="img/non_alert.gif"/>';
								}
								
								
								formatter_str += '<span >';
								formatter_str += '<span  style="margin-left:30px;">'+icon_alert_img+'</span>';
								formatter_str += '</span>';
								
								formatter_str += '</span>';
                        		return formatter_str;
                    	},
						style: {
							fontSize: '18px',
							color:'#000000'
						}
					},
                    tooltip: {
                        valueSuffix: ' %'
                    }
                }]
        	});
}

function pieGender( myID, data ){
	
	$('#'+myID).highcharts({
        chart: {
			type: 'pie',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
			height: 580,
			width: 600
        },
		colors: ['#4baace',  '#ed8e52',  '#fcdb58', '#910000'],
        title: {
            text: ''
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b style="font-size:40px;color:{point.color};">{point.name}</b><br/><br/><br/> <b style="font-size:26px;color:#555;">{point.percentage:.2f}%</d> '
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: data
			/* Ex Data
			[
                ['Firefox',   45.0],
                ['IE',       26.8],
                {
                    name: 'Chrome',
                    y: 12.8,
                    sliced: true,
                    selected: true
                },
                ['Safari',    8.5],
                ['Opera',     6.2],
                ['Others',   0.7]
            ]
			*/
        }]
    });
}