<div class="toolbar"><a href="javascript:void(0)" title="Hapus Data Guru Mata Pelajaran" onclick="delAll('<?=$sort_by?>/<?=$sort_order?>/<?=$page?>','mapel/del_guru_mapels/','mapel/<?=$ref?>/')"><img src="<?=base_url()?>asset/images/RecycleBin_Full-64.png" /></a></div>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="10%">Edit</th><th><a href="<?=base_url().shorting_page($this->uri->uri_string(),$urs,"a.nama/".(($sort_order == 'asc') ? 'desc' : 'asc'))?>">Kelas</a></th>
	</tr>
	<?
	if($jum_kueri > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->id_mapel_kelas?>">
		<td><?=form_checkbox('cek[]', $dt_kueri->id_mapel_kelas)?></td><td><a href="<?=base_url()?>mapel/edit_guru_mapel_kelas/<?=$kode?>/<?=$dt_kueri->id_mapel_kelas?>"><img src="<?=base_url()?>asset/images/edit.png"/></a></td><td><?=$dt_kueri->nama?></td>
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