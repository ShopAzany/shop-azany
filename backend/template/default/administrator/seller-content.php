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

  <?php if(isset($_GET["update"]) && $_GET["update"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Your update is <strong>successful</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      How it work <strong>successfully</strong> deleted
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>


  <section id="bannerSection" class="mb-5">
    <div class="row">
      <div class="col-xl-6">
        <div class="banner-form">
          <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/updateSellInfo" enctype="multipart/form-data">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Banner Contents</h6>
                <input type="hidden" name="id" value="1">
                <div class="form-group">
                  <label>Title</label>
                  <input type="text" name="title" class="form-control" value="<?=$ban->title?>">
                </div>
                <div class="form-group">
                  <label>Sub title</label>
                  <textarea rows="7" class="form-control" name="sub_title"><?=$ban->sub_title?></textarea>
                </div>
                <div class=" mt-3">
                  <h6 class="card-title">Banner</h6>
                  <input type="hidden" name="default_banner" value="<?=$ban->banner?>">
                  <input type="file" id="myDropifyTwo" class="border" name="banner" data-default-file="<?=$ban->banner?>"/>
                </div>
                <div class="text-center mt-5">
                  <button class="btn btn-primary pt-3 pb-3">UPDATE BANNER INFO</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="col-xl-6">
        <div class="banner-form">
          <div class="card">
            <div class="card-body">
              <h6 class="card-title">Banner Details</h6>

              <div class="bannWrap">
                <img src="<?=$ban->banner?>" width="100%">

                <h4 class="mt-3"><?=$ban->title?></h4>
                <p><?=$ban->sub_title?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>





  <section id="HowItWork">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">How It Works <button class="float-right btn btn-primary" data-toggle="modal" data-target="#addHowWork">Add More</button></h6>

        <div class="row mt-5">
          <?php foreach ($howItWorks as $how): ?>
          <div class="col-xl-4">
            <div class="card card-footer hwBox">
              <div class="img-wrap text-center">
                <img src="<?=$how->banner?>">
              </div>
              <h6 class="text-center mt-2"><?=$how->title?></h6>
              <p class="text-justify"><?=$how->sub_title?></p>

              <div class="text-center mt-2">
                <button class="btn btn-primary btn-sm" id="notSubmitting" onclick="editHowWork(<?=$how->id?>)"><i class="fa fa-edit"></i></button>
                <button class="btn btn-primary btn-sm" id="isSubmitting"><i class="fa fa-spin fa-spinner"></i></button>
                <button class="btn btn-danger btn-sm" onclick="deleteHowWork(<?=$how->id?>)"><i class="fa fa-trash"></i></button>
              </div>
            </div>
          </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </section>




  <section id="explore" class="mt-5">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Explore</h6>

        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/updateSellInfo" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?=$explore->id?>">
          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?=$explore->title?>">
          </div>

          <div class="row d-flex justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-8 col-sm-10">
              <div class="form-group">
                <input type="hidden" name="default_banner" value="<?=$explore->banner?>">
                <label>Banner</label>
                <input type="file" id="myDropifyDefImgAdmin" class="border" name="banner" data-default-file="<?=$explore->banner?>"/>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="footer">Contents</label>
            <textarea class="form-control" name="sub_title" id="tinymceExample" rows="10"><?=$explore->sub_title?></textarea>
          </div>

          <div class="text-center mt-5">
            <button class="btn btn-primary pt-2 pb-2">UPDATE</button>
          </div>
        </form>
      </div>
    </div>
  </section>


</div>


<!-- Add How It work Modal -->
<div class="modal" id="addHowWork">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add How It Works</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/add_how_it_work" enctype="multipart/form-data">
          
          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control">
          </div>

          <div class="form-group">
            <label>Content</label>
            <textarea rows="6" class="form-control" name="sub_title"></textarea>
          </div>

          <div class="form-group">
            <label>Add Image</label>
            <input type="file" id="myDropifyDefImgAdmin" class="border" name="banner" data-default-file=""/>
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
        <h4 class="modal-title">Edit How It Works</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/updateSellInfo" enctype="multipart/form-data">
          
          <input type="hidden" name="id" id="howItWorkID">
          <input type="hidden" name="default_banner" id="defImgID">

          <div class="text-center">
            <img src="" id="imgPreview">
          </div>

          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" id="titleID">
          </div>

          <div class="form-group">
            <label>Content</label>
            <textarea rows="6" class="form-control" name="sub_title" id="contentID"></textarea>
          </div>

          <div class="form-group">
            <label>Add Image</label>
            <input type="file" id="myDropifyRightBanner" class="border" name="banner" data-default-file=""/>
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
        <p class="text-center">Are you sure you want to delete this how it work?</p>
        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/deleteHowWork" enctype="multipart/form-data">
          <input type="hidden" name="howID" id="inputID">
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
    url: "<?=Config::ADMIN_BASE_URL()?>content_manager/get_how_work_detail/" + hwID,
    type: "Get",
    success: function(data){
      data = data.split('|');
      if(data && Number(data[0]) == 1) {
        document.getElementById("titleID").value = data[1];
        document.getElementById("contentID").value = data[2];
        document.getElementById("defImgID").value = data[3];
        document.getElementById("imgPreview").src = data[3];
        document.getElementById("howItWorkID").value = data[4];

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