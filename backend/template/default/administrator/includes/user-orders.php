

  <div>
    <h5 class="mb-4">User Orders</h5>

      <?php foreach($orders as $order) :?>  
      <div class="borderLine p-2 mb-4" style="background: #f2f2f2">
          <div class="row">    
              <div class="col-lg-2 col-md-2 mb-2">
                  <img class="card-img-top"  src="<?=str_replace('192.168.8.105', 'localhost', $order->product_json->featured_img)?>" alt="Card image cap" style="height: 100%; width: 100%; object-fit: contain;">
              </div>

              <div class="col-lg-8 col-md-8">
                  <h5 class="text-danger mt-4"><?=$order->product_json->name ?></h5>
                  <h5 class="mt-3">
                      <small>Placed On <span><?= CustomDateTime::dateFrmatAlt( $order->created_at) ?></span></small>
                  </h5>
                  <h5 class="mt-3">
                      <small>Status: 
                          <?php if($order->status == 'Delivered') { ?>
                              <span class="badge badge-success"><?=$order->status?></span>
                          <?php } else if($order->status == 'Cancelled'){ ?>
                              <span class="badge badge-danger"><?=$order->status?></span>
                          <?php } else if($order->status !== 'Delivered'&& $order->status !== 'Cancelled') { ?>
                              <span class="badge badge-info"><?=$order->status?></span>
                          <?php } ?>
                      </small>
                  </h5>
              </div>

              <div class="col-lg-2 col-md-2">
                 <h3 class="mt-5">
                      <a href="<?=Config::ADMIN_BASE_URL()?>order_manager/order/<?=$order->order_number?>" class="btn btn-primary btn-sm">Full Details</a>
                  </h3>
              </div>                   
          </div>
      </div>
      <?php endforeach; ?>

  </div>