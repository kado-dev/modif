<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item"><a class="nav-link active" id="satu-tab" data-toggle="tab" href="#satu" role="tab" aria-controls="satu" aria-selected="true">Baru Lama</a></li>
	<li class="nav-item"><a class="nav-link" id="dua-tab" data-toggle="tab" href="#dua" role="tab" aria-controls="dua" aria-selected="true">Cara Bayar</a></li>
	<li class="nav-item"><a class="nav-link" id="tiga-tab" data-toggle="tab" href="#tiga" role="tab" aria-controls="tiga" aria-selected="false">Poli</a></li>
	<li class="nav-item"><a class="nav-link" id="empat-tab" data-toggle="tab" href="#empat" role="tab" aria-controls="empat" aria-selected="false">Jenis Kelamin</a></li>
	<li class="nav-item"><a class="nav-link" id="lima-tab" data-toggle="tab" href="#lima" role="tab" aria-controls="lima" aria-selected="false">Retribusi</a></li>
	<li class="nav-item"><a class="nav-link" id="enam-tab" data-toggle="tab" href="#enam" role="tab" aria-controls="enam" aria-selected="false">Pasien RJ</a></li>
	<li class="nav-item"><a class="nav-link" id="tujuh-tab" data-toggle="tab" href="#tujuh" role="tab" aria-controls="tujuh" aria-selected="false">Tracking Kunjungan</a></li>
	<li class="nav-item"><a class="nav-link" id="delapan-tab" data-toggle="tab" href="#delapan" role="tab" aria-controls="delapan" aria-selected="false">Puskesmas</a></li>
	<!--<li class="nav-item"><a class="nav-link" id="sembilan-tab" data-toggle="tab" href="#sembilan" role="tab" aria-controls="sembilan" aria-selected="false">Kematian</a></li>-->
</ul>
		
<div class="tab-content">
<div class="tab-pane active" id="satu" role="tabpanel" aria-labelledby="satu-tab">
	<p class="contohurl">
		URL : https://simpus.bandungkab.go.id/api/index.php/barulama/index/01/2021<br/>
		METHOD : GET<br/>
	</p>
	<p>
	<pre><code class="json">
{
	"Response": {
		"KunjunganBaru": "14285",
		"KunjunganLama": "43706"
	},
	"Pesan": {
		"Status": "Berhasil",
		"Kode": 200
	}
}
	</code></pre>	
	</p>
</div>

<div class="tab-pane" id="dua" role="tabpanel" aria-labelledby="dua-tab">
	<p class="contohurl">
		URL : https://simpus.bandungkab.go.id/api/index.php/carabayar/index/01/2021<br/>
		METHOD : GET<br/>
		KET : Cara Bayar Bulan (Semua Puskesmas)<br/>
	</p>
	<p>
	<pre><code class="json">
{
	"Response": {
		"BPJS PBI": "19435",
		"BPJS NON PBI": "9872",
		"GRATIS": "7952",
		"UMUM": "25142",
		"SKTM": "144"
	},
	"Pesan": {
		"Status": "Berhasil",
		"Kode": 200
	}
}
	</code></pre>	
	</p></hr>
	
	<p class="contohurl">
		URL : https://simpus.bandungkab.go.id/api/index.php/carabayartahun/index/2021<br/>
		METHOD : GET<br/>
		KET : Cara Bayar Tahun (Semua Puskesmas)<br/>
	</p>
	<p>
	<pre><code class="json">
{
	"Response": {
		"BPJS PBI": "19435",
		"BPJS NON PBI": "9872",
		"GRATIS": "7952",
		"UMUM": "25142",
		"SKTM": "144"
	},
	"Pesan": {
		"Status": "Berhasil",
		"Kode": 200
	}
}
	</code></pre>	
	</p>
</div>

<div class="tab-pane" id="tiga" role="tabpanel" aria-labelledby="tiga-tab">
	<p class="contohurl">
		URL : https://simpus.bandungkab.go.id/api/index.php/poli/index/01/2021<br/>
		METHOD : GET<br/>
	</p>
	<p>
	<pre><code class="json">
{
	"Response": {
		"Poli Gigi": "5663",
		"Poli KIA": "2919",
		"Poli KB": "1090",
		"Poli Umum": "30146"
	},
	"Pesan": {
		"Status": "Berhasil",
		"Kode": 200
	}
}
	</code></pre>	
	</p>
</div>

