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
	$('#nama').focus();
});
</script>
<form method="post" action="<?=base_url()?>keahlian/submit_edit_keahlian" class="f-wrap-1" id="formAhli">
	<fieldset>		
	<h3>Form Edit Data Keahlian</h3>		
	<div class="konfirmasi"></div>
	<label for="bidang"><b><span class="req"></span>Bidang Keahlian :</b>
	<input name="bidang" type="text" class="f-name" id="bidang" value="<?=$kueri->bidang_keahlian?>"/><br />
	<input name="kode" type="hidden" class="f-name" id="kode" value="<?=$kueri->id_keahlian?>"/>
	<input name="page" type="hidden" class="f-name" id="page" value="<?=get_edit(current_url(),3)?>"/>
	</label>		
	<label for="program"><b><span class="req"></span>Program Keahlian :</b>
	<input name="program" type="text" class="f-name" id="program" value="<?=$kueri->program_keahlian?>"/><br />
	</label>
	<label for="kodea"><b><span class="req"></span>Kode Program Keahlian :</b>
	<input name="kodea" type="text" class="f-name" id="kodea" value="<?=$kueri->kode_keahlian?>"/><br />
	</label>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>