<?php
    $page_title = "Customers";
    $active_page = "customer";
    include("includes/header.php");
?>
<link rel="stylesheet" href="<?=$this_folder?>/assets/css/dataTables.bootstrap4.css">



    <div class="page-content">

      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">All Customers</li>
        </ol>
      </nav>

      <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
          Admin deleted successfully
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      <?php } ?>

      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h6 class="card-title">All <?=ucwords($role)?> Customers</h6>

              <div class="table-responsive">
                <table id="dataTableExample" class="table">
                  <thead>
                    <tr>
                      <th>S/N</th>
                      <th>Full Name</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Signup Date</th>
                      <th>Status</th>
                      <th>View</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($users as $user): $count += 1; ?>
                    <tr>
                      <td>
                        <?=$count?>
                      </td>
                      <td><?=ucwords($user->full_name)?></td>
                      <td><?=$user->phone?></td>
                      <td><?=$user->email?></td>
                      <td><?=CustomDateTime::dateFrmatAlt($user->created_at)?></td>
                      <td>
                        <?php if($user->status == 'Active') { ?>
                          <span class="badge badge-success" style="padding-top: 3px">Active</span>
                        <?php } else if($user->status == 'Pending') { ?>
                          <span class="badge badge-warning" style="padding-top: 3px">Pending</span>
                        <?php } else if($user->status == 'Blocked' || $user->status == 'Suspended') { ?>
                          <span class="badge badge-danger" style="padding-top: 3px"><?=$user->status?></span>
                        <?php } ?>
                      </td>
                      <td>
                        <?php if($admin->id != 1) { ?>
                          <a class="btn btn-primary btn-sm" href="<?=Config::ADMIN_BASE_URL()?>customer_manager/details/<?=$user->login_id?>"><i class="fa fa-eye"></i></a>
                          
                        <?php } ?>
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
        <p>Are you sure you want to delete this admin?</p>

        <form method="post" class="mt-4" action="<?=Config::ADMIN_BASE_URL()?>admin_manager/delete_admin">
          <input type="hidden" name="adminID" id="inputId">
          <button class="btn btn-danger btn-sm mr-3" type="submit">YES</button>
          <button class="btn btn-success btn-sm ml-3" type="button" data-dismiss="modal">NO</button>
        </form>
      </div>
    </div>
  </div>
</div>


  <!-- core:js -->
  <script src="<?=$this_folder?>/assets/js/core.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="<?=$this_folder?>/assets/js/jquery.dataTables.js"></script>
  <script src="<?=$this_folder?>/assets/js/dataTables.bootstrap4.js"></script>
  <!-- end plugin js for this page -->
  <!-- inject:js -->
  <script src="<?=$this_folder?>/assets/js/feather.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/template.js"></script>
  <!-- endinject -->
  <!-- custom js for this page -->
  <script src="<?=$this_folder?>/assets/js/data-table.js"></script>
  <!-- end custom js for this page -->


  <script>
    function deleteAdmin(adminID) {
      $("#deleteModal").modal();
      document.getElementById("inputId").value = adminID;
    }
  </script>
</body>
</html>