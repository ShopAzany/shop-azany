<?php
    $page_title = "Edit Products";
    $active_page = "pro_manager";
    include("includes/header.php");
    $proNav = 'pro-shipping';
?>
<link rel="stylesheet" type="text/css" href="<?=$this_folder?>assets/css/simplemde.min.css">
<style>
  .form-wrapper{
    border: 1px solid #ccc;
  }

  .form-wrapper .form-control{
    height: 45px; 
    border: 2px solid #ccc; 
    border-radius: 5px;
  }
  .pointer{
    cursor: pointer;
  }
</style>


    <div class="page-content">

      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
        </ol>
      </nav>

      <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
          Admin deleted successfully
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      <?php } ?>

      <div class="row">
        <div class="col-md-12 grid-margin">
          
          <div class="tabSide">
            <div class="card card-body p-0" style="border: 2px solid #E51924; border-radius: 0px">
                <?php
                  include('includes/edit-product-nav.php');
                ?>
            </div>
          </div>


          <div class="row justify-content-center mt-5">
              
            <div class="col-xl-10">
              <form method="post" action="<?=Config::ADMIN_BASE_URL()?>product_manager/update_shipping_detail">

                <div class="form-wrapper card card-body">
                  <input type="hidden" name="pid" value="<?=$product->pid?>">

                  <div class="row">
                    <div class="col-xl-6">
                      <div class="form-group">
                        <label>Product Location Country</label>
                        <select class="form-control custom-select" name="pro_location_country">
                          <option hidden label="--- Select Product Country ---"></option>
                          <?php foreach ($countries as $country): ?>
                          <option <?php if($product->pro_location_country == $country) { ?> selected <?php } ?> value="<?=trim($country)?>"><?=$country?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-xl-6">
                      <div class="form-group">
                        <label>Product Location State</label>
                        <input type="text" name="pro_location_state" class="form-control" value="<?=$product->pro_location_state?>">
                      </div>
                    </div>

                    <div class="col-xl-6">
                      <div class="form-group">
                        <label>Shipping Method</label>
                        <input type="text" name="shipping_method" class="form-control" value="<?=$product->shipping_method?>">
                      </div>
                    </div>

                    <div class="col-xl-6">
                      <label>Shipping Fee</label>
                      <div class="form-group">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <button class="btn btn-success" type="submit"><?=$curr->symbol?></button>
                          </div>
                          <input type="number" class="form-control" name="shipping_fee" value="<?=$product->shipping_fee?>">
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="mt-5">
                    <div class="form-group">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" <?php if($product->allow_shipping_outside) { ?> checked <?php } ?> id="allow_shipping_outside" name="allow_shipping_outside" value="1">
                        <label class="custom-control-label mb-0" for="allow_shipping_outside">Allow shipping outside state</label>
                      </div>
                    </div>

                    <p class="text-muted"><i class="fa fa-exclamation-circle"></i> Enabling shipping outside state may incure tax expenses</p>
                  </div>



                  <div class="text-center mt-5">
                    <button class="btn btn-primary rounded-0 pt-3 pb-3">SUBMIT</button>
                  </div>
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


  <!-- core:js -->
  <script src="<?=$this_folder?>/assets/js/core.js"></script>
  <!-- endinject -->
  

  <!-- inject:js -->
  <script src="<?=$this_folder?>/assets/js/feather.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/template.js"></script>
  <!-- endinject -->
<!-- 
  <script src="<?=$this_folder?>/assets/js/tinymce.js"></script>
  <script src="<?=$this_folder?>/assets/js/simplemde.js"></script>
  <script src="<?=$this_folder?>/assets/js/ace.js"></script> -->


</body>
</html>