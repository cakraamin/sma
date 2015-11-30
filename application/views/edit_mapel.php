<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>mapel/add_mapel" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Data Mapel</a></li>
		<li><a href="<?=base_url()?>mapel/daftar" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Data Mapel</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#nama').focus();
	$('#harian').change(function() {
  		$(this).attr('checked',true);
	});
});
</script>
<form method="post" action="<?=base_url()?>mapel/submit_edit_mapel/<?=$kueri->id_mapel?>" class="f-wrap-1" id="formMapel">
	<fieldset>		
	<h3>Form Edit Data Mata Pelajaran</h3>		
	<div class="konfirmasi"></div>
	<label for="nama"><b><span class="req"></span>Nama Mapel :</b>
	<input name="nama" type="text" class="f-name" id="nama" value="<?=$kueri->mapel?>"/>
	<input name="page" type="hidden" class="f-name" id="page" value="<?=get_edit(current_url(),3)?>"/><br />
	</label>
	<!--<label for="jam"><b><span class="req"></span>Jumlah Jam :</b></label>
	<?
		$pj = 'id="jam" class="jam"';
		echo form_dropdown('jam',$jam,$kueri->jum_jam_mapel,$pj);
	?>
	<br />-->
	<label for="jenis"><b><span class="req"></span>Jenis Mapel :</b></label>
	<?php
		$pj = 'id="jenis" class="jenis"';
		echo form_dropdown('jenis',$jenis,$kueri->jenis,$pj);
	?>	
	<label for="jenis"><b><span class="req"></span>Dua Guru :</b>
	<?php
		$dual = ($kueri->dual_guru == '1')?TRUE:FALSE;
		echo form_checkbox('guru', '1', $dual);		
	?>	</label>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<input type="reset" name="reset" value="reset" id="reset" style="display:none;"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>