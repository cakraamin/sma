<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>fguru/nilai/set_nilai/<?=$id?>" <? if(isset($tambah)){ echo $tambah;}?>>Setting Nilai</a></li>
		<li><a href="<?=base_url()?>fguru/nilai/daftar/<?=$id?>" <? if(isset($daftar)){ echo $daftar;}?>>Daftar Nilai</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<form method="post" action="<?=base_url()?>fguru/nilai/submit_set_nilai/<?=$id?>" class="f-wrap-1" id="formSetNilai">
	<fieldset>		
	<h3>Form Set Nilai</h3>		
	<div class="konfirmasi">
	<?
		if($stat != '')
		{
	?>
			<p class='caution'>Set Nilai Sudah Diatur Berdasarkan <b><?=$stat?></b></p>	
	<?
		}	
	?>	
	</div>
	<label for="nama"><b><span class="req"></span>Jumlah :</b></label>	
	<?
		$nilai = array('Standard Kompetensi','Kompetensi Dasar','Indikator');
		$pn = 'id="nilai" class="nilai"';
		echo form_dropdown('nilai',$nilai,$stt,$pn);
	?>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<input type="reset" name="reset" value="reset" id="reset" style="display:none;"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('admin/footer')?>
</div>