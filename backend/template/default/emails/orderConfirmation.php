<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 16px; margin: 0;">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$title?></title>

<style>
	a{
		text-decoration: none;
	}
	.content-wrap{
		background: #fff; width: 80%; margin: auto; padding: 20px 10px;
	}
	.main-footer{
		width: 80%; margin: auto;
	}
	.prices{
		width: 40%;
	}
	.line{
		height: 1px;
		background: #ccc;
		width: 100%;
	}
	.price-history{
		display: flex; justify-content: space-between;
		margin-top: 40px;
	}
	.like-wrap{
		display: flex; 
		flex-wrap: wrap;
		padding: 0 4px; 
		justify-content: center;
	}
	.pro-list-each{
		background: #f4f4f4; 
		height: 300px; 
		margin: 3px; 
		border-radius: 5px; 
		padding: 8px;
		 flex: 20%;
		 width: 20%;
		 padding: 0 4px;
	}
	@media screen and (max-width: 770px) {
	  .pro-list-each {
	    flex: unset;
	    width: 96%;
	  }

  		.like-wrap{
			display: block; 
			flex-wrap: unset;
			padding: 0 4px; 
		justify-content: center;
		}
	}

	@media screen and (max-width: 700px) {
	  /*.pro-list-each {
	    -ms-flex: 95%;
	    flex: 95%;
	    max-width: 95%;
	  }*/

	  /*.like-wrap{
			display: grid; 
			flex-wrap: wrap;
			padding: 0 4px; 
			justify-content: center;
		}*/
	}

	@media only screen and (max-width: 500px) {
		.content-wrap{
			width: 92%;
		}
		.main-footer{
			width: 92%; margin: auto;
		}
		.prices{
			width: 100%;
		}
		.price-history{
			display: block
		}
	}
</style>
	
</head>

<body itemscope itemtype="http://schema.org/EmailMessage">





	<section class="email-wrap" style="background: #E5E5E5; width: 100%; padding: 20px 0px; font-family: calibri">
		<div class="content-wrap">

			<div class="logo-wrapp" style="padding-top: 10px;">
				<img src="<?=$siteInfo->logo_url?>" alt="<?=$siteInfo->name?> Logo"/>

				<h3 style="margin-top: 30px">
					Thank You For Shopping with Us 
					<img src="https://azany.creativeweb.com.ng/assets/images/thank-you.png" style="width: 30px">
				</h3>
			</div>

			<div class="note">
				<?=$emailContent?>  
			</div>

			<div class="price-history">
				<div class="orderNum"><p>Order No: #<?=$orderInfo['order_number']?></p></div>
				<div class="prices">


					<div style="padding: 5px 0px">
						<span>Subtotal:</span>
						<span style="float: right"><?=$cur->symbol?><?=number_format($orderInfo['subtotal'])?></span>
					</div>


					<div style="padding: 5px 0px">

						<span>Shipping:</span>
						<span style="float: right"><?=$cur->symbol?><?=number_format($orderInfo['shipping_cost'])?></span>
					</div>

					<div style="padding: 5px 0px">
						<span>Tax:</span>
						<span style="float: right"><?=$cur->symbol?><?=number_format($orderInfo['tax'])?></span>
					</div>

					<div class="line"></div>

					<div style="padding: 5px 0px; margin-top: 10px">
						<span><b>Total:</b></span>
						<span style="float: right"><b><?=$cur->symbol?><?=number_format($orderInfo['total'])?></b></span>
					</div>
				</div>
			</div>

			<div class="line" style="margin-top: 50px"></div>

			<div class="product-wrap">
				<div class="each-pro" style="margin-top: 20px">

					<?php foreach ($orders as $order): 
						$product_json = json_decode($order->product_json);
					?>

					<div style="display: flex; justify-content: flex-start; margin-bottom: 30px">
						<div style="width: 80px;">
							<img src="<?=$product_json->featured_img?>" style="width: 100%;">
						</div>
						<div style="margin-left: 10px;">
							<p style="margin-bottom: 3px; margin-top: 1px; font-weight: 550;"><?=substr($product_json->name, 0, 30)?> </p>
							<p style="margin-top: 2px; margin-bottom: 0px;"><small>Sold By: Underwood Garment</small></p>
							<p style="margin-top: 2px; margin-bottom: 0px;"><small>Qty: <?=$order->quantity?></small></p>
							<p style="margin-top: 3px; margin-bottom: 0px; font-weight: 550;"><?=$cur->symbol?> <?=number_format($order->sub_total)?></p>
						</div>
					</div>
					<?php endforeach ?>
				</div>
			</div>


			<div class="might-like" style="margin-top: 50px; background: #E5E5E5; padding-bottom: 30px;">
				<div style="padding: 1px 10px">
					<h3>
						<span>You might like</span>
						<span style="float: right"><a href="#" style="text-decoration: none">Discover More</a></span>
					</h3>
				</div>

				<div class="like-wrap">

					<?php foreach ($recommended as $rec): ?>
					<div class="pro-list-each">
						<div class="pro-img-wrap" style="height: 200px; width: 100%; padding-top: 5px">
							<img src="<?=$rec->featured_img?>" style="width: 100%; height: 100%; object-fit: contain;">
						</div>
						<div class="pro-info">
							<p style="margin-top: 10px; margin-bottom: 0px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;"><a href="#" style="color: #000"><?=substr($rec->name, 0,100)?></a></p>
							<h3 style="font-size: 23px; margin-bottom: 2px; margin-top: 7px; font-weight: 750; font-family: Arial;"><?=$cur->symbol?><?=number_format($rec['pro_var']->sales_price)?></h3>
							<p style="margin-top: 4px">
								<span style="color: #999; padding-right: 10px;"><del><?=$cur->symbol?><?=number_format($rec['pro_var']->regular_price)?></del></span>
								<span style="width: 30px; background: #1EE278; font-size: 13px; font-weight: bold; padding: 2px 3px; border-radius: 3px"><?=number_format($rec['pro_var']->discount)?>% off</span>
							</p>
						</div>
					</div>
					<?php endforeach ?>

				</div>
			</div>


			<div class="body-footer" style="border-top: 2px solid #ccc; margin-top: 50px;">
				<p style="color: #999; font-size: 15px">This email was sent to you as a registered member of Azany.com. To update your emails preferences <a href="#" style="text-decoration: none;">click here</a>. <br>
				Use of the service and website is subject to our <a href="<?=Config::domain()?>pages/terms-and-conditions" style="text-decoration: none;">Terms of Use</a> and <a href="<?=Config::domain()?>pages/privacy-policy" style="text-decoration: none;">Privacy Statement</a>.</p>

				<p style="color: #999; font-size: 15px">© 2021 Azany. All rights reserved</p>
			</div>
		</div>

		<div class="main-footer">
			<div class="partners" style="text-align: center">
				<p style="color: #999; margin-top: 30px">Partnership with the famous brands</p>

				<div class="brands">
					<?php foreach ($brands as $brand): ?>
					<img src="<?=$brand->image?>" style="width: 40px; padding: 0px 10px">
					<?php endforeach ?>
				</div>
			</div>

			<div style="margin-top: 20px;">
				<p style="color: #999">
					<span>Follow Azany on <a href="#" style="text-decoration: none;">Twitter</a></span>
					<span style="float: right"><a href="#" style="text-decoration: none; color: #999;">Unsubscibe</a></span>
				</p>
			</div>
		</div>
	</section>



</body>
</html>