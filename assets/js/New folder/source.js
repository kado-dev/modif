			$(document).ready(function() {
				
				$(".simpankkjquery").click(function(){
					var alamatkk = $(this).parent().parent().parent().find(".alamatkk").val();
					var namakk = $(this).parent().parent().parent().find(".namakk").val();
					var nama_kelurahan = $(this).parent().parent().parent().find(".nama_kelurahan").val();
					
					if(namakk == '' || alamatkk == '' || nama_kelurahan == ''){
						alert("Nama dan alamat harus diisi.");
						return false;
					}
					var namapasien = $(this).parent().find(".namapasienjquery").val();
					var nik = $(this).parent().find(".nik").val();
					var tgllahir = $(this).parent().find(".tgllahir").val();
					var jeniskelamin = $(this).parent().find(".jeniskelamin").val();
					var asuransi = $(this).parent().find(".asuransi").val();
					var statusasuransi = $(this).parent().find(".statusasuransi").val();
					var noasuransi = $(this).parent().find(".noasuransi").val();
					var kdprovider = $(this).parent().find(".kdprovider").val();
					
					$.post( "kk_insert_proses_lanjutan.php", { 
						namakk: namakk,
						alamat: alamatkk,
						nama_kelurahan: nama_kelurahan,
						namapasien: namapasien, 
						nik: nik,
						tgllahir: tgllahir,
						jeniskelamin: jeniskelamin,
						asuransi: asuransi,
						statusasuransi: statusasuransi,
						noasuransi: noasuransi,
						kdprovider: kdprovider,
					}).done(function( data ) {
						var obj = jQuery.parseJSON(data);
						$(".tablekkinsert").html(obj.keterangan);
						$(".noindexjquery").html(obj.noindex);
						$(".trbtnsimpankk").remove();
						
						//$(this).parent().parent().parent().html(data);
					});
					
				});
				
				$(".btnmodalinsertkk").click(function(){
					$(".tablekkinsert").removeAttr("style");
				});
				
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
					
					$( ".form-control" ).bind('keypress', function(e) {
						var code = e.keyCode || e.which;
						 if(code == 13) { //Enter keycode
						   return false;
						 }
					});
					
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
						if(isi == 'TanggalRegistrasi'){
							$(this).parent().parent().parent().find(".key").val("");
							$(this).parent().parent().parent().find(".key").datepicker({format: 'yyyy-mm-dd',});
						}else{
							$(this).parent().parent().parent().find(".key").datepicker("destroy");
							$(this).parent().parent().parent().find(".key").val("");
						}
					});
						var isi = $(".katdatareg").val();
						if(isi == 'TanggalRegistrasi'){
							$(".key").datepicker({format: 'yyyy-mm-dd',});
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
						//alert(noresep);
						$.post( "get_modal_apotik.php", { no: noresep })
						  .done(function( data ) {
							 $( ".hasilmodal" ).html( data );
							 $('#Modalobat').modal('show');
						});
						
					});
					
					
					$('.btnmodalpuskesmas').click(function(){
							 $('#modalpuskesmas').modal('show');
						});
						
					$('.btnmodalpuskesmasedit').click(function(){
						var kodepuskesmas = $(this).parent().parent().find(".kodepuskesmas").html()
						//alert(kodepuskesmas);
						$.post( "get_modal_puskesmas.php", { id: kodepuskesmas })
						  .done(function( data ) {
							 $( ".hasilmodal" ).html( data );
							 $('#modaleditpuskesmas').modal('show');
						});					
						
					});
					
					$('.btnmodalpegawai').click(function(){
						$('#modalpegawai').modal('show');
					});	
					
					$('.btnmodalpegawaiedit').click(function(){
						var nip = $(this).parent().parent().find(".nip").html()
						//alert(nip);
						$.post( "get_modal_pegawai.php", { id: nip })
						  .done(function( data ) {
							 $( ".hasilmodal" ).html( data );
							 $('#modaleditpegawai').modal('show');
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
					
					$('.btnmodalkartupasien').click(function(){
						var nocm = $(this).parent().parent().find(".nocm").html()
						//alert(noindex);//nocm
						$.post( "get_modal_kartupasien.php", { id: nocm })
						  .done(function( data ) {
							 $( ".hasilmodal" ).html( data );
							 $('#modalkartupasien').modal('show');
						});	
					});
					
					$('.modal_pasienrj').click(function(){
						var noreg = $(this).parent().parent().find(".noreg").html()
						$.post( "get_modal_pasienrj.php", { id: noreg })
						  .done(function( data ) {
							 $( ".hasilmodal" ).html( data );
							 $('#modalkartupasien').modal('show');
						});	
					});
					
					
					
					if($(".asuransi").val() != 'UMUM'){
						$( ".tarif" ).val("0");
					}
					
					$('.asuransichange').change(function(){
					
						if($(this).val() == 'UMUM'){
						
							var isi = $(".polipertama").val()
							$.post( "get_tarif.php", { jenis: isi })
							  .done(function( data ) {
								$( ".tarif" ).val( data );
							});
						}else{
							$( ".tarif" ).val("0");
						}
					});
					
					//default
					if($(".asuransichange").val() == 'GRATIS' || $(".asuransichange").val() == 'BPJS PBI' || $(".asuransichange").val() == 'BPJS NON PBI'){
						$( ".tarif" ).val("0");
					}else{
					var isi = $(".polipertama").val();
						$.post( "get_tarif.php", { jenis: isi })
						  .done(function( data ) {
							$( ".tarif" ).val( data );
						});
					}
					
					$('.polipertama').change(function(){
						if($(".asuransichange").val() == 'GRATIS' || $(".asuransichange").val() == 'BPJS PBI' || $(".asuransichange").val() == 'BPJS NON PBI'){
							$( ".tarif" ).val("0");
						}else{
							var isi = $(this).val()
							$.post( "get_tarif.php", { jenis: isi })
							  .done(function( data ) {
								$( ".tarif" ).val( data );
							});
						}
					});
					
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
					
					//diagnosa bpjs
					$('.diagnosabpjs').autocomplete({
						serviceUrl: 'get_diagnosa_bpjs.php',
						onSelect: function (suggestion) {
							$(this).val(suggestion.value);
							$(this).parent().find(".kodebpjs").val(suggestion.kode);
							$(this).parent().find(".diagnosahiddenbpjs").val(suggestion.diagnosa);
							$(this).parent().find(".spesialisbpjs").val(suggestion.spesialis);
						}
					});

					
					$(".tambah-diagnosa-bpjs").click(function(){
						var kode = $(".kodebpjs").val();
						var diagnosa = $(".diagnosahiddenbpjs").val();
						var kasus = $(".kasusbpjs").val();
						var spesialis = $(".spesialisbpjs").val();
						
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
						if(kasus == '--Pilih--'){
							alert("Kasus masih kosong..");
							return false;
						}
						
							$.post( "get_diagnosa_bpjs_rujukan.php")
							  .done(function( data ) {
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
						// add text html
						
						cl.find(".kode-html").html(kode); // untuk mengisi tr class kode-html
						cl.find(".diagnosa-html").html(diagnosa);
						cl.find(".kasus-html").html(kasus);
						
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
						
						// di create setelah form satu
						$(".head-table-bpjs").after(cl);
							$(".kodebpjs").val("");
							$(".diagnosabpjs").val("");
							$(".diagnosahiddenbpjs").val("");
							$(".kasusbpjs").val("--Pilih--");
						
						if(kode == 'A03.0' || kode == 'A06.0' || kode == 'A09'){
							$('#formdiarehidden').removeClass('hidden');
							$('.ket_formdiarehidden').val('123');
						}else if(kode == 'J18.0' || kode == 'J18.9'){
							$('#formispahidden').removeClass('hidden');
							$('.ket_formispahidden').val('123');
						}else if(kode == 'B05.9'){
							$('#formcampakhidden').removeClass('hidden');
							$('.ket_formcampakhidden').val('123');
						}
						
						// fungsi hapus
						$(".hapus-diagnosa").click(function(){
							$(this).parent().parent().remove();
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
					
					//therapy
					/*
					$('.therapy').autocomplete({
						serviceUrl: 'get_obat.php/<?php echo $_SESSION['kodepuskesmas'];?>/<?php echo $_GET['status'];?>',
						onSelect: function (suggestion) {
							$(this).val(suggestion.value);
							$(this).parent().find(".kodebarang").val(suggestion.kodebarang);
							$(this).parent().find(".namabarang").val(suggestion.namabarang);
						}
					});
					
					$(".tambah-therapy").click(function(){
						var kodebarang = $(".kodebarang").val();
						var namabarang = $(".namabarang").val();
						var jumlah = $(".jumlah").val();
						var keterangan = $(".keterangan").val();
						var dosis = $(".dosis").val();
						var puyer = $(".puyer").val();
						
						if(kodebarang == ''){
							alert("Nama Barang tidak valid..");
							return false;
						}
						if(namabarang == ''){
							alert("Nama Barang masih kosong..");
							return false;
						}
						if(jumlah == ''){
							alert("Jumlah masih kosong..");
							return false;
						}

						//validasi jika sudah dientry 2x
						var kode_array = valid_kode_barang();
						var tess = jQuery.inArray(kodebarang,kode_array);
						
						if (tess >= 0){
							alert("therapy ini sudah diinputkan...");
							$(".therapy").val("");
							$(".kodebarang").val("");
							$(".namabarang").val("");
							$(".jumlah").val("");
							$(".dosis").val("");
							$(".keterangan").val("");
							$(".puyer").val("");
							return false;
						}
						
						var cl = $(".master-table-therapy").clone(); // untuk mengcopy class master-table
						cl.removeAttr("style"); // untuk menghapus style di class master-table
						cl.removeClass("master-table-therapy");
						cl.addClass("newbaristherapy");
						
						// add text html
						cl.find(".kodebarang-html").html(kodebarang); // untuk mengisi tr class kode-html
						cl.find(".namabarang-html").html(namabarang);
						cl.find(".jumlah-html").html(jumlah);
						cl.find(".dosis-html").html(dosis);
						cl.find(".keterangan-html").html(keterangan);
						cl.find(".puyer-html").html(puyer);
						
						// add value
						var kodebaranginput = cl.find(".kodebarang-input");
						kodebaranginput.attr({name:"kodebarang[]"});//untuk post di proses
						kodebaranginput.val(kodebarang);
						
						var namabaranginput = cl.find(".namabarang-input");
						namabaranginput.attr({name:"therapy[]"});//untuk post di proses
						namabaranginput.val(namabarang);
						
						var jumlahinput = cl.find(".jumlah-input");
						jumlahinput.attr({name:"jumlah[]"});//untuk post di proses
						jumlahinput.val(jumlah);
						
						var dosisinput = cl.find(".dosis-input");
						dosisinput.attr({name:"dosis[]"});//untuk post di proses
						dosisinput.val(dosis);
						
						var keteranganinput = cl.find(".keterangan-input");
						keteranganinput.attr({name:"keterangan[]"});//untuk post di proses
						keteranganinput.val(keterangan);
						
						var puyerinput = cl.find(".puyer-input");
						puyerinput.attr({name:"puyer[]"});//untuk post di proses
						puyerinput.val(puyer);
						
						// di create setelah form satu
						$(".head-table-therapy").after(cl);
						$(".therapy").val("");
						$(".kodebarang").val("");
						$(".namabarang").val("");
						$(".jumlah").val("");
						$(".dosis").val("");
						$(".keterangan").val("");
						$(".puyer").val("");
						
						//mengisi catatan therapi
						var catatanterapi = $(this).parent().parent().parent().find(".catatan-therapy");
						if(catatanterapi.val() == ''){
							var isicatatanterapi = namabarang;
						}else{
							var isicatatanterapi = catatanterapi.val()+', '+namabarang;
						}
						catatanterapi.val(isicatatanterapi);
						
						$(".hapus-therapy").click(function(){
							$(this).parent().parent().remove();
							
						});	
					});	
					
					$(".hapus-therapy-edit").click(function(){
							$(this).parent().parent().remove();
					});	
					**/
					
					//therapy BPJS
					$('.therapybpjs').autocomplete({
						serviceUrl: 'get_therapy.php',
						onSelect: function (suggestion) {
							$(this).val(suggestion.value);
							$(this).parent().find(".kodeobatbpjs").val(suggestion.kodeobatbpjs);
							$(this).parent().find(".kodeobatlokal").val(suggestion.kodeobatlokal);
							$(this).parent().find(".namaobatbpjs").val(suggestion.namaobatbpjs);
							$(this).parent().find(".sediaobatbpjs").val(suggestion.sediaobatbpjs);
						}
					});
					
					function valid_nama_barang_bpjs(){
						var yourArray = [];
						$( ".namaobatbpjs-input" ).each(function( index, element) {
							yourArray.push($(this).val());
						});
					return yourArray;
					}
					
					
					$(".tambah-therapy-bpjs").click(function(){
						var jumlahbpjs = $(".jumlahbpjs").val();
						var dosisbpjs1 = $(".dosisbpjs1").val();
						var dosisbpjs2 = $(".dosisbpjs2").val();
						var kodeobatlokal = $(".kodeobatlokal").val();
						
						var status_racikan_bpjs = $('input[name=status_racikan]:checked').val();
						// alert(status_racikan_bpjs);
						if($(".namaobatbpjs").val() == ''){
							var namaobatbpjs = $(".therapybpjs").val();
							var kodeobatbpjs = "NDPHO";
						}else{
							var namaobatbpjs = $(".namaobatbpjs").val();
							var kodeobatbpjs = $(".kodeobatbpjs").val();
						}
						
						if(namaobatbpjs == ''){
							alert("Nama Obat masih kosong..");
							return false;
						}
					
						
						var kode_array = valid_nama_barang_bpjs();
						var tess = jQuery.inArray(namaobatbpjs,kode_array);
						if (tess >= 0){
							alert("therapy ini sudah diinputkan...");
							$(".therapybpjs").val("");
							$(".kodeobatbpjs").val("");
							$(".namaobatbpjs").val("");
							$(".jumlahbpjs").val("");
							$(".dosisbpjs1").val("");
							$(".dosisbpjs2").val("");
							return false;
						}
						
						
						var cl = $(".master-table-therapy-bpjs").clone(); // untuk mengcopy class master-table
						cl.removeAttr("style"); // untuk menghapus style di class master-table
						cl.removeClass("master-table-therapy-bpjs");
						cl.addClass("newbaristherapybpjs");
						
						// add text html
						cl.find(".kodeobatbpjs-html").html(kodeobatbpjs); // untuk mengisi tr class kode-html
						cl.find(".status_racikan_bpjs-html").html(status_racikan_bpjs);
						cl.find(".namaobatbpjs-html").html(namaobatbpjs);
						cl.find(".jumlahbpjs-html").html(jumlahbpjs);
						cl.find(".dosisbpjs-html").html(dosisbpjs1 +" X "+dosisbpjs2);
						
						// add value
						var kodebaranginput = cl.find(".kodeobatbpjs-input");
						kodebaranginput.attr({name:"kodeobatbpjs[]"});//untuk post di proses
						kodebaranginput.val(kodeobatbpjs);
						
						var kodebaranginput2 = cl.find(".kodeobatlokal-input");
						kodebaranginput2.attr({name:"kodeobatlokal[]"});//untuk post di proses
						kodebaranginput2.val(kodeobatlokal);
						
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
						
						// di create setelah form satu
						$(".head-table-therapy-bpjs").after(cl);
						$(".therapybpjs").val("");
						$(".kodeobatbpjs").val("");
						$(".namaobatbpjs").val("");
						$(".jumlahbpjs").val("");
						$(".dosisbpjs1").val("");
						$(".dosisbpjs2").val("");
						
						//mengisi catatan therapi
						var catatanterapibpjs = $(this).parent().parent().parent().find(".catatan-therapy-bpjs");
						if(catatanterapibpjs.val() == ''){
							var isicatatanterapibpjs = namaobatbpjs;
						}else{
							var isicatatanterapibpjs = catatanterapibpjs.val()+', '+namaobatbpjs;
						}
						catatanterapibpjs.val(isicatatanterapibpjs);
						
						// fungsi hapus
						$(".hapus-therapy-bpjs").click(function(){
							$(this).parent().parent().remove();
						});
					});
					
					$(".hapus-therapy-bpjs").click(function(){
						var kodeobatlokal = $(this).parent().parent().find(".kodeobatlokal-input").val();
						var kodeobat2 = $(this).parent().parent().find(".kodeobatskbpjs-input").val();
						//lokal
						var kd = $(".hapusobat").val();
						if(kd == ''){
							kodeobatinput = kodeobatlokal
						}else{
							kodeobatinput = kd+','+kodeobatlokal
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
					});
					
					
					
					function valid_nama_tindakan_bpjs(){
						var yourArray = [];
						$( ".namatindakanbpjs-input" ).each(function( index, element){
							yourArray.push($(this).val());
						});
					return yourArray;
					}
					
					$(".tambah-tindakan-bpjs").click(function(){
						var kodetindakanbpjs = $(".kodetindakanbpjs").val();
						var namatindakanbpjs = $(".namatindakanbpjs").val();
						var tariftindakanbpjs = $(".tariftindakanbpjs").val();
						var keteranganbpjs = $(".keteranganbpjs").val();
						
						if(kodetindakanbpjs == ''){
							alert("Kode Tindakan masih kosong..");
							return false;
						}
						if(namatindakanbpjs == ''){
							alert("Nama Tindakan tidak valid..");
							return false;
						}
						if(tariftindakanbpjs == '--Pilih--'){
							alert("Tarif masih kosong..");
							return false;
						}
						
						//validasi jika sudah dientry 2x
						var kode_array = valid_nama_tindakan_bpjs();
						var tess = jQuery.inArray(kodetindakanbpjs,kode_array);
						//alert(tess);
						
						if (tess >= 0){
							alert("Tindakan ini sudah diinputkan...");
							$(".kodetindakanbpjs").val("");
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
						cl.find(".kodetindakanbpjs-html").html(kodetindakanbpjs); // untuk mengisi tr class kode-html
						cl.find(".namatindakanbpjs-html").html(namatindakanbpjs);
						cl.find(".tariftindakanbpjs-html").html(tariftindakanbpjs);
						cl.find(".keteranganbpjs-html").html(keteranganbpjs);
						
						// add value
						var kodetindakaninput = cl.find(".kodetindakanbpjs-input");
						kodetindakaninput.attr({name:"kodetindakanbpjs[]"});//untuk post di proses
						kodetindakaninput.val(kodetindakanbpjs);
						
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
						$(".kodetindakanbpjs").val("");
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
						serviceUrl: 'get_puskesmas.php',
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
					
					$('.nama_barang_gudang_besar').autocomplete({
						serviceUrl: 'get_namabarang_gudangbesar.php',
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
							$(this).parent().find(".namabaranghidden").val(suggestion.namabarang);
							$(this).parent().find(".jumlahstokhidden").val(suggestion.stok);
						}
					});
					
					$('.nama_barang_gudang_pelayanan').autocomplete({
						serviceUrl: 'get_namabarang_gudangpelayanan.php',
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
					
					$('.nama_barang_gudang_puskesmas_pengadaan').autocomplete({
						serviceUrl: 'get_nama_barang_gudang_puskesmas_pengadaan.php',
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
						serviceUrl: 'get_nama_barang_gudang_puskesmas_pengeluaran.php',
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
						serviceUrl: 'get_produsen.php',
						onSelect: function (suggestion) {
							$(this).val(suggestion.value);
							$(".id").val(suggestion.id);
							$(".nama_prod_obat").val(suggestion.nama_prod_obat);
						}
					});
					
					$('.nama_provinsi').autocomplete({
						serviceUrl: 'get_provinsi.php',
						onSelect: function (suggestion){
							$(this).val(suggestion.value);
							$(".kodeprovinsi").val(suggestion.kodeprovinsi);
							//$(this).parent().find(".KodeProvinsi").val(suggestion.KodeProvinsi);
						}
					});
					
					$('.nama_kota').autocomplete({
						serviceUrl: 'get_kota.php',
						onSelect: function (suggestion){
							$(this).val(suggestion.value);
							$(".kodekota").val(suggestion.kodekota);
							$(".kota").val(suggestion.kota);
							//$(this).parent().find(".kota").val(suggestion.kota);
						}
					});
					
					$('.nama_kecamatan').autocomplete({
						serviceUrl: 'get_kecamatan.php',
						onSelect: function (suggestion){
							$(this).val(suggestion.value);
							$(".kodekecamatan").val(suggestion.kodekecamatan);
							//$(this).parent().find(".kodekecamatan").val(suggestion.kodekecamatan);
						}
					});
					
					$('.nama_kelurahan').autocomplete({
						serviceUrl: 'get_kelurahan.php',
						onSelect: function (suggestion){
							$(this).val(suggestion.value);
							$(".kodekelurahan").val(suggestion.kodekelurahan);
							$(".kelurahan").val(suggestion.kelurahan);
							$(this).parent().find(".kodekelurahan").val(suggestion.kodekelurahan);
							//$(this).parent().find(".kelurahan").val(suggestion.kelurahan);
						}
					});
					
					
					
					$(".statuspengeluaran").change(function(){
						var isi = $(this).val();
						if(isi == 'DALAM GEDUNG'){
							$(".penerima").html('<option value="IGD">IGD</option><option value="KEBIDANAN">KEBIDANAN</option><option value="LOKET OBAT">LOKET OBAT</option><option value="POLI GIGI">POLI GIGI</option><option value="RAWAT INAP">RAWAT INAP</option>');
						}else if(isi == 'LUAR GEDUNG'){
							$(".penerima").html('<option value="POSYANDU">POSYANDU</option><option value="PUSTU">PUSTU</option><option value="PUSLING">PUSLING</option>');
						}else{
							$(".penerima").html('<option value="-">--Pilih--</option>');
						}
					});
					
					$(".statuspengeluaran_gb").change(function(){
						var isi = $(this).val();
						if(isi == 'GUDANG PELAYANAN'){
							$(".penerima_gb").html('<select name="penerima" class="form-control"><option value="">--Pilih--</option><option value="GUDANG PELAYANAN">GUDANG PELAYANAN</option></select>');
						}else if(isi == 'PUSKESMAS'){
							$.post( "get_puskesmas_gb.php")
							  .done(function( data ) {
								$(".penerima_gb").html(data);
							});						
						}else if(isi == 'LAINNYA'){
							$(".penerima_gb").html('<input type="text" class="form-control" name="penerima" value="-">');
						}else{
							$(".penerima_gb").html('<select name="penerima" class="form-control"><option value="">--Pilih--</option><option value="GUDANG PELAYANAN">GUDANG PELAYANAN</option></select>');
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
						if(isi == 'true'){
							$.get( "get_poli.php?sts=true")
							  .done(function( data ) {
								$(".polipertama").html(data);
							});
						}else{
							$.get( "get_poli.php?sts=false")
							  .done(function( data ) {
								$(".polipertama").html(data);
							});
						}
					});
					
					
					$(".statuspulang").change(function(){
						var isi = $(this).val();
						if(isi == '4'){
						//rujuk lanjut
							$.post( "get_rujuk_lanjut.php") 
							  .done(function( data ) {
								$(".statuspulangform").html(data);
							});	
						
						}else if(isi == '5'){
						//rujuk internal
							$.post( "get_rujuk_internal.php")
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
							$(".isi_bulan").html("<select class='form-control' name='key'><option value='01'>Januari</option><option value='02'>Februari</option><option value='03'>Maret</option><option value='04'>April</option><option value='05'>Mei</option><option value='06'>Juni</option></select>");
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
					
					var tgllahir = $(".tgllahir").val();
					$.post( "get_umur.php", { 
						tgllahir: tgllahir
					}).done(function( data ) {
						$(".umur").val(data);
					});
					
					$(".tgllahir").change(function(){
						var tgllahir = $(this).val();
						$.post( "get_umur.php", { 
							tgllahir: tgllahir
						}).done(function( data ) {
							$(".umur").val(data);
						});
					});
					
				});		