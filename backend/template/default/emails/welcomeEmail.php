<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 16px; margin: 0;">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$title?></title>

<style>
	.content-wrap{
		background: #fff; width: 80%; margin: auto; padding: 20px 10px;
	}
	.main-footer{
		width: 80%; margin: auto;
	}
	@media only screen and (max-width: 500px) {
		.content-wrap{
			width: 90%;
		}
		.main-footer{
			width: 92%; margin: auto;
		}
	}
</style>
	
</head>

<body itemscope itemtype="http://schema.org/EmailMessage">





	<section class="email-wrap" style="background: #E5E5E5; width: 100%; padding: 20px 0px; font-family: calibri">
		<div class="content-wrap">

			<div class="logo-wrapp" style="text-align: center; padding-top: 30px;">
				<img src="<?=$siteInfo->logo_url?>" alt="<?=$siteInfo->name?> Logo"/>
			</div>
			<div class="product-wrap" style="margin-top: 30px;">
				<div class="each-product" style="margin-top: 10px">
					<?=$emailContent?>
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