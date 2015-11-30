<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>diri/add_diri" <? if(isset($tambah)){ echo $tambah;}?>>Tambah Pengembangan Diri</a></li>
		<li><a href="<?=base_url()?>diri/daftar" <? if(isset($daftar)){ echo $daftar;}?>>Daftar Data Pengembangan Diri</a></li>
	</ul>
</div>
</div>
<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#nama').focus();
});
</script>
<form method="post" action="<?=base_url()?>diri/submit_edit_diri" class="f-wrap-1" id="formSiswa">
	<fieldset>		
	<h3>Form Edit Data Siswa</h3>		
	<div class="konfirmasi"></div>
	<input name="page" type="hidden" class="f-name" id="page" value="<?=get_edit(current_url(),3)?>"/>
	<label for="diri"><b><span class="req"></span>Pengembangan Diri :</b>
	<input name="kode" type="hidden" class="f-name" id="kode" value="<?=$kueri->id_diri?>"/>	
	<input name="diri" type="text" class="f-name" id="diri" value="<?=$kueri->pengembangan_diri?>"/><br />
	</label>	
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>