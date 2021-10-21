<?php
    $page_title = "Edit Products";
    $active_page = "pro_manager";
    include("includes/header.php");
    $proNav = 'pro-cat';
?>
<link rel="stylesheet" type="text/css" href="<?=$this_folder?>assets/css/simplemde.min.css">
<style>
  .availCat{
    background: blue; padding: 5px 10px; color: #fff;
  }

  .form-wrapper{
    border: 1px solid #ccc;
  }

  .form-wrapper .form-control{
    height: 45px; 
    border: 2px solid #ccc; 
    border-radius: 5px;
  }
  .subcat, .subcatchild{
    display: none;
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
              <form method="post" action="<?=Config::ADMIN_BASE_URL()?>product_manager/update_product_details">

                <div class="form-wrapper card card-body">
                
                  <input type="hidden" name="category" id="categoryValue" value="<?=$product->category?>">
                  <input type="hidden" name="pid" value="<?=$product->pid?>">

                  <div class="form-group">
                    <label>Category </label>
                    <select class="form-control custom-select" onchange="catClick(this)">
                      <option hidden label="--- Select Category ---"></option>
                      <option hidden value="<?=$theCat?>" selected><?=ucwords(Settings::onlyString($theCat))?></option>
                      <?php foreach ($categories as $cat): ?>
                      <option value="<?=$cat->cat_slug?>,<?=$cat->cat_id?>"><?=$cat->cat_name?></option>
                      <?php endforeach ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Sub Category</label>
                    <select class="form-control custom-select" onchange="subcatClick(this)">
                      <option hidden label="--- Select Category ---"></option>
                      <option hidden value="<?=$theSub_cat?>" selected><?=ucwords(Settings::onlyString($theSub_cat))?></option>
                      <?php foreach ($subCategories as $subCat): ?>
                      <option class="subcat subcat_<?=$subCat->cat_id?>" value="<?=$subCat->subcat_slug?>,<?=$subCat->subcat_id?>"><?=$subCat->subcat_name?></option>
                      <?php endforeach ?>
                    </select>
                  </div>


                  <div class="form-group">
                    <label>Sub Category Child</label>
                    <select class="form-control custom-select" onchange="childClick(this)">
                      <option hidden label="--- Select Category ---"></option>
                      <option hidden value="<?=$theSub_sub_cat?>" selected><?=ucwords(Settings::onlyString($theSub_sub_cat))?></option>
                      <?php foreach ($subChildCategories as $child): ?>
                      <option class="subcatchild subchild_<?=$child->subcat_id?>" value="<?=$child->sub_subcat_slug?>,<?=$child->subcat_id?>"><?=$child->sub_subcat_name?></option>
                      <?php endforeach ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" value="<?=$product->name?>" class="form-control">
                  </div>

                  <div class="form-group">
                    <label>Subtitle</label>
                    <input type="text" name="sub_title" value="<?=$product->sub_title?>" class="form-control">
                  </div>

                  <div class="form-group">
                    <label>Condition</label>
                    <select class="form-control custom-select" name="pro_condition">
                      <option hidden label="--- Select Condition ---"></option>
                      <option <?php if($product->pro_condition == 'New') { ?> selected <?php } ?> value="New">New</option>
                      <option <?php if($product->pro_condition == 'Used') { ?> selected <?php } ?> value="Used">Used</option>
                      <option <?php if($product->pro_condition == 'Refurbish') { ?> selected <?php } ?> value="Refurbish">Refurbish</option>
                    </select>
                  </div>            
                </div>



                <!-- <div class="form-wrapper card card-body mt-5">
                  <div class="specifications">
                    <h4 class="text-muted">Product Image</h4>

                    
                  </div>
                </div> -->




                <div class="form-wrapper card card-body mt-5">
                  <div class="specifications">
                    <h4 class="text-muted">Specification of Item</h4>

                    <div class="row mt-4">
                      <div class="col-xl-6">
                        <div class="form-group">
                          <label>Brand</label>
                          <select name="brand" class="form-control custom-select">
                            <option hidden label="--- Select Brand ---"></option>

                            <?php foreach ($getVariation as $variation): ?>
                              <?php if(strtolower($variation->name) == 'brand') { ?>
                              
                              <?php foreach ($variation->values as $value): ?>
                                <option <?php if(trim($product->brand) == trim($value)) {?> selected <?php } ?> value="<?=$variation->name?>,<?=$value?>"><?=$value?></option>
                              <?php endforeach ?>

                              <?php } ?>
                            <?php endforeach ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-xl-6">
                        <div class="form-group">
                          <label>Size Type</label>
                          <input type="text" name="size" class="form-control" placeholder="optional" value="<?=$product->size?>">
                        </div>
                      </div>

                      <div class="col-xl-6">
                        <div class="form-group">
                          <label>Material</label>
                          <input type="text" name="material" placeholder="optional" class="form-control" value="<?=$product->material?>">
                        </div>
                      </div>

                      <div class="col-xl-6">
                        <div class="form-group">
                          <label>Country of Manufacture</label>
                          <select class="form-control custom-select" name="manufacture_country">
                            <option hidden label="--- Select Country ---"></option>
                            <?php foreach ($countries as $country): ?>
                            <option <?php if($product->manufacture_country == $country) { ?> selected <?php } ?> value="<?=trim($country)?>"><?=trim($country)?></option>  
                            <?php endforeach ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-xl-12">
                        <label>Features</label>
                        <?php if(count($features) < 1) { ?>
                        <div class="form-group">
                          <input type="text" name="features" class="form-control">
                        </div>
                        <?php } ?>

                        <div id="featureWrap" class="featureDel">

                          <?php foreach ($features as $feat): $count += 1; ?>
                          <div class="removeFirstBank input-group mb-3">
                            <input type="text" class="form-control" name="theFeatures[<?=$count-1?>][feature]" value="<?=$feat->feature?>">
                            <div class="input-group-append">
                              <button class="btn btn-danger deleteFirstbank" type="button"><i class="fa fa-trash"></i></button>
                            </div>
                          </div>
                          <?php endforeach ?>
                          
                        </div>

                        <div class="pointer text-danger" id="moreFeatures"><i class="fa fa-plus"></i> <b>Add More Features</b></div>
                      </div>


                      <div class="col-xl-12">
                        <div class="form-group mt-5">
                          <h5 class="text-muted">Give Additional Description of the Item</h5>
                         <label class="text-muted">Buyers may be interested in more information about the item</label>
                          <textarea class="form-control" name="description" id="tinymceExampleDesc" rows="10"><?=$product->description?></textarea>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>


                <div class="text-center mt-5">
                  <button class="btn btn-primary rounded-0 pt-3 pb-3">SAVE AND CONTINUE</button>
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
  
  <script src="https://www.nobleui.com/html/template/assets/vendors/tinymce/tinymce.min.js"></script>

  <!-- inject:js -->
  <script src="<?=$this_folder?>/assets/js/feather.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/template.js"></script>
  <!-- endinject -->

  <script src="<?=$this_folder?>/assets/js/tinymce.js"></script>
  <script src="<?=$this_folder?>/assets/js/simplemde.js"></script>
  <script src="<?=$this_folder?>/assets/js/ace.js"></script>


<script>

  //add more features function
  $(document).ready(function(){

    var countFirst = <?=count($features) - 1?>;
    var countUse = 0;

    
    $('#moreFeatures').click(function(){
      countFirst++;
      countUse = countFirst;
        
      $('#featureWrap').append('<div class="removeFirstBank input-group mb-3"><input type="text" class="form-control" name="theFeatures['+countUse+'][feature]"><div class="input-group-append"><button class="btn btn-danger deleteFirstbank" type="button"><i class="fa fa-trash"></i></button></div></div>'); 
    }); 

    $('.featureDel').on("click", ".deleteFirstbank", function(e) {
        e.preventDefault();
        $(this).parents('.removeFirstBank').remove();
        countFirst--;
    });

    


  });

  //category select functions
  function catClick(event) {
    var defSubCat = document.querySelectorAll('.subcat');
    for (var i = 0; i < defSubCat.length; i++) {
      defSubCat[i].style.display = 'none';
    }
    var defSubCat = document.querySelectorAll('.subcatchild');
    for (var i = 0; i < defSubCat.length; i++) {
      defSubCat[i].style.display = 'none';
    }
    var catID = event.value.split(',')[1];
    var allSubCat = document.querySelectorAll('.subcat_'+catID);
    for (var i = 0; i < allSubCat.length; i++) {
      allSubCat[i].style.display = 'block';
    }
    document.getElementById("categoryValue").value = event.value.split(',')[0];
  }
  function subcatClick(event) {
    var defSubCat = document.querySelectorAll('.subcatchild');
    for (var i = 0; i < defSubCat.length; i++) {
      defSubCat[i].style.display = 'none';
    }
    var subcatID = event.value.split(',')[1];
    var allSubCat = document.querySelectorAll('.subchild_'+subcatID);
    for (var i = 0; i < allSubCat.length; i++) {
      allSubCat[i].style.display = 'block';
    }
    var cat = document.getElementById("categoryValue").value;
    document.getElementById("categoryValue").value = cat+','+event.value.split(',')[0];
  }
  function childClick(event) {
    var cat = document.getElementById("categoryValue").value;
    document.getElementById("categoryValue").value = cat+','+event.value.split(',')[0];
  }
</script>

</body>
</html>