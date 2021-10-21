<?php
    $page_title = "Seller Detail";
    $active_page = "seller";
    include("includes/header.php");
?>
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/select2.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/jquery.tagsinput.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/dropzone.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/dropify.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/bootstrap-colorpicker.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/tempusdominus-bootstrap-4.min.css">

<style>
  .def-btn{
    padding: 3px 8px;
    font-weight: lighter;
    font-size: 13px
  }
  .set-cursor{
    cursor: pointer;
  }
</style>


    <div class="page-content">

      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>seller_manager">All Sellers</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?=ucwords($seller->shop_name)?></li>
        </ol>
      </nav>

      <?php if(isset($_GET["update"]) && $_GET["update"] == 'success') { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          Seller profile successfully updated
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      <?php } ?>

      <?php if(isset($_GET["approve"]) && $_GET["approve"] == 'success') { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          Product successfully approved
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      <?php } ?>

      <?php if(isset($_GET["business-info"]) && $_GET["business-info"] == 'success') { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          Business information successfully updated
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      <?php } ?>

      <?php if(isset($_GET["bank"]) && $_GET["bank"] == 'success') { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          You have successfully updated seller bank information
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      <?php } ?>


      <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          Product successfully deleted
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      <?php } ?>

      <?php if(isset($_GET["action"]) && $_GET["action"] == $_GET["action"]) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          User has been successfully <?php echo $_GET["action"] ?>.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      <?php } ?>

      <div class="row">
        <div class="col-xl-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body p-0">

              <div class="media p-3">
                <?php if($seller->photo) { ?>
                  <img src="<?=$seller->photo?>" alt="John Doe" class="mr-3" style="width:60px; height: 60px; border: 1px solid #ccc">
                <?php } else { ?>
                  <img src="<?=$this_folder?>/assets/images/profile-default.png" alt="John Doe" class="mr-3" style="width:60px; height: 60px; border: 1px solid #ccc">
                <?php } ?>
                <div class="media-body">
                  <h5><?=ucwords($seller->first_name)?> <?=ucwords($seller->last_name)?></h5>
                  <p><?=$seller->email?></p>
                  <p>
                    <?php if($seller->status == "Blocked") { ?>

                      <button class="btn def-btn btn-secondary">Blocked</button>
                      <button class="btn def-btn outline-danger" onclick="userAction(<?=$seller->seller_id?>, 'Active', 'Unblock')">Unblock</button>
                      <button class="btn def-btn btn-danger" onclick="userAction(<?=$seller->seller_id?>, 'Delete', 'Delete')">Delete</button>

                    <?php } else if($seller->status == "Active") { ?>

                      <button class="btn def-btn btn-danger" onclick="userAction(<?=$seller->seller_id?>, 'Blocked', 'Block')">Blocked</button>
                      <button class="btn def-btn btn-warning" onclick="userAction(<?=$seller->seller_id?>, 'Suspended', 'Suspend')">Suspend</button>
                      <button class="btn def-btn btn-danger" onclick="userAction(<?=$seller->seller_id?>, 'Delete', 'Delete')">Delete</button>

                    <?php } else if($seller->status == "Suspended") { ?>

                      <button class="btn def-btn btn-secondary">Suspended</button>
                      <button class="btn def-btn outline-danger" onclick="userAction(<?=$seller->seller_id?>, 'Active', 'Unsuspend')">Unsuspend</button>
                      <button class="btn def-btn btn-danger" onclick="userAction(<?=$seller->seller_id?>, 'Delete', 'Delete')">Delete</button>

                    <?php } ?>
                  </p>
                </div>
              </div>


              <ul class="list-group list-group-flush mt-4">
                <li class="list-group-item">
                  Status:
                  <?php if($seller->status == 'Active') { ?>
                    <span class="badge badge-success" style="padding-top: 3px">Active</span>
                  <?php } else if($seller->status == 'Pending') { ?>
                    <span class="badge badge-warning" style="padding-top: 3px">Pending</span>
                  <?php } else if($seller->status == 'Blocked' || $seller->status == 'Suspended') { ?>
                    <span class="badge badge-success" style="padding-top: 3px"><?=$seller->status?></span>
                  <?php } ?>
                </li>
                <li class="list-group-item">First Name: <?=ucwords($seller->first_name)?></li>
                <li class="list-group-item">Last Name: <?=ucwords($seller->last_name)?></li>
                <li class="list-group-item">Shop Name: <?=ucwords($seller->shop_name)?></li>
                <li class="list-group-item">Email: <?=$seller->email?></li>
                <li class="list-group-item">Gender: <?=ucwords($bus_info->gender)?></li>
                <li class="list-group-item">Phone No: <?=$seller->phone?></li>
                <li class="list-group-item">date of Birth: <?=CustomDateTime::dateFrmatAlt($seller->date_of_birth)?></li>
                <li class="list-group-item">Signup Date: <?=CustomDateTime::dateFrmatAlt($seller->created_at)?></li>
                <li class="list-group-item">Last Seen: <?=CustomDateTime::dateFrmatAlt($seller->last_login)?></li>
              </ul>

            </div>
          </div>
        </div>


        <div class="col-xl-8 grid-margin stretch-card">
          <div class="card">
            <div class="card-body p-0">

              <ul class="nav nav-pills nav-justified p-3 " style="border-bottom: 1px solid #ccc;">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="pill" href="#profile">PROFILE</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="pill" href="#busiInfo">BUSINESS INFO</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="pill" href="#products">PRODUCTS</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="pill" href="#bankInfo">BANK INFO</a>
                </li>
              </ul>


              <div class="tab-content mt-4">
                <div class="tab-pane container active" id="profile">
                  <?php include("includes/seller/profile.php"); ?>
                </div>
                <div class="tab-pane container fade" id="busiInfo">
                  <?php include("includes/seller/business_info.php"); ?>
                </div>
                <div class="tab-pane container fade" id="products">
                  <?php include("includes/seller/products.php"); ?>
                </div>
                <div class="tab-pane container fade" id="bankInfo">
                  <?php include("includes/seller/bank_info.php"); ?>
                </div>
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



