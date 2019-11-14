$(document).ready(function () {

  $.get("/acc/transactions/report/expend", function (data) {
    
    var ctx = document.getElementById('expendpiechart');

    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
          labels: data[0],
          datasets: [{
              label: '# of Votes',
              data: data[1],
              backgroundColor: data[2],
          }]
      },
      options: {
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
              //get the concerned dataset
              var dataset = data.datasets[tooltipItem.datasetIndex];
              //calculate the total of this data set
              var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                return previousValue + currentValue;
              });
              //get the current items value
              var currentValue = dataset.data[tooltipItem.index];
              //calculate the precentage based on the total and current item, also this does a rough rounding to give a whole number
              var percentage = Math.round(((currentValue/total) * 100));

              return currentValue + " " + "lakh" + "  " + "(" + percentage + "%" + ")";
            }
          }
        },
        responsive: true,
        layout: {
            padding: {
                left: 0,
                right: 40,
                top: 0,
                bottom: 0
            }
        },
        legend: {
          position: 'top',
        }
      }
    });    
  });  
});





