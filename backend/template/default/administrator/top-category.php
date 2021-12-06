<?php
    $page_title = "Category Banner";
    $active_page = "featured_category_banner";
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
      <li class="breadcrumb-item active" aria-current="page">Product Manager</li>
      <li class="breadcrumb-item active" aria-current="page">Category Banner</li>
    </ol>
  </nav>

  <?php if(isset($_GET["add"]) && $_GET["add"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Category banner successfully added
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Category banner successfully deleted
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["home_ban_delete"]) && $_GET["home_ban_delete"] == 'success') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Top category successfully deleted
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["home_banner"]) && $_GET["home_banner"] == 'success') { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      Home category banner successfully added
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["home_banner"]) && $_GET["home_banner"] == 'added') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Sorry, You have already added banner for this category
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  
  <div class="row">

    <div class="col-xl-12 mb-5">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Home Page Category Banner</h6>


          <div class="row">
            <div class="col-xl-5">
              <div class="card card-header">
                <form method="post" action="<?=Config::ADMIN_BASE_URL()?>product_manager/add_home_cat_banner" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="category">Select Category*</label>
                    <select class="form-control custom-select" name="category" required>
                      <option hidden>-- Select --</option>
                      <?php foreach ($categories as $category): ?>
                        <option style="font-size: 17px; font-weight: bolder;" value="<?=$category['mainCats']->cat_slug?>"><?=$category['mainCats']->cat_name?></option>
                      <?php endforeach ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control">
                  </div>

                  <div class="form-group">
                    <label>Banner</label>
                    <input type="file" class="border" id="myDropifyTwo" name="home_cat_banner" />
                  </div>

                  <div class="text-center mt-5">
                    <button class="btn btn-primary">ADD NOW</button>
                  </div>
                </form>
              </div>
            </div>


            <div class="col-xl-7">
              <div class="row">
                
                <?php foreach ($homeCat as $catBan): ?>
                  <div class="col-xl-6 mb-3">
                    <div style="border: 1px solid #ccc; padding: 5px">
                      <img src="<?=$catBan->banner?>" width="100%">
                      <p class="text-center"><?=$catBan->title?></p>

                      <div class="d-flex justify-content-center">
                        <div>
                          <button onclick="deletHomeBan(<?=$catBan->id?>)" class="btn btn-danger">Delete</button>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach ?>
                  
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
        <p>Are you sure you want to delete this banner?</p>

        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>product_manager/delete_cat_banner">
          <input type="hidden" name="bannerID" id="inputId">
          <button class="btn btn-danger btn-sm mr-3" type="submit">YES</button>
          <button class="btn btn-success btn-sm ml-3" type="button" data-dismiss="modal">NO</button>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal" id="delHomeBanModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning!!!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Are you sure you want to delete this Home category banner?</p>

        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>product_manager/delete_home_cat">
          <input type="hidden" name="catBanID" id="inputIdcatBan">
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
  function deleteBanner(bannerID) {
    $("#delBannerModal").modal();
    document.getElementById("inputId").value = bannerID;
  }

  function deletHomeBan(catBanID) {
    $("#delHomeBanModal").modal();
    document.getElementById("inputIdcatBan").value = catBanID;
  }
</script>
</body>
</html>