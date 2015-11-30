<div id="content">
<?=$this->message->display();?>
<div class="cari">
<form method="post" action="<?=base_url()?>industri/submit_industri">
	<label for="kunci"><b>Kelas :</b>
	<?
		if(count($klas) > 1)
		{
			$pk = 'id="kelas" class="kelas" OnChange="this.form.submit()"';
			echo form_dropdown('kelas',$klas,$kls,$pk);
	?>
	</label>
	<? } ?>
</form>
</div><hr />
<div class="isi">
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%">NO</th><th width="25%"><a href="<?=base_url()?>industri/daftar/<?=$kls?>/b.nis/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">NIS</a></th><th><a href="<?=base_url()?>fguru/nilai/daftar/<?=$kls?>/b.nama/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">Nama</a></th><th width="10%">Nilai</th>
	</tr>
	<?
	if($jum_kueri > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?>>
		<td align="center"><?=$no?></td><td><?=$dt_kueri->nis?></td><td><?=$dt_kueri->nama?></td>
	<?
		$iid = $this->mindustri->getIdNilai($dt_kueri->nis,$kls); 	
	?>
		<td class="tabel_isi" id="<?=$dt_kueri->nis?>_<?=$kls?>_<?=$iid?>" align="center">
	<?
		$nilai = $this->mindustri->getNilai($dt_kueri->nis,$kls);
		$isi = ($nilai == "kosong")?"<a href='".base_url()."industri/form_nilai/".$kls."/".$dt_kueri->nis."'>Kosong</a>":"<a href='".base_url()."industri/form_edit_nilai/".$kls."/".$nilai->id_industri."'>".$nilai->industri."</a>";
		echo $isi;
	?>
		</td>
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
</div>
<?=$this->load->view('admin/footer')?>
</div>