<ul class="nav nav-pills nav-justified">
  <li class="nav-item">
    <a class="nav-link <?php if($proNav == 'pro-cat') { ?> active <?php } ?>" href="<?=Config::ADMIN_BASE_URL()?>product_manager/edit/<?=$product->pid?>">Product Details</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php if($proNav == 'pro-img') { ?> active <?php } ?>" href="<?=Config::ADMIN_BASE_URL()?>product_manager/edit_image/<?=$product->pid?>">Product Images</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php if($proNav == 'pro-price') { ?> active <?php } ?>" href="<?=Config::ADMIN_BASE_URL()?>product_manager/selling_details/<?=$product->pid?>">Selling Details</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php if($proNav == 'pro-shipping') { ?> active <?php } ?>" href="<?=Config::ADMIN_BASE_URL()?>product_manager/shipping_info/<?=$product->pid?>">Shipping Information</a>
  </li>
  <!-- <li class="nav-item">
    <a class="nav-link <?php if($proNav == 'pro-price') { ?> active <?php } ?>" href="<?=Config::ADMIN_BASE_URL()?>product_manager/edit_pricing/<?=$product->pid?>">Product Pricing</a>
  </li>
   -->
</ul>