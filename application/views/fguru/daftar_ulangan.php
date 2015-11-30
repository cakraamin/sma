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
				if(explode[3] == ""){
					var kolom = '<input name="nip" type="text" class="nilai" id="nip'+explode[0]+'" value=""/>';
					$("#"+nilai).html(kolom);
				}else{
					var kolom = '<input name="nip" type="text" class="nilai" id="nip'+explode[0]+'" value="'+jj+'"/>';
					$("#"+nilai).html(kolom);
				}
			});
		}else{
			$(this).attr("value","Tambah");
			$('.tabel_isi').each(function(){
				var nilai = $(this).attr("id");
				var explode = nilai.split('_');
				var biji = $('#nip'+explode[0]).val();				
				if(explode[3] == ""){
					$.ajax({
						type: "POST",
						url: site+"fguru/nilai/input_nilaiu/"+explode[0]+"/"+explode[1]+"/"+explode[2]+"/"+biji,
						success: function(html){
							if(html == 'gagal'){
								//alert('Maaf Ada Yang Gagal');
								return false;							
							}
						}
					});					
				}else{				
					$.ajax({
						type: "POST",
						url: site+"fguru/nilai/update_nilai/"+explode[3]+"/"+biji,
						success: function(html){
							if(html == 'gagal'){
								//alert('Maaf Ada Yang Gagal');
								return false;							
							}
						}
					});
				}
				var jj = $("#"+nilai).html(biji);
			});
		} 		
	});
});
</script>
<div id="utility">
	<ul id="nav-secondary">		
		<li class="first"><a href="<?=base_url()?>fguru/nilai/set_nilai/<?=$id?>" <? if(isset($tambah)){ echo $tambah;}?>>Setting Nilai</a></li>
		<li><a href="<?=base_url()?>fguru/nilai/daftar/<?=$id?>" <? if(isset($daftar)){ echo $daftar;}?>>Daftar Nilai Harian</a></li>
		<li><a href="<?=base_url()?>fguru/nilai/daftar_ulangan/<?=$id?>" <? if(isset($daftars)){ echo $daftars;}?>>Daftar Nilai Ulangan</a></li>
	</ul>
</div>
<div id="content">
<div class="cari">
<form method="post" action="<?=base_url()?>fguru/nilai/submit_kategoris/<?=$id?>">
	<label for="kunci"><b>Kelas :</b>
	<?
		if(count($klas) > 1)
		{
		$pk = 'id="kelas" class="kelas"';
		echo form_dropdown('kelas',$klas,$kls,$pk);
		}
	?>
	</label>		
	<input type="submit" name="submit" value="OK" class="f-submit"/>
</form>
</div><hr />
<div class="isi">
<input type="button" name="submit" value="Tambah" class="f-submit" id="submit_add"/><br/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%">NO</th><th width="25%"><a href="<?=base_url()?>fguru/nilai/daftar/<?=$id?>/<?=$kls?>/<?=$dasar?>/b.nis/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">NIS</a></th><th><a href="<?=base_url()?>fguru/nilai/daftar/<?=$id?>/<?=$kls?>/<?=$dasar?>/b.nama/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">Nama</a></th><th width="10%">Nilai</th>
	</tr>
	<?
	if($jum_kueri > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?>>
		<td align="center"><?=$no?></td><td><?=$dt_kueri->nis?></td><td><?=$dt_kueri->nama?></td>
	<?
		$iid = $this->mnilai->getIdNilai($dt_kueri->nis,$id,$kls,0,$this->session->userdata('kd_sem'),1); 	
	?>
		<td class="tabel_isi" id="<?=$dt_kueri->nis?>_<?=$id?>_<?=$kls?>_<?=$iid?>" align="center">
	<?
		echo $this->mnilai->getNilai($dt_kueri->nis,$id,$kls,0,$this->session->userdata('kd_sem'),1);
	?>
		</td>
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