<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>mapel/add_guru_mapel" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Data Guru Mapel</a></li>
		<li><a href="<?=base_url()?>mapel/guru_mapel" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Data Guru Mapel</a></li>
	</ul>
</div>
<div id="content">
<?=$this->message->display();?>
<div class="cari">
<form method="post" action="<?=base_url()?>mapel/submit_cari_mapel">
	<label for="kunci"><b>Nama :</b>
	<input name="kunci" type="text" class="f-name" id="kunci" value="<?php if(isset($kunci)){ echo $kunci;} ?>"/>
	</label>		
	<input type="submit" name="submit" value="Cari" class="f-submit"/>
</form>
</div><hr />
<div class="isi">
<form name="formDelete" action="<?=base_url()?>mapel/del_guru_mapel" method="post">
<input type="image" src="<?=base_url()?>asset/images/RecycleBin_Full-64.png" name="woke" value="<?=current_url()?>" class="delImg" onclick="return confirmSubmit()" width="30px" title="Hapus Data Guru Mapel"/>
<input type="hidden" name="alamat" value="<?=current_url()?>"/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="10%">Edit</th><th width="40%"><a href="<?=base_url().shorting_page($this->uri->uri_string(),$urs,"b.mapel/".(($sort_order == 'asc') ? 'desc' : 'asc'))?>">Pelajaran</a></th><th>Nama</th>
	</tr>
	<?php
	if(count($kueri) > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->id_team?>">
	<?php
		$guru = $this->mmapel->getAllGuru($dt_kueri->id_team);
		$persen = $this->mmapel->getAllPersen($dt_kueri->id_team);	
	?>
		<td><?=form_checkbox('cek[]', $dt_kueri->id_team)?></td><td><a href="<?=base_url()?>mapel/edit_guru_mapel/<?=$dt_kueri->id_team?>/<?=$ref?>/<?=$sort_by?>/<?=$sort_order?>/<?=$page?>"><img src="<?=base_url()?>asset/images/edit.png"/></a></td><td><?=$dt_kueri->mapel?></td><td><?=$guru?></td>
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