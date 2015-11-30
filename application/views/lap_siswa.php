<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>laporan/siswa" <? if(isset($persiswa)){ echo $persiswa;}?>>Laporan per-siswa</a></li>
		<li><a href="<?=base_url()?>laporan/kelas" <? if(isset($perkelas)){ echo $perkelas;}?>>Laporan per-kelas</a></li>
	</ul>
</div>
<div id="content">
<div class="isi">
<a href="<?=base_url()?>laporan/siswa"><img src="<?=base_url()?>asset/images/back-icon.png" width="40px" title="kembali"/></a><hr />
<?
if($jum == 0)
{
	echo "<strong>Maaf NIS tersebut tidak terdaftar</strong>";
}
else
{
?>
	<div class="border">
	<table border="0" cellspacing="0" cellpadding="0" class="kartu">
	  <tr>
	  	<td rowspan="7" width="110px"><?=cek_gambar($kueri->gambar,"uploads/thumbnail")?></td> 	
		<td valign="top" width="160px">NIS</td>
		<td valign="top">: <?=$kueri->nis?></td>
	  </tr>
	  <tr>
		<td valign="top">Nama</td>
		<td valign="top">: <?=$kueri->nama?></td>
	  </tr>
	  <tr>
		<td valign="top">Alamat</td>
		<td valign="top">: <?=$kueri->alamat?></td>
	  </tr>
	  <tr>
		<td valign="top">Tempat,tanggal lahir</td>
		<td valign="top">: <?=$kueri->tempat_lahir?>,<?=ganti_tanggal($kueri->tanggal)?></td>
	  </tr>
	  <tr>
		<td valign="top">Agama</td>
		<td valign="top">: <?=$kueri->agama?></td>
	  </tr>
	  <tr>
		<td valign="top">Tahun Ajaran</td>
		<td valign="top">: <?=$kueri->ta?></td>
	  </tr>
	  <tr>
		<td valign="top">Kelas</td>
		<td valign="top">: <?=$kelas?></td>
	  </tr>
	</table>
	</div>		
	<input type="hidden" name="nis" class="nis" id="nis" value="<?=$id?>"/>
	<input type="hidden" name="jenis" class="jenis" id="jenis" value="<?=$jenis?>"/>
	<?
		$pj = 'id="jangka" class="jangka" onchange="combo()"';
		echo form_dropdown('jangka',$jangka,'',$pj);
	?>
	<span class="dropdown"></span>
	<?
		$pf = 'id="format" class="format"';
		echo form_dropdown('format',$format,'',$pf);
	?>
	<div class="link_lap"><input type="button" name="laporan" id="laporan" value="Laporan" class="button_lap" onClick="Laporan()"></div><br />
<?
}
?>
</div>
<?=$this->load->view('footer')?>
</div>