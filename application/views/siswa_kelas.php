<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#kode').focus();
});
</script>
<form method="post" action="<?=base_url()?>account/submit_account" class="f-wrap-1" id="formAccount">
	<fieldset>		
	<h3>Form Data Siswa Kelas</h3>		
	<div class="konfirmasi"></div>
	<label for="kode"><b><span class="req"></span>Kode Kelas :</b>
	<input name="kode" type="text" class="f-name" id="kode"/><br />
	</label>		
	<label for="nama"><b><span class="req"></span>Nama Kelas :</b>
	<input name="nama" type="text" class="f-name" id="nama"/><br />
	</label>
	<label><b><span class="req"></span>Wali Kelas :</b></label>
	<?
		$ph = 'id="hari" class="hari"';
		echo form_dropdown('hari',$hari,'',$ph);
	?>
	<br />					 					
	</label>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<input type="reset" name="reset" value="reset" id="reset" style="display:none;"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
