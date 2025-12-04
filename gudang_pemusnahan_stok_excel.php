<?php
	include_once('config/koneksi.php');
	session_start();
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('Y-m-d');	
	$key = $_GET['key'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Stok Gudang Pemusnahan (".$kota." - ".$hariini.").xls");
	if(isset($key)){
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
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	margin-top:10px;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
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
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b>DINAS KESEHATAN</b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN STOK GUDANG PEMUSNAHAN</b></h4>
	<br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
        <thead>
            <tr>
                <th width="3%">NO.</th>
                <th width="10%">TGL PEMUSNAHAN</th>
                <th width="5%">KODE</th>
                <th width="30%">NAMA BARANG</th>
                <th width="10%">NAMA PROGRAM</th>
                <th width="5%">STATUS<br/gudang_pemusnahan_stok>KARANTINA</th>
                <th width="15%">NO.BATCH</th>
                <th width="10%">EXPIRE</th>
                <th width="10%">SUMBER</th>
                <th width="5%">TAHUN</th>
                <th width="10%">SK PEMUSNAHAN</th>
                <th width="10%">SK PENGHAPUSAN</th>
                <th width="10%">TEMPAT<br/>PEMUSNAHAN</th>
                <th width="7%">STOK</th>
            </tr>
        </thead>
        <tbody font="8">
            <?php
                $key = $_GET['key'];		
                $str = "SELECT * FROM `tbgfk_pemusnahandetail` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%')";
                $str2 = $str." ORDER BY NamaBarang ASC";
                // echo $str2;			
                $query = mysqli_query($koneksi, $str2);
                while($data = mysqli_fetch_assoc($query)){
                    $no = $no + 1;
                    $kodebarang = $data['KodeBarang'];
                    $nobatch = $data['NoBatch'];
                    $nofakturterima = $data['NoFakturTerima'];
                    $statusgudang = $data['StatusGudang'];

                    // tbgfkstok
                    $dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'"));
            ?>
            <tr style="background:<?php echo $warna;?>;">
                <td align="right"><?php echo $no;?></td>
                <td align="center"><?php echo $data['TanggalPemusnahan'];?></td>
                <td align="center"><?php echo $data['KodeBarang'];?></td>
                <td align="left" class="nama"><?php echo "<b>".strtoupper($data['NamaBarang']);?> </td>
                <td align="left"><?php echo $dtgfkstok['NamaProgram'];?></td>
                <td align="left"><?php echo $data['StatusKarantina'];?></td>
                <td align="left"><?php echo $data['NoBatch'];?></td>
                <td align="center"><?php echo date('d-m-Y',strtotime($data['Expire']));?></td>
                <td align="center"><?php echo $dtgfkstok['SumberAnggaran'];?></td>
                <td align="center"><?php echo $dtgfkstok['TahunAnggaran'];?></td>
                <td align="center"><?php echo $data['SkPemusnahan'];?></td>
                <td align="center"><?php echo $data['SkPenghapusan'];?></td>
                <td align="center"><?php echo $data['TempatPemusnahan'];?></td>
                <td align="right" style="color:red;font-weight:bold"><?php echo $data['Jumlah'];?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
		</table>
	</div>
</div>
<?php
}
?>