var dataIn = [0,0,0,0,0,0,0,0,0,0,0,0];
var dataOut = [0,0,0,0,0,0,0,0,0,0,0,0];
var dataProfit = [0,0,0,0,0,0,0,0,0,0,0,0];

var barData = {
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
  datasets: [{
    label: 'Expense',
    data: dataOut,
    backgroundColor: 'rgba(255, 99, 132, 0.2)',
    borderColor: 'rgba(255, 99, 132, 1)',
    borderWidth: 1,
    fill: false
  },
  {
    label: 'Income',
    data: dataIn,
    backgroundColor: 'rgba(74, 242, 161, 0.2)',
    borderColor: 'rgba(74, 242, 161)',
    borderWidth: 1,
    fill: false
  },
  {
    label: 'Profit',
    data: dataProfit,
    backgroundColor: 'rgba(30, 46, 166, 0.2)',
    borderColor: 'rgba(30, 46, 166)',
    borderWidth: 1,
    fill: false
  }
  ]
};

$(document).ready(function () {

  var ctx = document.getElementById('monthbyyear');
  window.myBar = new Chart(ctx, {
    type: 'line',
    data: barData,
    options: {
      responsive: true,
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Per Lakhs'
      }
    }
  });

  loadData();

  $("#dyears").on('change', function() {
    loadData();
  });
});


function loadData() {
  year = $("#dyears").val();
  indata = [];
  outdata = [];
  $.get("/acc/transactions/report/" + year + "/in", function (data) {
    indata = data;
    $.get("/acc/transactions/report/" + year + "/out", function (data) {
      outdata = data;
      loadGraph(indata,outdata);
    });
  });
}


function loadGraph(indata,outdata) {
  
   for (let index = 0; index < indata.length; index++) {
     const element = indata[index];
     barData.datasets[1].data[element.month-1] = element.count/100000;
   }

   for (let index = 0; index < outdata.length; index++) {
    const element = outdata[index];
    barData.datasets[0].data[element.month-1] = element.count/100000;
  }

  dataProfit = dataIn.map(function(item, index) {
    // In this case item correspond to currentValue of array a, 
    // using index to get value from array b
    return item - dataOut[index];
  });

  barData.datasets[2].data = dataProfit;
  
  window.myBar.update();



}
