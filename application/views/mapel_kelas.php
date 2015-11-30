<div id="content">
<?=$this->message->display();?>
<div class="cari">
<form method="post" action="<?=base_url()?>mapel/submit_guru_kelas">
	<label for="kunci"><b>Kelas Asal :</b>
	<?php
		$pk = 'id="kelas" class="kelas" OnChange="this.form.submit()"';
		echo form_dropdown('kelas',$klas,$kls,$pk);
	?>
	</label>
</div><hr />
</form>
<div class="isi">
<form name="formDelete" action="<?=base_url()?>mapel/hapus_mapel_kelas" method="post">
<input type="image" src="<?=base_url()?>asset/images/RecycleBin_Full-64.png" name="woke" value="<?=current_url()?>" class="delImg" onclick="return confirmSubmit()" width="30px" title="Hapus Data Kelas"/>
<input type="hidden" name="alamat" value="<?=current_url()?>"/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="10%">Edit</th><th>Mata Pelajaran</th><th>Guru Mata Pelajaran</th>
	</tr>
	<?php	
	if(count($kueri) > 0)
	{		
		foreach($kueri as $key => $dt_kueri)
		{
			$links = ($kls == "0")?"":"<a href='".base_url()."mapel/tambah_guru_kelas/".$key."/".$kls."'>Tambah Mata Pelajaran</a>";
			echo "<tr><td colspan='4'><b>Kelompok ".$key." </b>".$links."</td></tr>";			
			foreach($dt_kueri as $detail)
			{
				echo "<tr><td align='center'>".form_checkbox('cek[]', $detail['kode_mapel_kelas'])."</td><td><a href='".base_url()."mapel/edit_mapel_kelas/".$detail['kode_mapel_kelas']."/".$key."/".$kls."'><img src='".base_url()."asset/images/edit.png'/></a></td><td>".$detail['mapel']."</td><td>".$detail['nama']."</td></tr>";				
			}
		}		
	}
	else
	{
	?>
	<tr><td colspan="4" align="center">Data Masih Kosong</td></tr>
	<?php
	}
	?>
</table><br/>
</form>
</div>
<?=$this->load->view('admin/footer')?>
</div>