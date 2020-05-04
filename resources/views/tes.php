<table>

<?php
$total = 0;

// Start perulangan

while($db = mysqli()) {

    ########## inisialisasi variable ####################
    $nama       = $db['nama'];
    $kodevcd    = $db['kdvcd'];
    $jumlah     = $db['jumlah'];
    $tanggal    = $db['tanggal'];

    $no_urut = substr($kodevcd, 2, 3);

    ########## CEK HARGA SEWA ####################

    if (substr($kodevcd, 0, 2) == "HO") {

        $harga_sewa = 25000;
        $jenis = "Horror";

    } else if (substr($kodevcd, 0, 2) == "AC") {

        $harga_sewa = 25000;
        $jenis = "Action";

    } else {

        $harga_sewa = 25000;
        $jenis = "Drama";
    }

    ########## CEK TOTAL HARGA SEWA ####################
    $jumlah_bayar = $harga_sewa * $jumlah;
    $total += $jumlah_bayar;

?>
    <!-- Tampilkan row data disini -->
    <tr>
        <td>Nama</td>
        <td>Nama</td>
        <td>Nama</td>
        <td>Nama</td>
        <td>Nama</td>
    </tr>
    <!-- sampai sini -->
<?php 

} 
// Akhir perulangan

// HITUNG TOTAL && diskon

if ( $total > 300000 ) {
    $diskon = 2*100;
} else if ($total > 200000 ) {
    $diskon = 1*100;
} else {
    $diskon = 0;
}

$harga_diskon = $total * $diskon;
$grand_total = $total - $harga_diskon;

?>

<tr>
    <td>Total</td>
    <td>diskon</td>
    <td>grand total</td>
</tr>

</table>