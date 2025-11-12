<canvas id="barChartHorizontal"></canvas>
<script>
    const ctx = document.getElementById('barChartHorizontal');

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($labels1); ?>,
        datasets: [{
          label: 'Cantidad Vendida',
          data: <?php echo json_encode($valores1, JSON_NUMERIC_CHECK); ?>,
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        indexAxis: 'y', // Esto lo hace horizontal
        responsive: true,
        scales: {
          x: {
            beginAtZero: true,
            ticks: {
              maxTicksLimit: 5 // máximo 5 ticks visibles en eje X
            }
          },
          y: {
            ticks: {
              autoSkip: true,  // permite saltarse etiquetas si son muchas
              maxTicksLimit: 5 // máximo 5 etiquetas visibles en eje Y
            }
          }
        }
      }
    });
</script>