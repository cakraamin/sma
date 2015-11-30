<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>mapel/add_guru_mapels/<?=$kode?>" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Guru Mapel Kelas</a></li>
		<li><a href="<?=base_url()?>mapel/guru_mapel_kelas/<?=$kode?>" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Guru Mapel Kelas</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<form method="post" action="<?=base_url()?>mapel/submit_edit_guru_kelas_mapel/<?=$kueri->id_mapel_kelas?>" class="f-wrap-1" id="formMapelGuruKelass">
	<fieldset>		
	<h3>Form Edit Data Guru Kelas Mata Pelajaran</h3>		
	<div class="konfirmasi"></div>
	<label for="jam"><b><span class="req"></span>Kelas :</b></label>
	<input name="page" type="hidden" class="f-name" id="page" value="<?=get_edit(current_url(),4)?>"/>
	<?php
		$pk = 'id="kelas" class="kelas"';
		echo form_dropdown('kelas',$kelase,$kueri->id_kelas,$pk);
	?>
	<br />
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<input type="reset" name="reset" value="reset" id="reset" style="display:none;"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>