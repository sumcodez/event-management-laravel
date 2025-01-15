<footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://www.bitpastel.com">bitpastel.com</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      {{-- <b>Version</b> --}}
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset ('adminLTE/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset ('adminLTE/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset ('adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset ('adminLTE/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset ('adminLTE/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset ('adminLTE/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset ('adminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset ('adminLTE/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset ('adminLTE/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset ('adminLTE/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset ('adminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset ('adminLTE/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset ('adminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset ('adminLTE/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ asset ('adminLTE/dist/js/demo.js') }}"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset ('adminLTE/dist/js/pages/dashboard.js') }}"></script>


<!-- DataTables  & Plugins -->
<script src="{{ asset ('adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset ('adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset ('adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset ('adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset ('adminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset ('adminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset ('adminLTE/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset ('adminLTE/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset ('adminLTE/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset ('adminLTE/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset ('adminLTE/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset ('adminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>



<script>
  $(document).ready(function () {
    // Fetch data from the server
    $.ajax({
      url: '/chart-data',
      method: 'GET',
      success: function (response) {
        // Extract labels and data from the response
        var labels = response.map(item => item.category);
        var data = response.map(item => item.value);

        // Create the chart
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
        var pieData = {
          labels: labels,
          datasets: [{
            data: data,
            backgroundColor: ['rgba(60,141,188,0.9)', 'rgba(210, 214, 222, 1)', 'rgba(0,192,239,1)', 'rgba(0,166,90,1)']
          }]
        };
        var pieOptions = {
          maintainAspectRatio: false,
          responsive: true
        };
        new Chart(pieChartCanvas, {
          type: 'pie',
          data: pieData,
          options: pieOptions
        });
      },
      error: function (error) {
        console.error('Error fetching chart data:', error);
      }
    });
  });
</script>

{{-- <script>
  $(document).ready(function () {
  $.ajax({
    url: '/chart-data',
    method: 'GET',
    success: function (response) {
      // Extract labels and data from the response
      var labels = response.map(item => item.category); // Categories for x-axis
      var data = response.map(item => item.value);      // Values for y-axis

      // Create the bar chart
      var barChartCanvas = $('#barChart').get(0).getContext('2d');
      var barData = {
        labels: labels,
        datasets: [{
          label: 'Dataset 1', // Change label as needed
          data: data,
          backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#3c8dbc'], // Adjust colors
          borderColor: '#000', // Optional: Border color for bars
          borderWidth: 1       // Optional: Border width for bars
        }]
      };
      var barOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true // Ensure y-axis starts at 0
          }
        }
      };
      new Chart(barChartCanvas, {
        type: 'bar', // Set chart type to 'bar'
        data: barData,
        options: barOptions
      });
    },
    error: function (error) {
      console.error('Error fetching chart data:', error);
    }
  });

})
</script> --}}
<script>
$(document).ready(function () {
  // Fetch data from /bar-chart-data
  $.ajax({
    url: '/bar-chart-data',
    method: 'GET',
    success: function (response) {
      console.log('Fetched data:', response); // Log the response to verify structure
      
      // Extract labels and datasets
      const labels = response.labels || [];
      const datasets = (response.datasets || []).map(dataset => ({
        label: dataset.label || 'Unknown',
        backgroundColor: dataset.backgroundColor || 'rgba(255,0,0,1)',
        data: dataset.data || []
      }));

      console.log('Processed labels:', labels); // Debug labels
      console.log('Processed datasets:', datasets); // Debug datasets

      // Chart data configuration
      const barData = {
        labels: labels,
        datasets: datasets
      };

      console.log("This is barData", barData);

      var barChartOptions = {
        responsive: true,                                                                                                                                                                                                                                                                                                               // Ensures the chart is responsive
        maintainAspectRatio: false,   // Allows the chart to adjust its aspect ratio based on the container size
        datasetFill: false,           // Disables filling the area beneath the bars (useful for stacked bars)
        plugins: {
          tooltip: {
            enabled: true,            // Enables tooltips
          },
          legend: {
            display: true,            // Displays the legend
            position: 'top',          // Positions the legend at the top
          }
        },
        scales: {
          x: {
            stacked: true,            // Stacks the bars on the x-axis
          },
          y: {
            stacked: true,            // Stacks the bars on the y-axis
            beginAtZero: true,        // Ensures the Y-axis starts at 0
            ticks: {
              min: 0,                 // Explicitly set the minimum value of the Y-axis to 0
              stepSize: 1,            // Optional: Sets the step size for Y-axis ticks
            }
          }
        }
      };

    //   var barChartOptions = {
    //   responsive              : true,
    //   maintainAspectRatio     : false,
    //   scales: {
    //     xAxes: [{
    //       stacked: true,
    //     }],
    //     yAxes: [{
    //       stacked: true
    //     }]
    //   }
    // }


      // Render the stacked bar chart
      const barChartCanvas = document.getElementById('stackedBarChart').getContext('2d');
      new Chart(barChartCanvas, {
        type: 'bar',
        data: barData,
        options: barChartOptions
      });
    },
    error: function (error) {
      console.error('Error fetching chart data:', error);
    }
  });
});
</script>


{{-- <script>
  $(document).ready(function () {
    // Use AJAX to fetch the data from the API
    $.ajax({
      url: '/bar-chart-data', // API endpoint
      method: 'GET',
      success: function (response) {
        // Extract labels and datasets from the API response
        const chartData = {
          labels: response.labels,
          datasets: response.datasets
        };

        // Chart configuration
        const config = {
          type: 'bar',
          data: chartData,
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'top',
              },
              title: {
                display: true,
                text: 'Bar Chart with AJAX'
              }
            },
            scales: {
              x: {
                stacked: false
              },
              y: {
                stacked: false,
                beginAtZero: true
              }
            }
          }
        };

        // Render the chart
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, config);
      },
      error: function (error) {
        console.error('Error fetching chart data:', error);
      }
    });
  });
</script> --}}

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}


{{-- <script>
  //- BAR CHART -
  var areaChartData = {
    labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [
      {
        label               : 'Dataset 1',
        backgroundColor     : 'rgba(60,141,188,0.9)',
        borderColor         : 'rgba(60,141,188,0.8)',
        pointRadius         : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : [28, 48, 40, 19, 86, 27, 90]
      },
      {
        label               : 'Dataset 2',
        backgroundColor     : 'rgba(210, 214, 222, 1)',
        borderColor         : 'rgba(210, 214, 222, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(210, 214,222,1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data                : [65, 59, 80, 81, 56, 55, 40]
      }
    ]
  }

  //- BAR CHART -
  var barChartCanvas = $('#stackedBarChart').get(0).getContext('2d') // Corrected ID
  var barChartData = $.extend(true, {}, areaChartData)
  var temp0 = areaChartData.datasets[0]
  var temp1 = areaChartData.datasets[1]
  barChartData.datasets[0] = temp1
  barChartData.datasets[1] = temp0

  var barChartOptions = {
    responsive              : true,
    maintainAspectRatio     : false,
    datasetFill             : false
  }

  new Chart(barChartCanvas, {
    type: 'bar',
    data: barChartData,
    options: barChartOptions
  })

</script> --}}



<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>


</body>
</html>