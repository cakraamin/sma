<link rel="stylesheet" href="<?=base_url()?>asset/js/jquery-ui/development-bundle/themes/base/jquery.ui.all.css">
<script src="<?=base_url()?>asset/js/jquery-ui/js/jquery-ui-1.8.15.custom.min.js" type="text/javascript"></script>
	    
<script type="text/javascript">
$(this).ready( function() {
	$("#nama").autocomplete({
    	minLength: 1,
      	source: 
        function(req, add){
			$.ajax({
				url: "<?php echo base_url(); ?>kelas/search",
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
			$('#nip').val(ui.item.id);	    	
        },		
   	});
});
</script>
<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>kelas/add_wali" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Data Wali Kelas</a></li>
		<li><a href="<?=base_url()?>kelas/daftar_wali" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Data Wali Kelas</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#nip').focus();
});
</script>
<form method="post" action="<?=base_url()?>kelas/submit_kelas_wali" class="f-wrap-1" id="formKelasWali">
	<fieldset>		
	<h3>Form Data Wali</h3>		
	<div class="konfirmasi"></div>
	<label for="agama"><b><span class="req"></span>Kelas :</b></label>
	<?php
		$pk = 'id="kelas" class="kelas"';
		echo form_dropdown('kelas',$kls,'',$pk);
	?>
	<br />
	<label for="nama"><b><span class="req"></span>Nama Guru :</b>
	<input name="nama" type="text" class="f-name" id="nama"/>
	<input name="nip" type="hidden" class="f-name" id="nip"/><br />
	</label>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<input type="reset" name="reset" value="reset" id="reset" style="display:none;"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('footer')?>
</div>