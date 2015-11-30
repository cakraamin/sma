<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$this->config->item('base_name')?></title>
<link rel="icon" type="image/x-icon" href="<?=base_url()?>asset/images/logo.ico" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/css/main.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/css/print.css" media="print" />
<script type="text/javascript" src="<?=base_url()?>asset/js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/jquery.form.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/jquery_facebook.alert.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/ajax.js"></script>
</head>
<body id="type-<?=$type?>">
<div id="wrap">

	<div id="header">
		<div id="site-name">Halaman Admin</div>
		<ul id="nav">
		<li <?php if(isset($home)){ echo $home;}?>><a href="<?=base_url()?>admin/home">Home</a></li>
		<li <?php if(isset($akun)){ echo $akun;}?>><a href="<?=base_url()?>admin/account">Setting Account</a>
		<li <?php if(isset($user)){ echo $user;}?>><a href="<?=base_url()?>admin/user">User</a>
		<li><a href="<?=base_url()?>login/logout">Logout</a>
		</li>
		</ul>
	</div>
	<div id="content-wrap">
		<?=$this->load->view($main)?>
	</div>

</div>
</body>
</html>
