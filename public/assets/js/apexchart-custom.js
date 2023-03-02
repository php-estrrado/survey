var options = {
	series: [{
		data: [
			[1327359600000, 30.95],
			[1327446000000, 31.34],
			[1327532400000, 31.18],
			[1327618800000, 31.05],
			[1327878000000, 31.00],
			[1327964400000, 30.95],
			
		]
	}],
	colors: ['#705ec8'],
	chart: {
		id: 'area-datetime',
		type: 'area',
		height: 300,
		zoom: {
			autoScaleYaxis: true
		}
	},
	annotations: {
		yaxis: [{
			y: 30,
			borderColor: '#999',
			label: {
				show: true,
				text: 'Support',
				style: {
					color: "#fff",
					background: '#00E396'
				}
			}
		}],
		xaxis: [{
			x: new Date('14 Nov 2012').getTime(),
			borderColor: '#999',
			yAxisIndex: 0,
			label: {
				show: true,
				text: 'Rally',
				style: {
					color: "#fff",
					background: '#775DD0'
				}
			}
		}]
	},
	dataLabels: {
		enabled: false
	},
	markers: {
		size: 0,
		style: 'hollow',
	},
	xaxis: {
		type: 'datetime',
		min: new Date('01 Mar 2012').getTime(),
		tickAmount: 6,
	},
	tooltip: {
		x: {
			format: 'dd MMM yyyy'
		}
	},
	fill: {
		type: 'gradient',
		gradient: {
			shadeIntensity: 1,
			opacityFrom: 0.7,
			opacityTo: 0.9,
			stops: [0, 100]
		}
	},
};
var chart = new ApexCharts(document.querySelector("#chart-timeline"), options);
chart.render();

var options1 = {
	series: [{
		name: 'series1',
		data: [31, 40, 28, 51, 42, 109, 100]
	}, {
		name: 'series2',
		data: [11, 32, 45, 32, 34, 52, 41]
	}],
	colors: ['#705ec8','#fa057a'],
	chart: {
		height: 300,
		type: 'area'
	},
	dataLabels: {
		enabled: false
	},
	stroke: {
		curve: 'smooth'
	},
	xaxis: {
		type: 'datetime',
		categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
	},
	tooltip: {
		x: {
			format: 'dd/MM/yy HH:mm'
		},
	},
	legend: {
		show: false,
	}
};
var chart1 = new ApexCharts(document.querySelector("#chart"), options1);
chart1.render();

var options2 = {
	series: [{
		data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]
	}],
	colors: ['#705ec8','#fa057a'],
	chart: {
		type: 'bar',
		height: 300,
	},
	plotOptions: {
		bar: {
			horizontal: true,
		}
	},
	dataLabels: {
		enabled: false
	},
	xaxis: {
		categories: ['South Korea', 'Canada', 'United Kingdom', 'Netherlands', 'Italy', 'France', 'Japan', 'United States', 'China', 'Germany'],
	},
	legend: {
		show: false,
	}
};
var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
chart2.render();

var options3 = {
	series: [{
		name: 'Marine Sprite',
		data: [44, 55, 41, 37, 22, 43, 21]
	}, {
		name: 'Striking Calf',
		data: [23, 22, 23, 22, 13, 13, 12]
	}, {
		name: 'Tank Picture',
		data: [22, 27, 21, 29, 15, 21, 20]
	}, {
		name: 'Bucket Slope',
		data: [25, 12, 19, 32, 25, 24, 10]
	}, {
		name: 'Reborn Kid',
		data: [9, 7, 5, 8, 6, 9, 4]
	}],
	colors: ['#705ec8', '#fa057a', '#2dce89', '#ff5b51',  '#fcbf09'],
	chart: {
		type: 'bar',
		height: 300,
		stacked: true,
	},
	plotOptions: {
		bar: {
			horizontal: true,
		},
	},
	stroke: {
		width: 1,
		colors: ['#fff']
	},
	xaxis: {
		categories: [2008, 2009, 2010, 2011, 2012, 2013, 2014],
		labels: {
			formatter: function(val) {
				return val + "K"
			}
		}
	},
	yaxis: {
		title: {
			text: undefined
		},
	},
	tooltip: {
		y: {
			formatter: function(val) {
				return val + "K"
			}
		}
	},
	fill: {
		opacity: 1
	},
	legend: {
		show: false,
		position: 'top',
		horizontalAlign: 'left',
		offsetX: 40
	}
};
var chart3 = new ApexCharts(document.querySelector("#chart3"), options3);
chart3.render();

var options4 = {
	series: [44, 55, 41, 17, 15],
	colors: ['#705ec8', '#fa057a', '#2dce89', '#ff5b51',  '#fcbf09'],
	chart: {
		height: 300,
		type: 'donut',
	},
	legend: {
		show: false,
	},
	responsive: [{
		breakpoint: 480,
		options: {
			chart: {
				width: 200
			},
			legend: {
				show: false,
				position: 'bottom'
			}
		}
	}]
};
var chart4 = new ApexCharts(document.querySelector("#chart4"), options4);
chart4.render();

var options5 = {
	series: [44, 55, 13, 43, 22],
	colors: ['#705ec8', '#fa057a',  '#2dce89', '#ff5b51', '#fcbf09'],
	chart: {
		height: 300,
		type: 'pie',
	},
	labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
	legend: {
		show: false,
	},
	responsive: [{
		breakpoint: 480,
		options: {
			chart: {
				width: 200
			},
			legend: {
				show: false,
				position: 'bottom'
			}
		}
	}]
};
var chart5 = new ApexCharts(document.querySelector("#chart5"), options5);
chart5.render();


var options8 = {
	series: [70],
	chart: {
		height: 200,
		type: 'radialBar',
	},
	plotOptions: {
		radialBar: {
			hollow: {
				label: "acc",
				size: '70%',
			}
		},
	},
	labels: [' '],
	colors: ['#4454c3'],
	responsive: [{
		options: {
			legend: {
				show: false,
			}
		}
	}]
};
var chart8 = new ApexCharts(document.querySelector("#chart8"), options8);
chart8.render();

var options9 = {
	series: [44, 55, 67, 83],
	chart: {
		height: 300,
		type: 'radialBar',
	},
	plotOptions: {
		radialBar: {
			dataLabels: {
				name: {
					fontSize: '22px',
				},
				value: {
					fontSize: '16px',
				},
				total: {
					show: false,
					label: 'Total',
					formatter: function(w) {
						// By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
						return 249
					}
				}
			}
		}
	},
	labels: ['data1', 'data1', 'data1', 'data1'],
	colors: ['#705ec8', '#fa057a',  '#2dce89', '#ff5b51', '#fcbf09'],
};
var chart9 = new ApexCharts(document.querySelector("#chart9"), options9);
chart9.render();