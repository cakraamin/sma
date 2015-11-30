<script type="text/javascript">
$(document).ready( function() {		
	show_captcha('.captcha');
	$('#nama').focus();
});
</script>
<form action="<?=base_url()?>register/daftar" method="post" class="f-wrap-1" id="formForgot">
	<fieldset>		
	<h3>Forgot Your Password</h3>		
	<label for="nama"><b><span class="req"></span>Username :</b>
	<input name="nama" type="text" class="f-name" id="nama" tabindex="1"/><br />
	</label>				
	<label for="email"><b><span class="req"></span>Email:</b>
	<input name="email" type="text" class="f-email" id="email" tabindex="2"/><br />
	</label>	
	<label for="kode"><div class="captcha"></div><a href="javascript:void(0)" onclick="show_captcha('.captcha')"><img src="<?=base_url()?>asset/images/refresh.gif" class="icon" /></a><br /><b><span class="req"></span>Kode :</b>
	<input name="kode" type="text" class="f-name" id="kode" tabindex="3"/><br />
	</label>			 				
	<div class="f-submit-wrap">
	<input type="submit" value="Get Password" class="f-submit"/><div class="status"><p>Alhamdulillah</p></div><br />
	</div>
	</fieldset>
</form>