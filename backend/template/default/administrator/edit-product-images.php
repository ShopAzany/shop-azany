<?php
    $page_title = "Edit Products";
    $active_page = "pro_manager";
    include("includes/header.php");
    $proNav = 'pro-img';
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



          <form method="post" action="<?=Config::ADMIN_BASE_URL()?>product_manager/update_pro_img" enctype="multipart/form-data">
            <input type="hidden" name="pid" value="<?=$product->pid?>">

            <div class="row firstBankDel mt-4" id="first_bank">
                <div class="col-xl-4">
                    <div class="card mb-0">
                        <div class="card-header">
                            Upload Image
                        </div>
                        <div class="card-body">
                            <input type="file" id="myDropify" class="border" name="product_img" onchange="form.submit()"/>
                        </div>
                    </div>
                </div>
                

                <?php if($product->images) { ?>
                <?php foreach ($productImg as $key => $pimg): $count += 1; ?>
                <div class="col-xl-4 mb-4">
                    <div class="card mb-0">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div>
                                    Image <?=$count?>
                                </div>
                                <div>
                                    <button onclick="removeImg(<?=$product->pid?>, <?=$key?>)" class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <img src="<?=$pimg?>"  style="width: 100%; height: 195px; object-fit: contain;">  
                        </div>
                    </div>
                </div> 
                <?php endforeach ?>
                <?php } ?>
            </div>
          </form>



          <form method="post" action="<?=Config::ADMIN_BASE_URL()?>product_manager/saveImgContinue">
            <input type="hidden" name="pid" value="<?=$product->pid?>">
            <div class="mt-5 text-center">
              <button class="btn btn-primary rounded-0 pt-3 pb-3" type="submit">SAVE AND CONTINUE</button>
            </div>
          </form>

        </div>
      </div>

    </div>

    <?php
      include("includes/footer.php");
    ?>
  
  </div>
</div>


<!--DELETE IMAGE MODAL-->
<div class="modal" id="deleImgModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p class="text-center">Are you sure you want to remove this product image</p>
        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>product_manager/remove_product_img">
            <input type="hidden" name="pid" id="pidInput">
            <input type="hidden" name="arrID" id="arrIDInput">
            <div class="text-center mt-4">
                <button class="btn btn-danger btn-sm mr-3" type="submit">YES</button>
                <button class="btn btn-primary btn-sm ml-3" type="button" data-dismiss="modal">NO</button>
            </div>
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
    function removeImg(pid, arrID) {
        document.getElementById('pidInput').value = pid;
        document.getElementById('arrIDInput').value = arrID;
        $("#deleImgModal").modal();
    }
</script>


</body>
</html>