<!-- ACTION MODAL -->
<div class="modal" id="actionModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning!!!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Are you sure you want to <span id="getTodo"></span> this user?</p>
        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>seller_manager/set_action">
          <input type="hidden" name="theRole" id="inputRole">
          <input type="hidden" name="sellerID" id="inputId">
          <button class="btn btn-danger btn-sm mr-3" type="submit">YES</button>
          <button class="btn btn-success btn-sm ml-3" type="button" data-dismiss="modal">NO</button>
        </form>
      </div>
    </div>
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

        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>seller_manager/deleteProduct">
          <input type="hidden" name="pid" id="delInputId">
          <input type="hidden" name="sellerID" value="<?=$seller->seller_id?>">
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

        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>seller_manager/approve_product">
          <input type="hidden" name="pid" id="inputIdApp">
          <input type="hidden" name="sellerID" value="<?=$seller->seller_id?>">
          <button class="btn btn-success btn-sm mr-3" type="submit">YES</button>
          <button class="btn btn-danger btn-sm ml-3" type="button" data-dismiss="modal">NO</button>
        </form>
      </div>
    </div>
  </div>
</div>


  <script src="<?=$this_folder?>/assets/js/core.js"></script>

  <script src="<?=$this_folder?>/assets/js/jquery.dataTables.js"></script>
  <script src="<?=$this_folder?>/assets/js/dataTables.bootstrap4.js"></script>

  <script src="<?=$this_folder?>/assets/js/jquery.validate.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/bootstrap-maxlength.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/jquery.inputmask.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/select2.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/typeahead.bundle.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/jquery.tagsinput.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/dropzone.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/dropify.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/bootstrap-colorpicker.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/bootstrap-datepicker.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/moment.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/tempusdominus-bootstrap-4.js"></script>

  <script src="<?=$this_folder?>/assets/js/feather.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/template.js"></script>

  <script src="<?=$this_folder?>/assets/js/form-validation.js"></script>
  <script src="<?=$this_folder?>/assets/js/bootstrap-maxlength.js"></script>
  <script src="<?=$this_folder?>/assets/js/inputmask.js"></script>
  <script src="<?=$this_folder?>/assets/js/select2.js"></script>
  <script src="<?=$this_folder?>/assets/js/typeahead.js"></script>
  <script src="<?=$this_folder?>/assets/js/tags-input.js"></script>
  <script src="<?=$this_folder?>/assets/js/dropzone.js"></script>
  <script src="<?=$this_folder?>/assets/js/dropify.js"></script>
  <script src="<?=$this_folder?>/assets/js/bootstrap-colorpicker.js"></script>
  <script src="<?=$this_folder?>/assets/js/datepicker.js"></script>
  <script src="<?=$this_folder?>/assets/js/timepicker.js"></script>


  <script src="<?=$this_folder?>/assets/js/data-table.js"></script>

  <script>
    function userAction(loginID, role, toDo) {
      $("#actionModal").modal();
      document.getElementById("inputId").value = loginID;
      document.getElementById("inputRole").value = role;
      document.getElementById("getTodo").innerHTML = toDo;
    }

    function deletePro(proID) {
      $("#deleteModal").modal();
      document.getElementById("delInputId").value = proID;
    }

    function approveProduct(proIDApp) {
      $("#approveModal").modal();
      document.getElementById("inputIdApp").value = proIDApp;
    }
  </script>



</body>
</html>