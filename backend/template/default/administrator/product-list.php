<?php
    $page_title = "All Products";
    $active_page = "pro_manager";
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

      <?php if(isset($_GET["update"]) && $_GET["update"] == 'success') { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          Product successfully updated
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
                      <th>Category</th>
                      <th>Status</th>
                      <th>Created On</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($products as $pro): ?>
                    <tr>
                      <td>
                        <img src="<?=$pro->featured_img?>">
                      </td>
                      <td><?=ucwords(substr($pro->name, 0,30))?><?php if(strlen($pro->name) > 30) { ?>...<?php } ?></td>
                      <td>
                        <?php $getCat = explode(',', $pro->category); ?>
                        <?=ucwords(Settings::onlyString($getCat[0]))?>
                      </td>
                      <td>
                        <?php if($pro->status == 'Pending') { ?>
                          <span class="badge badge-warning">Pending</span>
                        <?php } else if($pro->status == 'Active') { ?>
                          <span class="badge badge-success">Active</span>
                        <?php } else if($pro->status == 'Removed') { ?>
                          <span class="badge badge-danger">Removed</span>
                        <?php } else if($pro->status == 'Draft') { ?>
                          <span class="badge badge-primary">Draft</span>
                        <?php } ?>
                      </td>
                      <td><?=CustomDateTime::dateFrmatAlt($pro->created_at)?></td>
                      <td>
                        <?php if($pro->status !== 'Active') { ?>
                          <button class="btn btn-primary btn-sm" onclick="approveProduct(<?=$pro->pid?>)">Approve</button>
                        <?php } else { ?>
                          <button class="btn btn-success btn-sm">Approved</button>
                        <?php } ?>
                        <a class="btn btn-primary btn-sm" href="<?=Config::ADMIN_BASE_URL()?>product_manager/edit/<?=$pro->pid?>"><i class="fa fa-edit"></i></a>
                        <button class="btn btn-danger btn-sm" onclick="deletePro(<?=$pro->pid?>)"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>


            <!-- PAGINATION -->
            <div class="text-center mt-5">
                <div class="pagination-outer" aria-label="Page navigation">
                  <ul class="pagination justify-content-center">
                    <?php $prevPage =  $currPage - 1; ?>
                    <li class="page-item">
                      <?php if ($prevPage < 1) { ?>
                        <a href="javascript:()" class="pagin-disabled page-link" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                        </a>
                      <?php } else { ?>  
                        <a href="<?=Config::ADMIN_BASE_URL()?>product_manager/<?=$prevPage?>" class="page-link" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                        </a>
                      <?php } ?>                
                    </li>

                    <?php foreach ($pageLinks as $pageNum) : ?>

                      <?php if ($pageNum == $currPage) { ?>
                      <li class="page-item active"><a class="page-link" href="javascript:()"><?= $pageNum ?></a></li>
                      <?php } else { ?>
                      <li class="page-item"><a class="page-link" href="<?= Config::ADMIN_BASE_URL()?>product_manager/<?=$pageNum?>"><?= $pageNum ?></a></li>
                      <?php } ?>

                    <?php endforeach ?>  


                    <?php $nextPage =  $currPage + 1; ?>  
                    <li class="page-item">
                      <?php if ($nextPage > $totalLink) { ?>
                        <a href="javascript:()" class="pagin-disabled page-link" aria-label="Next">
                          <span aria-hidden="true">»</span>
                        </a>
                      <?php } else { ?>
                        <a href="<?=Config::ADMIN_BASE_URL()?>product_manager/<?=$nextPage?>" class="page-link" aria-label="Next">
                          <span aria-hidden="true">»</span>
                        </a>
                      <?php } ?>
                    </li>
                  </ul>
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



<div class="modal" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Warning!!!</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
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
        <p>Are you sure you want to approve this product?</p>

        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>product_manager/approve_product">
          <input type="hidden" name="pid" id="inputIdApp">
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
    function deletePro(proID) {
      console.log(proID);
      $("#deleteModal").modal();
      document.getElementById("inputId").value = proID;
    }

    function approveProduct(proIDApp) {
      $("#approveModal").modal();
      document.getElementById("inputIdApp").value = proIDApp;
    }
  </script>
</body>
</html>