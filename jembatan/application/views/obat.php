<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item"><a class="nav-link active" id="satu-tab" data-toggle="tab" href="#satu" role="tab" aria-controls="satu" aria-selected="true">Data Obat</a></li>
	<li class="nav-item"><a class="nav-link" id="dua-tab" data-toggle="tab" href="#dua" role="tab" aria-controls="dua" aria-selected="true">10 Pemakaian Terbanyak</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="satu" role="tabpanel" aria-labelledby="satu-tab">
		<p class="contohurl">
			URL : {BASE URL}/obat/index/{keyword}/{start}/{finish}<br/>
			CTH : {BASE URL}/obat/index/paras/1/10<br/>
			METHOD : GET<br/>
		</p>
		<p>
		<pre><code class="json">
{
	"Response": [
		{
			"KodeBarang": "GFK0077",
			"KodeBarangBpjs": "0",
			"KodeBarangElog": "0",
			"id_indikator": "0",
			"Barcode": "77",
			"NamaBarang": "PARASETAMOL SYR 120 MG/5ML 60 ML",
			"KodeBarangInn": "-",
			"NamaBarangInn": "-",
			"Kekuatan": "-",
			"Sediaan": "-",
			"Golongan": "-",
			"DetailKemasan": "-",
			"NamaLengkap": "-",
			"Kemasan": "Botol",
			"IsiKemasan": "0",
			"Satuan": "Botol",
			"JenisBarangElog": "TUNGGAL",
			"StatusApproveElog": "APPROVED",
			"KelasTherapy": "OBAT",
			"GolonganFungsi": "ANALGETIK, ANTIPIRETIK, ANTIINFLAMASI, AINS",
			"JenisBarang": "GENERIK",
			"Ruangan": "GUDANG BESAR",
			"Rak": "-",
			"Stok": "2106",
			"MinimalStok": "0",
			"HargaBeli": "0",
			"NoBatch": "0",
			"Expire": "2016-12-23",
			"SumberAnggaran": "APBD KAB/KOTA",
			"TahunAnggaran": "2018",
			"KodeSupplier": "SPL001",
			"Keterangan": "-",
			"NamaPegawaiSimpan": "-",
			"NamaPegawaiEdit": "TOMMY NATALIANTO. JH, ST",
			"TanggalEdit": "2016-09-22"
			}
		],
		"Pesan": {
			"Status": "Berhasil",
			"Kode": 200
		}
	}
}

		</code></pre>	
		</p>
	</div>
	<div class="tab-pane" id="dua" role="tabpanel" aria-labelledby="dua-tab">
		<p class="contohurl">
			URL : https://simpus.bandungkab.go.id/api/index.php/obatterbanyak/index/01/2021<br/>
			METHOD : GET<br/>
		</p>
		<p>
		<pre><code class="json">
{
	"Response": {
		"Count": 10,
		"List": [
		  {
		"KodeBarang": "GFK0263",
		"NamaBarang": "Besi (Fe) Tablet Tambah Darah + Asam Folat",
		"Jumlah": "9687540"
		},
		  {
		"KodeBarang": "GFK0113",
		"NamaBarang": "Metformin Tablet 500 mg",
		"Jumlah": "688900"
		},
		  {
		"KodeBarang": "GFK0011",
		"NamaBarang": "Amlodipine Tablet 5 mg",
		"Jumlah": "517800"
		},
		  {
		"KodeBarang": "GFK0010",
		"NamaBarang": "Amlodipine Tablet 10 mg",
		"Jumlah": "460400"
		},
		  {
		"KodeBarang": "GFK0173",
		"NamaBarang": "Vitamin B Kompleks Tablet",
		"Jumlah": "409100"
		},
		  {
		"KodeBarang": "GFK0142",
		"NamaBarang": "Parasetamol Tablet 500 mg",
		"Jumlah": "401370"
		},
		  {
		"KodeBarang": "GFK0014",
		"NamaBarang": "Amoxicilin Kaplet 500 mg",
		"Jumlah": "389320"
		},
		  {
		"KodeBarang": "GFK0378",
		"NamaBarang": "Masker bedah 3fly",
		"Jumlah": "373150"
		},
		  {
		"KodeBarang": "GFK0153",
		"NamaBarang": "Ranitidine Tablet 150 mg",
		"Jumlah": "351500"
		},
		  {
		"KodeBarang": "GFK0020",
		"NamaBarang": "Antasida DOEN Tablet",
		"Jumlah": "273900"
		}
		],
		"Pesan": {
		"Status": "Berhasil",
		"Kode": 200
		}
	}
}
		</code></pre>	
		</p>
	</div>
	
</div>