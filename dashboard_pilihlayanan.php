<?php
session_start();
include "config/koneksi.php";
if(isset($_GET['kodelayanan'])){
    $_SESSION['layanan_dipilih'] = $_GET['kodelayanan'];
    $_SESSION['namalayanan_dipilih'] = $_GET['namalayanan'];
    
    echo "<script>";
    echo "document.location.href='index.php?page=dashboard';";
    echo "</script>";
}else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="puskesmas online, e-puskesmas, epuskesmas, aplikasi puskesmas, simpus, sip, sikda, puskesmas, kesehatan"/>
    <meta name="description" content="Puskesmas Online merupakan sebuah Aplikasi Manajemen Puskesmas, 
	aplikasi ini dikembangkan di kota Bandung sejak tahun 2011, fungsi dari Puskesmas Online salahsatunya sebagai media
	pengolahan data informasi yang ada di Puskesmas. Harapan kedepan dengan adanya aplikasi Puskesmas Online dapat membantu 
	memaksimalkan pelayanan kepada masyarakat dan mempermudah pekerjaan petugas yang ada di Puskesmas seluruh Indonesia">
    <meta name="author" content="Tommy Natalianto">
	<meta name="language"content="id"/>
    <link rel="icon" href="image/sehat.png" type="image/png" sizes="16x16">
    <title>Sehat</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap-dist/css/bootstrap.min.css" rel="stylesheet">

	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
		<link href="assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
</head>
<style>
    .container{
        padding-top:100px;
    }
    .textbawah{
        margin-top:140px;
    }
    .judullyn{
        margin-bottom:70px;
    }

    .kotak_panels{
		padding: 25px 20px;
		border-radius: 6px;
		margin-bottom: 15px;
	}
    .kotak_panels i{
        color:#fff;
    }
	.kotak_panels a{
        text-decoration:none
	}
	.greens{
		background: linear-gradient(0deg, rgba(21, 114, 232, 0.9), rgba(174, 228, 213, 0.9)), url('image/bgpanel.jpg');
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
		box-shadow: 0 5px 10px -3px #7f7f7f;
	}
    .greens:hover{
		background:rgb(32, 81, 181);
	}

    .displ{
        display:flex;
    }
    .fontpanel{
		font-size: 18px;
		font-weight: bold;
		margin: 0px 10px;
        color: #fff;
	}
</style>

 <body>
    <div class="container">
        <h2 class="text-center fw-bold judullyn">PILIH LAYANAN</h2>
        <div class="row">	
            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM `tbasalpasien` ORDER BY FIELD(AsalPasien, 'PUSKESMAS', 'PUSTU', 'PUSKEL', 'PERKESMAS', 'POSYANDU', 'POLINDES', 'POSBINDU', 'POSKESDES', 'STBM', 'KELAS IBU', 'KELAS BALITA', 'PENYULUHAN KLG', 'PENYULUHAN KLP')");
            while($data = mysqli_fetch_assoc($query)){			
            ?>
                <div class="col-sm-3">
            
                    <div class="kotak_panels greens">
                        <a href="?page=dashboard_pilihlayanan&kodelayanan=<?php echo $data['Id'];?>&namalayanan=<?php echo $data['AsalPasien'];?>">
                            <div class="displ">
                                <i class="fa fa-home fa-2x" ></i>
                                <div class="fontpanel"><?php echo $data['AsalPasien'];?></div>
                            </div>
                        </a>
                    </div>

                </div>
            <?php
            }
            ?>		
        </div>
   </div>
 </body>
</html>
<?php
}
?>