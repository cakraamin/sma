<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>kelas/add_wali" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Data Wali Kelas</a></li>
		<li><a href="<?=base_url()?>kelas/daftar_wali" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Data Wali Kelas</a></li>
	</ul>
</div>
<div id="content">
<?=$this->message->display();?>
<div class="isi">
<form name="formDelete" action="<?=base_url()?>kelas/hapus_wali" method="post">
<input type="image" src="<?=base_url()?>asset/images/RecycleBin_Full-64.png" name="woke" value="<?=current_url()?>" class="delImg" onclick="return confirmSubmit()" width="30px" title="Hapus Data Wali Kelas"/>
<input type="hidden" name="alamat" value="<?=current_url()?>"/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="10%">Edit</th><th><a href="<?=base_url().shorting_page($this->uri->uri_string(),$urs,"nama/".(($sort_order == 'asc') ? 'desc' : 'asc'))?>">Nama</a></th><th>Wali Kelas</th>
	</tr>
	<?php
	if(count($kueri) > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->id_kelas_wali?>">
		<td><?=form_checkbox('cek[]', $dt_kueri->id_kelas_wali)?></td><td><a href="<?=base_url()?>kelas/edit_wali/<?=$dt_kueri->id_kelas_wali?>/<?=$ref?>/<?=$sort_by?>/<?=$sort_order?>/<?=$page?>"><img src="<?=base_url()?>asset/images/edit.png"/></a></td><td>
		<?php
			echo $dt_kueri->tingkat." ";
			if($dt_kueri->jenis == 1)
			{
				echo $this->mkelas->getMinatId($dt_kueri->id);
			}
			else
			{
				echo $this->arey->getPenjurusan($dt_kueri->kode);
			}			
			echo " ".$dt_kueri->nama;
		?></td>
		<td><?=$dt_kueri->wali?></td>
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