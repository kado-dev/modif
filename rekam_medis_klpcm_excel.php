<?php
    session_start();
	include "config/helper_css_laporan.php";
	include "config/helper_pasienrj.php";
	include "config/koneksi.php";
	$hariini = date('d-m-Y');
	$tglawal = $_GET['tglawal'];
	$tglakhir = $_GET['tglakhir'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Register KLPCM (".$hariini.").xls");
	if(isset($hariini)){
?>

<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:14px;
	font-family: "Trebuchet MS";
}
.printheader p{
	font-size:14px;
	font-family: "Trebuchet MS";
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	margin-top:10px;
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
}


@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.atastabel{
		display:block;
	}
}
</style>

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN KLPCM</b></h4>
	<p style="margin:1px; font-size: 16px;">
        <?php if($tglawal != ''){?>
		    <p style="margin:1px;">Periode Laporan: <?php echo $tglawal." s/d".$tglakhir;?></p>
        <?php }else{ ?>
            <p style="margin:1px;">Periode Laporan: <?php echo $hariini;?></p>
        <?php } ?>
	</p><br/>
</div>

<div class="atastabel font14">
	<div style="float:left; width:65%; margin-bottom:0px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5 style="margin:5px;">Kode Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$kodepuskesmas;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$namapuskesmas;?></h5 ></td>
			</tr>
		</table>
	</div>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
    <table class="table-judul" border=1>
        <thead>
            <tr>
                <th width="3%" rowspan="2">NO.</th>
                <th width="7%" rowspan="2">NO INDEX</th>
                <th width="20%" rowspan="2">NAMA PASIEN</th>
                <th width="17%" colspan="2">SELESAI ENTRY DATA</th>
                <th width="7%" rowspan="2">CARA BAYAR</th>
                <th width="7%" rowspan="2">PELAYANAN</th>
                <th colspan="4">KELENGKAPAN CATATAN MEDIS</th>
            </tr>
            <tr>
                <th>PENDAFTARAN</th>
                <th>PEMERIKSAAN</th>
                <th width="15%" >ANAMNESA</th>
                <th width="15%" >VITAL SIGN</th>
                <th width="15%" >DIAGNOSA</th>
                <th width="15%" >THERAPY</th>
            </tr>
        </thead>
        <tbody>
            <?php            
            $key = $_GET['key'];	
            $tglawal = $_GET['tglawal'];
			$tglakhir = $_GET['tglakhir'];
            $pelayanan = $_GET['pelayanan'];	
            
            if($tglawal != null){
                $tglawal = date('Y-m-d',strtotime($tglawal));
                $tglakhir = date('Y-m-d',strtotime($tglakhir));
                $tgl_str = " date(TanggalRegistrasi) BETWEEN '$tglawal' AND '$tglakhir' AND ";
            }else{
                $tgl_str = " date(TanggalRegistrasi) = '".date('Y-m-d')."' AND ";
            }
                                            
            if($key !=''){
                $strcari = " AND (`NamaPasien` like '%$key%' OR `NoIndex` like '%$key%' OR `NoRM` like '%$key%')";
            }else{
                $strcari = " ";
            }
                                
            if($pelayanan == 'semua' || $pelayanan == ''){
                $ply = " ";
            }else{
                $ply = " AND `PoliPertama`='$pelayanan'";
            }
            
            // kunjungan sehat tidak ditampilkan
            $str = "SELECT * FROM `$tbpasienrj`
            WHERE ".$tgl_str." StatusPasien = '1'".$strcari.$ply;		
            $str2 = $str." order by NoRegistrasi DESC";
            // echo $str2;
            // die();
            
            $query = mysqli_query($koneksi,$str2);
            while($data = mysqli_fetch_assoc($query)){
                $no = $no + 1;
                $idpasienrj = $data['IdPasienrj'];
                $noindex = $data['NoIndex'];
                $nocm = $data['NoCM'];
                $noregistrasi = $data['NoRegistrasi'];
                $kunjungan = $data['StatusKunjungan'];
                if($kunjungan == 'Baru' AND substr($noindex,14,4) == $tahunini){
                    $stylewarna = "style='background:#b3ecfd'";
                }else{
                    $stylewarna = "";
                }

                // cek anamnesa
                $namapkm = str_replace(' ','',strtoupper($namapuskesmas));
                if ($data['PoliPertama'] == "POLI GIGI" OR $data['PoliPertama'] == "POLI KIA" OR $data['PoliPertama'] == "POLI LANSIA" OR $data['PoliPertama'] == "POLI MTBS" OR $data['PoliPertama'] == "POLI UMUM" OR $data['PoliPertama'] == "POLI BERSALIN"){
                    $pelayanan = "tb".str_replace(' ','',strtolower($data['PoliPertama']))."_$namapkm";	
                }else{
                    $pelayanan = "tb".str_replace(' ','',strtolower($data['PoliPertama']));
                }

                $stranamnesa = "SELECT * FROM `$pelayanan` WHERE `NoPemeriksaan`='$data[NoRegistrasi]'";
                $queryanamnesa = mysqli_query($koneksi, $stranamnesa);
                $dtanamnesa = mysqli_fetch_assoc($queryanamnesa);

                // vital sign
                $strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
                $dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
                $dtsistole = $dtvs['Sistole'];
                $dtdiastole = $dtvs['Diastole'];
                $dtsuhutubuh = $dtvs['SuhuTubuh'];
                $dttinggiBadan = $dtvs['TinggiBadan'];
                $dtberatBadan = $dtvs['BeratBadan'];
                $dtheartRate = $dtvs['HeartRate'];
                $dtrespRate = $dtvs['RespiratoryRate'];
                $dtLingkarPerut = $dtvs['LingkarPerut'];
                $imt = $dtvs['IMT'];
            ?>
                <tr <?php echo $stylewarna;?>>
                    <td align="center" style="vertical-align: middle;"><?php echo $no;?></td>
                    <td align="center" style="vertical-align: middle;"><?php echo substr($data['NoIndex'],-10);?></td>
                    <td align="left" style="vertical-align: middle;">
                        <?php echo "<b>".$data['NamaPasien']."</b><br/>"?>
                        <?php echo $dtanamnesa['NamaPegawaiSimpan'];?>
                    </td>
                    <td align="center" style="vertical-align: middle;"><?php echo $data['TanggalRegistrasi'];?></td>
                    <td align="center" style="vertical-align: middle;">
                        <?php if($data['JamKembaliRM'] != ""){ ?>
                            <?php echo $data['JamKembaliRM'];?>
                        <?php }else{ ?>
                            <span class='badge badge-warning' style='font-style: italic; padding: 8px;'>Belum Diperiksa</span>
                        <?php } ?>
                    </td>
                    <td align="left" style="vertical-align: middle;"><?php echo str_replace('POLI','', $data['Asuransi']);?></td>                    
                    <td align="left" style="vertical-align: middle;"><?php echo str_replace('POLI','', $data['PoliPertama']);?></td>
                    <td align="left" style="vertical-align: middle;"><?php echo $dtanamnesa['Anamnesa'];?></td>
                    <td align="center" style="vertical-align: middle;">
                        <?php
                        if($data['JamKembaliRM'] != ""){
                            echo 
                            "Sistole/Diastole : ".$dtsistole."/".$dtdiastole."<br/>".
                            "BB/TB : ".$dtberatBadan."/".$dttinggiBadan."<br/>".
                            "Suhu : ".$dtsuhutubuh.", HR : ".$dtheartRate.", RR : ".$dtrespRate."</div>";
                        }
                        ?>	
                    </td>
                    <td align="center" style="vertical-align: middle;">
                        <?php
                            // tbdiagnosa
                            $tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
                            $qrdata_kd_diagnosa = mysqli_query($koneksi, "SELECT * FROM `$tbdiagnosapasien` WHERE `IdPasienrj` = '$idpasienrj' GROUP BY `KodeDiagnosa`");
                            while($data_diagnosapsn = mysqli_fetch_array($qrdata_kd_diagnosa)){
                                $data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
                                $array_diagnosa[$no][] = $data_diagnosa['Diagnosa'];
                                $array_kode_diagnosa[$no][] = $data_diagnosapsn['KodeDiagnosa'];
                            }
                            
                            if ($array_kode_diagnosa[$no] != ''){
                                $data_dgs = implode(", ", $array_kode_diagnosa[$no]);
                                echo $data_dgs;
                            }else{
                        ?>
                                <span class='badge badge-danger' style='padding: 4px;'><i class='icon-close fa-3x'></i></span>
                        <?php } ?>
                    </td>
                    <td align="center" style="vertical-align: middle;">
                        <?php
                            // therapy
                            $qrdata_therapy = mysqli_query($koneksi, "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$data[NoRegistrasi]' AND DATE(TanggalResep) IS NOT NULL GROUP BY NoResep, KodeBarang, Pelayanan");
                            while($data_therapy = mysqli_fetch_array($qrdata_therapy)){
                                $data_obat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbapotikstok` WHERE `KodeBarang` = '$data_therapy[KodeBarang]' GROUP BY KodeBarang"));
                                $array_obat[$no][] = $data_obat['NamaBarang'];
                            }
                            
                            if ($array_obat[$no] != ''){
                                $data_obt = implode(", ", $array_obat[$no]);
                                echo $data_obt;
                            }else{
                        ?>		
                                <span class='badge badge-danger' style='padding: 4px;'><i class='icon-close fa-3x'></i></span>
                        <?php } ?>	
                    </td>		
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table><hr/>
	</div>
</div>
<?php
}
?>