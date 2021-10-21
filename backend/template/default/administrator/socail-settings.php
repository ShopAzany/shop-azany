<?php
    $page_title = "Social Settings";
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
  .each-link{
    border-bottom: 1px solid #ccc;
    padding: 15px 0px;
  }
</style>

<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Socail Settings</li>
    </ol>
  </nav>

  <?php if(isset($_GET["add"]) && $_GET["add"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Social linkl <strong>successful</strong> added
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Social linkl <strong>successfully</strong> deleted
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["update"]) && $_GET["update"] == 'success') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Social linkl <strong>successfully</strong> updated
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>




  <section id="HowItWork">

    <div class="row">
      <div class="col-xl-6 mt-4">
        <div class="card">
          <div class="card-header">
            ADD SOCIAL LINK
          </div>

          <div class="card-body">
            <form method="post" action="<?=Config::ADMIN_BASE_URL()?>general_settings/add_social">
              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control">
              </div>

              <div class="form-group">
                <label>Icon</label>
                <input type="text" name="icon" class="form-control">
              </div>

              <div class="form-group">
                <label>Link</label>
                <input type="url" name="link" class="form-control">
              </div>

              <div class="mt-4 text-center">
                <button class="btn btn-success">ADD</button>
              </div>
            </form>
          </div>
        </div>
      </div>


      <div class="col-xl-6 mt-4">
        <div class="card">
          <div class="card-header">
            ALL SOCIAL LINKS
          </div>

          <div class="card-body">

            <?php foreach ($social_settings as $sos): ?>
            <div class="each-link">
              <div class="d-flex justify-content-between">
                <div class="mt-1"><h5><a href="<?=$sos->link?>" target="_blank"><?=$sos->name?></a></h5></div>
                <div>
                  <?php if($sos->status == 1) { ?>
                    <button class="btn btn-success btn-xs">Active</button>
                  <?php } else { ?>
                    <button class="btn btn-warning btn-xs">Pending</button>
                  <?php } ?>

                  <button id="notSubmitting" onclick="editSOS(<?=$sos->id?>)" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></button>

                  <button id="isSubmitting" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></button>

                  <button onclick="deleteSOS(<?=$sos->id?>)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                </div>
              </div>

              
            </div>  
            <?php endforeach ?>

          </div>
        </div>
      </div>
    </div>

  </section>

</div>



<!-- Edit How It work Modal -->
<div class="modal" id="editSOSModal">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Edit Social Setings</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>general_settings/update_social" enctype="multipart/form-data">
          
          <input type="hidden" name="id" id="sosID">

          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" id="nameID">
          </div>

          <div class="form-group">
            <label>Icon</label>
            <input type="text" name="icon" class="form-control" id="iconID">
          </div>

          <div class="form-group">
            <label>Link</label>
            <input type="text" name="link" class="form-control" id="linkID">
          </div>

          <div class="form-group">
            <p>Status</p>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" class="custom-control-input" id="active" name="status" value="1">
              <label class="custom-control-label" for="active">Active</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" class="custom-control-input" id="pending" name="status" value="0">
              <label class="custom-control-label" for="pending">Pending</label>
            </div>
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
        <p class="text-center">Are you sure you want to delete this Social link?</p>
        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>general_settings/delete_social" enctype="multipart/form-data">
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

function deleteSOS(arg) {
  document.getElementById('inputID').value = arg;
  $("#delModal").modal();
  console.log(arg);
}


function editSOS(sosID) {
  document.getElementById("isSubmitting").style.display = "inline";
  document.getElementById("notSubmitting").style.display = "none";
  console.log('ghjkl');

  $.ajax({
    url: "<?=Config::ADMIN_BASE_URL()?>general_settings/get_social/" + sosID,
    type: "Get",
    success: function(data){
      data = data.split('|');
      if(data && Number(data[0]) == 1) {
        document.getElementById("sosID").value = data[1];
        document.getElementById("nameID").value = data[2];
        document.getElementById("iconID").value = data[3];
        document.getElementById("linkID").value = data[4];
        if (data[5] == 1) {
          document.getElementById("active").checked = true;
        } else if(data[5] == 0){
          document.getElementById("pending").checked = true
        }
        

        $("#editSOSModal").modal();
      } else {
        window.alert('Oops, Error in getting your social settings content. Please try again');
      }
    }         
  });

  document.getElementById("isSubmitting").style.display = "none";
  document.getElementById("notSubmitting").style.display = "inline";
}
</script>
</body>
</html>