<div class="toolbar"><a href="javascript:void(0)" title="Hapus Data Kelas" onclick="delAll('<?=$sort_by?>/<?=$sort_order?>/<?=$page?>','kelas/del_kelas/','kelas/<?=$ref?>/')"><img src="<?=base_url()?>asset/images/RecycleBin_Full-64.png" /></a></div>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="10%">Edit</th><th><a href="<?=base_url().shorting_page($this->uri->uri_string(),$urs,"nama/".(($sort_order == 'asc') ? 'desc' : 'asc'))?>">Nama</a></th><th>Wali Kelas</th>
	</tr>
	<?
	if($jum_kueri > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->id_kelas_wali?>">
		<td><?=form_checkbox('cek[]', $dt_kueri->id_kelas)?></td><td><a href="<?=base_url()?>kelas/edit_wali/<?=$dt_kueri->id_kelas_wali?>"><img src="<?=base_url()?>asset/images/edit.png"/></a></td><td><?=$dt_kueri->nama?></td><td><?=$dt_kueri->wali?></td>
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