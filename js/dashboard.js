(function ($) {
  "use strict";
  $(function () {
    if ($("#orders-chart").length) {
      var currentChartCanvas = $("#orders-chart").get(0).getContext("2d");
      var labels = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ];
      $.ajax({
        type: "get",
        url: "server/col-exp.php",
        dataType: "json",
        success: function (response) {
          var currentChart = new Chart(currentChartCanvas, {
            type: "bar",
            data: {
              labels: labels,
              datasets: [
                {
                  label: "Collected",
                  data: response.collected,
                  backgroundColor: "#392c70",
                },
                {
                  label: "Expected",
                  data: response.expected,
                  backgroundColor: "#d1cede",
                },
              ],
            },
            options: {
              responsive: true,
              maintainAspectRatio: true,
              layout: {
                padding: {
                  left: 0,
                  right: 0,
                  top: 20,
                  bottom: 0,
                },
              },
              scales: {
                yAxes: [
                  {
                    gridLines: {
                      drawBorder: false,
                    },
                    ticks: {
                      stepSize: 25000,
                      fontColor: "#686868",
                    },
                  },
                ],
                xAxes: [
                  {
                    stacked: true,
                    ticks: {
                      beginAtZero: true,
                      fontColor: "#686868",
                    },
                    gridLines: {
                      display: false,
                    },
                    barPercentage: 0.4,
                  },
                ],
              },
              legend: {
                display: false,
              },
              elements: {
                point: {
                  radius: 0,
                },
              },
              legendCallback: function (chart) {
                var text = [];
                text.push('<ul class="legend' + chart.id + '">');
                for (var i = 0; i < chart.data.datasets.length; i++) {
                  text.push(
                    '<li><span class="legend-label" style="background-color:' +
                      chart.data.datasets[i].backgroundColor +
                      '"></span>'
                  );
                  if (chart.data.datasets[i].label) {
                    text.push(chart.data.datasets[i].label);
                  }
                  text.push("</li>");
                }
                text.push("</ul>");
                return text.join("");
              },
            },
          });
          document.getElementById("orders-chart-legend").innerHTML =
            currentChart.generateLegend();
        },
      });
    }

    //super admin
    if ($("#orders-chart2").length) {
      $.ajax({
        type: "get",
        url: "../server/col_exp_per_rental.php",
        dataType: "json",
        success: function (response) {
          var rentals = response.rentals;
          var collected = response.collected;
          var expected = response.expected;
          // Recreate arrays using for loop
          var recreatedRentals = [];
          var recreatedCollected = [];
          var recreatedExpected = [];

          for (var i = 0; i < rentals.length; i++) {
            recreatedRentals.push(rentals[i]);
          }

          for (var j = 0; j < collected.length; j++) {
            recreatedCollected.push(collected[j]);
          }

          for (var k = 0; k < expected.length; k++) {
            recreatedExpected.push(expected[k]);
          }

          var currentChartCanvas = $("#orders-chart2").get(0).getContext("2d");
          var currentChart = new Chart(currentChartCanvas, {
            type: "bar",
            data: {
              labels: recreatedRentals,
              datasets: [
                {
                  label: "Collected",
                  data: recreatedCollected,
                  backgroundColor: "#392c70",
                },
                {
                  label: "Expected",
                  data: recreatedExpected,
                  backgroundColor: "#d1cede",
                },
              ],
            },
            options: {
              responsive: true,
              maintainAspectRatio: true,
              layout: {
                padding: {
                  left: 0,
                  right: 0,
                  top: 20,
                  bottom: 0,
                },
              },
              scales: {
                yAxes: [
                  {
                    gridLines: {
                      drawBorder: false,
                    },
                    ticks: {
                      stepSize: 25000,
                      fontColor: "#686868",
                    },
                  },
                ],
                xAxes: [
                  {
                    stacked: true,
                    ticks: {
                      beginAtZero: true,
                      fontColor: "#686868",
                    },
                    gridLines: {
                      display: false,
                    },
                    barPercentage: 0.4,
                  },
                ],
              },
              legend: {
                display: false,
              },
              elements: {
                point: {
                  radius: 0,
                },
              },
              legendCallback: function (chart) {
                var text = [];
                text.push('<ul class="legend' + chart.id + '">');
                for (var i = 0; i < chart.data.datasets.length; i++) {
                  text.push(
                    '<li><span class="legend-label" style="background-color:' +
                      chart.data.datasets[i].backgroundColor +
                      '"></span>'
                  );
                  if (chart.data.datasets[i].label) {
                    text.push(chart.data.datasets[i].label);
                  }
                  text.push("</li>");
                }
                text.push("</ul>");
                return text.join("");
              },
            },
          });
          document.getElementById("orders-chart-legend2").innerHTML =
            currentChart.generateLegend();
        }
      });
    }

    //super admin
    if ($("#sales-chart2").length) {
      $.ajax({
        type: "get",
        url: "../server/annual_profit.php",
        dataType: "json",
        success: function (response) {
          var lineChartCanvas = $("#sales-chart2").get(0).getContext("2d");
          var data = {
            labels: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
            datasets: [
              {
                label: "Profit",
                data: response.profit,
                borderColor: ["#392c70"],
                borderWidth: 3,
                fill: false,
              },
              {
                label: "Collected",
                data: response.collected,
                borderColor: ["#d1cede"],
                borderWidth: 3,
                fill: false,
              },
            ],
          };
          var options = {
            scales: {
              yAxes: [
                {
                  gridLines: {
                    drawBorder: false,
                  },
                  ticks: {
                    stepSize: 25000,
                    fontColor: "#686868",
                  },
                },
              ],
              xAxes: [
                {
                  display: false,
                  gridLines: {
                    drawBorder: false,
                  },
                },
              ],
            },
            legend: {
              display: false,
            },
            elements: {
              point: {
                radius: 3,
              },
            },
            stepsize: 1,
          };
          var lineChart = new Chart(lineChartCanvas, {
            type: "line",
            data: data,
            options: options,
          });
        }
      });
    }

    if ($("#sales-chart").length) {
      var lineChartCanvas = $("#sales-chart").get(0).getContext("2d");
      var labels = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ];
      $.ajax({
        type: "get",
        url: "server/profit.php",
        dataType: "json",
        success: function (response) {
          var data = {
            labels: labels,
            datasets: [
              {
                label: "Profit",
                data: response.profit,
                borderColor: ["#392c70"],
                borderWidth: 3,
                fill: false,
              },
              {
                label: "Collected",
                data: response.collected,
                borderColor: ["#d1cede"],
                borderWidth: 3,
                fill: false,
              },
            ],
          };
          var options = {
            scales: {
              yAxes: [
                {
                  gridLines: {
                    drawBorder: false,
                  },
                  ticks: {
                    stepSize: 25000,
                    fontColor: "#686868",
                  },
                },
              ],
              xAxes: [
                {
                  display: false,
                  gridLines: {
                    drawBorder: false,
                  },
                },
              ],
            },
            legend: {
              display: false,
            },
            elements: {
              point: {
                radius: 3,
              },
            },
            stepsize: 1,
          };
          var lineChart = new Chart(lineChartCanvas, {
            type: "line",
            data: data,
            options: options,
          });
        }
      });
    }
    if ($("#sales-status-chart").length) {
      var pieChartCanvas = $("#sales-status-chart").get(0).getContext("2d");
      $.ajax({
        type: "get",
        url: "server/tenants-stats.php",
        dataType: "json",
        success: function (response) {
          var pieChart = new Chart(pieChartCanvas, {
            type: "pie",
            data: {
              datasets: [
                {
                  data: response,
                  backgroundColor: ["#392c70", "#04b76b", "#eeeeee", "#ff5e6d"],
                  borderColor: ["#392c70", "#04b76b", "#eeeeee", "#ff5e6d"],
                },
              ],

              // These labels appear in the legend and in the tooltips when hovering different arcs
              labels: [
                "Tenants without balance",
                "Tenants with balance",
                "Recent tenants",
                "Fined tenants",
              ],
            },
            options: {
              responsive: true,
              animation: {
                animateScale: true,
                animateRotate: true,
              },
              legend: {
                display: false,
              },
              legendCallback: function (chart) {
                var text = [];
                text.push('<ul class="legend' + chart.id + '">');
                for (var i = 0; i < chart.data.datasets[0].data.length; i++) {
                  text.push(
                    '<li><span class="legend-label" style="background-color:' +
                      chart.data.datasets[0].backgroundColor[i] +
                      '"></span>'
                  );
                  if (chart.data.labels[i]) {
                    text.push(chart.data.labels[i]);
                  }
                  text.push(
                    '<label class="badge badge-light badge-pill legend-percentage ml-auto">' +
                      chart.data.datasets[0].data[i] +
                      "%</label>"
                  );
                  text.push("</li>");
                }
                text.push("</ul>");
                return text.join("");
              },
            },
          });
          document.getElementById("sales-status-chart-legend").innerHTML =
            pieChart.generateLegend();
        },
      });
    }
    if ($("#daily-sales-chart").length) {
      $.ajax({
        type: "get",
        url: "server/houses-stats.php",
        dataType: "json",
        success: function (response) {
          var dailySalesChartData = {
            datasets: [
              {
                data: response,
                backgroundColor: ["#392c70", "#04b76b", "#ff5e6d"],
                borderWidth: 0,
              },
            ],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: ["Occupied houses", "Vacant houses", "Faulty houses"],
          };
          var dailySalesChartOptions = {
            responsive: true,
            maintainAspectRatio: true,
            animation: {
              animateScale: true,
              animateRotate: true,
            },
            legend: {
              display: false,
            },
            legendCallback: function (chart) {
              var text = [];
              text.push('<ul class="legend' + chart.id + '">');
              for (var i = 0; i < chart.data.datasets[0].data.length; i++) {
                text.push(
                  '<li><span class="legend-label" style="background-color:' +
                    chart.data.datasets[0].backgroundColor[i] +
                    '"></span>'
                );
                if (chart.data.labels[i]) {
                  text.push(chart.data.labels[i]);
                }
                text.push("</li>");
              }
              text.push("</ul>");
              return text.join("");
            },
            cutoutPercentage: 70,
          };
          var dailySalesChartCanvas = $("#daily-sales-chart")
            .get(0)
            .getContext("2d");
          var dailySalesChart = new Chart(dailySalesChartCanvas, {
            type: "doughnut",
            data: dailySalesChartData,
            options: dailySalesChartOptions,
          });
          document.getElementById("daily-sales-chart-legend").innerHTML =
            dailySalesChart.generateLegend();
        }
      });
    }
    if ($("#inline-datepicker-example").length) {
      $("#inline-datepicker-example").datepicker({
        enableOnReadonly: true,
        todayHighlight: true,
      });
    }
  });
})(jQuery);
