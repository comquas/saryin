var dataIn = [0,0,0,0,0,0,0,0,0,0,0,0];
var dataOut = [0,0,0,0,0,0,0,0,0,0,0,0];
var dataProfit = [0,0,0,0,0,0,0,0,0,0,0,0];
var totalIn = 0;
var totalOut = 0;
var totalProfit = 0;
var barData = {
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
  datasets: [{
    label: 'Expense',
    data: dataOut,
    backgroundColor: 'rgba(255, 99, 132, 0.8)',
    borderColor: 'rgba(255, 99, 132, 1)',
    borderWidth: 1,
    fill: true
  },
  {
    label: 'Income',
    data: dataIn,
    backgroundColor: 'rgba(74, 242, 161, 0.8)',
    borderColor: 'rgba(74, 242, 161)',
    borderWidth: 1,
    fill: true
  },
  {
    label: 'Profit',
    data: dataProfit,
    backgroundColor: 'rgba(30, 46, 166, 0.8)',
    borderColor: 'rgba(30, 46, 166)',
    borderWidth: 1,
    fill: false,
    type: 'line'
  }
  ]
};

$(document).ready(function () {

  var ctx = document.getElementById('monthbyyear');
  window.myBar = new Chart(ctx, {
    type: 'bar',
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
  
    barData.datasets[1].data = [0,0,0,0,0,0,0,0,0,0,0,0];
    barData.datasets[0].data = [0,0,0,0,0,0,0,0,0,0,0,0];
    barData.datasets[2].data = [0,0,0,0,0,0,0,0,0,0,0,0];

    dataIn = [0,0,0,0,0,0,0,0,0,0,0,0];
    dataOut = [0,0,0,0,0,0,0,0,0,0,0,0];


    totalIn = 0;
    totalOut = 0;
    totalProfit = 0;
   for (let index = 0; index < indata.length; index++) {
     const element = indata[index];
     barData.datasets[1].data[element.month-1] = element.count/100000;
     dataIn[element.month-1] = element.count/100000;
     totalIn = totalIn + element.count/100000;
   }

   for (let index = 0; index < outdata.length; index++) {
    const element = outdata[index];
    barData.datasets[0].data[element.month-1] = element.count/100000;
    dataOut[element.month-1] = element.count/100000;
    totalOut = totalOut + element.count/100000;
  }

  dataProfit = dataIn.map(function(item, index) {
    // In this case item correspond to currentValue of array a, 
    // using index to get value from array b
    return item - dataOut[index];
  });

  totalProfit = totalIn - totalOut;

  barData.datasets[2].data = dataProfit;
  
  window.myBar.update();

  document.getElementById("inlahk").innerHTML = "Total Income<br/>" + totalIn.toFixed(2) + " lakh";
  document.getElementById("outlahk").innerHTML = "Total Expense<br/>" + totalOut.toFixed(2) + " lakh";
  document.getElementById("profitlahk").innerHTML = "Total Profit<br/>" + totalProfit.toFixed(2) + " lakh";
  

}
