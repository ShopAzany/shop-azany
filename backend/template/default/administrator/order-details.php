<?php
    $page_title = "Order Detail";
    $active_page = "orderManager";
    include("includes/header.php");
?>

<style>
  .file-icon p{
    font-size: 17px !important
  }
</style>


<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=Config::ADMIN_BASE_URL()?>">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?=ucwords($page)?> Orders</li>
    </ol>
  </nav>

  <?php if(isset($_GET["added"]) && $_GET["added"] == 'success') { ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      Slider successfully added
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>

  <?php if(isset($_GET["delete"]) && $_GET["delete"] == 'success') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Successful</strong> Slider deleted successfully
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  <?php } ?>



  <div class="">

    <div class="card">
        <div class="card-header">
          <p class="mb-0">
            <b style="color: black; font-weight:bold">Order #<?= $order->order_number ?></b>
          </p>
        </div>


        <div class="card-body">
          <div class=" mb-5">
            <h4><b style="color: black; font-weight:bold"><?= count($orders) ?> </b>Items </h4>
            <h4>Placed on <b><?= CustomDateTime::dateFrmatAlt($order->created_at)?></b></h4>
            <h4>Total: <b><?=$curr?><?=number_format($order->total)?></b></h4>
          </div>


          <?php foreach ($orders as $orderItem): ?>
            <div class="card border mt-4">
              <div class="card-header">
                <div class="row">
                  <div class="col-xl-4">
                    <div>
                      Status: <?=$orderItem->status?>
                    </div>
                  </div>

                  <div class="col-xl-8">
                    <div class="float-right">
                      <label>Update Status: </label>
                      <select class="" style="height: 30px; border: 1px solid #ccc; border-radius: 4px; width: 150px;" onchange="onSelect(this.value, <?=$orderItem->order_id?>, 'delivery')">
                        <option value="<?=$orderItem->status?>"><?=$orderItem->status?></option>

                        <?php if($orderItem->invoice_status == 'Paid') { ?>
                          <option value="Processing">Processing</option>
                          <option value="Shipped">Shipped</option>
                          <option value="Delivered">Delivered</option>
                          <option value="Returned">Returned</option>
                        <?php } ?>

                        <?php if($orderItem->invoice_status !== 'Paid' && $orderItem->invoice_status !== 'Refunded') { ?>
                          <option value="Cancelled">Cancelled</option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-body">
                <div class="bg-white border p-2">
                  <div class="row">    
                    <div class="col-xl-2 col-lg-2 col-md-2">
                        <img src="<?=$orderItem->product_json->featured_img?>" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>

                    <div class="col-xl-6 col-lg-7 col-md-8">
                        <h5 class="text-danger mt-3"><?=$orderItem->product_json->name?></h5>
                        <h5 class="mt-3">
                            <small>QTY: <?=$orderItem->quantity?> item(s)</small>
                        </h5>
                        <h5 class="mt-3">
                          <small><?=$curr?><?=number_format($orderItem->sub_total)?> |</small>

                            <small>Status: 
                                <?php if($orderItem->invoice_status == 'Paid') { ?>
                                    <span class="badge badge-success">Paid</span>
                                <?php } else if($orderItem->invoice_status == 'Pending'){ ?>
                                    <span class="badge badge-danger">Unpaid</span>
                                <?php } else if($orderItem->invoice_status == 'Refunded') { ?>
                                    <span class="badge badge-info">Refunded</span>
                                <?php } ?>
                            </small>
                        </h5>
                    </div>

                    <div class="col-lg-4 col-md-3 mt-3">

                      <div <?php if($orderItem->invoice_status !== 'Paid') { ?> onchange="onSelect('Paid', <?=$orderItem->order_id?>, 'payment')" <?php } ?> class="pl-0 custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="paid<?=$orderItem->order_id?>" <?php if($orderItem->invoice_status == 'Paid') { ?> checked <?php } ?> name="actionName<?=$orderItem->order_id?>">
                        <label class="custom-control-label" for="paid<?=$orderItem->order_id?>">Mark Paid</label>
                      </div>


                      <div <?php if($orderItem->invoice_status !== 'Refunded') { ?> onchange="onSelect('Refunded', <?=$orderItem->order_id?>, 'payment')" <?php } ?> class="pl-5 custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="refund<?=$orderItem->order_id?>" <?php if($orderItem->invoice_status == 'Refunded') { ?> checked <?php } ?> name="actionName<?=$orderItem->order_id?>">
                        <label class="custom-control-label" for="refund<?=$orderItem->order_id?>">Refund</label>
                      </div>

                      <div class="mt-5 ml-2">
                        <button class="btn btn-danger" onclick="geneSingleInvoice(<?=$orderItem->order_id?>, '<?=$orderItem->order_number?>')">Download and Print Invoice</button>
                        <!-- <a href="" class="btn btn-danger btn-sm">Download & Print Invoice</a> -->
                      </div>
                    </div>                   
                  </div>
                </div>
              </div>


              <div class="card-footer">
                <small><i class="fa fa-truck"></i> <?=$order->shipping_method?></small>
              </div>
            </div>
          <?php endforeach ?>



          <div class="pay_n_deliv mt-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card border">
                        <div class="card-header font-weight-bold p-3">
                            Payment Information
                        </div>
                        <div class="card-body">
                            <div class="top">
                                <div class="dave">Payment Method</div>
                                <div class="text">
                                  <small><b><?=ucwords($order->payment_method)?></b></small>
                                </div>
                            </div>
                            <div class="bottom mt-3">
                                <div class="dave">Payment Details</div>
                                <div class="text pb-1">
                                  <small><b>Item total: <?=$curr?><?=number_format($order->total)?></b></small>
                                </div>
                                <div class="text pb-1">
                                  <small><b>Shipping Fees: <?=$curr?><?=number_format($order->sum_shipping_fee)?></b></small>
                                </div>
                                <div class="text pb-1">
                                  <small><b>Total: <?=$curr?><?=number_format($order->grand_total)?></b></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border">
                        <div class="card-header font-weight-bold p-3">
                            Delivery Information
                        </div>
                        <div class="card-body">
                            <div class="top mb-3">
                                <div class="dave">Delivery Method</div>
                                <div class="text">
                                  <small>
                                    <b><?=$order->shipping_method?></b>
                                  </small>
                                </div>
                            </div>
                            <div class="bottom">
                                <div class="dave">Shipping Address</div>
                                <div class="text">
                                  <small><b><?=ucwords($shipping_addr->full_name)?></b></small>
                                </div>
                                <div class="text">
                                  <small><b><?=ucwords($shipping_addr->street_addr)?></b></small>
                                </div>
                                <div class="text">
                                  <small><b><?=ucwords($shipping_addr->state)?>, <?=ucwords($shipping_addr->country)?></b></small>
                                </div>
                                <div class="text">
                                  <small><b><?=$shipping_addr->phone?></b></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>

          <?php if($order->status == 'Cancelled') { ?>
            <div class="forAll mt-5">
              <hr>
              <div class="alert alert-secondary text-center">
                <b class="font-weight-bold">Order Cancelled!</b> You can not update Cancelled order
              </div>
            </div>
          <?php } ?>

          <?php if($order->status !== 'Cancelled') { ?>
          <div class="forAll mt-5">
            <hr>
            <div class="alert alert-danger">
              <b class="font-weight-bold">Warning!</b> Please note that any action taken here will applied to the entire items on this order.
            </div>

            <hr>

            <div class="row">
              <div class="col-xl-5">
                <div <?php if($order->invoice_status !== 'Paid') { ?> onchange="onSelectAll('Paid', '<?=$order->order_number?>', 'payment')" <?php } ?> class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="paidAll<?=$orderItem->order_id?>" <?php if($order->invoice_status == 'Paid') { ?> checked <?php } ?> name="actionNameAll<?=$orderItem->order_id?>">
                  <label class="custom-control-label" for="paidAll<?=$orderItem->order_id?>">Mark Paid</label>
                </div>


                <div <?php if($order->invoice_status == 'Paid' && $order->invoice_status !== 'Refunded') { ?> onchange="onSelectAll('Refunded', '<?=$order->order_number?>', 'payment')" <?php } ?> class="pl-5 custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="refundAll<?=$orderItem->order_id?>" <?php if($order->invoice_status == 'Refunded') { ?> checked <?php } ?> name="actionNameAll<?=$orderItem->order_id?>">
                  <label class="custom-control-label" for="refundAll<?=$orderItem->order_id?>"> Refund</label>
                </div>
              </div>


              <div class="col-xl-7">
                <div class="float-right">
                  <label>Update Status: </label>
                  <select class="" style="height: 30px; border: 1px solid #ccc; border-radius: 4px; width: 150px;" onchange="onSelectAll(this.value, '<?=$order->order_number?>', 'delivery')">
                    <option value="<?=$order->status?>"><?=$order->status?></option>

                    <?php if($order->invoice_status == 'Paid') { ?>
                      <option value="Processing">Processing</option>
                      <option value="Shipped">Shipped</option>
                      <option value="Delivered">Delivered</option>
                      <option value="Returned">Returned</option>
                    <?php } ?>

                    <?php if($order->invoice_status !== 'Paid' && $order->invoice_status !== 'Refunded') { ?>
                      <option value="Cancelled">Cancelled</option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="text-center mt-3">
              <button class="btn btn-danger" onclick="geneInvoice(<?=$order->order_id?>, '<?=$order->order_number?>')">Download and Print Invoice</button>
            </div>
          </div>
          <?php } ?>


        </div>
    </div>

  </div>

  
  
    

</div>


<!-- FOR SINGLE      -->
<div class="modal fade" id="statusModal">
  <div class="modal-dialog">
    <div class="modal-content">    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Are you sure you want to mark this order as <span id="statusQuestion"></span>?</p>

        <div class="text-center mt-4">
          <form method="post" action="<?=Config::ADMIN_BASE_URL()?>order_manager/update_status">
            <input type="hidden" name="status" id="statusInput">
            <input type="hidden" name="orderID" id="inputID">
            <input type="hidden" name="role" id="roleInput">

            <button class="btn btn-success btn-sm mr-3 rounded-0" type="submit">YES</button>
            <button class="btn btn-danger btn-sm ml-3 rounded-0" type="button" data-dismiss="modal">NO</button>
          </form>
        </div>
      </div>
      
    </div>
  </div>
</div>



<!-- FOR ALL ACTION      -->
<div class="modal fade" id="statusModalAll">
  <div class="modal-dialog">
    <div class="modal-content">    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Warning</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Are you sure you want to mark all orders as <span id="statusQuestionAll"></span>?</p>

        <div class="text-center mt-4">
          <form method="post" action="<?=Config::ADMIN_BASE_URL()?>order_manager/update_status_all">
            <input type="hidden" name="status" id="statusInputAll">
            <input type="hidden" name="orderNum" id="inputOrderNum">
            <input type="hidden" name="role" id="roleInputAll">

            <button class="btn btn-success btn-sm mr-3 rounded-0" type="submit">YES</button>
            <button class="btn btn-danger btn-sm ml-3 rounded-0" type="button" data-dismiss="modal">NO</button>
          </form>
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




  <script src="<?=$this_folder?>/assets/js/core.js"></script>


  <script src="<?=$this_folder?>/assets/js/feather.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/template.js"></script>



<script>
function onSelect(action, id, role) {
  document.getElementById("statusInput").value = action;
  document.getElementById("inputID").value = id;
  document.getElementById("roleInput").value = role;
  document.getElementById("statusQuestion").innerHTML = action;
  $("#statusModal").modal();
}

function onSelectAll(action, orderNum, role) {
  document.getElementById("statusInputAll").value = action;
  document.getElementById("roleInputAll").value = role;
  document.getElementById("inputOrderNum").value = orderNum;
  document.getElementById("statusQuestionAll").innerHTML = action;
  $("#statusModalAll").modal();
}


function geneInvoice(orderID, orderNumber) {
  window.location.replace("<?=Config::ADMIN_BASE_URL()?>order_manager/generateInvoice/" + orderID + "/" + orderNumber);
}

function geneSingleInvoice(orderID, orderNumber) {
  window.location.replace("<?=Config::ADMIN_BASE_URL()?>order_manager/generateSingleInvoice/" + orderID + "/" + orderNumber);
}
</script>


</body>
</html>