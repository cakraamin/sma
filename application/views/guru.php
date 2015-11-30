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
<script type="text/javascript">
$(document).ready( function() {		
	$('#nip').focus();
});
</script>
<form method="post" action="<?=base_url()?>guru/submit_guru" class="f-wrap-1" id="formGuru">
	<fieldset>		
	<h3>Form Data Guru</h3>		
	<div class="konfirmasi"></div>
	<label for="nip"><b><span class="req"></span>NIP :</b>
	<input name="nip" type="text" class="f-name" id="nip"/><br />
	</label>		
	<label for="nama"><b><span class="req"></span>Nama Lengkap :</b>
	<input name="nama" type="text" class="f-name" id="nama"/><br />
	</label>
	<label for="tempat"><b><span class="req"></span>Tempat Lahir :</b>
	<input name="tempat" type="text" class="f-name" id="tempat"/><br />
	</label>
	<label><b><span class="req"></span>Tanggal Lahir :</b></label>
	<?php
		$ph = 'id="hari" class="hari"';
		echo form_dropdown('hari',$hari,'',$ph);	
		$pb = 'id="bulan" class="bulan"';
		echo form_dropdown('bulan',$bulan,'',$pb);	
		$pt = 'id="tahun" class="tahun"';
		echo form_dropdown('tahun',$tahun,'',$pt);
	?>
	<br />
	<label for="agama"><b><span class="req"></span>Agama :</b></label>
	<?php
		$pa = 'id="agama" class="agama"';
		echo form_dropdown('agama',$agama,'',$pa);
	?>
	<br />
	<label for="alamat"><b><span class="req"></span>Alamat :</b>
	<textarea name="alamat" class="f-comments" rows="6" cols="20" id="alamat"></textarea><br />
	</label>					 					
	</label>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<input type="reset" name="reset" value="reset" id="reset" style="display:none;"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>