<div id="content">
<div class="isi">
<form method="post" action="<?=base_url()?>fguru/catatan/submit_edit_catatan/<?=$id?>" class="f-wrap-1" id="formCatat">
	<fieldset>		
	<h3>Form Tambah Catatan</h3>		
	<div class="konfirmasi"></div>
	<label for="catat"><b><span class="req"></span>Catatan :</b>
		<textarea name="catat" class="f-comments" rows="6" cols="40" id="catat"><?=$kueri->catatan?></textarea>
	</label><br/>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<input type="reset" name="reset" value="reset" id="reset" style="display:none;"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('admin/footer')?>
</div>