<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item"><a class="nav-link active" id="satu-tab" data-toggle="tab" href="#satu" role="tab" aria-controls="satu" aria-selected="true">10 Besar</a></li>
	<li class="nav-item"><a class="nav-link" id="dua-tab" data-toggle="tab" href="#dua" role="tab" aria-controls="dua" aria-selected="true">Wabah (W2)</a></li>
	<li class="nav-item"><a class="nav-link" id="tiga-tab" data-toggle="tab" href="#tiga" role="tab" aria-controls="tiga" aria-selected="true">Campak (C1)</a></li>
	<li class="nav-item"><a class="nav-link" id="empat-tab" data-toggle="tab" href="#empat" role="tab" aria-controls="empat" aria-selected="true">Diare</a></li>
	<li class="nav-item"><a class="nav-link" id="lima-tab" data-toggle="tab" href="#lima" role="tab" aria-controls="lima" aria-selected="true">Ispa</a></li>
	<li class="nav-item"><a class="nav-link" id="enam-tab" data-toggle="tab" href="#enam" role="tab" aria-controls="enam" aria-selected="true">Surveilans</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="satu" role="tabpanel" aria-labelledby="satu-tab">
		<p class="contohurl">
			URL : {BASE URL}/sepuluhbesar/index/{bulan}/{tahun}<br/>
			CTH : {BASE URL}/sepuluhbesar/index/10/2018<br/>
			METHOD : GET<br/>
		</p>
		<p>
		<pre><code class="json">
{
	"Response": {
		"Count": 8,
		"List": [
			{
			"KodeDiagnosa": "R51",
			"NamaDiagnosa": "Headache",
			"Jumlah": "23"
			},
			{
			"KodeDiagnosa": "B05.9",
			"NamaDiagnosa": "Measles without complication",
			"Jumlah": "3"
			},
			{
			"KodeDiagnosa": "J18.9",
			"NamaDiagnosa": "Pneumonia, unspecified",
			"Jumlah": "3"
			},
			  {
			"KodeDiagnosa": "I25.0",
			"NamaDiagnosa": "Atherosclerotic cardiovascular disease, so described",
			"Jumlah": "2"
			},
			  {
			"KodeDiagnosa": "E14.0",
			"NamaDiagnosa": "Unspecified diabetes mellitus with coma",
			"Jumlah": "1"
			},
			  {
			"KodeDiagnosa": "E14.9",
			"NamaDiagnosa": "Unspecified diabetes mellitus without complications",
			"Jumlah": "1"
			},
			  {
			"KodeDiagnosa": "A09",
			"NamaDiagnosa": "Diarrhoea and gastroenteritis of presumed infectious origin",
			"Jumlah": "1"
			},
			  {
			"KodeDiagnosa": "J00",
			"NamaDiagnosa": "Acute nasopharyngitis [common cold]",
			"Jumlah": "1"
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
		<div class="accordion" id="accordionExample">
		  <div class="card">
			<div class="card-header" id="headingOne">
			  <h5 class="mb-0">
				<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				  Get Referensi Wabah
				</button>
			  </h5>
			</div>

			<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
			  <div class="card-body">
		<p class="contohurl">
			URL : {BASE URL}/wabah/index/{bulan}/{tahun}<br/>
			CTH : {BASE URL}/wabah/index/10/2018<br/>
			METHOD : GET<br/>
		</p>
		<p>
		<pre><code class="json">
{
	"Response": [
		{
		"KodeDiagnosa": "A09.0",
		"NamaDiagnosa": "Diare Akut",
		"Jumlah": "0"
		},
		{
		"KodeDiagnosa": "B50.9",
		"NamaDiagnosa": "Malaria Konfirmasi",
		"Jumlah": "0"
		},
		{
		"KodeDiagnosa": "A90",
		"NamaDiagnosa": "Tersangka Demam Dengue",
		"Jumlah": "0"
		},
		{
		"KodeDiagnosa": "J18.9",
		"NamaDiagnosa": "Pneumonia",
		"Jumlah": "1"
		},
		{
		"KodeDiagnosa": "Z01",
		"NamaDiagnosa": "Tersangka HFMD (Hand, Foot, Mount, Disease)",
		"Jumlah": "0"
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
			</div>
		  </div>
		  <div class="card">
			<div class="card-header" id="headingTwo">
			  <h5 class="mb-0">
				<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				  Get Referensi Wabah (Desa/Kelurahan)
				</button>
			  </h5>
			</div>
			<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
			  <div class="card-body">
		<p class="contohurl">
			URL : {BASE URL}/wabah/index/{bulan}/{tahun}/{kelurahan}<br/>
			CTH : {BASE URL}/wabah/index/10/2018/Soreang<br/>
			METHOD : GET<br/>
		</p>
		<p>
		<pre><code class="json">
{
	"Response": [
		{
		"KodeDiagnosa": "A09.0",
		"NamaDiagnosa": "Diare Akut",
		"Jumlah": "0"
		},
		{
		"KodeDiagnosa": "B50.9",
		"NamaDiagnosa": "Malaria Konfirmasi",
		"Jumlah": "0"
		},
		{
		"KodeDiagnosa": "A90",
		"NamaDiagnosa": "Tersangka Demam Dengue",
		"Jumlah": "0"
		},
		{
		"KodeDiagnosa": "J18.9",
		"NamaDiagnosa": "Pneumonia",
		"Jumlah": "1"
		},
		{
		"KodeDiagnosa": "Z01",
		"NamaDiagnosa": "Tersangka HFMD (Hand, Foot, Mount, Disease)",
		"Jumlah": "0"
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
			</div>
		  </div>
	
		</div>				
		
	</div>
	<div class="tab-pane" id="tiga" role="tabpanel" aria-labelledby="tiga-tab">
		<p class="contohurl">
			URL : {BASE URL}/campak/index/{bulan}/{tahun}<br/>
			CTH : {BASE URL}/campak/index/10/2018<br/>
			METHOD : GET<br/>
			Kode ICD X : B05.9
		</p>
		<p>
		<pre><code class="json">
{
	"Response": {
		"KasusBaru": "2",
		"KasusLama": "1"
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
			URL : {BASE URL}/diare/index/{bulan}/{tahun}<br/>
			CTH : {BASE URL}/diare/index/10/2018<br/>
			METHOD : GET<br/>
			Kode ICD X : A03.0, A06.0, A09
		</p>
		<p>
		<pre><code class="json">
{
	"Response": {
		"KasusBaru": "4",
		"KasusLama": "1"
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
			URL : {BASE URL}/ispa/index/{bulan}/{tahun}<br/>
			CTH : {BASE URL}/ispa/index/10/2018<br/>
			METHOD : GET<br/>
			Kode ICD X : J18.0, J18.9, J00, J06.9
		</p>
		<p>
		<pre><code class="json">
{
	"Response": {
		"KasusBaru": "2",
		"KasusLama": "0"
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
			URL : {BASE URL}/surveilans/index/{bulan}/{tahun}<br/>
			CTH : {BASE URL}/surveilans/index/10/2018<br/>
			METHOD : GET<br/>
		</p>
		<p>
		<pre><code class="json">
{
	"Response": [
		{
		"KodeDiagnosa": "I10",
		"NamaDiagnosa": "Hipertensi",
		"Jumlah": "0"
		},
		{
		"KodeDiagnosa": "J00",
		"NamaDiagnosa": "Influenza",
		"Jumlah": "0"
		},
		{
		"KodeDiagnosa": "E11",
		"NamaDiagnosa": "Diabetes",
		"Jumlah": "0"
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
</div>