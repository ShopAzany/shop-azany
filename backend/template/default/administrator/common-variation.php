<?php
    $page_title = "Common Variation";
    $active_page = "common_variation";
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
<style>
  .bs-example{
      margin: 10px;
  }
  .accordion .fa{
      /*margin-right: 0.5rem;*/
  }
  .collap-title{
    cursor: not-allowed;
    padding: 10px;
    font-size: 14px !important
  }
</style>

<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Product Manager</li>
      <li class="breadcrumb-item active" aria-current="page">Common Variation</li>
    </ol>
  </nav>

  <?php if(isset($_GET["add"]) && $_GET["add"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      FeatureVariation successfully added
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Feature category successfully deleted
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["error"]) && $_GET["error"] == 'variation-name') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Oops!!!</strong> Variation name already available.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  
  <div class="row">
    <div class="col-xl-5 grid-margin">
      <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>product_manager/add_variation" enctype="multipart/form-data">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Add Variation</h6>

            <div class="form-group">
              <label for="category">Select Category*</label>
              <select class="form-control custom-select" name="category" required>
                <option hidden>-- Select --</option>
                <?php foreach ($categories as $category): ?>
                  <option value="<?=$category->cat_slug?>"><?=$category->cat_name?></option>
                <?php endforeach ?>
              </select>
            </div>


            <div class="form-group">
              <label>Name*</label>
              <input type="text" class="form-control" name="variationName" placeholder="eg: Size">
            </div>

            <div class="form-group">
              <label>Value <small class="text-danger">separate each with comma (,)</small></label>
              <textarea class="form-control" rows="7" name="variationValues" placeholder="e.g S, M, XL etc"></textarea>
            </div>


            <div class="text-center mt-5 mb-5">
              <button type="submit" class="btn btn-primary p-3">Set Variation</button>
            </div>
          </div>
        </div>
      </form>
    </div>


    <div class="col-xl-7 grid-margin">
      <input type="hidden" name="default_favicon" value="<?=$webSettting->favicon_url?>">
      <div class="card">
        <div class="card-body pl-0 pr-0">
          <h6 class="card-title pl-4">All Banners (<?=count($features)?>)</h6>

          <div class="bs-example">
            <div class="accordion" id="accordionExample">

              <?php foreach ($allVariations as $variation): $count += 1; ?>
              <div class="card">
                <div class="card-header p-0" id="heading<?=$count?>" style="background: #bed3b5">

                  <div class="collap-title" data-toggle="collapse" data-target="#collapse<?=$count?>">
                    <div class="d-flex justify-content-between">
                      <div style="width: 70%">
                        <i class="fa fa-plus"></i> 
                        <?=ucwords(Settings::onlyString($variation->category))?>
                      </div>
                      <div>
                        <?=CustomDateTime::dateFrmatAlt($variation->created_at)?>
                      </div>
                      <div>
                        <button onclick="dVariation(<?=$variation->category?>)" class="btn btn-danger btn-sm" style="padding: 3px !important"><i class="fa fa-trash"></i></button>
                      </div>
                    </div>
                  </div>

                </div>
                <div id="collapse<?=$count?>" class="collapse <?php if($count == 1) { echo "show"; } ?>" aria-labelledby="heading<?=$count?>" data-parent="#accordionExample">
                  <div class="card-body p-0">

                    <?php $decode = json_decode($variation->value_obj); ?>

                    <div class="bs-example">
                      <div class="accordion" id="theChildAccordion<?=$count?>">

                        <?php foreach ($decode as $d): $childCount += 1; ?>
                        <div class="card p-0 mb-0" style="border: 1px solid #ccc">
                          <div class="card-header p-0" id="headingOne<?=$childCount?>" style="background: #f5f5f5">
                            <div class="collap-title" data-toggle="collapse" data-target="#collapseOne<?=$childCount?>">

                              <div class="d-flex justify-content-between">
                                <div>
                                  <i class="fa fa-plus" style="font-size: 11px"></i> <?=$d->name?>
                                </div>
                                <div>
                                  <button onclick="dVariation(<?=$variation->category?>)" class="btn btn-danger btn-sm" style="padding: 3px !important"><i class="fa fa-trash" style="font-size: 13px"></i></button>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div id="collapseOne<?=$childCount?>" class="collapse" aria-labelledby="headingOne<?=$childCount?>" data-parent="#theChildAccordion<?=$count?>">
                            <div class="card-body p-3">
                              <?php foreach ($d->values as $value): ?>
                                <span class="badge badge-primary"><?=$value?></span>
                              <?php endforeach ?>
                            </div>
                          </div>
                        </div>
                        <?php endforeach ?>
                          
                      </div>
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
  function dVariation(category) {
    console.log("kkk");
    // $("#delBannerModal").modal();
    // document.getElementById("inputId").value = featID;
  }
</script>

<script>
  $(document).ready(function(){
      // Add minus icon for collapse element which is open by default
      $(".collapse.show").each(function(){
        $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
      });
      
      // Toggle plus minus icon on show hide of collapse element
      $(".collapse").on('show.bs.collapse', function(){
        $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
      }).on('hide.bs.collapse', function(){
        $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
      });
  });
</script>
</body>
</html>