<div class="toolbar"><a href="javascript:void(0)" title="Hapus Data Mata Pelajaran" onclick="delAll('<?=$sort_by?>/<?=$sort_order?>/<?=$page?>','mapel/del_mapel/','mapel/<?=$ref?>/')"><img src="<?=base_url()?>asset/images/RecycleBin_Full-64.png" /></a></div>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="10%">Edit</th><th><a href="<?=base_url().shorting_page($this->uri->uri_string(),$urs,"mapel/".(($sort_order == 'asc') ? 'desc' : 'asc'))?>">Mata Pelajaran</a></th><th>Jumlah Jam</th>
	</tr>
	<?
	if($jum_kueri > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->id_mapel?>">
		<td><?=form_checkbox('cek[]', $dt_kueri->id_mapel)?></td><td><a href="<?=base_url()?>mapel/edit_mapel/<?=$dt_kueri->id_mapel?>"><img src="<?=base_url()?>asset/images/edit.png"/></a></td><td><?=$dt_kueri->mapel?></td><td><?=$dt_kueri->jum_jam_mapel?> Jam</td>
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