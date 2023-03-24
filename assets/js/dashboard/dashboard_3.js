var options = {
    series: [38, 60],
    chart: {
        width: 240,
        height: 360,
        type: 'radialBar',
        offsetX: -28,
    },
    plotOptions: {
        radialBar: {
            dataLabels: {
                name: {
                offsetY: 20,
                color: "var(--chart-text-color)",
                fontFamily: 'Rubik, sans-serif',
                fontWeight: 500,
                },
                value: {
                fontSize: '22px',
                offsetY: -16,
                fontFamily: 'Rubik, sans-serif',
                fontWeight: 500,
                },
                total: {
                show: true,
                label: 'Task Done!',
                fontSize: '12px',
                formatter: function () {
                    return "89%"
                }
                }
            },
            hollow: {
                margin: 5,
                size: '70%',
                image: hotspot_url.plugin_url + 'assets/images/dashboard-3/round.png',
                imageWidth: 115,
                imageHeight: 115,
                imageClipped: false,
            },
             track: {
              background: 'transparent',
             }
        }
    },
    colors: [ "var(--theme-deafult)", "#FFA941"],
    labels: ['进行中', '已完成'],
    stroke: {
        lineCap: 'round'
    },
    legend: {
        show: true,
        position: "bottom",
        horizontalAlign: 'center', 
        offsetY: -15,
        fontSize: '14px',
        fontFamily: 'Rubik, sans-serif',
        fontWeight: 500,
        labels: {
          colors: "var(--chart-text-color)",
        },
        markers: {
          width: 6,
          height: 6,
        }
    },
    responsive: [
      {
        breakpoint: 1830,
        options:{
           chart: {
              offsetX: -40,
           }
        }
      },
      {
        breakpoint: 1750,
        options:{
           chart: {
              offsetX: -50,
           }
        }
      },
      {
        breakpoint: 1661,
        options:{
           chart: {
              offsetX: -10,
           }
        }
      },
      {
        breakpoint: 1530,
        options:{
           chart: {
              offsetX: -25,
           }
        }
      },
      {
        breakpoint: 1400,
        options:{
           chart: {
              offsetX: 10,
           }
        }
      },
      {
        breakpoint: 1300,
        options:{
           chart: {
              offsetX: -10,
           }
        }
      },
      {
        breakpoint: 1200,
        options:{
           chart: {
              width: 255,
           }
        }
      },
      {
        breakpoint: 992,
        options:{
           chart: {
              width: 245,
           }
        }
      },
      {
        breakpoint: 600,
        options:{
           chart: {
              width: 225,
           }
        }
      },
    ] 
};

var chart = new ApexCharts(document.querySelector("#progresschart"), options);
chart.render();



// activity chart
var optionsactivity = {
        series: [{
        name: '发布量',
        data: [2, 4, 2.5, 1.5, 5.5, 1.5, 4]
    }],
        chart: {
        height: 300,
        type: 'bar',
        toolbar: {
            show: false
        },
        dropShadow: {
          enabled: true,
          // enabledOnSeries: undefined,
          top: 10,
          left: 0,
          blur: 5,
          color: "#7064F5",
          opacity: 0.35
        }
    },
    plotOptions: {
        bar: {
          borderRadius: 6,
          columnWidth: '30%',
        }
    },
    dataLabels: {
        enabled: false,
    },
    xaxis: {
        categories: ["日", "一", "二", "三", "四", "五", "六"],
        labels: {
            style: {
                fontSize: "12px",
                fontFamily: "Rubik, sans-serif",
                colors: "var(--chart-text-color)"
            }
        },
        axisBorder: {
        show: false
        },
        axisTicks: {
        show: false
        },
        tooltip: {
            enabled: false,
        }
    },
    yaxis: {
        axisBorder: {
        show: false
        },
        axisTicks: {
        show: false,
        },
        labels: {
            formatter: function (val) {
                return val + " " + "篇";
            },
            style: {
                fontSize: "12px",
                fontFamily: "Rubik, sans-serif",
                colors: "var(--chart-text-color)"
            }
        }
    
    },
    grid: {
        borderColor: 'var(--chart-dashed-border)',
        strokeDashArray: 5,
    },
    colors: ["#7064F5", "#8D83FF"],
    fill: {
        type: 'gradient' ,
        gradient: {
            shade: 'light',
            type: "vertical",
            gradientToColors: ["#7064F5", "#8D83FF"],
            opacityFrom: 0.98,
            opacityTo: 0.85,
            stops: [0, 100],
        },
    },
    responsive: [
      {
        breakpoint: 1200,
        options:{
           chart: {
              height: 200,
           }
        }
      },
    ]
};

var chartactivity = new ApexCharts(document.querySelector("#activity-chart"), optionsactivity);
chartactivity.render();

