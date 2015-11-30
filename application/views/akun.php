<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#nama').focus();
});
</script>
<form method="post" action="<?=base_url()?>account/submit_account" class="f-wrap-1" id="formAccount">
	<fieldset>		
	<h3>Form Setting Account</h3>		
	<div class="konfirmasi"></div>
	<label for="nama"><b><span class="req"></span>Username :</b>
	<input name="nama" type="text" class="f-name" id="nama" tabindex="1"/><br />
	</label>		
	<label for="passl"><b><span class="req"></span>Password :</b>
	<input name="passl" type="password" class="f-name" id="passl" tabindex="2"/><br />
	</label>
	<label for="pass"><b><span class="req"></span>Password Baru :</b>
	<input name="pass" type="password" class="f-name" id="pass" tabindex="3"/><br />
	</label>
	<label for="confrim"><b><span class="req"></span>Confirm :</b>
	<input name="confrim" type="password" class="f-name" id="confrim" tabindex="4"/><br />
	</label>					 					
	</label>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit" tabindex="5"/>
	<input type="reset" name="reset" value="reset" id="reset" style="display:none;"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>