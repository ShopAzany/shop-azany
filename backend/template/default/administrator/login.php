<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    $webset = WebsiteSettings::first();
  ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Logoin</title>
    <!-- core:css -->
    <link rel="stylesheet" href="<?=$this_folder?>/assets/css/core.css">
    <!-- endinject -->
  <!-- plugin css for this page -->
    <!-- end plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?=$this_folder?>/assets/css/iconfont.css">
    <link rel="stylesheet" href="<?=$this_folder?>/assets/css/flag-icon.min.css">
    <!-- endinject -->
  <!-- Layout styles -->  
    <link rel="stylesheet" href="<?=$this_folder?>/assets/css/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="<?=$webset->favicon_url?>" />
</head>
<body class="sidebar-dark">
    <div class="main-wrapper">
      <div class="page-wrapper full-page">

        <div class="page-content d-flex align-items-center justify-content-center">

          <div class="row w-100 mx-0 auth-page">
            <div class="col-md-8 col-xl-6 mx-auto">

              <?php if(isset($_GET["error"]) && $_GET["error"] == 'true') { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Oops!!!</strong> Email and password does not matched
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
              <?php } ?>

              <div class="card">
                <div class="row">
                  <div class="col-md-4 pr-md-0">
                    <div class="auth-left-wrapper"></div>
                  </div>
                  <div class="col-md-8 pl-md-0">
                    <div class="auth-form-wrapper px-4 py-5">
                      
                      <a href="#" class="noble-ui-logo d-block mb-2">
                        <img src="<?=$webset->logo_url?>" width="120">
                      </a>
                      <h5 class="text-muted font-weight-normal mb-4">Welcome back! Log in to your account.</h5>
                      <form class="forms-sample" method="post" action="<?=Config::ADMIN_BASE_URL()?>login/authenticate">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Email address</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Email or Username" name="admin">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">Password</label>
                          <input type="password" class="form-control" id="exampleInputPassword1" autocomplete="current-password" name="password" placeholder="Password">
                        </div>

                        <div class="mt-5">
                          <button class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">LOGIN</button>
                          <!-- <button type="button" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                            <i class="btn-icon-prepend" data-feather="twitter"></i>
                            Login with twitter
                          </button> -->
                          <a href="register.html" class="mt-3 text-muted float-right">Forgot Password</a>
                        </div>
                        
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- core:js -->
    <script src="<?=$this_folder?>/assets/js/core.js"></script>
    <!-- endinject -->
  <!-- plugin js for this page -->
    <!-- end plugin js for this page -->
    <!-- inject:js -->
    <script src="<?=$this_folder?>/assets/js/feather.min.js"></script>
    <script src="<?=$this_folder?>/assets/js/template.js"></script>
    <!-- endinject -->
  <!-- custom js for this page -->
    <!-- end custom js for this page -->
</body>
</html>