<?php
    $page_title = "About Us";
    $active_page = "about";
    include("includes/header.php");
?>
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/select2.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/jquery.tagsinput.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/dropzone.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/dropify.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/bootstrap-colorpicker.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/tempusdominus-bootstrap-4.min.css">

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
      <li class="breadcrumb-item active" aria-current="page">Website Settings</li>
    </ol>
  </nav>

  <?php if(isset($_GET["update"]) && $_GET["update"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      <strong>Successful</strong> Website settings successfully updated
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager//update_about_us" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=$about->id?>">
    <div class="row">
      <div class="col-md-6 grid-margin">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">General Settings</h6>
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control" id="title" autocomplete="off" name="title" value="<?=$about->title?>">
            </div>

            <div class="form-group">
              <label for="site_name">Sub Title</label>
              <textarea class="form-control" rows="5" name="sub_title"><?=$about->sub_title?></textarea>
            </div>

            <div class="form-group">
              <label for="site_email">Vision</label>
              <textarea class="form-control" name="vision" id="tinymceExample" rows="10"><?=$about->vision?></textarea>
            </div>


            <div class="form-group">
              <label for="site_email">Mision</label>
              <textarea class="form-control" name="mission" id="tinymceExampleThird" rows="10"><?=$about->mission?></textarea>
            </div>


            <div class="form-group">
              <label for="site_email">What We Do</label>
              <textarea class="form-control" name="what_we_do" id="tinymceExampleDesc" rows="10"><?=$about->what_we_do?></textarea>
            </div>


            <div class="form-group">
              <label for="site_email">Who We Serve</label>
              <textarea class="form-control" name="who_we_serve" id="tinymceExampleTwo" rows="10"><?=$about->who_we_serve?></textarea>
            </div>

          </div>
        </div>
      </div>


      <div class="col-md-6 grid-margin">
        <input type="hidden" name="default_title_image" value="<?=$about->title_image?>">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Title Image</h6>
            <input type="file" id="myDropify" class="border" name="title_image" data-default-file="<?=$about->title_image?>" />
          </div>
        </div>


        <div class="card mt-3">
          <input type="hidden" name="default_what_we_do_image" value="<?=$about->what_we_do_image?>">
          <div class="card-body">
            <h6 class="card-title">What We Do Image</h6>
            <input type="file" id="myDropifyTwo" class="border" name="what_we_do_image" data-default-file="<?=$about->what_we_do_image?>"/>
          </div>
        </div>

        <div class="card mt-3">
          <input type="hidden" name="default_vision_image" value="<?=$about->vision_image?>">
          <div class="card-body">
            <h6 class="card-title">Vision Image</h6>
            <input type="file" id="myDropifyLeftBanner" class="border" name="vision_image" data-default-file="<?=$about->vision_image?>"/>
          </div>
        </div>

      </div>
    </div>


    <div class="text-center mt-5 mb-5">
      <button type="submit" class="btn btn-primary p-3">Update Settings</button>
    </div>

  </form>

</div>





<?php
    include("includes/footer.php");
?>
  
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

  <script src="https://www.nobleui.com/html/template/assets/vendors/tinymce/tinymce.min.js"></script>

  <script src="<?=$this_folder?>/assets/js/simplemde.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/ace.js"></script>
  <script src="<?=$this_folder?>/assets/js/theme-chaos.js"></script>


  <script src="<?=$this_folder?>/assets/js/tinymce.js"></script>
  <script src="<?=$this_folder?>/assets/js/simplemde.js"></script>
  <script src="<?=$this_folder?>/assets/js/ace.js"></script>



  <script src="<?=$this_folder?>/assets/js/feather.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/template.js"></script>

  <script>
    $(function() {
  'use strict';

  if ($("#tinymceExampleThird").length) {
    tinymce.init({
      selector: '#tinymceExampleThird',
      height: 400,
      theme: 'silver',
      plugins: [
        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen',
      ],
      toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
      toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
      image_advtab: true,
      templates: [{
          title: 'Test template 1',
          content: 'Test 1'
        },
        {
          title: 'Test template 2',
          content: 'Test 2'
        }
      ],
      content_css: []
    });
  }

  if ($("#tinymceExampleTwo").length) {
    tinymce.init({
      selector: '#tinymceExampleTwo',
      height: 400,
      theme: 'silver',
      plugins: [
        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen',
      ],
      toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
      toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
      image_advtab: true,
      templates: [{
          title: 'Test template 1',
          content: 'Test 1'
        },
        {
          title: 'Test template 2',
          content: 'Test 2'
        }
      ],
      content_css: []
    });
  }
  
});
  </script>


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


</body>
</html>