var options = {
    series: [
    {
      name: "Sales",
      data: [23, 23, 20, 20, 32, 32,40,32,32,25,30,30]
    },
    {
      name: "sales",
      data: [22, 22, 19, 19, 31, 31,39,31,31,24,29,29]
    },
    {
      name: "sales",
      data: [21, 21, 18, 18, 30, 30,38,30,30,23,28,28]
    },
    {
      name: "sales",
      data: [20, 20, 17, 17, 29, 29,37,29,29,22,27,27]
    },
    {
      name: "sales",
      data: [19, 19, 16, 16, 28, 28,36,28,28,21,26,26]
    },
    {
      name: "sales",
      data: [18, 18, 15, 15, 27, 27,35,27,27,20,25,25]
    },
    {
      name: "sales",
      data: [17, 17, 14, 14, 26, 26,34,26,26,19,24,24]
    },
    {
      name: "sales",
      data: [16, 16, 13, 13, 25, 25,33,25,25,18,23,23]
    },
    {
      name: "sales",
      data: [16, 16, 13, 13, 25, 25,33,25,25,18,23,23]
    },
    {
      name: "sales",
      data: [15, 15, 12, 12, 24, 24,32,24,24,17,22,22]
    },
    {
      name: "sales",
      data: [14, 14, 11, 11, 23, 23,31,23,23,16,21,21]
    },
    {
      name: "sales",
      data: [13, 13, 10, 10, 22, 22,30,22,22,15,20,20]
    }
  ],
    chart: {
    height: 235,
    type: 'line',
    toolbar: {
      show: false
    }
  },
  colors: ['#7064F5', '#7064F5', '#7064F5','#7064F5', '#7064F5', '#7064F5','#7064F5', '#7064F5', '#7064F5','#7064F5', '#7064F5', '#7064F5'],
  fill: {
    type: 'gradient',
    gradient: {
        shade: 'dark',
        type: "horizontal",
        shadeIntensity: 1,
        gradientToColors: ['#FF8BA7', '#FF8BA7', '#FF8BA7','#FF8BA7', '#FF8BA7', '#FF8BA7','#FF8BA7', '#FF8BA7', '#FF8BA7','#FF8BA7', '#FF8BA7', '#FF8BA7'],
        inverseColors: true,
        opacityFrom: 1,
        opacityTo: 1,
        // stops: [0, 50, 100],
        colorStops: [
        {
          offset: 0,
          color: "#e183b7",
          opacity: 1
        },
        {
          offset: 20,
          color: "#ff8ba7",
          opacity: 1
        },
        {
          offset: 30,
          color: "#b377d0",
          opacity: 1
        },
        {
          offset: 65,
          color: "#7064f5",
          opacity: 1
        },
        {
          offset: 70,
          color: "#b778cf",
          opacity: 1
        },
        {
          offset: 80,
          color: "#eb86b2",
          opacity: 1
        },
        {
          offset: 100,
          color: "#a873d7",
          opacity: 1
        }
      ]
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    curve: 'smooth',
    width: 2,
  },
  grid: {
    borderColor: '#e7e7e7',
    yaxis: {
        lines: {
            show: false
        }
    },   
    column: {
      colors: ['transparent','var(--light-background)'], // takes an array which will be repeated on columns
      opacity: 0.5
    },
  },
  xaxis: {
    categories: ['01', '03', '05', '07', '09', '10', '11', '12',"15", "16","18"],
    tickAmount: 6,
    tickPlacement: 'between',
    axisTicks: {
      show: false
    },
    axisBorder: {
      show: false
    },
    tooltip: {
      enabled: false,
    },
  },
  yaxis: {
    min: 5,
    max: 40,
    axisBorder: {
       show: true,
       color: 'var(--chart-border)',
        offsetX: 12,
        offsetY: 5
    }
  },
  legend: {
    show: false
  },
  tooltip: {
      shared: false,
   },
   responsive: [{
    breakpoint: 1400,
    options: {
      chart: {
        height: 230
      },
    }
  },
  ]
};

var chart = new ApexCharts(document.querySelector("#order-goal"), options);
chart.render();


// profit monthly
var optionsprofit = {
    labels: ['Shoes', 'Grocery', 'other'],
    series: [30, 55, 35],
    chart: {
      type: 'donut',
      height: 300,
    },
    dataLabels: {
          enabled: false
    },
    legend: {
        position: 'bottom',
        fontSize: '14px',
        fontFamily: 'Rubik, sans-serif',
        fontWeight: 500,
        labels: {
          colors: ["var(--chart-text-color)"],
        },
        markers: {
          width: 6,
          height: 6,
        },
        itemMargin: {
          horizontal: 7,
          vertical: 0
        },
    },
    stroke: {
      width: 10,
      colors: ["var(--light2)"],
    },
     plotOptions: {
      pie: {
        expandOnClick: false,
        donut: {
          size: '83%',
           labels: {
              show: true,
              name: {
                offsetY: 4,
              },
              total: {
                show: true,
                fontSize: '20px',
                fontFamily: 'Rubik, sans-serif',
                fontWeight: 500,
                label: '$ 34,098',
                formatter: () => 'Total Profit'
              }
            },
        }
      }
    },
    states: {
      normal: {
          filter: {
              type: 'none',
          }
      },
      hover: {
          filter: {
              type: 'none',
          }
      },
      active: {
          allowMultipleDataPointsSelection: false,
          filter: {
              type: 'none',
          }
      },
    },
    colors: ["#54BA4A", "var(--theme-deafult)", "#FFA941"],
  responsive: [{
    breakpoint: 1630,
    options: {
      chart: {
        height: 360
      },
    }
  },
  {
    breakpoint: 1584,
    options: {
      chart: {
        height: 400
      },
    }
  },
  {
    breakpoint: 1473,
    options: {
      chart: {
        height: 250
      },
    }
  },
  {
    breakpoint: 1425,
    options: {
      chart: {
        height: 270
      },
    }
  },
  {
    breakpoint: 1400,
    options: {
      chart: {
        height: 320
      },
    }
  },
  {
    breakpoint: 480,
    options: {
      chart: {
        height: 250
      },
      
    }
  }]
};

var chartprofit = new ApexCharts(document.querySelector("#profitmonthly"), optionsprofit);
chartprofit.render();

// overview chart
var optionsoverview = {
    series: [ {
    name: 'Earning',
    type: 'area',
    data: [44, 55, 35, 50, 67, 50, 55, 45, 32, 38, 45]
  }, 
  {
    name: 'Order',
    type: 'area',
    data: [35, 30, 23, 40, 50, 35, 40, 52, 67, 50, 55]
  },
  {
    name: 'Refunds',
    type: 'area',
    data: [25, 20, 15, 25, 32, 20, 30, 35, 23, 30, 20]
  },
],
    chart: {
    height: 300,
    type: 'line',
    stacked: false,
    toolbar: {
      show: false
    },
    dropShadow: {
        enabled: true,
        top: 2,
        left: 0,
        blur: 4,
        color: '#000',
        opacity: 0.08
    }
  },
  stroke: {
    width: [2, 2, 2],
    curve: 'smooth'
  },
  grid: {
    show: true,
    borderColor: 'var(--chart-border)',
    strokeDashArray: 0,
    position: 'back',
    xaxis: {
        lines: {
            show: true
        }
    },   
    padding: {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    },  
  },
  plotOptions: {
    bar: {
      columnWidth: '50%'
    }
  },
  colors: ["#7064F5", "#54BA4A", "#FF3364"],
  fill: {
    type: 'gradient',
    gradient: {
      shade: 'light',
      type: "vertical",
      opacityFrom: 0.4,
      opacityTo: 0,
      stops: [0, 100]
    }
  },
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul',
    'Aug', 'Sep', 'Oct', 'Nov'
  ],
  markers: {
    discrete: [{
        seriesIndex: 0,
        dataPointIndex: 2,
        fillColor: '#7064F5',
        strokeColor: 'var(--white)',
        size: 5,
        sizeOffset: 3
      }, {
        seriesIndex: 1,
        dataPointIndex: 2,
        fillColor: '#54BA4A',
        strokeColor: 'var(--white)',
        size: 5,
      },
      {
        seriesIndex: 2,
        dataPointIndex: 2,
        fillColor: '#FF3364',
        strokeColor: 'var(--white)',
        size: 5,
      },
      {
        seriesIndex: 0,
        dataPointIndex: 5,
        fillColor: '#7064F5',
        strokeColor: 'var(--white)',
        size: 5,
        sizeOffset: 3
      }, {
        seriesIndex: 1,
        dataPointIndex: 5,
        fillColor: '#54BA4A',
        strokeColor: 'var(--white)',
        size: 5,
      },
      {
        seriesIndex: 2,
        dataPointIndex: 5,
        fillColor: '#FF3364',
        strokeColor: 'var(--white)',
        size: 5,
      },
      {
        seriesIndex: 0,
        dataPointIndex: 9,
        fillColor: '#7064F5',
        strokeColor: 'var(--white)',
        size: 5,
        sizeOffset: 3
      }, {
        seriesIndex: 1,
        dataPointIndex: 9,
        fillColor: '#54BA4A',
        strokeColor: 'var(--white)',
        size: 5,
      },
      {
        seriesIndex: 2,
        dataPointIndex: 9,
        fillColor: '#FF3364',
        strokeColor: 'var(--white)',
        size: 5,
      },
    ],
    hover: {
      size: 5,
      sizeOffset: 0
    }
},
  xaxis: {
    type: 'category',
    tickAmount: 4,
    tickPlacement: 'between',
    tooltip: {
      enabled: false,
    },
    axisBorder: {
       color: 'var(--chart-border)',
    },
    axisTicks: {
      show: false
    }
  },
  legend: {
    show: false,
  },
  yaxis: {
    min: 0,
    tickAmount: 6,
    tickPlacement: 'between',
  },
  tooltip: {
    shared: false,
    intersect: false,
  },
  responsive: [{
    breakpoint: 1200,
    options: {
      chart: {
        height: 250,
      }
    },
  }]

};

