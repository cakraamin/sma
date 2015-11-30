<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>kelas/add_siswa" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Data Kelas Siswa</a></li>
		<li><a href="<?=base_url()?>kelas/daftar_siswa" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Data Kelas Siswa</a></li>
		<li><a href="<?=base_url()?>kelas/export" <?php if(isset($export)){ echo $export;}?>>Export Data Kelas Siswa</a></li>
		<li class="last"><a href="<?=base_url()?>kelas/import" <?php if(isset($import)){ echo $import;}?>>Import Data Kelas Siswa</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#nama').focus();
});
</script>
<form method="post" action="<?=base_url()?>kelas/submit_edit_kelas_siswa" class="f-wrap-1" id="formKelasSiswa">
	<fieldset>		
	<h3>Form Edit Data Kelas Siswa</h3>		
	<div class="konfirmasi"></div>
	<label><b><span class="req"></span>Kelas :</b></label>
	<?php
		$pk = 'id="kelas" class="kelas"';
		echo form_dropdown('kelas',$kls,$kueri->id_kelas,$pk);
	?>
	<br />					 					
	</label>	
	<label for="nis"><b><span class="req"></span>NIS :</b>
	<input name="nis" type="text" class="f-name" id="nis" value="<?=$kueri->nis?>"/>
	<input name="page" type="hidden" class="f-name" id="page" value="<?=get_edit(current_url(),3)?>"/>
	<input name="kode" type="hidden" class="f-name" id="kode" value="<?=$kueri->id_kelas_sis?>"/><br />
	</label>
	<label for="nama"><b><span class="req"></span>Nama Lengkap :</b>	
	<input name="nama" type="text" class="f-name" id="nama" value="<?=$kueri->nama?>"/><br />
	</label>
	<label for="tempat"><b><span class="req"></span>Tempat Lahir :</b>
	<input name="tempat" type="text" class="f-name" id="tempat" value="<?=$kueri->tempat_lahir?>"/><br />
	</label>
	<label><b><span class="req"></span>Tanggal Lahir :</b></label>
	<?php
		$ph = 'id="hari" class="hari"';
		echo form_dropdown('hari',$hari,$kueri->tanggal,$ph);	
		$pb = 'id="bulan" class="bulan"';
		echo form_dropdown('bulan',$bulan,$kueri->bulan,$pb);	
		$pt = 'id="tahun" class="tahun"';
		echo form_dropdown('tahun',$tahun,$kueri->tahun,$pt);
	?>
	<br />
	<label for="agama"><b><span class="req"></span>Agama :</b></label>
	<?php
		$pa = 'id="agama" class="agama"';
		echo form_dropdown('agama',$agama,$kueri->agama,$pa);
	?>
	<br />
	<label for="status"><b><span class="req"></span>Status Anak :</b></label>
	<?php
		$status = array('Anak Kandung','Anak Angkat');
		$pst = 'id="status" class="status"';
		echo form_dropdown('status',$status,$kueri->status,$pst);
	?>
	<br />
	<label for="anak_ke"><b><span class="req"></span>Anak Ke :</b>	
	<input name="anak_ke" type="text" class="f-name" id="anak_ke" value="<?php echo $kueri->anak; ?>"/><br />
	</label>
	<label for="telp"><b><span class="req"></span>Nomor Telephone :</b>	
	<input name="telp" type="text" class="f-name" id="telp" value="<?php echo $kueri->telp_anak; ?>"/><br />
	</label>
	<label for="asal"><b><span class="req"></span>Asal Sekolah :</b>	
	<input name="asal" type="text" class="f-name" id="asal" value="<?php echo $kueri->asal_sek; ?>"/><br />
	</label>
	<label for="alamat"><b><span class="req"></span>Alamat :</b>
	<textarea name="alamat" class="f-comments" rows="6" cols="20" id="alamat"><?php echo $kueri->alamat?></textarea><br />
	</label>
	<label for="ayah"><b><span class="req"></span>Nama Ayah :</b>	
	<input name="ayah" type="text" class="f-name" id="ayah" value="<?php echo $kueri->ayah; ?>"/><br />
	</label>
	<label for="ibu"><b><span class="req"></span>Nama Ibu :</b>	
	<input name="ibu" type="text" class="f-name" id="ibu" value="<?php echo $kueri->ibu; ?>"/><br />
	</label>	
	<label for="alamat_o"><b><span class="req"></span>Alamat Orang Tua :</b>
	<textarea name="alamat_o" class="f-comments" rows="6" cols="20" id="alamat_o"><?php echo $kueri->alamat_ortu; ?></textarea><br />
	</label>
	<label for="telp_o"><b><span class="req"></span>Nomor Telephone :</b>	
	<input name="telp_o" type="text" class="f-name" id="telp_o" value="<?php echo $kueri->telp_ortu; ?>"/><br />
	</label>
	<label for="p_ayah"><b><span class="req"></span>Pekerjaan Ayah :</b>	
	<input name="p_ayah" type="text" class="f-name" id="p_ayah" value="<?php echo $kueri->kerja_ayah; ?>"/><br />
	</label>
	<label for="p_ibu"><b><span class="req"></span>Pekerjaan Ibu :</b>	
	<input name="p_ibu" type="text" class="f-name" id="p_ibu" value="<?php echo $kueri->kerja_ibu; ?>"/><br />
	</label>	

	<label for="wali"><b><span class="req"></span>Nama Wali :</b>	
	<input name="wali" type="text" class="f-name" id="wali" value="<?php echo $kueri->wali; ?>"/><br />
	</label>	
	<label for="alamat_w"><b><span class="req"></span>Alamat Wali :</b>
	<textarea name="alamat_w" class="f-comments" rows="6" cols="20" id="alamat_w"><?php echo $kueri->alamat_wali; ?></textarea><br />
	</label>
	<label for="telp_w"><b><span class="req"></span>Nomor Telephone :</b>	
	<input name="telp_w" type="text" class="f-name" id="telp_w" value="<?php echo $kueri->telp_wali; ?>"/><br />
	</label>
	<label for="p_wali"><b><span class="req"></span>Pekerjaan Wali :</b>	
	<input name="p_wali" type="text" class="f-name" id="p_wali" value="<?php echo $kueri->kerja_wali; ?>"/><br />
	</label>	
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<div class="status"></div><br />
	</fieldset>
</form>
<div class="isi_tabel"></div>
</div>
<?=$this->load->view('footer')?>
</div>