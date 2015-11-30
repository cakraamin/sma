<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#jam').focus();
});
</script>
<form method="post" action="<?=base_url()?>control/submit_control_sem" class="f-wrap-1" id="formControlSem">
	<fieldset>		
	<h3>Control Panel Semester</h3>
	<div class="konfirmasi">
	<?php
	echo "<p class='caution'>Saat Ini Semester Yang Diset Adalah Semester <b>".$semester."</b></p>";
	?>
	</div>
	<label for="jam"><b>Semester</b>
	<?php
		$ps = 'id="semester" class="semester"';
		echo form_dropdown('semester',$sem,$id_sem,$ps);
	?>
	</label>		
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>