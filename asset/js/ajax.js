function setSiteURL() { 
	var server = window.location.host;
	window.site = "http://"+server+"/sma/";
}

function show_captcha(DIV){
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$.ajax({
		url:""+site+"captcha/gambar",
		beforeSend: function(){
			$(DIV).html(image_load);
			$('#kode').val('');
        },
		success: function(response){			
    		$(DIV).html(response);
  		},
  		dataType:"html"  		
  	});
  	return false;
};

function combo(){
	var nis = $('#nis').val();
	var kombo = $('#jangka').val();
	var jenis = $('#jenis').val();
	var image_load = "<img src='"+site+"asset/images/ajax.gif' />";
	$.ajax({
		url:""+site+"laporan/getKombo/"+jenis+"/"+kombo+"/"+nis,
		beforeSend: function(){
			$('.dropdown').html(image_load);
        },
		success: function(response){			
    		$('.dropdown').html(response);
  		},
  		dataType:"html"  		
  	});
  	return false;
};

function submitFormMapel(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formMapel').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formMapel :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formMapel :input').removeAttr('disabled');
			if(response=='exist'){
				$('.konfirmasi').html('<p class="notice">Nama Kelas Exist</p>');
				return false;
			}else if(response=='exists'){
				$('.konfirmasi').html('<p class="notice">Nama Wali Exist</p>');
				return false;			
			}else if(response=='ok'){
				window.location = site+'mapel/daftar';
			}else if(response=='edit'){
				var alamat = $('#page').val();
				window.location = site+'mapel/'+alamat;
			}else{
				$('.konfirmasi').html('<p class="notice">Data Kelas Gagal Disimpan</p>');
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormNilai(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formNilai').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formNilai :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formNilai :input').removeAttr('disabled');
			if(response=='ok'){
				var alamat = $('#page').val();
				window.location = site+'industri/daftar_industri/'+alamat;
			}else{
				$('.konfirmasi').html('<p class="notice">Data Nilai DU/DI Gagal Disimpan</p>');
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormCatat(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formCatat').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formCatat :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formCatat :input').removeAttr('disabled');
			if(response=='ok'){
				window.location = site+'fguru/catatan';
			}else{
				$('.konfirmasi').html('<p class="notice">Catatan Gagal Disimpan</p>');
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormAhli(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formAhli').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formAhli :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formAhli :input').removeAttr('disabled');
			if(response=='exist'){
				$('.konfirmasi').html('<p class="notice">Bidang Keahlian atau Program Keahlian Sudah Digunakan</p>');
				return false;			
			}else if(response=='ok'){
				window.location = site+'keahlian/daftar';
			}else if(response=='edit'){
				var alamat = $('#page').val();
				window.location = site+'keahlian/'+alamat;
			}else{
				$('.konfirmasi').html('<p class="notice">Data Keahlian Gagal Disimpan</p>');
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormTa(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formControlTa').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formControlTa :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formControlTa:input').removeAttr('disabled');
			if(response=='ok'){
				window.location = site+'control/ta';
			}else if(response=='edit'){
				var alamat = $('#page').val();
				window.location = site+'control/'+alamat;
			}else{
				$('.konfirmasi').html('<p class="notice">Tahun Ajaran Gagal Disimpan</p>');
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormDiri(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formDiri').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formDiri :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formDiri :input').removeAttr('disabled');
			if(response=='ok'){
				window.location = site+'diri/daftar';
			}else if(response=='edit'){
				var alamat = $('#page').val();
				window.location = site+'diri/'+alamat;
			}else{
				$('.konfirmasi').html('<p class="notice">Data Pengembangan Diri Gagal Disimpan</p>');
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormKompetensi(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formKompetensi').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formKompetensi :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formKompetensi :input').removeAttr('disabled');
			window.location = site+'fguru/administrasi/daftar/'+response;
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormMapelGuruKelas(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formMapelGuruKelas').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formMapelGuruKelas :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formMapelGuruKelas :input').removeAttr('disabled');			
			if(response=='ok'){
				window.location = site+'mapel/guru_mapel';
			}else if(response=='edit'){
				var alamat = $('#page').val();
				window.location = site+'mapel/'+alamat;
			}else{
				$('.konfirmasi').html('<p class="notice">Data Guru Kelas Mata Pelajaran Gagal Disimpan</p>');
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormMapelGuruKelass(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formMapelGuruKelass').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formMapelGuruKelass :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formMapelGuruKelass :input').removeAttr('disabled');			
			if(response=='ok'){
				var alamat = $('#page').val();
				window.location = site+'mapel/guru_mapel_kelas/'+alamat;
			}else if(response=='edit'){
				var alamat = $('#page').val();
				window.location = site+'mapel/'+alamat;			
			}else{
				$('.konfirmasi').html('<p class="notice">Data Guru Kelas Mata Pelajaran Gagal Disimpan</p>');
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function Laporan(){
	var nis = $('#nis').val();
	var kombo = $('#jangka').val();
	var jenis = $('#jenis').val();
	var format = $('#format').val();
	var alamat = site+"laporan/getLaporan/"+jenis+"/"+kombo+"/"+nis+"/"+format;
	
	var image_load = "<img src='"+site+"asset/images/ajax.gif' />";
	$.ajax({
		url:alamat,
		beforeSend: function(){
			$('.load_lap').append(image_load);
        },
		success: function(response){			
  		},
  		dataType:"html"  		
  	});
  	return false;
};

function buat(){
	var image_load = "<img src='"+site+"asset/images/ajax.gif' />";
	$.ajax({
		url:""+site+"home/buatTA",
		beforeSend: function(){
			$('.loading').html(image_load);
        },
		success: function(response){
			if(response=='ok'){
				$('.caution').fadeOut('slow');	
			}else{
				$('.loading').html('TA gagal dibuat');
			}
  		},
  		dataType:"html"  		
  	});
  	return false;
};

function showKelas(){
	var image_load = "<img src='"+site+"asset/images/ajax.gif' />";
	var nilai = $('#kelas').val();
	$.ajax({
		url:""+site+"kelas/show_kelas/"+nilai,
		beforeSend: function(){
			$('.isi_tabel').html(image_load);
        },
		success: function(response){
			if(response=='ok'){
				$('.notce').fadeOut('slow');	
			}else{
				$('.isi_tabel').html(response);
			}
  		},
  		dataType:"html"  		
  	});
  	return false;
};

function refresh(ket,refr){
   $.ajax({
		url: site+refr+ket,
			success: function(response){
				$('.isi').html(response);
			},
			dataType:"html"  		
	});
	return false;
}

function delAll(ket,addr,refr){
    var image_load = "<img src='"+site+"asset/images/ajax.gif' />&nbsp;&nbsp;";
	jConfirm('Yakin Akan Menghapus Data Yang Dicentang?', 'Confirmation Dialog', 		
		function(r) {			
			if(r==true){
				$('input:checkbox:not(.checkall)').each(function() {
					if(this.checked == true){
						var nilai = $(this).closest('tr').attr("id");
						var new_str = nilai.replace("tabel","");
						$.ajax({
							url: site+addr+new_str,
							success: function(response){
								if(response == 'ok'){
									$('#tabel'+nilai).remove();
								}else if(response == 'aktif'){
									jAlert( 'Gagal Menghapus, User sedang digunakan','Informasi' );
								}else{
									jAlert( 'Gagal Menghapus','Informasi' );
								}
							},
							dataType:"html"  		
						});
					}
				});
				refresh(ket,refr);
			}	
		});
    return false;
}

function confirmSubmit() {
	var msg= "Apakah Anda Yakin Akan Menghapus Data ? " ;
	var agree=confirm(msg);
	if (agree)
	return true ;
	else
	return false ;
}

function del(ket,addr,refr){
    var image_load = "<img src='"+site+"asset/images/ajax.gif' />&nbsp;&nbsp;";
	 jConfirm('Yakin Akan Menghapus Data Yang Dicentang?', 'Confirmation Dialog', 		
		function(r) {			
			if(r==true){
				$.ajax({
					url: site+addr,
					success: function(response){
						if(response == 'ok'){
							//$('#tabel'+nilai).remove();
						}else if(response == 'aktif'){
							jAlert( 'Gagal Menghapus, User sedang digunakan','Informasi' );
						}else{
							jAlert( 'Gagal Menghapus','Informasi' );
						}
					},
					dataType:"html"  		
				});
				refresh(ket,refr);
			}	
		});
    return false;
}

function submitFormLogin(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formLogin').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formLogin :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formLogin :input').removeAttr('disabled');
			if(response=='gagal'){
				$('.konfirmasi').html('<p>Kode Yang Dimasukkan Salah</p>');
				show_captcha('.captcha');
				$('#kode').focus();
				return false;
			}else if(response=='salah'){
				$('.konfirmasi').html('<p>Login Salah</p>');
				show_captcha('.captcha');
				return false;
			}else{
				document.location=site+'home/index/'+response;	
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormSiswa(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formSiswa').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formSiswa :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formSiswa :input').removeAttr('disabled');
			if(response=='exist'){
				$('.konfirmasi').html('<p class="notice">NIS Exist</p>');
				return false;
			}else if(response=='ok'){
				window.location = site+'siswa/daftar';
			}else if(response=='edit'){
				var alamat = $('#page').val();
				window.location = site+'siswa/'+alamat;
			}else{
				$('.konfirmasi').html('<p class="notice">Data Siswa Gagal Disimpan</p>');
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormKelasWali(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formKelasWali').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formKelasWali :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formKelasWali :input').removeAttr('disabled');
			if(response=='exist'){
				$('.konfirmasi').html('<p class="notice">NIP Exist</p>');
				return false;
			}else if(response=='ok'){
				window.location = site+'kelas/daftar_wali';
			}else if(response=='edit'){
				var alamat = $('#page').val();
				window.location = site+'kelas/'+alamat;
			}else if(response == 'kosong'){
				$('.konfirmasi').html('<p class="notice">NIP Belun Terdaftar</p>');
				return false;
			}else{
				$('.konfirmasi').html('<p class="notice">Data Wali Kelas Gagal Disimpan</p>');
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormAbsensi(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formAbsensi').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formAbsensi :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formAbsensi :input').removeAttr('disabled');
			if(response == 'sudah'){
				$('.konfirmasi').html('<p class="notice">Siswa Sudah Absen</p>');
				return false;
			}else if(response == 'gagal'){
				$('.konfirmasi').html('<p class="notice">Gagal Mengabsen</p>');
				return false;
			}else if(response == 'kosong'){
				$('.konfirmasi').html('<p class="notice">NIS Belun Terdaftar</p>');
				return false;
			}else{
				$('.konfirmasi').html('<p class="succes">Absensi Berhasil Disimpan</p>');
				$('#reset').click();
				$('#nis').focus();
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormControl(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formControl').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formControl :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formControl :input').removeAttr('disabled');
			if(response=='gagal'){
				$('.konfirmasi').html('<p class="notice">Setting Batas Jam Masuk Gagal Disimpan</p>');
				return false;
			}else{
				$('.konfirmasi').html(response);
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormControlKepala(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formControlKepala').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formControlKepala :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formControlKepala :input').removeAttr('disabled');
			if(response=='gagal'){
				$('.konfirmasi').html('<p class="notice">Control Kepala Sekolah Gagal Disimpan</p>');
				return false;
			}else{
				$('.konfirmasi').html('<p class="succes">Control Kepala Sekolah Berhasil Disimpan</p>');
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormSetNilai(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formSetNilai').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formSetNilai :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formSetNilai :input').removeAttr('disabled');
			if(response=='gagal'){
				$('.konfirmasi').html('<p class="notice">Setting Nilai Gagal Disimpan</p>');
				return false;
			}else{
				$('.konfirmasi').html(response);
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormControlSemester(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formControlSem').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formControlSem :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formControlSem :input').removeAttr('disabled');
			if(response=='gagal'){
				$('.konfirmasi').html('<p class="notice">Setting Semester Gagal Disimpan</p>');
				return false;
			}else{
				$('.konfirmasi').html(response);
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormKelasSiswa(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formKelasSiswa').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formKelasSiswa :input').attr('disabled', true);
		},
		success: function(response){
			var ket = $('#ket').val();
			var ref = $('#ref').val();
			$('.status').html('');
			$('#formKelasSiswa :input').removeAttr('disabled');
			if(response=='kosong'){
				$('.konfirmasi').html('<p class="notice">NIS belum terdaftar</p>');
				return false;
			}else if(response=='exists'){
				$('.konfirmasi').html('<p class="notice">NIS sudah terdaftar di kelas lain</p>');
				$('#reset').click();
				return false;			
			}else if(response=='ok'){
				var kode = $('#kode').val();
				window.location = site+'kelas/add_siswa/'+kode;
				return false;
			}else{
				var alamat = $('#page').val();
 				window.location = site+'kelas/'+alamat;
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormKelas(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formKelas').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formKelas :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formKelas :input').removeAttr('disabled');
			if(response=='exist'){
				$('.konfirmasi').html('<p class="notice">Nama Kelas Exist</p>');
				return false;
			}else if(response=='exists'){
				$('.konfirmasi').html('<p class="notice">Nama Wali Exist</p>');
				return false;			
			}else if(response=='ok'){
				window.location = site+'kelas/daftar';
			}else if(response=='edit'){
				var alamat = $('#page').val();
				window.location = site+'kelas/'+alamat;
			}else{
				$('.konfirmasi').html('<p class="notice">Data Kelas Gagal Disimpan</p>');
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormGuru(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formGuru').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formGuru :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formGuru :input').removeAttr('disabled');
			if(response=='exist'){
				$('.konfirmasi').html('<p class="notice">NIP Exist</p>');
				return false;
			}else if(response=='ok'){
				window.location = site+'guru/daftar';
			}else if(response=='edit'){
				var alamat = $('#page').val();
				window.location = site+'guru/'+alamat;
			}else{
				$('.konfirmasi').html('<p class="notice">Data Guru Gagal Disimpan</p>');
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormGuruMapel(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formMapelGuru').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formMapelGuru :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formMapelGuru :input').removeAttr('disabled');
			if(response=='exist'){
				$('.konfirmasi').html('<p class="notice">NIP Exist</p>');
				return false;
			}else if(response=='ok'){
				window.location = site+'mapel/guru_mapel';
			}else if(response=='edit'){
				var alamat = $('#page').val();
				window.location = site+'mapel/'+alamat;
			}else{
				$('.konfirmasi').html('<p class="notice">Data Guru Gagal Disimpan</p>');
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormUser(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formUser').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formUser :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formUser :input').removeAttr('disabled');
			if(response=='belum'){
				$('.konfirmasi').html('<p class="notice">NIP Belum Terdaftar</p>');
				return false;
			}else if(response=='gagal'){
				$('.konfirmasi').html('<p class="notice">User Gagal Disimpan</p>');
				return false;
			}else{
				window.location = site+'admin/user/daftar';			
			}
			alert(response);
		}, 
		dataType: 'html'
	});
	return true;
};

function submitFormAccount(){ 
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formAccount').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formAccount :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formAccount :input').removeAttr('disabled');
			if(response=='OK'){
				$('.konfirmasi').html('<p>Account Berhasil Diupdate</p>');
				$('#reset').click();
				$('#nama').focus();
				return false;
			}else{
				$('.konfirmasi').html(response);
				return false;
			}
		}, 
		dataType: 'html'
	});
	return false;
};

function submitFormAspek(){
	var kode = $('#kode').val();
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formAspek').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formAspek :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formAspek :input').removeAttr('disabled');
			window.location = site+'aspek/nilai/'+kode;
		}, 
		dataType: 'html'
	});
	return false;
}

function submitFormMapelKelas(){	
	var kelasnya = $('#kelasnya').val();
	var image_load = "<div class='ajax_loading'><img src='"+site+"asset/images/ajax.gif' /></div>";
	$('#formMapelKelas').ajaxSubmit({
		beforeSubmit: function(){
			$('.status').html(image_load);
			$('#formMapelKelas :input').attr('disabled', true);
		},
		success: function(response){
			$('.status').html('');
			$('#formMapelKelas :input').removeAttr('disabled');
			window.location = site+'mapel/guru_kelas/'+kelasnya;
		}, 
		dataType: 'html'
	});
	return false;
}

function submitFormAbsen(){ 
	$('#formAbsen').ajaxSubmit({
		beforeSubmit: function(){
			$('#formAbsen :input').attr('disabled', true);
		},
		success: function(response){
			var nis = $('#nis').val();
			$('#formAbsen :input').removeAttr('disabled');
			if(response == 'sudah'){
				setInterval( function() {
					$('#informasi').html('');
				}, 5000 );
				var pesan = "<p class='notice'>Anda Sudah Absen</p>";
				$('#informasi').html(pesan);
				$('#nis').val('');
				$('#nis').focus();
				return false;
			}else if(response == 'gagal'){
				setInterval( function() {
					$('#informasi').html('');
				}, 5000 );
				var pesan = "<p class='notice'>Gagal Mengabsen</p>";
				$('#informasi').html(pesan);
				$('#nis').focus();
				return false;
			}else if(response == 'kosong'){
				setInterval( function() {
					$('#informasi').html('');
				}, 5000 );
				var pesan = "<p class='notice'>NIS Belum Terdaftar</p>";
				$('#informasi').html(pesan);
				$('#nis').val('');
				$('#nis').focus();
				return false;
			}else{
				setInterval( function() {
					jQuery.facebox.close();
					$('#nis').val('');
					$('#nis').focus();
					return false;
				}, 5000 );
				$.ajax({
					url:""+site+"form/detil/"+nis,
					beforeSend: function(){
						jQuery.facebox('&nbsp;loading');
					},
					success: function(response){			
						jQuery.facebox(response);
					},
					dataType:"html"  		
				});
			}
		}, 
		dataType: 'html'
	});
	return false;
};

$(document).ready( function() {		
	setSiteURL();
		
	$("#formControlSem").validate({
		submitHandler:function(form) {
			submitFormControlSemester();
		},
		rules: {
			semester: "required"
		},
		messages: {
			semester: {
				required: 'Semester harus di isi'
			}
		}
	});

	$("#formAspek").validate({
		submitHandler:function(form) {
			submitFormAspek();
		},
		rules: {
			semester: "required"
		},
		messages: {
			semester: {
				required: 'Semester harus di isi'
			}
		}
	});

	$("#formMapelKelas").validate({
		submitHandler:function(form) {
			submitFormMapelKelas();
		},
		rules: {
			nip: "required"
		},
		messages: {
			nip: {
				required: 'Nama Mapel Kelas'
			}
		}
	});
	
	$("#formControlTa").validate({
		submitHandler:function(form) {
			submitFormTa();
		},
		rules: {
			ta: "required"
		},
		messages: {
			ta: {
				required: 'Tahun Ajaran harus di isi'
			}
		}
	});
	
	$("#formControlKepala").validate({
		submitHandler:function(form) {
			submitFormControlKepala();
		},
		rules: {
			nip: "required",
			nama: "required"
		},
		messages: {
			nip: {
				required: 'NIP harus di isi'
			},
			nama: {
				required: 'Nama harus di isi'
			}
		}
	});
	
	$("#formNilai").validate({
		submitHandler:function(form) {
			submitFormNilai();
		},
		rules: {
			nama: "required",
			alamat: "required",
			lama: "required",
			nilai: "required"
		},
		messages: {
			nama: {
				required: 'Nama DU/DI harus di isi'
			},
			alamat: {
				required: 'Alamat DU/DI harus di isi'
			},
			lama: {
				required: 'Lama DU/DI harus di isi'
			},
			nilai: {
				required: 'Nilai DU/DI harus di isi'
			}
		}
	});
	
	$("#formCatat").validate({
		submitHandler:function(form) {
			submitFormCatat();
		},
		rules: {
			catat: "required"
		},
		messages: {
			catat: {
				required: 'Catatan harus di isi'
			}
		}
	});
	
	$("#formAhli").validate({
		submitHandler:function(form) {
			submitFormAhli();
		},
		rules: {
			bidang: "required",
			program: "required"
		},
		messages: {
			bidang: {
				required: 'Bidang Keahlian harus di isi'
			},
			program: {
				required: 'Program Keahlian harus di isi'
			}
		}
	});
	
	$("#formDiri").validate({
		submitHandler:function(form) {
			submitFormDiri();
		},
		rules: {
			diri: "required"
		},
		messages: {
			diri: {
				required: 'Pengembangan Diri harus di isi'
			}
		}
	});
	
	$("#formSetNilai").validate({
		submitHandler:function(form) {
			submitFormSetNilai();
		},
		rules: {
			nilai: "required"
		},
		messages: {
			nilai: {
				required: 'Nilai Belum Dipilih'
			}
		}
	});
	
	$("#formKompetensi").validate({
		submitHandler:function(form) {
			submitFormKompetensi();
		},
		rules: {
			semester: "required"
		},
		messages: {
			semester: {
				required: 'Semester harus di isi'
			}
		}
	});
	
	$("#formMapelGuruKelas").validate({
		submitHandler:function(form) {
			submitFormMapelGuruKelas();
		},
		rules: {
			kelas: "required"
		},
		messages: {
			kelas: {
				required: 'Kelas Harus Dipilih'
			}
		}
	});
	
	$("#formMapelGuruKelass").validate({
		submitHandler:function(form) {
			submitFormMapelGuruKelass();
		},
		rules: {
			kelas: "required"
		},
		messages: {
			kelas: {
				required: 'Kelas Harus Dipilih'
			}
		}
	});
	
	$("#formMapel").validate({
		submitHandler:function(form) {
			submitFormMapel();
		},
		rules: {
			nama: "required"
		},
		messages: {
			nama: {
				required: 'Nama Mata Pelajaran harus di isi'
			}
		}
	});
	
	$("#formMapelGuru").validate({
		submitHandler:function(form) {
			submitFormGuruMapel();
		},
		rules: {
			nip: "required"
		},
		messages: {
			nip: {
				required: 'NIP harus di isi'
			}
		}
	});
	
	$("#formKelasWali").validate({
		submitHandler:function(form) {
			submitFormKelasWali();
		},
		rules: {
			nip: "required"
		},
		messages: {
			nip: {
				required: 'NIP harus di isi'
			}
		}
	});		
		
	$("#formLogin").validate({
		submitHandler:function(form) {
			submitFormLogin();
		},
		rules: {
			nama: "required",
			pass: "required",
			kode: "required"
		},
		messages: {
			nama: {
				required: 'Username harus di isi'
			},
			pass: {
				required: 'Password harus di isi'
			},
			kode: {
				required: 'Kode harus di isi'
			}
		}
	});
	
	$("#formAbsensi").validate({
		submitHandler:function(form) {
			submitFormAbsensi();
		},
		rules: {
			nis: "required"
		},
		messages: {
			nis: {
				required: 'NIS harus di isi'
			}
		}
	});
	
	$("#formAbsen").validate({
		submitHandler:function(form) {
			submitFormAbsen();
		},
		rules: {
			nis: "required"
		},
		messages: {
			nis: {
				required: 'Isikan NIS'
			}
		}
	});
	
	$("#formKelasSiswa").validate({
		submitHandler:function(form) {
			submitFormKelasSiswa();
		},
		rules: {
			nis: "required",
			nama: "required",
			tempat: "required",
			alamat: "required"
		},
		messages: {
			nis: {
				required: 'NIS harus di isi'
			},
			nama: {
				required: 'Nama harus di isi'
			},
			tempat: {
				required: 'Tempat harus di isi'
			},
			alamat: {
				required: 'Alamat harus di isi'
			}
		}
	});
	
	$("#formKelas").validate({
		submitHandler:function(form) {
			submitFormKelas();
		},
		rules: {
			nama: "required"
		},
		messages: {
			nama: {
				required: 'Nama Kelas harus di isi'
			}
		}
	});
	
	$("#formGuru").validate({
		submitHandler:function(form) {
			submitFormGuru();
		},
		rules: {
			nip: "required",
			nama: "required",
			tempat: "required",
			alamat: "required"
		},
		messages: {
			nip: {
				required: 'NIP harus di isi'
			},			
			nama: {
				required: 'Username harus di isi'
			},
			tempat: {
				required: 'Tempat Lahir harus di isi'
			},
			alamat: {
				required: 'Alamat harus di isi'
			}
		}
	});
	
	$("#formUser").validate({
		submitHandler:function(form) {
			submitFormUser();
		},
		rules: {
			name: "required",
			nama: "required",
			alamat: "required",
			pass:{
				required: true,
				minlength: 6
			},
			confrim:{
				required: true,
				equalTo: "#pass"
			}
		},
		messages: {
			name: {
				required: 'Nama lengkap harus di isi'
			},
			nama: {
				required: 'Username harus di isi'
			},
			alamat: {
				required: 'Alamat harus di isi'
			},
			pass: {
				required: 'Password harus di isi',
				minlength: 'Password minimal 6 karakter'
			},
			confrim: {
				required: 'Confirm Password harus di isi',
				equalTo : 'Isinya harus sama dengan Password'
			}
		}
	});
	
	$("#formAccount").validate({
		submitHandler:function(form) {
			submitFormAccount();
		},
		rules: {
			nama: "required",
			passl: "required",
			pass:{
				required: true,
				minlength: 6
			},
			confrim:{
				required: true,
				equalTo: "#pass"
			}
		},
		messages: {
			nama: {
				required: 'Username harus di isi'
			},
			passl: {
				required: 'Password lama harus di isi'
			},
			pass: {
				required: 'Password baru harus di isi',
				minlength: 'Password minimal 6 karakter'
			},
			confrim: {
				required: 'Password lama harus di isi',
				equalTo : 'Isinya harus sama dengan Password'
			}
		}
	});
	
	$("#formSiswa").validate({
		submitHandler:function(form) {
			submitFormSiswa();
		},
		rules: {
			nis: "required",
			nama: "required",
			tempat: "required",
			alamat: "required"
		},
		messages: {
			nis: {
				required: 'NIS harus di isi'
			},
			nama: {
				required: 'Nama Lengkap harus di isi'
			},
			tempat: {
				required: 'Tempat Lahir harus di isi'
			},
			alamat: {
				required: 'Alamat harus di isi'
			}
		}
	});
	
	$("#formControl").validate({
		submitHandler:function(form) {
			submitFormControl();
		},
		rules: {
			jam: "required"
		},
		messages: {
			jam: {
				required: 'Batas Jam Masuk Belum Ditentukan'
			}
		}
	});

	$(".checkall").live('click',function(event){
		$('input:checkbox:not(.checkall)').attr('checked',this.checked);
		if ($(this).attr("checked") == true){
			$(".content").find('tr:not(#chkrow)').removeClass('genap');
			$(".content").find('tr:not(#chkrow)').removeClass('ganjil');
			$(".content").find('tr:not(#chkrow)').addClass('hight');
		}else{
			DisCheckSelectAll();
		}
	});

	$('input:checkbox:not(.checkall)').live('click',function(event){
		if($(".checkall").attr('checked') == true && this.checked == false){
			$(".checkall").attr('checked',false);
			$(this).closest('tr').removeClass('hight');
		}
		if(this.checked == true){
			var nilai = $(this).closest('tr').attr("id");
			if(nilai % 2 == 0){
				$(this).closest('tr').removeClass('genap');
			}else{
				$(this).closest('tr').removeClass('ganjil');	
			}
			$(this).closest('tr').addClass('hight');
			CheckSelectAll();
		}
		if(this.checked == false){
			$(this).closest('tr').removeClass('hight');
			var nilai = $(this).closest('tr').attr("id");
			if(nilai % 2 == 0){
				$(this).closest('tr').addClass('genap');
			}else{
				$(this).closest('tr').addClass('ganjil');	
			}
		}
	});
	
	function CheckSelectAll(){
		var flag = true;
		$('input:checkbox:not(.checkall)').each(function() {
			if(this.checked == false)
			flag = false;
		});
		$(".checkall").attr('checked',flag);
	}
	
	function DisCheckSelectAll(){
		var flag = false;
		$('input:checkbox:not(.checkall)').each(function() {
			if(this.checked == true)
			flag = true;
			$(this).closest('tr').removeClass('hight');
			var nilai = $(this).closest('tr').attr("id");
			if(nilai % 2 == 0){
				$(this).closest('tr').addClass('genap');
			}else{
				$(this).closest('tr').addClass('ganjil');	
			}
		});
		$(".checkall").attr('checked',flag);
	}
});
