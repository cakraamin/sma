<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>guru/add_guru" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Data Guru</a></li>
		<li><a href="<?=base_url()?>guru/daftar" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Data Guru</a></li>
		<li><a href="<?=base_url()?>guru/export" <?php if(isset($export)){ echo $export;}?>>Export Data Guru</a></li>
		<li class="last"><a href="<?=base_url()?>guru/import" <?php if(isset($import)){ echo $import;}?>>Import Data Guru</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<form method="post" action="<?=base_url()?>guru/submit_export_guru" class="f-wrap-1">
	<fieldset>		
	<h3>Form Export Data Guru</h3>	
	<label for="nama"><b><span class="req"></span>Nama File :</b>
	<input name="nama" type="text" class="f-name" id="nama" value="Export Guru"/><br />
	</label>	
	<label><b><span class="req"></span>Format File :</b></label>
	<?php
		$data = array(
			'csv'	=> 'csv',
			'xls'	=> 'xls'
		);
		$pf = 'id="format" class="format"';
		echo form_dropdown('format',$data,'',$pf);
	?>
	<br />
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Export Data Guru" class="f-submit"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>