<div id="content">
<div class="isi">
<form method="post" action="<?=base_url()?>mapel/simpan_guru_kelas/<?php echo $jenis; ?>/<?php echo $kls; ?>" class="f-wrap-1" id="formMapelKelas">
	<fieldset>		
	<h3>Form Data Mapel Kelas</h3><a href="<?php echo base_url(); ?>mapel/guru_kelas/<?php echo $kls; ?>">Kembali</a>
	<div id="1" class="banyak">
	<label for="nama1"><b><span class="req"></span>Nama :</b>
	<?php
		$pm = 'id="mapel" class="mapel"';
		echo form_dropdown('mapel',$mapels,'',$pm);
	?>
	<br/></label>			
	<input type="hidden" name="kelasnya" id="kelasnya" value="<?php echo $kls; ?>"/> 
	</div>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<input type="reset" name="reset" value="reset" id="reset" style="display:none;"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>