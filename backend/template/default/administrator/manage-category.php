<?php
    $page_title = "Manage Category";
    $active_page = "manage_cat";
    include("includes/header.php");
?>
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/dataTables.bootstrap4.css">

<style>
  .table td{
    padding: 3px 10px !important;
  }
  .topCat{
    background: #dff0d8
  }
  .sub-topCat{
    background: #f4f8fb
  }
</style>

<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Product Manager</li>
      <li class="breadcrumb-item active" aria-current="page">Manage Category</li>
    </ol>
  </nav>

  <?php if(isset($_GET["added"]) && $_GET["added"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      <strong>Successful</strong> Category successfully added
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>
  

  <?php if(isset($_GET["category"]) && $_GET["category"] == 'delete') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      <strong>Category</strong> successfully deleted
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  
  <div class="row">
    <div class="col-xl-5 grid-margin">
      <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>product_manager/add_category" enctype="multipart/form-data">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Add New Category</h6>
            <div class="form-group">
              <label for="category">Name*</label>
              <input type="text" class="form-control" id="category" name="category" required>
            </div>

            <div class="form-group">
              <label for="category">Parent*</label>
              <select class="form-control custom-select" name="parentCategory" required onchange="checkCat(this)">
                <option hidden>-- Select --</option>
                <option value="parent">PARENT</option>
                <?php foreach ($categories as $category): ?>
                  <option style="font-size: 17px; font-weight: bolder;" value="<?=$category['mainCats']->level?>,<?=$category['mainCats']->cat_id?>"><?=$category['mainCats']->cat_name?></option>

                  <?php foreach ($category['Subcategories'] as $subcategory): ?>
                    <option style="font-size: 15px; font-weight: 550; font-style: italic;" value="<?=$subcategory['Subcategory']->level?>,<?=$subcategory['Subcategory']->subcat_id?>">- <?=$subcategory['Subcategory']->subcat_name?></option>

                    <?php foreach ($subcategory['SubSubcategories'] as $subSub): ?>
                      <option disabled>- - <?=$subSub->sub_subcat_name?></option>
                    <?php endforeach ?>
                  <?php endforeach ?>
                <?php endforeach ?>
              </select>
            </div>
            <style>
              .hiddenInput{
                display: none;
              }
            </style>

            <div class="hiddenInput form-group">
              <label>Category Description</label>
              <input type="text" name="cat_desc" class="form-control">
            </div>

            <div class="hiddenInput form-group">
              <label>Category Image</label>
              <div class="custom-file">
                <input type="file" name="cat_img" class="custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
            </div>


            <div class="form-group">
              <label for="mobile_icon">Mobile Icon</label>
              <input type="text" class="form-control" id="mobile_icon" name="mobile_icon" placeholder="Optional">
            </div>

            <div class="form-group">
              <label for="web_icon">Web Icon</label>
              <input type="text" class="form-control" id="web_icon" name="web_icon" placeholder="Optional">
            </div>

            <div class="text-center mt-5 mb-5">
              <button type="submit" class="btn btn-primary p-3">Add Category</button>
            </div>
          </div>
        </div>
      </form>
    </div>


    <div class="col-xl-7 grid-margin">
      <input type="hidden" name="default_favicon" value="<?=$webSettting->favicon_url?>">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">All Categories</h6>


          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Slug</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($categories as $category): ?>
                  <tr class="topCat">
                    <td><?=$category['mainCats']->cat_name?></td>
                    <td><?=$category['mainCats']->cat_slug?></td>
                    <td>
                      <button title="Delete Category" class="btn btn-danger btn-sm" onclick="deleteCategory(<?=$category['mainCats']->cat_id?>, 'category')">
                        <i class="fa fa-trash"></i> 
                      </button>  
                    </td>
                  </tr>

                  <?php foreach ($category['Subcategories'] as $subcategory): ?>
                    <tr class="sub-topCat">
                      <td>- <?=$subcategory['Subcategory']->subcat_name?></td>
                      <td><?=$subcategory['Subcategory']->subcat_slug?></td>
                      <td>
                        <button title="Delete Category" class="btn btn-danger btn-sm" onclick="deleteCategory(<?=$subcategory['Subcategory']->subcat_id?>, 'sub category')">
                          <i class="fa fa-trash"></i> 
                        </button>  
                      </td>
                    </tr>



                    <?php foreach ($subcategory['SubSubcategories'] as $subSub): ?>
                      <tr>
                        <td>- - <?=$subSub->sub_subcat_name?></td>
                        <td><?=$subSub->sub_subcat_slug?></td>
                        <td>
                          <button title="Delete Category" class="btn btn-danger btn-sm" onclick="deleteCategory(<?=$subSub->sub_subcat_id?>, 'sub category child')">
                            <i class="fa fa-trash"></i> 
                          </button>  
                        </td>
                      </tr>
                    <?php endforeach ?>
                  <?php endforeach ?> 

                  <!-- <option style="font-size: 17px; font-weight: bolder;" value="<?=$category['mainCats']->level?>,<?=$category['mainCats']->cat_id?>"><?=$category['mainCats']->cat_name?></option>

                  <?php foreach ($category['Subcategories'] as $subcategory): ?>
                    <option style="font-size: 15px; font-weight: 550; font-style: italic;" value="<?=$subcategory['Subcategory']->level?>,<?=$subcategory['Subcategory']->subcat_id?>">- <?=$subcategory['Subcategory']->subcat_name?></option>

                    <?php foreach ($subcategory['SubSubcategories'] as $subSub): ?>
                      <option disabled>- - <?=$subSub->sub_subcat_name?></option>
                    <?php endforeach ?>
                  <?php endforeach ?> -->
                <?php endforeach ?>
              </tbody>
            </table>
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

<div class="modal fade" id="deleteCatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Warning!!!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p>Are you sure you want to delete this <span id="askRole"></span> ?</p>

        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>product_manager/delete_category">
          <input type="hidden" name="theID" id="inputID">
          <input type="hidden" name="theRole" id="inputRole">

          <div class="mt-3 mb-3">
            <button class="btn btn-primary btn-sm mr-3" type="submit">YES</button>
            <button class="btn btn-danger btn-sm ml-3" type="button">NO</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

  <script src="<?=$this_folder?>/assets/js/core.js"></script>

  <script src="<?=$this_folder?>/assets/js/jquery.dataTables.js"></script>
  <script src="<?=$this_folder?>/assets/js/dataTables.bootstrap4.js"></script>

  <script src="<?=$this_folder?>/assets/js/feather.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/template.js"></script>

  <script src="<?=$this_folder?>/assets/js/data-table.js"></script>



  <script>
    function deleteCategory($getID, $role) {
      $("#deleteCatModal").modal();
      document.getElementById('inputID').value = $getID;
      document.getElementById('inputRole').value = $role;
      document.getElementById('askRole').innerHTML = $role;
    }


    function checkCat(event) {
      if (event.value == 'parent') {
        var hInput = document.querySelectorAll('.hiddenInput');
        for (var i = 0; i < hInput.length; i++) {
          hInput[i].style.display = 'block';
        }
      }
      console.log(event.value);
    }
  </script>
<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>
</body>
</html>