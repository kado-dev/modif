<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item"><a class="nav-link active" id="awal-tab" data-toggle="tab" href="#awal" role="tab" aria-controls="lima" aria-selected="false">Get Started</a></li>
	<li class="nav-item"><a class="nav-link" id="satu-tab" data-toggle="tab" href="#satu" role="tab" aria-controls="satu" aria-selected="false">Token</a></li>
	<li class="nav-item"><a class="nav-link" id="dua-tab" data-toggle="tab" href="#dua" role="tab" aria-controls="dua" aria-selected="true">Status Antrean</a></li>
	<li class="nav-item"><a class="nav-link" id="tiga-tab" data-toggle="tab" href="#tiga" role="tab" aria-controls="tiga" aria-selected="true">Antrean</a></li>
	<li class="nav-item"><a class="nav-link" id="empat-tab" data-toggle="tab" href="#empat" role="tab" aria-controls="empat" aria-selected="false">Sisa Antrean</a></li>
	<li class="nav-item"><a class="nav-link" id="lima-tab" data-toggle="tab" href="#lima" role="tab" aria-controls="lima" aria-selected="false">Batal Antrean</a></li>
	<li class="nav-item"><a class="nav-link" id="enam-tab" data-toggle="tab" href="#enam" role="tab" aria-controls="enam" aria-selected="false">Pasien Baru</a></li>

</ul>
		
