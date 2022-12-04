<?php
$barang_pilih = 0;

if(isset($_COOKIE['keranjang'])){
    $barang_pilih = $_COOKIE['keranjang'];
}

if(isset($_GET['idbarang'])){
    $idbarang = $_GET['idbarang'];
    $barang_pilih = $barang_pilih.",".$idbarang;
    setcookie('keranjang',$barang_pilih,time()+3600);
}

include "koneksi.php";

$sql = "SELECT * FROM barang WHERE idbarang NOT IN (".$barang_pilih.") AND stok > 0 ORDER BY idbarang DESC";
$hasil = mysqli_query($kon,$sql);

if(!$hasil){
    die("Gagal query...".mysqli_error($kon));
}
?>
<h2>Daftar Barang Tersedia</h2>
<a href="keranjang_belanja.php">Keranjang Saya</a>
<br>
<table border="1">
    <tr>
        <th>No</th>
        <th>Foto</th>
        <th>Nama Barang</th>
        <th>Harga Jual</th>
        <th>Stok</th>
        <th>Operasi</th>
    </tr>
    <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($hasil)) : ?>
    <tr>
        <td><?= $no++; ?></td>
        <td> <a href="pict/<?=$row['foto'];?>"><img src="thumb/t_<?= $row['foto']; ?>" alt="<?= $row['nama']; ?>"
                    loading="lazy"></a></td>
        <td><?= $row['nama']; ?></td>
        <td><?= $row['harga']; ?></td>
        <td><?= $row['stok']; ?></td>
        <td>
            <a href="<?=$_SERVER['PHP_SELF'].'?idbarang='.$row['idbarang'];?>">BELI</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
