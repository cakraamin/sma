<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>kelas/add_siswa" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Data Kelas Siswa</a></li>
		<li><a href="<?=base_url()?>kelas/daftar_siswa" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Data Kelas Siswa</a></li>
		<li><a href="<?=base_url()?>kelas/export" <?php if(isset($export)){ echo $export;}?>>Export Data Kelas Siswa</a></li>
		<li class="last"><a href="<?=base_url()?>kelas/import" <?php if(isset($import)){ echo $import;}?>>Import Data Kelas Siswa</a></li>
        <li class="last"><a href="<?=base_url()?>kelas/mutasi" <?php if(isset($mutasi)){ echo $mutasi;}?>>Mutasi Siswa</a></li>
	</ul>
</div>
<script language="javascript" type="text/javascript">
	jQuery(function(){
		$("#formMutasi").submit(function(){
			var post_data = $(this).serialize();
			var form_action = $(this).attr("action");
			var form_method = $(this).attr("method");
			$.ajax({
				type : form_method,
				url : form_action,
				cache: false,
				data : post_data,
				success : function(response){
					if(response == 'gagal'){
						$('#info').html('<p class="error"> Mutasi Siswa Gagal </p>');
					}else{
						var myArray = response.split('-');

						for(var i=1;i<myArray.length;i++){
							$('#'+myArray[i]).hide();
						}
						$('#info').html('<p class="succes"> Mutasi Siswa Berhasil </p>');
					}
				}
			});
			return false;
		});		
	});
</script>
<div id="content">
<div class="cari">
<form method="post" action="<?=base_url()?>kelas/simpan_mutasi" id="formMutasi">
	<label for="kunci"><b>Kelas :</b>
	<?php
		$pk = 'id="kelas" class="kelas"';
		echo form_dropdown('kelas',$klas,'',$pk);
	?>
	</label>  <input type="submit" name="submit" value="Mutasi" class="f-submit"/>
</div><hr />
<div class="isi">
<span id="info"></span>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="25%">NIS</th><th>Nama</th><th width="20%">Kelas</th>
	</tr>
	<?php
	if(count($kueri) > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
		$alamat = ($kls == "" || $kls == "0")?"0":$kls;
	?>
	<tr <?=$klas?> id="<?=$dt_kueri->nis?>">
		<td><?=form_checkbox('cek[]', $dt_kueri->nis)?></td><td><?=$dt_kueri->nis?></td><td><?=$dt_kueri->jeneng?></td><td><?=$dt_kueri->tingkat?> <?=$dt_kueri->kode?> <?=$dt_kueri->kelas?></td>
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