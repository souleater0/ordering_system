<div class="body-wrapper-inner">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-4">
        <!-- card -->
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center gap-6 mb-4 pb-3">
              <span class="round-48 d-flex align-items-center justify-content-center rounded bg-secondary-subtle">
                <iconify-icon icon="mdi:cart" class="fs-6 text-primary"> </iconify-icon>
              </span>
              <h6 class="mb-0 fs-4 text-uppercase">total customers</h6>
            </div>
            <div class="row">
              <div class="col-12">
                <h4>225</h4>
              </div>
            </div>
          </div>
        </div>
        <!-- card-end -->
      </div>
      <div class="col-lg-4">
        <!-- card -->
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center gap-6 mb-4 pb-3">
              <span class="round-48 d-flex align-items-center justify-content-center rounded bg-secondary-subtle">
                <iconify-icon icon="vaadin:stock" class="fs-6 text-primary"> </iconify-icon>
              </span>
              <h6 class="mb-0 fs-4 text-uppercase">total order</h6>
            </div>
            <div class="row">
              <div class="col-12">
                <h4>5</h4>
              </div>
            </div>
          </div>
        </div>
        <!-- card-end -->
      </div>
      <div class="col-lg-4">
        <!-- card -->
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center gap-6 mb-4 pb-3">
              <span class="round-48 d-flex align-items-center justify-content-center rounded bg-secondary-subtle">
                <iconify-icon icon="healthicons:rdt-result-out-stock" class="fs-6 text-primary"> </iconify-icon>
              </span>
              <h6 class="mb-0 fs-4 text-uppercase">total cancel</h6>
            </div>
            <div class="row">
              <div class="col-12">
                <h4>10</h4>
              </div>
            </div>
          </div>
        </div>
        <!-- card-end -->
      </div>
    </div>
  </div>
</div>
<script>
  var colors = ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#00D9E9', '#FF66C3', '#FFD466'];
  var options = {
    series: [{
      name: 'Product',
      data: [225, 50, 10, 30]
    }],
    chart: {
      height: 350,
      type: 'bar',
      events: {
        click: function(chart, w, e) {
          // console.log(chart, w, e)
        }
      }
    },
    colors: colors,
    plotOptions: {
      bar: {
        columnWidth: '45%',
        distributed: true,
      }
    },
    dataLabels: {
      enabled: false
    },
    legend: {
      show: false
    },
    xaxis: {
      categories: [
        'Snack Bar',
        'EC Cafe',
        'Marketing',
        'Eskina'
      ],
      labels: {
        style: {
          colors: colors,
          fontSize: '12px'
        }
      }
    }
  };

  var chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render();
</script>
<?php
?>