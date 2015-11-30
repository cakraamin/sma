<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>keahlian/add_keahlian" <? if(isset($tambah)){ echo $tambah;}?>>Tambah Data Keahlian</a></li>
		<li><a href="<?=base_url()?>keahlian/daftar" <? if(isset($daftar)){ echo $daftar;}?>>Daftar Data Keahlian</a></li>
	</ul>
</div>
<div id="content">
<?=$this->message->display();?>
<div class="isi">
<form name="formDelete" action="<?=base_url()?>keahlian/hapus" method="post">
<input type="image" src="<?=base_url()?>asset/images/RecycleBin_Full-64.png" name="woke" value="<?=current_url()?>" class="delImg" onclick="return confirmSubmit()" width="30px" title="Hapus Data Keahlian"/>
<input type="hidden" name="alamat" value="<?=current_url()?>"/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="10%">Edit</th><th width="35%"><a href="<?=base_url().shorting_page($this->uri->uri_string(),$urs,"bidang Keahlian/".(($sort_order == 'asc') ? 'desc' : 'asc'))?>">Bidang Keahlian</a></th><th><a href="<?=base_url().shorting_page($this->uri->uri_string(),$urs,"program_keahlian/".(($sort_order == 'asc') ? 'desc' : 'asc'))?>">Program Keahlian</a></th>
	</tr>
	<?
	if(count($kueri) > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->id_keahlian?>">
		<td><?=form_checkbox('cek[]', $dt_kueri->id_keahlian)?></td><td><a href="<?=base_url()?>keahlian/edit_keahlian/<?=$dt_kueri->id_keahlian?>/<?=$ref?>/<?=$sort_order?>/<?=$sort_by?>/<?=$page?>"><img src="<?=base_url()?>asset/images/edit.png"/></a></td><td><?=$dt_kueri->bidang_keahlian?></td><td><?=$dt_kueri->program_keahlian?></td>
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
</div>
<?=$this->load->view('admin/footer')?>
</div>