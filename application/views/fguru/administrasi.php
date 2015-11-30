<div id="content">
<div class="cari">
<form method="post" action="<?=base_url()?>fguru/administrasi/submit_administrasi">
	<label for="kunci"><b>Mapel :</b>
	<?
		$pm = 'id="mapel" class="mapel" OnChange="this.form.submit()" ';
		echo form_dropdown('mapel',$mapels,'',$pm);
	?>
	</label>		
</form>
</div><hr />
<?=$this->load->view('admin/footer')?>
</div>