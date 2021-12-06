<?php
    $page_title = "Welcome to Dashboard";
    $active_page = "dashboard";
    include("includes/header.php");
?>
<style>
  .dash-grid .icon-wrap i{
    width: 80px; 
    height: 80px; 
    border-radius: 50%; 
    background: #4250f2; 
    color: #fff; 
    font-size: 30px; 
    text-align: center; 
    padding-top: 25px;
  }
  .dash-grid .dash-content h2{
    font-size: 35px;
  }
  .dash-grid .dash-content p{
    font-size: 17px; 
    float: right;
  }
  .text_truncate {
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    display: inline-block;
  }
</style>


      <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
          <div>
            <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
          </div>
          
        </div>

        <div class="row">
          <div class="col-12 col-xl-4 stretch-card">
            <div class="card card-body p-3 dash-grid">
              <div class="d-flex justify-content-between">
                <div class="icon-wrap">
                  <i class="fa fa-users"></i>
                </div>
                <div class="dash-content">
                  <h2 class="text-muted"><?=number_format($allUser)?></h2>
                  <p class="text-muted mt-3">Total Customers</p>
                </div>
              </div>
            </div>
          </div>



          <div class="col-12 col-xl-4 stretch-card">
            <div class="card card-body p-3 dash-grid">
              <div class="d-flex justify-content-between">
                <div class="icon-wrap">
                  <i class="fa fa-users"></i>
                </div>
                <div class="dash-content">
                  <h2 class="text-muted"><?=number_format($allSeller)?></h2>
                  <p class="text-muted mt-3">Total Sellers</p>
                </div>
              </div>
            </div>
          </div>



          <div class="col-12 col-xl-4 stretch-card">
            <div class="card card-body p-3 dash-grid">
              <div class="d-flex justify-content-between">
                <div class="icon-wrap">
                  <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="dash-content">
                  <h2 class="text-muted"><?=number_format($allOrder)?></h2>
                  <p class="text-muted mt-3">Total Orders</p>
                </div>
              </div>
            </div>
          </div>


        </div> <!-- row -->



        <!-- <div class="row mt-4">
          <div class="col-lg-12 col-xl-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                  <h6 class="card-title mb-0">Monthly sales</h6>
                </div>
                <p class="text-muted mb-4">Sales are activities related to selling or the number of goods or services sold in a given time period.</p>
                <div class="monthly-sales-chart-wrapper">
                  <canvas id="monthly-sales-chart"></canvas>
                </div>
              </div> 
            </div>
          </div>
        </div> --> <!-- row -->



        <div class="row mt-5">
          <div class="col-lg-6 col-xl-5 grid-margin grid-margin-xl-0 stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                  <h6 class="card-title mb-0">Recently Added Product</h6>
                </div>

                <div class="d-flex flex-column">

                  <?php foreach ($recentAddedPro as $pro): ?>
                  <a href="#" class="d-flex align-items-center border-bottom pb-3 pt-3">
                    <div class="mr-3" style="width: 20%">
                      <img src="<?=str_replace('192.168.8.106', 'localhost', $pro->featured_img)?>" class="rounded-circle wd-35">
                    </div>
                    <div class=""style="width: 80%;">
                      <div class="d-flex justify-content-between">
                        <h6 class="text-body mb-2 text_truncate" style=""><?=$pro->name?> </h6>
                      </div>
                      <p class="text-muted tx-13"><b>Sales Price: <?=$curr->symbol?><?=number_format($pro->sales_price)?></b></p>
                      <p class="text-muted tx-13">Status: <?=$pro->status?> - Qty: <?=$pro->quantity?></p>
                    </div>
                  </a>
                  <?php endforeach ?>
                  
                </div>
              </div>
            </div>
          </div>


          <div class="col-lg-7 col-xl-7 stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                  <h6 class="card-title mb-0">Recent Orders</h6>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover mb-0">
                    <thead>
                      <tr>
                        <th class="pt-0">#</th>
                        <th class="pt-0">Product Name</th>
                        <th class="pt-0">Placed On</th>
                        <th class="pt-0">Status</th>
                        <th class="pt-0">Details</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($recentOrder as $value): $count += 1; ?>
                      <tr>
                        <td>
                          <img src="<?=str_replace('192.168.8.106', 'localhost', $value->product_json->featured_img)?>" class="rounded-circle" style="width: 50px; height: 50px; object-fit: contain;">
                        </td>
                        <td><?=substr($value->product_json->name, 0,30)?></td>
                        <td><?=CustomDateTime::dateFrmatAlt($value->created_at)?></td>
                        <td>
                          <?php if($value->status == 'Delivered') { ?>
                            <span class="badge badge-success">Delivered</span>
                          <?php } else if($value->status == 'Returned') { ?>
                            <span class="badge badge-success">Returned</span>
                          <?php }  else if($value->status == 'Pending') { ?>
                            <span class="badge badge-warning">Pending</span>
                          <?php } else { ?>
                            <span class="badge badge-info"><?=$value->status?></span>
                          <?php } ?>
                        </td>
                        <td><a href="<?=Config::ADMIN_BASE_URL()?>order_manager/order/<?=$value->order_number?>"><b>VIEW</b></a></td>
                      </tr>
                      <?php endforeach ?>
                      
                    </tbody>
                  </table>
                </div>
              </div> 
            </div>
          </div>
        </div> <!-- row -->

      </div>

      <?php 
      
        include("includes/footer.php");

      ?>
    
    </div>
  </div>

  <!-- core:js -->
  <script src="<?=$this_folder?>/assets/js/core.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="<?=$this_folder?>/assets/js/Chart.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/jquery.flot.js"></script>
  <script src="<?=$this_folder?>/assets/js/jquery.flot.resize.js"></script>
  <script src="<?=$this_folder?>/assets/js/bootstrap-datepicker.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/apexcharts.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/progressbar.min.js"></script>
  <!-- end plugin js for this page -->
  <!-- inject:js -->
  <script src="<?=$this_folder?>/assets/js/feather.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/template.js"></script>
  <!-- endinject -->
  <!-- <script>
    var chatMonths = "'May','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','May'";
  </script> -->
  <!-- custom js for this page -->

  <script src="<?=$this_folder?>/assets/js/dash.js"></script>
  <script src="<?=$this_folder?>/assets/js/datepicker.js"></script>
  <!-- end custom js for this page -->
</body>
</html>    