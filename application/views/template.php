<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$this->config->item('base_name')?></title>
<link rel="icon" type="image/x-icon" href="<?=base_url()?>asset/images/logo.ico" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/css/main.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/js/lightbox/facebox.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/css/jquery.autocomplete.css" media="print" />
<script type="text/javascript" src="<?=base_url()?>asset/js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/lightbox/facebox.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/jquery.form.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/jquery_facebook.alert.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/ajax.js"></script>
</head>
<body id="type-<?=$type?>">
<div id="wrap">

	<div id="header">
		<div id="site-name"><?=$this->config->item('base_name')?></div>
		<ul id="nav">
		<li <?php if(isset($home)){ echo $home;}?>><a href="<?=base_url()?>">Home</a></li>
		<?php
		if($this->session->userdata('level') == "2")
		{
		?>
		<li <?php if(isset($control)){ echo $control;}?>><a href="#">Control Panel</a>
			<ul>
			<li class="first"><a href="<?=base_url()?>control">Data Semester</a></li>
			<li class="first"><a href="<?=base_url()?>control/kepala">Data Kepala Sekolah</a></li>
			<li class="last"><a href="<?=base_url()?>control/ta">Data Tahun Ajaran</a></li>
			</ul>
		</li>				
		<li <?php if(isset($akun)){ echo $akun;}?>><a href="<?=base_url()?>account">Setting Account</a></li>				
		<li <?php if(isset($guru)){ echo $guru;}?>><a href="<?=base_url()?>guru">Data Guru</a></li>
		<li <?php if(isset($kenaikan)){ echo $kenaikan;}?>><a href="<?php echo base_url(); ?>kenaikan">Kenaikan</a></li>
		<li <?php if(isset($kelas)){ echo $kelas;}?>><a href="#">Data Kelas</a>
			<ul>
			<li class="first"><a href="<?=base_url()?>kelas">Data Kelas</a></li>
			<li class="first"><a href="<?=base_url()?>kelas/daftar_wali">Data Wali Kelas</a></li>
			<li class="last"><a href="<?=base_url()?>kelas/daftar_siswa">Data Siswa Kelas</a></li>
			</ul>
		</li>		
		<li <?php if(isset($aspek)){ echo $aspek;}?>><a href="#">Aspek Nilai</a>
			<ul>
			<li class="first"><a href="<?=base_url()?>aspek/nilai/1">Aspek Pengetahuan</a></li>
			<li class="first"><a href="<?=base_url()?>aspek/nilai/2">Aspek Keterampilan</a></li>
			<li class="last"><a href="<?=base_url()?>aspek/nilai/3">Aspek Sikap</a></li>
			</ul>
		</li>
		<li <?php if(isset($mapel)){ echo $mapel;}?>><a href="#">Data Mapel</a>
			<ul>
			<li class="first"><a href="<?=base_url()?>mapel">Data Mapel</a></li>
			<li class="first"><a href="<?=base_url()?>mapel/guru_mapel">Data Guru Mapel</a></li>
			<li class="first"><a href="<?=base_url()?>mapel/guru_mapel_kelas">Data Guru Mapel Kelas</a></li>
			<li class="last"><a href="<?=base_url()?>mapel/guru_kelas">Data Mapel Kelas</a></li>
			</ul>
		</li>
		<!--<li <? if(isset($setting)){ echo $setting;}?>><a href="#">Setting</a>
			<ul>
			<li <? if(isset($kkm)){ echo $kkm;}?>><a href="<?=base_url()?>kkm">Setting KKM</a></li>
			<li <? if(isset($nilai)){ echo $nilai;}?>><a href="<?=base_url()?>nilai">Setting Nilai</a></li>
			<li <? if(isset($diri)){ echo $diri;}?>><a href="<?=base_url()?>diri">Pengembangan Diri</a></li>			
			</ul>		
		</li>-->
		<li <?php if(isset($lap)){ echo $lap;} ?>><a href="<?=base_url()?>laporan">Laporan</a></li>
		<!--<li <? if(isset($nilai)){ echo $nilai;}?>><a href="<?=base_url()?>nilai/pilih">Nilai</a></li>-->
		<?php
		}
		else
		{
		?>
		<li <?php if(isset($about)){ echo $about;}?>><a href="<?=base_url()?>about">About</a>		
		<?php
		}
		?>
		<?php
		if($this->session->userdata('level') == "2")
		{
		?>
		<li><a href="<?=base_url()?>login/logout">Log Out</a></li>
		<?php
		}
		?>
		</li>
		</ul>
	</div>
	<div id="content-wrap">
		<?=$this->load->view($main)?>
	</div>
</div>
</body>
</html>
