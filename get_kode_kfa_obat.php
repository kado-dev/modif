<?php
    session_start();
    include "config/helper_satusehat.php";
?>
<table class="table">
    <tr>
        <th>Kode KFA</th>
        <th width="50%">NAMA OBAT</th>
        <th width="15%">DOSIS KODE</th>
        <th width="15%">DOSIS NAME</th>
        <th width="8%">#</th>
    </tr>
<?php
    $key = $_POST['key'];

    $stsehat_access_token = $_SESSION['stsehat_access_token'];
    $dtobatkfa = get_obat_kfa($stsehat_access_token,$key);
    // echo $dtobatkfa;
    // die();
    $dtkfa = json_decode($dtobatkfa,true);
    $dtkfa_item = $dtkfa['items']['data'];
    if(count($dtkfa_item)){
        
        for($i = 0; $i < count($dtkfa_item); $i++){
            echo "<tr><td class='kodekfa'>".$dtkfa_item[$i]['kfa_code']."</td><td class='namekfa'>".$dtkfa_item[$i]['name']."</td><td class='dosiscodekfa'>".$dtkfa_item[$i]['dosage_form']['code']."</td><td class='dosisnamekfa'>".$dtkfa_item[$i]['dosage_form']['name']."</td><td><a href='#' class='btn btn-info btn-sm btnpilihkodekfa'>Pilih</a></td></tr>";
        }
    }else{
         echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
    }
?>
</table>