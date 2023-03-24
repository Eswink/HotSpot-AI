var options = {
  chart: {
      height: 315,
      type: 'area',
      zoom: {
          enabled: false
      },
      toolbar:{
        show: false
      }
  },
  dataLabels: {
      enabled: false
  },
  stroke: {
      curve: 'straight'
  },
  series: [{
      name: "STOCK ABC",
      data: series.monthDataSeries1.prices
  }],
  // title: {
  //     text: 'Fundamental Analysis of Stocks',
  //     align: 'left'
  // },
  subtitle: {
      text: '创作力曲线',
      align: 'center'
  },
  labels: series.monthDataSeries1.dates,
  xaxis: {
      type: 'datetime',
  },
  yaxis: {
      opposite: true
  },
  legend: {
      horizontalAlign: 'left'
  },
  colors:[ CubaAdminConfig.primary ]

}

var chart = new ApexCharts(
  document.querySelector("#basic-apex"),
  options
);

chart.render();