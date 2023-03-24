// bitcoin widget charts
function widgetCommonOption(data) {
  return {
    series: [{
        data: data.widgetYseries
    }],
    chart: {
        width: 120,
        height: 120,
        type: 'line',
        toolbar: {
            show: false
        },
        offsetY: 10,
        dropShadow: {
            enabled: true,
            enabledOnSeries: undefined,
            top: 6,
            left: 0,
            blur: 6,
            color: data.dropshadowColor,
            opacity: 0.3
        }
},
grid: {
    show: false
},
colors: data.color,
stroke: {
    width: 2,
    curve: 'smooth'
},
labels: data.label,
markers: {
    size: 0
},
xaxis: {
    // type: 'datetime',
    axisBorder: {
        show: false
    },
    axisTicks: {
        show: false
    },
    labels: {
        show: false
    },
    tooltip: {
        enabled: false
    }
},
yaxis: {
    axisBorder: {
        show: false
    },
    axisTicks: {
        show: false
    },
    labels: {
        show: false
    }
},
legend: {
    show: false
},
tooltip: {
     marker: {
          show: false,
      },
    x: {
          show: false,
      },
      y: {
          show: false,
          labels: {
            show: false
          }
      },
    },
responsive: [
  {
    breakpoint: 1790,
    options:{
        chart: {
          width: 100,
          height: 100,
        }
    }
  },
  {
    breakpoint: 1661,
    options:{
        chart: {
          width: "100%",
          height: 100,
        }
    }
  },
]
}
}


const widget1 = {
  color: ["#FFA941"],
  dropshadowColor:"#FFA941",
  label: ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul',
    'aug', 'sep', 'oct', 'nov'],
  widgetYseries: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39],
};

const widgetchart1 = document.querySelector('#currency-chart');
if (widgetchart1) {
  var bitcoinChart1 = new ApexCharts(widgetchart1, widgetCommonOption(widget1));
  bitcoinChart1.render();
}

// widget 2
const widget2 = {
  color: ["var(--theme-deafult)"],
  dropshadowColor:"var(--theme-deafult)",
  label: ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul',
    'aug', 'sep'],
  widgetYseries: [30, 25, 30, 25, 64, 40, 59, 52, 64],
};

const widgetchart2 = document.querySelector('#currency-chart2');
if (widgetchart2) {
  var bitcoinChart2 = new ApexCharts(widgetchart2, widgetCommonOption(widget2));
  bitcoinChart2.render();
}

// widget 3
const widget3 = {
  color: ["#54BA4A"],
  dropshadowColor:"#54BA4A",
  label: ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul',
    'aug', 'sep', 'oct'],
  widgetYseries: [30, 25, 36, 30, 64, 50, 45, 62, 60,64],
};

const widgetchart3 = document.querySelector('#currency-chart3');
if (widgetchart3) {
  var bitcoinChart3 = new ApexCharts(widgetchart3, widgetCommonOption(widget3));
  bitcoinChart3.render();
}


// radial chart js
function radialCommonOption(data) {
  return {
      series: data.radialYseries,
      chart: {
        height: 150,
        type: 'radialBar',
        dropShadow: {
            enabled: true,
            top: 3,
            left: 0,
            blur: 10,
            color: data.dropshadowColor,
            opacity: 0.35
        }
    },
    plotOptions: {
        radialBar: {
            hollow: {
                size: '60%',
            },
            track: {
                strokeWidth: '45%',
                opacity: 1,
                margin: 5,
            },
            dataLabels: {
                showOn: "always",
                value: {
                    color: "var(--chart-text-color)",
                    fontSize: "18px",
                    show: true,
                    offsetY: -8,
                }
            }
        },
    },
    colors: data.color,
    stroke: {
        lineCap: "round",
    },
    responsive: [
      {
        breakpoint: 1500,
        options:{
            chart: {
              height: 130,
            }
        }
      },
    ]
  }
}

const radial1 = {
  color: ["var(--theme-deafult)"],
  dropshadowColor:"var(--theme-deafult)",
  radialYseries: [70],
};

const radialchart1 = document.querySelector('#radial-chart');
if (radialchart1) {
  var radialprogessChart1 = new ApexCharts(radialchart1, radialCommonOption(radial1));
  radialprogessChart1.render();
}

// radial 2
const radial2 = {
  color: ["var(--theme-secondary)"],
  dropshadowColor:"var(--theme-secondary)",
  radialYseries: [80],
};

const radialchart2 = document.querySelector('#radial-chart2');
if (radialchart2) {
  var radialprogessChart2 = new ApexCharts(radialchart2, radialCommonOption(radial2));
  radialprogessChart2.render();
}

// radial 3
const radial3 = {
  color: ["#54BA4A"],
  dropshadowColor:"#54BA4A",
  radialYseries: [48],
};

const radialchart3 = document.querySelector('#radial-chart3');
if (radialchart3) {
  var radialprogessChart3 = new ApexCharts(radialchart3, radialCommonOption(radial3));
  radialprogessChart3.render();
}

