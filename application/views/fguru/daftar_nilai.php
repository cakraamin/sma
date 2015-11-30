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

function panggil(ID){	
	$.get( site+"fguru/nilai/form"+ID+"<?php echo $jns; ?>/<?php echo $tingkat; ?>/<?php echo $kes; ?>", function( data ) {
		jQuery.facebox( data );
	});	
}
function remidi(ID){
	var nilai = ID.id;	
	var res = nilai.split("_"); 
	var kodene = res[0]+"_"+res[1]+"_"+res[2]+"_"+res[3]+"_"+res[4]+"_"+res[5];	
	var isine = $('#'+kodene).html();
	if(isine == "kosong"){
		$('#'+kodene).html('<input type="text" id="'+kodene+'_2"><a id="'+kodene+'_3" onclick="remidije(this)" class="simpanje">&nbsp;</>');	
	}else{
		$('#'+kodene).html('<input type="text" id="'+kodene+'_2" value="'+isine+'"><a id="'+kodene+'_3" onclick="remidije(this)" class="simpanje">&nbsp;</>');	
	}	
	return false;
}
function remidije(ID){
	var nilai = ID.id;
	var explode = nilai.split("_");
	var kodene = explode[0]+"_"+explode[1]+"_"+explode[2]+"_"+explode[3]+"_"+explode[4]+"_"+explode[5]+"_2";
	var kolome = explode[0]+"_"+explode[1]+"_"+explode[2]+"_"+explode[3]+"_"+explode[4]+"_"+explode[5];
	var biji = $('#'+kodene).val();
	$.ajax({
		type: "POST",
		url: site+"fguru/nilai/update_nilai/"+explode[3]+"/"+biji+"/3",
		success: function(html){			
			$('#'+kolome).html(biji);
			//alert(kolome);
		}
	});
	return false;
}
$(document).ready( function() {			
	$('#submit_add').click(function() {
		var isi = $(this).attr("value");
		var pengetahuan = $('#penget').val();
		if(pengetahuan == 2){
			var kolome = 'tabel_ul';			
		}else{
			var kolome = 'tabel_isi';
		}		
		if(isi == "Update"){
			$(this).attr("value","Simpan");
			var no = 1;
			$('.'+kolome).each(function(){
				var nilai = $(this).attr("id");
				var explode = nilai.split('_');
				var jj = $("#"+nilai).text();
				if(explode[4] == 1){
					if(explode[3] == ""){
						var kolom = '<input name="nip" type="text" class="nilai'+no+'" id="nip'+explode[0]+'" value="" maxlength="3" onkeyup="langsung('+no+')"/>';
						$("#"+nilai).html(kolom);
					}else{
						var nilaine = jj;	
						var nilaijo;
						if(nilaine.trim() == "kosong"){
							nilaijo = "";
						}else{
							nilaijo = nilaine.trim();
						}
						var kolom = '<input name="nip" type="text" class="nilai'+no+'" id="nip'+explode[0]+'" value="'+nilaijo+'" maxlength="3" onkeyup="langsung('+no+')"/>';
						$("#"+nilai).html(kolom);
					}						
				}else{
					var nilaine = jj;	
					var kolom = '<a onclick="panggil(/'+nilai+'/)">'+nilaine.trim()+'</a>';										
					$("#"+nilai).html(kolom);
				}
				no++;
			});
		}else{
			var kkm = $('#kkm').val();
			$(this).attr("value","Update");
			$('.'+kolome).each(function(){
				var nilai = $(this).attr("id");
				var explode = nilai.split('_');
				var biji = $('#nip'+explode[0]).val();					
				if(biji == ""){
					biji = 0;
				}else{
					biji = biji;
				}
				if (pengetahuan === undefined) {
				    var txt = 1;
				} else {
				    var txt = pengetahuan;
				}								
				if(explode[3] == ""){
					$.ajax({
						type: "POST",
						url: site+"fguru/nilai/input_nilai/"+explode[0]+"/"+explode[1]+"/"+explode[2]+"/"+biji+"/<?=$tingkat?>/"+explode[4]+"/<?=$kes?>/"+txt,
						success: function(html){
							var obj = jQuery.parseJSON( html );							
							if(obj.statuse == 'gagal'){
								return false;							
							}else{
								$('#'+obj.awal).attr('id', obj.newK);
								var nilai = $('#'+obj.newK).html();
								if($('#jenism').val() == "tes"){
									var remidine = '';
								}else{
									var remidine = '<a id="'+obj.newK+'_2_1" class="next" onclick="remidi(this)"> </a>';
								}								
								if(kkm <= biji){
									$('#'+obj.newK).html(biji);
								}else{
									if(biji == 0){
										$('#'+obj.newK).html("kosong");
									}else{
										$('#'+obj.newK).html("<font color='red'>"+biji+"</font>"+remidine);
									}									
								}								
								$('#'+obj.k2).attr('id', obj.newK+'_2');
								$('#'+obj.k3).attr('id', obj.newK+'_3');
							}
						}
					});					
				}else{									
					$.ajax({
						type: "POST",
						url: site+"fguru/nilai/update_nilai/"+explode[3]+"/"+biji+"/"+txt,
						success: function(html){
							var obj = jQuery.parseJSON( html );																					
							if(obj.nilai < kkm && obj.nilai != "kosong"){
								$('#'+nilai).html("<font color='red'>"+obj.nilai+"</font><a id='"+nilai+"_2_1' class='next' onclick='remidi(this)'> </a>");
							}else{
								$('#'+nilai).html(obj.nilai);
							}							
						}
					});
				}	
				/*if(explode['4'] == 3){
					var person = [];
					person[1] = "SB";
					person[2] = "B";
					person[3] = "C";
					person[4] = "K";
					var jj = $("#"+nilai).html(person[biji]);
				}else{					
					if(kkm <= biji){
						var jj = $("#"+nilai).html(biji);
					}else{
						if($('#jenism').val() == "tes"){
							var remidine = '';
						}else{
							var remidine = '<a id="'+nilai+'_2_1" class="next" onclick="remidi(this)"> </a>';
						}						
						var jj = $("#"+nilai).html("<font color='red'>"+biji+"</font>"+remidine);
					}					
				}*/
			});
		} 		
	});	
});
$(function(){
	var image_load = "<img src='"+site+"asset/images/ajax.gif' />";
	var btnUpload=$('#upload');
	var status=$('.konfirmasi');
	new AjaxUpload(btnUpload, {
		action: '<?=base_url()?>fguru/nilai/upload/<?=$id?>/<?=$kls?>/<?=$tingkat?>/<?=$kes?>/<?php echo $jns; ?>',
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
					var kkm = $('#kkm').val();
					var jenis = $('#jenism').val();
					if(explode[3] == ""){
						$.ajax({
							type: "POST",
							dataType: 'json',
							url: site+"fguru/nilai/cek_nilai/"+explode[0]+"/"+explode[1]+"/"+explode[2]+"/<?=$tingkat?>/<?=$kes?>/<?php echo $jns; ?>",
							success: function(html){
								if(html.status == 'ok'){
									if(jenis == "tes"){
										var nilaije = html.nilai;
										var remidi = '';										
									}else{
										if(kkm <= html.nilai){
											var nilaije = html.nilai;
											var remidi = '';
										}else{
											var nilaije = '<font color="red">'+html.nilai+'</font>';
											var remidi = '<a id="'+html.newK+'_2_1" class="next" onclick="remidi(this)"> </a>';
										}											
									}
									$("#"+nilai).html(nilaije+remidi);
									//$("#"+nilai).html("okelah");
									$("#"+nilai+"_2").html(html.remidi);
									$("#"+nilai+"_3").html(html.tugas);
									$("#"+nilai).attr("id",html.newK);	
									$("#"+nilai+"_2").attr("id",html.newK+"_2");	
									$("#"+nilai+"_3").attr("id",html.newK+"_3");	
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
		<li><a href="<?=base_url()?>fguru/nilai/daftar/<?=$id?>/<?=$jenis?>" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Nilai Harian</a></li>
		<li><a href="<?=base_url()?>fguru/nilai/daftar_uts/<?=$id?>/<?=$jenis?>" <?php if(isset($daftart)){ echo $daftart;}?>>Daftar Nilai UTS</a></li>
		<li><a href="<?=base_url()?>fguru/nilai/daftar_uas/<?=$id?>/<?=$jenis?>" <?php if(isset($daftars)){ echo $daftars;}?>>Daftar Nilai UAS</a></li>		
	</ul>
</div>
<div id="content">
<?=$this->message->display();?>
<div class="cari">
<form method="post" action="<?=base_url()?>fguru/nilai/submit_kategori/<?=$this->uri->segment(3)?>/<?=$id?>/<?=$jenis?>">
	<label for="kunci"><b>Kelas :</b>
	<?php
		if(count($klas) > 1)
		{
			$pk = 'id="kelas" class="kelas" OnChange="this.form.submit()"';
			$pj = 'id="jenis" class="jenis" OnChange="this.form.submit()"';
			echo form_dropdown('kelas',$klas,$kls,$pk);
			if($this->uri->segment(3) == "daftar" || $this->uri->segment(3) == "daftar_tugas")
			{				
				$pke = 'id="ke" class="ke" OnChange="this.form.submit()"';								
				echo "&nbsp;".form_dropdown('jenise',$jenise,$jns,$pj);			
				if($tingkatane > 0)
				{
					$levele = array();
					for($u=1;$u<=$tingkatane;$u++)
					{
						$levele[$u] = $u;
					}
					echo "&nbsp;".form_dropdown('ke',$levele,$kes-1,$pke);				
					if($jns == 1)
					{
						echo "&nbsp;".form_dropdown('penget',$penget,'','id="penget"');			
					}					
				}				
			}
	?>
	</label>	
	<?php } ?>
</form>
</div><hr />
<div class="isi">
<?php
if($isi == 'daftar')
{
	if($tingkatane > 0 && $j_keterampilan > 0)
	{
		?><input type="button" name="submit" value="Update" class="f-submit" id="submit_add"/><?php	
	}
}
else
{
	?><input type="button" name="submit" value="Update" class="f-submit" id="submit_add"/><?php		
}
?>
<br/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%">NO</th><th width="25%"><a href="<?=base_url()?>fguru/nilai/daftar/<?=$id?>/<?=$jenis?>/<?=$kls?>/b.nis/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">NIS</a></th><th><a href="<?=base_url()?>fguru/nilai/daftar/<?=$id?>/<?=$jenis?>/<?=$kls?>/b.nama/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">Nama</a></th><th width="10%">Nilai</th>
		<?php
		if($jns == 1 && $isi == "daftar")
		{
			?><th width="10%">Remidial</th><th width="10%">Tugas</th><?php
		}
		?>
	</tr>
	<?php
	if($jum_kueri > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?>>
		<td align="center"><?=$no?></td><td><?=$dt_kueri->nis?></td><td><?=$dt_kueri->nama?></td>
	<?php
		$jnse = (isset($jns))?$jns:0;
		if($jns == 3)
		{
			$iid = $this->mnilai->getIdSikap($dt_kueri->nis,$id,$kls,$this->session->userdata('kd_sem'),$tingkat,$jnse,$kes); 	
		}
		elseif($jns == 2)
		{
			$iid = $this->mnilai->getIdTrampil($dt_kueri->nis,$id,$kls,$this->session->userdata('kd_sem'),$tingkat,$jnse,$kes); 	
		}
		else
		{
			$iid = $this->mnilai->getIdNilai($dt_kueri->nis,$id,$kls,$this->session->userdata('kd_sem'),$tingkat,$jnse,$kes); 	
		}		
	?>
		<td class="tabel_isi" id="<?=$dt_kueri->nis?>_<?=$id?>_<?=$kls?>_<?=$iid?>_<?php if(isset($jns)){ echo $jns; } ?>" align="center">
	<?php
		$jnse = (isset($jns))?$jns:0;		
		if($jns == 3)
		{
			echo $this->mnilai->getSikap($dt_kueri->nis,$id,$kls,$this->session->userdata('kd_sem'),$kes);		
		}
		elseif($jns == 2)
		{
			echo $this->mnilai->getTrampil($dt_kueri->nis,$id,$kls,$this->session->userdata('kd_sem'),$kes);		
		}
		else
		{
			$nilaine = $this->mnilai->getNilai($dt_kueri->nis,$id,$kls,$this->session->userdata('kd_sem'),$tingkat,$jnse,$kes);			
			if($kkm <= $nilaine['nilai'])
			{
				echo $nilaine['nilai'];
			}
			else
			{
				echo "<font color='red'>".$nilaine['nilai']."</font>";
			}
			if($nilaine['nilai'] != "kosong")
			{
				$jjns = (isset($jns))?$jns:0;
				if($isi == "daftar" && $kkm > $nilaine['nilai'])
				{
					echo "<a class='next' id='".$dt_kueri->nis."_".$id."_".$kls."_".$iid."_".$jjns."_2_1' onclick='remidi(this)'>&nbsp;</a>";
				}				
			}			
		}		
	?>
		</td>
		<?php
		if($jns == 1 && $isi == "daftar")
		{
			?><td align="center" class="tabel_rem" id="<?=$dt_kueri->nis?>_<?=$id?>_<?=$kls?>_<?=$iid?>_<?php if(isset($jns)){ echo $jns; } ?>_2"><?php echo $nilaine['remidi']; ?></td><td align="center" class="tabel_ul" id="<?=$dt_kueri->nis?>_<?=$id?>_<?=$kls?>_<?=$iid?>_<?php if(isset($jns)){ echo $jns; } ?>_3"><?php echo $nilaine['tugas']; ?></td><?php
		}
		?>
	</tr>
	<?php
		$no++;
		endforeach;
	}
	else
	{
		$kolom = ($jns == 1)?6:4;
	?>
	<tr><td colspan="<?php echo $kolom; ?>" align="center">Data Masih Kosong</td></tr>
	<?php
	}
	?>
</table>
<input type="hidden" name="kkm" id="kkm" value="<?php echo $kkm; ?>">
<input type="hidden" name="jenism" id="jenism" value="<?php echo $isi; ?>">
<?php	
	if($kls != "" || $kes != "")
	{
		echo '<br/><span id="upload" class="tombolUp">Import Nilai</span>&nbsp;<a href="'.base_url().'fguru/nilai/sample/'.$kls.'/'.$kes.'/'.$jns.'/'.$id.'/'.$mbuh.'">Download</a> contoh file import<br/><br/>';
	}
?>
</div>
<?=$this->load->view('admin/footer')?>
</div>