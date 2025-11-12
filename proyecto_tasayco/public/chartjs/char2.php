<canvas id="myBarChart"></canvas>
<script>
    let ctx2 = document.getElementById("myBarChart");
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
              maxTicksLimit: 6
            },
            grid: {
              display: false
            }
          },
          y: {
            min: 0,
            max: 20,
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