<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#nip').focus();
});
</script>
<form method="post" action="<?=base_url()?>control/<?=$kontrol?>" class="f-wrap-1" id="formControlKepala">
	<fieldset>		
	<h3>Control Kepala Sekolah</h3>
	<div class="konfirmasi"></div>
	<label for="nip"><b>NIP </b>
	<input name="nip" type="text" class="f-name" id="nip" value="<?php if(isset($kueri->nip_kep)){ echo $kueri->nip_kep; } ?>"/><br /></label>		
	<label for="nama"><b>Nama </b>
	<input name="nama" type="text" class="f-name" id="nama" value="<?php if(isset($kueri->nama_kep)){ echo $kueri->nama_kep; } ?>"/><br /></label>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>