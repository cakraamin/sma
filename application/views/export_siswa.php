<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>siswa/add_siswa" <? if(isset($tambah)){ echo $tambah;}?>>Tambah Data Siswa</a></li>
		<li><a href="<?=base_url()?>siswa/daftar" <? if(isset($daftar)){ echo $daftar;}?>>Daftar Data Siswa</a></li>
		<li><a href="<?=base_url()?>siswa/export" <? if(isset($export)){ echo $export;}?>>Export Data Siswa</a></li>
		<li class="last"><a href="<?=base_url()?>siswa/import" <? if(isset($import)){ echo $import;}?>>Import Data Siswa</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<form method="post" action="<?=base_url()?>siswa/submit_export_siswa" class="f-wrap-1">
	<fieldset>		
	<h3>Form Export Data Siswa</h3>	
	<label for="nama"><b><span class="req"></span>Nama File :</b>
	<input name="nama" type="text" class="f-name" id="nama" value="Export Siswa"/><br />
	</label>	
	<label><b><span class="req"></span>Format File :</b></label>
	<?
		$data = array(
			'csv'	=> 'csv',
			'xls'	=> 'xls'
		);
		$pf = 'id="format" class="format"';
		echo form_dropdown('format',$data,'',$pf);
	?>
	<br />
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Export Data Siswa" class="f-submit"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>