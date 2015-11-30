<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>mapel/guru_mapel_kelas" <?php if(isset($tambah)){ echo $tambah;}?>>Pilih Guru Mapel Kelas</a></li>
		<li><a href="<?=base_url()?>mapel/daftar_guru_mapel_kelas" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Guru Mapel per-Kelas</a></li>
	</ul>
</div>
<div id="content">
<?=$this->message->display();?>
<div class="cari">
<form method="post" action="<?=base_url()?>mapel/pilih_daftar_kelas">
	<label for="kunci"><b>Kelas :</b>
	<?php
		$pk = 'id="kelas" class="kelas" OnChange="this.form.submit()"';
		echo form_dropdown('kelas',$klas,$kls,$pk);
	?>
	</label>
</form>
</div><hr />
<div class="isi">
<form name="formDelete" action="<?=base_url()?>kelas/hapus_kelas_siswa" method="post">
<input type="image" src="<?=base_url()?>asset/images/RecycleBin_Full-64.png" name="woke" value="<?=current_url()?>" class="delImg" onclick="return confirmSubmit()" width="30px" title="Hapus Data Kelas Siswa"/>
<input type="hidden" name="alamat" value="<?=current_url()?>"/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="10%">Edit</th><th width="25%">Mata Pelajaran</th><th>Guru</th>
	</tr>
	<?php
	if(count($kueri) > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
		$alamat = ($kls == "" || $kls == "0")?"0":$kls;
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri['id_mapel_kelas']?>-<?=$dt_kueri['id_kelas']?>">
		<td><?=form_checkbox('cek[]', $dt_kueri['id_mapel_kelas'])?></td><td><a href="<?=base_url()?>kelas/edit_kelas_siswa/<?=$dt_kueri['id_mapel_kelas']?>"><img src="<?=base_url()?>asset/images/edit.png"/></a></td><td><?=$dt_kueri['mapel']?></td><td><?=$dt_kueri['nama']?></td>
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
</div>
<?=$this->load->view('admin/footer')?>
</div>