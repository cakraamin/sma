<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>kelas/add_kelas" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Data Kelas</a></li>
		<li><a href="<?=base_url()?>kelas/daftar" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Data Kelas</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<script type="text/javascript">
function ubahJenis(){
	var jenismu = $('#jenise').val();
	if(jenismu == 0){
		$('#jurusan').show();
		$('#minate').hide();
	}else{
		$('#jurusan').hide();
		$('#minate').show();
	}
}
$(document).ready( function() {		
	$('#nama').focus();
});
</script>
<form method="post" action="<?=base_url()?>kelas/submit_edit_kelas" class="f-wrap-1" id="formKelas">
	<fieldset>		
	<h3>Form Edit Data Kelas</h3>		
	<div class="konfirmasi"></div>
	<input name="page" type="hidden" class="f-name" id="page" value="<?=get_edit(current_url(),3)?>"/>
	<label for="tingkat"><b><span class="req"></span>Jenis Kelas :</b></label>
	<?php
		$jenise = array('Kelas Tingkat','Kelas Minat');
		$pj = 'id="jenise" class="jenise" onChange="ubahJenis()"';
		echo form_dropdown('jenis',$jenise,$kueri->jenis,$pj);
	?>
	<br />
	<label for="tingkat"><b><span class="req"></span>Tingkat :</b></label>
	<?php
		$tingkat = array(
			'X'	=> 'X',
			'XI'	=> 'XI',
			'XII'	=> 'XII'		
		);
		$pt = 'id="tingkat" class="tingkat"';
		echo form_dropdown('tingkat',$tingkat,$kueri->tingkat,$pt);
	?>
	<br />
	<?php $jurusane = ($kueri->jenis == 1)?'style="display:none"':''; ?>
	<span id="jurusan" <?php echo $jurusane; ?> >
	<label for="program"><b><span class="req"></span>Penjurusan :</b></label>
	<?php
		$pp = 'id="program" class="program"';
		echo form_dropdown('program',$ahli,$kueri->kode,$pp);
	?>
	<br /></span>
	<?php $mintanan = ($kueri->jenis == 1)?'':'style="display:none"'; ?>
	<span id="minate" <?php echo $mintanan; ?> >
	<label for="minat"><b><span class="req"></span>Peminatan :</b></label>
	<?php
		$pm = 'id="minat" class="minat"';
		echo form_dropdown('minat',$minat,'',$pm);
	?>
	<br /></span>
	<label for="nama"><b><span class="req"></span>Nama Kelas :</b>
	<input name="nama" type="text" class="f-name" id="nama" value="<?=$kueri->nama?>"/><input name="kode" type="hidden" class="f-name" id="kode" value="<?=$kueri->id_kelas?>"/><br />
	</label>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>