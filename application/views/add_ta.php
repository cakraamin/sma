<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>control/add_ta" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Tahun Ajaran</a></li>
		<li><a href="<?=base_url()?>control/ta" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Tahum Ajaran</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#ta').focus();
});
</script>
<form method="post" action="<?=base_url()?>control/<?=$kontrol?>" class="f-wrap-1" id="formControlTa">
	<fieldset>		
	<h3>Form Tahun Ajaran</h3>
	<div class="konfirmasi"></div>
	<label for="ta"><b>Tahun Ajaran </b>
	<input name="ta" type="text" class="f-name" id="ta" value="<?=$tahun?>" disabled="disabled"/><br /></label>
    <input type="hidden" name="tahun" value="<?=$tahun?>" />
    <input type="hidden" name="kode" value="<?=$kode?>" />
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>