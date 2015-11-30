<script type="text/javascript">
function langsung(ID){
	var nilai = $('.nilais'+ID).val();
	if(Number(nilai)){
		if(nilai > 100){
			alert('Maaf Nilai Terlalu Besar');
			$('.nilais'+ID).val('');
			$('.nilais'+ID).focus();
		}
	}else{
		$('.nilais'+ID).val('');
		$('.nilais'+ID).focus();
	}
	return false;
};
$(document).ready( function() {		
	$('#submit_add').click(function() {
		var isi = $(this).attr("value");
		if(isi == "Tambah"){
			$(this).attr("value","Simpan");
			var no = 1;
			$('.tabel_isi').each(function(){
				var nilai = $(this).attr("id");
				var explode = nilai.split('_');
				var jj = $("#"+nilai).text();
				if(explode[6] == ""){
					if(explode[3] == 1){
						var kolom1 = '<input name="nilai1" type="text" class="nilais'+no+'1" id="nilai1'+explode[1]+'" value="" maxlength="3" onkeyup="langsung('+no+'1)"/>x NH';	
					}else{
						var kolom1 = '<input name="nilai1" type="hidden" class="nilais'+no+'1" id="nilai1'+explode[1]+'" value="0" maxlength="3" onkeyup="langsung('+no+'1)"/>';					
					}
					if(explode[4] == 1){
						var kolom2 = '+<input name="nilai2" type="text" class="nilais'+no+'2" id="nilai2'+explode[1]+'" value="" maxlength="3" onkeyup="langsung('+no+'2)"/>x NT';	
					}else{
						var kolom2 = '<input name="nilai2" type="hidden" class="nilais'+no+'2" id="nilai2'+explode[1]+'" value="0" maxlength="3" onkeyup="langsung('+no+'2)"/>';					
					}
					if(explode[5] == 1){
						var kolom3 = '+<input name="nilai3" type="text" class="nilais'+no+'3" id="nilai3'+explode[1]+'" value="" maxlength="3" onkeyup="langsung('+no+'3)"/>x NU';	
					}else{
						var kolom3 = '<input name="nilai3" type="hidden" class="nilais'+no+'3" id="nilai3'+explode[1]+'" value="0" maxlength="3" onkeyup="langsung('+no+'3)"/>';					
					}
					var total = kolom1+kolom2+kolom3;
				}else{
					var isi = $(this).html();
					var pecah = isi.split('+');
					if(pecah[0] != ""){
						var ketok1 = pecah[0].split('x');
						var kolom1 = '<input name="nilai1" type="text" class="nilais'+no+'1" id="nilai1'+explode[1]+'" value="'+ketok1[0]+'" maxlength="3" onkeyup="langsung('+no+'1)"/>x NH';	
					}else{
						var kolom1 = '<input name="nilai1" type="hidden" class="nilais'+no+'1" id="nilai1'+explode[1]+'" value="0" maxlength="3" onkeyup="langsung('+no+'1)"/>';					
					}
					if(pecah.length > 1){
						if(pecah[1] != ""){
							var ketok2 = pecah[1].split('x');
							var kolom2 = '+<input name="nilai2" type="text" class="nilais'+no+'2" id="nilai2'+explode[1]+'" value="'+ketok2[0]+'" maxlength="3" onkeyup="langsung('+no+'2)"/>x NT';	
						}else{
							var kolom2 = '<input name="nilai2" type="hidden" class="nilais'+no+'2" id="nilai2'+explode[1]+'" value="0" maxlength="3" onkeyup="langsung('+no+'2)"/>';					
						}
						if(pecah.length > 2){
							if(pecah[2] != ""){
								var ketok3 = pecah[2].split('x');
								var kolom3 = '+<input name="nilai3" type="text" class="nilais'+no+'3" id="nilai3'+explode[1]+'" value="'+ketok3[0]+'" maxlength="3" onkeyup="langsung('+no+'3)"/>xNU';	
							}else{
								var kolom3 = '<input name="nilai3" type="hidden" class="nilais'+no+'3" id="nilai3'+explode[1]+'" value="0" maxlength="3" onkeyup="langsung('+no+'3)"/>';					
							}
						}else{
							var kolom3 = '<input name="nilai3" type="hidden" class="nilais'+no+'3" id="nilai3'+explode[1]+'" value="0" maxlength="3" onkeyup="langsung('+no+'3)"/>';
						}
					}else{
						var kolom2 = '<input name="nilai2" type="hidden" class="nilais'+no+'2" id="nilai2'+explode[1]+'" value="0" maxlength="3" onkeyup="langsung('+no+'2)"/>';
						var kolom3 = '<input name="nilai3" type="hidden" class="nilais'+no+'3" id="nilai3'+explode[1]+'" value="0" maxlength="3" onkeyup="langsung('+no+'3)"/>';
					}
					var total = kolom1+kolom2+kolom3;
				}
				$("#"+nilai).html(total);
				no++;
			});
		}else{
			$(this).attr("value","Tambah");
			var q = 1;
			var indk = 1;
			var myArray = new Array();
			var myArray1 = new Array();
			var myArray2 = new Array();
			$('.tabel_isi').each(function(){
				var nilai = $(this).attr("id");
				var explode = nilai.split('_');
				var biji = $('#nilai1'+explode[1]).val();
				var biji1 = $('#nilai2'+explode[1]).val();
				var biji2 = $('#nilai3'+explode[1]).val();
				myArray[indk] = biji;
				myArray1[indk] = biji1;
				myArray2[indk] = biji2;	
				if(myArray[indk] == "" || myArray1[indk] == "" || myArray2[indk] == ""){
					alert('Kolom Tidak Boleh Ada Yang Kosong');
					return false;				
				}
				indk++;
			});			
			$('.tabel_isi').each(function(){
				var nilai = $(this).attr("id");
				var explode = nilai.split('_');
				var biji = $('#nilai1'+explode[1]).val();
				var biji1 = $('#nilai2'+explode[1]).val();
				var biji2 = $('#nilai3'+explode[1]).val();
				myArray[indk] = biji;
				myArray1[indk] = biji1;
				myArray2[indk] = biji2;	
				if(explode[6] == ""){
					if(indk % 3 == 0){
						var nilai1 = myArray[indk-2]+"-"+myArray1[indk-2]+"-"+myArray2[indk-2];
						var nilai2 = myArray[indk-1]+"-"+myArray1[indk-1]+"-"+myArray2[indk-1];
						var nilai3 = myArray[indk]+"-"+myArray1[indk]+"-"+myArray2[indk];						 
						$.ajax({
							type: "POST",
							url: site+"nilai/input_rumus/"+nilai1+"/"+nilai2+"/"+nilai3+"/"+explode[2],
							success: function(html){
								if(html == 'gagal'){
									return false;	
								}else{
									$("#nilai1_"+explode[1]+"_"+explode[2]+"_"+explode[3]+"_"+explode[4]+"_"+explode[5]+"_").attr("id","nilai1_"+explode[1]+"_"+explode[2]+"_"+explode[3]+"_"+explode[4]+"_"+explode[5]+"_"+html);
									$("#nilai2_"+explode[1]+"_"+explode[2]+"_"+explode[3]+"_"+explode[4]+"_"+explode[5]+"_").attr("id","nilai2_"+explode[1]+"_"+explode[2]+"_"+explode[3]+"_"+explode[4]+"_"+explode[5]+"_"+html);
									$("#nilai3_"+explode[1]+"_"+explode[2]+"_"+explode[3]+"_"+explode[4]+"_"+explode[5]+"_").attr("id","nilai3_"+explode[1]+"_"+explode[2]+"_"+explode[3]+"_"+explode[4]+"_"+explode[5]+"_"+html);									
								}
							}
						});
					}					
				}else{	
					if(indk % 3 == 0){
						var nilai1 = myArray[indk-2]+"-"+myArray1[indk-2]+"-"+myArray2[indk-2];
						var nilai2 = myArray[indk-1]+"-"+myArray1[indk-1]+"-"+myArray2[indk-1];
						var nilai3 = myArray[indk]+"-"+myArray1[indk]+"-"+myArray2[indk];						 
						$.ajax({
							type: "POST",
							url: site+"nilai/update_rumus/"+nilai1+"/"+nilai2+"/"+nilai3+"/"+explode[6],
							success: function(html){
								if(html == 'gagal'){
									return false;	
								}
							}
						});
					}				
				}
				if(biji != 0){
					var hasil = biji+"xNH";				
				}else{
					var hasil = "";
				}
				if(biji1 != 0){
					var hasil1 = "+"+biji1+"xNT";				
				}else{
					var hasil1 = "";				
				}
				if(biji2 != 0){
					var hasil2 = "+"+biji2+"xNU";				
				}else{
					var hasil2 = "";				
				}
				if(biji == 0 && biji1 == 0 && biji2 == 0){
					$("#"+nilai).html('Kosong');
				}else{
					$("#"+nilai).html(hasil+hasil1+hasil2);
				}
				indk++;
			});
			//window.location = site+'nilai';
		} 		
	});
});
</script>
<div id="content">
<div class="isi">
<p class='caution'>
NH : Nilai Harian<br/>
NT : Nilai Tugas<br/>
NU : Nilai Ulangan
</p>
<input type="button" name="submit" value="Tambah" class="f-submit" id="submit_add"/><br/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%">NO</th><th width="25%"><a href="<?=base_url()?>nilai/index/b.nis/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">Nama</a></th><th>Rumus Nilai Kelas 1</th><th>Rumus Nilai Kelas 2</th><th>Rumus Nilai Kelas 3</th>
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
			$kkm = $this->mrumus->getRumuss($dt_kueri->id_mapel);
			if(count($kkm) > 0)
			{
				echo '<td align="center" class="tabel_isi" id="nilai1_'.$no.'_'.$dt_kueri->id_mapel.'_'.$dt_kueri->harian.'_'.$dt_kueri->tugas.'_'.$dt_kueri->ulangan.'_'.$kkm->id_rumus.'">'.rumus($kkm->rumus1).'</td>';
				echo '<td align="center" class="tabel_isi" id="nilai2_'.$no.'_'.$dt_kueri->id_mapel.'_'.$dt_kueri->harian.'_'.$dt_kueri->tugas.'_'.$dt_kueri->ulangan.'_'.$kkm->id_rumus.'">'.rumus($kkm->rumus2).'</td>';
				echo '<td align="center" class="tabel_isi" id="nilai3_'.$no.'_'.$dt_kueri->id_mapel.'_'.$dt_kueri->harian.'_'.$dt_kueri->tugas.'_'.$dt_kueri->ulangan.'_'.$kkm->id_rumus.'">'.rumus($kkm->rumus3).'</td>';
			}
			else
			{
				echo '<td align="center" class="tabel_isi" id="nilai1_'.$no.'_'.$dt_kueri->id_mapel.'_'.$dt_kueri->harian.'_'.$dt_kueri->tugas.'_'.$dt_kueri->ulangan.'_">Kosong</td>';
				echo '<td align="center" class="tabel_isi" id="nilai2_'.$no.'_'.$dt_kueri->id_mapel.'_'.$dt_kueri->harian.'_'.$dt_kueri->tugas.'_'.$dt_kueri->ulangan.'_">Kosong</td>';
				echo '<td align="center" class="tabel_isi" id="nilai3_'.$no.'_'.$dt_kueri->id_mapel.'_'.$dt_kueri->harian.'_'.$dt_kueri->tugas.'_'.$dt_kueri->ulangan.'_">Kosong</td>';
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