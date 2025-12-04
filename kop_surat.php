<table width="100%" style="border-bottom:2px solid #111;margin-bottom:10px; margin-top:0px;">
    <tr>
        <td width="5%">
            <img src="image/bandungkabnew.jpg" width="130px" style="margin-left:0px;"/>
        </td>
        <td width="90%" align="center">
            <h2 style="font-size:16px;margin:0px;margin-bottom:0px">PEMERINTAH <?php echo strtoupper($kota)?></h2>
            <h2 style="font-size:16px;margin:0px;margin-bottom:0px">DINAS KESEHATAN</h2>
            <h1 style="font-size:22px;margin:0px;margin-bottom:0px">UPTD PUSKESMAS <?php echo strtoupper($namapuskesmas)?></h1>
            <h1 style="font-size:16px;margin:0px;margin-bottom:0px">BADAN LAYANAN UMUM DAERAH</h1>
            <!-- <h1 style="font-size:18px;margin:0px;margin-bottom:2px">KLINIK PRATAMA UNPAD JATINANGOR</h1> -->
            <p style="font-size:12px;margin:0px;margin-bottom:0px"><?php echo $_SESSION['alamat'].", Telp.".$_SESSION['telepon'];?></p>
            <p style="font-size:12px;margin:0px;margin-bottom:0px"><?php echo "Email : ".$_SESSION['emailpuskesmas'];?></p>
        </td>
        <td width="5%">
            <img src="image/logo_puskesmas_noshadow.png" width="90px"/>
        </td>
    </tr>
</table>