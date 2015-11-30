<div id="content">
<div class="isi">
<div class="cari">
<form method="post" action="<?=base_url()?>laporan/submit_lap">
	<label><b><span class="req"></span>Kelas :</b></label>
	<?
		$pk = 'id="kelas" class="kelas"';
		echo form_dropdown('kelas',$kelas,'',$pk);
	?>
	<br /><br />
	<label for="ta"><b><span class="req"></span>Tahun Ajaran :</b></label>
	<?
		$pt = 'id="ta" class="ta"';
		echo form_dropdown('ta',$ta,$this->session->userdata('kd_ta'),$pt);
	?>
	<br />
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Laporan" class="f-submit"/>
	<div class="status"></div>		
</form>
</div>
</div>
<?=$this->load->view('footer')?>
</div>