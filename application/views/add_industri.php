<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#nama').focus();
});
</script>
<form method="post" action="<?=base_url()?>industri/input_nilai/<?=$kls?>/<?=$nis?>" class="f-wrap-1" id="formNilai">
	<fieldset>		
	<h3>Form Data Nilai DU/DI</h3>		
	<div class="konfirmasi"></div>		
	<label for="nama"><b><span class="req"></span>Nama DU/DI :</b>
	<input name="page" type="hidden" class="f-name" id="page" value="<?=$kls?>"/>	
	<input name="nama" type="text" class="f-name" id="nama"/><br />
	</label>
	<label for="alamat"><b><span class="req"></span>Alamat DU/DI :</b>
	<textarea name="alamat" class="f-comments" rows="6" cols="20" id="alamat"></textarea><br />
	</label>
	<label for="lama"><b><span class="req"></span>Lama :</b>
	<input name="lama" type="text" class="f-name" id="lama"/><br />
	</label>
	<label for="nilai"><b><span class="req"></span>Nilai DU/DI :</b>
	<input name="nilai" type="text" class="f-name" id="nilai"/><br />
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