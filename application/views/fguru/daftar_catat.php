<script type="text/javascript">
$(document).ready( function() {		
	$('#submit_add').click(function() {
		var isi = $(this).attr("value");
		if(isi == "Tambah"){
			$(this).attr("value","Simpan");
			$('.tabel_isi').each(function(){
				var nilai = $(this).attr("id");
				var explode = nilai.split('_');
				var jj = $("#"+nilai).text();
				if(explode[2] == ""){
					var kolom = '<textarea name="cat" class="nilai" id="cat'+explode[0]+'" cols="40" rows="5"></textarea>';
					$("#"+nilai).html(kolom);
				}else{
					var kolom = '<textarea name="cat" class="nilai" id="cat'+explode[0]+'" cols="40" rows="5">'+jj+'</textarea>';
					$("#"+nilai).html(kolom);
				}
			});
		}else{
			$(this).attr("value","Tambah");
			$('.tabel_isi').each(function(){
				var nilai = $(this).attr("id");
				var explode = nilai.split('_');
				var biji = $('#cat'+explode[0]).val();				
				if(explode[2] == ""){
					$.ajax({
						type: "POST",
						url: site+"fguru/catatan/submit_catatan/"+explode[1]+"/"+explode[0]+"/"+biji,
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
						url: site+"fguru/catatan/submit_edit_catatan/"+explode[2]+"/"+biji,
						success: function(html){
							if(html == 'gagal'){
								return false;							
							}
						}
					});
				}
				if(biji == ""){
					var jj = $("#"+nilai).html('kosong');
				}else{
					var jj = $("#"+nilai).html(biji);				
				}
			});
		} 		
	});
});
</script>
<div id="content">
<?=$this->message->display();?>
<div class="isi">
<input type="button" name="submit" value="Tambah" class="f-submit" id="submit_add"/><br/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%">NO</th><th width="35%"><a href="<?=base_url()?>fguru/catatan/index/b.nis/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">Nama</a></th><th>Catatan</th>
	</tr>
	<?
	if(count($kueri) > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
		$js = 'class="ceks" id="'.$dt_kueri->nis.'"';
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->nis?>">
		<td align="center"><?=$no?></td><td><?=$dt_kueri->nama?></td>
		<?
			$iid = $this->mnaik->getIdCatat($dt_kueri->nis,$id_kelas_sis,$this->session->userdata('kd_sem')); 	
		?>
			<td class="tabel_isi" id="<?=$dt_kueri->nis?>_<?=$id_kelas_sis?>_<?=$iid?>" align="center">
		<?
			echo str_replace("%20"," ",$this->mnaik->getCatat($dt_kueri->nis,$id_kelas_sis,$this->session->userdata('kd_sem')));
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