<?php
    $page_title = "Featured Category";
    $active_page = "feature_cat";
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
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>product_manager/featured_category">Featured Category</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit Feature</li>
    </ol>
  </nav>

  <?php if(isset($_GET["update"]) && $_GET["update"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Feature category successfully updated
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["error"]) && $_GET["error"] == 'cat') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Oops!!!</strong> This category is already added to featured category.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  
  <div class="row">
    <div class="col-xl-5 grid-margin">
      <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>product_manager/update_feature" enctype="multipart/form-data">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Add Feature Category</h6>
            <input type="hidden" class="form-control" name="id" value="<?=$feat->id?>">
            <div class="form-group">
              <label for="category">Select Category*</label>
              <select class="form-control custom-select" name="category" required>
                <option hidden>-- Select --</option>
                <?php foreach ($categories as $category): ?>
                  <option <?php if($category->cat_slug == $feat->category) { ?> selected <?php } ?> value="<?=$category->cat_slug?>"><?=$category->cat_name?></option>
                <?php endforeach ?>
              </select>
            </div>


            <div class="form-group">
              <label for="title">Category Heading</label>
              <input type="text" class="form-control" id="title" name="title" value="<?=$feat->title?>">
            </div>


            <div class="form-group">
              <input type="hidden" name="def_full_width_banner" value="<?=$feat->full_width_banner?>">
              <label>Full Width Banner</label>
              <input type="file" id="myDropify" class="border" name="full_width_banner" data-default-file="<?=$feat->full_width_banner?>"/>
            </div>
            <div class="form-group">
              <label>Full Width Banner Link</label>
              <input type="text" class="form-control" name="full_width_banner_link" value="<?=$feat->title?>">
            </div>


            <div class="form-group">
              <input type="hidden" name="def_left_banner" value="<?=$feat->left_banner?>">
              <label>Left Banner</label>
              <input type="file" id="myDropifyLeftBanner" class="border" name="left_banner" data-default-file="<?=$feat->left_banner?>"/>
            </div>
            <div class="form-group">
              <label>Left Banner Link</label>
              <input type="text" class="form-control" name="left_banner_link" value="<?=$feat->left_banner_link?>">
            </div>


            <div class="form-group">
              <input type="hidden" name="def_right_banner" value="<?=$feat->right_banner?>">
              <label>Right Banner</label>
              <input type="file" id="myDropifyRightBanner" class="border" name="right_banner" data-default-file="<?=$feat->right_banner?>"/>
            </div>
            <div class="form-group">
              <label>Left Banner Link</label>
              <input type="text" class="form-control" name="right_banner_link" value="<?=$feat->right_banner_link?>">
            </div>


            <div class="text-center mt-5 mb-5">
              <button type="submit" class="btn btn-primary p-3">Update Feature</button>
            </div>
          </div>
        </div>
      </form>
    </div>


    <div class="col-xl-7 grid-margin">
      <input type="hidden" name="default_favicon" value="<?=$webSettting->favicon_url?>">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">All Banners</h6>

          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <?php if($feat->full_width_banner) { ?>
                <img src="<?=$feat->full_width_banner?>" width="100%">
              <?php } ?>

              <div class="row">
                <div class="col-xl-6">
                  <?php if($feat->left_banner) { ?>
                    <img src="<?=$feat->left_banner?>" width="100%">
                  <?php } ?>
                </div>
                <div class="col-xl-6">
                  <?php if($feat->right_banner) { ?>
                    <img src="<?=$feat->right_banner?>" width="100%">
                  <?php } ?>
                </div>
              </div>

              

              <div class="d-flex justify-content-between mt-3">
                <div>
                  Title: <?=$feat->title?><br>
                  Category: <?=str_replace('-', ' ', $feat->category) ?>
                </div>
                <!-- <div>
                  <a href="<?=Config::ADMIN_BASE_URL()?>product_manager/edit_feature_category" class="btn btn-success"><i class="fa fa-edit"></i></a>
                  <button class="btn btn-danger bnt-sm" onclick="deleteFeature(<?=$feat->id?>)"><i class="fa fa-trash"></i></button>
                </div> -->
              </div>
            </li>
          </ul>

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
<div class="modal" id="delBannerModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning!!!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Are you sure you want to delete this featured category?</p>

        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>product_manager/delete_feature_cat">
          <input type="hidden" name="featID" id="inputId">
          <button class="btn btn-danger btn-sm mr-3" type="submit">YES</button>
          <button class="btn btn-success btn-sm ml-3" type="button" data-dismiss="modal">NO</button>
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
  function deleteFeature(featID) {
    $("#delBannerModal").modal();
    document.getElementById("inputId").value = featID;
  }
</script>
</body>
</html>