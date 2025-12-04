$(document).ready(function() {			
				
	$(".editnikreg").dblclick(function(){
		var isiawal = $(this).html();
		$(this).html('<input type="text" class="valnik" value="'+isiawal+'"><input type="button" value="edit" class="savenikreg btn btn-xs btn-info">');
		$(".savenikreg").click(function(){
			var nik = $(this).parent().find(".valnik").val();
			var nocm = $(this).parent().parent().find(".nocmreg").val();
			$.post( "edit_nik_pasien_jquery.php", { nik: nik,nocm: nocm});
			$(this).parent().html(nik);
		});
	});
	
	// $(".editnobpjs").dblclick(function(){
		// var isiawal = $(this).html();
		// $(this).html('<input type="text" class="valnobpjs" value="'+isiawal+'"><input type="button" value="edit" class="savenobpjs btn btn-xs btn-info">');
		// $(".savenobpjs").click(function(){
			// var nobpjs = $(this).parent().find(".valnobpjs").val();
			// var nocm = $(this).parent().parent().find(".nocmreg").val();
			// $.post( "edit_nobpjs_pasien_jquery.php", { nobpjs: nobpjs,nocm: nocm});
			// $(this).parent().html(nobpjs);
		// });
	// });
	
	$(".btneditnorm").click(function(){
		var isiawal = $(".editnormtext").html();
		$(".btneditnorm").hide();
		$(".editnormtext").html('<input type="text" class="valnorm" value="'+isiawal+'" size="25px" maxlength="11"> <input type="button" value="Simpan" class="btn savenorm">');
		$(".savenorm").click(function(){
			var norm = $(this).parent().find(".valnorm").val();
			var nocm = $(this).parent().parent().parent().find(".nocmreg").val();
			var noindex = $(this).parent().parent().parent().find(".noindexreg").val();
			
			$.post( "edit_norm_pasien_jquery.php", { norm: norm,nocm: nocm,noindex: noindex}).done(function( data ) {
				
				if(data == 'sukses'){
					$(".editnormtext").html(norm);
					$(".btneditnorm").show();
				}else{
					alert(data);
				}
			});
		});
	});
	
	$(".btneditnobpjs").click(function(){
		var isiawal = $(".editnobpjstext").html();
		$(".btneditnobpjs").hide();
		$(".editnobpjstext").html('<input type="text" class="valnobpjs" value="'+isiawal+'" size="25px"> <input type="button" value="Simpan" class="btn btn-white savenobpjs">');
		$(".savenobpjs").click(function(){
			var nobpjs = $(this).parent().find(".valnobpjs").val();
			var panjang_nobpjs = nobpjs.length;
			if(panjang_nobpjs < 13){
				alert('No bpjs kurang dari 13 digit');
			}else if(panjang_nobpjs > 13){
				alert('No bpjs lebih dari 13 digit');	
			}else{
			
			var nocm = $(this).parent().parent().parent().find(".nocmreg").val();
			
			$.post( "edit_nobpjs_pasien_jquery.php", { nobpjs: nobpjs,nocm: nocm}).done(function( data ) {
				$(".kodeprovider").val(data);
			});
			$(".editnobpjstext").html(nobpjs);
			$(".nokartubpjseditjquery").val(nobpjs);
			
			// $(".editnobpjstext").html(kodeppk);
			// $(".nokartubpjseditjquery").val(kodeppk);
			$(".btneditnobpjs").show();
			}
		});
	});
					
	$(".btnedit").click(function(){
		var isiawal = $(".editnamapsntext").html();
		$(".btnedit").hide();
		$(".editnamapsntext").html('<input type="text" class="valnamapsn" value="'+isiawal+'" size="25px"> <input type="button" value="Simpan" class="btn btn-white savenamapsn">');
		$(".savenamapsn").click(function(){
			var namapsn = $(this).parent().find(".valnamapsn").val();
			var idpasien = $(this).parent().parent().parent().find(".idpasien").val();
			
			$.post( "edit_namapsn_jquery.php", { namapsn: namapsn,idpasien: idpasien});
			$(".editnamapsntext").html(namapsn);
			$(".btnedit").show();
		});
	});
		
	$(".btneditnik").click(function(){
		var isiawal = $(".editnik").html();
		$(".btneditnik").hide();
		$(".editnik").html('<input type="text" class="valnamapsn" value="'+isiawal+'" size="25px"> <input type="button" value="Simpan" class="btn btn-white savenamapsn">');
		$(".savenamapsn").click(function(){
			var nik = $(this).parent().find(".valnamapsn").val();
			var idpasien = $(this).parent().parent().parent().find(".idpasien").val();
			
			$.post( "edit_nik_pasien_jquery.php", { nik: nik,idpasien: idpasien});
			$(".editnik").html(nik);
			$(".nikps").val(nik);
			$(".btneditnik").show();
		});
	});	
	
	$(".btngrafikdetail").click(function(){
		$(".grafikdetail").removeClass('hidden');
	});
	$(".nbr").focusout(function(){
		var isi = $(this).val()+" "+$(".kekuatannbr").val()+" "+$(".sediaannbr").val();
		$(".hasilnbr").val(isi);
	});
	
	$(".kekuatannbr").focusout(function(){
		var isi = $(".nbr").val()+" "+$(this).val()+" "+$(".sediaannbr").val();
		
		$(".hasilnbr").val(isi);
	});
	
	$(".sediaannbr").focusout(function(){
		var isi = $(".nbr").val()+" "+$(this).val()+" "+$(".kekuatannbr").val();
		
		$(".hasilnbr").val(isi);
	});
	
	
	$(".formtambahkk").hide();
	$(".kembali_kk").hide();
	$(".tambah_kk").click(function(){
		$(".tambah_kk").hide();
		$(".kembali_kk").show();
		$(".formtambahkk").show();
		$(".selainformtambahkk").hide();
	});
	$(".kembali_kk").click(function(){
		$(".kembali_kk").hide();
		$(".tambah_kk").show();
		$(".formtambahkk").hide();
		$(".selainformtambahkk").show();
	});
	
	$(".lap_loket").change(function(){
		var isi = $(this).val();
		if(isi == 'TanggalRegistrasi'){
			$('.key').hide();
			$('.key').removeAttr("required"); 
			$('.tampilformdate').removeClass('hiddens');
			$('.tampilformdate').find('.datepicker2').prop("required",true);
		}else{
			$('.key').show();
			$('.key').prop("required",true);
			$('.tampilformdate').find('.datepicker2').removeAttr("required"); 
			$('.tampilformdate').addClass('hiddens');
		}
	});
	
	$(".lap_poli").change(function(){
		var isi = $(this).val();
		if(isi == 'TanggalRegistrasi'){
			$('.key').hide();
			$('.key').removeAttr("required"); 
			$('.tampilformdate').removeClass('hiddens');
			$('.tampilformdate').find('.datepicker2').prop("required",true);
		}else{
			$('.key').show();
			$('.key').prop("required",true);
			$('.tampilformdate').find('.datepicker2').removeAttr("required"); 
			$('.tampilformdate').addClass('hiddens');
		}
	});

	$(".kategori_pencarian_rfid").change(function(){
		var isi = $(this).val();
		if(isi == 'Rfid'){
			var timer = null;
			$('.cari').keyup(function(){
				clearTimeout(timer); 
				timer = setTimeout(clicktombol, 400)
			});

			function clicktombol() {
				//alert('tes');
				$(".clicktombol").trigger('click');
			}
		}
	});
	$('.barcodefocus').bind('keypress', function(e) {
			var code = e.keyCode || e.which;
			if(code == 13) { //Enter keycode
				$( ".submit" ).submit();
			}
	});		
		$(".nama_supplier").focus();		
			
		$('.barcode').bind('keypress', function(e) {
			var code = e.keyCode || e.which;
			if(code == 13) { //Enter keycode
			
			var bar = $(this).val();
			var lokasi = $(this).parent().parent().parent();
			$.post( "get_namabarang_gudangbesar_barcode.php", { barcode: bar })
			  .done(function( data ) {
			  var obj = jQuery.parseJSON(data);
				 lokasi.find('.barcode').val( obj.barcode );
				 lokasi.find('.nama_barang_gudang_besar').val( obj.namabarang );
				 lokasi.find('.kodebarang').val( obj.kodebarang );
				 lokasi.find('.satuan').val( obj.satuan );
				 lokasi.find('.nobatch').val( obj.nobatch );
				 lokasi.find('.expire').val( obj.expire );
				 lokasi.find('.hargabeli').val( obj.hargabeli );
				 lokasi.find('.stok').val( obj.stok );
			});
			$(".jumlah").focus();
			$(".jumlah").val("");
			}
		});
		
		$('.barcode_gp').bind('keypress', function(e) {
			var code = e.keyCode || e.which;
			if(code == 13) { //Enter keycode
			
			var bar = $(this).val();
			var lokasi = $(this).parent().parent().parent();
			$.post( "get_namabarang_gudangpelayanan_barcode.php", { barcode: bar })
			  .done(function( data ) {
			  var obj = jQuery.parseJSON(data);
				 lokasi.find('.barcode').val( obj.barcode );
				 lokasi.find('.nama_barang_gudang_pelayanan').val( obj.namabarang );
				 lokasi.find('.kodebarang').val( obj.kodebarang );
				 lokasi.find('.satuan').val( obj.satuan );
				 lokasi.find('.nobatch').val( obj.nobatch );
				 lokasi.find('.expire').val( obj.expire );
				 lokasi.find('.hargabeli').val( obj.hargabeli );
				 lokasi.find('.stok').val( obj.stok );
			});
			$(".jumlah").focus();
			$(".jumlah").val("");
			}
		});
		
		// $( ".form-control" ).bind('keypress', function(e) {//untuk mematikan enter, supaya tidak submit langsung
		// 	var code = e.keyCode || e.which;
		// 	 if(code == 13) { //Enter keycode
		// 	   return false;
		// 	 }
		// });
		
		$(".btnhapus").click(function(){
		
			var nama = $(this).parent().parent().find(".nama").html();
			var conf = confirm("apakah anda yakin akan menghapus data "+ nama +" ini ?");

			if(conf)
			{
			  window.location = $(this).attr("href");
			}
			return false;
			
		});
		$(".tesdate").click(function(){
			$(this).parent().find(".datepicker").datepicker("show");
		});
		$(".katdatareg").change(function(){
			var isi = $(this).val();
			if(isi == 'TanggalRegistrasi' || isi == 'TanggalPinjam'){
				$(this).parent().parent().parent().find(".key").val("");
				$(this).parent().parent().parent().find(".key").datepicker({format: 'yyyy-mm-dd',});
			}else{
				$(this).parent().parent().parent().find(".key").datepicker("destroy");
				$(this).parent().parent().parent().find(".key").val("");
			}
		});
			var isi = $(".katdatareg").val();
			if(isi == 'TanggalRegistrasi' || isi == 'TanggalPinjam'){
				$(".key").datepicker({format: 'yyyy-mm-dd',});
			}else if(isi == 'TanggalRegistrasi' || isi == 'TanggalPinjam'){
			}else{
				$(".key").datepicker("destroy");
			}
		
		$('.datepicker2').datepicker({
			format: 'yyyy-mm-dd',
		});
		
		$('.datepicker').datepicker({
			format: 'dd-mm-yyyy',
		});

		
		
		$(".tglreg").change(function(){
			var tgl =$(this).val();
			var lokasinoreg = $(this).parent().parent().parent().parent().find(".noreg");
			var noreg = lokasinoreg.val();
			
			$.post( "get_noreg.php", { tgl: tgl, noreg: noreg })
			  .done(function( data ) {
				 lokasinoreg.val( data );
			});
		});
		
		$('#myModalxxx').modal('show');
		
		$('.btnmodalobat').click(function(){
			var noresep = $(this).parent().parent().find(".noresep").html()
			var pelayanan = $(this).parent().parent().find(".pelayanan").html()
			//alert(noresep);
			$.post( "get_modal_apotik.php", { no: noresep, ply: pelayanan})
			  .done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#Modalobat').modal('show');
			});
		});
		
		$('.btnmodalrm').click(function(){
			var noresep = $(this).parent().parent().find(".noresep").html()
			//alert(noresep);
			$.post( "get_modal_nomorrm.php", { no: noresep})
			  .done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#Modalrm').modal('show');
			});
		});
		
		$('.btnmodalrm_bandungkab').click(function(){
			var noresep = $(this).parent().parent().find(".noresep").html()
			//alert(noresep);
			$.post( "get_modal_nomorrm_bandungkab.php", { no: noresep})
			  .done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#Modalrm').modal('show');
			});
		});
					
		$('.btnmodalpuskesmas').click(function(){
			 $('#modalpuskesmas').modal('show');
		});
			
		$('.btnmodallihatdistribusi').click(function(){
			var nofaktur = $(this).parent().parent().find(".nomorfaktur").html()
			$.post( "get_modal_distribusi_barang.php", { id: nofaktur })
			  .done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#modallihatdistribusi').modal('show');
			});	
		});
		
		$('.btnmodalpcareedit').click(function(){
			var kodepuskesmas = $(this).parent().parent().find(".kodepuskesmas").html()
			//alert(kodepuskesmas);
			$.post( "get_modal_pcare.php", { id: kodepuskesmas })
			  .done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#modaleditpuskesmas').modal('show');
			});	
		});
		
		$('.btnmodalpegawai').click(function(){
			$('#modalpegawai').modal('show');
		});	
		
		$('.btnmodalkartubelakang').click(function(){
			$('#modalkartubelakang').modal('show');
		});	
		
		$('.btnmodaldkh').click(function(){
			$('#modaldkh').modal('show');
		});	
		
		$('.btnmodaltindakan').click(function(){
			$('#modaltindakan').modal('show');
		});
		
		$('.btnmodalpengadaanobat').click(function(){
			var kodebarang = $(this).data('kodebarang');
			$.post( "get_modal_persediaan_obat.php", { kodebarang: kodebarang })
			  .done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#btnmodalpengadaanobat').modal('show');
			});	
			
		});	
		
		$('.btnmodalpegawaiedit').click(function(){
			var nip = $(this).parent().parent().find(".nip").html()
			var kota = $(this).parent().parent().find(".kota").html()
			//alert(nip);
			// alert(kota);
			if(kota == 'KABUPATEN GARUT'){
				$.post( "get_modal_pegawai_garutkab.php", { id: nip })
				  .done(function( data ) {
					 $( ".hasilmodal" ).html( data );
					 $('#modaleditpegawai').modal('show');
				});	
			}else{
				$.post( "get_modal_pegawai.php", { id: nip })
				  .done(function( data ) {
					 $( ".hasilmodal" ).html( data );
					 $('#modaleditpegawai').modal('show');
				});	
			}	
		});
		
		$('.btnmodalantrianedit').click(function(){
			var idantrian = $(this).parent().parent().find(".idantrian").html()
			//alert(nip);
			$.post( "get_modal_aplikasi_antrian.php", { id: idantrian })
			  .done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#modaleditantrian').modal('show');
			});					
		});
		
		$('.btnmodalpendampingan').click(function(){
			var nofaktur = $(this).parent().parent().find(".nofaktur").html()
			//alert(nip);
			$.post( "get_modal_pendampingan.php", { id: nofaktur })
			  .done(function( data ) {
				$( ".hasilmodal" ).html( data );
				$('#modalpendampingan').modal('show');
			});	
		});
		
		$('.btnmodalpkmbumil').click(function(){
			var kodepuskesmas = $(this).parent().parent().find(".kodepuskesmas").html()
			// alert(kodepuskesmas);
			$.post( "get_modal_bumil.php", { id: kodepuskesmas })
			  .done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#modalbumil1').modal('show');
			});							
		});
		
		$('.btnmodal_gudang_puskesmas').click(function(){
			var kodebarang = $(this).parent().parent().find(".kodebarang").html()
			$.post( "get_modal_gudang_puskesmas.php", { id: kodebarang })
			  .done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#modalgudangpuskesmas').modal('show');
			});	
		});
		
		$('.btnmodalkartupasienkk').click(function(){
			var noindex = $(this).parent().find(".noindex").val()
			//alert(noindex);//noindex
			$.post( "get_modal_kartupasien_kk.php", { id: noindex })
			  .done(function( data ) {
				 $( ".hasilmodalkk" ).html( data );
				 $('#modalkartupasienkk').modal('show');
			});	
		});
		
		$('.btnmodalobatdistribusi').click(function(){
			var kdpenerima = $(this).parent().parent().find(".kdpenerima").html()
			//alert(kdpenerima);
			$.post( "get_modal_obat_distribusi.php", { id: kdpenerima })
			  .done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#modalobatdistribusi').modal('show');
			});					
		});
		
		$('.btnmodalkunjunganresep').click(function(){
			var kodepkm = $(this).parent().parent().find(".kodepkm").html()
			//alert(kodepkm);
			$.post( "get_modal_kunjungan_resep.php", { id: kodepkm })
			  .done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#modalkunjunganresep').modal('show');
			});					
		});
		
	
		
		if($(".asuransi").val() != 'UMUM'){
			$( ".tarif" ).val("0");
		}
		
		$('.asuransichange').change(function(){
			if($(this).val() == 'UMUM' && $(".tarifkarcis_check").prop('checked')==true){
				var isi =  $('input[name="polipertama"]:checked').val();//$(".polipertama").val()
				//var isi2 = $(".polikedua").val();
				$.post( "get_tarif.php", { jenis: isi })
				  .done(function( data ) {
					$( ".tarif" ).val( data );
					set_total_tarif();
				});
			}else{
				$( ".tarif" ).val("0");
				set_total_tarif();
			}
		});
		
		//default
		if($(".asuransichange").val() == '' || $(".asuransichange").val() == 'GRATIS' || $(".asuransichange").val() == 'BPJS PBI' || $(".asuransichange").val() == 'BPJS PBI APBD' || $(".asuransichange").val() == 'BPJS PBI APBN' || $(".asuransichange").val() == 'BPJS NON PBI' || $(".tarifkarcis_check").prop('checked')==false){
			$( ".tarif" ).val('0');
		}else{
			var isi = $('input[name="polipertama"]:checked').val();//$(".polipertama").val();
			$.post( "get_tarif.php", { jenis: isi })
			  .done(function( data ) {
				$( ".tarif" ).val( data );
			});
		}
		
		$('.polipertama').change(function(){
			if($(".asuransichange").val() == '' || $(".asuransichange").val() == 'GRATIS' || $(".asuransichange").val() == 'BPJS PBI' || $(".asuransichange").val() == 'BPJS PBI APBD' || $(".asuransichange").val() == 'BPJS PBI APBN' || $(".asuransichange").val() == 'BPJS NON PBI' || $(".asuransichange").val() == 'BPJS PBIP' || $(".asuransichange").val() == 'BPJS PBID' || $(".asuransichange").val() == 'BPJS MANDIRI' || $(".asuransichange").val() == 'BPJS PNS/POLRI/TNI' || $(".tarifkarcis_check").prop('checked')==false){
				$( ".tarif" ).val('0');
				set_total_tarif();
			}else{
				var isi =  $('input[name="polipertama"]:checked').val();//$(".polipertama").val();
				$.post( "get_tarif.php", { jenis: isi })
				  .done(function( data ) {
					$( ".tarif" ).val( data );
					set_total_tarif();
				});
			}
		});
			
		$(".kircls").click(function(){
				var isival = $(this).val();
				if ($(this).prop('checked')==true){
					$.post( "get_tarif_kir.php", { kir: isival })
						.done(function( data ) {
							var tarifkir_a = $( ".tarifkir" ).val();
							var tarifkir = parseInt(tarifkir_a) + parseInt(data);
							$( ".tarifkir" ).val(tarifkir);
							set_total_tarif();
					});
				}else{
					$.post( "get_tarif_kir.php", { kir: isival })
						.done(function( data ) {
							var tarifkir_a = $( ".tarifkir" ).val();
							var tarifkir = parseInt(tarifkir_a) - parseInt(data);
							$( ".tarifkir" ).val(tarifkir);
							set_total_tarif();
					});
				}
		});
		
		$(".stsadministrasi").change(function(){
			set_total_tarif();
		});
		
		function set_total_tarif(){
			var adm = $(".stsadministrasi").val();
			var biayaadm;
			if(adm == 'Ya'){
				biayaadm = $(".biayaadministrasi").val();	
			}else{
				biayaadm = 0;	
			}	
			
			$(".tarifadministrasi").val(parseInt(biayaadm));
			$(".totaltarif").val(parseInt($(".tarif").val()) + parseInt($(".tarifkir").val()) + parseInt(biayaadm));
		}
		
		//diagnosa
		$('.diagnosa').autocomplete({
			// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
			serviceUrl: 'get_diagnosa.php',
			// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
			//	$(this).parent().find(".kode").val(suggestion.kode);
			//	$(this).parent().find(".diagnosahidden").val(suggestion.diagnosa);
			}
		});
		
		$(".tambah-diagnosa").click(function(){
			var kode = $(".kode").val();
			var diagnosa = $(".diagnosahidden").val();
			var kasus = $(".kasus").val();
			
			if(diagnosa == ''){
				alert("Diagnosa masih kosong..");
				return false;
			}
			if(kode == ''){
				alert("Diagnosa penyakit tidak valid..");
				return false;
			}
			if(kasus == '--Pilih--'){
				alert("Kasus masih kosong..");
				return false;
			}

			//validasi jika sudah dientry 2x
			var kode_array = valid_kode();
			var tess = jQuery.inArray(kode,kode_array);
			//alert(tess);
			
			if (tess >= 0){
				alert("Diagnosa ini sudah diinputkan...");
				$(".kode").val("");
				$(".diagnosa").val("");
				$(".diagnosahidden").val("");
				$(".kasus").val("--Pilih--");
				return false;
			}
			
			var cl = $(".master-table").clone(); // untuk mengcopy class master-table
			cl.removeAttr("style"); // untuk menghapus style di class master-table
			cl.removeClass("master-table");
			cl.addClass("newbaris");
			// add text html
			cl.find(".kode-html").html(kode); // untuk mengisi tr class kode-html
			cl.find(".diagnosa-html").html(diagnosa);
			cl.find(".kasus-html").html(kasus);
			
			// add value
			var kodeinput = cl.find(".kode-input");
			kodeinput.val(kode);
			
			var diagnosainput = cl.find(".diagnosa-input");
			diagnosainput.attr({name:"diagnosa[]"});
			diagnosainput.val(diagnosa);
			
			var kasusinput = cl.find(".kasus-input");
			kasusinput.val(kasus);
			
			// di create setelah form satu
			$(".head-table").after(cl);
			
				$(".kode").val("");
				$(".diagnosa").val("");
				$(".diagnosahidden").val("");
				$(".kasus").val("--Pilih--");
			
			// fungsi hapus
			$(".hapus-diagnosa").click(function(){
				$(this).parent().parent().remove();
			});	
			
		});						
		
		// diagnosa bpjs
		$('.diagnosabpjs').autocomplete({
			serviceUrl: 'get_diagnosa_bpjs.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(this).parent().find(".kodebpjs").val(suggestion.kode);
				$(this).parent().find(".diagnosahiddenbpjs").val(suggestion.diagnosa);
				$(this).parent().find(".spesialisbpjs").val(suggestion.spesialis);
			}
		});
		
		$('.diagnosabpjsnonspesialis').autocomplete({
			serviceUrl: 'get_diagnosa_bpjs_nonspesialis.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(this).parent().find(".kodebpjs").val(suggestion.kode);
				$(this).parent().find(".diagnosahiddenbpjs").val(suggestion.diagnosa);
				$(this).parent().find(".spesialisbpjs").val(suggestion.spesialis);
			}
		});
		
		$(".tambah-diagnosa-bpjs").click(function(){
			var lokasi = $(".lokasikota").val();
			var kode = $(".kodebpjs").val();
			var diagnosa = $(".diagnosahiddenbpjs").val();
			var kasus = $(".kasusbpjs").val();
			var spesialis = $(".spesialisbpjs").val();
			var kelompok = $(".kelompok").val();
			var kelompokname = $(".kelompok option:selected").text();
			
			if(spesialis == 'true'){
				alert("Diagnosa ini termasuk 155 penyakit tidak boleh dirujuk");
			}
			if(diagnosa == ''){
				alert("Diagnosa masih kosong..");
				return false;
			}
			if(kode == ''){
				alert("Diagnosa penyakit tidak valid..");
				return false;
			}
			if(kasus == ''){
				alert("Kasus masih kosong..");
				return false;
			}
			if(kelompok == ''){
				alert("kelompok masih kosong..");
				return false;
			}
		
			var kelompok_array = func_kelompok_array();
			var cekkelompok = jQuery.inArray(kelompokname,kelompok_array);
			//alert(kelompok);
			if (cekkelompok >= 0){
				alert("kelompok ini sudah ada..");
				return false;
			}
			
			$.post("get_diagnosa_bpjs_rujukan.php")
			  .done(function(data){
			  var obj = jQuery.parseJSON(data);
				var tess = jQuery.inArray(kode,obj);
				//alert(tess);
				if(kode_array.length > 3){
					alert("Diagnosa yang di inputkan max 3");
					return false;
				}
			});
				
			if (tess >= 0){
				alert("Diagnosa ini sudah diinputkan...");
				$(".kodebpjs").val("");
				$(".diagnosabpjs").val("");
				$(".diagnosahiddenbpjs").val("");
				$(".kasusbpjs").val("--Pilih--");
				return false;
			}
			
			var cl = $(".master-table-bpjs").clone(); // untuk mengcopy class master-table
			cl.removeAttr("style"); // untuk menghapus style di class master-table
			cl.removeClass("master-table-bpjs");
			cl.addClass("newbaris");
			
			//count click
			countdgclick = $(".newbaris").length + 1;
			if(countdgclick == '6'){
				alert("Sudah melebihi diagnosa yang boleh diinputkan");
				$(".kodebpjs").val("");
				$(".diagnosabpjs").val("");
				$(".diagnosahiddenbpjs").val("");
				$(".kasusbpjs").val("");
				$(".kelompok").val("");
				return false;
			}
	
			// add text html
			
			cl.find(".kode-html").html(kode); // untuk mengisi tr class kode-html
			cl.find(".diagnosa-html").html(diagnosa);
			cl.find(".kasus-html").html(kasus);
			cl.find(".kelompok-html").html(kelompokname);
			
			// add value
			var kodeinput = cl.find(".kode-diagnosa-input");
			kodeinput.attr({name:"kodediagnosabpjs[]"});
			kodeinput.val(kode);
			
			var namadiagnosainput = cl.find(".nama-diagnosa-input");
			namadiagnosainput.attr({name:"namadiagnosabpjs[]"});
			namadiagnosainput.val(diagnosa);
			
			var kasusdiagnosainput = cl.find(".kasus-diagnosa-input");
			kasusdiagnosainput.attr({name:"kasusdiagnosabpjs[]"});
			kasusdiagnosainput.val(kasus);
			
			var kelompokdiagnosainput = cl.find(".kelompok-diagnosa-input");
			kelompokdiagnosainput.attr({name:"kelompokdiagnosa[]"});
			kelompokdiagnosainput.val(kelompok);
			
			var spesialisdiagnosainput = cl.find(".spesialis-diagnosa-input");
			spesialisdiagnosainput.attr({name:"spesialisdiagnosabpjs[]"});
			spesialisdiagnosainput.val(spesialis);
			
			// di create setelah form satu
			$(".master-table-bpjs").before(cl);
				$(".kodebpjs").val("");
				$(".diagnosabpjs").val("");
				$(".diagnosahiddenbpjs").val("");
				$(".kasusbpjs").val("");
				$(".kelompok").val("");
			
			if(lokasi == 'KOTA BANDUNG' || lokasi == 'KABUPATEN BANDUNG' || lokasi == 'KOTA TARAKAN'){
				var diare1 = 'A09';
				var diare2 = 'A06.0';
				var diare3 = 'A03.0';
				var diare4 = 'A00.9';
				var diare5 = 'K58.0';
				var diare6 = 'K58.9';
			}else{
				var diare1 = 'A08.0';
			}
			
			if(kode == diare1 || kode == diare2 || kode == diare3 || kode == diare4 || kode == diare5 || kode == diare6){
			// if(kode == 'A03.0' || kode == 'A06.0' || kode == 'A09'){
				$.get( "form_diare.php")
				  .done(function( data ) {
					$('.form_tambahan').html(data);
				});
			}else if(kode == 'J00' || kode == 'J02.9' || kode == 'J03.9' || kode == 'J11.0' || kode == 'J15.9' || kode == 'J18.9' || kode == 'J06.0' || kode == 'J04.0' || kode == 'J20.9' || kode == 'J39.8' || kode == 'J39.9'){
			//}else if(kode == 'J18.0' || kode == 'J18.9' || kode == 'J00' || kode == 'J06.9'){
				$.get( "form_ispa.php")
				  .done(function( data ) {
					$('.form_tambahan').html(data);
				});
			}else if(kode == 'B05.9'){
				$.get( "form_campak.php")
				  .done(function( data ) {
					$('.form_tambahan').html(data);
				});
			}else if(kode == 'I10' || kode == 'I23' || kode == 'I64' || kode == 'E14.0' || kode == 'C53.9'){
				$.get( "form_ptm.php")
				  .done(function( data ) {
					$('.form_tambahan').html(data);
				});
			}
			
			// fungsi hapus
			$(".hapus-diagnosa").click(function(){
				$(this).parent().parent().remove();
				var kode = $(this).parent().parent().find('.kode-diagnosa-input').val();
				if(kode == 'A03.0' || kode == 'A06.0' || kode == 'A09' || kode == 'J18.0' || kode == 'J18.9' || kode == 'J00' || kode == 'J06.9' || kode == 'B05.9' || kode == 'I10' || kode == 'I23' || kode == 'I64' || kode == 'E14.0' || kode == 'C53.9'){
					$('.form_tambahan').html("");
				}
			});
			
			
			var kode_array = kode_array_diagnosabpjs();
			var tess = jQuery.inArray(kode,kode_array);
			if (tess >= 0){
				alert ("Diagnosa termasuk 155 penyakit tidak boleh dirujuk");
			}
		});	
		
		$(".hapus-diagnosa-edit").click(function(){
			$(this).parent().parent().remove();
		});
		
		function valid_kode(){
			var yourArray = [];
			$( ".kode-input" ).each(function( index, element) {
				yourArray.push($(this).val());
			});
			return yourArray;
		}
		
		function func_kelompok_array(){
			var yourArray = [];
			$( ".newbaris" ).each(function( index, element) {
				yourArray.push($(this).find('.kelompok-html').html());
			});
			return yourArray;
		}
		
		function valid_kode_bpjs(){
			var yourArray = [];
			$( ".kode-diagnosa-input" ).each(function( index, element) {
				yourArray.push($(this).val());
			});
		return yourArray;
		}
		
		
		function valid_kode_barang(){
			var yourArray = [];
			$( ".kodebarang-input" ).each(function( index, element) {
				yourArray.push($(this).val());
			});
		return yourArray;
		}
		
		//therapy BPJS
		// $('.therapybpjs').autocomplete({
			// serviceUrl: 'get_therapy.php?keyword=',
			// onSelect: function (suggestion) {
				// $(this).val(suggestion.value);
				// $(this).parent().find(".kodeobatbpjs").val(suggestion.kodeobatbpjs);
				// $(this).parent().find(".kodeobatlokal").val(suggestion.kodeobatlokal);
				// $(this).parent().find(".nobatch").val(suggestion.nobatch);
				// $(this).parent().find(".namaobatbpjs").val(suggestion.namaobatbpjs);
				// $(this).parent().find(".sediaobatbpjs").val(suggestion.sediaobatbpjs);
			// }
		// });
		
		function valid_nama_barang_bpjs(){
			var yourArray = [];
			$( ".namaobatbpjs-input" ).each(function( index, element) {
				yourArray.push($(this).val());
			});
		return yourArray;
		}
		
		$(".anjuranterapi").change(function(){
			if($(this).val() == 'Lainnya'){
				$(".formanjuranlainnya").show();
			}else{
				$(".formanjuranlainnya").hide();
			}
		});
		
		$(".tambah-therapy-bpjs").click(function(){
			var sediaobatbpjs = $(".sediaobatbpjs").val();
			var jumlahbpjs = $(".jumlahbpjs").val();
			var dosisbpjs1 = $(".dosisbpjs1").val();
			var dosisbpjs2 = $(".dosisbpjs2").val();
			var kodeobatlokal = $(".kodeobatlokal").val();
			var nobatch = $(".nobatch").val();						
			var anjuranterapi = $(".anjuranterapi").val();
			var anjuranterapilainnya = $(".anjuranterapilain").val();
			var status_racikan_bpjs = $('.status_racikan_bpjs').val();

			if(anjuranterapi == 'Lainnya'){
				anjuranterapi = anjuranterapilainnya;
			}	
			var noregistrasiclass = $(".noregistrasiclass").val();
			var ket_racikan = $(".ket_racikan").val();
			if(ket_racikan != ''){
				ket_racikan = ", Ket: "+ket_racikan;
			}

			if(status_racikan_bpjs == 'true'){
				anjuranterapi = ket_racikan;
			}
			
			//cek kode obat di terapidetail
			$.post( "cek_namaobatsama_resepdetail.php", { kodeobatlokal: kodeobatlokal, nobatch: nobatch, noregistrasiclass:noregistrasiclass })
			  .done(function( data ) {
				if(data > 0){
					alert("therapy ini sudah diinputkan di poli sebelumnya...");
				}
			});
			
			if(parseInt(sediaobatbpjs) < parseInt(jumlahbpjs)){
				alert("Jumlah obat harus lebih kecil dari stok...");
				$(".jumlahbpjs").val("");
				return false;
			}
			
			// if(parseInt(jumlahbpjs) == ""){
			if($(".jumlahbpjs").val() == ''){
				alert("Jumlah tidak boleh kosong...");
				$(".jumlahbpjs").val("1");
				return false;
			}
			
			if($(".jumlahbpjs").val() == '0'){
				alert("Jumlah tidak boleh kosong...");
				$(".jumlahbpjs").val("1");
				return false;
			}

			if(anjuranterapi == ''){
				alert("Anjuran tidak boleh kosong...");
				$(".anjuranterapi").val("");
				return false;
			}			
			
			
			// alert(status_racikan_bpjs);
			if($(".namaobatbpjs").val() == ''){
				var namaobatbpjs = $(".therapybpjs").val();
				var kodeobatbpjs = "NDPHO";
			}else{
				var namaobatbpjs = $(".namaobatbpjs").val();
				var kodeobatbpjs = $(".kodeobatbpjs").val();
			}
		
			
			//if(namaobatbpjs == ''){
			if($(".namaobatbpjs").val() == ''){
				alert("Nama obat tidak ditemukan didatabase, jangan diketik manual...");
				return false;
			}
			
			var kode_array = valid_nama_barang_bpjs();
			var tess = jQuery.inArray(namaobatbpjs,kode_array);
			if (tess >= 0){
				alert("therapy ini sudah diinputkan...");
				$(".therapybpjs").val("");
				$(".kodeobatlokal").val("");
				$(".nobatch").val("");
				$(".kodeobatbpjs").val("");
				$(".namaobatbpjs").val("");
				$(".jumlahbpjs").val("");
				$(".dosisbpjs1").val("");
				$(".dosisbpjs2").val("");
				$(".anjuranterapi").val("-");
				$(".anjuranterapilain").val("");
				$(".ket_racikan").val("");
				return false;
			}
			
			var cl = $(".master-table-therapy-bpjs").clone(); // untuk mengcopy class master-table
			cl.removeAttr("style"); // untuk menghapus style di class master-table
			cl.removeClass("master-table-therapy-bpjs");
			cl.addClass("newbaristherapybpjs");

			var status_racikan_bpjs2;	
			if(status_racikan_bpjs == 'true'){
				status_racikan_bpjs2 = 'Ya';
			}else{
				status_racikan_bpjs2 = 'Tidak';
			}
			// add text html
			cl.find(".kodeobatlokal-html").html(kodeobatlokal); // untuk mengisi tr class kode-html						
			cl.find(".nobatch-html").html(nobatch); 
			cl.find(".status_racikan_bpjs-html").html(status_racikan_bpjs2);
			cl.find(".namaobatbpjs-html").html(namaobatbpjs+""+ket_racikan);
			cl.find(".jumlahbpjs-html").html(jumlahbpjs);
			cl.find(".anjuranterapi-html").html(anjuranterapi);
			if(dosisbpjs1 == "" && dosisbpjs2 == ""){
				cl.find(".dosisbpjs-html").html(dosisbpjs1 +" - "+dosisbpjs2);
			}else{
				cl.find(".dosisbpjs-html").html(dosisbpjs1 +" X "+dosisbpjs2);
			}
			
			
			// add value
			var kodebaranginput = cl.find(".kodeobatbpjs-input");
			kodebaranginput.attr({name:"kodeobatbpjs[]"});//untuk post di proses
			kodebaranginput.val(kodeobatbpjs);
			
			var kodebaranginput2 = cl.find(".kodeobatlokal-input");
			kodebaranginput2.attr({name:"kodeobatlokal[]"});//untuk post di proses
			kodebaranginput2.val(kodeobatlokal);
			
			var nobatchinput = cl.find(".nobatch-input");
			nobatchinput.attr({name:"nobatch[]"});//untuk post di proses
			nobatchinput.val(nobatch);
			
			var tstatus_racikan_bpjs = cl.find(".status_racikan_bpjs-input");
			tstatus_racikan_bpjs.attr({name:"status_racikan_bpjs[]"});//untuk post di proses
			tstatus_racikan_bpjs.val(status_racikan_bpjs);
			
			var namabaranginput = cl.find(".namaobatbpjs-input");
			namabaranginput.attr({name:"namaobatbpjs[]"});//untuk post di proses
			namabaranginput.val($(".namaobatbpjs").val());
			
			var namaobatnonbpjs = cl.find(".namaobatnonbpjs-input");
			namaobatnonbpjs.attr({name:"namaobatnonbpjs[]"});//untuk post di proses
			namaobatnonbpjs.val($(".therapybpjs").val());
			
			var jumlahinput = cl.find(".jumlahbpjs-input");
			jumlahinput.attr({name:"jumlahbpjs[]"});//untuk post di proses
			jumlahinput.val(jumlahbpjs);
			
			var dosisinput = cl.find(".dosisbpjs1-input");
			dosisinput.attr({name:"dosisbpjs1[]"});//untuk post di proses
			dosisinput.val(dosisbpjs1);
			
			var dosisinput = cl.find(".dosisbpjs2-input");
			dosisinput.attr({name:"dosisbpjs2[]"});//untuk post di proses
			dosisinput.val(dosisbpjs2);
			
			var anjuraninput = cl.find(".anjuranterapi-input");
			anjuraninput.attr({name:"anjuranterapi[]"});//untuk post di proses
			anjuraninput.val(anjuranterapi);

			var ket_racikaninput = cl.find(".ket_racikan-input");
			ket_racikaninput.attr({name:"ket_racikan[]"});//untuk post di proses
			ket_racikaninput.val(ket_racikan);
			
			// di create setelah form satu
			$(".head-table-therapy-bpjs").after(cl);
			$(".therapybpjs").val("");
			$(".kodeobatlokal").val("");
			$(".nobatch").val("");
			$(".kodeobatbpjs").val("");
			$(".namaobatbpjs").val("");
			$(".jumlahbpjs").val("");
			$(".dosisbpjs1").val("");
			$(".dosisbpjs2").val("");
			//$(".anjuranterapi").val("-");
			$(".anjuranterapilain").val("");
			$(".ket_racikan").val("");
			
			//mengisi catatan therapi
			var catatanterapibpjs = $(this).parent().parent().parent().find(".catatan-therapy-bpjs");
			if(catatanterapibpjs.val() == ''){
				var isicatatanterapibpjs = namaobatbpjs;
			}else{
				var isicatatanterapibpjs = catatanterapibpjs.val()+', '+namaobatbpjs;
			}
			catatanterapibpjs.val(isicatatanterapibpjs);
			$(".formanjuranlainnya").hide();
			
			// fungsi hapus
			$(".hapus-therapy-bpjs").click(function(){
				$(this).parent().parent().remove();

				set_obatlist();
			});

			set_obatlist();
		});
		
		$(".hapus-therapy-bpjs").click(function(){
			var kodeobatlokal = $(this).parent().parent().find(".kodeobatlokal-input").val();
			var kodeobat2 = $(this).parent().parent().find(".kodeobatskbpjs-input").val();
			var nobatch = $(this).parent().parent().find(".nobatch-input").val();
			//lokal
			var kodeobatlokal2 = kodeobatlokal+"|"+nobatch;

			var kd = $(".hapusobat").val();
			if(kd == ''){
				kodeobatinput = kodeobatlokal2
			}else{
				kodeobatinput = kd+','+kodeobatlokal2
			}
			$(".hapusobat").val(kodeobatinput);
			
			//bpjs
			var kd2 = $(".hapusobatbpjs").val();
			if(kd2 == ''){
				kodeobatinput2 = kodeobat2
			}else{
				kodeobatinput2 = kd2+','+kodeobat2
			}
			$(".hapusobatbpjs").val(kodeobatinput2);
			
			$(this).parent().parent().remove();

			set_obatlist();
		});
		
		function set_obatlist(){
			let text = '';
			var yourArray = [];
			$( ".namaobatbpjs-html" ).each(function( index, element){
				if($(this).text() != ''){
					var dosis = $(this).parent().find(".dosisbpjs-html").text();
					var jmlh = $(this).parent().find(".jumlahbpjs-html").text();
					var nmobat = $(this).text()+", dosis: "+dosis+", jml:"+jmlh;
					
					yourArray.push(nmobat);
				}							
			});

			text = yourArray.join(", ");
			$(".terapiobat_planing").val(text);
		}
		
		function valid_nama_tindakan_bpjs(){
			var yourArray = [];
			$( ".namatindakanbpjs-input" ).each(function( index, element){
				yourArray.push($(this).val());
			});
		return yourArray;
		}
		
		$(".tambah-tindakan-bpjs").click(function(){
			var idtindakanbpjs = $(".idtindakanbpjs").val();
			var namatindakanbpjs = $(".namatindakanbpjs").val();
			var tariftindakanbpjs = $(".tariftindakanbpjs").val();
			var keteranganbpjs = $(".keteranganbpjs").val();
			
			if(idtindakanbpjs == ''){
				alert("Kode Tindakan masih kosong..");
				return false;
			}
			if(namatindakanbpjs == ''){
				alert("Nama Tindakan tidak valid..");
				return false;
			}
			if(tariftindakanbpjs == ''){
				alert("Tarif masih kosong..");
				return false;
			}
			
			// validasi jika sudah dientry 2x
			var kode_array = valid_nama_tindakan_bpjs();
			var tess = jQuery.inArray(idtindakanbpjs,kode_array);
			// alert(tess);
			
			if (tess >= 0){
				alert("Tindakan ini sudah diinputkan...");
				$(".idtindakanbpjs").val("");
				$(".namatindakanbpjs").val("");
				$(".tariftindakanbpjs").val("");
				$(".keteranganbpjs").val("");
				return false;
			}
			
			var cl = $(".master-table-tindakan-bpjs").clone(); // untuk mengcopy class master-table
			cl.removeAttr("style"); // untuk menghapus style di class master-table
			cl.removeClass("master-table-tindakan-bpjs");
			cl.addClass("newbaristindakanbpjs");
			
			// add text html
			cl.find(".idtindakanbpjs-html").html(idtindakanbpjs); // untuk mengisi tr class kode-html
			cl.find(".namatindakanbpjs-html").html(namatindakanbpjs);
			cl.find(".tariftindakanbpjs-html").html(tariftindakanbpjs);
			cl.find(".keteranganbpjs-html").html(keteranganbpjs);
			
			// add value
			var idtindakaninput = cl.find(".idtindakanbpjs-input");
			idtindakaninput.attr({name:"idtindakanbpjs[]"});//untuk post di proses
			idtindakaninput.val(idtindakanbpjs);
									
			var namatindakaninput = cl.find(".namatindakanbpjs-input");
			namatindakaninput.attr({name:"namatindakanbpjs[]"});//untuk post di proses
			namatindakaninput.val(namatindakanbpjs);
									
			var tariftindakaninput = cl.find(".tariftindakanbpjs-input");
			tariftindakaninput.attr({name:"tariftindakanbpjs[]"});//untuk post di proses
			tariftindakaninput.val($(".tariftindakanbpjs").val());
			
			var keteranganbpjsinput = cl.find(".keteranganbpjs-input");
			keteranganbpjsinput.attr({name:"keteranganbpjs[]"});//untuk post di proses
			keteranganbpjsinput.val($(".keteranganbpjs").val());
			
			// di create setelah form satu
			$(".head-table-tindakan-bpjs").after(cl);
			$(".idtindakanbpjs").val("");
			$(".namatindakanbpjs").val("");
			$(".tariftindakanbpjs").val("");
			$(".keteranganbpjs").val("");
			$(".tindakanbpjs").val("");
		
			// fungsi hapus
			$(".hapus-tindakan-bpjs").click(function(){
				$(this).parent().parent().remove();
			});
		});
		
		$(".hapus-tindakan-bpjs").click(function(){
			var kodetindakan = $(this).parent().parent().find(".kodetindakanbpjsSK-input").val();
			var kd = $(".hapustindakanbpjs").val();
			if(kd == ''){
				kodetindakaninput = kodetindakan
			}else{
				kodetindakaninput = kd+','+kodetindakan
			}
			$(".hapustindakanbpjs").val(kodetindakaninput);
			$(this).parent().parent().remove();
		});
		
		
		$(".tambah-gudang-besar-penerimaan").click(function(){
			var barcode = $(".barcode").val();
			var kodebarang = $(".kodebarang").val();
			var namabarang = $(".namabaranghidden").val();
			var satuan = $(".satuan").val();
			var nobatch = $(".nobatch").val();
			var expire = $(".expire").val();
			var harga = $(".harga").val();
			var jumlah_stok = $(".jumlahstokhidden").val();
			var jumlah = $(".jumlah").val();
			var subtotal = jumlah * harga;
			
			// di create setelah form satu
			var cl = $(".master-table-gudang-besar-penerimaan").clone(); // untuk mengcopy class master-table
			cl.removeAttr("style"); // untuk menghapus style di class master-table
			cl.removeClass("master-table-gudang-besar-penerimaan");
			
			// add text html---> masuk kedatagrid
			cl.find(".barcode-html").html(barcode);
			cl.find(".kodebarang-html").html(kodebarang);
			cl.find(".namabarang-html").html(namabarang);
			cl.find(".satuan-html").html(satuan);
			cl.find(".batch-html").html(nobatch);
			cl.find(".expire-html").html(expire);
			cl.find(".harga-html").html(harga);
			cl.find(".jumlah-html").html(jumlah);
			cl.find(".subtotal-html").html(subtotal);
			
			var barcodeinput = cl.find(".barcode-input");
			barcodeinput.attr({name:"barcodes[]"});//untuk post di proses
			barcodeinput.val(barcode);
			
			var kodebaranginput = cl.find(".kodebarang-input");
			kodebaranginput.attr({name:"kodebarangs[]"});//untuk post di proses
			kodebaranginput.val(kodebarang);
			
			var nobatchinput = cl.find(".nobatch-input");
			nobatchinput.attr({name:"nobatchs[]"});//untuk post di proses
			nobatchinput.val(nobatch);
			
			var expireinput = cl.find(".expire-input");
			expireinput.attr({name:"expires[]"});//untuk post di proses
			expireinput.val(expire);
			
			var hargainput = cl.find(".harga-input");
			hargainput.attr({name:"hargas[]"});//untuk post di proses
			hargainput.val(harga);
			
			var jumlahinput = cl.find(".jumlah-input");
			jumlahinput.attr({name:"jumlahs[]"});//untuk post di proses
			jumlahinput.val(jumlah);
			
			var subtotalinput = cl.find(".subtotal-input");
			subtotalinput.attr({name:"subtotals[]"});//untuk post di proses
			subtotalinput.val(subtotal);
			
			$(".barcode").val("");
			$(".kodebarang").val("");
			$(".nama_barang_gudang_besar").val("");
			$(".nama_barang_gudang_pelayanan").val("");
			$(".namabaranghidden").val("");
			$(".jumlahstokhidden").val("");
			$(".namaobat_go").val("");
			$(".satuan").val("");
			$(".nobatch").val("");
			$(".expire").val("");
			$(".harga").val("");
			$(".jumlah").val("");
			
			$(".hapus-gudang-besar-penerimaan").click(function(){
				$(this).parent().parent().remove();
			});						

			$(".head-table-gudang-besar-penerimaan").after(cl);
		});
		
		$(".tambah-gudang-besar-pengeluaran").click(function(){
			var barcode = $(".barcode").val();
			var kodebarang = $(".kodebarang").val();
			var namabarang = $(".namabaranghidden").val();
			var satuan = $(".satuan").val();
			var nobatch = $(".nobatch").val();
			var expire = $(".expire").val();
			var hargabeli = $(".hargabeli").val();
			var jumlah_stok = $(".jumlahstokhidden").val();
			var jumlah = $(".jumlah").val();
			var subtotal = jumlah * hargabeli;
			
			var cek_jumlah = jumlah_stok - jumlah;
			if(cek_jumlah < 0){
				alert("maaf tidak bisa");
				return false;
			}
		
			// di create setelah form satu
			var cl = $(".master-table-gudang-besar-pengeluaran").clone(); // untuk mengcopy class master-table
			cl.removeAttr("style"); // untuk menghapus style di class master-table
			cl.removeClass("master-table-gudang-besar-pengeluaran");
			
			// add text html---> masuk kedatagrid
			cl.find(".barcode-html").html(barcode);
			cl.find(".kodebarang-html").html(kodebarang);
			cl.find(".namabarang-html").html(namabarang);
			cl.find(".satuan-html").html(satuan);
			cl.find(".batch-html").html(nobatch);
			cl.find(".expire-html").html(expire);
			cl.find(".hargabeli-html").html(hargabeli);
			cl.find(".jumlah-html").html(jumlah);
			cl.find(".subtotal-html").html(subtotal);
			
			var barcodeinput = cl.find(".barcode-input");
			barcodeinput.attr({name:"barcodes[]"});//untuk post di proses
			barcodeinput.val(barcode);
			
			var kodebaranginput = cl.find(".kodebarang-input");
			kodebaranginput.attr({name:"kodebarangs[]"});//untuk post di proses
			kodebaranginput.val(kodebarang);
			
			var nobatchinput = cl.find(".nobatch-input");
			nobatchinput.attr({name:"nobatchs[]"});//untuk post di proses
			nobatchinput.val(nobatch);
			
			var expireinput = cl.find(".expire-input");
			expireinput.attr({name:"expires[]"});//untuk post di proses
			expireinput.val(expire);
			
			var hargainput = cl.find(".hargabeli-input");
			hargainput.attr({name:"hargas[]"});//untuk post di proses
			hargainput.val(hargabeli);
			
			var jumlahinput = cl.find(".jumlah-input");
			jumlahinput.attr({name:"jumlahs[]"});//untuk post di proses
			jumlahinput.val(jumlah);
			
			var subtotalinput = cl.find(".subtotal-input");
			subtotalinput.attr({name:"subtotals[]"});//untuk post di proses
			subtotalinput.val(subtotal);
			
			$(".head-table-gudang-besar-pengeluaran").after(cl);
			$(".barcode").val("");
			$(".kodebarang").val("");
			$(".nama_barang_gudang_besar").val("");
			$(".namabaranghidden").val("");
			$(".jumlahstokhidden").val("");
			$(".namaobat_go").val("");
			$(".satuan").val("");
			$(".nobatch").val("");
			$(".expire").val("");
			$(".hargabeli").val("");
			$(".jumlah").val("");
			
			$(".hapus-gb-pengeluaran").click(function(){
				$(this).parent().parent().remove();
			});		
		});
		
		$(".tambah-gudang-pelayanan-pengeluaran").click(function(){
			var barcode = $(".barcode").val();
			var kodebarang = $(".kodebarang").val();
			var namabarang = $(".namabarang").val();
			var satuan = $(".satuan").val();
			var nobatch = $(".nobatch").val();
			var expire = $(".expire").val();
			var hargabeli = $(".hargabeli").val();
			var jumlah_stok = $(".stok").val();
			var jumlah = $(".jumlah").val();
			var subtotal = jumlah * hargabeli;
			
			var cek_jumlah = jumlah_stok - jumlah;
			if(cek_jumlah < 0){
				alert("maaf tidak bisa");
				return false;
			}
		
			// di create setelah form satu
			var cl = $(".master-table-gudang-pelayanan-pengeluaran").clone();
			cl.removeAttr("style"); 
			cl.removeClass("master-table-gudang-pelayanan-pengeluaran");
			cl.addClass("newbarispengeluaran_gp");
			
			// add text html---> masuk kedatagrid
			cl.find(".barcode-html").html(barcode);
			cl.find(".kodebarang-html").html(kodebarang);
			cl.find(".namabarang-html").html(namabarang);
			cl.find(".satuan-html").html(satuan);
			cl.find(".batch-html").html(nobatch);
			cl.find(".expire-html").html(expire);
			cl.find(".hargabeli-html").html(hargabeli);
			cl.find(".jumlah-html").html(jumlah);
			cl.find(".subtotal-html").html(subtotal);
			
			// add value
			var barcodeinput = cl.find(".barcode-input");
			barcodeinput.attr({name:"barcodes[]"});//untuk post di proses
			barcodeinput.val(barcode);
			
			var kodebaranginput = cl.find(".kodebarang-input");
			kodebaranginput.attr({name:"kodebarangs[]"});//untuk post di proses
			kodebaranginput.val(kodebarang);
			
			var nobatchinput = cl.find(".nobatch-input");
			nobatchinput.attr({name:"nobatchs[]"});//untuk post di proses
			nobatchinput.val(nobatch);
			
			var expireinput = cl.find(".expire-input");
			expireinput.attr({name:"expires[]"});//untuk post di proses
			expireinput.val(expire);
			
			var hargainput = cl.find(".hargabeli-input");
			hargainput.attr({name:"hargas[]"});//untuk post di proses
			hargainput.val(hargabeli);
			
			var jumlahinput = cl.find(".jumlah-input");
			jumlahinput.attr({name:"jumlahs[]"});//untuk post di proses
			jumlahinput.val(jumlah);
			
			var subtotalinput = cl.find(".subtotal-input");
			subtotalinput.attr({name:"subtotals[]"});//untuk post di proses
			subtotalinput.val(subtotal);
			
			// di create setelah form satu
			$(".head-table-gudang-pelayanan-pengeluaran").after(cl);
			$(".barcode").val("");
			$(".kodebarang").val("");
			$(".nama_barang_gudang_pelayanan").val("");
			$(".namabarang").val("");
			$(".stok").val("");
			$(".namaobat_go").val("");
			$(".satuan").val("");
			$(".nobatch").val("");
			$(".expire").val("");
			$(".hargabeli").val("");
			$(".jumlah").val("");
			
			// fungsi hapus
			$(".hapus-gp-pengeluaran").click(function(){
				$(this).parent().parent().remove();
			});	
		});
		
		$('.puskesmas').autocomplete({
			serviceUrl: 'get_puskesmas.php?keyword=',
			onSelect: function (suggestion){
				$(this).val(suggestion.value);
				$(".kodepuskesmas").val(suggestion.kodepuskesmas);
				$(".puskesmas").val(puskesmas.kota);
			}
		});
		
		$('.pegawai').autocomplete({
			serviceUrl: 'get_pegawai.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
			}
		});
		$('.pegawaipuskesmas').autocomplete({
			serviceUrl: 'get_pegawai_puskesmas.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
			}
		});
		$('.pegawaifarmasi').autocomplete({
			serviceUrl: 'get_pegawai_farmasi.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
			}
		});
		$('.penerimabarang').autocomplete({
			serviceUrl: 'get_penerima.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
			}
		});
		//form stok gudang puskesmas
		$('.namaobat_gop').autocomplete({
			serviceUrl: 'get_namaobat_gop.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namabarang);
				$(".kodebarang").val(suggestion.kodebarang);
				$(".barcode").val(suggestion.barcode);
				$(".kodebaranginn").val(suggestion.kodebaranginn);
				$(".namabaranginn").val(suggestion.namabaranginn);
				$(".kekuatan").val(suggestion.kekuatan);
				$(".sediaan").val(suggestion.sediaan);
				$(".golongan").val(suggestion.golongan);
				$(".detailkemasan").val(suggestion.detailkemasan);
				$(".kemasan").val(suggestion.kemasan);
				$(".isikemasan").val(suggestion.isikemasan);
				$(".jenisbarangelog").val(suggestion.jenisbarangelog);
				$(".statusapproveelog").val(suggestion.statusapproveelog);
				$(".satuan").val(suggestion.satuan);
				$(".kelastherapy").val(suggestion.kelastherapy);
				$(".golonganfungsi").val(suggestion.golonganfungsi);
				$(".jenisbarang").val(suggestion.jenisbarang);
				$(".ruangan").val(suggestion.ruangan);
				$(".rak").val(suggestion.rak);
				$(".stok").val(suggestion.stok);
				$(".minimalstok").val(suggestion.minimalstok);
				$(".hargabeli").val(suggestion.hargabeli);
				$(".nobatch").val(suggestion.nobatch);
				$(".expire").val(suggestion.expire);
				$(".sumberanggaran").val(suggestion.sumberanggaran);
				$(".tahunanggaran").val(suggestion.tahunanggaran);
				$(".supplier").val(suggestion.supplier);
				$(".keterangan").val(suggestion.keterangan);
				$(".namalengkap").val(suggestion.namalengkap);
				
				$(this).parent().find(".namabaranghidden").val(suggestion.namabarang);
				$(this).parent().find(".jumlahstokhidden").val(suggestion.stok);
			}
		});
		
		$('.nama_barang_gudang_besar_stok').autocomplete({
			serviceUrl: 'get_namabarang_gudangbesar_stok.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namabarang);
				$(".kodebarang").val(suggestion.kodebarang);
				$(".barcode").val(suggestion.barcode);
				$(".kodebaranginn").val(suggestion.kodebaranginn);
				$(".namabaranginn").val(suggestion.namabaranginn);
				$(".kekuatan").val(suggestion.kekuatan);
				$(".sediaan").val(suggestion.sediaan);
				$(".golongan").val(suggestion.golongan);
				$(".detailkemasan").val(suggestion.detailkemasan);
				$(".kemasan").val(suggestion.kemasan);
				$(".isikemasan").val(suggestion.isikemasan);
				$(".jenisbarangelog").val(suggestion.jenisbarangelog);
				$(".statusapproveelog").val(suggestion.statusapproveelog);
				$(".satuan").val(suggestion.satuan);
				$(".kelastherapy").val(suggestion.kelastherapy);
				$(".golonganfungsi").val(suggestion.golonganfungsi);
				$(".jenisbarang").val(suggestion.jenisbarang);
				$(".ruangan").val(suggestion.ruangan);
				$(".rak").val(suggestion.rak);
				$(".stok").val(suggestion.stok);
				$(".minimalstok").val(suggestion.minimalstok);
				$(".hargabeli").val(suggestion.hargabeli);
				$(".nobatch").val(suggestion.nobatch);
				$(".expire").val(suggestion.expire);
				$(".sumberanggaran").val(suggestion.sumberanggaran);
				$(".tahunanggaran").val(suggestion.tahunanggaran);
				$(".supplier").val(suggestion.supplier);
				$(".keterangan").val(suggestion.keterangan);
				$(".namalengkap").val(suggestion.namalengkap);
				
				$(this).parent().find(".namabaranghidden").val(suggestion.namabarang);
				$(this).parent().find(".jumlahstokhidden").val(suggestion.stok);
			}
		});
		
		$('.nama_barang_elogistik').autocomplete({
			serviceUrl: 'get_namabarang_elogistik.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namabarang);
				$(".kodebarang_elog").val(suggestion.kodebarangelog);
				$(".nama_produsen").val(suggestion.produsen);
				$(".nama_inn").val(suggestion.namagenerik);
			}
		});
		
		$('.nama_barang_pornas').autocomplete({
			serviceUrl: 'get_namabarang_pornas.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namaobat);
			}
		});
		
		$('.nama_barang_lplpo').autocomplete({
			serviceUrl: 'get_namabarang_lplpo.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namaobat);
				$(".kodeobat").val(suggestion.kodeobat);
				$(".isikemasanobat").val(suggestion.isikemasanobat);
				$(".kemasanobat").val(suggestion.kemasanobat);
				$(".satuanobat").val(suggestion.satuanobat);
				$(".idindikatorobat").val(suggestion.idindikatorobat);
				$(".idketersediaanobat").val(suggestion.idketersediaanobat);
				$(".namaprogramobat").val(suggestion.namaprogramobat);
				$(".golonganfungsiobat").val(suggestion.golonganfungsiobat);
				$(".jenisbarangobat").val(suggestion.jenisbarangobat);
				$(".minimalstokobat").val(suggestion.minimalstokobat);
				$(".barcodeobat").val(suggestion.barcodeobat);
			}
		});
		
		$('.nama_barang_vaksin').autocomplete({
			serviceUrl: 'get_namabarang_vaksin.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namavaksin);
				$(".kodevaksin").val(suggestion.kodevaksin);
			}
		});
		
		$('.nama_barang_vaksin_group').autocomplete({
			serviceUrl: 'get_namabarang_vaksin_group.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namavaksin);
				$(".kodevaksin").val(suggestion.kodevaksin);
			}
		});
		
		$('.nama_barang_gudang_besar_stok_bpjs').autocomplete({
			serviceUrl: 'get_namabarang_gudangbesar_stok_bpjs.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(".kodebarangbpjs").val(suggestion.kodebarang);
			}
		});
							
		$('.nama_barang_gudang_vaksin').autocomplete({
			serviceUrl: 'get_namabarang_gudangvaksin.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namabarang);
				$(".jumlah").focus();
				$(".kodebarang").val(suggestion.kodebarang);
				$(".namabarang").val(suggestion.namabarang);
				$(".barcode").val(suggestion.barcode);
				$(".kemasan").val(suggestion.kemasan);
				$(".isikemasan").val(suggestion.isikemasan);
				$(".satuan").val(suggestion.satuan);
				$(".kelastherapy").val(suggestion.kelastherapy);
				$(".golonganfungsi").val(suggestion.golonganfungsi);
				$(".program").val(suggestion.program);
				$(".jenisbarang").val(suggestion.jenisbarang);
				$(".ruangan").val(suggestion.ruangan);
				$(".rak").val(suggestion.rak);
				$(".stok").val(suggestion.stok);
				$(".minimalstok").val(suggestion.minimalstok);
				$(".hargabeli").val(suggestion.hargabeli);
				$(".nobatch").val(suggestion.nobatch);
				$(".expire").val(suggestion.expire);
				$(".sumberanggaran").val(suggestion.sumberanggaran);
				$(".tahunanggaran").val(suggestion.tahunanggaran);
				$(".supplier").val(suggestion.supplier);
				$(".keterangan").val(suggestion.keterangan);
				$(".tglpenerimaan").val(suggestion.tglpenerimaan);
				$(".nofakturterima").val(suggestion.nofakturterima);
				// $(this).parent().find(".namabaranghidden").val(suggestion.namabarang);
				// $(this).parent().find(".jumlahstokhidden").val(suggestion.stok);
			}
		});
		
		$('.nama_barang_gudang_vaksin_semua').autocomplete({
			serviceUrl: 'get_namabarang_gudangvaksin_semua.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(".jumlah").focus();
				$(".kodebarang").val(suggestion.kodebarang);
				$(".barcode").val(suggestion.barcode);
				$(".kemasan").val(suggestion.kemasan);
				$(".isikemasan").val(suggestion.isikemasan);
				$(".satuan").val(suggestion.satuan);
				$(".kelastherapy").val(suggestion.kelastherapy);
				$(".golonganfungsi").val(suggestion.golonganfungsi);
				$(".program").val(suggestion.program);
				$(".jenisbarang").val(suggestion.jenisbarang);
				$(".ruangan").val(suggestion.ruangan);
				$(".rak").val(suggestion.rak);
				$(".stok").val(suggestion.stok);
				$(".minimalstok").val(suggestion.minimalstok);
				$(".hargabeli").val(suggestion.hargabeli);
				$(".nobatch").val(suggestion.nobatch);
				$(".expire").val(suggestion.expire);
				$(".sumberanggaran").val(suggestion.sumberanggaran);
				$(".tahunanggaran").val(suggestion.tahunanggaran);
				$(".supplier").val(suggestion.supplier);
				$(".keterangan").val(suggestion.keterangan);
				$(".nofakturterima").val(suggestion.nofakturterima);
				$(this).val(suggestion.value);
				$(this).parent().find(".namabaranghidden").val(suggestion.namabarang);
				$(this).parent().find(".jumlahstokhidden").val(suggestion.stok);
			}
		});
		
												
		$('.nama_barang_mutasi_awal').autocomplete({
			serviceUrl: 'get_namabarang_gudangbesar_mutasi_awal.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namabarang);
				$(".kodebarang_awal").val(suggestion.kodebarang);
				$(".namaprogram_awal").val(suggestion.namaprogram);
				$(".nobatch_awal").val(suggestion.nobatch);
				$(".nofaktur_awal").val(suggestion.nofakturterima);
			}
		});
		
		$('.nama_barang_mutasi_akhir').autocomplete({
			serviceUrl: 'get_namabarang_gudangbesar_mutasi_akhir.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namabarang);
				$(".kodebarang_akhir").val(suggestion.kodebarang);
				$(".namaprogram_akhir").val(suggestion.namaprogram);
				$(".nobatch_akhir").val(suggestion.nobatch);
				$(".nofaktur_akhir").val(suggestion.nofakturterima);
			}
		});
		
		$('.nama_barang_gudang_besar_retur').autocomplete({
			serviceUrl: 'get_namabarang_gudangbesar_retur.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(".jumlah").focus();
				$(".kodebarang").val(suggestion.kodebarang);
				$(".barcode").val(suggestion.barcode);
				$(".kemasan").val(suggestion.kemasan);
				$(".isikemasan").val(suggestion.isikemasan);
				$(".satuan").val(suggestion.satuan);
				$(".kelastherapy").val(suggestion.kelastherapy);
				$(".golonganfungsi").val(suggestion.golonganfungsi);
				$(".program").val(suggestion.program);
				$(".jenisbarang").val(suggestion.jenisbarang);
				$(".ruangan").val(suggestion.ruangan);
				$(".rak").val(suggestion.rak);
				$(".stok").val(suggestion.stok);
				$(".minimalstok").val(suggestion.minimalstok);
				$(".hargabeli").val(suggestion.hargabeli);
				$(".nobatch").val(suggestion.nobatch);
				$(".expire").val(suggestion.expire);
				$(".sumberanggaran").val(suggestion.sumberanggaran);
				$(".tahunanggaran").val(suggestion.tahunanggaran);
				$(".supplier").val(suggestion.supplier);
				$(".keterangan").val(suggestion.keterangan);
				$(this).val(suggestion.value);
				$(this).parent().find(".namabaranghidden").val(suggestion.namabarang);
				$(this).parent().find(".jumlahstokhidden").val(suggestion.stok);
			}
		});
							
		$('.nama_barang_gudang_pelayanan').autocomplete({
			serviceUrl: 'get_namabarang_gudangpelayanan.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namabarang);
				$(".kodebarang").val(suggestion.kodebarang);
				$(".barcode").val(suggestion.barcode);
				$(".kemasan").val(suggestion.kemasan);
				$(".isikemasan").val(suggestion.isikemasan);
				$(".satuan").val(suggestion.satuan);
				$(".kelastherapy").val(suggestion.kelastherapy);
				$(".golonganfungsi").val(suggestion.golonganfungsi);
				$(".programs").val(suggestion.programs);
				$(".jenisbarang").val(suggestion.jenisbarang);
				$(".ruangan").val(suggestion.ruangan);
				$(".rak").val(suggestion.rak);
				$(".stok").val(suggestion.stok);
				$(".minimalstok").val(suggestion.minimalstok);
				$(".hargabeli").val(suggestion.hargabeli);
				$(".nobatch").val(suggestion.nobatch);
				$(".expire").val(suggestion.expire);
				$(".sumberanggaran").val(suggestion.sumberanggaran);
				$(".tahunanggaran").val(suggestion.tahunanggaran);
				$(".supplier").val(suggestion.supplier);
				$(".keterangan").val(suggestion.keterangan);
				$(this).val(suggestion.namabarang);
				$(this).parent().find(".namabarang").val(suggestion.namabarang);
				$(this).parent().find(".stok").val(suggestion.stok);
			}
		});
		
		$('.nama_barang_gudang_besar_penerimaan').autocomplete({
			serviceUrl: 'get_namabarang_gudangbesar_penerimaan.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(".kodebarang").val(suggestion.kodebarang);
				$(".barcode").val(suggestion.barcode);
				$(".kemasan").val(suggestion.kemasan);
				$(".isikemasan").val(suggestion.isikemasan);
				$(".satuan").val(suggestion.satuan);
				$(".kelastherapy").val(suggestion.kelastherapy);
				$(".golonganfungsi").val(suggestion.golonganfungsi);
				$(".jenisbarang").val(suggestion.jenisbarang);
				$(".ruangan").val(suggestion.ruangan);
				$(".rak").val(suggestion.rak);
				$(".stok").val(suggestion.stok);
				$(".minimalstok").val(suggestion.minimalstok);
				$(".hargabeli").val(suggestion.hargabeli);
				$(".nobatch").val(suggestion.nobatch);
				$(".expire").val(suggestion.expire);
				$(".sumberanggaran").val(suggestion.sumberanggaran);
				$(".tahunanggaran").val(suggestion.tahunanggaran);
				$(".supplier").val(suggestion.supplier);
				$(".keterangan").val(suggestion.keterangan);
				$(this).val(suggestion.value);
				$(this).parent().find(".namabarang").val(suggestion.namabarang);
				$(this).parent().find(".stok").val(suggestion.stok);
			}
		});
		
		//ini dihapus aja karena kartu stok gudang besar pakai fungsi nama_barang_lplpo 
		$('.nama_barang_kartu_stok').autocomplete({
			serviceUrl: 'get_namabarang_kartu_stok_gp.php',
			onSearchStart: function (){
				$(this).autocomplete('setOptions', { params: { filter: $('.groups').val() } });
			},
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(this).parent().find(".kodebarang").val(suggestion.kodebarang);
				$(this).parent().find(".namabarang").val(suggestion.namabarang);
			}
		});
		
		$('.nama_barang_gudang_puskesmas_pengadaan').autocomplete({
			serviceUrl: 'get_nama_barang_gudang_puskesmas_pengadaan.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namabarang);
				$(".kodebarang").val(suggestion.kodebarang);
				$(".satuan").val(suggestion.satuan);
			}
		});
		
		$('.nama_barang_gudang_puskesmas_retur').autocomplete({
			serviceUrl: 'get_nama_barang_gudang_puskesmas_pengadaan.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namabarang);
				$(".kodebarang").val(suggestion.kodebarang);
			}
		});
		
		$('.nama_barang_aset').autocomplete({
			serviceUrl: 'get_nama_barang_aset.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namabarang);
				$(".idbarang").val(suggestion.idbarang);
				$(".namabarang").val(suggestion.namabarang);
				$(".satuan").val(suggestion.satuan);
				$(".kelompok").val(suggestion.kelompok);
			}
		});
		
		$('.nama_barang_distribusi_aset').autocomplete({
			serviceUrl: 'get_nama_barang_distribusi_aset.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namabarang);
				$(".idbarang").val(suggestion.idbarang);
				$(".namabarang").val(suggestion.namabarang);
				$(".satuan").val(suggestion.satuan);
				$(".stok").val(suggestion.stok);
			}
		});
		
		$('.nama_barang_gudang_puskesmas_penerimaan_mandiri').autocomplete({
			serviceUrl: 'get_nama_barang_gudang_puskesmas_penerimaan_mandiri.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namabarang);
				$(".namabarang").val(suggestion.namabarang);
				$(".kodebarang").val(suggestion.kodebarang);
				$(".satuan").val(suggestion.satuan);
			}
		});
		
		$('.nama_barang_gudang_uptd_pengadaan').autocomplete({
			serviceUrl: 'get_nama_barang_gudang_uptd_pengadaan.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namabarang);
				$(".kodebarang").val(suggestion.kodebarang);
				$(".barcode").val(suggestion.barcode);
				$(".kemasan").val(suggestion.kemasan);
				$(".isikemasan").val(suggestion.isikemasan);
				$(".satuan").val(suggestion.satuan);
				$(".kelastherapy").val(suggestion.kelastherapy);
				$(".golonganfungsi").val(suggestion.golonganfungsi);
				$(".jenisbarang").val(suggestion.jenisbarang);
				$(".ruangan").val(suggestion.ruangan);
				$(".rak").val(suggestion.rak);
				$(".stok").val(suggestion.stok);
				$(".minimalstok").val(suggestion.minimalstok);
				$(".hargabeli").val(suggestion.hargabeli);
				$(".nobatch").val(suggestion.nobatch);
				$(".expire").val(suggestion.expire);
				$(".sumberanggaran").val(suggestion.sumberanggaran);
				$(".tahunanggaran").val(suggestion.tahunanggaran);
				$(".supplier").val(suggestion.supplier);
				$(".keterangan").val(suggestion.keterangan);
				
				$(this).parent().find(".namabarang").val(suggestion.namabarang);
				$(this).parent().find(".stok").val(suggestion.stok);
			}
		});
		
		$('.nama_barang_gudang_puskesmas_pengeluaran').autocomplete({
		serviceUrl: 'get_nama_barang_gudang_puskesmas_pengeluaran.php?keyword=',
		onSelect: function (suggestion) {
				$(this).val(suggestion.namabarang);
				$(".idbrggudangpkm").val(suggestion.idbrggudangpkm);
				$(".kodebarang").val(suggestion.kodebarang);
				$(".namabarang").val(suggestion.namabarang);
				$(".satuan").val(suggestion.satuan);
				$(".nobatch").val(suggestion.nobatch);
				$(".expire").val(suggestion.expire);
				$(".hargasatuan").val(suggestion.hargasatuan);
				$(".sumberanggaran").val(suggestion.sumberanggaran);
				$(".tahunanggaran").val(suggestion.tahunanggaran);
				$(".stok").val(suggestion.stok);
				$(".jumlah").focus();
			}
		});
		
		$('.nama_barang_gudang_vaksin_puskesmas_pengeluaran').autocomplete({
			serviceUrl: 'get_nama_barang_gudang_vaksin_puskesmas_pengeluaran.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namabarang);
				$(".idbrggudangpkm").val(suggestion.idbrggudangpkm);
				$(".kodebarang").val(suggestion.kodebarang);
				$(".namabarang").val(suggestion.namabarang);
				$(".satuan").val(suggestion.satuan);
				$(".expire").val(suggestion.expire);
				$(".hargasatuan").val(suggestion.hargasatuan);
				$(".sumberanggaran").val(suggestion.sumberanggaran);
				$(".tahunanggaran").val(suggestion.tahunanggaran);
				$(".nobatch").val(suggestion.nobatch);
				$(".stok").val(suggestion.stok);
			}
		});
							
		$('.nama_barang_gudang_puskesmas').autocomplete({
			serviceUrl: 'get_nama_barang_gudang_puskesmas.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.namabarang);
				$(".kodebarang").val(suggestion.kodebarang);
				$(".barcode").val(suggestion.barcode);
				$(".kemasan").val(suggestion.kemasan);
				$(".isikemasan").val(suggestion.isikemasan);
				$(".satuan").val(suggestion.satuan);
				$(".kelastherapy").val(suggestion.kelastherapy);
				$(".golonganfungsi").val(suggestion.golonganfungsi);
				$(".jenisbarang").val(suggestion.jenisbarang);
				$(".ruangan").val(suggestion.ruangan);
				$(".rak").val(suggestion.rak);
				$(".stok").val(suggestion.stok);
				$(".minimalstok").val(suggestion.minimalstok);
				$(".hargabeli").val(suggestion.hargabeli);
				$(".nobatch").val(suggestion.nobatch);
				$(".expire").val(suggestion.expire);
				$(".sumberanggaran").val(suggestion.sumberanggaran);
				$(".tahunanggaran").val(suggestion.tahunanggaran);
				$(".supplier").val(suggestion.supplier);
				$(".keterangan").val(suggestion.keterangan);
				
				$(this).parent().find(".namabarang").val(suggestion.namabarang);
				$(this).parent().find(".stok").val(suggestion.stok);
			}
		});
		
		$('.namabaranginn').autocomplete({
			serviceUrl: 'get_namabarang_inn.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(".kodebaranginn").val(suggestion.kodebaranginn);
				// $(".namabaranginn").val(suggestion.namabaranginn);
			}
		});
		
		$('.sediaan').autocomplete({
			serviceUrl: 'get_sediaan.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(".kodebarang").val(suggestion.kodebarang);
				//$(".jenis_sediaan").val(suggestion.jenis_sediaan);
				//$(this).parent().find(".idhidden").val(suggestion.id);
				//$(this).parent().find(".jenis_sediaanhidden").val(suggestion.jenis_sediaan);
			}
		});
		
		$('.nama_supplier').autocomplete({
			serviceUrl: 'get_supplier.php',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(".kodesupplier").val(suggestion.kodesupplier);
				$(".supplier").val(suggestion.supplier);
				$(".alamat").val(suggestion.alamat);
				$(".telpon").val(suggestion.telpon);
			}
		});
		
		$('.nama_produsen').autocomplete({
			serviceUrl: 'get_produsen.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.nama_prod_obat);
				$(".id").val(suggestion.id);
				$(".nama_prod_obat").val(suggestion.nama_prod_obat);
			}
		});
		
		// $('.nama_barang_gudang_puskesmas_penerimaan_mandiri').autocomplete({
			// serviceUrl: 'get_nama_barang_gudang_puskesmas_penerimaan_mandiri.php?keyword=',
			// onSelect: function (suggestion) {
				// $(this).val(suggestion.namabarang);
				// $(".namabarang").val(suggestion.namabarang);
				// $(".kodebarang").val(suggestion.kodebarang);
				// $(".satuan").val(suggestion.satuan);
			// }
		// });
		
		$('.nama_pbf').autocomplete({
			serviceUrl: 'get_pbf.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(".idpbf").val(suggestion.idpbf);
				$(".pbf").val(suggestion.pbf);
			}
		});
		
		$('.nama_provinsi').autocomplete({
			serviceUrl: 'get_provinsi.php?keyword=',
			onSelect: function (suggestion){
				$(this).val(suggestion.value);
				$(".kodeprovinsi").val(suggestion.kodeprovinsi);
				//$(this).parent().find(".KodeProvinsi").val(suggestion.KodeProvinsi);
			}
		});
		
		$('.nama_kota').autocomplete({
			serviceUrl: 'get_kota.php?keyword=',
			onSelect: function (suggestion){
				$(this).val(suggestion.value);
				$(".kodekota").val(suggestion.kodekota);
				$(".kota").val(suggestion.kota);
				//$(this).parent().find(".kota").val(suggestion.kota);
			}
		});
		
		$('.nama_kecamatan').autocomplete({
			serviceUrl: 'get_kecamatan.php?keyword=',
			onSelect: function (suggestion){
				$(this).val(suggestion.value);
				$(".kodekecamatan").val(suggestion.kodekecamatan);
				//$(this).parent().find(".kodekecamatan").val(suggestion.kodekecamatan);
			}
		});
		
		$('.nama_kelurahan').autocomplete({
			serviceUrl: 'get_kelurahan.php?keyword=',
			onSelect: function (suggestion){
				$(this).val(suggestion.value);
				$(".kode").val(suggestion.kode);
				$(".koderm").val(suggestion.koderm);
				$(".kelurahan").val(suggestion.kelurahan);
				// $(this).parent().find(".kode").val(suggestion.kode);
				//$(this).parent().find(".kelurahan").val(suggestion.kelurahan);
			}
		});
		
		$(".statuspengeluaran").change(function(){
			var isi = $(this).val();
			var lokasi = $(".lokasikota").val();
			if(isi == 'DALAM GEDUNG'){
				$(".penerima").html('<option value="LOKET OBAT">DEPOT OBAT</option><option value="POLI ANAK">POLI ANAK</option><option value="POLI GIGI">POLI GIGI</option><option value="POLI JIWA">POLI JIWA</option><option value="POLI KIA">POLI KIA</option><option value="POLI KUSTA">POLI KUSTA</option><option value="POLI LANSIA">POLI LANSIA</option><option value="POLI TB">POLI TB</option><option value="POLI UMUM">POLI UMUM</option><option value="LABORATORIUM">LABORATORIUM</option><option value="IGD">IGD</option><option value="PONED">PONED</option><option value="RAWAT INAP">RAWAT INAP</option>');
			}else if(isi == 'LUAR GEDUNG'){
				if(lokasi == 'KABUPATEN BOGOR'){
					$(".penerima").html('<option value="PUSTU">PUSTU</option><option value="PUSLING">PUSLING</option><option value="LAINNYA">LAINNYA</option>');
				}else{
					$(".penerima").html('<option value="POLINDES">POLINDES</option><option value="POSBINDU">POSBINDU</option><option value="POSKESDES">POSKESDES</option><option value="POSYANDU">POSYANDU</option><option value="PUSTU">PUSTU</option><option value="PUSLING">PUSLING</option><option value="LAYAD RAWAT">LAYAD RAWAT</option><option value="LAINNYA">LAINNYA</option><option value="UKS">UKS</option>');
				}	
			}else if(isi == 'PROGRAM'){
				$(".penerima").html('<option value="DIARE">DIARE</option><option value="FILARIASIS">FILARIASIS</option><option value="GIZI">GIZI</option><option value="HEPATITIS">HEPATITIS</option><option value="HIV">HIV</option><option value="IMUNISASI">IMUNISASI</option><option value="JIWA">JIWA</option><option value="KUSTA">KUSTA</option><option value="PTM">PTM</option>');
			}else{
				$(".penerima").html('<option value="-">--Pilih--</option>');
			}
		});
		
		$(".statuspengeluaran_gb").change(function(){
			var isi = $(this).val();
			if(isi == 'DEPO FARMASI'){
				$(".penerima_gb").html('<select name="penerima" class="form-control penerimacls"><option value="DEPO FARMASI">DEPO FARMASI</option></select>');
			}else if(isi == 'PUSKESMAS'){
				$.post( "get_puskesmas_gb.php")
				  .done(function( data ) {
					$(".penerima_gb").html(data);
				});		
			}else if(isi == 'RUMAH SAKIT'){
				$.post( "get_rumahsakit.php")
				  .done(function( data ) {
					$(".penerima_gb").html(data);
				});		
			}else if(isi == 'SENTRA VAKSINASI'){
				$(".penerima_gb").html('<select name="penerima" class="form-control penerimacls"><option value="DEPO FARMASI">SENTRA VAKSINASI</option></select>');	
			}else if(isi == 'LAINNYA'){
				$(".penerima_gb").html('<input type="text" class="form-control penerimacls" name="penerima" style="text-transform: uppercase;" value="">');
			}else{
				$(".penerima_gb").html('<select name="penerima" class="form-control penerimacls"><option value="GUDANG PELAYANAN">GUDANG PELAYANAN</option></select>');
			}
		});
		$(".statuspengeluaran_gp").change(function(){
			var isi = $(this).val();
			if(isi == 'PUSKESMAS'){
				$.post( "get_puskesmas_gb.php")
				  .done(function( data ) {
					$(".penerima_gp").html(data);
				});						
			}else if(isi == 'LAINNYA'){
				$(".penerima_gp").html('<input type="text" class="form-control" name="penerima" value="-">');
			}else{
				$(".penerima_gp").html('<select name="penerima" class="form-control"><option value="">--Pilih--</option><option value="GUDANG PELAYANAN">GUDANG PELAYANAN</option></select>');
			}
		});
		
		// pertanyaan???
		$(".statuskunjunganpoli").change(function(){
			var isi = $(this).val();
			var sts = '';
			if(isi == 'true'){
				sts = 'true';
			}else{
				sts = 'false';
			}
			$.get( "get_poli.php?sts="+sts)
				.done(function( data ) {
				$(".polipertama").html(data);

				if($(".tarifkarcis_check").prop('checked')==true){
					var isi =  $('input[name="polipertama"]:checked').val();//$(".polipertama").val();
					$.post( "get_tarif.php", { jenis: isi })
					.done(function( data ) {
						$( ".tarif" ).val( data );
						set_total_tarif();
					});
				}else{
					$( ".tarif" ).val("0");
					set_total_tarif();
				}
				
			});
		});

		$('.tarifkarcis_check').click(function(){
			if($(".tarifkarcis_check").prop('checked')==true){
				var isi =  $('input[name="polipertama"]:checked').val();//$(".polipertama").val()
				//var isi2 = $(".polikedua").val();
				$.post( "get_tarif.php", { jenis: isi })
				  .done(function( data ) {
					$( ".tarif" ).val( data );
					set_total_tarif();
				});
			}else{
				$( ".tarif" ).val("0");
				set_total_tarif();
			}
		});
		
		
		$(".statuspulang").change(function(){
			var isi = $(this).val();
			if(isi == '4'){
			var jaminan = $(".asuransicls").val();
			var nokunjunganbpjs = $(".nokunjunganbpjs").val();
			
			console.log('nokun: '+nokunjunganbpjs);
			function statusspesialis(){
				var yourArray = [];
				$( ".spesialis-diagnosa-input" ).each(function( index, element) {
					yourArray.push($(this).val());
				});
				return yourArray;
			}
			var tess = jQuery.inArray('true',statusspesialis());
			if (tess >= 0){
				var statusspesialis2 = 'true';
			}else{
				var statusspesialis2 = 'false';
			}
			//rujuk lanjut
				$.post( "get_rujuk_lanjut.php", { sts: statusspesialis2, jaminan: jaminan, nokunjunganbpjs: nokunjunganbpjs }) 
				  .done(function( data ) {
					$(".statuspulangform").html(data);
				});	
			
			}else if(isi == '5'){
			//rujuk internal
			var pelayanan = $(".getpelayanan").val();
			var idpsnrj = $(".idpsnrj").val();
			
				$.post( "get_rujuk_internal.php",{ pelayanan: pelayanan, idpsnrj:idpsnrj})
				  .done(function( data ) {
					$(".statuspulangform").html(data);
				});	
			
			}else{
				$(".statuspulangform").html('');
			}
		});	
		
		$(".kategori_bulan").change(function(){
			var isi = $(this).val();
			if(isi == 'TanggalPengeluaran'){
				$(".isi_bulan").html("<div class='row'><div class='col-sm-4'><select class='form-control' name='key'><option value='01'>Januari</option><option value='02'>Februari</option><option value='03'>Maret</option><option value='04'>April</option><option value='05'>Mei</option><option value='06'>Juni</option><option value='07'>Juli</option><option value='08'>Agustus</option><option value='09'>September</option><option value='10'>Oktober</option><option value='11'>November</option><option value='12'>Desember</option></select></div><div class='col-sm-2'><select class='form-control' name='keytahun'><option value='2019'>2019</option><option value='2020'>2020</option><option value='2021'>2021</option><option value='2022'>2022</option><option value='2023'>2023</option><option value='2024'>2024</option></select></div></div>");
			}else{
				$(".isi_bulan").html("<input type='text' name='key' class='form-control' required>");
			}
		});
		
		$('#myModaldiagnosa').modal('hide');
		
		$(".modalkamusdiagnosa").click(function(){
			$('#myModaldiagnosa').modal('show');
			$('#myModaldiagnosa').find('.diagnosa').val("");
		});
		
		$(".namapasienkkinsert").hide();
		$(".statuskeluargapilih").change(function(){
			var isi = $(this).val();
			if(isi == 'KEPALA KELUARGA'){
				$(".nikkkinsert").show();
				$(".namapasienkkinsert").hide();
			}else{
				$(".namapasienkkinsert").show();
			}
		});
		
		$.post( "get_poli_sakit_bpjs.php")
		  .done(function( data ) {
			$(".poli_bpjs").html(data);
		});	
		
		$(".kunjungan").change(function(){
			var isi = $(this).val();
			
			if(isi == 'true'){
				$.post( "get_poli_sakit_bpjs.php")
				  .done(function( data ) {
					$(".poli_bpjs").html(data);
				});	
			}else{
				$.post( "get_poli_sehat_bpjs.php")
				  .done(function( data ) {
					$(".poli_bpjs").html(data);
				});	
			}
		});
		
		
		
		$(".btn-dp-pb-e-bi").click(function(){
			var cek = $( ".pasien_belum_entri_bi" ).text();
			if(cek == ''){
				$( ".pasien_belum_entri_bi" ).html("<img src='assets/js/loader.gif' width='20%'/>");
				$( ".pasien_belum_entri_bi" ).load( "pasien_belum_entri_bi.php" );
			}else{
				$( ".pasien_belum_entri_bi" ).html();
			}
		});
		
		$(".btn-dp-pb-e-bl").click(function(){
			var cek = $( ".pasien_belum_entri_bl" ).text();
			if(cek == ''){
				$( ".pasien_belum_entri_bl" ).html("<img src='assets/js/loader.gif' width='20%'/>");
				$( ".pasien_belum_entri_bl" ).load( "pasien_belum_entri_bl.php" );
			}else{
				$( ".pasien_belum_entri_bl" ).html();
			}
		});
		
		$(".polipertama").change(function(){
			if($(this).val() == $(".polikedua").val()){
				alert("Poli tidak boleh sama");
				$(this).val('');
			}
		});
		
		$(".polikedua").change(function(){
			if($(this).val() == $(".polipertama").val()){
				alert("Poli tidak boleh sama");
				$(this).val('');
			}
		});
		
		$(".asuransikkinsert").change(function(){
			if($(this).val() == 'UMUM'){
				$(".stsasuransukkinsert").val('PESERTA');
				$(".noasuransikkinsert").val('0');
			}else{
				$(".stsasuransukkinsert").val('');
				$(".noasuransikkinsert").val('');
			}
		});
	
		$(".btnsubmitbpjs").click(function(){
			if($(".asuransichange").val() == ''){
				$(".registrasitab").click();
			}
		});
		
		$(".tglpengeluarangb").change(function(){
			var tgl =$(this).val();
			var lokasinofaktur = $(this).parent().parent().parent().parent().find(".nofaturgb");
			
			$.post( "get_nofakturgb.php", { tgl: tgl })
			  .done(function( data ) {
				 lokasinofaktur.val( data );
			});
		});
		
		$(".tahun_exp").change(function(){
			var isi = $(this).val();
			if(isi == 'Expire'){
				$(".key").val("Expire");
			}
		});
		

		
	});		