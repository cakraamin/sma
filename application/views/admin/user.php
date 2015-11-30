<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>admin/user/add_user" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Data User</a></li>
		<li class="last"><a href="<?=base_url()?>admin/user" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Data User</a></li>
	</ul>
</div>
<div id="content">
<?=$this->message->display();?>
<div class="konfirmasi"></div>
<div class="isi">
<div class="toolbar">
<form name="formDelete" action="<?=base_url()?>admin/user/hapus" method="post">
<input type="image" src="<?=base_url()?>asset/images/RecycleBin_Full-64.png" name="woke" value="<?=current_url()?>" class="delImg" onclick="return confirmSubmit()" width="30px"/>
<input type="hidden" name="alamat" value="<?=current_url()?>"/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="35%"><a href="<?=base_url()?>admin/user/daftar/nameid/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>/<?=$page?>">Nama</a></th><th><a href="<?=base_url()?>admin/user/daftar/userid/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>/<?=$page?>">User Name</a></th><th>Status</th>
	</tr>
	<?php
	if(count($kueri) > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
		if($dt_kueri->tingkatid == 1)
		{
			$tingkat = "Administrator";
		}
		elseif($dt_kueri->tingkatid == 2)
		{
			$tingkat = "Operator";
		}
		else
		{
			$tingkat = "Guru";
		}
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->user_id?>">
		<td><?=form_checkbox('cek[]', $dt_kueri->user_id)?></td><td><?=$dt_kueri->nameid?></td><td><?=$dt_kueri->nameid?></td><td><?=$tingkat?></td>
	</tr>
	<?php
		$no++;
		endforeach;
	}
	else
	{
	?>
	<tr><td colspan="3" align="center">Data Masih Kosong</td></tr>
	<?php
	}
	?>
</table>
</form><br />
<?=$paging?>
</div>
<?=$this->load->view('admin/footer')?>
</div>