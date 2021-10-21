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
	.pro-list-each{
		background: #f4f4f4; 
		height: 290px; 
		margin: 3px; 
		border-radius: 5px; 
		padding: 8px;
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

<section class="email-wrap" style="background: #E5E5E5; width: 100%; padding: 20px 0px; font-family: calibri">
	<div class="content-wrap">

		<div class="logo-wrapp" style="padding-top: 10px;">
			<img src="<?=$this_folder?>/assets/images/companyLogo.png">

			<h3 style="margin-top: 30px">
				Thank You For Shopping with Us 
				<img src="<?=$this_folder?>/assets/images/thanks.png" style="width: 30px">
			</h3>
		</div>

		<div class="note">
			<p>Hey <b>David,</b></p>
			<p>Your order has been confirmed and is on its way.</p>
			<p>Aliquam sed semper egestas lacus, in turpis posuere convallis. Vestibulum a consectetur sed turpis risus est facilisis velit. Blandit non, in a elit. Rhoncus urna eu, faucibus diam orci purus metus. Lectus ultrices mi et enim ullamcorper turpis dignissim eget quam. Gravida volutpat phasellus neque fermentum.</p>
		</div>

		<div class="price-history">
			<div class="orderNum"><p>Order No: #AZA639958020</p></div>
			<div class="prices">
				<div style="display: flex; justify-content: space-between; padding: 5px 0px">
					<div>Subtotal:</div>
					<div>$135,000</div>
				</div>
				<div style="display: flex; justify-content: space-between; padding: 5px 0px">
					<div>Shipping:</div>
					<div>$20,000</div>
				</div>
				<div style="display: flex; justify-content: space-between; padding: 5px 0px">
					<div>Tax:</div>
					<div> $999.99</div>
				</div>
				<div class="line"></div>
				<div style="display: flex; justify-content: space-between; padding: 5px 0px; margin-top: 10px">
					<div><b>Total:</b></div>
					<div><b>$155,999.99</b></div>
				</div>
			</div>
		</div>

		<div class="line" style="margin-top: 50px"></div>

		<div class="product-wrap">
			<div class="each-pro" style="margin-top: 20px">
				<div style="display: flex; justify-content: flex-start; margin-bottom: 30px">
					<div style="width: 80px;">
						<img src="<?=$this_folder?>/assets/images/product/p1.png">
					</div>
					<div style="margin-left: 10px;">
						<p style="margin-bottom: 3px; margin-top: 1px; font-weight: 550;">Multi-color Mens soft comfortable casual hoodie for Autumn and Winter</p>
						<p style="margin-top: 2px; margin-bottom: 0px;"><small>Sold By: Underwood Garment</small></p>
						<p style="margin-top: 2px; margin-bottom: 0px;"><small>Qty: 1</small></p>
						<p style="margin-top: 3px; margin-bottom: 0px; font-weight: 550;">$10,269.89</p>
					</div>
				</div>

				<div style="display: flex; justify-content: flex-start; margin-bottom: 30px">
					<div style="width: 80px;">
						<img src="<?=$this_folder?>/assets/images/product/p2.png">
					</div>
					<div style="margin-left: 10px;">
						<p style="margin-bottom: 3px; margin-top: 1px; font-weight: 550;">Multi-color Mens soft comfortable casual hoodie for Autumn and Winter</p>
						<p style="margin-top: 2px; margin-bottom: 0px;"><small>Sold By: Underwood Garment</small></p>
						<p style="margin-top: 2px; margin-bottom: 0px;"><small>Qty: 1</small></p>
						<p style="margin-top: 3px; margin-bottom: 0px; font-weight: 550;">$10,269.89</p>
					</div>
				</div>

				<div style="display: flex; justify-content: flex-start; margin-bottom: 30px">
					<div style="width: 80px;">
						<img src="<?=$this_folder?>/assets/images/product/p3.png">
					</div>
					<div style="margin-left: 10px;">
						<p style="margin-bottom: 3px; margin-top: 1px; font-weight: 550;">Multi-color Mens soft comfortable casual hoodie for Autumn and Winter</p>
						<p style="margin-top: 2px; margin-bottom: 0px;"><small>Sold By: Underwood Garment</small></p>
						<p style="margin-top: 2px; margin-bottom: 0px;"><small>Qty: 1</small></p>
						<p style="margin-top: 3px; margin-bottom: 0px; font-weight: 550;">$10,269.89</p>
					</div>
				</div>
			</div>
		</div>


		<div class="might-like" style="margin-top: 50px; background: #E5E5E5; padding-bottom: 30px;">
			<div style="display: flex; justify-content: space-between; padding: 0px 10px">
				<div><h3>You might like</h3></div>
				<div><h4><a href="#" style="text-decoration: none">Discover More</a></h4></div>
			</div>

			<div class="like-wrap" style="display: flex; flex-wrap: wrap; justify-content: center; ">
				<div class="pro-list-each">
					<div class="pro-img-wrap" style="height: 200px; width: 100%">
						<img src="<?=$this_folder?>/assets/images/product/image.png" style="width: 100%; height: 100%; object-fit: cover;">
					</div>
					<div class="pro-info">
						<p style="margin-top: 10px; margin-bottom: 0px"><a href="#" style="color: #000">Men’s Cotton Casual  Sweater</a></p>
						<h3 style="font-size: 23px; margin-bottom: 2px; margin-top: 7px; font-weight: 750; font-family: Arial;">$1,000</h3>
						<p style="margin-top: 4px">
							<span style="color: #999; padding-right: 10px;"><del>$20,000</del></span>
							<span style="width: 30px; background: #1EE278; font-size: 13px; font-weight: bold; padding: 2px 3px; border-radius: 3px">20% off</span>
						</p>
					</div>
				</div>

				<div class="pro-list-each">
					<div class="pro-img-wrap" style="height: 200px; width: 100%">
						<img src="<?=$this_folder?>/assets/images/product/image2.png" style="width: 100%; height: 100%; object-fit: cover;">
					</div>
					<div class="pro-info">
						<p style="margin-top: 10px; margin-bottom: 0px"><a href="#" style="color: #000">Gillette MACH 3 Electric Razor</a></p>
						<h3 style="font-size: 23px; margin-bottom: 2px; margin-top: 7px; font-weight: 750; font-family: Arial;">$1,000</h3>
						<p style="margin-top: 4px">
							<span style="color: #999; padding-right: 10px;"><del>$20,000</del></span>
							<span style="width: 30px; background: #1EE278; font-size: 13px; font-weight: bold; padding: 2px 3px; border-radius: 3px">20% off</span>
						</p>
					</div>
				</div>

				<div class="pro-list-each">
					<div class="pro-img-wrap" style="height: 200px; width: 100%">
						<img src="<?=$this_folder?>/assets/images/product/image3.png" style="width: 100%; height: 100%; object-fit: cover;">
					</div>	
					<div class="pro-info">
						<p style="margin-top: 10px; margin-bottom: 0px"><a href="#" style="color: #000">H&M Raw Denim Jeans for Men</a></p>
						<h3 style="font-size: 23px; margin-bottom: 2px; margin-top: 7px; font-weight: 750; font-family: Arial;">$1,000</h3>
						<p style="margin-top: 4px">
							<span style="color: #999; padding-right: 10px;"><del>$20,000</del></span>
							<span style="width: 30px; background: #1EE278; font-size: 13px; font-weight: bold; padding: 2px 3px; border-radius: 3px">20% off</span>
						</p>
					</div>
				</div>
			</div>
		</div>


		<div class="body-footer" style="border-top: 2px solid #ccc; margin-top: 50px;">
			<p style="color: #999; font-size: 15px">This email was sent to you as a registered member of Azany.com. To update your emails preferences <a href="#" style="text-decoration: none;">click here</a>. <br>
			Use of the service and website is subject to our <a href="#" style="text-decoration: none;">Terms of Use</a> and <a href="#" style="text-decoration: none;">Privacy Statement</a>.</p>

			<p style="color: #999; font-size: 15px">© 2021 Azany. All rights reserved</p>
		</div>
	</div>

	<div class="main-footer">
		<div class="partners" style="text-align: center">
			<p style="color: #999; margin-top: 30px">Partnership with the famous brands</p>

			<div class="brands">
				<img src="<?=$this_folder?>/assets/images/brand1.png" style="width: 40px; padding: 0px 10px">
				<img src="<?=$this_folder?>/assets/images/brand2.png" style="width: 40px; padding: 0px 10px">
				<img src="<?=$this_folder?>/assets/images/brand3.png" style="width: 40px; padding: 0px 10px">
				<img src="<?=$this_folder?>/assets/images/brand4.png" style="width: 40px; padding: 0px 10px">
			</div>
		</div>

		<div style="display: flex; justify-content: space-between; margin-top: 20px;">
			<div>
				<p style="color: #999">Follow Azany on <a href="#" style="text-decoration: none;">Twitter</a></p>
			</div>

			<div>
				<p><a href="#" style="text-decoration: none; color: #999;">Unsubscibe</a></p>
			</div>
		</div>
	</div>
</section>