

  <div>
    <h5 class="mb-4">User Addresses</h5>

    <div class="row">

      <?php foreach ($addresses as $addr): ?>
      <div class="col-xl-6">
        <div class="card card-body p-0" style="box-shadow: none; border-color: #ccc">
          <div class="address-wrap p-3">
            <h5 class="mb-3" style="font-weight: lighter;"><?=$addr->full_name?></h5>
            <p><?=$addr->street_addr?>, <?=$addr->city?>, <?=$addr->state?></p>
          </div>
          <div class="card-footer p-2" style="border-color: #ccc">
            <div class="d-flex justify-content-between">
              <div>
                <?php if($addr->add_status == 1) { ?>
                  <span class="text-muted">Default Address</span>
                <?php } else { ?>              
                    <span onclick="setAsDefault(<?=$addr->id?>)" class="text-success set-cursor">Set As Default</span>
                <?php } ?>
              </div>

              <div>
                <button onclick="editAddress(<?=$addr->id?>)" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></button>
              </div>
            </div>
            
          </div>
        </div>
      </div>
      <?php endforeach ?>
      
    </div>
  </div>