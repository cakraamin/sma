<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>mapel/guru_mapel_kelas" <?php if(isset($tambah)){ echo $tambah;}?>>Pilih Guru Mapel Kelas</a></li>
		<li><a href="<?=base_url()?>mapel/daftar_guru_mapel_kelas" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Guru Mapel per-Kelas</a></li>
	</ul>
</div>
<div id="content">
<div class="cari">
<form method="post" action="<?=base_url()?>mapel/submit_guru_mapel">
	<label for="kunci"><b>Mapel :</b>
	<?php
		$pm = 'id="mapel" class="mapel" OnChange="this.form.submit()" ';
		echo form_dropdown('mapel',$mapels,'',$pm);
	?>
	</label>		
</form>
</div><hr />
<?=$this->load->view('admin/footer')?>
</div>