// market chart
var marketoptions = {
    series: [{
      name: 'TEAM A',
      type: 'column',
      data: [4, 8, 4.5,8, 13, 8.5, 12, 5, 7, 12]
  }, {
      name: 'TEAM C',
      type: 'line',
      data: [2, 3, 2, 6, 8, 12, 9, 7, 9, 7]
  }],
    chart: {
      height: 300,
      type: 'line',
      stacked: false,
      toolbar: {
        show: false
      },
      dropShadow: {
        enabled: true,
        enabledOnSeries: [1],
        top: 0,
        left: 0,
        blur: 15,
        color: 'var(--theme-deafult)',
        opacity: 0.3
    }
  },
  stroke: {
    width: [0, 3],
    curve: 'smooth'
  },
  dataLabels: {
    enabled: true,
    enabledOnSeries: [1],
  },
  colors: ["rgba(170, 175, 203, 0.2)", "var(--theme-deafult)"],
  grid: {
    borderColor: 'var(--chart-border)'
  },
  plotOptions: {
    bar: {
      columnWidth: '20%',
    },
  },
  
  fill: {
    type: ['solid','gradient'],
      gradient: {
        shade: 'light',
        type: "vertical",
        shadeIntensity: 0.5,
        gradientToColors: ["var(--theme-deafult)","#d867ac"],
        opacityFrom: 0.8,
        opacityTo: 0.8,
        colorStops: [
        {
          offset: 0,
          color: "#d867ac",
          opacity: 1
        },
        {
          offset: 30,
          color: "#d867ac",
          opacity: 1
        },
        {
          offset: 50,
          color: "var(--theme-deafult)",
          opacity: 1
        },
        {
          offset: 80,
          color: "var(--theme-deafult)",
          opacity: 1
        },
        {
          offset: 100,
          color: "var(--theme-deafult)",
          opacity: 1
        },
      ]
    },
  },
  labels: ['Sep 10', 'Sep 15', 'Sep 20', 'Sep 25', 'Sep 30', 'Oct 05', 'Oct 10',
    'Oct 15', 'Oct 20', 'Oct 25'
  ],
  markers: {
    size: 0
  },
  yaxis: {
    min: 0,
    max: 20,
    tickAmount: 5,
    labels: {
      formatter: function (val) {
          return val + "k";
      },
      style: {
          fontSize: "12px",
          fontFamily: "Rubik, sans-serif",
          colors: "var(--chart-text-color)"
      }
    }
  },
  xaxis: {
    tooltip: {
      enabled: false
    },
    labels: {
      style: {
          fontSize: "10px",
          fontFamily: "Rubik, sans-serif",
          colors: "var(--chart-text-color)"
      }
    }
  },
  tooltip: {
    shared: true,
    intersect: false,
  },
  legend: {
    show: false
  }
};

  var marketchart = new ApexCharts(document.querySelector("#market-chart"), marketoptions);
  marketchart.render();

// portfolio chart
var portfoliooptions = {
  series: [44, 55, 67],
  chart: {
  height: 280,
  type: 'radialBar',
},
plotOptions: {
  radialBar: {
    dataLabels: {
      show: false
    },
    track: {
      background: "var(--chart-progress-light)",
      opacity: 0.3,
    },
    hollow: {
      margin: 10,
      size: '40%',
      image: '../assets/images/dashboard-4/portfolio-bg.png',
      imageWidth: 230,
      imageHeight: 230,
      imageClipped: false
    },
  }
},
colors: ["#54BA4A", "#FFA539", "#7366FF"],
labels: ['USD', 'BTC', 'ETH'],
fill: {
   type: 'gradient',
    gradient: {
      shade: 'light',
      type: 'horizontal',
      shadeIntensity: 0.25,
      inverseColors: true,
      opacityFrom: 1,
      opacityTo: 1,
      stops: [50, 0, 80, 100]
    }
},
responsive: [
  {
    breakpoint: 1500,
    options:{
        chart: {
          height: 260,
        },
        plotOptions: {
          radialBar: {
            hollow: {
              margin: 10,
              size: '40%',
              image: '../assets/images/dashboard-4/portfolio-bg.png',
              imageWidth: 190,
              imageHeight: 190,
              imageClipped: false
            },
          }
        },
    }
  },
  {
    breakpoint: 1400,
    options:{
        chart: {
          height: 320,
        },
        plotOptions: {
          radialBar: {
            hollow: {
              imageWidth: 260,
              imageHeight: 260,
            },
          }
        },
    }
  },
  {
    breakpoint: 650,
    options:{
        chart: {
          height: 280,
        },
        plotOptions: {
          radialBar: {
            hollow: {
              imageWidth: 220,
              imageHeight: 220,
            },
          }
        },
    }
  },
]
};

var portfoliochart = new ApexCharts(document.querySelector("#portfolio-chart"), portfoliooptions);
portfoliochart.render();