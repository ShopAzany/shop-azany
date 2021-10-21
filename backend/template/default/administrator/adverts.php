<?php
    $page_title = "Adverts";
    $active_page = "con_manager";
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
      <li class="breadcrumb-item active" aria-current="page">Content Manager</li>
      <li class="breadcrumb-item active" aria-current="page">Adverts</li>
    </ol>
  </nav>

  <?php if(isset($_GET["update"]) && $_GET["update"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Adverts successfully updated
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>


  <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Successful</strong> Brand deleted successfully
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  
  <div class="row">
    <div class="col-xl-5 grid-margin">
      <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/updateAdvert" enctype="multipart/form-data">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title"><?=$homeAds->title?></h6>
            <input type="hidden" name="id" value="<?=$homeAds->id?>">
            <div class="form-group">
              <label for="title">Title*</label>
              <input type="text" class="form-control" id="title" name="title" value="<?=$homeAds->title?>">
            </div>

            <div class="form-group">
              <label for="banner">Image</label>
              <input type="file" id="myDropifyTwo" class="border" name="image" data-default-file="<?=$homeAds->image?>"/>
            </div>


            <div>
              <label>Status</label>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="customRadio" name="status" <?php if($homeAds->status == 1) { ?> checked <?php } ?> value="1">
                <label class="custom-control-label" for="customRadio">Active</label>
              </div>

              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="customRadio" name="status" <?php if($homeAds->status == 0) { ?> checked <?php } ?> value="0">
                <label class="custom-control-label" for="customRadio">Pending</label>
              </div>
            </div>

            <div class="text-center mt-5 mb-5">
              <button type="submit" class="btn btn-primary p-3">Update Ads</button>
            </div>
          </div>
        </div>
      </form>
    </div>


    <div class="col-xl-7 grid-margin">
          
    </div>

  </div>

</div>





<?php
    include("includes/footer.php");
?>
  
    </div>
  </div>


<!-- delete modal( -->
<div class="modal" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning!!!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Are you sure you want to delete this brand?</p>

        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/deleteBrand" class="mt-4">
          <input type="hidden" name="brID" id="inputID">
          <button class="btn btn-primary btn-sm mr-3" type="submit">YES</button>
          <button class="btn btn-danger btn-sm ml-3" data-dismiss="modal" type="button">NO</button>
        </form>
      </div>
    </div>
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
    function deleteBrand(brandID) {
      $("#deleteModal").modal();
      document.getElementById('inputID').value = brandID;
    }
  </script>
</body>
</html>