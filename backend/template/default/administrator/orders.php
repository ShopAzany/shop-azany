<?php
    $page_title = "Orders";
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

  
  
  <?php if(count($allOrders) > 0) { ?>

    <!-- my php code which uses x-path to get results from xml query. -->
    <?php foreach($allOrders as $order) :?>  
    <div class="bg-white borderLine p-2 mb-4">
        <div class="row">    
            <div class="col-lg-2 col-md-2 mb-2">
                <img class="card-img-top"  src="<?=$order->image ?>" alt="Card image cap" style="height: 100%; width: 100%; object-fit: contain;">
            </div>

            <div class="col-lg-8 col-md-8">
                <h5 class="text-danger mt-4"><?=$order->name ?></h5>
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


    <!-- PAGINATION -->
    <div class="text-center mt-5">
        <div class="pagination-outer" aria-label="Page navigation">
          <ul class="pagination justify-content-center">
            <?php $prevPage =  $currPage - 1; ?>
            <li class="page-item">
              <?php if ($prevPage < 1) { ?>
                <a href="javascript:()" class="pagin-disabled page-link" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                </a>
              <?php } else { ?>  
                <a href="<?=Config::ADMIN_BASE_URL()?>order_manager/<?=$prevPage?>" class="page-link" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                </a>
              <?php } ?>                
            </li>

            <?php foreach ($pageLinks as $pageNum) : ?>

              <?php if ($pageNum == $currPage) { ?>
              <li class="page-item active"><a class="page-link" href="javascript:()"><?= $pageNum ?></a></li>
              <?php } else { ?>
              <li class="page-item"><a class="page-link" href="<?= Config::ADMIN_BASE_URL()?>order_manager/<?=$pageNum?>"><?= $pageNum ?></a></li>
              <?php } ?>

            <?php endforeach ?>  


            <?php $nextPage =  $currPage + 1; ?>  
            <li class="page-item">
              <?php if ($nextPage > $totalLink) { ?>
                <a href="javascript:()" class="pagin-disabled page-link" aria-label="Next">
                  <span aria-hidden="true">»</span>
                </a>
              <?php } else { ?>
                <a href="<?=Config::ADMIN_BASE_URL()?>order_manager/<?=$nextPage?>" class="page-link" aria-label="Next">
                  <span aria-hidden="true">»</span>
                </a>
              <?php } ?>
            </li>
          </ul>
        </div>
    </div>


    <?php } else { ?>

        <h4>No <?php if($page !== 'All') { ?> <?=ucwords($page)?> <?php } ?> Orders Available</h4>

    <?php } ?>

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
        <p>Are you sure you want to delete this slide?</p>

        <form method="post" action="<?=Config::ADMIN_BASE_URL()?>content_manager/delete_slide" class="mt-4">
          <input type="hidden" name="slideID" id="inputID">
          <button class="btn btn-primary btn-sm mr-3" type="submit">YES</button>
          <button class="btn btn-danger btn-sm ml-3" data-dismiss="modal" type="button">NO</button>
        </form>
      </div>
    </div>
  </div>
</div>
  

  <script src="<?=$this_folder?>/assets/js/core.js"></script>


  <script src="<?=$this_folder?>/assets/js/feather.min.js"></script>
  <script src="<?=$this_folder?>/assets/js/template.js"></script>


  <script>
    function deleteSlide(slideID) {
      $("#deleteModal").modal();
      document.getElementById('inputID').value = slideID;
    }
  </script>
</body>
</html>