var chartoverview = new ApexCharts(document.querySelector("#orderoverview"), optionsoverview);
chartoverview.render();

// bar overview chart
 var optionsorder = {
      series: [ {
      name: 'Revenue',
      data: [30,40,18,25,18,10,20,35,22,40,30,38,20,35,11,28,40,11,28,40,11,28,40,11,28,40,11]
    }],
      chart: {
      type: 'bar',
      height: 180,
      toolbar: {
        show: false
      }
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '55%',
      },
    },
    colors: ["var(--light-bg)"],
    grid: {
      show: false,
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    xaxis: {
      categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
      labels: {
        show: false
      },
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      }
    },
    yaxis: {
       labels: {
        show: false
      },
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      }
    },
    fill: {
      opacity: 0.7
    },
    tooltip: {
      enabled: false
    },
    states: {
      normal: {
          filter: {
              type: 'none',
          }
      },
      hover: {
          filter: {
             type: 'none',
          }
      },
      active: {
          allowMultipleDataPointsSelection: false,
          filter: {
              type: 'none',
          }
      },
    },
    responsive: [{
      breakpoint: 405,
      options: {
        chart: {
          height: 150,
        }
      },
    }]
};

var chartorder = new ApexCharts(document.querySelector("#order-bar"), optionsorder);
chartorder.render();

