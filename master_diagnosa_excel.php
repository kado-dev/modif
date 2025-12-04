<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";	
	$hariini = date('d-m-Y');
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename= Master Diagnosa (".$namapuskesmas.").xls");
	if(isset($hariini)){
?>
<style>
.tr, th{
	text-align:center;
}
td {
	vertical-align: middle;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:14px;
	font-family: "Poppins", sans-serif;
}
.printheader p{
	font-size:14px;
	font-family: "Poppins", sans-serif;
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Poppins", sans-serif;
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
	font-family: "Poppins", sans-serif;
}
.font11{
	font-size:11px;
	font-family: "Poppins", sans-serif;
}
.font14{
	font-size:14px;
	font-family: "Poppins", sans-serif;
}
.str{
	mso-number-format:\@; 
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
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>MASTER DIAGNOSA </b></h4><br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
                <tr>
                    <th width="5%">No.</th>
                    <th width="15%">Kode Diagnosa</th>
                    <th width="80%">Diagnosa</th>
                </tr>
			</thead>
			<tbody font="8">
                <?php
                $query = mysqli_query($koneksi,"select * from `tbdiagnosa` order by `KodeDiagnosa`");
                $no = 0;
                while($data = mysqli_fetch_assoc($query)){
                $no = $no + 1;
                ?>
                    <tr>
                        <td align="center"><?php echo $no;?></td>
                        <td><?php echo $data['KodeDiagnosa'];?></td>
                        <td class="nama"><?php echo $data['NamaDiagnosa'];?></td>
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