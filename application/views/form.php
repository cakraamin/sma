<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Sistem Absensi</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/css/form.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/js/lightbox/facebox.css" media="screen" />
<link rel="icon" type="image/x-icon" href="<?=base_url()?>asset/images/logo.ico" />
<script type="text/javascript" src="<?=base_url()?>asset/js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/lightbox/facebox.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/jquery.form.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/ajax.js"></script>
<script type="text/javascript">
$(document).ready( function() {	
	setInterval( function() {
    	var seconds = new Date().getSeconds();
        var sdegree = seconds * 6;
        var srotate = "rotate(" + sdegree + "deg)";
              
        $("#sec").css({"-moz-transform" : srotate, "-webkit-transform" : srotate});
                  
    }, 1000 );
                  
    setInterval( function() {
        var hours = new Date().getHours();
        var mins = new Date().getMinutes();
        var hdegree = hours * 30 + (mins / 2);
        var hrotate = "rotate(" + hdegree + "deg)";
              
    	$("#hour").css({"-moz-transform" : hrotate, "-webkit-transform" : hrotate});          
    }, 1000 );
        
        
    setInterval( function() {
        var mins = new Date().getMinutes();
        var mdegree = mins * 6;
        var mrotate = "rotate(" + mdegree + "deg)";
              
    	$("#min").css({"-moz-transform" : mrotate, "-webkit-transform" : mrotate})              
    }, 1000 );
	
	setInterval( function() {
		var hours = new Date().getHours();
      var mins = new Date().getMinutes();
		var seconds = new Date().getSeconds();
		var waktu = hours+":"+mins+":"+seconds;
                      
		$.ajax({
			url:""+site+"form/cekJam/"+waktu,
			success: function(response){
				if(response == 'lewat'){
					$("#waktu").html('<p class="inaktif">Sistem Absensi Ditutup</p>');
					$('#nis').val('');
					$('#formAbsen :input').attr('disabled', true);
				}else{
					$("#waktu").html('<p class="aktif">Batas Absen Sampai Pukul '+response+'</p>');
					$('#formAbsen :input').removeAttr('disabled');
					$('#nis').focus();
				}
			},
			dataType:"html"  		
		});
		return false;
    }, 1000 );	
	
	$('#nis').focus();
});
</script>
</head>
<body>
<div id="wrap">
	<h2><a href="<?=base_url()?>"><?=$this->config->item('base_name')?></a></h2>
	<span id="logo">&nbsp;
	<ul id="clock">	
	   	<li id="sec"></li>
	   	<li id="hour"></li>
		<li id="min"></li>
	</ul>
	</span>
<h3><?=$hari?>,&nbsp;<?=$tgl?>&nbsp;<?=$bln?>&nbsp;<?=$thn?></h3>
<form method="post" action="<?=base_url()?>form/submit_form" class="f-wrap-1" id="formAbsen">
	<input name="nis" type="text" class="f-name" id="nis" style="text-align:center"/>
</form>
<div id="waktu"><p class="aktif">Batas Absen Sampai Pukul <?=$jam?></p></div>
<div id="informasi"></div>
</div>
</body>
</html>
