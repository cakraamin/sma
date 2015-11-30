<style type="text/css">
#flay_form{	
	margin: 20px;	
}
#flay_form select{	
	padding: 2px;
	width: 80px;
}
#flay_form input[type="submit"]{
	float: left;
}
.kirine{
	float: left;
	width: 200px;	
	clear: both;
}
label.error{
	font-size: 10px;
	margin-left: 200px;
}
</style>
<script type="text/javascript">
function submitFormNilaine(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	var kodene = $('#kode').val();
	$('#formNilaine').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formNilaine :input').attr('disabled', true);
		},
		success: function(response){			
			$('.status').html('');
			$('#formNilaine :input').removeAttr('disabled');
			var obj = jQuery.parseJSON( response );
			if(obj.status == "gagal"){
				alert('Maaf Gagal');
			}else{
				jQuery.facebox.close();
				$('#'+obj.kode).html("<a onclick='panggil(/"+obj.newK+"/)'>"+obj.nilai+"</a>");
				$('#'+obj.kode).attr('id', obj.newK);
			}
		}, 
		dataType: 'html'
	});
	return false;
};
$(document).ready( function() {
	$("#formNilaine").validate({
		submitHandler:function(form) {
			submitFormNilaine();
		},
		rules: {
			buka:{
				required: true,
				maxlength: 2
			},
			tekun:{
				required: true,
				maxlength: 2
			},
			rajin:{
				required: true,
				maxlength: 2
			},
			rasa:{
				required: true,
				maxlength: 2
			},
			disiplin:{
				required: true,
				maxlength: 2
			},
			kerjasama:{
				required: true,
				maxlength: 2
			},
			ramah:{
				required: true,
				maxlength: 2
			},
			hormat:{
				required: true,
				maxlength: 2
			},
			jujur:{
				required: true,
				maxlength: 2
			},
			janji:{
				required: true,
				maxlength: 2
			},
			peduli:{
				required: true,
				maxlength: 2
			},
			jawab:{
				required: true,
				maxlength: 2
			}			
		},
		messages: {
			buka:{
				required: "Kolom Keterbukaan Harus Diisi",
				maxlength: 'Password minimal 6 karakter'
			},
			tekun:{
				required: "Kolom Ketekunan Belajar Harus Diisi",
				maxlength: 'Password minimal 6 karakter'
			},
			rajin:{
				required: "Kolom Kerajin Harus Diisi",
				maxlength: 'Password minimal 6 karakter'
			},
			rasa:{
				required: "Kolom Tengang Rasa Harus Diisi",
				maxlength: 'Password minimal 6 karakter'
			},
			disiplin:{
				required: "Kolom Disiplinan Harus Diisi",
				maxlength: 'Password minimal 6 karakter'
			},
			kerjasama:{
				required: "Kolom Kerjasama Harus Diisi",
				maxlength: 'Password minimal 6 karakter'
			},
			ramah:{
				required: "Kolom Ramah dengan Teman Harus Diisi",
				maxlength: 'Password minimal 6 karakter'
			},
			hormat:{
				required: "Kolom Hormat Pada Orang Tua Harus Diisi",
				maxlength: 'Password minimal 6 karakter'
			},
			jujur:{
				required: "Kolom Kejujuran Harus Diisi",
				maxlength: 'Password minimal 6 karakter'
			},
			janji:{
				required: "Kolom Menepati Janji Harus Diisi",
				maxlength: 'Password minimal 6 karakter'
			},
			peduli:{
				required: "Kolom Kepedulian Harus Diisi",
				maxlength: 'Password minimal 6 karakter'
			},
			jawab:{
				required: "Kolom Tanggungjawab Harus Diisi",
				maxlength: 'Password minimal 6 karakter'
			}			
		}
	});
});
</script>
<form action="<?php echo base_url(); ?>fguru/nilai/<?php echo $links; ?>" method="POST" id="formNilaine">
<div id="flay_form">	
	<?php
	if($jns == 2)
	{
		$no = 1;
		foreach($kueri as $dt_kueri)
		{			
			?><div class="baris"><span class="kirine"><?php echo $dt_kueri['fom']; ?></span><input type="text" name="buka[]" id="buka" value="<?php echo (isset($dt_kueri['nilai']['nilai_'.$no]))?$dt_kueri['nilai']['nilai_'.$no]:""; ?>"></div><?php	
			$no++;
		}
	}
	else
	{
		?>
		<div class="baris"><span class="kirine">Keterbukaan</span><input type="text" name="buka" id="buka" value="<?php echo isset($kueri->nilai_buka)?$kueri->nilai_buka:""; ?>"></div>
		<div class="baris"><span class="kirine">Ketekunan belajar</span><input type="text" name="tekun" id="takun" value="<?php echo isset($kueri->nilai_tekun)?$kueri->nilai_tekun:""; ?>"></div>
		<div class="baris"><span class="kirine">Kerajinan</span><input type="text" name="rajin" id="rajin" value="<?php echo isset($kueri->nilai_rajin)?$kueri->nilai_rajin:""; ?>"></div>
		<div class="baris"><span class="kirine">Tenggang rasa</span><input type="text" name="rasa" id="rasa" value="<?php echo isset($kueri->nilai_rasa)?$kueri->nilai_rasa:""; ?>"></div>
		<div class="baris"><span class="kirine">Kedisiplinan</span><input type="text" name="disiplin" id="disiplin" value="<?php echo isset($kueri->nilai_disiplin)?$kueri->nilai_disiplin:""; ?>"></div>
		<div class="baris"><span class="kirine">Kerjasama</span><input type="text" name="kerjasama" id="kerjasama" value="<?php echo isset($kueri->nilai_kerjasama)?$kueri->nilai_kerjasama:""; ?>"></div>
		<div class="baris"><span class="kirine">Ramah dengan teman</span><input type="text" name="ramah" id="ramah" value="<?php echo isset($kueri->nilai_ramah)?$kueri->nilai_ramah:""; ?>"></div>
		<div class="baris"><span class="kirine">Hormat pada orang tua</span><input type="text" name="hormat" id="hormat" value="<?php echo isset($kueri->nilai_hormat)?$kueri->nilai_hormat:""; ?>"></div>
		<div class="baris"><span class="kirine">Kejujuran</span><input type="text" name="jujur" id="jujur" value="<?php echo isset($kueri->nilai_jujur)?$kueri->nilai_jujur:""; ?>"></div>
		<div class="baris"><span class="kirine">Menepati janji</span><input type="text" name="janji" id="janji" value="<?php echo isset($kueri->nilai_janji)?$kueri->nilai_janji:""; ?>"></div>
		<div class="baris"><span class="kirine">Kepedulian</span><input type="text" name="peduli" id="peduli" value="<?php echo isset($kueri->nilai_peduli)?$kueri->nilai_peduli:""; ?>"></div>
		<div class="baris"><span class="kirine">Tanggung jawab</span><input type="text" name="jawab" id="jawab" value="<?php echo isset($kueri->nilai_jawab)?$kueri->nilai_jawab:""; ?>"></div>
		<?php
	}
	?>
	<input type="hidden" name="id_guru_mapel" value="<?php echo $id_guru_mapel; ?>">
	<input type="hidden" name="nis" value="<?php echo $nis; ?>">
	<input type="hidden" name="id_kelas" value="<?php echo $id_kelas; ?>">
	<input type="hidden" name="tingkat" value="<?php echo $tingkat; ?>">
	<input type="hidden" name="kode" value="<?php echo $kode; ?>" id="kode">	
</div>
<div class="kirine">&nbsp;</div><input type="submit" name="kirim" value="Simpan" class="f-submit"><input type="button" name="button" value="Keluar" onclick="jQuery.facebox.close();" class="f-submit">&nbsp;<div class="status"></div>
</form>