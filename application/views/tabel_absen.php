<div class="toolbar"><a href="javascript:void(0)" title="Hapus Data Absen" onclick="delAll('<?=$sort_by?>/<?=$sort_order?>/<?=$page?>','absen/del_absen/','absen/<?=$ref?>/')"><img src="<?=base_url()?>asset/images/RecycleBin_Full-64.png" /></a></div>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="10%">Edit</th><th width="35%"><a href="<?=base_url().shorting_page($this->uri->uri_string(),$urs,"a.nis/".(($sort_order == 'asc') ? 'desc' : 'asc'))?>">NIS</a></th><th><a href="<?=base_url().shorting_page($this->uri->uri_string(),$urs,"b.nama/".(($sort_order == 'asc') ? 'desc' : 'asc'))?>">Nama</a></th><th>Ket</th>
	</tr>
	<?
	if($jum_kueri > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->id_absen?>">
		<td><?=form_checkbox('cek[]', $dt_kueri->nis)?></td><td><a href="<?=base_url()?>absen/edit_absen/<?=$dt_kueri->id_absen?>"><img src="<?=base_url()?>asset/images/edit.png"/></a></td><td><?=$dt_kueri->nis?></td><td><?=$dt_kueri->nama?></td><td><?=$dt_kueri->ket?></td>
	</tr>
	<?
		$no++;
		endforeach;
	}
	else
	{
	?>
	<tr><td colspan="5" align="center">Data Masih Kosong</td></tr>
	<?
	}
	?>
</table>
</form><br />
<?=$paging?>