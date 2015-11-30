<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>mapel/add_mapel" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Data Mapel</a></li>
		<li><a href="<?=base_url()?>mapel/daftar" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Data Mapel</a></li>
	</ul>
</div>
<div id="content">
<?=$this->message->display();?>
<div class="cari">
<form method="post" action="<?=base_url()?>mapel/submit_cari">
	<label for="kunci"><b>Nama :</b>
	<input name="kunci" type="text" class="f-name" id="kunci" value="<?php if(isset($kunci)){ echo $kunci;} ?>"/>
	</label>		
	<input type="submit" name="submit" value="Cari" class="f-submit"/>
</form>
</div><hr />
<div class="isi">
<form name="formDelete" action="<?=base_url()?>mapel/del_mapel" method="post">
<input type="image" src="<?=base_url()?>asset/images/RecycleBin_Full-64.png" name="woke" value="<?=current_url()?>" class="delImg" onclick="return confirmSubmit()" width="30px" title="Hapus Data Mata Pelajaran"/>
<input type="hidden" name="alamat" value="<?=current_url()?>"/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="10%">Edit</th><th><a href="<?=base_url().shorting_page($this->uri->uri_string(),$urs,"mapel/".(($sort_order == 'asc') ? 'desc' : 'asc'))?>">Mata Pelajaran</a></th><th>Kelompok Mapel</th><th>Keterangan</th>
	</tr>
	<?php
	if(count($kueri) > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->id_mapel?>">
		<td><?=form_checkbox('cek[]', $dt_kueri->id_mapel)?></td><td><a href="<?=base_url()?>mapel/edit_mapel/<?=$dt_kueri->id_mapel?>/<?=$ref?>/<?=$sort_by?>/<?=$sort_order?>/<?=$page?>"><img src="<?=base_url()?>asset/images/edit.png"/></a></td><td><?=$dt_kueri->mapel?></td><td><?=$this->arey->getKelompok($dt_kueri->jenis)?></td><td align="center"><?php if($dt_kueri->dual_guru == 1){ echo "Dua Guru"; } ?></td>
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
</form><br />
<?=$paging?>
</div>
<?=$this->load->view('admin/footer')?>
</div>