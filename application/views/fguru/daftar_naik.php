<script type="text/javascript">
$(document).ready( function() {		
	$(".checkall").live('click',function(event){
		if ($(this).attr("checked") == true){
			CheckSelectAlls();
		}else{
			DisCheckSelectAlls();
		}
	});
	
	$('input:checkbox:not(.checkall)').change(function() {
  		var nilai = $(this).attr('id');
  		var biji = $(this).val();
		naik(nilai,biji);
	});
	
	function CheckSelectAlls(){
		$('input:checkbox:not(.checkall)').each(function() {
			var nilai = $(this).attr('id');
			var biji = $(this).val();
			//naik(nilai,biji);
		});
	}
	
	function DisCheckSelectAlls(){
		$('input:checkbox:not(.checkall)').each(function() {
			var nilai = $(this).attr('id');
			var biji = $(this).val();
			//naik(nilai,biji);		
		});
	}
	
	function naik(id,ids){
		$.ajax({
			url: site+'fguru/kenaikan/input/<?=$id_kelas_sis?>/'+id+'/'+ids+'/<?=$next?>/<?=$kode?>',
			success: function(response){
				//alert(response);
			},
			dataType:"html"  		
		}); 
	}
	
	function tetap(id,ids){
		$.ajax({
			url: site+'fguru/kenaikan/update/<?=$id_kelas_sis?>/'+id+'/'+ids+'/<?=$next?>/<?=$kode?>',
			success: function(response){
				//alert(response);
			},
			dataType:"html"  		
		}); 
	}
});
</script>
<div id="content">
<div class="isi">
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%">NO</th><th><a href="<?=base_url()?>fguru/kenaikan/index/b.nis/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">Nama</a></th><th width="5%"><input type="checkbox" class="checkall" />
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
		<?
			$data_jum = $this->mnaik->cekStatNaik($id_kelas_sis,$dt_kueri->nis)==1?"ok":"";		
		?>
		<td align="center"><?=$no?></td><td><?=$dt_kueri->nama?></td><td><?=form_checkbox('cek[]',1,$data_jum,$js)?></td>
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