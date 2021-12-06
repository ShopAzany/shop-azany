<?php
    $page_title = "Three Grid Image";
    $active_page = "home_product";
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
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>home_product">Home Product</a></li>
      <li class="breadcrumb-item active" aria-current="page">Three Grid Image</li>
    </ol>
  </nav>

  <?php if(isset($_GET["status"]) && $_GET["status"] == 'error') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Oops! You can not add more than four country to shop by country on home page
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["status"]) && $_GET["status"] == 'delete') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Banner deleted successfully
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["status"]) && $_GET["status"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Banner successfully added
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  
  <div class="row">

    <div class="col-xl-12 mb-5">
      <div class="card">
        <div class="card-header">
          
          <div class="d-flex justify-content-between">
            <div><h6 class="card-title mb-0">Three Grid Image</h6></div>
            <div>
              <form method="post" action="<?=Config::ADMIN_BASE_URL()?>home_product/status_action">
                <input type="hidden" name="product_type" value="three_grid_image">
                <div class="custom-control custom-switch">
                  <input type="checkbox" <?php if($home_pro->three_grid_image == 'Enabled') { ?> checked <?php } ?> name="action" class="custom-control-input" id="switch1" onchange="form.submit()">
                  <label class="custom-control-label" for="switch1"><?php if($home_pro->three_grid_image == 'Enabled') { ?> Enabled <?php } else { ?> Disabled <?php } ?></label>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-body">
          


          <div class="row">
            <div class="col-xl-5">
              <div class="card card-header">
                <h6 class="card-title mb-3">Add Banner</h6>

                <form method="post" action="<?=Config::ADMIN_BASE_URL()?>home_product/addGrimImage" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="country">URL</label>
                    <input type="url" name="url" class="form-control">
                  </div>

                  <div class="form-group">
                    <label>Image</label>
                    <input type="file" class="border" required id="myDropifyTwo" name="gridImg" />
                  </div>

                  <div class="text-center mt-5">
                    <button class="btn btn-primary">ADD NOW</button>
                  </div>
                </form>
              </div>
            </div>


            <div class="col-xl-7">
              <div class="row">
                
                <?php foreach ($getAll as $ban): ?>
                  <div class="col-xl-6 mb-3">
                    <div style="border: 1px solid #ccc; padding: 5px">
                      <img src="<?=$ban->banner_top?>" width="100%">
                      <p class="text-center mt-2 mb-2"><?=$ban->banner_top_link?></p>

                      <div class="d-flex justify-content-center">
                        <div>
                          <button onclick="deletHomeBan(<?=$ban->id?>)" class="btn btn-danger">Delete</button>
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
        <p>Are you sure you want to delete this banner?</p>

        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>home_product/delete_grid_img">
          <input type="hidden" name="bannerID" id="inputIdcatBan">
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

  function deletHomeBan(catBanID) {
    $("#delHomeBanModal").modal();
    document.getElementById("inputIdcatBan").value = catBanID;
  }
</script>
</body>
</html>