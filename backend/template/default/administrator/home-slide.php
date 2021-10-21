<?php
    $page_title = "Home Banners";
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
      <li class="breadcrumb-item active" aria-current="page">Home Slider</li>
    </ol>
  </nav>

  <?php if(isset($_GET["added"]) && $_GET["added"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Slider successfully added
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["added"]) && $_GET["added"] == 'right_banner') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Right banner successfully updated
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Successful</strong> Slider deleted successfully
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  
  <div class="row">
    <div class="col-xl-5 grid-margin">
      <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/add_slider" enctype="multipart/form-data">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Add New Slider</h6>
            <div class="form-group">
              <label for="title">Title*</label>
              <input type="text" class="form-control" id="title" name="title">
            </div>

            <div class="form-group">
              <label for="url">Link</label>
              <input type="text" class="form-control" id="url" name="url">
            </div>

            <div class="form-group">
              <label for="banner">Banner</label>
              <input type="file" id="myDropifyTwo" class="border" name="banner" required />
            </div>

            <div class="form-group">
              <label for="descr">Description</label>
              <textarea name="descr" class="form-control" rows="8"></textarea>
            </div>

            <div class="text-center mt-5 mb-5">
              <button type="submit" class="btn btn-primary p-3">Add Slider</button>
            </div>
          </div>
        </div>
      </form>
    </div>


    <div class="col-xl-7 grid-margin">
      <input type="hidden" name="default_favicon" value="<?=$webSettting->favicon_url?>">
      <div class="card" style="height: 797px; overflow-y: auto;">
        <div class="card-body">
          <h6 class="card-title">All Sliders</h6>

          <?php foreach ($slides as $slide): ?>
          <div class="each-slide mb-5">
            <img src="<?=$slide->banner?>" width="100%">
            <div class="d-flex justify-content-between mt-2">
              <div><a href="<?=Config::ADMIN_BASE_URL()?>content_manager/edit_slider/<?=$slide->id?>" class="btn btn-primary btn-sm">EDIT</a></div>

              <div>
                <?php if($slide->status == 1) { ?>
                <button class="btn btn-success btn-sm" disabled>Active</button>
                <?php } else if($slide->status == 0) { ?>
                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                <?php } ?>
              </div>

              <div>
                <button onclick="deleteSlide(<?=$slide->id?>)" class="btn btn-danger btn-sm">DELETE</button>
              </div>
            </div>
          </div>
          <?php endforeach ?>
          
        </div>
      </div>


      
    </div>

  </div>


  <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/update_home_right_banner" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=$rightBanner->id?>">
    <div class="row mt-5">

      <div class="col-xl-6 grid-margin">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Right Top Side Banner</h6>
            <input type="hidden" name="defHomeRightTop" value="<?=$rightBanner->banner_top?>">
            <div class="form-group">
              <label for="banner">Banner</label>
              <input type="file" class="border" id="myDropifyLeftBanner" name="home_right_banner_top" data-default-file="<?=$rightBanner->banner_top?>"/>
            </div>

            <div class="form-group">
              <label>Banner URL</label>
              <input type="url" name="banner_top_link" class="form-control" value="<?=$rightBanner->banner_top_link?>">
            </div>
            
          </div>
        </div>
      </div>


      <div class="col-xl-6 grid-margin">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Right Bottom Side Banner</h6>
            <input type="hidden" name="defHomeRightBottom" value="<?=$rightBanner->banner_bottom?>">
            <div class="form-group">
              <label for="banner">Banner</label>
              <input type="file" class="border" id="myDropifyRightBanner" name="home_right_banner_bottom" data-default-file="<?=$rightBanner->banner_bottom?>"/>
            </div>

            <div class="form-group">
              <label>Banner URL</label>
              <input type="url" name="banner_bottom_link" class="form-control" value="<?=$rightBanner->banner_bottom_link?>">
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="text-center mt-5 mb-5">
      <button type="submit" class="btn btn-primary p-3">Update Banner</button>
    </div>
  </form>

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
        <p>Are you sure you want to delete this slide?</p>

        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/delete_slide" class="mt-4">
          <input type="hidden" name="slideID" id="inputID">
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
    function deleteSlide(slideID) {
      $("#deleteModal").modal();
      document.getElementById('inputID').value = slideID;
    }
  </script>
</body>
</html>