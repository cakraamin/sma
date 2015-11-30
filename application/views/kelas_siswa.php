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
<script type="text/javascript">
$(document).ready( function() {		
	$('#nis').focus();
});
</script>
<form method="post" action="<?=base_url()?>kelas/get_kelas" class="f-wrap-1">
	<fieldset>		
	<h3>Form Data Kelas Siswa</h3>		
	<div class="konfirmasi"></div>
	<label><b><span class="req"></span>Kelas :</b></label>
	<?php
		$pk = 'id="kelas" class="kelas" OnChange="this.form.submit()"';
		echo form_dropdown('kelas',$kls,$id,$pk);
	?>
	<br />					 					
	</label>	
</form>
<form method="post" action="<?=base_url()?>kelas/submit_kelas_siswa/<?=$id?>" id="formKelasSiswa">
	<label for="nis"><b><span class="req"></span>NIS :</b>
	<input name="nis" type="text" class="f-name" id="nis"/><br/>
	</label>
	<input name="ket" type="hidden" class="f-name" id="ket" value="<?=$sort_by?>/<?=$sort_order?>/<?=$page?>"/>
	<input name="ref" type="hidden" class="f-name" id="ref" value="kelas/refreshsiswa/<?=$id?>/"/>
	<input name="kode" type="hidden" class="f-name" id="kode" value="<?=$id?>"/>
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
	<label for="status"><b><span class="req"></span>Status Anak :</b></label>
	<?php
		$status = array('Anak Kandung','Anak Angkat');
		$pst = 'id="status" class="status"';
		echo form_dropdown('status',$status,'',$pst);
	?>
	<br />
	<label for="anak_ke"><b><span class="req"></span>Anak Ke :</b>	
	<input name="anak_ke" type="text" class="f-name" id="anak_ke"/><br />
	</label>
	<label for="telp"><b><span class="req"></span>Nomor Telephone :</b>	
	<input name="telp" type="text" class="f-name" id="telp"/><br />
	</label>
	<label for="asal"><b><span class="req"></span>Asal Sekolah :</b>	
	<input name="asal" type="text" class="f-name" id="asal"/><br />
	</label>
	<label for="alamat"><b><span class="req"></span>Alamat :</b>
	<textarea name="alamat" class="f-comments" rows="6" cols="20" id="alamat"></textarea><br />
	</label>
	<label for="ayah"><b><span class="req"></span>Nama Ayah :</b>	
	<input name="ayah" type="text" class="f-name" id="ayah"/><br />
	</label>
	<label for="ibu"><b><span class="req"></span>Nama Ibu :</b>	
	<input name="ibu" type="text" class="f-name" id="ibu"/><br />
	</label>	
	<label for="alamat_o"><b><span class="req"></span>Alamat Orang Tua :</b>
	<textarea name="alamat_o" class="f-comments" rows="6" cols="20" id="alamat_o"></textarea><br />
	</label>
	<label for="telp_o"><b><span class="req"></span>Nomor Telephone :</b>	
	<input name="telp_o" type="text" class="f-name" id="telp_o"/><br />
	</label>
	<label for="p_ayah"><b><span class="req"></span>Pekerjaan Ayah :</b>	
	<input name="p_ayah" type="text" class="f-name" id="p_ayah"/><br />
	</label>
	<label for="p_ibu"><b><span class="req"></span>Pekerjaan Ibu :</b>	
	<input name="p_ibu" type="text" class="f-name" id="p_ibu"/><br />
	</label>	

	<label for="wali"><b><span class="req"></span>Nama Wali :</b>	
	<input name="wali" type="text" class="f-name" id="wali"/><br />
	</label>	
	<label for="alamat_w"><b><span class="req"></span>Alamat Wali :</b>
	<textarea name="alamat_w" class="f-comments" rows="6" cols="20" id="alamat_w"></textarea><br />
	</label>
	<label for="telp_w"><b><span class="req"></span>Nomor Telephone :</b>	
	<input name="telp_w" type="text" class="f-name" id="telp_w"/><br />
	</label>
	<label for="p_wali"><b><span class="req"></span>Pekerjaan Wali :</b>	
	<input name="p_wali" type="text" class="f-name" id="p_wali"/><br />
	</label>	

	<div class="f-submit-wrap">
	<?php
	if($id != "")
	{
		echo '<input type="submit" name="submit" value="Simpan" class="f-submit"/>';
	}
	?>
	<input type="reset" name="reset" value="reset" id="reset" style="display:none;"/>
	<div class="status"></div><br />
	</fieldset>
</form>
<?php
if($id != 0)
{
?>
<div class="isi">
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%">No</th><th width="35%">NIS</th><th><a href="<?=base_url()?>kelas/daftar/a.nama/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">Nama</a></th>
	</tr>
	<?php
	if(count($kueri) > 0)
	{
		$no = $page + 1;
		foreach($kueri as $dt_kueri):
		if($no % 2 == 0)
		{
			$klas = 'class="genap"';
		}
		else
		{
			$klas = 'class="ganjil"';
		}
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->id_kelas_sis?>">
		<td align="center"><?=$no?></td><td><?=$dt_kueri->nis?></td><td><?=$dt_kueri->jeneng?></td>
	</tr>
	<?php
		$no++;
		endforeach;
	}
	else
	{
	?>
	<tr><td colspan="3" align="center">Data Masih Kosong</td></tr>
	<?php
	}
	?>
</table>
</form><br />
<?=$paging?>
</div>
<?php
}
?>
</div>
<?=$this->load->view('footer')?>
</div>