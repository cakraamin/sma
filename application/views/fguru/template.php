<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$this->config->item('base_name')?></title>
<link rel="icon" type="image/x-icon" href="<?=base_url()?>asset/images/logo.ico" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/css/main.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/js/lightbox/facebox.css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>asset/js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/jquery.form.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/lightbox/facebox.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/jquery_facebook.alert.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/ajax.js"></script>
</head>
<body id="type-<?=$type?>">
<div id="wrap">

	<div id="header">
		<div id="site-name">Halaman Guru Mata Pelajaran</div>
		<ul id="nav">
		<li <?php if(isset($home)){ echo $home;}?>><a href="<?=base_url()?>fguru/home">Home</a></li>
		<li <?php if(isset($akun)){ echo $akun;}?>><a href="<?=base_url()?>fguru/account">Setting Account</a></li>		
		<li <?php if(isset($nilai)){ echo $nilai;}?>><a href="<?=base_url()?>fguru/nilai">Nilai</a>
		<?php
			if(count($menu) > 0)
			{
				echo "<ul>";
				foreach($menu as $dt_menu)
				{
					echo "<li><a href='".base_url()."fguru/nilai/nilai/".$dt_menu->id_guru_mapel."'>".$dt_menu->mapel."&nbsp;[".$this->mmenu->getAllGuru($dt_menu->id_team)."]</a></li>";	
				}
				echo "</ul>";
			}							
		?>
		<!--<li <? if(isset($catat)){ echo $catat;}?>><a href="<?=base_url()?>fguru/catatan">Catatan</a></li>		
		<li <? if(isset($diri)){ echo $diri;}?>><a href="<?=base_url()?>fguru/pengembangan">Pengembangan Diri</a></li>
		<?
			if($this->session->userdata('kd_sem') == 2)
			{
		?>
		<li <? if(isset($naik)){ echo $naik;}?>><a href="<?=base_url()?>fguru/kenaikan">Kenaikan</a></li>
		<?			
			}		
		?>-->
		<!--<li <? if(isset($gen)){ echo $gen;}?>><a href="<?=base_url()?>fguru/generate">Generate</a></li>-->		
		<li <?php if(isset($lap)){ echo $lap;}?>><a href="<?=base_url()?>fguru/laporan">Laporan</a></li>		
		</li>
		<li><a href="<?=base_url()?>login/logout">Logout</a></li>
		</ul>
	</div>
	<div id="content-wrap">
		<?=$this->load->view($main)?>
	</div>
</div>
</body>
</html>
