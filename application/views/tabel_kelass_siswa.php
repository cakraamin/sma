<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%">No</th><th width="35%">NIS</th><th><a href="<?=base_url()?>kelas/daftar/a.nama/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">Nama</a></th>
	</tr>
	<?
	if($jum_kueri > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->id_kelas_sis?>">
		<td align="center"><?=$no?></td><td><?=$dt_kueri->nis?></td><td><?=$dt_kueri->jeneng?></td>
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