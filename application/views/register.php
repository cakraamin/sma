<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/css/register.css" media="screen" />
<form method="post" action="<?=base_url()?>register/input" class="f-wrap-1" id="formSiswa">
	<div id="kolom">
	<fieldset>		
	<h3>Form Register</h3>
	<?=$this->message->display();?>		
	<input name="satu" type="text" class="nilai" maxlength="5"/> - 
	<input name="dua" type="text" class="nilai" maxlength="5"/> - 
	<input name="tiga" type="text" class="nilai" maxlength="5"/> - 
	<input name="empat" type="text" class="nilai" maxlength="5"/> - 
	<input name="lima" type="text" class="nilai" maxlength="5"/> - 
	<input name="enam" type="text" class="nilai" maxlength="5"/>
	<input type="submit" name="submit" value="Register" class="f-submit"/>
	</fieldset>
	</div>
</form>