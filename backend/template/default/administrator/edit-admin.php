<?php
    $page_title = "Edit Profile";
    $active_page = "acc_set";
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
      <li class="breadcrumb-item active" aria-current="page">Edit Admin</li>
    </ol>
  </nav>

  <?php if(isset($_GET["update"]) && $_GET["update"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Admin updated successfully
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>admin_manager/update_admin" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-6 grid-margin">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">General Details</h6>
            <input type="hidden" name="adminID" value="<?=$admin->id?>">
            <div class="form-group">
              <label for="full_name">Full Name</label>
              <input type="text" class="form-control" id="full_name" autocomplete="off" name="full_name" value="<?=$admin->full_name?>">
            </div>

            <div class="form-group">
              <label for="site_name">Username</label>
              <input type="text" class="form-control" id="site_name" value="<?=$admin->username?>" readonly>
            </div>

            <div class="form-group">
              <label for="role">Role</label>
              <input type="text" class="form-control" id="role" name="role" value="<?=$admin->role?>">
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="<?=$admin->email?>">
            </div>

            <div class="form-group">
              <label for="phone">Phone Number</label>
              <input type="text" class="form-control" id="phone" name="phone" value="<?=$admin->phone?>">
            </div>

            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="address" name="address" value="<?=$admin->address?>">
            </div>

            <div class="form-group">
              <label for="city">City</label>
              <input type="text" class="form-control" id="city" name="city" value="<?=$admin->city?>" >
            </div>

            <div class="form-group">
              <label for="state">State</label>
              <input type="text" class="form-control" id="state" name="state" value="<?=$admin->state?>">
            </div>

            <div class="form-group">
              <label for="country">Country</label>
              <input type="text" class="form-control" id="country" name="country" value="<?=$admin->country?>">
            </div>
          </div>
        </div>
      </div>


      <div class="col-md-6 grid-margin">
        <div class="card">
          <div class="card-body">
            <input type="hidden" name="defImg" value="<?=$admin->photo?>">
            <h6 class="card-title">Profile Photo</h6>
            <?php if($admin->photo) { ?>
            <input type="file" id="myDropify" class="border" name="photo" data-default-file="<?=$admin->photo?>" />
            <?php } else { ?>
            <input type="file" id="myDropifyDefImgAdmin" class="border" name="photo" data-default-file="<?=$this_folder?>/assets/images/profile-default.png" />
            <?php } ?>
          </div>
        </div>

        <div class="card mt-3">
          <div class="card-body">
            <div class="form-group">
              <label for="bio">Description</label>
              <textarea class="form-control" rows="7" name="bio"><?=$admin->bio?></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="text-center mt-5 mb-5">
      <button type="submit" class="btn btn-primary p-3">Update Profile</button>
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

</body>
</html>