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
        responsive: true,
        layout: {
            padding: {
                left: 0,
                right: 400,
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





