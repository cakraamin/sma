<div id="content">
	<?php
		if($ta == 0)
		{
			redirect('admin/control/add_ta');
		}
	if($this->session->userdata('level') == "2")
	{
	?>
		<h5>Selamat Datang</h5>
	<?php
	}
	else
	{
	?>
	<script type="text/javascript">
	$(document).ready( function() {		
		show_captcha('.captcha');
		$('#nama').focus();
	});
	</script>
	<form method="post" action="<?=base_url()?>login" class="f-wrap-1" id="formLogin">
		<fieldset>		
		<h3>Form Login</h3>		
		<div class="konfirmasi"></div>
		<label for="name"><b><span class="req"></span>Username :</b>
		<input name="nama" type="text" class="f-name" id="nama" tabindex="1"/><br />
		</label>		
		<label for="pass"><b><span class="req"></span>Password :</b>
		<input name="pass" type="password" class="f-name" id="pass" tabindex="2"/><br />
		</label>					 					
		<label for="kode">
		<div class="captcha"></div><br />
		</label>
		<label for="kode"><b><span class="req"></span>Kode :</b>
		<input name="kode" type="text" class="f-name" id="kode" tabindex="3"/><br />
		</label>
		<div class="f-submit-wrap">
		<input type="submit" name="submit" value="Login" class="f-submit" tabindex="3"/><div class="status"></div><br />
		</fieldset>
	</form>
	<?php
	}
	?>
	<?=$this->load->view('footer')?>
</div>