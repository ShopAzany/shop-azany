

<form method="post" action="<?=Config::ADMIN_BASE_URL()?>customer_manager/update_user_profile" enctype="multipart/form-data">
  <div>
    <h5 class="mb-4">User Profile</h5>
  </div>
  <div class="row">
    <div class="col-xl-6">
      <div class="form-group">
        <label>Full Name</label>
        <input type="hidden" name="loginID" value="<?=$user->login_id?>">
        <input type="text" name="full_name" class="form-control" value="<?=$user->full_name?>">
      </div>
    </div>

    <div class="col-xl-6">
      <div class="form-group">
        <label>Email</label>
        <input type="text" name="email" class="form-control" value="<?=$user->email?>">
      </div>
    </div>

    <div class="col-xl-6">
      <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" value="<?=$user->phone?>">
      </div>
    </div>

    <div class="col-xl-6">
      <div class="form-group">
        <label>Gender</label>
        <select class="form-control custom-select" name="gender">
          <option <?php if($user->gender == 'male') {?> selected <?php } ?> value="male">Male</option>
          <option <?php if($user->gender == 'female') {?> selected <?php } ?> value="female">Female</option>
        </select>
      </div>
    </div>

    <div class="col-xl-12">
      <div class="form-group">
        <div class="card mt-3">
          <input type="hidden" name="default_photo" value="<?=$user->photo?>">
          <div class="card-body p-2">
            <h6 class="card-title">Change Photo</h6>
            <?php if($user->photo) { ?>
            <input type="file" id="myDropify" class="border" name="photo" data-default-file="<?=$user->photo?>"/>
            <?php } else { ?>
            <input type="file" id="myDropifyTwo" class="border" name="photo" data-default-file="<?=$this_folder?>/assets/images/profile-default.png"/>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="text-center mb-4 mt-4">
    <button class="btn btn-primary">Update Profile</button>
  </div>
</form>