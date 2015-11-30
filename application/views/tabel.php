<div class="tabel">
<div class="border">
	<table border="0" cellspacing="0" cellpadding="0" class="formTabel">
	  <tr>
		<td rowspan="6" width="110px"><?=cek_gambar($kueri->gambar,"uploads/thumbnail")?></td>
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
	</table>
</div>
</div>
