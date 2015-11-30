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
<div class="isi">
<form method="post" action="<?=base_url()?>kelas/submit_export_kelas/<?=$id?>" class="f-wrap-1">
	<fieldset>		
	<h3>Form Export Data Kelas Siswa</h3>	
	<label for="nama"><b><span class="req"></span>Nama File :</b>
	<input name="nama" type="text" class="f-name" id="nama" value="Export Kelas <?php if(isset($id)){ echo $id; } ?>"/><input name="kode" type="hidden" class="f-name" id="kode" value="<?php if(isset($id)){ echo $id; } ?>"/><br />
	</label>	
	<label><b><span class="req"></span>Kelas :</b></label>
	<?php
		$pk = 'id="kelas" class="kelas" OnChange="this.form.submit()"';
		echo form_dropdown('kelas',$kls,$id,$pk);
	?>
	<br />					 					
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
	<?php
	if($id != "")
	{
		echo '<input type="submit" name="submit" value="Export Data Kelas Siswa" class="f-submit"/>';
	}
	?>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>