<script type="text/javascript">
$(document).ready( function() {		
	$('.aktif').click(function() {
		var nilai = $(this).attr('id');
		var gambar = "<img src='<?=base_url()?>asset/images/error.jpeg' width='20px;'/>";
		var aktif = "<img src='<?=base_url()?>asset/images/ok.png' width='20px;'/>";
		$('.aktif').each(function(){
			$(this).html(gambar);
		});
		$.ajax({
			type: "POST",
		  	url: "<?=base_url()?>control/updateSetTa/"+nilai,
			success: function(html){
				if(html == 'ok'){
					$('#'+nilai).html(aktif);
					alert('Logout kemudian login kembali untuk merasakan dampaknya');
					return false;	
				}
			}
		})
	});
});
</script>
<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>control/add_ta" <?php if(isset($tambah)){ echo $tambah;}?>>Tambah Tahun Ajaran</a></li>
		<li><a href="<?=base_url()?>control/ta" <?php if(isset($daftar)){ echo $daftar;}?>>Daftar Tahum Ajaran</a></li>
	</ul>
</div>
<div id="content">
<?=$this->message->display();?>
<div class="isi">
<form name="formDelete" action="<?=base_url()?>control/hapus" method="post">
<input type="image" src="<?=base_url()?>asset/images/RecycleBin_Full-64.png" name="woke" value="<?=current_url()?>" class="delImg" onclick="return confirmSubmit()" width="30px" title="Hapus Data Guru"/>
<input type="hidden" name="alamat" value="<?=current_url()?>"/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="10%">Edit</th><th><a href="<?=base_url().shorting_page($this->uri->uri_string(),$urs,"ta/".(($sort_order == 'asc') ? 'desc' : 'asc'))?>">Tahun Ajaran</a></th><th width="20%">Status</th><th width="20%">Aktifkan</th>
	</tr>
	<?php
	if(count($kueri) > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->id_ta?>">
		<td><?=form_checkbox('cek[]', $dt_kueri->id_ta)?></td><td><a href="<?=base_url()?>control/edit_ta/<?=$dt_kueri->id_ta?>/<?=$ref?>/<?=$sort_by?>/<?=$sort_order?>/<?=$page?>"><img src="<?=base_url()?>asset/images/edit.png"/></a></td><td><?=$dt_kueri->ta?></td>
		<td><?php
		$status = ($dt_kueri->status == 1)?"Aktif":"Tidak Aktif";
		echo $status;
		?></td>
		<td><center><span id="<?=$dt_kueri->id_ta?>" class="aktif">
		<?php
		if($dt_kueri->id_ta == $this->session->userdata('kd_ta'))
		{
			echo "<img src='".base_url()."asset/images/ok.png' width='20px;'/>";
		}
		else
		{
			echo "<img src='".base_url()."asset/images/error.jpeg' width='20px;'/>";
		}
		?>
		</span></center></td>
	</tr>
	<?php
		$no++;
		endforeach;
	}
	else
	{
	?>
	<tr><td colspan="4" align="center">Data Masih Kosong</td></tr>
	<?php
	}
	?>
</table>
</form><br />
<?=$paging?>
</div>
<?=$this->load->view('admin/footer')?>
</div>