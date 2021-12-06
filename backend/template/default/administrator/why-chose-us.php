<?php
    $page_title = "Seller Content";
    $active_page = "gen_set";
    include("includes/header.php");
?>
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/dropzone.min.css">
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/dropify.min.css">
<link rel="stylesheet" type="text/css" href="<?=$this_folder?>assets/css/simplemde.min.css">

<style>
  .file-icon p{
    font-size: 17px !important
  }
  .hwBox{
    background: #f2f2f2; 
    border: 1px solid #ccc
  }
  #isSubmitting{
    display: none;
  }
</style>

<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Seller Contents</li>
    </ol>
  </nav>

  <?php if(isset($_GET["status"]) && $_GET["status"] == 'added') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Why chose us is <strong>successful</strong> added
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["status"]) && $_GET["status"] == 'deleted') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Why chose <strong>successfully</strong> deleted
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["status"]) && $_GET["status"] == 'updated') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Why chose <strong>successfully</strong> updated
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>




  <section id="HowItWork">
    <div class="card">
      <div class="card-body p-2">
        <div class="d-flex justify-content-between">
          <div><h6 class="card-title mb-0 mt-2">How It Works</h6></div>
          <div>
            <button class="float-right btn btn-primary" data-toggle="modal" data-target="#addHowWork">Add More</button>
          </div>
        </div>
      </div>
    </div>


    <div class="row mt-5">
      <?php foreach ($whyUs as $why): ?>
      <div class="col-xl-12 mb-3">
        <div class="card card-body p-3">
            <h6 class="mt-2"><span><?=$why->svg?></span> <?=$why->title?></h6>
            <p class="text-justify mt-3"><?=$why->content?></p>

            <div class="d-flex justify-content-between mt-4">
              <div>Posted On: <b><?=CustomDateTime::dateFrmatAlt($why->created_at)?></b></div>

              <div>
                <button class="btn btn-primary btn-sm" id="notSubmitting" onclick="editHowWork(<?=$why->id?>)"><i class="fa fa-edit"></i></button>
                <button class="btn btn-primary btn-sm" id="isSubmitting"><i class="fa fa-spin fa-spinner"></i></button>
                <button class="btn btn-danger btn-sm" onclick="deleteHowWork(<?=$why->id?>)"><i class="fa fa-trash"></i></button>
              </div>
            </div>
        </div>
      </div>
      <?php endforeach ?>
    </div>


  </section>

</div>


<!-- Add How It work Modal -->
<div class="modal" id="addHowWork">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Add Why Chose Us</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/addWhyChoseUs" enctype="multipart/form-data">
          
          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control">
          </div>

          <div class="form-group">
            <label>SVG Icon</label>
            <textarea rows="6" class="form-control" name="svg"></textarea>
          </div>

          <div class="form-group">
            <label>Content</label>
            <textarea rows="6" class="form-control" name="content"></textarea>
          </div>

          <div class="text-center mt-4">
            <button class="btn btn-primary pt-2 pb-2">Add</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>







<!-- Edit How It work Modal -->
<div class="modal" id="editHowWork">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Edit How It Works</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/updateWhyChoseUs" enctype="multipart/form-data">
          
          <input type="hidden" name="id" id="whyID">

          <div class="text-center">
            <img src="" id="imgPreview">
          </div>

          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" id="titleID">
          </div>

          <div class="form-group">
            <label>SVG Icon</label>
            <textarea rows="6" class="form-control" name="svg" id="svgID"></textarea>
          </div>

          <div class="form-group">
            <label>Content</label>
            <textarea rows="6" class="form-control" name="content" id="contentID"></textarea>
          </div>

          <div class="text-center mt-4">
            <button class="btn btn-primary pt-2 pb-2">Update</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>


<!-- The Modal -->
<div class="modal" id="delModal">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning!!!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p class="text-center">Are you sure you want to delete this why chose us?</p>
        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/deleteWhyChoseUs" enctype="multipart/form-data">
          <input type="hidden" name="id" id="inputID">
          <div class="text-center mt-4">
            <button class="btn btn-success mr-3 btn-sm" type="submit">YES</button>
            <button class="btn btn-danger ml-3 btn-sm" type="button" data-dismiss="modal">NO</button>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>



<?php
    include("includes/footer.php");
?>
  
    </div>
  </div>

  <script src="<?=$this_folder?>/assets/js/core.js"></script>
  <script src="<?=$this_folder?>/assets/js/dropzone.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/dropify.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/feather.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/template.js"></script>

  <script src="<?=$this_folder?>/assets/js/dropzone.js"></script>
  <script src="<?=$this_folder?>/assets/js/dropify.js"></script>

  <script src="https://www.nobleui.com/html/template/assets/vendors/tinymce/tinymce.min.js"></script>

  <script src="<?=$this_folder?>/assets/js/simplemde.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/ace.js"></script>
  <script src="<?=$this_folder?>/assets/js/theme-chaos.js"></script>

  <script src="<?=$this_folder?>/assets/js/tinymce.js"></script>
  <script src="<?=$this_folder?>/assets/js/simplemde.js"></script>
  <script src="<?=$this_folder?>/assets/js/ace.js"></script>

<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});


function deleteHowWork(arg) {
  document.getElementById('inputID').value = arg;
  $("#delModal").modal();
  console.log(arg);
}


function editHowWork(hwID) {
  document.getElementById("isSubmitting").style.display = "inline";
  document.getElementById("notSubmitting").style.display = "none";

  $.ajax({
    url: "<?=Config::ADMIN_BASE_URL()?>content_manager/get_why_chose_us/" + hwID,
    type: "Get",
    success: function(data){
      data = data.split('|');
      if(data && Number(data[0]) == 1) {
        document.getElementById("titleID").value = data[1];
        document.getElementById("svgID").value = data[2];
        document.getElementById("contentID").value = data[3];
        document.getElementById("whyID").value = data[4];

        $("#editHowWork").modal();
      } else {
        window.alert('Oops, Error in getting your how it works content. Please try again');
      }
    }         
  });

  document.getElementById("isSubmitting").style.display = "none";
  document.getElementById("notSubmitting").style.display = "inline";
}
</script>
</body>
</html>