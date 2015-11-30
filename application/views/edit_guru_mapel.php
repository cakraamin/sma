<link rel="stylesheet" href="<?=base_url()?>asset/js/jquery-ui/development-bundle/themes/base/jquery.ui.all.css">
<script src="<?=base_url()?>asset/js/jquery-ui/js/jquery-ui-1.8.15.custom.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready( function() {		
	$('.banyak').hide('slow');
	$('#1').show('slow');
	$('#team').change(function() {
		var isi = $('#team').val();
		$('.banyak').hide('slow');
		for(var i=1;i<=isi;i++){
			$('#'+i).show('slow');
		}
	});	
	$("#nama1").autocomplete({
		minLength: 1,
		source: 
		function(req, add){
			$.ajax({
				url: "<?php echo base_url(); ?>mapel/search",
				dataType: 'json',
				type: 'POST',
				data: req,
				success:    
				function(data){
					if(data.response =="true"){
						add(data.message);
					}
				},
			});
		},
		select: 
		function(event, ui) {
			$("#result").append(
				"<li>"+ ui.item.value + "</li>"
			);       
			$('#nip1').val(ui.item.id);	    	
		},		
	});
	$("#nama2").autocomplete({
		minLength: 1,
		source: 
		function(req, add){
			$.ajax({
				url: "<?php echo base_url(); ?>mapel/search",
				dataType: 'json',
				type: 'POST',
				data: req,
				success:    
				function(data){
					if(data.response =="true"){
						add(data.message);
					}
				},
			});
		},
		select: 
		function(event, ui) {
			$("#result").append(
				"<li>"+ ui.item.value + "</li>"
			);       
			$('#nip2').val(ui.item.id);	    	
		},		
	});
	$("#nama3").autocomplete({
		minLength: 1,
		source: 
		function(req, add){
			$.ajax({
				url: "<?php echo base_url(); ?>mapel/search",
				dataType: 'json',
				type: 'POST',
				data: req,
				success:    
				function(data){
					if(data.response =="true"){
						add(data.message);
					}
				},
			});
		},
		select: 
		function(event, ui) {
			$("#result").append(
				"<li>"+ ui.item.value + "</li>"
			);       
			$('#nip3').val(ui.item.id);	    	
		},		
	});
	$("#nama4").autocomplete({
		minLength: 1,
		source: 
		function(req, add){
			$.ajax({
				url: "<?php echo base_url(); ?>mapel/search",
				dataType: 'json',
				type: 'POST',
				data: req,
				success:    
				function(data){
					if(data.response =="true"){
						add(data.message);
					}
				},
			});
		},
		select: 
		function(event, ui) {
			$("#result").append(
				"<li>"+ ui.item.value + "</li>"
			);       
			$('#nip4').val(ui.item.id);	    	
		},		
	});
});
</script>
<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>mapel/add_guru_mapel" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Data Guru Mapel</a></li>
		<li><a href="<?=base_url()?>mapel/guru_mapel" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Data Guru Mapel</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#nip').focus();
});
</script>
<form method="post" action="<?=base_url()?>mapel/submit_edit_mapel_guru/<?=$kueri->id_team?>" class="f-wrap-1" id="formMapelGuru">
	<fieldset>		
	<h3>Form Edit Data Guru Mata Pelajaran</h3>		
	<div class="konfirmasi"></div>
	<label for="jam"><b><span class="req"></span>Mata Pelajaran :</b></label>
	<input name="page" type="hidden" class="f-name" id="page" value="<?=get_edit(current_url(),3)?>"/>
	<?php
		$pm = 'id="mapel" class="mapel"';
		echo form_dropdown('mapel',$mapels,$kueri->id_mapel,$pm);
	?>
	<br />
	<?php
		$kueri = $this->mmapel->getAllGuruEdit($kueri->id_team);
		$no = 1;
		foreach($kueri as $data_kueri)
		{
	?>
	<label for="nama<?=$no?>"><b><span class="req"></span>Nama :</b>
	<input name="nama[]" type="text" class="f-name" id="nama<?=$no?>" value="<?=$data_kueri->nama?>"/><input name="kd[]" type="hidden" class="f-name" value="<?=$data_kueri->id_guru_mapel?>"/><input name="nip[]" type="hidden" class="f-name" id="nip<?=$no?>" value="<?=$data_kueri->nip?>"/><br /></label>	
	<?php
			$no++;
		}	
	?>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<input type="reset" name="reset" value="reset" id="reset" style="display:none;"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>