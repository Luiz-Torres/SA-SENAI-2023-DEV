<main role="main">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group mr-2">
        <button class="btn btn-sm btn-outline-secondary">Compartilhar</button>
        <button class="btn btn-sm btn-outline-secondary">Exportar</button>
      </div>
      <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
        <span data-feather="calendar"></span>
        Esta semana
      </button>
    </div>
  </div>

  <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

  <h2>Título da seção</h2>
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Cabeçalho</th>
          <th>Cabeçalho</th>
          <th>Cabeçalho</th>
          <th>Cabeçalho</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1,001</td>
          <td>Lorem</td>
          <td>ipsum</td>
          <td>dolor</td>
          <td>sit</td>
        </tr>
        <tr>
          <td>1,002</td>
          <td>amet</td>
          <td>consectetur</td>
          <td>adipiscing</td>
          <td>elit</td>
        </tr>
        <tr>
          <td>1,003</td>
          <td>Integer</td>
          <td>nec</td>
          <td>odio</td>
          <td>Praesent</td>
        </tr>
      </tbody>
    </table>
  </div>
</main>

      <!-- Gráficos -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script>
  var ctx = document.getElementById("myChart");
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
      datasets: [{
        data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
        lineTension: 0,
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        borderWidth: 4,
        pointBackgroundColor: '#007bff'
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: false
          }
        }]
      },
      legend: {
        display: false,
      }
    }
  });
</script>