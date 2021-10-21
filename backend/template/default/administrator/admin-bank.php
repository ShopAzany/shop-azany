<?php
    $page_title = "Admin Banks";
    $active_page = "otherManager";
    include("includes/header.php");
?>

<style>
  .bank-body{
    box-shadow: none; 
    border-color: #ccc; 
    margin-bottom: 20px
  }
</style>


<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Banks</li>
    </ol>
  </nav>

  <?php if(isset($_GET["add"]) && $_GET["add"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Bank info added successfully
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Bank info successfully deleted
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>
  <?php if(isset($_GET["update"]) && $_GET["update"] == 'success') { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      Bank info successfully updated
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between mb-3">
        <div><h6 class="card-title">All Bank</h6></div>
        <div>
          <button data-toggle="modal" data-target="#addBank" class="btn btn-primary btn-sm">Add Bank</button>
        </div>
      </div>

      <div class="row">
        <?php foreach ($banks as $bank): ?>
        <div class="col-xl-4">
          <div class="card card-body bank-body p-2">
            <p style="font-size: 15px">Account Name: <b><?=strtoupper($bank->account_name)?></b></p>
            <p style="font-size: 15px">Account Number: <b><?=$bank->account_number?></b></p>
            <p style="font-size: 15px">Bank Name: <b><?=$bank->bank?></b></p>
            <p style="font-size: 15px">Account Type: <b><?=$bank->account_type?></b></p>
            <p style="font-size: 15px">Account Currency: <b><?=$bank->currency?></b></p>

            <div class="d-flex justify-content-between mt-3">
              <div>
                <button class="btn btn-primary btn-sm" onclick="editBank(<?=$bank->id?>)"><i class="fa fa-edit"></i></button>
              </div>
              <div>
                <button onclick="deleteBank(<?=$bank->id?>)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>

</div>





<?php
    include("includes/footer.php");
?>
  
    </div>
  </div>


<!-- delete modal( -->
<div class="modal" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning!!!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Are you sure you want to delete this bank?</p>

        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>other_manager/delete_bank" class="mt-4">
          <input type="hidden" name="bankID" id="inputID">
          <button class="btn btn-primary btn-sm mr-3" type="submit">YES</button>
          <button class="btn btn-danger btn-sm ml-3" data-dismiss="modal" type="button">NO</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Add modal( -->
<div class="modal" id="addBank">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Bank</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">

        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>other_manager/add_bank">
          <div class="form-group">
            <label class="pull-left">Currency</label>
            <input type="text" name="currency" class="form-control">
          </div>

          <div class="form-group">
            <label class="pull-left">Account Name</label>
            <input type="text" name="account_name" class="form-control">
          </div>

          <div class="form-group">
            <label class="pull-left">Account Number</label>
            <input type="text" name="account_number" class="form-control">
          </div>

          <div class="form-group">
            <label class="pull-left">Bank Name</label>
            <input type="text" name="bank" class="form-control">
          </div>

          <div class="form-group">
            <label class="pull-left">Account Type</label>
            <input type="text" name="account_type" class="form-control">
          </div>

          <div class="modal-footer text-center">
            <button type="submit" class="btn btn-primary pb-2">ADD BANK</button>
          </div>
        </form>
        

      </div>
    </div>
  </div>
</div>


<!-- Edit modal( -->
<div class="modal" id="editModal">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Bank</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">

        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>other_manager/update_bank">
          <div id="fullInfo"></div>

          <div class="modal-footer text-center">
            <button type="submit" class="btn btn-primary pb-2">UPDATE BANK</button>
          </div>
        </form>
        

      </div>
    </div>
  </div>
</div>
  

  <script src="<?=$this_folder?>/assets/js/core.js"></script>


  <script src="<?=$this_folder?>/assets/js/feather.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/template.js"></script>


  <script>
    function deleteBank(getID) {
      document.getElementById('inputID').value = getID;
      $("#deleteModal").modal();
    }

    function editBank(getID) {
      $.ajax({
          url: "<?=Config::ADMIN_BASE_URL()?>other_manager/get_bank/" + getID,
          type: "Get",

          success: function(data){
            if(Number(data) !== 0) {
              document.getElementById("fullInfo").innerHTML = data;
              $("#editModal").modal();
            }
          }         
        });
    }
  </script>
</body>
</html>