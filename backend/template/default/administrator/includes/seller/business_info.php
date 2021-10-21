
<style>
  .dropify-infos-message{
    font-size: 10px !important
  }
</style>
<form method="post" action="<?=Config::ADMIN_BASE_URL()?>seller_manager/update_business_info" enctype="multipart/form-data">
  <div>
    <h5 class="mb-4">Business Information</h5>
  </div>
  <div class="row">
    <div class="col-xl-12">
      <input type="hidden" name="sellerID" value="<?=$seller->seller_id?>">
      <input type="hidden" name="busID" value="<?=$bus_info->id?>">

      <div class="form-group">
        <label>Business Name</label>
        <input type="text" name="biz_name" class="form-control" value="<?=$bus_info->biz_name?>">
      </div>
    </div>

    <div class="col-xl-12">
      <div class="form-group">
        <label>Business Type</label>

        <div class="custom-control custom-radio">
          <input <?php if($bus_info->biz_type == 'Individual') { ?> checked <?php } ?> type="radio" class="custom-control-input" id="customRadio" name="biz_type" value="Individual">
          <label class="custom-control-label" for="customRadio">Individual</label>
        </div>

        <div class="custom-control custom-radio">
          <input <?php if($bus_info->biz_type == 'Registered') { ?> checked <?php } ?> type="radio" class="custom-control-input" id="customRadio" name="biz_type" value="Registered">
          <label class="custom-control-label" for="customRadio">Registered Business Name</label>
        </div>

        <div class="custom-control custom-radio">
          <input <?php if($bus_info->biz_type == 'Company') { ?> checked <?php } ?> type="radio" class="custom-control-input" id="customRadio" name="biz_type" value="Company">
          <label class="custom-control-label" for="customRadio">Company</label>
        </div>
      </div>
    </div>

    <div class="col-xl-12">
      <div class="form-group">
        <label>Business Address</label>
        <input type="text" name="biz_address" class="form-control" value="<?=$bus_info->biz_address?>">
      </div>
    </div>

    <div class="col-xl-12">
      <div class="form-group">
        <label>Alternative Address</label>
        <input type="text" name="alternative_address" class="form-control" value="<?=$bus_info->alternative_address?>">
      </div>
    </div>

    <div class="col-xl-6">
      <div class="form-group">
        <label>City</label>
        <input type="text" name="city" class="form-control" value="<?=$bus_info->city?>">
      </div>
    </div>

    <div class="col-xl-6">
      <div class="form-group">
        <label>Country</label>
        <select class="form-control custom-select" name="country">
          <option hidden label="--- Select Country ---"></option>
          <?php foreach ($countries as $country): ?>
          <option <?php if($bus_info->country == $country) { ?> selected <?php } ?> value="<?=$country?>"><?=$country?></option>  
          <?php endforeach ?>
        </select>
      </div>
    </div>

    <div class="col-xl-6">
      <div class="form-group">
        <label>Zip Code</label>
        <input type="text" name="zip_code" class="form-control" value="<?=$bus_info->zip_code?>">
      </div>
    </div>

    <div class="col-xl-6">
      <div class="form-group">
        <label>Business Registration Number</label>
        <input type="text" name="biz_reg_number" class="form-control" value="<?=$bus_info->biz_reg_number?>">
      </div>
    </div>

    <div class="col-xl-6"></div>


    <div class="col-xl-12">
      <div class="form-group">
        <div class="card mt-3">
          <input type="hidden" name="defcartificate" value="<?=$bus_info->biz_certificate?>">
          <div class="card-body p-2">
            <h6 class="card-title">Business Certificate</h6>
            <input type="file" id="myDropifyTwo" class="border" name="biz_certificate" data-default-file="<?=$bus_info->biz_certificate?>"/>
          </div>
        </div>
      </div>
    </div>






  </div>

  <div class="text-center mb-4 mt-4">
    <button class="btn btn-primary">Update Business Info</button>
  </div>
</form>