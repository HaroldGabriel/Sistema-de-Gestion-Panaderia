<canvas id="BarChartVentas"></canvas>
<script>
    let ctx2 = document.getElementById("BarChartVentas");
    const myBarChart = new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
          label: "Revenue",
          backgroundColor: "rgba(2,117,216,1)",
          borderColor: "rgba(2,117,216,1)",
          borderWidth: 1,
          data: <?php echo json_encode($valores); ?>,
        }],
      },
      options: {
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          x: {
            ticks: {              
              maxTicksLimit: 5
            },
            grid: {
              display: false
            }
          },
          y: {
            min: 0,
            max: <?php echo json_encode($max); ?>,
            ticks: {
              maxTicksLimit: 5
            },
            grid: {
              display: true
            }
          }
        }
      }
    });
</script>