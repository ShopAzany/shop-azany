<?php
    $page_title = "Change Password";
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
      <li class="breadcrumb-item active" aria-current="page">Change Passowrd</li>
    </ol>
  </nav>

  <?php if(isset($_GET["password"]) && $_GET["password"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Password successfully reset.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["password"]) && $_GET["password"] == 'wrong_password') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Oops!!!</strong> Old password is wrong
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["password"]) && $_GET["password"] == 'not_matched') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Oops!!!</strong> New Password does not matched with retyped
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>admin_manager/change_pwd" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-6 grid-margin">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Password Details</h6>
            <div class="form-group">
              <label for="old_pwd">Old Password</label>
              <input type="password" class="form-control" id="old_pwd" required autocomplete="off" name="old_pwd">
            </div>

            <div class="form-group">
              <label for="new_pwd">New Password </label>
              <input type="password" name="new_pwd" class="form-control" id="new_pwd" required>
            </div>

            <div class="form-group">
              <label for="retype_new_pwd">Retype New Password</label>
              <input type="password" required class="form-control" id="retype_new_pwd" name="retype_new_pwd">
            </div>


            <div class="text-center mt-5 mb-3">
              <button type="submit" class="btn btn-primary p-3">Change Password</button>
            </div>
          </div>
        </div>
      </div>

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