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
	$('#submit_add').click(function() {
		var isi = $(this).attr("value");
		if(isi == "Tambah"){
			$(this).attr("value","Simpan");
			var no = 1;
			$('.tabel_isi').each(function(){
				var nilai = $(this).attr("id");
				var explode = nilai.split('_');
				var jj = $("#"+nilai).text();
				if(explode[2] == ""){
					var kolom = '<input name="diri" type="text" class="nilai'+no+'" id="diri'+explode[1]+'" value="" maxlength="1" onkeyup="langsung('+no+')"/>';
					$("#"+nilai).html(kolom);
				}else{
					var kolom = '<input name="diri" type="text" class="nilai'+no+'" id="diri'+explode[1]+'" value="'+jj+'" maxlength="1" onkeyup="langsung('+no+')"/>';
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
				var biji = $('#diri'+explode[1]).val();		
				if(explode[2] == ""){	
					$.ajax({
						type: "POST",
						url: site+"fguru/pengembangan/input_diri/<?=$id?>/"+explode[1]+"/"+explode[0]+"/"+biji,
						success: function(html){
							if(html == 'gagal'){
								return false;							
							}else{
								$("#"+nilai).attr("id",nilai+html);							
							}
						}
					});									
				}else{	
					$.ajax({
						type: "POST",
						url: site+"fguru/pengembangan/update_diri/"+biji+"/"+explode[2],
						success: function(html){
							if(html == 'gagal'){
								return false;							
							}
						}
					});								
				}
				var jj = $("#"+nilai).html(biji);
				indk++;
			});
		} 		
	});
});
</script>
<div id="content">
<div class="cari">
<form method="post" action="<?=base_url()?>fguru/pengembangan/submit_kategori">
	<label for="kunci"><b>Pengembangan Diri :</b>
	<?
		$pd = 'id="diri" class="diri" OnChange="this.form.submit()" ';
		echo form_dropdown('diri',$diris,$id,$pd);
	?>
	</label>		
</form>
</div>
<div class="isi">
<input type="button" name="submit" value="Tambah" class="f-submit" id="submit_add"/><br/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%">NO</th><th><a href="<?=base_url()?>fguru/pengembangan/index/a.nama/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">Nama</a></th><th width='15%'>Pengembangan Diri</th>
	</tr>
	<?
	if(count($kueri) > 0)
	{
		if($id == "")
		{
			echo '<tr><td colspan="3" align="center">Data Masih Kosong</td></tr>';
			exit();	
		}
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?>>
		<td align="center"><?=$no?></td><td><?=$dt_kueri->nama?></td>
	<?
		$data = $this->mkembang->getNilaiDiri($id,$dt_kueri->nis,$kelas);
		$nilai = $this->mkembang->getNilaiDiris($id,$dt_kueri->nis,$kelas);
		echo "<td align='center' class='tabel_isi' id='".$dt_kueri->nis."_".$kelas."_".$data."'>".$nilai."</td>";	
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