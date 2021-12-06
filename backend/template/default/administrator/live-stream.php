<?php
    $page_title = "Three Grid Image";
    $active_page = "home_product";
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
  .videoOption{
    display: none;
  }
  .playBtn{
    width: 60px;
    height: 40px;
    background: rgba(0, 0, 0, 0.7);
    color: #fff;
    font-size: 22px;
    text-align: center;
    border-radius: 10px;
    padding-top: 9px;
    cursor: pointer;
    position: absolute;
    top: 40%;
  }
  .all-vid-wrap{
    position: relative;
  }
  .playBtn:hover{
    background: red;
  }
  .videoWrap{
    background: #000;
  }
  .videoWrap:hover .playBtn{
    background: red !important;
    /*display: none;*/
  }
</style>

<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>home_product">Home Product</a></li>
      <li class="breadcrumb-item active" aria-current="page">Live Stream</li>
    </ol>
  </nav>

  <?php if(isset($_GET["status"]) && $_GET["status"] == 'added') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Live stream successfully added
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>


  <?php if(isset($_GET["status"]) && $_GET["status"] == 'delete') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Video successfully deleted.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  
  <div class="row">

    <div class="col-xl-12 mb-5">
      <div class="card">
        <div class="card-header">
          
          <div class="d-flex justify-content-between">
            <div><h6 class="card-title mb-0">Live Stream</h6></div>
            <div>
              <form method="post" action="<?=Config::ADMIN_BASE_URL()?>home_product/status_action">
                <input type="hidden" name="product_type" value="live_stream">
                <div class="custom-control custom-switch">
                  <input type="checkbox" <?php if($home_pro->live_stream == 'Enabled') { ?> checked <?php } ?> name="action" class="custom-control-input" id="switch1" onchange="form.submit()">
                  <label class="custom-control-label" for="switch1"><?php if($home_pro->live_stream == 'Enabled') { ?> Enabled <?php } else { ?> Disabled <?php } ?></label>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-body">
          


          <div class="row">
            <div class="col-xl-5">
              <div class="card card-header">
                <h6 class="card-title mb-3">Add Video</h6>

                <form method="post" action="<?=Config::ADMIN_BASE_URL()?>home_product/add_live_stream" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="country">Title</label>
                    <input type="text" name="title" class="form-control" required>
                  </div>

                  <div class="form-group">
                    <label>Video Type</label>
                    <select class="form-control custom-select" name="video_type" onchange="selectChange(this)" required>
                      <option hidden label="--- Select ---"></option>
                      <option value="local">Upload From File</option>
                      <option value="youtube">Youtube Video</option>
                    </select>
                  </div>

                  <div class="form-group videoOption">
                    <label>Upload Video</label>
                    <input type="file" class="border" id="myDropifyTwo" name="local_vid" />
                  </div>

                  <div class="form-group videoOption">
                    <label>Video Url</label>
                    <textarea rows="5" class="form-control" name="video_url" id="field">https://www.youtube.com/embed/</textarea>
                  </div>

                  <div class="text-center mt-5">
                    <button class="btn btn-primary pt-3 pb-3">ADD VIDEO</button>
                  </div>
                </form>
              </div>
            </div>


            <div class="col-xl-7">
              <div class="row">
                
                <?php foreach ($allVideos as $vid): ?>
                  <div class="col-xl-6 mb-3">
                    <div style="border: 1px solid #ccc; padding: 5px">
                      <?php if($vid->type == 'youtube') { ?>
                        <iframe width="100%" height="205" src="https://www.youtube.com/embed/<?=$vid->url?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                      <?php } else { ?>

                        <div class="all-vid-wrap">
                          <div class="d-flex justify-content-center">
                            <i class="fa fa-play playBtn" id="playIcon<?=$vid->id?>" onclick="playThisVid(<?=$vid->id?>)"></i>
                          </div>
                          <video id="myVideo<?=$vid->id?>" class="videoWrap" onclick="toPause(<?=$vid->id?>)" width="100%" height="205" autoplay>
                            <source src="<?=$vid->url?>" type="video/mp4">
                            Your browser does not support the video tag.
                          </video>
                        </div>
                      <?php } ?>
                      <p class="text-center mt-2 mb-2"><?=$vid->title?></p>

                      <div class="d-flex justify-content-center">
                        <div>
                          <button onclick="deletHomeBan(<?=$vid->id?>)" class="btn btn-danger">Delete</button>
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


<div class="modal" id="delHomeBanModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning!!!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Are you sure you want to delete this video?</p>

        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>home_product/delete_vid">
          <input type="hidden" name="vidID" id="inputIdcatBan">
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

  function deletHomeBan(vidID) {
    $("#delHomeBanModal").modal();
    document.getElementById("inputIdcatBan").value = vidID;
  }

  function selectChange(event) {
    if (event.value == 'local') {
      document.querySelectorAll('.videoOption')[0].style.display = 'block';
      document.querySelectorAll('.videoOption')[1].style.display = 'none';
    } else if(event.value == 'youtube'){
      document.querySelectorAll('.videoOption')[0].style.display = 'none';
      document.querySelectorAll('.videoOption')[1].style.display = 'block';
    }
  }



  var readOnlyLength = $('#field').val().length;
  $('#output').text(readOnlyLength);

  $('#field').on('keypress, keydown', function(event) {
      var $field = $(this);
      $('#output').text(event.which + '-' + this.selectionStart);
      if ((event.which != 37 && (event.which != 39))
          && ((this.selectionStart < readOnlyLength)
          || ((this.selectionStart == readOnlyLength) && (event.which == 8)))) {
          return false;
      }
  });  


  function playThisVid(id) { 
    var myVideo = document.getElementById("myVideo"+id); 
    if (myVideo.paused) {
      document.getElementById("playIcon"+id).style.display = 'none';
      myVideo.play(); 
    } else {
      myVideo.pause(); 
      document.getElementById("playIcon"+id).style.display = 'inline';
    }
  } 

  function toPause(id) { 
    var myVideo = document.getElementById("myVideo"+id); 
    if (myVideo.paused) {
      document.getElementById("playIcon"+id).style.display = 'none';
      myVideo.play(); 
    } else {
      myVideo.pause(); 
      document.getElementById("playIcon"+id).style.display = 'inline';
    }
  } 
</script>
</body>
</html>