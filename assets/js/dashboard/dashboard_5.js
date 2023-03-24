// radial chart js
function radialCommonOption(data) {
  return {
      series: data.radialYseries,
      chart: {
        height: 130,
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
                strokeWidth: '60%',
                opacity: 1,
                margin: 5,
            },
            dataLabels: {
                showOn: "always",
                value: {
                    color: "var(--body-font-color)",
                    fontSize: "14px",
                    show: true,
                    offsetY: -10,
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
  radialYseries: [78],
};

const radialchart1 = document.querySelector('#radial-facebook');
if (radialchart1) {
  var radialprogessChart1 = new ApexCharts(radialchart1, radialCommonOption(radial1));
  radialprogessChart1.render();
}

// radial 2
const radial2 = {
  color: ["#FFA941"],
  dropshadowColor:"#FFA941",
  radialYseries: [70],
};

const radialchart2 = document.querySelector('#radial-instagram');
if (radialchart2) {
  var radialprogessChart2 = new ApexCharts(radialchart2, radialCommonOption(radial2));
  radialprogessChart2.render();
}

// radial 3
const radial3 = {
  color: ["#57B9F6"],
  dropshadowColor:"#57B9F6",
  radialYseries: [50],
};

const radialchart3 = document.querySelector('#radial-twitter');
if (radialchart3) {
  var radialprogessChart3 = new ApexCharts(radialchart3, radialCommonOption(radial3));
  radialprogessChart3.render();
}

// follower gender chart
var followeroptions = {
    series: [70, 60],
    chart: {
        width: 325,
        height: 325,
        type: 'radialBar',
        dropShadow: {
          enabled: true,
          top: 5,
          left: 8,
          blur: 8,
          color: 'var(--theme-deafult)',
          opacity: 0.2
      }
    },
    plotOptions: {
        radialBar: {
            hollow: {
                margin: 5,
                size: '70%',
                image: '../assets/images/dashboard-5/follower.png',
                imageWidth: 50,
                imageHeight: 50,
                imageClipped: false,
            },
             track: {
              background: 'transparent',
             }
        }
    },
    colors: [ "var(--theme-deafult)", "#FFA941"],
    labels: ['Male', 'Female'],
    stroke: {
        lineCap: 'round'
    },
    legend: {
        show: true,
        position: "right",
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
        },
    },
    responsive: [
      {
        breakpoint: 718,
        options:{
           chart: {
              width: "100%",
              height: 230,
           },
           legend: {
              show: false,
           }
        }
      },
    ] 
};

var followerchart = new ApexCharts(document.querySelector("#followerchart"), followeroptions);
followerchart.render();

// intagram subscriber chart
var optionssubscriber = {
    series: [{
            name: 'growth',
            type: 'line',
            data: [12, 10, 25, 12, 30, 10, 55, 45, 60]
        },
        {
            name: 'growth',
            type: 'line',
            data: [10, 15, 20, 18, 38, 25, 55, 35,60]
        }
    ],
    chart: {
        height: 265,
        type: 'line',
        toolbar: {
            show: false
        },
         dropShadow: {
            enabled: true,
            top: 8,
            left: 0,
            blur: 2,
            color: ["#FFA941","#7366FF"],
            opacity: 0.1
        }
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
    colors: ["#FFA941","#7366FF"],
    stroke: {
        width: 2,
        curve: 'smooth',
        opacity: 1,
    },
    markers: {
      discrete: [{
          seriesIndex: 1,
          dataPointIndex: 4,
          fillColor: '#7064F5',
          strokeColor: 'var(--white)',
          size: 6,
        }
      ],
    },
    tooltip: {
        shared: false,
        intersect: false,
        marker: {
          width: 5,
          height: 5,
        },
    },
    xaxis: {
        type: 'category',
        categories: ['Sep 5', 'Sep 8', 'Sep 12', 'Sep 16', 'Sep 18', 'Sep 17', 'Sep 23', 'Sep 26', 'Sep 30'],
        tickAmount: 12,
        crosshairs: {
          show: false,
        },
        labels: {
            style: {
              colors: "var(--chart-text-color)",
              fontSize: '12px',
              fontFamily: 'Rubik, sans-serif',
              fontWeight: 400,
            }
        },
        axisTicks: {
            show: false
        },
        axisBorder: {
          show: false
        },
        tooltip: {
            enabled: false
        }
    },
    fill: {
        opacity: 1,
        type: 'gradient',
        gradient: {
          shade: 'light',
          type: "horizontal",
          shadeIntensity: 1,
          opacityFrom: 0.95,
          opacityTo: 1,
          stops: [0, 90,100]
        }
    },
    yaxis: {
        min: 10,
        max: 60,
        tickAmount: 5,
        labels: {
            style: {
              colors: "var(--chart-text-color)",
              fontSize: '12px',
              fontFamily: 'Rubik, sans-serif',
              fontWeight: 400,
            }
        },
    },
    legend: {
        show: false
    },
    responsive: [
       {
        breakpoint: 1694,
        options:{
           chart: {
              height: 240,
           }
        }
      },
      {
        breakpoint: 1661,
        options:{
           chart: {
              height: 265,
           }
        }
      },
      {
        breakpoint: 1412,
        options:{
           chart: {
              height: 240,
           }
        }
      },
      {
        breakpoint: 1200,
        options:{
           chart: {
              height: 260,
           }
        }
      },
      {
        breakpoint: 1040,
        options:{
           chart: {
              height: 240,
           }
        }
      },
      {
        breakpoint: 992,
        options:{
           chart: {
              height: 255,
           }
        }
      },
    ]
};

var subscriberchart = new ApexCharts(document.querySelector("#subscriber-chart"), optionssubscriber);
subscriberchart.render();

// click chart
var optionsphotoclick = {
      series: [{
        name: "photo",
        data: [10, 12, 41, 36, 60, 58],
      }],
      chart: {
            width: 125,
            height: 150,
            type: 'line',
            zoom: {
              enabled: false
            },
            toolbar: {
              show: false
            },
            dropShadow: {
              enabled: true,
              top: 8,
              left: 0,
              blur: 3,
              color: "#54BA4A",
              opacity: 0.2
            }
      },
    markers: {
      hover: {
        size: 3,
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 2,
    },
    grid: {
      show: false,
    },
    tooltip: {
      x: {
          show: false,
      },
      z: {
        show: false
      }
    },
    annotations: {
      points: [{
        x: 90,
        y: 58,
        marker: {
          size: 4,
          fillColor: '#54BA4A',
          strokeColor: 'var(--white)',
          radius: 2,
        },
      }]
    },
    colors: ["#54BA4A"],
    fill: {
          opacity: 1,
          type: 'gradient',
          gradient: {
            shade: 'light',
            type: "vertical",
            shadeIntensity: 1,
            opacityFrom: 0.95,
            opacityTo: 1,
            // stops: [0,100]
            colorStops: [
                {
                  offset: 0,
                  color: "#54BA4A",
                  opacity: 0.1
                },
                {
                  offset: 30,
                  color: "#54BA4A",
                  opacity: 0.8
                },
                 {
                  offset: 80,
                  color: "#54BA4A",
                  opacity: 1
                },
                {
                  offset: 100,
                  color: "#54BA4A",
                  opacity: 0.1
                },
            ]
          },
        },
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      labels: {
            show: false
          },
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          tooltip: {
            enabled: false
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
    responsive: [
      {
        breakpoint: 1694,
        options:{
            chart: {
              width: 100,
            },
            annotations: {
              points: [{
                x: 75,
                y: 58,
                marker: {
                  size: 4,
                  fillColor: '#54BA4A',
                  strokeColor: 'var(--white)',
                  radius: 2,
                },
              }]
            },
        }
      },
      {
        breakpoint: 1661,
        options:{
            chart: {
              width: 120,
            },
            annotations: {
              points: [{
                x: 90,
                y: 58,
                marker: {
                  size: 4,
                  fillColor: '#54BA4A',
                  strokeColor: 'var(--white)',
                  radius: 2,
                },
              }]
            },
        }
      },
      {
        breakpoint: 1378,
        options:{
            chart: {
              width: 100,
            },
            annotations: {
              points: [{
                x: 75,
                y: 58,
                marker: {
                  size: 4,
                  fillColor: '#54BA4A',
                  strokeColor: 'var(--white)',
                  radius: 2,
                },
              }]
            },
        }
      },
      {
        breakpoint: 1288,
        options:{
            chart: {
              width: 80,
            },
            annotations: {
              points: [{
                x: 50,
                y: 58,
                marker: {
                  size: 4,
                  fillColor: '#54BA4A',
                  strokeColor: 'var(--white)',
                  radius: 2,
                },
              }]
            },
        }
      },
      {
        breakpoint: 1200,
        options:{
            chart: {
              width: 110,
            },
            annotations: {
              points: [{
                x: 85,
                y: 58,
                marker: {
                  size: 4,
                  fillColor: '#54BA4A',
                  strokeColor: 'var(--white)',
                  radius: 2,
                },
              }]
            },
        }
      },
    ]
};

var photochart = new ApexCharts(document.querySelector("#photo-click"), optionsphotoclick);
photochart.render();

// link chart
var optionslinkclick = {
      series: [{
        name: "photo",
        data: [10, 12, 41, 36, 60, 58],
      }],
      chart: {
            width: 125,
            height: 150,
            type: 'line',
            zoom: {
              enabled: false
            },
            toolbar: {
              show: false
            },
            dropShadow: {
              enabled: true,
              top: 8,
              left: 0,
              blur: 3,
              color: "var(--theme-secondary)",
              opacity: 0.2
            }
      },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 2,
    },
    grid: {
      show: false,
    },
    tooltip: {
      x: {
          show: false,
      },
      z: {
        show: false
      }
    },
    colors: ["var(--theme-secondary)"],
    annotations: {
      points: [{
        x: 90,
        y: 58,
        marker: {
          size: 4,
          fillColor: 'var(--theme-secondary)',
          strokeColor: 'var(--white)',
          radius: 2,
        },
      }]
    },
    fill: {
          opacity: 1,
          type: 'gradient',
          gradient: {
            shade: 'light',
            type: "vertical",
            shadeIntensity: 1,
            opacityFrom: 0.95,
            opacityTo: 1,
            // stops: [0,100]
            colorStops: [
                {
                  offset: 0,
                  color: "var(--theme-secondary)",
                  opacity: 0.1
                },
                {
                  offset: 30,
                  color: "var(--theme-secondary)",
                  opacity: 0.8
                },
                 {
                  offset: 80,
                  color: "var(--theme-secondary)",
                  opacity: 1
                },
                {
                  offset: 100,
                  color: "var(--theme-secondary)",
                  opacity: 0.1
                },
            ]
          },
        },
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      labels: {
            show: false
          },
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          tooltip: {
            enabled: false
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
      responsive: [
      {
        breakpoint: 1694,
        options:{
            chart: {
              width: 100,
            },
            annotations: {
              points: [{
                x: 75,
                y: 58,
                marker: {
                  size: 4,
                  fillColor: 'var(--theme-secondary)',
                  strokeColor: 'var(--white)',
                  radius: 2,
                },
              }]
            },
        }
      },
      {
        breakpoint: 1661,
        options:{
            chart: {
              width: 120,
            },
            annotations: {
              points: [{
                x: 90,
                y: 58,
                marker: {
                  size: 4,
                  fillColor: 'var(--theme-secondary)',
                  strokeColor: 'var(--white)',
                  radius: 2,
                },
              }]
            },
        }
      },
      {
        breakpoint: 1378,
        options:{
            chart: {
              width: 100,
            },
            annotations: {
              points: [{
                x: 75,
                y: 58,
                marker: {
                  size: 4,
                  fillColor: 'var(--theme-secondary)',
                  strokeColor: 'var(--white)',
                  radius: 2,
                },
              }]
            },
        }
      },
       {
        breakpoint: 1288,
        options:{
            chart: {
              width: 80,
            },
            annotations: {
              points: [{
                x: 50,
                y: 58,
                marker: {
                  size: 4,
                  fillColor: 'var(--theme-secondary)',
                  strokeColor: 'var(--white)',
                  radius: 2,
                },
              }]
            },
        }
      },
      {
        breakpoint: 1200,
        options:{
            chart: {
              width: 110,
            },
            annotations: {
              points: [{
                x: 85,
                y: 58,
                marker: {
                  size: 4,
                  fillColor: 'var(--theme-secondary)',
                  strokeColor: 'var(--white)',
                  radius: 2,
                },
              }]
            },
        }
      },
    ]
};

var linkchart = new ApexCharts(document.querySelector("#link-click"), optionslinkclick);
linkchart.render();

// view chart
var optionsview = {
      series: [{
        name: "view",
        data: [20, 45, 30, 50],
      }],
      chart: {
            height: 305,
            type: 'line',
            zoom: {
              enabled: false
            },
            toolbar: {
              show: false
            },
            dropShadow: {
              enabled: true,
              top: 8,
              left: 0,
              blur: 3,
              color: "var(--theme-deafult)",
              opacity: 0.2
            }
      },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 3,
    },
  grid: {
    row: {
      colors: ['var(--view-grid-bg)', 'transparent'],
      opacity: 0.5
  }, 
  column: {
      colors: ['var(--view-grid-bg)', 'transparent'],
  }, 
  xaxis: {
    lines: {
      show: true
    }
  }
  },

    tooltip: {
      x: {
          show: false,
      },
      z: {
        show: false
      }
    },
    colors: ["var(--theme-deafult)"],
    fill: {
          opacity: 1,
          type: 'gradient',
          gradient: {
            shade: 'light',
            type: "vertical",
            shadeIntensity: 1,
            opacityFrom: 0.95,
            opacityTo: 1,
            // stops: [0,100]
            colorStops: [
                {
                  offset: 0,
                  color: "var(--theme-deafult)",
                  opacity: 0.05
                },
                {
                  offset: 30,
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
                  opacity: 0.1
                },
            ]
          },
        },
        annotations: {
          points: [{
            x: "Feb",
            y: 44,
            marker: {
              size: 15,
              fillColor: '#7366FF',
              strokeColor: 'var(--view-border-marker)',
              strokeWidth: 20,
              radius: 2,
              cssClass: 'apexcharts-custom-class'
            },
          }]
        },
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr'],
          axisBorder: {
            show: false
          },
          axisTicks: {
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
        }
    },
    responsive: [
      {
        breakpoint: 768,
        options:{
            chart: {
              height: 200,
            },
          }
      },
      {
        breakpoint: 481,
        options:{
            annotations: {
              points: [{
                x: "Feb",
                y: 44,
                marker: {
                  size: 10,
                  fillColor: '#7366FF',
                  strokeColor: '#cfcdfc',
                  strokeWidth: 7,
                  radius: 2,
                  cssClass: 'apexcharts-custom-class'
                },
              }]
            },
          }
      }
    ]
};

var viewchart = new ApexCharts(document.querySelector("#view"), optionsview);
viewchart.render();