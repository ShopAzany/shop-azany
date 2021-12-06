<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$title?></title>


<style type="text/css">
img {
width: 230px;
}
body {
-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
}
body {
background-color: #f6f6f6;
}
@media only screen and (max-width: 700px) {
body {
padding: 0 !important;
}
h1 {
font-weight: 800 !important; margin: 20px 0 5px !important;
}
h2 {
font-weight: 800 !important; margin: 20px 0 5px !important;
}
h3 {
font-weight: 800 !important; margin: 20px 0 5px !important;
}
h4 {
font-weight: 800 !important; margin: 20px 0 5px !important;
}
h1 {
font-size: 22px !important;
}
h2 {
font-size: 18px !important;
}
h3 {
font-size: 16px !important;
}
.container {
padding: 0 !important; width: 100% !important;
}
.content {
padding: 0 !important;
}
.content-wrap {
padding: 10px !important;
}
.invoice {
width: 100% !important;
}
}
</style>
</head>

<body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
<td class="container" width="700" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 700px !important; clear: both !important; margin: 0 auto;" valign="top">
<div class="content" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 700px; display: block; margin: 0 auto; padding: 20px;">
<table class="main" width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0;" bgcolor="#fff">

<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

<td class="alert alert-warning" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #f6f6f6; margin: 0; padding: 20px;" align="center" bgcolor="#f6f6f6" valign="top">


<a href="https://www.oziconnect.com">
<img src="images/oziconnect-logo.png" alt="<?=Config::project_name();?> Logo"/></a>

</td>

</tr>

<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

<td class="alert alert-warning" style="border-bottom: 1px solid #e9e9e9; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #FFF; margin: 0; padding: 20px;" align="center" bgcolor="#FFF" valign="top"> <br><br>
	<span style="color: #009966;font-size: 20px"><?=$title?></span>
	<br><br>
</td>

</tr>

<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">

<table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
	<td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">

<?=$emailContent?>  

</td>
</tr>

<?php if($linkRole){?>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">

	<?php if($linkRole == 'Verify'){?>
	<a href="<?=$link?>" class="btn-primary" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #009966; margin: 0; border-color: #009966; border-style: solid; border-width: 10px 20px;">
	Verify Now!</a>

	<br><br>
	<b>Or copy and paste the code below on your browser:</b>
	<br>
	<?=$link?>

	<?php }elseif($linkRole == 'Password Reset'){?>
	<a href="<?=$link?>" class="btn-primary" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #009966; margin: 0; border-color: #009966; border-style: solid; border-width: 10px 20px;">
	Reset Password</a>

	<br><br>
	<b>Or copy and paste the code below on your browser:</b>
	<br>
	<?=$link?>

	<?php }elseif($linkRole == 'Login'){?>
	<a href="<?=$link?>" class="btn-primary" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #009966; margin: 0; border-color: #009966; border-style: solid; border-width: 10px 20px;">
	Login Now</a>

	<?php }elseif($linkRole == 'Message'){?>
	<a href="<?=$link?>" class="btn-primary" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #009966; margin: 0; border-color: #009966; border-style: solid; border-width: 10px 20px;">
	View and Reply</a>
	<?php }?>
</td>
</tr>
<?php }?>

<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">

<?php if($signature){?>
	<hr style="border:1px solid #EEE;margin-bottom: 20px;">
	<?=$signature?>
<?php }?>
</td>
</tr></table></td>
</tr></table><div class="footer" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
<table width="100%" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="aligncenter content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">

This email was intended for <b><?=$receiverName?></b>, because you signed up for <b><?=Config::project_name();?></b>
<br>The links in this email will always direct to <b><?=Config::serverName()?></b>. <br>
&copy; <?=Config::businessName().'. '.date("Y")?>.</td>
</tr></table></div></div>
</td>
<td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
</tr></table></body>
</html>