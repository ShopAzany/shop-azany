

<form method="post" action="<?=Config::ADMIN_BASE_URL()?>seller_manager/update_seller_profile" enctype="multipart/form-data">
  <div>
    <h5 class="mb-4">Seller Profile</h5>
  </div>
  <div class="row">
    <div class="col-xl-6">
      <div class="form-group">
        <label>First Name</label>
        <input type="hidden" name="sellerID" value="<?=$seller->seller_id?>">
        <input type="text" name="first_name" class="form-control" value="<?=$seller->first_name?>">
      </div>
    </div>

    <div class="col-xl-6">
      <div class="form-group">
        <label>Last Name</label>
        <input type="text" name="last_name" class="form-control" value="<?=$seller->last_name?>">
      </div>
    </div>

    <div class="col-xl-6">
      <div class="form-group">
        <label>Email</label>
        <input type="text" name="email" class="form-control" value="<?=$seller->email?>">
      </div>
    </div>

    <div class="col-xl-6">
      <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" value="<?=$seller->phone?>">
      </div>
    </div>

    <div class="col-xl-6">
      <div class="form-group">
        <label>Date of Birth</label>
        <input type="date" name="date_of_birth" class="form-control" value="<?=$seller->date_of_birth?>">
      </div>
    </div>

    <div class="col-xl-12">
      <div class="form-group">
        <div class="card mt-3">
          <input type="hidden" name="default_photo" value="<?=$seller->photo?>">
          <div class="card-body p-2">
            <h6 class="card-title">Change Photo</h6>
            <?php if($seller->photo) { ?>
            <input type="file" id="myDropify" class="border" name="photo" data-default-file="<?=$seller->photo?>"/>
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