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
<form method="post" action="<?=base_url()?>kelas/<?php echo $links; ?>/<?=$id?>" id="formKelasSiswa">
	<label for="nis"><b><span class="req"></span>NIS :</b>
	<input name="nis" type="text" class="f-name" id="nis"/><br/>
	</label>
	<input name="ket" type="hidden" class="f-name" id="ket" value="<?=$sort_by?>/<?=$sort_order?>/<?=$page?>"/>
	<input name="ref" type="hidden" class="f-name" id="ref" value="kelas/refreshsiswa/<?=$id?>/"/>
	<input name="kode" type="hidden" class="f-name" id="kode" value="<?=$id?>"/>	
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