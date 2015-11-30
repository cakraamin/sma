<div id="content">
<script type="text/javascript">
$( document ).ready(function() {
    $( ".tingkat" ).change(function() {
		var jumlah = $(this).val();
		var hasil = "";		
		for (i = 1; i <= jumlah; i++) { 
			nilai = $("input[name^='aspek']").eq(i-1).val();
			if(typeof nilai == 'undefined'){
				var isine = "";
			}else{
				var isine = nilai;
			}
			hasil += '<label for="nama"><b><span class="req"></span><?php echo $isine; ?> '+i+' :</b><input type="text" name="aspek[]" class="f-name" value="'+isine+'"></label>';		
		}	
		$('#tingkatane').html(hasil);
	});
});
</script>
<div class="isi">
<form method="post" action="<?=base_url()?>aspek/input_aspek/<?php echo $kode; ?>/<?php echo $id; ?>/<?php echo $order; ?>" class="f-wrap-1" id="formAspek">
	<fieldset>		
	<h3>Form Data Aspek <?php echo $keterangan?></h3>		
	<div class="konfirmasi"></div>			
	<input type="hidden" name="kode" value="<?php echo $kode; ?>" id="kode">
	<label for="mapel"><b><span class="req"></span>Nama Mapel :</b>	
	<?php echo form_dropdown('mapel', $mapele,isset($kueri['id_mapel'])?$kueri['id_mapel']:0 , 'class="mapel"'); ?><br />
	</label>	
	<label for="tingkat"><b><span class="req"></span>Jumlah Aspek :</b>			
	<?php echo form_dropdown('tingkat', $tingkat,isset($kueri['jumlah'])?$kueri['jumlah']:1 , 'class="tingkat"'); ?><br />
	</label>		
	<span id="tingkatane">
		<?php 
		if(count($kueri['detaile']) > 0)
		{
			foreach($kueri['detaile'] as $key => $detils)
			{
				$no = $key + 1;
				?>
				<label for="nama"><b><span class="req"></span><?php echo $isine?> <?php echo $no; ?> :</b>
					<input type="text" name="aspek[]" class="f-name" value="<?php echo isset($detils)?$detils:""; ?>">
				</label>	
				<?php			
			}
		}	
		else
		{
			?><label for="nama"><b><span class="req"></span><?php echo $isine?> 1 :</b>
			<input type="text" name="aspek[]" class="f-name" value="<?php echo isset($detils)?$detils:""; ?>">
			</label><?php
		}	
		?>		
	</span>	
	<?php
	if($kode == 1)
	{
		?>
		<label for="mapel"><b><span class="req"></span>KKM :</b>	
		<input type="text" name="kkm" id="kkm" value="<?php if(isset($kueri['kkm'])){ echo $kueri['kkm']; } ?>">
		</label>	
		<?php
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