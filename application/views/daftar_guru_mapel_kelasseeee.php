<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>mapel/add_guru_mapels/<?=$kode?>" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Guru Mapel Kelas</a></li>
		<li><a href="<?=base_url()?>mapel/guru_mapel_kelas/<?=$kode?>" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Guru Mapel Kelas</a></li>
	</ul>
</div>
<div id="content">
<?=$this->message->display();?>
<div class="isi">
<form name="formDelete" action="<?=base_url()?>mapel/del_guru_mapels" method="post">
<input type="image" src="<?=base_url()?>asset/images/RecycleBin_Full-64.png" name="woke" value="<?=current_url()?>" class="delImg" onclick="return confirmSubmit()" width="30px" title="Hapus Data Guru Mapel Kelas"/>
<input type="hidden" name="alamat" value="<?=current_url()?>"/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="10%">Edit</th><th><a href="<?=base_url().shorting_page($this->uri->uri_string(),$urs,"a.nama/".(($sort_order == 'asc') ? 'desc' : 'asc'))?>">Kelas</a></th>
	</tr>
	<?php
	if(count($kueri) > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->id_mapel_kelas?>">
		<td><?=form_checkbox('cek[]', $dt_kueri->id_mapel_kelas)?></td><td><a href="<?=base_url()?>mapel/edit_guru_mapel_kelas/<?=$kode?>/<?=$dt_kueri->id_mapel_kelas?>/<?=$ref?>/<?=$sort_by?>/<?=$sort_order?>/<?=$page?>"><img src="<?=base_url()?>asset/images/edit.png"/></a></td><td>
		<?php
			echo $dt_kueri->tingkat." "; 
			if($dt_kueri->jenis == 1)
			{
				echo $this->mmapel->getMinatId($dt_kueri->id);
			}
			else
			{
				echo $this->arey->getPenjurusan($dt_kueri->kode);
			}			
			echo " ".$dt_kueri->nama;
		?></td>
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