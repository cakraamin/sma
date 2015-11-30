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
	$('#judul').focus();
});
</script>
<form method="post" action="<?=base_url()?>fguru/administrasi/submit_edit_kd/<?=$id?>/<?=$kueri->id_administrasi?>" class="f-wrap-1" id="formKompetensi">
	<fieldset>		
	<h3>Form Edit Kompetensi Dasar</h3>		
	<div class="konfirmasi"></div>
	<label for="judul"><b><span class="req"></span>Kompetensi Dasar :</b>
	<input name="judul" type="text" class="administrasi" id="judul" value="<?=$kueri->administrasi?>"/><br /></label>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<input type="reset" name="reset" value="reset" id="reset" style="display:none;"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('admin/footer')?>
</div>