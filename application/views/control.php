<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>control" <? if(isset($tambah)){ echo $tambah;}?>>Control Panel System</a></li>
		<li><a href="<?=base_url()?>control/semester" <? if(isset($daftar)){ echo $daftar;}?>>Control Panel Semester</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#jam').focus();
});
</script>
<form method="post" action="<?=base_url()?>control/submit_control" class="f-wrap-1" id="formControl">
	<fieldset>		
	<h3>Control Panel Sistem</h3>
	<div class="konfirmasi">
	<?
	if($waktu > 0)
	{
		echo "<p class='caution'>Batas Masuk Jam Yang Telah Ditentukan Adalah Pukul <b>".$waktu."</b></p>";
	}
	?>
	</div>
	<label for="jam"><b>Batas Jam Absen :</b>
	<input name="kode" type="hidden" class="f-name" id="kode" value="<?=$waktu?>"/>
	<input name="jam" type="text" class="f-name" id="jam"/><br />
	<i>Format : hh:mm:ss</i>
	</label>		
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>