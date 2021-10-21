<?php
    $page_title = "Home Product";
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

  #accordion .card .card-header a{
    color: #555;
    font-weight: 550;
    font-size: 15px;
  }
</style>


<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Home Product</li>
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

  

    <div id="accordion">

      <div class="card mb-2">
        <div class="card-header">
          <a class="card-link d-block" data-toggle="collapse" href="#collapseSeven">
            Shop By Country
          </a>
        </div>
        <div id="collapseSeven" class="collapse <?php if(!isset($_GET['action'])) { ?> show <?php } ?>" data-parent="#accordion">
          <div class="card-body">
            <a href="<?=Config::ADMIN_BASE_URL()?>home_product/shop_by_country" class="btn btn-primary pb-2">EDIT</a>
          </div>
        </div>
      </div>

      <div class="card mb-2">
        <div class="card-header">
          <a class="card-link d-block" data-toggle="collapse" href="#collapseEight">
            Feature product banner
          </a>
        </div>
        <div id="collapseEight" class="collapse" data-parent="#accordion">
          <div class="card-body">
            <a href="<?=Config::ADMIN_BASE_URL()?>home_product/feature_product_banner" class="btn btn-primary pb-2">EDIT</a>
          </div>
        </div>
      </div>

      <div class="card mb-2">
        <div class="card-header">
          <a class="card-link d-block" data-toggle="collapse" href="#collapseOne">
            Today Deals
          </a>
        </div>
        <div id="collapseOne" class="collapse <?php if(isset($_GET['action']) && $_GET['action'] == 'today_deals') { ?> show <?php } ?>" data-parent="#accordion">
          <div class="card-body">
            These are product with discount from 1% and above
            <form method="post" class="mt-3" action="<?=Config::ADMIN_BASE_URL()?>home_product/status_action">
              <input type="hidden" name="product_type" value="today_deals">
              <input type="hidden" name="home" value="fromHome">
              <div class="custom-control custom-switch">
                <input type="checkbox" <?php if($home_pro->today_deals == 'Enabled') { ?> checked <?php } ?> name="action" class="custom-control-input" id="switch1" onchange="form.submit()">
                <label class="custom-control-label" for="switch1"><?php if($home_pro->today_deals == 'Enabled') { ?> Enabled <?php } else { ?> Disabled <?php } ?></label>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="card mb-2">
        <div class="card-header">
          <a class="collapsed card-link d-block" data-toggle="collapse" href="#collapseTwo">
            Recommended For You
          </a>
        </div>
        <div id="collapseTwo" class="collapse <?php if(isset($_GET['action']) && $_GET['action'] == 'recommended') { ?> show <?php } ?>" data-parent="#accordion">
          <div class="card-body">
            These are product that will be recommended to users according to the product they viewed or purchased
            <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>home_product/status_action">
              <input type="hidden" name="product_type" value="recommended">
              <input type="hidden" name="home" value="fromHome">
              <div class="custom-control custom-switch">
                <input type="checkbox" <?php if($home_pro->recommended == 'Enabled') { ?> checked <?php } ?> name="action" class="custom-control-input" id="switch2" onchange="form.submit()">
                <label class="custom-control-label" for="switch2"><?php if($home_pro->recommended == 'Enabled') { ?> Enabled <?php } else { ?> Disabled <?php } ?></label>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="card mb-2">
        <div class="card-header">
          <a class="collapsed card-link d-block" data-toggle="collapse" href="#collapseThree">
            Three Grid Image
          </a>
        </div>
        <div id="collapseThree" class="collapse" data-parent="#accordion">
          <div class="card-body">
            <a href="<?=Config::ADMIN_BASE_URL()?>home_product/three_grid_image" class="btn btn-primary pb-2">EDIT</a>
          </div>
        </div>
      </div>

      <div class="card mb-2">
        <div class="card-header">
          <a class="collapsed card-link d-block" data-toggle="collapse" href="#collapseFour">
            Top Selling
          </a>
        </div>
        <div id="collapseFour" class="collapse <?php if(isset($_GET['action']) && $_GET['action'] == 'top_selling') { ?> show <?php } ?>" data-parent="#accordion">
          <div class="card-body">
            These are the list of most top selling product
            <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>home_product/status_action">
              <input type="hidden" name="product_type" value="top_selling">
              <input type="hidden" name="home" value="fromHome">
              <div class="custom-control custom-switch">
                <input type="checkbox" <?php if($home_pro->top_selling == 'Enabled') { ?> checked <?php } ?> name="action" class="custom-control-input" id="switch3" onchange="form.submit()">
                <label class="custom-control-label" for="switch3"><?php if($home_pro->top_selling == 'Enabled') { ?> Enabled <?php } else { ?> Disabled <?php } ?></label>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="card mb-2">
        <div class="card-header">
          <a class="collapsed card-link d-block" data-toggle="collapse" href="#collapseFive">
            Live Stream
          </a>
        </div>
        <div id="collapseFive" class="collapse" data-parent="#accordion">
          <div class="card-body">
            <a href="<?=Config::ADMIN_BASE_URL()?>home_product/live_stream" class="btn btn-primary pb-2">EDIT</a>
          </div>
        </div>
      </div>

      <div class="card mb-2">
        <div class="card-header">
          <a class="collapsed card-link d-block" data-toggle="collapse" href="#collapseSix">
            Recently Added to Azany
          </a>
        </div>
        <div id="collapseSix" class="collapse <?php if(isset($_GET['action']) && $_GET['action'] == 'recently_added') { ?> show <?php } ?>" data-parent="#accordion">
          <div class="card-body">
          These are the list of recently added products
            <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>home_product/status_action">
              <input type="hidden" name="product_type" value="recently_added">
              <input type="hidden" name="home" value="fromHome">
              <div class="custom-control custom-switch">
                <input type="checkbox" <?php if($home_pro->recently_added == 'Enabled') { ?> checked <?php } ?> name="action" class="custom-control-input" id="switch4" onchange="form.submit()">
                <label class="custom-control-label" for="switch4"><?php if($home_pro->recently_added == 'Enabled') { ?> Enabled <?php } else { ?> Disabled <?php } ?></label>
              </div>
            </form>
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