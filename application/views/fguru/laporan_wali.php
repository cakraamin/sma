<link rel="stylesheet" href="<?=base_url()?>asset/js/jquery-ui/development-bundle/themes/base/jquery.ui.all.css">
<script src="<?=base_url()?>asset/js/jquery-ui/development-bundle/ui/jquery.ui.core.js"></script>
<script src="<?=base_url()?>asset/js/jquery-ui/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="<?=base_url()?>asset/js/jquery-ui/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
	</script>
<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>fguru/laporan" <?php if(isset($guru)){ echo $guru;}?>>Guru Mapel</a></li>		
		<?php
		if($sWali != 0)
		{
			?><li class="first"><a href="<?=base_url()?>fguru/laporan/wali/<?php echo $sWali; ?>" <?php if(isset($wali)){ echo $wali;}?>>Wali Kelas</a></li><?php
		}	
		?>		
	</ul>
</div>
<div id="content">
	<?=$this->message->display();?>
<div class="cari">
<form method="post" action="<?=base_url()?>fguru/laporan/submit_wali/<?php echo $sWali; ?>">	
	<label for="kunci"><b>Mata Pelajaran :</b>
		<?php echo form_dropdown('mapel', $mapels); ?>
	</label><br/><br/>
	<input class="f-submit" type="submit" value="Generate" name="submit">	
</form>
</div>
<?=$this->load->view('admin/footer')?>
</div>