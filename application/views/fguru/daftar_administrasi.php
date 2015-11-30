<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>fguru/administrasi/add_sk/<?=$id?>" <? if(isset($tambah)){ echo $tambah;}?>>Tambah Standard Kompetensi</a></li>		
		<li class="first"><a href="<?=base_url()?>fguru/administrasi/add_kd/<?=$id?>" <? if(isset($tambah1)){ echo $tambah1;}?>>Tambah Kompetensi Dasar</a></li>
		<li class="first"><a href="<?=base_url()?>fguru/administrasi/add_indikator/<?=$id?>" <? if(isset($tambah2)){ echo $tambah2;}?>>Tambah Indikator</a></li>
		<li><a href="<?=base_url()?>fguru/administrasi/daftar/<?=$id?>" <? if(isset($daftar)){ echo $daftar;}?>>Daftar Administrasi</a></li>
	</ul>
</div>
<div id="content">
<?=$this->message->display();?>
<div class="isi">
<table width="100%" border="0" class="table1">
	<tr>
		<th width="5%">NO</th><th width="30%"><a href="<?=base_url()?>fguru/administrasi/daftar/<?=$id?>/administrasi/<?=(($sort_order == 'asc') ? 'desc' : 'asc')?>">Standar Kompetensi</a></th><th width="30%">Kompetensi Dasar</th><th>Indikator</th>
	</tr>
	<?
	if($jum_kueri > 0)
	{
		$no = 1;
		foreach($kueri as $dt_kueri):
		$klas = ($no % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$klas?> id="tabel<?=$dt_kueri->id_administrasi?>">
		<td align="center"><?=$no?></td><td><?=$dt_kueri->administrasi?>&nbsp;[<a href="<?=base_url()?>fguru/administrasi/edit_sk/<?=$id?>/<?=$dt_kueri->id_administrasi?>">Edit</a>]&nbsp;[<a href="<?=base_url()?>fguru/administrasi/hapus/<?=$id?>/<?=$dt_kueri->id_administrasi?>" onclick="return confirmSubmit()">Delete</a>]</td>
	<?
		$indikator = $this->madministrasi->getKompetensi($dt_kueri->id_administrasi);
		$j=1;
		if(count($indikator) > 0)
		{
			$n = $no;
			$ni = 1;
			foreach($indikator as $dt_indikator)
			{	
				if($j == 1)
				{
	?>		
		<td><?=$ni?>.&nbsp<?=$dt_indikator->administrasi?>&nbsp;[<a href="<?=base_url()?>fguru/administrasi/edit_kd/<?=$id?>/<?=$dt_indikator->id_administrasi?>">Edit</a>]&nbsp;[<a href="<?=base_url()?>fguru/administrasi/hapus/<?=$id?>/<?=$dt_indikator->id_administrasi?>" onclick="return confirmSubmit()">Delete</a>]</td>
	<?
					$tb = 1;
					$ni = $no;
					$tambh = $this->madministrasi->getIndikator($dt_indikator->id_administrasi);
					if(count($tambh) > 0)
					{
						foreach($tambh as $dt_tambh)
						{
							$kls = ($ni % 2 == 0)?'class="genap"':'class="ganjil"';
							if($tb == 1)
							{
								echo "<td>".$tb.". ".$dt_tambh->administrasi."&nbsp;[<a href='".base_url()."fguru/administrasi/edit_indikator/".$id."/".$dt_tambh->id_administrasi."'>Edit</a>]&nbsp;[<a href='".base_url()."fguru/administrasi/hapus/".$id."/".$dt_tambh->id_administrasi."' onclick='return confirmSubmit()'>Delete</a>]</td></tr>";
							}
							else
							{
								echo "<tr ".$kls."><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>".$tb.". ".$dt_tambh->administrasi."&nbsp;[<a href='".base_url()."fguru/administrasi/edit_indikator/".$id."/".$dt_tambh->id_administrasi."'>Edit</a>]&nbsp;[<a href='".base_url()."fguru/administrasi/hapus/".$id."/".$dt_tambh->id_administrasi."' onclick='return confirmSubmit()'>Delete</a>]</td></tr>";
							}
							$tb++;						
							$ni++;
						}
					}
					else
					{
						echo "<td>&nbsp;</td></tr>";					
					}
				}
				else
				{
					$kls = (($ni + $tb) % 2 == 0)?'class="genap"':'class="ganjil"';
	?>
	<tr <?=$kls?> id="tabel<?=$dt_kueri->id_administrasi?>">
		<td>&nbsp;</td><td>&nbsp;</td><td><?=$ni?>.&nbsp<?=$dt_indikator->administrasi?>&nbsp;[<a href="<?=base_url()?>fguru/administrasi/edit_indikator/<?=$id?>/<?=$dt_indikator->id_administrasi?>">Edit</a>]&nbsp;[<a href="<?=base_url()?>fguru/administrasi/hapus/<?=$id?>/<?=$dt_indikator->id_administrasi?>" onclick='return confirmSubmit()'>Delete</a>]</td><td>&nbsp;</td>
	</tr>	
	<?
				}
				$j++;
				$n++;
				$ni++;
			}
		}	
		else
		{
	?>
		<td>&nbsp;</td><td>&nbsp;</td></tr>	
	<?		
		}
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
</div>
<?=$this->load->view('admin/footer')?>
</div>