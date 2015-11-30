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
				if(explode[3] == ""){
					var kolom = '<input name="nip" type="text" class="nilai'+no+'" id="nip'+explode[0]+'" value="" maxlength="3" onkeyup="langsung('+no+')"/>';
					$("#"+nilai).html(kolom);
				}else{
					var kolom = '<input name="nip" type="text" class="nilai'+no+'" id="nip'+explode[0]+'" value="'+jj+'" maxlength="3" onkeyup="langsung('+no+')"/>';
					$("#"+nilai).html(kolom);
				}
				no++;
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
						url: site+"nilai/input_nilai/"+explode[0]+"/"+explode[1]+"/"+explode[2]+"/"+biji+"/<?=$tingkat?>/<?=$kes?>",
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
						url: site+"nilai/update_nilai/"+explode[3]+"/"+biji,
						success: function(html){
							if(html == 'gagal'){
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
$(function(){
	var image_load = "<img src='"+site+"asset/images/ajax.gif' />";
	var btnUpload=$('#upload');
	var status=$('.konfirmasi');
	new AjaxUpload(btnUpload, {
		action: '<?=base_url()?>nilai/upload/<?=$id?>/<?=$kls?>/<?=$tingkat?>/<?=$kes?>',
		name: 'uploadfile',
		onChange: function(file) {$('.konfirmasi').html(image_load);}, 
		onSubmit: function(file, ext){
			if (! (ext && /^(xls|csv)$/.test(ext))){ 
				var pesan = "<p class='notice'>Format File Import Tidak Diketahui</p>";
				$('#content').prepend(pesan);
				return false;
			}
		},
		onComplete: function(file, response){
			if(response == 'gagals'){
				alert('Maaf Format Import Nilai Salah');
				return false;			
			}else{
				$('.tabel_isi').each(function(){
					var nilai = $(this).attr("id");
					var explode = nilai.split('_');				
					if(explode[3] == ""){
						$.ajax({
							type: "POST",
							dataType: 'json',
							url: site+"nilai/cek_nilai/"+explode[0]+"/"+explode[1]+"/"+explode[2]+"/<?=$tingkat?>/<?=$kes?>",
							success: function(html){
								if(html.status == 'ok'){
									$("#"+nilai).html(html.nilai);
									$("#"+nilai).attr("id",nilai+html.id);	
								}else{
									$("#"+nilai).html('kosong');
								}
							}
						});
					}else{				
						alert('Nilai Sudah Terisi');
						return false;
					}
				});			
			}
		}
	});
	});
</script>
<div id="utility">
	<ul id="nav-secondary">	
		<? if($mnu->harian != 0){
		?><li><a href="<?=base_url()?>nilai/daftar/<?=$id?>/<?=$jenis?>" <? if(isset($daftar)){ echo $daftar;}?>>Daftar Nilai Harian</a></li><?	
		}?>
		<? if($mnu->tugas != 0){
		?><li><a href="<?=base_url()?>nilai/daftar_tugas/<?=$id?>/<?=$jenis?>" <? if(isset($daftart)){ echo $daftart;}?>>Daftar Nilai Tugas</a></li><?	
		}?>
		<? if($mnu->ulangan != 0){
		?><li><a href="<?=base_url()?>nilai/daftar_ulangan/<?=$id?>/<?=$jenis?>" <? if(isset($daftars)){ echo $daftars;}?>>Daftar Nilai Ulangan</a></li><?	
		}?>
		<li><a href="<?=base_url()?>nilai/daftar_akhir/<?=$id?>/<?=$jenis?>" <? if(isset($daftara)){ echo $daftara;}?>>Daftar Nilai Akhir</a></li>
	</ul>
</div>
<div id="content">
<div class="cari">
<form method="post" action="<?=base_url()?>nilai/submit_kategori/<?=$this->uri->segment(2)?>/<?=$id?>/<?=$jenis?>">
	<label for="kunci"><b>Kelas :</b>
	<?
		$pk = 'id="kelas" class="kelas" OnChange="this.form.submit()"';
		echo form_dropdown('kelas',$klas,$kls,$pk);
		if($this->uri->segment(2) == "daftar" || $this->uri->segment(2) == "daftar_tugas")
		{
			$ke = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20');			
			$pke = 'id="ke" class="ke" OnChange="this.form.submit()"';
			echo "&nbsp;".form_dropdown('ke',$ke,$kes-1,$pke);
		}
	?>
	</label>
</form>
</div><hr />
<div class="isi">
<input type="button" name="submit" value="Tambah" class="f-submit" id="submit_add"/><br/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%">NO</th><th width="25%"><a href="<?=base_url()?>nilai/daftar/<?=$id?>/<?=$jenis?>/<?=$kls?>/b.nis/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">NIS</a></th><th><a href="<?=base_url()?>nilai/daftar/<?=$id?>/<?=$jenis?>/<?=$kls?>/b.nama/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">Nama</a></th><th width="10%">Nilai</th>
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
		$iid = $this->mrumus->getIdNilai($dt_kueri->nis,$id,$kls,$this->session->userdata('kd_sem'),$tingkat,$kes); 	
	?>
		<td class="tabel_isi" id="<?=$dt_kueri->nis?>_<?=$id?>_<?=$kls?>_<?=$iid?>" align="center">
	<?
		echo $this->mrumus->getNilai($dt_kueri->nis,$id,$kls,$this->session->userdata('kd_sem'),$tingkat,$kes);
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
	<tr><td colspan="4" align="center">Data Masih Kosong</td></tr>
	<?
	}
	?>
</table>
<?
	if($kls != "" || $kes != "")
	{
		echo '<br/><span id="upload" class="tombolUp">Import Nilai</span>&nbsp;<a href="'.base_url().'nilai/sample/'.$kls.'">Download</a> contoh file import<br/><br/>';
	}
?>
</div>
<?=$this->load->view('admin/footer')?>
</div>