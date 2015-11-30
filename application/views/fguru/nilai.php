<div id="content">
<?=$this->message->display();?>
<div class="cari">
<form method="post" action="<?=base_url()?>fguru/nilai/submit_nilai">
	<label for="kunci"><b>Mapel :</b>
	<?php
		$pm = 'id="mapel" class="mapel" OnChange="this.form.submit()" ';
		echo form_dropdown('mapel',$mapels,'',$pm);
	?>
	</label>		
</form>
</div><hr />
<?=$this->load->view('admin/footer')?>
</div>