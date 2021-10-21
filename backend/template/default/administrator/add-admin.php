<?php
    $page_title = "Add Admin";
    $active_page = "admin_manager";
    include("includes/header.php");
?>
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/select2.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/jquery.tagsinput.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/dropzone.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/dropify.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/bootstrap-colorpicker.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/tempusdominus-bootstrap-4.min.css">
<style>
  .file-icon p{
    font-size: 17px !important
  }
</style>

<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>admin_manager">All Admins</a></li>
      <li class="breadcrumb-item active" aria-current="page">Add Admin</li>
    </ol>
  </nav>

  <?php if(isset($_GET["create"]) && $_GET["create"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Admin added successfully
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>admin_manager/add_admin" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-6 grid-margin">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">General Details</h6>
            <div class="form-group">
              <label for="full_name">Full Name</label>
              <input type="text" class="form-control" id="full_name" autocomplete="off" name="full_name">
            </div>

            <div class="form-group">
              <label for="site_name">Username</label>
              <input type="text" class="form-control" id="site_name" name="username">
            </div>

            <div class="form-group">
              <label>Password</label>
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" id="myInput">
                <div class="input-group-append">
                  <button onclick="viewPassword()" class="btn btn-success" type="button"><i class="fa fa-eye"></i></button>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="role">Role</label>
              <input type="text" class="form-control" id="role" name="role">
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email">
            </div>

            <div class="form-group">
              <label for="phone">Phone Number</label>
              <input type="text" class="form-control" id="phone" name="phone">
            </div>

            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="address" name="address">
            </div>

            <div class="form-group">
              <label for="city">City</label>
              <input type="text" class="form-control" id="city" name="city">
            </div>

            <div class="form-group">
              <label for="state">State</label>
              <input type="text" class="form-control" id="state" name="state">
            </div>

            <div class="form-group">
              <label for="country">Country</label>
              <input type="text" class="form-control" id="country" name="country">
            </div>
          </div>
        </div>
      </div>


      <div class="col-md-6 grid-margin">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Profile Photo</h6>
            <input type="file" id="myDropifyDefImgAdmin" class="border" name="photo"/>
          </div>
        </div>

        <div class="card mt-3">
          <div class="card-body">
            <div class="form-group">
              <label for="bio">About</label>
              <textarea class="form-control" rows="7" name="bio"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="text-center mt-5 mb-5">
      <button type="submit" class="btn btn-primary p-3">Add Admin</button>
    </div>

  </form>

</div>





<?php
    include("includes/footer.php");
?>
  
    </div>
  </div>

  

  <script src="<?=$this_folder?>/assets/js/core.js"></script>

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


<script>
  function viewPassword() {
    var x = document.getElementById("myInput");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
</script>
</body>
</html>