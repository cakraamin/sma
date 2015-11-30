<link rel="stylesheet" href="<?=base_url()?>asset/js/jquery-ui/development-bundle/themes/base/jquery.ui.all.css">
<script src="<?=base_url()?>asset/js/jquery-ui/development-bundle/ui/jquery.ui.core.js"></script>
<script src="<?=base_url()?>asset/js/jquery-ui/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="<?=base_url()?>asset/js/jquery-ui/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
	</script>
<div id="utility">
	<ul id="nav-secondary">
		<li class="first"><a href="<?=base_url()?>laporan" <? if(isset($tambah)){ echo $tambah;}?>>Perkelas</a></li>
	</ul>
</div>
<div id="content">
<div class="cari">
<form method="post" action="<?=base_url()?>fguru/laporan/submit_laporan">
	<label for="nama"><b>Nama Anak :</b>
	<?
		if($kls == "")
		{
			$ketan = '';		
		}
		else
		{
			$ketan = 'OnChange="this.form.submit()"';
		}
		$pa = 'id="anak" class="anak" '.$ketan;
		echo form_dropdown('anak',$anak,$kls,$pa);
	?>
	</label><br/><br/>	
	<label for="kunci"><b>Tanggal Penyerahan :</b>
		<input type="text" id="datepicker" OnChange="this.form.submit()" name="tanggal" value="<? if(isset($tggl)){ echo $tggl;}?>">
	</label><br/><br/>
	<!--(0271) 854188-->
	<?
		if($bln != "" || $tgl != "" || $thn != "")
		{
	?>
	<label for="kunci"><b>Laporan :</b><a href="<?=base_url()?>fguru/laporan/lap/<?=$bln?>/<?=$tgl?>/<?=$thn?>/<?=$ank?>" target="_blank">Per tanggal <?=ganti_tanggal($thn."-".$bln."-".$tgl)?> Dengan NIS <?=$ank?></a></label>
	<?
		}	
	?>
</form>
</div>
<?=$this->load->view('admin/footer')?>
</div>