<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>guru/add_guru" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Data Guru</a></li>
		<li><a href="<?=base_url()?>guru/daftar" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Data Guru</a></li>
		<li><a href="<?=base_url()?>guru/export" <?php if(isset($export)){ echo $export;}?>>Export Data Guru</a></li>
		<li class="last"><a href="<?=base_url()?>guru/import" <?php if(isset($import)){ echo $import;}?>>Import Data Guru</a></li>
	</ul>
</div>
<div id="content">
<?=$this->message->display();?>
<div class="cari">
<form method="post" action="<?=base_url()?>guru/submit_cari">
	<label for="kunci"><b>Nama :</b>
	<input name="kunci" type="text" class="f-name" id="kunci" value="<?php if(isset($kunci)){ echo $kunci;} ?>"/>
	</label>		
	<input type="submit" name="submit" value="Cari" class="f-submit"/>
</form>
</div><hr />
<div class="isi">
<form name="formDelete" action="<?=base_url()?>guru/hapus" method="post">
<input type="image" src="<?=base_url()?>asset/images/RecycleBin_Full-64.png" name="woke" value="<?=current_url()?>" class="delImg" onclick="return confirmSubmit()" width="30px" title="Hapus Data Guru"/>
<input type="hidden" name="alamat" value="<?=current_url()?>"/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="10%">Edit</th><th width="35%"><a href="<?=base_url().shorting_page($this->uri->uri_string(),$urs,"nip/".(($sort_order == 'asc') ? 'desc' : 'asc'))?>">NIP</a></th><th><a href="<?=base_url().shorting_page($this->uri->uri_string(),$urs,"nama/".(($sort_order == 'asc') ? 'desc' : 'asc'))?>">Nama</a></th>
	</tr>
	<?php
	if(count($kueri) > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->nip?>">
		<td><?=form_checkbox('cek[]', $dt_kueri->nip)?></td><td><a href="<?=base_url()?>guru/edit_guru/<?=$dt_kueri->nip?>/<?=$ref?>/<?=$sort_by?>/<?=$sort_order?>/<?=$page?>"><img src="<?=base_url()?>asset/images/edit.png"/></a></td><td><?=$dt_kueri->nip?></td><td><?=$dt_kueri->nama?></td>
	</tr>
	<?php
		$no++;
		endforeach;
	}
	else
	{
	?>
	<tr><td colspan="4" align="center">Data Masih Kosong</td></tr>
	<?php
	}
	?>
</table>
</form><br />
<?=$paging?>
</div>
<?=$this->load->view('admin/footer')?>
</div>