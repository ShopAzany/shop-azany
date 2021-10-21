<?php
    $page_title = "Product Deals";
    $active_page = "deals";
    include("includes/header.php");
?>
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/dataTables.bootstrap4.css">



    <div class="page-content">

      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Administrators</li>
        </ol>
      </nav>

      <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
          Product deleted successfully
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      <?php } ?>

      <?php if(isset($_GET["approve"]) && $_GET["approve"] == 'success') { ?>
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
          Product successfully approved
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      <?php } ?>

      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h6 class="card-title">All Products</h6>

              <div class="table-responsive">
                <table id="" class="table"><!-- dataTableExample -->
                  <thead>
                    <tr>
                      <th></th>
                      <th>Name</th>
                      <th>Products</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Weakly Deal</td>
                      <td>23</td>
                      <td>
                        <?php if($config->week == 'Disabled') { ?>
                          <button onclick='dealOption("enabled", "week")' class="btn btn-success btn-sm">Enable</button>
                        <?php } else if($config->week == 'Enabled') { ?>
                          <button onclick='dealOption("disabled", "week")' class="btn btn-danger btn-sm">Disable</button>
                        <?php } ?>
                      </td>
                    </tr>

                    <tr>
                      <td>1</td>
                      <td>Trending Deal</td>
                      <td>23</td>
                      <td>
                        <?php if($config->trending == 'Disabled') { ?>
                          <button onclick='dealOption("enabled", "trending")' class="btn btn-success btn-sm">Enable</button>
                        <?php } else if($config->trending == 'Enabled') { ?>
                          <button onclick='dealOption("disabled", "trending")' class="btn btn-danger btn-sm">Disable</button>
                        <?php } ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>

    <?php
      include("includes/footer.php");
    ?>
  
  </div>
</div>



<!-- <div class="modal" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Warning!!!</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body text-center">
        <p>Are you sure you want to delete this product?</p>

        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>product_manager/deleteProduct">
          <input type="hidden" name="pid" id="inputId">
          <button class="btn btn-danger btn-sm mr-3" type="submit">YES</button>
          <button class="btn btn-success btn-sm ml-3" type="button" data-dismiss="modal">NO</button>
        </form>
      </div>
    </div>
  </div>
</div>
 -->


<div class="modal" id="approveModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Warning!!!</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Are you sure you want to <span id="getTheOption"></span> this deal?</p>

        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>product_manager/updateDeals">
          <input type="hidden" name="dealAction" id="dealAction">
          <input type="hidden" name="dealRole" id="dealRole">
          <button class="btn btn-success btn-sm mr-3" type="submit">YES</button>
          <button class="btn btn-danger btn-sm ml-3" type="button" data-dismiss="modal">NO</button>
        </form>
      </div>
    </div>
  </div>
</div>


  <!-- core:js -->
  <script src="<?=$this_folder?>/assets/js/core.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="<?=$this_folder?>/assets/js/jquery.dataTables.js"></script>
  <script src="<?=$this_folder?>/assets/js/dataTables.bootstrap4.js"></script>
  <!-- end plugin js for this page -->
  <!-- inject:js -->
  <script src="<?=$this_folder?>/assets/js/feather.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/template.js"></script>
  <!-- endinject -->
  <!-- custom js for this page -->
  <script src="<?=$this_folder?>/assets/js/data-table.js"></script>
  <!-- end custom js for this page -->


  <script>
    function dealOption(value, dealOpt) {
      $("#approveModal").modal();
      document.getElementById("getTheOption").innerHTML = value;
      document.getElementById("dealAction").value = value;
      document.getElementById("dealRole").value = dealOpt;
    }
  </script>
</body>
</html>