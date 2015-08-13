
/*$(function () {
    $('#price-charts').highcharts({
		colors:['#62ab00','#bf5a2f','#578fd5'],
        title: {
            text: '',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: ['8月', '9月', '10月', '11月', '12月', '1月','2月', '3月', '4月', '5月', '6月', '7月']
        },
        yAxis: {
            title: {
                text: ''
            },
			labels: {
			formatter:function(){
				  if(this.value <=100) { 
					return "第一等级("+this.value+")";
				  }else if(this.value >100 && this.value <=200) { 
					return "第二等级("+this.value+")"; 
				  }else { 
					return "第三等级("+this.value+")";
				  }
				}
			},
			opposite:true,
            plotLines: [{
                value: 5,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '元/m²'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
			name:'',
            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
        }, {
			name:'',
            data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
        }, {
            data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
        }],
		credits:false
    });
});*/