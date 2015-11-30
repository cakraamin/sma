<script type="text/javascript">
	$().ready(function() {
	});
	$(function(){
		var image_load = "<img src='"+site+"asset/images/ajax.gif' />";
		var btnUpload=$('#upload');
		var status=$('.konfirmasi');
		new AjaxUpload(btnUpload, {
			action: '<?=base_url()?>kelas/upload/<?=$id?>',
			name: 'uploadfile',
			onChange: function(file) {$('.konfirmasi').html(image_load);}, 
			onSubmit: function(file, ext){
				if (! (ext && /^(xls|csv)$/.test(ext))){ 
					var pesan = "<p class='notice'>Format File Tidak Diketahui</p>";
					$('.konfirmasi').html(pesan);
					return false;
				}
			},
			onComplete: function(file, response){
				status.text('');
				$('.konfirmasi').html(response);
				return false;
			}
		});
	});
</script>
<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>kelas/add_siswa" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Data Kelas Siswa</a></li>
		<li><a href="<?=base_url()?>kelas/daftar_siswa" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Data Kelas Siswa</a></li>
		<li><a href="<?=base_url()?>kelas/export" <?php if(isset($export)){ echo $export;}?>>Export Data Kelas Siswa</a></li>
		<li class="last"><a href="<?=base_url()?>kelas/import" <?php if(isset($import)){ echo $import;}?>>Import Data Kelas Siswa</a></li>
        <li class="last"><a href="<?=base_url()?>kelas/mutasi" <?php if(isset($mutasi)){ echo $mutasi;}?>>Mutasi Siswa</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<form method="post" action="<?=base_url()?>kelas/import_kelas" class="f-wrap-1">
	<fieldset>		
	<h3>Form Import Data Kelas</h3>	
	<p class="caution"><b>Harap Melakukan Back Up Data Terlebih Dahulu Dengan Melakukan Export Data Terlebih Dahulu Agar Tidak Terdapat Penumpukan Data, Karena Penumpukan Data Akan Menyebabkan Import Data Gagal</b></p>
	<div class="konfirmasi"></div>
		
	<label><b><span class="req"></span>Kelas :</b></label>
	<?php
		$pk = 'id="kelas" class="kelas" OnChange="this.form.submit()"';
		echo form_dropdown('kelas',$kls,$id,$pk);
	?>
	<br />					 					
	</label>	
	<label><b><span class="req"></span>File Import :</b>
	<span id="upload" class="f-submits">Import File</span>&nbsp;<a href="<?=base_url()?>kelas/sample">Download</a> contoh file import
	</label>
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>