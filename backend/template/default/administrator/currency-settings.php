<?php
    $page_title = "Currency Settings";
    $active_page = "gen_set";
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
      <li class="breadcrumb-item active" aria-current="page">Currency Settings</li>
    </ol>
  </nav>

  <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Currency successfully deleted
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["add"]) && $_GET["add"] == 'success') { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      Currency successfully added
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["set"]) && $_GET["set"] == 'success') { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      Currency successfully set as default
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  
  <div class="row">
    <div class="col-md-6 grid-margin">
      <div class="card">
        <div class="card-body">
          <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>general_settings/add_currency" enctype="multipart/form-data">
            <h6 class="card-title">Add Currency</h6>
            <div class="form-group">
              <label for="country">Country</label>
              <input type="text" class="form-control" id="country" autocomplete="off" name="country">
            </div>

            <div class="form-group">
              <label for="code">Code</label>
              <input type="text" class="form-control" id="code" name="code">
            </div>

            <div class="form-group">
              <label for="symbol">Symbol</label>
              <input type="text" class="form-control" id="symbol" name="symbol">
            </div>


            <div class="text-center mt-5 mb-3">
              <button type="submit" class="btn btn-primary p-3">Add Currency</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <div class="col-md-6 grid-margin">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">All Currency</h6>
          
          <ul class="list-group list-group-flush">
            <?php foreach ($allCurrencies as $curr): ?>
            <li class="list-group-item">
              <div class="d-flex justify-content-between">
                <div>
                  <?=$curr->country?> (<?=$curr->code?>) => <?=$curr->symbol?>
                </div>
                <div>
                  <?php if($curr->c_default == 1) { ?>
                  <button class="btn btn-success btn-sm p-2">Default</button>
                  <?php } else { ?>
                  <button onclick="setDefault(<?=$curr->id?>)" class="btn btn-primary btn-sm p-2">Set as Default</button>
                  <?php } ?>
                  <button onclick="deleteCurrency(<?=$curr->id?>)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                </div>
              </div>
            </li> 
            <?php endforeach ?>
            
          </ul>
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

<div class="modal" id="deletCurrModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning!!!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Are you sure you want to delete this currency?</p>

        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>general_settings/del_currency">
          <input type="hidden" name="currID" id="inputId">
          <button class="btn btn-danger btn-sm mr-3" type="submit">YES</button>
          <button class="btn btn-success btn-sm ml-3" type="button" data-dismiss="modal">NO</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="defaultModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning!!!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Are you sure you want to set this currency as default?</p>

        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>general_settings/set_default">
          <input type="hidden" name="currID" id="inputIdDef">
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
  function deleteCurrency(currID) {
    $("#deletCurrModal").modal();
    document.getElementById("inputId").value = currID;
  }

  function setDefault(currID) {
    $("#defaultModal").modal();
    document.getElementById("inputIdDef").value = currID;
  }
</script>
</body>
</html>