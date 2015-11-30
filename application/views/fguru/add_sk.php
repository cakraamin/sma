<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>fguru/administrasi/add_sk/<?=$id?>" <? if(isset($tambah)){ echo $tambah;}?>>Tambah Standard Kompetensi</a></li>		
		<li class="first"><a href="<?=base_url()?>fguru/administrasi/add_kd/<?=$id?>" <? if(isset($tambah1)){ echo $tambah1;}?>>Tambah Kompetensi Dasar</a></li>
		<li class="first"><a href="<?=base_url()?>fguru/administrasi/add_indikator/<?=$id?>" <? if(isset($tambah2)){ echo $tambah2;}?>>Tambah Indikator</a></li>
		<li><a href="<?=base_url()?>fguru/administrasi/daftar/<?=$id?>" <? if(isset($daftar)){ echo $daftar;}?>>Daftar Administrasi</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#judul1').focus();
	$('#jumlah').change(function() {
		$('#inputs').html('');
		var isi = $('#jumlah').val();
		for (i=1;i<=isi;i++)
		{
			var nilai = '<label for="judul'+ i +'"><b><span class="req"></span>Standard Kompetensi :</b>'
						+ '<input name="judul[]" type="text" class="administrasi" id="judul'+ i +'"/><br /></label>';
			if(i == 1){
				$('#inputs').html(nilai);					
			}else{
				$('#inputs').append(nilai);
			}
		}
	});
});
</script>
<form method="post" action="<?=base_url()?>fguru/administrasi/submit_sk/<?=$id?>" class="f-wrap-1" id="formKompetensi">
	<fieldset>		
	<h3>Form Tambah Standard Kompetensi</h3>		
	<div class="konfirmasi"></div>
	<label for="nama"><b><span class="req"></span>Jumlah :</b></label>	
	<?
		$pj = 'id="jumlah" class="jumlah"';
		echo form_dropdown('jumlah',$jml,'',$pj);
	?>
	<div id="inputs">
	<label for="judul1"><b><span class="req"></span>Standard Kompetensi :</b>
	<input name="judul[]" type="text" class="administrasi" id="judul1"/><br /></label>
	</div>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<input type="reset" name="reset" value="reset" id="reset" style="display:none;"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('admin/footer')?>
</div>