<div id="utility">
	<ul id="nav-secondary">
		<li><a href="<?=base_url()?>laporan/kelas/<?=$id?>/<?=$kd_ta?>" <? if(isset($perkelas)){ echo $perkelas;}?>>Laporan Nilai</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%">NO</th><th width="10%"><a href="<?=base_url()?>laporan/kelas/<?=$id?>/<?=$kd_ta?>/b.nis/<?=(($short_order == 'asc') ? 'desc' : 'asc')?>">NIS</a></th><th width="25%"><a href="<?=base_url()?>laporan/kelas/<?=$id?>/<?=$kd_ta?>/b.nama/<?=(($short_order == 'asc') ? 'desc' : 'asc')?>">Nama</a></th><th>Nilai</th>
	</tr>
	<?
	if($jum_kueris > 0)
	{
		$no = 1;
		foreach($kueris as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?>>
		<td align="center"><?=$no?></td><td><?=$dt_kueri->nis?></td><td><?=$dt_kueri->nama?></td><td>ok</td>
	</tr>
	<?
		$no++;
		endforeach;
	}
	else
	{
	?>
	<tr><td colspan="3" align="center">Data Masih Kosong</td></tr>
	<?
	}
	?>
</table>
<?=$this->load->view('footer')?>
</div>