// upcoming event chart
  var upcomingoptions = {
    series: [
    {
      data: [
        {
          x: 'HotSpot-AI 发布',
          y: [
            new Date('2022-02-01').getTime(),
            new Date('2022-03-10').getTime()
          ],
          strokeColor: "var(--theme-deafult)",
          fillColor: 'var(--white)'
        },
        {
          x: 'BUG 修复',
          y: [
            new Date('2022-02-01').getTime(),
            new Date('2022-03-10').getTime()
          ],
          strokeColor: "#54BA4A",
          fillColor: 'var(--white)'
        },
        {
          x: 'UI/UX 设计',
          y: [
            new Date('2022-02-01').getTime(),
            new Date('2022-03-10').getTime()
          ],
          strokeColor: "#FFAA05",
          fillColor: 'var(--white)'
        },
        {
          x: 'LOGO 制作',
          y: [
            new Date('2022-02-10').getTime(),
            new Date('2022-03-15').getTime()
          ],
          strokeColor: "#FF3364",
          fillColor: 'var(--white)'
        },
      ]
    }
  ],
    chart: {
    height: 305,
    type: 'rangeBar',
    toolbar:{
        show:false,
      },
  },
  plotOptions: {
    bar: {
      horizontal: true,
      distributed: true,
      barHeight: '50%',
      dataLabels: {
        hideOverflowingLabels: false,
      },
    }
  },
  dataLabels: {
    enabled: true,
    formatter: function(val, opts) {
      var label = opts.w.globals.labels[opts.dataPointIndex]
      return label
    },
    textAnchor: 'middle',
    offsetX: 0,
    offsetY: 0,
     background: {
    enabled: true,
    foreColor: 'var(--chart-text-color)',
    padding: 10,
    borderRadius: 12,
    borderWidth: 1,
    opacity: 0.9,
  },
  },
  xaxis: {
    type: 'datetime',
     position: 'top',
     axisBorder: {
      show: false
     },
     axisTicks: {
      show: false
     }
  },
  yaxis: {
    show: false,
    axisBorder: {
      show: false
     },
     axisTicks: {
      show: false
     }
  },
  grid: {
    row: {
      colors: ['var(--light-background)', 'var(--white)'],
      opacity: 1
    },
  },
  stroke: {
    width: 2,
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
  responsive: [
    {
    breakpoint: 1661,
    options:{
      chart: {
        height: 295,
      }
    }
  },
  {
    breakpoint: 1200,
    options:{
      chart: {
        height: 370,
      }
    }
  },
  {
    breakpoint: 575,
    options:{
      chart: {
        height: 300,
      }
    }
  },
  ] 
  };

  var upcomingchart = new ApexCharts(document.querySelector("#upcomingchart"), upcomingoptions);
  upcomingchart.render();


  // lesson charts
  function lessonCommonOption(data) {
  return {
      series: data.lessonYseries,
      chart: {
        type: 'donut',
        height: 80,
      },
      colors: data.color,
      legend: {
          show: false
      },
      stroke: {
        width: 1,
        colors: "var(--white)"
      },
      dataLabels: {
        enabled: false
      },
      tooltip: {
        enabled: false
      },
      plotOptions: {
          pie: {
            donut: {
              labels: {
                show: true,
                value: {
                  fontSize: '11px',
                  fontFamily: 'Rubik, sans-serif',
                  fontWeight: 400,
                  color: 'var(--chart-text-color)',
                  offsetY: -12,
                  formatter: function (val) {
                    return val
                  }
                },
                total: {
                  show: true,
                  showAlways: false,
                  label: 'Total',
                  fontSize: '11px',
                  fontFamily: 'Rubik, sans-serif',
                }
              }
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
      }
  };
}


const lesson1 = {
  color: ["var(--theme-deafult)", "var(--chart-progress-light)", "var(--chart-progress-light)", "var(--chart-progress-light)","var(--chart-progress-light)","var(--chart-progress-light)", "var(--chart-progress-light)"],
  lessonYseries: [20, 5, 5, 5, 5,5,5],
};



const lessonactivechart1 = document.querySelector('#lessonChart1');
if (lessonactivechart1) {
  var lessonChart1 = new ApexCharts(lessonactivechart1, lessonCommonOption(lesson1));
  lessonChart1.render();
}

// lesson vue data
const lesson2 = {
  color: ["var(--theme-deafult)", "var(--chart-progress-light)", "var(--chart-progress-light)", "var(--chart-progress-light)"],
  lessonYseries: [50, 10, 10,10],
};

const lessonactivechart2 = document.querySelector('#lessonChart2');
if (lessonactivechart2) {
  var lessonChart2 = new ApexCharts(lessonactivechart2, lessonCommonOption(lesson2));
  lessonChart2.render();
}


// lesson bootstrap data
const lesson3 = {
  color: ["var(--theme-deafult)", "var(--chart-progress-light)", "var(--chart-progress-light)", "var(--chart-progress-light)","var(--chart-progress-light)","var(--chart-progress-light)", "var(--chart-progress-light)", "var(--chart-progress-light)", "var(--chart-progress-light)","var(--chart-progress-light)"],
  lessonYseries: [1, 1, 1,1,1, 1, 1,1,1,1],
};

const lessonactivechart3 = document.querySelector('#lessonChart3');
if (lessonactivechart3) {
  var lessonChart3 = new ApexCharts(lessonactivechart3, lessonCommonOption(lesson3));
  lessonChart3.render();
}