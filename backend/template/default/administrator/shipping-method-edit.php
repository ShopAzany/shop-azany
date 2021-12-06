<?php
    $page_title = "Edit Payment gateway";
    $active_page = "";
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
<style>
  .bs-example{
      margin: 10px;
  }
  .accordion .fa{
      /*margin-right: 0.5rem;*/
  }
  .collap-title{
    cursor: not-allowed;
    padding: 10px;
    font-size: 14px !important
  }
  .table td img{
    width: 100%;
    height: unset;
    border-radius: 0px;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: blue;
    border: 1px solid blue;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 5px;
    padding: 5px;
    font-size: 12px;
  }
</style>

<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>other_manager/shipping_method">Shipping Method</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit Shipping Method</li>
    </ol>
  </nav>

  <?php if(isset($_GET["update"]) && $_GET["update"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Shipping method successfully updated
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>



  
  <div class="row">
    <div class="col-xl-5 grid-margin">
      <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>other_manager/update_shipping_method" enctype="multipart/form-data">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Edit Method</h6>
            <input type="hidden" name="id" value="<?=$method->id?>">

            <div class="form-group">
              <label>Courier name*</label>
              <input type="text" class="form-control" name="name" value="<?=$method->name?>">
            </div>

            <div class="form-group">
              <label>Select Country</label>
              <select class="js-example-basic-multiple w-100" multiple="multiple" data-width="100%" name="country[]">
                <option label="-- Select Country ---"></option>
                <?php foreach (array_filter(explode(',', $method->country)) as $coun): ?>
                <option selected value="<?=$coun?>"><?=$coun?></option>
                <?php endforeach ?>

                <?php foreach ($countries as $country): ?>
                  <option value="<?=$country?>"><?=$country?></option>
                <?php endforeach ?>
              </select>
            </div>


            <div class="form-group">
              <label>Price*</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><?=$curr->symbol?></span>
                </div>
                <input type="text" class="form-control" placeholder="Price" name="price" value="<?=$method->price?>">
                <div class="input-group-append">
                  <span class="input-group-text">0.0</span>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Description*</label>
              <textarea class="form-control" rows="7" name="description" required><?=$method->description?></textarea>
            </div>

            <div class="form-group">
              <input type="hidden" name="defcourierLogo" value="<?=$method->url?>">
              <p>Gate Icon</p>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="courierLogo">
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
            </div>


            <div class="text-center mt-5 mb-5">
              <button type="submit" class="btn btn-primary">UPDATE</button>
            </div>
          </div>
        </div>
      </form>
    </div>


    <div class="col-xl-7 grid-margin">
      <input type="hidden" name="default_favicon" value="<?=$webSettting->favicon_url?>">
      <div class="card">
        <div class="card-body pl-0 pr-0">
          <h6 class="card-title pl-4">All Methods</h6>

          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th style="width: 60px">Logo</th>
                  <th>Courier Name</th>
                  <th>Price</th>
                  <th>Status</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>
                    <?php if($method->url) { ?>
                      <img src="<?=$method->url?>" width="100%">
                    <?php } else { ?>
                      No Icon
                    <?php } ?>
                  </td>

                  <td><?=$method->name?></td>
                  <td><?=number_format($method->price)?></td>
                  <td>
                    <?php if($method->status == 1) { ?>
                      <span class="badge badge-success">Active</span>
                    <?php } else { ?>
                      <span class="badge badge-danger">Pending</span>
                    <?php } ?>
                  </td>
                </tr>
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


<div class="modal" id="delPayModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning!!!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Are you sure you want to delete this payment method?</p>

        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>other_manager/delete_pay_method">
          <input type="hidden" name="payID" id="inputId">
          <button class="btn btn-danger btn-sm mr-3" type="submit">YES</button>
          <button class="btn btn-success btn-sm ml-3" type="button" data-dismiss="modal">NO</button>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal" id="actionFunc">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning!!!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Are you sure you want to <span id="callRole"></span> this payment method?</p>

        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>other_manager/pay_method_action">
          <input type="hidden" name="payID" id="inputIdRole">
          <input type="hidden" name="pay_role" id="roleInput">
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
  function doAction(payID, role) {
    $("#actionFunc").modal();
    document.getElementById("inputIdRole").value = payID;
    document.getElementById("roleInput").value = role;
    document.getElementById("callRole").innerHTML = role;
  }

  function deletePayMethod(payID) {
    $("#delPayModal").modal();
    document.getElementById("inputId").value = payID;
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