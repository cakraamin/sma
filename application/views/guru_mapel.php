<link rel="stylesheet" href="<?=base_url()?>asset/js/jquery-ui/development-bundle/themes/base/jquery.ui.all.css">
<script src="<?=base_url()?>asset/js/jquery-ui/js/jquery-ui-1.8.15.custom.min.js" type="text/javascript"></script>
	   
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
	$( "#mapel" ).change(function() {
		var nilai = $(this).val();
		$.get( "<?php echo base_url(); ?>mapel/getKodeMapel/"+nilai, function( data ) {		  
		  if(data == 1){
		  	$('#dual').show();
		  }else{
		  	$('#dual').hide();
		  }
		});		
	});
});
</script>
<form method="post" action="<?=base_url()?>mapel/submit_mapel_guru" class="f-wrap-1">
	<fieldset>		
	<h3>Form Data Guru Mata Pelajaran</h3>		
	<div class="konfirmasi"></div>
	<label for="jam"><b><span class="req"></span>Mata Pelajaran :</b></label>
	<?php
		$pm = 'id="mapel" class="mapel"';
		echo form_dropdown('mapel',$mapels,'',$pm);
	?>
	<br />	
	<div id="1" class="banyak">
	<label for="nama1"><b><span class="req"></span>Nama :</b>
	<input name="nama1" type="text" class="f-name" id="nama1"/><input name="nip[]" type="hidden" class="fname" id="nip1"/><br/></label>		
	<span id="dual" style="display:none">	
	<label for="nama2"><b><span class="req"></span>Nama :</b>
	<input name="nama2" type="text" class="f-name" id="nama2"/><input name="nip[]" type="hidden" class="fname" id="nip2"/><br/></label>		
	</span>
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