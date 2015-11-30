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
<form method="post" action="<?=base_url()?>guru/submit_edit_guru" class="f-wrap-1" id="formGuru">
	<fieldset>		
	<h3>Form Edit Data Guru</h3>		
	<div class="konfirmasi"></div>
	<input name="page" type="hidden" class="f-name" id="page" value="<?=get_edit(current_url(),3)?>"/>
	<label for="nip"><b><span class="req"></span>NIP :</b>
	<input name="nip" type="text" class="f-name" id="nip" value="<?php if(isset($kueri->nip)){ echo $kueri->nip; } ?>" disabled="disabled"/><input name="kode" type="hidden" class="f-name" id="kode" value="<?php if(isset($kueri->nip)){ echo $kueri->nip; } ?>"/><br />
	</label>		
	<label for="nama"><b><span class="req"></span>Nama Lengkap :</b>
	<input name="nama" type="text" class="f-name" id="nama" value="<?php if(isset($kueri->nama)){ echo $kueri->nama; } ?>"/><br />
	</label>
	<label for="tempat"><b><span class="req"></span>Tempat Lahir :</b>
	<input name="tempat" type="text" class="f-name" id="tempat" value="<?php if(isset($kueri->tempat_lahir)){ echo $kueri->tempat_lahir; } ?>"/><br />
	</label>
	<label><b><span class="req"></span>Tanggal Lahir :</b></label>
	<?php
		$ph = 'id="hari" class="hari"';
		$harine = (isset($kueri->tanggal))?$kueri->tanggal:0;
		echo form_dropdown('hari',$hari,$harine,$ph);	
		$pb = 'id="bulan" class="bulan"';
		$bulane = (isset($kueri->bulan))?$kueri->bulan:0;
		echo form_dropdown('bulan',$bulan,$bulane,$pb);	
		$pt = 'id="tahun" class="tahun"';
		$tahune = (isset($kueri->tahun))?$kueri->tahun:0;
		echo form_dropdown('tahun',$tahun,$tahune,$pt);
	?>
	<br />
	<label for="agama"><b><span class="req"></span>Agama :</b></label>
	<?php
		$pa = 'id="agama" class="agama"';
		$agamane = (isset($kueri->agama))?$kueri->agama:0;
		echo form_dropdown('agama',$agama,$agamane,$pa);
	?>
	<br />
	<label for="alamat"><b><span class="req"></span>Alamat :</b>
	<textarea name="alamat" class="f-comments" rows="6" cols="20" id="alamat"><?php if(isset($kueri->alamat)){ echo $kueri->alamat; } ?></textarea><br />
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