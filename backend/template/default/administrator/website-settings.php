<?php
    $page_title = "General Settings";
    $active_page = "gen_set";
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
      <li class="breadcrumb-item active" aria-current="page">Website Settings</li>
    </ol>
  </nav>

  <?php if(isset($_GET["update"]) && $_GET["update"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      <strong>Successful</strong> Website settings successfully updated
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>general_settings/website_update" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-6 grid-margin">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">General Settings</h6>
            <div class="form-group">
              <label for="biz_name">Business_name</label>
              <input type="text" class="form-control" id="biz_name" autocomplete="off" name="biz_name" value="<?=$webSettting->biz_name?>">
            </div>

            <div class="form-group">
              <label for="site_name">Site Name</label>
              <input type="text" class="form-control" id="site_name" name="site_name" value="<?=$webSettting->site_name?>">
            </div>

            <div class="form-group">
              <label for="site_title">Site Title</label>
              <input type="text" class="form-control" id="site_title" name="site_title" value="<?=$webSettting->site_title?>">
            </div>

            <div class="form-group">
              <label for="site_email">Site Email</label>
              <input type="email" class="form-control" id="site_email" name="site_email" value="<?=$webSettting->site_email?>">
            </div>

            <div class="form-group">
              <label for="site_url">Site URL</label>
              <input type="url" class="form-control" id="site_url" name="site_url" value="<?=$webSettting->site_url?>">
            </div>

            <div class="form-group">
              <label for="biz_phone">Phone Number</label>
              <input type="text" class="form-control" id="biz_phone" name="biz_phone" value="<?=$webSettting->biz_phone?>">
            </div>

            <div class="form-group">
              <label for="biz_addr">Business Address</label>
              <input type="text" class="form-control" id="biz_addr" name="biz_addr" value="<?=$webSettting->biz_addr?>">
            </div>

            <div class="form-group">
              <label for="biz_city">Business City</label>
              <input type="text" class="form-control" id="biz_city" name="biz_city" value="<?=$webSettting->biz_city?>" >
            </div>

            <div class="form-group">
              <label for="biz_state">Business State</label>
              <input type="text" class="form-control" id="biz_state" name="biz_state" value="<?=$webSettting->biz_state?>">
            </div>

            <div class="form-group">
              <label for="biz_country">Business Country</label>
              <input type="text" class="form-control" id="biz_country" name="biz_country" value="<?=$webSettting->biz_country?>">
            </div>
          </div>
        </div>
      </div>


      <div class="col-md-6 grid-margin">
        <input type="hidden" name="default_favicon" value="<?=$webSettting->favicon_url?>">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Upload Favicon</h6>
            <input type="file" id="myDropify" class="border" name="favicon_url" data-default-file="<?=$webSettting->favicon_url?>" />
          </div>
        </div>


        <div class="card mt-3">
          <input type="hidden" name="default_logo" value="<?=$webSettting->logo_url?>">
          <div class="card-body">
            <h6 class="card-title">Upload Logo</h6>
            <input type="file" id="myDropifyTwo" class="border" name="logo_url" data-default-file="<?=$webSettting->logo_url?>"/>
          </div>
        </div>


        <div class="card mt-3">
          <div class="card-body">
            <div class="form-group">
              <label for="site_description">Site Description</label>
              <textarea class="form-control" rows="7" name="site_description"><?=$webSettting->site_description?></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="text-center mt-5 mb-5">
      <button type="submit" class="btn btn-primary p-3">Update Settings</button>
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