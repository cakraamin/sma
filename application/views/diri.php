<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>diri/add_diri" <? if(isset($tambah)){ echo $tambah;}?>>Tambah Pengembangan Diri</a></li>
		<li><a href="<?=base_url()?>diri/daftar" <? if(isset($daftar)){ echo $daftar;}?>>Daftar Data Pengembangan Diri</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#diri').focus();
});
</script>
<form method="post" action="<?=base_url()?>diri/submit_siswa" class="f-wrap-1" id="formDiri">
	<fieldset>		
	<h3>Form Data Pengembangan Diri</h3>		
	<div class="konfirmasi"></div>
	<label for="diri"><b><span class="req"></span>Pengembangan Diri :</b>
	<input name="diri" type="text" class="f-name" id="diri"/><br />
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