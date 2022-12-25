<?php
if (!session_id()) session_start();
if (!isset($_SESSION['user'])) {
    header("Location:login_form.php");
}
include "koneksi.php";
include 'template_atas.php';

$buku_pilih = 0;

if (isset($_COOKIE['pinjaman'])) {
    $buku_pilih = $_COOKIE['pinjaman'];
}

if (isset($_GET['idbuku'])) {
    $idbuku = $_GET['idbuku'];
    $buku_pilih = str_replace(("," . $idbuku), "", $buku_pilih);
    setcookie('pinjaman', $buku_pilih, time() + 3600);
}

$sql = "SELECT * FROM buku WHERE idbuku IN (" . $buku_pilih . ") ORDER BY idbuku DESC";

$hasil = mysqli_query($kon, $sql) or die("Gagal Query");
?>
<h2>DATA PEMINJAMAN BUKU</h2>

<form action="simpan_keranjang.php" method="post">
    <table>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td><input type="date" name="tanggal" id="tanggal"></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><input type="text" name="nama" id="nama"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td><input type="email" name="email" id="email"></td>
        </tr>
        <tr>
            <td>No.Telp</td>
            <td>:</td>
            <td><input type="number" name="notelp" id="notelp"></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td><button type="submit">Simpan</button></td>
        </tr>
    </table>
</form>
<h2>Keranjang Buku</h2>
<a href="buku_tersedia.php">BUKU
    TERSEDIA</a> <a href="buku_pinjam.php">SIMPAN KERANJANG</a>
<br><br>
<table>
    <thead>
        <tr>
            <th>Foto</th>
            <th>Judul Buku</th>
            <th>Pengarang</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($hasil) > 0) :
            foreach ($hasil as $dt) : ?>

                <tr>
                    <td><a href="pict/<?= $dt['foto']; ?>"><img src="thumb/<?= $dt['foto']; ?>" alt="<?= $dt['judul']; ?>" width="80" height="100"></a></td>
                    <td><?= $dt['judul']; ?></td>
                    <td><?= $dt['pengarang']; ?></td>
                    <td> <a href="<?= $_SERVER['PHP_SELF'] . '?idbuku=' . $dt['idbuku'] ?>">Batal</a> </td>
                </tr>

        <?php
            endforeach;
        endif; ?>
    </tbody>
</table>
<?php
include 'template_bawah.php';
?>
