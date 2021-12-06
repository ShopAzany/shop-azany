<?php
    $page_title = "Edit Email Template";
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
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>content_manager/email_template">Email Template</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit Email Template</li>
    </ol>
  </nav>

  <?php if(isset($_GET["update"]) && $_GET["update"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Email template successfully updated
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  


  <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/update_email_template" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Edit Email Template</h6>
            <input type="hidden" name="emailID" value="<?=$email->id?>">
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control" id="title" autocomplete="off" name="title" value="<?=$email->title?>">
            </div>

            <div class="form-group">
              <label for="site_name">Content</label>
              <textarea class="form-control" name="content" id="tinymceExample" rows="10"><?=$email->content?></textarea>
            </div>



            <div class="form-group">
              <label for="footer">Footer</label>
              <textarea rows="6" class="form-control" id="footer" autocomplete="off" name="footer"><?=$email->footer?></textarea>
            </div>


            <div class="text-center mt-5 mb-3">
              <button type="submit" class="btn btn-primary p-3">Update Email</button>
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

</body>
</html>