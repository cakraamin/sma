<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>siswa/add_siswa" <? if(isset($tambah)){ echo $tambah;}?>>Tambah Data Siswa</a></li>
		<li><a href="<?=base_url()?>siswa/daftar" <? if(isset($daftar)){ echo $daftar;}?>>Daftar Data Siswa</a></li>
		<li><a href="<?=base_url()?>siswa/export" <? if(isset($export)){ echo $export;}?>>Export Data Siswa</a></li>
		<li class="last"><a href="<?=base_url()?>siswa/import" <? if(isset($import)){ echo $import;}?>>Import Data Siswa</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#nama').focus();
});
	$(function(){
		var image_load = "<img src='"+site+"asset/images/ajax.gif' />";
		var btnUpload=$('#upload');
		var status=$('#gambar');
		new AjaxUpload(btnUpload, {
			action: '<?=base_url()?>siswa/do_upload/<?=$kueri->nis?>',
			name: 'uploadfile',
			onChange: function(file) {$('#gambar').html(image_load);}, 
			onSubmit: function(file, ext){
				if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
			},
			onComplete: function(file, response){
				status.text('');
				if(response=="gagal"){
					var pesan = "<p class='notice'>Maaf Gagal Mengupload</p>";
					$('#gambar').html(response);
					return false;
				}else{
					var filename = response; 
					var dot = filename.lastIndexOf("."); 
					var extension = filename.substr(dot,filename.length); 
					if(extension == '.JPG' || extension == '.PNG' || extension == '.GIF' || extension == '.jpg' || extension == '.png' || extension == '.gif'){
						var pesan = '<img src="<?=base_url()?>uploads/thumbnail/'+response+'" alt="" />';
						$('#gambar').html(pesan);
						$('#images').val(response);
						return false;
					}else{
						alert('Ukuran Gambar Terlalu Besar');
						return false;
					}
				}
			}
		});
	});
</script>
<form method="post" action="<?=base_url()?>siswa/submit_edit_siswa" class="f-wrap-1" id="formSiswa">
	<fieldset>		
	<h3>Form Edit Data Siswa</h3>		
	<div class="konfirmasi"></div>
	<label for="nis"><b><span class="req"></span>NIS :</b>
	<input name="nis" type="text" class="f-name" id="nis" value="<?=$kueri->nis?>" disabled="disabled"/><input name="kode" type="hidden" class="f-name" id="kode" value="<?=$kueri->nis?>"/>
	<input name="page" type="hidden" class="f-name" id="page" value="<?=get_edit(current_url(),3)?>"/><br />
	</label>		
	<label for="nama"><b><span class="req"></span>Nama Lengkap :</b>	
	<input name="nama" type="text" class="f-name" id="nama" value="<?=$kueri->nama?>"/><br />
	</label>
	<label for="ahli"><b><span class="req"></span>Program Keahlian :</b></label>
	<?
		$pah = 'id="ahli" class="ahli"';
		echo form_dropdown('ahli',$ahli,$kueri->id_keahlian,$pah);
	?>
	<br />
	<label for="tempat"><b><span class="req"></span>Tempat Lahir :</b>
	<input name="tempat" type="text" class="f-name" id="tempat" value="<?=$kueri->tempat_lahir?>"/><br />
	</label>
	<label><b><span class="req"></span>Tanggal Lahir :</b></label>
	<?
		$ph = 'id="hari" class="hari"';
		echo form_dropdown('hari',$hari,$kueri->tanggal,$ph);
	?>
	<?
		$pb = 'id="bulan" class="bulan"';
		echo form_dropdown('bulan',$bulan,$kueri->bulan,$pb);
	?>
	<?
		$pt = 'id="tahun" class="tahun"';
		echo form_dropdown('tahun',$tahun,$kueri->tahun,$pt);
	?>
	<br />
	<label for="agama"><b><span class="req"></span>Agama :</b></label>
	<?
		$pa = 'id="agama" class="agama"';
		echo form_dropdown('agama',$agama,$kueri->agama,$pa);
	?>
	<br />
	<label for="alamat"><b><span class="req"></span>Alamat :</b>
	<textarea name="alamat" class="f-comments" rows="6" cols="20" id="alamat"><?=$kueri->alamat?></textarea><br />
	</label>
	<label for="alamat"><b><span class="req"></span>&nbsp;</b>
	<span id="gambar"><img src="<?=base_url()?>uploads/thumbnail/<?=$kueri->gambar?>" /></span>
	<input name="images" type="hidden" class="f-name" id="images"/>
	<br />
	</label>
	<label for="ortu"><b><span class="req"></span>Foto :</b>
	<span id="upload" class="tombolUp">Upload Foto</span><br />
	</label>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>