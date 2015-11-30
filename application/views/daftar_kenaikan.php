<div id="content">
<?=$this->message->display();?>
<div class="cari">
<form method="post" action="<?=base_url()?>kenaikan/pilih_kelas">
	<label for="kunci"><b>Kelas Asal :</b>
	<?php
		$pk = 'id="kelas" class="kelas" OnChange="this.form.submit()"';
		echo form_dropdown('kelas',$klas,$kls,$pk);
	?>
	</label><br/>
	</form><form method="post" action="<?=base_url()?>kenaikan/naik_kelas">
	<label for="kunci"><b>Naik Kelas :</b>
	<?php
		$npk = 'id="nkelas" class="nkelas"';
		echo form_dropdown('Nkelas',$Nklas,'',$npk);
	?>
	</label><br/><br/>
	<input type="submit" name="submit" value="Naik Kelas" />
</div><hr />
<div class="isi">
<input type="hidden" name="alamat" value="<?=current_url()?>"/>
<input type="hidden" name="ta_berikut" value="<?php echo $d_ta['berikut']['id']; ?>"/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="10%">Edit</th><th width="25%">NIS</th><th><a href="<?=base_url()?>kelas/daftar/a.nama/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">Nama</a></th><th><?php echo $d_ta['sekarang']['tahun']; ?></th><th><?php echo $d_ta['berikut']['tahun']; ?></th>
	</tr>
	<?php
	if(count($kueri) > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
		$alamat = ($kls == "" || $kls == "0")?"0":$kls;
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri['id_kelas_sis']?>-<?=$dt_kueri['nis']?>">
		<td><?=form_checkbox('cek[]', $dt_kueri['nis'])?></td><td><a href="<?=base_url()?>kelas/edit_kelas_siswa/<?=$dt_kueri['id_kelas_sis']?>/<?=$ref?>/<?=$alamat?>/<?=$sort_by?>/<?=$sort_order?>"><img src="<?=base_url()?>asset/images/edit.png"/></a></td><td><?=$dt_kueri['nis']?></td><td><?=$dt_kueri['jeneng']?></td><td align="center"><?=$dt_kueri['sekarang']?></td><td align="center"><?=$dt_kueri['depan']?></td>
	</tr>
	<?php
		$no++;
		endforeach;
	}
	else
	{
	?>
	<tr><td colspan="5" align="center">Data Masih Kosong</td></tr>
	<?php
	}
	?>
</table>
</form>
</div>
<?=$this->load->view('admin/footer')?>
</div>