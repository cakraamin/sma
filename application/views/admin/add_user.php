<link rel="stylesheet" href="<?=base_url()?>asset/js/jquery-ui/development-bundle/themes/base/jquery.ui.all.css">
<script src="<?=base_url()?>asset/js/jquery-ui/js/jquery-ui-1.8.15.custom.min.js" type="text/javascript"></script>

<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>admin/user/add_user" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Data User</a></li>
		<li class="last"><a href="<?=base_url()?>admin/user" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Data User</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<script type="text/javascript">
$(document).ready( function() {		
	$('#name').focus();
	$('#delik').hide('slow');
	$('#pengguna').change(function() {
		var jenis = $('#pengguna').val();
		if(jenis == 2){
			$('#delik').hide('slow');
		}else{
			$('#delik').show('slow');	
		}
	});
	$("#nama").autocomplete({
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
			$('#nip').val(ui.item.id);	    	
		},		
	});
});
</script>
<form method="post" action="<?=base_url()?>admin/user/submit_user" class="f-wrap-1">
	<fieldset>		
	<h3>Form Tambah User</h3>		
	<div class="konfirmasi"></div>
	<label for="name"><b><span class="req"></span>Nama Lengkap :</b>
	<input name="name" type="text" class="f-name" id="name"/><br />
	</label>		
	<label for="alamat"><b>Alamat :</b>
	<textarea name="alamat" class="f-comments" rows="6" cols="20" id="alamat"></textarea><br />
	</label>
	<label for="jam"><b><span class="req"></span>Pengguna :</b></label>
	<?php
		$pp = 'id="pengguna" class="pengguna"';
		echo form_dropdown('pengguna',$pengguna,'',$pp);
	?>
	<label for="nama" id="delik"><b><span class="req"></span>Nama :</b>
	<input name="nama" type="text" class="f-name" id="nama"/><input name="nip" type="hidden" class="fname" id="nip"/></label>
	<br />
	<label for="nama"><b><span class="req"></span>Username :</b>
	<input name="nama" type="text" class="f-name" id="nama"/><br />
	</label>		
	<label for="pass"><b><span class="req"></span>Password :</b>
	<input name="pass" type="password" class="f-name" id="pass"/><br />
	</label>
	<label for="confrim"><b><span class="req"></span>Confirm :</b>
	<input name="confrim" type="password" class="f-name" id="confrim"/><br />
	</label>					 					
	</label>
	<div class="f-submit-wrap">
	<input type="submit" name="submit" value="Simpan" class="f-submit"/>
	<input type="reset" name="reset" value="reset" id="reset" style="display:none;"/>
	<div class="status"></div><br />
	</fieldset>
</form>
</div>
<?=$this->load->view('admin/footer')?>
</div>