// visitor chart
var optionsvisitor = {
    series: [{
    name: 'Active',
    data: [18, 10, 65, 18, 28, 10]
  }, {
    name: 'Bounce',
    data: [25, 50, 30, 30, 25, 45]
  }],
    chart: {
      type: 'bar',
      height: 270,
      toolbar: {
        show: false
      },
    },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '50%',
    },
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    show: true,
    width: 6,
    colors: ['transparent']
  },
  grid: {
    show: true,
    borderColor: 'var(--chart-border)',
    xaxis: {
        lines: {
            show: true
        }
    }, 
  },
  colors: ["#FFA941", "var(--theme-deafult)"],
  xaxis: {
    categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    tickAmount: 4,
    tickPlacement: 'between',
    labels: {
      style: {
        fontFamily: 'Rubik, sans-serif',
      },
    },
    axisBorder: {
      show: false
    },
    axisTicks: {
      show: false
    }
  },
  yaxis: {
    min: 0,
    max: 100,
    tickAmount: 5,
    tickPlacement: 'between',
    labels: {
      style: {
        fontFamily: 'Rubik, sans-serif',
      }
    }
  },
  fill: {
    opacity: 1
  },
  legend: {
    position: 'top',
    horizontalAlign: 'left', 
    fontFamily: "Rubik, sans-serif",
    fontSize: '14px',
    fontWeight: 500,
    labels: {
          colors: "var(--chart-text-color)",
    },
    markers: {
      width: 6,
      height: 6,
      radius: 12,
    },
    itemMargin: {
      horizontal: 10,
    }
  },
  responsive: [{
    breakpoint: 1366,
    options: {
      plotOptions: {
        bar: {
          columnWidth: '80%',
        },
      },
      grid: {
        padding: {
          right: 0,
        }
      }
    },
  },
  {
    breakpoint: 992,
    options: {
      plotOptions: {
        bar: {
          columnWidth: '70%',
        },
      },
    },
  },
  {
    breakpoint: 576,
    options: {
      plotOptions: {
        bar: {
          columnWidth: '60%',
        },
      },
      grid: {
        padding: {
          right: 5,
        }
      }
    },
  }
  ]
};

  var chartvisitor = new ApexCharts(document.querySelector("#visitor-chart"), optionsvisitor);
  chartvisitor.render();




