<?php
    $page_title = "All Pages";
    $active_page = "con_manager";
    include("includes/header.php");
?>
<link rel="stylesheet" type="text/css" href="<?=$this_folder?>assets/css/simplemde.min.css">

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
      <li class="breadcrumb-item active" aria-current="page">Pages</li>
    </ol>
  </nav>

  <?php if(isset($_GET["update"]) && $_GET["update"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Page content successfully updated
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  


  <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/update_page" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Edit <?=$page->title?></h6>
            <input type="hidden" name="pageID" value="<?=$page->id?>">
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control" id="title" autocomplete="off" name="title" value="<?=$page->title?>">
            </div>

            <div class="form-group">
              <label for="sub_title">Sub Title</label>
              <input type="text" class="form-control" id="sub_title" autocomplete="off" name="sub_title" value="<?=$page->overview?>">
            </div>

            <div class="row">
              <div class="col-xl-5">
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control custom-select" name="status">
                    <option <?php if($page->status == 1) { ?> selected <?php } ?> value="1">Active</option>
                    <option <?php if($page->status == 0) { ?> selected <?php } ?> value="0">Pending</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="site_name">Content</label>
              <textarea class="form-control" name="contents" id="tinymceExample" rows="10"><?=$page->contents?></textarea>
            </div>


            <div class="text-center mt-5 mb-3">
              <button type="submit" class="btn btn-primary p-3">Update Settings</button>
            </div>
          </div>
        </div>
      </div>


    </div>

  </form>
      





<?php
    include("includes/footer.php");
?>
  
    </div>
  </div>




  <script src="<?=$this_folder?>/assets/js/core.js"></script>
  <!-- <script src="<?=$this_folder?>/assets/js/tinymce.min.js"></script> -->
  <script src="https://www.nobleui.com/html/template/assets/vendors/tinymce/tinymce.min.js"></script>

  <script src="<?=$this_folder?>/assets/js/simplemde.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/ace.js"></script>
  <script src="<?=$this_folder?>/assets/js/theme-chaos.js"></script>


  <script src="<?=$this_folder?>/assets/js/feather.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/template.js"></script>

  <script src="<?=$this_folder?>/assets/js/tinymce.js"></script>
  <script src="<?=$this_folder?>/assets/js/simplemde.js"></script>
  <script src="<?=$this_folder?>/assets/js/ace.js"></script>



  <script>
    function deleteSlide(slideID) {
      $("#deleteModal").modal();
      document.getElementById('inputID').value = slideID;
    }
  </script>
</body>
</html>