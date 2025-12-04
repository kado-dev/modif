# Instruksi Perbaikan Controller Antrean

Controller `Antrean.php` adalah controller yang sangat kompleks dan masih memiliki beberapa query langsung yang perlu diperbaiki.

## Query yang Perlu Diperbaiki

### 1. Token Verification (Line 16)

**Sebelum:**

```php
$cektoken = $this->db->query("SELECT * FROM tbtoken a join tbapikey b ON a.id = b.id WHERE b.Username = '$username' AND a.token = '$token' AND a.expire >= CURRENT_TIMESTAMP()");
```

**Sesudah:**

```php
$this->db->select('*');
$this->db->from('tbtoken a');
$this->db->join('tbapikey b', 'a.id = b.id');
$this->db->where('b.Username', $username);
$this->db->where('a.token', $token);
$this->db->where('a.expire >=', 'CURRENT_TIMESTAMP()', FALSE);
$cektoken = $this->db->get();
```

### 2. Get Puskesmas (Line 120)

**Sebelum:**

```php
$getpuskesmas = $this->db->query("SELECT * FROM tbpuskesmas WHERE KodePuskesmas = '$kodepuskesmas'")->row();
```

**Sesudah:**

```php
$this->db->where('KodePuskesmas', $kodepuskesmas);
$getpuskesmas = $this->db->get('tbpuskesmas')->row();
```

### 3. Check Pasien (Line 137)

**Sebelum:**

```php
$ceksts = $this->db->query("SELECT IdPasien, NamaPasien, TanggalLahir, JenisKelamin FROM $tbpasien WHERE NoAsuransi = '$nomorkartu'");
```

**Sesudah:**

```php
// Validate table name first
if (!preg_match('/^[a-zA-Z0-9_]+$/', $tbpasien)) {
    // Error handling
}
$this->db->select('IdPasien, NamaPasien, TanggalLahir, JenisKelamin');
$this->db->where('NoAsuransi', $nomorkartu);
$ceksts = $this->db->get($tbpasien);
```

### 4. Get Pelayanan (Line 244)

**Sebelum:**

```php
$dtpelayanan = $this->db->query("SELECT * FROM `tbpelayanankesehatan` WHERE kdPoli = '$kodepoli'")->row();
```

**Sesudah:**

```php
$this->db->where('kdPoli', $kodepoli);
$dtpelayanan = $this->db->get('tbpelayanankesehatan')->row();
```

### 5. Setting Antrian (Line 251)

**Sebelum:**

```php
$dtsettingantrian = $this->db->query("SELECT WaktuPelayananTutup FROM `tbantrian_setting` WHERE KodePuskesmas = '$kodepuskesmas'");
```

**Sesudah:**

```php
$this->db->select('WaktuPelayananTutup');
$this->db->where('KodePuskesmas', $kodepuskesmas);
$dtsettingantrian = $this->db->get('tbantrian_setting');
```

### 6. Dynamic Table Names

Untuk table yang dinamis seperti `tbantrian_pasien_{kodepuskesmas}`, pastikan:

1. Validasi `kodepuskesmas` sebelum digunakan
2. Gunakan whitelist jika mungkin
3. Escape table name dengan backticks jika diperlukan

**Contoh:**

```php
// Validate kodepuskesmas
if (!preg_match('/^[a-zA-Z0-9_]+$/', $kodepuskesmas)) {
    // Error
}

$tbantranpasien = "tbantrian_pasien_" . $kodepuskesmas;
// Use Query Builder
$this->db->where('KodePuskesmas', $kodepuskesmas);
$this->db->where('PoliPertama', $poli);
$this->db->where('DATE(WaktuAntrian)', $tanggalperiksa);
$result = $this->db->get($tbantranpasien);
```

## Validasi Input yang Perlu Ditambahkan

1. **Nomor Kartu**: Pastikan 13 digit numerik
2. **NIK**: Pastikan 16 digit numerik
3. **Kode Poli**: Validasi format
4. **Tanggal**: Validasi format YYYY-MM-DD
5. **Kode Dokter**: Validasi jika ada
6. **No RM**: Validasi format

## Error Handling

Ganti semua `echo json_encode($resp); die();` dengan:

```php
$this->output
    ->set_status_header($code)
    ->set_content_type('application/json')
    ->set_output(json_encode($resp));
return;
```

## Testing

Setelah perbaikan, test dengan:

1. Valid input
2. SQL injection attempts
3. XSS attempts
4. Invalid format input
5. Missing required fields
