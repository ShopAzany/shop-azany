
<style>
  .dropify-infos-message{
    font-size: 10px !important
  }
</style>
<form method="post" action="<?=Config::ADMIN_BASE_URL()?>seller_manager/update_bank_info" enctype="multipart/form-data">
  <div>
    <h5 class="mb-4">Bank Information</h5>
  </div>
  <div class="row">
    <div class="col-xl-6">
      <input type="hidden" name="sellerID" value="<?=$seller->seller_id?>">
      <input type="hidden" name="shop_name" value="<?=$seller->shop_name?>">
      <input type="hidden" name="busID" value="<?=$bank_info->id?>">

      <div class="form-group">
        <label>Account Name</label>
        <input type="text" name="account_name" class="form-control" value="<?=$bank_info->account_name?>">
      </div>
    </div>

    <div class="col-xl-6">
      <div class="form-group">
        <label>Account Number</label>
        <input type="text" name="account_number" class="form-control" value="<?=$bank_info->account_number?>">
      </div>
    </div>

    <div class="col-xl-6">
      <div class="form-group">
        <label>Bank Name</label>
        <input type="text" name="bank_name" class="form-control" value="<?=$bank_info->bank_name?>">
      </div>
    </div>

    <div class="col-xl-6">
      <div class="form-group">
        <label>Account Type</label>
        <input type="text" name="account_type" class="form-control" value="<?=$bank_info->account_type?>">
      </div>
    </div>


  </div>

  <div class="text-center mb-4 mt-4">
    <button class="btn btn-primary">Update Bank</button>
  </div>
</form>