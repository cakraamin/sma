<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>kelas/add_siswa" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Data Kelas Siswa</a></li>
		<li><a href="<?=base_url()?>kelas/daftar_siswa" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Data Kelas Siswa</a></li>
		<li><a href="<?=base_url()?>kelas/export" <?php if(isset($export)){ echo $export;}?>>Export Data Kelas Siswa</a></li>
		<li class="last"><a href="<?=base_url()?>kelas/import" <?php if(isset($import)){ echo $import;}?>>Import Data Kelas Siswa</a></li>
        <li class="last"><a href="<?=base_url()?>kelas/mutasi" <?php if(isset($mutasi)){ echo $mutasi;}?>>Mutasi Siswa</a></li>
	</ul>
</div>
<div id="content">
<form method="post" action="<?=base_url()?>kelas/submit_mutasi" class="f-wrap-1">
	<fieldset>		
	<h3>Form Mutasi Siswa</h3>		
	<div class="konfirmasi"></div>
	<label><b><span class="req"></span>Kelas :</b></label>
	<?php
		$pk = 'id="kelas" class="kelas" OnChange="this.form.submit()"';
		echo form_dropdown('kelas',$kls,'',$pk);
	?>
	<br /><br /><br />
	</label>	
</form>
</div>
<?=$this->load->view('footer')?>
</div>