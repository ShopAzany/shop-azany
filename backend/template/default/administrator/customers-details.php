<?php
    $page_title = "Customer Detail";
    $active_page = "customer";
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
          <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>customer_manager">All Customers</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?=ucwords($user->first_name)?></li>
        </ol>
      </nav>

      <?php if(isset($_GET["update"]) && $_GET["update"] == 'success') { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          User profile successfully updated
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      <?php } ?>

      <?php if(isset($_GET["address"]) && $_GET["address"] == 'success') { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          User address successfully updated
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      <?php } ?>

      <?php if(isset($_GET["default-address"]) && $_GET["default-address"] == 'success') { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          You have successfully set default address for this user.
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
                <img src="<?=$this_folder?>/assets/images/profile-default.png" alt="John Doe" class="mr-3" style="width:60px; height: 60px; border: 1px solid #ccc">
                <div class="media-body">
                  <h5><?=ucwords($user->full_name)?></h5>
                  <p><?=$user->email?></p>
                  <p>
                    <?php if($user->status == "Blocked") { ?>

                      <button class="btn def-btn btn-secondary">Blocked</button>
                      <button class="btn def-btn outline-danger" onclick="userAction(<?=$user->login_id?>, 'Active', 'Unblock')">Unblock</button>
                      <button class="btn def-btn btn-danger" onclick="userAction(<?=$user->login_id?>, 'Delete', 'Delete')">Delete</button>

                    <?php } else if($user->status == "Active") { ?>

                      <button class="btn def-btn btn-danger" onclick="userAction(<?=$user->login_id?>, 'Blocked', 'Block')">Blocked</button>
                      <button class="btn def-btn btn-warning" onclick="userAction(<?=$user->login_id?>, 'Suspended', 'Suspend')">Suspend</button>
                      <button class="btn def-btn btn-danger" onclick="userAction(<?=$user->login_id?>, 'Delete', 'Delete')">Delete</button>

                    <?php } else if($user->status == "Suspended") { ?>

                      <button class="btn def-btn btn-secondary">Suspended</button>
                      <button class="btn def-btn outline-danger" onclick="userAction(<?=$user->login_id?>, 'Active', 'Unsuspend')">Unsuspend</button>
                      <button class="btn def-btn btn-danger" onclick="userAction(<?=$user->login_id?>, 'Delete', 'Delete')">Delete</button>

                    <?php } ?>
                  </p>
                </div>
              </div>


              <ul class="list-group list-group-flush mt-4">
                <li class="list-group-item">
                  Status:
                  <?php if($user->status == 'Active') { ?>
                    <span class="badge badge-success" style="padding-top: 3px">Active</span>
                  <?php } else if($user->status == 'Pending') { ?>
                    <span class="badge badge-warning" style="padding-top: 3px">Pending</span>
                  <?php } else if($user->status == 'Blocked' || $user->status == 'Suspended') { ?>
                    <span class="badge badge-success" style="padding-top: 3px"><?=$user->status?></span>
                  <?php } ?>
                </li>
                <li class="list-group-item">First Name: <?=ucwords($user->full_name)?></li>
                <li class="list-group-item">Email: <?=$user->email?></li>
                <li class="list-group-item">Gender: <?=$user->gender?></li>
                <li class="list-group-item">Phone No: <?=$user->phone?></li>
                <li class="list-group-item">Signup Date: <?=CustomDateTime::dateFrmatAlt($user->created_at)?></li>
                <li class="list-group-item">Last Seen: <?=CustomDateTime::dateFrmatAlt($user->last_seen)?></li>
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
                  <a class="nav-link" data-toggle="pill" href="#address">ADDRESS</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="pill" href="#orders">ORDERS</a>
                </li>
               <!--  <li class="nav-item">
                  <a class="nav-link" data-toggle="pill" href="#save_items">SAVE ITEMS</a>
                </li> -->
              </ul>


              <div class="tab-content mt-4">
                <div class="tab-pane container active" id="profile">
                  <?php include("includes/user-profile.php"); ?>
                </div>
                <div class="tab-pane container fade" id="address">
                  <?php include("includes/user-address.php"); ?>
                </div>
                <div class="tab-pane container fade" id="orders">
                  <?php include("includes/user-orders.php"); ?>
                </div>
                <div class="tab-pane container fade" id="save_items">
                  <?php include("includes/user-save-items.php"); ?>
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


<div class="modal" id="setDefaultAddress">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning!!!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Are you sure you want to set this address as default?</p>
        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>customer_manager/set_default_address">
          <input type="hidden" name="addID" id="inputIdAdd">
          <input type="hidden" name="loginID" value="<?=$user->login_id?>">
          <button class="btn btn-danger btn-sm mr-3" type="submit">YES</button>
          <button class="btn btn-success btn-sm ml-3" type="button" data-dismiss="modal">NO</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- EDIT ADDRESS MODAL -->
<div class="modal" id="editAddressModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Address</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>customer_manager/update_user_address">
          <input type="hidden" name="loginID" value="<?=$user->login_id?>">
          <div id="getForm"></div>

          <div class="text-center mb-3 mt-3">
            <button class="btn btn-primary pb-2" type="submit">Update Address</button>
          </div>
        </form>
      </div>
    </div>
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
        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>customer_manager/set_action">
          <input type="hidden" name="theRole" id="inputRole">
          <input type="hidden" name="loginID" id="inputId">
          <button class="btn btn-danger btn-sm mr-3" type="submit">YES</button>
          <button class="btn btn-success btn-sm ml-3" type="button" data-dismiss="modal">NO</button>
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

    function setAsDefault(addID) {
      $("#setDefaultAddress").modal();
      document.getElementById("inputIdAdd").value = addID;
    }


    function editAddress(addID) {
      $.ajax({
        url: "<?=Config::ADMIN_BASE_URL()?>customer_manager/get_user_address/" + addID,
        type: "Get",
        success: function(data){
          if(Number(data) !== 0) {
            document.getElementById('getForm').innerHTML = data;
            $("#editAddressModal").modal();
          }
        }         
      });
    }
  </script>
</body>
</html>