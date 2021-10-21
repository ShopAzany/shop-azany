<?php
    $page_title = "Manage Menu";
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
      <li class="breadcrumb-item active" aria-current="page">Manage Menu</li>
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

  <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
       Menu successfully removed from menu
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  
  <div class="row">
    <div class="col-xl-5 grid-margin">
      <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/add_menu" enctype="multipart/form-data">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Add Category to Navigation Menu</h6>
            <input type="hidden" name="role" value="category">
            <div class="form-group">
              <label for="category">Select Category*</label>
              <select class="form-control custom-select" name="category" required>
                <option hidden>-- Select --</option>
                <?php foreach ($categories as $category): ?>
                  <option value="<?=$category->cat_id?>"><?=$category->cat_name?></option>
                <?php endforeach ?>
              </select>
            </div>

            <div class="text-center mt-5 mb-5">
              <button type="submit" class="btn btn-primary p-3">Add Menu</button>
            </div>
          </div>
        </div>
      </form>


      <form class="forms-sample mt-5" method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/add_page" enctype="multipart/form-data">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Add Page to Navigation Menu</h6>
            <input type="hidden" name="role" value="page">
            <div class="form-group">
              <label for="category">Select Page*</label>
              <select class="form-control custom-select" name="page" required>
                <option hidden>-- Select --</option>
                <?php foreach ($pages as $page): ?>
                  <option value="<?=$page->id?>"><?=$page->title?></option>
                <?php endforeach ?>
              </select>
            </div>

            <div class="text-center mt-5 mb-5">
              <button type="submit" class="btn btn-primary p-3">Add Page</button>
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
            <table class="table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($menus as $menu): ?>

                  <?php if($menu->role == 'category') { ?>
                  <tr>
                    <td><?=$menu->cat_name?></td>
                    <td><?=$menu->role?></td>
                    <td>
                      <button onclick="deleteMenu(<?=$menu->id?>)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </td>
                  </tr>
                  <?php } ?>

                  <?php if($menu->role == 'page') { ?>
                  <tr>
                    <td><?=$menu->title?></td>
                    <td><?=$menu->role?></td>
                    <td>
                      <button onclick="deleteMenu(<?=$menu->id?>)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </td>
                  </tr>
                  <?php } ?>

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
        <p>Are you sure you want to remove this category from the menu?</p>

        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/delete_menu" class="mt-4">
          <input type="hidden" name="menuID" id="inputID">
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
    function deleteMenu(menuID) {
      $("#deleteModal").modal();
      document.getElementById('inputID').value = menuID;
    }
  </script>
</body>
</html>