<script type="text/javascript">
function langsung(ID){
	var nilai = $('.nilai'+ID).val();
	if(Number(nilai)){
		if(nilai > 100){
			alert('Maaf Nilai Terlalu Besar');
			$('.nilai'+ID).val('');
			$('.nilai'+ID).focus();
		}
	}else{
		$('.nilai'+ID).val('');
		$('.nilai'+ID).focus();
	}
	return false;
};
$(document).ready( function() {		
	$("input[type='text']").change( function() {
		alert('ok');
	});
	$('#submit_add').click(function() {
		var isi = $(this).attr("value");
		if(isi == "Tambah"){
			$(this).attr("value","Simpan");
			var no = 1;
			$('.tabel_isi').each(function(){
				var nilai = $(this).attr("id");
				var explode = nilai.split('_');
				var jj = $("#"+nilai).text();
				if(explode[3] == ""){
					var kolom = '<input name="kkm" type="text" class="nilai'+no+'" id="kkm'+explode[1]+'" value="" maxlength="3" onkeyup="langsung('+no+')"/>';
					$("#"+nilai).html(kolom);
				}else{
					var kolom = '<input name="kkm" type="text" class="nilai'+no+'" id="kkm'+explode[1]+'" value="'+jj+'" maxlength="3" onkeyup="langsung('+no+')"/>';
					$("#"+nilai).html(kolom);
				}
				no++;
			});
		}else{
			$(this).attr("value","Tambah");
			var q = 1;
			var indk = 1;
			var myArray = new Array();
			$('.tabel_isi').each(function(){
				var nilai = $(this).attr("id");
				var explode = nilai.split('_');
				var biji = $('#kkm'+explode[1]).val();
				myArray[indk] = biji;				
				if(explode[3] == ""){
					if(indk % 3 == 0){
						var kkm1 = myArray[indk-2];
						var kkm2 = myArray[indk-1];
						var kkm3 = myArray[indk]; 
						$.ajax({
							type: "POST",
							url: site+"kkm/input_kkm/"+kkm1+"/"+kkm2+"/"+kkm3+"/"+explode[2],
							success: function(html){
								if(html == 'gagal'){
									return false;							
								}else{
									$("#kkm1_"+explode[1]+"_"+explode[2]+"_").attr("id","kkm1_"+explode[1]+"_"+explode[2]+"_"+html);
									$("#kkm2_"+explode[1]+"_"+explode[2]+"_").attr("id","kkm2_"+explode[1]+"_"+explode[2]+"_"+html);
									$("#kkm3_"+explode[1]+"_"+explode[2]+"_").attr("id","kkm3_"+explode[1]+"_"+explode[2]+"_"+html);							
								}
							}
						});					
					}					
				}else{	
					if(indk % 3 == 0){
						var kkm1 = myArray[indk-2];
						var kkm2 = myArray[indk-1];
						var kkm3 = myArray[indk]; 
						$.ajax({
							type: "POST",
							url: site+"kkm/update_kkm/"+kkm1+"/"+kkm2+"/"+kkm3+"/"+explode[3],
							success: function(html){
								if(html == 'gagal'){
									return false;							
								}
							}
						});					
					}				
				}
				if(biji == ""){
					var jj = $("#"+nilai).html('Kosong');
				}else{
					var jj = $("#"+nilai).html(biji);
				}
				indk++;
			});
		} 		
	});
});
</script>
<div id="content">
<div class="isi">
<input type="button" name="submit" value="Tambah" class="f-submit" id="submit_add"/><br/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%">NO</th><th width="25%"><a href="<?=base_url()?>kkm/index/b.nis/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">Nama</a></th><th>Nilai KKM Kelas 1</th><th>Nilai KKM Kelas 2</th><th>Nilai KKM Kelas 3</th>
	</tr>
	<?
	if(count($kueri) > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?>>
		<td align="center"><?=$no?></td><td><?=$dt_kueri->mapel?></td>
		<?
			$kkm = $this->mkkm->getKkmIsi($dt_kueri->id_mapel);
			if(count($kkm) > 0)
			{
				echo '<td align="center" class="tabel_isi" id="kkm1_'.$no.'_'.$dt_kueri->id_mapel.'_'.$kkm->id_kkm.'">'.$kkm->kkm1.'</td>';
				echo '<td align="center" class="tabel_isi" id="kkm2_'.$no.'_'.$dt_kueri->id_mapel.'_'.$kkm->id_kkm.'">'.$kkm->kkm2.'</td>';
				echo '<td align="center" class="tabel_isi" id="kkm3_'.$no.'_'.$dt_kueri->id_mapel.'_'.$kkm->id_kkm.'">'.$kkm->kkm3.'</td>';
			}
			else
			{
				echo '<td align="center" class="tabel_isi" id="kkm1_'.$no.'_'.$dt_kueri->id_mapel.'_">Kosong</td>';
				echo '<td align="center" class="tabel_isi" id="kkm2_'.$no.'_'.$dt_kueri->id_mapel.'_">Kosong</td>';
				echo '<td align="center" class="tabel_isi" id="kkm3_'.$no.'_'.$dt_kueri->id_mapel.'_">Kosong</td>';
			} 		
		?>	
	</tr>
	<?
		$no++;
		endforeach;
	}
	else
	{
	?>
	<tr><td colspan="3" align="center">Data Masih Kosong</td></tr>
	<?
	}
	?>
</table>
</div>
<?=$this->load->view('admin/footer')?>
</div>