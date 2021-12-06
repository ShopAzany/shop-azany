<?php
    $page_title = "Payment gateway";
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
</style>

<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Payment Gateway</li>
    </ol>
  </nav>

  <?php if(isset($_GET["add"]) && $_GET["add"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Payment gateway successfully added
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["update"]) && $_GET["update"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Payment gateway successfully updated
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      payment gateway successfully deleted
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>


  
  <div class="row">
    <div class="col-xl-5 grid-margin">
      <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>other_manager/add_pay_method" enctype="multipart/form-data">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Add Method</h6>

            <div class="form-group">
              <label>Name*</label>
              <input type="text" class="form-control" name="name">
            </div>

            <div class="form-group">
              <label for="type">Type*</label>
              <select class="form-control custom-select" name="type" required>
                <option hidden>-- Select Type--</option>
                <option>Bank</option>
                <option>On Delivery</option>
                <option>Online</option>
              </select>
            </div>

            <div class="form-group">
              <label for="gateway">Gateway*</label>
              <select class="form-control custom-select" name="gateway" required>
                <option hidden>-- Select Gateway--</option>
                <option value="bank">Bank</option>
                <option value="cash">Cash</option>
                <option value="gtpay">GTPay</option>
                <option value="paystack">Paystack</option>
                <option value="voguepay">Voguepay</option>
                <option value="paypal">Paypal</option>
                <option value="2checkout">2checkout</option>
                <option value="alipay">Alipay</option>
              </select>
            </div>


            <div class="form-group">
              <label>Mer ID</label>
              <input type="text" class="form-control" name="mer_id">
            </div>

            <div class="form-group">
              <label>Mer Code</label>
              <input type="text" class="form-control" name="mer_code">
            </div>


            <div class="form-group">
              <label>Bearer</label>
              <input type="text" class="form-control" name="bearer">
            </div>

            <div class="form-group">
              <label>Description</label>
              <textarea class="form-control" rows="7" name="descr"></textarea>
            </div>

            <div class="form-group">
              <p>Gate Icon</p>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="gate_icon">
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
            </div>


            <div class="text-center mt-5 mb-5">
              <button type="submit" class="btn btn-primary p-3">SUBMIT</button>
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
                  <th style="width: 250px">Logo</th>
                  <th>Title</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($getPayMethod as $method): ?>
                <tr>
                  <td>
                    <?php if($method->url) { ?>
                      <img src="<?=$method->url?>" width="100%">
                    <?php } else { ?>
                      No Icon
                    <?php } ?>
                  </td>

                  <td><?=$method->name?></td>
                  <td>
                    <?php if($method->status == 1) { ?>
                      <span class="badge badge-success">Active</span>
                    <?php } else { ?>
                      <span class="badge badge-danger">Pending</span>
                    <?php } ?>
                  </td>
                  <td>
                    <a href="<?=Config::ADMIN_BASE_URL()?>other_manager/edit_payment_gateway/<?=$method->id?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                    <?php if($method->status == 1) { ?>
                      <button onclick="doAction(<?=$method->id?>, 'disable')" class="btn btn-dark btn-sm">Disable Now</button>
                    <?php } else { ?>
                      <button onclick="doAction(<?=$method->id?>, 'activate')" class="btn btn-primary btn-sm">Activate Now</button>
                    <?php } ?>
                    <button onclick="deletePayMethod(<?=$method->id?>)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                  </td>
                </tr>
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