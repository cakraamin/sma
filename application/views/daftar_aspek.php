<div id="content">
<?=$this->message->display();?>
<div class="isi">
<form name="formDelete" action="<?=base_url()?>aspek/hapus/<?php echo $id; ?>" method="post">
<input type="image" src="<?=base_url()?>asset/images/RecycleBin_Full-64.png" name="woke" value="<?=current_url()?>" class="delImg" onclick="return confirmSubmit()" width="30px" title="Hapus Data Guru"/>
<input type="hidden" name="alamat" value="<?=current_url()?>"/>
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%"><input type="checkbox" class="checkall" /></th><th width="8%">Edit</th><th width="35%">Nama Mapel</th><th><?php echo $aspeke; ?> 1</th><th><?php echo $aspeke; ?> 2</th><th><?php echo $aspeke; ?> 3</th><th><?php echo $aspeke; ?> 4</th><th><?php echo $aspeke; ?> 5</th>
		<?php
		if($id == 1)
		{
			echo "<th>KKM</th>";
		}	
		?>		
	</tr>
	<?php	
	if(count($kueri) > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri['id_mapel']?>">
		<td><?=form_checkbox('cek[]', $dt_kueri['id_mapel'])?></td><td><a href="<?=base_url()?>aspek/edit_aspek/<?php echo $id; ?>/<?php echo $dt_kueri['id_mapel']; ?>/<?php echo $sort_by; ?>"><img src="<?=base_url()?>asset/images/edit.png"/></a></td><td><?=$dt_kueri['nama_mapel']?></td>
		<?php
		$n = 1;
		foreach($dt_kueri['detail'] as $detaile)
		{
			echo "<td>".$detaile."</td>";
			$n++;
		}
		$jum = 5 - intval($n);
		for($i=0;$i<=$jum;$i++)
		{
			echo "<td></td>";
		}
		if($id == 1)
		{
			echo "<td>".$dt_kueri['kkm']."</td>";
		}
		?>			
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
</form>
</div>
<?=$this->load->view('admin/footer')?>
</div>