<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>keahlian/add_keahlian" <? if(isset($tambah)){ echo $tambah;}?>>Tambah Data Keahlian</a></li>
		<li><a href="<?=base_url()?>keahlian/daftar" <? if(isset($daftar)){ echo $daftar;}?>>Daftar Data Keahlian</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#bidang').focus();
});
</script>
<form method="post" action="<?=base_url()?>keahlian/submit_keahlian" class="f-wrap-1" id="formAhli">
	<fieldset>		
	<h3>Form Data Keahlian</h3>		
	<div class="konfirmasi"></div>
	<label for="bidang"><b><span class="req"></span>Bidang Keahlian :</b>
	<input name="bidang" type="text" class="f-name" id="bidang"/><br />
	</label>		
	<label for="program"><b><span class="req"></span>Program Keahlian :</b>
	<input name="program" type="text" class="f-name" id="program"/><br />
	</label>
	<label for="kodea"><b><span class="req"></span>Kode Program Keahlian :</b>
	<input name="kodea" type="text" class="f-name" id="kodea"/><br />
	</label>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<input type="reset" name="reset" value="reset" id="reset" style="display:none;"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>