<div class="tab-content">
	<div class="tab-pane active" id="awal" role="tabpanel" aria-labelledby="awal-tab"><br/>
		<div class="row">
			<div class="col-sm-6">
				<h3>API ANTREAN BPJS</h3>
				<p class="lead">
					Layanan ini dipergunakan untuk bridging Antrian Simpus dengan Antrian JKN Mobile BPJS.
					Dalam menggunakan layanan ini, dibutuhkan username dan password untuk generate API key dalam bentuk token.<br/><br/>
					Untuk mendapatkan oken silahkan hubungi kami...<br/>			
				</p>
			</div>
			<div class="col-sm-6">
				<img src="<?php echo base_url('asset/img/jknmobile.jpg');?>"  width="100%" style="border-radius: 20px;"/>
			</div>
		</div>
	</div>
	<div class="tab-pane" id="satu" role="tabpanel" aria-labelledby="satu-tab">
		<p class="contohurl">
			URL : https://simpus.bandungkab.go.id/api/index.php/auth<br/>
			METHOD : GET<br/>
			HEADER : x-username, x-password<br/>
		</p>
		<p>
		<pre><code class="json">
	{
		"response": {
			"token"" : ""1231242353534645645"
		},
		"metadata": {
			"message"": "Ok",
			"code"": 200
		}
	}
		</code></pre>	
		</p>
	</div>
	<div class="tab-pane" id="dua" role="tabpanel" aria-labelledby="dua-tab">
		<p class="contohurl">
			URL : https://simpus.bandungkab.go.id/api/index.php/antrean/status/[kode_poli]/[tanggalperiksa]<br/>
			CTH : https://simpus.bandungkab.go.id/api/index.php/antrean/status/001/2020-01-28"<br/>
			METHOD : GET<br/>
			HEADER : x-token, x-username<br/>
		</p>
		<p>
		<pre><code class="json">
	{
		"response": {
			"namapoli" : "Poli Umum",
			"totalantrean" : "25",
			"sisaantrean" : "4",
			"antreanpanggil" : "A21",
			"keterangan" : ""
		},
		"metadata": {
			"message": "Ok",
			"code": 200
		}
	}
		</code></pre>	
		<pre><code class="json">
		Metadata code:
		200: Sukses
		201: Gagal

		Selain metadata code 200, agar message pada metadata diisi sesuai dengan kondisi di lapangan
		</code></pre>
		</p>
	</div>

	<div class="tab-pane" id="tiga" role="tabpanel" aria-labelledby="tiga-tab">
		<p class="contohurl">
			URL : https://simpus.bandungkab.go.id/api/index.php/antrean<br/>
			METHOD : POST<br/>
			HEADER : x-token, x-username<br/>
		</p>
		<p>
		<pre><code class="json">
	Parameter:<br/>		
	{
		"nomorkartu": "00012345678",
		"nik": "3212345678987654",
		"kodepoli": "001",
		"tanggalperiksa": "2020-01-28",
		"keluhan": "sakit kepala"
	}

	Response:<br/>
	{
		""response"": {
			"nomorantrean" : "A12",
			"angkaantrean" : "12",
			"namapoli" : "Poli Umum",
			"sisaantrean" : "4""
			"antreanpanggil" : "A8",
			"keterangan" : "Apabila antrean terlewat harap mengambil antrean kembali."
		},
		"metadata"": {
			"message": "Ok",
			"code": 200
		}
	}

	Keterangan:<br/>
	Metadata code:
	200: Sukses
	201: Gagal
	202: Pasien Baru

	Selain metadata code 200, agar message pada metadata diisi sesuai dengan kondisi di lapangan
		</code></pre>	
		</p>
	</div>

	<div class="tab-pane" id="empat" role="tabpanel" aria-labelledby="empat-tab">
		<p class="contohurl">
			URL : https://simpus.bandungkab.go.id/api/index.php/antrean/sisapeserta/[nomorkartu_jkn]/[kode_poli]/[tanggalperiksa]<br/>
			CTH : https://simpus.bandungkab.go.id/api/index.php/antrean/sisapeserta/00012345678/001/2020-01-28<br/>
			METHOD : GET<br/>
			HEADER : x-token, x-username<br/>
		</p>
		<p>
		<pre><code class="json">
	Response:<br>
	{
		"response": {
			"nomorantrean" : "A20",
			"namapoli" : "Poli Umum",
			"sisaantrean" : "4",
			"antreanpanggil" : "A8",
			"keterangan" : ""
		},
		"metadata": {
			"message": "Ok",
			"code": 200
		}
	}

	Keterangan:<br/>
	Metadata code:
	200: Sukses
	201: Gagal

	Selain metadata code 200, agar message pada metadata diisi sesuai dengan kondisi di lapangan
		</code></pre>	
		</p>
	</div>

	<div class="tab-pane" id="lima" role="tabpanel" aria-labelledby="lima-tab">
		<p class="contohurl">
			URL : https://simpus.bandungkab.go.id/api/index.php/antrean/batal<br/>
			METHOD : PUT<br/>
			HEADER : x-username, x-password<br/>
		</p>
		<p>
		<pre><code class="json">
	Parameter:<br>
	{
		"nomorkartu": "00012345678",
		"kodepoli": "001",
		"tanggalperiksa": "2020-01-28"
	}

	Response:<br>
	{
		"metadata": {
			"message": "Ok",
			"code": 200
		}
	}

	Keterangan:<br>
	"Metadata code:
	200: Sukses
	201: Gagal

	Selain metadata code 200, agar message pada metadata diisi sesuai dengan kondisi di lapangan"
		</code></pre>	
		</p>
	</div>

	<div class="tab-pane" id="enam" role="tabpanel" aria-labelledby="enam-tab">
		<p class="contohurl">
			URL : https://simpus.bandungkab.go.id/api/index.php/peserta<br/>
			METHOD : GET<br/>
			HEADER : x-token, x-username<br/>
		</p>
		<p>
		<pre><code class="json">
	Parameter<br/>
	{
		"nomorkartu": "00012345678",
		"nik": "3212345678987654",
		"nomorkk": "3212345678987654",
		"nama": "sumarsono",
		"jeniskelamin": "L",
		"tanggallahir": "1985-03-01",
		"alamat": "alamat yang muncul merupakan alamat lengkap",
		"kodeprop": "11",
		"namaprop": "Jawa Barat",
		"kodedati2": "0120",
		"namadati2": "Kab. Bandung",
		"kodekec": "1319",
		"namakec": "Soreang",
		"kodekel": "D2105",
		"namakel": "Cingcin",
		"rw": "001",
		"rt": "013"
	}

	Response:<br/>
	{
		"metadata": {
			"message": "Ok",
			"code": 200
		}
	}

	Keterangan:<br/>

	"Metadata code:
	200: Sukses
	201: Gagal
	Selain metadata code 200, agar message pada metadata diisi sesuai dengan kondisi di lapangan"
		</code></pre>	
		</p>
	</div>
</div>