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
		<li class="first"><a href="<?=base_url()?>laporan" <?php if(isset($tambah)){ echo $tambah;}?>>Perkelas</a></li>
	</ul>
</div>
<div id="content">
<?=$this->message->display();?>
<div class="cari">
<form method="post" action="<?=base_url()?>laporan/submit_laporan">
	<label for="nama"><b>Jenis Laporan :</b>
	<?php
		echo form_dropdown('jlaporan',$jlaporan);
	?></label><br/><br/>
	<label for="nama"><b>Kelas :</b>
	<?php		
		$pk = 'id="kelas" class="kelas" ';
		echo form_dropdown('kelas',$kelasmu,'',$pk);
	?>
	</label><br/><br/>
	<label for="kunci"><b>Tanggal Penyerahan :</b>
		<input type="text" id="datepicker" name="tanggal">
	</label><br/><br/>
	<input class="f-submit" type="submit" value="Generate" name="submit">		
</form>
</div>
<?=$this->load->view('admin/footer')?>
</div>