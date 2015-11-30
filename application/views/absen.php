<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>absen/add_absen" <? if(isset($tambah)){ echo $tambah;}?>>Tambah Data Absen</a></li>
		<li><a href="<?=base_url()?>absen" <? if(isset($daftar)){ echo $daftar;}?>>Daftar Data Absen</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#nis').focus();
});
</script>
<form method="post" action="<?=base_url()?>absen/submit_absen" class="f-wrap-1" id="formAbsensi">
	<fieldset>		
	<h3>Form Data Absensi Siswa</h3>		
	<div class="konfirmasi"></div>
	<label for="nis"><b><span class="req"></span>NIS :</b>
	<input name="nis" type="text" class="f-name" id="nis"/><br />
	</label>		
	<fieldset class="f-radio-wrap">
		<b>Keterangan:</b>
		<fieldset>		
		<?
		$no = 1;
		foreach($keterangan as $dt_ket)
		{
			$cek = ($no == '1')?"checked='checked'":"";
			echo '<label for="'.$dt_ket->ket.'"><input id="'.$dt_ket->ket.'" type="radio" name="ket" value="'.$dt_ket->id_ket.'" class="f-radio" '.$cek.'/>'.$dt_ket->ket.'</label>';
			$no++;
		}
		?>		
		</fieldset>
		</fieldset><br />
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<input type="reset" name="reset" value="reset" id="reset" style="display:none;"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>