<div class="tab-pane" id="empat" role="tabpanel" aria-labelledby="empat-tab">
	<p class="contohurl">
		URL : https://simpus.bandungkab.go.id/api/index.php/jeniskelamin/index/01/2021<br/>
		METHOD : GET<br/>
	</p>
	<p>
	<pre><code class="json">
{
	"Response": {
		"Lakilaki": "20643",
		"Perempuan": "37350"
	},
	"Pesan": {
		"Status": "Berhasil",
		"Kode": 200
	}
}
	</code></pre>	
	</p>
</div>

<div class="tab-pane" id="lima" role="tabpanel" aria-labelledby="lima-tab">
	<p class="contohurl">
		URL : https://simpus.bandungkab.go.id/api/index.php/retribusipuskesmas/index/01/2021<br/>
		METHOD : GET<br/>
	</p>
	<p>
	<pre><code class="json">
{
	"Response": {
		"Harian": "1410000",
		"Bulanan": "170005000",
		"Tahunan": "794475000"
	},
	"Pesan": {
		"Status": "Berhasil",
		"Kode": 200
	}
}
	</code></pre>	
	</p>
</div>

<div class="tab-pane" id="enam" role="tabpanel" aria-labelledby="enam-tab">
	<p class="contohurl">
		URL : https://simpus.bandungkab.go.id/api/index.php/pasienrj/index/2018-10-10/P3204270201/0/100<br/>
		METHOD : GET<br/>
	</p>
	<p>
	<pre><code class="json">
{
	"Response": [
		{
			"TanggalRegistrasi": "2021-01-02",
			"NoRegistrasi": "P3204270201/210102/001",
			"NoIndex": "IDP3204270201/2019/11170",
			"NoCM": "P3204270201/2019/001308",
			"NoRM": "P3204270201",
			"NamaPasien": "TATA SARTANA",
			"JenisKelamin": "L",
			"WaktuKunjungan": "1",
			"StatusBuku": "i",
			"PoliPertama": "POLI LANSIA",
			"Asuransi": "BPJS PBI",
			"StatusKunjungan": "Baru",
			"TarifKarcis": "0",
			"TarifKir": "0",
			"TotalTarif": "0",
			"Kir": ""
		}
	]
	"Pesan": {
		"Status": "Berhasil",
		"Kode": 200
	}
}
	</code></pre>	
	</p>
</div>

<div class="tab-pane" id="tujuh" role="tabpanel" aria-labelledby="tujuh-tab">
	<p class="contohurl">
		URL : https://simpus.bandungkab.go.id/api/index.php/trackingkunjungan/index/01/2021<br/>
		METHOD : GET<br/>
	</p>
	<p>
	<pre><code class="json">
Response: 
{
	"hasil": {
		"kunjungan_hari": "644",
		"kunjungan_bulan": "30053",
		"kunjungan_tahun": "369562"
	},
	"pesan": {
		"status": "Berhasil",
		"kode": 200
	}
}
	</code></pre>	
	</p>
</div>

<div class="tab-pane" id="delapan" role="tabpanel" aria-labelledby="delapan-tab">
	<p class="contohurl">
		URL : https://simpus.bandungkab.go.id/api/index.php/puskesmas/index/2021-05-05<br/>
		METHOD : GET<br/>
	</p>
	<p>
	<pre><code class="json">
{
	"Response": [
		{
			"KodePuskesmas": "P3204100101",
			"NamaPuskesmas": "CICALENGKA DTP",
			"Jumlah": "293"
		},
		{
			"KodePuskesmas": "P3204090201",
			"NamaPuskesmas": "CIKANCUNG",
			"Jumlah": "263"
		}
	],
	"Pesan": {
		"Status": "Berhasil",
		"Kode": 200
	}
}
	</code></pre>	
	</p>
</div>
<!--
	<div class="tab-pane" id="sembilan" role="tabpanel" aria-labelledby="sembilan-tab">
		<p class="contohurl">
			URL : https://simpus.bandungkab.go.id/api/index.php/kematian/index/01/2021/P3204280201<br/>
			METHOD : GET<br/>
		</p>
		<p>
		<pre><code class="json">
	{
		"Response": {
			"Jml_Hidup_L": 1,
			"Jml_Hidup_P": 0,
			"Jml_Meninggal_L": 0,
			"Jml_Meninggal_P": 0
		},
		"Pesan": {
			"Status": "Berhasil",
			"Kode": 200
		}
	}
		</code></pre>	
		</p>
	</div>
-->
</div>