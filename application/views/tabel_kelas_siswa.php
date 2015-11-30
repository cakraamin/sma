<div class="toolbar"><a href="javascript:void(0)" title="Hapus Data Kelas" onclick="delAll('<?=$sort_by?>/<?=$sort_order?>/<?=$page?>','kelas/del_kelas_siswa/','kelas/<?=$ref?>/')"><img src="<?=base_url()?>asset/images/RecycleBin_Full-64.png" /></a></div>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="10%">Edit</th><th width="35%"><a href="<?=base_url()?>kelas/daftar/a.nama/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">Nama</a></th><th>Kelas</th>
	</tr>
	<?
	if($jum_kueri > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->id_kelas_sis?>-<?=$dt_kueri->nis?>">
		<td><?=form_checkbox('cek[]', $dt_kueri->id_kelas_sis)?></td><td><a href="<?=base_url()?>kelas/edit_kelas_siswa/<?=$dt_kueri->id_kelas_sis?>"><img src="<?=base_url()?>asset/images/edit.png"/></a></td><td><?=$dt_kueri->jeneng?></td><td><?=$dt_kueri->kelas?></td>
	</tr>
	<?
		$no++;
		endforeach;
	}
	else
	{
	?>
	<tr><td colspan="4" align="center">Data Masih Kosong</td></tr>
	<?
	}
	?>
</table>
</form><br />
<?=$paging?>