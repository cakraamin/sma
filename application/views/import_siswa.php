<script type="text/javascript">
	$().ready(function() {
	});
	$(function(){
		var image_load = "<img src='"+site+"asset/images/ajax.gif' />";
		var btnUpload=$('#upload');
		var status=$('.konfirmasi');
		new AjaxUpload(btnUpload, {
			action: '<?=base_url()?>siswa/upload/<?php echo $id; ?>',
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
		<li class="first"><a href="<?=base_url()?>siswa/add_siswa" <? if(isset($tambah)){ echo $tambah;}?>>Tambah Data Siswa</a></li>
		<li><a href="<?=base_url()?>siswa/daftar" <? if(isset($daftar)){ echo $daftar;}?>>Daftar Data Siswa</a></li>
		<li><a href="<?=base_url()?>siswa/export" <? if(isset($export)){ echo $export;}?>>Export Data Siswa</a></li>
		<li class="last"><a href="<?=base_url()?>siswa/import" <? if(isset($import)){ echo $import;}?>>Import Data Siswa</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<form method="post" action="" class="f-wrap-1">
	<fieldset>		
	<h3>Form Import Data Siswa</h3>	
	<p class="caution"><b>Harap Melakukan Back Up Data Terlebih Dahulu Dengan Melakukan Export Data Terlebih Dahulu Agar Tidak Terdapat Penumpukan Data, Karena Penumpukan Data Akan Menyebabkan Import Data Gagal</b></p>
	<div class="konfirmasi"></div>
	<label><b><span class="req"></span>File Import :</b>
	<input type="submit" name="submit" value="Import File" class="f-submit" id="upload"/>&nbsp;<a href="<?=base_url()?>siswa/sample">Download</a> contoh file import
	</label>
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>